<?php
class inventoryBaseObject extends Object
{
	public static $METAOBJECT = 'inventory';
    public static $ID_METAATTRIBUTE = 'inventory.id';
 	public static $ID = 'inventory.id';
    public $name = '';
    public static $NAME = 'inventory.name';
    public $standard_item = 0;
    public static $STANDARD_ITEM = 'inventory.standard_item';
    public $player = 0;
    public static $PLAYER = 'inventory.player';
    public $durability = 0;
    public static $DURABILITY = 'inventory.durability';
    public $maxdurability = 0;
    public static $MAXDURABILITY = 'inventory.maxdurability';
    public $image = '';
    public static $IMAGE = 'inventory.image';
    public $slot = '';
    public $slot_Dictionary = array('weapon','pouch','cloth','cologne','talisman','home','accessory1','accessory2','accessory3','accessory4','accessory5','hat','jewellery','tech','shoe');
    public static $SLOT = 'inventory.slot';
    public $type = '';
    public $type_Dictionary = array('weapon','pouch','cloth','cologne','talisman','accessory1','accessory2','accessory3','accessory4','accessory5','home_comfort','home_defence','home_safe','pick','metro','pet','drug','gift','petfood','hat','jewellery','tech','shoe','petautofood','quest','usableitem','docs','drug2','gift2','home','autousableitem');
    public static $TYPE = 'inventory.type';
    public $equipped = 0;
    public static $EQUIPPED = 'inventory.equipped';
    public $itemlevel = 0;
    public static $ITEMLEVEL = 'inventory.itemlevel';
    public $upgradable = 0;
    public static $UPGRADABLE = 'inventory.upgradable';
    public $stackable = 0;
    public static $STACKABLE = 'inventory.stackable';
    public $sellable = 0;
    public static $SELLABLE = 'inventory.sellable';
    public $usable = 0;
    public static $USABLE = 'inventory.usable';
    public $time = '';
    public static $TIME = 'inventory.time';
    public $health = 0;
    public static $HEALTH = 'inventory.health';
    public $strength = 0;
    public static $STRENGTH = 'inventory.strength';
    public $dexterity = 0;
    public static $DEXTERITY = 'inventory.dexterity';
    public $intuition = 0;
    public static $INTUITION = 'inventory.intuition';
    public $resistance = 0;
    public static $RESISTANCE = 'inventory.resistance';
    public $attention = 0;
    public static $ATTENTION = 'inventory.attention';
    public $charism = 0;
    public static $CHARISM = 'inventory.charism';
    public $level = 0;
    public static $LEVEL = 'inventory.level';
    public $money = 0;
    public static $MONEY = 'inventory.money';
    public $honey = 0;
    public static $HONEY = 'inventory.honey';
    public $ore = 0;
    public static $ORE = 'inventory.ore';
    public $info = '';
    public static $INFO = 'inventory.info';
    public $oil = 0;
    public static $OIL = 'inventory.oil';
    public $hp = 0;
    public static $HP = 'inventory.hp';
    public $uniq = 0;
    public static $UNIQ = 'inventory.uniq';
    public $buyable = 0;
    public static $BUYABLE = 'inventory.buyable';
    public $code = '';
    public static $CODE = 'inventory.code';
    public $sex = '';
    public $sex_Dictionary = array('male','female');
    public static $SEX = 'inventory.sex';
    public $dtbuy = 0;
    public static $DTBUY = 'inventory.dtbuy';
    public $unlocked = 0;
    public static $UNLOCKED = 'inventory.unlocked';
    public $unlockedby = '';
    public static $UNLOCKEDBY = 'inventory.unlockedby';
    public $clan = 0;
    public static $CLAN = 'inventory.clan';
    public $type2 = '';
    public $type2_Dictionary = array('player','clan');
    public static $TYPE2 = 'inventory.type2';
    public $usestate = '';
    public $usestate_Dictionary = array('normal','fight');
    public static $USESTATE = 'inventory.usestate';
    public $mf = 0;
    public static $MF = 'inventory.mf';
    public $ratingcrit = 0;
    public static $RATINGCRIT = 'inventory.ratingcrit';
    public $ratingdodge = 0;
    public static $RATINGDODGE = 'inventory.ratingdodge';
    public $ratingresist = 0;
    public static $RATINGRESIST = 'inventory.ratingresist';
    public $ratinganticrit = 0;
    public static $RATINGANTICRIT = 'inventory.ratinganticrit';
    public $ratingdamage = 0;
    public static $RATINGDAMAGE = 'inventory.ratingdamage';
    public $ratingaccur = 0;
    public static $RATINGACCUR = 'inventory.ratingaccur';
    public $subtype = '';
    public $subtype_Dictionary = array('moto','metro','rats','korovan','gift','award');
    public static $SUBTYPE = 'inventory.subtype';
    public $special1 = '';
    public static $SPECIAL1 = 'inventory.special1';
    public $special1name = '';
    public static $SPECIAL1NAME = 'inventory.special1name';
    public $special2 = '';
    public static $SPECIAL2 = 'inventory.special2';
    public $special2name = '';
    public static $SPECIAL2NAME = 'inventory.special2name';
    public $special3 = '';
    public static $SPECIAL3 = 'inventory.special3';
    public $special3name = '';
    public static $SPECIAL3NAME = 'inventory.special3name';
    public $special4 = '';
    public static $SPECIAL4 = 'inventory.special4';
    public $special4name = '';
    public static $SPECIAL4NAME = 'inventory.special4name';
    public $special5 = '';
    public static $SPECIAL5 = 'inventory.special5';
    public $special5name = '';
    public static $SPECIAL5NAME = 'inventory.special5name';
    public $special6 = '';
    public static $SPECIAL6 = 'inventory.special6';
    public $special6name = '';
    public static $SPECIAL6NAME = 'inventory.special6name';
    public $special7 = '';
    public static $SPECIAL7 = 'inventory.special7';
    public $special7name = '';
    public static $SPECIAL7NAME = 'inventory.special7name';
    public $deleteafter = '';
    public $deleteafter_Dictionary = array('date','period');
    public static $DELETEAFTER = 'inventory.deleteafter';
    public $deleteafterdt = 0;
    public static $DELETEAFTERDT = 'inventory.deleteafterdt';

