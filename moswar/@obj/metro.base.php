<?php
class metroBaseObject extends Object
{
	public static $METAOBJECT = 'metro';
    public static $ID_METAATTRIBUTE = 'metro.id';
 	public static $ID = 'metro.id';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident','rieltor','raider','grafter');
    public static $FRACTION = 'metro.fraction';
    public $name = '';
    public static $NAME = 'metro.name';
    public $private = 0;
    public static $PRIVATE = 'metro.private';
    public $minlevel = 0;
    public static $MINLEVEL = 'metro.minlevel';
    public $abonus = '';
    public static $ABONUS = 'metro.abonus';
    public $rbonus = '';
    public static $RBONUS = 'metro.rbonus';
    public $avotes = 0;
    public static $AVOTES = 'metro.avotes';
    public $rvotes = 0;
    public static $RVOTES = 'metro.rvotes';
    public $info = '';
    public static $INFO = 'metro.info';

    public function __construct()
    {
        parent::__construct('metro');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->fraction = '';
        $this->name = '';
        $this->private = 0;
        $this->minlevel = 0;
        $this->abonus = '';
        $this->rbonus = '';
        $this->avotes = 0;
        $this->rvotes = 0;
        $this->info = '';
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
        $this->fraction = $object['fraction'];
        $this->name = $object['name'];
        $this->private = $object['private'];
        $this->minlevel = $object['minlevel'];
        $this->abonus = $object['abonus'];
        $this->rbonus = $object['rbonus'];
        $this->avotes = $object['avotes'];
        $this->rvotes = $object['rvotes'];
        $this->info = $object['info'];
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
            case 138:
                $this->rvotes = (int) $_POST['rvotes'];
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->fraction = $_POST['fraction'];
                $this->info = $_POST['info'];
                $this->abonus = $_POST['abonus'];
                $this->private = isset($_POST['private']) ? 1 : 0;
                $this->avotes = (int) $_POST['avotes'];
                $this->rbonus = $_POST['rbonus'];
                $this->minlevel = (int) $_POST['minlevel'];
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
        $object['fraction'] = $this->fraction;
        $object['name'] = $this->name;
        $object['private'] = $this->private;
        $object['minlevel'] = $this->minlevel;
        $object['abonus'] = $this->abonus;
        $object['rbonus'] = $this->rbonus;
        $object['avotes'] = $this->avotes;
        $object['rvotes'] = $this->rvotes;
        $object['info'] = $this->info;
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
            		$field = str_replace('metro.', '', $field);
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
            	$this->sql->query("UPDATE `metro".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `metro".$saveMerge."` SET `fraction`='".Std::cleanString($this->fraction)."', `name`='".Std::cleanString($this->name)."', `private`=".(int)$this->private.", `minlevel`=".(int)$this->minlevel.", `abonus`='".Std::cleanString($this->abonus)."', `rbonus`='".Std::cleanString($this->rbonus)."', `avotes`=".(int)$this->avotes.", `rvotes`=".(int)$this->rvotes.", `info`='".Std::cleanString($this->info)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `metro".$saveMerge."` (`fraction`, `name`, `private`, `minlevel`, `abonus`, `rbonus`, `avotes`, `rvotes`, `info`) VALUES ('".Std::cleanString($this->fraction)."', '".Std::cleanString($this->name)."', ".(int)$this->private.", ".(int)$this->minlevel.", '".Std::cleanString($this->abonus)."', '".Std::cleanString($this->rbonus)."', ".(int)$this->avotes.", ".(int)$this->rvotes.", '".Std::cleanString($this->info)."')");
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
			case 'fraction': return 15; break;
			case 'name': return 4; break;
			case 'private': return 10; break;
			case 'minlevel': return 2; break;
			case 'abonus': return 5; break;
			case 'rbonus': return 5; break;
			case 'avotes': return 2; break;
			case 'rvotes': return 2; break;
			case 'info': return 5; break;
    	}
    }
}
?>