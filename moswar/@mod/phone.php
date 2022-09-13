<?php
class Phone extends Page implements IModule {
	public $moduleCode = 'Phone';

	public function __construct() {
		parent::__construct();
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		$this->needAuth(false);

		Std::loadLib('HtmlTools');

		//
		if ($this->url[0] != 'messages' && $this->url[0] != 'contacts' && $this->url[0] != 'logs' && $this->url[0] != 'duels') {
			$this->url[0] = 'messages';
		}
		if ($this->url[0] == 'messages' && $this->url[1] == 'send' && !is_numeric($this->url[2])) {
			$this->sendMes();
		} elseif ($this->url[0] == 'contacts' && $this->url[1] == 'add' && in_array($_POST['type'], array('victim', 'friend', 'enemy', 'black')) && !is_numeric($this->url[2])) {
			$this->addContact();
		} elseif ($this->url[0] == 'contacts' && $_POST['action'] == 'delete') {
			$this->deleteContact();
		} elseif (($this->url[0] == 'logs' || $this->url[0] == 'duels') && $this->url[1] == 'delete' && is_numeric($this->url[2])) {
			$query = "UPDATE " . Page::$__LOG_TABLE__ . " SET visible = 0 WHERE id = " . $this->url[2] . " AND player = " . self::$player->id . " LIMIT 1";
			$this->sqlQuery($query);
		} elseif ($this->url[0] == 'messages' && $this->url[1] == 'delete') {
			$this->deleteMessage();
		} elseif ($this->url[0] == 'messages' && @$_POST['action'] == 'delete') {
			$this->deleteAllMessages();
		} elseif (($this->url[0] == 'logs' || $this->url[0] == 'duels') && @$_POST['action'] == 'delete') {
			$this->deleteLog();
		} elseif ($this->url[0] == 'messages' && @$_POST['action'] == 'complain') {
			$this->complainMessage();
		}

		$this->show();
		//
		parent::onAfterProcessRequest();
	}

	protected function show() {
		if ($this->url[0] == 'messages') {
			$this->showMessages();
		} elseif ($this->url[0] == 'contacts') {
			$this->showContacts();
		} elseif ($this->url[0] == 'logs') {
			$this->showLogs();
		} elseif ($this->url[0] == 'duels') {
			$this->showDuels();
		}
		$this->content['player'] = self::$player->toArray();
		$this->content['player']['fr'] = $this->content['player']['fraction']{0};
		$this->content['mode'] = $this->url[0];
		$this->page->addPart('content', 'phone/phone.xsl', $this->content);
	}

