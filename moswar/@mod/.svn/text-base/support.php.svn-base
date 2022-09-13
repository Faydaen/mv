<?php
class Support extends Page implements IModule
{
    public $moduleCode = 'Support';

    public function __construct()
    {
        parent::__construct();
    }

    public function processRequest()
    {
        parent::onBeforeProcessRequest();
        //
        $this->needAuth(false);

        if ($this->url[0] == 'send-message' && $_SERVER['REQUEST_METHOD'] == 'POST') {
			$text = '';
			if ($_POST['type'] == SupportLang::ACCRUAL_OF_HONEY) {
				if ($_POST['peymenttype'] == 'sms' && (strlen($_POST['phone']) < 10 || strlen($_POST['smsdata']) < 5)) {
					Page::addAlert(SupportLang::MESSAGE_SENT, SupportLang::REQUIRED_FIELDS_ARE_EMPTY);
					Std::redirect('/support/', true);
				}
				if ($_POST['paymenttype'] == 'sms') {
					$text = SupportLang::PHONE . $_POST['phone'] . PHP_EOL .
							SupportLang::PHONE_AND_TEXT . $_POST['smsdata'] . PHP_EOL . PHP_EOL;
				} else if ($_POST['paymenttype'] == 'other') {
					$text = SupportLang::PAYMENT_DETAILS . $_POST['paymentdata'] . PHP_EOL . PHP_EOL;
				}
			}
            Std::loadMetaObjectClass('support');
            $s = new supportObject();
            $s->name = htmlspecialchars($text . $_POST['name']);
            $s->dt = date('Y-m-d H:i:s', time());
            $s->player = self::$player->id;
            $s->comment = $s->reply = '';
            $s->type = htmlspecialchars($_POST['type']);
            $s->priority = SupportLang::NORMAL; //'Высокий','Обычный','Низкий'
            $s->status = SupportLang::ADDED; //'Новое','Открыто','Закрыто'
            $s->sysuser = 0;
            $s->dt2 = '0000-00-00 00:00:00';
            $s->save();

            Page::addAlert(SupportLang::MESSAGE_SENT, SupportLang::MESSAGE_SENT_TO_RESPONSIBLE_PARTIES);
            Std::redirect('/support/', true);
        }

		$this->content['window-name'] = SupportLang::TECHNICAL_SUPPORT;
		$this->content['player'] = self::$player->toArray();
		$this->content['session'] = substr(md5(self::$player->password), 0, 10) . self::$player->id;
		$this->page->addPart('content', 'support/support.xsl', $this->content);
        //
        parent::onAfterProcessRequest();
    }
}
?>