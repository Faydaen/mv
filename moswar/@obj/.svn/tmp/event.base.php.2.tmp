<?php
class eventBaseObject extends Object
{
	public static $METAOBJECT = 'event';
    public static $ID_METAATTRIBUTE = 'event.id';
 	public static $ID = 'event.id';
    public $name = '';
    public static $NAME = 'event.name';
    public $code = '';
    public static $CODE = 'event.code';
    public $info = '';
    public static $INFO = 'event.info';
    public $pos = 0;
    public static $POS = 'event.pos';
    public $trigger = '';
    public $trigger_Dictionary = array('item_used','macdonalds_finished','patrol_finished','jail','metro_finished','rat_attacked','rat_won','mf_finished','viptrainer_finished','petriks_finished','photo_added','fight_bank','fight_level','fight_flag','viptrainer_buy','huntclub_buy','major_buy','bankcell_buy','relations_buy','student_levelup','huntclub_order','pvp_win_over_1','pvp_win_over_2','pvp_win_over_3','pvp_win_over_4','pvp_win_over_5','pvp_win_over_6','pvp_win_over_7','pvp_win_over_8','pvp_win_over_9','pvp_win_over_10','pvp_win_over_11','pvp_win_over_12','pvp_win_over_13','pvp_win_over_14','pvp_win_over_15','pvp_win_over_16','pvp_win_over_17','pvp_win_over_18','pvp_win_over_19','pvp_win_over_20','automobile_ride','automobile_bring_up');
    public static $TRIGGER = 'event.trigger';
    public $probability = '';
    public static $PROBABILITY = 'event.probability';
    public $items = array();
    public static $ITEMS = 'event.items';
    public $conditions = '';
    public static $CONDITIONS = 'event.conditions';
    public $actions = '';
    public static $ACTIONS = 'event.actions';
    public $collections = array();
    public static $COLLECTIONS = 'event.collections';
    public $action_type = '';
    public static $ACTION_TYPE = 'event.action_type';
    public $date_begin = '0000-00-00';
    public static $DATE_BEGIN = 'event.date_begin';
    public $date_finish = '0000-00-00';
    public static $DATE_FINISH = 'event.date_finish';

