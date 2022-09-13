<?php
class player_questBaseObject extends Object
{
	public static $METAOBJECT = 'player_quest';
    public static $ID_METAATTRIBUTE = 'player_quest.id';
 	public static $ID = 'player_quest.id';
    public $player = 0;
    public static $PLAYER = 'player_quest.player';
    public $quest = 0;
    public static $QUEST = 'player_quest.quest';
    public $codename = '';
    public static $CODENAME = 'player_quest.codename';
    public $title = '';
    public static $TITLE = 'player_quest.title';
    public $info = '';
    public static $INFO = 'player_quest.info';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident','both');
    public static $FRACTION = 'player_quest.fraction';
    public $level = 0;
    public static $LEVEL = 'player_quest.level';
    public $location = '';
    public static $LOCATION = 'player_quest.location';
    public $condition = '';
    public static $CONDITION = 'player_quest.condition';
    public $autostart = 0;
    public static $AUTOSTART = 'player_quest.autostart';
    public $force = 0;
    public static $FORCE = 'player_quest.force';
    public $state = '';
    public static $STATE = 'player_quest.state';
    public $step = 0;
    public static $STEP = 'player_quest.step';
    public $priority = 0;
    public static $PRIORITY = 'player_quest.priority';
    public $data = '';
    public static $DATA = 'player_quest.data';
    public $item = '';
    public static $ITEM = 'player_quest.item';

    public function __construct()
    {
        parent::__construct('player_quest');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->quest = 0;
        $this->codename = '';
        $this->title = '';
        $this->info = '';
        $this->fraction = '';
        $this->level = 0;
        $this->location = '';
        $this->condition = '';
        $this->autostart = 0;
        $this->force = 0;
        $this->state = '';
        $this->step = 0;
        $this->priority = 0;
        $this->data = '';
        $this->item = '';
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
        $this->player = $object['player'];
        $this->quest = $object['quest'];
        $this->codename = $object['codename'];
        $this->title = $object['title'];
        $this->info = $object['info'];
        $this->fraction = $object['fraction'];
        $this->level = $object['level'];
        $this->location = $object['location'];
        $this->condition = $object['condition'];
        $this->autostart = $object['autostart'];
        $this->force = $object['force'];
        $this->state = $object['state'];
        $this->step = $object['step'];
        $this->priority = $object['priority'];
        $this->data = $object['data'];
        $this->item = $object['item'];
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
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        if (is_object($this->quest))
        {
            $object['quest'] = $this->quest->toArray();
        }
        else
        {
        	$object['quest'] = $this->quest;
        }
        $object['codename'] = $this->codename;
        $object['title'] = $this->title;
        $object['info'] = $this->info;
        $object['fraction'] = $this->fraction;
        $object['level'] = $this->level;
        $object['location'] = $this->location;
        $object['condition'] = $this->condition;
        $object['autostart'] = $this->autostart;
        $object['force'] = $this->force;
        $object['state'] = $this->state;
        $object['step'] = $this->step;
        $object['priority'] = $this->priority;
        $object['data'] = $this->data;
        $object['item'] = $this->item;
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
        if (is_object($this->player))
        {
            $this->player->save();
        }
        if (is_object($this->quest))
        {
            $this->quest->save();
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
            		$field = str_replace('player_quest.', '', $field);
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
            	$this->sql->query("UPDATE `player_quest".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `player_quest".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `quest`=".(is_object($this->quest) ? $this->quest->id : $this->quest).", `codename`='".Std::cleanString($this->codename)."', `title`='".Std::cleanString($this->title)."', `info`='".Std::cleanString($this->info)."', `fraction`='".Std::cleanString($this->fraction)."', `level`=".(int)$this->level.", `location`='".Std::cleanString($this->location)."', `condition`='".Std::cleanString($this->condition)."', `autostart`=".(int)$this->autostart.", `force`=".(int)$this->force.", `state`='".Std::cleanString($this->state)."', `step`=".(int)$this->step.", `priority`=".(int)$this->priority.", `data`='".Std::cleanString($this->data)."', `item`='".Std::cleanString($this->item)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `player_quest".$saveMerge."` (`player`, `quest`, `codename`, `title`, `info`, `fraction`, `level`, `location`, `condition`, `autostart`, `force`, `state`, `step`, `priority`, `data`, `item`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", ".(is_object($this->quest) ? $this->quest->id : $this->quest).", '".Std::cleanString($this->codename)."', '".Std::cleanString($this->title)."', '".Std::cleanString($this->info)."', '".Std::cleanString($this->fraction)."', ".(int)$this->level.", '".Std::cleanString($this->location)."', '".Std::cleanString($this->condition)."', ".(int)$this->autostart.", ".(int)$this->force.", '".Std::cleanString($this->state)."', ".(int)$this->step.", ".(int)$this->priority.", '".Std::cleanString($this->data)."', '".Std::cleanString($this->item)."')");
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
			case 'player': return 13; break;
			case 'quest': return 13; break;
			case 'codename': return 4; break;
			case 'title': return 4; break;
			case 'info': return 5; break;
			case 'fraction': return 15; break;
			case 'level': return 2; break;
			case 'location': return 4; break;
			case 'condition': return 4; break;
			case 'autostart': return 10; break;
			case 'force': return 10; break;
			case 'state': return 4; break;
			case 'step': return 2; break;
			case 'priority': return 2; break;
			case 'data': return 5; break;
			case 'item': return 4; break;
    	}
    }
}
?>