	private function showMessages() {
		if ($this->url[1] == 'send' && is_numeric($this->url[2])) {
			$player = new playerObject;
			if ($player->load($this->url[2]) !== false) {
				$this->content['nickname'] = htmlspecialchars($player->nickname);
				if ($this->url[3] == 'invite2chat') {
					$this->content['text'] = PhoneLang::$textInviteToChat;
				}
			}
		}
		$i = 1;
		$type = '';
		$this->content["sovet_exists"] = Page::sqlGetCacheValue("SELECT status FROM sovet WHERE player = " . self::$player->id, 3600, 'player_sovet_status_' . Page::$player->id) ? 1 : 0;
		$this->content["clan_exists"] = Page::$player->clan > 0 && Page::$player->clan_status != "recruit" ? 1 : 0;
		if (!$this->content["sovet_exists"]) {
			$this->content["sovet_exists"] = Page::sqlGetCacheValue("SELECT COUNT(1) FROM message m WHERE type = 'sovet_message' AND player2 = " . Page::$player->id . " AND m.visible2 = 1", 3600, 'player_sovet_messages_count_' . Page::$player->id) ? 1: 0;
		}
		if (!$this->content["clan_exists"]) {
			$this->content["clan_exists"] = Page::sqlGetCacheValue("SELECT COUNT(1) FROM message m WHERE type = 'clan_message' AND player2 = " . Page::$player->id . " AND m.visible2 = 1", 3600, 'player_clan_messages_count_' . Page::$player->id) ? 1: 0;
		}
		if ($this->url[1] == "sovet" && !$this->content["sovet_exists"]) {
			$this->url[1] = "inbox";
		}
		if ($this->url[1] == "clan" && !$this->content["clan_exists"]) {
			$this->url[1] = "inbox";
		}
		switch ($this->url[1]) {
			case "outbox" :
				$i++;
				$type = "outbox";
				break;
			case "sovet" :
				$i++;
				$type = "sovet";
				break;
			case "clan" :
				$i++;
				$type = "clan";
				break;
			case "inbox" :
				$i++;
				$type = "inbox";
				break;
			default :
				$unread = self::$sql->getValueSet("select type from message where player2 = " . Page::$player->id . " and `read` = 0 AND visible2 = 1 group by type");
				if ($unread && sizeof($unread)) {
					switch ($unread[0]) {
						case "sovet_message" :
							$type = "sovet";
							break;
						case "clan_message" :
							$type = "clan";
							break;
						case "message" :
							$type = "inbox";
							break;
					}
				} else {
					$type = "inbox";
				}
				break;
		}
		$this->content["submode"] = $type;
		
		if (is_numeric($this->url[$i]) && $this->url[$i] >= 1) {
			$page = $this->url[$i];
		} else {
			$page = 1;
		}
		$perPage = 20;
		$offset = ($page - 1) * $perPage;
//$result = self::$player->loadMessages($offset, $perPage, $type);

		switch ($type) {
			case "outbox" :
				$query = "SELECT m.id, m.player2 as player, m.player player1, m.read, m.text, m.dt, m.type, m.params FROM message m WHERE player = " . self::$player->id . " AND m.visible1 = 1 ORDER BY m.dt DESC ";
				break;
			case "sovet" :
				$query = "SELECT m.id, m.player, m.read, m.text, m.dt, m.type, m.params FROM message m WHERE type = 'sovet_message' AND player2 = " . self::$player->id . " AND m.visible2 = 1 ORDER BY m.dt DESC ";
				break;
			case "clan" :
				$query = "SELECT m.id, m.player, m.read, m.text, m.dt, m.type, m.params FROM message m WHERE type = 'clan_message' AND player2 = " . self::$player->id . " AND m.visible2 = 1 ORDER BY m.dt DESC ";
				break;
			case "inbox" :
			default :
				$query = "SELECT m.id, m.player, m.read, m.text, m.dt, m.type, m.params FROM message m WHERE type IN ('message', 'system_notice') AND player2 = " . self::$player->id . " AND m.visible2 = 1 ORDER BY m.dt DESC ";
				break;
		}
		$query .= "LIMIT " . $offset . ", " . ($perPage + 1);
		$messages = self::$sql->getRecordSet($query);
		$total = $offset + count($messages);

		$new = 0;
		$newIds = array();
		$playerIds = array();
		if (is_array($messages) && count($messages)) {
			foreach ($messages as $key => &$message) {
				if ($key == count($logs)-1) {
					unset($messages[$key]);
					continue;
				}
				$playerIds[$message['player']] = 1;
				
				$params = json_decode($message['params'], true);
				$message['params'] = $params;
				$message['datetime'] = HtmlTools::FormatDateTime($message['dt'], true, false, false);
				$message['fractionTitle'] = Page::$data['fractions'][$message['fraction']];
				if ($message['read'] == 0) {
					$new++;
					$newIds[] = $message['id'];
				}
				$message['text'] = nl2br(strip_tags($message['text']));


				preg_match_all("~(http://(www\.)?(" . str_replace(".", "\.", implode($GLOBALS["configWhiteLinks"], "|")) . ")[\w\/\?\-\_\+\\\=\d\.\&#]*)~", $message['text'], $matches);
				$l = 0;
				for ($j = 0; $j < count($matches[1]); $j ++) {
					$match = $matches[1][$j];
					if (strlen($match) > 60) {
						$link = 'http://' . substr($match, 7, max(strpos($match, '/', 7) - 7, 25)) . '<b>...</b>' . substr($match, -20);
					} else {
						$link = $match;
					}
					//$message['text'] = str_replace($match, "<noindex><a href=\"" . $match . "\" target=\"_blank\"> " . $link . "</a> </noindex>", $message['text']);
					$n = "<noindex><a href=\"" . $match . "\" target=\"_blank\"> " . $link . "</a> </noindex>";
					$p = strpos($message['text'], $match, $l);
					$message['text'] = substr($message['text'], 0, $p) . $n . substr($message['text'], $p + strlen($match));
					$l = $p + strlen($n) - strlen($match);
				}
			}
			$playerIds = CacheManager::getSet('player_small', 'player_id', array_keys($playerIds));
			$clanIds = array();
			foreach ($playerIds as $p) {
				if ($p['clan_id']) {
					$clanIds[$p['clan_id']] = 1;
				}
			}
			$clanIds = CacheManager::getSet('clan_shortinfo', 'clan_id', array_keys($clanIds));
			
			foreach ($messages as $key => &$message) {
				$p = $playerIds[$message['player']];
				//var_dump($p);
				$message['lastactivitytime'] = $p['lastactivitytime'];
				if (strtotime($message['lastactivitytime']) >= time() - 900) {
					$message['status'] = 'online';
				} else {
					$message['status'] = 'offline';
				}
				$params = $message['params'];
				if (($type == 'outbox' && isset($params['pf'])) || (($type == 'inbox' || $type == 'sovet' || $type == 'clan') && isset($params['pt']))) {
					if ($type == 'clan' && $message['type'] == 'clan_message') {
						$message['player'] = $params['pf'];
						$message['playerdir'] = 1;
					} elseif ($type == 'sovet' && $message['type'] == 'sovet_message') {
						$message['player'] = $params['pf'];
						$message['playerdir'] = 1;
					} elseif ($type == 'inbox') {
						$message['player'] = $params['pf'];
					} else {
						$message['player'] = $params['pt']; //($type == 'outbox' && $message['type'] != 'clan_message' ? $params['pt'] : $params['pf']);
						$message['playerdir'] = 2;
					}
				} else {
					$message['player'] = array('id' => $message['player'], 'nm' => $p['nickname'], 'lv' => $p['level'], 'fr' => $p['fraction']{0}, 'cl' => array('id' => @$clanIds[$p['clan_id']]['id'], 'nm' => @$clanIds[$p['clan_id']]['name']));
				}
			}
		}
		if ($new > 0 && $type != 'outbox') {
			self::$sql->query("UPDATE `message` SET `read` = 1 WHERE id IN (" . implode(", ", $newIds) . ")");
			self::$cache->set('players/' . self::$player->id . '/newmessages', 0, 10);

			self::$player2->newmes = 0;
			self::$player2->save(self::$player2->id, array(player2Object::$NEWMES));
		}
		$this->content['total'] = $total;
		$this->content['page'] = $page;
		$this->content['allpages'] = ceil($total / $perPage);
		$this->content['pages'] = Page::generatePages($page, ceil($total / $perPage), 3);
		$this->content['messages'] = $messages;
		$this->content['newmessages'] = $new;
		$this->content['window-name'] = PhoneLang::$windowTitleMessages;
		
		$this->content['maxtextsize'] = self::getMaxTextSize();

		$this->content['timeout1'] = self::$player->level < 7 && time() - strtotime(self::$player2->lastmesdt) < 60 ? 1 : 0;
	}

