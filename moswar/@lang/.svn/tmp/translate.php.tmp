#!/usr/bin/php -q
<?php

if ($_GET["clean"] == "true") die();
if (empty($_GET["lang"]) && empty($_POST["action"])) {
	echo "<html><head><title>Локализатор</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /></head><body><h1>Локализатор</h1><ul>";
	$langs = file("langs.txt");
	for ($i = 0; $i < sizeof($langs); $i++) {
		$langs[$i] = trim($langs[$i]);
		if (!empty($langs[$i])) {
			$arr = explode("|", $langs[$i]);
			echo "<li><a href=\"translate.php?lang=" . $arr[0] . "\">" . $arr[1] . "</a></li>";
		}
	}
	echo "</ul></body></html>";
} else if ($_POST["action"] == "translate") {
	$langCode = $_POST["code"];
	if (@filesize("lang_" . $langCode . ".xml")) {
		$date = date("dmY");
		if (!file_exists("daybackup/lang_" . $langCode . "_" . $date . ".xml"))
			copy("lang_" . $langCode . ".xml", "daybackup/lang_" . $langCode . "_" . $date . ".xml");
		copy("lang_" . $langCode . ".xml", "lang_" . $langCode . "_prev.xml");
		$xml = file_get_contents("lang_" . $langCode . ".xml");
		$xml = preg_replace("!<lang id=\"" . $_POST["id"] . "\">.*</lang>!", "<lang id=\"" . $_POST["id"] . "\">" . str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST["lang"]) . "</lang>", $xml);
		$fp = fopen("lang_" . $langCode . ".xml", "r+");
		while(!flock($fp, LOCK_EX)) { sleep(1); }
		ftruncate($fp, 0);
		fputs($fp, $xml);
		fclose($fp);
	}
	header("Location: translate.php?clean=true");
} else if(!empty($_GET["id"])) {
	$langCode = $_GET["lang"];
	$xml = file_get_contents("lang_" . $langCode . ".xml");
	$dom = new DOMDocument;
	$dom->loadXML($xml);
	$s = simplexml_import_dom($dom);

	$a = $s->xpath("file[@id='" . $_GET["id"] . "']/str");
	$length = sizeof($a);
	$strings = array();
	for ($i = 0; $i < $length; $i++) {
		$key = (string) $a[$i]->lang->attributes()->id[0];
		$num = (string) $a[$i]->attributes()->num[0];
		$strings[$key] = array("id" => $key, "ru" => (string) $a[$i]->ru[0], "lang" => (string) $a[$i]->lang[0], "num" => $num);
	}
	echo "<html><head><title>Локализатор</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /></head><body><iframe name=\"service\" style=\"display: none;\"></iframe><h1>" . base64_decode($_GET["title"]) . "</h1><a href=\"translate.php?lang=" . $langCode . "\" />К списку файлов</a><ol>";
	$length = sizeof($strings);
	foreach ($strings as $string) {
		echo "<li><strong>" . htmlspecialchars($string["ru"]) . "</strong><form action=\"translate.php\" method=\"post\" target=\"service\"><input type=\"hidden\" name=\"code\" value=\"" . $_GET["lang"] . "\" /><input type=\"hidden\" name=\"id\" value=\"" . $string["id"] . "\" />#". $string["num"] ." <textarea rows=\"4\" style=\"width: 100%;\" name=\"lang\">" . htmlspecialchars($string["lang"]) . "</textarea> <input type=\"hidden\" name=\"action\" value=\"translate\" /><input type=\"submit\" value=\"Сохранить\" /></form></li>";
	}
	echo "</ul></body></html>";
} else {
	$langCode = $_GET["lang"];
	$xml = file_get_contents("lang_" . $langCode . ".xml");
	$dom = new DOMDocument;
	$dom->loadXML($xml);
	$s = simplexml_import_dom($dom);

	$a = $s->xpath("file");
	$length = sizeof($a);
	$strings = array();
	for ($i = 0; $i < $length; $i++) {
		$id = (string) $a[$i]->attributes()->id[0];
		$name = (string) $a[$i]->attributes()->name[0];
		$name = substr($name, 3);
		$strings[] = array("id" => $id, "name" => $name);
	}
	echo "<html><head><title>Локализатор</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /></head><body><iframe name=\"service\" style=\"display: none;\"></iframe><h1>Локализатор</h1><a href=\"translate.php\" />К списку языков</a><ul>";
	$length = sizeof($strings);
	foreach ($strings as $string) {
		echo "<li><a href=\"translate.php?id=" . $string["id"] . "&title=" . base64_encode($string["name"]) . "&lang=" . $_GET["lang"] . "\">" . $string["name"] . "</a></li>";
	}
	echo "</ul></body></html>";
}
?>