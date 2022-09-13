<?php
class Police extends Page implements IModule
{
    public $moduleCode = 'Police';
	public $fine;
	public $avatars = array('resident' => array('man1.png', 'girl1.png', 'man4.png', 'girl4.png', 'man5.png', 'girl5.png'), 'arrived' => array('man2.png', 'girl2.png', 'man3.png', 'girl3.png', 'man6.png', 'girl6.png'));

    public function __construct()
    {
        parent::__construct();
    }

	public static function changeNickname($nickname)
    {
		$price = 100;
		$result = array('type' => 'police passport', 'action' => 'change nickname', 'params' => array('url' => '/police/passport/'));
		$nickname = preg_replace('/\s*\-\s*/', '-', trim ($nickname));
		$nickname = preg_replace('/\s+/', ' ', $nickname);
		if (in_array(strtolower($nickname), array('admin', 'administrator', 'administration', 'админ', 'администратор', 'администрация', 'moder', 'moderator', 'модератор', 'moder', 'support'))) {
		    $result['result'] = 0;
			$result['error'] = 'bad nickname';
			return $result;
		}
		if (!preg_match('~^(([a-z0-9\-\_\s]{3,18})|([а-яёЁ0-9\-\_\s]{3,18}))$~ui', $nickname) || count(explode(' ' , $nickname)) > 2) {
			$result['result'] = 0;
			$result['error'] = 'bad nickname';
			return $result;
		}
		if (self::$player->nickname == $nickname) {
			$result['result'] = 0;
			$result['error'] = 'same nickname';
			return $result;
		}
		if (self::$sql->getValue("SELECT count(*) FROM player WHERE nickname='" . mysql_real_escape_string($nickname) . "'") > 0) {
			$result['result'] = 0;
			$result['error'] = 'nickname exists';
			return $result;
		}
		$cert = self::$player->loadItemByCode('cert_changenickname');
		if (!$cert) {
			if (self::$player->honey < $price) {
				$result['result'] = 0;
				$result['error'] = 'no money';
				return $result;
			}
			$reason = 'police nickname [' . $nickname. '] $' . $price;
			$takeResult = self::doBillingCommand(self::$player->id, $price, 'takemoney', $reason, $other);
		}
		if ($cert || $takeResult[0] == 'OK') {
			if ($cert) {
				Page::sendLog(self::$player->id, 'nickname_changed', array('n' => $nickname, 'on' => self::$player->nickname, 'cert' => 1), 1);
				$cert->delete($cert->id);
			} else {
				self::$player->honey -= $price;
				Page::sendLog(self::$player->id, 'nickname_changed', array('n' => $nickname, 'on' => self::$player->nickname, 'honey' => $price, 'mbckp' => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey)), 1);
			}
			
			$oldNickname = self::$player->nickname;
            self::$player->nickname = $nickname;
			self::$player->save(self::$player->id, array(playerObject::$HONEY, playerObject::$NICKNAME));

			$key = Page::signed(self::$player->id);
			$userInfo = array();
			$userInfo[$key] = array();
			$userInfo[$key]["nickname"] = self::$player->nickname;
			Page::chatUpdateInfo($userInfo);

			$cachePlayer = Page::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["nickname"] = self::$player->nickname;
				Page::$cache->set("user_chat_" . $key, $cachePlayer);
			}

			$result['result'] = 1;
            $result['alert'] = array('title' => PoliceLang::ALERT_NAME_CHANGE_TITLE, 'text' => PoliceLang::ALERT_NAME_CHANGE_TEXT);

