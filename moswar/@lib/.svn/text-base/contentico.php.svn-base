<?php
/**
 * Стандартные функции
 *
 */
class Contentico
{
    /**
     * Загрузка модуля
     *
     * @param string $Module
     */
    public static function loadModule($module)
    {
        if (!in_array('@'.$module, Runtime::$loadedLibs))
        {
            include('@contentico/@mod/'.strtolower($module).'.php');
            Runtime::$loadedLibs[] = '@'.$module;
        }
    }

    /**
     * Загрузка шаблона
     *
     * @param string $template
     * @return string
     */
    public static function loadTemplate($template)
    {
        return file_get_contents('@contentico/@tpl/'.strtolower($template).'.html');
    }

    /**
     * Вспомогательная функция для перевода списка параметров UIE из строки (как они задаются в project.xml) в массив
     *
     * @param unknown_type $paramsString
     * @return array
     */
    public static function paramsStringToArray($paramsString)
    {
        $params = array();
        $paramsList = explode(',', $paramsString);
        foreach ($paramsList as $param)
        {
            $param = explode('=', $param);
            $params[trim($param[0])] = trim($param[1]);
        }
        return $params;
    }
    
    /**
     * Генерация ссылка на страницу админки с авторизацией
     *
     * @param mixed $user
     * @param string $link
     * @return string
     */
    public static function generateExternalLink($user, $link)
    {
    	$sql = SqlDataSource::getInstance();
    	$user = $sql->getRecord("SELECT email, pwd FROM sysuser WHERE ".(is_int($user)?'id':'email')."='$user'");
    	return 'http://'.$_SERVER['HTTP_HOST'].'/@contentico/redirect/'.base64_encode(md5($user['email']).','.md5($user['pwd']).','.$link).'/';
    }

    /**
     * Получение значения настройки
     *
     * @param string $code
     * @return string
     */
    public static function getConfig($code)
    {
        $sql = SqlDataSource::getInstance();
        return $sql->getValue("SELECT value FROM sysconfig WHERE code='$code'");
    }

    /**
     * Сохранение значения настройки
     *
     * @param string $code
     * @param string $value
     */
    public static function setConfig($code, $value)
    {
        $sql = SqlDataSource::getInstance();
        $sql->getValue("UPDATE sysconfig SET value='$value' WHERE code='$code'");
    }

