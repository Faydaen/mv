<?php
/**
 * Управление пользователями и правами доступа
 *
 */
class Users extends ContenticoModule implements IModule
{
    private $id = 1;
    private $type = self::TYPE_GROUPS;
    private $groupID;
    private $curPage = 1;
    private $returnToPage;

    const RULES_PER_PAGE = 20;
    const TYPE_USERS = 1;
    const TYPE_GROUPS = 2;
    const TYPE_SECURITY = 3;
    const ACTION_SECURITYFORM_GETOBJECTS = 101;
    const ACTION_SECURITYFORM_GETMETAVIEWS = 102;
    const ACTION_FULLACCESS = 103;

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
        $this->page['left-menu-users'] = 'class="cur"';
        $this->path['Пользователи'] = 'Users';
        //
        if (!$this->groupId)
        {
            $this->groupId = $_SESSION['@contentico']['Users']['gid'] ? $_SESSION['@contentico']['Users']['gid'] : 1;
        }
        //
        switch ($this->action)
        {
            case ACTION_LIST:
                if ($this->type == self::TYPE_GROUPS)
                {
                    $this->generateUsersList();
                    $this->page['page-name'] = $this->sqlGetValue("SELECT name FROM sysuser WHERE id={$this->id}");
                }
                else
                {
                    $this->generateSecurityList();
                    $this->path[$this->sqlGetValue("SELECT name FROM sysuser WHERE id={$this->groupId}")] = 'Users/type='.self::TYPE_GROUPS.'/action='.ACTION_LIST.'/id='.$this->groupId;
                    $this->page['page-name'] = 'Права доступа';
                }
                break;
            case ACTION_CREATE:
            case ACTION_EDIT:
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $this->saveObject();
                }
                $this->path[$this->sqlGetValue("SELECT name FROM sysuser WHERE id={$this->groupId}")] = 'Users/type='.self::TYPE_GROUPS.'/action='.ACTION_LIST.'/id='.$this->groupId;
                if ($this->type == self::TYPE_GROUPS)
                {
                    $this->generateGroupsForm();
                    $this->page['page-name'] = $this->action == ACTION_CREATE ? 'Новая группа' : 'Настройки';
                }
                elseif ($this->type == self::TYPE_USERS)
                {
                    $this->generateUsersForm();
                    $this->page['page-name'] = $this->action == ACTION_CREATE ? 'Новый пользователь' : 'Редактировать';
                }
                elseif ($this->type == self::TYPE_SECURITY)
                {
                    $this->path['Права доступа'] = 'Users/type='.self::TYPE_SECURITY.'/action='.ACTION_LIST.'/id='.$this->groupId;
                    $this->generateSecurityForm();
                    $this->page['page-name'] = $this->action == ACTION_CREATE ? 'Новое правило' : 'Редактировать';
                }
                break;
            case ACTION_DELETE:
                $this->deleteObject();
                break;
            case self::ACTION_FULLACCESS:
                $this->securityFullAccess();
                break;
            case self::ACTION_SECURITYFORM_GETOBJECTS:
                $this->securityFormGetObjects();
                break;
            case self::ACTION_SECURITYFORM_GETMETAVIEWS:
                $this->securityFormGetMetaViews();
                break;
        }
        //
        $this->page['content'] = $this->replaceCommonValues($this->page['content']);
        $this->generateGroupsTree();
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Замена констант
     *
     * @param string $Content
     * @return string
     */
    private function replaceCommonValues($content)
    {
        $content = Std::renderTemplate(Contentico::loadTemplate('users/tabs'), array(
            'cur-list' => $this->type == self::TYPE_USERS || ($this->type == self::TYPE_GROUPS && $this->action == ACTION_LIST) ? 'class="cur"' : '',
            'cur-settings' => $this->type == self::TYPE_GROUPS && $this->action == ACTION_EDIT ? 'class="cur"' : '',
            'cur-security' => $this->type == self::TYPE_SECURITY ? 'class="cur"' : '',
            'group-id' => $this->groupId,
        )).$content;
        return Std::renderTemplate($content, array(
            'TYPE_GROUPS'=>self::TYPE_GROUPS,
            'TYPE_USERS'=>self::TYPE_USERS,
            'TYPE_SECURITY'=>self::TYPE_SECURITY,
            'ACTION_CREATE'=>ACTION_CREATE,
            'ACTION_EDIT'=>ACTION_EDIT,
            'ACTION_DELETE'=>ACTION_DELETE,
            'ACTION_LIST'=>ACTION_LIST,
            'ACTION_FULLACCESS'=>self::ACTION_FULLACCESS,
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
            	case 'id':
            	    $this->id = (int) $urlPart[1];
            	    break;
            	case 'type':
            	    $this->type = (int) $urlPart[1];
            	    break;
            	case 'group':
            	    $this->groupId = $_SESSION['@contentico']['Users']['gid'] = (int) $urlPart[1];
            	    break;
            	case 'page':
            	    $this->curPage = (int) $urlPart[1];
            	    if ($this->curPage < 1)
            	    {
            	        $this->curPage = 1;
            	    }
            	    break;
            	case '-page':
            	    $this->returnToPage = $urlPart[1];
            	    break;
            }
        }
    }

    // группы

    /**
     * Генерация дерева групп
     *
     */
    private function generateGroupsTree()
    {
        $groups = $this->sqlGetRecordSet('SELECT u.id, u.name, (SELECT count(*) FROM sysuser WHERE _id=u.id) `count` FROM sysuser u WHERE u._id=0 ORDER BY u.name ASC');
        $li = '';
        $liTpl = Contentico::loadTemplate('tree/li');
        foreach ($groups as $group)
        {
            $li .= Std::renderTemplate($liTpl, array(
                'url'=>'Users/type='.self::TYPE_GROUPS.'/action='.ACTION_LIST.'/group='.$group['id'],
                'name'=>$group['name'],
                'count'=>$group['count'],
                'cur'=>$this->groupId == $group['id'] ? 'class="cur"' : '',
            ));
        }
        $this->page['tree'] = Std::renderTemplate(Contentico::loadTemplate('tree/td'), array(
            'li'=>$li,
            'create-url'=>'Users/type='.self::TYPE_GROUPS.'/action='.ACTION_CREATE,
            'create-label'=>'Добавить',
            'name' => 'Группы пользователей',
        ));
    }

    /**
     * Форма создания/редактирования группы
     *
     */
    private function generateGroupsForm()
    {
        $group = array();
        if ($this->action == ACTION_EDIT)
        {
            $group = $this->sqlGetRecord("SELECT name FROM sysuser WHERE id={$this->id}");
        }
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('users/groups-form'), array(
            'ID'=>$this->id,
            'name'=>$group['name'],
            'id'=>$this->action == ACTION_EDIT ? 'id='.$this->id.'/' : '',
            'action'=>$this->action,
            'delete-button'=>$this->action == ACTION_EDIT && $this->id != 1 ? '<input class="delete" type="button" value="Удалить" onclick="if(window.confirm(\'Подтвердите удаление.\')){document.location.href=\'/@contentico/Users/type='.self::TYPE_GROUPS.'/action='.ACTION_DELETE.'/id='.$this->id.'/\';}" />' : '',
        ));
    }

    // пользователи

    /**
     * Список пользователей
     *
     */
    private function generateUsersList()
    {
        $rows = $this->sqlGetRecordSet("SELECT id, name, email, enabled FROM sysuser WHERE _id={$this->groupId} ORDER BY name ASC");
        if ($rows)
        {
            $trTpl = Contentico::loadTemplate('users/tr');
            $tr = '';
            $i = $this->offset + 1;
            foreach ($rows as $row)
            {
                if ($row['name'] == '')
                {
                    $row['name'] = '<em>без имени</em>';
                }
                $row['name'] = '<a href="/@contentico/Users/type='.self::TYPE_USERS.'/action='.ACTION_EDIT.'/id='.$row['id'].'/">'.$row['name'].'</a>';
                $row['enabled'] = $row['enabled'] ? 'Да' : 'Нет';
                $row['i'] = $i;
                $tr .= Std::renderTemplate($trTpl, $row);
                $i++;
            }
        }
        else
        {
            $tr = '<tr><td colspan="5" align="center"><em>В группе нет пользователей</em></td></tr>';
        }
        $tableTpl = Std::renderTemplate(Contentico::loadTemplate('users/table'), array(
            'tr'=>$tr,
            'ID'=>$this->id,
        ));
        $this->page['content'] = $tableTpl;
    }

    /**
     * Форма создания/редактироавния пользователя
     *
     */
    private function generateUsersForm()
    {
        Std::loadLib('HtmlTools');
        $user = array();
        if ($this->action == ACTION_EDIT)
        {
            $user = $this->sqlGetRecord("SELECT name, email, enabled, cfghtmlarea FROM sysuser WHERE id={$this->id}");
        }
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('users/users-form'), array(
            'name'=>$user['name'],
            'email'=>$user['email'],
            'enabled'=>$user['enabled'] ? 'checked="checked"' : '',
            'cfghtmlarea'=>$user['cfghtmlarea'] ? 'checked="checked"' : '',
            'pwd'=>$this->action == ACTION_EDIT ? '*****' : '',
            'id'=>$this->action == ACTION_EDIT ? 'id='.$this->id.'/' : '',
            'action'=>$this->action,
            'groups'=>HtmlTools::generateOptions("SELECT id, name FROM sysuser WHERE _id=0 ORDER BY name ASC", ($this->action == ACTION_CREATE ? $this->id : $this->sqlGetValue("SELECT _id FROM sysuser WHERE id={$this->id}")), ($this->action == ACTION_CREATE ? $this->id : $user['_id'])),
        ));
    }

    // права доступа

    /**
     * Список прав доступа группы
     *
     */
    private function generateSecurityList()
    {
        $offset = ($this->curPage - 1) * self::RULES_PER_PAGE;
        //
        $sysModuleMetaObjectID = $this->sqlGetValue("SELECT id FROM metaobject WHERE code='sysmodule'");
        $rows = $this->sqlGetRecordSet("
            SELECT SQL_CALC_FOUND_ROWS
                ss.id, ss.rights, sp.name metaobject_name, ss.metaobject_id, ma.code 'export', mo.code metaobject_code, ss.object_id, ss.metaview_id,
                CASE WHEN mv.type=".META_VIEW_TYPE_FORM." THEN concat(mv.name, ' (форма)') ELSE
                CASE WHEN mv.type=".META_VIEW_TYPE_LIST." THEN concat(mv.name, ' (список)') ELSE
                CASE WHEN mv.type=".META_VIEW_TYPE_CARD." THEN concat(mv.name, ' (карточка)') ELSE
                CASE WHEN mv.type=".META_VIEW_TYPE_WIDGET." THEN concat(mv.name, ' (виджет)') ELSE
                CASE WHEN mv.type=".META_VIEW_TYPE_QUICKLIST." THEN concat(mv.name, ' (мини-список)') ELSE
                CASE WHEN mv.type=".META_VIEW_TYPE_QUICKFORM." THEN concat(mv.name, ' (мини-форма)') ELSE mv.name END END END END END END metaview
            FROM syssecurity ss
                LEFT JOIN metaobject mo ON mo.id=ss.metaobject_id
                LEFT JOIN metaview mv ON mv.id=ss.metaview_id
                LEFT JOIN sysparams sp ON sp.metaobject_id=ss.metaobject_id
                LEFT JOIN metaattribute ma ON sp.export_metaattribute_id=ma.id
            WHERE ss.sysuser_id={$this->groupId}
            ORDER BY sp.menupos ASC, metaobject_id ASC, object_id ASC, metaview_id ASC
            LIMIT $offset, ".self::RULES_PER_PAGE);
        $totalRows = $this->sqlGetValue("SELECT found_rows()");
        if (!$rows && $totalRows > 0 && $this->curPage > 1)
        {
            header('Location: /@contentico/Users/type='.self::TYPE_SECURITY.'/action='.ACTION_LIST.'/page='.($this->curPage - 1).'/');
            exit;
        }
        if ($rows)
        {
            $trTpl = Contentico::loadTemplate('users/security-tr');
            $tr = '';
            $i = 1;
            foreach ($rows as $row)
            {
                $row['object'] = $row['metaview_id'] > 0 || $row['metaobject_id'] == 5 ? '&mdash;' :
                    ($row['object_id'] > 0 ? $this->sqlGetValue("SELECT `{$row['export']}` FROM `{$row['metaobject_code']}` WHERE id={$row['object_id']}") : '<em>все</em>');
                $row['metaview'] = $row['metaview'] ? $row['metaview'] : '&mdash;';
                $row['metaobject'] = $row['metaobject_id'] == $sysModuleMetaObjectID ?
                    $this->sqlGetValue("SELECT name FROM sysmodule WHERE id={$row['object_id']}") :
                    ($row['metaobject_id'] > 0 ? $this->sqlGetValue("SELECT sp.name FROM sysparams sp WHERE sp.metaobject_id={$row['metaobject_id']}") : '<em>все</em>');
                $row['metaobject'] = '<a href="/@contentico/Users/type='.self::TYPE_SECURITY.'/action='.ACTION_EDIT.'/-page='.$this->curPage.'/id='.$row['id'].'/">'.$row['metaobject'].'</a>';
                $rights = array();
                if ($row['rights'] & SECURITY_RIGHT_READ)
                {
                    $rights[] = $row['metaobject_id'] == $sysModuleMetaObjectID || $row['metaview_id'] > 0 ? 'доступ разрешен' : 'просмотр';
                }
                if ($row['rights'] & SECURITY_RIGHT_WRITE)
                {
                    $rights[] = 'изменение';
                }
                if ($row['rights'] & SECURITY_RIGHT_DELETE)
                {
                    $rights[] = 'удаление';
                }
                $row['rights'] = sizeof($rights) > 0 ? implode(', ', $rights) : '<em>нет</em>';
                $row['i'] = $i + $offset;
                $tr .= Std::renderTemplate($trTpl, $row);
                $i++;
            }
        }
        else
        {
            $tr = '<tr><td colspan="5" align="center"><em>В группе нет пользователей</em></td></tr>';
        }
        $tableTpl = Std::renderTemplate(Contentico::loadTemplate('users/security-table'), array(
            'tr' => $tr,
            'ID' => $this->id,
            '-page' => $this->curPage,
        ));
        //
        $this->page['content'] = $tableTpl.Std::renderNavigation($totalRows, self::RULES_PER_PAGE, $this->curPage, '/@contentico/Users/type=3/action=1/page=');
    }

    /**
     * Форма создания/релактирования правила доступа
     *
     */
    private function generateSecurityForm()
    {
        $user = array();
        if ($this->action == ACTION_EDIT)
        {
            $rule = $this->sqlGetRecord("
                SELECT
                    ss.rights, sp.name metaobject_name, ma.code metaattribute, ss.object_id, mo.code metaobject_code, ss.metaobject_id, ss.metaview_id,
                    CASE WHEN mv.type=".META_VIEW_TYPE_FORM." THEN concat(mv.name, ' (форма)') ELSE
                    CASE WHEN mv.type=".META_VIEW_TYPE_LIST." THEN concat(mv.name, ' (список)') ELSE
                    CASE WHEN mv.type=".META_VIEW_TYPE_CARD." THEN concat(mv.name, ' (карточка)') ELSE
                    CASE WHEN mv.type=".META_VIEW_TYPE_WIDGET." THEN concat(mv.name, ' (виджет)') ELSE
                    CASE WHEN mv.type=".META_VIEW_TYPE_QUICKLIST." THEN concat(mv.name, ' (мини-список)') ELSE
                    CASE WHEN mv.type=".META_VIEW_TYPE_QUICKFORM." THEN concat(mv.name, ' (мини-форма)') ELSE mv.name END END END END END END metaview
                FROM syssecurity ss
                    LEFT JOIN metaobject mo ON mo.id=ss.metaobject_id
                    LEFT JOIN metaview mv ON mv.id=ss.metaview_id
                    LEFT JOIN sysparams sp ON sp.metaobject_id=ss.metaobject_id
                    LEFT JOIN metaattribute ma ON ma.id=sp.export_metaattribute_id
                WHERE ss.id={$this->id}");
        }
        if ($this->action == ACTION_EDIT)
        {
            if ($rule['metaobject_code'] == 'sysmodule')
            {
                $module = $this->sqlGetValue("SELECT name FROM sysmodule WHERE id={$rule['object_id']}");
            }
            else
            {
                $module = $rule['metaobject_id'] ? $this->sqlGetValue("SELECT sp.name FROM sysparams sp WHERE sp.metaobject_id="/$rule['metaobject_id']) : '<em>все</em>';
                $exportMetaAttributeCode = $this->sqlGetValue("SELECT ma.code FROM metaattribute ma LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                    WHERE sp.metaobject_id=(SELECT id FROM metaobject WHERE code='{$rule['metaobject_code']}')");
                $object = $rule['object_id'] == 0 ? '<em>все</em>' : $this->sqlGetValue("SELECT `$exportMetaAttributeCode` FROM `{$rule['metaobject_code']}` WHERE id=".$rule['object_id']);
            }
        }
        else
        {
            $module = '';
        }
        if ($this->action == ACTION_CREATE)
        {
            $metaObjectsJS = array();
            $sysModules = $this->sqlGetRecordSet("SELECT id, name FROM sysmodule WHERE code!='Metaobjects' ORDER BY id ASC");
            foreach ($sysModules as $sysModule)
            {
                $metaObjectsJS[] = '{"id":"'.$sysModule['id'].'","type":"1","name":"'.$sysModule['name'].'","rights":"access"}';
            }
            $metaObjects = $this->sqlGetRecordSet("SELECT sp.metaobject_id id, sp.name FROM sysparams sp LEFT JOIN metaobject mo ON mo.id=sp.metaobject_id WHERE mo.code!='sysmodule' ORDER BY sp.menupos ASC");
            foreach ($metaObjects as $metaObject)
            {
                $metaObjectsJS[] = '{"id":"'.$metaObject['id'].'","type":"2","name":"'.$metaObject['name'].'","rights":"actions"}';
            }
        }
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('users/security-form'), array(
            'metaobjects' => $this->action == ACTION_CREATE ? '['.implode(',', $metaObjectsJS).']' : '[]',
            'id' => $this->action == ACTION_EDIT ? 'id='.$this->id.'/' : '',
            'action' => $this->action,
            'right-read' => $this->action == ACTION_EDIT && $rule['rights'] & SECURITY_RIGHT_READ ? 'checked="checked"' : '',
            'right-write' => $this->action == ACTION_EDIT && $rule['rights'] & SECURITY_RIGHT_WRITE ? 'checked="checked"' : '',
            'right-delete' => $this->action == ACTION_EDIT && $rule['rights'] & SECURITY_RIGHT_DELETE ? 'checked="checked"' : '',
            'is-sysmodule' => $rule['metaobject_code'] == 'sysmodule' ? 'true' : 'false',
            'is-mo' => $rule['metaview'] ? 'false' : 'true',
            // edit
            'metaobject' => $this->action == ACTION_EDIT ? ($rule['metaobject_code'] == 'sysmodule' ? 'Модуль Contentico' : 'Модуль сайта') : '',
            'module' => $module,
            'moormv' => $this->action == ACTION_EDIT ? ($rule['metaview_id'] ? 'Доступ к представлению' : 'Операции над документами') : '',
            'metaview' => $this->action == ACTION_EDIT && $rule['metaview_id'] ? $rule['metaview'] : '',
            'object' => $this->action == ACTION_EDIT ? $object : '',
            '-page' => $this->returnToPage,
        ));
    }

    /**
     * Аjax
     * Список объектов
     *
     */
    private function securityFormGetObjects()
    {
        Std::loadLib('HtmlTools');
        $export = $this->sqlGetRecord("SELECT mo.code metaobject, ma.code metaattribute, sp.sortby, sp.sortorder
            FROM sysparams sp LEFT JOIN metaobject mo ON mo.id=sp.metaobject_id LEFT JOIN metaattribute ma ON ma.id=sp.export_metaattribute_id
            WHERE mo.id={$this->id}");
        $sort = $export['sortby'] && $export['sortorder'] ? "`{$export['sortby']}` {$export['sortorder']}" : "`{$export['metaattribute']}` ASC";
        if ($this->sqlGetValue("SELECT count(*) FROM `{$export['metaobject']}`") <= 1000) {
            echo HtmlTools::GenerateOptions("SELECT id, `{$export['metaattribute']}` name FROM `{$export['metaobject']}` ORDER BY $sort", 0);
        } else {
            echo '';
        }
        exit;
    }

    /**
     * Ajax
     * Список метапредставлений
     *
     */
    private function securityFormGetMetaViews()
    {
        Std::loadLib('HtmlTools');
        echo HtmlTools::generateOptions("SELECT id,
            CASE WHEN type=".META_VIEW_TYPE_FORM." THEN concat(name, ' (форма)') ELSE
            CASE WHEN type=".META_VIEW_TYPE_LIST." THEN concat(name, ' (список)') ELSE
            CASE WHEN type=".META_VIEW_TYPE_CARD." THEN concat(name, ' (карточка)') ELSE
            CASE WHEN type=".META_VIEW_TYPE_WIDGET." THEN concat(name, ' (виджет)') ELSE
            CASE WHEN type=".META_VIEW_TYPE_QUICKLIST." THEN concat(name, ' (мини-список)') ELSE
            CASE WHEN type=".META_VIEW_TYPE_QUICKFORM." THEN concat(name, ' (мини-форма)') ELSE name END END END END END END name
            FROM metaview WHERE metaobject_id={$this->id} ORDER BY type ASC, name ASC", 0);
        exit;
    }

    // операции

    /**
     * Сохдание/сохранение группы, пользователя, правила доступа
     *
     */
    private function saveObject()
    {
        if ($this->type == self::TYPE_USERS)
        {
            $name = Std::cleanString($_POST['name']);
            $email = preg_replace('/[^\w\.\-@]/', '', $_POST['email']);
            $enabled = isset($_POST['enabled']) ? 1 : 0;
            $cfgHtmlarea = isset($_POST['cfghtmlarea']) ? 1 : 0;
            $_id = (int) $_POST['_id'];
            if ($this->action == ACTION_CREATE)
            {
                $pwd = sha1(trim($_POST['pwd']));
                $this->sqlQuery("INSERT INTO sysuser (name, email, pwd, enabled, _id, cfghtmlarea) VALUES ('$name', '$email', '$pwd', $enabled, $_id, $cfgHtmlarea)");
            }
            else
            {
                $pwd = $_POST['pwd'] == '*****' ? $this->sqlGetValue("SELECT pwd FROM sysuser WHERE id={$this->id}") : sha1(trim($_POST['pwd']));
                $this->sqlQuery("UPDATE sysuser SET name='$name', email='$email', pwd='$pwd', enabled=$enabled, _id=$_id, cfghtmlarea=$cfgHtmlarea WHERE id={$this->id}");
            }
            header('Location: /@contentico/Users/type='.self::TYPE_GROUPS.'/action='.ACTION_LIST.'/');
        }
        elseif ($this->type == self::TYPE_GROUPS)
        {
            $name = Std::cleanString($_POST['name']);
            if ($this->action == ACTION_CREATE)
            {
                $this->id = $this->sqlInsert("INSERT INTO sysuser (name, email, pwd, enabled, _id) VALUES ('$name', '".rand(100000,999999)."', '', 1, 0)");
            }
            else
            {
                $this->sqlQuery("UPDATE sysuser SET name='$name' WHERE id={$this->id}");
            }
            header('Location: /@contentico/Users/type='.self::TYPE_GROUPS.'/action='.ACTION_LIST.'/');
        }
        elseif ($this->type == self::TYPE_SECURITY)
        {
            $Rights = array_sum(array_keys($_POST['rights']));
            if ($this->action == ACTION_CREATE)
            {
                if ($_POST['metaobject_type'] == 1) // доступ к модулям
                {
                    $metaObjectID = $this->sqlGetValue("SELECT id FROM metaobject WHERE code='sysmodule'");
                    $objectID = (int) $_POST['metaobject_id'];
                    $metaViewId = 0;
                    $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                        VALUES ({$this->groupId}, $metaObjectID, $objectID, $metaViewId, $Rights)");
                }
                else // доступ к метаобъектам
                {
                    $metaObjectID = (int) $_POST['metaobject_id'];
                    if ($_POST['target2'] == 1) // доступ к операциям
                    {
                        $metaViewId = 0;
                        if ($_POST['object_id'][0] == 0 && sizeof($_POST['object_id']) == 1)
                        {
                            $this->sqlQuery("DELETE FROM syssecurity WHERE sysuser_id={$this->groupId} AND metaobject_id=$metaObjectID AND metaview_id=0");
                            $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                                VALUES ({$this->groupId}, $metaObjectID, 0, $metaViewId, $Rights)");
                        }
                        else
                        {
                            foreach ($_POST['object_id'] as $objectID)
                            {
                                if ($objectID == 0)
                                {
                                    $this->sqlQuery("DELETE FROM syssecurity WHERE sysuser_id={$this->groupId} AND metaobject_id=$metaObjectID AND metaview_id=0");
                                }
                                $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                                    VALUES ({$this->groupId}, $metaObjectID, ".(int)$objectID.", $metaViewId, $Rights)");
                            }
                        }
                    }
                    else // доступ к представлениям
                    {
                        $objectID = 0;
                        if ($_POST['metaview_id'][0] == 0 && sizeof($_POST['metaview_id']) == 1)
                        {
                            $metaViews = $this->sqlGetValueSet("SELECT id FROM metaview WHERE metaobject_id=$metaObjectID");
                            foreach ($metaViews as $metaViewId)
                            {
                                $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                                    VALUES ({$this->groupId}, $metaObjectID, $objectID, $metaViewId, $Rights)");
                            }
                        }
                        else
                        {
                            foreach ($_POST['metaview_id'] as $metaViewId)
                            {
                                $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                                    VALUES ({$this->groupId}, $metaObjectID, $objectID, ".(int)$metaViewId.", $Rights)");
                            }
                        }
                    }
                }
            }
            else
            {
                $this->sqlQuery("UPDATE syssecurity SET rights=$Rights WHERE id={$this->id}");
            }
            header('Location: /@contentico/Users/type='.self::TYPE_SECURITY.'/action='.ACTION_LIST.'/page='.$this->ReturnToPage.'/');
        }
        exit;
    }

    private function securityFullAccess()
    {
        $this->sqlQuery("DELETE FROM syssecurity WHERE sysuser_id={$this->groupId}");
        // модули
        $sysModules = $this->sqlGetValueSet("SELECT id FROM sysmodule WHERE code!='Metaobjects' ORDER BY id ASC");
        $metaObjectID = $this->sqlGetValue("SELECT id FROM metaobject WHERE code='sysmodule'");
        foreach ($sysModules as $SysModule)
        {
            $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                VALUES ({$this->groupId}, $metaObjectID, $SysModule, 0, ".SECURITY_RIGHT_READ.")");
        }
        // метаобъекты
        $metaObjects = $this->sqlGetValueSet("SELECT sp.metaobject_id FROM sysparams sp LEFT JOIN metaobject mo ON mo.id=sp.metaobject_id WHERE mo.code!='sysmodule' ORDER BY sp.menupos ASC");
        if ($metaObjects)
        {
            foreach ($metaObjects as $metaObjectID)
            {
                $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                    VALUES ({$this->groupId}, $metaObjectID, 0, 0, ".(SECURITY_RIGHT_READ + SECURITY_RIGHT_WRITE + SECURITY_RIGHT_DELETE).")");
                // метапредставления
                $metaViews = $this->sqlGetValueSet("SELECT id FROM metaview WHERE metaobject_id=$metaObjectID");
                if ($metaViews)
                {
                    foreach ($metaViews as $metaViewId)
                    {
                        $this->sqlQuery("INSERT INTO syssecurity (sysuser_id, metaobject_id, object_id, metaview_id, rights)
                            VALUES ({$this->groupId}, $metaObjectID, 0, $metaViewId, ".SECURITY_RIGHT_READ.")");
                    }
                }
            }
        }
        header('Location: /@contentico/Users/type='.self::TYPE_SECURITY.'/action='.ACTION_LIST.'/');
        exit;
    }

    /**
     * Удаление группы, пользователя, правила доступа
     *
     */
    private function deleteObject()
    {
        if ($this->type == self::TYPE_SECURITY)
        {
            $this->sqlQuery("DELETE FROM syssecurity WHERE id=".$this->id);
            exit;
        }
        else
        {
            if ($this->id > 2)
            {
                if ($this->type == self::TYPE_USERS)
                {
                    $_id = $this->sqlGetValue("SELECT _id FROM sysuser WHERE id=".$this->id);
                    $this->sqlQuery("DELETE FROM sysuser WHERE id=".$this->id);
                }
                else
                {
                    $this->sqlQuery("DELETE FROM sysuser WHERE id=".$this->id);
                    $this->sqlQuery("DELETE FROM sysuser WHERE _id=".$this->id);
                }
            }
            header('Location: /@contentico/Users/type='.self::TYPE_GROUPS.'/action='.ACTION_LIST.'/');
            exit;
        }
    }
}
?>