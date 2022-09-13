<?php
class LevelUp extends player_QuestObject {
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
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '2', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		2 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '3', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		3 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '4', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		4 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '5', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		5 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '6', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		6 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '7', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		7 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '8', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		8 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '9', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		9 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '10', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		10 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '11', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		11 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '12', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		12 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '13', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		13 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '14', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		14 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '15', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		15 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '16', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		16 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '17', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		17 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '18', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		
		18 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '19', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
		
		
		19 => array(
			'fraction' => 'same',
			'render' => 'function',
			'function' => 'LevelUp',
			'after_step' => 'UpdateStat',
			'system' => array('trigger' => 'level', 'level' => '20', 'location' => '', 'condition' => '', 'autostart' => 1, 'force' => 1)
		),
	);

	public function __construct() {
		parent::__construct();
	}

	public function initQuest() {
		$this->data = array('wins' => 0, 'moneygrabbed' => 0);
	}

	public function stepLevelUp() {
		Page::$player->updateStat();
		$currentStat = $this->sql->getRecord("SELECT `moneygrabbed`, `wins` FROM `rating_player` WHERE `player` = " . Page::$player->id . " LIMIT 1");
		$content = array();
		$content['wins'] = $currentStat['wins'] - $this->data['wins'];
		$content['moneygrabbed'] = $currentStat['moneygrabbed'] - $this->data['moneygrabbed'];
		$content['quest'] = array('button' => LevelUpLang::FORWARD_TO_NEW_VICTORIES);
		$content['player'] = Page::$player->toArray();
		$this->page->addPart('content', 'quest/LevelUp/LevelUp.xsl', $content);
	}

	public function afterStepUpdateStat() {
		$currentStat = $this->sql->getRecord("SELECT `moneygrabbed`, `wins` FROM `rating_player` WHERE `player` = " . Page::$player->id . " LIMIT 1");
		$this->data['wins'] = $currentStat['wins'];
		$this->data['moneygrabbed'] = $currentStat['moneygrabbed'];
	}
}
?>