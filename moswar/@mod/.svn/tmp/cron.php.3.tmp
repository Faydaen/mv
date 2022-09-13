<?php

set_time_limit(0);

class Cron extends Page implements IModule {

	public $moduleCode = 'Cron';

	public function __construct() {
		self::$data = $GLOBALS['data'];
		self::$cache = new Cache();
		self::$sql = SqlDataSource::getInstance();
		self::$__LOG_TABLE__ = 'log' . date('Ymd');
	}

	public function __destruct() {
		if (self::$cache != null) {
			self::$cache->close();
		}
	}

	public function processRequest() {
		Std::loadLang();

		switch ($this->shellArgs[0]) {

			case 'give':
				$this->give();
				break;

			case 'recalc':
				$this->recalc($this->shellArgs[1], $this->shellArgs[2]);
				break;

			case 'second30':
				self::quizHandler();
				break;

			case "gf_process_id": self::calcGroupFightStepById($this->shellArgs[1]);
				break;
			case "gf_start_id": self::startGroupFightById($this->shellArgs[1]);
				break;

			case "gf_process": self::calcGroupFightStep();
				break;

			case "gf_finish": self::finishGroupFights();
				break;

			case "gf_create_chaotic": self::chaoticGroupFightCreate();
				break;
			case "gf_start_chaotic": self::startGroupFights("chaotic");
				break;
			case "gf_process_chaotic": self::calcGroupFightStep("chaotic");
				break;

			case "gf_create_flag": self::flagGroupFightCreate();
				break;
			case "gf_start_flag": self::startGroupFights("flag");
				break;
			case "gf_process_flag": self::calcGroupFightStep("flag");
				break;

			case "gf_create_clanwar": self::clanGroupFightCreate();
				break;
			case "gf_start_clanwar": self::startGroupFights("clanwar");
				break;
			case "gf_process_clanwar": self::calcGroupFightStep("clanwar");
				break;

			case "gf_create_level": self::levelGroupFightCreate();
				break;
			case "gf_start_level": self::startGroupFights("level");
				break;
			case "gf_process_level": self::calcGroupFightStep("level");
				break;

			case "gf_create_bank": self::bankGroupFightCreate();
				break;
			case "gf_start_bank": self::startGroupFights("bank");
				break;
			case "gf_process_bank": self::calcGroupFightStep("bank");
				break;

			case "gf_create_metro": self::metroGroupFightCreate();
				break;
			case "gf_start_metro": self::startGroupFights("metro");
				break;
			case "gf_process_metro": self::calcGroupFightStep("metro");
				break;

			// раз в минуту
			case 'minute':
				self::removePerks();
				self::removePerkVotes();

				self::updateHuntStates(1);

				//self::endWorkPetriks();
				//self::endWorkMetro();
				//self::endWorkTraining();
				//self::endWorkPatrol();
				//self::endWorkMacdonalds();
				self::endWork();
				self::removeBoosts2();
				self::removeBoosts();

				if (date('i', time()) < 59 && date('i', time()) > 5) {
					self::removeExpiredItems();
				}

				// эта штука срабатывает, когда в контентике нажимают кнопку
				self::kickGroupFights();

				self::deleteOldLogs();

				self::sendPromo();

				self::checkWedding();
				break;

			// раз в 10 минут
			case 'minute10':
				self::metroGroupFightCreate();

				self::resetCarHoneyImprovements();

				self::updateHuntStates(2);

				if (date('i', time()) < 55 && date('i', time()) > 5) {
					self::updateRatingPlayerBattle();
					//self::removeExpiredItems();
					self::pyramidIsCrashed();
				}
				//self::deleteHalfPlayers();

				//self::freeFrozenInFightsPlayers();
				break;

			// раз в 15 минут
			case 'minute15':
				self::getTopPlayers();

				self::updateSovetSponsorsList();
				self::updateSovetLeadersList();

				self::updateOnline();
				//self::sendNotifiesToDeleting();
				break;

			// раз в час
			case 'hour':
				switch ($this->shellArgs[1]) {
					case 0:
						// 00:02 раз в сутки
						if (intval(date("H")) == 0) {
							self::casinoSportlotoRun();
							self::resetCasino();
							self::pyramidIncreaseCost();
						}
						// 01:02 раз в сутки
						if (intval(date("H")) == 1) {
							self::ratingClear('day');
						}
						// каждые 4 часа
						if (date("H") % 4 == 0) {
							self::pyramidRefreshStat();
						}
						//self::deleteUnconfirmedPlayers();
						break;

					case 1:
						self::finishWars();
						self::unpauseWars();
						self::sovetCalcTempResults();
						break;

					case 2:
						//self::addHomeSalary();
						self::giveClanRegCert();
						break;

					case 3:
						self::suspicion();
						break;

					case 4:
						self::unfreezeFrozen();
						break;

					case 10:
						//self::sendNotifiesToInactive();
						self::removePaidBackgrounds();
						break;

					case 30:
						//self::updateRatingPlayerBattle();
						self::calcAvgStats();
						//self::calcOnlineCountersStats();
						self::clearClanRests();
						//self::deleteInactivePlayers();
						break;

					case 35:
						self::updateRatingPlayerReferers();
						break;

					case 40:
						self::updateRatingFractions();
						break;

					case 45:
						self::updateRatingClans();
						break;

					case 50:
						//self::calcAvgStats();
						self::calcStatsForWerewolfs();
						self::calcCutAverageStats();
						break;
				}
				break;

			// раз в сутки
			case 'day':
				self::updateMaxLevels();
				self::addBankPercent();
				self::deleteOldHunts();
				self::clearDeletedAvatarRequests();

				self::sovetResetPlayer2Points();
				self::sovetSelectMembers();
				self::sovetSelectLeaders();
				self::sovetSelectStations();
				self::sovetCalcResults();
				self::sovetClearWarStats();

				self::deleteForgotten();

				self::decreaseClanPoints();

				self::updateActive();

				self::removePatrolBonuses();

				self::calcLevelGroups();
				self::createLogTable();
				break;

			// раз в неделю
			case 'week':
				self::ratingClear('week');
				break;

			// раз в месяц
			case 'month';
				self::ratingClear('month');
				self::updateStat();
				break;

			// тест

			case 'test':
				eval('self::' . $this->shellArgs[1] . '();');
				break;

			case 'test_bank_create':
				Std::loadModule('Fight');
				Std::loadModule('Bank');
				$levelMoney = Bank::getRobberyLevelMoney();
				$maxLevel = CacheManager::get('value_bankfightmaxlevel');
				// создание боев
				for ($i = 5; $i <= $maxLevel; $i++) {
					Fight::createFight('bank', $i, array('money' => $levelMoney[$i]));
				}
				break;

			case 'test_bank_start':
				self::startGroupFights("bank");
				break;

			case 'test_upddate_max_levels':
				self::updateMaxLevels();
				break;

			case 'test4':
				Std::loadModule('Bank');
				var_dump(Bank::getRobberyLevelMoney());
				break;

			case 'test7':
				self::calcAvgStats(true);
				break;

			case 'test_fight_create':
				Std::loadModule('Fight');
				echo Fight::createFight($this->shellArgs[1], $this->shellArgs[2]);
				break;

			case 'test_fight_start':
				Std::loadModule('Fight');
				Fight::startFight($this->shellArgs[1]);
				break;

			case 'test_send_notifies':
				$this->sendNotifiesToInactive();
				break;
		}
	}

