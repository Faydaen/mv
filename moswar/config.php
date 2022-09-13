<?php
$configDb = array(
	'type'       => 'mysql',
    'host'       => '10.1.4.5',
	'user'       => 'ponaehali',
	'pwd'        => 'fGGO4N9xU',
	'db'         => 'ponaehali',
    'persistent' => true
);

$configSphinx = array(
	'type'       => 'mysql',
    'host'       => '10.1.4.2:9306',
    'persistent' => false
);

$configMongo = array(
	'host'		=>	'localhost',
	'db'	=>	'moswar'
);

$config = array(
    'advancedsecurity' => 0, // расширенные настройки безопасноститы (необходимы права на создание хранимых процедур)
    'xslt' => 1,
    'cache' => 1,
    'headerCharset' => 'utf-8',
    'errorReporting' => 0,
);

$configProject = array(
    'lang' => 'ru',
	'secretkey'	 => 'us7n@sa73&sd9as3',
);

$configWwwRoot = "/home/moswar/moswar.ru/www/";

//if (DEV_SERVER && $_COOKIE['contentico__php_errors'] == 'contentico@1') {
/*
if (isset($_COOKIE['contentico__php_errors']) && $_COOKIE['contentico__php_errors'] == 'contentico@1') {
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
} else {
	error_reporting();
	ini_set('error_reporting', 'off');
}
*/

$configWhiteLinks = array("moswar.ru", "img.moswar.ru", "forum.theabyss.ru", "youtube.com");


$data = array ();

$data['casino']['kubovich']['play_time'] = 4;

$data['project'] = $configProject;

$data['fractions']['arrived'] = 'Понаехавший';
$data['fractions']['resident'] = 'Коренной';
$data['fractions']['plural']['arrived'] = 'Понаехавшие';
$data['fractions']['plural']['resident'] = 'Коренные';

$data['classes']['girl1.png'] = array ('sex' => 'female', 'fraction' => 'resident', 'avatar' => 'girl1.png', 'title' => 'Блондинка',    'thumb' => 'girl1_thumb.png');
$data['classes']['girl2.png'] = array ('sex' => 'female', 'fraction' => 'arrived',  'avatar' => 'girl2.png', 'title' => 'Студентка',    'thumb' => 'girl2_thumb.png');
$data['classes']['girl3.png'] = array ('sex' => 'female', 'fraction' => 'arrived',  'avatar' => 'girl3.png', 'title' => 'Цыганка',      'thumb' => 'girl3_thumb.png');
$data['classes']['girl4.png'] = array ('sex' => 'female', 'fraction' => 'resident', 'avatar' => 'girl4.png', 'title' => 'Девушка',      'thumb' => 'girl4_thumb.png');
$data['classes']['girl5.png'] = array ('sex' => 'female', 'fraction' => 'resident', 'avatar' => 'girl5.png', 'title' => 'Девушка',      'thumb' => 'girl5_thumb.png');
$data['classes']['girl6.png'] = array ('sex' => 'female', 'fraction' => 'arrived',  'avatar' => 'girl6.png', 'title' => 'Девушка',      'thumb' => 'girl6_thumb.png');

$data['classes']['man1.png']  = array ('sex' => 'male',   'fraction' => 'resident', 'avatar' => 'man1.png',  'title' => 'Менеджер',     'thumb' => 'man1_thumb.png');
$data['classes']['man2.png']  = array ('sex' => 'male',   'fraction' => 'arrived',  'avatar' => 'man2.png',  'title' => 'Студент',      'thumb' => 'man2_thumb.png');
$data['classes']['man3.png']  = array ('sex' => 'male',   'fraction' => 'arrived',  'avatar' => 'man3.png',  'title' => 'Парень с юга', 'thumb' => 'man3_thumb.png');
$data['classes']['man4.png']  = array ('sex' => 'male',   'fraction' => 'resident', 'avatar' => 'man4.png',  'title' => 'Парень',       'thumb' => 'man4_thumb.png');
$data['classes']['man5.png']  = array ('sex' => 'male',   'fraction' => 'resident', 'avatar' => 'man5.png',  'title' => 'Парень',       'thumb' => 'man5_thumb.png');
$data['classes']['man6.png']  = array ('sex' => 'male',   'fraction' => 'arrived',  'avatar' => 'man6.png',  'title' => 'Парень',       'thumb' => 'man6_thumb.png');

$data['classes']['man100.png'] = array ('sex' => 'male', 'avatar' => 'man100.png', 'title' => 'Гопник',  'thumb' => 'man100_thumb.png');
$data['classes']['man101.png'] = array ('sex' => 'male', 'avatar' => 'man101.png', 'title' => 'Медведь', 'thumb' => 'man101_thumb.png');
$data['classes']['man102.png'] = array ('sex' => 'male', 'avatar' => 'man102.png', 'title' => 'Пахан',   'thumb' => 'man102_thumb.png');
$data['classes']['man103.png'] = array ('sex' => 'male', 'avatar' => 'man103.png', 'title' => 'Якудза',  'thumb' => 'man103_thumb.png');
$data['classes']['man104.png'] = array ('sex' => 'male', 'avatar' => 'man104.png', 'title' => 'Якудза',  'thumb' => 'man104_thumb.png');
$data['classes']['man105.png'] = array ('sex' => 'male', 'avatar' => 'man105.png', 'title' => 'Якудза',  'thumb' => 'man105_thumb.png');

$data['professions'][] = array ('level' => 1,  'cost_money' => 0,      'cost_ore' => 0, 'title' => 'Мойщик туалетов',        'tip' => 'мойщиком туалетов');
$data['professions'][] = array ('level' => 4,  'cost_money' => 1920,   'cost_ore' => 0, 'title' => 'Мойщик посуды',          'tip' => 'мойщиком посуды');
$data['professions'][] = array ('level' => 7,  'cost_money' => 5760,   'cost_ore' => 0, 'title' => 'Готовщик гамбургеров',   'tip' => 'готовщиком гамбургеров');
$data['professions'][] = array ('level' => 10, 'cost_money' => 15360,  'cost_ore' => 0, 'title' => 'Разносчик картошки-фри', 'tip' => 'разносчиком картошки-фри');
$data['professions'][] = array ('level' => 13, 'cost_money' => 38400,  'cost_ore' => 0, 'title' => 'Кассир',                 'tip' => 'кассиром');
$data['professions'][] = array ('level' => 16, 'cost_money' => 92160,  'cost_ore' => 0, 'title' => 'Клоун',                  'tip' => 'клоуном');
$data['professions'][] = array ('level' => 19, 'cost_money' => 215040, 'cost_ore' => 0, 'title' => 'Менеджер зала',          'tip' => 'менеджером зала');

