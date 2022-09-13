<?php

class Alley extends Page implements IModule {

	public $moduleCode = 'Alley';
	private $default = true;
	public $checkQuests = false;

	public function __construct() {
		parent::__construct();
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		//
		if (($this->url[0] != 'fight' && $this->url[0] != 'xml') || !is_numeric($this->url[1])) {
			$this->needAuth(false);
			$this->checkQuests();
		}

		$this->content['unixtime'] = time();
		$max = (self::$player->playboy == 1) ? 240 : 120;
		if (CacheManager::get('value_sovet_bonus_patrol') == Page::$player->fraction) {
			$max += 60;
		}
		if (self::$player->patrol_time < mktime(0, 0, 0, date('m'), date('d'), date('Y'))) {
			$this->content['patrol_available'] = $max;
		} else {
			$this->content['patrol_available'] = max(0, $max - (self::$player->patrol_time - mktime(0, 0, 0, date('m'), date('d'), date('Y'))) / 60);
		}
		for ($i = 10; $i <= $this->content['patrol_available']; $i += 10) {
			$this->content['patrol_times'][$i]['time'] = $i;
		}
		//Runtime::clear('search_type');
		if ($this->url[0] == 'search') {
			if (self::$player2->travma) {
				Page::addAlert(AlleyLang::$error, AlleyLang::$errorCanNotFightWithInjury, ALERT_ERROR);
				Std::redirect('/alley/');
			}
			if (isset($_POST['werewolf']) && $_POST['werewolf'] == 0) {
				Runtime::clear('werewolf_search');
			}
			$this->content['search_type'] = $this->url[1];
			if (!self::$player->isFree()) {
				$this->content['search_error'] = 'not_free';
			} elseif (self::$player->lastfight > time()) {
				$this->content['search_error'] = 'too_fast';
			} elseif (self::$player->level > 1 && self::$player->money < 1) {
				$this->content['search_error'] = 'no_money';
			} elseif (self::$player->hp < round(self::$player->maxhp * 0.35) && $_POST['werewolf'] != 1) {
				$this->content['search_error'] = 'low_hp';
			} elseif (($this->url[1] == 'type' || ($this->url[1] == 'again' && Runtime::get('search_type') == 'type')) && in_array((isset($_POST['type'])) ? $_POST['type'] : Runtime::get('type'), array('equal', 'strong', 'weak', 'victim', 'enemy'))) {
				$this->searchByType((isset($_POST['type'])) ? $_POST['type'] : Runtime::get('type'), ($_POST['werewolf'] == 1 || Runtime::get('werewolf_search') ? 1 : 0));
			} elseif (($this->url[1] == 'level' || ($this->url[1] == 'again' && Runtime::get('search_type') == 'level')) && self::$player->playboy == 1 && is_numeric((isset($_POST['minlevel'])) ? $_POST['minlevel'] : Runtime::get('minlevel')) && is_numeric((isset($_POST['maxlevel'])) ? $_POST['maxlevel'] : Runtime::get('maxlevel'))) {
				$this->searchByLevel(min((isset($_POST['minlevel'])) ? $_POST['minlevel'] : Runtime::get('minlevel'), (isset($_POST['maxlevel'])) ? $_POST['maxlevel'] : Runtime::get('maxlevel')), max((isset($_POST['minlevel'])) ? $_POST['minlevel'] : Runtime::get('minlevel'), (isset($_POST['maxlevel'])) ? $_POST['maxlevel'] : Runtime::get('maxlevel')), ($_POST['werewolf'] == 1 || Runtime::get('werewolf_search') ? 1 : 0));
			} elseif ($this->url[1] == 'nick') {
				$this->searchByNick($_POST['nick'], ($_POST['werewolf'] == 1 || Runtime::get('werewolf_search') ? 1 : 0));
			} elseif ($this->url[1] == 'npc' || ($this->url[1] == 'again' && Runtime::get('search_type') == 'npc')) {
				$this->searchMetroNpc();
			}
		} elseif (@$_POST['action'] == 'patrol' && isset($this->content['patrol_times'][$_POST['time']])) {
			$result = Alley::patrol($_POST['time']);
			//print_r($result);exit;
			Runtime::set('content/result', $result);
			Std::redirect($result['url']);
		} elseif ($this->url[0] == 'naperstki') {
			$this->playNaperstki();
		} elseif ($this->url[0] == 'fight' && is_numeric($this->url[1])) {
			if ($this->url[3] == 'text') {
				self::$sql->query("UPDATE player2 SET duelanim = 0 WHERE id = " . self::$player2->id);
				self::$player2->duelanim = 0;
			} elseif ($this->url[3] == 'animation') {
				self::$sql->query("UPDATE player2 SET duelanim = 1 WHERE id = " . self::$player2->id);
				self::$player2->duelanim = 1;
			}
			if (self::$player2->duelanim == 1) {
				$this->showFlashFight($this->url[1]);
			} else {
				$this->showFight($this->url[1]);
			}
		} elseif ($this->url[0] == 'attack' && is_numeric($this->url[1])) {
			$this->attack($this->url[1], (($this->url[2] == 'useitems') ? true : false));
		} elseif ($_POST['action'] == 'attack' && is_numeric($_POST['player'])) {
			$this->attack((int) $_POST['player'], (($_POST['useitems'] == 1) ? true : false), (($_POST['werewolf'] == 1) ? true : false));
		} elseif ($this->url[0] == 'attack-npc' && is_numeric($this->url[1])) {
			$this->attackNpc($this->url[1]);
		} elseif ($this->url[0] == 'attack-npc2') {
			$this->attackNpc2();
		} elseif (isset($_POST["action"]) && $_POST["action"] == "attack-npc3") {
            $this->attackNpc3();
        } elseif (@$_POST['action'] == 'leave' && self::$player->state == 'patrol') {
			$result = Alley::leavePatrol();
			//print_r($result);exit;
			Runtime::set('content/result', $result);
			Std::redirect($result['url']);
		} elseif ($this->url[0] == 'xml' && is_numeric($this->url[1])) {
			$this->showFightXml($this->url[1]);
			exit;
		} elseif ($this->url[0] == "sovet-take-day-prize") {
            $this->sovetTakeDayPrize();
        }

		if ($this->default == true) {
			$this->content['minlevel'] = $this->content['minlevel'] ? $this->content['minlevel'] : self::$player->level;
			$this->content['maxlevel'] = $this->content['maxlevel'] ? $this->content['maxlevel'] : self::$player->level;

			$this->showAlley();
		}
		//
		parent::onAfterProcessRequest();
	}

	/*public function showFightXml($duel) {
		if (Page::generateKeyForDuel($this->url[1]) != $this->url[2]) {
			$this->dieOnError(404);
		}
		if (!is_a($duel, 'duelObject')) {
			Std::loadMetaObjectClass('duel');
			$duelq = new duelObject;
			if (!$duelq->load($duel)) {
				echo '<fight error="NO_LOG" />';
				exit;
			}
			$duel = $duelq;
		}

		$acting = array();

		$this->content['acting'] = $duel->acting;
		foreach ($this->content['acting'] as &$act) {
			$acting[] = array("kt" => $act["kt"], "sx" => $act["sx"]);
		}

		$this->content['naezdkostil'] = $duel->log[0][0][0][2][0] == 11 ? 1 : 0;
		$this->content['attack-string'] = explode('%', AlleyLang::$attackStrings[rand(0, count(AlleyLang::$attackStrings) - 1)]);
		$this->content['log'] = array_reverse($duel->log);
		$this->content['time'] = date("H:i:s", $duel->time);
		$this->content['date'] = date("d.m.Y", $duel->time);
		$this->content['id'] = $duel->id;
		$this->content['sk'] = Page::generateKeyForDuel($duel->id);
		$this->content['winner'] = $duel->winner;
		$this->content['profit'] = $duel->profit;
		$this->content['exp'] = $duel->exp;
		$this->content['params'] = json_decode($duel->params, true);
		if (self::$player->id > 0) {
			$this->content['player'] = self::$player->toArray();
		}

		if ($this->content['params']['werewolf'] == 1) {
			$this->content['acting'][0]['id'] = 0;
			$this->content['acting'][0]['avatar'] = 'npc_werewolf';
		}
		
		if (!isset($this->content['params']['attacks'])) {
			$attacks = array(1 => array(), 2 => array());
			for ($i = 1; $i <= 2; $i ++) {
				while (count($attacks[$i]) < 3) {
					$w = rand(0, count(Page::$data['duels']['weapons']) - 1);
					if (!isset($attacks[$i][$w])) {
						$attacks[$i][$w] = rand(1, Page::$data['duels']['weapons'][$w]['weapons']);
					}
				}
			}
			$this->content['params']['attacks'] = $attacks;
		}
		
		if (!isset($this->content['params']['bg'])) {
			//$this->content['params']['attacks'] = rand();
		}

		if (DEV_SERVER && $duel->acting[1]['av'] == 'npc1.png') {
			$background = 6;
		} else {
			$background = rand(1, 5);
		}
		$result = '<fight id="' . $duel->id . '" background="' . $background . '" winner="' . $duel->winner . '">' . PHP_EOL;

		$result .= '  <players>' . PHP_EOL;
		foreach ($duel->acting as $key => $a) {
			if (isset($a['id'])) {
				$result .= '    <player id="' . $a['id'] . '" type="player" hp="' . $a['hp'] . '" maxhp="' . $a['mhp'] . '" avatar="' . str_replace('.png', '', $a['av']) . '" nickname="' . $a['nm'] . '" level="' . $a['lv'] . '" position="' . $a['position'] . '" image="' . $a['im'] . '" animation="' . implode(',', array_keys($this->content['params']['attacks'][$a['position']+1])) . '" weapons="' . implode(',', $this->content['params']['attacks'][$a['position']+1]) . '" />' . PHP_EOL;
			} else {
				$result .= '    <player player="' . $duel->acting[$a['position']-2]['id'] . '" type="pet" hp="' . $a['hp'] . '" maxhp="' . $a['mhp'] . '" avatar="' . str_replace('.png', '', $a['im']) . '" nickname="' . str_replace('"', '', $a['nm']) . '" position="' . $a['position'] . '" />' . PHP_EOL;
			}
		}
		$result .= '  </players>' . PHP_EOL;

		foreach ($duel->log as $key => &$step) {
			if (is_array($step) && is_array($step[0])) {
				foreach ($step[0] as &$strike) {
					$varName = 'fightStrings';
					if ($duel->acting[$strike[0]]['type'] == 'pet') {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsAnimalMiss;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsAnimalStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsAnimalCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsAnimalInjury;
						}
					} else {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsMiss;
							$strike[2][1] = 0;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsInjury;
						} elseif ($strike[2][0] == 11) {
							$varName = AlleyLang::$fightStringsNaezd;
						} elseif ($strike[2][0] == 12) {
							$varName = AlleyLang::$fightStringsNaezd40;
						} elseif ($strike[2][0] == 21 || $strike[2][0] == 22) {
							$varName = AlleyLang::$fightStringsCombo[$strike[2][3]][$acting[$strike[0]]["sx"]];
						}
					}
					if ($strike[2][2] == -1 || !is_array($varName) || !isset($varName[$strike[2][2]])) {
						$strike[2][2] = (is_array($varName) ? $varName[rand(0, count($varName) - 1)] : $varName);
					}
				}
			} elseif ($step[0] == 'duellogtext') {
				$result .= '  <duellogtext>' . $step[1] . '</duellogtext>';
				$this->content['duellogtext'] = $step[1];
				unset($duel->log[$key]);
			}
		}

		$result .= '  <turns>' . PHP_EOL;
		foreach ($duel->log as $key => &$step) {
			$result .= '    <turn>' . PHP_EOL;
			foreach ($step[0] as $s) {
				$result .= '      <action a="' . $s[0] . '" d="' . $s[1] . '" t="' . $s[2][0] . '" dp="' . $s[2][1] . '" />' . PHP_EOL;
			}
			$result .= '    </turn>' . PHP_EOL;
		}

		$result .= '  </turns>' . PHP_EOL;

		$result .= '</fight>' . PHP_EOL;
		echo $result;
	}*/

	public static function leavePatrol() {
		$result = array('type' => 'alley', 'action' => 'leave patrol');
		$result['url'] = '/alley/';
		if (self::$player->state == 'patrol') {
			self::$sql->query("DELETE FROM playerwork WHERE player = " . self::$player->id . " AND type='patrol'");
			self::$player->state = '';
			self::$player->timer = 1;
			self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$TIMER));

