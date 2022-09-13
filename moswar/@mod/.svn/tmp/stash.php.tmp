<?php
class Stash extends Page implements IModule
{
	public $moduleCode = 'Stash';

	private $wmr = "R239734663335";
	private $wSecretKey = "KeYm0sw4rW3Bm0neyKeY";
	private $smsKey = "035bbaf376bcec29fd3508333cb565ab";
    private $pay2secretKey = 'p4y2sup3rS3CR3Tk3y';

	

    const PAY2_RESULT_OK = 0;
    const PAY2_RESULT_ERROR_TRYLATER = 1;
    const PAY2_RESULT_ERROR_IDNOTFOUND = 2;
    const PAY2_RESULT_ERROR_MD5 = 3;
    const PAY2_RESULT_ERROR_PARAMS = 4;
    const PAY2_RESULT_ERROR_CUSTOM = 5;
    const PAY2_RESULT_ERROR_DENY = 7;

    private $sms_prefix = 'mw';

    //private $yandex_shop_id = '';
    //private $yandex_scid = '';
    //private $yandex_url = 'https://demomoney.yandex.ru/eshop.xml';//'https://money.yandex.ru/eshop.xml';

    //private $webmoney_purse = '';

    //private $rbk_shop_id = '';
    //private $rbk_url = 'https://rbkmoney.ru/acceptpurchase.aspx';

    //private $onlinedengi_url = 'http://www.onlinedengi.ru/wmpaycheck.php';
    //private $onlinedengi_shop_id = '';
    //private $onlinedengi_source_id = '';

    public function __construct() {
		parent::__construct();
	}

