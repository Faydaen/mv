<?php
class player2BaseObject extends Object
{
	public static $METAOBJECT = 'player2';
    public static $ID_METAATTRIBUTE = 'player2.id';
 	public static $ID = 'player2.id';
    public $player = 0;
    public static $PLAYER = 'player2.player';
    public $lastnews = 0;
    public static $LASTNEWS = 'player2.lastnews';
    public $metrorat = 0;
    public static $METRORAT = 'player2.metrorat';
    public $metroorechance = 0;
    public static $METROORECHANCE = 'player2.metroorechance';
    public $botcheck = '';
    public static $BOTCHECK = 'player2.botcheck';
    public $timemachinetime = 0;
    public static $TIMEMACHINETIME = 'player2.timemachinetime';
    public $newlogs = 0;
    public static $NEWLOGS = 'player2.newlogs';
    public $newmes = 0;
    public static $NEWMES = 'player2.newmes';
    public $bankbribe = 0;
    public static $BANKBRIBE = 'player2.bankbribe';
    public $newduellogs = 0;
    public static $NEWDUELLOGS = 'player2.newduellogs';
    public $addmoney = 0;
    public static $ADDMONEY = 'player2.addmoney';
    public $addmoneycomment = '';
    public static $ADDMONEYCOMMENT = 'player2.addmoneycomment';
    public $clanambulancedt = '0000-00-00 00:00:00';
    public static $CLANAMBULANCEDT = 'player2.clanambulancedt';
    public $ips = '';
    public static $IPS = 'player2.ips';
    public $name = '';
    public static $NAME = 'player2.name';
    public $birthdt = '0000-00-00';
    public static $BIRTHDT = 'player2.birthdt';
    public $age = 0;
    public static $AGE = 'player2.age';
    public $slogan = '';
    public static $SLOGAN = 'player2.slogan';
    public $about = '';
    public static $ABOUT = 'player2.about';
    public $country = 0;
    public static $COUNTRY = 'player2.country';
    public $city = 0;
    public static $CITY = 'player2.city';
    public $metro = 0;
    public static $METRO = 'player2.metro';
    public $interests = array();
    public static $INTERESTS = 'player2.interests';
    public $family = '';
    public $family_Dictionary = array('single','friend','engaged','married','mixed','search');
    public static $FAMILY = 'player2.family';
    public $business = '';
    public static $BUSINESS = 'player2.business';
    public $lastmesdt = '0000-00-00 00:00:00';
    public static $LASTMESDT = 'player2.lastmesdt';
    public $naperstki = 0;
    public static $NAPERSTKI = 'player2.naperstki';
    public $naperstkidata = '';
    public static $NAPERSTKIDATA = 'player2.naperstkidata';
    public $livejournal = '';
    public static $LIVEJOURNAL = 'player2.livejournal';
    public $facebook = '';
    public static $FACEBOOK = 'player2.facebook';
    public $odnoklassniki = '';
    public static $ODNOKLASSNIKI = 'player2.odnoklassniki';
    public $mailru = '';
    public static $MAILRU = 'player2.mailru';
    public $twitter = '';
    public static $TWITTER = 'player2.twitter';
    public $liveinternet = '';
    public static $LIVEINTERNET = 'player2.liveinternet';
    public $vkontakte = '';
    public static $VKONTAKTE = 'player2.vkontakte';
    public $toptime = 0;
    public static $TOPTIME = 'player2.toptime';
    public $clancertgiven = 0;
    public static $CLANCERTGIVEN = 'player2.clancertgiven';
    public $travmadt = '0000-00-00 00:00:00';
    public static $TRAVMADT = 'player2.travmadt';
    public $alert = '';
    public static $ALERT = 'player2.alert';
    public $lastclandep = '0000-00-00 00:00:00';
    public static $LASTCLANDEP = 'player2.lastclandep';
    public $lastsovetdep = '0000-00-00 00:00:00';
    public static $LASTSOVETDEP = 'player2.lastsovetdep';
    public $chatcaptcha = 0;
    public static $CHATCAPTCHA = 'player2.chatcaptcha';
    public $config = '';
    public static $CONFIG = 'player2.config';
    public $sovetvotes = 0;
    public static $SOVETVOTES = 'player2.sovetvotes';
    public $unbancost = 0;
    public static $UNBANCOST = 'player2.unbancost';
    public $sovetmoney = 0;
    public static $SOVETMONEY = 'player2.sovetmoney';
    public $denyblackgifts = 0;
    public static $DENYBLACKGIFTS = 'player2.denyblackgifts';
    public $approvegifts = 0;
    public static $APPROVEGIFTS = 'player2.approvegifts';
    public $werewolf = 0;
    public static $WEREWOLF = 'player2.werewolf';
    public $werewolf_dt = '0000-00-00 00:00:00';
    public static $WEREWOLF_DT = 'player2.werewolf_dt';
    public $werewolf_data = '';
    public static $WEREWOLF_DATA = 'player2.werewolf_data';
    public $sovetpoints1 = 0;
    public static $SOVETPOINTS1 = 'player2.sovetpoints1';
    public $sovetpoints2 = 0;
    public static $SOVETPOINTS2 = 'player2.sovetpoints2';
    public $sovetpoints3 = 0;
    public static $SOVETPOINTS3 = 'player2.sovetpoints3';
    public $sovetprizetaken = 0;
    public static $SOVETPRIZETAKEN = 'player2.sovetprizetaken';
    public $patrol_bonus = '';
    public static $PATROL_BONUS = 'player2.patrol_bonus';
    public $npc_stat = 0;
    public static $NPC_STAT = 'player2.npc_stat';
    public $sovetpoints1prev = 0;
    public static $SOVETPOINTS1PREV = 'player2.sovetpoints1prev';
    public $casino_kubovich_step = 0;
    public static $CASINO_KUBOVICH_STEP = 'player2.casino_kubovich_step';
    public $casino_kubovich_progress = 0;
    public static $CASINO_KUBOVICH_PROGRESS = 'player2.casino_kubovich_progress';
    public $casino_today_chip = 0;
    public static $CASINO_TODAY_CHIP = 'player2.casino_today_chip';
    public $duelanim = 0;
    public static $DUELANIM = 'player2.duelanim';
    public $a_rubber = 0;
    public static $A_RUBBER = 'player2.a_rubber';
    public $a_furnace = 0;
    public static $A_FURNACE = 'player2.a_furnace';
    public $a_pump = 0;
    public static $A_PUMP = 'player2.a_pump';
    public $a_windows = 0;
    public static $A_WINDOWS = 'player2.a_windows';
    public $a_glasscutter = 0;
    public static $A_GLASSCUTTER = 'player2.a_glasscutter';
    public $a_beam = 0;
    public static $A_BEAM = 'player2.a_beam';
    public $a_brick = 0;
    public static $A_BRICK = 'player2.a_brick';
    public $a_cement = 0;
    public static $A_CEMENT = 'player2.a_cement';
    public $a_paint = 0;
    public static $A_PAINT = 'player2.a_paint';
    public $a_screw = 0;
    public static $A_SCREW = 'player2.a_screw';
    public $a_draft = 0;
    public static $A_DRAFT = 'player2.a_draft';
    public $a_rasp = 0;
    public static $A_RASP = 'player2.a_rasp';
    public $garage = 0;
    public static $GARAGE = 'player2.garage';
    public $car = 0;
    public static $CAR = 'player2.car';

