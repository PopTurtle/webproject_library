<?php

namespace App\Model\DBObjects;

use App\Model\Database;
use App\Model\DBObject;
use App\Utils\Utils;

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

    public const FormAddPrefix = "user_";
    protected const FormAddElts = [
        "Lastname" => ["type" => "text", "fn" => "Nom"],
        "Firstname" => ["type" => "text", "fn" => "Prénom"],
        "Birthdate" => ["type" => "date", "fn" => "Date de naissance"],
        "Mail" => ["type" => "email", "fn" => "Adresse mail"],
        "Password" => ["type" => "password", "fn" => "Mot de passe"]
    ];

    /**  Renvoie l'utilisateur dont le mail est $mail s'il existe */
    public static function getConsumerByMail(string $mail) {
        return static::getFirstOBJ([static::$all_properties["Mail"] . " LIKE \"$mail\""]);
    }

    /**  Renvoie l'utilisateur dont l'ID est $id s'il existe */
    public static function getConsumerByID(int $id) {
        return static::getFirstOBJ([static::$all_properties["Id"] . " = $id"]);
    }

    public function tryAddToDB(&$propertyError = null) : bool {
        // Le mot de passe doit être haché.
        $pw = $this->Password;
        $this->Password = Utils::generatePasswordHash($pw);
        $r = parent::tryAddToDB($propertyError);
        $this->Password = $pw;
        return $r;
    }

    protected function ensureCorrectData(&$propertyError = null): bool {
        $m = Database::MAX_STRLEN;
        $test = function ($property, $result) use (&$propertyError) {
            if (!$result && !is_null($propertyError)) {
                $propertyError = static::getPropertyDBName($property);
            }
            return $result;
        };

        return $test("Id", is_null($this->Id))
            && $test("Firstname", Utils::isNonEmptyString($this->Firstname, $m))
            && $test("Lastname", Utils::isNonEmptyString($this->Lastname, $m))
            && $test("Birthdate", Utils::isCorrectDate($this->Birthdate))
            && $test("Mail", Utils::isValidMail($this->Mail))
            && $test("Password", Utils::isNonEmptyString($this->Password, $m));
    }
}