	public static function createLogTable() {
		$dt = date('Ymd', time() + 86400);
		$query = "CREATE TABLE IF NOT EXISTS `log" . $dt . "` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `type2` varchar(255) NOT NULL DEFAULT '',
  `dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix__log__player` (`player`),
  KEY `ix__log__type` (`type`),
  KEY `ix__log__type2` (`type2`),
  KEY `ix__log__player_type` (`player`,`type`),
  KEY `ix__log__dt` (`dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		$result = Page::$sql->query($query);
	}

	public static function checkWedding() {
		$fightId = Page::$cache->get('wedding');
		if ($fightId == 0) {
			return;
		}

		$players = Page::chatGetPlayers("wedding");
		$i = 0;
		while ($players === false) {
			usleep(10000);
			$players = Page::chatGetPlayers("wedding");
			$i++;
			if ($i > 50) return;
		}

		$playersMin = 10;
		if (count($players) < $playersMin) {
			Page::chatSystemSend(Std::renderTemplate(PlayerAdminLang::ERROR_SMALL_PPL_IN_CHAT, array('player_min' => $playersMin)), "wedding");
			return;
		}
		/*
		$found = 0;
		foreach ($players as $pid) {
			if ($pid == $playerId || $pid == $player2Id) {
				$found ++;
			}
		}

		if ($found != 2) {
			Page::chatSystemSend(PlayerAdminLang::ERROR_NO_MARRIEDS_IN_CHAT, "wedding");
			return $result;
		}
		*/

		Page::chatSystemSend(Std::renderTemplate(PlayerAdminLang::OK_FIGHT_STARTING, array('fight_id' => $fightId)), "wedding");
		Std::loadModule('Fight');
		Std::loadMetaobjectClass('player');
		Std::loadMetaobjectClass('player2');
		Std::loadMetaobjectClass('fight');
		$good = 0;
		$query = "select player, count(1) as am from fightplayer fp left join fight f on f.id = fp.fight
			where f.dt > '" . date('Y-m-d') . " 00:00:00' and f.type = 'chaotic' and f.level = 0 and fp.player IN (" . implode(', ', $players) . ") group by player";
		$am = Page::$sql->getRecordSet($query);
		$am2 = array();
		if ($am) {
			foreach ($am as $v) {
				$am2[$v['player']] = $v['am'];
			}
		}
		foreach ($players as $pid) {
			if (isset($am2[$pid]) && $am2[$pid] > 3) {
				continue;
			}
			$result = Fight::joinFight($fightId, $pid);
			if ($result['result'] == 1) {
				$good ++;
			}
		}
		/*if ($good < $playersMin) {
			Page::chatSystemSend(Std::renderTemplate(PlayerAdminLang::ERROR_SMALL_PPL_IN_CHAT, array('player_min' => $playersMin)), "wedding");
			return;
		} else {
			
		}*/
		var_dump(Runtime::get('alerts'));
		if ($good >= 0) {
			Fight::startFight($fightId);
			Page::$cache->set('wedding', 0);
		}
		
	}

	public static function pyramidRefreshStat() {
		Std::loadModule('Pyramid');
		Pyramid::refreshStat();
	}

	public static function pyramidIncreaseCost() {
		Std::loadModule('Pyramid');
		Pyramid::increasePyramidPrice();
	}

	public static function pyramidIsCrashed() {
		Std::loadModule('Pyramid');
		$pyramid = Pyramid::getPyramid();
		if (($pyramid['pyramid_state'] == 'crashed' || ($pyramid['pyramid_partners_rt'] > 0 && $pyramid['pyramid_fond_rt'] < $pyramid['pyramid_cost'])) === false) {
			return;
		}
		
		if ($pyramid['pyramid_state'] == 'crashed') {
			$resetStartAt = false;
		} else {
			$resetStartAt = true;
		}
		
		if (Pyramid::$collectionId == 0) {
			echo 'No collection';
		} else {
			$query = "SELECT player FROM pyramid_partners WHERE pyramids > 0";
			$players = Page::$sql->getValueSet($query);
			foreach ($players as $p) {
				Page::giveCollectionElement($p, $collectionId);
			}
		}
		Pyramid::resetPyramid($resetStartAt);
	}

	public static function resetNpcStat() {
		$sql = "update player2 set npc_stat = 0 where npc_stat > 0";
		Page::$sql->query($sql);
	}

	public static function removePaidBackgrounds() {
		$sql = "SELECT player, oldbg FROM player_paidbg WHERE untildt < NOW()";
		$backs = Page::$sql->getRecordSet($sql);
		$players = array();
		foreach ($backs as $b) {
			$players[] = $b['player'];
			$sql = "UPDATE player SET background = 'avatar-back-" . $b['oldbg'] . "' WHERE id = " . $b['player'];
			Page::$sql->query($sql);
			Page::sendLog($b['player'], 'ncrp', array());
		}

		$sql = "DELETE FROM player_paidbg WHERE player IN (" . implode(", ", $players) . ")";
		Page::$sql->query($sql);
	}

	public static function resetCarHoneyImprovements() {
		Std::loadModule("Automobile");
		Automobile::initImprovements();
		$time = time();
		foreach (Automobile::$improvements as &$imp) {
			if (isset($imp["acts"]) && $imp["acts"] > 0) {
				$i = array();
				foreach ($imp["bonus"] as $key => $value) {
					$i[] = $key . "=" . $key . "-" . $value;
				}
				$i[] = "improvements = improvements - " . $imp["bit"];
				$i[] = "dt_" . $imp["bit"] . " = NULL";

				$sql = "UPDATE automobile_car SET " . implode(",", $i) . " WHERE dt_" . $imp["bit"] . " < " . $time;
				Page::$sql->query($sql);
			}
		}
	}

	public static function revertBonusBug() {
		$pl = json_decode('{"1":[">=5",1],"1298":["<5",2],"4486":[">=5",2],"6078":[">=5",3],"8959":[">=5",2],"20227":[">=5",1],"21901":[">=5",1],"26527":[">=5",1],"28548":[">=5",2],"33223":[">=5",1],"50743":[">=5",1],"51448":[">=5",2],"51917":[">=5",1],"65927":[">=5",1],"81050":[">=5",1],"83296":[">=5",0],"84944":[">=5",1],"85911":[">=5",1],"96738":[">=5",1],"100913":[">=5",1],"114327":[">=5",1],"115788":[">=5",2],"119862":[">=5",1],"119879":[">=5",1],"120672":[">=5",1],"124824":[">=5",1],"125247":[">=5",1],"140987":[">=5",2],"142247":[">=5",2],"144018":[">=5",1],"144197":[">=5",1],"150805":[">=5",3],"153311":[">=5",2],"155948":[">=5",1],"156508":[">=5",3],"158364":[">=5",1],"159895":[">=5",1],"163346":[">=5",1],"167034":[">=5",2],"167101":[">=5",2],"167503":[">=5",1],"168389":[">=5",1],"173218":[">=5",1],"173300":[">=5",2],"174185":[">=5",1],"179887":[">=5",1],"185912":[">=5",1],"191289":[">=5",2],"191336":[">=5",2],"196154":[">=5",1],"197781":[">=5",1],"198490":[">=5",1],"199630":[">=5",1],"202089":[">=5",1],"206192":[">=5",3],"207918":[">=5",1],"231815":[">=5",1],"233919":[">=5",3],"235008":[">=5",2],"238355":[">=5",2],"238401":[">=5",1],"240973":[">=5",2],"246694":[">=5",1],"247003":[">=5",1],"247750":[">=5",1],"249479":[">=5",2],"249995":[">=5",2],"252951":[">=5",3],"253605":[">=5",2],"255784":[">=5",2],"256557":[">=5",3],"258767":[">=5",1],"259922":[">=5",1],"264054":[">=5",1],"267434":[">=5",1],"267495":[">=5",1],"274511":[">=5",2],"275484":[">=5",2],"282215":[">=5",1],"291694":[">=5",2],"296097":[">=5",1],"299667":[">=5",1],"299973":[">=5",2],"301190":[">=5",3],"322542":[">=5",2],"323730":[">=5",3],"330181":[">=5",3],"331532":[">=5",1],"332751":[">=5",1],"346112":[">=5",0],"360000":[">=5",2],"361353":[">=5",1],"364121":[">=5",3],"366297":[">=5",1],"367202":[">=5",3],"370173":[">=5",1],"371865":[">=5",1],"377709":[">=5",2],"382819":[">=5",1],"387162":["<5",2],"390863":[">=5",2],"391243":[">=5",1],"393706":[">=5",2],"395676":[">=5",1],"396879":[">=5",2],"398887":[">=5",1],"399897":[">=5",1],"400087":[">=5",1],"404728":["<5",1],"404750":[">=5",1],"412376":[">=5",1],"413115":[">=5",1],"414706":[">=5",2],"420201":[">=5",1],"421573":[">=5",1],"422407":[">=5",1],"424897":[">=5",1],"426916":[">=5",1],"427330":[">=5",3],"428365":[">=5",1],"432496":[">=5",1],"435014":[">=5",1],"439302":[">=5",1],"447482":[">=5",1],"453853":[">=5",1],"470939":["<5",1],"477828":[">=5",1],"478765":[">=5",1],"494665":[">=5",1],"527582":[">=5",1],"527700":[">=5",1],"531392":[">=5",1],"532288":[">=5",2],"545874":[">=5",1],"552523":[">=5",1],"555965":[">=5",1],"558589":[">=5",1],"561594":[">=5",1],"567144":[">=5",1],"570946":[">=5",2],"581506":[">=5",1],"582870":[">=5",1],"583653":[">=5",1],"591587":[">=5",1],"592185":[">=5",1],"599764":["<5",2],"602290":[">=5",1],"603171":[">=5",1],"605277":[">=5",2],"606881":[">=5",1],"608407":[">=5",1],"611531":[">=5",2],"622733":[">=5",1],"623811":[">=5",1],"625923":[">=5",1],"633231":[">=5",1],"637281":[">=5",1],"637623":[">=5",1],"638612":[">=5",1],"645331":[">=5",1],"646805":[">=5",1],"647009":[">=5",2],"648346":[">=5",3],"649534":[">=5",1],"651489":[">=5",1],"676815":[">=5",1],"688459":["<5",2],"691663":[">=5",1],"695223":["<5",2],"695883":[">=5",1],"697130":[">=5",1],"698326":[">=5",1],"702002":["<5",2],"713113":[">=5",1],"713952":[">=5",1],"718221":[">=5",1],"726718":[">=5",1],"729699":[">=5",1],"732279":["<5",1],"737610":[">=5",1],"739378":[">=5",2],"761208":[">=5",2],"761310":[">=5",1],"770399":[">=5",1],"774522":[">=5",2],"792969":[">=5",1],"825047":["<5",1],"828123":[">=5",1],"834246":["<5",3],"846995":["<5",1],"848411":[">=5",1],"851748":[">=5",1],"856120":[">=5",1],"856472":[">=5",1],"857166":[">=5",1],"861136":["<5",1],"863672":[">=5",1],"865675":[">=5",1],"888421":[">=5",1],"889211":[">=5",1],"889903":[">=5",1],"891568":[">=5",1],"893026":[">=5",1],"899971":[">=5",1],"900280":[">=5",1],"921365":["<5",1],"928332":[">=5",2],"934093":[">=5",1],"934447":[">=5",1],"935206":[">=5",1],"938210":[">=5",2],"938487":[">=5",1],"942367":[">=5",1],"942415":[">=5",1],"944011":[">=5",1],"945370":[">=5",1],"946962":[">=5",1],"963176":[">=5",1],"983656":[">=5",1],"990909":["<5",1],"992389":[">=5",1],"995729":["<5",2],"999125":[">=5",1],"999607":[">=5",1],"1000012":["<5",1],"1000134":["<5",1],"1008387":[">=5",1],"1013572":["<5",2],"1028906":["<5",1],"1044932":["<5",2],"1059624":["<5",1],"1060931":["<5",3],"1072335":["<5",2],"1073128":[">=5",1],"1087031":["<5",2],"1087169":["<5",2],"1088412":["<5",1],"1089162":["<5",1],"1089396":["<5",2],"1099805":["<5",1],"1100863":["<5",1],"1103512":["<5",1]}', true);
		//$pl = json_decode('{"1":[">=5",1]}', true);
		Std::loadMetaobjectClass('player');
		foreach ($pl as $playerId => $b) {
			$player = new playerObject();
			$player->load($playerId);
			Page::fullActions($player, Page::$data['metro']['reward'][$b[0]][$b[1]], AlleyLang::ALERT_SOVET_REWARD);
			Page::sendNotice($playerId, 'Уважаемый игрок, сообщаем вам, что ошибка с получением награды за противостояние исправлена. В ваш инвентарь добавлена недостающая награда.');
		}
	}

	public static function resetCasino() {
		Page::$sql->query("UPDATE player SET casino_today_profit = 0 WHERE casino_today_profit > 0");
		Page::$sql->query("UPDATE player2 SET casino_today_chip = 0 WHERE casino_today_chip > 0");
		Page::$sql->query("UPDATE player2 SET casino_kubovich_step = 0 WHERE casino_kubovich_step > 0");

		$trans = Page::$sql->getRecordSet("SELECT name,value FROM casino WHERE name IN('casino_slots_ore_in', 'casino_slots_honey_in', 'casino_slots_ore_out')");
		$stat = array();
		foreach ($trans as $rec) {
			$stat[$rec["name"]] = $rec["value"];
		}
		Page::$sql->query("INSERT INTO casino_stat(dt, ore_in, honey_in, ore_out) VALUES(NOW(), '" . $stat["casino_slots_ore_in"] . "', '" . $stat["casino_slots_honey_in"] . "', '" . $stat["casino_slots_ore_out"] . "')");
		Page::$sql->query("UPDATE casino SET value = 0 WHERE name IN('casino_slots_ore_in', 'casino_slots_honey_in', 'casino_slots_ore_out')");
	}

	public static function casinoSportlotoRun() {
		$max = 25;
		$count = 5;

		Page::$cache->delete("casino_sportloto_past_gussed");

		$fund = Page::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_sportloto_fund'");
		$jackpot = Page::$sql->getValue("SELECT value FROM casino WHERE name = 'casino_sportloto_jackpot'");
		$numbers = CacheManager::get('value_casino_sportloto_next_numbers');

		Page::$sql->query("UPDATE casino SET value = " . $fund . " WHERE name = 'casino_sportloto_past_fund'");
		Page::$sql->query("UPDATE casino SET value = " . $jackpot . " WHERE name = 'casino_sportloto_past_jackpot'");
		CacheManager::set('value_casino_sportloto_today_numbers', $numbers);
		Page::setValueFromDB('casino_sportloto_today_numbers', $numbers);
		Page::$sql->query("UPDATE casino SET value = 0 WHERE name = 'casino_sportloto_fund'");

		$nextNumbers = array();
		for ($i = 0; $i < $count; $i++) {
			$num = mt_rand(1, $max);
			while (in_array($num, $nextNumbers)) {
				$num = mt_rand(1, $max);
			}
			$nextNumbers[] = $num;
		}

		CacheManager::set('value_casino_sportloto_next_numbers', implode(' ', $nextNumbers));
		Page::setValueFromDB('casino_sportloto_next_numbers', implode(' ', $nextNumbers));

		$prize = array(0, 0, 0.47, 0.35, 0.07, 0.01);
		$pastStart = mktime(0, 0, 0, date("n"), date("j") - 1, date("Y"));
		$pastEnd = mktime(23, 59, 59, date("n"), date("j") - 1, date("Y"));
		$dateStart = date("Y-m-d H:i:s", $pastStart);
		$dateEnd = date("Y-m-d H:i:s", $pastEnd);

		$winCount = self::$sql->getRecordSet("SELECT COUNT(1) count, gussed FROM casino_sportloto WHERE dt >= '" . $dateStart . "' AND dt <= '" . $dateEnd . "' GROUP BY gussed");
		$prizes = array();
		$winCountWraper = array();
		for ($i = 0; $i <= $count; $i++) {
			$winCountWraper[$i] = array("count" => 0, "gussed" => $i);
			$prizes[$i] = $fund * $prize[$i];
		}
		if ($winCount) {
			foreach ($winCount as $rec) {
				$winCountWraper[$rec["gussed"]] = $rec;
			}
		}
		$jackpotInc = 0;
		foreach ($winCountWraper as $rec) {
			if ($rec["count"] > 0) {
				if ($rec["gussed"] == 5) {
					Page::$sql->query("UPDATE casino SET value = 3000 WHERE name= 'casino_sportloto_jackpot'");
					$prizes[$rec["gussed"]] = round(($jackpot + $prizes[$rec["gussed"]]) / $rec["count"]);
				} else {
					$prizes[$rec["gussed"]] = round($prizes[$rec["gussed"]] / $rec["count"]);
				}
			} else {
				$jackpotInc += $prizes[$rec["gussed"]];
				$prizes[$rec["gussed"]] = 0;
			}
		}
		if ($jackpotInc > 0) {
			Page::$sql->query("UPDATE casino SET value = value + " . $jackpotInc . " WHERE name = 'casino_sportloto_jackpot'");
		}
		Page::$sql->query("UPDATE casino SET value = value + 1 WHERE name = 'casino_sportloto_run'");
		Page::$cache->delete('casino_sportloto_run');

		foreach ($prizes as $k => $v) {
			self::$sql->query("UPDATE casino_sportloto SET chip = " . $v . " WHERE dt >= '" . $dateStart . "' AND dt <= '" . $dateEnd . "' AND gussed = " . $k);
		}
		Page::$cache->delete("casino_sportloto_past");
		Page::$sql->query("DELETE FROM casino_sportloto WHERE dt < NOW() - INTERVAL 3 DAY");
		Std::loadModule("Casino");
		Casino::getSportlotoPast();
	}

	public static function casinoSportlotoCacheReset() {
		Page::$cache->delete("casino_sportloto_past");
	}

	public function removePatrolBonuses() {
		$sql = "UPDATE player2 SET patrol_bonus = '' WHERE patrol_bonus != ''";
		Page::$sql->query($sql);
	}

	/*
	 * Отправляет e-mail и добавляет в список на удаление неактивных игроков
	 */
	public static function sendNotifiesToDeleting()
    {
		$players = Page::$sql->getRecordSet("SELECT p.* FROM player p left join player_to_delete ptd on ptd.player = p.id where ptd.player is null and p.lastactivitytime < adddate(now(), interval -14 * p.level day) and p.accesslevel >= 0 and p.email != '' and p.level < 6 limit 50");
		print_r($players);
		return;
		if ($players) {
			foreach ($players as $p) {
				if (!DEV_SERVER) Page::sendNotify($p, "inactive");
				$sql = "INSERT INTO player_to_delete (player, dt) VALUES (" . $p["id"] . ", now())";
				Page::$sql->query($sql);
			}
		}
	}

	public static function deleteInactivePlayers() {
		if (DEV_SERVER) return;
		$sql = "DELETE player_to_delete ptd FROM player_to_delete ptd, player p WHERE p.id = ptd.player AND p.lastactivitytime > ptd.dt";
		Page::$sql->query($sql);

		$players = Page::$sql->getValueSet("SELECT ptd.player FROM player_to_delete ptd WHERE ptd.dt < adddate(now(), interval -14 day) LIMIT 100");
		if ($players) {
			self::forceDeleteInactive($players);
		}
	}

	public static function deleteHalfPlayers() {
		$players = Page::$sql->getValueSet("SELECT id FROM player WHERE nickname = '' and registeredtime < adddate(now(), interval -2 day) LIMIT 50");
		if ($players) {
			self::forceDeleteInactive($players, false);
		}
	}

	public static function deleteUnconfirmedPlayers() {
		if (DEV_SERVER) return;
		$players = Page::$sql->getValueSet("SELECT id FROM player WHERE password = 'd41d8cd98f00b204e9800998ecf8427e' and level = 1 and lastactivitytime < adddate(now(), interval -14 day) LIMIT 100");
		if ($players) {
			self::forceDeleteInactive($players, false);
		}
	}

	public static function forceDeleteInactive($ids = array(), $saveEmail = true) {
		$t1 = microtime(true);
		//if (empty($ids)) $ids = Page::$sql->getValueSet("SELECT player.id FROM player FORCE INDEX(ix__player__level) LEFT JOIN payment ON payment.player = player.id WHERE player.level = 1 AND payment.player IS NULL AND lastactivitytime < DATE_SUB(NOW(), INTERVAL player.level * 2 WEEK) AND player.accesslevel = 0 LIMIT 5000");
		if ($ids) {
			$ids = implode(",", $ids);
			if ($saveEmail) Page::$sql->query("INSERT INTO email_deleted (nickname, email) SELECT nickname, email FROM player WHERE id IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM contact WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM contact WHERE player2 IN (" . $ids . ")");
			//Page::$sql->query("DELETE FROM log WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM gift WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM inventory WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM playerwork WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM playerboost2 WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM player_topic_read WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM pet WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM rating_player WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM player_quest WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM authlog WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM itemdroplog WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM support WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM playercomment WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM bankdeposit WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM metrolog WHERE player IN (" . $ids . ")");
			//Page::$sql->query("DELETE FROM fightplayer WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM photo_vote WHERE photo IN (SELECT id FROM photo WHERE photo.player IN(" . $ids . "))");
			Page::$sql->query("DELETE FROM photo WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM autologin WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM player2 WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM player WHERE id IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM logspecial WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM onlinecounter WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM quiz_results WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM collection_item_player WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM collection_player WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM boost WHERE player IN (" . $ids . ")");
			//Page::$sql->query("DELETE FROM sovetlog WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM sovet WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM hunt WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM hunt WHERE player2 IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM huntlog WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM job_player WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM player_paidbg WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM casino_sportloto WHERE player IN (" . $ids . ")");
			Page::$sql->query("DELETE FROM player_to_delete WHERE player IN (" . $ids . ")");
		}
		$t2 = microtime(true);
		print $t2 - $t1 . " - all\n";
	}

	public static function calcStatsForWerewolfs() {
		$sql = "SELECT level,
					FLOOR(AVG(health_finish)) as health_avg, FLOOR(MAX(health_finish)) as health_max,
					FLOOR(AVG(strength_finish)) as strength_avg, FLOOR(MAX(strength_finish)) as strength_max,
					FLOOR(AVG(dexterity_finish)) as dexterity_avg, FLOOR(MAX(dexterity_finish)) as dexterity_max,
					FLOOR(AVG(attention_finish)) as attention_avg, FLOOR(MAX(attention_finish)) as attention_max,
					FLOOR(AVG(intuition_finish)) as intuition_avg, FLOOR(MAX(intuition_finish)) as intuition_max,
					FLOOR(AVG(resistance_finish)) as resistance_avg, FLOOR(MAX(resistance_finish)) as resistance_max,
					FLOOR(AVG(charism_finish)) as charism_avg, FLOOR(MAX(charism_finish)) as charism_max,
					FLOOR(AVG(ratingcrit)) as ratingcrit_avg, FLOOR(MAX(ratingcrit)) as ratingcrit_max,
					FLOOR(AVG(ratingdodge)) as ratingdodge_avg, FLOOR(MAX(ratingdodge)) as ratingdodge_max,
					FLOOR(AVG(ratingresist)) as ratingresist_avg, FLOOR(MAX(ratingresist)) as ratingresist_max,
					FLOOR(AVG(ratinganticrit)) as ratinganticrit_avg, FLOOR(MAX(ratinganticrit)) as ratinganticrit_max,
					FLOOR(AVG(ratingdamage)) as ratingdamage_avg, FLOOR(MAX(ratingdamage)) as ratingdamage_max,
					FLOOR(AVG(ratingaccur)) as ratingaccur_avg, FLOOR(MAX(ratingaccur)) as ratingaccur_max
				FROM player
				WHERE accesslevel = 0
				GROUP BY level";
		$statsTmp = Page::$sql->getRecordSet($sql);
		$stats = array();
		foreach ($statsTmp as $s) {
			$s['ratingcrit_avg'] = max(0, $s['ratingcrit_avg']);
			$s['ratingcrit_max'] = max(0, $s['ratingcrit_max']);
			$s['ratingdodge_avg'] = max(0, $s['ratingdodge_avg']);
			$s['ratingdodge_max'] = max(0, $s['ratingdodge_max']);
			$s['ratingresist_avg'] = max(0, $s['ratingresist_avg']);
			$s['ratingresist_max'] = max(0, $s['ratingresist_max']);
			$s['ratinganticrit_avg'] = max(0, $s['ratinganticrit_avg']);
			$s['ratinganticrit_max'] = max(0, $s['ratinganticrit_max']);
			$s['ratingdamage_avg'] = max(0, $s['ratingdamage_avg']);
			$s['ratingdamage_max'] = max(0, $s['ratingdamage_max']);
			$s['ratingaccur_avg'] = max(0, $s['ratingaccur_avg']);
			$s['ratingaccur_max'] = max(0, $s['ratingaccur_max']);
			CacheManager::set('value_werewolf_stats', json_encode($s), array('level' => $s['level']));
			Page::setValueFromDB('werewolf_stats_' . $s['level'], json_encode($s));
		}
	}

	public static function calcCutAverageStats() {
		if (date("H") != 5) {
			return false;
		}
		$whereCond = "";
		$stats = array('health', 'strength', 'dexterity', 'intuition', 'resistance', 'attention', 'charism');
		$sql = "SELECT level, COUNT(1) as amount,
					FLOOR(AVG(health_finish)) as health_avg, FLOOR(MAX(health_finish)) as health_max,
					FLOOR(AVG(strength_finish)) as strength_avg, FLOOR(MAX(strength_finish)) as strength_max,
					FLOOR(AVG(dexterity_finish)) as dexterity_avg, FLOOR(MAX(dexterity_finish)) as dexterity_max,
					FLOOR(AVG(attention_finish)) as attention_avg, FLOOR(MAX(attention_finish)) as attention_max,
					FLOOR(AVG(intuition_finish)) as intuition_avg, FLOOR(MAX(intuition_finish)) as intuition_max,
					FLOOR(AVG(resistance_finish)) as resistance_avg, FLOOR(MAX(resistance_finish)) as resistance_max,
					FLOOR(AVG(charism_finish)) as charism_avg, FLOOR(MAX(charism_finish)) as charism_max
					/*,
					FLOOR(AVG(ratingcrit)) as ratingcrit_avg, FLOOR(MAX(ratingcrit)) as ratingcrit_max,
					FLOOR(AVG(ratingdodge)) as ratingdodge_avg, FLOOR(MAX(ratingdodge)) as ratingdodge_max,
					FLOOR(AVG(ratingresist)) as ratingresist_avg, FLOOR(MAX(ratingresist)) as ratingresist_max,
					FLOOR(AVG(ratinganticrit)) as ratinganticrit_avg, FLOOR(MAX(ratinganticrit)) as ratinganticrit_max,
					FLOOR(AVG(ratingdamage)) as ratingdamage_avg, FLOOR(MAX(ratingdamage)) as ratingdamage_max,
					FLOOR(AVG(ratingaccur)) as ratingaccur_avg, FLOOR(MAX(ratingaccur)) as ratingaccur_max
					*/
				FROM player
				WHERE accesslevel = 0 " . $whereCond . "
				GROUP BY level";
		$result = mysql_query($sql);
		$res = array();
		while ($line = mysql_fetch_assoc($result)) {
			$res[$line['level']] = $line;
		}
		foreach ($res as $level => &$r) {
			$cutAmount = round($r['amount'] * 0.1);
			if ($cutAmount < 1) {
				continue;
			}
			foreach ($stats as $s) {
				$sql = "SELECT " . $s . "_finish as " . $s . " FROM player WHERE accesslevel = 0 " . $whereCond . " AND level = " . $level . " ORDER BY " . $s . " DESC LIMIT " . $cutAmount . ", 1";
				$result = mysql_query($sql);
				$line = mysql_fetch_assoc($result);
				$v = $line[$s];
				$r[$s . '_max'] = $v;
				$max = $v;

				$sql = "SELECT " . $s . "_finish as " . $s . " FROM player WHERE accesslevel = 0 " . $whereCond . " AND level = " . $level . " ORDER BY " . $s . " ASC LIMIT " . $cutAmount . ", 1";
				$result = mysql_query($sql);
				$line = mysql_fetch_assoc($result);
				$min = $line[$s];

				$sql = "SELECT FLOOR(AVG(" . $s . "_finish)) as v, COUNT(1) as a FROM player WHERE accesslevel = 0 " . $whereCond . " AND level = " . $level . " AND " . $s . "_finish BETWEEN " . $min . " and " . $max . "";
				$result = mysql_query($sql);
				$line = mysql_fetch_assoc($result);
				$r[$s . '_avg'] = $line['v'];
				$r['amount'] = $line['a'];
			}
		}
		foreach ($res as $s) {
			/* $s['ratingcrit_avg'] = max(0, $s['ratingcrit_avg']);
			  $s['ratingcrit_max'] = max(0, $s['ratingcrit_max']);
			  $s['ratingdodge_avg'] = max(0, $s['ratingdodge_avg']);
			  $s['ratingdodge_max'] = max(0, $s['ratingdodge_max']);
			  $s['ratingresist_avg'] = max(0, $s['ratingresist_avg']);
			  $s['ratingresist_max'] = max(0, $s['ratingresist_max']);
			  $s['ratinganticrit_avg'] = max(0, $s['ratinganticrit_avg']);
			  $s['ratinganticrit_max'] = max(0, $s['ratinganticrit_max']);
			  $s['ratingdamage_avg'] = max(0, $s['ratingdamage_avg']);
			  $s['ratingdamage_max'] = max(0, $s['ratingdamage_max']);
			  $s['ratingaccur_avg'] = max(0, $s['ratingaccur_avg']);
			  $s['ratingaccur_max'] = max(0, $s['ratingaccur_max']); */
			$s['ratingcrit_avg'] = 0;
			$s['ratingcrit_max'] = 0;
			$s['ratingdodge_avg'] = 0;
			$s['ratingdodge_max'] = 0;
			$s['ratingresist_avg'] = 0;
			$s['ratingresist_max'] = 0;
			$s['ratinganticrit_avg'] = 0;
			$s['ratinganticrit_max'] = 0;
			$s['ratingdamage_avg'] = 0;
			$s['ratingdamage_max'] = 0;
			$s['ratingaccur_avg'] = 0;
			$s['ratingaccur_max'] = 0;
			CacheManager::set('value_avgcut_stats', json_encode($s), array('level' => $s['level']));
			Page::setValueFromDB('avgcut_stats' . $s['level'], json_encode($s));
		}
	}

	public static function clearClanRests() {
		$sql = "SELECT id FROM clan WHERE state = 'rest' AND attackdt < now()";
		$ids = Page::$sql->getValueSet($sql);
		if (!$ids) {
			return;
		}
		CacheManager::deleteSet('clan_full', 'clan_id', $ids);
		$sql = "UPDATE clan SET state = '' WHERE id IN (" . implode(', ', $ids) . ")";
		Page::$sql->query($sql);
	}

	public static function decreaseClanPoints() {
		$dt = date('Y-m-d H:i:s', time() - 3600 * 24 * 21);
		$newDt = date('Y-m-d 00:00:00', time());
		$sql = "SELECT id, points FROM clan WHERE lastdecrease < '" . $dt . "'";
		$clans = Page::$sql->getRecordSet($sql);
		Std::loadModule('Clan');
		$sql = "UPDATE clan SET points = IF(points > 0, points - 1, 0), lastdecrease = '" . $newDt . "' WHERE lastdecrease < '" . $dt . "'";
		Page::$sql->query($sql);
		if (is_array($clans) && count($clans))
			foreach ($clans as $c) {
				if ($c['points'] > 0) {
					Clan::sendClanLog('dcrs3w', array('points' => $c['points'] - 1, 'pts' => -1), 0, $c['id']);
					CacheManager::delete('clan_full', array('clan_id' => $c['id']));
				}
			}
	}

	public static function updateOnline() {
		//$online = Page::getData('general/users_online', "SELECT COUNT(1) FROM `player` WHERE `status` = 'online'", 'value', 300);
		$online = CacheManager::get('players_online');
		self::$sql->query("INSERT INTO online(dt,online) VALUES('" . date("Y-m-d H:i:s") . "', '" . $online . "')");
	}

	public static function updateActive() {
		$j = date("j");
		$to = date("Y-m-d H:i:s", mktime(0, 30, 0, date("n"), $j));
		$from = date("Y-m-d H:i:s", mktime(0, 30, 0, date("n"), ($j - 1)));
		$count = self::$sql->getValue("SELECT count(*) from player where lastactivitytime >= '" . $from . "' AND lastactivitytime < '" . $to . "'");
		self::$sql->query("INSERT INTO active(active, dt) values('" . $count . "', '" . $from . "')");
	}

	public static function updateStat() {
		$curMonthDate = date("Y-m-d", mktime(0, 0, 0, date("n"), 1));
		$prevMonthDate = date("Y-m-d", mktime(0, 0, 0, date("n") - 1, 1));
		$curMonthDateWeek = date("Y-m-d", mktime(0, 0, 0, date("n"), -6));
		$prevMonthDateWeek = date("Y-m-d", mktime(0, 0, 0, date("n") - 1, -6));

		// Всего активных игроков за месяц
		self::$sql->query("
INSERT INTO stat(active, level, dt) SELECT count(distinct player.id), player.level, '" . $curMonthDate . "' FROM player LEFT JOIN payment ON payment.player = player.id WHERE ((lastactivitytime > registeredtime + INTERVAL 7 DAY AND player.level >= 2) OR (payment.id IS NOT NULL)) AND lastactivitytime >= '" . $prevMonthDate . "' GROUP BY player.level
ON DUPLICATE KEY UPDATE active = VALUES(active);
			");

		// Всего пришедших игроков за месяц
		self::$sql->query("
INSERT INTO stat(come, level, dt) SELECT count(distinct player.id), player.level, '" . $curMonthDate . "' FROM player LEFT JOIN payment ON payment.player = player.id WHERE ((lastactivitytime > registeredtime + INTERVAL 7 DAY AND player.level >= 2) OR (payment.id IS NOT NULL)) AND lastactivitytime >= '" . $prevMonthDate . "' AND registeredtime >= '" . $prevMonthDate . "' GROUP BY player.level
ON DUPLICATE KEY UPDATE come = VALUES(come);
			");

// Всего ушедших игроков за месяц
		self::$sql->query("
INSERT INTO stat(gone, level, dt) SELECT count(*), level, '" . $curMonthDate . "' FROM player WHERE lastactivitytime > registeredtime + INTERVAL 7 DAY AND level >= 2 AND lastactivitytime >= '" . $prevMonthDateWeek . "' AND lastactivitytime < '" . $curMonthDateWeek . "' GROUP BY level
ON DUPLICATE KEY UPDATE gone = VALUES(gone);
			");

		// Количество платящих игроков за месяц(с 1 по 31 число месяца): количество уникальных игроков, которые сделали платежи с 1 по 31 числом месяца по уровням
		self::$sql->query("
INSERT INTO stat(paid, level, dt) SELECT count(distinct player.id), player.level, '" . $curMonthDate . "' FROM player INNER JOIN payment ON payment.player = player.id WHERE payment.dt >= '" . $prevMonthDate . "' AND payment.dt < '" . $curMonthDate . "' GROUP BY player.level
ON DUPLICATE KEY UPDATE paid = VALUES(paid);
			");

		// Выручка за месяц по уровням
		self::$sql->query("
INSERT INTO stat(revenue, level, dt) SELECT ROUND(SUM(value)), player.level, '" . $curMonthDate . "' FROM player INNER JOIN payment ON payment.player = player.id WHERE payment.dt >= '" . $prevMonthDate . "' AND payment.dt < '" . $curMonthDate . "' GROUP BY player.level
ON DUPLICATE KEY UPDATE revenue = VALUES(revenue);
			");

		self::$sql->query("
UPDATE stat SET arpu = IF(active > 0, ROUND(revenue / active), 0) WHERE dt = '" . $curMonthDate . "';
			");

		self::$sql->query("
UPDATE stat SET arppu = IF(paid > 0, ROUND(revenue / paid), 0) WHERE dt = '" . $curMonthDate . "';
			");
	}

	public static function deleteForgotten() {
		/*
		  $ids = Page::$sql->vs("SELECT id FROM player WHERE password = '" . md5("") . "' AND lastactivitytime < '" . date("Y-m-d H:i:s", time() - (86400 * 30)) . "'");
		  if (sizeof($ids)) {
		  $ids = implode(",", $ids);
		  Page::$sql->query("DELETE FROM player WHERE id in (" . $ids . ")");
		  Page::$sql->query("DELETE FROM player2 WHERE player in (" . $ids . ")");
		  }
		 */
	}

	/*
	 * Обнуляет рейтинг за заданный период
	 * @param string $period - период
	 */

	public static function ratingClear($period) {
		Page::setValueFromDB('rating_state', 'off');
		CacheManager::set('rating_state', 'off');
		Page::$sql->query("update rating_player set moneygrabbed_" . $period . " = 0 where moneygrabbed_" . $period . " > 0");
		Page::$sql->query("update rating_player set moneyglost_" . $period . " = 0 where moneylost_" . $period . " > 0");
		Page::$sql->query("update rating_player set wins_" . $period . " = 0 where wins_" . $period . " > 0");
		//Page::$sql->query("update rating_player set moneygrabbed_" . $period . " = 0, moneylost_" . $period . " = 0, wins_" . $period . " = 0");
		Page::$sql->query("update rating_player2 set huntkills_" . $period . " = 0, huntaward_" . $period . " = 0");
		Page::setValueFromDB('rating_state', '');
		CacheManager::set('rating_state', '');
	}

	/*
	 * Обработчик викторины
	 */

	public static function quizHandler() {
		// часы, в какие начинается викторина
		$startTimes = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
		// количество вопросов в каждой викторине
		$questionsAmount = 20;
		// время, за которое появляется объявление о викторине
		$alertBefore = 5;
		Std::loadMetaObjectClass('chatlog');
		// если в данный момент викторина не запущена, то проверяем, не надо ли запустить ее сейчас или дать объявление
		if (Page::$cache->get('quiz') != 'on') {
			$hour = date("H");
			$time = time();
			$startsSoon = false;
			$startsNow = false;
			foreach ($startTimes as $h) {
				$t = mktime($h, 0, 0);
				$r = $time - $t;
				if (abs($r) > $alertBefore * 60) {
					continue;
				}
				if ($r > 0) {
					$startsNow = true;
					break;
				} else if ($r <= 0) {
					$startsSoon = true;
					break;
				}
			}
			if ($startsSoon && Page::$cache->get("quiz_state") === false) {
				self::chatQuizSend('Новая викторина начнется через 5 минут!');
				Page::$cache->set('quiz_state', 'alert_done', 600);
				echo 'quiz starts soon';
			} else if ($startsNow) {
				self::chatQuizSend('Началась новая викторина! Приготовьтесь к первому вопросу.');
				Page::$sql->query("update quiz_results set current = 0");
				Page::$cache->set('quiz_state', 'started', 6000);
				Page::$cache->set('quiz', 'on', 6000);
				Page::$cache->set('quiz_questions', 0, 6000);
				echo 'quiz starts now';
			} else {
				echo 'no quiz';
			}
			return;
		}
		$state = Page::$cache->get("quiz_state");
		$newQuestion = false;
		// если был задан вопрос и никто не ответил, то даем первую подсказку, вторую подсказку, завершаем вопрос и переходим к следующему
		if ($state == 'question_asked') {
			switch (Page::$cache->get("quiz_hint")) {
				case 0:
					self::chatQuizSend('Подсказка: слово состоит из ' . mb_strlen(Page::$cache->get('quiz_answer'), 'UTF-8') . ' букв.');
					Page::$cache->set('quiz_hint', 1, 6000);
					echo 'hint 1';
					break;

				case 1:
					self::chatQuizSend('Подсказка: слово начинается на букву ' . mb_substr(Page::$cache->get('quiz_answer'), 0, 1, 'UTF-8') . '.');
					Page::$cache->set('quiz_hint', 2, 6000);
					echo 'hint 2';
					break;

				case 2:
					self::chatQuizSend('Никто не ответил на вопрос. ' . (Page::$cache->get('quiz_questions') < $questionsAmount ? 'Переходим к следующему вопросу.' : 'Это был последний вопрос. Переходим к подведению итогов.'));
					$newQuestion = true;
					break;
			}
		}
		// если викторина только началась или закончен предыдущий вопрос, то задаем новый вопрос
		if ($state == 'started' || $state == 'question_answered') {
			$newQuestion = true;
		}
		if ($newQuestion) {
			$questions = Page::$cache->get('quiz_questions');
			// если задано вопросов меньше, чем должно быть, то задаем новый
			if ($questions < $questionsAmount) {
				$questions++;
				Page::$cache->set('quiz_questions', $questions, 6000);
				Page::$cache->set('quiz_hint', 0, 6000);
				Page::$cache->set('quiz_state', 'question_asked', 6000);
				do {
					$question = Page::$sql->getRecord("SELECT id, question, answer FROM question WHERE id = " . rand(1, 134000));
				} while ($question === false);
				//$question['answer'] = str_replace(array('a', 'e', 'o', 'p', 'x', 'c', 'E', 'T', 'O', 'P', 'A', 'H', 'K', 'X', 'C', 'B', 'M', 'а', 'е', 'о', 'р', 'х', 'с', 'Е', 'Т', 'О', 'Р', 'А', 'Н', 'К', 'Х', 'С', 'В', 'М'), array('а', 'е', 'о', 'р', 'х', 'с', 'Е', 'Т', 'О', 'Р', 'А', 'Н', 'К', 'Х', 'С', 'В', 'М', 'a', 'e', 'o', 'p', 'x', 'c', 'E', 'T', 'O', 'P', 'A', 'H', 'K', 'X', 'C', 'B', 'M'), $question['answer']);
				$question['question'] = strtr($question['question'], array('а' => 'a', 'е' => 'e', 'о' => 'o', 'р' => 'p', 'х' => 'x', 'с' => 'c', 'Е' => 'E', 'Т' => 'T', 'О' => 'O', 'Р' => 'P', 'А' => 'A', 'Н' => 'H', 'К' => 'K', 'Х' => 'X', 'С' => 'C', 'В' => 'B', 'М' => 'M'));
				Page::$cache->set('quiz_answer', $question['answer'], 6000);
				self::chatQuizSend($questions . '/' . $questionsAmount . '. ' . $question['question'], $question['answer']);
				echo 'new question';
			} else {
				// завершаем викторину
				$topScore = Page::$sql->getValue("SELECT max(qr.current) FROM quiz_results qr");
				if ($topScore > 0) {
					$winners = Page::$sql->getRecordSet("select qr.player id, p.nickname, qr.wins, qr.current from quiz_results qr left join player p on p.id = qr.player where qr.current = " . $topScore);
				}
				if ($winners) {
					// награда победителя, current - кол-во правильных ответов в данной викторине, wins - количество побед
					$money = (int) ($topScore * 50 + 1000);
					$ore = (int) ($topScore / 5 + 10);
					Std::loadLib('HtmlTools');
					$scoreStr = HtmlTools::russianNumeral($topScore, 'правильный ответ', 'правильных ответа', 'правильных ответов');
					if (count($winners) > 1) {
						$money = (int) ($money / count($winners));
						$ore = (int) ($ore / count($winners));
						$nicknames = array();
						$ids = array();
						foreach ($winners as $w) {
							$ids[] = $w['id'];
							$nicknames[] = $w['nickname'];
							//Page::sendLog($w['id'], 'quiz_won', array('money' => $money, 'ore' => $ore, 'answers' => $w['current']));
							Page::sendLog($w['id'], 'quiz_won', array('answers' => $w['current']));
						}
						Page::$sql->query("update quiz_results set wins = wins + 1 where player in (" . implode(', ', $ids) . ")");
						//Page::$sql->query("update player set money = money + " . $money . ", ore = ore + " . $ore . " where id in (" . implode(', ', $ids) . ")");
						//self::chatQuizSend('Викторина закончена. Победители ' . implode(', ', $nicknames) . ' (' . $topScore . ' ' . $scoreStr . ') получают ' . $money . ' монет и ' . $ore . ' руды.');
						self::chatQuizSend('Викторина закончена. Победители ' . implode(', ', $nicknames) . ' (' . $topScore . ' ' . $scoreStr . ').');
					} else {
						$winner = current($winners);
						Page::$sql->query("update quiz_results set wins = wins + 1 where player in (" . $winner['id'] . ")");
						//Page::$sql->query("update player set money = money + " . $money . ", ore = ore + " . $ore . " where id = " . $winner['id']);
						//self::chatQuizSend('Викторина закончена. Победитель ' . $winner['nickname'] . ' (' . $winner['current'] . ' ' . $scoreStr . ') получает ' . $money . ' монет и ' . $ore . ' руды.');
						self::chatQuizSend('Викторина закончена. Победитель ' . $winner['nickname'] . ' (' . $winner['current'] . ' ' . $scoreStr . ').');
						//Page::sendLog($winner['id'], 'quiz_won', array('money' => $money, 'ore' => $ore, 'answers' => $winner['current']));
						Page::sendLog($winner['id'], 'quiz_won', array('answers' => $winner['current']));
					}
				} else {
					self::chatQuizSend('Викторина закончена. В этой викторине никто не ответил правильно ни на один вопрос.');
				}
				Page::$cache->delete('quiz');
				Page::$cache->delete('quiz_state');
				echo 'quiz end';
			}
		}
	}

	/*
	 * Отправка сообщения в чат от лица ведущего викторину
	 * @param string $text
	 */

	public static function chatQuizSend($text, $answer = "") {
		if (DEV_SERVER) {
			$address = "dev.moswar.ru";
		} else {
			$address = "10.1.4.2";
		}
		$port = 8081;
		if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) && (socket_connect($socket, $address, $port))) {
			socket_write($socket, '{"action":"quiz","data":{"message":"' . $text . '","answer":"' . $answer . '","key":"quizquizquiz1~"}}' . "\n");
			//socket_write($socket, '{"action":"quit","data":{}}' . "\n");
			socket_close($socket);
		}
	}

	/*
	 * Отправляет e-mail неактивным игрокам
	 */

	public static function sendNotifiesToInactive() {
		$players = Page::$sql->getRecordSet("SELECT p.* FROM player p left join autologin al on al.player = p.id and al.type = 'inactive' where al.id is null and p.lastactivitytime < adddate(now(), interval -14 day) /*and p.id <= 20*/ and p.accesslevel >= 0 limit 50");
		if ($players)
			foreach ($players as $p) {
				Page::sendNotify($p, 'inactive');
				usleep(100);
			}
	}

	public static function sendPromo() {
		$mails = Page::$sql->getRecordSet("SELECT * FROM mail_queue ORDER BY id LIMIT 100");
		if ($mails) {
			foreach ($mails as $mail) {
				$result = Page::sendNotify(null, "promo", array("params" => $mail["text"], "text" => Page::sqlGetCacheValue("SELECT text FROM mail WHERE id = " . $mail["mail"], 3600)), $mail["email"], $mail["subject"]);
				if ($result) {
					Page::$sql->query("DELETE FROM mail_queue WHERE id = " . $mail["id"]);
				}
			}
		}
	}

	/**
	 * Раздача игрокам предметов
	 */
	public function give() {
		$player = $this->shellArgs[1];
		if ($this->shellArgs[2] == 'money' || $this->shellArgs[2] == 'honey' || $this->shellArgs[2] == 'ore') {
			$query = "UPDATE player SET " . $this->shellArgs[2] . " = " . $this->shellArgs[2] . " + " . intval($this->shellArgs[3]);
			if ($player != 'all') {
				$query .= " WHERE id = " . $player;
			}
			self::sqlQuery($query);
			echo 'Gave: ' . $this->shellArgs[3] . ' ' . $this->shellArgs[2] . ' to ';
			if ($player == 'all') {
				echo 'all';
			} else {
				echo '<a href="/player/' . $player . '/">' . $player . '</a>';
			}
			echo '<br />';
		} else if ($this->shellArgs[2] == 'item') {
			$query = "SELECT id FROM player";
			if (is_numeric($player)) {
				$query .= " WHERE id = " . $player;
			} else if ($player == 'home') {
				$query .= " WHERE is_home_available = 1";
			}
			$players = self::sqlGetValueSet($query);
			if ($players == false) {
				echo 'players not found<br />';
			} else {
				Std::loadMetaObjectClass('standard_item');
				$item = new standard_itemObject();
				if (is_numeric($this->shellArgs[3])) {
					$result = $item->load($this->shellArgs[3]);
				} else {
					$result = $item->loadByCode($this->shellArgs[3]);
				}
				if ($result == false) {
					echo 'item not found<br />';
				} else {
					foreach ($players as $p) {
						$item->makeExampleOrAddDurability($p);
					}
					echo 'Gave: item ' . $this->shellArgs[3] . ' to ';
					if ($player == 'all') {
						echo 'all';
					} else {
						echo '<a href="/player/' . $player . '/">' . $player . '</a>';
					}
					echo '<br />';
				}
			}
		}
	}

	/**
	 * Завершение войн по таймеру
	 */
	private static function finishWars() {
		$warsToFinish = self::$sql->getRecordSet("SELECT id, state FROM diplomacy WHERE type='war' AND (state='step1' OR state='step2') AND dt2<now() AND parent_diplomacy=0");
		if ($warsToFinish) {
			Std::loadMetaObjectClass('diplomacy');
			foreach ($warsToFinish as $war) {
				$dip = new diplomacyObject();
				$dip->load($war['id']);
				if ($war['state'] == 'step1') {
					$dip->tryEndStep1(true);
				} elseif ($war['state'] == 'step2') {
					$dip->tryEndStep2(true);
				}
			}
		}
	}

	/**
	 * Завершение периода ненападения (24 часа) после объявления войны
	 */
	private static function unpauseWars() {
		$warsToStart = self::$sql->getValueSet("SELECT id FROM diplomacy WHERE type='war' AND state='paused' AND DATE_SUB(now(), INTERVAL 1 DAY)>dt AND parent_diplomacy=0");
		if ($warsToStart) {
			Std::loadMetaObjectClass('diplomacy');
			foreach ($warsToStart as $warId) {
				$dip = new diplomacyObject();
				$dip->load($warId);
				$dip->advanceWarToStep1($warId);
			}
		}
	}

	/**
	 * Обработка хода группового боя
	 *
	 * @param int $id
	 */
	private static function calcGroupFightStepById($id) {
		Std::loadModule('Fight');
		Fight::calcEndStep($id);
	}

	/**
	 * Рассчет хода группового боя
	 *
	 * @param string $type
	 */
	private static function calcGroupFightStep($type = false) {
		//$fights = self::$sql->getValueSet("SELECT id FROM fight WHERE state = 'started' AND type = '" . $type . "' AND dt <= now()");
		$fights = self::$sql->getValueSet("SELECT id FROM fight WHERE state = 'started' AND dt <= now()" .
						($type ? "AND type = '" . $type . "'" : ""));
		if ($fights) {
			Std::loadModule('Fight');
			foreach ($fights as $id) {
				echo $id . PHP_EOL;
				Fight::calcEndStep($id);
				#$pid = pcntl_fork();
				#if ($pid == 0) {
				#exec("cd " . $GLOBALS["configWwwRoot"] . ";php5 service.php Cron gf_process_id $id");
				//exit;
				#    posix_kill(getmypid(), 9);
				#}
				//exec("cd " . $GLOBALS["configWwwRoot"] . ";nohup php5 service.php Cron calcGroupFightStepById $id &");
			}
		}
	}

	/**
	 * Запуск группового боя
	 *
	 * @param int $id
	 */
	private static function startGroupFightById($id) {
		Std::loadModule('Fight');
		Fight::startFight($id);
	}

	/**
	 * Запуск групповых боев
	 *
	 * @param string $type
	 */
	private static function startGroupFights($type = false) {
		//$fights = self::$sql->getValueSet("SELECT id FROM fight WHERE state = 'created' AND type = '" . $type . "' AND start_dt <= now()");
		$fights = self::$sql->getValueSet("SELECT id FROM fight WHERE state = 'created' AND start_dt <= date_add(now(), INTERVAL 1 MINUTE) " .
						($type ? " AND type = '" . $type . "'" : ""));
		if ($fights) {
Std::dump($type . " [" . sizeof($fights) . "]: " . implode(", ", $fights));
$started = array();
			Std::loadModule('Fight');
			foreach ($fights as $id) {
$started[] = $id;
				Fight::startFight($id);
$started[] = $id;            
//Std::dump("gf zxs parent $id");
				#$pid = pcntl_fork();
				#if ($pid == 0) {
//Std::dump("gf zxs child $id before exec");
				#exec("cd " . $GLOBALS["configWwwRoot"] . ";php5 service.php Cron gf_start_id $id");
//Std::dump("gf zxs child $id after exec");
				//exit;
				#    posix_kill(getmypid(), 9);
				#/}
//Std::dump("gf zxs parent after current foreach");
				//exec("cd " . $GLOBALS["configWwwRoot"] . ";nohup php5 service.php Cron calcGroupFightStepById $id &");
			}
Std::dump($type . " [x]: " . implode(", ", $started));
//Std::dump("gf zxs parent after foreach");
		}
//Std::dump("gf zxs parent before return");
	}

	/**
	 * Завершение групповых боев
	 *
	 * @param string $type
	 */
	private static function finishGroupFights($type = false) {
		$fights = self::$sql->getValueSet("SELECT id FROM fight WHERE state = 'finishing' " .
						($type ? " AND type = '" . $type . "'" : ""));
		if ($fights) {
			Std::loadModule('Fight');
			foreach ($fights as $id) {
				Fight::finishFight($id);
			}
		}
	}

	/**
	 * Создание группового боя за флаг
	 */
	private static function flagGroupFightCreate() {
		Std::loadModule('Fight');
		if ((date("H", time()) == '21' && (int) date("i", time()) > 10)) {
			Fight::createFight('flag');
		}
	}

	/**
	 * Создание клановых групповых боев
	 */
	private static function clanGroupFightCreate() {
		$h = (int) date("H", time());
		//if (DEV_SERVER == 1 || ((($h + 1) % 3 == 0) && (int)date("i", time()) > 40)) {
		if ((($h + 1) % 3 == 0) && (int) date("i", time()) > 40) {
			Std::loadModule('Fight');
			$wars = self::$sql->getRecordSet("SELECT id, data FROM diplomacy WHERE type='war' AND state='step2' and parent_diplomacy=0");
			if ($wars) {
				foreach ($wars as $war) {
					echo "war start: " . $war['id'] . PHP_EOL;
					$data = json_decode($war['data'], true);
					$hours = is_string($data['wpt']) ? explode(',', substr($data['wpt'], 0, -1)) : $data['wpt'];
					//if (!stristr($data['wpt'], $h . ',')) {
					if (!in_array($h, $hours)) {
						Fight::createFight('clanwar', $war['id']);
					}
				}
			}
		}
	}

	/**
	 * Создание боя для ограбления банка
	 */
	private static function bankGroupFightCreate() {
		// очистка, если после запуска боев не очистилось
		self::$sql->query("UPDATE player2 SET bankbribe=0 WHERE bankbribe>0");

		$h = (int) date("H", time());
		if ((($h + 1) == 10 || ($h + 1) == 16 || ($h + 1) == 20) && (int) date("i", time()) > 40) {
			//if (true) {
			Std::loadModule('Fight');
			Std::loadModule('Bank');

			$levelMoney = Bank::getRobberyLevelMoney();

			$maxLevel = CacheManager::get('value_bankfightmaxlevel');

			// создание боев
			for ($i = 5; $i <= $maxLevel; $i++) {
				Fight::createFight('bank', $i, array('money' => $levelMoney[$i]));
			}
		}
	}

	/**
	 * Создание уровневых боев
	 */
	private static function levelGroupFightCreate() {
		if ((int) date("i", time()) > 40) {
			Std::loadModule('Fight');
			$maxLevel = CacheManager::get('value_levelfightmaxlevel');
			for ($i = 1; $i <= $maxLevel; $i++) {
				Fight::createFight('level', $i);
			}
		}
	}

	/**
	 * Создание хаотичных боев
	 */
	private static function chaoticGroupFightCreate() {
		Std::loadModule('Fight');
		$maxLevel = CacheManager::get('value_levelfightmaxlevel');
		for ($i = 1; $i <= $maxLevel; $i++) {
			Fight::createFight('chaotic', $i);
		}
	}

	/**
	 * Создание боев за метро
	 */
	private static function metroGroupFightCreate() {
		$h = (int) date("H", time());
		$m = (int) date("i", time());
		if (date("N", time()) == 5 && $h > 8 && (($m > 5 && $m < 15) || ($m > 25 && $m < 35))) {
			Std::loadModule('Fight');
			$maxLevel = CacheManager::get('value_levelfightmaxlevel');
			for ($i = 3; $i <= $maxLevel; $i++) {
				Fight::createFight('metro', $i);
			}
		}
	}

	/**
	 * Удаление предметов с истекшим сроком годности
	 */
	private static function removeExpiredItems() {
		// ! написание универсальную удалялку !
		$m = (int) date("i", time());
		$h = (int) date("H", time());
		// удаление сейфов
		if ($m > 5 && $m < 55) { // && $h == 3) {
			$safeExp = 60 * 60 * 24 * 14;
			$safe2Exp = 3600 * 24;
			$now = time();
			$expiredItems = self::$sql->getRecordSet("SELECT id, name, player FROM inventory WHERE code='safe' AND dtbuy <= " . ($now - $safeExp) . " AND unlocked = 1");
			if ($expiredItems) {
				foreach ($expiredItems as $item) {
					Page::sendLog($item['player'], 'item_expired', array('name' => $item['name']), 0);
				}
			}
			$expiredItems = self::$sql->getRecordSet("SELECT id, name, player FROM inventory WHERE code='safe2' AND dtbuy <= " . ($now - $safe2Exp) . " AND unlocked = 1");
			if ($expiredItems) {
				foreach ($expiredItems as $item) {
					Page::sendLog($item['player'], 'item_expired', array('name' => $item['name']), 0);
				}
			}
			self::$sql->query("DELETE FROM inventory WHERE code='safe' AND dtbuy <= " . ($now - $safeExp) . " AND unlocked = 1");
			self::$sql->query("DELETE FROM inventory WHERE code='safe2' AND dtbuy <= " . ($now - $safe2Exp) . " AND unlocked = 1");
		}
		// удаление предметов по расписанию (вывод предметов из игры)
		if ($m > 5 && $m < 55) {
			self::$sql->query("DELETE FROM inventory WHERE deleteafter='date' AND deleteafterdt < " . time());
			self::$sql->query("DELETE FROM inventory WHERE deleteafter='period' AND dtbuy < (unix_timestamp(now()) - deleteafterdt * 60)");
		}
	}

	/**
	 * Уменьшение подозрительности
	 */
	private static function suspicion() {
		self::sqlQuery("UPDATE player SET suspicion=suspicion-1 WHERE suspicion>-5 AND state != 'police'");
	}

	/**
	 * Пересчет рейтинга награбленного и прочитанного
	 */
	private static function updateRatingPlayerBattle() {
		Std::loadLib('Xslt');
		Std::loadModule('Rating');

		/*$time = time();

		$eventTimeBegin = strtotime('2010-05-04 00:00:00');
		$eventTimeEnd = strtotime('2010-05-06 00:00:00');

		if ($eventTimeBegin <= time() && time() <= $eventTimeEnd) {
			$moneygrabbedEvent = true;
		}

		$lastupdate = self::$sql->getValue("SELECT `value` FROM `value` where `name` = 'rating_players_lastupdatetime'");
		if ($lastupdate === false) {
			$lastupdate = 0;
		}
		$lastid = self::$sql->getValue("SELECT `value` FROM `value` where `name` = 'rating_players_lastfightid'");
		if ($lastid === false) {
			echo 'no last fight id';
			exit;
		}*/

		/*
		  $playersTemp = self::$sql->getRecordSet("SELECT player, lastupdate FROM rating_player");
		  $players = array();
		  $minTime = -1;
		  foreach ($playersTemp as $p) {
		  if ($minTime == -1 || $p['lastupdate'] < $minTime) {
		  $minTime = $p['lastupdate'];
		  }
		  $players[$p['player']] = $p;
		  }
		  $origPlayers = $players;
		 */

		/*
		$changes = array();
		//$fights = self::$sql->getRecordSet("SELECT id, player1 as p1, player2 as p2, profit as p, winner as w, time as t FROM duel WHERE time >= " . $lastupdate . " AND time < " . $time);
		$fights = self::$sql->getRecordSet("SELECT id, player1 as p1, player2 as p2, profit as p, winner as w, time as t FROM duel WHERE id > " . $lastid . " LIMIT 0, 5000");
		if (is_array($fights) && count($fights)) {
			foreach ($fights as $f) {
				if ($f['p1'] == $f['w']) {
					$w = $f['p1'];
					$l = $f['p2'];
				} else if ($f['p2'] == $f['w']) {
					$w = $f['p2'];
					$l = $f['p1'];
				}
				//if (isset($players[$w]) && $players[$w]['lastupdate'] < $f['t']) {
				$changes[$w]['moneygrabbed'] += $f['p'];
				$changes[$w]['wins']++;
				//}
				//if (isset($players[$l]) && $players[$w]['lastupdate'] < $f['t']) {
				$changes[$l]['moneylost'] += $f['p'];
				//}

				if ($lastid < $f['id']) {
					$lastid = $f['id'];
				}
			}
		}

		foreach ($changes as $key => $p) {
			$query = "UPDATE rating_player SET
					lastupdate = " . $time . ",
					moneygrabbed = moneygrabbed + " . (int) $p['moneygrabbed'] . ",
					moneygrabbed_day = moneygrabbed_day + " . (int) $p['moneygrabbed'] . ",
					moneygrabbed_week = moneygrabbed_week + " . (int) $p['moneygrabbed'] . ",
					moneygrabbed_month = moneygrabbed_month + " . (int) $p['moneygrabbed'] . ",
					" . ($moneygrabbedEvent ? "moneygrabbed_event = moneygrabbed_event + " . (int) $p['moneygrabbed'] . "," : "") . "
					moneylost = moneylost + " . (int) $p['moneylost'] . ",
					moneylost_day = moneylost_day + " . (int) $p['moneylost'] . ",
					moneylost_week = moneylost_week + " . (int) $p['moneylost'] . ",
					moneylost_month = moneylost_month + " . (int) $p['moneylost'] . ",
					wins = wins + " . (int) $p['wins'] . ",
					wins_day = wins_day + " . (int) $p['wins'] . ",
					wins_week = wins_week + " . (int) $p['wins'] . ",
					wins_month = wins_month + " . (int) $p['wins'] . "
					WHERE player = " . $key . " LIMIT 1";
			self::$sql->query($query);
		}
		*/
		//self::$sql->query("INSERT INTO `value` (`name`, `value`) VALUE('rating_players_lastupdatetime', " . $time . ") ON DUPLICATE KEY UPDATE `value` = " . $time);
		//self::$sql->query("INSERT INTO `value` (`name`, `value`) VALUE('rating_players_lastfightid', " . $lastid . ") ON DUPLICATE KEY UPDATE `value` = " . $lastid);

		//
		$ratingMoneygrabbed = Rating::playerRating('', 'moneygrabbed', '', '', 3, 0);
		//$ratingMoneygrabbed = Rating::playerRating('', 'moneygrabbed', 3, 0);
		$ratingClans = Rating::clanRating('', 3, 0);
		$rating = array('moneygrabbed' => $ratingMoneygrabbed, 'clans' => $ratingClans);
		file_put_contents('@cache/rating_side.html', Xslt::getHtml2('rating/side', $rating));
		//self::$sql->query("UPDATE `value` SET `value`='" . mysql_real_escape_string(Xslt::getHtml2('rating/side', $rating)) . "' WHERE name='rating_side'");
	}

	public static function calcLevelGroups() {
		$sql = "select level, count(1) as am from player group by level";
		$results = Page::$sql->getRecordSet($sql);
		$a = array();
		foreach ($results as $c) {
			$a[$c['level']] = $c['am'];
		}
		$real = array();
		for ($j = 1; $j <= count($a); $j ++) {
			$level = $j;
			$amount = $a[$j];
			if ($amount >= 150 || $level <= 14) {
				$real[$level] = $level;
			} else {
				//$c = 0;
				//for ($i = $level; $i <= count($a); $i ++) {
				//	$c += $a[$i];
				//}
				//if ($c >= 60) {
				//	$real[$level] = $level;
				//} else {
					$real[$level] = $real[$level-1];
				//}
			}
			Page::$cache->set('levelgroups_' . $level, $real[$level], 86400);
		}
		Page::setValueFromDB('levelgroups', json_encode($real));
		var_dump($real);
	}

	/*
	 * Пересчитывает бои в рейтинг
	 * @param int $fromId id первого боя
	 * @param int $toId id последнего боя
	 */

	private static function recalc($fromId, $toId) {
		$changes = array();
		$fights = self::$sql->getRecordSet("SELECT id, player1 as p1, player2 as p2, profit as p, winner as w, time as t FROM duel WHERE id BETWEEN " . $fromId . " AND " . $toId);
		if (is_array($fights) && count($fights)) {
			foreach ($fights as $f) {
				if ($f['p1'] == $f['w']) {
					$w = $f['p1'];
					$l = $f['p2'];
				} else if ($f['p2'] == $f['w']) {
					$w = $f['p2'];
					$l = $f['p1'];
				}
				$changes[$w]['moneygrabbed'] += $f['p'];
				$changes[$w]['wins']++;
				$changes[$l]['moneylost'] += $f['p'];
				if ($lastid < $f['id']) {
					$lastid = $f['id'];
				}
			}
		}

		foreach ($changes as $key => $p) {
			$query = "UPDATE rating_player SET
					moneygrabbed = moneygrabbed + " . (int) $p['moneygrabbed'] . ",
					moneylost = moneylost + " . (int) $p['moneylost'] . ",
					wins = wins + " . (int) $p['wins'] . "
					WHERE player = " . $key . " LIMIT 1";
			self::$sql->query($query);
		}
	}

	/**
	 * Пересчет рейтинга сенсеев
	 */
	private static function updateRatingPlayerReferers() {
		$query = "INSERT INTO rating_player(player, referers) (SELECT referer player, COUNT(1) referers FROM player WHERE referer > 0 AND password != 'd41d8cd98f00b204e9800998ecf8427e' GROUP BY referer) ON DUPLICATE KEY UPDATE referers = VALUES(referers)";
		self::$sql->query($query);
		//$query = "update rating_player as rp set rp.referers = (select ifnull(count(1),0) from player where referer = rp.player)";
		//self::$sql->query($query);

		/*
		  $query = "SELECT player, referers from rating_player where referers > 0";
		  $tmp = self::$sql->getRecordSet($query);
		  $origReferers = array();
		  if ($tmp !== false)
		  foreach ($tmp as $r) {
		  $origReferers[$r['player']] = $r['referers'];
		  }
		  $query = "SELECT referer as player, COUNT(1) as referers from player  where referer > 0 group by referer";
		  $referers = self::$sql->getRecordSet($query);
		  if ($referers !== false)
		  foreach ($referers as $r) {
		  if (!is_numeric($r['player']) || $r['referers'] == $origReferers[$r['player']]) {
		  continue;
		  }
		  $query = "update rating_player set referers = " . $r['referers'] . " where player = " . $r['player'];
		  self::$sql->query($query);
		  }
		 */
	}

	/**
	 * Пересчет рейтинга фракций
	 */
	private static function updateRatingFractions() {
		$fractions = self::$sql->getRecordSet("SELECT rp.fraction, (SELECT COUNT(1) FROM rating_player WHERE rp.fraction = fraction) as members, SUM(rp.wins) as wins, SUM(rp.moneygrabbed) as moneygrabbed FROM rating_player rp GROUP BY rp.fraction");
		if (is_array($fractions) && count($fractions))
			foreach ($fractions as $f) {
				$query = "update rating_fraction SET members = " . $f['members'] . ", wins = " . $f['wins'] . ", moneygrabbed = " . $f['moneygrabbed'] . " WHERE fraction = '" . $f['fraction'] . "' LIMIT 1";
				self::$sql->query($query);
			}
	}

	/**
	 * Пересчет рейтинга кланов
	 */
	private static function updateRatingClans() {
		//Page::$sql->query("UPDATE rating_clan rc, clan c SET rc.exp = (c.money + (c.ore + c.honey) * 50) WHERE c.id = rc.clan");
		Page::$sql->query("UPDATE rating_clan rc SET rc.exp = 0");
		$clans = Page::$sql->getRecordSet("SELECT clan, SUM( statsum ) AS statsum, COUNT( 1 ) AS amount FROM player WHERE clan >0 AND accesslevel >=0 GROUP BY clan");
		foreach ($clans as &$c) {
			if ($c['amount'] > 25) {
				$c['statsum'] = $c['statsum'] / $c['amount'] * 25;
			}
			Page::$sql->query("UPDATE rating_clan rc, clan c SET rc.exp = " . $c['statsum'] . " * (100 + (c.level - 1) * 10) / 100 WHERE c.id = rc.clan AND c.id = " . $c['clan']);
		}
	}

	/**
	 * Начисление дохода за хату
	 */
	private static function addHomeSalary() {
		self::$sql->query("UPDATE player SET money=money+home_price*(100+home_comfort*10)/100 WHERE is_home_available=1 AND accesslevel>=0 AND state!='police'");
	}
/*
	private static function endWorkPetriks() {
		Page::startTransaction("cron_end_work_petriks", false, 30, true);
		//self::$sql->query("START TRANSACTION");
		$time = time();
		$dt = date("Y-m-d H:i:s", $time);

		// Зачисление петриков сразу всем пользователям
		self::$sql->query("UPDATE player SET petriks=petriks+5 WHERE id IN (SELECT pw.player FROM playerwork pw WHERE pw.endtime < " . $time . " AND type='petriks')");
		// По хорошему тут надо смотреть сколько строк измененено и дальше не выполнять.
		// Но на раббочем сервере отсутствие изменённых строк крайне мало вероятно,
		// поэтому лишняя проверка опущена


		// Отправка логов сразу всем пользователям
		self::$sql->query("INSERT INTO log (player, type, `read`, params, visible, dt)
							SELECT pw.player, 'ptrk2' type, 0 `read`, CONCAT('{\\\"p\\\":', p.petriks, '}'), 1, '" . $dt . "'
							FROM playerwork pw
							INNER JOIN player p ON p.id = pw.player
							WHERE pw.type='petriks' AND pw.endtime < " . $time);
		self::$sql->query("UPDATE player2 SET newlogs = newlogs + 1 WHERE player IN (SELECT pw.player FROM playerwork pw WHERE pw.type='petriks' AND pw.endtime < " . $time . ")");
		// Удаление работ из списка
		self::$sql->query("DELETE FROM playerwork WHERE type='petriks' AND endtime < " . $time);
		//self::$sql->query("COMMIT");

		Page::endTransaction("cron_end_work_petriks", false);
	}

	private static function endWorkMetro() {
		Page::startTransaction("cron_end_work_metro", false, 30, true);
		$time = time();

		// Установка стейтов сразу всем пользователям
		// ВНИМАНИЕ! для увеличения производительности в этом методе была отключена раздача вещей
		// и проверка событий, т.к. на момент написания их небыло. Если в дальнейшем это потребуется то
		// нужно будет переписать его по аналогии с endWorkMetro или endWorkPatrol

		//self::$sql->query("START TRANSACTION");
		self::$sql->query("INSERT INTO player(id, timer, state)
							SELECT pw.player id, 1 timer, 'metro_done' state
							FROM playerwork pw
							INNER JOIN player p ON p.id = pw.player
							WHERE pw.endtime < " . $time . " AND pw.type='metro' AND p.state != 'police'
							ON DUPLICATE KEY UPDATE timer = VALUES(timer), state = VALUES(state)");

		// Удаление работ сразу всех пользователей
		self::$sql->query("DELETE FROM playerwork WHERE type='metro' AND endtime < " . $time);
		//self::$sql->query("COMMIT");

		Page::endTransaction("cron_end_work_metro", false);
	}

	private static function  endWorkPatrol(){
		Page::startTransaction("cron_end_work_patrol", false, 30, true);
		$time = time();
		$dt = date("Y-m-d H:i:s", $time);

		//self::$sql->query("START TRANSACTION");
		// Начисление платежа сразу всем
		self::$sql->query("INSERT INTO player(id, timer, state, exp, money)
							SELECT pw.player id, 1 timer, '' state, pw.exp, pw.salary money
							FROM playerwork pw
							INNER JOIN player p ON p.id = pw.player
							WHERE pw.endtime < " . $time . " AND pw.type='patrol' AND p.state != 'police'
							ON DUPLICATE KEY UPDATE timer = VALUES(timer), state = VALUES(state), exp = p.exp + VALUES(exp), money = p.money + VALUES(money)");

		// Получение списка работ для дополнительного обхода. Нужно для проверки событий и раздачи вещей
		// В этом месте запросы ен экономятся =(
		$works = self::$sql->getRecordSet("SELECT p.level, pw.player, pw.type, pw.time, pw.salary, pw.exp, pw.params FROM playerwork pw INNER JOIN player p ON p.id = pw.player WHERE pw.type = 'patrol' AND p.state != 'police' AND pw.endtime < " . $time);
		if ($works) {
			// Сброс флага напёрстков сразу для всех
			self::$sql->query("UPDATE player2 SET naperstki=-1, naperstkidata='' WHERE naperstki!=1 AND player IN SELECT pw.player FROM playerwork pw WHERE pw.type = 'patrol' AND pw.endtime < " . $time);

			// Вставка логов одновременно для всех игроков одним запросом
			self::$sql->query("INSERT INTO log (player, type, `read`, params, visible, dt)
								SELECT pw.player, 'patrol_endwork' type, 0 `read`, CONCAT('{\\\"money\\\":', pw.salary, ',\\\"exp\\\":', pw.exp, ',\\\"mbckp\\\":{\\\"m\\\":', p.money, ',\\\"o\\\":', p.ore, ',\\\"h\\\":', p.honey, '}}'), 1, '" . $dt . "'
								FROM playerwork pw
								INNER JOIN player p ON p.id = pw.player
								WHERE pw.type='patrol' AND p.state != 'police' AND pw.endtime < " . $time);

			self::$sql->query("UPDATE player2 SET newlogs = newlogs + 1 WHERE player IN (SELECT pw.player FROM playerwork pw INNER JOIN player p ON p.id = pw.player WHERE pw.type='patrol' AND p.state != 'police' AND pw.endtime < " . $time . ")");
			// Удаление работ из списка
			self::$sql->query("DELETE FROM playerwork WHERE type='patrol' AND endtime < " . $time);
			//self::$sql->query("COMMIT");

			Std::loadMetaObjectClass("standard_item");
			foreach ($works as $w) {
				// на деве работы в 60 раз быстрее, тут фикс
				if (DEV_SERVER) {
					$w["time"] = ceil($w["time"] / 60) * 60 * 60;
				}

				// выпадение вещей
				$w["time"] /= 60;
	
				// проверка на срабатывание события
				// перенес после нормирования $w['time']
				Page::checkEvent($w["player"], "patrol_finished", 0, $w["time"]);
			}
		} else {
			self::$sql->query("DELETE FROM playerwork WHERE type='patrol' AND endtime < " . $time);
			//self::$sql->query("COMMIT");
		}

		Page::endTransaction("cron_end_work_patrol", false);
	}

	private static function  endWorkMacdonalds(){
		Page::startTransaction("cron_end_work_macdonalds", false, 30, true);
		$time = time();
		$dt = date("Y-m-d H:i:s", $time);

		//self::$sql->query("START TRANSACTION");
		// Начисление платежа сразу всем
		self::$sql->query("INSERT INTO player(id, timer, state, exp, money)
							SELECT pw.player id, 1 timer, '' state, pw.exp, pw.salary money
							FROM playerwork pw
							INNER JOIN player p ON p.id = pw.player
							WHERE pw.endtime < " . $time . " AND pw.type='macdonalds' AND p.state != 'police'
							ON DUPLICATE KEY UPDATE timer = VALUES(timer), state = VALUES(state), exp = p.exp + VALUES(exp), money = p.money + VALUES(money)");

		// Получение списка работ для дополнительного обхода. Нужно для проверки событий и раздачи вещей
		// В этом месте запросы ен экономятся =(
		$works = self::$sql->getRecordSet("SELECT p.level, pw.player, pw.type, pw.time, pw.salary, pw.exp, pw.params FROM playerwork pw INNER JOIN player p ON p.id = pw.player WHERE pw.type = 'macdonalds' AND p.state != 'police' AND pw.endtime < " . $time);
		if ($works) {
			// Вставка логов одновременно для всех игроков одним запросом
			self::$sql->query("INSERT INTO log (player, type, `read`, params, visible, dt)
								SELECT pw.player, 'macdonalds_endwork' type, 0 `read`, CONCAT('{\\\"money\\\":', pw.salary, ',\\\"exp\\\":', pw.exp, ',\\\"mbckp\\\":{\\\"m\\\":', p.money, ',\\\"o\\\":', p.ore, ',\\\"h\\\":', p.honey, '}}'), 1, '" . $dt . "'
								FROM playerwork pw
								INNER JOIN player p ON p.id = pw.player
								WHERE pw.type='macdonalds' AND p.state != 'police' AND pw.endtime < " . $time);

			self::$sql->query("UPDATE player2 SET newlogs = newlogs + 1 WHERE player IN (SELECT pw.player FROM playerwork pw INNER JOIN player p ON p.id = pw.player WHERE pw.type='macdonalds' AND p.state != 'police' AND pw.endtime < " . $time . ")");
			// Удаление работ из списка
			self::$sql->query("DELETE FROM playerwork WHERE type='macdonalds' AND endtime < " . $time);
			//self::$sql->query("COMMIT");

			Std::loadMetaObjectClass("standard_item");
			foreach ($works as $w) {
				// на деве работы в 60 раз быстрее, тут фикс
				if (DEV_SERVER) {
					$w["time"] = ceil($w["time"] / 60) * 60 * 60;
				}

				// выпадение вещей
				$w["time"] /= 3600;

				// проверка на срабатывание события
				// перенес после нормирования $w['time']
				Page::checkEvent($w["player"], "macdonalds_finished", 0, $w["time"]);
			}
		} else {
			self::$sql->query("DELETE FROM playerwork WHERE type='macdonalds' AND endtime < " . $time);
			//self::$sql->query("COMMIT");
		}

		Page::endTransaction("cron_end_work_macdonalds", false);
	}

	private static function endWorkTraining() {
		Page::startTransaction("cron_end_work_training", false, 30, true);
		$time = time();
		$dt = date("Y-m-d H:i:s", $time);

		// Тут не получилось свести к одному запросу т.к. прокаченные статы хранятся в формате JSON их нужно разбирать
		$works = self::$sql->getRecordSet("SELECT pw.params FROM playerwork pw WHERE pw.type = 'training' AND pw.endtime < " . $time);
		if ($works) {
			// Вставка логов одновременно для всех игроков одним запросом
			//self::$sql->query("START TRANSACTION");
			self::$sql->query("INSERT INTO log (player, type, `read`, params, visible, dt)
								SELECT pw.player, 'trnrfntr' type, 0 `read`, CONCAT('{\\\"s\\\":', pw.params, '}'), 1, '" . $dt . "'
								FROM playerwork pw
								INNER JOIN player p ON p.id = pw.player
								WHERE pw.type='training' AND pw.endtime < " . $time);

			self::$sql->query("UPDATE player2 SET newlogs = newlogs + 1 WHERE player IN (SELECT pw.player FROM playerwork pw WHERE pw.type='training' AND pw.endtime < " . $time . ")");

			// Удаление работ из списка
			self::$sql->query("DELETE FROM playerwork WHERE type='training' AND endtime < " . $time);

			$stats = array("h" => "health", "s" => "strength", "d" => "dexterity", "r" => "resistance", "i" => "intuition", "a" => "attention", "c" => "charism");
			foreach ($works as $w) {
				if (strlen($w["params"]) > 10) {
					$w["params"] = json_decode($w["params"], true);
					$sql = array();
					foreach ($w["params"] as $stat => $params) {
						$sql[] = $stats[$stat] . "=" . $stats[$stat] . "+" . $params["c"] . "," .
								$stats[$stat] . "_finish=" . $stats[$stat] . "_finish+" . $params["c"];
					}
					if (sizeof($sql) > 0) {
						self::$sql->query("UPDATE player SET " . implode(",", $sql) . " WHERE id=" . $w["player"]);
					}
				}
			}
			//self::$sql->query("COMMIT");
		} else {
			//self::$sql->query("COMMIT");
		}

		Page::endTransaction("cron_end_work_training", false);
	}
	*/

	/**
	 * Завершение работы в шаурбургерсе и в метро
	 */
	private static function endWork() {
//$time = time() + 59;
		$lock = (int) self::$sql->getValue("SELECT value FROM value WHERE name = 'endwork_lock'");
		if ($lock == 1) {
			return;
		} else {
			self::$sql->query("UPDATE value SET value = 1 WHERE name = 'endwork_lock'");
		}
		$time = time();
		$works = self::$sql->getRecordSet("SELECT pw.player, pw.salary, pw.exp, pw.type, pw.time, pw.params, p.state, p.stateparam, p.timer FROM playerwork pw LEFT JOIN player p ON p.id=pw.player WHERE pw.endtime < " . $time . " LIMIT 0, 3000");
//self::sqlQuery("DELETE FROM playerwork WHERE endtime <= " . $time);
		if ($works == false) {
			self::$sql->query("UPDATE value SET value = 0 WHERE name = 'endwork_lock'");
			return;
		}
//$fp = fopen('work.log', 'a');
		try {
			foreach ($works as $w) {

				// производство нано-петриков

				if ($w['type'] == 'petriks') {
					//continue; // отключил на время
					$attempts = 0;
					$query = "DELETE FROM playerwork WHERE player = " . $w['player'] . " AND type='" . $w['type'] . "'";
					do {
						$attempts++;
						$result = self::$sql->query($query);
						if ($result === false) {
							usleep(1);
						}
					} while ($result === false && $attempts <= 5);
					if ($result === false) {
						continue;
					}
					$w['params'] = json_decode($w['params'], true);
					$petriks = $w['params']['petriks'];
					if ($petriks != 5 && $petriks != 10) {
						$petriks = 5;
					}
					self::$sql->query("UPDATE player SET petriks=petriks+" . $petriks . " WHERE id=" . $w['player']);
					$petriksGot = $petriks;
					$petriks = self::$sql->getValue("SELECT petriks FROM player WHERE id=" . $w['player']);

					Page::sendLog($w['player'], 'ptrk2', array('p' => $petriks, 'p2' => $petriksGot));

					Page::checkEvent($w['player'], 'petriks_finished', $petriks);

					continue;
				}

				// ВИП-тренировка статов
				if ($w['type'] == 'training') {
					//continue; // Отключил
					$attempts = 0;
					$query = "DELETE FROM playerwork WHERE player = " . $w['player'] . " AND type='" . $w['type'] . "'";
					do {
						$attempts++;
						$result = self::$sql->query($query);
						if ($result === false) {
							usleep(1);
						}
					} while ($result === false && $attempts <= 5);
					if ($result === false) {
						continue;
					}

					if (strlen($w['params']) > 10) {
						$stats = array('h' => 'health', 's' => 'strength', 'd' => 'dexterity', 'r' => 'resistance',
							'i' => 'intuition', 'a' => 'attention', 'c' => 'charism');
						$sql = '';
						$w['params'] = json_decode($w['params'], true);
						$sql = array();
						foreach ($w['params'] as $stat => $params) {
							$sql[] = $stats[$stat] . '=' . $stats[$stat] . '+' . $params['c'] . ',' .
									$stats[$stat] . '_finish=' . $stats[$stat] . '_finish+' . $params['c'];
						}
						if (sizeof($sql) > 0) {
							self::$sql->query("UPDATE player SET " . implode(',', $sql) . " WHERE id=" . $w['player']);

							Page::sendLog($w['player'], 'trnrfntr', array('s' => $w['params']));
						}
					}
					continue;
				}

				// метро, патруль, шаурбургерс
				$fields = array();
				if ($w['type'] == 'metro') {
					//continue; // отключил
					if ($w['state'] == 'police' && $w['stateparam'] == 'admin') {
						$fields['state'] = "'police'";
						$timer = $w['timer'];
					} else {
						$fields['state'] = "'metro_done'";
						$timer = 1;
					}
				} else {
					if ($w['state'] == 'police' && $w['stateparam'] == 'admin') {
						$fields['state'] = "'police'";
						$timer = $w['timer'];
					} else {
						$fields['state'] = "''";
						$timer = 1;
					}
					if ($w['exp'] > 0) {
						$fields['exp'] = 'exp + ' . $w['exp'];
					}
					if ($w['salary'] > 0) {
						if (($w['type'] == "macdonalds" && self::$sql->getValue("SELECT count(*) FROM gift WHERE code='shaurbadge' AND player = " . $w['player']) == 1) ||
							($w['type'] == "patrol" && self::$sql->getValue("SELECT count(*) FROM gift WHERE code='svistok' AND player = " . $w['player']) == 1)
						) {
							$w['salary'] += round($w['salary'] * 0.3);
						}
						$fields['money'] = 'money + ' . $w['salary'];
					}
				}

				$query = "UPDATE player SET timer = $timer ";
				foreach ($fields as $key => $value) {
					$query .= ", " . $key . " = " . $value;
				}
				$query .= " WHERE id = " . $w['player']; // . " LIMIT 1";
				//fwrite($fp, $query . "\r\n");
				$result = self::$sql->query($query);
				if ($result === false) {
					continue;
				}

				$attempts = 0;
				$query = "DELETE FROM playerwork WHERE player = " . $w['player'] . " AND type='" . $w['type'] . "'";
				do {
					$attempts++;
					$result = self::$sql->query($query);
					if ($result === false) {
						usleep(1);
					}
				} while ($result === false && $attempts <= 5);
				if ($result === false) {
					//fwrite($fp, "ATATAT " . $query . "\r\n");
					continue;
				}

				//echo $w['player'] . ' - ' . $w['salary'] . ' - ' . $w['exp'] . '<br/>';
				// на деве работы в 60 раз быстрее, тут фикс
				if (DEV_SERVER) {
					$w['time'] = ceil($w['time'] / 60) * 60 * 60;
				}

				if ($w['player'] == 1) {
					file_put_contents('email.log', print_r($w, true));
				}

				// выпадение вещей
				$playerLevel = self::$sql->getValue("SELECT level FROM player WHERE id = " . $w['player'] . " LIMIT 1");
				if ($w['type'] == 'macdonalds') {
					$w['time'] /= 3600;
					$k = $w['time'];
				} elseif ($w['type'] == 'patrol') {
					$w['time'] /= 60;
					$k = round($w['time'] / 120, 2);
				} elseif ($w['type'] == 'metro') {
					$k = 0.01;
				}

				// проверка на срабатывание события
				// перенес после нормирования $w['time']
				if ($w['type'] == 'macdonalds') {
					Page::checkEvent($w['player'], 'macdonalds_finished', 0, $w['time']);
				} else if ($w['type'] == 'patrol') {
					Page::checkEvent($w['player'], 'patrol_finished', 0, $w['time']);
				} else if ($w['type'] == 'metro') {
					Page::checkEvent($w['player'], 'metro_finished');
				}

				$r = rand(0, 10000) / 100;
				$time = strtotime(date('H:i'));
				$query = "SELECT * FROM itemdrop
						WHERE event_type = '" . $w['type'] . "'
						AND (event_time_min <= " . $w['time'] . " AND  " . $w['time'] . " <= event_time_max)
						AND " . $r . " <= probability * " . $k . "
						AND (condition_time_min <= " . $time . " AND " . $time . " <= condition_time_max)
						AND (condition_level_min <= " . $playerLevel . " AND " . $playerLevel . " <= condition_level_max)
						AND (amount = 0 OR (SELECT COUNT(1) FROM itemdroplog idl where idl.itemdrop = itemdrop.id AND idl.player = " . $w['player'] . ") < amount) ";
				$result = self::$sql->getRecordSet($query);
				if ($result != false) {
					Std::loadMetaObjectClass('standard_item');
					foreach ($result as $i) {
						$item = new standard_itemObject();
						$item->load($i['item']);
						$item->makeExampleOrAddDurability($w['player']);
						$query = "INSERT INTO itemdroplog (itemdrop, player, time) VALUES(" . $i['id'] . ", " . $w['player'] . ", " . time() . ")";
						self::$sql->query($query);
					}
				}

				// сброс флага наперстков
				if ($w['type'] == 'patrol') {
					self::$sql->query("UPDATE player2 SET naperstki=-1, naperstkidata='' WHERE naperstki!=1 AND player=" . $w['player']);
				}

				// логи
				if ($w['type'] == 'patrol') {
					Page::sendLog($w['player'], 'patrol_endwork', array('money' => $w['salary'], 'exp' => $w['exp']), 0, time());
				} else if ($w['type'] == 'macdonalds') {
					Page::sendLog($w['player'], 'macdonalds_endwork', array('money' => $w['salary'], 'exp' => $w['exp']), 0, time());
				}
			}
		} catch (Exception $e) {
			self::$sql->query("UPDATE value SET value = 0 WHERE name = 'endwork_lock'");
		}
//fclose($fp);
		self::$sql->query("UPDATE value SET value = 0 WHERE name = 'endwork_lock'");
	}

	/**
	 * Удаление истекших бустов
	 */
	private static function removeBoosts2() {
		$time = time();
		$lock = fopen("@cache/removeboosts2.lock", "r+");
		if (!flock($lock, LOCK_EX | LOCK_NB)) {
			fclose($lock);
			return;
		}
		$boosts = self::$sql->getRecordSet("SELECT * FROM playerboost2 WHERE dt2 < now() LIMIT 10000");
		if ($boosts) {
			Std::loadMetaObjectClass('player');
			foreach ($boosts as $boost) {
				$p = new playerObject();
				$p->load($boost['player']);
				$p->calcStats($boost, -1);

				self::$sql->query("DELETE FROM playerboost2 WHERE player=" . $boost['player'] . " AND type='" . $boost['type'] . "' AND code='" . $boost['code'] . "'");
			}
		}
		flock($lock, LOCK_UN);
		fclose($lock);
	}

	/**
	 * Удаление клановых и фракционных бустов
	 */
	private static function removeBoosts() {
		$sql = "SELECT clan FROM boost WHERE clan > 0 AND dt2 < now()";
		$clans = Page::$sql->getValueSet($sql);
		if (is_array($clans) && count($clans)) {
			foreach ($clans as $clan) {
				Page::$cache->delete('clan_boosts/' . $clan);
			}
		}
		self::$sql->query("DELETE FROM boost WHERE dt2 < now()");
	}

	/**
	 * Рассчет средних статов на уровне для определения стоимости статов
	 *
	 * @return null
	 */
	private static function calcAvgStats($force = false) {
		if (date('H', time()) != 4 && !$force) {
			return;
		}
		$curMaxLevel = CacheManager::get('value_maxlevel');

		$stats = array('health', 'strength', 'dexterity', 'intuition', 'resistance', 'attention', 'charism');

		// type = 1
		for ($i = 1; $i <= $curMaxLevel; $i++) {
			$playerCount = self::$sql->getValue("SELECT count(*) FROM player WHERE level=" . $i);
			$health = self::$sql->getValue("SELECT sum(health) FROM player WHERE level=" . $i) / $playerCount;
			$strength = self::$sql->getValue("SELECT sum(strength) FROM player WHERE level=" . $i) / $playerCount;
			$dexterity = self::$sql->getValue("SELECT sum(dexterity) FROM player WHERE level=" . $i) / $playerCount;
			$intuition = self::$sql->getValue("SELECT sum(intuition) FROM player WHERE level=" . $i) / $playerCount;
			$resistance = self::$sql->getValue("SELECT sum(resistance) FROM player WHERE level=" . $i) / $playerCount;
			$attention = self::$sql->getValue("SELECT sum(attention) FROM player WHERE level=" . $i) / $playerCount;
			$charism = self::$sql->getValue("SELECT sum(charism) FROM player WHERE level=" . $i) / $playerCount;

			if ($i > 5) {
				$k = 1.5;
				if ($i >= 9) {
					if (date("Y", time()) == 2010 && (int) date("m", time()) == 6) {
						$diff = (int) date("d", time()) - 2;
						$k = 2 - $diff * 0.03;
						if ($k < 1.5) {
							$k = 1.5;
						}
					}
				}

				$health = $health1 * $k > $health ? $health : $health1 * $k;
				$strength = $strength1 * $k > $strength ? $strength : $strength1 * $k;
				$dexterity = $dexterity1 * $k > $dexterity ? $dexterity : $dexterity1 * $k;
				$intuition = $intuition1 * $k > $intuition ? $intuition : $intuition1 * $k;
				$resistance = $resistance1 * $k > $resistance ? $resistance : $resistance1 * $k;
				$attention = $attention1 * $k > $attention ? $attention : $attention1 * $k;
				$charism = $charism1 * $k > $charism ? $charism : $charism1 * $k;
			}

			self::$sql->query("INSERT INTO levelstat (type, level, health, strength, dexterity, intuition, resistance, attention, charism, dt)
                VALUES (1, $i, $health, $strength, $dexterity, $intuition, $resistance, $attention, $charism, now())");

			$health1 = $health;
			$strength1 = $strength;
			$dexterity1 = $dexterity;
			$intuition1 = $intuition;
			$resistance1 = $resistance;
			$attention1 = $attention;
			$charism1 = $charism;
		}

		// type = 2
		$statsOnLevel = array();
		for ($i = 1; $i <= $curMaxLevel; $i++) {
			$playerCount = self::$sql->getValue("SELECT count(*) FROM player WHERE level=" . $i);

			$health = self::$sql->getValue("SELECT sum(health) FROM player WHERE level=" . $i) / $playerCount;
			$strength = self::$sql->getValue("SELECT sum(strength) FROM player WHERE level=" . $i) / $playerCount;
			$dexterity = self::$sql->getValue("SELECT sum(dexterity) FROM player WHERE level=" . $i) / $playerCount;
			$intuition = self::$sql->getValue("SELECT sum(intuition) FROM player WHERE level=" . $i) / $playerCount;
			$resistance = self::$sql->getValue("SELECT sum(resistance) FROM player WHERE level=" . $i) / $playerCount;
			$attention = self::$sql->getValue("SELECT sum(attention) FROM player WHERE level=" . $i) / $playerCount;
			$charism = self::$sql->getValue("SELECT sum(charism) FROM player WHERE level=" . $i) / $playerCount;

			if ($playerCount > 60 || $i == 1) {
				self::$sql->query("INSERT INTO levelstat (type, level, health, strength, dexterity, intuition, resistance, attention, charism, dt)
                    VALUES (2, $i, $health, $strength, $dexterity, $intuition, $resistance, $attention, $charism, now())");
			} else {
				$health = ($health + $statsOnLevel[$i - 1]['health']) / 2;
				$strength = ($strength + $statsOnLevel[$i - 1]['strength']) / 2;
				$dexterity = ($dexterity + $statsOnLevel[$i - 1]['dexterity']) / 2;
				$intuition = ($intuition + $statsOnLevel[$i - 1]['intuition']) / 2;
				$resistance = ($resistance + $statsOnLevel[$i - 1]['resistance']) / 2;
				$attention = ($attention + $statsOnLevel[$i - 1]['attention']) / 2;
				$charism = ($charism + $statsOnLevel[$i - 1]['charism']) / 2;

				self::$sql->query("INSERT INTO levelstat (type, level, health, strength, dexterity, intuition, resistance, attention, charism, dt)
                    VALUES (2, $i, $health, $strength, $dexterity, $intuition, $resistance, $attention, $charism, now())");
			}

			$statsOnLevel[$i] = array(
				'health' => $health,
				'strength' => $strength,
				'dexterity' => $dexterity,
				'intuition' => $intuition,
				'resistance' => $resistance,
				'attention' => $attention,
				'charism' => $charism,
			);
		}

		// type = 3
		$statsOnLevel = array();
		$playersOnLevel = array();
		for ($i = 1; $i <= $curMaxLevel; $i++) {
			$playerCount = self::$sql->getValue("SELECT count(*) FROM player WHERE level=" . $i);

			$playersOnLevel[$i] = $playerCount;
			// если количество людей на уровне <60, то для следующего уровня будет считаться, что количество игроков на прошлом уровне равно количеству людей на всех предыдущих уровнях
			if ($playerCount <= 60 && $i > 1) {
				$playersOnLevel[$i]+=$playersOnLevel[$i - 1];
			}

			$health = self::$sql->getValue("SELECT sum(health) FROM player WHERE level=" . $i) / $playerCount;
			$strength = self::$sql->getValue("SELECT sum(strength) FROM player WHERE level=" . $i) / $playerCount;
			$dexterity = self::$sql->getValue("SELECT sum(dexterity) FROM player WHERE level=" . $i) / $playerCount;
			$intuition = self::$sql->getValue("SELECT sum(intuition) FROM player WHERE level=" . $i) / $playerCount;
			$resistance = self::$sql->getValue("SELECT sum(resistance) FROM player WHERE level=" . $i) / $playerCount;
			$attention = self::$sql->getValue("SELECT sum(attention) FROM player WHERE level=" . $i) / $playerCount;
			$charism = self::$sql->getValue("SELECT sum(charism) FROM player WHERE level=" . $i) / $playerCount;

			if ($playerCount > 60 || $i == 1) {
				self::$sql->query("INSERT INTO levelstat (type, level, health, strength, dexterity, intuition, resistance, attention, charism, dt)
                    VALUES (3, $i, $health, $strength, $dexterity, $intuition, $resistance, $attention, $charism, now())");
			} else {
				$health = ($health * $playerCount + $statsOnLevel[$i - 1]['health'] * $playersOnLevel[$i - 1]) / ($playerCount + $playersOnLevel[$i - 1]);
				$strength = ($strength * $playerCount + $statsOnLevel[$i - 1]['strength'] * $playersOnLevel[$i - 1]) / ($playerCount + $playersOnLevel[$i - 1]);
				$dexterity = ($dexterity * $playerCount + $statsOnLevel[$i - 1]['dexterity'] * $playersOnLevel[$i - 1]) / ($playerCount + $playersOnLevel[$i - 1]);
				$intuition = ($intuition * $playerCount + $statsOnLevel[$i - 1]['intuition'] * $playersOnLevel[$i - 1]) / ($playerCount + $playersOnLevel[$i - 1]);
				$resistance = ($resistance * $playerCount + $statsOnLevel[$i - 1]['resistance'] * $playersOnLevel[$i - 1]) / ($playerCount + $playersOnLevel[$i - 1]);
				$attention = ($attention * $playerCount + $statsOnLevel[$i - 1]['attention'] * $playersOnLevel[$i - 1]) / ($playerCount + $playersOnLevel[$i - 1]);
				$charism = ($charism * $playerCount + $statsOnLevel[$i - 1]['charism'] * $playersOnLevel[$i - 1]) / ($playerCount + $playersOnLevel[$i - 1]);

				self::$sql->query("INSERT INTO levelstat (type, level, health, strength, dexterity, intuition, resistance, attention, charism, dt)
                    VALUES (3, $i, $health, $strength, $dexterity, $intuition, $resistance, $attention, $charism, now())");
			}

			$statsOnLevel[$i] = array(
				'health' => $health,
				'strength' => $strength,
				'dexterity' => $dexterity,
				'intuition' => $intuition,
				'resistance' => $resistance,
				'attention' => $attention,
				'charism' => $charism,
			);
		}
	}

	/**
	 * Разморозка замороженных в течение более 30 дней
	 */
	private static function unfreezeFrozen() {
		$players = self::$sql->getValueSet("SELECT id FROM player WHERE accesslevel=-2 AND DATE_SUB(now(), INTERVAL 30 DAY)>lastactivitytime");
		if ($players) {
			Std::loadModule('Page');
			foreach ($players as $playerId) {
				Page::sendNotice($playerId, 'Вы были автоматически разморожены по истечению 30 дней с момента заморозки.');
				// сделать уведомление на e-mail
				Page::sendNotify($playerId, 'autounfreeze');
			}
			self::$sql->query("UPDATE player SET accesslevel=0, homesalarytime = " . mktime(date("H"), 0, 0) . " WHERE accesslevel=-2 AND DATE_SUB(now(), INTERVAL 30 DAY)>lastactivitytime");
		}
	}

	/**
	 * Начисление процентов на банковские вклады
	 */
	private static function addBankPercent() {
		self::$sql->query("UPDATE bankdeposit SET money=money + (money * 0.01)");
	}

	/**
	 * Включение боев для последних уровней
	 */
	private static function updateMaxLevels() {
		$curLevelFightMaxLevel = CacheManager::get('value_levelfightmaxlevel') + 1;
		if (self::$sql->getValue("SELECT count(1) FROM player WHERE level = " . $curLevelFightMaxLevel) > 5) {
			CacheManager::set('value_levelfightmaxlevel', $curLevelFightMaxLevel);
			Page::setValueFromDB('levelfightmaxlevel', $curLevelFightMaxLevel);
		}

		$curBankFightMaxLevel = CacheManager::get('value_bankfightmaxlevel') + 1;
		if (self::$sql->getValue("SELECT count(*) FROM player WHERE level= " . $curBankFightMaxLevel) > 5) {
			CacheManager::set('value_bankfightmaxlevel', $curBankFightMaxLevel);
			Page::setValueFromDB('bankfightmaxlevel', $curBankFightMaxLevel);
		}

		$curMaxLevel = CacheManager::get('value_maxlevel');
		$maxLevel = self::$sql->getValue("SELECT max(level) FROM player WHERE accesslevel = 0");
		if ($curMaxLevel != $maxLevel) {
			CacheManager::set('value_maxlevel', $maxLevel);
			Page::setValueFromDB('maxlevel', $maxLevel);
		}
	}

	/**
	 * Обработка статистики онлайна
	 *
	 * @return void
	 */
	private static function calcOnlineCountersStats($force = false) {
		/*
		  if (date('H', time()) != 3 && !$force) {
		  return;
		  }

		  self::$sql->query("UPDATE onlinecounter SET stdlon=duels/online, stmton=metro/online, stauon=auth/online
		  WHERE dt='" . date('Y-m-d', (time() - 24 * 60 * 60)) . "'");
		 */
		/*
		  $maxLevel = self::$sql->getValue("SELECT value FROM value WHERE name='bankfightmaxlevel'");

		  for ($i = 0; $i <= $maxLevel; $i++) {
		  $players = self::$sql->getValue("SELECT count(*) FROM onlinecounter WHERE level=" . $i);
		  $sums = self::$sql->getRecord("SELECT sum(stdlon) stdlon, sum(stmton) stmton, sum(stauon) stauon WHERE level=" . $i);
		  $avg = array();
		  foreach ($sums as $stat => $value) {
		  $avg[$stat] = $value / $players;
		  }
		  }
		 */
	}

	/**
	 * Список самых крутых игроков для центральной площади
	 */
	private static function getTopPlayers() {
		$maxLevel = CacheManager::get('value_maxlevel');
		$top = array();
		$id = array();
		for ($i = 1; $i <= $maxLevel; $i++) {
			if (DEV_SERVER) {
				$player = self::$sql->getRecord("SELECT id, statsum2 FROM player WHERE level=" . $i . " ORDER BY statsum2 DESC");
			} else {
				$player = self::$sql->getRecord("SELECT id, statsum2 FROM player WHERE level=" . $i . " AND accesslevel=0 ORDER BY statsum2 DESC");
				if (!$player) {
					$player = array("id" => 0, "statsum2" => 0);
				}
			}
			self::$sql->query("INSERT INTO value (value, name) VALUES (" . $player['id'] . ", 'topplayer" . $i . "')
                ON DUPLICATE KEY UPDATE value=" . $player['id']);
			if ($player["id"] > 0) {
				$top[] = $player;
				$id[] = $player['id'];
			}
		}
		$id = implode(',', $id);
		CacheManager::set('value_topplayers', $id);
		Page::setValueFromDB('topplayers', $id);

		Std::sortRecordSetByField($top, 'statsum2', 0);
		CacheManager::set('value_topplayerbest', $top[0]['id']);
		Page::setValueFromDB('topplayerbest', $top[0]['id']);

		self::$sql->query("UPDATE player2 SET toptime=toptime+15 WHERE player=" . $top[0]['id']);
	}

	/**
	 * Раздача сертификатов на бесплатную регистрацию клана тем, кто набрал 30 учеников 3-го уровня
	 */
	private static function giveClanRegCert() {
		$players = self::$sql->getValueSet("SELECT player FROM player2 p2 WHERE p2.clancertgiven=0
            AND (select count(*) FROM contact c LEFT JOIN player p ON p.id=c.player2
                WHERE player=p2.player AND type='referer' AND p.level>=3)>=30");
		if ($players) {
			Std::loadMetaObjectClass('standard_item');
			$cert = new standard_itemObject();
			$cert->loadByCode('clan_regcert');
			foreach ($players as $playerId) {
				$cert->makeExample($playerId);
				Page::sendLog($playerId, 'clnrgcrt', array());
				self::$sql->query("UPDATE player2 SET clancertgiven=1 WHERE player=" . $playerId);
			}
		}
	}

	/**
	 * Фикс с раздачей подарков в качестве компенсации
	 */
	private static function giveCompensation() {
		// защита от дурака
		$notStartAfter = strtotime('2011-04-17 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$standart_item_code = 'compensate5';

		
		$step = 5000;
		for ($i = 2227150; $i <= 2400000; $i += $step) {
			$sql = "select id from player where lastactivitytime > '2011-02-11 06:00' and id between " . $i . " and " . ($i + $step - 1);
		
			$player_ids = self::$sql->getValueSet($sql);
			if (!$player_ids) continue;
			
			foreach ($player_ids as $j) {
				// раздача
				Std::loadMetaObjectClass('standard_item');
				$item = new standard_itemObject();
				$item->loadByCode($standart_item_code);
				$item->makeExampleOrAddDurability($j);
			}
			sleep(1);
		}
	}
	
	private static function giveCompensationFood() {
		// защита от дурака
		$notStartAfter = strtotime('2011-04-17 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$standart_item_code = 'fightfood_lvl12';

		
		$step = 5000;
		for ($i = 1; $i <= 630151; $i += $step) {
			$sql = "select id from player where level=12 and id<630152 and lastactivitytime > '2011-02-11 06:00' and id between " . $i . " and " . ($i + $step - 1);
		
			$player_ids = self::$sql->getValueSet($sql);
			if (!$player_ids) continue;
			
			foreach ($player_ids as $j) {
				// раздача
				Std::loadMetaObjectClass('standard_item');
				$item = new standard_itemObject();
				$item->loadByCode($standart_item_code);
				$item->makeExampleOrAddDurability($j);
			}
			sleep(1);
		}
	}

	
	
	

	private static function giveCompensation2() {
		// защита от дурака
		$notStartAfter = strtotime('2010-12-02 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		$players = Page::$sql->getRecordSet("SELECT player, (photos/2) as amount FROM player WHERE photos > 0");

		// вводимые для фикса переменные
		$comment = 'Уважаемый игрок, в результате произошедшей ошибки вы не получили положенные вам предметы/элементы коллекций. В данный момент вам начислены все недостающие элементы. Желаем приятной игры. С уважением, Администрация.';

		Std::loadMetaObjectClass('standard_item');
		foreach ($players as $p) {
			// пяни
			$item = new standard_itemObject();
			$item->loadByCode('pyani');
			echo $player . PHP_EOL;
			for ($i = 0; $i < $i; $i ++) {
				//$item->makeExampleOrAddDurability($id);
				echo 'give' . PHP_EOL;
			}
		}

	}

	private static function giveCompensation3() {
		// защита от дурака
		$notStartAfter = strtotime('2010-11-05 00:00:00');
		if (time() > $notStartAfter) {
			echo 'time defence';
			return;
		}
		echo 'start giving';

		$player_ids = array(1, 3, 20);


		// вводимые для фикса переменные


		$comment = 'Недостающая часть сундучка';
		$standart_item_code = 'compensate3';

		foreach ($player_ids as $id) {
			Std::loadMetaObjectClass('standard_item');
			$item = new standard_itemObject();
			$item->loadByCode($standart_item_code);
			$item->giveGift('Администрация', $id, $comment, 0, 0);
		}

		echo 'end giving';
	}

	private static function giveBirthdayGifts() {
		// защита от дурака
		$notStartAfter = strtotime('2011-01-02 01:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$standart_item_code = 'present_ny2011_13';


		/*
		  $player_ids = array (
		  '3',
		  );
		 */

		$player_levels = array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 1, 2);
		$comment = '';
		
		//foreach ($player_levels as $lvl) {
		
		Std::loadMetaObjectClass('standard_item');
		$from = 1800001;
		$to = 1900000;
		
		$sql = "select id from player where email!='' and id between " . $from . " and " . $to;
		$player_ids = self::$sql->getValueSet($sql);

		if (!$player_ids) continue;
		foreach ($player_ids as $i) {
			// раздача
			$item = new standard_itemObject();
			$item->loadByCode($standart_item_code);
			$q = $item->giveGift('Администрация', $i, $comment, 0, 0);
			$q = null;
		}
		
	}
	
	
	private static function giveCompensation4() {
		// защита от дурака
		$notStartAfter = strtotime('2010-12-16 00:00:00');
		if (time() > $notStartAfter) {
			echo 'time defence';
			return;
		}
		echo "start giving
";

		$player_levels = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,16);
		
		
		// --------------------------- мажорство -----------------------------
		
		$player_ids = array(1998,1451516,1455044,186013,186013,186013,579116,297615,129515,791739,681301,1492630,1998,87949,1088181,240090,778944,888237,1,3,1,1,1145585);
		$collection_id = 24; // мажорство

		foreach ($player_levels as $lvl) {
			$players = self::$sql->getValueSet("select id from player where level=" . $lvl ." and id in (".implode(",", $player_ids).")");
			if (!$players) continue;
			$sql = "SELECT * FROM collection WHERE id = " . $collection_id;

			$collection = Page::sqlGetCacheRecord($sql, 60);
			
			if ($collection) {
				foreach ($players as $i) {
					Page::giveCollectionElement($i, $collection);
				}
			}
		}
		// -------------------------------------------------------------------
		
		
		// --------------------------- банковская коллекция -----------------------------
		
		$player_ids = array(3,326467,326467,637290,310928,529955,159765,146771,459244,107101,182836,277291,107426,972659,321009,321009,321009,178614,182983,219152,219152,219152,349136,775694,775694,639839,426870,426870,417272,417272);
		$collection_id = 16; // банковская

		foreach ($player_levels as $lvl) {
			$players = self::$sql->getValueSet("select id from player where level=" . $lvl ." and id in (".implode(",", $player_ids).")");
			if (!$players) continue;
			$sql = "SELECT * FROM collection WHERE id = " . $collection_id;
			
			$collection = Page::sqlGetCacheRecord($sql, 60);
			
			if ($collection) {
				foreach ($players as $i) {
					Page::giveCollectionElement($i, $collection);
				}
			}
		}
		// -------------------------------------------------------------------
		
		
		// --------------------------- охотничья коллекция -----------------------------
		
		$player_ids = array(3,250631,816844,381362,266425,160577,160577,799365,252514,514927,514927,201253,380672,1208791,796810,1025388,284423,296380,296380,900608,162653,370984,277664,139291,292317,17648,206630,1084668,592185,303526,12777,430468,430468,323321,587533,528124,286909,387242,21597,300866,1407748,86931,1310841,864122,514724,514724,1095008,1095008,760032,365152,464524,1,1453987,350129,350129,350129);
		$collection_id = 15; // охотничья

		foreach ($player_levels as $lvl) {
			$players = self::$sql->getValueSet("select id from player where level=" . $lvl ." and id in (".implode(",", $player_ids).")");
			if (!$players) continue;
			$sql = "SELECT * FROM collection WHERE id = " . $collection_id;

			$collection = Page::sqlGetCacheRecord($sql, 60);
			
			if ($collection) {
				foreach ($players as $i) {
					Page::giveCollectionElement($i, $collection);
				}
			}
		}
		// -------------------------------------------------------------------
		
		
		// --------------------------- вип-тренажерка коллекция -----------------------------
		
		$player_ids = array(3,162621,410178,232829,587741,1085223,745817,208226,402105,306748,306748,622824,690413,892705,699510,680281,179427,343808,882373,1430978,303598,1280488,388269,156880,423920,377913,50206,544964,22519,276264,208314,872331,160034,327114,257489,1056473,1359456,692130,184625,731459,703766,637357,850054,277822,67782,424393,67782,178397,471086,20472,103981);
		$collection_id = 14; // вип-тренажерка

		foreach ($player_levels as $lvl) {
			$players = self::$sql->getValueSet("select id from player where level=" . $lvl ." and id in (".implode(",", $player_ids).")");
			if (!$players) continue;
			$sql = "SELECT * FROM collection WHERE id = " . $collection_id;

			$collection = Page::sqlGetCacheRecord($sql, 60);
			
			if ($collection) {
				foreach ($players as $i) {
					Page::giveCollectionElement($i, $collection);
				}
			}
		}
		// -------------------------------------------------------------------
		
		// --------------------------- милицейская коллекция -----------------------------
		
		$player_ids = array(3,22452,322828,224768,231256,124518,160577,230913,432844,25192,389972,88749,60940,212050,167101,231448,1244341,145619,235568,253605,7584,177169,208422,600222,294383,115631,726441,699510,300456,106215,398439,3,742802,419191,307704,410442);
		$collection_id = 18; // милицейская

		foreach ($player_levels as $lvl) {
			$players = self::$sql->getValueSet("select id from player where level=" . $lvl ." and id in (".implode(",", $player_ids).")");
			if (!$players) continue;
			$sql = "SELECT * FROM collection WHERE id = " . $collection_id;

			$collection = Page::sqlGetCacheRecord($sql, 60);
			
			if ($collection) {
				foreach ($players as $i) {
					Page::giveCollectionElement($i, $collection);
				}
			}
		}
		// -------------------------------------------------------------------
		
		
	

		echo 'end giving
';
	}

	private static function giveBirthdayGiftsTest() {
		// защита от дурака
		$notStartAfter = strtotime('2010-11-16 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$standart_item_code = 'box_november_present_';


		/*
		  $player_ids = array (
		  '3',
		  );
		 */

		$player_levels = array(1, 3, 6, 9, 13);

		foreach ($player_levels as $lvl) {



			$player_ids = self::$sql->getValueSet("select id from player where id=3");

			foreach ($player_ids as $i) {
				// раздача
				Std::loadMetaObjectClass('standard_item');
				$item = new standard_itemObject();

				if ($lvl <= 2) {
					$item->loadByCode($standart_item_code . "1");
				} else if ($lvl <= 5) {
					$item->loadByCode($standart_item_code . "2");
				} else if ($lvl <= 8) {
					$item->loadByCode($standart_item_code . "3");
				} else if ($lvl <= 10) {
					$item->loadByCode($standart_item_code . "4");
				} else if ($lvl <= 15) {
					$item->loadByCode($standart_item_code . "5");
				}

				$item->makeExampleOrAddDurability($i);
			}
			sleep(10);
		}
	}

	private static function giveBirthdayRegaly() {
		// защита от дурака
		$notStartAfter = strtotime('2010-11-14 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$standart_item_code = 'regqaly_kurant';

		$comment = '';
		/*
		  $player_ids = array (
		  '3',
		  );
		 */

		Std::loadMetaObjectClass('player');

		$player_levels = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);

		foreach ($player_levels as $lvl) {

			$months = 12;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2009-11-13 00:00' and registeredtime<'2009-12-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}


			$months = 11;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2009-12-14 00:00' and registeredtime<'2010-01-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}


			$months = 10;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-01-14 00:00' and registeredtime<'2010-02-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}


			$months = 9;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-02-14 00:00' and registeredtime<'2010-03-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}


			$months = 8;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-03-14 00:00' and registeredtime<'2010-04-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}

			$months = 7;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-04-14 00:00' and registeredtime<'2010-05-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}

			$months = 6;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-05-14 00:00' and registeredtime<'2010-06-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}

			$months = 5;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-06-14 00:00' and registeredtime<'2010-07-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}

			$months = 4;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-07-14 00:00' and registeredtime<'2010-08-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}

			$months = 3;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-08-14 00:00' and registeredtime<'2010-09-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}

			$months = 2;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-09-14 00:00' and registeredtime<'2010-10-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}

			$months = 1;
			$player_ids = self::$sql->getValueSet("select id from player where email!='' and level=" . $lvl . " and registeredtime>='2010-10-14 00:00' and registeredtime<'2010-11-14 00:00'");
			if ($player_ids) {
				foreach ($player_ids as $i) {
					Std::loadMetaObjectClass('standard_item');
					$item = new standard_itemObject();
					$item->loadByCode($standart_item_code . "_" . $months);
					$item->giveGift('Администрация', $i, $comment, 0, 0);
				}
			}
		}
	}

	private static function giveBirthdayRegalyTest() {
		// защита от дурака
		$notStartAfter = strtotime('2010-11-14 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$standart_item_code = 'regqaly_kurant';

		$comment = '';
		/*
		  $player_ids = array (
		  '3',
		  );
		 */

		Std::loadMetaObjectClass('player');



		$months = 12;
		// id=3
		$player_ids = self::$sql->getValueSet("select id from player where email!='' and id=3");
		if ($player_ids) {
			foreach ($player_ids as $i) {
				Std::loadMetaObjectClass('standard_item');
				$item = new standard_itemObject();
				$item->loadByCode($standart_item_code . "_" . $months);
				$item->giveGift('Администрация', $i, $comment, 0, 0);
			}
		}
	}

	/**
	 * Фикс с раздачей монет в качестве компенсации
	 */
	private static function giveMoneyAndNotify() {
		// защита от дурака
		$notStartAfter = strtotime('2010-05-12 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$standart_item_code = 'compensate1';

		$addmoneycomment = 'Компенсация взятки в банке';
		/*
		  $playerData = array (
		  '3' => 1234,
		  );
		 */

		$playerData = array(
			'3' => 600,
			'20' => 600
		);


		foreach ($playerData as $id => $value) {
			// раздача
			self::$sql->query("UPDATE player2 SET addmoney=" . $value . ", addmoneycomment='" . $addmoneycomment . "' WHERE player=" . $id);
		}
	}

	/**
	 * Фикс с раздачей монет в качестве компенсации
	 */
	private static function giveHuntclubBandages() {
		// защита от дурака
		$notStartAfter = strtotime('2010-06-04 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// вводимые для фикса переменные
		$item_code = 'huntclub_badge';
		$playerData = array(
			'0' => '23',
			'1' => '1',
			'3' => '3'
		);


		foreach ($playerData as $id => $value) {
			// раздача
			self::give2($id, $item_code, $value);
		}
	}

	/**
	 * Раздача игрокам предметов, отличие от give в том, что здесь параметры передаются в функцию, а не берутся из строки шелла.
	 */
	public static function give2($player, $item_code, $item_quantity) {
		if (!$player || !$item_code)
			return 0;

		$item_quantity = $item_quantity;

		if ($item_code == 'money' || $item_code == 'honey' || $item_code == 'ore') {
			$query = "UPDATE player SET " . $item_code . " = " . $item_code . " + " . $item_quantity;
			if ($player != 'all') {
				$query .= " WHERE id = " . $player;
			}
			return self::sqlQuery($query);
		} else {
			$query = "SELECT id FROM player";
			if (is_numeric($player)) {
				$query .= " WHERE id = " . $player;
			} else if ($player == 'home') {
				$query .= " WHERE is_home_available = 1";
			}
			$players = self::sqlGetValueSet($query);
			if ($players == false) {
				return 0;
			} else {
				Std::loadMetaObjectClass('standard_item');
				$item = new standard_itemObject();
				$result = $item->loadByCode($item_code);

				if ($result == false) {
					return 0;
				} else {
					for ($i = 0; $i < $item_quantity; $i++) {
						foreach ($players as $p) {
							$item->makeExampleOrAddDurability($p);
						}
					}
					return 1;
				}
			}
		}
	}

	/**
	 * Перевод заказов в охотничьем клубе на следующие стадии
	 *
	 * @param int $state
	 */
	private static function updateHuntStates($state) {
		self::$sql->query("UPDATE hunt SET state = " . $state . " WHERE state = " . ($state - 1) . "
            AND dt" . ($state == 1 ? "" : "2") . " < now()");
	}

	/**
	 * Удаление старых заказов и логов
	 */
	private static function deleteOldHunts() {
		self::$sql->query("DELETE FROM hunt WHERE dt < DATE_SUB(now(), INTERVAL 7 DAY)");
		self::$sql->query("DELETE FROM huntlog WHERE dt < DATE_SUB(now(), INTERVAL 7 DAY)");
	}

	/**
	 * Удаление обработанных (удаленных) заявок на проверку аватарок
	 */
	private static function clearDeletedAvatarRequests() {
		//self::$sql->query("DELETE FROM post WHERE topic=1525 AND deleted=1");
	}

	/**
	 * Удаление старых логов, дуэлей и прочих служебных данных
	 */
	private static function deleteOldLogs() {
		$lock = (int) self::$sql->getValue("SELECT value FROM value WHERE name = 'deleteoldlogs_lock'");
		if ($lock == 1) {
			return;
		} else {
			self::$sql->query("UPDATE value SET value = 1 WHERE name = 'deleteoldlogs_lock'");
		}
		$m = (int) date("i", time());
		$h = (int) date("H", time());
		//if ($m > 5 && $m % 2 == 0 && $h > 1 && $h < 9) {
		if ($h > 1 && $h < 9) {
			// ночью
			$limit = 5000;
			$duelLimit = 2000;
			$fightLimit = 1000;
		} elseif ($h > 16 && $h <= 23) {
			// вечер
			$limit = 500;
			$duelLimit = 0;
			$fightLimit = 500;
		} else {
			// днем
			$limit = 500;
			$duelLimit = 300;
			$fightLimit = 300;
		}
		if ($m > 5 && $m % 2 == 0) {
			// логи
			/*$firstLog = self::$sql->getValue("SELECT id FROM log ORDER BY id ASC LIMIT 0,1");
			$targetLog = self::$sql->getValue("SELECT id FROM log WHERE dt < date_sub(now(), INTERVAL 2 WEEK) ORDER BY dt DESC LIMIT 0,1");
			if ($firstLog && $targetLog) {
				$diapazon = $targetLog - $firstLog;
				$diapazon = $diapazon > $limit ? $limit : $diapazon;
				self::$sql->query("DELETE FROM log WHERE id BETWEEN $firstLog AND " . ($firstLog + $diapazon));
			}*/
			// дуэли
			if ($duelLimit > 0) {
				$firstLog = self::$sql->getValue("SELECT id FROM duel ORDER BY id ASC LIMIT 0,1");
				$targetLog = self::$sql->getValue("SELECT id FROM duel WHERE time < " . (time() - 14 * 24 * 60 * 60) . " ORDER BY time DESC LIMIT 0,1");
				if ($firstLog && $targetLog) {
					$diapazon = $targetLog - $firstLog;
					$diapazon = $diapazon > $duelLimit ? $duelLimit : $diapazon;
					self::$sql->query("DELETE FROM duel WHERE id BETWEEN $firstLog AND " . ($firstLog + $diapazon));
					/*$mongo = Page::getMongo();
					if ($mongo) {
						$lastLog = ($firstLog + $diapazon);
						$mongo->getDb()->selectCollection("duel")->remove(array("id" => array('$gte' => intval($firstLog), '$lte' => intval($lastLog))));
					}*/
				}
			}
			// onlinecounter
			$firstLog = self::$sql->getValue("SELECT id FROM onlinecounter ORDER BY id ASC LIMIT 0,1");
			$targetLog = self::$sql->getValue("SELECT id FROM onlinecounter WHERE dt < date_sub(now(), INTERVAL 2 WEEK) ORDER BY dt DESC LIMIT 0,1");
			if ($firstLog && $targetLog) {
				$diapazon = $targetLog - $firstLog;
				$diapazon = $diapazon > $limit ? $limit : $diapazon;
				self::$sql->query("DELETE FROM onlinecounter WHERE id BETWEEN $firstLog AND " . ($firstLog + $diapazon));
			}
			// metrolog
			$firstLog = self::$sql->getValue("SELECT id FROM metrolog ORDER BY id ASC LIMIT 0,1");
			$targetLog = self::$sql->getValue("SELECT id FROM metrolog WHERE dt < date_sub(now(), INTERVAL 2 WEEK) ORDER BY dt DESC LIMIT 0,1");
			if ($firstLog && $targetLog) {
				$diapazon = $targetLog - $firstLog;
				$diapazon = $diapazon > $limit ? $limit : $diapazon;
				self::$sql->query("DELETE FROM metrolog WHERE id BETWEEN $firstLog AND " . ($firstLog + $diapazon));
			}
			// authlog
			$firstLog = self::$sql->getValue("SELECT id FROM authlog ORDER BY id ASC LIMIT 0,1");
			$targetLog = self::$sql->getValue("SELECT id FROM authlog WHERE time < date_sub(now(), INTERVAL 1 MONTH) ORDER BY time DESC LIMIT 0,1");
			if ($firstLog && $targetLog) {
				$diapazon = $targetLog - $firstLog;
				$diapazon = $diapazon > $limit ? $limit : $diapazon;
				self::$sql->query("DELETE FROM authlog WHERE id BETWEEN $firstLog AND " . ($firstLog + $diapazon));
			}
			// message
			$firstLog = self::$sql->getValue("SELECT id FROM message ORDER BY id ASC LIMIT 0,1");
			$targetLog = self::$sql->getValue("SELECT id FROM message WHERE dt < date_sub(now(), INTERVAL 2 WEEK) ORDER BY id DESC LIMIT 0,1");
			if ($firstLog && $targetLog) {
				$diapazon = $targetLog - $firstLog;
				$diapazon = $diapazon > $limit ? $limit : $diapazon;
				self::$sql->query("DELETE FROM message WHERE id BETWEEN $firstLog AND " . ($firstLog + $diapazon));
			}
		}
		if ($h >= 2 && $h <= 9 && $m >= 10 && $m < 55) {
			// групповые бои
			self::$sql->query("delete from fight where dt = '0000-00-00 00:00:00';");
			$firstLog = self::$sql->getValue("SELECT id FROM fight ORDER BY id ASC LIMIT 0,1");
			$targetLog = self::$sql->getValue("SELECT id FROM fight WHERE dt < date_sub(now(), INTERVAL 2 WEEK) ORDER BY dt DESC LIMIT 0,1");
			if ($firstLog && $targetLog) {
				$diapazon = $targetLog - $firstLog;
				$diapazon = $diapazon > $fightLimit ? $fightLimit : $diapazon;
				self::$sql->query("DELETE FROM fight WHERE id BETWEEN $firstLog AND " . ($firstLog + $diapazon));
				self::$sql->query("DELETE FROM fightplayer WHERE fight BETWEEN $firstLog AND " . ($firstLog + $diapazon));
				self::$sql->query("DELETE FROM fightlog WHERE fight BETWEEN $firstLog AND " . ($firstLog + $diapazon));
			}
		}
		self::$sql->query("UPDATE value SET value = 0 WHERE name = 'deleteoldlogs_lock'");
	}

	private static function sendPlayerNotify() {
		// защита от дурака
		$notStartAfter = strtotime('2010-08-01 00:00:00');
		if (time() > $notStartAfter) {
			return;
		}

		// условия
		$minLevel = 4;
		$maxLevel = 15;
		$messageText = 'Уважаемые игроки, еще раз напоминаем Вам о необходимости соблюдения мер осторожности и безопасности.
Администрация не несет ответственности в случае взломов, произошедших из-за неосторожности и несоблюдения правил безопасности.

Будьте бдительны! Чтобы избежать взлома игрового аккаунта, соблюдайте простые правила:
- Не сообщайте Ваш логин и пароль другим пользователям;
- Не вводите логин и пароль от аккаунта в какие-либо программы, на какие-либо сайты;
- В качестве пароля используйте сложную комбинацию из букв и цифр;
- Не используйте одинаковый пароль для различных регистраций;

Администрация никогда не запрашивает пароли, адреса электронной почты и другую конфиденциальную информацию.

Соблюдая элементарные правила безопасности, Вы значительно снижаете риск взлома Вашего игрового аккаунта!';
		// действие
		$query = "SELECT id FROM player WHERE level >=" . $minLevel . " and level<=" . $maxLevel . " and lastactivitytime>'2010-07-15'";
		$players = self::sqlGetValueSet($query);

		foreach ($players as $id) {
			Page::sendNotice($id, $messageText);
		}
	}

	private static function copyLogs2() {
		for ($i = 1; $i < 400000; $i++) {
			echo "
" . $i . ": ";
			self::$sql->query("INSERT INTO log (id, player, time, type, `read`, params, visible, type2, dt)
                SELECT id, player, time, type, `read`, params, visible, type2, dt FROM log2 WHERE player = " . $i);
			echo "ok";
		}
	}

	/**
	 * Создание группового боя за флаг вручную
	 */
	private static function flagGroupFightManualCreate() {
		Std::loadModule('Fight');
		Fight::createFight('flag');
	}

	/**
	 * Сброс счетчиков бонусов у игроков в начале недели
	 */
	private static function sovetResetPlayer2Points() {
		if (date("N", time()) == 1 && (int) date("H", time()) < 1) {
			self::$sql->query("UPDATE player2 SET sovetpoints1prev = sovetpoints1, sovetpoints1 = 0, sovetpoints2 = 0, sovetpoints3 = 0,
                sovetprizetaken = 0");
		}
	}

	/**
	 * Определение победителей голосования за места в совете
	 */
	private static function sovetSelectMembers() {
		if (date("N", time()) == 2 && (int) date("H", time()) < 1) {
			// удалении регалии советников
			self::$sql->query("DELETE FROM gift WHERE type = 'award' AND code = 'award_sovet' AND player IN
                (SELECT player FROM sovet)");
			$players = self::$sql->getValueSet("SELECT player FROM sovet");
			if ($players) {
				foreach ($players as $player) {
					// CHAT выходим из совета
					$key = self::signed($player);
					$userInfo = array();
					$userInfo[$key] = array();
					$userInfo[$key]["sovet"] = "0";
					Page::chatUpdateInfo($userInfo);

					$cachePlayer = self::$cache->get("user_chat_" . $key);
					if ($cachePlayer) {
						$cachePlayer["sovet"] = "0";
						self::$cache->set("user_chat_" . $key, $cachePlayer);
					}
				}
			}
			self::$sql->query("TRUNCATE TABLE sovet");
			self::$sql->query("UPDATE sovet2 SET glava = 0");

			Std::loadMetaObjectClass("standard_item");
			$award = new standard_itemObject();
			$award->loadByCode("award_sovet");

			Std::loadModule("Sovet");

			foreach (array('arrived', 'resident') as $fraction) {
				$members = self::$sql->getRecordSet("SELECT p.id, p.fraction FROM player2 p2 INNER JOIN player p ON p.id = p2.player
                    WHERE p2.sovetvotes > 0 AND p.fraction = '" . $fraction . "' ORDER BY sovetvotes DESC, p.statsum2 DESC LIMIT 0, " . Page::$data["sovet"]["memberscount"]);

				foreach ($members as $member) {
					self::$sql->query("INSERT INTO sovet (player, fraction, status, title)
                        VALUES (" . $member["id"] . ", '" . $member["fraction"] . "', 'accepted', '')");
					Page::sendLog($member["id"], "svtmb1", array());
					$award->giveAward($member["id"]);
					Page::$cache->set('player_sovet_status_' . $member["id"], 'accepted', 3600);

					// CHAT вступаем в совет
					$key = self::signed($member["id"]);
					$userInfo = array();
					$userInfo[$key] = array();
					$userInfo[$key]["sovet"] = "1";
					Page::chatUpdateInfo($userInfo);

					$cachePlayer = self::$cache->get("user_chat_" . $key);
					if ($cachePlayer) {
						$cachePlayer["sovet"] = "1";
						self::$cache->set("user_chat_" . $key, $cachePlayer);
					}

				}

				$money = self::$sql->getValue("SELECT sum(sovetvotes) FROM player p LEFT JOIN player2 p2 ON p.id = p2.player
                    WHERE p.fraction = '" . $fraction . "'");
				self::$sql->query("UPDATE sovet2 SET kazna = kazna + " . round($money / 2) . " WHERE fraction = '" . $fraction . "'");

				Sovet::addLog("svk", array("m" => round($money / 2)), $fraction, 0);
				$award->giveAward($member["id"]);
			}

			self::$sql->query("UPDATE player2 SET sovetvotes = 0");

			file_put_contents("@cache/sovet_leaders_resident.html", "");
			file_put_contents("@cache/sovet_leaders_arrived.html", "");

			CacheManager::set('value_sovet_members_selected', 1);
			Page::setValueFromDB('sovet_members_selected', 1);
		}
	}

	/**
	 * Определение результатов голосования за станцию для атаки
	 */
	private static function sovetSelectStations() {
		if (date("N", time()) == 3 && (int) date("H", time()) < 1) {
			Std::loadModule("Sovet");
			Std::loadMetaObjectClass("sovet3");

			$rStations = self::$sql->getRecordSet("SELECT id, rvotes FROM metro WHERE private = 0
                AND id IN (" . implode(",", Sovet::getCanAttackStations("resident")) . ") ORDER BY rvotes DESC LIMIT 0,2");
			$aStations = self::$sql->getRecordSet("SELECT id, avotes FROM metro WHERE private = 0
                AND id IN (" . implode(",", Sovet::getCanAttackStations("arrived")) . ") ORDER BY avotes DESC LIMIT 0,2");
			$stations = array("arrived" => 0, "resident" => 0);
			if ($rStations[0]["id"] == $aStations[0]["id"]) {
				if ($rStations[0]["rvotes"] > $aStations[0]["avotes"]) {
					$stations["resident"] = $rStations[0]["id"];
					$stations["arrived"] = $aStations[1]["id"];
				} elseif ($rStations[0]["rvotes"] < $aStations[0]["avotes"]) {
					$stations["resident"] = $rStations[1]["id"];
					$stations["arrived"] = $aStations[0]["id"];
				} else {
					if (mt_rand(1, 100) > 50) {
						$stations["resident"] = $rStations[0]["id"];
						$stations["arrived"] = $aStations[1]["id"];
					} else {
						$stations["resident"] = $rStations[1]["id"];
						$stations["arrived"] = $aStations[0]["id"];
					}
				}
			} else {
				$stations["resident"] = $rStations[0]["id"];
				$stations["arrived"] = $aStations[0]["id"];
			}

			$npcTypes = array("rieltor" => NPC_RIELTOR, "raider" => NPC_RAIDER, "grafter" => NPC_GRAFTER);

			foreach (array("arrived", "resident") as $fraction) {
				$sovet3 = new sovet3Object();
				$sovet3->fraction = $fraction;
				$sovet3->week = date("W", time());
				$sovet3->year = date("Y", time());
				$sovet3->metro = $stations[$fraction];
				$sovet3->step1points = $sovet3->step1points_enemy = $sovet3->step2points = $sovet3->step2points_enemy =
						$sovet3->resultpoints = $sovet3->resultpoints_enemy = 0;
				$sovet3->leaders1 = $sovet3->leaders2 = "";

				$money = self::$sql->getValue("SELECT sum(" . $fraction{0} . "votes) FROM metro");
				self::$sql->query("UPDATE sovet2 SET kazna = kazna + " . round($money / 2) . " WHERE fraction = '" . $fraction . "'");

				Sovet::addLog("mvk", array("m" => round($money / 2)), $fraction, 0);

				$enemyFraction = self::$sql->getValue("SELECT fraction FROM metro WHERE id = " . $stations[$fraction]);
				if (in_array($enemyFraction, array("rieltor", "raider", "grafter"))) {
					$sovet3->enemy = "npc";
					$sovet3->enemy_npc = $npcTypes[$enemyFraction];
				} else {
					$sovet3->enemy = $fraction == "arrived" ? "resident" : "arrived";
					$sovet3->enemy_npc = 0;
				}

				$myStations = (int)self::$sql->getValue("SELECT count(*) FROM metro WHERE fraction = '" . $fraction . "'");
				$enemyStations = (int)self::$sql->getValue("SELECT count(*) FROM metro WHERE fraction = '" . $enemyFraction . "'");
				$sovet3->k = ($enemyStations - $myStations) / (int)self::$sql->getValue("SELECT count(*) FROM metro");

				if ($sovet3->enemy == "npc") {
					$sovet3->k = 0;
				}
				
				$sovet3->save();
			}

			self::$sql->query("UPDATE metro SET avotes = 0, rvotes = 0");
		}
	}

	/**
	 * Определение резульатов голосования за председателя совета
	 */
	private static function sovetSelectLeaders() {
		if (date("N", time()) == 3 && (int) date("H", time()) < 1) {
			foreach (array("resident", "arrived") as $fraction) {
				$glava = self::$sql->getValue("SELECT p2.player
                    FROM sovet s LEFT JOIN player p ON p.id = s.player LEFT JOIN player2 p2 ON p2.player = s.player
                    WHERE s.fraction = '" . $fraction . "' ORDER BY p2.sovetvotes DESC, p.statsum2 DESC LIMIT 0, 1");

				self::$sql->query("UPDATE sovet SET status = 'founder' WHERE player = " . $glava);
				self::$sql->query("UPDATE sovet2 SET glava = '" . $glava . "' WHERE fraction = '" . $fraction . "'");
				Page::sendLog($glava, "svtglv1", array());
			}

			self::$sql->query("UPDATE player2 SET sovetvotes = 0");
			CacheManager::set('value_sovet_elections_voted', '');
			Page::setValueFromDB('sovet_elections_voted', '');
		}
	}

	/**
	 * Определение победителей этой недели
	 */
	private static function sovetCalcResults() {
		if (date("N", time()) == 6 && (int) date("H", time()) < 1) {
			$maxLevel = CacheManager::get('value_levelfightmaxlevel');
			$m2 = ($maxLevel - 2) * 15; // максимум возможных побед во втором этапе (= кол-во боев)

			$sovet3 = array(
				"resident" => self::$sql->getRecord("SELECT * FROM sovet3 WHERE fraction = 'resident' AND year = " . (int)date("Y", time()) . " AND week = " . (int)date("W", time())),
				"arrived" => self::$sql->getRecord("SELECT * FROM sovet3 WHERE fraction = 'arrived' AND year = " . (int)date("Y", time()) . " AND week = " . (int)date("W", time())),
			);
			$m1 = ($sovet3["resident"]["points1"] + $sovet3["arrived"]["points1"]) / 2;
			// пересчет максимум баллов во втором этапе относительно перого, относительно того,
			// что первый этап дает 40% победы, а второй - 60%
			$x = Page::$data["sovet"]["step2k"] / Page::$data["sovet"]["step1k"] * $m1;
			$y = $x / $m2; // баллов за победу в групповом во втором этапе
			$y = $y < 1 ? 1 : $y;

			foreach (array("resident", "arrived") as $fraction) {
				$war = $sovet3[$fraction];
				$fraction2 = $fraction == "arrived" ? "resident" : "arrvied";

				if ($war["enemy"] == "npc") {
					$war["points1enemy"] = Page::$data["sovet"]["npcduels"] - $war["points1"];
					$war["points1enemy"] = $war["points1enemy"] < 0 ? 0 : $war["points1enemy"];
				}

				$war["points2"] = round($war["points2"] * $y);
                $war["points2enemy"] = round($war["points2enemy"] * $y);

				//$k = $data["k"] > 0 ? $data["k"] : 1;
                //$total = round($k * ($data["points1"] + $p2));

				// наложение коэффициента
				if ($war["k"] > 0) { // у врага больше станций
					$war["points12"] = round($war["points1"] * $war["k"]);
					$war["points22"] = round($war["points2"] * $war["k"]);

					$war["points2enemy2"] = $data["points1enemy2"] = 0;
				} elseif ($war["k"] < 0) { // у нас больше станций
					$war["points1enemy2"] = round($war["points1enemy"] * abs($war["k"]));
					$war["points2enemy2"] = round($war["points2enemy"] * abs($war["k"]));

					$war["points22"] = $war["points12"] = 0;
				}

				$total = $war["resultpoints"] = $war["points1"] + $war["points12"] + $war["points2"] + $war["points22"];
                $totalEnemy = $war["resultpoints_enemy"] = $war["points1enemy"] + $war["points1enemy2"] + $war["points2enemy"] + $war["points2enemy2"];

				if ($total > $totalEnemy) {
					self::$sql->query("UPDATE metro SET fraction = '" . $fraction . "' WHERE id = " . $war["metro"]);
					self::$sql->query("UPDATE sovet3 SET result = 1, resultpoints = " . $total . ",
                        resultpoints_enemy = " . $totalEnemy . " WHERE id = " . $war["id"]);

					$metroName = self::$sql->getValue("SELECT name FROM metro WHERE id = " . $war["metro"]);
					Std::loadModule("Sovet");
					Sovet::addLog("mz", array("n" => $metroName), $fraction, 0);
				} else {
					self::$sql->query("UPDATE sovet3 SET result = 0, resultpoints = " . $total . ",
                        resultpoints_enemy = " . $totalEnemy . " WHERE id = " . $war["id"]);

					$metroName = self::$sql->getValue("SELECT name FROM metro WHERE id = " . $war["metro"]);
					Std::loadModule("Sovet");
					Sovet::addLog("mz2", array("n" => $metroName), $fraction, 0);
				}
			}

			CacheManager::set('value_sovet_results_calculated', 1);
			Page::setValueFromDB('sovet_results_calculated', 1);

			self::sovetTryEndRound();
		}
	}

	/**
	 * Очистка статистики войны
	 */
	private static function sovetClearWarStats() {
		if (date("N", time()) == 1 && (int) date("H", time()) < 1) {
			CacheManager::set('value_sovet_members_selected', 0);
			Page::setValueFromDB('sovet_members_selected', 0);

			CacheManager::set('value_sovet_results_calculated', 0);
			Page::setValueFromDB('sovet_results_calculated', '');

			CacheManager::set('value_sovet_bonus_patrol', '');
			Page::setValueFromDB('sovet_bonus_patrol', '');

		}
	}

	/**
	 * Попытка завершения раунда
	 */
	private static function sovetTryEndRound() {
		$rDistricts = self::$sql->getValue("SELECT count(*) FROM metro WHERE fraction = 'resident'");
		$aDistricts = self::$sql->getValue("SELECT count(*) FROM metro WHERE fraction = 'arrived'");
		$totalDistricts = (int) self::$sql->getValue("SELECT count(*) FROM metro") - 2;
		if ($rDistricts == $totalDistricts || $aDistricts == $totalDistricts) {
			// !!!
		}
	}

	/**
	 * Топ вкладчиков в казну совета
	 */
	private static function updateSovetSponsorsList() {
		foreach (array('resident', 'arrived') as $fraction) {
			$sponsors = self::$sql->getRecordSet("SELECT p.id, p.fraction, p.level, p.nickname, p.clan_status, c.id clan_id, c.name clan_name,
                p2.sovetmoney FROM player p JOIN player2 p2 ON p2.player=p.id LEFT JOIN clan c ON c.id=p.clan
                WHERE p.fraction = '" . $fraction . "' AND p2.sovetmoney > 0 ORDER BY p2.sovetmoney DESC LIMIT 0,10");
			foreach ($sponsors as &$sponsor) {
				if ($sponsor["clan_status"] == "recruit") {
					unset($sponsor["clan_id"]);
					unset($sponsor["clan_name"]);
				}
			}
			Std::loadLib("Xslt");
			file_put_contents("@cache/sovet_sponsors_" . $fraction . ".html", Xslt::getHtml2('sovet/sponsors-top', array('sponsors' => $sponsors)));
		}
	}

	/**
	 * Лидеры на выборах в совет
	 */
	private static function updateSovetLeadersList() {
		foreach (array('resident', 'arrived') as $fraction) {
			$leaders = self::$sql->getRecordSet("SELECT p.id, p.fraction, p.level, p.nickname, p.clan_status, c.id clan_id,
                c.name clan_name, p2.sovetvotes sovetmoney FROM player p JOIN player2 p2 ON p2.player=p.id LEFT JOIN clan c ON c.id=p.clan
                WHERE p.fraction = '" . $fraction . "' AND p2.sovetvotes > 0 ORDER BY p2.sovetvotes DESC LIMIT 0,20");
			foreach ($leaders as &$leader) {
				if ($leader["clan_status"] == "recruit") {
					unset($leader["clan_id"]);
					unset($leader["clan_name"]);
				}
			}
			Std::loadLib("Xslt");
			file_put_contents('@cache/sovet_leaders_' . $fraction . '.html', Xslt::getHtml2('sovet/sponsors-top', array('sponsors' => $leaders)));
		}
	}

	/**
	 * Удаление перков
	 */
	private static function removePerks() {
		self::$sql->query("DELETE FROM perk WHERE dt2 < now()");
	}

	/**
	 * Удаление голосований, которые не завершились в течение часа
	 */
	private static function removePerkVotes() {
		$perks = self::$sql->getRecordSet("SELECT sbt.id, sbt.fraction, sbt.params, si.money FROM sovetperktemp sbt LEFT JOIN standard_item si ON si.id = sbt.standard_item
            WHERE sbt.dt < DATE_SUB(now(), INTERVAL 1 HOUR)");
		if ($perks) {
			foreach ($perks as $perk) {
				$params = json_decode($perk["params"], true);
				self::$sql->query("DELETE FROM sovetperktemp WHERE id = " . $perk["id"]);
				self::$sql->query("UPDATE sovet2 SET kazna = kazna + " . ($perk["money"] * $params["x"]) . ",
					kazna2 = kazna2 - " . ($perk["money"] * $params["x"]) . " WHERE fraction = '" . $perk["fraction"] . "'");
			}
		}
	}

    /**
     * Подсчет промежуточных результатов противостояния (после дня дуэлей)
     * - выдача бонуса за победу по дуэлям
     */
	private static function sovetCalcTempResults() {
		if (date("N", time()) == 5 && date("H", time()) == 0) {
			$residentPoints = self::$sql->getRecord("SELECT points1, k FROM sovet3 WHERE fraction = 'resident' ORDER BY id DESC LIMIT 0,1");
            $residentPoints = $residentPoints["points1"] + ($residentPoints["k"] > 0 ? $residentPoints["points1"] * $residentPoints["k"] : 0);
			$arrivedPoints = self::$sql->getRecord("SELECT points1, k FROM sovet3 WHERE fraction = 'arrived' ORDER BY id DESC LIMIT 0,1");
            $arrivedPoints = $arrivedPoints["points1"] + ($arrivedPoints["k"] > 0 ? $arrivedPoints["points1"] * $arrivedPoints["k"] : 0);

            $winner = $residentPoints > $arrivedPoints ? 'resident' : 'arrived';

            CacheManager::set('value_sovet_bonus_patrol', $winner);
			Page::setValueFromDB('sovet_bonus_patrol', $winner);
		}
	}

	private static function kickGroupFights() {
		$kick = self::$sql->getValue("SELECT value FROM value WHERE name='kickgroupfights'");
		if ($kick != "") {
			self::$sql->query("UPDATE value SET value='' WHERE name='kickgroupfights'");

			switch ($kick) {
				case "chaotic": self::startGroupFights("chaotic"); break;
				case "flag": self::startGroupFights("flag");break;
				case "clanwar": self::startGroupFights("clanwar");break;
				case "level": self::startGroupFights("level");break;
				case "bank": self::startGroupFights("bank");break;
				case "metro": self::startGroupFights("metro");break;
			}
		}
	}

}

?>