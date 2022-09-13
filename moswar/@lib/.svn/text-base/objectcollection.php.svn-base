<?php
/**
 * Коллекция объектов
 *
 */
class ObjectCollection
{
	private $sql;
	
	public $criteria = false;
	public $metaObjectCode;
	
	public function __construct()
	{
		$this->sql = SqlDataSource::getInstance();
	}
	
	/**
	 * Получить список массивов
	 *
	 * @param string $metaObjectCode
	 * @param object $criteria
	 * @param array $fields
	 * @return array
	 *
	 */
	public function getArrayList($metaObjectCode, $criteria, $fields=false)
	{
            $rows = $this->sql->getRecordSet($this->generateSqlQuery($metaObjectCode, $criteria, $fields));
            if ($rows) {
                $records = array();
                foreach ($rows as $row) {
                    if (isset($row['id']))
                    {
                        $records[$row['id']] = $row;
                    }
                    else
                    {
                        $records[] = $row;
                    }
                }
            return $records;
            }
            else
            {
                return false;
            }
                
	}
	
	/**
	 * Получить список объектов
	 *
	 * @param string $metaObjectCode
	 * @param object $criteria
	 * @param array $fields
	 * @return array
	 *
	 */
	public function getObjectList($metaObjectCode, $criteria, $fields=false)
	{
		Std::loadMetaObjectClass($metaObjectCode);
        ///$className = $metaObjectCode.'Object';
        ///$classVars = get_class_vars($className);
        //
		///$records = $this->sql->getRecordSet($this->generateSqlQuery($metaObjectCode, $criteria, array($classVars['ID_METAATTRIBUTE']=>'id')));
		$records = $this->sql->getRecordSet($this->generateSqlQuery($metaObjectCode, $criteria, $fields));
		//
		if ($records) {
			$objects = array();
			$className = $this->metaObjectCode.'Object';
			///$fields = $this->getFieldList($fields);
			foreach ($records as $record) {
				$object = new $className();
				///$object->loadAttributes($record['id'], $fields);
				$object->init($record);
				$objects[$record['id']] = $object;
			}
			return $objects;
		} else {
			return false;
		}
	}
	
	/**
	 * Генерация SQL запроса
	 *
	 */
	public function generateSqlQuery($metaObjectCode, $criteria, $fields=false)
	{
		$this->metaObjectCode = $metaObjectCode;
		Std::loadMetaObjectClass($this->metaObjectCode);
		//
		$sqlFields = $this->getFieldList($fields);
		//
		$sqlWhere = $this->generateSqlWhere($criteria->where);
		$sqlWhere = sizeof($sqlWhere) ? 'WHERE '.implode($criteria->whereLogic, $sqlWhere) : '';
		//
		$sqlJoin = array();
		if ($criteria->joins) {
			foreach ($criteria->joins as $join)
			{
				if (is_string($join))
				{
					$sqlJoin[] = $join;
				}
				else
				{
					$sqlJoin[] = $join->getSql();
				}
			}
		}
		$sqlJoin = implode(' ', $sqlJoin);
		//
		$sqlOrder = array();
		if ($criteria->orders) {
			foreach ($criteria->orders as $order)
			{
				if (is_string($order))
				{
					$sqlOrder[] = $order;
				}
				else
				{
					$sqlOrder[] = $order->getSql();
				}
			}
		}
		$sqlOrder = sizeof($sqlOrder) ? 'ORDER BY ' . implode(', ', $sqlOrder) : '';
		//
		$sqlLimit = $criteria->count > 0 ? 'LIMIT '.$criteria->offset.', '.$criteria->count : '';
		//
		return "SELECT $sqlFields FROM `".$this->metaObjectCode."` $sqlJoin $sqlWhere $sqlOrder $sqlLimit";
	}
	
	/**
	 * Генерация списка полей для выборки в виде строки
	 *
	 */
	private function getFieldList($fields)
	{
		if ($fields)
		{
			$sqlFields = array();
			//if (!isset($fields['id']))
			//{
			//	$fields['id'] = 'id';
			//}
			foreach ($fields as $code=>$alias)
			{
				if (is_numeric($code)) {
					$sqlFields[] = $alias;
				} else {
					$sqlFields[] = $code.' '.$alias;
				}
			}
			$sqlFields = implode(', ', $sqlFields);
		}
		else
		{
			$sqlFields = '*';
		}
		return $sqlFields;
	}
	
	/**
	 * Генерация условий WHERE для запроса
	 *
	 */
	private function generateSqlWhere($where)
	{
		$whereParts = array();
		if ($where) {
			foreach($where as $w)
			{
				if (is_string($w))
				{
					$whereParts[] = $w;
				}
				elseif(is_a($w, 'ObjectCollectionWhereSet'))
				{
					$whereParts[] = '('.implode($w->logic, $this->generateSqlWhere($w->where)).')';
				}
				elseif(is_a($w, 'ObjectCollectionWhereItem'))
				{
					$whereParts[] = $w->getSql();
				}
			}
		}
		return $whereParts;
	}
}

class ObjectCollectionCriteria
{
	public static $WHERE_AND = ' AND ';
	public static $WHERE_OR = ' OR ';
	
	public static $COMPARE_EQUAL = '=';
	public static $COMPARE_NOT_EQUAL = '!=';
	public static $COMPARE_GREATER = '>';
	public static $COMPARE_SMALLER = '<';
	public static $COMPARE_EQUAL_OR_GREATER = '>=';
	public static $COMPARE_EQUAL_OR_SMALLER = '<=';
	public static $COMPARE_LIKE = ' LIKE ';
	public static $COMPARE_BETWEEN = 1;
	public static $COMPARE_IN = 2;
	public static $COMPARE_NOT_IN = 3;
	