//key = opponent level - my level
$data['expfights'][-1] = 0;
$data['expfights'][0] = 1;
$data['expfights'][1] = 2;
$data['expfights'][2] = 3;
$data['expfights'][3] = 4;
$data['expfights'][4] = 5;

$data['buildings'][1] =  array('money' => 1000,   'ore' => 100,   'bonus' => 1);
$data['buildings'][2] =  array('money' => 2000,   'ore' => 200,   'bonus' => 2);
$data['buildings'][3] =  array('money' => 4000,   'ore' => 400,   'bonus' => 4);
$data['buildings'][4] =  array('money' => 8000,   'ore' => 800,   'bonus' => 6);
$data['buildings'][5] =  array('money' => 16000,  'ore' => 1600,  'bonus' => 8);
$data['buildings'][6] =  array('money' => 32000,  'ore' => 3200,  'bonus' => 10);
$data['buildings'][7] =  array('money' => 64000,  'ore' => 6400,  'bonus' => 12);
$data['buildings'][8] =  array('money' => 128000, 'ore' => 12800, 'bonus' => 14);
$data['buildings'][9] =  array('money' => 256000, 'ore' => 25600, 'bonus' => 16);
$data['buildings'][10] = array('money' => 512000, 'ore' => 51200, 'bonus' => 18);

$data['stash'][] = array('rub' => 30,    'honey' => 10,   'label' => '30 руб. = 7 мёда + 3 бесплатно');
$data['stash'][] = array('rub' => 100,   'honey' => 34,   'label' => '100 руб. = 23 мёда + 9 бесплатно + 2 бонус');
$data['stash'][] = array('rub' => 150,   'honey' => 53,   'label' => '150 руб. = 34 мёда + 14 бесплатно + 5 бонус');
$data['stash'][] = array('rub' => 300,   'honey' => 108,  'label' => '300 руб. = 68 мёда + 28 бесплатно + 12 бонус');
$data['stash'][] = array('rub' => 500,   'honey' => 183,  'label' => '500 руб. = 114 мёда + 46 бесплатно + 23 бонус');
$data['stash'][] = array('rub' => 1000,  'honey' => 372,  'label' => '1000 руб. = 227 мёда + 93 бесплатно + 52 бонус');
$data['stash'][] = array('rub' => 1500,  'honey' => 567,  'label' => '1500 руб. = 340 мёда + 140 бесплатно + 87 бонус');
$data['stash'][] = array('rub' => 3000,  'honey' => 1152, 'label' => '3000 руб. = 680 мёда + 280 бесплатно + 192 бонус');
$data['stash'][] = array('rub' => 6000,  'honey' => 2324, 'label' => '6000 руб. = 1360 мёда + 560 бесплатно + 404 бонус');
$data['stash'][] = array('rub' => 9000,  'honey' => 3514, 'label' => '9000 руб. = 2040 мёда + 840 бесплатно + 634 бонус');
$data['stash'][] = array('rub' => 12000, 'honey' => 4724, 'label' => '12000 руб. = 2720 мёда + 1120 бесплатно + 884 бонус');
$data['stash'][] = array('rub' => 15000, 'honey' => 5952, 'label' => '15000 руб. = 3400 мёда + 1400 бесплатно + 1152 бонус');

$data['statslist'] = array('health','strength','dexterity','resistance','intuition','attention','charism');
$data['stats']['health']     = array('name' => 'Здоровье',       'l' => 'h', 'code' => 'health',     'fightName' => '',                               'ratingName' => '');
$data['stats']['strength']   = array('name' => 'Сила',           'l' => 's', 'code' => 'strength',   'fightName' => 'Увеличение урона',               'ratingName' => 'Рейтинг урона');
$data['stats']['dexterity']  = array('name' => 'Ловкость',       'l' => 'd', 'code' => 'dexterity',  'fightName' => 'Вероятность удара',              'ratingName' => 'Рейтинг точности');
$data['stats']['resistance'] = array('name' => 'Выносливость',   'l' => 'r', 'code' => 'resistance', 'fightName' => 'Увеличение защиты',              'ratingName' => 'Рейтинг защиты');
$data['stats']['intuition']  = array('name' => 'Хитрость',       'l' => 'i', 'code' => 'intuition',  'fightName' => 'Вероятность критического удара', 'ratingName' => 'Рейтинг критических ударов');
$data['stats']['attention']  = array('name' => 'Внимательность', 'l' => 'a', 'code' => 'attention',  'fightName' => 'Вероятность уворота',            'ratingName' => 'Рейтинг уворота');
$data['stats']['charism']    = array('name' => 'Харизма',        'l' => 'c', 'code' => 'charism',    'fightName' => '',                               'ratingName' => 'Рейтинг защиты от критических ударов');

$data['ratings']['ratingaccur']    = array('code' => 'ratingaccur',    'short'=> 'ra',  'name' => 'Рейтинг точности');
$data['ratings']['ratingdamage']   = array('code' => 'ratingdamage',   'short'=> 'rdm', 'name' => 'Рейтинг урона');
$data['ratings']['ratingcrit']     = array('code' => 'ratingcrit',     'short'=> 'rc',  'name' => 'Рейтинг критических ударов');
$data['ratings']['ratingdodge']    = array('code' => 'ratingdodge',    'short'=> 'rd',  'name' => 'Рейтинг уворота');
$data['ratings']['ratingresist']   = array('code' => 'ratingresist',   'short'=> 'rr',  'name' => 'Рейтинг защиты');
$data['ratings']['ratinganticrit'] = array('code' => 'ratinganticrit', 'short'=> 'rac', 'name' => 'Рейтинг защиты от критических ударов');

$data['costs']['heal'] = array('money' => 100, 'honey' => 0, 'ore' => 0);
$data['costs']['thimble'][3] = array('money' => 500);
$data['costs']['thimble'][9] = array('money' => 1500);
$data['costs']['clan']['register'] = array('money' => 5000, 'ore' => 200);
$data['costs']['clan']['change_graphic'] = array('honey' => 200, 'money' => 20000);
$data['costs']['clan']['change_name'] = array('honey' => 800, 'money' => 80000);
$data['costs']['clan']['hire_detective'] = array('honey' => 10);
$data['costs']['police']['werewolf_begin'] = array('honey' => 19);
$data['costs']['police']['werewolf_extension'] = array('honey' => 19);
$data['costs']['police']['werewolf_regeneration'] = array('honey' => 9);

$data['boosts']['god'] = array ('time' => '10m', 'type' => 'positive', 'param' => array ('type' => 'stat', 'param' => 'health', 'value' => 99));


