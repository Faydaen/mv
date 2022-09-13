<?php
class Home extends Page implements IModule
{
    public $moduleCode = 'Home';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		$this->needAuth();
        //
        switch ($this->url[0])
		{
			case 'collection':
				if ($this->url[1] == 'preview' || $this->url[1] == 'image') {
					$this->showImage((int) $this->url[2], $this->url[1]);
				}
				if ($this->url[2] == 'make') {
					$this->makeCollection((int) $this->url[1]);
					Std::redirect('/home/collection/' . (int) $this->url[1] . '/');
				} else if ($this->url[2] == 'thimble') {
					$this->thimble((int) $this->url[1]);
				} else {
					$this->showCollection((int) $this->url[1]);
				}
				break;

			case 'heal':
				if (self::$player->is_home_available == 1) {
					$this->heal();
				}
                break;

            case 'travma':
                if (self::$player->is_home_available == 1) {
					$this->healTravma();
				}
                break;

            case 'clearrabbits':
                if (self::$player->is_home_available == 1) {
					$this->clearRabbits();
				}
                break;

            case "antirabbit":
                $this->enableAntiRabbit();
                break;

			default:
				$this->showHome();
                break;
		}
        //
        parent::onAfterProcessRequest();
    }

	/*
	 * Игра с Моней на элементы коллекции
	 *
	 * @param int $collectionId
	 */
	public function thimble($collectionId) {
		$collection = Page::$sql->getRecord("SELECT c.*, IFNULL(cp.repeats, 0) done FROM collection c LEFT JOIN collection_player cp ON cp.player = " . self::$player->id . " AND cp.collection = c.id WHERE c.id = " . $collectionId);
		if (!$collection) {
			$this->dieOnError(404);
		}
		$sql = "SELECT ci.collection, SUM(IF(ci.amount <= cip.amount, 1, 0)) as now, COUNT(ci.amount) as needed FROM collection_item ci LEFT JOIN collection_item_player cip ON cip.player = " . self::$player->id . " AND cip.collection_item = ci.id WHERE ci.collection = " . $collectionId . " GROUP BY ci.collection";
		$results = Page::$sql->getRecord($sql);
		if (round($results['now'] / $results['needed'] * 100) < 50 || round($results['now'] / $results['needed'] * 100) == 100) {
			$this->dieOnError(404);
		}
		$baseCost = 5;
		$this->content['monya_cost'] = round($results['needed'] / ($results['needed'] - $results['now']) * $baseCost);

		// выбран сундучок
		if ($_POST['action'] == 'guess' && strlen(self::$player2->naperstkidata) > 10) {
			Page::startTransaction('home_thimble');
			if (self::$player->honey < $this->content['monya_cost']) {
				Page::addAlert(PageLang::ERROR_NO_HONEY, PageLang::ERROR_NO_HONEY_TEXT, $type);
				Std::redirect('/home/collection/' . $collection['id'] . '/');
			}
			$priceHoney = $this->content['monya_cost'];
			$reason	= 'thimble_collection [' . $collection['id'] .'] $' . $priceHoney;
			$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
			
			if ($takeResult[0] != 'OK') {
				Page::addAlert(PageLang::ERROR_NO_HONEY, PageLang::ERROR_NO_HONEY_TEXT, $type);
				Std::redirect('/home/collection/' . $collection['id'] . '/');
			}
			$cell = (int)$_POST['position'];
			if ($cell < 0 || $cell > 2) {
				$cell = 0;
			}
			$sCell = $cell;
			$naperstki = json_decode(self::$player2->naperstkidata, true);
			$this->content['full'] = 0;
			if (isset($naperstki['d'][$cell]) && $naperstki['d'][$cell]['s'] == 0) {
				$naperstki['g']++;
				if ($naperstki['d'][$cell]['r'] == 1) {
					$naperstki['r']++;
					$naperstki['d'][$cell]['s'] = 2;
					$result = 1;
				} else {
					$naperstki['d'][$cell]['s'] = 3;
					$result = 0;
                }
				$nn = $naperstki;
				foreach ($naperstki['d'] as &$cell) {
					$cell = $cell['s'];
				}
                $this->content['naperstkidata'] = $naperstki;
				self::$player2->naperstkidata = '';
				self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKIDATA));

				$sql = "select ci.* from collection_item ci left join collection_item_player cip on cip.collection_item = ci.id and cip.player = " . self::$player->id . " where ci.collection = " . $collection['id'] . " and (cip.player is not null or cip.amount >= ci.amount) order by rand() limit 2";
				$oldItems = Page::$sql->getRecordSet($sql);

				$sql = "select ci.* from collection_item ci left join collection_item_player cip on cip.collection_item = ci.id and cip.player = " . self::$player->id . " where ci.collection = " . $collection['id'] . " and (cip.player is null or cip.amount < ci.amount) order by rand() limit 1";
				$newItem = Page::$sql->getRecord($sql);

				$a = array(0, 1, 2);
				shuffle($a);
				foreach ($a as $i) {
					if ($nn['d'][$i]['r'] == 1) {
						$items[$i] = $newItem;
					} else {
						$items[$i] = array_pop($oldItems);
					}
				}
				ksort($items);
				$item = $items[$sCell];

				// угадал новый элемент
				if ($result) {
					//Page::AddAlert(HomeLang::$thimbleGuessed, Std::renderTemplate(HomeLang::$thimbleGuessedText, array('collection_item' => $item['name'])));
					if ($results['needed'] > $results['now'] + 1) {
						$this->content['monya_cost'] = round($results['needed'] / ($results['needed'] - $results['now'] - 1) * $baseCost);
					} else {
						$this->content['full'] = 1;
					}
				} else {
					// угадан старый элемент
					//unset($oldItems[2]);
					//Page::AddAlert(HomeLang::$thimbleNotGuessed, Std::renderTemplate(HomeLang::$thimbleNotGuessedText, array('collection_item' => $item['name'])));
				}
				$this->content['result'] = $result;
				$this->content['item'] = $item;
				$this->content['items'] = $items;

				$mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                Page::sendLog(self::$player->id, 'ioshi', array('h' => $priceHoney, 'mbckp' => $mbckp), 1);
                
                Page::giveCollectionElement(self::$player->id, $collection, $item['id'], false, false);
            }
			$this->content['finished'] = 1;
			Page::endTransaction('home_thimble');
		} else {
			if (self::$player->honey < $this->content['monya_cost']) {
				Page::addAlert(PageLang::ERROR_NO_HONEY, PageLang::ERROR_NO_HONEY_TEXT, $type);
				Std::redirect('/home/collection/' . $collection['id'] . '/');
			}
			$num = 3;
			$naperstki = array();
			for ($i = 0; $i < $num; $i++) {
				$naperstki[] = array('r' => 0, 's' => 0);
			}
			$r = 1;
			$i = 0;
			while ($i < $r) {
				$n = mt_rand(0, $num - 1);
				if ($naperstki[$n]['r'] == 0) {
					$naperstki[$n]['r'] = 1;
					$i++;
				}
			}

			self::$player2->naperstkidata = json_encode(array(
				'd' => $naperstki,
				'g' => 0,
				'r' => 0,
			));
			self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKIDATA));
			$naperstki = json_decode(self::$player2->naperstkidata, true);
            $game = array('r' => $naperstki['r'], 'g' => $naperstki['g'], 'c' => sizeof($naperstki['d']), 'd' => array());
            foreach ($naperstki['d'] as $cell) {
                $game['d'][] = $cell['s'];
            }
			$this->content['naperstkidata'] = $game;
		}
		
		$this->content['collection'] = $collection;
		$this->content['window-name'] = HomeLang::$thimbleWindowTitle;
		$this->page->addPart('content', 'home/thimble.xsl', $this->content);
	}

    /**
     * Очистка эффектов от негативных подарков
     */
    private function clearRabbits()
    {
        if ($_POST["player"] == self::$player->id) {
            $price = 0;
            $boosts = self::$sql->getRecordSet("SELECT * FROM playerboost2 WHERE player = " . self::$player->id . " AND (
                health < 0 OR strength < 0 OR dexterity < 0 OR intuition < 0 OR resistance < 0 OR attention < 0 OR charism < 0 OR
                ratingcrit < 0 OR ratingdodge < 0 OR ratingresist < 0 OR ratinganticrit < 0 OR ratingdamage < 0 OR ratingaccur < 0
            )");

            if ($boosts) {
                foreach ($boosts as $boost) {
                    $item = self::$sql->getRecord("SELECT honey, ore, time FROM standard_item WHERE code = '" . $boost["code"] . "'");
                    $itemPrice = $item["honey"] > 0 ? $item["honey"] : $item["ore"];
                    $price += ceil((strtotime($boost["dt2"]) - time()) / Page::timeLettersToSeconds($item["time"])) * $itemPrice;
                }

                if (self::$player->honey >= $price) {
                    $reason = 'home clear rabbits $' . $price;
                    $takeResult = self::doBillingCommand(self::$player->id, $price, 'takemoney', $reason, $other);
                    if ($takeResult[0] == 'OK') {
                        self::$player->honey -= $price;
                        self::$player->save(self::$player->id, array(playerObject::$HONEY));

                        foreach ($boosts as $boost) {
                            self::$player->calcStats($boost, -1);
                            self::$sql->query("DELETE FROM playerboost2 WHERE player=" . $boost['player'] . " AND type='" . $boost['type'] . "' AND code='" . $boost['code'] . "'");
                            self::$sql->query("DELETE FROM gift WHERE player=" . $boost['player'] . " AND type = 'gift' AND code='" . $boost['code'] . "'");
                        }

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                        Page::sendLog(self::$player->id, 'rbbt1', array('h' => $price, 'mbckp' => $mbckp), 1);
                        Page::addAlert(HomeLang::ALERT_CLEARRABBITS_TITLE, '<img src="/@/images/obj/antigift.png" align="left" style="margin-right:10px;" />' . HomeLang::ALERT_CLEARRABBITS_TEXT);
                    } else {
                        Page::addAlert(HomeLang::ERROR_NO_HONEY, HomeLang::ERROR_NO_HONEY_TEXT, ALERT_ERROR);
                    }
                } else {
                    Page::addAlert(HomeLang::ERROR_NO_MONEY_TITLE, HomeLang::ERROR_NO_MONEY_CLEARRABBITS, ALERT_ERROR);
                }
            } else {
                Page::addAlert(HomeLang::ERROR, HomeLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            }
        }

        Std::redirect("/home/");
    }

    /**
     * Включение защиты от негативных подарков
     */
    private function enableAntiRabbit()
    {
        if ($_POST["player"] == self::$player->id && strtotime(self::$player->antirabbitdt) < time()) {
            $days = (int)$this->url[1];
            if ($days != 3 && $days != 7) {
                $days = 3;
            }
            $price = Page::$data["home"]["antirabbit" . $days];

            if (self::$player->honey >= $price) {
                $reason = 'home antrabbit ' . $days . ' $' . $price;
                $takeResult = self::doBillingCommand(self::$player->id, $price, 'takemoney', $reason, $other);
                if ($takeResult[0] == 'OK') {
                    self::$player->honey -= $price;
                    self::$player->antirabbitdt = date("Y-m-d H:i:s", (time() + $days * 24 * 60 * 60));
                    self::$player->save(self::$player->id, array(playerObject::$HONEY, playerObject::$ANTIRABBITDT));

                    $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                    Page::sendLog(self::$player->id, 'rbbt2', array('h' => $price, 'd' => $days, 'mbckp' => $mbckp), 1);
                    Page::addAlert(HomeLang::ALERT_OK, '<img src="/@/images/obj/antigift2.png" align="left" style="margin-right:10px;" />' . HomeLang::ALERT_ANTIRABBIT_TEXT);
                } else {
                    Page::addAlert(HomeLang::ERROR_NO_HONEY, HomeLang::ERROR_NO_HONEY_TEXT, ALERT_ERROR);
                }
            } else {
                Page::addAlert(HomeLang::ERROR, HomeLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            }
        }

        Std::redirect("/home/");
    }

    private function healTravma()
    {
		Page::startTransaction('home_healtravma');
        $priceHoney = 5;
        if (self::$player->honey < $priceHoney) {
            Page::addAlert(HomeLang::$errorNoHoney, HomeLang::$errorNoHoneyText, ALERT_ERROR);
            Std::redirect('/home/');
        }

		if (strtotime(self::$player2->travmadt) <= time()) {
			Std::redirect('/home/');
		}

        $reason	= 'travma heal $' . $priceHoney;
        $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);

        if ($takeResult[0] == 'OK') {
            self::$player->honey -= $priceHoney;

            self::$player2->travmadt = date('Y-m-d H:i:s', time());

            self::$player->save(self::$player->id, array(playerObject::$HONEY));
            self::$player2->save(self::$player2->id, array(player2Object::$TRAVMADT));

            Runtime::set('fights', 1);

            $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
            Page::sendLog(self::$player->id, 'trvmhl', array('h' => $priceHoney, 'mbckp' => $mbckp), 1);

            Page::addAlert(HomeLang::ALERT_TRAVMA_HEALED_TITLE, HomeLang::ALERT_TRAVMA_HEALED_TEXT);

            Std::redirect('/home/');
        } else {
            Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
        }
    }

	protected function heal()
	{
		global $data;
		
        if (self::$player->hp < self::$player->maxhp) {
			if (self::$player->money < Page::$data['costs']['heal']['money']) {
                Page::addAlert(HomeLang::$error, 'Не хватает денег для лечения.', ALERT_ERROR);
			} else {
                self::$player->setFullHP();
                self::$player->money -= $data['costs']['heal']['money'];
                self::$player->save(self::$player->id, array(playerObject::$MONEY));
                Page::addAlert(HomeLang::ALERT_HEALED_TITLE, HomeLang::ALERT_HEALED_TEXT);
            }
		} else {
            Page::addAlert(HomeLang::ERROR, HomeLang::ERROR_HP_FULL, ALERT_ERROR);
		}
        Std::redirect('/home/');
	}

	protected function showHome()
	{
		Std::loadModule("Automobile");
		self::$player->loadInventory(array('home_defence', 'home_comfort', 'home_safe'));
		$this->content['homeInventory'] = array();

		if (count(self::$player->home)) {
            foreach (self::$player->home as $item) {
                $itemArray = $item->toArray();
                switch ($itemArray['type']) {
                    case 'home_defence':
                        $itemArray['param'] = HomeLang::STRING_HOME_DEFENCE;
                        $itemArray['value'] = $itemArray['itemlevel'];
                        break;

                    case 'home_comfort':
                        $itemArray['param'] = HomeLang::STRING_HOME_COMFORT;
                        $itemArray['value'] = $itemArray['itemlevel'];
                        break;

                    case 'home_safe':
                        if ($itemArray['unlocked']) {
                            $itemArray['param'] = HomeLang::STRING_SAFE_SAVES;
                            $itemArray['value'] = ($itemArray['itemlevel'] * 100 * self::$player->level) . ' монет';
                            $itemArray['param_period'] = HomeLang::STRING_SAFE_VALID_TILL;
                            $itemArray['value_period'] = date('d.m.Y H:i', $itemArray['dtbuy'] + ($itemArray['code'] == 'safe' ? 14 : 1) * 24 * 60 *60);
                        } else {
                            $itemArray['param'] = HomeLang::STRING_SAFE_CLOSED;
                            $itemArray['value'] = HomeLang::STRING_SAFE_NOT_BEING_USED;
                        }
                        break;
                }
				if ($itemArray['type'] == 'home_safe') {
					$this->content['home_safe'] = $itemArray;
				} else {
                $this->content['homeInventory'][] = $itemArray;
            }
        }
        }
		for ($i = count($this->content['homeInventory']); $i < 8; $i ++) {
			$this->content['homeInventory'][] = array();
		}
		$this->content['player'] = self::$player->toArray();
		$this->content['heal_cost'] = Page::$data['costs']['heal']['money'];
		$max = max ($this->content['player']['home_defence'], $this->content['player']['home_comfort']);
		$this->content['procenthomedefence'] = @floor($this->content['player']['home_defence'] / 40 * 100);
		$this->content['procenthomecomfort'] = @floor($this->content['player']['home_comfort'] / 40 * 100);
		$this->content['player']['home_income'] = self::$player->home_price * (100 + self::$player->home_comfort * 10) / 100;

		// гараж
		$cars = Automobile::getCarsByPlayerId(Page::$player->id, 1);
		if ($cars) {
			$carsCount = sizeof($cars);
		} else {
			$carsCount = 0;
		}
		$this->content["cars"] = array();
		$this->content["cars_count"] = $carsCount;
		Automobile::initModels();
		for ($i = 0; $i < Page::$player2->garage; $i++) {
			$car = array();
			if ($i < $carsCount) {
				$car = $cars[$i];
				$car["image"] = Automobile::$models[$car["model"]]["image"];
			} else {
				$car["id"] = 0;
			}
			$this->content["cars"][] = $car;
		}
		$this->content["garage"] = Page::$player2->garage;
		$this->content["garage_max"] = Page::$player2->garage == sizeof(Automobile::$garage);
		Automobile::initGarage();
		$this->content["garage_cost"] = Automobile::$garage[Page::$player2->garage + 1]["ore"];

        // травмы
        $this->content['travma'] = self::$player2->travma;

        // зайцы
        $price = 0;
        $boosts = self::$sql->getRecordSet("SELECT * FROM playerboost2 WHERE player = " . self::$player->id . " AND (
            health < 0 OR strength < 0 OR dexterity < 0 OR intuition < 0 OR resistance < 0 OR attention < 0 OR charism < 0 OR
            ratingcrit < 0 OR ratingdodge < 0 OR ratingresist < 0 OR ratinganticrit < 0 OR ratingdamage < 0 OR ratingaccur < 0
        )");
        if ($boosts) {
            foreach ($boosts as $boost) {
                $item = Page::sqlGetCacheRecord("SELECT honey, ore, time FROM standard_item WHERE code = '" . $boost["code"] . "'", 3600, 'si_price_by_code_' . $boost['code']);
                $itemPrice = $item["honey"] > 0 ? $item["honey"] : $item["ore"];
                $price += ceil((strtotime($boost["dt2"]) - time()) / Page::timeLettersToSeconds($item["time"])) * $itemPrice;
            }
        }
        $this->content["clearrabbits"] = $price;

        // защита от зайцев
        $this->content["antirabbit"] = strtotime(self::$player->antirabbitdt) > time() ? 1 : 0;
        if ($this->content["antirabbit"] == 1) {
            Std::loadLib("HtmlTools");
            $this->content["antirabbitdt"] = HtmlTools::FormatDateTime(self::$player->antirabbitdt, true, false, false);
        }

        // коллекции
		//$this->content['collections'] = Page::$sql->getRecordSet("SELECT DISTINCT c.id, c.code, c.name, c.image FROM collection c LEFT JOIN collection_item_player cip /*FROM collection_item_player cip LEFT JOIN collection c*/ ON c.id = cip.collection WHERE cip.player = " . self::$player->id . " OR c.addcondition = 1");
		
		$this->content['collections'] = Page::sqlGetCacheRecordSet("SELECT DISTINCT c.id, c.code, c.name, c.image, c.repeats needed, IFNULL(cp.repeats, 0) have FROM collection c LEFT JOIN collection_player cp ON cp.player = " . Page::$player->id . " AND cp.collection = c.id LEFT JOIN collection_item_player cip ON c.id = cip.collection AND cip.player = " . self::$player->id . " WHERE cip.player IS NOT NULL OR c.addcondition = 1", 3600, 'player_collections_' . Page::$player->id . '_new');
			
		$c2 = array();
		if ($this->content['collections']) {
			$ids = array();
			foreach ($this->content['collections'] as $key => &$c) {
				if ($c['code'] == 'teech_necklace' && self::$player->level < 4) {
					continue;
				} else {
					$ids[] = $c['id'];
					$c2[] = $c;
				}
			}
			$sql = "SELECT ci.collection, SUM(IF(ci.amount <= cip.amount, 1, 0)) as now, COUNT(ci.amount) as needed FROM collection_item ci LEFT JOIN collection_item_player cip ON cip.player = " . self::$player->id . " AND cip.collection_item = ci.id WHERE ci.collection IN (" . implode(", ", $ids) . ") GROUP BY ci.collection";
			$results = Page::sqlGetCacheRecordSet($sql, 3600, 'player_collections_progress_' . Page::$player->id);
			if (count($results) && is_array($results))
			foreach ($results as $r) {
				foreach ($c2 as &$c) {
					if ($c['id'] == $r['collection']) {
						//$c['progress'] = 100 - round($r['s'] / $r['ss'] * 100);
						if ($c['needed'] <= $c['have']) {
							$c['progress'] = 100;
						} else {
							$c['progress'] = round($r['now'] / $r['needed'] * 100);
						}
						break;
					}
				}
			}
		}
		$this->content['collections'] = $c2;

        $this->content['window-name'] = HomeLang::WINDOW_TITLE;
		$this->page->addPart('content', 'home/home.xsl', $this->content);
	}

	/*
	 * Показ коллекции
	 *
	 * @param int $collectionId
	 */
	public function showCollection($collectionId)
    {
		$collection = Page::sqlGetCacheRecord("SELECT c.*, IFNULL(cp.repeats, 0) done FROM collection c LEFT JOIN collection_player cp ON cp.player = " . self::$player->id . " AND cp.collection = c.id WHERE c.id = " . $collectionId, 3600, 'player_collection_' . Page::$player->id . '_' . $collectionId);
		if (!$collection) {
			$this->dieOnError(404);
		}
		$collection['conditions'] = json_decode($collection['conditions'], true);
		if (isset($collection['conditions']['repeats'][$collection['done']])) {
			$conditions = $collection['conditions']['repeats'][$collection['done']];
		} else if (isset($collection['conditions']['repeats']['last'])) {
			$conditions = $collection['conditions']['repeats']['last'];
		}
		$needItems = array();
		if (count($conditions))
		foreach ($conditions as $c) {
			if ($c['type'] == 'need_item') {
				$needItems[$c['item']] = $c['amount'];
			}
		}
		if (count($needItems)) {
			$items2 = Page::$sql->getRecordSet("SELECT code, name, image, durability as amount FROM inventory WHERE player = " . self::$player->id . " AND code in ('" . implode("', '", array_keys($needItems)) . "')");
			//foreach ($items2 as &$i) {
				//$i['amount'] = $needItems[$i['code']];
			//}
		}
		
		if ($collection['done'] >= $collection['repeats']) {
			$sql = "SELECT ci.* FROM collection_item ci WHERE ci.collection = " . $collectionId;
		} else {
			$sql = "SELECT ci.id, ci.name, ci.image, ci.collection, ci.amount as amount_needed, IFNULL(cip.amount, 0) as amount FROM collection_item ci LEFT JOIN collection_item_player cip ON ci.id = cip.collection_item AND cip.player = " . self::$player->id . " WHERE ci.collection = " . $collectionId . " and ci.amount > 0 ORDER BY ci.id ASC";
		}
		
		$items = Page::sqlGetCacheRecordSet($sql, 3600, 'player_collection_items_' . Page::$player->id . '_' . $collectionId);
		if (!$items && !$items2 && $collection['addcondition'] == 0) {
			$this->dieOnError(404);
		}

		$sql = "SELECT ci.collection, SUM(IF(ci.amount <= cip.amount, 1, 0)) as now, COUNT(ci.amount) as needed FROM collection_item ci LEFT JOIN collection_item_player cip ON cip.player = " . self::$player->id . " AND cip.collection_item = ci.id WHERE ci.collection = " . $collectionId . " GROUP BY ci.collection";
		$results = Page::sqlGetCacheRecord($sql, 3600, 'player_collection_progress_' . Page::$player->id . '_' . $collectionId);
		if ($results['needed'] > 0 && round($results['now'] / $results['needed'] * 100) >= 50 && round($results['now'] / $results['needed'] * 100) < 100) {
			$this->content['monya'] = 1;
			$baseCost = 5;
			$this->content['monya_cost'] = round($results['needed'] / ($results['needed'] - $results['now']) * $baseCost);
		}

		if ($collection['done'] > 0) {
			$collection['stars'] = array_fill(0, $collection['repeats'], 1);
		}

		$this->content['collection'] = $collection;
		$this->content['items'] = $items;
		$this->content['items2'] = $items2;
		$this->content['now'] = $results['now'] + count($items2); // здесь косяк с зубной коллекцией. надо пофиксить.
		$this->content['needed'] = $results['needed'];

		$this->content['window-name'] = HomeLang::WINDOW_TITLE_COLLECTIONS;
		$this->page->addPart('content', 'home/collection.xsl', $this->content);
	}

	/*
	 * Отображение картинки элемента коллекции
	 *
	 * @param int $collectionItemId
	 * @param string $type
	 */
	public function showImage($collectionItemId, $type)
    {
		/*if ($type != 'preview') {
			$image = Page::$sql->getValue("SELECT ci.image FROM collection_item ci LEFT JOIN collection_item_player cip ON ci.id = cip.collection_item WHERE ci.id = " . $collectionItemId . " AND (cip.player = " . self::$player->id . " OR ci.amount = 0)");
		} else {
			$image = Page::$sql->getValue("SELECT ci.image FROM collection_item ci WHERE ci.id = " . $collectionItemId);
		}*/
		$image = Page::$sql->getValue("SELECT ci.image FROM collection_item ci WHERE ci.id = " . $collectionItemId);
		if (!$image) {
			$this->dieOnError(404);
		}

		$src = "@/images/obj/collections/" . $image;
		if ($type == 'preview') {
			$src .= '.png';
			header('Content-Type: image/png');
		} else if ($type == 'image') {
			$src .= '-picture.jpg';
			header('Content-Type: image/jpeg');
		}
		echo file_get_contents($src);
		exit;
	}

	/*
	 * Собирание элементов коллекции в коллекцию
	 *
	 * @param int $collectionId
	 */
	public function makeCollection($collectionId)
    {
		Page::startTransaction('home_makecollection');
		$sql = "SELECT ci.name, (ci.amount - IFNULL(cip.amount, 0)) as needed FROM collection_item ci LEFT JOIN collection_item_player cip ON cip.player = " . self::$player->id . " AND cip.collection_item = ci.id WHERE ci.collection = " . $collectionId . " AND (cip.player IS NULL OR cip.amount < ci.amount) AND ci.amount > 0";
		$items = Page::$sql->getRecordSet($sql);
		if ($items) {
			// не хватает элементов
			$s = '';
			foreach ($items as $i) {
				$s .= '<li><b>' . $i['name'] . '</b>' . ($i['needed'] > 1 ? ' x ' . $i['needed'] : '') . '</li>';
			}
			Page::addAlert(HomeLang::$alertCollectionMakeNotEnoughError, sprintf(HomeLang::$alertCollectionMakeNotEnoughErrorText, $s));
		} else {
			// коллекция собрана полностью
			$collection = Page::$sql->getRecord("SELECT c.*, IFNULL(cp.repeats, 0) done FROM collection c LEFT JOIN collection_player cp ON cp.player = " . self::$player->id . " AND cp.collection = c.id WHERE c.id = " . $collectionId);

			// коллекция уже была собрана разрешенное количество раз
			if ($collection['repeats'] > 0 && $collection['done'] >= $collection['repeats']) {
				Page::addAlert(HomeLang::$alertCollectionMakeRepeatsError, sprintf(HomeLang::$alertCollectionMakeRepeatsErrorText, $s));
				return;
			}
			$collection['conditions'] = json_decode($collection['conditions'], true);
			// если выполнены не все условия
			if (isset($collection['conditions']['repeats'][$collection['done']])) {
				$conditions = $collection['conditions']['repeats'][$collection['done']];
			} else if (isset($collection['conditions']['repeats']['last'])) {
				$conditions = $collection['conditions']['repeats']['last'];
			}
			if (Page::checkConditions(self::$player, $conditions, $results) == false) {
				$results = Page::translateConditions($results);
				$resultsStr = '';
				foreach ($results as $r) {
					if (is_string($r)) {
						$resultsStr .= '<li>' . $r . '</li>';
					} else if (isset($r['text'])) {
						$resultsStr .= '<li>' . $r['text'] . '</li>';
					} else if ($r['type'] == 'image') {
						$images .= '<span class="object-thumb">
								<img src="/@/images/obj/' . $r['image'] . '" alt="' . htmlspecialchars($r['name']) . '" title="' . htmlspecialchars($r['name']) . '" />
								<div class="count">#' . (isset($r['amount']) ? $r['amount'] : 1) . '</div>
							</span>';
					}
				}
				Page::addAlert(PageLang::$alertConditionsError, Lang::renderText(PageLang::$alertConditionsErrorText, array('conditions' => $resultsStr)) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : ''));
				return;
			}
			// награда
			$collection['reward'] = json_decode($collection['reward'], true);
			if (isset($collection['reward']['repeats'][$collection['done']])) {
				$reward = $collection['reward']['repeats'][$collection['done']];
			} else if (isset($collection['reward']['repeats']['last'])) {
				$reward = $collection['reward']['repeats']['last'];
			}
			Page::doActions(self::$player, $reward);

			// поп-ап
			$results = Page::translateActions($reward);
			$resultsStr = '';
			foreach ($results as $r) {
				if (is_string($r)) {
					$resultsStr .= '<li>' . $r . '</li>';
				}
			}
			Page::addAlert(PageLang::$alertCollectionMade, Lang::renderText($collection['made_text'], array('reward' => $resultsStr)) . '<div class="clear objects" align="center"><img src="/@/images/obj/collections/' . $collection['image_reward'] . '" /></div>', ALERT_INFO, array(array('url' => '/player/' . self::$player->id . '/', 'name' => 'Мой профиль')));

			// отметка о выполнении
			$sql = "INSERT INTO collection_player (collection, player, repeats) VALUES(" . $collection['id']. ", " . self::$player->id . ", 1) ON DUPLICATE KEY UPDATE repeats = " . ((int) $collection['done'] + 1);
			Page::$sql->query($sql);

			// удаление элементов
			$sql = "SELECT ci.id, IF(cip.amount - ci.amount > 0, 'decrease', 'delete') action, ci.amount FROM collection_item ci LEFT JOIN collection_item_player cip ON cip.collection_item = ci.id AND cip.player = " . self::$player->id . " WHERE ci.collection = " . $collection['id'];
			$items = Page::$sql->getRecordSet($sql);
			$toDelete = $toDecrease = array();
			if (is_array($items) && count($items))
			foreach ($items as $i) {
				if ($i['action'] == 'delete') {
					$toDelete[] = $i['id'];
				} else {
					$toDecrease[] = $i['id'];
					$decrement = $i['amount'];
				}
			}
			if (count($toDecrease)) {
				$sql = "UPDATE collection_item_player SET amount = amount - " . $decrement . " WHERE player = " . self::$player->id . " AND collection_item IN (" . implode(", ", $toDecrease) . ")";
				Page::$sql->query($sql);
			}
			if (count($toDelete)) {
				$sql = "DELETE FROM collection_item_player WHERE player = " . self::$player->id . " AND collection_item IN (" . implode(", ", $toDelete) . ")";
				Page::$sql->query($sql);
			}

			// лог
			Page::sendLog(self::$player->id, 'col_made', array('n' => $collection['name']));

			//Page::$cache->delete("snowy_player_gifts_" . Page::$player->id);
			CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));
			
			Page::$cache->delete('player_collections_' . Page::$player->id);
			Page::$cache->delete('player_collections_progress_' . Page::$player->id);
			
			Page::$cache->delete('player_collection_' . Page::$player->id . '_' . $collectionId);
			Page::$cache->delete('player_collection_items_' . Page::$player->id . '_' . $collectionId);
			Page::$cache->delete('player_collection_progress_' . Page::$player->id . '_' . $collectionId);
		}
	}
}
?>
