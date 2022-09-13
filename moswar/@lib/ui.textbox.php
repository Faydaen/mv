<?php
class TextboxUIE extends UserInterfaceElement implements IUserInterfaceElement
{
    public $isPassword;
    public $mask;
	public $dtConverter;

    public function __construct()
    {
        parent::__construct();
    }

    public function setParams($params)
    {
        parent::setParams($params);
        $this->isPassword = isset($params['password']) && (int) $params['password'] ? true : false;
        $this->mask = $params['mask'] == '' ? false : $params['mask'];
		$this->dtConverter = isset($params["dtconverter"]) ? true : false;
    }

    public function getHtml()
    {
        return '
            <input type="'.($this->isPassword ? 'password' : 'text').'" name="'.$this->name.'" id="'.$this->name.'" value="'.($this->value == '' ? $this->defaultValue : ($this->isPassword ? '*****' : str_replace(array('&', '"'), array('&amp;', '&quot;'), $this->value))).'" '.$this->attributes.' />
            '.($this->mask ? '<script type="text/javascript">jQuery(function($){$("#'.$this->name.'").mask("'.$this->mask.'",{placeholder:"_"});});</script>' : '').'
            '.($this->dtConverter ? '<a href="javascript:void(0);" onclick="uiTextboxDateTimeToTimestamp(\'' . $this->name . '\')">datetime &larr;&rarr; timestamp</a>' : '') . '
        ';
    }
}
?>