<?php
class Factory extends Page implements IModule
{
    public $moduleCode = 'Factory';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		$this->needAuth();
        //
		switch ($this->url[0]){
            case 'mf':
                $this->showMf();
                break;
            
            case 'mf-item':
                $this->showMfItem();
                break;

            case 'start-petriks':
                $this->startPetriks();
                break;

            case 'farma':
                $this->showFarma();
                break;

            default:
				$this->showFactory();
				break;
		}
        //
        parent::onAfterProcessRequest();
    }

	public static function getExtendedItems() {
		$result = array();
		//$tmp = Page::$player->getItemsForUseByCode(array('petriks_instant', 'petriks_double', 'petriks_double_norm'));
		$result['instant'] = Page::$player->getItemForUseByCode('petriks_instant');
		$result['double'] = Page::$player->getItemForUseByCode('petriks_double');
		//$result['double_norm'] = Page::$player->getItemForUseByCode('petriks_double_norm');
		//if (isset($tmp['petriks_instant'])) {
		//	$result['instant'] = $tmp['petriks_instant'];
		//}
		//if (isset($tmp['petriks_double'])) {
		//	$result['double'] = $tmp['petriks_double'];
		//}
		//if (isset($tmp['petriks_double_norm'])) {
		//	$result['double_norm'] = $tmp['petriks_double_norm'];
		//}
		return $result;
	}

	protected function showFactory() {
		Std::loadMetaObjectClass('clan');

        $this->content['player'] = self::$player->toArray();

/* статистика вкладчиков
Std::loadMetaObjectClass("factory_investition");		
$criteria = new ObjectCollectionCriteria();
$criteria->addLimit(0, 10);
$criteria->createOrder("(factory_investition.ore + factory_investition.honey) * 50 + factory_investition.money", "DESC");
//$criteria->createOrder("factory_investition.ore", "DESC");
//$criteria->createOrder("factory_investition.honey", "DESC");
$criteria->createJoin(playerObject::$METAOBJECT, playerObject::$ID, factory_investitionObject::$PLAYER, ObjectCollectionCriteria::$JOIN_INNER);
$criteria->createJoin(clanObject::$METAOBJECT, clanObject::$ID, playerObject::$CLAN, ObjectCollectionCriteria::$JOIN_LEFT);
$collection = new ObjectCollection();
$investors = $collection->getArrayList(factory_investitionObject::$METAOBJECT, $criteria, array(
        "factory_investition.money" => "money",
        "factory_investition.ore" => "ore",
        "factory_investition.honey" => "honey",
        "player.nickname" => "nickname",
        "player.level" => "level",
        "player.fraction" => "fraction",
        "player.id" => "player",
        "clan.id" => "clan_id",
        "clan.name" => "clan_name",
    ));

if ($investors) {
    $this->content["investors"] = $investors;
}

$total = $collection->getArrayList(factory_investitionObject::$METAOBJECT, null, array(
        "SUM(money)" => "money",
        "SUM(ore)" => "ore",
        "SUM(honey)" => "honey"
    ));
$this->content["total"] = $total[0];
*/

        $petriks = self::$sql->getRecord("SELECT * FROM playerwork WHERE player=" . self::$player->id . " AND type='petriks'");
        if ($petriks) {
            $timer = $petriks['endtime'] - time();
			$this->content['petriksprocesstimeleft'] = $timer > 0 ? $timer : 0;
            $this->content['petriksprocesstimeleft2'] = date('H:i:s', $timer);
            $this->content['petriksprocesstimetotal'] = 3600;
            $this->content['petriksprocesspercent'] = round((3600 - $timer) / 3600 * 100);
            $this->content['petriksprocess'] = 1;
			$petriks['params'] = json_decode($petriks['params'], true);
			$this->content['petriks_doing'] = $petriks['params']['petriks'];
			//if ($this->content['petriks_doing'] != 5 && $this->content['petriks_doing'] != 10) {
			//	$this->content['petriks_doing'] = 5;
			//}
        } else {
            $this->content['petriksprocess'] = 0;
			$this->content['items'] = Factory::getExtendedItems();
			//$petriks = Page::$data['factory']['petriks'][Page::getGroupLevel(Page::$player->level)];
			$petriks = 5;
			$this->content['petriks'] = $petriks;
			$this->content['petriks_orecost'] = $petriks;
        }

        $this->content['window-name'] = FactoryLang::$windowTitleFactory;
		$this->page->addPart('content', 'factory/factory.xsl', $this->content);
	}

    /**
     * Цех модификаций
     */
    private function showMf()
    {
        if (self::$player->level >= 6) {
            // инвентарь
            Std::loadMetaObjectClass('inventory');
            $this->content['inventory'] = array();

            // список предметов для модификации
            $criteria = new ObjectCollectionCriteria();
            $criteria->createWhere(inventoryObject::$PLAYER, ObjectCollectionCriteria::$COMPARE_EQUAL, self::$player->id);
            //$criteria->createWhere(inventoryObject::$LEVEL, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, 5);
            //$criteria->createWhere(inventoryObject::$EQUIPPED, ObjectCollectionCriteria::$COMPARE_EQUAL, 0);
            $criteria->createWhere(inventoryObject::$TYPE, ObjectCollectionCriteria::$COMPARE_IN, array('weapon','cloth','hat','shoe','pouch','accessory1','talisman','jewellery','cologne','tech'));
            $criteria->createWhere(inventoryObject::$USESTATE, ObjectCollectionCriteria::$COMPARE_IN, array('','normal'));

            $inventory = new ObjectCollection();
            $inventory = $inventory->getArrayList(inventoryObject::$METAOBJECT, $criteria);
            if ($inventory) {
                foreach ($inventory as $item) {
                    if ($item['level'] < 3 || ($item['level'] < 5 && $item['type'] != 'tech')) {
                        continue;
                    }

                    Page::parseSpecialParams($item);

                    $this->content['inventory'][] = $item;//Array;
                }
            }

            $this->content['prof'] = self::$player->getProf(Page::$data['factory']['upgrade'], "skillupgrade");

            $this->content['player'] = self::$player->toArray();
            $this->content['window-name'] = FactoryLang::$windowTitleMf;
            $this->page->addPart('content', 'factory/mf.xsl', $this->content);
        } else {
            Page::addAlert(FactoryLang::$error, FactoryLang::$errorMfMinLevel6, ALERT_ERROR);
            Std::redirect('/factory/');
        }
    }

    /**
     * Цех модификаций - внутри
     */
    private function showMfItem()
    {
        if (self::$player->level >= 6) {
            // инвентарь
            Std::loadMetaObjectClass('inventory');

            $kupon = self::$player->loadItemByCode('factory_kupon');

            $params = array('weapon' => 'strength', 'cloth' => 'health', 'hat' => 'attention', 'shoe' => 'dexterity',
                'pouch' => 'resistance', 'accessory1' => 'intuition', 'talisman' => 'intuition',
                'jewellery' => 'charism', 'cologne' => 'attention', 'tech' => 'special1');
            $ratings = array(array('ratingcrit', 'rc', Lang::$captionRatingCrit), array('ratingdodge', 'rd', Lang::$captionRatingDodge),
                array('ratingresist', 'rr', Lang::$captionRatingResistance), array('ratinganticrit', 'rac', Lang::$captionRatingActiCrit),
                array('ratingdamage', 'rdm', Lang::$captionRatingDamage), array('ratingaccur', 'ra', Lang::$captionRatingAccur));

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inventory'])) {
				Page::startTransaction('factory_showmfitem');
                $inventoryId = (int)$_POST['inventory'];
                $item = self::$sql->getRecord("SELECT * FROM inventory WHERE id= " . $inventoryId . " AND player=" . self::$player->id . " AND equipped=0 AND usestate IN ('','normal') AND type IN ('weapon','cloth','hat','shoe','pouch','accessory1','talisman','jewellery','cologne','tech')");
                $mfPrice = Page::$data['factory']['mfprice'][$item['mf']];
                if ($kupon) {
                    $mfPrice--;
                }
                if ($item && !($item['level'] < 3 || ($item['level'] < 5 && $item['type'] != 'tech'))) {
                    if ($item['equipped'] == 0) {
						if ($item['type'] == 'tech') {
							$maxMf = 40;
						} else {
							$maxMf = 20;
						}
						$usingCert21 = false;
						if ($item['mf'] == $maxMf) {
							$cert21 = Page::$player->getItemForUseByCode('cert_mf_21');
							if ($cert21) {
								$usingCert21 = true;
							}
						}
                        if ($item['mf'] < $maxMf || $usingCert21) {
                            if (self::$player->ore + self::$player->honey >= $mfPrice || $usingCert21) {
								$priceOre = 0;
								$priceHoney = 0;
								if (!$usingCert21) {
                                if (self::$player->ore >= $mfPrice) {
                                    $priceOre = $mfPrice;
                                    $priceHoney = 0;
                                } else {
                                    $priceOre = self::$player->ore;
                                    $priceHoney = $mfPrice - $priceOre;
                                    $priceHoneyOre = $mfPrice - $priceOre; // для логов
                                }

                                if ($priceHoney > 0) {
                                    $reason	= 'factory mf $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
                                    $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                                }
								}
                                if ($usingCert21 || $priceHoney == 0 || $takeResult[0] == 'OK') {
                                    self::$player->ore -= $priceOre;
                                    self::$player->honey -= $priceHoney;
                                    self::$player->skillupgrade++;

                                    if ($kupon) {
                                        $kupon->useItem();
                                    }

                                    // профессия
                                    for ($i = 0, $j = sizeof(Page::$data['factory']['upgrade']); $i < $j; $i++) {
                                        $prof = Page::$data['factory']['upgrade'][$i];
                                        if ($prof['a'] <= self::$player->skillupgrade && $prof['b'] >= self::$player->skillupgrade) {
                                            break;
                                        }
                                    }
                                    // логи профессии
                                    if (self::$player->skillupgrade == $prof['a']) {
                                        Page::sendLog(self::$player->id, 'skllvl', array('t' => 'mf', 'n' => $prof['n']));
                                    } else {
                                        Page::sendLog(self::$player->id, 'sklup', array('t' => 'mf', 'n' => $prof['n'], 'v' => (self::$player->skillupgrade - $prof['a'])), 1);
                                    }

                                    self::$player->save(self::$player->id, array(playerObject::$ORE, playerObject::$HONEY, playerObject::$SKILLUPGRADE));

                                    $mfLog = array();

									$passatiji = false;
									if (isset($_POST["passatiji"])) {
										$passatij = self::$player->loadItemByCode("passatiji");
										if ($passatij) {
											$passatiji = true;
											$passatij->useWithNoEffect();
										}
									}

                                    if ($item['type'] == 'tech') {
                                        $sMf = 1;
                                    } else {
										if ($passatiji) {
											$sMf = 3;
										} else {
                                        $s2 = $prof['p2'] >= mt_rand(1, 100) ? 1 : 0;
                                        $s3 = $prof['p3'] >= mt_rand(1, 100) ? 1 : 0;
                                        $sMf = 1 + $s2 + $s3;
                                    }
                                    }
                                    $s = $params[$item['type']];
                                    $mfLog['s'] = $s{0};
                                    $mfLog['ss'] = $sMf;
                                    $mfLog['sf'] = $item[$params[$item['type']]] + $sMf;

                                    if ($passatiji) {
										$rMf = 3;
									} else {
                                    $r2 = $prof['p2'] >= mt_rand(1, 100) ? 1 : 0;
                                    $r3 = $prof['p3'] >= mt_rand(1, 100) ? 1 : 0;
                                    $rMf = 1 + $r2 + $r3;
									}

                                    $r = mt_rand(0, 5);
                                    $r0 = $ratings[$r][0];

                                    $mfLog['r'] = $ratings[$r][1];
                                    $mfLog['rr'] = $rMf;
                                    $mfLog['rf'] = $item[$r0] + $rMf;

									$sql = "UPDATE inventory SET mf=mf+1, $s=$s+$sMf, $r0=$r0+$rMf, ore=ore+" . (int) $mfPrice . "
                                        WHERE id=" . $item['id'] . " AND player=" . self::$player->id;
                                    self::$sql->query($sql);


                                    $mbckp = self::$player->getMbckp();
									$log = array('i'=>array('n'=>$item['name'], 'mf'=>($item['mf'] + 1), 't' => $item['type']),
                                        'mf'=>$mfLog, 'mbckp'=>$mbckp);
									if ($usingCert21) {
										$log['c21'] = 1;
										Page::$player->useItemFast($cert21);
									}
                                    Page::sendLog(self::$player->id, 'itmmf', $log, 1);

                                    Page::parseSpecialParams($item);
                                    switch ($item['type']) {
                                        case 'tech':
                                            $sName = $item['special1name'];
                                            break;
                                        default:
                                            $sName = Lang::$captionStats[$params[$item['type']]];
                                            break;
                                    }

                                    Page::addAlert('Предмет улучшен', 'Вы успешно улучшили предмет «<b>' . $item['name'] . '</b>».<br /><br />
                                        '.($sMf > 1 ? 'Благодаря своим навыкам ' : '').'Вы улучшили характеристику <b>' . $sName . '</b>
                                            предмета на <span style="color:'.($sMf > 1 ? ($sMf > 2 ? 'red' : 'green') : '').';"><b>+' . $sMf . '</b></span>
                                                (итого стало +' . ($item[$params[$item['type']]] + $sMf) . ').<br /><br />
                                        Вы также смогли увеличить <b>' . $ratings[$r][2] . '</b> предмета на
                                            <span style="color:'.($rMf > 1 ? ($rMf > 2 ? 'red' : 'green') : '').';"><b>+' . $rMf . '</b></span>
                                            (итого стало +' . ($item[$r0] + $rMf) . ').<br /><br />
                                        '.(self::$player->skillupgrade == $prof['a'] ? '<p class="congr"><img src="/@/images/pics/congr2.png" /><br />Вы получили новое звание: <b>' . $prof['n'] . '</b></p>' :
                                            'Вы увеличили свой навык модификаций. <nobr>Навык мф.: <b>' . (self::$player->skillupgrade - $prof['a']) . '</b></nobr>. <nobr>Звание: <b>' . $prof['n'] . '</b></nobr>'), ALERT_INFO_BIG);

									Page::checkEvent(self::$player->id, 'mf_finished', $item['id']);

                                    Std::redirect('/factory/mf-item/' . $inventoryId . '/');
                                } else {
                                    Page::addAlert(FactoryLang::$errorNoHoney, FactoryLang::$errorNoHoneyText, ALERT_ERROR);
                                }
                            } else {
                                Page::addAlert(FactoryLang::$error, 'У Вас не хватает руды на улучшение предмета. Стоимость улучшения — <span class="ruda">' . $mfPrice . '<i></i></span>');
                            }
                        } else {
                            Page::addAlert(FactoryLang::$error, FactoryLang::$errorMfMax, ALERT_ERROR);
                        }
                    } else {
                        Page::addAlert(FactoryLang::$error, FactoryLang::$errorMfItemOnPlayer, ALERT_ERROR);
                    }
                } else {
                    Page::addAlert(FactoryLang::$error, FactoryLang::$errorItemNotFound, ALERT_ERROR);
                }
            }

            $inventoryId = (int)$this->url[1];
            $item = self::$sql->getRecord("SELECT * FROM inventory WHERE id= " . $inventoryId . " AND player=" . self::$player->id);
            $mfPrice = Page::$data['factory']['mfprice'][$item['mf']];
            if ($kupon) {
                $mfPrice--;
            }
            if ($item) {
                if ($item['equipped'] == 0) {
                    $this->content['inventory'] = $item['id'];

                    Page::parseSpecialParams($item);

                    $item['sell']['money'] = floor($item['money'] * 0.25);
                    $item['sell']['ore'] = floor($item['ore'] * 0.25);
                    $item['sell']['honey'] = floor($item['honey'] * 0.25);
                    $this->content['current'] = $item;

                    $itemMf = $item;

                    switch ($itemMf['type']) {
                        case 'tech':
                            switch ($itemMf['subtype']) {
                                case 'moto':
                                    $itemMf[$params[$itemMf['type']]] += 1;
                                    break;
                            }
                            break;

                        default:
                            $itemMf[$params[$itemMf['type']]] += 1;
                            $itemMf[$params[$itemMf['type']] . '2'] = $itemMf[$params[$itemMf['type']]] + 3;
                            break;
                    }

                    $itemMf['ratingrandom'] = 1;

                    Page::parseSpecialParams($itemMf);

					$maxMf = ($item['type'] == 'tech') ? 40 : 20;

					$usingCert21 = false;
					if ($itemMf['mf'] == $maxMf) {
						$cert21 = Page::$player->getItemForUseByCode('cert_mf_21');
						if ($cert21) {
							$usingCert21 = true;
						}
					}

                    $itemMf['mf']++;
                    $itemMf['ore'] += $mfPrice;
                    $itemMf['sell']['ore'] = floor($itemMf['ore'] * 0.25);

                    $this->content['next'] = $itemMf;

                    $this->content['mfprice'] = $mfPrice;
                    $this->content['mfprice2'] = $mfPrice + 1;
                    
                    $this->content['maxlevel'] = $item['type'] == 'tech' ? 40 : 20;
					if ($cert21) {
						$this->content['maxlevel'] ++;
					}
					if ($this->content['maxlevel'] < $item['mf']) {
						$this->content['maxlevel'] = $item['mf'];
					}
					$this->content['percentlevel'] = min(round($item['mf'] / $this->content['maxlevel'] * 100), 100);

                    $this->content['kupon'] = $kupon ? 1 : 0;

					if ($usingCert21) {
						$this->content['using_cert_21'] = 1;
					} else {
						$this->content['using_cert_21'] = 0;
					}

					if ($item['type'] != 'tech') {
						$passatiji = self::$player->loadItemByCode("passatiji");
						if ($passatiji) {
							$this->content['passatiji'] = 1;
						}
					}

                    $this->content['window-name'] = FactoryLang::$windowTitleMf;
                    $this->page->addPart('content', 'factory/mf-item.xsl', $this->content);
                } else {
                    Page::addAlert(FactoryLang::$error, FactoryLang::$errorMfItemOnPlayer, ALERT_ERROR);
                    Std::redirect('/factory/mf/');
                }
            } else {
                Std::redirect('/factory/mf/');
            }
        } else {
            Page::addAlert(FactoryLang::$error, FactoryLang::$errorMfMinLevel6, ALERT_ERROR);
            Std::redirect('/factory/');
        }
    }

    /**
     * Запуск производства нано-петриков
     */
    private function startPetriks() {
		//$petriks = Page::$data['factory']['petriks'][Page::getGroupLevel(Page::$player->level)];
		$petriks = 5;
		if (self::$player->level >= 5) {
			if ($_POST['player'] == self::$player->id) {
				$npPrice = $petriks;
				$npPriceCoins = 500;
				$items = Factory::getExtendedItems();
				if ($items['double']) {
					$petriks *= 2;
				}
				$params = array('petriks' => $petriks);
				if (self::$sql->getValue("SELECT count(*) FROM playerwork WHERE player=" . self::$player->id . " AND type='petriks'") == 0) {
					//if (self::$player->ore + self::$player->honey >= $npPrice && self::$player->money >= $npPriceCoins) {
					if (self::$player->ore >= $npPrice && self::$player->money >= $npPriceCoins) {
						/*
						  if (self::$player->ore >= $npPrice) {
						  $priceOre = $npPrice;
						  $priceHoney = 0;
						  } else {
						  $priceOre = self::$player->ore;
						  $priceHoney = $npPrice - $priceOre;
						  $priceHoneyOre = $npPrice - $priceOre; // для логов
						  }

						  if ($priceHoney > 0) {
						  $reason	= 'factory petriks $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
						  $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
						  }
						 */

						//if ($priceHoney == 0 || $takeResult[0] == 'OK') {
						self::$player->money -= $npPriceCoins;
						//self::$player->ore -= $priceOre;
						self::$player->ore -= $npPrice;
						//self::$player->honey -= $priceHoney;
						//self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$ORE, playerObject::$HONEY));
						self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$ORE));

						$mbckp = self::$player->getMbckp();
						//Page::sendLog(self::$player->id, 'ptrk1', array('m'=>$npPriceCoins, 'o'=>$priceOre, 'h'=>$priceHoney, 'mbckp'=>$mbckp), 1);
						//Page::sendLog(self::$player->id, 'ptrk1', array('m'=>$npPriceCoins, 'o'=>$npPrice, 'mbckp'=>$mbckp), 1);
						if ($items['instant']) {
							Page::$player->petriks += $petriks;
							Page::$player->save(Page::$player->id, array(playerObject::$PETRIKS));

							//Page::sendLog($w['player'], 'ptrk2', array('p' => Page::$player->petriks));

							Page::checkEvent($w['player'], 'petriks_finished', $petriks);
						} else {
							self::$player->beginBackgroundWork('petriks', 3600, $params);
						}

						if ($items['instant'] && $items['double']) {
							Page::$player->useItemFast($items['instant']);
							Page::$player->useItemFast($items['double']);
							Page::addAlert(FactoryLang::$alertPetriksStart, FactoryLang::$alertPetriksInstantDoubleMakeText);
							Page::sendLog(self::$player->id, 'ptrk2', array('p' => Page::$player->petriks, 'p2' => $petriks, 'i' => 1, 'm' => $npPriceCoins, 'o' => $npPrice, 'mbckp' => $mbckp), 1);
						} else if ($items['double']) {
							Page::$player->useItemFast($items['double']);
							Page::addAlert(FactoryLang::$alertPetriksStart, FactoryLang::$alertPetriksDoubleMakeText);
							Page::sendLog(self::$player->id, 'ptrk1', array('m' => $npPriceCoins, 'o' => $npPrice, 'mbckp' => $mbckp), 1);
						} else if ($items['instant']) {
							Page::$player->useItemFast($items['instant']);
							Page::addAlert(FactoryLang::$alertPetriksStart, FactoryLang::$alertPetriksInstantMakeText);
							Page::sendLog(self::$player->id, 'ptrk2', array('p' => Page::$player->petriks, 'i' => 1, 'm' => $npPriceCoins, 'o' => $npPrice, 'mbckp' => $mbckp, 'p2' => $petriks), 1);
						} else {
							Page::addAlert(FactoryLang::$alertPetriksStart, Std::renderTemplate(FactoryLang::$alertPetriksStartText, array('petriks' => $petriks)));
							Page::sendLog(self::$player->id, 'ptrk1', array('m' => $npPriceCoins, 'o' => $npPrice, 'mbckp' => $mbckp, 'p2' => $petriks), 1);
						}

						//} else {
						//    Page::addAlert(FactoryLang::$errorNoHoney, FactoryLang::$errorNoHoneyText, ALERT_ERROR);
						//}
					} else {
						Page::addAlert(FactoryLang::$error, FactoryLang::$errorPetriksNoMoney, ALERT_ERROR);
					}
				} else {
					Page::addAlert(FactoryLang::$error, FactoryLang::$errorPetriksInProgress, ALERT_ERROR);
				}
			}
		} else {
			Page::addAlert(FactoryLang::$error, FactoryLang::$errorPetriksMinLevel5, ALERT_ERROR);
		}
		Std::redirect('/factory/');
	}

    /**
     * Фарма цех
     */
    private function showFarma()
    {
        Page::addAlert(FactoryLang::$error, FactoryLang::$errorSectionClosed, ALERT_ERROR);
        Std::redirect('/factory/');
    }
}
?>