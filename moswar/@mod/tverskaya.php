<?php
class Tverskaya extends Page implements IModule
{
    public $moduleCode = 'Tverskaya';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $this->needAuth();
        //
		$this->showTverskaya();
        //
        parent::onAfterProcessRequest();
    }

    protected function showTverskaya()
	{
        $this->content['window-name'] = TverskayaLang::WINDOW_NAME;
		$this->page->addPart('content', 'tverskaya/tverskaya.xsl', $this->content);
	}
}
?>