//							   0  1   2   3   4    5    6    7    8    9     10    11    12    13    14    15    16    17    18       19
$data['exptable'] =		array (0, 16, 36, 72, 146, 262, 404, 596, 848, 1382, 1838, 2254, 3092, 4196, 5300, 6408, 7520, 1000000, 1000000, 1000000);
$data['exptable'][99] =	99999;
$data['clanexptable'] =	array (0, 9,  18, 30, 45,  63,  84,  108, 135, 165,  198,  234,  273,  315,  360, 99999);
$data['clanranks'] = array('', 'Зеваки', 'Шарашка', 'Чапаевцы', 'Шайка', 'Бюрошники', 'Банда', 'Семейка', 'Контора', 'Бригада', 'Командос', 'Мафиози', 'Картель', 'Фирмачи', 'Корпорация', 'Массонская ложа');

//                               0  1   2   3   4   5    6    7    8    9    10   11   12   13   14   15   16   17   18   19
$data['macwork_salary'] = array (0, 0, 40, 50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800, 850);


$data['diplomacy'] = array(
    'wardays' => 5,
    'maxunions' => 2,
    'unionprice' => 100,
    'kills' => 3,
);

$data['vk'] = $_SERVER['HTTP_HOST'] == 'vk.moswar.ru' ? true : false;

$data['factory'] = array(
    'upgrade' => array(
        array('a' => 0,     'b' => 9,     'p2' => 5,   'p3' => 1,    'n' => 'Стажер'),
        array('a' => 10,    'b' => 29,    'p2' => 10,  'p3' => 2,    'n' => 'Студент'),
        array('a' => 30,    'b' => 99,    'p2' => 15,  'p3' => 3,    'n' => 'Криворучкин'),
        array('a' => 100,   'b' => 249,   'p2' => 20,  'p3' => 4,    'n' => 'Разбиратель'),
        array('a' => 250,   'b' => 499,   'p2' => 25,  'p3' => 5,    'n' => 'Юннат'),
        array('a' => 500,   'b' => 749,   'p2' => 30,  'p3' => 6,    'n' => 'Эникейщик'),
        array('a' => 750,   'b' => 999,   'p2' => 35,  'p3' => 7,    'n' => 'Подмастерье'),
        array('a' => 1000,  'b' => 1499,  'p2' => 40,  'p3' => 8,    'n' => 'Слесарь'),
        array('a' => 1500,  'b' => 1999,  'p2' => 45,  'p3' => 9,    'n' => 'Самоделкин'),
        array('a' => 2000,  'b' => 2499,  'p2' => 50,  'p3' => 10,   'n' => 'Испытатель'),
        array('a' => 2500,  'b' => 2999,  'p2' => 60,  'p3' => 12.5, 'n' => 'Подрядчик'),
        array('a' => 3000,  'b' => 3499,  'p2' => 70,  'p3' => 15,   'n' => 'Аппаратчик'),
        array('a' => 3500,  'b' => 3999,  'p2' => 80,  'p3' => 20,   'n' => 'Наладчик'),
        array('a' => 4000,  'b' => 4999,  'p2' => 90,  'p3' => 25,   'n' => 'Перворазрядник'),
        array('a' => 5000,  'b' => 5999,  'p2' => 100, 'p3' => 30,   'n' => 'Кандидат в мастера'),
        array('a' => 6000,  'b' => 6999,  'p2' => 100, 'p3' => 35,   'n' => 'Мастер'),
        array('a' => 7000,  'b' => 7999,  'p2' => 100, 'p3' => 40,   'n' => 'Конструктор'),
        array('a' => 8000,  'b' => 8999,  'p2' => 100, 'p3' => 45,   'n' => 'Инженер'),
        array('a' => 9000,  'b' => 9999,  'p2' => 100, 'p3' => 50,   'n' => 'Специалист'),
        array('a' => 10000, 'b' => 10999, 'p2' => 100, 'p3' => 55,   'n' => 'Перфекционист'),
        array('a' => 11000, 'b' => 11999, 'p2' => 100, 'p3' => 60,   'n' => 'Профессионал'),
        array('a' => 12000, 'b' => 12999, 'p2' => 100, 'p3' => 65,   'n' => 'Золотые руки'),
        array('a' => 13000, 'b' => 13999, 'p2' => 100, 'p3' => 70,   'n' => 'Эксперт'),
        array('a' => 14000, 'b' => 14999, 'p2' => 100, 'p3' => 75,   'n' => 'Рационализатор'),
        array('a' => 15000, 'b' => 15999, 'p2' => 100, 'p3' => 80,   'n' => 'Левша'),
        array('a' => 16000, 'b' => 16999, 'p2' => 100, 'p3' => 85,   'n' => 'Ювелир'),
        array('a' => 17000, 'b' => 17999, 'p2' => 100, 'p3' => 90,   'n' => 'Кулибин'),
        array('a' => 18000, 'b' => 18999, 'p2' => 100, 'p3' => 95,   'n' => 'Изобретатель'),
        array('a' => 19000, 'b' => 19999, 'p2' => 100, 'p3' => 100,  'n' => 'Великий изобретатель'),
    ),
    'mfprice' => array('3','4','5','6','7','8','9','10','12','15','19','24','30','37','45','54','64','75','87','100','114','129','145','162','180','199','219','240','262','285','309','334','360','387','415','444','474','505','537','570'),
);

$data['huntclub'] = array(
    'price' => 14,
    'viporderprice' => 5, // руды/меда
    'privateorderprice' => 5, // меда
    'openprice' => 5, // меда
    'badgesforkill' => array(1, 3, 5, 7), // штук за убийство -1 урвень, свой уровень, +1 уровень
    'mobilkaforkill' => array(0, 10, 30, 50), // вероятность получить в процентах при убийстве -1 уровень, свой уровень, +1 уровень
    "rangs" => array(
        array("a" => 0,      "b" => 9,      "n" => "Салага"),
        array("a" => 10,     "b" => 19,     "n" => "Новичок"),
        array("a" => 20,     "b" => 39,     "n" => "Ищейка"),
        array("a" => 40,     "b" => 59,     "n" => "Бывалый"),
        array("a" => 60,     "b" => 79,     "n" => "Сталкер"),
        array("a" => 80,     "b" => 99,     "n" => "Бандит"),
        array("a" => 100,    "b" => 129,    "n" => "Следопыт"),
        array("a" => 130,    "b" => 159,    "n" => "Подрывник"),
        array("a" => 160,    "b" => 189,    "n" => "Особист"),
        array("a" => 190,    "b" => 219,    "n" => "Снайпер"),
        array("a" => 220,    "b" => 249,    "n" => "Бешеный пёс"),
        array("a" => 250,    "b" => 299,    "n" => "Гост-бастер"),
        array("a" => 300,    "b" => 349,    "n" => "Хельсинг"),
        array("a" => 350,    "b" => 399,    "n" => "Убивашка"),
        array("a" => 400,    "b" => 449,    "n" => "Ниндзя"),
        array("a" => 450,    "b" => 499,    "n" => "Лаки-Хантер"),
        array("a" => 500,    "b" => 599,    "n" => "Ассасин"),
        array("a" => 600,    "b" => 699,    "n" => "Google-man"),
        array("a" => 700,    "b" => 799,    "n" => "Апач"),
        array("a" => 800,    "b" => 899,    "n" => "Раскольников"),
        array("a" => 900,    "b" => 9999,   "n" => "VIP-Охотник"),
        array("a" => 10000,  "b" => 99999,  "n" => "Герой"),
        array("a" => 100000, "b" => 999999, "n" => "Супер-Герой"),
    ),
);