	private function showContacts() {
		if ($this->url[1] == 'add' && is_numeric($this->url[2])) {
			$player = new playerObject;
			if ($player->load($this->url[2]) !== false) {
				$this->content['nickname'] = htmlspecialchars($player->nickname);
			}
		}
		Std::loadMetaObjectClass('contact');

		switch ($this->url[1]) {
			case "enemies" : $type = "enemy";  $submode = $this->url[1]; break;
			case "friends" : $type = "friend"; $submode = $this->url[1]; break;
			case "blacks" : $type = "black";  $submode = $this->url[1]; break;
			case "referers" : $type = "referer";  $submode = $this->url[1]; break;
			case "victims" : default : $type = "victim"; $submode = "victims"; break;
		}

		if (is_numeric($this->url[2]) && $this->url[2] > 0) {
			$page = (int) $this->url[2];
		} else {
			$page = 1;
		}

		$perPage = 40;
		$offset = ($page - 1) * $perPage;

		$contacts = self::$sql->getRecordSet("SELECT co.*, p.id, p.nickname, p.lastactivitytime, p.level, p.fraction, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan_id, c.name as clan_name FROM contact co INNER JOIN player p ON p.id = co.player2 LEFT JOIN clan c ON c.id = p.clan WHERE co.type = '" . $type . "' and co.player = " . self::$player->id . " limit " . $offset . ", " . $perPage);
		$total = self::$sql->getValue("SELECT count(co.id) FROM contact co INNER JOIN player p ON p.id = co.player2 WHERE co.type = '" . $type . "' and co.player = " . self::$player->id);
		
		//$victims = $enemies = $friends = $referers = $blacks = array();
		$count = count($contacts);
		if (is_array ($contacts) && $count)
			for($i = 0; $i < $count; $i++) {
				if (strtotime($contacts[$i]['lastactivitytime']) >= time() - 900) {
					$contacts[$i]['status'] = 'online';
				} else {
					$contacts[$i]['status'] = 'offline';
				}
				$contacts[$i]["fractionTitle"] = Page::$data["fractions"][$contacts[$i]["fraction"]];
				/*
				if ($contact['type'] == 'enemy') {
					$enemies[] = $contact;
				} else if ($contact['type'] == 'friend') {
					$friends[] = $contact;
				} else if ($contact['type'] == 'victim') {
					$victims[] = $contact;
				} else if ($contact['type'] == 'black') {
					$blacks[] = $contact;
				} else if ($contact['type'] == 'referer') {
					$referers[] = $contact;
				}
				*/
			}

		//$this->content['victims'] = $victims;
		//$this->content['enemies'] = $enemies;
		//$this->content['friends'] = $friends;
		//$this->content['blacks'] = $blacks;
		//$this->content['referers'] = $referers;
		$this->content["contacts"] = $contacts;
		$this->content["submode"] = $submode;
		$this->content["pages"] = Page::generatePages($page, ceil($total / $perPage), 8);
		$this->content["page"] = $page;

		$this->content['window-name'] = PhoneLang::$windowTitleContacts;
	}

