<?php

class diplomacyObject extends diplomacyBaseObject {

	private $accessLevels = array();

	public function __construct() {
		parent::__construct();
	}

	public function load($id, $loadParent = true) {
		$loaded = parent::load($id);

		if ($loaded && !CONTENTICO) {
			if ($this->parent_diplomacy) {
				if ($loadParent) {
					$this->load($this->parent_diplomacy);
				} else {
					$this->data = json_decode($this->sql->getValue("SELECT data FROM diplomacy WHERE id=" . $this->parent_diplomacy), true);
					$this->loadAllAccessLevels();
				}
			} else {
				$this->data = json_decode($this->data, true);
				$this->loadAllAccessLevels();
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Загрузка accesslevel всех участников войны (воюющих кланов)
	 */
	private function loadAllAccessLevels() {
		if (is_array($this->data['a']) && is_array($this->data['d'])) {
			$accessLevels = array_merge($this->loadPlayersAccesslevel($this->data['a']), $this->loadPlayersAccesslevel($this->data['d']));
			foreach ($accessLevels as $accessLevel) {
				$this->accessLevels[$accessLevel['id']] = $accessLevel['accesslevel'];
			}
		}
	}

	/**
	 * Заморозить себя во время подготовки к войне
	 *
	 * @param  $playerId
	 * @return bool
	 */
	public function freezePlayerDuringPausedWar($playerId, $state = -2) {
		if ($this->state != 'paused') {
			return false;
		}

		$playerSide = isset($this->data['a'][$playerId]) ? 'a' : (isset($this->data['d'][$playerId]) ? 'd' : false);
		if (!$playerSide) {
			return false;
		}

		// счетчик и лог убийства
		if (isset($this->data[$playerSide][$playerId])) {
			$this->data[$playerSide][$playerId]['al'] = $state;
		}

		$this->sql->query("UPDATE diplomacy SET data='" . json_encode($this->data) . "' WHERE id=" . $this->id);

		return true;
	}

	/**
	 * Установка счетчика убийств
	 *
	 * @param int $killedId
	 * @param int $kills
	 */
	public function setKills($killedId, $kills) {
		if ($this->state != 'step1') {
			return false;
		}

		$killedSide = isset($this->data['a'][$killedId]) ? 'a' : (isset($this->data['d'][$killedId]) ? 'd' : false);
		if (!$killedSide) {
			return false;
		}

		// счетчик и лог убийства
		if (isset($this->data[$killedSide][$killedId])) {
			$this->data[$killedSide][$killedId]['ks'] = $kills;
		}

		$this->sql->query("UPDATE diplomacy SET data='" . json_encode($this->data) . "' WHERE id=" . $this->id);

		return true;
	}

	/**
	 * Увеличение счетчика убийств
	 *
	 * @param int $killedId
	 * @param int $killerId
	 */
	public function addKills($killed, $killer, $duelLog = 0) {
		$killedId = $killed->id;
		$killerId = $killer->id;

		if ($this->state != 'step1') {
			return false;
		}

		$killedSide = isset($this->data['a'][$killedId]) ? 'a' : (isset($this->data['d'][$killedId]) ? 'd' : false);
		if (!$killedSide) {
			return false;
		}

		// проверка времени не нападения
		//$wpt = $this->data['wpt' . $killedSide];
		//$wpt = $this->data['wpt'];
		$wpt = $this->data['wpta'];
		if ((is_array($wpt) && sizeof($wpt) > 0) || (is_string($wpt) && $wpt != '')) {
			$hours = is_string($wpt) ? explode(',', substr($wpt, 0, -1)) : $wpt;
			for ($i = 0, $j = sizeof($hours); $i < $j; $i++) {
				$hours[$i] = $hours[$i] % 24;
			}

			$h = (int) date('H', time());
			$m = (int) date('i', time());

			if ($h == $hours[0] && $m >= 40) {
				return false;
			} elseif (sizeof($hours) == 1 && $h == (($hours[sizeof($hours) - 1] + 1) % 24) && $m < 40) {
				return 0;
			} elseif (sizeof($hours) == 2 && $h == ($hours[sizeof($hours) - 1] % 24) && $m < 40) {
				return 0;
			} elseif (sizeof($hours) > 2 && in_array($h, array_slice($hours, 1, (sizeof($hours) - 2)))) {
				return false;
			}
		}
		$wpt = $this->data['wptd'];
		if ((is_array($wpt) && sizeof($wpt) > 0) || (is_string($wpt) && $wpt != '')) {
			$hours = is_string($wpt) ? explode(',', substr($wpt, 0, -1)) : $wpt;
			for ($i = 0, $j = sizeof($hours); $i < $j; $i++) {
				$hours[$i] = $hours[$i] % 24;
			}

			$h = (int) date('H', time());
			$m = (int) date('i', time());

			if ($h == $hours[0] && $m >= 40) {
				return false;
			} elseif (sizeof($hours) == 1 && $h == (($hours[sizeof($hours) - 1] + 1) % 24) && $m < 40) {
				return 0;
			} elseif (sizeof($hours) == 2 && $h == ($hours[sizeof($hours) - 1] % 24) && $m < 40) {
				return 0;
			} elseif (sizeof($hours) > 2 && in_array($h, array_slice($hours, 1, (sizeof($hours) - 2)))) {
				return false;
			}
		}

		if ($this->data[$killedSide][$killedId]['ks'] >= 3) {
			return false;
		}

		// счетчик и лог убийства
		if (isset($this->data[$killedSide][$killedId])) {
			foreach ($this->data[$killedSide][$killedId]['kdby'] as $murder) {
				if ($murder['p'] == $killerId) {
					$killDt = strtotime($murder['dt']);
					//$killDt = DateTime::createFromFormat('Y-m-d H:i:s', $murder['dt']);
					$nowDt = time();
					//$nowDt = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time()));
					$diff = $nowDt - $killDt;
					//$diff = $nowDt->diff($killDt);
					// за последний день или раньше
					if ($diff < 24 * 60 * 60) {
						//if ($diff->days < 1) {
						// убийство не засчитывается, счетчики не меняются
						return false;
					}
				}
			}
			$this->data[$killedSide][$killedId]['ks']++;
			$this->data[$killedSide][$killedId]['kdby'][] = array('p' => $killerId, 'dt' => date('Y-m-d H:i:s', time()), 'dl' => $duelLog);
		}

		// счетчик и лог убийцы
		$killerSide = $killedSide == 'a' ? 'd' : 'a';
		if (isset($this->data[$killerSide][$killerId])) {
			$this->data[$killerSide][$killerId]['kd'][] = array('p' => $killedId, 'dt' => date('Y-m-d H:i:s', time()), 'dl' => $duelLog);
		} else {
			if (!isset($this->data[$killerSide . 'u'])) {
				$this->data[$killerSide . 'u'][$killerId] = array();
			}
			$this->data[$killerSide . 'u'][$killerId][] = array('p' => $killedId, 'dt' => date('Y-m-d H:i:s', time()), 'dl' => $duelLog);
		}

		$this->sql->query("UPDATE diplomacy SET data='" . json_encode($this->data) . "' WHERE id=" . $this->id);

		// зубы для победителя
		$code = 'war_zub';
		if ($killed->clan_status == 'founder') {
			$code = 'war_goldenzub';
		}
		Std::loadMetaObjectClass("standard_item");
		$item = new standard_itemObject();
		$item->loadByCode($code);
		$item->makeExampleOrAddDurability($killerId);

		return true;
	}

	/**
	 * Проверка: будет ли засчитано убийство в данный момент
	 *
	 * @param int $killedId
	 * @param int $killerId
	 * @return int
	 */
	public function canKillNow($killedId, $killerId) {
		if ($this->state != 'step1') {
			return 0;
		}

		$killedSide = isset($this->data['a'][$killedId]) ? 'a' : (isset($this->data['d'][$killedId]) ? 'd' : false);
		if (!$killedSide) {
			return 0;
		}

		// проверка времени не нападения
		//$wpt = $this->data['wpt' . $killedSide];
		//$wpt = $this->data['wpt'];
		$wpt = $this->data['wpta'];
		if ((is_array($wpt) && sizeof($wpt) > 0) || (is_string($wpt) && $wpt != '')) {
			$hours = is_string($wpt) ? explode(',', substr($wpt, 0, -1)) : $wpt;
			for ($i = 0, $j = sizeof($hours); $i < $j; $i++) {
				$hours[$i] = $hours[$i] % 24;
			}

			$h = (int) date('H', time());
			$m = (int) date('i', time());

			//Std::dump('can kill now check (h='.$h.' m='.$m.')');
			//Std::dump(' hours: '. json_encode($hours));
			if ($h == $hours[0] && $m >= 40) {
				//Std::dump('  hours condition 1');
				return 0;
			} elseif (sizeof($hours) == 1 && $h == (($hours[sizeof($hours) - 1] + 1) % 24) && $m < 40) {
				//Std::dump('  hours condition 2.1');
				return 0;
			} elseif (sizeof($hours) == 2 && $h == ($hours[sizeof($hours) - 1] % 24) && $m < 40) {
				//Std::dump('  hours condition 2.2');
				return 0;
			} elseif (sizeof($hours) > 2 && in_array($h, array_slice($hours, 1, (sizeof($hours) - 2)))) {
				//Std::dump('  condition 3 hours: ' . json_encode(array_slice($hours, 1, (sizeof($hours) - 2))));
				//Std::dump('  hours condition 3');
				return 0;
			}
		}
		$wpt = $this->data['wptd'];
		if ((is_array($wpt) && sizeof($wpt) > 0) || (is_string($wpt) && $wpt != '')) {
			$hours = is_string($wpt) ? explode(',', substr($wpt, 0, -1)) : $wpt;
			for ($i = 0, $j = sizeof($hours); $i < $j; $i++) {
				$hours[$i] = $hours[$i] % 24;
			}

			$h = (int) date('H', time());
			$m = (int) date('i', time());

			//Std::dump('can kill now check (h='.$h.' m='.$m.')');
			//Std::dump(' hours: '. json_encode($hours));
			if ($h == $hours[0] && $m >= 40) {
				//Std::dump('  hours condition 1');
				return 0;
			} elseif (sizeof($hours) == 1 && $h == (($hours[sizeof($hours) - 1] + 1) % 24) && $m < 40) {
				//Std::dump('  hours condition 2.1');
				return 0;
			} elseif (sizeof($hours) == 2 && $h == ($hours[sizeof($hours) - 1] % 24) && $m < 40) {
				//Std::dump('  hours condition 2.2');
				return 0;
			} elseif (sizeof($hours) > 2 && in_array($h, array_slice($hours, 1, (sizeof($hours) - 2)))) {
				//Std::dump('  condition 3 hours: ' . json_encode(array_slice($hours, 1, (sizeof($hours) - 2))));
				//Std::dump('  hours condition 3');
				return 0;
			}
		}

		if ($this->data[$killedSide][$killedId]['ks'] >= 3) {
			return 0;
		}

		// проверка повторных убийств
		if (isset($this->data[$killedSide][$killedId])) {
			foreach ($this->data[$killedSide][$killedId]['kdby'] as $murder) {
				if ($murder['p'] == $killerId) {
					$killDt = strtotime($murder['dt']);
					//$killDt = DateTime::createFromFormat('Y-m-d H:i:s', $murder['dt']);
					$nowDt = time();
					//$nowDt = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time()));
					$diff = $nowDt - $killDt;
					//$diff = $nowDt->diff($killDt);
					// за последний час или раньше
					if ($diff < 24 * 60 * 60) {
//Std::dump(' already killed in last 24 hours');
						//if ($diff->days < 1) {
						// убийство не засчитывается, счетчики не меняются
						return 0;
					}
				}
			}
		}

		return 1;
	}

	/**
	 * Увеличить счетчик побед в групповых боях во время второго этапа войны
	 *
	 * @param int $clanId
	 */
	public function addGroupFightWins($clanId) {
		$this->data['gf'][($clanId == $this->clan1 ? 'a' : 'd')]++;
		$this->data = json_encode($this->data);
		$this->save($this->id, array(diplomacyObject::$DATA));
		$this->data = json_decode($this->data, true);
	}

	/**
	 * Завершение второго этапа войны
	 *
	 * @param bool $forceFinish
	 */
	public function tryEndStep2($forceFinish = false) {
		if ($this->state == 'step2') {
			$groupFightsLeft = $this->getGroupFightsLeft();

			$finished = false;
			if ($this->data['gf']['a'] > $this->data['gf']['d'] && ($this->data['gf']['a'] - $this->data['gf']['d'] > $groupFightsLeft || $groupFightsLeft == 0)) {
				$this->finishWar(true, false);
				$finished = true;
			} elseif ($this->data['gf']['d'] > $this->data['gf']['a'] && ($this->data['gf']['d'] - $this->data['gf']['a'] > $groupFightsLeft || $groupFightsLeft == 0)) {
				$this->finishWar(false, true);
				$finished = true;
			} elseif ($forceFinish) {
				$finished = true;
				if ($this->data['gf']['a'] > $this->data['gf']['d']) {
					$this->finishWar(true, false);
				} elseif ($this->data['gf']['d'] > $this->data['gf']['a']) {
					$this->finishWar(false, true);
				} else {
					$this->finishWar(false, false);
				}
			}

			if ($finished) {
				$this->data['st2'] = $this->data['w'];
				$this->data = json_encode($this->data);
				$this->save($this->id, array(diplomacyObject::$DATA));
				$this->data = json_decode($this->data, true);
			}
		}
	}

	/**
	 * Определение кол-ва оставшихся групповых боев
	 *
	 * @return int
	 */
	private function getGroupFightsLeft() {
		$endDt = strtotime($this->dt2);
		$nowDt = time();
		$diff = $endDt - $nowDt;

		$fightsLeft = 0;
		if ($diff > 60 * 60) {
			$h = date('H', time());
			$hours = is_string($this->data['wpt']) ? explode(',', substr($this->data['wpt'], 0, -1)) : $this->data['wpt'];
			for ($i = 0, $hoursLeft = floor($diff / 60 / 60); $i < $hoursLeft; $i++) {
				if (($h + 1) % 3 == 0 && !in_array($h % 24, $hours)) {
					$fightsLeft++;
				}
				$h++;
			}
		}
		return $fightsLeft;
	}

	/**
	 * Завершение первого этапа войны
	 * При победе защищающегося - завершение войны, атакующего - переход ко 2-му этапу
	 *
	 * @param bool $forceFinish
	 */
	public function tryEndStep1($forceFinish = false) {
		if ($this->state == 'step1') {
			if ($this->checkIfAttackerWinsStep1()) {
				$this->advanceWarToStep2();
				//$this->finishWar(true, false);
			} elseif ($this->checkIfDefenderWinsStep1() || $forceFinish) {
				$this->data['st1'] = $this->clan2;
				$this->data = json_encode($this->data);
				$this->save($this->id, array(diplomacyObject::$DATA));
				$this->data = json_decode($this->data, true);

				$this->finishWar(false, true);
			}
		}
	}

	/**
	 * Проверка: выиграл ли атакующий клан
	 *
	 * @return bool
	 */
	private function checkIfAttackerWinsStep1() {
		foreach ($this->data['d'] as $playerId => $player) {
			if (!$this->checkIfPlayerKilledEnoughTimes($playerId, 'd')) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Проверка: выиграл ли защищающийся клан
	 *
	 * @return bool
	 */
	private function checkIfDefenderWinsStep1() {
		foreach ($this->data['a'] as $playerId => $player) {
			if (!$this->checkIfPlayerKilledEnoughTimes($playerId, 'a')) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Проверка: достаточно ли раз убит противник
	 *
	 * @global array $data
	 * @param array $playersAccesslevels
	 * @param int $playerId
	 * @return bool
	 */
	private function checkIfPlayerKilledEnoughTimes($playerId, $playerSide) {
		global $data;

		return $this->accessLevels[$playerId] < 0 || $this->data[$playerSide][$playerId]['ks'] >= $data['diplomacy']['kills'] ? true : false;
	}

	/**
	 * Закгрузка accesslevel игроков
	 *
	 * @param array $players
	 * @return array
	 */
	private function loadPlayersAccesslevel($players) {
		$idList = array();
		foreach ($players as $playerId => $player) {
			$idList[] = $playerId;
		}
		return $this->sql->getRecordSet("SELECT id, accesslevel FROM player WHERE id IN (" . implode(',', $idList) . ")");
	}

	/**
	 * Переход ко второму этапу войны
	 */
	public function advanceWarToStep2() {
		Std::loadMetaObjectClass('clan');
		Std::loadModule('Clan');

		$this->state = 'step2';
		$this->data['st1'] = $this->clan1;

		$this->data = json_encode($this->data);
		$this->save($this->id, array(diplomacyObject::$STATE, diplomacyObject::$DATA));
		$this->data = json_decode($this->data, true);


		$this->sql->query("UPDATE diplomacy SET state='finished' WHERE parent_diplomacy=" . $this->id . " AND state='step1'");

		// логи игрокам (начало)
		Std::loadMetaObjectClass('clan');
		$attackerClan = new clanObject();
		$attackerClan->load($this->clan1);
		$defenderClan = new clanObject();
		$defenderClan->load($this->clan2);

		// логи кланам
		Clan::sendClanLog('ws2', array('c' => $defenderClan->exportForDB(), 'd' => $this->id), 0, $attackerClan->id);
		Clan::sendClanLog('ws2', array('c' => $attackerClan->exportForDB(), 'd' => $this->id), 0, $defenderClan->id);

		// логи союзникам
		$attackerUnionClans = $defenderUnionClans = array();
		$unions = $this->sql->getRecordSet("(SELECT d.clan1 'id', c.fraction FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.parent_diplomacy=" . $this->id . ")
            UNION (SELECT c.clan2 'id' FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.parent_diplomacy=" . $this->id . ")");
		if ($unions) {
			foreach ($unions as $clan) {
				if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
					continue;
				}
				if ($clan['fraction'] == $attackerClan->fraction) {
					$attackerUnionClans[] = $clan['id'];
					Clan::sendClanLog('ws2', array('c' => $defenderClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
				} elseif ($clan['fraction'] == $defenderClan->fraction) {
					$defenderUnionClans[] = $clan['id'];
					Clan::sendClanLog('ws2', array('c' => $attackerClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
				}
			}
		}

		// логи игрокам (продолжение)
		foreach ($this->data['a'] as $playerId => $player) {
			Page::sendLog($playerId, 'war_step2', array('c' => $defenderClan->exportForDB()));
		}
		$attackerUnions = $this->sql->getValueSet("
            SELECT id FROM player
            WHERE
                ((clan IN (SELECT clan1 FROM diplomacy WHERE clan2=" . $attackerClan->id . " AND type='union' AND state='accepted'))
                OR
                (clan IN (SELECT clan2 FROM diplomacy WHERE clan1=" . $attackerClan->id . " AND type='union' AND state='accepted')))
                AND clan_status != 'recruit' AND accesslevel>=0 AND clan IN (" . implode(',', $attackerUnionClans) . ")");
		if (is_array($attackerUnions) && count($attackerUnions))
		foreach ($attackerUnions as $player) {
			Page::sendLog($player, 'war_step2', array('c' => $defenderClan->exportForDB()));
		}

		foreach ($this->data['d'] as $playerId => $player) {
			Page::sendLog($playerId, 'war_step2', array('c' => $attackerClan->exportForDB()));
		}
		$defenderUnions = $this->sql->getValueSet("
            SELECT id FROM player
            WHERE
                ((clan IN (SELECT clan1 FROM diplomacy WHERE clan2=" . $defenderClan->id . " AND type='union' AND state='accepted'))
                OR
                (clan IN (SELECT clan2 FROM diplomacy WHERE clan1=" . $defenderClan->id . " AND type='union' AND state='accepted')))
                AND clan_status != 'recruit' AND accesslevel>=0 AND clan IN (" . implode(',', $defenderUnionClans) . ")");
		foreach ($defenderUnions as $player) {
			Page::sendLog($player, 'war_step2', array('c' => $attackerClan->exportForDB()));
		}
	}

	/**
	 * Переход к первому этапу войны
	 *
	 * @param int $warId
	 */
	public function advanceWarToStep1($warId) {
		Std::loadMetaObjectClass('clan');
		Std::loadModule('Clan');

		$this->state = 'step1';
		$this->save($this->id, array(diplomacyObject::$STATE));
		$this->sql->query("UPDATE diplomacy SET state='step1' WHERE parent_diplomacy=" . $this->id . " AND state='paused'");

		// удаление неподтвержденных предложений присоединиться к войне
		$this->sql->query("DELETE FROM diplomacy WHERE parent_diplomacy=" . $this->id . " AND state='proposal'");

		// логи игрокам (начало)
		$attackerClan = new clanObject();
		$attackerClan->load($this->clan1);
		$defenderClan = new clanObject();
		$defenderClan->load($this->clan2);

		// логи кланам
		Clan::sendClanLog('ws1', array('c' => $defenderClan->exportForDB(), 'd' => $this->id), 0, $attackerClan->id);
		Clan::sendClanLog('ws1', array('c' => $attackerClan->exportForDB(), 'd' => $this->id), 0, $defenderClan->id);

		// логи союзникам
		$attackerUnionClans = $defenderUnionClans = array();
		$unions = $this->sql->getRecordSet("(SELECT d.clan1 'id', c.fraction FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.parent_diplomacy=" . $this->id . ")
            UNION (SELECT c.clan2 'id' FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.parent_diplomacy=" . $this->id . ")");
		if ($unions) {
			foreach ($unions as $clan) {
				if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
					continue;
				}
				if ($clan['fraction'] == $attackerClan->fraction) {
					$attackerUnionClans[] = $clan['id'];
					Clan::sendClanLog('ws1', array('c' => $defenderClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
				} elseif ($clan['fraction'] == $defenderClan->fraction) {
					$defenderUnionClans[] = $clan['id'];
					Clan::sendClanLog('ws1', array('c' => $attackerClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
				}
			}
		}

		// логи игрокам (продолжение)
		foreach ($this->data['a'] as $playerId => $player) {
			Page::sendLog($playerId, 'war_step1', array('c' => $defenderClan->exportForDB()));
		}
		$attackerUnions = $this->sql->getValueSet("
            SELECT id FROM player
            WHERE
                ((clan IN (SELECT clan1 FROM diplomacy WHERE clan2=" . $attackerClan->id . " AND type='union' AND state='accepted'))
                OR
                (clan IN (SELECT clan2 FROM diplomacy WHERE clan1=" . $attackerClan->id . " AND type='union' AND state='accepted')))
                AND clan_status != 'recruit' AND accesslevel>=0 AND clan IN (" . implode(',', $attackerUnionClans) . ")");
		if (!empty($attackerUnions))
		foreach ($attackerUnions as $player) {
			Page::sendLog($player, 'war_step1', array('c' => $defenderClan->exportForDB()));
		}

		foreach ($this->data['d'] as $playerId => $player) {
			Page::sendLog($playerId, 'war_step1', array('c' => $attackerClan->exportForDB()));
		}
		$defenderUnions = $this->sql->getValueSet("
            SELECT id FROM player
            WHERE
                ((clan IN (SELECT clan1 FROM diplomacy WHERE clan2=" . $defenderClan->id . " AND type='union' AND state='accepted'))
                OR
                (clan IN (SELECT clan2 FROM diplomacy WHERE clan1=" . $defenderClan->id . " AND type='union' AND state='accepted')))
                AND clan_status != 'recruit' AND accesslevel>=0 AND clan IN (" . implode(',', $defenderUnionClans) . ")");
		if (!empty($defenderUnions))
		foreach ($defenderUnions as $player) {
			Page::sendLog($player, 'war_step1', array('c' => $attackerClan->exportForDB()));
		}
	}

	/**
	 * Капитуляция
	 *
	 * @param int $clanId
	 */
	public function surrender($clanId) {
		$winnerClan = new clanObject();
		if ($this->clan1 == $clanId) {
			$this->finishWar(false, true);
			$winnerClan->load($this->clan2);
		} elseif ($this->clan2 == $clanId) {
			$this->finishWar(true, false);
			$winnerClan->load($this->clan2);
		}

		// логи союзникам
		$unions = $this->sql->getRecordSet("(SELECT d.clan1 'id', c.fraction FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.parent_diplomacy=" . $this->id . ")
            UNION (SELECT c.clan2 'id' FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.parent_diplomacy=" . $this->id . ")");
		if ($unions) {
			foreach ($unions as $clan) {
				Clan::sendClanLog('wsr', array('p' => self::$player->exportForLogs(), 'c' => $winnerClan->exportForDB()));
			}
		}
	}

	/**
	 * Автоматическое завершение войны, если на одной из все заморозились/заблокировались
	 */
	public function tryAutoSurrender($clanId) {
		if (Page::$sql->getValue("SELECT count(*) FROM player WHERE accesslevel=0 AND clan=" . $clanId) == 0) {
			$this->surrender($clanId);
		}
	}

	/**
	 * Завершение войны
	 *
	 * @param bool $attackerWins
	 * @param bool $defenderWins
	 */
	public function finishWar($attackerWins, $defenderWins) {
		Std::loadMetaObjectClass('clan');
		Std::loadMetaObjectClass('player');
		Std::loadModule('Clan');

		$logParams = array();

		if ($this->parent_diplomacy) {
			$clans = $this->sql->getValue("SELECT clan1, clan2 FROM diplomacy WHERE type='war' AND state='accepted' AND id=" . $this->parent_diplomacy);
			$attackerClanId = $clans['clan1'];
			$defenderClanId = $clans['clan2'];
		} else {
			$attackerClanId = $this->clan1;
			$defenderClanId = $this->clan2;
		}

		$attackerClan = new clanObject();
		$attackerClan->load($attackerClanId);
		$attackerClan->data = json_decode($attackerClan->data, true);

		$defenderClan = new clanObject();
		$defenderClan->load($defenderClanId);
		$defenderClan->data = json_decode($defenderClan->data, true);

		$logParams['money'] = $defenderClan->rmoney;
		$logParams['honey'] = $defenderClan->rhoney;
		$logParams['ore'] = $defenderClan->rore;

		$attackerUnionClans = $defenderUnionClans = array();

		if ($attackerWins) {
			$attackerClan->increasePoints(2);

			$logParams['aw'] = 1;
			$logParams['dw'] = 0;

			$attackerClan->money += $defenderClan->rmoney;
			$attackerClan->honey += $defenderClan->rhoney;
			$attackerClan->ore += $defenderClan->rore;

			$logParams2['m'] = $defenderClan->rmoney;
			$logParams2['h'] = $defenderClan->rhoney;
			$logParams2['o'] = $defenderClan->rore;
			$logParams2['wexp'] = 3;
			$logParams2['lexp'] = 1;

			$defenderClan->rmoney = 0;
			$defenderClan->rhoney = 0;
			$defenderClan->rore = 0;

			$attackerClan->money += $attackerClan->rmoney;
			$attackerClan->rmoney = 0;
			$attackerClan->honey += $attackerClan->rhoney;
			$attackerClan->rhoney = 0;
			$attackerClan->ore += $attackerClan->rore;
			$attackerClan->rore = 0;

			$this->data['w'] = $attackerClanId;

			$attackerClan->createDataArray('ww', 0);
			$attackerClan->data['ww']++;
			$defenderClan->createDataArray('wf', 0);
			$defenderClan->data['wf']++;

			// разрушение здания (начало)
			$upgrades = $this->sql->getRecordSet("SELECT id, name, money, ore, honey, itemlevel, code FROM inventory WHERE clan=" . $defenderClan->id . " AND (code='clan_attack' OR code='clan_defence')");
			if ($upgrades) {
				$upgrade = $upgrades[mt_rand(0, sizeof($upgrades) - 1)];
				$logParams2['dstr'] = $upgrade['name'];

				if ($upgrade['itemlevel'] == 1) {
					$this->sql->query("DELETE FROM inventory WHERE clan=" . $defenderClan->id . " AND code='" . $upgrade['code'] . "'");
				} else {
					$downgrade = $this->sql->getRecord("SELECT id, name, itemlevel, info, money, ore, honey, image FROM standard_item WHERE code='" . $upgrade['code'] . "' AND itemlevel<" . $upgrade['itemlevel'] . " ORDER BY itemlevel DESC LIMIT 0,1 ");
					$this->sql->query("UPDATE inventory SET
                        name='" . $downgrade['name'] . "',
                        itemlevel=" . $downgrade['itemlevel'] . ",
                        info='" . $downgrade['info'] . "',
                        money=" . $downgrade['money'] . ",
                        ore=" . $downgrade['ore'] . ",
                        honey=" . $downgrade['honey'] . ",
                        image='" . $downgrade['image'] . "',
                        standard_item=" . $downgrade['id'] . "
                        WHERE clan=" . $defenderClan->id . " AND code='" . $upgrade['code'] . "'");
				}
				if ($upgrade['code'] == 'clan_attack') {
					$defenderClan->attack--;
				} elseif ($upgrade['code'] == 'clan_defence') {
					$defenderClan->defence--;
				}
			}

			$logParams2['d'] = $this->id;

			// логи защищающемуся клану
			$logParams2['c'] = $attackerClan->exportForDB();
			Clan::sendClanLog('wf', $logParams2, 0, $defenderClan->id);

			// логи союзникам защищающегося клана
			$unions = $this->sql->getRecordSet("(SELECT d.clan1 'id', c.fraction FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.parent_diplomacy=" . $this->id . ")
                UNION (SELECT c.clan2 'id' FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.parent_diplomacy=" . $this->id . ")");
			if ($unions) {
				foreach ($unions as $clan) {
					if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
						continue;
					}
					if ($clan['fraction'] == $defenderClan->fraction) {
						$defenderUnionClans[] = $clan['id'];
						Clan::sendClanLog('wf2', array('c' => $attackerClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
					}
				}
			}

			// логи атакующему клану
			$logParams2['c'] = $defenderClan->exportForDB();
			$glava = new playerObject();
			$glava->load($attackerClan->founder);
			$logParams2['p'] = $glava->exportForLogs();
			$logParams['pts'] = 2;
			Clan::sendClanLog('ww', $logParams2, 0, $attackerClan->id);

			// логи союзникам атакующего клана
			if ($unions) {
				foreach ($unions as $clan) {
					if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
						continue;
					}
					if ($clan['fraction'] == $attackerClan->fraction) {
						$attackerUnionClans[] = $clan['id'];
						Clan::sendClanLog('ww2', array('c' => $defenderClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
					}
				}
			}

			// разрушение здания (конец)
			$attackerClan->money += round($upgrade['money'] * 0.7);
			$attackerClan->honey += round($upgrade['honey'] * 0.7);
			$attackerClan->ore += round($upgrade['ore'] * 0.7);

			$logParams2['m'] = round($upgrade['money'] * 0.7);
			$logParams2['h'] = round($upgrade['honey'] * 0.7);
			$logParams2['o'] = round($upgrade['ore'] * 0.7);

			Clan::sendClanLog('dstr', $logParams2, 0, $attackerClan->id);
		} elseif ($defenderWins) {
			$defenderClan->increasePoints(2);
			$logParams['aw'] = 0;
			$logParams['dw'] = 1;

			$defenderClan->money += $defenderClan->rmoney;
			$defenderClan->rmoney = 0;
			$defenderClan->honey += $defenderClan->rhoney;
			$defenderClan->rhoney = 0;
			$defenderClan->ore += $defenderClan->rore;
			$defenderClan->rore = 0;

			$defenderClan->money += $attackerClan->rmoney;
			$defenderClan->honey += $attackerClan->rhoney;
			$defenderClan->ore += $attackerClan->rore;

			$logParams2['m'] = $attackerClan->rmoney;
			$logParams2['h'] = $attackerClan->rhoney;
			$logParams2['o'] = $attackerClan->rore;
			$logParams2['wexp'] = 1;
			$logParams2['lexp'] = 1;

			$attackerClan->rmoney = 0;
			$attackerClan->rhoney = 0;
			$attackerClan->rore = 0;

			$this->data['w'] = $defenderClanId;

			$attackerClan->createDataArray('wf', 0);
			$attackerClan->data['wf']++;
			$defenderClan->createDataArray('ww', 0);
			$defenderClan->data['ww']++;

			$logParams2['d'] = $this->id;

			// логи атакующему клану
			$logParams2['c'] = $defenderClan->exportForDB();
			Clan::sendClanLog('wf', $logParams2, 0, $attackerClan->id);

			// логи союзникам атакующего клана
			$unions = $this->sql->getRecordSet("(SELECT d.clan1 'id', c.fraction FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.parent_diplomacy=" . $this->id . ")
                UNION (SELECT c.clan2 'id' FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.parent_diplomacy=" . $this->id . ")");
			if ($unions) {
				foreach ($unions as $clan) {
					if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
						continue;
					}
					if ($clan['fraction'] == $attackerClan->fraction) {
						$attackerUnionClans[] = $clan['id'];
						Clan::sendClanLog('wf2', array('c' => $defenderClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
					}
				}
			}

			// логи защищающему клану
			$logParams2['c'] = $attackerClan->exportForDB();
			$glava = new playerObject();
			$glava->load($defenderClan->founder);
			$logParams2['p'] = $glava->exportForLogs();
			$logParams2['pts'] = 2;
			Clan::sendClanLog('ww', $logParams2, 0, $defenderClan->id);

			// логи союзникам защищающегося клана
			if ($unions) {
				foreach ($unions as $clan) {
					if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
						continue;
					}
					if ($clan['fraction'] == $defenderClan->fraction) {
						$defenderUnionClans[] = $clan['id'];
						Clan::sendClanLog('ww2', array('c' => $attackerClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
					}
				}
			}
		} else {
			$logParams['aw'] = 0;
			$logParams['dw'] = 0;

			$defenderClan->money += $defenderClan->rmoney;
			$defenderClan->rmoney = 0;
			$defenderClan->honey += $defenderClan->rhoney;
			$defenderClan->rhoney = 0;
			$defenderClan->ore += $defenderClan->rore;
			$defenderClan->rore = 0;

			$defenderClan->money += $attackerClan->rmoney;
			$defenderClan->honey += $attackerClan->rhoney;
			$defenderClan->ore += $attackerClan->rore;

			$logParams2['m'] = $attackerClan->rmoney;
			$logParams2['h'] = $attackerClan->rhoney;
			$logParams2['o'] = $attackerClan->rore;
			$logParams2['wexp'] = 1;
			$logParams2['lexp'] = 1;

			$attackerClan->rmoney = 0;
			$attackerClan->rhoney = 0;
			$attackerClan->rore = 0;

			//$this->data['w'] = $defenderClanId;
			$this->data['w'] = 0;

			$attackerClan->createDataArray('we', 0);
			$attackerClan->data['we']++;
			$defenderClan->createDataArray('we', 0);
			$defenderClan->data['we']++;

			$logParams2['d'] = $this->id;

			// логи атакующему клану
			$logParams2['c'] = $defenderClan->exportForDB();
			Clan::sendClanLog('wea', $logParams2, 0, $attackerClan->id);

			// логи союзникам атакующего клана
			$unions = $this->sql->getRecordSet("(SELECT d.clan1 'id', c.fraction FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.parent_diplomacy=" . $this->id . ")
                UNION (SELECT c.clan2 'id' FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.parent_diplomacy=" . $this->id . ")");
			if ($unions) {
				foreach ($unions as $clan) {
					if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
						continue;
					}
					if ($clan['fraction'] == $attackerClan->fraction) {
						$attackerUnionClans[] = $clan['id'];
						Clan::sendClanLog('we2', array('c' => $defenderClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
					}
				}
			}

			// логи защищающемуся клану
			$logParams2['c'] = $attackerClan->exportForDB();
			Clan::sendClanLog('wed', $logParams2, 0, $defenderClan->id);

			// логи союзникам защищающегося клана
			if ($unions) {
				foreach ($unions as $clan) {
					if ($clan['id'] == $defenderClan->id || $clan['id'] == $attackerClan->id) {
						continue;
					}
					if ($clan['fraction'] == $defenderClan->fraction) {
						$defenderUnionClans[] = $clan['id'];
						Clan::sendClanLog('we2', array('c' => $attackerClan->exportForDB(), 'd' => $this->id), 0, $clan['id']);
					}
				}
			}
		}

		$attackerClan->createDataArray('wdt', '0000-00-00 00:00:00');
		$defenderClan->createDataArray('wdt', '0000-00-00 00:00:00');
		$attackerClan->data['wdt'] = $defenderClan->data['wdt'] = date('Y-m-d H:i:s', time());
		$attackerClan->createDataArray('wc', 0);
		$defenderClan->createDataArray('wc', 0);
		$attackerClan->data['wc'] = (int) $defenderClan->id;
		$defenderClan->data['wc'] = (int) $attackerClan->id;

		$attackerClan->data = json_encode($attackerClan->data);
		$defenderClan->data = json_encode($defenderClan->data);

		$attackerClan->attackdt = date("Y-m-d H:i:s", time() + 3600 * 24 * 2);
		$attackerClan->defencedt = date("Y-m-d H:i:s", time() + 3600 * 24);
		$attackerClan->state = '';
		$defenderClan->attackdt = date("Y-m-d H:i:s", time());
		$defenderClan->defencedt = date("Y-m-d H:i:s", time() + 3600 * 24 * 2);
		$defenderClan->state = '';

		$attackerClan->save($attackerClanId, array(clanObject::$MONEY, clanObject::$RMONEY, clanObject::$HONEY, clanObject::$RHONEY, clanObject::$ORE, clanObject::$RORE, clanObject::$DATA, clanObject::$ATTACKDT, clanObject::$DEFENCEDT, clanObject::$STATE, clanObject::$POINTS, clanObject::$LEVEL));
		$defenderClan->save($defenderClanId, array(clanObject::$MONEY, clanObject::$RMONEY, clanObject::$HONEY, clanObject::$RHONEY, clanObject::$ORE, clanObject::$RORE, clanObject::$DATA, clanObject::$ATTACK, clanObject::$DEFENCE, clanObject::$ATTACKDT, clanObject::$DEFENCEDT, clanObject::$STATE, clanObject::$POINTS, clanObject::$LEVEL));

		// логи игрокам атакующего клана
		foreach ($this->data['a'] as $playerId => $player) {
			$logParams['clan'] = $defenderClan->exportForDB();
			Page::sendLog($playerId, ($attackerWins ? 'we_win' : 'we_fail'), $logParams);
		}

		// логи игрокам защищающегося клана
		foreach ($this->data['d'] as $playerId => $player) {
			$logParams['clan'] = $attackerClan->exportForDB();
			Page::sendLog($playerId, ($attackerWins ? 'we_fail' : 'we_win'), $logParams);
		}

		// логи союзникам атакующего клана
		$attackerUnions = $this->sql->getValueSet("
            SELECT id FROM player
            WHERE
                ((clan IN (SELECT clan1 FROM diplomacy WHERE clan2=" . $attackerClan->id . " AND type='union' AND state='accepted'))
                OR
                (clan IN (SELECT clan2 FROM diplomacy WHERE clan1=" . $attackerClan->id . " AND type='union' AND state='accepted')))
                AND clan_status != 'recruit' AND accesslevel>=0 AND clan IN (" . implode(',', $attackerUnionClans) . ")");
		if ($attackerUnions) {
			foreach ($attackerUnions as $player) {
				$logParams['clan'] = $defenderClan->exportForDB();
				Page::sendLog($player, ($attackerWins ? 'they_win' : 'they_fail'), $logParams);
			}
		}

		// логи союзникам защищающегося клана
		$defenderUnions = $this->sql->getValueSet("
            SELECT id FROM player
            WHERE
                ((clan IN (SELECT clan1 FROM diplomacy WHERE clan2=" . $defenderClan->id . " AND type='union' AND state='accepted'))
                OR
                (clan IN (SELECT clan2 FROM diplomacy WHERE clan1=" . $defenderClan->id . " AND type='union' AND state='accepted')))
                AND clan_status != 'recruit' AND accesslevel>=0 AND clan IN (" . implode(',', $defenderUnionClans) . ")");
		if ($defenderUnions) {
			foreach ($defenderUnions as $player) {
				$logParams['clan'] = $attackerClan->exportForDB();
				Page::sendLog($player, ($attackerWins ? 'they_fail' : 'they_win'), $logParams);
			}
		}

		// удаление дипломатических отношений войны
		$this->sql->query("UPDATE diplomacy SET state='finished', data='" . json_encode($this->data) . "', dt2 = now() WHERE id=" . $this->id . " OR parent_diplomacy=" . $this->id);
	}

	public function startWar() {

	}

	/**
	 * Выход из войны (только для союзников)
	 */
	public function exitWar($clanId) {
		Std::loadMetaObjectClass('clan');

		$clan1 = new clanObject();
		$clan1->load($this->clan1);

		$clan2 = new clanObject();
		$clan2->load($this->clan2);

		$myClan = new clanObject();
		$myClan->load($clanId);

		$clans = $this->sql->getRecordSet("SELECT clan1, clan2 FROM diplomacy WHERE id = " . $this->id . " OR parent_diplomacy = " . $this->id);
		$clansId = array();
		foreach ($clans as $pair) {
			if (!in_array($pair['clan1'], $clansId)) {
				$clansId[] = $pair['clan1'];
			}
			if (!in_array($pair['clan2'], $clansId)) {
				$clansId[] = $pair['clan2'];
			}
		}

		$this->sql->query("DELETE FROM diplomacy WHERE parent_diplomacy = " . $this->id . " AND (clan1 = " . $clanId . " OR clan2 = " . $clanId . ")");

		foreach ($clansId as $id) {
			Clan::sendClanLog('wx', array('p' => Page::$player->exportForLogs(), 'c' => $myClan->exportForDB(),
						'c1' => $clan1->exportForDB(), 'c2' => $clan2->exportForDB()), 0, $id);
		}
	}

	public function acceptUnion() {

	}

	public function cancelUnion() {

	}

	public function proposeUnion() {

	}

	public function cancelProposeUnion() {

	}

	/**
	 * Сколько раз осталось убить этого игрока
	 *
	 * @global array $data
	 * @param int $playerId
	 * @return int
	 */
	public function getKillsLeft($playerId) {
		global $data;
		$killsLeft = 0;
		if ($this->state != 'step1') {
			return 0;
		}
		$playerSide = isset($this->data['a'][$playerId]) ? 'a' : 'd';
		if ($this->accessLevels[$playerId] >= 0 && isset($this->data[$playerSide][$playerId])) {
			$killsLeft = $data['diplomacy']['kills'] - $this->data[$playerSide][$playerId]['ks'];
		}
		return $killsLeft > 0 ? $killsLeft : 0;
	}

	public function getWarKillsStats($myClanId, $state = '') {
		global $data;

		if ($this->state == 'step1' || $state == 'step1') {
			$stats = array('enemieskilled' => 0, 'enemiestokill' => 0, 'enemiestotal' => 0,
				'alliaskilled' => 0, 'alliastokill' => 0, 'alliastotal' => 0, 'wewin' => 0,
				'alliastotalkills' => 0, 'enemiestotalkills' => 0);

			foreach ($this->data['a'] as $playerId => $player) {
				$stats[($this->clan1 == $myClanId ? 'alliastokill' : 'enemiestokill')] += $this->accessLevels[$playerId] < 0 ? 0 : $data['diplomacy']['kills'];
				$stats[($this->clan1 == $myClanId ? 'alliaskilled' : 'enemieskilled')] += $player['ks'] < $data['diplomacy']['kills'] ? $player['ks'] : $data['diplomacy']['kills'];

				if (!isset($player['al']) || $player['al'] >= 0) {
					$stats[($this->clan1 == $myClanId ? 'alliastotalkills' : 'enemiestotalkills')] += 3;
				}
			}
			foreach ($this->data['d'] as $playerId => $player) {
				$stats[($this->clan1 == $myClanId ? 'enemiestokill' : 'alliastokill')] += $this->accessLevels[$playerId] < 0 ? 0 : $data['diplomacy']['kills'];
				$stats[($this->clan1 == $myClanId ? 'enemieskilled' : 'alliaskilled')] += $player['ks'] < $data['diplomacy']['kills'] ? $player['ks'] : $data['diplomacy']['kills'];

				if ($player['al'] >= 0) {
					$stats[($this->clan2 == $myClanId ? 'alliastotalkills' : 'enemiestotalkills')] += 3;
				}
			}
			//$stats[($this->clan1 == $myClanId ? 'alliastokill' : 'enemiestokill')] = $data['diplomacy']['kills'] * sizeof($this->data['attackers']);
			//$stats[($this->clan1 == $myClanId ? 'enemiestokill' : 'alliastokill')] = $data['diplomacy']['kills'] * sizeof($this->data['defenders']);

			$stats['wewin'] = $stats['enemieskilled'] / $stats['enemiestokill'] >= $stats['alliaskilled'] / $stats['alliastokill'] ? 1 : 0;

			//$stats[($this->clan1 == $myClanId ? 'alliastotalkills' : 'enemiestotalkills')] = sizeof($this->data['a']) * 3;
			//$stats[($this->clan2 == $myClanId ? 'alliastotalkills' : 'enemiestotalkills')] = sizeof($this->data['d']) * 3;
		} elseif ($this->state == 'step2' || $state == 'step2') {
			$stats['wins'] = $this->data['gf'][($myClanId == $this->clan1 ? 'a' : 'd')];
			$stats['fails'] = $this->data['gf'][($myClanId == $this->clan1 ? 'd' : 'a')];
			$stats['wewin'] = $stats['wins'] >= $stats['fails'] ? 1 : 0;
		}

		return $stats;
	}

	/**
	 * Проверка: ведут ли эти два кланы войну между собой
	 *
	 * @param int $clan1
	 * @param int $clan2
	 * @return int - ID войны
	 */
	public static function areAtWar($clan1, $clan2) {
		$warId = Page::$sql->getValue("SELECT id FROM diplomacy WHERE type='war' AND (state='paused' OR state='step1' OR state='step2') AND
            ((clan1=" . $clan1 . " AND clan2=" . $clan2 . ") OR (clan1=" . $clan2 . " AND clan2=" . $clan1 . ")) AND parent_diplomacy=0");
		if (!$warId) {
			$warId = Page::$sql->getValue("SELECT id FROM diplomacy WHERE type='war' AND (state='paused' OR state='step1' OR state='step2') AND
                ((clan1=" . $clan1 . " AND clan2=" . $clan2 . ") OR (clan1=" . $clan2 . " AND clan2=" . $clan1 . "))");
		}
		return $warId;
	}

	/**
	 * Проверка: ведет ли клан войну
	 *
	 * @param int $clanId
	 * @return int - ID войны
	 */
	public static function isAtWar($clanId) {
		if ($clanId == 0) {
			return false;
		}
		$warId = Page::$sql->getValue("SELECT id FROM diplomacy FORCE INDEX (ix__diplomacy__state) WHERE type='war' AND (state='paused' OR state='step1' OR state='step2') AND (clan1=" . $clanId . " OR clan2=" . $clanId . ") AND parent_diplomacy=0");
		if (!$warId) {
			$warId = Page::$sql->getValue("SELECT id FROM diplomacy FORCE INDEX (ix__diplomacy__state) WHERE type='war' AND (state='paused' OR state='step1' OR state='step2') AND (clan1=" . $clanId . " OR clan2=" . $clanId . ")");
		}
		return $warId;
	}

	/**
	 * Проверка: можно ли использовать клановые предметы
	 * (можно только во время активной войны)
	 *
	 * @param int $clanId
	 * @return bool
	 */
	public static function isAtActiveWar($clanId) {
		return Page::$sql->getValue("SELECT id FROM diplomacy FORCE INDEX (ix__diplomacy__state) WHERE type='war' AND (state='step1' OR state='step2') AND (clan1=" . $clanId . " OR clan2=" . $clanId . ")");
	}

}

?>