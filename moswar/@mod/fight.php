<?php
class Fight extends Page implements IModule
{
    public $moduleCode = 'Fight';
	public static $timeouts = array(15, 30, 45, 60, 90, 120, 150, 180, 210, 240);
	public static $fight;

	public static $killedNow = array();

    public static $levelFightPrize = array(
        '1'  => array('m' => 1500, 'o' => 0),
        '2'  => array('m' => 3000, 'o' => 0),
        '3'  => array('m' => 4500, 'o' => 0),
        '4'  => array('m' => 6000, 'o' => 0),
        '5'  => array('m' => 0,    'o' => 50),
        '6'  => array('m' => 0,    'o' => 90),
        '7'  => array('m' => 0,    'o' => 135),
        '8'  => array('m' => 0,    'o' => 180),
        '9'  => array('m' => 0,    'o' => 225),
        '10' => array('m' => 0,    'o' => 270),
        '11' => array('m' => 0,    'o' => 315),
        '12' => array('m' => 0,    'o' => 360),
        '13' => array('m' => 0,    'o' => 405),
        '14' => array('m' => 0,    'o' => 450),
        '15' => array('m' => 0,    'o' => 495),
		'16' => array('m' => 0,    'o' => 540),
		'17' => array('m' => 0,    'o' => 590),
		'18' => array('m' => 0,    'o' => 640),
		'19' => array('m' => 0,    'o' => 690),
		'20' => array('m' => 0,    'o' => 750),
    );
    public static $levelFightCost = array(
        '1'  => array('m' => 10, 'o' => 0),
        '2'  => array('m' => 20, 'o' => 0),
        '3'  => array('m' => 30, 'o' => 0),
        '4'  => array('m' => 40, 'o' => 0),
        '5'  => array('m' => 0,  'o' => 1),
        '6'  => array('m' => 0,  'o' => 2),
        '7'  => array('m' => 0,  'o' => 3),
        '8'  => array('m' => 0,  'o' => 4),
        '9'  => array('m' => 0,  'o' => 5),
        '10' => array('m' => 0,  'o' => 6),
        '11' => array('m' => 0,  'o' => 7),
        '12' => array('m' => 0,  'o' => 8),
        '13' => array('m' => 0,  'o' => 9),
        '14' => array('m' => 0,  'o' => 10),
        '15' => array('m' => 0,  'o' => 11),
		'16' => array('m' => 0,  'o' => 12),
		'17' => array('m' => 0,  'o' => 13),
		'18' => array('m' => 0,  'o' => 14),
		'19' => array('m' => 0,  'o' => 15),
		'20' => array('m' => 0,  'o' => 16),
    );
    public static $chaoticFightCost = array(
        '1'  => array('m' => 30),
        '2'  => array('m' => 70),
        '3'  => array('m' => 150),
        '4'  => array('m' => 300),
        '5'  => array('m' => 400),
        '6'  => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '7'  => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '8'  => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '9'  => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '10' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '11' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '12' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '13' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '14' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
        '15' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
		'16' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
		'17' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
		'18' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
		'19' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
		'20' => array('m' => 500, 'zub' => 2, 'huntbadge' => 4),
    );

    /**
     * Сейчас идет бой или просто показывается лог
     *
     * @var bool
     */
	public $fighting = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        Std::loadMetaObjectClass('fight');

		if (self::$player->state == 'fight') {
			// участие в бою
			Fight::$fight = new fightObject();
			//if (Fight::$fight->load(self::$sql->getValue("SELECT stateparam FROM player WHERE id = " . self::$player->id . " AND state='fight'"))) {
            if (Fight::$fight->load(self::$player->stateparam)) {
                Fight::$fight->data = json_decode(Fight::$fight->data, true);
                Fight::$fight->players = json_decode(Fight::$fight->players, true);
                Fight::$fight->results = json_decode(Fight::$fight->results, true);
                Fight::$fight->log = json_decode(Fight::$fight->log, true);

                $ok = true;
                $this->fighting = true;
            } else {
                self::$player->state = "";
                self::$player->stateparam = "";
                self::$player->timer = 0;
                self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$STATEPARAM, playerObject::$TIMER));

                Std::redirect('/alley/');
            }
		} elseif (is_numeric($this->url[0])) {
			// просмотр боя
			Fight::$fight = new fightObject();
			if (Fight::$fight->load($this->url[0])) {
				Fight::$fight->data = json_decode(Fight::$fight->data, true);
                Fight::$fight->players = json_decode(Fight::$fight->players, true);
                Fight::$fight->results = json_decode(Fight::$fight->results, true);
                Fight::$fight->log = json_decode(Fight::$fight->log, true);
			} else {
                Page::addAlert(FightLang::$error, FightLang::$errorFightNotFound);
                Std::redirect('/alley/', true);
            }
            $ok = true;
		}

