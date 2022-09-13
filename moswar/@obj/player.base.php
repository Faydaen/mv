<?php
class playerBaseObject extends Object
{
	public static $METAOBJECT = 'player';
    public static $ID_METAATTRIBUTE = 'player.id';
 	public static $ID = 'player.id';
    public $nickname = '';
    public static $NICKNAME = 'player.nickname';
    public $password = '';
    public static $PASSWORD = 'player.password';
    public $email = '';
    public static $EMAIL = 'player.email';
    public $about = '';
    public static $ABOUT = 'player.about';
    public $registeredtime = '0000-00-00 00:00:00';
    public static $REGISTEREDTIME = 'player.registeredtime';
    public $lastactivitytime = '0000-00-00 00:00:00';
    public static $LASTACTIVITYTIME = 'player.lastactivitytime';
    public $fraction = '';
    public $fraction_Dictionary = array('resident','arrived');
    public static $FRACTION = 'player.fraction';
    public $avatar = '';
    public static $AVATAR = 'player.avatar';
    public $background = '';
    public static $BACKGROUND = 'player.background';
    public $sex = '';
    public $sex_Dictionary = array('male','female');
    public static $SEX = 'player.sex';
    public $clan = 0;
    public static $CLAN = 'player.clan';
    public $clan_status = '';
    public $clan_status_Dictionary = array('accepted','recruit','founder','adviser','diplomat','money','forum','people');
    public static $CLAN_STATUS = 'player.clan_status';
    public $level = 0;
    public static $LEVEL = 'player.level';
    public $skill = 0;
    public static $SKILL = 'player.skill';
    public $exp = 0;
    public static $EXP = 'player.exp';
    public $status = '';
    public $status_Dictionary = array('online','offline');
    public static $STATUS = 'player.status';
    public $playboy = 0;
    public static $PLAYBOY = 'player.playboy';
    public $state = '';
    public static $STATE = 'player.state';
    public $timer = 0;
    public static $TIMER = 'player.timer';
    public $orechance = 0;
    public static $ORECHANCE = 'player.orechance';
    public $maxhp = 0;
    public static $MAXHP = 'player.maxhp';
    public $health = 0;
    public static $HEALTH = 'player.health';
    public $strength = 0;
    public static $STRENGTH = 'player.strength';
    public $dexterity = 0;
    public static $DEXTERITY = 'player.dexterity';
    public $intuition = 0;
    public static $INTUITION = 'player.intuition';
    public $resistance = 0;
    public static $RESISTANCE = 'player.resistance';
    public $attention = 0;
    public static $ATTENTION = 'player.attention';
    public $charism = 0;
    public static $CHARISM = 'player.charism';
    public $health_bonus = 0;
    public static $HEALTH_BONUS = 'player.health_bonus';
    public $strength_bonus = 0;
    public static $STRENGTH_BONUS = 'player.strength_bonus';
    public $dexterity_bonus = 0;
    public static $DEXTERITY_BONUS = 'player.dexterity_bonus';
    public $intuition_bonus = 0;
    public static $INTUITION_BONUS = 'player.intuition_bonus';
    public $resistance_bonus = 0;
    public static $RESISTANCE_BONUS = 'player.resistance_bonus';
    public $attention_bonus = 0;
    public static $ATTENTION_BONUS = 'player.attention_bonus';
    public $charism_bonus = 0;
    public static $CHARISM_BONUS = 'player.charism_bonus';
    public $health_percent = 0;
    public static $HEALTH_PERCENT = 'player.health_percent';
    public $strength_percent = 0;
    public static $STRENGTH_PERCENT = 'player.strength_percent';
    public $dexterity_percent = 0;
    public static $DEXTERITY_PERCENT = 'player.dexterity_percent';
    public $intuition_percent = 0;
    public static $INTUITION_PERCENT = 'player.intuition_percent';
    public $resistance_percent = 0;
    public static $RESISTANCE_PERCENT = 'player.resistance_percent';
    public $attention_percent = 0;
    public static $ATTENTION_PERCENT = 'player.attention_percent';
    public $charism_percent = 0;
    public static $CHARISM_PERCENT = 'player.charism_percent';
    public $health_finish = 0;
    public static $HEALTH_FINISH = 'player.health_finish';
    public $strength_finish = 0;
    public static $STRENGTH_FINISH = 'player.strength_finish';
    public $dexterity_finish = 0;
    public static $DEXTERITY_FINISH = 'player.dexterity_finish';
    public $intuition_finish = 0;
    public static $INTUITION_FINISH = 'player.intuition_finish';
    public $resistance_finish = 0;
    public static $RESISTANCE_FINISH = 'player.resistance_finish';
    public $attention_finish = 0;
    public static $ATTENTION_FINISH = 'player.attention_finish';
    public $charism_finish = 0;
    public static $CHARISM_FINISH = 'player.charism_finish';
    public $statsum = 0;
    public static $STATSUM = 'player.statsum';
    public $home_defence = 0;
    public static $HOME_DEFENCE = 'player.home_defence';
    public $home_comfort = 0;
    public static $HOME_COMFORT = 'player.home_comfort';
    public $home_price = 0;
    public static $HOME_PRICE = 'player.home_price';
    public $lastfight = 0;
    public static $LASTFIGHT = 'player.lastfight';
    public $money = 0;
    public static $MONEY = 'player.money';
    public $honey = 0;
    public static $HONEY = 'player.honey';
    public $ore = 0;
    public static $ORE = 'player.ore';
    public $suspicion = 0;
    public static $SUSPICION = 'player.suspicion';
    public $patrol_time = 0;
    public static $PATROL_TIME = 'player.patrol_time';
    public $relations_time = 0;
    public static $RELATIONS_TIME = 'player.relations_time';
    public $playboytime = 0;
    public static $PLAYBOYTIME = 'player.playboytime';
    public $referer = '';
    public static $REFERER = 'player.referer';
    public $chat_time = 0;
    public static $CHAT_TIME = 'player.chat_time';
    public $is_home_available = 0;
    public static $IS_HOME_AVAILABLE = 'player.is_home_available';
    public $accesslevel = 0;
    public static $ACCESSLEVEL = 'player.accesslevel';
    public $gateseen = 0;
    public static $GATESEEN = 'player.gateseen';
    public $mute_forum = 0;
    public static $MUTE_FORUM = 'player.mute_forum';
    public $mute_phone = 0;
    public static $MUTE_PHONE = 'player.mute_phone';
    public $respect = 0;
    public static $RESPECT = 'player.respect';
    public $clan_title = '';
    public static $CLAN_TITLE = 'player.clan_title';
    public $access = array();
    public static $ACCESS = 'player.access';
    public $stateparam = '';
    public static $STATEPARAM = 'player.stateparam';
    public $forum_avatar = 0;
    public static $FORUM_AVATAR = 'player.forum_avatar';
    public $forum_avatar_checked = 0;
    public static $FORUM_AVATAR_CHECKED = 'player.forum_avatar_checked';
    public $forum_show_useravatars = 0;
    public static $FORUM_SHOW_USERAVATARS = 'player.forum_show_useravatars';
    public $state2 = '';
    public static $STATE2 = 'player.state2';
    public $flag_bonus = 0;
    public static $FLAG_BONUS = 'player.flag_bonus';
    public $mute_chat = 0;
    public static $MUTE_CHAT = 'player.mute_chat';
    public $ratingcrit = 0;
    public static $RATINGCRIT = 'player.ratingcrit';
    public $ratingdodge = 0;
    public static $RATINGDODGE = 'player.ratingdodge';
    public $ratingresist = 0;
    public static $RATINGRESIST = 'player.ratingresist';
    public $ratingaccur = 0;
    public static $RATINGACCUR = 'player.ratingaccur';
    public $ratingdamage = 0;
    public static $RATINGDAMAGE = 'player.ratingdamage';
    public $ratinganticrit = 0;
    public static $RATINGANTICRIT = 'player.ratinganticrit';
    public $photos = 0;
    public static $PHOTOS = 'player.photos';
    public $skillmetro = 0;
    public static $SKILLMETRO = 'player.skillmetro';
    public $skilldoping = 0;
    public static $SKILLDOPING = 'player.skilldoping';
    public $skillupgrade = 0;
    public static $SKILLUPGRADE = 'player.skillupgrade';
    public $skillbazar = 0;
    public static $SKILLBAZAR = 'player.skillbazar';
    public $ip = 0;
    public static $IP = 'player.ip';
    public $oil = 0;
    public static $OIL = 'player.oil';
    public $petriks = 0;
    public static $PETRIKS = 'player.petriks';
    public $anabolics = 0;
    public static $ANABOLICS = 'player.anabolics';
    public $energy = 0;
    public static $ENERGY = 'player.energy';
    public $viptrainerdt = '0000-00-00 00:00:00';
    public static $VIPTRAINERDT = 'player.viptrainerdt';
    public $bankdt = '0000-00-00 00:00:00';
    public static $BANKDT = 'player.bankdt';
    public $rulesver = 0;
    public static $RULESVER = 'player.rulesver';
    public $master = 0;
    public static $MASTER = 'player.master';
    public $shadowmode = 0;
    public static $SHADOWMODE = 'player.shadowmode';
    public $shadowdt = '0000-00-00 00:00:00';
    public static $SHADOWDT = 'player.shadowdt';
    public $isolate_chat = 0;
    public static $ISOLATE_CHAT = 'player.isolate_chat';
    public $statsum2 = 0;
    public static $STATSUM2 = 'player.statsum2';
    public $wanted = 0;
    public static $WANTED = 'player.wanted';
    public $huntdt = '0000-00-00 00:00:00';
    public static $HUNTDT = 'player.huntdt';
    public $chatroom = '';
    public $chatroom_Dictionary = array('general','noobs','quiz','resident','arrived','male','female','fight_resident','fight_arrived','clan','union');
    public static $CHATROOM = 'player.chatroom';
    public $skillhunt = 0;
    public static $SKILLHUNT = 'player.skillhunt';
    public $viphuntdt = 0;
    public static $VIPHUNTDT = 'player.viphuntdt';
    public $skillgranata = 0;
    public static $SKILLGRANATA = 'player.skillgranata';
    public $komplekt = 0;
    public static $KOMPLEKT = 'player.komplekt';
    public $antirabbitdt = '0000-00-00 00:00:00';
    public static $ANTIRABBITDT = 'player.antirabbitdt';
    public $lasttimeattacked = 0;
    public static $LASTTIMEATTACKED = 'player.lasttimeattacked';
    public $healtime = 0;
    public static $HEALTIME = 'player.healtime';
    public $chip = 0;
    public static $CHIP = 'player.chip';
    public $remind_code = '';
    public static $REMIND_CODE = 'player.remind_code';
    public $casino_today_profit = 0;
    public static $CASINO_TODAY_PROFIT = 'player.casino_today_profit';
    public $homesalarytime = 0;
    public static $HOMESALARYTIME = 'player.homesalarytime';
    public $data = '';
    public static $DATA = 'player.data';

