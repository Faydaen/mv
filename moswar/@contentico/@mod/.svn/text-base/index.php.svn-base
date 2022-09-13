<?php
class Index extends ContenticoModule implements IModule
{
    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $this->page['left-menu-index'] = 'class="cur"';
        $this->page['page-name'] = 'А таки чем это вы тут занимаетесь?';
        $this->page['tab-content'] = 'Обзор';
        //
        //Std::loadLib('HtmlTools');

        //$dt = date('Y-m-d', time());
        //$dt2 = date('Y-m-01', time());
        //$sms = $this->sqlGetValue("SELECT sum(profit) FROM smspayment WHERE dt BETWEEN '" . $dt . " 00:00:01' AND '" . $dt . " 23:59:59'");
        //$wm = $this->sqlGetValue("SELECT sum(value) FROM payment WHERE active=1 AND dt BETWEEN '" . $dt . " 00:00:01' AND '" . $dt . " 23:59:59' AND active=1");
        //$sms2 = $this->sqlGetValue("SELECT sum(profit) FROM smspayment WHERE dt BETWEEN '" . $dt2 . " 00:00:01' AND '" . $dt . " 23:59:59'");
        //$wm2 = $this->sqlGetValue("SELECT sum(value) FROM payment WHERE active=1 AND dt BETWEEN '" . $dt2 . " 00:00:01' AND '" . $dt . " 23:59:59' AND active=1");
        //$newPlayers = $this->sqlGetValue("SELECT count(*) FROM player WHERE registeredtime BETWEEN '" . $dt . " 00:00:01' AND '" . $dt . " 23:59:59'");
        //$t = $this->sqlGetValue("SELECT count(*) FROM player WHERE (exp>0 OR level>1) AND accesslevel!=-1");
        //$r = $this->sqlGetValue("select count(*) from player p where ((select count(*) from smspayment where player=p.id) + (select count(*) from payment where player=p.id and active=1) > 2)");
        //$r1 = $this->sqlGetValue("select count(*) from player p where ((select count(*) from smspayment where player=p.id) > 0 or (select count(*) from payment where player=p.id and active=1) > 0)");
        //$lvl['2'] = $this->sqlGetValue("SELECT count(*) FROM log l LEFT JOIN player p ON p.id=l.player WHERE l.type='level_up' AND p.level=2 AND dt between '".date('Y-m-d 00:00:01', time())."' and '".date('Y-m-d 23:59:59', time())."'");
        //$lvl['3'] = $this->sqlGetValue("SELECT count(*) FROM log l LEFT JOIN player p ON p.id=l.player WHERE l.type='level_up' AND p.level=3 AND dt between '".date('Y-m-d 00:00:01', time())."' and '".date('Y-m-d 23:59:59', time())."'");
        //$lvl['4'] = $this->sqlGetValue("SELECT count(*) FROM log l LEFT JOIN player p ON p.id=l.player WHERE l.type='level_up' AND p.level=4 AND time between '".strtotime(date('Y-m-d 00:00:01', time()))."' and '".strtotime(date('Y-m-d 23:59:59', time()))."'");
        //$lvl['5'] = $this->sqlGetValue("SELECT count(*) FROM log l LEFT JOIN player p ON p.id=l.player WHERE l.type='level_up' AND p.level=5 AND time between '".strtotime(date('Y-m-d 00:00:01', time()))."' and '".strtotime(date('Y-m-d 23:59:59', time()))."'");
        //$lvl['6'] = $this->sqlGetValue("SELECT count(*) FROM log l LEFT JOIN player p ON p.id=l.player WHERE l.type='level_up' AND p.level=6 AND time between '".strtotime(date('Y-m-d 00:00:01', time()))."' and '".strtotime(date('Y-m-d 23:59:59', time()))."'");
        /*
		$levels = '
            <p>Игроков: ' . $this->sqlGetValue("SELECT count(*) FROM player WHERE exp>0 OR level>1") . ' (реальщики (3+ платежей): ' . $r . ' (' . round($r / $t * 100, 2) . '%), вообще: ' . $r1 . ')</p>
            <p>Распределение игроков по уровням:
            <ol>';
        $level = 1;
        $playersOnLevel = $this->sqlGetValue("SELECT count(*) FROM player WHERE level=1 AND exp>0");
        while ($playersOnLevel > 0) {
            //$r = $this->sqlGetValue("select count(*) from player p where ((select count(*) from smspayment where player=p.id) > 1 or (select count(*) from payment where player=p.id) > 1) AND p.level=$level");
            $levels .= '<li>' . $playersOnLevel . (isset($lvl[$level])?' <b>+'.$lvl[$level].'</b> ':'') .' (реальщики: ' . $r . ' (' . round($r / $playersOnLevel * 100, 2) . '%))</li>';
            $level++;
            $playersOnLevel = $this->sqlGetValue("SELECT count(*) FROM player WHERE level=$level");
        }
        $levels .= '</ol></p>';
        */
        //
		/*
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('overview'), array(
            'metaobjects-links'=>$this->generateMetaObjectsLinks(),
            'widgets'=>$this->generateWidgets(),
            'modules'=>$this->generateModulesLinks(),
            'todayMoney'=>HtmlTools::FormatMoney(($sms + $wm), 2),
            'monthMoney'=>HtmlTools::FormatMoney(($sms2 + $wm2), 2),
            'levels'=>$levels,
        ));
		*/
		$list = "";
		$list .= "<li><a href=\"/@contentico/Stat/billing/\">Сводка покупок</li>";
		$list .= "<li><a href=\"/@contentico/Stat/online/\">График онлайна</li>";
		$list .= "<li><a href=\"/@contentico/Stat/active/\">График активности</li>";
		$list .= "<li><a href=\"/@contentico/Stat/stat/\">Общая сводка</li>";
		$list .= "<li><a href=\"/@contentico/Stat/mail/\">Почтовая статистика</li>";

