<?php
class Photos extends Page implements IModule {
	public $moduleCode = 'Photos';
	public $filter;
	public $perPage = 20;

	public $players4gfu = null;
	public $total4gfu = null;

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Удаление фотографии
	 *
	 * @param int $photoId
	 * @return array
	 */
	public function delete($photoId) {
		$result = array('type' => 'photos', 'action' => 'delete');
		if (Page::$sql->getValue("SELECT 1 FROM photo WHERE id = " . $photoId . " and player = " . self::$player->id) == 1) {
			$result['params']['url'] = '/photos/' . self::$player->id . '/';
			$result['result'] = 1;
			unlink('@images/photos/' . $photoId . '_orig.jpg');
			unlink('@images/photos/' . $photoId . '.jpg');
			unlink('@images/photos/' . $photoId . '_thumb.jpg');
			self::$sql->query("delete from photo where id = " . $photoId);
		} else {
			$result['params']['url'] = '/photos/';
			$result['error'] = 'you have not access';
			$result['result'] = 0;
		}

		Runtime::set('photos/resetcache', 1);

		return $result;
	}

	/**
	 * Модерирование фотографии
	 *
	 * @param int $photoId
	 * @param string $status
	 * @return array
	 */
	public function changeStatus($photoId, $status) {
		$result = array('type' => 'photos', 'action' => $status);
		$result['params']['url'] = '/photos/';
		if (!self::$player->access['photos']) {
			$result['result'] = 0;
			$result['error'] = 'you have not access';
		} else {
			$player = Page::$sql->getValue("SELECT player FROM photo WHERE id = " . $photoId);
			if (!$player) {
				$result['result'] = 0;
				$result['error'] = 'photo not found';
				return $result;
			}
			$result['params']['url'] = '/photos/' . $player . '/#' . $photoId;
			$result['result'] = 1;
			Std::loadModule('PlayerAdmin');
			if ($status == 'accept') {
				self::$sql->query("update photo set status = 'accepted', dt_accepted = '" . date('Y-m-d H:i:s') . "' where id = " . $photoId);
				Page::sendLog($player, 'admin_action', array('player' => self::$player->exportForLogs(), 'action' => '+photo', 'photo' => $photoId));
				PlayerAdmin::adminAddPlayerComment(self::$sql->getValue("SELECT player FROM photo WHERE id=" . $photoId), PhotosLang::ACCEPT_PHOTO, '', '');
				Page::$cache->delete('photos_by_date');
			} else {
				self::$sql->query("update photo set status = 'canceled', in_profile = 0 where id = " . $photoId);
				Page::sendLog($player, 'admin_action', array('player' => self::$player->exportForLogs(), 'action' => '-photo', 'photo' => $photoId, 'text' => $_POST['reason']));
				PlayerAdmin::adminAddPlayerComment(self::$sql->getValue("SELECT player FROM photo WHERE id=" . $photoId), PhotosLang::REJECT_PHOTO, '', $_POST['reason']);
			}
		}

		Runtime::set('photos/resetcache', 1);

		return $result;
	}

	/**
	 * Закрепление фотогарфии в профиле
	 *
	 * @param int $photoId
	 * @return array
	 */
	public function setInProfile($photoId) {
		$result = array('type' => 'photos', 'action' => 'set in profile');
		if (Page::$sql->getValue("SELECT 1 FROM photo WHERE id = " . $photoId . " and player = " . self::$player->id) == 1) {
			$result['params']['url'] = '/photos/' . self::$player->id . '/' . $photoId . '/';
			$result['result'] = 1;
			self::$sql->query("update photo set in_profile = 0 where player = " . self::$player->id);
			self::$sql->query("update photo set in_profile = 1 where id = " . $photoId);

			//Page::$cache->delete("snowy_player_profile_photo_" . self::$player->id);
			CacheManager::delete('player_profile_photo', array('player_id' => Page::$player->id));
		} else {
			$result['params']['url'] = '/photos/';
			$result['error'] = 'you have not access';
			$result['result'] = 0;
		}
		return $result;
	}

	/**
	 * Покупка рамки для фотографии
	 *
	 * @return array
	 */
	public function buyFrame() {
		$priceHoney = 2;
		$result = array('type' => 'photos', 'action' => 'buy frame');
		if (!self::$player) {
			$result['params']['url'] = '/photos/';
			$result['error'] = 'you have not access';
			$result['result'] = 0;
			return $result;
		}
		$result['params']['url'] = '/photos/upload';
		if (self::$player->honey < $priceHoney) {
			$result['error'] = 'no money';
			$result['result'] = 0;
			return $result;
		}
		$reason = 'buy frame $' . $priceHoney;
		$takeResult = self::doBillingCommand(self::$player->id, $priceHoney, 'takemoney', $reason, $other);
		if ($takeResult[0] != 'OK') {
			$result['error'] = 'no money';
			$result['result'] = 0;
			return $result;
		}
		$result['result'] = 1;
		self::$player->photos += 1;
		self::$player->save(self::$player->id, array(playerObject::$PHOTOS));

		Runtime::set('photos/resetcache', 1);

		return $result;
	}

	public static function getFreeMaxSlots() {
		if (Page::$player->level < 3) {
			return 10;
		} else {
			return 20;
		}
	}

	/**
	 * Оценка фотографии
	 *
	 * @param int $photo
	 * @param int $value
	 * @return array
	 */
	public function rate($photo, $value) {
		$id = $photo;
		$result = array('type' => 'photos', 'action' => 'rate');
		$tmp = self::$sql->getRecord("select p.player, p.for_contest, p.status, pc.status state from photo p left join photo_contest pc on pc.id = p.for_contest where p.id = " . $photo);
		if ($tmp == false) {
			$result['params']['url'] = '/photos/';
			$result['result'] = 0;
			$result['error'] = 'no photo';
			return $result;
		}

		$player = $tmp['player'];
		$contest = $tmp['for_contest'];
		$status = $tmp['status'];
		if ($_POST['type'] == 'line') {
			$result['params']['url'] = '/photos/rate/next/';
		} else if ($contest > 0) {
			$result['params']['url'] = '/photos/contest/' . $contest . '/#' . $photo;
		} else {
			$result['params']['url'] = '/photos/' . $player . '/#' . $photo;
		}
		$this->needAuth(false);
		if (!self::$player) {
			$result['result'] = 0;
			$result['error'] = 'you have no access';
			return $result;
		}
		if (self::$player->level < 2) {
			$result['result'] = 0;
			$result['error'] = 'low level';
			return $result;
		}
		if ($player == self::$player->id && !DEV_SERVER) {
			$result['result'] = 0;
			$result['error'] = 'you cannot rate yourself';
			return $result;
		}
		if ($contest > 0 && $tmp['state'] != 'started') {
			$result['result'] = 0;
			$result['error'] = 'photo is not available for voting';
			return $result;
		}
		if ($status != 'accepted') {
			$result['result'] = 0;
			$result['error'] = 'photo is not accepted';
			return $result;
		}
		if ((($value >= 1 && $value <= 5) || $value == 10) != 1) {
			$result['result'] = 0;
			$result['error'] = 'bad value';
			return $result;
		}
		$money = $honey = 0;
		if ($value <= 5) {
			$money = 50;
		} else if ($value == 10) {
			$honey = 1;
		}
		if ($value == 10 && $contest == 0) {
		} else if (self::$sql->getValue("select 1 from photo_vote where photo = " . $id . " and player = " . self::$player->id . " and dt = '" . date('Y-m-d') . "' limit 1") == 1) {
			$result['result'] = 0;
			$result['error'] = 'already rated today';
			return $result;
		}

		if (self::$player->money < $money || self::$player->honey < $honey) {
			$result['result'] = 0;
			$result['error'] = 'no money';
			return $result;
		}

		$sendMoney = 0;
		$sendOre = 0;
		if ($money > 0) {
			$sendMoney = 25;
			self::$player->money -= $money;
			self::$player->save(self::$player->id, array(playerObject::$MONEY));
			$mbckp = array('m' => self::$player->money);
		}

		if ($honey > 0) {
			$reason = 'rate photo [' . $id . ' / ' . $value . '] $' . $honey;
			$takeResult = self::doBillingCommand(self::$player->id, $honey, 'takemoney', $reason, $other);
			if ($takeResult[0] != 'OK') {
				$result['result'] = 0;
				$result['error'] = 'no money';
				return $result;
			}
			$sendOre = 1;
			self::$player->honey -= $honey;
			$mbckp = array('h' => self::$player->honey);
		}
		if ($value == 10) {
			Page::sendNotify($player, 'photo_rate');
		}
		self::$sql->query("insert into photo_vote (photo, player, dt, value) values(" . $id . ", " . self::$player->id . ", '" . date("Y-m-d") . "', " . $value . ");");
		self::$sql->query("update photo set amount = amount + 1, sum = sum + " . $value . ", rating = sum/amount where id = " . $id);
		self::$sql->query("update player set money = money + " . $sendMoney . ", ore = ore + " . $sendOre . " where id = " . $player);

		$playerObject = new playerObject();
		$playerObject->load($player);
		Page::sendLog(self::$player->id, 'photo_rated_by_you', array('player' => $playerObject->exportForDB(true), 'photo' => $id, 'value' => $value, 'money' => $money, 'honey' => $honey, 'mbckp' => $mbckp), 0);
		Page::sendLog($player, 'photo_rated', array('player' => self::$player->exportForDB(true), 'photo' => $id, 'value' => $value, 'ore' => $sendOre, 'money' => $sendMoney), 0);

		$result['result'] = 1;

		Runtime::set('photos/resetcache', 1);

		return $result;
	}

