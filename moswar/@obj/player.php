<?php
class playerObject extends playerBaseObject
{
	const RECOVERY_TIME = 60;
	const RECOVERY_SPEED = 30;

	public $inventory = array();
	private $inventoryLoaded = false;
	public $boost = array();
	public $hp;
	public $capacity = 20;
	public $inventoryAmount = 0;
	public $pet;
	public $pethpk = 6;
	public $home;
	public $gifts;
	private $testedOnLoad = false;
	private $boostLoaded = false;
	public $access;
	public $clan_name;
    public $viphunt = 0;
	public $hasSafe = 0;

	public $npc_wins = 0;
	public $npc_loses = 0;

	public function __construct()
    {
		parent::__construct();
	}

	public function __clone() {
		unset($this->boost, $this->inventory, $this->pet, $this->home, $this->gifts);
	}

	public function load($id) {
		if (false && !CONTENTICO && (Page::isAdminFor('code-test') || true)) {
			$object = Page::sqlQueryOverPS('object_player_load', array('@id' => $id));
			if (is_array($object) === false) {
				return false;
			}
			$this->id = $id;
			$this->init($object);
		} else {
			$result = parent::load($id);
		}
		
		//$result = parent::load($id);
		if (time() - strtotime($this->lastactivitytime) <= 900) {
			$this->status = 'online';
		} else {
			$this->status = 'offline';
		}
		if (!CONTENTICO && class_exists('Page')/* && $result == true*/) {
			if (!is_array($this->data)) {
				$this->data = (array) json_decode($this->data, true);
			}
			$this->testOnLoad();
		}
		return $result;
	}

	public function init($object) {
		parent::init($object);
		if (time() - strtotime($this->lastactivitytime) <= 900) {
			$this->status = 'online';
		} else {
			$this->status = 'offline';
		}
		if (!CONTENTICO && class_exists('Page')/* && $result == true*/) {
			if (!is_array($this->data)) {
				$this->data = (array) json_decode($this->data, true);
			}
			$this->testOnLoad();
		}
	}

	public function loadClan()
    {
		if ($this->clan > 0 && $this->clan_status != 'recruit') {
			$this->clan_name = Page::$sql->getValue("select name from clan where id = " . $this->clan);
		}
	}

