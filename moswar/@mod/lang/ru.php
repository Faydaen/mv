<?php
class TverskayaLang extends Lang
{
    const WINDOW_NAME = "Тверская";
}

class ArbatLang extends Lang
{
    const WINDOW_NAME = "Арбат";
}

class NeftLang extends Lang {
    const WINDOW_NAME = "Нефтепровод";
    const MISHA2 = "Миша Двапроцента";
}

class PetarenaLang extends Lang {
	const WINDOW_TITLE = "Дрессировка питомцев";

	const ERROR_TRAIN_PETDEAD = 'Ваш питомец травмирован, он не может тренироваться.';
	const ERROR_TRAIN_PETNOTDEAD = 'Ваш питомец жив и здоров, ему не нужна медицинская помощь.';
	const ERROR_TRAIN_REST = 'Ваш питомец отдыхает после тренировки, он не может тренироваться опять так быстро.';
	const ERROR_RESTORE_PET_RESTED = 'Ваш питомец уже отдохнул и готов к новой тренировке.';
	const ERROR_RESTORE_LIMIT = 'Сегодня ваш питомец много тренировался сегодня, он хочет отдохнуть.';
	const ERROR_RESTORE_NO_KNUT = 'У вас нет никакого кнута.';
	const ERROR_MOOD_TOOFAST = 'Вы только что чесали своему питомцу брюшко.';

	const ALERT_MOOD_PLUS_PROGRESS = 'Вы почесали своему питомцу брюшко, от чего его настроение поднялось на <%mood_progress%>%.';
	const ALERT_MOOD_NO_PROGRESS = 'Вы почесали своему питомцу брюшко, но он не обратил на это внимания.';
	const ALERT_MOOD_MINUS_PROGRESS = 'Вы почесали своему питомцу брюшко, но это его только разозлило, от чего его настроение ухудшилось на <%mood_progress%>%.';
	const ALERT_PET_SOLD = 'Вы сдали в питомник своего питомца.';

	public static $healings = array(
		1 => array('name' => 'Измазать зеленкой', 'alert' => 'Вы потыкали своего питомца ваткой с зеленкой. Ему вроде полегчало.'),
		2 => array('name' => 'Сделать укол', 'alert' => 'Питомец долго сопротивлялся, но вы все-таки сделали ему укол, который облегчил его страдания.'),
		3 => array('name' => 'Сводить к ветеринару', 'alert' => 'Накормив питомца какими-то пилюлями, ветеринар вернул его вам со словами "Денек отдохнет и будет как новенький!".'),
		4 => array('name' => 'Показать Куклачёву', 'alert' => 'Куклачёв заперся с вашим питомцем в каморке, а через пару минут оттуда с шумом и гамом появился ваш питомец, совсем здоровый и бодрый.'),
	);
}

class SovetLang extends Lang {
	const ERROR_NO_MONEY_TO_VOTE_SOVET = "Вы внесли недостаточно денег, чтобы проголосовать на выборах в Совет.";
	const ERROR_NO_MONEY_TO_VOTE_STATION = "У вас нет столько денег, сколько вы хотите внести в поддержку атаки выбранной
        вами станции метро";
	const ERROR_NO_MONEY_TO_DEPOSIT = "У вас нет столько денег, сколько вы хотите внести в казну совета. Но вы можете пожертвовать
        и меньшую сумму, которую можете сейчас себе позволить.";
    const ERROR_MIN100 = "Минимальный взнос в казну совета — <span class='tugriki'>100<i></i></span>";
    const ERROR_VOTERAION_MIN100 = "Минимальный взнос при голосовании за район — <span class='tugriki'>100<i></i></span>";
	const ERROR_VOTERAION_MAX10000 = "Максимальный взнос при голосовании за район — <span class='tugriki'>10000<i></i></span>";

	const ALERT_VOTE_TITLE = "Голос учтен!";
	const ALERT_VOTE_TEXT = "Ваш голос учтен самой честной в мире избирательно-голосовательной комиссией, и ни за что не будет
        ни утерян, ни фальсифицирован.";
    const ALERT_BOOST_BUY = "Усиление успешно куплено и вынесено на голосование.";
    const ALERT_BOOST_VOTED = "Ваш голос учтен. Осталось дождаться мнения других членов Совета.";
    const ALERT_BOOST_ACTIVATED = "Ваш голос стал решающим. Усиление успешно активировано.";
    const ALERT_BOOST_CANCELED = "Ваш голос стал решающим. Усиление отменено.";
    const ALERT_TEXT_SAVED = "Обращение успешно сохранено.";
    const ALERT_DEPOSIT_TEXT = "Ваш взнос в казну совета принят и учтен в амбарной книге.";

	const ALERT_REWARD = "За вашу активность совет награждает вас: <%reward%>";

    const ALERT_EXIT = "Вы досрочно сложили свои полномочия и покинули Совет.";

    const ALERT_RUPOR_OK = "Сообщение разослано всем членам Совета.";

    const WINDOW_TITLE = "Совет";
    const WINDOW_TITLE_MAP = "Карта города / Совет";
}

class HuntclubLang extends Lang {
	const ERROR_LOW_LEVEL = "Вступить в элитный Охотничий клуб можно только с 3-го уровне.";
	const ERROR_LOW_MONEY = "У вас не хватает денег на уплату членского взноса.";
	const ERROR_LOW_TARGET_LEVEL = "Можно заказывать только игроков 3-го или более старшего уровня.";
	const ERROR_HIGH_LEVEL_DIFF = "Нельзя заказывать персонажей, которые младше вас более чем на 1 уровень.";
	const ERROR_MAX_MONEY = "Максимальная сумма награды на вашем уровне — <span class='tugriki'><%money%><i></i></span>";
	const ERROR_PLAYER_ZAKAZ_LIMIT = "Игрок не может быть заказан в более чем 3-х заказах одновременно. Подождите, пока будут
        исполнены другие заказы на этого игрока и попытайтесь заказать его снова.";
	const ERROR_MY_ZAKAZ_LIMIT = "Вы не можете разместить более 10 заказов одновременно. Подождите, пока будут исполнены
        другие ваши заказы, либо отмените их самостоятельно.";
	const ERROR_NO_MONEY_TO_PAY_FEE = "У вас не хватает денег, чтобы откупиться от заказа. Остается либо
        прятаться в темных закоулках, либо мужественно принять бой.";

	const ERROR_NO_VICTIM_MESSAGE = "Вы долго выслеживали свою жертву, но ему удалось скрыться в темных закоулках. Попробуйте снова";
	const ALERT_WELCOME_TITLE = "Охотничий клуб";
	const ALERT_WELCOME_TEXT = "Добро пожаловать в элитный Охотничий клуб, место, где
        собираются отчаянные головорезы и охотники за наградой.";
	const ALERT_ZAKAZ_TITLE = "Wanted!";
	const ALERT_ZAKAZ_TEXT = "Секретарь клуба внимательно ознакомился с бланком, положил его под
        стопку других заказов и сказал:<br/> — Ступай, скоро я передам твой заказ нашим охотникам.";
	const ALERT_OPEN_TITLE = "Попался, негодяй!";
	const ALERT_OPEN_TEXT = "Теперь, когда вы выяснили, кто вас заказал, самое время начать мстить!";
	const ALERT_PAYFEE_TITLE = "Заявка удалена";
	const ALERT_PAYFEE_TEXT = "Вы откупились от заказа, секретарь Охотничьего клуба скомкал бланк и кинул его в камин.";

	const WINDOW_TITLE = "Охотничий клуб";
}

class StashLang extends Lang {

}

class TrainerLang extends Lang {

	public static $windowTitleBasic = 'Тренажерный зал';
	public static $windowTitleVip = 'Фитнесс-центр';

}

class PlayerLang extends Lang {

	public static $itemUseCaptionDrug = 'съесть';
	public static $itemUseCationUsableItem = 'испол-ть';
	public static $itemUseCationPetFood = 'кормить';
	public static $itemUseCaptionPutOn = 'надеть';
	public static $itemUseCaptionTakeOff = 'снять';
	public static $itemUseCaptionOpen = 'открыть';
	public static $windowTitle = 'Персонаж';
	public static $strForFlag = '— Флаг';
	public static $strFlagAtOurSide = 'Флаг на нашей стороне';
	public static $strFlagAtClaner = 'Флаг у соклановца';
	public static $strFlagAtMe = 'Флаг у вас';

	const LAST_ITEM_USED = 'Предмет использован.';
	const LAST_ITEM_USED_TEXT = 'Вы использовали последний ваш предмет <b><%name%></b>. Хотите купить еще?<br />Цена за 1 шт.: <%price%>';

	const ALERT_KOMPLEKT = "Полный комплект";
	const ALERT_KOMPLEKT_TEXT = "Поздравляем! Вы собрали полный комплект одежды <%level%>-го уровня. Теперь в бою
        у вас есть шанс применить специальные удары и блоки.";
    const ALERT_ITEM_SWITCH_SAVED = "Изменения сохранены.";
	const ERROR_ACTION_VOODOO_DENIED = "В очередной раз перечитывая уже затертую до дыр книгу \"Магия Вуду для чайников\", вы поняли, что использовать куклу Вуду можно только на первом этапе войны.";
	const ERROR_ACTION_VOODOO_NO_TARGET = "Вы долго читали учебник \"Магия Вуду для чайников\", делали все по правилам, но так и не смогли заставить эту коварную куклу работать!
Скорее всего, не осталось никого, на ком ее можно было бы использовать.";
    const ALERT_VOODOO_USED = "Вы успешно применили магию Вуду и выбили зуб у
        <i class='<%fraction%>'></i>
        <a href='/clan/<%clan%>/'><img src='/@images/clan/clan_<%clan%>_ico.png' class='clan-icon' /></a>
        <a href='/player/<%id%>/'><%nickname%></a> <span class='level'>[<%level%>]</span>.";
    const ALERT_HASPERKS = "Персонаж усилен перками.";
}

class BankLang extends Lang {
	const ERROR_NO_TICKET = "Для покупки <span class=\"ruda\"><i></i>руды</span> за
        <span class=\"tugriki\"><i></i>монеты</span> необходимо приобрести специальный
        сертификат в <a href=\"/berezka/\">Березке</a>.";

	const ALERT_ORE_CHANGED = "Вы успешно обменяли <span class=\"tugriki\"><%money%><i></i></span> на
        <span class=\"ruda\"><%ore%><i></i></span>.";

	public static $windowTitle = 'Банк';
	public static $errorLowLevelText = 'Услуги банка предоставляются только персонажам 5-го и более уровня.';

}

class ClanLang extends Lang {
	const ERROR_CANNOT_LEAVE_DURING_WAR = "Вы не можете покинуть клан во время войны.";
	const ERROR_CANNOT_LEAVE_AT_TITLE = "Вы не можете покинуть клан, пока занимаете в нем должность. Сначала откажитесь от должности,
        потом покиньте клан.";

	const ERROR_CANNOT_EXIT_BEFORE_STEP2 = 'Вы не можете капитулировать, пока не начнется второй этап.';

	const ERROR_CANNOT_ATTACK_SAME_FRACTION = 'Нельзя нападать на кланы вашей стороны.';
	const ERROR_CLAN_ALREADY_AT_WAR = 'Этот клан уже воюет. Нельзя развязать еще одну войну.';
	const ERROR_YOUR_CLAN_ALREADY_AT_WAR = 'Ваш клан уже воюет. Нельзя развязать еще одну войну.';
	const ERROR_CANNOT_ATTACK_WITH_NO_ACTIVE_PLAYERS = 'Нельзя напасть на клан, в котором все игроки либо заблокированы, либо заморожены.';
	const ERROR_CANNOT_ATTACK_NOW = 'Сейчас нельзя напасть на этот клан.';
	const ERROR_CANNOT_ATTACK_LEVEL_DIFFERENCE = 'Нельзя нападать на клан на 2 уровня больше или меньше вашего.';