	private function createCountries() {
		$this->content["countries"] = "<option>" . PhotosLang::ANY_W . "</option>";
		$countries = Page::sqlGetCacheRecordSet("SELECT id, name FROM socialdata WHERE type='country' ORDER BY pos ASC, name ASC", 190000);
		if ($countries) {
			foreach ($countries as $i) {
				$this->content['countries'] .= '<option value="' . $i['id'] . '" ' . ($i['id'] == $this->filter['country'] ? 'selected="selected"' : '') . '>' . $i['name'] . '</option>';
			}
		}
	}

	private function createCities() {
		$this->content['cities'] = "<option>" . PhotosLang::ANY_M . "</option>";
		if (!empty($this->filter['country'])) {
			$cities = Page::sqlGetCacheRecordSet("SELECT id, name FROM socialdata WHERE type='city' AND parent=" . $this->filter['country'] . " ORDER BY pos ASC, name ASC", 180000);
			if ($cities) {
				foreach ($cities as $i) {
					$this->content['cities'] .= '<option value="' . $i['id'] . '" ' . ($i['id'] == $this->filter['city'] ? 'selected="selected"' : '') . '>' . $i['name'] . '</option>';
				}
			}
		}
	}

	private function createMetros() {
		$this->content['metros'] = "<option>" . PhotosLang::ANY_O . "</option>";
		if (!empty($this->filter['city'])) {
			$metros = Page::sqlGetCacheRecordSet("SELECT id, name FROM socialdata WHERE type='metro' AND parent=" . $this->filter['city'] . " ORDER BY pos ASC, name ASC", 200000);
			if ($metros) {
				foreach ($metros as $i) {
					$this->content['metros'] .= '<option value="' . $i['id'] . '" ' . ($i['id'] == $this->filter['metro'] ? 'selected="selected"' : '') . '>' . $i['name'] . '</option>';
				}
			}
		}
	}

