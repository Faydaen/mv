<?php
$_COOKIE['contentico__php_errors'] = 'contentico@1';
$_COOKIE['contentico__sql_debug'] == 'contentico@1';

include('config.php');
include('config2.php');
include('@lib/const.php');
include('@lib/i.php');
include('@lib/ds.'.$configDb['type'].($_COOKIE['sql_debug'] == 1 ? '.debug' : '').'.php');
include('@lib/std.php');
include('@lib/runtime.php');
include('@obj/object.php');
include('@lib/objectcollection.php');
include('@mod/const.php');
include('@mod/page.php');

define('CONTENTICO', false);


if ($config['xslt'] == 1)
{
	include('@lib/cache'.($config['cache'] == 0 ? '.empty' : '').'.php');
	include('@lib/pageTemplate.php');
	include('@lib/pageXHTML.php');
	include('@lib/pageXSL.php');
}
$module = new Page();

Std::loadLib('ImageTools');
$photos = Page::$sql->getRecordSet("select id from photo where id <= 48044");
$photosSize = sizeof($photos);
for ($i = 0; $i < $photosSize; $i++) {
	$path = '@images/photos/' . $photos[$i]["id"] . '.jpg';
	if (file_exists($path)) ImageTools::applyWatermark($path, "@/images/logo-photos.png", "BOTTOM_RIGHT", 0, 0);
}
?>