<?php
$cacheObjects = array();
//fields: key, memcacheKey, type=value/valueset/record/recordset/function, getter=sql_query(string)/function, primary=yes/no, time = 300
$cacheObjects['clan_full'] = array('mkey' => 'clan_full_{clan_id}', 'type' => 'record', 'getter' => 'select * from clan where id = {clan_id}', 'time' => 86400);
$cacheObjects['clan_shortinfo'] = array('mkey' => 'clan_shortinfo_{clan_id}', 'type' => 'record', 'getter' => 'select id, name, level, fraction from clan where id = {clan_id}', 'time' => 86400);
$cacheObjects['player_small'] = array('mkey' => 'player_small_{player_id}', 'type' => 'record', 'getter' => "select p.id, p.nickname, p.lastactivitytime, p.fraction, p.level, p.clan, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan_id from player p where id = {player_id}", 'time' => 3600);

$cacheObjects['player_stat'] = array('mkey' => 'player_stat_{player_id}', 'type' => 'record', 'getter' => "SELECT player id, moneygrabbed, moneylost, wins, referers FROM rating_player WHERE player = {player_id}", 'time' => 300);

$cacheObjects['standard_item_stats'] = array('mkey' => 'standard_item_stats_{standard_item_id}', 'getter' => "SELECT si.id, si.health, si.strength, si.dexterity, si.intuition, si.resistance, si.attention, si.charism, si.ratingcrit, si.ratingaccur, si.ratingdodge, si.ratinganticrit, si.ratingresist, si.ratingdamage, si.special1, si.special1name, si.special2, si.special2name, si.special3, si.special3name, si.special4, si.special4name, si.special5, si.special5name, si.special6, si.special6name, si.special7, si.special7name, si.subtype, si.time FROM standard_item si WHERE si.id = {standard_item_id}", 'type' => 'record', 'time' => 86400);

$cacheObjects['player_access'] = array('mkey' => 'player_access_{player_id}', 'type' => 'function', 'getter' => function($params) {
	$sql = "SELECT a.code FROM access a LEFT JOIN metalink ml ON ml.linkedobject_id = a.id LEFT JOIN metaattribute ma ON ml.metaattribute_id = ma.id LEFT JOIN metaobject mo ON mo.id = ma.metaobject_id WHERE mo.code =  'player' AND ma.code = 'access' and ml.object_id = " . $params['player_id'];
	$tmpAccess = CacheManager::$sql->getValueSet($sql);

	$access = array();
	if ($tmpAccess !== false && is_array($tmpAccess) && sizeof($tmpAccess) > 0) {
		foreach ($tmpAccess as $a) {
			$access[$a] = 1;
		}
	}
	return $access;
}, 'time' => 3600);

$cacheObjects['clan_boosts'] = array('mkey' => 'clan_boosts_{clan_id}', 'type' => 'function', 'getter' => function($params) {
	$sql = "SELECT code, SUM(value) as value, dt2, info FROM boost WHERE clan = " . $params['clan_id'] . " GROUP BY code";
	$boostsRatings = Page::$sql->getRecordSet($sql);
	$boosts = array();
	if (is_array($boostsRatings) && count($boostsRatings)) {
		$boosts[0] = array('title' => ClanLang::CLAN_TEMP_BOOST);
		foreach ($boostsRatings as $b) {
			$boosts[0]['boosts'][] = array('name' => Page::$data['ratings'][$b['code']]['name'], 'value' => $b['value']);
		}
	}
	$sql = "SELECT c.attack, c.defence, c.level FROM clan c WHERE c.id = " . $params['clan_id'];
	$upgrades = Page::$sql->getRecord($sql);
	$level = $upgrades['level'];
	if ($upgrades['attack'] > 0 || $upgrades['defence'] > 0) {
		$boosts[1] = array('title' => ClanLang::CLAN_UPGRADES);
		if ($upgrades['attack'] > 0) {
			$boosts[1]['boosts'][] = array('name' => Page::$data['ratings']['ratingdamage']['name'], 'value' => Page::$data['clan']['upgrades_ratings'][$upgrades['attack']-1] * 5);
		}
		if ($upgrades['defence'] > 0) {
			$boosts[1]['boosts'][] = array('name' => Page::$data['ratings']['ratingresist']['name'], 'value' => Page::$data['clan']['upgrades_ratings'][$upgrades['defence']-1] * 5);
		}
	}
	$info = '';
	if (count($boosts)) {
		foreach ($boosts as $b) {
			$info .= '<b>' . $b['title'] . '</b>:<br />';
			foreach ($b['boosts'] as $b2) {
				if (abs($b2['value']) > 1) {
					$value = $b2['value'];
				} else {
					$value = $b2['value'] * 1000;
				}
				if ($value > 0) {
					$value = '+' . $value;
				}
				if (abs($b2['value']) < 0.1) {
					$value .= '%';
				}
				$info .= '&#0160; &#0160; &#0160; ' . $b2['name'] . ': ' . $value . '<br />';
			}
		}
	}
		$award = array('count' => 1, 'code' => 'soft_clan_award', 'name' => ClanLang::CLAN_AWARD, 'image' => 'clansign' . $level . '.png', 'info' => '<span class=\'brown\'>' . $info . '</span>');
	return $award;
}, 'time' => 3600);