	public function processRequest()
    {
		parent::onBeforeProcessRequest();
		if (($this->url[0] != "webmoney" && $this->url[1] != "result")
			&& ($this->url[0] != 'sms' && $this->url[1] != 'payment')) {
			//$this->needAuth();
		}
		if ($this->url[0] == 'webmoney' && $this->url[1] == 'result') {

		} else if ($this->url[0] == 'sms' && $this->url[1] == 'payment') {

        } else if ($this->url[0] == 'pay2') {

        } else if ($this->url[0] == 'addmoney' || $this->url[0] == 'buyhoney') {

		} else {
			$this->needAuth(false);
		}
		//

		switch ($this->url[0]) {
			case 'usecert':
				$this->useCertificate();
				break;

			case 'becomemajor':
				 $this->becomeMajor();
				break;

			case "webmoney" :
				switch ($this->url[1]) {
					/*
                    case "result" :
						if ($_POST["LMI_PREREQUEST"] == 1) {
							Std::loadMetaObjectClass("payment");
							$paymentObject = new paymentObject();
							$paymentObject->load($_POST["LMI_PAYMENT_NO"]);
							if ($paymentObject->value == $_POST["LMI_PAYMENT_AMOUNT"]){
								echo "YES";
								exit;
							} else {
								echo "NO";
								exit;
							}
						} else if ((int)$_POST["LMI_PAYMENT_NO"] > 0) {
							$this->webmoneyVerify();
						} else {
							echo "NO";
							exit;
						}
						break;
                    */

					case "step2":
						$this->showWebmoneyStep2();
						break;

					case "success":
						$this->webmoneySuccess();
						break;

                    case "error":
						$this->webmoneyError();
						break;

					default:
						$this->showWebmoneyStep1();
                        break;
				}
				break;

            case "onlinedengi" :
				switch ($this->url[1]) {
                    case "step2":
						$this->showOnlineDengiStep2();
						break;

					case "success":
						$this->showOnlineDengiSuccess();
						break;

                    case "error":
						$this->showOnlineDengiError();
						break;

					default:
						$this->showOnlineDengiStep1();
                        break;
				}
				break;

            case "qiwi" :
				switch ($this->url[1]) {
                    case "step2":
						$this->showQiwiStep2();
						break;

                    default:
						$this->showQiwiStep1();
                        break;
				}
				break;

            case "mobile" :
				switch ($this->url[1]) {
                    case "step2":
						$this->showMobileStep2();
						break;

                    case "step3":
						$this->showMobileStep3();
						break;

					default:
						$this->showMobileStep1();
                        break;
				}
				break;

            case "rbk" :
				switch ($this->url[1]) {
					case "step2":
						$this->showRBKStep2();
						break;

                    case "success":
						$this->showRBKSuccess();
						break;

                    case "error":
						$this->showRBKError();
						break;

                    default:
						$this->showRBKStep1();
                        break;
				}
				break;

            case "yandex" :
				switch ($this->url[1]) {
					case "step2":
						$this->showYandexStep2();
						break;

                    case "success":
						$this->showYandexSuccess();
						break;

                    case "error":
						$this->showYandexError();
						break;

                    default:
						$this->showYandexStep1();
                        break;
				}
				break;

			case 'sms':
				if ($this->url[1] == 'payment') {
					$this->smsPayment();
				} else {
					$this->showSms();
				}
				break;

			//case "fail" :
			//	echo "OLOLO";
			//	exit;
			//	break;

            /*
			case 'pay2':
                $pay2ip = array('82.146.40.60', '188.120.245.101', '188.120.245.102');
                $cmd = $_REQUEST['command'];
                switch ($cmd) {
                    case 'check':
                        if (in_array($_SERVER['REMOTE_ADDR'], $pay2ip)) {
                            $this->pay2check();
                        }
                        break;

                    case 'pay':
                        if (in_array($_SERVER['REMOTE_ADDR'], $pay2ip)) {
                            $this->pay2pay();
                        }
                        break;

                    default:
                        $this->pay2page();
                        break;
                }
                break;
            */
            
            // –Њ–±—А–∞–±–Њ—В–Ї–∞ —Б–Њ–Њ–±—Й–µ–љ–Є–є –Њ—В –±–Є–ї–ї–Є–љ–≥ —Б–µ—А–≤–µ—А–∞
			case 'addmoney':
                if ($_SERVER['REMOTE_ADDR'] == self::$billing_ip || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::$billing_ip ||
					$_SERVER['REMOTE_ADDR'] == self::$billing_ip_backup || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::$billing_ip_backup) {
                    $this->updateHoney();
                }
                exit;
                break;

            case 'buyhoney':
                if ($_SERVER['REMOTE_ADDR'] == self::$billing_ip || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::$billing_ip ||
					$_SERVER['REMOTE_ADDR'] == self::$billing_ip_backup || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::$billing_ip_backup) {
                    $this->buyHoney();
                }
                exit;
                break;

            // –Њ–±–Љ–µ–љ –Љ—С–і–∞ –љ–∞ –Љ–Њ–љ–µ—В—Л
            case 'change':
				$this->changeHoney();

            // –≥–µ–љ–µ—А–∞—Ж–Є—П —Б—В—А–∞–љ–Є—Ж –њ–ї–∞—В–µ–∂–µ–Ї
            default:
				$this->content['player'] = self::$player->toArray();
				if ($_POST["type"]) {
					switch ($_POST["type"]) {
						case "sms":
							$this->showSms();
							break;

						case "webmoney":
							Std::redirect("/stash/webmoney/");
							break;

						case "yandex":
							Std::redirect('/stash/yandex/');
							break;

                        case "qiwi":
							Std::redirect('/stash/qiwi/');
							break;

                        case "mobile":
							Std::redirect('/stash/mobile/');
							break;

                        //case '2pay':
                        //    Std::redirect("/stash/pay2/");
                        //    break;

                        case 'onlinedengi':
                            Std::redirect('/stash/onlinedengi/');
                            break;

                        case 'rbk':
                            Std::redirect('/stash/rbk/');
                            break;

					}
				} else {
					$this->showStash();
				}
				break;
		}

		//
		parent::onAfterProcessRequest();
	}

    /**
     * –Я–Њ–Ї—Г–њ–Ї–∞ —Б—В–∞—В—Г—Б–∞ –Љ–∞–∂–Њ—А–∞
     */
    private function becomeMajor()
    {
        if ((self::$player->playboy == 0 && self::$player->honey < 22) || (self::$player->playboy == 1 && self::$player->honey < 17)) {
            $this->content['becomemajor-message'] = 'no_money';
        } else {
            $honey = self::$player->playboy == 0 ? 22 : 17;
            $reason	= 'major $' . $honey;
            $takeResult = self::doBillingCommand(self::$player->id, $honey, 'takemoney', $reason, $other);

            if ($takeResult[0] == 'OK') {
                self::$player->honey -= $honey;

                self::$player->money += 100;

                $time = 3600 * 24 * 14;
                if (self::$player->playboy == 0) {
                    self::$player->playboytime = time() + $time;
                    self::$player->playboy = 1;
                } else {
                    self::$player->playboytime += $time;
                }
                self::$player->save(self::$player->id, array(playerObject::$PLAYBOY, playerObject::$PLAYBOYTIME, playerObject::$HONEY, playerObject::$MONEY));
                
                // Пяни в подарок
                Std::loadMetaObjectClass("standard_item");
                $item = new standard_itemObject();
                $item->loadByCode('pyani');
                $item->makeExampleOrAddDurability(self::$player->id);

                $this->content['player'] = self::$player->toArray();

                $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                Page::sendLog(self::$player->id, 'mjr', array('h' => $honey, 'dt' => date('d.m.Y H:i', self::$player->playboytime), 'mbckp' => $mbckp), 1);

				Page::checkEvent(self::$player->id, 'major_buy');
            } else {
                Page::addAlert(StashLang::ERROR_NO_HONEY, StashLang::ERROR_NO_HONEY_TEXT);
            }
        }
        Std::redirect('/stash/');
    }

