<?php
class standard_itemObject extends standard_itemBaseObject
{
	public function __construct()
	{
		parent::__construct();
	}

	public function loadByCode($code)
    {
	    $arr = $this->sql->getRecord("SELECT * FROM `standard_item` WHERE `code` = '" . $code . "' LIMIT 1");
	    if ($arr == false) {
			return false;
	    }
	    $this->init($arr);
	    return true;
	}

	public function load($id)
    {
		if (is_callable($GLOBALS['module'], 'getData')) {
			$arr = $GLOBALS['module']->getData('standard_item/' . $id, "SELECT * FROM `standard_item` WHERE `id` = '" . $id . "' LIMIT 1", "record", 3600);
		} else {
			$arr = $this->sql->getRecord("SELECT * FROM `standard_item` WHERE `id` = '" . $id . "' LIMIT 1");
		}
	    if ($arr == false) {
			return false;
	    }
	    $this->init($arr);
	    return true;
	}

	public function makeExampleOrAddDurability($player, $count = 1)
    {
	    if ($this->stackable == 1 && ($id = $this->sql->getValue("SELECT id FROM inventory WHERE player = " . $player . " AND standard_item = " . $this->id)) != false) {
			//$this->sql->query("UPDATE inventory SET durability = durability + " . $count . ", maxdurability = maxdurability + " . $count . ", dtbuy = " . time() . " WHERE player = " . $player . " AND standard_item = " . $this->id . " LIMIT 1");
			$query = "UPDATE inventory SET durability = durability + " . $count . ", maxdurability = maxdurability + " . $count . ", dtbuy = " . time() . " WHERE id = " . $id;
			$this->sql->query($query);
	    } else {
			$this->makeExample($player, '', '', $count);
	    }
	}

	public function makeExample($player, $name = '', $info = '', $count = 0)
    {
		Std::loadMetaObjectClass('inventory');
		$inventory = new inventoryObject;
		$inventory->attention = $this->attention;
		$inventory->charism = $this->charism;
		$inventory->dexterity = $this->dexterity;
		$inventory->durability = $count > $this->maxdurability && $count > 0 ? $count : ($this->maxdurability > 0 ? $this->maxdurability : 1);
		$inventory->health = $this->health;
		$inventory->honey = $this->honey;
		$inventory->image = $this->image;
		$inventory->intuition = $this->intuition;
		$inventory->itemlevel = $this->itemlevel;
        $inventory->mf = 0;
		$inventory->level = $this->level;
		$inventory->maxdurability = $count > $this->maxdurability && $count > 0 ? $count : ($this->maxdurability > 0 ? $this->maxdurability : 1);
		$inventory->money = $this->money;
		$inventory->uniq = $this->uniq;
		$inventory->buyable = $this->buyable;
		if ($name != '') {
			$inventory->name = $name;
		} else {
			$inventory->name = $this->name;
		}
		if ($info != '') {
			$inventory->info = $info;
		} else {
			$inventory->info = $this->info;
		}
		$inventory->ore = $this->ore;
		$inventory->player = $player;
		$inventory->resistance = $this->resistance;
		$inventory->slot = $this->slot;
		$inventory->standard_item = $this->id;
		$inventory->strength = $this->strength;
		$inventory->type = $this->type;
        $inventory->subtype = $this->subtype;
        $inventory->type2 = $this->type2;
		$inventory->equipped = 0;
		$inventory->stackable = $this->stackable;
		$inventory->sellable = $this->sellable;
		$inventory->usable = $this->usable;
		$inventory->upgradable = $this->upgradable;
		$inventory->time = $this->time;
		$inventory->hp = $this->hp;
		$inventory->code = $this->code;
        $inventory->dtbuy = time();
        $inventory->unlocked = $this->unlocked;
        $inventory->unlockedby = $this->unlockedby;
        $inventory->usestate = $this->usestate;

        $inventory->ratingcrit = $this->ratingcrit;
        $inventory->ratingdodge = $this->ratingdodge;
        $inventory->ratingresist = $this->ratingresist;
        $inventory->ratinganticrit = $this->ratinganticrit;
        $inventory->ratingdamage = $this->ratingdamage;
        $inventory->ratingaccur = $this->ratingaccur;

        $inventory->special1 = $this->special1;
        $inventory->special1name = $this->special1name;
        $inventory->special2 = $this->special2;
        $inventory->special2name = $this->special2name;
        $inventory->special3 = $this->special3;
        $inventory->special3name = $this->special3name;
        $inventory->special4 = $this->special4;
        $inventory->special4name = $this->special4name;
        $inventory->special5 = $this->special5;
        $inventory->special5name = $this->special5name;
        $inventory->special6 = $this->special6;
        $inventory->special6name = $this->special6name;
        $inventory->special7 = $this->special7;
        $inventory->special7name = $this->special7name;

		$inventory->deleteafter = $this->deleteafter;
        $inventory->deleteafterdt = $this->deleteafterdt;

		$inventory->save();

		if ($inventory->type == 'pet') {
			Std::loadMetaObjectClass('pethp');
			$pethp = new pethpObject();
			$pethp->player = $player;
			$pethp->initHP($inventory);
			$pethp->regen = 1;
			$pethp->save();
		}

		return $inventory;
	}

