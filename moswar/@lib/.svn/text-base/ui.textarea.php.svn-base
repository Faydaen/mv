<?php
class TextareaUIE extends UserInterfaceElement implements IUserInterfaceElement
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
        return '
            <textarea name="'.$this->name.'" '.$this->attributes.'>'.($this->value == '' ? $this->defaultValue : str_replace('&', '&amp;', $this->value)).'</textarea>
        ';
    }
}
?>