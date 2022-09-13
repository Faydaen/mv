<?php

class Rambler {
	public static function getContacts($email, $password) {
		stream_context_set_default(array(
			"http" => array(
				"method" => "POST",
				"header" => "Content-Type: application/x-www-form-urlencoded" . PHP_EOL,
				"content" => "login=" . $email . "&passw=" . $password
			)
		));
		$headers = get_headers("http://id.rambler.ru/script/auth.cgi", 1);
		$setCookie = $headers["Set-Cookie"];
		stream_context_set_default(array(
			"http" => array(
				"method" => "GET"
				)
			));
		if (is_array($setCookie) && sizeof($setCookie) > 5) {
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
					"content" => ""
					)
				));
			$data = file_get_contents("http://mail.rambler.ru/mail/contacts.cgi", false, $context);
			preg_match_all("!<td><div class=\"cell\">.*<a class=\"email\"[^>]*>(.*)</a></div></td>[\s]*<td class=\"fn\"><div class=\"cell\">.*</span>(.*)</div>!isU", $data, $matches);
			$contacts = array();
			$matchesCount = sizeof($matches[1]);
			for ($i = 0; $i < $matchesCount; $i++) {
				
				if (!empty($matches[1][$i])) {
					$contacts[] = array("name" => $matches[2][$i], "email" => $matches[1][$i]);
				}
			}
			return $contacts;
		} else {
			return null;
		}
	}
}
?>
