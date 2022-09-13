#!/usr/bin/php -q
<?php
//error_reporting(0);
//set_time_limit(0);
ini_set("max_execution_time", "0");
ini_set("memory_limit", "32M");
ini_set("output_buffering", "0");
ini_restore("safe_mode");
ini_restore("open_basedir");
ini_restore("safe_mode_include_dir");
ini_restore("safe_mode_exec_dir");
ini_restore("disable_functions");
ini_restore("allow_url_fopen");
//ini_set("error_log", NULL);
//ini_set("log_errors", 0);
set_magic_quotes_runtime(0);
ignore_user_abort(1);

/*
$pid = pcntl_fork();

if ($pid == -1) {
    echo "fork error\n";
    exit;
} elseif ($pid > 0) {
    // завершаем работу родительского процесса
    exit;
}

umask(0);
chdir("/");

if (posix_setsid() == -1) {
    exit;
}
*/
if(!function_exists("socket_create")) {
	trigger_error("Socket: Missing module 'sockets'", E_USER_ERROR);
	die();
}

$GLOBALS["bindport"] = (intval($argv[1]) ? intval($argv[1]) : 8080);

$server = new Server();

class Server {
	private $listenAddr = "0.0.0.0";
	private $listenPort;
	private $socket = false;
	private $clients;
	private $command;

	public function __construct() {
		$this->listenPort = $GLOBALS["bindport"];
		$this->socket = false;
		$this->clients = array();
		$this->clientsConnections = array();
		$this->command = new Command($this);
		$this->run();
	}

	private function run() {
		global $abort;
		if(!($this->socket = @socket_create(AF_INET, SOCK_STREAM, 0))) $this->socketError();
		if(!@socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1)) $this->socketError();

		if(!@socket_set_nonblock($this->socket)) $this->socketError();
		if(!@socket_bind($this->socket, $this->listenAddr, $this->listenPort)) $this->socketError();
		if(!socket_listen($this->socket)) $this->socketError();
		$abort = false;
		$this->clientsConnections["server"] = $this->socket;
		while(!$abort) {
			/*
			$setArray = &$this->clientsConnections;
			$set = $setArray;
			if(socket_select($set, $set_w = NULL, $set_e = NULL, 1, 0) > 0) {
				foreach($set as $sock) {
					$name = array_search($sock, $setArray);
			*/
			$set = $this->clientsConnections;
			if(socket_select($set, $set_w = NULL, $set_e = NULL, 0, 0) > 0) {
				foreach($set as $name => &$sock) {
					//$name = array_search($sock, $setArray);
					if(!$name) {
						continue;
					} elseif($name == "server") {
						if(!($conn = socket_accept($this->socket))) {
							$this->socketError();
						} else {
							$clientID = uniqid("client_");
							$this->clients[$clientID] = new Client($conn, $this->command, $clientID);
							$this->clientsConnections[$clientID] = $conn;
							//print("Client " . $clientID . " connected\n");
							print memory_get_usage() . "\n";
						}
					} else {
						$clientID = $name;
						if(($read = @socket_read($sock, 1024)) === false || $read == "") {
							if($read != "") $this->socketError();
							$this->clients[$clientID]->disconnect();
							$this->removeClient($clientID);
							//print("Client " . $clientID . " disconnected\n");
							print memory_get_usage() . "\n";
						} else {
							if(strchr(strrev($read), "\n") === false) {
								$this->clients[$clientID]->writeBuffer($read);
							} else {
								$this->clients[$clientID]->writeBuffer(trim($read));
								if(!$this->clients[$clientID]->interact()) {
									$this->clients[$clientID]->disconnect();
									$this->removeClient($clientID);
									//print("Client " . $clientID . " disconnected\n");
									print memory_get_usage() . "\n";
								}
							}
						}
					}
				}
			}
		}
	}

	public function removeClient($clientID) {
		$this->clients[$clientID] = null;
		unset($this->clients[$clientID]);
		$this->clientsConnections[$clientID] = null;
		unset($this->clientsConnections[$clientID]);
	}

	private function socketError() {
		trigger_error("Socket error: " .socket_strerror(socket_last_error($this->socket)) . "\n", E_USER_ERROR);
		if(is_resource($this->socket)) socket_close($this->socket);
		die();
	}
}

class Client {
	private $connection;
	private $command;
	private $buffer = "";
	private $id;

	public function __construct(&$connection, &$command, $id) {
		$this->connection = $connection;
		$this->command = $command;
		$this->id = $id;
		$this->send('<?xml version="1.0"?><!DOCTYPE cross-domain-policy SYSTEM "http://www.adobe.com/xml/dtds/cross-domain-policy.dtd"><cross-domain-policy><allow-access-from domain="*" to-ports="' . $GLOBALS["bindport"] . '" /></cross-domain-policy>');
	}

	public function writeBuffer($str) {
		$this->buffer .= $str;
	}

	public function interact() {
		$result = true;
		if(strlen($this->buffer)) {
			//print $this->buffer;
			$object = json_decode(trim($this->buffer));
			$result = $this->command->exec($object, $this);
			$this->buffer = "";
		}
		return $result;
	}

	public function disconnect() {
		$this->command->kickClient($this->id);
		if(is_resource($this->connection)) socket_close($this->connection);
	}

	public function getId() {
		return $this->id;
	}

	public function send($str) {
		if(is_resource($this->connection)) socket_write($this->connection, $str . "\0");
	}
}

class Command {
	private $users = array();
	private $users2 = array();
	private $users3 = array();
	private $rooms = array();
	private $quizAnswer = null;
	private $quizState = null;
	private $cache;
	private $server;