	const ERROR_CANNOT_TAKE_REST_NOW = 'Вы не можете взять отдых сейчас.';
	const ERROR_CANNOT_TAKE_REST_NOT_ENOUGH_WARS = 'Чтобы взять отпуск, надо провести не меньше 4-х войн после последнего отпуска.';
	const TAKE_REST_OK = 'Ваш клан взял недельный отпуск.';

	const CONTENTICO_STRING_ATTACK = 'нападение';
	const CONTENTICO_STRING_ATTACK_INVITE = 'предложение напасть';
	const CONTENTICO_STRING_ATTACK_AUTO = 'автонападение';
	const CONTENTICO_STRING_ON_OUR_ALLY = 'на напавшего на союзника';
	const CONTENTICO_STRING_ATTACK_INVITE_ENEMY = 'предложение напасть на врага союзника';

	const ALERT_TITLE_STOP = 'снимается с должности';
	const ALERT_TITLE_START = 'назначается на должность';
	const ALERT_TITLES_REPORT = '<p>Вы провели следующие кадровые перестановки:<%alert%></p>
            <p>Итого вы потратили <span class="tugriki"><%price%><i></i></span> из клановой казны.</p>';

	const CLAN_TEMP_BOOST = 'Усиление клана';
	const CLAN_UPGRADES = 'Улучшения клана';
	const CLAN_AWARD = 'Клановая регалия';

	const ERROR_CANNOT_JOIN_WAR_BECAUSE_OF_REST = 'Вы не можете присоединиться к союзной войне, так как сейчас ваш клан отдыхает.';
	const ERROR_CANNOT_JOIN_WAR_BECAUSE_OF_ANOTHER_WAR = 'Вы не можете присоединиться к этой войне, потому что уже воюете.';

	public static $errorNoRightsDiplomacy = 'У вас нет прав изменять дипломатические отношения вашего клана.';
	public static $errorNoRightsPeople = 'У вас нет прав принимать/исключать кланеров и расширять офис.';
	public static $errorNoRightsAdviser = 'У вас нет прав на управление кланом.';
	public static $errorNoRightsFounder = 'Вы не являетесь главой клана, поэтому данное действие вам не доступно.';
	public static $errorNoRightsMoney = 'У вас нет прав распоряжаться казной клана.';
	public static $errorNoMoney = 'В казне клана недостаточно денег.';
	public static $errorNoMoneyToChangeRoles = 'В казне вашего клана недостаточно денег для таких кадровых перестановок.';
	public static $errorNoMoneyToAttack = 'В казне вашего клана недостаточно денег для нападения на этот клан.';
	public static $errorNoMoneyToChangeGraphic = 'В казне вашего клана недостаточно денег для изменения иконки и/или логотипа.';
	public static $errorShortName = 'Слишком короткое название для клана.';
	public static $errorLowClanLevel = 'У вашего клана слишком маленький уровень.';
	public static $errorCanNotKillClanDuringWar = 'Вы не можете распустить клан во время войны.';
	public static $errorCanNotKickDuringWar = 'Вы не можете исключать игроков из клана во время войны.';
	public static $errorCanNotKick = 'Почему-то вы не можете исключить этого человека из клана.';
	public static $errorMax2Unions = 'Нельзя заключить более двух союзов одновременно.';
	public static $errorTheyNeedDefence1 = 'Чтобы заключить союз, союзному клану необходимо увеличить атаку клана до 1.
        Для этого им клану необходимо купить клановое улучшение <b>Знак Стоп</b>.';
	public static $errorWeNeedDefence1 = 'Чтобы заключить союз, необходимо увеличить атаку клана до 1.
        Для этого вашему клану необходимо купить клановое улучшение <b>Знак Стоп</b>.';
	public static $rolesAlertTitle = 'Кадровые перестановки';
	public static $alertUpgrade = 'Улучшение';
	public static $alertUpgradeText = 'Вы успешно купили улучшение <b><%name%></b>.';
	public static $boostInfo = 'Усиление клана';
	public static $windowTitleTeam = 'Состав клана';
	public static $windowTitleDiplomacy = 'Дипломатия';
	public static $windowTitleUpgrade = 'Улучшения кланового офиса';
	public static $windowTitleWarehouse = 'Склад';
	public static $windowTitleLogs = 'Амбарная книга';
	public static $windowTitleWarStats = 'Статистика войны';
	public static $windowTitle = 'Клан';
	public static $windowTitleBanzai = 'Усиление клана';
	public static $windowTitleRegister = 'Регистрация клана';
	public static $roleFounder = 'Глава клана';
	public static $roleAdviser = 'Заместитель главы клана';
	public static $roleDiplomat = 'Дипломат';
	public static $roleMoney = 'Казначей';
	public static $roleForum = 'Модератор';
	public static $rolePeople = 'Кадровик';

}

class PoliceLang extends Lang {

	public static $errorBribeModer = 'Вы не можете откупиться от тюрьмы, так как вы были отправлены туда модератором.
        Ваше дело находится под особым контролем.';

    const ERROR_PASSPORT_SOVET = "Вы не можете сменить прописку, пока состоите в Совете.";

    const ALERT_AVATAR_CHANGE_TITLE = "Смена аватара";
    const ALERT_AVATAR_CHANGE_TEXT = "Ваш аватар успешно изменен.";
    const ALERT_NAME_CHANGE_TITLE = "Смена имени";
    const ALERT_NAME_CHANGE_TEXT = "Ваше имя успешно изменено.";

	const STRING_PLAYERCOMMENT_NAMECHANGE_ACTION = "+ Сменить имя";
	const STRING_PLAYERCOMMENT_NAMECHANGE_PREVIOUS = "Прежнее имя";

	const ERROR_WEREWOLF_BAD_LEVEL = 'Выбираемый уровень должен быть больше <%min_level%>-го и меньше вашего уровня на 1.';
	const WEREWOLF_BEGIN = 'Вы перевоплотились в оборотня в погонах.';
	const WEREWOLF_EXTENSION = 'Вы продлили действие оборотня.';
	const WEREWOLF_REGENERATION = 'Вы создали нового оборотня.';
	const WEREWOLF_CANCEL = 'Вы отпустили своего оборотня.';

	public static $windowTitle = 'Милиция';
    const WINDOW_TITLE = 'Милиция';
}

class HomeLang extends Lang {
	const ERROR_NO_MONEY_CLEARRABBITS = 'У вас недостаточно <span class="med"><i></i>мёда</span> для удаления негативных эффектов.';
	const ERROR_HP_FULL = 'Вы и так уже полностью здоровы.';

	const WINDOW_TITLE = 'Хата';

	const ALERT_TRAVMA_HEALED_TITLE = 'Травма вылечена';
	const ALERT_TRAVMA_HEALED_TEXT = 'Съев целую кучу таблеток, запив ее горячим чаем с мёдом и лимоном, вы почувствовали бодрость
        во всем теле и забыли о своих болячках.';

	const WINDOW_TITLE_COLLECTIONS = 'Коллекции';

	const ALERT_CLEARRABBITS_TITLE = "Эффекты удалены";
	const ALERT_CLEARRABBITS_TEXT = "Все негативные эффекты были с вас сняты. вы опять полны сил и готовы броситься в бой!";

	const ALERT_ANTIRABBIT_TEXT = "Защита от негативных эффектов подарков успешно включена.";

	const ALERT_HEALED_TITLE = "Лечение окончено";
	const ALERT_HEALED_TEXT = "Вы полностью восстановили свое здоровье.";

	const STRING_HOME_DEFENCE = "Защита дома";
	const STRING_HOME_COMFORT = "Комфорт дома";
	const STRING_SAFE_SAVES = "Сохраняет";
	const STRING_SAFE_VALID_TILL = "Годен до";
	const STRING_SAFE_CLOSED = "Закрыт";
	const STRING_SAFE_NOT_BEING_USED = "не используется";

	public static $alertCollectionMakeNotEnoughError = 'Коллекция собрана не полностью';
	public static $alertCollectionMakeNotEnoughErrorText = 'Чтобы собрать коллекцию, вам необходимо найти следующие элементы:<br /><ol>%s</ol>';
	public static $alertCollectionMakeRepeatsError = 'Коллекцию нельзя сдать';
	public static $alertCollectionMakeRepeatsErrorText = 'Вы уже получали награду за сбор этой коллекции.';
	public static $thimbleWindowTitle = 'Сундучки';
	public static $thimbleGuessed = 'Поздравляем!';
	public static $thimbleGuessedText = 'Вы угадали у Мони <b><%collection_item%></b>, которого у вас раньше не было.';
	public static $thimbleNotGuessed = 'Поздравляем!';
	public static $thimbleNotGuessedText = 'Вы угадали у Мони <b><%collection_item%></b>, который у вас уже был.';

}

class AlleyLang extends Lang {
	const ERROR_NPC_RAT_ESCAPED = "<p>Вы бросились на Крысомаху, но она ловко увернулась от вашего удара и скрылась в темноте туннеля.</p>";
	const ERROR_NPC_CANNOT_ATTACK = 'Что-то пошло не так, и вы не смогли напасть на монстра.';
	const ERROR_TOO_FREQUENT_FIGHTS = 'Вы слишком часто деретесь.';
	const ERROR_NPC_RAT_SEARCH_FIRST = 'Чтобы напасть на Крысомаху, необходимо ее выследить в темных коридорах метро.';
	const ERROR_LOWHP_TO_ATTACK = 'Вы слишком слабы для нападения. Наберитесь сначала сил.';

	const ALERT_SOVET_REWARD = 'За помощь в захвате района вы получаете: <%reward%>';
	const ALERT_SOVET_BOX1 = 'За помощь в захвате района вы получаете <b>Малый сундучок</b>.';
	const ALERT_SOVET_BOX2 = 'За помощь в захвате района вы получаете <b>Средний сундучок</b>.';
	const ALERT_SOVET_BOX3 = 'За помощь в захвате района вы получаете <b>Большой сундучок</b>.';
	const ALERT_PATROL_BONUS = 'Проходящий мимо член совета заметил, как вы рветесь поскорее начать патрулировать улицы вашего района, и наградил вас за это: <%reward%>';

   const ERROR_NEFTTIMEOUT = "Вы не успели напасть на негодяя до завершения суток. Придется начать все с начала.";
   
