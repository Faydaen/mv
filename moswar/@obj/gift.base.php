<?php
class giftBaseObject extends Object
{
	public static $METAOBJECT = 'gift';
    public $type = '';
    public $type_Dictionary = array('gift','award');
    public static $TYPE = 'gift.type';
    public static $ID_METAATTRIBUTE = 'gift.id';
 	public static $ID = 'gift.id';
    public $player = 0;
    public static $PLAYER = 'gift.player';
    public $time = 0;
    public static $TIME = 'gift.time';
    public $player_from = '';
    public static $PLAYER_FROM = 'gift.player_from';
    public $anonymous = 0;
    public static $ANONYMOUS = 'gift.anonymous';
    public $name = '';
    public static $NAME = 'gift.name';
    public $image = '';
    public static $IMAGE = 'gift.image';
    public $info = '';
    public static $INFO = 'gift.info';
    public $comment = '';
    public static $COMMENT = 'gift.comment';
    public $endtime = 0;
    public static $ENDTIME = 'gift.endtime';
    public $code = '';
    public static $CODE = 'gift.code';
    public $private = 0;
    public static $PRIVATE = 'gift.private';
    public $unlocked = 0;
    public static $UNLOCKED = 'gift.unlocked';
    public $unlockedby = '';
    public static $UNLOCKEDBY = 'gift.unlockedby';
    public $standard_item = 0;
    public static $STANDARD_ITEM = 'gift.standard_item';
    public $hidden = 0;
    public static $HIDDEN = 'gift.hidden';

    public function __construct()
    {
        parent::__construct('gift');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->type = '';
        $this->player = 0;
        $this->time = 0;
        $this->player_from = '';
        $this->anonymous = 0;
        $this->name = '';
        $this->image = '';
        $this->info = '';
        $this->comment = '';
        $this->endtime = 0;
        $this->code = '';
        $this->private = 0;
        $this->unlocked = 0;
        $this->unlockedby = '';
        $this->standard_item = 0;
        $this->hidden = 0;
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
        $this->type = $object['type'];
        $this->player = $object['player'];
        $this->time = $object['time'];
        $this->player_from = $object['player_from'];
        $this->anonymous = $object['anonymous'];
        $this->name = $object['name'];
        $this->image = $object['image'];
        $this->info = $object['info'];
        $this->comment = $object['comment'];
        $this->endtime = $object['endtime'];
        $this->code = $object['code'];
        $this->private = $object['private'];
        $this->unlocked = $object['unlocked'];
        $this->unlockedby = $object['unlockedby'];
        $this->standard_item = $object['standard_item'];
        $this->hidden = $object['hidden'];
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
            case 156:
                $this->player = (int) $_POST['player'];
                $this->player_from = str_replace('"', '&quot;', $_POST['player_from']);
                $this->time = (int) $_POST['time'];
                $this->code = str_replace('"', '&quot;', $_POST['code']);
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->image = str_replace('"', '&quot;', $_POST['image']);
                $this->info = $_POST['info'];
                $this->comment = $_POST['comment'];
                $this->endtime = (int) $_POST['endtime'];
                $this->unlocked = isset($_POST['unlocked']) ? 1 : 0;
                $this->unlockedby = $_POST['unlockedby'];
                $this->anonymous = isset($_POST['anonymous']) ? 1 : 0;
                $this->private = isset($_POST['private']) ? 1 : 0;
                $this->type = $_POST['type'];
                $this->hidden = isset($_POST['hidden']) ? 1 : 0;
                $this->standard_item = (int) $_POST['standard_item'];
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
        $object['type'] = $this->type;
        $object['id'] = $this->id;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['time'] = $this->time;
        $object['player_from'] = $this->player_from;
        $object['anonymous'] = $this->anonymous;
        $object['name'] = $this->name;
        $object['image'] = $this->image;
        $object['info'] = $this->info;
        $object['comment'] = $this->comment;
        $object['endtime'] = $this->endtime;
        $object['code'] = $this->code;
        $object['private'] = $this->private;
        $object['unlocked'] = $this->unlocked;
        $object['unlockedby'] = $this->unlockedby;
        if (is_object($this->standard_item))
        {
            $object['standard_item'] = $this->standard_item->toArray();
        }
        else
        {
        	$object['standard_item'] = $this->standard_item;
        }
        $object['hidden'] = $this->hidden;
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
        if (is_object($this->standard_item))
        {
            $this->standard_item->save();
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
            		$field = str_replace('gift.', '', $field);
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
            	$this->sql->query("UPDATE `gift".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `gift".$saveMerge."` SET `type`='".Std::cleanString($this->type)."', `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `time`=".(int)$this->time.", `player_from`='".Std::cleanString($this->player_from)."', `anonymous`=".(int)$this->anonymous.", `name`='".Std::cleanString($this->name)."', `image`='".Std::cleanString($this->image)."', `info`='".Std::cleanString($this->info)."', `comment`='".Std::cleanString($this->comment)."', `endtime`=".(int)$this->endtime.", `code`='".Std::cleanString($this->code)."', `private`=".(int)$this->private.", `unlocked`=".(int)$this->unlocked.", `unlockedby`='".Std::cleanString($this->unlockedby)."', `standard_item`=".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", `hidden`=".(int)$this->hidden." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `gift".$saveMerge."` (`type`, `player`, `time`, `player_from`, `anonymous`, `name`, `image`, `info`, `comment`, `endtime`, `code`, `private`, `unlocked`, `unlockedby`, `standard_item`, `hidden`) VALUES ('".Std::cleanString($this->type)."', ".(is_object($this->player) ? $this->player->id : $this->player).", ".(int)$this->time.", '".Std::cleanString($this->player_from)."', ".(int)$this->anonymous.", '".Std::cleanString($this->name)."', '".Std::cleanString($this->image)."', '".Std::cleanString($this->info)."', '".Std::cleanString($this->comment)."', ".(int)$this->endtime.", '".Std::cleanString($this->code)."', ".(int)$this->private.", ".(int)$this->unlocked.", '".Std::cleanString($this->unlockedby)."', ".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", ".(int)$this->hidden.")");
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
			case 'type': return 15; break;
			case 'id': return 1; break;
			case 'player': return 13; break;
			case 'time': return 2; break;
			case 'player_from': return 4; break;
			case 'anonymous': return 10; break;
			case 'name': return 4; break;
			case 'image': return 4; break;
			case 'info': return 5; break;
			case 'comment': return 5; break;
			case 'endtime': return 2; break;
			case 'code': return 4; break;
			case 'private': return 10; break;
			case 'unlocked': return 10; break;
			case 'unlockedby': return 5; break;
			case 'standard_item': return 13; break;
			case 'hidden': return 10; break;
    	}
    }
}
?>