	const MESSAGE_ROOM		= 1;
	const MESSAGE_PRIVATE	= 2;
	const MESSAGE_CLAN		= 3;
	const MESSAGE_BATTLE	= 4;

	const SIGN = "fuckingshit";

	const API = "http://moswar.ru/api/";

	private function formatRussianNumeral($n, $form1, $form2, $form5) {
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $form5;
		if ($n1 > 1 && $n1 < 5) return $form2;
		if ($n1 == 1) return $form1;
		return $form5;
	}

	private function formatPeriod($time) {
		if ($time >= 60) {
			$minutes = floor($time / 60);
			if ($minutes >= 60) {
				$hours = floor($minutes / 60);
				$minutes = $minutes % 60;
				$result = $hours . " " . $this->formatRussianNumeral($hours, "час", "часа", "часов");
				if ($minutes > 0) $result .= " " . $minutes . " " . $this->formatRussianNumeral($minutes, "минуту", "минуты", "минут");
				return $result;
			} else {
				return $minutes . " " . $this->formatRussianNumeral($minutes, "минуту", "минуты", "минут");
			}
		} else {
			return $time . " " . $this->formatRussianNumeral($time, "секунду", "секунды", "секунд");
		}
	}

	private function notifyRoom($room, $action, &$data, $initiatorKey = null) {
		switch ($room) {
			case "clan" :
				$this->updateUserInfo($this->users[$initiatorKey]);
				foreach ($this->rooms[$room]["users"] as $key => &$user) {
					$this->updateUserInfo($user);
					if ($user["player"]["clan"] == $this->users[$initiatorKey]["player"]["clan"]) {
						if ($initiatorKey == null || $key != $initiatorKey) {
							$data["room"] = $this->getResponseRoom($this->rooms[$room], $key);
							$this->sendRequest($user, $action, $data);
						}
					}
				}
				break;
			case "battle" :
				$this->updateUserInfo($this->users[$initiatorKey]);
				foreach ($this->rooms[$room]["users"] as $key => &$user) {
					$this->updateUserInfo($user);
					if ($user["player"]["fight_id"] == $this->users[$initiatorKey]["player"]["fight_id"]) {
						if ($initiatorKey == null || $key != $initiatorKey) {
							$data["room"] = $this->getResponseRoom($this->rooms[$room], $key);
							$this->sendRequest($user, $action, $data);
						}
					}
				}
				break;
			default :
				$data["room"] = $this->getResponseRoom($this->rooms[$room], null);
				foreach ($this->rooms[$room]["users"] as $key => &$user) {
					if ($initiatorKey == null || $key != $initiatorKey) {
						$this->sendRequest($user, $action, $data);
					}
				}
				break;
		}
	}

	public function __construct(&$server) {
		$this->rooms["general"]		=	array("code" => "general",	"name" => "Центральный зал",	"description" => "общая комната для всех",			"count" => 0,	"users" => array(),	"conditions" => array(array("field" => "level", "value" => 1, "compare" => ">", "error" => "У вас слишком маленький уровень")));
		$this->rooms["noobs"]		=	array("code" => "noobs",	"name" => "Детсад",				"description" => "комната для новичков",			"count" => 0,	"users" => array(),	"conditions" => array());
		$this->rooms["quiz"]		=	array("code" => "quiz",		"name" => "Викторина",			"description" => "для знатоков и эрудитов",			"count" => 0,	"users" => array(),	"conditions" => array(array("field" => "level", "value" => 1, "compare" => ">", "error" => "У вас слишком маленький уровень")));
		$this->rooms["resident"]	=	array("code" => "resident",	"name" => "Красная площадь",	"description" => "только для коренных",				"count" => 0,	"users" => array(),	"conditions" => array(array("field" => "level", "value" => 1, "compare" => ">", "error" => "У вас слишком маленький уровень"), array("field" => "fraction", "value" => "resident", "compare" => "==", "error" => "Сюда могут зайти только коренные")));
		$this->rooms["arrived"]		=	array("code" => "arrived",	"name" => "Вокзал",				"description" => "только для понаехавших",			"count" => 0,	"users" => array(),	"conditions" => array(array("field" => "level", "value" => 1, "compare" => ">", "error" => "У вас слишком маленький уровень"), array("field" => "fraction", "value" => "arrived", "compare" => "==", "error" => "Сюда могут зайти только понаехавшие")));
		$this->rooms["battle"]		=	array("code" => "battle",	"name" => "Боевая",				"description" => "для участников группового боя",	"count" => 0,	"users" => array(),	"conditions" => array(array("field" => "level", "value" => 1, "compare" => ">", "error" => "У вас слишком маленький уровень"), array("field" => "fight_id", "value" => null, "compare" => "!=", "error" => "Вы должны находиться в бою"), array("field" => "fight_state", "value" => null, "compare" => "!=", "error" => "Вы должны находиться в бою")));
		$this->rooms["clan"]		=	array("code" => "clan",		"name" => "Клан-центр",			"description" => "только для кланеров",				"count" => 0,	"users" => array(),	"conditions" => array(array("field" => "level", "value" => 1, "compare" => ">", "error" => "У вас слишком маленький уровень"), array("field" => "clan", "value" => 0, "compare" => "!=", "error" => "Вы должны состоять в клане"), array("field" => "clan_status", "value" => "recruit", "compare" => "!=", "error" => "Вы должны состоять в клане")));

		$this->cache = new Memcache();
		$this->cache->pconnect("10.1.4.3", 11211);
		$this->server = $server;
		//$this->rooms["union"]		=	array("code" => "union",	"name" => "Союзный двор",		"description" => "для общения с союзниками",		"conditions" => array(array("field" => "level", "condition" => 1, "compare" => ">")));
	}

