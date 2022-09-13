<?php
/**
 * Базовый объект для всех пользовательских объектов
 *
 */
class Object //implements ArrayAccess, Iterator, Countable
{
    protected $sql;
    public $id = 0;
    public $metaObjectCode;
    public $metaObjectId;
    public $metaViewId;
    public $extention = false;
    public $globalExtention;

    public function __construct($metaObjectCode)
    {
        $this->sql = SqlDataSource::getInstance();
        //
        $this->metaObjectCode = $metaObjectCode;
        //$this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
        if (Std::loadMetaObjectExtention($this->metaObjectCode))
        {
            $className = $this->metaObjectCode.'Extention';
            $this->extention = new $className();
        }
        //
        Std::loadMetaObjectExtention('object');
        $this->globalExtention = new ObjectExtention($this->metaObjectCode);
    }

	/**
	 * Получение объекта
	 * 
	 * @param string $metaObjectCode
	 * @param int $objectId
	 * @return object
	 */
	public static function get($metaObjectCode, $objectId=0)
	{
		Std::loadMetaObjectClass($metaObjectCode);
		$className = $metaObjectCode.'Object';
		$object = new $className();
		if ($objectId)
		{
			$object->load($id);
		}
		return $object;
	}
	
	/**
	 * Получение коллекции объектов
	 *
	 * @param string $metaObjectCode
	 * @param object $criterias
	 * @return array
	 */
	public static function getCollection($metaObjectCode, $criterias, $fields)
	{
		Std::loadMetaObjectClass($metaObjectCode);
		$collection = new ObjectCollection();
		$collection->get($metaObjectCode, $criterias, $fields);
		return $objects;
	}
	
	/**
	 * Загрузка всех свойств обекта из базы данных
	 *
	 * @param int $id
	 */
    public function load($id) {
        $this->id = $id;
        //
        Std::loadMetaObjectClass($this->metaObjectCode);
        $className = $this->metaObjectCode.'Object';
        $classVars = get_class_vars($className);
        //
        $object = $this->sql->getRecord("SELECT * FROM `{$this->metaObjectCode}` WHERE ".$classVars['ID_METAATTRIBUTE']."=$id");
		if ($object === false) {
			return false;
		}
        $this->init($object);
		return true;
    }

	/**
	 * Загрузка свойств обекта из базы данных по представлению
	 *
	 * @param int $id
	 * @param int $metaViewId
	 */
    public function loadView($id, $metaViewId)
    {
        $this->id = $id;
        if (!is_numeric($metaViewId))
        {
            $metaViewId = $this->sql->getValue("SELECT id FROM metaview WHERE code='$metaViewId'");
        }
        $metaAttributes = $this->sql->getValueSet("SELECT ma.code FROM metaviewfield mvf LEFT JOIN metaattribute ma ON ma.id=mvf.metaattribute_id WHERE mvf.metaview_id=$metaViewId ORDER BY mvf.pos");
        $conditions = $this->sql->getValueSet("SELECT concat(ma.code,mvc.operation,'\'',mvc.value,'\'') FROM metaviewcondition mvc LEFT JOIN metaattribute ma ON ma.id=mvc.metaattribute_id WHERE mvc.metaview_id=$metaViewId");
        $conditions = $conditions ? ' AND '.implode(' AND ', $conditions) : '';
        $object = $this->sql->getRecord("SELECT ".implode(', ', $metaAttributes)." FROM `{$this->metaObjectCode}` WHERE id=$id $conditions");
        $this->init($object);
    }

	/**
	 * Загрузка конкретных свойств обекта из базы данных
	 *
	 * @param int $id
	 * @param string $metaAttributes
	 */
    public function loadAttributes($id, $metaAttributes)
    {
        Std::loadMetaObjectClass($this->metaObjectCode);
        $className = $this->metaObjectCode.'Object';
        $classVars = get_class_vars($className);
        //
        $this->id = $id;
        $object = $this->sql->getRecord("SELECT $metaAttributes FROM `{$this->metaObjectCode}` WHERE ".$classVars['ID_METAATTRIBUTE']."=$id");
        $this->init($object);
    }

