<?php

class Chat {
	public static $users = array();
	public static $users2 = array();
	public static $users3 = array();
	public static $rooms = array();
	public static $quizAnswer = null;
	public static $quizState = null;
	public static $pids = array();
	private static $cache;

	const SIGN = "fuckingshit";

	const MESSAGE_ROOM		= 1;
	const MESSAGE_PRIVATE	= 2;
	const MESSAGE_CLAN		= 3;
	const MESSAGE_BATTLE	= 4;
	const MESSAGE_WEDDING_START	= 5;
	const MESSAGE_WEDDING_END	= 6;
	const MESSAGE_WEDDING_ASK	= 7;

	//const API = "http://prod.dev.moswar.ru/api/";
	const API = "http://moswar.ru/api/";

	public static function init() {
		self::$cache = new Memcache();
		self::$cache->pconnect("10.1.4.3", 11211);
		//self::$cache->pconnect("localhost", 11211);

		$conditionProtect = array("field" => "password", "value" => "d41d8cd98f00b204e9800998ecf8427e", "compare" => "!=", "error" => "Чтобы начать общаться в чате, защитите своего персонажа");
		$conditionLevel = array("field" => "level", "value" => 1, "compare" => ">", "error" => "У вас слишком маленький уровень");
		self::$rooms["general"]		=	array("code" => "general",	"name" => "Центральный зал",	"description" => "общая комната для всех",			"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel));
		self::$rooms["noobs"]		=	array("code" => "noobs",	"name" => "Детсад",				"description" => "комната для новичков",			"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect));
		self::$rooms["quiz"]		=	array("code" => "quiz",		"name" => "Викторина",			"description" => "для знатоков и эрудитов",			"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel));
		self::$rooms["resident"]	=	array("code" => "resident",	"name" => "Красная площадь",	"description" => "только для коренных",				"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel, array("field" => "fraction", "value" => "resident", "compare" => "==", "error" => "Сюда могут зайти только коренные")));
		self::$rooms["arrived"]		=	array("code" => "arrived",	"name" => "Вокзал",				"description" => "только для понаехавших",			"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel, array("field" => "fraction", "value" => "arrived", "compare" => "==", "error" => "Сюда могут зайти только понаехавшие")));
		self::$rooms["battle"]		=	array("code" => "battle",	"name" => "Боевая",				"description" => "для участников группового боя",	"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel, array("field" => "fight_id", "value" => null, "compare" => "!=", "error" => "Вы должны находиться в бою"), array("field" => "fight_state", "value" => null, "compare" => "!=", "error" => "Вы должны находиться в бою")));
		self::$rooms["clan"]		=	array("code" => "clan",		"name" => "Клан-центр",			"description" => "только для кланеров",				"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel, array("field" => "clan", "value" => 0, "compare" => "!=", "error" => "Вы должны состоять в клане"), array("field" => "clan_status", "value" => "recruit", "compare" => "!=", "error" => "Вы должны состоять в клане")));
		self::$rooms["casino"]		=	array("code" => "casino",	"name" => "Казино",				"description" => "только для посетителей казино",	"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel), "invisible" => true);
		self::$rooms["wedding"]		=	array("code" => "wedding",	"name" => "Свадебная",			"description" => "комната для свадебных церемоний",	"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel), "process" => 0, "ask" => 0);
		self::$rooms["sresident"]	=	array("code" => "sresident","name" => "Совет коренных",		"description" => "комната для совета коренных",		"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel, array("field" => "fraction", "value" => "resident", "compare" => "==", "error" => "Сюда могут зайти только коренные"), array("field" => "sovet", "value" => "1", "compare" => "==", "error" => "Сюда могут зайти только члены совета")));
		self::$rooms["sarrived"]	=	array("code" => "sarrived",	"name" => "Совет понаехавших",	"description" => "комната для совета понаехавших",	"count" => 0,	"users" => array(),	"conditions" => array($conditionProtect, $conditionLevel, array("field" => "fraction", "value" => "arrived", "compare" => "==", "error" => "Сюда могут зайти только понаехавшие"), array("field" => "sovet", "value" => "1", "compare" => "==", "error" => "Сюда могут зайти только члены совета")));
	}

	public static function kickUserByClientId($id) {
		if (isset(self::$users3[$id])) {
			$object = array();
			$object["data"] = array();
			$object["data"]["key"] = self::$users3[$id]["key"];
			$object = json_decode(json_encode($object));
			$client = null;
			self::actionLeave($object, $client);
			$nickname = self::$users3[$id]["player"]["nickname"];
			$key = self::$users3[$id]["key"];
			self::$users[self::$users3[$id]["key"]] = null;
			self::$users2[$nickname] = null;
			self::$users3[$id] = null;
			unset(self::$users[$key]);
			unset(self::$users2[$nickname]);
			unset(self::$users3[$id]);
		}
	}

	/* Actions */
	public static function actionAuth(&$object, &$client) {
		$key = self::signed($object->data->id);
		$player = null;
		if (!($player = self::$cache->get("user_chat_" . $key))) {
			$auth = file_get_contents(self::API . "auth/" . $object->data->id . "/" . $object->data->password . "/" . $key . "/");
		}
		//print self::API . "auth/" . $object->data->id . "/" . $object->data->password . "/";
		$result = true;
		if ($player || trim($auth) != "null") {
			if (!$player) $player = json_decode($auth, true);
			if ($player) {
				$data = array();
				$data["key"] = $key;
				$data["rooms"] = array();
				if (!isset(self::$users[$key]) || empty(self::$users[$key])) {
					self::$users[$key] = array();
					self::$users[$key]["client"] = &$client;
					self::$users[$key]["queue"] = array();
					self::$users[$key]["player"] = &$player;
					self::$users[$key]["room"] = null;
					self::$users[$key]["last_update"] = time();
					self::$users[$key]["key"] = $key;
					self::$users[$key]["mute_message_time"] = null;
					self::$users[$key]["mute_message_count"] = 0;

					self::$users2[$player["nickname"]] = &self::$users[$key];
					self::$users3[$client->getId()] = &self::$users[$key];
				} else {
					if (self::$users[$key]["client"]) {
						$prevClient = &self::$users[$key]["client"];
						$messageData = array();
						$messageData["type"] = "system";
						$messageData["time"] = time();
						$messageData["reauth"] = true;
						$messageData["message"] = "Потеряно соединение с чат-сервером. Для того, чтобы перезайти - обновите страницу.";

						self::$users[$key]["client"]->sendRequest("message", $messageData);

						self::$users[$key]["client"] = &$client;
						self::$users3[$client->getId()] = &self::$users[$key];
						unset(self::$users3[$prevClient->getId()]);
						$prevClient->removeme = true;
					} else {
						self::$users[$key]["client"] = &$client;
						self::$users3[$client->getId()] = &self::$users[$key];
					}
					self::$users[$key]["last_update"] = time();
					unset(self::$users[$key]["player"]);
					self::$users[$key]["player"] = &$player;
				}
				self::$users[$key]["rp"] = self::getResponsePlayer(self::$users[$key]);

				$data["player"] = self::$users[$key]["rp"];
				$client->sendResponse("auth", $data);

				/*
				$data = array();
				$data["type"] = "system";
				$data["message"] = "Уважаемые игроки, чат запущен в тестовом режиме и проходит отладку. Приносим извинения за возможные неудобства.";
				$data["time"] = time();
				self::$users[$key]["client"]->sendRequest("message", $data);
				*/
			} else {
				$result = false;
			}
		} else {
			$result = false;
		}
		return $result;
	}

	public static function actionCome(&$object, &$client) {
		self::actionLeave($object, $client);
		if (isset(self::$users[$object->data->key])) {
			// Авторизовались
			if (self::$rooms[$object->data->room]) {
				// Комната существует. пробуем войти
				//self::updateUserInfo(self::$users[$object->data->key], true, true);
				$allow = true;
				foreach (self::$rooms[$object->data->room]["conditions"] as &$condition) {
					$allow = $allow && self::checkCondition(self::$users[$object->data->key], $condition);
					if (!$allow) {
						$data = array();
						//$data["room"] = self::getResponseRoom(self::$rooms[$object->data->room], $object->data->key);
						$data["roomCode"] = $object->data->room;
						$client->sendResponse("come", $data, false, $condition["error"]);
						break;
					}
				}
				if ($allow) {
					// Можно входить. Всё проверили
					self::$users[$object->data->key]["room"] = &self::$rooms[$object->data->room];
					self::$rooms[$object->data->room]["users"][$object->data->key] = &self::$users[$object->data->key];
					self::$rooms[$object->data->room]["count"]++;
					$data = array();
					$data["room"] = self::getResponseRoom(self::$rooms[$object->data->room], $object->data->key);
					$client->sendResponse("come", $data);
					// Оповещаем комнату
					//$data["player"] = $this->getResponsePlayer(self::$users[$object->data->key]);
					$data = array();
					self::notifyRoom($object->data->room, "come", $data, $object->data->key);
				}
			} else {
				// Запрашиваемой комнаты не существует
			}
		} else {
			return false;
		}
		return true;
	}

	public static function actionLeave(&$object, &$client) {
		if (isset(self::$users[$object->data->key])) {
			// Авторизовались
			//self::$users[$object->data->key]["last_activity"] = time();
			if (self::$users[$object->data->key]["room"]) {
				// Юзер находится в комнате и нужно из неё выйти
				self::$users[$object->data->key]["room"]["count"]--;
				unset(self::$users[$object->data->key]["room"]["users"][$object->data->key]);

				$data = array();
				self::notifyRoom(self::$users[$object->data->key]["room"]["code"], "leave", $data, $object->data->key);

				unset(self::$users[$object->data->key]["room"]);
				self::$users[$object->data->key]["room"] = null;
				$data = array();
				if ($client) {
					$client->sendResponse("leave", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	private static function actionMessageClan(&$object) {
		// Делаю не очень круто. Когда пользователей в пределах 1000 должно работать нормально.
		// Такой метод делает ненужным постоянный контроль за ещё одной структурой кланов, но зато надо бегать по массиву юзеров,
		// Чтобы раздать сообщения адресатам
		if (self::$users[$object->data->key]["player"]["clan"] != "0" && self::$users[$object->data->key]["player"]["clan_status"] != "recruit") {
			// Человек состоит в клане. Можно отправлять сообщения кланерам
			foreach (self::$users as &$user) {
				if ($user["player"]["clan"] == self::$users[$object->data->key]["player"]["clan"] && $user["player"]["clan_status"] != "recruit") {
					// Чувак принадлежит к тому же клану что и отправитель и должен получить сообщение. Отправляем.
					$object->data->message = trim(str_replace(array("private [clan]", "to [clan]"), "", $object->data->message));
					if ($user["room"]["code"] != "clan") $object->data->message = "to [clan] " . $object->data->message;
					self::sendMessage(self::$users[$object->data->key], $user, $object, "clan");
				}
			}
		}
	}

	private static function actionMessageWeddingStart(&$object) {
		self::$rooms["wedding"]["process"] = 1;
		self::$rooms["wedding"]["ask"] = 0;
	}

	private static function actionMessageWeddingEnd(&$object) {
		self::$rooms["wedding"]["process"] = 0;
		self::$rooms["wedding"]["ask"] = 0;
	}

	private static function actionMessageWeddingAsk(&$object, &$nicknames) {
		foreach ($nicknames as $nickname) {
			if (isset(self::$users2[$nickname])) {
				self::$rooms["wedding"]["ask"] = self::$users2[$nickname]["player"]["id"];
			}
		}
	}

	private static function actionMessagePrivate(&$object, &$nicknames) {
		//$signedPlayer = $this->signed($object->data->player);
		$playersCount = sizeof($nicknames);
		self::sendMessage(self::$users[$object->data->key], self::$users[$object->data->key], $object, "private");
		foreach ($nicknames as $nickname) {
			if (isset(self::$users2[$nickname])) {
				if ($object->data->key != self::$users2[$nickname]["key"])
					self::sendMessage(self::$users[$object->data->key], self::$users2[$nickname], $object, "private");
			} else {
				$data = array();
				$data["type"] = "system";
				if (self::$users[$object->data->key]["player"]["level"] == 1) {
					$data["message"] = "Игрок " . $nickname . " сейчас не в чате.";
				} else {
					$data["message"] = "Игрок " . $nickname . " сейчас не в чате. Ему было отправлено личное сообщение.";
					$text = $object->data->message;
					//$nickname = $nickname;
					$pid = pcntl_fork();
					self::$pids["p" . $pid] = true;
					if ($pid == 0) {
						file_get_contents(self::API . "private/" . self::$users[$object->data->key]["player"]["id"] . "/" . urlencode($nickname) . "/" . urlencode($text) . "/" . self::signed(self::$users[$object->data->key]["player"]["id"] . $nickname . $text) . "/");
						exit(0);
					}
				}
				$data["time"] = time();
				self::$users[$object->data->key]["client"]->sendRequest("message", $data);
			}
		}
	}

	private static function actionMessageBattle(&$object) {
		// Делаю не очень круто. Когда пользователей в пределах 1000 должно работать нормально.
		// Такой метод делает ненужным постоянный контроль за ещё одной структурой кланов, но зато надо бегать по массиву юзеров,
		// Чтобы раздать сообщения адресатам
		//self::updateUserInfo(self::$users[$object->data->key]);

		if (self::$users[$object->data->key]["player"]["fight_id"] && self::$users[$object->data->key]["player"]["fight_state"]) {
			if (self::$users[$object->data->key]["player"]["fight_dt"] > time()) {
				foreach (self::$users as &$user) {
					if ($user["player"]["fight_id"] == self::$users[$object->data->key]["player"]["fight_id"]) {
						// Чувак находится в том же бою. Отправляем.
						$object->data->message = trim(str_replace(array("private [battle]", "to [battle]"), "", $object->data->message));
						if ($user["room"]["code"] != "battle") $object->data->message = "to [battle] " . $object->data->message;

						self::sendMessage(self::$users[$object->data->key], $user, $object, "battle");
					}
				}
			} else {
				foreach (self::$users as &$user) {
					if ($user["player"]["fight_id"] == self::$users[$object->data->key]["player"]["fight_id"] && $user["player"]["fight_side"] == self::$users[$object->data->key]["player"]["fight_side"]) {
						// Чувак находится в том же бою. Отправляем.
						$object->data->message = trim(str_replace(array("private [battle]", "to [battle]"), "", $object->data->message));
						if ($user["room"]["code"] != "battle") $object->data->message = "to [battle] " . $object->data->message;

						self::sendMessage(self::$users[$object->data->key], $user, $object, "battle");
					}
				}
			}
		} else {
			if (self::$users[$object->data->key]["room"]["code"] == "battle") {
				$data = array();
				$data["type"] = "system";
				$data["message"] = "Бой завершён. Общение в этой комнате остановлено.";
				$data["time"] = time();
				self::$users[$object->data->key]["client"]->sendRequest("message", $data);
			}
		}
	}

	private static function actionMessageRoom(&$object) {
		if (self::$users[$object->data->key]["room"]) {
			$type = "general";
			switch (self::$users[$object->data->key]["room"]["code"]) {
				case "clan" :
					self::actionMessageClan($object);
					break;
				case "battle" :
					self::actionMessageBattle($object);
					break;
				case "quiz" :
					$object->data->message = str_replace("private [quiz]", "to [quiz]", $object->data->message);
					foreach (self::$users[$object->data->key]["room"]["users"] as &$user) {
						self::sendMessage(self::$users[$object->data->key], $user, $object);
					}
					if (self::$quizState == "question_asked") {
						$answer = mb_strtolower(trim(str_replace("to [quiz]", "", $object->data->message)), "UTF-8");

						if ($answer == mb_strtolower(self::$quizAnswer, "UTF-8")) {
							$data = array();
							$data["type"] = "quiz";
							$data["sender"] = self::getQuizPlayer();

							$data["message"] = "Игрок " . self::$users[$object->data->key]["player"]["nickname"] . " первым отвечает правильно и получает 1 очко. Переходим к следующему вопросу.";
							$data["time"] = time();

							self::notifyRoom("quiz", "message", $data);

							self::$quizState = "question_answered";
							$pid = pcntl_fork();
							self::$pids["p" . $pid] = true;
							if ($pid == 0) {
								file_get_contents(self::API . "quiz/" . self::$users[$object->data->key]["player"]["id"] . "/" . self::signed(self::$users[$object->data->key]["player"]["id"]) . "/");
								exit(0);
							}
						}

					}
					break;
				case "wedding" :
					if (self::$rooms["wedding"]["process"]) {
						if (self::$users[$object->data->key]["player"]["id"] != self::$rooms["wedding"]["ask"] && !self::$users[$object->data->key]["player"]["wedding_access"]) {
							break;
						}
					}
					if (self::$users[$object->data->key]["player"]["wedding_access"]) {
						$type = "quiz"; // Пока юзаем класс от голосования. он вполне подходит
					}
				default :
				// Чувак находится в комнате и может в неё писать
					foreach (self::$users[$object->data->key]["room"]["users"] as &$user) {
						self::sendMessage(self::$users[$object->data->key], $user, $object, $type);
					}
					break;
			}
		} else {
			// Чувак попытался написать сообщение не находясь в комнате
		}
	}

	public static function actionMessage(&$object, &$client) {
		if (isset(self::$users[$object->data->key])) {
			// Авторизовались
			$object->data->time = time();

			if (self::$users[$object->data->key]["player"]["mute_chat"] && self::$users[$object->data->key]["player"]["mute_chat"] > $object->data->time) {
				$data = array();
				$data["period"] = self::formatPeriod(self::$users[$object->data->key]["player"]["mute_chat"] - $object->data->time);
				$client->sendResponse("message", $data, false, "mute");
				return true;
			}

			if (self::$users[$object->data->key]["player"]["accesslevel"] == "-2") {
				$data = array();
				$client->sendResponse("message", $data, false, "frozen");
				return true;
			}

			if (self::$users[$object->data->key]["player"]["accesslevel"] == "-1") {
				$data = array();
				$client->sendResponse("message", $data, false, "deported");
				return true;
			}

			//print self::$users[$object->data->key]["mute_message_time"] . "\n";
			if (self::$users[$object->data->key]["mute_message_time"] && ($object->data->time - self::$users[$object->data->key]["mute_message_time"]) < 15) {
				self::$users[$object->data->key]["mute_message_count"]++;
				//print self::$users[$object->data->key]["mute_message_count"] . "\n";
			} else {
				self::$users[$object->data->key]["mute_message_time"] = $object->data->time;
				//print self::$users[$object->data->key]["mute_message_count"] . "\n";
				self::$users[$object->data->key]["mute_message_count"] = 0;
			}

			if (self::$users[$object->data->key]["mute_message_count"] >= 5) {
				$data = array();
				$muteTime = 60 * 15;
				$data["period"] = self::formatPeriod($muteTime);
				$muteTime += $object->data->time;
				$client->sendResponse("message", $data, false, "automute");
				$pid = pcntl_fork();
				self::$pids["p" . $pid] = true;
				if ($pid == 0) {
					file_get_contents(self::API . "automute/" . self::$users[$object->data->key]["player"]["id"] . "/" . $muteTime . "/" . self::signed(self::$users[$object->data->key]["player"]["id"] . $muteTime) . "/");
					exit(0);
				}
				// Пользователь есть в чате. Накладываем молчанку
				self::$users[$object->data->key]["player"]["mute_chat"] = $muteTime;
				return true;
			}

			//self::$users[$object->data->key]["last_activity"] = $object->data->time;

			if (!self::$users[$object->data->key]["player"]["captcha"]) {
				//self::updateUserInfo(self::$users[$object->data->key], true, true);
			}
			if (!self::$users[$object->data->key]["player"]["captcha"]) {
				$data = array();
				$client->sendResponse("message", $data, false, "captcha");
				return true;
			}

			$object->data->message = htmlspecialchars(addslashes($object->data->message));

			if (self::$users[$object->data->key]["player"]["level"] > 1 && (strpos($object->data->message, "to [clan]") !== false || strpos($object->data->message, "private [clan]") !== false)) {
				$type = self::MESSAGE_CLAN;
			} elseif (self::$users[$object->data->key]["player"]["level"] > 1 && (strpos($object->data->message, "to [battle]") !== false || strpos($object->data->message, "private [battle]") !== false)) {
				$type = self::MESSAGE_BATTLE;
			} elseif (strpos($object->data->message, "private [") === 0 && strpos($object->data->message, "private [quiz]") === false && strpos($object->data->message, "private [battle]") === false) {
				$type = self::MESSAGE_PRIVATE;
				preg_match_all("~private\s?\[([^\]]+)\]~", $object->data->message, $nicknames);
				$nicknames = $nicknames[1];
			} elseif (self::$users[$object->data->key]["room"]["code"] == "wedding" && self::$users[$object->data->key]["player"]["wedding_access"] && strpos($object->data->message, "wedding_start") === 0) {
				$type = self::MESSAGE_WEDDING_START;
			} elseif (self::$users[$object->data->key]["room"]["code"] == "wedding" && self::$users[$object->data->key]["player"]["wedding_access"] && strpos($object->data->message, "wedding_end") === 0) {
				$type = self::MESSAGE_WEDDING_END;
			} elseif (self::$users[$object->data->key]["room"]["code"] == "wedding" && self::$users[$object->data->key]["player"]["wedding_access"] && strpos($object->data->message, "wedding_ask") === 0) {
				$type = self::MESSAGE_WEDDING_ASK;
				preg_match_all("~wedding_ask\s?\[([^\]]+)\]~", $object->data->message, $nicknames);
				$nicknames = $nicknames[1];
			} else {
				$type = self::MESSAGE_ROOM;
			}

			switch ($type) {
				case self::MESSAGE_ROOM : self::actionMessageRoom($object);
					break;
				case self::MESSAGE_WEDDING_START : self::actionMessageWeddingStart($object);
					break;
				case self::MESSAGE_WEDDING_END : self::actionMessageWeddingEnd($object);
					break;
				case self::MESSAGE_WEDDING_ASK : self::actionMessageWeddingAsk($object, $nicknames);
					break;
				case self::MESSAGE_PRIVATE : self::actionMessagePrivate($object, $nicknames);
					break;
				case self::MESSAGE_CLAN : self::actionMessageClan($object);
					break;
				case self::MESSAGE_BATTLE : self::actionMessageBattle($object);
					break;
			}
		} else {
			return false;
		}
		return true;
	}

	private static function sendMessage(&$sender, &$recipient, &$object, $type = "general") {
		$data = array();
		$data["type"] = $type;
		$data["sender"] = $sender["rp"];

		$data["message"] = $object->data->message;
		//$data["time"] = date("H:i:s", $object->data->time);
		$data["time"] = $object->data->time;

		if ($sender["player"]["isolate_chat"] && $sender["player"]["isolate_chat"] > time()) {
			if ($recipient["player"]["id"] == $sender["player"]["id"]) $recipient["client"]->sendRequest("message", $data);
		} else {
			$recipient["client"]->sendRequest("message", $data);
		}
	}

	public static function actionComplain(&$object, &$client) {
		return true;
	}

	public static function actionMute(&$object, &$client) {
		if (isset(self::$users[$object->data->key])) {
			// Авторизовались
			if (self::$users[$object->data->key]["player"]["mute_chat_access"]) {
				// Может ставить молчанку
				$time = time();
				$muteTime = $time + $object->data->time;
				$signedPlayer = self::signed($object->data->player);
				if (self::$users[$signedPlayer]) {
					$moderatorId = self::$users[$object->data->key]["player"]["id"];
					$playerId = self::$users[$signedPlayer]["player"]["id"];
					$period = $object->data->time;
					//$text = urlencode($object->data->reason);
					$text = $object->data->reason;
					$pid = pcntl_fork();
					self::$pids["p" . $pid] = true;
					if ($pid == 0) {
						file_get_contents(self::API . "mute/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . urlencode($text) . "/" . self::signed($moderatorId . $playerId . $period) . "/");
						exit(0);
					}
					//print self::API . "mute/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . $text . "/" . $this->signed($moderatorId . $playerId . $period . $text) . "/\n";
					// Пользователь есть в чате. Накладываем молчанку
					if (self::$users[$signedPlayer]["player"]["mute_chat"] == null) self::$users[$signedPlayer]["player"]["mute_chat"] = $muteTime;
					else self::$users[$signedPlayer]["player"]["mute_chat"] += $period;
					//self::$users[$signedPlayer]["mute"] = $muteTime;
					// Оповещаем комнату

					$data = array();
					$data["moderator"] = self::$users[$object->data->key]["rp"];
					$data["player"] = self::$users[$signedPlayer]["rp"];
					$data["reason"] = $object->data->reason;
					$data["period"] = self::formatPeriod($object->data->time);
					//$data["time"] = date("H:i:s", time());
					$data["time"] = $time;

					if (self::$users[$signedPlayer]["room"]) {
						self::notifyRoom(self::$users[$signedPlayer]["room"]["code"], "mute", $data);
					}
					if ($client) $client->sendResponse("mute", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	public static function actionIsolate(&$object, &$client) {
		if (isset(self::$users[$object->data->key])) {
			// Авторизовались
			if (self::$users[$object->data->key]["player"]["isolate_chat_access"]) {
				// Может ставить изоляцию
				$time = time();
				$muteTime = $time + $object->data->time;
				$signedPlayer = self::signed($object->data->player);
				if (self::$users[$signedPlayer]) {
					$moderatorId = self::$users[$object->data->key]["player"]["id"];
					$playerId = self::$users[$signedPlayer]["player"]["id"];
					$period = $object->data->time;
					$text = $object->data->reason;
					$pid = pcntl_fork();
					self::$pids["p" . $pid] = true;
					if ($pid == 0) {
						file_get_contents(self::API . "isolate/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . urlencode($text) . "/" . self::signed($moderatorId . $playerId . $period) . "/");
						exit(0);
					}
					//print self::API . "isolate/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . $text . "/" . $this->signed($moderatorId . $playerId . $period . $text) . "/\n";
					// Пользователь есть в чате. Накладываем изоляцию
					if (self::$users[$signedPlayer]["player"]["isolate_chat"] == null) self::$users[$signedPlayer]["player"]["isolate_chat"] = $muteTime;
					else self::$users[$signedPlayer]["player"]["isolate_chat"] += $period;

					$data = array();
					$data["moderator"] = self::$users[$object->data->key]["rp"];
					$data["player"] = self::$users[$signedPlayer]["rp"];
					$data["reason"] = $object->data->reason;
					$data["period"] = self::formatPeriod($object->data->time);
					//$data["time"] = date("H:i:s", time());
					$data["time"] = $time;

					if ($client) $client->sendResponse("isolate", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	public static function actionUnmute(&$object, &$client) {
		if (isset(self::$users[$object->data->key])) {
			// Авторизовались
			if (self::$users[$object->data->key]["player"]["mute_chat_access"]) {
				// Может снимать молчанку
				$signedPlayer = self::signed($object->data->player);
				if (self::$users[$signedPlayer]) {
					$moderatorId = self::$users[$object->data->key]["player"]["id"];
					$playerId = self::$users[$signedPlayer]["player"]["id"];
					$pid = pcntl_fork();
					self::$pids["p" . $pid] = true;
					if ($pid == 0) {
						file_get_contents(self::API . "unmute/" . $moderatorId . "/" . $playerId . "/" . self::signed($moderatorId . $playerId) . "/");
						exit(0);
					}
					//print self::API . "unmute/" . $moderatorId . "/" . $playerId . "/" . $this->signed($moderatorId . $playerId) . "/\n";
					// Пользователь есть в чате. Снимаем молчанку
					self::$users[$signedPlayer]["player"]["mute_chat"] = null;
					// Оповещаем юзера

					$data = array();
					$data["moderator"] = self::$users[$object->data->key]["rp"];
					$data["player"] = self::$users[$signedPlayer]["rp"];

					if (self::$users[$signedPlayer]["room"]) {
						self::notifyRoom(self::$users[$signedPlayer]["room"]["code"], "unmute", $data);
					}
					if ($client) $client->sendResponse("unmute", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	public function actionUnisolate(&$object, &$client) {
		if (isset(self::$users[$object->data->key])) {
			// Авторизовались
			if (self::$users[$object->data->key]["player"]["isolate_chat_access"]) {
				// Может снимать изоляцию
				$signedPlayer = self::signed($object->data->player);
				if (self::$users[$signedPlayer]) {
					$moderatorId = self::$users[$object->data->key]["player"]["id"];
					$playerId = self::$users[$signedPlayer]["player"]["id"];
					$pid = pcntl_fork();
					self::$pids["p" . $pid] = true;
					if ($pid == 0) {
						file_get_contents(self::API . "unisolate/" . $moderatorId . "/" . $playerId . "/" . self::signed($moderatorId . $playerId) . "/");
						exit(0);
					}
					//print self::API . "unisolate/" . $moderatorId . "/" . $playerId . "/" . $this->signed($moderatorId . $playerId) . "/\n";
					// Пользователь есть в чате. Снимаем изоляцию
					self::$users[$signedPlayer]["player"]["isolate_chat"] = null;

					$data = array();
					$data["moderator"] = self::$users[$object->data->key]["rp"];
					$data["player"] = self::$users[$signedPlayer]["rp"];

					if ($client) $client->sendResponse("unisolate", $data);

				}
			}
		} else {
			return false;
		}
		return true;
	}

	public static function actionRooms(&$object, &$client) {
		if (isset(self::$users[$object->data->key])) {
			$data = array();
			$data["rooms"] = array();
			foreach (self::$rooms as &$room) {
				if (!isset($room["invisible"]) || !$room["invisible"]) {
					$rroom = self::getResponseRoom($room, $object->data->key);
					if ($rroom) {
						$data["rooms"][] = $rroom;
					}
				}
			}
			if ($client) $client->sendResponse("rooms", $data);
		}
		return true;
	}

	public static function actionQuiz(&$object, &$client) {
		if ($object->data->key == "quizquizquiz1~") {
			if (isset($object->data->answer) && !empty ($object->data->answer)) {
				self::$quizAnswer = $object->data->answer;
				self::$quizState = "question_asked";
			}

			if (isset($object->data->message) && !empty ($object->data->message)) {
				$data = array();
				$data["type"] = "quiz";
				$data["sender"] = self::getQuizPlayer();

				$data["message"] = $object->data->message;
				$data["time"] = time();

				self::notifyRoom("quiz", "message", $data);
			}
			//$this->sendRequest($recipient, "message", $data);

		}
	}

	public static function actionSystem(&$object, &$client) {
		if ($object->data->key == "systemmess4ge!23") {
			if (isset($object->data->message) && !empty ($object->data->message)) {
				$data = array();
				$data["type"] = "system";
				$data["sender"] = self::getSystemPlayer();

				$data["message"] = $object->data->message;
				$data["time"] = time();

				self::notifyRoom($object->data->room, "message", $data);
			}
		}
	}

	public static function actionPlayers(&$object, &$client) {
		if ($object->data->key == "pl4yersroom12!@") {
			$data = array();
			$data["players"] = self::getRoomUsers($object->data->room);
			$client->sendResponse("players", $data);
		}
	}

	public static function actionCasino(&$object, &$client) {
		if ($object->data->key == "casinocasinocasino1~") {
			if (isset($object->data->message) && !empty ($object->data->message)) {
				$data = array();
				$data["type"] = "casino";
				$data["sender"] = self::getCasinoPlayer();

				$data["message"] = $object->data->message;
				$data["time"] = time();

				self::notifyRoom("casino", "message", $data);
			}
		}
	}

	public static function actionInfo(&$object, &$client) {
		if ($object->data->key == "chat1nf0upd@te123456q.") {
			$info = json_decode(json_encode($object->data->info), true);
			foreach ($info as $key => &$userInfo) {
				if (isset(self::$users[$key])) {
					self::$users[$key]["old_fight_id"] = self::$users[$key]["player"]["fight_id"];
					self::$users[$key]["old_fight_state"] = self::$users[$key]["player"]["fight_state"];

					foreach ($userInfo as $opt => $val) {
						self::$users[$key]["player"][$opt] = $val;
						if ($opt == "level" || $opt == "nickname" || $opt == "clan" || $opt == "fraction") {
							self::$users[$key]["rp"] = self::getResponsePlayer(self::$users[$key]);
						}
					}

				}
			}

			foreach ($info as $key => $userInfo) {
				if (isset(self::$users[$key])) {
					if (self::$users[$key]["room"]["code"] == "battle" && self::$users[$key]["old_fight_id"] != null && self::$users[$key]["player"]["fight_id"] == null) {
						// Были в бою но вышли (бой закончился или не попали)
						// Перекинуть в главную
						$data = array();
						$data["type"] = "system";
						$data["time"] = time();
						if (self::$users[$key]["player"]["fight_state"] == "created") {
							$data["message"] = "Вы не попали в бой. Боевой чат завершён.";
						} else {
							$data["message"] = "Бой окончен. Боевой чат завершён.";
						}
						self::$users[$key]["client"]->sendRequest("message", $data);
					}
					if (self::$users[$key]["room"]["code"] == "battle" && (!isset(self::$users[$key]["fight_message"]) || !self::$users[$key]["fight_message"]) && self::$users[$key]["old_fight_id"] != null && self::$users[$key]["player"]["fight_id"] != null && self::$users[$key]["old_fight_id"] == self::$users[$key]["player"]["fight_id"] && self::$users[$key]["old_fight_state"] == "created" && self::$users[$key]["player"]["fight_state"] == "started") {
						// Были в комнате до боя. И бой начался.
						$messageData = array();
						$messageData["type"] = "system";
						$messageData["message"] = "Бой начался, и теперь в Боевой комнате остались <b>только Ваши соратники</b>";
						$messageData["time"] = time();

						$comeData = array();
						foreach (self::$rooms["battle"]["users"] as $playerKey => &$user) {
							if ($user["player"]["fight_id"] == self::$users[$playerKey]["player"]["fight_id"]) {
								$user["fight_message"] = true;
								$user["client"]->sendRequest("message", $messageData);
								$comeData["room"] = self::getResponseRoom(self::$rooms["battle"], $playerKey);
								$user["client"]->sendResponse("come", $comeData);
							}
						}
					}
				}
			}

			foreach ($info as $key => $userInfo) {
				if (isset(self::$users[$key])) {
					unset(self::$users[$key]["fight_message"]);
					unset(self::$users[$key]["old_fight_id"]);
					unset(self::$users[$key]["old_fight_state"]);
				}
			}
		}
	}

	public function actionQuit(&$object, &$client) {
		self::actionLeave($object, $client);
		$client->removeme = true;
		return true;
	}

	/* Private */

	private static function formatRussianNumeral($n, $form1, $form2, $form5) {
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $form5;
		if ($n1 > 1 && $n1 < 5) return $form2;
		if ($n1 == 1) return $form1;
		return $form5;
	}

	private static function formatPeriod($time) {
		if ($time >= 60) {
			$minutes = floor($time / 60);
			if ($minutes >= 60) {
				$hours = floor($minutes / 60);
				$minutes = $minutes % 60;
				$result = $hours . " " . self::formatRussianNumeral($hours, "час", "часа", "часов");
				if ($minutes > 0) $result .= " " . $minutes . " " . self::formatRussianNumeral($minutes, "минуту", "минуты", "минут");
				return $result;
			} else {
				return $minutes . " " . self::formatRussianNumeral($minutes, "минуту", "минуты", "минут");
			}
		} else {
			return $time . " " . self::formatRussianNumeral($time, "секунду", "секунды", "секунд");
		}
	}

	private static function getRoomUsers($room) {
		$users = array();
		foreach (self::$rooms[$room]["users"] as $key => &$user) {
			$users[] = $user["player"]["id"];
		}
		return $users;
	}

	private static function notifyRoom($room, $action, &$data, $initiatorKey = null) {
		if ($initiatorKey && isset(self::$users[$initiatorKey])) $data["player"] = &self::$users[$initiatorKey]["rp"];
		$data["roomCode"] = $room;
		switch ($room) {
			case "clan" :
			//self::updateUserInfo(self::$users[$initiatorKey]);
				foreach (self::$rooms[$room]["users"] as $key => &$user) {
					//self::updateUserInfo($user);
					if ($user["player"]["clan"] == self::$users[$initiatorKey]["player"]["clan"]) {
						if ($initiatorKey == null || $key != $initiatorKey) {
							//if ($roomInfo) $data["room"] = self::getResponseRoom(self::$rooms[$room], $key);
							$user["client"]->sendRequest($action, $data);
						}
					}
				}
				break;
			case "battle" :
			//self::updateUserInfo(self::$users[$initiatorKey]);
				foreach (self::$rooms[$room]["users"] as $key => &$user) {
					//self::updateUserInfo($user);
					if ($user["player"]["fight_id"] == self::$users[$initiatorKey]["player"]["fight_id"] && (self::$users[$initiatorKey]["player"]["fight_dt"] > time() || $user["player"]["fight_side"] == self::$users[$initiatorKey]["player"]["fight_side"])) {
						if ($initiatorKey == null || $key != $initiatorKey) {
							//if ($roomInfo) $data["room"] = self::getResponseRoom(self::$rooms[$room], $key);
							$user["client"]->sendRequest($action, $data);
						}
					}
				}
				break;
			default :
			//if ($roomInfo) $data["room"] = self::getResponseRoom(self::$rooms[$room], null);
				foreach (self::$rooms[$room]["users"] as $key => &$user) {
					if ($initiatorKey == null || $key != $initiatorKey) {
						$user["client"]->sendRequest($action, $data);
					}
				}
				break;
		}
	}

	private static function getQuizPlayer() {
		$player = array();
		$player["id"] = 0;
		$player["nickname"] = "Викторина";
		$player["clan_id"] = 0;
		$player["clan_name"] = "";
		$player["fraction"] = "";
		$player["level"] = 0;
		$player["mute_chat_access"] = false;
		$player["isolate_chat_access"] = false;
		return $player;
	}

	private static function getCasinoPlayer() {
		$player = array();
		$player["id"] = 0;
		$player["nickname"] = "Казино";
		$player["clan_id"] = 0;
		$player["clan_name"] = "";
		$player["fraction"] = "";
		$player["level"] = 0;
		$player["mute_chat_access"] = false;
		$player["isolate_chat_access"] = false;
		return $player;
	}

	private static function getSystemPlayer() {
		$player = array();
		$player["id"] = 0;
		$player["nickname"] = "Чат";
		$player["clan_id"] = 0;
		$player["clan_name"] = "";
		$player["fraction"] = "";
		$player["level"] = 0;
		$player["mute_chat_access"] = false;
		$player["isolate_chat_access"] = false;
		return $player;
	}

	private static function getResponsePlayer(&$user) {
		$player = array();
		$player["id"] = $user["player"]["id"];
		$player["nickname"] = $user["player"]["nickname"];
		$player["clan_id"] = ($user["player"]["clan"] != 0 && $user["player"]["clan_status"] != "recruit") ? $user["player"]["clan"] : null;
		$player["clan_name"] = ($user["player"]["clan"] != 0 && $user["player"]["clan_status"] != "recruit") ? $user["player"]["clan_name"] : null;
		$player["fraction"] = $user["player"]["fraction"];
		$player["level"] = $user["player"]["level"];
		$player["mute_chat_access"] = $user["player"]["mute_chat_access"];
		$player["isolate_chat_access"] = $user["player"]["isolate_chat_access"];
		return $player;
	}

	private static function getResponseRoom(&$room, $userKey) {
		if (empty($room)) return null;
		if (!isset($room["users"]) || !is_array($room["users"])) return null;
		$responseRoom = array();
		$responseRoom["code"] = &$room["code"];
		$responseRoom["name"] = &$room["name"];
		$responseRoom["description"] = &$room["description"];
		$responseRoom["count"] = $room["count"];
		$responseRoom["players"] = array();
		$count = 0;
		$usersKeys = array_keys($room["users"]);
		$usersCount = sizeof($usersKeys);
		switch ($room["code"]) {
			case "clan" :
			//self::updateUserInfo(self::$users[$userKey]);
				foreach ($room["users"] as &$user) {
					//self::updateUserInfo($user);
					if ($user["player"]["clan"] == self::$users[$userKey]["player"]["clan"] && self::$users[$userKey]["player"]["clan_status"] != "recruit") {
						$responseRoom["players"][] = $user["rp"];
						$count++;
					}
				}
				$responseRoom["count"] = $count;
				break;
			case "battle" :
			//self::updateUserInfo(self::$users[$userKey]);
				foreach ($room["users"] as &$user) {
					//self::updateUserInfo($user);
					if ($user["player"]["fight_id"] == self::$users[$userKey]["player"]["fight_id"] && self::$users[$userKey]["player"]["fight_state"] != null && (self::$users[$userKey]["player"]["fight_state"] == "created" || self::$users[$userKey]["player"]["fight_side"] == $user["player"]["fight_side"])) {
						$responseRoom["players"][] = $user["rp"];
						$count++;
					}
				}
				$responseRoom["count"] = $count;
				break;
			default :
				foreach ($room["users"] as &$user) {
					$responseRoom["players"][] = &$user["rp"];
				}
				break;
		}
		return $responseRoom;
	}

	private static function checkCondition(&$user, &$condition) {
		switch ($condition["compare"]) {
			case "==" :
				return $user["player"][$condition["field"]] == $condition["value"];
				break;
			case "!=" :
				return $user["player"][$condition["field"]] != $condition["value"];
				break;
			case ">" :
				return $user["player"][$condition["field"]] > $condition["value"];
				break;
			case "<" :
				return $user["player"][$condition["field"]] < $condition["value"];
				break;
			default:
				return false;
				break;
		}
	}

	private static function signed($str) {
		return sha1($str . self::SIGN);
	}

}
?>
