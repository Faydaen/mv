<?php
class onlinecounterBaseObject extends Object
{
	public static $METAOBJECT = 'onlinecounter';
    public $dt = '0000-00-00';
    public static $DT = 'onlinecounter.dt';
    public $level = 0;
    public static $LEVEL = 'onlinecounter.level';
    public $player = 0;
    public static $PLAYER = 'onlinecounter.player';
    public static $ID_METAATTRIBUTE = 'onlinecounter.id';
 	public static $ID = 'onlinecounter.id';
    public $zlo = 0;
    public static $ZLO = 'onlinecounter.zlo';
    public $online = 0;
    public static $ONLINE = 'onlinecounter.online';
    public $metro = 0;
    public static $METRO = 'onlinecounter.metro';
    public $duels = 0;
    public static $DUELS = 'onlinecounter.duels';
    public $auth = 0;
    public static $AUTH = 'onlinecounter.auth';
    public $stdlon = 0;
    public static $STDLON = 'onlinecounter.stdlon';
    public $stmton = 0;
    public static $STMTON = 'onlinecounter.stmton';
    public $stauon = 0;
    public static $STAUON = 'onlinecounter.stauon';

    public function __construct()
    {
        parent::__construct('onlinecounter');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->dt = '0000-00-00';
        $this->level = 0;
        $this->player = 0;
        $this->zlo = 0;
        $this->online = 0;
        $this->metro = 0;
        $this->duels = 0;
        $this->auth = 0;
        $this->stdlon = 0;
        $this->stmton = 0;
        $this->stauon = 0;
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
        $this->dt = $object['dt'];
        $this->level = $object['level'];
        $this->player = $object['player'];
        $this->zlo = $object['zlo'];
        $this->online = $object['online'];
        $this->metro = $object['metro'];
        $this->duels = $object['duels'];
        $this->auth = $object['auth'];
        $this->stdlon = $object['stdlon'];
        $this->stmton = $object['stmton'];
        $this->stauon = $object['stauon'];
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
            case 117:
                $this->player = (int) $_POST['player'];
                $this->level = (int) $_POST['level'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000';
                }
                $d = explode('.', $dt);
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0];
                $this->zlo = (int) $_POST['zlo'];
                $this->online = (int) $_POST['online'];
                $this->metro = (int) $_POST['metro'];
                $this->duels = (int) $_POST['duels'];
                $this->auth = (int) $_POST['auth'];
                $this->stdlon = (double) str_replace(',', '.', $_POST['stdlon']);
                $this->stmton = (double) str_replace(',', '.', $_POST['stmton']);
                $this->stauon = (double) str_replace(',', '.', $_POST['stauon']);
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
        $object['dt'] = $this->dt;
        $object['level'] = $this->level;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['id'] = $this->id;
        $object['zlo'] = $this->zlo;
        $object['online'] = $this->online;
        $object['metro'] = $this->metro;
        $object['duels'] = $this->duels;
        $object['auth'] = $this->auth;
        $object['stdlon'] = $this->stdlon;
        $object['stmton'] = $this->stmton;
        $object['stauon'] = $this->stauon;
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
            		$field = str_replace('onlinecounter.', '', $field);
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
            	$this->sql->query("UPDATE `onlinecounter".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `onlinecounter".$saveMerge."` SET `dt`='".Std::cleanString($this->dt)."', `level`=".(int)$this->level.", `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `zlo`=".(int)$this->zlo.", `online`=".(int)$this->online.", `metro`=".(int)$this->metro.", `duels`=".(int)$this->duels.", `auth`=".(int)$this->auth.", `stdlon`=".(double)$this->stdlon.", `stmton`=".(double)$this->stmton.", `stauon`=".(double)$this->stauon." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `onlinecounter".$saveMerge."` (`dt`, `level`, `player`, `zlo`, `online`, `metro`, `duels`, `auth`, `stdlon`, `stmton`, `stauon`) VALUES ('".Std::cleanString($this->dt)."', ".(int)$this->level.", ".(is_object($this->player) ? $this->player->id : $this->player).", ".(int)$this->zlo.", ".(int)$this->online.", ".(int)$this->metro.", ".(int)$this->duels.", ".(int)$this->auth.", ".(double)$this->stdlon.", ".(double)$this->stmton.", ".(double)$this->stauon.")");
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
			case 'dt': return 9; break;
			case 'level': return 2; break;
			case 'player': return 13; break;
			case 'id': return 1; break;
			case 'zlo': return 2; break;
			case 'online': return 2; break;
			case 'metro': return 2; break;
			case 'duels': return 2; break;
			case 'auth': return 2; break;
			case 'stdlon': return 3; break;
			case 'stmton': return 3; break;
			case 'stauon': return 3; break;
    	}
    }
}
?>