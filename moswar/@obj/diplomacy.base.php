<?php
class diplomacyBaseObject extends Object
{
	public static $METAOBJECT = 'diplomacy';
    public static $ID_METAATTRIBUTE = 'diplomacy.id';
 	public static $ID = 'diplomacy.id';
    public $name = '';
    public static $NAME = 'diplomacy.name';
    public $type = '';
    public $type_Dictionary = array('war','union','control');
    public static $TYPE = 'diplomacy.type';
    public $state = '';
    public $state_Dictionary = array('proposal','accepted','finished','canceled','paused','step1','step2');
    public static $STATE = 'diplomacy.state';
    public $clan1 = 0;
    public static $CLAN1 = 'diplomacy.clan1';
    public $clan2 = 0;
    public static $CLAN2 = 'diplomacy.clan2';
    public $map = 0;
    public static $MAP = 'diplomacy.map';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'diplomacy.dt';
    public $dt2 = '0000-00-00 00:00:00';
    public static $DT2 = 'diplomacy.dt2';
    public $parent_diplomacy = 0;
    public static $PARENT_DIPLOMACY = 'diplomacy.parent_diplomacy';
    public $data = '';
    public static $DATA = 'diplomacy.data';

    public function __construct()
    {
        parent::__construct('diplomacy');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->type = '';
        $this->state = '';
        $this->clan1 = 0;
        $this->clan2 = 0;
        $this->map = 0;
        $this->dt = '0000-00-00 00:00:00';
        $this->dt2 = '0000-00-00 00:00:00';
        $this->parent_diplomacy = 0;
        $this->data = '';
    }

