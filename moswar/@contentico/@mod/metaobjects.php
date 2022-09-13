<?php
/**
 * Управление объектами
 *
 */
class Metaobjects extends ContenticoModule implements IModule
{
    private $metaObjectId;
    private $metaObjectCode;
    private $metaViewId; // $_SESSION['@contentico']['metaobjects']['<metaobject-code>']['metaview'] = *
    private $metaViewType = META_VIEW_TYPE_LIST;
    private $parents = array();
    private $offset = 0;
    private $listPage = 1;
    private $sortBy; // $_SESSION['@contentico']['metaobjects']['<metaobject-code>']['sortby'] = *
    private $sortOrder; // $_SESSION['@contentico']['metaobjects']['<metaobject-code>']['sortorder'] = *
    private $filters; //$_SESSION['@contentico']['metaobjects']['<metaobject-code>']['filters']['<metaattribute-code>'] = *
    private $rowsPerPage = 15;
    private $widgetRowsPerPage = 3;
    private $params; //$_SESSION['@contentico']['metaobjects']['<metaobject-code>']['parent']['<metaattribute-code>'] = array(*)
    public $returnToPage;
    public $returnToView;
    private $formApply = false;
    private $formCopy = false;
    private $cannot_insert = false;//если во время копирования из формы произошла какая то ошибка
    private $extention = false;
    public $customUrlParams = array();
    
    protected $metaObjectRights;
    
    public $objectId = 0;
    public $parent = false;

