<?php
class petBaseObject extends Object
{
	public static $METAOBJECT = 'pet';
    public $player = 0;
    public static $PLAYER = 'pet.player';
    public $name = '';
    public static $NAME = 'pet.name';
    public $image = '';
    public static $IMAGE = 'pet.image';
    public $info = '';
    public static $INFO = 'pet.info';
    public $procent = 0;
    public static $PROCENT = 'pet.procent';
    public $health = 0;
    public static $HEALTH = 'pet.health';
    public $strength = 0;
    public static $STRENGTH = 'pet.strength';
    public $dexterity = 0;
    public static $DEXTERITY = 'pet.dexterity';
    public $intuition = 0;
    public static $INTUITION = 'pet.intuition';
    public $resistance = 0;
    public static $RESISTANCE = 'pet.resistance';
    public $attention = 0;
    public static $ATTENTION = 'pet.attention';
    public $charism = 0;
    public static $CHARISM = 'pet.charism';
    public $hp = 0;
    public static $HP = 'pet.hp';
    public $maxhp = 0;
    public static $MAXHP = 'pet.maxhp';
    public $regen = 0;
    public static $REGEN = 'pet.regen';
    public $lastrecalc = 0;
    public static $LASTRECALC = 'pet.lastrecalc';
    public $item = 0;
    public static $ITEM = 'pet.item';
    public $wins = 0;
    public static $WINS = 'pet.wins';
    public $clan = 0;
    public static $CLAN = 'pet.clan';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'pet.dt';
    public $incage = 0;
    public static $INCAGE = 'pet.incage';
    public $healtime = 0;
    public static $HEALTIME = 'pet.healtime';
    public static $ID_METAATTRIBUTE = 'pet.id';
 	public static $ID = 'pet.id';
    public $level = 0;
    public static $LEVEL = 'pet.level';
    public $active = 0;
    public static $ACTIVE = 'pet.active';
    public $inprofile = 0;
    public static $INPROFILE = 'pet.inprofile';
    public $respawn_at = '0000-00-00 00:00:00';
    public static $RESPAWN_AT = 'pet.respawn_at';
    public $train_at = '0000-00-00 00:00:00';
    public static $TRAIN_AT = 'pet.train_at';
    public $lasttrainduration = 0;
    public static $LASTTRAINDURATION = 'pet.lasttrainduration';
    public $restores_today = 0;
    public static $RESTORES_TODAY = 'pet.restores_today';
    public $focus = 0;
    public static $FOCUS = 'pet.focus';
    public $loyality = 0;
    public static $LOYALITY = 'pet.loyality';
    public $mass = 0;
    public static $MASS = 'pet.mass';
    public $mood = 0;
    public static $MOOD = 'pet.mood';
    public $lastmooddt = 0;
    public static $LASTMOODDT = 'pet.lastmooddt';
    public $respawn_ups = 0;
    public static $RESPAWN_UPS = 'pet.respawn_ups';