    /**
     * Изпользование сертификата мажорика
     */
    private function useCertificate()
    {
        $major_cert = Page::$sql->getRecord("SELECT time, code, id FROM inventory WHERE code = 'cert_major_3d' and player = " . Page::$player->id . " LIMIT 0,1");
        if ($major_cert) {
            $time = 3600 * 24 * ((int)$major_cert['time']);
            if (self::$player->playboy == 0) {
                self::$player->playboytime = time() + $time;
                self::$player->playboy = 1;
            } else {
                self::$player->playboytime += $time;
            }
            self::$player->save(self::$player->id, array(playerObject::$PLAYBOY, playerObject::$PLAYBOYTIME));
            self::$sql->query("DELETE FROM inventory WHERE player = " . self::$player->id . " AND id = " . $major_cert['id']);

            Page::sendNotice(self::$player->id, 'Вы воспользовались Сертификатом мажорика и стали самым настоящим Мажором!');
            Page::addAlert('Привет, Мажор!', 'Вы воспользовались Сертификатом мажорика и стали самым настоящим Мажором! А теперь быстро в Закоулки пиннать негодяев раз в 5 минут.');
        }
        $this->content['player'] = self::$player->toArray();
        $this->showStash();
    }

    /**
     * Обмен мёда на монеты
     *
     * @return
     */
	public function changeHoney()
	{
		$this->content['action'] = 'change';
        $honey = (int)$_POST['honey'];
		//if ($this->verifyPostKey() == false) {
		//	$this->content['result'] = '0';
		//	$this->content['error'] = 'post_key';
		//	return;
		//} else
        if ($honey < 1) {
			$this->content['result'] = '0';
			$this->content['error'] = 'empty';
			return;
		} elseif (self::$player->honey < $honey) {
			$this->content['result'] = '0';
			$this->content['error'] = 'no money';
			return;
		}
        $reason	= 'honey2money $' . $honey . ' > *' . ($honey * $this->getExchangeRate());
        $takeResult = self::doBillingCommand(self::$player->id, $honey, 'takemoney', $reason, $other);

        if ($takeResult[0] == 'OK') {
            self::$player->honey -= $honey;
            self::$player->money += $honey * $this->getExchangeRate();
            self::$player->save(self::$player->id, array(playerObject::$HONEY, playerObject::$MONEY));
            $this->content['result'] = '1';
            $this->content['params'] = array('money' => $honey * $this->getExchangeRate(), 'honey' => $honey);

            $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
            Page::sendLog(self::$player->id, 'honey2m', array('h' => $honey, 'm' => ($honey * $this->getExchangeRate()), 'mbckp' => $mbckp));
        } else {
            Page::addAlert(StashLang::ERROR_NO_HONEY, StashLang::ERROR_NO_HONEY_TEXT, ALERT_ERROR);
        }
	}

	/**
     * Получиить новый курс обмена
     *
     * @return int
     */
	public function getExchangeRate($level = 0)
    {
		$exchangeRate = 60;
		
		if (!$level) {
            $level = self::$player->level;
        }
		
		if ($level > 3 ) {
			$exchangeRate = 60 * ( $level - 2);
		}
        
		return $exchangeRate;
	}

	private function showSms()
	{
		$this->isRegistered("sms");
		$this->content['sms'] = $this->sms_prefix . ' ' . self::$player->id;
		$this->content['window-name'] = 'Шаг 1 / Покупка мёда через СМС';
		$this->page->addPart('content', 'stash/sms2.xsl', $this->content);
	}

	private function showStash()
	{
		$this->content['window-name'] = 'Медовая заначка';
		//$this->content['bonus'] = Page::$data['professions'][self::$player->skill]['salary'] * 24;
		$this->content['bonus']	= 100;
		$this->content['datetime'] = date('d.m.Y H:i', self::$player->playboytime);
		$this->content['exchange_rate'] = $this->getExchangeRate();
		$this->content['exchange_rate_next_level'] = $this->getExchangeRate(self::$player->level+1);
		$this->content['player_level'] = self::$player->level;
		$this->content['referers'] = $this->sqlGetValue("SELECT referers FROM rating_player WHERE player = " . $this->content['player']['id'] . " LIMIT 0,1");
		$this->generatePostKey();
		$major_cert = Page::$sql->getRecord("SELECT time, code FROM inventory WHERE code = 'cert_major_3d' and player = " . Page::$player->id . " limit 1");
		if ($major_cert) {
			$this->content['major_cert']['time'] = (int) $major_cert['time'];
		}
		$this->page->addPart('content', 'stash/stash.xsl', $this->content);
	}