    public function getListByView()
    {
        $metaAttributes = $this->sql->getValueSet("SELECT ma.code FROM metaviewfield mvf LEFT JOIN metaview mv ON mv.id=mvf.metaview_id LEFT JOIN metaattribute ma ON ma.id=mvf.metaattribute_id WHERE mv.code='$metaViewCode' ORDER BY mvf.id");
        $conditions = $this->sql->getValueSet("SELECT concat(ma.code,mvc.operation,'\'',mvc.value,'\'') FROM metaviewcondition mvc LEFT JOIN metaview mv ON mv.id=mvc.metaview_id LEFT JOIN metaattribute ma ON ma.id=mvc.metaattribute_id WHERE mv.code='$metaViewCode' ORDER BY mvc.id");
        $conditions = $conditions ? ' WHERE '.implode(' AND ', $conditions) : '';
        return $this->sql->getRecordSet("SELECT ".implode(', ', $metaAttributes)." FROM `{$this->metaObjectCode}` $conditions");
    }

    public function getList($metaAttributes, $where=false, $order=false, $offset=false, $count=false)
    {
        $where = $where ? ' WHERE '.$where : '';
        $order = $order ? ' ORDER BY '.$order : '';
        $limit = $offset && $count ? ' LIMIT '.$offset.','.$count : '';
        $data = $this->sql->getRecordSet("SELECT SQL_CALC_FOUND_ROWS $metaAttributes FROM `{$this->metaObjectCode}` $where $order $limit");
        $count = $this->sql->getValue("SELECT found_rows()");
        return array('count'=>$count, 'data'=>$data);
    }

    public function uploadFile($fieldCode, $id=0)
    {
        if (!is_dir('@files/'.$this->metaObjectCode))
        {
            mkdir('@files/'.$this->metaObjectCode);
        }
        if ($id)
        {
            $currentState = $this->sql->getRecord("SELECT * FROM stdfile WHERE id=$id");
        }
        if ($_FILES[$fieldCode]['name'] == '')
        {
            return 0;
        }
        $name = $_FILES[$fieldCode]['name'];
        if ($id)
        {
            $path = $currentState['path'];
        }
        else
        {
            $file = Std::translit($name);
            $path = Std::getNextFreeFileName('@files/'.$this->metaObjectCode.'/'.$file);
        }
        $size = $_FILES[$fieldCode]['size'];
        $ext = explode('.', strtolower($name));
        $typeID = $this->sql->getValue("SELECT id FROM stdfiletype WHERE ext='".$ext[count($ext)-1]."'");
        if (!$typeID)
        {
            $typeID = 1;
        }
        if (move_uploaded_file($_FILES[$fieldCode]['tmp_name'], $path))
        {
            if ($id)
            {
                return $this->sql->query("UPDATE stdfile SET file='', path='$path', name='$name', size=$size, type_id=$typeID, dt=now() WHERE id=$id");
            }
            else
            {
                return $this->sql->insert("INSERT INTO stdfile (file, path, name, size, type_id, dt, attached) VALUES ('', '$path', '$name', $size, $typeID, now(), 1)");
            }
        }
    }

    public function uploadImage($fieldCode, $file = '', $id=0, $imagesize = array())
    {
		if (is_numeric($file) && $file > 0 && $id == 0) {
			$id = $file;
			$file = '';
		}
        if (!is_dir('@images/'.$this->metaObjectCode))
        {
            mkdir('@images/'.$this->metaObjectCode);
        }
        if ($id)
        {
            $currentState = $this->sql->getRecord("SELECT * FROM stdimage WHERE id=$id");
        }
        if (!isset ($_FILES[$fieldCode]) || $_FILES[$fieldCode]['name'] == '')
        {
            return 0;
        }
        $name = $_FILES[$fieldCode]['name'];
        if ($id)
        {
            $path = '@images/' . $currentState['path'];
            $previewPath = '@images/' . $currentState['previewpath'];
        }
        else
        {
			if ($file == '' || $file == 0) {
				$file = Std::translit($name);
			}
            $path = Std::getNextFreeFileName('@images/'.$this->metaObjectCode.'/'.$file);
            $previewPath = Std::getNextFreeFileName('@images/'.$this->metaObjectCode.'/@'.$file);
        }
        $size = $_FILES[$fieldCode]['size'];
        $ext = explode('.', strtolower($name));
        $typeID = $this->sql->getValue("SELECT id FROM stdfiletype WHERE ext='".$ext[count($ext)-1]."'");
        if (!$typeID)
        {
            $typeID = 1;
        }
        if (move_uploaded_file($_FILES[$fieldCode]['tmp_name'], $path))
        {
            Std::loadLib('imagetools');
			if (count($imagesize) == 2) {
				ImageTools::resize($path, $path, $imagesize[0], $imagesize[1]);
			}
            list($width, $height) = ImageTools::getSize($path);
            ImageTools::createThumbnail($path, $previewPath);
            if ($id)
            {
                $this->sql->query("UPDATE stdimage SET image='', preview='', path='" . str_replace('@images/', '', $path) . "', previewpath='" . str_replace('@images/', '', $previewPath) . "', name='$name', size=$size, width=$width, height=$height, type_id=$typeID, dt=now() WHERE id=$id");
                return $id;
            }
            else
            {
                return $this->sql->insert("INSERT INTO stdimage (image, preview, path, previewpath, name, width, height, size, type_id, dt, attached) VALUES ('', '', '" . str_replace('@images/', '', $path) . "', '" . str_replace('@images/', '', $previewPath) . "', '$name', $width, $height, $size, $typeID, now(), 1)");
            }
        }
    }

