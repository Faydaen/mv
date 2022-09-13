<?php

class NpcGenerator
{
    /**
     * Генерация NPC под игрока
     *
     * @param int $type
     * @param mixed $player
     * @return array
     */
    public static function get($type, &$player, $params = array())
	{
        $p = is_object($player) ? $player->toArray() : $player;

        switch ($type) {
            case NPC_RAT:
                $npc = new NpcRat();
                break;

            case NPC_AGENTSMITH:
                $npc = new NpcAgentSmith();
                break;

            case NPC_RAIDER:
                $npc = new NpcRaider();
                break;

            case NPC_RIELTOR:
                $npc = new NpcRieltor();
                break;

            case NPC_GRAFTER:
                $npc = new NpcGrafter();
                break;

            default:
                return false;
                break;
        }

        $npc->setParams($params);
        $npc->applyParams();
        $npc->setPlayer($p);
        $npc->applyPlayer();

		return $npc;
	}
}

/**
 * NPC
 */
class Npc
{
    public $npc = 1;
    public $id = 0;
    public $type = NPC_ID;
    public $nickname = '';
    public $about = '';
    public $fraction = 'npc';
    public $avatar = '';
    public $background = '';
    public $clan = 0;
    public $clan_status = '';
    public $clan_title = '';
    public $level = 0;
    public $hp = 0;
    public $maxhp = 0;
    public $health = 0;
    public $strength = 0;
    public $dexterity = 0;
    public $intuition = 0;
    public $resistance = 0;
    public $attention = 0;
    public $charism = 0;
    public $money = 0;
    public $honey = 0;
    public $ore = 0;
    public $ratingcrit = 0;
    public $ratingdodge = 0;
    public $ratingresist = 0;
    public $ratinganticrit = 0;
    public $ratingdamage = 0;
    public $ratingaccur = 0;
    public $pet = null;

    protected $sql;

    protected $player = null;
    public $playerBoosts = array();

    protected $params = array();

    public function  __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function applyParams()
    {

    }