	private function checkCondition(&$user, &$condition) {
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

	private function signed($str) {
		return sha1($str . self::SIGN);
	}

	private function kickUser($key) {
		if (isset($this->users[$key])) {
			$object = array();
			$object["data"] = array();
			$object["data"]["key"] = $key;
			$object = json_decode(json_encode($object));
			$client = null;
			$this->actionLeave($object, $client);
			$nickname = $this->users[$key]["player"]["nickname"];

			if ($this->users[$key]["client"]) {
				$clientId = $this->users[$key]["client"]->getId();
				$this->users3[$clientId] = null;
				unset($this->users3[$clientId]);
			}

			$this->users[$key] = null;
			$this->users2[$nickname] = null;
			unset($this->users[$key]);
			unset($this->users2[$nickname]);
			//print "user kicked";
		}
	}

	public function kickClient($id) {
		if (isset($this->users3[$id])) {
			$object = array();
			$object["data"] = array();
			$object["data"]["key"] = $this->users3[$id]["key"];
			$object = json_decode(json_encode($object));
			$client = null;
			$this->actionLeave($object, $client);
			$nickname = $this->users3[$id]["player"]["nickname"];
			$key = $this->users3[$id]["key"];
			$this->users[$this->users3[$id]["key"]] = null;
			$this->users2[$nickname] = null;
			$this->users3[$id] = null;
			unset($this->users[$key]);
			unset($this->users2[$nickname]);
			unset($this->users3[$id]);
			//print "user kicked";
		}
	}

	private function sendResponse(&$client, $action, &$data, $success = true, $error = "") {
		$response = array();
		$response["success"] = $success;
		$response["type"] = "response";
		$response["action"] = $action;
		$response["data"] = $data;
		if (!$success) $response["error"] = $error;
		$response = json_encode($response);
		if ($client) {
			$client->send($response);
			return true;
		} else {
			return false;
		}
	}

	private function sendRequest(&$user, $action, &$data) {
		$request = array();
		$request["type"] = "request";
		$request["action"] = $action;
		$request["data"] = $data;
		$request = json_encode($request);
		if ($user) {
			if ($user["client"]) {
				$user["client"]->send($request);
			} else {
				$this->kickUser($user["key"]);
				//array_push($user["queue"], $request);
			}
			return true;
		} else {
			return false;
		}
	}

	private function getResponsePlayer(&$user) {
		$player = array();
		$player["id"] = $user["player"]["id"];
		$player["nickname"] = $user["player"]["nickname"];
		$player["clan_id"] = ($user["player"]["clan"] != 0 && $user["player"]["clan_status"] != "recruit") ? $user["player"]["clan"] : null;
		$player["clan_name"] = ($user["player"]["clan"] != 0 && $user["player"]["clan_status"] != "recruit") ? $user["player"]["clan_name"] : null;
		$player["fraction"] = $user["player"]["fraction"];
		$player["level"] = $user["player"]["level"];
		$player["mute_chat_access"] = $user["player"]["mute_chat_access"];
		return $player;
	}

	private function getResponseRoom(&$room, $userKey) {
		if (empty($room)) return null;
		$responseRoom = array();
		$responseRoom["code"] = $room["code"];
		$responseRoom["name"] = $room["name"];
		$responseRoom["description"] = $room["description"];
		$responseRoom["count"] = $room["count"];
		$responseRoom["players"] = array();
		$count = 0;
		$usersKeys = array_keys($room["users"]);
		$usersCount = sizeof($usersKeys);
		switch ($room["code"]) {
			case "clan" :
				$this->updateUserInfo($this->users[$userKey]);
				foreach ($room["users"] as &$user) {
					$this->updateUserInfo($user);
					if ($user["player"]["clan"] == $this->users[$userKey]["player"]["clan"] && $this->users[$userKey]["player"]["clan_status"] != "recruit") {
						$responseRoom["players"][] = $this->getResponsePlayer($user);
						$count++;
					}
				}
				$responseRoom["count"] = $count;
				break;
			case "battle" :
				$this->updateUserInfo($this->users[$userKey]);
				foreach ($room["users"] as &$user) {
					$this->updateUserInfo($user);
					if ($user["player"]["fight_id"] == $this->users[$userKey]["player"]["fight_id"] && $this->users[$userKey]["player"]["fight_state"] != null && ($this->users[$userKey]["player"]["fight_state"] == "created" || $this->users[$userKey]["player"]["fight_side"] == $user["player"]["fight_side"])) {
						$responseRoom["players"][] = $this->getResponsePlayer($user);
						$count++;
					}
				}
				$responseRoom["count"] = $count;
				break;
			default :
				foreach ($room["users"] as &$user) {
					$responseRoom["players"][] = $this->getResponsePlayer($user);
				}
				break;
		}
		return $responseRoom;
	}

	private function actionAuth(&$object, &$client) {
		//print "try auth " . $client->getId() . "\n";
		$key = $this->signed($object->data->id);
		$player = null;
		if (!($player = $this->cache->get("user_chat_" . $key))) {
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
				if (empty($this->users[$key])) {
					$this->users[$key] = array();
					$this->users[$key]["client"] = &$client;
					$this->users[$key]["queue"] = array();
					$this->users[$key]["player"] = &$player;
					$this->users[$key]["room"] = null;
					//$this->users[$key]["last_activity"] = time();
					$this->users[$key]["last_update"] = time();
					$this->users[$key]["key"] = $key;
					$this->users[$key]["mute_message_time"] = null;
					$this->users[$key]["mute_message_count"] = 0;

					$this->users2[$player["nickname"]] = &$this->users[$key];
					$this->users3[$client->getId()] = &$this->users[$key];
					//print "client auth " . $this->users[$key]["player"]["nickname"] . "\n";
				} else {
					if ($this->users[$key]["client"]) {
						$prevClient = &$this->users[$key]["client"];
						$data = array();
						$data["type"] = "system";
						$data["time"] = time();
						$data["reauth"] = true;
						$data["message"] = "В чат вошли этим персонажем с другого окна или компьютера. Для того, чтобы перезайти - обновите страницу.";

						$this->sendRequest($this->users[$key], "message", $data);

						$this->users[$key]["client"] = &$client;
						$this->users3[$client->getId()] = &$this->users[$key];
						unset($this->users3[$prevClient->getId()]);
						//print "client reauth " . $this->users[$key]["player"]["nickname"] . "\n";
						$prevClient->disconnect();
					} else {
						$this->users[$key]["client"] = &$client;
						$this->users3[$client->getId()] = &$this->users[$key];
					}
					//$this->users[$key]["last_activity"] = time();
					$this->users[$key]["last_update"] = time();
					unset($this->users[$key]["player"]);
					$this->users[$key]["player"] = &$player;
					/*
					$queueSize = sizeof($this->users[$key]["queue"]);
					for ($i = 0; $i < $queueSize; $i++) {
						$client->send(array_shift($this->users[$key]["queue"]));
					}
					*/
				}
				foreach ($this->rooms as &$room) {
					$data["rooms"][] = $this->getResponseRoom($room, $key);
				}
				$data["player"] = $this->getResponsePlayer($this->users[$key]);
				$this->sendResponse($client, "auth", $data);

			} else {
				$result = false;
			}
		} else {
			$result = false;
		}
		return $result;
	}

