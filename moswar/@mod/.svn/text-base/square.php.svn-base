<?php
class Square extends Page implements IModule
{
	public $moduleCode = 'Square';

	public function __construct()
	{
		parent::__construct();
	}

	public function processRequest()
	{
		parent::onBeforeProcessRequest();
		$this->needAuth();
		//
		$this->showSquare();
		//
		parent::onAfterProcessRequest();
	}

	protected function showSquare()
	{
		$this->content['window-name'] = "Площадь";
		//$this->content['player'] = self::$player->toArray();

		$content = Page::$cache->get('square_content');
		if (!$content) {
			$this->getTopPlayers();
			Std::loadLib('Xslt');
			$content = Xslt::getHtml2('square/square', array('best' => $this->content['best'], 'top' => $this->content['top']));
			Page::$cache->set('square_content', $content, 900);
		}
		$this->content['content'] = $content;

		//$this->page->addPart('content', 'square/square.xsl', $this->content);
	}

	private function getTopPlayers() {
		//$top = Page::$cache->get('square_top');
		//$best = Page::$cache->get('square_best');
		//if (!$top || !$best) {
			$maxLevel = CacheManager::get('value_maxlevel');
			$names = array();
			for ($i = 1; $i <= $maxLevel; $i++) {
				$names[] = 'topplayer' . $i;
			}
			$players = self::$sql->getRecordSet("SELECT value, name FROM value WHERE name IN ('" . implode("','", $names) . "')");
			$top = array();
			if ($players) {
				foreach ($players as $player) {
					$p = self::$sql->getRecord("SELECT p.id, p.fraction, p.level, p.nickname, p.statsum2,
						p.avatar, p.forum_avatar, p.forum_avatar_checked, p2.slogan, p2.toptime, p.clan_status,
						c.id clan_id, c.name clan_name, i.path
						FROM player p JOIN player2 p2 ON p2.player=p.id LEFT JOIN clan c ON c.id=p.clan
						LEFT JOIN stdimage i ON i.id=p.forum_avatar
						WHERE p.id=" . $player['value']);
					if ($p["clan_status"] == "recruit") {
						unset($p["clan_id"]);
						unset($p["clan_name"]);
					}
					$top[] = $p;
				}

				Std::sortRecordSetByField($top, 'statsum2', 0);
				$best = $top[0];
				if ($best['forum_avatar'] > 0 && $best['forum_avatar_checked'] == 1) {
					$best['avatar'] = '/@images/' . $best['path'];
				}
				foreach (Page::$data['classes'] as $key => $cur) {
					if ($cur['avatar'] == $best['avatar']) {
						$best['avatar'] = '/@/images/pers/' . $cur['thumb'];
					}
				}
				$days = floor($best['toptime'] / 60 / 24);
				$best['toptime'] -= $days * 60 * 24;
				$hours = floor($best['toptime'] / 60);
				$min = $best['toptime'] - $hours * 60;
				$best['toptime'] = $days . ' д. ' . $hours . ' ч. ' . $min . ' м.';
				Std::sortRecordSetByField($top, 'level', 0);
				//Page::$cache->set('square_best', $best, 900);
				//Page::$cache->set('square_top', $top, 900);
			}
		//}
		$this->content['best'] = $best;
		$this->content['top'] = $top;
	}
}
?>