		$this->page['content'] = Std::renderTemplate(Contentico::loadTemplate("stat"), array("list" => $list));

		/*
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('overview'), array(            'metaobjects-links'=>$this->generateMetaObjectsLinks(),
            'widgets'=>$this->generateWidgets(),
            'modules'=>$this->generateModulesLinks()
        ));
		 */
        //
        parent::onAfterProcessRequest();
    }

    private function generateMetaObjectsLinks()
    {
        $metaObjects = $this->sqlGetRecordSet("
            SELECT mo.code, sp.name, sp.action_list, sp.action_create,
                (SELECT max(rights) FROM syssecurity WHERE metaobject_id=sp.metaobject_id AND metaview_id=0 AND sysuser_id=".Runtime::$gid.") rights
            FROM sysparams sp LEFT JOIN metaobject mo ON sp.metaobject_id=mo.id
            WHERE sp.menupos>0
            ORDER BY sp.menupos ASC");
        $Links = array();
        if ($metaObjects)
        {
            foreach ($metaObjects as $metaObject)
            {
                if ($metaObject['rights'] & SECURITY_RIGHT_READ)
                {
                    $Actions = array();
                    if ($metaObject['action_create'] && $metaObject['rights'] & SECURITY_RIGHT_WRITE)
                    {
                        $Actions[] = '<a href="/@contentico/Metaobjects/'.$metaObject['code'].'/action='.ACTION_CREATE.'/">Добавить</a>';
                    }
                    $Actions[] = '<a href="/@contentico/Metaobjects/'.$metaObject['code'].'/action='.ACTION_LIST.'/">Список</a>';
                    $Links[] = $metaObject['name'].': '.implode(', ', $Actions);
                }
            }
            if (sizeof($Links))
            {
                return '<h2>Модули сайта</h2>'.implode('<br />', $Links);
            }
        }
        return '';
    }

    private function generateModulesLinks()
    {
        $Modules = $this->sqlGetRecordSet("
            SELECT sm.code, sm.name FROM sysmodule sm
            WHERE sm.menupos>0 AND sm.code!='Index' AND (SELECT max(rights) FROM syssecurity WHERE sysuser_id=".Runtime::$gid."
                AND metaobject_id=(SELECT id FROM metaobject WHERE code='sysmodule') AND (object_id=0 OR object_id=sm.id)) > 0
            ORDER BY sm.menupos ASC");
        $ModuleLinks = array();
        if ($Modules)
        {
            foreach ($Modules as $Module)
            {
                $ModuleLinks[] = '<a href="/@contentico/'.$Module['code'].'/">'.$Module['name'].'</a></li>';
            }
            return '<h2>Управление сайтом</h2>'.implode('<br />', $ModuleLinks);
        }
        return '';
    }

    private function generateWidgets()
    {
        $Widgets = $this->sqlGetRecordSet("
            SELECT mv.id, mv.metaobject_id
            FROM metaview mv
                LEFT JOIN metaobject mo ON mo.id=mv.metaobject_id
                LEFT JOIN syssecurity ssmv ON ssmv.metaview_id=mv.id AND ssmv.sysuser_id=".Runtime::$gid."
                LEFT JOIN syssecurity ssmo ON ssmo.metaobject_id=mo.id AND ssmo.metaview_id=0 AND ssmo.sysuser_id=".Runtime::$gid."
            WHERE mv.type=".META_VIEW_TYPE_WIDGET." AND ssmv.rights>0 AND ssmo.rights>0");
        $WidgetsHtml = '';
        if ($Widgets)
        {
            Contentico::loadModule('metaobjects');
            foreach ($Widgets as $Widget)
            {
                $metaobjectsModule = new Metaobjects();
                $metaobjectsModule->initForWidget($Widget['metaobject_id'], $Widget['id']);
                $metaobjectsModule->parent = false;
                $WidgetsHtml .= $metaobjectsModule->generateListWidget();
            }
        }
        return $WidgetsHtml;
    }
}
?>