	private function showWebmoneyStep1()
	{
		$this->isRegistered("webmoney");
		global $data;
		$this->content['window-name'] = 'Шаг 1 / Покупка мёда за WebMoney';
		$this->content["rates"] = $data["stash"];
		$this->page->addPart('content', 'stash/webmoney/step1.xsl', $this->content);
	}

	private function showWebmoneyStep2()
	{
		if ($_POST) {
            $other = array('billing' => 'webmoney');
            $result	= self::doBillingCommand(self::$player->id, (int)$_POST["amount"], 'addmoney', '', $other);
            if ($result[0] == "BILLING_OK") {
                $data = $result[2];

                $this->content["wmr"] = $data['purse'];
                $this->content["payment_number"] = $data['trans_id'];
                $this->content["payment_amount"] = $data['price'];
                $this->content["honey2buy"] = $data['willget']; //$paymentObject->value / 3 + $paymentObject->value / 5 / 3;

                $this->content['window-name'] = 'Шаг 2 / Покупка мёда за WebMoney';
                $this->content['player'] = self::$player->toArray();
                $this->page->addPart('content', 'stash/webmoney/step2.xsl', $this->content);
            } else {
                $code = unserialize($result[1]);
                $this->content['error'] = $code;
                $this->page->addPart('content', 'stash/webmoney/error.xsl', $this->content);
            }
		} else {
			Std::redirect("/stash/webmoney/");
		}
	}

	private function showWebmoneySuccess()
    {
		$this->content['window-name'] = 'Мёд куплен / Покупка мёда за WebMoney';
        Std::loadMetaObjectClass("payment");
		$paymentObject = new paymentObject();
		$paymentObject->load($_POST["LMI_PAYMENT_NO"]);
        $this->content['amount'] = $paymentObject->value / 3 + $paymentObject->value / 5 / 3;
		$this->page->addPart('content', 'stash/webmoney/success.xsl', $this->content);
	}

    private function showWebmoneyError()
    {
        $this->content['window-name'] = 'Ошибка / Покупка мёда за WebMoney';
		$this->page->addPart('content', 'stash/webmoney/error.xsl', $this->content);
	}

    // RBK Money

    private function showRBKStep1()
	{
		$this->isRegistered("rbk");
		global $data;
		$this->content['window-name'] = 'Шаг 1 / Покупка мёда через RBK Money';
		$this->content["rates"] = $data["stash"];
		$this->page->addPart('content', 'stash/rbk/step1.xsl', $this->content);
	}

	private function showRBKStep2()
	{
		if ($_POST) {
			$other = array('billing' => 'rbk');
            $result	= self::doBillingCommand(self::$player->id, (int)$_POST["amount"], 'addmoney', '', $other);
            if ($result[0] == "BILLING_OK") {
                $data = $result[2];

                $this->content['rbk_shop_id'] = $data['purse'];
                $this->content["payment_number"] = $data['trans_id'];
                $this->content["payment_amount"] = $data['price'];
                $this->content["honey2buy"] = $data['willget']; //$paymentObject->value / 3 + $paymentObject->value / 5 / 3;
                $this->content['userField_1'] = $data['purse2'];
                $this->content['window-name'] = 'Шаг 2 / Покупка мёда через RBK Money';
                $this->content['player'] = self::$player->toArray();
                $this->page->addPart('content', 'stash/rbk/step2.xsl', $this->content);
            } else {

                $this->page->addPart('content', 'stash/rbk/error.xsl', $this->content);
            }
		} else {
			Std::redirect("/stash/rbk/");
		}
	}

    private function showRBKSuccess()
    {
		$this->content['window-name'] = 'Мёд куплен / Покупка мёда через RBK Money';
        Std::loadMetaObjectClass("payment");
		$paymentObject = new paymentObject();
		$paymentObject->load($_POST["LMI_PAYMENT_NO"]);
        $this->content['amount'] = $paymentObject->value / 3 + $paymentObject->value / 5 / 3;
		$this->page->addPart('content', 'stash/rbk/success.xsl', $this->content);
	}

    private function showRBKError()
    {
        $this->content['window-name'] = 'Ошибка / Покупка мёда через RBK Money';
		$this->page->addPart('content', 'stash/rbk/error.xsl', $this->content);
	}

    // Мобильный платеж