$cacheObjects['player_equipped'] = array('mkey' => 'player_equipped_{player_id}', 'getter' => "SELECT name, image, info, slot, type, standard_item si, mf FROM inventory WHERE player = {player_id} AND equipped = 1", 'type' => 'recordset', 'time' => 3600);
$cacheObjects['player_gifts'] = array('mkey' => 'player_gifts_{player_id}', 'getter' => function($params) {
	//SELECT g.*, g.time gifttime, IFNULL(si.health, 0) health, IFNULL(si.strength, 0) strength, IFNULL(si.dexterity, 0) dexterity, IFNULL(si.intuition, 0) intuition, IFNULL(si.resistance, 0) resistance, IFNULL(si.attention, 0) attention, IFNULL(si.charism, 0) charism, IFNULL(si.ratingcrit, 0) ratingcrit, IFNULL(si.ratingaccur, 0) ratingaccur, IFNULL(si.ratingdodge, 0) ratingdodge, IFNULL(si.ratinganticrit, 0) ratinganticrit, IFNULL(si.ratingresist, 0) ratingresist, IFNULL(si.ratingdamage, 0) ratingdamage, si.special1, si.special1name, si.special2, si.special2name, si.special3, si.special3name, si.special4, si.special4name, si.special5, si.special5name, si.special6, si.special6name, si.special7, si.special7name, si.subtype, si.time FROM gift g LEFT JOIN standard_item si ON si.id = g.standard_item WHERE g.hidden = 0 AND g.player = {player_id} ORDER BY g.time DESC",
	$sql = "SELECT g.*, g.time gifttime FROM gift g WHERE g.hidden = 0 AND g.player = " . $params['player_id'] /*. " ORDER BY g.time DESC"*/;
	$results = CacheManager::$sql->getRecordSet($sql);
	if (!$results) {
		return false;
	}
	Std::sortRecordSetByField($results, "gifttime", 0);
	$standard_itemIds = array();
	foreach ($results as $r) {
		if ($r['standard_item'] > 0) {
			$standard_itemIds[$r['standard_item']] = 1;
		}
	}
	if (count($standard_itemIds)) {
		$standard_itemIds = CacheManager::getSet('standard_item_stats', 'standard_item_id', array_keys($standard_itemIds));
	}
	foreach ($results as &$r) {
		$r['health'] = (int) $standard_itemIds[$r['standard_item']]['health'];
		$r['strength'] = (int) $standard_itemIds[$r['standard_item']]['strength'];
		$r['dexterity'] = (int) $standard_itemIds[$r['standard_item']]['dexterity'];
		$r['intuition'] = (int) $standard_itemIds[$r['standard_item']]['intuition'];
		$r['resistance'] = (int) $standard_itemIds[$r['standard_item']]['resistance'];
		$r['attention'] = (int) $standard_itemIds[$r['standard_item']]['attention'];
		$r['charism'] = (int) $standard_itemIds[$r['standard_item']]['charism'];

		$r['ratingcrit'] = (int) $standard_itemIds[$r['standard_item']]['ratingcrit'];
		$r['ratingaccur'] = (int) $standard_itemIds[$r['standard_item']]['ratingaccur'];
		$r['ratingdodge'] = (int) $standard_itemIds[$r['standard_item']]['ratingdodge'];
		$r['ratinganticrit'] = (int) $standard_itemIds[$r['standard_item']]['ratinganticrit'];
		$r['ratingresist'] = (int) $standard_itemIds[$r['standard_item']]['ratingresist'];
		$r['ratingdamage'] = (int) $standard_itemIds[$r['standard_item']]['ratingdamage'];

		$r['special1'] = (string) $standard_itemIds[$r['standard_item']]['special1'];
		$r['special1name'] = (string) $standard_itemIds[$r['standard_item']]['special1name'];
		$r['special2'] = (string) $standard_itemIds[$r['standard_item']]['special2'];
		$r['special2name'] = (string) $standard_itemIds[$r['standard_item']]['special2name'];
		$r['special3'] = (string) $standard_itemIds[$r['standard_item']]['special3'];
		$r['special3name'] = (string) $standard_itemIds[$r['standard_item']]['special3name'];
		$r['special4'] = (string) $standard_itemIds[$r['standard_item']]['special4'];
		$r['special4name'] = (string) $standard_itemIds[$r['standard_item']]['special4name'];
		$r['special5'] = (string) $standard_itemIds[$r['standard_item']]['special5'];
		$r['special5name'] = (string) $standard_itemIds[$r['standard_item']]['special5name'];
		$r['special6'] = (string) $standard_itemIds[$r['standard_item']]['special6'];
		$r['special6name'] = (string) $standard_itemIds[$r['item']]['special6name'];
		$r['special7'] = (string) $standard_itemIds[$r['standard_item']]['special7'];
		$r['subtype'] = (string) $standard_itemIds[$r['standard_item']]['subtype'];
		$r['time'] = (string) $standard_itemIds[$r['standard_item']]['time'];
		if (substr($r['code'], 0, 12) == 'wedding_ring') {
			unset($r['time']);
		}
	}
	return $results;
}
,'type' => 'function', 'time' => 3600);

