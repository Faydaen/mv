<?php

class Yandex {
	public static function getContacts($email, $password) {
		stream_context_set_default(array(
			"http" => array(
				"method" => "POST",
				"header" => "Content-Type: application/x-www-form-urlencoded" . PHP_EOL,
				"content" => "login=" . $email . "&passwd=" . $password
			)
		));
		$headers = get_headers("http://passport.yandex.ru/passport?mode=auth&retpath=http://mail.yandex.ru", 1);
		$setCookie = $headers["Set-Cookie"];
		stream_context_set_default(array(
			"http" => array(
				"method" => "GET"
				)
			));
		if (is_array($setCookie)) {
			$cookiesCount = sizeof($setCookie);
			$cookies = array();
			for ($i = 0; $i < $cookiesCount; $i++) {
				$cookie = explode("; ", $setCookie[$i]);
				$cookie = trim($cookie[0]);
				if (!empty($cookie)) {
					$cookies[] = $cookie;
				}
			}
			$cookies = implode("; ", $cookies);
			$context = stream_context_create(array(
				"http" => array(
					"method" => "POST",
					"header" => "Content-Type: application/x-www-form-urlencoded" . PHP_EOL . "Cookie: " . $cookies . PHP_EOL,
					"content" => "tp=1&rus=0"
					)
				));
			$data = file_get_contents("http://mail.yandex.ru/neo/ajax/action_abook_export", false, $context);
			$data = str_replace("\\\"", "", $data);
			$lines = explode("\n", $data);
			$linesCount = sizeof($lines);
			$contacts = array();
			for ($i = 1; $i < $linesCount; $i++) {
				preg_match_all("!(\"[^\"]\")?,(\"[^\"]\")?,(\"[^\"]\")?,(\"[^\"]\")?,(\"[^\"]\")?,(\"[^\"]\")?,(\"[^\"]\")?,\"(.*)\",(\"(.*)\"|,)!isU", trim($lines[$i]), $matches);
				if (!empty($matches[8]) && !empty($matches[8][0])) {
					$contacts[] = array("name" => iconv("WINDOWS-1251", "UTF-8", $matches[10][0]), "email" => $matches[8][0]);
				}
			}
			return $contacts;
		} else {
			return null;
		}
	}
}
?>
