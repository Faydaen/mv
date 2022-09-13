<?php
class logspecialBaseObject extends Object
{
	public static $METAOBJECT = 'logspecial';
    public static $ID_METAATTRIBUTE = 'logspecial.id';
 	public static $ID = 'logspecial.id';
    public $type = '';
    public static $TYPE = 'logspecial.type';
    public $player = 0;
    public static $PLAYER = 'logspecial.player';
    public $dt = '0000-00-00 00:00:00';
    public static $DT = 'logspecial.dt';
    public $data1 = '';
    public static $DATA1 = 'logspecial.data1';
    public $data2 = '';
    public static $DATA2 = 'logspecial.data2';
    public $data3 = 0;
    public static $DATA3 = 'logspecial.data3';
    public $data4 = 0;
    public static $DATA4 = 'logspecial.data4';
    public $data5 = '';
    public static $DATA5 = 'logspecial.data5';

    public function __construct()
    {
        parent::__construct('logspecial');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->type = '';
        $this->player = 0;
        $this->dt = '0000-00-00 00:00:00';
        $this->data1 = '';
        $this->data2 = '';
        $this->data3 = 0;
        $this->data4 = 0;
        $this->data5 = '';
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
        $this->type = $object['type'];
        $this->player = $object['player'];
        $this->dt = $object['dt'];
        $this->data1 = $object['data1'];
        $this->data2 = $object['data2'];
        $this->data3 = $object['data3'];
        $this->data4 = $object['data4'];
        $this->data5 = $object['data5'];
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
            case 114:
                $this->type = str_replace('"', '&quot;', $_POST['type']);
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
                $this->data1 = str_replace('"', '&quot;', $_POST['data1']);
                $this->data2 = str_replace('"', '&quot;', $_POST['data2']);
                $this->data3 = (int) $_POST['data3'];
                $this->data4 = (int) $_POST['data4'];
                $this->data5 = $_POST['data5'];
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
        $object['type'] = $this->type;
        if (is_object($this->player))
        {
            $object['player'] = $this->player->toArray();
        }
        else
        {
        	$object['player'] = $this->player;
        }
        $object['dt'] = $this->dt;
        $object['data1'] = $this->data1;
        $object['data2'] = $this->data2;
        $object['data3'] = $this->data3;
        $object['data4'] = $this->data4;
        $object['data5'] = $this->data5;
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
            		$field = str_replace('logspecial.', '', $field);
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
            	$this->sql->query("UPDATE `logspecial".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `logspecial".$saveMerge."` SET `type`='".Std::cleanString($this->type)."', `player`=".(is_object($this->player) ? $this->player->id : $this->player).", `dt`='".Std::cleanString($this->dt)."', `data1`='".Std::cleanString($this->data1)."', `data2`='".Std::cleanString($this->data2)."', `data3`=".(int)$this->data3.", `data4`=".(int)$this->data4.", `data5`='".Std::cleanString($this->data5)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `logspecial".$saveMerge."` (`type`, `player`, `dt`, `data1`, `data2`, `data3`, `data4`, `data5`) VALUES ('".Std::cleanString($this->type)."', ".(is_object($this->player) ? $this->player->id : $this->player).", '".Std::cleanString($this->dt)."', '".Std::cleanString($this->data1)."', '".Std::cleanString($this->data2)."', ".(int)$this->data3.", ".(int)$this->data4.", '".Std::cleanString($this->data5)."')");
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
			case 'type': return 4; break;
			case 'player': return 13; break;
			case 'dt': return 8; break;
			case 'data1': return 4; break;
			case 'data2': return 4; break;
			case 'data3': return 2; break;
			case 'data4': return 2; break;
			case 'data5': return 5; break;
    	}
    }
}
?>