    public function setPlayer(&$player)
    {
        $this->player = $player;

		//$this->player['npc_wins'] = floor($this->player['npc_stat'] / 1000);
		//$this->player['npc_loses'] = $this->player['npc_stat'] % 1000;

        // вычисление бустов игрока
        $absBoosts = array('health'=>0, 'strength'=>0, 'dexterity'=>0, 'intuition'=>0, 'resistance'=>0,
            'attention'=>0, 'charism'=>0, 'ratingcrit'=>0, 'ratingdodge'=>0, 'ratingresist'=>0, 'ratinganticrit'=>0,
            'ratingdamage'=>0, 'ratingaccur'=>0);

        $playerBoosts = $this->sql->getRecordSet("SELECT health, strength, dexterity, intuition, resistance,
            attention, charism, ratingcrit, ratingdodge, ratingresist, ratinganticrit,
            ratingdamage, ratingaccur FROM playerboost2 WHERE player=" . $player['id']);

        if ($playerBoosts) {
            $pcnBoosts = array('health'=>0, 'strength'=>0, 'dexterity'=>0, 'intuition'=>0, 'resistance'=>0,
                'attention'=>0, 'charism'=>0);
            foreach ($playerBoosts as $boost) {
                foreach ($boost as $stat => $value) {
                    if (abs($value) < 0.1) {
                        $pcnBoosts[$stat] += $value;
                    } else {
                        $absBoosts[$stat] += $value;
                    }
                }
            }
            foreach ($pcnBoosts as $stat => $value) {
                if ($value > 0) {
                    if (isset($player[$stat . '_finish'])) {
                        $absBoosts[$stat] += $player[$stat . '_finish'] - round($player[$stat . '_finish'] / (1 + $value * 10));
                    } else {
                        $absBoosts[$stat] += $player[$stat{0}] - round($player[$stat{0}] / (1 + $value * 10));
                    }
                }
            }
        }

        // питомец игркоа
        $this->pet = $this->sql->getRecord("SELECT procent, health, strength, dexterity, intuition, resistance, attention, charism,
            hp, maxhp FROM pet WHERE player=" . $this->player['id'] . " and active = 1 and restore_at < now()");

        $this->playerBoosts = $absBoosts;
    }

    public function applyPlayer()
    {

    }

	public function generatePet($type, $percent = 0)
	{
		$this->pet = new NpcPet();
		switch ($type) {
			case "cat":
				$this->pet->image = "pets/1-" . rand(1, 4) . ".png";
				$this->pet->percent = $percent ? $percent : mt_rand(50, 60);
				$this->pet->name = Lang::PET_CAT;
				$this->pet->item = 47;
				break;

			case "dog":
				$this->pet->image = "pets/2-" . rand(1, 4) . ".png";
				$this->pet->percent = $percent ? $percent : mt_rand(60, 70);
				$this->pet->name = Lang::PET_DOG;
				$this->pet->item = 48;
				break;

			case "parrot":
				$this->pet->image = "pets/3-" . rand(1, 4) . ".png";
				$this->pet->percent = $percent ? $percent : mt_rand(30, 40);
				$this->pet->name = Lang::PET_PARROT;
				$this->pet->item = 46;
				break;

			case "doberman":
				$this->pet->image = "pets/4-" . rand(1, 4) . ".png";
				$this->pet->percent = $percent ? $percent : 80;
				$this->pet->name = Lang::PET_DOBERMAN;
				$this->pet->item = 360;
				break;
		}
		$this->pet->name .= " " . Lang::$npcPetNames[mt_rand(0, sizeof(Lang::$npcPetNames) - 1)];
		$this->pet->health = (int)round($this->health * $this->pet->percent / 100);
		$this->pet->strength = (int)round($this->strength * $this->pet->percent / 100 / 4); // сила у питомцев NPC уменьшена в 4 ураза
		$this->pet->dexterity = (int)round($this->dexterity * $this->pet->percent / 100);
		$this->pet->attention = (int)round($this->attention * $this->pet->percent / 100);
		$this->pet->resistance = (int)round($this->resistance * $this->pet->percent / 100);
		$this->pet->intuition = (int)round($this->intuition * $this->pet->percent / 100);
		$this->pet->charism = (int)round($this->charism * $this->pet->percent / 100);
		$this->pet->level = (int)$this->player->level;
		$this->pet->hp = $this->pet->maxHp = (int)((10 * $this->pet->health + 4 * $this->pet->resistance) * 4);
	}

    public function getExp()
    {
        return 1;
    }

    public function getPlayerProfit()
    {
        return array(
            'money' => 0,
            'ore'   => 0,
        );
    }

    public function getNpcProfit()
    {
        return array(
            'money' => 0,
            'ore'   => 0,
        );
    }

    public function getDroppedItems()
    {
        return false;
    }

    public function onDuelEnd()
    {

    }

    public function exportForFight()
    {
        $npc = array(
            'npc' => 1,
            'id'  => $this->id,
            'tp'  => $this->type,
            'fr'  => $this->fraction,
            'av'  => $this->avatar,
            'bg'  => $this->background,
            'nm'  => $this->nickname,
            'lv'  => $this->level,
            'h'   => $this->health,
            'h0'  => $this->health,
            's'   => $this->strength,
            's0'  => $this->strength,
            'd'   => $this->dexterity,
            'd0'  => $this->dexterity,
            'a'   => $this->attention,
            'a0'  => $this->attention,
            'r'   => $this->resistance,
            'r0'  => $this->resistance,
            'i'   => $this->intuition,
            'i0'  => $this->intuition,
            'c'   => $this->charism,
            'c0'  => $this->charism,
            'ss'  => 0,
            'hp'  => 0,
            'mhp' => 0,
            'rc'  => $this->ratingcrit,
            'rd'  => $this->ratingdodge,
            'rr'  => $this->ratingresist,
            'rac' => $this->ratinganticrit,
            'rdm' => $this->ratingdamage,
            'ra'  => $this->ratingaccur,
        );
        $npc['ss'] = $npc['h'] + $npc['s'] + $npc['d'] + $npc['a'] + $npc['r'] + $npc['i'] + $npc['c'];
        $npc['hp'] = $npc['mhp'] = $npc['h'] * 10 + $npc['r'] * 4;

        $npc['equipped'] = array();

		if (is_object($this->pet)) {
			$npc["pet"] = $this->pet->exportForFight();
		}

        return $npc;
    }

    public function toArray()
    {
        $npc = array(
            'npc' => 1,
            'id' => $this->id,
            'type' => $this->type,
            'fraction' => $this->fraction,
            'avatar' => $this->avatar,
            'background' => $this->background,
            'nickname' => $this->nickname,
            'level' => $this->level,
            'health_finish' => $this->health,
            'heath' => $this->health,
            'strength_finish' => $this->strength,
            'strength' => $this->strength,
            'dexterity_finish' => $this->dexterity,
            'dexterity' => $this->dexterity,
            'attention_finish' => $this->attention,
            'attention' => $this->attention,
            'resistance_finish' => $this->resistance,
            'resistance' => $this->resistance,
            'intuition_finish' => $this->intuition,
            'intuition' => $this->intuition,
            'charism_finish' => $this->charism,
            'charism' => $this->charism,
            'starsum' => 0,
            'hp' => 0,
            'maxhp' => 0,
            'ratingcrit' => $this->ratingcrit,
            'raringdodge' => $this->ratingdodge,
            'ratingresist' => $this->ratingresist,
            'ratinganticrit' => $this->ratinganticrit,
            'ratingdamage' => $this->ratingdamage,
            'ratingaccur' => $this->ratingaccur,
        );
        $npc['statsum'] = $npc['health_finish'] + $npc['strength_finish'] + $npc['dexterity_finish'] + $npc['attention_finish'] +
            $npc['resistance_finish'] + $npc['intuition_finish'] + $npc['charism_finish'];
        $npc['hp'] = $npc['maxhp'] = $npc['health_finish'] * 10 + $npc['resistance_finish'] * 4;

        $npc['equipped'] = array();

		if (is_object($this->pet)) {
			$npc["pet"] = $this->pet->exportForFight();
		}

        return $npc;
    }

	public function import($exportedNpc)
    {
        $this->id = $exportedNpc["id"];
        $this->type = $exportedNpc["tp"];
        $this->fraction = $exportedNpc["fr"];
        $this->avatar = $exportedNpc["av"];
        $this->background = $exportedNpc["bg"];
        $this->nickname = $exportedNpc["nm"];
        $this->level = $exportedNpc["lv"];
        $this->health = $exportedNpc["h"];
        $this->health = $exportedNpc["h0"];
        $this->strength = $exportedNpc["s"];
        $this->strength = $exportedNpc["s0"];
        $this->dexterity = $exportedNpc["d"];
        $this->dexterity = $exportedNpc["d0"];
        $this->attention = $exportedNpc["a"];
        $this->attention = $exportedNpc["a0"];
        $this->resistance = $exportedNpc["r"];
        $this->resistance = $exportedNpc["r0"];
        $this->intuition = $exportedNpc["i"];
        $this->intuition = $exportedNpc["i0"];
        $this->charism = $exportedNpc["c"];
        $this->charism = $exportedNpc["c0"];
        $this->ratingcrit = $exportedNpc["rc"];
        $this->ratingdam = $exportedNpc["rd"];
        $this->ratingresist = $exportedNpc["rr"];
        $this->ratinganticrit = $exportedNpc["rac"];
        $this->ratingdamage = $exportedNpc["rdm"];
        $this->ratingaccur = $exportedNpc["ra"];

		if (isset($exportedNpc["pet"])) {
			$this->pet = new NpcPet();
			$this->pet->import($exportedNpc["pet"]);
		}
    }
}

/**
 * Крыска
 */
class NpcRat extends Npc
{
    public function  __construct()
    {
        parent::__construct();

        $this->id = NPC_ID + NPC_RAT;
        $this->type = NPC_RAT;
        $this->avatar = 'npc1.png';
        $this->background = '';
        $this->nickname = Lang::NPC_RAT . ' ' . Lang::$ratNames[mt_rand(0, sizeof(Lang::$ratNames) - 1)];
    }

    public function getExp()
    {
        return 2;
    }

    public function getPlayerProfit()
    {
		Page::checkEvent($this->player['id'], 'rat_won');
        return array(
            'money' => mt_rand(500, 1500),
            'ore'   => mt_rand(1, 3),
        );
    }

    public function getNpcProfit()
    {
        return array(
            'money' => round($this->player['money'] * mt_rand(9, 11) / 100),
            'ore'   => 0,
        );
    }

    public function applyPlayer()
    {

		if (isset($this->player["health_finish"])) { // генерация бота для дуэли
			$levelK = 1;

			// усиление под питомцев
			$petProcent = 0;
			if ($this->pet) {
				$petProcent = $this->pet['health'] / $this->player['health_finish'];
			}
			$levelK += $petProcent * $petProcent;

			// усиление на частоту боев за сутки
			//$mongo = Page::getMongo();
			//if ($mongo) {
			//	$battlesCount = (int) $mongo->getDb()->selectCollection("duel")->count(array("player1" => $this->player["id"], "player2" => (NPC_ID + NPC_RAT), "winner" => $this->player["id"], "time" => array('$gte' => time() - 86400)));
			//} else {
				$battlesCount = (int) $this->sql->getValue("SELECT count(*) FROM duel WHERE player1 = " . $this->player['id'] . "
					AND player2 = " . (NPC_ID + NPC_RAT) . " AND winner=" . $this->player['id'] . " AND time >= unix_timestamp(DATE_SUB(now(), INTERVAL 1 DAY))");
			//}
			$enrage = 0.9 + $battlesCount / 40;

			$avgLevelStats = $this->sql->getRecord("SELECT health, strength, dexterity, intuition, resistance, attention, charism
				FROM levelstat WHERE type = 1 AND level = " . (Page::getGroupLevel($this->player["level"]) - 1) . " ORDER BY id DESC LIMIT 0,1");

			$h = $this->player['health_finish'] - $this->playerBoosts['health'];
			$this->health = round(($h + round($h * mt_rand(10, 20) / 100 )) * $levelK);
			if ($this->health < $avgLevelStats["health"]) {
				$this->health = round($avgLevelStats["health"] * $enrage);
			}

			$s = $this->player['strength_finish'] - $this->playerBoosts['strength'];
			$this->strength = round($s * $enrage) + round($s * mt_rand(10, 20) / 100);
			if ($this->strength < $avgLevelStats["strength"]) {
				$this->strength = round($avgLevelStats["strength"] * $enrage);
			}

			$d = $this->player['dexterity_finish'] - $this->playerBoosts['dexterity'];
			$this->dexterity = round($d * $enrage) + round($d * mt_rand(19, 35) / 100);
			if ($this->dexterity < $avgLevelStats["dexterity"]) {
				$this->dexterity = round($avgLevelStats["dexterity"] * $enrage);
			}

			$r = $this->player['resistance_finish'] - $this->playerBoosts['resistance'];
			$this->resistance = round($r * $enrage) + round($r * mt_rand(5, 10) / 100);
			if ($this->resistance < $avgLevelStats["resistance"]) {
				$this->resistance = round($avgLevelStats["resistance"] * $enrage);
			}

			$i = $this->player['intuition_finish'] - $this->playerBoosts['intuition'];
			$this->intuition = round($i * $enrage) + round($i * mt_rand(15, 30) / 100);
			if ($this->intuition < $avgLevelStats["intuition"]) {
				$this->intuition = round($avgLevelStats["intuition"] * $enrage);
			}

			$a = $this->player['attention_finish'] - $this->playerBoosts['attention'];
			$this->attention = round($a * $enrage) + round($a * mt_rand(1, 5) / 100);
			if ($this->attention < $avgLevelStats["attention"]) {
				$this->attention = round($avgLevelStats["attention"] * $enrage);
			}

			$c = $this->player['charism_finish'] - $this->playerBoosts['charism'];
			$this->charism = round($c * $enrage) + round($c * mt_rand(10, 20) / 100);
			if ($this->charism < $avgLevelStats["charism"]) {
				$this->charism = round($avgLevelStats["charism"] * $enrage);
			}

			//$this->level = $this->player['level'] + 1;
			$this->level = floor($battlesCount / 2) + 1;

		} else { // генерация для группового боя
			$this->level = Page::getGroupLevel($this->player['lv']);

			$statsForLevel = json_decode(CacheManager::get('value_werewolf_stats', array('level' => $this->level)), true);
			//Стат = Среднее + рандом 35-55%
			$values = array_merge(array_keys(Page::$data['stats']), array_keys(Page::$data['ratings']));
			foreach ($values as $v) {
				$k = rand(35,55)/100;
				$stat = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
				$this->{$v} = $stat == 0 ? 1 : $stat;
			}
		}
    }

    public function onDuelEnd()
    {
        
    }
}

/**
 * Агент Смит
 */
class NpcAgentSmith extends Npc
{
    private $bossK = 1;

    public function  __construct()
    {
        parent::__construct();

        $this->id = NPC_ID + NPC_AGENTSMITH;
        $this->type = NPC_AGENTSMITH;
        $this->avatar = 'man107.png';
        $this->background = '';
        $this->nickname = Lang::NPC_AGENTSMITH . ' ' . Lang::$agentNames[mt_rand(0, sizeof(Lang::$agentNames) - 1)];
    }

    public function getExp()
    {
        return 1;
    }

    public function applyParams()
    {
        if ($this->params['boss']) {
            $this->bossK = mt_rand(20, 30) / 10;
            $this->nickname = 'Начальник охраны';
        }
    }

    public function applyPlayer()
    {
        $levelK = 1;
        switch ($this->player['lv']) {
            case 5:  $levelK = 1; break;
            case 6:  $levelK = 1; break;
            case 7:  $levelK = 1; break;
            case 8:  $levelK = 1; break;
            case 9:  $levelK = 1; break;
            case 10: $levelK = 1; break;
            case 11: $levelK = 1; break;
        }

		// усиление под питомцев
		$pet_procent = 0;
		if ($this->pet) {
            $playerHp = isset($this->player['health_finish']) ? $this->player['health_finish'] : $this->player['h'];
			$pet_procent = $this->pet['health'] / $playerHp;
		}
		$levelK += $pet_procent * $pet_procent;

        $h = $this->player['h'] - $this->playerBoosts['health'];
        $this->health = round( ($h + round($h * mt_rand(9, 25) / 100 * $this->bossK )) * $levelK );

        $s = $this->player['s'] - $this->playerBoosts['strength'];
        $this->strength = $s + round($s * mt_rand(5, 15) * $this->bossK / 100);

        $d = $this->player['d'] - $this->playerBoosts['dexterity'];
        $this->dexterity = $d + round($d * mt_rand(1, 5) * $this->bossK / 100);

        $r = $this->player['r'] - $this->playerBoosts['resistance'];
        $this->resistance = $r + round($r * mt_rand(9, 25) * $this->bossK / 100);

        $i = $this->player['i'] - $this->playerBoosts['intuition'];
        $this->intuition = $i + round($i * mt_rand(5, 15) * $this->bossK / 100);

        $a = $this->player['a'] - $this->playerBoosts['attention'];
        //$this->attention = $a + round($a * mt_rand(5, 15) * $this->bossK / 100);
        $this->attention = $a + round($a * mt_rand(1, 5) * $this->bossK / 100);

        $c = $this->player['c'] - $this->playerBoosts['charism'];
        $this->charism = $c + round($c * mt_rand(5, 15) * $this->bossK / 100);

        $this->level = Page::getGroupLevel($this->player['lv']) + ($this->bossK == 1 ? 0 : 1);

        $this->id = NPC_ID + $this->player['id'];
    }
}

/**
 * Риэлторша
 */
class NpcRieltor extends Npc
{
    public function  __construct()
    {
        parent::__construct();

        $this->id = NPC_ID + NPC_RIELTOR;
        $this->type = NPC_RIELTOR;
        $this->avatar = 'girl107.png';
        $this->background = "avatar-back-" . mt_rand(1, 6);
        $this->nickname = Lang::NPC_RIELTOR . ' ' . Lang::$rieltorNames[mt_rand(0, sizeof(Lang::$rieltorNames) - 1)];
    }

    public function getExp()
    {
        return 1;
    }

    public function getPlayerProfit()
    {
        return array(
            'money' => mt_rand(30, 70)*$this->player['level'],
            'ore'   => 0,
        );
    }

    public function getNpcProfit()
    {
        return array(
            'money' => round($this->player['money'] * mt_rand(9, 11) / 100),
            'ore'   => 0,
        );
    }

    public function applyPlayer()
    {
	
		if (isset($this->player["health_finish"])) { // генерация бота для дуэли
            $this->level = Page::getGroupLevel($this->player['level']);
			
			// сделали предварительный подсчет значений
			
			$statsForLevel = json_decode(CacheManager::get('value_avgcut_stats', array('level' => $this->level)), true);
			//Стат = Среднее + рандом 35-55%
			//$values = array_merge(array_keys(Page::$data['stats']), array_keys(Page::$data['ratings']));
			$values = array_keys(Page::$data['stats']);
			
			$wins = $this->player['npc_loses'];
			$looses = $this->player['npc_wins'];

			$enrageKoef = ($wins + 10) / ($looses + 10);
			
			if ($enrageKoef > 7) {
				$enrageKoef = 7;
			}
			if ($enrageKoef < 0.4) {
				$enrageKoef = 0.4;
			}
			
			$absLowerStats = 1;
			if ($this->level > 10) {
				for ($lvlCap = 0; $lvlCap < ( $this->level-10); $lvlCap++) {
                    $absLowerStats = $absLowerStats * 0.9;
                }
			}
			
			foreach ($values as $v) {
				$k = rand(0, 15) / 100;
				$stat = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
				
				if ($enrageKoef > 1) {
					$stat = $stat * (1 + ($enrageKoef - 1)/7) * $absLowerStats;
				} else {
					$stat = $stat * $enrageKoef * $absLowerStats;
				}
				
				$this->{$v} = $stat == 0 ? 1 : $stat;
			}
			
			
			
			// округляем и избегаем нуля. по хорошему это вынести вниз вообще
			foreach ($values as $v) {
				$this->{$v} = $this->{$v} == 0 ? 1 : floor($this->{$v});
			}
			
			
			
		
			
        } else { // генерация бота для группового боя
			
			
		
            $this->level = Page::getGroupLevel($this->player['lv']);
			$statsForLevel = json_decode(CacheManager::get('value_werewolf_stats', array('level' => $this->level)), true);
			//Стат = Среднее + рандом 0-15%
			$values = array_merge(array_keys(Page::$data['stats']), array_keys(Page::$data['ratings']));
			foreach ($values as $v) {
				$k = rand(0,15)/100;
				$stat = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
				$this->{$v} = $stat == 0 ? 1 : $stat;
			}
		
		
        }
			
        $this->id = NPC_ID + $this->player['id'];

		$this->generatePet("cat");
    }

    public function onDuelEnd($npcWins = false) {
		if ($npcWins === true) {
			$sql = "update player2 set npc_stat = npc_stat + 1 where player = " . $this->player['id'];
			Page::$sql->query($sql);
		} else if ($npcWins === false || $npcWins === -1) {
			$sql = "update player2 set npc_stat = npc_stat + 1000 where player = " . $this->player['id'];
			Page::$sql->query($sql);
		}
    }
}

/**
 * Рейдер
 */
class NpcRaider extends Npc
{
    public $neftDuel = false;

    public function  __construct()
    {
        parent::__construct();

        $this->id = NPC_ID + NPC_RAIDER;
        $this->type = NPC_RAIDER;
        $this->avatar = 'man110.png';
        $this->background = "avatar-back-" . mt_rand(1, 6);
        $this->nickname = Lang::NPC_RAIDER . ' ' . Lang::$raiderNames[mt_rand(0, sizeof(Lang::$raiderNames) - 1)];
    }

    public function getExp()
    {
        return 1;
    }

    public function getPlayerProfit()
    {
        return array(
            'money' => mt_rand(50, 100)*$this->player['level'],
            'ore'   => 0,
        );
    }

    public function getNpcProfit()
    {
        return array(
            'money' => round($this->player['money'] * mt_rand(9, 11) / 100),
            'ore'   => 0,
        );
    }

    public function applyPlayer()
    {
	
		if (isset($this->player["health_finish"])) { // генерация бота для дуэли
            $this->level = Page::getGroupLevel($this->player['level']);
			
			// сделали предварительный подсчет значений
			
			$statsForLevel = json_decode(CacheManager::get('value_avgcut_stats', array('level' => $this->level)), true);
			$values = array_keys(Page::$data['stats']);
			
			$wins = $this->player['npc_loses'];
			$looses = $this->player['npc_wins'];

			$enrageKoef = ($wins + 10) / ($looses + 10);
			
			if ($enrageKoef > 7) {
				$enrageKoef = 7;
			}
			if ($enrageKoef < 0.4) {
				$enrageKoef = 0.4;
			}
			
			$absLowerStats = 1;
			if ($this->level > 10) {
				for ($lvlCap = 0; $lvlCap < ( $this->level-10); $lvlCap++) {
                    $absLowerStats = $absLowerStats * 0.9;
                }
			}
			
			foreach ($values as $v) {
				$k = rand(15, 35) / 100;
				$stat = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
				
				if ($enrageKoef > 1) {
					$stat = $stat * (1 + ($enrageKoef - 1)/7) * $absLowerStats;
				} else {
					$stat = $stat * $enrageKoef * $absLowerStats;
				}
				
				$this->{$v} = $stat == 0 ? 1 : $stat;
			}
			
			
			
			// округляем и избегаем нуля. по хорошему это вынести вниз вообще
			foreach ($values as $v) {
				$this->{$v} = $this->{$v} == 0 ? 1 : floor($this->{$v});
			}
			
			
			
		
			
        } else { // генерация бота для группового боя
			
			
		
            $this->level = Page::getGroupLevel($this->player['lv']);
			
			
			$statsForLevel = json_decode(CacheManager::get('value_werewolf_stats', array('level' => $this->level)), true);
			//Стат = Среднее + рандом 35-55%
			$values = array_merge(array_keys(Page::$data['stats']), array_keys(Page::$data['ratings']));
			foreach ($values as $v) {
				$k = rand(15,35)/100;
				$stat = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
				$this->{$v} = $stat == 0 ? 1 : $stat;
			}
		
		
        }
	
        $this->id = NPC_ID + $this->player['id'];

		$this->generatePet("doberman");
    }

    public function onDuelEnd($npcWins = false) {
		if ($npcWins === true) {
			$sql = "update player2 set npc_stat = npc_stat + 1 where player = " . $this->player['id'];
			Page::$sql->query($sql);
		} else if ($npcWins === false || $npcWins === -1) {
			$sql = "update player2 set npc_stat = npc_stat + 1000 where player = " . $this->player['id'];
			Page::$sql->query($sql);
		}
    }
}

/**
 * Взяточник
 */
class NpcGrafter extends Npc
{
    public $specialProfit = false;
    public $neftDuel = false;

    public function  __construct()
    {
        parent::__construct();

        $this->id = NPC_ID + NPC_GRAFTER;
        $this->type = NPC_GRAFTER;
        $this->avatar = 'man109.png';
        $this->background = "avatar-back-" . mt_rand(1, 6);
        $this->nickname = Lang::NPC_GRAFTER . ' ' . Lang::$grafterNames[mt_rand(0, sizeof(Lang::$grafterNames) - 1)];
    }

    public function getExp()
    {
        return 1;
    }

    public function getPlayerProfit()
    {
        return $this->specialProfit ? $this->specialProfit :
            array(
                'money' => mt_rand(80, 130)*$this->player['level'],
                'ore'   => 0,
            );
    }

    public function getNpcProfit()
    {
        return array(
            'money' => round($this->player['money'] * mt_rand(9, 11) / 100),
            'ore'   => 0,
        );
    }

    public function applyPlayer()
    {
	
		if (isset($this->player["health_finish"])) { // генерация бота для дуэли
            $this->level = Page::getGroupLevel($this->player['level']);
			
			// сделали предварительный подсчет значений
			
			$statsForLevel = json_decode(CacheManager::get('value_avgcut_stats', array('level' => $this->level)), true);
			//Стат = Среднее + рандом 35-55%
			//$values = array_merge(array_keys(Page::$data['stats']), array_keys(Page::$data['ratings']));
			$values = array_keys(Page::$data['stats']);
			
			$wins = $this->player['npc_loses'];
			$looses = $this->player['npc_wins'];

			$enrageKoef = ($wins + 10) / ($looses + 10);
			
			if ($enrageKoef > 7) {
				$enrageKoef = 7;
			}
			if ($enrageKoef < 0.4) {
				$enrageKoef = 0.4;
			}
			
			$absLowerStats = 1;
			if ($this->level > 10) {
				for ($lvlCap = 0; $lvlCap < ( $this->level-10); $lvlCap++) {
                    $absLowerStats = $absLowerStats * 0.9;
                }
			}
			
			foreach ($values as $v) {
				$k = rand(35, 55) / 100;
				$stat = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
				
				if ($enrageKoef > 1) {
					$stat = $stat * (1 + ($enrageKoef - 1)/7) * $absLowerStats;
				} else {
					$stat = $stat * $enrageKoef * $absLowerStats;
				}
				
				$this->{$v} = $stat == 0 ? 1 : $stat;
			}
			
			// округляем и избегаем нуля. по хорошему это вынести вниз вообще
			foreach ($values as $v) {
				$this->{$v} = $this->{$v} == 0 ? 1 : floor($this->{$v});
			}
        } else { // генерация бота для группового боя
            $this->level = Page::getGroupLevel($this->player['lv']);
			
			$statsForLevel = json_decode(CacheManager::get('value_werewolf_stats', array('level' => $this->level)), true);
			//Стат = Среднее + рандом 35-55%
			$values = array_merge(array_keys(Page::$data['stats']), array_keys(Page::$data['ratings']));
			foreach ($values as $v) {
				$k = rand(35,55)/100;
				$stat = floor($statsForLevel[$v. '_avg'] + ($statsForLevel[$v. '_max'] - $statsForLevel[$v. '_avg']) * $k);
				$this->{$v} = $stat == 0 ? 1 : $stat;
			}
        }

        $this->id = NPC_ID + $this->player['id'];

		$this->generatePet("dog");
    }

    public function onDuelEnd($npcWins = false) {
		if ($npcWins === true) {
			$sql = "update player2 set npc_stat = npc_stat + 1 where player = " . $this->player['id'];
			Page::$sql->query($sql);
		} else if ($npcWins === false || $npcWins === -1) {
			$sql = "update player2 set npc_stat = npc_stat + 1000 where player = " . $this->player['id'];
			Page::$sql->query($sql);
		}
    }
}

class NpcPet
{
	public $name;
	public $image;
	public $percent;
	public $health;
	public $strength;
	public $dexterity;
	public $attention;
	public $resistance;
	public $intuition;
	public $charism;
	public $level;
	public $hp;
	public $maxHp;
	public $statSum;
	public $item;

	public function  __construct()
	{

	}

	public function exportForFight()
	{
		return array(
			't'   => 'pet',
			'nm'  => $this->name,
			'im'  => $this->image,
			'h'   => (int)$this->health,
			's'   => (int)$this->strength,
			'd'   => (int)$this->dexterity,
			'a'   => (int)$this->attention,
			'r'   => (int)$this->resistance,
			'i'   => (int)$this->intuition,
			'c'   => (int)$this->charism,
			'lv'  => (int)$this->player->level,
			"hp"  => (int)$this->hp,
			"mhp" => (int)$this->maxHp,
			"ss"  => (int)($this->health + $this->strength + $this->dexterity + $this->attention + $this->resistance +
				$this->intuition + $this->charism),
			"item" => (int) $this->item,
		);
	}

	public function import($pet)
	{
		$this->name = $pet["nm"];
		$this->image = $pet["im"];
		$this->health = $pet["h"];
		$this->strength = $pet["s"];
		$this->dexterity = $pet["d"];
		$this->attention = $pet["a"];
		$this->resistance = $pet["r"];
		$this->intuition = $pet["i"];
		$this->charism = $pet["c"];
		$this->level = $pet["lv"];
		$this->hp = $pet["hp"];
		$this->maxHp = $pet["mhp"];
		$this->item = $pet['item'];
	}
}
?>
