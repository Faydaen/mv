<?php
/**
 * Класс для работы с SQL-сервером MySQL с функциями отладки
 *
 */
class SqlDataSource implements IDataSource
{
    /**
     * Соединение с сервером
     *
     * @var resource
     */
    private $serverLink = null;

    /**
     * Экземпляр класса
     *
     * @var object
     */
    public static $instance = null;

    /**
     * Счетчик запросоа
     *
     * @var int
     */
    public static $queryCount = 0;

    /**
     * Статистика запросов
     *
     * @var array
     */
    public static $queryStatistics = array();

    /**
     * Подключение к серверу БД
     *
     */
    public function __construct()
    {

    }

    /**
     * Разрыв соединения с сервером БД
     *
     */
    public function __destruct()
    {

    }

    /**
     * Получить экземпляр класса
     *
     * @return unknown
     */
    public static function getInstance()
    {
        if (empty(self::$instance))
        {
            self::$instance = new SqlDataSource();
            if (self::$instance->connect())
            {
            	self::$instance->selectDatabase();
            	return self::$instance;
            }
            else
            {
            	self::$instance = null;
            	return false;
            }
        }
        else
        {
        	return self::$instance;
        }
    }

    /**
     * Соединиться с сервером MySQL (параметры соединения берутся из конфига)
     *
     */
    public function connect()
    {
        global $configDb;
        $this->serverLink = mysql_connect($configDb['host'], $configDb['user'], $configDb['pwd'], false, 65536);
        if ($this->serverLink)
        {
        	mysql_query('SET NAMES UTF8', $this->serverLink);
        	mysql_query('SET max_sp_recursion_depth=100', $this->serverLink);
			mysql_query('SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ', $this->serverLink);
        	return true;
        }
        else
        {
            $this->ShowErrorMessage("mysql_connect({$configDb['host']}, {$configDb['user']}, {**********}, false, 65536)");
            return false;
        }
    }

	public function close() {
		mysql_close($this->serverLink);
	}

    /**
     * Выбрать базу данных (параметры соединения берутся из конфига)
     *
     */
    public function selectDatabase()
    {
        global $configDb;
        if (mysql_select_db($configDb['db'], $this->serverLink))
        {
            return true;
        }
        else
        {
        	$this->showErrorMessage("mysql_select_db({$configDb['db']})");
        	return false;
        }
    }

    /**
     * Получить следующую запись из ответа SQL сервера
     *
     * @param resource $SqlResult
     * @return array
     */
    private function nextRow(&$sqlResult)
    {
        $rawRecord = mysql_fetch_assoc($sqlResult);
        if ($rawRecord)
        {
            /*
            $record = array();
            foreach ($rawRecord as $key=>$value)
            {
                $record[$key] = $value;
            }
            return $record;
			*/
			return $rawRecord;
        }
        else
        {
            return false;
        }
    }

    /**
     * Кол-во измененных последним запросом строк
     */
    public function getAffectedRows()
    {
        return mysql_affected_rows($this->serverLink);
    }

    /**
     * Выполнить запрос
     *
     * @param string $query
     * @return resource
     */
    public function q($query)
    {
        return $this->query($query);
    }

    /**
     * Выполнить запрос
     *
     * @param string $query
     * @return resource
     */
    public function query($query)
    {
        self::$queryCount++;
        $t = microtime(true);
        $result = mysql_query($query, $this->serverLink);
        self::$queryStatistics[] = array('Query'=>$query, 'Time'=>(microtime(true)-$t));
        if ($result)
        {
			return mysql_affected_rows($this->serverLink);
            //return $result;
        }
        else
        {
            $this->showErrorMessage($query);
        }
    }

    /**
     * Вставить запись в БД
     *
     * @param string $query
     * @return int
     */
    public function i($query)
    {
        return $this->insert($query);
    }

    /**
     * Вставить запись в БД
     *
     * @param string $query
     * @return int
     */
    public function insert($query)
    {
        self::$queryCount++;
        $t = microtime(true);
        $ok = mysql_query($query, $this->serverLink);
        self::$queryStatistics[] = array('Query'=>$query, 'Time'=>(microtime(true)-$t));
        if (!$ok)
        {
            $this->showErrorMessage($query);
        }
        if ($ok)
        {
            return mysql_insert_id($this->serverLink);
        }
        else
        {
            return false;
        }
    }

