<?php
class levelstatBaseObject extends Object
{
	public static $METAOBJECT = 'levelstat';
    public static $ID_METAATTRIBUTE = 'levelstat.id';
 	public static $ID = 'levelstat.id';
    public $level = 0;
    public static $LEVEL = 'levelstat.level';
    public $health = 0;
    public static $HEALTH = 'levelstat.health';
    public $strength = 0;
    public static $STRENGTH = 'levelstat.strength';
    public $dexterity = 0;
    public static $DEXTERITY = 'levelstat.dexterity';
    public $intuition = 0;
    public static $INTUITION = 'levelstat.intuition';
    public $resistance = 0;
    public static $RESISTANCE = 'levelstat.resistance';
    public $attention = 0;
    public static $ATTENTION = 'levelstat.attention';
    public $charism = 0;
    public static $CHARISM = 'levelstat.charism';
    public $dt = '0000-00-00';
    public static $DT = 'levelstat.dt';
    public $type = 0;
    public static $TYPE = 'levelstat.type';

    public function __construct()
    {
        parent::__construct('levelstat');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->level = 0;
        $this->health = 0;
        $this->strength = 0;
        $this->dexterity = 0;
        $this->intuition = 0;
        $this->resistance = 0;
        $this->attention = 0;
        $this->charism = 0;
        $this->dt = '0000-00-00';
        $this->type = 0;
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
        $this->level = $object['level'];
        $this->health = $object['health'];
        $this->strength = $object['strength'];
        $this->dexterity = $object['dexterity'];
        $this->intuition = $object['intuition'];
        $this->resistance = $object['resistance'];
        $this->attention = $object['attention'];
        $this->charism = $object['charism'];
        $this->dt = $object['dt'];
        $this->type = $object['type'];
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
        $object['level'] = $this->level;
        $object['health'] = $this->health;
        $object['strength'] = $this->strength;
        $object['dexterity'] = $this->dexterity;
        $object['intuition'] = $this->intuition;
        $object['resistance'] = $this->resistance;
        $object['attention'] = $this->attention;
        $object['charism'] = $this->charism;
        $object['dt'] = $this->dt;
        $object['type'] = $this->type;
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
            		$field = str_replace('levelstat.', '', $field);
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
            	$this->sql->query("UPDATE `levelstat".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `levelstat".$saveMerge."` SET `level`=".(int)$this->level.", `health`=".(int)$this->health.", `strength`=".(int)$this->strength.", `dexterity`=".(int)$this->dexterity.", `intuition`=".(int)$this->intuition.", `resistance`=".(int)$this->resistance.", `attention`=".(int)$this->attention.", `charism`=".(int)$this->charism.", `dt`='".Std::cleanString($this->dt)."', `type`=".(int)$this->type." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `levelstat".$saveMerge."` (`level`, `health`, `strength`, `dexterity`, `intuition`, `resistance`, `attention`, `charism`, `dt`, `type`) VALUES (".(int)$this->level.", ".(int)$this->health.", ".(int)$this->strength.", ".(int)$this->dexterity.", ".(int)$this->intuition.", ".(int)$this->resistance.", ".(int)$this->attention.", ".(int)$this->charism.", '".Std::cleanString($this->dt)."', ".(int)$this->type.")");
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
			case 'level': return 2; break;
			case 'health': return 2; break;
			case 'strength': return 2; break;
			case 'dexterity': return 2; break;
			case 'intuition': return 2; break;
			case 'resistance': return 2; break;
			case 'attention': return 2; break;
			case 'charism': return 2; break;
			case 'dt': return 9; break;
			case 'type': return 2; break;
    	}
    }
}
?>