<?php
class inventoryObject extends inventoryBaseObject
{
	public function __construct()
	{
		parent::__construct();
	}

	public function useItem() {
		if ($this->type != 'petfood' && $this->type != 'petautofood' && $this->time == '' && $this->hp != '' && $this->type != 'usableitem') {
			// drug heal player hp
			if ($this->player->hp < $this->player->maxhp) {
				if ($this->hp >= 1) {
					$this->player->setHP($this->player->hp + $this->hp);
				} else {
					$this->player->setHP($this->player->hp + $this->player->maxhp * $this->hp*1000 / 100);
				}
			}
		} elseif (($this->type == 'drug' || $this->type == 'gift' || $this->type == 'drug2') && $this->time != '') {
			$this->applyBoost2();
		} elseif (($this->type == 'petfood' || $this->type == 'petautofood') && $this->usable == 1) {
			//Std::loadMetaObjectClass("pet");
			//$pet = new petObject();
			//$petId = (is_numeric($this->player) ? $this->player : $this->player->id);
			//$pet->load($petId);
			if ((is_object($this->player) && $this->player->id == Page::$player->id) || (!is_object($this->player) && $this->player == Page::$player->id)) {
                $result = Page::$player->loadActivePet(false);
            } else {
                Std::loadMetaObjectClass('pet');
                $pet = new petObject();
                $sql = "SELECT id FROM pet WHERE player = " . $this->player . " and active = 1";
                $id = $this->sql->getValue($sql);
                if (!$id) {
                    return false;
                }
                $result = $pet->load($id);
                if ($result == false) {
                    return false;
                }
            }
			if (!$result) {
				return;
			}
			$hp = round($result->hp + ($result->maxhp * $this->special1 / 100));
			$result->setHP($hp);
            /*
			if (is_object(Page::$player)) {
                $hp = round(Page::$player->pet->hp + (Page::$player->pet->maxhp * $this->special1 / 100));
                Page::$player->pet->setHP($hp);
            } else {
                $hp = round($pet->hp + ($pet->maxhp * $this->special1 / 100));
                $pet->setHP($hp);
            }
			*/
		} else if ($this->code == 'stat_stimulator') {
			$stat = Page::$data['stats'][Page::$data['statslist'][rand(0, 6)]];
			Page::$player->{$stat['code']} ++;
			Page::$player->{$stat['code'] . '_finish'} = round((Page::$player->{$stat['code']} + Page::$player->{$stat['code'] . '_bonus'} + Page::$player->flag_bonus) * (100 + Page::$player->{$stat['code'] . '_percent'}) / 100);
			Page::$player->calcMaxHp();
			Page::$player->save(Page::$player->id, array(playerObject::$MONEY, playerObject::${strtoupper($stat['code'])}, playerObject::${strtoupper($stat['code']) . '_FINISH'}, playerObject::$MAXHP));
			Page::$player->updateStatsum();
			Page::addAlert(PageLang::ALERT_OK, Std::renderTemplate(PageLang::ALERT_STAT_STIMULATOR, array('stat' => $stat['name'], 'value' => Page::$player->{$stat['code']})));
			Page::sendLog(Page::$player->id, 'stat_stimulator', array('stat' => $stat['name'], 'value' => Page::$player->{$stat['code']}));
		} elseif ($this->type == 'usableitem') {
            $itemUsed = false;
			$this->unlockedby = json_decode($this->unlockedby, true);
			if (count($this->unlockedby) == 0) {
				$lockedItems = $this->sql->getRecordSet("SELECT id, unlockedby, name FROM inventory WHERE player=" . $this->player->id . " AND unlocked=0 ORDER BY itemlevel DESC");
				if ($lockedItems) {
					foreach ($lockedItems as $item) {
						$unlock = json_decode($item['unlockedby'], true);

						if ($unlock['item']['code'] == $this->code && $unlock['action'] == 'use') {
							$itemUsed = true;
							if (isset($unlock['newitem'])) {
								if (isset($unlock['newitem']['code'])) {
									$code = is_array($unlock['newitem']['code']) ? $unlock['newitem']['code'][mt_rand(0, sizeof($unlock['newitem']['code'])-1)] : $unlock['newitem']['code'];
									Std::loadMetaObjectClass('standard_item');
									$standard_item = new standard_itemObject;
									$standard_item->loadByCode($code);
									$item2 = $standard_item->makeExample($this->player->id);
								}
							}
							if (isset($unlock['actions'])) {
								/*
								Page::doActions(Page::$player, $unlock['actions']);
								$results = Page::translateActions($unlock['actions']);
								$resultStr = '';

								$images = '';
								foreach ($results as $r) {
									if (is_string($r)) {
										$resultsStr .= '<li>' . $r . '</li>';
									} else if (is_array($r) && $r['type'] == 'image') {
										$images .= '<div class="object-thumb">
														<img src="/@/images/obj/' . $r['image'] . '" />
														<div class="count">#' . $r['amount'] . '</div>
													</div>';
									}
								}
								Page::addAlert(PageLang::ALERT_OK, Lang::renderText(PageLang::ALERT_ITEM_UNLOCKED, array('unlocked_by' => $this->name, 'unlocked_item' => $item['name'], 'reward' => $resultsStr)) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : ''), ALERT_INFO);
								*/
								Page::fullActions(Page::$player, $unlock['actions'], PageLang::ALERT_ITEM_UNLOCKED, array('unlocked_by' => $this->name, 'unlocked_item' => $item['name']));
							}
							if ($unlock['delete_after'] == 1) {
								$this->sql->query("DELETE FROM inventory WHERE id = " . $item['id']);
							} else {
								$this->sql->query("UPDATE inventory SET unlocked=1,dtbuy=" . time() . " WHERE id=" . $item['id']);
							}
							break;
						}
					}
				}
			} else if ($this->unlockedby['actions']) {
				if (isset($this->unlockedby['conditions'])) {
					if (Page::checkConditions(Page::$player, $this->unlockedby['conditions'], $results) == false) {
						$results = Page::translateConditions($results);
						$resultsStr = '';
						$images = array();
						foreach ($results as $r) {
							if (is_string($r)) {
								$resultsStr .= '<li>' . $r . '</li>';
							} else if (is_array($r) && $r['type'] == 'image') {
								$images[] = '<span class="object-thumb">
												<img src="/@/images/obj/' . $r['image'] . '" alt="' . htmlspecialchars($r['name']) . '" title="' . htmlspecialchars($r['name']) . '" />
												' . ($r['amount'] > 1 ? '<div class="count">#' . $r['amount'] . '</div>' : '') . '
											</span>';
								$im = $r;
							}
						}
						if (isset($this->unlockedby['conditions_error'])) {
							$text = $this->unlockedby['conditions_error'];
						} else {
							$text = PageLang::$alertConditionsErrorText;
						}
						if (count($images) > 1) {
							$images = implode('', $images);
							$text = Lang::renderText($text, array('conditions' => $resultsStr)) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : '');
						} else if (count($images)) {
							$r = $im;
							$text = '<img align="left" style="margin: 0 10px 10px 0;" src="/@/images/obj/' . $r['image'] . '" alt="' . htmlspecialchars($r['name']) . '" title="' . htmlspecialchars($r['name']) . '" />
									' . ($r['amount'] > 1 ? '<div class="count">#' . $r['amount'] . '</div>' : '') . '
									' . Lang::renderText($text, array('conditions' => $resultsStr));
						} else {
							$text = Lang::renderText($text, array('conditions' => $resultsStr)) . ($images ? '<div class="clear objects" align="center">' . $images . '</div>' : '');
						}
						
						Page::addAlert(PageLang::$alertConditionsError, $text);
						return;
					}
				}
				if (isset($this->unlockedby['alert_after'])) {
					$text = $this->unlockedby['alert_after'];
				} else {
					$text = PageLang::ALERT_ITEM_UNLOCKED_MYSELF;
				}
				Page::fullActions(Page::$player, $this->unlockedby['actions'], $text, array('unlocked_item' => $this->name));
					$itemUsed = true;
				
			}

			if (!$itemUsed) {
				return;
			}
        }
		
