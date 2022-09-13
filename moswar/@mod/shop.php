<?php
class Shop extends Page implements IModule
{
	public $moduleCode = 'Shop';
	public static $sections = array (
		'pharmacy' => array('name' => 'Киоск', 'types' => array('drug','drug2')),
		'gifts' => array('name' => 'Подарки', 'types' => array('gift','gift2')),
		'home' => array('name' => 'Для дома', 'types' => array('home_defence','home_comfort', 'home_safe')),
		'clan' => array('name' => 'Кланам', 'types' => array('', 'pet', 'usableitem')),
		'zoo' => array('name' => 'Зоомагазин', 'types' => array('pet', 'petfood', 'petautofood')),
		'other' => array('name' => 'Другое', 'types' => array('pick', 'metro', 'usableitem', 'autousableitem')),
		
		'weapons' => array('name' => 'Оружие', 'types' => array('weapon')),
		'clothes' => array('name' => 'Одежда', 'types' => array('cloth')),
		'hats' => array('name' => 'Шапки', 'types' => array('hat')),
		'shoes' => array('name' => 'Обувь', 'types' => array('shoe')),
		'pouches' => array('name' => 'Сумки', 'types' => array('pouch')),
		'mine' => array('name' => 'Мои вещи', 'types' => array('mine')),

		'jewellery' => array('name' => 'Украшения', 'types' => array('jewellery')),
		'perfumery' => array('name' => 'Парфюмерия', 'types' => array('cologne')),
		'accessories' => array('name' => 'Аксессуары', 'types' => array('accessory1')),
		'talismans' => array('name' => 'Талисманы', 'types' => array('talisman')),
		'tech' => array('name' => 'Техника', 'types' => array('tech')),
                'rings' => array('name' => 'Кольца','types' => array('ring')),
		array('name' => 'spacer'),
	);
	public static $section;
	public static $sell_procent = 0.25;