$data["groupfights"] = array(
    "winnersidestars" => 1, // звезд игрокам на выигравшей стороне
    "winnerbeststars" => 1, // дополнительно звезд лучшим игрокам
    "slots" => 3,
    "slotsviphunt" => 4,
    "itemsinslot" => 3,
    "itemsinslotviphunt" => 4,
    "skillgranata" => array(
        array("a" => 0,      "b" => 9,      "n" => "Рядовой"),
        array("a" => 10,     "b" => 19,     "n" => "Ефрейтор"),
        array("a" => 20,     "b" => 39,     "n" => "Мл. сержант"),
        array("a" => 40,     "b" => 59,     "n" => "Сержант"),
        array("a" => 60,     "b" => 79,     "n" => "Ст. сержант"),
        array("a" => 80,     "b" => 99,     "n" => "Старшина"),
        array("a" => 100,    "b" => 129,    "n" => "Мл. лейтенант"),
        array("a" => 130,    "b" => 159,    "n" => "Лейтенант"),
        array("a" => 160,    "b" => 189,    "n" => "Ст. лейтенант"),
        array("a" => 190,    "b" => 219,    "n" => "Капитан"),
        array("a" => 220,    "b" => 249,    "n" => "Майор"),
        array("a" => 250,    "b" => 299,    "n" => "Подполковник"),
        array("a" => 300,    "b" => 349,    "n" => "Полковник"),
        array("a" => 350,    "b" => 399,    "n" => "Генерал-майор"),
        array("a" => 400,    "b" => 449,    "n" => "Генерал-лейтенант"),
        array("a" => 450,    "b" => 499,    "n" => "Генерал-полковник"),
        array("a" => 500,    "b" => 599,    "n" => "Генерал"),
        array("a" => 600,    "b" => 699,    "n" => "Маршал"),
        array("a" => 700,    "b" => 799,    "n" => "Мастер спорта"),
        array("a" => 800,    "b" => 899,    "n" => "Гренадёр-затейник"),
        array("a" => 900,    "b" => 999,   	"n" => "Террорист-бессмертник"),
        array("a" => 1000,  "b" => 1499,  	"n" => "Повелитель взрывов"),
        array("a" => 1500, 	"b" => 2000, 	"n" => "Брат Админа"),
    ),                                             
    "skillgranatamax" => 2000,
    "skillgranatamax2" => 300,
);

$data["inventory"] = array(
    "itemsinslot" => 20,
);

$data["duels"] = array(
    "combo" => array(
        /**
         * если value < 1, то это значение в процентах, где 0.1 = 100%, 0.001 = 1%
         * cooldown - кол-во ходов для (пере)зарядки приема
         * типы:
         *      adddamage - добавить урон к текущему удару, если удар проходит
         *      blockdamage - блокировать часть урона, если по тебе проходит удар
         *
         *  не сделано:
         *      heal - восстановить жизни
         *      reflectdamage - отразить часть урона на врага
         */
		'1'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 15, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 15, 'cooldown' => 3),
        ),
		'2'  => array(
            'm' => array('action' => 'adddamage', 'value' => 23, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 23, 'cooldown' => 3),
        ),
		'3'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 34, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 34, 'cooldown' => 3),
        ),
		'4'  => array(
            'm' => array('action' => 'adddamage', 'value' => 51, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 51, 'cooldown' => 3),
        ),
		'5'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 76, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 76, 'cooldown' => 3),
        ),
		'6'  => array(
            'm' => array('action' => 'adddamage', 'value' => 114, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 114, 'cooldown' => 3),
        ),
		'7'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 171, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 171, 'cooldown' => 3),
        ),
		'8'  => array(
            'm' => array('action' => 'adddamage', 'value' => 256, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 256, 'cooldown' => 3),
        ),
		'9'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 384, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 384, 'cooldown' => 3),
        ),
		'10'  => array(
            'm' => array('action' => 'adddamage', 'value' => 576, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 576, 'cooldown' => 3),
        ),
		'11'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 865, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 865, 'cooldown' => 3),
        ),
		'12'  => array(
            'm' => array('action' => 'adddamage', 'value' => 1298, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 1298, 'cooldown' => 3),
        ),
		'13'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 1946, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 1946, 'cooldown' => 3),
        ),
		'14'  => array(
            'm' => array('action' => 'adddamage', 'value' => 2919, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 2919, 'cooldown' => 3),
        ),
		
		'15'  => array(
            'm' => array('action' => 'blockdamage', 'value' => 4380, 'cooldown' => 3),
            'f' => array('action' => 'blockdamage', 'value' => 4380, 'cooldown' => 3),
        ),
		'16'  => array(
            'm' => array('action' => 'adddamage', 'value' => 4380, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 4380, 'cooldown' => 3),
        ),
		
		'17'  => array(
            'm' => array('action' => 'adddamage', 'value' => 5250, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 5250, 'cooldown' => 3),
        ),
		
		'18'  => array(
            'm' => array('action' => 'adddamage', 'value' => 6300, 'cooldown' => 3),
            'f' => array('action' => 'adddamage', 'value' => 6300, 'cooldown' => 3),
        ),
		
        //...
    ),
);

$data['duels']['weapons'] = array(
	array('category' => 'throwing', 'weapons' => 1),
	array('category' => 'throwitem', 'weapons' => 1),
	array('category' => 'pistol', 'weapons' => 3),
	array('category' => 'gun', 'weapons' => 2),
	array('category' => 'fist', 'weapons' => 10),
	array('category' => 'onehand', 'weapons' => 10),
	array('category' => 'twohand', 'weapons' => 4),
	array('category' => 'knife', 'weapons' => 10)
);

$data["monya"] = array(
    "price2" => 500,
    "price9" => 1500,
);

$data["bank"] = array(
    "money2ore" => 750,
);

$data["home"] = array(
    "antirabbit3" => 10,
    "antirabbit7" => 25,
);

