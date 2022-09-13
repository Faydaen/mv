<?php
class Chat extends Page implements IModule
{
    public $moduleCode = 'Chat';

    public $channels = array('general' => 'Общий', 'private' => 'Приват', 'fraction' => '', 'clan' => 'Клановый', 'battle' => 'Боевой', 'quiz' => 'Викторина', 'noobs' => 'Детсад');
	public $rooms = array(
		'general' => array('title' => 'Центральный зал',	'link' => 'general',	'hint' => 'общая комната для всех'),
		'noobs' => array('title' => 'Детсад',				'link' => 'noobs',		'hint' => 'комната для новичков'),
		'quiz' => array('title' => 'Викторина',				'link' => 'quiz',		'hint' => 'для знатоков и эрудитов'),
		'resident' => array('title' => 'Красная площадь',	'link' => 'resident',	'hint' => 'только для коренных'),
		'arrived' => array('title' => 'Вокзал',				'link' => 'arrived',	'hint' => 'только для понаехавших'),
		'male' => array('title' => 'Паб',					'link' => 'male',		'hint' => 'только для мужчин'),
		'female' => array('title' => 'Будуар',				'link' => 'female',		'hint' => 'вход только для дам'),
		'battle' => array('title' => 'Боевая',				'link' => 'battle',		'hint' => 'для участников группового боя'),
		'clan' => array('title' => 'Клан-центр',			'link' => 'clan',		'hint' => 'только для кланеров'),
		'union' => array('title' => 'Союзный двор',			'link' => 'union',		'hint' => 'для общения с союзниками'),
	);
    public $idletime = 180;