	public static $fightStringsCombo = array(
		'1' => array(
			'm' => '%1% замахнулся ударить в ухо %2%, но тот <span class="highlight-set-blockdamage">подставил копчик</span>, что смягчило удар',
			'f' => '%1% замахнулась ударить в ухо %2%, но та <span class="highlight-set-blockdamage">подставила копчик</span>, что смягчило удар',
		),
		'2' => array(
			'm' => '%1% <span class="highlight-set-adddamage">превратился в кролика</span> и укусил %2%',
			'f' => '%1% <span class="highlight-set-adddamage">превратилась в кролика</span> и укусила %2%',
		),
		'3' => array(
			'm' => '%1% заехал пяткой в глаз %2%, но тот <span class="highlight-set-blockdamage">достал телесную пудру</span> и скрыл синяк. Теперь не так обидно',
			'f' => '%1% заехала пяткой в глаз %2%, но та <span class="highlight-set-blockdamage">достала телесную пудру</span> и скрыла синяк. Теперь не так обидно',
		),
		'4' => array(
			'm' => '%1% <span class="highlight-set-adddamage">нахмурил брови,</span> что до слез испугало %2%',
			'f' => '%1% <span class="highlight-set-adddamage">нахмурила брови,</span> что до слез испугало %2%',
		),
		'5' => array(
			'm' => '%1% прицелился кулаком меж глаз %2%, но тот <span class="highlight-set-blockdamage">замаскировался под берёзу</span> и это ослабило удар',
			'f' => '%1% прицелилась кулаком меж глаз %2%, но та <span class="highlight-set-blockdamage">замаскировалась под берёзу</span> и это ослабило удар',
		),
		'6' => array(
			'm' => '%1% слез с дерева и силой мысли <span class="highlight-set-adddamage">натравил свирепых пчёл</span> на %2%',
			'f' => '%1% слезла с дерева и силой мысли <span class="highlight-set-adddamage">натравила свирепых пчёл</span> на %2%',
		),
		'7' => array(
			'm' => '%1% метнул кирпичем в %2%, но тот <span class="highlight-set-blockdamage">спрятался под скамейкой</span> и не сильно пострадал',
			'f' => '%1% метнула кирпичем в %2%, но та <span class="highlight-set-blockdamage">спряталась под скамейкой</span> и не сильно пострадала',
		),
		'8' => array(
			'm' => '%1% смачно чихнул и <span class="highlight-set-adddamage">заразил радикулитом</span> %2%',
			'f' => '%1% смачно чихнула и <span class="highlight-set-adddamage">заразила радикулитом</span> %2%',
		),
		'9' => array(
			'm' => '%1% напустил уличных распространителей на %2%, но тот <span class="highlight-set-blockdamage">зажала уши</span> и лишь слегка испугалась',
			'f' => '%1% напустила уличных распространителей на %2%, но та <span class="highlight-set-blockdamage">зажал уши</span> и лишь слегка испугался',
		),
		'10' => array(
			'm' => '%1% <span class="highlight-set-adddamage">плеснул стакан воды</span> в лицо %2%, что вызвало у него морскую болезнь',
			'f' => '%1% <span class="highlight-set-adddamage">плеснула стакан воды</span> в лицо %2%, что вызвало у него морскую болезнь',
		),
		'11' => array(
			'm' => '%1% отнял и разорвал паспорт %2%, но тот <span class="highlight-set-blockdamage">вытащил запасной</span> и слегка успокоился',
			'f' => '%1% отняла и разорвала паспорт %2%, но та <span class="highlight-set-blockdamage">вытащила запасной</span> и слегка успокоилась',
		),
		'12' => array(
			'm' => '%1% ударил пяткой в позвоночник %2%, чем нанес ему <span class="highlight-set-adddamage">психологическую травму</span>',
			'f' => '%1% ударила пяткой в позвоночник %2%, чем нанесла ему <span class="highlight-set-adddamage">психологическую травму</span>',
		),
		'13' => array(
                        'm' => '%1% со всей силы размахнулся на %2%, но тот <span class="highlight-set-blockdamage">наслал на него юристов</span> и остался цел',
			'f' => '%1% со всей силы размахнулась на %2%, но та <span class="highlight-set-blockdamage">наслала на неё юристов</span> и осталась цела',
		),
		'14' => array(
			'm' => '%1% сделал <span class="highlight-set-adddamage">ход конём</span> и объявил %2% Шах',
			'f' => '%1% сделала <span class="highlight-set-adddamage">ход конём</span> и объявила %2% Шах',
		),
		'15' => array(
			'm' => '%1% возомнил себя Робокопом и врезал %2%.  Однако удар получился жалкой <span class="highlight-set-blockdamage">пиратской копией</span>',
			'f' => '%1% возомнила себя Робокопом и врезала %2%. Однако удар получился жалкой <span class="highlight-set-blockdamage">пиратской копией</span>',
		),
		'16' => array(
			'm' => '%1% осмотрел %2% и сделал ему <span class="highlight-set-adddamage">модный приговор</span>',
			'f' => '%1% осмотрела %2% и сделала ему <span class="highlight-set-adddamage">модный приговор</span>',
		),
		
		'17' => array(
			'm' => '%1% рассмеялся и перекрыл %2% <span class="highlight-set-adddamage">кислород</span>',
			'f' => '%1% рассмеялась и перекрыла %2% <span class="highlight-set-adddamage">кислород</span>',
		),
		
		'18' => array(
			'm' => '%1% передергивает затвор Максимыча и с криком Ураааааааа! показывает %2% <span class="highlight-set-adddamage">кузькину мать</span>',
			'f' => '%1% передергивает затвор Максимыча и с криком Ураааааааа! показывает %2% <span class="highlight-set-adddamage">кузькину мать</span>',
		),

        //...
	);

    public static $fightStringsPerksKnockOut = array("%1% оглушает %2%");

    public static $fightStringsPerksVampir = array("%1% высасывает у %2% жизни");

    public static $fightStringsPerksRatKiller = array("%1% отравляет крысиным ядом %2%");

	public static $fightStringsPetStun = array("%1% пытается что-то сделать, но %2% <span class='miss'>отпугивает</span> своим грозным видом.");

	public static $fightStringsPetToPlayer = array("%1% <span class='punch'>прицеливается</span> и нападает на игрока %2%.");

	public static $fightStringsPetCatch = array("%2% <span class='miss'>перехватывает атаку</span> %1% на себя.");

    public static $fightStringsStrike = array(
		'%1% дает %2% смачную пощечину',
		'%1% бьет %2% по лбу',
		'%1% дает %2% щелбан',
		'%1% рассказывает %2% анекдот. %2% падает со смеху и подворачивает ногу',
		'%1% кидает в %2% камень',
		'%1% наносит %2% хороший удар',
		'%1% ставит %2% подножку',
		'%1% разбегается и дает %2% пинок под зад',
		'%1% проводит серию ударов по %2%',
		'%1% толкает %2%. %2% падает',
		'%1% пользуется моментом и делает %2% больно',
		'%1% начинает плясать и петь русские народные частушки. %2% не может этого вынести',
		'%1% больно щипает %2%',
		'%1% дает %2% подзатыльник',
		'%1% реализует секретный план на %2%: 1) свистнуть 2) ... 3) профит!',
		'%1% залезает на ёлку и кидает в %2% шишку',
		'%1% промахивается и попадает %2% не в ногу, а в глаз',
		'%1% ловко тычет %2% карандашом в ухо',
		'%1% бьет молотком по мизинцу %2%',
		'%1% нежно шлепает %2% по лицу помойным веником',
		'%1% просит подержать %2% вот эти вот два оголенных кабеля и резко дергает рубильник',
		'%1% цитирует философские трактаты Ницше. %2% понимает всю бессмысленность своего существования',
		'%1% читает суровый гангста-рэп. %2% не находит, чем ответить',
		'%1% обвиняет %2% во всех смертных грехах. %2% понимает, что он самое слабое звено',
		'%1% доказывает, что именно %2% подставил кролика Роджера',
		'%1% наглядно демонстрирует %2%, что его кунг-фу сильнее',
	);
	public static $fightStringsCritical = array(// критический удар
		'%1% со всей дури наносит критический удар пяткой в лоб %2%',
		'%1% проводит молниеносную атаку %2%',
		'%1% делает %2% подсечку. %2% крайне неудачно падает',
		'%1% кусает %2% за палец. Больно, очень больно',
		'%1% случайно роняет %2% с балкона. Четыре раза',
		'%1% наотмашь бьет %2% дамской сумочкой по лицу. Не зря же там три кирпича таскать',
		'%1% напевая «не сыпь мне соль на рану» щедро обсыпает ею %2%',
		'%1% подлавливает %2% когда тот занимается йогой и увлеченно скачет на нем, пока тот лежит на гвоздях',
		'%1% пользуется головой %2% в качестве тарана для взлома сейфовой двери',
		'%1% с легкостью убеждает %2%, что против лома нет приема',
	);
	public static $fightStringsInjury = array(// нанесение травмы
		'%1% использует прием «Удар Чака Норриса ногой с разворота». %2% получает тяжелую травму',
		'%1% говорит много нецензурных слов. %2% получает моральную травму',
		'%1% изощренно бьет %2% и наносит изощренную травму',
		'%1% практикуется в техниках массажа. %2% получает травмы предвещающие экстерминус',
		'%1% показывает фотографию своей жены. У %2% развивается травматический комплекс неполноценности',
		'%1% угощает %2% винегретиком. Тот уползает залечивать травмы в туалет',
		'%1% пронзительно вопит. Барабанные перепонки %2% зарастут еще не скоро',
		'%1% попадает %2% стрелой в пятку. Тот конечно не Ахиллес, но ходить сможет еще не скоро',
		'%1% наносит сокрушающий удар. %2% становится чуть менее чем полностью одной большой травмой',
		'%1% использует %2% в качестве манекена для краш-тестов для Лады Калины',
		'%1% наливает %2% очередные 100 грамм. Таких алкогольных травм организм %2% не получал уже давно',
		'%1% настойчиво ездит по %2% туда-сюда на асфальтоукладчике. То что получает %2% - травмами назвать слабовато',
	);
	public static $fightStringsMiss = array(
		'%1% пытается поразить %2%, но %2% только ухмыляется в ответ.',
		'%1% залезает на ближайшее дерево. %2% не видит в этом никакого смысла.',
		'%1% пытается ударить %2%, но спотыкается и падает.',
		'%1% делает выпад, но %2% ловко уклоняется.',
		'%1% слишком долго готовится нанести удар. %2% успевает убежать.',
		'%1% плюет в %2%. %2% плюет в ответ. Толку - ноль.',
		'%1% кидает в %2% камень, но не попадает.',
		'%1% замахивается на %2%, но так и не решается ударить.',
		'%1% хочет ударить %2% ногой, но %2% его отговаривает.',
		'%1% пытается вспомнить прием карате, но %2% не дает ему этого сделать.',
		'%1% бьет %2%, но %2% ставит блок.',
		'%1% хочет обвести %2% вокруг пальца, но не может этого сделать.',
		'%1% машет руками, но %2% легко уворачивается.',
		'%1% ловко бьет %2% глазом в кулак.',
		'%1% ловко бьет %2% пахом в колено.',
		'%1% врываясь в комнату к %2%, смачно бьется головой об дверной косяк и падает.',
		'%1% исполняет ритуальный танец для завершения заклинания «Великой Черной Неминуемой Ужасной Смерти». %2% вызывает санитаров, чтобы увезли этого психа.',
		'%1% прикрывается портретом Путина. %2% боится репрессий и не решается ударить.',
	);
	public static $fightStringsNaezd = array(// наезд на мопеде
		'%1% нагло наезжает на %2%',
		'%1% подло наезжает на %2%',
		'%1% очень больно наезжает на %2%',
		'%1% с криком «Яррррр!» наезжает на %2%',
		'%1%, вообразив себя водителем катка, медленно и с особым цинизмом наезжает на %2%',
	);
	public static $fightStringsNaezd40 = array(// наезд на мопеде
		'%1% запрыгнул на свой байк и смылся от поражения.',
		'%1% сел на мопед и скрылся из виду.',
		'%1% с криком «Ай л би бэк!» вскочил на байк и укатил прочь.',
	);
	public static $attackStrings = array(// нападение
		'%1% подходит к %2% и спрашивает: «Закурить рубль есть?»',
		'%1% слышит звон монет в кармане %2% и не может пройти мимо.',
		'%1% бросает злобный взгляд на %2%. %2% отвечает взаимностью.',
		'%1% показывает неприличный жест в сторону %2%. %2% решает проучить %1% за подобную дерзость.',
		'%1% как бы говорит %2%, что чужакам на районе не место. %2% не соглашается.',
		'%1% решает разобраться со своими денежными проблемами за счет %2%.',
		'%1% копит на Бентли и думает, что %2% сможет ему в этом помочь.',
		'%1% склоняет %2% к страстной партии с уклоном садо-мазо.',
		'%1% уговаривает %2% поиграть в Маркиза Де Сада.',
		'%1%, поигрывая утюгом, спрашивает у %2%, где тот прячет сбережения.',
		'%1% выскакивает из кустов с криком «Кошелек или жизнь!!!». %2% соглашается забрать у него и то и другое.',
		'%1% предлагает %2% отойти в ближайший дворик. %2% с радостью соглашается.',
	);
	public static $fightStringsAnimalStrike = array(
		'%1% бросается на %2%. %2% не успевает увернуться',
		'%1% всем своим видом как бы говорит %2%, что от расплаты не уйти. %2% соглашается',
		'%1% посылает на %2% лучи смерти',
		'%1% создает пучок энергетических волн и посылает его на %2%',
		'%1% издает душераздирающие звуки. %2% не может их вынести',
		'%1% метко пускает из под хвоста струю жгучей жидкости прямо в глаза %2%',
		'Хотя %1%, в принципе, не голодный, но %2% становится отличной заготовкой еды на зиму',
	);
	public static $fightStringsAnimalCritical = array(
		'%1% наносит критический удар %2%',
	);
	public static $fightStringsAnimalInjury = array(
		'%1% наносит %2% травму',
	);
	public static $fightStringsAnimalMiss = array(
		'%1% бросается на %2%, но %2% успевает увернуться.',
	);
	public static $errorPlayerCanNotBeAttacked = 'На этого персонажа невозможно напасть.';
	public static $errorCanNotFightWithInjury = 'Вы не можете драться, пока у вас есть травмы.';
	public static $windowTitle = 'Закоулки';
	public static $windowTitleAttackPage = "Выбор противника";
}

