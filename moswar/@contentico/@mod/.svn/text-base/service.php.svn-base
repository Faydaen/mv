<?php
class Service extends ContenticoModule implements IModule {

	public function __construct() {
		parent::__construct();
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		$this->page["left-menu-index"] = "class=\"cur\"";
		$this->page["page-name"] = "Сервисы";
		$this->page["tab-content"] = "Сервисы";
		$this->path["Сервисы"] = "Service";

		$this->processUrl();
		if (!empty($_POST["action"])) {
			switch ($this->url[0]) {
				case "helphacked" :
					switch ($_POST["action"]) {
						case "payments" :
							$this->serviceActionHelpHackedCheckPayments();
							break;
						case "email" :
							$this->serviceActionHelpHackedChangeEmail();
							break;
					}
					break;
				case "promo" :
					$this->serviceActionPromo();
					break;
				case "pets" :
					switch ($_POST["action"]) {
						case "setwins" :
							$this->serviceActionPetsSetWins();
							break;
					}
					break;
				case "petskoma" :
					$this->serviceActionPetsKoma();
					break;
				case "repairrating":
					$this->serviceActionRepairRating();
					break;
				case "giveexp":
					$this->serviceActionGiveExp();
					break;
				case "giveitem":
					$this->serviceActionGiveItem();
					break;
				case "clanico":
					$this->serviceActionClanIco();
					break;
			}
		} else {
			switch ($this->url[0]) {
				case "logs" :
					$this->serviceLogs();
					break;
				case "helphacked" :
					$this->serviceHelpHacked();
					break;
				case "promo" :
					$this->servicePromo();
					break;
				case "pets" :
					$this->servicePets();
					break;
				case "petskoma" :
					$this->servicePetsKoma();
					break;
				case 'releaseplayers':
					$this->releasePlayersFromFights();
					break;
				case 'repairrating':
					$this->serviceRepairRating();
					break;
				case 'giveexp':
					$this->serviceGiveExp();
					break;
				case 'giveitem':
					$this->serviceGiveItem();
					break;
				case "groupfights":
					$this->serviceGroupFights();
					break;
				case "korm":
					$this->serviceKorm($_POST['level']);
					break;
				case "clanico":
				    $this->serviceClanIco();
				    break;
				default:
					$this->serviceIndex();
					break;
			}
		}

		parent::onAfterProcessRequest();
	}

	private function checkAccess($service) {
		$userId = $this->sqlGetValue("SELECT _id FROM sysuser WHERE id = " . Runtime::$uid);
		$objectId = $this->sqlGetValue("SELECT id FROM service WHERE code = '" . $service . "'");
		$metaobjectId = $this->sqlGetValue("SELECT id FROM metaobject WHERE code = 'service'");
		$right = $this->sqlGetValue("SELECT COUNT(*) FROM syssecurity WHERE sysuser_id = " . $userId . " AND metaobject_id = " . $metaobjectId . " AND metaview_id = 0 AND (object_id = " . $objectId . " OR object_id = 0)");
		return ($right) ? true : false;
	}

	public function serviceActionRepairRating() {
		if (!$this->checkAccess("rating")) return;

		$strings = $_POST["text"];
		$strings = explode("\n", $_POST["text"]);
		$count = 0;
		foreach ($strings as $string) {
			$ids[] = trim($string);
		}
		$sql = "update rating_player rp, player p set rp.fraction = p.fraction where p.id = rp.player and p.fraction != rp.fraction and rp.player IN (" . implode(', ', $ids) . ")";
		$this->sqlQuery($sql);
		$count += mysql_affected_rows();
		$sql = "update rating_player2 rp, player p set rp.fraction = p.fraction where p.id = rp.player and p.fraction != rp.fraction and rp.player IN (" . implode(', ', $ids) . ")";
		$this->sqlQuery($sql);
		$count += mysql_affected_rows();
		Std::redirect("/@contentico/Service/repairrating/" . $count . "/");
	}

