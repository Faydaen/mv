<?php
class automobile_carBaseObject extends Object
{
	public static $METAOBJECT = 'automobile_car';
    public static $ID_METAATTRIBUTE = 'automobile_car.id';
 	public static $ID = 'automobile_car.id';
    public $player = 0;
    public static $PLAYER = 'automobile_car.player';
    public $model = 0;
    public static $MODEL = 'automobile_car.model';
    public $number = '';
    public static $NUMBER = 'automobile_car.number';
    public $improvements = 0;
    public static $IMPROVEMENTS = 'automobile_car.improvements';
    public $cooldown = 0;
    public static $COOLDOWN = 'automobile_car.cooldown';
    public $rides = 0;
    public static $RIDES = 'automobile_car.rides';
    public $speed = 0;
    public static $SPEED = 'automobile_car.speed';
    public $controllability = 0;
    public static $CONTROLLABILITY = 'automobile_car.controllability';
    public $passability = 0;
    public static $PASSABILITY = 'automobile_car.passability';
    public $prestige = 0;
    public static $PRESTIGE = 'automobile_car.prestige';
    public $createdat = 0;
    public static $CREATEDAT = 'automobile_car.createdat';
    public $dt_4096 = 0;
    public static $DT_4096 = 'automobile_car.dt_4096';
    public $dt_8192 = 0;
    public static $DT_8192 = 'automobile_car.dt_8192';

    public function __construct()
    {
        parent::__construct('automobile_car');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->model = 0;
        $this->number = '';
        $this->improvements = 0;
        $this->cooldown = 0;
        $this->rides = 0;
        $this->speed = 0;
        $this->controllability = 0;
        $this->passability = 0;
        $this->prestige = 0;
        $this->createdat = 0;
        $this->dt_4096 = 0;
        $this->dt_8192 = 0;
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
        $this->model = $object['model'];
        $this->number = $object['number'];
        $this->improvements = $object['improvements'];
        $this->cooldown = $object['cooldown'];
        $this->rides = $object['rides'];
        $this->speed = $object['speed'];
        $this->controllability = $object['controllability'];
        $this->passability = $object['passability'];
        $this->prestige = $object['prestige'];
        $this->createdat = $object['createdat'];
        $this->dt_4096 = $object['dt_4096'];
        $this->dt_8192 = $object['dt_8192'];
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
            case 183:
                $this->player = (int) $_POST['player'];
                $this->model = (int) $_POST['model'];
                $this->number = str_replace('"', '&quot;', $_POST['number']);
                $this->improvements = (int) $_POST['improvements'];
                $this->cooldown = (int) $_POST['cooldown'];
                $this->rides = (int) $_POST['rides'];
                $this->speed = (int) $_POST['speed'];
                $this->controllability = (int) $_POST['controllability'];
                $this->passability = (int) $_POST['passability'];
                $this->prestige = (int) $_POST['prestige'];
                $this->createdat = (int) $_POST['createdat'];
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
        $object['model'] = $this->model;
        $object['number'] = $this->number;
        $object['improvements'] = $this->improvements;
        $object['cooldown'] = $this->cooldown;
        $object['rides'] = $this->rides;
        $object['speed'] = $this->speed;
        $object['controllability'] = $this->controllability;
        $object['passability'] = $this->passability;
        $object['prestige'] = $this->prestige;
        $object['createdat'] = $this->createdat;
        $object['dt_4096'] = $this->dt_4096;
        $object['dt_8192'] = $this->dt_8192;
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
            		$field = str_replace('automobile_car.', '', $field);
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
            	$this->sql->query("UPDATE `automobile_car".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `automobile_car".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `model`=".(int)$this->model.", `number`='".Std::cleanString($this->number)."', `improvements`=".(int)$this->improvements.", `cooldown`=".(int)$this->cooldown.", `rides`=".(int)$this->rides.", `speed`=".(int)$this->speed.", `controllability`=".(int)$this->controllability.", `passability`=".(int)$this->passability.", `prestige`=".(int)$this->prestige.", `createdat`=".(int)$this->createdat.", `dt_4096`=".(int)$this->dt_4096.", `dt_8192`=".(int)$this->dt_8192." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `automobile_car".$saveMerge."` (`player`, `model`, `number`, `improvements`, `cooldown`, `rides`, `speed`, `controllability`, `passability`, `prestige`, `createdat`, `dt_4096`, `dt_8192`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", ".(int)$this->model.", '".Std::cleanString($this->number)."', ".(int)$this->improvements.", ".(int)$this->cooldown.", ".(int)$this->rides.", ".(int)$this->speed.", ".(int)$this->controllability.", ".(int)$this->passability.", ".(int)$this->prestige.", ".(int)$this->createdat.", ".(int)$this->dt_4096.", ".(int)$this->dt_8192.")");
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
			case 'model': return 2; break;
			case 'number': return 4; break;
			case 'improvements': return 2; break;
			case 'cooldown': return 2; break;
			case 'rides': return 2; break;
			case 'speed': return 2; break;
			case 'controllability': return 2; break;
			case 'passability': return 2; break;
			case 'prestige': return 2; break;
			case 'createdat': return 2; break;
			case 'dt_4096': return 2; break;
			case 'dt_8192': return 2; break;
    	}
    }
}
?>