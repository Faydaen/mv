<?php
class Auth extends Page implements IModule
{
    public $moduleCode = 'Auth';
	public $checkQuests = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
		
        //
		
		switch ($this->url[0]) {
			case 'logout':
				Page::logout();
				Std::redirect('/');
				break;

			case "remind" :
				if (strlen(trim($_POST['email'])) > 5) {
					Std::loadMetaObjectClass('player');
					$criteria = new ObjectCollectionCriteria();
					$criteria->createWhere(playerObject::$EMAIL, ObjectCollectionCriteria::$COMPARE_EQUAL, Std::cleanString($_POST['email']));
					$collection = new ObjectCollection();
					$players = $collection->getObjectList(playerObject::$METAOBJECT, $criteria);
					if ($players === false) {
						$this->content["error"] = AuthLang::USER_EMAIL_NOT_FOUND;
					} else {
						$p = current ($players);

						$remind_code = sha1($p->id . "#" . $p->email . time() . rand(0, 1000));
						$params = array("reset" => $remind_code);
						Page::$sql->query("UPDATE player SET remind_code = '" . $remind_code . "' WHERE id = " . $p->id);

						Page::sendNotify($p, "reset_password", $params);

						/*
						$player = $p->toArray();
						
						$passwordMail = Std::renderTemplate(Std::loadTemplate('email/reset_password'), array(
								'uid' => $player['id'],
								'reset' => sha1($player['id'].'#'.$player['email']),
							));

						//Std::sendMail($player['email'], 'www.MosWar.ru: Сброс пароля', $passwordMail, 'informer@moswar.ru');
						Std::sendMultipartMail('informer@' . Lang::$textDomain, $player['email'], AuthLang::MOSWAR_RESET_PASSWORD, $passwordMail);
						 */
						Std::redirect('/auth/passwordstep2/');
					}
				} 
				$this->content['window-name'] = AuthLang::RESET_PASSWORD;
				$this->page->addPart('content', 'auth/remind.xsl', $this->content);
				break;

			case 'passwordstep2':
				$this->content['window-name'] = AuthLang::RESET_PASSWORD_STEP2;
				$this->page->addPart('content', 'auth/passwordstep2.xsl', $this->content);
				break;

			case 'reset':
				Std::loadMetaObjectClass('player');
				$criteria = new ObjectCollectionCriteria();
				$criteria->createWhere(playerObject::$ID, ObjectCollectionCriteria::$COMPARE_EQUAL, (int) $this->url[1]);
				$collection = new ObjectCollection();
				$players = $collection->getObjectList(playerObject::$METAOBJECT, $criteria);

				if ($players === false) {
					Page::dieOnError(404);
				}
				$player = current ($players);
				$p = $player->toArray();

				if ($p && !empty($p['remind_code']) && $p['remind_code'] == $this->url[2]) {
					$pwd = substr(md5(mt_rand(100000, 999999)), 0, 8);
					
					$player->password = md5($p["email"] . $pwd);
					$player->remind_code = "";
					$player->save($p['id'], array(playerObject::$PASSWORD, playerObject::$REMIND_CODE));

					$params = array("pwd" => $pwd);
					Page::sendNotify($player, "new_password", $params);

					/*
					$passwordMail = Std::renderTemplate(Std::loadTemplate('email/new_password'), array('pwd' => $pwd));
					//Std::sendMail($p['email'], 'www.MosWar.ru: Новый пароль', $passwordMail, 'informer@moswar.ru');
					Std::sendMultipartMail('informer@' . Lang::$textDomain, $p['email'], AuthLang::MOSWAR_NEW_PASSORD, $passwordMail);
					*/

					Runtime::set('player', $p);
					Runtime::$uid = $p['id'];
					$_SESSION['authkey'] = md5($p["email"].$pwd);
					if (DEV_SERVER) {
						setcookie('authkey', md5($p["email"].$pwd), time() + 2592000, '/');
						setcookie('userid', $p['id'], time() + 2592000, '/');
					} else {
						setcookie('authkey', md5($p["email"].$pwd), time() + 2592000, '/', '.moswar.ru');
						setcookie('userid', $p['id'], time() + 2592000, '/', '.moswar.ru');
					}
					

					Runtime::set('pwd', $pwd);
					Std::redirect('/auth/passwordstep3/');
				} else {
					Page::dieOnError(404);
				}
				break;

			case 'passwordstep3':
				Page::tryAutoLogin();
				$this->content["pwd"] = Runtime::get('pwd');
				$this->content['window-name'] = AuthLang::RESET_PASSWORD_STEP3;
				$this->page->addPart('content', 'auth/passwordstep3.xsl', $this->content);
				Runtime::clear('pwd');
				break;

			default:
				Std::redirect('/');
				break;
		}
		
        //
        parent::onAfterProcessRequest();
    }


}
?>