class ShopLang extends Lang {
	const ERROR_ANTIRABBIT = "<p>Вы не можете подарить этому игрокуподарок с негативным эффектом, потому что у него
        имеется защита от таких подарков.</p><p>Если вы тоже хотите такую защиту, то можете
        <a href=\"/home/\">включить ее</a> у себя на хате.</p>";

	const ERROR_BLACKGIFTDENIED = "Вы не можете дарить обычные подарки этому игроку.";
    const ERROR_DT = "Все раскупили, ассортимент иссяк. В данный момент этот предмет не продается в магазине.";
    const ERROR_MANYNY2011GIFTS = "Нельзя подарить новогодний подарок этому игроку. Ему уже подарено слишком
        много подарков.";

	const ERROR_WEDDING_RING_BAD_SEX = 'Обручальное кольцо можно подарить только игроку противоположного пола.';
	const ERROR_WEDDING_RING_PLAYER_ALREADY_HAS_RING = 'У этого игрока уже есть кольцо, вы не можете подарить ему второе.';

	public static $errorWrongSection = 'Вы пытались пробраться в закрытый отдел магазина, но бдительный охранник вас остановил.';
	public static $windowTitle = 'Торговый центр';
	public static $noticeBotDeteced = 'Покупка ботом ("<%name%>" (ID: <%id%>) x <%amount%>)';
	public static $lockedQuestSafeExists = 'У вас уже есть один сейф, но он закрыт. <a href="/shop/section/other/">Купите в магазине</a> <b>Отмычку</b>, чтобы открыть его и начать пользоваться.';
	public static $safeExists = 'У вас уже есть один сейф, а в вашей квартире помещается только один.';

}

class PlayerAdminLang extends Lang {
	const ERROR_RING_NOT_FOUND = 'У игрока не найдено обручальное кольцо.';
	const ERROR_PARTNER_RING_NOT_FOUND = 'У второго игрока не найдено обручальное кольцо.';
	const ERROR_ALREADY_MARRIED = 'Эти игроки уже поженились.';
	const ERROR_NOT_MARRIED = 'Эти игроки не пара.';
	const OK_MARRIED = 'Игроки успешны повенчены.';
	const OK_MARRIED_CHAT = 'Игроки <b><%player1name%></b> и <b><%player2name%></b> отныне и навеки связаны узами брака.';
	const OK_UNMARRIED = 'Игроки успешны разведены.';
	const ERROR_SMALL_PPL_IN_CHAT = 'В чате слишком мало людей. Необходимо не менее <%player_min%> человек.';
	const ERROR_NO_MARRIEDS_IN_CHAT = 'Новобрачных нет в чате.';
	const OK_WAIT_FOR_FIGHT = 'Внимание! Скоро начнутся праздничные гуляния!';
	const OK_FIGHT_STARTING = 'Ииээээх! Играй гармонь!';
	const MARRIED_COMMENT = 'Знак верности и бесконечной любви молодоженов.';
}

class PageLang extends Lang {

	public static $errorPlayerBlocked = 'Персонаж заблокирован.';
	public static $errorAccessDenied = 'Вам запрещен доступ к игре';
	public static $errorAuthEmailNotFound = 'Неверно указан e-mail адрес или пароль.';
	public static $errorAuthLoginError = 'Данный персонаж уже защищён паролем. Хотите <a href="/auth/remind/">вспомнить пароль?</a>';
	public static $logAddMoneyTitle = 'Монетки';
	//public static $logAddMoneyText = '<p>Вам начислено <span class="tugriki"><%money%><i></i></span>.</p>Причина:<br />';
	public static $logAddMoneyText = '<p>Вам начислено <span class="tugriki"><%money%><i></i></span>.';
	public static $alertCollectionMade = 'Коллекция собрана';
	public static $alertCollectionNewItem = 'Находка';
	public static $alertCollectionNewItemButton2 = 'Перейти в коллекцию';
	public static $alertConditionsError = 'Ошибка';
	public static $alertConditionsErrorText = 'Вы выполнили не все условия. Вам необходимо: <ul><%conditions%></ul>';

	const ALERT_ITEM_UNLOCKED = 'Воспользовавшись предметом <b><%unlocked_by%></b>, вы смогли открыть <b><%unlocked_item%></b>. Вы получили: <%reward%>';
	const ALERT_ITEM_UNLOCKED_MYSELF = 'Вы открыли <b><%unlocked_item%></b>. Вы получили: <%reward%>';
	const ALERT_STAT_STIMULATOR = 'Вы съели вкусный пельмень и смогли увеличить вашу характеристику <b><%stat%></b> до <b><%value%></b>.';

	const BONUS_PATROL_SALARY_25 = 'Увеличение дохода с патруля';
	const BONUS_PATROL_SALARY_50 = 'Большое увеличение дохода с патруля';
	const BONUS_COLLECTION_PROBABILITY = 'Увеличение шанса получить элемент коллекции';
	const BONUS_CARAVAN_PROBABILITY = 'Увеличение шанса встречи с корованом';

	// Вы получили:
	const GET_HUNTDT = 'членство в <a href="/huntclub/">Охотничьем Клубе</a> на <%dt%>';
	const GET_VIPTRAINERDT = 'членство в <a href="/trainer/vip/">VIP-зале</a> на <%dt%>';
	const GET_BANKDT = 'ячейку в <a href="/bank/">банке</a> на <%dt%>';
	const GET_SKILLUPGRADE = 'увеличили свой навык модификатора на <b><%skill%></b>';
	const GET_PROF_UPGRADE = 'получили новое звание модификатора <b><%prof%></b>';
	const GET_SKILLGRANATA = 'увеличили свой навык подрывника на <b><%skill%></b>';
	const GET_PROF_GRANATA = 'получили новое звание подрывника <b><%prof%></b>';

	// Вам необходимо:
	const NEED_TO_BE_MAJOR = 'иметь <a href="/stash/">мажорство</a>';
	const NEED_TO_HAVE_RELATIONS = 'иметь связи в <a href="/police/">милиции</a>';
	const NEED_TO_HAVE_HUNTCLUB = 'иметь членство в <a href="/huntclub/">Охотничем Клубе</a>';
	const NEED_TO_HAVE_VIPTRAINER = 'иметь членство в <a href="/trainer/vip/">VIP-зале</a>';
	const NEED_MIN_LEVEL = 'иметь уровень не ниже <%min_level%>-го';

	const AGREEMENT = "Соглашение";
	const FEE_FREES_ITSELF = "Игрок платно разморозил себя за ";
	const FEE_UNLOCK_ITSELF = "Игрок платно разблокировал себя за ";
	const HONEY_ONE = "мед";
	const HONEY_MANY = "меда";
	const PAID_UNLOCK = "Платная разблокировка";
	const CHARACTER_ACTIVATION = "Активация персонажа";
	const YOU_LONG_ABSENT = "Вы долго не были в игре";
	const NOT_BORED = "Чтобы вы не скучали в будущем, мы вручаем вам:<br><ul><li>Пяни</li><li>Сертификат мажора</li><li>Коробку конфет</li><li>Немножко монет</li></ul><br />Не скучайте!";
	const YOUR_CHARACTER = "Ваш персонаж ";
	const ILL = " заболел";
	const OBTAINED = "Получен ";
	const LEVEL_IN_GAME = " уровень в игре www.moswar.ru";
	const GET_TEN = "Получена Десятка! за фотографию, ";
	const AUTOMATICALLY_DEFROSTED = "Ваш персонаж был автоматически разморожен из криогенной камеры";
	const ITEM = "предмет";
	const PICKED = "отобран";

	const PET_NAME_CHANGED = "Теперь Ваш питомец откликается на кличку <b><%name%></b>.";
}

class NightclubLang extends Lang {
	const ALERT_SETPHOTO = 'Вы изменили себе фон.';
	const ALERT_EXTENSIONPHOTO = 'Вы продлили действие фона.';
}

class SettingsLang extends Lang {
	const ERROR_PASSWORD1 = "Введенные вами новый пароль и подтверждение не совпадают.";
	const ERROR_PASSWORD2 = "Введенный вами текущий пароль — неправильный.";
	const ERROR_AVATAR_4HOURS = "Вы не можете менять аватар чаще, чем раз в 4 часа.";

	const ERROR_CANNOT_BLOCK_WAR1 = 'Вы не можете заблокироваться во время 1-го этапа войны.';
	const ERROR_CANNOT_BLOCK_4LEVEL = 'Блокировка персонажа доступна с 4-го уровня.';
	const ERROR_CANNOT_BLOCK_AT_FIGHT = 'Вы не можете сейчас заблокироваться, вас ждут в бою.';

	const ERROR_CANNOT_CREO_WAR1 = 'Вы не можете заморозиться во время 1-го этапа войны.';
	const ERROR_CANNOT_CREO_4LEVEL = 'Заморозка персонажа доступна с 4-го уровня.';
	const ERROR_CANNOT_CREO_LOWMONEY = 'У вас не хватает денег.<br />Стоимость замороки — <span class="tugriki"><i></i>1000</span>.';
	const ERROR_CANNOT_CREO_AT_FIGHT = 'Вы не можете сейчас заморозиться, вас ждут в бою.';

	const ALERT_SETTINGS_SAVED = "Настройки сохранены.";
	const ALERT_PROFILE_SAVED = "Изменения профиля сохранены.";
	const ALERT_PASSWORD_SAVED = "Новый пароль сохранен.";

	const ACTION_COMMENT_BLOCK = "+ Заблокировать";
	const ACTION_COMMENT_BLOCK2 = "Сам себя заблокировал через настройки";

	const WINDOW_TITLE = "Профиль персонажа";
}

class PhoneLang extends Lang {

	public static $errorNoPlayer2 = 'Не указан адресат сообщения.';
	public static $errorShortText = 'Текст сообщения слишком короткий.';
	public static $errorLongText = 'Текст сообщения слишком длинный.';
	public static $errorMinLevel2 = 'Вы сможете отправлять личные сообщения только со 2-го уровня.';
	public static $errorUnder7Level1Minute = 'Персонажи до 7-го уровня могут писать личные сообщения не чаще, чем раз в минуту.';
	public static $errorMessagesBan = 'Вам запрещено писать личные сообщения до <%dt%>.';
	public static $errorNoPlayerWithName = 'Персонаж с именем <b><%name%></b> не найден.';
	public static $errorPlayerBlocked = '<b>Персонаж заблокирован</b>. Нельзя отправлять сообщения заблокированным персонажам.';
	public static $errorContactExists = "Контакт с таким именем уже существует.";
	public static $errorContactAdded = "Контакт добавлен.";
	public static $errorContactNoPlayer = "Игрока с таким ником нет.";
	public static $windowTitleLogs = 'Логи';
	public static $windowTitleDuels = 'Дуэли';
	public static $windowTitleContacts = 'Контакты';
	public static $windowTitleMessages = 'Сообщения';
	public static $textInviteToChat = 'Привет! Заходи в игровой чат, чтобы пообщаться со мной в реальном времени! Вот ссылка: http://moswar.ru/chat/';

}