    /**
     * Значение для списка
     *
     * @param array $metaAttribute
     * @param mixed $value
     * @param int $objectId
     * @return string
     */
    public static function getListValue($metaAttribute, $value, $objectId=0)
    {
        $sql = SqlDataSource::getInstance();
        if ($metaAttribute['uie'])
        {
            Std::loadLib('ui.'.strtolower($metaAttribute['uie']));
            $ui =  $metaAttribute['uie'].'UIE';
            $ui = new $ui();
            $ui->setParams(self::paramsStringToArray($metaAttribute['uieparams']));
            $ui->setData($value);
            $value = $ui->getHtml();
        }
        else
        {
            Std::loadLib('HtmlTools');
            switch ($metaAttribute['type'])
            {
                case META_ATTRIBUTE_TYPE_INT:
                    $value = number_format($value, 0, '', ' ');
                    break;
                case META_ATTRIBUTE_TYPE_FLOAT:
                    $value = number_format($value, 2, '.', ' ');
                    break;
                case META_ATTRIBUTE_TYPE_STRING:
                    //$value = $value;
                    break;
                case META_ATTRIBUTE_TYPE_TEXT:
                case META_ATTRIBUTE_TYPE_BIGTEXT:
                    $value = strip_tags($value);
                    if (strlen($value) > 99)
                    {
                        $value = substr($value, 0, 99).'&hellip;';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_DATA:
                    $value = '<em>данные</em>';
                    break;
                case META_ATTRIBUTE_TYPE_DATETIME:
                case META_ATTRIBUTE_TYPE_DATE:
                    Std::loadLib('HtmlTools');
                    if ($value == '0000-00-00 00:00:00' || $value == '0000-00-00')
                    {
                        $value = '<em>нет</em>';
                    }
                    else
                    {
                        $value = HtmlTools::formatDateTime($value, true, false, true);
                    }
                    break;
                case META_ATTRIBUTE_TYPE_BOOL:
                    $value = $value ? 'Да' : 'Нет';
                    break;
                case META_ATTRIBUTE_TYPE_FILE:
                    if ($value)
                    {
                        $file = $sql->getRecord("SELECT path, name, size FROM stdfile WHERE id=$value");
                        $name = strlen($file['name']) > 20 ? substr($file['name'], 0, 20).'...' : $file['name'];
                        $value = '<a href="/@files/'.$file['path'].'" target="_blank">'.$name.'</a> ('.HtmlTools::formatFileSize($file['size']).')';
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_IMAGE:
                    if ($value)
                    {
                        $image = $sql->getRecord("SELECT path, name FROM stdimage WHERE id=$value");
                        $name = strlen($image['name']) > 20 ? substr($image['name'], 0, 20).'...' : $image['name'];
                        $value = '<a href="/@images/'.$image['path'].'" target="_blank">'.$name.'</a>';
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                    if ($value)
                    {
                        $exportMetaAttributeCode = $sql->getValue("
                        	SELECT 
                        		ma.code
                        	FROM
                        		metaattribute ma
                        		LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                        	WHERE
                        		sp.metaobject_id=(SELECT id FROM metaobject WHERE code='{$metaAttribute['typeparam']}')");
                        $name = $sql->getValue("SELECT `$exportMetaAttributeCode` FROM `{$metaAttribute['typeparam']}` WHERE id=$value");
                        $name = strlen($name) > 100 ? substr($name, 0, 100) . '&hellip;' : $name;
                        $value = '<a href="/@contentico/Metaobjects/'.$metaAttribute['typeparam'].'/id='.$value.'/action='.ACTION_VIEW.'/">'.$name.'</a>';
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    $exportAttribute = $sql->getValue("
                    	SELECT
                    		ma.code
                    	FROM
                    		metaattribute ma
                    		LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                        WHERE
                        	sp.metaobject_id=(SELECT id FROM metaobject WHERE code='{$metaAttribute['typeparam']}')");
                    $values = $sql->getRecordSet("
                    	SELECT
                    		id, mo.$exportAttribute name
                        FROM
                        	metalink ml
                        	LEFT JOIN `{$metaAttribute['typeparam']}` mo ON mo.id=ml.linkedobject_id
                        WHERE
                        	ml.metaattribute_id={$metaAttribute['id']}
                        	AND ml.object_id=".$objectId);
                    if ($values)
                    {
                        $value = array();
                        foreach ($values as $v)
                        {
                            $v['name'] = strlen($v['name']) > 100 ? substr($v['name'], 0, 100) . '&hellip;' : $v['name'];
                            $value[] = '<a href="/@contentico/Metaobjects/'.$metaAttribute['typeparam'].'/id='.$v['id'].'/action='.ACTION_VIEW.'/">'.$v['name'].'</a>';
                        }
                        $value = implode(', ', $value);
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_DICTIONARY:
                    if ($value == '')
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_CUSTOM:
                    //$value = $value;
                    break;
                case META_ATTRIBUTE_TYPE_PASSWORD:
                    $value = '*****';
                    break;
                case META_ATTRIBUTE_TYPE_QUERY:
                    $value = $sql->getValue(str_replace('$id', $objectId, $metaAttribute['typeparam']));
                    break;
            }
        }
        return $value;
    }

    /**
     * Значение для карточки
     *
     * @param array $metaAttribute
     * @param mixed $value
     * @param int $objectId
     * @return string
     */
    public static function getCardValue($metaAttribute, $value, $objectId=0)
    {
        $sql = SqlDataSource::getInstance();
        if ($metaAttribute['uie'])
        {
            Std::loadLib('ui.'.strtolower($metaAttribute['uie']));
            $ui = $metaAttribute['uie'].'UIE';
            $ui = new $ui();
            $ui->setParams(self::paramsStringToArray($metaAttribute['uieparams']));
            $ui->setData($value);
            $value = $ui->getHtml();
        }
        else
        {
            Std::loadLib('HtmlTools');
            switch ($metaAttribute['type'])
            {
                case META_ATTRIBUTE_TYPE_INT:
                    $value = number_format($value, 0, '', ' ');
                    break;
                case META_ATTRIBUTE_TYPE_FLOAT:
                    $value = number_format($value, 2, '.', ' ');
                    break;
                case META_ATTRIBUTE_TYPE_STRING:
                case META_ATTRIBUTE_TYPE_TEXT:
                case META_ATTRIBUTE_TYPE_BIGTEXT:
                    $value = $value;
                    break;
                case META_ATTRIBUTE_TYPE_DATA:
                    $value = '<em>данные</em>';
                    break;
                case META_ATTRIBUTE_TYPE_DATETIME:
                case META_ATTRIBUTE_TYPE_DATE:
                    if ($value == '0000-00-00 00:00:00' || $value == '0000-00-00')
                    {
                        $value = '<em>нет</em>';
                    }
                    else
                    {
                        $value = HtmlTools::formatDateTime($value);
                    }
                    break;
                case META_ATTRIBUTE_TYPE_BOOL:
                    $value = $value ? 'Да' : 'Нет';
                    break;
                case META_ATTRIBUTE_TYPE_FILE:
                    if ($value)
                    {
                        $file = $sql->getRecord("SELECT path, name, size FROM stdfile WHERE id=$value");
                        $value = '<a href="/@files/'.$file['path'].'" target="_blank">'.$file['name'].'</a> ('.HtmlTools::formatFileSize($file['size']).')';
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_IMAGE:
                    if ($value)
                    {
                        $image = $sql->getRecord("SELECT path, previewpath FROM stdimage WHERE id=$value");
                        $value = '<a href="/@images/'.$image['path'].'" target="_blank"><img src="/@images/'.$image['previewpath'].'" /></a>';
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                    if ($value)
                    {
                        $exportMetaAttributeCode = $sql->getValue("
                        	SELECT
                        		ma.code
                        	FROM
                        		metaattribute ma
                        		LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                            WHERE
                            	sp.metaobject_id=(SELECT id FROM metaobject WHERE code='{$metaAttribute['typeparam']}')");
                        $value = '<a href="/@contentico/Metaobjects/'.$metaAttribute['typeparam'].'/id='.$value.'/action='.ACTION_VIEW.'/">'.
                            $sql->getValue("SELECT `$exportMetaAttributeCode` FROM `{$metaAttribute['typeparam']}` WHERE id=$value").'</a>';
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    $exportAttribute = $sql->getValue("
                    	SELECT
                    		ma.code
                    	FROM
                    		metaattribute ma
                    		LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                        WHERE
                        	sp.metaobject_id=(SELECT id FROM metaobject WHERE code='{$metaAttribute['typeparam']}')");
                    $values = $sql->getRecordSet("
                    	SELECT
                    		id, mo.$exportAttribute name
                        FROM
                        	metalink ml
                        	LEFT JOIN `{$metaAttribute['typeparam']}` mo ON mo.id=ml.linkedobject_id
                        WHERE
                        	ml.metaattribute_id={$metaAttribute['id']}
                        	AND ml.object_id=".$objectId);
                    if ($values)
                    {
                        $value = array();
                        foreach ($values as $v)
                        {
                            $value[] = '<a href="/@contentico/Metaobjects/'.$metaAttribute['typeparam'].'/id='.$v['id'].'/action='.ACTION_VIEW.'/">'.$v['name'].'</a>';
                        }
                        $value = implode(', ', $value);
                    }
                    else
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_DICTIONARY:
                    if ($value == '')
                    {
                        $value = '<em>нет</em>';
                    }
                    break;
                case META_ATTRIBUTE_TYPE_CUSTOM:
                    //$value = $value;
                    break;
                case META_ATTRIBUTE_TYPE_PASSWORD:
                    $value = '*****';
                    break;
                case META_ATTRIBUTE_TYPE_QUERY:
                    $value = $sql->getValue(str_replace('$id', $objectId, $metaAttribute['typeparam']));
                    break;
            }
        }
        return $value;
    }

    /**
     * Элемент управления для формы
     *
     * @param array $metaAttribute
     * @return object
     */
    public static function getFormControl($metaAttribute)
    {
        $sql = SqlDataSource::getInstance();
        if ($metaAttribute['uie'])
        {
            Std::loadLib('ui.'.strtolower($metaAttribute['uie']));
            $ui = $metaAttribute['uie'].'UIE';
            $ui = new $ui();
            $ui->setParams(self::paramsStringToArray($metaAttribute['uieparams']));
        }
        else
        {
            $uieParams = self::paramsStringToArray($metaAttribute['uieparams']);
            switch ($metaAttribute['type'])
            {
                case META_ATTRIBUTE_TYPE_INT:
                case META_ATTRIBUTE_TYPE_FLOAT:
                    Std::loadLib('ui.textbox');
                    $ui = new TextboxUIE();
                    $uieParams['mask'] = $metaAttribute['mask'];
                    $ui->setParams($uieParams);
                    $ui->setAttributes(array('class'=>'numeric'));
                    break;
                case META_ATTRIBUTE_TYPE_STRING:
                    Std::loadLib('ui.textbox');
                    $ui = new TextboxUIE();
                    $uieParams['mask'] = $metaAttribute['mask'];
                    $ui->setParams($uieParams);
                    $ui->setAttributes(array('class'=>'wide'));
                    break;
                case META_ATTRIBUTE_TYPE_TEXT:
                case META_ATTRIBUTE_TYPE_BIGTEXT:
                    if ($sql->getValue("SELECT cfghtmlarea FROM sysuser WHERE id=".Runtime::$uid) == 1)
                    {
                        Std::loadLib('ui.htmlarea');
                        $ui = new HtmlareaUIE();
                        $ui->setParams($uieParams);
                        $ui->setAttributes(array('class'=>'ui-htmlarea wide'));
                    }
                    else
                    {
                        Std::loadLib('ui.textarea');
                        $ui = new TextareaUIE();
                        $ui->setParams($uieParams);
                        $ui->setAttributes(array('class'=>'wide'));
                    }
                    break;
                case META_ATTRIBUTE_TYPE_DATA:
                    break;
                case META_ATTRIBUTE_TYPE_DATETIME:
                    Std::loadLib('ui.calendar');
                    $ui = new CalendarUIE();
                    $ui->setParams($uieParams);
                    $ui->setAttributes(array('class'=>'wide'));
                    break;
                case META_ATTRIBUTE_TYPE_DATE:
                    Std::loadLib('ui.calendar');
                    $ui = new CalendarUIE();
                    $uieParams['time'] = 0;
                    $uieParams['format'] = 'd.m.Y';
                    $ui->setParams($uieParams);
                    $ui->setAttributes(array('class'=>'wide'));
                    break;
                case META_ATTRIBUTE_TYPE_BOOL:
                    Std::loadLib('ui.checkbox');
                    $ui = new CheckboxUIE();
                    $uieParams['label'] = $metaAttribute['name'];
                    $ui->setParams($uieParams);
                    break;
                case META_ATTRIBUTE_TYPE_FILE:
                    Std::loadLib('ui.file');
                    $ui = new FileUIE();
                    $ui->setParams($uieParams);
                    $ui->setAttributes(array('class'=>'wide'));
                    break;
                case META_ATTRIBUTE_TYPE_IMAGE:
                    Std::loadLib('ui.image');
                    $ui = new ImageUIE();
                    $ui->setParams($uieParams);
                    $ui->setAttributes(array('class'=>'wide'));
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                    Std::loadLib('ui.select');
                    $ui = new SelectUIE();
                    $linkedMetaObjectId = $sql->getValue("SELECT id FROM metaobject WHERE code='{$metaAttribute['typeparam']}'");
                    $export = $sql->getRecord("
                    	SELECT
                    		ma.code, sp.sortby, sp.sortorder
                        FROM
                        	metaattribute ma
                        	LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                        WHERE
                        	sp.metaobject_id=".$linkedMetaObjectId);
                    $selfLink = $sql->getValue("
                    	SELECT
                    		code
                    	FROM
                    		metaattribute
                    	WHERE
                    		metaobject_id=$linkedMetaObjectId
                        	AND type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT."
                        	AND typeparam='{$metaAttribute['typeparam']}'");
                    if ($selfLink)
                    {
                        $sort = $export['sortby'] != '' && $export['sortorder'] ? "ORDER BY `$selfLink` ASC, `{$export['sortby']}` {$export['sortorder']}" : '';
                        $advancedSecurity = $GLOBALS['config']['advancedsecurity'] ? "WHERE checkUserRightsOnObject($linkedMetaObjectId, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1" : '';
                        $values = $sql->getRecordSet("
                            SELECT
                            	id, `{$export['code']}` name, `$selfLink`
                            FROM
                            	`{$metaAttribute['typeparam']}`
                            $advancedSecurity
                            $sort
                            LIMIT 0, " . ($ui->maxCount + 1));
                        //
                        if ($values)
                        {
                            $parents = array(0);
                            $processed = array();
                            $options = array();
                            $space = 0;
                            $len = sizeof($values);
                            //
                            while (sizeof($parents) > 0)
                            {
                                $curParent = $parents[0];
                                $i = 0;
                                while ($i < $len)
                                {
                                    if ($values[$i]['_id'] == $curParent && !in_array($values[$i]['id'], $processed))
                                    {
                                        $processed[] = $values[$i]['id'];
                                        $name = $values[$i]['name'];
                                        $name = strlen($name) > 100 ? substr($name, 0, 100) . '&hellip;' : $name;
                                        $values[$i]['name'] = str_repeat(' -&nbsp;', $space).$name;
                                        $options[] = $values[$i];
                                        if (!in_array($values[$i]['id'], $parents))
                                        {
                                            array_unshift($parents, $values[$i]['id']);
                                            $space++;
                                            break;
                                        }
                                    }
                                    $i++;
                                }
                                if ($i == $len)
                                {
                                    array_shift($parents);
                                    $space--;
                                }
                            }
                        }
                        else
                        {
                            $options = false;
                        }
                        $uieParams['options'] = $options;
                        $uieParams['metaobject'] = $metaAttribute['typeparam'];
                        $uieParams['metaattribute'] = $export['code'];
                        $ui->setParams($uieParams);
                    }
                    else
                    {
                        $sort = $export['sortby'] != '' && $export['sortorder'] ? 'ORDER BY `'.$export['sortby'].'` '.$export['sortorder'] : '';
                        $advancedSecurity = $GLOBALS['config']['advancedsecurity'] ? "WHERE checkUserRightsOnObject($linkedMetaObjectId, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1" : '';
                        $values = $sql->getRecordSet("
                            SELECT
                            	id, `{$export['code']}` name
                            FROM
                            	`{$metaAttribute['typeparam']}`
                            $advancedSecurity
                            $sort
                            LIMIT 0, " . ($ui->maxCount + 1));
                        if ($values) {
                            foreach ($values as &$v) {
                                $v['name'] = strlen($v['name']) > 100 ? substr($v['name'], 0, 100) . '&hellip;' : $v['name'];
                            }
                        }
                        $uieParams['options'] = $values;
                        $uieParams['metaobject'] = $metaAttribute['typeparam'];
                        $uieParams['metaattribute'] = $export['code'];
                        $ui->setParams($uieParams);
                    }
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    Std::loadLib('ui.multiselect');
                    $ui = new MultiSelectUIE();
                    $linkedMetaObjectId = $sql->getValue("SELECT id FROM metaobject WHERE code='{$metaAttribute['typeparam']}'");
                    $export = $sql->getRecord("
                    	SELECT
                    		ma.code, sp.sortby, sp.sortorder
                        FROM
                        	metaattribute ma
                        	LEFT JOIN sysparams sp ON sp.export_metaattribute_id=ma.id
                        WHERE
                        	sp.metaobject_id=".$linkedMetaObjectId);
                    $sort = $export['sortby'] != '' && $export['sortorder'] ? 'ORDER BY '.$export['sortby'].' '.$export['sortorder'] : '';
                    $values = $sql->getRecordSet("SELECT id, `{$export['code']}` name FROM `{$metaAttribute['typeparam']}` $sort");
                    foreach ($values as &$v) {
                        $v['name'] = strlen($v['name']) > 100 ? substr($v['name'], 0, 100) . '&hellip;' : $v['name'];
                    }
                    $uieParams['options'] = $values;
                    $ui->setParams($uieParams);
                    break;
                case META_ATTRIBUTE_TYPE_DICTIONARY:
                    Std::loadLib('ui.select');
                    $ui = new SelectUIE();
                    $metaObject = $sql->getValue("
                    	SELECT
                    		mo.code
                    	FROM
                    		metaattribute ma 
                    		LEFT JOIN metaobject mo ON mo.id=ma.metaobject_id
                    	WHERE
                    		ma.id={$metaAttribute['id']}");
                    Std::loadMetaObjectClass($metaObject);
                    eval('$object = new '.$metaObject.'Object(); $values = $object->'.$metaAttribute['code'].'_Dictionary;');
                    $dictionary = array();
                    foreach ($values as $value)
                    {
                        if ($value != '')
                        {
                            $dictionary[$value] = $value;
                        }
                    }
                    $uieParams['options'] = $dictionary;
                    $ui->setParams($uieParams);
                    if ($metaAttribute['defaultvalue'] != '')
                    {
                        $ui->setDefaultValue($metaAttribute['defaultvalue']);
                    }
                    break;
                case META_ATTRIBUTE_TYPE_CUSTOM:
                    break;
                case META_ATTRIBUTE_TYPE_PASSWORD:
                    Std::loadLib('ui.textbox');
                    $ui = new TextboxUIE();
                    $uieParams['password'] = 1;
                    $ui->setParams($uieParams);
                    $ui->setAttributes(array('class'=>'wide'));
                    break;
                case META_ATTRIBUTE_TYPE_QUERY:
                    Std::loadLib('ui.label');
                    $ui = new LabelUIE();
                    $ui->setParams($uieParams);
                    break;
            }
        }
        $ui->setName($metaAttribute['code']);
        return $ui;
    }

    /**
     * Список CSS классов для визуального редактора
     *
     * @return unknown
     */
    public static function uiHtmlareaGetStyleSelect()
    {
        $css = file_get_contents('@/css/content.css');
        preg_match('/\/\*\*(.*?)\*\*\//ism', $css, $styles);
        return str_replace("\n", '', $styles[1]);
    }
}

/**
 * Представление
 *
 */
class ContenticoView
{
    private $sql;
    
    public $trTemplate;
    public $isCustomTrTemplate = 0;
    public $tableTemplate;
    public $isCustomTableTemplate = 0;
    public $metaViewId;
    public $metaViewRights;
    public $metaObjectId;
    public $metaObjectCode;
    public $metaObjectRights;
    public $metaAttributes;
    public $params;
    public $parent;
    public $views;
    public $viewSelectTemplate;
    public $action;
    public $objectId;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    /**
     * Загрузка полей метапредставления
     *
     */
    public function loadMetaAttributes()
    {
        $this->metaAttributes = $this->sqlGetRecordSet("
            SELECT
            	ma.id, ma.code, ma.type, ma.typeparam, mvf.name, mvf.uie, mvf.uieparams, mvf.defaultvalue, mvf.hint, mvf.unit, mvf.mask, mvf.group
            FROM
            	metaviewfield mvf
                LEFT JOIN metaattribute ma ON ma.id=mvf.metaattribute_id
            WHERE
            	mvf.metaview_id={$this->metaViewId}
            ORDER BY
            	mvf.pos ASC");
    }

    /**
     * Получение кода метаатрибута ID
     *
     * @return string
     */
    protected function getIdMetaAttributeCode()
    {
        Std::loadMetaObjectClass($this->metaObjectCode);
        $className = $this->metaObjectCode.'Object';
        $classVars = get_class_vars($className);
        return $classVars['ID_METAATTRIBUTE'];
    }

    /**
     * Определение метапредставления
     *
     * @param int $type
     */
    protected function getMetaView($type)
    {
        if ($this->metaViewId)
        {
            $this->metaViewRights = $this->sqlGetValue("
            	SELECT
            		max(rights)
            	FROM
            		syssecurity
            	WHERE
            		metaobject_id={$this->metaObjectId}
                	AND metaview_id={$this->metaViewId}
                	AND sysuser_id=".Runtime::$gid);
            $metaViewType = $this->sqlGetValue("SELECT type FROM metaview WHERE id=".$this->metaViewId);
            if (!$this->metaViewRights || $metaViewType != $type)
            {
                $this->metaViewId = 0;
            }
        }
        if (!$this->metaViewId)
        {
            $metaView = $this->sqlGetRecord("
                SELECT mv.id,
                    (SELECT max(rights) FROM syssecurity WHERE (metaobject_id={$this->metaObjectId} OR metaobject_id=0)
                        AND (metaview_id=mv.id OR metaview_id=0) AND sysuser_id=".Runtime::$gid.") rights
                FROM
                	metaview mv
                WHERE
                	mv.metaobject_id={$this->metaObjectId}
                	AND mv.type=$type
                    AND (SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND metaview_id=mv.id AND sysuser_id=".Runtime::$gid.") > 0");
            if (!$metaView)
            {
                header('Location: /@contentico/Auth/accessdenied/');
                exit;
            }
            $this->metaViewId = $metaView['id'];
            $this->metaViewRights = $metaView['rights'];
        }
    }

    /**
     * Загрузка списка доступных представлений
     *
     * @param int $type
     */
    protected function loadViews($type)
    {
        $this->views = $this->sqlGetRecordSet("
            SELECT
            	mv.id, mv.name
            FROM
            	metaview mv
            WHERE
            	mv.name!=''
            	AND mv.metaobject_id={$this->metaObjectId}
            	AND mv.type=$type
                AND (SELECT max(rights) FROM syssecurity WHERE metaobject_id={$this->metaObjectId} AND sysuser_id=".Runtime::$gid." AND metaview_id=mv.id) > 0");
    }

    /**
     * Генерация select'а метапредставлений
     *
     * @return string
     */
    protected function generateViews()
    {
        if (sizeof($this->views) > 1)
        {
            $views = '';
            foreach ($this->views as $view)
            {
                $views .= '<option value="'.$view['id'].'" '.($view['id'] == $this->metaViewId ? 'selected="selected"' : '').'>'.$view['name'].'</option>';
            }
            $views = Std::renderTemplate($this->viewSelectTemplate, array(
                'options' => $views,
                'metaobject' => $this->metaObjectCode,
                'action' => $this->action,
                'id'=>$this->objectId,
            ));
        }
        else
        {
            $views = '';
        }
        return $views;
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
}

/**
 * Представление: Форма
 *
 */
class ContenticoViewForm extends ContenticoView
{
    public $object;
    public $fields;
    public $pageTitle = false;
    public $returnToPage;
    public $returnToView;
    public $actionUrl;
    public $cannot_insert;//не смог скопировать
    public $hintTemplate;
    public $unitTemplate;
    public $templateGroup;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Загрузка шаблонов
     *
     */
    public function loadTemplates()
    {
        $templates = $this->sqlGetRecord("SELECT template, templaterow FROM metaview WHERE id=".$this->metaViewId);
        if ($templates['template'] == '')
        {
            $this->tableTemplate = Contentico::loadTemplate('form/table');
        }
        else
        {
            $this->tableTemplate = stripslashes($templates['template']);
            $this->isCustomTableTemplate = true;
        }
        if ($templates['templaterow'] == '')
        {
            $this->trTemplate = Contentico::loadTemplate('form/tr');
        }
        else
        {
            $this->trTemplate = stripslashes($templates['templaterow']);
            $this->isCustomTrTemplate = true;
        }
        $this->hintTemplate = Contentico::loadTemplate('form/hint');
        $this->unitTemplate = Contentico::loadTemplate('form/unit');
        $this->viewSelectTemplate = Contentico::loadTemplate('form/view-select');
        $this->templateGroup = Contentico::loadTemplate('form/fieldgroup');
    }

    /**
     * Генерация формы
     *
     */
    public function generate()
    {
		$this->getMetaView(META_VIEW_TYPE_FORM);
		//		
        $this->loadMetaAttributes();
		//
        $this->loadTemplates();
		//
        $this->loadViews(META_VIEW_TYPE_FORM);
		//
        $this->generateFields();		
    }

    /**
     * Генерация полей формы
     *
     */
    public function generateFields()
    {
        $metaAttributesList = array();
        foreach ($this->metaAttributes as $metaAttribute)
        {
            if ($metaAttribute['type'] != META_ATTRIBUTE_TYPE_LINKTOOBJECTS && $metaAttribute['type'] != META_ATTRIBUTE_TYPE_QUERY)
            {
                $metaAttributesList[] = "`{$metaAttribute['code']}`";
            }
        }
        $metaAttributesList = implode(', ', $metaAttributesList);
        //
        if ($this->action == ACTION_EDIT)
        {
            $advancedSecurity = $GLOBALS['config']['advancedsecurity'] ? "AND checkUserRightsOnObject({$this->metaObjectId}, " . $this->getIdMetaAttributeCode() . ", ".Runtime::$gid.", ".SECURITY_RIGHT_WRITE.")=1" : '';
            $this->object = $this->sqlGetRecord("
                SELECT
                	$metaAttributesList
                FROM
                	`{$this->metaObjectCode}`
                WHERE
                	" . $this->getIdMetaAttributeCode() . "={$this->objectId}
                	".$advancedSecurity);
            if (!$this->object)
            {
                header('Location: /@contentico/Auth/accessdenied/');
                exit;
            }
        }
        
        //если произошла ошибка копирования
        if ($this->cannot_insert)
        {
            $this->object = $_SESSION['@contentico']['cannotinsert'];
        }
        else
        {
            unset($_SESSION['@contentico']['cannotinsert']);
        }

        foreach ($this->metaAttributes as $metaAttribute)
        {
            $ui = Contentico::getFormControl($metaAttribute);
            if ($this->action == ACTION_EDIT || $this->cannot_insert)
            {
                if ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_LINKTOOBJECTS)
                {
                    $ui->setData($this->sqlGetValueSet("SELECT linkedobject_id FROM metalink WHERE metaattribute_id={$metaAttribute['id']} AND object_id=".$this->objectId));
                }
                elseif ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_QUERY)
                {
                    $value = $this->sqlGetValue(str_replace('$id', $this->objectId, $metaAttribute['typeparam']));
                    $ui->setData($value ? $value : '&mdash;');
                }
                else
                {
                    $ui->setData($this->object[$metaAttribute['code']]);
                }
            }
            else
            {
                if ($metaAttribute['type'] != META_ATTRIBUTE_TYPE_LINKTOOBJECTS && $metaAttribute['type'] != META_ATTRIBUTE_TYPE_QUERY)
                {
                    $setValue = true;
                    if ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_LINKTOOBJECT)
                    {
                        if ($this->parent)
                        {
                            foreach ($this->parent as $parent)
                            {
                                if ($metaAttribute['code'] == $parent['metaattribute'] && $metaAttribute['typeparam'] == $parent['metaobject'])
                                {
                                    $ui->setData($parent['id']);
                                    $setValue = false;
                                }
                            }
                        }
                    }
                    if ($setValue)
                    {
                        $ui->setData($metaAttribute['defaultvalue']);
                    }
                }
                elseif ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_QUERY)
                {
                    $ui->setData($this->sqlGetValue(str_replace('$id', 0, $metaAttribute['typeparam'])));
                }
            }
            $this->fields[$metaAttribute['code']] = array(
                'name' => $metaAttribute['type'] == META_ATTRIBUTE_TYPE_BOOL ? '' : $metaAttribute['name'].':',
                'control' => $ui,
                'hint' => $metaAttribute['hint'],
                'unit' => $metaAttribute['unit'],
                'group' => $metaAttribute['group'],
            );
            if ($metaAttribute['id'] == $this->params['export_metaattribute_id'] && $this->object[$metaAttribute['code']] != '')
            {
                $this->pageTitle = Contentico::getCardValue($metaAttribute, $this->object[$metaAttribute['code']], $this->objectId);
                if (strlen($this->pageTitle) > 100) {
                    $this->pageTitle = substr($this->pageTitle, 0, 100) . '&hellip';
                }
            }
        }
        //
        $this->actionUrl = $this->metaObjectCode.'/action='.$this->action.($this->action == ACTION_EDIT ? '/id='.$this->objectId : '');
    }

    /**
     * Генерация HTML
     *
     * @return string
     */
    public function  getHtml()
    {
        if ($this->isCustomTableTemplate)
        {
            $fields = array();
            foreach ($this->fields as $metaAttributeCode=>$field)
            {
                $fields[$metaAttributeCode] = Std::renderTemplate($this->trTemplate, array(
                    'control' => $field['control']->getHtml(),
                    'unit' => $field['unit'] ? Std::renderTemplate($this->unitTemplate, array('unit'=>$field['unit'])) : '',
                ));
            }
            $this->tableTemplate = Std::renderTemplate($this->tableTemplate, $fields);
        }
        else
        {
            $tr = '';
            foreach ($this->fields as $metaAttributeCode=>$field)
            {
                $tr .= Std::renderTemplate($this->trTemplate, array(
                    'name' => $field['name'],
                    'control' => $field['control']->getHtml(),
                    'hint' => $field['hint'] ? Std::renderTemplate($this->hintTemplate, array('hint'=>$field['hint'])) : '',
                    'unit' => $field['unit'] ? Std::renderTemplate($this->unitTemplate, array('unit'=>$field['unit'])) : '',
                    'group' => $field['group'] ? Std::renderTemplate($this->templateGroup, array('name'=>$field['group'])) : '',
                ));
            }
        }

        $copyBtn = $this->objectId ? '<input class="cancel" type="button" value="Копировать" onclick="GoCopy();" />' : '';
        return Std::renderTemplate($this->tableTemplate, array(
            'tr' => $tr,
            'copy-button' => $copyBtn ,
            'action-url' => $this->actionUrl,
            '-page' => $this->returnToPage,
            '-view' => $this->returnToView,
            'ui-htmlarea-init' => Std::renderTemplate(Contentico::loadTemplate('ui.htmlarea'), array(
                'style-select' => Contentico::uiHtmlareaGetStyleSelect(),
            )),
            'view-select' => $this->generateViews(),
            'metaview' => $this->metaViewId,
            'parent' => $this->parent ? '<input type="hidden" name="'.$this->parent['metaattribute'].'" value="'.$this->parent['id'].'" />' : '',
        ));
    }
}

/**
 * Представление: Форма
 *
 */
class ContenticoViewQuickForm extends ContenticoViewForm
{
    public $returnUrl;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Загрузка шаблонов
     *
     */
    public function loadTemplates()
    {
        parent::loadTemplates();
        $templates = $this->sqlGetRecord("SELECT template, templaterow FROM metaview WHERE id=".$this->metaViewId);
        if ($templates['template'] == '')
        {
            $this->tableTemplate = Contentico::loadTemplate('form/quick-table');
        }
        else
        {
            $this->tableTemplate = stripslashes($templates['template']);
            $this->isCustomTableTemplate = true;
        }
        if ($templates['templaterow'] == '')
        {
            $this->trTemplate = Contentico::loadTemplate('form/tr');
        }
        else
        {
            $this->trTemplate = stripslashes($templates['templaterow']);
            $this->isCustomTrTemplate = true;
        }
    }

    /**
     * Генерация формы
     *
     */
    public function generate()
    {
        $this->getMetaView(META_VIEW_TYPE_QUICKFORM);
        //
        $this->loadMetaAttributes();
        //
        $this->loadTemplates();
        //
        $this->generateFields();
    }

    /**
     * Генерация HTML
     *
     * @return string
     */
    public function getHtml()
    {
        $formHtml = Std::renderTemplate(parent::getHtml(), array(
            'return-url' => '<input type="hidden" name="returnurl" value="'.$this->returnUrl.'" />',
        ));
        return $formHtml;
    }
}

/**
 * Представление: Карточка
 *
 */
class ContenticoViewCard extends ContenticoView
{
    public $object;
    public $fields;
    public $pageTitle = false;
    public $returnToPage;
    public $returnToView;
    public $unitTemplate;
    public $templateGroup;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Генерация объектов
     *
     */
    public function generate()
    {
        $this->getMetaView(META_VIEW_TYPE_CARD);
        //
        $this->loadMetaAttributes();
        // загрузка шаблонов
        $templates = $this->sqlGetRecord("SELECT template, templaterow FROM metaview WHERE id=".$this->metaViewId);
        if ($templates['template'] == '')
        {
            $this->tableTemplate = Contentico::loadTemplate('card/table');
        }
        else
        {
            $this->tableTemplate = stripslashes($templates['template']);
            $this->isCustomTableTemplate = true;
        }
        if ($templates['templaterow'] == '')
        {
            $this->trTemplate = Contentico::loadTemplate('card/tr');
        }
        else
        {
            $this->trTemplate = stripslashes($templates['templaterow']);
            $this->isCustomTrTemplate = true;
        }
        $this->unitTemplate = Contentico::loadTemplate('form/unit');
        $this->viewSelectTemplate = Contentico::loadTemplate('form/view-select');
        $this->templateGroup = Contentico::loadTemplate('form/fieldgroup');
        //
        $this->loadViews(META_VIEW_TYPE_CARD);
        //
        $metaAttributesList = array();
        foreach ($this->metaAttributes as $metaAttribute)
        {
            if ($metaAttribute['type'] != META_ATTRIBUTE_TYPE_LINKTOOBJECTS && $metaAttribute['type'] != META_ATTRIBUTE_TYPE_QUERY)
            {
                $metaAttributesList[] = "`{$metaAttribute['code']}`";
            }
        }
        $metaAttributesList = implode(', ', $metaAttributesList);
        //
        $advancedSecurity = $GLOBALS['config']['advancedsecurity'] ? "AND checkUserRightsOnObject({$this->metaObjectId}, " . $this->getIdMetaAttributeCode() . ", ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1" : '';
        $this->object = $this->sqlGetRecord("
            SELECT
            	$metaAttributesList
            FROM
            	`{$this->metaObjectCode}`
            WHERE
            	" . $this->getIdMetaAttributeCode() . "={$this->objectId}
            	".$advancedSecurity);
        if (!$this->object)
        {
            header('Location: /@contentico/Auth/accessdenied/');
            exit;
        }
        //
        foreach ($this->metaAttributes as $metaAttribute)
        {
            $this->fields[$metaAttribute['code']] = array(
                'name'=>$metaAttribute['name'].':',
                'value'=>Contentico::getCardValue($metaAttribute, $this->object[$metaAttribute['code']], $this->objectId),
                'unit'=>$metaAttribute['unit'],
                'group' => $metaAttribute['group'],
            );
            if ($metaAttribute['id'] == $this->params['export_metaattribute_id'] && $this->object[$metaAttribute['code']] != '')
            {
                $this->pageTitle = Contentico::getCardValue($metaAttribute, $this->object[$metaAttribute['code']], $this->objectId);
                if (strlen($this->pageTitle) > 100) {
                    $this->pageTitle = substr($this->pageTitle, 0, 100) . '&hellip';
                }
            }
        }
    }

    /**
     * Генерация HTML
     *
     * @return string
     */
    public function getHtml()
    {
        $tr = '';
        if ($this->isCustomTableTemplate)
        {
            $fields = array();
            foreach ($this->fields as $metaAttributeCode=>$field)
            {
                $fields[$metaAttributeCode] = Std::renderTemplate($this->trTemplate, array(
                    'value'=>$field['value'],
                    'unit'=>$field['unit'] ? Std::renderTemplate($this->unitTemplate, array('unit'=>$field['unit'])) : '',
                ));
            }
            $this->tableTemplate = Std::renderTemplate($this->tableTemplate, $fields);
        }
        else
        {
            foreach ($this->fields as $metaAttributeCode=>$field)
            {
                $tr .= Std::renderTemplate($this->trTemplate, array(
                    'name'=>$field['name'],
                    'value'=>$field['value'],
                    'unit'=>$field['unit'] ? Std::renderTemplate($this->unitTemplate, array('unit'=>$field['unit'])) : '',
                    'group' => $field['group'] ? Std::renderTemplate($this->templateGroup, array('name'=>$field['group'])) : '',
                ));
            }
        }
        $objectRights = $this->sqlGetValue("
        	SELECT
        		rights
        	FROM
        		syssecurity
        	WHERE
        		metaobject_id={$this->metaObjectId}
        		AND metaview_id=0
        		AND (object_id=0 OR object_id={$this->objectId})");
        return Std::renderTemplate($this->tableTemplate, array(
            'tr'=>$tr,
            '-page'=>$this->returnToPage,
            '-view'=>$this->returnToView,
            'ACTION_EDIT'=>ACTION_EDIT,
            'ACTION_DELETE'=>ACTION_DELETE,
            'ACTION_LIST'=>ACTION_LIST,
            'id'=>$this->objectId,
            'metaobject'=>$this->metaObjectCode,
            'view-select'=>$this->generateViews(),
            'delete-button' => $objectRights & SECURITY_RIGHT_DELETE ? '<input class="delete" type="submit" value="Удалить" onclick="if(window.confirm(\'Подтвердите удаление.\')){document.location.href=\'/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_DELETE.'/-page='.$this->returnToPage.'/-view='.$this->returnToView.'/id='.$this->objectId.'/\';}"/>' : '',
            'edit-button' => $objectRights & SECURITY_RIGHT_DELETE ? '<input class="edit" type="submit" value="Редактировать" onclick="document.location.href=\'/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_EDIT.'/-page='.$this->returnToPage.'/-view='.$this->returnToView.'/id='.$this->objectId.'/\';" />' : '',
        ));
    }
}

/**
 * Представление: Список
 *
 */
class ContenticoViewList extends ContenticoView
{
    private $childMetaObjects;
    
    public $data;
    public $parent;
    public $headers = array();
    public $rows = array();
    public $sctions = false;
    public $sortBy;
    public $sortOrder;
    public $sort = '';
    public $offset;
    public $rowsPerPage = 15;
    public $filters = array();
    public $conditions = array();
    public $totalRows;
    public $metaAttributesList = array();
    public $listPage;
    public $metaObjectRights;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Прегенерация объектов - условия, фильтры
     *
     */
    public function preGenerate()
    {
        $this->getMetaView(META_VIEW_TYPE_LIST);
        //
        $this->loadMetaAttributes();
        // загрузка шаблонов
        $templates = $this->sqlGetRecord("SELECT template, templaterow FROM metaview WHERE id=".$this->metaViewId);
        if ($templates['template'] == '')
        {
            $this->tableTemplate = Contentico::loadTemplate('list/table');
        }
        else
        {
            $this->tableTemplate = stripslashes($templates['template']);
            $this->isCustomTableTemplate = true;
        }
        if ($templates['templaterow'] == '')
        {
            $this->trTemplate = Contentico::loadTemplate('list/tr');
        }
        else
        {
            $this->trTemplate = stripslashes($templates['templaterow']);
            $this->isCustomTrTemplate = true;
        }
        $this->viewSelectTemplate = Contentico::loadTemplate('list/view-select');
        //
        $this->loadViews(META_VIEW_TYPE_LIST);
        $this->generateActions();
        //
        $this->metaAttributesList[] = $this->getIdMetaAttributeCode() . " 'id'";
        $filters = array();
        foreach ($this->metaAttributes as $metaAttribute)
        {
            if ($metaAttribute['type'] != META_ATTRIBUTE_TYPE_LINKTOOBJECTS && $metaAttribute['type'] != META_ATTRIBUTE_TYPE_FILE && $metaAttribute['type'] != META_ATTRIBUTE_TYPE_IMAGE)
            {
                $sort = '
                    <div class="sort">
                        <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/sortby='.$metaAttribute['code'].'/sortorder=asc/" title="Сортировать по возрастанию"><img src="/@contentico/@img/ico/sort_asc'.($this->sortBy == $metaAttribute['code'] && $this->sortOrder == 'asc' ? '_cur' : '').'.gif" style="top:2px;" /></a>
                        <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/sortby='.$metaAttribute['code'].'/sortorder=desc/" title="Сортировать по убыванию"><img src="/@contentico/@img/ico/sort_desc'.($this->sortBy == $metaAttribute['code'] && $this->sortOrder == 'desc' ? '_cur' : '').'.gif" style="top:8px;" /></a>
                    </div>
                ';
                $name = '<span>'.$metaAttribute['name'].'</span>';
            }
            else
            {
                $sort = '';
                $name = $metaAttribute['name'];
            }
            if ($metaAttribute['type'] != META_ATTRIBUTE_TYPE_LINKTOOBJECTS && $metaAttribute['type'] != META_ATTRIBUTE_TYPE_QUERY)
            {
                $this->metaAttributesList[] = "`{$metaAttribute['code']}`";
                //
                switch ($metaAttribute['type'])
                {
                    case META_ATTRIBUTE_TYPE_INT:
                    case META_ATTRIBUTE_TYPE_FLOAT:
                        $filterFrom = '<input type="text" name="'.$metaAttribute['code'].'-from" value="'.$this->filters[$metaAttribute['code'].'-from'].'" class="wide" style="width:70px;" />';
                        if ($this->filters[$metaAttribute['code'].'-from'])
                        {
                            $filters[$metaAttribute['code'].'-from'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`>='{$this->filters[$metaAttribute['code'].'-from']}'",
                            );
                        }
                        $filterTill = '<input type="text" name="'.$metaAttribute['code'].'-till" value="'.$this->filters[$metaAttribute['code'].'-till'].'" class="wide" style="width:70px;" />';
                        if ($this->filters[$metaAttribute['code'].'-till'])
                        {
                            $filters[$metaAttribute['code'].'-till'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`<='{$this->filters[$metaAttribute['code'].'-till']}'",
                            );
                        }
                        $filter = $filterFrom.' &mdash; '.$filterTill;
                        $filterWidth = 200;
                        break;
                    case META_ATTRIBUTE_TYPE_STRING:
                    case META_ATTRIBUTE_TYPE_TEXT:
                    case META_ATTRIBUTE_TYPE_BIGTEXT:
                        $filter = '<input type="text" name="'.$metaAttribute['code'].'" value="'.$this->filters[$metaAttribute['code']].'" class="wide" style="width:120px;" />';
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
                        Std::loadLib('ui.calendar');
                        $ui = new CalendarUIE();
                        $ui->setParams(array('time'=>1,'format'=>'d.m.Y H:i'));
                        $ui->setAttributes(array('class'=>'wide','style'=>'width:80px;'));
                        $ui->setName($metaAttribute['code'].'-from');
                        $ui->setData($this->filters[$metaAttribute['code'].'-from']);
                        if ($this->filters[$metaAttribute['code'].'-from'])
                        {
                            $filters[$metaAttribute['code'].'-from'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`>='{$this->filters[$metaAttribute['code'].'-from']}'",
                            );
                        }
                        $ui2 = new CalendarUIE();
                        $ui2->setParams(array('time'=>1,'format'=>'d.m.Y H:i'));
                        $ui2->setAttributes(array('class'=>'wide','style'=>'width:80px;'));
                        $ui2->setName($metaAttribute['code'].'-till');
                        $ui2->setData($this->filters[$metaAttribute['code'].'-till']);
                        if ($this->filters[$metaAttribute['code'].'-till'])
                        {
                            $filters[$metaAttribute['code'].'-till'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`<='{$this->filters[$metaAttribute['code'].'-till']}'",
                            );
                        }
                        $filter = $ui->getHtml().' &mdash; '.$ui2->getHtml();
                        $filterWidth = 250;
                        break;
                    case META_ATTRIBUTE_TYPE_DATE:
                        Std::loadLib('ui.calendar');
                        $ui = new CalendarUIE();
                        $ui->setParams(array('time'=>0,'format'=>'d.m.Y'));
                        $ui->setAttributes(array('class'=>'wide','style'=>'width:80px;'));
                        $ui->setName($metaAttribute['code'].'-from');
                        $ui->setData($this->filters[$metaAttribute['code'].'-from']);
                        if ($this->filters[$metaAttribute['code'].'-from'])
                        {
                            $filters[$metaAttribute['code'].'-from'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`>='{$this->filters[$metaAttribute['code'].'-from']}'",
                            );
                        }
                        $ui2 = new CalendarUIE();
                        $ui2->setParams(array('time'=>0,'format'=>'d.m.Y'));
                        $ui2->setAttributes(array('class'=>'wide','style'=>'width:80px;'));
                        $ui2->setName($metaAttribute['code'].'-till');
                        $ui2->setData($this->filters[$metaAttribute['code'].'-till']);
                        if ($this->filters[$metaAttribute['code'].'-till'])
                        {
                            $filters[$metaAttribute['code'].'-till'] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`<='{$this->filters[$metaAttribute['code'].'-till']}'",
                            );
                        }
                        $filter = $ui->getHtml().' &mdash; '.$ui2->getHtml();
                        $filterWidth = 250;
                        break;
                    case META_ATTRIBUTE_TYPE_BOOL:
                        $filter = '
                            <input type="checkbox" name="'.$metaAttribute['code'].'-yes" id="'.$metaAttribute['code'].'-yes" '.($this->filters[$metaAttribute['code'].'-yes'] ? 'checked="checked"' : '').' />
                            <label for="'.$metaAttribute['code'].'-yes">Да</label>
                            <input type="checkbox" name="'.$metaAttribute['code'].'-no" id="'.$metaAttribute['code'].'-no" '.($this->filters[$metaAttribute['code'].'-no'] ? 'checked="checked"' : '').' />
                            <label for="'.$metaAttribute['code'].'-no">Нет</label>
                        ';
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
                        $filterWidth = 130;
                        break;
                    case META_ATTRIBUTE_TYPE_FILE:
                    case META_ATTRIBUTE_TYPE_IMAGE:
                        $filter = '
                            <input type="checkbox" name="'.$metaAttribute['code'].'-yes" id="'.$metaAttribute['code'].'-yes" '.($this->filters[$metaAttribute['code'].'-yes'] ? 'checked="checked"' : '').' />
                            <label for="'.$metaAttribute['code'].'-yes">Имеется</label>
                            <input type="checkbox" name="'.$metaAttribute['code'].'-no" id="'.$metaAttribute['code'].'-no" '.($this->filters[$metaAttribute['code'].'-no'] ? 'checked="checked"' : '').' />
                            <label for="'.$metaAttribute['code'].'-no">Отсутствует</label>
                        ';
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
                        $filterWidth = 210;
                        break;
                    case META_ATTRIBUTE_TYPE_DICTIONARY:
                        Std::loadLib('ui.select');
                        $ui = new SelectUIE();
                        //
                        $metaObject = $this->sqlGetValue("SELECT mo.code FROM metaattribute ma LEFT JOIN metaobject mo ON mo.id=ma.metaobject_id WHERE ma.id={$metaAttribute['id']}");
                        Std::loadMetaObjectClass($metaObject);
                        eval('$object = new '.$metaObject.'Object(); $values = $object->'.$metaAttribute['code'].'_Dictionary;');
                        $dictionary = array();
                        foreach ($values as $value)
                        {
                            if ($value != '')
                            {
                                $dictionary[$value] = $value;
                            }
                        }
                        //
                        $ui->setParams(array('options'=>$dictionary));
                        $ui->setName($metaAttribute['code']);
                        $ui->setData($this->filters[$metaAttribute['code']]);
                        $ui->setAttributes(array('style'=>'width:150px;'));
                        $filter = $ui->getHtml();
                        if ($this->filters[$metaAttribute['code']])
                        {
                            $filters[$metaAttribute['code']] = array(
                                'value' => $this->filters[$metaAttribute['code']],
                                'condition' => "`{$metaAttribute['code']}`='{$this->filters[$metaAttribute['code']]}'",
                            );
                        }
                        $filterWidth = 190;
                        break;
                    case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                        $filter = '<input type="text" name="'.$metaAttribute['code'].'" value="'.$this->filters[$metaAttribute['code']].'" class="wide" style="width:120px;" />';
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
                        $filter = '';
                        break;
                }
                if ($filter != '')
                {
                    $filter = '
                        <img src="/@contentico/@img/ico/filter'.($this->filters[$metaAttribute['code']] ? '_cur' : '').'.gif" align="absmiddle" class="filter" onclick="if($(\'#'.$metaAttribute['code'].'-filter-div\')[0].style.display==\'block\'){$(\'#'.$metaAttribute['code'].'-filter-div\').hide(\'fast\');}else{$(\'div.filter\').hide();$(\'#'.$metaAttribute['code'].'-filter-div\').toggle(\'fast\');}" alt="Фильтр" title="Фильтр" />
                        <div id="'.$metaAttribute['code'].'-filter-div" class="filter" style="width:'.$filterWidth.';">
                            <form action="/@contentico/Metaobjects/'.$this->metaObjectCode.'/filter/" method="post">
                            <input type="hidden" name="metaattribute_id" value="'.$metaAttribute['id'].'" />
                                '.$filter.'
                                <input type="image" src="/@contentico/@img/ico/apply.gif" />
                            </form>
                        </div>
                    ';
                }
            }
            $this->headers[$metaAttribute['code']] = array(
                'sort' => $sort,
                'name' => $name,
                'filter' => $filter,
            );
            $filter = '';
        }
        $this->filters = $filters;
        $this->metaAttributes = array_merge(array(array('code'=>'id')), $this->metaAttributes);
        //
        $this->childMetaObjects = $this->sqlGetRecordSet("
            SELECT
            	mo.id, mo.code metaobject, sp.name, ma.code metaattribute
            FROM metaattribute ma
                LEFT JOIN metaobject mo ON mo.id=ma.metaobject_id
                LEFT JOIN sysparams sp ON sp.metaobject_id=mo.id
                LEFT JOIN syssecurity ss ON ss.metaobject_id=mo.id AND metaview_id=0 AND sysuser_id=".Runtime::$gid."
            WHERE
            	ss.rights>0
            	AND ma.type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT."
            	AND ma.typeparam='{$this->metaObjectCode}'
            ORDER BY
            	sp.menupos ASC");
        if ($this->childMetaObjects)
        {
            $this->headers['childmetaobjects'] = array('sort'=>'', 'name'=>'Дочерние документы', 'filter'=>'');
        }
        //
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
                $this->conditions[] = array(
                    'code' => $condition['code'],
                    'operation' => $operation,
                    'value' => $value,
                    'sql' => $condition['sql'],
                );
            }
        }
        //
        $this->sort = $this->sortBy != '' && $this->sortOrder != '' ? "ORDER BY {$this->sortBy} {$this->sortOrder}" : '';
    }

    /**
     * Генерация объектов
     *
     */
    public function generate()
    {
        $where = array();
        if (sizeof($this->conditions) > 0)
        {
            foreach ($this->conditions as $condition)
            {
                $value = $condition['value'] == '' ? $condition['sql'] : "'".$condition['value']."'";
                $where[] = "`{$condition['code']}`{$condition['operation']}$value";
            }
        }
        //
        if (sizeof($this->filters) > 0)
        {
            foreach ($this->filters as $filter)
            {
                $where[] = $filter['condition'];
            }
        }
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
        //
        if ($GLOBALS['config']['advancedsecurity'])
        {
            $where[] = "checkUserRightsOnObject({$this->metaObjectId}, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1";
        }
        //
        $where = sizeof($where) > 0 ? 'WHERE '.implode(' AND ', $where) : '';
        //
        $tableSize = $this->sqlGetValue("
            SELECT count(*)
            FROM `{$this->metaObjectCode}`");
        $this->data = $this->sqlGetRecordSet("
            SELECT ".implode(', ', $this->metaAttributesList)."
            FROM `{$this->metaObjectCode}`
            $where
            " . ($tableSize > 100000 ? "" : $this->sort) . "
            LIMIT {$this->offset}, {$this->rowsPerPage}");
        echo "
            SELECT ".implode(', ', $this->metaAttributesList)."
            FROM `{$this->metaObjectCode}`
            $where
            " . ($tableSize > 100000 ? "" : $this->sort) . "
            LIMIT {$this->offset}, {$this->rowsPerPage}";
        $this->totalRows = $this->sqlGetValue("
            SELECT count(*)
            FROM `{$this->metaObjectCode}`
            $where");
        if ($this->data)
        {
            $i = $this->offset + 1;
            foreach ($this->data as $row)
            {
                $td = array();
                $firstCol = true;
                foreach ($this->metaAttributes as $metaAttribute)
                {
                    if ($metaAttribute['code'] == 'id')
                    {
                        continue;
                    }
                    if ($firstCol)
                    {
                        $firstCol = false;
                        $td[$metaAttribute['code']] = '<a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_VIEW.'/id='.$row['id'].'/-page='.$this->listPage.'/-view='.$this->metaViewId.'/">'.Contentico::getListValue($metaAttribute, $row[$metaAttribute['code']], $row['id']).'</a>';
                    }
                    else
                    {
                        $td[$metaAttribute['code']] = Contentico::getListValue($metaAttribute, $row[$metaAttribute['code']], $row['id']);
                    }
                }
                $this->rows[$row['id']] = array(
                    'i' => $i,
                    'id' => $row['id'],
                    'td' => $td,
                );
                $i++;
            }
        }
        else
        {
            $this->rows = '<tr><td colspan="'.(sizeof($this->metaAttributes) + 2).'" align="center"><em>Нет данных для отображения</em></td></tr>';
        }
    }

    /**
     * Генерация постраничной навигации
     *
     * @return string
     */
    private function generateNavigation()
    {
        $url = '/@contentico/Metaobjects/'.$this->metaObjectCode.'/view='.$this->metaViewId.'/';
        $pages = ($this->totalRows - ($this->totalRows % $this->rowsPerPage)) / $this->rowsPerPage;
        if($this->totalRows > ($pages * $this->rowsPerPage))
        {
            $pages++;
        }
        $pageNums = array();
        for ($i =- 3; $i <= 3; $i++)
        {
            $link = '';
            if ($i == 0)
            {
                $pageNums[] = '<strong>'.$this->listPage.'</strong>';
            }
            else
            {
                $n = $this->listPage + $i;
                if (($n > 0) && ((($n * $this->rowsPerPage) == $this->totalRows) || ((($n - 1) * $this->rowsPerPage) < $this->totalRows)))
                {
                    $pageNums[] = '<a href="'.$url.'page='.$n.'/">'.$n.'</a>';
                }
            }
        }
        // 1 ... 5 6 7
        if ($this->listPage > 4)
        {
            $link = '<a href="'.$url.'page=1/">1</a>';
            if ($this->listPage > 5)
            {
                $link .= ' &nbsp; &hellip; ';
            }
            array_unshift($pageNums, $link);
        }
        // 1 2 3 ... 7
        if ($pages - $this->listPage > 3)
        {
            $link = '';
            if ($pages - $this->listPage > 4)
            {
                $link = ' &hellip; &nbsp; ';
            }
            $link .= '<a href="'.$url.'page='.$pages.'/">'.$pages.'</a>';
            array_push($pageNums, $link);
        }
        // первая, назад, вперед, последняя
        $prev = $this->listPage > 1 ? '<a href="'.$url.'page='.($this->listPage - 1).'/">&larr;&nbsp;назад</a>' : '&larr;&nbsp;назад';
        $next = $this->listPage < $pages ? '<a href="'.$url.'page='.($this->listPage + 1).'/">вперед&nbsp;&rarr;</a>' : 'вперед&nbsp;&rarr;';
        return $prev.' &nbsp; '.implode(' &nbsp; ', $pageNums).' &nbsp; '.$next;
    }

    /**
     * Генерация действий
     *
     */
    private function generateActions()
    {
        $actions = array();
        if ($this->params['action_create'] && $this->metaObjectRights & SECURITY_RIGHT_WRITE)
        {
            $actions['create'] = '<li id="action-add" onclick="document.location.href=\'/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_CREATE.'/\';">Добавить</li>';
        }
        if ($this->params['action_view'] && $this->metaObjectRights & SECURITY_RIGHT_READ)
        {
            $actions['view'] = '<li id="action-view" onclick="GoViewEdit(\''.$this->metaObjectCode.'\', '.ACTION_VIEW.', '.$this->listPage.', '.$this->metaViewId.');">Открыть</li>';
        }

        if ($this->params['action_create'] && $this->metaObjectRights & SECURITY_RIGHT_WRITE)
        {
            $actions['copy'] = '<li id="action-copy" onclick="GoViewEdit(\''.$this->metaObjectCode.'\', '.ACTION_COPY.', '.$this->listPage.', '.$this->metaViewId.');">Копировать</li>';
        }


        if ($this->params['action_edit'] && $this->metaObjectRights & SECURITY_RIGHT_WRITE)
        {
            $actions['edit'] = '
                <li id="action-edit" onclick="GoViewEdit(\''.$this->metaObjectCode.'\', '.ACTION_EDIT.', '.$this->listPage.', '.$this->metaViewId.');">Редактировать</li>
                <!--li id="action-up" class="disabled">Вверх</li>
                <li id="action-down" class="disabled">Вниз</li-->
            ';
        }
        if ($this->params['action_delete'] && $this->metaObjectRights & SECURITY_RIGHT_DELETE)
        {
            $actions['delete'] = '<li id="action-delete" onclick="GoDelete(\''.$this->metaObjectCode.'\', '.ACTION_DELETE.', '.$this->listPage.', '.$this->metaViewId.');">Удалить</li>';
        }
        if ($this->metaObjectRights & SECURITY_RIGHT_READ)
        {
            $actions['more'] = '<li id="action-more" onmouseover="$(this).find(\'ul\').show();" onmouseout="$(this).find(\'ul\').hide();">Еще
                <ul>
                    <li>Экспорт в XML (<a href="javascript:void(0);" onclick="listActionExport(\''.$this->metaObjectCode.'\', ' . ACTION_EXPORT . ', 1, '.$this->listPage.', '.$this->metaViewId.');">все</a>,
                        <a href="javascript:void(0);" onclick="listActionExport(\''.$this->metaObjectCode.'\', ' . ACTION_EXPORT . ', 2, '.$this->listPage.', '.$this->metaViewId.');">выбранные</a>,
                        <a href="javascript:void(0);" onclick="listActionExport(\''.$this->metaObjectCode.'\', ' . ACTION_EXPORT . ', 3, '.$this->listPage.', '.$this->metaViewId.');">отфильтрованные</a>)</li>
                    <li><a href="javascript:void(0);" onclick="showImportXmlWindow(false);">Импорт из XML</a></li>
                </ul>';
        }
        //
        if ($this->actions)
        {
            foreach ($this->actions as $action)
            {
                switch ($action->type)
                {
                    case ContenticoViewListAction::LIST_ACTION_TYPE_REDIRECT:
                        if ($this->metaObjectRights & $action->rights)
                        {
                            $actions[$action->code] = '<li id="action-'.$action->code.'"  onclick="document.location.href=\'/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_CUSTOM.'/'.$action->param.'\';" style="background:url('.$action->icon.') #fff no-repeat 50% 0;">'.$action->name.'</li>';
                        }
                        break;
                    case ContenticoViewListAction::LIST_ACTION_TYPE_FUNCTION:
                        if ($this->metaObjectRights & $action->rights)
                        {
                            $actions[$action->code] = '<li id="action-'.$action->code.'"  onclick="'.$action->param.'(\''.$this->metaObjectCode.'\', '.ACTION_CUSTOM.', '.$this->listPage.', '.$this->metaViewId.');" style="background:url('.$action->icon.') #fff no-repeat 50% 0;">'.$action->name.'</li>';
                        }
                        break;
                }
                $actions[$action->code] .= '<script type="text/javascript">ContenticoListActions.push({"id":"action-'.$action->code.'", "count":'.$action->mode.'});'.$action->javaScript.'</script>';
            }
        }
        //
        $this->actions = $actions;
    }

    /**
     * Генерация HTML
     *
     * @return string
     */
    public function getHtml()
    {
        $actions = '<ul class="actions">';
        foreach ($this->actions as $actionCode=>$html)
        {
            $actions .= $html;
        }
        $actions .= '</ul>';
        //
        $views = $this->generateViews();
        //
        $th = '';
        foreach ($this->headers as $header)
        {
            $th .= '<th><div class="fix">'.$header['filter'].$header['sort'].$header['name'].'</div></th>';
        }
        //
        if ($this->data)
        {
            $tr = '';
            foreach ($this->rows as $row)
            {
                if ($this->isCustomTrTemplate)
                {
                    $row['td']['id'] = $row['id'];
                    $tr .= Std::renderTemplate($this->trTemplate, $row['td']);
                }
                else
                {
                    $td = '';
                    foreach ($row['td'] as $metaAttributeCode=>$value)
                    {
                        $td .= '<td>'.$value.'</td>';
                    }
                    if ($this->childMetaObjects)
                    {
                        $links =  array();
                        foreach ($this->childMetaObjects as $ChildMetaObject)
                        {
                            $links[] = '<a href="/@contentico/Metaobjects/'.$ChildMetaObject['metaobject'].'/action='.ACTION_LIST.'/parent='.$this->metaObjectCode.'-'.$row['id'].'-'.$ChildMetaObject['metaattribute'].'/">'.$ChildMetaObject['name'].'</a>';
                        }
                        $td .= '<td>'.implode(', ', $links).'</td>';
                    }
                    $tr .= Std::renderTemplate($this->trTemplate, array(
                        'i' => $row['i'],
                        'id' => $row['id'],
                        'td' => $td,
                    ));
                }
            }
        }
        else
        {
            $tr = $this->rows;
        }
        $list = Std::renderTemplate($this->tableTemplate, array(
            'view-select' => $views,
            'actions' => $actions,
            'th' => $th,
            'tr' => $tr,
            'nav' => $this->totalRows > $this->rowsPerPage ? $this->generateNavigation() : '',
            'rows-onpage' => $this->totalRows ? sizeof($this->rows) : '0',
            'rows-total' => $this->totalRows,
        ));
        //
        $tree = $this->sqlGetRecord("
            SELECT
            	mo.code metaobject, mo.id metaobject_id, ma.code metaattribute, sp.sortby, sp.sortorder, sp.name,
                (SELECT code FROM metaattribute WHERE metaobject_id=mo.id AND type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT."  AND typeparam=mo.code) selflink,
                (SELECT code FROM metaattribute WHERE metaobject_id={$this->metaObjectId} AND type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT." AND typeparam=mo.code) childlink
            FROM
            	metaview mv
                LEFT JOIN metaobject mo ON mo.id=mv.tree_metaobject_id
                LEFT JOIN sysparams sp ON sp.metaobject_id=mo.id
                LEFT JOIN metaattribute ma ON ma.id=sp.export_metaattribute_id
                LEFT JOIN syssecurity ss ON ss.metaobject_id=mo.id AND ss.metaview_id=0 AND ss.sysuser_id=".Runtime::$gid."
            WHERE
            	mv.id={$this->metaViewId} AND ss.rights>0");
        if ($tree)
        {
            $where = array();
            if ($this->parent)
            {
                foreach ($this->parent as $parent)
                {
                    if ($parent['id'] > 0 && $parent['metaobject'] != $tree['metaobject'])
                    {
                        $where[] = "`{$parent['metaattribute']}`='{$parent['id']}'";
                    }
                }
                $where = implode(' AND ', $where);
            }
            else
            {
                $where = '';
            }
            //
            $where = ($where ? ' AND ' : '').($GLOBALS['config']['advancedsecurity'] ? "checkUserRightsOnObject({$this->metaObjectId}, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1" : '');
            $li = '<li '.($this->parent[$tree['childlink']]['id'] == 0 ? ' class="cur"' : '').'>
                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$tree['metaobject'].'-0-'.$tree['childlink'].'/">
                        <span class="name">Все</span><span class="number">'.$this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}` ".($where ? "WHERE $where" : "")).'</span>
                    </a>
                </li>';
            if ($tree['selflink'])
            {
                $sort = $tree['sortby'] != '' && $tree['sortorder'] ? "ORDER BY `{$tree['selflink']}` ASC, `{$tree['sortby']}` {$tree['sortorder']}" : '';
                if ($where)
                {
                    $where = ' AND '.$where;
                }
                $advancedSecurity1 = $GLOBALS['config']['advancedsecurity'] ? "AND checkUserRightsOnObject({$this->metaObjectId}, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1" : '';
                $advancedSecurity2 = $GLOBALS['config']['advancedsecurity'] ? "WHERE checkUserRightsOnObject({$tree['metaobject_id']}, pmo.id, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1" : '';
                $values = $this->sqlGetRecordSet("
                	SELECT
                		pmo.id, pmo.{$tree['metaattribute']} name, pmo.{$tree['selflink']} _id,
                    	(SELECT count(*) FROM `{$this->metaObjectCode}` WHERE `{$tree['childlink']}`=pmo.id $advancedSecurity1 $where) count
                    FROM
                    	`{$tree['metaobject']}` pmo
                    $advancedSecurity2
                    $sort");
                if ($values)
                {
                    $parents = array(0);
                    $processed = array();
                    $space = 0;
                    $len = sizeof($values);
                    //
                    while (sizeof($parents) > 0)
                    {
                        $curParent = $parents[0];
                        $i = 0;
                        while ($i < $len)
                        {
                            if ($values[$i]['_id'] == $curParent && !in_array($values[$i]['id'], $processed))
                            {
                                $processed[] = $values[$i]['id'];
                                $li .= '<li '.($this->parent[$tree['childlink']]['id'] == $values[$i]['id'] ? ' class="cur"' : '').'>
                                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$tree['metaobject'].'-'.$values[$i]['id'].'-'.$tree['childlink'].'/">
                                        <span class="name">'.$values[$i]['name'].'</span>
                                        <span class="number">'.$values[$i]['count'].'</span>
                                    </a></li>';
                                if (!in_array($values[$i]['id'], $parents))
                                {
                                    $li .= '<ul>';
                                    array_unshift($parents, $values[$i]['id']);
                                    $space++;
                                    break;
                                }
                            }
                            $i++;
                        }
                        if ($i == $len)
                        {
                            $li .= '</ul>';
                            array_shift($parents);
                            $space--;
                        }
                    }
                }
            }
            else
            {
                $sort = $tree['sortby'] != '' && $tree['sortorder'] ? "ORDER BY `{$tree['sortby']}` {$tree['sortorder']}" : '';
                $values = $this->sqlGetRecordSet("
                	SELECT
                		pmo.id, pmo.{$tree['metaattribute']} name,
                    	(SELECT count(*) FROM `{$this->metaObjectCode}` WHERE `{$tree['childlink']}`=pmo.id) count
                    FROM
                    	`{$tree['metaobject']}` pmo
                    $sort");
                if ($values)
                {
                    foreach ($values as $value)
                    {
                        $li .= '<li '.($this->parent[$tree['childlink']]['id'] == $value['id'] ? ' class="cur"' : '').'>
                            <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$tree['metaobject'].'-'.$value['id'].'-'.$tree['childlink'].'/">
                                <span class="name">'.$value['name'].'</span>
                                <span class="number">'.$value['count'].'</span>
                            </a></li>';
                    }
                }
            }
            //
            if ($this->parent)
            {
                foreach ($this->parent as $parent)
                {
                    if ($parent['id'] > 0 && $tree['metaobject'] != $parent['metaobject'])
                    {
                        $metaObject = $this->sqlGetRecord("
                            SELECT
                            	sp.name, ma.code metaattribute
                            FROM
                            	sysparams sp
                                LEFT JOIN metaobject mo ON mo.id=sp.metaobject_id
                                LEFT JOIN metaattribute ma ON ma.id=sp.export_metaattribute_id
                            WHERE
                            	mo.code='{$parent['metaobject']}'");
                        $name = $this->sqlGetValue("SELECT `{$metaObject['metaattribute']}` FROM `{$parent['metaobject']}` WHERE id={$parent['id']}");
                        $subTree .= '
                            <br clear="all" />
                            <div style="clear:both; border-top:1px solid #DFE0DE; margin:20px 10px 10px 0px;" />
                            <br clear="all" />
                            <strong>'.$metaObject['name'].'</strong> <span class="addfolder"><a href="/@contentico/Metaobjects/'.$parent['metaobject'].'/action='.ACTION_CREATE.'/">Добавить</a></span>
	                        <ul class="tree">
                                <li>
                                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$parent['metaobject'].'-0-'.$parent['metaattribute'].'/">
                                        <span class="name">Все</span>
                                        <span class="number">'.$this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}`").'</span>
                                    </a>
                                </li>
                                <li class="cur">
                                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$parent['metaobject'].'-'.$parent['id'].'-'.$parent['metaattribute'].'/">
                                        <span class="name">'.$name.'</span>
                                        <span class="number">'.$this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}` WHERE `{$parent['metaattribute']}`={$parent['id']}").'</span>
                                    </a>
                                </li>
                            </ul>
                        ';
                    }
                }
            }
            //
            $tree = Std::renderTemplate(Contentico::loadTemplate('tree/td'), array(
                'li' => $li,
                'subtree' => $subTree,
                'create-label' => 'Добавить',
                'create-url' => 'Metaobjects/'.$tree['metaobject'].'/action='.ACTION_CREATE,
                'name' => $tree['name'],
            ));
            return array($list, $tree);
        }
        else
        {
            if ($this->parent)
            {
                $li = '';
                $first = true;
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
                        $name = $this->sqlGetValue("SELECT `{$metaObject['metaattribute']}` FROM `{$parent['metaobject']}` WHERE id={$parent['id']}");
                        if ($first)
                        {
                            $first = false;
                            $liName = $metaObject['name'];
                            $liMetaObjectCode = $parent['metaobject'];
                            $li .= '
                                <li>
                                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$parent['metaobject'].'-0-'.$parent['metaattribute'].'/">
                                        <span class="name">Все</span>
                                        <span class="number">'.$this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}`").'</span>
                                    </a>
                                </li>
                                <li class="cur">
                                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$parent['metaobject'].'-'.$parent['id'].'-'.$parent['metaattribute'].'/">
                                        <span class="name">'.$name.'</span>
                                        <span class="number">'.$this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}` WHERE `{$parent['metaattribute']}`={$parent['id']}").'</span>
                                    </a>
                                </li>
                            ';
                        }
                        else
                        {
                            $subTree .= '
                            <br clear="all" />
                            <div style="clear:both; border-top:1px solid #DFE0DE; margin:20px 10px 10px 0px;" />
                            <br clear="all" />
                            <strong>'.$metaObject['name'].'</strong> <span class="addfolder"><a href="/@contentico/Metaobjects/'.$parent['metaobject'].'/action='.ACTION_CREATE.'/">Добавить</a></span>
	                        <ul class="tree">
                                <li>
                                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$parent['metaobject'].'-0-'.$parent['metaattribute'].'/">
                                        <span class="name">Все</span>
                                        <span class="number">'.$this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}`").'</span>
                                    </a>
                                </li>
                                <li class="cur">
                                    <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/parent='.$parent['metaobject'].'-'.$parent['id'].'-'.$parent['metaattribute'].'/">
                                        <span class="name">'.$name.'</span>
                                        <span class="number">'.$this->sqlGetValue("SELECT count(*) FROM `{$this->metaObjectCode}` WHERE `{$parent['metaattribute']}`={$parent['id']}").'</span>
                                    </a>
                                </li>
                            </ul>
                        ';
                        }
                    }
                }
                if ($li != '')
                {
                    $tree = Std::renderTemplate(Contentico::loadTemplate('tree/td'), array(
                        'li' => $li,
                        'subtree' => $subTree,
                        'create-label' => 'Добавить',
                        'create-url' => 'Metaobjects/'.$liMetaObjectCode.'/action='.ACTION_CREATE,
                        'name' => $liName,
                    ));
                    return array($list, $tree);
                }
            }
        }
        return $list;
    }
}

/**
 * Представление: "Быстрый" список
 *
 */
class ContenticoViewQuickList extends ContenticoView
{
    public $data;
    public $headers = array();
    public $rows = array();
    public $sortBy;
    public $sortOrder;
    public $sort = '';
    public $rowsPerPage = 5;
    public $conditions = array();
    public $totalRows;
    public $metaAttributesList = array();
    private $childMetaObjects;
    public $metaObjectRights;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Прегенерация объектов - условия, фильтры
     *
     */
    public function preGenerate()
    {
        $this->getMetaView(META_VIEW_TYPE_QUICKLIST);
        //
        $this->loadMetaAttributes();
        // загрузка шаблонов
        $templates = $this->sqlGetRecord("SELECT template, templaterow FROM metaview WHERE id=".$this->metaViewId);
        if (trim($templates['template']) == '')
        {
            $this->tableTemplate = Contentico::loadTemplate('list/table');
        }
        else
        {
            $this->tableTemplate = trim($templates['template']);
            $this->isCustomTableTemplate = true;
        }
        if (trim($templates['templaterow']) == '')
        {
            $this->trTemplate =  Contentico::loadTemplate('list/tr');
        }
        else
        {
            $this->trTemplate =  trim($templates['templaterow']);
            $this->isCustomTrTemplate = true;
        }
        //
        $this->metaAttributesList[] = '`id`';
        $filters = array();
        foreach ($this->metaAttributes as $metaAttribute)
        {
            $this->headers[$metaAttribute['code']] = array(
                'name' => $metaAttribute['name'],
            );
            $this->metaAttributesList[] = $metaAttribute['code'];
        }
        $this->metaAttributes = array_merge(array(array('code'=>'id')), $this->metaAttributes);
        //
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
                //
                $operation = str_replace(array('L','B','E','LE','BE'), array('<','>','=','<=','>='), $condition['operation']);
                //
                $this->conditions[] = array(
                    'code' => $condition['code'],
                    'operation' => $operation,
                    'value' => $value,
                    'sql' => $condition['sql'],
                );
            }
        }
        //
        $this->sort = "ORDER BY {$this->params['sortby']} {$this->params['sortorder']}";
    }

    /**
     * Генерация объектов
     *
     */
    public function generate()
    {
        $where = array();
        if (sizeof($this->conditions) > 0)
        {
            foreach ($this->conditions as $condition)
            {
                $value = $condition['value'] == '' ? $condition['sql'] : "'".$condition['value']."'";
                $where[] = "`{$condition['code']}`{$condition['operation']}$value";
            }
        }
        //
        if ($this->parent)
        {
            $where[] = "`{$this->parent['metaattribute']}`={$this->parent['id']}";
        }
        //
        if ($GLOBALS['config']['advancedsecurity'])
        {
            $where[] = "checkUserRightsOnObject({$this->metaObjectId}, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1";
        }
        //
        $where = sizeof($where) > 0 ? 'WHERE '.implode(' AND ', $where) : '';
        //
        $this->data = $this->sqlGetRecordSet("
            SELECT
            	SQL_CALC_FOUND_ROWS ".implode(', ', $this->metaAttributesList)."
            FROM
            	`{$this->metaObjectCode}`
            $where
            {$this->sort}
            LIMIT
            	0, ".$this->rowsPerPage);
        $this->totalRows = $this->sqlGetValue("SELECT found_rows()");
        if ($this->data)
        {
            $i = 1;
            foreach ($this->data as $row)
            {
                $td = array();
                $firstCol = true;
                foreach ($this->metaAttributes as $metaAttribute)
                {
                    if ($metaAttribute['code'] == 'id')
                    {
                        continue;
                    }
                    if ($firstCol)
                    {
                        $firstCol = false;
                        $td[$metaAttribute['code']] = '<a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_VIEW.'/id='.$row['id'].'/-page=/-view=/">'.Contentico::getListValue($metaAttribute, $row[$metaAttribute['code']], $row['id']).'</a>';
                    }
                    else
                    {
                        $td[$metaAttribute['code']] = Contentico::getListValue($metaAttribute, $row[$metaAttribute['code']], $row['id']);
                    }
                }
                $this->rows[$row['id']] = array(
                    'i' => $i,
                    'id' => $row['id'],
                    'td' => $td,
                );
                $i++;
            }
        }
        else
        {
            $this->rows = '<tr><td colspan="'.(sizeof($this->metaAttributes) + 2).'" align="center"><em>Нет данных для отображения</em></td></tr>';
        }
    }

    /**
     * Генерация HTML
     *
     * @return string
     */
    public function getHtml()
    {
        $th = '';
        foreach ($this->headers as $metaAttributeCode=>$header)
        {
            $th .= '<th>'.$header['name'].'</th>';
        }
        //
        if ($this->data)
        {
            $tr = '';
            foreach ($this->rows as $row)
            {
                if ($this->isCustomTrTemplate)
                {
                    $row['td']['id'] = $row['id'];
                    $tr .= Std::renderTemplate($this->trTemplate, $row['td']);
                }
                else
                {
                    $td = '';
                    foreach ($row['td'] as $metaAttributeCode=>$value)
                    {
                        $td .= '<td>'.$value.'</td>';
                    }
                    $tr .= Std::renderTemplate($this->trTemplate, array(
                        'i' => $row['i'],
                        'id' => $row['id'],
                        'td' => $td,
                    ));
                }
            }
            return Std::renderTemplate($this->tableTemplate, array(
                'th' => $rh,
                'tr' => $rr,
                'rows-onpage' => $this->rotalRows ? sizeof($this->rows) : '0',
                'rows-total' => $this->rotalRows,
                'name'=>$this->sqlGetValue("SELECT name FROM metaview WHERE id={$this->metaViewId}"),
                'more'=>$this->rotalRows > $this->rowsPerPage ? '
                    <tr>
                        <td class="num"></td>
                        <td colspan="'.(sizeof($Attributes) - 1).'">
                            <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/'.($this->parent ? 'parent='.$this->parent['metaobject'].'-'.$this->parent['id'].'-'.$this->parent['metaattribute'].'/' : '').'"><em>полный список &hellip;</em></a>
                        </td>
                    </tr>' : '',
            ));
        }
        else
        {
            return '';
        }
    }
}

/**
 * Представление: Список
 *
 */
class ContenticoViewWidget extends ContenticoView
{
    private $childMetaObjects;
    
    public $data;
    public $headers = array();
    public $rows = array();
    public $sortBy;
    public $sortOrder;
    public $sort = '';
    public $rowsPerPage = 5;
    public $conditions = array();
    public $totalRows;
    public $metaAttributesList = array();
    public $metaObjectRights;

    public function __construct()
    {
        parent::__construct();		
    }

    /**
     * Прегенерация объектов - условия, фильтры
     *
     */
    public function preGenerate()
    {
        $this->getMetaView(META_VIEW_TYPE_WIDGET);
        //
        $this->loadMetaAttributes();
        // загрузка шаблонов
        $templates = $this->sqlGetRecord("SELECT template, templaterow FROM metaview WHERE id=".$this->metaViewId);
        if (trim($templates['template']) == '')
        {
            $this->tableTemplate = Contentico::loadTemplate('list/table-widget');
        }
        else
        {
            $this->tableTemplate = trim($templates['template']);
            $this->isCustomTableTemplate = true;
        }
        if (trim($templates['templaterow']) == '')
        {
            $this->trTemplate =  Contentico::loadTemplate('list/tr-widget');
        }
        else
        {
            $this->trTemplate =  trim($templates['templaterow']);
            $this->isCustomTrTemplate = true;
        }
        //
        $this->metaAttributesList[] = '`id`';
        $filters = array();		
        foreach ($this->metaAttributes as $metaAttribute)
        {
            $this->headers[$metaAttribute['code']] = array(
                'name' => $metaAttribute['name'],
            );
			if ($metaAttribute['type'] == 18) continue;
            $this->metaAttributesList[] = $metaAttribute['code'];
        }
        $this->metaAttributes = array_merge(array(array('code'=>'id')), $this->metaAttributes);
        //
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
                //
                $operation = str_replace(array('L','B','E','LE','BE'), array('<','>','=','<=','>='), $condition['operation']);
                //
                $this->conditions[] = array(
                    'code' => $condition['code'],
                    'operation' => $operation,
                    'value' => $value,
                    'sql' => $condition['sql'],
                );
            }
        }
        //
        $this->sort = "ORDER BY {$this->params['sortby']} {$this->params['sortorder']}";
    }

    /**
     * Генерация объектов
     *
     */
    public function generate()
    {
        $where = array();
        if (sizeof($this->conditions) > 0)
        {
            foreach ($this->conditions as $condition)
            {
                $value = $condition['value'] == '' ? $condition['sql'] : "'".$condition['value']."'";
                $where[] = "`{$condition['code']}`{$condition['operation']}$value";
            }
        }
        //
        if ($this->parent)
        {
            $where[] = "`{$this->parent['metaattribute']}`={$this->parent['id']}";
        }
        //
        if ($GLOBALS['config']['advancedsecurity'])
        {
            $where[] = "checkUserRightsOnObject({$this->metaObjectId}, `id`, ".Runtime::$gid.", ".SECURITY_RIGHT_READ.")=1";
        }
        //
        $where = sizeof($where) > 0 ? 'WHERE '.implode(' AND ', $where) : '';
        //
		$this->data = $this->sqlGetRecordSet("
            SELECT
            	SQL_CALC_FOUND_ROWS ".implode(', ', $this->metaAttributesList)."
            FROM
            	`{$this->metaObjectCode}`
            $where
            {$this->sort}
            LIMIT
            	0, " . $this->rowsPerPage);
        $this->totalRows = $this->sqlGetValue("SELECT found_rows()");
        if ($this->data)
        {
            $i = 1;
            foreach ($this->data as $row)
            {
                $td = array();
                $firstCol = true;
                foreach ($this->metaAttributes as $metaAttribute)
                {
                    if ($metaAttribute['code'] == 'id')
                    {
                        continue;
                    }
                    if ($firstCol)
                    {
                        $firstCol = false;
                        $td[$metaAttribute['code']] = '<a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/action='.ACTION_VIEW.'/id='.$row['id'].'/-page=/-view=/">'.Contentico::getListValue($metaAttribute, $row[$metaAttribute['code']], $row['id']).'</a>';
                    }
                    else
                    {
                        $td[$metaAttribute['code']] = Contentico::getListValue($metaAttribute, $row[$metaAttribute['code']], $row['id']);
                    }
                }
                $this->rows[$row['id']] = array(
                    'i' => $i,
                    'id' => $row['id'],
                    'td' => $td,
                );
                $i++;
            }
        }
        else
        {
            $this->rows = '<tr><td colspan="'.(sizeof($this->metaAttributes) + 2).'" align="center"><em>Нет данных для отображения</em></td></tr>';
        }
    }

    /**
     * Генерация HTML
     *
     * @return string
     */
    public function getHtml()
    {
        $th = '';
        foreach ($this->headers as $metaAttributeCode=>$header)
        {
            $th .= '<th>'.$header['name'].'</th>';
        }
        //
        if ($this->data)
        {
            $tr = '';
            foreach ($this->rows as $row)
            {
                if ($this->isCustomTrTemplate)
                {
                    $row['td']['id'] = $row['id'];
                    $tr .= Std::renderTemplate($this->trTemplate, $row['td']);
                }
                else
                {
                    $td = '';
                    foreach ($row['td'] as $metaAttributeCode=>$value)
                    {
                        $td .= '<td>'.$value.'</td>';
                    }
                    $tr .= Std::renderTemplate($this->trTemplate, array(
                        'i' => $row['i'],
                        'id' => $row['id'],
                        'td' => $td,
                    ));
                }
            }
            return Std::renderTemplate($this->tableTemplate, array(
                'th' => $th,
                'tr' => $tr,
                'rows-onpage' => $this->totalRows ? sizeof($this->rows) : '0',
                'rows-total' => $this->totalRows,
                'name'=>$this->sqlGetValue("SELECT name FROM metaview WHERE id={$this->metaViewId}"),
                'more'=>$this->totalRows > $this->rowsPerPage ? '
                    <tr>
                        <td class="num"></td>
                        <td colspan="'.(sizeof($attributes) - 1).'">
                            <a href="/@contentico/Metaobjects/'.$this->metaObjectCode.'/'.($this->parent ? 'parent='.$this->parent['metaobject'].'-'.$this->parent['id'].'-'.$this->parent['metaattribute'].'/' : '').'"><em>полный список &hellip;</em></a>
                        </td>
                    </tr>' : '',
            ));
        }
        else
        {
            return '';
        }
    }
}

/**
 * Действие над элементов списка
 *
 */
class ContenticoViewListAction
{
    public $type;
    public $code;
    public $param;
    public $mode;
    public $name;
    public $icon;
    public $rights;
    public $javaScript;

    const LIST_ACTION_TYPE_REDIRECT = 1;
    const LIST_ACTION_TYPE_FUNCTION = 2;

    const LIST_ACTION_MODE_ALWAYSON = 0;
    const LIST_ACTION_MODE_ONE = 1;
    const LIST_ACTION_MODE_MANY = 2;

    public function __construct($type, $code, $param, $mode, $name, $icon, $rights, $javaScript='')
    {
        $this->type = $type;
        $this->code = $code;
        $this->param = $param;
        $this->mode = $mode;
        $this->name = $name;
        $this->icon = $icon;
        $this->rights = $rights;
        $this->javaScript = $javaScript;
    }
}
?>
