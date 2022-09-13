<?php
class clanObject extends clanBaseObject
{
	public $players = array();
	public $recruits = array();
    public $inventory = array();
    public $inventoryAmount = 0;
    public $inventoryCapacity = 0;
    public $attack = 0;
    public $defence = 0;
    private $inventoryLoaded = false;

	public function __construct()
	{
		parent::__construct();
	}

    public function isAtWar() {
        return $this->sql->getValue("SELECT count(*) FROM diplomacy WHERE (clan1=" . $this->id ." OR clan2=" . $this->id . ") AND type='war' AND (state='paused' OR state='step1' OR state='step2')") > 0 ? true : false;
    }

    public function toArray()
	{
		$object = parent::toArray();
		$object['players'] = $this->players;
		$object['recruits'] = $this->recruits;
		return $object;
	}

	public function loadFull()
    {
        Std::loadLib('HtmlTools');

		$this->recruits = array();
        $this->players = array();
		$criteria = new ObjectCollectionCriteria ();
		$criteria->createWhere (playerObject::$CLAN, ObjectCollectionCriteria::$COMPARE_EQUAL, $this->id);
		$collection = new ObjectCollection();
		$players = $collection->getArrayList(playerObject::$METAOBJECT, $criteria, array('id', 'nickname', 'clan_status', 'clan_title', 'status', 'level', 'fraction', 'lastactivitytime', 'accesslevel'));
		if ($players == false) {
			return;
		}
		foreach ($players as $player) {
			if (strtotime($player['lastactivitytime']) >= time() - 900) {
				$player['status'] = 'online';
			} else {
				$player['status'] = 'offline';
			}
			$player['lastactivitytime'] = HtmlTools::FormatDateTime($player['lastactivitytime'], true, true, true);

            if ($player['clan_status'] == 'recruit') {
				$this->recruits[] = $player;
			} else {
				$player['clan'] = array('id' => $this->id, 'name' => $this->name);
				$this->players[] = $player;
			}
		}
	}

	public function exportForDB()
	{
		return array(
			'id' => (int)$this->id,
			'nm' => $this->name,
			'fr' => $this->fraction{0}
		);
	}
	
	public static function staticExportForDB($clanId) {
		$clan = Page::sqlGetCacheRecord("SELECT name, fraction FROM clan WHERE id = " . $clanId, 3600, 'clan_export_for_db_' . $clanId);
		return array(
			'id' => (int)$clanId,
			'nm' => $clan['name'],
			'fr' => $clan['fraction'][0]
		);
	}

    /**
     * Загрузка кланового инвентаря
     *
     * @return array
     */
    public function loadInventory()
    {
        if ($this->inventoryLoaded) {
			return $this->inventory;
		}

        Std::loadMetaObjectClass('inventory');

        $criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(inventoryObject::$CLAN, ObjectCollectionCriteria::$COMPARE_EQUAL, $this->id);
        $criteria->createWhere(inventoryObject::$PLAYER, ObjectCollectionCriteria::$COMPARE_EQUAL, 0);
		$criteria->where[] = "((`inventory`.`durability` > 0 AND `inventory`.`maxdurability` > 0) OR (`inventory`.`maxdurability` = 0))";

        $collection = new ObjectCollection();
		$inventory = $collection->getObjectList(inventoryObject::$METAOBJECT, $criteria);

        if ($inventory === false) {
			$this->inventory = array();
		} else {
			foreach ($inventory as $item) {
                if ($item->maxdurability > 0 && !isset($this->inventory[$item->code])) {
                    $this->inventoryAmount++;
                }
                $this->inventory[$item->code] = $item;
                switch ($item->code) {
                    case 'clan_warehouse':
                        $this->inventoryCapacity = $item->itemlevel;
                        break;

                    //case 'clan_attack':
                    //    $this->attack = $item->itemlevel;
                    //    break;

                    //case 'clan_defence':
                    //    $this->defence = $item->itemlevel;
                    //    break;
                }
			}
		}

		return $this->inventory;
    }

    /**
     * Служебная функция-костыль для генерации массива для хранения служебных данных клана
     *
     * @param <type> $key
     * @param <type> $value
     */
    public function createDataArray($key = '', $value = '')
    {
        if (!is_array($this->data)) {
            $this->data = array();
        }
        if ($key != '' && !isset($this->data[$key])) {
            $this->data[$key] = $value;
        }
    }

	/*
	 * Начисление клановых очков
	 *
	 * @param int $points
	 */
	public function increasePoints($points = 1) {
		$this->points += $points;
		if ($this->points < 0) {
			$this->points = 0;
		}
		if ($this->points >= Page::$data['clanexptable'][$this->level]) {
			$this->increaseLevel();
		}
	}

	/*
	 * Увеличение уровня клана
	 */
	public function increaseLevel() {
		if ($this->points > $data['exptable'][$this->level]) {
			$this->points -= $data['exptable'][$this->level];
		} else {
			$this->points = 0;
		}
		$this->level ++;
	}

	public function load($id) {
		$this->id = $id;
        $object = CacheManager::get('clan_full', array('clan_id' => $id));
		if ($object === false) {
			return false;
		}
        $this->init($object);
		return true;
	}

	public function save($id = 0, $fields = false, $saveMerge = '') {
		parent::save($id, $fields, $saveMerge);
		if ($id > 0) {
			CacheManager::updateData('clan_shortinfo', array('clan_id' => $id), array('id' => $id, 'name' => $this->name, 'level' => $this->level, 'fraction' => $this->fraction));
			CacheManager::updateData('clan_full', array('clan_id' => $id), $this->toArray());
		}
	}

	public static function increaseMoney($clanId, $money, $ore = 0, $honey = 0) {
		Page::$sql->query("UPDATE clan SET money = money + " . $money . ", ore = ore + " . $ore . ", honey = honey + " . $honey . " where id = " . $clanId);
		CacheManager::delete('clan_full', array('clan_id' => $clanId));
	}
}