            // запись в досье игрока
            Std::loadMetaObjectClass('playercomment');
            $playerComment = new playercommentObject();
            $playerComment->player = self::$player->id;
            $playerComment->player2 = 0;
            $playerComment->action = PoliceLang::STRING_PLAYERCOMMENT_NAMECHANGE_ACTION;
            $playerComment->period = '';
            $playerComment->text = PoliceLang::STRING_PLAYERCOMMENT_NAMECHANGE_PREVIOUS . ': ' . $oldNickname;
            $playerComment->dt = date('Y-m-d H:i:s', time());
            $playerComment->save();
		} else {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}
		return $result;
	}

	/*
	public function renameGifts($result,$oldname,$newname)
	{
	    if($result){
	    $query = 'UPDATE gift SET player_from=\''.$newname.'\' WHERE player_from=\''.$oldname.'\'';
	    $this->sqlQuery($query);
	    }
	}
	*/
	
	public static function changeAvatar($avatar, $background)
    {
		$result = array('type' => 'police passport', 'action' => 'change avatar', 'params' => array('url' => '/police/passport/'));
		$background = (int) str_replace('avatar-back-', '', $background);
		if (!isset(self::$data['classes'][$avatar]['fraction']) || (($background < 1 || $background > 6) && $background != str_replace('avatar-back-', '', Page::$player->background))) {
			$result['result'] = 0;
			$result['error'] = 'bad avatar or background';
			return $result;
		}
		$background = 'avatar-back-' . $background;
		if (self::$player->avatar == $avatar && self::$player->background == $background) {
			$result['result'] = 0;
			$result['error'] = 'same avatar and background';
			return $result;
		}
		if (Page::$data['classes'][$avatar]['fraction'] != self::$player->fraction) {
			$price = 200;
			$newfraction = true;
		} else {
			$price = 100;
			$newfraction = false;
		}
		if ($newfraction && self::$player->clan > 0) {
			$result['result'] = 0;
			$result['error'] = 'you are in clan';
			return $result;
		}
        if ($newfraction && self::$sql->getValue("SELECT count(*) FROM sovet WHERE player = " . self::$player->id) > 0) {
			$result['result'] = 0;
			//$result['error'] = 'you are in sovet';
            Page::addAlert(PoliceLang::ERROR, PoliceLang::ERROR_PASSPORT_SOVET, ALERT_ERROR);
			return $result;
		}

		if (self::$player->honey < $price) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}
		if ($newfraction && Page::$sql->getValue("SELECT 1 FROM sovet WHERE player = " . self::$player->id . " LIMIT 1") == 1) {
			$result['result'] = 0;
			$result['error'] = 'you are in sovet';
			return $result;
		}
		$reason = 'police avatar [' . $avatar . '/' . $background . '] $' . $price;
		$takeResult = self::doBillingCommand(self::$player->id, $price, 'takemoney', $reason, $other);
		if ($takeResult[0] == 'OK') {
			self::$player->honey -= $price;
			self::$player->avatar = $avatar;
            if (substr($avatar, 0, 4) == 'girl') {
				self::$player->sex = 'female';
			} elseif (substr($avatar, 0, 3) == 'man') {
				self::$player->sex = 'male';
			}
			self::$player->background = $background;
			if ($newfraction) {
				self::$player->fraction = Page::$data['classes'][$avatar]['fraction'];

				$key = Page::signed(self::$player->id);
				$userInfo = array();
				$userInfo[$key] = array();
				$userInfo[$key]["fraction"] = self::$player->fraction;
				Page::chatUpdateInfo($userInfo);

				$cachePlayer = Page::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["fraction"] = self::$player->fraction;
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}

				// удаление врагов и жерт в из контактов
				self::$sql->query("DELETE FROM `contact` WHERE `type` IN ('enemy', 'victim') AND (`player` = " . self::$player->id . " OR `player2` = " . self::$player->id . ")");

				// обновление фракции в рейтинге
				self::$sql->query("update rating_player set fraction=" . self::$player->fraction . " where player=" . self::$player->id);
				self::$sql->query("update rating_player2 set fraction=" . self::$player->fraction . " where player=" . self::$player->id);
			}
			self::$player->save(self::$player->id, array(playerObject::$HONEY, playerObject::$AVATAR, playerObject::$BACKGROUND, playerObject::$FRACTION, playerObject::$SEX));
			Page::sendLog(self::$player->id, 'avatar_changed', array('a' => $avatar, 'b' => $background, 'honey' => $price, 'mbckp' => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey), 'f' => $newfraction), 1);
			$result['result'] = 1;
			$result['alert'] = array('title' => PoliceLang::ALERT_AVATAR_CHANGE_TITLE, 'text' => PoliceLang::ALERT_AVATAR_CHANGE_TEXT);
		} else {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}
		return $result;
	}

	public static function changeFraction()
    {
		$price = 20;
		$result = array('type' => 'police passport', 'action' => 'change fraction', 'params' => array('url' => '/police/passport/'));
		if (self::$player->honey < $price) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}
		if (self::$player->clan > 0) {
			$result['result'] = 0;
			$result['error'] = 'you are in clan';
			return $result;
		}
        if (self::$sql->getValue("SELECT count(*) FROM sovet WHERE player = " . self::$player->id) > 0) {
			$result['result'] = 0;
			//$result['error'] = 'you are in sovet';
            Page::addAlert(PoliceLang::ERROR, PoliceLang::ERROR_PASSPORT_SOVET, ALERT_ERROR);
			return $result;
		}

		$reason = 'police avatar [' . $avatar . '/' . $background . '] $20';
		$takeResult = self::doBillingCommand(self::$player->id, 20, 'takemoney', $reason, $other);
		if ($takeResult[0] == 'OK') {
			self::$player->honey -= 20;
			self::$player->avatar = $avatar;
			self::$player->background = $background;
			self::$player->save(self::$player->id, array(playerObject::$HONEY, playerObject::$AVATAR, playerObject::$BACKGROUND));

			$key = Page::signed(self::$player->id);
			$userInfo = array();
			$userInfo[$key] = array();
			$userInfo[$key]["fraction"] = self::$player->fraction;
			Page::chatUpdateInfo($userInfo);

			$cachePlayer = Page::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["fraction"] = self::$player->fraction;
				Page::$cache->set("user_chat_" . $key, $cachePlayer);
			}

			Page::sendLog(self::$player->id, 'avatar_changed', array('a' => $avatar, 'b' => $background, 'honey' => 20, 'mbckp' => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey)), 1);
			$result['result'] = 1;
			$result['alert'] = array('title' => PoliceLang::ALERT_AVATAR_CHANGE_TITLE, 'text' => PoliceLang::ALERT_AVATAR_CHANGE_TEXT);
		} else {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}
		return $result;
	}

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		$this->needAuth();
        //
		foreach (Page::$data['classes'] as $k => $a) {
			if ($a['fraction'] == self::$player->fraction) {
				$this->avatars[] = "'" . $k . "'";
			}
		}
		if ($_POST['action'] == 'change_avatar') {
			$result = self::changeAvatar($_POST['avatar'], $_POST['background']);
		} else if ($_POST['action'] == 'change_nickname') {
			$result = self::changeNickname($_POST['nickname']);
		} else if ($_POST['action'] == 'change_fraction') {
			$result = self::changeFraction();
		} else if ($_POST['action'] == 'werewolf_begin') {
			$result = self::werewolfBegin((int) $_POST['level'], (int) $_POST['with_item']);
		} else if ($_POST['action'] == 'werewolf_extension') {
			$result = self::werewolfExtension();
		} else if ($_POST['action'] == 'werewolf_regeneration') {
			$result = self::werewolfRegeneration();
		} else if ($_POST['action'] == 'werewolf_cancel') {
			$result = self::werewolfCancel();
		}

		if (isset($result)) {
			if ($_POST['ajax']) {
				echo json_encode($result);
				exit;
			}
			Runtime::set('content/result', $result);
			if ($result['alert']) {
				Page::addAlert($result['alert']['title'], $result['alert']['text']);
			}
			if ($_POST['return_url'] != '') {
				$result['params']['url'] = $_POST['return_url'];
			}
			if ($result['params']['url']) {
				Std::redirect($result['params']['url']);
			}
		}

		$this->fine = Page::$player->level * 50;
		if ($this->url[0] == 'fine') {
			$this->payFine();
		} else if ($this->url[0] == 'relations' && self::$player->relations_time < time()) {
			if (!self::$player->isEnoughOreHoney(20)) {
				$this->content['relations_message'] = 'no_money';
			} else {
				$this->establishRelations();
			}
		} else if ($this->url[0] == 'fraction') {
			if (!self::$player->isEnoughOreHoney(100)) {
				$this->content['fraction_message'] = 'no_money';
			} else {
				$this->changeFraction();
			}
		}
		if ($this->url[0] == 'passport') {
			$this->showPassport();
		} else if ($this->url[0] == 'werewolf' && Page::$player2->werewolf == 1) {
			$this->showWerewolf();
		} else {
			$this->showPolice();
		}
        //
        parent::onAfterProcessRequest();
    }

	public function showWerewolf() {
        $this->content['window-name'] = PoliceLang::$windowTitle;

		$this->content['costs'] = Page::$data['costs']['police'];

		$this->content['werewolf']['timer'] = strtotime(Page::$player2->werewolf_dt) - time();
		$this->content['werewolf']['timer2'] = date('H:i:s', $this->content['werewolf']['timer']);
		Page::$player2->werewolf_data = json_decode(Page::$player2->werewolf_data, true);
		$this->content['werewolf']['level'] = Page::$player2->werewolf_data['level'];
		$this->content['werewolf']['maxhp'] = Page::$player2->werewolf_data['stats']['health'] * 10 + Page::$player2->werewolf_data['stats']['resistance'] * 4;
		$this->content['werewolf']['regeneration'] = Page::$player2->werewolf_data['regeneration'];

		$maxStat = $maxRating = 0;
		foreach (self::$player2->werewolf_data['stats'] as $stat => $value) {
			if (substr($stat, 0, 6) == 'rating') {
				if ($value > $maxRating) {
					$maxRating = $value;
				}
			} else {
				if ($value > $maxStat) {
					$maxStat = $value;
				}
			}
		}
		foreach (self::$player2->werewolf_data['stats'] as $stat => $value) {
			if (substr($stat, 0, 6) == 'rating') {
				if ($maxRating == 0) {
					$procent = 0;
				} else {
					$procent = floor($value / $maxRating * 100);
				}
			} else {
				$procent = floor($value / $maxStat * 100);
			}
			$this->content['werewolf'][$stat] = $value;
			$this->content['werewolf'][$stat . 'procent'] = $procent;
		}
		$k1 = $k2 = 0;
		foreach (self::$player2->werewolf_data['k'] as $stat => $value) {
			if (substr($stat, 0, 6) == 'rating') {
				$k2 += $value;
			} else {
				$k1 += $value;
			}
		}
		$this->content['stars'] = round(($k1 / 7 * 5 + $k2 / 6) / 6 / 1.5 * 5);
        $this->page->addPart('content', 'police/werewolf.xsl', $this->content);
	}

	protected function payFine()
    {
		if (self::$player->state == 'police' && self::$player->timer > time()) {
			if (self::$player->ore + self::$player->honey < 5) {
				$this->content['fine_message'] = 'no_money';
				return;
			}
            if (self::$player->stateparam == 'admin') {
				Page::addAlert(PoliceLang::$error, PoliceLang::$errorBribeModer, ALERT_ERROR);
				return;
			}

            if (self::$player->ore >= 5) {
                $priceOre = 5;
                $priceHoney = 0;
            } else {
                $priceOre = self::$player->ore;
                $priceHoney = 5 - $priceOre;
                $priceHoneyOre = 5 - $priceOre; // для логов
            }

            if ($priceHoney > 0) {
                $reason	= 'police bribe $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
                $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
            }
            if ($priceHoney == 0 || $takeResult[0] == 'OK') {
                self::$player->ore -= $priceOre;
                self::$player->honey -= $priceHoney;

                self::$player->state = '';
                self::$player->suspicion = -5;
                self::$player->timer = 0;

				Page::$player->homesalarytime = mktime(date("H"), 0, 0);
                
                self::$player->save(self::$player->id, array(playerObject::$SUSPICION, playerObject::$STATE, playerObject::$TIMER, playerObject::$MONEY, playerObject::$ORE, playerObject::$HONEY, playerObject::$HOMESALARYTIME));

                $this->content['fine_message'] = 'ok';

                $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
                Page::sendLog(self::$player->id, 'plcvzt2', array('o' => $priceOre, 'h' => $priceHoney, 'dt' => date('d.m.Y H:i', self::$player->relations_time), 'mbckp' => $mbckp), 1);
            } else {
                Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
            }
		} else {
			if (self::$player->money < $this->fine) {
				$this->content['fine_message'] = 'no_money';
				return;
			}
			self::$player->suspicion = -5;
			self::$player->money -= $this->fine;
            self::$player->save(self::$player->id, array(playerObject::$SUSPICION, playerObject::$MONEY));

            $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
            Page::sendLog(self::$player->id, 'plcvzt1', array('m' => $this->fine, 'dt' => date('d.m.Y H:i', self::$player->relations_time), 'mbckp' => $mbckp), 1);

            $this->content['fine_message'] = 'ok';
		}
	}

    /**
     * Включение/продление налаженных связей
     *
     * @return void
     */
	protected function establishRelations()
    {
		Page::startTransaction('police_establishrelations');
        if (self::$player->ore + self::$player->honey < 20) {
            $this->content['relations_message'] = 'no_money';
            return;
        }
        if (self::$player->ore >= 20) {
            $priceOre = 20;
            $priceHoney = 0;
        } else {
            $priceOre = self::$player->ore;
            $priceHoney = 20 - $priceOre;
        }

        if ($priceHoney > 0) {
            $reason	= 'police relations $' . $priceHoney;
            $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
        }
        if ($priceHoney == 0 || $takeResult[0] == 'OK') {
            self::$player->ore -= $priceOre;
            self::$player->honey -= $priceHoney;

            self::$player->relations_time = self::$sql->getValue("SELECT relations_time FROM player WHERE id = " . self::$player->id);
            self::$player->relations_time = (self::$player->relations_time > time() ? self::$player->relations_time : time()) + 7 * 24 * 3600;

            if (self::$player->state == 'police' && self::$player->timer > time() && self::$player->stateparam != 'admin') {
                self::$player->suspicion = 0;
                self::$player->state = '';
            } else {
                self::$player->suspicion = 0;
            }
            self::$player->save(self::$player->id, array(playerObject::$ORE, playerObject::$HONEY, playerObject::$RELATIONS_TIME, playerObject::$STATE, playerObject::$SUSPICION));

            $mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
            Page::sendLog(self::$player->id, 'plcrel', array('o' => $priceOre, 'h' => $priceHoney, 'dt' => date('d.m.Y H:i', self::$player->relations_time), 'mbckp' => $mbckp), 1);

			Page::checkEvent(self::$player->id, 'relations_buy');
        } else {
            Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
        }
		Page::endTransaction('police_establishrelations');
	}

	public static function werewolfCancel() {
		$result = array();
		$result['params']['url'] = '/police/';
		if (Page::$player2->werewolf == 1) {
			Page::$player2->werewolf = 0;
			Page::$player2->save(Page::$player2->id, array(player2Object::$WEREWOLF));
			Page::addAlert(Lang::ALERT_OK, PoliceLang::WEREWOLF_CANCEL);
		}
		return $result;
	}
	
	public static function werewolfBegin($level, $useItem = false) {
		$result = array();
		$result['params']['url'] = '/police/werewolf/';
		if ($level < max(4, Page::$player->level - 6) || $level > Page::$player->level - 1) {
			Page::addAlert(Lang::$error, Std::renderTemplate(PoliceLang::ERROR_WEREWOLF_BAD_LEVEL, array('min_level' => max(4, Page::$player->level - 6))), ALERT_ERROR);
			return $result;
		}
		$log = array('l' => $level);
		if ($useItem) {
			$id = Page::$sql->getValue("SELECT id FROM inventory WHERE player = " . Page::$player->id . " AND code = 'shoulderstrap' LIMIT 1");
			if (!$id) {
				Page::addAlert(Lang::$error, PoliceLang::ERROR_WEREWOLF_NO_ITEM, ALERT_ERROR);
				return $result;
			}
			$sql = "DELETE FROM inventory WHERE id = " . $id;
			Page::$sql->query($sql);
			$log['item'] = 1;
		} else {
			$priceHoney = Page::$data['costs']['police']['werewolf_begin']['honey'];
			if (Page::$player->honey < $priceHoney) {
				Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
				return $result;
			}
			$log['h'] = $priceHoney;
			$reason	= 'werewolf begin $' . $priceHoney;
			$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
			if ($takeResult[0] == 'OK') {
			self::$player->honey -= $priceHoney;
			self::$player->save(self::$player->id, array(playerObject::$HONEY));
			$mbckp = array('h' => self::$player->honey);
			$log['mbckp'] = $mbckp;
		}
		}
		if ($useItem || $takeResult[0] == 'OK') {
			self::$player2->werewolf = 1;
			self::$player2->werewolf_dt = date('Y-m-d H:i:s', time() + 3600);
			self::$player2->werewolf_data = Police::generateWerewolf($level);
			self::$player2->werewolf_data = json_encode(self::$player2->werewolf_data);
			self::$player2->save(self::$player2->id, array(player2Object::$WEREWOLF, player2Object::$WEREWOLF_DT, player2Object::$WEREWOLF_DATA));

			Page::sendLog(self::$player->id, 'wolf_begin', $log, 1);
			Page::addAlert(Lang::ALERT_OK, PoliceLang::WEREWOLF_BEGIN);
        } else {
            Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
        }
		return $result;
	}

	public static function werewolfExtension() {
		$result = array();
		$result['params']['url'] = '/police/';
		if (Page::$player2->werewolf == 0) {
			$result['params']['url'] = '/police/';
			return $result;
		}
		$priceHoney = Page::$data['costs']['police']['werewolf_extension']['honey'];
		if (Page::$player->honey < $priceHoney) {
			Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
			return $result;
		}
		$reason	= 'werewolf extension $' . $priceHoney;
		$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
		if ($takeResult[0] == 'OK') {
			self::$player->honey -= $priceHoney;
			self::$player->save(self::$player->id, array(playerObject::$HONEY));
			self::$player2->werewolf_data = json_decode(self::$player2->werewolf_data, true);
			self::$player2->werewolf_data['extensions'] ++;
			self::$player2->werewolf_data = json_encode(self::$player2->werewolf_data);
			self::$player2->werewolf_dt = date('Y-m-d H:i:s', strtotime(self::$player2->werewolf_dt) + 3600);
			self::$player2->save(self::$player2->id, array(player2Object::$WEREWOLF, player2Object::$WEREWOLF_DT, player2Object::$WEREWOLF_DATA));

			$mbckp = array('h' => self::$player->honey);
			Page::sendLog(self::$player->id, 'wolf_extension', array('h' => $priceHoney, 'mbckp' => $mbckp), 1);
			Page::addAlert(Lang::ALERT_OK, PoliceLang::WEREWOLF_EXTENSION);
        } else {
            Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
        }
		return $result;
	}

	public static function werewolfRegeneration() {
		$result = array();
		$result['params']['url'] = '/police/werewolf/';
		if (Page::$player2->werewolf == 0) {
			$result['params']['url'] = '/police/';
			return $result;
		}
		$priceHoney = Page::$data['costs']['police']['werewolf_regeneration']['honey'];
		if (Page::$player->honey < $priceHoney) {
			Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
			return $result;
		}
		$reason	= 'werewolf regeneration $' . $priceHoney;
		$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
		if ($takeResult[0] == 'OK') {
			self::$player->honey -= $priceHoney;
			self::$player->save(self::$player->id, array(playerObject::$HONEY));

			self::$player2->werewolf_data = json_decode(self::$player2->werewolf_data, true);
			self::$player2->werewolf_data['regeneration'] ++;
			self::$player2->werewolf_data = Police::generateWerewolf(self::$player2->werewolf_data['level'], self::$player2->werewolf_data['regeneration'], self::$player2->werewolf_data['extensions']);
			self::$player2->werewolf_data = json_encode(self::$player2->werewolf_data);
			self::$player2->save(self::$player2->id, array(player2Object::$WEREWOLF, player2Object::$WEREWOLF_DT, player2Object::$WEREWOLF_DATA));

			$mbckp = array('h' => self::$player->honey);
			Page::sendLog(self::$player->id, 'wolf_regeneration', array('h' => $priceHoney, 'mbckp' => $mbckp), 1);
        } else {
            Page::addAlert(PoliceLang::$errorNoHoney, PoliceLang::$errorNoHoneyText, ALERT_ERROR);
        }
		Page::$player2->werewolf_data = json_decode(Page::$player2->werewolf_data, true);
		$result['stats'] = Page::$player2->werewolf_data['stats'];
		$k1 = $k2 = 0;
		foreach (self::$player2->werewolf_data['k'] as $stat => $value) {
			if (substr($stat, 0, 6) == 'rating') {
				$k2 += $value;
			} else {
				$k1 += $value;
			}
		}
		$result['stars'] = round(($k1 / 7 * 5 + $k2 / 6) / 6 / 1.5 * 5);
		$result['wallet'] = array('honey' => Page::$player->honey);
		$result['hp'] = $result['stats']['health'] * 10 + $result['stats']['resistance'] * 4;
		return $result;
	}

	public static function generateWerewolf($level, $regeneration = 0, $extensions = 1) {
		$statsForLevel = json_decode(CacheManager::get('value_werewolf_stats', array('level' => $level)), true);
		//Стат = Среднее + (Макс-Среднее) * Мин (1, ( Рандом(количество генераций * 0.05,0.75 + количество генераций * 0.05) ) ) - c каждой генерацией шанс получить всё более клевые статы.
		$values = array_merge(array_keys(Page::$data['stats']), array_keys(Page::$data['ratings']));
		$stats = array();
		$ks = array();
		foreach ($values as $v) {
			$k = min((0.05 * $regeneration + rand(0, 75)/100), 1.5);
			$ks[$v] = $k;
			$stats[$v] = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
		}
		$return = array();
		$return['level'] = $level;
		$return['regeneration'] = $regeneration;
		$return['extensions'] = $extensions;
		$return['stats'] = $stats;
		$return['k'] = $ks;
		return $return;
	}

	protected function showPolice()
    {
		$this->content['player'] = self::$player->toArray();
		$this->content['player2'] = self::$player2->toArray();
		$this->content['procentsuspicion'] = floor ((self::$player->suspicion + 5) / 10 * 100);
		$this->content['timestamp'] = time();
		$this->content['unixtime'] = time();
		$this->content['fine'] = $this->fine;
		if (self::$player->relations_time >= time()) {
			Std::loadLib('HtmlTools');
			$this->content['player']['relations_until'] = HtmlTools::formatDateTime(date("Y-m-d H:i:s", self::$player->relations_time), true);
		}
		
        $this->content['window-name'] = PoliceLang::WINDOW_TITLE;

		$this->content['costs'] = Page::$data['costs']['police'];
		if (Page::$player2->werewolf == 1) {
			$this->content['werewolf'] = 1;

			$timer = strtotime(Page::$player2->werewolf_dt) - time();
			self::$player2->werewolf_data = json_decode(self::$player2->werewolf_data, true);
			$werewolfTime = 3600 * self::$player2->werewolf_data['extensions'];

			$this->content['werewolf_data'] = self::$player2->werewolf_data;
			$stats = array();
			$maxStat = $maxRating = 0;
			foreach (self::$player2->werewolf_data['stats'] as $stat => $value) {
				if (substr($stat, 0, 6) == 'rating') {
					if ($value > $maxRating) {
						$maxRating = $value;
					}
				} else {
					if ($value > $maxStat) {
						$maxStat = $value;
					}
				}
			}
			$i = 0;
			foreach (self::$player2->werewolf_data['stats'] as $stat => $value) {
				if (substr($stat, 0, 6) == 'rating') {
					$name = Page::$data['ratings'][$stat]['name'];
					if ($maxRating == 0) {
						$procent = 0;
					} else {
						$procent = floor($value / $maxRating * 100);
					}
				} else {
					$name = Page::$data['stats'][$stat]['name'];
					$procent = floor($value / $maxStat * 100);
				}
				$stats[] = array('code' => $stat, 'value' => $value, 'name' => $name, 'procent' => $procent, 'style' => ($i % 2 == 0 ? 'odd' : ''));
				$i ++;
			}
			$this->content['werewolf_data']['stats'] = $stats;

			$this->content['werewolftime'] = date('d.m.Y H:i', strtotime(Page::$player2->werewolf_dt));
			$this->content['werewolftimeleft'] = $timer > 0 ? $timer : 0;
			$this->content['werewolftimeleft2'] = date('H:i:s', $timer);
			$this->content['werewolftimetotal'] = $werewolfTime;
			$this->content['werewolfpercent'] = round(($werewolfTime - $timer) / $werewolfTime * 100);
		} else {
			$this->content['werewolf_levels'] = array();
			for ($i = max(4, Page::$player->level - 6); $i < Page::$player->level; $i ++) {
				$this->content['werewolf_levels'][] = $i;
			}
			$this->content['werewolf_minlevel'] = max(4, Page::$player->level - 6);
			$this->content['shoulderstrap'] = (int) Page::$sql->getValue("SELECT 1 FROM inventory WHERE player = " . Page::$player->id . " AND code = 'shoulderstrap' LIMIT 1");
		}
		

        $this->page->addPart('content', 'police/police.xsl', $this->content);
	}

	protected function showPassport()
    {
		$avatar = $background = 0;
		foreach ($this->avatars[self::$player->fraction] as $a) {
			if ($a == self::$player->avatar) {
				break;
			}
			$avatar ++;
		}
		$background = str_replace('avatar-back-', '', self::$player->background);
		$this->content['avatar'] = $avatar;
		$this->content['background'] = $background;
		$this->content['player'] = self::$player->toArray();
		$this->content['cert_changenickname'] = self::$player->isHaveItem('cert_changenickname');
		$this->content["sovet"] = self::$sql->getValue("SELECT count(*) FROM sovet WHERE player = " . self::$player->id);

        $this->content['window-name'] = PoliceLang::WINDOW_TITLE;
        $this->page->addPart('content', 'police/passport.xsl', $this->content);
	}
}
?>
