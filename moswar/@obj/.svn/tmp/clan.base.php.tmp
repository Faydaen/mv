<?php
class clanBaseObject extends Object
{
	public static $METAOBJECT = 'clan';
    public static $ID_METAATTRIBUTE = 'clan.id';
 	public static $ID = 'clan.id';
    public $name = '';
    public static $NAME = 'clan.name';
    public $fraction = '';
    public $fraction_Dictionary = array('resident','arrived');
    public static $FRACTION = 'clan.fraction';
    public $ico = 0;
    public static $ICO = 'clan.ico';
    public $logo = 0;
    public static $LOGO = 'clan.logo';
    public $founder = 0;
    public static $FOUNDER = 'clan.founder';
    public $site = '';
    public static $SITE = 'clan.site';
    public $slogan = '';
    public static $SLOGAN = 'clan.slogan';
    public $money = 0;
    public static $MONEY = 'clan.money';
    public $honey = 0;
    public static $HONEY = 'clan.honey';
    public $ore = 0;
    public static $ORE = 'clan.ore';
    public $rmoney = 0;
    public static $RMONEY = 'clan.rmoney';
    public $rhoney = 0;
    public static $RHONEY = 'clan.rhoney';
    public $rore = 0;
    public static $RORE = 'clan.rore';
    public $defence = 0;
    public static $DEFENCE = 'clan.defence';
    public $attack = 0;
    public static $ATTACK = 'clan.attack';
    public $info = '';
    public static $INFO = 'clan.info';
    public $accesslevel = 0;
    public static $ACCESSLEVEL = 'clan.accesslevel';
    public $maxpeople = 0;
    public static $MAXPEOPLE = 'clan.maxpeople';
    public $data = '';
    public static $DATA = 'clan.data';
    public $points = 0;
    public static $POINTS = 'clan.points';
    public $level = 0;
    public static $LEVEL = 'clan.level';
    public $regdt = '0000-00-00 00:00:00';
    public static $REGDT = 'clan.regdt';
    public $attackdt = '0000-00-00 00:00:00';
    public static $ATTACKDT = 'clan.attackdt';
    public $defencedt = '0000-00-00 00:00:00';
    public static $DEFENCEDT = 'clan.defencedt';
    public $lastrestdt = '0000-00-00 00:00:00';
    public static $LASTRESTDT = 'clan.lastrestdt';
    public $state = '';
    public $state_Dictionary = array('war','rest');
    public static $STATE = 'clan.state';
    public $lastdecrease = '0000-00-00 00:00:00';
    public static $LASTDECREASE = 'clan.lastdecrease';

