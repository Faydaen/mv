<?php
include('config.php');
include('config2.php');
include('@lib/i.php');
include('@lib/ds.'.$configDb['type'].'.debug.php');
include('@lib/std.php');
include('@lib/runtime.php');
include('@lib/const.php');
include('@lib/ui.element.php');
include('@lib/contentico.php');
include('@obj/object.php');
include('@lib/objectcollection.php');
include('@contentico/@mod/module.php');
include('cacheobjects.php');
include('@lib/cachemanager.php');
include('@lib/cache.php');

define('CONTENTICO', true);

header ("Content-Type: text/html; charset=".$GLOBALS['config']['headerCharset']);
session_start();
error_reporting(E_ALL ^ E_NOTICE);

if (!function_exists("_debug")) {
	function _debug($a) { }
}

Std::loadModule("Page");
Page::initData();
Page::initCache();
Page::initSql();
cacheManager::init(Page::$cache, Page::$sql, $GLOBALS['cacheObjects']);

$moduleCode = $_GET['_m'] ? preg_replace('/[^\w]/', '', $_GET['_m']) : 'Index';
Contentico::loadModule($moduleCode);
$module = new $moduleCode();
$module->processRequest();
$module->renderPage();
?>