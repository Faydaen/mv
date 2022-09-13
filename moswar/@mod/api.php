<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE);
class API extends Page implements IModule
{
    public $moduleCode = 'API';
	public $request = array();
	public $request_params = array();
	public $response = array();
	public $response_params = array();
	public $auth = false;
	public $errors = array(
		1	=> 'invalid email/password',
		2	=> 'account blocked',
		3	=> 'internal server error',
		4	=> 'invalid session',

		24	=> 'item not found',
		25	=> 'slot busy',
		26	=> 'item cant be withdrawed',
		27	=> 'item cant be dressed',

		40	=> 'section not found',
		41	=> 'low level',
		42	=> 'full inventory',

		1000	=> 'not enough money',
		1001	=> 'not enough honey',
		1002	=> 'not enough ore'
	);

	public static $shopSections = array (
		'pharmacy' => array('name' => ApiLang::PHARMACY, 'types' => array('drug')),
		'boutique' => array('name' => ApiLang::CLOTHING, 'types' => array('cloth')),
		'perfumery' => array('name' => ApiLang::PERFUMERY, 'types' => array('cologne')),
		'home' => array('name' => ApiLang::FOR_HOME, 'types' => array('home_defence','home_comfort')),
		'clan' => array('name' => ApiLang::FOR_CLAN, 'types' => array()),
		'accessory' => array('name' => ApiLang::ACCESSORIES, 'types' => array('accessory1', 'accessory2', 'accessory3', 'accessory4', 'accessory5')),
		'weapon' => array('name' => ApiLang::WEAPON, 'types' => array('weapon')),
		'talisman' => array('name' => ApiLang::MASCOTS, 'types' => array('talisman')),
		'pet' => array('name' => ApiLang::PETS, 'types' => array('pet')),
		'other' => array('name' => ApiLang::OTHER, 'types' => array('pick', 'glasses', 'flashlight'))
	);

    public function __construct()
    {
        self::$sql = SqlDataSource::getInstance();
		if (!self::$sql) {
			$this->dieOnError(500);
		}
		self::$data = $GLOBALS['data'];
		self::$cache = new Cache();
		$this->url = explode('/', trim ($_GET['url'], '/'));

		cacheManager::init(self::$cache, self::$sql, $GLOBALS['cacheObjects']);
    }

	public function debug($str, $clear = false) {
		if ($clear == false) {
			$mode = 'a';
		} else {
			$mode = 'w';
		}
		$fp = fopen('debug.txt', $mode);
		fwrite($fp, $str . "\r\n");
		fclose($fp);
	}