	public static function generateDates() {
		$t = mktime(0, 0, 0);
		$startDt = max(strtotime('2011-01-21 00:00:00'), $t - 86400*14);
		$endDt = $t;
		$dates = array();
		for ($i = $endDt; $i >= $startDt; $i -= 86400) {
			if ($t - $i < 86400) {
				$title = 'Сегодня';
			} else if ($t - $i < 86400*2) {
				$title = 'Вчера';
			} else {
				$title = date('d/m', $i);
			}
			$dates[] = array('dt' => date('Ymd', $i), 'title' => $title);
		}
		return $dates;
	}

	private function showLogs() {
		$i = 1;
		if (is_numeric($this->url[$i]) && strlen($this->url[$i]) == 8) {
			$dt = $this->url[$i];
			$i ++;
		} else {
			$dt = date('Ymd');
		}
		if (is_numeric($this->url[$i]) && $this->url[$i] >= 1) {
			$page = $this->url[$i];
		} else {
			$page = 1;
		}
		$perPage = 20;
		$offset = ($page - 1) * $perPage;

		//$result = self::$player->loadLog($offset, $perPage, $type);
		//$logs = $result['logs'];

		$query = "SELECT * FROM log" . $dt . " WHERE player = " . self::$player->id . "
            AND type NOT IN ('fight_attacked','fight_defended','fighthntclb')
            ORDER BY id DESC" . (($perPage > 0) ? (" LIMIT " . $offset . ", " . ($perPage + 1) ) : "");
		$logs = self::$sql->getRecordSet($query);
		//$total = self::$sql->getValue("SELECT found_rows()");
		$total = $offset + count($logs);
		$new = 0;
		if (is_array($logs) && count($logs)) {
			foreach ($logs as $key => &$log) {
				if ($key == count($logs)-1 && $key >= $perPage) {
					unset($logs[$key]);
					continue;
				}
				$log['params'] = json_decode($log['params'], true);
				$log['datetime'] = HtmlTools::FormatDateTime($log['dt'], true, false, false, true);
				if ($log['read'] == 0) {
					$new ++;
					$newIds[] = $log['id'];
				}
				if ($log['type'] == 'nprstnew' && $log['params']['m'] > 0) {
					$log['word_games'] = HtmlTools::russianNumeral($log['params']['g2'] + $log['params']['g9'], 'игру', 'игры', 'игр');
			}
			}
			if ($new > 0) {
				self::$sql->query("UPDATE `log" . $dt . "` SET `read` = 1 WHERE id IN (" . implode(", ", $newIds) . ")");
			}
		}
		
		if (self::$player2->newlogs > 0) {
			self::$player2->newlogs = 0;
			self::$player2->save(self::$player2->id, array(player2Object::$NEWLOGS));
		}
		//self::$sql->query("UPDATE `log` SET `read` = 1 WHERE `player` = " . self::$player->id . " AND `read`=0 AND type NOT IN ('fight_attacked','fight_defended','fighthntclb')");
		//self::$cache->set('players/' . self::$player->id . '/newlogs', 0, 10);

		$this->content['total'] = $total;
		$this->content['page'] = $page;
		$this->content['allpages'] = ceil($total / $perPage);
		$this->content['pages'] = Page::generatePages($page, ceil($total / $perPage), 3);
		$this->content['logs'] = $logs;
		$this->content['dt'] = $dt;
		$this->content['dates'] = self::generateDates();
		$this->content['window-name'] = PhoneLang::$windowTitleLogs;
	}

