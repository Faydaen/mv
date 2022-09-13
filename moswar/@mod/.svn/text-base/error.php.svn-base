<?php
class Error extends Page implements IModule
{
    public $moduleCode = 'Error';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $error = $_GET['url'];
        switch ($error)
		{
			case '404':
				header("HTTP/1.0 404 Not Found");
				break;

			case '500':
				//header("HTTP/1.0 500 Internal Server Error");
				break;

            case '502':
				break;
		}
        $this->page->setTemplate('error.html');
        $this->page->addPart('content', 'error.xsl', array('error' => $error));
        //
        parent::onAfterProcessRequest();
    }
}
?>