    private function showMobileStep1()
	{
		$this->isRegistered("mobile");
		global $data;
		$this->content['window-name'] = 'Шаг 1 / Покупка мёда через Мобильный платеж';
		$this->content["rates"] = $data["stash"];
		$this->page->addPart('content', 'stash/mobile/step1.xsl', $this->content);
	}

    private function showMobileStep2()
	{
		if ($_POST) {
            $phone = $_POST["phone1"] . $_POST["phone2"];
			$other = array('billing' => 'odengi', 'billing2' => "mobile", "phone" => $phone, "confirm" => 0);
            $result	= self::doBillingCommand(self::$player->id, (int)$_POST["amount"], 'addmoney', '', $other);
            if ($result[0] == "BILLING_OK") {
                $data = $result[2];

                $this->content["amount"] = $data['willget']; //$paymentObject->value / 3 + $paymentObject->value / 5 / 3;
                $this->content["myamount"] = (int)$_POST["amount"];
                $this->content["phone1"] = $_POST["phone1"];
                $this->content["phone2"] = $_POST["phone2"];
                $this->content['payment_amount'] = $data['price'];
                $this->content['op'] = $data["extra"]['operator'];
                $this->content['window-name'] = 'Шаг 2 / Покупка мёда через Мобильный платеж';
                $this->content['player'] = array("id" => self::$player->id, "nickname" => self::$player->nickname);
                $this->page->addPart('content', 'stash/mobile/step2.xsl', $this->content);
            } else {
                $this->page->addPart('content', 'stash/mobile/error.xsl', $this->content);
            }
		} else {
			Std::redirect("/stash/mobile/");
		}
	}

    private function showMobileStep3()
	{
		if ($_POST) {
            $phone = $_POST["phone1"] . $_POST["phone2"];
			$other = array('billing' => 'odengi', 'billing2' => "mobile", "phone" => $phone, "confirm" => 1);
            $result	= self::doBillingCommand(self::$player->id, (int)$_POST["amount"], 'addmoney', '', $other);
            if ($result[0] == "BILLING_OK") {
                $data = $result[2];

                if ($data["extra"]["status"] == "complete") {
                    $this->content["amount"] = $data['willget']; //$paymentObject->value / 3 + $paymentObject->value / 5 / 3;
                    $this->content["phone1"] = $_POST["phone1"];
                    $this->content["phone2"] = $_POST["phone2"];
                    $this->content['payment_amount'] = $data['price'];
                    $this->content['op'] = $_POST['operator'];
                    $this->content['window-name'] = 'Шаг 3 / Покупка мёда через Мобильный платеж';
                    $this->content['player'] = array("id" => self::$player->id, "nickname" => self::$player->nickname);
                    $this->page->addPart('content', 'stash/mobile/step3.xsl', $this->content);
                } else {
                    $this->page->addPart('content', 'stash/mobile/error.xsl', $this->content);
                }
            } else {
                $this->page->addPart('content', 'stash/mobile/error.xsl', $this->content);
            }
		} else {
			Std::redirect("/stash/mobile/");
		}
	}

    // QIWI

    private function showQiwiStep1()
	{
		$this->isRegistered("qiwi");
		global $data;
		$this->content['window-name'] = 'Шаг 1 / Покупка мёда через QIWI';
		$this->content["rates"] = $data["stash"];
		$this->page->addPart('content', 'stash/qiwi/step1.xsl', $this->content);
	}

    private function showQiwiStep2()
	{
		if ($_POST) {
            $phone = $_POST["phone1"] . $_POST["phone2"];
			$other = array('billing' => 'odengi', 'billing2' => "qiwi", "phone" => $phone);
            $result	= self::doBillingCommand(self::$player->id, (int)$_POST["amount"], 'addmoney', '', $other);
            if ($result[0] == "BILLING_OK") {
                $data = $result[2];

                $this->content["amount"] = $data['willget']; //$paymentObject->value / 3 + $paymentObject->value / 5 / 3;
                $this->content["phone1"] = $_POST["phone1"];
                $this->content["phone2"] = $_POST["phone2"];
                $this->content['payment_amount'] = $data['price'];
                $this->content['window-name'] = 'Шаг 2 / Покупка мёда через QIWI';
                $this->content['player'] = array("id" => self::$player->id, "nickname" => self::$player->nickname);
                $this->page->addPart('content', 'stash/qiwi/step2.xsl', $this->content);
            } else {
                $this->page->addPart('content', 'stash/qiwi/error.xsl', $this->content);
            }
		} else {
			Std::redirect("/stash/qiwi/");
		}
	}

    // Деньги-онлайн

