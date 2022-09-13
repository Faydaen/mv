<?php
class Cache {
	private $cacheIndex;

	public function connect($ip, $port) {
		return true;
	}

	public function close() {
		return true;
	}

	public function get($name) {
		return false;
	}
	 
	public function set($key, $var, $flag = 0, $expire = 0, $dependences = array()) {
		return true;
	}
	 
	public function deleteDependences($dependences = array()) {
		return true;
	}
}
?>