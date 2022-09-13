<?php
class ClientSock {
	public $_socket;
	public $state;
	public $ip;
	public $port;
	public $data;
	public $removeme;
	public $id;
	public $lastHeartbeat;

	public function __construct( &$socket ) {
		global $listenport;
		$this->lastHeartbeat = time();
		$this->id = uniqid("sock", true);
		$this->_socket = $socket;
		@socket_getpeername( $socket, $this->ip, $this->port);
		print "New client: " . $this->ip . ":" . $this->port . " socket " . $socket . "\n";
		$this->data = "";
		$this->removeme = false;
		$this->send('<?xml version="1.0"?><!DOCTYPE cross-domain-policy SYSTEM "http://www.adobe.com/xml/dtds/cross-domain-policy.dtd"><cross-domain-policy><allow-access-from domain="*" to-ports="' . $listenport . '" /></cross-domain-policy>');
		//$this->removeme = true; to quit
	}

	public function remove() {
		Chat::kickUserByClientId($this->id);
	}

	public function getId() {
		return $this->id;
	}

	public function wantsToReceive() {
		/*
		$time = time();
		if ($this->lastHeartbeat < ($time - 15)) {
			$ping = array();
			$ping["action"] = "p";
			$this->send(json_encode($ping));
			$this->lastHeartbeat = $time;
		}
		*/
		return true;
	}

	public function wantsToSend() {
		return false;
	}

	public function onReadyToReceive() {
		$data = @socket_read($this->_socket, 1024);
		if ( $data === false ) {
			$etype = @socket_last_error($this->_socket);
			//@socket_shutdown($this->_socket);
			//@socket_close($this->_socket);
			$this->removeme = true;

			if (!$etype) $etype = "UNDEFINED";
			print date("d-m-y H:i:s ") . "Client read ERROR: " . $etype . " " . $this->ip ."\n";
			//if (   $etype != SOCKET_EAGAIN
			//		&& $etype != SOCKET_EINTR ) {
				//print "Client ERROR: {$this->ip}:{$this->port}\n";
			//	$this->removeme = true;
			//}
			//print "Other ERROR: {$this->ip}:{$this->port}\n";
		}
		else if ( strlen($data) == 0 ) {
			//print "Client disconnected: {$this->ip}:{$this->port}\n";
			//@socket_shutdown($this->_socket);
			//@socket_close($this->_socket);
			$this->removeme = true;
		}
		else {
			//print "Client data from {$this->ip}:{$this->port}: $data\n";
			$this->onQueryReceived($data);
		}
	}

	public function send($msg) {
		if (is_resource($this->_socket)) {
			//print $msg . "\n";
			$write = @socket_write($this->_socket, $msg . "\0");
			if ($write === false) {
				$etype = socket_last_error($this->_socket);
				//@socket_shutdown($this->_socket);
				//@socket_close($this->_socket);
				$this->removeme = true;

				print date("d-m-y H:i:s ") . "Client send ERROR: " + $etype . "\n";
			}
			return $write;
		} else {
			return false;
		}
	}

	public function sendResponse($action, &$data, $success = true, $error = "") {
		$response = array();
		$response["success"] = $success;
		$response["type"] = "response";
		$response["action"] = $action;
		$response["data"] = $data;
		if (!$success) $response["error"] = $error;
		$response = json_encode($response);
		return $this->send($response);
	}

	public function sendRequest($action, &$data) {
		$request = array();
		$request["type"] = "request";
		$request["action"] = $action;
		$request["data"] = $data;
		$request = json_encode($request);
		return $this->send($request);
	}

	public function onQueryReceived( $rdata ) {
		$this->data .= $rdata;
		if(strchr(strrev($this->data), "\n") !== false) {
			$this->handleQuery();
		}
	}

	private function handleQuery() {
		$command = $this->data;
		$this->data = "";
		$object = json_decode(trim($command));
		if (is_object($object)) {
			switch ($object->action) {
				case "casino" : return Chat::actionCasino($object, $this);
					break;
				case "quiz" : return Chat::actionQuiz($object, $this);
					break;
				case "auth" : return Chat::actionAuth($object, $this);
					break;
				case "come" : return Chat::actionCome($object, $this);
					break;
				case "leave" : return Chat::actionLeave($object, $this);
					break;
				case "message" : return Chat::actionMessage($object, $this);
					break;
				case "complain" : return Chat::actionComplain($object, $this);
					break;
				case "mute" : return Chat::actionMute($object, $this);
					break;
				case "isolate" : return Chat::actionIsolate($object, $this);
					break;
				case "unmute" : return Chat::actionUnmute($object, $this);
					break;
				case "unisolate" : return Chat::actionUnisolate($object, $this);
					break;
				case "quit" : return Chat::actionQuit($object, $this);
					break;
				case "rooms" : return Chat::actionRooms($object, $this);
					break;
				case "info" : return Chat::actionInfo($object, $this);
					break;
				case "system" : return Chat::actionSystem($object, $this);
					break;
				case "players" : return Chat::actionPlayers($object, $this);
					break;
				default: return false; break;
			}
		} else {
			return false;
		}
	}
}
?>