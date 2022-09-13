<?php
class Metro extends Page implements IModule
{
    public $moduleCode = 'Metro';

    private $ratSearchTime = 600;
    private $ratSearchChance = 35; //35%

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		$this->needAuth();
        //
        switch ($this->url[0]) {
            case 'myorechance':
                if (self::$player->timer - time() < 30) {
                    echo self::$player2->metroorechance;
                }
                exit;
                break;

            case 'myrat':
                $this->callForTheRat();
                break;

            //case "myratlevel":
            //    self::getRatLevel();
            //    break;

            case 'search-rat':
                $this->searchRat();
                break;

            case "naperstki":
                $this->playWithMonya();
                break;
        }

        if (self::$player->level >= 5 && @$_POST['action'] == 'work') {
			if (self::$player->isFree() || self::$player->state == 'metro_done' || (self::$player->timer - time() < 0 && self::$player->state == 'metro')) {
				$result = self::work();
			} else {
				Page::addAlert(MetroLang::ERROR, MetroLang::ERROR_CANNOT_WORK_BUSY, ALERT_ERROR);
			}
			Std::redirect('/metro/');
		} elseif (self::$player->level >= 5 && @$_POST['action'] == 'leave') {
			$result = self::leave();
			Runtime::set('content/result', $result);
			Std::redirect('/metro/');
		} elseif (self::$player->level >= 5 && @$_POST['action'] == 'dig' && (self::$player->state == 'metro_done' || (self::$player->timer - time() < 0 && self::$player->state == 'metro'))) {
			$result = self::dig();
			if (is_array($result)) {
				foreach ($result as $key => $value) {
					$this->content[$key] = $value;
				}
			}
		}/* else if (self::$player->level >= 2 && $this->url[0] == 'naperstki' && self::$player->isFree() && ($this->url[1] == 3 OR $this->url[1] == 9)) {
			$this->naperstki();
		}*/

