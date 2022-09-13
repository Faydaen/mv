<?php

class PlayerAdmin {

	private static $boostTypes = array('health', 'strength', 'dexterity', 'intuition', 'resistance', 'attention', 'charism', 'ratingcrit', 'ratingdodge', 'ratingresist', 'ratinganticrit', 'ratingdamage', 'ratingaccur');
	private static $boostTypes2 = array('health', 'strength', 'dexterity', 'intuition', 'resistance', 'attention', 'charism');

	public static function adminMarry($playerId, $marry) {
		$result = array('type' => 'admin', 'action' => 'marry', 'params' => array('url' => '/player/' . $playerId . '/'));

		if (Page::$player->access['marry'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		
		$player = CacheManager::get('player_small', array('player_id' => $playerId));
		$query = "SELECT id, type, player_from_id FROM gift WHERE player = " . $playerId . " AND SUBSTR(code, 1, 12) = 'wedding_ring' AND hidden = 0";
		$ring = Page::$sql->getRecord($query);
		
		if (!$ring) {
			$result['result'] = 0;
			Page::addAlert(PlayerAdminLang::ERROR, PlayerAdminLang::ERROR_RING_NOT_FOUND, ALERT_ERROR);
			return $result;
		}

		$player2Id = $ring['player_from_id'];
		$player2 = CacheManager::get('player_small', array('player_id' => $player2Id));
		#$query = "SELECT id, type FROM gift WHERE player = " . $player2Id . " AND player_from LIKE '" . $player['nickname'] . "'  AND SUBSTR(code, 1, 12) = 'wedding_ring' AND hidden = 0";
		$query = "SELECT id, type FROM gift WHERE player = " . $player2Id . " AND player_from_id='" . $playerId . "'  AND SUBSTR(code, 1, 12) = 'wedding_ring' AND hidden = 0";

		$ring2 = Page::$sql->getRecord($query);

		if (!$ring2) {
			$result['result'] = 0;
			Page::addAlert(PlayerAdminLang::ERROR, PlayerAdminLang::ERROR_PARTNER_RING_NOT_FOUND, ALERT_ERROR);
			return $result;
		}

		// поженить
		if ($marry) {
			if ($ring['type'] == 'award' || $ring2['type'] == 'award') {
				$result['result'] = 0;
				Page::addAlert(PlayerAdminLang::ERROR, PlayerAdminLang::ERROR_ALREADY_MARRIED, ALERT_ERROR);
				return $result;
			}

			$query = "UPDATE gift SET type = 'award', endtime = 0, comment='".PlayerAdminLang::MARRIED_COMMENT."',  time = " . time() . " WHERE id IN (" . $ring['id'] . ", " . $ring2['id'] . ")";
			Page::$sql->query($query);

			Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '+marry', 'p2' => $player2), 0);
			Page::sendLog($player2Id, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '+marry', 'p2' => $player), 0);

			CacheManager::deleteSet('player_gifts', 'player_id', array($playerId, $player2Id));

			$result['result'] = 1;
			Page::addAlert(PageLang::ALERT_OK, PlayerAdminLang::OK_MARRIED);
			Page::chatSystemSend(Std::renderTemplate(PlayerAdminLang::OK_MARRIED_CHAT, array('player1name' => $player['nickname'], 'player2name' => $player2['nickname'])), "wedding");
			return $result;
		}



