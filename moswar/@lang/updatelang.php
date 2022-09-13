#!/usr/bin/php -q
<?php
$langCode = $argv[1];
if (empty ($langCode)) die("Укажите язык");

$xml = file_get_contents("lang_" . $langCode . ".xml");
$dom = new DOMDocument;
$dom->loadXML($xml);
$s = simplexml_import_dom($dom);

$a = $s->xpath("file");
$length = sizeof($a);

function cmp($a, $b)
{
	if (mb_strlen($a["ru"], "UTF-8") == mb_strlen($b["ru"], "UTF-8")) {
		return 0;
	}
	return (mb_strlen($b["ru"], "UTF-8") < mb_strlen($a["ru"], "UTF-8")) ? -1 : 1;
}

for ($i = 0; $i < $length; $i++) {
	$file = (string) $a[$i]->attributes()->name[0];
	$content = file_get_contents($file);
	$strings = array();
	for ($j = 0; $j < sizeof($a[$i]->str); $j++) {
		$strings[] = array("ru" => trim((string) $a[$i]->str[$j]->ru[0]), "lang" => trim((string) $a[$i]->str[$j]->lang[0]));
	}
	usort($strings, "cmp");
	foreach ($strings as $string) {
		if (!empty($string["lang"])) {
			$content = str_replace($string["ru"], $string["lang"], $content);
			//$content = preg_replace("/" . preg_quote($string["ru"]) . "([^\-А-ЯЁа-яё!.,\?0-9 ])/", $string["lang"] . "$1", $content);
		}
	}
	$fp = fopen($file, "w");
	fputs($fp, $content);
	fclose($fp);
}
?>