		Page::checkEvent(Page::$player->id, 'item_used', $this->standard_item);

		if ($this->code == 'clan_malahoff' || $this->code == 'clan_embulance') {
			Page::sendLog($this->player->id, 'item_autoused', array('code' => $this->code, 'name' => $this->name), 0);
		} else {
			if (is_string($this->unlockedby)) {
				$this->unlockedby = json_decode($this->unlockedby, true);
			}
			if (isset($this->unlockedby['logtext'])) {
				Page::sendLog($this->player->id, 'item_autoused', array('code' => $this->code, 'name' => $this->name, 'text' => $this->unlockedby['logtext']), 0);
			}
		}

        $this->useWithNoEffect();
/*
if ($this->code == 'clan_embulance') {
	$this->player->lastfight = time() + 3 * 3600;
	$this->player->save($this->player->id, array(playerObject::$LASTFIGHT));
}
*/
/*
if ($this->maxdurability > 0) {
    if ($this->durability > $this->maxdurability) {
        $this->maxdurability = $this->durability;
    }
    $p = $this->player;
    $this->player = $p->id;
    if ($this->durability == 1) {
        $this->delete($this->id);
    } else {
        if ($this->stackable == 1) {
            $this->maxdurability--;
        }
        $this->durability--;
        $this->save($this->id, array(inventoryObject::$DURABILITY, inventoryObject::$MAXDURABILITY));
    }
    $this->player = $p;
}
*/
	}

    /**
     * Уменьшение кол-ва предметов в пачке предметов
     * Вызывается при использовании предмета во время боя (нужно для уменьшения кол-ва предметов в инвентаре,
     * а эффект применяется в модуле группового боя)
     */
    public function useWithNoEffect()
    {
        if ($this->maxdurability > 0) {
			if ($this->durability > $this->maxdurability) {
				$this->maxdurability = $this->durability;
			}
			$p = $this->player;
			$this->player = $p->id;
			if ($this->durability == 1) {
				$this->delete($this->id);
			} else {
				if ($this->stackable == 1) {
					$this->maxdurability--;
				}
				$this->durability--;
				$this->save($this->id, array(inventoryObject::$DURABILITY, inventoryObject::$MAXDURABILITY));
			}
			$this->player = $p;
		}
    }

