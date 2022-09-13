<?php
class FileUIE extends UserInterfaceElement implements IUserInterfaceElement
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
        $CurrentFile = '';
        if ($this->value)
        {
            Std::loadLib('HtmlTools');
            $file = $this->sql->getRecord("SELECT path, name, size FROM stdfile WHERE id={$this->value}");
            $currentFile = '
                <div>
                    <a href="/@files/'.$file['path'].'" target="_blank">'.$file['name'].'</a> ('.HtmlTools::formatFileSize($file['size']).') &nbsp;
                    <input type="checkbox" name="'.$this->name.'-delete" id="'.$this->name.'-delete" /> <label for="'.$this->name.'-delete">удалить</label>
                </div>
            ';
        }
        return '
            <input type="file" name="'.$this->name.'" '.$this->attributes.' />
        '.$currentFile;
    }
}
?>