			if (self::$player2->naperstki != 1) {
				self::$player2->naperstki = -1;
				self::$player2->naperstkidata = '';
				self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKI, player2Object::$NAPERSTKIDATA));
			}

			$result['result'] = 1;
			return $result;
		} else {
			$result['result'] = 0;
			$result['error'] = 'you are not in patrol';
			return $result;
		}
	}

	protected function searchByType($type, $werewolf) {
		Runtime::set('search_type', 'type');
		Runtime::set('type', $type);
		$this->content['search_type'] = 'type';
		$this->content['type'] = $type;

		// временно убрали tags: %alley %money %player %save %search
		//if (self::$player->level > 1) {
		//	self::$player->money--;
		//	self::$player->save(self::$player->id, array(playerObject::$MONEY));
		//}


		//wtf?
		//if (rand(1, 100) < 50 && false) {
		//	$this->content['search_error'] = 'no_players';
		//	return;
		//}
		$results = $this->search($type, 0, 0, '', $werewolf);
		if ($results === false) {
			$this->content['search_error'] = 'no_players';
			$this->content['result'] = array();
			$this->content['result']['result'] = 0;
			$this->content['action'] = 'search';
			$this->content['result']['error'] = 'no targets found';
		} else {
			$this->showAttackPage($results, $werewolf);
		}
	}

	protected function searchByLevel($minlevel, $maxlevel, $werewolf) {
		Runtime::set('search_type', 'level');
		Runtime::set('minlevel', $minlevel);
		Runtime::set('maxlevel', $maxlevel);
		$this->content['search_type'] = 'level';
		$this->content['minlevel'] = $minlevel;
		$this->content['maxlevel'] = $maxlevel;
		// временно убрали tags: %alley %money %player %save %search
		//self::$player->money--;
		//self::$player->save(self::$player->id, array(playerObject::$MONEY));
		$results = $this->search('', $minlevel, $maxlevel, '', $werewolf);
		if ($results === false) {
			$this->content['search_error'] = 'no_players';
		} else {
			$this->showAttackPage($results, $werewolf);
		}
	}

    protected function searchMetroNpc()
    {
        if (date("N", time()) != 4 || self::$sql->getValue("SELECT enemy FROM sovet WHERE fraction='" . self::$player->fraction . "' ORDER BY id DESC LIMIT 0,1")) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/alley/');
        }

        if (self::$player->level < 3) {
            $this->content['search_error'] = 'no_players';
        } else {

            Std::loadModule("Npc");

            Runtime::set('search_type', 'npc');
            $this->content['search_type'] = 'npc';

			// временно убрали tags: %alley %money %player %save %search
            //self::$player->money--;
            //self::$player->save(self::$player->id, array(playerObject::$MONEY));

            $npcType = Page::getData("alley_" . self::$player->fraction . "_enemy_npc",
                "SELECT enemy_npc FROM sovet3 WHERE fraction = '" . self::$player->fraction . "' ORDER BY id DESC LIMIT 0,1",
                "value", 3600);
			Page::$player->npc_wins = Page::$player2->npc_stat % 1000;
			Page::$player->npc_loses = floor(Page::$player2->npc_stat / 1000);
            $npc = NpcGenerator::get($npcType, self::$player);
            if (!$npc) {
                $this->content['search_error'] = 'no_players';
            } else {
                Runtime::set("generated_npc", $npc->exportForFight());
                $this->showAttackPage($npc);
            }
        }
    }

	protected function searchByNick($nick, $werewolf) {
		Runtime::set('search_type', 'nick');
		Runtime::set('nick', $nick);
		$this->content['search_type'] = 'nick';
		// временно убрали tags: %alley %money %player %save %search
		//$this->content['nick'] = $nick;
		//self::$player->money--;
		self::$player->save(self::$player->id, array(playerObject::$MONEY));
		$results = $this->search('', 0, 0, $nick, $werewolf);
		if ($results === false) {
			$this->content['search_error'] = 'no_players';
		} else {
			$this->showAttackPage($results, $werewolf);
		}
	}

	/**
	 * Поиск противника
	 *
	 * @param string $type
	 * @param int $minlevel
	 * @param int $maxlevel
	 * @param string $nick
	 * @return mixed
	 */
	protected function search($type, $minlevel = 0, $maxlevel = 0, $nick = '', $werewolf = 0) {
		if ($werewolf == 1 && Page::$player2->werewolf != 1) {
			Std::redirect('/alley/');
		}
		Runtime::set('werewolf_search', $werewolf);
		$t1 = microtime(true);
		Std::loadMetaObjectClass("player");
		Std::loadLib("sphinxapi");

		$sphinx = new SphinxClient();
		if (DEV_SERVER) {
			$sphinx->SetServer("localhost", 3312);
		} else {
			$sphinx->SetServer("10.1.4.2", 3312);
		}
		$sphinx->SetSortMode(SPH_SORT_EXTENDED, "@random");
		$sphinx->SetFilter("accesslevel", array(0));
		$sphinx->SetFilterRange("id", 21, 99999999);
		$players = self::$sql->getValueSet("SELECT DISTINCT player2 FROM duel WHERE time >= " . (time() - 60) . "");
		$sphinx->SetFilter("nickname", array(0), true);
		if (is_array($players) && !empty($players)) {
			$sphinx->SetFilter("id", $players, true);
		}
		if ($werewolf == 0) {
			$sphinx->SetFilter("fraction", array((self::$player->fraction == "arrived" ? 0 : 1)));
		}
		$sphinx->SetFilter("state", array(1));
		$sphinx->SetFilter("ip", array(self::$player->ip), true);
		if (self::$player->level > 1) {
			$sphinx->SetFilter("level", array(1), true);
		}
		$sphinx->SetFilter("hp", array(1));
		
		if ($type == "victim" || $type == "enemy") {
			$players = self::$sql->getValueSet("SELECT player2 FROM contact WHERE player=" . self::$player->id . " AND type='" . $type . "'");
			if ($players) {
				$sphinx->SetFilter("id", $players);
			}
		}
		if ($minlevel > 0 && $maxlevel > 0) {
			$sphinx->SetFilterRange("level", max(1, $minlevel), min(99, $maxlevel));
		}
		if (!empty($nick)) {
			$sphinx->SetFilter("nickname", array(crc32($nick)));
		}
		$sphinx->SetLimits(0, 100, 0, 0);
		if ($werewolf == 1) {
			$tmp = json_decode(Page::$player2->werewolf_data, true);
			$statsum = $tmp['stats']['health'] + $tmp['stats']['strength'] + $tmp['stats']['dexterity'] + $tmp['stats']['attention'] + $tmp['stats']['intuition'] + $tmp['stats']['resistance'] + $tmp['stats']['charism'];
		} else {
			$statsum = self::$player->statsum;
		}
		if ($type == "equal") {
			$sphinx->SetFilterRange("statsum", intval(round($statsum * 0.95)), intval(round($statsum * 1.05)));
			$result = $sphinx->Query("", "duels");
			if ($result["total"] == 0) {
				//array_pop($sphinx->_filters);
				$sphinx->SetFilterRange("statsum", intval(round($statsum * 0.90)), intval(round($statsum * 1.1)));
				$result = $sphinx->Query("", "duels");
			}
			if ($result["total"] == 0) {
				//array_pop($sphinx->_filters);
				$sphinx->SetFilterRange("statsum", intval(round($statsum * 0.85)), intval(round($statsum * 1.15)));
				$result = $sphinx->Query("", "duels");
			}
		} elseif ($type == "strong") {
			$sphinx->SetFilterRange("statsum", intval(round($statsum * 1.1)), intval(round($statsum * 1.3)));
			$result = $sphinx->Query("", "duels");
			if ($result["total"] == 0) {
				//array_pop($sphinx->_filters);
				$sphinx->SetFilterRange("statsum", intval(round($statsum * 1.3)), intval(round($statsum * 100)));
				$result = $sphinx->Query("", "duels");
			}
		} elseif ($type == "weak") {
			$sphinx->SetFilterRange("statsum", intval(round($statsum * 0.7)), intval(round($statsum * 0.9)));
			$result = $sphinx->Query("", "duels");
			if ($result["total"] == 0) {
				//array_pop($sphinx->_filters);
				$sphinx->SetFilterRange("statsum", intval(round($statsum * 0.3)), intval(round($statsum * 0.7)));
				$result = $sphinx->Query("", "duels");
			}
		} else {
			$result = $sphinx->Query("", "duels");
		}
		if ($result["total"] == 0) return false;
		$matches = array_keys($result["matches"]);

		Std::loadMetaObjectClass("diplomacy");
		Std::loadMetaObjectClass("player");
		foreach ($matches as $player) {
			$warId = false;
			if (!empty($result["matches"][$player]["clan"])) {
				$warId = diplomacyObject::areAtWar($result["matches"][$player]["clan"], self::$player->clan);
			}
			if ($warId || self::$sql->getValue("SELECT count(*) FROM duel WHERE player1=" . self::$player->id . " AND player2=" . $player . " AND time>=" . (time() - 60 * 60 * 24 - 21)) < 5) {
				$p = new playerObject();
				$p->load($player);
				if ($p->accesslevel != 0 || $p->lasttimeattacked > (time() - 3600)) {
					continue;
				}
				$p->loadHP();
				if ($p->hp >= $p->maxhp * 0.35) {
					return $p;
				}
			}
		}

		/*
		foreach ($playerCollection as $i => $player) {
			if (self::$player->ip != $player['ip']) {
				if (self::$sql->getValue("SELECT count(*) FROM duel WHERE player2=" . $player['id'] . " AND time >= " . (time() - 60 * 60 - 21)) == 0) {
					// проверка на количество нападений за последние 24 часа или на состояние войны
					Std::loadMetaObjectClass('diplomacy');
					$warId = diplomacyObject::areAtWar($player['clan'], self::$player->clan);
					if ($warId || self::$sql->getValue("SELECT count(*) FROM duel WHERE player1=" . self::$player->id . " AND player2=" . $player['id'] . " AND time>=" . (time() - 60 * 60 * 24 - 21)) < 5) {
						Std::loadMetaObjectClass('player');
						$p = new playerObject();
						$p->load($player['id']);
						$p->loadHP();
						return $p;
					}
				}
			}
		}
*/
		return false;

		/*
		  // проверка на нападения за последний час

		  Std::loadMetaObjectClass('duel');
		  $criteria = new ObjectCollectionCriteria();
		  $criteria->createWhere(duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $player->id);
		  $criteria->createWhere(duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, time() - 60 * 60);

		  $collection = new ObjectCollection();
		  $duelCollection = $collection->getArrayList(duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
		  if ($duelCollection !== false) {
		  $fights = current($duelCollection);
		  if ($fights['amount'] > 0) {
		  return false;
		  }
		  }

		  // проверка на количество нападений за последние 24 часа или на состояние войны
		  Std::loadMetaObjectClass('diplomacy');
		  $warId = diplomacyObject::areAtWar($player->clan, self::$player->clan);
		  if (!$warId) {
		  $criteria = new ObjectCollectionCriteria ();
		  $criteria->createWhere(duelObject::$PLAYER1, ObjectCollectionCriteria::$COMPARE_EQUAL, self::$player->id);
		  $criteria->createWhere(duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $player->id);
		  $criteria->createWhere(duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, time() - 3600 * 24);
		  $collection = new ObjectCollection();
		  $duelCollection = $collection->getArrayList(duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
		  if ($duelCollection !== false) {
		  $fights = current($duelCollection);
		  if ($fights['amount'] >= 5) {
		  return false;
		  }
		  }
		  }

		  $player->loadHP();
		  //$player->loadInventory();

		  ////// случайный сброс списка не-поиска
		  ////if (mt_rand(1, 100) < 10) {
		  ////    Runtime::set('alley_skip', '');
		  ////}
		  //Runtime::set('alley_skip', Runtime::get('alley_skip') == '' ? $player->id : Runtime::get('alley_skip').','.$player->id);

		  return $player;
		 */
	}

	/**
	 * Атаковать игрока
	 *
	 * @param int $id
	 * @param bool $useitems
	 * @return void
	 */
	protected function attack($id, $useitems = false, $werewolf = false) {
		$id = intval($id);
		//Std::redirect('/alley/');
		if ($werewolf && Page::$player2->werewolf == 0) {
			//Page::addAlert(AlleyLang::$error, AlleyLang::YOU_ARE_NOT_WEREWOLF, ALERT_ERROR);
			Std::redirect('/player/' . $id . '/');
		}
		Page::startTransaction('alley_attack_' . $id, false, 10);
		$player = new playerObject;
		// Мне повезёт
		if (empty($id) && strtotime(Page::$player->huntdt) > time()) {
			if (!$werewolf) {
				$level = Page::$player->level;
				$fraction = self::$player->fraction == "resident" ? "'arrived'" : "'resident'";
			} else {
				$werewolf_data = json_decode(Page::$player2->werewolf_data, true);
				$level = $werewolf_data["level"];
				$fraction = "'arrived', 'resident'";
			}
			$wanted = self::$sql->getRecordSet("SELECT p.id
												FROM hunt h
												LEFT JOIN player p ON h.player = p.id
												WHERE h.fraction IN (" . $fraction . ")
												AND h.level IN (" . ($level - 1) . ", " . $level . ", " . ($level + 1) . ", " . ($level + 2) . ")
												AND h.state = 1 AND h.player2 != " . self::$player->id . "
												AND h.award > 0
												AND p.lasttimeattacked < UNIX_TIMESTAMP() - 3600
												AND p.accesslevel = 0
												AND p.state = ''
												AND (p.maxhp = 0 OR round(p.maxhp - ((p.healtime - unix_timestamp()) / (60 / if(p.level = 1, 6, 1))) * (p.maxhp / 30)) >= p.maxhp * 0.35)
												ORDER BY h.xmoney DESC, h.award DESC LIMIT 0,10");
			if (!$wanted) {
				Page::addAlert(HuntclubLang::ERROR, HuntclubLang::ERROR_NO_VICTIM_MESSAGE, ALERT_ERROR);
				Std::redirect('/huntclub/wanted/');
			}
			shuffle($wanted);
			$id = $wanted[0]["id"];
		}
		if ($player->load($id) === false) {
			return;
		}
		if ($player->accesslevel < 0 || $player->id == Page::$player->id) {
			Std::redirect('/player/' . $id . '/');
		}
		if (self::$player->level <= 3) {
			$maxAttackLevel = self::$player->level + 1;
		} else {
			$maxAttackLevel = self::$player->level + 3;
		}
		if ($werewolf == 0 && $player->level > $maxAttackLevel) {
			Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			Runtime::set('content', array('message' => 'cant_attack_highlevel', 'action' => 'attack', 'maxattacklevel' => $maxAttackLevel));
			Std::redirect('/player/' . $player->id . '/');
		} elseif (self::$player2->travma) {
			Page::addAlert(AlleyLang::$error, AlleyLang::$errorCanNotFightWithInjury, ALERT_ERROR);
			Std::redirect('/player/' . $player->id . '/');
		}
		Runtime::set('captcha', 0);
		//if (Runtime::get('attacks') == 10) {
		//	Runtime::set('captcha', 1);
		//	Runtime::set('captcha_return_url', '/alley/attack/' . $player->id . '/');
		//	Std::redirect('/player/' . $player->id . '/');
		//}
		$passWarConditions = false;
		if ($useitems) {
			Std::loadMetaObjectClass('diplomacy');
			$warId = diplomacyObject::areAtWar($player->clan, self::$player->clan);
			if ($warId) {
				//$perms['metro'] = false;
				$perms['police'] = false;
				$perms['time'] = false;
				$items = array();
				/*
				  if ($player->state == 'metro') {
				  $perms['metro'] = true;
				  $items[] = "clan_krot";
				  } else
				 */
				if ($player->state == 'police') {
					$perms['police'] = true;
					$items[] = "clan_ksiva";
				}
				$lastFightTimeDuringLastHour = Page::$sql->getValue("SELECT time FROM duel WHERE player2 = " . $player->id . " AND time > " . (time() - 60 * 60) . " ORDER BY time DESC LIMIT 0,1");
				if ($lastFightTimeDuringLastHour) {
					$perms['time'] = true;
					$items[] = (time() - $lastFightTimeDuringLastHour) > 300 && (time() - self::$player2->timemachinetime > 1800) ? "clan_timemashine" : "clan_timemashine_ollolo";
				}
				if (count($items)) {
					$it = Page::$sql->getValueSet("SELECT id FROM inventory where player = " . self::$player->id . " and code in ('" . implode("', '", $items) . "') group by code");
					if ($it && count($it) == count($items)) {
						$passWarConditions = true;
					}
				}
			}
		}
		if (!$werewolf && self::$player->loadHP() < self::$player->maxhp * 0.35) {
//Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			Runtime::set('content', array('message' => 'cant_attack_lowhp', 'action' => 'attack'));
			Std::redirect('/player/' . $player->id . '/');
		} elseif (!self::$player->isFree()) {
//Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			Runtime::set('content', array('message' => 'cant_attack_you_busy', 'action' => 'attack'));
			Std::redirect('/player/' . $player->id . '/');
		} elseif (self::$player->lastfight > time()) {
			Runtime::set('content', array('message' => 'cant_attack_too_fast', 'action' => 'attack'));
			Std::redirect('/player/' . $player->id . '/');
		} elseif ($player->fraction == self::$player->fraction && !$werewolf) {
//Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			Runtime::set('content', array('message' => 'cant_attack_ally', 'action' => 'attack'));
			Std::redirect('/player/' . $player->id . '/');
			//} else if ($player->lastfight > time()) {
			//	Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			//	Runtime::set('content', array('message' => 'cant_attack_recently_fight', 'action' => 'attack'));
			//	Std::redirect('/player/' . $player->id . '/');
		} elseif ($player->loadHP() < $player->maxhp * 0.35) {
//Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			Runtime::set('content', array('message' => 'cant_attack_enemy_lowhp', 'action' => 'attack'));
			Std::redirect('/player/' . $player->id . '/');
		} elseif (($player->id <= 20 || $player->id == 17595) && self::$player->id > 20 && !DEV_SERVER) {
			Runtime::set('content', array('message' => 'cant_attack_admin', 'action' => 'attack'));
			Std::redirect('/player/' . $player->id . '/');
		} elseif ($player->accesslevel > 10 && self::$player->accesslevel != 100) {
			//Runtime::set('content', array('message' => 'cant_attack_admin', 'action' => 'attack'));
			Page::addAlert(AlleyLang::$error, AlleyLang::$errorPlayerCanNotBeAttacked, ALERT_ERROR);
			Std::redirect('/player/' . $player->id . '/');
		} elseif ($player->ip == self::$player->ip && !DEV_SERVER) {
			Runtime::set('content', array('message' => 'cant_attack_ip', 'action' => 'attack'));
			Std::redirect('/player/' . $player->id . '/');
		}

		if (($player->state == 'police') && $passWarConditions == true) {

		} else if (!$player->isFreeForFight()) {
			Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			if ($player->state == 'fight' || $player->state == 'frozen') {
				Runtime::set('content', array('message' => 'cant_attack_fight', 'action' => 'attack'));
			} else {
				Runtime::set('content', array('message' => 'cant_attack_busy', 'action' => 'attack'));
			}
			Std::redirect('/player/' . $player->id . '/');
		}

		Std::loadMetaObjectClass('duel');

		if (Page::$player->id != 1 && !DEV_SERVER && $passWarConditions == false) {
			$criteria = new ObjectCollectionCriteria ();
			$criteria->createWhere(duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $player->id);
			$criteria->createWhere(duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, (time() - 60 * 60 - mt_rand(1, 20)));
			$collection = new ObjectCollection ();
			$duelCollection = $collection->getArrayList(duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
			if ($duelCollection !== false) {
				$fights = current($duelCollection);
				if ($fights['amount'] > 0) {
					Runtime::set('content', array('message' => 'cant_attack_attacked_recently', 'action' => 'attack'));
					Std::redirect('/player/' . $player->id . '/');
				}
			}
			Std::loadMetaObjectClass('diplomacy');
			$warId = diplomacyObject::areAtWar($player->clan, self::$player->clan);
			if (!$warId) {
				$criteria = new ObjectCollectionCriteria ();
				$criteria->createWhere(duelObject::$PLAYER1, ObjectCollectionCriteria::$COMPARE_EQUAL, self::$player->id);
				$criteria->createWhere(duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $player->id);
				$criteria->createWhere(duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, time() - 3600 * 24);
				$collection = new ObjectCollection ();
				$duelCollection = $collection->getArrayList(duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
				if ($duelCollection !== false) {
					$fights = current($duelCollection);
					if ($fights['amount'] >= 5) {
						Runtime::set('content', array('message' => 'cant_attack_too_much_attacks', 'action' => 'attack'));
						Std::redirect('/player/' . $player->id . '/');
					}
				}
			}
		}

		if ($passWarConditions == true && count($items)) {
			foreach ($items as $i) {
				if ($i == "clan_timemashine") {
					self::$player2->timemachinetime = time();
					self::$player2->save(self::$player2->id, array(player2Object::$TIMEMACHINETIME));
				}
				$s = Page::$sql->getRecord("SELECT id, durability, name FROM inventory WHERE player = " . self::$player->id . " AND code = '" . $i . "' LIMIT 0,1");
				if ($s['durability'] == 1) {
					Page::$sql->query("DELETE from inventory where id = " . $s['id']);
				} else {
					Page::$sql->query("UPDATE inventory SET durability = durability - 1, maxdurability = maxdurability - 1 WHERE id = " . $s['id']);
				}
				Page::sendLog(self::$player->id, 'item_used', array('code' => $i, 'name' => $s['name'], 'you' => 'attacker', 'player' => $player->exportForDB()), 1);
				Page::sendLog($player->id, 'item_used', array('code' => $i, 'name' => $s['name'], 'you' => 'defender', 'player' => self::$player->exportForDB()), 0);
			}
		}

		//Page::$sql->query("START TRANSACTION");
		//$player->state = Page::$sql->getValue("SELECT state FROM player WHERE id = " . $player->id . " FOR UPDATE");

		if (($player->state == 'police') && $passWarConditions == true) {

		} else if (!$player->isFreeForFight()) {
			Runtime::set('attacks', intval(Runtime::get('attacks') + 1));
			Runtime::set('content', array('message' => 'cant_attack_busy', 'action' => 'attack'));
			//Page::$sql->query("ROLLBACK");
			Std::redirect('/player/' . $player->id . '/');
		}

		if ($player->state != '') {
			$player->state2 = json_encode(array(
						'state' => $player->state,
						'stateparam' => $player->stateparam,
						'timer' => $player->timer,
					));
			$state2 = ", state2 = '" . addslashes($player->state2) . "' ";
		} else {
			$state2 = "";
		}
		//self::$sql->query("UPDATE player SET state = 'fight' " . $state2 . " WHERE id = " . $player->id . " AND state != 'fight'");
		//if (self::$sql->getAffectedRows() > 0) {
		//	if (self::$sql->getValue("SELECT count(*) FROM duel WHERE player2 = " . $player->id . " AND time > " . (time() - 60 * 60)) == 0) {
				// сюда прошел только один запрос
				//Page::$sql->query("UPDATE player SET state = 'fight' " . $state2 . " WHERE id = " . $player->id);
				//Page::$sql->query("COMMIT");

		//		self::$player->updateOnlineCounters(ONLINECOUNTER_DUELS);

				// травмы
				$this->processTravma();

				//Runtime::set('attacks', 0);
				//Runtime::set('skip_in_alley', '');
				$duel = $this->fight($player, $werewolf);
				Std::redirect('/alley/fight/' . $duel->id . '/' . Page::generateKeyForDuel($duel->id) . '/');
		//	}
		//}

		//Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		//Std::redirect("/player/" . $player->id . "/");
	}

	/**
	 * Получение травмы
	 */
	private function processTravma() {
		//$fights = (int)Runtime::get('fights');
		//if (!$fights || $fights == 0) {
		//$d1 = date('Y-m-d', time());
		//$fights = array_sum(self::$sql->getValueSet("SELECT duels FROM onlinecounter WHERE player=" . self::$player->id . " AND (dt='" . $d1 . "' OR dt=DATE_SUB('" . $d1 . "', INTERVAL 1 DAY)"));
		//$fights = self::$sql->getValue("select count(*) from duel where id > 13000000 and player1=" . self::$player->id . " and time>unix_timestamp(date(now())) and time>unix_timestamp('" . self::$player2->travmadt . "')");
		//$fights = self::$sql->getValue("SELECT count(*) FROM log WHERE player=" . self::$player->id . " and type='fight_attacked' and dt>DATE_SUB(now(), interval 1 day) and dt>'" . self::$player2->travmadt . "'");
		
		$t = max(strtotime(self::$player2->travmadt), time() - 86400);
		$query = "SELECT COUNT(1) FROM duel WHERE player1 = " . self::$player->id . " AND time > " . $t;
		$fights = (int) Page::$sql->getValue($query);
		//}
		$fights++;
		Runtime::set('fights', $fights);
		if ((DEV_SERVER && $fights > mt_rand(100, 200)) || (($fights - 150) > mt_rand(1, 50))) {
			self::$player2->travmadt = date('Y-m-d H:i:s', (time() + 12 * 60 * 60));
			self::$player2->save(self::$player2->id, array(player2Object::$TRAVMADT));
			Page::sendLog(self::$player->id, 'trvm', array());
		}
	}

	/**
	 * Бой
	 *
	 * @param object $player
	 * @return object
	 */
	protected function fight($player, $werewolf = false) {
		Std::loadMetaObjectClass('duel');
		$duel = new duelObject;
		$player->loadInventory();
		$player->loadPet();
		$player->updateHomeSalary();
		if ($werewolf) {
			$werewolf = new playerObject();
			if (is_a($player->pet, 'petObject')) {
				$werewolf->pet = $player->pet;
				$werewolf->pet->image = 'pets/3-4.png';
				$werewolf->pet->name = 'Попугай "Йаррр!"';
				$werewolf->pet->hp = $werewolf->pet->maxhp;
			}
			$werewolf_data = json_decode(Page::$player2->werewolf_data, true);
			$s = $werewolf_data['stats'];
			unset($werewolf_data['stats']);
			$werewolf_data = array_merge($werewolf_data, $s);
			foreach ($werewolf_data as $key => $value) {
				$werewolf->{$key} = $value;
			}
			$werewolf->exp = Page::$player->exp;
			$werewolf->stateparam = Page::$player->level;
			$werewolf->avatar = 'npc2.png';
			$werewolf->background = 'avatar-back-4';
			$werewolf->state = 'werewolf';
			$werewolf->nickname = 'Оборотень в погонах';
			$werewolf->playboy = Page::$player->playboy;
			$werewolf->accesslevel = Page::$player->accesslevel;
			$werewolf->health_finish = $werewolf->health;
			$werewolf->strength_finish = $werewolf->strength;
			$werewolf->dexterity_finish = $werewolf->dexterity;
			$werewolf->intuition_finish = $werewolf->intuition;
			$werewolf->attention_finish = $werewolf->attention;
			$werewolf->resistance_finish = $werewolf->resistance;
			$werewolf->charism_finish = $werewolf->charism;
			$werewolf->sex = 'male';
			$werewolf->hp = $werewolf->maxhp = $werewolf->calcMaxHp();
			$werewolf->money = Page::$player->money;
			$werewolf->suspicion = Page::$player->suspicion;
			$werewolf->ore = Page::$player->ore;
            $werewolf->oil = Page::$player->oil;
			$werewolf->honey = Page::$player->honey;
			$werewolf->lastfight = Page::$player->lastfight;
			$werewolf->respect = Page::$player->respect;
			$werewolf->id = Page::$player->id;
			$werewolf->huntdt = Page::$player->huntdt;
			$werewolf->skillhunt = Page::$player->skillhunt;
			$werewolf->data = Page::$player->data;
			$duel->fight($werewolf, $player, false, true);

			//var_dump($werewolf);
			//exit;
		} else {
			self::$player->loadInventory();
			self::$player->loadPet();
			$duel->fight(self::$player, $player);
			self::$player->suspicionTest();
		}
		Runtime::set('interactive', 1);
		return $duel;
	}

	/**
	 * Патрулирование
	 *
	 * @param int $time - время патрулирования в минутах
	 * @return array
	 */
	public static function patrol($time) {
		$result = array('type' => 'alley', 'action' => 'patrol');
		$result['url'] = '/alley/';
		if (self::$player->isFree() == false) {
			$result['result'] = 0;
			$result['error'] = 'player is busy';
			return $result;
		} else if (self::$player->level > 1 && self::$player->money < 10) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}
		if (self::$player->level > 1) {
			self::$player->money -= 10;
		}
		self::$player->state = 'patrol';
		$endTime = time() + $time * 60;
		$endTime -= time() + date("s", $endTime);
		self::$player->timer = time() + $endTime;

		if (self::$player->level == 1) {
			$r = 100;
		} else {
			$r = mt_rand(0, 100);
		}

		if ($r > (100 / $time)) {
			$salary = 10 + round(mt_rand(1, 40) * $time / 60 + self::$player->charism_finish * 20 * $time / 60);
		} else {
			$salary = 10;
		}
		$b = 0;
		if (Page::$player2->patrol_bonus == 'patrol_salary_25') {
			$b = 25;
		} else if (Page::$player2->patrol_bonus == 'patrol_salary_50') {
			$b = 50;
		}

		if (Page::getData("player_hasgift_svistok_" . self::$player->id,
			"SELECT count(*) FROM gift WHERE code='svistok' AND player = " . self::$player->id, "value", 300)) {
			$b += 30;
		}

		$salary = round($salary * (100 + $b) / 100);

		// опыт при патрулировании более 10 минут
		$exp = 0;
		if ($time / 10 > 1) {
			$exp = floor($time / 10 * rand(1, 5) / 10);
		}

        // район патрулирования
        $metro = (int)$_POST["region"];
        $metroParams = Page::getData("alley_metro_" . $metro . "_fraction",
            "SELECT fraction, rbonus, abonus FROM metro WHERE id = " . $metro, "record", 3600);
        if ($metroParams['fraction'] == self::$player->fraction) {
            self::$player->stateparam = $metro;
        } else {
            self::$player->stateparam = Page::getData("alley_" . self::$player->fraction . "_startmetro",
                "SELECT id FROM metro WHERE fraction = '" . self::$player->fraction . "' AND private = 1", "value", 3600);
        }
		Runtime::set('lastmetro', $metro);

		// бонусы за патрулирование районов
		if (self::$player->patrol_time < mktime(0, 0, 0, date('m'), date('d'), date('Y')) && $metro == Page::$player->stateparam) {
			$time2 = mktime(0, 0, 0);
			if (isset(Page::$player->data['lastpatrolbonus'])) {
				$r2 = 33 * (floor(($time2 - Page::$player->data['lastpatrolbonus']) / 3600 / 24) + 1);
			} else {
				$r2 = 34;
				Page::$player->data['lastpatrolbonus'] = mktime(0, 0, 0) - 3600*24;
			}
			if (rand(1, 100) <= $r2) {
				$bonus = json_decode($metroParams[Page::$player->fraction{0} . 'bonus'], true);
				if (is_array($bonus) && count($bonus)) {
					$bonus2 = array();
					foreach ($bonus as $b) {
						$bonus2[] = $b['code'];
						if ($b['wt'] >= 2) {
							$bonus2[] = $b['code'];
						}
						if ($b['wt'] == 3) {
							$bonus2[] = $b['code'];
						}
					}
					$bonus = $bonus2[rand(0, count($bonus2)-1)];
					$actions = Page::$data['metro']['bonuses'][$bonus]['actions'];
					Page::fullActions(Page::$player, $actions, AlleyLang::ALERT_PATROL_BONUS);
					Page::$player->data['lastpatrolbonus'] = mktime(0, 0, 0);
				}
			}
		}

		self::$player->beginWork('patrol', $endTime, $salary, $exp);
		//if (!DEV_SERVER) {
			if (self::$player->patrol_time < mktime(0, 0, 0, date('m'), date('d'), date('Y'))) {
				self::$player->patrol_time = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + $time * 60;
			} else {
				self::$player->patrol_time += $time * 60;
			}
		//}
		Page::$player->data = json_encode(Page::$player->data);
		self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$STATEPARAM, playerObject::$TIMER, playerObject::$PATROL_TIME, playerObject::$MONEY, playerObject::$DATA));
		Page::$player->data = json_decode(Page::$player->data, true);

		// караваны
		$r = mt_rand(1, 100);
		$m = 0;
		
		if (Page::$player2->patrol_bonus == 'caravan_probability') {
			$m += 50;
		}
		
		
		$r = round($r * (100 - $m) / 100);
		
		if ($podkova = Page::$player->getItemForUseByCode('podkova')) {
			if (mt_rand(1,100)<11) {
				$r = 0;
				Page::$player->useItemFast($podkova);
			}
		}
		if ($r <= $time / 720 * 100) {
			Runtime::set('desert/state', 'begin');
			
		}

		$result['result'] = 1;
		
		return $result;
	}

	/**
	 * Показ анимированной дуэли
	 *
	 * @param object $duel
	 * @return void
	 */
	protected function showFlashFight($duel) {
		if (!DEV_SERVER && Page::generateKeyForDuel($this->url[1]) != $this->url[2]) {
			$this->dieOnError(404);
		}
		if (!is_a($duel, 'duelObject')) {
			Std::loadMetaObjectClass('duel');
			$duelq = new duelObject;
			if (!$duelq->load($duel)) {
				$this->content['result'] = 0;
				$this->content['error'] = 'fight not found';
				$this->content['window-name'] = AlleyLang::$windowTitle;
				$this->page->addPart('content', 'fight/fight.xsl', $this->content);
				$this->default = false;
				//$this->showAlley();
				return;
			}
			$duel = $duelq;
		}

		$acting = array();

		$this->content['acting'] = $duel->acting;
		foreach ($this->content['acting'] as &$act) {
			$acting[] = array("kt" => $act["kt"], "sx" => $act["sx"]);

			if (isset($act['health_finish'])) {
				$max = max($act['health_finish'], $act['dexterity_finish'], $act['strength_finish'], $act['intuition_finish'], $act['charism_finish'], $act['resistance_finish'], $act['attention_finish']);
				$act['procenthp'] = round($act['hp'] / $act['maxhp'] * 100);
			} elseif (isset($act['health'])) {
				$max = max($act['health'], $act['dexterity'], $act['strength'], $act['intuition'], $act['charism'], $act['resistance'], $act['attention']);
				$act['procenthp'] = round($act['hp'] / $act['maxhp'] * 100);
			} else {
				$max = max($act['h'], $act['d'], $act['s'], $act['i'], $act['c'], $act['r'], $act['a']);
				$act['procenthp'] = round($act['hp'] / $act['mhp'] * 100);

				if (isset($act['h0']) && isset($act['d0']) && isset($act['s0']) && isset($act['i0']) && isset($act['c0']) && isset($act['r0']) && isset($act['a0'])) {
					foreach (Page::$data['stats'] as $stat => $tmp) {
						//$act['p' . $stat{0}] = floor($act[$stat{0} . '0'] / $max * 100);
						//$act['p' . $stat{0} . '2'] = floor(($act[$stat{0}] - $act[$stat{0} . '0']) / $max * 100);
						//$act[$stat{0}] = $act[$stat{0}] - $act[$stat{0} . '0'];

						$statLetter = $stat{0};
						$statValue = $act[$statLetter . '0'];
						$statValueFinish = $act[$statLetter];

						$act['p' . $statLetter] = floor(($statValue - ($statValueFinish > $statValue ? 0 : $statValue - $statValueFinish)) / $max * 100);
						$act['p' . $statLetter . '2'] = $statValueFinish >= $statValue ? floor(($statValueFinish - $statValue) / $max * 100) : 0;
						$act['p' . $statLetter . '3'] = $statValueFinish < $statValue ? floor(($statValue - $statValueFinish) / $max * 100) : 0;
						$act[$statLetter] = $statValueFinish - $statValue;
					}
				}
			}
			foreach (Page::$data['stats'] as $stat) {
				$stat = $stat['code'];
				if (isset($act['health_finish'])) {
					$act['procent' . $stat] = floor($act[$stat . '_finish'] / $max * 100);
				} elseif (isset($act['health'])) {
					$act['procent' . $stat] = floor($act[$stat] / $max * 100);
				} else {
					$act['procent' . $stat] = floor($act[$stat{0}] / $max * 100);
				}
			}

			if (isset($act['pet'])) {
				$act['pet']['hppcnt'] = round($act['pet']['hp'] / $act['pet']['mhp'] * 100);
				$act['pet']['im'] = str_replace('.png', '', $act['pet']['im']);
			}

			$dopings = array();
			if ($act['rc'] > 0) {
				$dopings[] = Lang::$captionRatingCrit . ': +' . $act['rc'] . '';
			}
			if ($act['rd'] > 0) {
				$dopings[] = Lang::$captionRatingDodge . ': +' . $act['rd'] . '';
			}
			if ($act['rr'] > 0) {
				$dopings[] = Lang::$captionRatingResistance . ': +' . $act['rr'] . '';
			}
			if ($act['rac'] > 0) {
				$dopings[] = Lang::$captionRatingActiCrit . ': +' . $act['rac'] . '';
			}
			if ($act['rdm'] > 0) {
				$dopings[] = Lang::$captionRatingDamage . ': +' . $act['rdm'] . '';
			}
			if ($act['ra'] > 0) {
				$dopings[] = Lang::$captionRatingAccur . ': +' . $act['ra'] . '';
			}
			if (sizeof($dopings) > 0) {
				$act['dopings'] = implode('|', $dopings);
			}
			if (isset($act['equipped']) && is_array($act['equipped'])) {
				foreach ($act['equipped'] as $itemType => &$itemInfo) {
					if (isset($itemInfo['id'])) {
						$item = self::$sql->getRecord("SELECT name, image, info, level FROM inventory WHERE id=" . $itemInfo['id']);
					} else {
						$item = Page::sqlGetCacheRecord("SELECT name, image, info, level FROM standard_item WHERE id=" . $itemInfo['si'], 3600);
					}
					$itemInfo['name'] = $item['name'];
					$itemInfo['image'] = $item['image'];
					$itemInfo['info'] = $item['info'];
					$itemInfo['type'] = $itemType;
					$itemInfo['level'] = $item['level'];

					Page::parseSpecialParams($itemInfo, true);
				}
			}
		}
		foreach ($duel->log as $key => &$step) {
			if (is_array($step) && is_array($step[0])) {
				foreach ($step[0] as &$strike) {
					$varName = 'fightStrings';
					if ($duel->acting[$strike[0]]['type'] == 'pet' || $duel->acting[$strike[0]]['t'] == 'pet') {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsAnimalMiss;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsAnimalStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsAnimalCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsAnimalInjury;
						}
					} else {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsMiss;
							$strike[2][1] = 0;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsInjury;
						} elseif ($strike[2][0] == 11) {
							$varName = AlleyLang::$fightStringsNaezd;
						} elseif ($strike[2][0] == 12) {
							$varName = AlleyLang::$fightStringsNaezd40;
						} elseif ($strike[2][0] == 21 || $strike[2][0] == 22) {
							$varName = AlleyLang::$fightStringsCombo[$strike[2][3]][$acting[$strike[0]]["sx"]];
						}
					}
					if ($strike[2][2] == -1 || !is_array($varName) || !isset($varName[$strike[2][2]])) {
						$strike[2][2] = explode('%', (is_array($varName) ? $varName[rand(0, count($varName) - 1)] : $varName));
					}
				}
			} elseif ($step[0] == 'duellogtext') {
				$this->content['duellogtext'] = $step[1];
				unset($duel->log[$key]);
			}
		}

		$this->content['naezdkostil'] = $duel->log[0][0][0][2][0] == 11 ? 1 : 0;
		$this->content['attack-string'] = explode('%', AlleyLang::$attackStrings[rand(0, count(AlleyLang::$attackStrings) - 1)]);
		$this->content['log'] = array_reverse($duel->log);
		$this->content['time'] = date("H:i:s", $duel->time);
		$this->content['date'] = date("d.m.Y", $duel->time);
		$this->content['id'] = $duel->id;
		$this->content['sk'] = Page::generateKeyForDuel($duel->id);
		$this->content['winner'] = $duel->winner;
		$this->content['profit'] = $duel->profit;
		$this->content['exp'] = $duel->exp;
		
		$this->content['params'] = json_decode($duel->params, true);
		if (self::$player->id > 0) {
			$this->content['player'] = self::$player->toArray();
		}

		// если пришли сюда после атаки и нужно применить результат боя
		if (Runtime::get('interactive') !== false) {
			Runtime::clear('interactive');
			$this->content['interactive'] = 1;
			if ($this->content['params']['werewolf'] != 1) {
				self::$player->hp = $duel->acting[0]['hp'];
			}
			if ($duel->winner == self::$player->id) {
				self::$player->money -= $duel->profit;
			} else if ($duel->winner > 0) {
				self::$player->money += $duel->profit;
			}
			// автолечение питомцев
			self::usePetAutoFood($duel->acting[0]['id']);
			self::usePetAutoFood($duel->acting[1]['id']);
		} else {
			$this->content['interactive'] = 0;
		}
		if ($this->content['params']['werewolf'] == 1) {
			//$this->content['acting'][0]['id'] = 0;
			$this->content['acting'][0]['fr'] = 'w';
		}

		if ($this->content['params']['werewolf'] == 1) {
			$this->content['acting'][0]['id'] = -10;
			$this->content['acting'][0]['avatar'] = 'npc_werewolf';
			
			if ($duel->winner == $duel->acting[0]['id']) {
				$duel->winner = -10;
				$this->content['winner'] = -10;
			}
		}

		if (!isset($this->content['params']['attacks'])) {
			$attacks = array(1 => array(), 2 => array());
			for ($i = 1; $i <= 2; $i ++) {
				while (count($attacks[$i]) < 3) {
					$w = rand(0, count(Page::$data['duels']['weapons']) - 1);
					if (!isset($attacks[$i][$w])) {
						$attacks[$i][$w] = rand(1, Page::$data['duels']['weapons'][$w]['weapons']);
					}
				}
			}
			$this->content['params']['attacks'] = $attacks;
		}

		if (!isset($this->content['params']['bg'])) {
			//$this->content['params']['attacks'] = rand();
		}

		if ($duel->acting[1]['av'] == 'npc1.png') {
			$background = 6;
		} else if ($this->content['params']['neft']) {
			$background = 7;
		} else {
			$background = ($duel->id % 5 + 1);
		}
		$result = '<fight id="' . $duel->id . '" background="' . $background . '" winner="' . $duel->winner . '">' . PHP_EOL;

		$result .= '  <players>' . PHP_EOL;
		foreach ($this->content['acting'] as $key => $a) {
			if (isset($a['id']) && $a['t'] != 'pet') {
				$result .= '    <player id="' . $a['id'] . '" type="player" hp="' . $a['hp'] . '" maxhp="' . $a['mhp'] . '" avatar="' . str_replace('.png', '', $a['av']) . '" nickname="' . $a['nm'] . '" level="' . $a['lv'] . '" position="' . $a['position'] . '" image="' . $a['im'] . '" animation="' . implode(',', array_keys($this->content['params']['attacks'][$a['position']+1])) . '" weapons="' . implode(',', $this->content['params']['attacks'][$a['position']+1]) . '" />' . PHP_EOL;
			} else {
				$result .= '    <player player="' . $duel->acting[$a['position']-2]['id'] . '" type="pet" hp="' . $a['hp'] . '" maxhp="' . $a['mhp'] . '" avatar="' . str_replace('.png', '', $a['im']) . '" nickname="' . str_replace(array('"', '&quot;'), '', $a['nm']) . '" position="' . $a['position'] . '" />' . PHP_EOL;
			}
		}
		$result .= '  </players>' . PHP_EOL;

		foreach ($duel->log as $key => &$step) {
			if (is_array($step) && is_array($step[0])) {
				foreach ($step[0] as &$strike) {
					$varName = 'fightStrings';
					if ($duel->acting[$strike[0]]['type'] == 'pet') {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsAnimalMiss;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsAnimalStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsAnimalCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsAnimalInjury;
						}
					} else {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsMiss;
							$strike[2][1] = 0;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsInjury;
						} elseif ($strike[2][0] == 11) {
							$varName = AlleyLang::$fightStringsNaezd;
						} elseif ($strike[2][0] == 12) {
							$varName = AlleyLang::$fightStringsNaezd40;
						} elseif ($strike[2][0] == 21 || $strike[2][0] == 22) {
							$varName = AlleyLang::$fightStringsCombo[$strike[2][3]][$acting[$strike[0]]["sx"]];
						}
					}
					if (!@isset($varName[$strike[2][2]]) || @$strike[2][2] == -1 || !is_array($varName)) {
						$strike[2][2] = (is_array($varName) ? $varName[rand(0, count($varName) - 1)] : $varName);
					}
				}
			} elseif ($step[0] == 'duellogtext') {
				$result .= '  <duellogtext>' . $step[1] . '</duellogtext>';
				$this->content['duellogtext'] = $step[1];
				unset($duel->log[$key]);
			}
		}

		$result .= '  <turns>' . PHP_EOL;
		foreach ($duel->log as $key => &$step) {
			$result .= '    <turn>' . PHP_EOL;
			foreach ($step[0] as $s) {
				$result .= '      <action a="' . $s[0] . '" d="' . $s[1] . '" t="' . $s[2][0] . '" dp="' . $s[2][1] . '" />' . PHP_EOL;
			}
			$result .= '    </turn>' . PHP_EOL;
		}

		$result .= '  </turns>' . PHP_EOL;

		$result .= '</fight>' . PHP_EOL;
		$result = str_replace("\"", "'", $result);
		$this->content['xml'] = str_replace(array("\r", "\n"), "", $result);

		if ($backlink = Runtime::get("showfight_backlink")) {
			Runtime::clear("showfight_backlink");
			$this->content['backlink'] = $backlink;
		}

		$this->content['window-name'] = $this->content['acting'][0]['nm'] . ' [' . $this->content['acting'][0]['lv'] . '] vs. ' .
				$this->content['acting'][1]['nm'] . ' [' . $this->content['acting'][1]['lv'] . ']';
		$this->page->addPart('content', 'fight/flashfight.xsl', $this->content);
		$this->default = false;
	}

	/**
	 * Показ дуэли
	 *
	 * @param object $duel
	 * @return void
	 */
	protected function showFight($duel) {
//		if (!DEV_SERVER) {
//            if (Page::$cache->get('fights_views_' . ip2long($_SERVER['REMOTE_ADDR']))) {
//                echo file_get_contents('@tpl/many_fights_view.html');
//                exit;
//            } else {
//                Page::$cache->set('fights_views_' . ip2long($_SERVER['REMOTE_ADDR']), 1, 5);
//            }
//        }
		if (Page::generateKeyForDuel($this->url[1]) != $this->url[2]) {
			$this->dieOnError(404);
		}
		if (!is_a($duel, 'duelObject')) {
			Std::loadMetaObjectClass('duel');
			$duelq = new duelObject;
			if (!$duelq->load($duel)) {
				$this->content['result'] = 0;
				$this->content['error'] = 'fight not found';
				$this->content['window-name'] = AlleyLang::$windowTitle;
				$this->page->addPart('content', 'fight/fight.xsl', $this->content);
				$this->default = false;
				//$this->showAlley();
				return;
			}
			$duel = $duelq;
		}

		$acting = array();

		$this->content['acting'] = $duel->acting;
		foreach ($this->content['acting'] as &$act) {
			$acting[] = array("kt" => $act["kt"], "sx" => $act["sx"]);

			if (isset($act['health_finish'])) {
				$max = max($act['health_finish'], $act['dexterity_finish'], $act['strength_finish'], $act['intuition_finish'], $act['charism_finish'], $act['resistance_finish'], $act['attention_finish']);
				$act['procenthp'] = round($act['hp'] / $act['maxhp'] * 100);
			} elseif (isset($act['health'])) {
				$max = max($act['health'], $act['dexterity'], $act['strength'], $act['intuition'], $act['charism'], $act['resistance'], $act['attention']);
				$act['procenthp'] = round($act['hp'] / $act['maxhp'] * 100);
			} else {
				$max = max($act['h'], $act['d'], $act['s'], $act['i'], $act['c'], $act['r'], $act['a']);
				$act['procenthp'] = round($act['hp'] / $act['mhp'] * 100);

				if (isset($act['h0']) && isset($act['d0']) && isset($act['s0']) && isset($act['i0']) && isset($act['c0']) && isset($act['r0']) && isset($act['a0'])) {
					foreach (Page::$data['stats'] as $stat => $tmp) {
						//$act['p' . $stat{0}] = floor($act[$stat{0} . '0'] / $max * 100);
						//$act['p' . $stat{0} . '2'] = floor(($act[$stat{0}] - $act[$stat{0} . '0']) / $max * 100);
						//$act[$stat{0}] = $act[$stat{0}] - $act[$stat{0} . '0'];

						$statLetter = $stat{0};
						$statValue = $act[$statLetter . '0'];
						$statValueFinish = $act[$statLetter];

						$act['p' . $statLetter] = floor(($statValue - ($statValueFinish > $statValue ? 0 : $statValue - $statValueFinish)) / $max * 100);
						$act['p' . $statLetter . '2'] = $statValueFinish >= $statValue ? floor(($statValueFinish - $statValue) / $max * 100) : 0;
						$act['p' . $statLetter . '3'] = $statValueFinish < $statValue ? floor(($statValue - $statValueFinish) / $max * 100) : 0;
						$act[$statLetter] = $statValueFinish - $statValue;
					}
				}
			}
			foreach (Page::$data['stats'] as $stat) {
				$stat = $stat['code'];
				if (isset($act['health_finish'])) {
					$act['procent' . $stat] = floor($act[$stat . '_finish'] / $max * 100);
				} elseif (isset($act['health'])) {
					$act['procent' . $stat] = floor($act[$stat] / $max * 100);
				} else {
					$act['procent' . $stat] = floor($act[$stat{0}] / $max * 100);
				}
			}

			if (isset($act['pet']) && is_array($act['pet'])) {
				$act['pet']['hppcnt'] = round($act['pet']['hp'] / $act['pet']['mhp'] * 100);
				$act['pet']['im'] = str_replace('.png', '', $act['pet']['im']);
			}

			$dopings = array();
			if ($act['rc'] > 0) {
				$dopings[] = Lang::$captionRatingCrit . ': +' . $act['rc'] . '';
			}
			if ($act['rd'] > 0) {
				$dopings[] = Lang::$captionRatingDodge . ': +' . $act['rd'] . '';
			}
			if ($act['rr'] > 0) {
				$dopings[] = Lang::$captionRatingResistance . ': +' . $act['rr'] . '';
			}
			if ($act['rac'] > 0) {
				$dopings[] = Lang::$captionRatingActiCrit . ': +' . $act['rac'] . '';
			}
			if ($act['rdm'] > 0) {
				$dopings[] = Lang::$captionRatingDamage . ': +' . $act['rdm'] . '';
			}
			if ($act['ra'] > 0) {
				$dopings[] = Lang::$captionRatingAccur . ': +' . $act['ra'] . '';
			}
			if ($act['ra'] > 0) {
				$dopings[] = Lang::$captionRatingAccur . ': +' . $act['ra'] . '';
			}
			if ($act['pdmg'] > 0) {
				$dopings[] = Lang::$captionPercentDmg . ': +' . $act["pdmg"] . '%';
			}
			if ($act['pdef'] > 0) {
				$dopings[] = Lang::$captionPercentDefence . ': +' . $act["pdef"] . '%';
			}
			if ($act['phit'] > 0) {
				$dopings[] = Lang::$captionPercentHit . ': +' . $act["phit"] . '%';
			}
			if ($act['pdod'] > 0) {
				$dopings[] = Lang::$captionPercentDodge . ': +' . $act["pdod"] . '%';
			}
			if ($act['pcrt'] > 0) {
				$dopings[] = Lang::$captionPercentCrit . ': +' . $act["pcrt"] . '%';
			}
			if ($act['pacrt'] > 0) {
				$dopings[] = Lang::$captionPercentAnticrit . ': +' . $act["pacrt"] . '%';
			}

			if (sizeof($dopings) > 0) {
				$act['dopings'] = implode('|', $dopings);
			}
			if (isset($act['equipped']) && is_array($act['equipped'])) {
				foreach ($act['equipped'] as $itemType => &$itemInfo) {
					if (isset($itemInfo['id'])) {
						$item = self::$sql->getRecord("SELECT name, image, info, level FROM inventory WHERE id=" . $itemInfo['id']);
					} else {
						$item = Page::sqlGetCacheRecord("SELECT name, image, info, level FROM standard_item WHERE id=" . $itemInfo['si'], 3600);
					}
					$itemInfo['name'] = $item['name'];
					$itemInfo['image'] = $item['image'];
					$itemInfo['info'] = $item['info'];
					$itemInfo['type'] = $itemType;
					$itemInfo['level'] = $item['level'];

					Page::parseSpecialParams($itemInfo, true);
				}
			}
		}
		foreach ($duel->log as $key => &$step) {
			if (is_array($step) && is_array($step[0])) {
				foreach ($step[0] as &$strike) {
					$varName = 'fightStrings';
					if ($duel->acting[$strike[0]]['type'] == 'pet' || $duel->acting[$strike[0]]['t'] == 'pet') {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsAnimalMiss;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsAnimalStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsAnimalCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsAnimalInjury;
						} else if ($strike[2][0] == 52) {
							$varName = AlleyLang::$fightStringsPetStun;
						} else if ($strike[2][0] == 50) {
							$varName = AlleyLang::$fightStringsPetToPlayer;
						} else if ($strike[2][0] == 51) {
							$varName = AlleyLang::$fightStringsPetCatch;
						} else {
							die($strike[2][0] . ' unknown');
						}
					} else {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsMiss;
							$strike[2][1] = 0;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsInjury;
						} elseif ($strike[2][0] == 11) {
							$varName = AlleyLang::$fightStringsNaezd;
						} elseif ($strike[2][0] == 12) {
							$varName = AlleyLang::$fightStringsNaezd40;
						} elseif ($strike[2][0] == 21) {
							$varName = AlleyLang::$fightStringsCombo[$strike[2][3]][$acting[$strike[0]]["sx"]];
						} elseif ($strike[2][0] == 22) {
							$varName = AlleyLang::$fightStringsCombo[$strike[2][3]][$acting[$strike[1]]["sx"]];
						} elseif ($strike[2][0] == 31) {
                            $varName = AlleyLang::$fightStringsPerksKnockOut;
                        } elseif ($strike[2][0] == 32) {
                            $varName = AlleyLang::$fightStringsPerksVampir;
                        } elseif ($strike[2][0] == 33) {
                            $varName = AlleyLang::$fightStringsPerksRatKiller;
                        } else {
							die($strike[2][0] . ' unknown');
						}
					}
					if (!isset($strike[2][1])) {
						$strike[2][1] = 0;
					}
					if ($strike[2][2] == -1 || !is_array($varName) || !isset($varName[$strike[2][2]])) {
						$strike[2][2] = explode('%', (is_array($varName) ? $varName[rand(0, count($varName) - 1)] : $varName));
					}
				}
			} elseif ($step[0] == 'duellogtext') {
				$this->content['duellogtext'] = $step[1];
				unset($duel->log[$key]);
			}
		}
		
		$this->content['naezdkostil'] = $duel->log[0][0][0][2][0] == 11 ? 1 : 0;
		$this->content['attack-string'] = explode('%', AlleyLang::$attackStrings[rand(0, count(AlleyLang::$attackStrings) - 1)]);
		$this->content['log'] = array_reverse($duel->log);

		$this->content['time'] = date("H:i:s", $duel->time);
		$this->content['date'] = date("d.m.Y", $duel->time);
		$this->content['id'] = $duel->id;
		$this->content['sk'] = Page::generateKeyForDuel($duel->id);
		$this->content['winner'] = $duel->winner;
		$this->content['profit'] = $duel->profit;
		$this->content['exp'] = $duel->exp;
		//$this->content['flag'] = $duel->flag;
		$this->content['params'] = json_decode($duel->params, true);

		if (self::$player->id > 0) {
			$this->content['player'] = self::$player->toArray();
		}
		// если пришли сюда после атаки и нужно применить результат боя
		if (Runtime::get('interactive') !== false) {
			Runtime::clear('interactive');
			$this->content['interactive'] = 1;
			if ($this->content['params']['werewolf'] != 1) {
				self::$player->hp = $duel->acting[0]['hp'];
			}
			if ($duel->winner == self::$player->id) {
				self::$player->money -= $duel->profit;
			} else if ($duel->winner > 0) {
				self::$player->money += $duel->profit;
			}
			// автолечение питомцев
			self::usePetAutoFood($duel->acting[0]['id']);
			self::usePetAutoFood($duel->acting[1]['id']);
		} else {
			$this->content['interactive'] = 0;
		}
		if ($this->url[2] == 'interactive') {
			$this->content['interactive'] = 1;
		}
		if ($this->content['params']['werewolf'] == 1) {
			//$this->content['acting'][0]['id'] = 0;
			$this->content['acting'][0]['fr'] = 'w';
		}

		if ($backlink = Runtime::get("showfight_backlink")) {
			Runtime::clear("showfight_backlink");
			$this->content['backlink'] = $backlink;
		}

		$this->content['window-name'] = $this->content['acting'][0]['nm'] . ' [' . $this->content['acting'][0]['lv'] . '] vs. ' .
				$this->content['acting'][1]['nm'] . ' [' . $this->content['acting'][1]['lv'] . ']';
		$this->page->addPart('content', 'fight/fight.xsl', $this->content);
		$this->default = false;
	}

	/**
	 * Закоулки
	 */
	protected function showAlley() {
		Std::loadModule('Fight');

		$this->forceForward();
		$this->content['desert'] = Runtime::get('desert');
		$this->content['player'] = self::$player->toArray();
		if (Page::$player2->werewolf == 1) {
			$this->content['player2']['werewolf'] = 1;
		}
		if (self::$player->state == 'patrol' && self::$player->timer > time()) {
			$timer = self::$player->timer - time();
			$patrolTime = self::$sql->getValue("SELECT time FROM playerwork WHERE player=" . self::$player->id . " AND type='patrol'");
			$this->content['timer'] = $timer > 0 ? $timer : 0;
			$this->content['patroltimeleft2'] = date('H:i:s', $timer);
			$this->content['patroltimetotal'] = $patrolTime;
			$this->content['patrolpercent'] = round(($patrolTime - $timer) / $patrolTime * 100);
		} else {
			if (self::$player2->naperstki == 1 || self::$player2->naperstki == 3) {
				// костыль для убирания ошибки 502, у тех кто во время обновы сидел с моней в патруле.
				self::$player2->naperstki = -1;
				self::$player2->naperstkidata = '';
				self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKI, player2Object::$NAPERSTKIDATA));
			}
		}
		$this->content['svistok'] = Page::getData("player_hasgift_svistok_" . self::$player->id,
			"SELECT count(*) FROM gift WHERE code='svistok' AND player = " . self::$player->id, "value", 300);

		$this->content['naperstki'] = self::$player2->naperstki;

		$this->content['player']['isfree'] = intval(self::$player->isFree());
		$this->content['window-name'] = "Закоулки";
		$this->content['unixtime'] = time();

		$this->content['minlevel'] = Runtime::get('minlevel') ? Runtime::get('minlevel') : self::$player->level;
		$this->content['maxlevel'] = Runtime::get('maxlevel') ? Runtime::get('maxlevel') : self::$player->level;
		if (Page::$player2->werewolf == 1) {
			$tmp = json_decode(Page::$player2->werewolf_data, true);
			$this->content['werewolf_minlevel'] = Runtime::get('minlevel') ? Runtime::get('minlevel') : $tmp['level'];
			$this->content['werewolf_maxlevel'] = Runtime::get('maxlevel') ? Runtime::get('maxlevel') : $tmp['level'];
		}
		
		// бой за флаг
		$flag = array(
			'id' => 0,
			'fraction' => CacheManager::get('value_flag_fraction'),
			'left' => array(),
			'right' => array(),
			'me' => 0,
			'state' => '',
		);
		$flagFight = self::$sql->getRecord("SELECT id, data, players, dt, state, ac, dc FROM fight WHERE type = 'flag' AND (state = 'created' OR state = 'started')");
		if ($flagFight) {
			$flag['id'] = $flagFight['id'];
			$flag['state'] = $flagFight['state'];

			$players = array();
			$playersId = array();
			Fight::getPlayersInFight($flagFight['id'], $players, $playersId);

			$data = json_decode($flagFight['data'], true);

			$leftSide = $data['a']['f'] == self::$player->fraction{0} ? 'a' : 'd';
			$rightSide = $leftSide == 'a' ? 'd' : 'a';
			$flag['left'] = array(
				'name' => self::$player->fraction == 'resident' ? Lang::$captionResident : Lang::$captionArrived,
				'count' => $flagFight[$leftSide . 'c'],
				'max' => ($flagFight['state'] == 'created' ? $data[$leftSide]['m'] : $data[$leftSide]['m3']),
				'code' => self::$player->fraction,
				'players' => array(),
			);
			$flag['right'] = array(
				'name' => self::$player->fraction == 'resident' ? Lang::$captionArrived : Lang::$captionResident,
				'count' => $flagFight[$rightSide . 'c'],
				'max' => ($flagFight['state'] == 'created' ? $data[$rightSide]['m'] : $data[$rightSide]['m3']),
				'code' => self::$player->fraction == 'resident' ? 'arrived' : 'resident',
				'players' => array(),
			);

			if ($players) {
				foreach ($players as $playerId => $player) {
					$flag[($player['sd'] == $leftSide ? 'left' : 'right')]['players'][] = $player;
					if ($playerId == self::$player->id) {
						$flag['me'] = 1;
					}
				}
			}
		}
		$this->content['flag'] = $flag;

		// клановый бой
		if (self::$player->clan > 0 && Page::$player->clan_status != 'recruit') {
			Std::loadMetaObjectClass('diplomacy');
			$warId = diplomacyObject::isAtWar(self::$player->clan);
			if ($warId) {
				$clanWar = array(
					'id' => 0,
					'left' => array(),
					'right' => array(),
					'me' => 0,
					'state' => '',
					'nearesthour' => '',
				);
				$clanWarFight = self::$sql->getRecord("SELECT id, data, players, dt, state, ac, dc FROM fight WHERE type = 'clanwar' AND (state = 'created' OR state = 'started') AND diplomacy=" . $warId);
				if ($clanWarFight) {
					$clanWar['id'] = $clanWarFight['id'];
					$clanWar['state'] = $clanWarFight['state'];

					$players = array();
					$playersId = array();
					Fight::getPlayersInFight($clanWarFight['id'], $players, $playersId);

					$data = json_decode($clanWarFight['data'], true);

					$leftSide = $data['a']['f'] == self::$player->fraction{0} ? 'a' : 'd';
					$rightSide = $leftSide == 'a' ? 'd' : 'a';
					$clanWar['left'] = array(
						'name' => self::$player->fraction == 'resident' ? Lang::$captionResident : Lang::$captionArrived,
						'count' => $clanWarFight[$leftSide . 'c'],
						'max' => $data[$leftSide]['m'],
						'code' => self::$player->fraction,
						'players' => array(),
					);
					$clanWar['right'] = array(
						'name' => self::$player->fraction == 'resident' ? Lang::$captionArrived : Lang::$captionResident,
						'count' => $clanWarFight[$rightSide . 'c'],
						'max' => $data[$rightSide]['m'],
						'code' => self::$player->fraction == 'resident' ? 'arrived' : 'resident',
						'players' => array(),
					);

					if ($players) {
						foreach ($players as $playerId => $player) {
							$clanWar[($player['sd'] == $leftSide ? 'left' : 'right')]['players'][] = $player;
							if ($playerId == self::$player->id) {
								$clanWar['me'] = 1;
							}
						}
					}
				}
				$this->content['clanwar'] = $clanWar;
			}
		}

		// уровневый бой
		Std::loadModule('Fight');
		$h = date('H', time());
		$levelFight = array(
			'id' => 0,
			'left' => array(),
			'right' => array(),
			'me' => 0,
			'state' => '',
			'nearesthour' => ($h + 1),
			'price' => Fight::$levelFightCost[self::$player->level],
			'prize' => Fight::$levelFightPrize[self::$player->level],
		);

		$curMaxLevel = CacheManager::get('value_maxlevel');
		$curLevelFightMaxLevel = CacheManager::get('value_levelfightmaxlevel');