$data["sovet"] = array(
    "memberminlevel" => 9,
    "voteminlevel" => 5, // за советников
    "voteminlevel2" => 2, // за район
    "memberscount" => 20,
    "npcduels" => 5000000,
    "step1k" => 40, // 40% от победы
    "step2k" => 60, // 60% от победы
    "boostvotes" => 5,
    "minadv" => 0.01, // минимально преимущество по очкам в процентах для захвата района
    "day4prize" => array(10, 30, 60),
    "day5prize" => array(1, 3, 6),
);


$data["automobile_bring_up"]["time"][] = array("count" => 0, "base" => 15);
$data["automobile_bring_up"]["time"][] = array("count" => 160, "base" => 30);
$data["automobile_bring_up"]["time"][] = array("count" => 400, "base" => 60);

$data["automobile_bring_up"]["luck"] = 85;

$data["automobile_bring_up"]["max"][0] = 160;
$data["automobile_bring_up"]["max"][1] = 400;
$data["automobile_bring_up"]["max"][2] = 640;

$data["automobile_bring_up"]["passenger"][] = array("count" => 0, "type" => 1);
$data["automobile_bring_up"]["passenger"][] = array("count" => 16, "type" => 2);
$data["automobile_bring_up"]["passenger"][] = array("count" => 21, "type" => 3);
$data["automobile_bring_up"]["passenger"][] = array("count" => 26, "type" => 4);

$data["automobile_bring_up"]["bonus"] = array(
	1 => array(
			array("type" => "give_item", "item" => "box_b1"),
		),
	2 => array(
			array("type" => "give_item", "item" => "box_b2"),
		),
	3 => array(
			array("type" => "give_item", "item" => "box_b3"),
	)
);

$data['clan']['upgrades_ratings'] = array(1, 2, 3, 4, 7, 10, 13, 16, 20, 25, 30);

$data['metro']['bonuses'] = array(
	'cert_mf_2' => array('title' => 'Сертификат на модификацию (2 шт.)', 'actions' => array(array('type' => 'give_item', 'item' => 'factory_kupon', 'amount' => 2))),
	'chocolate' => array('title' => 'Конфета', 'actions' => array(
		array('type' => 'give_item', 'item' => array('chocolate_s1', 'chocolate_s2', 'chocolate_s3', 'chocolate_s7', 'chocolate_s8', 'chocolate_s9'), 'name' => 'Случайная конфета', 'conditions' => array(array('type' => 'max_level', 'value' => 3))), // 1-3
		array('type' => 'give_item', 'item' => array('chocolate_m1', 'chocolate_m2', 'chocolate_m3', 'chocolate_m7', 'chocolate_m8', 'chocolate_m9'), 'name' => 'Случайная конфета', 'conditions' => array(array('type' => 'min_level', 'value' => 4), array('type' => 'max_level', 'value' => 6))), // 4-6
		array('type' => 'give_item', 'item' => array('chocolate_l1', 'chocolate_l2', 'chocolate_l3', 'chocolate_l7', 'chocolate_l8', 'chocolate_l9'), 'name' => 'Случайная конфета', 'conditions' => array(array('type' => 'min_level', 'value' => 7))), // 7+
	)),
	'gum_buyable' => array('title' => 'Жвачка', 'actions' => array(
		array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
		array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
		array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
		array('type' => 'give_item', 'item' => array(556,557,558,559,560,561), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
		array('type' => 'give_item', 'item' => array(799,800,801,802,803,804), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
		array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
	)),
	'gum_buyable_www' => array('title' => 'Жвачка', 'actions' => array(
		array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
		array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
		array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
		array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
		array('type' => 'give_item', 'item' => array(750,751,752,753,754,755), 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12))), // 12+
	)),
	'gum' => array('title' => 'Жвачка', 'actions' => array(array('type' => 'give_item', 'item' => array(842, 843, 844, 845, 846, 847), 'name' => 'Случайная жвачка'))),
	'star' => array('title' => 'Звезда', 'actions' => array(array('type' => 'give_item', 'item' => 'fight_star'))),
	'patrol_money_25' => array('title' => 'Увеличение дохода с патруля', 'actions' => array(array('type' => 'set_bonus', 'bonus' => 'patrol_salary_25'))),
	'patrol_money_50' => array('title' => 'Большое увеличение дохода с патруля', 'actions' => array(array('type' => 'set_bonus', 'bonus' => 'patrol_salary_50'))),
	'cert_monya' => array('title' => 'Билетик к Моне Шацу', 'actions' => array(array('type' => 'give_item', 'item' => 'monya_ticket'))),
	'ruda_1' => array('title' => 'Руда', 'actions' => array(array('type' => 'ore', 'ore' => '1'))),
	'ruda_2' => array('title' => 'Руда (2 шт.)', 'actions' => array(array('type' => 'ore', 'ore' => '2'))),
	'ruda_3' => array('title' => 'Руда (3 шт.)', 'actions' => array(array('type' => 'ore', 'ore' => '3'))),
	'mobile' => array('title' => 'Мобилка', 'actions' => array(array('type' => 'give_item', 'item' => 'huntclub_mobile'))),
	'cert_attack' => array('title' => 'Лицензия наемника', 'actions' => array(array('type' => 'give_item', 'item' => 'docs_naemnik'))),
	'petrik_1' => array('title' => 'Нано-петрики', 'actions' => array(array('type' => 'petriks', 'petriks' => '1'))),
	'petrik_2' => array('title' => 'Нано-петрики (2 шт.)', 'actions' => array(array('type' => 'petriks', 'petriks' => '2'))),
	'petrik_3' => array('title' => 'Нано-петрики (3 шт.)', 'actions' => array(array('type' => 'petriks', 'petriks' => '3'))),
	'cert_werevolf' => array('title' => 'Погоны', 'actions' => array(array('type' => 'give_item', 'item' => 'shoulderstrap'))),
	'berezka_food' => array('title' => 'Фаст-фуд из березки', 'actions' => array(array('type' => 'give_item', 'item' => array('fightfood_burger', 'fightfood_pizza', 'fightfood_royal', 'fightfood_hotdog'), 'name' => 'Фаст-фуд из березки'))),
	'berezka_grenade' => array('title' => 'Граната из березки', 'actions' => array(array('type' => 'give_item', 'item' => array('fight_granata', 'fight_granata2', 'fight_granata3', 'fight_granata4'), 'name' => 'Граната из березки'))),
	'chance_korovan' => array('title' => 'Увеличение шанса встречи с корованом', 'actions' => array(array('type' => 'set_bonus', 'bonus' => 'caravan_probability'))),
	'chance_collection' => array('title' => 'Увеличение шанса получить элемент коллекции', 'actions' => array(array('type' => 'set_bonus', 'bonus' => 'collection_probability'))),
);