	private function showDuels() {
		$i = 1;
		if (is_numeric($this->url[$i]) && strlen($this->url[$i]) == 8) {
			$dt = $this->url[$i];
			$i ++;
		} else {
			$dt = date('Ymd');
		}
		if (is_numeric($this->url[$i]) && $this->url[$i] >= 1) {
			$page = $this->url[$i];
		} else {
			$page = 1;
		}
		$perPage = 20;
		$offset = ($page - 1) * $perPage;

		//$result = self::$player->loadLog($offset, $perPage, $type);
		//$logs = $result['logs'];


		//$logs = $this->sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS * FROM log WHERE player = " . $this->id . " AND time <= " . time() . " " . (($type == 'all') ? '' : "AND visible = 1") . " ORDER BY time DESC" .
			$logs = self::$sql->getRecordSet("SELECT * FROM log" . $dt . " WHERE player = " . self::$player->id . "
            AND type IN ('fight_attacked','fight_defended','fighthntclb')
            ORDER BY dt DESC " . (($perPage > 0) ? (" LIMIT " . $offset . ", " . ($perPage + 1) ) : "")
			);
		//$total = self::$sql->getValue("SELECT found_rows()");
		$total = $offset + count($logs);
		$newIds = array();
		$new = 0;
		if (is_array($logs) && count($logs)) {
			foreach ($logs as &$log) {
				$log['params'] = json_decode($log['params'], true);
				if ($log['type'] == 'fighthntclb') {
					$log['params']['sk'] = Page::generateKeyForDuel($log['params']['dl']);
				} else {
					$log['params']['secretkey'] = Page::generateKeyForDuel($log['params']['fight_id']);
				}
				if ($log['params']['werewolf'] == 1 && $log['type'] == 'fight_defended') {
					$log['params']['player']['id'] = 0;
					$log['params']['player']['fr'] = 'w';
				}
				
				if ($log['read'] == 0) {
					$new ++;
					$newIds[] = $log['id'];
				}
			}
			
			if ($new > 0) {
				self::$sql->query("UPDATE `log" . $dt . "` SET `read` = 1 WHERE id IN (" . implode(", ", $newIds) . ")");
			}
		}
		//self::$sql->query("UPDATE `log` SET `read` = 1 WHERE `player` = " . self::$player->id . " AND `read`=0 AND type IN ('fight_attacked','fight_defended','fighthntclb')");
		//self::$cache->set('players/' . self::$player->id . '/newlogs', 0, 10);
		//$result = array('logs' => $logs, 'total' => $total);
		if (self::$player2->newduellogs > 0) {
			self::$player2->newduellogs = 0;
			self::$player2->save(self::$player2->id, array(player2Object::$NEWDUELLOGS));
		}
		
		if (is_array($logs) && count($logs)) {
			foreach ($logs as &$log) {
				$log['datetime'] = HtmlTools::FormatDateTime($log['dt'], true, false, false, true);
			}
		}
		$this->content['total'] = $total;
		$this->content['page'] = $page;
		$this->content['allpages'] = ceil($total / $perPage);
		$this->content['pages'] = Page::generatePages($page, ceil($total / $perPage), 3);
		$this->content['logs'] = $logs;
		$this->content['dt'] = $dt;
		$this->content['dates'] = self::generateDates();
		$this->content['window-name'] = PhoneLang::$windowTitleDuels;

	}

