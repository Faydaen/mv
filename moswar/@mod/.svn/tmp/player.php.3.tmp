<?php
class Player extends Page implements IModule {
	public $moduleCode = 'Player';
	public $checkQuests = false;

	private $boostTypes = array('health', 'strength', 'dexterity', 'intuition', 'resistance', 'attention', 'charism', 'ratingcrit', 'ratingdodge', 'ratingresist', 'ratinganticrit', 'ratingdamage', 'ratingaccur');
	private $boostTypes2 = array('health', 'strength', 'dexterity', 'intuition', 'resistance', 'attention', 'charism');

	public $loadedBoosts = array();

	public function __construct() {
		parent::__construct();
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();

		// действия модераторов из админ-панели игрока
		if ($_POST['adminaction'] == '1') {
			$this->processAdminAction();
		}

		// AJAX запросы на получение служебных данных (например, состояние игрока)
		if (@$this->url[1] == "ajax") {
			$this->processAjaxRequest();
		}

		// AJAX запросы на получение данных пользователей модераторами
		if (is_numeric($this->url[0]) && $this->url[0] > 0) {
			$this->processAdminAjaxRequests();
		}

        // обработка специальных действий с предметами
		if ($this->url[0] == "item-special") {
			$this->processItemSpecial();
		}

		$content = Runtime::get('content');

		if (!is_numeric($this->url[0])) { //если смотрим свой профиль
			$this->needAuth();
			$this->checkQuests();
		} else { // если смотрим чужой профиль
			/*if (Page::$cache->get('playerprofile_views_' . ip2long($_SERVER['REMOTE_ADDR']))) {
				echo file_get_contents('@tpl/many_profiles_view.html');
				exit;
			} else {
				Page::$cache->set('playerprofile_views_' . ip2long($_SERVER['REMOTE_ADDR']), 1, 2);
			}*/

			// если просматривающий чужой профиль пользоватеь авторизован, то загружаем его права доступа
			if ((int) Page::$player->id > 0) {
				$getFromCache = array('friends_online', 'player_access');
				CacheManager::multiGet(array('player_id' => Page::$player->id), $getFromCache);
				Page::$player->loadAccess();
			}
		}

		if ($content !== false) {
			$this->content = array_merge($content, $this->content);
			Runtime::clear('content');
		}

/*
		if (self::$player != null && self::$player->id > 0) {
			self::$player->loadInventory();
			self::$player->loadGifts();
			self::$player->loadPet();
		}
*/
		// действия игрока

		if ($this->url[0] == 'test' && (Page::$player->id <= 20 || DEV_SERVER)) {
			if ($this->url[1] == 's') {
				$q = Page::$data['ny_gifts']['s'];
			} else if ($this->url[1] == 'm') {
				$q = Page::$data['ny_gifts']['m'];
			} else if ($this->url[1] == 'lo') {
				$q = Page::$data['ny_gifts']['lo'];
			} else if ($this->url[1] == 'lh') {
				$q = Page::$data['ny_gifts']['lh'];
			} else if ($this->url[1] == 'adm') {
				$q = Page::$data['ny_gifts']['adm'];
			} else {
				echo 'no gift';
				exit;
			}
			
			Page::fullActions(Page::$player, $q, 'Вы открыли подарок. Внутри вы нашли: <%reward%>');
			Std::redirect('/player/');
		}

		if ($this->url[0] == 'dress') {
			self::$player->loadInventory();
			if (isset(self::$player->inventory[$this->url[1]]) && self::$player->inventory[$this->url[1]]->slot != '' && self::$player->inventory[$this->url[1]]->equipped == 0) {
				$result = self::dress($this->url[1]);
				if (is_array($result)) {
					Runtime::set('content/result', $result);
				}
			}
			Std::redirect('/player/');
		}

		if ($this->url[0] == 'withdraw') {
			Std::loadMetaObjectClass("inventory");
			$inventory = new inventoryObject();
			$res = $inventory->load($this->url[1]);
			if ($res && $inventory->player == Page::$player->id) {
				self::$player->inventory[$this->url[1]] = $inventory;
			}

			if (isset(self::$player->inventory[$this->url[1]]) && self::$player->inventory[$this->url[1]]->slot != '' && self::$player->inventory[$this->url[1]]->equipped == 1) {
				$result = self::withdraw($this->url[1]);
				if (is_array($result)) {
					Runtime::set('content/result', $result);
				}
			}
			Std::redirect('/player/');
		}

		if ($this->url[0] == 'use') {
			Std::loadMetaObjectClass("inventory");
			$inventory = new inventoryObject();
			$res = $inventory->load($this->url[1]);
			if ($res && $inventory->player == Page::$player->id) {
				self::$player->inventory[$this->url[1]] = $inventory;
			}

			if (isset(self::$player->inventory[$this->url[1]]) && self::$player->inventory[$this->url[1]]->slot == '') {
				$result = self::useItem2($this->url[1]);
				if (is_array($result)) {
					Runtime::set('content/result', $result);
				}
			}
			Std::redirect('/player/');
		}

		if ($this->url[0] == 'opengift') {
			$result = self::openGift((int)$this->url[1]);
			if (is_array($result)) {
				Runtime::set('content/result', $result);
			}
			Std::redirect('/player/');
		}
			
		if ($this->url[0] == 'clearpresent') {
			$result = self::clearPresent((int)$this->url[1], (int)$this->url[2]);
			if (is_array($result)) {
				Runtime::set('content/result', $result);
			}
			//Std::redirect('/player/' . self::$player->id . '/');
			Std::redirect('/phone/logs/');
		}

		if ($this->url[0] == 'giftaccept') {
			self::acceptGift((int)$this->url[1], (int)$this->url[2]);
			Std::redirect('/phone/logs/');
		}

		if ($this->url[0] == 'giftcancel') {
			self::cancelGift((int)$this->url[1], (int)$this->url[2]);
			Std::redirect('/phone/logs/');
		}

		if ($this->url[0] == 'giftcomplain') {
			self::complainGift((int)$this->url[1], (int)$this->url[2]);
			Std::redirect('/phone/logs/');
		}
		
		if ($_POST['action'] == 'changePetName') {
			$result = self::changePetName($_POST['name']);
			if (is_array($result)) {
				Runtime::set('content/result', $result);
			}
			Std::redirect('/player/');
		}

		// это вообще тут используется?
		if ($_POST['action'] == 'sellpet') {
			$result = self::sellPet();
			if (is_array($result)) {
				Runtime::set('content/result', $result);
			}
			Std::redirect('/player/');
		}

		if (is_numeric($this->url[0])) {
			$id = abs((int)$this->url[0]);
			if ($id > NPC_ID) {
				$this->showNpcProfile($id);
			} else {
				$this->showProfile($id);
			}
		} else {
			$this->showProfile();
		}

		//
		parent::onAfterProcessRequest();
	}

	private function processAdminAjaxRequests()
	{
		if (isset($this->url[1]) && strlen($this->url[1])) {
			$this->needAuth(false);
		}
		switch ($this->url[1]) {
			case 'admin-history':
				$this->showAdminHistory((int)$this->url[0]);
				break;
			case 'admin-logs':
				$this->showAdminLogs((int)$this->url[0]);
				break;
			case 'admin-duels':
				$this->showAdminDuels((int)$this->url[0]);
				break;
			case 'admin-trade':
				$this->showAdminTradeHistory((int)$this->url[0]);
				break;
			case 'admin-messages':
				$this->showAdminMessages((int)$this->url[0]);
				break;
		}
	}

	private function processAdminAction() {
		$this->needAuth(false);
		self::$player->loadAccess();
		$playerId = (int)$_POST['player'];

		Std::loadModule('playeradmin');
		
		// модераторские действия
		switch ($_POST['action']) {
			case '+ Заблокировать': $result = PlayerAdmin::adminPlayerBlock($playerId, true, $_POST['text'], (int) $_POST['unbancost']);
				break;
			case '- Разблокировать': $result = PlayerAdmin::adminPlayerBlock($playerId, false, $_POST['text']);
				break;
			case '+ Молчанка на форуме': $result = PlayerAdmin::adminPlayerMute($playerId, 'forum', $_POST['period'], true, $_POST['text']);
				break;
			case '- Молчанка на форуме': $result = PlayerAdmin::adminPlayerMute($playerId, 'forum', $_POST['period'], false, $_POST['text']);
				break;
			case '+ Молчанка ЛС': $result = PlayerAdmin::adminPlayerMute($playerId, 'phone', $_POST['period'], true, $_POST['text']);
				break;
			case '- Молчанка ЛС': $result = PlayerAdmin::adminPlayerMute($playerId, 'phone', $_POST['period'], false, $_POST['text']);
				break;
			case '+ Молчанка в чате': $result = PlayerAdmin::adminPlayerMute($playerId, 'chat', $_POST['period'], true, $_POST['text']);
				break;
			case '- Молчанка в чате': $result = PlayerAdmin::adminPlayerMute($playerId, 'chat', $_POST['period'], false, $_POST['text']);
				break;
			case '+ Изолировать в чате': $result = PlayerAdmin::adminPlayerIsolate($playerId, true, $_POST['period'], $_POST['text']);
				break;
			case '- Изолировать в чате': $result = PlayerAdmin::adminPlayerIsolate($playerId, false, $_POST['period'], $_POST['text']);
				break;
			case '+ В тюрьму': $result = PlayerAdmin::adminPlayerJail($playerId, $_POST['period'], false, $_POST['text']);
				break;
			case '- В тюрьму': $result = PlayerAdmin::adminPlayerJail($playerId, $_POST['period'], true, $_POST['text']);
				break;
			case '+ Комментарий': $result = PlayerAdmin::adminAddPlayerComment($playerId, 'Комментарий', '', $_POST['text']);
				break;
			case '+ Сделать главой клана': $result = PlayerAdmin::adminPlayerClan($playerId, 'set founder');
				break;
			case '- Исключить из клана': $result = PlayerAdmin::adminPlayerClan($playerId, 'kick');
				break;
			case '+ Передать флаг': $result = PlayerAdmin::adminGiveFlag($playerId);
				break;
			case '+ Разрешить аватар': $result = PlayerAdmin::adminForumAvatar($playerId, 'allow');
				break;
			case '- Отклонить аватар': $result = PlayerAdmin::adminForumAvatar($playerId, 'deny', $_POST['text']);
				break;
			case '+ Пересчитать рейтинг': $result = PlayerAdmin::adminRating($playerId, 'repair');
				break;
			case '+ Показывать в рейтинге': $result = PlayerAdmin::adminRating($playerId, 'on');
				break;
			case '- Показывать в рейтинге': $result = PlayerAdmin::adminRating($playerId, 'off');
				break;
			case '- Очистить информацию': $result = PlayerAdmin::adminClearInfo($playerId);
				break;
			case '- Очистить кличку питомца': $result = PlayerAdmin::adminClearPetInfo($playerId);
				break;
			case '+ Забанить IP-адрес': $result = PlayerAdmin::adminIpBan($playerId, $_POST['text'], $_POST['period']);
				break;
			case '+ Пересчитать статы': $result = PlayerAdmin::adminRecalcStats($playerId);
				break;
			case '+ Передать сертификат на смену ника': $result = PlayerAdmin::adminGiveCertChangenickname($playerId);
				break;
			case '+ Брак': $result = PlayerAdmin::adminMarry($playerId, true);
				break;
			case '- Брак': $result = PlayerAdmin::adminMarry($playerId, false);
				break;
			case '+ Свадебный бой': $result = PlayerAdmin::adminMarryFight($playerId);
				break;
		}
		if ($_POST['action'] == '+ Комментарий') {
			$result = array(
				'type' => 'admin',
				'action' => 'player comment',
				'params' => array(
						'url' => '/player/' . $playerId . '/',
				),
				'result' => 1,
			);
		} else {
			PlayerAdmin::adminAddPlayerComment($playerId, $_POST['action'], $_POST['period'], $_POST['text']);
		}
		if (@$_POST['json'] == 1) {
			echo json_encode($result);
			exit;
		} else {
			Runtime::set('content/result', $result);
			Std::redirect($result['params']['url'], true);
		}
	}