$cacheObjects['metaobject_id_by_mocode'] = array('mkey' => 'metaobject_id_by_code_{metaobject_code}', 'getter' => "SELECT id FROM metaobject WHERE code='{metaobject_code}' limit 1", 'type' => 'value', 'time' => 86400);
$cacheObjects['metaattribute_id_by_moid_macode'] = array('mkey' => 'metaattribute_id_by_moid_macode_{metaobject_id}_{metaattribute_code}', 'getter' => "SELECT id FROM metaattribute WHERE metaobject_id={metaobject_id} AND code='{metaattribute_code}'", 'type' => 'value', 'time' => 86400);

$cacheObjects['player2_interests_metaattribute'] = array('mkey' => 'player2_interests_metaattribute', 'getter' => "SELECT id FROM metaattribute WHERE metaobject_id=(SELECT id FROM metaobject WHERE code='player2') AND code='interests' LIMIT 1", 'type' => 'value', 'time' => 86400);

$cacheObjects['stdimage_path'] = array('mkey' => 'stdimage_path_{image_id}', 'getter' => "SELECT path FROM stdimage WHERE id = {image_id}", 'type' => 'value', 'time' => 86400);

$cacheObjects['player_interests'] = array('mkey' => 'player2_interests_{player2_id}', 'getter' => function($params) {
	$metaAttributeId = CacheManager::get('player2_interests_metaattribute');
	$sql = "SELECT sd.id, sd.name, sd.pos
                FROM metalink ml LEFT JOIN socialdata sd ON sd.id = ml.linkedobject_id
                WHERE ml.metaattribute_id = " . $metaAttributeId . " AND ml.object_id = " . $params['player2_id'];
	$results = CacheManager::$sql->getRecordSet($sql);
	if ($results) {
		Std::sortRecordSetByField($results, 'pos');
	}
	return $results;
}, 'type' => 'function', 'time' => 86400);

$cacheObjects['player_location'] = array('mkey' => 'player_location_{player_id}', 'getter' => "SELECT sd1.name country, sd2.name city, sd3.name metro, p2.family FROM player2 p2 LEFT JOIN socialdata sd1 ON sd1.id=p2.country LEFT JOIN socialdata sd2 ON sd2.id=p2.city LEFT JOIN socialdata sd3 ON sd3.id=p2.metro WHERE p2.player = {player_id}", 'type' => 'record', 'time' => 86400);


$cacheObjects['player_profile_photo'] = array('mkey' => 'player_profile_photo_{player_id}', 'getter' => "select id from photo where status = 'accepted' and player = {player_id} order by in_profile desc limit 1", 'type' => 'value', 'time' => 3600);
$cacheObjects['player_photo_amount'] = array('mkey' => 'player_photo_amount_{player_id}', 'getter' => "select count(1) from photo where status = 'accepted' and player = {player_id}", 'type' => 'value', 'time' => 3600);

$cacheObjects['pet_full'] = array('mkey' => 'pet_full_{pet_id}', 'type' => 'record', 'getter' => 'select * from pet where id = {pet_id}', 'time' => 86400);

$cacheObjects['player_pets_id'] = array('mkey' => 'player_pets_id_{player_id}', 'type' => 'valueset', 'getter' => 'select id from pet where player = {player_id}', 'time' => 86400);

