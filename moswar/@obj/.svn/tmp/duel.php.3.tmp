<?php

class duelObject extends duelBaseObject {

	public $winner;
	public $looser;
	private $strikeStats = array();
	private $precalculatedValues = array();

	public $realprofit = 0;
	public $profit2 = 0;

	public $params;
	public $log;
	public $acting;

	public $attacker;
	public $defender;
	public $werewolf = 0;

	public function __construct() {
		parent::__construct();
	}

	public static function r($min = 0, $max = 1) {
		return round(mt_rand($min * 10000, $max * 10000) / 10000, 5);
	}

	/**
	 * Бой
	 * @param object $player1
	 * @param object $player2
	 */
	public function fight(&$player1, &$player2, $npc = false, $werewolf = false) {
		$this->werewolf = $werewolf;
		Std::loadMetaObjectClass('diplomacy');

		// подключение игроков
		$attacker = $player1;
		$defender = $player2;

		$this->attacker = $player1;
		$this->defender = $player2;

		// сохраняем состояние того, на кого напали
		// ставим состояние "в бою"
		//$player1->state = 'fight';
		//$player1->save($player1->id, array(playerObject::$STATE));

		/*
		  if (!$npc) {
		  if ($player2->state != '') {
		  $player2->state2 = json_encode(array(
		  'state' => $player2->state,
		  'stateparam' => $player2->stateparam,
		  'timer' => $player2->timer,
		  ));
		  $player2->state = 'fight';
		  $player2->save($player2->id, array(playerObject::$STATE, playerObject::$STATE2));
		  } else {
		  $player2->state = 'fight';
		  $player2->save($player2->id, array(playerObject::$STATE));
		  }
		  }
		 */

		// 0 attacker, 1 defender, 2 attacker pet, 3 defender pet
		$acting = array(
			0 => array_merge($player1->exportForFight(), array('position' => 0)),
			1 => array_merge($player2->exportForFight(), array('position' => 1))
		);

		// добавление рейтингов
		// хата = рейтинг защиты (для защищающегося)
		if (!$npc) {
			$acting[1]['rr'] += $player2->home_defence * 5;
		}
		// рейтинги клановых апгрейдов (если война)
		/*if ($npc) {
			$warId = 0;
		} else {
			$warId = diplomacyObject::areAtWar($player1->clan, $player2->clan);
			if ($warId) {
				$c1 = new clanObject();
				$c1->load($player1->clan);
				$acting[0]['rdm'] += $c1->attack * 5;
				$acting[0]['rr'] += $c1->defence * 5;
				$c2 = new clanObject();
				$c2->load($player2->clan);
				$acting[1]['rdm'] += $c2->attack * 5;
				$acting[1]['rr'] += $c2->defence * 5;
			}
		}*/

		// подключение питомцев
		if (isset($player1->pet) && is_object($player1->pet)) {
			$p = $player1->pet->exportForFight();
			if ($p) {
				$acting[2] = array_merge($p, array('position' => 2));
			}
		}
		if (isset($player2->pet) && is_object($player2->pet)) {
			$p = $player2->pet->exportForFight();
			if ($p) {
				$acting[3] = @array_merge($player2->pet->exportForFight(), array('position' => 3));
			}
		}

		//var_dump($acting);exit;

		// рассчет вероятностей
		$this->precalculatedValues = array(
			0 => array(
				1 => array(
					'sp' => self::calcSP($acting[0], $acting[1]),
					'csp' => self::calcCSP($acting[0], $acting[1]),
				),
			),
			1 => array(
				0 => array(
					'sp' => self::calcSP($acting[1], $acting[0]),
					'csp' => self::calcCSP($acting[1], $acting[0]),
				),
			),
		);
		if (isset($player1->pet)) {
			$this->precalculatedValues[2] = array(
				1 => array(
					'sp' => self::calcSP($acting[2], $acting[1]),
					'csp' => self::calcCSP($acting[2], $acting[1]),
				),
			);
			if (isset($player2->pet) && is_object($player2->pet)) {
				$this->precalculatedValues[2][3] = array(
					'sp' => self::calcSP($acting[2], $acting[3]),
					'csp' => self::calcCSP($acting[2], $acting[3]),
				);
			}
		}
		if (isset($player2->pet) && is_object($player2->pet)) {
			$this->precalculatedValues[3] = array(
				0 => array(
					'sp' => self::calcSP($acting[3], $acting[0]),
					'csp' => self::calcCSP($acting[3], $acting[0]),
				),
			);
			if (isset($player1->pet)) {
				$this->precalculatedValues[3][2] = array(
					'sp' => self::calcSP($acting[3], $acting[2]),
					'csp' => self::calcCSP($acting[3], $acting[2]),
				);
			}
		}

		// статистика ударов
		$this->strikeStats = array(
			'0_1' => array('strikes' => 0, 'hits' => 0, 'crits' => 0),
			'1_0' => array('strikes' => 0, 'hits' => 0, 'crits' => 0),
			'2_1' => array('strikes' => 0, 'hits' => 0, 'crits' => 0),
			'2_3' => array('strikes' => 0, 'hits' => 0, 'crits' => 0),
			'3_0' => array('strikes' => 0, 'hits' => 0, 'crits' => 0),
			'3_2' => array('strikes' => 0, 'hits' => 0, 'crits' => 0),
		);

		$beforeActing = $acting;
		$this->acting = $acting;

		// наезд на мопеде
		$player1Moto = $player1->getEquippedItemByType('tech');
		if ($player1Moto && $player1Moto->type == 'tech' && $player1Moto->subtype == 'moto' && $player1Moto->level > 2) {
			if (mt_rand(1, 100) < (int) $player1Moto->special1) {
				$move = $this->makeStrikeSpecial('naezd', 0, 1, mt_rand((int) $player1Moto->special2, (int) $player1Moto->special3));

				$hp = array();
				for ($i = 0; $i < 4; $i++) {
					$hp[] = isset($this->acting[$i]) ? $this->acting[$i]['hp'] : 0;
				}
				$this->log[] = array(array(array(0, 1, $move)), $hp);
			}
		}

		// раунды боя
		//$beforeActing = $acting;
		//$this->acting = $acting;
		$comboChance = array(5, 10, 15, 5);
		$cooldowns = array(0, 0);
		$minCombos = $maxCombos = array();
		for ($i = 0; $i <= 1; $i++) {
			if ($this->acting[$i]["kt"] > 0) {
				$minCombos[$i] = $this->acting[$i]["kt"] - 2;
				$maxCombos[$i] = $this->acting[$i]["kt"] + 1;
			}
		}

        // дуэльные перки
        $player1PerkKnockout = Page::getPerkByCode("perk_knockout", $player1->id, $player1->clan, $player1->fraction);
        $player1PerkVampir = Page::getPerkByCode("perk_vampir", $player1->id, $player1->clan, $player1->fraction);
        $player2PerkKnockout = Page::getPerkByCode("perk_knockout", $player2->id, $player2->clan, $player2->fraction);
        $player2PerkVampir = Page::getPerkByCode("perk_vampir", $player2->id, $player2->clan, $player2->fraction);
        $player1PerkRatKiller = Page::getPerkByCode("perk_ratkiller", $player1->id, $player1->clan, $player1->fraction);

        $playe1SkipNext = $player2SkipNext = false;

		$q = 0;
		do {
			$q++;
			$step = array();
			$moves = array();
            $skipStep = false;

            $player1SkipNow = $player1SkipNext ? true : false;
            $player1SkipNext = false;
            $player2SkipNow = $player2SkipNext ? true : false;
            $player2SkipNext = false;

            // перки перед ударами
            if ($q == 1 && $player2->fraction == "npc" && $player2->type == NPC_RAT
                && $player1PerkRatKiller && $player1PerkRatKiller["value"] >= mt_rand(0, 100)) {
                $hp = round($this->acting[1]['hp'] * mt_rand(50, 100) / 1000);
                $moves[] = array(0, 1, array(33, $hp));
                $this->acting[1]['hp'] -= $hp;
                $skipStep = true;
            }

            if (!$skipStep) {
                // приемы
                $combos = array(false, false);
                for ($i = 0; $i <= 1; $i++) {
                    if ($this->acting[$i]['kt'] > 0) {
                        for ($j = $maxCombos[$i]; $j >= $minCombos[$i]; $j--) {
                            if (!$j)
                                break;
                            $combo = Page::$data["duels"]["combo"][$j][$this->acting[$i]["sx"]];
                            if ($combo["cooldown"] <= $cooldowns[$i]) {
                                if (mt_rand(1, 100) <= (($this->acting[$i]["ktmf"] / 20) * ($this->acting[$i]["ktmf"] / 20) * 20 + $comboChance[$j - $minCombos[$i]])) {
                                    if ($i == 0 || $combos[$i - 1] == false || $combos[$i - 1]["action"] == $combo["action"]) {
                                        $combo["kt"] = $j;
                                        $combos[$i] = $combo;
                                        $cooldowns[$i] = 0;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                // удары игроков
                if ($player1SkipNow) {

                } else {
					$target = 1;
                    $move = array(0, $target, $this->makeStrike(0, $target, $combos));
                    $moves[] = $move;

                    // перки после удара
                    if ($player1PerkKnockout && $player1PerkKnockout["value"] >= mt_rand(0, 100) && $move[2][1] > 0) {
                        $player2SkipNext = true;
                        $moves[] = array(0, 1, array(31, 0));
                    } elseif ($player1PerkVampir && $player1PerkVampir["value"] >= mt_rand(0, 100) && $move[2][1] > 0
                        && $this->acting[0]['hp'] < $player1->maxhp) {
                        $hp = $move[2][1] > $player1->maxhp - $this->acting[0]['hp'] ? $player1->maxhp - $this->acting[0]['hp'] : $move[2][1];
                        $this->acting[0]['hp'] += $hp;
                        $moves[] = array(0, 1, array(32, $hp));
                    }
                }
                if ($player2SkipNow) {

                } else {
					$target = 0;
                    $move = array(1, $target, $this->makeStrike(1, $target, $combos));
                    $moves[] = $move;

                    // перки после удара
                    if ($player2PerkKnockout && $player2PerkKnockout["value"] >= mt_rand(0, 100) && $move[2][1] > 0) {
                        $player1SkipNext = true;
                        $moves[] = array(1, 0, array(31, 0));
                    } elseif ($player2PerkVampir && $player2PerkVampir["value"] >= mt_rand(0, 100) && $move[2][1] > 0
                        && $this->acting[0]['hp'] < $player1->maxhp) {
                        $hp = $move[2][1] > $player2->maxhp - $this->acting[1]['hp'] ? $player2->maxhp - $this->acting[1]['hp'] : $move[2][1];
                        $this->acting[1]['hp'] += $hp;
                        $moves[] = array(1, 0, array(32, $hp));
                    }
                }

                // удар питомца атакующего
				$catch = $stun = $petToPlayer = 0;
                if (isset($attacker->pet) && $this->acting[2]['hp'] > 0) {
                    if (isset($defender->pet) && $this->acting[3]['hp'] > 0) {
						$target = 3;
						if (isset($attacker->pet) && $this->acting[2]['hp'] > 0 && isset($defender->pet) && $this->acting[3]['hp'] > 0) {
							if (rand(1, 100) <= $this->petGetChanceStunPet($attacker->pet, $defender->pet)) {
								$stun = 1;
							} else {
								if (rand(1, 100) <= $this->petGetChanceAttackPlayer($attacker->pet, $defender->pet)) {
									$target = 1;
									$petToPlayer = 1;
									if (rand(1, 100) <= $this->petGetChanceTankPlayer($attacker->pet, $defender->pet)) {
										$target = 3;
										$catch = 1;
										$petToPlayer = 0;
									}
								}
							}
						}
						if ($stun) {
							$move = array(2, $target, array(52));
							$moves[] = $move;
						} else if ($catch) {
							$s = $this->makeStrike(2, $target);
							$s[0] = 51;
							$move = array(2, $target, $s);
							$moves[] = $move;
						} else if ($petToPlayer) {
							$s = $this->makeStrike(2, $target, null, true);
							$s[0] = 50;
							$move = array(2, $target, $s);
							$moves[] = $move;
						} else {
							$move = array(2, $target, $this->makeStrike(2, $target));
							$moves[] = $move;
						}
                    } else {
                        $move = array(2, 1, $this->makeStrike(2, 1));
                        $moves[] = $move;
                    }
                }

                // удар питомца защищающегося
				$catch = $stun = $petToPlayer = 0;
                if (isset($defender->pet) && $this->acting[3]['hp'] > 0) {
                    if (isset($attacker->pet) && $this->acting[2]['hp'] > 0) {
						$target = 2;
						if (isset($attacker->pet) && $this->acting[2]['hp'] > 0 && isset($defender->pet) && $this->acting[3]['hp'] > 0) {
							if (rand(1, 100) <= $this->petGetChanceStunPet($defender->pet, $attacker->pet)) {
								$stun = 1;
							} else {
								if (rand(1, 100) <= $this->petGetChanceAttackPlayer($defender->pet, $attacker->pet)) {
									$target = 0;
									$petToPlayer = 1;
									if (rand(1, 100) <= $this->petGetChanceTankPlayer($defender->pet, $attacker->pet)) {
										$target = 2;
										$catch = 1;
										$petToPlayer = 0;
									}
								}
							}
						}
						if ($stun) {
							$move = array(3, $target, array(52));
							$moves[] = $move;
						} else if ($catch) {
							$s = $this->makeStrike(3, $target);
							$s[0] = 51;
							$move = array(3, $target, $s);
							$moves[] = $move;
						} else if ($petToPlayer) {
							$s = $this->makeStrike(3, $target, null, true);
							$s[0] = 50;
							$move = array(3, $target, $s);
							$moves[] = $move;
						} else {
							$move = array(3, $target, $this->makeStrike(3, $target));
							$moves[] = $move;
						}
                    } else {
                        $move = array(3, 0, $this->makeStrike(3, 0));
                        $moves[] = $move;
                    }
                }
            }

			// осталось жизней
			$hp = array();
			//foreach ($this->acting as $key => $act) {
			//	$hp[$key] = $act['hp'];
			//}
			for ($i = 0; $i < 4; $i++) {
				$hp[] = isset($this->acting[$i]) ? $this->acting[$i]['hp'] : 0;
			}
			$step[] = $moves;
			$step[] = $hp;
			$this->log[] = $step;

			$cooldowns[0]++;
			$cooldowns[1]++;

            $player1SkipNow = false;
            $player2SkipNow = false;
		} while ($this->acting[0]['hp'] > 0 && $this->acting[1]['hp'] > 0 && $q < 100);

		$logSpecial = array();

		$werewolfWin = false;
		// определение победителя и проигравшего
		if (($this->acting[0]['hp'] <= 0 && $this->acting[1]['hp'] <= 0) || $this->acting[0]['hp'] == $this->acting[1]['hp']) {
			$this->winner = 0;
			$this->looser = 0;
		} elseif ($this->acting[0]['hp'] > 0) {
			$this->winner = $player1;
			$this->looser = $player2;
			if ($werewolf) {
				$werewolfWin = true;
			}
		} else {
			$this->winner = $player2;
			$this->looser = $player1;
		}

		if ($player1Moto && is_object($this->winner) && $this->winner->id == $player2->id && $player1Moto->type == 'tech' && $player1Moto->subtype == 'moto' && $player1Moto->level > 2 && $player1Moto->mf >= 40) {
			if (mt_rand(1, 100) < (int) $player1Moto->special4) {
				$hp = array();
				for ($i = 0; $i < 4; $i++) {
					$hp[] = isset($this->acting[$i]) ? $this->acting[$i]['hp'] : 0;
				}
				$this->log[] = array(array(array(0, 0, array(12, 0))), $hp);

				$this->winner = 0;
				$this->looser = 0;
			}
		}

		if ($this->winner !== 0) {

			if ($npc || $werewolf) {
				$warId = 0;
			} else {
				$warId = diplomacyObject::areAtWar($this->looser->clan, $this->winner->clan);
			}

			// охотничий клуб
			$hunt = false;
			if (!$npc) {
				if ($player2->wanted == 1 && strtotime($player1->huntdt) > time() && (abs(Page::getGroupLevel($player1->level) - Page::getGroupLevel($player2->level)) <= 1 || Page::getGroupLevel($player1->level) == Page::getGroupLevel($player2->level) - 2)) {
					$player1Complete = $this->sql->getValue("SELECT count(*) FROM " . Page::$__LOG_TABLE__ . " WHERE player=" . $player1->id . "
                        AND type = 'fighthntclb'");
					$player1Prof = $player1->getProf(Page::$data['huntclub']['rangs'], "skillhunt");
					if ($player1Complete < (10 + $player1Prof["i"])) {
						$hunt = $this->sql->getRecord("SELECT id, award, player2, kills, kills2, xmoney FROM hunt WHERE player = " . $player2->id . "
                            AND state = 1 AND player2 != " . $player1->id . " ORDER BY xmoney DESC, award DESC");
					}
				}
			}

			// ограбление
			if ($npc) {
				if ($this->winner->id == $player1->id) {
					$profit = $player2->getPlayerProfit();
					$this->winner->money += $profit['money'];
					$this->winner->ore += $profit['ore'];
                    $this->winner->oil += $profit['oil'];
				} else {
					$profit = $player2->getNpcProfit();
					$this->looser->money -= $profit['money'];
				}
				$this->params['pft'] = array(
					'm' => (int) $profit['money'],
					'o' => (int) $profit['ore'],
                    'n' => (int) $profit['oil'],
				);
				$this->profit = (int) $profit['money'];
				$this->profit2 = $this->profit;
			} else {
				// определение количества (рамок) награбленного
				if ($difference >= 2) {
					$minprobability = 7;
					$maxprobability = 19;
				} elseif ($difference == 1) {
					$minprobability = 6;
					$maxprobability = 17;
				} elseif ($difference == -1) {
					$minprobability = 5;
					$maxprobability = 10;
				} elseif ($difference <= -2) {
					$minprobability = 3;
					$maxprobability = 8;
				} else {
					$minprobability = 5;
					$maxprobability = 15;
				}

				// влияние войны
				if ($warId) {
					$minprobability *= 2;
					$maxprobability *= 2;
				}

				if ($hunt && $hunt["xmoney"] == 2) {
					if ($warId) {
						$minprobability *= 1.5;
						$maxprobability *= 1.5;
					} else {
						$minprobability *= 2;
						$maxprobability *= 2;
					}
				}

				if ($this->winner->id == $player1->id) {
					$utug = $player1->getItemByCode("utjug");
					if ($utug && $utug->unlocked == 1) {
						$minprobability += $utug->special1;
						$maxprobability += $utug->special1;
						$utug->useWithNoEffect();
						$logSpecial["utug"] = $utug->special1;
					}
				}

				$r = mt_rand($minprobability, $maxprobability);

				// влияние харизмы
				$charismInfluence = $this->winner->charism / ($this->winner->charism + $this->looser->charism) * ($maxprobability - $r);
				$r += $charismInfluence;

				// влияние сефа
				$safe = $this->looser->getItemByType('home_safe');
				$safeMoney = $safe && $safe->unlocked == 1 ? 500 * $this->looser->level : 0;

				// начисление награбленного
				$money = floor($r / 100 * ($this->looser->money > $safeMoney ? $this->looser->money - $safeMoney : 0));
				$this->realprofit = $money;
				if ($money > 0) {
					$this->profit = ((int) $money);
					$this->profit2 = $this->profit;
					$this->winner->money += $money;
					$this->looser->money -= $money;
				}
				if ($this->winner->level <= 2) {
					if ($this->profit < 10) {
						switch ($this->winner->level) {
							case 1 :
								$money = rand(10, 20);
								break;
							case 2 :
								$money = rand(10, 35);
								break;
						}
					}
					$this->winner->money -= $this->profit;
					$this->winner->money += $money;
					$this->profit = $money;
				}

				// выдача нефти победителю
				if (!$werewolf && !$npc && $this->winner->id == $player1->id && $this->winner->level >= 10 && Page::getGroupLevel($this->winner->level) <= Page::getGroupLevel($this->looser->level)) {
					if (mt_rand(1, 100) <= 30 && Page::$player->data['nft_d'] < mktime(0, 0, 0) + 150) { // если великий рандом благосклоннен
						$am = rand(8, 12);
						$this->winner->oil += $am;
						$this->params['pft']['n'] = $am;
						$this->params['pft']['m'] = $money;
						Page::$player->data['nft_d'] += $am;
						Page::$player->saveData();
					}
				}
			}

            // очки в противостоянии
			if (!$werewolf && !$player2->neftDuel) {
				if (date("N", time()) == 4) {
					$sovet3 = $this->sql->getRecord("SELECT id, enemy, points1 FROM sovet3 WHERE fraction = '" . $player1->fraction . "' ORDER BY id DESC LIMIT 0,1");
					$sovet3Enemy = $this->sql->getRecord("SELECT id, enemy, points1 FROM sovet3 WHERE fraction = '" . ($player1->fraction == "arrived" ? "resident" : "arrived") . "' ORDER BY id DESC LIMIT 0,1");

					if ($sovet3["enemy"] == "npc" &&                                                     // если война с NPC
						$npc && in_array($player2->type, array(NPC_RAIDER, NPC_RIELTOR, NPC_GRAFTER))) { // и напали на npc Рейдеров/Риэлторов/Взяточников
						// то апдейтим нашу войну
						$pts = Page::getGroupLevel($player1->level);
						if ($this->winner->id == $player1->id) {
							// если атакер победил, то получает очки для своей фракции
							$this->sql->query("UPDATE sovet3 SET points1 = points1 + " . $pts . " WHERE id = " . $sovet3["id"]);
							$this->sql->query("UPDATE player2 SET sovetpoints2 = sovetpoints2 + 1 WHERE player = " . $player1->id);
						} else {
							// если не победил, то очки получает npc
							$this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + " . $pts . " WHERE id = " . $sovet3["id"]);
						}
					} elseif ($sovet3["enemy"] == "npc" &&        // если война с NPC
								!$npc &&                          // и напали на игрока
								$sovet3Enemy["enemy"] == "npc") { // а у нашего врага война с NPC
						// то ничего не делаем
					} elseif ($sovet3["enemy"] == "npc" &&                     // если война с NPC
								!$npc &&                                       // и напали на игрока
								$sovet3Enemy["enemy"] == $player1->fraction) { // а другая фракция напала на нас
						// то апдейтим войну другой фракции (против нас)
						$level1 = Page::getGroupLevel($player1->level);
						$level2 = Page::getGroupLevel($player2->level);
						if ($level1 >= $level2) {
							$pts = $level2;
						} else if ($level1 - $level2 < 1) {
							$pts = ceil($level2 / 2);
						}
						if ($this->winner->id == $player1->id) {
							// при победе атакера мы (фракция-защитник) получаем очки в не своей войне
							$this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + " . $pts . " WHERE id = " . $sovet3Enemy["id"]);
							$this->sql->query("UPDATE player2 SET sovetpoints2 = sovetpoints2 + 1 WHERE player = " . $player1->id);
						} else {
							// при поражении атакера они (фракция-атакер) получают очки в своей войне
							$this->sql->query("UPDATE sovet3 SET points1 = points1 + " . $pts . " WHERE id = " . $sovet3Enemy["id"]);
						}
					} elseif ($sovet3["enemy"] != "npc" &&        // если война с другой фракцией
								!$npc &&                          // и напали на игрока этой фракции
								$sovet3Enemy["enemy"] == "npc") { // а она воет с npc
						// то апдейтим нашу войну
						$level1 = Page::getGroupLevel($player1->level);
						$level2 = Page::getGroupLevel($player2->level);
						if ($level1 >= $level2) {
							$pts = $level2;
						} else if ($level1 - $level2 < 1) {
							$pts = ceil($level2 / 2);
						}
						if ($this->winner->id == $player1->id) {
							// при победе атакера мы (фракция-защитник) получаем очки в своей войне
							$this->sql->query("UPDATE sovet3 SET points1 = points1 + " . $pts . " WHERE id = " . $sovet3["id"]);
							$this->sql->query("UPDATE player2 SET sovetpoints2 = sovetpoints2 + 1 WHERE player = " . $player1->id);
						} else {
							// при поражении атакера они (фракция-атакер) получают очки в не своей войне
							$this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + " . $pts . " WHERE id = " . $sovet3["id"]);
						}
					} elseif ($sovet3["enemy"] != "npc" &&                     // если война с другой фракцией
								!$npc &&                                       // и напали на игрока этой фракции
								$sovet3Enemy["enemy"] == $player1->fraction) { // и у нее война с нами
						// то апдейтим обе войны
						$level1 = Page::getGroupLevel($player1->level);
						$level2 = Page::getGroupLevel($player2->level);
						if ($level1 >= $level2) {
							$pts = $level2;
						} else if ($level1 - $level2 < 1) {
							$pts = ceil($level2 / 2);
						}
						if ($this->winner->id == $player1->id) {
							$this->sql->query("UPDATE sovet3 SET points1 = points1 + " . $pts . " WHERE id = " . $sovet3["id"]);
							$this->sql->query("UPDATE player2 SET sovetpoints2 = sovetpoints2 + 1 WHERE player = " . $player1->id);
							$this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + " . $pts . " WHERE id = " . $sovet3Enemy["id"]);
						} else {
							$this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + " . $pts . " WHERE id = " . $sovet3["id"]);
							$this->sql->query("UPDATE sovet3 SET points1 = points1 + " . $pts . " WHERE id = " . $sovet3Enemy["id"]);
						}
					}
					/* глючный код
					elseif ($sovet3['enemy'] != 'npc' && !$npc) {
						}
						$level1 = Page::getGroupLevel($player1->level);
						$level2 = Page::getGroupLevel($player2->level);
						if ($level1 >= $level2) {
							$pts = $level2;
						} else if ($level1 - $level2 < 1) {
							$pts = ceil($level2 / 2);
						}
						// если у нас война с другой фракцией и мы напали на игрока этой фракции
						if ($this->winner->id == $player1->id) {
							// если игрок победил, то получает очки для своей фракции
							$this->sql->query("UPDATE sovet3 SET points1 = points1 + " . $pts . " WHERE id = " . $sovet3["id"]);
							$this->sql->query("UPDATE player2 SET sovetpoints2 = sovetpoints2 + 1 WHERE player = " . $player1->id);
						} else {
							$this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + " . $pts . " WHERE id = " . $sovet3["id"]);
						}
					}
					*/


                    /*if (
							(!$npc && $sovet3["enemy"] != "npc" && ($player1->level - 3) <= $player2->level) ||
							($npc && $sovet3["enemy"] == "npc" && in_array($player2->type, array(NPC_RAIDER, NPC_RIELTOR, NPC_GRAFTER)))
						) {
						if ($this->winner->id == $player1->id) {
							$this->sql->query("UPDATE sovet3 SET points1 = points1 + 1 WHERE id = " . $sovet3["id"]);
							$this->sql->query("UPDATE player2 SET sovetpoints2 = sovetpoints2 + 1 WHERE player = " . $player1->id);
						} else {
							$this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + 1 WHERE id = " . $sovet3["id"]);
						}
					} elseif (!$npc && $sovet3Enemy["enemy"] == $player1->fraction && (Page::getGroupLevel($player1->level) - 3) <= Page::getGroupLevel($player2->level)) {
                        if ($this->winner->id == $player1->id) {
                            $this->sql->query("UPDATE sovet3 SET points1enemy = points1enemy + 1 WHERE id = " . $sovet3Enemy["id"]);
                            $this->sql->query("UPDATE player2 SET sovetpoints2 = sovetpoints2 + 1 WHERE player = " . $player1->id);
                        } else {
                            $this->sql->query("UPDATE sovet3 SET points1 = points1 + 1 WHERE id = " . $sovet3Enemy["id"]);
                        }
                    }*/
				}
			}


			// выпадание вещей в бою
			if ($npc) {
				$result = $player2->getDroppedItems();
			} else {
				$wins = (int) $this->winner->data['wins_on_level'];
				var_dump(Page::$data['reward']['wins_on_level'][$this->winner->level][$wins+1]);
				if (isset(Page::$data['reward']['wins_on_level'][$this->winner->level][$wins+1])) {
					$result = Page::$data['reward']['wins_on_level'][$this->winner->level][$wins+1];
					$this->winner->data['wins_on_level'] = $wins + 1;
					$this->winner->saveData();
				}
			}
			if ($result != false) {
				if ($result['duellogtext']) {
					$this->log[] = array('duellogtext', str_replace('%winner%', $this->winner->nickname . ' [' . $this->winner->level . ']', $result['duellogtext']));
				}
				Page::fullActions($this->winner, $result, @$result['alert_text']);
			}

			// опыт за победу
			if ($npc && $this->winner->id == $player1->id) {
				$giveXp = true;
				$exp = 0;
				if (date("N", time()) == 4) {
					$sovet3 = $this->sql->getRecord("SELECT id, enemy, points1 FROM sovet3 WHERE fraction = '" . $player1->fraction . "' ORDER BY id DESC LIMIT 0,1");
					if ($sovet3["enemy"] == "npc" && in_array($player2->type, array(NPC_RAIDER, NPC_RIELTOR, NPC_GRAFTER))) {
						$perk = Page::getPerkByCode("perk_noexp");
						if ($perk && $perk["value"] >= mt_rand(1, 100)) {
							$giveXp = false;
						}
					}
				}
				if ($giveXp) {
					$exp = $player2->getExp();
					$this->winner->increaseXP($exp, false);
				}
			} elseif (!$npc) {
				$difference = Page::getGroupLevel($this->looser->level) - Page::getGroupLevel($this->winner->level);
				if (isset(Page::$data['expfights'][$difference])) {
					$exp = Page::$data['expfights'][$difference];
				} else {
					if ($difference > max(array_keys(Page::$data['expfights']))) {
						$exp = Page::$data['expfights'][max(array_keys(Page::$data['expfights']))];
					} else if ($difference < min(array_keys(Page::$data['expfights']))) {
						$exp = Page::$data['expfights'][min(array_keys(Page::$data['expfights']))];
					}
				}
				if (!$werewolfWin) {
					$this->winner->increaseXP($exp, false);
				}
			}
		}

		if (!$werewolf && !$npc) {
			$this->onFightBetweenPlayersEnd();
		}

		if (!$npc && $this->winner->id == $this->attacker->id) {
			$this->onAttackerWins();
		}

		if ($werewolf) {
			$werewolfLevel = $attacker->level;
			$attacker->level = $attacker->stateparam;
			if ($werewolfWin) {
				$this->winner->increaseXP($exp, false);
			}
		}

		// здоровье питомцев
		if (isset($this->acting[2]) && !$werewolf) {
			$player1->pet->setHP($this->acting[2]['hp'], $player1->pet->mood - rand(5, 15));
		}
		if (!$npc && isset($this->acting[3])) {
			$player2->pet->setHP($this->acting[3]['hp'], $player2->pet->mood - rand(5, 15));
		}
		// увеличение характеристик питомца за победу
		if (!$werewolfWin) {
			if (is_a($this->winner->pet, 'petObject') &&
				(is_a($this->looser->pet, 'petObject') || is_a($this->looser->pet, 'NpcPet')) &&
				($this->looser->level >= $this->winner->level || $npc) &&
				$this->winner->pet->hp > 0 &&
				($this->winner->pet->item == $this->looser->pet->item ||
					//Page::$sql->getValue("SELECT itemlevel FROM standard_item WHERE id = " . $this->winner->pet->item) <= Page::$sql->getValue("SELECT itemlevel FROM standard_item WHERE id = " . $this->looser->pet->item))
					Page::getData("pet_itemlevel_" . $this->winner->pet->item, "SELECT itemlevel FROM standard_item WHERE id = " . $this->winner->pet->item, "value", 3600) <=
					Page::getData("pet_itemlevel_" . $this->looser->pet->item, "SELECT itemlevel FROM standard_item WHERE id = " . $this->looser->pet->item, "value", 3600)
				)
			) {
				$this->winner->pet->procent = min($this->winner->pet->procent + 0.05, 80);
				$this->winner->pet->wins++;
				$this->winner->pet->save(array(petObject::$PROCENT, petObject::$WINS));
			}
		}

		// респект
		if (!$npc && $this->winner->id == $player1->id) {
			$statDiff = $player1->statsum / $player2->statsum;
			$levelDiff = $player1->level - $player2->level;
			if ($statDiff > 1.1 && $levelDiff > 1) {
				$player1->respect--;
			} elseif ($statDiff < 1.1 && $levelDiff <= 0) {
				$player1->respect += 2;
			} else {
				$player1->respect++;
			}
		}

		//
		$player1->reloadFightTimer();
		//$player2->reloadFightTimer();
		if (!$werewolf) {
			$player1->setHP($this->acting[0]['hp']);
		}
		if (!$npc) {
			$player2->setHP($this->acting[1]['hp']);
		}
		if ($player1->level > 1 && !$npc) {
			$player1->suspicion = min(5, $player1->suspicion + 1);
		}
		//$player2->suspicion = min(5, $player2->suspicion + 1);
		$player1->state = '';
		
		$fields2save = array(playerObject::$STATE, playerObject::$LEVEL, playerObject::$EXP, playerObject::$SUSPICION, playerObject::$MONEY, playerObject::$ORE, playerObject::$LASTFIGHT, playerObject::$RESPECT);
        if (!$werewolf) {
			$fields2save[] = playerObject::$OIL;
		}
        $player1->saveData($fields2save);

		// восстанавливаем того, на кого напали
		if (!$npc) {
			$player2->lasttimeattacked = time();
			if ($player2->state2 != '') {
				$player2->state2 = json_decode($player2->state2, true);
				$player2->state = $player2->state2['state'];
				//$flagPlayer->stateparam = $flagPlayer->state2['stateparam'];
				$player2->timer = $player2->state2['timer'];
				$player2->state2 = '';
				$player2->saveData(array(playerObject::$STATE, playerObject::$LEVEL, playerObject::$EXP, playerObject::$SUSPICION, playerObject::$MONEY, playerObject::$LASTFIGHT, playerObject::$RESPECT, playerObject::$STATEPARAM, playerObject::$TIMER, playerObject::$STATE2, playerObject::$LASTTIMEATTACKED));
				$query = "UPDATE player SET
					state = '" . $player2->state . "', level = " . $player2->level . ", exp = " . $player2->exp . ",
					suspicion = " . $player2->suspicion . ", lastfight = " . $player2->lastfight . ", respect = " . $player2->respect . ",
					timer = " . $player2->timer . ", state2 = '', lasttimeattacked = " . $player2->lasttimeattacked . ",
					money = money " . ($this->winner->id == $player2->id ? '+' : '-') . " " . ((int) $this->realprofit) . "
					WHERE id = " . $player2->id;
			} else {
				$player2->state = '';
				$player2->saveData(array(playerObject::$STATE, playerObject::$LEVEL, playerObject::$EXP, playerObject::$SUSPICION, playerObject::$MONEY, playerObject::$LASTFIGHT, playerObject::$RESPECT, playerObject::$LASTTIMEATTACKED));
			}
		}

		// автохил
		if ($this->looser->id == $player2->id) { // если проиграл тот, на кого напали
			$warId = diplomacyObject::isAtActiveWar($this->looser->clan);
			if ($warId) {
				$dip = new diplomacyObject();
				$dip->load($warId);
				if ($dip->state == 'step1' && $dip->getKillsLeft($this->looser->id) > 0) {
					// мазь
					$item = $this->looser->loadItemByCode('clan_malahoff');
					if ($item) {
						$item->player = $this->looser;
						$item->useItem();
					} else {
						// скорая
						$item = $this->looser->loadItemByCode('clan_embulance');
						if ($item) {
							$item->player = $this->looser;
							$item->useItem();
						}
					}
				}
			}

			if (!$npc) {
				Page::checkEvent($player1->id, 'pvp_win_over_' . $player2->level);
			}
		}
		//

		$winner = $this->winner;
		$this->winner = (int) $winner->id;
		$this->player1 = $player1->id;
		$this->player2 = $player2->id;
		$this->time = time();
		$this->exp = (int) $exp;
		$this->acting = $beforeActing;
		if ($werewolf) {
			$this->params['werewolf'] = 1;
		}

		if ($player2->neftDuel) {
			$this->params['neft'] = 1;
		}

		if ($player2->neftDuel) {
			$this->params['neft'] = 1;
		}
		
		$attacks = array(1 => array(), 2 => array());
		for ($i = 1; $i <= 2; $i ++) {
			while (count($attacks[$i]) < 3) {
				$w = rand(0, count(Page::$data['duels']['weapons']) - 1);
				if (!isset($attacks[$i][$w])) {
					$attacks[$i][$w] = rand(1, Page::$data['duels']['weapons'][$w]['weapons']);
				}
			}
		}
		$this->params['attacks'] = $attacks;

		$this->params = json_encode($this->params);
		$this->save();
		$this->winner = $winner;

		$this->params = json_decode($this->params, true);

		if (!$npc) {
			if (!$werewolf) {
				$logSpecial["zub"] = false;
				if ($this->winner->id == $player1->id && $player1->clan_status != 'recruit') {
					// военные штучки
					$warId = diplomacyObject::areAtWar($this->looser->clan, $this->winner->clan);
					// если война, то увеличиваем счетчик убийств
					
					if ($warId) {
						$dip = new diplomacyObject();
						$dip->load($warId);
						$logSpecial["zub"] = $dip->addKills($this->looser, $this->winner, $this->id) ? 1 : 0;

						// попытка перейти ко второму этапу войны или завершить войну победой защищающихся
						$dip->tryEndStep1();
					}
				}

			}
			// охотничий клуб
			if ($hunt) {
				Std::loadMetaObjectClass("huntlog");
				$hl = new huntlogObject();
				$hl->hunt = $hunt["id"];
				$hl->duel = $this->id;
				$hl->player = $player1->id;
				$hl->dt = date("Y-m-d H:i:s", time());

				if ($this->winner->id == $player1->id) {
					if ($werewolf) {
						$level = Page::getGroupLevel($werewolfLevel);
					} else {
						$level = Page::getGroupLevel($player1->level);
					}
					$level2 = Page::getGroupLevel($player2->level);
					if ($level == $level2) {
						$badges = Page::$data['huntclub']['badgesforkill'][1];
						$mobilkaChance = Page::$data['huntclub']['mobilkaforkill'][1];
					} elseif ($level - 1 == $level2) {
						$badges = Page::$data['huntclub']['badgesforkill'][0];
						$mobilkaChance = Page::$data['huntclub']['mobilkaforkill'][0];
					} elseif ($level + 1 == $level2) {
						$badges = Page::$data['huntclub']['badgesforkill'][2];
						$mobilkaChance = Page::$data['huntclub']['mobilkaforkill'][2];
					} elseif ($level + 2 == $level2) {
						$badges = Page::$data['huntclub']['badgesforkill'][3];
						$mobilkaChance = Page::$data['huntclub']['mobilkaforkill'][3];
					} else {
						$badges = 0;
					}
					if ($badges > 0) {
						if ($mobilkaChance > 0) {
                            $boost = Page::getPerkByCode("perk_mobile");
                            if ($boost) {
                                $mobilkaChance += $boost["value"];
                            }
                        }

                        Std::loadMetaObjectClass('standard_item');
						$item = new standard_itemObject();
						$item->loadByCode("huntclub_badge");
						$item->makeExampleOrAddDurability($player1->id, $badges);

						if (mt_rand(1, 100) <= $mobilkaChance) {
							$mobilka = 1;
							$item = new standard_itemObject();
							$item->loadByCode("huntclub_mobile");
							$item->makeExampleOrAddDurability($player1->id);
						} else {
							$mobilka = 0;
						}

						if ($hunt["award"] > 0) {
							$award = floor($hunt["award"] / 3);
							$player1->money += $award;
							$player1->save($player1->id, array(playerObject::$MONEY));
						} else {
							$award = 0;
						}

						$this->sql->query("UPDATE rating_player2 SET huntkills = huntkills + 1, huntkills_day = huntkills_day + 1,
                            huntkills_week = huntkills_week + 1, huntkills_month = huntkills_month + 1, huntaward = huntaward + " . $award . ",
                            huntaward_day = huntaward_day + " . $award . ", huntaward_week = huntaward_week + " . $award . ",
                            huntaward_month = huntaward_month + " . $award . " WHERE player = " . $player1->id);

						if ($badges >= 3) {
							$this->sql->query("UPDATE player SET skillhunt = skillhunt + 1 WHERE id = " . $player1->id);
						}

						$logSpecial["hnt"] = array(
							'b' => $badges,
							'm' => $mobilka,
							'a' => $award,
						);

						$hl->kill = 1;
						$hl->save();
					}
				} else {
					if (abs($player1->level - $player2->level) <= 1) {
						$hl->kill = 0;
						$hl->save();
					}
				}

				if ($hunt["kills2"] + 1 >= $hunt["kills"]) {
					$this->sql->query("UPDATE hunt SET kills2 = kills2 + 1, state = 2 WHERE id = " . $hunt["id"]);
					if ($this->sql->getvalue("SELECT count(*) FROM hunt WHERE player = " . $player2->id . "
                        AND state IN (0,1) ") == 0) {
						$this->sql->query("UPDATE player SET wanted = 0 WHERE id = " . $player2->id);
					}
				} else {
					$this->sql->query("UPDATE hunt SET kills2 = kills2 + 1 WHERE id = " . $hunt["id"]);
				}
			}

			if (sizeof($logSpecial)) {
				foreach ($logSpecial as $key => $value) {
					$this->params[$key] = $value;
				}

				$this->params = json_encode($this->params);

				$winner = $this->winner;
				$this->winner = (int) $winner->id;
				$this->updateInMongo($this->id);
				$this->winner = $winner;

				$this->params = json_decode($this->params, true);
			}
		}

		// Хак, чтобы пересчитать уровень
		if ($this->winner && (!$npc || $this->winner->id == $player1->id)) {
			$oldLevel = $this->winner->level;
			$this->winner->increaseXP(0);
			if ($this->winner->level > $oldLevel) {
				$this->winner->saveData(array(playerObject::$LEVEL, playerObject::$EXP));
			}
		}

		// логи
		$mbckp = $player1->getMbckp();
		$mbckp['m'] -= (int)$logSpecial["hnt"]["a"];
		$log = array('fight_id' => $this->id, 'flag' => $this->flag, 'result' => ($player1->id == $this->winner->id) ? 'win' : ($this->winner == 0 ? 'draw' : 'loose'),
			'profit' => $this->profit, 'exp' => $this->exp,
			'player' => array('id' => $player2->id, 'nickname' => $player2->nickname, 'level' => $player2->level, 'fraction' => $player2->fraction),
			'mbckp' => $mbckp, 'pft' => $this->params['pft'], 'carpart' => $this->params['carpart']);
		if ($zub) {
			$log['zub'] = 1;
		}
		if ($werewolf) {
			$log['werewolf'] = 1;
		}
		$log = array_merge($log, $logSpecial);

		Page::sendLog($player1->id, 'fight_attacked', $log, 1);
		if (!$npc) {
			$mbckp = $player2->getMbckp();
			$log = array('fight_id' => $this->id, 'flag' => $this->flag, 'result' => ($player2->id == $this->winner->id) ? 'win' : ($this->winner == 0 ? 'draw' : 'loose'), 'profit' => $this->profit2, 'exp' => $this->exp, 'player' => array('id' => $player1->id, 'nickname' => $player1->nickname, 'level' => ($werewolf ? $werewolfLevel : $player1->level), 'fraction' => $player1->fraction), 'mbckp' => $mbckp);
			if ($werewolf) {
				$log['werewolf'] = 1;
			}
			Page::sendLog($player2->id, 'fight_defended', $log, 0);
		}

		if ($logSpecial["hnt"]) {
			$log = array('dl' => $this->id, 'a' => $logSpecial["hnt"]["a"], 'm' => $logSpecial["hnt"]["m"], 'b' => $logSpecial["hnt"]["b"]);
			if ($werewolf) {
				$log['werewolf'] = 1;
			}
			if ($logSpecial["hnt"]["a"] > 0) {
				$log["mbckp"] = $player1->getMbckp();
			}
			Page::sendLog($player1->id, 'fighthntclb', $log, 1);
		}
	}

	/**
	 * Рассчет удара
	 *
	 * @param array $attacker
	 * @param array $defender
	 * @return array
	 */
	public function makeStrike($attackerIndex, $defenderIndex, $combos = false, $hit = false) {
		$attacker = & $this->acting[$attackerIndex];
		$defender = & $this->acting[$defenderIndex];

		$step = array();
		if ($hit || $this->antiWhiningSP($attackerIndex, $defenderIndex, self::r(), $this->precalculatedValues[$attackerIndex][$defenderIndex]['sp']) <= $this->precalculatedValues[$attackerIndex][$defenderIndex]['sp']) {
			if ($this->antiWhiningCSP($attackerIndex, $defenderIndex, self::r(), $this->precalculatedValues[$attackerIndex][$defenderIndex]['csp']) <= $this->precalculatedValues[$attackerIndex][$defenderIndex]['csp']) {
				$dp = self::calcCDP($attacker, $defender);
				$step[] = 2;
				$this->strikeStats[$attackerIndex.'_'.$defenderIndex]['hits']++;
				$this->strikeStats[$attackerIndex.'_'.$defenderIndex]['crits']++;
			} else {
				$dp = self::calcDP($attacker, $defender);
				$step[] = 1;
				$this->strikeStats[$attackerIndex.'_'.$defenderIndex]['hits']++;
			}
			$dmg = floor(self::calcResist($attacker, $defender) * $dp); // сколько урона поглощено защитой
			$dp -= $dmg;
            $dp = $dp > 0 ? $dp : 1;

			if ($combos) {
				if ($combos[$attackerIndex]["action"] == "adddamage") {
					$dp += $combos[$attackerIndex]["value"] > 1 ? $combos[$attackerIndex]["value"] : $dp * $combos[$attackerIndex]["value"] * 10;
					$step[0] = 21;
				} elseif ($combos[$defenderIndex]["action"] == "blockdamage") {
					$dp -= $combos[$defenderIndex]["value"] > 1 ? $combos[$defenderIndex]["value"] : $dp * $combos[$defenderIndex]["value"] * 10;
					$dp = $dp < 0 ? 0 : $dp;
					$step[0] = 22;
				}
				/*
				  if ($attackerIndex == 0 && $combos[0]["action"] == "adddamage") {
				  $dp += $combos[0]["value"] > 1 ? $combos[0]["value"] : $dp * $combos[0]["value"] * 10;
				  $step[0] = 21;
				  } elseif ($attackerIndex == 0 && $combos[1]["action"] == "blockdamage") {
				  $dp -= $combos[1]["value"] > 1 ? $combos[1]["value"] : $dp * $combos[1]["value"] * 10;
				  $dp = $dp < 0 ? 0 : $dp;
				  $step[0] = 22;
				  } elseif ($defenderIndex == 1 && $combos[1]["action"] == "adddamage") {
				  $dp += $combos[1]["value"] > 1 ? $combos[1]["value"] : $dp * $combos[1]["value"] * 10;
				  $step[0] = 21;
				  } elseif ($defenderIndex == 1 && $combos[0]["action"] == "blockdamage") {
				  $dp -= $combos[0]["value"] > 1 ? $combos[0]["value"] : $dp * $combos[0]["value"] * 10;
				  $dp = $dp < 0 ? 0 : $dp;
				  $step[0] = 22;
				  }
				 */
			}

			$step[] = $dp;

			if ($combos) {
				if ($combos[$attackerIndex]["action"] == "adddamage") {
					$step[] = -1;
					$step[] = $combos[$attackerIndex]["kt"];
				} elseif ($combos[$defenderIndex]["action"] == "blockdamage") {
					$step[] = -1;
					$step[] = $combos[$defenderIndex]["kt"];
				}
			}

			$defender['hp'] = max(0, $defender['hp'] - $dp);
		} else {
			$step[] = 0;
		}
		$this->strikeStats[$attackerIndex.'_'.$defenderIndex]['strikes']++;
		return $step;
	}

	public function makeStrikeSpecial($type, $attackerIndex, $defenderIndex, $damage) {
		$attacker = & $this->acting[$attackerIndex];
		$defender = & $this->acting[$defenderIndex];

		$step = array();
		switch ($type) {
			case 'naezd':
				$this->strikeStats[$attackerIndex.'_'.$defenderIndex]['hits']++;
				$this->strikeStats[$attackerIndex.'_'.$defenderIndex]['strikes']++;
				$step = array(11, $damage);
				$defender['hp'] = max(0, $defender['hp'] - $damage);
				break;
		}

		return $step;
	}

	/**
	 * Корректировака вероятности удара
	 *
	 * @param array $player
	 * @param float $rand
	 * @param float $targetSP
	 * @return float
	 */
	private function antiWhiningSP($attackerIndex,$defenderIndex, $rand, $targetSP) {
		if ($this->strikeStats[$attackerIndex.'_'.$defenderIndex]['strikes'] >= 3) {
			$realSP = $this->strikeStats[$attackerIndex.'_'.$defenderIndex]['hits'] / $this->strikeStats[$attackerIndex.'_'.$defenderIndex]['strikes'];
			$correction = $targetSP - $realSP;
			return $rand - $correction * 5;
		} else {
			return $rand;
		}
	}

	/**
	 * Корректировка вероятности критического удара
	 *
	 * @param array $player
	 * @param float $rand
	 * @param float $targetCSP
	 * @return float
	 */
	private function antiWhiningCSP($attackerIndex,$defenderIndex, $rand, $targetCSP) {
		if ($this->strikeStats[$attackerIndex.'_'.$defenderIndex]['hits'] >= 3) {
			$realCSP = $this->strikeStats[$attackerIndex.'_'.$defenderIndex]['crits'] / $this->strikeStats[$attackerIndex.'_'.$defenderIndex]['hits'];
			$correction = $targetCSP - $realCSP;
			return $rand - $correction * 5;
		} else {
			return $rand;
		}
	}

	/**
	 * Рассчет вероятности удара
	 *
	 * @param array $attacker
	 * @param array $defender
	 * @return int
	 */
	public static function calcSP($attacker, $defender) {
		$spBase = 1;
		$dodge = (self::calcDodgeRating($defender) * (1 - ((int) $defender['weakness']) ) - ((int) $attacker['ra'])) / ($attacker['d'] * 5 + $attacker['ss'] * 2) + ((int) $defender['pdod']/100) - ((int) $attacker['phit']/100);
		$result = $spBase + self::calcLevelInfluence($attacker, $defender) - $dodge;
		return $result;
	}

	/**
	 *  Рейтинг уворота
	 *
	 * @param object $player
	 * @return int
	 */
	private static function calcDodgeRating($player) {
//echo $player['id'].'[dodge] = ' . (int)$player['rd'] . '; ';
		$dodgeRating = $player['a'] * 5 + (int) $player['rd'];
		return $dodgeRating;
	}

	/**
	 * Рассчет вероятности критического удара
	 *
	 * @param array $attacker
	 * @param array $defender
	 * @return int
	 */
	public static function calcCSP($attacker, $defender) {
		$cspBase = 0;
		$crit = (self::calcCritRating($attacker) * (1 + ((int) $defender['weakness'])) - ((int) $defender['rac'])) / ($defender['d'] * 5 + $defender['ss'] * 2) + ((int) $attacker['pcrt']/100) - ((int) $defender['pacrt']/100);
		$result = $cspBase + self::calcLevelInfluence($attacker, $defender) + $crit;
		return $result;
	}

	/**
	 * Рейтинг критических ударов
	 *
	 * @param array $player
	 * @return int
	 */
	private static function calcCritRating($player) {
//echo $player['id'].'[crit] = ' . (int)$player['rc'] . '; ';
		$critRating = $player['i'] * 5 + (int) $player['rc'];
		return $critRating;
	}

	/**
	 * Рассчет защиты
	 *
	 * @param array $attacker
	 * @param array $defender
	 * @return int
	 */
	public static function calcResist($attacker, $defender) {
		$resistBase = 0;

		$resist = (self::calcResistRating($defender) * (1 - ((int) $defender['weakness'])) - ((int) $attacker['rdm'])) / ($attacker['i'] * 5 + $attacker['ss'] * 2) + ((int) $defender['pdef']/100) - ((int) $attacker['pdmg']/100);

		$result = $resistBase + self::calcLevelInfluence($defender,$attacker) + $resist;
		return $result;
	}

	/**
	 * Рейтинг защиты
	 *
	 * @param array $player
	 * @return int
	 */
	private static function calcResistRating($player) {
//echo $player['id'].'[resist] = ' . (int)$player['rr'] . '; ';
		$resistRating = $player['r'] * 5 + (int) $player['rr'];
		return $resistRating;
	}

	/**
	 * Рассчет урона критического удара
	 *
	 * @param array $attacker
	 * @param array $defender
	 * @return int
	 */
	public static function calcCDP($attacker, $defender) {
		$critDamage = floor($attacker['s'] * self::r(1.5, 5));
		return $critDamage;
	}

	/**
	 * Рассчет урона удара
	 *
	 * @param array $attacker
	 * @param array $defender
	 * @return int
	 */
	public static function calcDP($attacker, $defender) {
		$damage = floor($attacker['s'] * self::r(0.6, 2));
		return $damage;
	}

	/**
	 * Вычисление увеличение рейтинга в зависимости от левела
	 *
	 * @param array $attacker
	 * @param array $defender
	 * @return float
	 */
	private static function calcLevelInfluence(&$attacker, &$defender) {
		if (($defender['fr'] == 'npc' && $defender['tp'] == NPC_RAT) || ($attacker['fr'] == 'npc' && $attacker['tp'] == NPC_RAT)  || ($attacker['t'] == 'pet' || $defender['t'] == 'pet')) {
			$levelInfluence = 0;
		} else {
			$levelInfluence = ($attacker['lv'] - $defender['lv']) * 0.02;
		}
		return $levelInfluence;
	}

	public function decompress($data) {
		$replaces = array('p1' => 'player1', 'p2' => 'player2', 'a1' => 'pet1', 'a2' => 'pet2', 'a' => 'attacker', 'r' => 'result', 'e' => 'enemyhp', 'd' => 'damage', 'm' => 'miss', 's' => 'strike', 'c' => 'critical', 'i' => 'injury');
		if (is_array($data)) {
			$result = array();
			foreach ($data as $key => $value) {
				$result[$this->decompress($key)] = $this->decompress($value);
			}
			return $result;
		} else {
			if (isset($replaces[$data])) {
				return $replaces[$data];
			} else {
				return $data;
			}
		}
	}

	public function compress($data) {
		$replaces = array('p1' => 'player1', 'p2' => 'player2', 'a1' => 'pet1', 'a2' => 'pet2', 'a' => 'attacker', 'r' => 'result', 'e' => 'enemyhp', 'd' => 'damage', 'm' => 'miss', 's' => 'strike', 'c' => 'critical', 'i' => 'injury');
		if (is_array($data)) {
			$result = array();
			foreach ($data as $key => $value) {
				$result[$this->compress($key)] = $this->compress($value);
			}
			return $result;
		} else {
			if (array_search($data, $replaces) !== false) {
				if ($data == 0) {
					echo $data . ' ' . array_search($data, $replaces) . '<br />';
				}
				return array_search($data, $replaces);
			} else {
				return $data;
			}
		}
	}

	public function save($id=0, $saveMerge='') {
		$tmpLog = $this->log;
		$tmpActing = $this->acting;
		$tmpParams = $this->params;

		$this->log = "";
		$this->acting = "";
		$this->params = "";

		//$this->log = json_encode($tmpLog);
		//$this->acting = json_encode($tmpActing);
		$new = true;
		if ($this->id || $id) {
			$new = false;
		}
		parent::save($id, $saveMerge);
		$mongo = Page::getMongo();
		if ($mongo) {
			if ($new) {
				//if (DEV_SERVER) {
					$mongo->getDb()->selectCollection("duel")->insert(array("id" => $this->id, "log" => new MongoBinData(gzcompress(json_encode($tmpLog), 9)), "acting" => new MongoBinData(gzcompress(json_encode($tmpActing), 9)), "params" => new MongoBinData(gzcompress($tmpParams, 9))));
				//} else {
				//	$mongo->getDb()->selectCollection("duel")->insert(array("id" => $this->id, "log" => json_encode($tmpLog), "acting" => json_encode($tmpActing), "params" => $tmpParams));
				//}

				//$mongo->getDb()->selectCollection("duel")->insert(array("id" => $this->id, "log" => $this->log, "acting" => $this->acting, "params" => $tmpParams));
			} else {
				//if (DEV_SERVER) {
					$mongo->getDb()->selectCollection("duel")->update(array("id" => $this->id), array('$set' => array("log" => new MongoBinData(gzcompress(json_encode($tmpLog), 9)), "acting" => new MongoBinData(gzcompress(json_encode($tmpActing), 9)), "params" => new MongoBinData(gzcompress($tmpParams, 9)))));
				//} else {
				//	$mongo->getDb()->selectCollection("duel")->update(array("id" => $this->id), array('$set' => array("log" => json_encode($tmpLog), "acting" => json_encode($tmpActing), "params" => $tmpParams)));
				//}

				//$mongo->getDb()->selectCollection("duel")->update(array("id" => $this->id), array('$set' => array("log" => $this->log, "acting" => $this->acting, "params" => $tmpParams)));
			}
		}
		/**
		 * ОМГ!
		$this->log = json_decode($this->log, true);
		$this->acting = json_decode($this->acting, true);
		 */
		$this->log = $tmpLog;
		$this->acting = $tmpActing;
		$this->params = $tmpParams;
	}

	public function updateInMongo($id = 0) {
		$mongo = Page::getMongo();
		//if (DEV_SERVER) {
			$mongo->getDb()->selectCollection("duel")->update(array("id" => $this->id), array('$set' => array("log" => new MongoBinData(gzcompress(json_encode($this->log), 9)), "acting" => new MongoBinData(gzcompress(json_encode($this->acting), 9)), "params" => new MongoBinData(gzcompress($this->params, 9)))));
		//} else {
		//	$mongo->getDb()->selectCollection("duel")->update(array("id" => $this->id), array('$set' => array("log" => json_encode($this->log), "acting" => json_encode($this->acting), "params" => $this->params)));
		//}
	}

	public function load($id) {

		// отсюда коментим
		$mongo = Page::getMongo();
		if ($mongo) {
			$duel = $mongo->getDb()->selectCollection("duel")->findOne(array("id" => (int)$id));
			if (!$duel) {
				return false;
			}
		} else {
			return false;
		}
		$result = parent::load($id);
		//if (DEV_SERVER) {
			if (is_object($duel["log"])) {
				$this->log = gzuncompress($duel["log"]->bin);				
				$this->acting = gzuncompress($duel["acting"]->bin);
				$this->params = gzuncompress($duel["params"]->bin);
			} else {
				$this->log = $duel["log"];
				$this->acting = $duel["acting"];
				$this->params = $duel["params"];
			}
		//} else {
		//	$this->log = $duel["log"];
		//	$this->acting = $duel["acting"];
		//	$this->params = $duel["params"];
		//}

		// досюда

		// это включаем
		//$result = parent::load($id); // убрать когда включим монго. такаяже строчка закоменчена выше. она будет рабоать

		if (isset(Page::$player->id) && Page::$player->id == 1) {
			var_dump($this->params);
			var_dump($this->acting);
		}

		if ($result !== false) {
			$this->log = json_decode($this->log, true);
			$this->acting = json_decode($this->acting, true);
		}

		if (isset(Page::$player->id) && Page::$player->id == 1) {
			var_dump($this->params);
		}

		return $result;
	}

	public function onFightBetweenPlayersEnd() {
		$this->updateRatings();
		$this->forceSendMonyaLog();
	}

	public function forceSendMonyaLog() {
		if (isset($this->defender->data['monya'])) {
			Std::loadModule('Thimble');
			Thimble::flushStat($this->defender, false);
		}
	}

	public function isEventActive() {
		return false;
	}

	public function onAttackerWins() {
		$this->automobileDrop();
	}

	public function automobileDrop() {
		if ($this->winner->level < 7) {
			return;
		}
		$chance = 0;
		$winnerLevel = Page::getGroupLevel($this->winner->level);
		$looserLevel = Page::getGroupLevel($this->looser->level);
		if ($winnerLevel <= $looserLevel) {
			$chance = 60;
		} else if (!$this->werewolf && $winnerLevel == $looserLevel + 1) {
			$chance = 15;
		}
		if ($this->werewolf && $chance > 0) {
			$diff = $looserLevel - $winnerLevel;
			switch ($diff) {
				case 0:
					$chance = 60;
					break;
				case 1:
					$chance = 70;
					break;
				case 2:
					$chance = 80;
					break;
				case 3:
					$chance = 90;
					break;
				default:
					$chance = 100;
			}
		}
		if ($chance == 0) {
			return;
		}
		Std::loadModule('Automobile');
		Automobile::initResources();
		$playerLevel = $winnerLevel;
		if (!is_array(Automobile::$resources_drop[$playerLevel])) {
			return;
		}
		/*
		$myChance = Automobile::$resources_drop[$playerLevel]["c"];
		$myChance *= ($this->winner->playboy == 1 ?  Automobile::$resources_drop[$playerLevel]["m"] : 1);
		*/
		$norm = Automobile::$resources_drop[$playerLevel]["n"];
		if (!isset(Page::$player->data["automobile_resources"]) || !is_array(Page::$player->data["automobile_resources"]) || Page::$player->data["automobile_resources"]["date"] != date("d.m.Y")) {
			Page::$player->data["automobile_resources"] = array("count" => 0, "date" => date("d.m.Y"));
		}
		$count = Page::$player->data["automobile_resources"]["count"];
		$myChance = ($count > $norm) ? (($norm * 1.25 - $count) * 200 / $norm) : $chance;
		if (DEV_SERVER) {
			$myChance *= 2;
		}
		$r = mt_rand(1, 100);
		if ($r > $myChance) { // если великий рандом НЕ благосклонен
			return;
		}

		$resources = array_keys(Automobile::$resources);

		$res_ratio = array();
		$res_sum = 0;

		foreach ($resources as $id => $value) {
			$v = 1/ ( Page::$player2->{"a_" . $value} + 1 );
			$res_sum += $v;
			$res_ratio[$id] = $v;
		}

		foreach ($resources as $id => $value) {
			if ($res_sum == 0) {
				$v = 0;
			} else {
				$v = round($res_ratio[$id]/$res_sum * 100); // сделали в диапазоне [0..100]
			}
			$res_ratio[$id] = $v;
		}

		$random_value = mt_rand(1,100);

		$count = sizeof($resources) - 1;
		$res = $resources[mt_rand(0, $count)]; // по дефолту берем любой рандомный ресурс

		/*
		foreach ($resources as $id => $value) {
			$random_value = $random_value - $res_ratio[$id];
			if ($random_value <= 0) { // попали в сектор рандома
				$res = $value;
				break;
			}
		}
		*/

		$drop_amount = 1 + round(($playerLevel-6)/2 + mt_rand(-100,100)/1000);
		Page::$player->data["automobile_resources"]["count"] += $drop_amount;
		Page::$player->saveData();
		$p2res = "a_" . $res;
		Page::$player2->{$p2res} += $drop_amount;
		Page::$player2->save(Page::$player2->id, array(player2Object::${strtoupper($p2res)}));
		$this->params['carpart'] = array("n" => Automobile::$resources[$res]["name"], "i" => Automobile::$resources[$res]["image"], "c" => $drop_amount);
	}

	public function updateRatings() {
		// $this->winner
		if (CacheManager::get('rating_state') == 'off') {
			return;
		}
		$moneygrabbedEvent = $this->isEventActive();
		$time = time();
		if ($this->profit > 0) {
			$sql = "UPDATE rating_player SET
					lastupdate = " . $time . ",
					moneygrabbed = moneygrabbed + " . $this->profit . ",
					moneygrabbed_day = moneygrabbed_day + " . $this->profit . ",
					moneygrabbed_week = moneygrabbed_week + " . $this->profit . ",
					moneygrabbed_month = moneygrabbed_month + " . $this->profit . ",
					" . ($moneygrabbedEvent ? "moneygrabbed_event = moneygrabbed_event + " . $this->profit . "," : "") . "
					wins = wins + 1,
					wins_day = wins_day + 1,
					wins_week = wins_week + 1,
					wins_month = wins_month + 1
					WHERE player = " . $this->winner->id . " LIMIT 1";
		} else {
			$sql = "UPDATE rating_player SET
					lastupdate = " . $time . ",
					wins = wins + 1,
					wins_day = wins_day + 1,
					wins_week = wins_week + 1,
					wins_month = wins_month + 1
					WHERE player = " . $this->winner->id . " LIMIT 1";
		}
		Page::$sql->query($sql);
		if ($this->realprofit > 0) {
			$sql = "UPDATE rating_player SET
					lastupdate = " . $time . ",
					moneylost = moneylost + " . $this->realprofit . ",
					moneylost_day = moneylost_day + " . $this->realprofit . ",
					moneylost_week = moneylost_week + " . $this->realprofit . ",
					moneylost_month = moneylost_month + " . $this->realprofit . "
					WHERE player = " . $this->looser->id . " LIMIT 1";
			Page::$sql->query($sql);
		}
		CacheManager::delete('player_stat', array('player_id' => $this->winner->id));
		CacheManager::delete('player_stat', array('player_id' => $this->looser->id));

	}

	/*
	 * Шанс атаковать игрока
	 * @param petObject $pet1
	 * @param petObject $pet2
	 * @return int
	 */
	public function petGetChanceAttackPlayer($pet1, $pet2) {
		if ($pet1->focus > $pet2->loyality) {
			$x = ($pet1->focus + 1) / ($pet2->loyality + 1) + ($pet1->focus - $pet2->loyality) / 50;
		} else {
			$x = 1;
		}
		$r = round((1 - 1/$x) * 0.3 * 100);
		return $r;
	}

	/*
	 * Шанс защитить своего хозяина
	 * @param petObject $pet1
	 * @param petObject $pet2
	 * @return int
	 */
	public function petGetChanceTankPlayer($pet1, $pet2) {
		if ($pet2->loyality > $pet1->mass ) {
			$x = ($pet2->loyality + 1) / ($pet1->mass + 1) + ($pet2->loyality - $pet1->mass) / 50;
		} else {
			$x = 1;
		}
		$r = round((1 - 1/$x) * 0.3 * 100);
		return $r;
	}

	/*
	 * Шанс испугать вражеского питомца
	 * @param petObject $pet1
	 * @param petObject $pet2
	 * @return int
	 */
	public function petGetChanceStunPet($pet1, $pet2) {
		if ($pet2->mass > $pet1->focus) {
			$x = ($pet2->mass + 1) / ($pet1->focus + 1) + ($pet2->mass - $pet1->focus) / 50;
		} else {
			$x = 1;
		}
		$r = round((1 - 1/$x) * 0.3 * 100);
		return $r;
	}

}

?>