	private function updateUserInfo(&$user, $force = false, $forcePanic = false) {
		$key = $this->signed($user["player"]["id"]);
		$result = true;
		if (!empty($this->users[$key])) {
			$time = time();
			$fightId = $this->users[$key]["player"]["fight_id"];
			$fightState = $this->users[$key]["player"]["fight_state"];

			if (/*(($time - $this->users[$key]["last_update"]) > 10 || $forcePanic) && */$player = $this->cache->get("user_chat_" . $key)) {
				//print "load data from memcache \n";
				unset($this->users[$key]["player"]);
				$this->users[$key]["player"] = &$player;
				$this->users[$key]["last_update"] = $time;
			} else {
				if ($forcePanic || ($force && ($time - $this->users[$key]["last_update"]) > 10) || ($time - $this->users[$key]["last_update"]) > 60) {
					$auth = file_get_contents(self::API . "auth/" . $user["player"]["id"] . "/" . $user["player"]["password"] . "/" . $key . "/");
					if (trim($auth) != "null") {
						$player = json_decode($auth, true);
						if ($player) {
							unset($this->users[$key]["player"]);
							$this->users[$key]["player"] = &$player;
							$this->users[$key]["last_update"] = $time;
						} else {
							$result = false;
						}
					} else {
						$result = false;
					}
				}
			}

			if ($this->users[$key]["room"]["code"] == "battle" && $fightId != null && $this->users[$key]["player"]["fight_id"] == null) {
				// Были в бою но вышли (бой закончился или не попали)
				// Перекинуть в главную
				$data = array();
				$data["type"] = "system";
				$data["time"] = time();
				if ($fightState == "created") {
					$data["message"] = "Вы не попали в бой. Боевой чат завершён.";
				} else {
					$data["message"] = "Бой окончен. Боевой чат завершён.";
				}
				$this->sendRequest($this->users[$key], "message", $data);
			}
			if ($this->users[$key]["room"]["code"] == "battle" && $fightId != null && $this->users[$key]["player"]["fight_id"] != null && $fightId == $this->users[$key]["player"]["fight_id"] && $fightState == "created" && $this->users[$key]["player"]["fight_state"] == "started") {
				// Были в комнате до боя. И бой начался.
				$messageData = array();
				$messageData["type"] = "system";
				$messageData["message"] = "Бой начался, и теперь в Боевой комнате остались <b>только Ваши соратники</b>";
				$messageData["time"] = time();
				$this->sendRequest($this->users[$key], "message", $data);

				$comeData = array();
				foreach ($this->rooms["battle"]["users"] as $playerKey => &$user) {
					if ($user["player"]["fight_id"] == $this->users[$playerKey]["player"]["fight_id"]) {
						$user["player"]["fight_state"] = "started";
						$comeData["room"] = $this->getResponseRoom($this->rooms["room"], $playerKey);
						$this->sendRequest($user, "message", $messageData);
						$this->sendRequest($user, "come", $data);
					}
				}
			}
		} else {
			$result = false;
		}
		return $result;
	}

	private function actionCome(&$object, &$client) {
		$this->actionLeave($object, $client);
		if (isset($this->users[$object->data->key])) {
			// Авторизовались
			//$this->users[$object->data->key]["last_activity"] = time();
			if ($this->rooms[$object->data->room]) {
				// Комната существует. пробуем войти
				$this->updateUserInfo($this->users[$object->data->key], true, true);
				$allow = true;
				foreach ($this->rooms[$object->data->room]["conditions"] as &$condition) {
					$allow = $allow && $this->checkCondition($this->users[$object->data->key], $condition);
					if (!$allow) {
						$data = array();
						$data["room"] = $this->getResponseRoom($this->rooms[$object->data->room], $object->data->key);
						$this->sendResponse($client, "come", $data, false, $condition["error"]);
						break;
					}
				}
				if ($allow) {
					// Можно входить. Всё проверили
					$this->users[$object->data->key]["room"] = &$this->rooms[$object->data->room];
					$this->rooms[$object->data->room]["users"][$object->data->key] = &$this->users[$object->data->key];
					$this->rooms[$object->data->room]["count"]++;
					$data = array();
					$data["room"] = $this->getResponseRoom($this->rooms[$object->data->room], $object->data->key);
					$this->sendResponse($client, "come", $data);
					// Оповещаем комнату
					//$data["player"] = $this->getResponsePlayer($this->users[$object->data->key]);
					$this->notifyRoom($object->data->room, "come", $data, $object->data->key);
				}
			} else {
				// Запрашиваемой комнаты не существует
			}
		} else {
			return false;
		}
		return true;
	}

