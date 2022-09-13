<?php

class CacheManager {

	public static $cache;
	public static $sql;
	public static $preloadParams = array();
	public static $preloadKeys = array();
	
	public static $data = array();
	
	public static $localcache = array();
	
	public static function init($cache, $sql, $data) {
		self::$cache = $cache;
		self::$sql = $sql;
		self::$data = $data;
	}
	
	public static function multiGet() {
		$args = func_get_args();
		$argsSize = func_num_args();
		if (is_array($args[0])) {
			$params = $args[0];
			unset($args[0]);
		} else {
			$params = array();
		}
		if (is_array($args[1])) {
			$args = $args[1];
		}
		$keys = array_values($args);

		foreach (self::$preloadParams as $k => $v) {
			$params[$k] = $v;
		}
		foreach (self::$preloadKeys as $k) {
			if (!in_array($k, $keys)) {
				$keys[] = $k;
			}
		}
		self::$preloadKeys = self::$preloadParams = array();

		$results = array();
		foreach ($keys as $k => $v) {
			if (isset(self::$localcache[self::getMKey($k, $params)])) {
				$results[$k] = self::$localcache[self::getMKey($k, $params)];
				unset($keys[$k]);
			}
		}
		if (count($keys) == 0) {
			return $results;
		}

		$mKeys = array();
		if (function_exists("_debug")) {
			_debug('cachemanager::multiget -> ' . print_r($keys, true) . ': ' . print_r($params, true));
		}
		foreach ($keys as $key) {
			$mKeys[self::getMKey($key, $params)] = $key;
		}
		$mResults = self::$cache->get(array_keys($mKeys));
		foreach ($mKeys as $mkey => $key) {
			if (!isset($mResults[$mkey])) {
				$mResults[$mkey] = self::generateResult(self::$data[$key], $params);
				self::set($key, $mResults[$mkey], $params);
			}
			if ($mResults[$mkey] === 'NULL') {
				$mResults[$mkey] = false;
			}
			$results[$key] = $mResults[$mkey];
		}
		return $results;
	}
	
	public static function getSet($key, $fieldName, $ids) {
		$mKeys = array();
		if (!isset(self::$data[$key])) {
			die('cachemanager::getset -> unknown key (' . $key . ')');
		}
		$results = array();
		foreach ($ids as $k => $id) {
			if (isset(self::$localcache[self::getMKey($key, array($fieldName => $id))])) {
				$results[$id] = self::$localcache[self::getMKey($key, array($fieldName => $id))];
				unset($ids[$k]);
			}
		}
		if (count($ids) == 0) {
			return $results;
		}
		_debug('cachemanager::getset ' . $key . ' -> ' . $fieldName . ': ' . print_r($ids, true));
		foreach ($ids as $id) {
			$mKeys[self::getMKey($key, array($fieldName => $id))] = $id;
		}
		$mResults = self::$cache->get(array_keys($mKeys));
		$misses = array();
		foreach ($mKeys as $mkey => $id) {
			if (!isset($mResults[$mkey])) {
				if (self::$data[$key]['type'] == 'function') {
					$mResults[$mkey] = self::generateResult(self::$data[$key], array($fieldName => $id));
					self::set($key, $mResults[$mkey], array($fieldName => $id));
					if ($mResults[$mkey] === 'NULL') {
						$mResults[$mkey] = false;
					}
					$results[$id] = $mResults[$mkey];
				} else {
					$misses[$id] = $mkey;
				}
			} else {
				if ($mResults[$mkey] === 'NULL') {
					$mResults[$mkey] = false;
				}
				$results[$id] = $mResults[$mkey];
			}
		}
		if (count($misses)) {
			if (isset(self::$data[$key]['notnumericid'])) {
				$sql = str_replace(" = '{" . $fieldName . "}'", " IN ('" . implode("', '", array_keys($misses)) . "')", self::$data[$key]['getter']);
			} else {
				$sql = str_replace(" = {" . $fieldName . "}", " IN (" . implode(", ", array_keys($misses)) . ")", self::$data[$key]['getter']);
			}
			$rr = self::$sql->getRecordSet($sql);
			if ($rr) {
				foreach ($rr as $r) {
					self::set($key, $r, array($fieldName => $r['id']));
					$results[$r['id']] = $r;
				}
			} else {
				//var_dump($sql);
			}
		}
		return $results;
	}
	
	public static function updateData($key, $params, $updatedData, $getFromCacheBefore = false) {
		if ($getFromCacheBefore) {
			$data = self::$cache->get(self::getMKey($key, $params));
			if ($data === false) {
				return false;
			}
			$updatedData = array_merge($data, $updatedData);
		}
		self::set($key, $updatedData, $params);
	}