    const ACTION_UI_SELECTSEARCH = 201;
    const ROWS_PER_PAGE = 20;
    const WIDGET_ROWS_PER_PAGE = 3;
    const QUICKLIST_ROWS_PER_PAGE = 5;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Обработка запроса
     *
     */
    public function processRequest()
    {
        parent::onBeforeProcessRequest();

        $this->processUrl();		
        if (!$this->metaObjectId)
        {
            header('Location: /@contentico/Index/');
            exit;
        }
        $this->metaObjectRights = $this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE sysuser_id=".Runtime::$gid."
            AND metaobject_id={$this->metaObjectId} AND metaview_id=0");
        if (!$this->metaObjectRights)
        {
            header('Location: /@contentico/Auth/accessdenied/');
            exit;
        }
        $this->page['left-menu-metaobject-'.$this->metaObjectCode] = 'class="cur"';
        $this->initParams();
        $this->initFilters();
        $this->initExtention();
        //
		if ($this->parent)
        {			
            foreach ($this->parent as $parent)
            {
                if ($parent['id'] > 0)
                {
                    $metaObject = $this->sqlGetRecord("
                        SELECT sp.name, ma.code metaattribute
                        FROM sysparams sp
                            LEFT JOIN metaobject mo ON mo.id=sp.metaobject_id
                            LEFT JOIN metaattribute ma ON ma.id=sp.export_metaattribute_id
                        WHERE mo.code='{$parent['metaobject']}'");
                    $this->path[$metaObject['name']] = 'Metaobjects/'.$parent['metaobject'];
                    $name = $this->sqlGetValue("SELECT `{$metaObject['metaattribute']}` FROM `{$parent['metaobject']}` WHERE id=".$parent['id']);
                    $this->path[$name] = 'Metaobjects/'.$parent['metaobject'].'/action='.ACTION_VIEW.'/id='.$parent['id'];
                }
            }
        }
        //
        switch ($this->action)
        {
            case ACTION_LIST:
				$this->generateList();
                $this->page['page-name'] = $this->params['name'];
                break;
            case ACTION_VIEW:
				$this->page['page-name'] = $this->params['string_view'];
                $this->path[$this->params['name']] = 'Metaobjects/'.$this->metaObjectCode;				
                $this->generateCard();
                break;
            case ACTION_CREATE:
            case ACTION_EDIT:
				if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $this->saveObject();
                }
                $this->page['page-name'] = $this->action == ACTION_CREATE ? 'Добавить' : 'Редактировать';
                $this->path[$this->params['name']] = 'Metaobjects/'.$this->metaObjectCode;
                $this->generateForm();
                break;
            case ACTION_COPY:
                $this->copyObject();
                break;
            case ACTION_DELETE:
                $this->deleteObject();
                break;
            case ACTION_CANNOT_INSERT:
                $this->cannot_insert = true;
                $this->generateForm();
            case ACTION_CUSTOM:
                $this->extention->processAction($this);
                break;
            case self::ACTION_UI_SELECTSEARCH:
                $this->uiSelectSearch();
                break;
            case ACTION_EXPORT:
                $this->exportToXml();
                break;
            case ACTION_IMPORT:
                //вообще можно это удалить
                $this->importFromXml();
                break;
        }
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Инициализация параметров для генерации виджета
     *
     * @param int $metaObjectId
     * @param int $metaViewId
     */
    public function initForWidget($metaObjectId, $metaViewId)
    {
        $this->metaObjectId = $metaObjectId;
        $this->metaObjectCode = $this->sqlGetValue("SELECT code FROM metaobject WHERE id=".$this->metaObjectId);
        $this->metaViewId = $metaViewId;
        $this->initParams();
    }

    /**
     * Инициализация параметров
     *
     */
    private function initParams()
    {
        $this->params = $this->sqlGetRecord("SELECT * FROM sysparams WHERE metaobject_id={$this->metaObjectId}");
        $this->sortBy = isset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['sortby']) ? $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['sortby'] : $this->params['sortby'];
        $this->sortOrder = isset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['sortorder']) ? $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['sortorder'] :  $this->params['sortorder'];
        $this->metaViewId = $this->metaViewId ? $this->metaViewId : $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['metaview'][$this->metaViewType];
        $this->parent = $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['parent'];
    }

    /**
     * Инициализация фильтров
     *
     */
    private function initFilters()
    {
        if (is_array($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters']) && sizeof($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters']) > 0)
        {
            foreach ($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'] as $metaAttributeCode=>$value)
            {
                if ($value != '')
                {
                    $this->filters[$metaAttributeCode] = $value;
                }
            }
        }
        else
        {
            $this->filters = false;
        }
    }

    /**
     * Инициализация и загрузка класса расширения объекта
     *
     */
    private function initExtention()
    {
        if (Std::loadMetaObjectExtention($this->metaObjectCode))
        {
            $className = $this->metaObjectCode.'Extention';
            $this->extention = new $className();
        }
    }

    /**
     * Обработка адреса запроса
     *
     */
    private function processUrl()
    {
        $this->metaObjectCode = preg_replace('/[^\w]/', '', $this->url[0]);
        $this->metaObjectId = $this->sqlGetValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
        $actionProcessed = false;
        for ($i = 1; $i < sizeof($this->url); $i++)
        {
            $urlPart = explode('=', $this->url[$i]);
            switch ($urlPart[0]) {
            	case 'view':
            	case 'metaview':
            	    if (!is_array($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['metaview']))
            	    {
            	        $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['metaview'] = array();
            	    }
            		$this->metaViewId = $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['metaview'][$this->metaViewType] = (int) $urlPart[1];
            		break;
            	case 'action':
            		$actionProcessed = true;
            	    $this->action = (int) $urlPart[1];
            	    switch ($this->action)
            	    {
            	        case ACTION_LIST:
            	            $this->metaViewType = META_VIEW_TYPE_LIST;
            	            break;
        	            case ACTION_VIEW:
            	            $this->metaViewType = META_VIEW_TYPE_CARD;
            	            break;
            	        case ACTION_CREATE:
            	        case ACTION_EDIT:
            	            $this->metaViewType = META_VIEW_TYPE_FORM;
            	            break;
            	    }
            	    break;
                case "action-param":
                    $this->actionParam = $urlPart[1];
                    break;
            	case 'page':
            	    $this->offset = (int) $urlPart[1] < 2 ? 0 : (((int) $urlPart[1]) - 1) * $this->rowsPerPage;
            	    $this->listPage = $this->offset / $this->rowsPerPage + 1;
            	    break;
            	case 'id':
            	    $this->objectId = (int) $urlPart[1];
            	    break;
        	    case 'parent':
        	        if (!is_array($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['parent']))
        	        {
        	            $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['parent'] = array();
        	        }
        	        $parent = explode('-', $urlPart[1]);
            	    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['parent'][Std::cleanString($parent[2])] = array(
            	       'metaobject' => Std::cleanString($parent[0]),
            	       'id' => (int) $parent[1],
            	       'metaattribute' => Std::cleanString($parent[2]),
                    );
            	    break;
            	case 'sortby':
            	    $this->sortBy = $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['sortby'] = preg_replace('/[^\w]/', '', $urlPart[1]);
            	    break;
            	case 'sortorder':
            	    $this->sortOrder = $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['sortorder'] = preg_replace('/[^\w]/', '', $urlPart[1]);
            	    break;
            	case 'apply':
            	    $this->formApply = true;
            	    break;
                case 'copy':
                    $this->formCopy = true;
                    break;
            	case 'filter':
            	    $this->applyFilter();
            	    true;
            	case '-page':
            	    $this->returnToPage = (int) $urlPart[1];
            	    break;
            	case '-view':
            	    $this->returnToView = (int) $urlPart[1];
            	    break;
            	case 'ajax':
            	    $this->ajaxRequest = true;
            	    break;
        	    default:
        	        $this->customUrlParams[$urlPart[0]] = $urlPart[1];
        	        break;
            }
        }
        if (!$actionProcessed)
        {
        	if ($this->sqlGetValue("SELECT count(*) FROM metaview WHERE type=".META_VIEW_TYPE_LIST." AND metaobject_id=".$this->metaObjectId) == 0)
        	{
        		$this->action = ACTION_FORM;
        		$this->objectId = $this->sqlGetValue("SELECT id FROM `{$this->metaObjectCode}`");
        	}
        }
    }

    /**
     * Применение (запоминание) фильтра
     *
     */
    private function applyFilter()
    {
        if (!is_array($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters']))
        {
            $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'] = array();
        }
        $metaViewId = $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['metaview'];
        $attribute = $this->sqlGetRecord("SELECT id, code, type, typeparam FROM metaattribute WHERE id=".(int)$_POST['metaattribute_id']);
        switch ($attribute['type'])
        {
            case META_ATTRIBUTE_TYPE_INT:
            case META_ATTRIBUTE_TYPE_FLOAT:
                unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']]);
                if ($_POST[$attribute['code'].'-from'] == '')
                {
                    unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-from']);
                }
                else
                {
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-from'] = Std::cleanString($_POST[$attribute['code'].'-from']);
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']] = 1;
                }
                if ($_POST[$attribute['code'].'-till'] == '')
                {
                    unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-till']);
                }
                else
                {
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-till'] = Std::cleanString($_POST[$attribute['code'].'-till']);
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']] = 1;
                }
                break;
            case META_ATTRIBUTE_TYPE_STRING:
            case META_ATTRIBUTE_TYPE_TEXT:
            case META_ATTRIBUTE_TYPE_BIGTEXT:
            case META_ATTRIBUTE_TYPE_DICTIONARY:
            case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                if ($_POST[$attribute['code']] == '')
                {
                    unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']]);
                }
                else
                {
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']] = Std::cleanString($_POST[$attribute['code']]);
                }
                break;
            case META_ATTRIBUTE_TYPE_DATETIME:
            case META_ATTRIBUTE_TYPE_DATE:
                unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']]);
                if ($_POST[$attribute['code'].'-from'] == '')
                {
                    unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-from']);
                }
                else
                {
                    $dt = explode(' ', Std::cleanString($_POST[$attribute['code'].'-from']));
                    $d = explode('.', $dt[0]);
                    if ($attribute['type'] == META_ATTRIBUTE_TYPE_DATETIME)
                    {
                        $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                    }
                    else
                    {
                        $t = '00:00:00';
                    }
                    $dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-from'] = $dt;
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']] = 1;
                }
                if ($_POST[$attribute['code'].'-till'] == '')
                {
                    unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-till']);
                }
                else
                {
                    $dt = explode(' ', Std::cleanString($_POST[$attribute['code'].'-till']));
                    $d = explode('.', $dt[0]);
                    if ($attribute['type'] == META_ATTRIBUTE_TYPE_DATETIME)
                    {
                        $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                    }
                    else
                    {
                        $t = '00:00:00';
                    }
                    $dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-till'] = $dt;
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']] = 1;
                }
                break;
            case META_ATTRIBUTE_TYPE_BOOL:
            case META_ATTRIBUTE_TYPE_FILE:
            case META_ATTRIBUTE_TYPE_IMAGE:
                unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']]);
                if (isset($_POST[$attribute['code'].'-yes']))
                {
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-yes'] = 1;
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']] = 1;
                }
                else
                {
                    unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-yes']);
                }
                if (isset($_POST[$attribute['code'].'-no']))
                {
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-no'] = 1;
                    $_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code']] = 1;
                }
                else
                {
                    unset($_SESSION['@contentico']['metaobjects'][$this->metaObjectCode]['filters'][$attribute['code'].'-no']);
                }
                break;
            case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
            case META_ATTRIBUTE_TYPE_DATA:
            case META_ATTRIBUTE_TYPE_CUSTOM:
            case META_ATTRIBUTE_TYPE_PASSWORD:
                $filter = '';
                break;
        }
        header('Location: /@contentico/Metaobjects/'.$this->metaObjectCode.'/');
        exit;
    }

    /**
     * Генерация списка
     *
     */
    private function generateList()
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_READ)
        {
            $list = new ContenticoViewList();
            $list->metaObjectId = $this->metaObjectId;
            $list->metaObjectCode = $this->metaObjectCode;
            $list->metaObjectRights = $this->metaObjectRights;
            $list->metaViewId = $this->metaViewId;
            $list->action = $this->action;
            $list->parent = $this->parent;
            $list->params = $this->params;
            $list->sortBy = $this->sortBy;
            $list->sortOrder = $this->sortOrder;
            $list->offset = $this->offset;
            $list->rowsPerPage = $this->rowsPerPage;
            $list->filters = $this->filters;
            $list->listPage = $this->listPage;
            $list->metaObjectRights = $this->metaObjectRights;
            if ($this->extention && $this->extention->extendsActions)
            {
                $this->extention->extendActions($list->actions);
            }
            $list->preGenerate();
            if ($this->extention && $this->extention->extendsList)
            {
                $this->extention->extendList($list, 1);
            }
            $list->generate();
            if ($this->extention && $this->extention->extendsList)
            {
                $this->extention->extendList($list, 2);
            }
            $Content = $list->getHtml();
            if (is_array($Content))
            {
                $this->page['content'] = $Content[0];
                $this->page['tree'] = $Content[1];
            }
            else
            {
                $this->page['content'] = $Content;
            }
            $this->page['page-name'] = $this->params['name'];
            //
            $quickForm = $this->sqlGetRecord("
                SELECT mv.id, mv.metaobject_id, ssmo.rights
                FROM metaview mv
                    LEFT JOIN metaobject mo ON mo.id=mv.metaobject_id
                    LEFT JOIN sysparams sp ON sp.metaobject_id=mo.id
                    LEFT JOIN syssecurity ssmv ON ssmv.metaview_id=mv.id AND ssmv.sysuser_id=".Runtime::$gid."
                    LEFT JOIN syssecurity ssmo ON ssmo.metaobject_id=mo.id AND ssmo.metaview_id=0 AND ssmo.sysuser_id=".Runtime::$gid."
                WHERE mv.type=".META_VIEW_TYPE_QUICKFORM." AND ssmv.rights>0 AND ssmo.rights>0 AND mo.id={$this->metaObjectId} LIMIT 0,1");
            if ($quickForm && $quickForm['rights'] & SECURITY_RIGHT_WRITE)
            {
                Contentico::loadModule('Metaobjects');
                $metaobjectsModule = new Metaobjects();
                $metaobjectsModule->InitForWidget($quickForm['metaobject_id'], $quickForm['id']);
                $metaobjectsModule->parent = $this->parent;
                $metaobjectsModule->returnToPage = $this->listPage;
                $metaobjectsModule->returnToView = $this->metaViewId;
                $this->page['content'] .= $metaobjectsModule->generateQuickForm();
            }
        }
        else
        {
            header('Location: /@contentico/Auth/accessdenied/');
            exit;
        }
    }

    /**
     * Генерация "быстрого" списка
     *
     */
    private function generateQuickList()
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_READ)
        {
            $list = new ContenticoViewQuickList();
            $list->metaObjectId = $this->metaObjectId;
            $list->metaObjectCode = $this->metaObjectCode;
            $list->metaObjectRights = $this->metaObjectRights;
            $list->metaViewId = $this->metaViewId;
            $list->action = $this->action;
            $list->parent = $this->parent;
            $list->params = $this->params;
            $list->rowsPerPage = self::QUICKLIST_ROWS_PER_PAGE;
            $list->metaObjectRights = $this->metaObjectRights;
            $list->preGenerate();
            if ($this->extention && $this->extention->extendsList)
            {
                $this->extention->extendList($list, 1);
            }
            $list->generate();
            if ($this->extention && $this->extention->extendsList)
            {
                $this->extention->extendList($list, 2);
            }
            return $list->getHtml();
        }
        else
        {
            return '';
        }
    }

    /**
     * Генерация виджета
     *
     * @return string
     */
    public function generateListWidget()
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_READ)
        {
            $listWidget = new ContenticoViewWidget();
            $listWidget->metaObjectId = $this->metaObjectId;
            $listWidget->metaObjectCode = $this->metaObjectCode;
            $listWidget->metaObjectRights = $this->metaObjectRights;
            $listWidget->metaViewId = $this->metaViewId;
            $listWidget->action = $this->action;
            $listWidget->parent = $this->parent;
            $listWidget->params = $this->params;
            $listWidget->rowsPerPage = $this->widgetRowsPerPage;
            $listWidget->metaObjectRights = $this->metaObjectRights;
            $listWidget->preGenerate();
            if ($this->extention && $this->extention->extendsWidget)
            {
                $this->extention->extendWidget($listWidget, 1);
            }
            $listWidget->generate();
            if ($this->extention && $this->extention->extendsWidget)
            {
                $this->extention->extendWidget($listWidget, 2);
            }
            return $listWidget->getHtml();
        }
        else
        {
            header('Location: /@contentico/Auth/accessdenied/');
            exit;
        }
    }

    /**
     * Генерация формы
     *
     */
    private function generateForm()
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_WRITE)
        {
            $form = new ContenticoViewForm();
            $form->metaObjectId = $this->metaObjectId;
            $form->metaObjectCode = $this->metaObjectCode;
            $form->metaObjectRights = $this->metaObjectRights;
            $form->metaViewId = $this->metaViewId;
            $form->cannot_insert = $this->cannot_insert;
            $form->action = $this->action;			
            $form->objectId = $this->objectId;
            $form->returnToPage = $this->returnToPage;
            $form->returnToView = $this->returnToView;
            $form->params = $this->params;
            $form->parent = $this->parent;			
            $form->generate();			
            if ($this->extention && $this->extention->extendsForm)
            {
                $this->extention->extendForm($form);
            }
            $this->page['content'] = $form->getHtml();
            if ($form->pageTitle != '')
            {
                $this->page['page-name'] = $form->pageTitle;
            }
        }
        else
        {
            header('Location: /@contentico/Auth/accessdenied/');
            exit;
        }
    }

    /**
     * Генерация мини-формы
     *
     */
    private function generateQuickForm($ReturnUrl='')
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_WRITE)
        {
            $form = new ContenticoViewQuickForm();
            $form->metaObjectId = $this->metaObjectId;
            $form->metaObjectCode = $this->metaObjectCode;
            $form->metaObjectRights = $this->metaObjectRights;
            $form->metaViewId = $this->metaViewId;
            $form->action = ACTION_CREATE;
            $form->objectId = 0;
            $form->returnToPage = $this->returnToPage;
            $form->returnToView = $this->returnToView;
            $form->params = $this->params;
            $form->parent = $this->parent;
            $form->returnUrl = $returnUrl;
            $form->generate();
            if ($this->extention && $this->extention->extendsForm)
            {
                $this->extention->extendForm($form);
            }
            return $form->getHtml();
        }
    }

    /**
     * Генерация карточки
     *
     */
    private function generateCard()
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_READ)
        {
            $card = new ContenticoViewCard();
            $card->metaObjectId = $this->metaObjectId;
            $card->metaObjectCode = $this->metaObjectCode;
            $card->metaObjectRights = $this->metaObjectRights;
            $card->metaViewId = $this->metaViewId;
            $card->objectId = $this->objectId;
            $card->returnToPage = $this->returnToPage;
            $card->returnToView = $this->returnToView;
            $card->params = $this->params;
            $card->parent = $this->parent;
            $card->action = $this->action;
            $card->generate();
			
            if ($this->extention && $this->extention->extendsCard)
            {
                $this->extention->extendCard($card);
            }
            $this->page['content'] = $card->getHtml();			
            if ($card->pageTitle != '')
            {
                $this->page['page-name'] = $card->pageTitle;
            }
            //
            $childViews = $this->sqlGetRecordSet("
                SELECT mv.id, mv.metaobject_id, ma.code metaattribute, ssmo.rights
                FROM metaview mv
                    LEFT JOIN metaobject mo ON mo.id=mv.metaobject_id
                    LEFT JOIN sysparams sp ON sp.metaobject_id=mo.id
                    LEFT JOIN syssecurity ssmv ON ssmv.metaview_id=mv.id AND ssmv.sysuser_id=".Runtime::$gid."
                    LEFT JOIN syssecurity ssmo ON ssmo.metaobject_id=mo.id AND ssmo.metaview_id=0 AND ssmo.sysuser_id=".Runtime::$gid."
                    LEFT JOIN metaattribute ma ON ma.metaobject_id=mo.id AND ma.type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT." AND ma.typeparam='{$this->metaObjectCode}'
                WHERE mv.type=".META_VIEW_TYPE_QUICKLIST." AND ssmv.rights>0 AND ssmo.rights>0 AND ma.code!=''
                GROUP BY mv.metaobject_id
                ORDER BY sp.menupos ASC");
            $childrenHtml = '';
            if ($childViews)
            {
                Contentico::loadModule('Metaobjects');
                foreach ($childViews as $view)
                {
                    $metaobjectsModule = new Metaobjects();
                    $metaobjectsModule->initForWidget($view['metaobject_id'], $view['id']);
                    $metaobjectsModule->parent = array(
                        'metaobject'=>$this->metaObjectCode,
                        'id'=>$this->objectId,
                        'metaattribute'=>$view['metaattribute'],
                    );
                    $childrenHtml .= $metaobjectsModule->generateQuickList();
                }
                $this->page['content'] .= $childrenHtml;
            }
            //
            $quickForm = $this->sqlGetRecord("
                SELECT mv.id, mv.metaobject_id, ssmo.rights, ma.code metaattribute
                FROM metaview mv
                    LEFT JOIN metaobject mo ON mo.id=mv.metaobject_id
                    LEFT JOIN sysparams sp ON sp.metaobject_id=mo.id
                    LEFT JOIN syssecurity ssmv ON ssmv.metaview_id=mv.id AND ssmv.sysuser_id=".Runtime::$gid."
                    LEFT JOIN syssecurity ssmo ON ssmo.metaobject_id=mo.id AND ssmo.metaview_id=0 AND ssmo.sysuser_id=".Runtime::$gid."
                    LEFT JOIN metaattribute ma ON ma.metaobject_id=mo.id AND ma.type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT." AND ma.typeparam='{$this->metaObjectCode}'
                WHERE mv.type=".META_VIEW_TYPE_QUICKFORM." AND ssmv.rights>0 AND ssmo.rights>0
                    AND (SELECT count(*) FROM metarelation WHERE `from`={$this->metaObjectId} AND `to`=mo.id AND type=".META_RELATION_PARENT.")>0
                LIMIT 0,1");
            if ($quickForm && $quickForm['rights'] & SECURITY_RIGHT_WRITE)
            {
                Contentico::loadModule('Metaobjects');
                $metaobjectsModule = new Metaobjects();
                $metaobjectsModule->initForWidget($quickForm['metaobject_id'], $quickForm['id']);
                $metaobjectsModule->parent = array('metaattribute'=>$quickForm['metaattribute'], 'id'=>$this->objectId);
                $metaobjectsModule->returnToPage = $this->listPage;
                $metaobjectsModule->returnToView = $this->metaViewId;
                $this->page['content'] .= $metaobjectsModule->generateQuickForm('/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.$this->action.'/id='.$this->objectId.'/metaview='.$this->metaViewId.'/-page='.$this->returnToPage.'/view='.$this->returnToView.'/');
            }
        }
        else
        {
            header('Location: /@contentico/Auth/accessdenied/');
            exit;
        }
    }

    /**
     * Создание и сохранение объектов
     *
     */
    private function saveObject()
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_WRITE)
        {
            Std::loadMetaObjectClass($this->metaObjectCode);
            $objectClass = $this->metaObjectCode.'Object';
            $object = new $objectClass();
            $object->metaViewId = $this->metaViewId;
            
                if ($this->formCopy)
                {
                    $object->initFromForm();
                }
                else
                {
                    $object->initFromForm($this->objectId);
                }
            $object->save();

            if ($this->formCopy)
            {
                if ($object->id)
                {
                    //всё хорошо
                    if (isset($_POST['returnurl']))
                    {
                        header('Location: '.$_POST['returnurl']);
                    }
                    else
                    {
                        header('Location: /@contentico/Metaobjects/'.$this->metaObjectCode.'/page='.$this->returnToPage.'/view='.$this->returnToView.'/');
                    }

                }
                else
                {
                    
                    $this->CannotInput();
                }
            }
            else
            {
                $this->objectId = $object->id;
            }

        }
        if ($this->formApply)
        {
            header('Location: /@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_EDIT.'/id='.$this->objectId.'/-page='.$this->returnToPage.'/-view='.$this->returnToView.'/');
        }
        else
        {
            if (isset($_POST['returnurl']))
            {
                header('Location: '.$_POST['returnurl']);
            }
            else
            {
                header('Location: /@contentico/Metaobjects/'.$this->metaObjectCode.'/page='.$this->returnToPage.'/view='.$this->returnToView.'/');
            }
        }
        exit;
    }

    /**
     *  Копирование из формы
     *
     *
     *
     */
    private function CannotInput()
    {
        //получаем метаатрибуты
        $metaatributes = $this->sqlGetValueSet("SELECT code FROM metaattribute WHERE metaobject_id ={$this->metaObjectId}");
        $ma = array();
        //метаатрибуты кроме id
        foreach ($metaatributes as $code){
            if ($code == 'id')
            {
                continue;
            }
            $ma[$code] = $_POST[$code];
        }

        $_SESSION['@contentico']['cannotinsert'] = $ma;
        header('Location: /@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_CANNOT_INSERT.'/id='.$this->objectId.'/-page='.$this->returnToPage.'/-view='.$this->returnToView.'/');
        exit;
    }

    /**
     *  Копирование объекта
     *
     *
     */
    private function copyObject()
    {
    $metaatributes = $this->sqlGetValueSet("SELECT code FROM metaattribute WHERE metaobject_id ={$this->metaObjectId}");
    $ma = array();
        foreach ($metaatributes as $metaatribute){
            if ($metaatribute == 'id')
            {
                continue;
            }
            $ma[] = $metaatribute;
        }

        $attr = implode(', ',$ma);
        $this->sqlInsert("INSERT INTO {$this->metaObjectCode} ({$attr}) SELECT $attr FROM {$this->metaObjectCode} WHERE id={$this->objectId}");
        header('Location: /@contentico/Metaobjects/'.$this->metaObjectCode.'/page='.$this->returnToPage.'/view='.$this->returnToView.'/');
    }

    /**
     * Удаление объектов
     *
     */
    private function deleteObject()
    {
        if ($this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=0 AND sysuser_id=".Runtime::$gid) & SECURITY_RIGHT_DELETE)
        {
            Std::loadMetaObjectClass($this->metaObjectCode);
            $objectClass = $this->metaObjectCode.'Object';
            $object = new $objectClass();
            $object->delete($this->objectId);
        }
        if (!$this->ajaxRequest)
        {
            header('Location: /@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_LIST.'/page='.$this->returnToPage.'/metaview='.$this->returnToView.'/');
        }
        exit;
    }

    /**
     * Ajax
     * Поиск значения для select'а
     *
     */
    private function uiSelectSearch()
    {
        $metaAttribute = Std::cleanString($this->customUrlParams['metaattribute']);
        $id = $this->objectId;
        $name = Std::cleanString($this->customUrlParams['name']);
        $item = $this->sqlGetRecord("SELECT id, `$metaAttribute` name FROM `{$this->metaObjectCode}` WHERE id=$id");
        $error = 0;
        if ($item)
        {
            $item = ',{"id":"'.$item['id'].'","name":"'.$item['name'].'"}';
            $status = 1;
        }
        else
        {
            $item = $this->sqlGetRecord("SELECT id, `$metaAttribute` name FROM `{$this->metaObjectCode}` WHERE `$metaAttribute`='$name'");
            if ($item)
            {
                $item = ',{"id":"'.$item['id'].'","name":"'.$item['name'].'"}';
            }
            else
            {
                if (strlen($name) > 2)
                {
                    $count = $this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}` WHERE `$metaAttribute` LIKE '%$name%'");
                    if ($count <= 10)
                    {
                        $item = $this->sqlGetRecordSet("SELECT id, `$metaAttribute` name FROM `{$this->metaObjectCode}` WHERE `$metaAttribute` LIKE '%$name%'");
                        if ($item)
                        {
                            foreach ($item as $i)
                            {
                                $items[] = '{"id":"'.$i['id'].'","name":"'.$i['name'].'"}';
                            }
                            $item = ','.implode(',', $items);
                        }
                        else
                        {
                            $item = '';
                            $error = 1;
                        }
                    }
                    else
                    {
                        $item = '';
                        $error = 3;
                    }
                }
                else
                {
                    $item = '';
                    $error = 2;
                }
            }
        }
        echo '[{"status":'.($item ? 1 : 0).',"error":'.$error.'}'.$item.']';
        exit;
    }

    private function exportToXml()
    {
        $params = explode("|", $this->actionParam);
        $exportType = $params[0];
        switch ($exportType) {
            case 1: // все
                $objects = $this->sqlGetRecordSet("SELECT * FROM `" . $this->metaObjectCode . "`");
                break;

            case 2: // отмеченные
                $id = explode(",", trim($params[1], ","));
                $objects = $this->sqlGetRecordSet("SELECT * FROM `" . $this->metaObjectCode . "` WHERE id IN (" . implode(",", $id) . ")");
                break;

            case 3: // отфильтрованные
                $objects = $this->sqlGetRecordSet("SELECT * FROM `" . $this->metaObjectCode . "`" . $this->generateFiltersForExport());
                break;
        }

        $xml = '<?xml version="1.0" encoding="utf-8"?>
<contentico>
    <metaobject code="' . $this->metaObjectCode . '">
';
                if ($objects) {
                    $metaAttributes = $this->sqlGetRecordSet("SELECT code, type FROM metaattribute WHERE metaobject_id = " . $this->metaObjectId);
                    $strings = array();
                    foreach ($metaAttributes as $metaAttribute) {
                        if (in_array($metaAttribute["type"], array(META_ATTRIBUTE_TYPE_STRING, META_ATTRIBUTE_TYPE_TEXT,
                            META_ATTRIBUTE_TYPE_BIGTEXT, META_ATTRIBUTE_TYPE_DATA, META_ATTRIBUTE_TYPE_CUSTOM))) {
                            $strings[] = $metaAttribute["code"];
                        }
                    }
                    
                    foreach ($objects as $i => $object) {
                        $stringParams = "";
                        $nonStringParams = array();
                        foreach ($object as $code => $value) {
                            if (in_array($code, $strings)) {
                                $stringParams .= '          <' . $code . '><![CDATA[' . trim($value) . ']]></' . $code . '>
';
                            } else {
                                $nonStringParams[] = $code . '="' . $value . '"';
                            }
                        }
                        $xml .= '       <object' . (sizeof($nonStringParams) > 0 ? " " . implode(" ", $nonStringParams) : "") . '>
' . $stringParams . '       </object>
';
                    }
                }
                $xml .= '   </metaobject>
</contentico>';

        header('Content-Disposition: attachment; filename="' . $this->metaObjectCode . '.xml"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($xml));
        header('Cache-Control: max-age=3600, must-revalidate');
        header('HTTP/1.0 200 OK');
        echo $xml;
        exit;
    }






    private function generateFiltersForExport()
    {
        $conditions1 = array();
        $conditions = $this->sqlGetRecordSet("
        	SELECT
        		ma.id, ma.code, ma.type, ma.typeparam, mvc.operation, mvc.value, mvc.sql
            FROM
            	metaviewcondition mvc
            	LEFT JOIN metaattribute ma ON ma.id=mvc.metaattribute_id
            WHERE
            	mvc.metaview_id=".$this->metaViewId);
        if ($conditions)
        {
            foreach ($conditions as $condition)
            {
                $value = $condition['value'];
                //
                if ($value == 'ME')
                {
                    $linkedMetaObject = $this->sqlGetValue("
                        SELECT
                        	mo.code
                        FROM
                        	metaattribute ma
                            LEFT JOIN metaobject mo ON mo.id=ma.metaobject_id
                        WHERE
                        	ma.type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT."
                        	AND ma.typeparam='sysuser'
                        	AND mo.code!='sysuser'");
                    $linkedObjectId = $this->sqlGetValue("SELECT id FROM `$linkedMetaObject` WHERE sysuser_id=".Runtime::$uid);
                    $value = $linkedMetaObject && $linkedObjectId ? $linkedObjectId : Runtime::$uid;
                }
                $operation = str_replace(array('L','B','E','LE','BE'), array('<','>','=','<=','>='), $condition['operation']);
                //
                $conditions1[] = array(
                    'code' => $condition['code'],
                    'operation' => $operation,
                    'value' => $value,
                    'sql' => $condition['sql'],
                );
            }
        }
        //
        $filters = array();
        $metaAttributes = $this->sqlGetRecordSet("
            SELECT
            	ma.id, ma.code, ma.type, ma.typeparam, mvf.name, mvf.uie, mvf.uieparams, mvf.defaultvalue, mvf.hint, mvf.unit, mvf.mask, mvf.group
            FROM
            	metaviewfield mvf
                LEFT JOIN metaattribute ma ON ma.id=mvf.metaattribute_id
            WHERE
            	mvf.metaview_id={$this->metaViewId}
            ORDER BY
            	mvf.pos ASC");
        Std::loadMetaObjectClass($this->metaObjectCode);
        $className = $this->metaObjectCode.'Object';
        $classVars = get_class_vars($className);
        $metaAttributesList[] = $classVars['ID_METAATTRIBUTE'] . " 'id'";
        foreach ($metaAttributes as $metaAttribute)
        {
            if ($metaAttribute['type'] != META_ATTRIBUTE_TYPE_LINKTOOBJECTS && $metaAttribute['type'] != META_ATTRIBUTE_TYPE_QUERY)
            {
                switch ($metaAttribute['type'])
                {
                    case META_ATTRIBUTE_TYPE_INT:
                    case META_ATTRIBUTE_TYPE_FLOAT:
                        if ($this->filters[$metaAttribute['code'].'-from'])
                        {
                            $filters[$metaAttribute['code'].'-from'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`>='{$this->filters[$metaAttribute['code'].'-from']}'",
                            );
                        }
                        if ($this->filters[$metaAttribute['code'].'-till'])
                        {
                            $filters[$metaAttribute['code'].'-till'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`<='{$this->filters[$metaAttribute['code'].'-till']}'",
                            );
                        }
                        break;
                    case META_ATTRIBUTE_TYPE_STRING:
                    case META_ATTRIBUTE_TYPE_TEXT:
                    case META_ATTRIBUTE_TYPE_BIGTEXT:
                        if ($this->filters[$metaAttribute['code']])
                        {
                            $filters[$metaAttribute['code']] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}` LIKE '".str_replace("*", "%", $this->filters[$metaAttribute['code']])."'",
                            );
                        }
                        $filterWidth = 160;
                        break;
                    case META_ATTRIBUTE_TYPE_DATETIME:
                        if ($this->filters[$metaAttribute['code'].'-from'])
                        {
                            $filters[$metaAttribute['code'].'-from'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`>='{$this->filters[$metaAttribute['code'].'-from']}'",
                            );
                        }
                        if ($this->filters[$metaAttribute['code'].'-till'])
                        {
                            $filters[$metaAttribute['code'].'-till'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`<='{$this->filters[$metaAttribute['code'].'-till']}'",
                            );
                        }
                        break;
                    case META_ATTRIBUTE_TYPE_DATE:
                        if ($this->filters[$metaAttribute['code'].'-from'])
                        {
                            $filters[$metaAttribute['code'].'-from'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`>='{$this->filters[$metaAttribute['code'].'-from']}'",
                            );
                        }
                        if ($this->filters[$metaAttribute['code'].'-till'])
                        {
                            $filters[$metaAttribute['code'].'-till'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`<='{$this->filters[$metaAttribute['code'].'-till']}'",
                            );
                        }
                        break;
                    case META_ATTRIBUTE_TYPE_BOOL:
                        $options = array();
                        if ($this->filters[$metaAttribute['code'].'-yes'])
                        {
                            $options[] = "`{$metaAttribute['code']}`>0";
                        }
                        if ($this->filters[$metaAttribute['code'].'-no'])
                        {
                            $options[] = "`{$metaAttribute['code']}`=0";
                        }
                        if (sizeof($options) > 0)
                        {
                            $filters[$metaAttribute['code']] = array(
                                'value' => '',
                                'condition' => '('.implode(' OR ', $options).')',
                            );
                        }
                        break;
                    case META_ATTRIBUTE_TYPE_FILE:
                    case META_ATTRIBUTE_TYPE_IMAGE:
                        $options = array();
                        if ($this->filters[$metaAttribute['code'].'-yes'])
                        {
                            $options[] = "`{$metaAttribute['code']}`>0";
                        }
                        if ($this->filters[$metaAttribute['code'].'-no'])
                        {
                            $options[] = "`{$metaAttribute['code']}`=0";
                        }
                        if (sizeof($options) > 0)
                        {
                            $filters[$metaAttribute['code']] = array(
                                'value' => '',
                                'condition' => '('.implode(' OR ', $options).')',
                            );
                        }
                        break;
                    case META_ATTRIBUTE_TYPE_DICTIONARY:
                        if ($this->filters[$metaAttribute['code']])
                        {
                            $filters[$metaAttribute['code']] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`='{$this->filters[$metaAttribute['code']]}'",
                            );
                        }
                        break;
                    case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                        if ($this->filters[$metaAttribute['code']])
                        {
                            if (is_numeric($this->filters[$metaAttribute['code']])) {
                                $filterVal = $this->filters[$metaAttribute['code']];
                            } else {
                                $exportMetaAttributeCode = $this->sqlGetValue("
                                    SELECT
                                        ma.code
                                    FROM
                                        metaattribute ma
                                        LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                                    WHERE
                                        sp.metaobject_id=(SELECT id FROM metaobject WHERE code='{$metaAttribute['typeparam']}')");
                                $filterVal = $this->sqlGetValue("SELECT id FROM `{$metaAttribute['typeparam']}` WHERE `$exportMetaAttributeCode`='" . $this->filters[$metaAttribute['code']] . "'");
                                if (!$filterVal) {
                                    $filterVal = 0;
                                }
                            }

                            $filters[$metaAttribute['code']] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`=$filterVal",
                            );
                        }
                        $filterWidth = 160;
                        break;
                    case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    case META_ATTRIBUTE_TYPE_DATA:
                    case META_ATTRIBUTE_TYPE_CUSTOM:
                    case META_ATTRIBUTE_TYPE_PASSWORD:
                        break;
                }
            }
        }
        //
        $where = array();
        if (sizeof($conditions1) > 0)
        {
            foreach ($conditions1 as $condition)
            {
                $value = $condition['value'] == '' ? $condition['sql'] : "'".$condition['value']."'";
                $where[] = "`{$condition['code']}`{$condition['operation']}$value";
            }
        }
        //
        if (sizeof($filters) > 0)
        {
            foreach ($filters as $filter)
            {
                $where[] = $filter['condition'];
            }
        }
        /*
        if ($this->parent)
        {
            foreach ($this->parent as $parent)
            {
                if ($parent['id'] > 0)
                {
                    $where[] = "`{$parent['metaattribute']}`={$parent['id']}";
                }
            }
        }
        */
        //
        if ($GLOBALS['config']['advancedsecurity'])
        {
            $where[] = "checkUserRightsOnObject({$this->metaObjectId}, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1";
        }
        //
        return sizeof($where) > 0 ? ' WHERE '.implode(' AND ', $where) : '';
    }
}
?>