	private function sendMes() {
		if (mb_strlen($_POST['name'], "UTF-8") < 3) {
			//$this->content['message'] = 'no_player';
			$this->content['result'] = 0;
			$this->content['action'] = 'send';
			//$this->content['error'] = 'no_player';
			Page::addAlert(PhoneLang::$error, PhoneLang::$errorNoPlayer2, ALERT_ERROR);
		} else {
			//$playerId = Page::getPlayerId($_POST['name']);
			$player = Page::$sql->getRecord("SELECT id, accesslevel FROM player WHERE nickname = '" . Std::cleanString($_POST['name']) . "'");
			if (!$player || $player['id'] === false) {
				$this->content['result'] = 0;
				$this->content['action'] = 'send';
				Page::addAlert(PhoneLang::$error, Lang::renderText(PhoneLang::$errorNoPlayerWithName, array('name' => Std::cleanString($_POST['name']))), ALERT_ERROR);
			} elseif ($player['accesslevel'] < 0) {
				$this->content['result'] = 0;
				$this->content['action'] = 'send';
				Page::addAlert(PhoneLang::$error, PhoneLang::$errorPlayerBlocked, ALERT_ERROR);
			} else {
				$messageId = Page::sendMessage(self::$player->id, $player['id'], $_POST['text'], "message", false);
				if ($messageId < 0) {
					if ($messageId == -1) {
						$this->content['result'] = 0;
						$this->content['action'] = 'send';
					} elseif ($messageId == -2) {
						$this->content['result'] = 0;
						$this->content['action'] = 'send';
					} elseif ($messageId == -3) {
						$result = array('type' => 'phone', 'action' => 'send message');
						$result['result'] = 0;
						$result['error'] = 'mute';
						Runtime::set('content/result', $result);
						Std::redirect('/phone/messages/');
					} elseif ($messageId == -4) {
						$result = array('type' => 'phone', 'action' => 'send message');
						$result['result'] = 0;
						Runtime::set('content/result', $result);
						Std::redirect('/phone/messages/');
					} elseif ($messageId == -5) {
						$result = array('type' => 'phone', 'action' => 'send message');
						$result['result'] = 0;
						Runtime::set('content/result', $result);
						Std::redirect('/phone/messages/');
					}
					return false;
				}

				if (!$visible2) {
					Std::loadMetaObjectClass('message2');
					$mes2 = new message2Object();
					$mes2->message = $messageId;
					$mes2->player = self::$player->id;
					$mes2->player2 = $player['id'];
					$mes2->dt = date('Y-m-d H:i', time());
					$mes2->text = $_POST['text'];
					$mes2->zlo = '';
					$mes2->save();
				}

				//$this->content['message'] = 'sent';
				$result = array('result' => 1, 'action' => 'send');
				Runtime::set('content', $result);
				Std::redirect('/phone/messages/');
				//$this->content['result'] = 1;
				//$this->content['action'] = 'send';
			}
		}
	}

	private function complainMessage() {
		if (is_numeric($_POST['id'])) {
			$message = $this->sqlGetRecord("SELECT m.id, m.player, m.dt, m.text, p.level, p.nickname FROM message m LEFT JOIN player p ON p.id = m.player WHERE m.player2 = " . self::$player->id . " AND m.id = " . $_POST['id'] . " LIMIT 1");
			if ($message != false) {
				Std::loadMetaObjectClass("post");
				$post = new postObject();
				$post->text = htmlspecialchars("Жалоба на письмо #" . $message['id'] . " от игрока " . $message['nickname'] . "[" . $message['level'] . "] http://moswar.ru/player/" . $message['player'] . "/ от " . HtmlTools::FormatDateTime($message['dt'], true, false, false) . ":\r\n[i]" . $message['text'] . '[/i]');
				$post->topic = 797;
				$post->player = Runtime::$uid;
				$post->playerdata = json_encode(self::$player->exportForForum());
				$post->dt = date('Y-m-d H:i:s', time());
				$post->save();
			}
			$query = "UPDATE message SET visible2 = 0 WHERE id = " . $_POST['id'] . " AND player2 = " . self::$player->id . " LIMIT 1";
			$this->sqlQuery($query);
			$this->content['action'] = 'complain';
			$this->content['result'] = 1;
		}
	}

