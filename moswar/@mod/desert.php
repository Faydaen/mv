<?php
class Desert extends Page implements IModule
{
    public $moduleCode = 'Desert';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        $this->needAuth();
		if (Runtime::get('desert/state') != 'begin') {
			Std::redirect('/player/');
		}
		//
        if ($this->url[0] == 'rob') {
			if (rand (1, 100) <= 50) {
				Runtime::set('desert/state', 'success');
				Runtime::set('desert/money', (Page::$data['macwork_salary'][self::$player->level] + self::$player->charism_finish * 5) * 20);
				self::$player->money += Runtime::get('desert/money');
				self::$player->save(self::$player->id, array(playerObject::$MONEY));
				Page::sendLog(self::$player->id, 'caravan_success', array('money' => Runtime::get('desert/money')), 1);
			} else {
				Runtime::set('desert/state', 'fail');
				Page::sendLog(self::$player->id, 'caravan_fail', array(), 1);
			}
		}
		$this->showDesert();
        //
        parent::onAfterProcessRequest();
    }

	protected function showDesert()
	{
		$this->content['desert'] = Runtime::get('desert');
		$this->content['window-name'] = 'Пустыня';
		$this->page->addPart('content', 'desert/desert.xsl', $this->content);
		if (Runtime::get('desert/state') == 'fail' || Runtime::get('desert/state') == 'success') {
			Runtime::clear('desert');
		}
	}
}
?>