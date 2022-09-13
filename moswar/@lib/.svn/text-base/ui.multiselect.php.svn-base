<?php
class MultiSelectUIE extends UserInterfaceElement implements IUserInterfaceElement
{
    public $allowNone = true;
    public $options = array();

    public function __construct()
    {
        parent::__construct();
        $this->value = array();
    }

    public function setParams($params)
    {
        parent::setParams($params);
        if (isset($params['allow-none']) && !$params['allow-none'])
        {
            $this->allowNone = false;
        }
        $this->options = $params['options'];
    }

    public function getHtml()
    {
        $options = $this->allowNone ? '<option value="0">- нет -</option>' : '';
        if ($this->options)
        {
            foreach ($this->options as $value=>$label)
            {
                if (is_array($label))
                {
                    $options .= '<option value="'.$label['id'].'" '.(in_array($label['id'], $this->data) ? 'selected="selected"' : '').'>'.$label['name'].'</option>';
                }
                else
                {
                    $options .= '<option value="'.$value.'" '.(in_array($value, $this->data) ? 'selected="selected"' : '').'>'.$label.'</option>';
                }
            }
        }
        return '
            <select name="'.$this->name.'[]" '.$this->attributes.' size="5" multiple="multiple">'.$options.'</select>
            <div class="hint">Вы можете выбрать несколько элементов, зажав клавишу Ctrl.</div>
        ';
    }
}
?>