	private function addContact() {
		$playerId = Page::getPlayerId($_POST['name']);
		if ($playerId === false) {
			Page::addAlert(PhoneLang::$windowTitleContacts, PhoneLang::$errorContactNoPlayer);
		} else {
			if ($this->sqlGetValue("SELECT count(*) FROM `contact` WHERE `player` = " . self::$player->id . " AND `player2` = " . $playerId . " AND type!='referer' LIMIT 1") == 1) {
				Page::addAlert(PhoneLang::$windowTitleContacts, PhoneLang::$errorContactExists);
			} else {
				Std::loadMetaObjectClass('contact');
				Page::addAlert(PhoneLang::$windowTitleContacts, PhoneLang::$errorContactAdded);
				$contact = new contactObject;
				$contact->player = self::$player->id;
				$contact->player2 = $playerId;
				$contact->type = $_POST['type'];
				$contact->info = htmlspecialchars($_POST['info']);
				$contact->save();
				$this->content['message'] = 'added';
			}
		}
		$submodes = array("friend" => "friends", "enemy" => "enemies", "black" => "blacks", "victim" => "victims", "referer" => "referes");
		Std::redirect("/phone/contacts/" . $submodes[$_POST['type']] . "/");
	}

	private function deleteContact() {
		if (is_numeric($_POST['id'])) {
			$this->content['action'] = 'delete';
			$this->content['result'] = array();
			$this->content['result']['result'] = 1;
			$this->content['result']['nickname'] = $_POST['nickname'];
			$type = self::$sql->getValue("SELECT type FROM contact WHERE player = " . self::$player->id . " AND player2 = " . (int)$_POST['id'] . " AND type " . ($_POST['type'] == 'referer' ? '' : '!') . "= 'referer'");
			self::$sql->query("DELETE FROM contact WHERE player = " . self::$player->id . " AND player2 = " . (int)$_POST['id'] . " AND type " . ($_POST['type'] == 'referer' ? '' : '!') . "= 'referer' LIMIT 1");
			$submodes = array("friend" => "friends", "enemy" => "enemies", "black" => "blacks", "victim" => "victims", "referer" => "referes");
			Std::redirect("/phone/contacts/" . $submodes[$type] . "/");
		}
	}

	private function deleteMessage() {
		if (is_numeric($this->url[2])) {
			self::$sql->query("UPDATE message SET visible1 = 0 WHERE id = " . $this->url[2] . " AND player = " . self::$player->id . " LIMIT 1");
			$result = mysql_affected_rows();
			if ($result != 1) {
				self::$sql->query("UPDATE message SET visible2 = 0 WHERE id = " . $this->url[2] . " AND player2 = " . self::$player->id . " LIMIT 1");
			} else {
				$this->url[1] = 'outbox';
				$this->url[2] = 1;
			}
			$this->content['result'] = 1;
			$this->content['action'] = 'delete';
			Page::sqlGetCacheValue("SELECT COUNT(1) FROM message m WHERE type = 'sovet_message' AND player2 = " . Page::$player->id . " AND m.visible2 = 1", 3600, 'player_sovet_messages_count_' . Page::$player->id) ? 1: 0;
			Page::sqlGetCacheValue("SELECT COUNT(1) FROM message m WHERE type = 'clan_message' AND player2 = " . Page::$player->id . " AND m.visible2 = 1", 3600, 'player_clan_messages_count_' . Page::$player->id) ? 1: 0;
		}
	}

	private function deleteAllMessages() {
		$query = "UPDATE message SET ";
		switch ($this->url[1]) {
			case "outbox" :
				$query .= "visible1 = 0 WHERE player = " . self::$player->id;
				break;
			case "clan" :
				$query .= "visible2 = 0 WHERE type = 'clan_message' AND player2 = " . self::$player->id;
				Page::$cache->set('player_clan_messages_count_' . Page::$player->id, 0, 3600);
				break;
			case "sovet" :
				$query .= "visible2 = 0 WHERE type = 'sovet_message' AND player2 = " . self::$player->id;
				Page::$cache->set('player_sovet_messages_count_' . Page::$player->id, 0, 3600);
				break;
			case "inbox" :
				default :
				$query .= "visible2 = 0 WHERE  type IN ('message', 'system_notice') AND player2 = " . self::$player->id;
				break;
		}
		$this->sqlQuery($query);
		if ($this->url[1] != 'outbox') {
			self::$sql->query("UPDATE player2 SET newmes = (SELECT COUNT(1) FROM message WHERE `read` = 0 AND player2 = " . self::$player->id . " AND visible2 = 1) WHERE player = " . self::$player->id);
		}
		$this->content['action'] = 'deleteall';
		$this->content['result'] = 1;
	}

	private function deleteLog() {
		self::$sql->query("UPDATE " . Page::$__LOG_TABLE__ . " SET visible = 0 WHERE player = " . self::$player->id);
		$this->content['action'] = 'deleteall';
		$this->content['result'] = 1;
	}
}
?>