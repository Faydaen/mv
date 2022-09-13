<?php

// Константы
// ...
define('ALERT_INFO', 1);
define('ALERT_ERROR', 2);
define('ALERT_INFO_BIG', 3);

/**
 * Модуль статической страницы
 *
 */
/*
 * @todo boost - проверка на повторяемость бустов
 * @todo чат
 * @todo наперстки - игр не более n в день
 */

class Page implements IBaseModule {

	public static $sql;
	public static $mongo = null;
	public static $sphinx = null;
	public static $cache;
	public static $player = false;
	public static $player2 = false;
	public static $data;
	public static $debugCall = 0;
	public static $debugSessId = '';
	protected $content = array();
	public $url = array();
	public $shellArgs = array();
	public $pageId = 0;
	public $template;
	public $moduleCode = 'Page';
	public $page;
	public $quests;
	public $location;
	public $checkQuests = true;
	public $reloadedFields;
	public static $chatSocket = null;
	protected static $billing_key = 'kbmzmnbnk1o4kfjghhmbnzkQLakzo!kakkbm';
	protected static $billing_path = 'http://billing23.theabyss.ru/';
	protected static $billing_ip = '85.199.75.154';
	protected static $billing_ip_backup = '178.162.181.101';
	protected static $billing_server = 'moswar';
	public static $transactions = array();
	private static $curlHttpStatus;
	public static $__LOG_TABLE__ = 'log';

	/*
	 * @var playerObject
	 */
	public $dataset;

	public static function initSql() {
		self::$sql = SqlDataSource::getInstance();
		self::$__LOG_TABLE__ = 'log' . date('Ymd');
	}

	public static function initSphinx() {
		self::$sphinx = SphinxDataSource::getInstance();
	}

	public static function initMongo() {
		self::$mongo = MongoDataSource::getInstance();
	}

	public static function initCache() {
		self::$cache = new Cache();
	}

	public static function initData() {
		self::$data = $GLOBALS['data'];		
	}

	public static function getMongo() {
		if (self::$mongo == null) {
			self::initMongo();
		}
		return self::$mongo;
	}

	public function __construct() {
		self::initSql();
		if (!self::$sql) {
			$this->dieOnError(500);
		}

		self::initData();
		self::initCache();
		
		cacheManager::init(self::$cache, self::$sql, $GLOBALS['cacheObjects']);
		
		CacheManager::multiGet('players_online', 'rulesver', 'value_flag_player', 'value_flag_clan', 'value_flag_fraction', 'value_registrations', 'value_sovet_results_calculated', 'lastnews');

		$this->content['online'] = max(1, CacheManager::get('players_online'));
		$this->content['registered'] = CacheManager::get('value_registrations');

		$this->location = strtolower($this->moduleCode);
		if ($this->page !== false) {
			$this->page = new PageXHTML(self::$cache);
			$this->page->setTemplate('layout.html');
		}
	}

	public function __destruct() {
		if (self::$cache != null) {
			self::$cache->close();
		}
		if (self::$chatSocket != null) {
			@socket_close(self::$chatSocket);
		}
	}

	public static function getPlayerNameByID($id) {
	    return Page::$sql->getValue("SELECT nickname FROM player WHERE id = {$id} LIMIT 1");
	}

	public static function printPlayer($id) {
	   $player = Page::$sql->getRecord("SELECT fraction, nickname, level FROM player WHERE id = {$id} LIMIT 1");
	   $str .= '<span class="user">';
	   switch ($player['fraction']){
	    case 'arrived':
		$str .= '<i class="arrived" title="Понаехавший"></i>';
		break;
	    case 'resident':
		$str .= '<i class="resident" title="Коренной"></i>';
		break;
	   }
	   $str .= '<a href="/player/'.$id.'/">'.$player['nickname'].'</a>';
	   $str .= '<span class="level">['.$player['level'].']</span>';
	   $str .= '</span>';
	   return $str;
	}


