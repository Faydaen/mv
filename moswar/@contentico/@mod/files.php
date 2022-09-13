<?php
/**
 * Модуль управления файлами и картинками
 *
 */
class Files extends ContenticoModule implements IModule
{
    private $id = 1;
    private $type = self::TYPE_FILES;
    
    const TYPE_FILES = 1;
    const TYPE_IMAGES = 2;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Обработка запроса
     *
     */
    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $this->processUrl();
        $this->initParams();
        $this->page['left-menu-files'] = 'class="cur"';
        switch ($this->action)
        {
            case ACTION_LIST:
                $this->generateList();
                $this->page['page-name'] = 'Файлы и картинки';
                break;
            case ACTION_CREATE:
            case ACTION_EDIT:
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $this->SaveObject();
                }
                $this->path['Файлы и картинки'] = 'Files';
                $this->generateForm();
                $this->page['page-name'] = $this->action == ACTION_CREATE ? 'Добавить' : 'Редактировать';
                break;
            case ACTION_DELETE:
                $this->deleteObject();
                break;
            case 'export-images-to-htmlarea':
                header('Content-Type: text/javascript');
                echo 'var tinyMCEImageList = new Array('.implode(',', $this->generateImageListForHtmlarea()).');';
                exit;
                break;
            case 'export-files-to-htmlarea':
                header('Content-Type: text/javascript');
                echo 'var tinyMCELinkList2 = new Array('.implode(',', $this->generateFilesListForHtmlarea()).');';
                exit;
                break;
            case 'upload-image-from-htmlarea':
                $this->uploadImageFromHtmlarea();
                break;
        }
        //
        $this->page['content'] = $this->replaceCommonValues($this->page['content']);
        //
        parent::onAfterProcessRequest();
    }

    private function replaceCommonValues($content)
    {
        return Std::renderTemplate($content, array(
            'TYPE_FILES'    => self::TYPE_FILES,
            'TYPE_IMAGES'   => self::TYPE_IMAGES,
            'ACTION_CREATE' => ACTION_CREATE,
            'ACTION_EDIT'   => ACTION_EDIT,
            'ACTION_DELETE' => ACTION_DELETE,
            'ACTION_LIST'   => ACTION_LIST,
        ));
    }

    /**
     * Обработка адреса запроса
     *
     */
    private function processUrl()
    {
        for ($i = 0; $i < sizeof($this->Url); $i++)
        {
            $urlPart = explode('=', $this->Url[$i]);
            switch ($urlPart[0]) {
            	case 'action':
            	    $this->action = $urlPart[1];
            	    break;
            	case 'id':
            	    $this->id = (int)$urlPart[1];
            	    break;
            	case 'apply':
            	    $this->formApply = true;
            	    break;
            	case 'type':
            	    $this->type = $_SESSION['@contentico']['Files']['type'] = (int)$urlPart[1];
            	    break;
            }
        }
    }

    /**
     * Инициализация параметров
     *
     */
    private function initParams()
    {
        $this->type = $_SESSION['@contentico']['Files']['type'] ? $_SESSION['@contentico']['Files']['type'] : $this->type;
    }

    /**
     * Генерация списка
     *
     */
    private function generateList()
    {
        Std::loadLib('HtmlTools');
        $rows = $this->sqlGetRecordSet("SELECT id, name, dt, path FROM ".($this->type == self::TYPE_FILES ? "stdfile" : "stdimage")."  WHERE attached=0 ORDER BY dt DESC");
        if ($rows)
        {
            $trTpl = Contentico::loadTemplate('files/tr');
            $tr = '';
            $i = $this->offset + 1;
            foreach ($rows as $row)
            {
                $row['name'] = '<a href="/@'.($this->type == self::TYPE_FILES ? 'files' : 'images').'/'.$row['path'].'" target="_blank">'.$row['name'].'</a>';
                $row['dt'] = HtmlTools::formatDateTime($row['dt']);
                $row['i'] = $i;
                $tr .= Std::renderTemplate($trTpl, $row);
                $i++;
            }
        }
        else
        {
            $tr = '<tr><td colspan="5" align="center"><em>'.($this->type == self::TYPE_FILES ? 'Файлов' : 'Картинок').' нет.</em></td></tr>';
        }
        $tableTpl = Std::renderTemplate(Contentico::loadTemplate('files/table'), array(
            'tr'=>$tr,
            'ID'=>$this->id,
            'cur-files'=>$this->type == self::TYPE_FILES ? 'class="cur"' : '',
            'cur-images'=>$this->type == self::TYPE_IMAGES ? 'class="cur"' : '',
        ));
        $this->page['content'] = $tableTpl;
    }

    /**
     * Генерация формы
     *
     */
    private function generateForm()
    {
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('files/form'), array(
            'id'=>$this->action == ACTION_EDIT ? 'id='.$this->id.'/' : '',
            'action'=>$this->action,
        ));
    }

    /**
     * Сохранение файлов
     *
     */
    private function saveObject()
    {
        Std::loadMetaObjectClass('stdpage');
        if ($this->type == self::TYPE_FILES)
        {
            if ($this->action == ACTION_EDIT)
            {
                $oldPath = $this->sqlGetValue("SELECT path FROM stdfile WHERE id={$this->ID}");
                unlink('@files/'.$oldPath);
            }
            $name = $_FILES['file']['name'];
            $file = Std::translit($name);
            $path = Std::getNextFreeFileName('@files/upload/'.$file);
            $size = $_FILES['file']['size'];
            $ext = explode('.', $name);
            $typeId = $this->sqlGetValue("SELECT id FROM stdfiletype WHERE ext='".$ext[count($ext)-1]."'");
            if (!$typeId)
            {
                $typeId = 1;
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], '@files/'.$path))
            {
                if ($this->action == ACTION_EDIT)
                {
                    $this->sqlQuery("UPDATE stdfile SET path='$path', name='$name', size=$size, type_id=$typeId, dt=now() WHERE id=".$this->id);
                }
                else
                {
                    $this->sqlInsert("INSERT INTO stdfile (file, path, name, size, type_id, dt, attached) VALUES ('', '$path', '$name', $size, $typeId, now(), 0)");
                }
            }
        }
        else
        {
            if (!is_dir('@images/upload'))
            {
                mkdir('@images/upload');
            }
            if ($this->action == ACTION_EDIT)
            {
                $oldPaths = $this->sqlGetRecord("SELECT path, previewpath FROM stdimage WHERE id=".$this->id);
                unlink('@images/'.$oldPaths['path']);
                unlink('@images/'.$oldPaths['previewpath']);
            }
            $name = $_FILES['file']['name'];
            $file = Std::translit($name);
            $path = Std::getNextFreeFileName('@images/upload/'.$file);
            $previewPath = Std::getNextFreeFileName('@images/upload/@'.$file);
            $size = $_FILES['file']['size'];
            $ext = explode('.', $name);
            $typeId = $this->sqlGetValue("SELECT id FROM stdfiletype WHERE ext='".$ext[count($ext)-1]."'");
            if (!$typeId)
            {
                $typeId = 1;
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], '@images/'.$path))
            {
                Std::loadLib('imagetools');
                list($width, $height) = ImageTools::getSize('@images/'.$path);
                ImageTools::createThumbnail('@images/'.$path, '@images/'.$previewPath);
                if ($this->action == ACTION_EDIT)
                {
                    $this->sqlQuery("UPDATE stdimage SET path='$path', previewpath='$previewPath', name='$name', width=$width, height=$height,
                        size=$size, type_id=$typeId, dt=now() WHERE id=".$this->id);
                }
                else
                {
                    $this->sqlInsert("INSERT INTO stdimage (image, preview, path, previewpath, name, width, height, size, type_id, dt, attached)
                        VALUES ('', '', '$path', '$previewPath', '$name', $width, $height, $size, $typeId, now(), 0)");
                }
            }
        }
        header('Location: /@contentico/Files/');
        exit;
    }

    /**
     * Удаление файлов
     *
     */
    private function deleteObject()
    {
        if ($this->type == self::TYPE_FILES)
        {
            $oldPath = $this->sqlGetValue("SELECT path FROM stdfile WHERE id=".$this->id);
            unlink('@files/'.$oldPath);
            $this->sqlQuery("DELETE FROM stdfile WHERE id=".$this->id);
        }
        else
        {
            $oldPaths = $this->sqlGetRecord("SELECT path, previewpath FROM stdimage WHERE id=".$this->id);
            unlink('@images/'.$oldPaths['path']);
            unlink('@images/'.$oldPaths['previewpath']);
            $this->sqlQuery("DELETE FROM stdimage WHERE id=".$this->id);
        }
        header('Location: /@contentico/Files/');
        exit;
    }

    /**
     * Генерация списка картинок для экспорта в визуальный редактор
     *
     * @return string
     */
    private function generateImageListForHtmlarea()
    {
        $imageList = array();
        $images = $this->sqlGetRecordSet("SELECT name, path FROM stdimage WHERE attached=0 ORDER BY name ASC");
        if ($images)
        {
            foreach ($images as $image)
            {
                $name = strlen($image['name']) > 30 ? substr($image['name'], 0, 30).'...' : $image['name'];
                $imageList[] = '["'.$name.'", "/@images/'.$image['path'].'"]';
            }
        }
        return $imageList;
    }

    /**
     * Генерация списка файлов для экспорта в визуальный редактор
     *
     * @return string
     */
    private function generateFilesListForHtmlarea()
    {
        $fileList = array();
        $files = $this->sqlGetRecordSet("SELECT id, name, path FROM stdfile WHERE attached=0 ORDER BY name ASC");
        if ($files)
        {
            foreach ($files as $file)
            {
                $name = strlen($file['name']) > 20 ? substr($file['name'], 0, 20).'...' : $file['name'];
                $fileList[] = '["'.$name.'", "/@files/'.$file['id'].'/"]';
            }
        }
        return $fileList;
    }

    /**
     * Загрузка картинки из визуального редактора
     *
     */
    private function uploadImageFromHtmlarea()
    {
        if (!is_dir('@images/upload'))
        {
            mkdir('@images/upload');
        }
        $name = $_FILES['image']['name'];
        $file = Std::translit($name);
        $path = Std::getNextFreeFileName('@images/upload/'.$file);
        $previewPath = Std::getNextFreeFileName('@images/upload/@'.$file);
        $size = $_FILES['image']['size'];
        $ext = explode('.', $name);
        $typeId = $this->sqlGetValue("SELECT id FROM stdfiletype WHERE ext='".$ext[count($ext)-1]."'");
        if (!$typeId)
        {
            $typeId = 1;
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], '@images/'.$path))
        {
            Std::loadLib('imagetools');
            list($width, $height) = ImageTools::getSize('@images/'.$path);
            ImageTools::createThumbnail('@images/'.$path, '@images/'.$previewPath);
            $this->sqlInsert("INSERT INTO stdimage (image, preview, path, previewpath, name, width, height, size, type_id, dt, attached)
                VALUES ('', '', '$path', '$previewPath', '$name', $width, $height, $size, $typeId, now(), 0)");
            echo '
                <script type="text/javascript">
                    parent.window.document.getElementById("src").value = "/@images/'.$path.'";
                    parent.window.document.getElementById("image-to-upload").value = "";
                    parent.window.ImageDialog.update();
                </script>
            ';
            exit;
        }
    }
}
?>