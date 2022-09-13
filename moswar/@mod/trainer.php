<?php
class Trainer extends Page implements IModule
{
    public $moduleCode = 'Trainer';

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
            case 'train':
                $this->train();
                break;

            case 'buy-anabolics':
                $this->buyAnabolics();
                break;

            case 'start-vip-training':
                $this->startVipTraining();
                break;

            case 'activate-vip':
                $this->activateVip();
                break;

            case 'vip':
                $this->showVipTrainer();
                break;

            default:
                $this->showTrainer();
                break;
		}
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Увеличение характеристики персонажа
     */
	protected function train()
	{
		$ok = false;
		foreach (Page::$data['stats'] as $stat) {
			if ($stat['code'] == $this->url[1]) {
				$ok = true;
				$this->content['success-stat'] = $stat['name'];
				break;
			}
		}
		if ($ok === false) {
			Std::redirect('/trainer/');
		}
		$needMoney = Page::calcTrainerCost(self::$player->{$this->url[1]}, $this->url[1]);
		Page::startTransaction('trainer_train');
		if (self::$player->money >= $needMoney) {
			self::$player->money -= $needMoney;
			self::$player->{$this->url[1]} ++;
			self::$player->{$this->url[1] . '_finish'} = round((self::$player->{$this->url[1]} + self::$player->{$this->url[1] . '_bonus'} + self::$player->flag_bonus) * (100 + self::$player->{$this->url[1] . '_percent'}) / 100);
			$oldMaxhp = self::$player->maxhp;
            self::$player->calcMaxHp();
			if ($oldMaxhp < self::$player->maxhp) {
				self::$player->setFullHP();
			}
			self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::${strtoupper($this->url[1])}, playerObject::${strtoupper($this->url[1]) . '_FINISH'}, playerObject::$MAXHP));
            self::$player->updateStatsum();
            $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
			Page::sendLog(self::$player->id, 'trainer_stat', array(
                's' => $this->url[1]{0},
                'v' => self::$player->{$this->url[1]},
                'm' => $needMoney,
                'mbckp' => $mbckp,
                ), 1);
			Runtime::set('content/success-stat', $this->content['success-stat']);
			Page::endTransaction('trainer_train');
			Std::Redirect('/trainer/');
		} else {
			$this->content['error-stat'] = Page::calcTrainerCost(self::$player->{$this->url[1]}, $this->url[1]) - self::$player->money;
			$this->content['success-stat'] = '';
		}
	}

	protected function showTrainer()
	{
		if (Runtime::get('content/success-stat') !== false) {
			$this->content['success-stat'] = Runtime::get('content/success-stat');
			Runtime::clear('content/success-stat');
		}
		$this->content['player'] = self::$player->toArray();
		$maxstat = max ($this->content['player']['health'], $this->content['player']['dexterity'], $this->content['player']['strength'], $this->content['player']['intuition'], $this->content['player']['charism'], $this->content['player']['resistance'], $this->content['player']['attention']);
		foreach (Page::$data['stats'] as $key => $stat) {
			$stat = $stat['code'];
			$this->content['player']['procent'.$stat] = floor ($this->content['player'][$stat] / $maxstat * 100);
			$this->content['player'][$stat.'cost'] = Page::calcTrainerCost ($this->content['player'][$stat], $stat);
			if ($this->content['success-stat'] == $stat) {
				$this->content['success-stat'] = Page::$data['stats'][$key]['name'];
			}
		}
		$this->content['window-name'] = TrainerLang::$windowTitleBasic;
		$this->page->addPart ('content', 'trainer/trainer.xsl', $this->content);
	}

    /**
     * VIP-зал
     */
    protected function showVipTrainer()
	{
        $this->content['player'] = self::$player->toArray();
        $this->content['anabolics2'] = (self::$player->petriks + self::$player->honey) * 10;
        
        if (self::$player->level >= 5) {
            $curVipDt = strtotime(self::$player->viptrainerdt);

            if ($curVipDt > time()) {
                $this->content['mystats'] = self::$player->health.','.self::$player->strength.','.self::$player->dexterity.','.
                        self::$player->resistance.','.self::$player->intuition.','.self::$player->attention.','.self::$player->charism;

                $this->content['leveldown'] = 0;
                $level = Page::getGroupLevel(self::$player->level);
                /*while ($level > 14 && self::$sql->getValue("SELECT count(*) FROM player WHERE level=" . $level) < 150) {
                    $level--;
                    $this->content['leveldown'] = 1;
                }*/
				if ($level != Page::$player->level) {
					$this->content['leveldown'] = 1;
				}

                $avgStats = self::$sql->getRecord("SELECT health, strength, dexterity, resistance, intuition, attention, charism
                    FROM levelstat WHERE level=" . $level . " AND type=1 ORDER BY id DESC LIMIT 0,1");
                $this->content['avgstats'] = $avgStats['health'].','.$avgStats['strength'].','.$avgStats['dexterity'].','.
                        $avgStats['resistance'].','.$avgStats['intuition'].','.$avgStats['attention'].','.$avgStats['charism'];


                $this->content['vip'] = array(
                    'active' => 1,
                    'showbuybutton' => $curVipDt <= time() ? 'block' : 'none',
                    'dt' => date('d.m.Y H:i', $curVipDt),
                );

                $training = self::$sql->getRecord("SELECT * FROM playerwork WHERE player=" . self::$player->id . " AND type='training'");
                if ($training) {
                    $timer = $training['endtime'] - time();
                    $this->content['trainingprocesstimeleft'] = $timer > 0 ? $timer : 0;
                    $this->content['trainingprocesstimeleft2'] = date('H:i:s', $timer);
                    $this->content['trainingprocesstimetotal'] = $training['time'];
                    $this->content['trainingprocesspercent'] = round(($training['time'] - $timer) / $training['time'] * 100);
                    $this->content['trainingprocess'] = 1;
                } else {
                    $this->content['trainingprocess'] = 0;
                }
            } else {
                $this->content['vip'] = array('active' => 0);
            }
        }

		$this->content['window-name'] = TrainerLang::$windowTitleVip;
		$this->page->addPart ('content', 'trainer/vip.xsl', $this->content);
	}

    /**
     * Покупка анаболиков за нано-петрики и мёд
     */
    private function buyAnabolics()
    {
        if (self::$player->level >= 5) {
            $count = abs((int)$_POST['count']);
            $curVipDt = strtotime(self::$player->viptrainerdt);
            if ($_POST['player'] == self::$player->id && $count > 0 && $curVipDt > time()) {
                $aPrice = 1;

                if (self::$player->petriks + self::$player->honey >= $count * $aPrice) {
                    $price = $count * $aPrice;
                    if (self::$player->petriks >= $price) {
                        $pricePetriks = $price;
                        $priceHoney = 0;
                    } else {
                        $pricePetriks = self::$player->petriks;
                        $priceHoney = $price - $pricePetriks;
                        $priceHoneyPetriks = $price - $pricePetriks; // для логов
                    }

                    if ($priceHoney > 0) {
                        $reason	= 'trainer anabolics $' . $priceHoney . ' (' . (int)$priceHoneyPetriks . ') + p' . $pricePetriks;
                        $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                    }
                    if ($priceHoney == 0 || $takeResult[0] == 'OK') {
                        self::$player->petriks -= $pricePetriks;
                        self::$player->honey -= $priceHoney;
                        self::$player->anabolics += $count * 10;

                        self::$player->save(self::$player->id, array(playerObject::$ANABOLICS, playerObject::$PETRIKS, playerObject::$HONEY));

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey, "a" => self::$player->anabolics, "p" => self::$player->petriks);
                        Page::sendLog(self::$player->id, 'trnrbnbl', array('a'=>($count * 10), 'p'=>$pricePetriks, 'h'=>$priceHoney, 'mbckp'=>$mbckp), 1);

                        Page::addAlert('Анаболики готовы', 'Тренер изготовил для Вас <span class="anabolic">' . ($count * 10) . '<i></i></span> по особому рецепту.');
                    } else {
                        Page::addAlert(TrainerLang::$errorNoHoney, TrainerLang::$errorNoHoneyText);
                    }
                } else {
                    Page::addAlert(TrainerLang::$error, 'У Вас недостаточно денег для покупки такого количества <span class="anabolic"><i></i>анаболиков</span>.');
                }
            } else {
                Page::addAlert(TrainerLang::$error, 'Почему-то Вы не смогли купить <span class="anabolic"><i></i>анаболики</span>.');
            }
        } else {
            Page::addAlert(TrainerLang::$error, 'Покупать <span class="anabolic"><i></i>анаболики</span> можно только с 5-го уровня.');
        }
        Std::redirect('/trainer/vip/');
    }

    /**
     * Запуск тренировок
     */
    private function startVipTraining()
    {
        if (self::$player->level >= 5) {
            $curVipDt = strtotime(self::$player->viptrainerdt);
            if ($_POST['player'] == self::$player->id && $curVipDt > time()) {
				Page::startTransaction('trainer_startviptraining');
                if (self::$sql->getValue("SELECT count(*) FROM playerwork WHERE player=" . self::$player->id . " AND type='training'") == 0) {
                    $price = 0;

                    $level = self::$player->level;
                    while ($level > 14 && self::$sql->getValue("SELECT count(*) FROM player WHERE level=" . $level) < 60) {
                        $level--;
                    }

                    $avgStats = self::$sql->getRecord("SELECT health, strength, dexterity, resistance, intuition, attention, charism
                        FROM levelstat WHERE level=" . $level . " AND type=1 ORDER BY id DESC LIMIT 0,1");

                    $stats = array('health', 'strength', 'dexterity', 'resistance', 'intuition', 'attention', 'charism');
                    $statsToTrain = array();
                    $statsToTrainCount = 0;

                    foreach ($stats as $stat) {
                        $c = abs((int)$_POST[$stat]);
                        if ($c > 0) {
                            $a = round($this->trainerCostAdd(self::$player->{$stat}, self::$player->{$stat} + $c, $avgStats[$stat], $stat), 1);
                            $statsToTrain[$stat{0}] = array(
                                'c' => (int)$c,
                                'a' => (int)$a,
                            );
                            $statsToTrainCount += $c;
                            $price += $a;
                        }
                    }
                    $price = round($price);

                    if ($statsToTrainCount > 0) {

                        if (self::$player->anabolics < $price) {
                            if (isset($_POST['autodeficit'])) {
                                $needAnabolics = $price - self::$player->anabolics;
                                $anabilicsPrice = ceil($needAnabolics / 10);
                                $anabilicsCount = $anabilicsPrice * 10;
                                if ($anabilicsPrice <= (self::$player->petriks + self::$player->honey)) {
                                    if (self::$player->petriks >= $anabilicsPrice) {
                                        $anabolicsPricePetriks = $anabilicsPrice;
                                        $anabolicsPriceHoney = 0;
                                    } else {
                                        $anabolicsPricePetriks = self::$player->petriks;
                                        $anabolicsPriceHoney = $anabilicsPrice - $anabolicsPricePetriks;
                                        $anabolicsPriceHoneyPetriks = $anabilicsPrice - $anabolicsPriceHoneyPetriks; // для логов
                                    }

                                    if ($anabolicsPriceHoney > 0) {
                                        $reason	= 'trainer anabolics auto $' . $anabolicsPriceHoney . ' (' . (int)$anabolicsPriceHoneyPetriks . ') + p' . $anabolicsPricePetriks;
                                        $takeResult = self::doBillingCommand(self::$player->id, $anabolicsPriceHoney, 'takemoney', $reason, $other);
                                    }
                                    if ($anabolicsPriceHoney == 0 || $takeResult[0] == 'OK') {
                                        self::$player->petriks -= $anabolicsPricePetriks;
                                        self::$player->honey -= $anabolicsPriceHoney;
                                        self::$player->anabolics += $anabilicsCount;

                                        self::$player->save(self::$player->id, array(playerObject::$ANABOLICS, playerObject::$PETRIKS, playerObject::$HONEY));

                                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                                        Page::sendLog(self::$player->id, 'trnrbnbl', array('auto'=>1, 'a'=>$anabilicsCount, 'p'=>$anabolicsPricePetriks, 'h'=>$anabolicsPriceHoney, 'mbckp'=>$mbckp), 1);

                                        $alertText2 = '<p>Автоматически куплены <span class="anabolic">' . $anabilicsCount . '<i></i></span>.</p>';
                                    } else {
                                        Page::addAlert(TrainerLang::$errorNoHoney, TrainerLang::$errorNoHoneyText);
                                        Std::redirect('/trainer/vip/');
                                    }
                                }
                            }
                        }

                        if (self::$player->anabolics >= $price) {
                            self::$player->anabolics -= $price;

                            self::$player->save(self::$player->id, array(playerObject::$ANABOLICS));

                            //Page::sendLog(self::$player->id, 'trnrsttr', array('a'=>$price, 'mbckp'=>$mbckp), 1);

                            self::$player->beginBackgroundWork('training', $statsToTrainCount * 600);

                            $stats = array('h'=>'health', 's'=>'strength', 'd'=>'dexterity', 'r'=>'resistance',
                                'i'=>'intuition', 'a'=>'attention', 'c'=>'charism');

                            $sql = array();
                            $healthChanged = false;
                            foreach ($statsToTrain as $stat => $params) {
                                $sql[] = $stats[$stat] . '=' . $stats[$stat] . '+' . $params['c'] . ',' .
                                    $stats[$stat] . '_finish=' . $stats[$stat] . '_finish+' . $params['c'];
                                $alertText .= '<br />' . Page::$data['stats'][$stats[$stat]]['name'] . ': +' . $params['c'];
                                if ($stat == 'h' || $stat == 'r') {
                                    $healthChanged = true;
                                }
                            }
                            if (sizeof($sql) > 0) {
                                self::$sql->query("UPDATE player SET " . implode(',', $sql) . " WHERE id=" . self::$player->id);
                            }

                            if ($healthChanged) {
                                self::$player->load(self::$player->id);
                                self::$player->loadHP();
								self::$player->setMaxHP(self::$player->health_finish * 10 + self::$player->resistance_finish * 4);
                                self::$player->save(self::$player->id, array(playerObject::$MAXHP));
								self::$player->setFullHP();
                            }

                            self::$player->updateStatsum();

                            Page::sendLog(self::$player->id, 'trnrfntr', array('s'=>$statsToTrain,'a'=>$price));

                            Page::addAlert('Тренировки', '<p>Вы усердно тренировались согласно персональной программе и прокачали:' . $alertText . '</p>' . $alertText2);

							Page::checkEvent(self::$player->id, 'viptrainer_finished', $statsToTrainCount);
                        } else {
                            Page::addAlert(TrainerLang::$error, 'У Вас недостаточно <span class="anabolic"><i></i>анаболиков</span> для прохождения курса тренировок.', ALERT_ERROR);
                        }
                    } else {
                        Page::addAlert(TrainerLang::$error, 'Вы не выбрали ни одной характеристики для тренировки.', ALERT_ERROR);
                    }
                } else {
                    Page::addAlert(TrainerLang::$error, 'Вы уже усердно тренируетесь по персональной программе.', ALERT_ERROR);
                }
            }
        } else {
            Page::addAlert(TrainerLang::$error, 'Персональные тренировки доступны только с 5-го уровня.');
        }
        Std::redirect('/trainer/vip/');
    }

    private function trainerCost($myStat, $avgStat, $stat)
    {
        $k = array('health' => 2.5, 'strength' => 2.9, 'dexterity' => 2.6, 'intuition' => 2.4,
            'attention' => 2.2, 'resistance' => 2.8, 'charism' => 2.7);
        $minK = 2.6;

        $statK = $k[$stat] / $minK;
        
        $ratio = $myStat / $avgStat;
        $cost = (pow(2, $ratio) - 1) * (pow(3, $ratio) - 1) * 3.3 * $statK;
        $cost *= 10; // в петриках
		if ($cost<10) $cost=10;
        return $cost;
    }

    private function trainerCostAdd($curStat, $needStat, $avgStat, $stat)
    {
        $sum = 0;
        for ($i = $curStat + 1; $i <= $needStat; $i++) {
            $sum += $this->trainerCost($i, $avgStat, $stat);
        }
        return $sum;
    }

    /**
     * Активация и продление ВИПа
     */
    private function activateVip()
    {
        if (self::$player->level >= 5) {
            if ($_POST['player'] == self::$player->id) {
                $price = 14;
				Page::startTransaction('trainer_activatevip');
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
                        $reason	= 'trainer vip $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
                        $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                    }
                    if ($priceHoney == 0 || $takeResult[0] == 'OK') {
                        self::$player->ore -= $priceOre;
                        self::$player->honey -= $priceHoney;

                        $curVipDt = strtotime(self::$player->viptrainerdt);
                        $vipSec = 14 * 24 * 60 * 60;
                        $newVipTime = $curVipDt <= time() ? time() + $vipSec : $curVipDt + $vipSec;
                        self::$player->viptrainerdt = date('Y-m-d H:i:s', $newVipTime);

                        self::$player->anabolics += 50;

                        self::$player->save(self::$player->id, array(playerObject::$VIPTRAINERDT, playerObject::$ORE, playerObject::$HONEY, playerObject::$ANABOLICS));

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                        Page::sendLog(self::$player->id, 'trnrvp', array('a' => 50, 'o'=>$priceOre, 'h'=>$priceHoney, 'dt'=>date('d.m.Y H:i', $newVipTime), 'mbckp'=>$mbckp), 1);

                        Page::addAlert('Персональный тренер', 'Теперь Вы можете пользоваться услугами персонального тренера до ' . date('d.m.Y H:i', $newVipTime) . '.
                            <br />В качестве бонуса Вы получили <span class="anabolic">50<i></i></span>.');

						Page::checkEvent(self::$player->id, 'viptrainer_buy');
                    } else {
                        Page::addAlert(TrainerLang::$errorNoHoney, TrainerLang::$errorNoHoneyText);
                    }
					Page::endTransaction('trainer_activatevip');
                } else {
                    Page::addAlert(TrainerLang::$error, 'У Вас не хватает денег на ВИП-абонемент.');
                }
            }
        } else {
            Page::addAlert(TrainerLang::$error, 'Персональные тренировки доступны только с 5-го уровня.');
        }
        Std::redirect('/trainer/vip/');
    }
}
?>