//		if ($ok == true) {
//
//		}

        switch ($_POST['action']) {
            case 'create fight':
                $result = Fight::createFight((int)$_POST['minlevel'], (int)$_POST['maxlevel'], (int)$_POST['side1_amount'], (int)$_POST['side2_amount'], $_POST['type'], $_POST['timeout'], $_POST['clan']);
                Runtime::set('content/result', $result);
                Std::redirect($result['params']['url']);
                break;

            case 'join fight':
                $result = Fight::joinFight((int)$_POST['fight']);
                Runtime::set('content/result', $result);
                Std::redirect($result['params']['url'], true);
                break;

            case 'attack':
            case 'defence':
            case 'useitem':
            case 'rupor':
                $result = Fight::attack($_POST['target']);
                echo json_encode($result);
                exit;
                break;
            /*
            case 'useitem':
                $result = Fight::useItem($_POST['item']);
                echo json_encode($result);
                exit;
                break;
            */

            case 'create_test_fight':
                if (self::$player->accesslevel == 100) {
                    self::createFight('test');
                }
                Std::redirect('/alley/', true);
                exit;
                break;

            case 'join_test_fight':
                if (self::$player->accesslevel == 100) {
                    self::joinFight(self::$sql->getValue("SELECT id FROM fight WHERE type='test' AND state='created'"));
                }
                Std::redirect('/alley/', true);
                exit;
                break;

            case 'start_test_fight':
                if (self::$player->accesslevel == 100) {
                    self::startFight(self::$sql->getValue("SELECT id FROM fight WHERE type='test' AND state='created'"));
                }
                Std::redirect('/alley/', true);
                exit;
                break;

		}

		if ($ok != true) {
			Std::redirect('/player/');
		} else {
			$this->showFight();
		}

        //
        parent::onAfterProcessRequest();
    }

    /**
     * Создание группового боя (вызывается из крона)
     *
     * @param string $type - flag, bank, clanwar
     * @param int $diplomacy
     */
	public static function createFight($type, $diplomacy = 0, $params = array())
    {
		Std::loadMetaObjectClass('fight');

        $fight = new fightObject();
        $fight->type = $type;
        $fight->state = 'created';
        $fight->data = array(
            's' => 0, // starter
            'a' => array( // attackers
                'f' => '', // fraction
                'm' => 0, // max заявок
                'm2' => 0, // max участников, попадающих в бой после старта
				'm3' => 0, // max участников всего
                'c' => 0, // count
                'k' => 0, // kills
                //'cl' => 0, // clan
                //'nm' => '', // название клана
            ),
            'd' => array( // defenders
                'f' => '',
                'm' => 0,
                'm2' => 0,
				'm3' => 0,
                'c' => 0,
                'k' => 0
            ),
            'p' => array(), // players
            'l1' => 0,
            'l2' => 0,
            // 'dp' => 0, // diplomacy
            // 'f' => 0, // flagplayer
        );
        $fight->players = '';
        $fight->playersid = '';
        $fight->results = array(
            'w' => '', // winners
            'k' => array( // killer
                'p' => 0, // player
                'k' => 0, // kills
            ),
            'd' => array( // damager
                'p' => 0,
                'd' => 0,
            ),
        );
        //$fight->step = 0;
        $fight->steps = 0;
        $fight->log = "";
        $fight->diplomacy = 0;
        $fight->level = 0;
        $fight->ac = $fight->dc = 0;

        $curMaxLevel = CacheManager::get('value_maxlevel');
        $curLevelFightMaxLevel = CacheManager::get('value_levelfightmaxlevel');
        $curBankFightMaxLevel = CacheManager::get('value_bankfightmaxlevel');

        switch ($fight->type) {
            case 'flag':
                Std::loadMetaObjectClass('player');

                $fight->data['f'] = CacheManager::get('value_flag_player');
                $fight->results['f'] = 0;

                $flagPlayer = new playerObject();
                $flagPlayer->load($fight->data['f']);

                $fight->data['d']['f'] = $flagPlayer->fraction{0};
                $fight->data['a']['f'] = $flagPlayer->fraction == 'resident' ? 'a' : 'r';
                $fight->data['d']['c'] = $fight->dc = 1;
                $fight->data['a']['c'] = $fight->ac = 0;
                $fight->data['l1'] = DEV_SERVER ? 7 : 12;//$flagPlayer->level - 1;
                $fight->data['l2'] = 99;//$flagPlayer->level + 1;

                $fight->dt = date('Y-m-d 21:30:00', time());
				$fight->start_dt = $fight->dt;
                $fight->data['a']['m'] = $fight->data['d']['m'] = 40;
                $fight->am = $fight->dm = 40;
                $m2 = explode(',', CacheManager::get('value_flag_fight_m2'));
                $fight->data['a']['m2'] = $fight->data['a']['f'] == 'r' ? (int)$m2[0] : (int)$m2[1];
                $fight->data['d']['m2'] = $fight->data['d']['f'] == 'r' ? (int)$m2[0] : (int)$m2[1];
				$fight->data['a']['m3'] = $fight->data['a']['m2'] + 15;
                $fight->data['d']['m3'] = $fight->data['d']['m2'] + 15;

                if ($flagPlayer->state != '') {
                    $flagPlayer->state2 = json_encode(array(
                        'state' => $flagPlayer->state,
                        'stateparam' => $flagPlayer->stateparam,
                        'timer' => $flagPlayer->timer,
                    ));
                }
                $flagPlayer->state = 'frozen';
                $flagPlayer->stateparam = json_encode(array(
                    'action' => 'redirect',
                    'url' => '/fight/',
                ));
                $flagPlayer->timer = strtotime($fight->dt) + 3;
                $flagPlayer->save($flagPlayer->id, array(playerObject::$TIMER, playerObject::$STATE, playerObject::$STATEPARAM, playerObject::$STATE2));

                $flagPlayer = $flagPlayer->exportForGroupFight();
                $flagPlayer['sd'] = 'd';
                break;

            case 'clanwar':
                $fight->diplomacy = (int)$diplomacy;
                $fight->dt = date('Y-m-d H:00:00', time() + 3600);
				$fight->start_dt = $fight->dt;
                $fight->data['dp'] = (int)$diplomacy;
                $fight->data['a']['m'] = $fight->data['d']['m'] = 30;
                $fight->am = $fight->dm = 30;
                $fight->data['a']['m2'] = $fight->data['d']['m2'] = 15;
				$fight->data['a']['m3'] = 30;
				$fight->data['d']['m3'] = 30;
                $clans = self::$sql->getRecord("
                    SELECT d.clan1, d.clan2, c1.fraction fraction1, c2.fraction fraction2, c1.name name1, c2.name name2
                    FROM diplomacy d LEFT JOIN clan c1 ON c1.id=d.clan1 LEFT JOIN clan c2 ON c2.id=d.clan2
                    WHERE d.id=" . $diplomacy);
                $fight->data['a']['f'] = $clans['fraction1']{0};
                $fight->data['d']['f'] = $clans['fraction2']{0};
                $fight->data['a']['cl'] = (int)$clans['clan1'];
                $fight->data['d']['cl'] = (int)$clans['clan2'];
                $fight->data['a']['nm'] = $clans['name1'];
                $fight->data['d']['nm'] = $clans['name2'];
                break;

            case 'level':
                $fight->level = (int)$diplomacy;
                $fight->dt = date('Y-m-d H:00:00', time() + 3600);
				$fight->start_dt = $fight->dt;
                $fight->data['a']['m'] = $fight->data['d']['m'] = 30;
                $fight->am = $fight->dm = 30;
                $fight->data['a']['m2'] = $fight->data['d']['m2'] = 15;
				$fight->data['a']['m3'] = 30;
				$fight->data['d']['m3'] = 30;
                $fight->data['a']['f'] = mt_rand(1, 2) == 1 ? 'r' : 'a';
                $fight->data['d']['f'] = $fight->data['a']['f'] == 'r' ? 'a' : 'r';
                $fight->data['l1'] = (int)$fight->level;
                $l2 = (int)$fight->level;
                if ($l2 == $curLevelFightMaxLevel) {
                    $l2 = 99; //$l2++;
                }
                $fight->data['l2'] = $l2;
                $fight->data['pz'] = self::$levelFightPrize[$fight->level];
                break;

            case 'bank':
                $fight->level = (int)$diplomacy;
                $fight->dt = date('Y-m-d H:00:00', time() + 3600);
				$fight->start_dt = $fight->dt;
                $fight->data['a']['m'] = $fight->data['d']['m'] = DEV_SERVER ? 10 : 1000;
                $fight->am = $fight->dm = DEV_SERVER ? 10 : 1000;
                $fight->data['a']['m2'] = $fight->data['d']['m2'] = DEV_SERVER ? 5 : 20;
				$fight->data['a']['m3'] = $fight->data['a']['m2'];
				$fight->data['d']['m3'] = $fight->data['d']['m2'];
                $fight->data['a']['f'] = '';
                $fight->data['d']['f'] = 'npc';
                $fight->data['l1'] = (int)$fight->level;
                $l2 = (int)$fight->level;
                if ($l2 == $curBankFightMaxLevel) {
                    $l2 = 99; //$l2++;
                }
                $fight->data['l2'] = $l2;
                $fight->data['pz'] = $params['money'];
                break;

            case 'test':
                $fight->dt = date('Y-m-d H:00:00', time() + 3600);
				$fight->start_dt = $fight->dt;
                $fight->data['a']['m'] = $fight->data['d']['m'] = 10;
				$fight->data['a']['m3'] = $fight->data['a']['m2'];
				$fight->data['d']['m3'] = $fight->data['d']['m2'];
                $fight->am = $fight->dm = 10;
                $fight->data['a']['m2'] = $fight->data['d']['m2'] = 3;
                $fight->data['a']['f'] = self::$player->fraction{0};
                $fight->data['d']['f'] = self::$player->fraction == 'resident' ? 'a' : 'r';
                break;

            case "chaotic":
                $fight->level = (int)$diplomacy;
                $fight->dt = date('Y-m-d H:i:00', time() + ((floor(date('i') / 15 + 1) * 15) - date('i')) * 60);
				$fight->start_dt = $fight->dt;
                $fight->data['a']['m'] = $fight->data['d']['m'] = 20;
                $fight->am = $fight->dm = 20;
                $fight->data['a']['m2'] = $fight->data['d']['m2'] = 10;
				if ($fight->level == 0) {
					$fight->data['a']['m'] = $fight->data['d']['m'] = 100;
					$fight->am = $fight->dm = 100;
					$fight->data['a']['m2'] = $fight->data['d']['m2'] = 100;
				}
				$fight->data['a']['m3'] = $fight->data['a']['m2'];
				$fight->data['d']['m3'] = $fight->data['d']['m2'];
                $fight->data['a']['f'] = '';
                $fight->data['d']['f'] = '';
                $fight->data['l1'] = (int)$fight->level;
                $l2 = (int)$fight->level;
                if ($l2 == $curLevelFightMaxLevel) {
                    $l2 = 99; //$l2++;
                }
                $fight->data['l2'] = $l2;
                break;

            case "metro":
                $h = (int)date('H', time());
                $m = (int)date("i", time());
                if ($m < 20) { // если менее 20 минут, то следующий групповой - в 20 минут
                    $m = 20;
                } else {
                    if ($m < 40) { // если менее 40 минут, то следующий групповой - в 40 минут
                        $m = 40;
                    } else { // если более 40 минут, то следующий групповой - в 20 минут следующего часа
                        $m = 20;
                        $h++;
                    }
                }
                if ($h > 23) { // если следующий час = 24 - говорим, что бои завершены
                    return;
                }

                $fight->level = (int)$diplomacy;
                $fight->dt = date('Y-m-d ' . $h . ':' . $m . ':00', time());
				$fight->start_dt = $fight->dt;
                $fight->data['a']['m'] = $fight->data['d']['m'] = 100;
                $fight->am = $fight->dm = 100;
                $fight->data['a']['m2'] = $fight->data['d']['m2'] = 20;
				$fight->data['a']['m3'] = $fight->data['d']['m3'] = 60;

                $me = $m == 20 ? "r" : "a";

                $sovet3 = self::$sql->getRecord("SELECT id, enemy, enemy_npc FROM sovet3 WHERE fraction = '" . ($m == 20 ? "resident" : "arrived") . "' ORDER BY id DESC LIMIT 0,1");

                $enemy = $sovet3["enemy"] == "npc" ? "npc" : ($m == 20 ? "a" : "r");

                $fight->data['a']['f'] = $me;
                $fight->data['d']['f'] = $enemy;

                if ($enemy == "npc") {
                    $fight->data['d']['f2'] = $sovet3["enemy_npc"];
                }

                $fight->data['l1'] = (int)$fight->level;
                $l2 = (int)$fight->level;
                if ($l2 == $curLevelFightMaxLevel) {
                    $l2 = 99; //$l2++;
                }
                $fight->data['l2'] = $l2;
                break;
        }
        $fight->data['dt'] = $fight->dt;

        $fight->data = json_encode($fight->data);
        $fight->results = json_encode($fight->results);

        $fight->save();

        if ($fight->type == "flag") {
			// CHAT флаг-обладатель записался в бой
			$key = self::signed($flagPlayer['id']);
			$userInfo = array();
			$userInfo[$key] = array();
			$userInfo[$key]["fight_side"] = $flagPlayer['sd'];
			$userInfo[$key]["fight_id"] = $fight->id;
			$userInfo[$key]["fight_state"] = $fight->state;
			$userInfo[$key]["fight_dt"] = strtotime($fight->start_dt);
			Page::chatUpdateInfo($userInfo);

			$cachePlayer = self::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["fight_side"] = $flagPlayer['sd'];
				$cachePlayer["fight_id"] = $fight->id;
				$cachePlayer["fight_state"] = $fight->state;
				$cachePlayer["fight_dt"] = strtotime($fight->start_dt);
				self::$cache->set("user_chat_" . $key, $cachePlayer);
			}

            self::$sql->query("INSERT INTO fightplayer (fight, player, data, side)
                VALUES (" . $fight->id . ", " . $flagPlayer['id'] . ", '" . addslashes(json_encode($flagPlayer)) . "', '" . $flagPlayer['sd'] . "')");
        }
        return $fight->id;
	}

    /**
     * Вступление в групповой бой
     *
     * @param int $fightId
     * @param int $playerId
     * @param bool $force
     * @return array
     */
	public static function joinFight($fightId, $playerId = 0, $setSide = false, $setFraction = false)
    {
		if (Page::checkTransaction("gf_start_" . $fightId, false)) {
			Page::addAlert(FightLang::ERROR, FightLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			Std::redirect('/alley/', true);
		}

		$result = array('type' => 'fight', 'action' => 'join fight', 'params' => array('url' => '/fight/'));
		$startPlayerId = $playerId;
        if ($playerId == 0) {
			$player = self::$player;
            $player2 = self::$player2;
		} else {
			$player = new playerObject();
			$player->load($playerId);

            $player2 = new player2Object();
            $player2->load($player->id);

			$player->loadHP();
		}

		$fight = new fightObject();
		if ($fight->load($fightId)) {
            $fight->data = json_decode($fight->data, true);
            $fight->players = json_decode('{' . substr($fight->players, 1) . '}', true);
        } else {
			Std::redirect('/alley/', true);
		}

		if ($fight->type == "metro" || $fight->type == "level") {
            $transactionName = "gf_join_" . $player->level . "_" . $player->fraction . "_" . $fightId;
        } elseif ($fight->type == "flag") {
			$transactionName = "gf_join_" . $player->fraction . "_" . $fightId;
		} else {
			$transactionName = "gf_join_" . $fightId;
		}
		if ($startPlayerId == 0) {
			$alert = array("title" => FightLang::UNLUCKY, "text" => FightLang::JOINLOCK, "type" => ALERT_ERROR);
			Page::startTransaction($transactionName, false, 3, false, "/alley/", $alert);
		}

		if (in_array($fight->type, array('flag', 'clanwar', 'level', 'chaotic', 'metro'))) {
			$result['params']['url'] = '/alley/';
		} elseif ($fight->type == 'bank') {
            $result['params']['url'] = '/bank/';
        }

        switch ($fight->type) {
            case 'flag':
            case 'level':
            case 'test':
                $mySide = $player->fraction{0} == $fight->data['a']['f'] ? 'a' : 'd';
                break;

            case "metro":
                $mySide = $player->fraction{0} == $fight->data['a']['f'] ? 'a' : 'd';
                break;

            case 'bank':
                $mySide = 'a';
                break;

            case 'clanwar':
                $mySide = $player->clan == $fight->data['a']['cl'] ? 'a' : 'd';
                break;

            case 'chaotic':
                if ($fight->state == "created") {
                    $mySide = 'a';
                } else {
                    $mySide = $mySide = $fight->data['a']['c'] < $fight->data['d']['c'] ? 'a' : ($fight->data['a']['c'] > $fight->data['d']['c'] ? "d" :
                        (mt_rand(1, 2) == 1 ? "a" : "d"));
                }
                break;
        }

        $checkLevel = in_array($fight->type, array('flag', 'level', 'bank', 'chaotic', 'metro')) ? true : false;
		if ($fight->type == 'chaotic' && $fight->level == 0) {
			$checkLevel = false;
		}
		
		/*
		// костыль на 8 марта
		if ($fight->type == 'flag' && $player->sex == 'male') {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, "Сегодня только для девушек!", ALERT_ERROR);
			return $result;
		}
		*/
		if ($playerId == 0 && $fight->type == 'chaotic' && $fight->level > 0 && $_POST["force_join"] == false) {
			if (!in_array($_POST['price'], array('money', 'zub', 'huntbadge'))) {
				Page::addAlert(FightLang::ERROR, FightLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				Std::redirect('/alley/', true);
			}
			switch ($_POST['price']) {
				case 'money':
					$enough = (isset(self::$chaoticFightCost[$player->level]['m']) && $player->money >= self::$chaoticFightCost[$player->level]['m']) ? true : false;
					break;

				case 'zub':
					$zub = $player->getItemForUseByCode('war_zub');
					$enough = (isset(self::$chaoticFightCost[$player->level]['zub']) && (int) $zub['durability'] >= self::$chaoticFightCost[$player->level]['zub']) ? true : false;
					break;

				case 'huntbadge':
					$huntbadge = $player->getItemForUseByCode('huntclub_badge');
					$enough = (isset(self::$chaoticFightCost[$player->level]['huntbadge']) && (int) $huntbadge['durability'] >= self::$chaoticFightCost[$player->level]['huntbadge']) ? true : false;
					break;

				default:
					$enough = false;
			}
			if ($enough == false) {
				$result['result'] = 0;
				Page::addAlert(FightLang::ERROR, FightLang::$errorJoinMoney, ALERT_ERROR);
				return $result;
			}
		}
		if ($player->isFreeFor('join fight') == false) {
			$result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinBusy, ALERT_ERROR);
			return $result;
        } elseif ($player2->travma) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinInjury, ALERT_ERROR);
			return $result;
        } elseif ($fight->state == 'finishing') {
            $result['result'] = 0;
            Page::addAlert(FightLang::ERROR, FightLang::ERROR_JOIN_FINISHING, ALERT_ERROR);
			Std::redirect('/alley/', true);
		} elseif (($fight->state == 'started' || $fight->state == 'finishing') && ($_POST["force_join"] == false || self::$sql->getValue("SELECT count(*) FROM inventory WHERE player = " . self::$player->id . " AND code = 'docs_naemnik'") == 0)) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::ERROR_JOIN_STARTED, ALERT_ERROR);
			return $result;
		} elseif ($player->hp < $player->maxhp * 0.5) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinHealth, ALERT_ERROR);
			return $result;
		} elseif (($fight->state == 'created' && $fight->{$mySide.'c'} >= $fight->{$mySide.'m'}) || ($fight->state == 'started' && $fight->{$mySide.'c'} >= $fight->data[$mySide]['m3'])) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinSideIsFull, ALERT_ERROR);
			return $result;
		} elseif ($checkLevel && $fight->data['l1'] > $player->level) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, Lang::renderText(FightLang::$errorJoinMinLevel, array('level' => $fight->data['l1'])), ALERT_ERROR);
			return $result;
		} elseif ($checkLevel && $fight->data['l2'] < $player->level) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, Lang::renderText(FightLang::$errorJoinMaxLevel, array('level' => $fight->data['l2'])), ALERT_ERROR);
			return $result;
        } elseif ($fight->type == 'level' && $_POST["force_join"] == false && ($player->money < self::$levelFightCost[$player->level]['m'] || ($player->ore + $player->honey) < self::$levelFightCost[$player->level]['o'])) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinMoney, ALERT_ERROR);
			return $result;
		}/* elseif ($fight->type == 'chaotic' && $fight->level > 0 && $_POST["force_join"] == false && $player->money < self::$chaoticFightCost[$player->level]['m']) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinMoney, ALERT_ERROR);
			return $result;
		}*/ elseif ($fight->type == 'chaotic' && $fight->level > 0 && self::$sql->getValue("SELECT count(*) FROM fightplayer fp JOIN fight f ON f.id = fp.fight
            WHERE f.dt > date_sub(now(), INTERVAL 1 DAY) AND f.type = 'chaotic' AND f.state = 'finished' AND fp.player=" . self::$player->id) >= 8) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			return $result;
		} elseif ($fight->type == 'bank' && $player->money < abs((int)$_POST['money'])) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinBribeNoMoney, ALERT_ERROR);
			return $result;
		} elseif ($fight->type == 'bank' && ($player->level - 4) * 100 > abs((int)$_POST['money'])) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::$errorJoinBribeTooSmall, ALERT_ERROR);
			return $result;
		} elseif ($fight->type == 'metro' && $player->fraction{0} != $fight->data['a']['f'] && $player->fraction{0} != $fight->data['d']['f']) {
            $result['result'] = 0;
			Page::addAlert(FightLang::ERROR, FightLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			return $result;
		} elseif ($fight->type == 'metro' && $fight->data["a"]["f"] == $player->fraction{0} &&
			self::$sql->getValue("SELECT count(*) FROM fightplayer fp JOIN fight f ON f.id = fp.fight
									WHERE f.dt > date_sub(now(), INTERVAL 1 DAY) AND f.type = 'metro' AND f.state = 'finished' AND MINUTE(start_dt) = " . ($player->fraction == 'resident' ? 20 : 40) . " AND fp.player=" . $player->id) >= 10) {
				$result['result'] = 0;
				Page::addAlert(FightLang::ERROR, FightLang::ERROR_ACTION_DENIED, ALERT_ERROR);
				return $result;
		} elseif (
            isset($fight->players[$player->id]) ||
            $fight->state == 'finished' ||
            ($fight->type == 'clanwar' && (($player->clan != $fight->data['a']['cl'] && $player->clan != $fight->data['d']['cl']) || $player->clan_status == 'recruit'))
        ) {
            Page::addAlert(FightLang::ERROR, FightLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			Std::redirect('/alley/', true);
		}

        //$fight->data['p'][] = $player->id;
        //$fight->data[$mySide]['c']++;

        $player2 = $player->exportForGroupFight();
        $player2['sd'] = $mySide;
		if ($fight->type == 'chaotic') {
			$player2['pr'] = $_POST['price'];
		}

        if ($_POST["force_join"] && self::$sql->getValue("SELECT count(*) FROM inventory WHERE player = " . self::$player->id . " AND code = 'docs_naemnik'") > 0) {
            $licence = $player->loadItemByCode("docs_naemnik");
            $licence->useItem();
            Page::sendLog($player->id, 'item_autoused', array('name' => $licence->name), 1);

            $player->state = 'fight';
            $player->stateparam = $fight->id;
            $player->timer = time() + 7200;
            $player->save($player->id, array(playerObject::$TIMER, playerObject::$STATE, playerObject::$STATEPARAM));

            self::$sql->query("UPDATE fight SET " . $mySide . "c = " . $mySide . "c + 1 WHERE id = " . $fight->id);
            $action = addslashes(json_encode(array("strike" => array(0, array(5, (int)$player->id)))));
            $player2['fj'] = 1;
            $player2['items'] = $player->exportGroupFightItems();
            self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, action, side)
                VALUES (" . $fight->id . ", " . $player->id . ", '" . addslashes(json_encode($player2)) . "', 1, '" . $action . "', '" . $player2["sd"] . "')");
			
            // автоматическое добавление NPC при вмешаивании в бои за метро
            if ($fight->type == "metro" && $fight->data["d"]["f"] == "npc") {
                Std::loadModule("Npc");
                $npc = NpcGenerator::get($fight->data["d"]["f2"], $player2, array());
                $npc = $npc->exportForFight();
                $npc['sd'] = 'd';
                $action = addslashes(json_encode(array("strike" => array(0, array(5, (int)$npc["id"])))));

                self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, action, side)
                    VALUES (" . $fight->id . ", " . $npc["id"] . ", '" . addslashes(json_encode($npc)) . "', 1, '" . $action . "', '" . $npc['sd'] . "')");

                self::$sql->query("UPDATE fight SET dc = dc + 1 WHERE id = " . $fight->id);
            }

			Page::$cache->delete("gf_playersinfight_" . $fight->id);

			// CHAT вмешались в бой
			$key = self::signed($player->id);
			$userInfo = array();
			$userInfo[$key] = array();
			$userInfo[$key]["fight_side"] = $player2["sd"];
			$userInfo[$key]["fight_id"] = $fight->id;
			$userInfo[$key]["fight_state"] = $fight->state;
			$userInfo[$key]["fight_dt"] = strtotime($fight->start_dt);
			Page::chatUpdateInfo($userInfo);

			$cachePlayer = self::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["fight_side"] = $player2["sd"];
				$cachePlayer["fight_id"] = $fight->id;
				$cachePlayer["fight_state"] = $fight->state;
				$cachePlayer["fight_dt"] = strtotime($fight->start_dt);
				self::$cache->set("user_chat_" . $key, $cachePlayer);
			}

            Std::redirect("/fight/" . $fight->id . "/");
        
        // вступление в бой
        } else {
			if ($fight->type == 'bank') {
				$bribe = abs((int) $_POST['money']);
				//$player2['bb'] = $bribe;
			} else {
				$sideCount = self::$sql->getValue("SELECT " . $mySide . "c FROM fight WHERE id = " . $fight->id);
				if ($sideCount < $fight->{$mySide . "m"}) {
					self::$sql->query("UPDATE fight SET " . $mySide . "c = " . $mySide . "c + 1 WHERE id = " . $fight->id);
					self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, side)
                        VALUES (" . $fight->id . ", " . $player->id . ", '" . addslashes(json_encode($player2)) . "', 1, '" . $player2["sd"] . "')");

					Page::$cache->delete("gf_playersinfight_" . $fight->id);

					// CHAT записались в бой
					$key = self::signed($player->id);
					$userInfo = array();
					$userInfo[$key] = array();
					$userInfo[$key]["fight_side"] = $player2["sd"];
					$userInfo[$key]["fight_id"] = $fight->id;
					$userInfo[$key]["fight_state"] = $fight->state;
					$userInfo[$key]["fight_dt"] = strtotime($fight->start_dt);
					Page::chatUpdateInfo($userInfo);

					$cachePlayer = self::$cache->get("user_chat_" . $key);
					if ($cachePlayer) {
						$cachePlayer["fight_side"] = $player2["sd"];
						$cachePlayer["fight_id"] = $fight->id;
						$cachePlayer["fight_state"] = $fight->state;
						$cachePlayer["fight_dt"] = strtotime($fight->start_dt);
						self::$cache->set("user_chat_" . $key, $cachePlayer);
					}
				} else {
					$result['result'] = 0;
					Page::addAlert(FightLang::$error, FightLang::$errorFightIsFull, ALERT_ERROR);
					return $result;
				}
			}

            if ($fight->type != 'bank') {
                $player->state = 'frozen';
                $player->stateparam = json_encode(array(
                    'action' => 'redirect',
                    'url' => '/fight/',
                ));
                $player->timer = strtotime($fight->dt) + mt_rand(1, 3);
            }

            if ($fight->type == 'level') {
                $priceMoney = self::$levelFightCost[$player->level]['m'];
                if ($player->ore >= self::$levelFightCost[$player->level]['o']) {
                    $priceOre = self::$levelFightCost[$player->level]['o'];
                    $priceHoney = 0;
                } else {
                    $priceOre = $player->ore;
                    $priceHoney = self::$levelFightCost[$player->level]['o'] - $priceOre;
                    $priceHoneyOre = self::$levelFightCost[$player->level]['o'] - $priceOre; // для логов
                }

                if ($priceHoney > 0) {
                    $reason	= 'alley levelfight $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre . ' + *' . $priceMoney;
                    $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
                }
                if ($priceHoney == 0 || $takeResult[0] == 'OK') {
                    $player->money -= $priceMoney;
                    $player->ore -= $priceOre;
                    $player->honey -= $priceHoney;

                    $log['m'] = $priceMoney;
                    $log['o'] = $priceOre;
                    $log['h'] = $priceHoney;

                    $player->save($player->id, array(playerObject::$TIMER, playerObject::$STATE, playerObject::$STATEPARAM, playerObject::$MONEY, playerObject::$ORE, playerObject::$HONEY));

                    $log['mbckp'] = array('m' => (int)$player->money, 'o' => (int)$player->ore, 'h' => (int)$player->honey);
                    $log['op'] = 'dpst';
                    Page::sendLog($player->id, 'gfdpst', $log, 1);
                } else {
                    Page::addAlert(FightLang::$errorNoHoney, FightLang::$errorNoHoneyText, ALERT_ERROR);
                }
            } elseif ($fight->type == 'chaotic') {
				if ($startPlayerId == 0) {
					$log = array('op' => 'dpst');
					switch ($_POST['price']) {
						case 'money':
							$priceMoney = self::$chaoticFightCost[$player->level]['m'];
							$log['m'] = $priceMoney;
							$player->money -= $priceMoney;
							break;

						case 'zub':
							$amount = self::$chaoticFightCost[$player->level]['zub'];
							$log['zub'] = $amount;
							$player->useItemFast($zub, $amount);
							break;

						case 'huntbadge':
							$amount = self::$chaoticFightCost[$player->level]['huntbadge'];
							$log['badge'] = $amount;
							$player->useItemFast($huntbadge, $amount);
							break;

						default:
							$enough = false;
					}
					$player->save($player->id, array(playerObject::$TIMER, playerObject::$STATE, playerObject::$STATEPARAM, playerObject::$MONEY));
					$log['mbckp'] = array('m' => (int)$player->money, 'o' => (int)$player->ore, 'h' => (int)$player->honey);
					Page::sendLog($player->id, 'gfdpst', $log, 1);
				}
            } elseif ($fight->type == 'bank') {
                $player->money -= $bribe;
                $player->save($player->id, array(playerObject::$MONEY));

                self::$player2->bankbribe = $bribe;
                self::$player2->save(self::$player2->id, array(player2Object::$BANKBRIBE));

                $log['mbckp'] = array('m' => (int)$player->money, 'o' => (int)$player->ore, 'h' => (int)$player->honey);
                $log['m'] = $bribe;
                Page::sendLog($player->id, 'bfdpst', $log, 1);
            } else {
                $player->save($player->id, array(playerObject::$TIMER, playerObject::$STATE, playerObject::$STATEPARAM));
            }
            if ($fight->type == 'bank') {
                Page::addAlert(FightLang::$alertBribeOk, FightLang::$alertBribeOkText);
            } else {
                Page::addAlert(FightLang::$alertPrepareToFight, FightLang::$alertPrepareToFightText);
            }
        }

        Page::endTransaction($transactionName);
        Page::$cache->delete("gf_playersinfight_" . $fight->id);

        $result['result'] = 1;
		return $result;
	}

    /**
     * Получение списка игроков в бою
     *
     * @param int $fightId
     * @param array $players
     * @param array $playersId
     */
    public static function getPlayersInFight($fightId, &$playersArray, &$playersIdArray, $alive = false, $forceNoCache = false)
    {
        $playersArray = array();
        $playersIdArray = array();

        $sql = "SELECT player, data, action, action2, alive, unix_timestamp(actiontime) actiontime 
            FROM fightplayer WHERE fight = " . $fightId . ($alive ? " AND alive = 1" : "") . "";
        if ($forceNoCache) {
            Page::$cache->delete("gf_playersinfight_" . $fightId);
            Page::$cache->delete("gf_playersinfight_alive_" . $fightId);
        }
        $players = Page::getData("gf_playersinfight_" . ($alive ? "alive_" : "") . $fightId, $sql, "recordset", 60);
        if (!is_array($players)) {
            $players = array();
        }
        Std::sortRecordSetByField($players, "actiontime", 1);

        if ($players) {
            foreach ($players as $player) {
                $action = $player['action'] == "" ? "" : json_decode($player['action'], true);
                $action2 = $player['action2'] == "" ? "" : json_decode($player['action2'], true);
                $alive = $player["alive"];
                $player = json_decode($player['data'], true);
                $player["action"] = $action;
                $player["action2"] = $action2;
                $player["alive"] = $alive;
                $playersArray[$player['id']] = $player;
                $playersIdArray[] = $player['id'];
            }
        } else {
            $playersArray = false;
            $playersIdArray = false;
        }
    }

    /**
     * Сохранение данных игроков в бое
     *
     * @param int $fightId
     * @param array $playersArray
     */
    private static function savePlayersInFight($fightId, &$playersArray)
    {
        if ($playersArray) {
            foreach ($playersArray as $playerId => $player) {
                $action = isset($player["action"]) && $player["action"] != "" ? addslashes(json_encode($player['action'])) : "";
                unset($player['action']);
                $action2 = isset($player["action2"]) && $player["action2"] != "" ? addslashes(json_encode($player['action2'])) : "";
                unset($player['action2']);
                $alive = (int)$player["alive"];
                unset($player["alive"]);
                $side = $player["sd"];
                $data = addslashes(json_encode($player));
                self::$sql->query("UPDATE fightplayer SET data='" . $data . "', action = '" . $action . "', action2 = '" . $action2 . "',
                    alive = " . $alive . ", side = '" . $side . "' WHERE fight = " . $fightId . " AND player = ". $playerId);
            }
			// сброс кеша
			Page::$cache->delete("gf_playersinfight_" . $fightId);
			Page::$cache->delete("gf_playersinfight_alive_" . $fightId);
			// восстановление кеша
			$sql1 = "SELECT player, data, action, action2, alive, actiontime FROM fightplayer
				WHERE fight = " . $fightId . "";
			$sql2 = "SELECT player, data, action, action2, alive, actiontime FROM fightplayer
				WHERE fight = " . $fightId . " AND alive = 1";
			Page::getData("gf_playersinfight_" . $fightId, $sql1, "recordset", 60);
			Page::getData("gf_playersinfight_alive_" . $fightId, $sql2, "recordset", 60);
        }
    }

    /**
     * Запуск боя (вызывается из крона)
     *
     * @param int $id
     * @return bool
     */
	public static function startFight($id)
    {
        Page::startTransaction("gf_start_" . $id, false, 10, true);

		Std::loadModule('Page');
		Std::loadMetaObjectClass('fight');
        Std::loadMetaObjectClass('player');

        $players1 = array();
        $players1Id = array();

		$fight = new fightObject();
		if ($fight->load($id)) {
            $fight->state = 'starting';
            $fight->save($fight->id, array(fightObject::$STATE));
            $fight->data = json_decode($fight->data, true);
            self::getPlayersInFight($fight->id, $players1, $players1Id, false, true);
        } else {
			return false;
		}

        // отмена хаотичного боя, если не набралось 10 человек
        if ($fight->type == "chaotic" && /*!DEV_SERVER &&*/ $fight->level > 0 && sizeof($players1) < 10) {
            if ($players1Id) {
				$money = self::$chaoticFightCost[$fight->level]['m'];
				Std::loadMetaObjectClass('standard_item');
				$returnMoney = array();
				$secondUpdate = array();
				foreach ($players1 as $key => &$p) {
					switch ($p['pr']) {
						case 'zub':
							$secondUpdate[] = $p['id'];
							if (!isset($zub)) {
								$zub = new standard_itemObject();
								$zub->loadByCode('war_zub');
							}
							$zub->makeExampleOrAddDurability($p['id'], self::$chaoticFightCost[$fight->level]['zub']);
							break;

						case 'huntbadge':
							$secondUpdate[] = $p['id'];
							if (!isset($huntbadge)) {
								$huntbadge = new standard_itemObject();
								$huntbadge->loadByCode('huntclub_badge');
							}
							echo gettype($huntbadge) . PHP_EOL;
							echo self::$chaoticFightCost[$fight->level]['huntbadge'] . PHP_EOL;
							$huntbadge->makeExampleOrAddDurability($p['id'], self::$chaoticFightCost[$fight->level]['huntbadge']);
							break;

						default:
							$returnMoney[] = $p['id'];
					}
				}
				if (count($returnMoney)) {
					self::$sql->query("UPDATE player SET state = '', timer=0, stateparam='', money = money + " . $money . " WHERE id in (" . implode(", ", $returnMoney) . ")");
				}
				if (count($secondUpdate)) {
					self::$sql->query("UPDATE player SET state = '', timer=0, stateparam='' WHERE id in (" . implode(", ", $secondUpdate) . ")");
				}
                
                self::$sql->query("DELETE FROM fightplayer WHERE fight = " . $fight->id . " AND player IN (" . implode(", ", $players1Id) . ")");

				$userInfo = array();
                foreach ($players1 as $key => &$player) {
					$playerId = $player['id'];
					// CHAT бой завершен
					$key = self::signed($playerId);
					$userInfo[$key] = array();
					$userInfo[$key]["fight_side"] = null;
					$userInfo[$key]["fight_id"] = null;
					$userInfo[$key]["fight_state"] = null;
					$userInfo[$key]["fight_dt"] = null;

					$cachePlayer = self::$cache->get("user_chat_" . $key);
					if ($cachePlayer) {
						$cachePlayer["fight_side"] = null;
						$cachePlayer["fight_id"] = null;
						$cachePlayer["fight_state"] = null;
						$cachePlayer["fight_dt"] = null;
						self::$cache->set("user_chat_" . $key, $cachePlayer);
					}

					$playerMoney = self::$sql->getRecord("SELECT money, ore, honey FROM player WHERE id = " . $playerId);
                    $mbckp = array('m' => $playerMoney['money'], 'o' => $playerMoney['ore'], 'h' => $playerMoney['honey']);
					$log = array('r' => 1, 'mbckp' => $mbckp);
					switch ($player['pr']) {
						case 'zub':
							$log['zub'] = self::$chaoticFightCost[$fight->level]['zub'];
							break;

						case 'huntbadge':
							$log['badge'] = self::$chaoticFightCost[$fight->level]['huntbadge'];
							break;

						default:
							$log['m'] = $money;
					}
                    Page::sendLog($playerId, 'gchfcnld', $log);
                }
				Page::chatUpdateInfo($userInfo);
            }

            $fight->state = "finished";
            $fight->save($fight->id, array(fightObject::$STATE));
            return;
        }

        // установка state у игроков, блокировака восполнения жизней
        if ($fight->type != 'bank' && is_array($players1Id) && sizeof($players1Id) > 0) {
			self::$sql->query("UPDATE player SET state = 'fight', timer = " . (time() + 7200) . ", stateparam = " . $fight->id . " WHERE id IN (" . implode(', ', $players1Id) . ")");
        }

        $players2 = array();
        $players2Id = array();

        // если клановый бой, то применяем будильники
        if ($fight->type == 'clanwar') {
			$sql = "SELECT p.id, p.clan, p.accesslevel FROM player p WHERE (p.clan=" . $fight->data['a']['cl'] . " OR p.clan=" . $fight->data['d']['cl'] . ") AND
                (SELECT count(*) FROM inventory WHERE player=p.id AND code='clan_alarmclock') > 0 " .
                (sizeof($players1Id) > 0 && $players1Id[0] ? " AND p.id NOT IN (" . implode(',', $players1Id) . ")" : "") . " ORDER BY rand()";
			//echo $sql;
            $alarmPlayers = self::$sql->getRecordSet($sql);
            if ($alarmPlayers) {
                foreach ($alarmPlayers as $player) {
                    if ($player["accesslevel"] < 0) {
                        continue;
                    }
                    $side = $player['clan'] == $fight->data['a']['cl'] ? 'a' : 'd';
                    if ($fight->data[$side]['c'] < $fight->data[$side]['m']) {
                        $p = new playerObject();
                        $p->load($player['id']);
                        //$p->loadHP();

                        if ($p->isFreeFor('join fight') == false) { // || $p->hp < $p->maxhp * 0.5) {
                            continue;
                        }
						$p->setHP($p->maxhp);

                        $fight->data[$side]['c']++;

                        $items = $p->exportGroupFightItems();
                        $p = $p->exportForGroupFight();
                        $p["items"] = $items;
                        $p['sd'] = $side;
                        $players1[$p['id']] = $p;
                        $players1Id[] = $p["id"];

                        self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, action, side)
                            VALUES (" . $fight->id . ", " . $p["id"] . ", '" . addslashes(json_encode($p)) . "', 1, '', '" . $p['sd'] . "')");

                        Page::sendLog($player['id'], 'item_autoused', array('code' => 'clan_alarmclock', 'name' => FightLang::ALARM_CLOCK), 0);

                        // удаление у игрока будильника
                        if (self::$sql->getValue("SELECT durability FROM inventory WHERE player=" . $player['id'] . " AND code='clan_alarmclock'") > 1) {
                            self::$sql->query("UPDATE inventory SET durability=durability-1, maxdurability=maxdurability-1 WHERE player=" . $player['id'] . " AND code='clan_alarmclock'");
                        } else {
                            self::$sql->query("DELETE FROM inventory WHERE player=" . $player['id'] . " AND code='clan_alarmclock'");
                        }
                    }
                }
                self::$sql->query("UPDATE player SET state = 'fight', timer = " . (time() + 7200) . ", stateparam = " . $fight->id . " WHERE id IN (" . implode(', ', $players1Id) . ")");
            }
        }
		
		// если в бой никто не записался, то завершаем его
        if ($players1 == false && $fight->type != "bank") {
            $fight->state = "finished";
            $fight->results = json_encode(array("w" => ""));
            $fight->save($fight->id, array(fightObject::$STATE, fightObject::$RESULTS));
            return;
        }

        // сортировка по статам (по взяткам)
        if ($fight->type == 'bank') { // сортировка по взяткам
            $fight->data['pzbb'] = self::$sql->getValue("SELECT sum(p2.bankbribe) FROM player2 p2
                LEFT JOIN player p ON p.id=p2.player WHERE p.level=" . $fight->level . " AND p2.bankbribe>0");

            $curMaxLevel = CacheManager::get('value_maxlevel');
            $curBankFightMaxLevel = CacheManager::get('value_bankfightmaxlevel');

            $bankRobbers = self::$sql->getRecordSet("SELECT p.id, p2.bankbribe bb FROM player2 p2
                LEFT JOIN player p ON p.id = p2.player
                WHERE (p.level = " . $fight->level . " " . ($curBankFightMaxLevel < $curMaxLevel && (int)$fight->level == $curBankFightMaxLevel ? " OR p.level>$curBankFightMaxLevel " : '') . ")
                    AND p2.bankbribe > 0 AND p2.travmadt < now()
                ORDER BY p2.bankbribe DESC");
        } else { // сортировка по статам
            $playerStats = array();
            foreach ($players1 as $playerId => $playerData) {
                $playerStats[$playerId] = array((int)$playerData['ss'], $playerId);
            }
            asort($playerStats);
            $playerStats = array_reverse($playerStats);
        }

        $fight->data['a']['c'] = $fight->data['d']['c'] = 0;

        // если битва за флаг, то владелец флага остается независимо от своих характеристик
        if ($fight->type == 'flag') {
            $playerId = $fight->data['f'];
            $playerData = $players1[$playerId];
            $fight->data[$playerData['sd']]['c'] = 1;
            $player = new playerObject();
            $player->load($playerId);
            $items = $player->exportGroupFightItems();
            $player = $player->exportForGroupFight();
            $player['items'] = $items;
            $player['dg'] = $player['ks'] = $player['kd'] = $player['xp'] = 0;
            $player['sd'] = $playerData['sd'];
            $player["alive"] = 1;
            $players2[$playerId] = $player;
            $players2Id[] = $playerId;
        }

        if ($fight->type == 'bank') {
            if ($bankRobbers) {
                foreach ($bankRobbers as $robber) {
                    $player = new playerObject();
                    $player->load($robber['id']);
                    if ($player->isFreeFor('join fight') && $player->loadHP() >= $player->maxhp * 0.75) {
                        $fight->data['a']['c']++;
                        $items = $player->exportGroupFightItems();
                        $player = $player->exportForGroupFight();
                        $player['items'] = $items;
                        $player['dg'] = $player['ks'] = $player['kd'] = $player['xp'] = 0;
                        $player['sd'] = 'a';
                        $player['bb'] = $robber['bb'];

                        self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, action, side)
                            VALUES (" . $fight->id . ", " . $player["id"] . ", '" . addslashes(json_encode($player)) . "', 1, '', '" . $player["sd"] . "')");

                        $players2[$robber['id']] = $player;
                        $players2Id[] = $robber['id'];
                    }
                    if ($fight->data['a']['c'] >= $fight->data['a']['m2']) {
                        break;
                    }
                }
                self::$sql->query("UPDATE player SET state = 'fight', timer = " . (time() + 7200) . ", stateparam = " . $fight->id . " WHERE id IN (" . implode(', ', $players2Id) . ")");
            }
        } else {
            $nextChaoticSide = mt_rand(1,2) == 1 ? "a" : "d";
            $outsidersIds = array();
            foreach ($playerStats as $i => $playerArr) {
                $playerId = $playerArr[1];
                if ($fight->type == 'flag' && $playerId == (int)$fight->data['f']) {
                    continue;
                }
                $playerData = $players1[$playerId];
                if ($fight->type != "chaotic") {
                    if ($fight->data[$playerData['sd']]['c'] >= $fight->data[$playerData['sd']]['m2']) {
                        $outsidersIds[] = $playerId;
                        Page::sendLog($playerId, 'gfout', array('t' => $fight->type));
                        if ($fight->type == 'level') {
                            $player = new playerObject();
                            $player->load($playerId);
                            $player->money += self::$levelFightCost[$player->level]['m'];
                            $player->ore += self::$levelFightCost[$player->level]['o'];
                            $player->save($player->id, array(playerObject::$MONEY, playerObject::$ORE));

                            $log['m'] = (int)self::$levelFightCost[$player->level]['m'];
                            $log['o'] = (int)self::$levelFightCost[$player->level]['o'];
                            $log['mbckp'] = array('m' => (int)$player->money, 'o' => (int)$player->ore, 'h' => (int)$player->honey);
                            $log['op'] = 'rtn';
                            Page::sendLog($player->id, 'gfdpst', $log);
                        }
                        continue;
                    }
                }
                $player = new playerObject();
                $player->load($playerId);
                $items = $player->exportGroupFightItems();
                $player = $player->exportForGroupFight();
                $player['items'] = $items;
                $player['dg'] = $player['ks'] = $player['kd'] = $player['xp'] = 0;
                if ($fight->type == "chaotic") {
                    $fight->data[$nextChaoticSide]['c']++;
                    $player['sd'] = $nextChaoticSide;
                    $nextChaoticSide = $nextChaoticSide == "a" ? "d" : "a";
                } else {
                    $player['sd'] = $playerData['sd'];
                    $fight->data[$playerData['sd']]['c']++;
                }
                $player["alive"] = 1;
                if ($fight->type == 'bank') {
                    $player['bb'] = $playerData['bb'];
                }
                $players2[$playerId] = $player;
                $players2Id[] = $playerId;
            }
            if (count($outsidersIds)) {
                self::$sql->query("UPDATE player SET state='', timer=0, stateparam='' WHERE id in (" . implode(", ", $outsidersIds) . ")");
                self::$sql->query("DELETE FROM fightplayer WHERE fight = " . $fight->id . " AND player IN (" . implode(", ", $outsidersIds) . ")");
            }
            self::savePlayersInFight($fight->id, $players2);
        }

        // генерация охранников для боя за банк
        if ($fight->type == 'bank') {
            Std::loadModule('Npc');
            $maxSs = 0;
            $bossPlayerId = 0;
            foreach ($players2 as $playerId => $player) {
                if ($player['ss'] > $maxSs) {
                    $maxSs = $player['ss'];
                    $bossPlayerId = $playerId;
                }
            }
            foreach ($players2 as $playerId => $player) {
                if ($playerId == $bossPlayerId) {
                    $params = array('boss' => true);
                } else {
                    $params = array('boss' => false);
                }
                $npc = NpcGenerator::get(NPC_AGENTSMITH, $player, $params);
                $npc = $npc->exportForFight();
                $npc['sd'] = 'd';
                $players2[NPC_ID + (int)$playerId] = $npc;

                self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, action, side)
                    VALUES (" . $fight->id . ", " . $npc["id"] . ", '" . addslashes(json_encode($npc)) . "', 1, '', '" . $npc['sd'] . "')");

                $fight->data['d']['c']++;
            }
        }

        // генерация NPC для боя за метро
        if ($fight->type == 'metro' && $fight->data["d"]["f"] == "npc") {
            Std::loadModule('Npc');
            $maxSs = 0;
            $bossPlayerId = 0;

            foreach ($players2 as $playerId => $player) {
                $npc = NpcGenerator::get($fight->data["d"]["f2"], $player, array());
                $npc = $npc->exportForFight();
                $npc['sd'] = 'd';
                $players2[NPC_ID + (int)$playerId] = $npc;

                self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, action, side)
                    VALUES (" . $fight->id . ", " . $npc["id"] . ", '" . addslashes(json_encode($npc)) . "', 1, '', '" . $npc['sd'] . "')");

                $fight->data['d']['c']++;
            }
        }

        $fight->ac = $fight->data['a']['c'];
        $fight->dc = $fight->data['d']['c'];
        $fight->data = json_encode($fight->data);
		$fight->state = 'started';
		$fight->dt = date('Y-m-d H:i:s', time() + 30);
		$fight->save($fight->id, array(fightObject::$STATE, fightObject::$DT, fightObject::$DATA, fightObject::$AC, fightObject::$DC));

        //self::startFightChat($id);

		$userInfo = array();
		foreach ($players2 as $playerId => $player) {
			$key = self::signed($playerId);////self::signed($player["player"]);
			$userInfo[$key] = array();
			$userInfo[$key]["fight_side"] = $player["sd"];////$player["side"];
			$userInfo[$key]["fight_id"] = $fight->id;
			$userInfo[$key]["fight_state"] = "started";

			$cachePlayer = self::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["fight_side"] = $player["sd"];////$player["side"];
				$cachePlayer["fight_id"] = $fight->id;
				$cachePlayer["fight_state"] = "started";
				self::$cache->set("user_chat_" . $key, $cachePlayer);
			}
		}
		Page::chatUpdateInfo($userInfo);

		Page::endTransaction("gf_start_" . $fight->id, false);

		return true;
	}

