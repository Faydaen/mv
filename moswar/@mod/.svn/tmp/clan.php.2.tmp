<?php

class Clan extends Page implements IModule {

	public $moduleCode = 'Clan';
	public static $clan;
	private $clanRoles = array('founder', 'adviser', 'diplomat', 'money', 'forum', 'people');

	public function __construct() {
		parent::__construct();
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();

		Std::loadMetaObjectClass('clan');
		self::$clan = new clanObject();


		if ($this->url[0] == 'warstats') {
			$this->showWarStats($this->url[1]);
		} else if (self::$player == null && is_numeric($this->url[0]) && self::$clan->load($this->url[0]) !== false) {
			$this->showClan2();
		} else {
			$this->needAuth();

			// регистрация клана
			if ($this->url[0] == 'register' && self::$player->clan == 0) {
				$this->register();

				// внутренняя страница клана (профиль)
			} elseif ($this->url[0] == 'profile' && self::$player->clan > 0 && self::$player->clan_status != 'recruit') {
				self::$clan->load(self::$player->clan);
				self::$clan->loadInventory();

				switch ($_POST['action']) {
					case 'hire_detective':
						$result = Clan::hireDetective();
						break;

					case 'take_rest':
						$result = Clan::takeRest();
						break;

					case 'refuse':
						$result = Clan::refuse((int) $_POST['player']);
						break;

					case 'accept':
						$result = Clan::accept((int) $_POST['player']);
						break;

					case 'drop':
						$result = Clan::drop((int) $_POST['player']);
						break;

					case 'change_info':
						$result = Clan::changeInfo($_POST['info']);
						break;

					case 'dissolve':
						$result = Clan::dissolve();
						break;

					case 'clan_message':
						$result = Clan::clanMessage($_POST['text']);
						break;

					case 'leave':
						$result = Clan::leave();
						break;

					case 'deposit':
						$result = Clan::deposit((int) $_POST['money'], (int) $_POST['ore'], (int) $_POST['honey']);
						break;

					case 'set_clan_title':
						$result = Clan::setClanTitle((int) $_POST['player'], $_POST['title']);
						break;

					case 'set_clan_roles':
						$result = Clan::setClanRoles();
						break;

					case 'expand_office':
						$result = Clan::expandOffice();
						break;

					case 'union_accept':
						$result = Clan::acceptUnion((int) $_POST['diplomacy']);
						break;

					case 'union_decline':
						$result = Clan::declineUnion((int) $_POST['diplomacy']);
						break;

					case 'union_cancel':
						$result = Clan::cancelUnion((int) $_POST['diplomacy']);
						break;

					case 'war_accept':
						$result = Clan::acceptWar((int) $_POST['diplomacy']);
						break;

					case 'war_decline':
						$result = Clan::declineWar((int) $_POST['diplomacy']);
						break;

					case 'war_surrender':
						$result = Clan::warSurrender((int) $_POST['diplomacy']);
						break;

					case 'war_exit':
						$result = Clan::warExit((int) $_POST['diplomacy']);
						break;
				}

				if (isset($result)) {
					Runtime::set('content/result', $result);
					Std::redirect($result['redirect'] == '' ? '/clan/profile/' : $result['redirect']);
				}

				//if (self::$player->clan == Clan::$clan->id) {
				switch ($this->url[1]) {
					case 'team':
						$this->showTeam();
						break;

					case 'diplomacy':
						$this->showDiplomacy();
						break;

					case 'warehouse':
						$this->showWarehouse();
						break;

					case 'upgrade':
						$this->showUpgrade();
						break;

					case 'logs':
						$this->showLogs();
						break;

					case 'warstats':
						Std::loadMetaObjectClass('diplomacy');
						$war = diplomacyObject::isAtWar(self::$clan->id);
						if (!$war) {
							Std::redirect('/clan/profile/');
						}
						$this->showWarStats($war);
						break;

					case 'banzai':
						$this->showBanzai();
						break;

					default:
						$this->showProfile();
						break;
				}
				//} else {
				//    $this->showProfile();
				//}
				// внешняя страница клана
			} elseif (is_numeric($this->url[0]) && self::$clan->load($this->url[0]) !== false) {
				self::$clan->loadInventory();

				switch ($_POST['action']) {
					case 'apply':
						$result = self::apply($this->url[0]);
						break;

					case 'apply_cancel':
						if (self::$player->clan == $this->url[0] && self::$player->clan_status == 'recruit') {
							$result = self::cancelApply($this->url[0]);
						}
						break;

					case 'union_propose':
						self::proposeUnion();
						break;

					case 'union_propose_cancel':
						self::cancelProposeUnion();
						break;

					case 'attack':
						self::attack();
						break;
				}

				if (isset($result)) {
					Runtime::set('content', array('result' => $result));
					Std::redirect('/clan/' . $this->url[0] . '/');
				}

				$this->showClan($this->url[0]);

				// страница основания клана
			} else {
				if (Clan::$player->clan > 0 && Clan::$player->clan_status != 'recruit') {
					Std::redirect('/clan/profile/');
				} else {
					$this->showSplash();
				}
			}
		}
		//
		parent::onAfterProcessRequest();
	}

	public static function hasRole($role, $clanId = 0) {
		if ($clanId) {
			Std::loadMetaObjectClass('clan');
			$clan = new clanObject();
			$clan->load($clanId);
		} else {
			$clan = self::$clan;
		}
		if ($clan->founder == self::$player->id) {
			return 1;
		}
		if ($clan->id != self::$player->clan) {
			return 0;
		}
		if ($role == 'founder') {
			return self::$player->clan_status == $role ? 1 : 0;
		} else {
			return self::$player->clan_status == $role || self::$player->clan_status == 'adviser' ? 1 : 0;
		}
		return 0;
	}

	/*
	 * Нанять детектива
	 */

