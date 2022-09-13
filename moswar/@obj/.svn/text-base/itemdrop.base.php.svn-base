<?php
class itemdropBaseObject extends Object
{
	public static $METAOBJECT = 'itemdrop';
    public static $ID_METAATTRIBUTE = 'itemdrop.id';
 	public static $ID = 'itemdrop.id';
    public $name = '';
    public static $NAME = 'itemdrop.name';
    public $item = 0;
    public static $ITEM = 'itemdrop.item';
    public $amount = 0;
    public static $AMOUNT = 'itemdrop.amount';
    public $probability = 0;
    public static $PROBABILITY = 'itemdrop.probability';
    public $event_type = '';
    public $event_type_Dictionary = array('macdonalds','patrol','metro','fight');
    public static $EVENT_TYPE = 'itemdrop.event_type';
    public $event_enemy = '';
    public static $EVENT_ENEMY = 'itemdrop.event_enemy';
    public $event_time_min = 0;
    public static $EVENT_TIME_MIN = 'itemdrop.event_time_min';
    public $event_time_max = 0;
    public static $EVENT_TIME_MAX = 'itemdrop.event_time_max';
    public $condition_level_min = 0;
    public static $CONDITION_LEVEL_MIN = 'itemdrop.condition_level_min';
    public $condition_level_max = 0;
    public static $CONDITION_LEVEL_MAX = 'itemdrop.condition_level_max';
    public $condition_time_min = '';
    public static $CONDITION_TIME_MIN = 'itemdrop.condition_time_min';
    public $condition_time_max = '';
    public static $CONDITION_TIME_MAX = 'itemdrop.condition_time_max';
    public $condition_quest = 0;
    public static $CONDITION_QUEST = 'itemdrop.condition_quest';
    public $condition_quest_step = 0;
    public static $CONDITION_QUEST_STEP = 'itemdrop.condition_quest_step';

    public function __construct()
    {
        parent::__construct('itemdrop');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->item = 0;
        $this->amount = 0;
        $this->probability = 0;
        $this->event_type = '';
        $this->event_enemy = '';
        $this->event_time_min = 0;
        $this->event_time_max = 0;
        $this->condition_level_min = 0;
        $this->condition_level_max = 0;
        $this->condition_time_min = '';
        $this->condition_time_max = '';
        $this->condition_quest = 0;
        $this->condition_quest_step = 0;
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
        $this->item = $object['item'];
        $this->amount = $object['amount'];
        $this->probability = $object['probability'];
        $this->event_type = $object['event_type'];
        $this->event_enemy = $object['event_enemy'];
        $this->event_time_min = $object['event_time_min'];
        $this->event_time_max = $object['event_time_max'];
        $this->condition_level_min = $object['condition_level_min'];
        $this->condition_level_max = $object['condition_level_max'];
        $this->condition_time_min = $object['condition_time_min'];
        $this->condition_time_max = $object['condition_time_max'];
        $this->condition_quest = $object['condition_quest'];
        $this->condition_quest_step = $object['condition_quest_step'];
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
            case 44:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->item = (int) $_POST['item'];
                $this->amount = (int) $_POST['amount'];
                $this->probability = (double) str_replace(',', '.', $_POST['probability']);
                $this->event_type = $_POST['event_type'];
                $this->event_enemy = str_replace('"', '&quot;', $_POST['event_enemy']);
                $this->event_time_min = (int) $_POST['event_time_min'];
                $this->event_time_max = (int) $_POST['event_time_max'];
                $this->condition_level_min = (int) $_POST['condition_level_min'];
                $this->condition_level_max = (int) $_POST['condition_level_max'];
                $this->condition_time_min = str_replace('"', '&quot;', $_POST['condition_time_min']);
                $this->condition_time_max = str_replace('"', '&quot;', $_POST['condition_time_max']);
                $this->condition_quest = (int) $_POST['condition_quest'];
                $this->condition_quest_step = (int) $_POST['condition_quest_step'];
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
        if (is_object($this->item))
        {
            $object['item'] = $this->item->toArray();
        }
        else
        {
        	$object['item'] = $this->item;
        }
        $object['amount'] = $this->amount;
        $object['probability'] = $this->probability;
        $object['event_type'] = $this->event_type;
        $object['event_enemy'] = $this->event_enemy;
        $object['event_time_min'] = $this->event_time_min;
        $object['event_time_max'] = $this->event_time_max;
        $object['condition_level_min'] = $this->condition_level_min;
        $object['condition_level_max'] = $this->condition_level_max;
        $object['condition_time_min'] = $this->condition_time_min;
        $object['condition_time_max'] = $this->condition_time_max;
        if (is_object($this->condition_quest))
        {
            $object['condition_quest'] = $this->condition_quest->toArray();
        }
        else
        {
        	$object['condition_quest'] = $this->condition_quest;
        }
        $object['condition_quest_step'] = $this->condition_quest_step;
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
        if (is_object($this->item))
        {
            $this->item->save();
        }
        if (is_object($this->condition_quest))
        {
            $this->condition_quest->save();
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
            		$field = str_replace('itemdrop.', '', $field);
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
            	$this->sql->query("UPDATE `itemdrop".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `itemdrop".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `item`=".(is_object($this->item) ? $this->item->id : $this->item).", `amount`=".(int)$this->amount.", `probability`=".(double)$this->probability.", `event_type`='".Std::cleanString($this->event_type)."', `event_enemy`='".Std::cleanString($this->event_enemy)."', `event_time_min`=".(int)$this->event_time_min.", `event_time_max`=".(int)$this->event_time_max.", `condition_level_min`=".(int)$this->condition_level_min.", `condition_level_max`=".(int)$this->condition_level_max.", `condition_time_min`='".Std::cleanString($this->condition_time_min)."', `condition_time_max`='".Std::cleanString($this->condition_time_max)."', `condition_quest`=".(is_object($this->condition_quest) ? $this->condition_quest->id : $this->condition_quest).", `condition_quest_step`=".(int)$this->condition_quest_step." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `itemdrop".$saveMerge."` (`name`, `item`, `amount`, `probability`, `event_type`, `event_enemy`, `event_time_min`, `event_time_max`, `condition_level_min`, `condition_level_max`, `condition_time_min`, `condition_time_max`, `condition_quest`, `condition_quest_step`) VALUES ('".Std::cleanString($this->name)."', ".(is_object($this->item) ? $this->item->id : $this->item).", ".(int)$this->amount.", ".(double)$this->probability.", '".Std::cleanString($this->event_type)."', '".Std::cleanString($this->event_enemy)."', ".(int)$this->event_time_min.", ".(int)$this->event_time_max.", ".(int)$this->condition_level_min.", ".(int)$this->condition_level_max.", '".Std::cleanString($this->condition_time_min)."', '".Std::cleanString($this->condition_time_max)."', ".(is_object($this->condition_quest) ? $this->condition_quest->id : $this->condition_quest).", ".(int)$this->condition_quest_step.")");
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
			case 'item': return 13; break;
			case 'amount': return 2; break;
			case 'probability': return 3; break;
			case 'event_type': return 15; break;
			case 'event_enemy': return 4; break;
			case 'event_time_min': return 2; break;
			case 'event_time_max': return 2; break;
			case 'condition_level_min': return 2; break;
			case 'condition_level_max': return 2; break;
			case 'condition_time_min': return 4; break;
			case 'condition_time_max': return 4; break;
			case 'condition_quest': return 13; break;
			case 'condition_quest_step': return 2; break;
    	}
    }
}
?>