    /**
     * Получить значение из БД
     *
     * @param string $query
     * @return string
     */
    public function v($query)
    {
        return $this->getValue($query);
    }

    /**
     * Получить значение из БД
     *
     * @param string $query
     * @return string
     */
    public function getValue($query)
    {
        self::$queryCount++;
        if (!stristr($query, 'LIMIT') && !stristr($query, "FOR UPDATE"))
        {
            $query .= ' LIMIT 0,1';
        }
        $t = microtime(true);
        $result = mysql_query($query, $this->serverLink);
        self::$queryStatistics[] = array('Query'=>$query, 'Time'=>(microtime(true)-$t));
        if (!$result)
        {
            $this->showErrorMessage($query);
        }
        if (is_resource($result) && mysql_num_rows($result) > 0)
        {
            $result = mysql_fetch_row($result);
            return $result[0];
        }
        else
        {
            return false;
        }
    }

    /**
     * Получить массив значений из БД
     *
     * @param string $query
     * @return array
     */
    public function vs($query)
    {
        return $this->getValueSet($query);
    }

    /**
     * Получить массив значений из БД
     *
     * @param string $query
     * @return array
     */
    public function getValueSet($query)
    {
        self::$queryCount++;
        $t = microtime(true);
        $result = mysql_query($query, $this->serverLink);
        self::$queryStatistics[] = array('Query'=>$query, 'Time'=>(microtime(true)-$t));
        if (!$result)
        {
            $this->showErrorMessage($query);
        }
        if (is_resource($result) && mysql_num_rows($result) > 0)
        {
            $valueSet = array();
            while ($row = mysql_fetch_row($result))
            {
                $valueSet[] = $row[0];
            }
            return $valueSet;
        }
        else
        {
            return false;
        }
    }

    /**
     * Получить запись из БД
     *
     * @param string $query
     * @return array
     */
    public function r($query)
    {
        return $this->getRecord($query);
    }

    /**
     * Получить запись из БД
     *
     * @param string $query
     * @return array
     */
    public function getRecord($query)
    {
        self::$queryCount++;
        if (!stristr($query, 'LIMIT') && !stristr($query, "FOR UPDATE"))
        {
            $query .= ' LIMIT 0,1';
        }
        $t = microtime(true);
        $result = mysql_query($query, $this->serverLink);
        self::$queryStatistics[] = array('Query'=>$query, 'Time'=>(microtime(true)-$t));
        if (!$result)
        {
            $this->showErrorMessage($query);
        }
        if (is_resource($result) && mysql_num_rows($result) > 0)
        {
            //$row = $this->nextRow($result);
			$row = mysql_fetch_assoc($result);
            return $row;
        }
        else
        {
            return false;
        }
    }

    /**
     * Получить набор записей из БД
     *
     * @param string $query
     * @return array
     */
    public function rs($query)
    {
        return $this->getRecordSet($query);
    }

    /**
     * Получить набор записей из БД
     *
     * @param string $query
     * @return array
     */
    public function getRecordSet($query)
    {
        self::$queryCount++;
        $t = microtime(true);
        $result = mysql_query($query, $this->serverLink);
        self::$queryStatistics[] = array('Query'=>$query, 'Time'=>(microtime(true)-$t));
        if (!$result)
        {
            $this->ShowErrorMessage($query);
        }
        if (is_resource($result) && mysql_num_rows($result) > 0)
        {
            $recordSet = array();
            //while ($row = $this->nextRow($result))
			while ($row = mysql_fetch_assoc($result))
            {
                $recordSet[] = $row;
            }
            return $recordSet;
        }
        else
        {
            return false;
        }
    }

    /**
     * Вывод сообщения об ошибке
     *
     * @param string $query
     */
    private function showErrorMessage($query)
    {
        echo '
            <div style="margin:2px; padding:2px; border-left:1px solid red; font-size:11px; font-family:Tahoma;">
                '.$query.'<br/>
                '.mysql_error().'
            </div>
        ';
    }