    /**
     * Создание вещи в инвентаре клана
     *
     * @param int $clan
     * @param string $name
     * @param string $info
     * @return object
     */
    public function makeExampleClan($clanId, $name = '', $info = '')
    {
		Std::loadMetaObjectClass('inventory');
		$inventory = new inventoryObject;

        $inventory->clan = $clanId;
        $inventory->player = 0;

        $inventory->health = $this->health;
        $inventory->attention = $this->attention;
		$inventory->charism = $this->charism;
		$inventory->dexterity = $this->dexterity;
        $inventory->intuition = $this->intuition;
        $inventory->resistance = $this->resistance;

		$inventory->durability = ($this->maxdurability > 0) ? $this->maxdurability : 1;
		$inventory->maxdurability = $this->maxdurability;

		$inventory->honey = $this->honey;
        $inventory->ore = $this->ore;
        $inventory->money = $this->money;

		$inventory->image = $this->image;
		
		$inventory->itemlevel = $this->itemlevel;
		$inventory->level = $this->level;

        $inventory->uniq = $this->uniq;
		$inventory->buyable = $this->buyable;
        $inventory->stackable = $this->stackable;
		$inventory->sellable = $this->sellable;
		$inventory->usable = $this->usable;
		$inventory->upgradable = $this->upgradable;

        if ($name != '') {
			$inventory->name = $name;
		} else {
			$inventory->name = $this->name;
		}
		if ($info != '') {
			$inventory->info = $info;
		} else {
			$inventory->info = $this->info;
		}
		
		$inventory->slot = $this->slot;
		$inventory->standard_item = $this->id;
		$inventory->strength = $this->strength;
		$inventory->type = $this->type;
        $inventory->type2 = $this->type2;
		$inventory->equipped = 0;
		
		$inventory->time = $this->time;
		$inventory->hp = $this->hp;
		$inventory->code = $this->code;
        $inventory->dtbuy = time();
        $inventory->unlocked = $this->unlocked;
        $inventory->unlockedby = $this->unlockedby;
        $inventory->usestate = $this->usestate;
		$inventory->save();

		return $inventory;
	}

