<?php
class messageBaseObject extends Object
{
	public static $METAOBJECT = 'message';
    public static $ID_METAATTRIBUTE = 'message.id';
 	public static $ID = 'message.id';
    public $player = 0;
    public static $PLAYER = 'message.player';
    public $player2 = 0;
    public static $PLAYER2 = 'message.player2';
    public $type = '';
    public $type_Dictionary = array('message','system_notice','clan_message','sovet_message');
    public static $TYPE = 'message.type';
    public $read = 0;
    public static $READ = 'message.read';
    public $text = '';
    public static $TEXT = 'message.text';
    public $visible1 = 0;
    public static $VISIBLE1 = 'message.visible1';
    public $visible2 = 0;
    public static $VISIBLE2 = 'message.visible2';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'message.dt';
    public $params = '';
    public static $PARAMS = 'message.params';

    public function __construct()
    {
        parent::__construct('message');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->player2 = 0;
        $this->type = '';
        $this->read = 0;
        $this->text = '';
        $this->visible1 = 0;
        $this->visible2 = 0;
        $this->dt = '0000-00-00 00:00:00';
        $this->params = '';
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
        $this->player2 = $object['player2'];
        $this->type = $object['type'];
        $this->read = $object['read'];
        $this->text = $object['text'];
        $this->visible1 = $object['visible1'];
        $this->visible2 = $object['visible2'];
        $this->dt = $object['dt'];
        $this->params = $object['params'];
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
            case 75:
                $this->type = $_POST['type'];
                $this->player = (int) $_POST['player'];
                $this->player2 = (int) $_POST['player2'];
                $this->text = $_POST['text'];
                $this->read = isset($_POST['read']) ? 1 : 0;
                $this->visible1 = isset($_POST['visible1']) ? 1 : 0;
                $this->visible2 = isset($_POST['visible2']) ? 1 : 0;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
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
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        if (is_object($this->player2))
        {
            $object['player2'] = $this->player2->toArray();
        }
        else
        {
        	$object['player2'] = $this->player2;
        }
        $object['type'] = $this->type;
        $object['read'] = $this->read;
        $object['text'] = $this->text;
        $object['visible1'] = $this->visible1;
        $object['visible2'] = $this->visible2;
        $object['dt'] = $this->dt;
        $object['params'] = $this->params;
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
        if (is_object($this->player2))
        {
            $this->player2->save();
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
            		$field = str_replace('message.', '', $field);
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
            	$this->sql->query("UPDATE `message".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `message".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `player2`=".(is_object($this->player2) ? $this->player2->id : $this->player2).", `type`='".Std::cleanString($this->type)."', `read`=".(int)$this->read.", `text`='".Std::cleanString($this->text)."', `visible1`=".(int)$this->visible1.", `visible2`=".(int)$this->visible2.", `dt`='".Std::cleanString($this->dt)."', `params`='".Std::cleanString($this->params)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `message".$saveMerge."` (`player`, `player2`, `type`, `read`, `text`, `visible1`, `visible2`, `dt`, `params`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", ".(is_object($this->player2) ? $this->player2->id : $this->player2).", '".Std::cleanString($this->type)."', ".(int)$this->read.", '".Std::cleanString($this->text)."', ".(int)$this->visible1.", ".(int)$this->visible2.", '".Std::cleanString($this->dt)."', '".Std::cleanString($this->params)."')");
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
			case 'player2': return 13; break;
			case 'type': return 15; break;
			case 'read': return 10; break;
			case 'text': return 5; break;
			case 'visible1': return 10; break;
			case 'visible2': return 10; break;
			case 'dt': return 8; break;
			case 'params': return 5; break;
    	}
    }
}
?>