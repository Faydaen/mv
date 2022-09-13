<?php
class Rating extends Page implements IModule
{
    public $moduleCode = 'Rating';
	public $ratings = array(
		array('name' => 'moneygrabbed', 'title' => 'Грабители'),
		array('name' => 'wins', 'title' => 'Хулиганы'),
		//array('name' => 'huntkills', 'title' => 'Huntkills'),
		//array('name' => 'huntaward', 'title' => 'Huntaward'),
		array('name' => 'referers', 'title' => 'Сэнсэи'),
		array('name' => 'clans', 'title' => 'Кланы'),
		//array('name' => 'moneylost', 'title' => 'Лузеры'),
		array('name' => 'huntkills', 'title' => 'Охотники за головами'),
		array('name' => 'huntaward', 'title' => 'Охотники за деньгами'),
		array('name' => 'fractions', 'title' => 'Противостояние')
	);

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		//$this->needAuth();
        //
		$this->content['modes'] = $this->ratings;
        if ($this->url[0] == 'fractions') {
			$this->showFractionRating();
		} else if ($this->url[0] == 'clans') {
			$this->showClanRating();
		} else {
			if (CacheManager::get('rating_state') == 'off') {
				$this->showOfflineScreen();
			} else {
				$this->showPlayerRating();
			}
		}
        //
        parent::onAfterProcessRequest();
    }

	public static function playerRating($fraction, $type, $period, $level, $amount, $offset, $playerId = 0) {
		$field = $type;
		if ($type != 'referers' && ($period == 'day' || $period == 'week' || $period == 'month' || ($type == 'moneygrabbed' && $period == 'event'))) {
			$field .= '_' . $period;
		}
		if ($type == 'huntkills' || $type == 'huntaward') {
			$table = 'rating_player2';
			} else {
			$table = 'rating_player';
		}
		
		$sql = "
                SELECT rp.*, rp." . $field . " as value FROM " . $table . " as rp WHERE rp.visible = 1
                " .
                (($fraction != '' && $playerId == 0) ? " AND rp.fraction = '" . $fraction . "'" : "")
				.
				((is_numeric($level) && $level > 0) ? " AND rp.level = " . $level : "")
                .
                (($playerId > 0) ? " AND rp.player = " . $playerId : "")
                . "
                ORDER BY rp.".$field." DESC
                LIMIT " . $offset . ", " . $amount;

		#echo '1 '.$sql.'<br><br>';###
		
		$players = Page::sqlGetCacheRecordSet($sql, 300, 'rating_' . $type . '_' . $period . '_' . $level .  '_' . $fraction . '_' . $playerId . '_' . $offset . '_' . $amount);
		$sql = " SELECT count(1) FROM " . $table . " as rp WHERE rp.visible = 1"
                .
                (($fraction != '' && $playerId == 0) ? " AND rp.fraction = '" . $fraction . "'" : "")
				.
				((is_numeric($level) && $level > 0) ? " AND rp.level = " . $level : "")
                .
                (($playerId > 0) ? " AND rp.player = " . $playerId : "") .
				"";
		#echo '2 '.$sql.'<br><br>';###
		
		$total = Page::sqlGetCacheValue($sql, 300, 'rating_' . $type . '_' . $period . '_' . $level .  '_' . $fraction . '_' . $playerId . '_' . $offset . '_' . $amount . '_total');

        if ($players) {
            $playersIds = array();
            foreach ($players as $player) {
                $playersIds[] = $player["player"];
            }

            $playersData = Page::sqlGetCacheRecordSet("SELECT p.id id, p.nickname, p2.slogan, p.level, c.name as clan_name,
                IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan
                FROM player p INNER JOIN player2 p2 ON p2.player = p.id LEFT JOIN clan as c ON p.clan = c.id
                WHERE p.id IN (" . implode(",", $playersIds) . ")", 600);


	    #echo '3 '."SELECT p.id id, p.nickname, p2.slogan, p.level, c.name as clan_name,
            #    IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan
            #    FROM player p INNER JOIN player2 p2 ON p2.player = p.id LEFT JOIN clan as c ON p.clan = c.id
            #    WHERE p.id IN (" . implode(",", $playersIds) . ")".'<br><br>';####

	    
            foreach ($players as &$p) {
                foreach ($playersData as $pd) {
                    if ($pd["id"] == $p["player"]) {
                        $p = array_merge($p, $pd);
                        break;
                    }
                }
            }
        }

		if (!is_array($players)) {
			$players = array();
		} else {
			$i = $offset + 1;
			foreach ($players as &$player) {
				$player['clan'] = array('id' => $player['clan'], 'name' => $player['clan_name'], 'ico' => $player['clan_ico']);
				if ($playerId == 0) {
					$player['position'] = $i ++;
				} else {
					$player['position'] = Page::sqlGetCacheValue("SELECT COUNT(1) as position FROM " . $table . " WHERE ((`" . $field . "` > " . $player['value'] . ") OR (`" . $field . "` = " . $player['value'] . " and player < " . $player['id'] . ")) and visible = 1 " .
                (($fraction != '') ? " AND fraction = '" . $fraction . "'" : "")
				.
				((is_numeric($level) && $level > 0) ? " AND level = " . $level : ""), 300) + 1;

				}
				//$player['about'] = @json_decode($player['about'], true);
				//$player['slogan'] = @$player['about']['slogan'];
				//unset($player['about']);
			}
		}
		$result = array('total' => $total, 'players' => $players);
		return $result;
	}

	public function showPlayerRating() {
		if (!array_search($this->url[0], array('moneygrabbed', 'wins', 'referers', 'huntkills', 'huntaward'))) {
        //if (!array_search($this->url[0], array('moneygrabbed', 'wins', 'referers'))) {
			$mode = 'moneygrabbed';
		} else {
			$mode = $this->url[0];
		}
		$i = 1;
		if ($this->url[1] == 'arrived' || $this->url[1] == 'resident') {
			$fraction = $this->url[1];
			$i ++;
		} else {
			$fraction = '';
		}
		if ($this->url[$i] == 'all' || $this->url[$i] == 'day' || $this->url[$i] == 'week' || $this->url[$i] == 'month' || ($this->url[$i] == 'event' && $mode == 'moneygrabbed')) {
			$period = $this->url[$i];
			$i ++;
		} else {
			$period = 'day';
		}
		if ($this->url[$i] == 'level' && is_numeric($this->url[$i+1])) {
			$level = $this->url[$i+1];
			$i += 2;
		} else {
			$level = 'all';
		}
		if (is_numeric($this->url[$i]) && $this->url[$i] >= 1 && $this->url[$i] <= 50) {
			$page = $this->url[$i];
		} else {
			$page = 1;
		}
		$playerId = 0;
		if (strlen($_POST['nickname']) > 0) {
			$playerId = Page::getPlayerId($_POST['nickname']);
			if ($playerId == false) {
				$this->content['search-message'] = 'player_not_found';
				$playerId = 0;
			}
		}
		if ($this->url[1] == 'player' && is_numeric($this->url[2])) {
			$playerId = $this->url[2];
			if ($this->sqlGetValue("SELECT 1 FROM `player` WHERE `id` = " . $playerId . " LIMIT 1") == false) {
				$this->content['search-message'] = 'player_not_found';
				$playerId = 0;
			}
		}
		if ($playerId == 0) {
			$result = Rating::playerRating($fraction, $mode, $period, $level, 20, ($page - 1) * 20);
			if (self::$player->id) {
				$result2 = Rating::playerRating($fraction, $mode, $period, $level, 20, 0, self::$player->id);
				if ($result2['total'] > 0 && $result2['players'][0]['position'] > $page * 20) {
					$result['players'][] = array('skip' => 1);
					$result['players'][] = $result2['players'][0];
				} else if ($result2['total'] > 0 && $result2['players'][0]['position'] < ($page - 1) * 20) {
					array_unshift($result['players'], $result2['players'][0], array('skip' => 1));
				}
			}
		} else {
			$result = Rating::playerRating('', $mode, '', '', 20, ($page - 1) * 20, $playerId);
		}
		foreach ($this->ratings as $r) {
			if ($r['name'] == $mode) {
				$ratingName = $r['title'];
			}
		}
		$this->content['total'] = $result['total'];
		$this->content['page'] = $page;
		$this->content['allpages'] = ceil($result['total'] / 20);
		$this->content['pages'] = Page::generatePages($page, min(ceil($result['total'] / 20), 50), 10);
		$this->content['players'] = $result['players'];
		$this->content['mode'] = $mode;
		$this->content['fraction'] = $fraction;
		$this->content['period'] = $period;
		$this->content['level'] = $level;
		$this->content['window-name'] = 'Рейтинг: ' . $ratingName;
		if (self::$player != null) {
            $this->content['player'] = self::$player->toArray();
        }
		$this->content['url'] = '/rating/' . $mode . '/';
		if ($fraction != '') {
			$this->content['url'] .= $fraction . '/';
		}
		if ($period != '') {
			$this->content['url'] .= $period . '/';
		}
		if ((int) $level > 0) {
			$this->content['url'] .= 'level/' . $level . '/';
		}
        $this->page->addPart ('content', 'rating/rating.xsl', $this->content);
	}

	public function showClanRating()
    {
		$i = 1;
		if ($this->url[1] == 'arrived' || $this->url[1] == 'resident') {
			$fraction = $this->url[1];
			$i ++;
		} else {
			$fraction = '';
		}
		if (is_numeric($this->url[$i]) && $this->url[$i] >= 1 && $this->url[$i] <= 50) {
			$page = $this->url[$i];
		} else {
			$page = 1;
		}

		$clanId = 0;
		if (strlen($_POST['name']) > 0) {
			$clanId = Page::$sql->getValue("SELECT c.id FROM clan c WHERE c.name = '" . Std::cleanString($_POST['name']) . "' LIMIT 1");
			if ($clanId == false) {
				$this->content['search-message'] = 'clan_not_found';
				$clanId = 0;
			}
		}
		$perPage = 20;
		if ($this->url[1] == 'for_attack' && Runtime::get('clan_hiredetective')) {
			Runtime::clear('clan_hiredetective');
			$result = Rating::clanRating('for_attack', 1000, 0);
			$perPage = 1000;
		} else if ($clanId == 0) {
			$result = Rating::clanRating($fraction, $perPage, ($page - 1) * $perPage);
		} else {
			$result = Rating::clanRating('', $perPage, ($page - 1) * $perPage, $clanId);
		}

		$this->content['clans'] = $result['clans'];
		$this->content['total'] = $result['total'];
		$this->content['page'] = $page;
		$this->content['allpages'] = ceil($result['total'] / $perPage);
		$this->content['fraction'] = $fraction;
		$this->content['pages'] = Page::generatePages($page, min(ceil($result['total'] / $perPage), 50), 3);
		$this->content['mode'] = 'clans';
		$this->content['window-name'] = 'Рейтинг: Кланы';
		$this->page->addPart ('content', 'rating/rating.xsl', $this->content);
	}

	public static function clanRating($fraction, $amount, $offset = 0, $clanId = 0)
    {
		if ($fraction == 'for_attack') {
			$fraction = Page::$player->fraction;
			$level = Page::$sql->getValue("SELECT level FROM clan WHERE id = " . Page::$player->clan);
			$sql = "SELECT SQL_CALC_FOUND_ROWS rc.*,
				c.name, c.id, c.slogan, c.level
				FROM rating_clan as rc
				LEFT JOIN clan as c ON c.id = rc.clan
				WHERE c.id NOT IN (2,3,14)
					AND rc.fraction = '" . ($fraction == 'resident' ? 'arrived' : 'resident') . "'
					AND c.level BETWEEN " . ($level - 1) . " AND " . ($level + 1) . "
					AND c.state = ''
					AND c.defencedt < now()
				ORDER BY c.level DESC, rc.exp DESC
				LIMIT " . $offset . ", " . $amount;
		} else {
			$sql = "SELECT SQL_CALC_FOUND_ROWS rc.*,
				c.name, c.id, c.slogan, c.level
				FROM rating_clan as rc
				LEFT JOIN clan as c ON c.id = rc.clan
				WHERE c.id NOT IN (2,3,14)
				" . (($clanId > 0) ? "AND rc.clan = " . $clanId : "") . "
				" .
				(($fraction != '') ? "AND rc.fraction = '" . $fraction . "'" : "")
				. "
				ORDER BY rc.exp DESC
				LIMIT " . $offset . ", " . $amount;
		}
		$clans = Page::$sql->getRecordSet($sql);
		$total = Page::$sql->getValue("SELECT found_rows()");
		if (!is_array($clans)) {
			$clans = array();
		} else {
			$i = $offset + 1;
			foreach ($clans as &$clan) {
				if ($clanId == 0) {
					$clan['position'] = $i ++;
				} else {
					$sql = "SELECT COUNT(1) as position FROM rating_clan WHERE ((`exp` > " . $clan['exp'] . ") OR (`exp` = " . $clan['exp'] . " and clan < " . $clan['clan'] . "))" .
                (($fraction != '') ? " AND fraction = '" . $fraction . "'" : "");
					$clan['position'] = self::$sql->getValue($sql) + 1;
				}
			}
		}
		$result = array('total' => $total, 'clans' => $clans);
		return $result;
	}

	public static function fractionRating()
    {
		$rating = Page::$sql->getRecordSet("SELECT * FROM rating_fraction");
		$result = array();
		$fraction = CacheManager::get('value_flag_fraction');
		foreach ($rating as &$item) {
			if ($fraction == $item['fraction']) {
				$item['flagtime'] += time() - CacheManager::get('value_flag_capturedtime');
			}
			if ($item['flagtime'] == 0) {
				$item['flagtime'] = '—';
			} else {
				$flagtime = date("H ч. i м. s с.", $item['flagtime'] - 3600 * 3);
				if (floor($item['flagtime'] / (3600 * 24)) > 0) {
					$flagtime = floor($item['flagtime'] / (3600 * 24)) . ' дн. ' . $flagtime;
				}
				$item['flagtime'] = $flagtime;
			}
			$result[$item['fraction']] = $item;
		}
		$return = array();
		$return['fractions'] = $result;
		$return['fraction'] = $fraction;
		return $return;
	}

	public function showFractionRating()
    {
		$this->content['window-name'] = 'Рейтинг: Противостояние';
		$this->content['mode'] = 'fraction';
		$this->content = array_merge($this->content, self::fractionRating());
		$this->page->addPart ('content', 'rating/rating.xsl', $this->content);
	}

	public function showOfflineScreen() {
		$this->content['window-name'] = 'Рейтинг';
        $this->page->addPart ('content', 'rating/offline.xsl', $this->content);
	}
}
?>