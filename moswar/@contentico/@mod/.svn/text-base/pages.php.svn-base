<?php
/**
 * Управление страницами
 *
 */
class Pages extends ContenticoModule implements IModule
{
    private $id = 1;
    private $sitemap = '';
    private $formApply = false;
    private $metaViewId = 0;
    private $action_param;
    
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
        $this->page['left-menu-pages'] = 'class="cur"';
        switch ($this->action)
        {
            case ACTION_LIST:
                $this->generateSitemap();
                $this->page['page-name'] = 'Управление страницами и разделами';
                break;
            case ACTION_CREATE:
            case ACTION_EDIT:
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $this->saveObject();
                }
                $this->path['Страницы'] = 'Pages';
                $this->generateForm();		
                $this->page['page-name'] = $this->action == ACTION_CREATE ? 'Добавить' : 'Редактировать';
                break;
            case ACTION_DELETE:
                $this->deleteObject();
                break;
            case ACTION_EXPORT:
                $this->exportToXml();
                break;
            case 'export-to-htmlarea':
                header('Content-Type: text/javascript');
                echo 'var tinyMCELinkList = new Array('.implode(',', $this->generateTreeForHtmlarea()).');';
                exit;
                break;
        }
        //
        parent::onAfterProcessRequest();
    }

    /**
     * Обработка адреса запроса
     *
     */
    private function processUrl()
    {
        for ($i = 0; $i < sizeof($this->url); $i++)
        {
            $urlPart = explode('=', $this->url[$i]);
            switch ($urlPart[0]) {
            	case 'action':
            	    $this->action = (int) $urlPart[1];
            	    break;
            	case 'id':
            	    $this->id = (int) $urlPart[1];
            	    break;
            	case 'apply':
            	    $this->formApply = true;
            	    break;
            	case 'metaview':
            	    $this->metaViewId = (int) $urlPart[1];
            	    break;
                case 'action-param':
                    $this->action_param = (string) $urlPart[1];
                    break;
            }
        }
    }

    /**
     * Дерево (список) страниц
     *
     */
    private function generateSitemap()
    {
        $this->generateSitemapLevel();
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('pages/table'), array(
            'tr'=>$this->sitemap,
            'more_button'=>'исчо',
            'ACTION_CREATE'=>ACTION_CREATE,
            'ACTION_EDIT'=>ACTION_EDIT,
            'ACTION_DELETE'=>ACTION_DELETE,
            'ACTION_EXPORT'=>ACTION_EXPORT,
            'ACTION_IMPORT'=>ACTION_IMPORT,
            'ID'=>$this->id,
        ));
    }

    private function generateSitemapLevel($id=0, $level=0, $i='')
    {
        $i = $i == '' ? '' : $i.'.';
        $pages = $this->sqlGetRecordSet("SELECT id, name, url FROM stdpage WHERE _id={$id} ORDER BY pos ASC");
        if ($pages)
        {
            $trTpl = Contentico::loadTemplate('pages/tr');
            $tr = '';
            $j = 1;
            foreach ($pages as $page)
            {
                $page['name'] = str_repeat('&nbsp;', ($level*4)).'<a href="/@contentico/Pages/action='.ACTION_EDIT.'/id='.$page['id'].'/">'.$page['name'].'</a>';
                $page['url'] = str_repeat('&nbsp;', ($level*4)).'/ '.$page['url'].' /';
                $page['i'] = $i.$j;
                $this->sitemap .= Std::renderTemplate($trTpl, $page);
                $this->generateSitemapLevel($page['id'], ($level+1), $i.$j);
                $j++;
            }
        }
    }

    /**
     * Форма добавления/редактирования страницы
     *
     */
    private function generateForm()
    {
        Std::loadLib('HtmlTools');
        $page = array();
        if ($this->action == ACTION_EDIT)
        {
            $page = $this->sqlGetRecord("SELECT * FROM stdpage WHERE id={$this->id}");
        }
        else
        {
            $page['_id'] = 0;
        }
        $pageSelect = '<option value="0">Сайт</option>';
        $this->generatePageSelect($pageSelect, 0, 1, $page['_id']);
        //
        $metaViewId = $this->sqlGetValue("SELECT mv.id FROM metaobject mo LEFT JOIN metaview mv ON mv.metaobject_id=mo.id WHERE mo.code='stdpage' AND mv.type=".META_VIEW_TYPE_FORM);
        $attributes = $this->sqlGetRecordSet("SELECT ma.id, ma.code, ma.type, ma.typeparam, mvf.name, mvf.uie, mvf.uieparams, mvf.defaultvalue, mvf.hint
            FROM metaviewfield mvf LEFT JOIN metaattribute ma ON ma.id=mvf.metaattribute_id WHERE metaview_id=$metaViewId AND ma.role=".META_ATTRIBUTE_ROLE_DATA." ORDER BY mvf.pos ASC");
        //
        $tr = '';
        $trTpl = Contentico::loadTemplate('form/tr');
        $hintTpl = Contentico::loadTemplate('form/hint');
        foreach ($attributes as $attribute)
        {
            $ui = Contentico::getFormControl($attribute);
            if ($this->action == ACTION_EDIT)
            {
                $ui->setData($page[$attribute['code']]);
            }
            $tr .= Std::renderTemplate($trTpl, array(
                'name' => $attribute['type'] == META_ATTRIBUTE_TYPE_BOOL ? '' : $attribute['name'].':',
                'control' => $ui->getHtml(),
                'hint' => $attribute['hint'] ? Std::renderTemplate($hintTpl, array('hint'=>$attribute['hint'])) : '',
            ));
            if ($attribute['code'] == 'name' && $object['name'] != '')
            {
                $this->page['page-name'] = $object['name'];
            }
        }
        $this->page['content'] = Std::renderTemplate(Contentico::loadTemplate('pages/form'), array(
            'content-fields'=>$tr,
            'url'=>$page['url'],
            'id'=>$this->action == ACTION_EDIT ? 'id='.$this->id.'/' : '',
            'action'=>$this->action,
            'page-select'=>$pageSelect,
            'template-select'=>HtmlTools::generateOptions("SELECT id, name FROM stdtemplate", $page['stdtemplate_id']),
            'module-select'=>HtmlTools::generateOptions("SELECT id, name FROM stdmodule", $page['stdmodule_id']),
            'htmlarea'=>$this->sqlGetValue("SELECT cfghtmlarea FROM sysuser WHERE id=".Runtime::$uid) == 1 ? 'ui-htmlarea ' : '',
            'ui-htmlarea-init'=>Std::renderTemplate(Contentico::loadTemplate('ui.htmlarea'), array(
                'style-select'=>Contentico::uiHtmlareaGetStyleSelect(),
            )),
            'metaview'=>$metaViewId,
        ));
    }

    /**
     * Генерация select'а родительской страницы
     *
     * @param string $pageSelect
     * @param int $id
     * @param int $level
     * @param int $_id
     */
    private function generatePageSelect(&$pageSelect, $id, $level, $parentId)
    {
        $pages = $this->sqlGetRecordSet("SELECT id, name FROM stdpage WHERE _id=$id AND id!=".$this->id." ORDER BY pos ASC");
        if ($pages)
        {
            foreach ($pages as $page)
            {
                $pageSelect .= '<option value="'.$page['id'].'" '.($page['id'] == $parentId ? 'selected="selected"' : '').'>'.str_repeat('&nbsp;', ($level*3)).$page['name'].'</option>';
                $this->generatePageSelect($pageSelect, $page['id'], ($level + 1), $parentId);
            }
        }
    }

    /**
     * Создание/сохранение страницы
     *
     */
    private function saveObject()
    {
        Std::loadMetaObjectClass('stdpage');
        $page = new stdpageObject();
        $page->metaViewId = $this->metaViewId;
        $id = $this->action == ACTION_CREATE ? 0 : $this->id;
        $page->initFromForm($id);
		$page->content = htmlspecialchars_decode(stripslashes($page->content));
        $page->url = Std::cleanString($_POST['url']);
        $page->stdtemplate_id = (int) $_POST['stdtemplate_id'];
        $page->stdmodule_id = (int) $_POST['stdmodule_id'];
        $page->_id = (int) $_POST['_id'];		
        if ($page->pos == 0)
        {
            $page->pos = $this->sqlGetValue("SELECT pos FROM stdpage WHERE _id={$page->_id} ORDER BY pos DESC LIMIT 0,1");
            $page->pos += 1;
        }
        if ($page->url == '')
        {
            if ($page->_id == 0 && $this->sqlGetValue("SELECT count(*) FROM stdpage WHERE _id=0 AND pos<".$page->pos) == 0)
            {
                $page->url = 'index';
            }
            else
            {
                $page->url = strtolower(Std::translit($page->name));
            }
        }
        $page->save();
        //
        if (isset($_POST['sitemap-xml']))
        {
            file_put_contents('sitemap.xml', $this->generateSitemapXml());
        }
        //
        if ($this->formApply)
        {
            header('Location: /@contentico/Pages/action='.ACTION_EDIT.'/id='.$this->id.'/');
        }
        else
        {
            header('Location: /@contentico/Pages/');
        }
        exit;
    }

    /**
     * Удаление страницы
     *
     */
    private function deleteObject()
    {
        $this->cascadeDelete($this->id);
        //
        file_put_contents('sitemap.xml', $this->generateSitemapXml());
        //
        exit;
    }

    private function cascadeDelete($id)
    {
        $subPages = $this->sqlGetValueSet("SELECT id FROM stdpage WHERE _id=$id");
        if ($subPages)
        {
            foreach ($subPages as $subPageId)
            {
                $this->cascadeDelete($subPageId);
            }
        }
        $this->sqlQuery("DELETE FROM stdpage WHERE id=$id");
    }

    /**
     * Генерация дерева страниц для визуального редактора
     *
     * @return string
     */
    private function generateTreeForHtmlarea()
    {
        $tree = array();
        $pages = $this->sqlGetRecordSet("SELECT p.id, p.name, p.url, (SELECT count(*) FROM stdpage WHERE _id=p.id) children FROM stdpage p WHERE p._id=0 ORDER BY p.pos ASC");
        if ($pages)
        {
            foreach ($pages as $page)
            {
                $page['name'] = strlen($page['name']) > 20 ? substr($page['name'], 0, 20).'...' : $page['name'];
                if ($page['url'] == 'index')
                {
                    $tree[] = '["'.$page['name'].'", "/"]';
                }
                else
                {
                    $tree[] = '["'.$page['name'].'", "/'.$page['url'].'/"]';
                }
                if ($page['children'])
                {
                    $this->generateTreeForHtmlareaLevel($tree, $page['id'], 1, '/'.$page['url'].'/');
                }
            }
        }
        return $tree;
    }

    private function generateTreeForHtmlareaLevel(&$tree, $parentPageID, $level, $path)
    {
        $pages = $this->sqlGetRecordSet("SELECT p.id, p.name, p.url, (SELECT count(*) FROM stdpage WHERE _id=p.id) children FROM stdpage p WHERE p._id=$parentPageId ORDER BY p.pos ASC");
        if ($pages)
        {
            foreach ($pages as $page)
            {
                $page['name'] = strlen($page['name']) > 20 ? substr($page['name'], 0, 20).'...' : $page['name'];
                $tree[] = '["'.str_repeat(' -', $level).' '.$page['name'].'", "'.$path.$page['url'].'/"]';
                if ($page['children'])
                {
                    $this->generateTreeForHtmlareaLevel($tree, $page['id'], ($level + 1), $path.$page['url'].'/');
                }
            }
        }
    }

    /**
     * Генерация файла sitemap.xml
     *
     * @return string
     */
    private function generateSitemapXml()
    {
        $priorityIndex = '1.0';
        $priority = '0.5';
        $changefreqIndex = 'always';
        $changefreqModule = 'daily';
        $changefreqStatic = 'weekly';
        //
        $tree = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        //
        $pages = $this->sqlGetRecordSet("SELECT p.id, p.name, p.url, p.stdmodule_id, (SELECT count(*) FROM stdpage WHERE _id=p.id) children FROM stdpage p WHERE p._id=0 ORDER BY p.pos ASC");
        if ($pages)
        {
            foreach ($pages as $page)
            {
                $tree .= '
                    <url>
                        <loc>http://'.$_SERVER['HTTP_HOST'].'/'.($page['url'] == 'index' ? '' : $page['url'].'/').'</loc>
                        <lastmod>'.date("Y-m-d", time()).'</lastmod>
                        <changefreq>'.($page['url'] == 'index' ? $changefreqIndex : ($page['stdmodule_id'] > 1 ? $changefreqModule : $changefreqStatic)).'</changefreq>
                        <priority>'.($page['url'] == 'index' ? $priorityIndex : $priority).'</priority>
                    </url>';
                if ($page['children'])
                {
                    $this->generateSitemapXmlLevel($tree, $page['id'], '/'.$page['url'].'/');
                }
            }
        }
        //
        return $tree.'</urlset>';
    }

    private function generateSitemapXmlLevel(&$tree, $parentPageID, $path)
    {
        $priority = '0.5';
        $changefreqModule = 'daily';
        $changefreqStatic = 'weekly';
        //
        $pages = $this->sqlGetRecordSet("SELECT p.id, p.name, p.url, p.stdmodule_id, (SELECT count(*) FROM stdpage WHERE _id=p.id) children FROM stdpage p WHERE p._id=$parentPageId ORDER BY p.pos ASC");
        if ($pages)
        {
            foreach ($pages as $page)
            {
                $tree .= '
                    <url>
                        <loc>http://'.$_SERVER['HTTP_HOST'].$path.$page['url'].'/</loc>
                        <lastmod>'.date("Y-m-d", time()).'</lastmod>
                        <changefreq>'.($page['stdmodule_id'] > 1 ? $changefreqModule : $changefreqStatic).'</changefreq>
                        <priority>'.$priority.'</priority>
                    </url>';
                if ($page['children'])
                {
                    $this->generateSitemapXmlLevel($tree, $page['id'], $path.$page['url'].'/');
                }
            }
        }
    }

    /**
     * Экспорт в ХМЛ
     *
     *
     */
    private function exportToXml()
    {
        $params = explode("|", $this->action_param);
        $exportType = $params[0];
        switch ($exportType) {
            case 1: // все
                $objects = $this->sqlGetRecordSet("SELECT * FROM `stdpage`");
                break;

            case 2: // отмеченные
                $id = explode(",", trim($params[1], ","));
                $objects = $this->sqlGetRecordSet("SELECT * FROM `stdpage` WHERE id IN (" . implode(",", $id) . ")");
                break;

            case 3: // отфильтрованные
                $objects = $this->sqlGetRecordSet("SELECT * FROM `stdpage`" . $this->generateFiltersForExport());
                break;
        }

        $xml = '<?xml version="1.0" encoding="utf-8"?>
<contentico>
    <metaobject code="stdpage">
';
                if ($objects) {
                    $metaAttributes = $this->sqlGetRecordSet("SELECT code, type FROM metaattribute WHERE metaobject_id = 11");
                    $strings = array();
                    foreach ($metaAttributes as $metaAttribute) {
                        if (in_array($metaAttribute["type"], array(META_ATTRIBUTE_TYPE_STRING, META_ATTRIBUTE_TYPE_TEXT,
                            META_ATTRIBUTE_TYPE_BIGTEXT, META_ATTRIBUTE_TYPE_DATA, META_ATTRIBUTE_TYPE_CUSTOM))) {
                            $strings[] = $metaAttribute["code"];
                        }
                    }

                    foreach ($objects as $i => $object) {
                        $stringParams = "";
                        $nonStringParams = array();
                        foreach ($object as $code => $value) {
                            if (in_array($code, $strings)) {
                                $stringParams .= '          <' . $code . '><![CDATA[' . trim($value) . ']]></' . $code . '>
';
                            } else {
                                $nonStringParams[] = $code . '="' . $value . '"';
                            }
                        }
                        $xml .= '       <object' . (sizeof($nonStringParams) > 0 ? " " . implode(" ", $nonStringParams) : "") . '>
' . $stringParams . '       </object>
';
                    }
                }
                $xml .= '   </metaobject>
</contentico>';

        header('Content-Disposition: attachment; filename="page.xml"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($xml));
        header('Cache-Control: max-age=3600, must-revalidate');
        header('HTTP/1.0 200 OK');
        echo $xml;
        exit;
    }
}
?>