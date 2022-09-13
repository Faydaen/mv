<?php
class Bank extends Page implements IModule {
    public $moduleCode = 'Bank';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
		$this->needAuth();

        switch ($this->url[0]) {
            case 'activate':
                $this->activateBank();
                break;
            
            case 'put':
                $this->putMoney();
                break;
            
            case 'take':
                $this->takeMoney();
                break;

            case "buy-ore":
                $this->buyOre();
                break;
            
            default:
                $this->showBank();
                break;
        }

        if ($_POST['action'] == 'deposit') {
			$result = Bank::deposit($_POST['money'], $_POST['days']);
			Runtime::set('content/result', $result);
			Std::redirect($result['url']);
		} elseif ($_POST['action'] == 'withdraw') {
			$result = Bank::withdraw();
			Runtime::set('content/result', $result);
			Std::redirect($result['url']);
		}
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Взять деньги со счета
     */
    private function takeMoney()
    {
        if (self::$player->level >= 5) {
            if ($_POST['player'] == self::$player->id) {
				Page::startTransaction('bank_takemoney');
                $myMoney = self::$sql->getRecord("SELECT money, enddt FROM bankdeposit WHERE player=" . self::$player->id);
                if ($myMoney) {
                    $endTime = strtotime($myMoney['enddt']);
                    if ($endTime <= time()) {
                        self::$player->money += $myMoney['money'];
                        self::$player->save(self::$player->id, array(playerObject::$MONEY));

                        self::$sql->query("DELETE FROM bankdeposit WHERE player=" . self::$player->id);

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                        Page::sendLog(self::$player->id, 'bnktk', array('m'=>$myMoney['money'], 'mbckp'=>$mbckp), 1);

                        Page::addAlert('Банковский вклад', 'Вы забрали <span class="tugriki">' . number_format($myMoney['money'], 0, '', ',') . '<i></i></span> со своего банковского счета.');
                    } else {
                        Page::addAlert('Ошибка', 'Вы не можете забрать <span class="tugriki"><i></i>деньги</span> из банка до ' . date('d.m.Y H:i', strtotime($myMoney['enddt'])) . '.');
                    }
                } else {
                    Page::addAlert('Ошибка', 'На Вашем счету в банке нет <span class="tugriki"><i></i>денег</span>.');
                }
				Page::endTransaction('bank_takemoney');
            } else {
                Page::addAlert('Ошибка', 'Почему-то Вы не смогли совершить банковскую операцию.');
            }
        } else {
            Page::addAlert('Ошибка', 'Услуги банка предоставляются только персонажам 5-го и более уровня.');
        }
        Std::redirect('/bank/');
    }

    /**
     * Положить деньги на счет
     */
    private function putMoney()
    {
        if (self::$player->level >= 5) {
            $putMoney = round(self::$player->money / 2);
            $curBankDt = strtotime(self::$player->bankdt);
            if ($_POST['player'] == self::$player->id) {
				Page::startTransaction('bank_putmoney');
                if ($curBankDt > time()) {
                    if ($putMoney > 100) {
                        $myMoney = self::$sql->getValue("SELECT money FROM bankdeposit WHERE player=" . self::$player->id);
                        if (!$myMoney) {
                            self::$player->money -= $putMoney;

                            self::$player->save(self::$player->id, array(playerObject::$MONEY));

                            Std::loadMetaObjectClass('bankdeposit');
                            $d = new bankdepositObject();
                            $d->money = $putMoney;
                            $d->dt = date('Y-m-d H:i:s', time());
                            $d->enddt = date('Y-m-d H:i:s', time() + 24 * 60 * 60);
                            $d->player = self::$player->id;
                            $d->save();

                            $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                            Page::sendLog(self::$player->id, 'bnkpt', array('m'=>$putMoney, 'mbckp'=>$mbckp), 1);

                            Page::addAlert('Банковский вклад', 'Вы положили <span class="tugriki">' . number_format($putMoney, 0, '', ',') . '<i></i></span> на свой банковский счет.');
                        } else {
                            Page::addAlert(BankLang::$error, 'Вы не можете сделать следующий вклад, пока на пройдет срок предыдущего.');
                        }
                    } else {
                        Page::addAlert(BankLang::$error, 'Минимальный депозит — <span class="tugriki">100<i></i></span>.');
                    }
                } else {
                    Page::addAlert(BankLang::$error, 'Чтобы положить <span class="tugriki"><i></i>деньги</span> в банк необходимо оплатить банковскую ячейку.');
                }
				Page::endTransaction('bank_putmoney');
            } else {
                Page::addAlert(BankLang::$error, 'Почему-то Вы не смогли совершить банковскую операцию.');
            }
        } else {
            Page::addAlert(BankLang::$error, BankLang::$errorLowLevelText);
        }
        Std::redirect('/bank/');
    }

