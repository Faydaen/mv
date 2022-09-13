<?php
class jobBaseObject extends Object
{
	public static $METAOBJECT = 'job';
    public static $ID_METAATTRIBUTE = 'job.id';
 	public static $ID = 'job.id';
    public $name = '';
    public static $NAME = 'job.name';
    public $code = '';
    public static $CODE = 'job.code';
    public $position = 0;
    public static $POSITION = 'job.position';
    public $location = '';
    public static $LOCATION = 'job.location';
    public $energy = 0;
    public static $ENERGY = 'job.energy';
    public $player_level = 0;
    public static $PLAYER_LEVEL = 'job.player_level';
    public $levels = 0;
    public static $LEVELS = 'job.levels';
    public $clicks = 0;
    public static $CLICKS = 'job.clicks';
    public $title = '';
    public static $TITLE = 'job.title';
    public $image = '';
    public static $IMAGE = 'job.image';
    public $text = '';
    public static $TEXT = 'job.text';
    public $text_doing = '';
    public static $TEXT_DOING = 'job.text_doing';
    public $text_mastery = '';
    public static $TEXT_MASTERY = 'job.text_mastery';
    public $require_jobs = array();
    public static $REQUIRE_JOBS = 'job.require_jobs';
    public $negative_jobs = array();
    public static $NEGATIVE_JOBS = 'job.negative_jobs';
    public $require = '';
    public static $REQUIRE = 'job.require';
    public $require_major = 0;
    public static $REQUIRE_MAJOR = 'job.require_major';
    public $require_bankcell = 0;
    public static $REQUIRE_BANKCELL = 'job.require_bankcell';
    public $require_huntclub = 0;
    public static $REQUIRE_HUNTCLUB = 'job.require_huntclub';
    public $require_relations = 0;
    public static $REQUIRE_RELATIONS = 'job.require_relations';
    public $reward = '';
    public static $REWARD = 'job.reward';
    public $button_title = '';
    public static $BUTTON_TITLE = 'job.button_title';

    public function __construct()
    {
        parent::__construct('job');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->name = '';
        $this->code = '';
        $this->position = 0;
        $this->location = '';
        $this->energy = 0;
        $this->player_level = 0;
        $this->levels = 0;
        $this->clicks = 0;
        $this->title = '';
        $this->image = '';
        $this->text = '';
        $this->text_doing = '';
        $this->text_mastery = '';
        $this->require_jobs = array();
        $this->negative_jobs = array();
        $this->require = '';
        $this->require_major = 0;
        $this->require_bankcell = 0;
        $this->require_huntclub = 0;
        $this->require_relations = 0;
        $this->reward = '';
        $this->button_title = '';
    }

	/**
	 * Инициализация свойств объекта из ассоциативного массива
	 *
	 * @param array
	 */
    public function init($object)
    {
        if (isset($object['id']))
        {
            $this->id = $object['id'];
        }
        $this->name = $object['name'];
        $this->code = $object['code'];
        $this->position = $object['position'];
        $this->location = $object['location'];
        $this->energy = $object['energy'];
        $this->player_level = $object['player_level'];
        $this->levels = $object['levels'];
        $this->clicks = $object['clicks'];
        $this->title = $object['title'];
        $this->image = $object['image'];
        $this->text = $object['text'];
        $this->text_doing = $object['text_doing'];
        $this->text_mastery = $object['text_mastery'];
        $this->require_jobs = $object['require_jobs'];
        $this->negative_jobs = $object['negative_jobs'];
        $this->require = $object['require'];
        $this->require_major = $object['require_major'];
        $this->require_bankcell = $object['require_bankcell'];
        $this->require_huntclub = $object['require_huntclub'];
        $this->require_relations = $object['require_relations'];
        $this->reward = $object['reward'];
        $this->button_title = $object['button_title'];
    }

