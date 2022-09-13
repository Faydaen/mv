<?php
class quest_standardBaseObject extends Object
{
	public static $METAOBJECT = 'quest_standard';
    public static $ID_METAATTRIBUTE = 'quest_standard.id';
 	public static $ID = 'quest_standard.id';
    public $codename = '';
    public static $CODENAME = 'quest_standard.codename';
    public $title = '';
    public static $TITLE = 'quest_standard.title';
    public $info = '';
    public static $INFO = 'quest_standard.info';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident','both');
    public static $FRACTION = 'quest_standard.fraction';
    public $level = 0;
    public static $LEVEL = 'quest_standard.level';
    public $location = '';
    public static $LOCATION = 'quest_standard.location';
    public $condition = '';
    public static $CONDITION = 'quest_standard.condition';
    public $autostart = 0;
    public static $AUTOSTART = 'quest_standard.autostart';
    public $priority = 0;
    public static $PRIORITY = 'quest_standard.priority';
    public $item = '';
    public static $ITEM = 'quest_standard.item';

    public function __construct()
    {
        parent::__construct('quest_standard');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->codename = '';
        $this->title = '';
        $this->info = '';
        $this->fraction = '';
        $this->level = 0;
        $this->location = '';
        $this->condition = '';
        $this->autostart = 0;
        $this->priority = 0;
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
        $this->codename = $object['codename'];
        $this->title = $object['title'];
        $this->info = $object['info'];
        $this->fraction = $object['fraction'];
        $this->level = $object['level'];
        $this->location = $object['location'];
        $this->condition = $object['condition'];
        $this->autostart = $object['autostart'];
        $this->priority = $object['priority'];
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
            case 30:
                $this->codename = str_replace('"', '&quot;', $_POST['codename']);
                $this->title = str_replace('"', '&quot;', $_POST['title']);
                $this->info = $_POST['info'];
                $this->fraction = $_POST['fraction'];
                $this->level = (int) $_POST['level'];
                $this->location = str_replace('"', '&quot;', $_POST['location']);
                $this->condition = str_replace('"', '&quot;', $_POST['condition']);
                $this->autostart = isset($_POST['autostart']) ? 1 : 0;
                $this->priority = (int) $_POST['priority'];
                $this->item = str_replace('"', '&quot;', $_POST['item']);
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
        $object['codename'] = $this->codename;
        $object['title'] = $this->title;
        $object['info'] = $this->info;
        $object['fraction'] = $this->fraction;
        $object['level'] = $this->level;
        $object['location'] = $this->location;
        $object['condition'] = $this->condition;
        $object['autostart'] = $this->autostart;
        $object['priority'] = $this->priority;
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
            		$field = str_replace('quest_standard.', '', $field);
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
            	$this->sql->query("UPDATE `quest_standard".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `quest_standard".$saveMerge."` SET `codename`='".Std::cleanString($this->codename)."', `title`='".Std::cleanString($this->title)."', `info`='".Std::cleanString($this->info)."', `fraction`='".Std::cleanString($this->fraction)."', `level`=".(int)$this->level.", `location`='".Std::cleanString($this->location)."', `condition`='".Std::cleanString($this->condition)."', `autostart`=".(int)$this->autostart.", `priority`=".(int)$this->priority.", `item`='".Std::cleanString($this->item)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `quest_standard".$saveMerge."` (`codename`, `title`, `info`, `fraction`, `level`, `location`, `condition`, `autostart`, `priority`, `item`) VALUES ('".Std::cleanString($this->codename)."', '".Std::cleanString($this->title)."', '".Std::cleanString($this->info)."', '".Std::cleanString($this->fraction)."', ".(int)$this->level.", '".Std::cleanString($this->location)."', '".Std::cleanString($this->condition)."', ".(int)$this->autostart.", ".(int)$this->priority.", '".Std::cleanString($this->item)."')");
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
			case 'codename': return 4; break;
			case 'title': return 4; break;
			case 'info': return 5; break;
			case 'fraction': return 15; break;
			case 'level': return 2; break;
			case 'location': return 4; break;
			case 'condition': return 4; break;
			case 'autostart': return 10; break;
			case 'priority': return 2; break;
			case 'item': return 4; break;
    	}
    }
}
?>