    public function __construct()
    {
        parent::__construct('player2');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->lastnews = 0;
        $this->metrorat = 0;
        $this->metroorechance = 0;
        $this->botcheck = '';
        $this->timemachinetime = 0;
        $this->newlogs = 0;
        $this->newmes = 0;
        $this->bankbribe = 0;
        $this->newduellogs = 0;
        $this->addmoney = 0;
        $this->addmoneycomment = '';
        $this->clanambulancedt = '0000-00-00 00:00:00';
        $this->ips = '';
        $this->name = '';
        $this->birthdt = '0000-00-00';
        $this->age = 0;
        $this->slogan = '';
        $this->about = '';
        $this->country = 0;
        $this->city = 0;
        $this->metro = 0;
        $this->interests = array();
        $this->family = '';
        $this->business = '';
        $this->lastmesdt = '0000-00-00 00:00:00';
        $this->naperstki = 0;
        $this->naperstkidata = '';
        $this->livejournal = '';
        $this->facebook = '';
        $this->odnoklassniki = '';
        $this->mailru = '';
        $this->twitter = '';
        $this->liveinternet = '';
        $this->vkontakte = '';
        $this->toptime = 0;
        $this->clancertgiven = 0;
        $this->travmadt = '0000-00-00 00:00:00';
        $this->alert = '';
        $this->lastclandep = '0000-00-00 00:00:00';
        $this->lastsovetdep = '0000-00-00 00:00:00';
        $this->chatcaptcha = 0;
        $this->config = '';
        $this->sovetvotes = 0;
        $this->unbancost = 0;
        $this->sovetmoney = 0;
        $this->denyblackgifts = 0;
        $this->approvegifts = 0;
        $this->werewolf = 0;
        $this->werewolf_dt = '0000-00-00 00:00:00';
        $this->werewolf_data = '';
        $this->sovetpoints1 = 0;
        $this->sovetpoints2 = 0;
        $this->sovetpoints3 = 0;
        $this->sovetprizetaken = 0;
        $this->patrol_bonus = '';
        $this->npc_stat = 0;
        $this->sovetpoints1prev = 0;
        $this->casino_kubovich_step = 0;
        $this->casino_kubovich_progress = 0;
        $this->casino_today_chip = 0;
        $this->duelanim = 0;
        $this->a_rubber = 0;
        $this->a_furnace = 0;
        $this->a_pump = 0;
        $this->a_windows = 0;
        $this->a_glasscutter = 0;
        $this->a_beam = 0;
        $this->a_brick = 0;
        $this->a_cement = 0;
        $this->a_paint = 0;
        $this->a_screw = 0;
        $this->a_draft = 0;
        $this->a_rasp = 0;
        $this->garage = 0;
        $this->car = 0;
    }

