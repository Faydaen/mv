<?php
class collectionBaseObject extends Object
{
	public static $METAOBJECT = 'collection';
    public $found_text = '';
    public static $FOUND_TEXT = 'collection.found_text';
    public static $ID_METAATTRIBUTE = 'collection.id';
 	public static $ID = 'collection.id';
    public $name = '';
    public static $NAME = 'collection.name';
    public $code = '';
    public static $CODE = 'collection.code';
    public $image = '';
    public static $IMAGE = 'collection.image';
    public $info = '';
    public static $INFO = 'collection.info';
    public $pos = 0;
    public static $POS = 'collection.pos';
    public $repeats = 0;
    public static $REPEATS = 'collection.repeats';
    public $conditions = '';
    public static $CONDITIONS = 'collection.conditions';
    public $reward = '';
    public static $REWARD = 'collection.reward';
    public $made_text = '';
    public static $MADE_TEXT = 'collection.made_text';
    public $level_min = 0;
    public static $LEVEL_MIN = 'collection.level_min';
    public $level_max = 0;
    public static $LEVEL_MAX = 'collection.level_max';
    public $image_reward = '';
    public static $IMAGE_REWARD = 'collection.image_reward';
    public $addcondition = 0;
    public static $ADDCONDITION = 'collection.addcondition';
    public $show_button = 0;
    public static $SHOW_BUTTON = 'collection.show_button';

    public function __construct()
    {
        parent::__construct('collection');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->found_text = '';
        $this->name = '';
        $this->code = '';
        $this->image = '';
        $this->info = '';
        $this->pos = 0;
        $this->repeats = 0;
        $this->conditions = '';
        $this->reward = '';
        $this->made_text = '';
        $this->level_min = 0;
        $this->level_max = 0;
        $this->image_reward = '';
        $this->addcondition = 0;
        $this->show_button = 0;
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
        $this->found_text = $object['found_text'];
        $this->name = $object['name'];
        $this->code = $object['code'];
        $this->image = $object['image'];
        $this->info = $object['info'];
        $this->pos = $object['pos'];
        $this->repeats = $object['repeats'];
        $this->conditions = $object['conditions'];
        $this->reward = $object['reward'];
        $this->made_text = $object['made_text'];
        $this->level_min = $object['level_min'];
        $this->level_max = $object['level_max'];
        $this->image_reward = $object['image_reward'];
        $this->addcondition = $object['addcondition'];
        $this->show_button = $object['show_button'];
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
            case 132:
                $this->name = str_replace('"', '&quot;', $_POST['name']);
                $this->code = str_replace('"', '&quot;', $_POST['code']);
                $this->image = str_replace('"', '&quot;', $_POST['image']);
                $this->info = $_POST['info'];
                $this->pos = (int) $_POST['pos'];
                $this->repeats = (int) $_POST['repeats'];
                $this->conditions = $_POST['conditions'];
                $this->reward = $_POST['reward'];
                $this->made_text = $_POST['made_text'];
                $this->found_text = $_POST['found_text'];
                $this->level_min = (int) $_POST['level_min'];
                $this->level_max = (int) $_POST['level_max'];
                $this->image_reward = str_replace('"', '&quot;', $_POST['image_reward']);
                $this->addcondition = isset($_POST['addcondition']) ? 1 : 0;
                $this->show_button = isset($_POST['show_button']) ? 1 : 0;
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
        $object['found_text'] = $this->found_text;
        $object['id'] = $this->id;
        $object['name'] = $this->name;
        $object['code'] = $this->code;
        $object['image'] = $this->image;
        $object['info'] = $this->info;
        $object['pos'] = $this->pos;
        $object['repeats'] = $this->repeats;
        $object['conditions'] = $this->conditions;
        $object['reward'] = $this->reward;
        $object['made_text'] = $this->made_text;
        $object['level_min'] = $this->level_min;
        $object['level_max'] = $this->level_max;
        $object['image_reward'] = $this->image_reward;
        $object['addcondition'] = $this->addcondition;
        $object['show_button'] = $this->show_button;
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
            		$field = str_replace('collection.', '', $field);
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
            	$this->sql->query("UPDATE `collection".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `collection".$saveMerge."` SET `found_text`='".Std::cleanString($this->found_text)."', `name`='".Std::cleanString($this->name)."', `code`='".Std::cleanString($this->code)."', `image`='".Std::cleanString($this->image)."', `info`='".Std::cleanString($this->info)."', `pos`=".(int)$this->pos.", `repeats`=".(int)$this->repeats.", `conditions`='".Std::cleanString($this->conditions)."', `reward`='".Std::cleanString($this->reward)."', `made_text`='".Std::cleanString($this->made_text)."', `level_min`=".(int)$this->level_min.", `level_max`=".(int)$this->level_max.", `image_reward`='".Std::cleanString($this->image_reward)."', `addcondition`=".(int)$this->addcondition.", `show_button`=".(int)$this->show_button." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `collection".$saveMerge."` (`found_text`, `name`, `code`, `image`, `info`, `pos`, `repeats`, `conditions`, `reward`, `made_text`, `level_min`, `level_max`, `image_reward`, `addcondition`, `show_button`) VALUES ('".Std::cleanString($this->found_text)."', '".Std::cleanString($this->name)."', '".Std::cleanString($this->code)."', '".Std::cleanString($this->image)."', '".Std::cleanString($this->info)."', ".(int)$this->pos.", ".(int)$this->repeats.", '".Std::cleanString($this->conditions)."', '".Std::cleanString($this->reward)."', '".Std::cleanString($this->made_text)."', ".(int)$this->level_min.", ".(int)$this->level_max.", '".Std::cleanString($this->image_reward)."', ".(int)$this->addcondition.", ".(int)$this->show_button.")");
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
			case 'found_text': return 5; break;
			case 'id': return 1; break;
			case 'name': return 4; break;
			case 'code': return 4; break;
			case 'image': return 4; break;
			case 'info': return 5; break;
			case 'pos': return 2; break;
			case 'repeats': return 2; break;
			case 'conditions': return 5; break;
			case 'reward': return 5; break;
			case 'made_text': return 5; break;
			case 'level_min': return 2; break;
			case 'level_max': return 2; break;
			case 'image_reward': return 4; break;
			case 'addcondition': return 10; break;
			case 'show_button': return 10; break;
    	}
    }
}
?>