    public function __construct()
    {
        parent::__construct();

        if (DEV_SERVER) {
            self::$sections['other']['types'][] = 'docs';
        }
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		$this->needAuth();

        Std::loadMetaObjectClass('standard_object');
        
		$this->processServiceRequests();

        Shop::$section = key(Shop::$sections);

        if ($this->url[0] == 'special') {
            $this->showSpecial();
        } else {
            for ($i = 0; $i < count($this->url); $i ++) {
                // покупка
                if ($this->url[$i] == 'buy' && is_numeric($this->url[$i+1])) {
					Std::loadModule('Player');
					$item = (int) $this->url[++ $i];
					$amount = abs((int) $this->url[++ $i]);
					if ($amount <= 0) {
						$amount = 1;
					}
					Std::loadModule('PlayerAdmin');
					PlayerAdmin::adminAddPlayerComment(self::$player->id, 'Замечен бот', '', Std::renderTemplate(ShopLang::$noticeBotDeteced, array('id' => $item, 'amount' => $amount, 'name' => Page::$sql->getValue("SELECT name FROM standard_item WHERE id = " . (int) $item))), false);
                    $result = Shop::buy($item, $amount);
                // продажа
                /*} elseif ($this->url[$i] == 'sell' && (is_numeric($this->url[$i+1]) || $this->url[$i+1] == 'pet')) {
                    $result = Shop::sell($this->url[++ $i]);
				*/
                // определение раздела
                } elseif ($this->url[$i] == 'section' && isset(Shop::$sections[$this->url[$i+1]])) {
                    Shop::$section = $this->url[++ $i];

                // автоподстановка получателя подарка
                } elseif ($this->url[$i] == 'present' && isset($this->url[$i+1]) && isset($this->url[$i+2])) {
                    $this->content['present'] = array('playerid' => (int)$this->url[$i+1], 'playername' => $this->url[$i+2]);
                }
            }
			if (@$_POST['action'] == 'buy') {
				$result = Shop::buy((int) $_POST['item'], abs((int) $_POST['amount']), ($_POST['type'] == 'normal' || $_POST['type'] == 'honey') ? $_POST['type'] : 'normal');
			} else if (@$_POST['action'] == 'sell') {
				if ($_POST['item'] != 'pet') {
					$_POST['item'] = (int) $_POST['item'];
				}
				$result = Shop::sell($_POST['item']);
			}
			if (is_array($result)) {
				Runtime::set('content/result', $result);
				if ($_POST['return_url']) {
					Std::redirect($_POST['return_url']);
				} else {
					Std::redirect($result['url']);
				}
			}
            $this->showShop();
        }
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Обработка служебных запросов
     */
    private function processServiceRequests()
    {
        switch ($this->url[0]) {
            case 'playerexists':
                $nickname = Std::cleanString($this->url[1]);
                echo Page::getPlayerId($nickname) ? 1 : 0;
                exit;
                break;

            case 'playeridexists':
                echo $this->sqlGetValue("SELECT count(*) FROM player WHERE id=" . (int)$this->url[1]);
                exit;
                break;
        }
    }

    /**
     * Покупка предмета
     *
     * @param int $id
	 * @param int $amount
	 * @param string $type
     * @return array
     */
	public static function buy($id, $amount = 1, $type = "") {
		// защита от РВС подарков
		if (trim($_POST["key"]) != self::getPostKey()) {
			Std::redirect("/shop/"); exit;
		}

		Page::startTransaction('shop_buy');

		if (Page::$cache->get('shopboughts/' . self::$player->id) === false) {
			Page::$cache->set('shopboughts/' . self::$player->id, 1, 2);
		} else {
			$result['result'] = 0;
			return $result;
		}

		if ($amount == 0) {
			$amount = 1;
		}

		$result = array('type' => 'shop', 'action' => 'buy');
		$result['url'] = '/shop/section/' . Shop::$section . '/';

		Std::loadMetaObjectClass('standard_item');
		$standard_item = new standard_itemObject();
		
        // проверка: есть ли такая вещь вообще?
        if (!$standard_item->load($id)) {
			$result['result'] = 0;
			$result['error'] = 'item not found';
			return $result;
		}

		//if (self::$section == 'clan') {
		if ($standard_item->type2 == 'clan') {
            return self::buyClan($id, $amount);
        }
		
		if ($standard_item->stackable == 0) {
			$amount = max($standard_item->durability, 1);
		}

        if (($standard_item->buyable == 0 && self::$player->accesslevel < 100) || ($standard_item->sex != '' && $standard_item->sex != self::$player->sex)) {
			$result['result'] = 0;
			$result['error'] = 'item is not buyable';
			return $result;
		} else if (self::$player->money < ($standard_item->money * $amount) || !self::$player->isEnoughOreHoney($standard_item->ore * $amount) || (self::$player->honey < ($standard_item->honey * $amount) && ($standard_item->shop == 'shop' || ($standard_item->shop == 'berezka' && $type == 'honey') )) ) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		} else if (self::$player->level < $standard_item->level && !(self::$player->level >= 4 && self::$player->level + 1 >= $standard_item->level && !empty($standard_item->slot))) {
			$result['result'] = 0;
			$result['error'] = 'low level';
			return $result;
		} else {
            $playerid = self::$player->id;
            if ($standard_item->type == 'gift' || $standard_item->type == 'gift2' || $standard_item->type == 'ring') {
		if (isset($_POST['me'])) {
                    $playerid = self::$player->id;
                } elseif ($_POST['playerid'] != '') {
                    $playerid = (int)$_POST['playerid'];
                } else {
                    $playerid = Page::getPlayerId($_POST['player']);
                    if ($playerid == false) {
                        $result['result'] = 0;
                        $result['error'] = 'player with this nickname not found';
                        return $result;
                    }
                }
				if (substr($standard_item->code, 0, 12) == 'wedding_ring') {
					if (Page::$player->sex == Page::$sql->getValue("SELECT sex FROM player WHERE id = " . $playerid)) {
						$result['result'] = 0;
						Page::addAlert(ShopLang::ERROR, ShopLang::ERROR_WEDDING_RING_BAD_SEX, ALERT_ERROR);
						return $result;
					}
					if (Page::$sql->getValue("SELECT COUNT(1) FROM gift WHERE player = " . $playerid . " AND SUBSTR(code, 1, 12) = 'wedding_ring'") > 0) {
						$result['result'] = 0;
						Page::addAlert(ShopLang::ERROR, ShopLang::ERROR_WEDDING_RING_PLAYER_ALREADY_HAS_RING, ALERT_ERROR);
						return $result;

					}
				}
            }

			self::$player->loadInventory();
            if (!in_array($standard_item->type, array('gift','gift2','home_comfort','home_defence','home_safe','pouch','ring')) && !self::$player->hasFreeSpaceForItem($standard_item->id, $standard_item->stackable, $amount)) {
				$result['result'] = 0;
				$result['error'] = 'full inventory';
				return $result;
			} else if ($standard_item->isNegativeGift() && strtotime(self::$sql->getValue("SELECT antirabbitdt FROM player WHERE id = " . $playerid)) > time()) {
				$result['result'] = 0;
				//$result['error'] = 'pet exists';
                Page::addAlert(ShopLang::ERROR, ShopLang::ERROR_ANTIRABBIT, ALERT_ERROR);
				return $result;
			} else if ((strtotime($standard_item->shopdt1) > 0 && strtotime($standard_item->shopdt1) > time()) ||
                    (strtotime($standard_item->shopdt2) > 0 && strtotime($standard_item->shopdt2) < time())) {
				$result['result'] = 0;
                Page::addAlert(ShopLang::ERROR, ShopLang::ERROR_DT, ALERT_ERROR);
				return $result;

            // проверка для доп эмиссии новогодних подарков 2011
            } else if (substr($standard_item->code, 0, 14) == "present_ny2011" &&
                self::$sql->getValue("SELECT count(*) FROM gift WHERE player = " . $playerid . " AND substring(code, 1, 14) = 'present_ny2011'") >= 90) {
				$result['result'] = 0;
                Page::addAlert(ShopLang::ERROR, ShopLang::ERROR_MANYNY2011GIFTS, ALERT_ERROR);
				return $result;

			} else if ($standard_item->type == "gift" && self::$sql->getValue("SELECT denyblackgifts FROM player2 WHERE player = " . $playerid) == 1 && self::$sql->getValue("SELECT count(*) FROM contact WHERE player = " . $playerid . " AND player2 = " . self::$player->id . " AND type='black'") > 0) {
				$result['result'] = 0;
				//$result['error'] = 'pet exists';
                Page::addAlert(ShopLang::ERROR, ShopLang::ERROR_BLACKGIFTDENIED, ALERT_ERROR);
				return $result;
			} else if ($standard_item->type == 'pet' && Page::$sql->getValue("SELECT 1 FROM pet WHERE player = " . Page::$player->id . " AND item = " . $standard_item->id) == 1) {
				$result['result'] = 0;
				$result['error'] = 'pet exists';
				return $result;
			} else if ($standard_item->type == 'pet' && Page::$sql->getValue("SELECT count(1) FROM pet WHERE player = " . Page::$player->id) >= 3) {
				$result['result'] = 0;
				$result['error'] = 'pet full';
				return $result;
			} else if ($standard_item->type == 'home_safe' && ($safe = self::$player->getItemByType('home_safe')) != false && $safe->code == 'safe2' && $safe->unlocked == 0) {
				//if ($safe->unlocked == 0) {
					Page::addAlert(ShopLang::ERROR, ShopLang::$lockedQuestSafeExists, ALERT_ERROR);
					$result['result'] = 0;
					return $result;
				//}
				//Page::addAlert(ShopLang::ERROR, ShopLang::$safeExists, ALERT_ERROR);
				//$result['result'] = 0;
				//$result['error'] = 'safe exists';
				//return $result;
			} else if ($standard_item->sex != self::$player->sex && $standard_item->sex != '') {
				$result['result'] = 0;
				$result['error'] = 'sex error';
				return $result;
			} else if (($standard_item->type == 'home_defence' || $standard_item->type == 'home_comfort') && count(self::$player->home) - Page::$player->hasSafe >= 8) {
				$result['result'] = 0;
				$result['error'] = 'no free slots for home';
				return $result;
			} else if (($standard_item->type == 'home_defence' || $standard_item->type == 'home_comfort') && self::$player->is_home_available == 0) {
				$result['result'] = 0;
				$result['error'] = 'you have not home';
				return $result;
			} else {
				if ($standard_item->uniq == 1) {
					$item = self::$player->getItemByStandard($id);
					if ($item !== false) {
						$result['result'] = 0;
						$result['error'] = 'you already have this uniq item';
						return $result;
					}
				}

				if ($standard_item->shop == 'berezka' && $type == 'normal') {
					$additionalCurrencies = array();
					if ($standard_item->warzub > 0) {
						$additionalCurrencies['warzub'] = 'war_zub';
						$property['war_zub'] = 0;
					}
					if ($standard_item->wargoldenzub > 0) {
						$additionalCurrencies['wargoldenzub'] = 'war_goldenzub';
						$property['war_goldenzub'] = 0;
					}
					if ($standard_item->huntbadge > 0) {
						$additionalCurrencies['huntbadge'] = 'huntclub_badge';
						$property['huntclub_badge'] = 0;
					}
					if ($standard_item->huntmobile > 0) {
						$additionalCurrencies['huntmobile'] = 'huntclub_mobile';
						$property['huntclub_mobile'] = 0;
					}
					if ($standard_item->stars > 0) {
						$additionalCurrencies['stars'] = 'fight_star';
						$property['fight_star'] = 0;
					}
					if (count($additionalCurrencies)) {
						$tmp = Page::$sql->getRecordSet("SELECT code, sum(durability) as amount FROM inventory WHERE player = " . self::$player->id . " and code in ('" . implode("' , '", $additionalCurrencies) . "') group by code");
						if ($tmp)
						foreach ($tmp as $i) {
							$property[$i['code']] = (int) $i['amount'];
						}
						foreach ($additionalCurrencies as $c => $v) {
							if ($property[$v] < $standard_item->{$c} * $amount) {
								$result['result'] = 0;
								$result['error'] = 'no money';
								return $result;
							}
						}
					}
				} else if ($standard_item->shop == 'berezka' && $type == 'honey' && $standard_item->honey <= 0) {
					$result['result'] = 0;
					$result['error'] = 'no money';
					return $result;
				}

				// вычисление сумм
                $priceMoney = $standard_item->money * $amount;
				if (($standard_item->shop == 'berezka' && $type == 'honey') || $standard_item->shop == 'shop') {
					
					$priceHoney = $standard_item->honey * $amount;
					
				} else {
					$priceHoney = 0;
				}
                if (self::$player->ore >= $standard_item->ore * $amount) {
                    $priceOre = $standard_item->ore * $amount;
                } else {
                    $priceOre = self::$player->ore;
                    $priceHoney += ($standard_item->ore * $amount - $priceOre);
                    $priceHoneyOre = ($standard_item->ore * $amount - $priceOre); // для логов
                }

				if ($type == 'normal' && $standard_item->shop == 'berezka' && $standard_item->oil>0) {
					if (self::$player->oil >= $standard_item->oil * $amount) {
						$priceOil = $standard_item->oil * $amount;
					} else {
						$result['result'] = 0;
						$result['error'] = 'no money';
						return $result;
						/*
						$priceOil = self::$player->oil - (self::$player->oil %  5);
						$priceHoney = ($standard_item->oil * $amount - $priceOil) / 5;
						$priceHoneyOil = ($standard_item->oil * $amount - $priceOil) / 5; // для логов
						*/
					}
				} else if ($standard_item->shop != 'berezka' && $standard_item->oil > 0) {
					if (self::$player->oil >= $standard_item->oil * $amount) {
						$priceOil = $standard_item->oil * $amount;
					} else {
						$priceOil = self::$player->oil;
						$priceHoney += ceil(($standard_item->oil * $amount - $priceOil) / 5);
						$priceHoneyOil = ($standard_item->oil * $amount - $priceOil); // для логов
					}
				}

                if ($priceHoney > 0) {
                    $reason	= 'shop [' . $standard_item->id . ($amount > 1 ? ' x ' . $amount : '') . '] h' . $priceHoney . ' (o' . (int)$priceHoneyOre . ' + n' . (int)$priceHoneyOil . ') + o' . $priceOre . ' + n' . $priceOil . ' + m' . $priceMoney;
                    $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                }

                if ($takeResult[0] == 'OK' || $priceHoney == 0) {
                    self::$player->money -= $priceMoney;
                    self::$player->ore -= $priceOre;
					self::$player->oil -= $priceOil;
                    self::$player->honey -= $priceHoney;

					if (count($additionalCurrencies)) {
						foreach ($additionalCurrencies as $c => $v) {
							if ($property[$v] - $standard_item->{$c} * $amount == 0) {
								$sql = "delete from inventory where player = " . self::$player->id . " and code = '" . $v . "'";
							} else {
								$sql = "update inventory set durability = durability - " . ($standard_item->{$c} * $amount) . ", maxdurability = maxdurability - " . ($standard_item->{$c} * $amount) . " where player = " . self::$player->id . " and code = '" . $v . "'";
							}
							Page::$sql->query($sql);
						}
					}

					// подарок
                    if ($standard_item->type == 'gift' || $standard_item->type == 'gift2' || $standard_item->type == 'ring') {
                        $player = self::$sql->getRecord("SELECT p.id, p.nickname, p.level, p.fraction, p2.approvegifts FROM player p
                            LEFT JOIN player2 p2 ON p2.player = p.id WHERE p.id = " . $playerid);
                        if (self::$player->level >= 3) {
                            $comment = mb_substr($_POST['comment'], 0, 200, "UTF-8");
                            $comment = htmlspecialchars(iconv("windows-1251", "utf-8", wordwrap(iconv("utf-8", "windows-1251", $comment), 18, " ", true)));
                        } else {
                            $comment = "";
                        }
						$hidden = ((self::$player && self::$player->id != $playerid) && $standard_item->type != "gift2" && $player["approvegifts"]);

						$anonymous = (isset($_POST['anonimous']) ? 1 : 0);
						if (substr($standard_item->code, 0, 12) == 'wedding_ring') {
							$standard_item->type = 'gift';###
							$anonymous = 0;
							$hidden = 1;
						}
						$giftId = $standard_item->giveGift(self::$player->nickname, self::$player->id,  $playerid, $comment, $anonymous, (isset($_POST['private']) ? 1 : 0), $hidden);
						//Page::$cache->delete("snowy_player_gifts_" . $playerid);
						//CacheManager::delete('player_gifts', array('player_id' => $playerid));
                    }
					// питомец
					elseif ($standard_item->type == 'pet') {
						$item = $standard_item->givePet(self::$player->id);
                    } elseif ($standard_item->stackable == 1) {
                        self::$player->giveItems($standard_item->id, $amount);
						$item = $standard_item;
/*
$item = self::$player->getItemByStandard($id);
if ($item !== false) {
    $item->maxdurability += $amount;
    $item->durability += $amount;
    $item->save();
} else {
    $item = $standard_item->makeExample($playerid);
    $item->maxdurability += ($amount - 1);
    $item->durability += ($amount - 1);
    $item->save();
}
*/
                    } else if ($amount > 1) {
						for ($i = 1; $i <= $amount; $i ++) {
							$item = $standard_item->makeExample($playerid);
						}
						$item = $standard_item;
                    } else if (!$safe) {
						$item = $standard_item->makeExample($playerid);
					}

                    $mbckp = self::$player->getMbckp();

                    // применение влияний
                    if ($item->type == 'home_comfort') {
                        self::$player->home_comfort += $item->itemlevel;
                        self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE, playerObject::$OIL, playerObject::$HOME_COMFORT));
                    } elseif ($item->type == 'home_defence') {
                        self::$player->home_defence += $item->itemlevel;
                        self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE, playerObject::$OIL, playerObject::$HOME_DEFENCE));
                    } else if ($standard_item->type == 'home_safe' && $safe->type == 'home_safe') {
						if ($safe->code == 'safe2') {
							$duration = 3600 * 24;
						} else {
							$duration = 3600 * 24 * 14;
						}
						$safe->dtbuy += $duration;
						$safe->code = 'safe';
						$safe->save($safe->id, array(inventoryObject::$DTBUY, inventoryObject::$CODE));
						self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE, playerObject::$OIL));
					} else {
                        self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE, playerObject::$OIL));
                    }

                    // логи
                    if ($standard_item->type == 'gift' || $standard_item->type == 'gift2') {
                        //$comment = htmlspecialchars($_POST['comment']);
                        //if ($player["level"] < 3) {
                        //    $comment = "";
                        //}
						// подарок с негативным воздействием
                        if ($standard_item->code == 'febriary23_gift_3' || $standard_item->code == 'unluck_rabbit' || $standard_item->code == 'gift_piggy') {
                            Page::sendLog($player["id"], 'gift_taken', array('player' => array('id' => self::$player->id, 'nickname' => self::$player->nickname, 'level' => self::$player->level, 'fraction' => self::$player->fraction), 'name' => $standard_item->name, 'id' => $giftId, 'cmnt' => $comment, 'image' => $standard_item->image), 0);
                        }
						// подарок
						else {
							if ($hidden) {
								Page::sendLog($player["id"], 'gift_approve', array('player' => ($anonymous ? '' : array('id' => self::$player->id, 'nickname' => self::$player->nickname, 'level' => self::$player->level, 'fraction' => self::$player->fraction)), 'name' => $standard_item->name, 'id' => $giftId, 'cmnt' => $comment, 'image' => $standard_item->image), 0);
							} else {
								Page::sendLog($player["id"], 'gift_taken', array('player' => ($anonymous ? '' : array('id' => self::$player->id, 'nickname' => self::$player->nickname, 'level' => self::$player->level, 'fraction' => self::$player->fraction)), 'name' => $standard_item->name, 'id' => $giftId, 'cmnt' => $comment, 'image' => $standard_item->image), 0);
							}
                        }
                        Page::sendLog(self::$player->id, 'gift_gaven', array('player' => array('id' => $player["id"], 'nickname' => $player["nickname"], 'level' => $player["level"], 'fraction' => $player["fraction"]), 'name' => $standard_item->name, 'ore' => $priceOre, 'money' => $priceMoney, 'honey' => $priceHoney, 'mbckp' => $mbckp), 1);
                    } else {
						$log = array('name' => ($item->name == null ? $standard_item->name : $item->name), 'money' => $priceMoney, 'honey' =>  $priceHoney, 'ore' => $priceOre,'oil'=>$priceOil, 'amount' => $amount, 'mbckp' => $mbckp, 'image' => $standard_item->image);
						if (count($additionalCurrencies)) {
							foreach ($additionalCurrencies as $c => $v) {
								$log[$v] = $standard_item->{$c} * $amount;
							}
						}
                        Page::sendLog(self::$player->id, 'item_bought', $log, 1);
                    }
                    $result['result'] = 1;
                } else {
                    $result['result'] = 0;
                    Page::addAlert(ShopLang::$errorNoHoney, ShopLang::$errorNoHoneyText);
                }

				return $result;
			}
		}
	}

    /**
     * Покупка предмета
     *
     * @param int $id
     * @return array
     */
	public static function buyClan($id, $amount) {
		$result = array(
            'type' => 'shop',
            'action' => 'buy',
            'url' => '/shop/section/' . Shop::$section . '/',
        );

		Std::loadMetaObjectClass('standard_item');
		$standard_item = new standard_itemObject();

        // проверка: есть ли такая вещь вообще?
        if (!$standard_item->load($id) || $standard_item->type2 != 'clan') {
			$result['result'] = 0;
			$result['error'] = 'item not found';
			return $result;
		}

        // проверка: игрок глава клана или нет
        /*if ((int)self::$player->clan < 1 || self::$player->clan_status != 'founder') {
            $result['result'] = 0;
			$result['error'] = 'not_clan_founder';
            return $result;
        }*/

        Std::loadMetaObjectClass('clan');
        $clan = new clanObject();
        $clan->load(self::$player->clan);
        $clan->loadInventory();

        Std::loadModule('Clan');

        if ($standard_item->buyable == 0 && self::$player->accesslevel < 100) {
			$result['result'] = 0;
			$result['error'] = 'item is not buyable';
			return $result;
		} elseif ($clan->money < ($standard_item->money * $amount) || ($clan->ore + $clan->honey) < ($standard_item->ore * $amount) || $clan->honey < ($standard_item->honey * $amount)) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		} elseif (self::$player->level < $standard_item->level) {
			$result['result'] = 0;
			$result['error'] = 'low level';
			return $result;
        } elseif ($clan->level < $standard_item->clanlevel) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, ClanLang::$errorLowClanLevel, ALERT_ERROR);
			return $result;
        } elseif ($clan->inventoryAmount >= $clan->inventoryCapacity && $standard_item->maxdurability > 0 && !isset($clan->inventory[$standard_item->code])) {
			$result['result'] = 0;
			Page::addAlert(ShopLang::$error, ($clan->inventoryCapacity == 0 ? 'Чтобы покупать мелкие предметы, нужно купить клановый склад.' : 'На складе Вашего клана нет свободного места.'), ALERT_ERROR);
            //$result['error'] = 'full inventory';
			return $result;
        } elseif ($clan->founder != self::$player->id && Clan::hasRole('money', self::$player->clan) == 0) {
			$result['result'] = 0;
			Page::addAlert(ShopLang::$error, 'Только Глава клана, Заместитель главы и Казначей могут покупать вещи в этом отделе.', ALERT_ERROR);
            //$result['error'] = 'full inventory';
			return $result;
        } elseif (isset($clan->inventory[$standard_item->code]) && $standard_item->maxdurability == 0) {
            $result['result'] = 0;
			$result['error'] = 'you already have this uniq item';
            return $result;
		} else {
			if ($standard_item->type == 'pet') {
                $item = $standard_item->givePetClan($clan->id);
            } elseif ($standard_item->stackable == 1 || $standard_item->uniq == 1) {
                if (isset($clan->inventory[$standard_item->code])) {
                    $item = $clan->inventory[$standard_item->code];
                    $item->maxdurability += $amount;
                    $item->durability += $amount;
                    $item->save();
                } else {
                    $item = $standard_item->makeExampleClan($clan->id);
					$item->maxdurability += ($amount - 1);
                    $item->durability += ($amount - 1);
                    $item->save();
                }
            } else {
                $item = $standard_item->makeExampleClan($clan->id);
            }

            $itemLog = array('n' => $standard_item->name);
			if ($amount > 1) {
				$itemLog['a'] = $amount;
			}

            // трата денег
            $priceMoney = $standard_item->money * $amount;
            $clan->money -= $priceMoney;
            $itemLog['m'] = $priceMoney;
            $priceHoney = $standard_item->honey * $amount;
            $clan->honey -= $priceHoney;
            $itemLog['h'] = $priceHoney;
            $priceOre = $standard_item->ore * $amount;
            if ($clan->ore >= $priceOre) {
                $clan->ore -= $priceOre;
                $itemLog['o'] = $priceOre;
                $priceOreHoney = 0;
            } else {
                $priceOre = (int)$clan->ore;
                $itemLog['o'] = $priceOre;
                $clan->ore = 0;
                $priceOreHoney = $standard_item->ore * $amount - $priceOre;
                $clan->honey -= $priceOreHoney;
                $itemLog['h'] += $priceOreHoney;
            }
            $clan->save($clan->id, array(clanObject::$MONEY, clanObject::$ORE, clanObject::$HONEY));

            // 
            if ($standard_item->code == 'clan_attack') {
                $clan->attack = $standard_item->itemlevel;
            } elseif ($standard_item->code == 'clan_defence') {
                $clan->defence = $standard_item->itemlevel;
            }
            $clan->save($clan->id, array(clanObject::$ATTACK, clanObject::$DEFENCE));

            // логи
            Page::sendLog(self::$player->id, 'item_bought', array('name' => $item->name, 'money' => $priceMoney, 'honey' =>  ($priceHoney + $priceOreHoney), 'ore' => $priceOre, 'amount' => $amount), 1);
            Std::loadModule('Clan');
            Clan::sendClanLog('buy', array('p' => self::$player->exportForLogs(), 'i' => $itemLog), self::$player->id, self::$player->clan);

            $result['result'] = 1;

            return $result;
        }
	}

    /**
     * Продажа предмета
     *
     * @param int $id
     * @return array
     */
	public static function sell($id)
    {
		$result = array('type' => 'shop', 'action' => 'sell');
		$result['url'] = '/shop/section/' . Shop::$section . '/';

		//$item = self::$player->loadItemByStandardId($id);
		if (is_numeric($id)) {
			$item = self::$player->loadItemById($id);
			if (!$item) {
				$type = 'not found';
			} else {
				if ($item && $item->equipped == 1) {
					$result['result'] = 0;
					$result['error'] = 'item is dressed';
					return $result;
				}

				if ($item && $item->sellable == 0) {
					$result['result'] = 0;
					$result['error'] = 'item is not sellable';
					return $result;
				}

				$type = 'simple item';
				$name = $item->name;
			}
		}
		if ($id == 'pet') {
			$type = 'not found';
			$pet = self::$sql->getRecord("SELECT item, name FROM pet WHERE player = " . self::$player->id);
			if ($pet) {
				$type = 'pet';
				$name = $pet['name'];
			}
		}
		if ($type == 'not found') {
			$result['result'] = 0;
			$result['error'] = 'item not found';
			return $result;
		}
		if ($item->stackable == 1) {
			$type = 'stackable item';
		}

		$sellcost = self::$sql->getValue("SELECT sellcost FROM standard_item WHERE id = " . $item->standard_item);
		if (!empty($sellcost)) {
			$costs = explode(" ", $sellcost);
			foreach ($costs as $itemCost) {
				preg_match("!(\d+)(\w+)!", $itemCost, $matches);
				if (sizeof($matches) == 3) {
					$price[$matches[2]] += $matches[1];
				}
			}
		} else {
			if ($id == 'pet') {
				exit;
				$price = self::$sql->getRecord("SELECT id, name, money, ore FROM standard_item WHERE id = " . $pet['item']);
				$price['money'] = floor($price['money'] * Shop::$sell_procent);
				$price['ore'] = floor($price['ore'] * Shop::$sell_procent);
			} else {
				$price['money'] = floor($item->money * Shop::$sell_procent);
				$price['ore'] = floor($item->ore * Shop::$sell_procent);
				// Костыль для киоска

				if ($item->type == "drug" || $item->type == "drug2" || $item->type == "usableitem") {
					if ($item->honey > 0) $price['ore'] += floor($item->honey * Shop::$sell_procent);
					if ($price['ore'] == 0 && $item->ore > 0) $price['ore'] = 1;
				}
			}
		}
		if ($item->type == 'home_comfort') {
			self::$player->home_comfort -= $item->itemlevel;
		} else if ($item->type == 'home_defence') {
			self::$player->home_defence -= $item->itemlevel;
		}

		self::$player->money += $price['money'];
		self::$player->ore += $price['ore'];
		self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$ORE, playerObject::$HOME_COMFORT, playerObject::$HOME_DEFENCE));

        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);

		if ($type == 'pet') {
			Std::loadMetaobjectClass('pet');
			petObject::deletePet(self::$player->id);
			CacheManager::delete('player_pets_id', array('player_id' => Page::$player->id));
		} else if ($type == 'simple item' || ($item->stackable == 1 && $item->durability == 1)) {
			$item->delete($item->id);
		} else {
			$item->durability --;
			$item->save($item->id, array(inventoryObject::$DURABILITY));
		}

		Page::sendLog(self::$player->id, 'item_sold', array('name' => $name, 'money' => $price['money'], 'ore' => $price['ore'], 'oil' => $price['oil'], 'mbckp' => $mbckp), 1);
		
		$result['result'] = 1;
		return $result;
	}

	protected function showShop()
	{
//$this->content = array_merge(Runtime::get('content'));
		if (Runtime::get('content/result') !== false) {
//$this->content['shop_message'] = Runtime::get('content/shop_message');
			$this->content['result'] = Runtime::get('content/result');
			$this->content['action'] = Runtime::get('content/action');
			Runtime::clear('content/result');
			Runtime::clear('content/action');
		}

        // автоподстановка имени игрока, при переходе в раздел подарков с его профиля
		if ((Shop::$section == 'gifts' || Shop::$section == 'rings') && is_numeric($this->url[2])) {
            $nickname = self::$sql->getValue("SELECT nickname FROM player WHERE id=" . (int)$this->url[2]);
            $this->content['playername'] = $nickname ? $nickname : '';
		}

        $this->content['mysex'] = self::$player->sex;
        $this->content['playerlevel'] = self::$player->level;
		$this->content['player'] = self::$player->toArray();
		$this->content["key"] = self::getPostKey();
		
		if (count(Shop::$sections[Shop::$section]['types'])) {
			self::$player->loadInventory();
			if (Shop::$section != 'mine') {
				Std::loadMetaObjectClass ('standard_item');
				$criteria = new ObjectCollectionCriteria();

//if (Shop::$section != 'mine') {
				$criteria->createWhere(standard_itemObject::$TYPE, ObjectCollectionCriteria::$COMPARE_IN, Shop::$sections[Shop::$section]['types']);
//}

                // оганичение по мин. левелу
				if (self::$section == "pharmacy") {
					$criteria->createWhere(standard_itemObject::$LEVEL, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_SMALLER, self::$player->level);
				} else {
					$criteria->createWhere(standard_itemObject::$LEVEL, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_SMALLER, self::$player->level+1);
				}
//$criteria->where[] = "(standard_item.sex = '" . self::$player->sex . "' or standard_item.sex = '')";

/** зачем это здесь?
// список вещей игрока
$ids = array(0);
if (self::$player->inventory) {
    foreach (self::$player->inventory as $i) {
        $ids[] = $i->standard_item;
    }
}
if (Shop::$section == 'mine') {
    $criteria->createWhere(standard_itemObject::$ID, ObjectCollectionCriteria::$COMPARE_IN, $ids);
    $criteria->createWhere(standard_itemObject::$SELLABLE, ObjectCollectionCriteria::$COMPARE_EQUAL, 1);
}
**/
				$criteria->createWhere(standard_itemObject::$SHOP, ObjectCollectionCriteria::$COMPARE_IN, array('shop', ''));
                // ограничения по макс. левелу, по дате, по возможности купить
				if (self::$player->accesslevel < 100) {
					$criteria->createWhere(standard_itemObject::$BUYABLE, ObjectCollectionCriteria::$COMPARE_EQUAL, 1);
//$criteria->where[] = "(standard_item.buyable = 1 OR (standard_item.sellable = 1 and standard_item.id in (" . implode(', ', $ids) . ")))";
					$criteria->where[] = "(standard_item.shopdt1 = '0000-00-00 00:00:00' or standard_item.shopdt1 <= now()) and (standard_item.shopdt2 = '0000-00-00 00:00:00' or standard_item.shopdt2 >= now())";
					if (self::$section != "pharmacy" && self::$section != "gifts") {
						$criteria->where[] = "(standard_item.maxlevel = 0 or standard_item.maxlevel >= " . self::$player->level . ")";
					}
				}

				// Костыль для выноса процентных жевачек, творожка и пяней наверх.
				if (self::$section == "pharmacy") {
					$criteria->addOrder("IF(level = 2, 0, 1) ASC");
				}

				if (self::$section == "gifts") {
					$criteria->addOrder("IF(ore = 15, 9999999, (money + (500 * honey) + (500 * ore))) DESC");
				} else {
					$criteria->createOrder(standard_itemObject::$LEVEL, ObjectCollectionCriteria::$ORDER_DESC);
				}
				if (Shop::$section == 'clan') {
					$criteria->createWhere(standard_itemObject::$TYPE2, ObjectCollectionCriteria::$COMPARE_EQUAL, 'clan');
				} else {
					$criteria->createWhere(standard_itemObject::$TYPE2, ObjectCollectionCriteria::$COMPARE_EQUAL, 'player');
				}

                $collection = new ObjectCollection();

				$this->content['items'] = array();
				$this->content['items2'] = array();
				$duplicates = array();

				$standard_itemCollection = $collection->getArrayList (standard_itemObject::$METAOBJECT, $criteria);
				if (self::$section != "pharmacy" && self::$section != "gifts") {
					$this->content['items'] = $standard_itemCollection;
				} else {
					foreach ($standard_itemCollection as &$item) {
						if ($item['minlevel'] <= Page::$player->level) {
							if (isset($duplicates[$item['code']])) {
								continue;
							} else {
								$duplicates[$item['code']] = 1;
							}
						}
						if ($item["maxlevel"] >= self::$player->level || $item["maxlevel"] == 0) {
							$this->content['items'][] = $item;
						} else {
							$this->content['items2'][] = $item;
						}
					}
				}
			} else {
				$items = array();
				foreach (self::$player->inventory as $key => $item) {
					if ($item->sellable == 0) {
						continue;
					}
					$item = $item->toArray();
					$items[] = $item;
				}
				$this->content['items'] = $items;
			}

			if (count($this->content['items']) && is_array($this->content['items'])) {
                foreach ($this->content['items'] as $key => &$standard_item) {
					// Проверка наличия даты окончания продажи
					if ($standard_item["shopdt2"] != "0000-00-00 00:00:00" && Shop::$section != 'mine') {
						$standard_item["shopdt2"] = date("d.m.Y H:i:s", strtotime($standard_item["shopdt2"]));
						$standard_item["shopdt2"] = str_replace(" 00:00:00", "", $standard_item["shopdt2"]);
					} else {
						$standard_item["shopdt2"] = "";
					}

					$standard_item['info'] = nl2br($standard_item['info']);

					if (self::$player->level >= 4 && self::$player->level + 1 >= $standard_item["level"] && self::$player->level < $standard_item["level"] && !empty($standard_item["slot"])) {
						$standard_item["forgrowth"] = 1;
					}

					if (Shop::$section == 'mine') {
						$standard_item['sellcost'] = Page::sqlGetCacheValue("SELECT sellcost FROM standard_item WHERE id = " . $standard_item["standard_item"], 86400, "standard_item_sellcost_" . $standard_item["standard_item"]);
					}

                    // цена продажи, если предмет продается
                    if ($standard_item['sellable'] == 1 && (!empty($standard_item['sellcost']) || (floor($standard_item['money'] * Shop::$sell_procent) > 0 || floor($standard_item['ore'] * Shop::$sell_procent) > 0 || floor($standard_item['honey'] * Shop::$sell_procent) > 0)) && (Shop::$section == 'mine' || self::$player->hasItemByStandardId($standard_item['id']))) {
                        if (empty($standard_item['sellcost'])) {
							$standard_item['sell']['money'] = floor($standard_item['money'] * Shop::$sell_procent);
							$standard_item['sell']['ore'] = floor($standard_item['ore'] * Shop::$sell_procent);
						} else {
							$costs = explode(" ", $standard_item['sellcost']);
							foreach ($costs as $itemCost) {
								preg_match("!(\d+)(\w+)!", $itemCost, $matches);
								if (sizeof($matches) == 3) {
									$standard_item['sell'][$matches[2]] += $matches[1];
								}
							}
						}
                    }
					
					// Костыль для киоска
					if ($standard_item['type'] == "drug" || $standard_item['type'] == "drug2" || $standard_item['type'] == "usableitem") {
						if (empty($standard_item['sellcost'])) {
							if ($standard_item['honey'] > 0) $standard_item['sell']['ore'] += floor($standard_item['honey'] * Shop::$sell_procent);
							if ($standard_item['sell']['ore'] == 0 && $standard_item['ore'] > 0) $standard_item['sell']['ore'] = 1;
						}
					}
					
                    // питомец, если мы сечас в секции "Мои вещи"
                    if ($standard_item['type'] == 'pet' && (Shop::$section == 'mine' || self::$player->pet->item == $standard_item['id'])) {
						if (empty($standard_item['sellcost'])) {
							if (Shop::$section == 'mine') {
								$prices = Page::$sql->getRecord("select money, ore from standard_item where id = " . $standard_item['item']);
								$standard_item['sell']['money'] = floor($prices['money'] * Shop::$sell_procent);
								$standard_item['sell']['ore'] = floor($prices['ore'] * Shop::$sell_procent);
							} else {
								$standard_item['sell']['money'] = floor($standard_item['money'] * Shop::$sell_procent);
								$standard_item['sell']['ore'] = floor($standard_item['ore'] * Shop::$sell_procent);
							}
						}
                    }
                    // если мы в секции "Мои вещи", а предмет не продается, то он убирается из списка предметов
                    if (Shop::$section == 'mine' && $standard_item['sell']['money'] == 0 && $standard_item['sell']['ore'] == 0) {
                        unset($this->content['items'][$key]);
                    }

//$paramNamesTech = array('health' => 'Шанс наезда', 'strength' => 'Мин. урон', 'dexterity' => 'Макс. урон');
/*
if ($standard_item['type'] != 'pet') {
    foreach (self::$data['stats'] as $stat) {
        if ($standard_item[$stat['code']] != 0) {
            if ($standard_item['type'] == 'tech' && $standard_item['level'] > 2) {
                $standard_item['effects'][] = array(
                    'param' => $paramNamesTech[$stat['code']],
                    'value' => $standard_item[$stat['code']] . ($stat['code'] == 'health' ? '%' : ''),
                    'noplus' => 1,
                );
            } else {
                $standard_item['effects'][] = array(
                    'param' => ($standard_item['type'] == 'drug2' ? $stat['ratingName'] : ($standard_item['usestate'] == 'normal' ? $stat['name'] : $stat['fightName'])),
                    'value' => $standard_item[$stat['code']],
                    'noplus' => 0,
                );
            }
        }
    }
    foreach (self::$data['ratings'] as $stat) {
        if ($standard_item[$stat['code']] != 0) {
            $standard_item['effects'][] = array(
                'param' => $stat['name'],
                'value' => $standard_item[$stat['code']],
                'noplus' => 0,
            );
        }
    }
    if ($standard_item['hp'] > 0) {
        $standard_item['effects'][] = array('param' => 'Жизни', 'value' => $standard_item['hp']);
    }
}
*/

                    Page::parseSpecialParams($standard_item);
/**
if ($standard_item['type'] == 'pick') {
    $standard_item['effects'][] = array('param' => 'Скорость поиска руды', 'value' => $standard_item['itemlevel'] / 1000);
} else if ($standard_item['type'] == 'metro') {
    $standard_item['effects'][] = array('param' => 'Шанс нахождения руды', 'value' => $standard_item['itemlevel'] / 1000);
} else
**/
                    if ($standard_item['type'] == 'pet') {
                        $standard_item['effects'][] = array('param' => ($standard_item['itemlevel'] ? $standard_item['itemlevel'] : $standard_item['procent']) . '% от характеристик хозяина');
                    } else if ($standard_item['type'] == 'petfood' || $standard_item['type'] == 'petautofood') {
                        $standard_item['effects'][] = array('param' => 'Восстанавливает ' . $standard_item['itemlevel'] . '% здоровья питомца');
                    } else if ($standard_item['type'] == 'home_comfort') {
                        $standard_item['effects'][] = array('param' => 'Комфорт', 'value' => $standard_item['itemlevel']);
                    } else if ($standard_item['type'] == 'home_defence') {
                        $standard_item['effects'][] = array('param' => 'Защита дома', 'value' => $standard_item['itemlevel']);
                    } else if ($standard_item['type'] == 'home_safe') {
                        $standard_item['effects'][] = array('param' => 'Сохраняет ' . ($standard_item['itemlevel'] * 100) . ' монет на уровень при ограблении Вас');
                    }
                    $standard_item['time'] = str_replace(array('d', 'h', 'm', 's'), array(Lang::TIME_D, Lang::TIME_H, Lang::TIME_MI, Lang::TIME_S), $standard_item['time']);
                }
            }
		} else {
			$this->content['items'] = array();
		}

//$this->content['allowbuy'] = 1; //self::$section == 'clan' ? ((int)self::$player->clan > 0 && self::$player->clan_status == 'founder' ? 1 : 0) : 1;

        // список разделов магазина
        $this->content['section'] = Shop::$section;
		$this->content['sections'] = array();
		foreach (Shop::$sections as $name => $element) {
			$this->content['sections'][] = array('name' => $name, 'title' => $element['name']);
		}

		$this->content['return_url'] = '/shop/section/' . self::$section . '/';
		$this->content['shop'] = 'shop';

        $this->content['window-name'] = ShopLang::$windowTitle;
		$this->page->addPart('content', 'shop/shop.xsl', $this->content);
	}

    /**
     * Специальная секция магазина
     */
    private function showSpecial()
    {
        //$specials = array('axe1' => 'axe');
		$specials = array();
        $special = $this->url[1];

        if (!isset($specials[$special])) {
            Page::addAlert(ShopLang::$error, ShopLang::$errorWrongSection);
			Std::redirect('/shop/');
        } else {
            $special = $specials[$special];
        }

        $this->content['step'] = 1;

        switch ($special) {
            case 'axe':
                $this->content['window-name'] = 'AXE Шифт';

                $products = array(
					'30056602' => '1','30056640' => '1','30056671' => '1','30061392' => '1','40883007' => '1',
					'40883007' => '1','40883403' => '1','40883496' => '1','40883564' => '1','40883632' => '1',
					'40883670' => '1','40883694' => '1','40883762' => '1','40883830' => '1','40883946' => '1',
					'40883946' => '1','40883991' => '1','42153016' => '1','42153061' => '1','42153153' => '1',
					'42153184' => '1','42182474' => '1','42182481' => '1','42182597' => '1','42182603' => '1',
					'46022714' => '1','46022769' => '1','50031795' => '1','50075126' => '1','50075126' => '1',
					'50075133' => '1','50075294' => '1','50076598' => '1','50076598' => '1','50076604' => '1',
					'50076604' => '1','50076611' => '1','50076611' => '1','50076703' => '1','50076727' => '1',
					'50077717' => '1','50093908' => '1','50093915' => '1','50093915' => '1','50096084' => '1',
					'50096084' => '1','50096091' => '1','50096091' => '1','50096091' => '1','50096107' => '1',
					'50096107' => '1','50096114' => '1','50096114' => '1','50096121' => '1','50096121' => '1',
					'50096121' => '1','50096121' => '1','50096121' => '1','50096398' => '1','50096732' => '1',
					'50096732' => '1','50096732' => '1','50096749' => '1','50096756' => '1','50096930' => '1',
					'50096930' => '1','50097432' => '1','50097432' => '1','50097487' => '1','50097487' => '1',
					'50097500' => '1','50097661' => '1','50097708' => '1','50099238' => '1','50099269' => '1',
					'50099290' => '1','50099344' => '1','50120765' => '1','50200726' => '1','50228935' => '1',
					'50230815' => '1','50230815' => '1','50262120' => '1','50285235' => '1','50285662' => '1',
					'50286959' => '1','50287031' => '1','50287062' => '1','50287062' => '1','50330218' => '1',
					'50330218' => '1','50330300' => '1','50330300' => '1','50330300' => '1','50330300' => '1',
					'50330317' => '1','50330317' => '1','50330317' => '1','50330317' => '1','50340279' => '1',
					'50340286' => '1','50370344' => '1','50370368' => '1','54024502' => '1','54024915' => '1',
                    '54024953' => '1','73103714' => '1','80466437' => '1','85904477' => '1','87117097' => '1',
                    '87294842' => '1','90142093' => '1',
					'3014230000201' => '1',
					'3014230010262' => '1',
					'3014230010323' => '1',
					'3014230560132' => '1',
					'3014230560132' => '1',
					'4000388175402' => '1',
					'4000388176904' => '1',
					'4000388177000' => '1',
					'4000388426702' => '1',
					'4000388426702' => '1',
					'4000388669000' => '1',
					'4000388669000' => '1',
					'4000388669000' => '1',
					'4000388669000' => '1',
					'4000388669406' => '1',
					'4000388669406' => '1',
					'4000388868502' => '1',
					'4000388868502' => '1',
					'4601726004769' => '1',
					'4601726004769' => '1',
					'4601726004806' => '1',
					'4601726004806' => '1',
					'4601726007593' => '1',
					'4601726007593' => '1',
					'5000228023411' => '1',
					'6192000781240' => '1',
					'8000630040843' => '1',
					'8000700000104' => '1',
					'8593838982621' => '1',
					'8593838982621' => '1',
					'8593838987718' => '1',
					'8593838987718' => '1',
					'8593838987831' => '1',
					'8593838987831' => '1',
					'8717163002087' => '1',
					'8717163005101' => '1',
					'8717163005156' => '1',
					'8717163005453' => '1',
					'8717163005484' => '1',
					'8717163006054' => '1',
					'8717163006085' => '1',
					'8717163006108' => '1',
					'8717163007303' => '1',
					'8717163007303' => '1',
					'8717163023839' => '1',
					'8717163023839' => '1',
					'8717163023877' => '1',
					'8717163041550' => '1',
					'8717163041611' => '1',
					'8717163044650' => '1',
					'8717163044650' => '1',
					'8717163044650' => '1',
					'8717163044674' => '1',
					'8717163044698' => '1',
					'8717163044698' => '1',
					'8717163044698' => '1',
					'8717163044711' => '1',
					'8717163044711' => '1',
					'8717163044711' => '1',
					'8717163044735' => '1',
					'8717163044735' => '1',
					'8717163044797' => '1',
					'8717163044797' => '1',
					'8717163046234' => '1',
					'8717163046234' => '1',
					'8717163046234' => '1',
					'8717163046258' => '1',
					'8717163046258' => '1',
					'8717163046258' => '1',
					'8717163046272' => '1',
					'8717163062210' => '1',
					'8717163062210' => '1',
					'8717163062340' => '1',
					'8717163064306' => '1',
					'8717163064320' => '1',
					'8717163064344' => '1',
					'8717163074558' => '1',
					'8717163082867' => '1',
					'8717163082867' => '1',
					'8717163082867' => '1',
					'8717163089361' => '1',
					'8717163089361' => '1',
					'8717163089361' => '1',
					'8717163089361' => '1',
					'8717163094891' => '1',
					'8717163094891' => '1',
					'8717163094891' => '1',
					'8717163094891' => '1',
					'8717163094891' => '1',
					'8717163094921' => '1',
					'8717163094921' => '1',
					'8717163094921' => '1',
					'8717163094921' => '1',
					'8717163094921' => '1',
					'8717163094952' => '1',
					'8717163094952' => '1',
					'8717163094952' => '1',
					'8717163094952' => '1',
					'8717163094952' => '1',
					'8717163289914' => '1',
					'8717163327753' => '1',
					'8717163328149' => '1',
					'8717163332122' => '1',
					'8717163337134' => '1',
					'8717163340455' => '1',
					'8717163340561' => '1',
					'8717163340561' => '1',
					'8717163340561' => '1',
					'8717163340561' => '1',
					'8717163349977' => '1',
					'8717163350003' => '1',
					'8717163350034' => '1',
					'8717163350324' => '1',
					'8717163408834' => '1',
					'8717163411216' => '1',
					'8717163465271' => '1',
					'8717163465271' => '1',
					'8717163465387' => '1',
					'8717163465448' => '1',
					'8717163465486' => '1',
					'8717163465509' => '1',
					'8717163467121' => '1',
					'8717163467121' => '1',
					'8717163467152' => '1',
					'8717163467169' => '1',
					'8717163467176' => '1',
					'8717163467237' => '1',
					'8717163467244' => '1',
					'8717163467275' => '1',
					'8717163467282' => '1',
					'8717163476789' => '1',
					'8717163558706' => '1',
					'8717163558799' => '1',
					'8717163559413' => '1',
					'8717163559444' => '1',
					'8717163560822' => '1',
					'8717163564226' => '1',
					'8717163564226' => '1',
					'8717163566282' => '1',
					'8717163566312' => '1',
					'8717163568736' => '1',
					'8717163572832' => '1',
					'8717163573235' => '1',
					'8717163573235' => '1',
					'8717163573235' => '1',
					'8717163573372' => '1',
					'8717163573563' => '1',
					'8717163591406' => '1',
					'8717163591406' => '1',
					'8717163593028' => '1',
					'8717163593059' => '1',
					'8717163593066' => '1',
					'8717163605448' => '1',
					'8717163605455' => '1',
					'8717163605547' => '1',
					'8717163605776' => '1',
					'8717163605776' => '1',
					'8717163607411' => '1',
					'8717163960349' => '1',
					'8717163960349' => '1',
					'8717163965276' => '1',
					'8717163965276' => '1',
					'8717163972717' => '1',
					'8717163976500' => '1',
					'8717163980132' => '1',
					'8717163980132' => '1',
					'8717163980149' => '1',
					'8717163980156' => '1',
					'8717163980194' => '1',
					'8717163980200' => '1',
					'8717163980224' => '1',
					'8717163980231' => '1',
					'8717163980255' => '1',
					'8717163980330' => '1',
					'8717163980361' => '1',
					'8717163980385' => '1',
					'8717163989876' => '1',
					'8717163991138' => '1',
					'8717163994252' => '1',
					'8717163994252' => '1',
					'8717163994252' => '1',
					'8717163997192' => '1',
					'8717163997192' => '1',
					'8717644000243' => '1',
					'8717644000243' => '1',
					'8717644000274' => '1',
					'8717644000274' => '1',
					'8717644000274' => '1',
					'8717644000335' => '1',
					'8717644000397' => '1',
					'8717644000397' => '1',
					'8717644000397' => '1',
					'8717644000427' => '1',
					'8717644000427' => '1',
					'8717644000427' => '1',
					'8717644009222' => '1',
					'8717644009246' => '1',
					'8717644009246' => '1',
					'8717644009260' => '1',
					'8717644009260' => '1',
					'8717644009284' => '1',
					'8717644009284' => '1',
					'8717644009284' => '1',
					'8717644009307' => '1',
					'8717644009307' => '1',
					'8717644009321' => '1',
					'8717644009321' => '1',
					'8717644013045' => '1',
					'8717644013076' => '1',
					'8717644013076' => '1',
					'8717644013076' => '1',
					'8717644013229' => '1',
					'8717644013793' => '1',
					'8717644013960' => '1',
					'8717644013960' => '1',
					'8717644019337' => '1',
					'8717644021958' => '1',
					'8717644021989' => '1',
					'8717644022009' => '1',
					'8717644022047' => '1',
					'8717644022078' => '1',
					'8717644022221' => '1',
					'8717644022269' => '1',
					'8717644022290' => '1',
					'8717644022351' => '1',
					'8717644022382' => '1',
					'8717644026748' => '1',
					'8717644026748' => '1',
					'8717644037720' => '1',
					'8717644037720' => '1',
					'8717644042359' => '1',
					'8717644042359' => '1',
					'8717644042359' => '1',
					'8717644042939' => '1',
					'8717644042939' => '1',
					'8717644044841' => '1',
					'8717644044841' => '1',
					'8717644046685' => '1',
					'8717644049501' => '1',
					'8717644050279' => '1',
					'8717644050279' => '1',
					'8717644052938' => '1',
					'8717644052938' => '1',
					'8717644061725' => '1',
					'8717644062357' => '1',
					'8717644062357' => '1',
					'8717644062357' => '1',
					'8717644072103' => '1',
					'8717644073353' => '1',
					'8717644073452' => '1',
					'8717644075326' => '1',
					'8717644076064' => '1',
					'8717644076101' => '1',
					'8717644076927' => '1',
					'8717644077214' => '1',
					'8717644078440' => '1',
					'8717644085776' => '1',
					'8717644088111' => '1',
					'8717644089262' => '1',
					'8717644089262' => '1',
					'8717644089293' => '1',
					'8717644089293' => '1',
					'8717644091517' => '1',
					'8717644091517' => '1',
					'8717644094617' => '1',
					'8717644094822' => '1',
					'8717644096079' => '1',
					'8717644096437' => '1',
					'8717644096574' => '1',
					'8717644099896' => '1',
					'8717644102428' => '1',
					'8717644102466' => '1',
					'8717644104309' => '1',
					'8717644104446' => '1',
					'8717644105320' => '1',
					'8717644115091' => '1',
					'8717644115091' => '1',
					'8717644115220' => '1',
					'8717644115220' => '1',
					'8717644134412' => '1',
					'8717644134412' => '1',
					'8717644134542' => '1',
					'8717644138359' => '1',
					'8717644138359' => '1',
					'8717644139530' => '1',
					'8717644141724' => '1',
					'8717644141793' => '1',
					'8717644142202' => '1',
					'8717644142462' => '1',
					'8717644142554' => '1',
					'8717644142615' => '1',
					'8717644143902' => '1',
					'8717644144053' => '1',
					'8717644144053' => '1',
					'8717644144091' => '1',
					'8717644144091' => '1',
					'8717644144275' => '1',
					'8717644144275' => '1',
					'8717644144275' => '1',
					'8717644144275' => '1',
					'8717644144336' => '1',
					'8717644144336' => '1',
					'8717644144336' => '1',
					'8717644144336' => '1',
					'8717644144367' => '1',
					'8717644144398' => '1',
					'8717644144398' => '1',
					'8717644144466' => '1',
					'8717644144466' => '1',
					'8717644144497' => '1',
					'8717644144626' => '1',
					'8717644144626' => '1',
					'8717644144671' => '1',
					'8717644144671' => '1',
					'8717644144671' => '1',
					'8717644146200' => '1',
					'8717644165348' => '1',
					'8717644165379' => '1',
					'8717644165379' => '1',
					'8717644165379' => '1',
					'8717644165409' => '1',
					'8717644165409' => '1',
					'8717644165546' => '1',
					'8717644165546' => '1',
					'8717644165577' => '1',
					'8717644165577' => '1',
					'8717644165577' => '1',
					'8717644165737' => '1',
					'8717644165737' => '1',
					'8717644165737' => '1',
					'8717644165768' => '1',
					'8717644165768' => '1',
					'8717644165768' => '1',
					'8717644165768' => '1',
					'8717644165799' => '1',
					'8717644165829' => '1',
					'8717644165829' => '1',
					'8717644165829' => '1',
					'8717644165829' => '1',
					'8717644165829' => '1',
					'8717644165867' => '1',
					'8717644165867' => '1',
					'8717644165867' => '1',
					'8717644165867' => '1',
					'8717644165898' => '1',
					'8717644165898' => '1',
					'8717644166222' => '1',
					'8717644166222' => '1',
					'8717644169001' => '1',
					'8717644169001' => '1',
					'8717644169230' => '1',
					'8717644169230' => '1',
					'8717644183144' => '1',
					'8717644198490' => '1',
					'8717644215920' => '1',
					'8717644215951' => '1',
					'8717644215951' => '1',
					'8717644216026' => '1',
					'8717644216057' => '1',
					'8717644216248' => '1',
					'8717644242223' => '1',
					'8717644242223' => '1',
					'8717644242742' => '1',
					'8717644242742' => '1',
					'8717644250365' => '1',
					'8717644263198' => '1',
					'8717644265000' => '1',
					'8717644268186' => '1',
					'8717644268186' => '1',
					'8717644271766' => '1',
					'8717644271797' => '1',
					'8717644271797' => '1',
					'8717644271858' => '1',
					'8717644271858' => '1',
					'8717644277539' => '1',
					'8717644277539' => '1',
					'8717644277539' => '1',
					'8717644277539' => '1',
					'8717644286548' => '1',
					'8717644288665' => '1',
					'8717644290248' => '1',
					'8717644290897' => '1',
					'8717644296714' => '1',
					'8717644296745' => '1',
					'8717644307014' => '1',
					'8717644307816' => '1',
					'8717644316658' => '1',
					'8717644317020' => '1',
					'8717644317068' => '1',
					'8717644317082' => '1',
					'8717644320358' => '1',
					'8717644320457' => '1',
					'8717644320457' => '1',
					'8717644321478' => '1',
					'8717644321508' => '1',
					'8717644321508' => '1',
					'8717644326671' => '1',
					'8717644328040' => '1',
					'8717644334607' => '1',
					'8717644339428' => '1',
					'8717644339428' => '1',
					'8717644339428' => '1',
					'8717644339480' => '1',
					'8717644340639' => '1',
					'8717644341209' => '1',
					'8717644343296' => '1',
					'8717644346617' => '1',
					'8717644346617' => '1',
					'8717644346679' => '1',
					'8717644346679' => '1',
					'8717644346730' => '1',
					'8717644346730' => '1',
					'8717644355480' => '1',
					'8717644355480' => '1',
					'8717644367599' => '1',
					'8717644378946' => '1',
					'8717644378946' => '1',
					'8717644379004' => '1',
					'8717644383247' => '1',
					'8717644388846' => '1',
					'8717644419281' => '1',
					'8717644419281' => '1',
					'8717644419519' => '1',
					'8717644419519' => '1',
					'8717644419540' => '1',
					'8717644419540' => '1',
					'8717644419595' => '1',
					'8717644419595' => '1',
					'8717644420799' => '1',
					'8717644420799' => '1',
					'8717644420836' => '1',
					'8717644420836' => '1',
					'8717644433799' => '1',
					'8717644434215' => '1',
					'8717644440599' => '1',
					'8717644440599' => '1',
					'8717644440650' => '1',
					'8717644440650' => '1',
					'8717644441497' => '1',
					'8717644442562' => '1',
					'8717644461891' => '1',
					'8717644461891' => '1',
					'8717644463017' => '1',
					'8717644463017' => '1',
					'8717644463017' => '1',
					'8717644463017' => '1',
					'8717644463017' => '1',
					'8717644474402' => '1',
					'8717644474402' => '1',
					'8717644479193' => '1',
					'8717644479193' => '1',
					'8717644479520' => '1',
					'8717644479551' => '1',
					'8717644479582' => '1',
					'8717644479582' => '1',
					'8717644492581' => '1',
					'8717644492581' => '1',
					'8717644492581' => '1',
					'8717644494868' => '1',
					'8717644500101' => '1',
					'8717644500446' => '1',
					'8717644500477' => '1',
					'8717644500507' => '1',
					'8717644501207' => '1',
					'8717644501627' => '1',
					'8717644501627' => '1',
					'8717644514726' => '1',
					'8717644514788' => '1',
					'8717644514788' => '1',
					'8717644515037' => '1',
					'8717644515068' => '1',
					'8717644515129' => '1',
					'8717644516294' => '1',
					'8717644516324' => '1',
					'8717644516355' => '1',
					'8717644516355' => '1',
					'8717644516386' => '1',
					'8717644516454' => '1',
					'8717644516515' => '1',
					'8717644517024' => '1',
					'8717644519493' => '1',
					'8717644519493' => '1',
					'8717644524961' => '1',
					'8717644526002' => '1',
					'8717644526002' => '1',
					'8717644526293' => '1',
					'8717644526323' => '1',
					'8717644531662' => '1',
					'8717644531662' => '1',
					'8717644531662' => '1',
					'8717644531815' => '1',
					'8717644531815' => '1',
					'8717644538234' => '1',
					'8717644538234' => '1',
					'8717644545157' => '1',
					'8717644568323' => '1',
					'8717644568323' => '1',
					'8717644568415' => '1',
					'8717644568507' => '1',
					'8717644577165' => '1',
					'8717644577165' => '1',
					'8717644577165' => '1',
					'8717644577165' => '1',
					'8717644577530' => '1',
					'8717644577530' => '1',
					'8717644578384' => '1',
					'8717644582763' => '1',
					'8717644582763' => '1',
					'8717644582763' => '1',
					'8717644584781' => '1',
					'8717644584781' => '1',
					'8717644585085' => '1',
					'8717644585085' => '1',
					'8717644585085' => '1',
					'8717644585511' => '1',
					'8717644585511' => '1',
					'8717644597576' => '1',
					'8717644599365' => '1',
					'8717644599778' => '1',
					'8717644600931' => '1',
					'8717644601969' => '1',
					'8717644601969' => '1',
					'8717644602157' => '1',
					'8717644602157' => '1',
					'8717644605479' => '1',
					'8717644606735' => '1',
					'8717644619407' => '1',
					'8717644620816' => '1',
					'8717644622926' => '1',
					'8717644641545' => '1',
					'8717644641545' => '1',
					'8717644653869' => '1',
					'8717644656983' => '1',
					'8717644678930' => '1',
					'8717644679081' => '1',
					'8717644679180' => '1',
					'8717644709245' => '1',
					'8717644723043' => '1',
					'8717644723388' => '1',
					'8717644723401' => '1',
					'8717644723555' => '1',
					'8717644724309' => '1',
					'8717644737545' => '1',
					'8717644737545' => '1',
					'8717644795545' => '1',
					'8717644796368' => '1',
					'8717644796542' => '1',
					'8717644799307' => '1',
					'8717644799543' => '1',
					'8717644799567' => '1',
					'8717644799604' => '1',
					'8717644799741' => '1',
					'8717644808474' => '1',
					'8717644822678' => '1',
					'8717644886632' => '1',
					'8717644967898' => '1',
					'8717644967898' => '1',
					'8718114003191' => '1',
					'8718114073163' => '1',
					'8718114073163' => '1',
					'8718114073248' => '1',
					'8718114073248' => '1',
					'8718114073248' => '1',
					'8718114148304' => '1','8718114148304' => '1','8718114151267' => '1','8718114151267' => '1',
					'8718114151458' => '1','8718114156828' => '1','8718114156828' => '1','8718114179445' => '1',
					'8718114179445' => '1','8718114179476' => '1','8718114179476' => '1','8718114184562' => '1',
					'8718114192345' => '1','8718114192345' => '1','8718114192475' => '1','8718114192475' => '1',
					'8718114194592' => '1','8718114202334' => '1','8718114202334' => '1','8718114202334' => '1',
					'8718114225647' => '1','8718114225647' => '1','8718114225685' => '1','8718114225685' => '1',
					'8718114225760' => '1','8718114225852' => '1','8718114247762' => '1','8718114249414' => '1',
					'8718114249513' => '1','8718114249599' => '1','8718114249926' => '1','8718114250076' => '1',
					'8718114250151' => '1','8718114255095' => '1','8718114265360' => '1','8718114265599' => '1',
					'8718114265711' => '1','8718114265926' => '1','8718114271545' => '1','8718114271767' => '1',
					'8718114272320' => '1','8718114272535' => '1','8718114284583' => '1','8718114284668' => '1',
					'8718114284743' => '1','8718114286822' => '1','8718114293868' => '1','8718114294216' => '1',
					'8718114294247' => '1','8718114310237' => '1','8718114310312' => '1','8718114322568' => '1',
					'8718114361147' => '1','8718114361420' => '1','8718114377612' => '1','8718114385044' => '1',
					'8718114385280' => '1','8718114385464' => '1','8718114398174' => '1','8718114398181' => '1',
					'8718114398198' => '1','8718114401928' => '1','8718114402116' => '1','8718114402192' => '1',
					'8718114402277' => '1','8718114402499' => '1','8718114402574' => '1','8718114402659' => '1',
					'8718114402680' => '1','8718114402857' => '1','8718114403014' => '1','8718114403090' => '1',
					'8718114403229' => '1','8718114403304' => '1','8718114403380' => '1','8718114403564' => '1',
					'8718114403649' => '1','8718114404219' => '1','8718114405230' => '1','8718114405315' => '1',
					'8718114405452' => '1','8718114406701' => '1','8718114406787' => '1','8718114406909' => '1',
					'8718114406985' => '1','8718114407296' => '1','8718114491592' => '1','9300663278466' => '1'
					);
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->url[2] == 'activate') {
                    $code = preg_replace('/[^\w]/', '', $_POST['code']);
                    if (isset($products[$code]) && strtolower($products[$code]) == strtolower($_POST['product'])) {
                        if ((int)self::$sql->getValue("SELECT count(*) FROM logspecial WHERE type='axe1' AND player=" . self::$player->id . " AND data1='" . $code . "'") == 0) {
                            if ((int)self::$sql->getValue("SELECT count(*) FROM logspecial WHERE type='axe1' AND player=" . self::$player->id . " AND dt>DATE_SUB(now(), INTERVAL 1 MONTH)") == 0) {
                                Std::loadMetaObjectClass('standard_item');
                                $item = new standard_itemObject();
                                $item->loadByCode('axe2');
                                $item->makeExampleOrAddDurability(self::$player->id, $item->maxdurability);

                                Std::loadMetaObjectClass('logspecial');
                                $ls = new logspecialObject();
                                $ls->type = 'axe1';
                                $ls->player = self::$player->id;
                                $ls->dt = date('Y-m-d H:i:s', time());
                                $ls->data1 = $code;
                                $ls->save();

                                $this->content['step'] = 2;

                                if (self::$player->sex == 'male') {
                                    Page::addAlert('Все правильно сделал', '<p><img src="/@/images/obj/axe.png" align="left" />Отлично, ты выполнил все условия задания. В награду ты получаешь <b>дезодорант Axe Shift</b>, который выделит тебя из толпы.</p>');
                                } else {
                                    Page::addAlert('Все правильно сделала', '<p><img src="/@/images/obj/axe.png" align="left" />Отлично, ты выполнила все условия задания. В награду ты получаешь <b>дезодорант Axe Shift</b>, который выделит тебя из толпы.</p>');
                                }
                                Runtime::set('axe_success', 1);
                            } else {
                                $this->content['step'] = 3;
                                Page::addAlert(ShopLang::$error, 'Вы уже активировали код в течение последнего месяца.');
                            }
                        } else {
                            $this->content['step'] = 3;
                            Page::addAlert(ShopLang::$error, 'Вы уже активировали этот код.');
                        }
                    } else {
                        $this->content['step'] = 3;
                        Page::addAlert(ShopLang::$error, 'Неверно введен код.');
                    }
                    Std::redirect('/shop/special/axe1/');
                }
                break;
        }

        if (Runtime::get('axe_success') == 1) {
            Runtime::clear('axe_success');
            $this->content['success'] = 1;
        } else {
            $this->content['success'] = 0;
        }

        $this->page->addPart('content', 'shop/special/' . $special . '.xsl', $this->content);
    }
}
?>