    public function __construct()
    {
        parent::__construct('event');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->code = '';
        $this->info = '';
        $this->pos = 0;
        $this->trigger = '';
        $this->probability = '';
        $this->items = array();
        $this->conditions = '';
        $this->actions = '';
        $this->collections = array();
        $this->action_type = '';
        $this->date_begin = '0000-00-00';
        $this->date_finish = '0000-00-00';
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
        $this->code = $object['code'];
        $this->info = $object['info'];
        $this->pos = $object['pos'];
        $this->trigger = $object['trigger'];
        $this->probability = $object['probability'];
        $this->items = $object['items'];
        $this->conditions = $object['conditions'];
        $this->actions = $object['actions'];
        $this->collections = $object['collections'];
        $this->action_type = $object['action_type'];
        $this->date_begin = $object['date_begin'];
        $this->date_finish = $object['date_finish'];
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
            case 147:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->code = str_replace('"', '&quot;', $_POST['code']);
                $this->info = $_POST['info'];
                $this->pos = (int) $_POST['pos'];
                $this->trigger = $_POST['trigger'];
                $this->probability = str_replace('"', '&quot;', $_POST['probability']);
                if (is_array($_POST['items']))
                {
                    foreach ($_POST['items'] as $linkedObjectId)
                    {
                        if ($linkedObjectId > 0)
                        {
                            $this->items[] = (int) $linkedObjectId;
                        }
                    }
                }
                $this->conditions = $_POST['conditions'];
                $this->actions = $_POST['actions'];
                if (is_array($_POST['collections']))
                {
                    foreach ($_POST['collections'] as $linkedObjectId)
                    {
                        if ($linkedObjectId > 0)
                        {
                            $this->collections[] = (int) $linkedObjectId;
                        }
                    }
                }
                $this->action_type = str_replace('"', '&quot;', $_POST['action_type']);
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['date_begin']));
                if ($dt == '')
                {
                    $dt = '00.00.0000';
                }
                $d = explode('.', $dt);
                $this->date_begin = $d[2].'-'.$d[1].'-'.$d[0];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['date_finish']));
                if ($dt == '')
                {
                    $dt = '00.00.0000';
                }
                $d = explode('.', $dt);
                $this->date_finish = $d[2].'-'.$d[1].'-'.$d[0];
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
        $object['code'] = $this->code;
        $object['info'] = $this->info;
        $object['pos'] = $this->pos;
        $object['trigger'] = $this->trigger;
        $object['probability'] = $this->probability;
        $object['items'] = $this->items;
        $object['conditions'] = $this->conditions;
        $object['actions'] = $this->actions;
        $object['collections'] = $this->collections;
        $object['action_type'] = $this->action_type;
        $object['date_begin'] = $this->date_begin;
        $object['date_finish'] = $this->date_finish;
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
        if (is_array($this->items))
        {
            for ($i=0, $j=sizeof($this->items); $i<$j; $i++)
            {
            	if (is_object($this->items[$i]))
            	{
            		$this->items[$i]->save();
            		if (!in_array($this->items[$i]->id, $this->items))
            		{
            			$this->items[] = $this->items[$i]->id;
            		}
            	}
            }
        }
        if (is_array($this->collections))
        {
            for ($i=0, $j=sizeof($this->collections); $i<$j; $i++)
            {
            	if (is_object($this->collections[$i]))
            	{
            		$this->collections[$i]->save();
            		if (!in_array($this->collections[$i]->id, $this->collections))
            		{
            			$this->collections[] = $this->collections[$i]->id;
            		}
            	}
            }
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
            		$field = str_replace('event.', '', $field);
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
            	$this->sql->query("UPDATE `event".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `event".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `code`='".Std::cleanString($this->code)."', `info`='".Std::cleanString($this->info)."', `pos`=".(int)$this->pos.", `trigger`='".Std::cleanString($this->trigger)."', `probability`='".Std::cleanString($this->probability)."', `conditions`='".Std::cleanString($this->conditions)."', `actions`='".Std::cleanString($this->actions)."', `action_type`='".Std::cleanString($this->action_type)."', `date_begin`='".Std::cleanString($this->date_begin)."', `date_finish`='".Std::cleanString($this->date_finish)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
                $linkToObjectsMetaAttributes = array(items, collections);
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
            $this->id = $this->sql->insert("INSERT INTO `event".$saveMerge."` (`name`, `code`, `info`, `pos`, `trigger`, `probability`, `conditions`, `actions`, `action_type`, `date_begin`, `date_finish`) VALUES ('".Std::cleanString($this->name)."', '".Std::cleanString($this->code)."', '".Std::cleanString($this->info)."', ".(int)$this->pos.", '".Std::cleanString($this->trigger)."', '".Std::cleanString($this->probability)."', '".Std::cleanString($this->conditions)."', '".Std::cleanString($this->actions)."', '".Std::cleanString($this->action_type)."', '".Std::cleanString($this->date_begin)."', '".Std::cleanString($this->date_finish)."')");
            if(sizeof($this->collections) > 0)
            {
                foreach ($this->collections as $linkedObjectId)
                {
                    $this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES (1126, {$this->id}, $linkedObjectId)");
                }
            }
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
			case 'code': return 4; break;
			case 'info': return 5; break;
			case 'pos': return 2; break;
			case 'trigger': return 15; break;
			case 'probability': return 4; break;
			case 'items': return 14; break;
			case 'conditions': return 5; break;
			case 'actions': return 5; break;
			case 'collections': return 14; break;
			case 'action_type': return 4; break;
			case 'date_begin': return 9; break;
			case 'date_finish': return 9; break;
    	}
    }
}
?>