		$this->showMetro();
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Вылезти из метро
     *
     * @return array
     */
	public static function leave()
    {
		$result = array('type' => 'metro', 'action' => 'leave', 'params' => array('url' => '/metro/'));
		if (self::$player->state != 'metro' && self::$player->state != 'metro_done' && self::$player->state != 'metro_rat_search') {
			$result['result'] = 0;
			$result['error'] = 'you are not in metro';
			return $result;
		}
		self::$sql->query("DELETE FROM playerwork WHERE player = " . self::$player->id . " AND type='metro'");
		self::$player->state = '';
		self::$player->timer = 1;
		self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$TIMER));

        self::$player2->metroorechance = 0;
        self::$player2->metrorat = -1;
        self::$player2->save(self::$player2->id, array(player2Object::$METROORECHANCE, player2Object::$METRORAT));

		$result['result'] = 1;
		return $result;
	}

	public static function getExtendedItems() {
		$result = array();
		$result['pick'] = Page::$player->getItemForUseByType('pick', array('special1'));
		$result['helmet'] = Page::$player->getItemForUseByType('metro', array('special1'));
		if ($result['helmet']['code'] == 'metro_counter') {
			$result['counter'] = $result['helmet'];
			$result['helmet'] = false;
		} else if (!$result['helmet']) {
			$result['counter'] = false;
		} else {
			$result['counter'] = Page::$player->getItemForUseByCode('metro_counter', array('special1'));
		}
		return $result;
	}

    /**
     * Спуститься в тоннель метро
     *
     * @return array
     */
	public static function work() {
        if (self::$player->state == 'metro_rat_search') {
            Page::addAlert(MetroLang::ERROR, MetroLang::ERROR_CANNOT_DIG_SEARCHING, ALERT_ERROR);
            Std::redirect('/metro/');
        }
        if (self::$player->state == 'metro') {// || self::$player->state == 'metro_done') {
            self::$sql->query("DELETE FROM playerwork WHERE player = " . self::$player->id . " AND type='metro'");
        }


		$time = 20 * 60;

		/* OLD:
		$pick = self::$player->loadItemByCode('pick');
		if ($pick !== false) {
			$time = 10 * 60;
            $pick->useItem();
		}
		*/
		$items = Metro::getExtendedItems();
		if ($items['pick']) {
			$time = $time * (100 - $items['pick']['special1']) / 100;
			Page::$player->useItemFast($items['pick']);
		}
		
        if (DEV_SERVER) {
            $time /= 10;
        }

		$endTime = time() + $time;
		$endTime -= time() + date("s", $endTime);

		//$glasses = self::$player->loadItemByCode('metro_helmet');
		//$flashlight = self::$player->loadItemByCode('metro_counter');

        self::$player2->metroorechance = 1;
		/* OLD:
		if ($glasses !== false) {
			self::$player2->metroorechance += (int)$glasses->special1;
			$glasses->useItem();
		}
		if ($flashlight !== false) {
			self::$player2->metroorechance += (int)$flashlight->special1;
			$flashlight->useItem();
		}
		*/
		if ($items['helmet']) {
			self::$player2->metroorechance += $items['helmet']['special1'];
			Page::$player->useItemFast($items['helmet']);
		}
		if ($items['counter']) {
			self::$player2->metroorechance += $items['counter']['special1'];
			Page::$player->useItemFast($items['counter']);
		}
		
		self::$player2->metroorechance += mt_rand(1, 100);
        self::$player2->metroorechance = min(100, self::$player2->metroorechance);
		self::$player2->metrorat = -1;
        self::$player2->save(self::$player2->id, array(player2Object::$METROORECHANCE, player2Object::$METRORAT));

		self::$player->state = 'metro';
		self::$player->timer = time() + $endTime;
		self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$TIMER));

        self::$player->beginWork('metro', $endTime, 0, 0);

        self::$player->updateOnlineCounters(ONLINECOUNTER_METRO);

        return true;
	}

    /**
     * Начать выслеживать Крысомах
     */
    private function searchRat()
    {
        if (!self::$player->isFree() && self::$player->state != 'metro_rat_search') {
            if (self::$player->state == 'metro' || self::$player->state == 'metro_done') {
                Page::addAlert(MetroLang::ERROR, MetroLang::ERROR_CANNOT_SEARCH_DIGGING, ALERT_ERROR);
            } else {
                Page::addAlert(MetroLang::ERROR, MetroLang::ERROR_CANNOT_SEARCH_BUSY, ALERT_ERROR);
            }
            Std::redirect('/metro/');
        }
		if (Page::$player->level < 5) {
			Std::redirect('/metro/');
		}
        //if (self::$player->state == 'metro_rat_search') {
        //    self::$sql->query("DELETE FROM playerwork WHERE player = " . self::$player->id . " AND type='metro'");
        //}

		self::$player->state = 'metro_rat_search';
		self::$player->timer = time() + (DEV_SERVER ? $this->ratSearchTime / 10 : $this->ratSearchTime);
		self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$TIMER));

        self::$player2->metroorechance = 0;
        self::$player2->metrorat = -1;
        self::$player2->save(self::$player2->id, array(player2Object::$METROORECHANCE, player2Object::$METRORAT));

        //self::$player->beginWork('metro', $endTime, 0, 0);

        Std::redirect('/metro/#rats');
    }

    /**
     * Выкапывание руды
     *
     * @return array
     */
	public static function dig()
    {
		if (self::$player2->metrorat == -1) {
            self::$player2->metrorat = self::getRatChance() >= mt_rand(1, 100) ? 1 : 0;
            if (self::$player2->metrorat == 1) {
                self::$player2->save(self::$player2->id, array(player2Object::$METRORAT));
                Std::redirect('/metro/');
            }
        }

        if (self::$player->state != 'metro_done') {
            self::$sql->query("DELETE FROM playerwork WHERE player = " . self::$player->id . " AND type='metro'");
        }

		$chance = mt_rand(1, 100);
		if ($chance <= self::$player2->metroorechance) {
			$success = 'success';
			$result = array('result' => 1, 'state' => 'success', 'action' => 'dig');
			self::$player->ore++;

			$perk = Page::getPerkByCode("perk_digger");
			if ($perk && mt_rand(1, 100) <= $perk["value"]) {
				self::$player->ore++;
				$result["perk_digger"] = 1;
			}
		} else {
			$success = 'fail';
			$result = array('result' => 0, 'state' => 'fail', 'action' => 'dig');
		}
        self::$player->state = '';
		self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$ORE));

        self::$player2->metrorat = -1;
        self::$player2->metroorechance = 0;
        self::$player2->save(self::$player2->id, array(player2Object::$METRORAT, player2Object::$METROORECHANCE));

        self::$sql->query("INSERT INTO metrolog(player, dt, result) VALUES(" . self::$player->id . ", NOW(), '" . $success . "')");

        return $result;
	}

    /**
     * Страница Метро
     */
	protected function showMetro()
    {
		$this->content['player'] = self::$player->toArray();

        // копание руды
		if (self::$player->state == 'metro' || self::$player->state == 'metro_done') {
            $timer = self::$player->timer - time();
            if ($timer <= 0) {
                if (self::$player2->metrorat == -1) {
                    self::$player2->metrorat = $this->getRatChance() >= mt_rand(1, 100) ? 1 : 0;
                    self::$player2->save(self::$player2->id, array(player2Object::$METRORAT));
                }
            }
        }
        if (self::$player->state == 'metro') {
            $digTime = self::$sql->getValue("SELECT time FROM playerwork WHERE player=" . self::$player->id . " AND type='metro'");
            $this->content['metrodigtimeleft'] = $timer > 0 ? $timer : 0;
            $this->content['metrodigtimeleft2'] = date('H:i:s', $timer);
            $this->content['metrodigtimetotal'] = $digTime;
            $this->content['metrodigpercent'] = round(($digTime - $timer) / $digTime * 100);
        }
        $this->content['metroorechance'] = self::$player2->metroorechance;

        // поиск Крысомахи
        if (self::$player->state == 'metro_rat_search') {
            $timer = self::$player->timer - time();
            if ($timer <= 0) {
                if (self::$player2->metrorat == -1) {
                    self::$player2->metrorat = $this->ratSearchChance >= mt_rand(1, 100) ? 1 : 0;
                    self::$player2->save(self::$player2->id, array(player2Object::$METRORAT));
                }
            }
            $this->content['ratsearchtimeleft'] = $timer > 0 ? $timer : 0;
            $this->content['ratsearchtimeleft2'] = date('H:i:s', $timer);
            $this->content['ratsearchtimetotal'] = DEV_SERVER ? $this->ratSearchTime/10 : $this->ratSearchTime;
            $this->content['ratsearchpercent'] = round(($this->ratSearchTime - $timer) / $this->ratSearchTime * 100);
        }

        $this->content['rat'] = self::$player2->metrorat;
        if (self::$player2->metrorat == 1) {
            $this->content['welcome_rat_display'] = 'block';
            $this->content['welcome_no_rat_display'] = 'none';

			//$mongo = Page::getMongo();
			//if ($mongo) {
			//	$battlesCount = (int) $mongo->getDb()->selectCollection("duel")->count(array("player1" => self::$player->id, "player2" => (NPC_ID + NPC_RAT), "winner" => self::$player->id, "time" => array('$gte' => time() - 86400)));
			//} else {
				$battlesCount = (int)self::$sql->getValue("SELECT count(*) FROM duel WHERE player1 = " . self::$player->id . "
					AND player2 = " . (NPC_ID + NPC_RAT) . " AND winner=" . self::$player->id . " AND time >= unix_timestamp(DATE_SUB(now(), INTERVAL 1 DAY))");
			//}
            $this->content['ratlevel'] = floor($battlesCount / 2) + 1;
        } else {
            $this->content['welcome_rat_display'] = 'none';
            $this->content['welcome_no_rat_display'] = 'block';
        }

        // игра с Моней
		$sql = "SELECT count(*) FROM " . Page::$__LOG_TABLE__ . " WHERE player = " . self::$player->id . " AND type = 'monya'";
        $games24 = Page::getData("snowy_metro_monyagames_" . date("Y-m-d", time()) . "_" . self::$player->id, $sql, "value", 3600);

        $this->content["monya_bilet"] = $games24 >= 3 ? 1 : 0;
        $this->content["monya_left"] = 3 - $games24 > 0 ? 3 - $games24 : 0;

        $this->content['window-name'] = MetroLang::WINDOW_TITLE;
		$this->page->addPart('content', 'metro/metro.xsl', $this->content);
	}

    /**
     * Призыв крысы
     */
    private function callForTheRat()
    {
        if (self::$player2->metrorat == -1) {
            if (self::$player->timer - time() < 30 && (self::$player->state == 'metro_rat_search' || self::$player->state == 'metro' || self::$player->state == 'metro_done')) {
                if (self::$player->state == 'metro_rat_search') {
					$perk = Page::getPerkByCode("perk_rathunter");
					if ($perk) {
						$this->ratSearchChance += $perk["value"];
					}
				}
				self::$player2->metrorat = (self::$player->state == 'metro_rat_search' ? $this->ratSearchChance : self::getRatChance()) >= mt_rand(1, 100) ? 1 : 0;
                self::$player2->save(self::$player2->id, array(player2Object::$METRORAT));
            }
        }
        if (self::$player2->metrorat == 0) {
            echo 0;
        } else {
			//$mongo = Page::getMongo();
			//if ($mongo) {
			//	$battlesCount = (int) $mongo->getDb()->selectCollection("duel")->count(array("player1" => self::$player->id, "player2" => (NPC_ID + NPC_RAT), "winner" => self::$player->id, "time" => array('$gte' => time() - 86400)));
			//} else {
	            $battlesCount = (int) self::$sql->getValue("SELECT count(*) FROM duel WHERE player1 = " . self::$player->id . "
		            AND player2 = " . (NPC_ID + NPC_RAT) . " AND winner=" . self::$player->id . " AND time >= unix_timestamp(DATE_SUB(now(), INTERVAL 1 DAY))");
			//}
            echo floor($battlesCount / 2) + 1;
        }
        exit;
    }

    /**
     * Шанс появления крысы
     *
     * @return bool
     */
    private static function getRatChance()
    {
		if (Page::$player->id == 1) {
			return 100;
		}
        $kopki = self::$sql->getValue("SELECT count(*) FROM metrolog WHERE player=" . self::$player->id . " AND dt>DATE_SUB(now(), INTERVAL 1 DAY)");

		if (DEV_SERVER) {
            $rnd = mt_rand(1, 5);
            $ratChance = $kopki <= 10 ? 0 : round(($kopki - 10) / $rnd * 100);
        } else {
            $rnd = mt_rand(1, 10);
            $ratChance = $kopki <= 25 ? 0 : round(($kopki - 25) / $rnd * 100);
        }
        return $ratChance;
    }

    /**
     * Ajax, уровень крысы
     */
    /*
    private static function getRatLevel()
    {
        $battlesCount = (int)self::$sql->getValue("SELECT count(*) FROM duel WHERE player1 = " . self::$player->id . "
            AND player2 = " . (NPC_ID + NPC_RAT) . " AND winner=" . self::$player->id . " AND time >= unix_timestamp(DATE_SUB(now(), INTERVAL 1 DAY))");
        echo floor($battlesCount / 2) + 1;
        exit;
    }
    */
}
?>