	/**
	 * Инициализация свойств объекта из ассоциативного массива
	 *
	 * @param array
	 */
    public function init($object)
    {
        if (isset($object['id']))
        {
            $this->id = $object['id'];
        }
        $this->player = $object['player'];
        $this->lastnews = $object['lastnews'];
        $this->metrorat = $object['metrorat'];
        $this->metroorechance = $object['metroorechance'];
        $this->botcheck = $object['botcheck'];
        $this->timemachinetime = $object['timemachinetime'];
        $this->newlogs = $object['newlogs'];
        $this->newmes = $object['newmes'];
        $this->bankbribe = $object['bankbribe'];
        $this->newduellogs = $object['newduellogs'];
        $this->addmoney = $object['addmoney'];
        $this->addmoneycomment = $object['addmoneycomment'];
        $this->clanambulancedt = $object['clanambulancedt'];
        $this->ips = $object['ips'];
        $this->name = $object['name'];
        $this->birthdt = $object['birthdt'];
        $this->age = $object['age'];
        $this->slogan = $object['slogan'];
        $this->about = $object['about'];
        $this->country = $object['country'];
        $this->city = $object['city'];
        $this->metro = $object['metro'];
        $this->interests = $object['interests'];
        $this->family = $object['family'];
        $this->business = $object['business'];
        $this->lastmesdt = $object['lastmesdt'];
        $this->naperstki = $object['naperstki'];
        $this->naperstkidata = $object['naperstkidata'];
        $this->livejournal = $object['livejournal'];
        $this->facebook = $object['facebook'];
        $this->odnoklassniki = $object['odnoklassniki'];
        $this->mailru = $object['mailru'];
        $this->twitter = $object['twitter'];
        $this->liveinternet = $object['liveinternet'];
        $this->vkontakte = $object['vkontakte'];
        $this->toptime = $object['toptime'];
        $this->clancertgiven = $object['clancertgiven'];
        $this->travmadt = $object['travmadt'];
        $this->alert = $object['alert'];
        $this->lastclandep = $object['lastclandep'];
        $this->lastsovetdep = $object['lastsovetdep'];
        $this->chatcaptcha = $object['chatcaptcha'];
        $this->config = $object['config'];
        $this->sovetvotes = $object['sovetvotes'];
        $this->unbancost = $object['unbancost'];
        $this->sovetmoney = $object['sovetmoney'];
        $this->denyblackgifts = $object['denyblackgifts'];
        $this->approvegifts = $object['approvegifts'];
        $this->werewolf = $object['werewolf'];
        $this->werewolf_dt = $object['werewolf_dt'];
        $this->werewolf_data = $object['werewolf_data'];
        $this->sovetpoints1 = $object['sovetpoints1'];
        $this->sovetpoints2 = $object['sovetpoints2'];
        $this->sovetpoints3 = $object['sovetpoints3'];
        $this->sovetprizetaken = $object['sovetprizetaken'];
        $this->patrol_bonus = $object['patrol_bonus'];
        $this->npc_stat = $object['npc_stat'];
        $this->sovetpoints1prev = $object['sovetpoints1prev'];
        $this->casino_kubovich_step = $object['casino_kubovich_step'];
        $this->casino_kubovich_progress = $object['casino_kubovich_progress'];
        $this->casino_today_chip = $object['casino_today_chip'];
        $this->duelanim = $object['duelanim'];
        $this->a_rubber = $object['a_rubber'];
        $this->a_furnace = $object['a_furnace'];
        $this->a_pump = $object['a_pump'];
        $this->a_windows = $object['a_windows'];
        $this->a_glasscutter = $object['a_glasscutter'];
        $this->a_beam = $object['a_beam'];
        $this->a_brick = $object['a_brick'];
        $this->a_cement = $object['a_cement'];
        $this->a_paint = $object['a_paint'];
        $this->a_screw = $object['a_screw'];
        $this->a_draft = $object['a_draft'];
        $this->a_rasp = $object['a_rasp'];
        $this->garage = $object['garage'];
        $this->car = $object['car'];
    }