//if (self::$player->level == $curMaxLevel && $curMaxLevel > $curLevelFightMaxLevel) {
		if (self::$player->level > $curLevelFightMaxLevel) {
			$lvlFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'level' AND (state = 'created' OR state = 'started') AND level=" . $curLevelFightMaxLevel);
		} else {
			$lvlFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'level' AND (state = 'created' OR state = 'started') AND level=" . self::$player->level);
		}
		if ($lvlFight) {
			$levelFight['id'] = $lvlFight['id'];
			$levelFight['state'] = $lvlFight['state'];

			$players = array();
			$playersId = array();
			Fight::getPlayersInFight($lvlFight['id'], $players, $playersId);

			$data = json_decode($lvlFight['data'], true);

			$leftSide = $data['a']['f'] == self::$player->fraction{0} ? 'a' : 'd';
			$rightSide = $leftSide == 'a' ? 'd' : 'a';
			$levelFight['left'] = array(
				'name' => self::$player->fraction == 'resident' ? Lang::$captionResident : Lang::$captionArrived,
				'count' => $lvlFight[$leftSide . 'c'],
				'max' => $data[$leftSide]['m'],
				'code' => self::$player->fraction,
				'players' => array(),
			);
			$levelFight['right'] = array(
				'name' => self::$player->fraction == 'resident' ? Lang::$captionArrived : Lang::$captionResident,
				'count' => $lvlFight[$rightSide . 'c'],
				'max' => $data[$rightSide]['m'],
				'code' => self::$player->fraction == 'resident' ? 'arrived' : 'resident',
				'players' => array(),
			);

			if ($players) {
				foreach ($players as $playerId => $player) {
					$levelFight[($player['sd'] == $leftSide ? 'left' : 'right')]['players'][] = $player;
					if ($playerId == self::$player->id) {
						$levelFight['me'] = 1;
					}
				}
			}
		}
		$this->content['levelfight'] = $levelFight;

		// хаотичный бой
		Std::loadModule('Fight');
		$chaoticFight = array(
			'id' => 0,
			'left' => array(),
			'me' => 0,
			'state' => '',
			'price' => Fight::$chaoticFightCost[self::$player->level],
		);

		$curMaxLevel = CacheManager::get('value_maxlevel');
		$curLevelFightMaxLevel = CacheManager::get('value_levelfightmaxlevel');

