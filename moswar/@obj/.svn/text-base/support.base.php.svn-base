<?php
class supportBaseObject extends Object
{
	public static $METAOBJECT = 'support';
    public static $ID_METAATTRIBUTE = 'support.id';
 	public static $ID = 'support.id';
    public $name = '';
    public static $NAME = 'support.name';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'support.dt';
    public $type = '';
    public $type_Dictionary = array('Начисление мёда','Начисление монет, руды, опыта','Ошибки, пожелания, улучшения','Жалобы на игроков','Другое');
    public static $TYPE = 'support.type';
    public $priority = '';
    public $priority_Dictionary = array('Высокий','Обычный','Низкий');
    public static $PRIORITY = 'support.priority';
    public $status = '';
    public $status_Dictionary = array('Новое','Открыто','Закрыто');
    public static $STATUS = 'support.status';
    public $sysuser_id = 0;
    public static $SYSUSER_ID = 'support.sysuser_id';
    public $dt2 = '0000-00-00 00:00:00';
    public static $DT2 = 'support.dt2';
    public $player = 0;
    public static $PLAYER = 'support.player';
    public $comment = '';
    public static $COMMENT = 'support.comment';
    public $reply = '';
    public static $REPLY = 'support.reply';

    public function __construct()
    {
        parent::__construct('support');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->dt = '0000-00-00 00:00:00';
        $this->type = '';
        $this->priority = '';
        $this->status = '';
        $this->sysuser_id = 0;
        $this->dt2 = '0000-00-00 00:00:00';
        $this->player = 0;
        $this->comment = '';
        $this->reply = '';
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
        $this->dt = $object['dt'];
        $this->type = $object['type'];
        $this->priority = $object['priority'];
        $this->status = $object['status'];
        $this->sysuser_id = $object['sysuser_id'];
        $this->dt2 = $object['dt2'];
        $this->player = $object['player'];
        $this->comment = $object['comment'];
        $this->reply = $object['reply'];
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
            case 49:
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->type = $_POST['type'];
                $this->priority = $_POST['priority'];
                $this->status = $_POST['status'];
                $this->sysuser_id = (int) $_POST['sysuser_id'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt2']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt2 = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->name = $_POST['name'];
                $this->player = (int) $_POST['player'];
                $this->comment = $_POST['comment'];
                $this->reply = $_POST['reply'];
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
        $object['dt'] = $this->dt;
        $object['type'] = $this->type;
        $object['priority'] = $this->priority;
        $object['status'] = $this->status;
        if (is_object($this->sysuser_id))
        {
            $object['sysuser_id'] = $this->sysuser_id->toArray();
        }
        else
        {
        	$object['sysuser_id'] = $this->sysuser_id;
        }
        $object['dt2'] = $this->dt2;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['comment'] = $this->comment;
        $object['reply'] = $this->reply;
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
        if (is_object($this->sysuser_id))
        {
            $this->sysuser_id->save();
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
            		$field = str_replace('support.', '', $field);
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
            	$this->sql->query("UPDATE `support".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `support".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `dt`='".Std::cleanString($this->dt)."', `type`='".Std::cleanString($this->type)."', `priority`='".Std::cleanString($this->priority)."', `status`='".Std::cleanString($this->status)."', `sysuser_id`=".(is_object($this->sysuser_id) ? $this->sysuser_id->id : $this->sysuser_id).", `dt2`='".Std::cleanString($this->dt2)."', `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `comment`='".Std::cleanString($this->comment)."', `reply`='".Std::cleanString($this->reply)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `support".$saveMerge."` (`name`, `dt`, `type`, `priority`, `status`, `sysuser_id`, `dt2`, `player`, `comment`, `reply`) VALUES ('".Std::cleanString($this->name)."', '".Std::cleanString($this->dt)."', '".Std::cleanString($this->type)."', '".Std::cleanString($this->priority)."', '".Std::cleanString($this->status)."', ".(is_object($this->sysuser_id) ? $this->sysuser_id->id : $this->sysuser_id).", '".Std::cleanString($this->dt2)."', ".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->comment)."', '".Std::cleanString($this->reply)."')");
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
			case 'name': return 5; break;
			case 'dt': return 8; break;
			case 'type': return 15; break;
			case 'priority': return 15; break;
			case 'status': return 15; break;
			case 'sysuser_id': return 13; break;
			case 'dt2': return 8; break;
			case 'player': return 13; break;
			case 'comment': return 5; break;
			case 'reply': return 5; break;
    	}
    }
}
?>