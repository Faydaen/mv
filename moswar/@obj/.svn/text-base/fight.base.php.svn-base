<?php
class fightBaseObject extends Object
{
	public static $METAOBJECT = 'fight';
    public static $ID_METAATTRIBUTE = 'fight.id';
 	public static $ID = 'fight.id';
    public $state = '';
    public $state_Dictionary = array('created','started','finished','finishing','starting');
    public static $STATE = 'fight.state';
    public $type = '';
    public $type_Dictionary = array('group','clanwar','flag','bank','test','level','chaotic','metro');
    public static $TYPE = 'fight.type';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'fight.dt';
    public $data = '';
    public static $DATA = 'fight.data';
    public $players = '';
    public static $PLAYERS = 'fight.players';
    public $results = '';
    public static $RESULTS = 'fight.results';
    public $log = '';
    public static $LOG = 'fight.log';
    public $diplomacy = 0;
    public static $DIPLOMACY = 'fight.diplomacy';
    public $level = 0;
    public static $LEVEL = 'fight.level';
    public $playersid = '';
    public static $PLAYERSID = 'fight.playersid';
    public $dm = 0;
    public static $DM = 'fight.dm';
    public $am = 0;
    public static $AM = 'fight.am';
    public $dc = 0;
    public static $DC = 'fight.dc';
    public $ac = 0;
    public static $AC = 'fight.ac';
    public $steps = 0;
    public static $STEPS = 'fight.steps';
    public $start_dt = '0000-00-00 00:00:00';
    public static $START_DT = 'fight.start_dt';
    public $finishing = '';
    public static $FINISHING = 'fight.finishing';

    public function __construct()
    {
        parent::__construct('fight');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->state = '';
        $this->type = '';
        $this->dt = '0000-00-00 00:00:00';
        $this->data = '';
        $this->players = '';
        $this->results = '';
        $this->log = '';
        $this->diplomacy = 0;
        $this->level = 0;
        $this->playersid = '';
        $this->dm = 0;
        $this->am = 0;
        $this->dc = 0;
        $this->ac = 0;
        $this->steps = 0;
        $this->start_dt = '0000-00-00 00:00:00';
        $this->finishing = '';
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
        $this->state = $object['state'];
        $this->type = $object['type'];
        $this->dt = $object['dt'];
        $this->data = $object['data'];
        $this->players = $object['players'];
        $this->results = $object['results'];
        $this->log = $object['log'];
        $this->diplomacy = $object['diplomacy'];
        $this->level = $object['level'];
        $this->playersid = $object['playersid'];
        $this->dm = $object['dm'];
        $this->am = $object['am'];
        $this->dc = $object['dc'];
        $this->ac = $object['ac'];
        $this->steps = $object['steps'];
        $this->start_dt = $object['start_dt'];
        $this->finishing = $object['finishing'];
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
        $object['state'] = $this->state;
        $object['type'] = $this->type;
        $object['dt'] = $this->dt;
        $object['data'] = $this->data;
        $object['players'] = $this->players;
        $object['results'] = $this->results;
        $object['log'] = $this->log;
        if (is_object($this->diplomacy))
        {
            $object['diplomacy'] = $this->diplomacy->toArray();
        }
        else
        {
        	$object['diplomacy'] = $this->diplomacy;
        }
        $object['level'] = $this->level;
        $object['playersid'] = $this->playersid;
        $object['dm'] = $this->dm;
        $object['am'] = $this->am;
        $object['dc'] = $this->dc;
        $object['ac'] = $this->ac;
        $object['steps'] = $this->steps;
        $object['start_dt'] = $this->start_dt;
        $object['finishing'] = $this->finishing;
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
        if (is_object($this->diplomacy))
        {
            $this->diplomacy->save();
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
            		$field = str_replace('fight.', '', $field);
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
            	$this->sql->query("UPDATE `fight".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `fight".$saveMerge."` SET `state`='".Std::cleanString($this->state)."', `type`='".Std::cleanString($this->type)."', `dt`='".Std::cleanString($this->dt)."', `data`='".Std::cleanString($this->data)."', `players`='".Std::cleanString($this->players)."', `results`='".Std::cleanString($this->results)."', `log`='".Std::cleanString($this->log)."', `diplomacy`=".(is_object($this->diplomacy) ? $this->diplomacy->id : $this->diplomacy).", `level`=".(int)$this->level.", `playersid`='".Std::cleanString($this->playersid)."', `dm`=".(int)$this->dm.", `am`=".(int)$this->am.", `dc`=".(int)$this->dc.", `ac`=".(int)$this->ac.", `steps`=".(int)$this->steps.", `start_dt`='".Std::cleanString($this->start_dt)."', `finishing`='".Std::cleanString($this->finishing)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `fight".$saveMerge."` (`state`, `type`, `dt`, `data`, `players`, `results`, `log`, `diplomacy`, `level`, `playersid`, `dm`, `am`, `dc`, `ac`, `steps`, `start_dt`, `finishing`) VALUES ('".Std::cleanString($this->state)."', '".Std::cleanString($this->type)."', '".Std::cleanString($this->dt)."', '".Std::cleanString($this->data)."', '".Std::cleanString($this->players)."', '".Std::cleanString($this->results)."', '".Std::cleanString($this->log)."', ".(is_object($this->diplomacy) ? $this->diplomacy->id : $this->diplomacy).", ".(int)$this->level.", '".Std::cleanString($this->playersid)."', ".(int)$this->dm.", ".(int)$this->am.", ".(int)$this->dc.", ".(int)$this->ac.", ".(int)$this->steps.", '".Std::cleanString($this->start_dt)."', '".Std::cleanString($this->finishing)."')");
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
			case 'state': return 15; break;
			case 'type': return 15; break;
			case 'dt': return 8; break;
			case 'data': return 5; break;
			case 'players': return 6; break;
			case 'results': return 5; break;
			case 'log': return 6; break;
			case 'diplomacy': return 13; break;
			case 'level': return 2; break;
			case 'playersid': return 5; break;
			case 'dm': return 2; break;
			case 'am': return 2; break;
			case 'dc': return 2; break;
			case 'ac': return 2; break;
			case 'steps': return 2; break;
			case 'start_dt': return 8; break;
			case 'finishing': return 4; break;
    	}
    }
}
?>