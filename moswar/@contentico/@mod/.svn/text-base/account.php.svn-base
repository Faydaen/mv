<?php
/**
 * Профиль пользователя
 *
 */
class Account extends ContenticoModule implements IModule
{
    private $metaObjectCode;
    private $metaObjectID;

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
        //
        $this->processUrl();
        $this->path['Профиль'] = 'Account';
        //
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $this->saveObject();
        }
        //
        $this->generateUsersForm();
        $this->page['page-name'] = 'Редактировать профиль';
        //
        $this->page['content'] = $this->replaceCommonValues($this->page['content']);
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Замена констант
     *
     * @param string $content
     * @return string
     */
    private function replaceCommonValues($content)
    {
        return Std::renderTemplate($content, array(
            'ACTION_CREATE'=>ACTION_CREATE,
            'ACTION_EDIT'=>ACTION_EDIT,
            'ACTION_DELETE'=>ACTION_DELETE,
            'ACTION_LIST'=>ACTION_LIST,
        ));
    }

    /**
     * Обработка адреса запроса
     *
     */
    private function processUrl()
    {
        for ($i = 0; $i < sizeof($this->url); $i++)
        {
            $urlPart = explode('=', $this->url[$i]);
            switch ($urlPart[0]) {
            	case 'action':
            	    $this->action = (int) $urlPart[1];
            	    break;
            }
        }
    }

    /**
     * Форма редактирования аккаунта
     *
     */
    private function generateUsersForm()
    {
        $user = array();
        $sysUser = $this->sqlGetRecord("SELECT name, email, cfghtmlarea FROM sysuser WHERE id=".Runtime::$uid);
        $formView = $this->sqlGetRecord("
            SELECT mv.id, mv.metaobject_id, mo.id metaobject_id, mo.code metaobject
            FROM metaview mv
                LEFT JOIN metaobject mo ON mo.id=mv.metaobject_id
                LEFT JOIN sysparams sp ON sp.metaobject_id=mo.id
                LEFT JOIN syssecurity ssmv ON ssmv.metaview_id=mv.id AND ssmv.sysuser_id=".Runtime::$gid."
                LEFT JOIN syssecurity ssmo ON ssmo.metaobject_id=mo.id AND ssmo.metaview_id=0 AND ssmo.sysuser_id=".Runtime::$gid."
            WHERE mv.type=".META_VIEW_TYPE_FORM." AND ssmv.rights>0 AND ssmo.rights>0
                AND (SELECT count(*) FROM metaattribute WHERE metaobject_id=mo.id AND type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT." AND typeparam='sysuser') > 0");
        if ($formView)
        {
            $accountObjectId = $_SESSION['@contentico']['Account']['objectid'] = $this->sqlGetValue("SELECT id FROM `{$formView['metaobject']}` WHERE sysuser_id=".Runtime::$uid);
        }
        else
        {
            $accountObjectId = false;
        }
        if ($formView && $accountObjectId)
        {
            $form = new ContenticoViewForm();
            $form->metaObjectID = $_SESSION['@contentico']['Account']['metaobjectid'] = $formView['metaobject_id'];
            $form->metaObjectCode = $_SESSION['@contentico']['Account']['metaobjectcode'] = $formView['metaobject'];
            $form->metaViewID = $_SESSION['@contentico']['Account']['metaviewid'] = $formView['id'];
            $form->action = ACTION_EDIT;
            $form->objectID = $AccountObjectID;
            $form->returnToPage = 0;
            $form->returnToView = 0;
            $form->params = array();
            $form->parent = array();
            $form->generate();
            $form->tableTemplate = Std::renderTemplate(Contentico::loadTemplate('account/table'), array(
                'email' => $sysUser['email'],
                'cfghtmlarea' => $sysUser['cfghtmlarea'] ? 'checked="checked"' : '',
            ));
            $this->page['content'] = $form->getHtml();
        }
        else
        {
            $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('account/table'), array(
                'name' => $sysUser['name'],
                'email' => $sysUser['email'],
                'cfghtmlarea' => $sysUser['cfghtmlarea'] ? 'checked="checked"' : '',
                'action-url' => 'action='.ACTION_EDIT,
            ));
        }
    }

    /**
     * Сохранение аккаунта
     *
     */
    private function saveObject()
    {
        if ($_SESSION['@contentico']['Account']['metaobjectcode'] != '' && $_SESSION['@contentico']['Account']['objectid'] > 0)
        {
            Std::loadMetaObjectClass($_SESSION['@contentico']['Account']['metaobjectcode']);
            $objectClass = $_SESSION['@contentico']['Account']['metaobjectcode'].'Object';
            $object = new $objectClass();
            $object->metaViewId = $_SESSION['@contentico']['Account']['metaviewid'];
            $object->id = $_SESSION['@contentico']['Account']['objectid'];
            $object->initFromForm($this->sqlGetValue("SELECT id FROM `{$_SESSION['@contentico']['Account']['metaobjectcode']}` WHERE sysuser_id=".Runtime::$uid));
            $object->save();
        }
        //
        $pwd = $_POST['pwd'] == '*****' ? $this->sqlGetValue("SELECT pwd FROM sysuser WHERE id=".Runtime::$uid) : sha1(trim($_POST['pwd']));
        $cfgHtmlarea = isset($_POST['cfghtmlarea']) ? 1 : 0;
        $name = Std::CleanString($_POST['name']);
        $this->sqlQuery("UPDATE sysuser SET name='$name', pwd='$pwd', cfghtmlarea=$cfgHtmlarea WHERE id=".Runtime::$uid);
        //
        header('Location: /@contentico/Account/');
        exit;
    }
}
?>