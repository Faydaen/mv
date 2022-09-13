<?php
class rating_playerBaseObject extends Object
{
	public static $METAOBJECT = 'rating_player';
    public static $ID_METAATTRIBUTE = 'rating_player.player';
    public $player = 0;
    public static $PLAYER = 'rating_player.player';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident');
    public static $FRACTION = 'rating_player.fraction';
    public $moneygrabbed = 0;
    public static $MONEYGRABBED = 'rating_player.moneygrabbed';
    public $moneylost = 0;
    public static $MONEYLOST = 'rating_player.moneylost';
    public $wins = 0;
    public static $WINS = 'rating_player.wins';
    public $referers = 0;
    public static $REFERERS = 'rating_player.referers';
    public $lastupdate = 0;
    public static $LASTUPDATE = 'rating_player.lastupdate';
    public $visible = 0;
    public static $VISIBLE = 'rating_player.visible';
    public $level = 0;
    public static $LEVEL = 'rating_player.level';
    public $moneygrabbed_day = 0;
    public static $MONEYGRABBED_DAY = 'rating_player.moneygrabbed_day';
    public $moneylost_day = 0;
    public static $MONEYLOST_DAY = 'rating_player.moneylost_day';
    public $wins_day = 0;
    public static $WINS_DAY = 'rating_player.wins_day';
    public $moneygrabbed_week = 0;
    public static $MONEYGRABBED_WEEK = 'rating_player.moneygrabbed_week';
    public $moneylost_week = 0;
    public static $MONEYLOST_WEEK = 'rating_player.moneylost_week';
    public $wins_week = 0;
    public static $WINS_WEEK = 'rating_player.wins_week';
    public $moneygrabbed_month = 0;
    public static $MONEYGRABBED_MONTH = 'rating_player.moneygrabbed_month';
    public $moneylost_month = 0;
    public static $MONEYLOST_MONTH = 'rating_player.moneylost_month';
    public $wins_month = 0;
    public static $WINS_MONTH = 'rating_player.wins_month';
    public $huntkills = 0;
    public static $HUNTKILLS = 'rating_player.huntkills';
    public $huntkills_day = 0;
    public static $HUNTKILLS_DAY = 'rating_player.huntkills_day';
    public $huntkills_week = 0;
    public static $HUNTKILLS_WEEK = 'rating_player.huntkills_week';
    public $huntkills_month = 0;
    public static $HUNTKILLS_MONTH = 'rating_player.huntkills_month';
    public $huntaward = 0;
    public static $HUNTAWARD = 'rating_player.huntaward';
    public $huntaward_day = 0;
    public static $HUNTAWARD_DAY = 'rating_player.huntaward_day';
    public $huntaward_week = 0;
    public static $HUNTAWARD_WEEK = 'rating_player.huntaward_week';
    public $huntaward_month = 0;
    public static $HUNTAWARD_MONTH = 'rating_player.huntaward_month';