	public function serviceRepairRating() {
		if (!$this->checkAccess("rating")) return;

		$this->path["Восстановление рейтинга"] = "Service/repairrating";
		$data = '<h1>Восстановление фракции в рейтинге</h1>';
		if (strlen($this->url[1]) > 0) {
			$count = intval($this->url[1]);
			$data .= "<strong>Исправлено фракций: " . $count . "</strong><br /><br />";
		}
		$data .= "Формат входных данных:<br/><strong>id_игрока</strong><br />Каждый новый игрок на новой строке<br /><br />";
		$data .= "<form action=\"/@contentico/Service/repairrating/\" method=\"post\">";
		$data .= '<input type="hidden" name="action" value="repairrating" />';
		$data .= "<textarea name=\"text\" cols=\"80\" rows=\"8\"></textarea><br />";
		$data .= "<button>Отправить</button>";
		$data .= "</form>";
		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceActionGiveItem() {
		if (!$this->checkAccess("give_item")) return;

		Std::loadLib("Cache");
		Std::loadModule("Page");
		Std::loadLib("cachemanager");
		Std::loadLang();
		Std::loadMetaObjectClass("player");

		cacheManager::init(Page::$cache, Page::$sql, $GLOBALS["cacheObjects"]);

		$strings = $_POST["text"];
		$strings = explode("\n", trim($_POST["text"]));
		$reason = Std::cleanString(trim($_POST["reason"]));
		if (empty ($reason)) {
			Std::redirect("/@contentico/Service/giveitem/reason/");
		}
		$count = 0;
		$stats = array("money" => 1, "honey" => 1, "ore" => 1, "exp" => 1, "petriks" => 1, "anabolics" => 1, "oil" => 1, "chips" => 1);
		foreach ($strings as $string) {
			$data = explode(" ", $string);
			$data[0] = intval(trim($data[0]));
			if (!$data[0]) continue;
			$data[1] = trim($data[1]);
			$data[2] = intval(trim($data[2]));
			if (!$data[2]) $data[2] = 1;
			$player = new playerObject();
			if (!$player->load($data[0])) continue;
			if ($data[1] == "money") {
				$sql = "UPDATE player2 SET addmoney = addmoney + " . intval($data[2]) . " WHERE player = " . intval($data[0]);
				$this->sqlQuery($sql);
				$result = true;
			} else {
			$actions = array();
			$action = array();
			if (isset($stats[$data[1]])) {
				$action["type"] = $data[1];
				$action[$data[1]] = $data[2];
				// stat
			} elseif($data[1] == "give_col_item") {
				$action["type"] = "give_col_item";
				$action["cid"] = $data[2];
			} else {
				$action["type"] = "give_item";
				$action["item"] = $data[1];
				$action["amount"] = $data[2];
				// item
			}
			$actions[] = $action;
			$result = Page::doActions($player, $actions);
			}
			if ($result) {
				$sql = "INSERT INTO `admin_give_item_log`(`admin`,`player`,`item`,`count`,`dt`,`ip`,`reason`) VALUES(" . Runtime::$uid . ", " . $data[0] . ", '" . Std::cleanString($data[1]) . "'," . $data[2] . ", NOW(), " . ip2long($_SERVER["REMOTE_ADDR"]) . ", '" . $reason . "')";
				$this->sqlQuery($sql);
				$count++;
			}

		}
		Std::redirect("/@contentico/Service/giveitem/" . $count . "/");
	}
	
	public function releasePlayersFromFights() {
		if (!$this->checkAccess("release")) return;

		$this->path["Освобождение игроков"] = "Service/releaseplayers";
		$data = '<h1>Освобождение игроков</h1>';
		
		$sql = "select id from player where state = 'frozen' and timer + 300 < unix_timestamp();";
		$players = $this->sqlGetValueSet($sql);
		if ($players) {
			$num1 = count($players);
			$sql = "update player set state = '' where id in (" . implode(", ", $players) . ")";
			$this->sqlQuery($sql);
		} else {
			$num1 = 0;
		}
		
		$sql = "select distinct f.id fight from player p left join fight f on f.id = p.stateparam where p.state = 'fight' and p.stateparam > 0 and f.id is not null and f.state = 'finished';";
		$fights = $this->sqlGetValueSet($sql);
		if ($fights) {
			$sql = "update player p, fight f set p.state = '', p.stateparam = '' where p.state = 'fight' and p.stateparam > 0 and f.id = p.stateparam and f.id is not null and f.state = 'finished' and f.id IN (" . implode(", ", $fights) . ")";
			$this->sqlQuery($sql);
			$num2 = mysql_affected_rows();
		} else {
			$num2 = 0;
		}
		$num3 = $num1 + $num2;
		
		$data .= "Освобождено замороженных игроков: <b>" . $num1 . "</b><br />" . PHP_EOL .
			"Освобождено повисших в боях игроков: <b>" . $num2 . "</b><br />" . PHP_EOL .
			"Освобождено всего: <b>" . $num3 . "</b>";
		
		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceActionGiveExp() {
		if (!$this->checkAccess("give_exp")) return;

		$strings = $_POST["text"];
		$strings = explode("\n", trim($_POST["text"]));
		$count = 0;
		foreach ($strings as $string) {
			list($playerId, $exp) = explode(' ', $string);
			if ($exp > 0) {
				$exp = ' + ' . $exp;
			}
			$sql = "update player set exp = exp " . $exp . " where id = " . $playerId;
			$this->sqlQuery($sql);
			$count ++;
		}
		Std::redirect("/@contentico/Service/giveexp/" . $count . "/");
	}

	public function serviceGiveItem() {
		if (!$this->checkAccess("give_item")) return;

		$this->path["Вернуть предметы"] = "Service/giveitem";
		$data = '<h1>Возвращение предметов игрокам</h1>';
		if (strlen($this->url[1]) > 0) {
			if ($this->url[1] == "reason") {
				$data .= "<strong>Укажите причину</strong><br /><br />";
			} else {
				$count = intval($this->url[1]);
				$data .= "<strong>Обработано игроков: " . $count . "</strong><br /><br />";
				$results = $this->sqlGetRecordSet("SELECT player, item, count FROM admin_give_item_log WHERE `admin` = " . Runtime::$uid . " ORDER BY id DESC LIMIT " . $count);
				$table = "";
				if ($results) {
					$table = "<style>table.stat { border: 2px solid #cccccc; border-collapse: collapse; width: auto; } table.stat td, table.stat th { padding: 2px 4px; border: 2px solid #cccccc; border-collapse: collapse; }</style>
						<table class=\"stat\"><tr><th>Игрок</th><th>Предмет</th><th>Количество</th></tr>";
					foreach ($results as $result) {
						$table .= "<tr>";
						$table .= "<td>" . $result["player"] . "</td>";
						$table .= "<td>" . $result["item"] . "</td>";
						$table .= "<td>" . $result["count"] . "</td>";
						$table .= "</tr>";
					}
					$table .= "</table><br />";
				}
				$data .= $table;
			}
		}
		$data .= "Формат входных данных:<br/><strong>id_игрока</strong> <strong>код_предмета</strong> <strong>количество</strong><br /><br />Каждый новый игрок на новой строке<br />Количество по умолчанию: 1<br /><br />";
		$data .= "<strong>Дополнительные коды:</strong><br />";
		$data .= "Монеты: <strong>money</strong><br />";
		$data .= "Руда: <strong>ore</strong><br />";
		$data .= "Нефть: <strong>oil</strong><br />";
		$data .= "Фишки: <strong>chips</strong><br />";
		$data .= "Анаболики: <strong>anabolics</strong><br />";
		$data .= "Петрики: <strong>petriks</strong><br />";
		$data .= "Опыт: <strong>exp</strong><br />";
		$data .= "<br />";
		$data .= "<form action=\"/@contentico/Service/giveitem/\" method=\"post\" onsubmit=\"if (document.getElementById('reason').value=='') { alert('Укажите причину'); return false; } \">";
		$data .= "<input type=\"hidden\" name=\"action\" value=\"giveitem\" />";
		$data .= "<strong>Причина: </strong><input type=\"text\" name=\"reason\" id=\"reason\" /><br /><br />";
		$data .= "<textarea name=\"text\" cols=\"80\" rows=\"8\"></textarea><br />";
		$data .= "<button>Отправить</button>";
		$data .= "</form>";

		$changes = $this->sqlGetRecordSet("SELECT s.email admin, a.player, a.item, a.count, a.ip, a.dt, a.reason FROM admin_give_item_log a INNER JOIN sysuser s ON s.id=a.admin WHERE a.dt >= NOW() - INTERVAL 2 DAY ORDER BY a.id DESC");
		if ($changes) {
			$table = "<h2>Последние изменения</h2><style>table.stat { border: 2px solid #cccccc; border-collapse: collapse; width: auto; } table.stat td, table.stat th { padding: 2px 4px; border: 2px solid #cccccc; border-collapse: collapse; }</style>
				<table class=\"stat\"><tr><th>Модератор</th><th>Игрок</th><th>Предмет</th><th>Количество</th><th>IP</th><th>Дата</th><th>Причина</th></tr>";
			foreach ($changes as $result) {
				$table .= "<tr>";
				$table .= "<td>" . $result["admin"] . "</td>";
				$table .= "<td>" . $result["player"] . "</td>";
				$table .= "<td>" . $result["item"] . "</td>";
				$table .= "<td>" . $result["count"] . "</td>";
				$table .= "<td>" . long2ip($result["ip"]) . "</td>";
				$table .= "<td>" . date("d.m.Y в H:i:s", strtotime($result["dt"])) . "</td>";
				$table .= "<td>" . $result["reason"] . "</td>";
				$table .= "</tr>";
			}
			$table .= "</table><br />";
			$data .= $table;
		}

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceGiveExp() {
		if (!$this->checkAccess("give_exp")) return;

		$this->path["Начисление опыта"] = "Service/giveexp";
		$data = '<h1>Начисление опыта</h1>';
		
		if (strlen($this->url[1]) > 0) {
			$count = intval($this->url[1]);
			$data .= "<strong>Затронуто игроков: " . $count . "</strong><br /><br />";
		}
		$data .= "Формат входных данных:<br/><strong>id_игрока опыт</strong><br />Каждый новый игрок на новой строке, чтобы снять опыт - указывать с минусом<br /><br />";
		$data .= "<form action=\"/@contentico/Service/giveexp/\" method=\"post\">";
		$data .= '<input type="hidden" name="action" value="giveexp" />';
		$data .= "<textarea name=\"text\" cols=\"80\" rows=\"8\"></textarea><br />";
		$data .= "<button>Отправить</button>";
		$data .= "</form>";
		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceHelpHacked() {
		if (!$this->checkAccess("help_hacked")) return;
		$this->path["Помощь взломанным"] = "Service/helphacked";
		$data = '<h1>Помощь взломанным</h1>';
		$data .= "<strong>ID взломанного игрока</strong> <input type=\"text\" id=\"player-id\" size=\"7\"/><br/>
				<br />Для проверки является ли обратившийся человек настоящим владельцем персонажа, необходимо узнать у него примерную дату регистрации в игре и информацию о последних платежах.<br />Если информация совпадает с указанными далее данными, то можно менять регистрационный e-mail.<br /><br />
			<button id=\"check-payments\" onclick=\"$.post('/@contentico/Service/helphacked/', { id: $('#player-id').val(), action: 'payments' }, function(data) { $('#payments').html(data); $('#email').html(''); $('#results').html(''); })\">Проверить платежи</button>";
		$data .= "<br /><br /><div id=\"payments\"></div>";
		$data .= "<br /><br /><div id=\"email\"></div>";
		$data .= "<div id=\"results\"></div>";

		$changes = $this->sqlGetRecordSet("SELECT s.email admin, a.player, a.old_email, a.new_email, a.ip, a.dt FROM admin_help_hacked_log a INNER JOIN sysuser s ON s.id=a.admin WHERE a.dt > (NOW() - INTERVAL 2 WEEK) ORDER BY a.id DESC");
		if ($changes) {
			$table = "<h2>Последние изменения</h2><style>table.stat { border: 2px solid #cccccc; border-collapse: collapse; width: auto; } table.stat td, table.stat th { padding: 2px 4px; border: 2px solid #cccccc; border-collapse: collapse; }</style>
				<table class=\"stat\"><tr><th>Модератор</th><th>Игрок</th><th>Старый e-mail</th><th>Новый e-mail</th><th>IP</th><th>Дата</th></tr>";
			foreach ($changes as $result) {
				$table .= "<tr>";
				$table .= "<td>" . $result["admin"] . "</td>";
				$table .= "<td>" . $result["player"] . "</td>";
				$table .= "<td>" . $result["old_email"] . "</td>";
				$table .= "<td>" . $result["new_email"] . "</td>";
				$table .= "<td>" . long2ip($result["ip"]) . "</td>";
				$table .= "<td>" . date("d.m.Y в H:i:s", strtotime($result["dt"])) . "</td>";
				$table .= "</tr>";
			}
			$table .= "</table><br />";
			$data .= $table;
		}

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceActionHelpHackedChangeEmail() {
		if (!$this->checkAccess("help_hacked")) return;
		$id = intval($_POST["id"]);
		$email = trim(Std::cleanString($_POST["email"]));
		if ($id) {
			if (!empty($email)) {
				$player = $this->sqlGetValue("SELECT id FROM player where email = '" . $email . "'");
				if (!$player) {
					$player = $this->sqlGetRecord("SELECT email FROM player where id = " . $id);
					if ($player) {
						$this->sqlQuery("UPDATE player SET email = '" . $email . "' WHERE id = " . $id);
						$sql = "INSERT INTO `admin_help_hacked_log`(`admin`,`player`,`old_email`,`new_email`,`dt`,`ip`) VALUES(" . Runtime::$uid . ", " . $id . ", '" . $player["email"] . "','" . $email . "', NOW(), " . ip2long($_SERVER["REMOTE_ADDR"]) . ")";
						$this->sqlQuery($sql);

						echo "Для завершения процедуры смены регистрационного почтового адреса игроку необходимо запросить сбор пароля ( http://www.moswar.ru/auth/remind/ ), указав новый e-mail.";
					} else {
						echo "<strong>Пользователя не существует</strong>";
					}
				} else {
					echo "<strong>Пользователь с таким e-mail уже существует</strong>";
				}
			} else {
				echo "<strong>Укажите e-mail</strong>";
			}
		} else {
			echo "<strong>Укажите пользователя</strong>";
		}
		die();
	}

	public function serviceActionHelpHackedCheckPayments() {
		if (!$this->checkAccess("help_hacked")) return;
		$id = intval($_POST["id"]);
		if ($id) {
			$player = $this->sqlGetRecord("SELECT id, registeredtime FROM player where id = " . $id);
			if ($player) {
				$payments = $this->sqlGetRecordSet("SELECT value, type, dt FROM payment WHERE player = " . $id . " ORDER BY dt DESC LIMIT 10");
				$result = "<strong>Дата регистрации:</strong> " . date("d.m.Y в H:i:s", strtotime($player["registeredtime"])) . "<br /><br />";
				if ($payments) {
					$result .= "<ul>";
					foreach ($payments as $payment) {
						$result .= "<li>" . date("d.m.Y в H:i:s", strtotime($payment["dt"])) . " &mdash; <strong>" . $payment["value"] .  " рублей</strong> (" . $payment["type"] . ")</li>";
					}
					$result .= "</ul>";
				} else {
					$result .= "<strong>Платежей нет</strong>";
					$result .= "<br /><br />";
				}
				$result .= "Если информация обратившегося игрока совпадает с указанными выше данными, то можно менять регистрационный e-mail.";
				$result .= "<br /><br /><strong>Новый e-mail</strong> <input type=\"hidden\" id=\"player-id-c\" value=\"" . $id .  "\" /><input type=\"text\" id=\"player-email\" />	<button id=\"check-payments\" onclick=\"$.post('/@contentico/Service/helphacked/', { email: $('#player-email').val(), id: $('#player-id-c').val(), action: 'email' }, function(data) { $('#results').html(data); })\">Изменить e-mail</button>";
				echo $result;
			} else {
				echo "<strong>Пользователя не существует</strong>";
			}
		} else {
			echo "<strong>Укажите пользователя</strong>";
		}
		die();
	}


	public function serviceKorm($level){
	if (!$this->checkAccess("korm")) return;
	$data = '';


	$data .= '<form action="/@contentico/Service/korm/" method="post">';
	
	$data .= 'Уровень персонажа ';
	$data .= '<select name="level">';
	$data .= '<option value=1>уровень 1</option>';
	$data .= '<option value=2>уровень 2</option>';
	$data .= '<option value=3>уровень 3</option>';
	$data .= '<option value=4>уровень 4</option>';
	$data .= '<option value=5>уровень 5</option>';
	$data .= '<option value=6>уровень 6</option>';
	$data .= '<option value=7>уровень 7</option>';
	$data .= '<option value=8>уровень 8</option>';
	$data .= '<option value=9>уровень 9</option>';
	$data .= '<option value=10>уровень 10</option>';
	$data .= '<option value=11>уровень 11</option>';
	$data .= '<option value=12>уровень 12</option>';
	$data .= '<option value=13>уровень 13</option>';
	$data .= '<option value=14>уровень 14</option>';
	$data .= '<option value=15>уровень 15</option>';
	$data .= '<option value=16>уровень 16</option>';
	$data .= '</select>';
	$data .= '<input type="submit">';
	$data .= '</form><br>';

	if (is_numeric($level) && $level>0 && $level<17){ 

	    $minimum = $this->sqlGetRecord("SELECT health, strength, dexterity, resistance, intuition, attention FROM levelstat WHERE level=" . $level . " AND type=1 LIMIT 0,1");
	    $where = 'accesslevel>0 AND state<>"police"';
	    $query= "SELECT id, nickname FROM player WHERE {$where} AND level={$level} LIMIT 1, 100";
	    $users = $this->sqlGetRecordSet($query);

	    //пробегаемся по всем не сидящем в тюрме и не заблокированым игрокам
	    if ($users){
		foreach($users as $user)
		{
		    //получаем характеристики персонажа
		    $current = $this->sqlGetRecord("SELECT health, strength, dexterity, resistance, intuition, attention, charism FROM player WHERE id={$user['id']}");
		    //$data .= '<a href="/player/'.$user['id'].'/">'.$user['nickname'].'</a> '.$user['id'].'<br>' ;
		    
			$normalStats = false;
			$normalStats2 = false;
			foreach($current as $key=>$param)
			{
			    //каждый стат меньше харизмы
			    if ($current['charism']>$param && $param != 'charism'){
				//$data .= $key.'=<font color="red"><b>'.$param.'</font></b> ';
			    }
			    else
			    {
				//если хотя бы один параметр нормальный то с игрока снимается все подозрения на мультиводство
				if ($key != 'charism'){
				$normalStats = true;
				}
			    }

			    //все статы (кроме харизмы) меньше средних на уровне 5 раз
			    if ($minimum[$key]>=$param*5 && $param != 'charism')
			    {
			       //
			    }
			    else
			    {
			       //если хотябы один стат норамальный то ставим флакг что всё хорошо
			       if ($key != 'charism'){
			       $normalStats2 = true;
			       }
			    }
			}

			if (!$normalStats || !$normalStats2){
			$strange[] = $user['id'];
			}
		}
	    }

	    $Mult = $this->getMultInfo($strange);

	    $Infidel = array();
	    //пробегаемся по всем кормушкам и состовляем 3 списка (медовики,брошенные не медовики, со связими+без связей)

	    $honeyList = '<input type="checkbox" id="allHon">Все<br>';
	    $lostList = '<input type="checkbox" id="allLos">Все<br>';
	    $kormList = '<input type="checkbox" id="allKor">Все<br>';
	    if (count($Mult))
	    {
		foreach ($Mult as $korm){

		$kormRekord = '';
 		$kormRekord .= '<input type="checkbox" ';

		if ($korm['honey'])
		{
		$kormRekord .= 'class = "honeyChBx" ';
		}
		elseif($korm['lost'])
		{
		$kormRekord .= 'class = "lostChBx" ';
		}
		else
		{
		$kormRekord .= 'class = "kormChBx" ';
		}

		$kormRekord .= 'name="korm'.$korm['id'].'">';
		$kormRekord .= '<a href="/player/'.$korm['id'].'">'.Page::getPlayerNameByID($korm['id']);
		$kormRekord .= '['.$korm['level'].']';
		$kormRekord .='</a>';

		if ($korm['honey']){
		$honeyList .= $kormRekord.$this->writeBRorLISTS($korm['GiftList'], $korm['CookList'],'hl'.$korm['id']);
		}elseif($korm['lost']){
		$lostList .= $kormRekord.$this->writeBRorLISTS($korm['GiftList'], $korm['CookList'],'ll'.$korm['id']);
		}else//в поле мультов
		{
		    $kormList .= $kormRekord.$this->writeBRorLISTS($korm['GiftList'], $korm['CookList'],'kl'.$korm['id']);
		    //если есть кто в подарках то выводим их
	

		}

		//получить списко хозяев кормушек
		$Infidel = array_merge($Infidel,$korm['CookList']);
		}
	    }

	    $Infidel = array_unique($Infidel);
	    $Infidel = $this->getMultInfo($Infidel);




	    $linkToMusters = '<input type="checkbox" id="allInf">Все<br>';
	    foreach ($Infidel as $infid)
	    {

		$linkToMusters .= '<input type="checkbox" name="korm'.$infid['id'].'" class = "InfidelChBx" >';
	    	$linkToMusters .= '<a href="/player/'.$infid['id'].'">'.Page::getPlayerNameByID($infid['id']);
		$linkToMusters .= '['.$infid['level'].']';
		$linkToMusters .= '</a>';
		$linkToMusters .= $infid['honey'] ? $medImg : '';
		$linkToMusters .= $infid['lost'] ? $lostImg : '';
		//дописываем раскрывающюся панель со всеми кто замечен был в куках
		$linkToMusters .= $this->writeBRorLISTS(array(), $infid['CookList'], 'il'.$infid['id']);


	    }

	    
	    $data .= '<form action="/@contentico/Service/korm/" method="post">';

	    $data .= '<table border="1">';
	    $data .= '<tr>';
	    $data .= '<td width="50%">Кормушки</td>';
	    $data .= '<td width="50%">Мультиводы</td>';
	    $data .= '</tr>';
	    $data .= '<tr>';
	    $data .= '<td width="50%">'.$kormList.'</td>';
	    $data .= '<td width="50%">'.$linkToMusters.'</td>';
	    $data .= '</tr>';
	    $data .= '</table>';

	    $data .= '<br>';

	    $data .= '<table border="1">';
	    $data .= '<tr>';
	    $data .= '<td width="50%">Медовики (в том числе брошенные)</td>';
	    $data .= '<td width="50%">Брошенные (и не медовики)</td>';
	    $data .= '</tr>';
	    $data .= '<tr>';
	    $data .= '<td width="50%">'.$honeyList.'</td>';
	    $data .= '<td width="50%">'.$lostList.'</td>';
	    $data .= '</tr>';
	    $data .= '</table>';

	    $data .= '<br>С выбранными<select name="ActionWithMult">';
	    $data .= '<option value="doNothind" onClick="$(\'#castle\').attr(\'disabled\',\'disabled\');$(\'#messege\').attr(\'disabled\',\'disabled\');">Ничего не делать</option>';
	    $data .= '<option value="catch" onClick="$(\'#castle\').removeAttr(\'disabled\');$(\'#messege\').attr(\'disabled\',\'disabled\');">В тюрьму</option>';
	    $data .= '<option value="deport" onClick="$(\'#castle\').attr(\'disabled\',\'disabled\');$(\'#messege\').attr(\'disabled\',\'disabled\');">В депортацию</option>';
	    $data .= '<option value="Messege" onClick="$(\'#castle\').attr(\'disabled\',\'disabled\');$(\'#messege\').removeAttr(\'disabled\');">Выслать предупреждение</option>';
	    $data .= '</select><br><br>';

	    $data .= 'Срок в тюрьме<br></span><input name="srokcastl" id="castle" disabled type="text" >';
	    $data .= '(12h - 12 часов, 1d - 1 день)<br><br>';
	    $data .= 'Текст сообщения <span id="textBeforInput"><br></span><textarea id="messege" rows="5" cols="45" name="messege" disabled></textarea><br>';
	    $data .= '<input type="Submit" value="Применить изменения">';
	    $data .= '</form>';

	}


	$this->path["Кормушки"] = "Service/korm";

	$Perpetrators = array();
	//получаем id всех отмеченных
	if (isset($_POST['ActionWithMult'])){
	    foreach($_POST as $key=>$value)
	    {
		if (substr($key, 0, 4) == 'korm'){
		   $Perpetrators[] = substr($key, 4);
		}
	    }

	    Std::loadModule('playeradmin');
	    Std::loadMetaObjectClass('player');

	    switch ($_POST['ActionWithMult']){
		case 'deport':
		    foreach ($Perpetrators as $playerId){
		    PlayerAdmin::adminPlayerBlock($playerId,true,'',50, true);
		    }
		    break;
		case 'catch':
		    foreach ($Perpetrators as $playerId){
		    PlayerAdmin::adminPlayerJail($playerId, $_POST['srokcastl'], false,'',true);
		    }
		    break;
		case 'Messege':
		    foreach ($Perpetrators as $playerId){
		    Page::sendLog($playerId,'messeg',array('text'=>$_POST['messege']));
		    }
		    break;

	    }

	}


	$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}



	public function writeBRorLISTS($giftList, $cookList, $panelID){
	    $record = '';
	    if (count($giftList) || count($cookList))
	    {
		$record.='<span id="sh'.$panelID.'" onClick="$(\'#'.$panelID.'\').toggle();
			if ($(\'#'.$panelID.'\').css(\'display\')==\'none\'){
			$(\'#sh'.$panelID.'\').text(\' Показать\');
			}else{$(\'#sh'.$panelID.'\').text(\' Скрыть\')}"> Показать</span><br>';
		$record.='<div id="'.$panelID.'" style="background:#eee6a3; display:none; border: 4px double #d2b48c; margin-left: 10px; margin-right: 70%; ">';
		//если есть кто нибудь в куках
		if ($cookList){
		$record .= 'В куках: <br>';
		foreach ($cookList as $cook){
		    $record .= '<input type="checkbox" name="korm'.$cook.'">';
		    $record .= '<a href="/player/'.$cook.'">'.Page::getPlayerNameByID($cook);
		    $record .='</a><br>';
		    }
		}

		//если есть кому то дарил подарки (в случае хоязяев кормушки передается всегда пустой массив и эта штука не работает)
		if ($giftList){
		$record .= 'Дарил подарки: <br>';
		foreach ($giftList as $gift){
		    $record .= '<input type="checkbox" name="korm'.$gift.'">';
		    $record .= '<a href="/player/'.$gift.'">'.Page::getPlayerNameByID($gift);
		    $record .='</a><br>';
		    }
		}
		$record .='</div>';
		return $record;
	    }
	    else
	    {
		return '<br>';
	    }

	}


	//пробегаемся по всем "странным" игрокам
	public function getMultInfo($mults)
	{
	    if (count($mults))
	    {
		foreach($mults as $id)
		{
		    //мультивод
		    $MultName = Page::getPlayerNameByID($id);
		    if ($MultName==''){
			continue;
		    }
		    
		    $giftList = array();
		    $CookList = array();
		    $honey = false;
		    $lost = false;
		    $Multlevel =$this->sqlGetValue("SELECT level FROM player WHERE id={$id}");

		    //если есть платежи
		    $paymented_id = $this->sqlGetValue("SELECT player FROM payment WHERE player={$id} LIMIT 0, 1");
		    $honey = ($paymented_id == $id) ? true : false;


		    //проверяем на брошенность
		    $lastVisit_string = $this->sqlGetValue("SELECT time FROM authlog WHERE player={$id} ORDER BY time desc LIMIT 0, 1");
		    $lastVisit = strtotime($lastVisit_string);
		    $now = time();
		    $infidel = $now - $lastVisit;//время отсутвия
		    $lost= ($infidel >= 14 * 24 * 60 * 60) ? true : false;


		    //проверяем куки (нужно получит списко тех кто заходил с компа подозрительного юзера кроме него)
		    $authlog = $this->sqlGetRecordSet("SELECT * FROM authlog WHERE player={$id}");
		    if ($authlog)
		    {
		    foreach ($authlog as $log)
			{
			    $cookName = mb_strcut($log['info'],8);
			    if ($cookName != $MultName)
			    {
				#$anotherMult = $this->getValue("SELECT id FROM player WHERE nickname = '" . $cookName . "' LIMIT 1");

				$usvermult = $this->sqlGetValue("SELECT id FROM player WHERE nickname = '" . Std::cleanString($MultName) . "' LIMIT 1");
				if ($usvermult)
				{
				    if (!in_array($usvermult, $CookList)){
				    $CookList[] = $usvermult;
				    }
				}
			    }
			}
		    }

		    //проверяем подарки
		    $giftListFromBD=$this->sqlGetValueSet("SELECT player FROM gift WHERE player_from LIKE '{$MultName}'");
		    if ($giftListFromBD)
		    {
			foreach ($giftListFromBD as $gift)
			{
			    $giftList[]=$gift;
			}
		    }

		    //полученные подарки (обработка хоязев мультов)
		    //получить ИМЕНА всех дарительей
		    //$giftList2=$this->sqlGetValueSet("SELECT player_from FROM gift WHERE player={$id} LIMIT 0, 50");
		    //получить

		    $Mult[]=array('id'=>$id,'name'=>$MultName,'level'=>$Multlevel,'honey'=>$honey,'lost'=>$lost,'CookList'=>$CookList,'GiftList'=>$giftList);

		}
		return $Mult;
	    }
	    else
	    {
	    return array();
	    }
	    
	}


	public function serviceIndex() {
		$list = "";
		if ($this->checkAccess("promo")) $list .= "<li><a href=\"/@contentico/Service/promo/\">Отправка рекламной почты</li>";
		if ($this->checkAccess("pet_wins")) $list .= "<li><a href=\"/@contentico/Service/pets/\">Питомцы</li>";
		if ($this->checkAccess("pets_koma")) $list .= "<li><a href=\"/@contentico/Service/petskoma/\">Снятие комы с питомцев</li>";
		if ($this->checkAccess("rating")) $list .= "<li><a href=\"/@contentico/Service/repairrating/\">Восстановлении фракции в рейтинге</li>";
		if ($this->checkAccess("release")) $list .= "<li><a href=\"/@contentico/Service/releaseplayers/\">Освободить игроков</li>";
		if ($this->checkAccess("give_exp")) $list .= "<li><a href=\"/@contentico/Service/giveexp/\">Начисление опыта</li>";
		if ($this->checkAccess("give_item")) $list .= "<li><a href=\"/@contentico/Service/giveitem/\">Вернуть предметы</li>";
		if ($this->checkAccess("help_hacked")) $list .= "<li><a href=\"/@contentico/Service/helphacked/\">Помощь взломанным</li>";
		if ($this->checkAccess("groupfights")) $list .= "<li><a href=\"/@contentico/Service/groupfights/\">Групповые бои</li>";
		if ($this->checkAccess("logs")) $list .= "<li><a href=\"/@contentico/Service/logs/\">Логи</li>";
		if ($this->checkAccess("korm")) $list .= "<li><a href=\"/@contentico/Service/korm/\">Кормушки</li>";
		if ($this->checkAccess("clanico")) $list .= "<li><a href=\"/@contentico/Service/clanico/\">Закачка клановых иконок</li>";

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service"), array("list" => $list));
	}
	public function serviceActionClanIco(){
	//в обход джава скрипту не заполнена причина
	if ( isset($_POST['reason']) && strlen($_POST['reason']) == 0 ){
	   return false;
	}

	$clanID = false;
	if (!empty($_POST['clanID']) && is_numeric($_POST['clanID'])) {
	    $clanID = $this->sqlGetValue("SELECT id FROM clan WHERE id = {$_POST['clanID']}");

	}

	if (!$clanID){
	    $clanID = $this->sqlGetValue("SELECT id FROM clan WHERE name = '{$_POST['clanNAME']}'");
	    if (!$clanID){
	    }
	}


	if (!$clanID){
	return false;
	Std::redirect("/@contentico/Service/clanico/");
	}

	//закачка клановой иконки
	std::loadMetaObjectClass('clan');
	$clan = new clanObject();
	
	if ($_FILES['ico']['error'] == 0 && $_FILES['ico']['name'] != '') {
		$ico = true;
		$clan->ico = $clan->uploadImage('ico');
	}
	if ($_FILES['logo']['error'] == 0 && $_FILES['logo']['name'] != '') {
		$logo = true;
		$clan->logo = $clan->uploadImage('logo');
	}

	$clan->save($clanID, array(clanObject::$ICO, clanObject::$LOGO));



	//запись в лог
	$sql = "INSERT INTO `admin_clanico_log`(`admin`,`dt`,`ip`,`reason`) VALUES(" . Runtime::$uid . ",  NOW(), " . ip2long($_SERVER["REMOTE_ADDR"]) . ", '" . $_POST['reason'] . "')";
	$this->sqlQuery($sql);


	Std::redirect("/@contentico/Service/clanico/");

	}

	public function serviceClanIco(){
	$this->path["Закачка клановых иконок"] = "Service/clanico";



	$data .= "<form  enctype=\"multipart/form-data\" action=\"/@contentico/Service/clanico/\" method=\"post\" onsubmit=\"if (document.getElementById('reason').value=='') { alert('Укажите причину'); return false; } \">";
	$data .= "<input type=\"hidden\" name=\"action\" value=\"clanico\" />";

	
	$data .= "Причина: <br><input type=\"text\" name=\"reason\" id=\"reason\" /><br /><br />";
	$data .= "Клан:<br> id <input size=\"5\" type=\"text\" name=\"clanID\" id=\"clanID\" />";
	$data .= " или имя <input size=\"9\" type=\"text\" name=\"clanNAME\" id=\"clanNAME\" /><br>";
	$data .= "<I>id приоритетнее имени клана</I><br><br>";
	$data .= "Эмблема:<br>";
	$data .= '<input type="file" name="logo" class="wide" onchange="if(this.value.substr(-3,3)!=\'png\'&&this.value.substr(-3,3)!=\'jpg\'&&this.value.substring(-3,3)!=\'jpeg\'&&this.value.substr(-3,3)!=\'gif\'){this.value=\'\';alert(\'Ошибка: выбранный файл не является картинкой.\');}"><br>';
	$data .= "Иконка:<br>";
	$data .= '<input type="file" name="ico" class="wide" onchange="if(this.value.substr(-3,3)!=\'png\'&&this.value.substr(-3,3)!=\'jpg\'&&this.value.substring(-3,3)!=\'jpeg\'&&this.value.substr(-3,3)!=\'gif\'){this.value=\'\';alert(\'Ошибка: выбранный файл не является картинкой.\');}"><br>';

	$data .= '<br />';

	$data .= "<input type=\"submit\" value=\"Отправить\">";
	$data .= "</form>";


	$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceGroupFights() {
		if (!$this->checkAccess("groupfights")) return;
		if (in_array($this->url[1], array("clanwar", "chaotic", "level", "metro", "flag","bank"))) {
			$this->sqlQuery("UPDATE value SET value = '".$this->url[1]."' WHERE name = 'kickgroupfights'");
			Runtime::set("gf_kick_result", "пиннули " . $this->url[1]);
			Std::redirect("/@contentico/Service/groupfights/");
		} else {
			$result = "";
		}

		$data = "";

		if (Runtime::get("gf_kick_result")) {
			$data .= '<p><b>Результат пинка</b>: '.Runtime::get("gf_kick_result").'</p>';
			Runtime::clear("gf_kick_result");
		}

		$kicking = $this->sqlGetValue("SELECT value FROM value WHERE name='kickgroupfights'");

		$fights = $this->sqlGetRecordSet("SELECT id, type, level, diplomacy, state, start_dt FROM fight WHERE state!='finished'");
		if ($fights) {
			$data .= '
				<p>Всего боев: '.sizeof($fights).'</p>
				<p>Пиннуть:'.($kicking == "" ? '
					<a href="/@contentico/Service/groupfights/clanwar/">клановые</a>,
					<a href="/@contentico/Service/groupfights/chaotic/">хаотики</a>,
					<a href="/@contentico/Service/groupfights/level/">левельные</a>,
					<a href="/@contentico/Service/groupfights/metro/">противостояние</a>,
					<a href="/@contentico/Service/groupfights/flag/">флаг</a>,
                                        <a href="/@contentico/Service/groupfights/bank/">банк</a>
					' : ' <i>ожидаем результат пинка</i>').'
				</p>
				<table border="1" class="gft">
				<tr class="head">
					<td>ID боя</td><td>Тип</td><td>Уровень</td><td>ID войны</td><td>Состояние</td><td>Дата старта</td>
					<td>Зависание</td>
				</tr>
			';
			foreach ($fights as $f) {
				if ($f["state"] == "created") {
					$delay = time() - strtotime($f["start_dt"]);
					$delayColor = $delay < 60 ? "black" : ($delay < 300 ? "brown" : "red");
				} else {
					$delay = 0;
				}
				$data .= '<tr>
					<td>'.$f["id"].'</td>
					<td>'.$f["type"].'</td>
					<td>'.$f["level"].'</td>
					<td>'.$f["diplomacy"].'</td>
					<td>'.$f["state"].'</td>
					<td>'.$f["start_dt"].'</td>
					<td>'.($delay > 0 ? '<span style="color:'.$delayColor.'">'.date("i:s", $delay) : '').'</td>
				</tr>';
			}
			$data .= '</table>';
		}
		$data .= '
			<style type="text/css">
				table.gft{border:1px solid #ccc;}
				table.gft td{padding:1px;}
				table.gft tr.head td{font-weight:bold;}
			</style>
		';

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceActionPetsSetWins() {
		if (!$this->checkAccess("pet_wins")) return;

		$strings = $_POST["text"];
		$strings = explode("\n", $_POST["text"]);
		$reason = Std::cleanString(trim($_POST["reason"]));
		if (empty ($reason)) {
			Std::redirect("/@contentico/Service/pets/reason/");
		}
		$count = 0;
		foreach ($strings as $string) {
			$string = trim($string);
			$string = explode(" ", $string);
			$string[0] = intval($string[0]);
			$string[1] = Std::cleanString($string[1]);
			$string[2] = intval($string[2]);
			$itemId = $this->sqlGetValue("SELECT id FROM standard_item where code = '" . $string[1] . "'");
			if ($string[0] && $string[2] && $itemId) {
				CacheManager::delete('pet_full', array('pet_id' => $string[0]));
				$this->sqlQuery("UPDATE pet SET wins = wins + " . $string[2] . ", procent=(case when ( procent+" . $string[2] . "*0.05 )<80 then procent+" . $string[2] . "*0.05 ELSE 80 end) where item = " . $itemId . " AND player=" . $string[0]);
				$c = $this->sqlGetAffectedRows();
				if ($c > 0) {
					$sql = "INSERT INTO `admin_pets_wins_log`(`admin`,`player`,`pet`,`count`,`dt`,`ip`,`reason`) VALUES(" . Runtime::$uid . ", " . $string[0] . ", '" . $string[1] . "'," . $string[2] . ", NOW(), " . ip2long($_SERVER["REMOTE_ADDR"]) . ", '" . $reason . "')";
					$this->sqlQuery($sql);
			}
				$count += $c;
		}
		}
		Std::redirect("/@contentico/Service/pets/" . $count . "/");
	}

	public function serviceActionPetsKoma() {
		if (!$this->checkAccess("pets_koma")) return;

		$strings = $_POST["text"];
		$strings = explode("\n", $_POST["text"]);
		$reason = Std::cleanString(trim($_POST["reason"]));
		if (empty ($reason)) {
			Std::redirect("/@contentico/Service/petskoma/reason/");
		}
		$count = 0;
		foreach ($strings as $string) {
			$string = trim($string);
			$string = explode(" ", $string);
			$string[0] = intval($string[0]);
			$string[1] = Std::cleanString($string[1]);
			$itemId = $this->sqlGetValue("SELECT id FROM standard_item where code = '" . $string[1] . "'");
			if ($string[0] && $itemId) {
				CacheManager::delete('pet_full', array('pet_id' => $string[0]));
				$this->sqlQuery("UPDATE pet SET respawn_at = '" . date("Y-m-d H:i:s") . "' where item = " . $itemId . " AND player=" . $string[0]);
				$c = $this->sqlGetAffectedRows();
				if ($c > 0) {
					$sql = "INSERT INTO `admin_pets_koma_log`(`admin`,`player`,`pet`,`dt`,`ip`,`reason`) VALUES(" . Runtime::$uid . ", " . $string[0] . ", '" . $string[1] . "', NOW(), " . ip2long($_SERVER["REMOTE_ADDR"]) . ", '" . $reason . "')";
					$this->sqlQuery($sql);
				}
				$count += $c;
			}
		}
		Std::redirect("/@contentico/Service/petskoma/" . $count . "/");
	}

	private function generateAutologinSession($player, $type) {
		$session = md5($player . mt_rand());
		$this->sqlQuery("insert into autologin (player, dt, type, session) value(" . $player . ", now(), '" . $type . "', '" . $session . "')");
		return $session;
	}

	public function serviceActionPromo() {
		if (!$this->checkAccess("promo")) return;

		$startLevel = intval($_POST["level_start"]);
		$endLevel = intval($_POST["level_end"]);
		$sendToDeleted = ($_POST["deleted"] == "true") ? true : false;
		//$_POST["text"] = str_replace("\r\n", "", $_POST["text"]);
		//$_POST["text"] = str_replace("\r", "", $_POST["text"]);
		//$_POST["text"] = str_replace("\n", "", $_POST["text"]);
		$text = Std::cleanString($_POST["text"]);
		$mailId = $this->sqlInsert("INSERT INTO mail(text) VALUES('" . $text . "')");

		$subject = Std::cleanString($_POST["subject"]);
		$type = "promo";

		if (strlen($_POST["dt"]) > 0) {
			$dt = trim($_POST["dt"]);
			$dt = explode(".", $dt);
			if (sizeof($dt) == 3) {
				$dt[0] = intval($dt[0]);
				$dt[1] = intval($dt[1]);
				$dt[2] = intval($dt[2]);
				if ($dt[0] > 0 && $dt[1] > 0 && $dt[2] > 2000) {
					$dt = " AND lastactivitytime < '" . date("Y-m-d H:i:s", mktime(0, 0, 0, $dt[1], $dt[0], $dt[2])) . "'";
				} else {
					$dt = "";
				}
			} else {
				$dt = "";
			}
		}
		if ($_POST["test"] == "true") {
			Std::loadModule("Page");
			Std::loadLang();
			$queryHead = "INSERT INTO mail_queue(type,email,subject,text,mail) VALUES";
			$stack = array();
			$stack[] = "('" . $type . "', '" . $_POST["email"] . "', '" . $subject . "', '" . json_encode(array()) . "', " . $mailId . ")";
			$this->sqlQuery($queryHead . implode(",", $stack));

			//Page::initSql();
			//Page::sendNotify(null, $type, array("text" => $text), $_POST["email"], $subject);
			Std::redirect("/@contentico/Service/promo/test/");
		} elseif($_POST["amnesty"] == "true") {
			$query = "SELECT player.id, player.email, player.nickname FROM player INNER JOIN player2 ON player.id = player2.player WHERE email != '' AND NOT (player.state='police' and player.stateparam='admin') AND player2.unbancost = 50" . $dt;
			$emails = $this->sqlGetRecordSet($query);
			$queryHead = "INSERT INTO mail_queue(type,email,subject,text,mail) VALUES";
			$stack = array();
			if (strpos($text, "<%link%>") === false) {
				$notlink = true;
			} else {
				$notlink = false;
			}

			foreach ($emails as $email) {
				if ($notlink) {
					$link = "";
				} else {
					$sessionId = $this->generateAutologinSession($email["id"], "promo");
					$link = "<a href=\"http://www.moswar.ru/autologin/" . $sessionId . "/\">http://www.moswar.ru/autologin/" . $sessionId . "/</a>";
				}
				$nick = Std::cleanString($email["nickname"]);
				//$stack[] = "('" . $type . "', '" . $email["email"] . "', '" . str_replace("<%nickname%>", $nick, $subject) . "', '" . str_replace(array("<%nickname%>", "<%link%>"), array($nick, $link), $text) . "')";
				$stack[] = "('" . $type . "', '" . $email["email"] . "', '" . str_replace("<%nickname%>", $nick, $subject) . "', '" . Std::cleanString(json_encode(array("<%nickname%>" => $nick, "<%link%>" => $link))) . "', " . $mailId . ")";
				if (sizeof($stack) > 50) {
					$this->sqlQuery($queryHead . implode(",", $stack));
					$stack = array();
				}
			}
			if (sizeof($stack) > 0) {
				$this->sqlQuery($queryHead . implode(",", $stack));
				$stack = array();
			}
			$this->sqlQuery("UPDATE player2 SET unbancost = 51 WHERE unbancost = 50 AND player IN (SELECT player.id FROM player WHERE player.state='police' AND player.stateparam='admin')");
			$this->sqlQuery("UPDATE player2 SET unbancost = 0 WHERE unbancost = 50");
			$this->sqlQuery("UPDATE player2 SET unbancost = 50 WHERE unbancost = 51 AND player IN (SELECT player.id FROM player WHERE player.state='police' AND player.stateparam='admin')");

			Std::redirect("/@contentico/Service/promo/sended/");
		}else {
			$query = "SELECT id, email, nickname FROM player WHERE email != ''";
			if ($startLevel)
				$query .= " AND level >= " . $startLevel;
			if ($endLevel)
				$query .= " AND level <= " . $endLevel;

			$query .= $dt;
			$emails = $this->sqlGetRecordSet($query);
			if (!$emails)
				$emails = array();
			if ($sendToDeleted) {
				$deletedEmails = $this->sqlGetRecordSet("SELECT 0 id, email, nickname FROM email_deleted");
				$emails = array_merge($emails, $deletedEmails);
			}
			$queryHead = "INSERT INTO mail_queue(type,email,subject,text,mail) VALUES";
			$stack = array();

			if (strpos($text, "<%link%>") === false) {
				$notlink = true;
			} else {
				$notlink = false;
			}
			$sended = array();
			foreach ($emails as $email) {
				if ($sended[$email["email"]]) continue;
				$sended[$email["email"]] = true;

				if ($notlink) {
					$link = "";
				} else {
					if (isset($email["id"]) && !empty($email["id"])) {
						$sessionId = $this->generateAutologinSession($email["id"], "promo");
					} else {
						$sessionId = null;
					}
					if ($sessionId != null) {
						$link = "<a href=\"http://www.moswar.ru/autologin/" . $sessionId . "/\">http://www.moswar.ru/autologin/" . $sessionId . "/</a>";
					} else {
						$link = "<a href=\"http://www.moswar.ru/\">http://www.moswar.ru/</a>";
					}
				}
				$nick = Std::cleanString($email["nickname"]);
				//$stack[] = "('" . $type . "', '" . $email["email"] . "', '" . str_replace("<%nickname%>", $nick, $subject) . "', '" . str_replace(array("<%nickname%>", "<%link%>"), array($nick, $link), $text) . "')";
				$stack[] = "('" . $type . "', '" . $email["email"] . "', '" . str_replace("<%nickname%>", $nick, $subject) . "', '" . Std::cleanString(json_encode(array("<%nickname%>" => $nick, "<%link%>" => $link))) . "', " . $mailId . ")";

				if (sizeof($stack) > 100) {
					$this->sqlQuery($queryHead . implode(",", $stack));
					usleep(100000);
					$stack = array();
				}
			}
			if (sizeof($stack) > 0) {
				$this->sqlQuery($queryHead . implode(",", $stack));
				$stack = array();
			}
			Std::redirect("/@contentico/Service/promo/sended/");
		}
	}

	public function servicePetsKoma() {
		if (!$this->checkAccess("pets_koma")) return;
		$this->path["Снятие комы с питомцев"] = "Service/petskoma";
		$data = '<h1>Снятие комы с питомцев</h1>';
		if (strlen($this->url[1]) > 0) {
			if ($this->url[1] == "reason") {
				$data .= "<strong>Укажите причину</strong><br /><br />";
			} else {
				$count = intval($this->url[1]);
				$data .= "<strong>Обновлено животных: " . $count . "</strong><br /><br />";
			}
		}
		$data .= "Формат входных данных:<br/><strong>id_игрока</strong> <strong>код_питомца</strong><br /><br />Каждый новый игрок на новой строке<br /><br />";
		$data .= "Коды питомцев:<br />
			<strong>parrot</strong> - попугай<br />
			<strong>pussy</strong> - кошка<br />
			<strong>chihuahua</strong> - чихуахуа<br />
			<strong>pet_doberman</strong> - доберман<br />
			<strong>pet_ovcharka</strong> - овчарка<br /><br />";

		$data .= "<form action=\"/@contentico/Service/petskoma/\" method=\"post\" onsubmit=\"if (document.getElementById('reason').value=='') { alert('Укажите причину'); return false; } \">";
		$data .= "<input type=\"hidden\" name=\"action\" value=\"setwins\" />";
		$data .= "<strong>Причина: </strong><input type=\"text\" name=\"reason\" id=\"reason\" /><br /><br />";
		$data .= "<textarea name=\"text\" cols=\"80\" rows=\"8\"></textarea><br />";
		$data .= "<button>Отправить</button>";
		$data .= "</form>";

		$changes = $this->sqlGetRecordSet("SELECT s.email admin, a.player, a.pet, a.ip, a.dt, a.reason FROM admin_pets_koma_log a INNER JOIN sysuser s ON s.id=a.admin WHERE a.dt > (NOW() - INTERVAL 2 DAY) ORDER BY a.id DESC");
		if ($changes) {
			$table = "<h2>Последние изменения</h2><style>table.stat { border: 2px solid #cccccc; border-collapse: collapse; width: auto; } table.stat td, table.stat th { padding: 2px 4px; border: 2px solid #cccccc; border-collapse: collapse; }</style>
				<table class=\"stat\"><tr><th>Модератор</th><th>Игрок</th><th>Питомец</th><th>IP</th><th>Дата</th><th>Причина</th></tr>";
			foreach ($changes as $result) {
				$table .= "<tr>";
				$table .= "<td>" . $result["admin"] . "</td>";
				$table .= "<td>" . $result["player"] . "</td>";
				$table .= "<td>" . $result["pet"] . "</td>";
				$table .= "<td>" . long2ip($result["ip"]) . "</td>";
				$table .= "<td>" . date("d.m.Y в H:i:s", strtotime($result["dt"])) . "</td>";
				$table .= "<td>" . $result["reason"] . "</td>";
				$table .= "</tr>";
			}
			$table .= "</table><br />";
			$data .= $table;
		}

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function servicePets() {
		if (!$this->checkAccess("pet_wins")) return;

		$this->path["Питомцы"] = "Service/pets";
		$data = '<h1>Добавление побед питомцам</h1>';
		if (strlen($this->url[1]) > 0) {
			if ($this->url[1] == "reason") {
				$data .= "<strong>Укажите причину</strong><br /><br />";
			} else {
			$count = intval($this->url[1]);
			$data .= "<strong>Обновлено животных: " . $count . "</strong><br /><br />";
		}
		}
		$data .= "Формат входных данных:<br/><strong>id_игрока</strong> <strong>код_питомца</strong> <strong>количество_побед</strong><br /><br />Каждый новый игрок на новой строке<br /><br />";
		$data .= "Коды питомцев:<br />
			<strong>parrot</strong> - попугай<br />
			<strong>pussy</strong> - кошка<br />
			<strong>chihuahua</strong> - чихуахуа<br />
			<strong>pet_doberman</strong> - доберман<br />
			<strong>pet_ovcharka</strong> - овчарка<br /><br />";

		$data .= "<form action=\"/@contentico/Service/pets/\" method=\"post\" onsubmit=\"if (document.getElementById('reason').value=='') { alert('Укажите причину'); return false; } \">";
		$data .= "<input type=\"hidden\" name=\"action\" value=\"setwins\" />";
		$data .= "<strong>Причина: </strong><input type=\"text\" name=\"reason\" id=\"reason\" /><br /><br />";
		$data .= "<textarea name=\"text\" cols=\"80\" rows=\"8\"></textarea><br />";
		$data .= "<button>Отправить</button>";
		$data .= "</form>";

		$changes = $this->sqlGetRecordSet("SELECT s.email admin, a.player, a.pet, a.count, a.ip, a.dt, a.reason FROM admin_pets_wins_log a INNER JOIN sysuser s ON s.id=a.admin WHERE a.dt > (NOW() - INTERVAL 2 DAY) ORDER BY a.id DESC");
		if ($changes) {
			$table = "<h2>Последние изменения</h2><style>table.stat { border: 2px solid #cccccc; border-collapse: collapse; width: auto; } table.stat td, table.stat th { padding: 2px 4px; border: 2px solid #cccccc; border-collapse: collapse; }</style>
				<table class=\"stat\"><tr><th>Модератор</th><th>Игрок</th><th>Питомец</th><th>Количество побед</th><th>IP</th><th>Дата</th><th>Причина</th></tr>";
			foreach ($changes as $result) {
				$table .= "<tr>";
				$table .= "<td>" . $result["admin"] . "</td>";
				$table .= "<td>" . $result["player"] . "</td>";
				$table .= "<td>" . $result["pet"] . "</td>";
				$table .= "<td>" . $result["count"] . "</td>";
				$table .= "<td>" . long2ip($result["ip"]) . "</td>";
				$table .= "<td>" . date("d.m.Y в H:i:s", strtotime($result["dt"])) . "</td>";
				$table .= "<td>" . $result["reason"] . "</td>";
				$table .= "</tr>";
			}
			$table .= "</table><br />";
			$data .= $table;
		}

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function serviceLogs() {
		if (!$this->checkAccess("logs")) return;
		$this->path["Логи"] = "Service/logs";
		$player = intval($_GET["player"]);
		$df = $_GET["df"];
		//$dt = $_GET["dt"];

		$player = intval($_GET["player"]);
		if (empty ($player)) {
			$player = "";
		}
		/*
		if (!empty($dt)) {
			$time = strtotime($dt);
			if ($time) {
				$dt = date("d.m.Y", $time);
			} else {
				$dt = "";
			}
		} else {
			$dt = "";
		}
		*/
		if (!empty($df)) {
			$time = strtotime($df);
			if ($time) {
				$df = date("d.m.Y", $time);
			} else {
				$df = "";
			}
		} else {
			$df = "";
		}

		$type = "logs";
		$title = "Логи";
		$mode = "logs";
		switch ($this->url[1]) {
			case "l" :
				$type = "logs";
				$title = "Логи";
				break;
			case "d" :
				$type = "duels";
				$title = "Дуэли";
				break;
		}

		$data = "<h1>" . $title . "</h1>";
		if ($player) {
			$nickname = $this->sqlGetValue("SELECT nickname FROM player WHERE id = " . $player);
			if ($nickname) {
				$data = "<h1>" . $title . " игрока " . $nickname . "";
				if (!empty($df)) {
					$data .= " от "  . $df;
				}
				/*
				if (!empty($dt)) {
					$data .= " до "  . $dt;
				}
				*/
				$data .= "</h1>";
			}
		}
		$data .= "<style>table.buttons { display: none; } h3 { display: none; }</style>";
		//$data .= "<strong><a href=\"/@contentico/Service/logs/l/?player=" . $player . "&df=" . $df . "&dt=" . $dt . "\">Логи</a>&#0160;&#0160;&#0160;&#0160;<a href=\"/@contentico/Service/logs/d/?player=" . $player . "&df=" . $df . "&dt=" . $dt . "\">Дуэли</a></strong><br /><br />";
		$data .= "<strong><a href=\"/@contentico/Service/logs/l/?player=" . $player . "&df=" . $df . "\">Логи</a>&#0160;&#0160;&#0160;&#0160;<a href=\"/@contentico/Service/logs/d/?player=" . $player . "&df=" . $df . "\">Дуэли</a></strong><br /><br />";
		$data .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"/@/css/main.css\" />";
		$data .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"/@/css/phone.css\" />";
		$data .= "<style>body { background: none; } .phone .messages .block-rounded { background-color: #ffffff; } div.block-rounded { background-color: #ffffff; } div.column-right, div.column-right-topbg, div.column-right-bottombg, div.column-right .heading, div.column-right .heading h2 { background: none; }</style>";
		$data .= "<form method=\"get\">";
		$data .= "<table border=\"0\" style=\"width: auto;\">";
		$data .= "<tr>";
		$data .= "<td><label>ID игрока:</label>&#0160;</td><td><input type=\"text\" name=\"player\" value=\"" . $player . "\" /></td>";
		$data .= "</tr>";
		$data .= "<tr>";
		//$data .= "<td><label>Начальная дата:</label>&#0160;</td><td><input type=\"text\" name=\"df\" value=\"" . $df . "\" /> <span style=\"color: #cccccc;\">(формат: дд.мм.гггг)</span></td>";
		$data .= "<td><label>Дата:</label>&#0160;</td><td><input type=\"text\" name=\"df\" value=\"" . $df . "\" /> <span style=\"color: #cccccc;\">(формат: дд.мм.гггг)</span></td>";
		$data .= "</tr>";
		//$data .= "<tr>";
		//$data .= "<td><label>Конечная дата:</label>&#0160;</td><td><input type=\"text\" name=\"dt\" value=\"" . $dt . "\" /> <span style=\"color: #cccccc;\">(формат: дд.мм.гггг)</span></td>";
		//$data .= "</tr>";
		$data .= "</table>";
		$data .= "<input type=\"submit\" value=\"Показать\">";
		$data .= "</form><br/><span style=\"color: #cccccc;\">Отображаются максимум 500 записей. Выбирайте подходящие диапазоны дат.</span><br />";
		$perPage = 500;

		//" . ((!empty($dt)) ? " AND dt <= '" . date("Y-m-d 23:59:59", strtotime($dt)) . "'" : "") . "

		$time = strtotime($df);
		if ($time >= mktime(0, 0, 0, 2, 21, 2011)) {
			$table = date("Ymd", $time);
			$df = "";
		} else {
			$table = "";
		}
		if (!empty($nickname)) {
			$query = "SELECT * FROM log" . $table . " WHERE player = " . $player . "
			AND type " . (($type == "logs") ? "NOT" : "") . " IN ('fight_attacked','fight_defended','fighthntclb')
			" . ((!empty($df)) ? " AND dt >= '" . date("Y-m-d 00:00:00", strtotime($df)) . "'" : "") . "
			" . ((!empty($df)) ? " AND dt <= '" . date("Y-m-d 23:59:59", strtotime($df)) . "'" : "") . "
			ORDER BY id DESC LIMIT " . $perPage;
			$logs = $this->sqlGetRecordSet($query);

			Std::loadLib("HtmlTools");

			if (is_array($logs)) {
				foreach ($logs as $key => &$log) {
					$log["params"] = json_decode($log["params"], true);
					$log["datetime"] = HtmlTools::FormatDateTime($log["dt"], true, false, false, true);
					if ($log["type"] == "nprstnew" && $log["params"]["m"] > 0) {
						$log["word_games"] = HtmlTools::russianNumeral($log["params"]["g2"] + $log["params"]["g9"], "игру", "игры", "игр");
					}
					if ($log["type"] == "fighthntclb") {
						$log["params"]["sk"] = Page::generateKeyForDuel($log["params"]["dl"]);
					} else {
						$log["params"]["secretkey"] = Page::generateKeyForDuel($log["params"]["fight_id"]);
					}
					if ($log["params"]["werewolf"] == 1 && $log["type"] == "fight_defended") {
						$log["params"]["player"]["id"] = 0;
						$log["params"]["player"]["fr"] = "w";
					}
				}
			}

			Std::loadLib("Cache");
			include("@lib/pageTemplate.php"); // loadLib убитвает регистр, жевать её уши!
			include("@lib/pageXSL.php"); // loadLib убитвает регистр, жевать её уши!
			Page::initCache();
			$page = new PageXSL(Page::$cache);
			$page->setStylesheet("phone/phone.xsl");
			$xml = oxml_encode(array("logs" => $logs, "mode" => $type));
			$dom = new DOMDocument();
			$dom->loadXML($xml);
			$page->setData($dom);
			$content = $page->create();

			$data .= $content;
		} else {
			if ($player) $data .= "<center><strong>Игрок не найден</strong></center>";
		}
		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	public function servicePromo() {
		if (!$this->checkAccess("promo")) return;

		$this->path["Отправка рекламной почты"] = "Service/mail";

		$data = '<h1>Отправка рекламной почты</h1>';
		if ($this->url[1] == "sended") {
			$data .= "<strong>Сообщение добавлено в очередь на отправку</strong><br /><br />";
		}
		if ($this->url[1] == "test") {
			$data .= "<strong>Тестовое сообщение отправлено</strong><br /><br />";
		}
		$data .= "<form action=\"/@contentico/Service/promo/\" method=\"post\">";
		$data .= "<input type=\"hidden\" name=\"action\" value=\"promo\" />";
		$data .= "<table border=\"0\">";
		$data .= "<tr><td width=\"15%;\">Начальный уровень:</td><td><input type=\"text\" name=\"level_start\" value=\"1\" /></td></tr>";
		$data .= "<tr><td>Конечный уровень:</td><td><input type=\"text\" name=\"level_end\" value=\"20\" /></td></tr>";
		$data .= "<tr><td>Отправлять удалённым:</td><td><input type=\"checkbox\" name=\"deleted\" value=\"true\" /></td></tr>";
		$data .= "<tr><td>Дата последнего входа:</td><td><input type=\"text\" name=\"dt\" size=\"10\" /> Формат <strong>ДД.ММ.ГГГГ</strong> (пустой/неправильный не учитывается)</td></tr>";
		$data .= "<tr><td>Тема:</td><td><input type=\"text\" name=\"subject\" value=\"\" /></td></tr></table>";
		$data .= "<textarea name=\"text\" cols=\"80\" rows=\"8\"></textarea><br />";
		$data .= "<strong><input type=\"checkbox\" name=\"test\" value=\"true\" checked=\"checked\" /> отправить тестовое сообщение на</strong> <input type=\"text\" name=\"email\" value=\"\" /><br />";
		$data .= "<strong><input type=\"checkbox\" name=\"amnesty\" value=\"true\" /> произвести амнистию</strong><br />";
		$data .= "<button>Отправить</button>";
		$data .= "</form>";
		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("service_view"), array("data" => $data));
	}

	private function processUrl() {
		for ($i = 1; $i < sizeof($this->url); $i++) {
			$urlPart = explode("=", $this->url[$i]);
			$this->{$urlPart[0]} = $urlPart[1];
		}
	}

}

?>