	/**
	 * Инициализация свойств объекта из формы (POST)
	 *
	 */
    public function initFromForm($id=0)
    {
        if ($id)
        {
            $this->id = $id;
        }
        else
        {
            if (isset($_POST['id']))
            {
                $this->id = (int) $_POST['id'];
            }
            if (isset($_GET['id']))
            {
                $this->id = (int) $_GET['id'];
            }
        }
        if (!$this->metaViewId)
        {
            $metaView = isset($_GET['metaview']) ? $_GET['metaview'] : (isset($_POST['metaview']) ? $_POST['metaview'] : 0);
            if ($metaView)
            {
                if (is_numeric((int) $metaView))
                {
                    $this->metaViewId = (int) $metaView;
                }
                else
                {
                    $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code=''");
                }
            }
        }
        if ($this->id)
        {
            $this->load($this->id);
        }
        switch ($this->metaViewId)
        {
            case 108:
                $this->player = (int) $_POST['player'];
                $this->metrorat = (int) $_POST['metrorat'];
                $this->metroorechance = (int) $_POST['metroorechance'];
                $this->lastnews = (int) $_POST['lastnews'];
                $this->newlogs = (int) $_POST['newlogs'];
                $this->newmes = (int) $_POST['newmes'];
                $this->timemachinetime = (int) $_POST['timemachinetime'];
                $this->botcheck = $_POST['botcheck'];
                $this->bankbribe = (int) $_POST['bankbribe'];
                $this->newduellogs = (int) $_POST['newduellogs'];
                $this->addmoney = (int) $_POST['addmoney'];
                $this->addmoneycomment = str_replace('"', '&quot;', $_POST['addmoneycomment']);
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['clanambulancedt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->clanambulancedt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->ips = str_replace('"', '&quot;', $_POST['ips']);
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['lastmesdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->lastmesdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['birthdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000';
                }
                $d = explode('.', $dt);
                $this->birthdt = $d[2].'-'.$d[1].'-'.$d[0];
                $this->age = (int) $_POST['age'];
                $this->slogan = str_replace('"', '&quot;', $_POST['slogan']);
                $this->about = str_replace('"', '&quot;', $_POST['about']);
                $this->country = (int) $_POST['country'];
                $this->city = (int) $_POST['city'];
                $this->metro = (int) $_POST['metro'];
                if (is_array($_POST['interests']))
                {
                    foreach ($_POST['interests'] as $linkedObjectId)
                    {
                        if ($linkedObjectId > 0)
                        {
                            $this->interests[] = (int) $linkedObjectId;
                        }
                    }
                }
                $this->family = $_POST['family'];
                $this->business = str_replace('"', '&quot;', $_POST['business']);
                $this->naperstki = (int) $_POST['naperstki'];
                $this->naperstkidata = str_replace('"', '&quot;', $_POST['naperstkidata']);
                $this->toptime = (int) $_POST['toptime'];
                $this->vkontakte = str_replace('"', '&quot;', $_POST['vkontakte']);
                $this->facebook = str_replace('"', '&quot;', $_POST['facebook']);
                $this->twitter = str_replace('"', '&quot;', $_POST['twitter']);
                $this->livejournal = str_replace('"', '&quot;', $_POST['livejournal']);
                $this->mailru = str_replace('"', '&quot;', $_POST['mailru']);
                $this->odnoklassniki = str_replace('"', '&quot;', $_POST['odnoklassniki']);
                $this->liveinternet = str_replace('"', '&quot;', $_POST['liveinternet']);
                $this->clancertgiven = isset($_POST['clancertgiven']) ? 1 : 0;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['travmadt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->travmadt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->alert = $_POST['alert'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['lastclandep']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->lastclandep = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['lastsovetdep']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->lastsovetdep = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->sovetvotes = (int) $_POST['sovetvotes'];
                $this->chatcaptcha = isset($_POST['chatcaptcha']) ? 1 : 0;
                $this->config = $_POST['config'];
                $this->unbancost = (int) $_POST['unbancost'];
                $this->sovetmoney = (int) $_POST['sovetmoney'];
                $this->denyblackgifts = isset($_POST['denyblackgifts']) ? 1 : 0;
                $this->approvegifts = isset($_POST['approvegifts']) ? 1 : 0;
                $this->werewolf = isset($_POST['werewolf']) ? 1 : 0;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['werewolf_dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->werewolf_dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->werewolf_data = $_POST['werewolf_data'];
                $this->sovetpoints1 = (int) $_POST['sovetpoints1'];
                $this->sovetpoints2 = (int) $_POST['sovetpoints2'];
                $this->sovetpoints3 = (int) $_POST['sovetpoints3'];
                $this->sovetprizetaken = (int) $_POST['sovetprizetaken'];
                $this->patrol_bonus = str_replace('"', '&quot;', $_POST['patrol_bonus']);
                $this->duelanim = isset($_POST['duelanim']) ? 1 : 0;
                $this->a_rubber = (int) $_POST['a_rubber'];
                $this->a_furnace = (int) $_POST['a_furnace'];
                $this->a_pump = (int) $_POST['a_pump'];
                $this->a_windows = (int) $_POST['a_windows'];
                $this->a_glasscutter = (int) $_POST['a_glasscutter'];
                $this->a_beam = (int) $_POST['a_beam'];
                $this->a_brick = (int) $_POST['a_brick'];
                $this->a_cement = (int) $_POST['a_cement'];
                $this->a_paint = (int) $_POST['a_paint'];
                $this->a_screw = (int) $_POST['a_screw'];
                $this->a_draft = (int) $_POST['a_draft'];
                $this->a_rasp = (int) $_POST['a_rasp'];
                $this->garage = (int) $_POST['garage'];
                break;
        }
    }

	/**
	 * Сериализация свойств объекта в ассоциативный массив
	 *
	 * @return array
	 */
    public function toArray()
    {
        $object = array();
        $object['id'] = $this->id;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['lastnews'] = $this->lastnews;
        $object['metrorat'] = $this->metrorat;
        $object['metroorechance'] = $this->metroorechance;
        $object['botcheck'] = $this->botcheck;
        $object['timemachinetime'] = $this->timemachinetime;
        $object['newlogs'] = $this->newlogs;
        $object['newmes'] = $this->newmes;
        $object['bankbribe'] = $this->bankbribe;
        $object['newduellogs'] = $this->newduellogs;
        $object['addmoney'] = $this->addmoney;
        $object['addmoneycomment'] = $this->addmoneycomment;
        $object['clanambulancedt'] = $this->clanambulancedt;
        $object['ips'] = $this->ips;
        $object['name'] = $this->name;
        $object['birthdt'] = $this->birthdt;
        $object['age'] = $this->age;
        $object['slogan'] = $this->slogan;
        $object['about'] = $this->about;
        if (is_object($this->country))
        {
            $object['country'] = $this->country->toArray();
        }
        else
        {
        	$object['country'] = $this->country;
        }
        if (is_object($this->city))
        {
            $object['city'] = $this->city->toArray();
        }
        else
        {
        	$object['city'] = $this->city;
        }
        if (is_object($this->metro))
        {
            $object['metro'] = $this->metro->toArray();
        }
        else
        {
        	$object['metro'] = $this->metro;
        }
        $object['interests'] = $this->interests;
        $object['family'] = $this->family;
        $object['business'] = $this->business;
        $object['lastmesdt'] = $this->lastmesdt;
        $object['naperstki'] = $this->naperstki;
        $object['naperstkidata'] = $this->naperstkidata;
        $object['livejournal'] = $this->livejournal;
        $object['facebook'] = $this->facebook;
        $object['odnoklassniki'] = $this->odnoklassniki;
        $object['mailru'] = $this->mailru;
        $object['twitter'] = $this->twitter;
        $object['liveinternet'] = $this->liveinternet;
        $object['vkontakte'] = $this->vkontakte;
        $object['toptime'] = $this->toptime;
        $object['clancertgiven'] = $this->clancertgiven;
        $object['travmadt'] = $this->travmadt;
        $object['alert'] = $this->alert;
        $object['lastclandep'] = $this->lastclandep;
        $object['lastsovetdep'] = $this->lastsovetdep;
        $object['chatcaptcha'] = $this->chatcaptcha;
        $object['config'] = $this->config;
        $object['sovetvotes'] = $this->sovetvotes;
        $object['unbancost'] = $this->unbancost;
        $object['sovetmoney'] = $this->sovetmoney;
        $object['denyblackgifts'] = $this->denyblackgifts;
        $object['approvegifts'] = $this->approvegifts;
        $object['werewolf'] = $this->werewolf;
        $object['werewolf_dt'] = $this->werewolf_dt;
        $object['werewolf_data'] = $this->werewolf_data;
        $object['sovetpoints1'] = $this->sovetpoints1;
        $object['sovetpoints2'] = $this->sovetpoints2;
        $object['sovetpoints3'] = $this->sovetpoints3;
        $object['sovetprizetaken'] = $this->sovetprizetaken;
        $object['patrol_bonus'] = $this->patrol_bonus;
        $object['npc_stat'] = $this->npc_stat;
        $object['sovetpoints1prev'] = $this->sovetpoints1prev;
        $object['casino_kubovich_step'] = $this->casino_kubovich_step;
        $object['casino_kubovich_progress'] = $this->casino_kubovich_progress;
        $object['casino_today_chip'] = $this->casino_today_chip;
        $object['duelanim'] = $this->duelanim;
        $object['a_rubber'] = $this->a_rubber;
        $object['a_furnace'] = $this->a_furnace;
        $object['a_pump'] = $this->a_pump;
        $object['a_windows'] = $this->a_windows;
        $object['a_glasscutter'] = $this->a_glasscutter;
        $object['a_beam'] = $this->a_beam;
        $object['a_brick'] = $this->a_brick;
        $object['a_cement'] = $this->a_cement;
        $object['a_paint'] = $this->a_paint;
        $object['a_screw'] = $this->a_screw;
        $object['a_draft'] = $this->a_draft;
        $object['a_rasp'] = $this->a_rasp;
        $object['garage'] = $this->garage;
        $object['car'] = $this->car;
        return $object;
    }

	/**
	 * Сохранение объекта в базу данных в merge таблицу
	 *
	 * @param int $id
	 */
    public function saveMerge($id=0, $fields=false)
    {
    	$this->save($id, $fields, '_merge');
    }

	/**
	 * Сохранение объекта в базу данных
	 *
	 * @param int $id
	 */
    public function save($id=0, $fields=false, $saveMerge='')
    {
        if (is_object($this->player))
        {
            $this->player->save();
        }
        if (is_object($this->country))
        {
            $this->country->save();
        }
        if (is_object($this->city))
        {
            $this->city->save();
        }
        if (is_object($this->metro))
        {
            $this->metro->save();
        }
        if (is_array($this->interests))
        {
            for ($i=0, $j=sizeof($this->interests); $i<$j; $i++)
            {
            	if (is_object($this->interests[$i]))
            	{
            		$this->interests[$i]->save();
            		if (!in_array($this->interests[$i]->id, $this->interests))
            		{
            			$this->interests[] = $this->interests[$i]->id;
            		}
            	}
            }
        }
        if ($id)
        {
            $this->id = $id;
        }
        if ($this->id)
        {
            $object = $this->toArray();
            if ($this->globalExtention->eventsOnBeforeEdit)
            {
                $this->globalExtention->onBeforeEdit($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnBeforeEdit)
            {
                $this->extention->onBeforeEdit($this->id, $this);
            }
            //
            $linkToObjectsMetaAttributes = array();
            //
            if ($fields) {
            	$attributes = array();
            	foreach ($fields as $field) {
            		$field = str_replace('player2.', '', $field);
            		switch ($this->getType($field)) {
            			case META_ATTRIBUTE_TYPE_INT:
                		case META_ATTRIBUTE_TYPE_BOOL:
		                case META_ATTRIBUTE_TYPE_FILE:
    		            case META_ATTRIBUTE_TYPE_IMAGE:
        		            $attributes[] = "`$field`=".(int)$this->{$field};
            		        break;
                		case META_ATTRIBUTE_TYPE_FLOAT:
	                	case META_ATTRIBUTE_TYPE_DOUBLE:
    	            		$attributes[] = "`$field`=".(double)$this->{$field};
	        	        	break;
    	        	    case META_ATTRIBUTE_TYPE_STRING:
        	        	case META_ATTRIBUTE_TYPE_TEXT:
	        	        case META_ATTRIBUTE_TYPE_BIGTEXT:
    	        	    case META_ATTRIBUTE_TYPE_DATA:
        	        	case META_ATTRIBUTE_TYPE_DATETIME:
	            	    case META_ATTRIBUTE_TYPE_DATE:
    	            	case META_ATTRIBUTE_TYPE_DICTIONARY:
	    	            case META_ATTRIBUTE_TYPE_CUSTOM:
    	    	        case META_ATTRIBUTE_TYPE_PASSWORD:
							$attributes[] = "`$field`='".Std::cleanString($this->{$field})."'";
	                	    break;
		                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
    		            	$attributes[] = "`$field`=".(is_object($this->{$field}) ? $this->{$field}->id : $this->{$field});	
		                	break;	
    		            case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
    		            	$linkToObjectsMetaAttributes[] = array($field);
    		            	break;
        	    	}
            	}
            	$this->sql->query("UPDATE `player2".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `player2".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `lastnews`=".(int)$this->lastnews.", `metrorat`=".(int)$this->metrorat.", `metroorechance`=".(int)$this->metroorechance.", `botcheck`='".Std::cleanString($this->botcheck)."', `timemachinetime`=".(int)$this->timemachinetime.", `newlogs`=".(int)$this->newlogs.", `newmes`=".(int)$this->newmes.", `bankbribe`=".(int)$this->bankbribe.", `newduellogs`=".(int)$this->newduellogs.", `addmoney`=".(int)$this->addmoney.", `addmoneycomment`='".Std::cleanString($this->addmoneycomment)."', `clanambulancedt`='".Std::cleanString($this->clanambulancedt)."', `ips`='".Std::cleanString($this->ips)."', `name`='".Std::cleanString($this->name)."', `birthdt`='".Std::cleanString($this->birthdt)."', `age`=".(int)$this->age.", `slogan`='".Std::cleanString($this->slogan)."', `about`='".Std::cleanString($this->about)."', `country`=".(is_object($this->country) ? $this->country->id : $this->country).", `city`=".(is_object($this->city) ? $this->city->id : $this->city).", `metro`=".(is_object($this->metro) ? $this->metro->id : $this->metro).", `family`='".Std::cleanString($this->family)."', `business`='".Std::cleanString($this->business)."', `lastmesdt`='".Std::cleanString($this->lastmesdt)."', `naperstki`=".(int)$this->naperstki.", `naperstkidata`='".Std::cleanString($this->naperstkidata)."', `livejournal`='".Std::cleanString($this->livejournal)."', `facebook`='".Std::cleanString($this->facebook)."', `odnoklassniki`='".Std::cleanString($this->odnoklassniki)."', `mailru`='".Std::cleanString($this->mailru)."', `twitter`='".Std::cleanString($this->twitter)."', `liveinternet`='".Std::cleanString($this->liveinternet)."', `vkontakte`='".Std::cleanString($this->vkontakte)."', `toptime`=".(int)$this->toptime.", `clancertgiven`=".(int)$this->clancertgiven.", `travmadt`='".Std::cleanString($this->travmadt)."', `alert`='".Std::cleanString($this->alert)."', `lastclandep`='".Std::cleanString($this->lastclandep)."', `lastsovetdep`='".Std::cleanString($this->lastsovetdep)."', `chatcaptcha`=".(int)$this->chatcaptcha.", `config`='".Std::cleanString($this->config)."', `sovetvotes`=".(int)$this->sovetvotes.", `unbancost`=".(int)$this->unbancost.", `sovetmoney`=".(int)$this->sovetmoney.", `denyblackgifts`=".(int)$this->denyblackgifts.", `approvegifts`=".(int)$this->approvegifts.", `werewolf`=".(int)$this->werewolf.", `werewolf_dt`='".Std::cleanString($this->werewolf_dt)."', `werewolf_data`='".Std::cleanString($this->werewolf_data)."', `sovetpoints1`=".(int)$this->sovetpoints1.", `sovetpoints2`=".(int)$this->sovetpoints2.", `sovetpoints3`=".(int)$this->sovetpoints3.", `sovetprizetaken`=".(int)$this->sovetprizetaken.", `patrol_bonus`='".Std::cleanString($this->patrol_bonus)."', `npc_stat`=".(int)$this->npc_stat.", `sovetpoints1prev`=".(int)$this->sovetpoints1prev.", `casino_kubovich_step`=".(int)$this->casino_kubovich_step.", `casino_kubovich_progress`=".(int)$this->casino_kubovich_progress.", `casino_today_chip`=".(int)$this->casino_today_chip.", `duelanim`=".(int)$this->duelanim.", `a_rubber`=".(int)$this->a_rubber.", `a_furnace`=".(int)$this->a_furnace.", `a_pump`=".(int)$this->a_pump.", `a_windows`=".(int)$this->a_windows.", `a_glasscutter`=".(int)$this->a_glasscutter.", `a_beam`=".(int)$this->a_beam.", `a_brick`=".(int)$this->a_brick.", `a_cement`=".(int)$this->a_cement.", `a_paint`=".(int)$this->a_paint.", `a_screw`=".(int)$this->a_screw.", `a_draft`=".(int)$this->a_draft.", `a_rasp`=".(int)$this->a_rasp.", `garage`=".(int)$this->garage.", `car`=".(int)$this->car." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
                $linkToObjectsMetaAttributes = array(interests);
        	}
         	if (sizeof($linkToObjectsMetaAttributes) > 0) {
        	   	foreach ($linkToObjectsMetaAttributes as $metaAttributeCode) {
        	   		$this->processLinkToObjects($metaAttributeCode);
          		}
        	}
        	//
            if ($this->globalExtention->eventsOnAfterEdit)
            {
                $this->globalExtention->onAfterEdit($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnAfterEdit)
            {
                $this->extention->onAfterEdit($this->id, $this);
            }
        }
        else
        {
            $object = $this->toArray();
            if ($this->globalExtention->eventsOnBeforeCreate)
            {
                $this->globalExtention->onBeforeCreate($this);
            }
            if ($this->extention && $this->extention->eventsOnBeforeCreate)
            {
                $this->extention->onBeforeCreate($this);
            }
            //
            $this->id = $this->sql->insert("INSERT INTO `player2".$saveMerge."` (`player`, `lastnews`, `metrorat`, `metroorechance`, `botcheck`, `timemachinetime`, `newlogs`, `newmes`, `bankbribe`, `newduellogs`, `addmoney`, `addmoneycomment`, `clanambulancedt`, `ips`, `name`, `birthdt`, `age`, `slogan`, `about`, `country`, `city`, `metro`, `family`, `business`, `lastmesdt`, `naperstki`, `naperstkidata`, `livejournal`, `facebook`, `odnoklassniki`, `mailru`, `twitter`, `liveinternet`, `vkontakte`, `toptime`, `clancertgiven`, `travmadt`, `alert`, `lastclandep`, `lastsovetdep`, `chatcaptcha`, `config`, `sovetvotes`, `unbancost`, `sovetmoney`, `denyblackgifts`, `approvegifts`, `werewolf`, `werewolf_dt`, `werewolf_data`, `sovetpoints1`, `sovetpoints2`, `sovetpoints3`, `sovetprizetaken`, `patrol_bonus`, `npc_stat`, `sovetpoints1prev`, `casino_kubovich_step`, `casino_kubovich_progress`, `casino_today_chip`, `duelanim`, `a_rubber`, `a_furnace`, `a_pump`, `a_windows`, `a_glasscutter`, `a_beam`, `a_brick`, `a_cement`, `a_paint`, `a_screw`, `a_draft`, `a_rasp`, `garage`, `car`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", ".(int)$this->lastnews.", ".(int)$this->metrorat.", ".(int)$this->metroorechance.", '".Std::cleanString($this->botcheck)."', ".(int)$this->timemachinetime.", ".(int)$this->newlogs.", ".(int)$this->newmes.", ".(int)$this->bankbribe.", ".(int)$this->newduellogs.", ".(int)$this->addmoney.", '".Std::cleanString($this->addmoneycomment)."', '".Std::cleanString($this->clanambulancedt)."', '".Std::cleanString($this->ips)."', '".Std::cleanString($this->name)."', '".Std::cleanString($this->birthdt)."', ".(int)$this->age.", '".Std::cleanString($this->slogan)."', '".Std::cleanString($this->about)."', ".(is_object($this->country) ? $this->country->id : $this->country).", ".(is_object($this->city) ? $this->city->id : $this->city).", ".(is_object($this->metro) ? $this->metro->id : $this->metro).", '".Std::cleanString($this->family)."', '".Std::cleanString($this->business)."', '".Std::cleanString($this->lastmesdt)."', ".(int)$this->naperstki.", '".Std::cleanString($this->naperstkidata)."', '".Std::cleanString($this->livejournal)."', '".Std::cleanString($this->facebook)."', '".Std::cleanString($this->odnoklassniki)."', '".Std::cleanString($this->mailru)."', '".Std::cleanString($this->twitter)."', '".Std::cleanString($this->liveinternet)."', '".Std::cleanString($this->vkontakte)."', ".(int)$this->toptime.", ".(int)$this->clancertgiven.", '".Std::cleanString($this->travmadt)."', '".Std::cleanString($this->alert)."', '".Std::cleanString($this->lastclandep)."', '".Std::cleanString($this->lastsovetdep)."', ".(int)$this->chatcaptcha.", '".Std::cleanString($this->config)."', ".(int)$this->sovetvotes.", ".(int)$this->unbancost.", ".(int)$this->sovetmoney.", ".(int)$this->denyblackgifts.", ".(int)$this->approvegifts.", ".(int)$this->werewolf.", '".Std::cleanString($this->werewolf_dt)."', '".Std::cleanString($this->werewolf_data)."', ".(int)$this->sovetpoints1.", ".(int)$this->sovetpoints2.", ".(int)$this->sovetpoints3.", ".(int)$this->sovetprizetaken.", '".Std::cleanString($this->patrol_bonus)."', ".(int)$this->npc_stat.", ".(int)$this->sovetpoints1prev.", ".(int)$this->casino_kubovich_step.", ".(int)$this->casino_kubovich_progress.", ".(int)$this->casino_today_chip.", ".(int)$this->duelanim.", ".(int)$this->a_rubber.", ".(int)$this->a_furnace.", ".(int)$this->a_pump.", ".(int)$this->a_windows.", ".(int)$this->a_glasscutter.", ".(int)$this->a_beam.", ".(int)$this->a_brick.", ".(int)$this->a_cement.", ".(int)$this->a_paint.", ".(int)$this->a_screw.", ".(int)$this->a_draft.", ".(int)$this->a_rasp.", ".(int)$this->garage.", ".(int)$this->car.")");
            if(sizeof($this->interests) > 0)
            {
                foreach ($this->interests as $linkedObjectId)
                {
                    $this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES (880, {$this->id}, $linkedObjectId)");
                }
            }
        	//
            if ($this->globalExtention->eventsOnAfterCreate)
            {
                $this->globalExtention->onAfterCreate($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnAfterCreate)
            {
                $this->extention->onAfterCreate($this->id, $this);
            }
        }
    }
    
    private function processLinkToObjects($metaAttributeCode)
    {
    	if (is_array($metaAttributeCode)) {
            $metaAttributeCode = $metaAttributeCode[0];
        }
        $metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE metaobject_id=(SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}') AND code='$metaAttributeCode'");
    	$this->sql->query("DELETE FROM metalink WHERE metaattribute_id=$metaAttributeId AND object_id={$this->id}");
	    if (sizeof($this->{$metaAttributeCode}) > 0) {
			foreach ($this->{$metaAttributeCode} as $linkedObjectId) {
            	$this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES ($metaAttributeId, {$this->id}, $linkedObjectId)");
	        }
		}
    }
    
    private function getType($fieldCode)
    {
    	switch ($fieldCode) {
			case 'id': return 1; break;
			case 'player': return 13; break;
			case 'lastnews': return 2; break;
			case 'metrorat': return 2; break;
			case 'metroorechance': return 2; break;
			case 'botcheck': return 5; break;
			case 'timemachinetime': return 2; break;
			case 'newlogs': return 2; break;
			case 'newmes': return 2; break;
			case 'bankbribe': return 2; break;
			case 'newduellogs': return 2; break;
			case 'addmoney': return 2; break;
			case 'addmoneycomment': return 4; break;
			case 'clanambulancedt': return 8; break;
			case 'ips': return 4; break;
			case 'name': return 4; break;
			case 'birthdt': return 9; break;
			case 'age': return 2; break;
			case 'slogan': return 4; break;
			case 'about': return 4; break;
			case 'country': return 13; break;
			case 'city': return 13; break;
			case 'metro': return 13; break;
			case 'interests': return 14; break;
			case 'family': return 15; break;
			case 'business': return 4; break;
			case 'lastmesdt': return 8; break;
			case 'naperstki': return 2; break;
			case 'naperstkidata': return 4; break;
			case 'livejournal': return 4; break;
			case 'facebook': return 4; break;
			case 'odnoklassniki': return 4; break;
			case 'mailru': return 4; break;
			case 'twitter': return 4; break;
			case 'liveinternet': return 4; break;
			case 'vkontakte': return 4; break;
			case 'toptime': return 2; break;
			case 'clancertgiven': return 10; break;
			case 'travmadt': return 8; break;
			case 'alert': return 5; break;
			case 'lastclandep': return 8; break;
			case 'lastsovetdep': return 8; break;
			case 'chatcaptcha': return 10; break;
			case 'config': return 5; break;
			case 'sovetvotes': return 2; break;
			case 'unbancost': return 2; break;
			case 'sovetmoney': return 2; break;
			case 'denyblackgifts': return 10; break;
			case 'approvegifts': return 10; break;
			case 'werewolf': return 10; break;
			case 'werewolf_dt': return 8; break;
			case 'werewolf_data': return 5; break;
			case 'sovetpoints1': return 2; break;
			case 'sovetpoints2': return 2; break;
			case 'sovetpoints3': return 2; break;
			case 'sovetprizetaken': return 2; break;
			case 'patrol_bonus': return 4; break;
			case 'npc_stat': return 2; break;
			case 'sovetpoints1prev': return 2; break;
			case 'casino_kubovich_step': return 2; break;
			case 'casino_kubovich_progress': return 2; break;
			case 'casino_today_chip': return 2; break;
			case 'duelanim': return 10; break;
			case 'a_rubber': return 2; break;
			case 'a_furnace': return 2; break;
			case 'a_pump': return 2; break;
			case 'a_windows': return 2; break;
			case 'a_glasscutter': return 2; break;
			case 'a_beam': return 2; break;
			case 'a_brick': return 2; break;
			case 'a_cement': return 2; break;
			case 'a_paint': return 2; break;
			case 'a_screw': return 2; break;
			case 'a_draft': return 2; break;
			case 'a_rasp': return 2; break;
			case 'garage': return 2; break;
			case 'car': return 2; break;
    	}
    }
}
?>