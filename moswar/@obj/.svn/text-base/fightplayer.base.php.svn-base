<?php
class fightplayerBaseObject extends Object
{
	public static $METAOBJECT = 'fightplayer';
    public static $ID_METAATTRIBUTE = 'fightplayer.id';
 	public static $ID = 'fightplayer.id';
    public $fight = 0;
    public static $FIGHT = 'fightplayer.fight';
    public $player = 0;
    public static $PLAYER = 'fightplayer.player';
    public $data = '';
    public static $DATA = 'fightplayer.data';
    public $action = '';
    public static $ACTION = 'fightplayer.action';
    public $actiontime = '0000-00-00 00:00:00';
    public static $ACTIONTIME = 'fightplayer.actiontime';
    public $alive = 0;
    public static $ALIVE = 'fightplayer.alive';
    public $side = '';
    public static $SIDE = 'fightplayer.side';
    public $action2 = '';
    public static $ACTION2 = 'fightplayer.action2';

    public function __construct()
    {
        parent::__construct('fightplayer');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->fight = 0;
        $this->player = 0;
        $this->data = '';
        $this->action = '';
        $this->actiontime = '0000-00-00 00:00:00';
        $this->alive = 0;
        $this->side = '';
        $this->action2 = '';
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
        $this->fight = $object['fight'];
        $this->player = $object['player'];
        $this->data = $object['data'];
        $this->action = $object['action'];
        $this->actiontime = $object['actiontime'];
        $this->alive = $object['alive'];
        $this->side = $object['side'];
        $this->action2 = $object['action2'];
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
        if (is_object($this->fight))
        {
            $object['fight'] = $this->fight->toArray();
        }
        else
        {
        	$object['fight'] = $this->fight;
        }
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['data'] = $this->data;
        $object['action'] = $this->action;
        $object['actiontime'] = $this->actiontime;
        $object['alive'] = $this->alive;
        $object['side'] = $this->side;
        $object['action2'] = $this->action2;
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
        if (is_object($this->fight))
        {
            $this->fight->save();
        }
        if (is_object($this->player))
        {
            $this->player->save();
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
            		$field = str_replace('fightplayer.', '', $field);
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
            	$this->sql->query("UPDATE `fightplayer".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `fightplayer".$saveMerge."` SET `fight`=".(is_object($this->fight) ? $this->fight->id : $this->fight).", `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `data`='".Std::cleanString($this->data)."', `action`='".Std::cleanString($this->action)."', `actiontime`='".Std::cleanString($this->actiontime)."', `alive`=".(int)$this->alive.", `side`='".Std::cleanString($this->side)."', `action2`='".Std::cleanString($this->action2)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `fightplayer".$saveMerge."` (`fight`, `player`, `data`, `action`, `actiontime`, `alive`, `side`, `action2`) VALUES (".(is_object($this->fight) ? $this->fight->id : $this->fight).", ".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->data)."', '".Std::cleanString($this->action)."', '".Std::cleanString($this->actiontime)."', ".(int)$this->alive.", '".Std::cleanString($this->side)."', '".Std::cleanString($this->action2)."')");
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
			case 'fight': return 13; break;
			case 'player': return 13; break;
			case 'data': return 6; break;
			case 'action': return 5; break;
			case 'actiontime': return 8; break;
			case 'alive': return 10; break;
			case 'side': return 4; break;
			case 'action2': return 5; break;
    	}
    }
}
?>