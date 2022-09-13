<?php
class Neft extends Page implements IModule
{
    public $moduleCode = 'Neft';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();

        $this->needAuth();

		$this->showNeft();

        parent::onAfterProcessRequest();
    }

    protected function showNeft()
	{
		if (self::$player->level < 10) { // маленьких не пускаем
			$this->content["lowlevel"] = 1;
		} else {
			$this->content["lowlevel"] = 0;
			$this->content["counter"] = range(1, 15);

			$lastVentelTime = (int)self::$player->data["nft_t"];
			if (!isset(self::$player->data["nft_n"]) || $lastVentelTime == 0 || date("Y-m-d", $lastVentelTime) != date("Y-m-d", time())) { // сегодня еще не дрался
				self::$player->data["nft_n"] = 1;
				self::$player->saveData();
			}
			$this->content["ventel"] = (int)self::$player->data["nft_n"];

			$this->content["npclevel"] = $this->content["ventel"];
			$this->content["money"] = Page::$data["neft"]["npc"][$this->content["ventel"]]["m"];
			$this->content["ore"] = Page::$data["neft"]["npc"][$this->content["ventel"]]["o"];
			$this->content["neft"] = Page::$data["neft"]["npc"][$this->content["ventel"]]["n"];

			$this->content["timeleft2"] = self::$player->lastfight > time() ? self::$player->lastfight - time() : 0;
			$this->content["timeleft"] = date("i:s", $this->content["timeleft2"]);

			$this->content["timer2"] = mktime(0, 0, 0, date("m", time()), date("d", time()) + 1, date("y", time())) - time();
			$this->content["timer"] = date("H:i:s", $this->content["timer2"]);

			$this->content["nowprice"] = Page::$data["neft"]["nowprice"];
		}

        $this->content['window-name'] = NeftLang::WINDOW_NAME;
		$this->page->addPart('content', 'neft/neft.xsl', $this->content);
	}
}
?>