	/*
	 * CacheManager::get
	 *
	 * @param string $key
	 * @param [mixed $params]
	 */
	public static function get() {
		$params = self::putIndex(func_get_args(), 'key');
		if (!isset(self::$data[$params['key']])) {
			if (isset(self::$localcache[$key])) {
				return self::$localcache[$key];
			} else {
				$value = self::$cache->get($params['key']);
				self::$localcache[$key] = $value;
				return $value;
			}
			die('cachemanager::get -> unknown key (' . $params['key'] . ')');
		}
		
		$data = self::$data[$params['key']];
		if (!isset($params['params'])) {
			$params['params'] = array();
		}
		$mKey = self::getMKey($params['key'], $params['params']);
		if (isset(self::$localcache[$mKey])) {
			return self::$localcache[$mKey];
		}
		_debug('cachemanager::get -> ' . $params['key'] . ': ' . print_r($params['params'], true));

		$value = self::$cache->get($mKey);
		if ($value === 'NULL' && $params['key'] == 'pet_full') {
			$value = false;
		}
		if ($value === false) {
			$value = self::forceReload($params['key'], $params['params']);
		}
		if ($value === 'NULL') {
			$value = false;
		}
		return $value;
	}
	
	public static function forceReload($key, $params = array()) {
		$value = self::generateResult(self::$data[$key], $params);
		self::set($key, $value, $params);
		return $value;
	}
	
	public static function set($key, $value, $params = array()) {
		_debug('cachemanager::set -> ' . $key . ': ' . print_r($params, true));
		self::setToCache($key, $value, $params);
	}
	
	private static function setToCache($key, $value, $params) {
		if ($value === false) {
			$value = 'NULL';
		}
		$mKey = self::getMKey($key, $params);
		self::$localcache[$mKey] = $value;
		self::$cache->set($mKey, $value, self::$data[$key]['time']);
		self::deleteDependencies($key, $params);
	}
	
	private static function getMKey($key, $params) {
		$mKey = self::$data[$key]['mkey'];
		if (is_array($params))
		foreach ($params as $k => $v) {
			$mKey = str_replace('{' . $k . '}', $v, $mKey);
		}
		return $mKey;
	}
	
	private static function deleteDependencies($key, $params) {
		if (isset(self::$data[$key]['depends'])) {
			foreach (self::$data[$key]['depends'] as $key) {
				self::delete($key, $params);
			}
		}
	}
	
	public static function delete($key, $params = array()) {
		self::$cache->delete(self::getMKey($key, $params));
		self::deleteDependencies($key, $params);
	}

	public static function deleteSet($key, $fieldName, $ids) {
		foreach ($ids as $id) {
			self::$cache->delete(self::getMKey($key, array($fieldName => $id)));
			self::deleteDependencies($key, array($fieldName => $id));
		}
	}
	
	private static function generateResult($data, $params) {
		switch ($data['type']) {
			case 'function':
				$result = $data['getter']($params);
				break;
				
			case 'value':
				$result = self::$sql->getValue(self::prepareSql($data['getter'], $params));
				break;
				
			case 'valueset':
				$result = self::$sql->getValueSet(self::prepareSql($data['getter'], $params));
				break;
			
			case 'record':
				$result = self::$sql->getRecord(self::prepareSql($data['getter'], $params));
				break;
				
			case 'recordset':
				$result = self::$sql->getRecordSet(self::prepareSql($data['getter'], $params));
				break;
				
			default:
				die('cachemanager: unsupported getter type (' . print_r($data, true) . ')');
		}
		return $result;
	}
	
	private static function putIndex() {
		$args = func_get_args();
		$argsCount = func_num_args();
		if ($argsCount < 1) {
			return $args[0];
		}
		$r = array();
		$data = func_get_arg(0);
		$dataSize = count($data);
		for ($i = 1; $i < $argsCount; $i ++) {
			if ($dataSize >= $i) {
				$r[$args[$i]] = $data[$i-1];
			} else {
				$r[$args[$i]] = null;
			}
		}
		if ($argsCount == $dataSize && is_array($data[$argsCount-1])) {
			$r['params'] = $data[$i-1];
		} else {
			for ($i = $argsCount; $i <= $dataSize; $i ++) {
				$r['params'][] = $data[$i-1];
			}
		}
		return $r;
	}
	
	private static function prepareSql($sql, $params) {
		foreach ($params as $key => $value) {
			$sql = str_replace('{' . $key . '}', $value, $sql);
		}
		return $sql;
	}
}

?>
