<?php
class CheckboxUIE extends UserInterfaceElement implements IUserInterfaceElement
{
    public $label;

    public function __construct()
    {
        parent::__construct();
    }

    public function setParams($params)
    {
        parent::setParams($params);
        $this->label = isset($params['label']) && $params['label'] != '' ? $params['label'] : false;
    }

    public function getHtml()
    {
        if (is_numeric($this->value))
        {
            $value = $this->value ? true : false;
        }
        else
        {
            $value = $this->defaultValue ? true : false;
        }
        return '
            <input type="checkbox" name="'.$this->name.'" id="'.$this->name.'" '.$this->attributes.' '.($value ? 'checked="checked"' : '').' />
            '.($this->label ? '<label for="'.$this->name.'">'.$this->label.'</label>' : '').'
        ';
    }
}
?>