	/**
	 * Инициализация свойств объекта из формы (POST)
	 *
	 */
    public function initFromForm($id=0)
    {
        if ($id)
        {
            $this->id = $id;
        }
        else
        {
            if (isset($_POST['id']))
            {
                $this->id = (int) $_POST['id'];
            }
            if (isset($_GET['id']))
            {
                $this->id = (int) $_GET['id'];
            }
        }
        if (!$this->metaViewId)
        {
            $metaView = isset($_GET['metaview']) ? $_GET['metaview'] : (isset($_POST['metaview']) ? $_POST['metaview'] : 0);
            if ($metaView)
            {
                if (is_numeric((int) $metaView))
                {
                    $this->metaViewId = (int) $metaView;
                }
                else
                {
                    $this->metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code=''");
                }
            }
        }
        if ($this->id)
        {
            $this->load($this->id);
        }
        switch ($this->metaViewId)
        {
            case 160:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->code = str_replace('"', '&quot;', $_POST['code']);
                $this->position = (int) $_POST['position'];
                $this->location = str_replace('"', '&quot;', $_POST['location']);
                $this->energy = (int) $_POST['energy'];
                $this->levels = (int) $_POST['levels'];
                $this->player_level = (int) $_POST['player_level'];
                $this->clicks = (int) $_POST['clicks'];
                $this->title = str_replace('"', '&quot;', $_POST['title']);
                $this->image = str_replace('"', '&quot;', $_POST['image']);
                $this->text = $_POST['text'];
                $this->text_doing = $_POST['text_doing'];
                $this->text_mastery = $_POST['text_mastery'];
                if (is_array($_POST['require_jobs']))
                {
                    foreach ($_POST['require_jobs'] as $linkedObjectId)
                    {
                        if ($linkedObjectId > 0)
                        {
                            $this->require_jobs[] = (int) $linkedObjectId;
                        }
                    }
                }
                if (is_array($_POST['negative_jobs']))
                {
                    foreach ($_POST['negative_jobs'] as $linkedObjectId)
                    {
                        if ($linkedObjectId > 0)
                        {
                            $this->negative_jobs[] = (int) $linkedObjectId;
                        }
                    }
                }
                $this->require = $_POST['require'];
                $this->require_major = isset($_POST['require_major']) ? 1 : 0;
                $this->require_bankcell = isset($_POST['require_bankcell']) ? 1 : 0;
                $this->require_huntclub = isset($_POST['require_huntclub']) ? 1 : 0;
                $this->require_relations = isset($_POST['require_relations']) ? 1 : 0;
                $this->reward = $_POST['reward'];
                $this->button_title = str_replace('"', '&quot;', $_POST['button_title']);
                break;
        }
    }

	/**
	 * Сериализация свойств объекта в ассоциативный массив
	 *
	 * @return array
	 */
    public function toArray()
    {
        $object = array();
        $object['id'] = $this->id;
        $object['name'] = $this->name;
        $object['code'] = $this->code;
        $object['position'] = $this->position;
        $object['location'] = $this->location;
        $object['energy'] = $this->energy;
        $object['player_level'] = $this->player_level;
        $object['levels'] = $this->levels;
        $object['clicks'] = $this->clicks;
        $object['title'] = $this->title;
        $object['image'] = $this->image;
        $object['text'] = $this->text;
        $object['text_doing'] = $this->text_doing;
        $object['text_mastery'] = $this->text_mastery;
        $object['require_jobs'] = $this->require_jobs;
        $object['negative_jobs'] = $this->negative_jobs;
        $object['require'] = $this->require;
        $object['require_major'] = $this->require_major;
        $object['require_bankcell'] = $this->require_bankcell;
        $object['require_huntclub'] = $this->require_huntclub;
        $object['require_relations'] = $this->require_relations;
        $object['reward'] = $this->reward;
        $object['button_title'] = $this->button_title;
        return $object;
    }

	/**
	 * Сохранение объекта в базу данных в merge таблицу
	 *
	 * @param int $id
	 */
    public function saveMerge($id=0, $fields=false)
    {
    	$this->save($id, $fields, '_merge');
    }

