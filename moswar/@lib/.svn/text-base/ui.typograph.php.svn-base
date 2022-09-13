<?php
class TypographUIE extends UserInterfaceElement implements IUserInterfaceElement
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
        $isHtml = preg_match('/<p(.*?)>/ims', $this->value) ? true : false;
        if (!$isHtml)
        {
            $this->value = nl2br($this->value);
        }
        return $this->value;
    }
}
?>