	/**
	 * Изменение имени питомца
	 *
	 * @param string $nickname
	 * @return array
	 */
	public static function changePetName($nickname) {
		$result = array('type' => 'player', 'action' => 'change pet name');
		
		$currentName = self::$sql->getValue("SELECT name FROM pet WHERE player = " . self::$player->id);
		if ($currentName) {
			$nickname = preg_replace('/[^а-яёА-ЯЁa-zA-Z0-9\s\-]/u', '', $nickname);
			$nickname = substr($nickname, 0, 30);
			$currentName = preg_replace('~ ".*"$~', '', $currentName);
			$currentName = $name . ($nickname == '' ? '' : ' "' . $nickname . '"');
			self::$sql->query("UPDATE pet SET name = '" . Std::cleanString($currentName) . "' WHERE player = " . self::$player->id);
			CacheManager::delete('pet_full', array('pet_id' => Page::$player->id));
			$result['result'] = 1;

			Page::addAlert('Питомец', 'Теперь Ваш питомец откликается на кличку <b>' . $nickname . '</b>.');
		}

		return $result;
	}

	/**
	 * Очистка комментария на подарке игроком из логов
	 *
	 * @param int $giftId
	 */
	private static function clearPresent($giftId, $logId, $showAlert = true) {
		if (strlen($logId) < 9) {
			return false;
		}
		$dt = substr($logId, 0, 8);
		$logId = substr($logId, 8);
		self::$sql->query("UPDATE gift SET comment='' WHERE id = $giftId AND player = " . self::$player->id);
		//Page::$cache->delete("snowy_player_gifts_" . self::$player->id);
		CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));
		$params = self::$sql->getValue("SELECT params FROM log" . $dt . " where id = $logId AND player=" . self::$player->id);
		if (!empty($params)) {
			$params = json_decode($params, true);
			$params["cmnt"] = "";
			self::$sql->query("UPDATE log" . $dt . " SET params = '" . mysql_escape_string(json_encode($params)) . "' WHERE id = $logId AND player = " . self::$player->id);
		}
		if ($showAlert) {
			Page::addAlert('Комментарий удален', GiftLang::$giftClear);
		}
	}

	/**
	 * Принять подарок
	 *
	 * @param int $giftId
	 * @param int $logId
	 */
	private static function acceptGift($giftId, $logId) {
		if (strlen($logId) < 9) {
			return false;
		}
		$dt = substr($logId, 0, 8);
		$logId = substr($logId, 8);
		self::$sql->query("UPDATE gift SET hidden = false WHERE id = $giftId AND player = " . self::$player->id);
		//Page::$cache->delete("snowy_player_gifts_" . self::$player->id);
		CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));
		self::$sql->query("UPDATE log" . $dt . " SET type = 'gift_taken' WHERE id = $logId AND player = " . self::$player->id);
		Page::addAlert(GiftLang::$gift, GiftLang::$giftAccepted);
	}

	/**
	 * Отказаться от подарка
	 *
	 * @param int $giftId
	 * @param int $logId
	 * @param bool $showAlert
	 */
	private static function cancelGift($giftId, $logId, $showAlert = true) {
		if (strlen($logId) < 9) {
			return false;
		}
		$dt = substr($logId, 0, 8);
		$logId = substr($logId, 8);
		self::$sql->query("DELETE FROM gift WHERE id = $giftId AND player = " . self::$player->id);
		//Page::$cache->delete("snowy_player_gifts_" . self::$player->id);
		CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));
		self::$sql->query("DELETE FROM log" . $dt . " WHERE id = $logId AND player = " . self::$player->id);
		if ($showAlert) Page::addAlert(GiftLang::$gift, GiftLang::$giftCanceled);
	}

	/**
	 * Пожаловаться на подарок
	 *
	 * @param int $giftId
	 * @param int $logId
	 */
	private static function complainGift($giftId, $logId) {
		if (strlen($logId) < 9) {
			return false;
		}
		$gift = self::$sql->getRecord("SELECT g.id, g.name, g.player, g.time, g.comment, g.player_from, st.type FROM gift g LEFT JOIN standard_item st ON g.standard_item = st.id WHERE g.player = " . self::$player->id . " AND g.id = " . $giftId . " LIMIT 1");
		if ($gift != false) {
			Std::loadLib('HtmlTools');
			$player = self::$sql->getRecord("SELECT p.id, p.nickname, p.level FROM player p WHERE p.nickname = '" . $gift["player_from"] . "' LIMIT 1");
			Std::loadMetaObjectClass("post");
			$post = new postObject();
			$post->text = htmlspecialchars("Жалоба на подарок " . $gift['name'] . " от игрока " . $player['nickname'] . "[" . $player['level'] . "] http://moswar.ru/player/" . $player['id'] . "/ от " . date('d.m.Y H:i:s', $gift['time']) . ":\r\n[i]" . $gift['comment'] . '[/i]');
			$post->topic = 11743;
			$post->player = Runtime::$uid;
			$post->playerdata = json_encode(self::$player->exportForForum());
			$post->dt = date('Y-m-d H:i:s', time());
			$post->save();
		}
		if ($gift["type"] != "gift2") {
			self::cancelGift($giftId, $logId, false);
			Page::addAlert(GiftLang::$gift, GiftLang::$giftComplained);
		} else {
			self::clearPresent($giftId, $logId, false);
			Page::addAlert(GiftLang::$gift, GiftLang::$giftComplained2);
		}
	}

	/**
	 * Продажа питомца
	 *
	 * @return array
	 */
	public static function sellPet() {

		echo 'epic fail: sell pet';
		exit;
		
		$si = self::$sql->getRecord("SELECT si.money, si.honey, si.ore FROM pet p LEFT JOIN standard_item si ON p.item = si.id
			WHERE si.sellable = 1 AND p.player = " . self::$player->id);

		if ($si) {
			$result['money'] = round($si['money'] * 0.25);
			$result['honey'] = round($si['honey'] * 0.25);
			$result['ore'] = round($si['ore'] * 0.25);

			self::$player->money += $result['money'];
			self::$player->honey += $result['honey'];
			self::$player->ore += $result['ore'];
			self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE));

			self::$sql->query("DELETE FROM pet WHERE player = " . self::$player->id);
		}

		return array();
	}

	/**
	 * Надевание вещи
	 *
	 * @param int $id
	 * @return array
	 */
	public static function dress($id) {
		$result = array('type' => 'player', 'action' => 'dress');
		$item = self::$player->inventory[$id];

		if (self::$player->level < $item->level) {
			$result['result'] = 0;
			$result['error'] = 'low level';
			return $result;
		}
		$dress = $item->dress(true);
		if ($dress != false) {
			$item->save($item->id, array(inventoryObject::$EQUIPPED));
			//Page::$cache->delete("snowy_player_profile_equipped_" . self::$player->id);
			CacheManager::delete('player_equipped', array('player_id' => Page::$player->id));
		} else {
			$result['result'] = 0;
			$result['error'] = 'cant dress item, slot is busy';
			return $result;
		}

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Снятие вещи
	 *
	 * @param int $id
	 * @return array
	 */
	protected static function withdraw($id) {
		$result = array('type' => 'player', 'action' => 'withdraw');
		$item = self::$player->inventory[$id];

		$withdraw = $item->withdraw();

		if ($withdraw == false) {
			$result['result'] = 0;
			$result['error'] = 'item is not undressable';
			return $result;
		} else {
			//Page::$cache->delete("snowy_player_profile_equipped_" . self::$player->id);
			CacheManager::delete('player_equipped', array('player_id' => Page::$player->id));
		}

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Открыть подарок
	 *
	 * @param int $id - ID подарка в таблице gift
	 */
	public static function openGift($id) {
		//if (self::$player->id != 9550) {
		//	Std::redirect("/player/"); exit;
		//}
		if (self::$cache->get('gift_' . $id) == 1) {
			Page::addAlert('Подарок', 'Упаковка подарка не поддалась Вам. Попробуйте открыть его еще раз.');
			return;
		}
		self::$cache->set('gift_' . $id, 1, 5);

		$nowDt = time();
		if (Page::$player->id == 1) {
			$nowDt = strtotime('2011-01-01 00:01:01');
		}
		Std::loadMetaobjectClass('gift');
		$gift = new giftObject();
		if ($gift->load($id)) {
			if ($gift->player != Page::$player->id) {
				return;
			}
			$unlock = json_decode($gift->unlockedby, true);
			// TODO fuck with json
			$unlockDt = strtotime($unlock['dt']);

			if ($gift->unlocked == 1) {
				Page::addAlert('Подарок', 'Вы не смогли открыть подарок.');
				return;
			}
			if ($nowDt < $unlockDt) {
				Page::addAlert('Подарок', 'Этот подарок нельзя открыть раньше, чем <b>' . date('d.m.Y H:i', $unlockDt) . '</b>, иначе сюрприз будет испорчен.');
				return;
			}
			if (substr($gift->code, 0, 15) == 'present_ny2011_') {
				$k = (int)str_replace(array('present_ny2011_', '_adm'), '', $gift->code);
				if ($k >= 1 && $k <= 3) {
					$key = 's';
				} else if ($k >= 4 && $k <= 6) {
					$key = 'm';
				} else if ($k >= 7 && $k <= 9) {
					$key = 'lo';
				} else if ($k >= 10 && $k <= 12) {
					$key = 'lh';
				} else {
					$key = 'adm';
				}
				$unlockDt = strtotime('2011-01-01 00:00:01');
				if ($nowDt < $unlockDt) {
					Page::addAlert('Подарок', 'Этот подарок нельзя открыть раньше, чем <b>' . date('d.m.Y H:i', $unlockDt) . '</b>, иначе сюрприз будет испорчен.');
					return;
				}
				if (!$key) {
					return;
				}
				$text = 'Вы открыли подарок. Внутри вы нашли: <%reward%>';
				Page::fullActions(Page::$player, Page::$data['ny_gifts'][$key], $text, array('unlocked_item' => $gift->name), 'Подарок');
				
				self::$sql->query("UPDATE gift SET unlocked=1 WHERE id = " . $id);
				CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));				
				return;
			}
			if (isset($unlock['actions'])) {
				if (isset($unlock['alert_after'])) {
					$text = $unlock['alert_after'];
				} else {
					$text = 'Вы открыли подарок. Внутри вы нашли: <%reward%>.';
				}
				Page::fullActions(Page::$player, $unlock['actions'], $text, array('unlocked_item' => $gift->name), 'Подарок');
				
				self::$sql->query("UPDATE gift SET unlocked=1 WHERE id = " . $id);
				CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));				
				return;
			}

			if ($gift->unlocked == 0 && $unlock['item']['code'] == 'self' && $unlock['action'] == 'use' && $nowDt >= $unlockDt) {
				//if ($unlock['item']['code'] == 'self' && $unlock['action'] == 'use' && $nowDt >= $unlockDt) {
				self::$sql->query("UPDATE gift SET unlocked=1 WHERE id=" . $id);
				// если должна появиться одна вещь
				if (isset($unlock['newitem'])) {
					if (isset($unlock['newitem']['code'])) {
						$code = is_array($unlock['newitem']['code']) ? $unlock['newitem']['code'][mt_rand(0, sizeof($unlock['newitem']['code'])-1)] : $unlock['newitem']['code'];
						Std::loadMetaObjectClass('standard_item');
						$standard_item = new standard_itemObject;
						$standard_item->loadByCode($code);
						$item = $standard_item->makeExample(self::$player->id);
					}
					Page::addAlert('Подарок', 'Вы открыли подарок. Внутри Вы нашли: <b>' . $item->name . '</b>.');
					// если должно появиться несколько вещей
				} elseif (isset($unlock['newitemset']['code'])) {
					$amount = isset($unlock['newitemset']['amount']) ? (int)$unlock['newitemset']['amount'] : 1;
					$names = array();
					foreach ($unlock['newitemset']['code'] as $code) {
						Std::loadMetaObjectClass('standard_item');
						$standard_item = new standard_itemObject;
						$standard_item->loadByCode($code);
						for ($i = 0; $i < $amount; $i++) {
							$item = $standard_item->makeExampleOrAddDurability(self::$player->id);
						}
						$names[] = '<b>' . $standard_item->name . '</b> (' .  $amount . ')';
					}
					Page::addAlert('Подарок', 'Вы открыли подарок. Внутри Вы нашли: ' . implode(', ', $names) . '.');
				}
				//Page::$cache->delete("snowy_player_gifts_" . self::$player->id);
				CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));
			} else if ($gift->unlocked == 0 && $unlock['item']['code'] == 'self' && $unlock['action'] == 'use' && $nowDt < $unlockDt) {
				Page::addAlert('Подарок', 'Этот подарок нельзя открыть раньше, чем <b>' . date('d.m.Y H:i', $unlockDt) . '</b>, иначе сюрприз будет испорчен.');
			} else {
				Page::addAlert('Подарок', 'Вы не смогли открыть подарок.');
			}
		}
	}

	public static function useItem2($id) {
		$result = array('type' => 'player', 'action' => 'use item');
		$item = self::$player->inventory[$id];

		Page::startTransaction("use_item" . $id, true);
		
		//$sql = "START TRANSACTION";
		//Page::$sql->query($sql);
		$sql = "SELECT * FROM inventory WHERE id = " . $item->id . " LIMIT 1 FOR UPDATE";
		$tmp = Page::$sql->getRecord($sql);
		
		if (!$tmp) {
			$result['result'] = 0;
			return $result;
		}
		$item->init($tmp);
		
		if (self::$sql->getValue("SELECT 1 FROM playerboost2 WHERE player = " . self::$player->id . " AND code = '" . $item->code . "'")) {
			$result['result'] = 0;
			$result['error'] = 'you already have this boost';
			//$sql = "COMMIT";
			//Page::$sql->query($sql);
			return $result;
		}
		//$q = self::$player->inventory;
		//self::$player->inventory = array();
		$item->player = self::$player;
		if ($item->code == 'lockpick') {
			Runtime::set('content/alert', 'aftersafeunlocking');
		}

		if ($item->usable == 1 && $item->durability == 1 && $item->buyable == 1 && ($item->type == 'drug' || $item->type == 'petfood' || $item->type == 'petautofood')) {
			$actions[] = array('name' => 'Купить 1', 'onclick' => "shopBuyItem('" . self::getPostKey() . "', " . $item->standard_item . ", '/player/', 1);");
			$actions[] = array('name' => 'Купить 5', 'onclick' => "shopBuyItem('" . self::getPostKey() . "', " . $item->standard_item . ", '/player/', 5);");
			$actions[] = array('name' => 'Купить 10', 'onclick' => "shopBuyItem('" . self::getPostKey() . "', " . $item->standard_item . ", '/player/', 10);");
			$actions[] = array('name' => 'Закрыть', 'default' => 1);
			Page::addAlert(PlayerLang::LAST_ITEM_USED, Std::renderTemplate(PlayerLang::LAST_ITEM_USED_TEXT, array('name' => $item->name,'price' => Page::renderPrice($item->money, $item->ore,$item->honey))), '', $actions);
		}
		$item->useItem();
		//self::$player->inventory = $q;
		$result['result'] = 1;
		//$sql = "COMMIT";
		//Page::$sql->query($sql);
		return $result;
	}

	protected function showPlayerProfile($id) {
		if ($id == self::$player->id) {
			$this->showMyProfile();
			return;
		}
		$player = new playerObject;
		if ($player->load($id) === false) {
			$this->showMyProfile();
			return;
		}
	}

	protected function showProfile($id = 0) {
		global $data;
		Std::loadMetaObjectClass('player2');

		$this->content['profile'] = '';
		$template = 'player/view.xsl';

		if ($id === 0) {
			$id = self::$player->id;
			$this->content['profile'] = 'my';
			$template = 'player/profile.xsl';
		}
		if ($this->content['profile'] == 'my') {
			$exp['safe'] = 60 * 60 * 24 * 14;
			$exp['safe2'] = 3600 * 24;
			if (is_array(Page::$player->home)) {
				foreach (Page::$player->home as &$item) {
					if (($item->code == 'safe' || $item->code == 'safe2') && $item->dtbuy <= time() - $exp[$item->code] && $item->unlocked == 1) {
						Page::sendLog(Page::$player->id, 'item_expired', array('name' => $item->name), 0);
						$item->delete($item->id);
					}
				}
			}

			$getFromCache = array('player_gifts', 'player_stat', 'friends_online');
			if (Page::$player->clan > 0) {
				$getFromCache[] = 'clan_boosts';
				$getFromCache[] = 'clan_shortinfo';
			}
			$getFromCache[] = 'value_avgcut_stats';
			CacheManager::multiGet(array('player_id' => Page::$player->id, 'clan_id' => (int) Page::$player->clan, 'pet_id' => Page::$player->id), $getFromCache);
			self::$player->loadGifts2();
			$this->content['player'] = self::$player->toArray();
			$player = Page::$player;
			$player2 = Page::$player2;

			// мастерство
			$this->content["skill_granata"] = self::$player->getProf(Page::$data['groupfights']['skillgranata'], "skillgranata");
			$this->content["skill_hunt"] = self::$player->getProf(Page::$data['huntclub']['rangs'], "skillhunt");
			$this->content["skill_mf"] = self::$player->getProf(Page::$data['factory']['upgrade'], "skillupgrade");
		} else {
			if ($id == Page::$player->id) {
				$player = Page::$player;
				$player2 = Page::$player2;
			} else {
				$player = new playerObject();
				if ($player->load($id) === false) {
					$this->content['result'] = 0;
					$this->content['error'] = 'player not found';
					$this->content['block'] = '1';
					$this->page->addPart('content', 'player/notfound.xsl', $this->content);
					return;
				}
				$player2 = new player2Object();
				$player2->load($player->id);
			}

			$getFromCache = array('player_gifts', 'player_interests', 'player_equipped', 'player_profile_photo', 'player_photo_amount', 'player_stat');
			if ($player->clan > 0) {
				$getFromCache[] = 'clan_shortinfo';
				$getFromCache[] = 'clan_boosts';
			}
			
			if ( (Page::$player->access['forum_checking_avatar'] == 1 && $player->forum_avatar > 0) || ((self::$player == null || self::$player->forum_show_useravatars == 1) && $player->forum_avatar > 0 && $player->forum_avatar_checked == 1) ) {
				$getFromCache[] = 'stdimage_path';
			}
			CacheManager::multiGet(array('player_id' => $player->id, 'player2_id' => $player2->id, 'clan_id' => $player->clan, 'image_id' => $player->forum_avatar), $getFromCache);

			$player->loadGifts2();
			$player->loadHP();
			$this->content['player'] = $player->toArray();

			$player2->loadFullProfile($player->sex);

			// определение состояния войны
			if ($player->id != Page::$player->id) {
				Std::loadMetaObjectClass('diplomacy');
				$warId = diplomacyObject::areAtWar($player->clan, self::$player->clan);
			}
				
			if ($warId) {
				$this->content['player']['war'] = array('war' => 1);
				$dip = new diplomacyObject();
				$dip->load($warId);
				$this->content['player']['war']['killsleft'] = $dip->getKillsLeft($player->id);
				$this->content['player']['war']['state'] = $dip->state;

				// предметы для нападения на спрятавшихся врагов
				if ($this->content['action'] == 'attack' && ($this->content['message'] == 'cant_attack_busy' || $this->content['message'] == 'cant_attack_attacked_recently') && $dip->canKillNow($player->id, self::$player->id)) {
					$perms['police'] = false;
					$perms['time'] = false;
					$items = array();

					if ($player->state == 'police') {
						$perms['police'] = true;
						$items[] = "clan_ksiva";
					}
					$lastFightTimeDuringLastHour = (time() - $player->lasttimeattacked < 3600) ? $player->lasttimeattacked : false;
					if ($lastFightTimeDuringLastHour) {
						$perms['time'] = true;
						$items[] = (time() - $lastFightTimeDuringLastHour) > 300 && (time() - self::$player2->timemachinetime > 1800) ? "clan_timemashine" : "clan_timemashine_ollolo";
					}
					$this->content['perms'] = $perms;
					if (count($items)) {
						$it = Page::$sql->getValueSet("SELECT distinct code FROM inventory where player = " . self::$player->id . " and code in ('" . implode("', '", $items) . "')");
						if ($it && count($it) == count($items)) {
							$this->content['perms_items'] = 1;
						} else {
							$this->content['perms_items'] = 0;
						}
					}
				}
				// засчитается ли килл
				$this->content['player']['war']['cankillnow'] = $dip->canKillNow($player->id, self::$player->id);
			} else {
				$this->content['player']['war'] = array('war' => 0);
			}

			$this->content['profile'] = '';
			$template = 'player/view.xsl';

			// модерирование - проверка аватар
			if (Page::$player->access['forum_checking_avatar'] == 1) {
				if ($this->content['player']['forum_avatar'] > 0) {
					$this->content['player']['forum_avatar_src'] = CacheManager::get('stdimage_path', array('image_id' => $this->content['player']['forum_avatar']));
				}
			}

			// модерирование - причины для блокировки
			if (self::$player->access['player_admin_panel'] == 1 && self::$player->access['player_block'] == 1) {
				$sql = "SELECT * FROM blockreason ORDER BY id DESC";
				if (DEV_SERVER) {
					$reasons = Page::$sql->getRecordSet($sql);
				} else {
					$reasons = Page::sqlGetCacheRecordSet($sql, 86400);
				}
				$this->content['admin_panel']['blockreasons'] = $reasons;
			}

			if ((self::$player == null || self::$player->forum_show_useravatars == 1) && $this->content['player']['forum_avatar'] > 0 && $this->content['player']['forum_avatar_checked'] == 1) {
				$this->content['player']['custom_avatar'] = CacheManager::get('stdimage_path', array('image_id' => $this->content['player']['forum_avatar']));
			}

			foreach (Page::$data['stats'] as $stat => $tmp) {
				$this->content['player'][$stat . '_finish'] = $this->content['player'][$stat];
			}

			// таймеры молчанок
			Std::loadLib('HtmlTools');
			$this->content['player']['lastactivitytime'] = HtmlTools::FormatDateTime($this->content['player']['lastactivitytime'], true, false, false, false);
			$this->content['player']['mute_forum2'] = HtmlTools::FormatDateTime(date('Y-m-d H:i:s', $this->content['player']['mute_forum']), true, true, true);
			$this->content['player']['mute_phone2'] = HtmlTools::FormatDateTime(date('Y-m-d H:i:s', $this->content['player']['mute_phone']), true, true, true);
			$this->content['player']['mute_chat2'] = HtmlTools::FormatDateTime(date('Y-m-d H:i:s', $this->content['player']['mute_chat']), true, true, true);
			$this->content['player']['timer2'] = HtmlTools::FormatDateTime(date('Y-m-d H:i:s', $this->content['player']['timer']), true, true, true);

			// мастерство
			$this->content["skill_granata"] = $player->getProf(Page::$data['groupfights']['skillgranata'], "skillgranata");
			$this->content["skill_hunt"] = $player->getProf(Page::$data['huntclub']['rangs'], "skillhunt");
			$this->content["skill_mf"] = $player->getProf(Page::$data['factory']['upgrade'], "skillupgrade");
		}
		if ($player2->car) {
			$car = Page::$sql->getRecord("SELECT model, number FROM automobile_car WHERE id = " . $player2->car . " AND createdat < " . time() . " AND player = "  . $player->id);
			if ($car) {
				Std::loadModule("Automobile");
				Automobile::initModels();
				$this->content["car"] = array();
				$this->content["car"]["name"] = Automobile::$models[$car["model"]]["name"];
				$this->content["car"]["image"] = Automobile::$models[$car["model"]]["image"];
				$this->content["car"]["number"] = mb_substr($car["number"], 0, 1, "UTF-8") . "<b>" . mb_substr($car["number"], 1, 3, "UTF-8") . "</b>" . mb_substr($car["number"], 4, 2, "UTF-8");
			} else {
				$this->content["car"] = 0;
			}
		} else {
			$this->content["car"] = 0;
		}

		$this->content['player2'] = $player2->toArray();
		
		$maxStat = max($this->content['player']['health_finish'], $this->content['player']['dexterity_finish'], $this->content['player']['strength_finish'], $this->content['player']['intuition_finish'], $this->content['player']['charism_finish'], $this->content['player']['resistance_finish'], $this->content['player']['attention_finish']);
		foreach (Page::$data['stats'] as $stat => $tmp) {
			$statLetter = $stat{0};
			$statValue = $this->content['player'][$stat];
			$statValueFinish = $this->content['player'][$stat.'_finish'];

			$this->content['player'][$statLetter . '0'] = $statValue;
			$this->content['player'][$statLetter] = $statValueFinish - $statValue;
			$this->content['player']['p' . $statLetter] = floor(($statValue - ($statValueFinish > $statValue ? 0 : $statValue - $statValueFinish)) / $maxStat * 100);
			$this->content['player']['p' . $statLetter . '2'] = $statValueFinish >= $statValue ? floor(($statValueFinish - $statValue) / $maxStat * 100) : 0;
			$this->content['player']['p' . $statLetter . '3'] = $statValueFinish < $statValue ? floor(($statValue - $statValueFinish) / $maxStat * 100) : 0;
		}
		$this->content['player']['maxstat'] = $maxStat;
		$this->content['player']['avatar_without_ext'] = str_replace('.png', '', $this->content['player']['avatar']);

		if (is_numeric($this->content['player']['referer']) && $this->content['player']['referer'] > 0) {
			$tmp = CacheManager::get('player_small', array('player_id' => $this->content['player']['referer']));
			$this->content['player']['referer_nickname'] = $tmp['nickname'];
			//$this->content['player']['referer_nickname'] = Page::getData("snowy_player_profile_referername_" . $this->content['player']['referer'], "SELECT `nickname` FROM `player` WHERE `id` = " . $this->content['player']['referer'] . " LIMIT 1", "value", 3600);
		}
		$ratingsFromItems = $ratingsFromItems2 = array();
		if ($this->content['profile'] == 'my') {
			$equipped = array();
			$pets = array();
			$doping = array();
			$pet = array();

			$pets = self::$player->loadPets();
			$alivePets = array();
			$activePet = false;

			foreach ($pets as &$p) {
				if ($p->active == 1) {
					if ($activePet === false) {
						$activePet = $p;
					} else {
						$p->active = 0;
						$p->save(array(petObject::$ACTIVE));
					}
				}
				if (strtotime($p->respawn_at) < time()) {
					$alivePets[] = $p;
				}
			}
			if ($activePet !== false && strtotime($activePet->respawn_at) > time() && count($alivePets) > 0) {
				$activePet->active = 0;
				$activePet->save(array(petObject::$ACTIVE));
				$p = $alivePets[rand(0, count($alivePets)-1)];
				$p->active = 1;
				$p->save(array(petObject::$ACTIVE));
				$activePet = $p;
			}
			if ($activePet === false && count($pets) > 0) {
				if (count($alivePets)) {
					$p = $alivePets[rand(0, count($alivePets)-1)];
				} else {
					$p = $pets[rand(0, count($pets)-1)];
				}
				$p->active = 1;
				$p->save(array(petObject::$ACTIVE));
				$activePet = $p;
			}
			if ($activePet !== false) {
				$this->content['showpetinprofile'] = $activePet->image;
				$this->content['pet']['image'] = $activePet->image;
				$this->content['pet']['name'] = $activePet->name;
			}
			foreach ($pets as &$p) {
				$p = $p->toArray();
				$p['type'] = 'pet';
			}

			if ($activePet === false && count($pets) > 0) {
				if (count($alivePets)) {
					$p = $alivePets[rand(0, count($alivePets)-1)];
				} else {
					$p = $pets[rand(0, count($pets)-1)];
				}
				$p->active = 1;
				$p->save(array(petObject::$ACTIVE));
				$activePet = $p;
			}

			if ($activePet !== false) {
				$this->content['showpetinprofile'] = $activePet->image;
				$this->content['pet']['image'] = $activePet->image;
				$this->content['pet']['name'] = $activePet->name;
			}

			//self::$player->loadInventoryAsArray();
			self::$player->loadInventory();
			if (count(self::$player->inventory)) {
				foreach (self::$player->inventory as $item) {
					$currentItem = $item->toArray();
					$currentItem['si'] = $item->standard_item;

					Page::parseSpecialParams($currentItem);

					/*
					if ($item['equipped'] == 1) {
						$equipped[$item['type']] = $currentItem;
					}

					if ($item['type'] == 'home_comfort' || $item['type'] == 'home_defence' || $item['type'] == 'home_safe') {
						continue;
					} elseif ($item['type'] == 'drug' || $item['type'] == 'drug2') {
						if ($item['usestate'] == '' || $item['usestate'] == 'normal') {
							$currentItem['action']['code'] = 'use';
							$currentItem['action']['title'] = PlayerLang::$itemUseCaptionDrug;
						}
						if ($item['code'] == 'axe2') {
							$currentItem['action']['title'] = PlayerLang::$itemUseCationUsableItem;
						}
						$currentItem["unlockedby"] = str_replace(array("&quot;","@unlocked"), array('\"',$currentItem["unlocked"]), $currentItem["unlockedby"]);
						$doping[] = $currentItem;
					} elseif ($item['type'] == 'usableitem') {
						$currentItem['action']['code'] = 'use';
						$currentItem['action']['title'] = PlayerLang::$itemUseCationUsableItem;
                        $currentItem["unlockedby"] = str_replace(array("&quot;","@unlocked"), array('\"',$currentItem["unlocked"]), $currentItem["unlockedby"]);
						if ($currentItem["unlockedby"] != '') {
							$tmp = json_decode($currentItem["unlockedby"], true);
							if (isset($tmp['actions'])) {
								$currentItem['notOvertip'] = 1;
							}
						}
						$equipment[] = $currentItem;
					} elseif ($item['type'] == 'petfood' || $item['type'] == 'petautofood') {
						$currentItem['action']['code'] = 'use';
						$currentItem['action']['title'] = PlayerLang::$itemUseCationPetFood;
						$pet[] = $currentItem;
					} else {
						if ($item['equipped'] == 1) {
							$currentItem['action']['code'] = 'withdraw';
							$currentItem['action']['title'] = PlayerLang::$itemUseCaptionTakeOff;
							//if ($item->type != 'tech' || $item->level < 3) {
							foreach ($this->boostTypes as $type) {
								if ($item[$type] > 0) {
									if (!isset($this->content['player']['x'][$type{0}])) {
										$this->content['player']['x'][$type{0}] = array();
									}
									$value = abs($item[$type]) <= 0.1 ? ($item[$type] * 1000) . '%' : $item[$type];
									//$this->content['player']['x'][$type{0}][] = array('si' => $item->standard_item, 'value' => $value);
									if (in_array($type, $this->boostTypes2)) {
										$this->content['player']['x'][$type{0}][] = array('nm' => $item['name'], 'value' => $value);
									}
									if (!isset($ratingsFromItems2[$type])) {
										$ratingsFromItems2[$type] = array();
									}
									$ratingsFromItems[$type] += $value;
									$ratingsFromItems2[$type][] = array('name' => $item['name'], 'value' => $value);
								}
							}
							// пересчет бонусов и процентов от бустов
							foreach ($this->boostTypes2 as $type) {
								if (abs($item[$type]) <= 0.1) {
									$mustbe[$type . '_percent'] += $item[$type] * 1000;
								} else if ($item->$type) {
									$mustbe[$type . '_bonus'] += $item[$type];
								}
							}
							//}
						} elseif ($item['equipped'] == 0 && $item['slot'] != '') {
                            $currentItem['action']['code'] = 'dress';
							$currentItem['action']['title'] = PlayerLang::$itemUseCaptionPutOn;
						}
                        $currentItem["unlockedby"] = str_replace(array("&quot;","@unlocked"), array('\"',$currentItem["unlocked"]), $currentItem["unlockedby"]);
						$equipment[] = $currentItem;
					}
					*/
					
					if ($item->equipped == 1) {
						$equipped[$item->type] = $currentItem;
					}

					if ($item->code == 'pet_knut') {
						$currentItem['action']['code'] = '';
						$currentItem['action']['title'] = '';
						$pets[] = $currentItem;
					} else if ($item->type == 'home_comfort' || $item->type == 'home_defence' || $item->type == 'home_safe') {
						continue;
					} elseif ($item->type == 'drug' || $item->type == 'drug2') {
						if ($item->usestate == '' || $item->usestate == 'normal') {
							$currentItem['action']['code'] = 'use';
							$currentItem['action']['title'] = PlayerLang::$itemUseCaptionDrug;
						}
						if ($item->code == 'axe2') {
							$currentItem['action']['title'] = PlayerLang::$itemUseCationUsableItem;
						}
						$currentItem["unlockedby"] = str_replace(array("&quot;","@unlocked"), array('\"',$currentItem["unlocked"]), $currentItem["unlockedby"]);
						$doping[] = $currentItem;
					} elseif ($item->type == 'usableitem') {
						$currentItem['action']['code'] = 'use';
						$currentItem['action']['title'] = PlayerLang::$itemUseCationUsableItem;
                        $currentItem["unlockedby"] = str_replace(array("&quot;","@unlocked"), array('\"',$currentItem["unlocked"]), $currentItem["unlockedby"]);
						if ($currentItem["unlockedby"] != '') {
							$tmp = json_decode($currentItem["unlockedby"], true);
							if (isset($tmp['actions'])) {
								$currentItem['notOvertip'] = 1;
							}
						}
						$equipment[] = $currentItem;
					} elseif ($item->type == 'petfood' || $item->type == 'petautofood') {
						$currentItem['action']['code'] = 'use';
						$currentItem['action']['title'] = PlayerLang::$itemUseCationPetFood;
						$pets[] = $currentItem;
					} else {
						if ($item->equipped == 1) {
							$currentItem['action']['code'] = 'withdraw';
							$currentItem['action']['title'] = PlayerLang::$itemUseCaptionTakeOff;
							//if ($item->type != 'tech' || $item->level < 3) {
							foreach ($this->boostTypes as $type) {
								if ($item->$type > 0) {
									if (!isset($this->content['player']['x'][$type{0}])) {
										$this->content['player']['x'][$type{0}] = array();
									}
									$value = abs($item->$type) <= 0.1 ? ($item->$type * 1000) . '%' : $item->$type;
									//$this->content['player']['x'][$type{0}][] = array('si' => $item->standard_item, 'value' => $value);
									if (in_array($type, $this->boostTypes2)) {
										$this->content['player']['x'][$type{0}][] = array('nm' => $item->type, 'value' => $value);
									}
									if (!isset($ratingsFromItems2[$type])) {
										$ratingsFromItems2[$type] = array();
									}
									//if (abs($item->$type) <= 0.1) {
									//	$ratingsFromItems[$type . '_percent'] += $value;
									//} else {
									//	$ratingsFromItems[$type] += $value;
									//}
									$ratingsFromItems[$type] += $item->$type;
									$ratingsFromItems2[$type][] = array('name' => $item->name, 'value' => $value);
								}
							}
							// пересчет бонусов и процентов от бустов
							foreach ($this->boostTypes2 as $type) {
								if (abs($item->$type) <= 0.1) {
									$mustbe[$type . '_percent'] += $item->$type * 1000;
								} else if ($item->$type) {
									$mustbe[$type . '_bonus'] += $item->$type;
								}
							}
							//}
						} elseif ($item->equipped == 0 && $item->slot != '') {
                            $currentItem['action']['code'] = 'dress';
							$currentItem['action']['title'] = PlayerLang::$itemUseCaptionPutOn;
						}
                        $currentItem["unlockedby"] = str_replace(array("&quot;","@unlocked"), array('\"',$currentItem["unlocked"]), $currentItem["unlockedby"]);
						$equipment[] = $currentItem;
					}
				}
				// пересчет бонусов и процентов от вещей раз в 10 минут
				$tmp = Runtime::get('recalcstats');
				if ($tmp == false || $tmp < time()) {
					self::$player->loadBoosts2();
					if (count(self::$player->boost) > 0) {
						foreach (self::$player->boost as $boost) {
							foreach ($this->boostTypes2 as $type) {
								$value = $boost[$type];
								if (abs($value) <= 0.1) {
									$mustbe[$type . '_percent'] += $value * 1000;
								} else if ($value) {
									$mustbe[$type . '_bonus'] += $value;
								}
							}
						}
					}
					$fields2 = array();
					foreach ($this->boostTypes2 as $type) {
						self::$player->{$type . '_bonus'} = (int) $mustbe[$type . '_bonus'];
						self::$player->{$type . '_percent'} = (int) $mustbe[$type . '_percent'];
						$fields2[] = playerObject::${strtoupper($type . '_percent')};
						$fields2[] = playerObject::${strtoupper($type . '_bonus')};
					}
					Runtime::set('recalcstats', time() + 600);
					self::$player->save(self::$player->id, $fields2);
				}
				// добавление неоткрытых подарков в инвентарь
				if (is_array(self::$player->gifts)) {
					foreach (self::$player->gifts as $item) {
						if ($item["unlocked"] == 0) {
							$item['action']['code'] = 'use';
							$item['action']['title'] = PlayerLang::$itemUseCaptionOpen;
							$equipment[] = $item;
						}
					}
				}
			}

			$this->content['equipment'] = $equipment;
			$this->content['equipped'] = $equipped;
			$this->content['doping'] = $doping;
			$this->content['pets'] = $pets;

			$this->content['player']['exp_next_level'] = Page::$data['exptable'][$this->content['player']['level']];
			$this->content['player']['procentexp'] = floor($this->content['player']['exp'] / $this->content['player']['exp_next_level'] * 100);
			$this->content['player']['procentsuspicion'] = floor ((self::$player->suspicion + 5) / 10 * 100);

			for ($i = 1; $i < $this->content['player']['level']; $i++) {
				$this->content['player']['exp_next_level'] += Page::$data['exptable'][$i];
				$this->content['player']['exp'] += Page::$data['exptable'][$i];
			}

			$this->content['player']['inventory'] = array('amount' => self::$player->inventoryAmount, 'capacity' => self::$player->capacity);

			if (self::$player->wanted) {
				$state0 = self::$sql->getValueSet("SELECT dt FROM hunt WHERE player = " . self::$player->id . " AND state = 0 ORDER BY dt ASC");
				if ($state0) {
					foreach ($state0 as $time) {
						$time = strtotime($state0[0]);
						if ($time - 90 >= time()) {
							$this->content["otkup"] = 1;
							$this->content["otkup_min"] = floor(($time - time()) / 60);
						}
					}
				} else {
					if (self::$sql->getValue("SELECT count(*) FROM hunt WHERE player = " . self::$player->id . " AND (state = 1 OR state = 0)") == 0) {
						$this->content['player']['wanted'] = 0;
					}
				}
			}

			// werewolf
			//$tmp = json_decode(Page::$player2->werewolf_data, true);
			$this->content['player2']['werewolf_timer'] = strtotime(Page::$player2->werewolf_dt) - time();
			$this->content['player2']['werewolf_timer2'] = date('H:i:s', $this->content['player2']['werewolf_timer']);

			$this->content['player']['ratings'] = '';
			foreach (Page::$data['ratings'] as $rating => $t) {
				if ($this->content['player'][$rating] > 0) {
					$this->content['player']['ratings'][] = $t['name'] . ': +' . $this->content['player'][$rating];
				}
			}
			if (is_array($this->content['player']['ratings'])) {
				$this->content['player']['ratings'] = implode('|', $this->content['player']['ratings']);
			}

		} else {
			// одетые на персонажа вещи
			
			//$sql = "SELECT name, image, info, slot, type, standard_item si, mf FROM inventory WHERE player = " . $this->content['player']['id'] . " AND equipped = 1";
			//$equipped = Page::getData("snowy_player_profile_equipped_" . $this->content['player']['id'], $sql, "recordset", 3600);
			//$equipped = Page::$sql->getRecordSet($sql);
			$equipped = CacheManager::get('player_equipped', array('player_id' => $this->content['player']['id']));
			if (is_array($equipped)) {
				foreach ($equipped as $item) {
					$this->content['equipped'][$item['type']] = $item;
				}
			}
			if ($this->content['player']['wanted'] && self::$player != null) {
				$myProf = self::$player->getProf(Page::$data['huntclub']['rangs'], "skillhunt");
				if (strtotime(self::$player->huntdt) < time() || (abs(self::$player->level - $this->content['player']['level']) > 1 && self::$player->level > $this->content['player']['level'] - 2) ||
						self::$sql->getValue("SELECT count(1) FROM " . Page::$__LOG_TABLE__ . " WHERE player=" . self::$player->id . "
                        AND type = 'fighthntclb'") >= (10 + $myProf["i"]) ||
						self::$sql->getValue("SELECT count(*) FROM hunt WHERE player = " . $this->content['player']["id"] . " AND state = 1") == 0) {
					$this->content['player']['wanted'] = 0;
				}
			}

			// подарки
			if (is_array($this->content['player']['gifts']) && count($this->content['player']['gifts'])) {
				$this->content['player']['gifts2'] = array();
				for ($i = 0, $j = sizeof($this->content["player"]["gifts"]); $i < $j; $i++) {
					$gift =& $this->content["player"]["gifts"][$i];
               if ($gift['endtime']>0) {
					$gift['enddate'] = date('d.m.Y', $gift['endtime']);
					$gift['endtime'] = date('H:i', $gift['endtime']);
					} else {
					$gift['enddate'] = '';
					$gift['endtime'] = '';
					}
					$gift['giftdate'] = date('d.m.Y', $gift['gifttime']);
					$gift['gifttime'] = date('H:i', $gift['gifttime']);
					
					Page::parseSpecialParams($gift);
					$gift['time'] = str_replace(array('d', 'h', 'm', 's'), array(' д', ' ч', ' м', ' с'), $gift['time']);
					$gift['comment'] = preg_replace('/\|{2,}/', '|', str_replace("\r\n", '|', $gift['comment']));
					if ($gift["type"] != "award") {
						$this->content['player']['gifts2'][] = $this->content["player"]["gifts"][$i];
						unset($this->content["player"]["gifts"][$i]);
					}
				}
			}
         
			/*
			 * AWARD SORT
			 */
            /*
			$awardRating = Page::sqlGetCacheRecordSet("select count(1) count, code from gift where type='award' group by code", 3600);
			$awardIndex = array();
			foreach($awardRating as &$awardRec) {
				$awardIndex[$awardRec["code"]] = $awardRec;
			}
			foreach ($this->content['player']['gifts'] as &$gift) {
				$gift["count"] = $awardIndex[$gift["code"]];
			}
            */
			/**/

			// клановая регалия
			if ($this->content['player']['clan'] > 0 && $this->content['player']['clan_status'] != 'recruit') {
				$award = CacheManager::get('clan_boosts', array('clan_id' => $this->content['player']['clan']));
				if (is_array($award) && count($award)) {
					$this->content['player']['gifts'] = array_merge(array($award), $this->content['player']['gifts']);
				}
			}

			/*
			 * AWARD SORT
			 */
			usort($this->content['player']['gifts'], array($this, "awardMainSort"));
			usort($this->content['player']['gifts'], array($this, "awardPersonalSort"));
			/**/

			//$sql = "select SQL_CALC_FOUND_ROWS id from photo where status = 'accepted' and player = " . $this->content['player']['id'] . " order by in_profile desc limit 1";
			//$photo = Page::getData("snowy_player_profile_photo_" . $this->content['player']['id'], $sql, "record", 3600);
			$photoId = CacheManager::get('player_profile_photo', array('player_id' => $this->content['player']['id']));
			if (is_numeric($photoId)) {
				$photo['thumb_src'] = 'http://img.moswar.ru/@images/photos/' . $photoId . '_thumb.jpg';

				//$sql = "select count(*) from photo where status = 'accepted' and player = " . $this->content['player']['id'];
				//$photo['amount'] = Page::getData("snowy_player_profile_photocount_" . $this->content['player']['id'], $sql, "value", 3600);
				$photo['amount'] = CacheManager::get('player_photo_amount', array('player_id' => $this->content['player']['id']));

				$this->content['player']['photo'] = $photo;
			}

			// pet
			if (isset($player->data['spip']) && $player->data['spip'] == 1) {
				$sql = "SELECT name, level, info, image, respawn_at FROM pet WHERE player = " . $player->id . " and active = 1";
				$showpetinprofile = Page::$sql->getRecord($sql);
				if ($showpetinprofile && strtotime($showpetinprofile['respawn_at']) < time()) {
					$this->content['showpetinprofile'] = 1;
					$this->content['pet'] = $showpetinprofile;
				}
			}
			
		}
		// допинги
		$this->content['player']['dopings'] = self::showDopings($this->content['player']['id'], $this->content['player']['fraction'], $this->content['player']['clan'], $this->content['player']['x'], $ratingsFromItems, $ratingsFromItems2);
		if ($this->content['profile'] == 'my') {
			$this->content['player']['full_dopings'] = $this->showFullDopings($this->content['player']['id'], $this->content['player']['fraction'], $this->content['player']['clan'], $this->content['player']['x'], $ratingsFromItems, $ratingsFromItems2);
			$this->content['existingBoosts'] = $this->loadedBoosts;
		}
        $this->content['player']['procenthp'] = floor($this->content['player']['hp'] / $this->content['player']['maxhp'] * 100);

		$this->content['player']['stat'] = CacheManager::get('player_stat', array('player_id' => $this->content['player']['id']));

		if ($this->content['player']['clan'] > 0 && $this->content['player']['clan_status'] != 'recruit') {
			//$clan = self::getData('clan_' . $this->content['player']['clan'], "SELECT id, name FROM `clan` WHERE `id` = " . $this->content['player']['clan'] . " LIMIT 1", 'record', 600);
			$clan = CacheManager::get('clan_shortinfo', array('clan_id' => $this->content['player']['clan']));
			$this->content['player']['clan'] = array();
			$this->content['player']['clan']['id'] = $clan['id'];
			$this->content['player']['clan']['name'] = $clan['name'];
		}

        // перки
        $this->content['player']['perks'] = self::showPerks($this->content['player']['id'], $clan['id'] ? $clan['id'] : null, $this->content['player']['fraction']);

		if (Runtime::get('captcha') == 1) {
			Runtime::get('captcha') == 0;
			//$this->content['captcha'] = array();
			//$this->content['captcha']['return_url'] = Runtime::get('captcha_return_url');
			//Runtime::clear('captcha');
			//Runtime::clear('captcha_return_url');
		}

		if (self::$player->id > 0) {
			$this->content['auth'] = 1;
			if ($this->content['profile'] != 'my') {
				//$this->content['self'] = self::$player->toArray();
				$this->content['self'] = array('level' => Page::$player->level, 'access' => Page::$player->access, 'accesslevel' => Page::$player->accesslevel);
			}
		} else {
			$this->content['self'] = array('id' => 0);
		}
		if ($this->content['profile'] == 'my') {
			$needFields = array(
				//'health', 'health_bonus', 'health_percent', 'health_finish',
				//'strength', 'strength_bonus', 'strength_percent', 'strength_finish',
				//'dexterity', 'dexterity_bonus', 'dexterity_percent', 'dexterity_finish',
				//'intuition', 'intuition_bonus', 'intuition_percent', 'intuition_finish',
				//'resistance', 'resistance_bonus', 'resistance_percent', 'resistance_finish',
				//'attention', 'attention_bonus', 'attention_percent', 'attention_finish',
				//'charism', 'charism_bonus', 'charism_percent', 'charism_finish',
				'wanted', 'level', 'id', 'nickname', 'fraction', 'dopings', 'background', 'avatar', 'status',
				'avatar_without_ext', 'clan', 'clan_status', 'exp', 'exp_next_level', 'hp', 'maxhp', 'procenthp',
				'suspicion','procentsuspicion', 'respect', 'statsum2', 'respect', 'stat', 'referer', 'referer_nickname',
				'inventory', 'pet', 'password', 'boost', 'h', 'h0', 'ph', 'ph2', 'ph3', 's', 's0', 'ps', 'ps2', 'ps3',
				'd', 'd0', 'pd', 'pd2', 'pd3', 'r', 'r0', 'pr', 'pr2', 'pr3', 'i', 'i0', 'pi', 'pi2', 'pi3',
				'a', 'a0', 'pa', 'pa2', 'pa3', 'c', 'c0', 'pc', 'pc2', 'pc3', 'procentexp', 'state', 'perks',
				'full_dopings'
			);
		} else {
			$needFields = array(
				//'health_finish', 'strength_finish', 'dexterity_finish', 'intuition_finish', 'resistance_finish', 'attention_finish', 'charism_finish',
				//'h', 's', 'd', 'r', 'i', 'a', 'c',
				//'health', 'health_bonus', 'health_percent', 'health_finish',
				//'strength', 'strength_bonus', 'strength_percent', 'strength_finish',
				//'dexterity', 'dexterity_bonus', 'dexterity_percent', 'dexterity_finish',
				//'intuition', 'intuition_bonus', 'intuition_percent', 'intuition_finish',
				//'resistance', 'resistance_bonus', 'resistance_percent', 'resistance_finish',
				//'attention', 'attention_bonus', 'attention_percent', 'attention_finish',
				//'charism', 'charism_bonus', 'charism_percent', 'charism_finish',
				'wanted', 'level', 'id', 'nickname', 'fraction', 'dopings', 'background', 'avatar', 'status', 'gifts', 'gifts2',
				'avatar_without_ext', 'clan', 'clan_status', /*'exp', 'exp_next_level',*/ 'hp', 'maxhp', 'procenthp',
				/*'suspicion','procentsuspicion', 'respect',*/ 'statsum2', 'respect', 'stat', 'referer', 'referer_nickname',
				/*'inventory', 'pet', 'password',*/ 'boost', 'h', 'h0', 'ph', 'ph2', 'ph3', 's', 's0', 'ps', 'ps2', 'ps3',
				'd', 'd0', 'pd', 'pd2', 'pd3', 'r', 'r0', 'pr', 'pr2', 'pr3', 'i', 'i0', 'pi', 'pi2', 'pi3', 'war',
				'a', 'a0', 'pa', 'pa2', 'pa3', 'c', 'c0', 'pc', 'pc2', 'pc3', 'sex', 'accesslevel', 'custom_avatar', 'photo', 'state', 'perks'
			);
			if (Page::$player->access['player_admin_panel']) {
				$needFields = array_merge(array('lastactivitytime', 'ip', 'mute_forum', 'mute_forum2', 'mute_phone', 'mute_phone2', 'mute_chat', 'mute_chat2', 'mute_state', 'forum_avatar', 'forum_avatar_checked', 'forum_avatar_src', 'state', 'timer2', 'timer'), $needFields);
			}
		}
		if (true || Page::$player->id == 1) {
			if (is_array($needFields) && count($needFields)) {
				foreach ($this->content['player'] as $key => $tmp) {
					if (!in_array($key, $needFields)) {
						$removed[$key] = $tmp;
						unset($this->content['player'][$key]);
					}
				}
				/*if ($this->url[0] == 'q' || $this->url[1] == 'q') {
					echo 'removed: ' . strlen(json_encode($removed)) . '; content: ' . strlen(json_encode($this->content['player']));
					var_dump($removed);
				}*/
			}
		}

		$this->content['window-name'] = $this->content['player']['nickname'] . ' [' . $this->content['player']['level'] . ']';
		$this->page->addPart('content', $template, $this->content);
	}

	public function awardMainSort($a, $b) {
		/* Флаг в топ */
		$flagCode = "ctf_flag";
		if ($a["code"] == $flagCode) return -1;
		if ($b["code"] == $flagCode) return 1;

		if ($a["count"] == $b["count"]) {
			return 0;
		}

		return ($a["count"] < $b["count"]) ? -1 : 1;
	}

	public function awardPersonalSort($a, $b) {
		/* Флаг в топ */
		$flagCode = "ctf_flag";
		if ($a["code"] == $flagCode) return -1;
		if ($b["code"] == $flagCode) return 1;

		$aMod = preg_match("!_m[0-9]+$!", $a["code"]);
		$bMod = preg_match("!_m[0-9]+$!", $b["code"]);
		if ($aMod == 0) return -1;
		if ($bMod == 0) return 1;
		return 0;
	}

    /**
     * Генерация списка активных перков
     *
     * @param int $playerId
     * @return string
     */
    public static function showPerks($playerId, $clan, $fraction)
    {
        if (self::getPerkCount($playerId, $clan, $fraction) > 0) {
            if ($playerId == self::$player->id) {
                $perks = self::getAllPerks($playerId, $clan, $fraction);
                foreach ($perks as &$perk) {
                    $t = strtotime($perk["dt2"]) - time();
                    $h = floor($t / 3600);
                    $m = floor(($t - $h * 3600) / 60);
                    $s = $t - $m * 60 - $h * 3600;
                    $perk["timeleft"] = sprintf("%02d:%02d:%02d", $h, $m, $s);
                    $perk["timeleft2"] = $t;
                    Page::parseSpecialParams($perk);
                }
                return $perks;
            } else {
                return PlayerLang::ALERT_HASPERKS;
            }
        } else {
            return "";
        }
    }

	/**
	 * Генерация списка активных допингов для поп-апа
	 *
	 * @param int $playerId
	 * @return string
	 */
	public static function showDopings($playerId, $fraction = '', $clanId = 0, &$x = null, $ratingsFromItems = null, $ratingsFromItems2 = null) {
		Std::loadModule("Automobile");
		//$boostTypes = array('ratingcrit','ratingdodge','ratingresist','ratinganticrit','ratingdamage','ratingaccur','health_bonus','health_percent','strength_bonus','strength_percent','dexterity_bonus','dexterity_percent','intuition_bonus','intuition_percent','resistance_bonus','resistance_percent','attention_bonus','attention_percent','charism_bonus','charism_percent');
		$boostTypes = array('ratingcrit','ratingdodge','ratingresist','ratinganticrit','ratingdamage','ratingaccur','health','strength','dexterity','intuition','resistance','attention','charism', 'percent_dmg', 'percent_defence', 'percent_hit', 'percent_dodge', 'percent_crit', 'percent_anticrit');
		$boostTypes2 = array('health','strength','dexterity','intuition','resistance','attention','charism');

		$dopings = '';

		$boosts = array(
				'health'         => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'strength'       => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'dexterity'      => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'intuition'      => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'resistance'     => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'attention'      => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'charism'        => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'ratingcrit'     => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'ratingdodge'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'ratingresist'   => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'ratinganticrit' => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'ratingdamage'   => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'ratingaccur'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_dmg'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_defence'=> array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_hit'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_dodge'  => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_crit'   => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_anticrit'=> array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
		);

		if ($playerId == self::$player->id) {
			$sql = "SELECT b.*, si.name FROM playerboost2 b LEFT JOIN standard_item si ON si.id = b.standard_item WHERE player = " . $playerId . " and b.type IN ('drug', 'drug2', 'gift2', 'automobile_ride') and dt2 < date_add(now(), interval 1 month)";
			$results = Page::$sql->getRecordSet($sql);
			if (!$results) {
				$mdopings = '';
			} else {
				$boo = array();
				Automobile::initDirections();
				Automobile::initFeatures();
				foreach ($results as $r) {
					if ($r["type"] == "automobile_ride") {
						$r["name"] = AutomobileLang::ALERT_RIDE . " " . Automobile::$directions[$r["code"]]["name"];
					}
					foreach ($boosts as $key => &$b) {
						$v = $r[$key];
						if ($v != 0) {
							if (abs($v) <= 0.1) {
								$b['v2'] += $v * 1000;
							} else {
								$b['v'] += $v;
							}
							$b['i'][] = array('name' => $r['name'], 'v' => (abs($v) > 0.1 ? $v : 0 ), 'v2' => (abs($v) <= 0.1 ? ($v * 1000) : 0 ), 'dt2' => $r['dt2']);
						}
					}
				}
				unset($b);
				foreach ($boosts as $key => $b) {
					if (count($b['i']) == 0) {
						continue;
					}
					$dopings .= '<b>';
					if (substr($key, 0, 6) == 'rating') {
						$dopings .= Page::$data['ratings'][$key]['name'];
					} else if(substr($key, 0, 7) == 'percent') {
						$dopings .= Automobile::$features[$key];
					}else {
						$dopings .= Page::$data['stats'][$key]['name'];
					}
					$dopings .= ': ';
					if ($b['v'] != 0) {
						if ($b['v'] > 0) {
							$dopings .= '+';
						}
						$dopings .= $b['v'];
						if ($b['v2'] != 0) {
							$dopings .= ' ';
						}
					}
					if ($b['v2'] != 0) {
						if ($b['v2'] > 0) {
							$dopings .= '+';
						}
						$dopings .= $b['v2'] . '%';
					}
					$dopings .= '</b>|';
					foreach ($b['i'] as $key => $c) {
						$dopings .= '&#0160; &#0160; &#0160; ';
						if ($c['v'] != 0) {
							if ($c['v'] > 0) {
								$dopings .= '+';
							}
							$dopings .= $c['v'];
						}
						if ($c['v2'] != 0) {
							if ($c['v2'] > 0) {
								$dopings .= '+';
							}
							$dopings .= $c['v2'] . '%';
						}
						$dopings .= ' до ' . date('d.m.Y H:i', strtotime($c['dt2'])) . ' — ' . $c['name'] . '|';
					}
				}
				$mdopings = $dopings;
			}
		} else {
			if (Page::$sql->getValue("SELECT 1 FROM playerboost2 WHERE player=$playerId LIMIT 1")) {
				$mdopings = Lang::$messageUnderAffects;
			}
		}
		return $mdopings;
	}

	public function showFullDopings($playerId, $fraction = '', $clanId = 0, &$x = null, $ratingsFromItems = null, $ratingsFromItems2 = null) {
		Std::loadModule("Automobile");
		//$boostTypes = array('ratingcrit','ratingdodge','ratingresist','ratinganticrit','ratingdamage','ratingaccur','health_bonus','health_percent','strength_bonus','strength_percent','dexterity_bonus','dexterity_percent','intuition_bonus','intuition_percent','resistance_bonus','resistance_percent','attention_bonus','attention_percent','charism_bonus','charism_percent');
		$boostTypes = array('health','strength','dexterity','intuition','resistance','attention','charism','ratingcrit','ratingdodge','ratingresist','ratinganticrit','ratingdamage','ratingaccur', 'percent_dmg', 'percent_defence', 'percent_hit', 'percent_dodge', 'percent_crit', 'percent_anticrit');
		$boostTypes2 = array('health','strength','dexterity','intuition','resistance','attention','charism');

		$dopings = '';

		$boosts = array(
				'health'         => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'strength'       => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'dexterity'      => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'intuition'      => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'resistance'     => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'attention'      => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'charism'        => array('value' => 0, 'value2' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'ratingcrit'     => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0, 'ap' => 0),
				'ratingdodge'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0, 'ap' => 0),
				'ratingresist'   => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0, 'ap' => 0),
				'ratinganticrit' => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0, 'ap' => 0),
				'ratingdamage'   => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0, 'ap' => 0),
				'ratingaccur'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0, 'ap' => 0),
				'percent_dmg'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_defence'=> array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_hit'    => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_dodge'  => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_crit'   => array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
				'percent_anticrit'=> array('value' => 0, 'i' => array(), 'v' => 0, 'v2' => 0),
		);

		$flagProcessed = false;
		$hasBoosts = false;

		if ($playerId == self::$player->id) {
			Std::loadLib('HtmlTools');
			Automobile::initDirections();
			//$boosts2 = Page::$sql->getRecordSet("SELECT * FROM playerboost2 WHERE player=$playerId");
			$boosts2 = self::$player->loadBoosts2(true);
			if ($boosts2) {
				foreach ($boosts2 as $boost) {
					if ($boost['type'] == 'drug2' || $boost['type'] == 'drug') {
						$this->loadedBoosts[$boost['code']] = 1;
					}
					if ($boost["type"] == "automobile_ride") {
						$boost["name"] = AutomobileLang::ALERT_RIDE . " " . Automobile::$directions[$boost["code"]]["name"];
					}

					//if ($boost['code'] == 'clan_founder_crown' || $boost['code'] == 'item_clan_founder_crown') {
					//    continue;
					//}
					$hasBoosts = true;
					if ($boost['code'] == 'item_ctf_flag' || $boost['code'] == 'ctf_flag') {
						foreach ($boostTypes2 as $type) {
							$boosts[$type]['v'] = 1;
							$boosts[$type]['value'] += $boost[$type];
							$boosts[$type]['i'][] = '+' . $boost[$type] . ' ' . PlayerLang::$strForFlag;
							if ($x) {
								if (!isset($x[$type{0}])) {
									$x[$type{0}] = array();
								}
								$x[$type{0}][] = array('si' => 76, 'nm' => PlayerLang::$strFlagAtMe, 'value' => $boost[$type]);
							}
						}
						$flagProcessed = true;
						continue;
					}
					foreach ($boostTypes as $type) {
						if ($boost[$type] != 0) {
							$value2 = abs($boost[$type]) <= 0.1 ? '2' : '';
							$boosts[$type]['v' . $value2] = 1;
							$boosts[$type]['value' . $value2] += $boost[$type] * ($value2 ? 1000 : 1);
							if ($boost["subtype"] == "award") {
								$i = "+" . ($boost[$type] * ($value2 ? 1000 : 1)) . " — " . $boost["name"];
							} else {
								$i = array('value' => ($boost[$type] * ($value2 ? 1000 : 1)), 'p' => ($value2 ? '%' : ''), 'si' => $boost['standard_item']);
								if (!empty($boost["name"])) $i["p"] .= " — " . $boost["name"];
								$i['dt'] = HtmlTools::FormatDateTime($boost['dt2'], true, false, false);
							}
							$boosts[$type]['i'][] = $i;
							if (in_array($type, $boostTypes2)) {
								$x[$type{0}][] = array(
										'si' => $boost['standard_item'],
										'nm' => $boost["name"],//self::$sql->getValue("SELECT name FROM standard_item WHERE id=" . $boost['standard_item']),
										'value' => ($boost[$type] * ($value2 ? 1000 : 1)), 'p' => ($value2 ? '%' : '')
								);
							}
						}
					}
				}
			}

			if (!$flagProcessed) {
				$flag = array(CacheManager::get('value_flag_fraction'), CacheManager::get('value_flag_clan'));
				if ($clanId > 0 && isset($flag[1]) && $clanId == $flag[1]) {
					$hasBoosts = true;
					$flagProcessed = true;
					foreach ($boostTypes2 as $type) {
						$boosts[$type]['v'] = 1;
						$boosts[$type]['value'] += 2;
						$boosts[$type]['i'][] = '+2 ' . PlayerLang::$strForFlag;
						if ($x) {
							if (!isset($x[$type{0}])) {
								$x[$type{0}] = array();
							}
							$x[$type{0}][] = array('si' => 76, 'nm' => PlayerLang::$strFlagAtClaner, 'value' => 2);
						}
					}
				}
				if ($fraction != '' && $fraction == $flag[0] && !$flagProcessed) {
					$hasBoosts = true;
					foreach ($boostTypes2 as $type) {
						$boosts[$type]['v'] = 1;
						$boosts[$type]['value'] += 1;
						$boosts[$type]['i'][] = '+1 ' . PlayerLang::$strForFlag;
						if ($x) {
							if (!isset($x[$type{0}])) {
								$x[$type{0}] = array();
							}
							$x[$type{0}][] = array('si' => 76, 'nm' => PlayerLang::$strFlagAtOurSide, 'value' => 1);
						}
					}
				}
			}

			$boostsNew = array();
			$boostsNewTotal = array();
			$boosts1 = self::$player->loadBoosts();
			if ($boosts1) {
				foreach ($boosts1 as $boost1) {
					if ($boost1['type'] == 'rating') {
						if (!is_array($boostsNew[$boost1['code']])) {
							$boostsNew[$boost1['code']] = array();
						}
						$boostsNew[$boost1['code']][] = array('name' => $boost1['info'], 'value' => $boost1['value']);
						$boostsNewTotal[$boost1['code']] += $boost1['value'];

						if ($boosts[$boost1['code']]['v'] == 0 && $boosts[$boost1['code']]['v2'] == 0) {
							$hasBoosts = true;
						}
					}
				}
			}

			
			if ($ratingsFromItems != null) {
				foreach ($ratingsFromItems as $rating => $value) {
					if ($boosts[$rating]['v'] == 0 && $boosts[$rating]['v2'] == 0) {
						$hasBoosts = true;
					}
				}
			}

			$mustBe = array();
			$fields = array();
			//echo 'hasBoosts: ' . (int) $hasBoosts;
			if ($hasBoosts) {
				$dopings = array();
				foreach ($boosts as $code => $boost) {
					if (isset($boost['value2'])) {
						$c = $code . '_percent';
						$v = $boost['value2'];
						$v += ((float)$ratingsFromItems[$code] * 1000) % 1000;
						//echo $c . ' ' .$boost['value2'] . PHP_EOL;
					} else {
						$c = $code;
						$v = $boost['value'];
					}
					$mustBe[$c] = 0;

					if ($ratingsFromItems2 != null && isset($ratingsFromItems2[$code])) {
						if (array_key_exists($code, Page::$data['ratings'])) {
							//echo 'aaaa';
							if (abs($ratingsFromItems[$code]) < 0.1) {
								$boost['value2'] += $ratingsFromItems[$code] * 1000;
							} else {
								$boost['value'] += $ratingsFromItems[$code];
							}
							foreach ($ratingsFromItems2[$code] as $ratingsFromItem) {
								$boost['i'][] = $ratingsFromItem['name'] . ': +' . $ratingsFromItem['value'];
								$v += $ratingsFromItem['value'];
							}
						}
					}

					if (isset($boostsNew[$code])) {
						if (array_key_exists($code, Page::$data['ratings'])) {
							$boost['value'] += $boostsNewTotal[$code];
							foreach ($boostsNew[$code] as $boostNew) {
								$boost['i'][] = $boostNew['name'] . ': +' . $boostNew['value'];
								$v += $boostNew['value'];
							}
						}
					}

					if (sizeof($boost['i']) > 0) {
						if ($code == 'percent_dmg') {
							$dopings[] = '<b>' . Lang::$captionPercentDmg . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'percent_defence') {
							$dopings[] = '<b>' . Lang::$captionPercentDefence . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'percent_hit') {
							$dopings[] = '<b>' . Lang::$captionPercentHit . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'percent_dodge') {
							$dopings[] = '<b>' . Lang::$captionPercentDodge . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'percent_crit') {
							$dopings[] = '<b>' . Lang::$captionPercentCrit . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'percent_anticrit') {
							$dopings[] = '<b>' . Lang::$captionPercentAnticrit . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'ratingcrit') {
							$dopings[] = '<b>' . Lang::$captionRatingCrit . ': +' . $boost['value'] . '</b>';
						}
						if ($code == 'ratingdodge') {
							$dopings[] = '<b>' . Lang::$captionRatingDodge . ': +' . $boost['value'] . '</b>';
						}
						if ($code == 'ratingresist') {
							$dopings[] = '<b>' . Lang::$captionRatingResistance . ': +' . $boost['value'] . '</b>';
						}
						if ($code == 'ratinganticrit') {
							$dopings[] = '<b>' . Lang::$captionRatingActiCrit . ': +' . $boost['value'] . '</b>';
						}
						if ($code == 'ratingdamage') {
							$dopings[] = '<b>' . Lang::$captionRatingDamage . ': +' . $boost['value'] . '</b>';
						}
						if ($code == 'ratingaccur') {
							$dopings[] = '<b>' . Lang::$captionRatingAccur . ': +' . $boost['value'] . '</b>';
						}
						if ($code == 'health') {
							$dopings[] = '<b>' . Lang::$captionStatHealth . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'strength') {
							$dopings[] = '<b>' . Lang::$captionStatStrength . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'dexterity') {
							$dopings[] = '<b>' . Lang::$captionStatDexterity . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'attention') {
							$dopings[] = '<b>' . Lang::$captionStatAttention . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'intuition') {
							$dopings[] = '<b>' . Lang::$captionStatIntuition . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'resistance') {
							$dopings[] = '<b>' . Lang::$captionStatResistance . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if ($code == 'charism') {
							$dopings[] = '<b>' . Lang::$captionStatCharism . ':' . ($boost['v'] != 0 ? ($boost['value'] > 0 ? ' +' : ' ') . $boost['value'] : '') . ($boost['v2'] != 0 ? ((int)$boost['value2'] > 0 ? ' +' : ' ') . $boost['value2'] . '%' : '') .'</b>';
						}
						if (substr($code, 0, 6) == 'rating') {
							$tmp = json_decode(CacheManager::get('value_avgcut_stats', array('level' => Page::getGroupLevel(Page::$player->level))), true);
							if ($code == 'ratingresist' || $code == 'ratingaccur') {
								$k = $tmp['intuition_avg'];
							} else {
								$k = $tmp['dexterity_avg'];
							}
							$s = $tmp['health_avg'] + $tmp['strength_avg'] + $tmp['dexterity_avg'] + $tmp['resistance_avg'] + $tmp['intuition_avg'] + $tmp['attention_avg'] + $tmp['charism_avg'];
							$ap = round($boost['value'] * 1 / ($k * 5 + $s * 2) * 100, 2);
							if ($ap) {
								switch ($code) {
									case 'ratingresist':
										$n = PageLang::$captionPercentDefence;
										break;

									case 'ratingaccur':
										$n = PageLang::$captionPercentHit;
										break;

									case 'ratingcrit':
										$n = PageLang::$captionPercentCrit;
										break;

									case 'ratinganticrit':
										$n = PageLang::$captionPercentAnticrit;
										break;

									case 'ratingdodge':
										$n = PageLang::$captionPercentDodge;
										break;

									case 'ratingdamage':
										$n = PageLang::$captionPercentDmg;
										break;
								}
								$add = '&#160;<b>(' . $n . ' +' . $ap . '%)</b>';
								$dopings[count($dopings) - 1] .= $add;
							}
						}
						foreach ($boost['i'] as $i) {
							$dopings[] = '&#0160; &#0160; &#0160; ' . (is_array($i) ? ($i['value'] > 0 ? '+' : '') . str_replace('-', '–', $i['value']) . $i['p'] .  ($i['dt'] == "" ? "" : ', до ' . $i['dt']) : $i);
						}
					}
					if (self::$player->{$c} != $v) {
						self::$player->{$c} = $v;
						$fields[] = $c;
					}
				}
				//var_dump($ratingsFromItems);
				//var_dump($ratingsFromItems2);
			} else {
				foreach ($boosts as $code => $boost) {
					if (isset($boost['value2'])) {
						$c = $code . '_percent';
					} else {
						$c = $code;
					}

					if (substr($c, 0, 6) == 'rating' && $ratingsFromItems != null) {
						$mustBe[$c] = $ratingsFromItems[$c];
					} else {
						$mustBe[$c] = 0;
					}

					if (self::$player->{$c} != $mustBe[$c]) {
						self::$player->{$c} = 0;
						$fields[] = playerObject::${strtoupper($c)};
					}
				}
			}
			//echo 'mustBe:';
			//var_dump($mustBe);
			//echo 'fields:';
			foreach ($fields as $v) {
				$v = str_replace('player.', '', strtolower($v));
			}
			if (count($fields)) {
				self::$player->save(self::$player->id, $fields);
				self::$player->testOnLoad();
			}
			if (is_array($dopings)) {
				$dopings = implode('|', $dopings);
			}
		} else {
			if (Page::$sql->getValue("SELECT 1 FROM playerboost2 WHERE player=$playerId LIMIT 1")) {
				$dopings = Lang::$messageUnderAffects;
			}
		}
		return $dopings;
	}

	/**
	 * Досье игрока для модератора
	 *
	 * @param int $playerId
	 */
	private function showAdminHistory($playerId) {
		self::$player->loadAccess();
		if (self::$player->access['player_admin_panel'] == 1 && self::$player->access['player_view_history'] == 1) {
			$offset = isset($this->url[2]) && is_numeric($this->url[2]) ? abs((int)$this->url[2]) : 0;
			$data = self::$sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS DATE_FORMAT(pc.dt, '%d.%m.%Y %H:%i:%s') d, pc.action a,
                pc.period p, pc.text c, p.id, p.nickname nm FROM playercomment pc LEFT JOIN player p ON p.id=pc.player2 WHERE pc.player=$playerId
                ORDER BY dt DESC LIMIT $offset, 20");
			$data[] = array('id' => self::$sql->getValue("SELECT found_rows()"));
			echo Std::arrayToJson($data);
		}
		exit;
	}

	/**
	 * История торговых сделок игрока для модератора
	 *
	 * @param int $playerId
	 */
	private function showAdminTradeHistory($playerId) {

	}

	/**
	 * История дуэлей игрока для модератора
	 *
	 * @param int $playerId
	 */
	private function showAdminDuels($playerId) {
		self::$player->loadAccess();
		if (self::$player->access['player_admin_panel'] == 1 && self::$player->access['player_view_duels'] == 1) {
			$offset = isset($this->url[2]) && is_numeric($this->url[2]) ? abs((int)$this->url[2]) : 0;

			$data = self::$sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS type, params, dt FROM log WHERE player = " . $playerId . "
                AND type IN ('fight_attacked','fight_defended')
                ORDER BY dt DESC LIMIT " . $offset . ", 20"); // ,'fighthntclb'
			foreach ($data as $i => &$row) {
				$params = json_decode($row["params"], true);
				$row["pid"] = $params["player"]["id"];
				$row["pnm"] = $params["player"]["nickname"];
				$row["plv"] = $params["player"]["level"];
				$row["d"] = $params["fight_id"];
				$row["r"] = $params["result"];
				$row["m"] = $params["profit"];
				$row["x"] = $params["exp"];
				$row["z"] = $params["zub"];
				$row['sk'] = Page::generateKeyForDuel($row['d']);
				unset($row["params"]);
			}

			$data[] = array('id' => self::$sql->getValue("SELECT found_rows()"));
			echo Std::arrayToJson($data);
		}
		exit;
	}

	/**
	 * Сообщения игрока для модератора
	 *
	 * @param int $playerId
	 */
	private function showAdminMessages($playerId) {
		self::$player->loadAccess();
		if (self::$player->access['player_admin_panel'] == 1 && self::$player->access['player_view_messages'] == 1) {
			$offset = isset($this->url[2]) && is_numeric($this->url[2]) ? abs((int)$this->url[2]) : 0;

			if ($playerId < 20) {
				$data = false;
			} else {
				$data = self::$sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS m.id, m.player2 p2, m.player p1, m.text, m.dt, m.type,
                p1.nickname pnm1, p1.level plv1, p2.nickname pnm2, p2.level plv2
                FROM message m LEFT JOIN player p1 ON m.player = p1.id LEFT JOIN player p2 ON m.player2 = p2.id
                WHERE player = " . $playerId . " OR player2 = " . $playerId . " ORDER BY m.dt DESC LIMIT " . $offset . ", 20");
			}

			foreach ($data as $i => &$row) {
				for ($i = 1; $i < 3; $i++) {
					if ($row["p" . $i] == $playerId) {
						$row["p" . $i] = 0;
						unset($row["pnm" . $i]);
						unset($row["plv" . $i]);
					}
					$row["text"] = str_replace(array('"', PHP_EOL, "\r", "\n", "\r\n"),
							array("'", '<br />', '<br />', '<br />', '<br />'), $row["text"]);
				}
			}

			$data[] = array('id' => self::$sql->getValue("SELECT found_rows()"));
			echo Std::arrayToJson($data);
		}
		exit;
	}

	/**
	 * Логи игркоа для модератора
	 *
	 * @param int $playerId
	 */
	private function showAdminLogs($playerId) {

	}

	/**
	 * Профиль NPC из группового боя
	 *
	 * @param int $npcId
	 */
	private function showNpcProfile($npcId) {
		$fightId = abs((int)$this->url[1]);
		$npcId = (int)$npcId;

		$npc = array('id' => NPC_ID, 'accesslevel' => -1);

		if ($fightId > 0) {
			$npc = false;
			$fight = self::$sql->getRecord("SELECT state, players FROM fight WHERE id = " . $fightId);
			if ($fight["players"] == "") { // новый формат данных боев
				$npc = self::$sql->getValue("SELECT data FROM fightplayer WHERE fight = " . $fightId . " AND player = " . $npcId);
				if ($npc) {
					$npc = json_decode($npc, true);
				}
			} else { // старый формат данных боев
				$fightPlayers = json_decode($fight['players'], true);
				$npc = $fightPlayers[$npcId];
			}

			if ($npc) {
				$npc['h'] = 0;
				$npc['s'] = 0;
				$npc['d'] = 0;
				$npc['r'] = 0;
				$npc['i'] = 0;
				$npc['a'] = 0;
				$npc['c'] = 0;

				$npc['procenthp'] = floor($npc['hp'] / $npc['mhp'] * 100);
				$npc['maxhp'] = $npc['mhp'];

				$npc['avatar_without_ext'] = str_replace('.png', '', $npc['av']);

				$npc['fight'] = $fightId;
			}
		}

		$this->content['player'] = $npc;
		$this->content['profile'] = 'npc';

		$this->content['window-name'] = PlayerLang::$windowTitle;
		$this->page->addPart('content', 'player/npc.xsl', $this->content);
	}

	/**
	 * Обработка служебных AJAX запросов
	 */
	private function processAjaxRequest() {
		switch ($this->url[2]) {
			case 'state':
				echo Std::arrayToJson(array(
				'state' => self::$player->state,
				'stateparam' => self::$player->stateparam,
				));
				break;
		}
		exit;
	}

    /**
     * Обработка специальных действий со специальными предметами
     */
    private function processItemSpecial()
    {
        switch ($this->url[1]) {
            case "switch-weapon":
                self::$sql->query("UPDATE inventory SET unlocked = " . (isset($_POST["unlocked"]) ? 1 : 0) . "
                    WHERE player = " . self::$player->id . " AND id = " . (int)$_POST["inventory"]);
                Page::addAlert(PlayerLang::ALERT_OK, PlayerLang::ALERT_ITEM_SWITCH_SAVED);
                break;
            case "voodoo":
				if (!DEV_SERVER) {
					break;
				}
			
                if (self::$player->clan > 0 && self::$player->clan_status != "recruit") {
					// Состоим в клане
					// Проверить а есть ли у нас кукла
					Std::loadMetaObjectClass("inventory");
					$vodooItem = new inventoryObject();
					$vodooItem->loadByCode("voodoo", self::$player->id);
					if ($vodooItem) {
						// Есть!
		                Std::loadMetaObjectClass("diplomacy");
						$warId = diplomacyObject::isAtActiveWar(self::$player->clan);
						if ($warId) {
							// Идёт война
							$war = new diplomacyObject();
							$war->load($warId);
							if ($war->state == "step1") {
								// Идёт первый этап войны
								$enemySide = $war->clan1 == self::$player->clan ? "d" : "a";
								$mySide = $war->clan1 == self::$player->clan ? "a" : "d";
								$enemyClan = $war->clan1 == self::$player->clan ? $war->clan2 : $war->clan1;
								$players = self::$sql->getValueSet("SELECT id FROM player WHERE clan = " . $enemyClan);
								shuffle($players);
								$found = false;
								foreach ($players as $player) {
									if ($war->data[$enemySide][$player]["ks"] < Page::$data['diplomacy']['kills']) {
										// Пропускаем тех их кого уже выбивали зуб куклой
										if (isset($war->data[$enemySide][$player]['kdby']) && is_array($war->data[$enemySide][$player]['kdby'])) {
											foreach ($war->data[$enemySide][$player]['kdby'] as $kill) {
												if ($kill["dl"] == "voodoo") {
													continue 2;
												}
											}
										}
										// Нашли жертву
										$war->data[$enemySide][$player]['ks']++;
										$war->data[$enemySide][$player]['kdby'][] = array('p' => self::$player->id, 'dt' => date('Y-m-d H:i:s', time()), 'dl' => "voodoo");

										// Зачисляем победу
										if (isset($war->data[$mySide][self::$player->id])) {
											$war->data[$mySide][self::$player->id]['kd'][] = array('p' => $player, 'dt' => date('Y-m-d H:i:s', time()), 'dl' => "voodoo");
										} else {
											if (!isset($this->data[$mySide . 'u'])) {
												$war->data[$mySide . 'u'][self::$player->id] = array();
											}
											$war->data[$mySide . 'u'][self::$player->id][] = array('p' => $player, 'dt' => date('Y-m-d H:i:s', time()), 'dl' => "voodoo");
										}

										// Сохраняем статистику войны
										self::$sql->query("UPDATE diplomacy SET data='" . json_encode($war->data) . "' WHERE id=" . $war->id);

										// Получаем данные о жертве и выводим сообщение
										$player = self::$sql->getRecord("SELECT id, clan, clan_status, nickname, level, fraction FROM player WHERE id = " . $player);

										// Выбиваем зуб
										$code = 'war_zub';
										if ($player["clan_status"] == 'founder') {
											$code = 'war_goldenzub';
										}
										Std::loadMetaObjectClass("standard_item");
										$item = new standard_itemObject();
										$item->loadByCode($code);
										$item->makeExampleOrAddDurability(self::$player->id);
										// Вычитаем куклу
										$vodooItem->useWithNoEffect();

										Page::addAlert(PlayerLang::ALERT_OK, Lang::renderText(PlayerLang::ALERT_VOODOO_USED, $player));

										Std::redirect("/player/");
									}
								}
								// Не на кого использовать куклу
								Page::addAlert(PlayerLang::ERROR, PlayerLang::ERROR_ACTION_VOODOO_NO_TARGET);
							} else {
								Page::addAlert(PlayerLang::ERROR, PlayerLang::ERROR_ACTION_VOODOO_DENIED);
							}
						} else {
							Page::addAlert(PlayerLang::ERROR, PlayerLang::ERROR_ACTION_VOODOO_DENIED);
						}
					} else {
						// Нет куклы
						Page::addAlert(PlayerLang::ERROR, PlayerLang::ERROR_ACTION_DENIED);
					}
                } else {
					Page::addAlert(PlayerLang::ERROR, PlayerLang::ERROR_ACTION_VOODOO_DENIED);
				}
                break;
        }
        Std::redirect("/player/");
    }
}
?>