$data['metro']['reward']['<5']['duels'] = array(
	1 => array(
			array('type' => 'give_item', 'item' => 'fight_star'),
			array('type' => 'money', 'money' => 500)
		),
	2 => array(
			array('type' => 'give_item', 'item' => 'fight_granata', 'amount' => 2),
			array('type' => 'money', 'money' => 1500)
		),
	3 => array(
			array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)),
			array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)),
			array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808))
	)
);
$data['metro']['reward']['>=5']['duels'] = array(
	1 => array(
			array('type' => 'give_item', 'item' => 'box1'),
			array('type' => 'money', 'money' => 500, 'k' => 'level')
		),
	2 => array(
			array('type' => 'give_item', 'item' => 'box2'),
			array('type' => 'give_item', 'item' => 'fight_star', 'amount' => 2)
		),
	3 => array(
			array('type' => 'give_item', 'item' => 'box3'),
			array('type' => 'give_item', 'item' => 'huntclub_mobile')
		)
);

$data['metro']['reward']['<5']['fights'] = array(
	1 => array(
			array('type' => 'give_item', 'item' => 'fight_star'),
			array('type' => 'money', 'money' => 500)
		),
	2 => array(
			array('type' => 'give_item', 'item' => 'fight_granata', 'amount' => 2),
			array('type' => 'money', 'money' => 1500)
		),
	3 => array(
			array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)),
			array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)),
			array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808))
	)
);
$data['metro']['reward']['>=5']['fights'] = array(
	1 => array(
			array('type' => 'give_item', 'item' => 'box4'),
			array('type' => 'money', 'money' => 500, 'k' => 'level')
		),
	2 => array(
			array('type' => 'give_item', 'item' => 'box5'),
			array('type' => 'give_item', 'item' => 'fight_star', 'amount' => 2)
		),
	3 => array(
			array('type' => 'give_item', 'item' => 'box6'),
			array('type' => 'give_item', 'item' => 'huntclub_mobile')
		)
);

$data['metro']['weekly_reward'] = array(
	1 => array('type' => 'exp', 'exp' => 5),
	2 => array('type' => 'ore', 'ore' => 3),
	3 => array('type' => 'give_item', 'item' => 'chocolates_11'),
	4 => array('type' => 'anabolics', 'anabolics' => 100),
	5 => array('type' => 'give_item', 'item' => 'stat_stimulator')
);

$data['nightclub']['backgrounds'] = array(
	// 'conditions' => array(array('type' => 'min_level', 'level' => 1), array('type' => 'major'), array('type' => 'relations'), array('type' => 'huntclub'), array('type' => 'viptrainer'))
	7 => array('money' => 0, 'ore' => 5, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 1))),
	8 => array('money' => 0, 'ore' => 5, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 2))),
	9 => array('money' => 0, 'ore' => 0, 'honey' => 5, 'conditions' => array(array('type' => 'min_level', 'level' => 3))),
	10 => array('money' => 0, 'ore' => 10, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 4))),
	18 => array('money' => 0, 'ore' => 0, 'honey' => 10, 'conditions' => array(array('type' => 'min_level', 'level' => 5))), // kover
	12 => array('money' => 0, 'ore' => 99, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 6))),
	13 => array('money' => 0, 'ore' => 0, 'honey' => 15, 'conditions' => array(array('type' => 'min_level', 'level' => 7))),
	14 => array('money' => 0, 'ore' => 25, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 8))),
	15 => array('money' => 0, 'ore' => 0, 'honey' => 20, 'conditions' => array(array('type' => 'min_level', 'level' => 9))),
	16 => array('money' => 0, 'ore' => 50, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 10))),
	17 => array('money' => 0, 'ore' => 0, 'honey' => 35, 'conditions' => array(array('type' => 'min_level', 'level' => 11))), // airport
	11 => array('money' => 0, 'ore' => 35, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 12))), // disco
	19 => array('money' => 0, 'ore' => 0, 'honey' => 99, 'conditions' => array(array('type' => 'min_level', 'level' => 13))), // car
	20 => array('money' => 0, 'ore' => 45, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 14))), // fishes
	22 => array('money' => 0, 'ore' => 0, 'honey' => 50, 'conditions' => array(array('type' => 'min_level', 'level' => 15))), // popstar
	25 => array('money' => 0, 'ore' => 10, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 2))), // ny
	26 => array('money' => 0, 'ore' => 60, 'honey' => 0, 'conditions' => array(array('type' => 'min_level', 'level' => 17))) // popstar
);

$data['reward']['wins_on_level'][1][1] = array(array('type' => 'give_item', 'item' => 'cert_major_3d'), 'duellogtext' => "За свою первую победу <b>%winner%</b> награждается <b>Сертификатом Мажорика</b>, за который можно получить 3-х дневное мажорство в <a href=\"/stash/#cert_major_3d\">Заначке</a>.", array('type' => 'send_log', 'type' => 'item_got', 'params' => array("logtext" => "Вы получаете Сертификат мажорика. <a href=\"/stash/#cert_major_3d\">Воспользовавшись</a> им, вы можете получить статус мажора на 3 дня.")));

$data["neft"] = array("npc" => array(
        0  => array("m" => 0, 				"n" => 0),
        1  => array("m" => 100, 			"n" => 10),
        2  => array("m" => 200, 			"n" => 10),
        3  => array("m" => 0, 	"o" => 1, 	"n" => 10),
        4  => array("m" => 100, "o" => 1, 	"n" => 10),
        5  => array("m" => 200, "o" => 1, 	"n" => 10),
        6  => array("m" => 300, "o" => 1, 	"n" => 10),
        7  => array("m" => 0, 	"o" => 2, 	"n" => 10),
        8  => array("m" => 100, "o" => 2, 	"n" => 10),
        9  => array("m" => 200, "o" => 2, 	"n" => 10),
        10 => array("m" => 300, "o" => 2, 	"n" => 10),
        11 => array("m" => 0, 	"o" => 3, 	"n" => 10),
        12 => array("m" => 100, "o" => 3, 	"n" => 10),
        13 => array("m" => 200, "o" => 3, 	"n" => 10),
        14 => array("m" => 300, "o" => 3, 	"n" => 10),
        15 => array("m" => 500, "o" => 3, 	"n" => 10),
        16 => array("m" => 1000,"o" => 3, 	"n" => 20),
    ), 
    "collections" => array(31), // ахтунг, настроено на DEV-SERVER
    "nowprice" => 2,
);