    public function processRequest() {
	if (isset($_GET['statsonlinereg'])) {
			$data = CacheManager::multiGet('players_online', 'value_registrations');
			$data['players_online'] = max(1, $data['players_online']);
            echo $data['players_online'] . '/' . $data['value_registrations'];
            exit;
        }

        if (isset($_GET['externalforum'])) {
            $extForum = new ExternalForum();
            echo $extForum->work();
            exit;
        }

		if ($this->url[0] == 'toolbar') {
			if ($this->url[1] == 'popup') {
				$this->toolbarPopup();
			} else {
				$this->toolbarButtons();
			}
		}

		if (DEV_SERVER || (!DEV_SERVER && ($_SERVER['REMOTE_ADDR'] == '85.112.117.73' || $_SERVER['REMOTE_ADDR'] == '85.21.241.134' || $_SERVER['REMOTE_ADDR'] == '85.93.150.50'))) {
			if ($this->url[0] == 'registrations') {
				$this->showRegistrations((int) $this->url[1], (int) $this->url[2]);
			} else if ($this->url[0] == 'lvlups') {
				$this->showLvlups((int) $this->url[1], (int) $this->url[2]);
			} else if ($this->url[0] == 'protections') {
				$this->showProtections((int) $this->url[1], (int) $this->url[2]);
			}
		}

		// BVadim
		if ($this->url[0] == 'auth') {
			Std::loadMetaObjectClass('player');
			if (isset($this->url[1], $this->url[2])) {
				// попытка авторизации

				$player = self::$sql->getRecord("SELECT player.id, player.password, player.level, player.accesslevel, IF(sovet.id, 1, 0) sovet, player2.chatcaptcha as captcha, player.mute_chat, player.isolate_chat, player.nickname, player.fraction, player.sex, player.clan, player.clan_status, clan.name as clan_name, fightplayer.side as fight_side, fightplayer.fight as fight_id, fight.state as fight_state, fight.start_dt as fight_dt,
(select count(*) from metalink where metaattribute_id = 541 and linkedobject_id = 8 and object_id = player.id) as mute_chat_access,
(select count(*) from metalink where metaattribute_id = 541 and linkedobject_id = 27 and object_id = player.id) as isolate_chat_access,
(select count(*) from metalink where metaattribute_id = 541 and linkedobject_id = 35 and object_id = player.id) as wedding_access
FROM player
LEFT JOIN player2 ON player.id = player2.player
LEFT JOIN clan ON player.clan = clan.id
LEFT JOIN fightplayer ON fightplayer.player = player.id
LEFT JOIN fight ON fightplayer.fight = fight.id AND fight.state != 'finished'
LEFT JOIN sovet ON sovet.player = player.id
WHERE player.id = " . (int) $this->url[1] . " and player.password = '" . mysql_escape_string($this->url[2]) . "' ORDER BY fight_id DESC LIMIT 0,1");

				if ($player === false) {
					// если авторизоваться не получилось
					echo "null";
					self::$cache->delete("user_chat_" . $this->url[3]);
				} else {
					if ($player["fight_dt"]) {
						$player["fight_dt"] = strtotime($player["fight_dt"]);
					}
					self::$cache->set("user_chat_" . $this->url[3], $player);
					echo json_encode($player);
				}
			} else {
				echo "null";
				self::$cache->delete("user_chat_" . $this->url[3]);
			}
		}

		if ($this->url[0] == "gameleads") {
			header("Content-type: text/xml");
			$xml = @new SimpleXMLElement($_POST["xml"]);
	        //$clients = self::$sql->getRecordSet("SELECT player.id, player.level, log.dt FROM player LEFT JOIN log ON player.id = log.player WHERE player.referer = 'gameleads' and player.password != 'd41d8cd98f00b204e9800998ecf8427e' and (log.dt >= '" . date("Y-m-d H:i:s", (string) $xml->date_from) . "' AND log.dt <= '" . date("Y-m-d H:i:s", (string) $xml->date_to) . "' AND (log.type='level_up' OR log.type='player_protect') ) group by player.id");
			$clients = self::$sql->getRecordSet("SELECT player, level, dt FROM gameleads WHERE dt >= '" . date("Y-m-d H:i:s", (string) $xml->date_from) . "' AND dt <= '" . date("Y-m-d H:i:s", (string) $xml->date_to) . "'");

			echo '<?xml version="1.0"?>' . PHP_EOL;
			echo '<items>' . PHP_EOL;
			if ($clients) {
				foreach ($clients as $client) {
					echo '
					<item>
						<id>' . $client["player"] . '</id>
						<level>' . $client["level"] . '</level>
						<price></price>
						<currency></currency>
						<date>' . strtotime($client["dt"]) . '</date>
					</item>';
				}
			}
			echo '</items>' . PHP_EOL;
			die();
		}

		if ($this->url[0] == 'automute') {
			$playerId = $this->url[1];
			$period = (int) $this->url[2];
			$sign = $this->url[3];
			if (self::signed($playerId . $period) == $sign) {
				Std::loadMetaObjectClass('player');
				self::$player = new playerObject();
				self::$player->load($player);
				self::$player->mute_chat = $period;
				self::$player->save($playerId, array(playerObject::$MUTE_CHAT));

				$key = self::signed($player);
				$cachePlayer = self::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["mute_chat"] = $period;
					self::$cache->set("user_chat_" . $key, $cachePlayer);
				}
			}
		}

		if ($this->url[0] == 'mute') {
			$moderatorId = $this->url[1];
			$playerId = $this->url[2];
			$period = (int) $this->url[3];
			$text = urldecode($this->url[4]);
			$sign = $this->url[5];
			if (self::signed($moderatorId . $playerId . $period) == $sign) {
				// Сообщение подписано. Разруливаем.
				Std::loadModule('PlayerAdmin');
				//base64_decode($text);
				PlayerAdmin::adminPlayerMute($playerId, "chat", intval($period), true, $text, $moderatorId);
				PlayerAdmin::adminAddPlayerComment($playerId, ApiLang::CHAT_MUTE_ADD, Std::formatPeriodLog(intval($period)), $text, false, $moderatorId);

				/*
				Std::loadMetaObjectClass('player');
				$mPlayer = new playerObject;
				$mPlayer->load($playerId);

				$key = self::signed($playerId);
				$cachePlayer = self::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["mute_chat"] = $mPlayer->mute_chat;
					self::$cache->set("user_chat_" . $key, $cachePlayer);
				}
				 */
			}
		}

		if ($this->url[0] == 'unmute') {
			$moderatorId = $this->url[1];
			$playerId = $this->url[2];
			$sign = $this->url[3];

			if (self::signed($moderatorId . $playerId) == $sign) {
				// Сообщение подписано. Разруливаем.
                Std::loadModule('PlayerAdmin');
				PlayerAdmin::adminPlayerMute($playerId, "chat", null, false, null, $moderatorId);
				PlayerAdmin::adminAddPlayerComment($playerId, ApiLang::CHAT_MUTE_REMOVE, null, "", false, $moderatorId);

				/*
				$key = self::signed($playerId);
				$cachePlayer = self::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["mute_chat"] = null;
					self::$cache->set("user_chat_" . $key, $cachePlayer);
				}
				 */
			}
		}

		if ($this->url[0] == 'isolate') {
			$moderatorId = $this->url[1];
			$playerId = $this->url[2];
			$period = (int) $this->url[3];
			$text = urldecode($this->url[4]);
			$sign = $this->url[5];

			if (self::signed($moderatorId . $playerId . $period) == $sign) {
				// Сообщение подписано. Разруливаем.
                Std::loadModule('PlayerAdmin');
				//base64_decode($text)
				PlayerAdmin::adminPlayerIsolate($playerId, true, intval($period), $text, $moderatorId);
				PlayerAdmin::adminAddPlayerComment($playerId, ApiLang::CHAT_ISOLATION_ADD, Std::formatPeriodLog(intval($period)), $text, false, $moderatorId);
				/*
				Std::loadMetaObjectClass('player');
				$iPlayer = new playerObject;
				$iPlayer->load($playerId);
				$key = self::signed($playerId);
				$cachePlayer = self::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["isolate_chat"] = $iPlayer->isolate_chat;
					self::$cache->set("user_chat_" . $key, $cachePlayer);
				}
				 */
			}
		}

		if ($this->url[0] == 'quiz') {
			$playerId = $this->url[1];
			$sign = $this->url[2];
			if (self::signed($playerId) == $sign) {
				Page::$sql->query("insert into quiz_results (player, wins, total, current) values(" . $playerId . ", 0, 1, 1) on duplicate key update current = current + 1, total = total + 1");
				Page::$cache->set("quiz_state", "question_answered", 300);
			}
		}

		if ($this->url[0] == 'unisolate') {
			$moderatorId = $this->url[1];
			$playerId = $this->url[2];
			$sign = $this->url[3];

			if (self::signed($moderatorId . $playerId) == $sign) {
				// Сообщение подписано. Разруливаем.
				Std::loadModule('PlayerAdmin');
				PlayerAdmin::adminPlayerIsolate($playerId, false, null, null, $moderatorId);
				PlayerAdmin::adminAddPlayerComment($playerId, ApiLang::CHAT_ISOLATION_REMOVE, null, "", false, $moderatorId);

/*
				$key = self::signed($playerId);
				$cachePlayer = self::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["isolate_chat"] = null;
					self::$cache->set("user_chat_" . $key, $cachePlayer);
				}
 */
			}
		}

		if ($this->url[0] == 'private') {
			$senderId = $this->url[1];
			$recipient = urldecode($this->url[2]);
			$text = urldecode($this->url[3]);
			$sign = $this->url[4];

			if (self::signed($senderId . $recipient . $text) == $sign) {
				Std::loadMetaObjectClass('player');
				//base64_decode($recipient)
				$recipient = Page::$sql->getRecord("SELECT id, accesslevel FROM player WHERE nickname = '" . Std::cleanString($recipient) . "'");
				$sender = Page::$sql->getRecord("SELECT id, email FROM player WHERE id = " . $senderId . "");
				//base64_decode($text)
				Page::login($sender['email'], '@informico!pazzword$');
				$this->onBeforeProcessRequest();
				Page::sendMessage($senderId, $recipient["id"], $text);
			}
		}
		// /BVadim

		// ответ для OTRS (тикет-система)
		if ($this->url[0] == 'otrs') {
			$secret = '831d017a9e692859699aaac972dfcd2b';
			if (isset($_POST['SessionID'])) {
				$session = $_POST['SessionID'];
			} else {
				$session = $this->url[1];
			}

			if (strlen($session) < 11) {
			
				echo '<?xml version="1.0" encoding="UTF-8"?>
<UserInfo>
<error>Bad SessionId</error>
</UserInfo>';
				exit;
			}
			$id = substr($session, 10);
			$session = substr($session, 0, 10);

			$sql = "SELECT nickname, password, email FROM player WHERE id = " . $id;
			$params = self::$sql->getRecord($sql);

			//var_dump($sql);
			//var_dump($params);

			if ($params == false || substr(md5($params['password']), 0, 10) != $session) {
				echo '<?xml version="1.0" encoding="UTF-8"?>
<UserInfo>
<error>Bad SessionId</error>
</UserInfo>';
				exit;
			}
			$sessionId = $session . $id;
			$key = md5($id . $params['nickname'] . $params['email'] .   $sessionId . $secret);

            $xml = '<?xml version="1.0" encoding="UTF-8"?>
<UserInfo>
		<ID>' . $id . '</ID>
		<Nick>' . $params['nickname'] . '</Nick>
		<Email>' . $params['email'] . '</Email>
		<Signature>' . $key . '</Signature>
</UserInfo>';
            header("Content-Length: " . strlen($xml));
            echo $xml;
			exit;
		}


        if ($_POST['action'] == 'registerplayer') {
			$result = $this->registerPlayer($_POST['nickname'], $_POST['email'], $_POST['password'], $_POST['fraction'], $_POST['avatar'], $_POST['background'], false);
			echo $result;
			exit;
		}
		if (!isset($_POST['data'])) {
			$_POST['data'] = @file_get_contents('php://input');
		}
		$_POST['data'] = stripslashes($_POST['data']);
		if (strlen($_POST['data']) > 0) {
			//$this->debug($_POST['data']);
			$this->parseRequest();
			if (isset($this->request['session'])) {
				session_id($this->request['session']);
				session_start();
				if ($_SESSION['id'] == false) {
					$this->response['error'] = 'invalid session1';
					$this->buildResponse();
				} else {
					$this->player = self::loadPlayer($_SESSION['id']);
					if ($this->player == false) {
						$this->response['error'] = 'invalid session2';
						$this->buildResponse();
					}
					$this->player->loadInventory();
					$this->player->loadHP();
					if (strtotime($this->player->lastactivitytime) <= time() - 60) {
						$this->player->lastactivitytime = date('Y-m-d H:i:s');
						$this->player->status = 'online';
						$this->player->save($this->player->id, array(playerObject::$LASTACTIVITYTIME, playerObject::$STATUS));
					}
				}
			}
            switch ($this->request['type']) {
                case 'auth':
                    $result = $this->apiAuth($this->request_params['email'], $this->request_params['password']);
                    if (is_array($result)) {
                        session_id($result['session']);
                        session_start();
                        $_SESSION['id'] = $result['id'];
                    }
                    break;

                case 'player':
                    switch ($this->request['action']) {
                        // мой персонаж
                        case 'load': $result = self::apiPlayerLoad($this->player); break;
                        case 'puton': $result = self::apiPlayerPutOn($this->player, $this->request_params['item']); break;
                        case 'putoff': $result = self::apiPlayerPutOff($this->player, $this->request_params['item']); break;
                        case 'logs': $result = self::apiPlayerLogs($this->player); break;
                        // другой персонаж
                        case 'info': $result = self::apiPlayerInfo($this->request_params['player']); break;
                    }
                    break;

                case 'trainer':
                    switch ($this->request['action']) {
                        case 'load': $result = $this->apiTrainerLoad($this->player); break;
                        case 'up': $result = $this->apiTrainerUp($this->player, $this->request_params['stat']); break;
                    }
                    break;

                case 'macdonalds':
                    switch ($this->request['action']) {
                        case 'work': $result = $this->apiMacdonaldsWork($this->player, $this->request_params['time']); break;
                    }
                    break;

                case 'alley':
                    switch ($this->request['action']) {
                        case 'search': $result = self::apiAlleySearch($this->player, $this->request_params['search_type'], $this->request_params['params']); break;
                        case 'attack': $result = $this->apiAlleyAttack($this->player, $this->request_params['id']); break;
                        case 'duelload': $result = $this->apiAlleyDuelLoad($this->player, $this->request_params['id']); break;
                        case 'patrol': $result = self::apiStartPatrol($this->player, $this->request_params['time']); break;
                    }
                    break;

                case 'shop':
                    switch ($this->request['action']) {
                        case 'loadsections': $result = $this->apiShopLoadSections($this->player); break;
                        case 'load':  $result = $this->apiShopLoad($this->player, $this->request_params['section']); break;
                        case 'buy': $result = $this->apiShopBuy($this->player, $this->request_params['id'], @$this->request_params['nickname']); break;
                    }
                    break;

                case 'rating':
                    switch ($this->request['action']) {
                        case 'top': $result = self::apiRatingShow($this->player, $this->request_params['mode'], $this->request_params['page'], $this->request_params['fraction']); break;
                        case 'search': $result = self::apiRatingSearch($this->player, $this->request_params['mode'], @$this->request_params['player'], @$this->request_params['nickname']); break;
                    }
                    break;
            }
			
			$this->buildResponse($result);
		}
		exit;
    }