    /**
     * Дать персонажу подарок
     *
     * @param string $player_from
     * @param string $player_from_id
     * @param int $player
     * @param string $comment
     * @param int $anonymous
     * @param int $private
     * @return mixed
     */
	public function giveGift($player_from,$player_from_id, $player, $comment = '', $anonymous = 0, $private = 0, $hidden = 0) {
        // флаг
		if ($this->code == 'ctf_flag') {
			$tmp = Page::$sql->getRecord("SELECT `fraction`, `clan`, `clan_status` FROM `player` WHERE `id` = " . $player);
			$fraction = $tmp['fraction'];
			if ($tmp['clan'] > 0 && $tmp['clan_status'] != 'recruit') {
				$clan = $tmp['clan'];
			} else {
				$clan = 0;
			}
			$tmp = Page::$sql->getRecordSet("SELECT * FROM `value` WHERE `name` IN ('flag_player', 'flag_fraction', 'flag_time', 'flag_capturedtime')");
			$flag = array();
			if ($tmp !== false)
			foreach ($tmp as $key => $value) {
				$flag[$value['name']] = $value['value'];
			}

			Page::$sql->query("update `playerboost2` set `dt2` = '2000-00-00 00:00:00' WHERE `code` = 'ctf_flag'");

            if ($flag['flag_fraction'] == '') {
				CacheManager::set('value_flag_fraction', $fraction);
				Page::setValueFromDB('flag_fraction', $fraction);
			} else if ($flag['flag_fraction'] != '' && $flag['flag_fraction'] != $fraction) {
				CacheManager::set('value_flag_fraction', $fraction);
				Page::setValueFromDB('flag_fraction', $fraction);
				Page::$sql->query("UPDATE rating_fraction SET flagtime = flagtime + " . (time() - $flag['flag_capturedtime']) . " where fraction = '" . $flag['flag_fraction'] . "'");
			}
			
			CacheManager::delete('player_gifts', array('player_id' => $flag['flag_player']));

            Page::$sql->query("DELETE FROM `gift` WHERE `code` = 'ctf_flag'");
			CacheManager::set('value_flag_player', $player);
			Page::setValueFromDB('flag_player', $player);

			CacheManager::set('value_flag_clan', $clan);
			Page::setValueFromDB('flag_clan', $clan);

			CacheManager::set('value_flag_capturedtime', time());
			Page::setValueFromDB('flag_capturedtime', time());
		}

        // подарок - boost2 - продление
        if ($this->type == 'gift2' && ($dt = Page::$sql->getValue("SELECT dt2 FROM playerboost2 WHERE player=" . $player . " AND code='" . $this->code . "'")) != false) {
			CacheManager::delete('player_gifts', array('player_id' => $player));
            Page::applyBoost2($player, $this);
            Page::$sql->query("UPDATE gift SET endtime = endtime + " . Page::timeLettersToSeconds($this->time) . ", comment='" . mysql_escape_string($comment) . "', private='" . $private . "', anonymous='" . (($this->subtype == "award") ? 1 : $anonymous) . "', player_from='" . mysql_escape_string((($this->subtype == "award") ? "" : $player_from)) . "' WHERE player = " . $player . " AND code = '" . $this->code . "' LIMIT 1");
			if (Page::$sql->getAffectedRows() == 0) {
				Std::loadMetaObjectClass('gift');
				$gift = new giftObject();
				$gift->hidden = $hidden;
				$gift->standard_item = $this->id;
				$gift->player = $player;
				$gift->player_from = $this->subtype == "award" ? "" : $player_from;
				$gift->player_from_id = $this->subtype == "award" ? "" : $player_from_id;
				$gift->time = time();
				$gift->anonymous = $this->subtype == "award" ? 1 : $anonymous;
				$gift->private = $private;
				$gift->name = $this->name;
				$gift->image = $this->image;
				$gift->info = $this->info;
				$gift->comment = $comment;
				$gift->code = $this->code;
				$gift->endtime = $this->subtype == "award" ? 0 : strtotime($dt) + Page::timeLettersToSeconds($this->time);
				$gift->unlocked = $this->unlocked;
				$gift->unlockedby = $this->unlockedby;
				$gift->type = $this->subtype;
				$gift->standard_item = $this->id;
				$gift->save();
				return $gift->id;
			}
			return Page::$sql->getValue("SELECT id FROM gift WHERE player = " . $player . " AND code = '" . $this->code . "' LIMIT 1");
            //return true;
		} else {
            if ($this->type == 'gift2' || $this->code == 'ctf_flag') {
                Page::applyBoost2($player, $this);
            }
			CacheManager::delete('player_gifts', array('player_id' => $player));
			Std::loadMetaObjectClass('gift');
			$gift = new giftObject();
			$gift->hidden = $hidden;
			$gift->standard_item = $this->id;
			$gift->player = $player;
			$gift->player_from = $this->subtype == "award" ? "" : $player_from;
			$gift->player_from_id = $this->subtype == "award" ? "" : $player_from_id;
			$gift->time = time();
			$gift->anonymous = $this->subtype == "award" ? 1 : $anonymous;
			$gift->private = $private;
			$gift->name = $this->name;
			$gift->image = $this->image;
			$gift->info = $this->info;
			$gift->comment = $comment;
			$gift->code = $this->code;
			$gift->endtime = $this->subtype == "award" ? 0 : time() + Page::timeLettersToSeconds($this->time);
			$gift->unlocked = $this->unlocked;
			$gift->unlockedby = $this->unlockedby;
            $gift->type = $this->subtype;
            $gift->standard_item = $this->id;
			$gift->save();
			return $gift->id;
		}
	}