	private function actionLeave(&$object, &$client) {
		if (isset($this->users[$object->data->key])) {
			// Авторизовались
			//$this->users[$object->data->key]["last_activity"] = time();
			if ($this->users[$object->data->key]["room"]) {
				// Юзер находится в комнате и нужно из неё выйти
				$this->users[$object->data->key]["room"]["count"]--;
				unset($this->users[$object->data->key]["room"]["users"][$object->data->key]);

				$data = array();
				//$data["room"] = $this->getResponseRoom($this->users[$object->data->key]["room"]);
				//$data["player"] = $this->getResponsePlayer($this->users[$object->data->key]);
				$this->notifyRoom($this->users[$object->data->key]["room"]["code"], "leave", $data, $object->data->key);

				unset($this->users[$object->data->key]["room"]);
				$this->users[$object->data->key]["room"] = null;
				$data = array();
				//$data["rooms"] = array();
				//foreach ($this->rooms as &$room) {
				//	$data["rooms"][] = $this->getResponseRoom($room, $object->data->key);
				//}
				if ($client) {
					$this->sendResponse($client, "leave", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	private function actionMessageClan(&$object) {
		// Делаю не очень круто. Когда пользователей в пределах 1000 должно работать нормально.
		// Такой метод делает ненужным постоянный контроль за ещё одной структурой кланов, но зато надо бегать по массиву юзеров,
		// Чтобы раздать сообщения адресатам
		if ($this->users[$object->data->key]["player"]["clan"] != "0" && $this->users[$object->data->key]["player"]["clan_status"] != "recruit") {
			// Человек состоит в клане. Можно отправлять сообщения кланерам
			foreach ($this->users as &$user) {
				if ($user["player"]["clan"] == $this->users[$object->data->key]["player"]["clan"] && $user["player"]["clan_status"] != "recruit") {
					// Чувак принадлежит к тому же клану что и отправитель и должен получить сообщение. Отправляем.
					$this->sendMessage($this->users[$object->data->key], $user, $object, "clan");
				}
			}
		}
	}

	private function actionMessageBattle(&$object) {
		// Делаю не очень круто. Когда пользователей в пределах 1000 должно работать нормально.
		// Такой метод делает ненужным постоянный контроль за ещё одной структурой кланов, но зато надо бегать по массиву юзеров,
		// Чтобы раздать сообщения адресатам
		$this->updateUserInfo($this->users[$object->data->key]);

		if ($this->users[$object->data->key]["player"]["fight_id"] && $this->users[$object->data->key]["player"]["fight_state"]) {
			if ($this->users[$object->data->key]["player"]["fight_dt"] > time()) {
				foreach ($this->users as &$user) {
					if ($user["player"]["fight_id"] == $this->users[$object->data->key]["player"]["fight_id"]) {
						// Чувак находится в том же бою. Отправляем.
						$object->data->message = trim(str_replace(array("private [battle]", "to [battle]"), "", $object->data->message));
						if ($user["room"]["code"] != "battle") $object->data->message = "to [battle] " . $object->data->message;

						$this->sendMessage($this->users[$object->data->key], $user, $object);
					}
				}
			} else {
				foreach ($this->users as &$user) {
					if ($user["player"]["fight_id"] == $this->users[$object->data->key]["player"]["fight_id"] && $user["player"]["fight_side"] == $this->users[$object->data->key]["player"]["fight_side"]) {
						// Чувак находится в том же бою. Отправляем.
						$this->sendMessage($this->users[$object->data->key], $user, $object);
					}
				}
			}
		}
	}

	private function actionMessagePrivate(&$object, &$nicknames) {
		//$signedPlayer = $this->signed($object->data->player);
		$playersCount = sizeof($nicknames);
		$this->sendMessage($this->users[$object->data->key], $this->users[$object->data->key], $object, "private");
		foreach ($nicknames as $nickname) {
			if ($this->users2[$nickname]) {
				if ($object->data->key != $this->users2[$nickname]["key"])
					$this->sendMessage($this->users[$object->data->key], $this->users2[$nickname], $object, "private");
			} else {
				$data = array();
				$data["type"] = "system";
				if ($this->users[$object->data->key]["player"]["level"] == 1) {
					$data["message"] = "Игрок " . $nickname . " сейчас не в чате.";
				} else {
					$data["message"] = "Игрок " . $nickname . " сейчас не в чате. Ему было отправлено личное сообщение.";
					$text = base64_encode($object->data->message);
					$nickname = base64_encode($nickname);
					file_get_contents(self::API . "private/" . $this->users[$object->data->key]["player"]["id"] . "/" . $nickname . "/" . $text . "/" . $this->signed($this->users[$object->data->key]["player"]["id"] . $nickname . $text) . "/");
				}
				$data["time"] = time();
				$this->sendRequest($this->users[$object->data->key], "message", $data);
			}
		}
	}

	private function actionMessageRoom(&$object) {
		if ($this->users[$object->data->key]["room"]) {
			switch ($this->users[$object->data->key]["room"]["code"]) {
				case "clan" :
					$this->actionMessageClan($object);
					break;
				case "battle" :
				// Вот тут должна происходить магия.  Отправление сообщений в предбоевой и боевой чат различаются. Поэтому нужно постоянно держать информацию актуальной.
				// За за этого может быть много запросов к апи. В запросе будет выполняться авторизация и получение данных и пользователе и его боях.
					$this->updateUserInfo($this->users[$object->data->key]);
					if ($this->users[$object->data->key]["player"]["fight_id"] && $this->users[$object->data->key]["player"]["fight_state"]) {
						// Чувак находится в бою или перед боем
						if ($this->users[$object->data->key]["player"]["fight_dt"] > time()) {
							foreach ($this->users as &$user) {
								if ($user["player"]["fight_id"] == $this->users[$object->data->key]["player"]["fight_id"]) {
									// Чувак находится в том же бою. Отправляем.
									if ($user["room"]["code"] == $this->users[$object->data->key]["room"]["code"]) {
										// Чувак в комнтае. Убираем to battle
										$object->data->message = trim(str_replace(array("private [battle]", "to [battle]"), "", $object->data->message));
									} else {
										// Чуак не в боевой комнате. Добавляем to battle
										$object->data->message = "to [battle] " . $object->data->message;
									}
									$this->sendMessage($this->users[$object->data->key], $user, $object);
								}
							}
						} else {
							foreach ($this->users as &$user) {
								if ($user["player"]["fight_id"] == $this->users[$object->data->key]["player"]["fight_id"] && $user["player"]["fight_side"] == $this->users[$object->data->key]["player"]["fight_side"]) {
									// Чувак находится в том же бою. Отправляем.
									if ($user["room"]["code"] == $this->users[$object->data->key]["room"]["code"]) {
										// Чувак в комнтае. Убираем to battle
										$object->data->message = trim(str_replace(array("private [battle]", "to [battle]"), "", $object->data->message));
									} else {
										// Чуак не в боевой комнате. Добавляем to battle
										$object->data->message = "to [battle] " . $object->data->message;
									}
									$this->sendMessage($this->users[$object->data->key], $user, $object);
								}
							}
						}
					} else {
						$data = array();
						$data["type"] = "system";
						$data["message"] = "Бой завершён. Общение в этой комнате остановлено.";
						$data["time"] = time();
						$this->sendRequest($this->users[$object->data->key], "message", $data);
					}
					break;
				case "quiz" :
					$object->data->message = str_replace("private [quiz]", "to [quiz]", $object->data->message);
					foreach ($this->users[$object->data->key]["room"]["users"] as &$user) {
						$this->sendMessage($this->users[$object->data->key], $user, $object);
					}
					if ($this->quizState == "question_asked") {
						$answer = mb_strtolower(trim(str_replace("to [quiz]", "", $object->data->message)), "UTF-8");

						if ($answer == mb_strtolower($this->quizAnswer, "UTF-8")) {
							$data = array();
							$data["type"] = "quiz";
							$data["sender"] = $this->getQuizPlayer();

							$data["message"] = "Игрок " . $this->users[$object->data->key]["player"]["nickname"] . " первым отвечает правильно и получает 1 очко. Переходим к следующему вопросу.";
							$data["time"] = time();

							$this->notifyRoom("quiz", "message", $data);

							$this->quizState = "question_answered";
							file_get_contents(self::API . "quiz/" . $this->users[$object->data->key]["player"]["id"] . "/" . $this->signed($this->users[$object->data->key]["player"]["id"]) . "/");
						}

					}
					break;
				default :
				// Чувак находится в комнате и может в неё писать
					foreach ($this->users[$object->data->key]["room"]["users"] as &$user) {
						$this->sendMessage($this->users[$object->data->key], $user, $object);
					}
					break;
			}
		} else {
			// Чувак попытался написать сообщение не находясь в комнате
		}
	}

	private function actionMessage(&$object, &$client) {
		if (isset($this->users[$object->data->key])) {
			// Авторизовались
			$object->data->time = time();

			if ($this->users[$object->data->key]["player"]["mute_chat"] && $this->users[$object->data->key]["player"]["mute_chat"] > $object->data->time) {
				$data = array();
				$data["period"] = $this->formatPeriod($this->users[$object->data->key]["player"]["mute_chat"] - $object->data->time);
				$this->sendResponse($client, "message", $data, false, "mute");
				return true;
			}

			//print $this->users[$object->data->key]["mute_message_time"] . "\n";
			if ($this->users[$object->data->key]["mute_message_time"] && ($object->data->time - $this->users[$object->data->key]["mute_message_time"]) < 15) {
				$this->users[$object->data->key]["mute_message_count"]++;
				//print $this->users[$object->data->key]["mute_message_count"] . "\n";
			} else {
				$this->users[$object->data->key]["mute_message_time"] = $object->data->time;
				//print $this->users[$object->data->key]["mute_message_count"] . "\n";
				$this->users[$object->data->key]["mute_message_count"] = 0;
			}

			if ($this->users[$object->data->key]["mute_message_count"] >= 5) {
				$data = array();
				$muteTime = 60 * 15;
				$data["period"] = $this->formatPeriod($muteTime);
				$muteTime += $object->data->time;
				$this->sendResponse($client, "message", $data, false, "automute");
				file_get_contents(self::API . "automute/" . $this->users[$object->data->key]["player"]["id"] . "/" . $muteTime . "/" . $this->signed($this->users[$object->data->key]["player"]["id"] . $muteTime) . "/");
				//print self::API . "automute/" . $this->users[$object->data->key]["player"]->id . "/" . $muteTime . "/" . $this->signed($this->users[$object->data->key]["player"]->id . $muteTime) . "/\n";
				// Пользователь есть в чате. Накладываем молчанку
				$this->users[$object->data->key]["player"]["mute_chat"] = $muteTime;
				return true;
			}

			//$this->users[$object->data->key]["last_activity"] = $object->data->time;

			if (!$this->users[$object->data->key]["player"]["captcha"]) {
				$this->updateUserInfo($this->users[$object->data->key], true, true);
			}
			if (!$this->users[$object->data->key]["player"]["captcha"]) {
				$data = array();
				$this->sendResponse($client, "message", $data, false, "captcha");
				return true;
			}

			$object->data->message = htmlspecialchars(addslashes($object->data->message));

			if ($this->users[$object->data->key]["player"]["level"] > 1 && (strpos($object->data->message, "to [clan]") !== false || strpos($object->data->message, "private [clan]") !== false)) {
				$type = self::MESSAGE_CLAN;
			} elseif ($this->users[$object->data->key]["player"]["level"] > 1 && (strpos($object->data->message, "to [battle]") !== false || strpos($object->data->message, "private [battle]") !== false)) {
				$type = self::MESSAGE_BATTLE;
			} elseif (strpos($object->data->message, "private [") === 0 && strpos($object->data->message, "private [quiz]") === false && strpos($object->data->message, "private [battle]") === false) {
				$type = self::MESSAGE_PRIVATE;
				preg_match_all("~private\s?\[([^\]]+)\]~", $object->data->message, $nicknames);
				$nicknames = $nicknames[1];
			} else {
				$type = self::MESSAGE_ROOM;
			}

			switch ($type) {
				case self::MESSAGE_ROOM : $this->actionMessageRoom($object);
					break;
				case self::MESSAGE_PRIVATE : $this->actionMessagePrivate($object, $nicknames);
					break;
				case self::MESSAGE_CLAN : $this->actionMessageClan($object);
					break;
				case self::MESSAGE_BATTLE : $this->actionMessageBattle($object);
					break;
			}
		} else {
			return false;
		}
		return true;
	}

	private function sendMessage(&$sender, &$recipient, &$object, $type = "general") {
		$data = array();
		$data["type"] = $type;
		$data["sender"] = $this->getResponsePlayer($sender);

		$data["message"] = $object->data->message;
		//$data["time"] = date("H:i:s", $object->data->time);
		$data["time"] = $object->data->time;

		if ($sender["player"]["isolate_chat"] && $sender["player"]["isolate_chat"] > time()) {
			if ($recipient == $sender) $this->sendRequest($recipient, "message", $data);
		} else {
			$this->sendRequest($recipient, "message", $data);
		}
	}

	private function actionComplain(&$object, &$client) {
		return true;
	}

	private function actionMute(&$object, &$client) {
		if (isset($this->users[$object->data->key])) {
			// Авторизовались
			if ($this->users[$object->data->key]["player"]["mute_chat_access"]) {
				// Может ставить молчанку
				$time = time();
				$muteTime = $time + $object->data->time;
				$signedPlayer = $this->signed($object->data->player);
				if ($this->users[$signedPlayer]) {
					$moderatorId = $this->users[$object->data->key]["player"]["id"];
					$playerId = $this->users[$signedPlayer]["player"]["id"];
					$period = $object->data->time;
					$text = base64_encode($object->data->reason);
					file_get_contents(self::API . "mute/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . $text . "/" . $this->signed($moderatorId . $playerId . $period . $text) . "/");
					//print self::API . "mute/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . $text . "/" . $this->signed($moderatorId . $playerId . $period . $text) . "/\n";
					// Пользователь есть в чате. Накладываем молчанку
					$this->users[$signedPlayer]["player"]["mute_chat"] = $muteTime;
					//$this->users[$signedPlayer]["mute"] = $muteTime;
					// Оповещаем комнату

					$data = array();
					$data["moderator"] = $this->getResponsePlayer($this->users[$object->data->key]);
					$data["player"] = $this->getResponsePlayer($this->users[$signedPlayer]);
					$data["reason"] = $object->data->reason;
					$data["period"] = $this->formatPeriod($object->data->time);
					//$data["time"] = date("H:i:s", time());
					$data["time"] = $time;

					if ($this->users[$signedPlayer]["room"]) {
						$this->notifyRoom($this->users[$signedPlayer]["room"]["code"], "mute", $data);
					}
					if ($client) $this->sendResponse($client, "mute", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	private function actionIsolate(&$object, &$client) {
		if (isset($this->users[$object->data->key])) {
			// Авторизовались
			if ($this->users[$object->data->key]["player"]["mute_chat_access"]) {
				// Может ставить изоляцию
				$time = time();
				$muteTime = $time + $object->data->time;
				$signedPlayer = $this->signed($object->data->player);
				if ($this->users[$signedPlayer]) {
					$moderatorId = $this->users[$object->data->key]["player"]["id"];
					$playerId = $this->users[$signedPlayer]["player"]["id"];
					$period = $object->data->time;
					$text = base64_encode($object->data->reason);
					file_get_contents(self::API . "isolate/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . $text . "/" . $this->signed($moderatorId . $playerId . $period . $text) . "/");
					//print self::API . "isolate/" . $moderatorId . "/" . $playerId . "/" . $period . "/" . $text . "/" . $this->signed($moderatorId . $playerId . $period . $text) . "/\n";
					// Пользователь есть в чате. Накладываем изоляцию
					$this->users[$signedPlayer]["player"]["isolate_chat"] = $muteTime;

					$data = array();
					$data["moderator"] = $this->getResponsePlayer($this->users[$object->data->key]);
					$data["player"] = $this->getResponsePlayer($this->users[$signedPlayer]);
					$data["reason"] = $object->data->reason;
					$data["period"] = $this->formatPeriod($object->data->time);
					//$data["time"] = date("H:i:s", time());
					$data["time"] = $time;

					if ($client) $this->sendResponse($client, "isolate", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	private function actionUnmute(&$object, &$client) {
		if (isset($this->users[$object->data->key])) {
			// Авторизовались
			if ($this->users[$object->data->key]["player"]["mute_chat_access"]) {
				// Может снимать молчанку
				$muteTime = time() + $object->data->time;
				$signedPlayer = $this->signed($object->data->player);
				if ($this->users[$signedPlayer]) {
					$moderatorId = $this->users[$object->data->key]["player"]["id"];
					$playerId = $this->users[$signedPlayer]["player"]["id"];
					$text = base64_encode($object->data->reason);
					file_get_contents(self::API . "unmute/" . $moderatorId . "/" . $playerId . "/" . $this->signed($moderatorId . $playerId) . "/");
					//print self::API . "unmute/" . $moderatorId . "/" . $playerId . "/" . $this->signed($moderatorId . $playerId) . "/\n";
					// Пользователь есть в чате. Снимаем молчанку
					$this->users[$signedPlayer]["player"]["mute_chat"] = null;
					// Оповещаем юзера

					$data = array();
					$data["moderator"] = $this->getResponsePlayer($this->users[$object->data->key]);
					$data["player"] = $this->getResponsePlayer($this->users[$signedPlayer]);

					if ($this->users[$signedPlayer]["room"]) {
						$this->notifyRoom($this->users[$signedPlayer]["room"]["code"], "unmute", $data);
					}
					if ($client) $this->sendResponse($client, "unmute", $data);
				}
			}
		} else {
			return false;
		}
		return true;
	}

	private function actionUnisolate(&$object, &$client) {
		if (isset($this->users[$object->data->key])) {
			// Авторизовались
			if ($this->users[$object->data->key]["player"]["mute_chat_access"]) {
				// Может снимать изоляцию
				$muteTime = time() + $object->data->time;
				$signedPlayer = $this->signed($object->data->player);
				if ($this->users[$signedPlayer]) {
					$moderatorId = $this->users[$object->data->key]["player"]["id"];
					$playerId = $this->users[$signedPlayer]["player"]["id"];
					$period = $object->data->time;
					$text = base64_encode($object->data->reason);
					file_get_contents(self::API . "unisolate/" . $moderatorId . "/" . $playerId . "/" . $this->signed($moderatorId . $playerId) . "/");
					//print self::API . "unisolate/" . $moderatorId . "/" . $playerId . "/" . $this->signed($moderatorId . $playerId) . "/\n";
					// Пользователь есть в чате. Снимаем изоляцию
					$this->users[$signedPlayer]["player"]["isolate_chat"] = null;

					$data = array();
					$data["moderator"] = $this->getResponsePlayer($this->users[$object->data->key]);
					$data["player"] = $this->getResponsePlayer($this->users[$signedPlayer]);

					if ($client) $this->sendResponse($client, "unisolate", $data);

				}
			}
		} else {
			return false;
		}
		return true;
	}

	private function actionRooms(&$object, &$client) {
		if (isset($this->users[$object->data->key])) {
			$data = array();
			$data["rooms"] = array();
			foreach ($this->rooms as &$room) {
				if (!empty($room)) $data["rooms"][] = $this->getResponseRoom($room, $object->data->key);
			}
			if ($client) {
				$this->sendResponse($client, "rooms", $data);
			}
		}
		return true;
	}

	private function getQuizPlayer() {
		$player = array();
		$player["id"] = 0;
		$player["nickname"] = "Викторина";
		$player["clan_id"] = 0;
		$player["clan_name"] = "";
		$player["fraction"] = "";
		$player["level"] = 0;
		$player["mute_chat_access"] = false;
		return $player;
	}

	private function actionQuiz(&$object, &$client) {
		if ($object->data->key == "quizquizquiz1~") {
			if (isset($object->data->answer) && !empty ($object->data->answer)) {
				$this->quizAnswer = $object->data->answer;
				$this->quizState = "question_asked";
			}

			if (isset($object->data->message) && !empty ($object->data->message)) {
				$data = array();
				$data["type"] = "quiz";
				$data["sender"] = $this->getQuizPlayer();

				$data["message"] = $object->data->message;
				$data["time"] = time();

				$this->notifyRoom("quiz", "message", $data);
			}
			//$this->sendRequest($recipient, "message", $data);

		}
	}

	private function actionQuit(&$object, &$client) {
		$this->actionLeave($object, $client);
		return false;
	}

	public function exec(&$object, &$client) {
		if (is_object($object)) {
			switch ($object->action) {
				case "quiz" : return $this->actionQuiz($object, $client);
					break;
				case "auth" : return $this->actionAuth($object, $client);
					break;
				case "come" : return $this->actionCome($object, $client);
					break;
				case "leave" : return $this->actionLeave($object, $client);
					break;
				case "message" : return $this->actionMessage($object, $client);
					break;
				case "complain" : return $this->actionComplain($object, $client);
					break;
				case "mute" : return $this->actionMute($object, $client);
					break;
				case "isolate" : return $this->actionIsolate($object, $client);
					break;
				case "unmute" : return $this->actionUnmute($object, $client);
					break;
				case "unisolate" : return $this->actionUnisolate($object, $client);
					break;
				case "quit" : return $this->actionQuit($object, $client);
					break;
				case "rooms" : return $this->actionRooms($object, $client);
					break;
			}
		} else {
			return false;
		}
	}
}
?>