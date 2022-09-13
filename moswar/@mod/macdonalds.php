<?php
class Macdonalds extends Page implements IModule
{
    public $moduleCode = 'Macdonalds';

    public function __construct()
    {
        parent::__construct();
    }

	public static function isAvailable() {
		if (self::$player->level >= 2 || self::salaryBonus()) {
			return true;
		} else {
			return false;
		}
	}

	public static function salaryBonus() {
		if (Page::sqlGetCacheValue("SELECT 1 FROM inventory WHERE player = " . self::$player->id . " and code = 'shaurcap' and equipped = 1 LIMIT 1", 1)) {
			return 50;
		} else {
			return 0;
		}
	}

    public function processRequest() {
        parent::onBeforeProcessRequest();
		$this->needAuth();
		Std::loadModule('Api');
        //
		if (self::isAvailable() && @$_POST['action'] == 'work') {
			$result = Macdonalds::work($_POST['time']);
			Runtime::set('content/result', $result);
			Std::redirect('/shaurburgers/');
		} else if (self::isAvailable() && $this->url[0] == 'train') {
			$result = Macdonalds::train();
			Runtime::set('content/result', $result);
			Std::redirect('/shaurburgers/');
		} else if (self::isAvailable() && @$_POST['action'] == 'leave') {
			$result = Macdonalds::leave();
			Runtime::set('content/result', $result);
			Std::redirect('/shaurburgers/');
		}
		$this->showMacdonalds();
        //
        parent::onAfterProcessRequest();
    }

	public static function train()
    {
		$result = array('type' => 'macdonalds', 'action' => 'train', 'result' => 0);
		$nextskill = Page::$data['professions'][self::$player->skill + 1];
		if (!isset($nextskill['cost_money'])) {
			$result['error'] = 'you already have max skill';
			$result['result'] = 0;
			return $result;
		} elseif (self::$player->level < $nextskill['level']) {
			$result['error'] = 'low level';
			$result['result'] = 0;
			return $result;
		} elseif (($nextskill['cost_money'] > 0 && $nextskill['cost_money'] > self::$player->money) || ($nextskill['cost_ore'] > 0 && $nextskill['cost_ore'] > (self::$player->ore + self::$player->honey))) {
			$result['error'] = 'no money';
			$result['result'] = 0;
			return $result;
		} elseif (self::$player->isFree() === false) {
			$result['result'] = 0;
			$result['error'] = 'you are busy';
			return $result;
		} else {
			if (self::$player->ore >= $nextskill['cost_ore']) {
                $priceOre = $nextskill['cost_ore'];
                $priceHoney = 0;
            } else {
                $priceOre = self::$player->ore;
                $priceHoney = $nextskill['cost_ore'] - $priceOre;
                $priceHoneyOre = $nextskill['cost_ore'] - $priceOre; // для логов
            }

            if ($priceHoney > 0) {
                $reason	= 'shaurma training $' . $priceHoney . ' (' . (int)$priceHoneyOre . ') + @' . $priceOre;
                $takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
            }
            if ($priceHoney == 0 || $takeResult[0] == 'OK') {
                self::$player->money -= $nextskill['cost_money'];
                self::$player->ore -= $priceOre;
                self::$player->honey -= $priceHoney;
                
                self::$player->skill++;
                self::$player->save(self::$player->id, array(playerObject::$MONEY, playerObject::$ORE, playerObject::$HONEY, playerObject::$SKILL));

                $result['result'] = 1;
            } else {
                Page::addAlert('Медовая ошибка', 'У Вас недостаточно мёда. Видимо, Вы уже съели весь свой мёд.');
            }
            //if ($nextskill['cost_ore'] > 0) {
			//	self::$player->spendOreHoney($nextskill['cost_ore']);
			//}
			
			return $result;
		}
	}

