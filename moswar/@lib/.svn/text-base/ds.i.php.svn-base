<?php
/**
 * Интерфейс класса для работы с БД
 *
 */
interface IDataSource
{
    public static function getInstance();

    public function connect();

    public function selectDatabase();

    public function query($query);

    public function insert($query);

    public function getValue($query);

    public function getValueSet($query);

    public function getRecord($query);

    public function getRecordSet($query);

    public static function getSqlByType($type, $typeParam='');
}
?>