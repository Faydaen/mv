<?php
class playerboost2BaseObject extends Object
{
	public static $METAOBJECT = 'playerboost2';
    public $standard_item = 0;
    public static $STANDARD_ITEM = 'playerboost2.standard_item';
    public static $ID_METAATTRIBUTE = 'playerboost2.player';
    public $player = 0;
    public static $PLAYER = 'playerboost2.player';
    public $type = '';
    public static $TYPE = 'playerboost2.type';
    public $code = '';
    public static $CODE = 'playerboost2.code';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'playerboost2.dt';
    public $dt2 = '0000-00-00 00:00:00';
    public static $DT2 = 'playerboost2.dt2';
    public $health = 0;
    public static $HEALTH = 'playerboost2.health';
    public $strength = 0;
    public static $STRENGTH = 'playerboost2.strength';
    public $dexterity = 0;
    public static $DEXTERITY = 'playerboost2.dexterity';
    public $intuition = 0;
    public static $INTUITION = 'playerboost2.intuition';
    public $resistance = 0;
    public static $RESISTANCE = 'playerboost2.resistance';
    public $attention = 0;
    public static $ATTENTION = 'playerboost2.attention';
    public $charism = 0;
    public static $CHARISM = 'playerboost2.charism';
    public $ratingcrit = 0;
    public static $RATINGCRIT = 'playerboost2.ratingcrit';
    public $ratingdodge = 0;
    public static $RATINGDODGE = 'playerboost2.ratingdodge';
    public $ratingresist = 0;
    public static $RATINGRESIST = 'playerboost2.ratingresist';
    public $ratinganticrit = 0;
    public static $RATINGANTICRIT = 'playerboost2.ratinganticrit';
    public $ratingdamage = 0;
    public static $RATINGDAMAGE = 'playerboost2.ratingdamage';
    public $ratingaccur = 0;
    public static $RATINGACCUR = 'playerboost2.ratingaccur';
    public $subtype = '';
    public $subtype_Dictionary = array('award');
    public static $SUBTYPE = 'playerboost2.subtype';
    public $percent_dmg = 0;
    public static $PERCENT_DMG = 'playerboost2.percent_dmg';
    public $percent_defence = 0;
    public static $PERCENT_DEFENCE = 'playerboost2.percent_defence';
    public $percent_hit = 0;
    public static $PERCENT_HIT = 'playerboost2.percent_hit';
    public $percent_dodge = 0;
    public static $PERCENT_DODGE = 'playerboost2.percent_dodge';
    public $percent_crit = 0;
    public static $PERCENT_CRIT = 'playerboost2.percent_crit';
    public $percent_anticrit = 0;
    public static $PERCENT_ANTICRIT = 'playerboost2.percent_anticrit';