// hours                                                                                                1h                                     2h                            3h                            4h
// level                                   1  2  3  4  5  6  7  8   9   10  11  12  13  14  15  16  17  18  19  20  21  22  23  24  25   26   27   28   29   30   31   32   33   34   35   36   37   38   39   40
$data['pets']['train_time']		= array(0, 1, 2, 3, 4, 5, 6, 8, 10, 12, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200, 210, 220, 230, 240);
$data['pets']['restore_cost']	= array(0, 2, 3, 4, 5, 6, 7, 8, 9,  10, 12, 15, 20, 25, 30, 35, 40, 45, 50, 65, 70, 80, 90, 99, 99, 99);

$data['ny_gifts']['s'] = array(
					// 1:
					array('type' => 'random_set', 'actions' => array(
						// a
						array(
							array("type" => "chips", "chips" => 50),
							array("type" => "anabolics", "anabolics" => 30),
						),

						//b
						array(
							array("type" => "chips", "chips" => 30),
							array("type" => "anabolics", "anabolics" => 50),
						),

						// c
						array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
						),
					)),

					// 2:
					array('type' => 'give_item', 'item' => array('shaurbadge', 'svistok', 'titan_metro_helmet', 'podkova')),

					// 3:
					array('type' => 'give_item', 'item' => array('ny2011_gift_attention', 'ny2011_gift_resistance', 'ny2011_gift_intuition', 'ny2011_gift_dexterity', 'ny2011_gift_strength', 'ny2011_gift_health')),

					// 4:
					array(
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_7', 'fightfood_ny2011_8'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 2))), // 1-2
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_8', 'fightfood_ny2011_7'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 3), array('type' => 'max_level', 'value' => 3))), // 3
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_9', 'fightfood_ny2011_6'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 4), array('type' => 'max_level', 'value' => 4))), // 4
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_10', 'fightfood_ny2011_5'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 5), array('type' => 'max_level', 'value' => 7))), // 5-7
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_11', 'fightfood_ny2011_3'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 10))), // 8-10
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_12', 'fightfood_ny2011_2'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 11), array('type' => 'max_level', 'value' => 13))), // 11-13
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_13', 'fightfood_ny2011_1'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 14), array('type' => 'max_level', 'value' => 15))), // 14-15
					),
					
					// 5:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array(),
						array(),
						array(),
						array(),
						array(),
						array(),
						array(),
						array(),
						
						array(),
						array(),
						array(),
					)),
				);
				
$data['ny_gifts']['m'] = array(
					// 1:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная

						// c
						array('type' => 'give_item', 'item' => array('petriks_double'), 'amount' => 6),

						// d
						array('type' => 'give_item', 'item' => array('petriks_instant'), 'amount' => 6),
					)),

					// 2:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная

						// c
						array('type' => 'give_item', 'item' => array('petriks_double'), 'amount' => 4),

						// d
						array('type' => 'give_item', 'item' => array('petriks_instant'), 'amount' => 4),
					)),

					// 3:
					array('type' => 'random_set', 'actions' => array(
						// 10%, level: 1-3
						array('type' => 'give_item', 'item' => 'shaurcap', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 3))),

						// 90%
						array(), array(), array(), array(), array(), array(), array(), array(), array(),
					)),

					// 4:
					array('type' => 'give_item', 'item' => array('shaurbadge', 'titan_metro_helmet', 'podkova', array('saper_book_s', 'saper_book_m', 'saper_book_l'), 'passatiji'), 'amount' => array(1, 1, 3, 1, 2)),

					// 5:
					array('type' => 'give_item', 'item' => array('titan_pick', array('mf_book_s', 'mf_book_m', 'mf_book_l'), 'svistok', 'utjug'), 'amount' => array(1, 1, 1, 8)),

					// 6:
					array(
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_7', 'fightfood_ny2011_8'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 2))), // 1-2
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_8', 'fightfood_ny2011_7'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 3), array('type' => 'max_level', 'value' => 3))), // 3
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_9', 'fightfood_ny2011_6'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 4), array('type' => 'max_level', 'value' => 4))), // 4
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_10', 'fightfood_ny2011_5'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 5), array('type' => 'max_level', 'value' => 7))), // 5-7
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_11', 'fightfood_ny2011_3'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 10))), // 8-10
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_12', 'fightfood_ny2011_2'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 11), array('type' => 'max_level', 'value' => 13))), // 11-13
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_13', 'fightfood_ny2011_1'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 14), array('type' => 'max_level', 'value' => 15))), // 14-15
					),

					// 7:
					array('type' => 'give_item', 'item' => array('ny2011_gift_attention', 'ny2011_gift_resistance', 'ny2011_gift_intuition', 'ny2011_gift_dexterity', 'ny2011_gift_strength', 'ny2011_gift_health')),
					
					// 8:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array(),
						array(),
						array(),
						array(),
						array(),
						array(),
						
						array(),
					)),
					
				);
$data['ny_gifts']['lo'] = array(
					// 1:
					array('type' => 'random_set', 'actions' => array(
						array('type' => 'give_item', 'item' => 'pet_knut', 'amount' => 9),
						array(
							array('type' => 'give_item', 'item' => 'hat_dedmoroz_2011'),
							array('type' => 'give_item', 'item' => 'hat_snegurochka_2011'),
						),
						array('type' => 'give_item', 'item' => 'fight_cheese', 'amount' => 3),
						array('type' => 'give_item', 'item' => 'cert_mf_21', 'amount' => 1),
						array('type' => 'give_item', 'item' => 'ny_back', 'amount' => 1),
					)),

					// 2:
					array('type' => 'give_item', 'item' => array('shaurbadge', 'passatiji', 'titan_metro_helmet', 'podkova', array('saper_book_s', 'saper_book_m', 'saper_book_l'), 'petriks_instant'), 'amount' => array(1, 3, 1, 4, 1, 8)),

					// 3:
					array('type' => 'give_item', 'item' => array('titan_pick', array('mf_book_s', 'mf_book_m', 'mf_book_l'), 'svistok', 'utjug', 'petriks_double'), 'amount' => array(1, 1, 1, 8, 8)),

					// 4:
					array(
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_7', 'fightfood_ny2011_8'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 2))), // 1-2
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_8', 'fightfood_ny2011_7'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 3), array('type' => 'max_level', 'value' => 3))), // 3
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_9', 'fightfood_ny2011_6'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 4), array('type' => 'max_level', 'value' => 4))), // 4
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_10', 'fightfood_ny2011_5'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 5), array('type' => 'max_level', 'value' => 7))), // 5-7
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_11', 'fightfood_ny2011_3'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 10))), // 8-10
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_12', 'fightfood_ny2011_2'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 11), array('type' => 'max_level', 'value' => 13))), // 11-13
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_13', 'fightfood_ny2011_1'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 14), array('type' => 'max_level', 'value' => 15))), // 14-15
					),

					// 5:
					array('type' => 'give_item', 'item' => array('ny2011_gift_attention', 'ny2011_gift_resistance', 'ny2011_gift_intuition', 'ny2011_gift_dexterity', 'ny2011_gift_strength', 'ny2011_gift_health')),
					
					// 6: 
					array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 2, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
						),
						
						
					// 7:
					array('type' => 'random_set', 'actions' => array(
						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная
					)),
					
					
					// 8:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array(),
						array(),
						array(),
						array(),
					)),
						

				);
