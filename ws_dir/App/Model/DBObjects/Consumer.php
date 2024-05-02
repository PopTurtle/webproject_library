<?php

namespace App\Model\DBObjects;

use App\Model\DBObject;

/**
 *  Représente un utilisateur, de la table 'consumer'
 */
class Consumer extends DBObject {
    public const TableName = "consumer";

    protected static $all_properties = [
        "Id" => "consumer_id",
        "Firstname" => "firstname",
        "Lastname" => "lastname",
        "Birthdate" => "birthdate",
        "Mail" => "mail",
        "Password" => "password"
    ];

    /**  Renvoie l'utilisateur dont le mail est $mail s'il existe */
    public static function getConsumerByMail(string $mail) {
        return static::getFirstOBJ([static::$all_properties["Mail"] . " LIKE \"$mail\""]);
    }

    /**  Renvoie l'utilisateur dont l'ID est $id s'il existe */
    public static function getConsumerByID(int $id) {
        return static::getFirstOBJ([static::$all_properties["Id"] . " = $id"]);
    }

    protected function ensureCorrectData(&$propertyError = null): bool {
        return false;
    }
}
