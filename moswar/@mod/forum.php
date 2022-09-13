<?php
class Forum extends Page implements IModule
{
    public $moduleCode = 'Forum';

    private $smiles = array('angel','angry','angry2','applause','attention','box','bye','chase','child','crazy','cry','dance','dance2','dance3','dance4','devil',
        'dontknow','flag','girl','gun','gun2','gun3','gun4','gun5','gun6','gun7','gun8','hello','hello2','holiday','holiday2','kiss','kiss2','kiss3','lol',
        'love','love2','molotok','music','music2','play','police','punk','rtfm','rtfm2','skull','sleep','smoke','smoke2','sport','sumo','tema','tounge','wall',
        'why','yessir','zver','popcorn','winner','mol','strah','haha');

    private $bbCodes = array(
        '[b]' => '<b>',
        '[/b]' => '</b>',
        '[u]' => '<u>',
        '[/u]' => '</u>',
        '[i]' => '<i>',
        '[/i]' => '</i>',
        '[center]' => '<div align="center">',
        '[/center]' => '</div>',
        '[left]' => '<div align="left">',
        '[/left]' => '</div>',
        '[right]' => '<div align="right">',
        '[/right]' => '</div>',
        '[quote]' => '<div class="quote">',
        '[/quote]' => '</div>',
        '[ul]' => '<ul>',
        '[/ul]' => '</ul>',
        '[ol]' => '<ol>',
        '[/ol]' => '</ol>',
        '[li]' => '<li>',
        '[/li]' => '</li>',
    );

