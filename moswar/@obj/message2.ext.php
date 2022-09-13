<?php
class message2Extention
{
    private $sql;

    public $extendsList = false;
    public $extendsWidget = false;
    public $extendsCard = false;
    public $extendsForm = false;
    public $extendsActions = true;
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
        // ...
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
        $mes1 = $this->sql->getRecord("SELECT message id, player2 FROM message2 WHERE id=" . $module->objectId);
        if ($mes1) {
            if (isset($module->customUrlParams['accept'])) {
                $this->sql->query("UPDATE message SET visible2 = 1, dt = now() WHERE id=" . $mes1['id']);
                $this->sql->query("UPDATE player2 SET newmes=newmes+1 WHERE player=" . $mes1['player2']);
            } elseif (isset($module->customUrlParams['decline'])) {
                $this->sql->query("DELETE FROM message WHERE id=" . $mes1['id']);
            }
            $this->sql->query("DELETE FROM message2 WHERE id=" . $module->objectId);
        }
        Std::redirect('/@contentico/Metaobjects/message2/page=' . $module->returnToPage . '/view=' . $module->returnToView . '/');
    }

    public function extendActions(&$actions)
    {
        $actions[] = new ContenticoViewListAction(ContenticoViewListAction::LIST_ACTION_TYPE_FUNCTION, 'accept', 'acceptMessage',
            ContenticoViewListAction::LIST_ACTION_MODE_ONE, 'Разрешить', '/@contentico/@img/ico/actions/tick.gif', SECURITY_RIGHT_WRITE,
            'function acceptMessage(metaobjectCode, action, page, view){document.location.href="/@contentico/Metaobjects/message2/action=9/accept=1/id=" + ContenticoSelectedItems[0].id + "/-page=" + page + "/-view=" + view + "/";}');
        $actions[] = new ContenticoViewListAction(ContenticoViewListAction::LIST_ACTION_TYPE_FUNCTION, 'decline', 'declineMessage',
            ContenticoViewListAction::LIST_ACTION_MODE_ONE, 'Удалить', '/@contentico/@img/ico/actions/tick-canceled.gif', SECURITY_RIGHT_WRITE,
            'function declineMessage(metaobjectCode, action, page, view){document.location.href="/@contentico/Metaobjects/message2/action=9/decline=1/id=" + ContenticoSelectedItems[0].id + "/-page=" + page + "/-view=" + view + "/";}');
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