<?php
class SelectUIE extends UserInterfaceElement implements IUserInterfaceElement
{
    public $allowNone = true;
    public $options = array();
    public $count = 0;
    public $maxCount = 100;
    public $metaObject;
    public $metaAttribute;

    public function __construct()
    {
        parent::__construct();
    }

    public function setParams($params)
    {
        parent::setParams($params);
        if (isset($params['allow-none']) && !$params['allow-none'])
        {
            $this->allowNone = false;
        }
        if (is_array($params['options']))
        {
            $this->options = $params['options'];
            $this->count = sizeof($this->options);
        }
        elseif ($params['options'] != '')
        {
            $countQuery = preg_replace('/SELECT (.*?) FROM/i', 'SELECT count(*) FROM', $params['options']);
            $this->count = $this->sql->getValue($countQuery);
            if ($this->count <= $this->maxCount)
            {
                $this->options = $this->sql->getRecordSet($params['options']);
            }
        }
        $this->metaObject = $params['metaobject'];
        $this->metaAttribute = $params['metaattribute'];
    }

    public function getHtml()
    {
        $this->value = $this->value == '' ? $this->defaultValue : $this->value;
        if ($this->count <= $this->maxCount || !$this->metaObject || !$this->metaAttribute)
        {
            $options = $this->allowNone ? '<option value="0">- нет -</option>' : '';
            if ($this->options)
            {
                foreach ($this->options as $value=>$label)
                {
                    if (is_array($label))
                    {
                        $options .= '<option value="'.$label['id'].'" '.($label['id'] == $this->value ? 'selected="selected"' : '').'>'.$label['name'].'</option>';
                    }
                    else
                    {
                        $options .= '<option value="'.$value.'" '.($value == $this->value ? 'selected="selected"' : '').'>'.$label.'</option>';
                    }
                }
            }
            return '
                <select name="'.$this->name.'" '.$this->attributes.'>'.$options.'</select>
            ';
        }
        else
        {
            $value = $this->value ? $this->sql->getValue("SELECT `{$this->metaAttribute}` FROM `{$this->metaObject}` WHERE id={$this->value}") : '<em>нет</em>';
            $value = strlen($value) > 100 ? substr($value, 0, 100) . '&hellip;' : $value;
            return '
                <div style="height:20px;" id="'.$this->name.'-label">'.$value.'</div>
                ID: <input type="text" class="small" id="'.$this->name.'-id" '.$this->attributes.' />
                Значение: <input type="text" class="quarter" id="'.$this->name.'-name" '.$this->attributes.' />
                <input type="button" value="Искать" onclick="ContenticoMetaobjectsUISelectSearch(\''.$this->metaObject.'\', \''.$this->metaAttribute.'\', \''.$this->name.'\');" />
                <input type="hidden" name="'.$this->name.'" id="'.$this->name.'" value="'.$this->value.'" />
            ';
        }
    }
}
?>