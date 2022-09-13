<?php
class perkBaseObject extends Object
{
	public static $METAOBJECT = 'perk';
    public static $ID_METAATTRIBUTE = 'perk.id';
 	public static $ID = 'perk.id';
    public $standard_item = 0;
    public static $STANDARD_ITEM = 'perk.standard_item';
    public $player = 0;
    public static $PLAYER = 'perk.player';
    public $clan = 0;
    public static $CLAN = 'perk.clan';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident');
    public static $FRACTION = 'perk.fraction';
    public $type = '';
    public static $TYPE = 'perk.type';
    public $code = '';
    public static $CODE = 'perk.code';
    public $value = '';
    public static $VALUE = 'perk.value';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'perk.dt';
    public $dt2 = '0000-00-00 00:00:00';
    public static $DT2 = 'perk.dt2';
    public $info = '';
    public static $INFO = 'perk.info';

    public function __construct()
    {
        parent::__construct('perk');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->standard_item = 0;
        $this->player = 0;
        $this->clan = 0;
        $this->fraction = '';
        $this->type = '';
        $this->code = '';
        $this->value = '';
        $this->dt = '0000-00-00 00:00:00';
        $this->dt2 = '0000-00-00 00:00:00';
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
        $this->standard_item = $object['standard_item'];
        $this->player = $object['player'];
        $this->clan = $object['clan'];
        $this->fraction = $object['fraction'];
        $this->type = $object['type'];
        $this->code = $object['code'];
        $this->value = $object['value'];
        $this->dt = $object['dt'];
        $this->dt2 = $object['dt2'];
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
            case 168:
                $this->player = (int) $_POST['player'];
                $this->clan = (int) $_POST['clan'];
                $this->fraction = $_POST['fraction'];
                $this->type = str_replace('"', '&quot;', $_POST['type']);
                $this->code = str_replace('"', '&quot;', $_POST['code']);
                $this->value = str_replace('"', '&quot;', $_POST['value']);
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt2']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt2 = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->info = str_replace('"', '&quot;', $_POST['info']);
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
        $object['id'] = $this->id;
        if (is_object($this->standard_item))
        {
            $object['standard_item'] = $this->standard_item->toArray();
        }
        else
        {
        	$object['standard_item'] = $this->standard_item;
        }
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        if (is_object($this->clan))
        {
            $object['clan'] = $this->clan->toArray();
        }
        else
        {
        	$object['clan'] = $this->clan;
        }
        $object['fraction'] = $this->fraction;
        $object['type'] = $this->type;
        $object['code'] = $this->code;
        $object['value'] = $this->value;
        $object['dt'] = $this->dt;
        $object['dt2'] = $this->dt2;
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
        if (is_object($this->standard_item))
        {
            $this->standard_item->save();
        }
        if (is_object($this->player))
        {
            $this->player->save();
        }
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
            		$field = str_replace('perk.', '', $field);
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
            	$this->sql->query("UPDATE `perk".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `perk".$saveMerge."` SET `standard_item`=".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `clan`=".(is_object($this->clan) ? $this->clan->id : $this->clan).", `fraction`='".Std::cleanString($this->fraction)."', `type`='".Std::cleanString($this->type)."', `code`='".Std::cleanString($this->code)."', `value`='".Std::cleanString($this->value)."', `dt`='".Std::cleanString($this->dt)."', `dt2`='".Std::cleanString($this->dt2)."', `info`='".Std::cleanString($this->info)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `perk".$saveMerge."` (`standard_item`, `player`, `clan`, `fraction`, `type`, `code`, `value`, `dt`, `dt2`, `info`) VALUES (".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", ".(is_object($this->player) ? $this->player->id : $this->player).", ".(is_object($this->clan) ? $this->clan->id : $this->clan).", '".Std::cleanString($this->fraction)."', '".Std::cleanString($this->type)."', '".Std::cleanString($this->code)."', '".Std::cleanString($this->value)."', '".Std::cleanString($this->dt)."', '".Std::cleanString($this->dt2)."', '".Std::cleanString($this->info)."')");
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
			case 'standard_item': return 13; break;
			case 'player': return 13; break;
			case 'clan': return 13; break;
			case 'fraction': return 15; break;
			case 'type': return 4; break;
			case 'code': return 4; break;
			case 'value': return 4; break;
			case 'dt': return 8; break;
			case 'dt2': return 8; break;
			case 'info': return 4; break;
    	}
    }
}
?>