    /**
     * Вывод статистики запросов
     *
     */
    public static function printStatistics()
    {
        $time = 0;
        foreach (self::$queryStatistics as $i)
        {
            echo '
                <div style="margin:2px; padding:2px; border-left:1px solid green; font-size:11px; font-family:Tahoma;">
                    '.$i['Query'].'<br/>
                    '.$i['Time'].'
                </div>
            ';
            $time += $i['Time'];
        }
        echo '
            <div style="margin:2px; padding:2px; border-left:1px solid green; font-size:11px; font-family:Tahoma;">
                '.self::$queryCount.'<br/>
                '.$time.'
            </div>
        ';
    }

    /**
     * Возвращает SQL код для создания колонки определнного типа
     *
     * @param int $Type
     * @param string $TypeParam
     */
    public static function getSqlByType($type, $typeParam='')
    {
        $sqlCode = '';
        switch ($type)
        {
            case META_ATTRIBUTE_TYPE_ID:
                $sqlCode = "INT UNSIGNED NOT NULL AUTO_INCREMENT";
                break;
            case META_ATTRIBUTE_TYPE_INT:
            	switch ($typeParam)
            	{
            		case 1: $sqlCode = "TINYINT"; break;
            		case 2: $sqlCode = "SMALLINT"; break;
            		case 3: $sqlCode = "MEDIUMINT"; break;
            		case 8: $sqlCode = "BIGINT"; break;
            		case 4: 
            		default: $sqlCode = "INT"; break;
            	}
                $sqlCode .= " NOT NULL DEFAULT 0";
                break;
            case META_ATTRIBUTE_TYPE_FLOAT:
                $sqlCode = "DOUBLE NOT NULL DEFAULT 0";
                break;
            case META_ATTRIBUTE_TYPE_STRING:
            	$varchar = 'VAR';
            	if (stristr($typeParam, 'char'))
            	{
            		$varchar = '';
            		if (stristr($typeParam, ','))
            		{
            			$typeParam = explode(',', $typeParam);
            			$typeParam = (int) trim($typeParam[1]);
            		}
            	}
                $sqlCode = $varchar."CHAR(".(is_numeric($typeParam) && $typeParam > 0 ? $typeParam : 255).") CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''";
                break;
            case META_ATTRIBUTE_TYPE_TEXT:
                $sqlCode = "TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
                break;
            case META_ATTRIBUTE_TYPE_BIGTEXT:
                $sqlCode = "MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
                break;
            case META_ATTRIBUTE_TYPE_DATA:
                $sqlCode = "MEDIUMBLOB NOT NULL";
                break;
            case META_ATTRIBUTE_TYPE_DATETIME:
                $sqlCode = "DATETIME NOT NULL";
                break;
            case META_ATTRIBUTE_TYPE_DATE:
                $sqlCode = "DATE NOT NULL";
                break;
            case META_ATTRIBUTE_TYPE_BOOL:
                $sqlCode = "TINYINT(1) NOT NULL DEFAULT 0";
                break;
            case META_ATTRIBUTE_TYPE_FILE:
                $sqlCode = "INT UNSIGNED NOT NULL DEFAULT 0";
                break;
            case META_ATTRIBUTE_TYPE_IMAGE:
                $sqlCode = "INT UNSIGNED NOT NULL DEFAULT 0";
                break;
            case META_ATTRIBUTE_TYPE_LINKTOOBJECT:
                $sqlCode = "INT UNSIGNED NOT NULL DEFAULT 0";
                break;
            case META_ATTRIBUTE_TYPE_LINKTOOBJECTS:
                $sqlCode = "";
                break;
            case META_ATTRIBUTE_TYPE_DICTIONARY:
                $sqlCode = "ENUM('',$typeParam) NOT NULL DEFAULT ''";
                break;
            case META_ATTRIBUTE_TYPE_CUSTOM:
                $sqlCode = "";
                break;
            case META_ATTRIBUTE_TYPE_PASSWORD:
                $sqlCode = "CHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''";
                break;
            case META_ATTRIBUTE_TYPE_QUERY:
                $sqlCode = "";
                break;
        }
        return $sqlCode;
    }
}
?>