    public function deleteFile($id)
    {
        $path = $this->sql->getValue("SELECT path FROM stdfile WHERE id=$id");
        unlink('@files/'.$path);
        $this->sql->query("DELETE FROM stdfile WHERE id=$id");
    }

    public function deleteImage($id)
    {
        $paths = $this->sql->getRecord("SELECT path, previewpath FROM stdimage WHERE id=$id");
        @unlink('@images/'.$paths['path']);
        @unlink('@images/'.$paths['previewpath']);
        $this->sql->query("DELETE FROM stdimage WHERE id=$id");
    }

	/**
	 * Удаление объекта
	 *
	 */
    public function delete($id)
    {
        if (!$this->metaObjectId) {
        	$this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
        }
        //
        if ($this->globalExtention->eventsOnBeforeDelete)
        {
            $this->globalExtention->onBeforeDelete($id);
        }
        if ($this->extention && $this->extention->eventsOnBeforeDelete)
        {
            $this->extention->onBeforeDelete($id);
        }
        //
        if ($this->globalExtention->eventsOnAfterDelete || ($this->extention && $this->extention->eventsOnAfterDelete))
        {
        	Std::loadMetaObjectClass($this->metaObjectCode);
        	$className = $this->metaObjectCode.'Object';
        	$objectCopy = new $className();
        	$objectCopy->load($id);
        }
        //
        $this->deleteAttachments($id);
        //
        Std::loadMetaObjectClass($this->metaObjectCode);
        $className = $this->metaObjectCode.'Object';
        $classVars = get_class_vars($className);
        //eval('$this->sql->query("DELETE FROM `'.$this->metaObjectCode.'` WHERE '.$className.'::$ID_METAATTRIBUTE."=$id");');
        $this->sql->query("DELETE FROM `".$this->metaObjectCode."` WHERE ".$classVars['ID_METAATTRIBUTE']."=$id");
        //
        $childMetaObjects = $this->sql->getRecordSet("SELECT mr.to id, mo.code FROM metarelation mr LEFT JOIN metaobject mo ON mo.id=mr.to WHERE mr.from={$this->metaObjectId} AND mr.type=1");
        if ($childMetaObjects)
        {
            foreach ($childMetaObjects as $childMetaObject)
            {
                $metaAttribute = $this->sql->getValue("SELECT code FROM metaattribute WHERE metaobject_id={$childMetaObject['id']} AND type=".META_ATTRIBUTE_TYPE_LINKTOOBJECT." AND typeparam='{$this->metaObjectCode}'");
                if ($metaAttribute)
                {
                    $childObjects = $this->sql->getValueSet("SELECT id FROM `{$childMetaObject['code']}` WHERE `$metaAttribute`=$id");
                    if ($childObjects)
                    {
                        foreach ($childObjects as $childObjectId)
                        {
                            $child = new Object();
                            $child->metaObjectCode = $childMetaObject['code'];
                            $child->metaObjectId = $childMetaObject['id'];
                            $child->delete($childObjectId);
                        }
                    }
                }
            }
        }
        //
        if ($this->globalExtention->eventsOnAfterDelete)
        {
            $this->globalExtention->onAfterDelete($id, $objectCopy);
        }
        if ($this->extention && $this->extention->eventsOnAfterDelete)
        {
            $this->extention->onAfterDelete($id, $objectCopy);
        }
    }

