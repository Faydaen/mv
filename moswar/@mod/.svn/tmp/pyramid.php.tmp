<?php
class Pyramid extends Page implements IModule
{
    public $moduleCode = 'Nightclub';
	public static $increaseProcent = 10;
	public static $startPrice = 100;
	public static $collectionId = 0;
	public static $forecastPrice = array('ore' => 1);

	public static $grandpaJokes = array(
		'Бабушки считают, что молодежь уже не та.',
		'Бабушки говорят, что цены на сахар вырастут.',
		'Бабушки считают, что ты слишком подозрительный и вот-вот вызовут милицию.',
		'Бабушки считают, что без шерстяных носков никуда!',
		'Бабушки считают, что зимой скамейки у подъезда улетают на юг, засим зимой сидят дома.',
		'Бабушки считают, что если где-то есть очередь без бабушек, это неправильная очередь.',
		'Бабушки говорят, что у них плохая память, но при этом помнят сколько стоила гречка в продуктовом 12 октября 1962 года.',
		'Бабушки считают, что надо делать запасы продуктов на случай войны.',
		'Бабушки уверены, что чем больше таблеток, тем лучше.',
		'Бабушки уверены, что вязание раскрывает чакры.',
		'Бабушки искренне верят, что из конопли делают только рубашки и веревки.',
		'Бабушки считают, что все приходящие к ее внучке парни - хулиганы и наркоманы.',
		'Бабушки говорят, что они плохо слышат, но прибегают из другой комнаты когда по телевизору рассказывают про пенсии.',
		'Бабушки говорят, что плохо себя чувствуют и скоро умрут, после чего совершают многокилометровые прогулки по магазинам за гречкой.',
		'Бабушки считают, что раньше фильмы снимали лучше.',
		'Бабушки считают, что не видят без очков, но запросто вдевают нитку в иголку без них.',
		'Бабушкам нравится болтать по видеосвязи с подружками по скайпу.',
		'Бабушки считают свом истинным предназначением сидеть с внуками.',
		'Бабушки считают, что пешеходный переход всегда там, где они переходят дорогу.',
		'Бабушки думают, что российский автопром подходит для поездок на дачу.',
		'Бабушки уверены, что только они действительно осознают всю важность происходящего.',
		'Бабушки уверены, что все продавщицы в магазинах их обвешивают.',
		'Бабушки считают, что авоська вмещает больше продуктов, чем полиэтиленовый пакет.',
		'Бабушки считают, что сметана вкуснее и полезнее майонеза.',
		'Бабушки уверены, что их час еще настанет.',
		'Бабушки знают, что в СССР на такси в булочную не ездили.',
		'Бабушки считают, что финансовый кризис - это всемирный заговор капиталистов.',
		'Бабушки знают, что завещал товарищ Ленин.',
		'Бабушки считают, что они лучше дедушек.',
		'Бабушки считают, что им должны уступать очередь.',
		'Бабушки считают, что Хрущев показал американцам кузькину мать.',
		'Бабушки считают, что это все от лукавого.',
		'Бабушки думают, что гречка опять подорожает.',
		'Бабушки считают, что желтые машины красивее черных.',
		'Бабушки уверены, что народные приметы точнее прогнозов метеорологов.',
		'Бабушки считают, что на телевидении не осталось нормальных программ.',
		'Бабушки считают, что финансовые пирамиды до добра не доведут.',
		'Бабушки думают, лампочку в подъезде разбил алкоголик Федя.',
		'Бабушки уверены, что подозрительный тип в желтом костюме - вор и обманщик.',
		'Бабушки уверены, что наперсточники всегда мухлюют.',
		'Бабушки думают, что есть много сладкого - вредно.',
		'Бабушки думают, что все девушки школьного возраста - их внучки.'
	);

    public function __construct() {
        parent::__construct();
    }

