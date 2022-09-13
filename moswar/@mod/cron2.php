<?php

set_time_limit(0);

class Cron2 extends Page implements IModule {

	public $moduleCode = 'Cron';

	public function __construct() {
		self::$data = $GLOBALS['data'];
		self::$cache = new Cache();
		self::$sql = SqlDataSource::getInstance();
	}

	public function __destruct() {
		if (self::$cache != null) {
			self::$cache->close();
		}
	}

	public function processRequest() {
		Std::loadLang();

		switch ($this->shellArgs[0]) {
            default:
				eval('self::' . $this->shellArgs[0] . '();');
				break;
        }
    }

    private function activatePets() {
        $players = self::$sql->getValueSet("select p.player from pet p where (select count(*) from pet where player=p.player and active=1)=0 group by player");
        foreach ($players as $p) {
            self::$sql->query("UPDATE pet SET active=1 WHERE player = " . $p . " LIMIT 1");
            echo $p . " ";
        }
        echo "DONE!";
    }

    private function generateNpc() {
        Std::loadModule('Npc');
        Std::loadMetaObjectClass('player');
        $player = new playerObject();
        $player->load($this->shellArgs[2]);
        if ($this->shellArgs[1] == 2) {
            $player = $player->exportForFight();
        }
        $npc = NpcGenerator::get($this->shellArgs[1], $player, array());
        var_dump($npc->exportForFight());
        var_dump($npc->playerBoosts);
    }

	public static function deleteUnconfirmedPlayers() {
		if (DEV_SERVER) return;
		Std::loadModule('Cron');
		$players = Page::$sql->getValueSet("SELECT id FROM player WHERE password = 'd41d8cd98f00b204e9800998ecf8427e' and level = 1 and lastactivitytime < adddate(now(), interval -14 day) LIMIT 15000");
		if ($players) {
			Cron::forceDeleteInactive($players, false);
		}
	}

	public static function forceStep2ClanWar() {
		Std::loadMetaObjectClass('diplomacy');
		Std::loadMetaObjectClass('clan');
		Std::loadMetaObjectClass('player');
		$warId = 49702;
		$dip = new diplomacyObject();
		$dip->load($warId);
		$dip->tryEndStep1();
	}

	public static function revertExp() {
		$query = "(select l.player, p.level, l.params, p.exp, l.dt from log20110228 l left join player p on l.player = p.id where l.player <  1000000000 and l.player != 22702 and l.dt > '2011-02-28 21:14:16' and l.type = 'level_up' and p.id is not null order by id asc)
			UNION
			(select l.player, p.level, l.params, p.exp, l.dt from log20110301 l left join player p on l.player = p.id where l.player <  1000000000 and l.player != 22702 and l.dt < '2011-03-01 12:25:00' and l.type = 'level_up' and p.id is not null order by id asc)";
		$logs = Page::$sql->getRecordSet($query);
		$doubles = array();
		$players = array();
		foreach ($logs as $key => &$v) {
			$v['params'] = json_decode($v['params'], true);
			$players[$v['player']] ++;
		}
		$v = null;
		foreach ($logs as $key => &$v) {
			if ($v['level'] <= 4) {
				continue;
			}

			if ($players[$v['player']] > 1) {
				$doubles[] = $v['player'];
				continue;
			}

			$d = Page::$data['exptable'][$v['level'] - 1];

			if ($v['exp'] < $d) {
				continue;
			}

			$query = "UPDATE player SET exp = exp - " . $d . " WHERE id = " . $v['player'];
			Page::$sql->query($query);
			echo $query . PHP_EOL;
		}
		echo json_encode($logs);
		
		echo implode(', ', $doubles);
	}

}

?>
