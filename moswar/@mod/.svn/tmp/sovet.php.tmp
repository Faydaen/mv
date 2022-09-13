<?php
class Sovet extends Page implements IModule
{
    public $moduleCode = 'Sovet';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $this->needAuth();

		if ($_POST['action'] == 'get_weekly_reward') {
			$result = $this->getWeeklyReward((int)$_POST['reward']);
		}
		if (isset($result)) {
			if (isset($_POST['return_url'])) {
				$result['return_url'] = $_POST['return_url'];
			}
			if (isset($result['return_url'])) {
				Std::redirect($result['return_url']);
			}
		}

        if (self::$player->level > 2) {
            switch ($this->url[0]) {

                // действия

                case 'check-player':
                    $this->checkPlayer();
                    break;

                case 'vote-station':
                    $this->voteMetro();
                    break;

                case 'vote-sovet':
                    $this->voteSovet();
                    break;

                case "vote-sovet-glava":
                    $this->voteSovetGlava();
                    break;

                case 'metro':
                    $this->showMetro();
                    break;

                case 'metro-xml':
                    $this->getMetroXml();
                    break;

                case 'give-money':
                    $this->giveSovetMoney();
                    break;

                case 'sovet':
                    $this->showInnerSovet();
                    break;

                case "glava-text":
                    $this->saveGlavaText();
                    break;

                case "exit":
                    $this->exitCouncil();
                    break;

                case "buy-boost":
                    $this->buyBoost();
                    break;

                case "vote-boost":
                    $this->voteBoost();
                    break;

                case "rupor":
                    $this->rupor();
                    break;

                // комнаты

                case "map":
                    $this->showMap();
                    break;

                case "council":
                    $this->showCouncil();
                    break;

                case "glava":
                    $this->showGlavaRoom();
                    break;

                case "warstats":
                    $this->showWarStats();
                    break;

                case "boosts":
                    $this->showBoostsShop();
                    break;

                case "logs":
                    $this->showLogs();
                    break;

                default:
                    $this->showSovet();
                    break;
            }
        } else {
            $this->showSovet();
        }
        //
        parent::onAfterProcessRequest();
    }

	/*
	 * Выдача недельного бонуса
	 */
	public function getWeeklyReward($reward) {
		if (date("N") >= 1 && date("N") <= 5) {
			$pts = Page::$player2->sovetpoints1prev;
			$field = 'sovetpoints1prev';
		} else {
			$pts = Page::$player2->sovetpoints1;
			$field = 'sovetpoints1';
		}
		if ($pts == 0) {
			Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			return $result;
		}
	
		$result = array('return_url' => '/sovet/');

		$sovetpoints1 = 0;
        if ($pts & 1) { $sovetpoints1++; }
        if ($pts & 2) { $sovetpoints1++; }
        if ($pts & 4) { $sovetpoints1++; }
        if ($pts & 8) { $sovetpoints1++; }
        if ($pts & 16) { $sovetpoints1++; }

		if ($reward > $sovetpoints1 || $reward < 1) {
			Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			return $result;
		}

		$actions = array(Page::$data['metro']['weekly_reward'][$reward]);
		Page::fullActions(Page::$player, $actions, SovetLang::ALERT_REWARD);

		if ($field == 'sovetpoints1') {
			Page::$sql->query("UPDATE player2 SET sovetprizetaken = sovetprizetaken | b'1000000', sovetpoints1 = 0 WHERE player = " . Page::$player->id);
		} else {
			Page::$sql->query("UPDATE player2 SET sovetpoints1prev = 0 WHERE player = " . Page::$player->id);
		}
		return $result;
	}

    /**
     * Покупка буста и выставление его на голосование
     */
    private function buyBoost()
    {
        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        if (!$this->content["council"]) {
            Std::redirect("/sovet/");
        }
        
        $ourStationsCount = self::$sql->getValue("SELECT count(*) FROM metro WHERE fraction = '" . self::$player->fraction . "'");
        
        $boost = self::$sql->getRecord("SELECT id, money FROM standard_item WHERE id = " . (int)$_POST["boost"] . " AND itemlevel <= " . $ourStationsCount);

        self::$sql->query("START TRANSACTION");
		$kazna = self::$sql->getValue("SELECT kazna FROM sovet2 WHERE fraction = '" . self::$player->fraction . "' FOR UPDATE");
		$x = isset($_POST["x2"]) ? 2 : 1;

		if ($boost && $kazna >= ($boost["money"] * $x)
            && self::$sql->getValue("SELECT count(*) FROM sovetperktemp WHERE standard_item = " . $boost["id"] . " AND fraction = '" . self::$player->fraction . "'") == 0)
        {
			self::$sql->query("UPDATE sovet2 SET kazna = kazna - " . ($boost["money"] * $x) . ", 
				kazna2 = kazna2 + " . ($boost["money"] * $x). " WHERE fraction = '" . self::$player->fraction . "'");

            $voted = addslashes(json_encode(array("all" => array(self::$player->id), "yes" => array(playerObject::exportForLogs2(self::$player->id)), "no" => array())));
            $params = addslashes(json_encode(array("x" => $x)));
            self::$sql->query("INSERT INTO sovetperktemp (fraction, dt, standard_item, player, yes, no, voted, params)
                VALUES ('" . self::$player->fraction . "', now(), " . $boost["id"] . ", " . self::$player->id . ", 0, 0, '" . $voted . "',
                '" . $params . "')");

            self::$sql->query("COMMIT");

            Page::addAlert(SovetLang::ALERT_OK, SovetLang::ALERT_BOOST_BUY);
		} else {
            self::$sql->query("ROLLBACK");
            Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
		}

        Std::redirect("/sovet/boosts/");
    }

    /**
     * Голосование за активацию буста
     */
    private function voteBoost()
    {
        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        if (!$this->content["council"]) {
            Std::redirect("/sovet/");
        }

        $vote = $_POST["vote"];
        $boostId = (int)$_POST["boost"];

        self::$sql->query("START TRANSACTION");
        $spt = self::$sql->getRecord("SELECT id, yes, no, voted, standard_item, params  FROM sovetperktemp WHERE id = " . $boostId . "
            AND fraction = '" . self::$player->fraction . "' FOR UPDATE");

		if ($spt && in_array($vote, array("yes", "no"))) {
			$voted = json_decode($spt["voted"], true);
			$params = json_decode($spt["params"], true);
            if (!in_array(self::$player->id, $voted["all"])) {
				$voted[$vote][] = playerObject::exportForLogs2(self::$player->id);
				$voted["all"][] = (int)self::$player->id;
				$points = $vote == "no" && $this->content["council"] == "founder" ? 5 : 1;
                self::$sql->query("UPDATE sovetperktemp SET $vote = $vote + $points,
                    voted = '" . addslashes(json_encode($voted)) . "' WHERE id = " . $boostId);
                self::$sql->query("COMMIT");

                if ($vote == "yes" && $spt["yes"] + $points >= Page::$data["sovet"]["boostvotes"]) {
                    self::$sql->query("START TRANSACTION");
                    self::$sql->query("DELETE FROM sovetperktemp WHERE id = " . $spt["id"]);

                    $boost = self::$sql->getRecord("SELECT id, code, name, money, time, special1, special1name FROM standard_item WHERE id = " . $spt["standard_item"]);

                    self::$sql->query("UPDATE sovet2 SET kazna2 = kazna2 - " . ($boost["money"] * $params["x"]). " WHERE fraction = '" . self::$player->fraction . "'");

                    Std::loadMetaObjectClass("perk");
                    $b = new perkObject();
                    $b->standard_item = $boost["id"];
                    $b->player = 0;
                    $b->clan = 0;
                    $b->fraction = self::$player->fraction;
                    $b->type = "";
                    $b->code = $boost["code"];
                    $b->value = $boost["special1"] * $params["x"];
                    $b->info = $boost["special1name"];
                    $b->dt = date("Y-m-d H:i:s", time());
                    $b->dt2 = date("Y-m-d H:i:s", time() + Page::timeLettersToSeconds($boost["time"]));
                    $b->save();

                    self::$sql->query("COMMIT");

					Sovet::addLog("bsta", array("m" => ($boost["money"] * $params["x"]), "b" => $boost["name"], "y" => $voted["yes"]));

                    Page::addAlert(SovetLang::ALERT_OK, SovetLang::ALERT_BOOST_ACTIVATED);
                } elseif ($vote == "no" && $spt["no"] + $points >= Page::$data["sovet"]["boostvotes"]) {
                    self::$sql->query("START TRANSACTION");
                    self::$sql->query("DELETE FROM sovetperktemp WHERE id = " . $spt["id"]);
                    $boost = self::$sql->getRecord("SELECT money FROM standard_item WHERE id = " . $spt["standard_item"]);
                    self::$sql->query("UPDATE sovet2 SET kazna = kazna + " . ($boost["money"] * $params["x"]) . ",
						kazna2 = kazna2 - " . ($boost["money"] * $params["x"]) . " WHERE fraction = '" . self::$player->fraction . "'");
                    self::$sql->query("COMMIT");

                    Page::addAlert(SovetLang::ALERT_OK, SovetLang::ALERT_BOOST_CANCELED);
                } else {
                    Page::addAlert(SovetLang::ALERT_OK, SovetLang::ALERT_BOOST_VOTED);
                }

                Std::redirect("/sovet/boosts/");
            }
        }
        self::$sql->query("ROLLBACK");
        Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);

        Std::redirect("/sovet/boosts/");
    }

    /**
     * Магазин бустов
     */
    private function showBoostsShop()
    {
        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        if (!$this->content["council"]) {
            Std::redirect("/sovet/");
        }

        $voteId = array();
        $votes = self::$sql->getRecordSet("SELECT si.*, sbt.* FROM sovetperktemp sbt INNER JOIN standard_item si ON sbt.standard_item = si.id
            WHERE sbt.fraction = '" . self::$player->fraction . "' ORDER BY sbt.dt ASC");
        if ($votes) {
            foreach ($votes as &$vote) {
                self::parseSpecialParams($vote);
                $vote["player"] = playerObject::exportForLogs2($vote["player"]);
                $vote['time'] = str_replace(array('d', 'h', 'm', 's'), array(Lang::TIME_D, Lang::TIME_H, Lang::TIME_MI, Lang::TIME_S), $vote['time']);
                $vote["timeleft"] = date("H:i:s", 3600 - (time() - strtotime($vote["dt"])));
                $vote["timeleft2"] = strtotime($vote["dt"]) + 3600 - time();
				$vote["params"] = json_decode($vote["params"], true);
				$vote['special1'] *= $vote["params"]["x"];

                $vote["voted"] = json_decode($vote["voted"], true);
				$vote["voted"]["me"] = in_array(self::$player->id, $vote["voted"]["all"]) ? 1 : 0;

                $voteId[] = $vote["standard_item"];
            }
            $this->content["votes"] = $votes;
        }

        $ourStationsCount = self::$sql->getValue("SELECT count(*) FROM metro WHERE fraction = '" . self::$player->fraction . "'");

        $this->content["boosts"] = self::$sql->getRecordSet("SELECT * FROM standard_item 
            WHERE shop = 'perk' AND type2 = 'fraction' AND buyable = 1 AND itemlevel <= " . $ourStationsCount . "
            ORDER BY itemlevel DESC");
        foreach ($this->content["boosts"] as &$boost) {
            self::parseSpecialParams($boost);
            $boost['time'] = str_replace(array('d', 'h', 'm', 's'), array(Lang::TIME_D, Lang::TIME_H, Lang::TIME_MI, Lang::TIME_S), $boost['time']);
            $boost["disabled"] = in_array($boost["id"], $voteId) ? 1 : 0;
        }

        $sovet2 = self::$sql->getRecord("SELECT * FROM sovet2 WHERE fraction = '" . self::$player->fraction . "'");

        $this->content["kazna"] = $sovet2["kazna"];
        $this->content["kazna2"] = $sovet2["kazna2"];

        $this->content["boostvotes"] = Page::$data["sovet"]["boostvotes"];

        $this->content['window-name'] = SovetLang::WINDOW_TITLE;
		$this->page->addPart('content', 'sovet/boosts.xsl', $this->content);
    }

    /**
     * Логи
     */
    private function showLogs()
    {
        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        if (!$this->content["council"]) {
            Std::redirect("/sovet/");
        }

        // логи
        if (is_numeric($this->url[1]) && $this->url[1] >= 1) {
            $page = (int)$this->url[1];
        } else {
            $page = 1;
        }
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $logs = self::$sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS DATE_FORMAT(dt, '%d.%m.%Y %H:%i') dt, action, params FROM sovetlog
            WHERE fraction='" . self::$player->fraction . "' ORDER BY id DESC LIMIT " . $offset . ", " . $perPage);
        $total = self::$sql->getValue("SELECT found_rows()");

        $this->content['page'] = $page;
		$this->content['pages'] = Page::generatePages($page, ceil($total / $perPage), 3);

        if ($logs) {
            foreach ($logs as &$log) {
                $log['params'] = json_decode($log['params'], true);
            }
            $this->content['log'] = $logs;
        } else {
            $this->content['log'] = "";
        }

        $this->content['window-name'] = SovetLang::WINDOW_TITLE;
		$this->page->addPart('content', 'sovet/logs.xsl', $this->content);
    }

    /**
     * Карта города
     */
    private function showMap()
    {
        $this->content["day"] = (int)date("N", time());
        $this->content["hour"] = (int)date("H", time());

        switch ($this->content["day"]) {
            case 2: // вторник, выборы станции для атаки, выборы главы совета (раз в 3 недели)
                // составление списка станций, которые можно атаковать
                $this->content["stations"]["votes"] = self::$sql->getRecordSet("SELECT id, name FROM metro
                    WHERE id IN (" . implode(",", self::getCanAttackStations()) . ") 
                    AND private = 0 ORDER BY name ASC");
                $this->content["stations"]["leaders"] = self::$sql->getRecordSet("
                    SELECT id, name, " . self::$player->fraction{0} . "votes votes FROM metro
                    WHERE id IN (" . implode(",", self::getCanAttackStations()) . ")
                    AND " . self::$player->fraction{0} . "votes > 0
                    ORDER BY " . self::$player->fraction{0} . "votes DESC LIMIT 0,10");
                $this->content["stations"]["total"] = 0;
                if ($this->content["stations"]["leaders"]) {
                    foreach ($this->content["stations"]["leaders"] as $leader) {
                        $this->content["stations"]["total"] += $leader["votes"];
                    }
                }
				if (strtotime(Page::$player->data['sovet_canvotearea']) > time()) {
					$this->content['areavote_willbe_at'] = date("H:i:s", strtotime(Page::$player->data['sovet_canvotearea']));
					$this->content['areavote'] = 0;
				} else {
					$this->content['areavote'] = 1;
				}
                break;
        }

//CacheManager::set('sovet_results_calculated', 1); // костыль. артем, разберись
		if ($this->content["day"] < 6 || CacheManager::get('value_sovet_results_calculated') == 0) {
			$this->content['astation'] = (int)self::$sql->getValue("SELECT metro FROM sovet3 WHERE fraction = 'arrived' AND year = " . (int)date("Y", time()) . " AND week = " . (int)date("W", time()));
			$this->content['rstation'] = (int)self::$sql->getValue("SELECT metro FROM sovet3 WHERE fraction = 'resident' AND year = " . (int)date("Y", time()) . " AND week = " . (int)date("W", time()));
		}

        $this->content['counter'] = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
        $this->content['metro'] = self::$sql->getRecordSet("SELECT id, name, fraction, private, " . self::$player->fraction{0} . "bonus bonus, info FROM metro ORDER BY id ASC");

		foreach ($this->content['metro'] as &$metro) {
			if ($metro['bonus'] != '') {
				$tmp = array();
				$metro['bonus'] = json_decode($metro['bonus'], true);
				foreach ($metro['bonus'] as $bonus) {
					$tmp[] = Page::$data['metro']['bonuses'][$bonus['code']]['title'];
				}
				$metro['bonus'] = implode(', ', $tmp);
			}
		}

        
        // сколько у кого станций сейчас
        $this->content["stations"]["stats"] = self::$sql->getRecordSet("SELECT fraction, count(*) amount FROM metro WHERE fraction != '' GROUP BY fraction ORDER BY amount DESC");

        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);

        $this->content["player"]["level"] = self::$player->level;

        $this->content['window-name'] = SovetLang::WINDOW_TITLE_MAP;
		$this->page->addPart('content', 'sovet/map.xsl', $this->content);
    }

    /**
     * Статистика противостояния этой недели
     */
    private function showWarStats()
    {
        $this->content["day"] = date("N", time());
        $this->content["hour"] = (int)date("H", time());

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
		$this->content["points2"] = $y;

		foreach (array("resident", "arrived") as $fraction) {
            $data = $sovet3[$fraction];
            $data["station"] = Page::sqlGetCacheValue("SELECT name FROM metro WHERE id = " . $data["metro"], 3600);
			//if ($this->content["day"] < 6 || self::$sql->getValue("SELECT value FROM value WHERE name = 'sovet_results_calculated'") == 0) {
                if ($data["enemy"] == "npc") {
                    $data["points1enemy"] = Page::$data["sovet"]["npcduels"] - $data["points1"];
                    $data["points1enemy"] = $data["points1enemy"] < 0 ? 0 : $data["points1enemy"];
                }

                $data["points2"] = round($data["points2"] * $y);
                $data["points2enemy"] = round($data["points2enemy"] * $y);

				// наложение коэффициента
				if ($data["k"] > 0) { // у врага больше станций
					$data["points12"] = round($data["points1"] * $data["k"]);
					$data["points22"] = round($data["points2"] * $data["k"]);

					$data["points2enemy2"] = $data["points1enemy2"] = 0;
				} elseif ($data["k"] < 0) { // у нас больше станций
					$data["points1enemy2"] = round($data["points1enemy"] * abs($data["k"]));
					$data["points2enemy2"] = round($data["points2enemy"] * abs($data["k"]));

					$data["points22"] = $data["points12"] = 0;
				}

				$data["resultpoints"] = $data["points1"] + $data["points12"] + $data["points2"] + $data["points22"];
                $data["resultpoints_enemy"] = $data["points1enemy"] + $data["points1enemy2"] + $data["points2enemy"] + $data["points2enemy2"];
            //} else {
			//	if ($data["enemy"] == "npc" && $data["points1"] < Page::$data["sovet"]["npcduels"]) {
			//		$data["points1enemy"] += (Page::$data["sovet"]["npcduels"] - $data["points1"]);
			//	}
			//}
			$data["points1percent"] = $data["points1"] / ($data["enemy"] == "npc" ? Page::$data["sovet"]["npcduels"] : (1 + $data["points1"] + $data["points1enemy"]));
			$data["points1percent"] = $data["points1percent"] < 0.01 ? 1 : round($data["points1percent"]*100);
			$data["points1percent"] = $data["points1percent"] > 100 ? 100 : $data["points1percent"];

			$data["points2percent"] = $data["points2"] / (1 + $data["points2"] + $data["points2enemy"]);
			$data["points2percent"] = $data["points2percent"] < 0.01 ? 1 : round($data["points2percent"]*100);
			$data["points2percent"] = $data["points2percent"] > 100 ? 100 : $data["points2percent"];

			$data["points3percent"] = $data["resultpoints"] / (1 + $data["resultpoints"] + $data["resultpoints_enemy"]);
			$data["points3percent"] = $data["points3percent"] < 0.01 ? 1 : round($data["points3percent"]*100);
			$data["points3percent"] = $data["points3percent"] > 100 ? 100 : $data["points3percent"];

            $this->content[$fraction] = $data;
        }

//CacheManager::set('sovet_results_calculated', 1); // костыль. артем, разберись
		$this->content["sovet_results_calculated"] = (int)CacheManager::get('value_sovet_results_calculated');

        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);

        $this->content['window-name'] = SovetLang::WINDOW_TITLE;
		$this->page->addPart('content', 'sovet/warstats.xsl', $this->content);
    }

    /**
     * Кабинет главы совета
     */
    private function showGlavaRoom()
    {
        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        if ($this->content["council"] != 'founder') {
            Std::redirect("/sovet/council/");
        }

        $sovet2 = self::$sql->getRecord("SELECT * FROM sovet2 WHERE fraction = '" . self::$player->fraction . "'");

        $this->content["textfraction"] = $sovet2["textfraction"];
        $this->content["textsovet"] = $sovet2["textsovet"];
        $this->content["textenemy"] = $sovet2["textenemy"];
        

        $this->content['window-name'] = SovetLang::WINDOW_TITLE;
		$this->page->addPart('content', 'sovet/glava.xsl', $this->content);
    }

    /**
     * Сохранение обращения главы Совета
     */
    private function saveGlavaText()
    {
        $council = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        $type = $this->url[1];
        if ($council == "founder" && in_array($type, array("fraction", "sovet", "enemy"))) {
            $text = htmlspecialchars($_POST[$type]);
            self::$sql->query("UPDATE sovet2 SET text" . $type . " = '" . $text . "' WHERE fraction = '" . self::$player->fraction . "'");
            Page::addAlert(SovetLang::ALERT_OK, SovetLang::ALERT_TEXT_SAVED);
        } else {
            Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
        }
        Std::redirect("/sovet/glava/");
    }

    /**
     * Главная страница для членов совета
     */
    private function showCouncil()
    {
        
        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        
        if (!$this->content["council"]) {
            Std::redirect("/sovet/");
        }


        $this->content["day"] = date("N", time());
        $this->content["hour"] = (int)date("H", time());

        switch ($this->content["day"]) {
            case 2: // вторник, выборы в главы совета
                $this->content["voted"] = in_array(self::$player->id, explode(",", trim(CacheManager::get('value_sovet_elections_voted'), ","))) ? 1 : 0;
                $this->content["sovet"] = self::$sql->getRecordSet("SELECT p.id, p.nickname, p.level, c.id clan_id, c.name clan_name, s.status
                    FROM sovet s LEFT JOIN player p ON p.id = s.player LEFT JOIN clan c ON c.id=p.clan LEFT JOIN player2 p2 ON p2.player = p.id
                    WHERE s.fraction =  '" . self::$player->fraction . "' ORDER BY s.status ASC");
                break;
        }

        $sovet2 = self::$sql->getRecord("SELECT * FROM sovet2 WHERE fraction = '" . self::$player->fraction . "'");

        // послание главы совета
        $glava = self::$sql->getRecord("SELECT p.id, p.fraction, p.level, p.nickname,
            p.avatar, p.forum_avatar, p.forum_avatar_checked, p2.slogan, p.clan_status, c.id clan_id, c.name clan_name, i.path
            FROM player p JOIN player2 p2 ON p2.player=p.id LEFT JOIN clan c ON c.id=p.clan LEFT JOIN stdimage i ON i.id=p.forum_avatar
            WHERE p.id = " . $sovet2["glava"]);
        if ($glava) {
            $letter = $sovet2["textsovet"];
            if ($glava["clan_status"] == "recruit") {
                unset($glava["clan_id"]);
                unset($glava["clan_name"]);
            }
            if ($glava['forum_avatar'] > 0 && $glava['forum_avatar_checked'] == 1) {
                $glava['avatar'] = '/@images/' . $glava['path'];
            }
            foreach (Page::$data['classes'] as $key => $cur) {
                if ($cur['avatar'] == $glava['avatar']) {
                    $glava['avatar'] = '/@/images/pers/' . $cur['thumb'];
                }
            }
            $this->content["lozung"] = array(
                "text" => nl2br($letter),
                "player" => $glava,
            );
        } else {
            $this->content["lozung"] = "";
        }

        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);
        
        // бусты
        $votes = self::$sql->getRecordSet("SELECT si.image, sbt.dt, si.name, si.info, si.special1, si.special1name
            FROM sovetperktemp sbt INNER JOIN standard_item si ON sbt.standard_item = si.id
            WHERE sbt.fraction = '" . self::$player->fraction . "' ORDER BY sbt.dt ASC");
        if ($votes) {
            foreach ($votes as &$vote) {
                $vote["timeleft"] = date("i:s", 3600 - (time() - strtotime($vote["dt"])));
                Page::parseSpecialParams($vote);
            }
            $this->content["votes"] = $votes;
        }

        $boosts = self::$sql->getRecordSet("SELECT si.image, p.dt2, si.name, si.info, p.value special1, si.special1name
            FROM perk p INNER JOIN standard_item si ON p.standard_item = si.id
            WHERE p.fraction = '" . self::$player->fraction . "' ORDER BY p.dt ASC");
        if ($boosts) {
            foreach ($boosts as &$boost) {
                $t = strtotime($boost["dt2"]) - time();
                $h = floor($t / 3600);
                $m = floor(($t - $h * 3600) / 60);
                $s = $t - $m * 60 - $h * 3600;
                $boost["timeleft"] = sprintf("%02d:%02d:%02d", $h, $m, $s);
                $boost["timeleft2"] = $t;
                Page::parseSpecialParams($boost);
            }
            $this->content["boosts"] = $boosts;
        }

        $this->content['player']["fraction"] = self::$player->fraction;

        $this->content['window-name'] = SovetLang::WINDOW_TITLE;
		$this->page->addPart('content', 'sovet/council.xsl', $this->content);
    }

    /**
     * Главная страница совета
     */
    private function showSovet()
    {
        $this->content["day"] = date("N", time());

        switch ($this->content["day"]) {
            case 1: // понедельник, выборы в совет (раз в 3 недели)
                $this->content["sovetvotes"]["leaders"] = file_get_contents("@cache/sovet_leaders_" . self::$player->fraction . ".html");
                $this->content["sovetvotes"]["me"] = strstr($this->content["sovetvotes"]["leaders"], self::$player->nickname) ? 0 : 1;
                $this->content["sovetvotes"]["money"] = (int)Page::getData("sovet_" . self::$player->fraction . "_elections_money", 
                    "SELECT sum(p2.sovetvotes) FROM player p INNER JOIN player2 p2 ON p.id = p2.player WHERE p.fraction = '" . self::$player->fraction  . "' AND p2.sovetvotes > 0",
                    "value", 300);
                $this->content["sovetvotes"]["total"] = (int)Page::getData("sovet_" . self::$player->fraction . "_elections_count",
					"SELECT count(*) FROM player p INNER JOIN player2 p2 ON p.id = p2.player WHERE p.fraction = '" . self::$player->fraction . "' AND p2.sovetvotes > 0",
					"value", 300);
				$this->content['sovet']['is_available'] = self::isVoteSovetAvailable();
                break;

            case 2: // вторник, выборы станции для атаки, выборы главы совета (раз в 3 недели)
                $this->content["sovet_members_selected"] = CacheManager::get('value_sovet_members_selected');
                break;

            case 3: // среда, объявление об атаках
                break;

            case 4: // четверг, дуэли
                break;

            case 5: // пятница, групповые бои
                break;

            case 6: // результаты, выходной
                break;

            case 7: // результаты, выходной
                break;
        }

        $sovet2 = self::$sql->getRecord("SELECT * FROM sovet2 WHERE fraction = '" . self::$player->fraction . "'");

        // послания глав советов
        $glavy = self::$sql->getRecordSet("SELECT p.id, p.fraction, p.level, p.nickname,
            p.avatar, p.forum_avatar, p.forum_avatar_checked, p2.slogan, p.clan_status, c.id clan_id, c.name clan_name, i.path
            FROM sovet2 s2 JOIN player p ON p.id = s2.glava JOIN player2 p2 ON p2.player=p.id
            LEFT JOIN clan c ON c.id=p.clan LEFT JOIN stdimage i ON i.id=p.forum_avatar");
        if ($glavy) {
            $ourFraction = self::$player->fraction;
            $enemyFraction = $ourFraction == "resident" ? "arrived" : "resident";
            $letters = self::$sql->getValueSet("SELECT textfraction FROM sovet2 WHERE fraction = '" . $ourFraction . "'
                UNION SELECT textenemy FROM sovet2 WHERE fraction = '" . $enemyFraction . "'");
            for ($i = 0; $i <= 1; $i++) {
                if ($glavy[$i]["clan_status"] == "recruit") {
                    unset($glavy[$i]["clan_id"]);
                    unset($glavy[$i]["clan_name"]);
                }
                if ($glavy[$i]['forum_avatar'] > 0 && $glavy[$i]['forum_avatar_checked'] == 1) {
                    $glavy[$i]['avatar'] = '/@images/' . $glavy[$i]['path'];
                }
                foreach (Page::$data['classes'] as $key => $cur) {
                    if ($cur['avatar'] == $glavy[$i]['avatar']) {
                        $glavy[$i]['avatar'] = '/@/images/pers/' . $cur['thumb'];
                    }
                }
            }
            $this->content["lozung"] = array(
                "our" => array(
                    "text" => nl2br($letters[0]),
                    "player" => $glavy[0]["fraction"] == $ourFraction ? $glavy[0] : $glavy[1],
                ),
                "enemy" => array(
                    "text" => nl2br($letters[1]),
                    "player" => $glavy[0]["fraction"] == $enemyFraction ? $glavy[0] : $glavy[1],
                ),
            );
        } else {
            $this->content["lozung"] = "";
        }

        $this->content["kazna"]["total"] = $sovet2["kazna"];
        $this->content["kazna"]["sponsors"] = file_get_contents("@cache/sovet_sponsors_" . self::$player->fraction . ".html");
        $this->content["kazna"]["me"] = strstr($this->content["kazna"]["sponsors"], self::$player->nickname) ? 0 : 1;

        // взнос в казну
        if (strtotime(self::$player2->lastsovetdep) > (time() - 8 * 60 * 60)) {
            $this->content["kazna"]['allowdep'] = 0;
            $this->content["kazna"]['depdt'] = date('d.m.Y H:i', (strtotime(self::$player2->lastsovetdep) + 8 * 60 * 60));
        } else {
            $this->content["kazna"]['allowdep'] = 1;
        }

        // состав совета
        $this->content["sostav"] = array(
            "our" => self::$sql->getRecordSet("SELECT p.id, p.nickname, p.level, p.fraction, c.id clan_id, c.name clan_name, s.status
                FROM sovet s LEFT JOIN player p ON p.id = s.player LEFT JOIN clan c ON c.id=p.clan LEFT JOIN player2 p2 ON p2.player = p.id
                WHERE s.fraction =  '" . self::$player->fraction . "' ORDER BY s.status ASC"),
            "enemy" => self::$sql->getRecordSet("SELECT p.id, p.nickname, p.level, p.fraction, c.id clan_id, c.name clan_name, s.status
                FROM sovet s LEFT JOIN player p ON p.id = s.player LEFT JOIN clan c ON c.id=p.clan LEFT JOIN player2 p2 ON p2.player = p.id
                WHERE s.fraction =  '" . (self::$player->fraction == "arrived" ? "resident" : "arrived") . "' ORDER BY s.status ASC"),
        );

        $this->content["player"] = array(
            "id" => self::$player->id,
            "nickname" => self::$player->nickname,
            "level" => self::$player->level,
            "fraction" => self::$player->fraction,
            "sovetmoney" => self::$player2->sovetmoney,
            "sovetvotes" => self::$player2->sovetvotes,
        );

        // бусты
        $boosts = self::$sql->getRecordSet("SELECT si.image, p.dt2, si.name, si.info, p.value special1, si.special1name
            FROM perk p INNER JOIN standard_item si ON p.standard_item = si.id
            WHERE p.fraction = '" . self::$player->fraction . "' ORDER BY p.dt ASC");
        if ($boosts) {
            foreach ($boosts as &$boost) {
                $t = strtotime($boost["dt2"]) - time();
                $h = floor($t / 3600);
                $m = floor(($t - $h * 3600) / 60);
                $s = $t - $m * 60 - $h * 3600;
                Page::parseSpecialParams($boost);
                $boost["timeleft"] = sprintf("%02d:%02d:%02d", $h, $m, $s);
                $boost["timeleft2"] = $t;
            }
            $this->content["boosts"] = $boosts;
        }

        // недельный бонус
		if (date("N") >= 6 && date("N") <= 7 && Page::$player2->sovetpoints1 == 0) {
			$this->content['show_progressbar'] = 0;
		} else {
			$this->content['show_progressbar'] = 1;
		}

		if (date("N") >= 1 && date("N") <= 5 && Page::$player2->sovetpoints1prev > 0) {
			$pts = Page::$player2->sovetpoints1prev;
			$this->content['bonus_prev_week'] = 1;
		} else {
			$pts = Page::$player2->sovetpoints1;
			$this->content['bonus_prev_week'] = 0;
		}

        $sovetpoints1 = 0;
        if ($pts & 1) { $sovetpoints1++; }
        if ($pts & 2) { $sovetpoints1++; }
        if ($pts & 4) { $sovetpoints1++; }
        if ($pts & 8) { $sovetpoints1++; }
        if ($pts & 16) { $sovetpoints1++; }
		$availableReward = array();
		for ($i = 1; $i <= $sovetpoints1; $i ++) {
			$availableReward[$i] = Page::$data['metro']['weekly_reward'][$i];
		}
		if (count($availableReward)) {
			$availableReward = Page::translateForAlert($availableReward);
			$this->content['weekly_reward'] = json_encode($availableReward);
		}

		$currentpoints1 = 0;
        if (Page::$player2->sovetpoints1 & 1) { $currentpoints1++; }
        if (Page::$player2->sovetpoints1 & 2) { $currentpoints1++; }
        if (Page::$player2->sovetpoints1 & 4) { $currentpoints1++; }
        if (Page::$player2->sovetpoints1 & 8) { $currentpoints1++; }
        if (Page::$player2->sovetpoints1 & 16) { $currentpoints1++; }
		$this->content["points1"] = $currentpoints1;
        $this->content["points1percent"] = $currentpoints1 / 5 * 100;

        // статус в совете
        $this->content["council"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id);

        $this->content['window-name'] = SovetLang::WINDOW_TITLE;
		$this->page->addPart('content', 'sovet/sovet.xsl', $this->content);
    }

    /**
     * Страница с картой метро
     */
    /*
    private function showMetro()
    {
        $stations = self::$sql->getRecordSet("SELECT * FROM station");
    }
    */

    /**
     * XML данные для отображения карты метро
     */
    /*
    private function getMetroXml()
    {
        $stations = self::$sql->getRecordSet("SELECT * FROM metro");
        for ($i = 0, $j = sizeof($stations); $i < $j; $i++) {
            $stations[$i]["neighbours"] = self::$sql->getValueSet("SELECT metro2 FROM metrolink WHERE metro1 = " . $stations[$i]["id"]);
        }
        echo Std::arrayToXml($stations);
        exit;
    }
    */

    /**
     * Получение списка id станций, которые можно атаковать
     *
     * @return array
     */
    public static function getCanAttackStations($fraction = false)
    {
        if (!$fraction) {
            $fraction = self::$player->fraction;
        }

        $canAttackStations = array();
        $ourStations = self::$sql->getValueSet("SELECT id FROM metro WHERE fraction='" . $fraction . "'");
        foreach ($ourStations as $station) {
            $neighbourStations = self::$sql->getValueSet("
                SELECT ml.metro2 FROM metrolink ml LEFT JOIN metro m ON m.id = ml.metro2
                    WHERE ml.metro1 = " . $station . " AND m.fraction != '" . self::$player->fraction . "' AND m.private = 0
                UNION SELECT ml.metro1 FROM metrolink ml LEFT JOIN metro m ON m.id = ml.metro1
                    WHERE ml.metro2 = " . $station . " AND m.fraction != '" . self::$player->fraction . "' AND m.private = 0");
            if ($neighbourStations) {
                foreach ($neighbourStations as $nStation) {
                    if (!in_array($nStation, $canAttackStations)) {
                        $canAttackStations[] = $nStation;
                    }
                }
            }
        }
        return $canAttackStations;
    }

    /**
     * Взнос в казну совета
     */
    private function giveSovetMoney()
    {
        $money = abs((int)$_POST["money"]);
        if ($money >= 100) {
            self::$sql->query("START TRANSACTION");
            $playerMoney = self::$sql->getValue("SELECT money FROM player WHERE id = " . self::$player->id . " FOR UPDATE");
            if ($playerMoney >= $money) {
                //self::$player->money -= $money;
                //self::$player->save(self::$player->id, array(playerObject::$MONEY));
                self::$sql->query("UPDATE player SET money = " . ($playerMoney - $money) . " WHERE id = " . self::$player->id);
                self::$sql->query("UPDATE sovet2 SET kazna = kazna + " . $money . " WHERE fraction = '" . self::$player->fraction . "'");
                self::$sql->query("UPDATE player2 SET sovetmoney = sovetmoney + " . $money . ", lastsovetdep = now()
                    WHERE player = " . self::$player->id);
                self::$sql->query("COMMIT");

                $mbckp = array('m' => ($playerMoney - $money), 'o' => self::$player->ore, 'h' => self::$player->honey);
                Page::sendLog(self::$player->id, "svtdpst", array('m' => $money, 'mbckp' => $mbckp), 1);

                if ($money >= self::$player->level * 500) {
                    Sovet::addLog("dpst", array("m" => $money, "p" => self::$player->exportForDb()));
                }

                Page::addAlert(SovetLang::ALERT_OK, SovetLang::ALERT_DEPOSIT_TEXT);

                // прогресс недельного бонуса
				if (!(self::$player2->sovetprizetaken & 64)) {
					self::$sql->query("UPDATE player2 SET sovetpoints1 = sovetpoints1 | b'00100' WHERE id = " . self::$player2->id);
				}
            } else {
                self::$sql->query("ROLLBACK");
                Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_NO_MONEY_TO_DEPOSIT, ALERT_ERROR);
            }
        } else {
            Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_MIN100, ALERT_ERROR);
        }
        Std::redirect("/sovet/");
    }

    /**
     * Голование за станцию метро
     */
    private function voteMetro() {
		if (date("N", time()) == 2) {
            $station = (int)$_POST["station"];
            $name = Page::sqlGetCacheValue("SELECT name FROM metro WHERE id = " . $station, 3600);
            $money = abs((int)$_POST["money"]);
			if ($money > 10000) {
				Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_VOTERAION_MAX10000, ALERT_ERROR);
				Std::redirect("/sovet/map/");
			}

			if (strtotime(Page::$player->data['sovet_canvotearea']) > time()) {
				Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				Std::redirect("/sovet/map/");
			}

            if ($money >= 100) {
                if ($name && in_array($station, self::getCanAttackStations()) && self::$player->level >= Page::$data["sovet"]["voteminlevel2"]) {
                    if (self::$player->money >= $money) {
                        self::$player->money -= $money;
						Page::$player->data['sovet_canvotearea'] = date("Y-m-d H:i:s", time() + 3600);
						Page::$player->data = json_encode(Page::$player->data);
                        self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$DATA));
						Page::$player->data = json_decode(Page::$player->data, true);

                        self::$sql->query("UPDATE metro SET " . self::$player->fraction{0} . "votes =
                            " . self::$player->fraction{0} . "votes + " . $money . " WHERE id = " . $station);

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                        Page::sendLog(self::$player->id, "svtmtvt", array('m' => $money, 'n' => $name, 'mbckp' => $mbckp), 1);

                        Page::addAlert(SovetLang::ALERT_VOTE_TITLE, SovetLang::ALERT_VOTE_TEXT);

                        // прогресс недельного бонуса
                        self::$sql->query("UPDATE player2 SET sovetpoints1 = sovetpoints1 | b'00010' WHERE id = " . self::$player2->id);
                    } else {
                        Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_NO_MONEY_TO_VOTE_STATION, ALERT_ERROR);
                    }
                } else {
                    Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
                }
            } else {
                Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_VOTERAION_MIN100, ALERT_ERROR);
            }
        } else {
            Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
        }
        Std::redirect("/sovet/map/");
    }
	
	public static function isVoteSovetAvailable() {
		if (date("N", time()) == 1 && (date("H") > 0 || (date("H") == 0 && date("i") > 30))) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * Голосование на выборах в совет
     */
    private function voteSovet()
    {
        //$lastElectionsTime = strtotime(self::$sql->getValue("SELECT value FROM value WHERE name = 'sovet_elections'"));
        //if (date("N", time()) == 1 && time() - $lastElectionsTime >= 21 * 24 * 60 * 60) { // с момента последнего голосования прошло более 3 недель
        if (self::isVoteSovetAvailable()) {
            $player = self::$sql->getRecord("SELECT p.id, p.fraction, p.nickname, p.level, p.accesslevel, c.id clan_id, c.name clan_name
                FROM player p LEFT JOIN clan c ON c.id=p.clan WHERE p.nickname = '" . Std::cleanString($_POST["nickname"]) . "'");
            if ($player && $player["level"] >= Page::$data["sovet"]["memberminlevel"] && ($player['accesslevel'] == 0 || DEV_SERVER)
                && self::$player->level >= Page::$data["sovet"]["voteminlevel"]) {
                $money = abs((int)$_POST["money"]);
                if ($money >= 100 && self::$player->money >= $money) {
                    self::$player->money -= $money;
                    self::$player->save(self::$player->id, array(playerObject::$MONEY));

                    self::$sql->query("UPDATE player2 SET sovetvotes = sovetvotes + " . $money . " WHERE player = " . $player["id"]);

                    $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                    Page::sendLog(self::$player->id, "svtsvtvt", array('m' => $money, 'p' => $player, 'mbckp' => $mbckp), 1);

                    Page::addAlert(SovetLang::ALERT_VOTE_TITLE, SovetLang::ALERT_VOTE_TEXT);

                    // прогресс недельного бонуса
                    self::$sql->query("UPDATE player2 SET sovetpoints1 = sovetpoints1 | b'00001' WHERE id = " . self::$player2->id);
                } else {
                    Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_NO_MONEY_TO_VOTE_SOVET, ALERT_ERROR);
                }
            } else {
                Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            }
        } else {
            Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
        }
        Std::redirect("/sovet/");
    }

    /**
     * Голосование на выборах главы совета
     */
    private function voteSovetGlava()
    {
        $player = (int)$_POST["player"];
        //$lastElectionsTime = strtotime(self::$sql->getValue("SELECT value FROM value WHERE name = 'sovet_elections_glava'"));
        $voted = explode(",", trim(CacheManager::get('value_sovet_elections_voted'), ","));
        if (Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id) == 'accepted'
            && date("N", time()) == 2
            /*&& (time() - $lastElectionsTime) >= (21 * 24 * 60 * 60)*/
            && (int)date("H", time()) > 0
            && !in_array(self::$player->id, $voted)
            && self::$sql->getValue("SELECT count(*) FROM sovet WHERE player = " . $player) == 1
            && self::$sql->getValue("SELECT count(*) FROM sovet WHERE player = " . self::$player->id) == 1)
        {
            self::$sql->query("UPDATE player2 SET sovetvotes = sovetvotes + 1 WHERE player = " . $player);
            self::$sql->query("UPDATE value SET value = concat(value,'," . self::$player->id . "') WHERE name = 'sovet_elections_voted'");
			CacheManager::delete('value_sovet_elections_voted');

            $p = new playerObject();
            $p->load($player);
            Page::sendLog(self::$player->id, "svtsvtvtglv", array('p' => $p->exportForLogs()), 1);

            Page::addAlert(SovetLang::ALERT_VOTE_TITLE, SovetLang::ALERT_VOTE_TEXT);
        } else {
            Page::addAlert(SovetLang::ERROR, SovetLang::ERROR_ACTION_DENIED, ALERT_ERROR);
        }
        Std::redirect("/sovet/council/");
    }

    /**
     * Проверка: можно ли голосовать за игрока на выборах в совет
     */
    private function checkPlayer()
    {
        $player = self::$sql->getRecord("SELECT id, level, accesslevel FROM player WHERE nickname = '" . Std::cleanString($this->url[1]) . "'");
        if ($player && ($player['accesslevel'] == 0 || (DEV_SERVER && $player['accesslevel'] == 2)) && $player["level"] >= 5) {
            echo Std::arrayToJson(array(
                "id" => (int)$player['id'],
            ));
        } else {
            $id = 0;
            if ($player['level'] < 5) {
                $id = -1;
            } elseif ($player['accesslevel'] == -1 || $player['accesslevel'] == -2) {
                $id = -2;
            } elseif ($player['accesslevel'] == 11) {
                $id = -3;
            }
            echo Std::arrayToJson(array("id" => $id));
        }
        exit;
    }

    /**
     *  Рассылка сообщений всем членам Совета
     */
    private function rupor() {
        $sovet = self::$sql->getValueSet("SELECT player FROM sovet WHERE fraction = '" . self::$player->fraction . "'");
		
		$found = false;
		foreach ($sovet as $s) {
			if ($s == Page::$player->id) {
				$found = true;
				break;
			}
		}
		
		if (!$found) {
			Std::redirect('/sovet/');
		}

        if ($sovet) {
            $meForLogs = self::$player->exportForLogs();
            foreach ($sovet as $player) {
                $id = Page::sendMessage(self::$player->id, $player, $_POST["text"], "sovet_message", $meForLogs);
				if ($id < 0)  {
					break;
				}
            }
        }

		if ($id > 0) Page::addAlert(Lang::ALERT_OK, SovetLang::ALERT_RUPOR_OK, ALERT_INFO);
        Std::redirect("/sovet/council/");
    }

    /**
     * Выход из совета
     */
    private function exitCouncil() {
		if ($_POST['action'] != 'exit') {
			Std::redirect('/exit/');
		}
	
        self::kickFromSovet(self::$player->id);

		// CHAT выходим из совета
		$key = self::signed(self::$player->id);
		$userInfo = array();
		$userInfo[$key] = array();
		$userInfo[$key]["sovet"] = "0";
		Page::chatUpdateInfo($userInfo);

		$cachePlayer = self::$cache->get("user_chat_" . $key);
		if ($cachePlayer) {
			$cachePlayer["sovet"] = "0";
			self::$cache->set("user_chat_" . $key, $cachePlayer);
		}

        Page::addAlert(SovetLang::ALERT_OK, SovetLang::ALERT_EXIT);
        Std::redirect("/sovet/");
    }

    public static function kickFromSovet($playerId)
    {
        self::$sql->query("DELETE FROM gift WHERE type = 'award' AND code = 'award_sovet' AND player = " . $playerId);

        if (Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id) == "founder") {
            $fraction = self::$sql->getValue("SELECT fraction FROM player WHERE id = " . $playerId);
            $newGlava = self::$sql->getValue("SELECT p2.player
                FROM sovet s LEFT JOIN player p ON p.id = s.player LEFT JOIN player2 p2 ON p2.player = s.player
                WHERE s.fraction = '" . $fraction . "' ORDER BY p.statsum2 DESC LIMIT 0, 1");
            self::$sql->query("UPDATE sovet SET status = 'founder' WHERE player = " . $newGlava);
        }

        self::$sql->query("DELETE FROM sovet WHERE player = " . $playerId);
		Page::$cache->set('player_sovet_status_' . Page::$player->id, '', 3600);
    }

    /**
     * Добавление записи в логи Совета
     *
     * @param string $action
     * @param array $params
     * @param int $player
     * @param string $fraction
     */
    public static function addLog($action, $params, $fraction = null, $player = null)
    {
        $fraction = $fraction === null ? self::$player->fraction : $fraction;
        $player = $player === null ? self::$player->id : $player;
        Std::loadMetaObjectClass("sovetlog");
        $log = new sovetlogObject();
        $log->action = $action;
        $log->dt = date("Y-m-d H:i:s", time());
        $log->params = json_encode($params);
        $log->player = $player;
        $log->fraction = $fraction;
        $log->save();
    }
}
?>