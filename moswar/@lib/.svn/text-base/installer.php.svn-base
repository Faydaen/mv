<?php
/**
 * MetaAttribute - мета-атрибут
 *
 */
class ContenticoInstallerMetaAttribute
{
    private $sql;
    
    public $id = 0;
    public $metaObjectCode;
    public $metaObjectId;
    public $code;
    public $oldCode = '';
    public $type;
    public $typeParam = false;
    public $typeSql = false;
    public $role = 3;
    public $dictionary = false;
    public $customSql = false;
    public $sqlPrimaryKey = false;
    public $sqlIndex = false;
    public $sqlIndexComplex = false;
    public $sqlUnique = false;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function initFromXml($metaAttributeXml, $metaObjectCode)
    {
        $this->metaObjectCode = $metaObjectCode;
        $this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
        $this->code = (string)$metaAttributeXml['code'];
        $this->oldCode = (string)$metaAttributeXml['oldcode'];
        $this->typeParam = (string)$metaAttributeXml['typeparam'];
        switch ((string)$metaAttributeXml['type']) {
            case 'id':
                $this->type = META_ATTRIBUTE_TYPE_ID;
                break;

            case 'int':
                $this->type = META_ATTRIBUTE_TYPE_INT;
                break;

            case 'float':
                $this->type = META_ATTRIBUTE_TYPE_FLOAT;
                break;

            case 'string':
                $this->type = META_ATTRIBUTE_TYPE_STRING;
                break;

            case 'text':
                $this->type = META_ATTRIBUTE_TYPE_TEXT;
                break;

            case 'bigtext':
                $this->type = META_ATTRIBUTE_TYPE_BIGTEXT;
                break;

            case 'data':
                $this->type = META_ATTRIBUTE_TYPE_DATA;
                break;

            case 'datetime':
                $this->type = META_ATTRIBUTE_TYPE_DATETIME;
                break;

            case 'date':
                $this->type = META_ATTRIBUTE_TYPE_DATE;
                break;

            case 'bool':
                $this->type = META_ATTRIBUTE_TYPE_BOOL;
                break;

            case 'file':
                $this->type = META_ATTRIBUTE_TYPE_FILE;
                break;

            case 'image':
                $this->type = META_ATTRIBUTE_TYPE_IMAGE;
                break;

            case 'link_to_object':
                $this->type = META_ATTRIBUTE_TYPE_LINKTOOBJECT;
                $code = $this->code ? $this->code : (($this->typeParam == $this->metaObjectCode ? '' : $this->typeParam).'_id');
                $_SESSION['contentico_installer']['get_parent_id'] .= "
    IF (metaObjectCode='{$this->metaObjectCode}' && parentMetaObjectCode='{$this->typeParam}') THEN
        SELECT `$code` INTO parentId FROM `{$this->metaObjectCode}` WHERE id=objectId;
    END IF;
";
                break;

            case 'link_to_objects':
                $this->type = META_ATTRIBUTE_TYPE_LINKTOOBJECTS;
                break;

            case 'dictionary':
                $this->type = META_ATTRIBUTE_TYPE_DICTIONARY;
                $_SESSION['contentico_installer'][$this->metaObjectCode.'_'.$this->code.'_dictionary'] = $this->typeParam;
                break;

            case 'custom':
                $this->type = META_ATTRIBUTE_TYPE_CUSTOM;
                break;

            case 'password':
                $this->type = META_ATTRIBUTE_TYPE_PASSWORD;
                break;

            case 'query':
                $this->type = META_ATTRIBUTE_TYPE_QUERY;
                break;
        }
        if ($this->code == '') {
            if ($this->type == META_ATTRIBUTE_TYPE_ID) {
                $this->code = 'id';
            } elseif ($this->type == META_ATTRIBUTE_TYPE_LINKTOOBJECT) {
                $this->code = ($this->typeParam == $this->metaObjectCode ? '' : $this->typeParam).'_id';
            }
        }
        if ($this->type == META_ATTRIBUTE_TYPE_CUSTOM) {
            $this->customSql = (string) $metaAttributeXml->customsql;
        }
        switch ((string)$metaAttributeXml['role']) {
            case 'id':
                $this->role = META_ATTRIBUTE_ROLE_ID;
                break;

            case 'system':
                $this->role = META_ATTRIBUTE_ROLE_SYSTEM;
                break;

            case 'data':
                $this->role = META_ATTRIBUTE_ROLE_DATA;
                break;
        }

        if ($metaAttributeXml->sql) {
            if ((string)$metaAttributeXml->sql['primarykey'] != '') {
                if (is_numeric((string) $metaAttributeXml->sql['primarykey']) && (int) $metaAttributeXml->sql['primarykey'] == 1) {
                    $this->sqlPrimaryKey = 1;
                } else {
                    $this->sqlPrimaryKey = (string) $metaAttributeXml->sql['primarykey'];
                }
            }
            if ((string)$metaAttributeXml->sql['index'] != '') {
                if (is_numeric((string) $metaAttributeXml->sql['index']) && (int) $metaAttributeXml->sql['index'] == 1) {
                    $this->sqlIndex = 1;
                } else {
                    $this->sqlIndex = (string) $metaAttributeXml->sql['index'];
                }
            }
            if ((string)$metaAttributeXml->sql['unique'] != '') {
                if (is_numeric((string) $metaAttributeXml->sql['unique']) && (string) $metaAttributeXml->sql['unique'] == 1) {
                    $this->sqlUnique = 1;
                } else {
                    $this->sqlUnique = (string) $metaAttributeXml->sql['index'];
                }
            }
        }
    }

    public function initFromDb($id)
    {
        $this->id = $id;
        $metaAttribute = $this->sql->getRecord("SELECT * FROM metaattribute WHERE id=".$this->id);
        $this->metaObjectId = $metaAttribute['metaobject_id'];
        $this->metaObjectCode = $this->sql->getValue("SELECT code FROM metaobject WHERE id=".$this->metaObjectId);
        $this->code = $metaAttribute['code'];
        $this->type = $metaAttribute['type'];
        $this->typeParam = $metaAttribute['typeparam'];
        $this->role = $metaAttribute['role'];
    }

