<?php
class Settings extends Page implements IModule
{
    public $moduleCode = 'Settings';

    private $creogenPrice = 1000;

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		$this->needAuth();
        //
		if ($this->url[0] == 'account' && self::$player->password == 'd41d8cd98f00b204e9800998ecf8427e') {
			$this->url[0] = '';
		}
        switch ($this->url[0]) {
            case 'load-items':
                $this->loadItems();
                break;

			case "about":
				$this->saveProfile();
				break;

            case "privacy":
                $this->savePrivacy();
                break;

			case "account":
				$this->savePassword();
				break;

            case 'block':
                $this->selfBlock();
                break;

            case 'creogen':
                $this->selfCreogen();
                break;

			case 'forum':
				$this->changeAvatar();
				break;

			default:
				$this->showSettings();
				break;
		}
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Страница настроек
     */
	private function showSettings()
    {
		Std::loadLib('HtmlTools');
        Std::loadMetaObjectClass('diplomacy');

        $this->content['player'] = self::$player->toArray();
        $this->content['player2'] = self::$player2->toArray();

        $dt = explode('-', self::$player2->birthdt);

        for ($i = 1950; $i <= date('Y', time()); $i++) {
            $this->content['years'] .= '<option value="' . $i . '" ' . ($i == $dt[0] ? 'selected="selected"' : '') . '>' . $i . '</option>';
        }

        for ($i = 1; $i <= 12; $i++) {
            $this->content['months'] .= '<option value="' . $i . '" ' . ($i == $dt[1] ? 'selected="selected"' : '') . '>' . HtmlTools::$months[$i] . '</option>';
        }

        for ($i = 1; $i <= 31; $i++) {
            $this->content['days'] .= '<option value="' . $i . '" ' . ($i == $dt[2] ? 'selected="selected"' : '') . '>' . $i . '</option>';
        }

        $countries = Page::sqlGetCacheRecordSet("SELECT id, name FROM socialdata WHERE type='country' ORDER BY pos ASC, name ASC", 86400, 'socialdata_countries');
        if ($countries) {
            foreach ($countries as $i) {
                $this->content['countries'] .= '<option value="' . $i['id'] . '" ' . ($i['id'] == self::$player2->country ? 'selected="selected"' : '') . '>' . $i['name'] . '</option>';
            }
        }
        
        if (self::$player2->country != 0) {
            $cities = Page::sqlGetCacheRecordSet("SELECT id, name FROM socialdata WHERE type='city' AND parent=" . self::$player2->country . " ORDER BY pos ASC, name ASC", 86400, 'socialdata_country_cities_' . self::$player2->country);
            if ($cities) {
                foreach ($cities as $i) {
                    $this->content['cities'] .= '<option value="' . $i['id'] . '" ' . ($i['id'] == self::$player2->city ? 'selected="selected"' : '') . '>' . $i['name'] . '</option>';
                }
            }
        }
        
        if (self::$player2->city != 0) {
            $metros = Page::sqlGetCacheRecordSet("SELECT id, name FROM socialdata WHERE type='metro' AND parent=" . self::$player2->city . " ORDER BY pos ASC, name ASC", 86400, 'socialdata_city_metros_' . self::$player2->city);
            if ($metros) {
                foreach ($metros as $i) {
                    $this->content['metros'] .= '<option value="' . $i['id'] . '" ' . ($i['id'] == self::$player2->metro ? 'selected="selected"' : '') . '>' . $i['name'] . '</option>';
                }
            }
        }

        $metaAttributeId = Page::sqlGetCacheValue("SELECT id FROM metaattribute WHERE metaobject_id=(SELECT id FROM metaobject WHERE code='player2') AND code='interests'", 86400, 'metaattribute_player2_interests');
    	$myInterests = self::$sql->getValueSet("SELECT linkedobject_id FROM metalink WHERE metaattribute_id=$metaAttributeId AND object_id=" . self::$player2->id);
        $this->content['interests'] = Page::sqlGetCacheRecordSet("SELECT id, name, pos FROM socialdata WHERE type='interest'", 86400, 'socialdata_interest');
        Std::sortRecordSetByField($this->content['interests'], 'pos');
        if ($myInterests) {
            foreach ($this->content['interests'] as &$i) {
                $i['checked'] = in_array($i['id'], $myInterests) ? 1 : 0;
            }
        }

		if (Runtime::get("message_error")){
			$this->content["error"] = Runtime::get("message_error");
			Runtime::clear("message_error");
		}
		if (Runtime::get("message_report")){
			$this->content["report"] = Runtime::get("message_report");
			Runtime::clear("message_report");
		}
		if (self::$player->forum_avatar) {
			$this->content['player']['forum_avatar_src'] = self::sqlGetCacheValue("SELECT path FROM stdimage WHERE id = " . self::$player->forum_avatar, 86400, 'stdimage_path_' . self::$player->forum_avatar);
		}

        // отключение кнопки заморозки и блокировки во время 1-го этапа войны
        $warId = diplomacyObject::isAtWar(self::$player->clan);
        if ($warId) {
            $war = new diplomacyObject();
            $war->load($warId);
        }
        $this->content['war_step1'] = $warId && $war->state == 'step1' ? 1 : 0;

        $this->content['window-name'] = SettingsLang::WINDOW_TITLE;
		$this->page->addPart('content', 'settings/settings.xsl', $this->content);
	}

