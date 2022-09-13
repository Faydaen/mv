<?php
class petObject extends petBaseObject
{
	const RECOVERY_TIME = 60;
	const RECOVERY_SPEED = 360;

	public $dead = 0;
	
	public function __construct() {
		parent::__construct();
	}

	public function increaseSkill($skill, $pts = 1) {
		$this->{$skill} ++;
		$this->lasttrainduration = Petarena::getTrainTime($this->{$skill}) * 60;
		$this->train_at = date('Y-m-d H:i:s', time() + $this->lasttrainduration);
		
		$this->level = floor(($this->focus + $this->loyality + $this->mass) / 1500 * 80);

		$min = min($this->focus, $this->loyality, $this->mass);
		if ($min == 500) {
			$this->image = substr($this->image, 0, 6) . '-4.png';
		} else if ($min >= 200) {
			$this->image = substr($this->image, 0, 6) . '-3.png';
		} else if ($min >= 50) {
			$this->image = substr($this->image, 0, 6) . '-2.png';
		}

		$this->save(array(petObject::${strtoupper($skill)}, petObject::$LASTTRAINDURATION, petObject::$TRAIN_AT, petObject::$LEVEL, petObject::$IMAGE));
	}

	public function restore($increaseRestores = true) {
		if ($this->restores_today < mktime(0, 0, 0)) {
			$this->restores_today = mktime(0, 0, 0) + (int) $increaseRestores;
		} else {
			$this->restores_today += (int) $increaseRestores;
		}
		$this->train_at = date('Y-m-d H:i:s');
		$this->save(array(petObject::$RESTORES_TODAY, petObject::$TRAIN_AT));
	}

	public function setHP($hp, $mood = -1) {
		if ($hp <= 0) {
			$dead = 1;
			//$this->sql->query("DELETE FROM pet WHERE id = " . $this->id);
			Page::sendLog($this->player, 'pet_dead', array(), 0);
			//CacheManager::delete('pet_full', array('pet_id' => $this->id));
		}

		if ($hp >= $this->maxhp) {
			$hp = $this->maxhp;
		}
		$this->hp = $hp;
		$need = $this->maxhp - $hp;
		$time = ($need * self::RECOVERY_TIME) / ($this->maxhp / self::RECOVERY_SPEED);
		$this->healtime = time() + $time;
		if ($this->id > 0) {
			$f = array('healtime = ' . $this->healtime);
			if ($mood >= 0) {
				$mood = max(0, $mood);
				$this->mood = $mood;
				$f[] = 'mood = ' . $mood;
			}

			if ($dead == 1) {
				$f[] = "respawn_at = '" . date("Y-m-d H:i:s", time() + 84600*4) . "'";

				$sql = "SELECT id FROM pet WHERE player = " . $this->player . " and active = 0 AND respawn_at < now()";
				$newActive = Page::$sql->getValue($sql);
				if ($newActive) {
					$sql = "UPDATE pet SET active = 1 WHERE id = " . $newActive;
					Page::$sql->query($sql);
					CacheManager::delete('pet_full', array('pet_id' => $newActive));
					$f[] = 'active = 0';
				}
				$this->procent = max(30, $this->procent - 5);
				$f[] = "procent = " . $this->procent;
			}
			
			$sql = "UPDATE pet SET " . implode(', ', $f) . " WHERE id = " . $this->id;
			$this->sql->query($sql);
			$this->updateInCache();
		}
		
	}

	public function setMood($mood) {
		$this->mood = min(100, max(0, $mood));
		$this->lastmooddt = time();
		$this->save(array(petObject::$MOOD, petObject::$LASTMOODDT));
	}

	public function save($fields = array(), $newPet = false) {
		if (count($fields) == 0 && !CONTENTICO) {
			$fields = array(petObject::$NAME, petObject::$INFO);
		}

		$tmpp = $this->player;
		if (is_a($this->player, 'playerObject')) {
			$this->player = $tmpp->id;
		}
		
		if ($newPet) {
			$sql = "INSERT INTO pet (player) VALUE(" . $this->player . ")";
			$this->id = Page::$sql->insert($sql);
			$this->mood = 100;
		}

		parent::save($this->id, $fields);
		
		$this->player = $tmpp;

		$this->updateInCache();
		
	}
	
	public function updateInCache() {
		//$tmpp = $this->player;
		//if (!is_numeric($this->player)) {
		//	$this->player = $tmpp->id;
		//}
		if ($this->image == "N") {
			CacheManager::delete('pet_full', array('pet_id' => $this->id));
			return;
		}
		CacheManager::updateData('pet_full', array('pet_id' => $this->id), $this->toArray());
		//$this->player = $tmpp;
	}

