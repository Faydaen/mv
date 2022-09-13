<?php
class huntBaseObject extends Object
{
	public static $METAOBJECT = 'hunt';
    public static $ID_METAATTRIBUTE = 'hunt.id';
 	public static $ID = 'hunt.id';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident');
    public static $FRACTION = 'hunt.fraction';
    public $player = 0;
    public static $PLAYER = 'hunt.player';
    public $player2 = 0;
    public static $PLAYER2 = 'hunt.player2';
    public $award = 0;
    public static $AWARD = 'hunt.award';
    public $money = 0;
    public static $MONEY = 'hunt.money';
    public $comment = '';
    public static $COMMENT = 'hunt.comment';
    public $level = 0;
    public static $LEVEL = 'hunt.level';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'hunt.dt';
    public $dt2 = '0000-00-00 00:00:00';
    public static $DT2 = 'hunt.dt2';
    public $kills = 0;
    public static $KILLS = 'hunt.kills';
    public $kills2 = 0;
    public static $KILLS2 = 'hunt.kills2';
    public $private = 0;
    public static $PRIVATE = 'hunt.private';
    public $opened = 0;
    public static $OPENED = 'hunt.opened';
    public $xmoney = 0;
    public static $XMONEY = 'hunt.xmoney';

    public function __construct()
    {
        parent::__construct('hunt');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->fraction = '';
        $this->player = 0;
        $this->player2 = 0;
        $this->award = 0;
        $this->money = 0;
        $this->comment = '';
        $this->level = 0;
        $this->dt = '0000-00-00 00:00:00';
        $this->dt2 = '0000-00-00 00:00:00';
        $this->kills = 0;
        $this->kills2 = 0;
        $this->private = 0;
        $this->opened = 0;
        $this->xmoney = 0;
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
        $this->fraction = $object['fraction'];
        $this->player = $object['player'];
        $this->player2 = $object['player2'];
        $this->award = $object['award'];
        $this->money = $object['money'];
        $this->comment = $object['comment'];
        $this->level = $object['level'];
        $this->dt = $object['dt'];
        $this->dt2 = $object['dt2'];
        $this->kills = $object['kills'];
        $this->kills2 = $object['kills2'];
        $this->private = $object['private'];
        $this->opened = $object['opened'];
        $this->xmoney = $object['xmoney'];
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
            case 150:
                $this->fraction = $_POST['fraction'];
                $this->player = (int) $_POST['player'];
                $this->player2 = (int) $_POST['player2'];
                $this->award = (int) $_POST['award'];
                $this->money = (int) $_POST['money'];
                $this->comment = str_replace('"', '&quot;', $_POST['comment']);
                $this->level = (int) $_POST['level'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt2']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt2 = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->kills = (int) $_POST['kills'];
                $this->kills2 = (int) $_POST['kills2'];
                $this->private = isset($_POST['private']) ? 1 : 0;
                $this->opened = isset($_POST['opened']) ? 1 : 0;
                $this->xmoney = (int) $_POST['xmoney'];
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
        $object['fraction'] = $this->fraction;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        if (is_object($this->player2))
        {
            $object['player2'] = $this->player2->toArray();
        }
        else
        {
        	$object['player2'] = $this->player2;
        }
        $object['award'] = $this->award;
        $object['money'] = $this->money;
        $object['comment'] = $this->comment;
        $object['level'] = $this->level;
        $object['dt'] = $this->dt;
        $object['dt2'] = $this->dt2;
        $object['kills'] = $this->kills;
        $object['kills2'] = $this->kills2;
        $object['private'] = $this->private;
        $object['opened'] = $this->opened;
        $object['xmoney'] = $this->xmoney;
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
        if (is_object($this->player2))
        {
            $this->player2->save();
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
            		$field = str_replace('hunt.', '', $field);
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
            	$this->sql->query("UPDATE `hunt".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `hunt".$saveMerge."` SET `fraction`='".Std::cleanString($this->fraction)."', `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `player2`=".(is_object($this->player2) ? $this->player2->id : $this->player2).", `award`=".(int)$this->award.", `money`=".(int)$this->money.", `comment`='".Std::cleanString($this->comment)."', `level`=".(int)$this->level.", `dt`='".Std::cleanString($this->dt)."', `dt2`='".Std::cleanString($this->dt2)."', `kills`=".(int)$this->kills.", `kills2`=".(int)$this->kills2.", `private`=".(int)$this->private.", `opened`=".(int)$this->opened.", `xmoney`=".(int)$this->xmoney." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `hunt".$saveMerge."` (`fraction`, `player`, `player2`, `award`, `money`, `comment`, `level`, `dt`, `dt2`, `kills`, `kills2`, `private`, `opened`, `xmoney`) VALUES ('".Std::cleanString($this->fraction)."', ".(is_object($this->player) ? $this->player->id : $this->player).", ".(is_object($this->player2) ? $this->player2->id : $this->player2).", ".(int)$this->award.", ".(int)$this->money.", '".Std::cleanString($this->comment)."', ".(int)$this->level.", '".Std::cleanString($this->dt)."', '".Std::cleanString($this->dt2)."', ".(int)$this->kills.", ".(int)$this->kills2.", ".(int)$this->private.", ".(int)$this->opened.", ".(int)$this->xmoney.")");
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
			case 'fraction': return 15; break;
			case 'player': return 13; break;
			case 'player2': return 13; break;
			case 'award': return 2; break;
			case 'money': return 2; break;
			case 'comment': return 4; break;
			case 'level': return 2; break;
			case 'dt': return 8; break;
			case 'dt2': return 8; break;
			case 'kills': return 2; break;
			case 'kills2': return 2; break;
			case 'private': return 10; break;
			case 'opened': return 10; break;
			case 'xmoney': return 2; break;
    	}
    }
}
?>