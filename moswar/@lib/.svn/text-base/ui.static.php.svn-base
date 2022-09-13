<?php
class StaticUIE extends UserInterfaceElement implements IUserInterfaceElement
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setParams($params)
    {
        parent::setParams($params);
    }

    public function getHtml()
    {
        $value = $this->value == '' ? $this->defaultValue : str_replace('&', '&amp;', $this->value);
        return '
            '.$value.'<input type="hidden" name="'.$this->name.'" id="'.$this->name.'" value="'.$value.'" />
        ';
    }
}
?>