$cacheObjects['value_flag_player'] = array('mkey' => 'value_flag_player', 'type' => 'value', 'getter' => "select value from value where name = 'flag_player'", 'time' => 86400);
$cacheObjects['value_flag_fraction'] = array('mkey' => 'value_flag_fraction', 'type' => 'value', 'getter' => "select value from value where name = 'flag_fraction'", 'time' => 86400);
$cacheObjects['value_flag_clan'] = array('mkey' => 'value_flag_clan', 'type' => 'value', 'getter' => "select value from value where name = 'flag_clan'", 'time' => 86400);
$cacheObjects['value_flag_capturedtime'] = array('mkey' => 'value_flag_capturedtime', 'type' => 'value', 'getter' => "select value from value where name = 'flag_capturedtime'", 'time' => 86400);
$cacheObjects['value_registrations'] = array('mkey' => 'value_registrations', 'type' => 'value', 'getter' => "select value from value where name = 'registrations'", 'time' => 86400);
$cacheObjects['value_sovet_results_calculated'] = array('mkey' => 'value_sovet_results_calculated', 'type' => 'value', 'getter' => "select value from value where name = 'sovet_results_calculated'", 'time' => 86400);
$cacheObjects['value_sovet_bonus_patrol'] = array('mkey' => 'value_sovet_bonus_patrol', 'type' => 'value', 'getter' => "select value from value where name = 'sovet_bonus_patrol'", 'time' => 86400);
$cacheObjects['value_sovet_results_calculated'] = array('mkey' => 'value_sovet_results_calculated', 'type' => 'value', 'getter' => "select value from value where name = 'sovet_results_calculated'", 'time' => 86400);
$cacheObjects['value_sovet_elections_voted'] = array('mkey' => 'value_sovet_elections_voted', 'type' => 'value', 'getter' => "select value from value where name = 'sovet_elections_voted'", 'time' => 86400);
$cacheObjects['value_sovet_members_selected'] = array('mkey' => 'value_sovet_members_selected', 'type' => 'value', 'getter' => "select value from value where name = 'sovet_members_selected'", 'time' => 86400);
$cacheObjects['value_casino_sportloto_today_numbers'] = array('mkey' => 'value_casino_sportloto_today_numbers', 'type' => 'value', 'getter' => "select value from value where name = 'casino_sportloto_today_numbers'", 'time' => 86400);
$cacheObjects['value_casino_sportloto_next_numbers'] = array('mkey' => 'value_casino_sportloto_next_numbers', 'type' => 'value', 'getter' => "select value from value where name = 'casino_sportloto_next_numbers'", 'time' => 86400);
$cacheObjects['value_casino_kubovich_time'] = array('mkey' => 'value_casino_kubovich_time', 'type' => 'value', 'getter' => "select value from value where name = 'casino_kubovich_time'", 'time' => 86400);

$cacheObjects['value_topplayers'] = array('mkey' => 'value_topplayers', 'getter' => "select value from value where name = 'topplayers'", 'type' => 'value', 'time' => 86400);
$cacheObjects['value_topplayerbest'] = array('mkey' => 'value_topplayerbest', 'getter' => "select value from value where name = 'topplayerbest'", 'type' => 'value', 'time' => 86400);

$cacheObjects['value_flag_fight_m2'] = array('mkey' => 'value_flag_fight_m2', 'getter' => "select value from value where name = 'flag_fight_m2'", 'type' => 'value', 'time' => 86400);

$cacheObjects['value_avgcut_stats'] = array('mkey' => 'value_avgcut_stats_{level}', 'getter' => function($params) {
	$sql = "select value from value where name = 'avgcut_stats_" . $params['level'] . "'";
	$result = CacheManager::$sql->getValue($sql);
	return $result;
}, 'type' => 'function', 'time' => 86400);

$cacheObjects['value_werewolf_stats'] = array('mkey' => 'value_werewolf_stats_{level}', 'getter' => function($params) {
	$sql = "select value from value where name = 'avgcut_stats_" . $params['level'] . "'";
	$result = CacheManager::$sql->getValue($sql);
	return $result;
}, 'type' => 'function', 'time' => 86400);

$cacheObjects['levelgroups'] = array('mkey' => 'levelgroups_{level}', 'getter' => function($params) {
	$sql = "select value from value where name = 'levelgroups'";
	$result = json_decode(CacheManager::$sql->getValue($sql), true);
	if (isset($result[$params['level']])) {
		$result = $result[$params['level']];
	} else {
		$result = end($result);
	}
	return $result;
}, 'type' => 'function', 'time' => 86400);

