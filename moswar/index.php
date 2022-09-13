<?php

if ((trim($_GET["url"], "/") == "faq/protivostoyanie" || trim($_GET["url"], "/") == "alley") &&
    (!isset($_COOKIE['authkey']) || !isset($_COOKIE['userid']))) {
    //header("http://www.moswar.ru/index.html");
    exit;
}

//if ((!isset($_COOKIE['authkey']) || !isset($_COOKIE['userid'])) && (!isset($_POST['email']) || !isset($_POST["password"]))) {
//    header("http://www.moswar.ru/index.html");
//    exit;
//}


/*$ips = array('95.26.63.99','87.117.189.197','85.199.75.154','178.162.181.101', '178.206.194.182', '79.120.10.3','94.180.162.71','88.231.86.47','78.106.20.38','89.232.124.116', "85.93.150.50", "81.25.168.209", "94.180.156.134", "85.112.113.75", "92.255.212.149", '89.184.30.219', '91.79.120.125', '95.220.166.104', '95.26.239.179',
    '91.79.133.255', '178.205.47.31', '93.80.215.145', '95.220.176.114', '91.79.112.49', '89.184.22.155', '95.220.189.84', '91.79.118.117'); //1
if (!in_array($_SERVER['REMOTE_ADDR'], $ips)) {
	header('Location: /closed.html'); exit;
}*/


//$time = time();
//$microtime = microtime(true);
/*
if (!apc_exists('configDb')) {
	include('config.php');
	include('config2.php');
	apc_add('config', $config, 600);
	apc_add('configDb', $configDb, 600);
	apc_add('configProject', $configProject, 600);
	apc_add('data', $data, 600);
} else {
	$config = apc_fetch('config');
	$configDb = apc_fetch('configDb');
	$configProject = apc_fetch('configProject');
	$data = apc_fetch('data');
	define('TPL', '@tpl');
}*/
//$t = microtime(true);
$tmpData = apc_fetch(array('config', 'configDb', 'configProject', 'data'));
if (!$tmpData['config'] || !$tmpData['configDb'] || !$tmpData['configProject'] || !$tmpData['data']) {
	$t = microtime(true);
	include('config.php');
	include('config2.php');
	apc_add('config', $config, 600);
	apc_add('configDb', $configDb, 600);
	apc_add('configProject', $configProject, 600);
	apc_add('data', $data, 600);
} else {
	define('TPL', '@tpl');
}

$microtime = microtime(true);
$time = time();
include('config.php');
include('config2.php');
include('@lib/const.php');
include('@lib/i.php');
include('@lib/ds.'.$configDb['type'].($_COOKIE['sql_debug'] == 1 ? '.debug' : '').'.php');
include('@lib/ds.mongo.php');
include('@lib/ds.sphinx.php');
include('@lib/std.php');
include('@lib/runtime.php');
include('@obj/object.php');
include('@lib/objectcollection.php');
include('@mod/const.php');
include('@mod/page.php');
include('cacheobjects.php');
include('@lib/cachemanager.php');

//$ips = array('85.199.75.154','178.162.181.101','79.120.10.3','94.180.162.71','88.231.86.47','78.106.20.38','89.232.124.116', "85.93.150.50", "81.25.168.209"); //1
//if (!in_array($_SERVER['REMOTE_ADDR'], $ips)) {
    //$userId = Page::tryAutoLogin2();
	//if ($userId) {
	//	header("X-Accel-UserID: " . $userId);
	//}
//    header('Location: /closed.html'); exit;
//}

define('CONTENTICO', false);

if ($config['xslt'] == 1)
{
	include('@lib/cache'.($config['cache'] == 0 ? '.empty' : '').'.php');
	include('@lib/pageTemplate.php');
	include('@lib/pageXHTML.php');
	include('@lib/pageXSL.php');
}

if (preg_replace('/[^\w]/', '', $_GET['_m']) != 'API') {
	session_start();
}
//header ("Content-Type: text/html; charset=".Std::HEADER_CHARSET);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");


$moduleCode = $_GET['_m'] ? preg_replace('/[^\w]/', '', $_GET['_m']) : 'Page';
if ($moduleCode == 'Index' && isset ($_COOKIE['authkey'], $_SESSION['authkey']) && $_COOKIE['authkey'] == $_SESSION['authkey']) {
	//header ('Location: /player/');
	//exit;
}
Std::loadLang();
if ($moduleCode == 'Page')
{
    $module = new Page();
    $module->getPage();
    if ($module->moduleCode != 'Page')
    {
        $moduleCode = $module->moduleCode;
    }
}
if ($moduleCode != 'Page')
{
    Std::loadModule($moduleCode);
    $module = new $moduleCode();
}
$module->processRequest();
$module->renderPage();

$timeExecute = round(((microtime(true) - $microtime)) * 1000, 4);

writeTiming();

