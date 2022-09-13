<?php
class postBaseObject extends Object
{
	public static $METAOBJECT = 'post';
    public static $ID_METAATTRIBUTE = 'post.id';
 	public static $ID = 'post.id';
    public $text = '';
    public static $TEXT = 'post.text';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'post.dt';
    public $player = 0;
    public static $PLAYER = 'post.player';
    public $topic = 0;
    public static $TOPIC = 'post.topic';
    public $playerdata = '';
    public static $PLAYERDATA = 'post.playerdata';
    public $deleted = 0;
    public static $DELETED = 'post.deleted';
    public $deletedby = 0;
    public static $DELETEDBY = 'post.deletedby';
    public $deletedbydata = '';
    public static $DELETEDBYDATA = 'post.deletedbydata';
    public $deleteddt = '0000-00-00 00:00:00';
    public static $DELETEDDT = 'post.deleteddt';

    public function __construct()
    {
        parent::__construct('post');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->text = '';
        $this->dt = '0000-00-00 00:00:00';
        $this->player = 0;
        $this->topic = 0;
        $this->playerdata = '';
        $this->deleted = 0;
        $this->deletedby = 0;
        $this->deletedbydata = '';
        $this->deleteddt = '0000-00-00 00:00:00';
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
        $this->text = $object['text'];
        $this->dt = $object['dt'];
        $this->player = $object['player'];
        $this->topic = $object['topic'];
        $this->playerdata = $object['playerdata'];
        $this->deleted = $object['deleted'];
        $this->deletedby = $object['deletedby'];
        $this->deletedbydata = $object['deletedbydata'];
        $this->deleteddt = $object['deleteddt'];
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
            case 21:
                $this->text = $_POST['text'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->player = (int) $_POST['player'];
                $this->topic = (int) $_POST['topic'];
                $this->deleted = isset($_POST['deleted']) ? 1 : 0;
                $this->deletedby = (int) $_POST['deletedby'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['deleteddt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->deleteddt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
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
        $object['text'] = $this->text;
        $object['dt'] = $this->dt;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        if (is_object($this->topic))
        {
            $object['topic'] = $this->topic->toArray();
        }
        else
        {
        	$object['topic'] = $this->topic;
        }
        $object['playerdata'] = $this->playerdata;
        $object['deleted'] = $this->deleted;
        if (is_object($this->deletedby))
        {
            $object['deletedby'] = $this->deletedby->toArray();
        }
        else
        {
        	$object['deletedby'] = $this->deletedby;
        }
        $object['deletedbydata'] = $this->deletedbydata;
        $object['deleteddt'] = $this->deleteddt;
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
        if (is_object($this->topic))
        {
            $this->topic->save();
        }
        if (is_object($this->deletedby))
        {
            $this->deletedby->save();
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
            		$field = str_replace('post.', '', $field);
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
            	$this->sql->query("UPDATE `post".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `post".$saveMerge."` SET `text`='".Std::cleanString($this->text)."', `dt`='".Std::cleanString($this->dt)."', `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `topic`=".(is_object($this->topic) ? $this->topic->id : $this->topic).", `playerdata`='".Std::cleanString($this->playerdata)."', `deleted`=".(int)$this->deleted.", `deletedby`=".(is_object($this->deletedby) ? $this->deletedby->id : $this->deletedby).", `deletedbydata`='".Std::cleanString($this->deletedbydata)."', `deleteddt`='".Std::cleanString($this->deleteddt)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `post".$saveMerge."` (`text`, `dt`, `player`, `topic`, `playerdata`, `deleted`, `deletedby`, `deletedbydata`, `deleteddt`) VALUES ('".Std::cleanString($this->text)."', '".Std::cleanString($this->dt)."', ".(is_object($this->player) ? $this->player->id : $this->player).", ".(is_object($this->topic) ? $this->topic->id : $this->topic).", '".Std::cleanString($this->playerdata)."', ".(int)$this->deleted.", ".(is_object($this->deletedby) ? $this->deletedby->id : $this->deletedby).", '".Std::cleanString($this->deletedbydata)."', '".Std::cleanString($this->deleteddt)."')");
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
			case 'text': return 5; break;
			case 'dt': return 8; break;
			case 'player': return 13; break;
			case 'topic': return 13; break;
			case 'playerdata': return 4; break;
			case 'deleted': return 10; break;
			case 'deletedby': return 13; break;
			case 'deletedbydata': return 4; break;
			case 'deleteddt': return 8; break;
    	}
    }
}
?>