    public function __construct()
    {
        parent::__construct('player');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->nickname = '';
        $this->password = '';
        $this->email = '';
        $this->about = '';
        $this->registeredtime = '0000-00-00 00:00:00';
        $this->lastactivitytime = '0000-00-00 00:00:00';
        $this->fraction = '';
        $this->avatar = '';
        $this->background = '';
        $this->sex = '';
        $this->clan = 0;
        $this->clan_status = '';
        $this->level = 0;
        $this->skill = 0;
        $this->exp = 0;
        $this->status = '';
        $this->playboy = 0;
        $this->state = '';
        $this->timer = 0;
        $this->orechance = 0;
        $this->maxhp = 0;
        $this->health = 0;
        $this->strength = 0;
        $this->dexterity = 0;
        $this->intuition = 0;
        $this->resistance = 0;
        $this->attention = 0;
        $this->charism = 0;
        $this->health_bonus = 0;
        $this->strength_bonus = 0;
        $this->dexterity_bonus = 0;
        $this->intuition_bonus = 0;
        $this->resistance_bonus = 0;
        $this->attention_bonus = 0;
        $this->charism_bonus = 0;
        $this->health_percent = 0;
        $this->strength_percent = 0;
        $this->dexterity_percent = 0;
        $this->intuition_percent = 0;
        $this->resistance_percent = 0;
        $this->attention_percent = 0;
        $this->charism_percent = 0;
        $this->health_finish = 0;
        $this->strength_finish = 0;
        $this->dexterity_finish = 0;
        $this->intuition_finish = 0;
        $this->resistance_finish = 0;
        $this->attention_finish = 0;
        $this->charism_finish = 0;
        $this->statsum = 0;
        $this->home_defence = 0;
        $this->home_comfort = 0;
        $this->home_price = 0;
        $this->lastfight = 0;
        $this->money = 0;
        $this->honey = 0;
        $this->ore = 0;
        $this->suspicion = 0;
        $this->patrol_time = 0;
        $this->relations_time = 0;
        $this->playboytime = 0;
        $this->referer = '';
        $this->chat_time = 0;
        $this->is_home_available = 0;
        $this->accesslevel = 0;
        $this->gateseen = 0;
        $this->mute_forum = 0;
        $this->mute_phone = 0;
        $this->respect = 0;
        $this->clan_title = '';
        $this->access = array();
        $this->stateparam = '';
        $this->forum_avatar = 0;
        $this->forum_avatar_checked = 0;
        $this->forum_show_useravatars = 0;
        $this->state2 = '';
        $this->flag_bonus = 0;
        $this->mute_chat = 0;
        $this->ratingcrit = 0;
        $this->ratingdodge = 0;
        $this->ratingresist = 0;
        $this->ratingaccur = 0;
        $this->ratingdamage = 0;
        $this->ratinganticrit = 0;
        $this->photos = 0;
        $this->skillmetro = 0;
        $this->skilldoping = 0;
        $this->skillupgrade = 0;
        $this->skillbazar = 0;
        $this->ip = 0;
        $this->oil = 0;
        $this->petriks = 0;
        $this->anabolics = 0;
        $this->energy = 0;
        $this->viptrainerdt = '0000-00-00 00:00:00';
        $this->bankdt = '0000-00-00 00:00:00';
        $this->rulesver = 0;
        $this->master = 0;
        $this->shadowmode = 0;
        $this->shadowdt = '0000-00-00 00:00:00';
        $this->isolate_chat = 0;
        $this->statsum2 = 0;
        $this->wanted = 0;
        $this->huntdt = '0000-00-00 00:00:00';
        $this->chatroom = '';
        $this->skillhunt = 0;
        $this->viphuntdt = 0;
        $this->skillgranata = 0;
        $this->komplekt = 0;
        $this->antirabbitdt = '0000-00-00 00:00:00';
        $this->lasttimeattacked = 0;
        $this->healtime = 0;
        $this->chip = 0;
        $this->remind_code = '';
        $this->casino_today_profit = 0;
        $this->homesalarytime = 0;
        $this->data = '';
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
        $this->nickname = $object['nickname'];
        $this->password = $object['password'];
        $this->email = $object['email'];
        $this->about = $object['about'];
        $this->registeredtime = $object['registeredtime'];
        $this->lastactivitytime = $object['lastactivitytime'];
        $this->fraction = $object['fraction'];
        $this->avatar = $object['avatar'];
        $this->background = $object['background'];
        $this->sex = $object['sex'];
        $this->clan = $object['clan'];
        $this->clan_status = $object['clan_status'];
        $this->level = $object['level'];
        $this->skill = $object['skill'];
        $this->exp = $object['exp'];
        $this->status = $object['status'];
        $this->playboy = $object['playboy'];
        $this->state = $object['state'];
        $this->timer = $object['timer'];
        $this->orechance = $object['orechance'];
        $this->maxhp = $object['maxhp'];
        $this->health = $object['health'];
        $this->strength = $object['strength'];
        $this->dexterity = $object['dexterity'];
        $this->intuition = $object['intuition'];
        $this->resistance = $object['resistance'];
        $this->attention = $object['attention'];
        $this->charism = $object['charism'];
        $this->health_bonus = $object['health_bonus'];
        $this->strength_bonus = $object['strength_bonus'];
        $this->dexterity_bonus = $object['dexterity_bonus'];
        $this->intuition_bonus = $object['intuition_bonus'];
        $this->resistance_bonus = $object['resistance_bonus'];
        $this->attention_bonus = $object['attention_bonus'];
        $this->charism_bonus = $object['charism_bonus'];
        $this->health_percent = $object['health_percent'];
        $this->strength_percent = $object['strength_percent'];
        $this->dexterity_percent = $object['dexterity_percent'];
        $this->intuition_percent = $object['intuition_percent'];
        $this->resistance_percent = $object['resistance_percent'];
        $this->attention_percent = $object['attention_percent'];
        $this->charism_percent = $object['charism_percent'];
        $this->health_finish = $object['health_finish'];
        $this->strength_finish = $object['strength_finish'];
        $this->dexterity_finish = $object['dexterity_finish'];
        $this->intuition_finish = $object['intuition_finish'];
        $this->resistance_finish = $object['resistance_finish'];
        $this->attention_finish = $object['attention_finish'];
        $this->charism_finish = $object['charism_finish'];
        $this->statsum = $object['statsum'];
        $this->home_defence = $object['home_defence'];
        $this->home_comfort = $object['home_comfort'];
        $this->home_price = $object['home_price'];
        $this->lastfight = $object['lastfight'];
        $this->money = $object['money'];
        $this->honey = $object['honey'];
        $this->ore = $object['ore'];
        $this->suspicion = $object['suspicion'];
        $this->patrol_time = $object['patrol_time'];
        $this->relations_time = $object['relations_time'];
        $this->playboytime = $object['playboytime'];
        $this->referer = $object['referer'];
        $this->chat_time = $object['chat_time'];
        $this->is_home_available = $object['is_home_available'];
        $this->accesslevel = $object['accesslevel'];
        $this->gateseen = $object['gateseen'];
        $this->mute_forum = $object['mute_forum'];
        $this->mute_phone = $object['mute_phone'];
        $this->respect = $object['respect'];
        $this->clan_title = $object['clan_title'];
        $this->access = $object['access'];
        $this->stateparam = $object['stateparam'];
        $this->forum_avatar = $object['forum_avatar'];
        $this->forum_avatar_checked = $object['forum_avatar_checked'];
        $this->forum_show_useravatars = $object['forum_show_useravatars'];
        $this->state2 = $object['state2'];
        $this->flag_bonus = $object['flag_bonus'];
        $this->mute_chat = $object['mute_chat'];
        $this->ratingcrit = $object['ratingcrit'];
        $this->ratingdodge = $object['ratingdodge'];
        $this->ratingresist = $object['ratingresist'];
        $this->ratingaccur = $object['ratingaccur'];
        $this->ratingdamage = $object['ratingdamage'];
        $this->ratinganticrit = $object['ratinganticrit'];
        $this->photos = $object['photos'];
        $this->skillmetro = $object['skillmetro'];
        $this->skilldoping = $object['skilldoping'];
        $this->skillupgrade = $object['skillupgrade'];
        $this->skillbazar = $object['skillbazar'];
        $this->ip = $object['ip'];
        $this->oil = $object['oil'];
        $this->petriks = $object['petriks'];
        $this->anabolics = $object['anabolics'];
        $this->energy = $object['energy'];
        $this->viptrainerdt = $object['viptrainerdt'];
        $this->bankdt = $object['bankdt'];
        $this->rulesver = $object['rulesver'];
        $this->master = $object['master'];
        $this->shadowmode = $object['shadowmode'];
        $this->shadowdt = $object['shadowdt'];
        $this->isolate_chat = $object['isolate_chat'];
        $this->statsum2 = $object['statsum2'];
        $this->wanted = $object['wanted'];
        $this->huntdt = $object['huntdt'];
        $this->chatroom = $object['chatroom'];
        $this->skillhunt = $object['skillhunt'];
        $this->viphuntdt = $object['viphuntdt'];
        $this->skillgranata = $object['skillgranata'];
        $this->komplekt = $object['komplekt'];
        $this->antirabbitdt = $object['antirabbitdt'];
        $this->lasttimeattacked = $object['lasttimeattacked'];
        $this->healtime = $object['healtime'];
        $this->chip = $object['chip'];
        $this->remind_code = $object['remind_code'];
        $this->casino_today_profit = $object['casino_today_profit'];
        $this->homesalarytime = $object['homesalarytime'];
        $this->data = $object['data'];
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
            case 3:
                $this->nickname = str_replace('"', '&quot;', $_POST['nickname']);
                $this->password = str_replace('"', '&quot;', $_POST['password']);
                $this->email = str_replace('"', '&quot;', $_POST['email']);
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['registeredtime']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->registeredtime = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->fraction = $_POST['fraction'];
                $this->avatar = str_replace('"', '&quot;', $_POST['avatar']);
                $this->clan = (int) $_POST['clan'];
                $this->clan_status = $_POST['clan_status'];
                $this->level = (int) $_POST['level'];
                $this->skill = (int) $_POST['skill'];
                $this->exp = (int) $_POST['exp'];
                $this->health = (int) $_POST['health'];
                $this->strength = (int) $_POST['strength'];
                $this->dexterity = (int) $_POST['dexterity'];
                $this->intuition = (int) $_POST['intuition'];
                $this->resistance = (int) $_POST['resistance'];
                $this->attention = (int) $_POST['attention'];
                $this->charism = (int) $_POST['charism'];
                $this->money = (int) $_POST['money'];
                $this->honey = (int) $_POST['honey'];
                $this->ore = (int) $_POST['ore'];
                $this->suspicion = (int) $_POST['suspicion'];
                $this->referer = str_replace('"', '&quot;', $_POST['referer']);
                $this->accesslevel = (int) $_POST['accesslevel'];
                $this->respect = (int) $_POST['respect'];
                $this->clan_title = str_replace('"', '&quot;', $_POST['clan_title']);
                if (is_array($_POST['access']))
                {
                    foreach ($_POST['access'] as $linkedObjectId)
                    {
                        if ($linkedObjectId > 0)
                        {
                            $this->access[] = (int) $linkedObjectId;
                        }
                    }
                }
                if ($this->id)
                {
                    $imageId = $this->sql->getValue("SELECT `forum_avatar` FROM `player` WHERE id=".$this->id);
                }
                else
                {
                    $imageId = 0;
                }
                if (isset($_FILES['forum_avatar']) && $_FILES['forum_avatar']['name'] != '')
                {
                    $this->forum_avatar = $this->uploadImage('forum_avatar', $imageId);
                }
                elseif ($imageId && isset($_POST['forum_avatar-delete']))
                {
                    $this->deleteImage($imageId);
                    $this->forum_avatar = 0;
                }
                else
                {
                    $this->forum_avatar = $imageId;
                }
                $this->forum_avatar_checked = isset($_POST['forum_avatar_checked']) ? 1 : 0;
                $this->forum_show_useravatars = isset($_POST['forum_show_useravatars']) ? 1 : 0;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['lastactivitytime']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->lastactivitytime = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->state = str_replace('"', '&quot;', $_POST['state']);
                $this->stateparam = str_replace('"', '&quot;', $_POST['stateparam']);
                $this->timer = (int) $_POST['timer'];
                $this->home_defence = (int) $_POST['home_defence'];
                $this->home_comfort = (int) $_POST['home_comfort'];
                $this->home_price = (int) $_POST['home_price'];
                $this->skillmetro = (int) $_POST['skillmetro'];
                $this->skillbazar = (int) $_POST['skillbazar'];
                $this->skillupgrade = (int) $_POST['skillupgrade'];
                $this->skilldoping = (int) $_POST['skilldoping'];
                $this->health_bonus = (int) $_POST['health_bonus'];
                $this->strength_bonus = (int) $_POST['strength_bonus'];
                $this->dexterity_bonus = (int) $_POST['dexterity_bonus'];
                $this->resistance_bonus = (int) $_POST['resistance_bonus'];
                $this->intuition_bonus = (int) $_POST['intuition_bonus'];
                $this->attention_bonus = (int) $_POST['attention_bonus'];
                $this->charism_bonus = (int) $_POST['charism_bonus'];
                $this->flag_bonus = (int) $_POST['flag_bonus'];
                $this->health_percent = (int) $_POST['health_percent'];
                $this->strength_percent = (int) $_POST['strength_percent'];
                $this->dexterity_percent = (int) $_POST['dexterity_percent'];
                $this->resistance_percent = (int) $_POST['resistance_percent'];
                $this->intuition_percent = (int) $_POST['intuition_percent'];
                $this->attention_percent = (int) $_POST['attention_percent'];
                $this->charism_percent = (int) $_POST['charism_percent'];
                $this->health_finish = (int) $_POST['health_finish'];
                $this->strength_finish = (int) $_POST['strength_finish'];
                $this->dexterity_finish = (int) $_POST['dexterity_finish'];
                $this->resistance_finish = (int) $_POST['resistance_finish'];
                $this->intuition_finish = (int) $_POST['intuition_finish'];
                $this->attention_finish = (int) $_POST['attention_finish'];
                $this->charism_finish = (int) $_POST['charism_finish'];
                $this->statsum = (int) $_POST['statsum'];
                $this->ratingcrit = (double) str_replace(',', '.', $_POST['ratingcrit']);
                $this->ratingdodge = (double) str_replace(',', '.', $_POST['ratingdodge']);
                $this->ratingresist = (double) str_replace(',', '.', $_POST['ratingresist']);
                $this->ratinganticrit = (double) str_replace(',', '.', $_POST['ratinganticrit']);
                $this->ratingdamage = (double) str_replace(',', '.', $_POST['ratingdamage']);
                $this->ratingaccur = (double) str_replace(',', '.', $_POST['ratingaccur']);
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['viptrainerdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->viptrainerdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['bankdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->bankdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->sex = $_POST['sex'];
                $this->petriks = (int) $_POST['petriks'];
                $this->anabolics = (int) $_POST['anabolics'];
                $this->statsum2 = (int) $_POST['statsum2'];
                $this->energy = (int) $_POST['energy'];
                $this->playboy = isset($_POST['playboy']) ? 1 : 0;
                $this->playboytime = (int) $_POST['playboytime'];
                $this->viphuntdt = (int) $_POST['viphuntdt'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['huntdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->huntdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->wanted = isset($_POST['wanted']) ? 1 : 0;
                $this->skillhunt = (int) $_POST['skillhunt'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['antirabbitdt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->antirabbitdt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->komplekt = (int) $_POST['komplekt'];
                $this->skillgranata = (int) $_POST['skillgranata'];
                $this->chip = (int) $_POST['chip'];
                $this->oil = (int) $_POST['oil'];
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
        $object['nickname'] = $this->nickname;
        $object['password'] = $this->password;
        $object['email'] = $this->email;
        $object['about'] = $this->about;
        $object['registeredtime'] = $this->registeredtime;
        $object['lastactivitytime'] = $this->lastactivitytime;
        $object['fraction'] = $this->fraction;
        $object['avatar'] = $this->avatar;
        $object['background'] = $this->background;
        $object['sex'] = $this->sex;
        if (is_object($this->clan))
        {
            $object['clan'] = $this->clan->toArray();
        }
        else
        {
        	$object['clan'] = $this->clan;
        }
        $object['clan_status'] = $this->clan_status;
        $object['level'] = $this->level;
        $object['skill'] = $this->skill;
        $object['exp'] = $this->exp;
        $object['status'] = $this->status;
        $object['playboy'] = $this->playboy;
        $object['state'] = $this->state;
        $object['timer'] = $this->timer;
        $object['orechance'] = $this->orechance;
        $object['maxhp'] = $this->maxhp;
        $object['health'] = $this->health;
        $object['strength'] = $this->strength;
        $object['dexterity'] = $this->dexterity;
        $object['intuition'] = $this->intuition;
        $object['resistance'] = $this->resistance;
        $object['attention'] = $this->attention;
        $object['charism'] = $this->charism;
        $object['health_bonus'] = $this->health_bonus;
        $object['strength_bonus'] = $this->strength_bonus;
        $object['dexterity_bonus'] = $this->dexterity_bonus;
        $object['intuition_bonus'] = $this->intuition_bonus;
        $object['resistance_bonus'] = $this->resistance_bonus;
        $object['attention_bonus'] = $this->attention_bonus;
        $object['charism_bonus'] = $this->charism_bonus;
        $object['health_percent'] = $this->health_percent;
        $object['strength_percent'] = $this->strength_percent;
        $object['dexterity_percent'] = $this->dexterity_percent;
        $object['intuition_percent'] = $this->intuition_percent;
        $object['resistance_percent'] = $this->resistance_percent;
        $object['attention_percent'] = $this->attention_percent;
        $object['charism_percent'] = $this->charism_percent;
        $object['health_finish'] = $this->health_finish;
        $object['strength_finish'] = $this->strength_finish;
        $object['dexterity_finish'] = $this->dexterity_finish;
        $object['intuition_finish'] = $this->intuition_finish;
        $object['resistance_finish'] = $this->resistance_finish;
        $object['attention_finish'] = $this->attention_finish;
        $object['charism_finish'] = $this->charism_finish;
        $object['statsum'] = $this->statsum;
        $object['home_defence'] = $this->home_defence;
        $object['home_comfort'] = $this->home_comfort;
        $object['home_price'] = $this->home_price;
        $object['lastfight'] = $this->lastfight;
        $object['money'] = $this->money;
        $object['honey'] = $this->honey;
        $object['ore'] = $this->ore;
        $object['suspicion'] = $this->suspicion;
        $object['patrol_time'] = $this->patrol_time;
        $object['relations_time'] = $this->relations_time;
        $object['playboytime'] = $this->playboytime;
        $object['referer'] = $this->referer;
        $object['chat_time'] = $this->chat_time;
        $object['is_home_available'] = $this->is_home_available;
        $object['accesslevel'] = $this->accesslevel;
        $object['gateseen'] = $this->gateseen;
        $object['mute_forum'] = $this->mute_forum;
        $object['mute_phone'] = $this->mute_phone;
        $object['respect'] = $this->respect;
        $object['clan_title'] = $this->clan_title;
        $object['access'] = $this->access;
        $object['stateparam'] = $this->stateparam;
        $object['forum_avatar'] = $this->forum_avatar;
        $object['forum_avatar_checked'] = $this->forum_avatar_checked;
        $object['forum_show_useravatars'] = $this->forum_show_useravatars;
        $object['state2'] = $this->state2;
        $object['flag_bonus'] = $this->flag_bonus;
        $object['mute_chat'] = $this->mute_chat;
        $object['ratingcrit'] = $this->ratingcrit;
        $object['ratingdodge'] = $this->ratingdodge;
        $object['ratingresist'] = $this->ratingresist;
        $object['ratingaccur'] = $this->ratingaccur;
        $object['ratingdamage'] = $this->ratingdamage;
        $object['ratinganticrit'] = $this->ratinganticrit;
        $object['photos'] = $this->photos;
        $object['skillmetro'] = $this->skillmetro;
        $object['skilldoping'] = $this->skilldoping;
        $object['skillupgrade'] = $this->skillupgrade;
        $object['skillbazar'] = $this->skillbazar;
        $object['ip'] = $this->ip;
        $object['oil'] = $this->oil;
        $object['petriks'] = $this->petriks;
        $object['anabolics'] = $this->anabolics;
        $object['energy'] = $this->energy;
        $object['viptrainerdt'] = $this->viptrainerdt;
        $object['bankdt'] = $this->bankdt;
        $object['rulesver'] = $this->rulesver;
        if (is_object($this->master))
        {
            $object['master'] = $this->master->toArray();
        }
        else
        {
        	$object['master'] = $this->master;
        }
        $object['shadowmode'] = $this->shadowmode;
        $object['shadowdt'] = $this->shadowdt;
        $object['isolate_chat'] = $this->isolate_chat;
        $object['statsum2'] = $this->statsum2;
        $object['wanted'] = $this->wanted;
        $object['huntdt'] = $this->huntdt;
        $object['chatroom'] = $this->chatroom;
        $object['skillhunt'] = $this->skillhunt;
        $object['viphuntdt'] = $this->viphuntdt;
        $object['skillgranata'] = $this->skillgranata;
        $object['komplekt'] = $this->komplekt;
        $object['antirabbitdt'] = $this->antirabbitdt;
        $object['lasttimeattacked'] = $this->lasttimeattacked;
        $object['healtime'] = $this->healtime;
        $object['chip'] = $this->chip;
        $object['remind_code'] = $this->remind_code;
        $object['casino_today_profit'] = $this->casino_today_profit;
        $object['homesalarytime'] = $this->homesalarytime;
        $object['data'] = $this->data;
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
        if (is_object($this->clan))
        {
            $this->clan->save();
        }
        if (is_array($this->access))
        {
            for ($i=0, $j=sizeof($this->access); $i<$j; $i++)
            {
            	if (is_object($this->access[$i]))
            	{
            		$this->access[$i]->save();
            		if (!in_array($this->access[$i]->id, $this->access))
            		{
            			$this->access[] = $this->access[$i]->id;
            		}
            	}
            }
        }
        if (is_object($this->master))
        {
            $this->master->save();
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
            		$field = str_replace('player.', '', $field);
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
            	$this->sql->query("UPDATE `player".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `player".$saveMerge."` SET `nickname`='".Std::cleanString($this->nickname)."', `password`='".Std::cleanString($this->password)."', `email`='".Std::cleanString($this->email)."', `about`='".Std::cleanString($this->about)."', `registeredtime`='".Std::cleanString($this->registeredtime)."', `lastactivitytime`='".Std::cleanString($this->lastactivitytime)."', `fraction`='".Std::cleanString($this->fraction)."', `avatar`='".Std::cleanString($this->avatar)."', `background`='".Std::cleanString($this->background)."', `sex`='".Std::cleanString($this->sex)."', `clan`=".(is_object($this->clan) ? $this->clan->id : $this->clan).", `clan_status`='".Std::cleanString($this->clan_status)."', `level`=".(int)$this->level.", `skill`=".(int)$this->skill.", `exp`=".(int)$this->exp.", `status`='".Std::cleanString($this->status)."', `playboy`=".(int)$this->playboy.", `state`='".Std::cleanString($this->state)."', `timer`=".(int)$this->timer.", `orechance`=".(int)$this->orechance.", `maxhp`=".(int)$this->maxhp.", `health`=".(int)$this->health.", `strength`=".(int)$this->strength.", `dexterity`=".(int)$this->dexterity.", `intuition`=".(int)$this->intuition.", `resistance`=".(int)$this->resistance.", `attention`=".(int)$this->attention.", `charism`=".(int)$this->charism.", `health_bonus`=".(int)$this->health_bonus.", `strength_bonus`=".(int)$this->strength_bonus.", `dexterity_bonus`=".(int)$this->dexterity_bonus.", `intuition_bonus`=".(int)$this->intuition_bonus.", `resistance_bonus`=".(int)$this->resistance_bonus.", `attention_bonus`=".(int)$this->attention_bonus.", `charism_bonus`=".(int)$this->charism_bonus.", `health_percent`=".(int)$this->health_percent.", `strength_percent`=".(int)$this->strength_percent.", `dexterity_percent`=".(int)$this->dexterity_percent.", `intuition_percent`=".(int)$this->intuition_percent.", `resistance_percent`=".(int)$this->resistance_percent.", `attention_percent`=".(int)$this->attention_percent.", `charism_percent`=".(int)$this->charism_percent.", `health_finish`=".(int)$this->health_finish.", `strength_finish`=".(int)$this->strength_finish.", `dexterity_finish`=".(int)$this->dexterity_finish.", `intuition_finish`=".(int)$this->intuition_finish.", `resistance_finish`=".(int)$this->resistance_finish.", `attention_finish`=".(int)$this->attention_finish.", `charism_finish`=".(int)$this->charism_finish.", `statsum`=".(int)$this->statsum.", `home_defence`=".(int)$this->home_defence.", `home_comfort`=".(int)$this->home_comfort.", `home_price`=".(int)$this->home_price.", `lastfight`=".(int)$this->lastfight.", `money`=".(int)$this->money.", `honey`=".(int)$this->honey.", `ore`=".(int)$this->ore.", `suspicion`=".(int)$this->suspicion.", `patrol_time`=".(int)$this->patrol_time.", `relations_time`=".(int)$this->relations_time.", `playboytime`=".(int)$this->playboytime.", `referer`='".Std::cleanString($this->referer)."', `chat_time`=".(int)$this->chat_time.", `is_home_available`=".(int)$this->is_home_available.", `accesslevel`=".(int)$this->accesslevel.", `gateseen`=".(int)$this->gateseen.", `mute_forum`=".(int)$this->mute_forum.", `mute_phone`=".(int)$this->mute_phone.", `respect`=".(int)$this->respect.", `clan_title`='".Std::cleanString($this->clan_title)."', `stateparam`='".Std::cleanString($this->stateparam)."', `forum_avatar`=".(int)$this->forum_avatar.", `forum_avatar_checked`=".(int)$this->forum_avatar_checked.", `forum_show_useravatars`=".(int)$this->forum_show_useravatars.", `state2`='".Std::cleanString($this->state2)."', `flag_bonus`=".(int)$this->flag_bonus.", `mute_chat`=".(int)$this->mute_chat.", `ratingcrit`=".(double)$this->ratingcrit.", `ratingdodge`=".(double)$this->ratingdodge.", `ratingresist`=".(double)$this->ratingresist.", `ratingaccur`=".(double)$this->ratingaccur.", `ratingdamage`=".(double)$this->ratingdamage.", `ratinganticrit`=".(double)$this->ratinganticrit.", `photos`=".(int)$this->photos.", `skillmetro`=".(int)$this->skillmetro.", `skilldoping`=".(int)$this->skilldoping.", `skillupgrade`=".(int)$this->skillupgrade.", `skillbazar`=".(int)$this->skillbazar.", `ip`=".(int)$this->ip.", `oil`=".(int)$this->oil.", `petriks`=".(int)$this->petriks.", `anabolics`=".(int)$this->anabolics.", `energy`=".(int)$this->energy.", `viptrainerdt`='".Std::cleanString($this->viptrainerdt)."', `bankdt`='".Std::cleanString($this->bankdt)."', `rulesver`=".(int)$this->rulesver.", `master`=".(is_object($this->master) ? $this->master->id : $this->master).", `shadowmode`=".(int)$this->shadowmode.", `shadowdt`='".Std::cleanString($this->shadowdt)."', `isolate_chat`=".(int)$this->isolate_chat.", `statsum2`=".(int)$this->statsum2.", `wanted`=".(int)$this->wanted.", `huntdt`='".Std::cleanString($this->huntdt)."', `chatroom`='".Std::cleanString($this->chatroom)."', `skillhunt`=".(int)$this->skillhunt.", `viphuntdt`=".(int)$this->viphuntdt.", `skillgranata`=".(int)$this->skillgranata.", `komplekt`=".(int)$this->komplekt.", `antirabbitdt`='".Std::cleanString($this->antirabbitdt)."', `lasttimeattacked`=".(int)$this->lasttimeattacked.", `healtime`=".(int)$this->healtime.", `chip`=".(int)$this->chip.", `remind_code`='".Std::cleanString($this->remind_code)."', `casino_today_profit`=".(int)$this->casino_today_profit.", `homesalarytime`=".(int)$this->homesalarytime.", `data`='".Std::cleanString($this->data)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
                $linkToObjectsMetaAttributes = array(access);
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
            $this->id = $this->sql->insert("INSERT INTO `player".$saveMerge."` (`nickname`, `password`, `email`, `about`, `registeredtime`, `lastactivitytime`, `fraction`, `avatar`, `background`, `sex`, `clan`, `clan_status`, `level`, `skill`, `exp`, `status`, `playboy`, `state`, `timer`, `orechance`, `maxhp`, `health`, `strength`, `dexterity`, `intuition`, `resistance`, `attention`, `charism`, `health_bonus`, `strength_bonus`, `dexterity_bonus`, `intuition_bonus`, `resistance_bonus`, `attention_bonus`, `charism_bonus`, `health_percent`, `strength_percent`, `dexterity_percent`, `intuition_percent`, `resistance_percent`, `attention_percent`, `charism_percent`, `health_finish`, `strength_finish`, `dexterity_finish`, `intuition_finish`, `resistance_finish`, `attention_finish`, `charism_finish`, `statsum`, `home_defence`, `home_comfort`, `home_price`, `lastfight`, `money`, `honey`, `ore`, `suspicion`, `patrol_time`, `relations_time`, `playboytime`, `referer`, `chat_time`, `is_home_available`, `accesslevel`, `gateseen`, `mute_forum`, `mute_phone`, `respect`, `clan_title`, `stateparam`, `forum_avatar`, `forum_avatar_checked`, `forum_show_useravatars`, `state2`, `flag_bonus`, `mute_chat`, `ratingcrit`, `ratingdodge`, `ratingresist`, `ratingaccur`, `ratingdamage`, `ratinganticrit`, `photos`, `skillmetro`, `skilldoping`, `skillupgrade`, `skillbazar`, `ip`, `oil`, `petriks`, `anabolics`, `energy`, `viptrainerdt`, `bankdt`, `rulesver`, `master`, `shadowmode`, `shadowdt`, `isolate_chat`, `statsum2`, `wanted`, `huntdt`, `chatroom`, `skillhunt`, `viphuntdt`, `skillgranata`, `komplekt`, `antirabbitdt`, `lasttimeattacked`, `healtime`, `chip`, `remind_code`, `casino_today_profit`, `homesalarytime`, `data`) VALUES ('".Std::cleanString($this->nickname)."', '".Std::cleanString($this->password)."', '".Std::cleanString($this->email)."', '".Std::cleanString($this->about)."', '".Std::cleanString($this->registeredtime)."', '".Std::cleanString($this->lastactivitytime)."', '".Std::cleanString($this->fraction)."', '".Std::cleanString($this->avatar)."', '".Std::cleanString($this->background)."', '".Std::cleanString($this->sex)."', ".(is_object($this->clan) ? $this->clan->id : $this->clan).", '".Std::cleanString($this->clan_status)."', ".(int)$this->level.", ".(int)$this->skill.", ".(int)$this->exp.", '".Std::cleanString($this->status)."', ".(int)$this->playboy.", '".Std::cleanString($this->state)."', ".(int)$this->timer.", ".(int)$this->orechance.", ".(int)$this->maxhp.", ".(int)$this->health.", ".(int)$this->strength.", ".(int)$this->dexterity.", ".(int)$this->intuition.", ".(int)$this->resistance.", ".(int)$this->attention.", ".(int)$this->charism.", ".(int)$this->health_bonus.", ".(int)$this->strength_bonus.", ".(int)$this->dexterity_bonus.", ".(int)$this->intuition_bonus.", ".(int)$this->resistance_bonus.", ".(int)$this->attention_bonus.", ".(int)$this->charism_bonus.", ".(int)$this->health_percent.", ".(int)$this->strength_percent.", ".(int)$this->dexterity_percent.", ".(int)$this->intuition_percent.", ".(int)$this->resistance_percent.", ".(int)$this->attention_percent.", ".(int)$this->charism_percent.", ".(int)$this->health_finish.", ".(int)$this->strength_finish.", ".(int)$this->dexterity_finish.", ".(int)$this->intuition_finish.", ".(int)$this->resistance_finish.", ".(int)$this->attention_finish.", ".(int)$this->charism_finish.", ".(int)$this->statsum.", ".(int)$this->home_defence.", ".(int)$this->home_comfort.", ".(int)$this->home_price.", ".(int)$this->lastfight.", ".(int)$this->money.", ".(int)$this->honey.", ".(int)$this->ore.", ".(int)$this->suspicion.", ".(int)$this->patrol_time.", ".(int)$this->relations_time.", ".(int)$this->playboytime.", '".Std::cleanString($this->referer)."', ".(int)$this->chat_time.", ".(int)$this->is_home_available.", ".(int)$this->accesslevel.", ".(int)$this->gateseen.", ".(int)$this->mute_forum.", ".(int)$this->mute_phone.", ".(int)$this->respect.", '".Std::cleanString($this->clan_title)."', '".Std::cleanString($this->stateparam)."', ".(int)$this->forum_avatar.", ".(int)$this->forum_avatar_checked.", ".(int)$this->forum_show_useravatars.", '".Std::cleanString($this->state2)."', ".(int)$this->flag_bonus.", ".(int)$this->mute_chat.", ".(double)$this->ratingcrit.", ".(double)$this->ratingdodge.", ".(double)$this->ratingresist.", ".(double)$this->ratingaccur.", ".(double)$this->ratingdamage.", ".(double)$this->ratinganticrit.", ".(int)$this->photos.", ".(int)$this->skillmetro.", ".(int)$this->skilldoping.", ".(int)$this->skillupgrade.", ".(int)$this->skillbazar.", ".(int)$this->ip.", ".(int)$this->oil.", ".(int)$this->petriks.", ".(int)$this->anabolics.", ".(int)$this->energy.", '".Std::cleanString($this->viptrainerdt)."', '".Std::cleanString($this->bankdt)."', ".(int)$this->rulesver.", ".(is_object($this->master) ? $this->master->id : $this->master).", ".(int)$this->shadowmode.", '".Std::cleanString($this->shadowdt)."', ".(int)$this->isolate_chat.", ".(int)$this->statsum2.", ".(int)$this->wanted.", '".Std::cleanString($this->huntdt)."', '".Std::cleanString($this->chatroom)."', ".(int)$this->skillhunt.", ".(int)$this->viphuntdt.", ".(int)$this->skillgranata.", ".(int)$this->komplekt.", '".Std::cleanString($this->antirabbitdt)."', ".(int)$this->lasttimeattacked.", ".(int)$this->healtime.", ".(int)$this->chip.", '".Std::cleanString($this->remind_code)."', ".(int)$this->casino_today_profit.", ".(int)$this->homesalarytime.", '".Std::cleanString($this->data)."')");
            if(sizeof($this->access) > 0)
            {
                foreach ($this->access as $linkedObjectId)
                {
                    $this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES (541, {$this->id}, $linkedObjectId)");
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
			case 'nickname': return 4; break;
			case 'password': return 4; break;
			case 'email': return 4; break;
			case 'about': return 5; break;
			case 'registeredtime': return 8; break;
			case 'lastactivitytime': return 8; break;
			case 'fraction': return 15; break;
			case 'avatar': return 4; break;
			case 'background': return 4; break;
			case 'sex': return 15; break;
			case 'clan': return 13; break;
			case 'clan_status': return 15; break;
			case 'level': return 2; break;
			case 'skill': return 2; break;
			case 'exp': return 2; break;
			case 'status': return 15; break;
			case 'playboy': return 10; break;
			case 'state': return 4; break;
			case 'timer': return 2; break;
			case 'orechance': return 2; break;
			case 'maxhp': return 2; break;
			case 'health': return 2; break;
			case 'strength': return 2; break;
			case 'dexterity': return 2; break;
			case 'intuition': return 2; break;
			case 'resistance': return 2; break;
			case 'attention': return 2; break;
			case 'charism': return 2; break;
			case 'health_bonus': return 2; break;
			case 'strength_bonus': return 2; break;
			case 'dexterity_bonus': return 2; break;
			case 'intuition_bonus': return 2; break;
			case 'resistance_bonus': return 2; break;
			case 'attention_bonus': return 2; break;
			case 'charism_bonus': return 2; break;
			case 'health_percent': return 2; break;
			case 'strength_percent': return 2; break;
			case 'dexterity_percent': return 2; break;
			case 'intuition_percent': return 2; break;
			case 'resistance_percent': return 2; break;
			case 'attention_percent': return 2; break;
			case 'charism_percent': return 2; break;
			case 'health_finish': return 2; break;
			case 'strength_finish': return 2; break;
			case 'dexterity_finish': return 2; break;
			case 'intuition_finish': return 2; break;
			case 'resistance_finish': return 2; break;
			case 'attention_finish': return 2; break;
			case 'charism_finish': return 2; break;
			case 'statsum': return 2; break;
			case 'home_defence': return 2; break;
			case 'home_comfort': return 2; break;
			case 'home_price': return 2; break;
			case 'lastfight': return 2; break;
			case 'money': return 2; break;
			case 'honey': return 2; break;
			case 'ore': return 2; break;
			case 'suspicion': return 2; break;
			case 'patrol_time': return 2; break;
			case 'relations_time': return 2; break;
			case 'playboytime': return 2; break;
			case 'referer': return 4; break;
			case 'chat_time': return 2; break;
			case 'is_home_available': return 10; break;
			case 'accesslevel': return 2; break;
			case 'gateseen': return 10; break;
			case 'mute_forum': return 2; break;
			case 'mute_phone': return 2; break;
			case 'respect': return 2; break;
			case 'clan_title': return 4; break;
			case 'access': return 14; break;
			case 'stateparam': return 4; break;
			case 'forum_avatar': return 12; break;
			case 'forum_avatar_checked': return 10; break;
			case 'forum_show_useravatars': return 10; break;
			case 'state2': return 4; break;
			case 'flag_bonus': return 2; break;
			case 'mute_chat': return 2; break;
			case 'ratingcrit': return 3; break;
			case 'ratingdodge': return 3; break;
			case 'ratingresist': return 3; break;
			case 'ratingaccur': return 3; break;
			case 'ratingdamage': return 3; break;
			case 'ratinganticrit': return 3; break;
			case 'photos': return 2; break;
			case 'skillmetro': return 2; break;
			case 'skilldoping': return 2; break;
			case 'skillupgrade': return 2; break;
			case 'skillbazar': return 2; break;
			case 'ip': return 2; break;
			case 'oil': return 2; break;
			case 'petriks': return 2; break;
			case 'anabolics': return 2; break;
			case 'energy': return 2; break;
			case 'viptrainerdt': return 8; break;
			case 'bankdt': return 8; break;
			case 'rulesver': return 2; break;
			case 'master': return 13; break;
			case 'shadowmode': return 10; break;
			case 'shadowdt': return 8; break;
			case 'isolate_chat': return 2; break;
			case 'statsum2': return 2; break;
			case 'wanted': return 10; break;
			case 'huntdt': return 8; break;
			case 'chatroom': return 15; break;
			case 'skillhunt': return 2; break;
			case 'viphuntdt': return 2; break;
			case 'skillgranata': return 2; break;
			case 'komplekt': return 2; break;
			case 'antirabbitdt': return 8; break;
			case 'lasttimeattacked': return 2; break;
			case 'healtime': return 2; break;
			case 'chip': return 2; break;
			case 'remind_code': return 4; break;
			case 'casino_today_profit': return 2; break;
			case 'homesalarytime': return 2; break;
			case 'data': return 5; break;
    	}
    }
}
?>