    public function processRequest() {
        parent::onBeforeProcessRequest();
		$this->needAuth();
        //

		if (DEV_SERVER && Page::$player->id == 1) {
			if ($this->url[0] == 'r') {
				$query = "UPDATE pyramid_partners SET lastactiondt = '2011-01-01 00:00:00' WHERE player = " . Page::$player->id;
				Page::$sql->query($query);
				Std::redirect('/pyramid/');
			} else if ($this->url[0] == 'i') {
				self::increasePyramidPrice();
				Std::redirect('/pyramid/');
			} else if ($this->url[0] == 'n') {
				self::resetPyramid(true);
				Std::redirect('/pyramid/');
			} else if ($this->url[0] == 'f') {
				self::refreshStat();
				Std::redirect('/pyramid/');
			}
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->url[0] == 'buy') {
				$result = self::actionBuy((int) $this->url[1]);
			} else if ($this->url[0] == 'sell') {
				$result = self::actionSell();
			} else if ($this->url[0] == 'forecast') {
				$result = self::actionForecast();
			}

			$this->processPostRequest($result);
		}

		$this->showPyramid();
        //
        parent::onAfterProcessRequest();
    }

	public static function resetPyramid($resetStartAt = false) {
		$query = "TRUNCATE TABLE pyramid_partners";
		Page::$sql->query($query);
		CacheManager::set('pyramid_partners', 0);
		CacheManager::set('pyramid_partners_rt', 0);

		$query = "UPDATE value SET value = 0 WHERE name IN ('pyramid_fond', 'pyramid_partners', 'pyramid_fond_rt', 'pyramid_fond_change', 'pyramid_progress')";
		Page::$sql->query($query);
		CacheManager::set('pyramid_fond', 0);
		CacheManager::set('pyramid_fond_rt', 0);
		CacheManager::set('pyramid_fond_change', 0);
		CacheManager::set('pyramid_progress', 0);

		$query = "UPDATE value SET value = " . self::$startPrice . " WHERE name = 'pyramid_cost'";
		Page::$sql->query($query);
		CacheManager::set('pyramid_cost', self::$startPrice);

		if ($resetStartAt) {
			$pyramid_startat = date('Y-m-d H:i:s', time() + 86400 * 2);
			CacheManager::set('pyramid_startat', $pyramid_startat);
			$query = "UPDATE value SET value = '" . $pyramid_startat . "' WHERE name = 'pyramid_startat'";
			Page::$sql->query($query);
		}

		$query = "UPDATE pyramid_history SET fond = 0, partners = 0";
		Page::$sql->query($query);
	}

	public static function increasePyramidPrice() {
		$pyramid = self::getPyramid();
		$cost = $pyramid['pyramid_cost'];
		$cost = round($cost * (100 + self::$increaseProcent) / 100);
		CacheManager::set('pyramid_cost', $cost);
		$query = "UPDATE value SET value = " . $cost . " WHERE name = 'pyramid_cost'";
		Page::$sql->query($query);

		$progress = $pyramid['pyramid_progress'];
		if (rand(1, 100) < $progress) {
			$pyramid_startat = date('Y-m-d H:i:s', time() + 86400 * 2);
			CacheManager::set('pyramid_startat', $pyramid_startat);
			$query = "UPDATE value SET value = '" . $pyramid_startat . "' WHERE name = 'pyramid_startat'";
			Page::$sql->query($query);
		}

		$progress += rand(2, 5);
		CacheManager::set('pyramid_progress', $progress);
		$query = "UPDATE value SET value = " . $progress . " WHERE name = 'pyramid_progress'";
		Page::$sql->query($query);
	}

	public static function refreshStat() {
		CacheManager::forceReload('pyramid_partners_rt');
		$pyramid = self::getPyramid();

		$pyramid['pyramid_partners'] = $pyramid['pyramid_partners_rt'];
		CacheManager::set('pyramid_partners', $pyramid['pyramid_partners']);
		$query = "UPDATE value SET value = " . $pyramid['pyramid_partners'] . " WHERE name = 'pyramid_partners'";
		Page::$sql->query($query);

		$pyramid['pyramid_fond_change'] = $pyramid['pyramid_fond_rt'] - $pyramid['pyramid_fond'];
		CacheManager::set('pyramid_fond_change', $pyramid['pyramid_fond_change']);
		$query = "UPDATE value SET value = " . $pyramid['pyramid_fond_change'] . " WHERE name = 'pyramid_fond_change'";
		Page::$sql->query($query);

		$pyramid['pyramid_fond'] = $pyramid['pyramid_fond_rt'];
		CacheManager::set('pyramid_fond', $pyramid['pyramid_fond']);
		$query = "UPDATE value SET value = " . $pyramid['pyramid_fond'] . " WHERE name = 'pyramid_fond'";
		Page::$sql->query($query);

		$h = floor(date('H') / 4) * 4;
		$query = "UPDATE pyramid_history SET fond = " . $pyramid['pyramid_fond'] . ", partners = " . $pyramid['pyramid_partners'] . " WHERE hour = " . $h;
		Page::$sql->query($query);
	}

	public static function actionBuy($amount) {
		$result = array('type' => 'pyramid', 'action' => 'buy', 'return_url' => '/pyramid/');

		$pyramid = self::getPyramid();
		$result['pyramid'] = $pyramid;

		$money = array('money' => $amount * $pyramid['pyramid_cost']);

		if (!Page::isEnoughMoney($money)) {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_NO_MONEY;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		if ($pyramid['pyramid_state'] == 'crashed') {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_PYRAMID_CRASHED;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		$player = self::getPlayer();
		$result['player'] = $player;

		if ($player['when_action_avail'] !== 0) {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_ACTION_NOT_AVAIL;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		$fields = Page::spendMoney($money, true, $changes, 'pyramid buy');

		foreach ($fields as $currency) {
			$result['wallet'][$currency] = Page::$player->{$currency};
		}

		$result['result'] = 1;

		$result['player']['your_pyramids'] += $amount;
		$result['player']['lastactiondt'] = date('Y-m-d H:i:s');
		//$result['player']['lastactiondt'] = '2011-01-01 00:00:00';
		$result['player']['when_action_avail'] = date('H:i d.m.Y', self::whenActionAvail($result['player']));
		if ($player['partner'] == 0) {
			$query = "INSERT INTO pyramid_partners (player, pyramids, lastactiondt)
						VALUES (" . Page::$player->id . ", " . $amount . ", '" . $result['player']['lastactiondt'] . "')";
		} else {
			$query = "UPDATE pyramid_partners
				SET pyramids = pyramids + " . $amount . ",
					lastactiondt = '" . $result['player']['lastactiondt'] . "'
				WHERE player = " . Page::$player->id;
		}
		Page::$sql->query($query);

		$query = "UPDATE value SET value = value + " . $money['money'] . " WHERE name = 'pyramid_fond_rt'";
		Page::$sql->query($query);
		$result['pyramid']['pyramid_fond_rt'] += $money['money'];
		CacheManager::set('pyramid_fond_rt', $result['pyramid']['pyramid_fond_rt']);

		$log = array('p' => $amount, 'm' => $money['money'], 'mbckp' => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey));
		Page::sendLog(Page::$player->id, 'pyrb', $log, 1);

		if ($player['your_pyramids'] == 0) {
			$query = "UPDATE value SET value = value + 1 WHERE name = 'pyramid_partners_rt'";
			Page::$sql->query($query);
			Page::$cache->increment('pyramid_partners_rt', 1);
			$result['pyramid']['pyramid_partners_rt'] += 1;
		}

		unset($result['pyramid']['pyramid_fondt_rt'], $result['pyramid_partners_rt']);

		return $result;
	}

	public static function actionSell() {
		$result = array('type' => 'pyramid', 'action' => 'sell', 'return_url' => '/pyramid/');

		$pyramid = self::getPyramid();
		$result['pyramid'] = $pyramid;
		
		if ($pyramid['pyramid_state'] == 'crashed') {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_PYRAMID_CRASHED;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		$player = self::getPlayer();
		$result['player'] = $player;

		if ($player['when_action_avail'] !== 0) {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_ACTION_NOT_AVAIL;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		if ($result['player']['your_pyramids'] == 0) {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_NO_PYRAMIDS;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		$sellPrice = round($result['pyramid']['pyramid_cost'] / ((100 + self::$increaseProcent) / 100));

		$pyramidsHave = floor($result['pyramid']['pyramid_fond_rt'] / $sellPrice);
		if ($pyramidsHave < $result['player']['your_pyramids']) {
			$full = false;
			$pyramids = $pyramidsHave;
		} else {
			$full = true;
			$pyramids = $result['player']['your_pyramids'];
		}
		$money = array('money' => $pyramids * $sellPrice);

		$fields = Page::giveMoney($money, true);

		foreach ($fields as $currency) {
			$result['wallet'][$currency] = Page::$player->{$currency};
		}

		$result['result'] = 1;

		$result['player']['your_pyramids'] -= $pyramids;
		$result['player']['lastactiondt'] = date('Y-m-d H:i:s');
		//$result['player']['lastactiondt'] = '2011-01-01 00:00:00';
		$result['player']['when_action_avail'] = date('H:i d.m.Y', self::whenActionAvail($result['player']));
		$query = "UPDATE pyramid_partners
				SET pyramids = pyramids - " . $pyramids . ",
					lastactiondt = '" . $result['player']['lastactiondt'] . "'
				WHERE player = " . Page::$player->id;
		Page::$sql->query($query);

		$query = "UPDATE value SET value = value - " . $money['money'] . " WHERE name = 'pyramid_fond_rt'";
		Page::$sql->query($query);
		$result['pyramid']['pyramid_fond_rt'] -= $money['money'];
		CacheManager::set('pyramid_fond_rt', $result['pyramid']['pyramid_fond_rt']);


		if ($full === true) {
			$result['pyramid']['pyramid_partners_rt'] -= 1;
			CacheManager::set('pyramid_partners_rt', $result['pyramid']['pyramid_partners_rt']);
		} else {
			$result['pyramid']['pyramid_startat'] = date('Y-m-d H:i:s', time() + 86400 * 2);
			CacheManager::set('pyramid_startat', $result['pyramid_startat']);
			$query = "UPDATE value SET value = '" . $result['pyramid_startat'] . "' WHERE name = 'pyramid_startat'";
			Page::$sql->query($query);
			$result['pyramid']['pyramid_state'] = 'crashed';
			$result['pyramid']['pyramid_start_in'] = strtotime($result['pyramid']['pyramid_startat']) - time();
			$result['text'] = Std::renderTemplate(PyramidLang::OK_PARTLY_BAYOUT, array('pyramids' => $pyramids, 'money' => $money['money']));
		}

		$log = array('p' => $pyramids, 'm' => $money['money'], 'mbckp' => array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey));
		Page::sendLog(Page::$player->id, 'pyrs', $log, 1);

		unset($result['pyramid']['pyramid_fond_rt'], $result['pyramid']['pyramid_partners_rt']);
		return $result;
	}

	public static function actionForecast() {
		$result = array('type' => 'pyramid', 'action' => 'forecast', 'return_url' => '/pyramid/');

		$pyramid = self::getPyramid();
		$result['pyramid'] = $pyramid;

		$money = self::$forecastPrice;

		if (!Page::isEnoughMoney($money)) {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_NO_MONEY;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		if ($pyramid['pyramid_state'] == 'crashed') {
			$result['result'] = 0;
			$result['error'] = PyramidLang::ERROR_PYRAMID_CRASHED;
			$result['return_url'] = '/pyramid/';
			return $result;
		}

		$fields = Page::spendMoney($money, true, $changes, 'pyramid buy');

		foreach ($fields as $currency) {
			$result['wallet'][$currency] = Page::$player->{$currency};
		}

		$result['result'] = 1;

		$log = array('m' => Page::translatePriceForLogs($changes), 'mbckp' => Page::$player->getMbckp());

		if (rand(1, 100) <= 20) {
			$r = 'advice';
		} else {
			$r = 'joke';
		}
		if ($r == 'advice') {
			$h = (ceil(date('H') / 4) * 4) % 24;
			$query = "SELECT fond, partners FROM pyramid_history WHERE hour = " . $h;
			$history = Page::$sql->getRecord($query);

			$change['fond'] = $pyramid['pyramid_fond'] - $history['fond'];
			$change['partners'] = $pyramid['pyramid_partners'] - $history['partners'];

			if ($change['partners'] * 0.4 + $change['fond']/$pyramid['pyramid_cost'] * 0.6 >= 0) {
				$advise = '<b>' . PyramidLang::GRANDPA_BUY . '</b>';
				$log['a'] = 'buy';
			}/* else if ($change['history'] < 0 && $change['partners'] < 0) {
				$advise = 'sell';
			} */else {
				$advise = '<b>' . PyramidLang::GRANDPA_SELL . '</b>';
				$log['a'] = 'sell';
			}
		} else {
			$advise = self::$grandpaJokes[rand(0, count(self::$grandpaJokes)-1)];
		}

		$result['advise'] = $advise;

		
		Page::sendLog(Page::$player->id, 'pyrf', $log, 1);

		

		unset($result['pyramid']['pyramid_fondt_rt'], $result['pyramid_partners_rt']);

		return $result;
	}

	public static function isActionAvail($player) {
		if (self::whenActionAvail($player) < time()) {
			return false;
		} else {
			return true;
		}
	}

	public static function whenActionAvail($player) {
		$time = strtotime($player['lastactiondt']);
		$next = strtotime(date('Y-m-d', $time) . ' 00:00:00') + 86400;
		if ($next > time()) {
			return $next;
		} else {
			return 0;
		}
	}

	public static function getPyramid() {
		$result = CacheManager::multiGet('pyramid_cost', 'pyramid_partners', 'pyramid_fond', 'pyramid_startat', 'pyramid_partners_rt', 'pyramid_fond_rt', 'pyramid_fond_change', 'pyramid_progress');
		if ($result['pyramid_fond_rt'] < $result['pyramid_cost'] && $result['pyramid_partners_rt'] > 0 && strtotime($result['pyramid_startat']) < time()) {
			$result['pyramid_startat'] = date('Y-m-d H:i:s', time() + 86400 * 2);
			CacheManager::set('pyramid_startat', $result['pyramid_startat']);
			$query = "UPDATE value SET value = '" . $result['pyramid_startat'] . "' WHERE name = 'pyramid_startat'";
			Page::$sql->query($query);
		}
		if (strtotime($result['pyramid_startat']) > time()) {
			$result['pyramid_state'] = 'crashed';
		} else {
			$result['pyramid_state'] = 'working';
		}
		$result['pyramid_partners'] = (int) $result['pyramid_partners'];
		$result['pyramid_partners_rt'] = (int) $result['pyramid_partners_rt'];
		$result['pyramid_cost_sell'] = round($result['pyramid_cost'] / ((100 + self::$increaseProcent) / 100));
		return $result;
	}

	public static function getPlayer() {
		$query = "SELECT pyramids, lastactiondt FROM pyramid_partners WHERE player = " . Page::$player->id;
		$player = Page::$sql->getRecord($query);
		if ($player === false) {
			$result['partner'] = 0;
			$result['your_pyramids'] = 0;
			$result['when_action_avail'] = 0;
		} else {
			$result['partner'] = 1;
			$result['your_pyramids'] = $player['pyramids'];
			$result['when_action_avail'] = self::whenActionAvail($player);
			if ($result['when_action_avail'] !== 0) {
				$result['when_action_avail'] = date('H:i d.m.Y', $result['when_action_avail']);
			}
		}
		return $result;
	}

	protected function showPyramid() {
		$this->content = array_merge($this->content, self::getPyramid(), self::getPlayer());

		if ($this->content['pyramid_state'] == 'crashed') {
			$this->content['pyramid_start_in'] = strtotime($this->content['pyramid_startat']) - time();
		} else {
			$this->content['pyramid_fond_change_abs'] = abs($this->content['pyramid_fond_change']);
		}

		$this->content['forecast_price'] = self::$forecastPrice;

		$this->content['window-name'] = 'Пирамида WWW';
		$this->page->addPart('content', 'pyramid/pyramid.xsl', $this->content);
	}

}
//create table pyramid_partners (player int unsigned not null, pyramids smallint unsigned not null, lastactiondt date not null, primary key (player)) engine=innodb default charset = utf8;
//insert into value (name, value) values('pyramid_cost', 100), ('pyramid_fond', 0), ('pyramid_startat', '2010-01-01 00:00:00'), ('pyramid_fond_rt', 0), ('pyramid_partners', 0), ('pyramid_fond_change', 0);

?>