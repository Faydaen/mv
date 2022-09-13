<?php

class GMail {
	public static function getContacts($email, $password) {
		$context = stream_context_create(array(
			"http" => array(
				"method" => "POST",
				"header" => "Content-Type: application/x-www-form-urlencoded" . PHP_EOL,
				"content" => "accountType=HOSTED_OR_GOOGLE&Email=" . $email . "&Passwd=" . $password . "&service=cp&source=informico-contacts-1"
			)
		));

		$data = @file_get_contents("https://www.google.com/accounts/ClientLogin", false, $context);
		if (!$data) return null;
		$data = explode("Auth=", $data);
		$auth = $data[1];

		$context = stream_context_create(array(
			"http" => array(
				"method" => "GET",
				"header" => "Authorization: GoogleLogin auth=" . $auth . PHP_EOL,
				"content" => ""
			)
		));

		$xml = file_get_contents("http://www.google.com/m8/feeds/contacts/" . $email . "/full", false, $context);
		$dom = new DOMDocument;
		$dom->loadXML($xml);
		$s = simplexml_import_dom($dom);
		$contacts = array();
		foreach ($s->entry as $entry) {
			$gd = $entry->children("http://schemas.google.com/g/2005");
			$contacts[] = array("name" => (string) $entry->title[0], "email" => (string) $gd->attributes()->address[0]);
		}
		return $contacts;
	}
}
?>
