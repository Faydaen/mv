<?php
class Nightclub extends Page implements IModule
{
    public $moduleCode = 'Nightclub';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		$this->needAuth();
        //

		if ($_POST['action'] == 'setphoto' && $this->url[0] == $_POST['action'] && Page::$player->level >= 2) {
			$result = Nightclub::setPhoto((int) $_POST['backid']);
		}
		if (isset($_POST['return_url'])) {
			$result['return_url'] = $_POST['return_url'];
		}
		if (isset($result['return_url'])) {
			Std::redirect($result['return_url']);
		}
		
		if ($this->url[0] == 'photo' && Page::$player->level >= 2) {
			$this->showPhoto();
		} else {
			$this->showNightclub();
		}
        //
        parent::onAfterProcessRequest();
    }

	public static function getExtendedItems() {
		$result = array();
		$result['camera'] = Page::$player->getItemForUseByCode('ny_back');
		return $result;
	}

	protected function showNightclub() {
		$this->content['window-name'] = "Ночной клуб";
		$this->content['player'] = self::$player->toArray();
		$this->page->addPart('content', 'nightclub/nightclub.xsl', $this->content);
	}

	protected function showPhoto() {
		$backgrounds = array();
		$currentBgid = str_replace('avatar-back-', '', Page::$player->background);
		if ($currentBgid <= 6) {
			$backgrounds[] = array('bgid' => $currentBgid, 'thumb' => 0, 'money' => 0, 'locked' => 0);
		} else {
			$backgrounds[] = array('bgid' => rand(1, 6), 'thumb' => 0, 'money' => 0, 'locked' => 0);
		}
		$items = Nightclub::getExtendedItems();
		foreach (Page::$data['nightclub']['backgrounds'] as $id => $bg) {
			$c = implode('|', Page::translateConditions($bg['conditions']));
			$b = array('bgid' => $id, 'thumb' => $id, 'money' => $bg['money'], 'ore' => $bg['ore'], 'honey' => $bg['honey'], 'locked' => !Page::checkConditions(Page::$player, $bg['conditions'], $results), 'conditions' => $c);
			if ($items['camera']) {
				$b['locked'] = 0;
		}
			$backgrounds[] = $b;

		}

		$this->content['backgrounds'] = $backgrounds;

		$this->content['window-name'] = "Ночной клуб";
		$this->content['player'] = self::$player->toArray();
		$paidbg = Page::$sql->getRecord("SELECT * FROM player_paidbg WHERE untildt > NOW() AND player = " . self::$player->id);
		if ($paidbg) {
			$this->content["isset_photo"] = "true";
			$seconds = strtotime($paidbg["untildt"]);
			$seconds -= time();
			$days = ceil($seconds / 86400);
			$this->content["days_left"] = $days;
		}
		$this->content['items'] = $items;
		$this->page->addPart('content', 'nightclub/photo.xsl', $this->content);
	}

	protected static function setPhoto($backgroundId) {
		$currentBgid = str_replace('avatar-back-', '', Page::$player->background);
		$result = array('return_url' => '/nightclub/photo/');

		$extension = false;
		if ($backgroundId == $currentBgid) {
			$extension = true;
			//return $result;
		}

		$items = Nightclub::getExtendedItems();

		if ($backgroundId <= 6) {
			if ($currentBgid <= 6) {
				return $result;
			}

			$sql = "SELECT oldbg FROM player_paidbg WHERE player = " . Page::$player->id;
			$oldbg = Page::$sql->getValue($sql);
			Page::$player->background = 'avatar-back-' . $oldbg;
			Page::$player->save(Page::$player->id, array(playerObject::$BACKGROUND));

			$sql = "DELETE FROM player_paidbg WHERE player = " . Page::$player->id;
			Page::$sql->query($sql);

			Page::addAlert(Lang::ALERT_OK, NightclubLang::ALERT_SETPHOTO, ALERT_INFO);
			return $result;
		}
		
		if (!isset(Page::$data['nightclub']['backgrounds'][$backgroundId])) {
			return $result;
		}
		$bg = Page::$data['nightclub']['backgrounds'][$backgroundId];

		if (!$items['camera']) {
		if (self::$player->money < $bg['money'] || !self::$player->isEnoughOreHoney($bg['ore']) || self::$player->honey < $bg['honey'] ) {
			Page::addAlert(Lang::ERROR_NO_MONEY_TITLE, Lang::ERROR_NO_MONEY, ALERT_ERROR);
			return $result;
		}

		if (!Page::fullConditions(Page::$player, $bg['conditions'])) {
			return $result;
		}
		
		$priceMoney = $bg['money'];
		$priceHoney = $bg['honey'];
        if (Page::$player->ore >= $bg['ore']) {
			$priceOre = $bg['ore'];
        } else {
			$priceOre = Page::$player->ore;
			$priceHoney += ($bg['ore'] - $priceOre);
			$priceHoneyOre = ($bg['ore'] - $priceOre); // для логов
		}

		if ($priceHoney > 0) {
			$reason	= 'setbg [' . $backgroundId . '] $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre . ' + *' . $priceMoney;
			$takeResult = Page::doBillingCommand(Page::$player->id, $priceHoney, 'takemoney', $reason, $other);
		}

		if ($takeResult[0] != 'OK' && $priceHoney > 0) {
			Page::addAlert(Lang::ERROR_NO_MONEY_TITLE, Lang::ERROR_NO_MONEY, ALERT_ERROR);
			return $result;
		}

		Page::$player->money -= $priceMoney;
		Page::$player->ore -= $priceOre;
		Page::$player->honey -= $priceHoney;
		} else {
			Page::$player->useItemFast($items['camera']);
		}

		Page::$player->background = 'avatar-back-' . $backgroundId;

		Page::$player->save(Page::$player->id, array(playerObject::$MONEY, playerObject::$ORE, playerObject::$HONEY, playerObject::$BACKGROUND));
		$sql = "INSERT INTO player_paidbg (player, untildt, oldbg) VALUES(" . Page::$player->id . ", DATE_ADD(NOW(), INTERVAL 14 DAY), " . $currentBgid . ") ON DUPLICATE KEY UPDATE untildt = date_add(" . (($extension) ? "untildt" : "NOW()") . ", interval 14 day)";
		Page::$sql->query($sql);

		if ($extension) {
			Page::addAlert(Lang::ALERT_OK, NightclubLang::ALERT_EXTENSIONPHOTO, ALERT_INFO);
		} else {
			Page::addAlert(Lang::ALERT_OK, NightclubLang::ALERT_SETPHOTO, ALERT_INFO);
		}
		$log = array();
		if ($priceMoney > 0) {
			$log['m'] = $priceMoney;
		}
		if ($priceOre > 0) {
			$log['o'] = $priceOre;
		}
		if ($priceHoney > 0) {
			$log['h'] = $priceHoney;
		}
		$mbckp = array('m' => self::$player->money, 'o' => self::$player->ore, 'h' => self::$player->honey);
		$log['mbckp'] = $mbckp;
		Page::sendLog(Page::$player->id, 'ncsp', $log, true);
		return $result;
	}
}
?>