	private $smiles = array('angel','angry','angry2','applause','attention','box','bye','chase','child','crazy','cry','dance','dance2','dance3','dance4','devil',
        'dontknow','flag','girl','gun','gun2','gun3','gun4','gun5','gun6','gun7','gun8','hello','hello2','holiday','holiday2','kiss','kiss2','kiss3','lol',
        'love','love2','molotok','music','music2','play','police','punk','rtfm','rtfm2','skull','sleep','smoke','smoke2','sport','sumo','tema','tounge','wall',
        'why','yessir','zver','popcorn','winner','mol','strah','haha');

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
		parent::onBeforeProcessRequest();
		$this->needAuth(false);
		//
		$ajax = true;
		if ($_POST['action'] == 'loadmessages' || $_POST['action'] == 'loadusers' || $_POST['action'] == 'send') {
			self::$player->chat_time = time();
			self::$player->save(self::$player->id, array(playerObject::$CHAT_TIME));
		}
		if ($_POST['action'] == 'loadmessages') {
			$messages = $this->loadMessages((string) @$_POST['type']);
			echo str_replace("'", "\\'", json_encode($messages));
			exit;
		} else if ($_POST['action'] == 'loadusers') {
			$users = $this->loadUsers();
			echo json_encode($users);
			exit;
		} else if ($_POST['action'] == 'send') {
			$_POST['text'] = wordwrap(trim($_POST['text']), 50, ' ', true);
			if (strlen($_POST['text']) == 0) {
				exit;
			}

			if (self::$player2->chatcaptcha == 0) {
				$result = array('error' => 'no_captcha');
				echo json_encode($result);
				exit;
			}

			if (self::$player->level > 1 && (strpos($_POST['text'], 'to [clan]') !== false || strpos($_POST['text'], 'private [clan]') !== false)) {
				if (self::$player->clan == 0 || self::$player->clan_status == 'recruit') {
					$result = array('error' => 'no_clan');
					echo json_encode($result);
					exit;
				}
				$channel = 'clan';
			}/* else if (strpos($_POST['text'], 'to [battle]') !== false || strpos($_POST['text'], 'private [battle]') !== false) {
				if (self::$player->state != 'fight') {
					$messages = array();
					$messages[] = array('type' => 'battle', 'time' => date('H:i:s'), 'player_from' => self::$player->id, 'player_from_nickname' => self::$player->nickname, 'text' => $_POST['text']);
					$messages[] = array('type' => 'system', 'time' => date('H:i:s'), 'text' => 'Вы сейчас не находитесь ни в каком бою.');
					echo json_encode($messages);
					exit;
				}
				$channel = 'battle_' . self::$player->fraction;
			}*/ else if (strpos($_POST['text'], 'private [') === 0) {
				$channel = 'private';
			} else if (self::$player->chatroom == 'battle_resident' || self::$player->chatroom == 'battle_arrived') {
				$channel = $this->getFightRoom();
			} else {
				$channel = self::$player->chatroom;
			}
			/*
			else if (self::$player->level > 1 && (strpos($_POST['text'], 'to [side]') !== false || strpos($_POST['text'], 'private [side]') !== false)) {
				$channel = self::$player->fraction;
			} else if (self::$player->level > 1 && (strpos($_POST['text'], 'to [quiz]') !== false || strpos($_POST['text'], 'private [quiz]') !== false)) {
				if (false && Page::$cache->get("quiz") != 'on') {
					$messages = array();
					$messages[] = array('type' => 'quiz', 'time' => date('H:i:s'), 'player_from' => self::$player->id, 'player_from_nickname' => self::$player->nickname, 'text' => $_POST['text']);
					$messages[] = array('type' => 'system', 'time' => date('H:i:s'), 'text' => 'В данный момент викторина не проводится.');
					echo json_encode($messages);
					exit;
				}
				$channel = 'quiz';
			} else if (strpos($_POST['text'], 'to [noobs]') !== false || strpos($_POST['text'], 'private [noobs]') !== false) {
				$channel = 'noobs';
			} else if (self::$player->level == 1) {
				$channel = 'noobs';
			} else {
				$channel = 'general';
			}*/

			if (self::$player->mute_chat > time()) {
				$result = array('error' => 'mute', 'endtime' => date('d.m.Y H:i:s', self::$player->mute_chat));
				echo json_encode($result);
				exit;
			} else if (self::$player->isolate_chat > time() || self::filterBadWords($_POST['text'])) {
				$result = $messages[] = array('type' => $channel, 'time' => date('H:i:s'), 'player_from' => self::$player->id, 'player_from_nickname' => self::$player->nickname, 'text' => $_POST['text'], 'player_to' => $id);
				$messages = array_merge($messages, $this->loadMessages());
				echo str_replace("'", "\\'", json_encode($messages));
				exit;
			}

			if (Page::$sql->getValue("select count(1) from chatlog where player_from = " . self::$player->id . " and time > " . (time() - 15)) > 5) {
				self::$player->mute_chat = time() + 60 * 15;
				self::$player->save(self::$player->id, array(playerObject::$CHAT_MUTE));
				$result = array('error' => 'automute', 'endtime' => date('d.m.Y H:i:s', time() + 60 * 15));
				echo json_encode($result);
				exit;
			}
			
			Std::loadMetaObjectClass('chatlog');
			$_POST['text'] = trim(htmlspecialchars($_POST['text']));
			$messages = array();
			if ($channel == 'private') {
				preg_match_all('~private\s?\[([^\]]+)\]~', $_POST['text'], $nicknames);
				$nicknames = $nicknames[1];
				//$_POST['text'] = trim(substr($_POST['text'], strpos($_POST['text'], ']') + 1));
				if (strlen($_POST['text']) == 0) {
					$result = array('error' => 'no_text');
					echo json_encode($result);
					exit;
				}
				$info = page::$sql->getRecordSet("select id, chat_time, nickname from player where nickname in ('" . implode("', '", $nicknames) . "')");
				$nicknamesInfo = array();
				foreach ($info as $i) {
					$nicknamesInfo[$i['nickname']] = array('id' => $i['id'], 'chat_time' => $i['chat_time']);
				}
				
				foreach ($nicknames as $nickname) {
					if (!isset($nicknamesInfo[$nickname])) {
						$messages[] = array('type' => 'private', 'time' => date('H:i:s'), 'player_from' => self::$player->id, 'player_from_nickname' => self::$player->nickname, 'text' => $_POST['text'], 'player_to' => $id);
						$messages[] = array('type' => 'system', 'time' => date('H:i:s'), 'text' => 'Игрок <b>' . $nickname . '</b> не найден.');
					}
					$chatlog = new chatlogObject();
					$chatlog->type = $channel;
					$chatlog->text = $_POST['text'];
					$chatlog->time = time();
					$chatlog->player_from = self::$player->id;
					$chatlog->player_from_nickname = self::$player->nickname;
					$chatlog->player_to = $nicknamesInfo[$nickname]['id'];
					$chatlog->save();

					if ($nicknamesInfo[$nickname]['chat_time'] < time() - $this->idletime) {
						$message = array('type' => 'system', 'time' => date('H:i:s'), 'player_from' => self::$player->id, 'player_from_nickname' => self::$player->nickname, 'player_from' => 0, 'text' => 'player_not_in_chat', 'player_to' => $nicknamesInfo[$nickname]['id'], 'player_to_nickname' => $nickname);
						$messages[] = $message;
					}
				}
			} else {
				if ($channel == 'quiz') {
					$answer = mb_strtolower(trim(str_replace(array('to [quiz]', 'private [quiz]'), '', $_POST['text'])), 'UTF-8');
					if ($answer == '.score' || $answer == '.s' || $answer == '.очки' || $answer == '.о') {
						$scores = Page::$sql->getRecordSet("SELECT qr.current, p.nickname FROM quiz_results qr LEFT JOIN player p ON p.id = qr.player WHERE qr.current > 0 ORDER BY qr.current DESC LIMIT 5");
						if ($scores) {
							$message = 'Лучшие отвечающие в этой викторине: ';
							$i = 1;
							foreach ($scores as $s) {
								$message .= $s['nickname'] . ' - ' . $s['current'];
								if ($i < count($scores)) {
									$message .= ', ';
								}
								$i ++;
							}
							$message .= '.';
						} else {
							$message = 'В этой викторине пока никто не дал ни одного правильного ответа.';
						}
						$messages = array();
						$messages[] = array('type' => 'quiz', 'time' => date('H:i:s'), 'player_from' => 0, 'player_from_nickname' => 'Викторина', 'text' => $message);
						echo json_encode($messages);
						exit;
					}
				}
				$chatlog = new chatlogObject();
				$chatlog->type = $channel;
				$chatlog->text = $_POST['text'];
				$chatlog->time = time();
				$chatlog->player_from = self::$player->id;
				$chatlog->player_from_nickname = self::$player->nickname;
				if ($channel == 'private') {
					$chatlog->player_to = $id;
					$chatlog->player_to_nickname = $nickname;
				} else if ($channel == 'fraction') {
					$chatlog->channel = self::$player->fraction;
				} else if ($channel == 'clan') {
					$chatlog->clan_to = self::$player->clan;
				} else if ($channel == 'battle_resident' || $channel == 'battle_arrived') {
					if (self::$player->state == 'fight') {
						$fight = self::$player->stateparam;
					} else {
						$fight = Page::sqlGetCacheValue("select fp.fight from fightplayer fp inner join fight f on f.id = fp.fight and f.state = 'created' where fp.player = " . self::$player->id, 90);
					}
					$chatlog->battle_to = $fight;
				}
				$chatlog->save();
				if ($channel == 'quiz') {
					if (Page::$cache->get("quiz_state") == 'question_asked') {
						if ($answer == mb_strtolower(Page::$cache->get("quiz_answer"), 'UTF-8')) {
							$chatlog = new chatlogObject();
							$chatlog->type = 'quiz';
							$chatlog->text = 'Игрок ' . self::$player->nickname . ' первым отвечает правильно и получает 1 очко. Переходим к следующему вопросу.';
							$chatlog->time = time();
							$chatlog->player_from = 0;
							$chatlog->player_from_nickname = 'Викторина';
							$chatlog->save();
							Page::$sql->query("insert into quiz_results (player, wins, total, current) values(" . self::$player->id . ", 0, 1, 1) on duplicate key update current = current + 1, total = total + 1");
							echo '/*' . mysql_error() . '*/';
							Page::$cache->set('quiz_state', 'question_answered', 300);
						}
					}
				}
			}
			$messages = array_merge($messages, $this->loadMessages());
			echo str_replace("'", "\\'", json_encode($messages));
			exit;
		} else if ($this->url[0] == 'chat') {
			$ajax = false;
			$this->showChat($this->url[1]);
		} else if ($this->url[0] == 'rooms') {
			$ajax = false;
			$this->showRooms();
		} else if ($this->url[0] == 'moderate') {
			$ajax = false;
			$this->showModerate((int) $this->url[1]);
		} else if ($this->url[0] == 'captcha') {
			$ajax = false;
			$this->showCaptcha();
		} else {
			$ajax = false;
			$this->showFrames();
			/*
			$room = 'noobs';
			if (self::$player->chatroom != '') {
				$room = self::$player->chatroom;
				if ($room == 'battle_resident' || $room == 'battle_arrived') {
					$room = 'battle';
				}
			}
			*/
			//Std::redirect('/chat/on/' . $room . '/');
		}
		//
		if ($ajax === true) {
			exit;
		}
        parent::onAfterProcessRequest();
    }

	public function showCaptcha() {
		if ($_POST['action'] == 'captcha') {
			if ($this->checkCaptcha($_POST['code'])) {
				self::$player2->chatcaptcha = 1;
				self::$player2->save(self::$player2->id, array(player2Object::$CHATCAPTCHA));
				$userInfo = array();
				$key = self::signed(self::$player2->player);
				$userInfo[$key] = array();
				$userInfo[$key]["captcha"] = 1;
				Page::chatUpdateInfo($userInfo);

				$cachePlayer = self::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["captcha"] = 1;
					self::$cache->set("user_chat_" . $key, $cachePlayer);
				}

				Std::redirect('/player/');
			} else {
				$this->content['error'] = 'bad captcha';
			}
		}
		
		$this->content['window-name'] = "Чат";
		$this->content['player'] = self::$player->toArray();
		$this->content['random'] = rand(1000000, 9999999);
        $this->page->addPart('content', 'chat/captcha.xsl', $this->content);
	}

	public function showModerate($playerId) {
		self::$player->loadAccess();
		if (!self::$player->access["player_mute_chat"] && !self::$player->access["player_chat_isolate"]) {
			$this->dieOnError(404);
		}
		$this->content['access-mute'] = self::$player->access["player_mute_chat"];
		$this->content['access-isolate'] = self::$player->access["player_chat_isolate"];

		$this->content['window-name'] = 'Модерирование чата';
		$this->content['target'] = Page::$sql->getRecord("select id, nickname from player where id = " . $playerId);
		$this->page->addPart('content', 'chat/moderate.xsl', $this->content);
	}

	public function showChat($side) {
		if ($side != 'left') {
			$side = 'bottom';
		}

		Runtime::clear('chat');
		self::$player->loadAccess();

		$this->content['player'] = self::$player->toArray();
		$this->content['unixtime'] = time();

		//$this->content['players'] = json_encode($this->loadUsers());
		//$this->content['messages'] = json_encode($this->loadMessages());
		if (self::$player->chatroom == 'battle_' . self::$player->fraction) {
			$this->content['chatname'] = $this->rooms['battle']['title'];
		} else {
			$this->content['chatname'] = $this->rooms[self::$player->chatroom]['title'];
		}

		$this->content['smiles'] = $this->smiles;

		$this->page->setTemplate('empty.html');
		$this->content['window-name'] = 'Чат';
		$this->page->addPart ('content', 'chat/' . $side . '.xsl', $this->content);
	}

	public function showFrames() {
		$room = $this->url[1];
		if ($room == 'battle') {
			$room = 'battle_' . self::$player->fraction;
		}
		self::$player->chatroom = $room;
		self::$player->save(self::$player->id, array(playerObject::$CHATROOM));

		if ($_COOKIE['lasturl']) {
			$url = $_COOKIE['lasturl'];
			setcookie('lasturl', '', time() - 3600*24, '/');
		} else {
			$url = '/';
		}
		if (self::$player2->chatcaptcha == 0) {
			$url = '/chat/captcha/';
		}
		$template = Std::loadTemplate('chat/frames');
		echo Std::renderTemplate($template, array('url' => $url));
		exit;
	}

	public function showRooms() {
		$sql = "SELECT chatroom, COUNT(1) as num
				FROM player
				WHERE chat_time >= " . (time() - $this->idletime) . "
				GROUP BY chatroom";
		//AND (chatroom != 'clan' " . ((self::$player->clan > 0 && self::$player->clan_status != 'recruit') ? "OR (clan_status != 'recruit' AND clan = " . self::$player->clan . ")" : "") . ")
		if (DEV_SERVER) {
			$nums = Page::$sql->getRecordSet($sql);
		} else {
			$nums = Page::sqlGetCacheRecordSet($sql, 60);
		}
		
		$rooms = array();
		unset($this->rooms['battle_' . (self::$player->fraction == 'resident' ? 'arrived' : 'resident')]);
		if ($nums	)
		foreach ($nums as $n) {
			if (!isset($this->rooms[$n['chatroom']])) {
				continue;
			}
			if ($n['chatroom'] != 'clan' && $n['chatroom'] != 'union' && $n['chatroom'] != 'battle_resident' && $n['chatroom'] != 'battle_arrived') {
				$this->rooms[$n['chatroom']]['num'] = $n['num'];
			}
		}
		foreach ($this->rooms as $key => $room) {
			if (self::$player->chatroom == $key && self::$player->chat_time >= time() - $this->idletime) {
				$room['current'] = 1;
			}
			if ($key == 'battle_' . self::$player->fraction) {
				$name = 'battle';
			} else {
				$name = $key;
			}
			$room['name'] = $name;
			if (!isset($room['num']) && $name != 'battle' && $name != 'clan' && $name != 'union') {
				$room['num'] = 0;
			}
			$rooms[] = $room;
		}

		$this->content['rooms'] = $rooms;

		$this->content['window-name'] = 'Чат';
		$this->page->addPart ('content', 'chat/rooms.xsl', $this->content);
	}

	public function getFightRoom() {
		// групповой бой - предбоевой чат (разделение по фракциям)
		// групповой бой - боевой чат (разделение по фракциям)
		// хаотический бой - предбоевой чат (все вместе)
		// хаотический бой - боевой чат (раделение по сторонам)
		// бой за банк - предбоевой чат (все вместе)
		// бой за банк - боевой чат (сторона - a)

		if (self::$player->state == 'fight') {
			$state = 'in';
			$fight = self::$player->stateparam;
			$tmp = Page::sqlGetCacheRecord("select f.type, fp.side from fightplayer fp inner join fight f on f.id = fp.fight and f.state = 'created' where fp.fight = " . $fight . " and fp.player = " . self::$player->id, 90);
			$type = $tmp['type'];
			$side = $tmp['side'];
		} else {
			$state = 'before';
			$tmp = Page::sqlGetCacheRecord("select fp.fight, f.type, fp.side from fightplayer fp inner join fight f on f.id = fp.fight and f.state = 'created' where fp.player = " . self::$player->id, 90);
			$fight = $tmp['fight'];
			$type = $tmp['type'];
			$side = $tmp['side'];
		}
		if (!$tmp) {
			return 'battle_' . self::$player->fraction;
		}
		if ($type == 'flag' || $type == 'test' || $type == 'clanwar' || $type == 'level') {
			$room = self::$player->chatroom;
		} else if ($type == 'chaotic' && $state == 'before') {
			$room = 'battle_resident';
		} else if ($type == 'chaotic' && $state == 'in') {
			if ($side == 'a') {
				$room = 'battle_resident';
			} else {
				$room = 'battle_arrived';
			}
		} else if ($type == 'bank') {
			$room = 'battle_resident';
		}
		return $room;
	}

    public function loadMessages($type = '') {
		//if ($type == 'quiz') {
		//	$id = Runtime::get('chat/lastmessage_quiz');
		//} else {
			$id = Runtime::get('chat/lastmessage');
		//}
		if ($id == false) {
			$limit = 'LIMIT 5';
		} else {
			$limit = '';
			$cond .= ' AND cl.id > ' . $id;
		}
		//$battleCond = '';
		//if (self::$player->state == 'fight') {
		//	$battleCond = "or (cl.type = 'battle_" . self::$player->fraction . "' and cl.battle_to = " . self::$player->stateparam . ")";
		//}
		//if (self::$player->level == 1) {
		//	$query = "SELECT cl.* FROM chatlog cl WHERE ((cl.type = 'noobs') or (cl.type = 'private' and (cl.player_from = " . self::$player->id . " or cl.player_to = " . self::$player->id . ")) or (cl.type = 'system') " . $battleCond . ") " . $cond . " ORDER BY cl.id DESC " . $limit;
		//} else if ($type == 'quiz') {
		//	$query = "SELECT cl.* FROM chatlog cl WHERE cl.type = 'quiz' " . $cond . " ORDER BY cl.id DESC " . $limit;
		//} else {
		//	$query = "SELECT cl.* FROM chatlog cl WHERE ((cl.type = 'general') or (cl.type = 'noobs') or (cl.type = '" . self::$player->fraction . "') " . ((self::$player->clan > 0 && self::$player->clan_status != 'recruit') ? " or (cl.type = 'clan' and cl.clan_to = " . self::$player->clan . ")" : "") . " or (cl.type = 'private' and (cl.player_from = " . self::$player->id . " or cl.player_to = " . self::$player->id . ")) or (cl.type = 'system') or (cl.type = 'quiz') " . $battleCond . ") " . $cond . " ORDER BY cl.id DESC " . $limit;
		//}
		//$query = "SELECT cl.* FROM chatlog cl WHERE ((cl.type = '" . self::$player->chatroom . "') " . ((self::$player->clan > 0 && self::$player->clan_status != 'recruit') ? " or (cl.type = 'clan' and cl.clan_to = " . self::$player->clan . ")" : "") . " or (cl.type = 'private' and (cl.player_from = " . self::$player->id . " or cl.player_to = " . self::$player->id . ")) or (cl.type = 'system') " . $battleCond . ") " . $cond . " ORDER BY cl.id DESC " . $limit;
		if (self::$player->chatroom == 'battle_arrived' || self::$player->chatroom == 'battle_resident') {
			//$roomCond = "(cl.type = '" . self::$player->chatroom . "' and cl.battle_to = " . $fight . ") or";
			if (self::$player->state == 'fight') {
				$fight = self::$player->stateparam;
			} else {
				$fight = Page::sqlGetCacheValue("select fp.fight from fightplayer fp inner join fight f on f.id = fp.fight and f.state = 'created' where fp.player = " . self::$player->id, 90);
			}
			$roomCond = "(cl.type = '" . $this->getFightRoom() . "' and cl.battle_to = " . $fight . ") or";
		} else if (self::$player->chatroom == 'clan') {
			$roomCond = "";
		} else {
			$roomCond = "cl.type = '" . self::$player->chatroom . "' or ";
		}
		$sql = "SELECT cl.* FROM chatlog cl WHERE (" . $roomCond . " " . ((self::$player->clan > 0 && self::$player->clan_status != 'recruit') ? " (cl.type = 'clan' and cl.clan_to = " . self::$player->clan . ") or" : "") . " (cl.type = 'private' and (cl.player_from = " . self::$player->id . " or cl.player_to = " . self::$player->id . ")) or (cl.type = 'system') ) " . $cond . " ORDER BY cl.id DESC " . $limit;
		$messages = $this->sqlGetRecordSet($sql);
		if ($messages === false) {
			return array();
		}
		$messages = array_reverse($messages);
		$id = 0;
		$uniq = array();
		foreach ($messages as $key => &$message) {
			if ($message['type'] == 'private') {
				if (!isset($uniq[md5($message['text'] . $message['time'])])) {
					$uniq[md5($message['text'] . $message['time'])] = 1;
				} else {
					unset($messages[$key]);
					continue;
				}
			}
			$message['time'] = date('H:i:s', $message['time']);
			if ($message['id'] > $id) {
				$id = $message['id'];
			}
			// смайлики
            preg_match_all('/:([\w]+):/mis', $message['text'], $smiles, PREG_SET_ORDER);
            if (sizeof($smiles) > 0) {
                for ($s = 0, $ss = sizeof($smiles); $s < $ss; $s++) {
                    if ($s == 3) {
                        break;
                    }
                    if (in_array($smiles[$s][1], $this->smiles)) {
                        $message['text'] = preg_replace('~' . $smiles[$s][0] . '~', '<img src="/@/images/smile/' . $smiles[$s][1] . '.gif" align="absmiddle" />', $message['text'], 1);
                    }
                }
            }
		}
		if ($type == 'quiz') {
			Runtime::set('chat/lastmessage_quiz', $id);
		} else {
			Runtime::set('chat/lastmessage', $id);
		}
		
		return $messages;
    }

    public function loadUsers() {
		// групповой бой - предбоевой чат (разделение по фракциям)
		// групповой бой - боевой чат (разделение по фракциям)
		// хаотический бой - предбоевой чат (все вместе)
		// хаотический бой - боевой чат (раделение по сторонам)
		// бой за банк - предбоевой чат (все вместе)
		// бой за банк - боевой чат (сторона - a)


		if (self::$player->chatroom == 'battle_arrived' || self::$player->chatroom == 'battle_resident') {
			if (self::$player->state == 'fight') {
				$state = 'in';
				$fight = self::$player->stateparam;
				$tmp = Page::sqlGetCacheRecord("select f.type, fp.side from fightplayer fp inner join fight f on f.id = fp.fight where fp.fight = " . $fight . " and fp.player = " . self::$player->id, 90);
				$type = $tmp['type'];
				$side = $tmp['side'];
			} else {
				$state = 'before';
				$tmp = Page::sqlGetCacheRecord("select fp.fight, f.type, fp.side from fightplayer fp inner join fight f on f.id = fp.fight and f.state = 'created' where fp.player = " . self::$player->id, 90);
				$fight = $tmp['fight'];
				$type = $tmp['type'];
				$side = $tmp['side'];
			}

			if ($type == 'flag' || $type == 'test' || $type == 'clanwar' || $type == 'level') {
				if ($state == 'before') {
					$sql = "SELECT p.id, p.nickname, p.fraction, IF(p.clan > 0 and p.clan_status != 'recruit', p.clan, 0) as clan_id, p.level, c.name as clan_name
							FROM fightplayer fp
							LEFT JOIN player p ON p.id = fp.player
							LEFT JOIN clan c ON c.id = p.clan
							WHERE fp.fight = " . $fight . " AND
							p.chat_time >= " . (time() - $this->idletime) . " AND
							p.chatroom = '" . self::$player->chatroom . "'
							ORDER BY p.nickname ASC";
				} else {
					$sql = "SELECT p.id, p.nickname, p.fraction, IF(p.clan > 0 and p.clan_status != 'recruit', p.clan, 0) as clan_id, p.level, c.name as clan_name
							FROM player p
							LEFT JOIN clan c ON c.id = p.clan
							WHERE p.chat_time >= " . (time() - $this->idletime) . " AND
							p.chatroom = '" . self::$player->chatroom . "' AND p.stateparam = " . $fight . "
							ORDER BY p.nickname ASC";
				}
			} else if ($type == 'chaotic' && $state == 'before') {
				$sql = "SELECT p.id, p.nickname, p.fraction, IF(p.clan > 0 and p.clan_status != 'recruit', p.clan, 0) as clan_id, p.level, c.name as clan_name
							FROM fightplayer fp
							LEFT JOIN player p ON p.id = fp.player
							LEFT JOIN clan c ON c.id = p.clan
							WHERE fp.fight = " . $fight . " AND
							p.chat_time >= " . (time() - $this->idletime) . " AND
							(p.chatroom = 'battle_resident' or p.chatroom = 'battle_arrived')
							ORDER BY p.nickname ASC";
			} else if ($type == 'chaotic' && $state == 'in') {
				$sql = "SELECT p.id, p.nickname, p.fraction, IF(p.clan > 0 and p.clan_status != 'recruit', p.clan, 0) as clan_id, p.level, c.name as clan_name
							FROM fightplayer fp
							LEFT JOIN player p ON p.id = fp.player
							LEFT JOIN clan c ON c.id = p.clan
							WHERE fp.fight = " . $fight . " AND
							fp.side = '" . $side . "' AND
							p.chat_time >= " . (time() - $this->idletime) . " AND
							(p.chatroom = 'battle_resident' or p.chatroom = 'battle_arrived')
							ORDER BY p.nickname ASC";
			} else if ($type == 'bank') {
				if ($state == 'before') {
					$sql = "SELECT p.id, p.nickname, p.fraction, IF(p.clan > 0 and p.clan_status != 'recruit', p.clan, 0) as clan_id, p.level, c.name as clan_name
							FROM fightplayer fp
							LEFT JOIN player p ON p.id = fp.player
							LEFT JOIN clan c ON c.id = p.clan
							WHERE fp.fight = " . $fight . " AND
							p.chat_time >= " . (time() - $this->idletime) . " AND
							(p.chatroom = 'battle_resident' or p.chatroom = 'battle_arrived')
							ORDER BY p.nickname ASC";
				} else {
					$sql = "SELECT p.id, p.nickname, p.fraction, IF(p.clan > 0 and p.clan_status != 'recruit', p.clan, 0) as clan_id, p.level, c.name as clan_name
							FROM player p
							LEFT JOIN clan c ON c.id = p.clan
							WHERE p.chat_time >= " . (time() - $this->idletime) . " AND
							(p.chatroom = 'battle_resident' or p.chatroom = 'battle_arrived') AND p.stateparam = " . $fight . "
							ORDER BY p.nickname ASC";
				}
			}
		} else {
			if (self::$player->chatroom == 'clan') {
				$roomCond = "AND p.clan_status != 'recruit' AND p.clan = " . self::$player->clan;
			}
			$sql = "SELECT p.id, p.nickname, p.fraction, IF(p.clan > 0 and p.clan_status != 'recruit', p.clan, 0) as clan_id, p.level, c.name as clan_name
					FROM player p
					LEFT JOIN clan c ON c.id = p.clan
					WHERE p.chat_time >= " . (time() - $this->idletime) . " AND
					p.chatroom = '" . self::$player->chatroom . "' " . $roomCond . "
					ORDER BY p.nickname ASC";
		}
		$users = $this->sqlGetRecordSet($sql);
		if ($users === false) {
			return array();
		}
		return $users;
    }

    /*public function showChat() {
		Runtime::clear('chat');
		$channels = array();
		$active_channels = array();
		self::$player->loadAccess();
		foreach ($this->channels as $channel => $title) {
			$newchannel = array('name' => $channel, 'title' => $title);
			if ($channel == 'fraction') {
				if (self::$player->fraction == 'resident') {
					$newchannel['title'] = 'Коренные';
				} else {
					$newchannel['title'] = 'Понаехавшие';
				}
			}
			if (self::$player->{'chat_'.$channel} == 0
			|| ($channel == 'clan' && (self::$player->clan == 0 || (self::$player->clan > 0 && self::$player->clan_status == 'recruit')))
			) {
				$newchannel['disabled'] = 1;
			} else {
				$active_channels[] = $channel;
			}
			$channels[] = $newchannel;
		}
		$this->content['active_channels'] = $active_channels;
		$this->content['channels'] = $channels;
		$this->content['player'] = self::$player->toArray();
		$this->content['unixtime'] = time();
		
		$this->content['players'] = json_encode($this->loadUsers());
		$this->content['messages'] = json_encode($this->loadMessages());

		$this->content['smiles'] = $this->smiles;
		
		$this->content['window-name'] = 'Чат';
		$this->page->addPart ('content', 'chat/chat.xsl', $this->content);
    }*/
}
?>