	public function load($id, $cache = true) {
		$this->id = $id;
		if ($cache) {
			$object = CacheManager::get('pet_full', array('pet_id' => $id));
			if ($object === false) {
				return false;
			}
			if (is_array($object['player']) || $object['image'] == 'N' || $object['player'] == '' || strlen($object['name']) == 1) {
				CacheManager::delete('pet_full', array('pet_id' => $id));
				$object = CacheManager::forceReload('pet_full', array('pet_id' => $id));
				if ($object === false) {
					return false;
				}
			}
		} else {
			$object = Page::$sql->getRecord("SELECT * FROM pet WHERE id = " . $id);
			if ($object === false) {
				return false;
			}
			$this->updateInCache();
		}
		$this->init($object);
		if ($this->name == '' || substr($this->name, 0, 1) == '"') {
			if ($this->name != '') {
				$this->name = Page::$sql->getValue("SELECT name FROM standard_item WHERE id = " . $this->item) . ' ' . $this->name;
			} else {
				$this->name = Page::$sql->getValue("SELECT name FROM standard_item WHERE id = " . $this->item);
			}
			$this->updateInCache();
		}

		$this->onLoad();

		$this->id = $id;

		return true;
	}

	public function onLoad() {
		$time = time();
		if (strtotime($this->respawn_at) > time()) {
			$this->dead = 1;
		}
		if ($this->restores_today < mktime(0, 0, 0)) {
			$this->restores_today = mktime(0, 0, 0);
			$this->save(array(petObject::$RESTORES_TODAY));
		}
		if ($this->procent < 35) {
			$this->procent = 35;
			$this->save(array(petObject::$PROCENT));
		}
		if ($this->healtime <= $time || $this->healtime == 0) {
			$this->hp = $this->maxhp;
		} else {
		$this->hp = round($this->maxhp - (($this->healtime - $time) / self::RECOVERY_TIME) * ($this->maxhp / self::RECOVERY_SPEED));
	}
		if (Page::$player->id == $this->player) {
			if ($this->isRecalcNeeded(Page::$player) == true) {
				$this->calcStats(false, true);
			}
			$this->player = $this->player->id;
		}
	}

	public function getRestoresAvailable() {
		$max = 25;
		if ($this->restores_today < mktime(0, 0, 0)) {
			return $max;
		} else {
			return ($max + mktime(0, 0, 0) - $this->restores_today);
		}
	}

	public function getRestoresUsed() {
		$max = 25;
		return $max - $this->getRestoresAvailable();
	}

	public function changeName($name) {
		$currentName = $this->name;
		$name = preg_replace('/[^а-яёА-ЯЁa-zA-Z0-9\s\-]/u', '', $name);
		$name = mb_substr($name, 0, 30, 'UTF-8');
		$currentName = preg_replace('~ ".*"$~', '', $currentName);
		$currentName .= ($name == '' ? '' : ' "' . $name . '"');
		$this->name = $currentName;
		$this->save(array(petObject::$NAME));
	}

	public function setActive() {
		if ($this->active == 1) {
			return true;
		}
		
		$sql = "SELECT id FROM pet WHERE player = " . $this->player . " and active = 1";
		$id = $this->sql->getValue($sql);

		$sql = "UPDATE pet SET active = 0 WHERE id = " . $id . "";
		$this->sql->query($sql);

		CacheManager::delete('pet_full', array('pet_id' => $id));

		$this->active = 1;
		$this->save(array(petObject::$ACTIVE));
	}
	
    /**
     * Формирование массива данных питомца для боя и лога боя
     *
     * @return array
     */
	public function exportForFight()
    {
		if ($this->hp > 0 && $this->maxhp > 0) {
			$object = array(
                'nm' => $this->name,
                'im' => $this->image,
                'h' => (int)$this->health,
                's' => (int)$this->strength,
                'd' => (int)$this->dexterity,
                'a' => (int)$this->attention,
                'r' => (int)$this->resistance,
                'i' => (int)$this->intuition,
                'c' => (int)$this->charism,
                'hp' => (int)$this->hp,
                'mhp' => (int)$this->maxhp,
                'ss' => (int)($this->health + $this->strength + $this->dexterity + $this->attention + $this->resistance + $this->intuition + $this->charism),
                'lv' => (int)$this->level,
                't' => 'pet',
				'id' => (int)$this->id,
				'lo' => (int)$this->loyality,
				'fo' => (int)$this->focus,
				'ma' => (int)$this->mass
            );
			return $object;
		}
		return false;
	}

	public function isRecalcNeeded($player) {
		$this->player = $player;
		//if (time() - $this->lastrecalc > 600) {
		//	return true;
		//}
		if ($this->health != round(max(1, $this->player->health_finish * ($this->procent) / 100))
			|| $this->strength != round(max(1, $this->player->strength_finish * ($this->procent) / 100))
			|| $this->dexterity != round(max(1, $this->player->dexterity_finish * ($this->procent) / 100))
			|| $this->resistance != round(max(1, $this->player->resistance_finish * ($this->procent) / 100))
			|| $this->intuition != round(max(1, $this->player->intuition_finish * ($this->procent) / 100))
			|| $this->attention != round(max(1, $this->player->attention_finish * ($this->procent) / 100))
			|| $this->charism != round(max(1, $this->player->charism_finish * ($this->procent) / 100))
		) {
			return true;
		}
		return false;
	}

