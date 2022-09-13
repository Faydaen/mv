<?php
class player_questObject extends player_questBaseObject
{
	public $steps = array();
	public $page;
	public $content;

	public function __construct()
	{
		parent::__construct();
	}

	public function nextStep($params = array()) {
		$this->endStep();
		if ($this->state != 'finished') {
			$this->step ++;
			$result = $this->startStep();
			if ($result == false) {
				$this->step --;
				return false;
			}
		}
		return true;
	}

	public function start() {
		$this->initQuest();
		$this->nextStep();
	}

	public function checkConditions($location = '') {
		if (!isset($this->steps[$this->step])) {
			return false;
		}
		$step = $this->steps[$this->step];
		if (@is_numeric($step['system']['level']) && $step['system']['level'] > 0 && $this->player->level < $step['system']['level']) {
			return false;
		}
		if (@$step['system']['location'] != '' && $step['system']['location'] != $location) {
			return false;
		}
		if (@$step['system']['item'] != '' && $this->player->isHaveItem($step['system']['item']) == false) {
			return false;
		}
		if (@$step['system']['condition'] != '' && is_callable(array($this, 'condition' . $step['system']['condition']))) {
			$result = call_user_func(array($this, 'condition' . $step['system']['condition']));
			if ($result == false) {
				return false;
			}
		}
		return true;
	}

	public function checkNextStepCondition() {
		if (!isset($this->steps[$this->step])) {
			return true;
		}
		$step = $this->steps[$this->step];
		if (@$step['system']['nscondition'] != '' && is_callable(array($this, 'condition' . $step['system']['nscondition']))) {
			$result = call_user_func(array($this, 'condition' . $step['system']['nscondition']));
			if ($result == false) {
				return false;
			}
		}
		return true;
	}

	public function conditionPerson() {
		if ($this->player->avatar == "") return false;
		else return true;
	}

	public function conditionPerson2() {
		if ($this->player->avatar == "") return true;
		else return false;
	}

	public function endStep($step = -1) {
		if ($step == -1) {
			$step = $this->step;
		}
		
		if (isset($this->steps[$this->step]) && isset($this->steps[$this->step]['after_step']) && is_callable(array($this, 'afterStep' . $this->steps[$this->step]['after_step']))) {
			call_user_func(array($this, 'afterStep' . $this->steps[$this->step]['after_step']), $params);
		}

		if (!isset($this->steps[$this->step + 1])) {
			$this->state = 'finished';
		}
	}

	public function startStep() {
		if (isset($this->steps[$this->step]['test_step']) && is_callable(array($this, 'testStep' . $this->steps[$this->step]['test_step']))) {
			$result = call_user_func(array($this, 'testStep' . $this->steps[$this->step]['test_step']), $params);
			if ($result === false) {
				return false;
			}
		}

		$this->level = @$this->steps[$this->step]['system']['level'];
		$this->location = @$this->steps[$this->step]['system']['location'];
		$this->condition = @$this->steps[$this->step]['system']['condition'];
		$this->item = @$this->steps[$this->step]['system']['item'];
		$this->force = $this->steps[$this->step]['system']['force'];
		$this->autostart = $this->steps[$this->step]['system']['autostart'];

		if (isset($this->steps[$this->step]) && isset($this->steps[$this->step]['before_step']) && is_callable(array($this, 'beforeStep' . $this->steps[$this->step]['before_step']))) {
			call_user_func(array($this, 'beforeStep' . $this->steps[$this->step]['before_step']), $params);
		}

		return true;
	}

	public function load($id = 0) {
		$result = parent::load($id);
		if ($result == true) {
			$this->data = json_decode($this->data, true);
		}
		return $result;
	}

	public function save($id = 0, $fields = false, $saveMerge = '') {
		$this->data = json_encode($this->data);
		parent::save($id, $fields, $saveMerge);
		$this->data = json_decode($this->data, true);
	}
}
?>