	public static function chatSystemSend($text, $room) {
		if (DEV_SERVER) {
			$address = "dev.moswar.ru";
		} else {
			$address = "10.1.4.2";
		}
		$port = 8081;
		if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) && (socket_connect($socket, $address, $port))) {
			socket_write($socket, '{"action":"system","data":{"message":"' . $text . '","room":"' . $room . '","key":"systemmess4ge!23"}}' . "\n");
			socket_close($socket);
		}
	}

	public static function chatGetPlayers($room) {
		if (DEV_SERVER) {
			$address = "dev.moswar.ru";
		} else {
			$address = "10.1.4.2";
		}
		$port = 8081;
		if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) && (socket_connect($socket, $address, $port))) {
			socket_write($socket, '{"action":"players","data":{"room":"' . $room . '","key":"pl4yersroom12!@"}}' . "\n");
			$i = 0;
			while(!$response = strip_tags(trim(@socket_read($socket, 40960)))) { usleep(10000); $i++; if ($i > 100) return false; };
			socket_close($socket);
			$response = json_decode($response, true);
			return $response["data"]["players"];
		} else {
			return false;
		}
	}

	public static function chatUpdateInfo($info) {
		if (empty($info))
			return;
		$key = "chat1nf0upd@te123456q.";
		if (DEV_SERVER) {
			$address = "dev.moswar.ru";
		} else {
			$address = "10.1.4.2";
		}
		$port = 8081;

		$data = array();
		$data["action"] = "info";
		$data["data"] = array();
		$data["data"]["key"] = $key;
		$data["data"]["info"] = $info;

		if (self::$chatSocket == null) {
			if ((self::$chatSocket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) && (@socket_connect(self::$chatSocket, $address, $port))) {
				socket_write(self::$chatSocket, json_encode($data) . "\n");
			}
		} else {
			socket_write(self::$chatSocket, json_encode($data) . "\n");
		}
		/*
		if (($socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) && (@socket_connect($socket, $address, $port))) {
			$data = array();
			$data["action"] = "info";
			$data["data"] = array();
			$data["data"]["key"] = $key;
			$data["data"]["info"] = $info;

			socket_write($socket, json_encode($data) . "\n");
			//socket_close($socket);
		}
		*/
	}

	/**
	 * Общие для всех страниц действия перед обработкой запроса
	 *
	 */
	public function onBeforeProcessRequest() {
		Runtime::init();
		$this->tryAutoLogin();

		Std::loadLang();

		if (self::$player->id > 0) {
			header("X-Accel-UserID: " . self::$player->id);
			
			$this->page->player = self::$player;

			Std::loadMetaObjectClass('player2');
			self::$player2 = new player2Object();
			self::$player2->load(self::$player->id);
			
			// монеты
			if (self::$player2->addmoney > 0) {
				self::$player->money += self::$player2->addmoney;
				self::$player->save(self::$player->id, array(playerObject::$MONEY));

				self::sendLog(self::$player->id, 'addmn', array('m' => self::$player2->addmoney, 'i' => self::$player2->addmoneycomment));
				self::$player2->newlogs++;
				self::addAlert(PageLang::$logAddMoneyTitle, Lang::renderText(PageLang::$logAddMoneyText, array('money' => self::$player2->addmoney))); //  . self::$player2->addmoneycomment

				self::$player2->addmoney = 0;
				self::$player2->addmoneycomment = '';
				self::$player2->save(self::$player2->id, array(player2Object::$ADDMONEY, player2Object::$ADDMONEYCOMMENT));
			}

			// квесты
			if ($this->checkQuests != false) {
				$this->checkQuests();
			}

			if ($_SESSION["protect_gameleads"]) {
				$this->content["protect_gameleads"] = "true";
				$this->content["protect_order"] = Page::$player->id;
				$this->content["protect_md5"] = md5("78" . Page::$player->id);
				$_SESSION["protect_gameleads"] = false;
			}

			// принятие новых правил
			$rulesVer = CacheManager::get('rulesver');
			if ($rulesVer != self::$player->rulesver && !(substr($_GET['url'], 0, 8) == 'licence/' && $this->moduleCode == 'Page' ) && !stristr($_GET['url'], 'logout')) {
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['licence_agree'])) {
					self::$player->rulesver = $rulesVer;
					self::$player->save(self::$player->id, array(playerObject::$RULESVER));
				} else {
					$this->content['window-name'] = PageLang::AGREEMENT;
					$this->page->addPart('content', 'other/licence.xsl', $this->content);
					$this->renderPage();
					exit;
				}
			}

			// редирект при истечении таймера
			if (self::$player->stateparam != '' && time() >= (int) self::$player->timer) {
				$stateparam = json_decode(self::$player->stateparam, true);
				switch ($stateparam['action']) {
					case 'redirect':
						self::$player->stateparam = '';
						self::$player->save(self::$player->id, array(playerObject::$STATEPARAM));
						Std::redirect($stateparam['url'], true);
						break;
				}
			}

			// отложенные алерты
			if (self::$player2->alert != '') {
				$alerts = json_decode(self::$player2->alert, true);
				if (count($alerts) > 0) {
					foreach ($alerts as $key => $alert) {
						$alert = current($alerts);
						break;
					}
					unset($alerts[$key]);
					Page::addAlert($alert['title'], $alert['text'], $alert['type'], $alert['actions']);
					self::$player2->alert = json_encode($alerts);
					self::$player2->save(self::$player2->id, array(player2Object::$ALERT));
				}
			}

			if (Page::$player->id%100 == 1) {
				SqlDataSource::$debug = true;
			}
		} else {
			// пользователь НЕ авторизован
		    
		}

		// общие действия
		//$this->url = explode('/', substr($_GET['url'], 0, -1));
		$_GET['url'] = trim($_GET['url'], '/');
		$this->url = explode('/', $_GET['url']);
		$this->template = 'page.html';
		// ...
		$content = Runtime::get('content');
		if ($content !== false && is_array($content) && count($content) > 0) {
			$this->content = array_merge($this->content, $content);
			Runtime::clear('content');
		}
		$this->content['servertime'] = time();
		$this->content['DEV_SERVER'] = DEV_SERVER ? 1 : 0;
	}

	/**
	 * Общие для всех страниц действия после обработки запроса
	 *
	 */
	public function onAfterProcessRequest() {
		if ($this->page !== false) {
			if (self::$player->id > 0) {
				// пользователь авторизован
				//$playerblock = self::$player->toArray();
				$this->generatePlayerBlock();

				$friends = CacheManager::get('friends_online', array('player_id' => Page::$player->id));
				$this->page->addPart('friends-side', 'phone/side.xsl', array('friends' => $friends));

				if (self::$player->timer > time() && self::$player->state != '') {
					$this->content['timer'] = max(self::$player->timer, self::$player->lastfight) - time();
					$timerLocation = Page::stateToLocation(self::$player->state);
					$this->content['location'] = $timerLocation == 'frozen' ? 'fight' : $timerLocation;
					$this->content['endtime'] = max(self::$player->timer, self::$player->lastfight);
				} else if (self::$player->lastfight > time()) {
					$this->content['timer'] = self::$player->lastfight - time();
					$this->content['location'] = 'alley';
					$this->content['endtime'] = self::$player->lastfight;
				}

				$this->content['head-content'] .= "var player = new Array();
player['nickname'] = '" . Page::$player->nickname . "';
player['level'] = " . Page::$player->level . ";
player['avatar_thumb'] = '" . str_replace('.png', '_thumb.png', Page::$player->avatar) . "';" . PHP_EOL;
				if (Page::$player2->werewolf == 1) {
					$tmp = is_array(Page::$player2->werewolf_data) ? Page::$player2->werewolf_data : json_decode(Page::$player2->werewolf_data, true);
					$werewolf_level = $tmp['level'];
					$this->content['head-content'] .= "player['werewolf'] = 1;
player['werewolf_level'] = " . $werewolf_level . ";" . PHP_EOL;
				}

				$this->content['head-content'] .= "var postVerifyKey = '" . $this->generatePostKey() . "';" . PHP_EOL;

				if (isset($this->content['head-content']) && strlen($this->content['head-content'])) {
					$this->content['head-content'] = "<script>" . $this->content['head-content'] . "</script>";
				}

			} else {
				// пользователь НЕ авторизован
				$this->page->addPart('playerblock', 'player/block-unregistered.xsl', array());
			}

			// session
			$this->page->addValue('session', self::$player->id . '_' . sha1(self::$player->password));
			$this->page->addValue('new-forum', (DEV_SERVER ? 'new.' : ''));

			// независимо от авторизации
			$this->page->addValue('rating-side', file_get_contents('@cache/rating_side.html'));

			//
			$lastNews = CacheManager::get('lastnews');
			$this->page->addValue('news', (self::$player2->lastnews != $lastNews ? 'style="color:red;"' : ''));

			if (self::$player->level == 1) {
				$this->content["hidearr1"] = '<!--';
				$this->content["hidearr2"] = '-->';
			}

			$alerts = Runtime::get('alerts');
			if ($alerts) {
				$tpl = Std::loadTemplate('alert');
				$alertbox = '';
				$i = 1;
				foreach ($alerts as $a) {
					$a['n'] = $i;
					$alertbox .= Std::renderTemplate($tpl, $a);
					$i++;
				}
				Runtime::clear('alerts');
				$this->page->addValue('alertbox', $alertbox);
			}
		}
		Page::forceEndTransactions();
	}

	public function generatePlayerBlock() {
		$playerblock = array('id' => Page::$player->id, 'nickname' => Page::$player->nickname, 'level' => Page::$player->level,
			'money' => Page::$player->money, 'ore' => Page::$player->ore, 'honey' => Page::$player->honey, 'oil' => Page::$player->oil,
			'hp' => Page::$player->hp, 'maxhp' => Page::$player->maxhp, 'avatar' => Page::$player->avatar,
			'suspicion' => Page::$player->suspicion);
		if (self::$player->forum_avatar > 0 && self::$player->forum_avatar_checked == 1) {
			//$playerblock['avatar'] = '/@images/' . Page::sqlGetCacheValue("SELECT path FROM stdimage WHERE id = " . self::$player->forum_avatar, 86400, 'stdimage_path_' . self::$player->forum_avatar);
			$playerblock['avatar'] = '/@images/' . CacheManager::get('stdimage_path', array('image_id' => Page::$player->forum_avatar));
		} else if ($playerblock['avatar'] != '') {
			$playerblock['avatar'] = '/@/images/pers/' . str_replace('.', '_thumb.', $playerblock['avatar']);
		}
		$playerblock['procenthp'] = floor($playerblock['hp'] / $playerblock['maxhp'] * 100);
		$playerblock['procentsuspicion'] = floor(($playerblock['suspicion'] + 5) / 10 * 100);
		//$playerblock['newmessages'] = Page::getData("players/" . self::$player2->id . "/newmes", "SELECT COUNT(1) FROM `message` WHERE `player2` = " . self::$player->id . " AND `read` = 0 AND visible2 = 1 AND `time` <= " . time(), 'value', 10);
		//$playerblock['newlogs'] = Page::getData("players/" . self::$player->id . "/newlogs", "SELECT COUNT(1) FROM `log` WHERE `player` = " . self::$player->id . " AND `read` = 0", 'value', 10);
		$playerblock['newmes'] = self::$player2->newmes;
		$playerblock['newlogs'] = self::$player2->newlogs;
		$playerblock['newduellogs'] = self::$player2->newduellogs;

		// агит-плакаты противостояния
		$playerblock["sovetday1"] = $playerblock["sovetday2"] = $playerblock["sovetday4"] =
				$playerblock["sovetday5"] = $playerblock["sovetdaywin"] = $playerblock["sovetdayfail"] = "none";
		if (self::$player->level > 2) {
			$playerblock["sovetdaynum"] = date("N", time());
			if (date("N", time()) <= 5) {
				$playerblock["sovetday" . date("N", time())] = "block";
			} else {
				if (date("N", time()) > 5 && CacheManager::get('value_sovet_results_calculated') == 1) {
					if ($this->getData('sovet' . self::$player->fraction . 'result', "SELECT result FROM sovet3 WHERE fraction = '" . self::$player->fraction . "'
								ORDER BY id DESC LIMIT 0,1", 'value', 3600) == 1) {
						$playerblock["sovetdaywin"] = 1;
					} else {
						$playerblock["sovetdayfail"] = 1;
					}
				}
			}
		}

		if (self::$player->level > 5 && $playerblock["sovetdaynum"] == 1 && rand(0, 1) == 0) {
			$playerblock['taxiblock'] = 1;
		} else {
			$playerblock['taxiblock'] = 0;
		}

		$this->page->addPart('playerblock', 'player/block.xsl', $playerblock);
	}

	/*
	 *
	 */
	public function processPostRequest($result) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST['ajax'] = (bool) @$_POST['ajax'];
			if ($_POST['ajax']) {
				echo json_encode($result);
				exit;
			} else {
				if ($result['result'] == 0) {
					if (!isset($result['error'])) {
						$this->dieOnError(404);
					}
					if (!isset($result['title'])) {
						$result['title'] = PageLang::ERROR;
					}
					Page::addAlert($result['title'], $result['error'], ALERT_ERROR);
				} else {
					if (!isset($result['title'])) {
						$result['title'] = PageLang::ALERT_OK;
					}
					Page::addAlert($result['title'], $result['text'], ALERT_INFO);
				}
				if ($_POST['return_url']) {
					$result['return_url'] = $_POST['return_url'];
				}
				Std::redirect($result['return_url']);
			}
		}
	}

	public static function isEnoughMoney($money) {
		foreach ($money as $currency => $value) {
			if ($currency == 'ore') {
				$have = Page::$player->ore + Page::$player->honey;
				if (Page::$player->ore < $value) {
					if ($money['ore'] + (int) $money['honey'] > $have) {
						return false;
					}
				}
			} else if ($currency == 'oil') {
				$have = Page::$player->oil + Page::$player->honey * 5;
				if (Page::$player->oil < $value) {
					if ($money['oil'] + (int) $money['honey'] > $have) {
						return false;
					}
				}
			}
			else {
				$have = Page::$player->{$currency};
			}
			if ($have < $value) {
				return false;
			}
		}
		return true;
	}

	public static function spendMoney($money, $save = false, &$changes = null, $reason = null) {
		$fields = array();
		
		foreach ($money as $currency => $value) {
			$fields[playerObject::${strtoupper($currency)}] = $currency;
			if ($currency == 'ore') {
				if (Page::$player->ore >= $value) {
					Page::$player->ore -= $value;
					$changes['ore'] -= $value;
				} else {
					$value -= Page::$player->ore;
					$changes['ore'] -= Page::$player->ore;
					Page::$player->ore = 0;
					$priceHoneyOre = $value;
					Page::$player->honey -= $value;
					$changes['honey'] -= $value;
					$fields[playerObject::$HONEY] = 'honey';
				}
			} else if ($currency == 'oil') {
				if (Page::$player->oil >= $value) {
					Page::$player->oil -= $value;
					$changes['oil'] -= $value;
				} else {
					$value -= Page::$player->oil;
					$changes['oil'] -= Page::$player->oil;
					Page::$player->oil = 0;
					$value = ceil($value/5);
					$priceHoneyOil = $value;
					Page::$player->honey -= $value;
					$changes['honey'] -= $value;
					$fields[playerObject::$HONEY] = 'honey';
				}
			} else {
				Page::$player->{$currency} -= $value;
				$changes[$currency] -= $value;
			}
		}
		
		if (isset($changes['honey']) && abs($changes['honey']) > 0) {
			$reason	= $reason . ' h' . abs((int) $changes['honey']) . ' (o' . abs((int)$priceHoneyOre) . ' + n' . abs((int)$priceHoneyOil) . ') + o' . abs((int)$changes['ore']) . ' + n' . abs((int)$changes['oil']) . ' + m' . abs((int)$money['changes']);
			$takeResult = Page::doBillingCommand(Page::$player->id, abs($changes['honey']), 'takemoney', $reason, $other);
			if ($takeResult[0] != 'OK') {
				foreach ($changes as $c => $v) {
					Page::$player->{$c} -= $v;
				}
				return false;
			}
		}

		if ($save) {
			Page::$player->save(Page::$player->id, array_keys($fields));
		}

		return $fields;
	}

	public static function giveMoney($money, $save = false, &$changes = null) {
		$fields = array();

		foreach ($money as $currency => $value) {
			$fields[playerObject::${strtoupper($currency)}] = $currency;
			Page::$player->{$currency} += $value;
			$changes[$currency] += $value;
		}

		if ($save) {
			Page::$player->save(Page::$player->id, array_keys($fields));
		}

		return $fields;
	}

	public function getMbckp($fields = 'all') {
		$result = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey, 'n' => self::$player->oil);
		return $result;
	}

	public function translatePriceForLogs($changes) {
		$result = array();
		foreach ($changes as $currency => $value) {
			switch ($currency) {
				case 'oil':
					$key = 'n';
					break;

				default:
					$key = substr($currency, 0, 1);
			}
			$result[$key] = abs($value);
		}
		return $result;
	}

	/**
	 * Обработка запроса
	 *
	 */
	public function processRequest() {
		$this->onBeforeProcessRequest();
		
		
		if ($this->url[0] == 'unlock') {
			$this->paidUnlock();
		} else if ($this->url[0] == 'underconstruction') {
			$this->page->addPart('content', 'underconstruction/underconstruction.xsl', array());
		} else if ($this->url[0] == 'birthday' && $_POST['action'] == 'print_invite') {
			//$this->page->addPart('content', 'underconstruction/underconstruction.xsl', array());
			$this->needAuth();
			$this->page->setTemplate('invite.html');
			$this->content = Page::$player->toArray();
			if (mb_strlen(Page::$player->nickname) >= 16) {
				$this->content['style'] = ' style="font-size:75%"';
			}
			$sql = "INSERT INTO player_invite (player) VALUES(" . Page::$player->id . ")";
			Page::$sql->query($sql);
		} else if ($this->url[0] == 'birthday' && $this->url[1] == 'list') {
			$content = Page::$cache->get('birthday_list_content');
			if (!$content) {
				$sql = "SELECT p.id, p.nickname, p.fraction, p.level, p.clan, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan_id, c.name as clan_name FROM player_invite pi LEFT JOIN player p ON pi.player = p.id LEFT JOIN clan c ON c.id = p.clan";
				$players = Page::$sql->getRecordSet($sql);
				Std::loadLib('Xslt');
				$content = Xslt::getHtml2('other/invite_list', array('players' => $players));
				Page::$cache->set('birthday_list_content', $content, 600);
			}
			echo $content;
			exit;
		} else {
			// генерация статической страницы
			$this->renderStaticPage();
		}
		// ...
		//
		$this->onAfterProcessRequest();
	}

	/**
	 * Генерация статической страницы
	 *
	 */
	public function renderStaticPage() {
		$page = $this->sqlGetRecord("SELECT * FROM stdpage WHERE id=" . $this->pageId);
		$this->content['text'] = $page['content'];
		$this->content['window-name'] = $page['name'];
		$this->content['title'] = $page['name'];
		$this->page->addPart('content', 'static.xsl', $this->content);
	}

	/**
	 * Генерация страницы
	 *
	 */
	public function renderPage() {
		//$html = Std::renderTemplate($this->template, $this->content);
		if (is_array($this->content) && count($this->content)) {
			foreach ($this->content as $key => $value) {
				$this->page->addValue($key, $value);
			}
		}
		$html = $this->page->create();
		$html = preg_replace('/<%[^>]*%>/', '', $html);
		echo $html;
		//exit;
	}

	/*
	 * Проверяет код на соответствие с ранее показаной каптчей
	 *
	 * @param string $code
	 * @return bool
	 */

	public function checkCaptcha($code) {
		if (isset($_SESSION['captcha']) && strtolower($_SESSION['captcha']) == strtolower($_POST['code'])) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Определение страницы по URL
	 *
	 */
	public function getPage() {
		$this->url = explode('/', trim($_GET['url'], '/'));
		if ($this->url[0] == 'captcha') {
			if ($_POST['action'] == 'check_captcha') {
				if ($this->checkCaptcha($_POST['code'])) {
					Runtime::set('attacks', 0);
					echo 'ok';
				} else {
					echo 'bad code';
				}
				exit;
			}
			Std::loadLib('ImageTools');
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-cache, must-revalidate");
			header("Cache-Control: post-check=0,pre-check=0", false);
			header("Cache-Control: max-age=0", false);
			header("Pragma: no-cache");
			//ImageTools::generateCaptcha(5, 150, 50, array(243, 140, 35), array(255, 255, 255));
			ImageTools::generateCaptcha(5, 120, 30, array(216, 202, 193), array(79, 23, 4));
		}

		$url = substr($_GET['url'], 0, -1);
		if ($_SERVER['REQUEST_URI'] == '/') { // главная страница
			$url = 'index';
		}
		$qs = explode('/', substr($_SERVER['REQUEST_URI'], 1, -1));
		if ($this->moduleCode != 'Page' && $qs[0] == strtolower($this->moduleCode)) {
			// дописываем часть URL с модулем, убранную в .htaccess
			$url = strtolower($this->moduleCode) . ($url ? '/' . $url : '');
		}
		$path = $this->url = explode('/', $url);
		$path[] = '';
		while (!$this->pageId && sizeof($path) > 1) {
			array_pop($path);
			$i = count($path) - 1;
			$query = "SELECT n$i.id, m.code module, t.code template, n$i.windowname, n$i.metadescription, n$i.metakeywords, n$i.name FROM stdpage n$i LEFT JOIN stdtemplate t ON t.id=n$i.stdtemplate_id
				LEFT JOIN stdmodule m ON m.id=n$i.stdmodule_id <%join%> WHERE n$i.url='{$path[$i]}' <%where%>";
			for ($j = 1, $count = sizeof($path); $j < $count; $j++) {
				$join = "INNER JOIN stdpage n" . ($i - $j) . " ON n" . ($i - $j) . ".id=n" . ($i - $j + 1) . "._id <%join%>";
				$where = "AND n" . ($i - $j) . ".url='" . $path[($i - $j)] . "' <%where%>";
				$query = str_replace(array('<%join%>', '<%where%>'), array($join, $where), $query);
			}
			$query = str_replace(array('<%join%>', '<%where%>'), array('', " AND n" . ($i - $j + 1) . "._id=0"), $query);
			$page = $this->sqlGetRecord($query);
			if ($page) {
				$this->pageId = $page['id'];
				$this->moduleCode = $page['module'];
				//$this->template = $page['template'];
			}
		}
		if (!$this->pageId) {
			$this->dieOnError(404);
		}
	}

	/*
	 * Показ страницы для платной разблокировки, разблокировка
	 */

	public function paidUnlock() {

		// выкидывание незалогиненных и незаблокированных игроков со страницы
		$this->needAuth();
		if (self::$player->accesslevel != -1 && self::$player->accesslevel != -2) {
		    Std::redirect('/player/');
		}


		// проверка на заморозку
		if (self::$player->accesslevel == -2) {
			$crioDt = strtotime(self::$player->lastactivitytime);
			$nowDt = time();
			$diff = $nowDt - $crioDt;
			if ($diff >= 2 * 24 * 60 * 60) {
			    #echo 'размарозка'; exit;
				self::$sql->query("UPDATE rating_player SET `visible` = 1 WHERE player = " . self::$player->id);
				self::$sql->query("UPDATE rating_player2 SET `visible` = 1 WHERE player = " . self::$player->id);
				self::$sql->query("UPDATE player SET accesslevel = 0, homesalarytime = " . mktime(date("H"), 0, 0) . " WHERE id = " . self::$player->id);

				$key = Page::signed(self::$player->id);
				$userInfo = array();
				$userInfo[$key] = array();
				$userInfo[$key]["accesslevel"] = 0;
				Page::chatUpdateInfo($userInfo);

				$cachePlayer = Page::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["accesslevel"] = 0;
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}

				// военные штучки
				Std::loadMetaObjectClass('diplomacy');
				$warId = diplomacyObject::isAtWar(self::$player->clan);
				if ($warId) {
					$war = new diplomacyObject();
					$war->load($warId);
					if ($war->state == 'step1') {
						$war->setKills(self::$player->id, $GLOBALS['data']['diplomacy']['kills']);
					}
				}

				Std::redirect('/player/');
			}
		}


		// определение типа и стоимости разблокировки
		if (self::$player->accesslevel == -1) {
			$honey = self::$player2->unbancost;
			if ($honey <= 0) {
				$honey = 0;
			}
			$type = 'blocked';
		} else if (self::$player->accesslevel == -2) {
			$honey = 50;
			$type = 'frozen';
		}

		// процесс разблокировки
		if ($_POST['action'] == 'unlock') {
			// оплата в биллинг
			$reason = 'unlock $' . $honey;
			$takeResult = self::doBillingCommand(self::$player->id, $honey, 'takemoney', $reason, $other);

			if ($takeResult[0] == 'OK') {
				// разблокировка игрока
				self::$player->accesslevel = 0;
				self::$player->honey -= $honey;
				self::$player->save(self::$player->id, array(playerObject::$ACCESSLEVEL, playerObject::$HONEY));

				self::$sql->query("UPDATE rating_player SET `visible` = 1 WHERE player = " . self::$player->id);
				self::$sql->query("UPDATE rating_player2 SET `visible` = 1 WHERE player = " . self::$player->id);


				$key = Page::signed(self::$player->id);
				$userInfo = array();
				$userInfo[$key] = array();
				$userInfo[$key]["accesslevel"] = self::$player->accesslevel;
				Page::chatUpdateInfo($userInfo);

				$cachePlayer = Page::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["accesslevel"] = self::$player->accesslevel;
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}

				self::$player2->unbancost = 0;
				self::$player2->save(self::$player2->id, array(player2Object::$UNBANCOST));

				// отправка лога разблокировки
				$mbckp = array('h' => self::$player->honey);
				Page::sendLog(self::$player->id, 'unlock', array('t' => $type, 'honey' => $honey, 'mbckp' => $mbckp), 1);

				// добавления комментария разблокировки в досье игрока
				Std::loadLib('HtmlTools');
				if ($type == 'frozen') {
					$text = PageLang::FEE_FREES_ITSELF . $honey . ' ' . HtmlTools::russianNumeral($honey, PageLang::HONEY_ONE, PageLang::HONEY_MANY, PageLang::HONEY_MANY);
				} else if ($type == 'blocked') {
					$text = PageLang::FEE_UNLOCK_ITSELF . $honey . ' ' . HtmlTools::russianNumeral($honey, PageLang::HONEY_ONE, PageLang::HONEY_MANY, PageLang::HONEY_MANY);
				}
				Std::loadModule('playeradmin');
				Playeradmin::adminAddPlayerComment(self::$player->id, PageLang::PAID_UNLOCK, '', $text, false);

				// перекидывание на свой профиль в случае успеха
				Std::redirect('/player/');
			} else {
				// ошибка оплаты - не хватает меда
				$this->content['error'] = 'no money';
			}
		}

		// генерация страницы
		$this->content['time'] = strtotime(self::$player->lastactivitytime) - time() + 48 * 3600;
		$this->content['costHoney'] = $honey;
		$this->content['window-name'] = PageLang::CHARACTER_ACTIVATION;
		$this->content['player'] = self::$player->toArray();
		$this->page->addPart('content', 'other/unlock.xsl', $this->content);
	}

	// Полезные функции

	public function generatePostKey() {
		$postKey = md5(time() . mt_rand());
		Runtime::set('post_key', $postKey);
		$this->content['post_key'] = $postKey;
		return $postKey;
	}

	public function verifyPostKey($key = '') {
		if ($key == '') {
			$key = $_POST['post_key'];
		}
		$postKey = Runtime::get('post_key');
        //echo '<!--'.$key.'-'.$postKey.'-->';
		if ($postKey === false || $key == $postKey) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Поиск ID верхней страницы раздела
	 *
	 * @param int $pageId
	 * @return int
	 */
	protected function getTopParentPage($pageId) {
		$parentId = $pageId;
		$parent = $this->sqlGetRecord("SELECT id, _id, url FROM stdpage WHERE id=$parentId");
		while ($parentId) {
			$parent = $this->sqlGetRecord("SELECT id, _id, url FROM stdpage WHERE id=$parentId");
			$parentId = $parent['_id'];
			$page = $parent;
		}
		return $page;
	}

	/**
	 * Генерация древовидного меню
	 *
	 * @param int $parentPageId
	 * @param int $selectedPageId
	 * @param string $itemTemplate
	 * @param string $groupTemplate
	 * @param bool $expandAll
	 * @return string
	 */
	protected function generateTreeMenu($parentPage, $selectedPageID, $ItemTemplate, $selectedItemTemplate, $levelTemplate, $maxLevel=0, $expandAll=false, $nameMetaAttributeCode='menuname', $orderByMetaAttributeCode='pos') {
		$html = '';
		$path = $parentPage['url'];
		$this->generateTreeMenuLevel($html, 0, $path, $parentPage['id'], $selectedPageID, $ItemTemplate, $selectedItemTemplate, $levelTemplate, $maxLevel, $expandAll, $nameMetaAttributeCode, $orderByMetaAttributeCode);
		return $html;
	}

	protected function generateTreeMenuLevel(&$html, $level=0, $path, $parentPageID, $selectedPageID, $ItemTemplate, $selectedItemTemplate, $levelTemplate, $maxLevel, $expandAll, $nameMetaAttributeCode, $orderByMetaAttributeCode) {
		$levelHtml = '';
		$pages = $this->SqlGetRecordSet("SELECT p.id, p.url, p.$nameMetaAttributeCode name, (SELECT count(*) FROM stdpage WHERE _id=p.id) sub
			FROM stdpage p WHERE p._id=$parentPageID AND p.$nameMetaAttributeCode!='' ORDER BY p.$orderByMetaAttributeCode ASC");
		if ($pages) {
			foreach ($pages as $page) {
				$page['url'] = $path . '/' . $page['url'];
				if ($level) {
					$levelHtml .= Std::renderTemplate(($page['id'] == $selectedPageID ? $selectedItemTemplate : $ItemTemplate), $page);
				} else {
					$html .= Std::renderTemplate(($page['id'] == $selectedPageID || ($maxLevel == 1 && ('/' . $this->Url[0] == $page['url'] || '/' . strtolower($this->ModuleCode) == $page['url'])) ? $selectedItemTemplate : $ItemTemplate), $page);
				}
				$SubHtml = '';
				if (($page['sub'] > 0 && (strstr($_SERVER['REQUEST_URI'], $page['url'] . '/')) || $expandAll) && ($maxLevel == 0 || $maxLevel > ($level + 1))) {
					$this->generateTreeMenuLevel($SubHtml, ($level + 1), $page['url'], $page['id'], $selectedPageID, $ItemTemplate, $selectedItemTemplate, $levelTemplate, $maxLevel, $expandAll, $nameMetaAttributeCode, $orderByMetaAttributeCode);
				}
				if ($level) {
					$levelHtml = Std::renderTemplate($levelHtml, array('sub-menu' => $SubHtml));
				} else {
					$html = Std::renderTemplate($html, array('sub-menu' => $SubHtml));
				}
			}
		}
		if ($level) {
			$html .= Std::renderTemplate($levelTemplate, array('items' => $levelHtml));
		}
	}

	static function dieOnError($error, $message='') {
		switch ($error) {
			case 404:
				header("HTTP/1.0 404 Not Found");
				break;
			case 500:
				header("HTTP/1.0 500 Internal Server Error");
				break;
		}
		echo Std::renderTemplate(Std::loadTemplate('error/' . $error), array('message' => $message));
		//echo '<!-- ' . $_SERVER['REQUEST_FILENAME'] . '; ' . $_SERVER['REQUEST_URI'] . ' -->';
		//header('Location: /error/' . $error . '/');
		exit;
	}

	// Сокращения для вызова функций работы с БД

	/**
	 * Получить значение из БД
	 *
	 * @param string $query
	 * @return string
	 */
	protected function sqlGetValue($query) {
		return self::$sql->getValue($query);
	}

	/**
	 * Получить массив значений из БД
	 *
	 * @param string $query
	 * @return array
	 */
	protected function sqlGetValueSet($query) {
		return self::$sql->getValueSet($query);
	}

	/**
	 * Получить запись (record) из БД
	 *
	 * @param string $query
	 * @return array
	 */
	protected function sqlGetRecord($query) {
		return self::$sql->getRecord($query);
	}

	/**
	 * Получить набор записей (record set) из БД
	 *
	 * @param string $query
	 * @return array
	 */
	protected function sqlGetRecordSet($query) {
		return self::$sql->getRecordSet($query);
	}

	/**
	 * Вставить запись в БД
	 *
	 * @param string $query
	 * @return int - ID вставленной записи
	 */
	protected function sqlInsert($query) {
		return self::$sql->insert($query);
	}

	/**
	 * Выполнить запрос к БД
	 *
	 * @param string $query
	 * @return sql resource
	 */
	protected function sqlQuery($query) {
		return self::$sql->query($query);
	}

	// Общие для всех модулей проекта функции
	// ...1

	/**
	 * Получение данных из БД с кешированием
	 *
	 * @param string $name - имя переменной в кеше
	 * @param string $query - SQL запрос
	 * @param string $type - тип запроса: value, valueset, record, recordset
	 * @param int $expire - время кеширования
	 * @return mixed
	 */
	public static function getData($name, $query, $type = 'value', $expire = 600) {
		$value = self::$cache->get($name);
		if ($value === false) {
			switch ($type) {
				case 'value':
					$value = self::$sql->getValue($query);
					break;
				case 'valueset':
					$value = self::$sql->getValueSet($query);
					break;
				case 'record':
					$value = self::$sql->getRecord($query);
					break;
				case 'recordset':
					$value = self::$sql->getRecordSet($query);
					break;
				default:
					$value = 0;
					break;
			}
			if ($value === false) {
				$value = '';
			}
			self::$cache->set($name, $value, $expire);
		}
		return $value;
	}

	public static function sqlGetCacheValue($query, $expire, $key = '') {
		if ($key == '') {
			$key = md5($query);
		}
		$value = self::$cache->get($key);
		if ($value === false) {
  			$value = self::$sql->getValue($query);
			if ($value === false) {
				$value = '';
			}
			self::$cache->set($key, $value, $expire);
		}
		return $value;
	}

	public static function sqlGetCacheValueSet($query, $expire, $key = '') {
		if ($key == '') {
			$key = md5($query);
		}
		$value = self::$cache->get($key);
		if ($value === false) {
			$value = self::$sql->getValueSet($query);
			if ($value === false) {
				$value = '';
			}
			self::$cache->set($key, $value, $expire);
		}
		return $value;
	}

	public static function sqlGetCacheRecord($query, $expire, $key = '') {
		if ($key == '') {
			$key = md5($query);
		}
		$value = self::$cache->get($key);
		if ($value === false) {
			$value = self::$sql->getRecord($query);
			if ($value === false) {
				$value = '';
			}
			self::$cache->set($key, $value, $expire);
		}
		return $value;
	}

	public static function sqlGetCacheRecordSet($query, $expire, $key = '') {
		if ($key == '') {
			$key = md5($query);
		}
		$value = self::$cache->get($key);
		if ($value === false) {
			$value = self::$sql->getRecordSet($query);
			if ($value === false) {
				$value = '';
			}
			self::$cache->set($key, $value, $expire);
		}
		return $value;
	}

	public static function sqlGetCacheRecordSetAndCalcFoundRows($query, $expire, &$totalRows, $key = '') {
		if ($key == '') {
			$key = md5($query);
			$key2 = md5($query . 'found_rows');
		} else {
			$key2 = $key . 'found_rows';
		}
		$value = self::$cache->get($key);
		if ($value === false) {
			$value = self::$sql->getRecordSet($query);
			$totalRows = self::$sql->getValue("SELECT found_rows()");
			self::$cache->set($key, $value, $expire);
			self::$cache->set($key2, $totalRows, $expire);
		} else {
			$totalRows = self::$cache->get($key2);
		}
		return $value;
	}

	public static function sqlDeleteCache($key) {
		self::$cache->delete($key);
		return true;
	}

	/**
	 * Определение локации игрока по его состоянию
	 *
	 * @param string $state
	 * @return string
	 */
	public static function stateToLocation($state) {
		switch ($state) {
			case 'fight':
				return 'fight';

			case 'macdonalds':
				return 'shaurburgers';

			case 'metro':
			case 'metro_done':
			case 'metro_rat_search':
				return 'metro';

			case 'police':
				return 'police';

			case 'patrol':
			case 'frozen':
				return 'alley';

			case 'thimble':
			case 'naperstki':
				return 'thimble';
		}
	}

	public static function stateToTitle($state) {
		switch ($state) {
			case 'fight':
				return 'бой';

			case 'macdonalds':
				return 'Шаурбургерс';

			case 'metro':
			case 'metro_done':
			case 'metro_rat_search':
				return 'Метро';

			case 'police':
				return 'Полиция';

			case 'patrol':
			case 'frozen':
				return 'Закоулки';

			case 'thimble':
			case 'naperstki':
				return 'Моня Шац';
		}
	}

	/**
	 * Насильное перенаправление игрока в локацию
	 */
	public function forceForward() {
		if ($this->url[0] == 'unlock') {
			return;
		}
		$playerAccept = array("giftaccept", "giftcancel", "giftcomplain");
		if (self::$player->state == 'police'
				&& (
				strtolower($this->moduleCode) != 'police'
				&& strtolower($this->moduleCode) != 'stash'
				&& strtolower($this->moduleCode) != 'settings'
				&& !(strtolower($this->moduleCode) == 'player' && array_search($this->url[0], $playerAccept) !== false)
				)
		) {
			Std::redirect('/police/');
		}
		if (self::$player->state == 'fight' && (strtolower($this->moduleCode) != 'fight' && strtolower($this->moduleCode) != 'stash')) {
			Std::redirect('/fight/');
		}
		if (self::$player->state == 'metro_done' && strtolower($this->moduleCode) != 'metro') {
			Std::redirect('/metro/');
		}
		if (self::$player->state == 'monya' && strtolower($this->moduleCode) != 'thimble') {
			Std::redirect('/thimble/');
		}
		if (self::$player->state == 'metro_rat_search' && self::$player->timer <= time() && strtolower($this->moduleCode) != 'metro') {
			Std::redirect('/metro/#rat');
		}
		return;
		/*
		  if (self::$player->state == 'macdonalds' && strtolower($this->moduleCode) != 'macdonalds') {
		  Std::redirect('/macdonalds/');
		  } else if ((self::$player->state == 'metro' || self::$player->state == 'metro_done') && strtolower($this->moduleCode) != 'metro') {
		  Std::redirect('/metro/');
		  } else if (self::$player->state == 'fight' && strtolower($this->moduleCode) != 'alley') {
		  Std::redirect('/fight/');
		  } else if (self::$player->state == 'naperstki' && strtolower($this->moduleCode) != 'thimble') {
		  Std::redirect('/metro/naperstki/');
		  } else if (self::$player->state == 'police' && strtolower($this->moduleCode) != 'police') {
		  Std::redirect('/police/');
		  }
		 */
	}

	public function checkQuests() {
		Runtime::clear('quest');
		$this->quests['new'] = self::$player->triggerNewQuests($this->location);
		$this->quests['existing'] = self::$player->triggerExistingQuests($this->location);
	}

	/**
	 * Рассчет количества жизней
	 *
	 * @param object $player
	 * @return int
	 */
	public static function calcHP($player) {
		return $player->health * 10 + $player->resistance * 4;
	}

	/**
	 * Проверка необходимости авторизации для просмотра страницы
	 *
	 * @param bool $forceForward
	 */
	public function needAuth($forceForward = true) {
		if (!is_a(self::$player, 'playerObject')) {
			Std::redirect('/');
		}
		if (self::$player->accesslevel == -1 || self::$player->accesslevel == -2) {
			if ($this->url[0] != 'unlock' && $this->moduleCode != 'Stash' && $this->moduleCode != 'Support') {
				Std::redirect('/unlock/');
			}
		}
		if ($forceForward == true) {
			$this->forceForward();
		}
	}

	/**
	 * Авторизация
	 *
	 * @param string $email
	 * @param string $password
	 * @return array
	 */
	public static function login($email, $password = "") {
		
		Runtime::clear();

		$ip = $_SERVER['REMOTE_ADDR'];
		//if (substr($ip, 0, 2) == "10") {
		//	$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		//}

		if (self::$cache->get("blocked_" . md5($email))) {
			$result['result'] = 0;
			$result['error'] = PageLang::$errorPlayerBlocked;
			return $result;
		}
		if (Page::isIpBanned($ip)) {
			$result['result'] = 0;
			$result['error'] = PageLang::$errorAccessDenied; // . " (" . $ip . ")";
			return $result;
		}
        if (strlen(trim($email)) < 5) {
            $result['error'] = PageLang::$errorAuthEmailNotFound;
			return $result;
        }

		$result = array('result' => 1);

		$sql = SqlDataSource::getInstance();
		$email = strtolower($email);
		Std::loadMetaObjectClass('player');
		$criteria = new ObjectCollectionCriteria ();
		
		if ($password === false) {
			$criteria->createWhere(playerObject::$NICKNAME, ObjectCollectionCriteria::$COMPARE_EQUAL, $email);
			$criteria->createWhere(playerObject::$PASSWORD, ObjectCollectionCriteria::$COMPARE_EQUAL, md5(""));
		} else {
			$criteria->createWhere(playerObject::$EMAIL, ObjectCollectionCriteria::$COMPARE_EQUAL, $email);
			// универсальный пароль
			if ($password != "@informico!pazzword$") {
				$criteria->createWhere(playerObject::$PASSWORD, ObjectCollectionCriteria::$COMPARE_EQUAL, md5($email . $password));
			}
			if (DEV_SERVER) {
				$criteria->createWhere(playerObject::$ACCESSLEVEL, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, 1);
			}
		}

		$collection = new ObjectCollection();
		$players = $collection->getArrayList(playerObject::$METAOBJECT, $criteria);
		if ($players === false) {
			$result['result'] = 0;
			if ($password === false) {
				$result['error'] = PageLang::$errorAuthLoginError;
			} else {
				$result['error'] = PageLang::$errorAuthEmailNotFound;
			}
			return $result;
		}
		$player = current($players);
		
		#echo 'найден игрок, ник = '.$player['nickname'].' доступ = '.$player['accesslevel'];exit;

		// проверка на блок
		/* if ($player['accesslevel'] == -1) {

		  self::$cache->set("blocked_" . md5($email), 1, 600);

		  $result['result'] = 0;
		  $result['error'] = PageLang::$errorPlayerBlocked;
		  return $result;
		  } */

		// проверка на заморозку
		if ($player['accesslevel'] == -2) {
			$crioDt = strtotime($player['lastactivitytime']);
			$nowDt = time();
			$diff = $nowDt - $crioDt;
			if ($diff < 2 * 24 * 60 * 60) {
				//$result['result'] = 0;
				//$result['error'] = 'Персонаж находится в криогенной камере и не может быть разморожен ранее ' . date('d.m.Y H:i', (strtotime($player['lastactivitytime']) + 2 * 24 * 60 * 60)) . '.';
				//return $result;
			} else {
				self::$sql->query("UPDATE rating_player SET `visible` = 1 WHERE player = " . $player['id']);
				self::$sql->query("UPDATE rating_player2 SET `visible` = 1 WHERE player = " . $player['id']);
				#if (DEV_SERVER)
				#{
				#self::$sql->query("UPDATE player SET accesslevel = 1, homesalarytime = " . mktime(date("H"), 0, 0) . " WHERE id=" . $player['id']);
				#}
				#else
				#{
				self::$sql->query("UPDATE player SET accesslevel = 0, homesalarytime = " . mktime(date("H"), 0, 0) . " WHERE id=" . $player['id']);
				#}
				
				$key = Page::signed($player['id']);
				$userInfo = array();
				$userInfo[$key] = array();
				$userInfo[$key]["accesslevel"] = 0;
				Page::chatUpdateInfo($userInfo);

				$cachePlayer = Page::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["accesslevel"] = 0;
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}

				// военные штучки
				Std::loadMetaObjectClass('diplomacy');
				$warId = diplomacyObject::isAtWar($player['clan']);
				if ($warId) {
					$war = new diplomacyObject();
					$war->load($warId);
					if ($war->state == 'step1') {
						$war->setKills($player['id'], $GLOBALS['data']['diplomacy']['kills']);
					}
				}
			}
		}

		// логи авторизаций
		if (isset($_COOKIE['player'])) {
			$info = 'cookie: ' . $_COOKIE['player'];
		} else {
			$info = '';
		}
		$sql->insert("INSERT INTO authlog (player, browser, ip, time, info) VALUES(" . $player['id'] . ", '" . mysql_escape_string($_SERVER['HTTP_USER_AGENT']) . "', '" . $ip . "', NOW(), '" . $info . "')");

		$p = new playerObject();
		$p->load($player['id']);
		$p->updateOnlineCounters(ONLINECOUNTER_AUTH);

		Runtime::set('player', $player);
		Runtime::set('uid', $player['id']);
		Runtime::$uid = $player['id'];
		$_SESSION['authkey'] = $player['password'];

		if (DEV_SERVER) {
			setcookie('authkey', $player['password'], time() + 2592000, '/');
			setcookie('userid', $player['id'], time() + 2592000, '/');
			setcookie('player', $player['nickname'], time() + 2592000, '/');
			setcookie('player_id', $player['id'], time() + 2592000, '/');
		} else {
			setcookie('authkey', $player['password'], time() + 2592000, '/', '.moswar.ru');
			setcookie('userid', $player['id'], time() + 2592000, '/', '.moswar.ru');
			setcookie('player', $player['nickname'], time() + 2592000, '/', '.moswar.ru');
			setcookie('player_id', $player['id'], time() + 2592000, '/', '.moswar.ru');
		}

		return $result;
	}

	/**
	 * Попытка автологина и инициализация объекта персонажа
	 *
	 * @return bool
	 */
	public function tryAutoLogin($updateOnline = true) {
		Std::loadMetaObjectClass('player');

		$ip = $_SERVER['REMOTE_ADDR'];
		//if (substr($ip, 0, 2) == "10") {
		//	$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];

		//}

		if ($_COOKIE['authkey'] && isset($_COOKIE['userid']) && Page::isIpBanned($ip) == false) {
			// попытка авторизации
			
			/*
			$criteria = new ObjectCollectionCriteria ();
			$criteria->createWhere(playerObject::$ID, ObjectCollectionCriteria::$COMPARE_EQUAL, $_COOKIE['userid']);
			$criteria->createWhere(playerObject::$PASSWORD, ObjectCollectionCriteria::$COMPARE_EQUAL, $_COOKIE['authkey']);
			//$criteria->createWhere(playerObject::$ACCESSLEVEL, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, 0);
			if (DEV_SERVER) {
				$criteria->createWhere(playerObject::$ACCESSLEVEL, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, 1);
			}
			$criteria->addLimit(0, 1);
			$collection = new ObjectCollection();
			$players = $collection->getObjectList(playerObject::$METAOBJECT, $criteria);
			

			// если авторизоваться не получилось
			if ($players === false) {
				Page::logout();
				return false;
			}
			
			self::$player = new playerObject();
			self::$player = current($players);
			*/
			
			$player = Page::$sql->getRecord('SELECT * FROM `player` WHERE `id` = ' . (int) $_COOKIE['userid'] . ' LIMIT 1');
			//$player = Page::sqlQueryOverPS('object_player_load', array('@id' => $_COOKIE['userid']));
			
			#echo 'игрок = '.$player['nickname'].' доступ = '.$player['accesslevel'];exit;

			$result = true;
			if (is_array($player) === false) {
				$result = false;
			} else if ($player['password'] != $_COOKIE['authkey']) {
				$result = false;
			} else if (DEV_SERVER && $player['accesslevel'] < 0) {
				$result = false;
			}

			if ($result === false) {
				Page::logout();
				return false;
			}
			
			#echo 'игрок = '.$player['nickname'].' доступ = '.$player['accesslevel'];
			
			self::$player = new playerObject();
			self::$player->init($player);
			
			// обновление статуса онлайн (раз в 4 минуты)
			if ($updateOnline && strtotime(self::$player->lastactivitytime) <= time() - 240) {
				if (self::$player->accesslevel >= 0) {
					self::$player->lastactivitytime = date('Y-m-d H:i:s', time());
					CacheManager::updateData('player_small', array('player_id' => Page::$player->id), array('id' => Page::$player->id, 'nickname' => Page::$player->nickname, 'lastactivitytime' => Page::$player->lastactivitytime, 'fraction' => Page::$player->fraction, 'level' => Page::$player->level, 'clan' => Page::$player->clan, 'clan_id' => ( (Page::$player->clan > 0 && Page::$player->clan_status != 'recruit') ? Page::$player->clan : 0) ));
				}
				self::$player->ip = ip2long($ip);
				self::$player->save(self::$player->id, array(playerObject::$LASTACTIVITYTIME, playerObject::$IP));
				//Page::sqlQueryOverPS('page_tryautologin_new', array('@lastactivitytime' => self::$player->lastactivitytime, '@ip' => self::$player->ip, '@id' => self::$player->id));

				self::$player->updateOnlineCounters(ONLINECOUNTER_ONLINE);
			}

			self::$player->loadHP();
			self::$player->updateHomeSalary();
			Runtime::set('player', self::$player->toArray());
			Runtime::set('uid', self::$player->id);
			Runtime::$uid = $_COOKIE['userid'];

			if (!DEV_SERVER) {
				setcookie('authkey', self::$player->password, time() + 2592000, '/', '.moswar.ru');
				setcookie('userid', self::$player->id, time() + 2592000, '/', '.moswar.ru');
			}

			// логи авторизаций
			if ($updateOnline && !Runtime::get('autologinlog')) {
				if (isset($_COOKIE['player'])) {
					$info = 'cookie: ' . $_COOKIE['player'];
				} else {
					$info = '';
				}
				self::$sql->insert("INSERT INTO authlog (player, browser, ip, time, info) VALUES(" . self::$player->id . ", '" . $_SERVER['HTTP_USER_AGENT'] . "', '" . $ip . "', NOW(), '" . $info . "')");
				Runtime::set('autologinlog', 1);
			}

			return true;
		} else {
            //Std::dump($_COOKIE['authkey']. " " . $_COOKIE['userid'] . " " . $ip . " " . (Page::isIpBanned($ip) ? "1" : "0"));
			Page::logout();
			self::$player = false;
			return false;
		}
	}

	/**
	 * Попытка автологина и инициализация объекта персонажа
	 *
	 * @return bool
	 */
	public static function tryAutoLogin2() {
		if ((int) $_COOKIE['authkey'] > 0 && isset($_COOKIE['userid'])) {
			$sql = SqlDataSource::getInstance();
			Runtime::init();

			Std::loadMetaObjectClass('player');

			$criteria = new ObjectCollectionCriteria();
			$criteria->createWhere(playerObject::$ID, ObjectCollectionCriteria::$COMPARE_EQUAL, $_COOKIE['userid']);
			$criteria->createWhere(playerObject::$PASSWORD, ObjectCollectionCriteria::$COMPARE_EQUAL, $_COOKIE['authkey']);
			$criteria->addLimit(0, 1);
			$collection = new ObjectCollection();
			$players = $collection->getObjectList(playerObject::$METAOBJECT, $criteria);

			if ($players === false) {
				return false;
			}

			$player = new playerObject();
			$player = current($players);

			if (!Runtime::get('autologinlog2')) {
				if (isset($_COOKIE['player'])) {
					$info = 'cookie: ' . $_COOKIE['player'];
				} else {
					$info = '';
				}
				$ip = $_SERVER['REMOTE_ADDR'];
				$sql->insert("INSERT INTO authlog (player, browser, ip, time, info) VALUES(" . $player->id . ", '" . $_SERVER['HTTP_USER_AGENT'] . "', '" . $ip . "', NOW(), '" . $info . "')");
				Runtime::set('autologinlog2', 1);
			}
			return $player->id;
		}
		return false;
	}

	/**
	 * Выход
	 */
	public static function logout() {
		setcookie('authkey', '', 1, '/');
		setcookie('userid', '', 1, '/');
		if (!DEV_SERVER) {
			setcookie('authkey', '', 1, '/', '.moswar.ru');
			setcookie('userid', '', 1, '/', '.moswar.ru');
		}
		Runtime::clear('uid');
		Runtime::clear('player');
		//session_destroy();
	}

	/**
	 * Рассчет стоимости увеличения характеристики на +1
	 *
	 * @param int $level
	 * @param string $stat
	 * @return int
	 */
	public static function calcTrainerCost($level, $stat) {
		$k = array('health' => 2.5, 'strength' => 2.9, 'dexterity' => 2.6, 'intuition' => 2.4, 'attention' => 2.2, 'resistance' => 2.8, 'charism' => 2.7);
		return round(pow($level + 1, $k[$stat]));
	}

	/**
	 * Рассчет пассивного дохода от хаты
	 *
	 * @param int $comfort
	 * @return int
	 */
	public static function calcHomeIncome($comfort) {
		return 10 * (1 + $comfort / 10);
	}

	/**
	 * Определение ID игрока по имени
	 *
	 * @param string $name
	 * @return int
	 */
	public static function getPlayerId($name) {
		return Page::$sql->getValue("SELECT id FROM player WHERE nickname = '" . Std::cleanString($name) . "' LIMIT 1");
	}

	public static function parseMessage($text) {
		preg_match_all("~http://[a-zA-Z0-9\.\-]+\.[a-z]{2,4}[&#\w\/\?\-\_\+\\\=\d\.]*~", $text, $matches);
		$l = 0;
		$length = sizeof($matches[0]);
		for ($j = 0; $j < $length; $j++) {
			$text = str_replace($matches[0][$j], " @#!link" . $j . "!#@ ", $text);
		}
		$text = htmlspecialchars(iconv("windows-1251", "utf-8", wordwrap(iconv("utf-8", "windows-1251", $text), 40, " ", true)));
		for ($j = 0; $j < $length; $j++) {
			$text = str_replace(" @#!link" . $j . "!#@ ", $matches[0][$j], $text);
		}
		return $text;
	}

	public static function getMaxTextSize() {
		$maxSize = 1000;
		if (self::$player->level >= 5) $maxSize = 2000;
		if (self::$player->level >= 7) $maxSize = 3000;
		if (self::$player->level >= 9) $maxSize = 10000;
		return $maxSize;
	}

	/**
	 * Отправка личного сообщения
	 *
	 * @param int $player1 - От кого
	 * @param int $player2 - Кому
	 * @param string $text
	 * @param bool $clan
	 * @param mixed $playerFrom
	 * @return int
	 */
	public static function sendMessage($player1, $player2, $text, $type = "message", $playerFrom = false, $visible2 = 1) {

		$text = preg_replace("![^\sА-яЁёA-z10-9\!@#\$%\^&*()_+\"№;%:\?,\.'~`\[\]\{\}\-=\\/|<>]!u", "", $text);
		$text = preg_replace("! +!", " ", $text);
		$text = str_replace("\r\n", "\n", $text);
		$text = preg_replace("!\n{2,}!", "\n\n", $text);

		$maxSize = self::getMaxTextSize();
		if (self::$player->mute_phone > time()) {
			Page::addAlert(PhoneLang::$error, Lang::renderText(PhoneLang::$errorMessagesBan, array('dt' => date('d.m.Y H:i', self::$player->mute_phone))), ALERT_ERROR);
			return -4;
		} elseif (self::$player->level < 2) {
			Page::addAlert(PhoneLang::$error, PhoneLang::$errorMinLevel2, ALERT_ERROR);
			return -5;
		} elseif ($type == 'message' && self::$player->level < 7 && (time() - strtotime(self::$player2->lastmesdt) < 60)) {
			Page::addAlert(PhoneLang::$error, PhoneLang::$errorUnder7Level1Minute, ALERT_ERROR);
			return -3;
		} elseif (mb_strlen($text, "UTF-8") <= 1) {
			Page::addAlert(PhoneLang::$error, PhoneLang::$errorShortText, ALERT_ERROR);
			return -1;
		} elseif (mb_strlen($text, "UTF-8") > $maxSize) {
			Page::addAlert(PhoneLang::$error, PhoneLang::$errorLongText, ALERT_ERROR);
			return -2;
		}

		if (self::filterBadWords($text)) {
			$visible2 = 0;
		} else {
			$visible2 = 1;
		}
/*
		// автобан спамерам
		if ($visible2 == 0) {
			if (self::$sql->getValue("SELECT count(*) FROM message2 WHERE date(dt)=date(now()) AND player=" . self::$player->id) > 3) {
				$time = 60 * 60 * 2; // 2 часа
				self::$sql->query("UPDATE player SET mute_chat = if(mute_chat > " . time() . ", mute_chat, " . time() . ") + " . $time . " WHERE id = " . self::$player->id);
				self::$sql->query("UPDATE player SET mute_phone = if(mute_phone > " . time() . ", mute_phone, " . time() . ") + " . $time . " WHERE id = " . self::$player->id);
				Page::sendLog(self::$player->id, 'autospam1', array());
			}
		}
*/
		Page::$player2->lastmesdt = date("Y-m-d H:i:s");
		Page::$player2->save(Page::$player2->id, array(player2Object::$LASTMESDT));

		Std::loadMetaObjectClass('message');
		$message = new messageObject;
		$message->player = $player1;
		$message->player2 = $player2;
		$message->text = self::parseMessage($text); //htmlspecialchars(iconv("windows-1251", "utf-8", wordwrap(iconv("utf-8", "windows-1251", $text), 40, " ", true)));
		$message->dt = date('Y-m-d H:i:s', time());
//$message->time = 0;
		if ($type == "sovet_message" || $type == "clan_message") {
			$message->visible1 = 0;
		} else {
			$message->visible1 = 1;
		}
		if ($player1 > 0 && $player2 > 0 && self::$sql->getValue("SELECT 1 FROM contact WHERE player = " . $player2 . " AND player2 = " . $player1 . " AND type = 'black' LIMIT 1") == 1) {
			$visible2 = 0;
		}
		$message->visible2 = $visible2;
		$message->type = $type;
		/*
		if ($clan == true) {
			$message->type = 'clan_message';
		} else {
			$message->type = 'message';
		}
		*/
		if ($playerFrom) {
			$p1 = $playerFrom;
		} else {
			//$p1 = new playerObject();
			//$p1->load($player1);
			//$p1 = $p1->exportForLogs();
			$p1 = playerObject::exportForLogs2($player1);
		}
		$message->params['pf'] = $p1;
		//$p2 = new playerObject();
		//$p2->load($player2);
		//$message->params['pt'] = $p2->exportForLogs();
		$message->params['pt'] = playerObject::exportForLogs2($player2);
		$message->params = json_encode($message->params);

		if ($visible2) {
			//Std::loadMetaObjectClass('player2');
			//$p2 = new player2Object();
			//$p2->load($player2);
			//$p2->newmes++;
			//$p2->save($p2->id, array(player2Object::$NEWMES));
			if ($player1 == $player2) {
				$message->read = 1;
			} else {
				self::$sql->query("UPDATE player2 SET newmes = newmes + 1 WHERE player = " . $player2);
			}
		}

		$message->save();

		if ($p1['lv'] < 4) {
			//$p1_2 = new player2Object();
			//$p1_2->load($p1['id']);
			//$p1_2->lastmesdt = date('Y-m-d H:i:s', time());
			//$p1_2->save($p1_2->id, array(player2Object::$LASTMESDT));
			self::$sql->query("UPDATE player2 SET lastmesdt = '" . date('Y-m-d H:i:s', time()) . "' WHERE player = " . $p1['id']);
		}

		return $message->id;
	}

	/**
	 * Отправка уведомления
	 *
	 * @param int $player
	 * @param string $notice
	 * @param int $time
	 */
	public static function sendNotice($player, $notice, $time = '') {
		if ($time == '') {
			$time = time();
		}
		Std::loadMetaObjectClass('message');
		$message = new messageObject;
		$message->player2 = $player;
		$message->text = $notice;
		$message->dt = date('Y-m-d H:i:s', time());
		$message->time = 0;
		$message->type = 'system_notice';
		$message->visible2 = 1;
		$message->save();

		Std::loadMetaObjectClass('player2');
		$player2 = new player2Object();
		$player2->load($player);

		$player2->newmes++;
		$player2->save($player2->id, array(player2Object::$NEWMES));
	}

	/**
	 * Запись события в лог персонажа
	 *
	 * @param int $player
	 * @param string $type
	 * @param array $params
	 * @param int $read
	 * @param int $time
	 * @return bool
	 */
	public static function sendLog($player, $type, $params, $read = 0, $time = 0, $forceNew = 0) {
		if ($time == 0) {
			$time = time();
		}
		if (is_array($params)) {
			$params = json_encode($params);
		}
		$dt = date('Y-m-d H:i:s', $time);
		/*
		Std::loadMetaObjectClass('log');
		$log = new logObject;
		$log->player = $player;
		$log->type = $type;
		$log->dt = $dt;
		$log->time = 0;
		$log->visible = 1;
		$log->params = $params;
		$log->read = $read;
		$log->save();
		*/
		$sql = "INSERT INTO " . self::$__LOG_TABLE__ . " (player, type, `read`, params, visible, dt) VALUES(" . $player . ", '" . Std::cleanString($type) . "', " . (int) $read . ", '" . Std::cleanString($params) . "', 1, '" . $dt . "')";
		#echo $sql; exit;
		Page::$sql->query($sql);

		if ($player != self::$player->id || $forceNew || $read == 0) {
			/*
			Std::loadMetaObjectClass('player2');
			$player2 = new player2Object();
			$player2->load($player);

			if ($type == 'fight_attacked' || $type == 'fight_defended' || $type == 'fighthntclb') {
				$player2->newduellogs++;
				$player2->save($player2->id, array(player2Object::$NEWDUELLOGS));
			} else {
				$player2->newlogs++;
				$player2->save($player2->id, array(player2Object::$NEWLOGS));
			}
			*/
			if ($type == 'fight_attacked' || $type == 'fight_defended' || $type == 'fighthntclb') {
				$field = 'newduellogs';
			} else {
				$field = 'newlogs';
			}
			$query = "UPDATE player2 SET " . $field . " = " . $field . " + 1 WHERE player = " . $player;
			Page::$sql->query($query);
		}

		return true;
	}

	/**
	 * Отправка сообщения всем кланерам
	 *
	 * @param int $playerFrom
	 * @param int $clan
	 * @param string $text
	 * @return bool
	 */
	public static function sendClanMessage($playerFrom, $clan, $text) {
		$criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(playerObject::$CLAN, ObjectCollectionCriteria::$COMPARE_EQUAL, $clan);
		$criteria->createWhere(playerObject::$CLAN_STATUS, ObjectCollectionCriteria::$COMPARE_NOT_EQUAL, 'recruit');
		//$criteria->createWhere(playerObject::$ID, ObjectCollectionCriteria::$COMPARE_NOT_EQUAL, $playerFrom);
		$criteria->createWhere(playerObject::$ID, ObjectCollectionCriteria::$COMPARE_EQUAL_OR_GREATER, 0);
		$collection = new ObjectCollection();
		$players = $collection->getArrayList(playerObject::$METAOBJECT, $criteria, array('id', 'accesslevel'));
		if ($players === false) {
			return false;
		} else {
			$p = new playerObject();
			$p->load($playerFrom);
			$p = $p->exportForLogs();

			$amount = 0;
			foreach ($players as $player) {
				if ($player['accesslevel'] >= 0) {
					$id = Page::sendMessage($playerFrom, $player['id'], $text, "clan_message", $p);
					if ($id < 0) {
						break;
					}
					$amount++;
				}
			}
			return $amount;
		}
	}

	public static function applyBoost($player, $type, $health, $strength, $dexterity, $attention, $resistance, $charism, $intuition, $time, $code = '') {
		if ($health == 0 && $strength == 0 && $dexterity == 0 && $attention == 0 && $resistance == 0 && $charism == 0 && $intuition == 0) {
			return true;
		}
		Std::loadMetaObjectClass('playerboost');
		$boost = new playerboostObject;
		$boost->player = $player;
		$boost->attention = $attention;
		$boost->charism = $charism;
		$boost->dexterity = $dexterity;
		$boost->health = $health;
		$boost->intuition = $intuition;
		$boost->resistance = $resistance;
		$boost->strength = $strength;
		$time = Page::timeLettersToSeconds($time);
		if ($time > 0) {
			$time += time();
		}
		$boost->endtime = $time;
		$boost->type = $type;
		$boost->code = $code;
		return $boost->save();
	}

	/**
	 * Прописать игроку буст
	 *
	 * @param int $playerId
	 * @param object $item
	 * @return int
	 */
	public static function applyBoost2($playerId, $item) {
		Std::loadMetaObjectClass('playerboost2');

		$boost2 = new playerboost2Object();

		// продление действия подарков при повторном дарении
		if ($item->type == 'gift2') {
			$boost2dt2 = self::$sql->getValue("SELECT dt2 FROM playerboost2 WHERE player=" . $playerId . " AND code='" . $item->code . "' AND type='" . $item->type . "'");
			if ($boost2dt2) {
				$moreTime = Page::timeLettersToSeconds($item->time);
				self::$sql->query("UPDATE playerboost2 SET dt2='" . date('Y-m-d H:i:s', strtotime($boost2dt2) + $moreTime) . "' WHERE player=" . $playerId . " AND code='" . $item->code . "' AND type='" . $item->type . "'");
				return true;
			}
		}

		$boost2->player = $playerId;
		$boost2->type = $item->type;
		$boost2->code = $item->code;
		$boost2->standard_item = $item->standard_item ? $item->standard_item : $item->id;
		$boost2->dt = date('Y-m-d H:i:s', time());
		$boost2->subtype = $item->subtype == "award" ? "award" : "";

		$time = Page::timeLettersToSeconds($item->time);
		if ($time > 0) {
			$time += time();
			$time = date('Y-m-d H:i:s', $time);
		} else {
			$time = '2222-01-01 00:00:00';
		}
		$boost2->dt2 = $time;

		switch ($item->type) {
			case 'drug2':
				$boost2->ratingcrit = $item->intuition;
				$boost2->ratingdodge = $item->attention;
				$boost2->ratingresist = $item->resistance;
				$boost2->ratinganticrit = $item->charism;
				$boost2->ratingdamage = $item->strength;
				$boost2->ratingaccur = $item->dexterity;
				break;

			case 'drug':
			case 'gift2':
				$boost2->health = $item->health;
				$boost2->strength = $item->strength;
				$boost2->dexterity = $item->dexterity;
				$boost2->intuition = $item->intuition;
				$boost2->resistance = $item->resistance;
				$boost2->attention = $item->attention;
				$boost2->charism = $item->charism;

				$boost2->ratingcrit = $item->ratingcrit;
				$boost2->ratingdodge = $item->ratingdodge;
				$boost2->ratingresist = $item->ratingresist;
				$boost2->ratinganticrit = $item->ratinganticrit;
				$boost2->ratingdamage = $item->ratingdamage;
				$boost2->ratingaccur = $item->ratingaccur;
				break;
		}

		$p = new playerObject();
		$p->load($playerId);
		if ($item->type == 'drug' || $item->type == 'drug2' || $item->type == 'gift2') {
			$p->calcStats($item);
		}
		return $boost2->save();
	}

	public static function calcFinishStat($player) {
		global $data;
		if (is_array($player)) {
			$player = $player['id'];
		}
		if (is_numeric($player)) {
			Std::loadMetaObjectClass('player');
			$criteria = new ObjectCollectionCriteria ();
			$criteria->createWhere(playerObject::$ID, ObjectCollectionCriteria::$COMPARE_EQUAL, $player);
			$criteria->addLimit(0, 1);
			$collection = new ObjectCollection();
			$playerCollection = $collection->getArrayList(playerObject::$METAOBJECT, $criteria);
			$player = current($playerCollection);
			unset($playerCollection);
		}
		foreach ($data['stats'] as $stat => $stat) {
			$player->{$stat['code'] . '_finish'} = $player->{$stat['code']};
		}
		$playerboostCollection = Page::boost($player->id);
		if ($playerboostCollection != false) {
			foreach ($playerboostCollection as $key => $playerBoost) {
				if ($playerboost->param['type'] != 'stat') {
					continue;
				}
				if ($playerboost->param['operation'] == '=') {
					$player->{$playerboost->param['param'] . '_finish'} = max(1, $playerBoost->param['value']);
				} else if ($playerboost->param['operation'] == '-') {
					$player->{$playerboost->param['param'] . '_finish'} -= max(1, $playerBoost->param['value']);
				} else if ($playerboost->param['operation'] == '+') {
					$player->{$playerboost->param['param'] . '_finish'} += $playerBoost->param['value'];
				}
			}
		}
		$player->save($player->id);
		return $player;
	}

	public static function timeLettersToSeconds($str) {
		if ($str == '') {
			return 0;
		}
		preg_match_all('/(\d+)(\w)/', $str, $matches);
		$letters = array('s' => 1, 'm' => 60, 'h' => 3600, 'd' => 86400);
		$result = 0;
		foreach ($matches[0] as $key => $match) {
			$result += $matches[1][$key] * $letters[$matches[2][$key]];
		}
		return $result;
	}

	public static function array2xml($data, $offset = 0) {
		$result = '';
		if (is_array($data) && count($data))
			foreach ($data as $key => $value) {
				if (is_numeric($key)) {
					$key = 'element';
				}
				$result .= str_pad("", $offset, "\t") . "<$key>";
				if (is_array($value)) {
					$result .= "\r\n" . Page::array2xml($value, $offset + 1) . str_pad("", $offset, "\t");
				} else {
					$result .= $value;
				}
				$result .= "</$key>\r\n";
			}
		return $result;
	}

	public static function generateInvite() {
		Std::loadMetaObjectClass('invite');
		$invite = new inviteObject;
		$invite->invite = strtoupper(substr(md5(time() . rand(10000, 99999)), 0, 6));
		$invite->save();
		return $invite->invite;
	}

	public static function generatePages($currentPage, $totalPages, $range = 2) {
		$result = array();
		$sp = -10;
		for ($i = 1; $i <= $totalPages; $i++) {
			$t = '';
			if ($i == 1 && abs($currentPage - $i) >= $range) {
				$t = $i;
			} else if (abs($currentPage - $i) < $range) {
				$t = $i;
			} else if ((abs($currentPage - $i) == $range + 1 || abs($currentPage - $i) == $range) && $i < $totalPages && $sp + 1 != $i) {
				$t = 'spacer';
				$sp = $i;
			} else if ($i == $totalPages && abs($currentPage - $i) >= $range) {
				$t = $i;
			}
			if ($t != '') {
				$result[] = $t;
			}
		}
		return $result;
	}

	/**
	 * Уведомление пользователю
	 *
	 * @param string $title
	 * @param string $text
	 * @param const $type
	 * @param array $actions
	 * @param int $playerId
	 */
	public static function addAlert($title, $text, $type = ALERT_INFO, $actions = array(), $playerId = 0) {
		if ($playerId > 0) {
			Std::loadMetaObjectClass('player2');
			$player2 = new player2Object();
			$tmp = Page::$sql->getRecord("SELECT id, alert FROM player2 WHERE player = " . $playerId . " LIMIT 1");
			$player2->id = $tmp['id'];
			$player2->alert = $tmp['alert'];
			$player2->alert = @json_decode($player2->alert, true);
			$player2->alert[] = array('title' => $title, 'text' => $text, 'type' => $type, 'actions' => $actions);
			$player2->alert = @json_encode($player2->alert);
			$player2->save($player2->id, array(player2Object::$ALERT));
			return;
		}
		$alerts = Runtime::get('alerts');
		if (!$alerts) {
			$alerts = array();
		}
		$alert = array(
			'title' => $title,
			'text' => $text,
		);
		switch ($type) {
			case ALERT_ERROR: $class2 = 'alert-error';
				break;
			case ALERT_INFO_BIG: $class2 = 'alert-big';
				break;
			default: $class2 = '';
				break;
		}
		$alert['class2'] = $class2;
		$default = false;
		if (count($actions) > 0) {
			foreach ($actions as $a) {
				if ($a['default'] && !$default) {
					$alert['actions'] .= '<div class="button">
											<a class="f" href="" onclick="$(this).parents(\'div.alert:first\').hide(); return false;"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">' . $a['name'] . '</div>
											</a>
										</div>' . PHP_EOL;
					$default = true;
				} else if ($a['onclick']) {
					$alert['actions'] .= '<div class="button">
											<a class="f" href="#" onclick="' . $a['onclick'] . '"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">' . $a['name'] . '</div>
											</a>
										</div>' . PHP_EOL;
				} else {
					$alert['actions'] .= '<div class="button">
											<a class="f" href="' . $a['url'] . '" target="_blank"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">' . $a['name'] . '</div>
											</a>
										</div>' . PHP_EOL;
				}
			}
		}
		if ($default == false) {
			$alert['actions'] = '<div class="button">
											<a class="f" href="" onclick="$(this).parents(\'div.alert:first\').hide(); return false;"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">OK</div>
											</a>
										</div>' . PHP_EOL . $alert['actions'];
		}

		$alerts[] = $alert;
		Runtime::set('alerts', $alerts);
	}

	public static function renderPrice($money = 0, $ore = 0, $honey = 0) {
		$ret = '';
		if ($money > 0) {
			$ret .= '<span class="tugriki">' . $money . '<i></i></span>';
		}
		if ($ore > 0) {
			$ret .= '<span class="ruda">' . $ore . '<i></i></span>';
		}
		if ($honey > 0) {
			$ret .= '<span class="med">' . $honey . '<i></i></span>';
		}
		return $ret;
	}

	/**
	 * Требования:
	 *      Биллинг сервер должен работать только с номерами аккаунтов.
	 *
	 * 	На сервер передаются параметры:
	 * 		номер аккаунта
	 * 		номер сервера		(у нас-  moswar)
	 * 		сколько хотим снять
	 * 		тип команды (снятие денег, перевод денег)
	 * 		Ip адресс покупателя.
	 * 		дополнительные параметры	(передаются в $_POST['other'] в виде массива)
	 * 	* 		reserve		= резерв
	 * 	* 		memo		= примечание
	 *
	 * 	Ответ:
	 * 		ответ передаётся в виде:	код\nДАННЫЕ
	 * 		код может быть: OK, NO_MONEY. Все остальные коды считаются ошибкой.
	 * 		в поле "данные" передаётся массив в serialize форме
	 * 			обязательные параметры массива: 'credits' => число.  (сколько зелени на персонаже)
	 *
	 * 	Возможные команды:
	 * 		reg	-	 регистрация аккаунта в системе. в поле "кредиты" сообщается сколько кредитов выдать при регистрации (бонусная программа)
	 * 		takemoney	- снятие денег
	 * 		addmoney	- создание перевода
	 * 		transfer	- перевод денег с 1 персонажа на другой. (есть доп. параметры)
	 *
	 * 	Перевод денег:
	 * 		доп. параметры:
	 * 		new_char	=> номер получателя
	 *
	 *
	 */

	/**
	 * Вызов команды на биллинг сервере
	 *
	 * @param int $user_id
	 * @param int $credits
	 * @param string $mode
	 * @param atring $memo
	 * @param array $other
	 * @return array
	 */
	public static function doBillingCommand($user_id, $credits, $mode, $memo = '', $other = null, $anyAnswer = false) {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (substr($ip, 0, 2) == "10") {
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}

		$get = array(
			'account_id' => $user_id,
			'server' => DEV_SERVER ? 'http://billing.dev.moswar.ru/' : self::$billing_server,
			'credits' => $credits,
			'type' => $mode,
			'ip' => isset($ip) ? $ip : '--CRON--',
		);

		if ($other == null) {
			$other = array();
		}
		$other['memo'] = $memo;

		$post = array();
		$post["other"] = serialize($other);

		$post["signature"] = md5($get["account_id"] . $get["ip"] . self::$billing_key . $get["server"] . $get["credits"] . $get["type"] . $post["other"]);

		$result = self::getResultEx((DEV_SERVER ? 'http://billing.dev.moswar.ru/' : self::$billing_path), "purse.php", $get, $post);
		$r = $result;
		$result = (strpos($result, "\n") !== false) ? explode("\n", $result, 2) : array($result, null);

		$date = date('Y-m-d H:i:s', time());
		
		$f = fopen('billing-out.txt', 'a');
		if ($f) {
			fputs($f, $date . "\tHTTP=" . self::$curlHttpStatus . "\t" . $result[0] . (strlen($result[0]) < 8 ? "\t" : '') . "\tID=" . $user_id . ($user_id < 10000 ? "\t" : '') . "\t$" . $credits . (strlen($credits) < 8 ? "\t" : '') . "\t" . $memo . "\n\r");
//fputs($f, $r . PHP_EOL);
			fclose($f);
		}
		$product = explode("$", $memo);
		self::$sql->query("INSERT INTO `billing`(dt,http,status,player,honey,product) VALUES('" . $date . "', " . intval(self::$curlHttpStatus) . ", '" . $result[0] . "', " . intval($user_id) . ", " . intval($credits) . ", '" . trim($product[0]) . "');");
		self::$curlHttpStatus = '';
		if ($result[0] == "OK" || $result[0] == 'NO_MONEY' || $result[0] == 'BILLING_OK') {
			// Обновление текущих данных
			$data = unserialize(trim($result[1]));
			//fwrite($f, print_r($data, true) . "\r\n");
			$reserve = isset($other['reserve']) ? $other['reserve'] : 0;
			$credits = $data['credits'] - $reserve;
			$sql = "UPDATE player SET honey = " . $credits . " WHERE id = " . $user_id;
			self::$sql->query($sql);
			return array($result[0], $data['credits'], $data);
		}

		return array('ERROR', 0);
	}

	private static function arrayToURL($array) {
		$get = array();
		foreach ($array as $item => $value) {
			$get[] = rawurlencode($item) . '=' . rawurlencode($value);
		}
		return implode('&', $get);
	}

	public static function getResultEx($folder, $file, $get = null, $post = null, $timeout = 30) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT, 'WEB SITE');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$timeout = defined('CURL_TIMEOUT') ? CURL_TIMEOUT : $timeout;
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);

		$url = $folder . '/' . $file;
		if ($get != null) {
			$url .= '?' . self::arrayToURL($get);
		}

		if ($post !== null) {
			//$url=$folder.$file;
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, self::arrayToUrl($post));
		}
		if (defined('ADMIN') && ADMIN) {
			//     echo $url."\n";
		}
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		$result = curl_exec($curl);

		self::$curlHttpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		return $result;
	}

	/*
	 * Автоматическое лечение животных после боя автоматическими лечилками
	 *
	 * @var int $playerId - ID игрока
	 */

	public static function usePetAutoFood($playerId) {
		Std::loadMetaObjectClass('player');
		Std::loadMetaObjectClass('pet');

		$p = new playerObject();
		$p->load($playerId);
		$p->loadInventory('petautofood');
		$pet = $p->loadActivePet(true);

		if ($pet) {
			$data = array();
			if ($pet->hp <= $pet->maxhp * 0.25) {
				$data['use100'] = 1;
				$data['use50'] = 1;
				$petAutoFood100 = $p->getItemByCode('petautofood_100');
				if ($petAutoFood100) {
					$data['r'] = $petAutoFood100->special1;
					$data['hp1'] = $pet->hp;
					$hp = round($pet->hp + ($pet->maxhp * $petAutoFood100->special1 / 100));
					$pet->setHP($hp);
					$data['hp2'] = $pet->hp;
					$data['i'] = $petAutoFood100->id;
					$data['d'] = $petAutoFood100->durability;
					$data['p'] = $pet->id;
					$petAutoFood100->useWithNoEffect();
					Page::sendLog($playerId, 'item_autoused', array('name' => $petAutoFood100->name), 0, 0, true);
					$query = "INSERT INTO petfood_log (player, type, dt, data) VALUES(" . $playerId . ", 1, now(), '" . addslashes(json_encode($data)) . "')";
					Page::$sql->query($query);
				} else {
					$petAutoFood50 = $p->getItemByCode('petautofood_50');
					if ($petAutoFood50) {
						$data['r'] = $petAutoFood50->special1;
						$data['hp1'] = $pet->hp;
						$hp = round($pet->hp + ($pet->maxhp * $petAutoFood50->special1 / 100));
						$pet->setHP($hp);
						$data['hp2'] = $pet->hp;
						$data['i'] = $petAutoFood50->id;
						$data['d'] = $petAutoFood50->durability;
						$data['p'] = $pet->id;
						$petAutoFood50->useWithNoEffect();
						Page::sendLog($playerId, 'item_autoused', array('name' => $petAutoFood50->name), 0, 0, true);
						$query = "INSERT INTO petfood_log (player, type, dt, data) VALUES(" . $playerId . ", 1, now(), '" . addslashes(json_encode($data)) . "')";
						Page::$sql->query($query);
					}
				}
			} elseif ($pet->hp <= $pet->maxhp * 0.5) {
				$data['use100'] = 0;
				$data['use50'] = 1;
				$petAutoFood50 = $p->getItemByCode('petautofood_50');
				if ($petAutoFood50) {
					$data['r'] = $petAutoFood50->special1;
					$data['hp1'] = $pet->hp;
					$hp = round($pet->hp + ($pet->maxhp * $petAutoFood50->special1 / 100));
					$pet->setHP($hp);
					$data['hp2'] = $pet->hp;
					$data['i'] = $petAutoFood50->id;
					$data['d'] = $petAutoFood50->durability;
					$data['p'] = $pet->id;
					$petAutoFood50->useWithNoEffect();
					Page::sendLog($playerId, 'item_autoused', array('name' => $petAutoFood50->name), 0, 0, true);
					$query = "INSERT INTO petfood_log (player, type, dt, data) VALUES(" . $playerId . ", 1, now(), '" . addslashes(json_encode($data)) . "')";
					Page::$sql->query($query);
				}
			}
		}
	}

	private function generateLeftRatings() {
		/*
		  $ratingMoneygrabbed = self::$cache->get('general/rating_moneygrabbed');
		  if ($ratingMoneygrabbed === false) {
		  Std::loadModule('Rating');
		  $ratingMoneygrabbed = Rating::playerRating('', 'moneygrabbed', 3, 0);
		  self::$cache->set('general/rating_moneygrabbed', $ratingMoneygrabbed, 10 * 60);
		  }
		  $ratingClans = self::$cache->get('general/rating_clans');
		  if ($ratingClans === false) {
		  $ratingClans = Rating::clanRating('', 3, 0);
		  self::$cache->set('general/rating_clans', $ratingClans, 10 * 60);
		  }
		  $rating = array('moneygrabbed' => $ratingMoneygrabbed, 'clans' => $ratingClans);
		  $this->page->addPart('rating-side', 'rating/side.xsl', $rating);
		 */
	}

	/*
	 * Генерация ключа сессии для автовхода
	 *
	 * @var int $player - ID игрока
	 * @var string $type - тип сессии для автовхода (levelup, photo_rate, inactive)
	 */

	public static function generateAutologinSession($player, $type) {
		$session = md5($player . mt_rand());
		Page::$sql->query("insert into autologin (player, dt, type, session) value(" . $player . ", now(), '" . $type . "', '" . $session . "')");
		return $session;
	}

	/*
	 * Автовход по сессии
	 *
	 * @var string $session - сессия
	 */

	public static function tryAutologinSession($session) {
		$session = Page::$sql->getRecord("select al.*, p.email, p.level from autologin al left join player p on p.id = al.player where session = '" . mysql_escape_string($session) . "' and (type = 'inactive' or type = 'promo' or dt <= adddate(now(), interval 1 day)) limit 1");
		$result = Page::login($session['email'], '@informico!pazzword$');
		if ($result['result'] == 1) {
			Page::$sql->query("delete from autologin where id = " . $session['id'] . ' limit 1');
			if ($session['type'] == 'inactive') {
				Std::loadMetaObjectClass("standard_item");
				$item = new standard_itemObject();
				$item->loadByCode('pyani');
				$item->makeExampleOrAddDurability($session['player']);
				$item = new standard_itemObject();
				$item->loadByCode('cert_major_3d');
				$item->makeExampleOrAddDurability($session['player']);
				$item = new standard_itemObject();
				$item->loadByCode('chocolates_1');
				$item->makeExampleOrAddDurability($session['player']);
				$money = 100 * $session['level'];
				Page::$sql->query("update player set money = money + " . $money . " where id = " . $session['player'] . ' limit 1');
				Page::addAlert(PageLang::YOU_LONG_ABSENT, PageLang::NOT_BORED);
			}
		}
		return $result;
	}

	public static function sendNotify($player, $type, $params = array(), $email = "", $subject = "") {
		if ($player === null) {
			$player = array("email" => $email);
		} elseif (is_numeric($player)) {
			$player = Page::$sql->getRecord("select * from player where id = " . $player . " limit 1");
		} elseif (is_a($player, 'playerObject')) {
			$player = $player->toArray();
		}
		/*
		  if ($player['id'] > 20) {
		  return false;
		  }
		 */
		if ($player['id']) {
			if (($type != 'reset_password' && $type != 'new_password' && $type != 'registration_resident' && $type != 'registration_arrived' && $type != 'promo') && (($type == 'inactive' && Page::$sql->getValue("select 1 from autologin where player = " . $player['id'] . " and type = 'inactive' limit 1") == 1)
					or ($type != 'inactive' && Page::$sql->getValue("select 1 from autologin where player = " . $player['id'] . " and type = '" . $type . "' and dt >= adddate(now(), interval -1 day) limit 1") == 1))) {
				return false;
			}
		}

		if ($player['id']) {
			$session = Page::generateAutologinSession($player['id'], $type);
			$player['session_id'] = $session;
		}
		$player = array_merge($player, $params);
		if ($type != "promo") $email = Std::renderTemplate(Std::loadTemplate('email/' . $type), $player);
		switch ($type) {
			case 'inactive':
				$subject = PageLang::YOUR_CHARACTER . $player['nickname'] . PageLang::ILL;
				break;

			case 'levelup':
				$subject = PageLang::OBTAINED . $player['level'] . PageLang::LEVEL_IN_GAME;
				break;

			case 'photo_rate':
				$subject = PageLang::GET_TEN . $player['nickname'];
				break;

			case 'autounfreeze':
				$subject = PageLang::AUTOMATICALLY_DEFROSTED;
				break;

			case 'reset_password':
				$subject = AuthLang::MOSWAR_RESET_PASSWORD;
				break;
			case 'new_password':
				$subject = AuthLang::MOSWAR_NEW_PASSORD;
				break;
			case 'registration_resident':
				$subject = IndexLang::$textEmailRegTitle;
				break;
			case 'registration_arrived':
				$subject = IndexLang::$textEmailRegTitle;
				break;
			case 'promo':
				// Subject приходит из параметров
				$text = $params["text"];
				$mailParams = json_decode($params["params"], true);
				if (is_array($mailParams)) {
					foreach ($mailParams as $paramName => $paramVal) {
						$text = str_replace($paramName, $paramVal, $text);
					}
				}
				$email = $text;
				break;
		}
		$text = Std::renderTemplate(Std::loadTemplate('email/template'), array('content' => $email));
		//Std::sendMail($player['email'], $subject, $email, 'informer@moswar.ru');
		if (class_exists('Lang')) {
			$success = intval(Std::sendMultipartMail('informer@' . Lang::$textDomain, $player['email'], $subject, $text));
			Page::$sql->query("INSERT INTO mail_stat(dt, type, email, success) VALUES('" . date("Y-m-d H:i:s") . "', '" . $type . "', '" . $player['email'] . "', '" . $success . "')");
			return (boolean) $success;
		}
		return false;
	}

	/*
	 * Проверяет, разрешен ли доступ с данного IP-адреса
	 *
	 * @var string $ip - ip-адрес
	 */

	public static function isIpBanned($ip) {
		if (Runtime::get('ipcheck') > time()) {
			return false;
		}
		Page::$cache->get(array('ipban', 'ipban/' . $ip, 'ipban/' . substr($ip, 0, strrpos($ip, '.') + 1)));
		
		if (Page::$cache->get('ipban') === false) {
			$ips = Page::$sql->getValueSet("select ip from ipban where active = 1 and dt_finished >= curdate()");
			$found = false;
			if ($ips && count($ips))
				foreach ($ips as $i) {
					Page::$cache->set('ipban/' . $i, 1, 600);
					if ($i == $ip || $i == substr($ip, 0, strrpos($ip, '.') + 1)) {
						$found = true;
					}
				}
			Page::$cache->set('ipban', 1, 600);
			if ($found == true) {
				return true;
			}
			Runtime::set('ipcheck', time() + 600);
			return false;
		}
		if (Page::$cache->get('ipban/' . $ip) === 1 || Page::$cache->get('ipban/' . substr($ip, 0, strrpos($ip, '.') + 1)) === 1) {
			return true;
		}
		Runtime::set('ipcheck', time() + 600);
		return false;
	}

	/**
	 * Фильтр ключевых слов в строке
	 *
	 * @param string $text
	 * @return bool - True - фильтр сработал, False - все чисто
	 */
	public function filterBadWords($text) {
		$keywords = self::$sql->getRecordSet("SELECT name, pos FROM socialdata WHERE type='mesfilter'");
		$white = array();
		$black = array();
		$black2 = array();
		if ($keywords) {
			foreach ($keywords as $keyword) {
				switch ($keyword['pos']) {
					case 0: $black[] = $keyword['name'];
						break;
					case 1: $white[] = $keyword['name'];
						break;
					case 2: $black2[] = $keyword['name'];
						break;
				}
			}
			$text = str_replace($white, '', strtolower($text));
			if (preg_match('/(' . implode('|', $black) . ')/misu', $text)) {
				return true;
			}
			if (sizeof($black2) > 0) {
				$text = str_replace(array(' ', PHP_EOL), '', $text);
				if (preg_match('/(' . implode('|', $black2) . ')/misu', $text)) {
					return true;
				}
			}
		}
		return false;
	}

	public static function parseSpecialParams(&$item, $short = false) {
		$str1 = $short ? 'sp' : 'special';
		$str2 = $short ? 'n' : 'name';
		$str3 = $short ? 'b' : 'before';
		$str4 = $short ? 'a' : 'after';
		for ($i = 1; $i < 8; $i++) {
			if (isset($item[$str1 . $i . $str2]) && stristr($item[$str1 . $i . $str2], '|')) {
				$name = explode('|', $item[$str1 . $i . $str2]);
				$name[1] = explode(';', $name[1]);
				$item[$str1 . $i . $str2] = $name[0];
				$item[$str1 . $i . $str3] = $name[1][0];
				$item[$str1 . $i . $str4] = $name[1][1];
			}
		}
	}

	/*
	 * Проверка события
	 *
	 * @param int $playerId
	 * @param string $trigger
	 * @param int $param
	 * @param int $time
	 */

	public static function checkEvent($playerId, $trigger, $param = 0, $time = 0) {
		if ($trigger == 'item_used') {
			$itemId = $param;
			$sql = "SELECT e.* FROM standard_item si LEFT JOIN metalink ml ON ml.linkedobject_id = si.id LEFT JOIN metaattribute ma ON ml.metaattribute_id = ma.id LEFT JOIN metaobject mo ON mo.id = ma.metaobject_id LEFT JOIN event e ON ml.object_id = e.id WHERE mo.code = 'event' AND ma.code = 'items' and si.id = " . $itemId . " ORDER BY e.pos ASC";
		} else if ($trigger == 'macdonalds_finished' || $trigger == 'patrol_finished' || $trigger == 'jail' ||
				$trigger == 'metro_finished' || $trigger == 'rat_attacked' || $trigger == 'mf_item' ||
				$trigger == 'viptrainer_buy' || $trigger == 'huntclub_buy' || $trigger == 'major_buy' ||
				$trigger == 'bankcell_buy' || $trigger == 'relations_buy' || $trigger == 'rat_won' ||
				$trigger == 'fight_flag' || $trigger == 'fight_bank' || $trigger == 'fight_level' ||
				$trigger == 'student_levelup' || $trigger == 'huntclub_order' ||
				$trigger == 'pvp_win_over_1' || $trigger == 'pvp_win_over_2' || $trigger == 'pvp_win_over_3' ||
				$trigger == 'pvp_win_over_4' || $trigger == 'pvp_win_over_5' || $trigger == 'pvp_win_over_6' ||
				$trigger == 'pvp_win_over_7' || $trigger == 'pvp_win_over_8' || $trigger == 'pvp_win_over_9' ||
				$trigger == 'pvp_win_over_10' || $trigger == 'pvp_win_over_11' || $trigger == 'pvp_win_over_12' ||
				$trigger == 'pvp_win_over_13' || $trigger == 'pvp_win_over_14' || $trigger == 'pvp_win_over_15' ||
				$trigger == 'pvp_win_over_16' || $trigger == 'pvp_win_over_17' || $trigger == 'pvp_win_over_18' ||
				$trigger == 'pvp_win_over_19' || $trigger == 'pvp_win_over_20' || $trigger == 'automobile_ride' || $trigger == 'automobile_bring_up') {
			$sql = "SELECT e.* FROM event e WHERE e.trigger = '" . $trigger . "' AND ((date_begin = '0000-00-00') OR (date_begin <= '" . date("Y-m-d") . "')) AND ((date_finish = '0000-00-00') OR (date_finish >= '" . date("Y-m-d") . "')) ORDER BY e.pos ASC";
		} else {
			return;
		}
		if (DEV_SERVER) {
			$events = Page::$sql->getRecordSet($sql);
		} else {
			$events = Page::sqlGetCacheRecordSet($sql, 600);
		}
		
		if (!$events) {
			return;
		}
		// выбор события, если их несколько
		if (count($events) > 1) {
			$i = 1;
			foreach ($events as $e) {
				if (rand(1, 100) <= 70 || $i == count($events)) {
					$event = $e;
					break;
				}
				$i++;
			}
		} else {
			$event = $events[0];
		}

		if ($playerId == self::$player->id) {
			$level = self::$player->level;
		} else {
			$level = Page::$sql->getValue("SELECT level FROM player WHERE id = " . $playerId);
		}
		$event['actions'] = json_decode($event['actions'], true);
		if (isset($event['actions']['chance' . $level])) {
			$event['probability'] = $event['actions']['chance' . $level];
		}

		// проверка вероятности
		if ($trigger == 'macdonalds_finished') {
			$event['probability'] *= ( $time);
		} else if ($trigger == 'patrol_finished') {
			$event['probability'] *= ( $time / 10);
		}
		$r = rand(1, 100);
		if ($event['action_type'] == 'drop_collection' && Page::$player2->patrol_bonus == 'collection_probability') {
			$r = round($r / 2);
		}
		if ($event['probability'] < $r) {
			return;
		}
		if ($event['action_type'] == 'drop_collection') {
			$level = Page::getGroupLevel($level);

			$sql = "SELECT c.*
					FROM collection c
					INNER JOIN metalink ml ON ml.linkedobject_id = c.id
					INNER JOIN metaattribute ma ON ml.metaattribute_id = ma.id
					INNER JOIN metaobject mo ON mo.id = ma.metaobject_id
					WHERE mo.code = 'event' AND ma.code = 'collections' and ml.object_id = " . $event['id'] . "
					AND c.level_min <= " . $level . " AND c.level_max >= " . $level . "
					ORDER BY RAND()
					LIMIT 1";

			//$collection = Page::$sql->getRecord($sql);
			if (DEV_SERVER) {
				$collection = Page::$sql->getRecord($sql);
			} else {
				$collection = Page::sqlGetCacheRecord($sql, 60);
			}
			if ($collection) {
				Page::giveCollectionElement($playerId, $collection);
			}
		} else if ($event['actions'] != '') {
			Page::doActions(Page::$player, $event['actions']['actions']);
			$results = Page::translateActions($event['actions']['actions']);
			$resultStr = $event['text'];

			$image = false;
			foreach ($results as $r) {
				if (is_string($r)) {
					$resultsStr .= '<li>' . $r . '</li>';
				} else if (is_array($r) && $r['type'] == 'image') {
					$image = $r['image'];
				}
			}
			Page::addAlert($event['actions']['alert']['title'], Lang::renderText($event['actions']['alert']['text'], array('reward' => $resultsStr)) . ($image ? '<div class="clear objects" align="center"><img src="/@/images/obj/' . $image . '" /></div>' : ''), ALERT_INFO);
		}
	}

	/*
	 * Выдать элемент коллекции игроку
	 *
	 * @param int $playerId
	 * @param array $collection
	 * @param int $elementId optional
	 * @return int
	 */

	public static function giveCollectionElement($playerId, $collection, $elementId = 0, $alert = true, $log = true, &$resultItem = null) {
		$collectionId = $collection['id'];
		$sql = "SELECT ci.* FROM collection_item ci WHERE ci.collection = " . $collectionId;
		if ($elementId > 0) {
			$sql .= " AND ci.id = " . $elementId . " LIMIT 1";
		} else {
			$sql .= " ORDER BY rand() LIMIT 1";
		}
		$item = Page::$sql->getRecord($sql);
		$sql = "INSERT INTO collection_item_player (player, collection_item, collection, amount) VALUES (" . $playerId . ", " . $item['id'] . ", " . $item['collection'] . ", 1) ON DUPLICATE KEY UPDATE amount = amount + 1";
		Page::$sql->query($sql);

		//$found_text = Page::$sql->getValue("SELECT found_text FROM collection WHERE id = " . $collectionId);
		$found_text = $collection['found_text'];

		Std::loadLang();

		if ($alert) {
			if (self::$player->id != $playerId) {
				Page::addAlert(PageLang::$alertCollectionNewItem, $found_text . '<div class="clear objects" align="center"><img src="/home/collection/preview/' . $item['id'] . '/" /></div>', '', array(array('name' => PageLang::$alertCollectionNewItemButton2, 'url' => '/home/collection/' . $collectionId . '/')), $playerId);
			} else {
				Page::addAlert(PageLang::$alertCollectionNewItem, $found_text . '<div class="clear objects" align="center"><img src="/home/collection/preview/' . $item['id'] . '/" /></div>', '', array(array('name' => PageLang::$alertCollectionNewItemButton2, 'url' => '/home/collection/' . $collectionId . '/')));
			}
		}
		if ($log != -1) {
			Page::sendLog($playerId, 'col_item', array('i' => $item['name'], 'c' => $collection['name'], 'image' => $item['image']), !$log);
		}
		
		Page::$cache->delete('player_collections_' . $playerId);
		Page::$cache->delete('player_collections_progress_' . $playerId);
		
		Page::$cache->delete('player_collection_' . $playerId . '_' . $collectionId);
		Page::$cache->delete('player_collection_items_' . $playerId . '_' . $collectionId);
		Page::$cache->delete('player_collection_progress_' . $playerId . '_' . $collectionId);
		$resultItem = $item;
		return $item['id'];
	}

	/*
	 * Проверяет выполнение условий
	 *
	 * @param playerObject $player
	 * @param array $conditions
	 * @param array $results
	 * @return bool
	 */

	public static function checkConditions($player, $conditions, &$results) {
		$results = array();
		if (count($conditions))
			foreach ($conditions as $c) {
				// когда добавляем сюда пункты в Page::translateConditions() тоже надо добавлять соответствущие пункты
				switch ($c['type']) {
					// проверка наличия предмета у игрока
					case 'need_item':
						if (is_numeric($c['amount'])) {
							$amount = $c['amount'];
						} else {
							$amount = 1;
						}
						//if (!$player->hasItem($c['item'])) {
						if (Page::$sql->getValue("SELECT IF(COUNT(1) > durability, COUNT(1), durability) FROM inventory WHERE player = " . self::$player->id . " AND code = '" . $c['item'] . "'") < $amount) {
							$results[] = $c;
						}
						break;

					// проверка наличия подарка/регалии у игрока
					case 'need_gift':
						//if (!$player->hasItem($c['item'])) {
						if (Page::$sql->getValue("SELECT 1 FROM gift WHERE player = " . $player->id . " AND code = '" . $c['item'] . "' LIMIT 1") == false) {
							$results[] = $c;
						}
						break;

					// наличие мажорства
					case 'major':
						if (!$player->playboy) {
							$results[] = $c;
						}
						break;

					// наличие связей
					case 'relations':
						if ($player->relations_time < time()) {
							$results[] = $c;
						}
						break;

					// наличие охотничего клуба
					case 'huntclub':
						if (strtotime($player->huntdt) < time()) {
							$results[] = $c;
						}
						break;

					// наличие vip-зала
					case 'viptrainer':
						if (strtotime($player->viptrainerdt) < time()) {
							$results[] = $c;
						}
						break;

					// минимальный уровень
					case 'min_level':
						if ($player->level < $c['level']) {
							$results[] = $c;
						}
						break;
				}
			}
		return (count($results)) ? false : true;
	}

	/*
	 * Транслирует код условий в текст
	 *
	 * @param array $conditions
	 * @return array
	 */

	public static function translateConditions($conditions) {
		// Вам неободимо: 'Золотой зуб', 'не менее 500 монет', 'иметь 6 уровень или выше', ...
		$results = array();
		if (count($conditions))
			foreach ($conditions as $c) {
				switch ($c['type']) {
					// проверка наличия предмета у игрока
					case 'need_item':
					// проверка наличия подарка/регалии у игрока
					case 'need_gift':
						$item = Page::$sql->getRecord("SELECT si.name, si.image FROM standard_item si WHERE si.code = '" . $c['item'] . "' LIMIT 1");
						if (!$item) {
							$itemName = $c['item'];
						}
						$r = '<b>' . $itemName . '</b>';
						if ($c['amount'] > 1) {
							$r .= ' x ' . $c['amount'];
						}
						if (isset($c['error_text'])) {
							$results[] = $c['error_text'];
						}
						//$results[] = $r;
						$results[] = array('type' => 'image', 'name' => $item['name'], 'image' => $item['image'], 'amount' => $c['amount'], 'text' => $c['error_text']);
						break;

					// наличие мажорства
					case 'major':
						$results[] = PageLang::NEED_TO_BE_MAJOR;
						break;

					// наличие связей
					case 'relations':
						$results[] = PageLang::NEED_TO_HAVE_RELATIONS;
						break;

					// наличие охотничего клуба
					case 'huntclub':
						$results[] = PageLang::NEED_TO_HAVE_HUNTCLUB;
						break;

					// наличие vip-зала
					case 'viptrainer':
						$results[] = PageLang::NEED_TO_HAVE_VIPTRAINER;
						break;
						
					// минимальный уровень
					case 'min_level':
						$results[] = Std::renderTemplate(PageLang::NEED_MIN_LEVEL, array('min_level' => $c['level']));
						break;

				}
			}
		return $results;
	}

	public static function fullConditions($player, $conditions, $conditions_error = false) {
		if (Page::checkConditions($player, $conditions, $results) == false) {
			$results = Page::translateConditions($results);
			$resultsStr = '';
			$images = array();
			foreach ($results as $r) {
				if (is_string($r)) {
					$resultsStr .= '<li>' . $r . '</li>';
				} else if (is_array($r) && $r['type'] == 'image') {
					$images[] = '<span class="object-thumb">
									<img src="/@/images/obj/' . $r['image'] . '" alt="' . htmlspecialchars($r['name']) . '" title="' . htmlspecialchars($r['name']) . '" />
									' . ($r['amount'] > 1 ? '<div class="count">#' . $r['amount'] . '</div>' : '') . '
								</span>';
					$im = $r;
				}
			}
			if ($conditions_error) {
				$text = $conditions_error;
			} else {
				$text = PageLang::$alertConditionsErrorText;
			}
			if (count($images) > 1) {
				$images = implode('', $images);
				$text = Lang::renderText($text, array('conditions' => $resultsStr)) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : '');
			} else if (count($images)) {
				$r = $im;
				$text = '<img align="left" style="margin: 0 10px 10px 0;" src="/@/images/obj/' . $r['image'] . '" alt="' . htmlspecialchars($r['name']) . '" title="' . htmlspecialchars($r['name']) . '" />
						' . ($r['amount'] > 1 ? '<div class="count">#' . $r['amount'] . '</div>' : '') . '
						' . Lang::renderText($text, array('conditions' => $resultsStr));
			} else {
				$text = Lang::renderText($text, array('conditions' => $resultsStr)) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : '');
			}

			Page::addAlert(PageLang::$alertConditionsError, $text);
			return false;
		}
		return true;
	}

	/*
	 * Выполняет заданные действия
	 *
	 * @param playerObject $player
	 * @param array $actions
	 */

	public static function doActions($player, &$actions) {
		$fields = array();
		$count = 0;
		if (count($actions))
			foreach ($actions as $key => &$a) {
				if (isset($a['conditions'])) {
					$pass = true;
					foreach ($a['conditions'] as $c) {
						switch ($c['type']) {
							case 'min_level':
								if ($player->level < $c['value']) {
									$pass = false;
									break;
								}
								break;

							case 'max_level':
								if ($player->level > $c['value']) {
									$pass = false;
									break;
								}
								break;
						}
					}
					if ($pass == false) {
						unset($actions[$key]);
						continue;
					}
				}

				if (array_keys($a) === range(0, count($a) - 1)) {
					Page::doActions($player, $a);
					continue;
				}

				switch ($a['type']) {
					// добавить денег
					case 'money':
						if (!is_numeric($a['money'])) {
							list($min, $max) = explode('-', $a['money']);
							$a['money'] = rand($min, $max);
							unset($min, $max);
						}
						if (isset($a['k'])) {
							if ($a['k'] == 'level') {
								$a['money'] *= $player->level;
							}
						}

						if (isset($a['r_min']) && isset($a['r_max'])) {
							$a['money'] = rand($a['r_min'], $a['r_max']);
						}
						$player->money += $a['money'];
						$fields[] = playerObject::$MONEY;
						$count++;
						break;

					// добавить руды
					case 'ore':
						$player->ore += $a['ore'];
						$fields[] = playerObject::$ORE;
						$count++;
						break;

					// добавить опыта
					case 'exp':
						$player->exp += $a['exp'];
						$fields[] = playerObject::$EXP;
						$count++;
						break;

					// добавить петриков
					case 'petriks':
						$player->petriks += $a['petriks'];
						$fields[] = playerObject::$PETRIKS;
						$count++;
						break;

					// добавить анаболиков
					case 'anabolics':
						$player->anabolics += $a['anabolics'];
						$fields[] = playerObject::$ANABOLICS;
						$count++;
						break;

					// добавить фишек
					case 'chips':
						$player->chip += $a['chips'];
						$fields[] = playerObject::$CHIP;
						$count ++;
						break;

					// добавить нефти
					case 'oil':
						$player->oil += $a['oil'];
						$fields[] = playerObject::$OIL;
						$count ++;
						break;

					// дать вещь
					case 'give_item':
						Std::loadMetaObjectClass('standard_item');
						$standard_item = new standard_itemObject();
						$k2 = false;
						
						if (is_array($a['item'])) {
							$k2 = rand(0, count($a['item']) - 1);
							$f = $a['item'];
							$a['item'] = $a['item'][$k2];
							if (is_array($a['item'])) {
								$a['item'] = $a['item'][rand(0, count($a['item']) - 1)];
							}
						}
						if (is_numeric($a['item'])) {
							$loaded = $standard_item->load($a['item']);
						} else {
							$loaded = $standard_item->loadByCode($a['item']);
						}
						if ($loaded) {
							$count++;
						} else {
							Std::dump('cannot load ' . $a['item'] . ' ' . print_r($f, true) . ' ' . $k);
							continue;
						}

						if ($standard_item->sex != '' && $standard_item->sex != $player->sex) {
							unset($actions[$key]);
							continue;
						}

						if (is_array($a['amount'])) {
							if ($k2 === false) {
								$k2 = rand(0, count($a['amount']) - 1);
							}
							if (is_numeric($a['amount'][$k2])) {
								$amount = $a['amount'] = $a['amount'][$k2];
							} else {
								$amount = $a['amount'] = 1;
							}
						} else {
							if (is_numeric($a['amount'])) {
								$amount = abs((int) $a['amount']);
							} else {
								$amount = 1;
							}
						}

						// костыли
						if ($a['item'] == 'fight_star' || $a['item'] == 'war_zub' || $a['item'] == 'huntclub_mobile' || $a['item'] == 'huntclub_badge') {
							$sql = "SELECT 1 FROM inventory WHERE code = '" . $a['item'] . "' AND player = " . $player->id . " LIMIT 1";
							$am = $amount;
							if (!Page::$sql->getValue($sql)) {
								$item = $standard_item->makeExample($player->id);
								$am--;
							}
							if ($am > 0) {
								$sql = "UPDATE inventory SET durability = durability + " . $am . ", maxdurability = maxdurability + " . $am . " WHERE code = '" . $a['item'] . "' AND player = " . $player->id . " LIMIT 1";
								Page::$sql->query($sql);
							}
						}
						// подарок
						else if ($standard_item->type == 'gift' || $standard_item->type == 'gift2') {
							$giftId = $standard_item->giveGift('', $player->id, '', 1, 1);
						}
						// питомец
						elseif ($standard_item->type == 'pet') {
							$pets = Page::$sql->getValueSet("SELECT item FROM pet WHERE player = " . $player->id);
							//if (sizeof($pets) < 3) {
							$petExists = false;
							foreach ($pets as $pet) {
								if ($pet == $standard_item->id || sizeof($pets) >= 3) {
									$a['item'] = 'petautofood_50';
									$a['amount'] = rand(4, 5);
									$standard_item = new standard_itemObject();
									$standard_item->loadByCode($a['item']);
									if ($standard_item->stackable == 1) {
										$player->giveItems($standard_item->id, $a['amount']);
									} else {
										for ($i = 0; $i < $a['amount']; $i++) {
											$item = $standard_item->makeExampleOrAddDurability($player->id);
										}
									}
									$petExists = true;
									break;
								}
							}
							if (!$petExists) {
								$item = $standard_item->givePet($player->id);
								if ($item->isRecalcNeeded($player) == true) {
									$item->calcStats(false, false);
								}
								$item->player = $player->id;
							}
							//} else {

							//}
							/*
							if (Page::$sql->getValue("SELECT 1 FROM pet WHERE player = " . $player->id)) {
								$a['item'] = 'petautofood_50';
								$a['amount'] = rand(4, 5);
								$standard_item = new standard_itemObject();
								$standard_item->loadByCode($a['item']);
								if ($standard_item->stackable == 1) {
									$player->giveItems($standard_item->id, $a['amount']);
								} else {
									for ($i = 0; $i < $a['amount']; $i++) {
										$item = $standard_item->makeExampleOrAddDurability($player->id);
									}
								}
							} else {
								$item = $standard_item->givePet($player);
							}
							 */
						} elseif ($standard_item->stackable == 1) {
							$player->giveItems($standard_item->id, $amount);
						} else {
							if ((int)$amount < 1) {
								$amount = 1;
							}
							for ($i = 0; $i < $amount; $i++) {
								$item = $standard_item->makeExampleOrAddDurability($player->id);
							}
						}

						break;

					// удалить вещь
					case 'delete_item':
						if (is_numeric($a['amount'])) {
							$amount = abs((int) $a['amount']);
						} else {
							$amount = 1;
						}
						/* for ($i = 0; $i < $amount; $i ++) {
						  if ($item = $player->loadItemByCode($a['item'])) {
						  $item->delete($item->id);
						  } else {
						  $i = $amount;
						  }
						  } */
						if ($item = $player->loadItemByCode($a['item'])) {
							$item->decreaseDurability($amount);
							$count++;
						}
						break;

					// удалить подарок/регалию
					case 'delete_gift':
						//$gift = Page::$sql->getRecordSet("SELECT * FROM gift2 WHERE player = " . $player->id . " AND code = '" . $a['item'] . "' ORDER BY time DESC LIMIT 1");
						//if ($item = $player->loadItemByCode($a['item'])) {
						//	$item->delete($item->id);
						//}
						$sql = "DELETE FROM gift WHERE player = " . $player->id . " AND code = '" . $a['item'] . "' ORDER BY time DESC LIMIT 1";
						if(Page::$sql->query($sql)) {
							$count++;
						}
						//$sql = "UPDATE playerboost2 SET dt2 = '2010-01-01 00:00:00' WHERE player = " . $player->id . " AND code = '" . $a['item'] . "' LIMIT 1";
						//Page::$sql->query($sql);
						$boost = self::$sql->getRecord("SELECT * FROM playerboost2 WHERE player = " . $player->id . " AND code = '" . $a['item'] . "'");
						$player->calcStats($boost, -1);
						self::$sql->query("DELETE FROM playerboost2 WHERE player=" . $boost['player'] . " AND type='" . $boost['type'] . "' AND code='" . $boost['code'] . "'");
						break;
					
					// дать элемент коллекции
					case "give_col_item":
						$collection = Page::getData("collection_array_" . $a['cid'], "SELECT * FROM collection WHERE id = " . $a['cid'], "record", 600);
						Runtime::set("col_item_given", Page::giveCollectionElement($player->id, $collection, 0, true, true, $collectionItem));
						/*
						if (!is_array($result)) $result = array();
						$result[] = array("type" => "collection_item", "name" => $collectionItem["name"], "image" => "/@/images/obj/collections/" . $collectionItem["image"] . ".png", "collection" => $collection["name"]);
						*/
						break;

					// дать элемент рандомной коллекции
					case 'give_rand_col_item':
						$collections = Page::sqlGetCacheRecordSet("SELECT DISTINCT c.id, c.code, c.name, c.image, c.repeats needed, IFNULL(cp.repeats, 0) have FROM collection c LEFT JOIN collection_player cp ON cp.player = " . $player->id . " AND cp.collection = c.id LEFT JOIN collection_item_player cip ON c.id = cip.collection AND cip.player = " . $player->id . " WHERE cip.player IS NOT NULL OR c.addcondition = 1", 3600, 'player_collections_' . $player->id . '_new');
						$c2 = array();
						$canDrop = array();
						if ($collections) {
							$ids = array();
							foreach ($collections as $key => &$c) {
								if ($c['code'] == 'teech_necklace' && $player->level < 4) {
									continue;
								} else {
									$ids[] = $c['id'];
									$c2[] = $c;
								}
							}
							$sql = "SELECT ci.collection, SUM(IF(ci.amount <= cip.amount, 1, 0)) as now, COUNT(ci.amount) as needed FROM collection_item ci LEFT JOIN collection_item_player cip ON cip.player = " . $player->id . " AND cip.collection_item = ci.id WHERE ci.collection IN (" . implode(", ", $ids) . ") GROUP BY ci.collection";
							$results = Page::sqlGetCacheRecordSet($sql, 3600, 'player_collections_progress_' . $player->id);
							if (count($results) && is_array($results))
							foreach ($results as $r) {
								foreach ($c2 as &$c) {
									if ($c['id'] == $r['collection']) {
										if ($c['needed'] <= $c['have']) {
											$c['progress'] = 100;
										} else {
											$c['progress'] = round($r['now'] / $r['needed'] * 100);
										}
										if ($c['progress'] != 100) {
											$canDrop[] = $c['id'];
										}
										break;
									}
								}
							}
						} else {
							$tmp = Page::sqlGetCacheRecord('SELECT id, level_min, level_max FROM collection', 3600, 'collections_by_level');
							foreach ($tmp as $key => &$t) {
								if ($t['level_min'] <= $player->level && $t['level_max'] >= $player->level) {
									$canDrop[] = $t['id'];
								}
							}
						}
						if (count($canDrop)) {
							$a['cid'] = $canDrop[rand(0, count($canDrop)-1)];
							$a['type'] = 'give_col_item';
							$collection = Page::getData("collection_array_" . $a['cid'], "SELECT * FROM collection WHERE id = " . $a['cid'], "record", 600);
							// -1 - вырублен лог совсем. Он ставится из кубовича. Если нужно будет гдето в дргом месте юзать с логом - перенести в параметр
							Page::giveCollectionElement($player->id, $collection, 0, true, true, $collectionItem);
							/*
							if (!is_array($result)) $result = array();
							$result[] = array("type" => "collection_item", "name" => $collectionItem["name"], "image" => "/@/images/obj/collections/" . $collectionItem["image"] . ".png", "collection" => $collection["name"]);
							*/
						}
						break;

					// мф-нуть вещь
					case 'mf_item':
						//
						break;

					// бонус
					case 'set_bonus':
						$sql = "UPDATE player2 SET patrol_bonus = '" . Std::cleanString($a['bonus']) . "' WHERE player = " . $player->id;
						if(Page::$sql->query($sql)) {
							$count++;
						}
						break;
						
					// охотничий клуб
					case 'huntdt':
						$curDt = strtotime($player->huntdt);
                        $sec = Page::timeLettersToSeconds($a['dt']);
                        $newDt = $curDt <= time() ? time() + $sec : $curDt + $sec;
						$player->huntdt = date('Y-m-d H:i:s', $newDt);
						$fields[] = playerObject::$HUNTDT;
						$count++;
						break;

					// vip-тренажерка
					case 'viptrainerdt':
						$curDt = strtotime($player->viptrainerdt);
                        $sec = Page::timeLettersToSeconds($a['dt']);
                        $newDt = $curDt <= time() ? time() + $sec : $curDt + $sec;
						$player->viptrainerdt = date('Y-m-d H:i:s', $newDt);
						$fields[] = playerObject::$VIPTRAINERDT;
						$count++;
						break;

					// банковская ячейка
					case 'bankdt':
						$curDt = strtotime($player->bankdt);
                        $sec = Page::timeLettersToSeconds($a['dt']);
                        $newDt = $curDt <= time() ? time() + $sec : $curDt + $sec;
						$player->bankdt = date('Y-m-d H:i:s', $newDt);
						$fields[] = playerObject::$BANKDT;
						$count++;
						break;
						
					// отправить лог
					case 'send_log':
						Page::sendLog($player->id, $a['type'], $a['params'], (isset($a['read'])) ? 0 : 1);
						$count++;
						break;

					// skillupgrade навык модификатора
					case 'skill_mf_increase':
						$player->skillupgrade += $a['skill'];
						$fields[] = playerObject::$SKILLUPGRADE;
						$count++;
						break;
						
					// skillgranata навык подрывника
					case 'skill_granata_increase':
						$player->skillgranata += $a['skill'];
						$fields[] = playerObject::$SKILLGRANATA;
						$count++;
						break;

					// случайное
					case 'random_set':
						$k = rand(0, count($a['actions']) - 1);
						$a = array($a['actions'][$k]);
						Page::doActions($player, $a);
						break;

					// вещь для цеха
					case 'autopart':
						if (!isset($a['part'])) {
							Std::loadModule('Automobile');
							Automobile::initResources();
							$parts = array_keys(Automobile::$resources);
							$part = $parts[rand(0, count($parts) - 1)];
							$a['part'] = $part;
						}
						/*
						if (!is_array($result)) $result = array();
						$result[] = array("type" => "automobile_part", "name" => Automobile::$resources[$a["part"]]["name"], "image" => Automobile::$resources[$a["part"]]["image"]);
						*/
						Page::$sql->query("UPDATE player2 SET a_" . $a['part'] . " = a_" . $a['part'] . " + " . $a['amount'] . " WHERE player = " . $player->id);
						break;
				}
			}
		if (count($fields)) {
			$player->save($player->id, $fields);
		}
		return $count;
	}

	/*
	 * Транслирует код действий в текст
	 *
	 * @param array $actions
	 * @return array
	 */

	public static function translateActions($actions, $player = null) {
		// Вы получаете: 'Золотой зуб', 'не менее 500 монет', 'иметь 6 уровень или выше', ...
		$results = array();
		if (count($actions))
			foreach ($actions as $a) {
				switch ($a['type']) {
					// деньги
					case 'money':
						if ($a['image'] == 1) {
							$results[] = array('type' => 'image', 'name' => Lang::MONEY, 'image' => 'tugrick.png', 'amount' => $a['money']);
						} else {
							$results[] = array('type' => 'one_line', 'text' => '<span class="tugriki">' . $a['money'] . '<i></i></span>');
						}
						break;
					// нефть
					case 'oil':
						if ($a['image'] == 1) {
							$results[] = array('type' => 'image', 'name' => Lang::OIL, 'image' => 'neft.png', 'amount' => $a['oil']);
						} else {
							$results[] = array('type' => 'one_line', 'text' => '<span class="neft">' . $a['oil'] . '<i></i></span>');
						}
						break;

					// руда
					case 'ore':
						if ($a['image'] == 1) {
							$results[] = array('type' => 'image', 'name' => Lang::ORE, 'image' => 'ruda.png', 'amount' => $a['ore']);
						} else {
							$results[] = array('type' => 'one_line', 'text' => '<span class="ruda">' . $a['ore'] . '<i></i></span>');
						}
						break;

					// опыт
					case 'exp':
						$results[] = array('type' => 'one_line', 'text' => '<span class="expa">' . $a['exp'] . '<i></i></span>');
						break;

					// петрики
					case 'petriks':
						if ($a['image'] == 1) {
							$results[] = array('type' => 'image', 'name' => Lang::PETRIKS, 'image' => 'nanogel.png', 'amount' => $a['petriks']);
						} else {
							$results[] = array('type' => 'one_line', 'text' => '<span class="petric">' . $a['petriks'] . '<i></i></span>');
						}
						break;

					// анаболики
					case 'anabolics':
						$results[] = array('type' => 'one_line', 'text' => '<span class="anabolic">' . $a['anabolics'] . '<i></i></span>');
						break;

					// фишки
					case 'chips':
						$results[] = array('type' => 'one_line', 'text' => '<span class="fishki">' . $a['chips'] . '<i></i></span>');
						break;

					// предмет
					case 'give_item':
						if (is_numeric($a['item'])) {
							$sql = "SELECT si.name, si.image FROM standard_item si WHERE si.id = " . $a['item'] . " LIMIT 1";
						} else {
							$sql = "SELECT si.name, si.image FROM standard_item si WHERE si.code = '" . $a['item'] . "' LIMIT 1";
						}
						if (DEV_SERVER) {
							$tmp = Page::$sql->getRecord($sql);
						} else {
							$tmp = Page::sqlGetCacheRecord($sql, 600);
						}
						$results[] = array('type' => 'image', 'name' => $tmp['name'], 'image' => $tmp['image'], 'amount' => (isset($a['amount']) ? $a['amount'] : 1));
						break;
					
					// элемент коллекции
					case "giv_col_item":
					case "give_col_item":
						$colItem = Page::getData("collection_item_" . Runtime::get("col_item_given"),
							"SELECT * FROM collection_item WHERE id = " . Runtime::get("col_item_given"), "record", 600);
						$results[] = array('type' => 'image', 'name' => $colItem['name'], 'image' => "collections/" . $colItem['image'] . ".png",
							'amount' => 1);
						Runtime::clear("col_item_given");
						break;

					// забирание предмета
					case 'delete_item':
						//$itemName = Page::$sql->getValue("SELECT si.name FROM standard_item si WHERE si.code = '" . $a['item'] . "' LIMIT 1");
						//$results[] = PageLang::ITEM . ' <b>' . $itemName . '</b>' . (@$a['amount'] > 1 ? ( ' x ' . $a['amount']) : '') . PageLang::PICKED;
						break;

					// бонус
					case 'set_bonus':
						$results[] = constant('PageLang::BONUS_' . strtoupper($a['bonus']));
						break;

					// охотничий клуб
					case 'huntdt':
						$results[] = Std::renderTemplate(PageLang::GET_HUNTDT, array('dt' => Std::formatPeriod(Page::timeLettersToSeconds($a['dt']))));
						break;

					// vip-тренажерка
					case 'viptrainerdt':
						$results[] = Std::renderTemplate(PageLang::GET_VIPTRAINERDT, array('dt' => Std::formatPeriod(Page::timeLettersToSeconds($a['dt']))));
						break;

					// банковская ячейка
					case 'bankdt':
						$results[] = Std::renderTemplate(PageLang::GET_BANKDT, array('dt' => Std::formatPeriod(Page::timeLettersToSeconds($a['dt']))));
						break;

					// skillupgrade навык модификатора
					case 'skill_mf_increase':
						$results[] = Std::renderTemplate(PageLang::GET_SKILLUPGRADE, array('skill' => $a['skill']));
						if ($player !== null) {
							$startSkill = $player->skillupgrade - $a['skill'];
							$startProf = Page::getMfProfBySkill($startSkill);
							$finishProf = Page::getMfProfBySkill($player->skillupgrade);
							if ($startProf['i'] != $finishProf['i']) {
								$results[] = Std::renderTemplate(PageLang::GET_PROF_UPGRADE, array('prof' => $finishProf['n']));
								Page::sendLog($player->id, 'skllvl', array('t' => 'mf', 'n' => $finishProf['n']));
							} else {
								Page::sendLog($player->id, 'sklup', array('t' => 'mf', 'n' => $startProf['n'], 'v' => $startSkill), 1);
							}
						}
						break;

					// skillgranata навык подрывника
					case 'skill_granata_increase':
						$results[] = Std::renderTemplate(PageLang::GET_SKILLGRANATA, array('skill' => $a['skill']));
						if ($player !== null) {
							$startSkill = $player->skillgranata - $a['skill'];
							$startProf = Page::getGranataProfBySkill($startSkill);
							$finishProf = Page::getGranataProfBySkill($player->skillgranata);
							if ($startProf['i'] != $finishProf['i']) {
								$results[] = Std::renderTemplate(PageLang::GET_PROF_GRANATA, array('prof' => $finishProf['n']));
								Page::sendLog($player->id, 'skllvl', array('t' => 'grn', 'n' => $finishProf['n']));
							} else {
								Page::sendLog($player->id, 'sklup', array('t' => 'grn', 'n' => $startProf['n'], 'v' => $startSkill), 1);
							}
						}
						break;

					// вещь для цеха
					case 'autopart':
						Std::loadModule('Automobile');
						Automobile::initResources();
						$part = Automobile::$resources[$a['part']];
						$results[] = array('type' => 'image', 'name' => $part['name'], 'image' => str_replace('/@/images/obj/', '', $part['image']), 'amount' => (isset($a['amount']) ? $a['amount'] : 1));
						break;
				}
			}
		return $results;
	}

	public static function razduplitArray($ar, &$results) {
		foreach ($ar as $a) {
			$numeric = true;
			foreach ($a as $k => $v) {
				if (!is_numeric($k)) {
					$numeric = false;
					break;
				}
			}
			if ($numeric) {
				Page::razduplitArray($a, $results);
			} else {
				$results[] = $a;
			}
		}
	}

	public static function fullActions($player, $actions, $text, $content = array(), $title = '') {
		Page::doActions($player, $actions);
		if (strlen($text) == 0) {
			return;
		}
		$newActions = array();
		Page::razduplitArray($actions, $newActions);
		$actions = $newActions;
		$results = Page::translateActions($actions, $player);
		$resultStr = '';

		$images = '';
		$resultOneLine = '';

		if (count($results) == 1 && is_string(reset($results))) {
			$resultOneLine .= reset($results);
		} else if (count($results) == 2 && is_string($results[0]) && is_string($results[1])) {
			$resultOneLine .= $results[0] . ' ' . Lang::UNION_AND . ' ' . $results[1];
		} else {
			foreach ($results as $r) {
				if (is_string($r)) {
					$resultsStr .= '<li>' . $r . '</li>';
				} else if (is_array($r) && $r['type'] == 'image') {
					$images .= '<span class="object-thumb">
									<img src="/@/images/obj/' . $r['image'] . '" alt="' . htmlspecialchars($r['name']) . '" title="' . htmlspecialchars($r['name']) . '" />
									<div class="count">#' . $r['amount'] . '</div>
								</span>';
				} else if (is_array($r) && $r['type'] == 'one_line') {
					$resultOneLine .= $r['text'];
				}
			}
		}
		if ($resultOneLine) {
			$resultsStr = $resultOneLine . $resultsStr;
		}
		$content['reward'] = $resultsStr;
		if ($title == '') {
			$title = PageLang::ALERT_OK;
		}
		if ($player->id == Page::$player->id) {
			Page::addAlert($title, Lang::renderText($text, $content) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : ''), ALERT_INFO);
		} else {
			Page::addAlert($title, Lang::renderText($text, $content) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : ''), ALERT_INFO, array(), $player->id);
		}
		
	}

	public static function translateForAlert($in) {
		$result = array();
		$itemsCode = array();
		foreach ($in as $key => $i) {
			switch ($i['type']) {
				case 'ore':
					$r = array('image' => 'underground2.png', 'name' => 'Руда', 'amount' => $i['ore']);
					break;

				case 'exp':
					$r = array('image' => 'collections/23-loot.png', 'name' => 'Опыт', 'amount' => $i['exp']);
					break;

				case 'give_item':
					$item = Page::sqlGetCacheRecord("SELECT name, image FROM standard_item WHERE code = '" . $i['item'] . "' LIMIT 1", 3600);
					$r = array('image' => $item['image'], 'name' => $item['name'], 'amount' => isset($i['amount']) ? $i['amount'] : 1);
					break;

				case 'anabolics':
					$r = array('image' => 'anabolics.png', 'name' => 'Анаболики', 'amount' => $i['anabolics']);
					break;
			}
			$result[$key] = $r;
		}
		return $result;
	}

	public static function signed($str) {
		$apiKey = "fuckingshit";
		return sha1($str . $apiKey);
	}

	/*
	 * Генерирует ключ для боя по его id
	 *
	 * @param int $duel
	 * @return string
	 */

	public static function generateKeyForDuel($duel) {
		return substr(md5($duel . Page::$data['project']['secretkey']), 0, 5);
	}

	/*
	 * Старт транзакции на локе мемкеша
	 *
	 * @param string $name
	 */
	public static function startTransaction($name, $personal = true, $time = 3, $cron = false, $redirect = false, $alert = false) {
		if ($personal && is_object(Page::$player)) {
			$name .= '/' . Page::$player->id;
		}
		if (Page::$cache->get('locks/' . $name) !== false) {
			if ($cron) {
				exit;
			} else {
                if (is_array($alert)) {
                    self::addAlert($alert["title"], $alert["text"], $alert["type"]);
                }
                $url = $redirect ? $redirect : "/player/";
				Std::redirect($url);
			}
		}
		//while (Page::$cache->get('locks/' . $name) !== false) {
		//	usleep(5000); // 5 ms
		//}
		$result = Page::$cache->set('locks/' . $name, true, $time);
		if (!$result) {
			Std::redirect('/player/');
		}
		Page::$transactions[$name] = true;
	}

	/*
	 * Проверка транзакции на локе мемкеша
	 *
	 * @param string $name
	 */
	public static function checkTransaction($name, $personal = true) {
		if ($personal && is_object(Page::$player)) {
			$name .= '/' . Page::$player->id;
		}
		return Page::$cache->get('locks/' . $name) !== false ? true : false;
	}

	/*
	 * Конец транзакции на локе мемкеша
	 *
	 * @param string $name
	 */
	public static function endTransaction($name, $personal = true) {
		if ($personal && is_object(Page::$player)) {
			$name .= '/' . Page::$player->id;
		}
		Page::$cache->delete('locks/' . $name);
		unset(Page::$transactions[$name]);
	}

	/*
	 * Снятие всех блокировок в мемкеше
	 */

	public static function forceEndTransactions() {
		if (count(Page::$transactions)) {
			foreach (Page::$transactions as $name => $tmp) {
				Page::endTransaction($name, false);
			}
		}
	}

	/*
	 * Получить профессию модификатора по уровню скилла
	 * @param $skill
	 * @return array
	 */
	public static function getMfProfBySkill($skill) {
		for ($i = 0, $j = sizeof(Page::$data['factory']['upgrade']); $i < $j; $i++) {
			$prof = Page::$data['factory']['upgrade'][$i];
			if ($prof['a'] <= $skill && $prof['b'] >= $skill) {
				break;
			}
		}
		$prof['i'] = $i;
		return $prof;
	}

	/*
	 * Получить профессию подрывника по уровню скилла
	 * @param $skill
	 * @return array
	 */
	public static function getGranataProfBySkill($skill) {
		for ($i = 0, $j = sizeof(Page::$data['groupfights']['skillgranata']); $i < $j; $i++) {
			$prof = Page::$data['groupfights']['skillgranata'][$i];
			if ($prof['a'] <= $skill && $prof['b'] >= $skill) {
				break;
			}
		}
		$prof['i'] = $i;
		return $prof;
	}

	/**
	 * Загрузка активного перка по коду
	 *
	 * @param string $code - "ALL" вернет все перки
	 * @param int $player
	 * @param int $clan
	 * @param string $fraction
	 * @return mixed
	 */
	public static function getPerkByCode($code, $player = null, $clan = null, $fraction = null) {
		$player = $player === null ? self::$player->id : $player;
		$clan = $clan === null ? (self::$player->clan > 0 && self::$player->clan_status != "recruit" ? self::$player->clan : 0) : $clan;
		$fraction = $fraction === null ? self::$player->fraction : $fraction;

		$queries = array("SELECT * FROM perk WHERE code = '" . $code . "' AND player = " . $player,
			"SELECT * FROM perk WHERE code = '" . $code . "' AND fraction = '" . $fraction . "'");
		if ($clan > 0) {
			$queries[] = "SELECT * FROM perk WHERE code = '" . $code . "' AND clan = " . self::$player->clan;
		}
		return self::$sql->getRecord(implode(" UNION ", $queries));
	}

	/**
	 * Загрузка активного перка по коду
	 *
	 * @param string $code - "ALL" вернет все перки
	 * @param int $player
	 * @param int $clan
	 * @param string $fraction
	 * @return mixed
	 */
	public static function getAllPerks($player = null, $clan = null, $fraction = null) {
		$player = $player === null ? self::$player->id : $player;
		$clan = $clan === null ? (self::$player->clan > 0 && self::$player->clan_status != "recruit" ? self::$player->clan : 0) : $clan;
		$fraction = $fraction === null ? self::$player->fraction : $fraction;

		$queries = array("SELECT si.name, si.image, si.info, p.value special1, si.special1name, p.dt2 FROM perk p LEFT JOIN standard_item si ON si.id = p.standard_item WHERE p.player = " . $player,
			"SELECT si.name, si.image, si.info, p.value special1, si.special1name, p.dt2 FROM perk p LEFT JOIN standard_item si ON si.id = p.standard_item WHERE p.fraction = '" . $fraction . "'");
		if ($clan > 0) {
			$queries[] = "SELECT si.name, si.image, si.info, p.value special1, si.special1name, p.dt2 FROM perk p LEFT JOIN standard_item si ON si.id = p.standard_item WHERE p.clan = " . self::$player->clan;
		}
		return self::$sql->getRecordSet(implode(" UNION ", $queries));
	}

	/**
	 * Кол-во перков на персонаже
	 *
	 * @param int $player
	 * @param int $clan
	 * @param string $fraction
	 * @return mixed
	 */
	public static function getPerkCount($player = null, $clan = null, $fraction = null) {
		$player = $player === null ? self::$player->id : $player;
		$clan = $clan === null ? (self::$player->clan > 0 && self::$player->clan_status != "recruit" ? self::$player->clan : 0) : $clan;
		$fraction = $fraction === null ? self::$player->fraction : $fraction;

		$queries = array("SELECT count(*) FROM perk WHERE player = " . $player,
			"SELECT count(*) FROM perk WHERE fraction = '" . $fraction . "'");
		if ($clan > 0) {
			$queries[] = "SELECT count(*) FROM perk WHERE clan = " . self::$player->clan;
		}
		$perksCount = self::$sql->getValueSet(implode(" UNION ", $queries));
		return $perksCount ? array_sum($perksCount) : 0;
	}

	public static function getGroupLevel($level) {
		$group = CacheManager::get('levelgroups', array('level' => $level));
		return $group;
		/*$key = "levelgroups_" . $level;
		$result = Page::$cache->get($key);
		if (!$result) {
			$result = json_decode(Page::$sql->getValue("SELECT value FROM value WHERE name = 'levelgroups'"), true);
			if (isset($result[$level])) {
				$result = $result[$level];
				Page::$cache->set($key, $result, 86400);
			} else {
				$result = end($result);
			}
			
		}
		return $result;*/
	}

	public static function getPostKey()
	{
		return sha1(self::$player->level . "yo!nigga%lets&dance" . self::$player->password);
	}

	public static function setValueFromDB($key, $value) {
		$sql = "UPDATE value SET value = '" . mysql_escape_string($value) . "' WHERE name = '" . $key . "' LIMIT 1";
		Page::$sql->query($sql);
		//Page::setCacheValueFromDB($key, $value, $expire);
	}

	public static function clearValueFromDB($key) {
		Page::$cache->delete('value_' . $key);
	}

	public static function isAdminFor($type) {
		if (!is_numeric(Page::$player->id)) {
			return false;
		}
		if ($type == 'debug-panel') {
			if (DEV_SERVER) {
				return true;
			}
			if (in_array(Page::$player->id, array(1, 3, 9550, 3422, 17595, 102649, 21003))) {
				return true;
			} else {
				return false;
			}
		} else if ($type == 'code-test') {
			if (in_array(Page::$player->id, array(1, 3422))) {
				return true;
			} else {
				return false;
			}
		}

		return false;
	}

	public static function sqlQueryOverPS($name, $params) {
		if (!isset($GLOBALS['preparedStatements'][$name])) {
			die('bad name for prepared statement - ' . $name);
		}

		$ps = $GLOBALS['preparedStatements'][$name];

		$execSql = "EXECUTE " . $name . " ";

		// если prepared statement с параметрами, то проставляем их в переменные
		if (count($params) > 0) {
			$sql = array();
			foreach ($params as $k => $v) {
				if (is_numeric($v) === false) {
					$v = "'" . $v . "'";
				}
				$sql[] = $k . ' = ' . $v . '';
			}
			$sql = "SET " . implode(", ", $sql);
			Page::$sql->query($sql);

			$execSql .= "USING " .  implode(", ", array_keys($params));
		}

		$result = Page::$sql->query($execSql);

		// если prepared statement такого нет, то создаем его и делаем execute еще раз
		if (mysql_errno() == 1243) {
			echo 'prepare ' . PHP_EOL;
			$prepSql = str_replace(array_keys($params), '?', $ps['sql']);
			$sql = "PREPARE " . $name . " FROM '" . str_replace("'", "\\'", $prepSql) . "'";
			Page::$sql->query($sql);

			$result = Page::$sql->query($execSql);
		}

		if ($result === false) {
			return false;
		}

		if ($ps['type'] == 'select_value') {
			$line = mysql_fetch_row($result);
			if ($line) {
				$result = $line[0];
			} else {
				$result = null;
			}
		} else if ($ps['type'] == 'select_value_set') {
			$resultTmp = array();
			while ($line = mysql_fetch_row($result)) {
				$resultTmp[] = $line[0];
			}
			$result = $resultTmp;
		} else if ($ps['type'] == 'select_record') {
			$line = mysql_fetch_assoc($result);
			if ($line) {
				$result = $line;
			} else {
				$result = null;
			}
		} else if ($ps['type'] == 'select_record_set') {
			$resultTmp = array();
			while ($line = mysql_fetch_assoc($result)) {
				$resultTmp[] = $line;
			}
			$result = $resultTmp;
		}

		return $result;
	}

}

?>