	public static function moveTopic($topic, $forum)
    {
		$result = array('type' => 'forum', 'action' => 'move topic');
		$result['params']['url'] = '/forum/topic/' . $topic . '/';
		if (Forum::$player->access['forum_move_topic'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		} else if (Forum::$sql->getValue("SELECT 1 FROM topic WHERE id = " . $topic) != 1) {
			$result['result'] = 0;
			$result['error'] = 'topic not found';
			$result['params']['url'] = '/forum/';
			return $result;
		} else if (Forum::$sql->getValue("SELECT 1 FROM forum WHERE id = " . $forum) != 1) {
			$result['result'] = 0;
			$result['error'] = 'forum not found';
			$result['params']['url'] = '/forum/';
			return $result;
		}
		Forum::$sql->query("UPDATE topic SET forum = " . $forum . " WHERE id = " . $topic);
		$result['result'] = 1;
		return $result;
	}

	public static function openTopic($topic)
    {
		$result = array('type' => 'forum', 'action' => 'open topic');
		$clan = Page::$sql->getValue("SELECT clan FROM forum WHERE id = (SELECT topic.forum FROM topic WHERE topic.id = " . $topic . ") LIMIT 1");
		if ($clan > 0) {
			Std::loadModule('Clan');
			$access = Clan::hasRole('forum', $clan);
			if (!$access) {
				$result['result'] = 0;
				$result['error'] = 'you have not access';
				return $result;
			}
		}
		if ($clan == 0 && Forum::$player->access['forum_openclose_topic'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		} else if (Forum::$sql->getValue("SELECT 1 FROM topic WHERE id = " . $topic) != 1) {
			$result['result'] = 0;
			$result['error'] = 'topic not found';
			return $result;
		} else {
			Forum::$sql->query("UPDATE topic SET closed = 0 WHERE id = " . $topic);
			$result['result'] = 1;
			return $result;
		}
	}

	public static function openForum($forum)
    {
		$result = array('type' => 'forum', 'action' => 'open forum');
		if (Forum::$player->access['forum_openclose_forum'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		} else if (Forum::$sql->getValue("SELECT 1 FROM forum WHERE id = " . $forum) != 1) {
			$result['result'] = 0;
			$result['error'] = 'forum not found';
			return $result;
		} else {
			Forum::$sql->query("UPDATE forum SET closed = 0 WHERE id = " . $forum);
			$result['result'] = 1;
			return $result;
		}
	}

	public static function closeForum($forum)
    {
		$result = array('type' => 'forum', 'action' => 'close forum');
		if (Forum::$player->access['forum_openclose_forum'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		} else if (Forum::$sql->getValue("SELECT 1 FROM forum WHERE id = " . $forum) != 1) {
			$result['result'] = 0;
			$result['error'] = 'forum not found';
			return $result;
		} else {
			Forum::$sql->query("UPDATE forum SET closed = 1 WHERE id = " . $forum);
			$result['result'] = 1;
			return $result;
		}
	}

	public static function closeTopic($topic)
    {
		$result = array('type' => 'forum', 'action' => 'close topic');
		$clan = Page::$sql->getValue("SELECT clan FROM forum WHERE id = (SELECT topic.forum FROM topic WHERE topic.id = " . $topic . ") LIMIT 1");
		if ($clan > 0) {
			Std::loadModule('Clan');
			$access = Clan::hasRole('forum', $clan);
			if (!$access) {
				$result['result'] = 0;
				$result['error'] = 'you have not access';
				return $result;
			}
		}
		if ($clan == 0 && Forum::$player->access['forum_openclose_topic'] != 1) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
			return $result;
		} else if (Forum::$sql->getValue("SELECT 1 FROM topic WHERE id = " . $topic) != 1) {
			$result['result'] = 0;
			$result['error'] = 'topic not found';
			return $result;
		} else {
			Forum::$sql->query("UPDATE topic SET closed = 1 WHERE id = " . $topic);
			$result['result'] = 1;
			return $result;
		}
	}

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		//$this->content['window-name'] = 'Форум';
		//$this->content['title'] = 'Форум';
		//$this->content['text'] = '<center><h3>Закрыто на реконструкцию</h3></center>';
		//$this->page->addPart('content', 'static.xsl', $this->content);
		if (self::$player) {
			self::$player->loadAccess();
		}
		
		if (isset($_POST['text'])) {
			$_POST['text'] = strip_tags($_POST['text'], '<b><i><u>');
		}
		if ($_POST['action'] == 'delete' && is_numeric($_POST['post'])) {
			$result = Forum::deletePost((int)$_POST['post'], $_POST['ajax']);
			Runtime::set('content/result', $result);
			Std::redirect('/forum/topic/' . $_POST['topic'] . '/');
		} else if ($_POST['action'] == 'delete' && is_numeric($_POST['topic'])) {
			$result = Forum::deleteTopic($_POST['topic']);
			Runtime::set('content/result', $result);
			Std::redirect('/forum/' . $_POST['forum'] . '/');

			/*$result = $this->deleteTopic($_POST['topic']);
			$this->content['action'] = 'delete';
			$this->content['params']['object'] = 'topic';
			if ($result == true) {
				$this->content['result'] = 1;
			} else {
				$this->content['result'] = 0;
			}*/
			//Std::redirect('/forum/');
		} else if ($_POST['action'] == 'open' && is_numeric($_POST['topic'])) {
			$result = Forum::openTopic($_POST['topic']);
			Runtime::set('content/result', $result);
			Std::redirect('/forum/topic/' . $_POST['topic'] . '/');
		} else if ($_POST['action'] == 'close' && is_numeric($_POST['topic'])) {
			$result = Forum::closeTopic($_POST['topic']);
			Runtime::set('content/result', $result);
			Std::redirect('/forum/topic/' . $_POST['topic'] . '/');
		} else if ($_POST['action'] == 'open' && is_numeric($_POST['forum'])) {
			$result = Forum::openForum($_POST['forum']);
			Runtime::set('content/result', $result);
			Std::redirect('/forum/' . $_POST['forum'] . '/');
		} else if ($_POST['action'] == 'close' && is_numeric($_POST['forum'])) {
			$result = Forum::closeForum($_POST['forum']);
			Runtime::set('content/result', $result);
			Std::redirect('/forum/' . $_POST['forum'] . '/');
		} else if ($_POST['action'] == 'new topic') {
			$result = Forum::saveTopic($_POST['forum'], $_POST['name'], $_POST['text'], $_POST['question'], $_POST['options']);
			Runtime::set('content/result', $result);
			Std::redirect($result['params']['url']);
		} else if ($_POST['action'] == 'new post') {
			$result = Forum::savePost($_POST['topic'], $_POST['text']);
			Runtime::set('content/result', $result);
			Std::redirect($result['params']['url']);
		} else if ($_POST['action'] == 'move topic') {
			$result = Forum::moveTopic($_POST['topic'], $_POST['forum']);
			Runtime::set('content/result', $result);
			Std::redirect($result['params']['url']);
		}
		//print_r($this->url);exit;
        switch ($this->url[0]) {
			case 'post':
				$post = self::$sql->getRecord("SELECT topic, dt FROM post where id = " . $this->url[1]);
				if ($post == false) {
					Std::redirect('/forum/');
				}
				$posts = self::$sql->getValue("SELECT COUNT(1) FROM post where topic = " . $post['topic'] . " and dt < '" . $post['dt'] . "'") + 1;
				$page = floor($posts / 20) + 1;
				Std::redirect('/forum/topic/' . $post['topic'] . '/' . $page . '/#p' . $this->url[1]);
				break;

			case "add":
				if ($_POST && self::$player->id > 0) {
					$this->saveTopic();
				} else {
					print_r($_REQUEST);
					Page::dieOnError("404");
				}
				break;

			case "topic":
				if ($this->url[1] == "add" && $_POST && self::$player->id > 0) {
					$this->savePost();
				} else if (self::$player->id > 0 && $_POST['action'] == 'vote' && is_numeric($_POST['option']) && $this->sqlGetValue("SELECT 1 FROM voteoption WHERE id = " . $_POST['option'] . " AND topic = " . $this->url[0]) != false) {
					$this->sqlQuery("INSERT INTO voteresult (`player`, `topic`, `option`) VALUES (" . self::$player->id . ", " . $this->url[1] . ", " . $_POST['option'] . ") ON DUPLICATE KEY UPDATE `option` = " . $_POST['option']);
					Runtime::set('content/result', 1);
					Runtime::set('content/action', 'vote');
					Std::redirect('/forum/topic/' . $this->url[1] . '/');
				} else if ((int)$this->url[1] > 0) {
					if (is_numeric($this->url[2]) && $this->url[2] >= 1) {
						$page = $this->url[2];
					} else {
						$page = 1;
					}
					$this->showPosts((int)$this->url[1], $page);
				} else Page::dieOnError("404");
				break;
            
			default:
				if ((int)$this->url[0] > 0 ) {
					if (is_numeric($this->url[1]) && $this->url[1] >= 1) {
						$page = $this->url[1];
					} else {
						$page = 1;
					}
					$this->showTopics((int)$this->url[0], $page);
				} else if ($_POST['action'] == 'search') {
					$this->search();
				} else {
					$this->showForums();
				}
				break;
		}
        //
        parent::onAfterProcessRequest();
    }

	public function search()
    {
		$_POST['text'] = preg_replace("/\s+/", " ", $_POST['text']);
		if (strlen($_POST['text']) < 4) {
			$result = array('type' => 'forum', 'action' => 'search', 'result' => 0, 'error' => 'bad text', 'params' => array('url' => '/forum/'));
			Runtime::set('content/result', $result);
			Std::redirect($result['params']['url']);
		} else if (self::$player == false) {
			$result = array('type' => 'forum', 'action' => 'search', 'result' => 0, 'error' => 'need auth', 'params' => array('url' => '/forum/'));
			Runtime::set('content/result', $result);
			Std::redirect($result['params']['url']);
		}
		$query = "SELECT id FROM forum";
		if (!is_a(self::$player, 'playerObject')) {
			$query .= " WHERE fraction = '' AND clan = 0 AND accesslevel = 0";
		} else if (self::$player->accesslevel < 100) {
			$query .= " WHERE ((clan = 0 OR clan = " . (self::$player->clan_status == 'recruit' ? 0 : self::$player->clan) . ")
			AND (fraction = '' OR (fraction = '" . self::$player->fraction . "' AND " . self::$player->level . " >= 3))
			AND (accesslevel = 0 OR accesslevel <= " . self::$player->accesslevel . "))";
		}
		$forums = self::$sql->getValueSet($query);
		$posts = self::$sql->getRecordSet("SELECT id, text, dt, player, topic, playerdata FROM post where text LIKE '%" . addslashes($_POST['text']) . "%' and deleted = 0 order by dt desc");
		if ($posts == false) {
			$result = array('type' => 'forum', 'action' => 'search', 'result' => 0, 'error' => 'posts not found', 'params' => array('url' => '/forum/'));
			Runtime::set('content/result', $result);
			Std::redirect($result['params']['url']);
		}
		$topicsId = array();
		if ($posts != false)
		foreach ($posts as $post) {
			$topicsId[$post['topic']] = $post['topic'];
		}
		$topics = self::$sql->getRecordSet("SELECT id, name FROM topic WHERE id in (" . implode(",", $topicsId) . ") and forum in (" . implode(",", $forums) . ")");
		$topicsId = array();
		foreach ($topics as &$topic) {
			//if (strlen($topic['name']) > 80) {
			//	$topic['name'] = mb_substr($topic['name'], 0, 80) . '...';
			//}
			$topicsId[$topic['id']] = $topic;
		}
		$newposts = array();
		foreach ($posts as $key => &$post) {
			if (!isset($topicsId[$post['topic']]) || count($newposts) > 100) {
				unset($post);
			} else {
				$post['topic'] = $topicsId[$post['topic']];
				$newposts[] = $post;
			}
		}
		$posts = $newposts;
		for ($i = 0, $length = count($posts); $i < $length; $i++) {
			$posts[$i]['player'] = json_decode($posts[$i]['playerdata'], true);
			$posts[$i]["player"]['thumb'] = Page::$data['classes'][$posts[$i]['player']['avatar']]['thumb'];
			$posts[$i]['dt'] = date("d.m.Y H:i:s", strtotime($posts[$i]['dt']));
			$posts[$i]['text'] = nl2br($posts[$i]['text']);
            // смайлики
            preg_match_all('/:([\w]+):/mis', $posts[$i]['text'], $smiles, PREG_SET_ORDER);
            if (sizeof($smiles) > 0) {
                for ($s = 0, $ss = sizeof($smiles); $s < $ss; $s++) {
                    if ($s == 3) {
                        break;
                    }
                    if (in_array($smiles[$s][1], $this->smiles)) {
                        $post[$i]['text'] = str_replace($smiles[$s][0], '<img src="/@/images/smile/' . $smiles[$s][1] . '.gif" align="absmiddle" />', $posts[$i]['text']);
                    }
                }
            }
            // bb-коды
            foreach ($this->bbCodes as $bbCode) {
                $code = str_replace(array('[',']'), '', $bbCode);
                preg_match_all('#\[' . $code . '\]#mis', $posts[$i]['text'], $matches1);
                preg_match_all('#\[\/' . $code . '\]#mis', $posts[$i]['text'], $matches2);
                if (sizeof($matches1) > sizeof($matches2)) {
                    $posts[$i]['text'] .= str_repeat('[' . $code . ']', (sizeof($matches1) - sizeof($matches2)));
                }
            }
            $posts[$i]['text'] = preg_replace('/\[quote\]\[b\](.*?)\[\/b\]:/mis', '[quote][b]$1[/b]:<br />', $posts[$i]['text']);
            $posts[$i]['text'] = str_replace(array_keys($this->bbCodes), array_values($this->bbCodes), $posts[$i]['text']);
            // цитата
            //$post[$i]['text'] = preg_replace('/\[quote=\]\[\/quote\]/mis', '<div class="quote">$2</div>', $post[$i]['text']);

			//$post[$i]['text'] = preg_replace("~(http://[a-zA-Z0-9\.\-]+\.[a-z]{2,4}[\w\/\?\-\_\+\\\=\d\.]*)~", "<noindex><a href=\"\\1\" target=\"_blank\">\\1</a></noindex>", $post[$i]['text']);
			preg_match_all("~(http://[a-zA-Z0-9\.\-]+\.[a-z]{2,4}[^\s<\r\n]*)~", $posts[$i]['text'], $matches);
			for ($j = 0; $j < count($matches[1]); $j ++) {
				$match = $matches[1][$j];
				if (strlen($match) > 60) {
					//$link = substr($match, 0, 20) . '...' . substr($match, -20);
					$link = 'http://' . substr($match, 7, max(strpos($match, '/', 7) - 7, 25)) . '<b>...</b>' . substr($match, -20);
				} else {
					$link = $match;
				}
				$posts[$i]['text'] = str_replace($match, "<noindex><a href=\"" . $match . "\" target=\"_blank\"> " . $link . "</a> </noindex>", $posts[$i]['text']);
			}
		}

		$this->content['searchtext'] = $_POST['text'];
		$this->content['topics'] = $topics;
		$this->content['posts'] = $posts;
		$this->content['window-name'] = "Поиск на форуме";
		$this->page->addPart('content', 'forum/search.xsl', $this->content);
	}

	protected function showForums()
    {
		Std::loadMetaObjectClass("forum");
		
		//$criteria = new ObjectCollectionCriteria();
		//$collection = new ObjectCollection();
		//$forums = $collection->getArrayList(forumObject::$METAOBJECT, $criteria);
		$query = "SELECT id, name, `desc` FROM forum";
		if (!is_a(self::$player, 'playerObject')) {
			$query .= " WHERE fraction = '' AND clan = 0 AND accesslevel = 0";
		} else if (self::$player->accesslevel < 100) {
			$query .= " WHERE ((clan = 0 OR clan = " . (self::$player->clan_status == 'recruit' ? 0 : self::$player->clan) . " OR clans LIKE '%[".(self::$player->clan_status == 'recruit' ? 0 : self::$player->clan)."]%')
			AND (fraction = '' OR (fraction = '" . self::$player->fraction . "' AND " . self::$player->level . " >= 3))
			AND (accesslevel = 0 OR accesslevel <= " . self::$player->accesslevel . "))";
		} else if (self::$player->accesslevel == 100) {
			$query .= " WHERE clan = 0";
		}
		$forums = $this->sqlGetRecordSet($query);
		//Std::loadMetaObjectClass("topic");
		Std::loadLib("Htmltools");
		if (is_array($forums))
		for($i = 0, $length = count($forums); $i < $length; $i++) {
			/*$result = $this->sqlGetRecordSet("SELECT
					p.*, t.name AS title, p.player, u.nickname,
					(SELECT COUNT(*) FROM post as pp WHERE pp.topic=p.topic) as amount
						FROM player AS u
						LEFT JOIN post AS p ON u.id=p.player
						LEFT JOIN topic AS t ON t.id=p.topic
						WHERE (p.id IN (select * from (SELECT MAX(id) FROM post GROUP BY post.topic ORDER BY post.topic DESC LIMIT 10) alias))
						AND t.forum={$forums[$i]["id"]}
						ORDER BY p.dt DESC
						LIMIT 5");
			*/
			$forums[$i]["dt"] = HtmlTools::formatDateTime($forums[$i]["dt"], true);
			$forums[$i]['topic'] = $this->sqlGetRecordSet("
                SELECT
                    t.id as topic, t.deleted, t.name as title, t.position, t.closed, p2.player as author_id, p2.playerdata as author_playerdata,
                    " . (self::$player->access['forum_hide_post'] == 1 ? "(SELECT COUNT(*) FROM post WHERE topic = t.id)" : "t.posts") . " as amount, p.dt, p.playerdata, p.id as post_id,
                    IFNULL((SELECT 1 FROM player_topic_read WHERE player = " . intval(self::$player->id) . " AND topic = t.id AND post = p.id), 0) as `read`
                FROM topic AS t
                    LEFT JOIN post AS p ON p.id = " . (self::$player->access['forum_hide_post'] == 1 ? "(SELECT id FROM post WHERE post.topic=t.id ORDER BY post.dt DESC LIMIT 1)" : "t.lastpost") . "
                    LEFT JOIN post AS p2 ON p2.id = t.startpost
                WHERE t.forum = " . $forums[$i]['id'] . "
                " . ((self::$player->access['forum_delete_topic'] == 1) ? "" : " and t.deleted = 0 ") . "
                GROUP BY t.id
                ORDER BY t.position DESC, p.dt DESC
                LIMIT 7");
			if (is_array($forums[$i]['topic']) && count($forums[$i]['topic'])) {
				foreach ($forums[$i]['topic'] as $key => &$topic) {
                    $styles = array();
                    if ($forums[$i]['topic'][$key]['position'] > 0) {
                        $styles[] = 'pinned';
                    }
                    if ($forums[$i]['topic'][$key]['closed']) {
                        $styles[] = 'closed';
                    }
                    $forums[$i]['topic'][$key]['class'] = implode(' ', $styles);
					$forums[$i]['topic'][$key]['dt'] = HtmlTools::FormatDateTime($forums[$i]['topic'][$key]['dt'], true, false, true);
					$forums[$i]['topic'][$key]['player'] = json_decode($forums[$i]['topic'][$key]['playerdata'], true);
					$forums[$i]['topic'][$key]['author'] = json_decode($forums[$i]['topic'][$key]['author_playerdata'], true);
					$forums[$i]['topic'][$key]['pages'] = Page::generatePages(1, ceil($forums[$i]['topic'][$key]['amount'] / 20), 5);
					/*array();
					for ($j = 1; $j <= ceil($forums[$i]['topic'][$key]['amount'] / 20); $j ++) {
						$forums[$i]['topic'][$key]['pages'][] = $j;
					}*/
				}
			}
		}

		$this->content["forum"] = $forums;
		$this->content['window-name'] = "Список форумов";
		$this->page->addPart('content', 'forum/forum.xsl', $this->content);
	}

	protected function showTopics($forum, $page = 1)
    {
		if (is_array(Runtime::get('content'))) {
			$this->content = array_merge($this->content, @Runtime::get('content'));
			Runtime::clear('content');
		}

		if ($this->isForumAvailable($forum) == false) {
			Std::redirect('/forum/');
		}

		$perPage = 20;
		$offset = ($page - 1) * $perPage;

		$topics = $this->sqlGetRecordSet("
            SELECT SQL_CALC_FOUND_ROWS
                t.id as topic, t.deleted, t.deleteddt, t.deletedbydata, t.name as title, t.position, t.closed, p2.player as author_id, p2.playerdata as author_playerdata,
                " . (self::$player->access['forum_hide_post'] == 1 ? "(SELECT COUNT(*) FROM post WHERE topic = t.id)" : "t.posts") . " as amount, p.dt, p.playerdata, p.id as post_id,
                IFNULL((SELECT 1 FROM player_topic_read WHERE player = " . (int)self::$player->id . " AND topic = t.id AND post = p.id), 0) as `read`
            FROM topic AS t
                LEFT JOIN post AS p ON p.id = " . (self::$player->access['forum_hide_post'] == 1 ? "(SELECT id FROM post WHERE post.topic=t.id ORDER BY post.dt DESC LIMIT 1)" : "t.lastpost") . "
                LEFT JOIN post as p2 ON p2.id = t.startpost
            WHERE t.forum = $forum
            " . (self::$player->access['forum_hide_topic'] == 1 ? "" : " and t.deleted = 0 ") . "
            ORDER BY t.position DESC, p.dt DESC
            LIMIT " . $offset . ", " . $perPage);
		$total = $this->sqlGetValue("SELECT found_rows()");

		if (is_array($topics)) {
			Std::loadLib("Htmltools");
			foreach ($topics as &$topic) {
                $styles = array();
                if ($topic['position'] > 0) {
                    $styles[] = 'pinned';
                }
                if ($topic['closed']) {
                    $styles[] = 'closed';
                }
				$topic['class'] = implode(' ', $styles);
                $topic["dt"] = HtmlTools::formatDateTime($topic["dt"], true);
				$topic['player'] = json_decode($topic['playerdata'], true);
				$topic['author'] = json_decode($topic['author_playerdata'], true);
				$topic['pages'] = Page::generatePages(1, ceil($topic['amount'] / 20), 5);
			}
			$this->content["topic"] = $topics;
		}

		$this->content['total'] = $total;
		$this->content['page'] = $page;
		$this->content['allpages'] = ceil($total / $perPage);
		$this->content['pages'] = Page::generatePages($page, $this->content['allpages'], 3);
        $this->content['minlevel'] = $this->sqlGetValue("SELECT minlevel FROM forum WHERE id=$forum");

		Std::loadMetaObjectClass("forum");
		$forumObject = new forumObject();
		$forumObject->load($forum);
		$this->content["forum"] = $forumObject->toArray();
		$this->content['window-name'] = $this->content["forum"]["name"] . " / Список форумов";
		if (self::$player->id > 0) {
			$this->content['player'] = self::$player->toArray();
		}
		$this->content['smiles'] = $this->smiles;
		$this->page->addPart('content', 'forum/topic.xsl', $this->content);
	}

	protected function showPosts($topic, $page = 1)
    {
        Std::loadLib('HtmlTools');
		//Std::loadMetaObjectClass("post");
		//$criteria = new ObjectCollectionCriteria();
		//$criteria->createWhere(postObject::$TOPIC, ObjectCollectionCriteria::$COMPARE_EQUAL, $topic);
		//$collection = new ObjectCollection();
		//$post = $collection->getArrayList(postObject::$METAOBJECT, $criteria);

		Std::loadMetaObjectClass("topic");
		$topicObject = new topicObject();
		$topicObject->load($topic);

		if ($this->isForumAvailable($topicObject->forum) == false) {
			Std::redirect('/forum/');
		}

		$this->content["topic"] = $topicObject->toArray();

		Std::loadMetaObjectClass("forum");
		$forumObject = new forumObject();
		$forumObject->load($this->content["topic"]["forum"]);
		$this->content["forum"] = $forumObject->toArray();
		if ($forumObject->clan > 0) {
			Std::loadModule('Clan');
			$this->content['topic']['moderatable'] = Clan::hasRole('forum', $forumObject->clan);
		}

		$perPage = 20;
		$offset = ($page - 1) * $perPage;
		
		$post = $this->sqlGetRecordSet("SELECT SQL_CALC_FOUND_ROWS p.* FROM post p WHERE p.topic = " . $topic . " " . ((self::$player->access['forum_hide_post'] == 1 || $this->content['topic']['moderatable'] == 1) ? "" : " and p.deleted = 0 ") . " ORDER BY p.dt ASC LIMIT " . $offset . ", " . $perPage);
		$total = $this->sqlGetValue("SELECT found_rows()");
		
		global $data;
		if (is_array($post))
		for ($i = 0, $length = count($post); $i < $length; $i++) {			
			$post[$i]['player'] = json_decode($post[$i]['playerdata'], true);
			$post[$i]['player']['thumb'] = Page::$data['classes'][$post[$i]['player']['avatar']]['thumb'];
			$post[$i]['dt'] = date("d.m.Y H:i:s", strtotime($post[$i]['dt']));
            if ($post[$i]['deleted']) {
                $post[$i]['deleteddt'] = HtmlTools::FormatDateTime($post[$i]['deleteddt'], true, true, true);
                $post[$i]['deletedbydata'] = json_decode($post[$i]['deletedbydata'], true);
            }
            $post[$i]['text'] = nl2br($post[$i]['text']);
            // смайлики
            preg_match_all('/:([\w]+):/mis', $post[$i]['text'], $smiles, PREG_SET_ORDER);
            if (sizeof($smiles) > 0) {
                for ($s = 0, $ss = sizeof($smiles); $s < $ss; $s++) {
                    if ($s == 3) {
                        break;
                    }
                    if (in_array($smiles[$s][1], $this->smiles)) {
                        $post[$i]['text'] = str_replace($smiles[$s][0], '<img src="/@/images/smile/' . $smiles[$s][1] . '.gif" align="absmiddle" />', $post[$i]['text']);
                    }
                }
            }
			unset($smiles);
            // bb-коды и цитаты
            foreach ($this->bbCodes as $bbCode) {
                $code = str_replace(array('[',']'), '', $bbCode);
				unset($matches1);
				unset($matches2);
                preg_match_all('#\[' . $code . '\]#mis', $post[$i]['text'], $matches1);
                preg_match_all('#\[\/' . $code . '\]#mis', $post[$i]['text'], $matches2);
                if (sizeof($matches1) > sizeof($matches2)) {
                    $post[$i]['text'] .= str_repeat('[' . $code . ']', (sizeof($matches1) - sizeof($matches2)));
                }
            }
			unset($matches1);
			unset($matches2);
            $post[$i]['text'] = preg_replace('/\[quote\]\[b\](.*?)\[\/b\]:/mis', '[quote][b]$1[/b]:<br />', $post[$i]['text']);
            $post[$i]['text'] = str_replace(array_keys($this->bbCodes), array_values($this->bbCodes), $post[$i]['text']);

			//$post[$i]['text'] = preg_replace("~(http://[a-zA-Z0-9\.\-]+\.[a-z]{2,4}[\w\/\?\-\_\+\\\=\d\.]*)~", "<noindex><a href=\"\\1\" target=\"_blank\">\\1</a></noindex>", $post[$i]['text']);
			
			unset($matches);
			preg_match_all("~(?:^|[^\"'])(http://[a-zA-Z0-9\.\-]+\.[a-z]{2,4}[^\s<\r\n]*)~", $post[$i]['text'], $matches);
			for ($j = 0; $j < count($matches[1]); $j ++) {
				$match = $matches[1][$j];
				unset($matches[1][$j]);
				if (strlen($match) > 60) {
					//$link = substr($match, 0, 20) . '...' . substr($match, -20);
					$link = 'http://' . substr($match, 7, max(strpos($match, '/', 7) - 7, 25)) . '<b>...</b>' . substr($match, -20);
				} else {
					$link = $match;
				}
				$post[$i]['text'] = str_replace($match, "<noindex><a href=\"" . $match . "\" target=\"_blank\"> " . $link . "</a> </noindex>", $post[$i]['text']);
			}
		}

		if (self::$player->id > 0) {
			$lastReadPost = $this->sqlGetValue("SELECT post FROM player_topic_read WHERE topic = " . $topic . " AND player = " . self::$player->id . " LIMIT 1");
			if (intval($lastReadPost) < $post[count($post)-1]['id']) {
				$this->sqlQuery("INSERT INTO player_topic_read (player, topic, post) VALUES (" . self::$player->id . ", " . $topic . ", " . $post[count($post)-1]['id'] . ") ON DUPLICATE KEY UPDATE post = " . $post[count($post)-1]['id']);
			}
		}

		if (is_array($post)) {
			$this->content["post"] = $post;
		}

		if (is_array(Runtime::get('content'))) {
			$this->content = array_merge($this->content, @Runtime::get('content'));
			Runtime::clear('content');
		}

		if ($topicObject->question != '') {
			if (self::$player->id == 0 || $this->sqlGetValue("SELECT 1 FROM voteresult WHERE player = " . intval(self::$player->id) . " AND topic = " . $topic) != false) {
				$this->content['vote']['voted'] = 1;
				$options = $this->sqlGetRecordSet("SELECT vo.id, vo.option, (SELECT COUNT(1) FROM voteresult WHERE voteresult.option = vo.id) as amount
												FROM voteoption vo
												WHERE topic = " . $topic . " ORDER BY vo.id ASC");
				$total = 0;
				foreach ($options as &$option) {
					$total += $option['amount'];
				}
				foreach ($options as &$option) {
					if ($option['amount'] == 0 || $total == 0) {
						$option['procent']= 0;
					} else {
						$option['procent']= round($option['amount'] / $total * 100, 2);
					}
				}
				$this->content['vote']['results'] = $options;

			} else {
				$options = $this->sqlGetRecordSet("SELECT vo.id, vo.option
												FROM voteoption vo
												WHERE topic = " . $topic . " ORDER BY vo.id ASC");
				$this->content['vote']['options'] = $options;
				$this->content['vote']['voted'] = 0;
			}
		}

		if (self::$player->id > 0) {
			$this->content['player'] = self::$player->toArray();
			if ($this->content['player']['mute_forum'] > 0) {
				$this->content['player']['mute_forum_time'] = date('d.m.Y H:i:s', $this->content['player']['mute_forum']);
			}
			if (self::$player->access['forum_move_topic'] == 1) {
				$this->content['forums'] = self::getData("forums", "SELECT id, name FROM forum ORDER BY id ASC", "recordset", 3600);
			}
		}

		$this->content['total'] = $total;
		$this->content['page'] = $page;
		$this->content['allpages'] = ceil($total / $perPage);
		$this->content['pages'] = Page::generatePages($page, $this->content['allpages'], 3);
		$this->content['smiles'] = $this->smiles;
        $this->content['minlevel'] = $this->sqlGetValue("SELECT minlevel FROM forum WHERE id=(SELECT forum FROM topic WHERE id=$topic)");

		

		$this->content['window-name'] = $this->content["topic"]["name"] . " / Список форумов";
		$this->page->addPart('content', 'forum/post.xsl', $this->content);

	}

	public static function saveTopic($forumId, $name, $text, $question, $options)
    {
		$minLevel = self::$sql->getValue("SELECT minlevel FROM forum WHERE id=$forumId");
        if (self::$player->level < $minLevel) {
            return;
        }
        $result = array('type' => 'forum', 'action' => 'new topic');
		$result['params']['url'] = "/forum/" . $forumId . '/';
		Std::loadMetaObjectClass('forum');
		$forum = new forumObject;
		if ($forum->load($forumId) == false) {
			$result['result'] = 0;
			$result['params']['url'] = '/forum/';
			$result['error'] = 'forum not found';
			return $result;
		} else if (strlen($name) < 4) {
			$result['result'] = 0;
			$result['error'] = 'bad name';
			return $result;
		} else if (strlen($text) < 4) {
			$result['result'] = 0;
			$result['error'] = 'bad text';
			return $result;
		} else if (Forum::isForumAvailable($forumId) == false) {
			$result['result'] = 0;
			$result['params']['url'] = '/forum/';
			$result['error'] = 'forum not found';
			return $result;
		} else if ($forum->closed == 1 && self::$player->accesslevel < 100) {
			Page::sendMessage(self::$player->id, 1, "Hack attempt of posting to closed forum.\r\nPlayer: " . self::$player->id . "\r\nForum: " . $forumId . "\r\nName: " . $name . "\r\nText: " . $text);
			$result['result'] = 0;
			$result['error'] = 'forum is closed';
			return $result;
		}
		Std::loadMetaObjectClass("topic");
		$topic = new topicObject();
		$topic->forum = $forumId;
		$topic->name = wordwrap(htmlspecialchars($name), 40, ' ', true);
        $topic->posts = 1;
		$topic->save();

		if (trim(strlen($question)) > 0) {
			$tempOptions = $options;
			$options = array();
			foreach ($tempOptions as $option) {
				if (strlen(trim($option)) > 0) {
					$options[] = $option;
				}
			}
			if (count($options)) {
				$topic->question = trim($question);
				Std::loadMetaObjectClass('voteoption');
				foreach ($options as $option){
					$voteoption = new voteoptionObject;
					$voteoption->topic = $topic->id;
					$voteoption->option = htmlspecialchars(trim($option));
					$voteoption->save();
				}
			}
		}

		Std::loadMetaObjectClass("post");
		$post = new postObject();
		$post->player = self::$player->id;
		//$post->text = wordwrap(htmlspecialchars($text), 40, ' ', true);
        $post->text = htmlspecialchars($text);
		$post->player = self::$player->id;
		$post->playerdata = json_encode(self::$player->exportForForum());
		$post->dt = date('Y-m-d H:i:s', time());
		$post->topic = $topic->id;
		$post->save();
		$topic->startpost = $topic->lastpost = $post->id;
		$topic->save($topic->id, array(topicObject::$STARTPOST, topicObject::$LASTPOST, topicObject::$QUESTION));

		$result['result'] = 1;
		$result['params']['forum'] = $forumId;
		$result['params']['topic'] = $topic->id;
		$result['params']['url'] = "/forum/topic/" . $topic->id . "/";
		return $result;
	}

	protected function savePost($topicId, $text)
    {
		$minLevel = $this->sqlGetValue("SELECT minlevel FROM forum WHERE id=(SELECT forum FROM topic WHERE id=$topicId)");
        if (self::$player->level < $minLevel) {
            return;
        }
        $result = array('type' => 'forum', 'action' => 'new post');
		$result['params']['url'] = "/forum/topic/" . $topicId . '/';
		Std::loadMetaObjectClass('topic');
		$topic = new topicObject;
		if ($topic->load($topicId) == false) {
			$result['result'] = 0;
			$result['params']['url'] = '/forum/';
			$result['error'] = 'topic not found';
			return $result;
		} else if (strlen($text) < 4) {
			$result['result'] = 0;
			$result['error'] = 'bad text';
			return $result;
		} else if (Forum::isForumAvailable($topic->forum) == false) {
			$result['result'] = 0;
			$result['params']['url'] = '/forum/';
			$result['error'] = 'forum not found';
			return $result;
		}  else if ($topic->closed == 1 && self::$player->accesslevel < 100) {
			$result['result'] = 0;
			$result['params']['url'] = '/forum/';
			$result['error'] = 'topic is closed';
			return $result;
		}
		Std::loadMetaObjectClass("post");
		$post = new postObject();
		//$post->text = wordwrap(htmlspecialchars($text), 40, ' ', true);
        $post->text = htmlspecialchars($text);
		$post->topic = $topicId;
		$post->player = self::$player->id;
		$post->playerdata = json_encode(self::$player->exportForForum());
		$post->dt = date('Y-m-d H:i:s', time());
		$post->save();

        self::$sql->query("UPDATE topic SET posts=posts+1, lastpost=" . $post->id . " WHERE id = " . $topicId);

		$posts = self::$sql->getValue("SELECT posts FROM topic WHERE id = " . $topicId);
		$page = ceil($posts / 20);

		$result['result'] = 1;
		$result['params']['post'] = $post->id;
		$result['params']['page'] = $page;
		$result['params']['topic'] = $topicId;
		$result['params']['url'] = "/forum/topic/" . $topicId . '/' . $page . '#p' . $post->id;
		return $result;

		//Std::redirect("/forum/topic/" . $post->topic . '/' . $page . '#p' . $post->id);
	}

	public static function deletePost($id, $ajax = false)
    {
		$result = array('type' => 'forum', 'action' => 'delete post');
		$topicId = self::$sql->getValue("SELECT topic FROM post WHERE id=" . $id);
		$clan = Page::$sql->getValue("SELECT clan FROM forum WHERE id = (SELECT topic.forum FROM topic WHERE topic.id = " . $topicId . ") LIMIT 1");
		if ($clan > 0) {
			Std::loadModule('Clan');
			$access = Clan::hasRole('forum', $clan);
		}
		if (self::$player->access['forum_hide_post'] == 1 || ($clan > 0 && $access)) {
            $lastPosts = self::$sql->getValueSet("SELECT id FROM post WHERE topic=" . $topicId . " AND deleted=0 ORDER BY dt DESC LIMIT 0,2");
            $delete = self::$sql->query("UPDATE post SET deleted=1, deletedby=" . self::$player->id . ", deleteddt='" . date("Y-m-d H:i:s", time()) . "', deletedbydata='" . addslashes(json_encode(self::$player->exportForForum())) . "' WHERE id = " . $id . " AND (SELECT COUNT(1) from topic where topic.startpost = " . $id . ") = 0 LIMIT 1");
            if ($delete == true) {
                //self::$sql->query("DELETE FROM player_topic_read WHERE post = " . $id);
                self::$sql->query("UPDATE topic SET posts=posts-1 " . ($id == $lastPosts[0] ? ", lastpost=" . $lastPosts[1] : "") . " WHERE id=" . $topicId);
				$result['result'] = 1;
			}
		}
		if (!isset($result['result'])) {
            $result['result'] = 0;
            $result['error'] = 'you have not access';
        }
		if ($ajax) {
            echo $result['result'];
            exit;
        } else {
            return $result;
        }
	}

	public static function deleteTopic($id)
    {
		$result = array('type' => 'forum', 'action' => 'delete topic');
		$clan = Page::$sql->getValue("SELECT clan FROM forum WHERE id = (SELECT topic.forum FROM topic WHERE topic.id = " . $id . ") LIMIT 1");
		if ($clan > 0) {
			Std::loadModule('Clan');
			$access = Clan::hasRole('forum', $clan);
		}
		if (Forum::$player->access['forum_hide_topic'] == 1 || Forum::$player->access['forum_delete_topic'] == 1 || ($clan > 0 && $access)) {
			if (Forum::$player->access['forum_delete_topic'] == 1) {
				//$delete = self::$sql->query("DELETE FROM post WHERE id = ". $id . " AND (SELECT COUNT(1) from topic where topic.startpost = " . $id . ") = 0 LIMIT 1");
				$rows = self::$sql->query("DELETE FROM topic WHERE id = ". $id . " LIMIT 1");
			} else {
				$delete = self::$sql->query("update topic set deleted = 1 WHERE id = ". $id . " LIMIT 1");
			}
			self::$sql->query("DELETE FROM player_topic_read WHERE topic = ". $id . " LIMIT 1");
			$rows = self::$sql->query("DELETE FROM post WHERE topic = ". $id);
			$result['result'] = 1;
			return $result;
		}
		$result['result'] = 0;
		$result['error'] = 'you have not access';
		return $result;
	}

	public static function isForumAvailable($forum)
    {
		if (self::$player->accesslevel == 100) {
			return true;
		}
		if (!is_a(self::$player, 'playerObject')) {
			$query = "SELECT 1 FROM forum where id = " . $forum . " and fraction = '' AND clan = 0 AND accesslevel = 0";
		} else {
			$query = "SELECT 1 FROM forum WHERE id = " . $forum . " AND ((clan = 0 OR clan = " . (self::$player->clan_status == 'recruit' ? 0 : self::$player->clan) . " OR clans LIKE '%[".(self::$player->clan_status == 'recruit' ? 0 : self::$player->clan)."]%')
			AND (fraction = '' OR (fraction = '" . self::$player->fraction . "' AND " . self::$player->level . " >= 3))
			AND (accesslevel = 0 OR accesslevel <= " . self::$player->accesslevel . "))";
		}
		$result = self::$sql->getValue($query);
		if ($result == false) {
			return false;
		} else {
			return true;
		}
	}
}
?>