	public function toolbarButtons() {
		$loggedIn = $this->tryAutoLogin();
		$output = array();
		
		
		
		
		
		if (DEV_SERVER) {
			$button = array(
				'id' => 'newevents',
				'label' => 'Понаехали тут!',
				'onclick' => array(
					'action' => 'openpopup',
					'params' => array(
						'width' => 400,
						'height' => 250,
						'url' => 'http://prod.dev.moswar.ru/api/toolbar/popup/'
					)
				),
				'appearance' => array(
					'type' => 'image',
					'url'=> 'http://prod.dev.moswar.ru/@/images/toolbar-button.png'
				),
				'badge' => array(
					'value'=> 1,
					'onclick'=> 'remove_badge',
					'highlight' => array(
						'enable'=> 'always',
						'color'=> '#ffffff'
					)
				) 
				
				
			);
		} else {
			$button = array(
				'id' => 'newevents',
				'icon' => 'http://www.moswar.ru/favicon.ico',
				'label' => 'Понаехали тут!',
				'onclick' => array(
					'action' => 'openpopup',
					'params' => array(
						'width' => 400,
						'height' => 250,
						'url' => 'http://www.moswar.ru/api/toolbar/popup/'
					)
				)
			);
		}
		$timer = 600;
		$counter = 0;
		if ($loggedIn) {
			Std::loadMetaObjectClass('player2');
			self::$player2 = new player2Object();
			self::$player2->load(self::$player->id);
			
			$counter = self::$player2->newmes + self::$player2->newlogs + self::$player2->newduellogs;
			$timers = array(
				(int) $this->data["automobile_upgrade_factory"]["time"],
				(int) $this->data["automobile_create_car"]["time"],
				(int) $this->data["automobile_bring_up"]["endtime"],
				Page::$player->lastfight,
				Page::$player->timer);
			$work_timers = Page::$sql->getValueSet("SELECT endtime FROM playerwork WHERE player = " . Page::$player->id . " and type IN ('petriks', 'training')");
			if ($work_timers) {
				$timers = array_merge($timers, $wotk_timers);
			}
			
			$now = time();
			foreach ($timers as $key => &$t) {
				if ($t < $now) {
					continue;
				}
				if ($t - $now + 10 < $timer) {
					$timer = $t - $now + 10;
				}
			}

		}
		
		$button['counter'] = array('value' => $counter, 'enable_highlight' => 1);
		$output['buttons'][] = $button;
		$output['version'] = 3;
		$output['update_interval'] = $timer;
		
		echo json_encode($output);
		exit;
	}

	public function toolbarPopup() {
		$loggedIn = $this->tryAutoLogin();
		Std::loadLib('Xslt');
		if ($loggedIn) {
			Std::loadMetaObjectClass('player2');
			self::$player2 = new player2Object();
			self::$player2->load(self::$player->id);
			
			$template = 'toolbar/popup';
			$playerblock = array('id' => Page::$player->id, 'nickname' => Page::$player->nickname, 'level' => Page::$player->level,
			'money' => Page::$player->money, 'ore' => Page::$player->ore, 'honey' => Page::$player->honey, 'oil' => Page::$player->oil,
			'hp' => Page::$player->hp, 'maxhp' => Page::$player->maxhp, 'avatar' => Page::$player->avatar,
			'suspicion' => Page::$player->suspicion, 'fraction' => Page::$player->fraction);
			if (Page::$player->clan > 0 && Page::$player->clan_status != 'recruit') {
				$tmp = CacheManager::get('clan_shortinfo', array('clan_id' => Page::$player->clan));
				$playerblock['clan_id'] = Page::$player->clan;
				$playerblock['clan_name'] = $tmp;
			}
			if (self::$player->forum_avatar > 0 && self::$player->forum_avatar_checked == 1) {
				$playerblock['avatar'] = '/@images/' . CacheManager::get('stdimage_path', array('image_id' => Page::$player->forum_avatar));
			} else {
				$playerblock['avatar'] = '/@/images/pers/' . str_replace('.', '_thumb.', $playerblock['avatar']);
			}
			$playerblock['newmes'] = self::$player2->newmes;
			$playerblock['newlogs'] = self::$player2->newlogs;
			$playerblock['newduellogs'] = self::$player2->newduellogs;
			$playerblock['session'] = self::$player->id . '_' . sha1(self::$player->password);
			
			if (self::$player->timer > time() && self::$player->state != '') {
				$playerblock['busy_endtime'] = max(self::$player->timer, self::$player->lastfight);
				$playerblock['busy_timer'] = $playerblock['busy_endtime'] - time();
				$timerLocation = Page::stateToLocation(self::$player->state);
				$playerblock['busy_timer2'] = date('H:i:s', $playerblock['busy_timer'] - 3600*3);
				$playerblock['busy_title'] = Page::stateToTitle(self::$player->state);
				$playerblock['busy_location'] = $timerLocation == 'frozen' ? 'fight' : $timerLocation;
			} else if (self::$player->lastfight > time()) {
				$playerblock['busy_timer'] = self::$player->lastfight - time();
				$playerblock['busy_timer2'] = date('H:i:s', $playerblock['busy_timer'] - 3600*3);
				$playerblock['busy_location'] = 'alley';
				$playerblock['busy_endtime'] = self::$player->lastfight;
				$playerblock['busy_title'] = 'отдых после драки';
			}

		} else {
			$template = 'toolbar/popup_notlogged';
		}
		echo Xslt::getHtml2($template, $playerblock);
		exit;
	}