	public function calcStats($newPet = false, $useAutoFood = true) {
		$this->health = round(max(1, $this->player->health_finish * ($this->procent) / 100));
		$this->strength = round(max(1, $this->player->strength_finish * ($this->procent) / 100));
		$this->dexterity = round(max(1, $this->player->dexterity_finish * ($this->procent) / 100));
		$this->resistance = round(max(1, $this->player->resistance_finish * ($this->procent) / 100));
		$this->intuition = round(max(1, $this->player->intuition_finish * ($this->procent) / 100));
		$this->attention = round(max(1, $this->player->attention_finish * ($this->procent) / 100));
		$this->charism = round(max(1, $this->player->charism_finish * ($this->procent) / 100));
		$this->maxhp = round(max(1, (10 * $this->health + 4 * $this->resistance) * $this->player->pethpk));
		$this->lastrecalc = time();
		$fields = array(petObject::$HEALTH, petObject::$STRENGTH, petObject::$DEXTERITY, petObject::$RESISTANCE, petObject::$INTUITION, petObject::$ATTENTION, petObject::$CHARISM, petObject::$MAXHP, petObject::$LASTRECALC);
		if ($newPet == true) {
			$this->hp = $this->maxhp;
			$fields[] = petObject::$HP;
			$fields[] = petObject::$NAME;
			$fields[] = petObject::$INFO;
			$fields[] = petObject::$PLAYER;
			$fields[] = petObject::$IMAGE;
			$fields[] = petObject::$PROCENT;
			$fields[] = petObject::$REGEN;
		} else if ($this->hp > $this->maxhp) {
			$this->hp = $this->maxhp;
			$fields[] = petObject::$HP;
		}
		$this->save($fields);
        // автоаптечка
        Std::loadModule('Page');
        $playerId = is_object($this->player) && (int)$this->player->id > 0 ? $this->player->id : $this->player;
        if ($useAutoFood) {
            $this->usePetAutoFood();
        }
	}

	public static function deletePet($petId) {
		Page::$sql->query("DELETE FROM pet where id = " . $petId);
		CacheManager::delete('pet_full', array('pet_id' => $petId));
	}

	public function usePetAutoFood() {
		if ($this->hp <= 0 || strtotime($this->respawn_at) > time()) {
			return false;
}
		if ($this->active != 1) {
			return false;
		}
		$use100 = $use50 = false;
		if ($this->hp <= $this->maxhp * 0.25) {
			$use100 = true;
			$use50 = true;
		} else if ($this->hp <= $this->maxhp * 0.5) {
			$use50 = true;
		}

		if ($use100 === false && $use50 === false) {
			return false;
		}

		$data = array();
		$data['use100'] = (int) $use100;
		$data['use50'] = (int) $use50;

		if ($use100 === true && $use50 === true) {
			$codeWhere = "code IN ('petautofood_100', 'petautofood_50')";
		} else if ($use50 === true) {
			$codeWhere = "code = 'petautofood_50'";
		}
		if (is_numeric($this->player)) {
			$playerId = $this->player;
		} else {
			$playerId = $this->player->id;
		}
		$sql = "SELECT id, durability, code, special1, name FROM inventory WHERE " . $codeWhere . " AND player = " . $playerId;
		$result = Page::$sql->getRecordSet($sql);
		if (!is_array($result)) {
			return false;
		}
		if ($use100 === true) {
			Std::sortRecordSetByField($result, 'special1', 0);
		}
		$item = reset($result);
		$data['r'] = $item['special1'];
		$data['hp1'] = $this->hp;
		$hp = round($this->hp + ($this->maxhp * $item['special1'] / 100));
		$this->setHP($hp);
		$data['hp2'] = $this->hp;
		$data['i'] = $item['id'];
		$data['d'] = $item['durability'];
		$data['p'] = $this->id;
		$data['ra'] = $this->respawn_at;
		$query = "INSERT INTO petfood_log (player, type, dt, data) VALUES(" . $playerId . ", 2, now(), '" . addslashes(json_encode($data)) . "')";
		Page::$sql->query($query);
		Page::sendLog($playerId, 'item_autoused', array('name' => $item['name']), 0, 0, true);
		if ($item['durability'] == 1) {
			$sql = "DELETE FROM inventory WHERE id = " . $item['id'];
		} else {
			$item['durability'] --;
			$sql = "UPDATE inventory SET durability = " . ($item['durability']) . " WHERE id = " . $item['id'];
		}
		Page::$sql->query($sql);
		return true;
	}
}
?>
