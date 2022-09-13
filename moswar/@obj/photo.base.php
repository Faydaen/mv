<?php
class photoBaseObject extends Object
{
	public static $METAOBJECT = 'photo';
    public $amount = 0;
    public static $AMOUNT = 'photo.amount';
    public $sum = 0;
    public static $SUM = 'photo.sum';
    public $rating = 0;
    public static $RATING = 'photo.rating';
    public $dt_accepted = '0000-00-00 00:00:00';
    public static $DT_ACCEPTED = 'photo.dt_accepted';
    public static $ID_METAATTRIBUTE = 'photo.id';
 	public static $ID = 'photo.id';
    public $player = 0;
    public static $PLAYER = 'photo.player';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'photo.dt';
    public $comment = '';
    public static $COMMENT = 'photo.comment';
    public $views = 0;
    public static $VIEWS = 'photo.views';
    public $status = '';
    public $status_Dictionary = array('new','accepted','canceled');
    public static $STATUS = 'photo.status';
    public $in_profile = 0;
    public static $IN_PROFILE = 'photo.in_profile';
    public $for_contest = 0;
    public static $FOR_CONTEST = 'photo.for_contest';

    public function __construct()
    {
        parent::__construct('photo');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->amount = 0;
        $this->sum = 0;
        $this->rating = 0;
        $this->dt_accepted = '0000-00-00 00:00:00';
        $this->player = 0;
        $this->dt = '0000-00-00 00:00:00';
        $this->comment = '';
        $this->views = 0;
        $this->status = '';
        $this->in_profile = 0;
        $this->for_contest = 0;
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
        $this->amount = $object['amount'];
        $this->sum = $object['sum'];
        $this->rating = $object['rating'];
        $this->dt_accepted = $object['dt_accepted'];
        $this->player = $object['player'];
        $this->dt = $object['dt'];
        $this->comment = $object['comment'];
        $this->views = $object['views'];
        $this->status = $object['status'];
        $this->in_profile = $object['in_profile'];
        $this->for_contest = $object['for_contest'];
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
            case 91:
                $this->player = (int) $_POST['player'];
                $dt = preg_replace('/[^\d\.\-\s:]/', '', trim($_POST['dt']));
                if ($dt == '')
                {
                    $dt = '00.00.0000 00:00';
                }
                $dt = explode(' ', $dt);
                $d = explode('.', $dt[0]);
                $t = strlen($dt[1]) < 6 ? $dt[1].':00' : $dt[1];
                $this->dt = $d[2].'-'.$d[1].'-'.$d[0].' '.$t;
                $this->comment = $_POST['comment'];
                $this->views = (int) $_POST['views'];
                $this->status = $_POST['status'];
                $this->in_profile = isset($_POST['in_profile']) ? 1 : 0;
                $this->for_contest = (int) $_POST['for_contest'];
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
        $object['amount'] = $this->amount;
        $object['sum'] = $this->sum;
        $object['rating'] = $this->rating;
        $object['dt_accepted'] = $this->dt_accepted;
        $object['id'] = $this->id;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['dt'] = $this->dt;
        $object['comment'] = $this->comment;
        $object['views'] = $this->views;
        $object['status'] = $this->status;
        $object['in_profile'] = $this->in_profile;
        if (is_object($this->for_contest))
        {
            $object['for_contest'] = $this->for_contest->toArray();
        }
        else
        {
        	$object['for_contest'] = $this->for_contest;
        }
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
        if (is_object($this->for_contest))
        {
            $this->for_contest->save();
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
            		$field = str_replace('photo.', '', $field);
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
            	$this->sql->query("UPDATE `photo".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `photo".$saveMerge."` SET `amount`=".(int)$this->amount.", `sum`=".(int)$this->sum.", `rating`=".(double)$this->rating.", `dt_accepted`='".Std::cleanString($this->dt_accepted)."', `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `dt`='".Std::cleanString($this->dt)."', `comment`='".Std::cleanString($this->comment)."', `views`=".(int)$this->views.", `status`='".Std::cleanString($this->status)."', `in_profile`=".(int)$this->in_profile.", `for_contest`=".(is_object($this->for_contest) ? $this->for_contest->id : $this->for_contest)." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `photo".$saveMerge."` (`amount`, `sum`, `rating`, `dt_accepted`, `player`, `dt`, `comment`, `views`, `status`, `in_profile`, `for_contest`) VALUES (".(int)$this->amount.", ".(int)$this->sum.", ".(double)$this->rating.", '".Std::cleanString($this->dt_accepted)."', ".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->dt)."', '".Std::cleanString($this->comment)."', ".(int)$this->views.", '".Std::cleanString($this->status)."', ".(int)$this->in_profile.", ".(is_object($this->for_contest) ? $this->for_contest->id : $this->for_contest).")");
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
			case 'amount': return 2; break;
			case 'sum': return 2; break;
			case 'rating': return 3; break;
			case 'dt_accepted': return 8; break;
			case 'id': return 1; break;
			case 'player': return 13; break;
			case 'dt': return 8; break;
			case 'comment': return 5; break;
			case 'views': return 2; break;
			case 'status': return 15; break;
			case 'in_profile': return 10; break;
			case 'for_contest': return 13; break;
    	}
    }
}
?>