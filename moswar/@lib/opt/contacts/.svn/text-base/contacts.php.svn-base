<?php
class Contacts {
	public static function getContacts($email, $password) {
		switch (Contacts::getEmailType($email)) {
			case "gmail" :
				require("gmail.php");
				return GMail::getContacts($email, $password);
				break;
			case "ynadex" :
				require("yandex.php");
				return Yandex::getContacts($email, $password);
				break;
			case "rambler" :
				require("rambler.php");
				return Rambler::getContacts($email, $password);
				break;
			default :
				return null;
				break;
		}
	}

	private static function getEmailType($email) {
		if (stripos($email, "@yandex.ru")) return "yandex";
		if (stripos($email, "@rambler.ru")) return "rambler";
		if (stripos($email, "@lenta.ru")) return "rambler";
		if (stripos($email, "@myrambler.ru")) return "rambler";
		if (stripos($email, "@autorambler.ru")) return "rambler";
		if (stripos($email, "@ro.ru")) return "rambler";
		if (stripos($email, "@r0.ru")) return "rambler";
		if (stripos($email, "@gmail.com")) return "gmail";
	}
}
?>