//if (self::$player->level == $curMaxLevel && $curMaxLevel > $curLevelFightMaxLevel) {
		if (self::$player->level > $curLevelFightMaxLevel) {
			$chFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'chaotic' AND (state = 'created' OR state = 'started') AND level=" . $curLevelFightMaxLevel);
		} else {
			$chFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'chaotic' AND (state = 'created' OR state = 'started') AND level=" . self::$player->level);
		}
		if ($chFight) {
			$chaoticFight['id'] = $chFight['id'];
			$chaoticFight['state'] = $chFight['state'];

			$players = array();
			$playersId = array();
			Fight::getPlayersInFight($chFight['id'], $players, $playersId);
			$data = json_decode($chFight['data'], true);

			$chaoticFight['left'] = array(
				'name' => Lang::CAPTION_PLAYERS,
				'count' => $chFight['ac'],
				'max' => $data['a']['m'],
				'players' => array(),
			);

			if ($players) {
				foreach ($players as $playerId => $player) {
					$chaoticFight['left']['players'][] = $player;
					if ($playerId == self::$player->id) {
						$chaoticFight['me'] = 1;
					}
				}
			}
		}
		$this->content['chaoticfight'] = $chaoticFight;

        $this->content["allowchaotic"] = self::$sql->getValue("SELECT count(*) FROM fightplayer fp JOIN fight f ON f.id = fp.fight
            WHERE f.dt > date_sub(now(), INTERVAL 1 DAY) AND f.type = 'chaotic' AND f.state = 'finished' AND fp.player=" . self::$player->id) < 8 ? 1 : 0;

		$this->content['bankfight'] = self::$sql->getRecord("SELECT id, state FROM fight WHERE type = 'bank' AND state = 'created'");

		// последние бои за флаг
		$lastFlagFights = self::$sql->getRecordSet("SELECT id, dt, results FROM fight WHERE type = 'flag' AND state = 'finished'
            ORDER BY id DESC LIMIT 0,5");
		if ($lastFlagFights) {
			Std::loadLib('HtmlTools');
			$fights = array();
			foreach ($lastFlagFights as $fight) {
				$fights[] = array('id' => $fight['id'], 'dt' => HtmlTools::FormatDateTime($fight['dt'], false, true, true));
			}
			$this->content['lastflagfights'] = $fights;
		}

		// тестовый групповой бой
		$testFight = self::$sql->getRecord("SELECT id FROM fight WHERE type = 'test' AND state = 'created'");
		if ($testFight) {
			$testgroupfight['state'] = 'created';
			$players = json_decode('{' . substr($testFight['players'], 1) . '}', true);
			$testgroupfight['me'] = isset($players[self::$player->id]) ? 1 : 0;
		}
		$this->content['testgroupfight'] = $testgroupfight;

        // противостояние - поиск npc
        if (self::$player->level > 2 && date("N", time()) == 4) {
            $sovet3 = self::$sql->getRecord("SELECT enemy, enemy_npc, points1, points1enemy FROM sovet3 WHERE fraction = '" . self::$player->fraction . "' ORDER BY id DESC LIMIT 0,1");
            if ($sovet3["enemy"] == "npc") {
                $npcAvatars = array("3" => "girl107", "4" => "man110", "5" => "man109");
                $this->content["npc_type"] = $sovet3["enemy_npc"];
                $this->content["npc_avatar"] = $npcAvatars[$this->content["npc_type"]];
                $this->content["npc_duels"] = Page::$data["sovet"]["npcduels"];
                $this->content["npc_wins"] = $sovet3["points1"];
                //$this->content["npcpercent"] = round($this->content["npc_wins"] / $this->content["npc_duels"] * 100);
            } else {
                $this->content["npc_type"] = 0;
            }
            $this->content["sovetdaytimer"] = strtotime(date("Y-m-d 23:59:59", time())) - time() + 1;
            $this->content["sovetdaytimer2"] = date("H:i:s", $this->content["sovetdaytimer"]);
            
            $this->content["sovetmetroname"] = Page::getData("alley_" . self::$player->fraction . "_nextmetro", 
                "SELECT name FROM metro WHERE id = (SELECT metro FROM sovet3 WHERE fraction = '" . self::$player->fraction . "' ORDER BY id DESC LIMIT 0,1)", 
                "value", 3600);

            // прогресс дневного бонуса
            $cur = 0;
            if (self::$player2->sovetprizetaken & 1) { $cur++; $this->content["sovetpoints2star1"] = 1; }
            if (self::$player2->sovetprizetaken & 2) { $cur++; $this->content["sovetpoints2star2"] = 1; }
            if (self::$player2->sovetprizetaken & 4) { $cur++; $this->content["sovetpoints2star3"] = 1; }
            if ($cur < 3 && self::$player2->sovetpoints2 >= Page::$data["sovet"]["day4prize"][$cur]) {
                $this->content["sovetcantakedayprize"] = 1;
            } else {
                $this->content["sovetcantakedayprize"] = 0;
            }
            $cur = $cur > 2 ? 2 : $cur;
            $this->content["sovetpoints2next"] = Page::$data["sovet"]["day4prize"][$cur];

            $this->content["sovetpoints2"] = self::$player2->sovetpoints2;
            $this->content["sovetpoints2percent"] = self::$player2->sovetpoints2 / $this->content["sovetpoints2next"] * 100;
            if ($this->content["sovetpoints2percent"] > 100) {
                $this->content["sovetpoints2percent"] = 100;
            }
        }

        // противостояние - групповые
		$h = date('H');
		if (self::$player->level > 2 && (date("N") == 5 || (date("N") == 6) && date('H') == 0 && date('m') < 30)) {
			$this->content['metrofightblock'] = 1;
		} else {
			$this->content['metrofightblock'] = 0;
		}
        if ($this->content['metrofightblock'] == 1) { // групповые за метро - только по пятницам
			$result = $this->generateMetroFightBlock();
			$this->content = array_merge($this->content, $result);
        }
        $this->content["day"] = date("N", time());

		$needFields = array(
			//'health', 'health_bonus', 'health_percent', 'health_finish',
			//'strength', 'strength_bonus', 'strength_percent', 'strength_finish',
			//'dexterity', 'dexterity_bonus', 'dexterity_percent', 'dexterity_finish',
			//'intuition', 'intuition_bonus', 'intuition_percent', 'intuition_finish',
			//'resistance', 'resistance_bonus', 'resistance_percent', 'resistance_finish',
			//'attention', 'attention_bonus', 'attention_percent', 'attention_finish',
			//'charism', 'charism_bonus', 'charism_percent', 'charism_finish',
			'id', 'level', 'lastfighttime', 'lastfight', 'playboy', 'state', 'accesslevel', 'fraction'
		);
		if (true || Page::$player->id == 1) {
			if (is_array($needFields) && count($needFields)) {
				foreach ($this->content['player'] as $key => $tmp) {
					if (!in_array($key, $needFields)) {
						$removed[$key] = $tmp;
						unset($this->content['player'][$key]);
					}
				}
				//if ($this->url[0] == 'q' || $this->url[1] == 'q') {
				//	echo 'removed: ' . strlen(json_encode($removed)) . '; content: ' . strlen(json_encode($this->content['player']));
				//	var_dump($removed);
				//}
			}
		}

		// районы для патруля
		$this->content['counter'] = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		//$this->content['counter'] = array();
		$sql = "SELECT id, name, fraction, private, " . self::$player->fraction{0} . "bonus bonus, info FROM metro ORDER BY /*IF(fraction = '" . Page::$player->fraction . "', 1, 0) DESC,*/ id ASC";
        $this->content['metro'] = self::$sql->getRecordSet($sql);
		foreach ($this->content['metro'] as &$metro) {
			//$this->content['counter'][] = $metro['id'];
			if ($metro['bonus'] != '') {
				$tmp = array();
				$metro['bonus'] = json_decode($metro['bonus'], true);
				foreach ($metro['bonus'] as $bonus) {
					$tmp[] = Page::$data['metro']['bonuses'][$bonus['code']]['title'];
				}
				$metro['bonus'] = implode(', ', $tmp);
			}
		}

		if (Runtime::get('lastmetro')) {
			$this->content['startmetro'] = Runtime::get('lastmetro');
		} else {
			$this->content['startmetro'] = Page::getData("alley_" . self::$player->fraction . "_startmetro",
				"SELECT id FROM metro WHERE fraction = '" . self::$player->fraction . "' AND private = 1", "value", 3600);
		}


		//$this->content['startmetro'] = array_search($start, $this->content['counter']) + 1;
		
		if (Page::$player->level >= 10) {
			$this->content['neft_procent'] = round((Page::$player->data['nft_d'] - mktime(0, 0, 0)) / 150 * 100);
		}

		$this->page->addPart('content', 'alley/alley.xsl', $this->content);
	}

	/**
	 * Экран перед боем (подтверждение нападения)
	 *
	 * @param object $enemy
	 */
	public function showAttackPage($enemy, $werewolf = 0) {
		$this->default = false;
		$this->forceForward();
		if ($werewolf == 1) {
			//$this->content['player'] = Page::$player->exportForFight(true);
			Page::$player2->werewolf_data = json_decode(Page::$player2->werewolf_data, true);
			foreach (Page::$player2->werewolf_data['stats'] as $key => $value) {
				if (substr($key, 0, 6) == 'rating') {
					$player[$key] = $value;
				} else {
					$player[$key] = $value;
					$player[$key . '_finish'] = $value;
				}
			}
			$player['fraction'] = 'werewolf';
			$player['level'] = Page::$player2->werewolf_data['level'];
			$player['avatar'] = 'npc2.png';
			$player['background'] = 'avatar-back-4';
			$player['nickname'] = 'Оборотень в погонах';
			$player['sex'] = 'male';
			$player['hp'] = $player['maxhp'] = $player['health_finish'] * 10 + $player['resistance_finish'] * 4;
			$this->content['player'] = $player;
		} else {
			$this->content['player'] = self::$player->toArray();
			if (self::$player->clan > 0 && self::$player->clan_status != 'recruit') {
				Std::loadMetaObjectClass('clan');
				$clan = new clanObject;
				$clan->load(self::$player->clan);
				$this->content['player']['clan'] = $clan->exportForDB();
				$this->content['player']['clan_status'] = $this->player->clan_status;
			}
			$this->content['player']['slogan'] = self::$player2->slogan;
		}
		$this->content['player']['avatar_without_ext'] = str_replace('.png', '', $this->content['player']['avatar']);

		$this->content['enemy'] = $enemy->toArray();
		if ($enemy->clan > 0 && $enemy->clan_status != 'recruit') {
			Std::loadMetaObjectClass('clan');
			$clan = new clanObject;
			$clan->load($enemy->clan);
			$this->content['enemy']['clan'] = $clan->exportForDB();
			$this->content['enemy']['clan_status'] = $this->player->clan_status;
		}
		$this->content['enemy']['avatar_without_ext'] = str_replace('.png', '', $enemy->avatar);
		$this->content['player']['maxstat'] = max($this->content['player']['health_finish'], $this->content['player']['dexterity_finish'], $this->content['player']['strength_finish'], $this->content['player']['intuition_finish'], $this->content['player']['charism_finish'], $this->content['player']['resistance_finish'], $this->content['player']['attention_finish']);
		$this->content['enemy']['maxstat'] = max($this->content['enemy']['health_finish'], $this->content['enemy']['dexterity_finish'], $this->content['enemy']['strength_finish'], $this->content['enemy']['intuition_finish'], $this->content['enemy']['charism_finish'], $this->content['enemy']['resistance_finish'], $this->content['enemy']['attention_finish']);
		foreach (Page::$data['stats'] as $stat => $tmp) {
			$this->content['player']['procent' . $stat] = floor($this->content['player'][$stat . '_finish'] / $this->content['player']['maxstat'] * 100);
			$this->content['enemy']['procent' . $stat] = floor($this->content['enemy'][$stat . '_finish'] / $this->content['enemy']['maxstat'] * 100);
		}
		// слоганы
		//$about = json_decode(self::$player->about, true);
		//$about = json_decode($enemy->about, true);
		$player2 = new player2Object();
		$player2->load($enemy->id);
		$this->content['enemy']['slogan'] = $player2->slogan;
		$this->content['window-name'] = AlleyLang::$windowTitleAttackPage;
		$this->content['werewolf'] = $werewolf;

        if ($enemy->npc == 1) {
            $this->content["npc"] = 1;
        }

		$this->page->addPart('content', 'player/attack.xsl', $this->content);
	}

	/**
	 * Нападение на бота
	 *
	 * @param int $npcType
	 */
	private function attackNpc($npcType) {
		if (self::$player2->travma) {
			Page::addAlert(AlleyLang::ERROR, AlleyLang::$errorCanNotFightWithInjury, ALERT_ERROR);
			Std::redirect('/metro/');
		}
		if ($npcType == NPC_RAT) {
			if (self::$player->loadHP() < self::$player->maxhp * 0.35) {
				Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_LOWHP_TO_ATTACK, ALERT_ERROR);
				Std::redirect('/metro/');
			} else if ($npcType == NPC_RAT && self::$player2->metrorat != 1) {
				Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_NPC_RAT_ESCAPED, ALERT_ERROR);
				Std::redirect('/metro/');
			}

			Std::loadModule('Npc');

			$npc = NpcGenerator::get($npcType, self::$player);
			if (!$npc) {
				Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_NPC_CANNOT_ATTACK, ALERT_ERROR);
				Std::redirect('/alley/');
			} elseif (self::$player->lastfight > time()) {
				Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_TOO_FREQUENT_FIGHTS, ALERT_ERROR);
				Std::redirect('/alley/');
			} elseif ($npc->type == NPC_RAT && self::$player2->metrorat != 1) {
				Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_NPC_RAT_SEARCH_FIRST, ALERT_ERROR);
				Std::redirect('/metro/');
			}

			Std::loadMetaObjectClass('duel');

			Runtime::set('attacks', 0);

			//Std::loadMetaObjectClass('player2');
			//$player2 = new player2Object();
			//$player2->load($this->player['id']);
			Page::$player2->metrorat = 0;
			//$player2->save($player2->id, array(player2Object::$METRORAT));
			//Page::checkEvent($player2->player, 'rat_attacked');
			$sql = "UPDATE player2 SET metrorat = 0 WHERE player = " . Page::$player->id . " LIMIT 1";
			Page::$sql->query($sql);
			
			self::$player->loadInventory();
			self::$player->loadPet();

			$duel = new duelObject();
			$duel->fight(self::$player, $npc, true);

			$npc->onDuelEnd();

			Runtime::set('interactive', 1);

			$this->processTravma();

			Runtime::set("showfight_backlink", array("url" => "/metro/", "name" => MetroLang::WINDOW_TITLE));
			Std::redirect('/alley/fight/' . $duel->id . '/' . Page::generateKeyForDuel($duel->id) . '/');
		} else {
			Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_NPC_RAT_ESCAPED, ALERT_ERROR);
			Std::redirect("/metro/");
		}
	}

	/**
     * Нападение на бота
     *
     * @param int $npcType
     */
    private function attackNpc2()
    {
        if (!self::$player->isFree()) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/alley/');
        }

        if (date("N", time()) != 4 || self::$sql->getValue("SELECT enemy FROM sovet WHERE fraction='" . self::$player->fraction . "' ORDER BY id DESC LIMIT 0,1")) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/alley/');
        }

        if (self::$player2->travma) {
            Page::addAlert(AlleyLang::$error, AlleyLang::$errorCanNotFightWithInjury, ALERT_ERROR);
            Std::redirect('/alley/');
        }

        if (self::$player->loadHP() < self::$player->maxhp * 0.35) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_LOWHP_TO_ATTACK, ALERT_ERROR);
            Std::redirect('/alley/');
        }

        Std::loadModule('Npc');

        $npcArray = Runtime::get("generated_npc");

        if (!$npcArray || $npcArray == "" || !is_array($npcArray)) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/alley/');
        } elseif (self::$player->lastfight > time()) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_TOO_FREQUENT_FIGHTS, ALERT_ERROR);
            Std::redirect('/alley/');
        }

        Page::$player->npc_wins = Page::$player2->npc_stat % 1000;
		Page::$player->npc_loses = floor(Page::$player2->npc_stat / 1000);
		$npc = NpcGenerator::get($npcArray["tp"], self::$player);
        $npc->import($npcArray);

        Std::loadMetaObjectClass('duel');

        Runtime::set('attacks', 0);

        self::$player->loadInventory();
        self::$player->loadPet();

        $duel = new duelObject();
        $duel->fight(self::$player, $npc, true);

		if (is_a($duel->winner, 'Npc')) {
			$npc->onDuelEnd(true);
		} else if ($duel->winner == 0) {
			$npc->onDuelEnd(-1);
		} else {
			$npc->onDuelEnd(false);
		}
        

        Runtime::set('interactive', 1);

        $this->processTravma();

		Runtime::set("generated_npc", "");

        Std::redirect('/alley/fight/' . $duel->id . '/' . Page::generateKeyForDuel($duel->id) . '/');
	}

    /**
     * Нападение на нефтяного взяточника
     *
     * @param int $npcType
     */
    private function attackNpc3()
    {
        if (!self::$player->isFree()) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/neft/');
        }

        if (self::$player2->travma) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::$errorCanNotFightWithInjury, ALERT_ERROR);
            Std::redirect('/neft/');
        }

		if (self::$player->level < 10) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/neft/');
        }

        if (self::$player->loadHP() < self::$player->maxhp * 0.35) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_LOWHP_TO_ATTACK, ALERT_ERROR);
            Std::redirect('/neft/');
        }

        if ($_POST["now"] == 1) {
            $priceHoney = Page::$data["neft"]["nowprice"];

            $reason	= 'neft now $' . $priceHoney;
            $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);

            if ($takeResult[0] == 'OK') {
                self::$player->honey -= $priceHoney;
                self::$player->save(self::$player->id, array(playerObject::$HONEY));

                Page::sendLog(self::$player->id, 'nftnow', array('h' => $priceHoney, 'mbckp' => self::$player->getMbckp()), 1);
            } else {
                Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
                Std::redirect('/neft/');
            }
        } elseif (self::$player->lastfight > time()) {
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_TOO_FREQUENT_FIGHTS, ALERT_ERROR);
            Std::redirect('/neft/');
        }

        $lastVentelTime = (int)self::$player->data["nft_t"];
        if (!isset(self::$player->data["nft_n"]) || $lastVentelTime == 0) { // каким-то образом тут очутился
            self::$player->data["nft_n"] = 1;
            self::$player->saveData();
        } elseif (self::$player->data["nft_n"] > 1 && date("d", $lastVentelTime) != date("d", time())) { // сегодня еще не дрался
            self::$player->data["nft_n"] = 1;
            self::$player->saveData();
            Page::addAlert(AlleyLang::ERROR, AlleyLang::ERROR_NEFTTIMEOUT, ALERT_ERROR);
            Std::redirect("/neft/");
        }
        
        self::$player->npc_loses = 10 + self::$player->data["nft_n"] * 3;
        self::$player->npc_wins = 0;

        Std::loadModule('Npc');
        $npc = NpcGenerator::get(NPC_GRAFTER, self::$player);
        $npc->level = self::$player->data["nft_n"];
        $npc->specialProfit = array(
            "money" => Page::$data["neft"]["npc"][self::$player->data["nft_n"]]["m"],
            "ore" => Page::$data["neft"]["npc"][self::$player->data["nft_n"]]["o"],
            "oil" => Page::$data["neft"]["npc"][self::$player->data["nft_n"]]["n"],
        );
        $npc->neftDuel = true;

		if (self::$player->data["nft_n"] == 16) {
			$npc->avatar = 'man110.png';
			$npc->nickname = NeftLang::MISHA2;
		}

        Std::loadMetaObjectClass('duel');

        Runtime::set('attacks', 0);

        self::$player->loadInventory();
        self::$player->loadPet();

        $duel = new duelObject();
        $duel->fight(self::$player, $npc, true);

		if (is_a($duel->winner, 'Npc')) { // взяточник отстоял свой вентиль
			//$npc->onDuelEnd(true);
		} elseif ($duel->winner == 0) { // ничья (взяточник остался на вентиле)
			//$npc->onDuelEnd(-1);
		} else { // взяточник сброшен с вентиля
        self::$player->data["nft_n"]++;

        if (self::$player->data["nft_n"] == 17) {
            Page::giveCollectionElement(self::$player->id, Page::getData("snowy_neft_collection",
                "SELECT * FROM collection WHERE id = " . Page::$data["neft"]["collections"][mt_rand(0, sizeof(Page::$data["neft"]["collections"]) - 1)], "record", 3600));
        }

        //if (self::$player->data["nft_n"] > 2 && date("d", $lastVentelTime) != date("d", time())) {
        //    self::$player->data["nft_n"] = 1;
        //}

        self::$player->data["nft_t"] = time();
        self::$player->saveData();
			//$npc->onDuelEnd(false);
		}

        Runtime::set('interactive', 1);

        $this->processTravma();

		Runtime::set("showfight_backlink", array("url" => "/neft/", "name" => NeftLang::WINDOW_NAME));
        Std::redirect('/alley/fight/' . $duel->id . '/' . Page::generateKeyForDuel($duel->id) . '/');
	}

    /**
     * Выдача дневныз бонусов в противостоянии за дуэли и групповые
     */
    private function sovetTakeDayPrize() {
        if (date("N", time()) == 4) {
            $cur = 0;
            if (!(self::$player2->sovetprizetaken & 1) && self::$player2->sovetpoints2 >= Page::$data["sovet"]["day4prize"][0]) {
                // выдать дневной бонус 1 за дуэли
				if (Page::$player->level >= 5) {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['>=5']['duels'][1], AlleyLang::ALERT_SOVET_REWARD);
				} else {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['<5']['duels'][1], AlleyLang::ALERT_SOVET_REWARD);
				}
                $bit = "000001";
                // прогресс недельного бонуса
                self::$sql->query("UPDATE player2 SET sovetpoints1 = sovetpoints1 | b'01000' WHERE id = " . self::$player2->id);
            } elseif (!(self::$player2->sovetprizetaken & 2) && self::$player2->sovetpoints2 >= Page::$data["sovet"]["day4prize"][1]) {
                // выдать дневной бонус 2 за дуэли
				if (Page::$player->level >= 5) {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['>=5']['duels'][2], AlleyLang::ALERT_SOVET_REWARD);
				} else {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['<5']['duels'][2], AlleyLang::ALERT_SOVET_REWARD);
				}
                $bit = "000010";
            } elseif (!(self::$player2->sovetprizetaken & 4) && self::$player2->sovetpoints2 >= Page::$data["sovet"]["day4prize"][2]) {
                // выдать дневной бонус 3 за дуэли
				if (Page::$player->level >= 5) {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['>=5']['duels'][3], AlleyLang::ALERT_SOVET_REWARD);
				} else {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['<5']['duels'][3], AlleyLang::ALERT_SOVET_REWARD);
				}
                $bit = "000100";
            }
            self::$sql->query("UPDATE player2 SET sovetprizetaken = sovetprizetaken | b'" . $bit . "' WHERE id = " . self::$player2->id);
        }
        if (date("N") == 5 || (date("N") == 6) && date('H') == 0 && date('m') < 30) {
            $cur = 0;
            if (!(self::$player2->sovetprizetaken & 8) && self::$player2->sovetpoints3 >= Page::$data["sovet"]["day5prize"][0]) {
                // выдать дневной бонус 1 за стенки
				if (Page::$player->level >= 5) {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['>=5']['fights'][1], AlleyLang::ALERT_SOVET_REWARD);
				} else {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['<5']['fights'][1], AlleyLang::ALERT_SOVET_REWARD);
				}
                $bit = "001000";
                // прогресс недельного бонуса
                self::$sql->query("UPDATE player2 SET sovetpoints1 = sovetpoints1 | b'10000' WHERE id = " . self::$player2->id);
            } elseif (!(self::$player2->sovetprizetaken & 16) && self::$player2->sovetpoints3 >= Page::$data["sovet"]["day5prize"][1]) {
                // выдать дневной бонус 2 за стенки
				if (Page::$player->level >= 5) {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['>=5']['fights'][2], AlleyLang::ALERT_SOVET_REWARD);
				} else {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['<5']['fights'][2], AlleyLang::ALERT_SOVET_REWARD);
				}
                $bit = "010000";
            } elseif (!(self::$player2->sovetprizetaken & 32) && self::$player2->sovetpoints3 >= Page::$data["sovet"]["day5prize"][2]) {
                // выдать дневной бонус 3 за стенки
				if (Page::$player->level >= 5) {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['>=5']['fights'][3], AlleyLang::ALERT_SOVET_REWARD);
				} else {
					Page::fullActions(Page::$player, Page::$data['metro']['reward']['<5']['fights'][3], AlleyLang::ALERT_SOVET_REWARD);
				}
                $bit = "100000";
            }
            self::$sql->query("UPDATE player2 SET sovetprizetaken = sovetprizetaken | b'" . $bit . "' WHERE id = " . self::$player2->id);
        }
        Std::redirect("/alley/");
    }

	public function generateMetroFightBlock() {
		// коренные нападают в 20 минут, понаехавшие - в 40
		$return = array();

		$return["sovetdaytimer"] = strtotime(date("Y-m-d 23:59:59", time())) - time() + 1;
		$return["sovetdaytimer2"] = date("H:i:s", $return["sovetdaytimer"]);

		// прогресс дневного бонуса
		$cur = 0;
		if (self::$player2->sovetprizetaken & 8) {
			$cur++;
			$return["sovetpoints3star1"] = 1;
		}
		if (self::$player2->sovetprizetaken & 16) {
			$cur++;
			$return["sovetpoints3star2"] = 1;
		}
		if (self::$player2->sovetprizetaken & 32) {
			$cur++;
			$return["sovetpoints3star3"] = 1;
		}
		if ($cur < 3 && self::$player2->sovetpoints3 >= Page::$data["sovet"]["day5prize"][$cur]) {
			$return["sovetcantakedayprize"] = 1;
		} else {
			$return["sovetcantakedayprize"] = 0;
		}
		$cur = $cur > 2 ? 2 : $cur;
		$return["sovetpoints3next"] = Page::$data["sovet"]["day5prize"][$cur];

		$return["sovetpoints3"] = self::$player2->sovetpoints3;
		$return["sovetpoints3percent"] = self::$player2->sovetpoints3 / $return["sovetpoints3next"] * 100;
		if ($return["sovetpoints3percent"] > 100) {
			$return["sovetpoints3percent"] = 100;
		}

		if (date('N') == 6) {
			$return['metrofight'] = 2;
			return $return;
		}
		if (date('H') < 9) { // групповые за метро - только с 9 утра
			$return['metrofight'] = 1;
			return $return;
		}

		//$return["allowmetro"] = self::$sql->getValue("SELECT count(*) FROM fightplayer fp JOIN fight f ON f.id = fp.fight
        //        WHERE f.dt > date_sub(now(), INTERVAL 1 DAY) AND f.type = 'chaotic' AND f.state = 'finished' AND fp.player=" . self::$player->id) < 10 ? 1 : 0;
		$return["allowmetro"] = 1;

		$query = "SELECT fraction, enemy, enemy_npc FROM sovet3 WHERE week = " . date('W') . ' AND year = ' . date('Y');
		$tmp = Page::$sql->getRecordSet($query);
		if (!$tmp) {
			return $return;
		}
		foreach ($tmp as $c) {
			$sovets[$c['fraction']] = $c;
			$fights[$c['fraction'][0]] = array(
				'id' => 0,
				'left' => array(),
				'right' => array(),
				'me' => 0,
				'start_dt' => strtotime($c['start_dt']),
				'attacker' => $c['fraction'],
				'attacker_name' => '',
				'enemy' => $c["enemy"],
				'enemy_name' => '',
				'enemy_npc' => $c['enemy_npc'],
				'pos' => ($c['fraction'] == 'resident' ? 0 : 1)
			);
			if ($c['fraction'] == 'arrived') {
				$fights[$c['fraction'][0]]['attacker_name'] = Lang::$captionArrived;
			} else {
				$fights[$c['fraction'][0]]['attacker_name'] = Lang::$captionResident;
			}
			if ($c['enemy'] == 'arrived') {
				$fights[$c['fraction'][0]]['enemy_name'] = Lang::$captionArrived;
			} else if ($c['enemy'] == 'resident') {
				$fights[$c['fraction'][0]]['enemy_name'] = Lang::$captionResident;
			} else if ($c['enemy'] == 'npc') {
				$fights[$c['fraction'][0]]['enemy_name'] = Lang::$npc[$c['enemy_npc']];
			}

			if ($c['fraction'] == 'resident') {
				if (date('H') <= 22 || (date('H') == 23 && date('i') <= 20)) {
					$fights[$c['fraction'][0]]['nearestminute'] = 20;
					$fights[$c['fraction'][0]]['nearesthour'] = date('H') + (date('i') > 20 ? 1 : 0);
				}
			} else {
				if (date('H') <= 22 || (date('H') == 23 && date('i') <= 40)) {
					$fights[$c['fraction'][0]]['nearestminute'] = 40;
					$fights[$c['fraction'][0]]['nearesthour'] = date('H') + (date('i') > 40 ? 1 : 0);
				}
			}
		}
		$return['metrofights'] = $fights;

		$curMaxLevel = CacheManager::get('value_maxlevel');
		$curLevelFightMaxLevel = CacheManager::get('value_levelfightmaxlevel');

		$level = min(self::$player->level, $curLevelFightMaxLevel);
		$query = "SELECT id, data, dt, state, ac, dc, start_dt FROM fight WHERE type = 'metro' AND (state = 'created' OR state = 'started') AND level = " . $level;
		$tmp = Page::$sql->getRecordSet($query);
		if (!$tmp) {
			if (count($fights) == 0) {
				$result['metrofight'] = 2;
			}
			$fights = array_values($fights);
			Std::sortRecordSetByField($fights, 'pos', 1);
			$return['metrofights'] = $fights;
			return $return;
		}
		foreach ($tmp as $c) {
			$data = json_decode($c['data'], true);
			if ($data['a']['f'] != self::$player->fraction{0} && $data["d"]["f"] != self::$player->fraction{0}) { // если наша сторона НЕ участвует в этом бою
				continue;
			}
			$metroFight = array(
				'id' => (int)$c['id'],
				'left' => array(),
				'right' => array(),
				'me' => 0,
				'state' => $c['state'],
				'start_dt' => strtotime($c['start_dt'])
			);
			$metroFight['nearesthour'] = date('H', $metroFight['start_dt']);
			$metroFight['nearestminute'] = date('i', $metroFight['start_dt']);
			if ($c["enemy"] == "npc") {
				$metroFight["npc_type"] = $c["enemy_npc"];
			}

			$players = array();
			$playersId = array();
			Fight::getPlayersInFight($c['id'], $players, $playersId);

			$leftSide = $data['a']['f'] == self::$player->fraction{0} ? 'a' : 'd';
			$rightSide = $leftSide == 'a' ? 'd' : 'a';
			$metroFight['left'] = array(
				'name' => self::$player->fraction == 'resident' ? Lang::$captionResident : Lang::$captionArrived,
				'count' => $c[$leftSide . 'c'],
				'max' => $data[$leftSide]['m'],
				'code' => self::$player->fraction,
				'players' => array(),
			);
			if ($c["enemy"] != "npc") {
				$metroFight['right'] = array(
					'name' => self::$player->fraction == 'resident' ? Lang::$captionArrived : Lang::$captionResident,
					'count' => $c[$rightSide . 'c'],
					'max' => $data[$rightSide]['m'],
					'code' => self::$player->fraction == 'resident' ? 'arrived' : 'resident',
					'players' => array(),
				);
			}

			if ($players) {
				foreach ($players as $playerId => $player) {
					$metroFight[($player['sd'] == $leftSide ? 'left' : 'right')]['players'][] = $player;
					if ($playerId == self::$player->id) {
						$metroFight['me'] = 1;
					}
				}
			}
			$fights[$data['a']['f']] = array_merge((array) $fights[$data['a']['f']], $metroFight);
		}
		$fights = array_values($fights);
		Std::sortRecordSetByField($fights, 'pos', 1);
		$return['metrofights'] = $fights;
		
		/*
			$m = (int) date("i", time());
			if ($m < 20 || $m >= 40) {
				if ($m >= 40) {
					$h++;
				}
				if (self::$player->fraction == "resident" || (self::$player->fraction == "arrived" && self::$sql->getValue("SELECT enemy FROM sovet3 WHERE fraction = 'arrived' ORDER BY id DESC LIMIT 0,1") == "resident")) {
					$m = 20;
				} else {
					$m = 40;
				}
			} elseif ($m < 40) {
				if (self::$player->fraction == "arrived" || (self::$player->fraction == "resident" && self::$sql->getValue("SELECT enemy FROM sovet3 WHERE fraction = 'resident' ORDER BY id DESC LIMIT 0,1") == "arrived")) {
					$m = 40;
				} else {
					$m = 20;
					$h++;
				}
			}
*/
			/*
			  $m = (int)date("i", time());
			  if ($m < 20) { // если менее 20 минут, то следующий групповой - в 20 минут
			  $m = 20;
			  } else {
			  if ($m < 40) { // если менее 40 минут, то следующий групповой - в 40 минут
			  $m = 40;
			  } else { // если более 40 минут, то следующий групповой - в 20 минут следующего часа
			  $m = 20;
			  $h++;
			  }
			  }
			 */
/*
			if ($h > 23) { // если следующий час = 24 - говорим, что бои завершены
				$this->content['metrofight'] = 2;
			} else {
				//$enemy = self::$sql->getValue("SELECT value FROM value WHERE name = 'sovet_" . ($m == 20 ? "resident" : "arrived") . "_enemy'");
				//$enemy = $enemy == "npc" ? "npc" : ($m == 20 ? "a" : "r");

				$sovet3 = self::$sql->getRecord("SELECT enemy, enemy_npc FROM sovet3 WHERE fraction = '" . ($m == 20 ? "resident" : "arrived") . "' ORDER BY id DESC LIMIT 0,1");

				$metroFight = array(
					'id' => 0,
					'left' => array(),
					'right' => array(),
					'me' => 0,
					'state' => '',
					'nearesthour' => $h,
					'nearestminute' => $m,
					'enemy' => $sovet3["enemy"],
				);
				if ($sovet3["enemy"] == "npc") {
					$metroFight["npc_type"] = $sovet3["enemy_npc"];
				}

				$curMaxLevel = CacheManager::get('value_maxlevel');
				$curLevelFightMaxLevel = CacheManager::get('value_levelfightmaxlevel');

				$checkStarted = false;
				if ($m == 40 && self::$player->fraction == "arrived") {
					$state = "state = 'created'";
					$checkStarted = true;
				} else {
					$state = "(state = 'created' OR state = 'started')";
				}
//if (self::$player->level == $curMaxLevel && $curMaxLevel > $curLevelFightMaxLevel) {
				if (self::$player->level > $curLevelFightMaxLevel) {
					$metFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'metro' AND (state = 'created' OR state = 'started') AND level=" . $curLevelFightMaxLevel);
				} else {
					$metFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'metro' AND (state = 'created' OR state = 'started') AND level=" . self::$player->level);
				}

				if (!$metFight && $checkStarted) {
//if (self::$player->level == $curMaxLevel && $curMaxLevel > $curLevelFightMaxLevel) {
					if (self::$player->level > $curLevelFightMaxLevel) {
						$metFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'metro' AND (state = 'created' OR state = 'started') AND level=" . $curLevelFightMaxLevel);
					} else {
						$metFight = self::$sql->getRecord("SELECT id, data, dt, state, ac, dc FROM fight WHERE type = 'metro' AND (state = 'created' OR state = 'started') AND level=" . self::$player->level);
					}
				}

				if ($metFight) {
					$data = json_decode($metFight['data'], true);

					if ($data["a"]["f"] == self::$player->fraction{0} || $data["d"]["f"] == self::$player->fraction{0}) { // если наша сторона учствует в этом бою
						$metroFight['id'] = $metFight['id'];
						$metroFight['state'] = $metFight['state'];

						$players = array();
						$playersId = array();
						Fight::getPlayersInFight($metFight['id'], $players, $playersId);

						$leftSide = $data['a']['f'] == self::$player->fraction{0} ? 'a' : 'd';
						$rightSide = $leftSide == 'a' ? 'd' : 'a';
						$metroFight['left'] = array(
							'name' => self::$player->fraction == 'resident' ? Lang::$captionResident : Lang::$captionArrived,
							'count' => $metFight[$leftSide . 'c'],
							'max' => $data[$leftSide]['m'],
							'code' => self::$player->fraction,
							'players' => array(),
						);
						if ($sovet3["enemy"] != "npc") {
							$metroFight['right'] = array(
								'name' => self::$player->fraction == 'resident' ? Lang::$captionArrived : Lang::$captionResident,
								'count' => $metFight[$rightSide . 'c'],
								'max' => $data[$rightSide]['m'],
								'code' => self::$player->fraction == 'resident' ? 'arrived' : 'resident',
								'players' => array(),
							);
						}

						if ($players) {
							foreach ($players as $playerId => $player) {
								$metroFight[($player['sd'] == $leftSide ? 'left' : 'right')]['players'][] = $player;
								if ($playerId == self::$player->id) {
									$metroFight['me'] = 1;
								}
							}
						}
					}
				}
			}
			if (!isset($this->content['metrofight'])) {
				$this->content['metrofight'] = $metroFight;
			}
*/
		return $return;
	}
}

?>
