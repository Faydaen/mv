<?php
class duelBaseObject extends Object
{
	public static $METAOBJECT = 'duel';
    public static $ID_METAATTRIBUTE = 'duel.id';
 	public static $ID = 'duel.id';
    public $player1 = 0;
    public static $PLAYER1 = 'duel.player1';
    public $player2 = 0;
    public static $PLAYER2 = 'duel.player2';
    public $time = 0;
    public static $TIME = 'duel.time';
    public $winner = 0;
    public static $WINNER = 'duel.winner';
    public $profit = 0;
    public static $PROFIT = 'duel.profit';
    public $exp = 0;
    public static $EXP = 'duel.exp';
    public $flag = 0;
    public static $FLAG = 'duel.flag';

    public function __construct()
    {
        parent::__construct('duel');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->player1 = 0;
        $this->player2 = 0;
        $this->time = 0;
        $this->winner = 0;
        $this->profit = 0;
        $this->exp = 0;
        $this->flag = 0;
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
        $this->player1 = $object['player1'];
        $this->player2 = $object['player2'];
        $this->time = $object['time'];
        $this->winner = $object['winner'];
        $this->profit = $object['profit'];
        $this->exp = $object['exp'];
        $this->flag = $object['flag'];
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
        if (is_object($this->player1))
        {
            $object['player1'] = $this->player1->toArray();
        }
        else
        {
        	$object['player1'] = $this->player1;
        }
        if (is_object($this->player2))
        {
            $object['player2'] = $this->player2->toArray();
        }
        else
        {
        	$object['player2'] = $this->player2;
        }
        $object['time'] = $this->time;
        if (is_object($this->winner))
        {
            $object['winner'] = $this->winner->toArray();
        }
        else
        {
        	$object['winner'] = $this->winner;
        }
        $object['profit'] = $this->profit;
        $object['exp'] = $this->exp;
        $object['flag'] = $this->flag;
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
        if (is_object($this->player1))
        {
            $this->player1->save();
        }
        if (is_object($this->player2))
        {
            $this->player2->save();
        }
        if (is_object($this->winner))
        {
            $this->winner->save();
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
            		$field = str_replace('duel.', '', $field);
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
            	$this->sql->query("UPDATE `duel".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `duel".$saveMerge."` SET `player1`=".(is_object($this->player1) ? $this->player1->id : $this->player1).", `player2`=".(is_object($this->player2) ? $this->player2->id : $this->player2).", `time`=".(int)$this->time.", `winner`=".(is_object($this->winner) ? $this->winner->id : $this->winner).", `profit`=".(int)$this->profit.", `exp`=".(int)$this->exp.", `flag`=".(int)$this->flag." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `duel".$saveMerge."` (`player1`, `player2`, `time`, `winner`, `profit`, `exp`, `flag`) VALUES (".(is_object($this->player1) ? $this->player1->id : $this->player1).", ".(is_object($this->player2) ? $this->player2->id : $this->player2).", ".(int)$this->time.", ".(is_object($this->winner) ? $this->winner->id : $this->winner).", ".(int)$this->profit.", ".(int)$this->exp.", ".(int)$this->flag.")");
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
			case 'player1': return 13; break;
			case 'player2': return 13; break;
			case 'time': return 2; break;
			case 'winner': return 13; break;
			case 'profit': return 2; break;
			case 'exp': return 2; break;
			case 'flag': return 2; break;
    	}
    }
}
?>