	public static $JOIN_INNER = 'INNER';
	public static $JOIN_LEFT = 'LEFT';
	public static $JOIN_RIGHT = 'RIGHT';
	
	public static $ORDER_ASC = 'ASC';
	public static $ORDER_DESC = 'DESC';
	public static $ORDER_RANDOM = 'rand()';

	public $where = array();
	public $whereLogic;
	public $joins = array();
	public $orders = array();
	public $offset = 0;
	public $count = 0;
	
	public function __construct()
	{
		$this->whereLogic = ObjectCollectionCriteria::$WHERE_AND;
	}
	
	public function addWhere($where)
	{
		$this->where[] = $where;
	}
	
	public function createWhere($fieldCode, $comparison, $value, $value2=false)
	{
		$this->where[] = new ObjectCollectionWhereItem($fieldCode, $comparison, $value, $value2);
	}
	
	public function setWhereLogic($logic)
	{
		$this->whereLogic = $logic;
	}
	
	public function createJoin($metaObjectCode, $field1Code, $field2Code, $mode = '')
	{
		if ($mode == '') {
			$mode = ObjectCollectionCriteria::$JOIN_INNER;
		}
		$this->joins[] = new ObjectCollectionJoinItem($metaObjectCode, $field1Code, $field2Code, $mode);
	}
	
	public function addJoin($join)
	{
		$this->joins[] = $join;
	}
	
	public function createOrder($fieldCode, $mode)
	{
		$this->orders[] = new ObjectCollectionOrderItem($fieldCode, $mode);
	}
	
	public function addOrder($order)
	{
		$this->orders[] = $order;
	}
	
	public function addLimit($offset, $count)
	{
		$this->offset = $offset;
		$this->count = $count;
	}
}

class ObjectCollectionWhereSet
{
	public $where = array();
	public $logic;
	
	public function __construct($logic=false, $where=array())
	{
		$this->logic = $logic ? $logic : ObjectCollectionCriteria::$WHERE_AND;
		$this->where = $where;
	}
	
	public function createWhere($fieldCode, $criteria, $value, $value2=false)
	{
		$this->where[] = new ObjectCollectionWhereItem($fieldCode, $criteria, $value, $value2);
	}
	
	public function addWhere($where)
	{
		$this->where[] = $where;
	}
	
	public function setLogic($logic)
	{
		$this->logic = $logic;
	}
}

class ObjectCollectionWhereItem
{
	public $fieldCode;
	public $comparison;
	public $value;
	public $value2;
	public $custom;
	
	public function __construct($fieldCode, $comparison, $value, $value2=false)
	{
		$this->fieldCode = $fieldCode;
		$this->comparison = $comparison;
		$this->value = $value;
		$this->value2 = $value2;
	}
	
	public function getSql()
	{
		switch ($GLOBALS['configDb']['type'])
		{
			case 'mysql':
				switch ($this->comparison)
				{
					case ObjectCollectionCriteria::$COMPARE_BETWEEN:
						return $this->fieldCode." BETWEEN '".mysql_real_escape_string($this->value)."' AND '".mysql_real_escape_string($this->value2)."'";
						break;
					case ObjectCollectionCriteria::$COMPARE_IN:
					case ObjectCollectionCriteria::$COMPARE_NOT_IN:
						for  ($i=0, $j=sizeof($this->value); $i<$j; $i++)
						{
							$this->value[$i] = mysql_real_escape_string($this->value[$i]);
						}
						return $this->fieldCode." ".($this->comparison == ObjectCollectionCriteria::$COMPARE_NOT_IN ? "NOT" : "")." IN ('".implode("', '", $this->value)."')";
						break;
					default:
						return $this->fieldCode.$this->comparison.( (is_numeric($this->value) || $this->comparison == '') ? $this->value : "'" . mysql_real_escape_string($this->value) . "'");
						break; 
				}
				break;
		}
	}
}

class ObjectCollectionJoinItem
{
	public $metaObjectCode;
	public $field1;
	public $field2;
	public $mode;
	public $custom;
	
	public function __construct($metaObjectCode, $field1, $field2, $mode=false)
	{
		$this->metaObjectCode = $metaObjectCode;
		$this->field1 = $field1;
		$this->field2 = $field2;
		$this->mode = $mode ? $mode : ObjectCollectionCriteria::$WHERE_INNER;
		//
		Std::loadMetaObjectClass($metaObjectCode);
	}
	
	public function getSql()
	{
		switch ($GLOBALS['configDb']['type'])
		{
			case 'mysql':
				return $this->mode.' JOIN `'.$this->metaObjectCode.'` ON '.$this->field1.'='.$this->field2;
				break;
		}
	}
}

class ObjectCollectionOrderItem
{
	public $fieldCode;
	public $direction;
	
	public function __construct($fieldCode, $direction=false)
	{
		$this->fieldCode = $fieldCode;
		$this->direction = $direction ? $direction : ObjectCollectionCriteria::$ORDER_ASC;
	}
	
	public function getSql()
	{
		switch ($GLOBALS['configDb']['type'])
		{
			case 'mysql':
				return $this->direction == ObjectCollectionCriteria::$ORDER_RANDOM ? 'rand()' : $this->fieldCode.' '.$this->direction;
				break;
		}
	}
}
?>