    private function showOnlineDengiStep1()
	{
		$this->isRegistered("onlinedengi");
		global $data;
		$this->content['window-name'] = 'Шаг 1 / Покупка мёда через ДеньгиОнлайн';
		$this->content["rates"] = $data["stash"];
        $this->content["yandex"] = $this->url[1] == 'yandex' ? 1 : 0;
		$this->page->addPart('content', 'stash/onlinedengi/step1.xsl', $this->content);
	}

	private function showOnlineDengiStep2()
	{
		if ($_POST) {
			$other = array('billing' => 'odengi');
            $result	= self::doBillingCommand(self::$player->id, (int)$_POST["amount"], 'addmoney', '', $other);
            if ($result[0] == "BILLING_OK") {
                $data = $result[2];

                $this->content["onlinedengi_shop_id"] = $data['purse'];
                $this->content["onlinedengi_source_id"] = $data['purse2'];
                $this->content["amount"] = $data['willget']; //$paymentObject->value / 3 + $paymentObject->value / 5 / 3;
                $this->content['payment_amount'] = $data['price'];
                $this->content['yandex'] = $_POST['yandex'];
                $this->content['window-name'] = 'Шаг 2 / Покупка мёда через ДеньгиОнлайн';
                $this->content['player'] = self::$player->toArray();
                $this->page->addPart('content', 'stash/onlinedengi/step2.xsl', $this->content);
            } else {
                $this->page->addPart('content', 'stash/onlinedengi/error.xsl', $this->content);
            }
		} else {
			Std::redirect("/stash/onlinedengi/");
		}
	}

    private function showOnlineDengiSuccess()
    {
		$this->content['window-name'] = 'Мёд куплен / Покупка мёда через ДеньгиОнлайн';
        Std::loadMetaObjectClass("payment");
		$paymentObject = new paymentObject();
		$paymentObject->load($_POST["LMI_PAYMENT_NO"]);
        $this->content['amount'] = $paymentObject->value / 3 + $paymentObject->value / 5 / 3;
		$this->page->addPart('content', 'stash/onlinedengi/success.xsl', $this->content);
	}

    private function showOnlineDengiError()
    {
        $this->content['window-name'] = 'Ошибка / Покупка мёда через ДеньгиОнлайн';
		$this->page->addPart('content', 'stash/onlinedengi/error.xsl', $this->content);
	}

    // –ѓ–љ–і–µ–Ї—Б.–Ф–µ–љ—М–≥–Є

    private function showYandexStep1()
	{
		$this->isRegistered("yandex");
		global $data;
		$this->content['window-name'] = 'Шаг 1 / Покупка мёда за Яндекс.Деньги';
		$this->content["rates"] = $data["stash"];
		$this->page->addPart('content', 'stash/yandex/step1.xsl', $this->content);
	}

	private function showYandexStep2()
	{
		if ($_POST) {
            $other = array('billing' => 'yandex');
            $result	= self::doBillingCommand(self::$player->id, (int)$_POST["amount"], 'addmoney', '', $other);
            if ($result[0] == "BILLING_OK") {
                $data = $result[2];

                $this->content["yandex_shop_id"] = $data['purse'];
                $this->content["yandex_scid"] = $data['purse2'];
                $this->content["payment_amount"] = $data['price'];
                $this->content["honey2buy"] = $data['willget']; //$paymentObject->value / 3 + $paymentObject->value / 5 / 3;
                $this->content["server"] = self::$billing_server;
                $this->content['trans_id'] = $data['trans_id'];

                $this->content['window-name'] = 'Шаг 2 / Покупка мёда за Яндекс.Деньги';
                $this->content['player'] = self::$player->toArray();
                $this->page->addPart('content', 'stash/yandex/step2.xsl', $this->content);
            } else {
                $code = unserialize($result[1]);
                $this->content['error'] = $code;
                $this->page->addPart('content', 'stash/yandex/error.xsl', $this->content);
            }
		} else {
			Std::redirect("/stash/yandex/");
		}
	}

    private function showYandexSuccess()
    {
        // редирект на красивый URL
		if (strlen($_SERVER['QUERY_STRING']) > 100) {
            Std::redirect('/stash/yandex/success/');
        }
        $this->content['window-name'] = 'Мёд куплен / Покупка мёда за Яндекс.Деньги';
        Std::loadMetaObjectClass("payment");
		$paymentObject = new paymentObject();
		$paymentObject->load($_POST["LMI_PAYMENT_NO"]);
        $this->content['amount'] = $paymentObject->value / 3 + $paymentObject->value / 5 / 3;
		$this->page->addPart('content', 'stash/yandex/success.xsl', $this->content);
	}

