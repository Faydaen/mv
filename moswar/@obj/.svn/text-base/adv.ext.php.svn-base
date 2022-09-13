<?php
class advExtention
{
    private $sql;

    public $extendsList = false;
    public $extendsWidget = false;
    public $extendsCard = true;
    public $extendsForm = false;
    public $extendsActions = false;
    public $eventsOnBeforeCreate = false;
    public $eventsOnAfterCreate = false;
    public $eventsOnBeforeEdit = false;
    public $eventsOnAfterEdit = false;
    public $eventsOnBeforeDelete = false;
    public $eventsOnAfterDelete = false;

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
        $refCode = $card->fields['code']['value'];
        $price = (int)str_replace(' ', '', $card->fields['price']['value']);
        $views = (int)str_replace(' ', '', $card->fields['statsviews']['value']);
        $clicks = (int)str_replace(' ', '', $card->fields['statsclicks']['value']);

        if ((int)date("H", time()) > 0 && (int)date("H", time()) < 12) {
        $total = $this->sql->getValue("select sum(d.value) rub from player p left join payment d on d.player=p.id where p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "')");

        $pc = $this->sql->getValue("select count(d.value) rub from player p left join payment d on d.player=p.id where p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "')");

        $activeWeek = $this->sql->getValue("select count(*) players from player p where (p.referer='" . $refCode . "' OR p.referer in (select id from player where referer='" . $refCode . "')) AND DATE_SUB(now(), INTERVAL 1 WEEK)<lastactivitytime");
        
        $reg = $this->sql->getValue("select count(*) rub from player p where p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "')");
		$regP = $this->sql->getValue("select count(*) rub from player p where p.password != 'd41d8cd98f00b204e9800998ecf8427e' AND p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "')");
        $levels = $this->sql->getValueSet("select concat('<b>',level,'</b>: ',round(count(*)/$reg*100,2),'% (',count(*),')') 'levels' from player p where p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "') GROUP BY level");
		$levelsP = $this->sql->getValueSet("select concat('<b>',level,'</b>: ',round(count(*)/$reg*100,2),'% (',count(*),')') 'levels' from player p where p.password != 'd41d8cd98f00b204e9800998ecf8427e' AND p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "') GROUP BY level");

        $p1 = $this->sql->getValue("select count(*) from player p where (select count(*) from payment where player=p.id) = 1 AND (p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "'))");
        $p2 = $this->sql->getValue("select count(*) from player p where (select count(*) from payment where player=p.id) > 2 AND (p.referer='" . $refCode . "' or p.referer in (select id from player where referer='" . $refCode . "'))");
        }

        $card->fields = array_merge($card->fields, array(
            's1_total' => array(
                'name' => 'Прибыль:',
                'value' => HtmlTools::FormatMoney($total, 2),
                'unit' => 'руб.',
                'group' => 'Деньги',
            ),
            's2_profit' => array(
                'name' => 'Баланс:',
                'value' => '<span style="color:'.($total>$price?'green':'red').';">'.HtmlTools::FormatMoney($total - $price, 2).'</span>',
                'unit' => 'руб.',
                'group' => '',
            ),
            's3_reg' => array(
                'name' => 'Регистрации:',
                'value' => $reg,
                'unit' => 'с учетом рефералов 1-го уровня',
                'group' => 'Игроки',
            ),
            's3_reg_p' => array(
                'name' => 'Защищённые регистрации:',
                'value' => $regP,
                'unit' => 'с учетом рефералов 1-го уровня',
                'group' => '',
            ),
            's3_levels' => array(
                'name' => 'Уровни:',
                'value' => is_array($levels) ? implode('<br />', $levels).'<br />' : '',
                'unit' => is_array($levels) ? 'с учетом рефералов 1-го уровня' : 'нет данных',
                'group' => '',
            ),
            's3_levels_p' => array(
                'name' => 'Защищённые уровни:',
                'value' => is_array($levelsP) ? implode('<br />', $levelsP).'<br />' : '',
                'unit' => is_array($levelsP) ? 'с учетом рефералов 1-го уровня' : 'нет данных',
                'group' => '',
            ),
            's3_activeweek' => array(
                'name' => 'Активные (неделя):',
                'value' => $activeWeek,
                'unit' => 'с учетом рефералов 1-го уровня',
                'group' => '',
            ),
            's4_p' => array(
                'name' => 'Реальщики:',
                'value' => $reg > 0 ? round(($p1 + $p2) / $reg * 100, 2).'%' : '',
                'unit' => $reg > 0 ? ($p1 + $p2) : 'нет данных',
                'group' => '',
            ),
            's5_p1' => array(
                'name' => '1 платеж:',
                'value' => $reg > 0 ? round($p1 / $reg * 100, 2).'%' : '',
                'unit' => $reg > 0 ? $p1 : 'нет данных',
                'group' => '',
            ),
            's6_p2' => array(
                'name' => '3+ платежа:',
                'value' => $reg > 0 ? round($p2 / $reg * 100, 2).'%' : '',
                'unit' => $reg > 0 ? $p2 : 'нет данных',
                'group' => '',
            ),
            's7_regprice' => array(
                'name' => 'Стоимость регистрации:',
                'value' => $reg > 0 ? round($price / $reg, 2) : '',
                'unit' => $reg > 0 ? 'руб.' : 'нет данных',
                'group' => 'Факты',
            ),
            's9_regprofit' => array(
                'name' => 'Прибыль с регистрации:',
                'value' => $reg > 0 ? round($total / $reg, 2) : '',
                'unit' => $reg > 0 ? 'руб.' : 'нет данных',
                'group' => '',
            ),
            's8_realprice' => array(
                'name' => 'Стоимость реальщика:',
                'value' => $p2 > 0 ? round($price / $p2, 2) : '',
                'unit' => $p2 > 0 ? 'руб.' : 'нет данных',
                'group' => '',
            ),
            's8_realprofit' => array(
                'name' => 'Прибыль с реальщика:',
                'value' => $p2 > 0 ? round($total / $p2, 2) : '',
                'unit' => $p2 > 0 ? 'руб.' : 'нет данных',
                'group' => '',
            ),
            's9_payments' => array(
                'name' => 'Всего платежей:',
                'value' => (int)$pc,
                'unit' => '',
                'group' => '',
            ),
            's9_avgpayment' => array(
                'name' => 'Средний платеж:',
                'value' => $pc > 0 ? round($total / $pc, 2) : '',
                'unit' => $pc > 0 ? 'руб.' : 'нет данных',
                'group' => '',
            ),
            's10_banctr' => array(
                'name' => 'CTR:',
                'value' => $views > 0 ? round($clicks / $views * 100, 2).'%' : '',
                'unit' => $views == 0 ? 'нет данных' : '',
                'group' => 'Баннер',
            ),
            's10_banconvview' => array(
                'name' => 'Конверсия с кликов:',
                'value' => $clicks > 0 ? round($reg / $clicks * 100, 2).'%' : '',
                'unit' => $clicks == 0 ? 'нет данных' : '',
                'group' => '',
            ),
            's11_banconvclick' => array(
                'name' => 'Конверсия с показов:',
                'value' => $views > 0 ? round($reg / $views * 100, 2).'%' : '',
                'unit' => $views == 0 ? 'нет данных' : '',
                'group' => '',
            ),
        ));
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
        // ...
    }

    public function onAfterEdit($id, $object)
    {
        // ...
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