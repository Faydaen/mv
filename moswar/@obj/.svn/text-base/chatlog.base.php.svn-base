<?php
class chatlogBaseObject extends Object
{
	public static $METAOBJECT = 'chatlog';
    public static $ID_METAATTRIBUTE = 'chatlog.id';
 	public static $ID = 'chatlog.id';
    public $player_from = 0;
    public static $PLAYER_FROM = 'chatlog.player_from';
    public $player_to = 0;
    public static $PLAYER_TO = 'chatlog.player_to';
    public $clan_to = 0;
    public static $CLAN_TO = 'chatlog.clan_to';
    public $text = '';
    public static $TEXT = 'chatlog.text';
    public $time = 0;
    public static $TIME = 'chatlog.time';
    public $player_from_nickname = '';
    public static $PLAYER_FROM_NICKNAME = 'chatlog.player_from_nickname';
    public $player_to_nickname = '';
    public static $PLAYER_TO_NICKNAME = 'chatlog.player_to_nickname';
    public $type = '';
    public $type_Dictionary = array('general','arrived','resident','clan','private','system','battle_resident','battle_arrived','quiz','general_noobs');
    public static $TYPE = 'chatlog.type';
    public $battle_to = 0;
    public static $BATTLE_TO = 'chatlog.battle_to';

    public function __construct()
    {
        parent::__construct('chatlog');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player_from = 0;
        $this->player_to = 0;
        $this->clan_to = 0;
        $this->text = '';
        $this->time = 0;
        $this->player_from_nickname = '';
        $this->player_to_nickname = '';
        $this->type = '';
        $this->battle_to = 0;
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
        $this->player_from = $object['player_from'];
        $this->player_to = $object['player_to'];
        $this->clan_to = $object['clan_to'];
        $this->text = $object['text'];
        $this->time = $object['time'];
        $this->player_from_nickname = $object['player_from_nickname'];
        $this->player_to_nickname = $object['player_to_nickname'];
        $this->type = $object['type'];
        $this->battle_to = $object['battle_to'];
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
        $object['player_from'] = $this->player_from;
        $object['player_to'] = $this->player_to;
        $object['clan_to'] = $this->clan_to;
        $object['text'] = $this->text;
        $object['time'] = $this->time;
        $object['player_from_nickname'] = $this->player_from_nickname;
        $object['player_to_nickname'] = $this->player_to_nickname;
        $object['type'] = $this->type;
        $object['battle_to'] = $this->battle_to;
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
            		$field = str_replace('chatlog.', '', $field);
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
            	$this->sql->query("UPDATE `chatlog".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `chatlog".$saveMerge."` SET `player_from`=".(int)$this->player_from.", `player_to`=".(int)$this->player_to.", `clan_to`=".(int)$this->clan_to.", `text`='".Std::cleanString($this->text)."', `time`=".(int)$this->time.", `player_from_nickname`='".Std::cleanString($this->player_from_nickname)."', `player_to_nickname`='".Std::cleanString($this->player_to_nickname)."', `type`='".Std::cleanString($this->type)."', `battle_to`=".(int)$this->battle_to." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `chatlog".$saveMerge."` (`player_from`, `player_to`, `clan_to`, `text`, `time`, `player_from_nickname`, `player_to_nickname`, `type`, `battle_to`) VALUES (".(int)$this->player_from.", ".(int)$this->player_to.", ".(int)$this->clan_to.", '".Std::cleanString($this->text)."', ".(int)$this->time.", '".Std::cleanString($this->player_from_nickname)."', '".Std::cleanString($this->player_to_nickname)."', '".Std::cleanString($this->type)."', ".(int)$this->battle_to.")");
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
			case 'player_from': return 2; break;
			case 'player_to': return 2; break;
			case 'clan_to': return 2; break;
			case 'text': return 4; break;
			case 'time': return 2; break;
			case 'player_from_nickname': return 4; break;
			case 'player_to_nickname': return 4; break;
			case 'type': return 15; break;
			case 'battle_to': return 2; break;
    	}
    }
}
?>