//public function applyBoost() {
//	$result = Page::applyBoost(is_numeric($this->player) ? $this->player : $this->player->id, 'positive', $this->health, $this->strength, $this->dexterity, $this->attention, $this->resistance, $this->charism, $this->intuition, $this->time, 'item_' . $this->code);
//	return $result;
//}

    /**
     * Применение допинга
     *
     * @return mixed
     */
    public function applyBoost2()
    {
        $playerId = is_numeric($this->player) ? $this->player : $this->player->id;
        return Page::applyBoost2($playerId, $this);
    }

    /**
     * Одевание предмета
     *
     * @param bool $check
     * @return bool
     */
	public function dress($check = false)
    {
		if ($this->slot == '') {
			return false;
		}

        // проверка: не занят ли слот другой вещью (если занят, то эта вещь снимается)
		$result = $this->sql->getRecord("SELECT * FROM inventory WHERE slot = '" . $this->slot . "' and equipped = 1 AND player = " . $this->player . " limit 1");
		if ($result !== false) {
			$item = new inventoryObject();
			$item->init($result);
			$item->withdraw();
		}


		$this->equipped = 1;
		$this->save($this->id, array(inventoryObject::$EQUIPPED));
		Page::$player->calcStats($this);
		
        // комплекты
        if (in_array($this->slot, array('cloth','weapon','hat','shoe','pouch','accessory1'))) {
            Page::$player->checkKomplekt();
        }

		return true;
	}

    /**
     * Снятие предмета
     *
     * @return bool
     */
	public function withdraw()
    {
		$this->equipped = 0;
		$this->save($this->id, array(inventoryObject::$EQUIPPED));
		Page::$player->calcStats($this, -1);

        // комплекты
        if (in_array($this->slot, array('cloth','weapon','hat','shoe','pouch','accessory1'))) {
            $this->sql->query("UPDATE player SET komplekt = 0 WHERE id = " . Page::$player->id);
            $this->sql->query("DELETE FROM gift WHERE player = " . Page::$player->id . " AND type = 'award' AND code = 'award_komplekt'");
        }

		return true;
	}

	public function loadByCode($code, $player)
    {
		$result = $this->sql->getRecord("SELECT * FROM inventory WHERE player = " . $player . " AND code = '" . $code . "' LIMIT 1");
		if ($result) {
            $this->init($result);
            return $this;
        } else {
			return false;
		}
	}

	public function loadByStandardId($id, $player)
    {
		$result = $this->sql->getRecord("SELECT * FROM inventory WHERE player = " . $player . " AND standard_item = '" . $id . "' LIMIT 1");
		if ($result) {
            $this->init($result);
            return $this;
        } else {
			return false;
		}
		
	}

    public function loadByType($type, $player)
    {
		$result = $this->sql->getRecord("SELECT * FROM inventory WHERE player = " . $player . " AND type = '" . $type . "' LIMIT 0,1");
		if ($result) {
            $this->init($result);
            return $this;
        } else {
			return false;
		}
	}

	public function decreaseDurability($amount = 1) {
		if ($this->durability <= $amount) {
			$this->delete($this->id);
		} else {
			$this->durability -= $amount;
			$this->maxdurability -= $amount;
			$this->save($this->id, array(inventoryObject::$DURABILITY, inventoryObject::$MAXDURABILITY));
		}
	}

	public function toArray() {
		if (is_object($this->player)) {
			$q = $this->player;
			$this->player = $q->id;
			$object = parent::toArray();
			$this->player = $q;
		} else {
			$object = parent::toArray();
		}
		return $object;
	}
}