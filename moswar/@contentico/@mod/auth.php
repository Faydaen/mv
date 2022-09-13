<?php
class Auth extends ContenticoModule implements IModule
{
    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $this->url = explode('/', substr($_GET['url'], 0, -1));
        Runtime::init(true);
        // выход
        if (Runtime::$uid > 0 && $this->url[0] == 'exit') {
            Runtime::clear('uid');
            Runtime::clear('gid');
            $_SESSION['@contentico'] = array();
            // автологин
            setcookie('contentico_email', '', 0, '/');
            setcookie('contentico_pwd', '', 0, '/');
            //
            header('Location: /@contentico/');
            exit;
        }
        // генерация каптчи
        if (Runtime::$uid == 0 && $this->url[0] == 'captcha') {
            Std::loadLib('ImageTools');
            ImageTools::generateCaptcha(5, 150, 50, array(255, 255, 255), array(0, 200, 155), array(62, 207, 170));
            exit;
        }
        // сообщение "Доступ запрещен"
        if (Runtime::$uid > 0 && $this->url[0] == 'accessdenied') {
            $this->page['page-name'] = 'Доступ запрещен';
            $this->page['content'] = Contentico::loadTemplate('accessdenied');
            parent::onAfterProcessRequest();
            return;
        }
        // редирект с авторизацией
        if ($this->url[0] == 'redirect') {
            $auth = explode(',', base64_decode($this->url[1]));
            $email = preg_replace('/[^\w]/', '', $auth[0]);
            $pwd = preg_replace('/[^\w]/', '', $auth[1]);
            $user = $this->sqlGetRecord("SELECT id, _id FROM sysuser WHERE md5(email)='$email' AND md5(pwd)='$pwd' AND enabled=1");
            if ($user) {
                Runtime::set('uid', $user['id']);
                Runtime::set('gid', $user['_id']);
                header('Location: '.$auth[2]);
                exit;
            }
        }
        // авторизация
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Contentico::getConfig('auth_captcha') == 0 || strtoupper(trim($_POST['captcha'])) == strtoupper($_SESSION['captcha'])) {
                $email = preg_replace('/[^\w\.\-@]/', '', $_POST['email']);
                $pwd = sha1(trim($_POST['pwd']));
                $user = $this->sqlGetRecord("SELECT id, _id FROM sysuser WHERE email='$email' AND pwd='$pwd' AND enabled=1");
                if ($user) {
                    Runtime::set('uid', $user['id']);
                    Runtime::set('gid', $user['_id']);
                    // автологин
                    if (isset($_POST['autologin'])) {
                        setcookie('contentico_email', $email, time()+604800, '/');
                        setcookie('contentico_pwd', $pwd, time()+604800, '/');
                    } else  {
                        // решение проблемы разлогиневания при долгом бездействии
                        setcookie('contentico_email', $email, 0, '/');
                        setcookie('contentico_pwd', $pwd, 0, '/');
                    }
                    //
                    header('Location: /@contentico/');
                    exit;
                } else {
                    $error = '<div class="error">Неверный пароль</div>';
                }
            } else {
                $error = '<div class="error">Неверный код с картинки</div>';
            }
        } else {
            $error = '';
        }
        $this->template = Contentico::loadTemplate('auth');
        $this->page['error'] = $error;
        $this->page['email'] = $email;
        $this->page['show-captcha'] = Contentico::getConfig('auth_captcha') == 1 ? 'block' : 'none';
        //
        parent::onAfterProcessRequest();
    }
    
    public function tryAutologin()
    {
    	if (isset($_COOKIE['contentico_email']) && isset($_COOKIE['contentico_pwd'])) {
    		$email = preg_replace('/[^\w\.\-@]/', '', $_COOKIE['contentico_email']);
            $pwd = preg_replace('/[^\w]/', '', trim($_COOKIE['contentico_pwd']));
            $user = $this->sqlGetRecord("SELECT id, _id FROM sysuser WHERE email='$email' AND pwd='$pwd' AND enabled=1");
            if ($user) {
                Runtime::set('uid', $user['id']);
                Runtime::$uid = $user['id'];
                Runtime::set('gid', $user['_id']);
                Runtime::$gid = $user['_id'];
            }
        }
    }
}
?>