    private function deleteAttachments($id)
    {
        if (!$this->metaObjectId) {
        	$this->metaObjectId = $this->sql->getValue("SELECT id FROM metaobject WHERE code='{$this->metaObjectCode}'");
        }
        //
        $metaAttributes = $this->sql->getRecordSet("SELECT id, code, type FROM metaattribute WHERE metaobject_id={$this->metaObjectId} AND (type=".META_ATTRIBUTE_TYPE_FILE." OR type=".META_ATTRIBUTE_TYPE_IMAGE.")");
        if ($metaAttributes)
        {
            $codes = array();
            foreach ($metaAttributes as $metaAttribute)
            {
                $codes[] = $metaAttribute['code'];
            }
            $object = $this->sql->getRecord("SELECT ".implode(',', $codes)." FROM `{$this->metaObjectCode}` WHERE id=$id");
            foreach ($metaAttributes as $metaAttribute)
            {
                if ($object[$metaAttribute['code']])
                {
                    if ($metaAttribute['type'] == META_ATTRIBUTE_TYPE_FILE)
                    {
                        $this->deleteFile($object[$metaAttribute['code']]);
                    }
                    else
                    {
                        $this->deleteImage($object[$metaAttribute['code']]);
                    }
                }
            }
        }
        $metaAttributes = $this->sql->getRecordSet("SELECT id, code, type FROM metaattribute WHERE metaobject_id={$this->metaObjectId} AND type=".META_ATTRIBUTE_TYPE_LINKTOOBJECTS);
        if ($metaAttributes)
        {
            foreach ($metaAttributes as $metaAttribute)
            {
                $this->sql->Query("DELETE FROM metalink WHERE metaattribute_id={$metaAttribute['id']} AND object_id=$id");
            }
        }
    }

    public function render($id, $template)
    {
        $this->load($id);
        return Std::renderTemplate(Std::loadTemplate($template), $this->toArray());
    }

    public function renderView($id, $metaViewCode, $template)
    {
        $this->reset();
        $this->loadView($id, $metaViewCode);
        return Std::renderTemplate(Std::loadTemplate($template), $this->toArray());
    }

    public function renderAttributes($id, $attributes, $template)
    {
        $this->reset();
        $this->loadAttributes($id);
        return Std::renderTemplate(Std::loadTemplate($template), $this->toArray());
    }

	/**************************************************************************/

	/**
	 * ArrayAccess
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function offsetSet($key, $value)
	{
        $this->_data[$key] = $value;
        $this->_changed[] = $key;
    }

	/**
	 * ArrayAccess
	 *
	 * @param string $key
	 * @return bool
	 */
    public function offsetExists($key)
	{
        return isset($this->_data[$key]);
    }

	/**
	 * ArrayAccess
	 *
	 * @param string $key
	 */
    public function offsetUnset($key)
	{
        unset($this->_data[$key]);
    }

	/**
	 * ArrayAcess
	 *
	 * @param string $key
	 * @return mixed
	 */
    public function offsetGet($key)
	{
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

	/**
	 * Magic
	 *
	 * @param string $key
	 * @param mixed $value
	 */
    public function __set($key, $value)
	{
         $this->offsetSet($key, $value);
    }

	/**
	 * Magic
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
        return $this->_data[$key];
    }

	/**
	 * Magic
	 *
	 * @param string $key
	 * @return bool
	 */
	public function __isset($key)
	{
        return isset($this->_data[$key]);
    }

	/**
	 * Magic
	 *
	 * @param string $key
	 */
	public function __unset($key)
	{
        unset($this->_data[$key]);
    }

	/**
	 * Iterator
	 */
	public function rewind()
    {
        reset($this->_data);
    }

	/**
	 * Iterator
	 *
	 * @return mixed
	 */
	public function current()
    {
        return current($this->_data);
    }

	/**
	 * Iterator
	 *
	 * @return mixed
	 */
	public function key()
    {
        return key($this->_data);
    }

	/**
	 * Iterator
	 *
	 * @return mixed
	 */
	public function next()
    {
        return next($this->_data);
    }

	/**
	 * Iterator
	 *
	 * @return bool
	 */
	public function valid()
    {
        return $this->current() !== false;
    }

	/**
	 * Countable
	 *
	 * @return int
	 */
	public function count()
    {
        return sizeof($this->_data);
    }
}
?>