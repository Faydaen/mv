<?php
class sovet3BaseObject extends Object
{
	public static $METAOBJECT = 'sovet3';
    public static $ID_METAATTRIBUTE = 'sovet3.id';
 	public static $ID = 'sovet3.id';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident');
    public static $FRACTION = 'sovet3.fraction';
    public $week = 0;
    public static $WEEK = 'sovet3.week';
    public $year = 0;
    public static $YEAR = 'sovet3.year';
    public $enemy = '';
    public $enemy_Dictionary = array('arrived','resident','npc');
    public static $ENEMY = 'sovet3.enemy';
    public $enemy_npc = 0;
    public static $ENEMY_NPC = 'sovet3.enemy_npc';
    public $metro = 0;
    public static $METRO = 'sovet3.metro';
    public $points1 = 0;
    public static $POINTS1 = 'sovet3.points1';
    public $points1enemy = 0;
    public static $POINTS1ENEMY = 'sovet3.points1enemy';
    public $points2 = 0;
    public static $POINTS2 = 'sovet3.points2';
    public $points2enemy = 0;
    public static $POINTS2ENEMY = 'sovet3.points2enemy';
    public $resultpoints = 0;
    public static $RESULTPOINTS = 'sovet3.resultpoints';
    public $resultpoints_enemy = 0;
    public static $RESULTPOINTS_ENEMY = 'sovet3.resultpoints_enemy';
    public $k = 0;
    public static $K = 'sovet3.k';
    public $leaders1 = '';
    public static $LEADERS1 = 'sovet3.leaders1';
    public $leaders2 = '';
    public static $LEADERS2 = 'sovet3.leaders2';
    public $result = 0;
    public static $RESULT = 'sovet3.result';

    public function __construct()
    {
        parent::__construct('sovet3');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->fraction = '';
        $this->week = 0;
        $this->year = 0;
        $this->enemy = '';
        $this->enemy_npc = 0;
        $this->metro = 0;
        $this->points1 = 0;
        $this->points1enemy = 0;
        $this->points2 = 0;
        $this->points2enemy = 0;
        $this->resultpoints = 0;
        $this->resultpoints_enemy = 0;
        $this->k = 0;
        $this->leaders1 = '';
        $this->leaders2 = '';
        $this->result = 0;
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
        $this->week = $object['week'];
        $this->year = $object['year'];
        $this->enemy = $object['enemy'];
        $this->enemy_npc = $object['enemy_npc'];
        $this->metro = $object['metro'];
        $this->points1 = $object['points1'];
        $this->points1enemy = $object['points1enemy'];
        $this->points2 = $object['points2'];
        $this->points2enemy = $object['points2enemy'];
        $this->resultpoints = $object['resultpoints'];
        $this->resultpoints_enemy = $object['resultpoints_enemy'];
        $this->k = $object['k'];
        $this->leaders1 = $object['leaders1'];
        $this->leaders2 = $object['leaders2'];
        $this->result = $object['result'];
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
            case 165:
                $this->fraction = $_POST['fraction'];
                $this->week = (int) $_POST['week'];
                $this->year = (int) $_POST['year'];
                $this->enemy = $_POST['enemy'];
                $this->enemy_npc = (int) $_POST['enemy_npc'];
                $this->metro = (int) $_POST['metro'];
                $this->points1 = (int) $_POST['points1'];
                $this->points1enemy = (int) $_POST['points1enemy'];
                $this->points2 = (int) $_POST['points2'];
                $this->points2enemy = (int) $_POST['points2enemy'];
                $this->resultpoints = (int) $_POST['resultpoints'];
                $this->resultpoints_enemy = (int) $_POST['resultpoints_enemy'];
                $this->result = isset($_POST['result']) ? 1 : 0;
                $this->k = (double) str_replace(',', '.', $_POST['k']);
                $this->leaders1 = $_POST['leaders1'];
                $this->leaders2 = $_POST['leaders2'];
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
        $object['week'] = $this->week;
        $object['year'] = $this->year;
        $object['enemy'] = $this->enemy;
        $object['enemy_npc'] = $this->enemy_npc;
        if (is_object($this->metro))
        {
            $object['metro'] = $this->metro->toArray();
        }
        else
        {
        	$object['metro'] = $this->metro;
        }
        $object['points1'] = $this->points1;
        $object['points1enemy'] = $this->points1enemy;
        $object['points2'] = $this->points2;
        $object['points2enemy'] = $this->points2enemy;
        $object['resultpoints'] = $this->resultpoints;
        $object['resultpoints_enemy'] = $this->resultpoints_enemy;
        $object['k'] = $this->k;
        $object['leaders1'] = $this->leaders1;
        $object['leaders2'] = $this->leaders2;
        $object['result'] = $this->result;
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
        if (is_object($this->metro))
        {
            $this->metro->save();
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
            		$field = str_replace('sovet3.', '', $field);
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
            	$this->sql->query("UPDATE `sovet3".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `sovet3".$saveMerge."` SET `fraction`='".Std::cleanString($this->fraction)."', `week`=".(int)$this->week.", `year`=".(int)$this->year.", `enemy`='".Std::cleanString($this->enemy)."', `enemy_npc`=".(int)$this->enemy_npc.", `metro`=".(is_object($this->metro) ? $this->metro->id : $this->metro).", `points1`=".(int)$this->points1.", `points1enemy`=".(int)$this->points1enemy.", `points2`=".(int)$this->points2.", `points2enemy`=".(int)$this->points2enemy.", `resultpoints`=".(int)$this->resultpoints.", `resultpoints_enemy`=".(int)$this->resultpoints_enemy.", `k`=".(double)$this->k.", `leaders1`='".Std::cleanString($this->leaders1)."', `leaders2`='".Std::cleanString($this->leaders2)."', `result`=".(int)$this->result." WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `sovet3".$saveMerge."` (`fraction`, `week`, `year`, `enemy`, `enemy_npc`, `metro`, `points1`, `points1enemy`, `points2`, `points2enemy`, `resultpoints`, `resultpoints_enemy`, `k`, `leaders1`, `leaders2`, `result`) VALUES ('".Std::cleanString($this->fraction)."', ".(int)$this->week.", ".(int)$this->year.", '".Std::cleanString($this->enemy)."', ".(int)$this->enemy_npc.", ".(is_object($this->metro) ? $this->metro->id : $this->metro).", ".(int)$this->points1.", ".(int)$this->points1enemy.", ".(int)$this->points2.", ".(int)$this->points2enemy.", ".(int)$this->resultpoints.", ".(int)$this->resultpoints_enemy.", ".(double)$this->k.", '".Std::cleanString($this->leaders1)."', '".Std::cleanString($this->leaders2)."', ".(int)$this->result.")");
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
			case 'week': return 2; break;
			case 'year': return 2; break;
			case 'enemy': return 15; break;
			case 'enemy_npc': return 2; break;
			case 'metro': return 13; break;
			case 'points1': return 2; break;
			case 'points1enemy': return 2; break;
			case 'points2': return 2; break;
			case 'points2enemy': return 2; break;
			case 'resultpoints': return 2; break;
			case 'resultpoints_enemy': return 2; break;
			case 'k': return 3; break;
			case 'leaders1': return 5; break;
			case 'leaders2': return 5; break;
			case 'result': return 10; break;
    	}
    }
}
?>