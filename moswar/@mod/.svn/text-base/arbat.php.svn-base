<?php
class Arbat extends Page implements IModule
{
    public $moduleCode = 'Arbat';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $this->needAuth();
        //
		$this->showArbat();
        //
        parent::onAfterProcessRequest();
    }

    protected function showArbat()
	{
		$this->content["window-name"] = ArbatLang::WINDOW_NAME;

		$time = time();

		$this->content["day"] = date("N", $time);
		$this->content["playerlevel"] = Page::$player->level;

		/* Бомбилы */
		Std::loadModule("Automobile");
		Automobile::initModels();
		Automobile::initFeatures();
		$this->content["cars"] = array();
		$this->content["automobile"] = array();
		$this->content["automobile"]["car"] = array();

		if (date("N") == 1) {
			if (Page::$player->data["automobile_bring_up"]["date"] != date("d.m.Y")) {
				Automobile::resetBringUp();
				Page::$player->saveData();
			}

			$cars = Automobile::getCarsByPlayerId(Page::$player->id, 0);

			if (is_array($cars)) {
				foreach ($cars as $car) {
					if ($car["cooldown"] < $time) {
						$car["cooldown"] = array("end" => 0);
					} else {
						$car["cooldown"] = array("end" => $car["cooldown"], "rest" => $car["cooldown"] - $time);
					}
					$car["stats"] = "";
					$car["name"] = Automobile::$models[$car["model"]]["name"];
					$car["description"] = Automobile::$models[$car["model"]]["description"];
					if (!empty($car["description"])) $car["stats"] .= "<br />";
					$car["stats"] .= "<span class=\"brown\">" . Automobile::$features["speed"] . ": " . $car["speed"] . "</span><br />";
					$car["stats"] .= "<span class=\"brown\">" . Automobile::$features["controllability"] . ": " . $car["controllability"] . "</span><br />";
					$car["stats"] .= "<span class=\"brown\">" . Automobile::$features["passability"] . ": " . $car["passability"] . "</span><br />";
					$car["stats"] .= "<span class=\"brown\">" . Automobile::$features["prestige"] . ": " . $car["prestige"] . "</span><br />";

					$car["image"] = Automobile::$models[$car["model"]]["image"];
					$car["level"] = Automobile::$models[$car["model"]]["level"];
					$cooldown = round(Automobile::getBringUpBaseTime() * (100/($car["speed"] + $car["passability"] + $car["controllability"])) * 60);
					if (DEV_SERVER) {
						$cooldown = floor($cooldown / 4);
					}
					$car["time"] = Std::formatPeriodShort($cooldown);
					if (empty($this->content["automobile"]["car"]) || $this->content["automobile"]["car"]["cooldown"]["end"] != 0) {
						$this->content["automobile"]["car"] = $car;
					}
					$this->content["cars"][] = $car;
				}
			}
			$this->content["cars"] = array_reverse($this->content["cars"]);
			$this->content["automobile"]["endtime"] = $todayEnd = mktime(23, 59, 59, date("n"), date("j"), date("Y"));
			$this->content["automobile"]["timer"] = $this->content["automobile"]["endtime"] - time();

			$this->content["automobile"]["enabled"] = 1;
		} else {
			$this->content["automobile"]["enabled"] = 0;
		}

		if (Page::$player->data["automobile_bring_up"]["count"] >= Page::$data["automobile_bring_up"]["max"][2]) {
			$this->content["automobile"]["complete"] = 1;
		} else {
			$this->content["automobile"]["complete"] = 0;
		}

		$prize = intval(Page::$player->data["automobile_bring_up"]["prize"]);
		if ($prize > 2) $prize = 2;
		$this->content["automobile"]["count"]["max"] = Page::$data["automobile_bring_up"]["max"][$prize];
		$this->content["automobile"]["count"]["current"] = intval(Page::$player->data["automobile_bring_up"]["count"]);
		$this->content["automobile"]["count"]["percent"] = round(100 / $this->content["automobile"]["count"]["max"] * $this->content["automobile"]["count"]["current"]);
		if ($this->content["automobile"]["count"]["percent"] > 100) $this->content["automobile"]["count"]["percent"] = 100;


		$allPrizes = true;
		for ($i = 0; $i < 3; $i++) {
			if (Page::$player->data["automobile_bring_up"]["prize"] > $i) {
				$this->content["automobile"]["prize" . ($i + 1)] = "filled";
			} else {
				$this->content["automobile"]["prize" . ($i + 1)] = "empty";
				$allPrizes = false;
			}
		}

		if ($this->content["automobile"]["count"]["current"] >= $this->content["automobile"]["count"]["max"] && !$allPrizes) {
			$this->content["automobile"]["prize"] = 1;
		} else {
			$this->content["automobile"]["prize"] = 0;
		}

		if (Page::$player->data["automobile_bring_up"]["endtime"] && Page::$player->data["automobile_bring_up"]["endtime"] >= $time) {
			$this->content["automobile"]["process"] = array("timer" => Page::$player->data["automobile_bring_up"]["endtime"] - $timer, "total" => Page::$player->data["automobile_bring_up"]["total"], "endtime" => Page::$player->data["automobile_bring_up"]["endtime"]);
		} else {
			$this->content["automobile"]["process"] = array("timer" => 0, "total" => 0, "endtime" => 0);
		}
		
		/* /Бомбилы */

		$this->page->addPart('content', 'arbat/arbat.xsl', $this->content);
	}
}
?>