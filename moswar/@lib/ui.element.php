<?php
/**
 * Базовый класс для элементов пользовательского интерфейса
 *
 */
class UserInterfaceElement implements IUserInterfaceElement
{
    protected $sql;
    protected $data = array();
    protected $value = '';
    protected $defaultValue = '';
    protected $params;
    protected $attributes = '';
    protected $id = '';
    protected $name = '';
    protected $readOnly = false;
    protected $mode = self::MODE_FORM;
    //
    const MODE_FORM = 1;
    const MODE_CARD = 2;
    const MODE_LIST = 3;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function setData($data)
    {
        if (is_array($data))
        {
            $this->data = $data;
        }
        else
        {
            $this->value = $data;
        }
    }

    public function setParams($params)
    {
        $this->params = $params;
        if ($params['readonly'])
        {
            $this->readOnly = true;
        }
    }

    public function setDefaultValue($value)
    {
        $this->defaultValue = $value;
       

    }

    public function getHtml()
    {

    }

    public function setAttributes($attributes)
    {
        if (is_array($attributes))
        {
            foreach ($attributes as $attribute=>$value)
            {
                $this->attributes .= $attribute.'="'.$value.'"';
            }
        }
        else
        {
            $this->attributes = $attributes;
        }
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
?>