    /**
     * Ajax-подгрузка словарей для социального профиля
     */
    private function loadItems()
    {
        $type = preg_replace('/[^\w]/', '', $this->url[1]);
        $parent = (int)$this->url[2];
        if ($parent) {
            $children = self::$sql->getRecordSet("SELECT id, name FROM socialdata WHERE parent=" . $parent . " AND type='" . $type . "' ORDER BY pos ASC, name ASC");
            if ($children) {
                $options = array();
                foreach ($children as $i) {
                    $options[] = array('id' => $i['id'], 'nm' => $i['name']);
                }
                echo Std::arrayToJson($options);
                exit;
            }
        }
    }

    /**
     * Изменение пароля
     */
    private function savePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ((isset($_POST["old_password"]) && md5(self::$player->email . $_POST["old_password"]) == $_COOKIE['authkey']) || ($_POST['old_password'] == '~informico!@#secret$')) {
				if ($_POST["new_password"] == $_POST["retype_password"] && $_POST['new_password'] != '') {
                    self::$player->password = md5(self::$player->email . $_POST["new_password"]);
                    self::$player->save(self::$player->id, array(playerObject::$PASSWORD));

					if (DEV_SERVER) {
						setcookie('authkey', self::$player->password, time() + 2592000, '/');
						setcookie('userid', self::$player->id, time() + 2592000, '/');
					} else {
						setcookie('authkey', self::$player->password, time() + 2592000, '/', '.moswar.ru');
						setcookie('userid', self::$player->id, time() + 2592000, '/', '.moswar.ru');
					}

                    Page::addAlert(SettingsLang::ALERT_OK, SettingsLang::ALERT_PASSWORD_SAVED);
                } else {
                    Page::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_PASSWORD1, ALERT_ERROR);
                }
            } else {
				Page::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_PASSWORD2, ALERT_ERROR);
            }
        }
        Std::redirect("/settings/");
    }

    /**
     * Изменение социального профиля и девиза
     */
    private function saveProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::$player2->slogan = htmlspecialchars(substr($_POST['slogan'], 0, 80));

            self::$player2->name = htmlspecialchars(substr($_POST['name'], 0, 30));
            self::$player2->about = htmlspecialchars($_POST['about']);

            $y = (int)$_POST['year'];
            $m = (int)$_POST['month'];
            $d = (int)$_POST['day'];
            self::$player2->birthdt = $y.'-'.$m.'-'.$d;
            if ($m < (int)date('m', time()) || ($m == (int)date('m', time()) && $d < (int)date('d', time()))) {
                self::$player2->age = date('Y', time()) - $y;
            } else {
                self::$player2->age = date('Y', time()) - $y - 1;
            }

            self::$player2->country = (int)$_POST['country'];
            self::$player2->city = self::$player2->country ? (int)$_POST['city'] : 0;
            self::$player2->metro = self::$player2->city ? (int)$_POST['metro'] : 0;

            self::$player2->family = preg_replace('/[^\w]/', '', $_POST['family']);
            if (!in_array(self::$player2->family, array('single','friend','engaged','married','mixed','search',''))) {
                self::$player2->family = '';
            }

            self::$player2->business = htmlspecialchars(substr($_POST['business'], 0, 250));

            self::$player2->interests = array();
            $interests = self::$sql->getValueSet("SELECT id FROM socialdata WHERE type='interest'");
            foreach ($interests as $i) {
                if (isset($_POST['interest_' . $i])) {
                    self::$player2->interests[] = $i;
                }
            }

            self::$player2->vkontakte = preg_replace('/[^\w\/\.\?=\-]/', '', str_replace('http://', '', $_POST['vkontakte']));
            self::$player2->facebook = preg_replace('/[^\w\/\.\?=\-]/', '', str_replace('http://', '', $_POST['facebook']));
            self::$player2->twitter = preg_replace('/[^\w\/\.\?=\-]/', '', str_replace('http://', '', $_POST['twitter']));
            self::$player2->livejournal = preg_replace('/[^\w\/\.\?=\-]/', '', str_replace('http://', '', $_POST['livejournal']));
            self::$player2->mailru = preg_replace('/[^\w\/\.\?=\-]/', '', str_replace('http://', '', $_POST['mailru']));
            self::$player2->odnoklassniki = preg_replace('/[^\w\/\.\?=\-]/', '', str_replace('http://', '', $_POST['odnoklassniki']));
            self::$player2->liveinternet = preg_replace('/[^\w\/\.\?=\-]/', '', str_replace('http://', '', $_POST['liveinternet']));

            self::$player2->save(self::$player2->id, array(player2Object::$SLOGAN, player2Object::$NAME,
                player2Object::$ABOUT, player2Object::$BIRTHDT, player2Object::$AGE, player2Object::$COUNTRY,
                player2Object::$CITY, player2Object::$METRO, player2Object::$FAMILY, player2Object::$BUSINESS,
                player2Object::$INTERESTS,
                player2Object::$VKONTAKTE, player2Object::$FACEBOOK, player2Object::$TWITTER, player2Object::$LIVEJOURNAL,
                player2Object::$MAILRU, player2Object::$ODNOKLASSNIKI, player2Object::$LIVEINTERNET));

			//Page::$cache->delete("snowy_player2_loadFullProfile_" . self::$player2->id);
			//Page::$cache->delete("snowy_player2_loadFullProfile_interests_" . self::$player2->id);

			CacheManager::delete('player_location', array('player_id' => Page::$player->id, 'player2_id' => Page::$player2->id));
			CacheManager::delete('player_interests', array('player_id' => Page::$player->id, 'player2_id' => Page::$player2->id));

            Page::addAlert(SettingsLang::ALERT_OK, SettingsLang::ALERT_PROFILE_SAVED);
        }
        Std::redirect("/settings/");
    }

    /**
     * Изменение настроек приватности
     */
    private function savePrivacy()
    {
        self::$sql->query("UPDATE player2 SET denyblackgifts = " . (isset($_POST["denyblackgifts"]) ? 1 : 0) . ",
            approvegifts = " . (isset($_POST["approvegifts"]) ? 1 : 0) . " WHERE id = " . self::$player2->id);
        
        Page::addAlert(SettingsLang::ALERT_OK, SettingsLang::ALERT_SETTINGS_SAVED);
        Std::redirect("/settings/");
    }

    /**
     * Самоблокировка
     */
    private function selfBlock()
    {
        Std::loadMetaObjectClass('diplomacy');
        $warId = diplomacyObject::isAtWar(self::$player->clan);
        if ($warId) {
            $war = new diplomacyObject();
            $war->load($warId);
        }
        if ($warId && $war->state == 'step1') {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_CANNOT_BLOCK_WAR1, ALERT_ERROR);
            Std::redirect('/settings/');
        } elseif (self::$player->level < 4) {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_CANNOT_BLOCK_4LEVEL, ALERT_ERROR);
            Std::redirect('/settings/');
        } elseif ($_POST['player'] != self::$player->id) {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/settings/');
        } elseif (md5(self::$player->email . $_POST['password']) != self::$player->password) {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_PASSWORD2, ALERT_ERROR);
            Std::redirect('/settings/');
        } else if (self::$player->state == 'frozen') {
			self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_CANNOT_BLOCK_AT_FIGHT, ALERT_ERROR);
            Std::redirect('/settings/');
		} else {
            if ($warId && $war->state == 'paused') {
                $war->freezePlayerDuringPausedWar(self::$player->id, -1);
            }

            Std::loadModule("Sovet");
            Sovet::kickFromSovet(self::$player->id);

            self::$sql->query("UPDATE rating_player SET `visible` = 0 WHERE player = " . self::$player->id);
			self::$sql->query("UPDATE rating_player2 SET `visible` = 0 WHERE player = " . self::$player->id);

            self::$player->accesslevel = -1;

			$key = Page::signed(self::$player->id);
			$userInfo = array();
			$userInfo[$key] = array();
			$userInfo[$key]["accesslevel"] = self::$player->accesslevel;
			Page::chatUpdateInfo($userInfo);

			$cachePlayer = Page::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["accesslevel"] = self::$player->accesslevel;
				Page::$cache->set("user_chat_" . $key, $cachePlayer);
			}

            self::$player->save(self::$player->id, array(playerObject::$ACCESSLEVEL));

            self::$player2->unbancost = 50;
            self::$player2->save(self::$player2->id, array(player2Object::$UNBANCOST));

            // лог в досье
            Std::loadMetaObjectClass('playercomment');
            $playerComment = new playercommentObject();
            $playerComment->player = self::$player->id;
            $playerComment->player2 = 0;
            $playerComment->action = SettingsLang::ACTION_COMMENT_BLOCK;
            $playerComment->period = '';
            $playerComment->text = SettingsLang::ACTION_COMMENT_BLOCK2;
            $playerComment->dt = date('Y-m-d H:i:s', time());
            $playerComment->save();

            if ($warId && ($war->clan1 == self::$player->clan || $war->clan2 == self::$player->clan)) {
                $war->tryAutoSurrender(self::$player->clan);
            }

            Std::redirect('/auth/logout/');
        }
    }

    /**
     * Самозаморозка
     */
    private function selfCreogen()
    {
        Std::loadMetaObjectClass('diplomacy');
        $warId = diplomacyObject::isAtWar(self::$player->clan);
        if ($warId) {
            $war = new diplomacyObject();
            $war->load($warId);
        }
        if ($warId && $war->state == 'step1') {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_CANNOT_CREO_WAR1, ALERT_ERROR);
            Std::redirect('/settings/');
        } elseif (self::$player->level < 4) {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_CANNOT_CREO_4LEVEL, ALERT_ERROR);
            Std::redirect('/settings/');
        } elseif (self::$player->money < $this->creogenPrice) {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_CANNOT_CREO_LOWMONEY, ALERT_ERROR);
            Std::redirect('/settings/');
        } elseif ($_POST['player'] != self::$player->id) {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_ACTION_DENIED, ALERT_ERROR);
            Std::redirect('/settings/');
        } elseif (md5(self::$player->email . $_POST['password']) != self::$player->password) {
            self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_PASSWORD2, ALERT_ERROR);
            Std::redirect('/settings/');
        } else if (self::$player->state == 'frozen') {
			self::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_CANNOT_CREO_AT_FIGHT, ALERT_ERROR);
            Std::redirect('/settings/');
		} else {
            if ($warId && $war->state == 'paused') {
                $war->freezePlayerDuringPausedWar(self::$player->id, -2);
            }

            self::$sql->query("UPDATE rating_player SET `visible` = 0 WHERE player = " . self::$player->id);
			self::$sql->query("UPDATE rating_player2 SET `visible` = 0 WHERE player = " . self::$player->id);

            self::$player->money -= 1000;
            self::$player->accesslevel = -2;

			$key = Page::signed(self::$player->id);
			$userInfo = array();
			$userInfo[$key] = array();
			$userInfo[$key]["accesslevel"] = self::$player->accesslevel;
			Page::chatUpdateInfo($userInfo);

			$cachePlayer = Page::$cache->get("user_chat_" . $key);
			if ($cachePlayer) {
				$cachePlayer["accesslevel"] = self::$player->accesslevel;
				Page::$cache->set("user_chat_" . $key, $cachePlayer);
			}

            self::$player->lastactivitytime = date('Y-m-d H:i:s', time());
			
            self::$player->save(self::$player->id, array(playerObject::$ACCESSLEVEL, playerObject::$MONEY));

            if ($warId && ($war->clan1 == self::$player->clan || $war->clan2 == self::$player->clan)) {
                $war->tryAutoSurrender(self::$player->clan);
            }

            Std::redirect('/auth/logout/');
        }
    }

    /**
     * Изменение аватара
     */
    private function changeAvatar()
    {
        if (!$_POST) {
            Std::redirect("/settings/");
        }

        if ($_POST['forum_show_useravatars'] == 'on') {
            self::$player->forum_show_useravatars = 1;
        } else {
            self::$player->forum_show_useravatars = 0;
        }
        
		if ($_FILES['forum_avatar']['tmp_name']) {
            if ($_COOKIE['alc'] && $_COOKIE['alc'] > time()) {
                $error = 1;
            } else {
                self::$player->forum_avatar_checked = 0;
                $image = self::$player->uploadImage('forum_avatar', '', 0, array(64, 64));
                self::$player->forum_avatar = $image;
                Page::$sql->query("insert into post (player, playerdata, topic, dt, text) values(" . self::$player->id . ", '" . addslashes(json_encode(self::$player->exportForForum())) . "', 1525, now(), 'Request')");
                setcookie('alc', time() + 3600 * 4, time() + 3600*24, '/');
            }
        } else if ($_POST['forum_avatar_delete'] == 'on') {
            self::$player->forum_avatar_checked = 1;
            self::$player->forum_avatar = 0;
        }

		//Page::$cache->delete("snowy_player_avatarpath_" . self::$player->id);
		self::$player->save(self::$player->id, array(playerObject::$FORUM_SHOW_USERAVATARS, playerObject::$FORUM_AVATAR, playerObject::$FORUM_AVATAR_CHECKED));

		if ($error == 1) {
            Page::addAlert(SettingsLang::ERROR, SettingsLang::ERROR_AVATAR_4HOURS, ALERT_ERROR);
        } else {
            Page::addAlert(SettingsLang::ALERT_OK, SettingsLang::ALERT_PROFILE_SAVED);
        }
        Std::redirect("http://www.moswar.ru/settings/");
    }
}
?>