	public static function work($time) {
		$result = array('type' => 'macdonalds', 'action' => 'work');
		$maxTime = 8;
		if (CacheManager::get('value_sovet_bonus_patrol') == Page::$player->fraction) {
			$maxTime += 4;
		}
		if (!is_numeric($time) || $time < 1 || $time > $maxTime) {
			$result['result'] = 0;
			$result['error'] = 'bad time';
			return $result;
		} else if (self::$player->isFree() === false) {
			$result['result'] = 0;
			Page::addAlert('Ошибка', 'Вы сейчас заняты и не можете работать. Приходите, когда освободитесь.', ALERT_ERROR);
			return $result;
		} else {
			$salary = ( Macdonalds::getMacHourSalary() + Macdonalds::salaryBonus()) * $time;
			$exp = 0;
			if ($time > 1) {
			    $exp = $time;
			}

			$b = 0;
			if (Page::getData("player_hasgift_shaurbadge_" . self::$player->id,
					"SELECT count(*) FROM gift WHERE code='shaurbadge' AND player = " . self::$player->id, "value", 600)) {
				$b += 30;
			}

			$salary = round($salary * (100 + $b) / 100);
			
			// на дев сервере работа за 20 сек делается.
			if (DEV_SERVER) {
				$endTime = time () + 60 * $time;
			} else {
				$endTime = time () + 3600 * $time;
			}
			$endTime -= time() + date("s", $endTime);
			self::$player->beginWork('macdonalds', $endTime, $salary, $exp);
			self::$player->state = 'macdonalds';
			self::$player->timer = time () + $endTime;
			self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$TIMER));
			$result['result'] = 1;
			$result['params'] = array('salary' => $salary, 'player' => array('timer' => self::$player->timer, 'state' => self::$player->state));
			return $result;
		}
	}
	
	public static function leave() {
		$result = array('type' => 'macdonalds', 'action' => 'leave');
		if (self::$player->state == 'macdonalds') {
			self::$sql->query("DELETE FROM playerwork WHERE player = " . self::$player->id . " AND type='macdonalds'");
			self::$player->state = '';
			self::$player->timer = 1;
			self::$player->save(self::$player->id, array(playerObject::$STATE, playerObject::$TIMER));
			$result['result'] = 1;
			return $result;
		} else {
			$result['result'] = 0;
			$result['error'] = 'you are not working';
			return $result;
		}
	}
	
	public static function getMacHourSalary($skill = false, $level = false) {
		if (!$level) {
            $level = self::$player->level;
        }
        if (!$skill) {
            $skill = self::$player->skill;
        }
		$salary = round( (Page::$data['macwork_salary'][$level] + self::$player->charism_finish * 5) * (1 + ($skill)/20) );
		
		return $salary;
	}

	protected function showMacdonalds() {
		$this->content['window-name'] = "ШаурБургерс";
		if (self::$player->state == 'macdonalds' && self::$player->timer > time()) {
            $timer = self::$player->timer - time();
            $shaurmaTime = self::$sql->getValue("SELECT time FROM playerwork WHERE player=" . self::$player->id . " AND type='macdonalds'");
            $this->content['timer'] = $timer > 0 ? $timer : 0;
            $this->content['shaurmatimeleft2'] = date('H:i:s', $timer);
            $this->content['shaurmatimetotal'] = $shaurmaTime;
            $this->content['shaurmapercent'] = round(($shaurmaTime - $timer) / $shaurmaTime * 100);
		}
		//$this->content['timer'] = self::$player->timer - time();

		$this->content['is_available'] = Macdonalds::isAvailable();
		$this->content['currentskill'] = Page::$data['professions'][self::$player->skill];
		$this->content['nextskill'] = Page::$data['professions'][self::$player->skill + 1];
		$this->content['player'] = self::$player->toArray();
		$this->content['currentskill']['salary'] = Macdonalds::getMacHourSalary();
		$level = Page::$data['professions'][self::$player->skill + 1]['level'] > self::$player->level ? Page::$data['professions'][self::$player->skill + 1]['level'] : self::$player->level;
		$this->content['nextskill']['salary_bonus'] = Macdonalds::getMacHourSalary(self::$player->skill + 1, $level);
        $this->content['nextskill']['salary'] = self::getMacHourSalary(self::$player->skill + 1, $level);
        $this->content['nextlevel']['salary'] = self::getMacHourSalary(self::$player->skill, self::$player->level + 1);
		
        $this->content['salaryBonus'] = Macdonalds::salaryBonus();

		$this->content['shaurbadge'] = Page::getData("player_hasgift_shaurbadge_" . self::$player->id,
			"SELECT count(*) FROM gift WHERE code='shaurbadge' AND player = " . self::$player->id, "value", 600);

		if (CacheManager::get('value_sovet_bonus_patrol') == Page::$player->fraction) {
			$this->content['add_hours'] = 1;
		}
		
		$this->page->addPart('content', 'macdonalds/macdonalds.xsl', $this->content);
	}
}