<?php
class StartQuest extends player_QuestObject {
	public $steps = array(
		/*
		array(
			'number' => 1,
			'fraction' => 'different',
			'arrived' => array('title' => '', 'text_up' => '', 'text_down' => '', 'button' => ''),
			'resident' => array('title' => '', 'text_up' => '', 'text_down' => '', 'button' => ''),
			'system' => array('trigger' => '', 'level' => '', 'location' => '', 'condition' => '', 'autostart' => 0, 'force' => 1)
		),
		*/
		1 => array(
			'fraction' => 'same',
			'render' => 'static',
			'same' => array(
				'title' => StartQuestLang::HOW_IT_ALL_BEGAN,
				'text_up' => StartQuestLang::STORY_1,
				'text_down' => StartQuestLang::STORY_2,
				'button' => StartQuestLang::STORY_3
			),
			'system' => array('autostart' => 1, 'force' => 1)
		),
		2 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'ShowCreatePerson',
			'title' => StartQuestLang::YOUR_CHARACTER,
			'system' => array('autostart' => 1, 'force' => 1, 'nscondition' => 'Person')
		),
		3 => array(
			'fraction' => 'same',
			'render' => 'static',
			'same' => array(
				'title' => StartQuestLang::FIRST_INCIDENT,
				'text_up' => StartQuestLang::STORY_4,
				'text_down' => StartQuestLang::STORY_5,
				'button' => StartQuestLang::STORY_6
			),
			'system' => array('autostart' => 1, 'force' => 1)
		),
		4 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'ShowBattle',
			'after_step' => 'SetExpMoney',
			'title' => StartQuestLang::FIGHT,
			'system' => array('autostart' => 1, 'force' => 1)
		),
		5 => array(
			'fraction' => 'same',
			'render' => 'static',
			'same' => array(
				'title' => StartQuestLang::GRAVY,
				'text_up' => StartQuestLang::STORY_7,
				'text_down' => StartQuestLang::STORY_8,
				'button' => StartQuestLang::BEGIN_TO_CONQUER_THE_CAPITAL
			),
			'system' => array('autostart' => 1, 'force' => 1)
		),
		// требования: 2-уровень
		// старт: автоматически при переходе на 2-й уровень
		// новое: доступен Макдональдс
		// редирект: в Макдональдс
		6=> array(
			'fraction' => 'same',
			'render' => 'static',
			'after_url' => '/shaurburgers/',
			'same' => array(
				'title' => StartQuestLang::WORK,
				'text_up' => StartQuestLang::STORY_9,
				'text_down' => StartQuestLang::STORY_10,
				'button' => StartQuestLang::HAPPILY_RUN_TO_WORK
			),
			'system' => array('level' => 2, 'autostart' => 1, 'force' => 1)
		),
		// требования: 3-й уровень, наличие Гаечный ключа
		// старт: при покупке Гаечного ключа
		// новое: квесторые предметы (cd-диск, кукла вуду), доступна Квартира
		// редирект: в Квартиру
		7 => array(
			'fraction' => 'same',
			'render' => 'static',
			'after_url' => '/home/',
			'after_step' => 'GiveQuestItemsStep3',
			'same' => array(
				'title' => StartQuestLang::SUITCASE,
				'text_up' => StartQuestLang::STORY_11,
				'text_down' => StartQuestLang::STORY_12,
				'button' => StartQuestLang::NEXT
			),
			'system' => array('level' => 3, 'location' => 'shop', 'item' => 'wrench', 'autostart' => 1, 'force' => 1)
		),
		// требования: 4-й уровень
		// старт: автоматически
		// новое: доступно создание клана
		// редирект: в Клан
		8 => array(
			'fraction' => 'same',
			'render' => 'static',
			'after_url' => '/clan/',
			'same' => array(
				'title' => StartQuestLang::CLAN_WARS,
				'text_up' => StartQuestLang::STORY_13,
				'text_down' => StartQuestLang::STORY_14,
				'button' => StartQuestLang::CREATE_YOUR_OWN_GANG
			),
			'system' => array('level' => 4, 'autostart' => 1, 'force' => 1)
		),
		// требования: 4-й уровень, наличие Ноутбука
		// старт: при покупке Ноутбука
		// новое: -
		// редирект: в Квартиру
		9 => array(
			'fraction' => 'same',
			'render' => 'static',
			'after_url' => '/home/',
			'after_step' => 'RemoveDisk',
			'same' => array(
				'title' => StartQuestLang::SUITCASE,
				'text_up' => StartQuestLang::STORY_15,
				'text_down' => StartQuestLang::STORY_16,
				'button' => StartQuestLang::PROCEED
			),
			'system' => array('level' => 4, 'item' => 'notebook', 'autostart' => 1, 'force' => 1)
		),
		// требования: 5-й уровень
		// старт: автоматически
		// новое: доступно Метро
		// редирект: в Метро
		10 => array(
			'fraction' => 'same',
			'render' => 'static',
			'after_url' => '/metro/',
			'same' => array(
				'title' => StartQuestLang::SUBWAY,
				'text_up' => StartQuestLang::STORY_17,
				'text_down' => StartQuestLang::STORY_18,
				'button' => StartQuestLang::DESCEND_INTO_THE_SUBWAY
			),
			'system' => array('level' => 5, 'autostart' => 1, 'force' => 1)
		),
		// требования: переход на 6-й уровень
		// старт: автоматически при переходе на 6-й уровень
		// новое: доступен Завод
		// редирект: на Завод
		11 => array(
			'fraction' => 'same',
			'render' => 'static',
			'after_url' => '/factory/',
			'same' => array(
				'title' => StartQuestLang::AN_UNEXPECTED_FINDING,
				'text_up' => StartQuestLang::STORY_19,
				'text_down' => StartQuestLang::STORY_20,
				'button' => StartQuestLang::VISIT_FACTORY
			),
			'system' => array('level' => 6, 'autostart' => 1, 'force' => 1)
		),
		// этап-заглушка
		12 => array(
			'fraction' => 'same',
			'render' => 'static',
			'same' => array('title' => '', 'text_up' => '', 'text_down' => '', 'button' => ''),
			'system' => array('level' => 100, 'autostart' => 1, 'force' => 1)
		),
	);
	
	public function __construct() {
		parent::__construct();
	}

	public function initQuest() {
		
	}

	public function afterStepGiveQuestItemsStep3() {
		Std::loadMetaObjectClass("standard_item");
		$item = new standard_itemObject();
		$item->loadByCode('keys');
		$item->makeExample(Page::$player->id);
		$item->loadByCode('voodoo');
		$item->makeExample(Page::$player->id);
		$item->loadByCode('disk');
		$item->makeExample(Page::$player->id);
		$item->loadByCode('safe2');
		$item->makeExample(Page::$player->id);
		$this->sql->query("DELETE FROM inventory WHERE player = " . Page::$player->id . " AND `code` = 'case'");
		Page::$player->is_home_available = 1;
		Page::$player->homesalarytime = mktime(date("H"), 0, 0);
		Page::$player->save(Page::$player->id, array(playerObject::$IS_HOME_AVAILABLE, playerObject::$HOMESALARYTIME));
	}

	public function afterStepRemoveDisk() {
		Std::loadMetaObjectClass("standard_item");
		$this->sql->query("DELETE FROM inventory WHERE player = " . Page::$player->id . " AND `code` = 'disk'");
	}

	public function afterStepSetExpMoney() {
		Page::$player->money += 300;
		Page::$player->increaseXP(1);
		Page::$player->save(Page::$player->id, array(playerObject::$MONEY, playerObject::$EXP, playerObject::$LEVEL));

		Std::loadMetaObjectClass("standard_item");
		$item = new standard_itemObject();
		$item->loadByCode('case');
		$item->makeExample(Page::$player->id);
	}

	public function stepShowCreatePerson() {
		$content = array();
		$this->page->addPart("content", "quest/StartQuest/person.xsl", $content);
	}

	public function stepShowBattle() {
		Std::loadModule('Alley');
		$content['acting'] = array();
		$content['acting'][0] = Page::$player->exportForFight();
        $content['acting'][0]['position'] = 0;
        //$content['acting'][1] = json_decode('{"id":"0","avatar":"man100.png","nickname":"","level":"1","health_finish":"1","strength_finish":"1","dexterity_finish":"1","attention_finish":"1","resistance_finish":"1","intuition_finish":"1","charism_finish":"1","hp":14,"mhp":"14","position":1}', true);
		$content['acting'][1] = json_decode('{"id":"0","avatar":"man100.png","nickname":"","lv":"1","health_finish":"1","strength_finish":"1","dexterity_finish":"1","attention_finish":"1","resistance_finish":"1","intuition_finish":"1","charism_finish":"1","hp":14,"mhp":"14","position":1}', true);
		$content['acting'][1]['nm'] = StartQuestLang::LOCAL_HOOLIGAN;
		if (Page::$player->fraction == 'arrived') {
			$content['acting'][1]['av'] = 'man100.png';
		} else {
			$content['acting'][1]['av'] = 'man100.png';
		}
		$log = json_decode('[[[[0,1,[1,1]],[1,0,[0]]],[14,13]],[[[0,1,[1,1]],[1,0,[2,3]]],[11,12]],[[[0,1,[1,2]],[1,0,[0]]],[11,10]],[[[0,1,[2,3]],[1,0,[1,1]]],[10,7]],[[[0,1,[0]],[1,0,[0]]],[10,7]],[[[0,1,[1,1]],[1,0,[0]]],[10,6]],[[[0,1,[1,2]],[1,0,[0]]],[10,4]],[[[0,1,[0]],[1,0,[2,4]]],[6,4]],[[[0,1,[1,1]],[1,0,[1,2]]],[4,3]],[[[0,1,[0]],[1,0,[2,3]]],[1,3]],[[[0,1,[3,3]],[1,0,[0]]],[1,0]]]');
		$content['interactive'] = 1;
		$content['date'] = date('d.m.Y');
		$content['time'] = date('H:i:s');
		$content['id'] = 0;
		$content['winner'] = Page::$player->id;
		$content['profit'] = 300;
		$content['exp'] = 1;
        $content["naezdkostil"] = 0;
		foreach ($content['acting'] as &$act) {
			if (isset($act['health_finish'])) {
				$max = max($act['health_finish'], $act['dexterity_finish'], $act['strength_finish'], $act['intuition_finish'], $act['charism_finish'], $act['resistance_finish'], $act['attention_finish']);
			} elseif (isset($act['health'])) {
				$max = max($act['health'], $act['dexterity'], $act['strength'], $act['intuition'], $act['charism'], $act['resistance'], $act['attention']);
			} else {
                $max = max($act['h0'], $act['d0'], $act['s0'], $act['i0'], $act['c0'], $act['r0'], $act['a0']);
                $act['hp'] = $act['mhp'] = $act['h0'] * 10 + $act['r0'] * 4;
            }
			$act['procenthp'] = round($act['hp'] / $act['mhp'] * 100);
			foreach (Page::$data['stats'] as $stat) {
				$stat = $stat['code'];
				if (isset($act['health_finish'])) {
					$act['procent'.$stat] = floor($act[$stat.'_finish'] / $max * 100);
				} elseif (isset($act['health'])) {
                    $act['procent'.$stat] = floor($act[$stat] / $max * 100);
                } else {
                    $act['procent'.$stat] = floor($act[$stat{0}] / $max * 100);
				}
			}
		}
		foreach ($log as &$step) {
			foreach ($step[0] as &$strike) {
				$varName = 'fightStrings';
				if ($content['acting'][$strike[0]]['type'] == 'pet') {
					$varName .= 'Animal';
				}
				if ($strike[2][0] == 0) {
					$varName .= 'Miss';
					$strike[2][1] = 0;
				} else if ($strike[2][0] == 1) {
					$varName .= 'Strike';
				} else if ($strike[2][0] == 2) {
					$varName .= 'Critical';
				} else if ($strike[2][0] == 3) {
					$varName .= 'Injury';
				}
				if ($strike[2][2] == -1 || !isset(AlleyLang::${$varName}[$strike[2][2]])) {
					$strike[2][2] = explode('%', AlleyLang::${$varName}[rand(0, count(AlleyLang::${$varName})-1)]);
				}
			}
		}
		
		if (!isset($content['params']['attacks'])) {
			$attacks = array(1 => array(), 2 => array());
			for ($i = 1; $i <= 2; $i ++) {
				while (count($attacks[$i]) < 3) {
					$w = rand(0, count(Page::$data['duels']['weapons']) - 1);
					if (!isset($attacks[$i][$w])) {
						$attacks[$i][$w] = rand(1, Page::$data['duels']['weapons'][$w]['weapons']);
					}
				}
			}
			$content['params']['attacks'] = $attacks;
		}

		if (!isset($content['params']['bg'])) {
			//$this->content['params']['attacks'] = rand();
		}

		$result = '<fight id="0" background="' . rand(1, 5) . '" winner="' . $content['winner'] . '">' . PHP_EOL;

		$result .= '  <players>' . PHP_EOL;
		foreach ($content['acting'] as $key => $a) {
			if (isset($a['id'])) {
				$result .= '    <player id="' . $a['id'] . '" type="player" hp="' . $a['hp'] . '" maxhp="' . $a['mhp'] . '" avatar="' . str_replace('.png', '', $a['av']) . '" nickname="' . $a['nm'] . '" level="' . $a['lv'] . '" position="' . $a['position'] . '" image="' . $a['im'] . '" animation="' . implode(',', array_keys($content['params']['attacks'][$a['position']+1])) . '" weapons="' . implode(',', $content['params']['attacks'][$a['position']+1]) . '" />' . PHP_EOL;
			} else {
				$result .= '    <player player="' . $content['acting'][$a['position']-2]['id'] . '" type="pet" hp="' . $a['hp'] . '" maxhp="' . $a['mhp'] . '" avatar="' . str_replace('.png', '', $a['im']) . '" nickname="' . str_replace('"', '&quot;', $a['nm']) . '" position="' . $a['position'] . '" />' . PHP_EOL;
			}
		}
		$result .= '  </players>' . PHP_EOL;

		foreach ($log as $key => &$step) {
			if (is_array($step) && is_array($step[0])) {
				foreach ($step[0] as &$strike) {
					$varName = 'fightStrings';
					if ($content['acting'][$strike[0]]['type'] == 'pet') {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsAnimalMiss;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsAnimalStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsAnimalCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsAnimalInjury;
						}
					} else {
						if ($strike[2][0] == 0) {
							$varName = AlleyLang::$fightStringsMiss;
							$strike[2][1] = 0;
						} elseif ($strike[2][0] == 1) {
							$varName = AlleyLang::$fightStringsStrike;
						} elseif ($strike[2][0] == 2) {
							$varName = AlleyLang::$fightStringsCritical;
						} elseif ($strike[2][0] == 3) {
							$varName = AlleyLang::$fightStringsInjury;
						} elseif ($strike[2][0] == 11) {
							$varName = AlleyLang::$fightStringsNaezd;
						} elseif ($strike[2][0] == 12) {
							$varName = AlleyLang::$fightStringsNaezd40;
						} elseif ($strike[2][0] == 21 || $strike[2][0] == 22) {
							$varName = AlleyLang::$fightStringsCombo[$strike[2][3]][$acting[$strike[0]]["sx"]];
						}
					}
					if (!@isset($varName[$strike[2][2]]) || @$strike[2][2] == -1 || !is_array($varName)) {
						$strike[2][2] = (is_array($varName) ? $varName[rand(0, count($varName) - 1)] : $varName);
					}
				}
			} elseif ($step[0] == 'duellogtext') {
				$result .= '  <duellogtext>' . $step[1] . '</duellogtext>';
				$content['duellogtext'] = $step[1];
				unset($log[$key]);
			}
		}

		$result .= '  <turns>' . PHP_EOL;
		foreach ($log as $key => &$step) {
			$result .= '    <turn>' . PHP_EOL;
			foreach ($step[0] as $s) {
				$result .= '      <action a="' . $s[0] . '" d="' . $s[1] . '" t="' . $s[2][0] . '" dp="' . $s[2][1] . '" />' . PHP_EOL;
			}
			$result .= '    </turn>' . PHP_EOL;
		}

		$result .= '  </turns>' . PHP_EOL;

		$result .= '</fight>' . PHP_EOL;
		$result = str_replace("\"", "'", $result);
		$content['xml'] = str_replace(array("\r", "\n"), "", $result);

		$content['attack-string'] = explode('%', AlleyLang::$attackStrings[rand(0, count(AlleyLang::$attackStrings)-1)]);
		$content['log'] = array_reverse($log);
		
		$content['player'] = Page::$player->toArray();
		$content['quest'] = array('button' => StartQuestLang::NEXT);
		$this->page->addPart('content', 'fight/flashfight.xsl', $content);
	}
}
?>