	public function showRegistrations($fromTimestamp, $toTimestamp) {
		$sql = "SELECT regtime as c_time, refer_code as r_code, player as acc_id, http_referer as ref, old_player as old_acc_id, 0 status FROM marketing_registrations WHERE regtime BETWEEN " . $fromTimestamp . " AND " . $toTimestamp;
		$result = Page::$sql->getRecordSet($sql);
		if (!is_array($result)) {
			$result = array();
		}
		echo '"registrations":' . json_encode($result);
		exit;
	}

	public function showLvlups($fromTimestamp, $toTimestamp) {
		$sql = "SELECT lvluptime as c_time, player as acc_id, level as lvl FROM marketing_lvlups WHERE lvluptime BETWEEN " . $fromTimestamp . " AND " . $toTimestamp;
		$result = Page::$sql->getRecordSet($sql);
		if (!is_array($result)) {
			$result = array();
		}
		echo '"lvlup":' . json_encode($result);
		exit;
	}

	public function showProtections($fromTimestamp, $toTimestamp) {
		$sql = "SELECT regtime as c_time, player as acc_id, 1 status FROM marketing_registrations WHERE protected_time BETWEEN " . $fromTimestamp . " AND " . $toTimestamp;
		$result = Page::$sql->getRecordSet($sql);
		if (!is_array($result)) {
			$result = array();
		}
		echo '"protections":' . json_encode($result);
		exit;
	}

    /* rating */

	public static function apiRatingShow($player, $mode, $page, $fraction = '') {
		Std::loadModule('Rating');
		if (!array_search($mode, array('moneygrabbed', 'moneylost', 'wins', 'referers'))) {
			$mode = 'moneygrabbed';
		}
		if ($fraction != 'resident' && $fraction != 'arrived') {
			$fraction = '';
		}
		if (!is_numeric($page) || $page < 1 || $page > 50) {
			$page = 1;
		}
		$rating = Rating::playerRating($fraction, $mode, 20, ($page - 1) * 20);
		$rating['pages'] = ceil($rating['total'] / 20);
		return $rating;
	}

	public static function apiRatingSearch($player, $mode, $playerId = 0, $playerNickname = '') {
		$sql = SqlDataSource::getInstance();
		if (is_numeric($playerId)) {
			if ($sql->getValue("SELECT 1 FROM `player` WHERE `id` = " . $playerId . " LIMIT 1") == false) {
				return 'player not found';
			}
		} else {
			$playerId = Page::getPlayerId($playerNickname);
			if ($playerId == false) {
				return 'player not found';
			}
		}
		Std::loadModule('Rating');
		if (!array_search($mode, array('moneygrabbed', 'moneylost', 'wins', 'referers'))) {
			$mode = 'moneygrabbed';
		}
		$rating = Rating::playerRating('', $mode, 20, ($page - 1) * 20, $playerId);
		$rating['pages'] = ceil($rating['total'] / 20);
		return $rating;
	}

    /* shop */