    public function __construct()
    {
        parent::__construct('inventory');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->standard_item = 0;
        $this->player = 0;
        $this->durability = 0;
        $this->maxdurability = 0;
        $this->image = '';
        $this->slot = '';
        $this->type = '';
        $this->equipped = 0;
        $this->itemlevel = 0;
        $this->upgradable = 0;
        $this->stackable = 0;
        $this->sellable = 0;
        $this->usable = 0;
        $this->time = '';
        $this->health = 0;
        $this->strength = 0;
        $this->dexterity = 0;
        $this->intuition = 0;
        $this->resistance = 0;
        $this->attention = 0;
        $this->charism = 0;
        $this->level = 0;
        $this->money = 0;
        $this->honey = 0;
        $this->ore = 0;
        $this->info = '';
        $this->oil = 0;
        $this->hp = 0;
        $this->uniq = 0;
        $this->buyable = 0;
        $this->code = '';
        $this->sex = '';
        $this->dtbuy = 0;
        $this->unlocked = 0;
        $this->unlockedby = '';
        $this->clan = 0;
        $this->type2 = '';
        $this->usestate = '';
        $this->mf = 0;
        $this->ratingcrit = 0;
        $this->ratingdodge = 0;
        $this->ratingresist = 0;
        $this->ratinganticrit = 0;
        $this->ratingdamage = 0;
        $this->ratingaccur = 0;
        $this->subtype = '';
        $this->special1 = '';
        $this->special1name = '';
        $this->special2 = '';
        $this->special2name = '';
        $this->special3 = '';
        $this->special3name = '';
        $this->special4 = '';
        $this->special4name = '';
        $this->special5 = '';
        $this->special5name = '';
        $this->special6 = '';
        $this->special6name = '';
        $this->special7 = '';
        $this->special7name = '';
        $this->deleteafter = '';
        $this->deleteafterdt = 0;
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
        $this->standard_item = $object['standard_item'];
        $this->player = $object['player'];
        $this->durability = $object['durability'];
        $this->maxdurability = $object['maxdurability'];
        $this->image = $object['image'];
        $this->slot = $object['slot'];
        $this->type = $object['type'];
        $this->equipped = $object['equipped'];
        $this->itemlevel = $object['itemlevel'];
        $this->upgradable = $object['upgradable'];
        $this->stackable = $object['stackable'];
        $this->sellable = $object['sellable'];
        $this->usable = $object['usable'];
        $this->time = $object['time'];
        $this->health = $object['health'];
        $this->strength = $object['strength'];
        $this->dexterity = $object['dexterity'];
        $this->intuition = $object['intuition'];
        $this->resistance = $object['resistance'];
        $this->attention = $object['attention'];
        $this->charism = $object['charism'];
        $this->level = $object['level'];
        $this->money = $object['money'];
        $this->honey = $object['honey'];
        $this->ore = $object['ore'];
        $this->info = $object['info'];
        $this->oil = $object['oil'];
        $this->hp = $object['hp'];
        $this->uniq = $object['uniq'];
        $this->buyable = $object['buyable'];
        $this->code = $object['code'];
        $this->sex = $object['sex'];
        $this->dtbuy = $object['dtbuy'];
        $this->unlocked = $object['unlocked'];
        $this->unlockedby = $object['unlockedby'];
        $this->clan = $object['clan'];
        $this->type2 = $object['type2'];
        $this->usestate = $object['usestate'];
        $this->mf = $object['mf'];
        $this->ratingcrit = $object['ratingcrit'];
        $this->ratingdodge = $object['ratingdodge'];
        $this->ratingresist = $object['ratingresist'];
        $this->ratinganticrit = $object['ratinganticrit'];
        $this->ratingdamage = $object['ratingdamage'];
        $this->ratingaccur = $object['ratingaccur'];
        $this->subtype = $object['subtype'];
        $this->special1 = $object['special1'];
        $this->special1name = $object['special1name'];
        $this->special2 = $object['special2'];
        $this->special2name = $object['special2name'];
        $this->special3 = $object['special3'];
        $this->special3name = $object['special3name'];
        $this->special4 = $object['special4'];
        $this->special4name = $object['special4name'];
        $this->special5 = $object['special5'];
        $this->special5name = $object['special5name'];
        $this->special6 = $object['special6'];
        $this->special6name = $object['special6name'];
        $this->special7 = $object['special7'];
        $this->special7name = $object['special7name'];
        $this->deleteafter = $object['deleteafter'];
        $this->deleteafterdt = $object['deleteafterdt'];
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
            case 33:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->code = str_replace('"', '&quot;', $_POST['code']);
                $this->player = (int) $_POST['player'];
                $this->durability = (int) $_POST['durability'];
                $this->maxdurability = (int) $_POST['maxdurability'];
                $this->image = str_replace('"', '&quot;', $_POST['image']);
                $this->slot = $_POST['slot'];
                $this->type = $_POST['type'];
                $this->itemlevel = (int) $_POST['itemlevel'];
                $this->level = (int) $_POST['level'];
                $this->info = $_POST['info'];
                $this->upgradable = isset($_POST['upgradable']) ? 1 : 0;
                $this->stackable = isset($_POST['stackable']) ? 1 : 0;
                $this->sellable = isset($_POST['sellable']) ? 1 : 0;
                $this->usable = isset($_POST['usable']) ? 1 : 0;
                $this->uniq = isset($_POST['uniq']) ? 1 : 0;
                $this->buyable = isset($_POST['buyable']) ? 1 : 0;
                $this->time = str_replace('"', '&quot;', $_POST['time']);
                $this->hp = (double) str_replace(',', '.', $_POST['hp']);
                $this->health = (double) str_replace(',', '.', $_POST['health']);
                $this->strength = (double) str_replace(',', '.', $_POST['strength']);
                $this->dexterity = (double) str_replace(',', '.', $_POST['dexterity']);
                $this->intuition = (double) str_replace(',', '.', $_POST['intuition']);
                $this->resistance = (double) str_replace(',', '.', $_POST['resistance']);
                $this->attention = (double) str_replace(',', '.', $_POST['attention']);
                $this->charism = (double) str_replace(',', '.', $_POST['charism']);
                $this->money = (int) $_POST['money'];
                $this->honey = (int) $_POST['honey'];
                $this->ore = (int) $_POST['ore'];
                $this->sex = $_POST['sex'];
                $this->dtbuy = (int) $_POST['dtbuy'];
                $this->unlocked = isset($_POST['unlocked']) ? 1 : 0;
                $this->unlockedby = $_POST['unlockedby'];
                $this->clan = (int) $_POST['clan'];
                $this->type2 = $_POST['type2'];
                $this->usestate = $_POST['usestate'];
                $this->ratingcrit = (double) str_replace(',', '.', $_POST['ratingcrit']);
                $this->ratingdodge = (double) str_replace(',', '.', $_POST['ratingdodge']);
                $this->ratingresist = (double) str_replace(',', '.', $_POST['ratingresist']);
                $this->ratinganticrit = (double) str_replace(',', '.', $_POST['ratinganticrit']);
                $this->ratingdamage = (double) str_replace(',', '.', $_POST['ratingdamage']);
                $this->ratingaccur = (double) str_replace(',', '.', $_POST['ratingaccur']);
                $this->subtype = $_POST['subtype'];
                $this->special1 = str_replace('"', '&quot;', $_POST['special1']);
                $this->special1name = str_replace('"', '&quot;', $_POST['special1name']);
                $this->special2 = str_replace('"', '&quot;', $_POST['special2']);
                $this->special2name = str_replace('"', '&quot;', $_POST['special2name']);
                $this->special3 = str_replace('"', '&quot;', $_POST['special3']);
                $this->special3name = str_replace('"', '&quot;', $_POST['special3name']);
                $this->special4 = str_replace('"', '&quot;', $_POST['special4']);
                $this->special4name = str_replace('"', '&quot;', $_POST['special4name']);
                $this->special5 = str_replace('"', '&quot;', $_POST['special5']);
                $this->special5name = str_replace('"', '&quot;', $_POST['special5name']);
                $this->special6 = str_replace('"', '&quot;', $_POST['special6']);
                $this->special6name = str_replace('"', '&quot;', $_POST['special6name']);
                $this->special7 = str_replace('"', '&quot;', $_POST['special7']);
                $this->special7name = str_replace('"', '&quot;', $_POST['special7name']);
                $this->deleteafter = $_POST['deleteafter'];
                $this->deleteafterdt = (int) $_POST['deleteafterdt'];
                $this->oil = (int) $_POST['oil'];
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
        $object['durability'] = $this->durability;
        $object['maxdurability'] = $this->maxdurability;
        $object['image'] = $this->image;
        $object['slot'] = $this->slot;
        $object['type'] = $this->type;
        $object['equipped'] = $this->equipped;
        $object['itemlevel'] = $this->itemlevel;
        $object['upgradable'] = $this->upgradable;
        $object['stackable'] = $this->stackable;
        $object['sellable'] = $this->sellable;
        $object['usable'] = $this->usable;
        $object['time'] = $this->time;
        $object['health'] = $this->health;
        $object['strength'] = $this->strength;
        $object['dexterity'] = $this->dexterity;
        $object['intuition'] = $this->intuition;
        $object['resistance'] = $this->resistance;
        $object['attention'] = $this->attention;
        $object['charism'] = $this->charism;
        $object['level'] = $this->level;
        $object['money'] = $this->money;
        $object['honey'] = $this->honey;
        $object['ore'] = $this->ore;
        $object['info'] = $this->info;
        $object['oil'] = $this->oil;
        $object['hp'] = $this->hp;
        $object['uniq'] = $this->uniq;
        $object['buyable'] = $this->buyable;
        $object['code'] = $this->code;
        $object['sex'] = $this->sex;
        $object['dtbuy'] = $this->dtbuy;
        $object['unlocked'] = $this->unlocked;
        $object['unlockedby'] = $this->unlockedby;
        if (is_object($this->clan))
        {
            $object['clan'] = $this->clan->toArray();
        }
        else
        {
        	$object['clan'] = $this->clan;
        }
        $object['type2'] = $this->type2;
        $object['usestate'] = $this->usestate;
        $object['mf'] = $this->mf;
        $object['ratingcrit'] = $this->ratingcrit;
        $object['ratingdodge'] = $this->ratingdodge;
        $object['ratingresist'] = $this->ratingresist;
        $object['ratinganticrit'] = $this->ratinganticrit;
        $object['ratingdamage'] = $this->ratingdamage;
        $object['ratingaccur'] = $this->ratingaccur;
        $object['subtype'] = $this->subtype;
        $object['special1'] = $this->special1;
        $object['special1name'] = $this->special1name;
        $object['special2'] = $this->special2;
        $object['special2name'] = $this->special2name;
        $object['special3'] = $this->special3;
        $object['special3name'] = $this->special3name;
        $object['special4'] = $this->special4;
        $object['special4name'] = $this->special4name;
        $object['special5'] = $this->special5;
        $object['special5name'] = $this->special5name;
        $object['special6'] = $this->special6;
        $object['special6name'] = $this->special6name;
        $object['special7'] = $this->special7;
        $object['special7name'] = $this->special7name;
        $object['deleteafter'] = $this->deleteafter;
        $object['deleteafterdt'] = $this->deleteafterdt;
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
            		$field = str_replace('inventory.', '', $field);
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
            	$this->sql->query("UPDATE `inventory".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `inventory".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `standard_item`=".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `durability`=".(int)$this->durability.", `maxdurability`=".(int)$this->maxdurability.", `image`='".Std::cleanString($this->image)."', `slot`='".Std::cleanString($this->slot)."', `type`='".Std::cleanString($this->type)."', `equipped`=".(int)$this->equipped.", `itemlevel`=".(int)$this->itemlevel.", `upgradable`=".(int)$this->upgradable.", `stackable`=".(int)$this->stackable.", `sellable`=".(int)$this->sellable.", `usable`=".(int)$this->usable.", `time`='".Std::cleanString($this->time)."', `health`=".(double)$this->health.", `strength`=".(double)$this->strength.", `dexterity`=".(double)$this->dexterity.", `intuition`=".(double)$this->intuition.", `resistance`=".(double)$this->resistance.", `attention`=".(double)$this->attention.", `charism`=".(double)$this->charism.", `level`=".(int)$this->level.", `money`=".(int)$this->money.", `honey`=".(int)$this->honey.", `ore`=".(int)$this->ore.", `info`='".Std::cleanString($this->info)."', `oil`=".(int)$this->oil.", `hp`=".(double)$this->hp.", `uniq`=".(int)$this->uniq.", `buyable`=".(int)$this->buyable.", `code`='".Std::cleanString($this->code)."', `sex`='".Std::cleanString($this->sex)."', `dtbuy`=".(int)$this->dtbuy.", `unlocked`=".(int)$this->unlocked.", `unlockedby`='".Std::cleanString($this->unlockedby)."', `clan`=".(is_object($this->clan) ? $this->clan->id : $this->clan).", `type2`='".Std::cleanString($this->type2)."', `usestate`='".Std::cleanString($this->usestate)."', `mf`=".(int)$this->mf.", `ratingcrit`=".(double)$this->ratingcrit.", `ratingdodge`=".(double)$this->ratingdodge.", `ratingresist`=".(double)$this->ratingresist.", `ratinganticrit`=".(double)$this->ratinganticrit.", `ratingdamage`=".(double)$this->ratingdamage.", `ratingaccur`=".(double)$this->ratingaccur.", `subtype`='".Std::cleanString($this->subtype)."', `special1`='".Std::cleanString($this->special1)."', `special1name`='".Std::cleanString($this->special1name)."', `special2`='".Std::cleanString($this->special2)."', `special2name`='".Std::cleanString($this->special2name)."', `special3`='".Std::cleanString($this->special3)."', `special3name`='".Std::cleanString($this->special3name)."', `special4`='".Std::cleanString($this->special4)."', `special4name`='".Std::cleanString($this->special4name)."', `special5`='".Std::cleanString($this->special5)."', `special5name`='".Std::cleanString($this->special5name)."', `special6`='".Std::cleanString($this->special6)."', `special6name`='".Std::cleanString($this->special6name)."', `special7`='".Std::cleanString($this->special7)."', `special7name`='".Std::cleanString($this->special7name)."', `deleteafter`='".Std::cleanString($this->deleteafter)."', `deleteafterdt`=".(int)$this->deleteafterdt." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `inventory".$saveMerge."` (`name`, `standard_item`, `player`, `durability`, `maxdurability`, `image`, `slot`, `type`, `equipped`, `itemlevel`, `upgradable`, `stackable`, `sellable`, `usable`, `time`, `health`, `strength`, `dexterity`, `intuition`, `resistance`, `attention`, `charism`, `level`, `money`, `honey`, `ore`, `info`, `oil`, `hp`, `uniq`, `buyable`, `code`, `sex`, `dtbuy`, `unlocked`, `unlockedby`, `clan`, `type2`, `usestate`, `mf`, `ratingcrit`, `ratingdodge`, `ratingresist`, `ratinganticrit`, `ratingdamage`, `ratingaccur`, `subtype`, `special1`, `special1name`, `special2`, `special2name`, `special3`, `special3name`, `special4`, `special4name`, `special5`, `special5name`, `special6`, `special6name`, `special7`, `special7name`, `deleteafter`, `deleteafterdt`) VALUES ('".Std::cleanString($this->name)."', ".(is_object($this->standard_item) ? $this->standard_item->id : $this->standard_item).", ".(is_object($this->player) ? $this->player->id : $this->player).", ".(int)$this->durability.", ".(int)$this->maxdurability.", '".Std::cleanString($this->image)."', '".Std::cleanString($this->slot)."', '".Std::cleanString($this->type)."', ".(int)$this->equipped.", ".(int)$this->itemlevel.", ".(int)$this->upgradable.", ".(int)$this->stackable.", ".(int)$this->sellable.", ".(int)$this->usable.", '".Std::cleanString($this->time)."', ".(double)$this->health.", ".(double)$this->strength.", ".(double)$this->dexterity.", ".(double)$this->intuition.", ".(double)$this->resistance.", ".(double)$this->attention.", ".(double)$this->charism.", ".(int)$this->level.", ".(int)$this->money.", ".(int)$this->honey.", ".(int)$this->ore.", '".Std::cleanString($this->info)."', ".(int)$this->oil.", ".(double)$this->hp.", ".(int)$this->uniq.", ".(int)$this->buyable.", '".Std::cleanString($this->code)."', '".Std::cleanString($this->sex)."', ".(int)$this->dtbuy.", ".(int)$this->unlocked.", '".Std::cleanString($this->unlockedby)."', ".(is_object($this->clan) ? $this->clan->id : $this->clan).", '".Std::cleanString($this->type2)."', '".Std::cleanString($this->usestate)."', ".(int)$this->mf.", ".(double)$this->ratingcrit.", ".(double)$this->ratingdodge.", ".(double)$this->ratingresist.", ".(double)$this->ratinganticrit.", ".(double)$this->ratingdamage.", ".(double)$this->ratingaccur.", '".Std::cleanString($this->subtype)."', '".Std::cleanString($this->special1)."', '".Std::cleanString($this->special1name)."', '".Std::cleanString($this->special2)."', '".Std::cleanString($this->special2name)."', '".Std::cleanString($this->special3)."', '".Std::cleanString($this->special3name)."', '".Std::cleanString($this->special4)."', '".Std::cleanString($this->special4name)."', '".Std::cleanString($this->special5)."', '".Std::cleanString($this->special5name)."', '".Std::cleanString($this->special6)."', '".Std::cleanString($this->special6name)."', '".Std::cleanString($this->special7)."', '".Std::cleanString($this->special7name)."', '".Std::cleanString($this->deleteafter)."', ".(int)$this->deleteafterdt.")");
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
			case 'standard_item': return 13; break;
			case 'player': return 13; break;
			case 'durability': return 2; break;
			case 'maxdurability': return 2; break;
			case 'image': return 4; break;
			case 'slot': return 15; break;
			case 'type': return 15; break;
			case 'equipped': return 10; break;
			case 'itemlevel': return 2; break;
			case 'upgradable': return 10; break;
			case 'stackable': return 10; break;
			case 'sellable': return 10; break;
			case 'usable': return 10; break;
			case 'time': return 4; break;
			case 'health': return 3; break;
			case 'strength': return 3; break;
			case 'dexterity': return 3; break;
			case 'intuition': return 3; break;
			case 'resistance': return 3; break;
			case 'attention': return 3; break;
			case 'charism': return 3; break;
			case 'level': return 2; break;
			case 'money': return 2; break;
			case 'honey': return 2; break;
			case 'ore': return 2; break;
			case 'info': return 5; break;
			case 'oil': return 2; break;
			case 'hp': return 3; break;
			case 'uniq': return 10; break;
			case 'buyable': return 10; break;
			case 'code': return 4; break;
			case 'sex': return 15; break;
			case 'dtbuy': return 2; break;
			case 'unlocked': return 10; break;
			case 'unlockedby': return 5; break;
			case 'clan': return 13; break;
			case 'type2': return 15; break;
			case 'usestate': return 15; break;
			case 'mf': return 2; break;
			case 'ratingcrit': return 3; break;
			case 'ratingdodge': return 3; break;
			case 'ratingresist': return 3; break;
			case 'ratinganticrit': return 3; break;
			case 'ratingdamage': return 3; break;
			case 'ratingaccur': return 3; break;
			case 'subtype': return 15; break;
			case 'special1': return 4; break;
			case 'special1name': return 4; break;
			case 'special2': return 4; break;
			case 'special2name': return 4; break;
			case 'special3': return 4; break;
			case 'special3name': return 4; break;
			case 'special4': return 4; break;
			case 'special4name': return 4; break;
			case 'special5': return 4; break;
			case 'special5name': return 4; break;
			case 'special6': return 4; break;
			case 'special6name': return 4; break;
			case 'special7': return 4; break;
			case 'special7name': return 4; break;
			case 'deleteafter': return 15; break;
			case 'deleteafterdt': return 2; break;
    	}
    }
}
?>