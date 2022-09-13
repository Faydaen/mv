<?php
class sovet2BaseObject extends Object
{
	public static $METAOBJECT = 'sovet2';
    public $kazna = 0;
    public static $KAZNA = 'sovet2.kazna';
    public $glava = 0;
    public static $GLAVA = 'sovet2.glava';
    public $fraction = '';
    public $fraction_Dictionary = array('arrived','resident');
    public static $FRACTION = 'sovet2.fraction';
    public static $ID_METAATTRIBUTE = 'sovet2.id';
 	public static $ID = 'sovet2.id';
    public $kazna2 = 0;
    public static $KAZNA2 = 'sovet2.kazna2';
    public $textfraction = '';
    public static $TEXTFRACTION = 'sovet2.textfraction';
    public $textsovet = '';
    public static $TEXTSOVET = 'sovet2.textsovet';
    public $textenemy = '';
    public static $TEXTENEMY = 'sovet2.textenemy';

    public function __construct()
    {
        parent::__construct('sovet2');
    }

	/**
	 * Сброс значений свойств объекта
	 *
	 */
    public function reset()
    {
        $this->id = 0;
        $this->kazna = 0;
        $this->glava = 0;
        $this->fraction = '';
        $this->kazna2 = 0;
        $this->textfraction = '';
        $this->textsovet = '';
        $this->textenemy = '';
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
        $this->kazna = $object['kazna'];
        $this->glava = $object['glava'];
        $this->fraction = $object['fraction'];
        $this->kazna2 = $object['kazna2'];
        $this->textfraction = $object['textfraction'];
        $this->textsovet = $object['textsovet'];
        $this->textenemy = $object['textenemy'];
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
            case 162:
                $this->fraction = $_POST['fraction'];
                $this->glava = (int) $_POST['glava'];
                $this->kazna = (int) $_POST['kazna'];
                $this->kazna2 = (int) $_POST['kazna2'];
                $this->textfraction = $_POST['textfraction'];
                $this->textsovet = $_POST['textsovet'];
                $this->textenemy = $_POST['textenemy'];
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
        $object['kazna'] = $this->kazna;
        if (is_object($this->glava))
        {
            $object['glava'] = $this->glava->toArray();
        }
        else
        {
        	$object['glava'] = $this->glava;
        }
        $object['fraction'] = $this->fraction;
        $object['id'] = $this->id;
        $object['kazna2'] = $this->kazna2;
        $object['textfraction'] = $this->textfraction;
        $object['textsovet'] = $this->textsovet;
        $object['textenemy'] = $this->textenemy;
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
        if (is_object($this->glava))
        {
            $this->glava->save();
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
            		$field = str_replace('sovet2.', '', $field);
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
            	$this->sql->query("UPDATE `sovet2".$saveMerge."` SET " . implode(', ', $attributes) . " WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
            } else {
        		$this->sql->query("UPDATE `sovet2".$saveMerge."` SET `kazna`=".(int)$this->kazna.", `glava`=".(is_object($this->glava) ? $this->glava->id : $this->glava).", `fraction`='".Std::cleanString($this->fraction)."', `kazna2`=".(int)$this->kazna2.", `textfraction`='".Std::cleanString($this->textfraction)."', `textsovet`='".Std::cleanString($this->textsovet)."', `textenemy`='".Std::cleanString($this->textenemy)."' WHERE ".str_replace('.', $saveMerge . '.', self::$ID_METAATTRIBUTE)."=".$this->id);
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
            $this->id = $this->sql->insert("INSERT INTO `sovet2".$saveMerge."` (`kazna`, `glava`, `fraction`, `kazna2`, `textfraction`, `textsovet`, `textenemy`) VALUES (".(int)$this->kazna.", ".(is_object($this->glava) ? $this->glava->id : $this->glava).", '".Std::cleanString($this->fraction)."', ".(int)$this->kazna2.", '".Std::cleanString($this->textfraction)."', '".Std::cleanString($this->textsovet)."', '".Std::cleanString($this->textenemy)."')");
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
			case 'kazna': return 2; break;
			case 'glava': return 13; break;
			case 'fraction': return 15; break;
			case 'id': return 1; break;
			case 'kazna2': return 2; break;
			case 'textfraction': return 5; break;
			case 'textsovet': return 5; break;
			case 'textenemy': return 5; break;
    	}
    }
}
?>