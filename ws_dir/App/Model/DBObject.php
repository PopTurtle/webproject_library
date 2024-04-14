<?php

namespace App\Model;

use InvalidArgumentException;

abstract class DBObject {
    protected const TableName = self::TableName;
    protected static $all_properties;
    private $obj_arr;

    function __construct() {
        $this->obj_arr = [];
    }

    function __get($name)
    {
        return $this->obj_arr[static::${$name}] ?? null;
    }

    function __set($name, $value)
    {
        if (!in_array($name, static::$all_properties)) {
            throw new InvalidArgumentException("Attribut impossible: " . $name);
        }
        $this->obj_arr[static::${$name}] = $value;
    }

    function tryAddToDB(Database $db) {
        if (!$this->ensureCorrectData()) {
            return false;
        }

        $request = "INSERT INTO " . static::TableName
                 . " (" . implode(", ", $this->getAllPropertyOrder()) . ") "
                 . "VALUES (" . implode(", ", $this->getAllValuesOrder()) . ")";

        return $db->connection()->query($request);
    }

    protected abstract function ensureCorrectData(): bool;

    private function getAllPropertyOrder() {
        $vs = [];
        foreach (static::$all_properties as $k) {
            array_push($vs, static::${$k});
        }
        return $vs;
    }

    private function getAllValuesOrder() {
        $vs = [];
        foreach (static::$all_properties as $k) {
            $t = $this->__get($k);
            if ($t != null) {
                $t = "\"" . $t . "\"";
            }
            array_push($vs, $t ?? "NULL");
        }
        return $vs;
    }
}
