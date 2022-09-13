#!/usr/bin/php -q
<?php
//define the path as relative
if (isset($_GET["lang"])) {
	$langCode = $_GET["lang"];
} else {
	$langCode = $argv[1];
}
if (empty ($langCode)) die("Укажите язык");
if ($xml = @file_get_contents("lang_" . $langCode . ".xml")) {
	$dom = new DOMDocument;
	@$dom->loadXML($xml);
	$s = @simplexml_import_dom($dom);
}

function scanResource($path) {
	$path = "../" . $path;
	if (is_dir($path)) {
		$dirHandle = @opendir($path);
		if ($dirHandle) list_dir($dirHandle, $path);
	} else {
		scanFile($path);
	}
}

$lang = "";
$lang .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<lang>\n";

$resources = file("resources.txt");
for ($i = 0; $i < sizeof($resources); $i++) {
	$resources[$i] = trim($resources[$i]);
	if (!empty($resources[$i])) scanResource($resources[$i]);
}

$lang .= "</lang>\n";

$fp = fopen("lang_" . $langCode . ".xml", "w");
fputs($fp, $lang);
fclose($fp);
chmod("lang_" . $langCode . ".xml", 0666);

function scanFile($dir) {
	global $lang, $s;
	$content = file_get_contents($dir);
	preg_match_all("/[А-ЯЁа-яё]+([\-А-ЯЁа-яё!.,\?0-9 ]+)?/iu", $content, $matches);
	if (sizeof($matches[0]) > 0) {
		$lines = file($dir);
		$linesCount = sizeof($lines);

		$lang .= "\t<file name=\"" . $dir . "\" id=\"" . sha1($dir) . "\">\n";
		for ($i = 0; $i < $linesCount; $i++)  {
			preg_match_all("/[А-ЯЁа-яё]+([\-А-ЯЁа-яё!.,\?0-9 ]+)?/iu", $lines[$i], $matches);
			if (sizeof($matches[0]) > 0) {
				$tmp = trim($lines[$i]);
				if (!empty($tmp)) {
					$key = sha1($lines[$i]);
					$trans = "";

					if ($s) {
						$trans = $s->xpath("file/str[lang/@id='" . $key . "']");
						if ($trans && sizeof($trans)) {
							$trans = (string) $trans[0]->lang[0];
						} else {
							$trans = "";
						}
					}
					$lang .= "\t\t<str num=\"" . $i . "\">\n\t\t\t<ru>" . str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $lines[$i]) . "</ru>\n\t\t\t<lang id=\"" . $key . "\">" . $trans . "</lang>\n\t\t</str>\n";
				}

			}
		}
		//$matches[0] = array_unique($matches[0]);
		//$lang .= "\t<file name=\"" . $dir . "\" id=\"" . sha1($dir) . "\">\n";
		/*
		for ($i = 0; $i < sizeof($matches[0]); $i++) {
			$matches[0][$i] = trim($matches[0][$i]);
			if (!empty ($matches[0][$i])) {
				$key = sha1($matches[0][$i]);
				$trans = "";

				if ($s) {
					$trans = $s->xpath("file/str[lang/@id='" . $key . "']");
					if ($trans && sizeof($trans)) {
						$trans = (string) $trans[0]->lang[0];
					} else {
						$trans = "";
					}
				}
				$lang .= "\t\t<str>\n\t\t\t<ru>" . $matches[0][$i] . "</ru>\n\t\t\t<lang id=\"" . $key . "\">" . $trans . "</lang>\n\t\t</str>\n";
			}
		}
		*/

		$lang .= "\t</file>\n";
	}
}

function list_dir($dir_handle,$path) {
	global $lang, $s;
	while (false !== ($file = readdir($dir_handle))) {
		$dir = $path .'/'. $file;
		if(is_dir($dir) && $file != '.' && $file !='..' && $file != '.svn') {
			$handle = @opendir($dir) or die("undable to open file $file");
			list_dir($handle, $dir);
		}elseif($file != '.' && $file !='..' && $file != '.svn') {
			scanFile($dir);
		}
	}
	closedir($dir_handle);
}

?>