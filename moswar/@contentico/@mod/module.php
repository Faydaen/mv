<?php
define('ACTION_LIST', 1);
define('ACTION_VIEW', 2);
define('ACTION_CREATE', 3);
define('ACTION_EDIT', 4);
define('ACTION_DELETE', 5);
define('ACTION_EXPORT', 6);
define('ACTION_IMPORT', 7);
define('ACTION_CUSTOM', 9);
define('ACTION_COPY', 10);
define('ACTION_CANNOT_INSERT',11);
/**
 * Родительский модуль для всех модулей панели управления
 *
 */
class ContenticoModule implements IBaseModule
{
    private $sql;
    
    protected $template;
    protected $url;
    protected $action = ACTION_LIST;
    protected $actionParam = "";
    protected $moduleRights;
    protected $ajaxRequest = false;
    
    public $page = array();
    public $path = array();

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    /**
     * Действия перед обработкой запроса
     *
     */
    public function onBeforeProcessRequest()
    {

        $this->url = explode('/', substr($_GET['url'], 0, -1));
        Runtime::init(true);
        if (!Runtime::$uid)
        {
        	Contentico::loadModule('Auth');
        	$authModule = new Auth();
        	$authModule->tryAutologin();
        }
        if (Runtime::$uid)
        {
            $this->template = Contentico::loadTemplate('page');
            // проверка прав доступа к модулю
            $this->moduleRights = $this->sqlGetValue("SELECT max(rights) FROM syssecurity WHERE sysuser_id=".Runtime::$gid."
                AND metaobject_id=(SELECT id FROM metaobject WHERE code='sysmodule')
                AND (object_id=0 OR object_id=(SELECT id FROM sysmodule WHERE code='{$_GET['_m']}'))");
            if (!$this->moduleRights && $_GET['_m'] != 'Auth' && $_GET['_m'] != 'Metaobjects' && $_GET['_m'] != 'Account')
            {
                header('Location: /@contentico/Auth/accessdenied/');
                exit;
            }
            // меню и меню документов
            $this->generateModulesMenu();
            $this->generateMetaObjectsMenu();
            //
            $this->page['help-context'] = strtolower($_GET['_m']).($_GET['_m'] == 'Metaobjects' ? '-'.$this->url[0] : '');
        }
        else
        {
            if ($_GET['_m'] != 'Auth')
            {
                header('Location: /@contentico/Auth/');
                exit;
            }
        }
    }

    /**
     * Действия после обработки запроса
     *
     */
    public function onAfterProcessRequest()
    {
        if (Runtime::$uid)
        {
            if (sizeof($this->path) > 0)
            {
                $path = array();
                foreach ($this->path as $label=>$url)
                {
                    $path[] = $url ? '<a href="/@contentico/'.$url.'/">'.$label.'</a>' : '<span>'.$label.'</span>';
                }
                $this->page['path'] = '<i></i>'.implode('<i></i>', $path);
            }
            //
            $user = $this->sqlGetRecord("SELECT u1.name user, u2.name `group` FROM sysuser u1 LEFT JOIN sysuser u2 ON u1._id=u2.id WHERE u1.id=".Runtime::$uid);
            $this->page['user-name'] = $user['user'];
            $this->page['user-group'] = $user['group'];
            $this->page['logo-red'] = DEV_SERVER ? '' : '-red';
        }
    }

    /**
     * Обработка запроса
     *
     */
    public function processRequest()
    {
        $this->onBeforeProcessRequest();
        //
        $this->onAfterProcessRequest();
    }

    /**
     * Генерация HTML страницы
     *
     */
    public function renderPage()
    {
        $html = Std::renderTemplate($this->template, $this->page);
        $html = preg_replace('/<%[^>]*%>/', '', $html);
        echo $html;
    }

    /**
     * Генерация меню модулей
     *
     */
    private function generateModulesMenu()
    {
        $modules = $this->sqlGetRecordSet("
            SELECT sm.code, sm.name FROM sysmodule sm
            WHERE sm.menupos>0 AND (SELECT max(rights) FROM syssecurity WHERE sysuser_id=".Runtime::$gid."
                AND metaobject_id=(SELECT id FROM metaobject WHERE code='sysmodule') AND (object_id=0 OR object_id=sm.id)) > 0
            ORDER BY sm.menupos ASC");
        if ($modules)
        {
            $i=1;
            foreach ($modules as $module)
            {
                $this->page['modules-menu'] .= '<li sort="top_sort" <%left-menu-'.strtolower($module['code']).'%>><a href="/@contentico/'.$module['code'].'/">'.$module['name'].'</a><span style="display:none">'.$i++.'</span></li>';
            }
        }
    }

    /**
     * Генерация меню метаобъектов
     *
     */
    private function generateMetaObjectsMenu()
    {
        $metaObjects = $this->sqlGetRecordSet("
            SELECT mo.code, sp.name FROM sysparams sp LEFT JOIN metaobject mo ON sp.metaobject_id=mo.id
            WHERE sp.menupos>0 AND (SELECT max(rights) FROM syssecurity WHERE metaobject_id=mo.id AND metaview_id=0 AND sysuser_id=".Runtime::$gid.") > 0
            ORDER BY sp.menupos ASC");
        if ($metaObjects)
        {
            $i=1;
            foreach ($metaObjects as $metaObject)
            {
                $this->page['metaobjects-menu'] .= '<li sort="bottom_sort" <%left-menu-metaobject-'.$metaObject['code'].'%>><a href="/@contentico/Metaobjects/'.$metaObject['code'].'/">'.$metaObject['name'].'</a><span style="display:none">'.$i++.'</span></li>';
            }
        }
    }

    // Сокращения для вызова функций работы с БД

    /**
     * Получить значение из БД
     *
     * @param string $query
     * @return string
     */
    protected function sqlGetValue($query)
    {
        return $this->sql->getValue($query);
    }

    /**
     * Получить массив значений из БД
     *
     * @param string $query
     * @return array
     */
    protected function sqlGetValueSet($query)
    {
        return $this->sql->getValueSet($query);
    }

    /**
     * Получить запись (record) из БД
     *
     * @param string $query
     * @return array
     */
    protected function sqlGetRecord($query)
    {
        return $this->sql->getRecord($query);
    }

    /**
     * Получить набор записей (record set) из БД
     *
     * @param string $query
     * @return array
     */
    protected function sqlGetRecordSet($query)
    {
        return $this->sql->getRecordSet($query);
    }

    /**
     * Вставить запись в БД
     *
     * @param string $query
     * @return int - ID вставленной записи
     */
    protected function sqlInsert($query)
    {
        return $this->sql->insert($query);
    }

    /**
     * Выполнить запрос к БД
     *
     * @param string $query
     * @return sql resource
     */
    protected function sqlQuery($query)
    {
        return $this->sql->query($query);
    }

	protected function sqlGetAffectedRows()
    {
        return $this->sql->getAffectedRows();
    }
}
?>