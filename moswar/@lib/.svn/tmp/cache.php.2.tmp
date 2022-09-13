<?php
class Cache extends Memcache {
	public $getTime = 0;
	public $getCount = 0;
	public $setTime = 0;
	public $setCount = 0;
	public $localCache = array();

	public function  __construct() {
		//parent::__construct();
		//parent::addServer("192.168.200.1", 11211);
        if (DEV_SERVER) {
            parent::pconnect("localhost", 11211);
        } else {
            parent::pconnect("10.1.4.3", 11211);
        }
	}

	public function  __wakeup() {
		if (DEV_SERVER) {
            parent::connect("localhost", 11211);
        } else {
            parent::connect("10.1.4.3", 11211);
        }
	}

	public function  __sleep() {
		parent::close();
	}

	public function set($key, $var, $expire = 0, $flag = 0, $dependences = array()) {
		_debug('cache::set -> ' . $key);
		$t = microtime(true);
		$res = parent::set($key, $var, $flag, $expire);
		$this->setTime += microtime(true) - $t;
		$this->setCount ++;
		$this->localcache[$key] = $var;
		return $res;
	}
	
	public function get($key) {
		if (!is_array($key) && isset($this->localcache[$key])) {
			return $this->localcache[$key];
		}
		if (is_array($key)) {
			$r = array();
			$exists = array();
			foreach ($key as $q => $k) {
				if (isset($this->localcache[$k])) {
					$r[$k] = $this->localcache[$k];
					unset($key[$q]);
				}
			}
			if (!is_array($key) || count($key) == 0) {
				return $r;
			}
			_debug('cache::get -> ' . print_r($key, true));
		} else {
			_debug('cache::get -> ' . $key);
		}
		
		$t = microtime(true);
		$res = parent::get($key);
		$this->getTime += microtime(true) - $t;
		$this->getCount ++;
		
		if (is_array($key)) {
			foreach ($key as $k) {
				$this->localcache[$k] = '';
			}
		
			foreach ($res as $k => $v) {
				if ($v === false) {
					$v = '';
				}
				$this->localcache[$k] = $v;
				$res = array_merge($res, $r);
			}
			
		} else {
			$this->localcache[$key] = $res;
		}
		return $res;
	}

    public function delete($key) {
		return parent::delete($key, 0);
	}
}
?>