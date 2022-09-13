<?php
class Stat extends ContenticoModule implements IModule {
	public function __construct() {
		parent::__construct();
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		$this->page["left-menu-index"] = "class=\"cur\"";
		$this->page["page-name"] = "Статистика";
		$this->page["tab-content"] = "Статистика";
		$this->path["Статистика"] = "Stat";

		$this->processUrl();
		switch ($this->url[0]) {
			case "billing" :
				$this->statBilling();
				break;
			case "online" :
				$this->statOnline();
				break;
			case "active" :
				$this->statActive();
				break;
			case "stat" :
				$this->statStat();
				break;
			case "mail" :
				$this->statMail();
				break;
			default:
				$this->statIndex();
				break;
		}

		parent::onAfterProcessRequest();
	}

	public function statIndex() {
		$list = "";
		$list .= "<li><a href=\"/@contentico/Stat/billing/\">Сводка покупок</li>";
		$list .= "<li><a href=\"/@contentico/Stat/online/\">График онлайна</li>";
		$list .= "<li><a href=\"/@contentico/Stat/active/\">График активности</li>";
		$list .= "<li><a href=\"/@contentico/Stat/stat/\">Общая сводка</li>";
		$list .= "<li><a href=\"/@contentico/Stat/mail/\">Почтовая статистика</li>";

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("stat"), array("list" => $list));
	}

	public static function googleChartSimpleEncoding($values, $max) {
		$simpleEncoding = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$chartData = "s:";
		foreach ($values as $currentValue) {
			if ($currentValue != null && $currentValue >= 0) {
				$chartData .= substr($simpleEncoding, round(61 * $currentValue / $max), 1);
			} else {
				$chartData .= "_";
			}
		}
		return $chartData;
	}

	public function statOnline() {
		$this->path["График онлайна"] = "Stat/online";

		$stat = $this->sqlGetRecordSet("SELECT * FROM online WHERE dt > '" . date("Y-m-d H:i:s", time() - 3 * 86400) . "' ORDER BY dt");
		$values = array();
		$dates = array();
		$max = 0;
		$i = 0;
		foreach ($stat as $rec) {
			$values[] = $rec["online"];

			if ($i % 8 == 0) {
				$dates[] = date("H:i", strtotime($rec["dt"]));
			} else {
				$dates[] = "";
			}
			$i++;
			if($rec["online"] > $max) $max = $rec["online"];
		}
		$chartData = self::googleChartSimpleEncoding($values, $max);
		$chartLabels = implode($dates, "|");


		$data = '<h1>Онлайн за 3 дня</h1><img src="http://chart.apis.google.com/chart?cht=lc&chs=1000x240&chd=' . $chartData . '&chxt=x,y&chxl=0:|' . $chartLabels . '&chxr=1,0,' . $max . '&chxs=0,444444,8,0,tl" /><br /><br />';

		$stat = $this->sqlGetRecordSet("SELECT * FROM online WHERE dt > '" . date("Y-m-d H:i:s", time() - 28 * 86400) . "' ORDER BY dt");
		$values = array();
		$dates = array();
		$max = 0;
		$curDate = null;
		$curDt = null;
		$curVal = 0;
		$curCount = 0;
		foreach ($stat as $rec) {
			$recDate = substr($rec["dt"], 0, 10);
			if ($curDate == null || $curDate == $recDate) {
				$curVal += $rec["online"];
				$curCount++;
			} else {
				$value = round($curVal / $curCount);
				$values[] = $value;
				if($value > $max) $max = $value;
				$dates[] = date("d.m", strtotime($curDt));
				$curVal = $rec["online"];
				$curCount = 1;
			}
			$curDt = $rec["dt"];
			$curDate = $recDate;
		}
		$value = round($curVal / $curCount);
		$values[] = $value;
		if($value > $max) $max = $value;
		$dates[] = date("d.m", strtotime($curDt));

		$chartData = self::googleChartSimpleEncoding($values, $max);
		$chartLabels = implode($dates, "|");


		$data .= '<h1>Онлайн за 4 недели</h1><img src="http://chart.apis.google.com/chart?cht=lc&chs=1000x240&chd=' . $chartData . '&chxt=x,y&chxl=0:|' . $chartLabels . '&chxr=1,0,' . $max . '&chxs=0,444444,10,0,tl" />';

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("stat_view"), array("data" => $data));

	}

	public function statMail() {
		$this->path["Почтовая статистика"] = "Stat/mail";

		$stat = $this->sqlGetRecordSet("SELECT count(1) c, type, sum(success) s FROM mail_stat GROUP BY type");

		$data = '<h1>Почтовая статистика</h1>';
		$data .= "<br /><style>table.stat { border: 2px solid #cccccc; border-collapse: collapse; width: auto; } table.stat td, table.stat th { padding: 2px 4px; border: 2px solid #cccccc; border-collapse: collapse; }</style>";
		$data .= "<table class=\"stat\">";
		$data .= "<tr><th>Тип</th><th>Отправлено</th><th>Удачно отправлено</th></tr>";

		if ($stat) {
			foreach ($stat as $rec) {
				$data .= "<tr><td>" . $rec["type"] . "</td><td>" . $rec["c"] . "</td><td>" . $rec["s"] . "</td></tr>";
			}
		}

		$data .= "</table>";

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("stat_view"), array("data" => $data));

	}

	public function statActive() {
		$this->path["График активности"] = "Stat/active";

		$stat = $this->sqlGetRecordSet("SELECT * FROM active WHERE dt > '" . date("Y-m-d H:i:s", time() - 28 * 86400) . "' ORDER BY dt");
		$values = array();
		$dates = array();
		$max = 0;
		foreach ($stat as $rec) {
			$values[] = $rec["active"];

			$dates[] = date("d.m", strtotime($rec["dt"]));

			if($rec["active"] > $max) $max = $rec["active"];
		}
		$chartData = self::googleChartSimpleEncoding($values, $max);
		$chartLabels = implode($dates, "|");


		$data = '<h1>Активность за 4 недели</h1><img src="http://chart.apis.google.com/chart?cht=lc&chs=1000x240&chd=' . $chartData . '&chxt=x,y&chxl=0:|' . $chartLabels . '&chxr=1,0,' . $max . '&chxs=0,444444,10,0,tl" /><br /><br />';

		$stat = $this->sqlGetRecordSet("SELECT * FROM active WHERE dt > '" . date("Y-m-d H:i:s", time() - 90 * 86400) . "' ORDER BY dt");
		$values = array();
		$dates = array();
		$max = 0;
		$i = 3;
		foreach ($stat as $rec) {
			$values[] = $rec["active"];

			if ($i % 3 == 0) {
				$dates[] = date("d.m", strtotime($rec["dt"]));
			} else {
				$dates[] = "";
			}
			$i++;
			if($rec["active"] > $max) $max = $rec["active"];
		}
		$chartData = self::googleChartSimpleEncoding($values, $max);
		$chartLabels = implode($dates, "|");

		$data .= '<h1>Активность за 90 дней</h1><img src="http://chart.apis.google.com/chart?cht=lc&chs=1000x240&chd=' . $chartData . '&chxt=x,y&chxl=0:|' . $chartLabels . '&chxr=1,0,' . $max . '&chxs=0,444444,10,0,tl" /><br /><br />';

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("stat_view"), array("data" => $data));
	}

	private function genColor($cur, $prev, $positive = true) {
		if (empty($cur)) $cur = 0;
		if (empty($prev)) $prev = 0;
		$max = max(array($cur, $prev));
		$diff = abs($cur - $prev);
		if ($max == 0) return "#ffffff";
		$percent = round(($diff * 100) / $max);
		$abs = round((255 * $percent) / 100);
		$shift = 255 - $abs;

		if ($shift == 255) return "#ffffff";

		$r = 255;
		$g = 255;
		$b = 255;

		if ($positive) {
			if ($cur > $prev) {
				$r = $shift;
				$b = $shift;
			}
			if ($cur < $prev) {
				$g = $shift;
				$b = $shift;
			}
		} else {
			if ($cur < $prev) {
				$r = $shift;
				$b = $shift;
			}
			if ($cur > $prev) {
				$g = $shift;
				$b = $shift;
			}
		}
		return "#" . str_pad(dechex($r), 2, "0", STR_PAD_LEFT) . str_pad(dechex($g), 2, "0", STR_PAD_LEFT) . str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
	}

	public function statStat() {
		$this->path["Общая сводка"] = "Stat/stat";

		$daysGonePlayers = $this->sqlGetValue("SELECT sum(TIMESTAMPDIFF(day,registeredtime,lastactivitytime)) FROM player WHERE lastactivitytime > registeredtime + INTERVAL 7 DAY AND level >= 2 AND lastactivitytime < NOW() - INTERVAL 7 DAY");
		$levelGonePlayers = $this->sqlGetValue("SELECT sum(level) FROM player WHERE lastactivitytime > registeredtime + INTERVAL 7 DAY AND level >= 2 AND lastactivitytime < NOW() - INTERVAL 7 DAY");
		$levelActivePlayers = $this->sqlGetValue("SELECT sum(level) FROM player WHERE lastactivitytime > registeredtime + INTERVAL 7 DAY AND level >= 2 AND lastactivitytime >= NOW() - INTERVAL 7 DAY");
		$countGonePlayers = $this->sqlGetValue("SELECT count(*) FROM player WHERE lastactivitytime > registeredtime + INTERVAL 7 DAY AND level >= 2 AND lastactivitytime < NOW() - INTERVAL 7 DAY");
		$countActivePlayers = $this->sqlGetValue("SELECT count(*) FROM player WHERE lastactivitytime > registeredtime + INTERVAL 7 DAY AND level >= 2 AND lastactivitytime >= NOW() - INTERVAL 7 DAY");

		$avgDaysGonePlayers = round($daysGonePlayers / $countGonePlayers);
		$avgLevelGonePlayers = round($levelGonePlayers / $countGonePlayers);
		$avgLevelActivePlayers = round($levelActivePlayers / $countActivePlayers);

		$dates = $this->sqlGetValueSet("SELECT dt FROM stat GROUP BY dt ORDER BY dt DESC");
		$curI = intval($_GET["i"]);
		if ($curI >= sizeof($dates)) $curI = 0;
		$curDate = $dates[$curI];
		$time = strtotime($curDate);
		$prevDate = date("Y-m-d", mktime(0, 0, 0, date("n", $time) - 1, 1, date("Y", $time)));
		$data .= "<h1>Усреднённые показатели</h1>";
		$data .= "Среднее время жизни игрока: <strong>" . $avgDaysGonePlayers . "</strong> (д)<br />";
		$data .= "Средний уровень ушедших игроков: <strong>" . $avgLevelGonePlayers . "</strong><br />";
		$data .= "Средний уровень активных игроков: <strong>" . $avgLevelActivePlayers . "</strong><br />";
		$data .= "<br />";
		$data .= "<h1>Информация по месяцам</h1><form action=\"/@contentico/Stat/stat/\" method=\"get\">";

		$data .= "Дата: <select name=\"i\">";
		$i = 0;
		foreach ($dates as $date) {
			$data .= "<option value=\"" . $i . "\" " . (($date == $curDate) ? " selected=\"selected\" " : "") . ">" . date("d.m.Y", strtotime($date)) . "</option>";
			$i++;
		}
		$data .= "</select> <input type=\"submit\" value=\"показать\" /></form>";

		$records = array();
		$prevRecords = array();
		$records1 = $this->sqlGetRecordSet("SELECT * FROM stat WHERE dt = '" . $curDate . "' ORDER BY level");
		$prevRecords1 = $this->sqlGetRecordSet("SELECT * FROM stat WHERE dt = '" . $prevDate . "' ORDER BY level");
		if ($records1) {
			foreach ($records1 as $rec) {
				$records["l" . $rec["level"]] = $rec;
			}
		}
		if ($prevRecords1) {
			foreach ($prevRecords1 as $rec) {
				$prevRecords["l" . $rec["level"]] = $rec;
			}
		}

		$data .= "<br /><style>table.stat { border: 2px solid #cccccc; border-collapse: collapse; width: auto; } table.stat td, table.stat th { padding: 2px 4px; border: 2px solid #cccccc; border-collapse: collapse; }</style>";
		$data .= "<table class=\"stat\">";
		$data .= "<tr><th>Уровень</th><th>Активных</th><th>Пришедших</th><th>Ушедших</th><th>Платящих</th><th>Выручка</th><th>ARPU</th><th>ARPPU</th></tr>";

		$sum = array();
		$sum["active"] = 0;
		$sum["come"] = 0;
		$sum["gone"] = 0;
		$sum["paid"] = 0;
		$sum["revenue"] = 0;
		$sum["arpu"] = 0;
		$sum["arppu"] = 0;

		$prevSum = $sum;

		$size = sizeof($records);

		foreach ($records as $i => $rec) {
			$prevRec = $prevRecords[$i];

			$sum["active"] += $rec["active"];
			$sum["come"] += $rec["come"];
			$sum["gone"] += $rec["gone"];
			$sum["paid"] += $rec["paid"];
			$sum["revenue"] += $rec["revenue"];

			$prevSum["active"] += $prevRec["active"];
			$prevSum["come"] += $prevRec["come"];
			$prevSum["gone"] += $prevRec["gone"];
			$prevSum["paid"] += $prevRec["paid"];
			$prevSum["revenue"] += $prevRec["revenue"];

			$data .= "<tr>
						<td>" . $rec["level"] . "</td>
						<td style=\"background-color: " . $this->genColor($rec["active"], $prevRec["active"], true) . ";\">" . $rec["active"] . "</td>
						<td style=\"background-color: " . $this->genColor($rec["come"], $prevRec["come"], true) . ";\">" . $rec["come"] . "</td>
						<td style=\"background-color: " . $this->genColor($rec["gone"], $prevRec["gone"], false) . ";\">" . $rec["gone"] . "</td>
						<td style=\"background-color: " . $this->genColor($rec["paid"], $prevRec["paid"], true) . ";\">" . $rec["paid"] . "</td>
						<td style=\"background-color: " . $this->genColor($rec["revenue"], $prevRec["revenue"], true) . ";\">" . $rec["revenue"] . "</td>
						<td style=\"background-color: " . $this->genColor($rec["arpu"], $prevRec["arpu"], true) . ";\">" . $rec["arpu"] . "</td>
						<td style=\"background-color: " . $this->genColor($rec["arppu"], $prevRec["arppu"], true) . ";\">" . $rec["arppu"] . "</td>
					</tr>";
		}
		if ($prevSum["active"] > 0) {
			$prevSum["arpu"] = round($prevSum["revenue"] / $prevSum["active"]);
		} else {
			$prevSum["arpu"] = 0;
		}
		if ($prevSum["paid"] > 0) {
			$prevSum["arppu"] = round($prevSum["revenue"] / $prevSum["paid"]);
		} else {
			$prevSum["arppu"] = 0;
		}
		if ($sum["active"] > 0) {
			$sum["arpu"] = round($sum["revenue"] / $sum["active"]);
		} else {
			$sum["arpu"] = 0;
		}
		if ($sum["paid"] > 0) {
			$sum["arppu"] = round($sum["revenue"] / $sum["paid"]);
		} else {
			$sum["arppu"] = 0;
		}
		

		$data .= "<tr>
						<th>Всего</th>
						<td style=\"background-color: " . $this->genColor($sum["active"], $prevSum["active"], true) . ";\">" . $sum["active"] . "</td>
						<td style=\"background-color: " . $this->genColor($sum["come"], $prevSum["come"], true) . ";\">" . $sum["come"] . "</td>
						<td style=\"background-color: " . $this->genColor($sum["gone"], $prevSum["gone"], false) . ";\">" . $sum["gone"] . "</td>
						<td style=\"background-color: " . $this->genColor($sum["paid"], $prevSum["paid"], true) . ";\">" . $sum["paid"] . "</td>
						<td style=\"background-color: " . $this->genColor($sum["revenue"], $prevSum["revenue"], true) . ";\">" . $sum["revenue"] . "</td>
						<td style=\"background-color: " . $this->genColor($sum["arpu"], $prevSum["arpu"], true) . ";\">" . $sum["arpu"] . "</td>
						<td style=\"background-color: " . $this->genColor($sum["arppu"], $prevSum["arppu"], true) . ";\">" . $sum["arppu"] . "</td>
					</tr>";
		$data .= "</table>";

		$stat = $this->sqlGetRecordSet("SELECT count(*) c, date(registeredtime) dt FROM player WHERE registeredtime > '" . date("Y-m-d H:i:s", time() - 30 * 86400) . "' AND nickname != '' GROUP BY dt ORDER BY dt");
		$referers = $this->sqlGetRecordSet("SELECT count(*) c, referer r, date(registeredtime) dt FROM player WHERE referer != '' AND registeredtime > '" . date("Y-m-d H:i:s", time() - 30 * 86400) . "' AND nickname != '' GROUP BY referer, dt");
		$masters = array();
		$referals = array();
		$mastersTmp = array();
		$referalsTmp = array();
		$links = array();
		if (!$referers) $referers = array();
		foreach ($referers as $ref) {
			if (is_numeric($ref["r"])) {
				$mastersTmp[$ref["dt"]] += intval($ref["c"]);
			} else {
				$referalsTmp[$ref["dt"]] += intval($ref["c"]);
				$links[$ref["r"]] += intval($ref["c"]);
			}
		}
		$values = array();
		$dates = array();
		$max = 0;
		foreach ($stat as $rec) {
			$values[] = $rec["c"];
			$refC = $referalsTmp[$rec["dt"]];
			$masterC = $mastersTmp[$rec["dt"]];
			if (empty($refC)) $refC = 0;
			if (empty($masterC)) $masterC = 0;
			$referals[] = $refC;
			$masters[] = $masterC;

			$dates[] = date("d.m", strtotime($rec["dt"]));

			if($rec["c"] > $max) $max = $rec["c"];
		}
		$chartData = self::googleChartSimpleEncoding($values, $max) . "," . substr(self::googleChartSimpleEncoding($referals, $max), 2) . "," . substr(self::googleChartSimpleEncoding($masters, $max), 2);
		$chartLabels = implode($dates, "|");


		$data .= '<br /><h1>Регистрации за последние 30 дней</h1><img src="http://chart.apis.google.com/chart?cht=lc&chs=1000x240&chd=' . $chartData . '&chxt=x,y&chxl=0:|' . $chartLabels . '&chxr=1,0,' . $max . '&chxs=0,444444,10,0,tl&chco=4D89F9,4DF989,F94D89&chdl=Всего игроков|Зарегистрированы по рекламным ссылкам|Зарегистрированы по ссылкам пользователей&chdlp=bv" /><br /><br />';

		if (sizeof($links)) {
			$max = max($links);
			arsort($links);
			$links = array_slice($links, 0, 10);
			$linksV = array();
			$linksN = array();
			foreach($links as $k => $v) {
				$linksV[] = $v;
				$linksN[] = $k;
			}
			$chartData = self::googleChartSimpleEncoding($linksV, $max);
			$chartLabels = implode($linksN, "|");
			$data .= '<br /><h1>Top 10 рекламных регистраций за 30 дней</h1><img src="http://chart.apis.google.com/chart?cht=bhs&chs=800x300&chd=' . $chartData . '&chxt=x,y&chxl=0:|1:|' . $chartLabels . '&chxr=0,0,' . $max . '&chxs=0,444444,10,0,tl" /><br /><br />';
		}

		$pStat = $this->sqlGetRecordSet("SELECT COUNT(*) c, level l FROM player WHERE nickname != '' GROUP BY level ORDER BY level");
		$rStat = $this->sqlGetRecordSet("SELECT COUNT(DISTINCT player.id) c, player.level l FROM player INNER JOIN payment WHERE player.id = payment.player GROUP BY player.level ORDER BY player.level");
		$players = array();
		$reals = array();
		$levels = array();
		$max = 0;
		for ($i = 0; $i < 20; $i++) {
			$pCount = $pStat[$i]["c"];
			if (empty($pCount)) $pCount = 0;
			$rCount = $rStat[$i]["c"];
			if (empty($rCount)) $rCount = 0;

			if (!empty($pStat[$i]["l"])) $players[$pStat[$i]["l"] - 1] = $pCount;
			if (!empty($rStat[$i]["l"])) $reals[$rStat[$i]["l"] - 1] = $rCount;

			$levels[] = $i + 1;

			if($pCount > $max) $max = $pCount;
		}
		for ($i = 0; $i < 20; $i++) {
			if (!isset($players[$i])) $players[$i] = 0;
			if (!isset($reals[$i])) $reals[$i] = 0;
		}
		ksort($players);
		ksort($reals);
		$playerLevels = "<table class=\"stat\"><tr><th>Уровень</th><th>Игроки</th><th>Реальщики</th></tr>";
		for ($i = 0; $i < 20; $i++) {
			if ($players[$i] > 0) $playerLevels .= "<tr><td>" . ($i + 1) . "</td><td>" . $players[$i] . "</td><td>" . $reals[$i] . "</td></tr>";
		}
		$playerLevels .= "</table>";
		//print_r($players);
		//print_r($reals);
		$chartData = self::googleChartSimpleEncoding($players, $max) . "," . substr(self::googleChartSimpleEncoding($reals, $max), 2);
		$chartLabels = implode($levels, "|");

		$data .= '<br /><h1>Распределение игроков по уровням</h1>'; //<img src="http://chart.apis.google.com/chart?cht=bvo&chs=1000x240&chd=' . $chartData . '&chxt=x,y&chxl=0:|' . $chartLabels . '&chxr=1,0,' . $max . '&chxs=0,444444,10,0,tl&chco=C6D9FD,4D89F9&chdl=Игроки|Реальщики&chdlp=bv" /><br /><br />';
		$data .= $playerLevels;

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("stat_view"), array("data" => $data));
	}

	public function statBilling() {
		$this->path["Сводка покупок"] = "Stat/billing";

		$time = time();
		if (!$this->start) {
			$this->start = date("Y-m-d", $time - (86400 * 30));
		}

		if (!$this->end) {
			$this->end = date("Y-m-d", $time);
		}

		$data = "С <input type=\"text\" id=\"start\" value=\"" . $this->start . "\"> по <input type=\"text\" id=\"end\" value=\"" . $this->end . "\"> <button onclick=\"window.location.href = '/@contentico/Stat/billing/order=" . $this->order . "/start=' + $('input#start').val() + '/end=' + $('input#end').val() + '/';\">Показать</button><br /><table><tr><th>Товар</th><th><a href=\"/@contentico/Stat/billing/order=count/start=" . $this->start . "/end=" . $this->end . "/\">" . (($order == "product_count") ? "* " : "") . "Кол-во продаж</a></th><th><a href=\"/@contentico/Stat/billing/order=honey/start=" . $this->start . "/end=" . $this->end . "/\">" . (($order == "honey_sum") ? "* " : "") . "Выручено мёдна</a></th></tr>";
		$stat = $this->sqlGetRecordSet("SELECT product, sum(honey) as honey_sum, sum(1) as product_count FROM billing WHERE dt >= '" . mysql_escape_string($this->start) . "' AND dt <= '" . mysql_escape_string($this->end) . "' AND status = 'OK'  GROUP BY product;");

		$resultStat = array();
		if ($stat) {
			foreach ($stat as $rec) {
				if(preg_match("!shop\s+\[(\d+)(\sx\s(\d+))?\]!i", $rec["product"], $matches)) {
					$rec["product"] = $this->sqlGetValue("select code from standard_item where id = " . $matches[1]);
					if (!empty($matches[2])) {
						$matches[3] = intval($matches[3]);
						if ($matches[3] > 0) $rec["product_count"] = $rec["product_count"] * $matches[3];
						// $matches[3]; - количество элементов в пачке
						// $rec["product_count"] - количество пачек
						//$rec["product"] .= " x " . $matches[3];
					}
				}
				if (isset($resultStat[$rec["product"]]) && is_array($resultStat[$rec["product"]])) {
					$resultStat[$rec["product"]]["product_count"] += $rec["product_count"];
					$resultStat[$rec["product"]]["honey_sum"] += $rec["honey_sum"];
				} else {
					$resultStat[$rec["product"]] = array("product" => $rec["product"], "product_count" => $rec["product_count"], "honey_sum" => $rec["honey_sum"]);
				}
			}
		}

		switch ($this->order) {
			case "honey" :
				usort($resultStat, array($this, "statCmpHoney"));
				break;
			case "count" :
			default :
				usort($resultStat, array($this, "statCmpCount"));
				break;
		}

		if ($resultStat) {
			foreach ($resultStat as $rec) {
				$data .= "<tr><td>" . $rec["product"] . "</td><td>" . $rec["product_count"] . "</td><td>" . $rec["honey_sum"] . "</td></tr>";
			}
		}
		$data .= "</table>";
		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("stat_view"), array("data" => $data));
	}

	public function statCmpHoney($a, $b) {
		if ($a["honey_sum"] == $b["honey_sum"]) {
			return 0;
		}
		return ($a["honey_sum"] > $b["honey_sum"]) ? -1 : 1;
	}

	public function statCmpCount($a, $b) {
		if ($a["product_count"] == $b["product_count"]) {
			return 0;
		}
		return ($a["product_count"] > $b["product_count"]) ? -1 : 1;
	}

	private function processUrl() {
		for ($i = 1; $i < sizeof($this->url); $i++) {
			$urlPart = explode("=", $this->url[$i]);
			$this->{$urlPart[0]} = $urlPart[1];
		}
	}
}
?>