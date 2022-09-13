<?php
class SocketManager {
	private static $socketMap = array();
	//private static $sockets = array();

	public static function addSocket(&$client, $id = null) {
		if ($id != null) {
			self::$socketMap[$id] = &$client;
			//self::$sockets[$id] = &$client->_socket;
		}
	}

	public static function handleEvents() {
		//print "There are " . count(self::$socketMap) . " sockets\n";
		//print memory_get_usage() . "\n";
		//$readsocks = self::$sockets;
		$writesocks = array();
		$readsocks = array();

		foreach (self::$socketMap as $id => &$so) {
			if (is_object($so)) {
				$readsocks[$id] = $so->_socket;
			}
		}

		$thenull = NULL;
		$selres = @socket_select($readsocks, $writesocks, $thenull, 1);
		if ($selres === false) {
			//throw new Exception("Some error on select()", socket_last_error());
		} else if ($selres > 0) {
			foreach ($readsocks as $id => &$sock) {
				if (isset(self::$socketMap[$id]) && is_object(self::$socketMap[$id])) {
					self::$socketMap[$id]->onReadyToReceive();
				}
			}
		}

		foreach (self::$socketMap as $id => &$so) {
			if (!is_object($so)) { unset(self::$socketMap[$id]); continue; }
			if ($so->removeme === true) {
				$so->remove();
				print date("d-m-y H:i:s ") . "Removing socket: $so->id $so->_socket\n";
				@socket_shutdown($so->_socket);
				@socket_close($so->_socket);
				$id = $so->id;
				$so = null;
				unset($so);
				self::$socketMap[$id] = null;
				//self::$sockets[$id] = null;
				unset(self::$socketMap[$id]);
				//unset(self::$sockets[$id]);
				print date("d-m-y H:i:s ") . "Sockets count: " . count(self::$socketMap). "\n";
			}
		}
	}
}
?>