/**
 * Запуск боевого чата
 *
 * @param int $fightId

private static function startFightChat($fightId)
{
    Std::loadMetaObjectClass('chatlog');
    $chatlog = new chatlogObject();
    $chatlog->type = $channel;
    $chatlog->text = htmlspecialchars(ChatLang::$messageGroupFightChatActive);
    $chatlog->time = time();
    $chatlog->player_from = 0;
    $chatlog->player_from_nickname = 'Notifier';
    $chatlog->battle_to = $fightId;
    $chatlog->type = 'battle_resident';
    $chatlog->save();
    $chatlog = new chatlogObject();
    $chatlog->type = $channel;
    $chatlog->text = htmlspecialchars(ChatLang::$messageGroupFightChatActive);
    $chatlog->time = time();
    $chatlog->player_from = 0;
    $chatlog->player_from_nickname = 'Notifier';
    $chatlog->battle_to = $fightId;
    $chatlog->type = 'battle_arrived';
    $chatlog->save();
}
*/

    /**
     * Удар
     *
     * @param int $target
     * @return array
     */
	public static function attack($targetId)
    {
		$result = array('type' => 'fight', 'action' => 'attack', 'params' => array('url' => '/fight/'));

        $actions = array('attack' => 1, 'defence' => 2, 'useitem' => 3, 'rupor' => 9);
        $actionType = isset($actions[$_POST['action']]) ? $actions[$_POST['action']] : 1;

        $action2sql = "";
        $ok = true;
        switch ($actionType) {
            case 1: // атака
            case 2: // защита
                $action = array("strike" => array($actionType, (int)$targetId));
                break;

            case 3: // использование предметов
                $action = array("item" => array($actionType, (int)$targetId));
                break;

            case 9: // рупор
                $rupor = self::$sql->getRecord("SELECT * FROM inventory WHERE player = " . self::$player->id . " AND code = 'fight_rupor'");
                if ($rupor) {
                    Std::loadMetaObjectClass("inventory");
                    $rup = new inventoryObject();
                    $rup->init($rupor);
                    $rup->useWithNoEffect();
                    $action = array("rupor" => Std::cleanString(htmlspecialchars($_POST["rupor"])));
                    $action2sql = "2";
                } else {
                    $ok = false;
                }
                break;
        }

        if ($ok) {
            $action = addslashes(json_encode($action));
            self::$sql->query("UPDATE fightplayer SET action" . $action2sql . " = '" . $action . "', actiontime = now()
                WHERE fight = " . self::$fight->id . " AND player = " . self::$player->id . " AND (action" . $action2sql . " = '' OR locate('0,[5,', action" . $action2sql . ") = 0)");
        }

		$result['result'] = 1;
		return $result;
	}

    /**
     * Убийство игрока
     *
     * @param array $players
     * @param int $playerId
     * @param int $targetId
     * @param array $logs2
     * @param object $fight
     * @param string $enemySide
     */
    private static function playerDie(&$players, $playerId, $targetId, &$logs2, &$fight, $enemySide)
    {
        $logs2[] = array(0, array(1, $playerId, (int)$targetId));
        $fight->data[$enemySide]['k']++;
		$fight->data = json_encode($fight->data);
		$fight->save($fight->id, array(fightObject::$DATA));
		$fight->data = json_decode($fight->data, true);
        $players[$targetId]['kd'] = 1;
        $players[$targetId]['hp'] = 0;
		self::$killedNow[] = $targetId;
//$players[$targetId]["alive"] = 0;
        // передача флага
        if ($fight->data['f'] == $targetId || $fight->results['f'] == $targetId) {
            $fight->results['f'] = $playerId;
            $logs2[] = array(0, array(2, $playerId, (int)$targetId));
        }

        $players[$playerId]['ks']++;

        $difference = Page::getGroupLevel($players[$targetId]['lv']) - Page::getGroupLevel($players[$playerId]['lv']);
        if (isset(Page::$data['expfights'][$difference])) {
            $exp = Page::$data['expfights'][$difference];
        } else {
            if ($difference > max(array_keys(Page::$data['expfights']))) {
                $exp = Page::$data['expfights'][max(array_keys(Page::$data['expfights']))];
            } else if ($difference < min(array_keys(Page::$data['expfights']))) {
                $exp = Page::$data['expfights'][min(array_keys(Page::$data['expfights']))];
            }
        }

		if ($exp <= 0) {
			return;
		}
        $players[$playerId]['xp'] += $exp;

        if ($playerId < NPC_ID) {
            $p1 = new playerObject();
            $p1->load($playerId);
            $p1->increaseXP($exp);
            $p1->save($p1->id, array(playerObject::$EXP, playerObject::$LEVEL));
        }
    }

    /**
     * Рассчет хода боя (вызывается из крона)
     *
     * @param int $id
     * @return bool
     */
	public static function calcEndStep($id)
    {
        Page::startTransaction("gf_calc_step_" . $id, false, 60, true);

        Std::loadModule('Page');
		Std::loadMetaObjectClass('fight');
		Std::loadMetaObjectClass('duel');
        Std::loadMetaObjectClass('player');

        $players = array();
        $playersId = array();

        $fight = new fightObject();
		if ($fight->load($id)) {
            $fight->data = json_decode($fight->data, true);
            $fight->results = json_decode($fight->results, true);
            $fight->log = json_decode($fight->log, true);
            self::getPlayersInFight($fight->id, $players, $playersId, false, true);
        } else {
			return false;
		}

        // массивы для AI ботов
        $playersWithLowHp = array();
        $botsWithLowHp = array();

        $alivePlayers = 0;
		foreach ($players as $playerId => &$player) {
            if ($player["alive"] == 1) {
                $alivePlayers++;
                if ($player['action'] == "") {
                    $player["action"] = array("strike" => array(1, 0));
                }

                // заполнение массивов для AI ботов
                if ($fight->type == "bank") {
                    if ($playerId < NPC_ID) {
                        $playersWithLowHp[] = array("id" => (int)$playerId, "hp" => (int)$player["hp"]);
                    } else {
                        $botsWithLowHp[] = array("id" => (int)$playerId, "hp" => (int)$player["hp"]);
                    }
                }
            } else {
                $player["action"] = array("strike" => array(0, 0));
            }
        }

        // генерация ударов ботов (дописать)
        if ($fight->type == 'bank' || ($fight->type == "metro" && $fight->data["d"]["f"] == "npc")) {
            $aiBotAttackPercent = 90; //%, иначе защищать
            $aiBotAttackLikePreviousPercent = 50; //%, иначе выбрать случайную новую цель (кроме той, которую атакует предыдущий бот)
            $aiBotAttackLowHpPercent = 20; //%, иначе атаковать случайную новую цель (кроме той, которую атакует предыдущий бот)
            $aiBotDefendLowHpPercent = 50; //%, иначе защищать с минимальным здоровьем, иначе - защищать случайного

            $playersSide = "a";
            $botsSide = "d";

            Std::sortRecordSetByField($playersWithLowHp, "hp", 1);
            Std::sortRecordSetByField($botsWithLowHp, "hp", 1);

            $previousTarget = 0;

            foreach ($players as $playerId => &$player) {
                if ((int)$playerId < NPC_ID || (is_array($player["action"]) && $player["action"]["strike"][1][0] == 5)) {
                    continue;
                }
                if (mt_rand(1, 100) <= $aiBotAttackPercent) {
                    if ($previousTarget > 0 && mt_rand(1, 100) <= $aiBotAttackLikePreviousPercent) {
                        $player["action"]["strike"] = array(1, $previousTarget);
                    } else {
                        if (mt_rand(1, 100) <= $aiBotAttackLowHpPercent) {
                            $target = 0;
                            for ($i = 0; $i < sizeof($playersWithLowHp); $i++) {
                                if ($playersWithLowHp[$i]["id"] != $previousTarget && $player["alive"] == 1) {
                                    $target = $playersWithLowHp[0]["id"];
                                    break;
                                }
                            }
                            if (!$target) { // костыль на случай, когда остался только один противник
                                $target = $previousTarget;
                            }
                            $player["action"]["strike"] = array(1, $playersWithLowHp[0]["id"]);
                            $previousTarget = $target;
                        } else {
                            $randomPlayer = mt_rand(1, sizeof($playersWithLowHp) - 1);
                            $i = 0;
                            while (($playersWithLowHp[$randomPlayer]["id"] == $previousTarget || $playersWithLowHp[$randomPlayer]["alive"] == 0) && $i < sizeof($playersWithLowHp)) {
                                $randomPlayer = mt_rand(1, sizeof($playersWithLowHp) - 1);
                                $i++;
                            }
                            $player["action"]["strike"] = array(1, $playersWithLowHp[$randomPlayer]["id"]);
                            $previousTarget = $playersWithLowHp[$randomPlayer]["id"];
                        }
                    }
                } else {
                    if (mt_rand(1, 100) < $aiBotDefendLowHpPercent) {
                        for ($i = 0, $j = sizeof($botsWithLowHp); $i < $j; $i++) {
                            if ($botsWithLowHp[$i]["alive"] == 1) {
                                $player["action"]["strike"] = array(2, $botsWithLowHp[$i]["id"]);
                                break;
                            }
                        }
                    } else {
                        $randomBot = mt_rand(1, sizeof($botsWithLowHp) - 1);
                        $i = 0;
                        while ($botsWithLowHp[$randomBot]["alive"] == 0 && $i < sizeof($botsWithLowHp[$randomBot])) {
                            $randomBot = mt_rand(1, sizeof($botsWithLowHp) - 1);
                            $i++;
                        }
                        $player["action"]["strike"] = array(2, $botsWithLowHp[$randomBot]["id"]);
                    }
                }
            }
        }

        $logs = $logs2 = $logsPre = array();
        $attacks = array();
        $defences = array();

        // рупор
        foreach ($players as $playerId => &$player) {
            if (isset($player["action2"]["rupor"]) && $player["action2"]["rupor"] != "") { // рупор
                $logsPre[] = array(0, array(8, $playerId, $player["action2"]["rupor"]));
            }
        }

		self::$killedNow = array();

		// использовать предметы
        self::useItems($fight, $players, $logsPre, $logs2);

        foreach ($players as $playerId => &$player) {
            if ($player["alive"] == 1) {
                if (isset($player["action"]["item"])) {
                    $player["action"] = array(0, 0);
                } else {
                    $player["action"] = $player["action"]["strike"];
                }
            }
        }

        // составление списка защищаемых
        foreach ($players as $playerId => &$player) {
            // $action[0] - тип действия: 0 - пропуск, 1 - удар, 2 - защита союзника, 3 - использование предмета
            // $action[1] - id игрока (цели действия)

            // защита союзника
            if ($player["alive"] == 1) {
                if ($player["action"][0] == 2) {
                    if (!is_array($defences[$player["action"][1]])) {
                        $defences[$player["action"][1]] = array();
                    }
                    $defences[$player["action"][1]][] = array($playerId, 0);
                }
            }
        }

		foreach ($players as $playerId => &$player) {
            // $action[0] - тип действия: 0 - пропуск, 1 - удар, 2 - защита союзника, 3 - использование предмета
            // $action[1] - id игрока (цели действия)

            if ($player["action"][0] == 0 && is_array($player["action"][1])) {
                if ($player["action"][1][0] == 5) { // сообщение о вмешательстве в бой
                    $logs2[] = $player["action"];
                }
                continue;
            }

            $enemySide = $player['sd'] == 'a' ? 'd' : 'a';
            // выбор случайного противника для удара
            if ($player["action"][0] == 1 && ((int)$player["action"][1] == 0 || (($players[(int)$player["action"][1]]["kd"] == 1 || $players[(int)$player["action"][1]]["hp"] == 0) && !in_array((int)$player["action"][1], self::$killedNow)))) {
                shuffle($playersId);
                for ($i = 0, $j = sizeof($playersId); $i < $j; $i++) {
                    $target = $playersId[$i];
                    if ($players[$target]["sd"] == $enemySide && $players[$target]["alive"] == 1) {
                        break;
                    }
                }
                $player["action"][1] = $players[$target]['id'];

                // костыль на случай, когда в бою один участник
                if ($player["action"][1] == $playerId) {
                    $player["action"][1] = 0;
                }
            }

            // защита союзника
            if ($player["action"][0] == 2) {
                $player["action"] = "";
                continue;

            // использование предметов
            } elseif ($player["action"][0] == 3) {
                $player["action"] = "";
                continue;

            // удар по противнику
            } elseif ($player["action"][0] == 1) {
                $targetId = 0;
                // определение цели (с учетом защиты)
                if (isset($defences[$player["action"][1]])) {
                    foreach ($defences[$player["action"][1]] as &$defence) {
                        if ($defence[1] == 0 && $players[$defence[0]]['hp'] > 0) {
                            $logs[] = array(0, array(4, (int)$defence[0], (int)$player["action"][1]));
                            $targetId = $defence[0];
                            $defence[1] = 1;
                            break;
                        }
                    }
                }

                if ($targetId == 0) {
                    $targetId = $player["action"][1];
                }
                // костыль на случай, когда в бою всего 1 участник
                if ($targetId == 0) {
                    continue;
                }

                if ($players[$playerId]['sd'] == $players[$targetId]['sd']) {
                    continue;
                }

                if (!isset($players[$targetId])) {
                    continue;
                }

				if (($players[$targetId]["kd"] == 1 || $players[$targetId]["hp"] == 0) && !in_array($targetId, self::$killedNow)) {
                    continue;
                }

                // влияение одновременных ударов
                if (isset($attacks[$targetId])) {
                    $attacks[$targetId]++;
                } else {
                    $attacks[$targetId] = 0;
                }

                $damaged = array('player' => 0, 'pet' => 0);
                $damage = Fight::makeStrike($players[$playerId], $players[$targetId], $attacks[$targetId]);
                // $damage[0] - тип удара: 0 - промах, 1 - удар, 2 - крит
                // $damage[1] - урон
                $log = array((int)$playerId, (int)$targetId);
                // если удар нанесен
                if ($damage[0] != 0) {
                    $log[] = $damage;
                    $damaged['player'] += $damage[1];
                }
                $logs[] = $log;

                // если у ударяющего игрока есть питомец
                if ($players[$playerId]['pet'] && $players[$playerId]['pet']['hp'] > 0) {
                    // если у защищающегося игрока есть питомец
                    if ($players[$targetId]['pet'] && $players[$targetId]['pet']['hp'] > 0) {
                    $target = (int) -1 * $targetId;
                        if (isset($attacks[$targetId . 'p'])) {
                            $attacks[$targetId . 'p']++;
                        } else {
                            $attacks[$targetId . 'p'] = 0;
                        }
						if (rand(1, 100) <= Fight::petGetChanceStunPet($players[$playerId]['pet'], $players[$targetId]['pet'])) {
							$stun = 1;
						} else {
							if (rand(1, 100) <= Fight::petGetChanceAttackPlayer($players[$playerId]['pet'], $players[$targetId]['pet'])) {
								$target = $targetId;
								$petToPlayer = 1;
								if (rand(1, 100) <= Fight::petGetChanceTankPlayer($players[$playerId]['pet'], $players[$targetId]['pet'])) {
									$target = (int) -1 * $targetId;
									$catch = 1;
									$petToPlayer = 0;
								}
							}
						}
						if ($stun) {
							$damage = array(52);
						} else {
							if ($target == $targetId) {
								$damage = Fight::makeStrike($players[$playerId]['pet'], $players[$targetId], $attacks[$targetId . 'p']);
								$damage[0] = 50;
							} else if ($catch) {
								$damage = Fight::makeStrike($players[$playerId]['pet'], $players[$targetId]['pet'], $attacks[$targetId . 'p']);
								$damage[0] = 51;
							} else {
								$damage = Fight::makeStrike($players[$playerId]['pet'], $players[$targetId]['pet'], $attacks[$targetId . 'p']);
							}
						}
						$log = array((int) -1 * $playerId, $target);
						if ($damage[0] != 0) {
							if ($target == $targetId) {
								$damaged['player'] += $damage[1];
							} else {
								$damaged['pet'] += $damage[1];
							}
							$log[] = $damage;
						}
                    } else {
                        $damage = Fight::makeStrike($players[$playerId]['pet'], $players[$targetId], $attacks[$targetId]);
                        $log = array((int) -1 * $playerId, (int)$targetId);
                        if ($damage[0] != 0) {
                            $damaged['player'] += $damage[1];
                            $log[] = $damage;
                        }
                    }
                    $logs[] = $log;
                }

                if ($damaged['player'] > 0) {
                    $players[$playerId]['dg'] += $damaged['player'];
                    //$players[$targetId]['hp'] -= $damaged['player'];
                }
                // если игрок убит текущим ударом
                if ($players[$targetId]['hp'] < 1 && $players[$targetId]['kd'] == 0) {
                    self::playerDie($players, $playerId, $targetId, $logs2, $fight, $enemySide);
                }
                // если игрок убился об пружину текущим ударом
                if ($players[$playerId]['hp'] < 1 && $players[$playerId]['kd'] == 0) {
                    self::playerDie($players, $targetId , $playerId, $logs2, $fight, $player["sd"]);
                }

                if ($damaged['pet'] > 0) {
                    //$players[$targetId]['pet']['hp'] -= $damaged['pet'];
                    if ($players[$targetId]['pet']['hp'] < 1) {
                        $players[$targetId]['pet']['hp'] = 0;
                        $logs2[] = array(0, array(1, (int) -1 * $playerId, (int) -1 * $targetId));
                    }
                }
            }
        }
        foreach ($players as $playerId => &$player) {
            $player["action"] = $player["action2"] = "";
            if ($player["kd"] == 1) {
                $player["alive"] = 0;
            }
			// уменьшаем кол-во ходов действия зонтиков
			if (isset($player["umb"])) {
				$player["umb"]--;
				if ($player["umb"] == 0) {
					unset($player["umb"]);
				}
			}
			// уменьшаем кол-во ходов действия защиты от гранат
			if (isset($player["antigr"])) {
				$player["antigr"]--;
				if ($player["antigr"] == 0) {
					unset($player["antigr"]);
				}
			}
			// удаляем зеркала
			if (isset($player["mrr"])) {
				unset($player["mrr"]);
			}
        }

        $logs = array_merge($logsPre, $logs, $logs2);

        self::savePlayersInFight($fight->id, $players);

        $fight->data['a']['k'] = self::$sql->getValue("SELECT count(*) FROM fightplayer WHERE fight = " . $fight->id . " AND side = 'a' AND alive = 0");
        $fight->data['d']['k'] = self::$sql->getValue("SELECT count(*) FROM fightplayer WHERE fight = " . $fight->id . " AND side = 'd' AND alive = 0");

		$aAlive = self::$sql->getValue("SELECT count(*) FROM fightplayer WHERE fight = " . $fight->id . " AND side = 'a' AND alive = 1");
		$dAlive = self::$sql->getValue("SELECT count(*) FROM fightplayer WHERE fight = " . $fight->id . " AND side = 'd' AND alive = 1");

        //if ($fight->data['a']['k'] >= $fight->ac && $fight->data['d']['k'] < $fight->dc) {
		if ($aAlive == 0 && $dAlive > 0) {
			$fight->results['w'] = 'd';
			$finish = true;
        //} elseif ($fight->data['a']['k'] < $fight->ac && $fight->data['d']['k'] >= $fight->dc) {
		} elseif ($aAlive > 0 && $dAlive == 0) {
			$fight->results['w'] = 'a';
			$finish = true;
        //} elseif ($fight->data['a']['k'] >= $fight->ac && $fight->data['d']['k'] >= $fight->dc) {
		} elseif (($aAlive == 0 && $dAlive == 0) || $fight->steps >= 100) { // все умерли или завершение по таймауту
			$fight->results['w'] = '';
			$finish = true;
		}

        // лог сохранения флага
        if ($fight->type == 'flag' && $finish && $fight->results['f'] == 0) {
            $logs[] = array(0, array(3, $fight->data['f']));
        }

        //$fight->log[] = $logs;
		if ($finish) {
            $fight->state = "finishing";
		}

        $t = time();
        $s = (int)date("s", $t);
        $s = $s >= 30 ? 60 - $s : 30 - $s;
        $fight->dt = date('Y-m-d H:i:s', $t + $s - 1); // -1 на всякий случай =)

        $fight->data['a']['c'] = $fight->ac;
        $fight->data['d']['c'] = $fight->dc;
        $fight->data = json_encode($fight->data);
        $fight->results = json_encode($fight->results);
        $fight->steps++;
        $fight->save($fight->id, array(fightObject::$DT, fightObject::$STATE, fightObject::$DATA, fightObject::$RESULTS, fightObject::$STEPS));

        self::$sql->query("INSERT INTO fightlog (fight, step, log)
            VALUES (" . $fight->id . ", " . $fight->steps . ", '" . addslashes(json_encode($logs)) . "')");

        self::$cache->delete("fight_" . $fight->id . "_a_right_1");
        self::$cache->delete("fight_" . $fight->id . "_a_right_0");
        self::$cache->delete("fight_" . $fight->id . "_d_right_1");
        self::$cache->delete("fight_" . $fight->id . "_d_right_0");

        Page::endTransaction("gf_calc_step_" . $id, false);
	}

	/**
	 * Использование предметов
	 *
	 * @param array $players
	 */
	private static function useItems(&$fight, &$players, &$logsPre, &$logs2)
	{
		$loadedItems = array();
		Std::loadMetaObjectClass("inventory");

		// использование предметов (лечение/защита)
        foreach ($players as $playerId => &$player) {
            if ($player["alive"] == 1) {
                if (isset($player["action"]["item"])) {
                    $itemId = $player["action"]["item"][1];
                    if (array_key_exists($itemId, $player["items"])) {
                        $inventoryItem = new inventoryObject();
                        $inventoryItem->load($itemId);
                        $loadedItems[$itemId] = $inventoryItem;

                        $used = false;
                        switch ($inventoryItem->type) {
                            case "drug":
                                $player["hp"] += $inventoryItem->hp;
                                if ($player["hp"] > $player["mhp"]) {
                                    $player["hp"] = $player["mhp"];
                                }
                                $logsPre[] = array(0, array(6, $playerId, $inventoryItem->name, $inventoryItem->hp));
                                $used = true;
                                break;

							case "weapon":
								if ($inventoryItem->code == "fight_antigranata") {
									$logsPre[] = array(0, array(14, $playerId, $inventoryItem->name, 0));
									$player["antigr"] = isset($player["antigr"]) ? $player["antigr"] + $inventoryItem->special2 : $inventoryItem->special2;
									$used = true;
								}
								break;
                        }

                        if ($used) {
                            $inventoryItem->useWithNoEffect();

                            $player["items"][$itemId]["drb"]--;
                            if ($player["items"][$itemId]["drb"] == 0) {
                                unset($player["items"][$itemId]);
                                $player["items"][] = "";
                            }
                        }
                    }
                }
            }
        }

        // использование предметов (атака)
        foreach ($players as $playerId => &$player) {
            if ($player["alive"] == 1) {
                if (isset($player["action"]["item"])) {
                    $itemId = $player["action"]["item"][1];
                    if (array_key_exists($itemId, $player["items"])) {
                        $inventoryItem = $loadedItems[$itemId];

                        $used = false;
                        switch ($inventoryItem->type) {
                            case "weapon":
                                switch ($inventoryItem->code) {
                                    case "fight_granata":
                                    case "fight_granata2":
                                    case "fight_granata3":
                                    case "fight_granata4":
                                    case "fight_granata_lvl11":
                                    case "fight_granata_lvl12":
                                    case "fight_granata_lvl13":
                                    case "fight_granata_lvl14":
                                    case "fight_granata_lvl15":
                                    case "fight_granata_ny2011_1":
                                    case "fight_granata_ny2011_2":
                                    case "fight_granata_ny2011_3":
                                    case "fight_granata_ny2011_4":
                                    case "fight_granata_ny2011_5":
                                    case "fight_granata_ny2011_6":
                                    case "fight_granata_ny2011_7":
                                    case "fight_granata_ny2011_8":
                                    case "fight_granata_ny2011_9":
                                    case "fight_granata_ny2011_10":
                                    case "fight_granata_ny2011_11":
                                    case "fight_granata_ny2011_12":
                                    case "fight_granata_ny2011_13":

                                        $logsPre[] = array(0, array(9, $playerId, $inventoryItem->name)); // лог кидания гранаты
                                        $enemySide = $player['sd'] == 'a' ? 'd' : 'a';
                                        $enemySide2 = $enemySide == 'a' ? 'd' : 'a';
                                        $i = 0;
                                        $j = $player["skgr"] >= Page::$data["groupfights"]["skillgranatamax2"] ? $inventoryItem->special4 : 0;
                                        foreach ($players as $pid => &$p) {
                                            if ($p["alive"] == 1) {
                                                if ($i < $inventoryItem->special4 && $p['sd'] == $enemySide) {
                                                    $damagePlayer = floor(mt_rand(80, 110) * ($inventoryItem->special1 +
                                                        ($inventoryItem->special2 - $inventoryItem->special1) *
                                                        $player['skgr'] / Page::$data["groupfights"]["skillgranatamax"]) / 100);
													// защита от гранат
													if (isset($player["antigr"])) {
														$damagePlayer = round($damagePlayer / 2);
														if ($p["hp"] <= $damagePlayer) {
															$damagePlayer = $p["hp"] - 1;
														}
													}

                                                    $logsPre[] = array(0, array(10, $p["id"], $damagePlayer)); // лог урона от гранаты
                                                    $p["hp"] -= $damagePlayer;
                                                    $player["dg"] += $damagePlayer;
                                                    if ($p['hp'] < 1 && $p['kd'] == 0) {
                                                        self::playerDie($players, $playerId, $p["id"], $logs2, $fight, $enemySide);
                                                    }
                                                    /*
                                                    if ($p['pet'] && $p['pet']['hp'] > 0) {
                                                        $damagePet = floor(mt_rand(80, 110) * ($inventoryItem->special1 +
                                                            ($inventoryItem->special2 - $inventoryItem->special1) *
                                                            $player['skgr'] / Page::$data["groupfights"]["skillgranatamax"]) / 100);
                                                        $logsPre[] = array(0, array(10, -$p["id"], $damagePet)); // лог урона от гранаты
                                                        $p["pet"]["hp"] -= $damagePet;
                                                        if ($p['pet']['hp'] < 0) {
                                                            $p['pet']['hp'] = 0;
                                                            $logs2[] = array(0, array(1, (int)$playerId, (int) -1 * $p["id"]));
                                                        }
                                                    }
                                                    */
                                                    $i++;
                                                }
                                                if ($j < $inventoryItem->special4 && $p['sd'] != $enemySide) {
                                                    $damagePlayer = floor(mt_rand(80, 110) * ($inventoryItem->special3 -
                                                        $inventoryItem->special3 * $player['skgr'] / Page::$data["groupfights"]["skillgranatamax2"]) / 100);
													// защита от гранат
													if (isset($player["antigr"])) {
														$damagePlayer = round($damagePlayer / 2);
														if ($p["hp"] <= $damagePlayer) {
															$damagePlayer = $p["hp"] - 1;
														}
													}

													$logsPre[] = array(0, array(10, $p["id"], $damagePlayer)); // лог урона от гранаты
                                                    $p["hp"] -= $damagePlayer;
                                                    $player["dg"] += $damagePlayer;
                                                    if ($p['hp'] < 1 && $p['kd'] == 0) {
                                                        self::playerDie($players, $playerId, $p["id"], $logs2, $fight, $enemySide2);
                                                    }
                                                    /*
                                                    if ($p['pet'] && $p['pet']['hp'] > 0) {
                                                        $damagePet = floor(mt_rand(80, 110) * ($inventoryItem->special3 -
                                                            $inventoryItem->special3 * $player['skgr'] / Page::$data["groupfights"]["skillgranatamax2"]) / 100);
                                                        $logsPre[] = array(0, array(10, -$p["id"], $damagePet)); // лог урона от гранаты
                                                        $p["pet"]["hp"] -= $damagePet;
                                                        if ($p['pet']['hp'] < 0) {
                                                            $p['pet']['hp'] = 0;
                                                            $logs2[] = array(0, array(1, (int)$playerId, (int) -1 * $p["id"]));
                                                        }
                                                    }
                                                    */
                                                    $j++;
                                                }

                                            }

                                            if ($i >= $inventoryItem->special4 && $j >= $inventoryItem->special4) {
                                                break;
                                            }
                                        }

                                        self::$sql->query("UPDATE player SET skillgranata = skillgranata + 1 WHERE id = " . $player["id"]);
                                        $player['skgr']++;
                                        $used = true;
                                        break;
                                }
                                break;
                        }

                        if ($used) {
                            $inventoryItem->useWithNoEffect();

                            $player["items"][$itemId]["drb"]--;
                            if ($player["items"][$itemId]["drb"] == 0) {
                                unset($player["items"][$itemId]);
                                $player["items"][] = "";
                            }
                        }
                    }
                }
            }
        }

		// использование предметов: каска, пружина
        foreach ($players as $playerId => &$player) {
            if ($player["alive"] == 1) {
                if (isset($player["action"]["item"])) {
                    $itemId = $player["action"]["item"][1];
                    if (array_key_exists($itemId, $player["items"])) {
                        $inventoryItem = $loadedItems[$itemId];

                        $used = false;

                        switch ($inventoryItem->code) {
                            case "fight_umbrella":
								$logsPre[] = array(0, array(11, $playerId, $inventoryItem->name, 0));
								$player["umb"] = isset($player["umb"]) ? $player["umb"] + 2 : 2;
                                $used = true;
                                break;

                            case "fight_mirror":
								$logsPre[] = array(0, array(12, $playerId, $inventoryItem->name, 0));
								$player["mrr"] = 1;
								$used = true;
                                break;
                        }

                        if ($used) {
                            $inventoryItem->useWithNoEffect();

                            $player["items"][$itemId]["drb"]--;
                            if ($player["items"][$itemId]["drb"] == 0) {
                                unset($player["items"][$itemId]);
                                $player["items"][] = "";
                            }
                        }
                    }
                }
            }
        }

		// использование предметов: призыв крысомахи
        foreach ($players as $playerId => &$player) {
            if ($player["alive"] == 1) {
                if (isset($player["action"]["item"])) {
                    $itemId = $player["action"]["item"][1];
                    if (array_key_exists($itemId, $player["items"])) {
                        $inventoryItem = $loadedItems[$itemId];

                        $used = false;

                        switch ($inventoryItem->code) {
                            case "fight_cheese":
								$logsPre[] = array(0, array(13, $playerId, $inventoryItem->name, 0));
								
								Std::loadModule("Npc");
								$npc = NpcGenerator::get(NPC_RAT, $player, array());
								$npc = $npc->exportForFight();
								$npc['id'] = NPC_ID * 2 + $player["id"] * 100 + mt_rand(1, 99);
								$npc['sd'] = $player["sd"];
								$action = addslashes(json_encode(array("strike" => array(0, array(5, (int)$npc["id"])))));

								self::$sql->query("INSERT INTO fightplayer (fight, player, data, alive, action, side)
									VALUES (" . $fight->id . ", " . $npc["id"] . ", '" . addslashes(json_encode($npc)) . "', 1, '" . $action . "', '" . $npc['sd'] . "')");

								self::$sql->query("UPDATE fight SET " . $player["sd"] . "c = " . $player["sd"] . "c + 1 WHERE id = " . $fight->id);

								$used = true;
                                break;
                        }

                        if ($used) {
                            $inventoryItem->useWithNoEffect();

                            $player["items"][$itemId]["drb"]--;
                            if ($player["items"][$itemId]["drb"] == 0) {
                                unset($player["items"][$itemId]);
                                $player["items"][] = "";
                            }
                        }
                    }
                }
            }
        }

        unset($loadedItems);
	}

    /**
     * Завершение боя
     * 
     * @param int $id
     * @return mixed
     */
    public static function finishFight($id)
    {
        Page::startTransaction("gf_finish_" . $id, false, 600, true);

		Std::loadMetaObjectClass('fight');

        $players = array();
        $playersId = array();

        $fight = new fightObject();
		if ($fight->load($id)) {
            $fight->data = json_decode($fight->data, true);
            $fight->results = json_decode($fight->results, true);
            $fight->log = json_decode($fight->log, true);
            self::getPlayersInFight($fight->id, $players, $playersId);
        } else {
			return false;
		}

        Std::loadMetaObjectClass('pet');
        Std::loadMetaObjectClass('standard_item');
        Std::loadModule('Page');
        Std::loadMetaObjectClass('player');

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',fl1')) {
            // сохранение результатов боя за флаг
            if ($fight->type == 'flag') {
                $m2Resident = $fight->data[($fight->data['d']['f'] == 'r' ? 'd' : 'a')]['m2'];
                $m2Arrived = $fight->data[($fight->data['d']['f'] == 'r' ? 'a' : 'd')]['m2'];

                if ($fight->results['f'] != $fight->data['f'] && (int)$fight->results['f'] != 0) {
                    Std::loadMetaObjectClass('standard_item');
                    $standard_item = new standard_itemObject();
                    $standard_item->loadByCode('ctf_flag');
                    $item = $standard_item->giveGift($players[$fight->data['f']]['nm'], $fight->results['f'], '', 1);

                    $p1 = new playerObject();
                    $p1->load($fight->results['f']);
                    $logFlag = array('r' => 1, 'p' => $p1->exportForLogs());

                    // изменение численности сторон на следующий бой
                    if ($players[$fight->results['f']]['fr'] != $players[$fight->data['f']]['fr']) {
                        $m2Resident = $m2Arrived = 10;
                    } else {
                        if ($players[$fight->results['f']]['fr'] == 'r') {
                            $m2Arrived += 2;
                        } else {
                            $m2Resident += 2;
                        }
                    }
                } else {
                    $p1 = new playerObject();
                    $p1->load($fight->data['f']);
                    $logFlag = array('r' => 0, 'p' => $p1->exportForLogs());

                    // изменение иисленности сторон на следующий бой
                    if ($players[$fight->data['f']]['fr'] == 'r') {
                        $m2Arrived += 2;
                    } else {
                        $m2Resident += 2;
                    }
                }
				CacheManager::set('flag_fight_m2', $m2Resident . ',' . $m2Arrived);
				Page::setValueFromDB('flag_fight_m2', $m2Resident . ',' . $m2Arrived);
            }
            
            $fight->finishing .= ",fl1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        } else {
            if ($fight->type == 'flag') {
                if ($fight->results['f'] != $fight->data['f'] && (int)$fight->results['f'] != 0) {
                    $p1 = new playerObject();
                    $p1->load($fight->results['f']);
                    $logFlag = array('r' => 1, 'p' => $p1->exportForLogs());
                } else {
                    $p1 = new playerObject();
                    $p1->load($fight->data['f']);
                    $logFlag = array('r' => 0, 'p' => $p1->exportForLogs());
                }
            }
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',cl1')) {
            // сохранение результатов кланового боя
            if ($fight->type == 'clanwar') {
				//Std::dump($fight->id .  ' fight: clanwar, result: ' . $fight->results['w'] . ', diplomacy: ' . $fight->data['dp']);
                if ($fight->results['w'] != '') {
                    Std::loadMetaObjectClass('diplomacy');
                    $dip = new diplomacyObject();
                    $dip->load($fight->data['dp']);
					//Std::dump($dip->id .  ' diplomacy: ok');
                    $dip->addGroupFightWins($fight->data[$fight->results['w']]['cl']);

                    $dip->tryEndStep2();
                }
            }

            $fight->finishing .= ",cl1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',mt1')) {
            // сохранение результатов боя за метро
            if (/*date("N", time()) == 5 && */$fight->results["w"] != "" && $fight->type == "metro") {
                $fightSide = $fight->data["a"]["f"] == "a" ? "arrived" : "resident";
                $field = "points2" . ($fight->results["w"] == "a" ? "" : "enemy");
                self::$sql->query("UPDATE sovet3 SET " . $field . " = " . $field . " + 1 WHERE fraction = '" . $fightSide . "'");
                foreach ($players as $playerId => &$player) {
                    if ($player['sd'] == $fight->results['w'] && (int)$playerId < NPC_ID) {
                        //self::$sql->query("UPDATE player2 SET sovetpoints1 = IF(sovetpoints3 >= " . (Page::$data["sovet"]["day5prize"][0] - 1) . ", sovetpoints1 | b'10000', sovetpoints1), sovetpoints3 = sovetpoints3 + 1 WHERE player = " . $player["id"]);
						self::$sql->query("UPDATE player2 SET sovetpoints3 = sovetpoints3 + 1 WHERE player = " . $player["id"]);
                    }
                }
            }

            $fight->finishing .= ",mt1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',xp1')) {
            if ($fight->results['w'] != '') {
                $winnerId = array();
                foreach ($players as $playerId => &$player) {
                    if ($player['sd'] == $fight->results['w'] && (int)$playerId < NPC_ID) {
                        $winnerId[] = $playerId;
                        $player['xp']++;
                    }
                }
                Page::$sql->query("UPDATE player SET exp = exp + 1 WHERE id IN (" . implode(', ', $winnerId) . ")");
            }

            $fight->finishing .= ",xp1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        } else {
            if ($fight->results['w'] != '') {
                $winnerId = array();
                foreach ($players as $playerId => &$player) {
                    if ($player['sd'] == $fight->results['w'] && (int)$playerId < NPC_ID) {
                        $winnerId[] = $playerId;
                        $player['xp']++;
                    }
                }
            }
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',lv1')) {
            // начисление призового фонда победителям
            $aliveId = array();
            $moneyId = array();
            $money2Id = array();
            $prizeMoney = $prizeOre = 0;
            if ($fight->type == 'level') {
                // статистика побед сторон в боях за руду для противостояние фракций
                if ($fight->results['w'] != '') {
                    self::$sql->query("UPDATE rating_fraction SET levelfights = levelfights + 1
                        WHERE fraction = '" . ($fight->results['w'] == "a" ? "arrived" : "resident") . "'");
                }

                $totalDamage = 1;
                foreach ($players as $playerId => &$player) {
                    if ($player['alive'] == 1 && $player["id"] < NPC_ID) {
                        $aliveId[] = $playerId;
                        if ((!isset($player["fj"]) || $player["fj"] == 0) && $player["id"] < NPC_ID) {
                            $moneyId[] = $playerId;
                        }
                    }
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $money2Id[] = $playerId;
                        $totalDamage += $player['dg'];
                    }
                }

                $prizeMoney = floor(self::$levelFightPrize[$fight->level]['m'] * sizeof($players) / 30);
                $prizeMoney -= self::$levelFightCost[$fight->level]['m'] * sizeof($money2Id);

                $prizeOre = floor(self::$levelFightPrize[$fight->level]['o'] * sizeof($players) / 30);
                $prizeOre -= self::$levelFightCost[$fight->level]['o'] * sizeof($money2Id);

                foreach ($players as $playerId => &$player) {
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $player['am'] = self::$levelFightCost[$fight->level]['m'] + floor($player['dg'] / $totalDamage * $prizeMoney);
                        $player['ao'] = self::$levelFightCost[$fight->level]['o'] + floor($player['dg'] / $totalDamage * $prizeOre);

                        self::$sql->query("UPDATE player SET money = money + " . $player['am'] . ", ore = ore + " . $player['ao'] . "
                             WHERE id = " . $playerId);
                    }
                }

                self::savePlayersInFight($fight->id, $players);

                $fight->results['am'] = self::$levelFightCost[$fight->level]['m'];
                $fight->results['ao'] = self::$levelFightPrize[$fight->level]['o'];
            }

            $fight->finishing .= ",lv1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        } else {
            // начисление призового фонда победителям
            $aliveId = array();
            $moneyId = array();
            $money2Id = array();
            $prizeMoney = $prizeOre = 0;
            if ($fight->type == 'level') {
                $totalDamage = 1;
                foreach ($players as $playerId => &$player) {
                    if ($player['alive'] == 1) {
                        $aliveId[] = $playerId;
                        if ((!isset($player["fj"]) || $player["fj"] == 0) && $player["id"] < NPC_ID) {
                            $moneyId[] = $playerId;
                        }
                    }
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $money2Id[] = $playerId;
                        $totalDamage += $player['dg'];
                    }
                }

                $prizeMoney = floor(self::$levelFightPrize[$fight->level]['m'] * sizeof($players) / 30);
                $prizeMoney -= self::$levelFightCost[$fight->level]['m'] * sizeof($money2Id);

                $prizeOre = floor(self::$levelFightPrize[$fight->level]['o'] * sizeof($players) / 30);
                $prizeOre -= self::$levelFightCost[$fight->level]['o'] * sizeof($money2Id);

                foreach ($players as $playerId => &$player) {
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $player['am'] = self::$levelFightCost[$fight->level]['m'] + floor($player['dg'] / $totalDamage * $prizeMoney);
                        $player['ao'] = self::$levelFightCost[$fight->level]['o'] + floor($player['dg'] / $totalDamage * $prizeOre);
                    }
                }

                $fight->results['am'] = self::$levelFightCost[$fight->level]['m'];
                $fight->results['ao'] = self::$levelFightPrize[$fight->level]['o'];
            }
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',cht1')) {
            // начисление призового фонда победителям
            $money3Id = array();
            $playersCount = 0;
            $prizeNeft = 0;
            if ($fight->type == 'chaotic' && $fight->level >= 10) {
                $totalDamage = 1;
                foreach ($players as $playerId => &$player) {
                    if ($player["id"] < NPC_ID) {
                        $playersCount++;
                    }
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $money3Id[] = $playerId;
                        $totalDamage += $player['dg'];
                    }
                }

                $prizeNeft = $playersCount * 10;

                foreach ($players as $playerId => &$player) {
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $player['an'] = floor($player['dg'] / $totalDamage * $prizeNeft);

                        self::$sql->query("UPDATE player SET oil = oil + " . $player['an'] . " WHERE id = " . $playerId);
                    }
                }

                self::savePlayersInFight($fight->id, $players);

                $fight->results['an'] = $prizeNeft;
            }

            $fight->finishing .= ",cht1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        } else {
            // начисление призового фонда победителям
            $money3Id = array();
            $playersCount = 0;
            $prizeNeft = 0;
            if ($fight->type == 'chaotic' && $fight->level >= 10) {
                $totalDamage = 1;
                foreach ($players as $playerId => &$player) {
                    if ($player["id"] < NPC_ID) {
                        $playersCount++;
                    }
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $money3Id[] = $playerId;
                        $totalDamage += $player['dg'];
                    }
                }

                $prizeNeft = $playersCount * 10;

                foreach ($players as $playerId => &$player) {
                    if ($player['sd'] == $fight->results['w'] && !isset($player["fj"]) && $player["id"] < NPC_ID) {
                        $player['an'] = floor($player['dg'] / $totalDamage * $prizeNeft);
                    }
                }

                $fight->results['an'] = $prizeNeft;
            }
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',bn1')) {
            if ($fight->type == 'bank' && $fight->results['w'] == 'a') {
                Std::loadModule('Bank');

                $aliveId = array();
                $moneyId = array();
                foreach ($players as $playerId => &$player) {
                    if ($playerId < NPC_ID) {
                        $aliveId[] = $playerId;
                        if (!isset($player["fj"]) || $player["fj"] == 0) {
                            $moneyId[] = $playerId;
                        }
                    }
                }

                $levelMoney = Bank::getRobberyLevelMoney();
                $prizeMoney = round(($levelMoney[$fight->level] + $fight->data['pzbb']) / sizeof($moneyId));

                if ($prizeMoney < 1) {
                    $prizeMoney = 1;
                }
                if ($prizeMoney > 50000) {
                    $prizeMoney = 50000;
                }

                self::$sql->query("UPDATE player SET money = money + $prizeMoney WHERE id IN (" . implode(',', $moneyId) . ")");

                // списание украденных денег со счетов в банке
                $bankAccounts = self::$sql->getValue("SELECT count(*) FROM bankdeposit");
                $moneyRobbed = round($prizeMoney * sizeof($moneyId) / $bankAccounts);

                $bankMaxLevel = CacheManager::get('value_bankfightmaxlevel');
                $bankFights = $bankMaxLevel - 4;
                $grabbedPercent = 0.1 / $bankFights;

                if ($grabbedPercent < 0) {
                    $grabbedPercent = 0.01;
                }
                if ($grabbedPercent > 0.1) {
                    $grabbedPercent = 0.1;
                }
                self::$sql->query("UPDATE bankdeposit SET money = money - money * $grabbedPercent");

                // удаление счетов, на которых осталось менее 50 монет
                $accounts = self::$sql->getValueSet("SELECT player FROM bankdeposit WHERE money<50");
                if ($accounts) {
                    self::$sql->query("DELETE FROM bankdeposit WHERE money<50");
                    foreach ($accounts as $pid) {
                        Page::sendLog($pid, 'bnkcl', array());
                    }
                }

                $fight->results['am'] = $prizeMoney;
            }

            $fight->finishing .= ",bn1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        } else {
            if ($fight->type == 'bank' && $fight->results['w'] == 'a') {
                Std::loadModule('Bank');

                $aliveId = array();
                $moneyId = array();
                foreach ($players as $playerId => &$player) {
                    if ($playerId < NPC_ID) {
                        $aliveId[] = $playerId;
                        if (!isset($player["fj"]) || $player["fj"] == 0) {
                            $moneyId[] = $playerId;
                        }
                    }
                }

                $levelMoney = Bank::getRobberyLevelMoney();
                $prizeMoney = round(($levelMoney[$fight->level] + $fight->data['pzbb']) / sizeof($moneyId));

                if ($prizeMoney < 1) {
                    $prizeMoney = 1;
                }
                if ($prizeMoney > 50000) {
                    $prizeMoney = 50000;
                }

                $fight->results['am'] = $prizeMoney;
            }
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',st1')) {
            $maxKills = 0;
            $killer = 0;
            $maxDamage = 0;
            $damager = 0;
            $star = new standard_itemObject();
            $star->loadByCode("fight_star");

			foreach ($players as $playerId => &$player) {
				if ($player['sd'] == $fight->results['w']) {
                    if ($player['ks'] > $maxKills) {
                        $maxKills = $player['ks'];
                        $killer = $playerId;
                    }
                    if ($player['dg'] > $maxDamage) {
                        $maxDamage = $player['dg'];
                        $damager = $playerId;
                    }
                    if ($playerId < NPC_ID) {
                        $star->makeExampleOrAddDurability($playerId, 1);

						if ($fight->type == 'flag') {
							Page::checkEvent($playerId, 'fight_flag', $fight->id);
						}
                    }
                }
            }

            if ($killer < NPC_ID) {
                $star->makeExampleOrAddDurability($killer, Page::$data["groupfights"]["winnersidestars"]);
            }
            if ($killer != $damager && $damager < NPC_ID) {
                $star->makeExampleOrAddDurability($damager, Page::$data["groupfights"]["winnerbeststars"]);
            }

            $fight->finishing .= ",st1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        } else {
            $maxKills = 0;
            $killer = 0;
            $maxDamage = 0;
            $damager = 0;
            $star = new standard_itemObject();
            $star->loadByCode("fight_star");

			foreach ($players as $playerId => &$player) {
				if ($player['sd'] == $fight->results['w']) {
                    if ($player['ks'] > $maxKills) {
                        $maxKills = $player['ks'];
                        $killer = $playerId;
                    }
                    if ($player['dg'] > $maxDamage) {
                        $maxDamage = $player['dg'];
                        $damager = $playerId;
                    }
                }
            }
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',lg1')) {
			$userInfo = array();
            foreach ($players as $playerId => &$player) {
                if ($playerId < NPC_ID) {
					// CHAT бой завершён

					$key = self::signed($playerId);
					$userInfo[$key] = array();
					$userInfo[$key]["fight_side"] = null;
					$userInfo[$key]["fight_id"] = null;
					$userInfo[$key]["fight_state"] = null;
					$userInfo[$key]["fight_dt"] = null;

					$cachePlayer = self::$cache->get("user_chat_" . $key);
					if ($cachePlayer) {
						$cachePlayer["fight_side"] = null;
						$cachePlayer["fight_id"] = null;
						$cachePlayer["fight_state"] = null;
						$cachePlayer["fight_dt"] = null;
						self::$cache->set("user_chat_" . $key, $cachePlayer);
					}

					if ($player['hp'] < 0) {
                        $player['hp'] = 0;
                    }
					$po = new playerObject();
					$po->load($player['id']);
					$po->setHP($player['hp']);
                    if (isset($player['pet'])) {
                        $pet = new petObject();
                        $pet->load($player['pet']['id']);
                        $pet->setHP($player['pet']['hp']);
                    }

                    $logData = array(
                        'id' => $fight->id,
                        't' => $fight->type,
                        'w' => $player['sd'] == $fight->results['w'] ? 1 : ($fight->results['w'] != '' ? 2 : 0),
                        'f' => $fight->type == 'flag' ? $logFlag : '',
                        'xp' => $player['xp'],
                    );
                    if ($fight->type == 'level') {
                        //if (in_array($playerId, $moneyId)) {
                            //$logData['a'] = in_array($playerId, $aliveId) ? 1 : 0;
                            //$logData['am'] = $prizeMoney;
                            //$logData['ao'] = $prizeOre;
                        //}
                        if (in_array($playerId, $money2Id)) {
                            $logData['a'] = 1;
                            $logData['am'] = $player["am"];
                            $logData['ao'] = $player["ao"];
                            $logData['ao'] = $player["ao"];
                        }

                        $p2 = new playerObject();
                        $p2->load($player['id']);
                        $logData['mbckp'] = $p2->getMbckp();

                    } elseif ($fight->type == 'bank' && $fight->results['w'] == 'a') {
                        if (in_array($playerId, $moneyId)) {
                            $logData['a'] = 1;
                            $logData['am'] = $prizeMoney;
                        }

                        $p2 = new playerObject();
                        $p2->load($player['id']);
                        $logData['mbckp'] = array('m' => (int)$p2->money, 'o' => (int)$p2->ore, 'h' => (int)$p2->honey);
                    } elseif ($fight->type == 'chaotic' && $fight->level >= 10) {
                        if (in_array($playerId, $money3Id)) {
                            $logData['a'] = 1;
                            $logData['an'] = $player["an"];
                        }

                        $p2 = new playerObject();
                        $p2->load($player['id']);
                        $logData['mbckp'] = $p2->getMbckp();
                    }

                    if ($player['sd'] == $fight->results['w']) {
                        $logData['as'] = Page::$data["groupfights"]["winnersidestars"];
                        if ($playerId == $killer || $playerId == $damager) {
                            $logData['as'] += Page::$data["groupfights"]["winnerbeststars"];
                        }
                    }

                    Page::sendLog($playerId, 'groupfight', $logData);
                    Page::usePetAutoFood($player['id']);

					if ($fight->type == 'bank' || $fight->type == 'level') {
						Page::checkEvent($playerId, 'fight_' . $fight->type, $fight->id);
					}
                }
			}

            $fight->finishing .= ",lg1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        } else {
            $userInfo = array();
            foreach ($players as $playerId => &$player) {
                if ($playerId < NPC_ID) {
					// CHAT бой завершён
					$key = self::signed($playerId);
					$userInfo[$key] = array();
					$userInfo[$key]["fight_side"] = null;
					$userInfo[$key]["fight_id"] = null;
					$userInfo[$key]["fight_state"] = null;
					$userInfo[$key]["fight_dt"] = null;

					if ($player['hp'] < 0) {
                        $player['hp'] = 0;
                    }
                }
			}
        }

        Page::chatUpdateInfo($userInfo);

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',ssp1')) {
            $fight->results['k'] = array('p' => $killer, 'k' => $maxKills);
            $fight->results['d'] = array('p' => $damager, 'd' => $maxDamage);

            if ($fight->results['w'] != "") {
                $fight->results['as'] = Page::$data["groupfights"]["winnersidestars"];
            }

            $stateparam = json_encode(array(
                'action' => 'redirect',
                'url' => '/fight/' . $fight->id . '/',
            ));

			Page::$sql->query("UPDATE player SET state = '', timer = 0, stateparam = '" . $stateparam . "' WHERE id IN (" . implode(', ', $playersId) . ")");

            $fight->finishing .= ",ssp1";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        }

        $fight->finishing = self::$sql->getValue("SELECT finishing FROM fight WHERE id = " . $fight->id);
        if (!strstr($fight->finishing, ',fl2')) {
            if ($fight->type == 'flag') {
                $flagPlayer = new playerObject();
                $flagPlayer->load($fight->data['f']);
                if ($flagPlayer->state2 != '') {
                    $flagPlayer->state2 = json_decode($flagPlayer->state2, true);
                    $flagPlayer->state = $flagPlayer->state2['state'];
                    //$flagPlayer->stateparam = $flagPlayer->state2['stateparam'];
                    $flagPlayer->timer = $flagPlayer->state2['timer'];
                    $flagPlayer->state2 = '';
                    $flagPlayer->save($flagPlayer->id, array(playerObject::$STATE, playerObject::$STATEPARAM, playerObject::$TIMER, playerObject::$STATE2));
                }
            }

            $fight->finishing .= ",fl2";
            self::$sql->query("UPDATE fight SET finishing = '" . $fight->finishing ."' WHERE id = " . $fight->id);
        }

        $fight->state = 'finished';
        $fight->data = json_encode($fight->data);
        $fight->results = json_encode($fight->results);
        $fight->save($fight->id, array(fightObject::$STATE, fightObject::$DATA, fightObject::$RESULTS));

        Page::endTransaction("gf_finish_" . $id, false);
    }

    /**
     * Удар
     *
     * @param array $attacker
     * @param array $defender
     * @param int $count
     * @return array
     */
	public static function makeStrike(&$attacker, &$defender, $count = 0)
    {
        if ($count > 0) {
            $weakness = $count * 0.07;
            $defender['weakness'] = $weakness > 0.5 ? 0.5 : $weakness;
        }

		Std::loadMetaObjectClass('duel');
		$step = array();
		if (self::r() <= duelObject::calcSP($attacker, $defender) && $defender['id'] != 2) {
			if (self::r() <= duelObject::calcCSP($attacker, $defender)) {
				$dp = duelObject::calcCDP($attacker, $defender);
				$step[] = 2;
			} else {
				$dp = duelObject::calcDP($attacker, $defender);
				$step[] = 1;
			}

			$dmg = floor(duelObject::calcResist($attacker, $defender) * $dp);
			$dp -= $dmg > 0 ? $dmg : 1;

			if (isset($defender["mrr"])) {
				$step = array(14, $dp);
				$attacker['hp'] = max(0, $attacker['hp'] - $dp);
			} elseif (isset($defender["umb"])) {
				$step = array(13, 0);
			} else {
				$step[] = $dp;
				$defender['hp'] = max(0, $defender['hp'] - $dp);
			}
			// здесь будут автолечилки для животных во время боя (когда нибудь, наверное :)
		} else {
			$step[] = 0;
		}
		$step[2] = $count;
		return $step;
	}

    /**
     * Генерация случайного числа
     *
     * @param int $min
     * @param int $max
     * @return int
     */
	public static function r($min = 0, $max = 1)
    {
        return round(rand($min * 10000, $max * 10000) / 10000, 5);
	}

    /**
     * Отображение лога боя
     */
    public function showFight()
    {
		$this->content['fighting'] = $this->fighting;
        $this->content['viewing'] = !$this->fighting && self::$fight->state == 'started' ? 1 : 0;

        $this->content['type'] = self::$fight->type;

        $step = isset($this->url[1]) && is_numeric($this->url[1]) ? (int)$this->url[1] : (self::$fight->log == "" ? self::$fight->steps : sizeof(self::$fight->log));
        if ($step < 0) {
            $step = 0;
        }

        $this->content['waiting'] = 0;
		if ($this->fighting == true || $this->content['viewing'] == 1) {
			$timer = strtotime(self::$fight->dt) - time() + mt_rand(2, 3);
            if ($this->content['viewing'] == 1) {
                $timer += mt_rand(10, 15);
            }
			if ($timer <= 0) {
				$timer = mt_rand(6, 7);
                $this->content['waiting'] = 1;
			} else {
                $this->content['waiting'] = 0;
            }
			$this->content['nextstep'] = $timer;
		}

        $fightResults = array();

        $players = array();
        $playersId = array();

        if (in_array(self::$fight->state, array("started", "finishing", "finished"))) {
            self::getPlayersInFight(self::$fight->id, $players, $playersId);
            if (!$players) {
                $players = self::$fight->players;
            }

            $fraction = self::$player == null ? 'resident' : self::$player->fraction;

            if (self::$fight->type == 'bank') {
                $leftSide = 'a';
                $rightSide = 'd';
            } elseif (self::$fight->type == 'chaotic') {
                if (self::$player != null && isset($players[self::$player->id])) {
                    $leftSide = $players[self::$player->id]["sd"] == "a" ? 'a' : 'd';
                    $rightSide = $leftSide == 'a' ? 'd' : 'a';
                } else {
                    $leftSide = 'a';
                    $rightSide = 'd';
                }
            } else {
                $leftSide = self::$fight->data['a']['f'] == $fraction{0} ? 'a' : 'd';
                $rightSide = $leftSide == 'a' ? 'd' : 'a';
            }

            $this->content['left'] = array(
                'name' => $fraction == 'resident' ? Lang::$captionResident : Lang::$captionArrived,
                'count' => self::$fight->data[$leftSide]['c'],
                'alive' => 0,
                'code' => $fraction,
                'players' => array(),
            );
            $this->content['right'] = array(
                'name' => $fraction == 'resident' ? Lang::$captionArrived : Lang::$captionResident,
                'count' => self::$fight->data[$rightSide]['c'],
                'alive' => 0,
                'code' => $fraction == 'resident' ? 'arrived' : 'resident',
                'players' => array(),
            );
            $fightResults['winners'] = array(
                'players' => array(),
            );

            // фикс для двух массивов чуть выше
            if (self::$fight->type == 'bank') {
                $this->content['left']['name'] = FightLang::$captionBankRobbers;
                $this->content['right']['name'] = FightLang::$captionBankSecurity;
                $this->content['left']['code'] = '';
                $this->content['right']['code'] = '';
            } elseif (self::$fight->type == 'clanwar') {
                if (isset(self::$fight->data['a']['nm']) && isset(self::$fight->data['d']['nm'])) {
                    $this->content['left']['name'] = self::$fight->data[$leftSide]['nm'];
                    $this->content['right']['name'] = self::$fight->data[$rightSide]['nm'];
                }
            } elseif (self::$fight->type == 'chaotic') {
                $this->content['left']['name'] = FightLang::CAPTION_TEAM1;
                $this->content['right']['name'] = FightLang::CAPTION_TEAM2;
                $this->content['left']['code'] = '';
                $this->content['right']['code'] = '';
            }

            $winnerFraction = '';
            $winnerSide = '';

            if (is_array($players) && count($players))
            foreach ($players as $playerId => $player) {
                if ((int)$player['hp'] < 0) {
                    $player['hp'] = 0;
                }
                if ($player['fr'] == 'npc') {
                    $player['fightid'] = self::$fight->id;
                }
                $player['procenthp'] = round($player['hp'] / $player['mhp'] * 100);
                $this->content[($player['sd'] == $leftSide ? 'left' : 'right')]['players'][] = $player;
                if ($player['hp'] > 1) {
                    $this->content[($player['sd'] == $leftSide ? 'left' : 'right')]['alive']++;
                }
                if ($playerId == self::$player->id) {
                    $this->content['left']['me'] = $player;
                }
                if ($player['sd'] == self::$fight->results['w']) {
                    $winnerFraction = $player['fr'];
                    $winnerSide = $player['sd'];
                    $fightResults["winners"]["players"][] = $player;
                }
                if ($this->fighting && self::$player->id == $player["id"] && is_array($player['items']) && sizeof($player['items']) > 0) {
                    $this->content["fight"]["items"] = $player["items"];
                }
            }
            if (!isset($this->content['left']['me'])) {
                $this->content['left']['me'] = array('id' => 0);
            }

            // кеш правой колонки игроков
            $rightHtml = self::$cache->get("fight_" . self::$fight->id . "_" . $leftSide . "_right_" . $this->content['waiting']);
            if (!$rightHtml || $this->content['waiting'] == 0) {
                Std::loadLib('Xslt');
                $right = $this->content["right"];
                $right["myside"] = $leftSide;
                $right["myid"] = $this->content['left']['me']["id"];
                $right["myhp"] = $right["myid"] > 0 ? $this->content['left']['me']["hp"] : 0;
                $right["fighting"] = $this->fighting;
                $right["waiting"] = $this->content['waiting'];
                $rightHtml = Xslt::getHtml2('fight/groupfight-right', $right);
                self::$cache->set("fight_" . self::$fight->id . "_" . $leftSide . "_right_" . $this->content['waiting'], $rightHtml, 5);
            }
            $this->content["rightplayers"] = $rightHtml;
            unset($this->content["right"]["players"]);

            $this->content["myside"] = $leftSide;
            $this->content["myid"] = $this->content['left']['me']["id"];
            $this->content["myhp"] = $this->content["myid"] > 0 ? $this->content['left']['me']["hp"] : 0;

            // результаты боя
            if (self::$fight->state == 'finished' && $step == self::$fight->steps) {
                $resultsHtml = self::$cache->get("fight_" . self::$fight->id . "_results");
                if (!$resultsHtml) {
                    $fightResults['id'] = self::$fight->id;
                    $fightResults['type'] = self::$fight->type;
                    $fightResults['time'] = date("H:i:s", strtotime(self::$fight->data['dt']));
                    $fightResults['date'] = date("d.m.Y", strtotime(self::$fight->data['dt']));

                    $fightResults['winners']['side'] = self::$fight->results['w'];
                    $fightResults['winners']['alive'] = $this->content[($winnerSide == $leftSide ? 'left' : 'right')]['alive'];
                    $fightResults['winners']['count'] = self::$fight->data[$winnerSide]['c'];

                    if (self::$fight->results['w'] != '') {
                        $fightResults['winners']['code'] = $winnerFraction == 'r' ? 'resident' : 'arrived';
                        $fightResults['winners']['name'] = $winnerFraction == 'r' ? Lang::$captionResident : Lang::$captionArrived;
                        switch (self::$fight->type) {
                            case 'flag':
                                $fightResults['flag'] = array(
                                    'result' => self::$fight->data['f'] == self::$fight->results['f'] || self::$fight->results['f'] == 0 ? 'defended' : 'captured',
                                    'player' => self::$fight->data['f'] == self::$fight->results['f'] || self::$fight->results['f'] == 0 ? $players[self::$fight->data['f']] : $players[self::$fight->results['f']],
                                );
                                break;

                            case 'bank':
                                $fightResults['winners']['name'] = self::$fight->results['w'] == 'a' ? FightLang::$captionBankRobbers : FightLang::$captionBankSecurity;
                                $fightResults['winners']['code'] = '';
                                $fightResults['results']['am'] = self::$fight->results['am'];
                                break;

                            case 'clanwar':
                                if (isset(self::$fight->data[self::$fight->results['w']]['nm'])) {
                                    $fightResults['winners']['name'] = self::$fight->data[self::$fight->results['w']]['nm'];
                                }
                                break;

                            case 'test':
                                break;

                            case 'level':
                                $fightResults['results']['am'] = self::$fight->results['am'];
                                $fightResults['results']['ao'] = self::$fight->results['ao'];
                                break;

                            case "chaotic":

                                break;
                        }
                        $fightResults['results']['as'] = self::$fight->results['as'];
                        if ((int)self::$fight->results['k']['p'] > 0) {
                            $fightResults['killer'] = array(
                                'player' => $players[self::$fight->results['k']['p']],
                                'kills' => self::$fight->results['k']['k'],
                            );
                        } else {
                            $fightResults['killer'] = '';
                        }

                        if ((int)self::$fight->results['d']['p'] > 0) {
                            $fightResults['damager'] = array(
                                'player' => $players[self::$fight->results['d']['p']],
                                'damage' => self::$fight->results['d']['d'],
                            );
                        } else {
                            $fightResults['damager'] = '';
                        }
                    }
                    Std::loadLib('Xslt');
                    $resultsHtml = Xslt::getHtml2('fight/groupfight-results', $fightResults);
                    self::$cache->set("fight_" . self::$fight->id . "_results", $resultsHtml, 30);
                }
                $this->content["fightresults"] = $resultsHtml;
            }

            Std::loadModule('Alley');

            $logHtml = self::$cache->get("fight_" . self::$fight->id . "_log_" . $step);
            if (!$logHtml) {
                $log = self::$sql->getValue("SELECT log FROM fightlog WHERE fight = " . self::$fight->id . " AND step = " . $step);
                $currentlog = $log ? json_decode($log, true) : self::$fight->log[$step - 1];

                $newLogAll = $newLogMe = $newLogMy = array();
                if ($currentlog) {
                    foreach ($currentlog as &$strike) {
                        if (is_array($strike[1])) {
                            $left = $strike[1][1];
                            $right = $strike[1][2];
                            $strike[2] = '';
                            switch ($strike[1][0]) {
                                case 1: $strike[3] = array('1', FightLang::LOG_ACTION_KILLS, '2'); break;
                                case 2: $strike[3] = array('1', FightLang::LOG_ACTION_GETSFLAG, '2'); break;
                                case 3: $strike[3] = array('1', FightLang::LOG_ACTION_SAVESFLAG); break;
                                case 4: $strike[3] = array('1', FightLang::LOG_ACTION_PROTECTS, '2'); break;
                                case 5: $strike[3] = array('1', FightLang::LOG_ACTION_FORCEJOINS, ''); break;
                                case 6: $strike[3] = array('1', FightLang::LOG_ACTION_EATS . "<b>" . $right . "</b> (+" . $strike[1][3] . ")", ''); break;
                                case 7: $strike[3] = array('1', FightLang::LOG_ACTION_USESITEM, ''); break;
                                case 8: $strike[3] = array('1', FightLang::LOG_ACTION_RUPOR, "<b>" . $right . "</b>"); break;

                                case 9: $strike[3] = array('1', FightLang::LOG_ACTION_GRANATA, "<b>" . $right . "</b>"); break;
                                case 10: $strike[3] = array('1', FightLang::LOG_ACTION_GRANATA2, " (–" . $right . ")", ''); break;

                                case 11: $strike[3] = array('1', FightLang::LOG_ACTION_UMBRELLA, ''); break;
                                case 12: $strike[3] = array('1', FightLang::LOG_ACTION_MIRROR, ''); break;

								case 13: $strike[3] = array('1', FightLang::LOG_ACTION_CHEESE, ''); break;

								case 14: $strike[3] = array('1', FightLang::LOG_ACTION_ANTIGRANATA, ''); break;
								
								case 50: 
									if ($strike[1][1] > 0) {
										$strike[3] = array('1', FightLang::LOG_PET_FOCUS, '2');
									}
									break;
									
								case 51: 
									$strike[3] = array('2', FightLang::LOG_PET_CATCH, '1');
									break;
									
								case 52: 
									$strike[3] = array('2', FightLang::LOG_PET_STUN, '1');
									break;
                            }
                        } else {
                            $left = $strike[0];
                            $right = $strike[1];

                            if (!$strike[2]) {
                                $strike[2] = array(0, 0);
                            }

                            //$varName = 'fightStringsStrike';
                            /*
                            if ($strike[0] < 0) {
                                $varName .= 'Animal';
                            }
                            if (!$strike[2]) {
                                $varName .= 'Miss';
                                $strike[2] = array(0, 0);
                            } elseif ($strike[2][0] == 1) {
                                $varName .= 'Strike';
                            } elseif ($strike[2][0] == 2) {
                                $varName .= 'Critical';
                            } elseif ($strike[2][0] == 3) {
                                $varName .= 'Injury';
                            } elseif ($strike[2][0] == 11) {

                            } elseif ($strike[2][0] == 11) {

                            }
                            */
                            $strike[3] = array(1, '', 2); //explode('%', AlleyLang::${$varName}[rand(0, count(AlleyLang::${$varName})-1)]);
                        }
                        if ($left < 0) {
                            $strike[4] = array(
                                'type' => 'pet',
                                'nm' => $players[abs($left)]['pet']['nm'],
                                'fr' =>  $players[abs($left)]['fr'],
                            );
                        } elseif ($left > 0) {
                            $strike[4] = array(
                                'type' => 'player',
                                'nm' => $players[$left]['nm'],
                                'lv' => $players[$left]['lv'],
                                'fr' =>  $players[$left]['fr'],
                            );
                        }
                        if ($right < 0) {
                            $strike[5] = array(
                                'type' => 'pet',
                                'nm' => $players[abs($right)]['pet']['nm'],
                                'fr' =>  $players[abs($right)]['fr'],
                            );
                        } elseif ($right > 0) {
                            $strike[5] = array(
                                'type' => 'player',
                                'nm' => $players[$right]['nm'],
                                'lv' => $players[$right]['lv'],
                                'fr' => $players[$right]['fr'],
                            );
                        }
                        $strike[2][2]++;
                        if (abs($left) == self::$player->id) {
                            $strike[6] = 1;
                        } elseif (abs($right) == self::$player->id) {
                            $strike[6] = 2;
                        } else {
                            $strike[6] = 0;
                        }
                        $strike[7] = ($strike[0] > 0 && !isset($players[$strike[0]]['pet'])) || $strike[0] < 0 ? 1 : 0;
                    }
                }
                Std::loadLib('Xslt');
                $logHtml = Xslt::getHtml2('fight/groupfight-steplog', array(
                    "log" => $currentlog,
                    "page" => $step,
                ));
                self::$cache->set("fight_" . self::$fight->id . "_log_" . $step, $logHtml, 30);
            }
            $this->content['log'] = $logHtml;
            
            if (self::$player != null) {
                $this->content['player'] = self::$player->toArray();
                if ($this->fighting) {
                    $this->content["rupor"] = self::$sql->getValue("SELECT count(*) FROM inventory WHERE player = " . self::$player->id . "
                        AND code = 'fight_rupor'") > 0 ? 1 : 0;
                }
            }
        }

        if ($step == 0) {
            $this->content['fight']['time'] = date("H:i:s", strtotime(self::$fight->data['dt']));
            $this->content['fight']['date'] = date("d.m.Y", strtotime(self::$fight->data['dt']));
        }

        $this->content['fight']['id'] = self::$fight->id;
        $this->content['fight']['state'] = self::$fight->state;

		$this->content['page'] = $step;

        $pagerHtml = self::$cache->get("fight_" . self::$fight->id . "_pager_" . $step);
        if (!$pagerHtml) {
            $pager['id'] = self::$fight->id;
            $pager['page'] = $step;
            if ($playersId) {
                $pager['steps'] = self::$fight->steps ? array_fill(1, self::$fight->steps, 1) : array();
            } else {
                $pager['steps'] = sizeof(self::$fight->log) ? array_fill(1, sizeof(self::$fight->log), 1) : array();
            }
            Std::loadLib('Xslt');
            $pagerHtml = Xslt::getHtml2('fight/groupfight-pager', $pager);
            self::$cache->set("fight_" . self::$fight->id . "_pager_" . $step, $pagerHtml, 30);
        }
        $this->content["pager"] = $pagerHtml;

        $this->content['window-name'] = FightLang::$windowTitle;
		$this->page->addPart('content', 'fight/groupfight.xsl', $this->content);
	}

	/*
	 * Шанс атаковать игрока
	 * @param array $pet1
	 * @param array $pet2
	 * @return int
	 */
	public function petGetChanceAttackPlayer($pet1, $pet2) {
		if ($pet1['fo'] > $pet2['lo']) {
			$x = ($pet1['fo'] + 1) / ($pet2['lo'] + 1) + ($pet1['fo'] - $pet2['lo']) / 50;
		} else {
			$x = 1;
		}
		$r = round((1 - 1/$x) * 0.3 * 100);
		return $r;
	}

	/*
	 * Шанс защитить своего хозяина
	 * @param array $pet1
	 * @param array $pet2
	 * @return int
	 */
	public function petGetChanceTankPlayer($pet1, $pet2) {
		if ($pet2['lo'] > $pet1['ma'] ) {
			$x = ($pet2['lo'] + 1) / ($pet1['ma'] + 1) + ($pet2['lo'] - $pet1['ma']) / 50;
		} else {
			$x = 1;
		}
		$r = round((1 - 1/$x) * 0.3 * 100);
		return $r;
	}

	/*
	 * Шанс испугать вражеского питомца
	 * @param array $pet1
	 * @param array $pet2
	 * @return int
	 */
	public function petGetChanceStunPet($pet1, $pet2) {
		if ($pet2['ma'] > $pet1['fo']) {
			$x = ($pet2['ma'] + 1) / ($pet1['fo'] + 1) + ($pet2['ma'] - $pet1['fo']) / 50;
		} else {
			$x = 1;
		}
		$r = round((1 - 1/$x) * 0.3 * 100);
		return $r;
	}

}
?>