class IndexLang extends Lang {

	public static $errorIpBanned = 'Извините, но вам запрещено пользоваться игрой.';
	public static $errorFractionNotSelected = 'Необходимо выбрать сторону!';
	public static $errorBannedName = 'Запрещенное имя';
	public static $errorWrongName = 'Неверное имя';
	public static $errorWrongEmail = 'Неверный e-mail';
	public static $errorWrongPassword = 'Пароль должен содержать от 6 до 20 символов';
	public static $errorNameExists = 'Имя уже занято';
	public static $errorEmailExists = 'E-mail уже занят';
	public static $errorUnknown = 'Произошла ошибка, попробуйте зарегистрироваться позже.';
	public static $textRegSuccess = 'Вы успешно разместились в Москве и теперь можете приютить у себя одного товарища. Для этого передайте ему билет: <%invite%>.';
	public static $textInvitedBy = 'Приглашен';
	public static $textEmailRegTitle = 'Понаехали тут! Добро пожаловать в Москву!';
	public static $textEmailArrivedMale = 'понаехавший';
	public static $textEmailArrivedFemale = 'понаехавшая';
	public static $textEmailResidentMale = 'доблестный защитник';
	public static $textEmailResidentFemale = 'доблестная защитница';

}

class PhotosLang extends Lang {

	public static $windowTitle = 'Фотогалерея';

	const ACCEPT_PHOTO = "+ Принять фотографию";
	const REJECT_PHOTO = "- Отклонить фотографию";
	const ANY_W = "любая";
	const ANY_M = "любой";
	const ANY_O = "любое";
	const ITSELF_W = "Сама по себе";
	const HAS_BOYFRIEND = "Есть парень";
	const ENGAGED_W = "Помолвлена";
	const MARRIED_W = "Замужем";
	const DONT_KNOW_W = "Эх, сама не пойму";
	const ACTIVE_SEARCH = "В активном поиске";
	const SINGLE = "Холост";
	const HAS_GIRLFRIEND = "Есть девушка";
	const ENGAGED_M = "Помолвлен";
	const MARRIED_M = "Женат";
	const DONT_KNOW_M = "Сам не пойму";
	const PHOTO_1 = "фотографию";
	const PHOTO_2 = "фотографии";
	const PHOTO_5 = "фотографий";
	const FILE_1 = "файл";
	const FILE_2 = "файла";
	const FILE_5 = "файлов";
}

class FightLang extends Lang {

	public static $errorFightIsFull = 'Вы не успели записаться в бой. Кто-то коварно обогнал вас.';
	public static $errorJoinBusy = 'Вы слишком заняты, чтобы драться.';
	public static $errorJoinInjury = 'У вас травма, и вы не можете вступить в бой.';
	const ERROR_JOIN_STARTED = 'Бой уже начался, и вы не можете просто так вступить в него. Но вы можете
        вмешаться в этот бой.<div class="hint">Чтобы вмешаться, вам нужно <a href="/berezka/">купить разрешение</a>.</div>';
    const ERROR_JOIN_FINISHING = "Вы не можете вмешаться в этот бой. Он уже завершается.";
	public static $errorJoinHealth = 'У вас слишком мало здоровья, чтобы вступить в этот бой. Восстановите
        хотя бы половину.';
	public static $errorJoinSideIsFull = 'Вы не можете вступить в бой за эту сторону. Там уже слишком много человек.';
	public static $errorJoinMoney = 'Вы не можете вступить в этот бой. У вас недостаточно денег для оплаты
        вступительного взноса.';
	public static $errorJoinBribeNoMoney = 'У вас не хватает денег для дачи такой большой взятки.';
	public static $errorJoinBribeTooSmall = 'Слишком маленькая взятка. Охранник не будет рисковать ради таких денег.';
	public static $errorJoinMinLevel = 'Вы не можете вступить в этот бой. Вы слишком маленький.
        Минимальный уровень для вступления: <%level%>.';
	public static $errorJoinMaxLevel = 'Вы не можете вступить в этот бой. Вы слишком большой.
        Максимальный уровень для вступления: <%level%>.';
	public static $errorFightNotFound = 'Запрашиваемый вами бой не найден.';

    const JOINLOCK = "Вмешаться в бой не удалось. Более проворные игроки хитро заняли места в очереди
        на влезание в бой перед вами. Попробуйте еще раз.";

	public static $alertBribeOk = 'Взятка успешно дана';
	public static $alertBribeOkText = 'Охранник взял горстку монет, сунул их себе в карман и сказал:<br />
        — Постой где-нибудь недалеко и следи за мной. Если все будет чики-пуки, я дам тебе знать.';
	public static $alertPrepareToFight = 'Готовься к бою!';
	public static $alertPrepareToFightText = '<div align="center">Вы успешно вступили в бой. Готовьтесь к битве.<div class="hint"><b>Можете <a href="/chat/" onclick="setCookie(\'chat_room\', \'battle\');" target="_top">включить боевой чат</a></b></div></div>';
	public static $captionBankRobbers = 'Грабители';
	public static $captionBankSecurity = 'Охрана банка';

	const LOG_ACTION_KILLS = ' убивает ';
	const LOG_ACTION_GETSFLAG = ' перехватывает флаг у ';
	const LOG_ACTION_SAVESFLAG = ' сохраняет флаг';
	const LOG_ACTION_PROTECTS = ' прикрывает ';
	const LOG_ACTION_FORCEJOINS = " вмешивается в бой";
	const LOG_ACTION_EATS = " кушает ";
	const LOG_ACTION_USESITEM = " использует предмет ";
	const LOG_ACTION_RUPOR = " кричит: ";
	const LOG_ACTION_GRANATA = " метает в толпу дерущихся ";
	const LOG_ACTION_GRANATA2 = " получает урон от взрыва ";

	const LOG_ACTION_UMBRELLA = " надевает <b>Пробковую каску</b>";
	const LOG_ACTION_MIRROR = " готовится защищаться <b>Коварной пружиной</b>";

	const LOG_ACTION_CHEESE = " приманивает Крысомаху <b>Ароматным сыром</b>";

	const LOG_ACTION_ANTIGRANATA = " изпользует <b>Защиту от гранат</b>";
	
	const LOG_PET_CATCH = " <span class='miss'>перехватывает атаку</span>&#160;";
	const LOG_PET_FOCUS = " <span class='punch'>прицеливается</span> и нападает на игрока <spacer />";
	const LOG_PET_STUN = " <span class='miss'>отпугивает</span> своим грозным видом&#160;";

	const CAPTION_TEAM1 = "Левые";
	const CAPTION_TEAM2 = "Правые";

	const ALARM_CLOCK = "Будильник";

	public static $windowTitle = 'Стенка на стенку';

}

class FactoryLang extends Lang {

	public static $errorMfMinLevel6 = 'Цех модификаций доступен только с 6-го уровня.';
	public static $errorMfItemOnPlayer = 'Для модификации предмета его необходимо снять с персонажа.';
	public static $errorMfMax = 'Предмет уже улучшен максимальное количество раз.';
	public static $errorItemNotFound = 'Предмет не найден в инвентаре.';
	public static $errorPetriksMinLevel5 = 'Производство нано-петриков доступно только с 5-го уровня.';
	public static $errorSectionClosed = 'Цех закрыт.';
	public static $errorPetriksNoMoney = 'У вас недостаточно денег для производства нано-петриков.';
	public static $errorPetriksInProgress = 'Нано-петрики по вашему заказу уже производятся.';
	public static $alertPetriksStart = 'Производство нано-петриков';
	public static $alertPetriksStartText = 'Производство активных молекул нано-петриков успешно запущено. Через 1 час
        <%petriks%> нано-петриков будут присланы вам самой надежной в мире российской почтой.';
	public static $alertPetriksInstantMakeText = 'Производство активных молекул нано-петриков успешно запущено. Благодаря пред-заказу вам не пришлось ждать час и вы быстренько получили товар.';
	public static $alertPetriksDoubleMakeText = 'Договорившись со сторожем завода поместили сразу две партии нано-петриков в производство.';
	public static $alertPetriksInstantDoubleMakeText = 'Воспользовавшись сразу всеми доступными сертификатами вы получили удвоенную партию нано-петриков моментально.';
	public static $windowTitleMf = 'Цех улучшения предметов';
	public static $windowTitleFactory = 'Завод';

}

class MetroLang extends Lang {
	const ERROR_CANNOT_DIG_SEARCHING = 'Вы не можете искать руду в данный момент, потому что вы бродите по тонелям метро,
        пытаясь выследить Крысомаху.';
	const ERROR_CANNOT_SEARCH_DIGGING = 'Вы заняты копанием ветки метро. Вам сейчас не до Крысомах.';
	const ERROR_CANNOT_SEARCH_BUSY = 'Вы слишком заняты. Вам сейчас не до Крысомах.';
	const ERROR_CANNOT_WORK_BUSY = 'Вы сейчас заняты другими вещами и не можете спуститься в метро.';

	const WINDOW_TITLE = 'Метро';
}

class ThimbleLang extends Lang {
	const ERROR_MONYA_DONTWANT_TEXT = 'Вы сегодня уже играли в наперстки с Моней Шацом много раз, и его интерес
        к вам сильно поубавился. Но если же вы хотите во что бы то ни стало рискнуть еще разок,
        то <a href="/berezka/">купите билетик</a> в Березке.';
	const ERROR_MONYA_BUSY_TEXT = "Вы сейчас слишком заняты, чтобы сосредоточиться на игре в наперстки. Освободитесь
        от других дел и приходите.";
	const ERROR_NO_MONEY = "У вас не хватает <span class=\"tugriki\"><i></i>монет</span> для игры.";

	const WINDOW_TITLE = "Наперсточник Моня Шац";
}

class ChatLang extends Lang {

	public static $messageGroupFightChatActive = 'Начался групповой бой. Боевой чат подключен.';
	public static $errorNoGroupFight = 'Вы сейчас не находитесь в бою.';
	public static $errorNoClan = 'Вы сейчас не состоите в клане.';
	public static $errorNoUnion = 'У вашего клана нет союзов.';
	public static $errorEnemyFraction = 'Вы не можете зайти в чат враждующей фракции.';
	public static $errorMaleChat = 'Вы не можете зайти в мужской чат.';
	public static $errorFemaleChat = 'Вы не можете зайти в женский чат.';
	public static $errorNoobs = 'Игроки первого уровня могут общаться только в Детсаде.';

}

class Lang {

	public static $error = 'Ошибка';
	public static $errorNoHoney = 'Медовая ошибка';
	public static $errorNoHoneyText = 'У вас недостаточно мёда. Видимо, вы уже съели весь свой мёд.';

	const MONEY = 'Монеты';
	const ORE = 'Руда';
	const PETRIKS = 'Нано-петрики';
	const OIL = 'Нефть';

	const ERROR = 'Ошибка';
    const UNLUCKY = "Не повезло";
	const ERROR_NO_HONEY = 'Медовая ошибка';
	const ERROR_NO_HONEY_TEXT = 'У вас недостаточно мёда. Видимо, вы уже съели весь свой мёд.';

	const ERROR_NO_MONEY_TITLE = "Недостаточно денег";
	const ERROR_NO_MONEY = "У вас недостаточно денег для совершения этой операции.";

	const ERROR_ACTION_DENIED = "По странному стечению обстоятельств вы не можете совершить это действие.";

    const ALERT_OK = "Все правильно сделал!";

    const TIME_D = ' д';
    const TIME_H = ' ч';
    const TIME_MI = ' м';
    const TIME_S = ' с';