    public function __construct()
    {
        parent::__construct('clan');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->fraction = '';
        $this->ico = 0;
        $this->logo = 0;
        $this->founder = 0;
        $this->site = '';
        $this->slogan = '';
        $this->money = 0;
        $this->honey = 0;
        $this->ore = 0;
        $this->rmoney = 0;
        $this->rhoney = 0;
        $this->rore = 0;
        $this->defence = 0;
        $this->attack = 0;
        $this->info = '';
        $this->accesslevel = 0;
        $this->maxpeople = 0;
        $this->data = '';
        $this->points = 0;
        $this->level = 0;
        $this->regdt = '0000-00-00 00:00:00';
        $this->attackdt = '0000-00-00 00:00:00';
        $this->defencedt = '0000-00-00 00:00:00';
        $this->lastrestdt = '0000-00-00 00:00:00';
        $this->state = '';
        $this->lastdecrease = '0000-00-00 00:00:00';
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
        $this->fraction = $object['fraction'];
        $this->ico = $object['ico'];
        $this->logo = $object['logo'];
        $this->founder = $object['founder'];
        $this->site = $object['site'];
        $this->slogan = $object['slogan'];
        $this->money = $object['money'];
        $this->honey = $object['honey'];
        $this->ore = $object['ore'];
        $this->rmoney = $object['rmoney'];
        $this->rhoney = $object['rhoney'];
        $this->rore = $object['rore'];
        $this->defence = $object['defence'];
        $this->attack = $object['attack'];
        $this->info = $object['info'];
        $this->accesslevel = $object['accesslevel'];
        $this->maxpeople = $object['maxpeople'];
        $this->data = $object['data'];
        $this->points = $object['points'];
        $this->level = $object['level'];
        $this->regdt = $object['regdt'];
        $this->attackdt = $object['attackdt'];
        $this->defencedt = $object['defencedt'];
        $this->lastrestdt = $object['lastrestdt'];
        $this->state = $object['state'];
        $this->lastdecrease = $object['lastdecrease'];
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
            case 78:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->fraction = $_POST['fraction'];
                if ($this->id)
                {
                    $imageId = $this->sql->getValue("SELECT `ico` FROM `clan` WHERE id=".$this->id);
                }
                else
                {
                    $imageId = 0;
                }
                if (isset($_FILES['ico']) && $_FILES['ico']['name'] != '')
                {
                    $this->ico = $this->uploadImage('ico', $imageId);
                }
                elseif ($imageId && isset($_POST['ico-delete']))
                {
                    $this->deleteImage($imageId);
                    $this->ico = 0;
                }
                else
                {
                    $this->ico = $imageId;
                }
                if ($this->id)
                {
                    $imageId = $this->sql->getValue("SELECT `logo` FROM `clan` WHERE id=".$this->id);
                }
                else
                {
                    $imageId = 0;
                }
                if (isset($_FILES['logo']) && $_FILES['logo']['name'] != '')
                {
                    $this->logo = $this->uploadImage('logo', $imageId);
                }
                elseif ($imageId && isset($_POST['logo-delete']))
                {
                    $this->deleteImage($imageId);
                    $this->logo = 0;
                }
                else
                {
                    $this->logo = $imageId;
                }
                $this->founder = (int) $_POST['founder'];
                $this->info = $_POST['info'];
                $this->money = (int) $_POST['money'];
                $this->honey = (int) $_POST['honey'];
                $this->ore = (int) $_POST['ore'];
                $this->rmoney = (int) $_POST['rmoney'];
                $this->rhoney = (int) $_POST['rhoney'];
                $this->rore = (int) $_POST['rore'];
                $this->defence = (int) $_POST['defence'];
                $this->attack = (int) $_POST['attack'];
                $this->accesslevel = (int) $_POST['accesslevel'];
                $this->maxpeople = (int) $_POST['maxpeople'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['regdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->regdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['attackdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->attackdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['defencedt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->defencedt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['lastrestdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->lastrestdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->state = $_POST['state'];
                $this->level = (int) $_POST['level'];
                $this->points = (int) $_POST['points'];
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
        $object['fraction'] = $this->fraction;
        $object['ico'] = $this->ico;
        $object['logo'] = $this->logo;
        if (is_object($this->founder))
        {
            $object['founder'] = $this->founder->toArray();
        }
        else
        {
        	$object['founder'] = $this->founder;
        }
        $object['site'] = $this->site;
        $object['slogan'] = $this->slogan;
        $object['money'] = $this->money;
        $object['honey'] = $this->honey;
        $object['ore'] = $this->ore;
        $object['rmoney'] = $this->rmoney;
        $object['rhoney'] = $this->rhoney;
        $object['rore'] = $this->rore;
        $object['defence'] = $this->defence;
        $object['attack'] = $this->attack;
        $object['info'] = $this->info;
        $object['accesslevel'] = $this->accesslevel;
        $object['maxpeople'] = $this->maxpeople;
        $object['data'] = $this->data;
        $object['points'] = $this->points;
        $object['level'] = $this->level;
        $object['regdt'] = $this->regdt;
        $object['attackdt'] = $this->attackdt;
        $object['defencedt'] = $this->defencedt;
        $object['lastrestdt'] = $this->lastrestdt;
        $object['state'] = $this->state;
        $object['lastdecrease'] = $this->lastdecrease;
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
        if (is_object($this->founder))
        {
            $this->founder->save();
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
            		$field = str_replace('clan.', '', $field);
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
            	$this->sql->query("UPDATE `clan".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `clan".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `fraction`='".Std::cleanString($this->fraction)."', `ico`=".(int)$this->ico.", `logo`=".(int)$this->logo.", `founder`=".(is_object($this->founder) ? $this->founder->id : $this->founder).", `site`='".Std::cleanString($this->site)."', `slogan`='".Std::cleanString($this->slogan)."', `money`=".(int)$this->money.", `honey`=".(int)$this->honey.", `ore`=".(int)$this->ore.", `rmoney`=".(int)$this->rmoney.", `rhoney`=".(int)$this->rhoney.", `rore`=".(int)$this->rore.", `defence`=".(int)$this->defence.", `attack`=".(int)$this->attack.", `info`='".Std::cleanString($this->info)."', `accesslevel`=".(int)$this->accesslevel.", `maxpeople`=".(int)$this->maxpeople.", `data`='".Std::cleanString($this->data)."', `points`=".(int)$this->points.", `level`=".(int)$this->level.", `regdt`='".Std::cleanString($this->regdt)."', `attackdt`='".Std::cleanString($this->attackdt)."', `defencedt`='".Std::cleanString($this->defencedt)."', `lastrestdt`='".Std::cleanString($this->lastrestdt)."', `state`='".Std::cleanString($this->state)."', `lastdecrease`='".Std::cleanString($this->lastdecrease)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `clan".$saveMerge."` (`name`, `fraction`, `ico`, `logo`, `founder`, `site`, `slogan`, `money`, `honey`, `ore`, `rmoney`, `rhoney`, `rore`, `defence`, `attack`, `info`, `accesslevel`, `maxpeople`, `data`, `points`, `level`, `regdt`, `attackdt`, `defencedt`, `lastrestdt`, `state`, `lastdecrease`) VALUES ('".Std::cleanString($this->name)."', '".Std::cleanString($this->fraction)."', ".(int)$this->ico.", ".(int)$this->logo.", ".(is_object($this->founder) ? $this->founder->id : $this->founder).", '".Std::cleanString($this->site)."', '".Std::cleanString($this->slogan)."', ".(int)$this->money.", ".(int)$this->honey.", ".(int)$this->ore.", ".(int)$this->rmoney.", ".(int)$this->rhoney.", ".(int)$this->rore.", ".(int)$this->defence.", ".(int)$this->attack.", '".Std::cleanString($this->info)."', ".(int)$this->accesslevel.", ".(int)$this->maxpeople.", '".Std::cleanString($this->data)."', ".(int)$this->points.", ".(int)$this->level.", '".Std::cleanString($this->regdt)."', '".Std::cleanString($this->attackdt)."', '".Std::cleanString($this->defencedt)."', '".Std::cleanString($this->lastrestdt)."', '".Std::cleanString($this->state)."', '".Std::cleanString($this->lastdecrease)."')");
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
			case 'fraction': return 15; break;
			case 'ico': return 12; break;
			case 'logo': return 12; break;
			case 'founder': return 13; break;
			case 'site': return 4; break;
			case 'slogan': return 4; break;
			case 'money': return 2; break;
			case 'honey': return 2; break;
			case 'ore': return 2; break;
			case 'rmoney': return 2; break;
			case 'rhoney': return 2; break;
			case 'rore': return 2; break;
			case 'defence': return 2; break;
			case 'attack': return 2; break;
			case 'info': return 5; break;
			case 'accesslevel': return 2; break;
			case 'maxpeople': return 2; break;
			case 'data': return 6; break;
			case 'points': return 2; break;
			case 'level': return 2; break;
			case 'regdt': return 8; break;
			case 'attackdt': return 8; break;
			case 'defencedt': return 8; break;
			case 'lastrestdt': return 8; break;
			case 'state': return 15; break;
			case 'lastdecrease': return 8; break;
    	}
    }
}
?>