    public function sync()
    {
        $oldCode = $this->oldCode == '' ? $this->code : $this->oldCode;
        $currentState = $this->sql->getRecord("SELECT * FROM metaattribute WHERE code='{$oldCode}' AND metaobject_id=".$this->metaObjectId);
        $this->id = $currentState['id'];
        $typeParam = $this->type == META_ATTRIBUTE_TYPE_DICTIONARY ? '' : $this->typeParam;
        $this->sql->query("UPDATE metaattribute SET code='{$this->code}', type={$this->type}, typeparam='{$typeParam}',
            role={$this->role} WHERE id=".$this->id);
        // type & code
        $newSql = SqlDataSource::getSqlByType($this->type, $this->typeParam);
        $oldSql = SqlDataSource::getSqlByType($currentState['type'], $currentState['typeparam']);
        if (!$oldSql) {
            if ($newSql) {
                //$this->sql->query("ALTER TABLE `{$this->metaObjectCode}` ADD `{$this->code}` $newSql");
            }
        } else {
            if ($newSql) {
                //$this->sql->query("ALTER TABLE `{$this->metaObjectCode}` CHANGE `$oldCode` `{$this->code}` $newSql");
            } else {
                //$this->sql->query("ALTER TABLE `{$this->metaObjectCode}` DROP `$oldCode`");
            }
        }
        // links
        if ($this->type != META_ATTRIBUTE_TYPE_LINKTOOBJECTS && $currentState['type'] == META_ATTRIBUTE_TYPE_LINKTOOBJECTS) {
            $this->sql->query("DELETE FROM metalink WHERE metaattribute_id=".$this->id);
        }
    }

    public function create()
    {
        $this->createMeta();
        $this->createSql();
    }

    public function createMeta()
    {
        $typeParam = $this->type == META_ATTRIBUTE_TYPE_DICTIONARY ? '' : $this->typeParam;
        $this->id = $this->sql->insert("
        	INSERT INTO
        		metaattribute (metaobject_id, code, type, typeparam, role)
            VALUES
            	({$this->metaObjectId}, '{$this->code}', {$this->type}, '{$typeParam}', {$this->role})");
    }

    public function createSql()
    {
        $sql = SqlDataSource::getSqlByType($this->type, $this->typeParam);
        if ($sql) {
            //$this->sql->query("ALTER TABLE `{$this->metaObjectCode}` ADD `{$this->code}` $sql");
        }
    }

    public function setMetaObject($metaObjectCode)
    {
        $this->metaObjectCode = $metaObjectCode;
        $this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
    }

    public function delete()
    {
        //$this->sql->query("ALTER TABLE `{$this->metaObjectCode}` DROP COLUMN `{$this->code}`");
        $this->sql->query("DELETE FROM metaattribute WHERE id=".$this->id);
        $this->sql->query("DELETE FROM metaviewfield WHERE metaattribute_id=".$this->id);
        $this->sql->query("DELETE FROM metaviewcondition WHERE metaattribute_id=".$this->id);
        $this->sql->query("DELETE FROM metalink WHERE metaattribute_id=".$this->id);
    }
}

/**
 * MetaViewField - поле в мета-представлении
 *
 */
class ContenticoInstallerMetaViewField
{
    private $sql;
    
    public $id = 0;
    public $metaObjectId;
    public $metaViewId;
    public $metaAttributeId;
    public $metaAttributeCode;
    public $name;
    public $uie = '';
    public $uieParams = '';
    public $defaultValue = '';
    public $isRequired = 0;
    public $hint = '';
    public $unit = '';
    public $mask = '';
    public $group = '';
    public $pos;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function initFromXml($fieldXml, $metaViewCode, $pos)
    {
        $this->pos = $pos;
        $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code='$metaViewCode'");
        if ($this->metaViewId) {
            $this->metaObjectId = $this->sql->getValue("SELECT metaobject_id FROM metaview WHERE id=".$this->metaViewId);
            $this->metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE code='".(string) $fieldXml['metaattribute']."' AND metaobject_id=".$this->metaObjectId);
        }
        $this->metaAttributeCode = (string) $fieldXml['metaattribute'];
        $this->name = (string)$fieldXml['name'];
        if (isset($fieldXml['uie'])) {
            $this->Uie = (string)$fieldXml['uie'];
        }
        if (isset($fieldXml['uieparams'])) {
            $this->uieParams = (string)$fieldXml['uieparams'];
        }
        if (isset($fieldXml['defaultvalue'])) {
            $this->defaultValue = (string)$fieldXml['defaultvalue'];
        }
        if (isset($fieldXml['required'])) {
            $this->isRequired = (int)$fieldXml['required'];
        }
        if (isset($fieldXml['hint'])) {
            $this->hint = (string)$fieldXml['hint'];
        }
        if (isset($fieldXml['unit'])) {
            $this->unit = (string)$fieldXml['unit'];
        }
        if (isset($fieldXml['mask'])) {
            $this->mask = (string)$fieldXml['mask'];
        }
        if (isset($fieldXml['group'])) {
            $this->group = (string)$fieldXml['group'];
        }
    }

    public function initFromDb($id)
    {
        $this->id = $id;
        $metaViewField = $this->sql->getRecord("SELECT * FROM metaviewfield WHERE id=".$this->id);
        $this->metaViewId = $metaViewField['metaview_id'];
        $this->metaAttributeId = $metaViewField['metaattribute_id'];
        $this->name = $metaViewField['name'];
        $this->uie = $metaViewField['uie'];
        $this->uieParams = $metaViewField['uieparams'];
        $this->defaultValue = $metaViewField['defaultvalue'];
        $this->isRequired = $metaViewField['required'];
        $this->hint = $metaViewField['hint'];
        $this->unit = $metaViewField['unit'];
        $this->mask = $metaViewField['mask'];
        $this->group = $metaViewField['group'];
        $this->pos = $metaViewField['pos'];
    }

    public function sync()
    {
        if (!$this->id) {
            $this->id = $this->sql->getValue("SELECT id FROM metaviewfield WHERE metaview_id={$this->metaViewId} AND metaattribute_id=".$this->metaAttributeId);
        }
        if ($this->id) {
            $this->sql->query("
            	UPDATE
            		metaviewfield
            	SET
            		uie='{$this->uie}', uieparams='{$this->uieParams}', defaultvalue='{$this->defaultValue}', required={$this->isRequired}, name='{$this->name}', hint='{$this->hint}', unit='{$this->unit}', mask='{$this->mask}', `group`='{$this->group}', pos={$this->pos}
                WHERE
                	id=".$this->id);
        } else {
            $this->id = $this->sql->insert("
            	INSERT INTO
            		metaviewfield (metaview_id, metaattribute_id, uie, uieparams, defaultvalue, required, name, hint, unit, mask, `group`, pos)
                VALUES
                	({$this->metaViewId}, {$this->metaAttributeId}, '{$this->uie}', '{$this->uieParams}', '{$this->defaultValue}', {$this->isRequired}, '{$this->name}', '{$this->hint}', '{$this->unit}', '{$this->mask}', '{$this->group}', {$this->pos})");
        }
    }

    public function delete()
    {
        $this->sql->query("DELETE FROM metaviewfield WHERE id=".$this->id);
    }

    public function setMetaView($metaViewCode)
    {
        $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code='$metaViewCode'");
        $this->metaObjectId = $this->sql->getValue("SELECT metaobject_id FROM metaview WHERE id=".$this->metaViewId);
        $this->metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE code='{$this->metaAttributeCode}' AND metaobject_id=".$this->metaObjectId);
    }
}

/**
 * MetaViewCondition - условие в мета-представлении
 *
 */
class ContenticoInstallerMetaViewCondition
{
    private $sql;
    
    public $id = 0;
    public $metaObjectId;
    public $metaViewId;
    public $metaAttributeId;
    public $metaAttributeCode;
    public $operation;
    public $value;
    public $customSql;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function initFromXml($conditionXml, $metaViewCode)
    {
        $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code='$metaViewCode'");
        if ($this->metaViewId) {
            $this->metaObjectId = $this->sql->getValue("SELECT metaobject_id FROM metaview WHERE id=".$this->metaViewId);
            $this->metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE code='".(string) $conditionXml['metaattribute']."' AND metaobject_id=".$this->metaObjectId);
        }
        $this->metaAttributeCode = (string) $conditionXml['metaattribute'];
        $this->operation = (string) $conditionXml['operation'];
        $this->value = (string) $conditionXml['value'];
        $this->customSql = (string) $conditionXml['sql'];
    }

    public function initFromDb($id)
    {
        $this->id = $id;
        $metaViewCondition = $this->sql->getRecord("SELECT * FROM metaviewcondition WHERE id=".$this->id);
        $this->metaViewId = $metaViewCondition['metaview_id'];
        $this->metaAttributeId = $metaViewCondition['metaattribute_id'];
        $this->operation = $metaViewCondition['operation'];
        $this->value = $metaViewCondition['value'];
        $this->customSql = $metaViewCondition['sql'];
    }

    public function sync()
    {
        $this->id = $this->sql->insert("
        	INSERT INTO
        		metaviewcondition (metaview_id, metaattribute_id, operation, value, `sql`)
            VALUES
            	({$this->metaViewId}, {$this->metaAttributeId}, '{$this->operation}', '{$this->value}', '{$this->customSql}')");
    }

    public function delete()
    {
        $this->sql->query("DELETE FROM metaviewcondition WHERE id=".$this->id);
    }

    public function setMetaView($metaViewCode)
    {
        $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code='$metaViewCode'");
        $this->metaObjectId = $this->sql->getValue("SELECT metaobject_id FROM metaview WHERE id=".$this->metaViewId);
        $this->metaAttributeId = $this->sql->getValue("
        	SELECT
        		id 
        	FROM
        		metaattribute
        	WHERE 
        		code='{$this->metaAttributeCode}' 
        		AND metaobject_id=".$this->metaObjectId);
    }
}

/**
 * MetaView - мета-представление
 *
 */
class ContenticoInstallerMetaView
{
    private $sql;
    
    public $id = 0;
    public $metaObjectId;
    public $code;
    public $type;
    public $name;
    public $treeMetaObjectId = 0;
    public $treeMetaObjectCode = false;
    public $template = '';
    public $templateRow = '';
    public $metaViewFields = array();
    public $metaViewConditions = false;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function initFromXml($metaViewXml, $metaObjectCode)
    {
        $this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
        $this->code = (string)$metaViewXml['code'];
        $this->name = (string)$metaViewXml['name'];
        switch ((string)$metaViewXml['type']) {
            case 'form':
                $this->type = META_VIEW_TYPE_FORM;
                break;

            case 'list':
                $this->type = META_VIEW_TYPE_LIST;
                break;

            case 'card':
                $this->type = META_VIEW_TYPE_CARD;
                break;

            case 'widget':
                $this->type = META_VIEW_TYPE_WIDGET;
                break;

            case 'quickform':
                $this->type = META_VIEW_TYPE_QUICKFORM;
                break;

            case 'quicklist':
                $this->type = META_VIEW_TYPE_QUICKLIST;
                break;
        }
        if ($this->type == META_VIEW_TYPE_LIST && (string) $metaViewXml->tree['metaobject'] != '') {
            $this->treeMetaObjectCode = (string) $metaViewXml->tree['metaobject'];
        }

        // fields (поля)
        $pos = 1;
        foreach($metaViewXml->fields->field as $metaViewFieldXml) {
            $metaViewField = new ContenticoInstallerMetaViewField();
            $metaViewField->initFromXml($metaViewFieldXml, $this->code, $pos);
            $this->metaViewFields[] = $metaViewField;
            $pos++;
        }

        // conditions (условия)
        if ($metaViewXml->conditions->condition) {
            $this->metaViewConditions = array();
            foreach ($metaViewXml->conditions->condition as $metaViewConditionXml) {
                $metaViewCondition = new ContenticoInstallerMetaViewCondition();
                $metaViewCondition->initFromXml($metaViewConditionXml, $this->code);
                $this->metaViewConditions[] = $metaViewCondition;
            }
        }

        // шаблоны
        if ($metaViewXml->template) {
            $this->template = addslashes(trim((string) $metaViewXml->template));
        }
        if ($metaViewXml->templaterow) {
            $this->templateRow = addslashes(trim((string) $metaViewXml->templaterow));
        }
    }

    public function initFromDb($id)
    {
        $this->id = $id;
        $metaView = $this->sql->getRecord("SELECT * FROM metaview WHERE id=".$this->id);
        $this->metaObjectId = $metaView['metaobject_id'];
        $this->code = $metaView['code'];
        $this->type = $metaView['type'];
        $this->name = $metaView['name'];
        $this->template = $metaView['template'];
        $this->templateRow = $metaView['templaterow'];
        $this->treeMetaObjectId = $metaView['tree_metaobject_id'];
    }

    public function sync()
    {
        if (!$this->id) {
            $this->id = $this->sql->getValue("SELECT id FROM metaview WHERE code='{$this->code}'");
        }
        if ($this->treeMetaObjectCode) {
            $this->treeMetaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->treeMetaObjectCode}'");
        }
        if ($this->id) {
            $this->sql->query("
            	UPDATE
            		metaview
            	SET
            		code='{$this->code}', type={$this->type}, name='{$this->name}', tree_metaobject_id={$this->treeMetaObjectId}, template='{$this->template}', templaterow='{$this->templateRow}' WHERE id=".$this->id);
        } else {
            $this->id = $this->sql->insert("
            	INSERT INTO
            		metaview (metaobject_id, code, type, name, tree_metaobject_id, template, templaterow)
                VALUES
                	({$this->metaObjectId}, '{$this->code}', {$this->type}, '{$this->name}', {$this->treeMetaObjectId}, '{$this->template}', '{$this->templateRow}')");
        }
    }

    public function delete()
    {
        $this->sql->query("DELETE FROM metaview WHERE id=".$this->id);
        $this->sql->query("DELETE FROM metaviewfield WHERE metaview_id=".$this->id);
        $this->sql->query("DELETE FROM metaviewcondition WHERE metaview_id=".$this->id);
        $this->id = 0;
    }

    public function setMetaObject($metaObjectCode)
    {
        $this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='$metaObjectCode'");
    }
}

/**
 * MetaRelation - отношение между мета-объектами
 *
 */
class ContenticoInstallerMetaRelation
{
    private $sql;
    
    public $fromId;
    public $fromCode;
    public $toId;
    public $toCode;
    public $type;

    public function __construct($fromCode, $toCode, $type)
    {
        $this->sql = SqlDataSource::getInstance();
        $this->fromCode = $fromCode;
        $this->toCode = $toCode;
        $this->initType($type);
    }

    public function init($fromCode, $toCode, $type)
    {
        $this->fromCode = $fromCode;
        $this->toCode = $toCode;
        $this->initType($type);
    }

    private function initType($type)
    {
        switch ($type)
        {
            case 'parent':
                $this->type = META_RELATION_PARENT;
                break;

            case 'reason':
                $this->type = META_RELATION_REASON;
                break;

            case 'partof':
                $this->type = META_RELATION_PARTOF;
                break;
        }
    }

    public function create()
    {
        $this->fromId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='$this->fromCode'");
        $this->toId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='$this->toCode'");
        $this->sql->query("
        	INSERT INTO
        		metarelation (`from`, `to`, type)
        	VALUES
        		({$this->fromId}, {$this->toId}, {$this->type})");
    }

    public function delete()
    {
        $this->fromId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='$this->fromCode'");
        $this->toId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='$this->toCode'");
        $this->sql->query("
        	DELETE FROM
        		metarelation
        	WHERE
        		`from`={$this->fromId}
        		AND `to`={$this->toId}
        		AND type={$this->type}");
    }
}

/**
 * MetaObject - мета-объект
 *
 */
class ContenticoInstallerMetaObject
{
    private $sql;
    
    public $id = 0;
    public $code;
    public $oldCode;
    public $versions;
    public $logs;
    public $sqlEngine = 'InnoDb';
    public $sqlPartitionMethod = '';
    public $sqlPartitionExpression = '';
    public $sqlPartitions = 0;
    public $sqlMerge = 0;
    public $sqlQueries = array();
    public $extends = false;
    public $extendsMetaObjectCode = '';
    public $extendsMetaObjectId = 0;
    public $extendsType = 0;
    public $metaAttributes = array();
    public $contentico = false;
    public $contenticoParamsSortBy = '';
    public $contenticoParamsSortOrder = '';
    public $contenticoParamsGroupBy = '';
    public $contenticoParamsGroupStyle = '';
    public $contenticoParamsExportMetaAtttributeCode = '';
    public $contenticoParamsExportMetaAtttributeId = 0;
    public $contenticoParamsMenuPos = 0;
    public $contenticoActionsList = '';
    public $contenticoActionsView = '';
    public $contenticoActionsCreate = '';
    public $contenticoActionsEdit = '';
    public $contenticoActionsDelete = '';
    public $contenticoName = '';
    public $metaViews = false;
    public $metaRelations = false;
    public $rows = false;
    public $installerGenerateClass = false;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function initFromXml($metaObjectXml)
    {
        // propertions
        $this->code = (string) $metaObjectXml['code'];
        $this->oldCode = (string) $metaObjectXml['oldcode'];
        $this->versions = (int) $metaObjectXml['versions'];
        $this->logs = (int) $metaObjectXml['logs'];
        // extends
        if ($metaObjectXml->extends) {
            $this->extends = true;
            $this->extendsMetaObjectCode = (string) $metaObjectXml->extends['metaobject'];
            $this->extendsMetaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->extendsMetaObjectCode}'");
            $this->extendsType = (int) $metaObjectXml->extends['type'] == META_OBJECT_EXTENDS_LOGICAL ? META_OBJECT_EXTENDS_LOGICAL : META_OBJECT_EXTENDS_PHYSICAL;
        }
        // attributes
        foreach ($metaObjectXml->metaattributes->metaattribute as $metaAttributeXml) {
            $metaAttribute = new ContenticoInstallerMetaAttribute();
            $metaAttribute->initFromXml($metaAttributeXml, $this->code);
            $this->metaAttributes[] = $metaAttribute;
        }
        // backend
        if ($metaObjectXml->contentico) {
            $this->contentico = true;
            // params
            $this->contenticoName = (string) $metaObjectXml->contentico->params['name'];
            $this->contenticoParamsSortBy = (string) $metaObjectXml->contentico->params['sortby'];
            $this->contenticoParamsSortOrder = (string) $metaObjectXml->contentico->params['sortorder'];
            $this->contenticoParamsGroupBy = (string) $metaObjectXml->contentico->params['groupby'];
            $this->contenticoParamsGroupStyle = (string) $metaObjectXml->contentico->params['groupstyle'];
            $this->contenticoParamsExportMetaAtttributeCode = (string) $metaObjectXml->contentico->params['export'];
            $this->contenticoParamsMenuPos = (int) $metaObjectXml->contentico->params['menupos'];
            // actions
            $this->contenticoActionsList = (int) $metaObjectXml->contentico->actions['list'] == 1 ? 1 : 0;
            $this->contenticoActionsView = (int) $metaObjectXml->contentico->actions['view'] == 1 ? 1 : 0;
            $this->contenticoActionsCreate = (int) $metaObjectXml->contentico->actions['create'] == 1 ? 1 : 0;
            $this->contenticoActionsEdit = (int) $metaObjectXml->contentico->actions['edit'] == 1 ? 1 : 0;
            $this->contenticoActionsDelete = (int) $metaObjectXml->contentico->actions['delete'] == 1 ? 1 : 0;
        }
        // views
        if ($metaObjectXml->metaviews->metaview) {
            $this->metaViews = array();
            foreach ($metaObjectXml->metaviews->metaview as $metaViewXml) {
                $metaView = new ContenticoInstallerMetaView();
                $metaView->initFromXml($metaViewXml, $this->code);
                $this->metaViews[] = $metaView;
            }
        }
        // relations
        if ($metaObjectXml->metarelations) {
            $this->metaRelations = array();
            if ($metaObjectXml->metarelations->relation) {
                foreach ($metaObjectXml->metarelations->relation as $relation) {
                    $this->metaRelations[] = new ContenticoInstallerMetaRelation((string) $relation['from'], $this->code, (string) $relation['type']);
                }
            }
        }
        // rows
        if ($metaObjectXml->rows->row) {
            $this->rows = array();
            foreach ($metaObjectXml->rows->row as $row) {
                $newRow = array('id'=>(int)$row['id']);
                foreach ($row as $metaAttributeCode=>$value) {
                    $newRow[$metaAttributeCode] = trim((string) $value);
                    foreach ($this->metaAttributes as $metaAttribute) {
                        if ($metaAttribute->code == $metaAttributeCode) {
                            if ($metaAttribute->type == META_ATTRIBUTE_TYPE_PASSWORD) {
                                $newRow[$metaAttributeCode] = sha1($newRow[$metaAttributeCode]);
                            }
                            break;
                        }
                    }
                }
                $this->rows[] = $newRow;
            }
        }
        // installer options
        if ((int) $metaObjectXml->installer['generateclass'] == 1) {
            $this->installerGenerateClass = true;
        }
        // sql options
        if ($metaObjectXml->sql) {
            $this->sqlEngine = (string) $metaObjectXml->sql['engine'];
            $this->sqlPartitionMethod = strtoupper((string) $metaObjectXml->sql['partitionmethod']);
    		$this->sqlPartitionExpression = (string) $metaObjectXml->sql['partitionexpression'];
    		if ($this->sqlPartitionMethod == 'KEY' || $this->sqlPartitionMethod == 'HASH') {
		    	$this->sqlPartitions = (int) $metaObjectXml->sql['partitions'];
		    } else {
		    	$this->sqlPartitions = (string) $metaObjectXml->sql['partitions'];
		    }
		    $this->sqlMerge = (int) $metaObjectXml->sql['merge'];

            if ($metaObjectXml->sql->query) {
                foreach ($metaObjectXml->sql->query as $query) {
                    $this->sqlQueries[] = (string)$query;
                }
            }
        }
    }

    public function sync()
    {
        $oldCode = $this->oldCode != '' ? $this->oldCode : $this->code;
        $curObject = $this->sql->getRecord("SELECT * FROM metaobject WHERE code='$oldCode'");
        if ($curObject) {
            $this->id = $curObject['id'];
            $this->sql->query("
            	UPDATE
            		metaobject
            	SET
            		code='{$this->code}', logs={$this->logs}, versions={$this->versions}, extendsmetaobject_id={$this->extendsMetaObjectId}, extendstype={$this->extendsType}
            	WHERE
            		id=".$this->id);
            // code & rename
            if ($curObject['code'] != $this->code) {
                //$this->sql->query("ALTER TABLE `{$curObject['code']}` RENAME `{$this->code}`");
                if ($curObject['versions'] == META_OBJECT_VERSIONS_ALL) {
                    //$this->sql->query("ALTER TABLE `{$curObject['code']}__versions` RENAME `{$this->code}__versions`");
                }
                if ($curObject['logs']) {
                    //$this->sql->query("ALTER TABLE `{$curObject['code']}__log` RENAME `{$this->code}__log`");
                }
            }
            // атрибуты
            $currentMetaAttributes = $this->sql->getValueSet("SELECT code FROM metaattribute WHERE metaobject_id=".$this->id);
            $metaAttributes = array();
            if ($currentMetaAttributes) {
                foreach ($currentMetaAttributes as $metaAttribute) {
                    $metaAttributes[$metaAttribute] = false;
                }
            }
            foreach ($this->metaAttributes as $metaAttribute) {
                if (in_array($metaAttribute->code, $currentMetaAttributes) || in_array($metaAttribute->oldCode, $currentMetaAttributes)) {
                    $metaAttribute->sync();
                    $metaAttributes[$metaAttribute->code] = true;
                    $metaAttributes[$metaAttribute->oldCode] = true;
                } else {
                    $metaAttribute->create();
                }
            }
            // удаление более ненужных метаобъектов
            foreach ($metaAttributes as $metaAttributeCode => $processed) {
                if (!$processed) {
                    $metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE code='$metaAttributeCode' AND metaobject_id=".$this->id);
                    $metaAttribute = new ContenticoInstallerMetaAttribute();
                    $metaAttribute->initFromDb($metaAttributeId);
                    $metaAttribute->delete();
                }
            }
            // engine
            $sqlEngine = $this->sql->getValue("
    			SELECT ENGINE 
    			FROM information_schema.TABLES
    			WHERE TABLE_SCHEMA='".$GLOBALS['configDb']['db']."' AND TABLE_NAME='{$this->code}'");
    		if (strtolower($sqlEngine) != strtolower($this->sqlEngine)) {
    			//$this->sql->query("ALTER TABLE `{$this->code}` ENGINE=".$this->sqlEngine);
    		}
    		
            $this->syncSqlKeys();
            
            $this->syncSqlPartitions();
            
            $this->syncMergeTable();

            $this->doSqlQueries();

            // versions
            if ($curObject['versions'] == META_OBJECT_VERSIONS_ALL && $this->versions == META_OBJECT_VERSIONS_LATEST) {
                $this->sql->query("DROP TABLE `{$this->code}__versions`");
            } elseif ($this->versions == META_OBJECT_VERSIONS_ALL && $curObject['versions'] == META_OBJECT_VERSIONS_LATEST) {
                $this->createVersionsTable();
                $this->createVersionsTableStructure();
                $this->syncSqlKeys(true);
            }

            // logs
            if ($curObject['logs'] && !$this->logs) {
                $this->sql->query("DROP TABLE `{$this->code}__logs`");
            } elseif ($this->logs && !$curObject['logs']) {
                $this->createLogsTable();
            }

            $this->syncContenticoParams();
        } else {
            $this->create();
        }
        $this->syncRows();
    }

    public function create()
    {
        $this->id = $this->sql->insert("
        	INSERT INTO
        		metaobject (code, logs, versions, extendsmetaobject_id, extendstype)
            VALUES
            	('{$this->code}', {$this->logs}, {$this->versions}, {$this->extendsMetaObjectId}, {$this->extendsType})");
        // атрибуты
        $this->sql->query("
            CREATE TABLE `{$this->code}` (
            " . $this->getMetaAttributesSql() . "
            ) ENGINE=".$this->sqlEngine." DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
        ");
        //
        foreach ($this->metaAttributes as $metaAttribute)
        {
            $metaAttribute->setMetaObject($this->code);
            $metaAttribute->createMeta();
        }
        //
        $this->syncSqlKeys();
        //
        $this->syncSqlPartitions();
        // merge таблица
        $this->syncMergeTable();
        // versions
        if ($this->versions == META_OBJECT_VERSIONS_ALL) {
            $this->createVersionsTable();
            $this->createVersionsTableStructure();
            $this->syncSqlKeys(true);
        }
        // logs
        if ($this->logs) {
            $this->createLogsTable();
        }
        // Contentico params
        $this->syncContenticoParams();
    }
    
    private function getMetaAttributesSql()
    {
    	$metaAttributesSql = array();
        $primaryKey = '';
        foreach ($this->metaAttributes as $metaAttribute) {
            $metaAttributeSql = SqlDataSource::getSqlByType($metaAttribute->type, $metaAttribute->typeParam);
            if ($metaAttributeSql) {
                $metaAttributesSql[] = "`{$metaAttribute->code}` $metaAttributeSql";
            }
            if ($metaAttribute->sqlPrimaryKey) {
                $primaryKey = ", PRIMARY KEY (`{$metaAttribute->code}`)";
            }
        }
        return implode(',', $metaAttributesSql) . $primaryKey;
    }
    
    private function syncMergeTable()
    {
    	$this->sql->query("DROP TABLE IF EXISTS `" . $this->code . "_merge`");
    	
    	if ($this->sqlMerge) {
    		$this->sql->query("CREATE TABLE `" . $this->code . "_merge` (
    			" . $this->getMetaAttributesSql() . "
				) ENGINE=MERGE UNION(" . $this->code . ") INSERT_METHOD=first DEFAULT CHARSET=utf8;");
			$this->syncSqlKeys('_merge');
		}
    }

    private function doSqlQueries()
    {
        foreach ($this->sqlQueries as $query) {
            $this->sql->query($query);
        }
    }
    
    private function syncSqlPartitions()
    {
    	if ((float)substr($this->sql->getValue("SELECT version()"), 0, 3) < 5.1) {
    		return;
    	}
    	//
    	$curPartition = $this->sql->getRecordSet("
    		SELECT PARTITION_NAME, PARTITION_METHOD, PARTITION_EXPRESSION
    		FROM information_schema.PARTITIONS
    		WHERE TABLE_SCHEMA='".$GLOBALS['configDb']['db']."' AND TABLE_NAME='{$this->code}'");
    	if ($curPartition && $curPartition[0]['PARTITION_NAME'] != NULL) {
	    	$partition = $curPartition[0];
	    	$partition['count'] = sizeof($curPartition);
	    } else {
	    	$partition = false;
	    }
	    //
	    if ($partition) {
	    	if ($partition['PARTITION_METHOD'] == $this->sqlPartitionMethod && $partition['PARTITION_EXPRESSION'] == $this->sqlPartitionExpression) {
	    		if ($this->sqlPartitions < $partition['count']) {
	    			//$this->sql->query("ALTER TABLE `".$this->code."` COALESCE PARTITION ".($partition['count'] - $this->sqlPartitions));
	    		} elseif ($this->sqlPartitions > $partition['count']) {
	    			//$this->sql->query("ALTER TABLE `".$this->code."` ADD PARTITION PARTITIONS ".($this->sqlPartitions - $partition['count']));
	    		}
	    		return;
	    	} else {
	    		//$this->sql->query("ALTER TABLE `".$this->code."` DROP PARTITION ".$partition['PARTITION_NAME']);
	    	}
	    }
	    //
	   	if ($this->sqlPartitionMethod && $this->sqlPartitionExpression && $this->sqlPartitions) {
	    	//$this->sql->query("ALTER TABLE `".$this->code."` PARTITION BY ".$this->sqlPartitionMethod."(".$this->sqlPartitionExpression.") PARTITIONS ".$this->sqlPartitions);
	    }
    }

    private function syncSqlKeys($table='')
    {
        // составление списка имеющихся индексов
        $currentKeys = array();
        $keys = $this->sql->getRecordSet("SHOW INDEX FROM `{$this->code}" . $table . "`");
        if ($keys) {
            foreach ($keys as $key) {
                if ($key['Key_name'] == 'PRIMARY') {
                    $type = 'Primary';
                } elseif ($key['Non_unique'] == 0) {
                    $type = 'Unique';
                } elseif ($key['Non_unique'] == 1) {
                    $type = 'Index';
                }
                if (array_key_exists($key['Key_name'], $currentKeys)) {
                    $currentKeys[$key['Key_name']]['columns'][] = $key['Column_name'];
                } else {
                    $currentKeys[$key['Key_name']] = array(
                        'type' => $type,
                        'name' => $key['Key_name'],
                        'columns' => array($key['Column_name']),
                        'column' => $key['Column_name'],
                        'processed' => false,
                    );
                }
            }
        }
        // составление списка новых индексов
        $newKeys = array();
        foreach ($this->metaAttributes as $metaAttribute) {
            /*
            if ($metaAttribute->sqlPrimaryKey)
            {
                $newKeys['PRIMARY'] = array(
                    'type' => 'Primary',
                    'name' => 'PRIMARY',
                    'columns' => array($metaAttribute->code),
                    'column' => $metaAttribute->code,
                    'processed' => false,
                );
            }
            */
            if ($metaAttribute->sqlIndex || $metaAttribute->sqlUnique || $metaAttribute->sqlPrimaryKey) {
            	if ($metaAttribute->sqlPrimaryKey) {
                    $keyName = 'PRIMARY';
                } elseif ($metaAttribute->sqlIndex) {
                    if (is_numeric((string)$metaAttribute->sqlIndex)) {
                        $keyName = "ix__{$this->code}__{$metaAttribute->code}" . $table;
                    } else {
                        $keyName = "ix__{$this->code}__".(string)$metaAttribute->sqlIndex . $table;
                    }
                } elseif ($metaAttribute->sqlUnique) {
                    if (is_numeric((string)$metaAttribute->sqlUnique)) {
                        $keyName = "uq__{$this->code}__{$metaAttribute->code}" . $table;
                    } else {
                        $keyName = "uq__{$this->code}__".(string)$metaAttribute->sqlUnique . $table;
                    }
                }
                if (array_key_exists($keyName, $newKeys)) {
                    $newKeys[$keyName]['columns'][] = $metaAttribute->code;
                } else {
                    $newKeys[$keyName] = array(
                        'type' => $metaAttribute->sqlPrimaryKey ? 'Primary' : ($metaAttribute->sqlIndex ? 'Index' : 'Unique'),
                        'name' => $keyName,
                        'columns' => array($metaAttribute->code),
                        'column' => $metaAttribute->code,
                        'processed' => false,
                    );
                }
            }
        }
        // применение изменений
        // primary
        if (array_key_exists('PRIMARY', $currentKeys)) {
        	if (array_key_exists('PRIMARY', $newKeys)) {
	            $columnsFound = true;
    	        foreach ($newKeys['PRIMARY']['columns'] as $column) {
        	    	if (!in_array($column, $currentKeys['PRIMARY']['columns'])) {
            			$columnsFound = false;
            			break;
	            	}
    	        }
        	    if ($columnsFound) {
            	    $currentKeys['PRIMARY']['processed'] = true;
	            } else {
            	    //$this->sql->query("ALTER TABLE `{$this->code}" . $table . "` DROP PRIMARY KEY");
	            }
	        } else {
	        	//$this->sql->query("ALTER TABLE `{$this->code}" . $table . "` DROP PRIMARY KEY");
	        }
        }
        if (array_key_exists('PRIMARY', $newKeys) && (!array_key_exists('PRIMARY', $currentKeys) || !$currentKeys['PRIMARY']['processed'])) {
            //$this->sql->query("ALTER TABLE `{$this->code}" . $table . "` ADD PRIMARY KEY (`".implode('`,`', $newKeys['PRIMARY']['columns'])."`)");
        }
        $currentKeys['PRIMARY']['processed'] = true;
        // index, unique
        foreach ($newKeys as $keyName=>$key) {
            if ($keyName == 'PRIMARY') {
            	continue;
            }
            $found = false;
            if (array_key_exists($keyName, $currentKeys)) {
                $columnsFound = true;
                foreach ($key['columns'] as $column) {
                    if (!in_array($column, $currentKeys[$keyName]['columns'])) {
                        $columnsFound = false;
                        break;
                    }
                }
                if ($columnsFound && $key['type'] == $currentKeys[$keyName]['type'] && sizeof($key['columns']) == sizeof($currentKeys[$keyName]['columns'])) {
                    $found = true;
                    $currentKeys[$keyName]['processed'] = true;
                }
                if (!$found) {
                    //$this->sql->query("ALTER TABLE `{$this->code}" . $table . "` DROP INDEX $keyName");
                    $currentKeys[$keyName]['processed'] = true;
                }
            }
            if (!$found) {
                //$this->sql->query("ALTER TABLE `{$this->code}" . $table . "` ADD ".($key['type'] == 'Index' ? 'INDEX' : 'UNIQUE')." $keyName (`".implode('`,`', $key['columns'])."`)");
            }
        }
        // удаление старых индексов
        foreach ($currentKeys as $keyName=>$key) {
            if (!$key['processed']) {
                //$this->sql->query("ALTER TABLE `{$this->code}" . $table . "` DROP INDEX $keyName");
            }
        }
    }

    private function syncRows()
    {
        if ($this->rows) {
            foreach ($this->rows as $row) {
                if ($this->sql->getValue("SELECT count(*) FROM `{$this->code}` WHERE id={$row['id']}") == 1) {
                    $columns = array();
                    foreach ($row as $column=>$value) {
                        if ($column == 'id') {
                            continue;
                        } else {
                            $columns[] = "`$column`='$value'";
                        }
                    }
                    $this->sql->query("UPDATE `{$this->code}` SET ".implode(', ', $columns)." WHERE id={$row['id']}");
                } else {
                    $columns = array();
                    $values = array();
                    foreach ($row as $column=>$value) {
                        $columns[] = "`$column`";
                        $values[] = "'$value'";
                    }
                    $this->sql->insert("INSERT INTO `{$this->code}` (".implode(',', $columns).") VALUES (".implode(',', $values).")");
                }
            }
        }
    }

    private function syncContenticoParams()
    {
        if ($this->contentico) {
            $this->contenticoParamsExportMetaAtttributeId = $this->contenticoParamsExportMetaAtttributeCode ? $this->sql->getValue("
            	SELECT
            		id
            	FROM metaattribute
                WHERE
                	code='{$this->contenticoParamsExportMetaAtttributeCode}'
                	AND metaobject_id=".$this->id) : 0;
            $this->sql->query("
            	REPLACE INTO
            		sysparams
            	SET
            		metaobject_id={$this->id},
            		name='{$this->contenticoName}',
                	sortby='{$this->contenticoParamsSortBy}',
                	sortorder='{$this->contenticoParamsSortOrder}',
	                groupby='{$this->contenticoParamsGroupBy}',
    	            groupstyle='{$this->contenticoParamsGroupStyle}',
        	        action_list={$this->contenticoActionsList},
            	    action_view={$this->contenticoActionsView},
                	action_create={$this->contenticoActionsCreate},
	                action_edit={$this->contenticoActionsEdit},
    	            action_delete={$this->contenticoActionsDelete},
        	        export_metaattribute_id={$this->contenticoParamsExportMetaAtttributeId},
            	    menupos={$this->contenticoParamsMenuPos}");
        } else {
            $this->sql->query("DELETE FROM sysparams WHERE metaobject_id=".$this->id);
        }
    }

    public function delete()
    {
        $metaAttributes = $this->sql->getValueSet("SELECT id FROM metaattribute WHERE metaobject_id=".$this->id);
        if ($metaAttributes) {
            foreach ($metaAttributes as $metaAttributeId) {
                $metaAttribute = new ContenticoInstallerMetaAttribute();
                $metaAttribute->initFromDb($metaAttributeId);
                $metaAttribute->delete();
            }
        }
        $metaViews = $this->sql->getValueSet("SELECT id FROM metaview WHERE metaobject_id=".$this->id);
        if ($metaViews) {
            foreach ($metaViews as $metaViewId) {
                $metaView = new ContenticoInstallerMetaView();
                $metaView->initFromDb($metaViewId);
                $metaView->delete();
            }
        }
        $this->sql->query("DELETE FROM metaobject WHERE id=".$this->id);
        $this->sql->query("DELETE FROM metarelation WHERE `from`=".$this->id." OR `to`=".$this->id);
        $this->sql->query("DELETE FROM sysparams WHERE metaobject_id=".$this->id);
        $this->sql->query("DROP TABLE `{$this->code}`");
    }

    public function createLogsTable()
    {
        $this->sql->query("
            CREATE TABLE `{$this->code}__log` (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                object_id INT UNSIGNED NOT NULL,
                event_id TINYINT (3) UNSIGNED NOT NULL,
                sysuser_id INT UNSIGNED NOT NULL,
                dt DATETIME NOT NULL,
                version_id INT UNSIGNED NOT NULL,
                PRIMARY KEY (id),
                KEY `ix__{$this->code}_log__object_id` (`object_id`)
            ) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
        ");
    }

    public function createVersionsTable()
    {
        $this->sql->query("
            CREATE TABLE `{$this->code}__versions` (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                _object_id INT UNSIGNED NOT NULL,
                _dt DATETIME NOT NULL default now(),
                PRIMARY KEY (id),
                KEY `ix__{$this->code}_versions___object_id` (`_object_id`)
            ) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
        ");
    }

    public function createVersionsTableStructure()
    {
        $metaAttributes = $this->sql->getRecordSet("SELECT * FROM metaattribute WHERE metaobject_id=".$this->id." ORDER BY id ASC");
        foreach ($metaAttributes as $metaAttribute) {
            $metaAttributeSql = SqlDataSource::getSqlByType($field['type'], $field['typeparam']);
            if ($metaAttributeSql) {
                //$this->sql->query("ALTER TABLE `{$this->code}_versions` ADD `{$field['code']}` $metaAttributeSql");
            }
        }
    }
}

class ContenticoInstallerClassGenerator
{
    private $sql;
    
    public $metaObjectCode;
    public $metaObjectId;
    public $metaAtributes;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function setMetaObject($metaObjectCode)
    {
        $this->metaObjectCode = $metaObjectCode;
        $this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
        $this->metaAtributes = $this->sql->getRecordSet("SELECT id, code, type, typeparam, role FROM metaattribute WHERE metaobject_id=".$this->metaObjectId);
    }

    public function generateClass()
    {
        $classFile = '<?php
class '.$this->metaObjectCode.'BaseObject extends Object
{
	public static $METAOBJECT = \''.$this->metaObjectCode.'\';
';
        foreach ($this->metaAtributes as $metaAttribute)
        {
            if ($metaAttribute['role'] == META_ATTRIBUTE_ROLE_ID)
            {
                $classFile .= '    public static $ID_METAATTRIBUTE = \''.$this->metaObjectCode.'.'.$metaAttribute['code'].'\';
';
				if ($metaAttribute['code'] == 'id')
				{
					$classFile .= ' 	public static $ID = \''.$this->metaObjectCode.'.id\';
';
					continue;
				}
            }
            switch ($metaAttribute['type'])
            {
                case META_ATTRIBUTE_TYPE_INT:
                case META_ATTRIBUTE_TYPE_FLOAT:
                case META_ATTRIBUTE_TYPE_BOOL:
                case META_ATTRIBUTE_TYPE_FILE:
                case META_ATTRIBUTE_TYPE_IMAGE:
                    $classFile .= '    public $'.$metaAttribute['code'].' = 0;
';
                    break;
                case META_ATTRIBUTE_TYPE_DATE:
                    $classFile .= '    public $'.$metaAttribute['code'].' = \'0000-00-00\';
';
                    break;
                case META_ATTRIBUTE_TYPE_DATETIME:
                    $classFile .= '    public $'.$metaAttribute['code'].' = \'0000-00-00 00:00:00\';
';
                    break;
                case META_ATTRIBUTE_TYPE_STRING:
                case META_ATTRIBUTE_TYPE_TEXT:
                case META_ATTRIBUTE_TYPE_BIGTEXT:
                case META_ATTRIBUTE_TYPE_DATA:
                    $classFile .= '    public $'.$metaAttribute['code'].' = \'\';
';
                    break;
                case META_ATTRIBUTE_TYPE_DICTIONARY:
                    $classFile .= '    public $'.$metaAttribute['code'].' = \'\';
    public $'.$metaAttribute['code'].'_Dictionary = array('.$_SESSION['contentico_installer'][$this->metaObjectCode.'_'.$metaAttribute['code'].'_dictionary'].');
';
                    break;
                case META_ATTRIBUTE_TYPE_CUSTOM:
                    $classFile .= '    public $'.$metaAttribute['code'].' = \'\';
';
                    break;
                case META_ATTRIBUTE_TYPE_PASSWORD:
                    $classFile .= '    public $'.$metaAttribute['code'].' = \''.sha1('').'\';
';
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                	$classFile .= '    public $'.$metaAttribute['code'].' = 0;
';
					break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    $classFile .= '    public $'.$metaAttribute['code'].' = array();
';
                    break;
            }
            $classFile .= '    public static $'.strtoupper($metaAttribute['code']).' = \''.$this->metaObjectCode.'.'.$metaAttribute['code'].'\';
';
        }
    $classFile .= '
    public function __construct()
    {
        parent::__construct(\''.$this->metaObjectCode.'\');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
';
        foreach ($this->metaAtributes as $metaAttribute)
        {
            if ($metaAttribute['code'] == 'id')
            {
                continue;
            }
            switch ($metaAttribute['type'])
            {
                case META_ATTRIBUTE_TYPE_INT:
                case META_ATTRIBUTE_TYPE_FLOAT:
                case META_ATTRIBUTE_TYPE_BOOL:
                case META_ATTRIBUTE_TYPE_FILE:
                case META_ATTRIBUTE_TYPE_IMAGE:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = 0;
';
                    break;
                case META_ATTRIBUTE_TYPE_DATE:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = \'0000-00-00\';
';
                    break;
                case META_ATTRIBUTE_TYPE_DATETIME:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = \'0000-00-00 00:00:00\';
';
                    break;
                case META_ATTRIBUTE_TYPE_STRING:
                case META_ATTRIBUTE_TYPE_TEXT:
                case META_ATTRIBUTE_TYPE_BIGTEXT:
                case META_ATTRIBUTE_TYPE_DATA:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = \'\';
';
                    break;
                case META_ATTRIBUTE_TYPE_DICTIONARY:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = \'\';
';
                    break;
                case META_ATTRIBUTE_TYPE_CUSTOM:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = \'\';
';
                    break;
                case META_ATTRIBUTE_TYPE_PASSWORD:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = \''.sha1('').'\';
';
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                	$classFile .= '        $this->'.$metaAttribute['code'].' = 0;
';
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    $classFile .= '        $this->'.$metaAttribute['code'].' = array();
';
                    break;
            }
        }
    $classFile .= '    }

	/**
	 * Инициализация свойств объекта из ассоциативного массива
	 *
	 * @param array
	 */
    public function init($object)
    {
        if (isset($object[\'id\']))
        {
            $this->id = $object[\'id\'];
        }
';
        foreach ($this->metaAtributes as $metaAttribute)
        {
            if ($metaAttribute['code'] == 'id')
            {
                continue;
            }
            $classFile .= '        $this->'.$metaAttribute['code'].' = $object[\''.$metaAttribute['code'].'\'];
';
			/* инициализация подобъектов
			if ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_LINKTOOBJECT)
			{
				$classFile .= '        if ($object[\''.$metaAttribute['code'].'\'] > 0)
        {
            Std::loadMetaObjectClass(\''.$metaAttribute['typeparam'].'\');
            $this->'.$metaAttribute['code'].' = new '.$metaAttribute['typeparam'].'Object();
            $this->'.$metaAttribute['code'].'->load($object[\''.$metaAttribute['code'].'\']);
        }
';
			}
			*/
        }
    $classFile .= '    }

	/**
	 * Инициализация свойств объекта из формы (POST)
	 *
	 */
    public function initFromForm($id=0)
    {
        if ($id)
        {
            $this->id = $id;
        }
        else
        {
            if (isset($_POST[\'id\']))
            {
                $this->id = (int) $_POST[\'id\'];
            }
            if (isset($_GET[\'id\']))
            {
                $this->id = (int) $_GET[\'id\'];
            }
        }
        if (!$this->metaViewId)
        {
            $metaView = isset($_GET[\'metaview\']) ? $_GET[\'metaview\'] : (isset($_POST[\'metaview\']) ? $_POST[\'metaview\'] : 0);
            if ($metaView)
            {
                if (is_numeric((int) $metaView))
                {
                    $this->metaViewId = (int) $metaView;
                }
                else
                {
                    $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code=\''.Std::CleanString($metaView).'\'");
                }
            }
        }
        if ($this->id)
        {
            $this->load($this->id);
        }
';
        $metaViews = $this->sql->getValueSet("SELECT id FROM metaview WHERE metaobject_id={$this->metaObjectId} AND (type=".META_VIEW_TYPE_FORM." OR type=".META_VIEW_TYPE_QUICKFORM.")");
        $classFile .= '        switch ($this->metaViewId)
        {
';
        if ($metaViews)
        {
            foreach ($metaViews as $metaViewId)
            {
                $classFile .= '            case '.$metaViewId.':
';
                $metaAtributes = $this->sql->getRecordSet("
                	SELECT
                		ma.id, ma.code, ma.type, ma.typeparam
                	FROM
                		metaviewfield mvf
                    	LEFT JOIN metaattribute ma ON ma.id=mvf.metaattribute_id
                    WHERE
                    	mvf.metaview_id=".$metaViewId);
                foreach ($metaAtributes as $metaAttribute)
                {
                    if ($metaAttribute['code'] == 'id')
                    {
                        continue;
                    }
                    switch ($metaAttribute['type'])
                    {
                        case META_ATTRIBUTE_TYPE_ID:
                        case META_ATTRIBUTE_TYPE_INT:
                        case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                            $classFile .= '                $this->'.$metaAttribute['code'].' = (int) $_POST[\''.$metaAttribute['code'].'\'];
';
                            break;
                        case META_ATTRIBUTE_TYPE_FLOAT:
                            $classFile .= '                $this->'.$metaAttribute['code'].' = (double) str_replace(\',\', \'.\', $_POST[\''.$metaAttribute['code'].'\']);
';
                            break;
                        case META_ATTRIBUTE_TYPE_STRING:
                            //$classFile .= '                $this->'.$metaAttribute['code'].' = str_replace(\'"\', \'&quot;\', Std::cleanString($_POST[\''.$metaAttribute['code'].'\']));
                            $classFile .= '                $this->'.$metaAttribute['code'].' = str_replace(\'"\', \'&quot;\', $_POST[\''.$metaAttribute['code'].'\']);
';
                            break;
                        case META_ATTRIBUTE_TYPE_TEXT:
                        case META_ATTRIBUTE_TYPE_BIGTEXT:
                        case META_ATTRIBUTE_TYPE_DICTIONARY:
                            //$classFile .= '                $this->'.$metaAttribute['code'].' = Std::cleanString($_POST[\''.$metaAttribute['code'].'\']);
                            $classFile .= '                $this->'.$metaAttribute['code'].' = $_POST[\''.$metaAttribute['code'].'\'];
';
                            break;
                        case META_ATTRIBUTE_TYPE_DATA:
                            $classFile .= '                $this->'.$metaAttribute['code'].' = base64_encode($_POST[\''.$metaAttribute['code'].'\']);
';
                            break;
                        case META_ATTRIBUTE_TYPE_DATETIME:
                            $classFile .= '                $dt = preg_replace(\'/[^\d\.\-\s:]/\', \'\', trim($_POST[\''.$metaAttribute['code'].'\']));
                if ($dt == \'\')
                {
                    $dt = \'00.00.0000 00:00\';
                }
                $dt = explode(\' \', $dt);
                $d = explode(\'.\', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].\':00\' : $dt[1];
                $this->'.$metaAttribute['code'].' = $d[2].\'-\'.$d[1].\'-\'.$d[0].\' \'.$t;
';
                            break;
                        case META_ATTRIBUTE_TYPE_DATE:
                            $classFile .= '                $dt = preg_replace(\'/[^\d\.\-\s:]/\', \'\', trim($_POST[\''.$metaAttribute['code'].'\']));
                if ($dt == \'\')
                {
                    $dt = \'00.00.0000\';
                }
                $d = explode(\'.\', $dt);
                $this->'.$metaAttribute['code'].' = $d[2].\'-\'.$d[1].\'-\'.$d[0];
';
                            break;
                        case META_ATTRIBUTE_TYPE_BOOL:
                            $classFile .= '                $this->'.$metaAttribute['code'].' = isset($_POST[\''.$metaAttribute['code'].'\']) ? 1 : 0;
';
                            break;
                        case META_ATTRIBUTE_TYPE_FILE:
                            $classFile .= '                if ($this->id)
                {
                    $fileId = $this->sql->getValue("SELECT `'.$metaAttribute['code'].'` FROM `'.$this->metaObjectCode.'` WHERE id=".$this->id);
                }
                else
                {
                    $fileId = 0;
                }
                if (isset($_FILES[\''.$metaAttribute['code'].'\']) && $_FILES[\''.$metaAttribute['code'].'\'][\'name\'] != \'\')
                {
                    $this->'.$metaAttribute['code'].' = $this->uploadFile(\''.$metaAttribute['code'].'\', $fileId);
                }
                elseif ($fileId && isset($_POST[\''.$metaAttribute['code'].'-delete\']))
                {
                    $this->deleteFile($fileId);
                    $this->'.$metaAttribute['code'].' = 0;
                }
                else
                {
                    $this->'.$metaAttribute['code'].' = $fileId;
                }
';
                            break;
                        case META_ATTRIBUTE_TYPE_IMAGE:
                            $classFile .= '                if ($this->id)
                {
                    $imageId = $this->sql->getValue("SELECT `'.$metaAttribute['code'].'` FROM `'.$this->metaObjectCode.'` WHERE id=".$this->id);
                }
                else
                {
                    $imageId = 0;
                }
                if (isset($_FILES[\''.$metaAttribute['code'].'\']) && $_FILES[\''.$metaAttribute['code'].'\'][\'name\'] != \'\')
                {
                    $this->'.$metaAttribute['code'].' = $this->uploadImage(\''.$metaAttribute['code'].'\', $imageId);
                }
                elseif ($imageId && isset($_POST[\''.$metaAttribute['code'].'-delete\']))
                {
                    $this->deleteImage($imageId);
                    $this->'.$metaAttribute['code'].' = 0;
                }
                else
                {
                    $this->'.$metaAttribute['code'].' = $imageId;
                }
';
                            break;
                        case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                            $classFile .= '                if (is_array($_POST[\''.$metaAttribute['code'].'\']))
                {
                    foreach ($_POST[\''.$metaAttribute['code'].'\'] as $linkedObjectId)
                    {
                        if ($linkedObjectId > 0)
                        {
                            $this->'.$metaAttribute['code'].'[] = (int) $linkedObjectId;
                        }
                    }
                }
';
                            break;
                        case META_ATTRIBUTE_TYPE_CUSTOM:
                            //$classFile .= '                $this->'.$metaAttribute['code'].' = Std::cleanString($_POST[\''.$metaAttribute['code'].'\']);
                            $classFile .= '                $this->'.$metaAttribute['code'].' = $_POST[\''.$metaAttribute['code'].'\'];
';
                            break;
                        case META_ATTRIBUTE_TYPE_PASSWORD:
                            $classFile .= '                if($_POST[\''.$metaAttribute['code'].'\'] == \'*****\')
                {
                    $this->'.$metaAttribute['code'].' = $this->sql->getValue("SELECT `'.$metaAttribute['code'].'` FROM `'.$this->metaObjectCode.'` WHERE id=".$this->id);
                }
                else
                {
                    $this->'.$metaAttribute['code'].' = sha1(trim($_POST[\''.$metaAttribute['code'].'\']));
                }
';
                            break;
                    }
                }
                $classFile .= '                break;
';
            }
        }
        $classFile .= '        }';

    $classFile .= '
    }

	/**
	 * Сериализация свойств объекта в ассоциативный массив
	 *
	 * @return array
	 */
    public function toArray()
    {
        $object = array();
';
        foreach ($this->metaAtributes as $metaAttribute)
        {
            if ($metaAttribute['code'] == 'id')
            {
            	$classFile .= '        $object[\'id\'] = $this->id;
';
                continue;
            }
            if ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_LINKTOOBJECT)
			{
				$classFile .= '        if (is_object($this->'.$metaAttribute['code'].'))
        {
            $object[\''.$metaAttribute['code'].'\'] = $this->'.$metaAttribute['code'].'->toArray();
        }
        else
        {
        	$object[\''.$metaAttribute['code'].'\'] = $this->'.$metaAttribute['code'].';
        }
';
			}
			else
			{
				$classFile .= '        $object[\''.$metaAttribute['code'].'\'] = $this->'.$metaAttribute['code'].';
';
			}
        }
        $classFile .= '        return $object;
    }

	/**
	 * Сохранение объекта в базу данных в merge таблицу
	 *
	 * @param int $id
	 */
    public function saveMerge($id=0, $fields=false)
    {
    	$this->save($id, $fields, \'_merge\');
    }

	/**
	 * Сохранение объекта в базу данных
	 *
	 * @param int $id
	 */
    public function save($id=0, $fields=false, $saveMerge=\'\')
    {
';
		foreach ($this->metaAtributes as $metaAttribute)
        {
			if ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_LINKTOOBJECT)
			{
				$classFile .= '        if (is_object($this->'.$metaAttribute['code'].'))
        {
            $this->'.$metaAttribute['code'].'->save();
        }
';
			}
			elseif($metaAttribute['type'] == META_ATTRIBUTE_TYPE_LINKTOOBJECTS)
			{
				$classFile .= '        if (is_array($this->'.$metaAttribute['code'].'))
        {
            for ($i=0, $j=sizeof($this->'.$metaAttribute['code'].'); $i<$j; $i++)
            {
            	if (is_object($this->'.$metaAttribute['code'].'[$i]))
            	{
            		$this->'.$metaAttribute['code'].'[$i]->save();
            		if (!in_array($this->'.$metaAttribute['code'].'[$i]->id, $this->'.$metaAttribute['code'].'))
            		{
            			$this->'.$metaAttribute['code'].'[] = $this->'.$metaAttribute['code'].'[$i]->id;
            		}
            	}
            }
        }
';
			}
        }
        $classFile .= '        if ($id)
        {
            $this->id = $id;
        }
        if ($this->id)
        {
            $object = $this->toArray();
            if ($this->globalExtention->eventsOnBeforeEdit)
            {
                $this->globalExtention->onBeforeEdit($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnBeforeEdit)
            {
                $this->extention->onBeforeEdit($this->id, $this);
            }
            //
            $linkToObjectsMetaAttributes = array();
            //
            if ($fields) {
            	$attributes = array();
            	foreach ($fields as $field) {
            		$field = str_replace(\''.$this->metaObjectCode.'.\', \'\', $field);
            		switch ($this->getType($field)) {
            			case META_ATTRIBUTE_TYPE_INT:
                		case META_ATTRIBUTE_TYPE_BOOL:
		                case META_ATTRIBUTE_TYPE_FILE:
    		            case META_ATTRIBUTE_TYPE_IMAGE:
        		            $attributes[] = "`$field`=".(int)$this->{$field};
            		        break;
                		case META_ATTRIBUTE_TYPE_FLOAT:
	                	case META_ATTRIBUTE_TYPE_DOUBLE:
    	            		$attributes[] = "`$field`=".(double)$this->{$field};
	        	        	break;
    	        	    case META_ATTRIBUTE_TYPE_STRING:
        	        	case META_ATTRIBUTE_TYPE_TEXT:
	        	        case META_ATTRIBUTE_TYPE_BIGTEXT:
    	        	    case META_ATTRIBUTE_TYPE_DATA:
        	        	case META_ATTRIBUTE_TYPE_DATETIME:
	            	    case META_ATTRIBUTE_TYPE_DATE:
    	            	case META_ATTRIBUTE_TYPE_DICTIONARY:
	    	            case META_ATTRIBUTE_TYPE_CUSTOM:
    	    	        case META_ATTRIBUTE_TYPE_PASSWORD:
							$attributes[] = "`$field`=\'".Std::cleanString($this->{$field})."\'";
	                	    break;
		                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
    		            	$attributes[] = "`$field`=".(is_object($this->{$field}) ? $this->{$field}->id : $this->{$field});	
		                	break;	
    		            case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
    		            	$linkToObjectsMetaAttributes[] = array($field);
    		            	break;
        	    	}
            	}
            	$this->sql->query("UPDATE `'.$this->metaObjectCode.'".$saveMerge."` SET " . implode(\', \', $attributes) . " WHERE ".str_replace(\'.\', $saveMerge . \'.\', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {';
        $attributes = array();
        $linkToObjectsMetaAttributes = array();
        foreach ($this->metaAtributes as $metaAttribute)
        {
            if ($metaAttribute['code'] == 'id')
            {
                continue;
            }
            switch ($metaAttribute['type'])
            {
                case META_ATTRIBUTE_TYPE_INT:
                case META_ATTRIBUTE_TYPE_BOOL:
                case META_ATTRIBUTE_TYPE_FILE:
                case META_ATTRIBUTE_TYPE_IMAGE:
                    $attributes[] = "`{$metaAttribute['code']}`=\".(int)\$this->{$metaAttribute['code']}.\"";
                    break;
                case META_ATTRIBUTE_TYPE_FLOAT:
                case META_ATTRIBUTE_TYPE_DOUBLE:
                	$attributes[] = "`{$metaAttribute['code']}`=\".(double)\$this->{$metaAttribute['code']}.\"";
                	break;
                case META_ATTRIBUTE_TYPE_STRING:
                case META_ATTRIBUTE_TYPE_TEXT:
                case META_ATTRIBUTE_TYPE_BIGTEXT:
                case META_ATTRIBUTE_TYPE_DATA:
                case META_ATTRIBUTE_TYPE_DATETIME:
                case META_ATTRIBUTE_TYPE_DATE:
                case META_ATTRIBUTE_TYPE_DICTIONARY:
                case META_ATTRIBUTE_TYPE_CUSTOM:
                case META_ATTRIBUTE_TYPE_PASSWORD:
					$attributes[] = "`{$metaAttribute['code']}`='\".Std::cleanString(\$this->{$metaAttribute['code']}).\"'";
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                	$attributes[] = "`{$metaAttribute['code']}`=\".(is_object(\$this->{$metaAttribute['code']}) ? \$this->{$metaAttribute['code']}->id : \$this->{$metaAttribute['code']}).\"";
                	break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    $linkToObjectsMetaAttributes[] = $metaAttribute['code'];
                    break;
            }
        }
        $classFile .= '
        		$this->sql->query("UPDATE `'.$this->metaObjectCode.'".$saveMerge."` SET ' . implode(', ', $attributes) . ' WHERE ".str_replace(\'.\', $saveMerge . \'.\', self::$ID_METAATTRIBUTE)."=".$this->id);';
        if (sizeof($linkToObjectsMetaAttributes) > 0) {
        	$classFile .= '
                $linkToObjectsMetaAttributes = array('.implode(', ', $linkToObjectsMetaAttributes).');';
        }
        
        $classFile .= '
        	}
         	if (sizeof($linkToObjectsMetaAttributes) > 0) {
        	   	foreach ($linkToObjectsMetaAttributes as $metaAttributeCode) {
        	   		$this->processLinkToObjects($metaAttributeCode);
          		}
        	}
        	//
            if ($this->globalExtention->eventsOnAfterEdit)
            {
                $this->globalExtention->onAfterEdit($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnAfterEdit)
            {
                $this->extention->onAfterEdit($this->id, $this);
            }
        }
        else
        {
            $object = $this->toArray();
            if ($this->globalExtention->eventsOnBeforeCreate)
            {
                $this->globalExtention->onBeforeCreate($this);
            }
            if ($this->extention && $this->extention->eventsOnBeforeCreate)
            {
                $this->extention->onBeforeCreate($this);
            }
            //
            $this->id = $this->sql->insert("INSERT INTO `'.$this->metaObjectCode.'".$saveMerge."` (';
        $attributes = array();
        $values = array();
        foreach ($this->metaAtributes as $metaAttribute)
        {
            if ($metaAttribute['code'] == 'id')
            {
                continue;
            }
            switch ($metaAttribute['type'])
            {
                case META_ATTRIBUTE_TYPE_INT:
                case META_ATTRIBUTE_TYPE_BOOL:
                case META_ATTRIBUTE_TYPE_FILE:
                case META_ATTRIBUTE_TYPE_IMAGE:
                    $attributes[] = "`{$metaAttribute['code']}`";
                    $values[] = "\".(int)\$this->{$metaAttribute['code']}.\"";
                    break;
                case META_ATTRIBUTE_TYPE_FLOAT:
                case META_ATTRIBUTE_TYPE_DOUBLE:
                	$attributes[] = "`{$metaAttribute['code']}`";
                    $values[] = "\".(double)\$this->{$metaAttribute['code']}.\"";
                	break;
                case META_ATTRIBUTE_TYPE_STRING:
                case META_ATTRIBUTE_TYPE_TEXT:
                case META_ATTRIBUTE_TYPE_BIGTEXT:
                case META_ATTRIBUTE_TYPE_DATA:
                case META_ATTRIBUTE_TYPE_DATETIME:
                case META_ATTRIBUTE_TYPE_DATE:
                case META_ATTRIBUTE_TYPE_DICTIONARY:
                case META_ATTRIBUTE_TYPE_CUSTOM:
                case META_ATTRIBUTE_TYPE_PASSWORD:
                    $attributes[] = "`{$metaAttribute['code']}`";
                    //$values[] = "'{\$this->{$metaAttribute['code']}}'";
					$values[] = "'\".Std::cleanString(\$this->{$metaAttribute['code']}).\"'";
                    break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                	$attributes[] = "`{$metaAttribute['code']}`";
                	$values[] = "\".(is_object(\$this->{$metaAttribute['code']}) ? \$this->{$metaAttribute['code']}->id : \$this->{$metaAttribute['code']}).\"";
                	break;
                case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                    $linkToObjectsSql = '
            if(sizeof($this->'.$metaAttribute['code'].') > 0)
            {
                foreach ($this->'.$metaAttribute['code'].' as $linkedObjectId)
                {
                    $this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES ('.$metaAttribute['id'].', {$this->id}, $linkedObjectId)");
                }
            }';
                    break;
            }
        }
        $classFile .= implode(', ', $attributes).') VALUES ('.implode(', ', $values).')");'.$linkToObjectsSql.'
        	//
            if ($this->globalExtention->eventsOnAfterCreate)
            {
                $this->globalExtention->onAfterCreate($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnAfterCreate)
            {
                $this->extention->onAfterCreate($this->id, $this);
            }
        }
    }
    
    private function processLinkToObjects($metaAttributeCode)
    {
    	if (is_array($metaAttributeCode)) {
            $metaAttributeCode = $metaAttributeCode[0];
        }
        $metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE metaobject_id=(SELECT id FROM metaobject WHERE code=\'{$this->metaObjectCode}\') AND code=\'$metaAttributeCode\'");
    	$this->sql->query("DELETE FROM metalink WHERE metaattribute_id=$metaAttributeId AND object_id={$this->id}");
	    if (sizeof($this->{$metaAttributeCode}) > 0) {
			foreach ($this->{$metaAttributeCode} as $linkedObjectId) {
            	$this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES ($metaAttributeId, {$this->id}, $linkedObjectId)");
	        }
		}
    }
    
    private function getType($fieldCode)
    {
    	switch ($fieldCode) {';
		foreach ($this->metaAtributes as $metaAttribute)
        {
            $classFile .= '
			case \''.$metaAttribute['code'].'\': return '.$metaAttribute['type'].'; break;';
        }
		$classFile .= '
    	}
    }
}
?>';
        file_put_contents('@obj/'.strtolower($this->metaObjectCode).'.base.php', $classFile);
        //
		if (!file_exists('@obj/'.strtolower($this->metaObjectCode).'.php'))
		{
			$classFile = '<?php
class '.$this->metaObjectCode.'Object extends '.$this->metaObjectCode.'BaseObject
{
	public function __construct()
	{
		parent::__construct();
	}
}
?>';
			file_put_contents('@obj/'.strtolower($this->metaObjectCode).'.php', $classFile);
		}
    }

    public function generateExtention()
    {
        if (!file_exists('@obj/'.strtolower($this->metaObjectCode).'.ext.php'))
        {
            $extentionFile = '<?php
class '.$this->metaObjectCode.'Extention
{
    private $sql;
    
    public $extendsList = false;
    public $extendsWidget = false;
    public $extendsCard = false;
    public $extendsForm = false;
    public $extendsActions = false;
    public $eventsOnBeforeCreate = false;
    public $eventsOnAfterCreate = false;
    public $eventsOnBeforeEdit = false;
    public $eventsOnAfterEdit = false;
    public $eventsOnBeforeDelete = false;
    public $eventsOnAfterDelete = false;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function extendList(&$list, $step)
    {
        if ($step == 1) // после PreGenerate
        {
            // ...
        }
        else // после Generate
        {
            // ...
        }
    }

    public function extendCard(&$card)
    {
        // ...
    }

    public function extendForm(&$form)
    {
        // ...
    }

    public function extendWidget(&$widget, $step)
    {
        if ($step == 1) // после preGenerate
        {
            // ...
        }
        else // после Generate
        {
             // ...
        }
    }

    public function processAction(&$module)
    {
        // ...
    }

    public function extendActions(&$actions)
    {
        // ...
    }

    public function onBeforeCreate(&$object)
    {
        // ...
    }

    public function onAfterCreate($id, $object)
    {
        // ...
    }

    public function onBeforeEdit($id, &$object)
    {
        // ...
    }

    public function onAfterEdit($id, $object)
    {
        // ...
    }

    public function onBeforeDelete($id)
    {
        // ...
    }

    public function onAfterDelete($id, $deletedObject=false)
    {
        // ...
    }
}
?>';
            file_put_contents('@obj/'.strtolower($this->metaObjectCode).'.ext.php', $extentionFile);
        }
    }
}
?>