$cacheObjects['value_levelfightmaxlevel'] = array('mkey' => 'value_levelfightmaxlevel', 'type' => 'value', 'getter' => "select value from value where name = 'levelfightmaxlevel'", 'time' => 86400);
$cacheObjects['value_maxlevel'] = array('mkey' => 'value_maxlevel', 'type' => 'value', 'getter' => "select value from value where name = 'maxlevel'", 'time' => 86400);
$cacheObjects['value_bankfightmaxlevel'] = array('mkey' => 'value_bankfightmaxlevel', 'type' => 'value', 'getter' => "select value from value where name = 'bankfightmaxlevel'", 'time' => 86400);


$cacheObjects['rulesver'] = array('mkey' => 'rulesver', 'type' => 'value', 'getter' => "SELECT value FROM sysconfig WHERE code='rulesver'", 'time' => 86400);

$cacheObjects['players_online'] = array('mkey' => 'players_online', 'type' => 'value', 'getter' => "select count(1) from player where lastactivitytime > date_sub(now(), interval 15 minute)", 'time' => 300);

$cacheObjects['friends_online'] = array('mkey' => 'friends_online_{player_id}', 'type' => 'function',
	'getter' => function($params) {
		$sql = "select p.id as id, p.nickname, p.level, p.fraction, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan_id
from contact co
left join player p on p.id = co.player2
where co.player = " . $params['player_id'] . " and co.type = 'friend' and p.lastactivitytime >= '" . date('Y-m-d H:i:s', time() - 900) . "'
order by p.lastactivitytime desc
limit 3";
		$playersOnline = CacheManager::$sql->getRecordSet($sql);
		if (!$playersOnline) {
			return $playersOnline;
		}
		$clanIds = array();
		foreach ($playersOnline as $p) {
			if ($p['clan_id']) {
				$clanIds[$p['clan_id']] = 1;
			}
		}
		if (count($clanIds)) {
			$clanIds = CacheManager::getSet('clan_shortinfo', 'clan_id', array_keys($clanIds));
			foreach ($playersOnline as &$p) {
				$p['clan_name'] = $clanIds[$p['clan_id']]['name'];
			}
		}
		
		return $playersOnline;
		
	}, 'time' => 150);

$cacheObjects['lastnews'] = array('mkey' => 'lastnews', 'type' => 'value', 'getter' => "SELECT id FROM news ORDER BY id DESC", 'time' => 300);

$cacheObjects['pyramid_cost'] = array('mkey' => 'pyramid_cost', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'pyramid_cost'", 'time' => 3600);
$cacheObjects['pyramid_partners'] = array('mkey' => 'pyramid_partners', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'pyramid_partners'", 'time' => 3600);
$cacheObjects['pyramid_fond'] = array('mkey' => 'pyramid_fond', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'pyramid_fond'", 'time' => 3600);
$cacheObjects['pyramid_startat'] = array('mkey' => 'pyramid_startat', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'pyramid_startat'", 'time' => 3600);
$cacheObjects['pyramid_partners_rt'] = array('mkey' => 'pyramid_partners_rt', 'type' => 'value', 'getter' => "SELECT count(1) FROM pyramid_partners WHERE pyramids > 0", 'time' => 3600);
$cacheObjects['pyramid_fond_rt'] = array('mkey' => 'pyramid_fond_rt', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'pyramid_fond_rt'", 'time' => 3600);
$cacheObjects['pyramid_fond_change'] = array('mkey' => 'pyramid_fond_change', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'pyramid_fond_change'", 'time' => 3600);
$cacheObjects['pyramid_progress'] = array('mkey' => 'pyramid_progress', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'pyramid_progress'", 'time' => 3600);

$cacheObjects['rating_state'] = array('mkey' => 'rating_state', 'type' => 'value', 'getter' => "SELECT value FROM value WHERE name = 'rating_state'", 'time' => 300);

$preparedStatements['object_player_load'] = array('sql' => "SELECT SQL_NO_CACHE * FROM `player` WHERE `id` = @id LIMIT 1", 'type' => 'select_record');
$preparedStatements['object_player2_load'] = array('sql' => "SELECT * FROM `player2` WHERE `player` = @player LIMIT 1", 'type' => 'select_record');
$preparedStatements['page_tryautologin_new'] = array('sql' => "UPDATE `player` SET `lastactivitytime` = @lastactivitytime, `ip` = @ip WHERE player.id = @id", 'type' => 'update');
?>