    /**
     * Страница банка
     */
	public function showBank()
    {
		// мой счет (статус)
        $curBankDt = strtotime(self::$player->bankdt);
        if ($curBankDt > time()) {
            $this->content['bank'] = array(
                'active' => 1,
                'dt' => date('d.m.Y H:i', $curBankDt),
            );
        } else {
            $this->content['bank'] = array('active' => 0);
        }

        // мой счет (деньги)
        $myMoney = self::$sql->getRecord("SELECT money, enddt FROM bankdeposit WHERE player=" . self::$player->id);
        if ($myMoney) {
            $this->content['bank']['mymoney'] = $myMoney['money'];
            $this->content['bank']['mydt'] = date('d.m.Y H:i', strtotime($myMoney['enddt']));
            $this->content['bank']['cantake'] = strtotime($myMoney['enddt']) <= time() ? 1 : 0;
        } else {
            $this->content['bank']['mymoney'] = 0;
            $this->content['bank']['newmoney'] = round(self::$player->money / 2);
        }

        // ограбление банка
        Std::loadModule('Fight');
        $h = date('H', time());
        $fight = array(
            'id' => 0,
            'left' => array(),
            'right' => array(),
            'me' => 0,
            'state' => '',
            'nearesthour' => ($h < 10 ? 10 : ($h < 16 ? 16 : ($h < 20 ? 20 : 10))),
            'minbribe' => (self::$player->level - 4) * 100,
        );

		$curMaxLevel = CacheManager::get('value_maxlevel');
		$curBankFightMaxLevel = CacheManager::get('value_bankfightmaxlevel');

        if (self::$player->level > $curBankFightMaxLevel) {
            $bFight = self::$sql->getRecord("SELECT id, data, players, dt, state, ac, dc, level FROM fight WHERE type = 'bank' AND (state = 'created' OR state = 'started') AND level=" . $curBankFightMaxLevel);
        } else {
            $bFight = self::$sql->getRecord("SELECT id, data, players, dt, state, ac, dc, level FROM fight WHERE type = 'bank' AND (state = 'created' OR state = 'started') AND level=" . self::$player->level);
        }
        if ($bFight) {
            $fight['id'] = $bFight['id'];
            $fight['state'] = $bFight['state'];

            $bribes = self::$sql->getValueSet("SELECT p2.bankbribe FROM player2 p2
                LEFT JOIN player p ON p.id=p2.player WHERE 
                (p.level=" . $bFight['level'] . " " . ($curBankFightMaxLevel < $curMaxLevel && (int)$bFight['level'] == $curBankFightMaxLevel ? " OR p.level=$curMaxLevel " : '') . ")
                AND p2.bankbribe>0");
            $fight['totalbribes'] = $bribes ? array_sum($bribes) : 0;
            $fight['robbers'] = $bribes ? sizeof($bribes) : 0;
            $fight['me'] = self::$player2->bankbribe > 0 ? 1 : 0;
        }
        $this->content['fight'] = $fight;

        // итого в банке
        $this->content['bank']['total'] = (int)Page::getData('bank/total', "SELECT sum(money) FROM bankdeposit", 'value', 300);

        // обмен руды
        Std::loadMetaObjectClass("inventory");
        $item = new inventoryObject();
        $item = $item->loadByCode("ore_ticket", self::$player->id);
        $this->content["orechange"] = $item ? 1 : 0;

        $this->content['window-name'] = BankLang::$windowTitle;
		$this->content['player'] = self::$player->toArray();

		$this->page->addPart('content', 'bank/bank.xsl', $this->content);
	}

    /**
     * Открытие/продление банковской ячейки
     */
    private function activateBank()
    {
        if (self::$player->level >= 5) {
            if ($_POST['player'] == self::$player->id) {
                $price = 14;
				Page::startTransaction('bank_activatebank');
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
                        $reason	= 'bank activate $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
                        $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                    }
                    if ($priceHoney == 0 || $takeResult[0] == 'OK') {
                        self::$player->ore -= $priceOre;
                        self::$player->honey -= $priceHoney;

                        $curBankDt = strtotime(self::$player->bankdt);
                        $bankSec = 14 * 24 * 60 * 60;
                        $newBankTime = $curBankDt <= time() ? time() + $bankSec : $curBankDt + $bankSec;
                        self::$player->bankdt = date('Y-m-d H:i:s', $newBankTime);

                        self::$player->save(self::$player->id, array(playerObject::$BANKDT, playerObject::$ORE, playerObject::$HONEY));

                        $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                        Page::sendLog(self::$player->id, 'bnkactv', array('o'=>$priceOre, 'h'=>$priceHoney, 'dt'=>date('d.m.Y H:i', $newBankTime), 'mbckp'=>$mbckp), 1);

                        // дарение бонусной жвачки
                        $gum = self::$sql->getValue("SELECT id FROM standard_item WHERE code='gum_" . Page::$data['statslist'][mt_rand(0,5)] . "2' AND level<=" . self::$player->level . " ORDER BY level DESC");

                        Std::loadMetaObjectClass('standard_item');
                        $item = new standard_itemObject();
                        $item->load($gum);
                        $item->makeExampleOrAddDurability(self::$player->id);

                        Page::addAlert('Банковская ячейка', '<p>Теперь Вы можете пользоваться банковской ячейкой до <b>' . date('d.m.Y H:i', $newBankTime) . '</b>.</p>
                            <p>Как одному из своих самых ценных клиентов Банк дарит Вам жвачку: <b>' . $item->name . '</b>.</p>');

						Page::checkEvent(self::$player->id, 'bankcell_buy');
                    } else {
                        Page::addAlert(BankLang::$errorNoHoney, BankLang::$errorNoHoneyText);
                    }
					Page::endTransaction('bank_activatebank');
                } else {
                    Page::addAlert(BankLang::$error, 'У Вас не хватает денег для открытия банковской ячейки.');
                }
            }
        } else {
            Page::addAlert(BankLang::$error, BankLang::$errorLowLevelText);
        }
        Std::redirect('/bank/');
    }

