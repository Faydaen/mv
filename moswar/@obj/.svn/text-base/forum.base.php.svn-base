<?php
class forumBaseObject extends Object
{
	public static $METAOBJECT = 'forum';
    public static $ID_METAATTRIBUTE = 'forum.id';
 	public static $ID = 'forum.id';
    public $name = '';
    public static $NAME = 'forum.name';
    public $fraction = '';
    public $fraction_Dictionary = array('resident','arrived');
    public static $FRACTION = 'forum.fraction';
    public $accesslevel = 0;
    public static $ACCESSLEVEL = 'forum.accesslevel';
    public $closed = 0;
    public static $CLOSED = 'forum.closed';
    public $desc = '';
    public static $DESC = 'forum.desc';
    public $minlevel = 0;
    public static $MINLEVEL = 'forum.minlevel';
    public $clans = '';
    public static $CLANS = 'forum.clans';
    public $clan = 0;
    public static $CLAN = 'forum.clan';

    public function __construct()
    {
        parent::__construct('forum');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->fraction = '';
        $this->accesslevel = 0;
        $this->closed = 0;
        $this->desc = '';
        $this->minlevel = 0;
        $this->clans = '';
        $this->clan = 0;
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
        $this->fraction = $object['fraction'];
        $this->accesslevel = $object['accesslevel'];
        $this->closed = $object['closed'];
        $this->desc = $object['desc'];
        $this->minlevel = $object['minlevel'];
        $this->clans = $object['clans'];
        $this->clan = $object['clan'];
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
            case 15:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->fraction = $_POST['fraction'];
                $this->accesslevel = (int) $_POST['accesslevel'];
                $this->closed = isset($_POST['closed']) ? 1 : 0;
                $this->desc = str_replace('"', '&quot;', $_POST['desc']);
                $this->minlevel = (int) $_POST['minlevel'];
                $this->clans = str_replace('"', '&quot;', $_POST['clans']);
                $this->clan = (int) $_POST['clan'];
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
        $object['fraction'] = $this->fraction;
        $object['accesslevel'] = $this->accesslevel;
        $object['closed'] = $this->closed;
        $object['desc'] = $this->desc;
        $object['minlevel'] = $this->minlevel;
        $object['clans'] = $this->clans;
        if (is_object($this->clan))
        {
            $object['clan'] = $this->clan->toArray();
        }
        else
        {
        	$object['clan'] = $this->clan;
        }
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
        if (is_object($this->clan))
        {
            $this->clan->save();
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
            		$field = str_replace('forum.', '', $field);
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
            	$this->sql->query("UPDATE `forum".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `forum".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `fraction`='".Std::cleanString($this->fraction)."', `accesslevel`=".(int)$this->accesslevel.", `closed`=".(int)$this->closed.", `desc`='".Std::cleanString($this->desc)."', `minlevel`=".(int)$this->minlevel.", `clans`='".Std::cleanString($this->clans)."', `clan`=".(is_object($this->clan) ? $this->clan->id : $this->clan)." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `forum".$saveMerge."` (`name`, `fraction`, `accesslevel`, `closed`, `desc`, `minlevel`, `clans`, `clan`) VALUES ('".Std::cleanString($this->name)."', '".Std::cleanString($this->fraction)."', ".(int)$this->accesslevel.", ".(int)$this->closed.", '".Std::cleanString($this->desc)."', ".(int)$this->minlevel.", '".Std::cleanString($this->clans)."', ".(is_object($this->clan) ? $this->clan->id : $this->clan).")");
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
			case 'fraction': return 15; break;
			case 'accesslevel': return 2; break;
			case 'closed': return 10; break;
			case 'desc': return 4; break;
			case 'minlevel': return 2; break;
			case 'clans': return 4; break;
			case 'clan': return 13; break;
    	}
    }
}
?>