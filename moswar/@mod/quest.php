<?php
class Quest extends Page implements IModule
{
    public $moduleCode = 'Quest';
	public $checkQuests = false;
	public $quest;

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        if (Runtime::get('quest/id') == false) {
			Std::redirect('/player/');
		}
		if (self::$player->gateseen == 0 && $this->url[0] != 'first') {
			Std::redirect('/quest/first/');
		} else if (self::$player->gateseen == 1 && $this->url[0] == 'first') {
			Std::redirect('/quest/');
		} else if (self::$player->gateseen == 0 && $this->url[0] == 'first') {
			self::$player->gateseen = 1;
			self::$player->save(self::$player->id, array(playerObject::$GATESEEN));
		}
		Std::loadMetaObjectClass('player_quest');
		$quest2 = new player_questObject();
		$result = $quest2->load(Runtime::get('quest/id'));
		if ($result == false || $quest2->player != self::$player->id || $quest2->state == 'finished') {
			Std::redirect('/player/');
		}
		Std::loadModule('quests/' . $quest2->codename);
		$quest = new $quest2->codename;
		$quest->init($quest2->toArray());
		$this->quest = $quest;
		$this->quest->player = self::$player;

		if ($this->quest->checkConditions(Runtime::get('quest/triggered_location')) == false) {
			echo 'bad';exit;
			Std::redirect('/player/');
		}

		if ($_POST['action'] == 'nextstep' || $this->url[0] == "next") {
			if ($this->quest->checkNextStepCondition()) {
				$this->quest->nextStep();
				$p = $this->quest->player;
				$this->quest->player = $p->id;
				$this->quest->save($this->quest->id);
				$this->quest->player = $p;
				$step = $this->quest->step;
				if ($this->quest->state != 'finished') {
					$step --;
				}
				if (isset($this->quest->steps[$step]['after_url']) && strlen($this->quest->steps[$step]['after_url']) > 0) {
					Std::redirect($this->quest->steps[$step]['after_url']);
				}
				if ($this->quest->checkConditions() == false) {
					Std::redirect('/');
				}
				if ($this->quest->state == 'finished') {
					if (Runtime::get('quest/return_location') != false) {
						Std::redirect('/' . Runtime::get('quest/return_location') . '/');
					} else {
						Std::redirect('/');
					}
				}
			}
			if ($this->url[0] == "next") {
				Std::redirect("/");
			}
		}
		
		$this->showQuest();
        //
        parent::onAfterProcessRequest();
    }

	public function showQuest() {
		$step = $this->quest->steps[$this->quest->step];
		if ($step['render'] == 'static') {
			$this->generateStaticQuestPage($step);
		} else if ($step['render'] == 'function') {
			$this->quest->page = $this->page;
			$this->content['window-name'] = $step['title'];
			$this->quest->content = $this->content;
			call_user_func(array($this->quest, 'step' . $step['function']));
		}
	}

	public function generateStaticQuestPage($quest) {
		$this->content['window-name'] = $this->quest->title;
		if ($quest['fraction'] == 'same') {
			$content = $quest['same'];
			$content['className'] = '';
		} else {
			$content = $quest[self::$player->fraction];
			$content['className'] = '-' . self::$player->fraction;
		}
		$content['system'] = $quest['system'];
		$content['fraction'] = $quest['fraction'];
		$content['step'] = $this->quest->step;
		$content['id'] = $this->quest->id;
		foreach ($content as $key => $value) {
			$this->content[$key] = $value;
		}
		$this->content['player'] = self::$player->toArray();
		$this->page->addPart ('content', 'quest/static.xsl', $this->content);
	}
}
?>