	/**
	 * Сохранение объекта в базу данных
	 *
	 * @param int $id
	 */
    public function save($id=0, $fields=false, $saveMerge='')
    {
        if (is_array($this->require_jobs))
        {
            for ($i=0, $j=sizeof($this->require_jobs); $i<$j; $i++)
            {
            	if (is_object($this->require_jobs[$i]))
            	{
            		$this->require_jobs[$i]->save();
            		if (!in_array($this->require_jobs[$i]->id, $this->require_jobs))
            		{
            			$this->require_jobs[] = $this->require_jobs[$i]->id;
            		}
            	}
            }
        }
        if (is_array($this->negative_jobs))
        {
            for ($i=0, $j=sizeof($this->negative_jobs); $i<$j; $i++)
            {
            	if (is_object($this->negative_jobs[$i]))
            	{
            		$this->negative_jobs[$i]->save();
            		if (!in_array($this->negative_jobs[$i]->id, $this->negative_jobs))
            		{
            			$this->negative_jobs[] = $this->negative_jobs[$i]->id;
            		}
            	}
            }
        }
        if ($id)
        {
            $this->id = $id;
        }
        if ($this->id)
        {
            $object = $this->toArray();
            if ($this->globalExtention->eventsOnBeforeEdit)
            {
                $this->globalExtention->onBeforeEdit($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnBeforeEdit)
            {
                $this->extention->onBeforeEdit($this->id, $this);
            }
            //
            $linkToObjectsMetaAttributes = array();
            //
            if ($fields) {
            	$attributes = array();
            	foreach ($fields as $field) {
            		$field = str_replace('job.', '', $field);
            		switch ($this->getType($field)) {
            			case META_ATTRIBUTE_TYPE_INT:
                		case META_ATTRIBUTE_TYPE_BOOL:
		                case META_ATTRIBUTE_TYPE_FILE:
    		            case META_ATTRIBUTE_TYPE_IMAGE:
        		            $attributes[] = "`$field`=".(int)$this->{$field};
            		        break;
                		case META_ATTRIBUTE_TYPE_FLOAT:
	                	case META_ATTRIBUTE_TYPE_DOUBLE:
    	            		$attributes[] = "`$field`=".(double)$this->{$field};
	        	        	break;
    	        	    case META_ATTRIBUTE_TYPE_STRING:
        	        	case META_ATTRIBUTE_TYPE_TEXT:
	        	        case META_ATTRIBUTE_TYPE_BIGTEXT:
    	        	    case META_ATTRIBUTE_TYPE_DATA:
        	        	case META_ATTRIBUTE_TYPE_DATETIME:
	            	    case META_ATTRIBUTE_TYPE_DATE:
    	            	case META_ATTRIBUTE_TYPE_DICTIONARY:
	    	            case META_ATTRIBUTE_TYPE_CUSTOM:
    	    	        case META_ATTRIBUTE_TYPE_PASSWORD:
							$attributes[] = "`$field`='".Std::cleanString($this->{$field})."'";
	                	    break;
		                case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
    		            	$attributes[] = "`$field`=".(is_object($this->{$field}) ? $this->{$field}->id : $this->{$field});	
		                	break;	
    		            case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
    		            	$linkToObjectsMetaAttributes[] = array($field);
    		            	break;
        	    	}
            	}
            	$this->sql->query("UPDATE `job".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `job".$saveMerge."` SET `name`='".Std::cleanString($this->name)."', `code`='".Std::cleanString($this->code)."', `position`=".(int)$this->position.", `location`='".Std::cleanString($this->location)."', `energy`=".(int)$this->energy.", `player_level`=".(int)$this->player_level.", `levels`=".(int)$this->levels.", `clicks`=".(int)$this->clicks.", `title`='".Std::cleanString($this->title)."', `image`='".Std::cleanString($this->image)."', `text`='".Std::cleanString($this->text)."', `text_doing`='".Std::cleanString($this->text_doing)."', `text_mastery`='".Std::cleanString($this->text_mastery)."', `require`='".Std::cleanString($this->require)."', `require_major`=".(int)$this->require_major.", `require_bankcell`=".(int)$this->require_bankcell.", `require_huntclub`=".(int)$this->require_huntclub.", `require_relations`=".(int)$this->require_relations.", `reward`='".Std::cleanString($this->reward)."', `button_title`='".Std::cleanString($this->button_title)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
                $linkToObjectsMetaAttributes = array(require_jobs, negative_jobs);
        	}
         	if (sizeof($linkToObjectsMetaAttributes) > 0) {
        	   	foreach ($linkToObjectsMetaAttributes as $metaAttributeCode) {
        	   		$this->processLinkToObjects($metaAttributeCode);
          		}
        	}
        	//
            if ($this->globalExtention->eventsOnAfterEdit)
            {
                $this->globalExtention->onAfterEdit($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnAfterEdit)
            {
                $this->extention->onAfterEdit($this->id, $this);
            }
        }
        else
        {
            $object = $this->toArray();
            if ($this->globalExtention->eventsOnBeforeCreate)
            {
                $this->globalExtention->onBeforeCreate($this);
            }
            if ($this->extention && $this->extention->eventsOnBeforeCreate)
            {
                $this->extention->onBeforeCreate($this);
            }
            //
            $this->id = $this->sql->insert("INSERT INTO `job".$saveMerge."` (`name`, `code`, `position`, `location`, `energy`, `player_level`, `levels`, `clicks`, `title`, `image`, `text`, `text_doing`, `text_mastery`, `require`, `require_major`, `require_bankcell`, `require_huntclub`, `require_relations`, `reward`, `button_title`) VALUES ('".Std::cleanString($this->name)."', '".Std::cleanString($this->code)."', ".(int)$this->position.", '".Std::cleanString($this->location)."', ".(int)$this->energy.", ".(int)$this->player_level.", ".(int)$this->levels.", ".(int)$this->clicks.", '".Std::cleanString($this->title)."', '".Std::cleanString($this->image)."', '".Std::cleanString($this->text)."', '".Std::cleanString($this->text_doing)."', '".Std::cleanString($this->text_mastery)."', '".Std::cleanString($this->require)."', ".(int)$this->require_major.", ".(int)$this->require_bankcell.", ".(int)$this->require_huntclub.", ".(int)$this->require_relations.", '".Std::cleanString($this->reward)."', '".Std::cleanString($this->button_title)."')");
            if(sizeof($this->negative_jobs) > 0)
            {
                foreach ($this->negative_jobs as $linkedObjectId)
                {
                    $this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES (1213, {$this->id}, $linkedObjectId)");
                }
            }
        	//
            if ($this->globalExtention->eventsOnAfterCreate)
            {
                $this->globalExtention->onAfterCreate($this->id, $this);
            }
            if ($this->extention && $this->extention->eventsOnAfterCreate)
            {
                $this->extention->onAfterCreate($this->id, $this);
            }
        }
    }
    
    private function processLinkToObjects($metaAttributeCode)
    {
    	if (is_array($metaAttributeCode)) {
            $metaAttributeCode = $metaAttributeCode[0];
        }
        $metaAttributeId = $this->sql->getValue("SELECT id FROM metaattribute WHERE metaobject_id=(SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}') AND code='$metaAttributeCode'");
    	$this->sql->query("DELETE FROM metalink WHERE metaattribute_id=$metaAttributeId AND object_id={$this->id}");
	    if (sizeof($this->{$metaAttributeCode}) > 0) {
			foreach ($this->{$metaAttributeCode} as $linkedObjectId) {
            	$this->sql->query("INSERT INTO metalink (metaattribute_id, object_id, linkedobject_id) VALUES ($metaAttributeId, {$this->id}, $linkedObjectId)");
	        }
		}
    }
    
    private function getType($fieldCode)
    {
    	switch ($fieldCode) {
			case 'id': return 1; break;
			case 'name': return 4; break;
			case 'code': return 4; break;
			case 'position': return 2; break;
			case 'location': return 4; break;
			case 'energy': return 2; break;
			case 'player_level': return 2; break;
			case 'levels': return 2; break;
			case 'clicks': return 2; break;
			case 'title': return 4; break;
			case 'image': return 4; break;
			case 'text': return 5; break;
			case 'text_doing': return 5; break;
			case 'text_mastery': return 5; break;
			case 'require_jobs': return 14; break;
			case 'negative_jobs': return 14; break;
			case 'require': return 5; break;
			case 'require_major': return 10; break;
			case 'require_bankcell': return 10; break;
			case 'require_huntclub': return 10; break;
			case 'require_relations': return 10; break;
			case 'reward': return 5; break;
			case 'button_title': return 4; break;
    	}
    }
}
?>