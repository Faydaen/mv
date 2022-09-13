<?php
class playerExtention
{
    private $sql;
    
    public $extendsList = false;
    public $extendsWidget = false;
    public $extendsCard = false;
    public $extendsForm = false;
    public $extendsActions = false;
    public $eventsOnBeforeCreate = false;
    public $eventsOnAfterCreate = false;
    public $eventsOnBeforeEdit = true;
    public $eventsOnAfterEdit = true;
    public $eventsOnBeforeDelete = false;
    public $eventsOnAfterDelete = false;

	private $oldAccesslevel = null;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function extendList(&$list, $step)
    {
        if ($step == 1) // после PreGenerate
        {
            // ...
        }
        else // после Generate
        {
            // ...
        }
    }

    public function extendCard(&$card)
    {
        // ...
    }

    public function extendForm(&$form)
    {
        // ...
    }

    public function extendWidget(&$widget, $step)
    {
        if ($step == 1) // после preGenerate
        {
            // ...
        }
        else // после Generate
        {
             // ...
        }
    }

    public function processAction(&$module)
    {
        // ...
    }

    public function extendActions(&$actions)
    {
        // ...
    }

    public function onBeforeCreate(&$object)
    {
        // ...
    }

    public function onAfterCreate($id, $object)
    {
        // ...
    }

    public function onBeforeEdit($id, &$object)
    {
		$this->oldAccesslevel = Page::$sql->getValue("SELECT accesslevel FROM player WHERE id = " . $id);
    }

    public function onAfterEdit($id, $object)
    {
		if (is_array($object->access)) {
			Std::loadModule("Page");
			if (CONTENTICO) {
				if ($this->oldAccesslevel != null && $this->oldAccesslevel != $object->accesslevel) {
					if ($this->oldAccesslevel == -2 && $object->accesslevel >= 0) {
						// разморозка
						Page::$sql->query("UPDATE player SET homesalarytime = " . mktime(date("H"), 0, 0) . " WHERE id=" . $id);
					}
				}
				Std::loadLib("Cache");
				$key = Page::signed($id);
				$userInfo = array();
				$userInfo[$key] = array();
				$userInfo[$key]["accesslevel"] = $object->accesslevel;
				$userInfo[$key]["mute_chat_access"] = in_array(8, $object->access);
				$userInfo[$key]["isolate_chat_access"] = in_array(27, $object->access);
				$userInfo[$key]["wedding_access"] = in_array(35, $object->access);
				$userInfo[$key]["clan"] = $object->clan;
				$userInfo[$key]["clan_status"] = $object->clan_status;
				$userInfo[$key]["fraction"] = $object->fraction;
				$userInfo[$key]["level"] = $object->level;
				$userInfo[$key]["nickname"] = $object->nickname;

				Page::chatUpdateInfo($userInfo);

				$cachePlayer = Page::$cache->get("user_chat_" . $key);
				if ($cachePlayer) {
					$cachePlayer["accesslevel"] = $userInfo[$key]["accesslevel"];
					$cachePlayer["mute_chat_access"] = $userInfo[$key]["mute_chat_access"];
					$cachePlayer["isolate_chat_access"] = $userInfo[$key]["isolate_chat_access"];
					$cachePlayer["clan"] = $userInfo[$key]["clan"];
					$cachePlayer["clan_status"] = $userInfo[$key]["clan_status"];
					$cachePlayer["fraction"] = $userInfo[$key]["fraction"];
					$cachePlayer["level"] = $userInfo[$key]["level"];
					$cachePlayer["nickname"] = $userInfo[$key]["nickname"];
					Page::$cache->set("user_chat_" . $key, $cachePlayer);
				}
				
				//$cache->delete("snowy_player_access_" . $id);
				CacheManager::delete('player_access', array('player_id' => $id));
			} else {
				//Page::$cache->delete("snowy_player_access_" . $id);
				CacheManager::delete('player_access', array('player_id' => $id));
			}
		}
    }

    public function onBeforeDelete($id)
    {
        // ...
    }

    public function onAfterDelete($id, $deletedObject=false)
    {
        // ...
    }
}
?>