<?php
class Huntclub extends Page implements IModule
{
    public $moduleCode = 'Huntclub';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();

        $this->needAuth();

        switch ($this->url[0]) {
            case 'activate':
                $this->activateClub();
                break;

            case 'zakaz':
                $this->zakaz();
                break;

            case "checkplayer":
                $this->checkPlayer();
                break;

            case 'my':
                $this->showMy();
                break;

            case 'me':
                $this->showMe();
                break;

            case 'wanted':
                $this->showWanted();
                break;

            case "clear-comment":
                $this->clearZakazComment();
                break;

            default:
                $this->showClub();
                break;
		}

        parent::onAfterProcessRequest();
    }

    /**
     * Отображение клуба
     */
    private function showClub()
    {
        $this->content['player'] = self::$player->toArray();

        if (self::$player->level >= 3) {
            if (strtotime(self::$player->huntdt) > time()) {
                Std::loadLib('HtmlTools');
                $this->content['huntdt'] = HtmlTools::FormatDateTime(self::$player->huntdt, true, true, true);
                $this->content['hunter'] = 1;

                $this->content['prof'] = self::$player->getProf(Page::$data['huntclub']['rangs'], "skillhunt");

                $this->content["mycomplete"] = self::$sql->getValue("SELECT count(*) FROM " . Page::$__LOG_TABLE__ . " WHERE player=" . self::$player->id . "
                    AND type = 'fighthntclb'");

                $fraction = self::$player->fraction == 'resident' ? 'arrived' : 'resident';
                $wanted = self::$sql->getRecordSet("SELECT p.id, p.nickname, p.level, p.fraction, c.id clan_id, c.name clan_name, h.award
													FROM hunt h
													FORCE INDEX (ix__hunt__fraction_state)
													LEFT JOIN player p ON h.player = p.id
													LEFT JOIN clan c ON p.clan = c.id
													WHERE h.fraction = '" . $fraction . "'
													AND h.level IN (" . (self::$player->level - 1) . ", " . self::$player->level . ", " . (self::$player->level + 1) . ")
													AND h.state = 1 AND h.player2 != " . self::$player->id . "
													AND h.award > 0
													AND p.accesslevel = 0
													AND p.state NOT IN ('police', 'fight', 'frozen')
													AND p.lasttimeattacked < UNIX_TIMESTAMP() - 3600
													AND (p.maxhp = 0 OR round(p.maxhp - ((p.healtime - unix_timestamp()) / (60 / if(p.level = 1, 6, 1))) * (p.maxhp / 30)) >= p.maxhp * 0.35)
													ORDER BY h.xmoney DESC, h.award DESC LIMIT 0,20");
                $this->content['wanted'] = array();
                if ($wanted) {
                    shuffle($wanted);
                    for ($i = 0, $j = sizeof($wanted); $i < 5, $i < $j; $i++) {
                        $wanted[$i]['award'] = floor($wanted[$i]['award'] / 3);
                        $this->content['wanted'][] = $wanted[$i];
                    }
                }
            } else {
                $this->content['hunter'] = 0;
            }
        }

        $this->content['orders_done'] = self::$sql->getValue("SELECT count(*) FROM hunt WHERE player2 = " . self::$player->id . "
            AND dt > DATE_SUB(now(), INTERVAL 1 DAY)");
		$this->content['myzakaz'] = self::$sql->getValue("SELECT count(*) FROM hunt WHERE player2 = " . self::$player->id . "
            AND state IN (0,1)");
        $this->content['myzakaz2'] = self::$sql->getValue("SELECT count(*) FROM hunt WHERE player2 = " . self::$player->id);

        $this->content['mezakaz'] = self::$sql->getValue("SELECT count(*) FROM hunt WHERE player = " . self::$player->id . "
            AND state IN (0,1)");
        $this->content['mezakaz2'] = self::$sql->getValue("SELECT count(*) FROM hunt WHERE player = " . self::$player->id);

        if ($this->url[0] == "revenge" && is_numeric($this->url[1])) {
            $victim = self::$sql->getValue("SELECT nickname FROM player WHERE id = " . (int)$this->url[1]);
            $this->content["revenge"] = $victim ? $victim : "";
        }

		$this->content['window-name'] = HuntclubLang::WINDOW_TITLE;
		$this->page->addPart ('content', 'huntclub/huntclub.xsl', $this->content);
    }

    /**
     * Проверка игрока на возможность заказа
     */
    private function checkPlayer()
    {
        $player = self::$sql->getRecord("SELECT id, level, accesslevel, clan, clan_status FROM player WHERE nickname = '" . Std::cleanString($this->url[1]) . "'");
        if ($player && $player['id'] != self::$player->id && ($player['accesslevel'] == 0 || (DEV_SERVER && $player['accesslevel'] == 2)) 
                && $player["clan"] != 130 && $player["clan"] != 14 && $player["clan"] != 278 && (self::$player->level - $player["level"]) <= 1) {
            echo Std::arrayToJson(array(
                "id" => (int)$player['id'],
                "level" => (int)$player['level'],
                "playerzakaz" => (int)self::$sql->getValue("SELECT count(*) FROM hunt WHERE player = " . $player['id'] . " AND dt > DATE_SUB(now(), INTERVAL 1 DAY)"),
				"myzakaz" => (int)self::$sql->getValue("SELECT count(*) FROM hunt WHERE player2 = " . self::$player->id . " AND dt > '" . date("Y-m-d 00:00:00", time()) . "'")
            ));
        } else {
            if ($player == false) {
                $id = 0;
            } elseif ($player['id'] == self::$player->id) {
                $id = -1;
            } elseif ($player['accesslevel'] == -1 || $player['accesslevel'] == -2) {
                $id = -2;
            } elseif ($player['accesslevel'] == 11) {
                $id = -3;
            } elseif ($player["clan"] == 130 || $player["clan"] == 14 || $player["clan"] == 278) {
                $id = -5;
            } elseif (self::$player->level - $player["level"] > 1) {
                $id = -6;
            } elseif ($player['id'] != 0) {
                $id = -4;
            }
            echo Std::arrayToJson(array("id" => $id, "level" => 0, "playerzakaz" => 0));
        }
        exit;
    }

    /**
     * Заказ
     */
    private function zakaz()
    {
        if (self::$player->level >= 2) {
            $player = self::$sql->getRecord("SELECT id, level, fraction, accesslevel, clan FROM player WHERE nickname='" . Std::cleanString($_POST['nickname']) . "'");
            if (($player["clan"] == 0 || ($player["clan"] != 130 && $player["clan"] != 14 && $player["clan"] != 278)) && ($player["accesslevel"] == 0 || ($player["accesslevel"] == 2 && DEV_SERVER)) && $player['id'] != Page::$player->id) {
                if ($player['level'] > 2) {
                    if (self::$player->level - $player['level'] <= 1) {
                        $playerZakaz = (int)self::$sql->getValue("SELECT count(*) FROM hunt WHERE player = " . $player['id'] . " AND dt > DATE_SUB(now(), INTERVAL 1 DAY)");
                        if ($playerZakaz < 3) {
                            $myZakaz = (int)self::$sql->getValue("SELECT count(*) FROM hunt WHERE player2 = " . self::$player->id . " AND dt > '" . date("Y-m-d 00:00:00", time()) . "'");
                            if ($myZakaz < 10) {
                                $money = 40 * ($player['level'] - 2) * ($playerZakaz > $myZakaz ? $playerZakaz : $myZakaz);
                                if ($money <= self::$player->money) {
                                    $award = abs((int)$_POST['award']);
                                    if ($award <= self::$player->level * 1000) {
                                        if (($award + $money) <= self::$player->money) {
                                            $vip = isset($_POST['vip']) ? 1 : 0;
                                            $private = isset($_POST['private']) ? 1 : 0;
                                            if ($vip || $private) {
                                                $price = $vip ? Page::$data['huntclub']['viporderprice'] : 0;
                                                $priceHoney = $private ? Page::$data['huntclub']['privateorderprice'] : 0;
                                                if (self::$player->ore + self::$player->honey >= $price && self::$player->honey >= $priceHoney) {
                                                    if (self::$player->ore >= $price) {
                                                        $priceOre = $price;
                                                        $priceHoney = $priceHoney;
                                                    } else {
                                                        $priceOre = self::$player->ore;
                                                        $priceHoney = $price - $priceOre + $priceHoney;
                                                        $priceHoneyOre = $price - $priceOre; // для логов
                                                    }

                                                    if ($priceHoney > 0) {
                                                        $reason	= 'huntclub zakaz $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
                                                        $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                                                    }
                                                } else {
                                                    Page::addAlert(HuntclubLang::$error, HuntclubLang::ERROR_LOW_ORE, ALERT_ERROR);
                                                    Std::redirect("/huntclub/");
                                                }
                                            }

                                            if (!$vip || ($priceHoney == 0 || $takeResult[0] == 'OK')) {
                                                if ($vip) {
                                                    self::$player->ore -= $priceOre;
                                                    self::$player->honey -= $priceHoney;
                                                    self::$player->save(self::$player->id, array(playerObject::$ORE, playerObject::$HONEY));
                                                }
                                                self::$player->money -= ($award + $money);
                                                self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$ORE, playerObject::$HONEY));

                                                $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                                                $p = new playerObject();
                                                $p->load($player["id"]);
                                                Page::sendLog(self::$player->id, 'hntclbz', array('o' => $priceOre, 'h' => $priceHoney, 'm' => ($award + $money), 'p' => $p->exportForLogs(), 'mbckp' => $mbckp), 1);

                                                Std::loadMetaObjectClass('hunt');
                                                $hunt = new huntObject();
                                                $hunt->fraction = $player['fraction'];
                                                $hunt->player = $player['id'];
                                                $hunt->player2 = self::$player->id;
                                                $hunt->award = $money + $award;
                                                $hunt->money = $money + $award;
                                                $hunt->comment = htmlspecialchars(Std::cleanString(iconv("windows-1251", "utf-8", wordwrap(iconv("utf-8", "windows-1251", $_POST['comment']), 40, " ", true))));
                                                $hunt->level = $player['level'];
                                                $hunt->xmoney = $vip ? 2 : 1;
                                                $hunt->dt = date("Y-m-d H:i:s", time() + 60 * 60);
                                                $hunt->dt2 = date("Y-m-d H:i:s", time() + 60 * 60 + 24 * 60 * 60);
                                                $hunt->kills = 3;
                                                $hunt->kills2 = 0;
                                                $hunt->private = $private;
                                                $hunt->state = 0;
                                                $hunt->save();

                                                self::$sql->query("UPDATE player SET wanted=1 WHERE id = " . $player["id"]);
                                                Page::sendLog($player["id"], 'hntclbz2', array(), 1);

                                                Page::addAlert(HuntclubLang::ALERT_ZAKAZ_TITLE, HuntclubLang::ALERT_ZAKAZ_TEXT);
												
												Page::checkEvent(Page::$player->id, 'huntclub_order');
                                            }
                                        }
                                    } else {
                                        Page::addAlert(HuntclubLang::ERROR, Lang::renderText(HuntclubLang::ERROR_MAX_MONEY, array('money' => (self::$player->level * 1000))), ALERT_ERROR);
                                    }
                                } else {
                                    Page::addAlert(HuntclubLang::ERROR, HuntclubLang::ERROR_LOW_MONEY, ALERT_ERROR);
                                }
                            } else {
                                Page::addAlert(HuntclubLang::ERROR, HuntclubLang::ERROR_MY_ZAKAZ_LIMIT, ALERT_ERROR);
                            }
                        } else {
                            Page::addAlert(HuntclubLang::ERROR, HuntclubLang::ERROR_PLAYER_ZAKAZ_LIMIT, ALERT_ERROR);
                        }
                    } else {
                        Page::addAlert(HuntclubLang::ERROR, HuntclubLang::ERROR_HIGH_LEVEL_DIFF, ALERT_ERROR);
                    }
                } else {
                    Page::addAlert(HuntclubLang::ERROR, HuntclubLang::ERROR_LOW_TARGET_LEVEL, ALERT_ERROR);
                }
            } else {
                Page::addAlert(HuntclubLang::ERROR, HuntclubLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            }
        }
        Std::redirect('/huntclub/');
    }

    /**
     * Активация и продление членства в клубе
     */
    private function activateClub()
    {
        if (self::$player->level >= 2) {
            if ($_POST['player'] == self::$player->id) {
                $price = Page::$data['huntclub']['price'];
				Page::startTransaction('huntclub_activate');
                if (self::$player->ore + self::$player->honey >= $price) {
                    if (self::$player->ore >= $price) {
                        $priceOre = $price;
                        $priceHoney = 0;
                    } else {
                        $priceOre = self::$player->ore;
                        $priceHoney = $price - $priceOre;
                        $priceHoneyOre = $price - $priceOre; // для логов
                    }

                    if ($priceHoney > 0) {
                        $reason	= 'huntclub membership $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
                        $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                    }
                    if ($priceHoney == 0 || $takeResult[0] == 'OK') {
                        self::$player->ore -= $priceOre;
                        self::$player->honey -= $priceHoney;
                        

                        $curHuntClubDt = strtotime(self::$player->huntdt);
                        $hcSec = 14 * 24 * 60 * 60;
                        $newHuntClubTime = $curHuntClubDt <= time() ? time() + $hcSec : $curHuntClubDt + $hcSec;
                        self::$player->huntdt = date('Y-m-d H:i:s', $newHuntClubTime);
                        
                        self::$player->save(self::$player->id, array(playerObject::$ORE, playerObject::$HONEY, playerObject::$HUNTDT));

                        // добавить дарение бонуса

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                        Page::sendLog(self::$player->id, 'hntclbm', array('o'=>$priceOre, 'h'=>$priceHoney, 'dt'=>date('d.m.Y H:i', $newHuntClubTime), 'mbckp'=>$mbckp), 1);

                        Page::addAlert(HuntclubLang::ALERT_WELCOME_TITLE, '<img src="/@/images/obj/symbol2.png" style="margin-right:10px;" align="left" />' . HuntclubLang::ALERT_WELCOME_TEXT);

						Page::checkEvent(self::$player->id, 'huntclub_buy');
                    } else {
                        Page::addAlert(HuntclubLang::$errorNoHoney, HuntclubLang::$errorNoHoneyText);
                    }
					Page::endTransaction('huntclub_activate');
                } else {
                    Page::addAlert(HuntclubLang::$error, HuntclubLang::ERROR_LOW_MONEY, ALERT_ERROR);
                }
            }
        } else {
            Page::addAlert(HuntclubLang::$error, HuntclubLang::ERROR_LOW_LEVEL, ALERT_ERROR);
        }
        Std::redirect('/huntclub/');
    }

    /**
     * Список заказов игрока
     */
    private function showMy()
    {
        Std::loadLib('HtmlTools');

        $wanted = self::$sql->getRecordSet("SELECT p.id, p.nickname, p.level, p.fraction, p.level, c.id clan_id, 
            c.name clan_name, h.id hunt, h.award, h.opened, h.private, h.dt, h.comment, h.dt2, h.state, h.xmoney
            FROM hunt h LEFT JOIN player p ON h.player = p.id LEFT JOIN clan c ON p.clan = c.id
            WHERE h.player2 = " . self::$player->id . " ORDER BY dt DESC");

        $this->content['wanted'] = array();
        if ($wanted) {
            foreach ($wanted as $want) {
                $want['award'] = $want['award'];
                $want['dt'] = HtmlTools::FormatDateTime($want['dt'], true, false, false);
                
                $want["logs"] = array();
                $kills = self::$sql->getRecordSet("SELECT player, duel, `kill`, dt FROM huntlog WHERE hunt = " . $want["hunt"] . " ORDER BY dt ASC");
                if ($kills) {
                    foreach ($kills as $kill) {
                        $kill["dt"] = HtmlTools::FormatDateTime($kill['dt'], true, false, false);
						$kill['sk'] = Page::generateKeyForDuel($kill['duel']);
                        $want["logs"][] = $kill;
                    }
                }
                $this->content['wanted'][] = $want;
            }
        }

        $this->content['window-name'] = HuntclubLang::WINDOW_TITLE;
        $this->page->addPart('content', 'huntclub/my.xsl', $this->content);
    }

    /**
     * Список заказов на игрока
     */
    private function showMe()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($this->url[1] == "pay-fee") {
                $hunt = self::$sql->getRecord("SELECT id, money, award FROM hunt WHERE id = " . (int)$_POST["hunt"] . " AND player = " . self::$player->id);
                if ($hunt["money"] == 0 || $hunt["money"] == $hunt["award"]) {
                    $hunt["money"] = $hunt["award"] + 40 * (self::$player->level - 2) * 1;
                }
                if ($hunt && self::$player->money >= $hunt["money"]) {
                    self::$player->money -= $hunt["money"];
                    self::$player->save(self::$player->id, array(playerObject::$MONEY));

                    self::$sql->query("UPDATE hunt SET state = 3 WHERE id = " . $hunt["id"]);
                    Page::addAlert(HuntclubLang::ALERT_PAYFEE_TITLE, HuntclubLang::ALERT_PAYFEE_TEXT);

                    $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                    Page::sendLog(self::$player->id, 'hntclbf', array('m'=>$hunt["money"], 'mbckp'=>$mbckp), 1);

                    if (self::$sql->getValue("SELECT count(*) FROM hunt WHERE player = " . self::$player->id . " AND state IN (0,1)") == 0) {
                        self::$player->wanted = 0;
                        self::$player->save(self::$player->id, array(playerObject::$WANTED));
                    }
                } else {
                    Page::addAlert(Lang::ERROR_NO_MONEY_TITLE, HuntclubLang::ERROR_NO_MONEY_TO_PAY_FEE, ALERT_ERROR);
                }
            } elseif ($this->url[1] == "open") {
                $price = Page::$data['huntclub']['openprice'];
                if (self::$player->honey >= $price) {
                    $reason	= 'huntclub open $' . $price;
                    $takeResult = self::doBillingCommand(self::$player->id, $price, 'takemoney', $reason, $other);
                    if ($takeResult[0] == 'OK') {
                        self::$player->honey -= $price;
                        self::$player->save(self::$player->id, array(playerObject::$HONEY));

                        self::$sql->query("UPDATE hunt SET opened = 1 WHERE player = " . self::$player->id . " AND id = " . (int)$_POST['hunt'] . " AND private = 0 AND opened = 0");
                        Page::addAlert(HuntclubLang::ALERT_OPEN_TITLE, HuntclubLang::ALERT_OPEN_TEXT);

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                        Page::sendLog(self::$player->id, 'hntclbo', array('h'=>$price, 'mbckp'=>$mbckp), 1);
                    } else {
                        Page::addAlert(HuntclubLang::$errorNoHoney, HuntclubLang::$errorNoHoneyText, ALERT_ERROR);
                    }
                } else {
                    Page::addAlert(HuntclubLang::$errorNoHoney, HuntclubLang::$errorNoHoneyText, ALERT_ERROR);
                }
            }
            Std::redirect("/huntclub/me/");
        }

        Std::loadLib('HtmlTools');

        $wanted = self::$sql->getRecordSet("SELECT p.id, p.nickname, p.level, p.fraction, p.level, c.id clan_id,
            c.name clan_name, h.id hunt, h.award, h.opened, h.private, DATE_SUB(h.dt, INTERVAL 1 HOUR) dt, h.comment, 
            h.money, h.award, h.dt2, h.state, h.xmoney
            FROM hunt h LEFT JOIN player p ON h.player2 = p.id LEFT JOIN clan c ON p.clan = c.id 
            WHERE h.player = " . self::$player->id . " ORDER BY dt DESC");

        $this->content['wanted'] = array();
        if ($wanted) {
            foreach ($wanted as $want) {
                $want['dt'] = HtmlTools::FormatDateTime($want['dt'], true, false, false);
                if ($want["money"] == 0 || $want["money"] == $want["award"]) {
                    $want["money"] = $want["award"] + 40 * (self::$player->level - 2) * 1;
                }
                $want['award'] = $want['award'];

                $want["logs"] = array();
                $kills = self::$sql->getRecordSet("SELECT player, duel, `kill`, dt FROM huntlog WHERE hunt = " . $want["hunt"] . " ORDER BY dt ASC");
                if ($kills) {
                    foreach ($kills as $kill) {
                        $kill["dt"] = HtmlTools::FormatDateTime($kill['dt'], true, false, false);
						$kill['sk'] = Page::generateKeyForDuel($kill['duel']);
                        $want["logs"][] = $kill;
                    }
                }

                $this->content['wanted'][] = $want;
            }
        }

        $this->content["player"] = self::$player->toArray();

        $this->content['window-name'] = HuntclubLang::WINDOW_TITLE;
        $this->page->addPart('content', 'huntclub/me.xsl', $this->content);
    }

    /**
     * Список заказов для охотников
     */
    private function showWanted()
    {
        if (strtotime(self::$player->huntdt) > time()) {
            Std::loadLib('HtmlTools');

            // логи
            
            $perPage = 20;
			$page = 1;

			$werewolf = 0;
			$this->content['link'] = '';
			for ($i = 1; $i < count($this->url); $i ++) {
				switch ($this->url[$i]) {
					case 'level':
						if ($this->url[$i+1] == "my" || $this->url[$i+1] == "all") {
							Runtime::set("huntclub_levelfilter", ($this->url[$i+1] == "my" ? 1 : 0));
							$this->content['link'] .= '/level/' . $this->url[$i+1];
						}
						$i ++;
						break;

					case 'sort':
						if ($this->url[$i+1] == "award" || $this->url[$i+1] == "dt") {
							$orderBy = $this->url[$i+1];
							Runtime::set("huntclub_orderby", $orderBy);
							$this->content['link'] .= '/sort/' . $this->url[$i+1];
						}
						$i ++;
						break;

					case 'werewolf':
						if (Page::$player2->werewolf == 1) {
							$werewolf = 1;
							$this->content['link'] .= '/werewolf';
						}
						break;

					case 'page':
						if (is_numeric($this->url[$i+1]) && $this->url[$i+1] >= 1) {
							$page = (int)$this->url[$i+1];
						}
						$i ++;
						break;
				}
			}
			$offset = ($page - 1) * $perPage;

			/*if ($this->url[1] == "level" && ($this->url[2] == "my" || $this->url[2] == "all")) {
				Runtime::set("huntclub_levelfilter", ($this->url[2] == "my" ? 1 : 0));
			}

            if ($this->url[1] == "sort" && ($this->url[2] == "award" || $this->url[2] == "dt")) {
                $orderBy = $this->url[2];
                Runtime::set("huntclub_orderby", $orderBy);
            } else {
                $orderBy = Runtime::get("huntclub_orderby");
                if (!$orderBy) {
                    $orderBy = "award";
                }
            }*/
			if (!$orderBy) {
				$orderBy = "award";
			}

            $this->content["cursort_award"] = $orderBy == "award" ? " selected" : "";
            $this->content["cursort_dt"] = $orderBy == "dt" ? " selected" : "";

            $this->content["levelfilter"] = $levelFilter = Runtime::get("huntclub_levelfilter");

			if (Page::$player2->werewolf == 1) {
				$tmp = json_decode(Page::$player2->werewolf_data, true);
				$this->content['werewolf_level'] = $tmp['level'];
			}
			
			if ($werewolf) {
				$whereFraction = '';
				$level = $tmp['level'];
			} else {
				$whereFraction = "h.fraction = '" . (self::$player->fraction == 'resident' ? 'arrived' : 'resident') . "' AND ";
				$level = self::$player->level;
			}

			if ($levelFilter == 1) {
                $whereLevel = "h.level = " . $level;
            } else {
                $whereLevel = "h.level IN (" . ($level - 1) . ", " . $level . ", " . ($level + 1) . ", " . ($level + 2) . ")";
            }

            $wanted = self::$sql->getRecordSet("SELECT p.id, p.nickname, p.level, p.fraction, p.level, c.id clan_id, c.name clan_name, h.award,
                h.dt, h.comment, h.xmoney, h.state, h.id hunt
												FROM hunt h
												FORCE INDEX (ix__hunt__fraction_state)
												LEFT JOIN player p ON h.player = p.id
												LEFT JOIN clan c ON p.clan = c.id
												WHERE " . $whereFraction . " " . $whereLevel . "
												AND h.state IN (0,1) AND player2 != " . self::$player->id . "
												AND p.lasttimeattacked < UNIX_TIMESTAMP() - 3600
												AND p.accesslevel = 0
												AND p.state NOT IN ('police', 'fight', 'frozen')
												AND (p.maxhp = 0 OR round(p.maxhp - ((p.healtime - unix_timestamp()) / (60 / if(p.level = 1, 6, 1))) * (p.maxhp / 30)) >= p.maxhp * 0.35)
												ORDER BY " . $orderBy . "
												DESC LIMIT " . $offset . ", " . $perPage);
            $total = self::$sql->getValue("SELECT count(*)
											FROM hunt h
											FORCE INDEX (ix__hunt__fraction_state)
											LEFT JOIN player p ON h.player = p.id
											WHERE " . $whereFraction . " " . $whereLevel . "
											AND h.state IN (0,1) AND player2 != " . self::$player->id . "
											AND p.lasttimeattacked < UNIX_TIMESTAMP() - 3600
											AND p.accesslevel = 0
											AND p.state NOT IN ('police', 'fight', 'frozen')
											AND (p.maxhp = 0 OR round(p.maxhp - ((p.healtime - unix_timestamp()) / (60 / if(p.level = 1, 6, 1))) * (p.maxhp / 30)) >= p.maxhp * 0.35)
											");

            $this->content['wanted'] = array();
            if ($wanted) {
                foreach ($wanted as $want) {
                    $want['award'] = floor($want['award'] / 3);
                    $want['dt'] = HtmlTools::FormatDateTime($want['dt'], true, false, false);
                    $this->content['wanted'][] = $want;
                }
            }

            $this->content['page'] = $page;
            $this->content['pages'] = Page::generatePages($page, ceil($total / $perPage), 3);

            self::$player->loadAccess();
            $this->content['censor'] = self::$player->access["general_censorship"] == 1 ? 1 : 0;

			$this->content['werewolf'] = $werewolf;
			$this->content['werewolf_can'] = Page::$player2->werewolf;

            $this->content['window-name'] = HuntclubLang::WINDOW_TITLE;
            $this->page->addPart('content', 'huntclub/wanted.xsl', $this->content);
        } else {
            Std::redirect("/huntclub/");
        }
    }

    /**
     * Очистить комментарий в заказе (только для модераторов)
     */
    private function clearZakazComment()
    {
        self::$player->loadAccess();
        if (self::$player->access["general_censorship"] == 1) {
            $id = (int)$this->url[1];
            self::$sql->query("UPDATE hunt SET comment = '' WHERE id = " . $id);
        }
        exit;
    }
}
?>