    /**
     * Подсчет сумм грабежа для уровней
     *
     * @return array
     */
    public static function getRobberyLevelMoney()
    {
        Std::loadModule('Page');

        $sql = SqlDataSource::getInstance();
        
        $maxLevel = CacheManager::get('value_bankfightmaxlevel');

        $stats = $sql->getRecordSet("SELECT level, health, strength, dexterity, intuition, resistance, attention, charism
            FROM levelstat WHERE level BETWEEN 5 AND $maxLevel AND dt='" . date('Y-m-d', time() - 24 * 60 * 60) . "'");

        // подсчет стоимости средних статов на уровнях
        $statsCostByLevel = array();
        $totalStatsCost = 0;
        foreach ($stats as $i => $level) {
            foreach ($level as $stat => $value) {
                if ($stat == 'level') {
                    $level = $value;
                    $statsCostByLevel[$level] = 0;
                    continue;
                }
                $statCost = Page::calcTrainerCost($value, $stat);
                $statsCostByLevel[$level] += $statCost;
                $totalStatsCost += $statCost;
            }
        }

        // подсчет соотношения стоимости средних статов на уровнях
        $levelPercent = array();
        foreach ($statsCostByLevel as $level => $cost) {
            $levelPercent[$level] = $cost / $totalStatsCost;
        }

        $bankMoney = $sql->getValue("SELECT sum(money) FROM bankdeposit") * 0.1;

        // подсчет призового фонда на каждый уровень
        $levelMoney = array();
        foreach ($levelPercent as $level => $percent) {
            $levelMoney[$level] = round($bankMoney * $percent);
        }

        return $levelMoney;
    }

    /**
     * Покупка руды за монеты
     */
    private function buyOre()
    {
        Std::loadMetaObjectClass("inventory");
        $item = new inventoryObject();
		Page::startTransaction('bank_buyore');
        $item = $item->loadByCode("ore_ticket", self::$player->id);
        if ($item) {
            $ore = abs((int)$_POST["ore"]);
            $money = $ore * Page::$data["bank"]["money2ore"];
            if ($money > 0 && self::$player->money >= $money) {
                $item->useWithNoEffect();
                
                self::$player->money -= $money;
                self::$player->ore += $ore;
                self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$ORE));

                $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                Page::sendLog(self::$player->id, "bnkm2o", array('o' => $ore, 'm' => $money, 'mbckp' => $mbckp), 1);

                Page::addAlert(BankLang::ALERT_OK, Lang::renderText(BankLang::ALERT_ORE_CHANGED, array('ore' => $ore, 'money' => $money)));
            } else {
                Page::addAlert(BankLang::ERROR, BankLang::ERROR_NO_MONEY, ALERT_ERROR);
            }
        } else {
            Page::addAlert(BankLang::ERROR, BankLang::ERROR_NO_TICKET, ALERT_ERROR);
        }
		Page::endTransaction('bank_buyore');
        Std::redirect("/bank/");
    }
}
?>