		// развести
		if (!$marry) {
			if ($ring['type'] != 'award' && $ring2['type'] != 'award') {
				$result['result'] = 0;
				Page::addAlert(PlayerAdminLang::ERROR, PlayerAdminLang::ERROR_NOT_MARRIED, ALERT_ERROR);
				return $result;
			}

			$query = "DELETE FROM gift WHERE id IN (" . $ring['id'] . ", " . $ring2['id'] . ")";
			Page::$sql->query($query);

			Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '-marry', 'p2' => $player2), 0);
			Page::sendLog($player2Id, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '-marry', 'p2' => $player), 0);

			CacheManager::deleteSet('player_gifts', 'player_id', array($playerId, $player2Id));

			$result['result'] = 1;
			Page::addAlert(PageLang::ALERT_OK, PlayerAdminLang::OK_UNMARRIED);
			return $result;
		}
	}

	public static function adminMarryFight($playerId) {
		$result = array('type' => 'admin', 'action' => 'marry_fight', 'params' => array('url' => '/player/' . $playerId . '/'));

		if (Page::$player->access['marry'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}

		$player = CacheManager::get('player_small', array('player_id' => $playerId));
		$query = "SELECT id, type, player_from FROM gift WHERE player = " . $playerId . " AND SUBSTR(code, 1, 12) = 'wedding_ring' AND hidden = 0 AND type = 'award' AND time > " . (time() - 900);
		$ring = Page::$sql->getRecord($query);

		if (!$ring) {
			$result['result'] = 0;
			Page::addAlert(PlayerAdminLang::ERROR, PlayerAdminLang::ERROR_RING_NOT_FOUND, ALERT_ERROR);
			return $result;
		}

		$player2Id = Page::getPlayerId($ring['player_from']);
		$player2 = CacheManager::get('player_small', array('player_id' => $player2Id));
		$query = "SELECT id, type FROM gift WHERE player = " . $player2Id . " AND player_from LIKE '" . $player['nickname'] . "'  AND SUBSTR(code, 1, 12) = 'wedding_ring' AND hidden = 0 AND type = 'award' AND time > " . (time() - 900);
		$ring2 = Page::$sql->getRecord($query);

		if (!$ring2) {
			$result['result'] = 0;
			Page::addAlert(PlayerAdminLang::ERROR, PlayerAdminLang::ERROR_PARTNER_RING_NOT_FOUND, ALERT_ERROR);
			return $result;
		}

		Std::loadModule('Fight');
		$fightId = Fight::createFight('chaotic', 0);
		Page::$cache->set('wedding', $fightId, 300);

		// ok
		$result['result'] = 1;
		//Page::addAlert(PageLang::ALERT_OK, PlayerAdminLang::OK_WAIT_FOR_FIGHT);
		Page::chatSystemSend(PlayerAdminLang::OK_WAIT_FOR_FIGHT, "wedding");
		return $result;
	}

	/**
	 * Пересчет статов игрока
	 *
	 * @param int $playerId
	 * @return array
	 */
	public static function adminRecalcStats($playerId) {
		$result = array('type' => 'admin', 'action' => 'recalc', 'params' => array('url' => '/player/' . $playerId . '/'));
		$player = new playerObject();
		$load = $player->load($playerId);
		if ($load == false) {
			$result['result'] = 0;
			$result['error'] = 'no player found';
			return $result;
		}
		$mustbe = array();
		$stats = Page::$sql->getRecordSet("SELECT health, strength, dexterity, charism, attention, intuition, resistance FROM inventory WHERE player = " . $playerId . " and equipped = 1 and !(type='tech' and level>2)
										UNION SELECT health, strength, dexterity, charism, attention, intuition, resistance FROM playerboost2 WHERE player = " . $playerId);
		if (is_array($stats) && count($stats)) {
			foreach ($stats as $boost) {
				foreach (self::$boostTypes2 as $type) {
					$value = $boost[$type];
					if (abs($value) <= 0.1) {
						$mustbe[$type . '_percent'] += $value * 1000;
					} else if ($value != 0) {
						$mustbe[$type . '_bonus'] += $value;
					}
				}
			}
			$fields2 = array();
			foreach (self::$boostTypes2 as $type) {
				$player->{$type . '_bonus'} = $mustbe[$type . '_bonus'];
				$player->{$type . '_percent'} = $mustbe[$type . '_percent'];
				$fields2[] = playerObject::${strtoupper($type . '_percent')};
				$fields2[] = playerObject::${strtoupper($type . '_bonus')};
			}
			$player->save($player->id, $fields2);
		}
		$player->recalcStats();
		$result['result'] = 1;
		return $result;
	}

	/**
	 * Бан по IP
	 *
	 * @param int $playerId
	 * @param string $text
	 * @param <type> $period
	 * @return array
	 */
	public static function adminIpBan($playerId, $text, $period) {
		$result = array('type' => 'admin', 'action' => 'ipban', 'params' => array('url' => '/player/' . $playerId . '/'));
		if (Page::$player->access['ipban'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		$ip = Page::$sql->getValue("SELECT ip FROM player WHERE id = " . $playerId);
		$ip = long2ip($ip);
		if (Page::$sql->getValue("SELECT 1 FROM ipban WHERE ip = '" . $ip . "' OR ip = '" . substr($i, 0, strrpos($ip, '.')+1) . "' LIMIT 1")) {
			$result['result'] = 0;
			$result['error'] = 'already banned';
			return $result;
		}
		$comment = "Игрок: " . $playerId . "\r\nМодератор: " . Page::$player->nickname . "\r\nПричина: " . $text;
		preg_match("/([0-9]+)d/", $period, $match);
		$days = $match[1];
		$sql = "INSERT INTO ipban (ip, active, dt_finished, comment) VALUES ('" . $ip . "', 0, ADDDATE(CURDATE(), INTERVAL " . $days . " DAY), '" . mysql_escape_string($comment) . "')";
		Page::$sql->query($sql);
		$result['result'] = 1;
		return $result;
	}

	/**
	 * Пересчет рейтинга игрока
	 *
	 * @param int $playerId
	 * @param string $action
	 * @return array
	 */
	public static function adminRating($playerId, $action) {
		$result = array('type' => 'admin', 'action' => $action . ' rating', 'params' => array('url' => '/player/' . $playerId . '/'));
		if (Page::$player->access['rating'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		$result['result'] = 1;
		if ($action == 'repair') {
			$tmp = Page::$sql->getRecord("select fraction, level from player where id = " . $playerId . " limit 1");
			Page::$sql->query("insert into rating_player(id, fraction, level, visible) values(" . $playerId . ", '" . $tmp['fraction'] . "', " . $tmp['level'] . ", 1) on duplicate key update visible = 1");
			Page::$sql->query("insert into rating_player2(id, fraction, level, visible) values(" . $playerId . ", '" . $tmp['fraction'] . "', " . $tmp['level'] . ", 1) on duplicate key update visible = 1");
		} else if ($action == 'on') {
			Page::$sql->query("update rating_player set visible = 1 where player = " . $playerId);
			Page::$sql->query("update rating_player2 set visible = 1 where player = " . $playerId);
		} else if ($action == 'off') {
			Page::$sql->query("update rating_player set visible = 0 where player = " . $playerId);
			Page::$sql->query("update rating_player2 set visible = 0 where player = " . $playerId);
		}
		return $result;
	}

	/**
	 * Принятие/отклонение аватара игрока
	 *
	 * @param int $playerId
	 * @param string $action
	 * @param string $text
	 * @return array
	 */
	public static function adminForumAvatar($playerId, $action, $text) {
		$result = array('type' => 'admin', 'action' => 'forum checking avatar ' . $action, 'params' => array('url' => '/player/' . $playerId . '/'));
		if (Page::$player->access['forum_checking_avatar'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		if ($action == 'allow') {
			Page::$sql->query("update player set forum_avatar_checked = 1 where id = " . $playerId);
			$result['result'] = 1;
			Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '+avatar'));
		} else if ($action == 'deny') {
			Page::$sql->query("update player set forum_avatar_checked = 1 where id = " . $playerId);
			Page::$sql->query("update player set forum_avatar = 0 where id = " . $playerId);
			$result['result'] = 1;
			Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '-avatar', 'text' => htmlspecialchars($text)), 0);
		}
		return $result;
	}

	/**
	 * Передача флага игроку
	 *
	 * @param int $playerId
	 * @return array
	 */
	public static function adminGiveFlag($playerId) {
		$result = array('type' => 'admin', 'action' => 'player giveflag', 'params' => array('url' => '/player/' . $playerId . '/'));
		if (Page::$player->access['player_flag'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		Std::loadMetaObjectClass('standard_item');
		$item = new standard_itemObject();
		$item->loadByCode('ctf_flag');
		$item->giveGift('', $playerId);
		$result['result'] = 1;
		return $result;
	}

	/*
	 * Передача сертификата на бесплатную смену ника
	 *
	 * @param int $playerId - id игрока
	*/
	public static function adminGiveCertChangenickname($playerId) {
		$result = array('type' => 'admin', 'action' => 'player give_cert_changenickname', 'params' => array('url' => '/player/' . $playerId . '/'));
		if (Page::$player->access['give_cert_changenickname'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		Std::loadMetaObjectClass('standard_item');
		$item = new standard_itemObject();
		$item->loadByCode('cert_changenickname');
		$item->makeExample($playerId);
		$result['result'] = 1;
		Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '+give_cert_changenickname', 'text' => htmlspecialchars($text)));
		return $result;
	}

	/**
	 * Удаление игрока из клана, назначение игрока главой клана
	 *
	 * @param int $playerId
	 * @param string $type
	 * @return array
	 */
	public static function adminPlayerClan($playerId, $type) {
		$result = array('type' => 'admin', 'action' => 'player clan ' . $type, 'params' => array('url' => '/player/' . $playerId . '/'));
		if (($type == 'kick' && Page::$player->access['clan_kick'] != 1) || ($type == 'set founder' && Page::$player->access['clan_setfounder'] != 1)) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		$clan = Page::$sql->getRecord("SELECT clan as id, clan_status as status FROM player WHERE id = " . $playerId . " and clan > 0 and clan_status != 'recruit' limit 1");
		if ($clan === false) {
			$result['result'] = 0;
			$result['error'] = 'player is not in clan';
			return $result;
		} else if ($type == 'set founder' && $clan['status'] == 'founder') {
			$result['result'] = 0;
			$result['error'] = 'player is clan founder';
			return $result;
		} else if ($type == 'kick' && $clan['status'] == 'founder') {
			$result['result'] = 0;
			$result['error'] = 'player is clan founder';
			return $result;
		}
		if ($type == 'set founder') {
			$oldFounder = Page::$sql->getValue("select founder from clan where id = " . $clan['id']);
			Page::$sql->query("DELETE FROM gift WHERE code = 'clan_founder_crown' and player = " . $oldFounder);
			Page::$sql->query("update playerboost2 set `dt2` = '2000-00-00 00:00:00' WHERE code = 'clan_founder_crown' and player = " . $oldFounder);
			Std::loadMetaObjectClass('standard_item');
			$standard_item = new standard_itemObject();
			$standard_item->loadByCode('clan_founder_crown');
			$standard_item->giveGift('', $playerId);
			Page::$sql->query("update player set clan_status = 'accepted' where id = " . $oldFounder);
			Page::$sql->query("update player set clan_status = 'founder' where id = " . $playerId);
			Page::$sql->query("update clan set founder = " . $playerId . " where id = " . $clan['id']);
			CacheManager::delete('clan_full', array('clan_id' => $clan['id']));
			$result['result'] = 1;
			return $result;
		} else if ($type == 'kick') {
			Page::$sql->query("update player set clan_status = '', clan = 0 where id = " . $playerId);
			$result['result'] = 1;
			return $result;
		}

	}

	/**
	 * Добавление комментария в досье игрока
	 *
	 * @param int $playerId
	 * @param string $action
	 * @param string $period
	 * @param string $text
	 * @return array
	 */
	public static function adminAddPlayerComment($playerId, $action, $period, $text, $checkAccess = true, $moderator = null) {
		if ($checkAccess && Page::$player->access['player_comment'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		if ($moderator == null) {
			$moderator = Page::$player->id;
		}
		Std::loadMetaObjectClass('playercomment');
		$playerComment = new playercommentObject();
		$playerComment->player = $playerId;
		$playerComment->player2 = $moderator;
		$playerComment->action = $action;
		$playerComment->period = preg_replace('/[^\w]/', '', $period);
		$playerComment->text = Std::cleanString(htmlspecialchars($text));
		$playerComment->dt = date('Y-m-d H:i:s', time());
		$playerComment->save();
	}

	/**
	 * Блокирование/разблокирование игрока
	 *
	 * @param int $playerId
	 * @param bool $block
	 * @param string $reason
	 * @param int $unbancost
	 * @return array
	 */
	public static function adminPlayerBlock($playerId, $block = true, $reason = '', $unbancost = 50, $skipAccess=false) {
		if (($block == true && Page::$player->access['player_block'] != 1) || ($block == false && Page::$player->access['player_unblock'] != 1)){
		    if (!$skipAccess){
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		    }
		}
		$player = new playerObject();
		$player->load($playerId);
		//$info = Page::$sql->getValue("SELECT about FROM player WHERE id = " . $playerId);
		if (is_string($player->about)) {
			$info = json_decode($info, true);
		} else {
			$info = $player->about;
		}
		if ($block == true) {
			Page::$sql->query("update rating_player set `visible` = 0 where player = " . $playerId);
			Page::$sql->query("update rating_player2 set `visible` = 0 where player = " . $playerId);
			Page::$sql->query("UPDATE player2 SET unbancost = " . (int) $unbancost . " where player = " . $playerId);
			if ($reason != '') {
				$info['about'] = 'Игрок заблокирован ' . date("d.m.Y H:i:s") . " с причиной: " . $reason;
			} else {
				$info['about'] = 'Игрок заблокирован ' . date("d.m.Y H:i:s");
			}
			$logreason = $reason;
			$reason .= 'Стоимость разбана: ' . $unbancost . ' меда.';

            Std::loadModule("Sovet");
            Sovet::kickFromSovet($playerId);
		} else {
			Page::$sql->query("update rating_player set `visible` = 1 where player = " . $playerId);
			Page::$sql->query("update rating_player2 set `visible` = 1 where player = " . $playerId);
			$info['about'] = '';
		}
		
		// военные штучки
		Std::loadMetaObjectClass('diplomacy');
		$playerСlan = Page::$sql->getValue("SELECT clan FROM player WHERE id=" . $playerId);
		$warId = diplomacyObject::isAtWar($playerСlan);
		if ($warId) {
			$war = new diplomacyObject();
			$war->load($warId);
			if ($war->state == 'step1') {
				$war->setKills($playerId, Page::$data['diplomacy']['kills']);
			}
			if ($war->clan1 == Page::$player->clan || $war->clan2 == Page::$player->clan) {
				$war->tryAutoSurrender(Page::$player->clan);
			}
		}

		$player->about = json_encode($info);
		if ($block) {
			$player->accesslevel = -1;
			$player->updateHomeSalary();
			//Page::$sql->query("UPDATE player SET accesslevel = -1, about = '" . addslashes(json_encode($info)) . "' WHERE id = " . $playerId);
		} else {
			$player->accesslevel = 0;
			$player->homesalarytime = mktime(date("H"), 0, 0);
			//Page::$sql->query("UPDATE player SET accesslevel = 0, about = '" . addslashes(json_encode($info)) . "' WHERE id = " . $playerId);
		}
		$player->save($player->id, array(playerObject::$ACCESSLEVEL, playerObject::$ABOUT, playerObject::$HOMESALARYTIME));

		// CHAT блокируем в чате
		$key = Page::signed($playerId);
		$userInfo = array();
		$userInfo[$key] = array();
		$userInfo[$key]["accesslevel"] = ($block ? -1 : 0);
		Page::chatUpdateInfo($userInfo);

		$cachePlayer = Page::$cache->get("user_chat_" . $key);
		if ($cachePlayer) {
			$cachePlayer["accesslevel"] = $userInfo[$key]["accesslevel"];
			Page::$cache->set("user_chat_" . $key, $cachePlayer);
		}

		if (!$skipAccess){
		Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => ($block ? '+' : '-') . 'block', 'text' => htmlspecialchars($logreason)));
		}
		
		return array(
				'type' => 'admin',
				'action' => 'player block',
				'params' => array(
						'url' => '/player/' . $playerId . '/',
				),
				'result' => 1,
		);
	}

	/**
	 * Наложение/снятие молчанки на игрока
	 *
	 * @param int $playerId
	 * @param string $muteType
	 * @param string $period
	 * @param bool $mute
	 * @return array
	 */
	public static function adminPlayerMute($playerId, $muteType, $period, $mute = true, $text = '', $moderatorId = null) {
		Std::loadMetaObjectClass('player');
		if ($moderatorId == null) {
			$moderator = Page::$player;
		} else {
			$moderator = new playerObject;
			$moderator->load($moderatorId);
			$moderator->loadAccess();
		}
		$result = array(
				'type' => 'admin',
				'action' => 'player mute' . $muteType . ' ' . ($mute ? 'add' : 'cancel'),
				'params' => array (
						'url' => '/player/' . $playerId . '/',
				),
				'result' => 1,
		);
		$tmp = Page::$sql->getRecord("select nickname, chatroom from player where id = " . $playerId);
		if ($tmp) {
			$nickname = $tmp['nickname'];
			$channel = $tmp['chatroom'];
		} else {
			$nickname = false;
		}
		if ($nickname === false) {
			$result['result'] = 0;
			$result['error'] = 'no player found';
			return $result;
		}
		if ($moderator->access['player_mute_' . $muteType] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}
		if ($mute) {
			if (is_int($period)) {
				$time = $period;
			} else {
				$time = Page::timeLettersToSeconds($period);
			}
			if ($time <= 0) {
				$result['result'] = 0;
				$result['error'] = 'bad time';
			} else {
				Page::$sql->query("UPDATE player SET mute_" . $muteType . " = if(mute_" . $muteType . " > " . time() . ", mute_" . $muteType . ", " . time() . ") + " . $time . " WHERE id = " . $playerId);
				Page::sendLog($playerId, 'admin_action', array('player' => $moderator->exportForLogs(), 'action' => '+mute_' . $muteType, 'period' => Std::formatPeriod($time), 'text' => htmlspecialchars($text)));
			}
		} else {
			Page::$sql->query("UPDATE player SET mute_" . $muteType . " = 0 WHERE id = " . $playerId);
			Page::sendLog($playerId, 'admin_action', array('player' => $moderator->exportForLogs(), 'action' => '-mute_' . $muteType, 'text' => htmlspecialchars($text)));
		}
		if ($muteType == 'chat') {
			//Std::loadMetaObjectClass('chatlog');
			//$chatlog = new chatlogObject();
			//$chatlog->type = $channel;
			//$chatlog->time = time();
			//$chatlog->player_from = $moderator->id;
			//$chatlog->player_from_nickname = $moderator->nickname;
			//$chatlog->player_from = 0;
			//$chatlog->player_from_nickname = 'Уведомление';

			$key = Page::signed($playerId);
			$userInfo = array();
			$userInfo[$key] = array();
			$cachePlayer = Page::$cache->get("user_chat_" . $key);

			if ($mute) {
				$mPlayer = new playerObject;
				$mPlayer->load($playerId);
				//$chatlog->text = "Модератор " . $moderator->nickname . " накладывает молчанку на игрока " . $nickname . " длительностью " . Std::formatPeriod($time) . (($text == "") ? "." : " (причина: " . $text . ").");
				if ($cachePlayer) {
					$cachePlayer["mute_chat"] = $mPlayer->mute_chat;
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}
				$userInfo[$key]["mute_chat"] = $mPlayer->mute_chat;
			} else {
				//$chatlog->text = "Модератор " . $moderator->nickname . " снял молчанку с игрока " . $nickname . ".";
				if ($cachePlayer) {
					$cachePlayer["mute_chat"] = null;
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}
				$userInfo[$key]["mute_chat"] = null;
			}
			Page::chatUpdateInfo($userInfo);

			//$chatlog->save();
		}
		return $result;
	}

	/**
	 * Изоляция/снятие изоляции в чате
	 *
	 * @param int $playerId
	 * @param bool $on
	 * @param string $period
	 * @param string $text
	 * @return array
	 */
	public static function adminPlayerIsolate($playerId, $on, $period, $text = '', $moderatorId = null) {
		Std::loadMetaObjectClass('player');
		if ($moderatorId == null) {
			$moderator = Page::$player;
		} else {
			$moderator = new playerObject;
			$moderator->load($moderatorId);
			$moderator->loadAccess();
		}

		$result = array(
				'type' => 'admin',
				'action' => 'player isolate ' . ($on ? 'on' : 'off'),
				'params' => array (
						'url' => '/player/' . $playerId . '/',
				),
				'result' => 1,
		);
		$nickname = Page::$sql->getValue("select nickname from player where id = " . $playerId);
		if ($nickname === false) {
			$result['result'] = 0;
			$result['error'] = 'no player found';
			return $result;
		}
		if ($moderator->access['player_chat_isolate'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}

		$key = Page::signed($playerId);
		$userInfo = array();
		$userInfo[$key] = array();
		$cachePlayer = Page::$cache->get("user_chat_" . $key);

		if ($on) {
			if (is_int($period)) {
				$time = $period;
			} else {
				$time = Page::timeLettersToSeconds($period);
			}

			if ($time <= 0) {
				$result['result'] = 0;
				$result['error'] = 'bad time';
			} else {
				Page::$sql->query("UPDATE player SET isolate_chat = if(isolate_chat > " . time() . ", isolate_chat, " . time() . ") + " . $time . " WHERE id = " . $playerId);
				$iPlayer = new playerObject;
				$iPlayer->load($playerId);

				if ($cachePlayer) {
					$cachePlayer["isolate_chat"] = $iPlayer->isolate_chat;
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}
				$userInfo[$key]["isolate_chat"] = $iPlayer->isolate_chat;
			}
		} else {
			Page::$sql->query("UPDATE player SET isolate_chat = 0 WHERE id = " . $playerId);
			if ($cachePlayer) {
				$cachePlayer["isolate_chat"] = null;
				Page::$cache->set("user_chat_" . $key, $cachePlayer);
			}
			$userInfo[$key]["isolate_chat"] = null;
		}
		Page::chatUpdateInfo($userInfo);

		return $result;
	}

	/**
	 * Очистка информации персонажа
	 *
	 * @param int $playerId
	 * @return array
	 */
	public static function adminClearInfo($playerId) {
		$result = array(
				'type' => 'admin',
				'action' => 'player clear info',
				'params' => array(
						'url' => '/player/' . $playerId . '/',
				),
				'result' => 1,
		);
		if (Page::$player->access['player_clear_info'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}

		$p2 = new player2Object();
		$p2->load($playerId);
		$p2->slogan = '';
		$p2->name = '';
		$p2->birthdt = '0000-00-00 00:00:00';
		$p2->about = '';
		$p2->country = 0;
		$p2->city = 0;
		$p2->metro = 0;
		$p2->family = '';
		$p2->business = '';
		$p2->age = 0;
		$p2->vkontakte = "";
		$p2->facebook = "";
		$p2->twitter = "";
		$p2->livejournal = "";
		$p2->mailru = "";
		$p2->odnoklassniki = "";
		$p2->liveinternet = "";
		$p2->save($p2->id, array(player2Object::$SLOGAN, player2Object::$NAME,
				player2Object::$ABOUT, player2Object::$BIRTHDT, player2Object::$AGE, player2Object::$COUNTRY,
				player2Object::$CITY, player2Object::$METRO, player2Object::$FAMILY, player2Object::$BUSINESS,
				player2Object::$VKONTAKTE, player2Object::$FACEBOOK, player2Object::$TWITTER, player2Object::$LIVEJOURNAL,
				player2Object::$MAILRU, player2Object::$ODNOKLASSNIKI, player2Object::$LIVEINTERNET));

		return $result;
	}

	/**
	 * Очистка клички питомца
	 *
	 * @param int $playerId
	 * @return array
	 */
	public static function adminClearPetInfo($playerId) {
		$result = array(
				'type' => 'admin',
				'action' => 'player clear pet info',
				'params' => array(
						'url' => '/player/' . $playerId . '/',
				),
				'result' => 1,
		);
		if (Page::$player->access['player_clear_info'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		}

		$p = new playerObject();
		$p->load($playerId);
		$pets = $p->loadPets();
		foreach ($pets as $pet) {
			$pet->name = preg_replace('~ ".*"$~', '', $pet->name);
			$pet->save(array(petObject::$NAME));
		}

		return $result;
	}

	/**
	 * Отправка игркоа в тюрьму
	 *
	 * @param int $playerId
	 * @param string $period
	 * @param bool $free
	 * @return array
	 */
	public static function adminPlayerJail($playerId, $period, $free = false, $text = '',$skipAccess=false) {
		$result = array(
				'type' => 'admin',
				'action' => 'player ' . ($free ? 'free' : 'send') . ' jail',
				'params' => array(
						'url' => '/player/' . $playerId . '/',
				),
				'result' => 1,
		);

		if (Page::$player->access['player_jail'] != 1) {
			if (!$skipAccess){
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
			}
		}
		$player = new playerObject();
		$player->load($playerId);
		if ($free) {
			$player->state = '';
			$player->stateparam = '';
			$player->timer = 1;
			$player->homesalarytime = mktime(date("H"), 0, 0);
			$player->save($player->id, array(playerObject::$STATE, playerObject::$TIMER, playerObject::$STATEPARAM, playerObject::$HOMESALARYTIME));

			Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '-jail', 'text' => htmlspecialchars($text)));
			Page::addAlert('Тюрьма', 'Игрок выпущен из тюрьмы.');
		} else {
			/* Удаляем из боёв. Проверки на frozen не хватает т.к. в бое за банк оно не проставляется */
			// Удалить можно только из созданного боя. После начала уже нельзя
			$fight = Page::$sql->getRecord("SELECT fp.fight, fp.side FROM fightplayer fp INNER JOIN fight f ON f.id = fp.fight WHERE f.state = 'created' AND fp.player = " . $player->id);
			if ($fight) {
				Page::$sql->query("UPDATE fight SET " . $fight["side"] . "c = " . $fight["side"] . "c - 1 WHERE id = " . $fight["fight"]);
				Page::$sql->query("DELETE FROM fightplayer WHERE fight = " . $fight["fight"] . " AND player = " . $player->id);
			}

			/***********/
			$player->state = 'police';
			$player->stateparam = 'admin';
			$player->timer = time() + Page::timeLettersToSeconds($_POST['period']);
			$player->updateHomeSalary();
			$player->save($player->id, array(playerObject::$STATE, playerObject::$TIMER, playerObject::$STATEPARAM));

			// Костыль чтобы выкинуть сажаемого из работ в маке и патруле.
			Page::$sql->query("DELETE FROM playerwork WHERE (type = 'macdonalds' OR type = 'patrol') AND player = " . $player->id);
			if(!$skipAccess){
			Page::sendLog($playerId, 'admin_action', array('player' => Page::$player->exportForLogs(), 'action' => '+jail', 'period' => $period, 'text' => htmlspecialchars($text)));
			Page::addAlert('Тюрьма', 'Игрок отправлен в тюрьму.');
			}
		}
		return $result;
	}
}
?>