	public static $textDomain = 'moswar.ru';
	public static $messageUnderAffects = 'Игрок наелся вкусных конфет или напился тонизирующего чая, а может быть даже и жвачек нажевался.';
	public static $captionRatings = array(
		'ratingcrit' => 'Рейтинг критических ударов',
		'ratingdodge' => 'Рейтинг уворота',
		'ratingresist' => 'Рейтинг защиты',
		'ratingactiCrit' => 'Рейтинг защиты от критических ударов',
		'ratingdamage' => 'Рейтинг урона',
		'ratingaccur' => 'Рейтинг точности',
	);

	public static $captionPercentDmg = 'Бонус к урону';
	public static $captionPercentDefence = 'Снижение урона';
	public static $captionPercentHit = 'Шанс попасть';
	public static $captionPercentDodge = 'Шанс увернуться';
	public static $captionPercentCrit = 'Шанс критического удара';
	public static $captionPercentAnticrit = 'Защита от критического удара';

	public static $captionRatingCrit = 'Рейтинг критических ударов';
	public static $captionRatingDodge = 'Рейтинг уворота';
	public static $captionRatingResistance = 'Рейтинг защиты';
	public static $captionRatingActiCrit = 'Рейтинг защиты от критических ударов';
	public static $captionRatingDamage = 'Рейтинг урона';
	public static $captionRatingAccur = 'Рейтинг точности';
	public static $captionRatingRandom = 'Случайный рейтинг';
	public static $captionStats = array(
		'health' => 'Здоровье',
		'strength' => 'Сила',
		'dexterity' => 'Ловкость',
		'intuition' => 'Хитрость',
		'resistance' => 'Выносливость',
		'attention' => 'Внимательность',
		'charism' => 'Харизма',
	);
	public static $captionStatHealth = 'Здоровье';
	public static $captionStatStrength = 'Сила';
	public static $captionStatDexterity = 'Ловкость';
	public static $captionStatIntuition = 'Хитрость';
	public static $captionStatResistance = 'Выносливость';
	public static $captionStatAttention = 'Внимательность';
	public static $captionStatCharism = 'Харизма';

	const RESIDENT = "Коренные";
	public static $captionResident = 'Коренные';
    const ARRIVED = "Понаехавшие";
	public static $captionArrived = 'Понаехавшие';
	const CAPTION_PLAYERS = "Игроки";

    const NPC_RAT = "Крысомаха";
    const NPC_AGENTSMITH = "Охранник";
    const NPC_RIELTOR = "Риэлторша";
    const NPC_RAIDER = "Рейдер";
    const NPC_GRAFTER = "Взяточник";

	public static $npc = array(3 => 'Риэлторши', 4 => 'Рейдеры', 5 => 'Взяточники');

    public static $rieltorNames = array("Антонина", "Квартиркина", "Света", "Дуся", "Анжела", "Хрущевкина", "Элитова", "Галина",
		"Плиточкина", "Ипотекова", "Бутова", "Выхина");
	public static $rieltorFightPhrases = array(
        "Я вам всем сдам квартирку в Выхино, чтоб вы каждое утро на метро ездили!",
        "Всех загоним в ипотеку на 20 лет!",
        "Недвижимость всегда будет расти! И мы вместе с ней!",
        "Бетонометры - лучшая инвестиция, несите нам свои денежки!",
        "Рассмотрим только славян! Куда вы все лезите?!",
        "Элитных квартир захотели? Сидите в коммуналках и не высовывайтесь!",
    );

	public static $raiderNames = array("Николай", "Хитров", "Макс", "Прокуроров", "Подлецов", "Данила", "Петров", "Владимир", "Бандитофф", 
		"Суров", "Приставов", "Наездов", "Братанов", "Собакин", "Феликс");
	public static $raiderFightPhrases = array(
        "Мы бандито, знаменито, Мы стрелянто пистолето, оу-ессс!",
        "Мы - санитары экономики! Мы сейчас вас всех тут отсанитарим!",
        "Кто с мечом к нам придет, тот по морде и получит!",
        "Да вы хоть понимаете, какие у нас связи?",
        "Сколько я зарезал, сколько перерезал, сколько душ я загубил...",
        "Владимирский централ, ветер северный. Этапом из Твери...",
    );

	public static $grafterNames = array("Борис", "Жаднов", "Обжоров", "Рублев", "Вася", "Дулин", "Александр", "Вован", "Жирнов", "Откатов", 
		"Распилов", "Бюджетов", "Депутатов", "Долларов", "Транжиров", "Карманов", "Кепкин");
	public static $grafterFightPhrases = array(
        "У вас еще нет миллиарда? Идите нафиг!",
        "Молодые люди, а давайте вы ко мне в особняк крепостными холопами пойдете!",
        "Предпочитаю доллары и евро. Рубли не предлагать!",
        "Мои часы стоят миллион баксов. Куда тебе до меня?",
        "А ты уже присмотрел себе домик в Лондоне?",
    );

	public static $npcPetNames = array("Тузик", "Рэкс", "Пушистик", "Дружок", "Бобик", "Мурзик", "Ушастый");

    public static $ratNames = array("Арргх", "Ярррр", "Жжжжуть", "Ххххвост", "Ццццап", "Ррррявк", "Ббббрысь",
        "Кккклык");
    public static $agentNames = array("Василий", "Павел", "Димон", "Колян", "Толик", "Михаил", "Злобный", "Денис", "Бывалый",
        "Пистолетов", "Качалкин", "Вышибалов");

	const PET_CAT = "Киска";
	const PET_DOG = "Чихуа-хуа";
	const PET_PARROT = "Попугай";
	const PET_DOBERMAN = "Доберман";
    const PET_OVCHAR = "Овчарка";

	const UNION_AND = 'и';

	/**
	 * Генерация строки
	 *
	 * @param string $text
	 * @param array $params
	 * @return string
	 */
	public static function renderText($text, $params) {
		foreach ($params as $code => $value) {
			$text = str_replace('<%' . $code . '%>', $value, $text);
			$text = str_replace('{%' . $code . '%}', $value, $text);
		}
		return $text;
	}

}

class GiftLang extends Lang {

	public static $gift = 'Подарок';
	public static $giftAccepted = 'Подарок принят.';
	public static $giftCanceled = 'Подарок удалён.';
	public static $giftComplained = 'Подарок удалён. Жалоба на подарок отправлена.';
	public static $giftComplained2 = 'Комментарий удалён. Жалоба на подарок отправлена.';
	public static $giftClear = 'Комментарий к подарку удалён. Сам подарок остался.';

}

class SupportLang extends Lang {
	const ACCRUAL_OF_HONEY = "Начисление мёда";
	const MESSAGE_SENT = "Сообщение отправлено";
	const REQUIRED_FIELDS_ARE_EMPTY = "Вы заполнили не все необходимые поля";
	const PHONE = "Номер телефона: ";
	const PHONE_AND_TEXT = "Короткий номер и текст сообщения: ";
	const PAYMENT_DETAILS = "Реквизиты платежа";
	const NORMAL = "Обычный";
	const HIGH = "Высокий";
	const LOW = "Низкий";
	const ADDED = "Новое";
	const OPEN = "Открыто";
	const CLOSED = "Закрыто";
	const MESSAGE_SENT_TO_RESPONSIBLE_PARTIES  = "Ваше сообщение отправлено всем ответственным лицам";
	const TECHNICAL_SUPPORT = "Техническая поддержка";
}

class StartQuestLang extends Lang {
	const HOW_IT_ALL_BEGAN = "Как все началось";
	const STORY_1 = "Ты всегда был{%sex:|а%} амбициоз{%sex:ен|на%} и любил{%sex:|а%} повыпендриваться, но родители учили тебя быть скромн{%sex:ым|ой%} и жить как все. Поступив в институт и посчитав себя уже достаточно независим{%sex:ым|ой%}, ты решаешь уйти из дома и пойти завоевывать Москву!";
	const STORY_2 = "Выйдя из родного двора и не зная, куда пойти, ты прогуливал{%sex:ся|ась%} по площади около Казанского вокзала, как вдруг...";
	const STORY_3 = "Что дальше?";
	const YOUR_CHARACTER = "Ваш персонаж";
	const FIRST_INCIDENT = "Первое происшествие";
	const STORY_4 = "Подозрительного вида мужик с кейсом пронесся мимо тебя и, расталкивая прохожих, побежал в ближайший двор. Не успев опомниться, ты был{%sex:|а%} сбит{%sex:|а%} с ног парой крепких ОМОНовцев, промчавшихся вслед за странным типом, матерясь и расталкивая всех вокруг. Сидя на асфальте, ты заметил{%sex:|а%}, как мужик бросил кейс в кусты и скрылся в ближайшей подворотне. ОМОНовцы последовали за ним. Пока окружающие люди отходили от шока, ты быстро подбежал{%sex:|а%} к кейсу.";
	const STORY_5 = "Кейс оказался сделан из полупрозрачного пластика, через который ты смог{%sex:|ла%} разглядеть какой-то документ, CD-диск, ключи и что-то тряпичное. Но тут перед тобой возник агрессивно настроенный молодой человек в спортивном костюме и лакированных ботинках и, размахивая руками, стал объяснять, что это его территория, и, следовательно, кейс тоже его. Тебе такое хамское отношение очень не понравилось...";
	const STORY_6 = "Надрать уши ублюдку";
	const FIGHT = "Бой";
	const GRAVY = "Легкая нажива";
	const STORY_7 = "Победив в неравной схватке и получив, так сказать, боевое крещение, ты решил{%sex:|а%} немного помародерствовать. Вытащив из кармана поверженного противника <span class=\"tugriki\">300<i></i></span>, ты решаешь пойти в ближайший дворик подальше от суеты и спокойно все обдумать.";
	const STORY_8 = "Не все так просто с этим кейсом, но вот как его открыть?...";
	const BEGIN_TO_CONQUER_THE_CAPITAL = "А пока начнем покорять столицу!";
	const WORK = "Работа";
	const STORY_9 = "Понимая, что одними грабежами сыт не будешь, ты решаешь заработать денег другим путем. Познакомившись на улице с нужными людьми, ты получаешь возможность пройти в подпольный карточный клуб. «Новичкам всегда везет» — пытаешься согреть себя мыслью. Но не тут то было!";
	const STORY_10 = "Уже через пару часов, оказавшись по уши в долгах местному мафиозному клану, ты плетешься по ночному городу, ясно понимая, что отрабатывать долг теперь придется долго и упорно. Куда пойти работать {%sex:такому балбесу|такой дуре%}? Конечно же в ближайшую забегаловку! Там такие всегда нужны.";
	const HAPPILY_RUN_TO_WORK = "Радостно побежать работать";
	const SUITCASE = "Чемоданчик";
	const STORY_11 = "Оценив все преимущества новенького оружия, ты понимаешь, что теперь то ты точно разберешься с коварным чемоданчиком. Пара ударов, и китайский замок на не менее китайском кейсе перестает быть проблемой. Внутри ты наш{%sex:ел|ла%} целую гору ништяков: документы на квартиру и ключи от нее, DVD-диск, несколько паспортов на разные имена и куклу вуду.";
	const STORY_12 = "Мда, вопросов появилось больше, чем ответов...";
	const NEXT = "Далее";
	const CLAN_WARS = "Клановые разборки";
	const STORY_13 = "В метре от тебя просвистела пуля и впечаталась в штукатурку, оставив на ней глубокую ямку. В мгновение ты пригнул{%sex:ся|ась%} и спрятал{%sex:ся|ась%} под рядом-стоящим Джипом. Выстрелы стали громче и послышались стуки каблуков десятка дорогих ботинок. Они приближались, и с каждой секундой ты чувствовал увеличивающийся страх и чуть было не вскрикнул, когда один из ботинков остановился у твоего носа. Прогремел еще один выстрел и через секунду на асфальт упало окровавленное тело водителя. Джип завелся с оглушительным ревом и двинулся с места оставив тебя без укрытия...";
	const STORY_14 = "Через неделю после пережитого шока, сидя вечером с товарищами на лавочке, жуя рогалик и запивая его кефиром, ты понимаешь, что в одиночку в этом городе тебе ничего не добиться. И, взяв инициативу в свои руки, ты решаешь сколотить свою банду.<br /><br />К сожалению, ты не замечаешь, что из-за угла за тобой следит мужчина в ботинках из белой кожи.";
	const CREATE_YOUR_OWN_GANG = "Создать свою банду";
	const STORY_15 = "Купив наконец то дешевый ноутбук и радостно прибежав с ним домой, чтобы поведать своим друзьям в контакте о столь ярких последних событиях своей жизни, ты вдруг вспоминаешь о DVD-диске из странного кейса. Не медля ни минуты, ты вставляешь его в ноутбук и видишь красивую видео-презентацию не менее красивого плана секты “Мировая Термоядерная Война” по уничтожению всего человечества. С экрана вещает некий Даня Ше.<ol><li>Мировой экономический кризис сыграл нам на руку. Местный завод закрыли за	долги, всю охрану распустили, и теперь никто нам не мешает организовать там	подпольное производство.</li><li>Мы производим на некогда секретном заводе дешевые копии аЙфонов и начиняем их радиоактивной рудой.</li><li>Дешевые аЙфоны быстро раскупаются и распространяются по всему миру.	<li>И в час «Х» все аЙфоны одновременно взрываются, образуя всемирный ядерный взрыв, и уцелеет только Антарктида.</li><li>ПРОФИТ!!!</li></ol>";
	const STORY_16 = "Похоже ты попал{%sex:|а%} в центр зловещего масонского заговора, но как его предотвратить? Пойти в милицию? Там просто посчитают {%sex:психом|ненормальной%}. Одной	проблемой у тебя стало больше...";
	const PROCEED = "Продолжить";
	const SUBWAY = "Метро";
	const STORY_17 = "Обыскивая вещи очередного лежащего без сознания в темном переулке твоего спонсора, ты обращаешь внимание на вырезку из статьи у него в кармане с кричащим заголовком: «Стройка века! Огромные возможности для молодых сильных и амбициозных! Большие зарплаты в метро и новые возможности на заводе! Построй дорогу в светлое будущее для всей страны!».";
	const STORY_18 = "«Вот он мой шанс» — думаешь ты — «теперь то я точно разбогатею!» и стремительно направляешься по указанному адресу.";
	const DESCEND_INTO_THE_SUBWAY = "Вперед в метро";
	const AN_UNEXPECTED_FINDING = "Неожиданная находка";
	const STORY_19 = "Ты так долго ждал{%sex:|а%} этого дня! Ведь сегодня тебя наконец то должны повысить в должности. Зайдя на последок в уже ставший тебе родным сверкающий чистотой туалет в Макдональдсе за углом, где ты усердно работал{%sex:|а%} последние несколько недель.";
	const STORY_20 = "Ты вдруг заметил{%sex:|а%} оброненный кем-то пропуск с номером «007» на местный завод на имя некоего Д. Бонда. Не долго думая, ты сунул{%sex:|а%} его себе в карман и направил{%sex:ся|ась%} исследовать новый цех завода.";
	const VISIT_FACTORY = "Посетить этот завод";
	const LOCAL_HOOLIGAN = "Местный гопник";
	const MORE = "Дальше";
}

