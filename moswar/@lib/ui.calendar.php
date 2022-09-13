<?php
class CalendarUIE extends UserInterfaceElement implements IUserInterfaceElement
{
    public $format = "d.m.Y H:i";
    public $date = true;
    public $time = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function setParams($params)
    {
        parent::setParams($params);
        if (isset($params['date']) && !$params['date'])
        {
            $this->date = false;
        }
        if (isset($params['time']) && !$params['time'])
        {
            $this->time = false;
        }
        if (isset($params['format']) && $params['format'])
        {
            $this->format = $params['format'];
        }
    }

    public function getHtml()
    {
        if ($this->value)
        {
            if ($this->value == 'NOW')
            {
                $value = date($this->format, time());
            }
            else
            {
                if ($this->value == '0000-00-00' || $this->value == '0000-00-00 00:00:00')
                {
                    $value = '';
                }
                else
                {
                    $value = '';
                    $dt = explode(' ', $this->value);
                    if ($this->date)
                    {
                        $d = explode('-', $dt[0]);
                        $value .= $d[2].'.'.$d[1].'.'.$d[0];
                    }
                    if ($this->time)
                    {
                        $t = explode(':', $dt[1]);
                        $value .= ($this->date ? ' ' : '').$t[0].':'.$t[1];
                    }
                }
            }
        }
        if ($this->readOnly)
        {
            return $value.'<input type="hidden" name="'.$this->name.'" id="'.$this->name.'-id" value="'.$value.'" />';
        }
        else
        {
            return '
                <input type="text" name="'.$this->name.'" id="'.$this->name.'-id" '.$this->attributes.' value="'.$value.'" style="width:120px;" />
                <img align="absmiddle" src="/@contentico/@img/ui/calendar.gif" style="cursor:pointer;" onclick="popUpCalendar(this, document.getElementById(\''.$this->name.'-id\'), \'dd.mm.yyyy\', '.($this->time ? 'true' : 'false').');"/>
                <script type="text/javascript">jQuery(function($){$("#'.$this->name.'-id").mask("'.($this->date?'99.99.9999':'').($this->time?($this->date?' ':'').'99:99':'').'",{placeholder:"_"});});</script>
            ';
        }
    }
}
?>