<?php
class News extends Page implements IModule
{
    public $moduleCode = 'News';

    private $newsPerPage = 10;

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //

        Std::loadLib('HtmlTools');

        // сохранение последней прочитанной новости
        if (self::$player2 != null) {
			if (self::$player2->lastnews != $this->getData('lastnews', "SELECT id FROM news ORDER BY id DESC", 'value', 600)) {
				self::$player2->lastnews = $this->getData('lastnews', "SELECT id FROM news ORDER BY id DESC", 'value', 600);
				self::$player2->save(self::$player2->id, array(player2Object::$LASTNEWS));
			}
        }

        Std::loadMetaObjectClass('news');

        $page = abs((int)$this->url[0]);
        $page = $page >= 1 ? $page : 1;
        $offset = ($page - 1) * $this->newsPerPage;

        $news = self::$sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS id, dt, text FROM news
            WHERE dt<now() ORDER BY dt DESC LIMIT $offset, " . $this->newsPerPage);
        $total = self::$sql->getValue("SELECT found_rows()");

        foreach ($news as $i => &$item) {
            $item['dt'] = HtmlTools::FormatDateTime($item['dt'], false, true, false);
        }

        $this->content['news'] = $news;

        $this->content['page'] = $page;
        $this->content['pages'] = Page::generatePages($page, ceil($total / $this->newsPerPage), 3);

        $this->content['window-name'] = NewsLang::NEWS;
        $this->page->addPart('content', 'news/news.xsl', $this->content);
        //
        parent::onAfterProcessRequest();
    }
}
?>