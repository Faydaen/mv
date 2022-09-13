<?php
class playeractivityBaseObject extends Object
{
	public static $METAOBJECT = 'playeractivity';
    public static $ID_METAATTRIBUTE = 'playeractivity.id';
 	public static $ID = 'playeractivity.id';
    public $player = 0;
    public static $PLAYER = 'playeractivity.player';
    public $level = 0;
    public static $LEVEL = 'playeractivity.level';
    public $dt = '0000-00-00';
    public static $DT = 'playeractivity.dt';
    public $alleysearch = 0;
    public static $ALLEYSEARCH = 'playeractivity.alleysearch';
    public $alleyattack = 0;
    public static $ALLEYATTACK = 'playeractivity.alleyattack';
    public $alleypatrol = 0;
    public static $ALLEYPATROL = 'playeractivity.alleypatrol';
    public $metrowork = 0;
    public static $METROWORK = 'playeractivity.metrowork';
    public $metrodig = 0;
    public static $METRODIG = 'playeractivity.metrodig';
    public $macdonalds = 0;
    public static $MACDONALDS = 'playeractivity.macdonalds';
    public $shopbuy = 0;
    public static $SHOPBUY = 'playeractivity.shopbuy';
    public $statcount = 0;
    public static $STATCOUNT = 'playeractivity.statcount';
    public $statmoney = 0;
    public static $STATMONEY = 'playeractivity.statmoney';
    public $statanabolic = 0;
    public static $STATANABOLIC = 'playeractivity.statanabolic';
    public $forumpost = 0;
    public static $FORUMPOST = 'playeractivity.forumpost';
    public $forumtopic = 0;
    public static $FORUMTOPIC = 'playeractivity.forumtopic';

    public function __construct()
    {
        parent::__construct('playeractivity');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player = 0;
        $this->level = 0;
        $this->dt = '0000-00-00';
        $this->alleysearch = 0;
        $this->alleyattack = 0;
        $this->alleypatrol = 0;
        $this->metrowork = 0;
        $this->metrodig = 0;
        $this->macdonalds = 0;
        $this->shopbuy = 0;
        $this->statcount = 0;
        $this->statmoney = 0;
        $this->statanabolic = 0;
        $this->forumpost = 0;
        $this->forumtopic = 0;
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
        $this->player = $object['player'];
        $this->level = $object['level'];
        $this->dt = $object['dt'];
        $this->alleysearch = $object['alleysearch'];
        $this->alleyattack = $object['alleyattack'];
        $this->alleypatrol = $object['alleypatrol'];
        $this->metrowork = $object['metrowork'];
        $this->metrodig = $object['metrodig'];
        $this->macdonalds = $object['macdonalds'];
        $this->shopbuy = $object['shopbuy'];
        $this->statcount = $object['statcount'];
        $this->statmoney = $object['statmoney'];
        $this->statanabolic = $object['statanabolic'];
        $this->forumpost = $object['forumpost'];
        $this->forumtopic = $object['forumtopic'];
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
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['level'] = $this->level;
        $object['dt'] = $this->dt;
        $object['alleysearch'] = $this->alleysearch;
        $object['alleyattack'] = $this->alleyattack;
        $object['alleypatrol'] = $this->alleypatrol;
        $object['metrowork'] = $this->metrowork;
        $object['metrodig'] = $this->metrodig;
        $object['macdonalds'] = $this->macdonalds;
        $object['shopbuy'] = $this->shopbuy;
        $object['statcount'] = $this->statcount;
        $object['statmoney'] = $this->statmoney;
        $object['statanabolic'] = $this->statanabolic;
        $object['forumpost'] = $this->forumpost;
        $object['forumtopic'] = $this->forumtopic;
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
        if (is_object($this->player))
        {
            $this->player->save();
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
            		$field = str_replace('playeractivity.', '', $field);
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
            	$this->sql->query("UPDATE `playeractivity".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `playeractivity".$saveMerge."` SET `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `level`=".(int)$this->level.", `dt`='".Std::cleanString($this->dt)."', `alleysearch`=".(int)$this->alleysearch.", `alleyattack`=".(int)$this->alleyattack.", `alleypatrol`=".(int)$this->alleypatrol.", `metrowork`=".(int)$this->metrowork.", `metrodig`=".(int)$this->metrodig.", `macdonalds`=".(int)$this->macdonalds.", `shopbuy`=".(int)$this->shopbuy.", `statcount`=".(int)$this->statcount.", `statmoney`=".(int)$this->statmoney.", `statanabolic`=".(int)$this->statanabolic.", `forumpost`=".(int)$this->forumpost.", `forumtopic`=".(int)$this->forumtopic." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `playeractivity".$saveMerge."` (`player`, `level`, `dt`, `alleysearch`, `alleyattack`, `alleypatrol`, `metrowork`, `metrodig`, `macdonalds`, `shopbuy`, `statcount`, `statmoney`, `statanabolic`, `forumpost`, `forumtopic`) VALUES (".(is_object($this->player) ? $this->player->id : $this->player).", ".(int)$this->level.", '".Std::cleanString($this->dt)."', ".(int)$this->alleysearch.", ".(int)$this->alleyattack.", ".(int)$this->alleypatrol.", ".(int)$this->metrowork.", ".(int)$this->metrodig.", ".(int)$this->macdonalds.", ".(int)$this->shopbuy.", ".(int)$this->statcount.", ".(int)$this->statmoney.", ".(int)$this->statanabolic.", ".(int)$this->forumpost.", ".(int)$this->forumtopic.")");
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
			case 'player': return 13; break;
			case 'level': return 2; break;
			case 'dt': return 9; break;
			case 'alleysearch': return 2; break;
			case 'alleyattack': return 2; break;
			case 'alleypatrol': return 2; break;
			case 'metrowork': return 2; break;
			case 'metrodig': return 2; break;
			case 'macdonalds': return 2; break;
			case 'shopbuy': return 2; break;
			case 'statcount': return 2; break;
			case 'statmoney': return 2; break;
			case 'statanabolic': return 2; break;
			case 'forumpost': return 2; break;
			case 'forumtopic': return 2; break;
    	}
    }
}
?>