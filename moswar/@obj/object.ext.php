<?php
/**
 * Расширения для всех объектов
 */

class ObjectExtention
{
    private $sql;
    private $metaObjectCode;
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

    public function __construct($metaObjectCode)
    {
        $this->sql = SqlDataSource::getInstance();
        $this->metaObjectCode = $metaObjectCode;
    }

    /**
     * Расширение функционала списков
     *
     * @param object $list
     * @param int $step
     */
    public function extendList(&$list, $step)
    {
        if ($step == 1) // после preGenerate
        {
            // ...
        }
        else // после generate
        {
            // ...
        }
    }

    /**
     * Расширение функционала карточек объектов
     *
     * @param object $card
     */
    public function extendCard(&$card)
    {
        // ...
    }

    /**
     * Расширение функционала форм объектов
     *
     * @param object $form
     */
    public function extendForm(&$form)
    {
        // ...
    }

    /**
     * Расширение функционала виджетов объектов
     *
     * @param object $widget
     * @param int $step
     */
    public function extendWidget(&$widget, $step)
    {
        if ($step == 1) // после preGenerate
        {
            // ...
        }
        else // после generate
        {
            // ...
        }
    }

    /**
     * Обработка дополнительных действий
     *
     * @param object $module
     */
    public function processAction(&$module)
    {
        // ...
    }

    /**
     * Добавление дополнительных действий над объектами
     *
     * @param array $actions
     */
    public function extendActions(&$actions)
    {
        // ...
    }

    /**
     * Действия перед созданием объектов
     *
     * @param array $object
     */
    public function onBeforeCreate(&$object)
    {
        // ...
    }

    /**
     * Действия после создания объектов
     *
     * @param int $id
     * @param array $object
     */
    public function onAfterCreate($id, $object)
    {
        // ...
    }

    /**
     * Действия перед редактированием объектов
     *
     * @param int $id
     * @param array $object
     */
    public function onBeforeEdit($id, &$object)
    {
        // ...
    }

    /**
     * Действия после редактирования объектов
     *
     * @param int $id
     * @param array $object
     */
    public function onAfterEdit($id, $object)
    {
        // ...
    }

    /**
     * Действия перед удалением объектов
     *
     * @param int $id
     */
    public function onBeforeDelete($id)
    {
        // ...
    }

    /**
     * Действия после удаления объектов
     *
     * @param int $id
     */
    public function onAfterDelete($id, $deletedObject=false)
    {
        // ...
    }
}
?>