	public function testOnLoad()
    {
		$this->viphunt = strtotime($this->viphuntdt) > time() ? 1 : 0;
        
        if ($this->testedOnLoad == true) {
			return;
		}
		
		if ($this->data['nft_d'] < mktime(0, 0, 0)) {
			$this->data['nft_d'] = mktime(0, 0, 0);
		}
		
		if ($this->sex == '') {
			if (substr($this->avatar, 0, 4) == 'girl') {
				$this->sex = 'female';
			} else if (substr($this->avatar, 0, 3) == 'man') {
				$this->sex = 'male';
			}
			$sql = "UPDATE player SET sex = '" . $this->sex . "' WHERE id = " . $this->id;
			Page::$sql->query($sql);
			//$this->save($this->id, array(playerObject::$SEX));
		}
		if ($this->exp >= $GLOBALS['data']['exptable'][$this->level]) {
			$this->increaseLevel(1, true);
		}
		if ($this->money < 0) {
			$this->money = 0;
			$this->save($this->id, array(playerObject::$MONEY));
		}
		if (is_callable(array(Page, 'getData'))) {
			$this->recalcStats();
		}
		$this->testedOnLoad = true;

		if (Page::$player->id == $this->id) {
			/* Завершение автомобилезаводостроения */
			if (isset($this->data["automobile_upgrade_factory"]) && is_array($this->data["automobile_upgrade_factory"]) && $this->data["automobile_upgrade_factory"]["time"] <= time()) {
				$automobile = Page::sqlGetCacheRecord("SELECT * FROM automobile WHERE player = " . $this->id, 1800, "automobile_automobile_" . $this->id);
				Std::loadModule("Automobile");
				Automobile::initFactories();
				Automobile::initImprovements();

				$imps = Automobile::newImprovements($automobile, $this->data["automobile_upgrade_factory"]["factory"], $this->data["automobile_upgrade_factory"]["level"]);
				Page::sendLog($this->id, "automobile_upgrade_factory_end", array("factory" => Automobile::$factoryType[$this->data["automobile_upgrade_factory"]["factory"]]["name"] . " [" . $this->data["automobile_upgrade_factory"]["level"] . "]", "mbckp" => $this->getMbckp()), 1);
				if (sizeof($imps) > 0) {
					Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_CONGRATULATIONS . "<b>" . Automobile::$factoryType[$this->data["automobile_upgrade_factory"]["factory"]]["name"] . " [" . $this->data["automobile_upgrade_factory"]["level"] . "]" . "</b>" . AutomobileLang::MESSAGE_UPGRADE_FACTORY_COMPLETE . " " . AutomobileLang::MESSAGE_UPGRADE_FACTORY_NEW_IMPROVEMENT . "<b>«" . Automobile::$improvements[$imps[0]]["name"] . "»</b>" . AutomobileLang::MESSAGE_UPGRADE_FACTORY_CHECK_GARAGE);
				} else {
					Page::addAlert(AutomobileLang::ALERT_FACTORY, AutomobileLang::MESSAGE_UPGRADE_FACTORY_CONGRATULATIONS . "<b>" . Automobile::$factoryType[$this->data["automobile_upgrade_factory"]["factory"]]["name"] . " [" . $this->data["automobile_upgrade_factory"]["level"] . "]" . "</b>" . AutomobileLang::MESSAGE_UPGRADE_FACTORY_COMPLETE);
				}
				$this->data["automobile_upgrade_factory"] = null;
				$this->saveData();
			}

			if (isset($this->data["automobile_create_car"]) && is_array($this->data["automobile_create_car"]) && $this->data["automobile_create_car"]["time"] <= time()) {
				Std::loadModule("Automobile");
				Automobile::initModels();

				Page::sendLog($this->id, "automobile_create_car_end", array("carid" => $this->data["automobile_create_car"]["carid"], "carname" => Automobile::$models[$this->data["automobile_create_car"]["model"]]["name"], "mbckp" => $this->getMbckp()), 1);
				$this->data["automobile_create_car"] = null;
				$this->saveData();
			}

			if ($this->data["automobile_bring_up"]["endtime"] && $this->data["automobile_bring_up"]["endtime"] < time()) {
				Std::loadModule("Automobile");
				Automobile::initPassengers();
				if (mt_rand(1, 100) <= Page::$data["automobile_bring_up"]["luck"]) {
					$count = 10 + floor(($this->data["automobile_bring_up"]["prestige"] - 10) / 16) + mt_rand(0,2);

					if (DEV_SERVER) {
						$count *= 8;
					}

					$this->data["automobile_bring_up"]["count"] += $count;
					$type = 1;
					foreach (Page::$data["automobile_bring_up"]["passenger"] as $pas) {
						if ($count >= $pas["count"]) $type = $pas["type"];
					}
					Page::addAlert(AutomobileLang::ALERT_OK, AutomobileLang::MESSAGE_BRING_UP_SUCCESS_1 . "<b>" . Automobile::$passengers[$type][mt_rand(0, sizeof(Automobile::$passengers[$type]) - 1)]. "</b>" . AutomobileLang::MESSAGE_BRING_UP_SUCCESS_2 . $count);
					Page::checkEvent($this->id, "automobile_bring_up");
				} else {
					Page::addAlert(AutomobileLang::MESSAGE_BRING_UP_FAIL, Automobile::$bringUpFails[mt_rand(0, sizeof(Automobile::$bringUpFails) - 1)], ALERT_ERROR);
				}
				$this->data["automobile_bring_up"]["prestige"] = $car["prestige"];
				$this->data["automobile_bring_up"]["total"] = $cooldown;
				$this->data["automobile_bring_up"]["endtime"] = 0;
				$this->saveData();
			}
			/* /Завершение автомобилезаводостроения */
		}
	}

	public function recalcStats()
    {
		$bonus = 0;
		if ($this->level > 1 && $this->id == CacheManager::get('value_flag_player')) {
			$bonus = 0;
		} elseif ($this->level > 1 && $this->clan > 0 && $this->clan_status != 'recruit' && $this->clan == CacheManager::get('value_flag_clan')) {
			$bonus = 2;
		} elseif ($this->level > 1 && $this->fraction == CacheManager::get('value_flag_fraction')) {
			$bonus = 1;
		}
		$fields = array();
		if ($bonus != $this->flag_bonus) {
			$this->flag_bonus = $bonus;
			//$this->save($this->id, array(playerObject::$FLAG_BONUS));
			$fields[] = playerObject::$FLAG_BONUS;
		}
		$statChanged = false;
		$hpChanged = false;
		foreach (Page::$data['stats'] as $key => $stat) {
			$newstat = round(($this->{$key} + $this->{$key . '_bonus'} + $bonus) * (100 + $this->{$key . '_percent'}) / 100);
			if ($this->{$key . '_finish'} != $newstat) {
				$this->{$key . '_finish'} = $newstat;
				$fields[] = playerObject::${strtoupper($key) . '_FINISH'};
				$statChanged = true;
				if ($key == 'health' || $key == 'resistance') {
					$hpChanged = true;
				}
			}
		}
		$sum = $this->health_finish + $this->strength_finish + $this->attention_finish + $this->resistance_finish + $this->charism_finish + $this->dexterity_finish + $this->intuition_finish;
		if ($this->statsum != $sum) {
			$fields[] = playerObject::$STATSUM;
			$this->statsum = $sum;
		}
		if ($hpChanged) {
			$this->setMaxHP($this->health_finish * 10 + $this->resistance_finish * 4);
			$fields[] = playerObject::$MAXHP;
		}

		if ($this->level >= 3) {
			$home_price = 40 * pow(2, floor($this->level / 3) - 1);
			if ($this->home_price != $home_price) {
				$this->home_price = $home_price;
				$fields[] = playerObject::$HOME_PRICE;
			}
		}
		if (count($fields)) {
			$this->save($this->id, $fields);
		}
	}

	public function toArray()
	{
		$object = parent::toArray();
		$object['hp'] = $this->hp;
		$object['npc_wins'] = $this->npc_wins;
		$object['npc_loses'] = $this->npc_loses;
		$object['inventory'] = array();
		if (count($this->inventory)) {
			foreach ($this->inventory as $key => $inventory) {
				if (is_object($inventory)) {
					$object['inventory'][$key] = $inventory->toArray();
				}
			}
		}
		$object['boost'] = array();
		if (is_array($this->boost) && count($this->boost)) {
			foreach ($this->boost as $boost) {
				if (is_array($boost)) {
					$object['boost'][] = $boost;
				} else {
					$object['boost'][] = $boost->toArray();
				}
			}
		}
		$object['gifts'] = array();
		if (is_array($this->gifts) && !empty($this->gifts)) {
			foreach ($this->gifts as $gift) {
				$object['gifts'][] = is_array($gift) ? $gift : $gift->toArray();
			}
		}
		if ($this->clan_name) {
			$object['clan_name'] = $this->clan_name;
		}
        $object['ip'] = long2ip($this->ip);
		return $object;
	}

	public function loadHP() {
		$time = time();
		//$maxTime = ($this->maxhp * self::RECOVERY_TIME) / ($this->maxhp / self::RECOVERY_SPEED);
		if ($this->healtime <= $time || $this->healtime == 0) { // $this->healtime > ($time + $maxTime)
			$this->hp = $this->maxhp;
			return $this->maxhp;
		}
		$coef = 1;
		if ($this->level == 1) {
			$coef = 6;
		}
		$curhp = round($this->maxhp - (($this->healtime - $time) / (self::RECOVERY_TIME / $coef)) * ($this->maxhp / self::RECOVERY_SPEED));
		$this->hp = $curhp;
		return $curhp;
	}

	public function loadEquipped()
    {
		Std::loadMetaObjectClass ('inventory');
		$criteria = new ObjectCollectionCriteria ();
		$criteria->createWhere(inventoryObject::$PLAYER, ObjectCollectionCriteria::$COMPARE_EQUAL, $this->id);
		$criteria->where[] = "((`inventory`.`durability` > 0 AND `inventory`.`maxdurability` > 0) OR (`inventory`.`maxdurability` = 0))";
		$criteria->createWhere(inventoryObject::$EQUIPPED, ObjectCollectionCriteria::$COMPARE_EQUAL, 1);
		$collection = new ObjectCollection();
		$this->inventory = $collection->getObjectList (inventoryObject::$METAOBJECT, $criteria);
		if ($this->inventory === false) {
			$this->inventory = array();
		} else {
			foreach ($this->inventory as &$item) {
				if ($item->type == 'pet') {
					$this->pet = $item;
				} else if ($item->type == 'home_comfort' || $item->type == 'home_defence' || $item->type == 'home_safe') {
					$this->home[] = $item;
				} else {
					$this->inventoryAmount++;
				}
			}
		}

		return $this->inventory;
	}

	public function loadInventory($type = '', $slot = '') {
		if ($this->inventoryLoaded == true) {
			return $this->inventory;
		}
		$this->inventoryLoaded = true;
		Std::loadMetaObjectClass('inventory');
		
		$criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(inventoryObject::$PLAYER, ObjectCollectionCriteria::$COMPARE_EQUAL, $this->id);
		//$criteria->createWhere (inventoryObject::$DURABILITY, ObjectCollectionCriteria::$COMPARE_GREATER, 0);
		$criteria->where[] = "((`inventory`.`durability` > 0 AND `inventory`.`maxdurability` > 0) OR (`inventory`.`maxdurability` = 0))";
		if (is_string($slot) && strlen($slot)) {
			$criteria->createWhere(inventoryObject::$SLOT, ObjectCollectionCriteria::$COMPARE_EQUAL, $slot);
		} elseif (is_array($slot) && count($slot)) {
			$criteria->createWhere(inventoryObject::$SLOT, ObjectCollectionCriteria::$COMPARE_IN, $slot);
		}
		if (is_string($type) && strlen($type)) {
			$criteria->createWhere(inventoryObject::$TYPE, ObjectCollectionCriteria::$COMPARE_EQUAL, $type);
		} elseif (is_array($type) && count($type)) {
			$criteria->createWhere(inventoryObject::$TYPE, ObjectCollectionCriteria::$COMPARE_IN, $type);
		}
		$collection = new ObjectCollection();
		$this->inventory = $collection->getObjectList(inventoryObject::$METAOBJECT, $criteria);
		
		/*$query = "SELECT * FROM inventory WHERE player = " . $this->id;
		$this->inventory = Page::$sql->getRecordSet($query);*/
		if ($this->inventory === false) {
			$this->inventory = array();
		} else {
			foreach ($this->inventory as $key => &$item) {
				/*if ($item['durability'] == 0 && $item['maxdurability'] > 0) {
					unset($this->inventory[$key]);
					continue;
				}
				$i = new inventoryObject();
				$i->init($item);
				$item = $i;*/
				if ($item->type == 'pet') {
					$this->pet = $item;
				} elseif ($item->type == 'home_comfort' || $item->type == 'home_defence' || $item->type == 'home_safe') {
					$this->home[] = $item;
					if ($item->type == 'home_safe') {
						$this->hasSafe = 1;
					}
				} else {
					if ($item->type == 'pouch' && $item->equipped) {
                        $this->capacity += $item->special1;
                    }
                    if ($item->type != 'quest') {// && $item->type != 'drug' && $item->type != 'drug2') {
                        $this->inventoryAmount++;
                    }
				}
			}
		}
		return $this->inventory;
	}

	public function loadInventoryAsArray() {
		if ($this->inventoryLoaded == true) {
			return $this->inventory;
		}
		$this->inventoryLoaded = true;

		$sql = "SELECT * FROM `inventory` WHERE inventory.player=" . $this->id . " AND ((`inventory`.`durability` > 0 AND `inventory`.`maxdurability` > 0) OR (`inventory`.`maxdurability` = 0))";
		$this->inventory = Page::$sql->getRecordSet($sql);
		if ($this->inventory === false) {
			$this->inventory = array();
		} else {
			foreach ($this->inventory as &$item) {
				if ($item['type'] == 'home_comfort' || $item['type'] == 'home_defence' || $item['type'] == 'home_safe') {
					$this->home[] = $item;
				} else {
					if ($item['type'] == 'pouch' && $item['type']) {
                        $this->capacity += $item->special1;
                    }
                    if ($item['type'] != 'quest') {// && $item->type != 'drug' && $item->type != 'drug2') {
                        $this->inventoryAmount++;
                    }
				}
			}
		}
		return $this->inventory;
	}

    /**
     * Подсчет, хватает ли свободных слотов в инвентаре для новых предметов
     *
     * @param object $newItem
     * @param int $amount
     * @return bool
     */
    public function hasFreeSpaceForItem($standardItemId, $stackable, $amount = 0)
    {
		// новогодняя хрень. разрешаем покупать без ограничений
		return true;
		
        $freeSpace = false;
        if ($stackable == 0 && $this->inventoryAmount < $this->capacity) {
            $freeSpace = true;
        } elseif ($stackable == 1) {
            $freePositions = ($this->capacity - $this->inventoryAmount) * Page::$data["inventory"]["itemsinslot"];
            foreach ($this->inventory as $item) {
                if ($item->standard_item == $standardItemId) {
                    $freePos = Page::$data["inventory"]["itemsinslot"] - $item->durability;
                    if ($freePos > 0) {
                        $freePositions += $freePos;
                    }
                }
            }
            if ($freePositions >= $amount) {
                $freeSpace = true;
            }
        }
        return $freeSpace;
    }

    /**
     * Дать игроку новые складывающиеся предметы, разложив их по пачкам
     *
     * @param object $newItem
     * @param int $amount
     */
    public function giveItems($standardItemId, $amount)
    {
		$this->loadInventory();
		foreach ($this->inventory as $item) {
            if ($item->standard_item == $standardItemId) {
				if ($item->code == 'fight_star' || $item->code == 'huntclub_mobile' || $item->code == 'war_zub') {
					$itemsInSlot = 9999;
				} else {
					$itemsInSlot = Page::$data["inventory"]["itemsinslot"];
				}
                if ($item->durability < $itemsInSlot && $item->stackable == 1) {
                    $canPutHere = $itemsInSlot - $item->durability;
                    $canPutHere = $canPutHere > $amount ? $amount : $canPutHere;
                    $item->maxdurability += $canPutHere;
                    $item->durability += $canPutHere;
					$item->dtbuy = time();
                    $item->save($item->id, array(inventoryObject::$MAXDURABILITY, inventoryObject::$DURABILITY, inventoryObject::$DTBUY));
                    $amount -= $canPutHere;
                }
            }
            if ($amount <= 0) {
                return;
            }
        }
        Std::loadMetaObjectClass("standard_item");
        $standardItem = new standard_itemObject();
        $standardItem->load($standardItemId);
		while ($amount > 0) {
            $canPutHere = Page::$data["inventory"]["itemsinslot"];
            $canPutHere = $canPutHere > $amount ? $amount : $canPutHere;
            $newMyItem = $standardItem->makeExample($this->id);
            $newMyItem->maxdurability = $canPutHere;
            $newMyItem->durability = $canPutHere;
            $newMyItem->save();
            $amount -= $canPutHere;
        }
    }

	public function loadGifts($type = false)
    {
        Std::loadMetaObjectClass('gift');
        /* snowy fix
		$criteria = new ObjectCollectionCriteria();
        $criteria->createWhere(giftObject::$PLAYER, ObjectCollectionCriteria::$COMPARE_EQUAL, $this->id);
		// BVadim выборка только принятых подарков
		$criteria->createWhere(giftObject::$HIDDEN, ObjectCollectionCriteria::$COMPARE_NOT_EQUAL, true);
        if ($type) {
            $criteria->createWhere(giftObject::$TYPE, ObjectCollectionCriteria::$COMPARE_EQUAL, $type);
        }
        $criteria->createOrder(giftObject::$ID, ObjectCollectionCriteria::$ORDER_DESC);
        $collection = new ObjectCollection();
        $this->gifts = $collection->getObjectList(giftObject::$METAOBJECT, $criteria);
        if ($this->gifts === false) {
            $this->gifts = array();
        }
		*/

		/*
		$sql = "SELECT g.*, g.time gifttime, IFNULL(si.health, 0) health, IFNULL(si.strength, 0) strength, IFNULL(si.dexterity, 0) dexterity, IFNULL(si.intuition, 0) intuition, IFNULL(si.resistance, 0) resistance, IFNULL(si.attention, 0) attention,
            IFNULL(si.charism, 0) charism, IFNULL(si.ratingcrit, 0) ratingcrit, IFNULL(si.ratingaccur, 0) ratingaccur, IFNULL(si.ratingdodge, 0) ratingdodge, IFNULL(si.ratinganticrit, 0) ratinganticrit, IFNULL(si.ratingresist, 0) ratingresist, IFNULL(si.ratingdamage, 0) ratingdamage,
            si.special1, si.special1name, si.special2, si.special2name, si.special3, si.special3name, si.special4, si.special4name,
            si.special5, si.special5name, si.special6, si.special6name, si.special7, si.special7name, si.subtype, si.time
            FROM gift g LEFT JOIN standard_item si ON si.id = g.standard_item
            WHERE g.hidden = 0 AND g.player = " . $this->id . " " . ($type ? " AND g.type = '" . $type . "'" : "") . "
            ORDER BY g.time DESC";
		*/
		//$gifts = Page::getData("snowy_player_gifts_" . $this->id, $sql, "recordset", 3600);
		$gifts = CacheManager::get('player_gifts', array('player_id' => $this->id));
		$this->gifts = array();
		if ($gifts) {
			foreach ($gifts as $gift) {
				$giftObj = new giftObject();
				$giftObj->init($gift);
				$this->gifts[$giftObj->id] = $giftObj;
				//foreach ($gift as $field => $value) {
				//	$giftObj->{$code} = $value;
				//}
			}
		}

        return $this->gifts;
	}

    public function loadGifts2($type = false)
    {
		/*
		$sql = "SELECT g.*, g.time gifttime, IFNULL(si.health, 0) health, IFNULL(si.strength, 0) strength, IFNULL(si.dexterity, 0) dexterity, IFNULL(si.intuition, 0) intuition, IFNULL(si.resistance, 0) resistance, IFNULL(si.attention, 0) attention,
            IFNULL(si.charism, 0) charism, IFNULL(si.ratingcrit, 0) ratingcrit, IFNULL(si.ratingaccur, 0) ratingaccur, IFNULL(si.ratingdodge, 0) ratingdodge, IFNULL(si.ratinganticrit, 0) ratinganticrit, IFNULL(si.ratingresist, 0) ratingresist, IFNULL(si.ratingdamage, 0) ratingdamage,
            si.special1, si.special1name, si.special2, si.special2name, si.special3, si.special3name, si.special4, si.special4name,
            si.special5, si.special5name, si.special6, si.special6name, si.special7, si.special7name, si.subtype, si.time
            FROM gift g LEFT JOIN standard_item si ON si.id = g.standard_item
            WHERE g.hidden = 0 AND g.player = " . $this->id . " " . ($type ? " AND g.type = '" . $type . "'" : "") . "
            ORDER BY g.time DESC";
		*/
		//$this->gifts = Page::getData("snowy_player_gifts_" . $this->id, $sql, "recordset", 3600);
		$this->gifts = CacheManager::get('player_gifts', array('player_id' => $this->id));


	if ($this->gifts == false) {
            $this->gifts = array();
	    }

        return $this->gifts;
	}

	public function hasItemByStandardId($id)
    {
		foreach ($this->inventory as $item) {
			if ($item->standard_item == $id) {
				return true;
			}
		}
		return false;
	}

    /**
     * Загрузка бустов из таблицы playerboost2
     *
     * @param bool $extended
     * @return array
     */
    public function loadBoosts2($extended = false)
    {
		if ($this->boostLoaded == false) {
            $sqlQuery = $extended ? "SELECT b.*, si.name FROM playerboost2 b LEFT JOIN standard_item si ON si.id = b.standard_item
                WHERE player = " . $this->id :
                "SELECT * FROM playerboost2 WHERE player = " . $this->id;
			$this->boost = Page::$sql->getRecordSet($sqlQuery);
			$this->boostLoaded == true;
		}
		if (!is_array($this->boost)) {
			$this->boost = array();
		}
		return $this->boost;
    }

	public function isFree()
	{
		return in_array($this->state, array('macdonalds','frozen','metro','metro_done','metro_rat_search','fight','police','patrol','monya')) ? false : true;
	}

	public function isFreeForFight()
    {
		return in_array($this->state, array('frozen','fight','police')) ? false : true;
	}

	public function isFreeFor($action)
    {
		if ($action == 'create fight') {
			return in_array($this->state, array('macdonalds','frozen','metro','metro_rat_search','fight','police','patrol','monya')) ? false : true;
		} elseif ($action == 'join fight') {
            return in_array($this->state, array('macdonalds','frozen','metro','metro_rat_search','fight','police','patrol','monya')) ? false : true;
		}
		return true;
	}

	public function setFullHP()
	{
        $this->sql->query("UPDATE player SET healtime = NOW() WHERE id = " . $this->id);
		$this->hp = $this->maxhp;
	}

	public function setHP($hp) {
		if ($hp >= $this->maxhp) $hp = $this->maxhp;
		$this->hp = $hp;
		$need = $this->maxhp - $hp;
		$coef = 1;
		if ($this->level == 1) {
			$coef = 6;
		}
		$time = ($need * (self::RECOVERY_TIME / $coef)) / ($this->maxhp / self::RECOVERY_SPEED);
		$this->healtime = time() + $time;
		if ($this->id > 0) {
			$this->sql->query("UPDATE player SET healtime = " . $this->healtime . " WHERE id = " . $this->id);
		}
	}

	public function setMaxHP($maxhp) {
		$hp = $this->loadHP();
		if ($maxhp < $hp) $hp = $maxhp;

		$this->maxhp = $maxhp;
		$this->setHP($hp);
	}

	public function updateHomeSalary() {
		if ($this->is_home_available) {
			$time = mktime(date("H"), $this->id % 5, $this->id % 60);
			$count = $time - $this->homesalarytime;
			$count = floor($count / 3600);
			if ($count > 0) {
				if ($this->state == "police" || $this->accesslevel < 0) {
					$count = 0;
				}
				$this->homesalarytime = $time;
				Page::$sql->query("UPDATE player SET homesalarytime = " . $time . ", money = money + " . $count . " * (home_price * (100 + home_comfort * 10) / 100) WHERE id = " . $this->id);
			}
			if ($count > 0) {
				$this->money = Page::$sql->getValue("SELECT money FROM player WHERE id = " . $this->id);
			}
		}
	}

	public function reloadFightTimer()
    {
		if (DEV_SERVER) {
			$this->lastfight = time() + 30;
		} elseif ($this->playboy == 1) {
			$this->lastfight = time() + 60 * 5;
		} else {
			$this->lastfight = time() + 60 * 15;
		}
	}

	/**
     * Экспорт информации персонажа для боя и лога боя
     *
     * @return array
     */
	public function exportForFight($werewolf = false)
	{
		$params = array(
            'id' => 'id',
            'fraction' => 'fr',
            'avatar' => 'av',
            'background' => 'bg',
            'nickname' => 'nm',
            'level' => 'lv',
            'health_finish' => 'h',
            'health' => 'h0',
            'strength_finish' => 's',
            'strength' => 's0',
            'dexterity_finish' => 'd',
            'dexterity' => 'd0',
            'attention_finish' => 'a',
            'attention' => 'a0',
            'resistance_finish' => 'r',
            'resistance' => 'r0',
            'intuition_finish' => 'i',
            'intuition' => 'i0',
            'charism_finish' => 'c',
            'charism' => 'c0',
            'statsum' => 'ss',
            'hp' => 'hp',
            'maxhp' => 'mhp',
            'ratingcrit' => 'rc',
            'ratingdodge' => 'rd',
            'ratingresist' => 'rr',
            'ratinganticrit' => 'rac',
            'ratingdamage' => 'rdm',
            'ratingaccur' => 'ra',
            'skillgranata' => 'skgr',
            'komplekt' => 'kt',
            'sex' => 'sx',
			'percent_dmg' => 'pdmg',
			'percent_defence' => 'pdef',
			'percent_hit' => 'phit',
			'percent_dodge' => 'pdod',
			'percent_crit' => 'pcrt',
			'percent_anticrit' => 'pacrt'
        );
		$object = array();
		foreach ($params as $long => $short) {
            if ($long == 'fraction' || $long == 'sex') {
                $object[$short] = $this->{$long}{0};
            } elseif ($short == 'av' || $short == 'nm' || $short == 'bg') {
                $object[$short] = $this->{$long};
            } else {
                $object[$short] = (int)$this->{$long};
            }
		}
        $object['ss'] = $object['h'] + $object['s'] + $object['d'] + $object['a'] + $object['r'] + $object['i'] + $object['c'];

		if ($this->state != 'werewolf' && !$werewolf) {
			// avatar
			if ($this->forum_avatar > 0 && $this->forum_avatar_checked == 1) {
				$object['im'] = '/@images/' . Page::sqlGetCacheValue("SELECT path FROM stdimage WHERE id = " . $this->forum_avatar, 86400, 'stdimage_path_' . $this->forum_avatar);
			} else {
				foreach (Page::$data['classes'] as $key => $cur) {
					if ($cur['avatar'] == $this->avatar) {
						$object['im'] = '/@/images/pers/' . $cur['thumb'];
					}
				}
			}

			// бусты
			$clanId = is_numeric($this->clan) ? $this->clan : $this->clan->id;
			$boosts = $this->loadBoosts();
			if ($boosts) {
				foreach ($boosts as $boost) {
					if ($boost['type'] == 'stat' || $boost['type'] == 'rating') {
						$object[Page::$data['ratings'][$boost['code']]['short']] += $boost['value'];
					}
				}
			}

			// Загрузка автомобильных бустов
            $sqlQuery = "SELECT percent_dmg, percent_defence, percent_hit, percent_dodge, percent_crit, percent_anticrit FROM playerboost2 WHERE type='automobile_ride' AND player = " . $this->id;
			$automobileBoosts = Page::$sql->getRecordSet($sqlQuery);
			if (is_array($automobileBoosts)) {
				foreach ($automobileBoosts as $aboost) {
					foreach ($aboost as $key => $val) {
						$object[$params[$key]] += intval($val * 1000);
					}
				}
			}


			// клан
			if ($this->clan > 0 && $this->clan_status != 'recruit') {
				Std::loadMetaObjectClass('clan');
				$clan = new clanObject;
				$clan->load($this->clan);
				$object['cl'] = $clan->exportForDB();
				$object['cls'] = $this->clan_status;
				$object['rdm'] += Page::$data['clan']['upgrades_ratings'][$clan->attack-1] * 5;
				$object['rr'] += Page::$data['clan']['upgrades_ratings'][$clan->defence-1] * 5;
			}
			
			// инвентарь
			$mfs = array();
			foreach ($this->inventory as $item) {
				if ($item->equipped == 1) {
					$object['equipped'][$item->type] = array(
						'si'  => (int)$item->standard_item,
						'h'   => (float)$item->health,
						's'   => (int)$item->strength,
						'd'   => (int)$item->dexterity,
						'a'   => (int)$item->attention,
						'r'   => (int)$item->resistance,
						'i'   => (int)$item->intuition,
						'c'   => (int)$item->charism,
						'rc'  => (int)$item->ratingcrit,
						'rd'  => (int)$item->ratingdodge,
						'rr'  => (int)$item->ratingresist,
						'rac' => (int)$item->ratinganticrit,
						'rdm' => (int)$item->ratingdamage,
						'ra'  => (int)$item->ratingaccur,
						'mf'  => (int)$item->mf,
					);
					for ($i = 0; $i < 8; $i++) {
						if ($item->{'special' . $i} != '') {
							$object['equipped'][$item->type]['sp' . $i] = $item->{'special' . $i};
							$object['equipped'][$item->type]['sp' . $i . 'n'] = $item->{'special' . $i . 'name'};
						}
					}

					if (in_array($item->slot, array('cloth','weapon','hat','shoe','pouch','accessory1'))) {
						$mfs[] = $item->mf;
					}

				}

			}
			sort($mfs);
			$object["ktmf"] = $mfs[0];

			$this->loadPet();
		} else {
			$object['im'] = '/@/images/pers/npc2_thumb.png';
		}


        // питомец
		if (is_a($this->pet, 'petObject')) {
			$object['pet'] = $this->pet->exportForFight();
		}

		return $object;
	}

    /**
     * Экспорт информации персонажа для боя и лога боя
     *
     * @return array
     */
	public function exportForGroupFight()
	{
		$this->loadHP();
        $params = array(
            'id' => 'id',
            'fraction' => 'fr',
            'nickname' => 'nm',
            'level' => 'lv',
            'health_finish' => 'h',
            'strength_finish' => 's',
            'dexterity_finish' => 'd',
            'attention_finish' => 'a',
            'resistance_finish' => 'r',
            'intuition_finish' => 'i',
            'charism_finish' => 'c',
            'statsum' => 'ss',
            'hp' => 'hp',
            'maxhp' => 'mhp',
            'ratingcrit' => 'rc',
            'ratingdodge' => 'rd',
            'ratingresist' => 'rr',
            'ratinganticrit' => 'rac',
            'ratingdamage' => 'rdm',
            'ratingaccur' => 'ra',
            'skillgranata' => 'skgr',
        );

        $object = array();
		foreach ($params as $long => $short) {
            if ($long == 'fraction') {
                $object[$short] = $this->{$long}{0};
            } elseif ($short == 'nm') {
                $object[$short] = $this->{$long};
            } else {
                $object[$short] = (int)$this->{$long};
            }
		}
        $object['ss'] = $object['h'] + $object['s'] + $object['d'] + $object['a'] + $object['r'] + $object['i'] + $object['c']
			+ round(($object['rc'] + $object['rd'] + $object['rr'] + $object['rac'] + $object['rdm'] + $object['ra']) / 5);

        // бусты
        //$clanId = is_numeric($this->clan) ? $this->clan : $this->clan->id;
        $boosts = $this->loadBoosts();
        if ($boosts) {
            foreach ($boosts as $boost) {
                if ($boost['type'] == 'stat' || $boost['type'] == 'rating') {
                    $object[Page::$data['ratings'][$boost['code']]['short']] += $boost['value'];
                }
            }
        }

        // питомец
        if ($this->loadPet()) {
            $object['pet'] = $this->pet->exportForFight();
		}

        // клан
        if ($this->clan > 0 && $this->clan_status != 'recruit') {
			Std::loadMetaObjectClass('clan');
			$clan = new clanObject;
			$clan->load($this->clan);
			$object['cl'] = $clan->exportForDB();
			$object['cls'] = $this->clan_status;
			$object['rdm'] += Page::$data['clan']['upgrades_ratings'][$clan->attack-1] * 5;
			$object['rr'] += Page::$data['clan']['upgrades_ratings'][$clan->defence-1] * 5;
		}

		return $object;
	}

    /**
     * Загрузка бустов из таблицы boost
     *
     * @param int $type
     * @return mixed
     */
    public function loadBoosts($type = 1)
    {
        $fields = $type == 1 ? "type, code, value, info" : "sum(value)";
        $where = $type == 2 ? " AND type='rating' " : "";
        $queries = array("SELECT " . $fields . " FROM boost WHERE player=" . $this->id . $where,
            "SELECT " . $fields . " FROM boost WHERE fraction='" . $this->fraction . "'" . $where);
        if ($this->clan > 0 && $this->clan_status != 'recruit') {
            $queries[] = "SELECT " . $fields . " FROM boost WHERE clan=" . $this->clan . $where;
        }
        if ($type == 1) {
            return $this->sql->getRecordSet(implode(" UNION ", $queries));
        } elseif ($type == 2) {
            return $this->sql->getValue(implode(" UNION ", $queries));
        }
    }

    /**
     * Экспорт предметов для группового боя
     */
    public function exportGroupFightItems()
    {
        $maxDurability = $this->viphunt ? Page::$data["groupfights"]["itemsinslotviphunt"] : Page::$data["groupfights"]["itemsinslot"];
		if (DEV_SERVER) {
			$maxDurability = 99;
		}
        $maxSlots = $this->viphunt ? Page::$data["groupfights"]["slotsviphunt"] : Page::$data["groupfights"]["slots"];
        $items = $this->sql->getRecordSet("SELECT * FROM inventory WHERE player = " . $this->id . " AND usestate = 'fight' AND unlocked=1 
            ORDER BY level DESC LIMIT 0, " . $maxSlots);
        $fightItems = array();
        if ($items) {
            $filledSlots = 0;
            foreach ($items as $item) {
                $filledSlots++;
                $fightItems[$item['id']] = array(
                    'id'    => (int)$item['id'],
                    'name'  => $item['name'],
                    'image' => $item['image'],
                    'si'  => (int)$item['standard_item'],
                    'h'   => (float)$item['health'],
                    's'   => (int)$item['strength'],
                    'd'   => (int)$item['dexterity'],
                    'a'   => (int)$item['attention'],
                    'r'   => (int)$item['resistance'],
                    'i'   => (int)$item['intuition'],
                    'c'   => (int)$item['charism'],
                    'rc'  => (int)$item['ratingcrit'],
                    'rd'  => (int)$item['ratingdodge'],
                    'rr'  => (int)$item['ratingresist'],
                    'rac' => (int)$item['ratinganticrit'],
                    'rdm' => (int)$item['ratingdamage'],
                    'ra'  => (int)$item['ratingaccur'],
                    'mf'  => (int)$item['mf'],
                    'hp'  => (float)$item['hp'],
                    'drb' => (int)$item['durability'] > $maxDurability ? $maxDurability : (int)$item['durability'],
                );
                if ($item["code"] == "fight_cheese") {
                    $fightItems[$item['id']]["drb"] = 1;
                }
                for ($i = 0; $i < 8; $i++) {
                    if ($item['special' . $i] != '') {
                        $fightItems[$item['id']]['sp' . $i] = $item['special' . $i];
                        $name = explode("|", $item['special' . $i . 'name']);
                        $fightItems[$item['id']]['sp' . $i . 'n'] = $name[0];
                        if ($name[1] != "") {
                            $name = explode(";", $name[1]);
                            $fightItems[$item['id']]['sp' . $i . 'b'] = $name[0];
                            $fightItems[$item['id']]['sp' . $i . 'a'] = $name[1];
                        }
                    }
                }
            }
            while ($filledSlots < $maxSlots) {
                $fightItems[] = "";
				$filledSlots++;
            }
        }
        return $fightItems;
    }

	public function isPetExists() {
		return $this->sql->getValue("SELECT 1 FROM pet WHERE player = " . $this->id . " LIMIT 1") == false ? false : true;
	}

	public function loadActivePet($onlyAlive = false) {
		Std::loadMetaObjectClass('pet');
		$pet = new petObject();
		$sql = "SELECT id FROM pet WHERE player = " . $this->id . " and active = 1" . ($onlyAlive ? " and respawn_at < now()" : "");
		$id = $this->sql->getValue($sql);
		if (!$id) {
			return false;
		}
		$result = $pet->load($id);
		if ($result == false) {
			$this->pet = null;
			return false;
		}
		$this->pet = $pet;
		return $pet;
	}

	public function loadPet($useAutoFood = true, $recalcStats = true) {
		Std::loadMetaObjectClass('pet');
		$pet = new petObject();
		$sql = "SELECT id FROM pet WHERE player = " . $this->id . " and active = 1 and respawn_at < now()";
		$id = $this->sql->getValue($sql);
		if (!$id) {
			return false;
		}
		$result = $pet->load($id);
		if ($result == false) {
			$this->pet = null;
			return false;
		}
		$this->pet = $pet;
		return $pet;
	}

	public function loadPets() {
		//$petsId = CacheManager::get('player_pets_id', array('player_id' => $this->id));
		$petsId = Page::$sql->getValueSet("select id from pet where player = " . $this->id);

		if (!$petsId) {
			return array();
		}
		$res = CacheManager::getSet('pet_full', 'pet_id', $petsId);
		Std::loadMetaObjectClass('pet');
		$pets = array();
		foreach ($petsId as $id) {
			$pet = new petObject();
			$result = $pet->load($id);
			if ($result == false) {
				continue;
			}
			$pet->player = $this->id;
			$pets[] = $pet;
		}
		return $pets;
	}

    /**
     * Одеть/снять комплект
     *
     * @param bool $putOn
     */
    public function checkKomplekt()
    {
        $this->loadEquipped();
        $neededItems = array('cloth' => false, 'weapon' => false, 'hat' => false, 'shoe' => false, 'pouch' => false, 'accessory1' => false);
        $level = 0;
        foreach ($this->inventory as $item) {
            if (array_key_exists($item->slot, $neededItems) && $item->equipped) {
                if ($level == 0) {
                    $level = $item->level;
                }
                if ($level == $item->level) {
                    $neededItems[$item->slot] = true;
                }
            }
        }
        $komplekt = true;
        foreach ($neededItems as $slot => $equipped) {
            if (!$equipped) {
                $komplekt = false;
                break;
            }
        }
        if ($komplekt) {
            $this->sql->query("UPDATE player SET komplekt = " . $level . " WHERE id = " . $this->id);

            $item = $this->sql->getRecord("SELECT * FROM standard_item WHERE code = 'award_komplekt'");
            Std::loadMetaObjectClass("gift");
            $gift = new giftObject();
            $gift->player = $this->id;
            $gift->type = "award";
            $gift->name = str_replace("%level%", $level, $item["name"]);
            $gift->image = str_replace("%level%", $level, $item["image"]);
            $gift->info = $item["info"];
            $gift->code = $item["code"];
            $gift->unlocked = 1;
            $gift->anonymous = 1;
            $gift->save();

            Page::addAlert(PlayerLang::ALERT_KOMPLEKT, '<img src="/@/images/obj/set/' . $level . '.png" style="margin-right:10px;" align="left" />' . Lang::renderText(PlayerLang::ALERT_KOMPLEKT_TEXT, array('level' => $level)));
        }
    }

    /**
     * Получение данных о мастерстве
     *
     * @param array $profData
     * @param string $skill
     * @return array
     */
    public function getProf(&$profData, $skill)
    {
        for ($i = 0, $j = sizeof($profData); $i < $j; $i++) {
            $prof = $profData[$i];
            if ($prof['a'] <= $this->{$skill} && $prof['b'] >= $this->{$skill}) {
                break;
            }
        }
        $prof = array(
            'value'     => $this->{$skill} - $prof['a'],
            'nextlevel' => $prof['b'] - $prof['a'] + 1,
            'name'      => $prof['n'],
            'i'         => $i,
        );
        $prof['percent'] = min(round($prof['value'] / $prof['nextlevel'] * 100), 100);
        
        return $prof;
    }

    // действия с предметами в инвентаре

    public function loadItemByStandardId($id)
    {
		Std::loadMetaObjectClass('inventory');
		$item = new inventoryObject();
		$result = $item->loadByStandardId($id, $this->id);
		if ($result === false) {
			return false;
		}
		return $item;
	}

	public function loadItemByCode($code)
    {
		Std::loadMetaObjectClass('inventory');
		$item = new inventoryObject();
		$result = $item->loadByCode($code, $this->id);
		if ($result === false) {
			return false;
		}
		return $item;
	}

	public function loadItemById($id)
    {
		Std::loadMetaObjectClass('inventory');
		$item = new inventoryObject();
		$result = $item->load($id);
		if ($result === false) {
			return false;
		}
		if ($item->player != $this->id || $item->type2 == 'clan') {
			return false;
		}
		return $item;
	}

	public function getItemByStandard($id)
    {
		foreach ($this->inventory as $inventory) {
			if ($inventory->standard_item == $id) {
				return $inventory;
			}
		}
		return false;
	}

    public function getItemById($id)
    {
		foreach ($this->inventory as $inventory) {
			if ($inventory->id == $id) {
				return $inventory;
			}
		}
		return false;
	}

	public function getItemByType($type)
    {
		foreach ($this->inventory as $inventory) {
			if ($inventory->type == $type) {
				return $inventory;
			}
		}
		return false;
	}

    public function getEquippedItemByType($type)
    {
        foreach ($this->inventory as $inventory) {
			if ($inventory->type == $type && $inventory->equipped == 1) {
				return $inventory;
			}
		}
		return false;
    }

	public function getItemByCode($code) {
		foreach ($this->inventory as $inventory) {
			if ($inventory->code == $code) {
				return $inventory;
			}
		}
		return false;
	}

    public function isHaveItem($itemCode) {
		return $this->hasItem($itemCode);
	}

    public function hasItem($itemCode) {
        return $this->sql->getValue("SELECT count(1) FROM inventory i WHERE i.player = " . $this->id . " AND i.code='" . $itemCode . "'") ? true : false;
    }

	public function getItemForUseByCode($code, $extendedFields = array()) {
		$fields = array_merge(array('id', 'durability'), $extendedFields);
		$sql = "SELECT " . implode(", ", $fields) . " FROM inventory WHERE code = '" . $code . "' AND player = " . $this->id;
		$result = Page::$sql->getRecord($sql);
		return $result;
	}

	public function getItemsForUseByCode($codes, $extendedFields = array()) {
		$fields = array_merge(array('id', 'durability', 'code'), $extendedFields);
		$sql = "SELECT " . implode(", ", $fields) . " FROM inventory WHERE code IN ('" . implode("', '", $codes) . "') AND player = " . $this->id;
		$tmpResult = Page::$sql->getRecord($sql);
		$result = array();
		foreach ($tmpResult as $r) {
			$result[$r['code']] = $r;
		}
		return $result;
	}

	public function getItemForUseByType($type, $extendedFields = array()) {
		$fields = array_merge(array('id', 'durability', 'code', 'itemlevel'), $extendedFields);
		$sql = "SELECT " . implode(", ", $fields) . " FROM inventory WHERE type = '" . $type . "' AND player = " . $this->id /*. " ORDER BY itemlevel DESC LIMIT 1"*/;
		$result = Page::$sql->getRecordSet($sql);
		if ($result === false) {
			return false;
		}
		Std::sortRecordSetByField($result, 'itemlevel', 0);
		$r = reset($result);
		return $r;
	}

	public function useItemFast($item, $uses = 1) {
		if ($item['durability'] == $uses) {
			$sql = "DELETE FROM inventory WHERE id = " . $item['id'];
		} else {
			$item['durability'] -= $uses;
			$sql = "UPDATE inventory SET durability = " . ($item['durability']) . " WHERE id = " . $item['id'];
		}
		Page::$sql->query($sql);
	}

    /**
     * Запустить процесс работы: мак, патруль
     *
     * @param string $type
     * @param int $time
     * @param int $salary
     * @param int $exp
     * @param array $params
     */
    public function beginWork($type, $time, $salary, $exp = 0, $params = array())
    {
		Std::loadMetaObjectClass('playerwork');
		$playerwork = new playerworkObject;
		$playerwork->player = $this->id;
		$playerwork->endtime = time() + $time;
		$playerwork->salary = $salary;
		$playerwork->exp = $exp;
		$playerwork->type = $type;
		$playerwork->time = $time;
        $playerwork->params = json_encode($params);
		$playerwork->save();
	}

    /**
     * Запустить процесс работы (производства) в фоне: производство петриков, вип-тренировки
     *
     * @param string $type
     * @param int $time
     * @param array $params
     */
    public function beginBackgroundWork($type, $time, $params = array())
    {
		$this->beginWork($type, $time, 0, 0, $params);
	}

    /**
     * Проверка достаточности меда и руды
     *
     * @param $needed
     */
    public function isEnoughOreHoney($needed)
    {
		if ($this->ore + $this->honey < $needed) {
			return false;
		} else if ($this->ore >= $needed) {
            return 'ore';
        } else if ($this->ore == 0 && $this->honey >= $needed) {
			return 'honey';
		} else {
			return 'both';
		}
    }

    public function spendOreHoney($needed)
    {
		if ($this->ore + $this->honey < $needed) {
			return false;
		} elseif ($this->ore >= $needed) {
			$this->ore -= $needed;
			return 'ore';
		} elseif ($this->ore == 0 && $this->honey >= $needed) {
			$this->honey -= $needed;
			return 'honey';
		} else{
			$needed -= $this->ore;
			$this->ore = 0;
			$this->honey -= $needed;
			return 'both';
		}
	}

    /**
     * Проерка на подозрительность и отправка в тюрьму
     *
     * @return bool
     */
	public function suspicionTest()
	{
		if ($this->suspicion <= 0 || $this->relations_time >= time()) {
			return false;
		} else {
			if (mt_rand(1, 10) <= $this->suspicion) {
				$this->state = 'police';
				$this->timer = time() + 3 * 3600;
				$this->save($this->id, array(playerObject::$STATE, playerObject::$TIMER));
				Page::checkEvent($this->id, 'jail', $this->suspicion);
				return true;
			} else {
				return false;
			}
		}
	}

	public function exportForDB($needClan = false)
    {
		$result = array();
		if ($this->clan > 0 && $needClan && $this->clan_status != 'recruit') {
			Std::loadMetaObjectClass('clan');
			$clan = new clanObject;
			$clan->load($this->clan);
			$result['clan'] = $clan->exportForDB();
			$result['clan_status'] = $this->player->clan_status;
		}
		$result['id'] = $this->id;
		$result['nickname'] = $this->nickname;
		$result['level'] = $this->level;
		$result['fraction'] = $this->fraction;
		$result['avatar'] = $this->avatar;
		return $result;
	}

    /**
     * Экспорт информации персонажа для форума
     *
     * @return array
     */
	public function exportForForum()
    {
		$result = array();
		if ($this->clan > 0 && $this->clan_status != 'recruit') {
			Std::loadMetaObjectClass('clan');
			$clan = new clanObject;
			$clan->load($this->clan);
			$result['clan'] = $clan->exportForDB();
			$result['clan_status'] = $this->player->clan_status;
		}
		$result['id'] = $this->id;
		$result['nickname'] = $this->nickname;
		$result['level'] = $this->level;
		$result['fraction'] = $this->fraction;
		$result['avatar'] = $this->avatar;
		$result['accesslevel'] = $this->accesslevel;
		if ($this->forum_avatar > 0 && $this->forum_avatar_checked == 1) {
			$result['forum_avatar'] = Page::sqlGetCacheValue("SELECT path FROM stdimage WHERE id = " . $this->forum_avatar, 86400, 'stdimage_path_' . $this->forum_avatar);
		}
		return $result;
	}

    /**
     * Экспорт информации персонажа для логов
     *
     * @return array
     */
    public function exportForLogs()
    {
		$result = array();
		if ($this->clan > 0 && $this->clan_status != 'recruit') {
			Std::loadMetaObjectClass('clan');
			//$clan = new clanObject;
			//$clan->load($this->clan);
			//$result['cl'] = $clan->exportForDB();
			$result['cl'] = clanObject::staticExportForDB($this->clan);
			$result['cls'] = $this->player->clan_status;
		}
		$result['id'] = $this->id;
		$result['nm'] = $this->nickname;
		$result['lv'] = $this->level;
		$result['fr'] = $this->fraction{0};
		return $result;
	}

    /**
     * Экспорт данных игрока для логов
     *
     * @param int $id
     * @return array
     */
    public static function exportForLogs2($id)
    {
        $player = Page::$sql->getRecord("SELECT p.id, p.fraction, p.level, p.nickname, p.clan_status, c.id clan_id, c.name clan_name
            FROM player p LEFT JOIN clan c ON c.id = p.clan WHERE p.id = " . $id);
        return array(
            "id" => (int)$player["id"],
            "nm" => $player["nickname"],
            "lv" => (int)$player["level"],
            "fr" => $player["fraction"]{0},
            "cl" => $player["clan_id"] > 0 && $player["clan_status"] != "recruit" ? array(
                "id" => (int)$player["clan_id"],
                "nm" => $player["clan_name"],
            ) : "",
        );
    }

	public function triggerNewQuests($location = '') {
		if ($this->level > 2) {
			return array();
		}
		$newQuests = $this->sql->getRecordSet("SELECT qs.* FROM quest_standard qs WHERE
((`qs`.`level` = '') OR (`qs`.`level` <= " . $this->level . "))
AND ((`qs`.`location` = '') OR (`qs`.`location` = '" . $location . "'))
AND ((`qs`.`item` = '') OR ((SELECT COUNT(1) FROM `inventory` WHERE `code` = `qs`.`item` AND `player` = " . $this->id . ") >= 1))
AND (SELECT COUNT(1) FROM `player_quest` WHERE `player` = " . $this->id . " AND `quest` = qs.`id`) = 0
");
		if ($newQuests == false) {
			return array();
		}
		Std::loadMetaObjectClass('quest_standard');
		foreach ($newQuests as &$questArray) {
			if ($questArray['autostart'] == 1) {
				$quest = new quest_standardObject();
				$quest->init($questArray);
				$this->startQuest($quest);
			}
		}
		return $newQuests;
	}

	public function triggerExistingQuests($location = '') {
		/*$triggeredQuests = $this->sql->getRecordSet("SELECT pq.* FROM player_quest `pq` WHERE `pq`.`player` = " . $this->id . "
AND `pq`.`state` != 'finished'
AND ((`pq`.`level` = '') OR (`pq`.`level` <= " . $this->level . "))
AND ((`pq`.`location` = '') OR (`pq`.`location` = '" . $location . "'))
AND ((`pq`.`item` = '') OR ((SELECT COUNT(1) FROM `inventory` WHERE `code` = `pq`.`item` AND `player` = " . $this->id . ") >= 1))
ORDER BY `pq`.`priority` DESC
");*/
		$triggeredQuestsTmp = $this->sql->getRecordSet("SELECT pq.* FROM player_quest `pq`
WHERE `pq`.`player` = " . $this->id . " ");
		if ($triggeredQuestsTmp == false) {
			return array();
		}
		Std::sortRecordSetByField($triggeredQuestsTmp, "priority");
		$triggeredQuests = array();
		foreach ($triggeredQuestsTmp as $i => $q) {
			if ((int) $q['level'] > $this->level) {
				continue;
			}
			if ($q['location'] != '' && $q['location'] != $location) {
				continue;
			}
			if ($q['item'] != '') {
				if ($this->sql->getValue("SELECT 1 FROM `inventory` WHERE `code` = '" . $q['item'] . "' AND `player` = " . $this->id . "") === false) {
					continue;
				}
			}
			$triggeredQuests[] = $q;
		}
		if (count($triggeredQuests) == 0) {
			$triggeredQuests = array();
		} else {
			Std::loadMetaObjectClass('player_quest');
			foreach ($triggeredQuests as &$questArray) {
				Std::loadModule('quests/' . $questArray['codename']);
				if ($questArray['autostart'] == 1 && $questArray['state'] != 'finished') {
					$quest = new $questArray['codename'];
					$quest->init($questArray);
					$quest->player = $this;
					if ($quest->checkConditions($location)) {
						Runtime::set('quest/id', $questArray['id']);
						Runtime::set('quest/triggered_location', $location);
						Std::redirect('/quest/');
					}
				}
			}
		}
		return $newQuests;
	}

	public function startQuest($questStandard)
    {
		Std::loadMetaObjectClass('player_quest');
		Std::loadModule('quests/' . $questStandard->codename);
		$quest = new $questStandard->codename;
		$quest->player = $this->id;
		$quest->codename = $questStandard->codename;
		$quest->title = $questStandard->title;
		$quest->info = $questStandard->info;
		$quest->fraction = $questStandard->fraction;
		$quest->quest = $questStandard->id;
		$quest->state = 'started';
		$quest->priority = $questStandard->priority;
		$quest->start();
		$quest->save();
	}

	public function increaseXP($exp, $increaseLevel = true)
    {
		$this->exp += $exp;
		if ($increaseLevel && $this->exp >= Page::$data['exptable'][$this->level]) {
			$this->increaseLevel();
		}
	}

    /**
     * Level Up!
     *
     * @param int $level
     * @param bool $save
     */
	public function increaseLevel($level = 1, $save = false)
    {
		global $data;

        if ($this->exp >= $data['exptable'][$this->level]) {
			$this->exp -= $data['exptable'][$this->level];
		} else {
			$this->exp = 0;
		}
		$this->level += $level;
		
		$key = Page::signed($this->id);
		$userInfo = array();
		$userInfo[$key] = array();
		$userInfo[$key]["level"] = $this->level;
		Page::chatUpdateInfo($userInfo);

		$cachePlayer = Page::$cache->get("user_chat_" . $key);
		if ($cachePlayer) {
			$cachePlayer["level"] = $this->level;
			Page::$cache->set("user_chat_" . $key, $cachePlayer);
		}

		$this->data['wins_on_level'] = 0;
		$this->data = json_encode($this->data);
		if ($save == true) {
			$this->save($this->id, array(playerObject::$EXP, playerObject::$LEVEL, playerObject::$DATA));
		} else {
			$this->save($this->id, array(playerObject::$DATA));
		}
		$this->data = json_decode($this->data, true);
		
		$this->sql->query("update rating_player SET level = " . $this->level ." WHERE player = " . $this->id);
		$this->sql->query("update rating_player2 SET level = " . $this->level ." WHERE player = " . $this->id);
        if (class_exists('Page')) {
            Page::sendLog($this->id, 'level_up', array('level' => $this->level), 0);
			if ($this->referer == "gameleads" && $this->password != "d41d8cd98f00b204e9800998ecf8427e") {
				Page::$sql->query("INSERT INTO `gameleads`(`player`, `level`, `dt`) VALUES(" . $this->id . ", " . $this->level . ", NOW())");
			}
			Page::sendNotify($this->toArray(), 'levelup');
        }

        // обновление дохода от квартиры
		if ($this->level >= 3) {
			$this->updateHomeSalary();
			$this->sql->query("update player SET home_price = IF(FLOOR(" . $this->level ."/3)-1 < 0, 0, 40 * POW(2, FLOOR(" . $this->level . "/3)-1)) WHERE id=" . $this->id);
			$this->home_price = 40 * pow(2, floor($this->level / 3) - 1);
		}

        // начисление руды сэнсею
        if (is_numeric($this->referer)) {
            $this->sql->query("update player set ore=ore+1 where id=" . $this->referer);
			Page::sendLog($this->referer, 'stud_lvlup', array('p' => $this->exportForDB(true)));
			
			// проверка события для сенсея
			if ($this->level >= 4) {
				$p = $this->level * $this->level / ($this->level + 3) / ($this->level + 3) * ($this->level / 7) * 100;
				if (rand(1, 100) <= $p) {
					Page::checkEvent($this->referer, 'student_levelup');
				}
			}
        }

		$sql = "INSERT INTO marketing_lvlups (lvluptime, player, level) VALUES(" . time() . ", " . $this->id . ", " . $this->level . ")";
		Page::$sql->query($sql);
	}

	public function updateStat()
    {
	    /*
        $this->sql->query("update rating_player as rp set rp.moneygrabbed = rp.moneygrabbed + (select ifnull(sum(profit),0) from duel where winner = rp.player and time >= rp.lastupdate),
                                rp.moneylost = rp.moneylost + (select ifnull(sum(profit),0) from duel where (player1 = rp.player or player2 = rp.player) and winner != rp.player and time >= rp.lastupdate),
                                rp.wins = rp.wins + (select ifnull(count(1),0) from duel where winner = rp.player and time >= rp.lastupdate),
                                rp.referers = (select ifnull(count(1),0) from player where referer = rp.player),
								rp.lastupdate = UNIX_TIMESTAMP(NOW())
				where player = " . $this->id . " LIMIT 1");
        */
	}

    /**
     * Загрузка прав доступа модераторов
     *
     * @return array
     */
	public function loadAccess() {
		$access = CacheManager::get('player_access', array('player_id' => $this->id));
		$this->access = $access;
		return $access;
	}

    public function calcMaxHp()
    {
		$this->setMaxHP($this->health_finish * 10 + $this->resistance_finish * 4);
		return $this->maxhp;
    }

    /**
     * Пересчет характеристик персонажа и автоматическая корректировка
     *
     * @param object $obj
     * @param int $plus
     */
	public function calcStats($obj, $plus = 1) {
		if ($plus == 1) {
			$k = 1;
		} else {
			$k = -1;
		}

        $stats = array('attention', 'resistance', 'health', 'strength', 'dexterity', 'charism', 'intuition', 'ratingcrit', 'ratingdodge', 'ratingresist', 'ratinganticrit', 'ratingdamage', 'ratingaccur');
		if (is_object($obj)) {
			$statsValue = array();
			foreach ($stats as $s) {
				$statsValue[$s] = $obj->{$s};
			}
		} else {
			$statsValue = $obj;
		}

        $fields = array();
		if ((isset($obj->type) && $obj->type == 'drug2') || $statsValue['type'] == 'drug2') {
			if ($statsValue['type'] == 'drug2') {
				$this->ratingcrit += $k * $statsValue['ratingcrit'];
				$this->ratingdodge += $k * $statsValue['ratingdodge'];
				$this->ratingresist += $k * $statsValue['ratingresist'];
				$this->ratinganticrit += $k * $statsValue['ratinganticrit'];
				$this->ratingdamage += $k * $statsValue['ratingdamage'];
				$this->ratingaccur += $k * $statsValue['ratingaccur'];
			} else {
				$this->ratingcrit += $k * $statsValue['intuition'];
				$this->ratingdodge += $k * $statsValue['attention'];
				$this->ratingresist += $k * $statsValue['resistance'];
				$this->ratinganticrit += $k * $statsValue['charism'];
				$this->ratingdamage += $k * $statsValue['strength'];
				$this->ratingaccur += $k * $statsValue['dexterity'];
			}
			$fields = array(playerObject::$RATINGCRIT, playerObject::$RATINGDODGE, playerObject::$RATINGRESIST, playerObject::$RATINGANTICRIT, playerObject::$RATINGDAMAGE, playerObject::$RATINGACCUR);
        }/* elseif (isset($obj->type) && $obj->type == 'tech' && $obj->level > 2) {
            // изучаем астральные потоки энергии
		} */else {
			$sum = 0;
			$r = array();
			foreach ($stats as $s) {
				if (substr($s, 0, 6) == 'rating') {
					if (!isset($statsValue[$s]) || empty($statsValue[$s])) {
                        continue;
                    }
                    $this->{$s} += $k * $statsValue[$s];
                    $fields[] = playerObject::${strtoupper($s)};
                } else {
                    if (!isset($statsValue[$s]) || empty($statsValue[$s])) {
                        $sum += $this->{$s . '_finish'};
                        continue;
                    }
                    if ($statsValue[$s] < 0) {
                        //$k *= -1;
                    }
                    if (abs($statsValue[$s]) <= 0.1) {
                        $this->{$s . '_percent'} += $k * 1000 * $statsValue[$s];
						$r[$s . '_percent'] = $this->{$s . '_percent'};
                    } else {
                        $this->{$s . '_bonus'} += $k * $statsValue[$s];
						$r[$s . '_bonus'] = $this->{$s . '_bonus'};
                    }
                    $bonus = $this->flag_bonus;
                    $this->{$s . '_finish'} = ($this->{$s} + $this->{$s . '_bonus'} + $bonus) * (100 + $this->{$s . '_percent'}) / 100;
					$r[$s . '_finish'] = $this->{$s . '_finish'};
                    $sum += $this->{$s . '_finish'};
                    $fields[] = playerObject::${strtoupper($s) . '_BONUS'};
                    $fields[] = playerObject::${strtoupper($s) . '_FINISH'};
                    $fields[] = playerObject::${strtoupper($s) . '_PERCENT'};
                }
			}
			$this->setMaxHP($this->health_finish * 10 + $this->resistance_finish * 4);
			$fields[] = playerObject::$MAXHP;
			$fields[] = playerObject::$STATSUM;
			$this->statsum = $sum;
		}
        if (sizeof($fields) > 0) {
            $this->save($this->id, $fields);
        }
        $this->updateStatsum();
	}

    /**
     * Обновление счетчиков действий пользователя
     * 
     * @param int $type
     */
    public function updateOnlineCounters($type)
    {
        /*
        $counterId = $this->sql->getValue("SELECT id FROM onlinecounter WHERE player=" . $this->id . " AND dt='" . date('Y-m-d', time()) . "'");
        if (!$counterId) {
            $counterId = $this->sql->insert("INSERT INTO onlinecounter (player, level, dt, online, metro, duels)
                VALUES (" . $this->id . ", " . $this->level . ", '" . date('Y-m-d', time()) . "', 0, 0, 0)");
        }

        Runtime::set('onlinecounter', $counterId);

        switch ($type) {
            case ONLINECOUNTER_ONLINE: $counter = 'online'; break;
            case ONLINECOUNTER_METRO: $counter = 'metro'; break;
            case ONLINECOUNTER_DUELS: $counter = 'duels'; break;
            case ONLINECOUNTER_AUTH: $counter = 'auth'; break;
        }
        
        $this->sql->query("UPDATE onlinecounter SET $counter=$counter+1 WHERE id=" . $counterId);
        */
    }

    /**
     * Пересчет суммы статов и крутости
     */
    public function updateStatsum()
    {
        $this->sql->query("UPDATE player SET statsum=health_finish + strength_finish + dexterity_finish + resistance_finish + intuition_finish + attention_finish + charism_finish WHERE id=" . $this->id);

        $clanId = is_numeric($this->clan) ? $this->clan : $this->clan->id;
        $ratingsNew = round($this->loadBoosts(2) / 5);

        $this->sql->query("UPDATE player SET statsum2=statsum + round((ratingcrit + ratinganticrit + ratingaccur + ratingdodge + ratingdamage + ratingresist)/5) + " . $ratingsNew . " WHERE id=" . $this->id);
    }

	/*
	 * Дать игроку предмет по коду предмета
	 *
	 * @param string $code
	 * @result bool
	 */
	public function giveItem($code) {
		Std::loadMetaObjectClass("standard_item");
		$item = new standard_itemObject();
		if (is_numeric($code)) {
			if ($item->load($code) == false) {
				return false;
			}
		} else {
			if ($item->loadByCode($code) == false) {
				return false;
			}
		}
		$item->makeExampleOrAddDurability($this->id);
		return true;
	}
	
	/*
	 * Сохраняет player.data
	 */
	public function saveData($fields = array()) {
		$fields[] = playerObject::$DATA;
		$this->data = json_encode($this->data);
		$this->save($this->id, $fields);
		$this->data = json_decode($this->data, true);
	}

	public function canBuyNewPet() {
		$sql = "SELECT count(1) FROM pet WHERE player = " . $this->id;
		$amount = $this->sql->getValue($sql);
		if ($amount < 3) {
			return true;
		} else {
			return false;
		}
	}
    /**
     * Получить массив валют игрока для логов
     *
     * @return array
     */
    public function getMbckp() {
        return array('m' => $this->money, 'o' => $this->ore, 'h' => $this->honey, 'n' => $this->oil);
    }

	/*public function save($id=0, $fields=false, $saveMerge='') {
		parent::save($id, $fields, $saveMerge);
		if (Page::$player->id == 1 && (@in_array(playerObject::$HEALTH_PERCENT, $fields) || $fields == false)) {
			Std::dump('saving player, health_percent: ' . $this->health_percent . '; debug: ' . print_r(xdebug_get_function_stack(), true));
		}

	}*/
}
?>