    private function showYandexError()
    {
        // редирект на красивый URL
		if (strlen($_SERVER['QUERY_STRING']) > 100) {
            Std::redirect('/stash/yandex/error/');
        }
        $this->content['window-name'] = 'Ошибка / Покупка мёда за Яндекс.Деньги';
		$this->page->addPart('content', 'stash/yandex/error.xsl', $this->content);
	}

    // 2pay.ru
    /*
    private function pay2page()
    {
        $this->content['player'] = self::$player->toArray();
        $this->content['window-name'] = "–Я–Њ–Ї—Г–њ–Ї–∞ –Љ—С–і–∞ —З–µ—А–µ–Ј —Б–Є—Б—В–µ–Љ—Г 2pay.ru";
		$this->page->addPart('content', 'stash/2pay.xsl', $this->content);
    }

    private function pay2check()
    {
        $playerId = (int) trim($_REQUEST['v1']);
        if ($this->sqlGetValue("SELECT count(*) FROM player WHERE id=" . $playerId) == 1) {
            if (trim($_REQUEST['md5']) == md5('check' . $playerId . $this->pay2secretKey)) {
                $this->pay2reply(self::PAY2_RESULT_OK);
            } else {
                $this->pay2reply(self::PAY2_RESULT_ERROR_MD5);
            }
        } else {
            $this->pay2reply(self::PAY2_RESULT_ERROR_IDNOTFOUND);
        }
    }

    private function pay2pay()
    {
        $playerId = (int)trim($_REQUEST['v1']);
        if ($this->sqlGetValue("SELECT count(*) FROM player WHERE id=" . $playerId) == 1) {
            $pay2TransactionId = (int)trim($_REQUEST['id']);
            if ($this->sqlGetValue("SELECT count(*) FROM payment WHERE trans=$pay2TransactionId") == 0) {
                if (trim($_REQUEST['md5']) == md5('pay' . $playerId . $pay2TransactionId . $this->pay2secretKey)) {
                    $sum = (float) trim($_REQUEST['sum']);
                    $dt = preg_replace('/[^\d\-\s:]/', '', trim($_REQUEST['date']));

                    Std::loadMetaObjectClass('payment');
                    $paymentObject = new paymentObject();
                    $paymentObject->player = $playerId;
                    $paymentObject->purse = '';
                    $paymentObject->invs = '';
                    $paymentObject->trans = $pay2TransactionId;
                    $paymentObject->wm = '';
                    $paymentObject->type = '2pay.ru';
                    $paymentObject->dt = $dt;
                    $paymentObject->active = 1;
                    $paymentObject->value = $sum * 3;
                    $paymentObject->save();

                    Std::loadMetaObjectClass('player');
                    $playerObject = new playerObject();
                    $playerObject->load($playerId);
                    $playerObject->honey += round($sum);
                    $playerObject->save();
                    Page::sendNotice($playerId, '–Т–∞–Љ –љ–∞—З–Є—Б–ї–µ–љ–Њ ' . round($sum) . ' –Љ–µ–і–∞.');

                    $this->pay2reply(self::PAY2_RESULT_OK, '', $pay2TransactionId, $paymentObject->id, $sum);
                } else {
                    $this->pay2reply(self::PAY2_RESULT_ERROR_MD5);
                }
            } else {
                $this->pay2reply(self::PAY2_RESULT_OK, 'payment was sent earlier');
            }
        } else {
            $this->pay2reply(self::PAY2_RESULT_ERROR_IDNOTFOUND);
        }
    }


    private function pay2cancel()
    {
        //
    }

    private function pay2reply($result, $comment = '', $pay2id = '', $myId = '', $sum = '')
    {
        $xml = '<?xml version="1.0" encoding="windows-1251"?>
<response>
'.($pay2id == '' ? '' : '<id>' . $pay2id . '</id>').'
'.($myId == '' ? '' : '<id_shop>' . $myId . '</id_shop>').'
'.($sum == '' ? '' : '<sum>' . $sum . '</sum>').'
<result>' . $result . '</result>
<comment>' . $comment . '</comment>
</response>';
        header('Content-type: text/xml');
        echo iconv('utf-8', 'windows-1251', $xml);
        exit;
    }
    */

    // —Б–ї—Г–∂–µ–±–љ—Л–µ —Д—Г–љ–Ї—Ж–Є–Є –і–ї—П —А–∞–±–Њ—В—Л —Б –±–Є–ї–ї–Є–љ–≥-—Б–µ—А–≤–µ—А–Њ–Љ