	public static function hireDetective() {
		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 0,
			'type' => 'clan',
			'action' => 'hire_detective',
		);
		if (!self::hasRole('diplomat', self::$player->clan)) {
			$result['result'] = 0;
			$result['error'] = 'noRightsDiplomacy';
			Page::addAlert(ClanLang::ERROR, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}
		Page::startTransaction('clan_hiredetective_' . Clan::$clan->id, false);
		if (Clan::$clan->honey < Page::$data['costs']['clan']['hire_detective']['honey']) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoMoney, ALERT_ERROR);
			return $result;
		}
		Clan::$clan->honey -= Page::$data['costs']['clan']['hire_detective']['honey'];
		Clan::$clan->save(Clan::$clan->id, array(clanObject::$HONEY));
		Page::endTransaction('clan_hiredetective_' . Clan::$clan->id, false);
		Clan::sendClanLog('hire_detective', array('p' => self::$player->exportForLogs(), 'h' => Page::$data['costs']['clan']['hire_detective']['honey']), Page::$player->id);
		$result['result'] = 1;
		$result['redirect'] = '/rating/clans/for_attack/';
		Runtime::set('clan_hiredetective', true);
		return $result;
	}

	/**
	 * Соглашение заключить союз
	 *
	 * @global array $data
	 * @param int $diplomacyId
	 * @return array
	 */
	public static function acceptUnion($diplomacyId) {
		global $data;
		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 1,
			'type' => 'clan',
			'action' => 'union_accept',
		);

		$unions = self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE type='union' AND state='accepted' AND (clan1=" . self::$clan->id . " OR clan2=" . self::$clan->id . ")");
		$price = $unions == 0 ? 100 : 200;

		$clans = self::$sql->getRecord("SELECT clan1, clan2, parent_diplomacy FROM diplomacy WHERE clan2=" . self::$player->clan . "  AND type='union' AND state='proposal' AND id=" . $diplomacyId);

		Std::loadMetaObjectClass('clan');
		$unionClan = new clanObject();
		$unionClan->load($clans['clan1']);
		$unionClan->loadInventory();

		if (!self::hasRole('diplomat')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		} elseif (self::$clan->defence == 0) {
			$result['result'] = 0;
			//$result['error'] = 'you need defence 1';
			Page::addAlert(ClanLang::$error, ClanLang::$errorWeNeedDefence1, ALERT_ERROR);
			return $result;
		} elseif ($unionClan->defence == 0) {
			$result['result'] = 0;
			//$result['error'] = 'they need defence 1';
			Page::addAlert(ClanLang::$error, ClanLang::$errorTheyNeedDefence1, ALERT_ERROR);
			return $result;
		} elseif ($unions == 2) {
			$result['result'] = 0;
			//$result['error'] = 'already 2 unions';
			Page::addAlert(ClanLang::$error, ClanLang::$errorMax2Unions, ALERT_ERROR);
			return $result;
		}

		if (self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE (clan1=" . Clan::$clan->id . " OR clan2=" . Clan::$clan->id . ") AND type='union' AND state='accepted'") < $data['diplomacy']['maxunions']) {
			if (!Clan::$clan->isAtWar()) {
				Std::loadMetaObjectClass('diplomacy');
				$dip = new diplomacyObject();
				if ($dip->load((int) $diplomacyId)) {
					if (Clan::$clan->ore + Clan::$clan->honey >= $price) {
						if (Clan::$clan->ore >= $price) {
							Clan::$clan->ore -= $price;
							Clan::$clan->save(Clan::$clan->id, array(clanObject::$ORE));
							$priceOre = $price;
							$priceHoney = 0;
						} else {
							$priceOre = Clan::$clan->ore;
							$priceHoney = $price - $priceOre;
							Clan::$clan->ore = 0;
							Clan::$clan->honey -= $priceHoney;
							Clan::$clan->save(Clan::$clan->id, array(clanObject::$ORE, clanObject::$HONEY));
						}

						$dip->state = 'accepted';
						$dip->save($dip->id, array(diplomacyObject::$STATE));

						// логи главам кланов
						//Page::sendLog(self::$player->id, 'we_union_accept', array('clan' => $unionClan->exportForDB()));
						Page::sendLog($unionClan->founder, 'they_union_accept', array('clan' => Clan::$clan->exportForDB()));
						// логи кланам
						self::sendClanLog('dua', array('p' => self::$player->exportForLogs(), 'c' => $unionClan->exportForDB(), 'o' => (int) $priceOre, 'h' => (int) $priceHoney));
						self::sendClanLog('dua2', array('p' => self::$player->exportForLogs(), 'c' => self::$clan->exportForDB()), 0, $unionClan->id);
					} else {
						$result['result'] = 0;
						$result['error'] = 'no money';
					}
				}
			} else {
				$result['result'] = 0;
				$result['error'] = 'clan at war';
			}
		} else {
			$result['result'] = 0;
			$result['error'] = 'unions limit';
		}
		return $result;
	}

	/**
	 * Отказ заключить союз
	 *
	 * @param int $diplomacyId
	 * @return array
	 */
	public static function declineUnion($diplomacyId) {
		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 1,
			'type' => 'clan',
			'action' => 'union_decline',
		);
		if (!self::hasRole('diplomat')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}

		$clans = self::$sql->getRecord("SELECT clan1, clan2, parent_diplomacy FROM diplomacy WHERE clan2=" . self::$player->clan . "  AND type='union' AND state='proposal'");

		self::$sql->query("DELETE FROM diplomacy WHERE id=" . (int) $diplomacyId . " AND type='union' AND state='proposal' AND clan2=" . Clan::$clan->id);

		// логи
		Std::loadMetaObjectClass('clan');
		$unionClan = new clanObject();
		$unionClan->load($clans['clan1']);

		//Page::sendLog(self::$player->id, 'we_union_decline', array('clan' => $unionClan->exportForDB()));
		Page::sendLog($unionClan->founder, 'they_union_decline', array('clan' => Clan::$clan->exportForDB()));

		self::sendClanLog('dud', array('p' => self::$player->exportForLogs(), 'c' => $unionClan->exportForDB()));
		self::sendClanLog('dud2', array('p' => self::$player->exportForLogs(), 'c' => self::$clan->exportForDB()), 0, $unionClan->id);

		return $result;
	}

	/**
	 * Соглашение вступления в войну (когда наш союзник на кого-то напал)
	 *
	 * @param int $diplomacyId
	 * @return array
	 */
	public static function acceptWar($diplomacyId) {
		Std::loadMetaObjectClass('diplomacy');

		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 1,
			'type' => 'clan',
			'action' => 'war_accept',
		);

		if (!self::hasRole('diplomat')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		} elseif (diplomacyObject::isAtWar(self::$clan->id)) {
			$result['result'] = 0;
			//$result['error'] = 'you are at war';
			Page::addAlert(ClanLang::$error, ClanLang::ERROR_CANNOT_JOIN_WAR_BECAUSE_OF_ANOTHER_WAR, ALERT_ERROR);
			return $result;
		} elseif (Clan::$clan->state == 'rest') {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, ClanLang::ERROR_CANNOT_JOIN_WAR_BECAUSE_OF_REST, ALERT_ERROR);
			return $result;
		}


		$dip = new diplomacyObject();
		if ($dip->load((int) $diplomacyId, false)) {
			if ($dip->clan1 == self::$clan->id && $dip->type == 'war' && $dip->state == 'proposal') {
				$dip->state = 'paused';
				$dip->save((int) $diplomacyId, array(diplomacyObject::$STATE));
			}
		}

		$clans = self::$sql->getRecord("SELECT clan1, clan2, parent_diplomacy FROM diplomacy WHERE clan1=" . self::$player->clan . "  AND type='war' AND state='paused' AND id=" . (int) $diplomacyId);

		// логи
		$unionClanId = self::$sql->getValue("SELECT clan1 FROM diplomacy WHERE id=" . $clans['parent_diplomacy']);
		Std::loadMetaObjectClass('clan');
		$unionClan = new clanObject();
		$unionClan->load($unionClanId);
		//Page::sendLog(self::$player->id, 'we_attack_accept', array('clan' => $unionClan->exportForDB()));
		Page::sendLog($unionClan->founder, 'they_attack_accept', array('clan' => Clan::$clan->exportForDB()));

		$enemyClan = new clanObject();
		$enemyClan->load($clans['clan2']);

		Clan::sendClanLog('wapa', array('p' => self::$player->exportForLogs(), 'c' => $enemyClan->exportForDB(), 'c2' => $unionClan->exportForDB(), 'd' => $dip->id), self::$player->id, self::$clan->id);
		Clan::sendClanLog('wapa2', array('p' => self::$player->exportForLogs(), 'c' => self::$clan->exportForDB(), 'c2' => $enemyClan->exportForDB(), 'd' => $dip->id), self::$player->id, $unionClan->id);
		Clan::sendClanLog('wapa3', array('p' => self::$player->exportForLogs(), 'c' => self::$clan->exportForDB(), 'c2' => $unionClan->exportForDB(), 'd' => $dip->id), self::$player->id, $enemyClan->id);

		return $result;
	}

	/**
	 * Отказ от вступления в войну (когда наш союзник на кого-то напал)
	 *
	 * @param int $diplomacyId
	 * @return array
	 */
	public static function declineWar($diplomacyId) {
		Std::loadMetaObjectClass('clan');

		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 1,
			'type' => 'clan',
			'action' => 'war_decline',
		);
		if (!self::hasRole('diplomat')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}

		$clans = self::$sql->getRecord("SELECT d.clan1, c1.fraction fraction1, d.clan2, c2.fraction fraction2, parent_diplomacy
            FROM diplomacy d LEFT JOIN clan c1 ON c1.id=d.clan1 LEFT JOIN clan c2 ON c2.id=d.clan2
            WHERE d.id=" . $diplomacyId . "  AND d.type='war' AND d.state='proposal'");

		self::$sql->query("DELETE FROM diplomacy WHERE id=" . (int) $diplomacyId . " AND type='war' AND state='proposal'");

		// логи
		$unionClans = self::$sql->getRecord("SELECT d.clan1, c1.fraction fraction1, d.clan2, c2.fraction fraction2
            FROM diplomacy d LEFT JOIN clan c1 ON c1.id=d.clan1 LEFT JOIN clan c2 ON c2.id=d.clan2
            WHERE d.id=" . $clans['parent_diplomacy']);

		$unionClanId = $unionClans['fraction1'] == self::$clan->fraction ? $unionClans['clan1'] : $unionClans['clan2'];

		$unionClan = new clanObject();
		$unionClan->load($unionClanId);
		//Page::sendLog(self::$player->id, 'we_attack_decline', array('clan' => $unionClan->exportForDB()));
		Page::sendLog($unionClan->founder, 'they_attack_decline', array('clan' => Clan::$clan->exportForDB()));

		$enemyClan = new clanObject();
		$enemyClan->load($clans['clan2']);

		Clan::sendClanLog('wapd', array('p' => self::$player->exportForLogs(), 'c' => $enemyClan->exportForDB(), 'c2' => $unionClan->exportForDB()), self::$player->id, self::$clan->id);
		Clan::sendClanLog('wapd2', array('p' => self::$player->exportForLogs(), 'c' => self::$clan->exportForDB(), 'c2' => $enemyClan->exportForDB()), self::$player->id, $unionClan->id);

		return $result;
	}

	/**
	 * Выход из войны (только для союзников)
	 *
	 * @param int $diplomacyId
	 * @return array
	 */
	private static function warExit($diplomacyId) {
		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 1,
			'type' => 'clan',
			'action' => 'war_exit',
		);
		if (!self::hasRole('diplomat')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}

		$dip = self::$sql->getRecord("SELECT clan1, clan2, parent_diplomacy FROM diplomacy WHERE id = " . $diplomacyId);
		if ($dip['parent_diplomacy'] > 0 && (self::$clan->id == $dip['clan1'] || self::$clan->id == $dip['clan2'])) {
			Std::loadMetaObjectClass('diplomacy');
			$war = new diplomacyObject();
			$war->load($diplomacyId);
			$war->exitWar(self::$clan->id);

			Page::addAlert('Выход из войны', 'Прикинувшись пацифистами, вы отказались воевать и пошли заниматься общественно полезными делами.');
		}

		return $result;
	}

	/**
	 * Капитуляция в войне (только для оснонвых воюющих кланов)
	 *
	 * @param int $diplomacyId
	 * @return array
	 */
	private static function warSurrender($diplomacyId) {
		Page::startTransaction("clan_warsurrender_" . $diplomacyId, false, 5, false, false, false);

		Std::loadMetaObjectClass('clan');

		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 1,
			'type' => 'clan',
			'action' => 'war_surrender',
		);
		if (!self::hasRole('diplomat')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}

		Std::loadMetaObjectClass('diplomacy');
		$war = new diplomacyObject();
		$war->load($diplomacyId);

		if ($war->state == 'step1' || $war->state == 'paused') {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, ClanLang::ERROR_CANNOT_EXIT_BEFORE_STEP2, ALERT_ERROR);
			return $result;
		}

		if ($war->clan1 == self::$clan->id || $war->clan2 == self::$clan->id) {
			Clan::$clan->increasePoints(-3);
			Clan::$clan->save(Clan::$clan->id, array(clanObject::$POINTS));

			$enemyClanId = $war->clan1 == self::$clan->id ? $war->clan2 : $war->clan1;
			$enemyClan = new clanObject();
			$enemyClan->load($enemyClanId);
			Clan::sendClanLog('wsr', array('p' => self::$player->exportForLogs(), 'c' => $enemyClan->exportForDB(), 'pts' => -3));

			$war->surrender(self::$clan->id);

			Page::addAlert('Капитуляция', 'Прикинувшись пацифистами, вы отказались воевать и пошли заниматься общественно полезными делами.');
		}
		
		Page::endTransaction("clan_warsurrender_" . $diplomacyId, false);

		return $result;
	}

	/**
	 * Разрыв союза
	 *
	 * @param int $diplomacyId
	 * @return array
	 */
	public static function cancelUnion($diplomacyId) {
		$result = array(
			'redirect' => '/clan/profile/diplomacy/',
			'result' => 1,
			'type' => 'clan',
			'action' => 'union_cancel',
		);
		if (!self::hasRole('diplomat')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}

		$clans = self::$sql->getRecord("SELECT clan1, clan2 FROM diplomacy WHERE (clan1=" . self::$player->clan . " OR clan2=" . self::$player->clan . ") AND type='union' AND state='accepted' AND id=" . (int) $diplomacyId);

		self::$sql->query("DELETE FROM diplomacy WHERE ((clan1=" . self::$player->clan . " OR clan2=" . self::$player->clan . ")) AND type='union' AND state='accepted' AND id=" . (int) $diplomacyId);

		// логи
		Std::loadMetaObjectClass('clan');
		$clan1 = new clanObject();
		$clan1->load($clans['clan1']);
		$clan2 = new clanObject();
		$clan2->load($clans['clan2']);

		//Page::sendLog(self::$player->id, 'we_union_cancel', array('clan' => ($clan1->id == self::$player->clan ? $clan2->exportForDB() : $clan1->exportForDB())));
		Page::sendLog(($clan1->id == self::$player->clan ? $clan2->founder : $clan1->founder), 'they_union_cancel', array('clan' => ($clan1->id == self::$player->clan ? $clan1->exportForDB() : $clan2->exportForDB())));

		self::sendClanLog('duc', array('p' => self::$player->exportForLogs(), 'c' => ($clan1->id == self::$player->clan ? $clan2->exportForDB() : $clan1->exportForDB())), 0, ($clan1->id == self::$player->clan ? $clan1->id : $clan2->id));
		self::sendClanLog('duc2', array('p' => self::$player->exportForLogs(), 'c' => ($clan1->id == self::$player->clan ? $clan1->exportForDB() : $clan2->exportForDB())), 0, ($clan1->id == self::$player->clan ? $clan2->id : $clan1->id));

		return $result;
	}

	/* Внешние действия */

	/**
	 * Отзыв предложения заключения союза
	 *
	 * @return array
	 */
	public static function cancelProposeUnion() {
		$result = array(
			'redirect' => '',
			'result' => 1,
			'type' => 'clan',
			'action' => 'cancel_propose_union',
		);
		if (!self::hasRole('diplomat', self::$player->clan)) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}

		$clans = self::$sql->getRecord("SELECT clan1, clan2 FROM diplomacy WHERE clan1=" . self::$player->clan . " AND clan2=" . Clan::$clan->id . " AND type='union' AND state='proposal'");

		self::$sql->query("DELETE FROM diplomacy WHERE clan1=" . self::$player->clan . " AND clan2=" . Clan::$clan->id . " AND type='union' AND state='proposal'");

		// логи
		Std::loadMetaObjectClass('clan');
		$clan1 = new clanObject();
		$clan1->load($clans['clan1']);
		$clan2 = new clanObject();
		$clan2->load($clans['clan2']);

		//Page::sendLog(self::$player->id, 'we_cancel_union_propose', array('clan' => $clan2->exportForDB()));
		Page::sendLog(Clan::$clan->founder, 'they_cancel_union_propose', array('clan' => $clan1->exportForDB()));

		self::sendClanLog('dupc', array('p' => self::$player->exportForLogs(), 'c' => $clan2->exportForDB()), 0, $clan1->id);
		self::sendClanLog('dupc2', array('p' => self::$player->exportForLogs(), 'c' => $clan1->exportForDB()), 0, $clan2->id);

		return $result;
	}

	/**
	 * Предложение заключить союз
	 *
	 * @return array
	 */
	public static function proposeUnion() {
		$result = array(
			'redirect' => '',
			'result' => 0,
			'type' => 'clan',
			'action' => 'propose_union',
		);

		$myUnions = (int) self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE type='union' AND (clan1=" . self::$player->clan . " OR clan2=" . self::$player->clan . ")");
		$price = $unions == 0 ? 100 : 200;

		$myClan = new clanObject();
		$myClan->load(self::$player->clan);
		$myClan->loadInventory();

		if (!$myClan || !self::hasRole('diplomat', self::$player->clan)) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		} elseif (self::$clan->fraction != $myClan->fraction) {
			$result['result'] = 0;
			//$result['error'] = 'you need defence 1';
			Page::addAlert(ClanLang::$error, 'Нельзя заключать союзы с кланами противоположной стороны.', ALERT_ERROR);
			return $result;
		} elseif ($myClan->defence == 0) {
			$result['result'] = 0;
			//$result['error'] = 'you need defence 1';
			Page::addAlert(ClanLang::$error, 'Для заключения союза необходимо увеличить защиту Вашего клана до 1.', ALERT_ERROR);
			return $result;
		} elseif (self::$clan->defence == 0) {
			$result['result'] = 0;
			//$result['error'] = 'they need defence 1';
			Page::addAlert(ClanLang::$error, 'Для заключения союза Вашему будущему союзнику необходимо увеличить защиту клана до 1.', ALERT_ERROR);
			return $result;
		} elseif ($unions == 2) {
			$result['result'] = 0;
			//$result['error'] = 'already 2 unions';
			Page::addAlert(ClanLang::$error, 'Нельзя заключать более двух союзов одновременно.', ALERT_ERROR);
			return $result;
		}

		if ($myClan->ore + $myClan->honey >= $price) {
			if ($myClan->ore >= $price) {
				$myClan->ore -= $price;
				$myClan->save($myClan->id, array(clanObject::$ORE));
				$priceOre = $price;
				$priceHoney = 0;
			} else {
				$priceOre = $myClan->ore;
				$priceHoney = $price - $priceOre;
				$myClan->ore = 0;
				$myClan->honey -= $priceHoney;
				$myClan->save($myClan->id, array(clanObject::$ORE, clanObject::$HONEY));
			}
			Std::loadMetaObjectClass('diplomacy');
			$dip = new diplomacyObject();
			$dip->clan1 = $myClan->id;
			$dip->clan2 = Clan::$clan->id;
			$dip->type = 'union';
			$dip->state = 'proposal';
			$dip->dt = date('Y-m-d H:i:s', time());
			$dip->name = $myClan->name . ' > предложение союза > ' . Clan::$clan->name . ' (' . date('d.m.Y H:i', time()) . ')';
			$dip->save();

			//Page::sendLog(self::$player->id, 'we_union_propose', array('clan' => Clan::$clan->exportForDB()));
			Page::sendLog(Clan::$clan->founder, 'they_union_propose', array('clan' => $myClan->exportForDB()));

			self::sendClanLog('dup', array('p' => self::$player->exportForLogs(), 'c' => self::$clan->exportForDB(), 'o' => (int) $priceOre, 'h' => (int) $priceHoney), 0, $myClan->id);
			self::sendClanLog('dup2', array('p' => self::$player->exportForLogs(), 'c' => $myClan->exportForDB()));

			$result['result'] = 1;
		}
		return $result;
	}

	/**
	 * Нападение на клан
	 *
	 * @global array $data
	 * @return array
	 */
	public static function attack() {
		Std::loadMetaObjectClass('diplomacy');

		Page::startTransaction('clan_attack_' . Clan::$clan->id, false, 30);
		Page::startTransaction('clan_attack_' . Page::$player->clan, false, 30);

		global $data;

		$result = array(
			'redirect' => '',
			'result' => 0,
			'type' => 'clan',
			'action' => 'attack',
		);

		if (is_string(self::$clan->data)) {
			self::$clan->data = json_decode(self::$clan->data, true);
		}
		self::$clan->loadInventory();

		$myClan = new clanObject();
		$myClan->load(self::$player->clan);
		$myClan->data = json_decode($myClan->data, true);
		$myClan->loadInventory();

		if (!$myClan || !self::hasRole('diplomat', self::$player->clan)) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::ERROR, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		} elseif (self::$clan->fraction == $myClan->fraction || self::$clan->fraction == '') {
			$result['result'] = 0;
			//$result['error'] = 'already_at_war';
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_SAME_FRACTION, ALERT_ERROR);
			return $result;
		} elseif (self::$clan->state == 'war' || Clan::$clan->isAtWar() > 0 || Page::$sql->getValue("SELECT count(1) FROM diplomacy WHERE type='war' AND (state='paused' OR state='step1' OR state='step2') AND (clan1=" . self::$player->clan . " OR clan2=" . self::$player->clan . ")") > 0) {
			$result['result'] = 0;
			//$result['error'] = 'already_at_war';
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CLAN_ALREADY_AT_WAR, ALERT_ERROR);
			return $result;
		} elseif ($myClan->state == 'war') {
			$result['result'] = 0;
			//$result['error'] = 'already_at_war';
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_YOUR_CLAN_ALREADY_AT_WAR, ALERT_ERROR);
			return $result;
		} elseif (self::$sql->getValue("SELECT count(*) FROM player WHERE accesslevel=0 AND clan=" . self::$clan->id . " AND clan_status != 'recruit'") == 0) {
			$result['result'] = 0;
			//$result['error'] = 'already_at_war';
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_WITH_NO_ACTIVE_PLAYERS, ALERT_ERROR);
			return $result;
		} else if (abs(Clan::$clan->level - $myClan->level) > 2) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_LEVEL_DIFFERENCE, ALERT_ERROR);
			return $result;
		} else if (strtotime($myClan->attackdt) > time()) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_NOW, ALERT_ERROR);
			return $result;
		} else if (strtotime(Clan::$clan->defencedt) > time()) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_NOW, ALERT_ERROR);
			return $result;
		} else if (strtotime(Clan::$clan->regdt) + 3600 * 24 * 14 > time() && Clan::$clan->data['ww'] == 0 && Clan::$clan->data['wf'] == 0) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_NOW, ALERT_ERROR);
			return $result;
		} else if (isset(self::$clan->data['wc']) && self::$clan->data['wc'] > 0 && self::$clan->data['wc'] == $myClan->id && strtotime(self::$clan->data['wdt']) + 3600 * 24 * 4 > time()) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_NOW, ALERT_ERROR);
			return $result;
		}

		// таймаут после последней войны
		/* $warDt = strtotime(self::$clan->data['wdt']);
		  $regDt = strtotime(self::$clan->data['rdt']);
		  $nowDt = time();
		  $diff = $nowDt - $warDt;
		  $diff2 = $nowDt - $regDt;
		  $days = isset(self::$clan->data['wc']) && self::$clan->data['wc'] > 0 && self::$clan->data['wc'] == $myClan->id ? 4 : 2;
		  if ($diff < $days * 24 * 60 * 60 && (self::$clan->data['ww'] + self::$clan->data['wf']) > 0) {
		  $result['result'] = 0;
		  Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_NOW, ALERT_ERROR);
		  return $result;
		  } elseif ($diff2 < 14 * 24 * 60 * 60 && self::$clan->data['ww'] == 0 && self::$clan->data['wf'] == 0) {
		  $result['result'] = 0;
		  Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_ATTACK_NOW, ALERT_ERROR);
		  return $result;
		  } */

		if ($myClan->ore + $myClan->honey >= round((Clan::$clan->ore + Clan::$clan->honey) * 0.1) && $myClan->honey >= round(Clan::$clan->honey * 0.1) && $myClan->money >= round(Clan::$clan->money * 0.1)) {
			// снятие платы с нападющего за нападение
			$logParams = array();
			$myClan->honey -= round(Clan::$clan->honey * 0.1);
			$logParams['h'] = round(Clan::$clan->honey * 0.1);
			$myClan->money -= round(Clan::$clan->money * 0.1);
			$logParams['m'] = round(Clan::$clan->money * 0.1);
			$price = round(Clan::$clan->ore * 0.1);
			if ($myClan->ore >= $price) {
				$myClan->ore -= $price;
				$logParams['o'] = $price;
			} else {
				$priceOre = $myClan->ore;
				$logParams['o'] = $priceOre;
				$myClan->ore = 0;
				$myClan->honey -= ( $price - $priceOre);
				$logParams['h'] += ( $price - $priceOre);
			}
			//$myClan->save($myClan->id, array(clanObject::$ORE, clanObject::$HONEY, clanObject::$MONEY));
			// состояние войны
			$myClan->state = 'war';
			// резервирование выигрыша в казне инициатора войны
			$myClan->rhoney = round($myClan->honey * 0.2);
			$logParams['h3'] = $myClan->rhoney;
			$myClan->rmoney = round($myClan->money * 0.2);
			$logParams['m3'] = $myClan->rmoney;
			$myClan->rore = round($myClan->ore * 0.2);
			$logParams['o3'] = $myClan->rore;
			$myClan->honey -= round($myClan->honey * 0.2);
			$myClan->money -= round($myClan->money * 0.2);
			$myClan->ore -= round($myClan->ore * 0.2);
			$myClan->increasePoints(1);
			$logParams['pts'] = 1;

			// состояние войны
			Clan::$clan->state = 'war';
			// резервирование выигрыша в казне того, на кого напали
			Clan::$clan->rhoney = round(Clan::$clan->honey * 0.2);
			$logParams['h2'] = Clan::$clan->rhoney;
			Clan::$clan->rmoney = round(Clan::$clan->money * 0.2);
			$logParams['m2'] = Clan::$clan->rmoney;
			Clan::$clan->rore = round(Clan::$clan->ore * 0.2);
			$logParams['o2'] = Clan::$clan->rore;
			Clan::$clan->honey -= round(Clan::$clan->honey * 0.2);
			Clan::$clan->money -= round(Clan::$clan->money * 0.2);
			Clan::$clan->ore -= round(Clan::$clan->ore * 0.2);

			$dt = ' (' . date('d.m.Y H:i', time()) . ')';

			// война
			// высчитывание часов ненападения для двух кланов
			$wpt = $wpta = $wptd = array();
			$myWptHours = isset($myClan->inventory['clan_pacifistcert']) ? $myClan->inventory['clan_pacifistcert']->itemlevel : 0;
			if ($myWptHours > 0) {
				$myWptStartHour = isset($myClan->data['wpt']) ? $myClan->data['wpt'] : 0;
				for ($i = $myWptStartHour; $i <= $myWptStartHour + $myWptHours; $i++) {
					$j = $i % 24;
                    if (!in_array($j, $wpt)) {
						$wpt[] = $j;
						$wpta[] = $j;
					}
				}
			}
			$hisWptHours = isset(self::$clan->inventory['clan_pacifistcert']) ? self::$clan->inventory['clan_pacifistcert']->itemlevel : 0;
			if ($hisWptHours > 0) {
				$hisWptStartHour = isset(self::$clan->data['wpt']) ? self::$clan->data['wpt'] : 0;
				for ($i = $hisWptStartHour; $i <= $hisWptStartHour + $hisWptHours; $i++) {
					$j = $i % 24;
                    if (!in_array($j, $wpt)) {
						$wpt[] = $j;
					}
					$wptd[] = $j;
				}
			}

			$attackers = self::$sql->getValueSet("SELECT id FROM player WHERE clan=" . $myClan->id . " AND clan_status!='recruit' AND accesslevel>=0");
			$a = array();
			foreach ($attackers as $attacker) {
				$a[$attacker] = array('id' => $attacker, 'ks' => 0, 'kd' => array(), 'kdby' => array());
			}
			$defenders = self::$sql->getValueSet("SELECT id FROM player WHERE clan=" . Clan::$clan->id . " AND clan_status!='recruit' AND accesslevel>=0");
			$d = array();
			foreach ($defenders as $defender) {
				$d[$defender] = array('id' => $defender, 'ks' => 0, 'kd' => array(), 'kdby' => array());
			}

			$dip = new diplomacyObject();
			$dip->clan1 = $myClan->id;
			$dip->clan2 = Clan::$clan->id;
			$dip->type = 'war';
			$dip->state = 'paused';
			$dip->dt = date('Y-m-d H:i:s', time());
			$dip->dt2 = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * $data['diplomacy']['wardays']);

			$warriors = array(
				'a' => $a,
				'd' => $d,
				'au' => array(),
				'du' => array(),
				'w' => 0,
				'gf' => array('a' => 0, 'd' => 0),
				'wpt' => $wpt,
				'wpta' => $wpta,
				'wptd' => $wptd,
				'st1' => 0,
				'st2' => 0,
				'arm' => $logParams['m3'],
				'aro' => $logParams['o3'],
				'arh' => $logParams['h3'],
				'drm' => $logParams['m2'],
				'dro' => $logParams['o2'],
				'drh' => $logParams['h2'],
			);
			$dip->data = json_encode($warriors);
			$dip->name = $myClan->name . ' > ' . ClanLang::CONTENTICO_STRING_ATTACK . ' > ' . Clan::$clan->name . $dt;
			$dip->save();

			if ($dip->id > 0) {
				Clan::$clan->save(Clan::$clan->id, array(clanObject::$ORE, clanObject::$HONEY, clanObject::$MONEY, clanObject::$RORE, clanObject::$RHONEY, clanObject::$RMONEY, clanObject::$STATE));
				$myClan->save($myClan->id, array(clanObject::$ORE, clanObject::$HONEY, clanObject::$MONEY, clanObject::$RORE, clanObject::$RHONEY, clanObject::$RMONEY, clanObject::$STATE, clanObject::$POINTS));
			} else {
				Std::redirect('/clan/' . Clan::$clan->id . '/');
			}

			$parentDip = $dip->id;

			// логи игрокам
			foreach ($warriors['a'] as $playerId => $player) {
				Page::sendLog($playerId, 'we_attack', array('clan' => Clan::$clan->exportForDB()));
			}
			foreach ($warriors['d'] as $playerId => $player) {
				Page::sendLog($playerId, 'they_attack', array('clan' => $myClan->exportForDB()));
			}
			// логи кланам
			$logParams['c'] = self::$clan->exportForDB();
			$logParams['p'] = self::$player->exportForLogs();
			$logParams['d'] = $dip->id;
			$logParams['pts'] = 1;
			Clan::sendClanLog('wa', $logParams, self::$player->id, $myClan->id);
			unset($logParams['pts']);
			$logParams['c'] = $myClan->exportForDB();
			$logParams['m'] = $logParams['m2'];
			$logParams['o'] = $logParams['o2'];
			$logParams['h'] = $logParams['h2'];
			$logParams['m2'] = $logParams['m3'];
			$logParams['o2'] = $logParams['o3'];
			$logParams['h2'] = $logParams['h3'];
			unset($logParams['m3']);
			unset($logParams['o3']);
			unset($logParams['h3']);
			Clan::sendClanLog('wa2', $logParams, self::$player->id, self::$clan->id);

			// подключение к войне союзников того, на кого напали
			$unions = self::$sql->getRecordSet("
                (SELECT d.clan1 'id', c.name, c.founder FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.clan2=" . Clan::$clan->id . " AND d.type='union' AND d.state='accepted')
                UNION
                (SELECT d.clan2 'id', c.name, c.founder FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.clan1=" . Clan::$clan->id . " AND d.type='union' AND d.state='accepted')");
			if ($unions) {
				foreach ($unions as $union) {
					$unionClan = new clanObject();
					$unionClan->load($union['id']);

					$dip = new diplomacyObject();
					$dip->clan1 = $union['id'];
					$dip->clan2 = $myClan->id;
					$dip->type = 'war';
					$dip->state = diplomacyObject::isAtWar($union['id']) ? 'proposal' : 'paused';
					$dip->dt = date('Y-m-d H:i:s', time());
					$dip->dt2 = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * $data['diplomacy']['wardays']);
					$dip->parent_diplomacy = $parentDip;
					$dip->name = $unionClan->name . ' > ' . (diplomacyObject::isAtWar($union['id']) ? ClanLang::CONTENTICO_STRING_ATTACK_INVITE :
									ClanLang::CONTENTICO_STRING_ATTACK_AUTO) . ' ' . ClanLang::CONTENTICO_STRING_ON_OUR_ALLY . ' > ' . $myClan->name . $dt;
					$dip->save();

					if ($dip->state == 'paused') {
						$defenderUnions = self::$sql->getValueSet("SELECT id FROM player WHERE clan=" . $union['id']);
						if ($defenderUnions) {
							foreach ($defenderUnions as $player) {
								Page::sendLog($player, 'we_attack_auto', array('clan' => $myClan->exportForDB()));
							}
						}

						$glava = new playerObject();
						$glava->load($unionClan->founder);
						Clan::sendClanLog('waa', array('p' => $glava->exportForLogs(), 'c' => $myClan->exportForDB(), 'c2' => self::$clan->exportForDB(), 'd' => $dip->id), $union['founder'], $union['id']);
						Clan::sendClanLog('waa2', array('p' => $glava->exportForLogs(), 'c' => $unionClan->exportForDB(), 'c2' => $myClan->exportForDB(), 'd' => $dip->id), $union['founder'], self::$clan->id);
					} else {
						Page::sendLog($union['founder'], 'they_attack_proposal', array('clan' => $myClan->exportForDB()));
					}
				}
			}

			// подключение к войне союзников того, кто напал
			$unions = self::$sql->getRecordSet("
                (SELECT d.clan1 'id', c.name, c.founder FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.clan2=" . $myClan->id . " AND d.type='union' AND d.state='accepted')
                UNION
                (SELECT d.clan2 'id', c.name, c.founder FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.clan1=" . $myClan->id . " AND d.type='union' AND d.state='accepted')");
			if ($unions) {
				foreach ($unions as $union) {
					$dip = new diplomacyObject();
					$dip->clan1 = $union['id'];
					$dip->clan2 = Clan::$clan->id;
					$dip->type = 'war';
					$dip->state = 'proposal';
					$dip->dt = date('Y-m-d H:i:s', time());
					$dip->dt2 = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * $data['diplomacy']['wardays']);
					$dip->parent_diplomacy = $parentDip;
					$dip->name = $union['name'] . ' > ' . ClanLang::CONTENTICO_STRING_ATTACK_INVITE_ENEMY . ' > ' . Clan::$clan->name . $dt;
					$dip->save();

					Page::sendLog($union['founder'], 'we_attack_proposal', array('clan' => Clan::$clan->exportForDB()));
				}
			}

			$result['result'] = 1;
		} else {
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoMoneyToAttack, ALERT_ERROR);
		}
		return $result;
	}

	/**
	 * Подсчет стоимости следующего расширения штаба
	 *
	 * @return int
	 */
	public static function getExpandOfficePrice() {
		$morePlaces = Clan::$clan->maxpeople - 20;
		$price = 5;
		if ($morePlaces > 0) {
			for ($i = 0; $i < $morePlaces; $i++) {
				if ($i < 4) {
					$price = round($price * 1.5 + 0.4);
				} elseif ($i < 9) {
					$price = round($price * 1.4 + 0.4);
				} elseif ($i < 14) {
					$price = round($price * 1.3 + 0.4);
				} elseif ($i < 19) {
					$price = round($price * 1.2 + 0.4);
				} else {
					$price = round($price * 1.1 + 0.4);
				}
			}
		}
		return $price;
	}

	/**
	 * Расширение штаба
	 *
	 * @return array
	 */
	public function expandOffice() {
		$result = array(
			'redirect' => '/clan/profile/team/',
			'result' => 0,
			'type' => 'clan',
			'action' => 'expand_office',
		);
		if (!self::hasRole('money')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsPeople, ALERT_ERROR);
			return $result;
		}

		$price = self::getExpandOfficePrice();
		if (Clan::$clan->ore + CLan::$clan->honey >= $price && Clan::$clan->money >= $price * 100) {
			Clan::$clan->maxpeople += 1;
			Clan::$clan->money -= $price * 100;
			if (Clan::$clan->ore >= $price) {
				Clan::$clan->ore -= $price;
				$priceOre = $price;
				$priceHoney = 0;
			} else {
				$priceOre = Clan::$clan->ore;
				Clan::$clan->ore = 0;
				$priceHoney = ($price - $priceOre);
				Clan::$clan->honey -= $priceHoney;
			}
			Clan::$clan->save(Clan::$clan->id, array(clanObject::$MONEY, clanObject::$ORE, clanObject::$HONEY, clanObject::$MAXPEOPLE));

			self::sendClanLog('offc', array('p' => self::$player->exportForLogs(), 'mp' => Clan::$clan->maxpeople, 'm' => (int) ($price * 100), 'o' => (int) $priceOre, 'h' => (int) $priceHoney));
			$result['result'] = 1;
		} else {
			$result['result'] = 0;
		}
		return $result;
	}

	/**
	 * Проверка: является ли текущий игрок главой какого-либо клана
	 *
	 * @return bool
	 */
	public function glavaKlana() {
		return Clan::$sql->getValue("SELECT count(*) FROM clan WHERE founder=" . self::$player->id) > 0 ? 1 : 0;
	}

	/**
	 * Установка должности для кланера
	 *
	 * @param int $player
	 * @param string $title
	 * @return array
	 */
	public function setClanTitle($player, $title) {
		$result = array(
			'redirect' => '/clan/profile/team/',
			'result' => 0,
			'type' => 'clan',
			'action' => 'set_clan_title',
		);
		if (!self::hasRole('people')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsAdviser, ALERT_ERROR);
			return $result;
		}

		$playerObj = new playerObject();
		if ($playerObj->load((int) $player) && $playerObj->clan == Clan::$clan->id) {
			$playerObj->clan_title = htmlspecialchars($title);
			$playerObj->save($playerObj->id, array(playerObject::$CLAN_TITLE));
			$result['result'] = 1;
		}
		return $result;
	}

	private function setClanRoles() {
		$result = array(
			'redirect' => '/clan/profile/team/',
			'result' => 0,
			'type' => 'clan',
			'action' => 'set_clan_roles',
		);
		if (!self::hasRole('founder')) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsFounder, ALERT_ERROR);
			//$result['error'] = 'you are not founder of this clan';
			return $result;
		}

		// подсчет стоимости
		$price = 0;
		$newFounder = (int) $_POST['founder'];
		if ($newFounder && $newFounder != self::$clan->founder) {
			$price += 50000;
		}
		foreach (self::$player->clan_status_Dictionary as $role) {
			if ($role == '' || $role == 'founder' || $role == 'recruit' || $role == 'accepted') {
				continue;
			}
			$newRole = (int) $_POST[$role];
			$oldRole = (int) self::$sql->getValue("SELECT id FROM player WHERE clan=" . self::$clan->id . " AND clan_status='" . $role . "'");
			if ($newRole != $oldRole) {
				$price += 5000;
			}
			//if ($oldRole != 0) {
			//    $price += 5000;
			//}
		}
		if ($price > self::$clan->money) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoMoneyToChangeRoles . $a, ALERT_ERROR);
			return $result;
		}

		// списание денег
		self::$clan->money -= $price;
		self::$clan->save(self::$clan->id, array(clanObject::$MONEY));

		$log = array('p' => self::$player->exportForLogs(), 'r' => array(), 'm' => $price);

		// смена главы клана
		if ($newFounder && $newFounder != self::$clan->founder) {
			$p = new playerObject();
			$p->load($newFounder);
			if ($p->clan == self::$clan->id && $p->clan_status != 'recruit') {
				$p->clan_status = 'founder';
				$p->save($p->id, array(playerObject::$CLAN_STATUS));

				// корона
				self::$sql->query("DELETE FROM gift WHERE code = 'clan_founder_crown' and player = " . self::$clan->founder);
				self::$sql->query("UPDATE playerboost2 SET `dt2` = '2000-00-00 00:00:00' WHERE code = 'clan_founder_crown' AND player = " . self::$clan->founder);
				Std::loadMetaObjectClass('standard_item');
				$standard_item = new standard_itemObject();
				$standard_item->loadByCode('clan_founder_crown');
				$standard_item->giveGift('', $newFounder);

				self::$sql->query("UPDATE player SET clan_status = 'accepted' where id = " . self::$clan->founder);

				$p1 = new playerObject();
				$p1->load(self::$clan->founder);
				$log['r']['fr0'] = $p1->exportForLogs();
				$alertText .= '<br /><b>' . $p1->nickname . '</b> ' . ClanLang::ALERT_TITLE_STOP . ' <b>' . ClanLang::$roleFounder . '</b>';

				self::$clan->founder = $newFounder;
				self::$clan->save(self::$clan->id, array(clanObject::$FOUNDER));

				$p1 = new playerObject();
				$p1->load($newFounder);
				$log['r']['fr1'] = $p1->exportForLogs();
				$alertText .= '<br /><b>' . $p->nickname . '</b> ' . ClanLang::ALERT_TITLE_START . ' <b>' . ClanLang::$roleFounder . '</b>';

				Page::sendLog($newFounder, 'clnrl', array('t' => 1, 'r' => 'fr'));
			}
		}

		$logCodes = array('founder' => 'fr', 'adviser' => 'ad', 'diplomat' => 'dp',
			'money' => 'mn', 'forum' => 'fm', 'people' => 'pp');
		$logNames = array('founder' => ClanLang::$roleFounder, 'adviser' => ClanLang::$roleAdviser,
			'diplomat' => ClanLang::$roleDiplomat, 'money' => ClanLang::$roleMoney,
			'forum' => ClanLang::$roleForum, 'people' => ClanLang::$rolePeople);
		$alertText = '';

		// смена остальных должностей
		foreach (self::$player->clan_status_Dictionary as $role) {
			if ($role == '' || $role == 'founder') {
				continue;
			}
			$newRole = (int) $_POST[$role];
			$oldRole = (int) self::$sql->getValue("SELECT id FROM player WHERE clan=" . self::$clan->id . " AND clan_status='" . $role . "'");
			if ($newRole == $oldRole) {
				// ничего не меняется
			} elseif ($newRole != $newFounder) {
				if ($oldRole) {
					$p = new playerObject();
					$p->load($oldRole);
					if ($p->clan == self::$clan->id && $p->clan_status != 'recruit' && $p->clan_status != 'accepted') {
						$p->clan_status = 'accepted';
						$p->save($p->id, array(playerObject::$CLAN_STATUS));

						$log['r'][$logCodes[$role] . '0'] = $p->exportForLogs();
						$alertText .= '<br /><b>' . $p->nickname . '</b> ' . ClanLang::ALERT_TITLE_STOP . ' <b>' . $logNames[$role] . '</b>';

						Page::sendLog($p->id, 'clnrl', array('t' => 0, 'r' => $logCodes[$role]));
					}
				}
				if ($newRole) {
					$p = new playerObject();
					$p->load($newRole);
					if ($p->clan == self::$clan->id && $p->clan_status != 'recruit') {
						$p->clan_status = $role;
						$p->save($p->id, array(playerObject::$CLAN_STATUS));

						$log['r'][$logCodes[$role] . '1'] = $p->exportForLogs();
						$alertText .= '<br /><b>' . $p->nickname . '</b> ' . ClanLang::ALERT_TITLE_START . ' <b>' . $logNames[$role] . '</b>';

						Page::sendLog($p->id, 'clnrl', array('t' => 1, 'r' => $logCodes[$role]));
					}
				}
			}
		}

		Page::addAlert(ClanLang::$rolesAlertTitle, Lang::renderText(ClanLang::ALERT_TITLES_REPORT, array('alert' => $alertText, 'price' => $price)));

		self::sendClanLog('tmsr', $log);

		Std::redirect('/clan/profile/team/');

		return $result;
	}

	/**
	 * Подача заявки на вступление в клан
	 *
	 * @param int $clan
	 * @return array
	 */
	public static function apply($clan) {
		$result = array();
		$result['action'] = 'apply';
		$result['type'] = 'clan';
		if (self::$player->clan != 0) {
			$result['result'] = 0;
			$result['error'] = 'you are already in clan';
			return $result;
		} elseif (self::$player->ore + self::$player->honey < 5) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		} elseif (Clan::$player->fraction != Clan::$clan->fraction) {
			$result['result'] = 0;
			$result['error'] = 'different fractions';
			return $result;
		} elseif (Clan::$player->level < 4) {
			$result['result'] = 0;
			$result['error'] = 'low level';
			return $result;
		} elseif (Clan::$clan->isAtWar()) {
			$result['result'] = 0;
			$result['error'] = 'clan at war';
			return $result;
		}
		//Clan::$player->spendOreHoney(5);
		if (self::$player->ore >= 5) {
			$priceOre = 5;
			$priceHoney = 0;
		} else {
			$priceOre = self::$player->ore;
			$priceHoney = 5 - $priceOre;
		}

		if ($priceHoney > 0) {
			$reason = 'clan apply $' . $priceHoney;
			$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
		}
		if ($priceHoney == 0 || $takeResult[0] == 'OK') {
			self::$player->ore -= $priceOre;
			self::$player->honey -= $priceHoney;

			//$mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);

			Clan::$player->clan = $clan;
			Clan::$player->clan_status = 'recruit';

			Clan::$player->save(Clan::$player->id, array(playerObject::$CLAN, playerObject::$CLAN_STATUS, playerObject::$ORE, playerObject::$HONEY));

			Page::sendLog(self::$clan->founder, 'clnlv2', array('t' => 5));

			self::sendClanLog('japl', array('p' => self::$player->exportForLogs()));

			$result['result'] = 1;
		} else {
			$result['result'] = 1;

			Page::addAlert(ClanLang::$errorNoHoney, ClanLang::$errorNoHoneyText, ALERT_ERROR);
		}
		return $result;
	}

	/**
	 * Отзыв заявки на вступление в клан
	 *
	 * @param int $clan
	 * @return array
	 */
	public static function cancelApply($clan) {
		$result = array();
		$result['action'] = 'cancel_apply';
		$result['type'] = 'clan';
		if (self::$player->clan != self::$clan->id || self::$player->clan_status != 'recruit') {
			$result['result'] = 0;
			$result['error'] = 'you have not made an apply';
			return $result;
		}
		Clan::$player->clan = 0;
		Clan::$player->clan_status = '';
		Clan::$player->save(Clan::$player->id, array(playerObject::$CLAN, playerObject::$CLAN_STATUS));

		//Page::sendNotice(Clan::$clan->founder, 'Заявка о вступлении в клан отменена.');

		self::sendClanLog('japc', array('p' => self::$player->exportForLogs()));

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Выход из клана
	 *
	 * @return array
	 */
	public static function leave() {
		$result = array();
		$result['action'] = 'leave';
		$result['type'] = 'clan';
		if (Clan::$player->clan == 0 || Clan::$player->clan_status == 'recruit') {
			$result['result'] = 0;
			//$result['error'] = 'you are not in clan';
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_ACTION_DENIED, ALERT_ERROR);
			return $result;
		} elseif (self::$player->clan_status != 'accepted') {
			$result['result'] = 0;
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_LEAVE_AT_TITLE, ALERT_ERROR);
			return $result;
		} elseif (Clan::$clan->isAtWar()) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::ERROR, ClanLang::ERROR_CANNOT_LEAVE_DURING_WAR, ALERT_ERROR);
			return $result;
		}
		Clan::$player->clan = 0;
		Clan::$player->clan_status = '';

		// CHAT покидаем клан
		$key = self::signed(Clan::$player->id);
		$userInfo = array();
		$userInfo[$key] = array();
		$userInfo[$key]["clan"] = null;
		$userInfo[$key]["clan_status"] = null;
		Page::chatUpdateInfo($userInfo);

		$cachePlayer = self::$cache->get("user_chat_" . $key);
		if ($cachePlayer) {
			$cachePlayer["clan"] = null;
			$cachePlayer["clan_status"] = null;
			self::$cache->set("user_chat_" . $key, $cachePlayer);
		}

		Clan::$player->save(Clan::$player->id, array(playerObject::$CLAN, playerObject::$CLAN_STATUS));

		self::dropClanItems(self::$player->id);

		Page::sendLog(self::$clan->founder, 'clnlv', array('p' => self::$player->exportForLogs()));

		self::sendClanLog('leav', array('p' => self::$player->exportForLogs()));

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Возврат клановых вещей на склад
	 */
	private static function dropClanItems($playerId) {
		Page::startTransaction('clan_dropclanitems');
		$clanItems = self::$sql->getRecordSet("SELECT * FROM inventory WHERE type2 = 'clan' AND player=" . $playerId);
		if ($clanItems) {
			foreach ($clanItems as $item) {
				if (self::$sql->getValue("SELECT count(*) FROM inventory WHERE clan=" . self::$clan->id . " AND code='" . $item['code'] . "' AND player=0")) {
					$sql = "UPDATE inventory SET maxdurability = maxdurability + " . $item['durability'] . ",
                        durability = durability + " . $item['durability'] . " WHERE clan=" . self::$clan->id . " AND code='" . $item['code'] . "' AND player=0";
				} else {
					$sql = "UPDATE inventory SET player = 0, clan = " . self::$clan->id . " WHERE type2 = 'clan' AND code='" . $item['code'] . "' AND player=" . $playerId;
				}
				Page::$sql->query($sql);
			}
		}
		self::$sql->query("DELETE FROM inventory WHERE type2 = 'clan' AND player=" . $playerId);
	}

	/**
	 * Отказ на заявку на вступление в клан
	 *
	 * @param int $player
	 * @return array
	 */
	public static function refuse($player) {
		$result = array();
		$result['action'] = 'refuse';
		$result['type'] = 'clan';
		if (!self::hasRole('people')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsPeople, ALERT_ERROR);
			return $result;
		}
		$player = Clan::$sql->getRecord("SELECT `id`, `clan`, `clan_status` FROM `player` WHERE `id` = " . $player);
		if ($player['clan'] != Clan::$clan->id || $player['clan_status'] != 'recruit') {
			$result['result'] = 0;
			$result['error'] = 'this player is not recruit of this clan';
			return $result;
		}
		Clan::$sql->query("UPDATE `player` SET `clan` = 0, `clan_status` = '' WHERE `id` = " . $player['id']);

		$p2 = new playerObject();
		$p2->load($player['id']);
		self::sendClanLog('jrfs', array('p' => self::$player->exportForLogs(), 'p2' => $p2->exportForLogs()));

		Page::sendLog($player['id'], 'clnlv2', array('t' => 3));

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Прием игрока в клан (подтверждение заявки)
	 *
	 * @param int $player
	 * @return array
	 */
	public static function accept($player) {
		$result = array();
		$result['action'] = 'accept';
		$result['type'] = 'clan';
		if (!self::hasRole('people')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsPeople, ALERT_ERROR);
			return $result;
		} elseif (Clan::$sql->getValue("SELECT COUNT(1) FROM `player` WHERE `clan_status` != 'recruit' AND `clan` = " . self::$clan->id) >= Clan::$clan->maxpeople) {
			$result['result'] = 0;
			$result['error'] = 'clan is full';
			return $result;
		} elseif (Clan::$clan->isAtWar(self::$clan->id)) {
			$result['result'] = 0;
			$result['error'] = 'clan at war';
			return $result;
		}
		$player = Clan::$sql->getRecord("SELECT `id`, `clan`, `clan_status` FROM `player` WHERE `id` = " . $player);
		if ($player['clan'] != Clan::$clan->id || $player['clan_status'] != 'recruit') {
			$result['result'] = 0;
			$result['error'] = 'this player is not recruit of this clan';
			return $result;
		}
		Clan::$sql->query("UPDATE `player` SET `clan_status` = 'accepted' WHERE `id` = " . $player['id']);

		// CHAT принялив клан
		$key = self::signed($player['id']);

		$userInfo = array();
		$userInfo[$key] = array();
		$userInfo[$key]["clan"] = $player['clan'];
		$userInfo[$key]["clan_status"] = 'accepted';
		Page::chatUpdateInfo($userInfo);


		$cachePlayer = self::$cache->get("user_chat_" . $key);
		if ($cachePlayer) {
			$cachePlayer["clan"] = $player['clan'];
			$cachePlayer["clan_status"] = 'accepted';
			self::$cache->set("user_chat_" . $key, $cachePlayer);
		}

		$p2 = new playerObject();
		$p2->load($player['id']);
		self::sendClanLog('jacp', array('p' => self::$player->exportForLogs(), 'p2' => $p2->exportForLogs()));

		Page::sendLog($player['id'], 'clnlv2', array('t' => 4));

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Выгнать игрока из клана
	 *
	 * @param int $player
	 * @return array
	 */
	public static function drop($player) {
		$result = array(
			'action' => 'drop',
			'type' => 'clan',
			'redirect' => '/clan/profile/team/',
		);

		if (!self::hasRole('people')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsPeople, ALERT_ERROR);
			return $result;
		} elseif (self::$clan->isAtWar(self::$clan->id)) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, ClanLang::$errorCanNotKickDuringWar, ALERT_ERROR);
			return $result;
		}

		$player = self::$sql->getRecord("SELECT `id`, `clan`, `clan_status` FROM `player` WHERE `id` = " . $player);
		if ($player['clan'] != self::$clan->id) {
			$result['result'] = 0;
			//$result['error'] = 'this player is not member of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorCanNotKick, ALERT_ERROR);
			return $result;
		}
		self::$sql->query("UPDATE `player` SET `clan` = 0, `clan_status` = '' WHERE `id` = " . $player['id']);

		// CHAT выгнали из клана
		$key = self::signed($player['id']);
		$userInfo = array();
		$userInfo[$key] = array();
		$userInfo[$key]["clan"] = null;
		$userInfo[$key]["clan_status"] = null;
		Page::chatUpdateInfo($userInfo);


		$cachePlayer = self::$cache->get("user_chat_" . $key);
		if ($cachePlayer) {
			$cachePlayer["clan"] = null;
			$cachePlayer["clan_status"] = null;
			self::$cache->set("user_chat_" . $key, $cachePlayer);
		}

		self::dropClanItems($player['id']);

		Page::sendLog($player['id'], 'clnlv2', array('t' => (self::$player->id == $player['id'] ? 1 : 2)));

		$p2 = new playerObject();
		$p2->load($player['id']);
		self::sendClanLog('jdrp', array('p' => self::$player->exportForLogs(), 'p2' => $p2->exportForLogs()));

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Роспуск клана
	 *
	 * @return array
	 */
	public static function dissolve() {
		Std::loadMetaObjectClass('diplomacy');

		$result = array();
		$result['action'] = 'dissolve';
		$result['type'] = 'clan';
		if (!self::hasRole('founder')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsFounder, ALERT_ERROR);
			return $result;
		}
		$warId = diplomacyObject::isAtWar(self::$clan->id);
		if ($warId) {
			$result['result'] = 0;
			$result['error'] = '';
			Page::addAlert(ClanLang::$error, ClanLang::$errorCanNotKillClanDuringWar, ALERT_ERROR);
			return $result;
		}
		Clan::clanMessage('Клан распущен.');
		// CHAT всех выгнать из клана
		$players = self::$sql->getRecordSet("SELECT id FROM `player` WHERE `clan` = " . self::$player->clan);
		$userInfo = array();

		foreach ($players as $chatPlayer) {
			$key = self::signed($chatPlayer['id']);
			$userInfo[$key] = array();
			$userInfo[$key]["clan"] = null;
			$userInfo[$key]["clan_status"] = 'accepted';

			$cachePlayer = self::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["clan"] = null;
				$cachePlayer["clan_status"] = null;
				self::$cache->set("user_chat_" . $key, $cachePlayer);
			}
		}
		Page::chatUpdateInfo($userInfo);

		// удаление ID клана из таблицы с игроками
		self::$sql->query("UPDATE `player` SET `clan` = 0, `clan_status` = '' WHERE `clan` = " . self::$player->clan);
		// удаление кланового форума
		self::$sql->query("delete from forum WHERE `clan` = " . self::$player->clan);
		// удаление клана
		self::$sql->query("delete from clan WHERE `id` = " . self::$player->clan);
		// удаление дипломаических связей (войны, союзы)
		self::$sql->query("delete from diplomacy WHERE (clan1 = " . self::$player->clan . " OR clan2 = " . self::$player->clan . ")");
		// удаление логов клана
		self::$sql->query("delete from clanlog WHERE clan = " . self::$player->clan);
		// удаление короны главы клана
		self::$sql->query("DELETE FROM gift WHERE code = 'clan_founder_crown' and player = " . self::$player->id);
		CacheManager::delete('player_gifts', array('player_id' => Page::$player->id));
		self::$sql->query("update playerboost2 set `dt2` = '2000-00-00 00:00:00' WHERE code = 'clan_founder_crown' and player = " . self::$player->id);
		CacheManager::delete('clan_full', array('clan_id' => self::$player->clan));

		$result['result'] = 1;
		return $result;
	}

	/**
	 * Редактирование информации о клане
	 *
	 * @return array
	 */
	public static function changeInfo() {
		$result = array();
		$result['action'] = 'change_info';
		$result['type'] = 'clan';
		if (!self::hasRole('adviser')) {
			$result['result'] = 0;
			//$result['error'] = 'you are not founder of this clan';
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsAdviser, ALERT_ERROR);
			return $result;
		}

		$priceHoney = 0;

		if ($_FILES['ico']['tmp_name'] || $_FILES['logo']['tmp_name']) {
			$priceHoney += Page::$data['costs']['clan']['change_graphic']['honey'];
			$priceMoney += Page::$data['costs']['clan']['change_graphic']['money'];
		}

		$ico = $logo = $name = false;

		if (isset($_POST['name']) && $_POST['name'] != Clan::$clan->name && isset($_POST['changename'])) {
			if (strlen($_POST['name']) < 5) {
				$result['result'] = 0;
				//$result['error'] = 'you are not founder of this clan';
				Page::addAlert(ClanLang::$error, ClanLang::$errorShortName, ALERT_ERROR);
				return $result;
			}
			$priceHoney += Page::$data['costs']['clan']['change_name']['honey'];
			$priceMoney += Page::$data['costs']['clan']['change_name']['money'];
			Clan::$clan->name = htmlspecialchars($_POST['name']);
			$name = true;
		}

		if (($priceHoney && self::$clan->honey < $priceHoney) || ($priceMoney && self::$clan->money < $priceMoney)) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, ClanLang::$errorNoMoney, ALERT_ERROR);
			return $result;
		}

		if ($_FILES['ico']['error'] == 0 && $_FILES['ico']['name'] != '') {
			$ico = true;
			Clan::$clan->ico = Clan::$clan->uploadImage('ico');
		}
		if ($_FILES['logo']['error'] == 0 && $_FILES['logo']['name'] != '') {
			$logo = true;
			Clan::$clan->logo = Clan::$clan->uploadImage('logo');
		}
		if ($priceMoney || $priceHoney) {
			Clan::$clan->honey -= $priceHoney;
			Clan::$clan->money -= $priceMoney;
			self::sendClanLog('chgr', array('p' => self::$player->exportForLogs(), 'h' => (int) $priceHoney, 'm' => (int) $priceMoney, 'i' => $ico, 'l' => $logo, 'n' => $name));
		}

		Clan::$clan->info = htmlspecialchars($_POST['info']);
		Clan::$clan->slogan = htmlspecialchars($_POST['slogan']);
		Clan::$clan->site = htmlspecialchars($_POST['site']);
		Clan::$clan->save(Clan::$clan->id, array(clanObject::$INFO, clanObject::$SLOGAN, clanObject::$SITE, clanObject::$ICO, clanObject::$LOGO, clanObject::$HONEY, clanObject::$MONEY, clanObject::$NAME));
		$result['result'] = 1;
		return $result;
	}

	/**
	 * Отправка сообщения всем кланерам
	 *
	 * @param string $text
	 * @return array
	 */
	public static function clanMessage($text) {
		$result = array();
		$result['action'] = 'clan_message';
		$result['type'] = 'clan';
		$amount = Page::sendClanMessage(self::$player->id, self::$player->clan, $text);
		if ($amount > 0) {
			$result['result'] = 1;
		} else {
			$result['result'] = 0;
		}
		return $result;
	}

	/**
	 * Положить средства в клановую казну
	 *
	 * @param int $money
	 * @param int $ore
	 * @param int $honey
	 * @return array
	 */
	public static function deposit($money, $ore, $honey) {
		if (Clan::$clan->state == 'rest') {
			Std::redirect('/clan/profile/');
		}
		Page::startTransaction('clan_deposit');
		$result = array();
		$result['action'] = 'deposit';
		$result['type'] = 'clan';
		if (self::$player->money < $money || self::$player->ore < $ore || self::$player->honey < $honey) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, 'У Вас недостаточно денег.', ALERT_ERROR);
			return $result;
		} elseif (!is_numeric($money) || !is_numeric($ore) || !is_numeric($honey) || $money < 0 || $ore < 0 || $honey < 0 || ($money == 0 && $ore == 0 && $honey == 0)) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, 'Что-то, видимо, пошло не так, и Вы не сумели пополнить казну клана. Попробуйте еще раз.', ALERT_ERROR);
			return $result;
		} elseif (self::$player->clan == 0 || self::$player->clan_status == 'recruit') {
			$result['result'] = 0;
			$result['error'] = 'you are not in clan';
			return $result;
		} elseif (strtotime(self::$player2->lastclandep) > (time() - 8 * 60 * 60)) {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$error, 'Вы совсем недавно пополняли казну клана. Вы сможете сделать следующий взнос не ранее ' . date('d.m.y H:i', (strtotime(self::$player2->lastclandep) + 8 * 60 * 60)) . '.', ALERT_ERROR);
			return $result;
		}

		$priceMoney = $money;
		$priceHoney = $honey;
		if (self::$player->ore >= $ore) {
			$priceOre = $ore;
		} else {
			$priceOre = self::$player->ore;
			$priceHoney += ( $ore - $priceOre);
			$priceHoneyOre = ($ore - $priceOre); // для логов
		}

		if ($priceHoney > 0) {
			$reason = 'clan deposit $' . $priceHoney . ' (' . (int) $priceHoneyOre . ') + @' . $priceOre;
			$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
		}
		if ($priceHoney == 0 || $takeResult[0] == 'OK') {
			self::$player->money -= $priceMoney;
			self::$player->ore -= $priceOre;
			self::$player->honey -= $priceHoney;

			self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE));

			clanObject::increaseMoney(Page::$player->clan, $priceMoney, $priceOre, $priceHoney);

			$mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
			Page::sendLog(self::$player->id, 'clan_investition', array('player' => self::$player->exportForDB(1), 'm' => $priceMoney, 'h' => $priceHoney, 'o' => $priceOre, 'mbckp' => $mbckp), 1);

			if (self::$player->clan_status != 'founder') {
				$founder = self::$sql->getValue("SELECT founder FROM clan WHERE id = " . self::$player->clan);
				Page::sendLog($founder, 'clan_investition', array('player' => self::$player->exportForDB(1), 'm' => $priceMoney, 'h' => $priceHoney, 'o' => $priceOre), 0);
			}

			self::sendClanLog('dpst', array('p' => self::$player->exportForLogs(), 'm' => (int) $priceMoney, 'o' => (int) $priceOre, 'h' => (int) $priceHoney));

			$result['result'] = 1;

			self::$player2->lastclandep = date('Y-m-d H:i:s', time());
			self::$player2->save(self::$player2->id, array(player2Object::$LASTCLANDEP));
		} else {
			$result['result'] = 0;
			Page::addAlert(ClanLang::$errorNoHoney, ClanLang::$errorNoHoneyText, ALERT_ERROR);
		}
		return $result;
	}

	/**
	 * Страница основывания клана
	 */
	protected function showSplash() {
		$this->content['player'] = self::$player->toArray();

		$this->content['window-name'] = ClanLang::$windowTitle;
		$this->page->addPart('content', 'clan/splash.xsl', $this->content);
	}

	/**
	 * Регистрация клана
	 */
	protected function register() {
		$cert = self::$player->loadItemByCode('clan_regcert'); // проверка на сертификат "Мой клан"

		if (isset($_POST['name'])) {
			if (strlen($_POST['name']) < 4 || strlen($_POST['name']) > 50) {
				$this->content['name-error'] = 'bad_length';
				$noErrors = false;
			} else if (preg_match('~[А-Яа-яёЁ]~ui', $_POST['name']) && preg_match('~[a-zA-Z]~ui', $_POST['name'])) {
				$this->content['name-error'] = 'bad_name';
				$noErrors = false;
			} else if (Page::$sql->getValue("SELECT 1 FROM `clan` WHERE `name` = '" . Std::cleanString($_POST['name']) . "' LIMIT 1")) {
				$this->content['name-error'] = 'name_exists';
				$noErrors = false;
			} else if (!$cert && (self::$player->money < Page::$data['costs']['clan']['register']['money'] || self::$player->isEnoughOreHoney(Page::$data['costs']['clan']['register']['ore']) === false)) {
				$this->content['message'] = 'no_money';
				$noErrors = false;
			} else if ($_FILES['ico']['error'] != 0 || $_FILES['logo']['error'] != 0 || $_FILES['ico']['name'] == '' || $_FILES['logo']['name'] == '') {
				$result = array('result' => 0, 'action' => 'register', 'type' => 'clan', 'error' => 'no ico or logo');
				$this->content['result'] = $result;
				$noErrors = false;
			} else {
				if (!$cert) {
					$priceMoney = Page::$data['costs']['clan']['register']['money'];
					if (self::$player->ore >= Page::$data['costs']['clan']['register']['ore']) {
						$priceOre = Page::$data['costs']['clan']['register']['ore'];
					} else {
						$priceOre = self::$player->ore;
						$priceHoney += ( Page::$data['costs']['clan']['register']['ore'] - $priceOre);
					}

					if ($priceHoney > 0) {
						$reason = 'clan register $' . $priceHoney;
						$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
					}
				}
				if ($priceHoney == 0 || $takeResult[0] == 'OK' || $cert) {
					if ($cert) {
						self::$sql->query("DELETE FROM inventory WHERE id=" . $cert->id . " AND player=" . self::$player->id);
						Page::sendLog(self::$player->id, 'item_used', array('n' => $cert->name));
					} else {
						self::$player->money -= $priceMoney;
						self::$player->ore -= $priceOre;
						self::$player->honey -= $priceHoney;
					}

					$site = $_POST['site'];
					if ($site == 'http://' || !preg_match('~(http://)?[a-z0-9\-]+\.[a-z]{2,4}/?\??[\w]*~', $site)) {
						$site = '';
					}
					$clan = new clanObject;
					$clan->founder = self::$player->id;
					$clan->name = htmlspecialchars($_POST['name']);
					$clan->info = htmlspecialchars($_POST['info']);
					$clan->fraction = self::$player->fraction;
					$clan->site = $site;
					$clan->slogan = htmlspecialchars(substr($_POST['slogan'], 0, 80));
					$clan->maxpeople = 20;
					$clan->data = json_encode(array(
								'ww' => 0, // war wins
								'wf' => 0, // war fails
								'we' => 0, // war ends (draw)
								'rdt' => date('Y-m-d H:i:s', time()), // reg dt
								'wdt' => '0000-00-00 00:00:00', // last war dt
								'wpt' => 0, // war pacifict time
							));
					$clan->ico = $clan->uploadImage('ico');
					$clan->logo = $clan->uploadImage('logo');
					$clan->regdt = date('Y-m-d H:i:s', time());
					$clan->lastdecrease = date('Y-m-d 00:00:00', time());
					$clan->defencedt = date('Y-m-d H:i:s', time() + 3600*24*14);
					$clan->attackdt = date('Y-m-d H:i:s', time());
					$clan->level = 1;
					$clan->save();
					//$clan->ico = $clan->uploadImage('ico', 'clan_' . $clan->id . '_ico.' . pathinfo($_FILES['ico']['name'], PATHINFO_EXTENSION));
					//$clan->logo = $clan->uploadImage('logo', 'clan_' . $clan->id . '_logo.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
					/*
					  $ico = '@images/clan/clan_' . $clan->id . '_ico.temp.' . pathinfo($_FILES['ico']['name'], PATHINFO_EXTENSION);
					  $logo = '@images/clan/clan_' . $clan->id . '_logo.temp.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
					  move_uploaded_file($_FILES['ico']['tmp_name'], $ico);
					  move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
					  Std::loadLib('ImageTools');
					  ImageTools::resize($ico, '@images/clan/clan_' . $clan->id . '_ico.png', 28, 16);
					  ImageTools::resize($logo, '@images/clan/clan_' . $clan->id . '_logo.png', 99, 99);
					  unlink($ico);
					  unlink($logo);
					 */
					self::$player->clan = $clan->id;
					self::$player->clan_status = 'founder';
					self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$HONEY, playerObject::$ORE, playerObject::$CLAN, playerObject::$CLAN_STATUS));

					// CHAT создали клан. вошли в клан
					$key = self::signed(self::$player->id);
					$userInfo = array();
					$userInfo[$key] = array();
					$userInfo[$key]["clan"] = $clan->id;
					$userInfo[$key]["clan_status"] = "founder";
					Page::chatUpdateInfo($userInfo);


					$cachePlayer = self::$cache->get("user_chat_" . $key);
					if ($cachePlayer) {
						$cachePlayer["clan"] = $clan->id;
						$cachePlayer["clan_status"] = 'founder';
						self::$cache->set("user_chat_" . $key, $cachePlayer);
					}

					// клановый форум
					self::$sql->query("INSERT INTO forum (name, clan) VALUE('Клан " . Std::cleanString($clan->name) . "', " . $clan->id . ")");

					// дарение короны
					Std::loadMetaObjectClass("standard_item");
					$item = new standard_itemObject();
					$item->loadByCode('clan_founder_crown');
					$item->giveGift(Clan::$player->nickname, Clan::$player->id, '');

					// добавление клана в рейтинг
					self::$sql->query("insert into rating_clan (clan, fraction) values (" . $clan->id . ", '" . $clan->fraction . "')");

					Page::sendLog(self::$player->id, 'clnrg', array('n' => $clan->name));

					Std::redirect('/clan/profile/');
				} else {
					Page::addAlert(ClanLang::$errorNoHoney, ClanLang::$errorNoHoneyText);
				}
			}
		}

		$cert = self::$player->loadItemByCode('clan_regcert');
		$this->content['clan_regcert'] = $cert ? 1 : 0;

		$this->content['window-name'] = ClanLang::$windowTitleRegister;
		$this->page->addPart('content', 'clan/register.xsl', $this->content);
	}

	/**
	 * Страница (профиль) клана (внутренняя)
	 */
	protected function showProfile() {
		Std::loadMetaObjectClass('diplomacy');

		Clan::$clan->load(Clan::$player->clan);
		Clan::$clan->loadFull();
		$this->content['player'] = self::$player->toArray();
		if (is_a(Clan::$clan, 'clanObject')) {
			$this->content['clan'] = Clan::$clan->toArray();
			$forumId = self::$sql->getValue("SELECT id FROM forum WHERE clan=" . Clan::$clan->id);
			if ($forumId) {
				$this->content['clan']['forum'] = $forumId;
			} else {
				$this->content['clan']['forum'] = self::$sql->getValue("SELECT id FROM forum WHERE clans LIKE '%[" . self::$player->clan . "]%'");
			}
		} else {
			//$this->content['player']['fractionTitle'] = Page::$data['fractions']['plural'][$this->content['player']['fraction']];
		}

		// дипломатия
		$this->content['clan']['diplomacy'] = self::$sql->getRecordSet("
            (SELECT d.id diplomacy, d.clan1, d.clan2, d.type, d.state, d.dt, d.dt2, c.name, c.fraction, c.id, d.parent_diplomacy FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.clan2=" . Clan::$clan->id . ")
            UNION
            (SELECT d.id diplomacy, d.clan1, d.clan2, d.type, d.state, d.dt, d.dt2, c.name, c.fraction, c.id, d.parent_diplomacy FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.clan1=" . Clan::$clan->id . ")
        ");
		$this->content['myclan'] = array('war' => self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE type='war' AND (state='paused' OR state='step1' OR state='step2') AND (clan1=" . self::$player->clan . " OR clan2=" . self::$player->clan . ")") > 0 ? 1 : 0);

		if ($this->content['clan']['diplomacy']) {
			Std::loadLib('HtmlTools');
			$dip = array();
			foreach ($this->content['clan']['diplomacy'] as $d) {
				if (($d['type'] == 'war' && $d['state'] == 'proposal' && $d['clan1'] != self::$clan->id) || ($d['type'] == 'war' && $d['state'] == 'finished')) {
					continue;
				}
				$d['dt2'] = HtmlTools::FormatDateTime($d['dt2'], true, true, true);
				$dip[] = $d;
			}
			$this->content['clan']['diplomacy'] = $dip;
		}

		// состояние войны
		$warId = diplomacyObject::isAtWar(self::$clan->id);
		if ($warId) {
			$dip = new diplomacyObject();
			$dip->load($warId, false);
			if ($dip->parent_diplomacy) {
				$dip2 = new diplomacyObject();
				$dip2->load($dip->parent_diplomacy);
				if (self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE type='union' AND state='accepted' AND
                    ((clan1=" . self::$clan->id . " AND clan2=" . $dip2->clan1 . ") OR (clan2=" . self::$clan->id . " AND clan1=" . $dip2->clan1 . "))")) {
					$clanId = $dip2->clan1;
				} else {
					$clanId = $dip2->clan2;
				}
				$dip = $dip2;
			} else {
				$clanId = $dip->clan1 == self::$clan->id ? $dip->clan1 : $dip->clan2;
			}
			$this->content['war'] = $dip->getWarKillsStats($clanId);
			$this->content['war']['atwar'] = 1;
			$this->content['war']['state'] = $dip->state;
		} else {
			$this->content['war'] = array('atwar' => 0);
		}

		// инвентарь
		Std::loadMetaObjectClass('inventory');
		$this->content['inventory'] = array();

		$criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(inventoryObject::$CLAN, ObjectCollectionCriteria::$COMPARE_EQUAL, self::$clan->id);
		$criteria->createWhere(inventoryObject::$MAXDURABILITY, ObjectCollectionCriteria::$COMPARE_EQUAL, 0);

		$inventory = new ObjectCollection();
		$inventory = $inventory->getObjectList(inventoryObject::$METAOBJECT, $criteria);
		if ($inventory) {
			//var_dump($inventory);
			foreach ($inventory as $item) {
				$itemArray = $item->toArray();
				switch ($itemArray['code']) {
					
				}
				$this->content['inventory'][] = $itemArray;
			}
		}
		for ($i = count($this->content['inventory']); $i < 7; $i++) {
			$this->content['inventory'][] = array();
		}

		$this->content['adviser'] = self::hasRole('adviser');
		$this->content['diplomat'] = self::hasRole('diplomat');
		$this->content['people'] = self::hasRole('people');
		$this->content['money'] = self::hasRole('money');

		$this->content['forum_new_topics'] = Page::sqlGetValue("SELECT COUNT(1)
FROM topic AS t
LEFT JOIN post AS p ON p.id = t.lastpost
LEFT JOIN player_topic_read ptr ON ptr.topic = t.id AND ptr.player = " . self::$player->id . " AND ptr.post = p.id
WHERE t.forum = " . $this->content['clan']['forum'] . " and t.deleted = 0 AND ptr.topic IS NULL");

		// взнос в казну
		if (strtotime(self::$player2->lastclandep) > (time() - 8 * 60 * 60)) {
			$this->content['allowdep'] = 0;
			$this->content['depdt'] = date('d.m.Y H:i', (strtotime(self::$player2->lastclandep) + 8 * 60 * 60));
		} else if (Clan::$clan->state == 'rest') {
			$this->content['allowdep'] = 0;
			$this->content['depdt'] = date('d.m.Y H:i', strtotime(Clan::$clan->attackdt));
		} else {
			$this->content['allowdep'] = 1;
		}

		// бусты
		$boosts = self::$sql->getRecordSet("SELECT code, value, dt, dt2 FROM boost WHERE clan=" . self::$clan->id);
		if ($boosts) {
			$this->content['banzai'] = 1;

			$timer = strtotime($boosts[0]['dt2']) - time();
			$banzaiTime = strtotime($boosts[0]['dt2']) - strtotime($boosts[0]['dt']);

			$this->content['banzaitimeleft'] = $timer > 0 ? $timer : 0;
			$this->content['banzaitimeleft2'] = date('H:i:s', $timer);
			$this->content['banzaitimetotal'] = $banzaiTime;
			$this->content['banzaipercent'] = round(($banzaiTime - $timer) / $banzaiTime * 100);

			$curBoosts = array();

			$this->content['boosts'] = $boosts;
		} else {
			$this->content['banzai'] = 0;
		}

		if (Clan::$clan->state == 'rest') {
			$this->content['rest'] = 1;

			$timer = strtotime(Clan::$clan->attackdt) - time();
			$restTime = 3600 * 24 * 7;

			$this->content['resttime'] = date('d.m.Y H:i', strtotime(Clan::$clan->attackdt));
			$this->content['resttimeleft'] = $timer > 0 ? $timer : 0;
			$this->content['resttimeleft2'] = date('H:i:s', $timer);
			$this->content['resttimetotal'] = $restTime;
			$this->content['restpercent'] = round(($restTime - $timer) / $restTime * 100);
		}

		$this->content['cost_change_graphic'] = Page::$data['costs']['clan']['change_graphic'];
		$this->content['cost_change_name'] = Page::$data['costs']['clan']['change_name'];

		$this->content['clan']['points_next'] = Page::$data['clanexptable'][$this->content['clan']['level']];
		$this->content['clan']['points_percent'] = round(($this->content['clan']['points']) / $this->content['clan']['points_next'] * 100);
		$this->content['clan']['rank'] = Page::$data['clanranks'][Clan::$clan->level];

		$this->content['clan']['attackdt'] = date('d.m.Y H:i', strtotime(Clan::$clan->attackdt));
		$this->content['clan']['defencedt'] = date('d.m.Y H:i', strtotime(Clan::$clan->defencedt));

		$this->content['window-name'] = ClanLang::$windowTitle;
		$this->page->addPart('content', 'clan/clan.xsl', $this->content);
	}

	/**
	 * Отображение состава клана и его редактирование
	 * отображение - для всех, редактирование - для клавы
	 */
	protected function showTeam() {
		if ($this->url[2] == "canceltitle" && $_SERVER['REQUEST_METHOD'] == 'POST') {
			$price = 5000;
			if (self::$clan->money < 5000) {
				Page::addAlert(ClanLang::$error, ClanLang::$errorNoMoney, ALERT_ERROR);
				Std::redirect('/clan/profile/team/');
			}
			self::$clan->money -= $price;
			self::$clan->save(self::$clan->id, array(clanObject::$MONEY));

			self::sendClanLog('tmct', array('p' => self::$player->exportForLogs(), 'm' => $price, 'r' => self::$player->clan_status));

			self::$player->clan_status = 'accepted';
			self::$player->save(self::$player->id, array(playerObject::$CLAN_STATUS));

			Std::redirect('/clan/profile/team/');
		}

		Clan::$clan->load(Clan::$player->clan);
		Clan::$clan->loadFull();
		$this->content['player'] = self::$player->toArray();
		if (is_a(Clan::$clan, 'clanObject')) {
			$this->content['clan'] = Clan::$clan->toArray();
			$this->content['clan']['morepeopleprice']['ore'] = Clan::getExpandOfficePrice();
			$this->content['clan']['morepeopleprice']['money'] = (int) $this->content['clan']['morepeopleprice']['ore'] * 100;
		} else {
			//$this->content['player']['fractionTitle'] = Page::$data['fractions']['plural'][$this->content['player']['fraction']];
		}

		$this->content['atwar'] = self::$clan->isAtWar(self::$clan->id) ? 1 : 0;

		$this->content['people'] = self::hasRole('people');
		$this->content['money'] = self::hasRole('money');
		$this->content['founder'] = self::hasRole('founder');

		foreach ($this->clanRoles as $role) {
			$this->content['cur'][$role] = array('id' => 0);
		}
		foreach (self::$clan->players as $player) {
			if (in_array($player['clan_status'], $this->clanRoles)) {
				$this->content['cur'][$player['clan_status']] = $player;
			}
		}

		$this->content['window-name'] = ClanLang::$windowTitleTeam;
		$this->page->addPart('content', 'clan/team.xsl', $this->content);
	}

	/**
	 * Отображение дипломатии клана и ее редактирование
	 * отображение - для всех, редактирование - для главы
	 */
	protected function showDiplomacy() {
		Std::loadMetaObjectClass('diplomacy');

		Clan::$clan->load(Clan::$player->clan);
		Clan::$clan->loadFull();
		$this->content['player'] = self::$player->toArray();
		if (is_a(Clan::$clan, 'clanObject')) {
			$this->content['clan'] = Clan::$clan->toArray();
			$this->content['clan']['morepeopleprice'] = Clan::getExpandOfficePrice();
		} else {
			//$this->content['player']['fractionTitle'] = Page::$data['fractions']['plural'][$this->content['player']['fraction']];
		}

		$this->content['clan']['diplomacy'] = self::$sql->getRecordSet("
            (SELECT d.id diplomacy, d.clan1, d.clan2, d.type, d.state, d.dt, d.dt2, d.parent_diplomacy, c.name, c.fraction, c.id FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.clan2=" . Clan::$clan->id . " AND d.state IN ('accepted','proposal','paused','step1','step2'))
            UNION
            (SELECT d.id diplomacy, d.clan1, d.clan2, d.type, d.state, d.dt, d.dt2, d.parent_diplomacy, c.name, c.fraction, c.id FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.clan1=" . Clan::$clan->id . " AND d.state IN ('accepted','proposal','paused','step1','step2'))
        ");

		$myUnions = 0;
		if (is_array($this->content['clan']['diplomacy']) && count($this->content['clan']['diplomacy']))
			foreach ($this->content['clan']['diplomacy'] as $diplomacy) {
				if ($diplomacy['type'] == 'union' && $diplomacy['state'] == 'accepted') {
					$myUnions++;
				}
			}
		$this->content['myunions'] = $myUnions;

		$this->content['myclan']['war'] = diplomacyObject::isAtActiveWar(self::$clan->id);

		if ($this->content['clan']['diplomacy']) {
			Std::loadLib('HtmlTools');
			$dip = array();
			foreach ($this->content['clan']['diplomacy'] as $d) {
				if ($d['type'] == 'war') {
					$d['surrender'] = $d['exit'] = 0;
					if ($d['parent_diplomacy'] == 0) {
						$d['surrender'] = 1;
					} else {
						$parentDiplomacyClans = self::$sql->getRecord("SELECT clan1, clan2 FROM diplomacy WHERE id=" . $d['parent_diplomacy']);
						if (self::$clan->id != $parentDiplomacyClans['clan1'] && self::$clan->id != $parentDiplomacyClans['clan2']) {
							$d['exit'] = 1;
						}
					}
				}
				if (($d['type'] == 'war' && $d['state'] == 'proposal' && $d['clan1'] != self::$clan->id) || ($d['type'] == 'war' && $d['state'] == 'finished')) {
					continue;
				}
				$d['dt2'] = HtmlTools::FormatDateTime($d['dt2'], true, true, true);
				$d['dt'] = HtmlTools::FormatDateTime($d['dt'], true, true, true);
				$dip[] = $d;
			}
			$this->content['clan']['diplomacy'] = $dip;
		}

		$this->content['atwar'] = self::$clan->isAtWar(self::$clan->id) ? 1 : 0;

		$this->content['diplomat'] = self::hasRole('diplomat');

		$this->content['cost_hire_detective'] = Page::$data['costs']['clan']['hire_detective'];

		$this->content['window-name'] = ClanLang::$windowTitleDiplomacy;
		$this->page->addPart('content', 'clan/diplomacy.xsl', $this->content);
	}

	/**
	 * Страница улучшений клановых зданий
	 */
	protected function showUpgrade() {
		Clan::$clan->load(Clan::$player->clan);
		Clan::$clan->loadFull();
		self::$clan->loadInventory();

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code']) && isset($_POST['inventory'])) {
			$code = preg_replace('/[^\w]/', '', $_POST['code']);
			$inventoryId = (int) $_POST['inventory'];
			if (self::hasRole('money')) {
				if (isset(self::$clan->inventory[$code])) {
					$item = self::$clan->inventory[$code];
					$upgrade = self::$sql->getRecord("SELECT * FROM standard_item WHERE code='" . $item->code . "' AND itemlevel=" . ($item->itemlevel + 1) . " AND upgradable=1");
					if (self::$clan->level < $upgrade['clanlevel']) {
						Page::addAlert(ClanLang::$error, ClanLang::$errorLowClanLevel, ALERT_ERROR);
					} else if ($upgrade && self::$clan->money >= $upgrade['money'] &&
							(self::$clan->ore + self::$clan->honey) >= $upgrade['ore'] && self::$clan->honey >= $upgrade['honey']) {
						// трата денег
						self::$clan->money -= $upgrade['money'];
						self::$clan->honey -= $upgrade['honey'];
						if (self::$clan->ore >= $upgrade['ore']) {
							self::$clan->ore -= $upgrade['ore'];
						} else {
							$priceOre = self::$clan->ore;
							self::$clan->ore = 0;
							self::$clan->honey -= ( $upgrade['ore'] - $priceOre);
						}
						self::$clan->save(self::$clan->id, array(clanObject::$MONEY, clanObject::$ORE, clanObject::$HONEY));

						// улучшение вещи
						$item->name = $upgrade['name'];
						$item->code = $upgrade['code'];
						$item->itemlevel = $upgrade['itemlevel'];
						$item->info = $upgrade['info'];
						$item->money = $upgrade['money'];
						$item->ore = $upgrade['ore'];
						$item->honey = $upgrade['honey'];
						$item->image = $upgrade['image'];
						$item->standard_item = $upgrade['id'];
						$item->save($item->id);

						// запоминание атаки/защиты
						if ($code == 'clan_attack') {
							self::$clan->attack = $upgrade['itemlevel'];
						} elseif ($code == 'clan_defence') {
							self::$clan->defence = $upgrade['itemlevel'];
						}
						self::$clan->save(self::$clan->id, array(clanObject::$ATTACK, clanObject::$DEFENCE));

						self::sendClanLog('upgr', array('p' => self::$player->exportForLogs(), 'i' => array('n' => $item->name, 'm' => (int) $item->money, 'o' => (int) $item->ore, 'h' => (int) $item->honey)));
						Page::addAlert(ClanLang::$alertUpgrade, Lang::renderText(ClanLang::$alertUpgradeText, array('name' => $item->name)));

						//Page::$cache->delete('clan_boosts/' . Page::$player->clan);
						CacheManager::delete('clan_boosts', array('clan_id' => Page::$player->clan));
					} else {
						Page::addAlert(ClanLang::$error, ClanLang::$errorNoMoney, ALERT_ERROR);
					}
				}
			} else {
				Page::addAlert(ClanLang::$error, ClanLang::$errorNoRightsMoney, ALERT_ERROR);
			}
			Std::redirect('/clan/profile/upgrade/' . $code . '/', true);
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['param'])) {
			Std::loadMetaObjectClass('diplomacy');
			if ($_POST['code'] == 'clan_pacifistcert' && isset(self::$clan->inventory['clan_pacifistcert']) && !diplomacyObject::isAtWar(self::$clan->id)) {
				if (is_string(self::$clan->data)) {
					self::$clan->data = json_decode(self::$clan->data, true);
				}
				self::$clan->createDataArray('wpt', 0);
				self::$clan->data['wpt'] = (int) $_POST['param'];
				self::$clan->data = json_encode(self::$clan->data);
				self::$clan->save(self::$clan->id, array(clanObject::$DATA));
				Page::addAlert('Время ненападения', 'Время ненападения установлено на: <b>' . (int) $_POST['param'] . ':40 — ' . (((int) $_POST['param'] + self::$clan->inventory[$_POST['code']]->itemlevel) % 24) . ':40</b>.');
			}
			Std::redirect('/clan/profile/upgrade/' . $_POST['code'] . '/', true);
		}

		$code = preg_replace('/[^\w]/', '', $this->url[2]);

		if (!isset(self::$clan->inventory[$code])) {
			Std::redirect('/clan/profile/', true);
		}
		$this->content['code'] = $code;
		$this->content['inventory'] = self::$clan->inventory[$code]->id;
		$this->content['current'] = self::$clan->inventory[$code]->toArray();
		$this->content['next'] = self::$sql->getRecord("SELECT * FROM standard_item WHERE code='" . self::$clan->inventory[$code]->code . "' AND itemlevel=" . (self::$clan->inventory[$code]->itemlevel + 1) . " AND upgradable=1");
		$this->content['maxlevels'] = self::$sql->getValue("SELECT count(*) FROM standard_item WHERE code='" . self::$clan->inventory[$code]->code . "' AND upgradable=1");
		$this->content['percentlevel'] = round(self::$clan->inventory[$code]->itemlevel / (int) $this->content['maxlevels'] * 100);

		if ($code == 'clan_pacifistcert') {
			Std::loadMetaObjectClass('diplomacy');
			if (is_string(self::$clan->data)) {
				self::$clan->data = json_decode(self::$clan->data, true);
			}
			if (diplomacyObject::isAtWar(self::$clan->id)) {
				$this->content['war'] = 1;
			} else {
				$wpt = '';
				for ($i = 0; $i < 24; $i++) {
					$wpt .= '<option value="' . $i . '" ' . ($i == self::$clan->data['wpt'] ? 'selected="selected"' : '') . '>' . $i . ':40 — ' . (($i + self::$clan->inventory[$code]->itemlevel) % 24) . ':40</option>';
				}
				$this->content['wptselect'] = $wpt;
				$this->content['war'] = 0;
			}
			$this->content['wpt'] = (int) self::$clan->data['wpt'];
			$this->content['wpt2'] = ((int) self::$clan->data['wpt'] + self::$clan->inventory[$code]->itemlevel) % 24;
		}

		$this->content['player'] = self::$player->toArray();

		$this->content['capacity'] = self::$clan->inventoryCapacity;
		$this->content['amount'] = self::$clan->inventoryAmount;

		$this->content['playerid'] = self::$player->id;
		$this->content['clanfounder'] = self::$clan->founder;

		$this->content['money'] = self::hasRole('money');
		$this->content['diplomat'] = self::hasRole('diplomat');

		$this->content['window-name'] = ClanLang::$windowTitleUpgrade;
		$this->page->addPart('content', 'clan/upgrade.xsl', $this->content);
	}

	/**
	 * Склад клана
	 */
	protected function showWarehouse() {
		Clan::$clan->load(Clan::$player->clan);
		Clan::$clan->loadFull();
		self::$clan->loadInventory();

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['inventory']) && isset($_POST['code'])) || isset($_POST['upgrade'])) {
			Page::startTransaction('clan_showwarehouse');
			$code = preg_replace('/[^\w]/', '', $_POST['code']);
			$inventoryId = (int) $_POST['inventory'];
			if ($this->url[2] == 'take') {
				if (isset(self::$clan->inventory[$code])) {
					$item = self::$clan->inventory[$code];
					self::$player->loadInventory();
					if (self::$player->hasFreeSpaceForItem($item->standard_item, $item->stackable, 1)) {
						self::$player->giveItems($item->standard_item, 1);
						/*
						  $myItem = self::$player->getItemByCode($code);
						  if ($myItem && $myItem->durability < Page::$data["inventory"]["itemsinslot"]) {
						  $myItem->durability++;
						  $myItem->maxdurability++;
						  $myItem->save($myItem->id, array(inventoryObject::$DURABILITY, inventoryObject::$MAXDURABILITY));
						  } else {
						  $myItem = clone $item;
						  $myItem->id = 0;
						  $myItem->player = self::$player->id;
						  $myItem->durability = 1;
						  $myItem->maxdurability = 1;
						  $myItem->save();
						  }
						 */

						if ($item->durability > 1) {
							$item->durability--;
							$item->maxdurability--;
							$item->save($item->id, array(inventoryObject::$DURABILITY, inventoryObject::$MAXDURABILITY));
						} else {
							self::$sql->query("DELETE FROM inventory WHERE id=" . $item->id);
						}
						self::sendClanLog('take', array('p' => self::$player->exportForLogs(), 'i' => $item->name));
						echo 1;
					} else {
						echo -1;
					}
				} else {
					echo 0;
				}
			} elseif ($this->url[2] == 'put') {
				if (self::$clan->inventoryAmount < self::$clan->inventoryCapacity || isset(self::$clan->inventory[$code])) {
					self::$player->loadInventory();
					//$myItem = self::$player->getItemByCode($code);
					$myItem = self::$player->getItemById($inventoryId);
					if ($myItem) {
						if (isset(self::$clan->inventory[$code])) {
							$item = self::$clan->inventory[$code];
							$item->durability++;
							$item->maxdurability++;
							$item->save($item->id, array(inventoryObject::$DURABILITY, inventoryObject::$MAXDURABILITY));
						} else {
							$item = clone $myItem;
							$item->id = 0;
							$item->player = 0;
							$item->durability = 1;
							$item->maxdurability = 1;
							$item->clan = self::$player->clan;
							$item->save();
						}

						if ($myItem->durability > 1) {
							$myItem->durability--;
							$myItem->maxdurability--;
							$myItem->save($myItem->id, array(inventoryObject::$DURABILITY, inventoryObject::$MAXDURABILITY));
						} else {
							self::$sql->query("DELETE FROM inventory WHERE id=" . $myItem->id);
						}
						self::sendClanLog('put', array('p' => self::$player->exportForLogs(), 'i' => $myItem->name));
						echo 1;
					} else {
						echo 0;
					}
				} else {
					echo -1;
				}
			} elseif ($this->url[2] == 'upgrade') {
				$upgrade = self::$sql->getRecord("SELECT * FROM standard_item WHERE code='clan_warehouse2'");
				if ($upgrade && isset(self::$clan->inventory['clan_warehouse']) && self::$clan->money >= $upgrade['money'] && (self::$clan->ore + self::$clan->honey) >= $upgrade['ore'] && self::$clan->honey >= $upgrade['honey']) {
					// трата денег
					self::$clan->money -= $upgrade['money'];
					self::$clan->honey -= $upgrade['honey'];
					if (self::$clan->ore >= $upgrade['ore']) {
						self::$clan->ore -= $upgrade['ore'];
					} else {
						$priceOre = self::$clan->ore;
						self::$clan->ore = 0;
						self::$clan->honey -= ( $upgrade['ore'] - $priceOre);
					}
					self::$clan->save(self::$clan->id, array(clanObject::$MONEY, clanObject::$ORE, clanObject::$HONEY));

					self::$clan->inventory['clan_warehouse']->itemlevel += $upgrade['itemlevel'];
					self::$clan->inventory['clan_warehouse']->save(self::$clan->inventory['clan_warehouse']->id, array(inventoryObject::$ITEMLEVEL));

					Page::addAlert('Склад расширен', 'Клановый склад успешно расширен. Теперь Вы можете аккуратно расставить по полкам еще пару коробок с барахлом.');
				} else {
					Page::addAlert(ClanLang::$error, ClanLang::$errorNoMoney, ALERT_ERROR);
				}
				Std::redirect('/clan/profile/warehouse/');
			}
			Page::endTransaction('clan_showwarehouse');
			exit;
		}

		self::$player->loadInventory();
		$this->content['player'] = self::$player->toArray();
		$this->content['player']["capacity"] = self::$player->capacity;
		$this->content['player']["amount"] = self::$player->inventoryAmount;

		$this->content['capacity'] = self::$clan->inventoryCapacity;
		$this->content['amount'] = self::$clan->inventoryAmount;

		// инвентарь
		Std::loadMetaObjectClass('inventory');
		$this->content['inventory'] = array();

		$criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(inventoryObject::$CLAN, ObjectCollectionCriteria::$COMPARE_EQUAL, self::$clan->id);
		$criteria->createWhere(inventoryObject::$PLAYER, ObjectCollectionCriteria::$COMPARE_EQUAL, 0);
		$criteria->createWhere(inventoryObject::$MAXDURABILITY, ObjectCollectionCriteria::$COMPARE_GREATER, 0);

		$inventory = new ObjectCollection();
		$inventory = $inventory->getArrayList(inventoryObject::$METAOBJECT, $criteria, array(inventoryObject::$ID, inventoryObject::$CODE, inventoryObject::$IMAGE, inventoryObject::$NAME, inventoryObject::$INFO, inventoryObject::$DURABILITY, inventoryObject::$STACKABLE, inventoryObject::$STANDARD_ITEM));
		if ($inventory) {
			foreach ($inventory as $item) {
				//$itemArray = $item->toArray();
				//switch ($itemArray['code']) {
				//case 'clan_warehouse':
				//    $itemArray['param'] = 'Вместимость';
				//    $itemArray['value'] = $itemArray['itemlevel'];
				//    break;
				//}
				$this->content['inventory'][] = $item; //Array;
			}
		}

		// взятые вещи (в моем инвентаре)
		$this->content['inventory2'] = array();

		$criteria = new ObjectCollectionCriteria();
		$criteria->createWhere(inventoryObject::$PLAYER, ObjectCollectionCriteria::$COMPARE_EQUAL, self::$player->id);
		$criteria->createWhere(inventoryObject::$TYPE2, ObjectCollectionCriteria::$COMPARE_EQUAL, 'clan');
		$criteria->createWhere(inventoryObject::$MAXDURABILITY, ObjectCollectionCriteria::$COMPARE_GREATER, 0);

		$inventory = new ObjectCollection();
		$inventory = $inventory->getObjectList(inventoryObject::$METAOBJECT, $criteria);
		if ($inventory) {
			foreach ($inventory as $item) {
				$itemArray = $item->toArray();
				switch ($itemArray['code']) {
					//case 'clan_warehouse':
					//    $itemArray['param'] = 'Вместимость';
					//    $itemArray['value'] = $itemArray['itemlevel'];
					//    break;
				}
				$this->content['inventory2'][] = $itemArray;
			}
		}

		// логи
		$logs = self::$sql->getRecordSet("SELECT DATE_FORMAT(dt, '%d.%m.%Y %H:%i') dt, action, params FROM clanlog WHERE clan=" . self::$clan->id . " AND (action='take' OR action='put') ORDER BY id DESC LIMIT 0, 5");
		if ($logs) {
			foreach ($logs as &$log) {
				$log['params'] = json_decode($log['params'], true);
			}
		}
		$this->content['log'] = $logs;

		$this->content['money'] = self::hasRole('money');

		$this->content['window-name'] = ClanLang::$windowTitleWarehouse;
		$this->page->addPart('content', 'clan/warehouse.xsl', $this->content);
	}

	/**
	 * Логи клана
	 */
	protected function showLogs() {
		Clan::$clan->load(Clan::$player->clan);
		//Clan::$clan->loadFull();
		//self::$clan->loadInventory();
		// логи
		if (is_numeric($this->url[2]) && $this->url[2] >= 1) {
			$page = (int) $this->url[2];
		} else {
			$page = 1;
		}
		$perPage = 20;
		$offset = ($page - 1) * $perPage;

		$logs = self::$sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS DATE_FORMAT(dt, '%d.%m.%Y %H:%i') dt, action, params FROM clanlog WHERE clan=" . self::$clan->id . " ORDER BY id DESC LIMIT " . $offset . ", " . $perPage);
		$total = self::$sql->getValue("SELECT found_rows()");

		$this->content['page'] = $page;
		$this->content['pages'] = Page::generatePages($page, ceil($total / $perPage), 3);

		Std::loadLib('HtmlTools');
		foreach ($logs as &$log) {
			$log['params'] = json_decode($log['params'], true);
			if ($log['params']['pts']) {
				$log['params']['pts_word'] = HtmlTools::russianNumeral($log['params']['pts'], 'балл', 'балла', 'баллов');
			}
		}
		$this->content['log'] = $logs;

		$this->content['window-name'] = ClanLang::$windowTitleLogs;
		$this->page->addPart('content', 'clan/logs.xsl', $this->content);
	}

	/**
	 * Статистика войны
	 *
	 * @param int $warId
	 */
	protected function showWarStats($warId) {
		Std::loadLib('HtmlTools');
		Std::loadMetaObjectClass('diplomacy');

		//Clan::$clan->load(Clan::$player->clan);
		//Clan::$clan->loadFull();
		//self::$clan->loadInventory();

		$dip = new diplomacyObject();
		$dip->load($warId, false);
		if ($dip->parent_diplomacy) {
			$dip2 = new diplomacyObject();
			$dip2->load($dip->parent_diplomacy);
			if (self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE type='union' AND state='accepted' AND
                ((clan1=" . self::$clan->id . " AND clan2=" . $dip2->clan1 . ") OR (clan2=" . self::$clan->id . " AND clan1=" . $dip2->clan1 . "))")) {
				$clanId = $dip2->clan1;
			} else {
				$clanId = $dip2->clan2;
			}
			$dip = $dip2;
		} else {
			$clanId = $dip->clan1 == self::$clan->id ? $dip->clan1 : $dip->clan2;
		}
		$clanId = $dip->clan1;

		$this->content['war'] = $dip->toArray();
		$this->content['war']['dt2'] = HtmlTools::FormatDateTime($this->content['war']['dt2'], true, true, true);

		//$mySide = $dip->clan1 == $clanId ? 'a' : 'd';
		//$enemySide = $mySide == 'a' ? 'd' : 'a';
		$mySide = 'a';
		$enemySide = 'd';

		$clan1 = new clanObject();
		$clan1->load($dip->clan1);
		$this->content['clan1'] = $clan1->exportForDB();

		$clan2 = new clanObject();
		$clan2->load($dip->clan2);
		$this->content['clan2'] = $clan2->exportForDB();

		$this->content['left'] = $clan1->id == $clanId ? $clan1->exportForDB() : $clan2->exportForDB();
		$this->content['right'] = $clan1->id == $clanId ? $clan2->exportForDB() : $clan1->exportForDB();

		$this->content['left']['profit']['money'] = $dip->data[$enemySide . 'rm'];
		$this->content['left']['profit']['ore'] = $dip->data[$enemySide . 'ro'];
		$this->content['left']['profit']['honey'] = $dip->data[$enemySide . 'rh'];
		$this->content['left']['risks']['money'] = $dip->data[$mySide . 'rm'];
		$this->content['left']['risks']['ore'] = $dip->data[$mySide . 'ro'];
		$this->content['left']['risks']['honey'] = $dip->data[$mySide . 'rh'];

		$this->content['stats1'] = $dip->getWarKillsStats($clanId, 'step1');
		$this->content['stats2'] = $dip->getWarKillsStats($clanId, 'step2');

		$pps = array();
		$pps2 = array();
		
		// список убийств
		if ($dip->state == 'step1' || $dip->state == 'step2' || $dip->state == 'finished') {
			//вклад в войну
			$this->content['left']['players'] = array();
			foreach ($dip->data[$mySide] as $playerId => $player) {
				if (!isset($pps[$playerId])) {
					$p2 = new playerObject();
					$p2->load($playerId);
					$pps[$playerId] = $p2;
				}
				$p = $pps[$playerId];

				$zub = array();
				foreach ($player['kd'] as $murder) {
					if (!isset($pps2[$murder['p']])) {
						$pps2[$murder['p']] = self::$sql->getRecord("SELECT nickname, clan_status, accesslevel FROM player WHERE id=" . $murder['p']);
					}
					$p1 = $pps2[$murder['p']];
					if ($murder['dl'] == "voodoo") {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth-green', 'dl' => '', 'sk' => '');
					} else {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth' . ($p1['clan_status'] == 'founder' ? '-golden' : ''), 'dl' => $murder['dl'], 'sk' => Page::generateKeyForDuel($murder['dl']));
					}
				}

				$myZub = array();
				foreach ($player['kdby'] as $murder) {
					if ($murder['dl'] == "voodoo") {
						$myZub[] = array('dl' => '', 'class' => 'tooth-green', 'sk' => '');
					} else {
						$myZub[] = array('dl' => $murder['dl'], 'class' => 'tooth-black', 'sk' => Page::generateKeyForDuel($murder['dl']));
					}
				}
				if (sizeof($player['kdby']) < $player['ks']) {
					for ($i = 0, $j = $player['ks'] - sizeof($player['kdby']); $i < $j; $i++) {
						$myZub[] = array('name' => '', 'class' => 'tooth-outline', 'dl' => '');
					}
				}

				$this->content['left']['players'][] = array(
					'player' => $p->exportForLogs(),
					'accesslevel' => $p->accesslevel,
					'al' => isset($player['al']) ? $player['al'] : 0,
					'zub' => $zub,
					'myzub' => $myZub,
					'u' => 0,
				);
			}
			foreach ($dip->data[$mySide . 'u'] as $playerId => $kills) {
				if (!isset($pps[$playerId])) {
					$p2 = new playerObject();
					$p2->load($playerId);
					$pps[$playerId] = $p2;
				}
				$p = $pps[$playerId];

				$zub = array();
				foreach ($kills as $kill) {
					if (!isset($pps2[$kill['p']])) {
						$pps2[$kill['p']] = self::$sql->getRecord("SELECT nickname, clan_status, accesslevel FROM player WHERE id=" . $kill['p']);
					}
					$p1 = $pps2[$kill['p']];
					if ($kill['dl'] == "voodoo") {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth-green', 'dl' => '', 'sk' => '');
					} else {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth' . ($p1['clan_status'] == 'founder' ? '-golden' : ''), 'dl' => $kill['dl'], 'sk' => Page::generateKeyForDuel($kill['dl']));
					}
				}

				$this->content['left']['players'][] = array(
					'player' => $p->exportForLogs(),
					'zub' => $zub,
					'myzub' => array(),
					'u' => 1,
				);
			}

			$this->content['right']['players'] = array();
			foreach ($dip->data[$enemySide] as $playerId => $player) {
				if (!isset($pps[$playerId])) {
					$p2 = new playerObject();
					$p2->load($playerId);
					$pps[$playerId] = $p2;
				}
				$p = $pps[$playerId];

				$zub = array();
				foreach ($player['kd'] as $murder) {
					if (!isset($pps2[$murder['p']])) {
						$pps2[$murder['p']] = self::$sql->getRecord("SELECT nickname, clan_status, accesslevel FROM player WHERE id=" . $murder['p']);
					}
					$p1 = $pps2[$murder['p']];
					if ($murder['dl'] == "voodoo") {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth-green', 'dl' => '', 'sk' => '');
					} else {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth' . ($p1['clan_status'] == 'founder' ? '-golden' : ''), 'dl' => $murder['dl'], 'sk' => Page::generateKeyForDuel($murder['dl']));
					}
				}

				$myZub = array();
				foreach ($player['kdby'] as $murder) {
					if ($murder['dl'] == "voodoo") {
						$myZub[] = array('dl' => '', 'class' => 'tooth-green', 'sk' => '');
					} else {
						$myZub[] = array('dl' => $murder['dl'], 'class' => 'tooth-black', 'sk' => Page::generateKeyForDuel($murder['dl']));
					}
				}
				if (sizeof($player['kdby']) < $player['ks']) {
					for ($i = 0, $j = $player['ks'] - sizeof($player['kdby']); $i < $j; $i++) {
						$myZub[] = array('name' => '', 'class' => 'tooth-outline', 'dl' => '');
					}
				}

				$this->content['right']['players'][] = array(
					'player' => $p->exportForLogs(),
					'accesslevel' => $p->accesslevel,
					'al' => isset($player['al']) ? $player['al'] : 0,
					'zub' => $zub,
					'myzub' => $myZub,
					'u' => 0,
				);
			}
			foreach ($dip->data[$enemySide . 'u'] as $playerId => $kills) {
				if (!isset($pps[$playerId])) {
					$p2 = new playerObject();
					$p2->load($playerId);
					$pps[$playerId] = $p2;
				}
				$p = $pps[$playerId];

				$zub = array();
				foreach ($kills as $kill) {
					if (!isset($pps2[$kill['p']])) {
						$pps2[$kill['p']] = self::$sql->getRecord("SELECT nickname, clan_status, accesslevel FROM player WHERE id=" . $kill['p']);
					}
					$p1 = $pps2[$kill['p']];
					if ($kill['dl'] == "voodoo") {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth' . ($p1['clan_status'] == 'founder' ? '-golden' : ''), 'dl' => '', 'sk' => '');
					} else {
						$zub[] = array('name' => $p1['nickname'], 'class' => 'tooth' . ($p1['clan_status'] == 'founder' ? '-golden' : ''), 'dl' => $kill['dl'], 'sk' => Page::generateKeyForDuel($kill['dl']));
					}
				}

				$this->content['right']['players'][] = array(
					'player' => $p->exportForLogs(),
					'zub' => $zub,
					'myzub' => array(),
					'u' => 1,
				);
			}
		}

		if ($dip->state == 'step1') {
			// надо убить
			$this->content['right']['kill'] = array();
			foreach ($dip->data[$enemySide] as $playerId => $player) {
				if ($player['ks'] < Page::$data['diplomacy']['kills']) {
					if (!isset($pps[$playerId])) {
						$p2 = new playerObject();
						$p2->load($playerId);
						$pps[$playerId] = $p2;
					}
					$p = $pps[$playerId];

					if ($p->accesslevel >= 0) {
						$this->content['right']['kill'][] = array(
							'player' => $p->exportForLogs(),
						);
					}
				}
			}
		}

		// групповые бои
		if ($dip->state == 'step2' || $dip->state == 'finished') {
			$sql = "SELECT f.id, f.dt dt, f.results, f.state FROM fight f WHERE diplomacy = " . $dip->id . " ORDER BY f.id DESC";
			$fights = Page::$sql->getRecordSet($sql);
			if (is_array($fights) && count($fights)) {
				foreach ($fights as &$f) {
					$f['dt'] = HtmlTools::FormatDateTime($f['dt'], true, true, false, false);
					$f['results'] = json_decode($f['results'], true);
					if ($f['results']['w'] == 'a') {
						$f['winner'] = 1;
					} else if ($f['results']['w'] == 'd') {
						$f['winner'] = 2;
					} else {
						$f['winner'] = 0;
					}
				}
				$this->content['fightlogs'] = $fights;
			}
		}

		// расписание
		$timetable = array();
		$wpt = is_string($dip->data['wpt']) ? explode(',', substr($dip->data['wpt'], 0, -1)) : $dip->data['wpt'];
		for ($i = 0; $i < 24; $i++) {
			$classes = array();
			if ($i % 3 == 0) {
				$classes[] = 'fight-time';
			}
			$j = $i - 1;
			if ($j == -1) {
				$j = 23;
			}
			if (in_array($j, $wpt)) {
				$classes[] = 'pacifism-time';
			}
			$timetable[] = '<td class="' . implode(' ', $classes) . '">' . $i . '<br /><small>:00</small></td>';
		}
		$this->content['timetable'] = implode(' ', $timetable);

		if ($dip->state == 'finished') {
			$this->content['winner'] = $dip->data['w'] == $dip->clan1 ? $clan1->exportForDB() : ($dip->data['w'] == $dip->clan2 ? $clan2->exportForDB() : '');
			$this->content['looser'] = $dip->data['w'] == $dip->clan1 ? $clan2->exportForDB() : ($dip->data['w'] == $dip->clan2 ? $clan1->exportForDB() : '');
			if ($dip->data['w'] == $dip->clan1) {
				$this->content['results']['profit'] = $this->content['left']['profit'];
			} else if ($dip->data['w'] == $dip->clan2) {
				$this->content['results']['profit'] = $this->content['left']['risks'];
			}
		}

		$this->content['window-name'] = ClanLang::$windowTitleWarStats;
		$this->page->addPart('content', 'clan/warstats.xsl', $this->content);
	}

	/**
	 * Страница клана (внешняя)
	 *
	 * @param int $id
	 */
	protected function showClan($id) {
		self::$clan->loadFull();
		self::$clan->loadInventory();
		if (is_string(self::$clan->data)) {
			self::$clan->data = json_decode(self::$clan->data, true);
		}

		Std::loadMetaObjectClass('diplomacy');
		$warId = diplomacyObject::areAtWar(self::$player->clan, Clan::$clan->id);
		if ($warId) {
			$dip = new diplomacyObject();
			$dip->load($warId);
		}

		$this->content['player'] = self::$player->toArray();
		$this->content['player']['glava'] = $this->glavaKlana();
		$this->content['clan'] = self::$clan->toArray();
		foreach ($this->content['clan']['players'] as &$player) {
			if ($player['id'] == self::$clan->founder) {
				$this->content['clan']['founder'] = $player;
			}
		}

		// дипломатические отношения игрока (просматривающего страницу клана) с кланом
		$myDiplomacy = self::$sql->getRecord("SELECT type, state, clan1, clan2 FROM diplomacy WHERE (state='paused' OR state='step1' OR state='step2' OR state='proposal' OR state='accepted') AND
            ((clan1=" . self::$clan->id . " AND clan2=" . self::$player->clan . ") OR (clan2=" . self::$clan->id . " AND clan1=" . self::$player->clan . "))
            ORDER BY dt DESC LIMIT 0,1");
		$this->content['clan']['mydiplomacy'] = $myDiplomacy ? $myDiplomacy : array();
		$this->content['myclan'] = array('war' => self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE type='war' AND (state='paused' OR state='step1' OR state='step2') AND (clan1=" . self::$player->clan . " OR clan2=" . self::$player->clan . ")") > 0 ? 1 : 0);

		// дипломатия клана
		$this->content['clan']['diplomacy'] = self::$sql->getRecordSet("
            SELECT d.type, d.state, d.dt, d.dt2, c.name, c.fraction, c.id, d.id as dip_id, d.parent_diplomacy FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.clan2=" . Clan::$clan->id . " AND ((d.type='union' AND d.state='accepted') OR (d.type='war' AND (d.state='paused' OR d.state='step1' OR d.state='step2')))
            UNION
            SELECT d.type, d.state, d.dt, d.dt2, c.name, c.fraction, c.id, d.id as dip_id, d.parent_diplomacy FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.clan1=" . Clan::$clan->id . " AND ((d.type='union' AND d.state='accepted') OR (d.type='war' AND (d.state='paused' OR d.state='step1' OR d.state='step2')))"
		);

		// мой клан
		$myClan = self::$sql->getRecord("SELECT state, attackdt, attack, defence FROM clan WHERE id=" . self::$player->clan);

		// таймаут после последней войны
		$warDt = strtotime(self::$clan->data['wdt']);
		$regDt = strtotime(self::$clan->data['rdt']);
		$nowDt = time();
		$diff = $nowDt - $warDt;
		$diff2 = $nowDt - $regDt;
		$days = isset(self::$clan->data['wc']) && self::$clan->data['wc'] > 0 && self::$clan->data['wc'] == self::$player->clan ? 4 : 2;
		if (strtotime(self::$clan->defencedt) > time()) {
			$this->content['clan']['wartimeout'] = $days == 2 ? 1 : 3;
		} elseif ($diff2 < 14 * 24 * 60 * 60 && self::$clan->data['ww'] == 0 && self::$clan->data['wf'] == 0) {
			$this->content['clan']['wartimeout'] = 2;
		} elseif (strtotime($myClan['attackdt']) > time()) {
			$this->content['clan']['wartimeout'] = 0;
		}

		$this->content['clan']['unions'] = 0;
		if ($this->content['clan']['diplomacy']) {
			Std::loadLib('HtmlTools');
			foreach ($this->content['clan']['diplomacy'] as &$d) {
				$d['dt2'] = HtmlTools::FormatDateTime($d['dt2'], true, true, true);
				if ($d['type'] == 'union' && $d['state'] == 'accepted') {
					$this->content['clan']['unions']++;
				}
			}
		}
		$this->content['clan']['war'] = Clan::$clan->isAtWar() ? 1 : 0;

		// сооружения клана
		$this->content['clan']['attack'] = (int) self::$clan->attack;
		$this->content['clan']['defence'] = (int) self::$clan->defence;
		// время ненападения
		$this->content['clan']['wpt'] = isset(self::$clan->inventory['clan_pacifistcert']) ? (((int) self::$clan->data['wpt'] . ':40 — ' . ((int) self::$clan->data['wpt'] + self::$clan->inventory['clan_pacifistcert']->itemlevel) % 24) . ':40') : '';

		// сооружения моего клана
		$this->content['myclan']['attack'] = $myClan ? (int) $myClan['attack'] : 0;
		$this->content['myclan']['defence'] = $myClan ? (int) $myClan['defence'] : 0;
		$this->content['myclan']['unions'] = $myClan ? (int) self::$sql->getValue("SELECT count(*) FROM diplomacy WHERE type='union' AND (clan1=" . self::$player->clan . " OR clan2=" . self::$player->clan . ")") : 0;
		$this->content['myclan']['state'] = $myClan ? $myClan['state'] : '';
		$this->content['myclan']['attackdt'] = $myClan ? $myClan['attackdt'] : '';
		$this->content['myclan']['can_attack'] = ($myClan['state'] == 'war' || strtotime($myClan['attackdt']) > time()) ? 0 : 1;

		$this->content['player']['fractionTitle'] = Page::$data['fractions']['plural'][self::$player->fraction];
		//$this->content['clan']['rating'] = $this->sqlGetValue("SELECT COUNT(1) FROM `clan` WHERE exp > ") + 1;
		$this->content['clan']['rating'] = Clan::getData("clan/" . Clan::$clan->id . "/rating", "SELECT COUNT(1) FROM `rating_clan` WHERE `exp` > (SELECT `exp` FROM `rating_clan` WHERE `clan` = " . Clan::$clan->id . ")") + 1;
		$forumId = self::$sql->getValue("SELECT id FROM forum WHERE clan=" . Clan::$clan->id);
		if ($forumId) {
			$this->content['clan']['forum'] = $forumId;
		} else {
			$this->content['clan']['forum'] = self::$sql->getValue("SELECT id FROM forum WHERE clans LIKE '%[" . self::$player->clan . "]%'");
		}
		$this->content['clan']['info'] = nl2br($this->content['clan']['info']);

		$this->content['diplomat'] = self::hasRole('diplomat', self::$player->clan);

		if ($this->content['clan']['attackdt'] != '0000-00-00 00:00:00') {
			$this->content['clan']['attackdt'] = date('d.m.Y H:i:s', strtotime($this->content['clan']['attackdt']));
		} else {
			unset($this->content['clan']['attackdt']);
		}
		if ($this->content['clan']['defencedt'] != '0000-00-00 00:00:00') {
			$this->content['clan']['defencedt'] = date('d.m.Y H:i:s', strtotime($this->content['clan']['defencedt']));
		} else {
			unset($this->content['clan']['defencedt']);
		}

		/*
		$this->content['clan']['wars'] = Page::$sql->getRecordSet(
			"(SELECT d.id dip_id, d.data, c.id, c.name, c.level, c.fraction, d.dt2 " .
			"FROM diplomacy d force index (ix__diplomacy__clan1_type_state) LEFT JOIN clan c ON c.id = d.clan2 " .
			"WHERE d.clan1 = " . Clan::$clan->id . " " .
			"AND d.type = 'war' AND d.state = 'finished' AND d.parent_diplomacy = 0) " .
			"UNION ".
			"(SELECT d.id dip_id, d.data, c.id, c.name, c.level, c.fraction, d.dt2 " .
			"FROM diplomacy d force index (ix__diplomacy__clan2_type_state) LEFT JOIN clan c ON c.id = " . Clan::$clan->id . " " .
			"WHERE d.clan2 = " . Clan::$clan->id . " " .
			"AND d.type = 'war' AND d.state = 'finished' AND d.parent_diplomacy = 0) " .
			"ORDER BY dip_id DESC LIMIT 5");
		*/
		$this->content['clan']['wars'] = Page::$sql->getRecordSet(
			"(SELECT d.id dip_id, d.data, d.dt2, d.clan2 id " .
			"FROM diplomacy d force index (ix__diplomacy__clan1_type_state) " .
			"WHERE d.clan1 = " . Clan::$clan->id . " " .
			"AND d.type = 'war' AND d.state = 'finished' AND d.parent_diplomacy = 0) " .
			"UNION ".
			"(SELECT d.id dip_id, d.data, d.dt2, d.clan1 id " .
			"FROM diplomacy d force index (ix__diplomacy__clan2_type_state) " .
			"WHERE d.clan2 = " . Clan::$clan->id . " " .
			"AND d.type = 'war' AND d.state = 'finished' AND d.parent_diplomacy = 0) " .
			"ORDER BY dip_id DESC LIMIT 5");
		if (is_array($this->content['clan']['wars']) && count($this->content['clan']['wars'])) {
			$clanIds = array();
			foreach ($this->content['clan']['wars'] as $w) {
				if ($w['id']) {
					$clanIds[$w['id']] = 1;
				}
			}
			$clanIds = CacheManager::getSet('clan_shortinfo', 'clan_id', array_keys($clanIds));
			foreach ($this->content['clan']['wars'] as &$war) {
				$war = array_merge($war, $clanIds[$war['id']]);
				$war['data'] = json_decode($war['data'], true);
				if ($war['data']['w'] == Clan::$clan->id) {
					$war['result'] = 'win';
				} else if ($war['data']['w'] > 0) {
					$war['result'] = 'lose';
				} else {
					$war['result'] = 'draw';
				}
				$war['dt2'] = HtmlTools::FormatDateTime($war['dt2'], true, true, true);
			}
		}
		$this->content['clan']['rank'] = Page::$data['clanranks'][Clan::$clan->level];

		$this->content['window-name'] = ClanLang::$windowTitle;
		$this->page->addPart('content', 'clan/view.xsl', $this->content);
	}

	private function showClan2() {
		self::$clan->loadFull();
		self::$clan->loadInventory();
		self::$clan->data = json_decode(self::$clan->data, true);

		$this->content['clan'] = self::$clan->toArray();
		foreach ($this->content['clan']['players'] as &$player) {
			if ($player['id'] == self::$clan->founder) {
				$this->content['clan']['founder'] = $player;
			}
		}

		// дипломатия клана
		$this->content['clan']['diplomacy'] = self::$sql->getRecordSet("
            SELECT d.type, d.state, d.dt, d.dt2, c.name, c.fraction, c.id FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan1 WHERE d.clan2=" . Clan::$clan->id . " AND ((d.type='union' AND d.state='accepted') OR (d.type='war' AND (d.state='paused' OR d.state='step1' OR d.state='step2')))
            UNION
            SELECT d.type, d.state, d.dt, d.dt2, c.name, c.fraction, c.id FROM diplomacy d LEFT JOIN clan c ON c.id=d.clan2 WHERE d.clan1=" . Clan::$clan->id . " AND ((d.type='union' AND d.state='accepted') OR (d.type='war' AND (d.state='paused' OR d.state='step1' OR d.state='step2')))"
		);

		$this->content['clan']['war'] = Clan::$clan->isAtWar() ? 1 : 0;

		// сооружения клана
		$this->content['clan']['attack'] = (int) self::$clan->attack;
		$this->content['clan']['defence'] = (int) self::$clan->defence;
		// время ненападения
		$this->content['clan']['wpt'] = isset(self::$clan->inventory['clan_pacifistcert']) ? (((int) self::$clan->data['wpt'] . ':40 — ' . ((int) self::$clan->data['wpt'] + self::$clan->inventory['clan_pacifistcert']->itemlevel) % 24) . ':40') : '';

		$this->content['clan']['rating'] = Clan::getData("clan/" . Clan::$clan->id . "/rating", "SELECT COUNT(1) FROM `rating_clan` WHERE `exp` > (SELECT `exp` FROM `rating_clan` WHERE `clan` = " . Clan::$clan->id . ")") + 1;
		$this->content['clan']['forum'] = $this->sqlGetValue("SELECT id FROM forum WHERE clan=" . Clan::$clan->id . " LIMIT 1");
		$this->content['clan']['info'] = nl2br($this->content['clan']['info']);
		$this->content['clan']['rank'] = Page::$data['clanranks'][Clan::$clan->level];

		$this->content['window-name'] = ClanLang::$windowTitle;
		$this->page->addPart('content', 'clan/view.xsl', $this->content);
	}

	/**
	 * Страница покупки усилений для клана
	 */
	private function showBanzai() {
		if (Clan::$clan->state == 'rest') {
			Std::redrect('/clan/profile/');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ((int) self::$sql->getValue("SELECT count(*) FROM boost WHERE clan=" . self::$clan->id) == 0) {
				Std::loadMetaObjectClass('boost');

				$hours = (int) $_POST['hours'];
				$hours = $hours > 8 ? 8 : $hours;

				$boosts = array();

				if ($hours > 0) {
					$log = array('b' => array());

					foreach ($_POST['boost'] as $boost => $value) {
						if (!is_numeric($value) || ($value % 5) != 0) {
							$value = 0;
						}
						$value = $value > 100 ? 100 : $value;
						$value = $value < 0 ? 0 : $value;

						if ($value > 0 && (array_key_exists($boost, Page::$data['stats']) || array_key_exists($boost, Page::$data['ratings']))) {
							$b = new boostObject();
							$b->clan = self::$clan->id;
							$b->player = 0;
							$b->fraction = '';
							$b->type = array_key_exists($boost, Page::$data['stats']) ? 'stat' : 'rating';
							$b->code = $boost;
							$b->value = $value;
							$b->dt = date('Y-m-d H:i:s', time());
							$b->dt2 = date('Y-m-d H:i:s', time() + ($hours * 60 * 60));
							$b->info = ClanLang::$boostInfo;
							$boosts[] = $b;

							$log['b'][] = array('c' => Page::$data['ratings'][$boost]['short'], 'v' => $value);
						}
					}

					$multiRatingKoef = 0.5;
					for ($i = 0, $j = sizeof($boosts); $i < $j; $i++) {
						$ratingValue = $boosts[$i]->value;
						$ratingKoef = $ratingValue ? (1 + (($ratingValue / 5 - 1) * 0.2 + 1)) / 2 : 0;
						$timeKoef = (1 + ($hours - 1) * 0.2 + 1) / 2;
						$singleRatingCost = floor($ratingKoef * 75 * $ratingValue * $timeKoef * $hours);
						$multiRatingKoef += $ratingValue > 0 ? 0.5 : 0;
						$clanAffectsCostSum = $clanAffectsCostSum + $singleRatingCost;
					}
					$clanAffectsCostSum = floor($clanAffectsCostSum * $multiRatingKoef);

					if ($clanAffectsCostSum <= self::$clan->money) {
						self::$clan->money -= $clanAffectsCostSum;
						self::$clan->save(self::$clan->id, array(clanObject::$MONEY));

						foreach ($boosts as $b) {
							$b->save();
						}
					}

					//Page::$cache->delete('clan_boosts/' . Page::$player->clan);
					CacheManager::delete('clan_boosts', array('clan_id' => Page::$player->clan));

					$log['p'] = self::$player->exportForLogs();
					$log['h'] = $hours;
					$log['m'] = $clanAffectsCostSum;
					Clan::sendClanLog('bst', $log);
				}
			}
			Std::redirect('/clan/profile/banzai/');
		}

		$boosts = self::$sql->getRecordSet("SELECT * FROM boost WHERE clan=" . self::$clan->id);

		if ($boosts) {
			$this->content['banzai'] = 1;

			$timer = strtotime($boosts[0]['dt2']) - time();
			$banzaiTime = strtotime($boosts[0]['dt2']) - strtotime($boosts[0]['dt']);

			$this->content['banzaitimeleft'] = $timer > 0 ? $timer : 0;
			$this->content['banzaitimeleft2'] = date('H:i:s', $timer);
			$this->content['banzaitimetotal'] = $banzaiTime;
			$this->content['banzaipercent'] = round(($banzaiTime - $timer) / $banzaiTime * 100);

			$curBoosts = array('ratingaccur' => 0, 'ratingdamage' => 0, 'ratingcrit' => 0,
				'ratingdodge' => 0, 'ratingresist' => 0, 'ratinganticrit' => 0);

			foreach ($boosts as $boost) {
				$curBoosts[$boost['code']] = (int) $boost['value'];
			}

			$this->content['curboosts'] = implode(',', array($curBoosts['ratingaccur'], $curBoosts['ratingdamage'], $curBoosts['ratingcrit'],
						$curBoosts['ratingdodge'], $curBoosts['ratingresist'], $curBoosts['ratinganticrit']));
		} else {
			$this->content['banzai'] = 0;
			$this->content['curboosts'] = '0,0,0,0,0,0';
		}
		$this->content['clanpeople'] = self::$sql->getValue("SELECT count(*) FROM player WHERE clan=" . self::$clan->id);

		$this->content['player'] = array('id' => self::$player->id);
		$this->content['clan'] = array('money' => self::$clan->money);

		$this->content['window-name'] = ClanLang::$windowTitleBanzai;
		$this->page->addPart('content', 'clan/banzai.xsl', $this->content);
	}

	/**
	 * Добавление кланового лога
	 *
	 * @param string $action
	 * @param mixed $params
	 * @param int $playerId
	 * @param int $clanId
	 */
	public static function sendClanLog($action, $params, $playerId = 0, $clanId = 0) {
		Std::loadMetaObjectClass('clanlog');
		$log = new clanlogObject;
		$log->action = $action;
		$log->params = is_array($params) ? json_encode($params) : $params;
		$log->player = $playerId ? $playerId : (self::$player->id ? self::$player->id : 0);
		$log->clan = $clanId ? $clanId : (self::$clan->id ? self::$clan->id : 0);
		$log->dt = date('Y-m-d H:i:s', time());
		$log->save();
	}

	/*
	 * Взятие отпуска после 4-х войн
	 * 
	 * @return bool
	 */

	public static function takeRest() {
		$result = array(
			'type' => 'clan',
			'action' => 'take_rest',
			'redirect' => '/clan/profile/'
		);
		if (Clan::$clan->state != '') {
			$result['result'] = 0;
			$result['error'] = 'CANNOT_TAKE_REST_NOW';
			Page::addAlert(Lang::ERROR, ClanLang::ERROR_CANNOT_TAKE_REST_NOW, ALERT_ERROR);
			return $result;
		}
		if (!self::hasRole('diplomat', self::$player->clan)) {
			$result['result'] = 0;
			$result['error'] = 'noRightsDiplomacy';
			Page::addAlert(ClanLang::ERROR, ClanLang::$errorNoRightsDiplomacy, ALERT_ERROR);
			return $result;
		}

		// выход из союзных войн
		$sql = "SELECT id FROM diplomacy WHERE type = 'war' AND parent_diplomacy > 0 AND (clan1 = " . Clan::$clan->id . " OR clan2 = " . Clan::$clan->id . ") and state != 'finished'";
		$unionWars = Page::$sql->getValueSet($sql);
		if (is_array($unionWars) && count($unionWars)) {
			Std::loadMetaObjectClass('diplomacy');
			foreach ($unionWars as $diplomacyId) {
				$war = new diplomacyObject();
				$war->load($diplomacyId);
				$war->exitWar(self::$clan->id);
			}
		}

		$sql = "SELECT COUNT(1) FROM diplomacy WHERE type = 'war' AND (clan1 = " . Clan::$clan->id . " OR clan2 = " . Clan::$clan->id . ") AND dt > '" . Clan::$clan->lastrestdt . "'";
		$wars = Page::$sql->getValue($sql);
		if ($wars < 4) {
			$result['result'] = 0;
			$result['error'] = 'CANNOT_TAKE_REST_NOT_ENOUGH_WARS';
			Page::addAlert(Lang::ERROR, ClanLang::ERROR_CANNOT_TAKE_REST_NOT_ENOUGH_WARS, ALERT_ERROR);
			return $result;
		}
		$log = array('p' => self::$player->exportForLogs());
		Clan::$clan->state = 'rest';
		$dt = mktime(date('H'), 30, 0, date("m"), date('d'), date('Y'));
		$dt += 3600 * 24 * 7;
		Clan::$clan->lastrestdt = date('Y-m-d H:i:s');
		Clan::$clan->attackdt = date('Y-m-d H:i:s', $dt);
		Clan::$clan->defencedt = date('Y-m-d H:i:s', $dt);
		if (Clan::$clan->level > 1) {
			Clan::$clan->level--;
			$log['l'] = Clan::$clan->level;
		}
		Clan::$clan->points = Page::$data['clanexptable'][Clan::$clan->level - 1];
		Clan::$clan->save(Clan::$clan->id, array(clanObject::$STATE, clanObject::$LASTRESTDT, clanObject::$ATTACKDT, clanObject::$DEFENCEDT, clanObject::$LEVEL, clanObject::$POINTS));

		Clan::sendClanLog('rest', $log);
		Page::addAlert(Lang::ALERT_OK, ClanLang::TAKE_REST_OK);
		$result['result'] = 1;
		return $result;
	}

}

?>