    public function __construct()
    {
        parent::__construct('rating_player');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->fraction = '';
        $this->moneygrabbed = 0;
        $this->moneylost = 0;
        $this->wins = 0;
        $this->referers = 0;
        $this->lastupdate = 0;
        $this->visible = 0;
        $this->level = 0;
        $this->moneygrabbed_day = 0;
        $this->moneylost_day = 0;
        $this->wins_day = 0;
        $this->moneygrabbed_week = 0;
        $this->moneylost_week = 0;
        $this->wins_week = 0;
        $this->moneygrabbed_month = 0;
        $this->moneylost_month = 0;
        $this->wins_month = 0;
        $this->huntkills = 0;
        $this->huntkills_day = 0;
        $this->huntkills_week = 0;
        $this->huntkills_month = 0;
        $this->huntaward = 0;
        $this->huntaward_day = 0;
        $this->huntaward_week = 0;
        $this->huntaward_month = 0;
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
        $this->fraction = $object['fraction'];
        $this->moneygrabbed = $object['moneygrabbed'];
        $this->moneylost = $object['moneylost'];
        $this->wins = $object['wins'];
        $this->referers = $object['referers'];
        $this->lastupdate = $object['lastupdate'];
        $this->visible = $object['visible'];
        $this->level = $object['level'];
        $this->moneygrabbed_day = $object['moneygrabbed_day'];
        $this->moneylost_day = $object['moneylost_day'];
        $this->wins_day = $object['wins_day'];
        $this->moneygrabbed_week = $object['moneygrabbed_week'];
        $this->moneylost_week = $object['moneylost_week'];
        $this->wins_week = $object['wins_week'];
        $this->moneygrabbed_month = $object['moneygrabbed_month'];
        $this->moneylost_month = $object['moneylost_month'];
        $this->wins_month = $object['wins_month'];
        $this->huntkills = $object['huntkills'];
        $this->huntkills_day = $object['huntkills_day'];
        $this->huntkills_week = $object['huntkills_week'];
        $this->huntkills_month = $object['huntkills_month'];
        $this->huntaward = $object['huntaward'];
        $this->huntaward_day = $object['huntaward_day'];
        $this->huntaward_week = $object['huntaward_week'];
        $this->huntaward_month = $object['huntaward_month'];
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
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['fraction'] = $this->fraction;
        $object['moneygrabbed'] = $this->moneygrabbed;
        $object['moneylost'] = $this->moneylost;
        $object['wins'] = $this->wins;
        $object['referers'] = $this->referers;
        $object['lastupdate'] = $this->lastupdate;
        $object['visible'] = $this->visible;
        $object['level'] = $this->level;
        $object['moneygrabbed_day'] = $this->moneygrabbed_day;
        $object['moneylost_day'] = $this->moneylost_day;
        $object['wins_day'] = $this->wins_day;
        $object['moneygrabbed_week'] = $this->moneygrabbed_week;
        $object['moneylost_week'] = $this->moneylost_week;
        $object['wins_week'] = $this->wins_week;
        $object['moneygrabbed_month'] = $this->moneygrabbed_month;
        $object['moneylost_month'] = $this->moneylost_month;
        $object['wins_month'] = $this->wins_month;
        $object['huntkills'] = $this->huntkills;
        $object['huntkills_day'] = $this->huntkills_day;
        $object['huntkills_week'] = $this->huntkills_week;
        $object['huntkills_month'] = $this->huntkills_month;
        $object['huntaward'] = $this->huntaward;
        $object['huntaward_day'] = $this->huntaward_day;
        $object['huntaward_week'] = $this->huntaward_week;
        $object['huntaward_month'] = $this->huntaward_month;
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
            		$field = str_replace('rating_player.', '', $field);
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
            	$this->sql->query("UPDATE `rating_player".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `rating_player".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `fraction`='".Std::cleanString($this->fraction)."', `moneygrabbed`=".(int)$this->moneygrabbed.", `moneylost`=".(int)$this->moneylost.", `wins`=".(int)$this->wins.", `referers`=".(int)$this->referers.", `lastupdate`=".(int)$this->lastupdate.", `visible`=".(int)$this->visible.", `level`=".(int)$this->level.", `moneygrabbed_day`=".(int)$this->moneygrabbed_day.", `moneylost_day`=".(int)$this->moneylost_day.", `wins_day`=".(int)$this->wins_day.", `moneygrabbed_week`=".(int)$this->moneygrabbed_week.", `moneylost_week`=".(int)$this->moneylost_week.", `wins_week`=".(int)$this->wins_week.", `moneygrabbed_month`=".(int)$this->moneygrabbed_month.", `moneylost_month`=".(int)$this->moneylost_month.", `wins_month`=".(int)$this->wins_month.", `huntkills`=".(int)$this->huntkills.", `huntkills_day`=".(int)$this->huntkills_day.", `huntkills_week`=".(int)$this->huntkills_week.", `huntkills_month`=".(int)$this->huntkills_month.", `huntaward`=".(int)$this->huntaward.", `huntaward_day`=".(int)$this->huntaward_day.", `huntaward_week`=".(int)$this->huntaward_week.", `huntaward_month`=".(int)$this->huntaward_month." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `rating_player".$saveMerge."` (`player`, `fraction`, `moneygrabbed`, `moneylost`, `wins`, `referers`, `lastupdate`, `visible`, `level`, `moneygrabbed_day`, `moneylost_day`, `wins_day`, `moneygrabbed_week`, `moneylost_week`, `wins_week`, `moneygrabbed_month`, `moneylost_month`, `wins_month`, `huntkills`, `huntkills_day`, `huntkills_week`, `huntkills_month`, `huntaward`, `huntaward_day`, `huntaward_week`, `huntaward_month`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->fraction)."', ".(int)$this->moneygrabbed.", ".(int)$this->moneylost.", ".(int)$this->wins.", ".(int)$this->referers.", ".(int)$this->lastupdate.", ".(int)$this->visible.", ".(int)$this->level.", ".(int)$this->moneygrabbed_day.", ".(int)$this->moneylost_day.", ".(int)$this->wins_day.", ".(int)$this->moneygrabbed_week.", ".(int)$this->moneylost_week.", ".(int)$this->wins_week.", ".(int)$this->moneygrabbed_month.", ".(int)$this->moneylost_month.", ".(int)$this->wins_month.", ".(int)$this->huntkills.", ".(int)$this->huntkills_day.", ".(int)$this->huntkills_week.", ".(int)$this->huntkills_month.", ".(int)$this->huntaward.", ".(int)$this->huntaward_day.", ".(int)$this->huntaward_week.", ".(int)$this->huntaward_month.")");
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
			case 'player': return 13; break;
			case 'fraction': return 15; break;
			case 'moneygrabbed': return 2; break;
			case 'moneylost': return 2; break;
			case 'wins': return 2; break;
			case 'referers': return 2; break;
			case 'lastupdate': return 2; break;
			case 'visible': return 2; break;
			case 'level': return 2; break;
			case 'moneygrabbed_day': return 2; break;
			case 'moneylost_day': return 2; break;
			case 'wins_day': return 2; break;
			case 'moneygrabbed_week': return 2; break;
			case 'moneylost_week': return 2; break;
			case 'wins_week': return 2; break;
			case 'moneygrabbed_month': return 2; break;
			case 'moneylost_month': return 2; break;
			case 'wins_month': return 2; break;
			case 'huntkills': return 2; break;
			case 'huntkills_day': return 2; break;
			case 'huntkills_week': return 2; break;
			case 'huntkills_month': return 2; break;
			case 'huntaward': return 2; break;
			case 'huntaward_day': return 2; break;
			case 'huntaward_week': return 2; break;
			case 'huntaward_month': return 2; break;
    	}
    }
}
?>