    /**
     * –Ю–±—А–∞–±–Њ—В–Ї–∞ —Б–Њ–Њ–±—Й–µ–љ–Є–є –Њ—В –±–Є–ї–ї–Є–љ–≥-—Б–µ—А–≤–µ—А–∞
     */
    private function updateHoney()
    {
        if (isset($_POST['purses'])){
            $mas = unserialize($_POST['purses']);
            foreach ($mas as $row) {
                $account_id = (int)$row['account_id'];
                $credits = (int)$row['credits'];

                self::$sql->query("UPDATE player SET honey=" . $credits ." WHERE id=" . $account_id);

                //Std::loadMetaObjectClass('player');
                //$player = new playerObject();
                //$player->load($account_id);
                //$mbckp = array('m' => $player->money, 'o' => $player->ore, 'h' => $player->honey);
                //Page::sendLog($account_id, 'honey', array('h' => ($credits - self::$player->honey), 'mbckp' => $mbckp));

                $timestamp = gmdate("U");
                $timestamp += intval(3*3600);
                //$timestamp += 3600;
                $date = gmdate("d.m.y H:i:s", $timestamp);
                $str = "[$date] id = $account_id, honey = $credits\r\n";

                $file = fopen("med-log.txt","a");
                if ($file) {
                    fwrite($file,$str);
                }
                fclose ($file);
            }
            //echo sizeof($mas);
        } else {
            //echo 0;
        }
        echo 'OK';
    }

    function getBillingError($billingType, $errorMsg)
    {
        $msgs = array(
            'dengimail'	=> array(
                'issuer is invalid' => 'issuer_error',
                'invalid access' => 'issuer_error',
                'failure' => 'issuer_error',
                'no connect' => 'issuer_error',

                'no such user' => 'wrong_email',
                'invalid buyers email' => 'wrong_email',
                'user is blocked' => 'wrong_user_block',
            ),
        );

        if (isset($msgs[$billingType][$errorMsg])) {
            return getLang('buy_error_'.$msgs[$billingType][$errorMsg]);
        }

        return getLang('buy_error_total');
    }

	private function isRegistered($type) {
		if (self::$player->password == md5("")) {
			Std::redirect("/protect/pay/" . $type);
		}
	}

    private function buyHoney()
    {
        $transactions = isset($_POST['transactions']) ? unserialize($_POST['transactions'])	: null;

        if (empty($transactions)) {
            echo 'ERROR';
        }

        foreach ($transactions as $row) {
/*
        $set = array(
            'orig_id'		=> $row['id'],
            'account_id'	=> $row['account_id'],
            'added'			=> $row['added'],
            'credits'		=> $row['credits'],
            'billing_id'	=> $row['biling_id'],
        );

*       id			-	системный номер лога, уникальный.
* 		account_id	- номер аккаунта
* 		added       - дата события (unixtime, moscow time)
* 		credits		- количество кредитов которое добавлено (зелень, мёд, и тд)
* 		billing_id	- номер биллинга (наш, для упрощения)
* 		billing_name- название платёжной систеы (cp1251)
* 		billing_key	- код платёжной систеы	(latin1)
* 		transaction	- номер перевода. Может быть равен 0 для некоторых платёжных систем (смс, иногда онлайн деньги)
* 						Может повторятся при перевыдачах.
* 		extra		- другая информация.	(есть в протоколе, но не используется для Мосвара)
*/
            // статистика платежей для анализа рекламы
            $row['price_rub'] = $row['price_rub'] ? $row['price_rub'] : ($row['credits'] * ($row['billing_name'] == 'SMS' ? 1.5 : 3));
            $level = self::$sql->getValue("SELECT level FROM player WHERE id=" . $row['account_id']);
            self::$sql->query("INSERT INTO payment (player, value, dt, type, med, level)
                VALUES (" . $row['account_id'] . ", " . $row['price_rub'] . ", now(), '" . iconv('windows-1251', 'utf-8', $row['billing_name']) . "', " . $row['credits'] . ", $level)");

            // лог транзакций
            $f = fopen('buy-honey2.txt', 'a');
			if ($f) {
				fputs($f, date('Y-m-d H:i:s', $row['added']) . "\tID=" . $row['account_id'] . ($row['account_id'] < 10000 ? "\t" : '') . "\t+" . $row['credits'] . (strlen($row['credits']) < 7 ? "\t" : '') . "\t=" . $row['credits_now'] . (strlen($row['credits_now']) < 8 ? "\t" : '') . "\tRUB=" . $row['price_rub'] . (strlen($row['price_rub']) < 8 ? "\t" : '') . "\tT=" . $row['transaction'] . "\tID=" . $row['id'] . "\n\r");
				fclose($f);
			}
        }
        echo 'OK';
    }
}

function return_result($message, $is_error = false)
{
	if ($is_error) exit("<SMSDERR>" . stripslashes($message) . "</SMSDERR>");
	exit("<SMSDOSTUP>" . stripslashes($message) . "</SMSDOSTUP>");
}
?>