	/**
	 * Инициализация свойств объекта из ассоциативного массива
	 *
	 * @param array
	 */
    public function init($object)
    {
        if (isset($object['id']))
        {
            $this->id = $object['id'];
        }
        $this->name = $object['name'];
        $this->type = $object['type'];
        $this->state = $object['state'];
        $this->clan1 = $object['clan1'];
        $this->clan2 = $object['clan2'];
        $this->map = $object['map'];
        $this->dt = $object['dt'];
        $this->dt2 = $object['dt2'];
        $this->parent_diplomacy = $object['parent_diplomacy'];
        $this->data = $object['data'];
    }

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
            if (isset($_POST['id']))
            {
                $this->id = (int) $_POST['id'];
            }
            if (isset($_GET['id']))
            {
                $this->id = (int) $_GET['id'];
            }
        }
        if (!$this->metaViewId)
        {
            $metaView = isset($_GET['metaview']) ? $_GET['metaview'] : (isset($_POST['metaview']) ? $_POST['metaview'] : 0);
            if ($metaView)
            {
                if (is_numeric((int) $metaView))
                {
                    $this->metaViewId = (int) $metaView;
                }
                else
                {
                    $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code=''");
                }
            }
        }
        if ($this->id)
        {
            $this->load($this->id);
        }
        switch ($this->metaViewId)
        {
            case 82:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->type = $_POST['type'];
                $this->state = $_POST['state'];
                $this->clan1 = (int) $_POST['clan1'];
                $this->clan2 = (int) $_POST['clan2'];
                $this->map = (int) $_POST['map'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt2']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt2 = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->parent_diplomacy = (int) $_POST['parent_diplomacy'];
                break;
        }
    }

	/**
	 * Сериализация свойств объекта в ассоциативный массив
	 *
	 * @return array
	 */
    public function toArray()
    {
        $object = array();
        $object['id'] = $this->id;
        $object['name'] = $this->name;
        $object['type'] = $this->type;
        $object['state'] = $this->state;
        if (is_object($this->clan1))
        {
            $object['clan1'] = $this->clan1->toArray();
        }
        else
        {
        	$object['clan1'] = $this->clan1;
        }
        if (is_object($this->clan2))
        {
            $object['clan2'] = $this->clan2->toArray();
        }
        else
        {
        	$object['clan2'] = $this->clan2;
        }
        if (is_object($this->map))
        {
            $object['map'] = $this->map->toArray();
        }
        else
        {
        	$object['map'] = $this->map;
        }
        $object['dt'] = $this->dt;
        $object['dt2'] = $this->dt2;
        if (is_object($this->parent_diplomacy))
        {
            $object['parent_diplomacy'] = $this->parent_diplomacy->toArray();
        }
        else
        {
        	$object['parent_diplomacy'] = $this->parent_diplomacy;
        }
        $object['data'] = $this->data;
        return $object;
    }

	/**
	 * Сохранение объекта в базу данных в merge таблицу
	 *
	 * @param int $id
	 */
    public function saveMerge($id=0, $fields=false)
    {
    	$this->save($id, $fields, '_merge');
    }

	/**
	 * Сохранение объекта в базу данных
	 *
	 * @param int $id
	 */
    public function save($id=0, $fields=false, $saveMerge='')
    {
        if (is_object($this->clan1))
        {
            $this->clan1->save();
        }
        if (is_object($this->clan2))
        {
            $this->clan2->save();
        }
        if (is_object($this->map))
        {
            $this->map->save();
        }
        if (is_object($this->parent_diplomacy))
        {
            $this->parent_diplomacy->save();
        }
        if ($id)
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
            		$field = str_replace('diplomacy.', '', $field);
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
							$attributes[] = "`$field`='".Std::cleanString($this->{$field})."'";
	                	    break;
		                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
    		            	$attributes[] = "`$field`=".(is_object($this->{$field}) ? $this->{$field}->id : $this->{$field});	
		                	break;	
    		            case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
    		            	$linkToObjectsMetaAttributes[] = array($field);
    		            	break;
        	    	}
            	}
            	$this->sql->query("UPDATE `diplomacy".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `diplomacy".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `type`='".Std::cleanString($this->type)."', `state`='".Std::cleanString($this->state)."', `clan1`=".(is_object($this->clan1) ? $this->clan1->id : $this->clan1).", `clan2`=".(is_object($this->clan2) ? $this->clan2->id : $this->clan2).", `map`=".(is_object($this->map) ? $this->map->id : $this->map).", `dt`='".Std::cleanString($this->dt)."', `dt2`='".Std::cleanString($this->dt2)."', `parent_diplomacy`=".(is_object($this->parent_diplomacy) ? $this->parent_diplomacy->id : $this->parent_diplomacy).", `data`='".Std::cleanString($this->data)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `diplomacy".$saveMerge."` (`name`, `type`, `state`, `clan1`, `clan2`, `map`, `dt`, `dt2`, `parent_diplomacy`, `data`) VALUES ('".Std::cleanString($this->name)."', '".Std::cleanString($this->type)."', '".Std::cleanString($this->state)."', ".(is_object($this->clan1) ? $this->clan1->id : $this->clan1).", ".(is_object($this->clan2) ? $this->clan2->id : $this->clan2).", ".(is_object($this->map) ? $this->map->id : $this->map).", '".Std::cleanString($this->dt)."', '".Std::cleanString($this->dt2)."', ".(is_object($this->parent_diplomacy) ? $this->parent_diplomacy->id : $this->parent_diplomacy).", '".Std::cleanString($this->data)."')");
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
        $metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE metaobject_id=(SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}') AND code='$metaAttributeCode'");
    	$this->sql->query("DELETE FROM metalink WHERE metaattribute_id=$metaAttributeId AND object_id={$this->id}");
	    if (sizeof($this->{$metaAttributeCode}) > 0) {
			foreach ($this->{$metaAttributeCode} as $linkedObjectId) {
            	$this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES ($metaAttributeId, {$this->id}, $linkedObjectId)");
	        }
		}
    }
    
    private function getType($fieldCode)
    {
    	switch ($fieldCode) {
			case 'id': return 1; break;
			case 'name': return 4; break;
			case 'type': return 15; break;
			case 'state': return 15; break;
			case 'clan1': return 13; break;
			case 'clan2': return 13; break;
			case 'map': return 13; break;
			case 'dt': return 8; break;
			case 'dt2': return 8; break;
			case 'parent_diplomacy': return 13; break;
			case 'data': return 5; break;
    	}
    }
}
?>