<?php
class Thimble extends Page implements IModule
{
    public $moduleCode = 'Thimble';

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
            case "start":
                $this->start();
                break;

            case 'play': // генерация поля
                $this->startNewRound();
                break;

            case 'guess': // угадывание
                $this->guess();
                break;

            case 'leave': // выход из игры
                $this->leave();
                break;

            case 'state': // вывод состояния поля
            default:
                $this->showThimble();
                break;
        }
        parent::onAfterProcessRequest();
    }

    private function showThimble()
    {
        if (self::$player->state == "monya") {
            // состояние игры с Моней
            if (self::$player2->naperstki == 1) { // кнопка "Играть"

            } else {
                $game = $this->state();
                $this->content['naperstkidata'] = $game;
                $this->content['naperstkidata']['left'] = $game['c'] == 2 ? 1 - $game['g'] : 3 - $game['g'];
            }
            $this->content['naperstki'] = self::$player2->naperstki;

            $this->content["player"] = self::$player->toArray();

            $this->content['window-name'] = ThimbleLang::WINDOW_TITLE;
            $this->page->addPart('content', 'thimble/thimble.xsl', $this->content);
        } else {
            Std::redirect("/metro/");
        }
    }

    /**
     * Запуск сеанса игры
     */
    private function start() {
        if (self::$player->isFree()) {
            Std::loadMetaObjectClass("inventory");
            $item = new inventoryObject();
            $item = $item->loadByCode("monya_ticket", self::$player->id);

            //$games24 = self::$sql->getValue("SELECT count(*) FROM log WHERE player = " . self::$player->id . " AND type = 'monya' AND dt > '" . date("Y-m-d 00:00:00", time()) . "'");
			$sql = "SELECT count(*) FROM " . Page::$__LOG_TABLE__ . " WHERE player = " . self::$player->id . " AND type = 'monya'";
			$games24 = Page::getData("snowy_metro_monyagames_" . date("Y-m-d", time()) . "_" . self::$player->id, $sql, "value", 3600);
			Page::$cache->set("snowy_metro_monyagames_" . date("Y-m-d", time()) . "_" . self::$player->id, ($games24 + 1), 3600);

            if ($games24 == 0) {
				$newPlayer = true;
			} else {
				$newPlayer = false;
			}
            if ($item || $games24 < 3) {
                if ($games24 >= 3) {
                    $item->useWithNoEffect();
                    Page::sendLog(self::$player->id, "monyat", array(), 1);
                } else {
                    Page::sendLog(self::$player->id, "monya", array(), 1);
                }
                self::$player->state = "monya";
                self::$player->save(self::$player->id, array(playerObject::$STATE));

                self::$player2->naperstki = 1;
                self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKI));

				$sql = "INSERT INTO monya_log (dt, level, enters, players) VALUES ('" . date('Y-m-d') . "', " . Page::$player->level . ", 1, 1) ON DUPLICATE KEY UPDATE enters = enters + 1 " . (($newPlayer) ? ', players = players + 1' : '');
				Page::$sql->query($sql);

                Std::redirect("/thimble/");
            } else {
                Page::addAlert(ThimbleLang::ERROR, ThimbleLang::ERROR_MONYA_DONTWANT_TEXT, ALERT_ERROR);
            }
        } else {
            Page::addAlert(ThimbleLang::ERROR, ThimbleLang::ERROR_MONYA_BUSY_TEXT, ALERT_ERROR);
        }
        Std::redirect("/metro/");
    }

    /**
     * Завершение сеанса игры
     */
    public static function leave() {
		
		if (self::$player->state != "monya") Std::redirect("/metro/");
		
		Thimble::flushStat(Page::$player);
		
        self::$player->state = "";
		Page::$player->saveData(array(playerObject::$STATE));

        self::$player2->naperstki = -1;
        self::$player2->naperstkidata = '';
        self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKI, player2Object::$NAPERSTKIDATA));
        Std::redirect("/metro/");
    }

    /**
     * Попытка угадывания
     */
    public function guess() {
		if (self::$player->state != "monya") Std::redirect("/metro/");
		
		Page::startTransaction('thimble_guess');
        if (self::$player2->naperstki == 2) {
            $cell = (int)$this->url[1];
            $naperstki = json_decode(self::$player2->naperstkidata, true);
            if (isset($naperstki['d'][$cell]) && $naperstki['d'][$cell]['s'] == 0) {
                $naperstki['g']++;
                if ($naperstki['d'][$cell]['r'] == 1) {
                    $naperstki['r']++;
                    $naperstki['d'][$cell]['s'] = 2;
                    self::$player->ore++;
					Page::$player->data['monya']['o'] ++;
                    self::$player->saveData(array(playerObject::$ORE));
                    $result = '1';
                    $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                    //Page::sendLog(self::$player->id, 'nprst1', array('mbckp' => $mbckp), 1);
                } else {
                    $naperstki['d'][$cell]['s'] = 3;
                    $result = '0';
                }
                if (($naperstki['g'] == 1 && sizeof($naperstki['d']) == 2) || ($naperstki['g'] == 3 && sizeof($naperstki['d']) == 9)) {
                    self::$player2->naperstki = 3;
                    foreach ($naperstki["d"] as &$cell) {
                        if ($cell["s"] == 0) {
                            $cell["s"] = 1;
                        }
                    }
                    self::$player2->naperstkidata = json_encode($naperstki);
                    self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKI, player2Object::$NAPERSTKIDATA));
                    $guessesLeft = 0;
                } else {
                    self::$player2->naperstkidata = json_encode($naperstki);
                    self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKIDATA));
                    $guessesLeft = sizeof($naperstki['d']) == 3 ? 1 - $naperstki['g'] : 3 - $naperstki['g'];
                }
            }
        }
		Page::endTransaction('thimble_guess');
        Std::redirect("/thimble/");
    }

    /**
     * Генерация состояния игрового поля
     *
     * @return mixed
     */
    public function state()
    {
        if (self::$player2->naperstki != 1) {
            $naperstki = json_decode(self::$player2->naperstkidata, true);
            $game = array('r' => $naperstki['r'], 'g' => $naperstki['g'], 'c' => sizeof($naperstki['d']), 'd' => array());
            foreach ($naperstki['d'] as $cell) {
                $game['d'][] = $cell['s'];
            }
            return $game;
        } else {
            return false;
        }
    }

    /**
     * Запуск нового раунда
     */
    public function startNewRound()
    {
        if ((self::$player2->naperstki == 1 || self::$player2->naperstki == 3) && self::$player->state == "monya") {
            $num = (int)$this->url[1];
            if ($num != 2 && $num != 9) {
                $num = 2;
            }

            $priceMoney = $num == 2 ? Page::$data["monya"]["price2"] : Page::$data["monya"]["price9"];
            if (self::$player->money >= $priceMoney) {
                self::$player->money -= $priceMoney;
				Page::$player->data['monya']['c'] += $priceMoney;
				Page::$player->data['monya']['g' . $num] ++;
                self::$player->saveData(array(playerObject::$MONEY));

                $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                //Page::sendLog(self::$player->id, 'nprst', array('m' => $priceMoney, 'mbckp' => $mbckp), 1);

                $this->generate($num);
            } else {
                self::$player2->naperstki = 1;
                self::$player2->naperstkidata = '';
                self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKI, player2Object::$NAPERSTKIDATA));

                Page::addAlert(ThimbleLang::ERROR, ThimbleLang::ERROR_NO_MONEY, ALERT_ERROR);
            }
        }
        Std::redirect("/thimble/");
    }

    /**
     * Генерация нового игрового поля
     */
    public function generate($num)
    {
        $naperstki = array();
        for ($i = 0; $i < $num; $i++) {
            $naperstki[] = array('r' => 0, 's' => 0);
        }
        $r = $num == 2 ? 1 : ($num == 9 ? 6 : 0);
        $i = 0;
        while ($i < $r) {
            $n = mt_rand(0, $num - 1);
            if ($naperstki[$n]['r'] == 0) {
                $naperstki[$n]['r'] = 1;
                $i++;
            }
        }

        self::$player2->naperstki = 2;
        self::$player2->naperstkidata = json_encode(array(
            'd' => $naperstki,
            'g' => 0,
            'r' => 0,
        ));
        self::$player2->save(self::$player2->id, array(player2Object::$NAPERSTKI, player2Object::$NAPERSTKIDATA));
    }

	/*
	 * Отправить лог игр анаперстков
	 */
	public static function flushStat($player, $showMbckp = true) {
		$log = array('m' => (int) $player->data['monya']['c'], 'g2' => (int) $player->data['monya']['g2'], 'g9' => (int) $player->data['monya']['g9'], 'o' => (int) $player->data['monya']['o']);
		if ($showMbckp) {
			$mbckp = array('m' => $player->money, 'o' => $player->ore, 'h' => $player->honey);
			$log['mbckp'] = $mbckp;
}
		Page::sendLog($player->id, 'nprstnew', $log, 1);

		if ($player->data['monya']['o'] > 0) {
			$sql = "UPDATE monya_log SET ore = ore + " . $player->data['monya']['o'] . " WHERE dt = '" . date('Y-m-d') . "' AND level = " . $player->level;
			Page::$sql->query($sql);
		}

		unset($player->data['monya']);
	}
}
?>