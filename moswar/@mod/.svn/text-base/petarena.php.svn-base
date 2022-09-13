<?php

class Petarena extends Page implements IModule {

	public $moduleCode = 'Petarena';

	public static $healingsCost = array(
		1 => 20,
		2 => 50,
		3 => 70
		//4 => 50
	);
	public static $skills = array('focus' => 'Нацеленность', 'loyality' => 'Преданность', 'mass' => 'Массивность');

	public function __construct() {
		parent::__construct();
	}

	public static function getExtendedItems() {
		$result = array();
		$result['knut'] = Page::$player->getItemForUseByCode('pet_knut');
		return $result;
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		//
		$this->needAuth();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->url[0] == 'train') {
				$result = self::actionTrain((int) $this->url[1], $this->url[2]);
			} else if ($this->url[0] == 'restore') {
				$result = self::actionRestore((int) $this->url[1], (bool)$_POST['knut']);
			} else if ($this->url[0] == 'changename') {
				$result = self::actionChangeName((int) $this->url[1], $_POST['name']);
			} else if ($this->url[0] == 'active') {
				$result = self::actionActive((int) $this->url[1]);
			} else if ($this->url[0] == 'showpetinprofile') {
				$result = self::actionShowPetInProfile((bool) $this->url[1]);
			} else if ($this->url[0] == 'mood') {
				$result = self::actionMood((int) $this->url[1]);
			} else if ($this->url[0] == 'respawn') {
				$result = self::actionRespawnUp((int) $this->url[1]);
			} else if ($this->url[0] == 'sell') {
				$result = self::actionSell((int) $this->url[1]);
			}
			$this->processPostRequest($result);
		}

		if ($this->url[0] == 'train' && is_numeric($this->url[1])) {
			$this->showTrain((int) $this->url[1]);
		} else {
			$this->showPetarena();
		}
		//
		parent::onAfterProcessRequest();
	}

	public static function actionSell($pet) {
		$result = array('type' => 'petarena', 'action' => 'sell', 'return_url' => '/petarena/');

		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$petObject->load($pet, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$result['result'] = 0;
			$result['ext'] = 'not found';
			return $result;
		}

		if ($pet->dead == 1) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_TRAIN_PETDEAD;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$price = self::$sql->getRecord("SELECT id, name, money, ore+honey as ore FROM standard_item WHERE id = " . $petObject->item);
		Std::loadModule('Shop');
		$money = array('money' => floor($price['money'] * Shop::$sell_procent), 'ore' => floor($price['ore'] * Shop::$sell_procent));

		$fields = Page::giveMoney($money, true, $changes);

		foreach ($fields as $currency) {
			$result['wallet'][$currency] = Page::$player->{$currency};
		}

		$active = $petObject->active;

		petObject::deletePet($petObject->id);
		CacheManager::delete('player_pets_id', array('player_id' => Page::$player->id));

		$result['result'] = 1;

		$result['text'] = PetarenaLang::ALERT_PET_SOLD;

		if ($active && $newActive = Page::$sql->getValue("SELECT id FROM pet WHERE player = " . Page::$player->id . " and active = 0 AND respawn_at < now()")) {
			$sql = "UPDATE pet SET active = 1 WHERE id = " . $newActive;
			Page::$sql->query($sql);
			CacheManager::delete('pet_full', array('pet_id' => $newActive));
		}

		Page::sendLog(Page::$player->id, 'item_sold', array('name' => $price['name'], 'money' => $money['money'], 'ore' => $money['ore'], 'mbckp' => Page::getMbckp()), 1);

		return $result;
	}

	public static function actionRespawnUp($pet) {
		$result = array('type' => 'petarena', 'action' => 'mood', 'return_url' => '/petarena/');

		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$petObject->load($pet, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$result['result'] = 0;
			$result['ext'] = 'not found';
			return $result;
		}

		if (!isset(Petarena::$healingsCost[$petObject->respawn_ups + 1])) {
			$result['result'] = 0;
			$result['ext'] = 'not found';
			return $result;
		}

		if ($pet->dead == 0) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_TRAIN_PETNOTDEAD;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$money = array('ore' => Petarena::$healingsCost[$petObject->respawn_ups + 1]);

		if (!Page::isEnoughMoney($money)) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_NO_MONEY;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$fields = Page::spendMoney($money, true, $changes, 'petarena respawn');

		if ($fields === false) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_NO_MONEY;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		foreach ($fields as $currency) {
			$result['wallet'][$currency] = Page::$player->{$currency};
		}

		$result['result'] = 1;

		$petObject->respawn_at = date("Y-m-d H:i:s", strtotime($petObject->respawn_at) - 86400);
		$restore_in = max(0, strtotime($petObject->respawn_at) - time());
		$alert = $petObject->respawn_ups + 1;
		if ($restore_in == 0) {
			$petObject->respawn_ups = 0;
		} else {
			$petObject->respawn_ups ++;
		}
		$petObject->save(array(PetObject::$RESPAWN_AT, petObject::$RESPAWN_UPS));

		$result['restore_in'] = $restore_in;
		if ($restore_in > 0 && isset(Petarena::$healingsCost[$petObject->respawn_ups + 1])) {
			$result['healing_cost'] = Petarena::$healingsCost[$petObject->respawn_ups + 1];
			$result['healing_name'] = PetarenaLang::$healings[$petObject->respawn_ups + 1]['name'];
		}

		$result['text'] = PetarenaLang::$healings[$alert]['alert'];

		$log = array('p' => Page::translatePriceForLogs($changes), 'mbckp' => Page::getMbckp(), 'pet' => array('n' => $petObject->name, 'id' => $petObject->id));
		if (!$restore_in) {
			$log['r'] = 1;
		}
		Page::sendLog(Page::$player->id, 'pet_respawn', $log, 1);

		return $result;
	}

	public static function actionMood($pet) {
		$result = array('type' => 'petarena', 'action' => 'mood', 'return_url' => '/petarena/');

		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$petObject->load($pet, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$result['result'] = 0;
			$result['ext'] = 'not found - ' . $pet;
			return $result;
		}

		$was = $petObject->mood;

		if (time() - $petObject->lastmooddt < 60) {
			$result['result'] = 1;
			$result['text'] = PetarenaLang::ERROR_MOOD_TOOFAST;
			return $result;
		} else if (time() - $petObject->lastmooddt < 3600) {
			$r = rand(1, 100);
			if ($r <= 50) {
				$change = 0;
			} else if ($r > 50 && $r <= 80) {
				$change = -1 * rand(1, 5);
			} else {
				$change = rand(1, 5);
			}
		} else {
			$change = rand(50, 100);
		}

		$toSet = $petObject->mood + $change;
		$petObject->setMood($toSet);
		$progress = $petObject->mood - $was;

		$result['result'] = 1;
		$result['return_url'] = '/petarena/train/' . $pet->id . '/';
		$result['pet']['mood_progress'] = $progress;
		$result['pet']['mood'] = $petObject->mood;


		if ($progress == 0) {
			$result['text'] = PetarenaLang::ALERT_MOOD_NO_PROGRESS;
		} else if ($progress > 0) {
			$result['text'] = Std::renderTemplate(PetarenaLang::ALERT_MOOD_PLUS_PROGRESS, array('mood_progress' => $progress));
		} else {
			$result['text'] = Std::renderTemplate(PetarenaLang::ALERT_MOOD_MINUS_PROGRESS, array('mood_progress' => abs($progress)));
		}

		return $result;
	}

	public static function actionActive($pet) {
		$result = array('type' => 'petarena', 'action' => 'active', 'return_url' => '/petarena/');

		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$petObject->load($pet, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$result['result'] = 0;
			$result['ext'] = 'not found';
			return $result;
		}

		if ($pet->dead == 1) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_TRAIN_PETDEAD;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$active = 1;

		$petObject->setActive();

		$result['pet']['active'] = $petObject->active;

		$result['result'] = 1;
		return $result;
	}

	public static function actionShowPetInProfile($show) {
		$result = array('type' => 'petarena', 'action' => 'showpetinprofile', 'return_url' => '/petarena/');

		Page::$player->data['spip'] = (int) $show;
		Page::$player->saveData();

		$result['result'] = 1;
		return $result;
	}

	public static function actionChangeName($pet, $name) {
		$result = array('type' => 'petarena', 'action' => 'changename', 'return_url' => '/petarena/');

		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$petObject->load($pet, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$result['result'] = 0;
			$result['ext'] = 'not found';
			return $result;
		}

		$petObject->changeName($name);

		$result['result'] = 1;
		$result['return_url'] = '/petarena/train/' . $petObject->id . '/';

		$result['pet']['name'] = $petObject->name;

		$result['text'] = Std::renderTemplate(PageLang::PET_NAME_CHANGED, array('name' => $name));

		return $result;
	}

	public static function actionRestore($pet, $knut = false) {
		$result = array('type' => 'petarena', 'action' => 'restore', 'return_url' => '/petarena/');

		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$petObject->load($pet, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$result['result'] = 0;
			$result['ext'] = 'not found';
			return $result;
		}

		if ($pet->dead == 1) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_TRAIN_PETDEAD;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$pet = $pet->toArray();

		if (strtotime($pet['train_at']) < time()) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_RESTORE_PET_RESTED;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		if ($knut) {
			$items = Petarena::getExtendedItems();
			if (!$items['knut']) {
				$result['result'] = 0;
				$result['error'] = PetarenaLang::ERROR_RESTORE_NO_KNUT;
				$result['return_url'] = '/petarena/train/' . $pet->id . '/';
				return $result;
			}
		}

		$log = array();

		if (!$knut) {
			$cost = self::getRestoreCost($petObject->getRestoresUsed() + 1);

			if (!$cost) {
				$result['result'] = 0;
				$result['error'] = PetarenaLang::ERROR_RESTORE_LIMIT;
				$result['return_url'] = '/petarena/train/' . $pet->id . '/';
				return $result;
			}

			$money = array('honey' => $cost);

			if (!Page::isEnoughMoney($money)) {
				$result['result'] = 0;
				$result['error'] = PetarenaLang::ERROR_NO_MONEY;
				$result['return_url'] = '/petarena/train/' . $pet->id . '/';
				return $result;
			}

			$fields = Page::spendMoney($money, true, $changes, 'patarena restore');

			if ($fields === false) {
				$result['result'] = 0;
				$result['error'] = PetarenaLang::ERROR_NO_MONEY;
				$result['return_url'] = '/petarena/train/' . $pet->id . '/';
				return $result;
			}

			$log['p'] = Page::translatePriceForLogs($changes);

			foreach ($fields as $currency) {
				$result['wallet'][$currency] = Page::$player->{$currency};
			}
		} else {
			$log['k'] = 1;
			Page::$player->useItemFast($items['knut']);
		}

		$petObject->restore();


		$result['result'] = 1;

		$log['mbckp'] = Page::getMbckp();
		$log['pet'] = array('n' => $petObject->name, 'id' => $petObject->id);
		Page::sendLog(Page::$player->id, 'pet_restore', $log, 1);

		return $result;
	}

	public static function actionTrain($pet, $skill) {
		$result = array('type' => 'petarena', 'action' => 'train', 'return_url' => '/petarena/');

		if ($skill != 'focus' && $skill != 'loyality' && $skill != 'mass') {
			$result['result'] = 0;
			$result['ext'] = 'bad skill';
			$result['skill'] = $skill;
			return $result;
		}

		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$petObject->load($pet, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$result['result'] = 0;
			$result['ext'] = 'not found';
			return $result;
		}

		if ($pet->dead == 1) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_TRAIN_PETDEAD;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$pet = $pet->toArray();

		if (strtotime($pet['train_at']) > time()) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_TRAIN_REST;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$cost = self::getTrainCost($pet[$skill] + 1);
		$time = self::getTrainTime($pet[$skill] + 1);

		if (!Page::isEnoughMoney($cost)) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_NO_MONEY;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$fields = Page::spendMoney($cost, true, $changes, 'petarena train');

		if ($fields === false) {
			$result['result'] = 0;
			$result['error'] = PetarenaLang::ERROR_NO_MONEY;
			$result['return_url'] = '/petarena/train/' . $pet->id . '/';
			return $result;
		}

		$petObject->increaseSkill($skill, 1);

		foreach ($fields as $currency) {
			$result['wallet'][$currency] = Page::$player->{$currency};
		}

		$min = min($petObject->focus, $petObject->loyality, $petObject->mass);
		if ($min == 500) {
			$maxStat = 500;
		} else if ($min >= 200) {
			$maxStat = 499;
		} else if ($min >= 50) {
			$maxStat = 199;
		} else {
			$maxStat = 49;
		}

		$result['pet']['lasttrainduration'] = $petObject->lasttrainduration;
		$result['pet'][$skill] = $petObject->{$skill};
		$result['pet'][$skill . '_procent'] = min(round($petObject->{$skill} / $maxStat * 100), 100);
		$result['pet'][$skill . '_cost'] = self::getTrainCost($petObject->{$skill} + 1);
		$result['pet']['restore_cost'] = self::getRestoreCost($petObject->getRestoresUsed() + 1);
		$result['pet']['level'] = $petObject->level;
		$result['pet']['image'] = str_replace('.png', '-big.png', $petObject->image);

		$result['result'] = 1;

		$items = Petarena::getExtendedItems();
		if ($items['knut']) {
			$result['knut'] = 1;
		}

		$log = array('s' => Petarena::$skills[$skill], 'n' => $petObject->{$skill}, 'p' => Page::translatePriceForLogs($changes), 'mbckp' => Page::getMbckp(), 'pet' => array('n' => $petObject->name, 'id' => $petObject->id));
		Page::sendLog(Page::$player->id, 'pet_train', $log, 1);

		return $result;
	}

	public function showTrain($petId) {
		Std::loadMetaObjectClass('pet');
		$petObject = new petObject();
		$result = $petObject->load($petId, false);
		$pet = $petObject;

		if (!$pet || $pet->player != Page::$player->id) {
			$this->dieOnError(404);
		}

		$pet->name = preg_replace("/&quot;/", "&laquo;", $pet->name, 1);
		$pet->name = preg_replace("/&quot;/", "&raquo;", $pet->name, 1);

		$pet = $pet->toArray();
		$pet['dead'] = $petObject->dead;
		$pet['can_train'] = 1;

		if ($petObject->dead == 1) {
			if (isset(Petarena::$healingsCost[$pet['respawn_ups'] + 1])) {
				$this->content['healing'] = array('name' => PetarenaLang::$healings[$pet['respawn_ups'] + 1]['name'], 'cost' => Petarena::$healingsCost[$pet['respawn_ups'] + 1]);
			}

			$trainTime = 84600 * 4;
			$timer = strtotime($pet['respawn_at']) - time();
			$this->content['restoretimer'] = $timer > 0 ? $timer : 0;
			$this->content['restoretimeleft2'] = $timer;
			$this->content['restoretimetotal'] = $trainTime;
			$this->content['restorepercent'] = round(($trainTime - $timer) / $trainTime * 100);
		}

		if (strtotime($pet['train_at']) > time()) {
			$pet['can_train'] = 0;
			$trainTime = $pet['lasttrainduration'];
			$timer = strtotime($pet['train_at']) - time();
			$this->content['traintimer'] = $timer > 0 ? $timer : 0;
			$this->content['traintimeleft2'] = $timer;
			$this->content['traintimetotal'] = $trainTime;
			$this->content['trainpercent'] = round(($trainTime - $timer) / $trainTime * 100);

			$this->content['restore_cost'] = self::getRestoreCost($petObject->getRestoresUsed() + 1);
			$this->content['items'] = Petarena::getExtendedItems();
		}

		$min = min($petObject->focus, $petObject->loyality, $petObject->mass);
		if ($min == 500) {
			$maxStat = 500;
		} else if ($min >= 200) {
			$maxStat = 499;
		} else if ($min >= 50) {
			$maxStat = 199;
		} else {
			$maxStat = 49;
		}
		foreach (array('focus', 'loyality', 'mass') as $key) {
			$pet[$key . '_cost'] = self::getTrainCost($pet[$key] + 1);
			$pet[$key . '_procent'] = min(round($pet[$key] / $maxStat * 100), 100);
		}

		$pet['procenthp'] = round($pet['hp'] / $pet['maxhp'] * 100);

		$pet['image'] = str_replace('.png', '-big.png', $pet['image']);

		$this->content['pet'] = $pet;
		preg_match("/\"(.*?)\"/", $pet['name'], $match);
		$this->content['pet']['nickname'] = (string) @$match[1];

		$this->content['pet']['imagesmall'] = str_replace('-big', '', $this->content['pet']['image']);

		$this->content['window-name'] = PetarenaLang::WINDOW_TITLE;
		$this->page->addPart('content', 'petarena/train.xsl', $this->content);
	}

	public function showPetarena() {
		$sql = "SELECT * FROM pet WHERE player = " . Page::$player->id;
		$pets = Page::$sql->getRecordSet($sql);

		$this->content['pets'] = $pets;

		$this->content['showpetinprofile'] = Page::$player->data['spip'];

		$this->content['window-name'] = PetarenaLang::WINDOW_TITLE;
		$this->page->addPart('content', 'petarena/petarena.xsl', $this->content);
	}

	public static function getTrainCost($forLevel) {
		if ($forLevel >= 1 && $forLevel <= 49) {
			return array(
				'money' => 100 * $forLevel
			);
		} else if ($forLevel >= 50 && $forLevel <= 199) {
			return array(
				'money' => ($forLevel - 30) * 40,
				'ore' => 4 + round($forLevel / 40)
			);
		} else if ($forLevel >= 200 && $forLevel <= 500) {
			return array(
				'money' => ($forLevel - 100) * 20,
				'ore' => 4 + round(($forLevel - 150 ) / 70),
				'oil' => (4 + round(($forLevel - 50) / 40)) * 10
			);
		} else {
			return false;
		}
	}

	public static function getTrainTime($forLevel) {
		if (isset(Page::$data['pets']['train_time'][$forLevel])) {
			return Page::$data['pets']['train_time'][$forLevel];
		} else {
			return Page::$data['pets']['train_time'][count(Page::$data['pets']['train_time']) - 1];
		}
	}

	public static function getRestoreCost($forTime) {
		if (isset(Page::$data['pets']['restore_cost'][$forTime])) {
			return Page::$data['pets']['restore_cost'][$forTime];
		} else {
			return false;
		}
	}
}

?>