class NewsLang extends Lang {
	const NEWS = "Новости";
}

class LevelUpLang extends Lang {
	const FORWARD_TO_NEW_VICTORIES = "Вперед, к новым победам!";
}

class AuthLang extends Lang {
	const USER_EMAIL_NOT_FOUND = "Пользователь с указанным e-mail адресом не найден";
	const MOSWAR_RESET_PASSWORD = "www.MosWar.ru: Сброс пароля";
	const RESET_PASSWORD = "Сброс пароля";
	const RESET_PASSWORD_STEP2 = "Сброс пароля - шаг 2";
	const MOSWAR_NEW_PASSORD = "www.MosWar.ru: Новый пароль";
	const RESET_PASSWORD_STEP3 = "Сброс пароля - шаг 3";
}

class ApiLang extends Lang {
	const PHARMACY = "Аптека";
	const CLOTHING = "Одежда";
	const PERFUMERY = "Парфюмерия";
	const FOR_HOME = "Для дома";
	const FOR_CLAN = "Для клана";
	const ACCESSORIES = "Аксессуары";
	const WEAPON = "Оружие";
	const MASCOTS = "Талисманы";
	const PETS = "Питомцы";
	const OTHER = "Другое";
	const CHAT_MUTE_ADD = "+ Молчанка в чате";
	const CHAT_MUTE_REMOVE = "- Молчанка в чате";
	const CHAT_ISOLATION_ADD = "+ Изолиция в чате";
	const CHAT_ISOLATION_REMOVE = "- Изолиция в чате";
	const USERFROM = "от";
	const ARRIVED_M = "понаехавший";
	const ARRIVED_W = "понаехавшая";
	const RESIDENT_M = "доблестный защитник";
	const RESIDENT_W = "доблестная защитница";
	const SUBJECT = "Понаехали тут! Добро пожаловать в Москву!";
}

class CasinoLang extends Lang
{
    const WINDOW_NAME = "Казино";
	const WINDOW_NAME_KUBOVICH = "Кубович";
	const WINDOW_NAME_SLOTS = "Слот-автомат";
	const WINDOW_NAME_SPORTLOTO = "Спортлото";
}

class PyramidLang extends Lang {
	const ERROR_NO_PYRAMIDS = 'У вас совсем нет пирамидок.';
	const ERROR_PYRAMID_CRASHED = 'Пирамида разрушена.';
	const ERROR_ACTION_NOT_AVAIL = 'С момента последней операции еще не прошло 24 часа.';

	const OK_PARTLY_BAYOUT = 'В фонде пирамиды не хватило денег, чтобы выкупить все ваши пирамидки. Вы получили <span class="tugriki"><%money%><i></i></span> за <span class="pyramids"><%pyramids%><i></i></span> и пирамида рухнула.';

	const GRANDPA_BUY = 'Бабушки считают, что пирамида будет расти.';
	const GRANDPA_SELL = 'Бабушкам кажется, что пирамида может развалиться.';
}

class AutomobileLang extends Lang {
	const WINDOW_NAME = "Автозавод";

	const RES_RUBBER = "Каучук";
	const RES_FURNACE = "Плавильная печь";
	const RES_PUMP = "Насос";
	const RES_WINDOWS = "Стеклопакет";
	const RES_GLASSCUTTER = "Стеклорез";
	const RES_BEAM = "Балка";
	const RES_BRICK = "Кирпич";
	const RES_CEMENT = "Цемент";
	const RES_PAINT = "Краска";
	const RES_SCREW = "Болт";
	const RES_DRAFT = "Чертёж";
	const RES_RASP = "Напильник";

	const DIRECTION_1 = "На дачу";
	const DIRECTION_2 = "В деревню к дедушке";
	const DIRECTION_3 = "На шашлыки с друзьями в подмосковье";
	const DIRECTION_4 = "На молодежную дискотеку в Южное Бутово";
	const DIRECTION_5 = "На корпоратив в сауну";
	const DIRECTION_6 = "В аквапарк «Лето круглый год»";
	const DIRECTION_7 = "Погонять на треке";
	const DIRECTION_8 = "На концерт поп-звезд российской эстрады";
	const DIRECTION_9 = "На занятие по йоге с тибетским монахом";
	const DIRECTION_10 = "В ресторан «Пушкинъ & Дантесъ»";
	const DIRECTION_11 = "На разборки с говнюками и негодяями";
	const DIRECTION_12 = "В элитный ночной клуб «Дягилефф Жжот»";
	const DIRECTION_13 = "Совершить круг почета по МКАД";
	const DIRECTION_14 = "На Байкал — прочистить чакры";
	const DIRECTION_15 = "В Питер — повысить уровень культуры";
	const DIRECTION_16 = "На горнолыжный курорт в Сочи";
	const DIRECTION_17 = "На встречу с неподкупным депутатом";
	const DIRECTION_18 = "На Казантип — «пожариться» на солнце";
	const DIRECTION_19 = "В Европу";

	const CAR_1_NAME = "Лада-Пандора";
	const CAR_1_DESC = "Мир полный новых приключений. Под капотом."; 
	const CAR_2_NAME = "Уазик";
	const CAR_2_DESC = "Где непроходимая грязь — там рядом Уазик ее покоряет. Говорят, если его разобрать и правильно собрать, то может получиться Геленваген.";
	const CAR_3_NAME = "Ослик";
	const CAR_3_DESC = "Простая и надежная рабочая лошадка. То, что нужно для хозяйственного человека.";
	const CAR_4_NAME = "Пыжик";
	const CAR_4_DESC = "Гламурный французский лягушонок притягивает взгляды всех девчонок со школьной дискотеки.";
	const CAR_5_NAME = "Кредитавто";
	const CAR_5_DESC = "Примета гласит, что этот автомобиль можно покупать только в кредит. Даже если у вас есть нужная сумма, все равно сходите в банк за кредитом.";
	const CAR_6_NAME = "Матрешка";
	const CAR_6_DESC = "Новая акция! Каждому купившему Матрешку — помада в подарок.";
	const CAR_7_NAME = "Субарик";
	const CAR_7_DESC = "В Турбо-Субарике никогда не трясет, это просто такой массаж задуманный японскими инженерами. ";
	const CAR_8_NAME = "Финик";
	const CAR_8_DESC = "Отличная такая изящная малолитражка.";
	const CAR_9_NAME = "Крузак";
	const CAR_9_DESC = "Если вас посылают куда подальше, учтите, что туда можно добраться только на проходимой машине.";
	const CAR_10_NAME = "Семерка";
	const CAR_10_DESC = "Многие водители жалуются, что у этой машины на скорости не работают поворотники. Бракованная какая-то.";
	const CAR_11_NAME = "Окаенный";
	const CAR_11_DESC = "С милым рай и в шалаше, если милый на Порше";
	const CAR_12_NAME = "Эска";
	const CAR_12_DESC = "Загадка этого автомобиля в том, что во что бы он не врезался — это окажется Запорожец";
	const CAR_13_NAME = "Гелик";
	const CAR_13_DESC = "Качественно собранный Уазик.";
	const CAR_14_NAME = "Скакун";
	const CAR_14_DESC = "Аэродинамику придумали те, кто не умеет строить мощные моторы.";
	const CAR_15_NAME = "Скорая помощь";
	const CAR_15_DESC = "Если у вас много денег, и главная проблема жизни - их потратить, тогда 911-й слегка облегчит вам работу.";
	const CAR_16_NAME = "Дьявол";
	const CAR_16_DESC = "Говорят, когда едет, музыку плохо слышно.";
	const CAR_17_NAME = "Бент-мобиль";
	const CAR_17_DESC = "Представьте себе, эта машина управляется с заднего сиденья.";
	const CAR_18_NAME = "Бугай";
	const CAR_18_DESC = "Расход бензина более 1 литра на 1 километр. Но кому какое дело.";
	const CAR_19_NAME = "Танк Т-34";
	const CAR_19_DESC = "Несмотря на отсутсвие кондиционера и АБС, есть одна хорошая длинная опция.";

	const FAIL_1 = "На дорогах кортеж с мигалками";
	const FAIL_2 = "На автомойке большая очередь";
	const FAIL_3 = "Дорожные рабочие перекрыли шоссе";
	const FAIL_4 = "Улицу перекрыли для проведения марша согласных";
	const FAIL_5 = "На въезде мкада пробки";
	const FAIL_6 = "На мкаде километровые пробки";
	const FAIL_7 = "На всем пути гаишники в кустах";

