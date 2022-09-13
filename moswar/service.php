<?php

$microtime = microtime(true);
include('config.php');
include('config2.php');
include('@lib/const.php');
include('@lib/i.php');
include('@lib/ds.'.$configDb['type'].'.php');
include('@lib/ds.mongo.php');
include('@lib/std.php');
include('@lib/runtime.php');
include('@obj/object.php');
include('@lib/objectcollection.php');
include('@mod/const.php');
include('@mod/page.php');
include('cacheobjects.php');
include('@lib/cachemanager.php');

if ($config['xslt'] == 1)
{
	include('@lib/cache'.($config['cache'] == 0 ? '.empty' : '').'.php');
	include('@lib/pageTemplate.php');
	include('@lib/pageXHTML.php');
	include('@lib/pageXSL.php');
}

define('CONTENTICO', false);
define('SHELL', isset($_SERVER['SHELL']) ? true : false);

if (!SHELL) {
session_start();
}

$sql = SqlDataSource::getInstance();
$cache = new Cache();
		
cacheManager::init($cache, $sql, $GLOBALS['cacheObjects']);
// скрипт вызван из командной строки
if (SHELL) {
    error_reporting(E_ALL ^ E_NOTICE);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
    // первый аргумент из командной строки - модуль
    $moduleCode = $argv[1];
    // загрузка класса модуля
    Std::loadModule($moduleCode);
    // инициализация модуля
    $module = new $moduleCode();
    // обработка оставшихся аргументов из командной строки
    for ($i = 2, $j = sizeof($argv); $i < $j; $i++) {
        $module->shellArgs[] = $argv[$i];
    }
    // обработка запроса
    $module->processRequest();

// скрипт вызван через URL
} else {
    switch ($_GET['_a']) {
        // отправка файла на скачивание
        case 'file':
            sendFileToDownload();
            break;

        // удаленные SQL запросы
        case 'remotesql':
            remoteSql();
            break;
    }
}
$timeExecute = round(((microtime(true) - $microtime)) * 1000, 4);
writeTiming();
function writeTiming() {
	global $timeExecute, $module, $argv;
	return;
	
	$url = '/' . strtolower($_GET['_m']) . '/'. implode('/', $module->url) . '/';
	$url = '/' . trim($url, '/') . '/';
	$url = preg_replace('~^/alley/fight/.*$~', '/alley/fight/', $url);
	$url = preg_replace('~^/fight/ID/.*$~', '/fight/ID/', $url);
	$url = preg_replace('~^/huntclub/wanted/.*$~', '/huntclub/wanted/', $url);
	$url = preg_replace('~^/photos/ID/.*$~', '/photos/ID/', $url);
	$url = preg_replace('~^/player/giftaccept/ID/.*$~', '/player/giftaccept/ID/', $url);
	$url = preg_replace('~^/thimble/.*$/~', '/thimble/', $url);
	$url = preg_replace('~^/shop/.*$~', '/shop/', $url);
	$url = preg_replace('~^/forum/.*$~', '/forum/', $url);
	$url = preg_replace('~^/rating/.*$~', '/rating/', $url);
	
	
	$url = preg_replace('~\/([0-9]+)\/~', '/ID/', $url);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$method = 'post';
	} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$method = 'get';
	} else {
		$method = 'cron';
		$q = $argv;
		unset($q[0]);
		$url = implode('/', $q);
	}
	if (isset($_POST['action'])) {
		$action = mysql_escape_string($_POST['action']);
	} else {
		$action = '';
	}
	if ($timeExecute < 20) {
		$field = 'less20';
	} else if ($timeExecute < 50) {
		$field = 'less50';
	} else if ($timeExecute < 100) {
		$field = 'less100';
	} else if ($timeExecute < 200) {
		$field = 'less200';
	} else if ($timeExecute < 500) {
		$field = 'less500';
	} else if ($timeExecute < 1000) {
		$field = 'less1000';
	} else if ($timeExecute < 5000) {
		$field = 'less5000';
	} else {
		$field = 'more5000';
	}
	$sql = "INSERT INTO timings	(url, method, action, " . $field . ", queries) VALUES ('" . $url . "', '" . $method . "', '" . $action . "', 1, " .  SqlDataSource::$queryCount. ") ON DUPLICATE KEY UPDATE " . $field . " = " . $field . " + 1, queries = queries + " . SqlDataSource::$queryCount;
	Page::$sql->query($sql);
}

/**
 * Отправка файла на скачивание
 */
function sendFileToDownload()
{
    $file = $sql->getRecord("SELECT name, path, size FROM stdfile WHERE id=" . (int)$_GET['id']);
    if ($file) {
        header('Content-Disposition: attachment; filename="'.$file['name'].'"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.$file['size']);
        header('HTTP/1.0 200 OK');
        header('Cache-Control: max-age=3600, must-revalidate');
        readfile('@files/'.$file['path']);
    } else {
        header('HTTP/1.0 404 Not Found');
        file_get_contents('@tpl/error/404.html');
    }
    exit;
}

/**
 * Удаленные SQL запросы
 */
function remoteSql()
{
    $email = Std::cleanString($_GET['email']);
    $pwd = sha1(trim($_GET['pwd']));
    $exportType = $_GET['export'];
    $userId = $sql->getValue("SELECT id FROM sysuser WHERE email='$email' AND pwd='$pwd' AND enabled=1");
    if ($userId) {
        $queryType = $_GET['type'];
        $query = base64_decode($_GET['query']);
        switch ($queryType) {
            case 'getvalue':
                $result = $sql->getValue($query);
                break;

            case 'getrecord':
                $result = $sql->getRecord($query);
                break;

            case 'getrecordset':
                $result = $sql->getRecordSet($query);
                break;

            case 'getinsert':
                $result = $sql->insert($query);
                break;

            case 'query':
            default:
                $result = $sql->query($query);
                break;
        }
        echo $exportType == 'json' ? Std::arrayToJson($result) : Std::arrayToXml($result);
    } else {
        echo $exportType == 'json' ?
            Std::arrayToJSON(array('error'=>'Authentication failed.')) :
            Std::arrayToXml(array('error'=>'Authentication failed.'));
    }
}

function _debug($log) {
	global $moswarDebugLog;
	$moswarDebugLog .= "<br />" . $log;
}
?>