    public function __construct()
    {
        parent::__construct('playerboost2');
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
        $this->type = '';
        $this->code = '';
        $this->dt = '0000-00-00 00:00:00';
        $this->dt2 = '0000-00-00 00:00:00';
        $this->health = 0;
        $this->strength = 0;
        $this->dexterity = 0;
        $this->intuition = 0;
        $this->resistance = 0;
        $this->attention = 0;
        $this->charism = 0;
        $this->ratingcrit = 0;
        $this->ratingdodge = 0;
        $this->ratingresist = 0;
        $this->ratinganticrit = 0;
        $this->ratingdamage = 0;
        $this->ratingaccur = 0;
        $this->subtype = '';
        $this->percent_dmg = 0;
        $this->percent_defence = 0;
        $this->percent_hit = 0;
        $this->percent_dodge = 0;
        $this->percent_crit = 0;
        $this->percent_anticrit = 0;
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
        $this->type = $object['type'];
        $this->code = $object['code'];
        $this->dt = $object['dt'];
        $this->dt2 = $object['dt2'];
        $this->health = $object['health'];
        $this->strength = $object['strength'];
        $this->dexterity = $object['dexterity'];
        $this->intuition = $object['intuition'];
        $this->resistance = $object['resistance'];
        $this->attention = $object['attention'];
        $this->charism = $object['charism'];
        $this->ratingcrit = $object['ratingcrit'];
        $this->ratingdodge = $object['ratingdodge'];
        $this->ratingresist = $object['ratingresist'];
        $this->ratinganticrit = $object['ratinganticrit'];
        $this->ratingdamage = $object['ratingdamage'];
        $this->ratingaccur = $object['ratingaccur'];
        $this->subtype = $object['subtype'];
        $this->percent_dmg = $object['percent_dmg'];
        $this->percent_defence = $object['percent_defence'];
        $this->percent_hit = $object['percent_hit'];
        $this->percent_dodge = $object['percent_dodge'];
        $this->percent_crit = $object['percent_crit'];
        $this->percent_anticrit = $object['percent_anticrit'];
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
            case 99:
                $this->player = (int) $_POST['player'];
                $this->type = str_replace('"', '&quot;', $_POST['type']);
                $this->standard_item = (int) $_POST['standard_item'];
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
                $this->health = (double) str_replace(',', '.', $_POST['health']);
                $this->strength = (double) str_replace(',', '.', $_POST['strength']);
                $this->dexterity = (double) str_replace(',', '.', $_POST['dexterity']);
                $this->resistance = (double) str_replace(',', '.', $_POST['resistance']);
                $this->intuition = (double) str_replace(',', '.', $_POST['intuition']);
                $this->attention = (double) str_replace(',', '.', $_POST['attention']);
                $this->charism = (double) str_replace(',', '.', $_POST['charism']);
                $this->ratingcrit = (double) str_replace(',', '.', $_POST['ratingcrit']);
                $this->ratingdodge = (double) str_replace(',', '.', $_POST['ratingdodge']);
                $this->ratingresist = (double) str_replace(',', '.', $_POST['ratingresist']);
                $this->ratinganticrit = (double) str_replace(',', '.', $_POST['ratinganticrit']);
                $this->ratingdamage = (double) str_replace(',', '.', $_POST['ratingdamage']);
                $this->ratingaccur = (double) str_replace(',', '.', $_POST['ratingaccur']);
                $this->subtype = $_POST['subtype'];
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
        $object['type'] = $this->type;
        $object['code'] = $this->code;
        $object['dt'] = $this->dt;
        $object['dt2'] = $this->dt2;
        $object['health'] = $this->health;
        $object['strength'] = $this->strength;
        $object['dexterity'] = $this->dexterity;
        $object['intuition'] = $this->intuition;
        $object['resistance'] = $this->resistance;
        $object['attention'] = $this->attention;
        $object['charism'] = $this->charism;
        $object['ratingcrit'] = $this->ratingcrit;
        $object['ratingdodge'] = $this->ratingdodge;
        $object['ratingresist'] = $this->ratingresist;
        $object['ratinganticrit'] = $this->ratinganticrit;
        $object['ratingdamage'] = $this->ratingdamage;
        $object['ratingaccur'] = $this->ratingaccur;
        $object['subtype'] = $this->subtype;
        $object['percent_dmg'] = $this->percent_dmg;
        $object['percent_defence'] = $this->percent_defence;
        $object['percent_hit'] = $this->percent_hit;
        $object['percent_dodge'] = $this->percent_dodge;
        $object['percent_crit'] = $this->percent_crit;
        $object['percent_anticrit'] = $this->percent_anticrit;
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
            		$field = str_replace('playerboost2.', '', $field);
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
            	$this->sql->query("UPDATE `playerboost2".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `playerboost2".$saveMerge."` SET `standard_item`=".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `type`='".Std::cleanString($this->type)."', `code`='".Std::cleanString($this->code)."', `dt`='".Std::cleanString($this->dt)."', `dt2`='".Std::cleanString($this->dt2)."', `health`=".(double)$this->health.", `strength`=".(double)$this->strength.", `dexterity`=".(double)$this->dexterity.", `intuition`=".(double)$this->intuition.", `resistance`=".(double)$this->resistance.", `attention`=".(double)$this->attention.", `charism`=".(double)$this->charism.", `ratingcrit`=".(double)$this->ratingcrit.", `ratingdodge`=".(double)$this->ratingdodge.", `ratingresist`=".(double)$this->ratingresist.", `ratinganticrit`=".(double)$this->ratinganticrit.", `ratingdamage`=".(double)$this->ratingdamage.", `ratingaccur`=".(double)$this->ratingaccur.", `subtype`='".Std::cleanString($this->subtype)."', `percent_dmg`=".(double)$this->percent_dmg.", `percent_defence`=".(double)$this->percent_defence.", `percent_hit`=".(double)$this->percent_hit.", `percent_dodge`=".(double)$this->percent_dodge.", `percent_crit`=".(double)$this->percent_crit.", `percent_anticrit`=".(double)$this->percent_anticrit." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `playerboost2".$saveMerge."` (`standard_item`, `player`, `type`, `code`, `dt`, `dt2`, `health`, `strength`, `dexterity`, `intuition`, `resistance`, `attention`, `charism`, `ratingcrit`, `ratingdodge`, `ratingresist`, `ratinganticrit`, `ratingdamage`, `ratingaccur`, `subtype`, `percent_dmg`, `percent_defence`, `percent_hit`, `percent_dodge`, `percent_crit`, `percent_anticrit`) VALUES (".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", ".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->type)."', '".Std::cleanString($this->code)."', '".Std::cleanString($this->dt)."', '".Std::cleanString($this->dt2)."', ".(double)$this->health.", ".(double)$this->strength.", ".(double)$this->dexterity.", ".(double)$this->intuition.", ".(double)$this->resistance.", ".(double)$this->attention.", ".(double)$this->charism.", ".(double)$this->ratingcrit.", ".(double)$this->ratingdodge.", ".(double)$this->ratingresist.", ".(double)$this->ratinganticrit.", ".(double)$this->ratingdamage.", ".(double)$this->ratingaccur.", '".Std::cleanString($this->subtype)."', ".(double)$this->percent_dmg.", ".(double)$this->percent_defence.", ".(double)$this->percent_hit.", ".(double)$this->percent_dodge.", ".(double)$this->percent_crit.", ".(double)$this->percent_anticrit.")");
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
			case 'standard_item': return 13; break;
			case 'player': return 13; break;
			case 'type': return 4; break;
			case 'code': return 4; break;
			case 'dt': return 8; break;
			case 'dt2': return 8; break;
			case 'health': return 3; break;
			case 'strength': return 3; break;
			case 'dexterity': return 3; break;
			case 'intuition': return 3; break;
			case 'resistance': return 3; break;
			case 'attention': return 3; break;
			case 'charism': return 3; break;
			case 'ratingcrit': return 3; break;
			case 'ratingdodge': return 3; break;
			case 'ratingresist': return 3; break;
			case 'ratinganticrit': return 3; break;
			case 'ratingdamage': return 3; break;
			case 'ratingaccur': return 3; break;
			case 'subtype': return 15; break;
			case 'percent_dmg': return 3; break;
			case 'percent_defence': return 3; break;
			case 'percent_hit': return 3; break;
			case 'percent_dodge': return 3; break;
			case 'percent_crit': return 3; break;
			case 'percent_anticrit': return 3; break;
    	}
    }
}
?>