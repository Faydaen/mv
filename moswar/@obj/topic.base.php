<?php
class topicBaseObject extends Object
{
	public static $METAOBJECT = 'topic';
    public static $ID_METAATTRIBUTE = 'topic.id';
 	public static $ID = 'topic.id';
    public $name = '';
    public static $NAME = 'topic.name';
    public $forum = 0;
    public static $FORUM = 'topic.forum';
    public $startpost = 0;
    public static $STARTPOST = 'topic.startpost';
    public $position = 0;
    public static $POSITION = 'topic.position';
    public $question = '';
    public static $QUESTION = 'topic.question';
    public $closed = 0;
    public static $CLOSED = 'topic.closed';
    public $deleted = 0;
    public static $DELETED = 'topic.deleted';
    public $deletedby = 0;
    public static $DELETEDBY = 'topic.deletedby';
    public $deletedbydata = '';
    public static $DELETEDBYDATA = 'topic.deletedbydata';
    public $deleteddt = '0000-00-00 00:00:00';
    public static $DELETEDDT = 'topic.deleteddt';
    public $lastpost = 0;
    public static $LASTPOST = 'topic.lastpost';
    public $posts = 0;
    public static $POSTS = 'topic.posts';

    public function __construct()
    {
        parent::__construct('topic');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->forum = 0;
        $this->startpost = 0;
        $this->position = 0;
        $this->question = '';
        $this->closed = 0;
        $this->deleted = 0;
        $this->deletedby = 0;
        $this->deletedbydata = '';
        $this->deleteddt = '0000-00-00 00:00:00';
        $this->lastpost = 0;
        $this->posts = 0;
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
        $this->forum = $object['forum'];
        $this->startpost = $object['startpost'];
        $this->position = $object['position'];
        $this->question = $object['question'];
        $this->closed = $object['closed'];
        $this->deleted = $object['deleted'];
        $this->deletedby = $object['deletedby'];
        $this->deletedbydata = $object['deletedbydata'];
        $this->deleteddt = $object['deleteddt'];
        $this->lastpost = $object['lastpost'];
        $this->posts = $object['posts'];
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
            case 18:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->forum = (int) $_POST['forum'];
                $this->startpost = (int) $_POST['startpost'];
                $this->position = (int) $_POST['position'];
                $this->question = str_replace('"', '&quot;', $_POST['question']);
                $this->closed = isset($_POST['closed']) ? 1 : 0;
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
        $object['name'] = $this->name;
        if (is_object($this->forum))
        {
            $object['forum'] = $this->forum->toArray();
        }
        else
        {
        	$object['forum'] = $this->forum;
        }
        if (is_object($this->startpost))
        {
            $object['startpost'] = $this->startpost->toArray();
        }
        else
        {
        	$object['startpost'] = $this->startpost;
        }
        $object['position'] = $this->position;
        $object['question'] = $this->question;
        $object['closed'] = $this->closed;
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
        if (is_object($this->lastpost))
        {
            $object['lastpost'] = $this->lastpost->toArray();
        }
        else
        {
        	$object['lastpost'] = $this->lastpost;
        }
        $object['posts'] = $this->posts;
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
        if (is_object($this->forum))
        {
            $this->forum->save();
        }
        if (is_object($this->startpost))
        {
            $this->startpost->save();
        }
        if (is_object($this->deletedby))
        {
            $this->deletedby->save();
        }
        if (is_object($this->lastpost))
        {
            $this->lastpost->save();
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
            		$field = str_replace('topic.', '', $field);
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
            	$this->sql->query("UPDATE `topic".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `topic".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `forum`=".(is_object($this->forum) ? $this->forum->id : $this->forum).", `startpost`=".(is_object($this->startpost) ? $this->startpost->id : $this->startpost).", `position`=".(int)$this->position.", `question`='".Std::cleanString($this->question)."', `closed`=".(int)$this->closed.", `deleted`=".(int)$this->deleted.", `deletedby`=".(is_object($this->deletedby) ? $this->deletedby->id : $this->deletedby).", `deletedbydata`='".Std::cleanString($this->deletedbydata)."', `deleteddt`='".Std::cleanString($this->deleteddt)."', `lastpost`=".(is_object($this->lastpost) ? $this->lastpost->id : $this->lastpost).", `posts`=".(int)$this->posts." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `topic".$saveMerge."` (`name`, `forum`, `startpost`, `position`, `question`, `closed`, `deleted`, `deletedby`, `deletedbydata`, `deleteddt`, `lastpost`, `posts`) VALUES ('".Std::cleanString($this->name)."', ".(is_object($this->forum) ? $this->forum->id : $this->forum).", ".(is_object($this->startpost) ? $this->startpost->id : $this->startpost).", ".(int)$this->position.", '".Std::cleanString($this->question)."', ".(int)$this->closed.", ".(int)$this->deleted.", ".(is_object($this->deletedby) ? $this->deletedby->id : $this->deletedby).", '".Std::cleanString($this->deletedbydata)."', '".Std::cleanString($this->deleteddt)."', ".(is_object($this->lastpost) ? $this->lastpost->id : $this->lastpost).", ".(int)$this->posts.")");
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
			case 'forum': return 13; break;
			case 'startpost': return 13; break;
			case 'position': return 2; break;
			case 'question': return 4; break;
			case 'closed': return 10; break;
			case 'deleted': return 10; break;
			case 'deletedby': return 13; break;
			case 'deletedbydata': return 4; break;
			case 'deleteddt': return 8; break;
			case 'lastpost': return 13; break;
			case 'posts': return 2; break;
    	}
    }
}
?>