	const IMPROVEMENT_1_NAME = "Качественные шины";
	const IMPROVEMENT_1_DESC = ""; // Для вашей машины
	const IMPROVEMENT_2_NAME = "Литые диски";
	const IMPROVEMENT_2_DESC = "";
	const IMPROVEMENT_3_NAME = "Спортивная тормозная система";
	const IMPROVEMENT_3_DESC = "";
	const IMPROVEMENT_4_NAME = "Автоматическая коробка передач";
	const IMPROVEMENT_4_DESC = "";
	const IMPROVEMENT_5_NAME = "Турбонаддув";
	const IMPROVEMENT_5_DESC = "";
	const IMPROVEMENT_6_NAME = "Закись азота";
	const IMPROVEMENT_6_DESC = "";
	const IMPROVEMENT_7_NAME = "ГЛОНАСС-навигатор";
	const IMPROVEMENT_7_DESC = "";
	const IMPROVEMENT_8_NAME = "ГПС-навигатор с компасом и продвинутая аудиосистема";
	const IMPROVEMENT_8_DESC = "";
	const IMPROVEMENT_9_NAME = "Бортовой компьютер";
	const IMPROVEMENT_9_DESC = "";
	const IMPROVEMENT_10_NAME = "Тонированные стекла";
	const IMPROVEMENT_10_DESC = "";
	const IMPROVEMENT_11_NAME = "Антикрыло";
	const IMPROVEMENT_11_DESC = "";
	const IMPROVEMENT_12_NAME = "Неоновая подсветка";
	const IMPROVEMENT_12_DESC = "";
	const IMPROVEMENT_13_NAME = "Ксива";
	const IMPROVEMENT_13_DESC = "";
	const IMPROVEMENT_14_NAME = "Мигалка";
	const IMPROVEMENT_14_DESC = "";

	const NUMBER_0 = "Обычный";
	const NUMBER_1 = "Трёхзнак";
	const NUMBER_2 = "Букварь";
	const NUMBER_3 = "Красивый";
	const NUMBER_4 = "Блатной";
	const NUMBER_5 = "Спецномер";

	const FACTORY_1_NAME = "Колёсный цех";
	const FACTORY_1_DESC = "В этом цехе делаются круглые колеса. Секрет круглых колес в том, что они едут лучше, чем треугольные и квадратные.";
	const FACTORY_2_NAME = "Цех моторчиков";
	const FACTORY_2_DESC = "В этом цехе собирают моторчики. Зачем они нужны никто не знает, но без моторчиков автомобиль отказывается ехать.";
	const FACTORY_3_NAME = "Рулевой цех";
	const FACTORY_3_DESC = "В этом цехе делаются рули. Без руля автомобиль не сможет поворачивать.";
	const FACTORY_4_NAME = "Кузовной цех";
	const FACTORY_4_DESC = "В этом цехе мастерятся кузова автомобилей. Внутрь кузова вставляются руль и моторчик, а снаружи прикручиваются колеса.";

	const ALERT_GARAGE = "Гараж";
	const ALERT_FACTORY = "Автозавод";
	const ALERT_RIDE = "Поездка";

	const MESSAGE_BUY_NUMBER_SUCCESS = "Закрепив новый номер, вы радостно поехали кататься.";
	const MESSAGE_BUY_NUMBER_NO_MONEY = "На такой номер нужно ещё немного подкопить.";
	const MESSAGE_BUY_NUMBER_BUSY = "Кто-то с таким номером уже бороздит просторы неризиновой.";
	const MESSAGE_BUY_NUMBER_BUSY_1 = "Ушлые бомбилы уже расхватали все номера. Либо оставляй свой, либо выбирай номер другой категории.";
	const MESSAGE_BUY_NUMBER_BUSY_2 = "Номерок блатной, три семерочки, да вот только он не твой, нету корочки. Нет больше свободных номеров в этой категории, попрубуй поискать в других.";
	const MESSAGE_BUY_NUMBER_BUSY_3 = "Лихие мажоры еще вчера разобрали все такие номерки. Попробуй найти что-нибудь в других категориях.";
	const MESSAGE_BUY_NUMBER_BUSY_4 = "Все красивые номера давно прицеплены к гламурным машинкам подружек олигархов. Попытай счастье с другими категориями номеров.";
	const MESSAGE_BUY_NUMBER_BUSY_5 = "Хотел безнаказанно ездить на двухста по встречке? Так вот не выйдет, не осталось номеров, дающих авто-индульгенцию. Попробуй поискать в других категориях.";
	const MESSAGE_BUY_NUMBER_BUSY_6 = "Спецномера всегда в дефиците. Их не хватает даже на самих чиновников, не говоря уже об их многочисленных помошниках. Вот и тебе не хватило. Попробуй поискать менее крутые номера.";
	const MESSAGE_BUY_NUMBER_INCORRECT = "Такой номер можно закрепить только на велосипед.";

	const MESSAGE_CREATE_CAR_NO_PLACE = "В гараже мало места. Продайте старый автомобиль или расширьте свой <a href='/home/'>гараж</a>.";
	const MESSAGE_CREATE_CAR_NO_GARAGE = "Каждый порядочный горожанин должен иметь гараж для хранения своего авто. 
		<a href='/home/'>Гараж</a> можно построить рядом с хатой.";
	const MESSAGE_CREATE_CAR_COOLDOWN = "Производство занято.";

	const MESSAGE_BUY_PETROL_SUCCESS = "Бак заполнен до верха!";
	const MESSAGE_BUY_PETROL_NO_MONEY = "У вас нет денег даже на бензин, вот печаль :(";
	const MESSAGE_BUY_PETROL_ALREADY_FULL = "Бак уже и так заполнен до отказа!";

	const MESSAGE_FAVORITE_SUCCESS = "Теперь эта тачка будет показыватья в вашем профиле.";

	const MESSAGE_UPGRADE_GARAGE_SUCCESS = "Ура! Теперь у вас в гараже на одно место больше.";
	const MESSAGE_UPGRADE_GARAGE_NO_MONEY = "У Вас не хватает руды для расширения гаража.";

	const MESSAGE_UPGRADE_FACTORY_SUCCESS = "Начато улучшение цеха.";
	const MESSAGE_UPGRADE_FACTORY_NO_RES = "Для улучшения цеха недостаточно ресурсов.";
	const MESSAGE_UPGRADE_FACTORY_NO_MONEY = "Для улучшения цеха недостаточно руды.";
	const MESSAGE_UPGRADE_FACTORY_ALREADY_BEST = "Цех уже улучшен до максиамльного уровня";
	const MESSAGE_UPGRADE_FACTORY_COOLDOWN = "Цех занят";

	const MESSAGE_UPGRADE_CAR_SUCCESS = "Вы успешно прокачали свою тачку. Она стала еще круче!";
	const MESSAGE_UPGRADE_CAR_NO_MONEY = "У вас не хватает денег для улучшения своего авто.";
	const MESSAGE_UPGRADE_CAR_ALREADY_EXISTS = "Это улучшение уже установлено на вашей машине.";

	const MESSAGE_RIDE_SUCCESS = "Вы отлично провели время и улучшили своё настроение";
	const MESSAGE_RIDE_SUCCESS_BONUS = "Бонус на ";
	const MESSAGE_RIDE_SUCCESS_RIDE = "Следующая поездка ";
	const MESSAGE_RIDE_SUCCESS_RIDE_AVAILABLE = " возможна через ";
	const MESSAGE_RIDE_SUCCESS_CAR = "Машина ";
	const MESSAGE_RIDE_SUCCESS_CAR_AVAILABLE = " будет готова через ";
	const MESSAGE_RIDE_SUCCESS_YAHOO = "Ура!";
	const MESSAGE_RIDE_NUMBER = "Вы решили отправиться в путь, как вдруг обнаружили, что у вас нет гос. номера автомобиля. Чтобы получить номер, зайдите в профиль машины.";
	const MESSAGE_RIDE_TO_CAR = "К машине";

	const MESSAGE_RIDE_COOLDOWN = "В этом направлении ещё нельзя ехать.";
	const MESSAGE_RIDE_CAR_COOLDOWN = "Машина ещё не готова.";
	const MESSAGE_RIDE_NO_PETROL = "С пустым баком далеко не уедешь. Нужно <a href=\"/home/\">заправить машину</a>.";

	const MESSAGE_UPGRADE_FACTORY_CONGRATULATIONS = "Поздравляем, ";
	const MESSAGE_UPGRADE_FACTORY_COMPLETE = " успешно построен!";
	const MESSAGE_UPGRADE_FACTORY_NEW_IMPROVEMENT = "Вам открыто новое улучшение ";
	const MESSAGE_UPGRADE_FACTORY_CHECK_GARAGE = ", проверьте свой <a href=\"/home/\">гараж</a>.";

	const MESSAGE_SELL_CAR_COOLDOWN = "Нельзя продать машину, находящуюся в сервисе.";
	const MESSAGE_SELL_CAR_SUCCESS = "Вы успешно продали ";

	const MESSAGE_BRING_UP_PASSENGER_1_1 = "студента";
	const MESSAGE_BRING_UP_PASSENGER_1_2 = "красивую девушку";
	const MESSAGE_BRING_UP_PASSENGER_1_3 = "домохозяйку";
	const MESSAGE_BRING_UP_PASSENGER_1_4 = "пенсионера";
	const MESSAGE_BRING_UP_PASSENGER_1_5 = "оппозиционера";

	const MESSAGE_BRING_UP_PASSENGER_2_1 = "менеджера среднего звена";
	const MESSAGE_BRING_UP_PASSENGER_2_2 = "гламурную девицу";
	const MESSAGE_BRING_UP_PASSENGER_2_3 = "мелкого чиновника";
	const MESSAGE_BRING_UP_PASSENGER_2_4 = "милиционера";
	const MESSAGE_BRING_UP_PASSENGER_2_5 = "чемпиона по боксу";

	const MESSAGE_BRING_UP_PASSENGER_3_1 = "нностранеца";
	const MESSAGE_BRING_UP_PASSENGER_3_2 = "даму с собачкой";
	const MESSAGE_BRING_UP_PASSENGER_3_3 = "налогового инспектора";
	const MESSAGE_BRING_UP_PASSENGER_3_4 = "популярного телеведущего";
	const MESSAGE_BRING_UP_PASSENGER_3_5 = "криминального авторитета";

	const MESSAGE_BRING_UP_PASSENGER_4_1 = "эффективного менеджера";
	const MESSAGE_BRING_UP_PASSENGER_4_2 = "генерала";
	const MESSAGE_BRING_UP_PASSENGER_4_3 = "слугу народа";
	const MESSAGE_BRING_UP_PASSENGER_4_4 = "светскую львицу";
	const MESSAGE_BRING_UP_PASSENGER_4_5 = "известного артиста";

	const MESSAGE_BRING_UP_FAIL = "Не судьба!";
	const MESSAGE_BRING_UP_FAIL_1 = "Вы сделали кружок по столице, но никто не помахал вам рукой.";
	const MESSAGE_BRING_UP_FAIL_2 = "Вы выехали на дорогу в поисках пассажира, но застряли в пробке.";
	const MESSAGE_BRING_UP_FAIL_3 = "Ваш пассажир на ходу выпрыгнул из автомобиля, так и не заплатив.";

	const MESSAGE_BRING_UP_SUCCESS_1 = "Вы с радостью подвезли ";
	const MESSAGE_BRING_UP_SUCCESS_2 = ", тем более что вам было по пути.<br />Получено баллов: ";
	const MESSAGE_BRING_UP_BONUS = "За активную помощь вечно опаздывающим жителям столицы вы получаете: <%reward%>";

	const STAT_CONTROLLABILITY = "Управляемость";
	const STAT_PASSABILITY = "Проходимость";
	const STAT_SPEED = "Скорость";
	const STAT_PRESTIGE = "Престиж";
	const STAT_RANDOM = "Случайная характеристика";
	const STAT_TIME = "Время поездки";
	const STAT_ACTS = "Время действия";
	const STAT_LEFT = "Осталось";

	const PART_NEED_TO_BUY = "Для покупки требуется построить";
	const FACTORY_NEED_TO_BUILD = "Для сборки требуется построить";
	const PART_ALLOW = "Доступно для покупки";

	const BONUS_TIME = "Время действия бонуса";
}

?>
