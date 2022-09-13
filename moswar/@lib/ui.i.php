<?php
/**
 * Интерфейс класса элемента пользовательского интерфейса
 *
 */
interface IUserInterfaceElement
{
    public function setData($data);

    public function setParams($params);

    public function setDefaultValue($value);

    public function setAttributes($attributes);

    public function getHtml();
}
?>