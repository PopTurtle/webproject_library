<?php

namespace App\Model\DBObjects;

use App\Model\Database;
use App\Model\DBObject;

class Consumer extends DBObject {
    protected const TableName = "consumer";

    protected static $all_properties = [
        "Id" => "consumer_id",
        "Firstname" => "firstname",
        "Lastname" => "lastname",
        "Birthdate" => "birthdate",
        "Mail" => "mail",
        "Password" => "password"
    ];

    public static function getConsumerByMail(string $mail) {
        return static::getFirstOBJ([static::$all_properties["Mail"] . " LIKE \"$mail\""]);
    }

    public static function getConsumerByID(int $id) {
        return static::getFirstOBJ([static::$all_properties["Id"] . " = $id"]);
    }

    protected function ensureCorrectData(): bool {
        return false;
    }
}
