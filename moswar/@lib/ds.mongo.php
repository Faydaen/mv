<?php

class MongoDataSource {

	public static $instance = null;
	private $serverLink = null;
	private $db = null;

	public static function getInstance() {
		if (empty(self::$instance)) {
			self::$instance = new MongoDataSource();
			if (self::$instance->connect()) {
				if (self::$instance->selectDatabase()) {
					return self::$instance;
				}
			}
			self::$instance = null;
			return false;
		} else {
			return self::$instance;
		}
	}

	public function connect() {
		global $configMongo;
		$this->serverLink = new Mongo($configMongo["host"], array("persist" => ""));
		$this->serverLink->connect();
		if ($this->serverLink) {
			return true;
		} else {
			return false;
		}
	}

	public function selectDatabase() {
		global $configMongo;
		$this->db = $this->serverLink->selectDB($configMongo["db"]);
		return true;
	}

	public function getDb() {
		return $this->db;
	}
}

?>
