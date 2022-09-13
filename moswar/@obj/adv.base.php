<?php
class advBaseObject extends Object
{
	public static $METAOBJECT = 'adv';
    public static $ID_METAATTRIBUTE = 'adv.id';
 	public static $ID = 'adv.id';
    public $name = '';
    public static $NAME = 'adv.name';
    public $code = '';
    public static $CODE = 'adv.code';
    public $www = '';
    public static $WWW = 'adv.www';
    public $banner = '';
    public static $BANNER = 'adv.banner';
    public $price = 0;
    public static $PRICE = 'adv.price';
    public $dt1 = '0000-00-00 00:00:00';
    public static $DT1 = 'adv.dt1';
    public $dt2 = '0000-00-00 00:00:00';
    public static $DT2 = 'adv.dt2';
    public $comment = '';
    public static $COMMENT = 'adv.comment';
    public $statsviews = 0;
    public static $STATSVIEWS = 'adv.statsviews';
    public $statsclicks = 0;
    public static $STATSCLICKS = 'adv.statsclicks';

    public function __construct()
    {
        parent::__construct('adv');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->code = '';
        $this->www = '';
        $this->banner = '';
        $this->price = 0;
        $this->dt1 = '0000-00-00 00:00:00';
        $this->dt2 = '0000-00-00 00:00:00';
        $this->comment = '';
        $this->statsviews = 0;
        $this->statsclicks = 0;
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
        $this->code = $object['code'];
        $this->www = $object['www'];
        $this->banner = $object['banner'];
        $this->price = $object['price'];
        $this->dt1 = $object['dt1'];
        $this->dt2 = $object['dt2'];
        $this->comment = $object['comment'];
        $this->statsviews = $object['statsviews'];
        $this->statsclicks = $object['statsclicks'];
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
            case 88:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->code = str_replace('"', '&quot;', $_POST['code']);
                $this->www = str_replace('"', '&quot;', $_POST['www']);
                $this->banner = str_replace('"', '&quot;', $_POST['banner']);
                $this->price = (int) $_POST['price'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt1']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt1 = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt2']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt2 = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->comment = $_POST['comment'];
                $this->statsviews = (int) $_POST['statsviews'];
                $this->statsclicks = (int) $_POST['statsclicks'];
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
        $object['code'] = $this->code;
        $object['www'] = $this->www;
        $object['banner'] = $this->banner;
        $object['price'] = $this->price;
        $object['dt1'] = $this->dt1;
        $object['dt2'] = $this->dt2;
        $object['comment'] = $this->comment;
        $object['statsviews'] = $this->statsviews;
        $object['statsclicks'] = $this->statsclicks;
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
            		$field = str_replace('adv.', '', $field);
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
            	$this->sql->query("UPDATE `adv".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `adv".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `code`='".Std::cleanString($this->code)."', `www`='".Std::cleanString($this->www)."', `banner`='".Std::cleanString($this->banner)."', `price`=".(int)$this->price.", `dt1`='".Std::cleanString($this->dt1)."', `dt2`='".Std::cleanString($this->dt2)."', `comment`='".Std::cleanString($this->comment)."', `statsviews`=".(int)$this->statsviews.", `statsclicks`=".(int)$this->statsclicks." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `adv".$saveMerge."` (`name`, `code`, `www`, `banner`, `price`, `dt1`, `dt2`, `comment`, `statsviews`, `statsclicks`) VALUES ('".Std::cleanString($this->name)."', '".Std::cleanString($this->code)."', '".Std::cleanString($this->www)."', '".Std::cleanString($this->banner)."', ".(int)$this->price.", '".Std::cleanString($this->dt1)."', '".Std::cleanString($this->dt2)."', '".Std::cleanString($this->comment)."', ".(int)$this->statsviews.", ".(int)$this->statsclicks.")");
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
			case 'code': return 4; break;
			case 'www': return 4; break;
			case 'banner': return 4; break;
			case 'price': return 2; break;
			case 'dt1': return 8; break;
			case 'dt2': return 8; break;
			case 'comment': return 5; break;
			case 'statsviews': return 2; break;
			case 'statsclicks': return 2; break;
    	}
    }
}
?>