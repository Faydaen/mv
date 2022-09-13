<?php
class stdpageBaseObject extends Object
{
	public static $METAOBJECT = 'stdpage';
    public static $ID_METAATTRIBUTE = 'stdpage.id';
 	public static $ID = 'stdpage.id';
    public $_id = 0;
    public static $_ID = 'stdpage._id';
    public $url = '';
    public static $URL = 'stdpage.url';
    public $stdtemplate_id = 0;
    public static $STDTEMPLATE_ID = 'stdpage.stdtemplate_id';
    public $stdmodule_id = 0;
    public static $STDMODULE_ID = 'stdpage.stdmodule_id';
    public $name = '';
    public static $NAME = 'stdpage.name';
    public $content = '';
    public static $CONTENT = 'stdpage.content';
    public $pos = 0;
    public static $POS = 'stdpage.pos';
    public $menuname = '';
    public static $MENUNAME = 'stdpage.menuname';
    public $windowname = '';
    public static $WINDOWNAME = 'stdpage.windowname';
    public $metakeywords = '';
    public static $METAKEYWORDS = 'stdpage.metakeywords';
    public $metadescription = '';
    public static $METADESCRIPTION = 'stdpage.metadescription';

    public function __construct()
    {
        parent::__construct('stdpage');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->_id = 0;
        $this->url = '';
        $this->stdtemplate_id = 0;
        $this->stdmodule_id = 0;
        $this->name = '';
        $this->content = '';
        $this->pos = 0;
        $this->menuname = '';
        $this->windowname = '';
        $this->metakeywords = '';
        $this->metadescription = '';
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
        $this->_id = $object['_id'];
        $this->url = $object['url'];
        $this->stdtemplate_id = $object['stdtemplate_id'];
        $this->stdmodule_id = $object['stdmodule_id'];
        $this->name = $object['name'];
        $this->content = $object['content'];
        $this->pos = $object['pos'];
        $this->menuname = $object['menuname'];
        $this->windowname = $object['windowname'];
        $this->metakeywords = $object['metakeywords'];
        $this->metadescription = $object['metadescription'];
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
            case 1:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->content = $_POST['content'];
                $this->pos = (int) $_POST['pos'];
                $this->menuname = str_replace('"', '&quot;', $_POST['menuname']);
                $this->windowname = str_replace('"', '&quot;', $_POST['windowname']);
                $this->metakeywords = str_replace('"', '&quot;', $_POST['metakeywords']);
                $this->metadescription = str_replace('"', '&quot;', $_POST['metadescription']);
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
        if (is_object($this->_id))
        {
            $object['_id'] = $this->_id->toArray();
        }
        else
        {
        	$object['_id'] = $this->_id;
        }
        $object['url'] = $this->url;
        if (is_object($this->stdtemplate_id))
        {
            $object['stdtemplate_id'] = $this->stdtemplate_id->toArray();
        }
        else
        {
        	$object['stdtemplate_id'] = $this->stdtemplate_id;
        }
        if (is_object($this->stdmodule_id))
        {
            $object['stdmodule_id'] = $this->stdmodule_id->toArray();
        }
        else
        {
        	$object['stdmodule_id'] = $this->stdmodule_id;
        }
        $object['name'] = $this->name;
        $object['content'] = $this->content;
        $object['pos'] = $this->pos;
        $object['menuname'] = $this->menuname;
        $object['windowname'] = $this->windowname;
        $object['metakeywords'] = $this->metakeywords;
        $object['metadescription'] = $this->metadescription;
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
        if (is_object($this->_id))
        {
            $this->_id->save();
        }
        if (is_object($this->stdtemplate_id))
        {
            $this->stdtemplate_id->save();
        }
        if (is_object($this->stdmodule_id))
        {
            $this->stdmodule_id->save();
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
            		$field = str_replace('stdpage.', '', $field);
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
            	$this->sql->query("UPDATE `stdpage".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `stdpage".$saveMerge."` SET `_id`=".(is_object($this->_id) ? $this->_id->id : $this->_id).", `url`='".Std::cleanString($this->url)."', `stdtemplate_id`=".(is_object($this->stdtemplate_id) ? $this->stdtemplate_id->id : $this->stdtemplate_id).", `stdmodule_id`=".(is_object($this->stdmodule_id) ? $this->stdmodule_id->id : $this->stdmodule_id).", `name`='".Std::cleanString($this->name)."', `content`='".Std::cleanString($this->content)."', `pos`=".(int)$this->pos.", `menuname`='".Std::cleanString($this->menuname)."', `windowname`='".Std::cleanString($this->windowname)."', `metakeywords`='".Std::cleanString($this->metakeywords)."', `metadescription`='".Std::cleanString($this->metadescription)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `stdpage".$saveMerge."` (`_id`, `url`, `stdtemplate_id`, `stdmodule_id`, `name`, `content`, `pos`, `menuname`, `windowname`, `metakeywords`, `metadescription`) VALUES (".(is_object($this->_id) ? $this->_id->id : $this->_id).", '".Std::cleanString($this->url)."', ".(is_object($this->stdtemplate_id) ? $this->stdtemplate_id->id : $this->stdtemplate_id).", ".(is_object($this->stdmodule_id) ? $this->stdmodule_id->id : $this->stdmodule_id).", '".Std::cleanString($this->name)."', '".Std::cleanString($this->content)."', ".(int)$this->pos.", '".Std::cleanString($this->menuname)."', '".Std::cleanString($this->windowname)."', '".Std::cleanString($this->metakeywords)."', '".Std::cleanString($this->metadescription)."')");
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
			case '_id': return 13; break;
			case 'url': return 4; break;
			case 'stdtemplate_id': return 13; break;
			case 'stdmodule_id': return 13; break;
			case 'name': return 4; break;
			case 'content': return 5; break;
			case 'pos': return 2; break;
			case 'menuname': return 4; break;
			case 'windowname': return 4; break;
			case 'metakeywords': return 4; break;
			case 'metadescription': return 4; break;
    	}
    }
}
?>