$data['ny_gifts']['lh'] = array(
					// 1:
					array('type' => 'random_set', 'actions' => array(
						// 10%
						array('type' => 'give_item', 'item' => 'pet_ovcharka'),

						// 90%
						array(), array(), array(), array(), array(), array(), array(), array(), array(),
					)),

					// 2:
					array('type' => 'random_set', 'actions' => array(
						array('type' => 'give_item', 'item' => 'pet_knut', 'amount' => 12),
						array(
							array('type' => 'give_item', 'item' => 'hat_dedmoroz_2011'),
							array('type' => 'give_item', 'item' => 'hat_snegurochka_2011'),
						),
						array('type' => 'give_item', 'item' => 'fight_cheese', 'amount' => 6),
						array('type' => 'give_item', 'item' => 'cert_mf_21', 'amount' => 2),
						array('type' => 'give_item', 'item' => 'ny_back', 'amount' => 1),
					)),

					// 3:
					array('type' => 'give_item', 'item' => array('shaurbadge', 'passatiji', 'titan_metro_helmet', 'podkova', array('saper_book_s', 'saper_book_m', 'saper_book_l'), 'petriks_instant'), 'amount' => array(1, 3, 1, 4, 1, 8)),

					// 4:
					array('type' => 'give_item', 'item' => array('titan_pick', array('mf_book_s', 'mf_book_m', 'mf_book_l'), 'svistok', 'utjug', 'petriks_double'), 'amount' => array(1, 1, 1, 8, 8)),

					// 5:
					array(
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_7', 'fightfood_ny2011_8'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 2))), // 1-2
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_8', 'fightfood_ny2011_7'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 3), array('type' => 'max_level', 'value' => 3))), // 3
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_9', 'fightfood_ny2011_6'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 4), array('type' => 'max_level', 'value' => 4))), // 4
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_10', 'fightfood_ny2011_5'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 5), array('type' => 'max_level', 'value' => 7))), // 5-7
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_11', 'fightfood_ny2011_3'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 10))), // 8-10
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_12', 'fightfood_ny2011_2'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 11), array('type' => 'max_level', 'value' => 13))), // 11-13
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_13', 'fightfood_ny2011_1'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 14), array('type' => 'max_level', 'value' => 15))), // 14-15
					),

					// 6:
					array('type' => 'give_item', 'item' => array('ny2011_gift_attention', 'ny2011_gift_resistance', 'ny2011_gift_intuition', 'ny2011_gift_dexterity', 'ny2011_gift_strength', 'ny2011_gift_health')),
					
					// 7:
					array(
						array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
						array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
						array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
						array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
						array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
						array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
					),
					
					
					// 8:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная

						// c
						array('type' => 'give_item', 'item' => array('petriks_double'), 'amount' => 6),

						// d
						array('type' => 'give_item', 'item' => array('petriks_instant'), 'amount' => 6),
					)),
					
					
					// 9:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная
					)),
					
					
					// 10:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная
					)),
					
					// 11:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array('type' => 'give_col_item', 'cid' => 32), // элемент коллекции
						array(),
						array(),
						array(),
					)),
					
					
					
				);
				
				
$data['ny_gifts']['adm'] = array(
					// 1:
					array('type' => 'random_set', 'actions' => array(
						// c
						array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
						),
					)),
					
					// 1:
					array('type' => 'random_set', 'actions' => array(
						// c
						array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
						),
					)),
					
					
					// 1:
					array('type' => 'random_set', 'actions' => array(
						// c
						array(
							array('type' => 'give_item', 'item' => array(276,277,278,279,280,281), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 5))), // 3-5
							array('type' => 'give_item', 'item' => array(288,289,290,291,292,293), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 6), array('type' => 'max_level', 'value' => 7))), // 6-7
							array('type' => 'give_item', 'item' => array(294,295,296,297,298,299), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 9))), // 8-9
							array('type' => 'give_item', 'item' => array(482,483,484,485,486,487), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 10), array('type' => 'max_level', 'value' => 11))), // 10-11
							array('type' => 'give_item', 'item' => array(755,750,751,752,753,754), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 12), array('type' => 'max_level', 'value' => 13))), // 12-13
							array('type' => 'give_item', 'item' => array(880,881,882,883,884,885), 'amount' => 3, 'name' => 'Случайная жвачка', 'conditions' => array(array('type' => 'min_level', 'value' => 14))), // 14+
						),
					)),

					// 2:
					array('type' => 'give_item', 'item' => array('shaurbadge', 'svistok', 'titan_metro_helmet', 'podkova')),

					// 4:
					array(
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_7', 'fightfood_ny2011_8'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 1), array('type' => 'max_level', 'value' => 2))), // 1-2
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_8', 'fightfood_ny2011_7'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 3), array('type' => 'max_level', 'value' => 3))), // 3
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_9', 'fightfood_ny2011_6'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 4), array('type' => 'max_level', 'value' => 4))), // 4
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_10', 'fightfood_ny2011_5'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 5), array('type' => 'max_level', 'value' => 7))), // 5-7
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_11', 'fightfood_ny2011_3'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 8), array('type' => 'max_level', 'value' => 10))), // 8-10
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_12', 'fightfood_ny2011_2'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 11), array('type' => 'max_level', 'value' => 13))), // 11-13
						array('type' => 'give_item', 'item' => array('fight_granata_ny2011_13', 'fightfood_ny2011_1'), 'amount' => 2, 'conditions' => array(array('type' => 'min_level', 'value' => 14), array('type' => 'max_level', 'value' => 15))), // 14-15
					),
					
					
					// 8:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная
					)),
					
					
					// 8:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная
					)),
					
					
					// 8:
					array('type' => 'random_set', 'actions' => array(
						// a
						array('type' => 'give_item', 'item' => array(803, 804, 805, 806, 807, 808)), // зефир

						// b
						array('type' => 'give_item', 'item' => array(84, 85, 86, 87, 88, 89)), // жвачка %-ная
					)),
					
					
				);
//                                     1  2  3  4  5  6  7  8  9  10 11 12 13 14  15  16  17  18  19  20  21  22  23  24  25
$data['factory']['petriks'] = array(0, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21);

define("TPL", "@tpl");
?>