    /**
     * Дать персонажу регалию
     *
     * @param int $playerId
     */
    public function giveAward($playerId)
    {
        Std::loadMetaObjectClass("gift");
        $gift = new giftObject();
        $gift->player = $playerId;
        $gift->type = "award";
        $gift->name = $this->name;
        $gift->image = $this->image;
        $gift->info = $this->info;
        $gift->code = $this->code;
        $gift->unlocked = 1;
        $gift->anonymous = 1;
        $gift->standard_item = $this->id;
        $gift->save();
    }

	public function givePet($player) {
		Std::loadMetaObjectClass('pet');
		$pet = new petObject();
		$pet->image = $this->image;
		$pet->name = $this->name;
		$pet->player = $player;
		$pet->procent = $this->special1;
		$pet->info = $this->info;
		$pet->item = $this->id;
		$pet->regen = 1;
		
		$sql = "SELECT id, respawn_at FROM pet WHERE player = " . $player . " and active = 1";
		$r = Page::$sql->getRecord($sql);
		
        $fields2save = array(petObject::$IMAGE, petObject::$NAME, petObject::$PLAYER, petObject::$PROCENT, petObject::$INFO, petObject::$ITEM, petObject::$REGEN);

		if (!$r || strtotime($r['respawn_at']) > time()) {
			$pet->active = 1;
            $fields2save[] = petObject::$ACTIVE;

			if ($r['respawn_at'] > time()) {
				$sql = "UPDATE pet SET active = 0 WHERE id = " . $r['id'];
				Page::$sql->query($sql);
				CacheManager::delete("pet_full", array('pet_id' => $r['id']));
			}
		}
		
		$pet->save($fields2save, true);

		if ($pet->player == Page::$player->id) {
			$pet->player = Page::$player;
		$pet->calcStats(true);
			$pet->player = Page::$player->id;
		}
		
		CacheManager::delete('player_pets_id', array('player_id' => $player));
		
		return $pet;
	}

    public function givePetClan($clanId)
    {
		Std::loadMetaObjectClass('pet');
		$pet = new petObject();
		$pet->image = $this->image;
		$pet->name = $this->name;
		$pet->player = 0;
        $pet->clan = $clanId;
		$pet->procent = 0;
		$pet->info = $this->info;
		$pet->item = $this->id;
		$pet->regen = 0;

		//$pet->calcStats(true);

		$pet->health = 10;
		$pet->strength = 10;
		$pet->dexterity = 10;
		$pet->resistance = 10;
		$pet->intuition = 10;
		$pet->attention = 10;
		$pet->charism = 10;
		$pet->maxhp = max(1, (10 * $pet->health + 4 * $pet->resistance) * $pet->player->pethpk * 100);
		$pet->hp = $pet->maxhp;

		return $pet;
	}

    /**
     * Проверка: является ли данный предмет подарком с негативным эффектом
     *
     * @return bool
     */
    public function isNegativeGift()
    {
        if ($this->type == 'gift' || $this->type == 'gift2') {
            if ($this->health < 0 || $this->attention < 0 || $this->charism < 0 || $this->dexterity < 0 ||
                $this->intuition < 0 || $this->strength < 0 || $this->resistance < 0 || $this->ratingcrit < 0 ||
                $this->ratingdodge < 0 || $this->ratingresist < 0 || $this->ratinganticrit < 0 ||
                $this->ratingdamage < 0 || $this->ratingaccur < 0) {
                return true;
            }
        }
        return false;
    }
}
