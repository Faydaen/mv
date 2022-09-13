<?php
class automobileBaseObject extends Object
{
	public static $METAOBJECT = 'automobile';
    public static $ID_METAATTRIBUTE = 'automobile.id';
 	public static $ID = 'automobile.id';
    public $player = 0;
    public static $PLAYER = 'automobile.player';
    public $state = '';
    public $state_Dictionary = array('create_car','upgrade_factory');
    public static $STATE = 'automobile.state';
    public $stateparam = 0;
    public static $STATEPARAM = 'automobile.stateparam';
    public $cooldown = 0;
    public static $COOLDOWN = 'automobile.cooldown';
    public $factory1 = 0;
    public static $FACTORY1 = 'automobile.factory1';
    public $factory2 = 0;
    public static $FACTORY2 = 'automobile.factory2';
    public $factory3 = 0;
    public static $FACTORY3 = 'automobile.factory3';
    public $factory4 = 0;
    public static $FACTORY4 = 'automobile.factory4';

    public function __construct()
    {
        parent::__construct('automobile');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->state = '';
        $this->stateparam = 0;
        $this->cooldown = 0;
        $this->factory1 = 0;
        $this->factory2 = 0;
        $this->factory3 = 0;
        $this->factory4 = 0;
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
        $this->state = $object['state'];
        $this->stateparam = $object['stateparam'];
        $this->cooldown = $object['cooldown'];
        $this->factory1 = $object['factory1'];
        $this->factory2 = $object['factory2'];
        $this->factory3 = $object['factory3'];
        $this->factory4 = $object['factory4'];
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
            case 181:
                $this->player = (int) $_POST['player'];
                $this->state = $_POST['state'];
                $this->stateparam = (int) $_POST['stateparam'];
                $this->factory1 = (int) $_POST['factory1'];
                $this->factory2 = (int) $_POST['factory2'];
                $this->factory3 = (int) $_POST['factory3'];
                $this->factory4 = (int) $_POST['factory4'];
                $this->cooldown = (int) $_POST['cooldown'];
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
        $object['state'] = $this->state;
        $object['stateparam'] = $this->stateparam;
        $object['cooldown'] = $this->cooldown;
        $object['factory1'] = $this->factory1;
        $object['factory2'] = $this->factory2;
        $object['factory3'] = $this->factory3;
        $object['factory4'] = $this->factory4;
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
            		$field = str_replace('automobile.', '', $field);
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
            	$this->sql->query("UPDATE `automobile".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `automobile".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `state`='".Std::cleanString($this->state)."', `stateparam`=".(int)$this->stateparam.", `cooldown`=".(int)$this->cooldown.", `factory1`=".(int)$this->factory1.", `factory2`=".(int)$this->factory2.", `factory3`=".(int)$this->factory3.", `factory4`=".(int)$this->factory4." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `automobile".$saveMerge."` (`player`, `state`, `stateparam`, `cooldown`, `factory1`, `factory2`, `factory3`, `factory4`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->state)."', ".(int)$this->stateparam.", ".(int)$this->cooldown.", ".(int)$this->factory1.", ".(int)$this->factory2.", ".(int)$this->factory3.", ".(int)$this->factory4.")");
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
			case 'state': return 15; break;
			case 'stateparam': return 2; break;
			case 'cooldown': return 2; break;
			case 'factory1': return 2; break;
			case 'factory2': return 2; break;
			case 'factory3': return 2; break;
			case 'factory4': return 2; break;
    	}
    }
}
?>