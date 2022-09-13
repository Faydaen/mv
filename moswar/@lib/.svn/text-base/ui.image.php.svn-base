<?php
class ImageUIE extends UserInterfaceElement implements IUserInterfaceElement, IUserInterfaceElement
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
        $currentImage = '';
        if ($this->value)
        {
            $image = $this->sql->getRecord("SELECT path, previewpath FROM stdimage WHERE id={$this->value}");
            $currentImage = '
                <div>
                    <a href="/@images/'.$image['path'].'" target="_blank"><img src="/@images/'.$image['previewpath'].'" /></a> &nbsp;
                    <input type="checkbox" name="'.$this->name.'-delete" id="'.$this->name.'-delete" /> <label for="'.$this->name.'-delete">удалить</label>
                </div>
            ';
        }
        return '
            <input type="file" name="'.$this->name.'" '.$this->attributes.' onchange="if(this.value.substr(-3,3)!=\'png\'&&this.value.substr(-3,3)!=\'jpg\'&&this.value.substring(-3,3)!=\'jpeg\'&&this.value.substr(-3,3)!=\'gif\'){this.value=\'\';alert(\'Ошибка: выбранный файл не является картинкой.\');}" />
        '.$currentImage;
    }
}
?>