    public function __construct()
    {
        parent::__construct('pet');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->name = '';
        $this->image = '';
        $this->info = '';
        $this->procent = 0;
        $this->health = 0;
        $this->strength = 0;
        $this->dexterity = 0;
        $this->intuition = 0;
        $this->resistance = 0;
        $this->attention = 0;
        $this->charism = 0;
        $this->hp = 0;
        $this->maxhp = 0;
        $this->regen = 0;
        $this->lastrecalc = 0;
        $this->item = 0;
        $this->wins = 0;
        $this->clan = 0;
        $this->dt = '0000-00-00 00:00:00';
        $this->incage = 0;
        $this->healtime = 0;
        $this->level = 0;
        $this->active = 0;
        $this->inprofile = 0;
        $this->respawn_at = '0000-00-00 00:00:00';
        $this->train_at = '0000-00-00 00:00:00';
        $this->lasttrainduration = 0;
        $this->restores_today = 0;
        $this->focus = 0;
        $this->loyality = 0;
        $this->mass = 0;
        $this->mood = 0;
        $this->lastmooddt = 0;
        $this->respawn_ups = 0;
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
        $this->name = $object['name'];
        $this->image = $object['image'];
        $this->info = $object['info'];
        $this->procent = $object['procent'];
        $this->health = $object['health'];
        $this->strength = $object['strength'];
        $this->dexterity = $object['dexterity'];
        $this->intuition = $object['intuition'];
        $this->resistance = $object['resistance'];
        $this->attention = $object['attention'];
        $this->charism = $object['charism'];
        $this->hp = $object['hp'];
        $this->maxhp = $object['maxhp'];
        $this->regen = $object['regen'];
        $this->lastrecalc = $object['lastrecalc'];
        $this->item = $object['item'];
        $this->wins = $object['wins'];
        $this->clan = $object['clan'];
        $this->dt = $object['dt'];
        $this->incage = $object['incage'];
        $this->healtime = $object['healtime'];
        $this->level = $object['level'];
        $this->active = $object['active'];
        $this->inprofile = $object['inprofile'];
        $this->respawn_at = $object['respawn_at'];
        $this->train_at = $object['train_at'];
        $this->lasttrainduration = $object['lasttrainduration'];
        $this->restores_today = $object['restores_today'];
        $this->focus = $object['focus'];
        $this->loyality = $object['loyality'];
        $this->mass = $object['mass'];
        $this->mood = $object['mood'];
        $this->lastmooddt = $object['lastmooddt'];
        $this->respawn_ups = $object['respawn_ups'];
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
            case 60:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->player = (int) $_POST['player'];
                $this->clan = (int) $_POST['clan'];
                $this->procent = (double) str_replace(',', '.', $_POST['procent']);
                $this->wins = (int) $_POST['wins'];
                $this->incage = isset($_POST['incage']) ? 1 : 0;
                $this->level = (int) $_POST['level'];
                $this->active = isset($_POST['active']) ? 1 : 0;
                $this->inprofile = isset($_POST['inprofile']) ? 1 : 0;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['respawn_at']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->respawn_at = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['train_at']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->train_at = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->lasttrainduration = (int) $_POST['lasttrainduration'];
                $this->restores_today = (int) $_POST['restores_today'];
                $this->focus = (int) $_POST['focus'];
                $this->loyality = (int) $_POST['loyality'];
                $this->mass = (int) $_POST['mass'];
                $this->mood = (int) $_POST['mood'];
                $this->lastmooddt = (int) $_POST['lastmooddt'];
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
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['name'] = $this->name;
        $object['image'] = $this->image;
        $object['info'] = $this->info;
        $object['procent'] = $this->procent;
        $object['health'] = $this->health;
        $object['strength'] = $this->strength;
        $object['dexterity'] = $this->dexterity;
        $object['intuition'] = $this->intuition;
        $object['resistance'] = $this->resistance;
        $object['attention'] = $this->attention;
        $object['charism'] = $this->charism;
        $object['hp'] = $this->hp;
        $object['maxhp'] = $this->maxhp;
        $object['regen'] = $this->regen;
        $object['lastrecalc'] = $this->lastrecalc;
        if (is_object($this->item))
        {
            $object['item'] = $this->item->toArray();
        }
        else
        {
        	$object['item'] = $this->item;
        }
        $object['wins'] = $this->wins;
        if (is_object($this->clan))
        {
            $object['clan'] = $this->clan->toArray();
        }
        else
        {
        	$object['clan'] = $this->clan;
        }
        $object['dt'] = $this->dt;
        $object['incage'] = $this->incage;
        $object['healtime'] = $this->healtime;
        $object['id'] = $this->id;
        $object['level'] = $this->level;
        $object['active'] = $this->active;
        $object['inprofile'] = $this->inprofile;
        $object['respawn_at'] = $this->respawn_at;
        $object['train_at'] = $this->train_at;
        $object['lasttrainduration'] = $this->lasttrainduration;
        $object['restores_today'] = $this->restores_today;
        $object['focus'] = $this->focus;
        $object['loyality'] = $this->loyality;
        $object['mass'] = $this->mass;
        $object['mood'] = $this->mood;
        $object['lastmooddt'] = $this->lastmooddt;
        $object['respawn_ups'] = $this->respawn_ups;
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
        if (is_object($this->item))
        {
            $this->item->save();
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
            		$field = str_replace('pet.', '', $field);
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
            	$this->sql->query("UPDATE `pet".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `pet".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `name`='".Std::cleanString($this->name)."', `image`='".Std::cleanString($this->image)."', `info`='".Std::cleanString($this->info)."', `procent`=".(double)$this->procent.", `health`=".(int)$this->health.", `strength`=".(int)$this->strength.", `dexterity`=".(int)$this->dexterity.", `intuition`=".(int)$this->intuition.", `resistance`=".(int)$this->resistance.", `attention`=".(int)$this->attention.", `charism`=".(int)$this->charism.", `hp`=".(int)$this->hp.", `maxhp`=".(int)$this->maxhp.", `regen`=".(int)$this->regen.", `lastrecalc`=".(int)$this->lastrecalc.", `item`=".(is_object($this->item) ? $this->item->id : $this->item).", `wins`=".(int)$this->wins.", `clan`=".(is_object($this->clan) ? $this->clan->id : $this->clan).", `dt`='".Std::cleanString($this->dt)."', `incage`=".(int)$this->incage.", `healtime`=".(int)$this->healtime.", `level`=".(int)$this->level.", `active`=".(int)$this->active.", `inprofile`=".(int)$this->inprofile.", `respawn_at`='".Std::cleanString($this->respawn_at)."', `train_at`='".Std::cleanString($this->train_at)."', `lasttrainduration`=".(int)$this->lasttrainduration.", `restores_today`=".(int)$this->restores_today.", `focus`=".(int)$this->focus.", `loyality`=".(int)$this->loyality.", `mass`=".(int)$this->mass.", `mood`=".(int)$this->mood.", `lastmooddt`=".(int)$this->lastmooddt.", `respawn_ups`=".(int)$this->respawn_ups." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `pet".$saveMerge."` (`player`, `name`, `image`, `info`, `procent`, `health`, `strength`, `dexterity`, `intuition`, `resistance`, `attention`, `charism`, `hp`, `maxhp`, `regen`, `lastrecalc`, `item`, `wins`, `clan`, `dt`, `incage`, `healtime`, `level`, `active`, `inprofile`, `respawn_at`, `train_at`, `lasttrainduration`, `restores_today`, `focus`, `loyality`, `mass`, `mood`, `lastmooddt`, `respawn_ups`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->name)."', '".Std::cleanString($this->image)."', '".Std::cleanString($this->info)."', ".(double)$this->procent.", ".(int)$this->health.", ".(int)$this->strength.", ".(int)$this->dexterity.", ".(int)$this->intuition.", ".(int)$this->resistance.", ".(int)$this->attention.", ".(int)$this->charism.", ".(int)$this->hp.", ".(int)$this->maxhp.", ".(int)$this->regen.", ".(int)$this->lastrecalc.", ".(is_object($this->item) ? $this->item->id : $this->item).", ".(int)$this->wins.", ".(is_object($this->clan) ? $this->clan->id : $this->clan).", '".Std::cleanString($this->dt)."', ".(int)$this->incage.", ".(int)$this->healtime.", ".(int)$this->level.", ".(int)$this->active.", ".(int)$this->inprofile.", '".Std::cleanString($this->respawn_at)."', '".Std::cleanString($this->train_at)."', ".(int)$this->lasttrainduration.", ".(int)$this->restores_today.", ".(int)$this->focus.", ".(int)$this->loyality.", ".(int)$this->mass.", ".(int)$this->mood.", ".(int)$this->lastmooddt.", ".(int)$this->respawn_ups.")");
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
			case 'name': return 4; break;
			case 'image': return 4; break;
			case 'info': return 5; break;
			case 'procent': return 3; break;
			case 'health': return 2; break;
			case 'strength': return 2; break;
			case 'dexterity': return 2; break;
			case 'intuition': return 2; break;
			case 'resistance': return 2; break;
			case 'attention': return 2; break;
			case 'charism': return 2; break;
			case 'hp': return 2; break;
			case 'maxhp': return 2; break;
			case 'regen': return 2; break;
			case 'lastrecalc': return 2; break;
			case 'item': return 13; break;
			case 'wins': return 2; break;
			case 'clan': return 13; break;
			case 'dt': return 8; break;
			case 'incage': return 10; break;
			case 'healtime': return 2; break;
			case 'id': return 1; break;
			case 'level': return 2; break;
			case 'active': return 10; break;
			case 'inprofile': return 10; break;
			case 'respawn_at': return 8; break;
			case 'train_at': return 8; break;
			case 'lasttrainduration': return 2; break;
			case 'restores_today': return 2; break;
			case 'focus': return 2; break;
			case 'loyality': return 2; break;
			case 'mass': return 2; break;
			case 'mood': return 2; break;
			case 'lastmooddt': return 2; break;
			case 'respawn_ups': return 2; break;
    	}
    }
}
?>