	private function createFamilies() {
		$this->content['families'] = "<option>" . PhotosLang::ANY_O . "</option>";
		if ($this->filter["sex"] == "female") {
			$this->content['families'] .= '<option value="single" ' . ("single" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::ITSELF_W . '</option>';
			$this->content['families'] .= '<option value="friend" ' . ("friend" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::HAS_BOYFRIEND . '</option>';
			$this->content['families'] .= '<option value="engaged" ' . ("engaged" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::ENGAGED_W . '</option>';
			$this->content['families'] .= '<option value="married" ' . ("married" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::MARRIED_W . '</option>';
			$this->content['families'] .= '<option value="mixed" ' . ("mixed" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::DONT_KNOW_W . '</option>';
			$this->content['families'] .= '<option value="search" ' . ("search" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::ACTIVE_SEARCH . '</option>';
		} else {
			$this->content['families'] .= '<option value="single" ' . ("single" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::SINGLE . '</option>';
			$this->content['families'] .= '<option value="friend" ' . ("friend" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::HAS_GIRLFRIEND . '</option>';
			$this->content['families'] .= '<option value="engaged" ' . ("engaged" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::ENGAGED_M . '</option>';
			$this->content['families'] .= '<option value="married" ' . ("married" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::MARRIED_M . '</option>';
			$this->content['families'] .= '<option value="mixed" ' . ("mixed" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::DONT_KNOW_M . '</option>';
			$this->content['families'] .= '<option value="search" ' . ("search" == $this->filter['family'] ? 'selected="selected"' : '') . '>' . PhotosLang::ACTIVE_SEARCH . '</option>';
		}
	}

	public function processRequest() {
		parent::onBeforeProcessRequest();
		//

		if ($this->url[0] == "load-items") {
			switch ($this->url[1]) {
				case "cities" :
					$this->filter["country"] = intval($this->url[2]);
					$this->createCities();
					echo $this->content["cities"];
					die();
					break;
				case "metros" :
					$this->filter["city"] = intval($this->url[2]);
					$this->createMetros();
					echo $this->content["metros"];
					die();
					break;
				case "families" :
					$this->filter["sex"] = $this->url[2];
					$this->createFamilies();
					echo $this->content["families"];
					die();
					break;
			}
		}

		if (self::$player) {
			self::$player->loadAccess();
		}
		$this->filter = $_SESSION["photos_filter"];

		if (@$_POST['action'] == 'top') {
			$result = $this->top();
		} else if (@$_POST['action'] == 'upload') {
			$result = $this->uploadPhotos();
		} else if (@$_POST['action'] == 'search') {
			$result = $this->search();
		} else if (@$_POST['action'] == 'delete') {
			$result = $this->delete((int) $_POST['photo']);
		} else if (@$_POST['action'] == 'set in profile') {
			$result = $this->setInProfile((int) $_POST['photo']);
		} else if (@$_POST['action'] == 'accept' || @$_POST['action'] == 'cancel') {
			$result = $this->changeStatus((int) $_POST['photo'], $_POST['action']);
		} else if ($_POST['action'] == 'buy_frame') {
			$result = $this->buyFrame();
		} else if ($_POST['action'] == 'rate') {
			$result = $this->rate((int) $_POST['photo'], (int) $_POST['value']);
		}

		$this->createCountries();
		$this->createCities();
		$this->createMetros();
		$this->createFamilies();

		if (isset($result)) {
			Runtime::set('content/result', $result);
			if (isset($result['params']['url'])) {
				Std::redirect($result['params']['url']);
			}
		}

		if (self::$player && $this->url[0] == 'upload') {
			$this->showUpload();
		} else if ($this->url[0] == 'contest') {
			$this->showContest((int) $this->url[1], (int) $this->url[2]);
		} else if ($this->url[0] == 'rate') {
			$this->showRate();
		} else if ($this->url[0] == '' && count($_POST) == 0) {
			$filter = array('sex' => '', 'clan' => '', 'name' => '', 'sort' => 'rating', 'status' => array('accepted'));
			$this->filter = $filter;
			$this->showIndex();
		} else {

			if ($this->url[0] == 'topphotos') {
				$filter = array('sex' => '', 'clan' => '', 'name' => '', 'sort' => 'rating', 'status' => array('accepted'));
			} else if ($this->url[0] == 'newphotos') {
				$filter = array('sex' => '', 'clan' => '', 'name' => '', 'sort' => 'date', 'status' => array('accepted'));
			} else if ($this->url[0] == 'toppeople') {
				$filter = array('sex' => '', 'clan' => '', 'name' => '', 'sort' => 'people', 'status' => array('accepted'));
			} else if ($this->url[0] == 'popular') {
				$filter = array('sex' => '', 'clan' => '', 'name' => '', 'sort' => 'popular', 'status' => array('accepted'));
			} else if (is_numeric($this->url[0])) {
				$filter = array('sex' => '', 'clan' => '', 'name' => '', 'sort' => 'date', 'status' => array('accepted'));
			} else {
				$filter = Runtime::get('photo/search_filter');
				if (!$filter) {
					$filter = array('sex' => '', 'clan' => '', 'name' => '', 'sort' => 'date', 'status' => array('accepted'));
				}
			}
			if ($this->url[0] == 'moderate' && self::$player->access['photos']) $filter['status'] = array("new");
			$this->filter = $filter;

			if ($this->url[0] == 'page' && is_numeric($this->url[1]) && $this->url[1] > 0) {
				$page = (int)$this->url[1];
			} else if($this->url[0] == "moderate" && $this->url[1] == 'page' && is_numeric($this->url[2]) && $this->url[2] > 0) {
				$page = (int)$this->url[2];
			} else {
				$page = 1;
			}
			$player = 0;
			if (@$_POST['action'] != 'search' && $this->url[0] != 'page' && is_numeric($this->url[0])) {
				$player = (int) $this->url[0];
				$this->filter['status'] = array('accepted');

				if (self::$player->id == $player || self::$player->access['photos']) {
					$this->filter['status'] = array('new', 'accepted', 'canceled');
				}
				if (is_numeric($this->url[1])) {
					$photo = (int) $this->url[1];
				} else {
					$photo = 'random';
				}
			}/* else {
				$player = $this->getFilterUsers(1, ($page - 1) * $this->perPage);
				if ($player['players'][0]) {
					$player = $player['players'][0]['id'];
				} else {
					$player = 0;
				}
			}*/

			if ($player && is_numeric($this->url[1])) {
				$photo = (int) $this->url[1];
			} else {
				$photo = 'random';
			}

			/*if (!$status) {
				if ($player == self::$player->id) {
					$status = array('new', 'accepted', 'canceled');
				} else {
					$status = array('accepted');
				}
			} else {
				Runtime::clear('photo/search_status');
			}

			if (self::$player->id == $player) {
				$status = array('new', 'accepted', 'canceled');
			} else {
				if (self::$player && self::$player->access['photos']) {
					$status = array('new', 'accepted', 'canceled');
				} else {
					$status = array('accepted');
				}
			}*/
			$status = $this->filter['status'];
			if ($player == 0) {
				Runtime::set('photo/search_filter', $this->filter);
			}
			$this->content['filter'] = $this->filter;

			$this->showPhotos($player, $photo, $status, $page);
		}

		//
		parent::onAfterProcessRequest();
	}

	/**
	 * Фотку в топ
	 */
	private function top() {
		$this->needAuth(false);
		Std::loadMetaObjectClass('photo');
		Std::loadMetaObjectClass('photo_top');
		Std::loadLib('ImageTools');
		$photo = new photoObject();
		$id = intval($_POST["id"]);
		if($photo->load($id)) {
			$takeResult = self::doBillingCommand(self::$player->id, 1, 'takemoney', "photo top", $other);
			if ($takeResult[0] == 'OK') {
				$pathOrig = '@images/photos/' . $id . '_thumb.jpg';
				$pathMini = '@images/photos/' . $id . '_mini.jpg';
				if (!file_exists($pathMini)) {
					ImageTools::resize($pathOrig, $pathMini, 55, 55, true);
				}
				$photoTop = new photo_topObject();
				$photoTop->photo = $id;
				$photoTop->dt = date('Y-m-d H:i:s');
				$photoTop->save();
				self::$cache->delete("photos-top");

				$playerObject = new playerObject();
				$playerObject->load($photo->player);
				self::$player->honey -= 1;
				$mbckp = array('h' => self::$player->honey);
				Page::sendLog(self::$player->id, 'photo_top_by_you', array('player' => $playerObject->exportForDB(true), 'photo' => $id, 'honey' => 1, 'mbckp' => $mbckp), 0);

			} else {
				Page::addAlert(PhotosLang::$errorNoHoney, PhotosLang::$errorNoHoneyText);
			}
			Std::redirect("/photos/" . $photo->player . "/" . $photo->id . "/");
		}
	}

	/**
	 * Загрузка фотографий
	 *
	 * @return array
	 */
	public function uploadPhotos() {
		//$result = array('params' => array('url' => '/photos/' . self::$player->id . '/', 'total' => 0, 'successes' => 0), 'type' => 'photos', 'action' => 'upload', 'result' => 0, 'error' => 'you have no access');
		//return $result;

		$successes = 0;
		$total = 0;
		$smallsize = 0;
		$notphotos = 0;
		$errors = array();
		Std::loadMetaObjectClass('photo');
		Std::loadLib('ImageTools');
		if (@$_POST['contest'] > 0) {
			$ok = (Page::$sql->getValue("SELECT id FROM photo WHERE player = " . self::$player->id . " and for_contest = " . (int) $_POST['contest'] . " limit 1") == false);
			$ok2 = (Page::$sql->getValue("SELECT 1 FFOM photo_contest WHERE id = " . (int) $_POST['contest']) == false);
			if ($ok == false || $ok2 == false) {
				$result = array('params' => array('url' => '/photos/' . self::$player->id . '/', 'total' => 1, 'successes' => 0), 'type' => 'photos', 'action' => 'upload', 'result' => 0, 'error' => 'you have no access');
				return $result;
			}
		}
		$available = Photos::getFreeMaxSlots() - self::$sql->getValue("select count(1) from photo where player = " . self::$player->id) + self::$player->photos;
        foreach ($_FILES as $key => $file) {
			if (isset($file['tmp_name']) && @$file['error'] == 0 && $available > 0) {
				$ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
				if ($ext != 'jpg' && $ext != 'png' && $ext != 'bmp') {
					$errors['not_image'] = 1;
					$notphotos ++;
					continue;
				}
				$total ++;
				$photo = new photoObject();
				$photo->dt = date('Y-m-d H:i:s');
				$photo->player = self::$player->id;
				$photo->status = 'new';
				$photo->for_contest = (int) $_POST['contest'];
				$photo->save();
				$id = $photo->id;
				$pathOrig = '@images/photos/' . $id . '_orig.' . $ext;
				$path = '@images/photos/' . $id . '.jpg';
				$pathThumb = '@images/photos/' . $id . '_thumb.jpg';
				//$pathClean = '@images/photos/' . $id . '_clean.jpg';

				$r = move_uploaded_file($_FILES[$key]['tmp_name'], $pathOrig);
				if ($r == false) {
					$photo->delete($id);
					continue;
				}
				$size = ImageTools::getSize($pathOrig);
				if ($size[0] * $size[1] < 48000) {
					$smallsize ++;
					unlink($pathOrig);
					$photo->delete($id);
					continue;
				}
				ImageTools::resize($pathOrig, $path, 400, 400);
				//ImageTools::resize($pathOrig, $pathClean, 400, 400);
				ImageTools::resize($path, $pathThumb, 99, 99);
				//ImageTools::applyWatermark($pathOrig, "@/images/logo-photos.png", "BOTTOM_RIGHT", 0, 0);
				ImageTools::applyWatermark($path, "@/images/logo-photos.png", "BOTTOM_RIGHT", 0, 0);
				$successes ++;
				$available --;
			}
		}
		Std::loadLib('HtmlTools');
		$words['total'] = HtmlTools::russianNumeral($total, PhotosLang::PHOTO_1, PhotosLang::PHOTO_2, PhotosLang::PHOTO_5);
		$words['successes'] = HtmlTools::russianNumeral($successes, PhotosLang::PHOTO_1, PhotosLang::PHOTO_2, PhotosLang::PHOTO_5);
		$words['notphotos'] = HtmlTools::russianNumeral($notphotos, PhotosLang::FILE_1, PhotosLang::FILE_2, PhotosLang::FILE_5);
		$words['smallsize'] = HtmlTools::russianNumeral($smallsize, PhotosLang::FILE_1, PhotosLang::FILE_2, PhotosLang::FILE_5);
		$result = array('params' => array('url' => '/photos/' . self::$player->id . '/', 'total' => $total, 'successes' => $successes, 'smallsize' => $smallsize, 'notphotos' => $notphotos, 'words' => $words), 'type' => 'photos', 'action' => 'upload', 'result' => 1);
		if (@$_POST['contest'] > 0) {
			$result['params']['url'] = '/photos/contest/' . (int) $_POST['contest'] . '/' . $photo->id . '/';
		}
		return $result;
	}

	/**
	 * Поиск (установка параметров фильтров) фотографий
	 */
	public function search() {
		$filter = array();
		$filter['name'] = $_POST['name'];
		if ($_POST['sex'] == 'male' || $_POST['sex'] == 'female') {
			$filter['sex'] = $_POST['sex'];
		} else {
			$filter['sex'] = '';
		}
		if ($_POST['fraction'] == 'resident' || $_POST['fraction'] == 'arrived') {
			$filter['fraction'] = $_POST['fraction'];
		} else {
			$filter['fraction'] = '';
		}

		$filter["city"] = intval($_POST["city"]);
		$filter["country"] = intval($_POST["country"]);
		$filter["metro"] = intval($_POST["metro"]);

		$filter["age_from"] = intval($_POST["age_from"]);
		$filter["age_to"] = intval($_POST["age_to"]);
		if ($filter["age_from"] == 0) $filter["age_from"] = "";
		if ($filter["age_to"] == 0) $filter["age_to"] = "";

		if (array_search($_POST['family'], array("single", "friend", "engaged", "married", "mixed", "search")) !== false) {
			$filter['family'] = $_POST['family'];
		} else {
			$filter['family'] = '';
		}

		$filter['clan'] = $_POST['clan'];

		$filter['level'] = intval($_POST['level']);
		if ($_POST['sort'] == 'abc') {
			$filter['sort'] = 'abc';
		} else if ($_POST['sort'] == 'rating') {
			$filter['sort'] = 'rating';
		} else if ($_POST['sort'] == 'popular') {
			$filter['sort'] = 'popular';
		} else {
			$filter['sort'] = 'date';
		}

		if ($_POST['status']) {
			if (self::$player->id > 0) {
				if (self::$player->access['photos']) {
					$filter['status'][] = $_POST['status'];
				} else {
					$filter['status'][] = 'accepted';
				}
			} else {
				$filter['status'][] = 'accepted';
			}
		} else {
			$filter['status'][] = 'accepted';
		}

		Runtime::set('photo/search_filter', $filter);
		$this->filter = $filter;
		$_SESSION["photos_filter"] = $filter;
	}

	/**
	 * Генерация списка пользователей в колонке слева
	 *
	 * @param int $amount
	 * @param int $offset
	 * @param bool $index
	 * @return array
	 */
	public function getFilterUsers($amount, $offset, $index = false) {
		if ($this->filter['sort'] == 'abc') {
			$orderBy = 'p.nickname ASC';
		} else if ($this->filter['sort'] == 'date') {
			if ($this->filter['status'][0] != 'accepted') {
				$orderBy = 'ph.dt_accepted DESC';
			} else {
				$orderBy = 'ph.dt DESC';
			}
		} else if ($this->filter['sort'] == 'rating') {
			$orderBy = 'MAX(ph.rating) DESC';
			//$orderBy = 'ph.rating DESC';
		} else if ($this->filter['sort'] == 'people') {
			$orderBy = 'SUM(ph.sum) DESC';
		} else if ($this->filter['sort'] == 'popular') {
			$orderBy = 'ph.amount DESC';
		}
		$status = $this->filter['status'];
		if (count($status) == 3) {
			$status = array('accepted');
		}
		$sql = "SELECT ph.*, ROUND(ph.rating, 2) as rating, p.id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph left join player p on p.id = ph.player left join clan c on c.id = p.clan where ph.status in ('" . implode("', '", $status) . "')
		" . (($this->filter['clan'] != '') ? " and (c.name like '%" . mysql_escape_string($this->filter['clan']) . "%' and p.clan_status != 'recruit')" : "") . "
		" . (($this->filter['name'] != '') ? " and p.nickname like '%" . $this->filter['name'] . "%'" : "") . "
		" . (($status[0] == 'accepted' && count($status) == 1) ? " and ph.for_contest = 0" : "") . "
		" . (($this->filter['sort'] == 'rating' && !$index) ? " and ph.amount > 5" : "") . "
		group by ph.player order by " . $orderBy . "
		limit " . $offset . ", " . $amount;
		$sql2 = "SELECT count(distinct player) FROM photo ph left join player p on p.id = ph.player left join clan c on c.id = p.clan where ph.status in ('" . implode("', '", $status) . "')
		" . (($this->filter['clan'] != '') ? " and (c.name like '%" . mysql_escape_string($this->filter['clan']) . "%' and p.clan_status != 'recruit')" : "") . "
		" . (($this->filter['name'] != '') ? " and p.nickname like '%" . $this->filter['name'] . "%'" : "") . "
		" . (($status[0] == 'accepted' && count($status) == 1) ? " and ph.for_contest = 0" : "") . "
		" . (($this->filter['sort'] == 'rating' && !$index) ? " and ph.amount > 5" : "");
//echo '<!--'.$sql.'-->';
		//$playersTemp = Page::$sql->getRecordSet($sql);
		//$total = Page::$sql->getValue("SELECT found_rows()");
		//$playersTemp = Page::sqlGetCacheRecordSet($sql, 37);
		//$total = Page::sqlGetCacheValue($sql2, 37);
		// SELECT count(distinct player) FROM photo ph left join player p on p.id = ph.player left join clan c on c.id = p.clan where ph.status in ('accepted') and ph.for_contest = 0 LIMIT 0,1
		if (in_array('new', $status) || in_array('canceled', $status) || Runtime::get('photos/resetcache') == 1) {
			if (Runtime::get('photos/resetcache') == 1) {
				Runtime::clear('photos/resetcache');
			}
			$playersTemp = Page::$sql->getRecordSet($sql);
			$total = Page::sqlGetValue($sql2);
			//$total = Page::sqlGetValue($sql2);
			//echo '<!--'.$total.'-->';
		} else {
			//$total = 0;
			//$playersTemp = Page::sqlGetCacheRecordSetAndCalcFoundRows($sql, 37, $total);
			$playersTemp = Page::sqlGetCacheRecordSet($sql, 37);
			if ($status[0] == 'accepted' && count($status) == 1 && $this->filter['clan'] == '' && $this->filter['sort'] == 'date' && $this->filter['name'] == '') {
				$total = Page::sqlGetCacheValue($sql2, 3600, 'photos_by_date');
			} else {
				$total = Page::sqlGetCacheValue($sql2, 37);
			}
		}

		//$playersTemp = $this->players4gfu;
		//$total = $this->total4gfu;

		$players = array();
		if ($playersTemp) {
			$id = array();
			foreach ($playersTemp as &$p) {
				if (in_array($p['player'], $id)) {
					continue;
				}
				$id[] = $p['player'];

				$p['clan'] = array('id' => $p['clan'], 'name' => $p['clan_name']);
				$players[] = $p;
			}
		}
		$result = array('players' => $players, 'total' => $total);
		return $result;
	}

	/**
	 * Генерация центральной части фотогалереи
	 *
	 * @param int $player
	 * @param int $photo
	 * @param string $status
	 * @param int $page
	 */
	public function showPhotos($player, $photo, $status = array('accepted', 'new', 'canceled'), $page = 1) {
		$where = "";
		$sWhere = "";
		if ($player > 0) {
			$this->content['mode'] = 'player';
			$where = "ph.player = " . $player . " and ";
			$sWhere = "player = " . $player . " and ";
			$perPage = 1000;
		} else {
			$perPage = 15;
		}
		if ($status[0] == 'accepted' && count($status) == 1 && $player == 0) {
			$where .= " ph.for_contest = 0 and ";
			$sWhere .= " for_contest = 0 and ";
		}

		$sSortField = "";
		$offset = ($page - 1) * $perPage;
		if ($this->filter['sort'] == 'abc') {
			$orderBy = 'p.nickname ASC';
			$sOrderBy = 'nickname_sort ASC';
		} else if ($this->filter['sort'] == 'date') {
			if ($status[0] == 'accepted' && count($status) == 1) {
				$orderBy = 'ph.dt_accepted DESC';
				$sOrderBy = 'dt_accepted DESC';
			} else {
				$orderBy = 'ph.dt DESC';
				$sOrderBy = 'dt DESC';
			}
		} else if ($this->filter['sort'] == 'rating') {
			//$orderBy = 'ph.rating DESC';
			$orderBy = 'MAX(ph.rating) DESC';
			$sOrderBy = 'max_rating DESC';
			$sSortField = ", MAX(rating) as max_rating";
		} else if ($this->filter['sort'] == 'people') {
			//$groupBy = "group by ph.player";
			$orderBy = 'SUM(ph.sum) DESC';
			$sOrderBy = 'sum_sum DESC';
			$sSortField = ", SUM(summ) as sum_sum";
		} else if ($this->filter['sort'] == 'popular') {
			$orderBy = 'ph.amount DESC';
			$sOrderBy = 'amount DESC';
		}
		if ($player == 0 && $this->filter["status"] != array("new")) {
			$groupBy = "group by ph.player";
			$sGroupBy = "group by player";
		}
		if ($this->filter["status"] == array("new")) {
			$this->content['mode'] = 'moderate';
			$perPage = 50;
			$offset = ($page - 1) * $perPage;
		}

		//" . ((!empty($this->filter['level'])) ? " and p.level = " . $this->filter['level'] . "" : "") . "
		//" . (($this->filter['fraction'] != '') ? " and p.fraction = '" . $this->filter['fraction'] . "'" : "") . "
		//" . (($this->filter['sex'] != '') ? " and p.sex = '" . $this->filter['sex'] . "'" : "") . "

		// SPHINX
		// ROUND(ph.rating, 2) as rating,
		// photo.player_id
		// player.fraction
		// player.clan
		// p.level

		// SQL
		// player.nickname
		// clan.name

		Std::loadLib("sphinxapi");
		$sphinx = new SphinxClient();
		Page::initSphinx();

		$match = "";
		if ($this->filter['clan'] != '' && $player == 0) {
			$match .= "@clan_name " . $sphinx->EscapeString($this->filter['clan']) . " ";
		}
		if ($this->filter['name'] != '' && $player == 0) {
			$match .= "@nickname " . $sphinx->EscapeString($this->filter['name']);
		}

		$crcStatus = array_map("crc32", $status);
		$time = time();
		$sSql = "SELECT *" . $sSortField . " FROM photos WHERE " . $sWhere . " stat in (" . implode(", ", $crcStatus) . ")
		" . ((!empty($this->filter['age_from'])) ? " and birthdt != 0 and birthdt <= " . ($time - ($this->filter['age_from'] * (86400 * 365))) . "" : "") . "
		" . ((!empty($this->filter['age_to'])) ? " and birthdt != 0 and birthdt >= " . ($time - ($this->filter['age_to'] * (86400 * 365))) . "" : "") . "
		" . ((!empty($this->filter['city'])) ? " and city = " . $this->filter['city'] . "" : "") . "
		" . ((!empty($this->filter['country'])) ? " and country = " . $this->filter['country'] . "" : "") . "
		" . ((!empty($this->filter['metro'])) ? " and metro = " . $this->filter['metro'] . "" : "") . "
		" . ((!empty($this->filter['family'])) ? " and family = " . crc32($this->filter['family']) . "" : "") . "
		" . ((!empty($this->filter['level'])) ? " and level = " . $this->filter['level'] . "" : "") . "
		" . ((!empty($this->filter['fraction'])) ? " and fraction = " . (($this->filter['fraction'] == "arrived") ? 1 : 0) . "" : "") . "
		" . (($this->filter['sex'] != '' && $player == 0) ? " and sex = " . (($this->filter['sex'] == "male") ? 1 : 0) . "" : "") . "
		" . (($this->filter['clan'] != '' && $player == 0) ? " and clan != 0" : "") . "
		" . (($match != "") ? " and match('" . $match . "')" : "") . "
		" . (($this->filter['sort'] == 'rating' && $player == 0) ? " and amount > 5" : "") . "
		" . $sGroupBy . "
		order by " . $sOrderBy . "
		limit " . $offset . ", " . $perPage;

		$sSql2 = "SHOW META";

		$sql = "SELECT ph.*, ROUND(ph.rating, 2) as rating, p.id player_id, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph inner join player p on p.id = ph.player inner join player2 p2 on p2.player = p.id left join clan c on c.id = p.clan where " . $where . " ph.status in ('" . implode("', '", $status) . "')
		" . ((!empty($this->filter['age_from'])) ? " and p2.birthdt <> '0000-00-00' and p2.birthdt <= '" . (intval(date('Y', time())) - $this->filter['age_from']) . "-" . date('m-d', time()) . "'" : "") . "
		" . ((!empty($this->filter['age_to'])) ? " and p2.birthdt <> '0000-00-00' and p2.birthdt >= '" . (intval(date('Y', time())) - $this->filter['age_to']) . "-" . date('m-d', time()) . "'" : "") . "
		" . ((!empty($this->filter['city'])) ? " and p2.city = " . $this->filter['city'] . "" : "") . "
		" . ((!empty($this->filter['country'])) ? " and p2.country = " . $this->filter['country'] . "" : "") . "
		" . ((!empty($this->filter['metro'])) ? " and p2.metro = " . $this->filter['metro'] . "" : "") . "
		" . ((!empty($this->filter['family'])) ? " and p2.family = '" .  mysql_escape_string($this->filter['family']) . "'" : "") . "
		" . ((!empty($this->filter['level'])) ? " and p.level = " . $this->filter['level'] . "" : "") . "
		" . ((!empty($this->filter['fraction'])) ? " and p.fraction = '" .  mysql_escape_string($this->filter['fraction']) . "'" : "") . "
		" . (($this->filter['sex'] != '' && $player == 0) ? " and p.sex = '" . $this->filter['sex'] . "'" : "") . "
		" . (($this->filter['clan'] != '' && $player == 0) ? " and (c.name like '%" . mysql_escape_string($this->filter['clan']) . "%' and p.clan_status != 'recruit')" : "") . "
		" . (($this->filter['name'] != '' && $player == 0) ? " and p.nickname like '%" . $this->filter['name'] . "%'" : "") . "
		" . (($this->filter['sort'] == 'rating' && $player == 0) ? " and ph.amount > 5" : "") . "
		" . $groupBy . "
		order by " . $orderBy . "
		limit " . $offset . ", " . $perPage;

		//echo $sql;
		//select count(distinct player) from photo where for_contest=0 and status in ('accepted')
		//if ($player == 0) {
		//	$sql2 = "select count(distinct player) from photo where for_contest=0 and status in ('accepted')";
		//}
		$sql2 = "SELECT count(distinct ph.player) FROM photo ph inner join player p on p.id = ph.player inner join player2 p2 on p2.player = p.id left join clan c on c.id = p.clan where " . $where . " ph.status in ('" . implode("', '", $status) . "')
		" . ((!empty($this->filter['age_from'])) ? " and p2.birthdt <> '0000-00-00' and p2.birthdt <= '" . (intval(date('Y', time())) - $this->filter['age_from']) . "-" . date('m-d', time()) . "'" : "") . "
		" . ((!empty($this->filter['age_to'])) ? " and p2.birthdt <> '0000-00-00' and p2.birthdt >= '" . (intval(date('Y', time())) - $this->filter['age_to']) . "-" . date('m-d', time()) . "'" : "") . "
		" . ((!empty($this->filter['city'])) ? " and p2.city = " . $this->filter['city'] . "" : "") . "
		" . ((!empty($this->filter['country'])) ? " and p2.country = " . $this->filter['country'] . "" : "") . "
		" . ((!empty($this->filter['metro'])) ? " and p2.metro = " . $this->filter['metro'] . "" : "") . "
		" . ((!empty($this->filter['family'])) ? " and p2.family = '" .  mysql_escape_string($this->filter['family']) . "'" : "") . "
		" . ((!empty($this->filter['level'])) ? " and p.level = " . $this->filter['level'] . "" : "") . "
		" . ((!empty($this->filter['fraction'])) ? " and p.fraction = '" .  mysql_escape_string($this->filter['fraction']) . "'" : "") . "
		" . (($this->filter['sex'] != '' && $player == 0) ? " and p.sex = '" . $this->filter['sex'] . "'" : "") . "
		" . (($this->filter['clan'] != '' && $player == 0) ? " and (c.name like '%" . mysql_escape_string($this->filter['clan']) . "%' and p.clan_status != 'recruit')" : "") . "
		" . (($this->filter['name'] != '' && $player == 0) ? " and p.nickname like '%" . $this->filter['name'] . "%'" : "") . "
		" . (($this->filter['sort'] == 'rating' && $player == 0) ? " and ph.amount > 5" : "") . "
		";// . $groupBy;
//echo '<!--'.$sql.'-->';
		//$photos = Page::$sql->getRecordSet($sql);
		//$total = Page::$sql->getValue("SELECT found_rows()");
		//$photos = Page::sqlGetCacheRecordSet($sql, 33);
		////$photos = Page::sqlGetCacheRecordSet($sql, 33);
		////$total = Page::sqlGetCacheValue($sql2, 33);
		if (in_array('new', $status) || in_array('canceled', $status) || Runtime::get('photos/resetcache') == 1) {
			if (Runtime::get('photos/resetcache') == 1) {
				Runtime::clear('photos/resetcache');
			}

			$photos = Page::$sql->getRecordSet($sql);
			$total = Page::$sql->getValue($sql2);

			/*
			$photos = Page::$sphinx->getRecordSet($sSql);
			$total = Page::$sphinx->getRecord($sSql2);
			$total = $total["total_found"];
			*/
		} else {
			//$total = 0;
			//$photos = Page::sqlGetCacheRecordSetAndCalcFoundRows($sql, 33, $total);
			/*
			$photos = Page::sqlGetCacheRecordSet($sql, 33);
			$total = Page::sqlGetCacheValue($sql2, 33);
			*/
			//if ($player == 0) {
			//echo '<!--'.$total.'-->';
			//echo '<!--'.$sql2.'-->';
			//} else {
			//	$total = Page::sqlGetCacheValue($sql2);
			//}
			
			$photos = Page::$sphinx->getRecordSet($sSql);
			$total = Page::$sphinx->getRecordSet($sSql2);
			$total = $total[1]["Value"];
			
		}
		$photoId = $photo;
		$photo = array();

		if (!(in_array('new', $status) || in_array('canceled', $status) || Runtime::get('photos/resetcache') == 1)) {
			// Собираем нужные данные которых нет в индексе сфинкса
			$players = array();
			if (is_array($photos)) {
				foreach ($photos as &$ph) {
					$players[] = $ph["player"];
				}
			}
			$playerIndex = $this->photoPlayerIndex($players);
			//
		}

		if ($photos)
			for ($i = 0; $i < count($photos); $i ++) {
				$p = &$photos[$i];

				if (!(in_array('new', $status) || in_array('canceled', $status) || Runtime::get('photos/resetcache') == 1)) {
					$this->photoAfterSphinx($p, $playerIndex);
				}

				$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru') . '/@images/photos/' . $p['id'] . '.jpg';
				$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru') . '/@images/photos/' . $p['id'] . '_thumb.jpg';

				$photoIds[] = $p['id'];
				if ($p['id'] == $photoId) {
					$photo = $p;
				}
			}

		if (count($photo) == 0) {
			$photoId = 'random';
		}

		if ($photoId == 'random') {
			$photoId = rand(0, count($photoIds)-1);
			$photo = $photos[$photoId];
		}

		$prevPhotoId = $nextPhotoId = $currentPhoto = 0;
		$s = 0;
		if ($photoIds)
			foreach ($photoIds as $key => $id) {
				if ($id == $photoId) {
					$currentPhoto = $key;
					if ($photoIds[$key-1]) {
						$prevPhotoId = $photoIds[$key-1];
					}
					if ($photoIds[$key+1]) {
						$nextPhotoId = $photoIds[$key+1];
					}
				}
			}
		$this->content['next_photo'] = $nextPhotoId;
		$this->content['prev_photo'] = $prevPhotoId;
		$this->content['current_photo'] = $currentPhoto;

		if ($player > 0 && $this->content['profile'] != 'my') {
			$this->content['show_player_info'] = 1;
			if (self::$player == null || $player != self::$player->id) {
				$playerId = $player;
				$player = new playerObject();
				$result = $player->load($playerId);
				if ($result) {
					$player->loadClan();
					//$photo['player'] = $player->toArray();
					//$photo['player']['about'] = json_decode($photo['player']['about'], true);
				}
			} else if ($player > 0) {
				$player = self::$player;
				//$player->about = json_decode($player->about, true);
				$player->loadClan();
				//$photo['player'] = $player->toArray();
				//$photo['player']['about'] = json_decode($photo['player']['about'], true);
			}
			$photo['player'] = $player->toArray();
			$photo['player']['about'] = json_decode($photo['player']['about'], true);
			Std::loadMetaObjectClass('player2');
			$player2 = new player2Object();
			$player2->load($player->id);
			$player2->loadFullProfile($player->sex);
			$photo['player2'] = $player2->toArray();
			if (self::$player != null && self::$player->forum_show_useravatars == 1 && $player->forum_avatar > 0 && $player->forum_avatar_checked == 1) {
				$photo['player']['custom_avatar'] = Page::sqlGetCacheValue("SELECT path FROM stdimage WHERE id = " . $player->forum_avatar, 86400, 'stdimage_path_' . $player->forum_avatar);
				$photo['player']['custom_avatar'] = Page::sqlGetCacheValue("SELECT path FROM stdimage WHERE id = " . $player->forum_avatar, 86400, 'stdimage_path_' . $player->forum_avatar);
			}
		} else {
			$photo['player'] = $player;
		}

		if ($photo) {
			$this->content['photo'] = $photo;
		}

		$this->content['photos'] = $photos;
		$this->content['photos_json'] = str_replace("'", "\\'", json_encode($photos));

		$clans = Page::sqlGetCacheRecordSet("SELECT id, name FROM clan", 600);
		$this->content['clans'] = $clans;

		//$perPage = 20;
		//$players = $this->getFilterUsers($perPage, ($page - 1) * $perPage);
		//$this->content['players'] = $players['players'];
		$this->content['page'] = $page;
		//$this->content['pages'] = Page::generatePages($page, ceil($players['total'] / $perPage), 2);
		//$this->content['total'] = $players['total'];
		$this->content['pages2'] = Page::generatePages($page, ceil($total / $perPage), 8);
		$this->content['total2'] = $total;

		if (self::$player != null) {
			$this->content['player'] = self::$player->toArray();
			$this->content['player']['photos_to_upload'] = 10 - self::$sql->getValue("select count(1) from photo where player = " . self::$player->id);
			$this->content['player']['allow_actions'] = "true";
		} else {
			$this->content['player']['photos_to_upload'] = 0;
		}

		$this->content['todaynew'] = self::getData('photos/todaynew', "SELECT count(*) FROM photo WHERE status='accepted' AND dt>DATE_SUB(now(), INTERVAL 1 DAY)", 'value', 600);

		$this->createTopPhotos();

		$this->content['window-name'] = PhotosLang::$windowTitle;
		$this->page->addPart('content', 'photo/photo.xsl', $this->content);
	}

	private function photoPlayerIndex($players) {
		$players = array_unique($players);
		$players = Page::$sql->getRecordSet("SELECT player.id, player.nickname, clan.name AS clan_name FROM player LEFT JOIN clan on clan.id = player.clan AND player.clan_status != 'recruit' WHERE player.id IN(" . implode(",", $players) . ")");
		$playerIndex = array();
		if (is_array($players)) {
			foreach($players as $pl) {
				$playerIndex[$pl["id"]] = $pl;
			}
		}
		return $playerIndex;
	}

	private function photoAfterSphinx(&$p, &$playerIndex) {
		unset($p["city"]);
		unset($p["country"]);
		unset($p["birthdt"]);
		unset($p["metro"]);
		unset($p["family"]);
		unset($p["@count"]);
		unset($p["@groupby"]);
		unset($p["weight"]);
		unset($p["sex"]);
		unset($p["stat"]);
		unset($p["nickname_sort"]);
		$p["sum"] = $p["summ"];
		unset($p["summ"]);
		$p["dt"] = date("Y-m-d H:i:s", $p["dt"]);
		$p["dt_accepted"] = date("Y-m-d H:i:s", $p["dt_accepted"]);
		$p["rating"] = round($p["rating"], 2);
		$p["player_id"] = $p["player"];
		$p["nickname"] = $playerIndex[$p["player"]]["nickname"];
		$p["clan_name"] = $playerIndex[$p["player"]]["clan_name"];
		$p["fraction"] = ($p["fraction"] == 1) ? "arrived" : "resident";
	}

	/**
	 * Страница загрузки фотографий
	 */
	public function showUpload() {
		$this->content['player'] = self::$player->toArray();
		$this->content['max_free_slots'] = Photos::getFreeMaxSlots();
		$this->content['total'] = $this->content['max_free_slots'] + self::$player->photos;
		$this->content['uploaded'] = self::$sql->getValue("select count(1) from photo where player = " . self::$player->id);
		$this->content["available"] = $this->content['total'] - $this->content['uploaded'];
		if ($this->content["available"] > 5) $this->content["available"] = 5;
		if ($this->content["available"]) {
			$this->content["slots"] = range(1, $this->content["available"]);
		} else {
			$this->content["slots"] = array();
		}

		$this->content['window-name'] = PhotosLang::$windowTitle;
		$this->page->addPart('content', 'photo/upload.xsl', $this->content);
	}

	private function createTopPhotos() {
		$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player INNER JOIN photo_top pt ON ph.id = pt.photo LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' ORDER BY pt.dt DESC LIMIT 10";
		$top = Page::sqlGetCacheRecordSet($sql, 3600, "photos-top"); // 05 sec

		if ($top) {
			foreach ($top as &$p) {
				$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
				$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_mini.jpg';
			}
		}
		$this->content['top'] = $top;

	}

	/**
	 * Главная страница
	 */
	public function showIndex() {
		/*
		$filter_topphotos = "all";
		$filter_toppeople = "all";
		$filter_topphotos_cond = "";
		$filter_toppepole_cond = "";

		switch($_COOKIE["filter_topphotos"]) {
			case "male" : $filter_topphotos = $_COOKIE["filter_topphotos"]; $filter_topphotos_cond = " and p.sex = 'male'"; break;
			case "female" : $filter_topphotos = $_COOKIE["filter_topphotos"]; $filter_topphotos_cond = " and p.sex = 'female'"; break;
		}

		switch($_COOKIE["filter_toppeople"]) {
			case "male" : $filter_toppeople = $_COOKIE["filter_toppeople"]; $filter_toppeople_cond = " and p.sex = 'male'"; break;
			case "female" : $filter_toppeople = $_COOKIE["filter_toppeople"]; $filter_toppeople_cond = " and p.sex = 'female'"; break;
		}

		*/

		Page::initSphinx();
		//$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' and ph.for_contest = 0 ORDER BY ph.dt_accepted DESC LIMIT 12";
		//$newphotos = Page::sqlGetCacheRecordSet($sql, 583); // 43 sec
		$sql = "SELECT * FROM photos WHERE stat = " . crc32('accepted') . " and for_contest = 0 ORDER BY dt_accepted DESC LIMIT 12";
		$newphotos = Page::$sphinx->getRecordSet($sql);

		//$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' and ph.for_contest = 0 and ph.amount > 5 ORDER BY ph.rating DESC LIMIT 5";
		//$topphotos = Page::sqlGetCacheRecordSet($sql, 75); // 05 sec
		$sql = "SELECT * FROM photos WHERE stat = " . crc32('accepted') . " and for_contest = 0 and amount > 5 ORDER BY rating DESC LIMIT 5";
		$topphotos = Page::$sphinx->getRecordSet($sql);

		//$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' and ph.for_contest = 0 and ph.amount > 5 and p.sex = 'male' ORDER BY ph.rating DESC LIMIT 5";
		//$topphotosMale = Page::sqlGetCacheRecordSet($sql, 85); // 05 sec
		$sql = "SELECT * FROM photos WHERE stat = " . crc32('accepted') . " and for_contest = 0 and amount > 5 and sex = 1 ORDER BY rating DESC LIMIT 5";
		$topphotosMale = Page::$sphinx->getRecordSet($sql);

		//$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' and ph.for_contest = 0 and ph.amount > 5 and p.sex = 'female' ORDER BY ph.rating DESC LIMIT 5";
		//$topphotosFemale = Page::sqlGetCacheRecordSet($sql, 65); // 05 sec
		$sql = "SELECT * FROM photos WHERE stat = " . crc32('accepted') . " and for_contest = 0 and amount > 5 and sex = 0 ORDER BY rating DESC LIMIT 5";
		$topphotosFemale = Page::$sphinx->getRecordSet($sql);

		//$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' and ph.for_contest = 0 GROUP BY ph.player ORDER BY SUM(ph.sum) DESC LIMIT 5";
		//$toppeople = Page::sqlGetCacheRecordSet($sql, 361); // 21 sec
		$sql = "SELECT *, SUM(summ) as sum_sum FROM photos WHERE stat = " . crc32('accepted') . " and for_contest = 0 GROUP BY player ORDER BY sum_sum DESC LIMIT 5";
		$toppeople = Page::$sphinx->getRecordSet($sql);

		//$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' and ph.for_contest = 0 and p.sex = 'male' GROUP BY ph.player ORDER BY SUM(ph.sum) DESC LIMIT 5";
		//$toppeopleMale = Page::sqlGetCacheRecordSet($sql, 301); // 21 sec
		$sql = "SELECT *, SUM(summ) as sum_sum FROM photos WHERE stat = " . crc32('accepted') . " and for_contest = 0 and sex = 1 GROUP BY player ORDER BY sum_sum DESC LIMIT 5";
		$toppeopleMale = Page::$sphinx->getRecordSet($sql);

		//$sql = "SELECT ph.*, p.id player_id, p.status, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph INNER JOIN player p ON p.id = ph.player LEFT JOIN clan c ON c.id = p.clan WHERE ph.status = 'accepted' and ph.for_contest = 0 and p.sex = 'female' GROUP BY ph.player ORDER BY SUM(ph.sum) DESC LIMIT 5";
		//$toppeopleFemale = Page::sqlGetCacheRecordSet($sql, 261); // 21 sec
		$sql = "SELECT *, SUM(summ) as sum_sum FROM photos WHERE stat = " . crc32('accepted') . " and for_contest = 0 and sex = 0 GROUP BY player ORDER BY sum_sum DESC LIMIT 5";
		$toppeopleFemale = Page::$sphinx->getRecordSet($sql);

		$players = array();
		foreach ($toppeople as &$ph) $players[] = $ph["player"];
		foreach ($toppeopleFemale as &$ph) $players[] = $ph["player"];
		foreach ($toppeopleMale as &$ph) $players[] = $ph["player"];
		foreach ($topphotos as &$ph) $players[] = $ph["player"];
		foreach ($topphotosMale as &$ph) $players[] = $ph["player"];
		foreach ($topphotosFemale as &$ph) $players[] = $ph["player"];
		foreach ($newphotos as &$ph) $players[] = $ph["player"];
		$playerIndex = $this->photoPlayerIndex($players);

		foreach ($topphotos as &$p) {
			$this->photoAfterSphinx($p, $playerIndex);
			$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
			$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_thumb.jpg';
		}
		foreach ($topphotosMale as &$p) {
			$this->photoAfterSphinx($p, $playerIndex);
			$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
			$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_thumb.jpg';
		}
		foreach ($topphotosFemale as &$p) {
			$this->photoAfterSphinx($p, $playerIndex);
			$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
			$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_thumb.jpg';
		}
		foreach ($toppeople as &$p) {
			$this->photoAfterSphinx($p, $playerIndex);
			$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
			$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_thumb.jpg';
		}
		foreach ($toppeopleMale as &$p) {
			$this->photoAfterSphinx($p, $playerIndex);
			$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
			$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_thumb.jpg';
		}
		foreach ($toppeopleFemale as &$p) {
			$this->photoAfterSphinx($p, $playerIndex);
			$p['src'] = '/@images/photos/' . $p['id'] . '.jpg';
			$p['thumb_src'] = '/@images/photos/' . $p['id'] . '_thumb.jpg';
		}
		foreach ($newphotos as &$p) {
			$this->photoAfterSphinx($p, $playerIndex);
			$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
			$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_thumb.jpg';
		}

		$this->players4gfu = array_merge(array_merge($topphotos, $toppeople), $newphotos);

		$this->createTopPhotos();
		$this->content['toppeople'] = $toppeople;
		$this->content['topphotos'] = $topphotos;
		$this->content['topphotos_male'] = $topphotosMale;
		$this->content['topphotos_female'] = $topphotosFemale;
		$this->content['toppeople_male'] = $toppeopleMale;
		$this->content['toppeople_female'] = $toppeopleFemale;
		$this->content['newphotos'] = $newphotos;

		//$this->content["filter_topphotos"] = $filter_topphotos;
		//$this->content["filter_toppeople"] = $filter_toppeople;

		/*
		$perPage = 20;
		$page = 1;
		$players = $this->getFilterUsers($perPage, ($page - 1) * $perPage, true);
		$this->content['players'] = $players['players'];
		$this->content['page'] = $page;
		$this->content['pages'] = Page::generatePages($page, ceil($players['total'] / $perPage), 2);
		$this->content['total'] = $players['total'];
		*/

		$this->content['mode'] = 'index';
		if (self::$player) {
			$this->content['player'] = self::$player->toArray();
		}

		$this->content['todaynew'] = self::getData('photos/todaynew', "SELECT count(*) FROM photo WHERE status='accepted' AND dt>DATE_SUB(now(), INTERVAL 1 DAY)", 'value', 600);

		$this->content['window-name'] = PhotosLang::$windowTitle;
		$this->page->addPart('content', 'photo/photo.xsl', $this->content);
	}

	/**
	 * Генерация центральной части страницы конкурса
	 *
	 * @param int $contestId
	 * @param int $photoId
	 */
	public function showContest($contestId, $photoId) {
		$sql = "SELECT c.* FROM photo_contest c ORDER BY dt_finished DESC";
		$contests = Page::$sql->getRecordSet($sql);

		if (is_array($contests) && count($contests)) {
			Std::loadLib('HtmlTools');
			foreach ($contests as &$c) {
				$c['dt_started'] = HtmlTools::FormatDateTime($c['dt_started'], false);
				$c['dt_finished'] = HtmlTools::FormatDateTime($c['dt_finished'], false);
			}
		}

		if ($contestId) {
			$found = false;
			foreach ($contests as $co) {
				if ($co['id'] == $contestId) {
					$found = true;
					$contest = $co;
					break;
				}
			}
			if ($found == false) {
				$contestId = 0;
			}
		}

		if ($contestId) {
			if ($contest['status'] == 'accepting') {
				$sort = 'ph.dt_accepted ASC';
			} else if ($contest['status'] == 'finished') {
				$sort = 'ph.sum DESC';
			} else {
				$sort = 'RAND()';
			}
			//ph.dt_accepted ASC
			$sql = "SELECT ph.*, ROUND(ph.rating, 2) as rating, p.id player_id, p.nickname, p.fraction, p.level, IF(p.clan > 0 AND p.clan_status != 'recruit', p.clan, 0) clan, c.name as clan_name FROM photo ph inner join player p on p.id = ph.player left join clan c on c.id = p.clan WHERE ph.for_contest = " . $contest['id'] . " ORDER BY " . $sort;
			$photos = Page::$sql->getRecordSet($sql);
			$newphotos = array();
			if (is_array($photos) && count($photos)) {
				foreach ($photos as $k => &$p) {
					$p['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '.jpg';
					$p['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $p['id'] . '_thumb.jpg';
					if ($p['status'] != 'accepted' && $photoId != $p['id']) {
						unset($photos[$k]);
					} else {
						$newphotos[] = $p;
					}
				}
				$photos = $newphotos;
			}


			$this->content['contest'] = $contest;

			//Std::loadLib('HtmlTools');

			//$this->content['contest']['dt_started'] = HtmlTools::FormatDateTime($contest['dt_started'], false);
			//$this->content['contest']['dt_finished'] = HtmlTools::FormatDateTime($contest['dt_finished'], false);
			reset($photos);
			$photoId = current($photos);
			$photoId = $photoId['id'];
			$this->content['current_photo'] = $photoId;
			if ($photoId && $photos) {
				$found = false;
				$prevId = $nextId = 0;
				//echo json_encode($photos);
				foreach ($photos as $k => &$p) {
				//while (!is_null($k = key($photos))) {
					//$p = $photos[$k];
					if ($p['id'] == $photoId) {
						$found = true;
						$photo = $p;
						//$r = prev($photos);
						$r = $photos[$k-1];
						if ($r) {
							$prevId = $r['id'];
							//next($photos);
						}
						//$r = next($photos);
						$r = $photos[$k+1];
						if ($r) {
							$nextId = $r['id'];
							//prev($photos);
						}
						if ($p['status'] != 'accepted') {
							unset($photos[$k]);
						}
					}
					//next($photos);
				}
				if ($found == false) {
					$photoId = 0;
				}
				$this->content['prevId'] = $prevId;
				$this->content['nextId'] = $nextId;

				if ($photoId) {
					if ($photo['player'] == self::$player->id) {
						$player = self::$player;
					} else {
						$player = new playerObject();
						$player->load($photo['player']);
					}
					$player->loadClan();
					$photo['player'] = $player->toArray();
					$photo['player']['about'] = json_decode($photo['player']['about'], true);
					$this->content['photo'] = $photo;

				}
			}
			$this->content['photos'] = $photos;
			$this->content['photos_json'] = str_replace("'", "\\'", json_encode($photos));
		}

		$this->content['contests'] = $contests;

		if (self::$player) {
			$tmp = Page::$sql->getRecord("SELECT id, status FROM photo WHERE player = " . self::$player->id . " and for_contest = " . $contest['id'] . " limit 1");
			$this->content['uploaded_photo_id'] = (int) @$tmp['id'];
			$this->content['uploaded_photo_status'] = $tmp['status'];
		}

		$this->content['window-name'] = PhotosLang::$windowTitle;
		if (self::$player) {
			$this->content['player'] = self::$player->toArray();
		}
		$this->page->addPart('content', 'photo/contest.xsl', $this->content);
	}

	/**
	 * Генерация панели оценки фотографии
	 */
	public function showRate() {
		$lastId = Runtime::get('last_seen_photo');
		if ($lastId) {
			if ($this->url[1] == 'prev') {
				$where = ' and ph.id > ' . $lastId;
			} else if ($this->url[1] == 'next') {
				$where = ' and ph.id < ' . $lastId;
			}
		}
		$sql = "SELECT ph.*, ROUND(ph.rating, 2) as rating
				FROM photo ph
				LEFT JOIN photo_vote r FORCE INDEX (`ix__photo_vote__photo_player_dt`)
					ON r.photo = ph.id and r.dt = '" . date('Y-m-d') . "'
					and r.player = " . self::$player->id . "
				WHERE r.id is NULL and ph.status = 'accepted'
					and ph.for_contest = 0
					" . $where . "
				ORDER BY ph.id desc limit 1";

		$photo = Page::$sql->getRecord($sql);
		if ($photo) {
			Runtime::set('last_seen_photo', $photo['id']);
			$photo['src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $photo['id'] . '.jpg';
			$photo['thumb_src'] = (DEV_SERVER ? '' : 'http://img.moswar.ru/') . '/@images/photos/' . $photo['id'] . '_thumb.jpg';
			if ($photo['player'] == self::$player->id) {
				$player = self::$player;
			} else {
				$player = new playerObject();
				$player->load($photo['player']);
			}
			$player->loadClan();
			$photo['player'] = $player->toArray();
			$photo['player']['about'] = json_decode($photo['player']['about'], true);

			$this->content['photo'] = $photo;
		}

		$this->content['window-name'] = PhotosLang::$windowTitle;
		$this->content['player'] = self::$player->toArray();
		$this->page->addPart('content', 'photo/rate.xsl', $this->content);
	}
}
?>