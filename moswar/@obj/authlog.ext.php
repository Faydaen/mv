<?php
class authlogExtention
{
    private $sql;
    
    public $extendsList = false;
    public $extendsWidget = false;
    public $extendsCard = false;
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