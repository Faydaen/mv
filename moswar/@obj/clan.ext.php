<?php
class clanExtention
{
    private $sql;
    
    public $extendsList = false;
    public $extendsWidget = false;
    public $extendsCard = false;
    public $extendsForm = false;
    public $extendsActions = false;
    public $eventsOnBeforeCreate = false;
    public $eventsOnAfterCreate = true;
    public $eventsOnBeforeEdit = false;
    public $eventsOnAfterEdit = true;
    public $eventsOnBeforeDelete = false;
    public $eventsOnAfterDelete = false;

    public function __construct()
    {
        $this->sql = SqlDataSource::getInstance();
    }

    public function extendList(&$list, $step)
    {
        if ($step == 1) // после PreGenerate
        {
            // ...
        }
        else // после Generate
        {
            // ...
        }
    }

    public function extendCard(&$card)
    {
        // ...
    }

    public function extendForm(&$form)
    {
        // ...
    }

    public function extendWidget(&$widget, $step)
    {
        if ($step == 1) // после preGenerate
        {
            // ...
        }
        else // после Generate
        {
             // ...
        }
    }

    public function processAction(&$module)
    {
        // ...
    }

    public function extendActions(&$actions)
    {
        // ...
    }

    public function onBeforeCreate(&$object)
    {
        // ...
    }

    public function onAfterCreate($id, $object)
    {
        $this->onAfterEditCreate($id, $object);
    }

    public function onBeforeEdit($id, &$object)
    {
        // ...
    }

    public function onAfterEdit($id, $object)
    {
        $this->onAfterEditCreate($id, $object);
    }

    public function onBeforeDelete($id)
    {
        // ...
    }

    public function onAfterDelete($id, $deletedObject=false)
    {
        // ...
    }

	public function onAfterEditCreate($id, $object) {
		Std::loadLib('ImageTools');
		if ($_FILES['ico']['name'] != '') {
			$tmp = $this->sql->getRecord("SELECT path, previewpath FROM stdimage WHERE id = " . $object->ico);
			if ($tmp) {
				ImageTools::resize('@images/' . $tmp['path'], '@images/clan/clan_' . $object->id . '_ico.png', 28, 16);
				ImageTools::resize('@images/' . $tmp['previewpath'], '@images/clan/@clan_' . $object->id . '_ico.png', 28, 16);
				$this->sql->query("UPDATE stdimage SET path = 'clan/clan_" . $object->id . "_ico.png', previewpath = 'clan/clan_" . $object->id . "_ico.png', name = 'clan_" . $object->id . "_ico.png' WHERE id = " . $object->ico);
				if ($tmp['path'] != 'clan/clan_' . $object->id . '_ico.png') {
					@unlink('@images/' . $tmp['path']);
					@unlink('@images/' . $tmp['previewpath']);
				}
			}
		}
		if ($_FILES['logo']['name'] != '') {
			$tmp = $this->sql->getRecord("SELECT path, previewpath FROM stdimage WHERE id = " . $object->logo);
			if ($tmp) {
				ImageTools::resize('@images/' . $tmp['path'], '@images/clan/clan_' . $object->id . '_logo.png', 99, 99);
				ImageTools::resize('@images/' . $tmp['previewpath'], '@images/clan/@clan_' . $object->id . '_logo.png', 99, 99);
				$this->sql->query("UPDATE stdimage SET path = 'clan/clan_" . $object->id . "_logo.png', previewpath = 'clan/clan_" . $object->id . "_logo.png', name = 'clan_" . $object->id . "_logo.png' WHERE id = " . $object->logo);
				@unlink('@images/' . $tmp['path']);
				@unlink('@images/' . $tmp['previewpath']);
				if ($tmp['path'] != 'clan/clan_' . $object->id . '_logo.png') {
					@unlink('@images/' . $tmp['path']);
					@unlink('@images/' . $tmp['previewpath']);
				}
			}
		}
		if (CONTENTICO) {
			CacheManager::delete('clan_full', array('clan_id' => $object->id));
			CacheManager::delete('clan_shortinfo', array('clan_id' => $object->id));
	}
}
}
?>