	public static function apiShopBuy($player, $id, $nickname) {
		Std::loadMetaObjectClass('standard_item');
		$standard_item = new standard_itemObject;
		if (!$standard_item->load($id)) {
			return;
		}
		if ($player->level < $standard_item->level) {
			return 'low level';
		} else if ($player->money < $standard_item->money || !$player->isEnoughOreHoney($standard_item->ore) || $player->honey < $standard_item->honey) {
			return 'no money';
		} else {
			$player->loadInventory();
			if ($player->inventoryAmount >= $player->capacity) {
				return 'full inventory';
			} else if (is_a($player->pet, 'inventoryObject') && $standard_item->type == 'pet') {
				return 'pet exists';
			} else if (($standard_item->type == 'home_defence' || $standard_item->type == 'home_comfort') && count($player->home) == 6) {
				return 'home is full';
			} else {
				$playerid = $player->id;
				if ($standard_item->type == 'gift') {
					$playerid = Page::getPlayerId($nickname);
					if ($playerid == false || $playerid == $player->id) {
						return 'player not found';
					}
				}
				if ($standard_item->stackable == 1) {
					$item = $player->getItemByStandard($id);
					if ($item !== false) {
						$item->maxdurability ++;
						$item->durability ++;
						$item->save();
					} else {
						$item = $standard_item->makeExample($playerid);
					}
				} else {
					if ($standard_item->type == 'gift') {
						$item = $standard_item->makeExample($playerid, $standard_item->name . ' (' . ApiLang::USERFROM . ' ' . $player->nickname . ')');
					} else {
						$item = $standard_item->makeExample($playerid);
					}
				}
				$player->money -= $standard_item->money;
				$player->spendOreHoney($standard_item->ore);
				$player->honey -= $standard_item->honey;
				if ($item->type == 'home_comfort') {
					$player->home_comfort += $item->itemlevel;
				}
				if ($item->type == 'home_defence') {
					$player->home_defence += $item->itemlevel;
					$player->save($player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE, playerObject::$HOME_DEFENCE));
				} else {
					$player->save($player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE, playerObject::$HOME_COMFORT));
				}
				$result = array();
				$result['player'] = array('money' => $player->money, 'ore' => $player->ore, 'honey' => $player->honey);
				return $result;
			}
		}
	}

	public static function apiShopLoad($player, $section) {
		if (!isset(self::$shopSections[$section])) {
			return 'section not found';
		}
		if (count (self::$shopSections[$section]['types'])) {
			Std::loadMetaObjectClass ('standard_item');
			$criteria = new ObjectCollectionCriteria ();
			$criteria->createWhere (standard_itemObject::$TYPE, ObjectCollectionCriteria::$COMPARE_IN, self::$shopSections[$section]['types']);
			$collection = new ObjectCollection ();
			$standard_itemCollection = $collection->getArrayList (standard_itemObject::$METAOBJECT, $criteria);
            if ($standard_itemCollection !== false) {
                //foreach ($standard_itemCollection as &$standard_item) {
                    //foreach (Page::$data['stats'] as $stat) {
                    //    if ($standard_item[$stat['code']] > 0) {
                    //        $standard_item['effects'][] = array('param' => $stat['name'], 'value' => $standard_item[$stat['code']]);
                    //    }
					//	unset($standard_item[$stat['code']]);
                    //}
                //}
            }
			$items = $standard_itemCollection;
		}
		if (!isset($items) || !is_array($items)) {
			$items = array();
		}
		return $items;
	}

	public static function apiShopLoadSections($player) {
		$result = array();
		foreach (self::$shopSections as $code => $section) {
			$result[] = array('code' => $code, 'name' => $section['name']);
		}
		return $result;
	}

    /* alley */

	public static function apiAlleyAttack($player, $id) {
		if (!$player->isFree()) {
			return array('error' => 'player busy', 'player' => array('state' => $player->state, 'timer' => $player->timer), 'servertime' => time());
		} else if ($player->lastfight > time()) {
			return array('error' => 'too many fights', 'player' => array('lastfight' => $player->lastfight), 'servertime' => time());
		} else if ($player->hp < $player->maxhp * 0.5) {
			return array('error' => 'low hp', 'player' => array('hp' => $player->hp, 'maxhp' => $player->maxhp));
		}
		$enemy = new playerObject;
		if ($enemy->load($id) === false) {
			return 'players not found';
		}
		if ($enemy->fraction == $player->fraction) {
			return 'cant attack ally';
		} else if ($enemy->lastfight > time()) {
			return 'enemy fighted recently';
		} else if ($enemy->loadHP() < $enemy->maxhp * 0.5) {
			return 'enemy has low hp';
		} else {
			Std::loadMetaObjectClass ('duel');
			$criteria = new ObjectCollectionCriteria ();
			$criteria->createWhere (duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $enemy->id);
			$criteria->createWhere (duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, time() - 3600);
			$collection = new ObjectCollection ();
			$duelCollection = $collection->getArrayList (duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
			if ($duelCollection !== false) {
				$fights = current($duelCollection);
				if ($fights['amount'] > 0) {
					return 'enemy fighted recently';
				}
			}
			$criteria = new ObjectCollectionCriteria ();
			$criteria->createWhere (duelObject::$PLAYER1, ObjectCollectionCriteria::$COMPARE_EQUAL, $enemy->id);
			$criteria->createWhere (duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $enemy->id);
			$criteria->createWhere (duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, time() - 3600 * 24);
			$collection = new ObjectCollection ();
			$duelCollection = $collection->getArrayList (duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
			if ($duelCollection !== false) {
				$fights = current($duelCollection);
				if ($fights['amount'] >= 5) {
					return 'enemy fighted recently';
				}
			}
			$player->loadInventory();
			$enemy->loadInventory();
			/*
			Std::loadMetaObjectClass('duel');
			$duel = new duelObject;
			$duel->attacker = $player->id;
			$duel->player1 = $player;
			$duel->player2 = $player;
			$duel->player1data = json_encode($player->exportForFight());
			$duel->player2data = json_encode($player->exportForFight());
			$duel->fight();
			$duel->player1 = $player->id;
			$duel->player2 = $player->id;
			$duel->save();
			Page::sendLog($player->id, array('type' => 'fight', 'role' => 'defender', 'fight_id' => $duel->id, 'player' => $player->id, 'nickname' => $player->nickname, 'level' => $player->level, 'fraction' => $player->fraction));
			Page::sendLog($player->id, array('type' => 'fight', 'role' => 'attacker', 'fight_id' => $duel->id, 'player' => $player->id, 'nickname' => $player->nickname, 'level' => $player->level, 'fraction' => $player->fraction));
			$player->suspicion = min(5, $player->suspicion + 1);
			$player->suspicionTest();
			$result = array();
			*/
			Std::loadMetaObjectClass('duel');
			$duel = new duelObject;
			$duel->fight($player, $enemy);
			$duel->save();

			Page::sendLog($enemy->id, 'fight_defended', array('fight_id' => $duel->id, 'result' => ($enemy->id == $duel->winner) ? 'win' : ($duel->winner == 0 ? 'draw' : 'loose'), 'player' => array('id' => $player->id, 'nickname' => $player->nickname, 'level' => $player->level, 'fraction' => $player->fraction)), 0);
			Page::sendLog($player->id, 'fight_attacked', array('fight_id' => $duel->id, 'result' => ($player->id == $duel->winner) ? 'win' : ($duel->winner == 0 ? 'draw' : 'loose'), 'player' => array('id' => $enemy->id, 'nickname' => $enemy->nickname, 'level' => $enemy->level, 'fraction' => $enemy->fraction)), 1);

			//Page::sendLog($enemy->id, array('type' => 'fight', 'role' => 'defender', 'fight_id' => $duel->id, 'player' => $player->id, 'nickname' => $player->nickname, 'level' => $player->level, 'fraction' => $player->fraction));
			//Page::sendLog($player->id, array('type' => 'fight', 'role' => 'attacker', 'fight_id' => $duel->id, 'player' => $enemy->id, 'nickname' => $enemy->nickname, 'level' => $enemy->level, 'fraction' => $enemy->fraction));
			$result['player'] = array('hp' => $player->hp, 'money' => $player->money, 'exp' => $player->exp, 'level' => $player->level);
			$result['duel'] = self::apiAlleyDuelLoad($player, $duel->id);
			return $result;
		}
	}

	public static function apiAlleyDuelLoad($player, $id) {
		Std::loadModule('Alley');
		Std::loadMetaObjectClass('duel');
		$duel = new duelObject;
		if ($duel->load($id) === false) {
			return 'duel not found';
		}
		$result['acting'] = $duel->acting;
		foreach ($result['acting'] as &$act) {
			if (isset($act['health_finish'])) {
				$max = max($act['health_finish'], $act['dexterity_finish'], $act['strength_finish'], $act['intuition_finish'], $act['charism_finish'], $act['resistance_finish'], $act['attention_finish']);
			} else {
				$max = max($act['health'], $act['dexterity'], $act['strength'], $act['intuition'], $act['charism'], $act['resistance'], $act['attention']);
			}
			$act['procenthp'] = round($act['hp'] / $act['maxhp'] * 100);
			foreach (Page::$data['stats'] as $stat) {
				$stat = $stat['code'];
				if (isset($act['health_finish'])) {
					$act['procent'.$stat] = floor($act[$stat.'_finish'] / $max * 100);
				} else {
					$act['procent'.$stat] = floor($act[$stat] / $max * 100);
				}
			}
		}
		foreach ($duel->log as &$step) {
			foreach ($step[0] as &$strike) {
				$varName = 'fightStrings';
				if ($duel->acting[$strike[0]]['type'] == 'pet') {
					$varName .= 'Animal';
				}
				if ($strike[2][0] == 0) {
					$varName .= 'Miss';
					$strike[2][1] = 0;
				} else if ($strike[2][0] == 1) {
					$varName .= 'Strike';
				} else if ($strike[2][0] == 2) {
					$varName .= 'Critical';
				} else if ($strike[2][0] == 3) {
					$varName .= 'Injury';
				}
				//if ($strike[2][2] == -1 || !isset(Alley::${$varName}[$strike[2][2]])) {
				//	$strike[2][2] = explode('%', Alley::${$varName}[rand(0, count(Alley::${$varName})-1)]);
				//}
				$strike['attacker'] = $strike[0];
				$strike['defender'] = $strike[1];
				$strike['strike']['result'] = $strike[2][0];
				$strike['strike']['damage'] = $strike[2][1];
				$strike['strike']['txt'] = str_replace(array('%1%', '%2%'), array('$attacker', '$defender'), Alley::${$varName}[rand(0, count(Alley::${$varName})-1)]);
				unset($strike[0], $strike[1], $strike[2]);
			}
			$step['strikes'] = $step[0];
			$step['hp'] = $step[1];
			unset($step[0], $step[1]);
		}
		//$result['attack-string'] = explode('%', Alley::$attackStrings[rand(0, count(Alley::$attackStrings)-1)]);
		$result['attack-string'] = str_replace(array('%1%', '%2%'), array('$attacker', '$defender'), Alley::$attackStrings[rand(0, count(Alley::$attackStrings)-1)]);
		$result['log'] = array_reverse($duel->log);
		$result['time'] = date("H:i:s", $duel->time);
		$result['date'] = date("d.m.Y", $duel->time);
		$result['id'] = $duel->id;
		$result['winner'] = $duel->winner;
		$result['profit'] = $duel->profit;
		$result['exp'] = $duel->exp;
		return $result;
	}

	public static function apiAlleySearch($player, $search_type, $params) {
		if ($player->hp < $player->maxhp * 0.5) {
			return array('error' => 'low hp', 'player' => array('hp' => $player->hp, 'maxhp' => $player->maxhp));
		} else if (!$player->isFree()) {
			return array('error' => 'player busy', 'player' => array('state' => $player->state, 'timer' => $player->timer), 'servertime' => time());
		} else if ($player->lastfight > time()) {
			return array('error' => 'too many fights', 'player' => array('lastfight' => $player->lastfight), 'servertime' => time());
		}
		if ($player->money <= 0) {
			return array('error' => 'not enough money', 'player' => array('money' => $player->money));
		}
		$player->money --;
		$player->save($player->id, array(playerObject::$MONEY));
		Std::loadMetaObjectClass('playerhp');
		$criteria = new ObjectCollectionCriteria();
		$criteria->createJoin(playerhpObject::$METAOBJECT, playerhpObject::$PLAYER, playerObject::$ID, ObjectCollectionCriteria::$JOIN_LEFT);
		if ($search_type == 'type') {
			if ($params['type'] == 'equal') {
				$criteria->createWhere (playerObject::$STATSUM, ObjectCollectionCriteria::$COMPARE_BETWEEN, round($player->statsum * 0.8), round($player->statsum * 1.2));
			} else if ($params['type'] == 'strong') {
				$criteria->createWhere(playerObject::$STATSUM, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, round($player->statsum * 1.2));
			} else if ($params['type'] == 'weak') {
				$criteria->createWhere(playerObject::$STATSUM, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_SMALLER, round($player->statsum * 0.8));
			}
		} else if ($search_type == 'level') {
			if ($params['minlevel'] > 0 && $params['maxlevel'] > 0) {
				$criteria->createWhere(playerObject::$LEVEL, ObjectCollectionCriteria::$COMPARE_BETWEEN, max(1, $params['minlevel']), min(99, $params['maxlevel']));
			}
		} else if ($search_type == 'nick') {
			if ($params['nick'] != '') {
				$criteria->createWhere(playerObject::$NICKNAME, ObjectCollectionCriteria::$COMPARE_EQUAL, $params['nick']);
			}
		}
		$criteria->addWhere('(playerhp.hp >= playerhp.maxhp * 0.5 OR playerhp.maxhp IS NULL)');
		$criteria->createWhere(playerObject::$ID, ObjectCollectionCriteria::$COMPARE_NOT_EQUAL, $player->id);
		$criteria->createWhere(playerObject::$FRACTION, ObjectCollectionCriteria::$COMPARE_NOT_EQUAL, $player->fraction);
		$criteria->createWhere(playerObject::$STATE, ObjectCollectionCriteria::$COMPARE_NOT_IN, array('metro', 'macdonalds', 'fight', 'police', 'patrol'));
		$criteria->createWhere(playerObject::$LASTFIGHT, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_SMALLER, time());
		$criteria->createOrder(playerObject::$ID, ObjectCollectionCriteria::$ORDER_RANDOM);
		$criteria->addLimit(0, 1);
		$collection = new ObjectCollection();
		$playerCollection = $collection->getObjectList(playerObject::$METAOBJECT, $criteria);
		if ($playerCollection == false) {
			return 'players not found';
		}
		$player = current($playerCollection);
		Std::loadMetaObjectClass ('duel');
		$criteria = new ObjectCollectionCriteria ();
		$criteria->createWhere (duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $player->id);
		$criteria->createWhere (duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, time() - 3600);
		$collection = new ObjectCollection ();
		$duelCollection = $collection->getArrayList (duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
		if ($duelCollection !== false) {
			$fights = current($duelCollection);
			if ($fights['amount'] > 0) {
				return 'players not found';
			}
		}
		$criteria = new ObjectCollectionCriteria ();
		$criteria->createWhere (duelObject::$PLAYER1, ObjectCollectionCriteria::$COMPARE_EQUAL, $player->id);
		$criteria->createWhere (duelObject::$PLAYER2, ObjectCollectionCriteria::$COMPARE_EQUAL, $player->id);
		$criteria->createWhere (duelObject::$TIME, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, time() - 3600 * 24);
		$collection = new ObjectCollection ();
		$duelCollection = $collection->getArrayList(duelObject::$METAOBJECT, $criteria, array('COUNT(*)' => 'amount'));
		if ($duelCollection !== false) {
			$fights = current($duelCollection);
			if ($fights['amount'] >= 5) {
				return 'players not found';
			}
		}
		$player->loadHP();
		$result = $player->toArray();
		$fields = array('id', 'nickname', 'health_finish', 'strength_finish', 'dexterity_finish', 'attention_finish', 'resistance_finish', 'intuition_finish', 'charism_finish', 'level', 'fraction','avatar', 'background');
		$result['enemy'] = array_intersect_key($result, array_fill_keys($fields, ''));
		$result['player']['money'] = $player->money;
		return $result;
	}

    /**
     * Начать патрулирование улиц
     *
     * @param object $player
     * @param int $time
     * @return mixed
     */
    public static function apiStartPatrol($player, $time)
    {/*
        if (!is_numeric($time) || $time < 1 || $time > 8) {
			return 'bad time';
		} else if (!$player->isFree()) {
			return array('error' => 'player busy', 'player' => array('state' => $player->state, 'timer' => $player->timer), 'servertime' => time());
		} else {
			} else if (self::$player->level > 1 && self::$player->money < 10) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}
		if (self::$player->level > 1) {
			self::$player->money -= 10;
		}
		self::$player->state = 'patrol';
		self::$player->timer = time() + $time * 60;

        /**
         * @todo Разобраться с заработком и добавить влияние харизмы
         *//*
        foreach (Page::$data['professions'] as $skill) {
			if ($skill['level'] <= self::$player->level) {
				$ms = $skill['salary'] + self::$player->charism_finish;
			}
		}
		$r = rand(0, 100) / 100;
		if ($time < 30) {
			if ($r < 0.3) {
				$salary = 0;
			} else {
				$salary = $ms * $r * 1.5;
			}
		} else {
			if ($r <= 0.1) {
				$salary = 0;
			} else if ($r >= 0.9) {
				$salary = $r * $ms * 4;
			} else {
				$salary = $r * $ms * 1.5;
			}
		}
		$salary = round($salary);

		// опыт при патрулировании более 10 минут
        $exp = 0;
		if ($time / 10 > 1) {
		    $exp = floor($time / 10 * rand(1, 5) / 10);
		}

        self::$player->beginWork('patrol', $time * 60, $salary, $exp);
		if (self::$player->patrol_time < mktime(0, 0, 0, date('m'), date('d'), date('Y'))) {
			self::$player->patrol_time = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + $time * 60;
		} else {
			self::$player->patrol_time += $time * 60;
		}
		self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$TIMER, playerObject::$PATROL_TIME, playerObject::$MONEY));

            Page::sendLog($w['player'], 'patrol_endwork', array('money' => $w['salary'], 'exp' => $w['exp']), 0, time());
			return array('player' => array('salary' => $salary, 'timer' => $player->timer, 'state' => 'patrol'));
		}*/
    }

    /* macdonalds */

    /**
     * Начать работать в Шаурбургерсе
     *
     * @param object $player
     * @param int $time
     * @return mixed
     */
	public static function apiMacdonaldsWork($player, $time)
    {
		if (!is_numeric($time) || $time < 1 || $time > 8) {
			return 'bad time';
		} else if (!$player->isFree()) {
			return array('error' => 'player busy', 'player' => array('state' => $player->state, 'timer' => $player->timer), 'servertime' => time());
		} else {
			$salary = (Page::$data['professions'][$player->skill]['salary'] + $player->charism_finish) * $time;
			$exp = 0;
			if ($time > 1) {
			    $exp = $time;
			}
			$player->beginWork('macdonalds', $time * 3600, $salary, $exp);
			$player->state = 'macdonalds';
			$player->timer = time() + $time * 3600;
			$player->save($player->id, array(playerObject::$STATE, playerObject::$TIMER));
			Page::sendLog($player->id, 'macdonalds_endwork', array('money' => $salary, 'exp' => $exp), 0, $player->timer);
			return array('player' => array('salary' => $salary, 'timer' => $player->timer, 'state' => 'macdonalds'));
		}
	}

    /* trainer */

	public static function apiTrainerLoad($player)
    {
		$result = array();
		foreach (array_keys(Page::$data['stats']) as $stat) {
			$result[$stat] = $player->{$stat};
			$result['costs'][$stat] = Page::calcTrainerCost($player->{$stat}, $stat);
		}
		return $result;
	}

	public static function apiTrainerUp($player, $stat)
    {
		if ($player->money < Page::calcTrainerCost($player->{$stat}, $stat)) {
			return 'not enough money';
		} else {
			$player->money -= Page::calcTrainerCost($player->{$stat}, $stat);
			$player->{$stat} ++;
			$player->save();
			$result = array(
				'player' => array(
					$stat => $player->{$stat}
				),
				'costs' => array(
					$stat => Page::calcTrainerCost($player->{$stat}, $stat)
				)
			);
			return $result;
		}
	}

    /* player */

    /**
     * Данные текущего игрока
     *
     * @param object $player
     * @return array
     */
	public static function apiPlayerLoad($player)
    {
		$result = $player->toArray();
		$result['info'] = json_decode($result['about'], true);
		$fields = array('id', 'nickname', 'health_finish', 'strength_finish', 'dexterity_finish', 'attention_finish', 'resistance_finish', 'intuition_finish', 'charism_finish', 'level', 'exp', 'playboy', 'hp', 'maxhp', 'state', 'timer', 'fraction', 'about', 'avatar', 'background', 'money', 'honey', 'ore', 'suspicion', 'inventory');
		$result = array_intersect_key($result, array_fill_keys($fields, ''));
        $result['pet'] = $player->loadPet($player->id)->toArray();
		$result['expnextlevel'] = Page::$data['exptable'][$player->level];
		return $result;
	}

    /**
     * Данные другого игрока
     *
     * @param int $playerId
     * @return array
     */
    public static function apiPlayerInfo($playerId)
    {
		$player = self::loadPlayer($playerId);
        $player->loadEquipped();

        $result = $player->toArray();
		$result['info'] = json_decode($result['about'], true);
		$fields = array('id', 'nickname', 'health', 'strength', 'dexterity', 'attention', 'resistance', 'intuition', 'charism', 'level', 'hp', 'maxhp', 'fraction', 'about', 'avatar', 'background', 'inventory');
		$result = array_intersect_key($result, array_fill_keys($fields, ''));

        $inventoryFields = array('name','image','slot','info');
        foreach ($result['inventory'] as &$item) {
            $item = array_intersect_key($item, array_fill_keys($inventoryFields, ''));
        }

        return $result;
	}

	public static function apiPlayerLoadState($player)
    {
		return array('state' => $this->player->state, 'timer' => $this->player->timer, 'servertime' => time());
	}

    /**
     * Одевание вещи
     *
     * @param object $player
     * @param int $itemId
     * @return mixed
     */
    public static function apiPlayerPutOn($player, $itemId)
    {
        if (isset($player->inventory[$itemId])) {
            $item = $player->inventory[$itemId];
            if ($player->level >= $item->level) {
                if ($item->dress(true)) {
                    $item->save($item->id, array(inventoryObject::$EQUIPPED));
                    return true;
                } else {
                    return 'slot_busy';
                }
            } else {
                return 'low_level';
            }
        } else {
            return 'item_not_found';
        }
    }

    /**
     * Снятие вещи
     *
     * @param object $player
     * @param int $itemId
     * @return mixed
     */
    public static function apiPlayerPutOff($player, $itemId)
    {
        if (isset($player->inventory[$itemId])) {
            $item = $player->inventory[$itemId];
            if ($item->withdraw()) {
                $item->equipped = 0;
                $item->save($item->id, array(inventoryObject::$EQUIPPED));
                return true;
            } else {
                return 'can_not_putoff_this_item';
            }
        } else {
            return 'item_not_found';
        }
    }

    /* common */
	public function parseRequest()
    {
		$this->debug($_POST['data']);
		$xml = simplexml_load_string($_POST['data']);
		foreach ($xml->attributes() as $key => $value) {
			$this->request[$key] = strval($value);
		}
		if (count($xml->children()) > 0) {
            foreach ($xml->children() as $key => $value) {
                if (count($value) > 0) {
                    foreach ($value as $key2 => $value2) {
                        $this->request_params[$key][$key2] = strval($value2);
                    }
                } else {
                    $this->request_params[$key] = strval($value);
                }
            }
        }
	}

    public function buildResponse($result = array())
    {
		$this->response['type'] = $this->request['type'];
		if ($this->request['action'] != '') {
			$this->response['action'] = $this->request['action'];
		}
		$this->response['requestid'] = $this->request['requestid'];
		if ($result === true || (is_array($result) && !isset($result['error']))) {
			$this->response['result'] = 1;
			$this->response_params = $result;
		} else {
			$this->response['result'] = 0;
			if (is_array($result)) {
				$this->response['error'] = array_search($result['error'], $this->errors);
				$this->response_params = $result;
				unset($this->response_params['error']);
			} else {
				$this->response['error'] = $result;
			}
		}
		$out = '<response';
		foreach ($this->response as $key => $value) {
			$out .= ' ' .$key . '="' . $value . '"';
		}
		if (is_array($this->response_params) && sizeof($this->response_params)) {
			$out .= ">\r\n";
			$out .= Page::array2xml($this->response_params) . '</response>';
		} else {
			$out .= ' />';
		}
		$this->debug($out);
		echo $out;
		exit;
	}

	public static function loadPlayer($id)
    {
		Std::loadMetaObjectClass('player');
		$player = new playerObject;
		$player->load($id);
		return $player;
	}

	public function apiAuth($email, $password)
    {
		Std::loadMetaObjectClass('player');
		$criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(playerObject::$EMAIL, ObjectCollectionCriteria::$COMPARE_EQUAL, $email);
		//$criteria->createWhere(playerObject::$PASSWORD, ObjectCollectionCriteria::$COMPARE_EQUAL, md5($email . $password));
		$criteria->createWhere(playerObject::$PASSWORD, ObjectCollectionCriteria::$COMPARE_EQUAL, $password);
		$criteria->addLimit(0, 1);
		$collection = new ObjectCollection();
		$players = $collection->getArrayList(playerObject::$METAOBJECT, $criteria);
		if ($players === false) {
			return 'invalid email/password';
		} else {
			$player = current($players);
			return array('session' => md5(time() . rand(10000, 99999)), 'id' => $player['id']);
		}
	}

	public function registerPlayer($name, $email, $password, $fraction = '', $avatar = '', $background = '', $emailNotice = false)
    {
		$email = strtolower($email);
		$name = preg_replace ('/\s*\-\s*/', '-', trim ($name));
		$name = preg_replace ('/\s+/', ' ', $name);
		if (!preg_match('~^[a-zа-я0-9\-\s\_]{3,25}$~ui', $name)) {
			return 'bad_nickname';
		} else if (!preg_match('~^[a-z][a-z0-9\.\-_]{2,}@[a-z-\0\-\.]{2,}\.[a-z]{2,4}$~i', $email)) {
			return 'bad_email';
		} else if (strlen($password) < 6 || strlen($password) > 40) {
			return 'bad_password';
		} else {
			Std::loadMetaObjectClass('player');
			$criteria = new ObjectCollectionCriteria();
			$criteria->createWhere(playerObject::$NICKNAME, ObjectCollectionCriteria::$COMPARE_EQUAL, $name);
			$collection = new ObjectCollection();
			$players = $collection->getArrayList(playerObject::$METAOBJECT, $criteria);
			if ($players !== false) {
				return 'nickname_exists';
			} else {
				$criteria = new ObjectCollectionCriteria();
				$criteria->createWhere(playerObject::$EMAIL, ObjectCollectionCriteria::$COMPARE_EQUAL, $email);
				$players = $collection->getArrayList(playerObject::$METAOBJECT, $criteria);
				if ($players !== false) {
					return 'email_exists';
				}
			}
		}

		if ($avatar == '') {
			$avatars = array_keys(Page::$data['classes']);
			$avatar = $avatars[rand(0, count(Page::$data['classes'])-1)];
		}
		if ($fraction == '') {
			$fractions = array_keys(Page::$data['fractions']);
			unset($fractions[array_search('plural', $fractions)]);
			$fraction = $fractions[rand(0, count($fractions)-1)];
		}
		if ($background == '') {
			$backgrounds = array('avatar-back-1', 'avatar-back-2', 'avatar-back-3', 'avatar-back-4', 'avatar-back-5', 'avatar-back-6');
			$background = $backgrounds[rand(0, count($backgrounds)-1)];
		}

		$player = new playerObject();
		$player->email = $email;
		$player->nickname = $name;
		$player->avatar = $avatar;
		$player->background = $background;
		$player->fraction = $fraction;
		$player->attention = 1;
		$player->health = 1;
		$player->strength = 1;
		$player->dexterity = 1;
		$player->intuition = 1;
		$player->charism = 1;
		$player->resistance = 1;

		$player->attention_finish = 1;
		$player->health_finish = 1;
		$player->strength_finish = 1;
		$player->dexterity_finish = 1;
		$player->intuition_finish = 1;
		$player->charism_finish = 1;
		$player->resistance_finish = 1;

		$player->level = 1;
		$player->home_price = 10;
		$player->money = 100;
		$player->honey = 3;
		$player->password = md5($email . $password);
		$player->registeredtime = date('Y-m-d H:i:s');
		$player->suspicion = -5;
		$player->statsum = $player->health + $player->strength + $player->attention + $player->resistance + $player->charism + $player->dexterity + $player->intuition;
		$player->maxhp = Page::calcHP($player);
		$player->status = 'offline';

		$player->playboy = 0;
		$player->playboytime = 0;
		
		$player->save();
		if (mysql_errno() > 0) {
			echo mysql_error();
		}
		if ($player->id == 0) {
			return 'unknown_error';
		}
		if ($emailNotice == true) {
			$titles['arrived']['male'] = ApiLang::ARRIVED_M;
			$titles['arrived']['female'] = ApiLang::ARRIVED_W;
			$titles['resident']['male'] = ApiLang::RESIDENT_M;
			$titles['resident']['female'] = ApiLang::RESIDENT_W;
			$mail = Std::renderTemplate(Std::loadTemplate('email/registration_' . $player->fraction),
										array('password' => $password, 'email' => $email, 'title' => $titles[$player->fraction][Page::$data['classes'][$player->avatar]['sex']]));
			Std::sendMail($email, ApiLang::SUBJECT, $mail, 'informer@moswar.ru');
		}
		return true;
	}
	
	public function decompressXML($str) {
		$result = '';
		$char = '';
		for ($i = 0, $length = strlen($str); $i < $length; $i ++) {
			if ($i < 5) {
			
			} else if ($i == 5) {
				$char = $str[$i];
			} else if ($str[$i] == $char) {
				$back = ((ord($str[$i+1]) - 14) * 114 + (ord($str[$i+2]) - 14));
				$len = ord($str[$i+3]) - 14;
				$j = $i - 6;
				$chunk = substr($result, -1 * $back, $len);
				$result .= $chunk;
				$i += 3;
			} else {
				$result .= $str[$i];
			}
		}
		return $result;
	}
}

class ExternalForum
{
	const ANSWER_OK = "OK";
	const ANSWER_ERROR = "ERROR";
	const ANSWER_NOTEXISTS = "NOTEXISTS";

    private $sql;

    public function  __construct() {
        $this->sql = SqlDataSource::getInstance();
    }

	function work()
	{
		$action = !empty($_GET['act']) ? trim($_GET['act']) : null;
		$session = !empty($_GET['session']) ? trim($_GET['session']) : null;

		switch ($action) {
			case 'check_user':
				return $this->getInfo($session);
                break;
            case 'getuserinfo':
                return $this->getUserInfo();
                break;
		}
	}

    private function getUserInfo()
    {
        global $data;

        if (md5(date('H-d.m.Y', time()) . md5($_POST['data'])) == $_GET['key']) {
            $players = json_decode($_POST['data'], true);

            if (sizeof($players) > 0) {
                $players = $this->sql->getRecordSet("SELECT p.id, p.password, p.nickname, p.ip, p.forum_avatar, p.forum_avatar_checked, p.avatar,
                    p.email, i.path, p.avatar, p.fraction, p.level, c.name clan, c.id clanid
                    FROM player p LEFT JOIN clan c ON c.id=p.clan LEFT JOIN stdimage i ON i.id=p.forum_avatar
                    WHERE p.id IN (" . implode(',', $players) . ")");
                if ($players) {
                    $result = array();
                    foreach ($players as $player) {
                        if ($player['forum_avatar'] > 0 && $player['forum_avatar_checked'] == 1) {
                            $player['avatar'] = '/@images/' . $player['path'];
                        }
                        foreach ($data['classes'] as $key => $cur) {
                            if ($cur['avatar'] == $player['avatar']) {
                                $player['avatar'] = '/@/images/pers/' . $cur['thumb'];
                            }
                        }

                        $result[] = array(
                            'name'    => $player['nickname'],
                            'player'  => $player['id'],
                            'ip'      => long2ip($player['ip']),
                            'avatar'  => 'http://www.moswar.ru' . $player['avatar'],
                            'email'   => $player['email'],
                            'race'    => $player['fraction'] == 'resident' ? 1 : 2,
                            'gamedata' => array(
                                'level'   => $player['level'],
                                'clan'    => $player['clan'],
                                'clanid'  => $player['clanid'],
                                'clanimg' => 'http://www.moswar.ru/@images/clan/clan_' . $player['clanid'] . '_ico.png',
                            ),
                        );
                    }
                    return $this->answer(self::ANSWER_OK, $result);
                } else {
                    return $this->answer(self::ANSWER_ERROR, 'PLAYERS_NOT_FOUND');
                }
            } else {
                return $this->answer(self::ANSWER_ERROR, 'WRONG_DATA');
            }
        } else {
            return $this->answer(self::ANSWER_ERROR, 'WRONG_KEY');
        }
    }

	/**
	 * External_Forum::getInfo()
	 *
	 * @param mixed $values
	 * @param mixed $values2
	 * @return
	 */
	public function getInfo($session)
	{
		global $data;

        if (empty($session)) {
			return $this->answer(self::ANSWER_ERROR);
		}

        //session_id($session);

        //var_dump($SESSION);

        //Runtime::init();

        //if (Runtime::$uid) {
            //Std::loadMetaObjectClass('player');
        list ($id, $password) = explode('_', $session);
        $player = $this->sql->getRecord("SELECT p.id, p.password, p.nickname, p.ip, p.forum_avatar, p.forum_avatar_checked, p.avatar,
            p.email, i.path, p.avatar, p.fraction, p.level, c.name clan, c.id clanid
            FROM player p LEFT JOIN clan c ON c.id=p.clan LEFT JOIN stdimage i ON i.id=p.forum_avatar
            WHERE p.id='" . $id . "'");
        if ($player && sha1($player['password']) == $password) {
            if ($player['forum_avatar'] > 0 && $player['forum_avatar_checked'] == 1) {
                $player['avatar'] = '/@images/' . $player['path'];
            }
            foreach ($data['classes'] as $key => $cur) {
                if ($cur['avatar'] == $player['avatar']) {
                    $player['avatar'] = '/@/images/pers/' . $cur['thumb'];
                }
            }

            return $this->answer(self::ANSWER_OK, array(
                'name'    => $player['nickname'],
                'player'  => $player['id'],
                'ip'      => long2ip($player['ip']),
                'avatar'  => 'http://www.moswar.ru' . $player['avatar'],
                'email'   => $player['email'],
                'race'    => $player['fraction'] == 'resident' ? 1 : 2,
                'gamedata' => array(
                    'level'   => $player['level'],
                    'clan'    => $player['clan'],
                    'clanid'  => $player['clanid'],
                    'clanimg' => 'http://www.moswar.ru/@images/clan/clan_' . $player['clanid'] . '_ico.png',
                ),
            ));
        } else {
			return $this->answer(self::ANSWER_NOTEXISTS);
		}
	}

	private function answer($code, $data = "")
	{
		return json_encode(array("status" => $code, "data" => $data));
	}
}
?>