if ((DEV_SERVER && $_COOKIE['contentico__sql_debug'] == 'contentico@1') || Page::isAdminFor('debug-panel')) {
	$queryTime = 0;
	foreach (SqlDataSource::$queryStatistics as $query) {
		$queryTime += $query['Time'];
	}
	
	ob_start();
	passthru("ifconfig | grep 10.1.4");
	$result = ob_get_contents();
	ob_end_clean();
	$result = trim($result);
	preg_match("!10\.1\.\d+\.\d+!", $result, $matches);
	$servers = array('10.1.4.3' => 'megahero', '10.1.4.16' => 'moswar01', '10.1.4.23' => 'moswar02', '10.1.4.24' => 'moswar03', '10.1.4.25' => 'moswar04', '10.1.4.26' => 'moswar05', '10.1.4.27' => 'moswar06');
	if (isset($servers[$matches[0]])) {
		$server = $servers[$matches[0]];
	} else {
		$server = $matches[0];
	}
	echo '<center><small><b>' . $server . '</b> &bull; Time: ' . $timeExecute . ' ms &bull; XSL: ' . round (PageXSL::$time * 1000, 4) . ' ms &bull; MySQL: ' . SqlDataSource::$queryCount . ' qrs, ' . round($queryTime * 1000, 4) . ' ms - <a onclick="$(\'#mysqlLog\').show();">log</a> &bull; Memcached: ' . Page::$cache->getCount . '(' . round(Page::$cache->getTime * 1000, 4) . 'ms)/' . Page::$cache->setCount . '(' . round(Page::$cache->setTime * 1000, 4) . 'ms) &bull; Memory: ' . floor(memory_get_usage(true)/1024) . ' KB</small></center>';
	echo '<div style="background-color: white; display: none; width: 70%; position: absolute; left: 15%; top: 50px; border: 1px dashed black; padding: 2px; z-index: 99;" id="mysqlLog">
	<center><a onclick="$(\'#mysqlLog\').hide();">close</a></center>';
	$max = -1;
	foreach (SqlDataSource::$queryStatistics as $key => $query) {
		if ($max == -1 || $query['Time'] > SqlDataSource::$queryStatistics[$max]['Time']) {
			$max = $key;
		}
	}
	foreach (SqlDataSource::$queryStatistics as $key => $query) {
		$color = null;
		if (strtolower(substr($query['Query'], 0, 3)) == 'set') {
			$color = 'silver';
		} else if (strtolower(substr($query['Query'], 0, 7)) == 'execute') {
			$color = 'gray';
		} else if (strtolower(substr($query['Query'], 0, 6)) == 'insert') {
			$color = 'red';
		} else if (strtolower(substr($query['Query'], 0, 6)) == 'update' ||
					strtolower(substr($query['Query'], 0, 7)) == 'prepare') {
			$color = 'green';
		}

		if ($color !== null) {
			echo '<span style="color: ' . $color . ';">';
		}
		echo $query['Query'] . ' ';
		if ($key == $max) {
			echo '(<b>' . round($query['Time'] * 1000, 6) . ' ms</b>)';
		} else {
			echo '(' . round($query['Time'] * 1000, 6) . ' ms)';
		}
		if ($color !== null) {
			echo '</span>';
		}
		echo '<br />';
		if ($key != count(SqlDataSource::$queryStatistics) - 1) {
			echo '<hr />';
		}
	}
	if (strlen($moswarDebugLog)) {
		echo $moswarDebugLog;
	}
	echo '</div>';
}
function _debug($log) {
	global $moswarDebugLog;
	$moswarDebugLog .= "<br />" . $log;
}

function writeTiming() {
	global $timeExecute, $module;

	return;
	
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
	$url = preg_replace('~^/player/ID/.*$~', '/player/ID/', $url);
	$url = preg_replace('~^/clan/ID/.*$~', '/clan/ID/', $url);
	$url = preg_replace('~^/clan/profile/warstats/.*$~', '/clan/profile/warstats/', $url);
	$url = preg_replace('~^/clan/warstats/ID/.*$~', '/clan/warstats/ID/', $url);
	
	
	$url = preg_replace('~\/([0-9]+)\/~', '/ID/', $url);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$method = 'post';
	} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$method = 'get';
	} else {
		$method = 'cron';
		$url = implode('/', $argv);
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

 /*
 $office_ips = array('79.120.10.3','94.180.162.71','88.231.86.47','78.106.20.38','89.232.124.116', "85.93.150.50", "81.25.168.209"); 
if (in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $office_ips) || in_array($_SERVER['REMOTE_ADDR'], $office_ips)) {
	ob_start();
	passthru("ifconfig | grep 10.1.4");
	$result = ob_get_contents();
	ob_end_clean();
	$result = trim($result);
	preg_match("!10\.1\.\d+\.\d+!", $result, $matches);
  	print $matches[0];
}
*/

?>