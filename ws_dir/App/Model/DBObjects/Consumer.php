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

    public const FormPrefix = "user_";
    protected const FormElts = [
        "Id" => ["type" => "number", "fn" => "ID"],
        "Lastname" => ["type" => "text", "fn" => "Nom"],
        "Firstname" => ["type" => "text", "fn" => "Prénom"],
        "Birthdate" => ["type" => "date", "fn" => "Date de naissance"],
        "Mail" => ["type" => "email", "fn" => "Adresse mail"],
        "Password" => ["type" => "password", "fn" => "Mot de passe"]
    ];

    protected const FormAddElts = [
        "Lastname", "Firstname", "Birthdate", "Mail", "Password"
    ];

    /**  Renvoie l'utilisateur dont le mail est $mail s'il existe */
    public static function getConsumerByMail(string $mail) {
        return static::getFirstOBJ([static::$all_properties["Mail"] . " LIKE \"$mail\""]);
    }

    /**  Renvoie l'utilisateur dont l'ID est $id s'il existe */
    public static function getConsumerByID(int $id) {
        return static::getFirstOBJ([static::$all_properties["Id"] . " = $id"]);
    }

    public static function deleteConsumerByID(int $id) : bool {
        $c = new static();
        $c->Id = $id;
        return $c->removeFromDB() !== false;
    }

    public function tryAddToDB(&$propertyError = null) : bool {
        //  Vérifie que le mot de passe n'est pas vide
        if (strcmp($this->Password, "") === 0) {
            if (!is_null($propertyError)) {
                $propertyError = static::getPropertyDBName("Password");
            }
            return false;
        }
        //  Le mot de passe doit être haché.
        $pw = $this->Password;
        $this->Password = Utils::generatePasswordHash($pw);
        $r = parent::tryAddToDB($propertyError);
        $this->Password = $pw;
        return $r;
    }

    /**
     *  Test si un e-mail est déjà utilisé. Si c'est le cas, renvoie 0, sinon
     *    renvoie -1. Renvoie -2 en cas d'erreur de connexion à la BDD
     *  Il est supposé que $mail est valide.
     */
    public static function isMailAlreadyTaken(string $mail) : int {
        $cm = self::getPropertyDBName("Mail");
        $request = "
            SELECT $cm FROM consumer
            WHERE $cm LIKE \"$mail\"";
        $r = Database::Instance()->isEmptyQuery($request);
        if ($r === null) {
            return -2;
        }

        return $r ? 0 : -1;
    }

    protected function ensureCorrectData(&$propertyError = null): bool {
        $m = Database::MAX_STRLEN;
        $test = function ($property, $result) use (&$propertyError) {
            if (!$result && !is_null($propertyError)) {
                $propertyError = static::getPropertyDBName($property);
            }
            return $result;
        };

        // Vérifie que le mail n'est pas déjà pris
        if (!$test("Mail", Utils::isValidMail($this->Mail))) {
            return false;
        }
        $r = static::isMailAlreadyTaken($this->Mail);
        if ($r !== 0) {
            if ($r === -1 && !is_null($propertyError)) {
                $propertyError = static::getPropertyDBName("Mail");
            }
            return false;
        }

        return $test("Id", is_null($this->Id))
            && $test("Firstname", Utils::isNonEmptyString($this->Firstname, $m))
            && $test("Lastname", Utils::isNonEmptyString($this->Lastname, $m))
            && $test("Birthdate", Utils::isCorrectDate($this->Birthdate))
            && $test("Password", Utils::isNonEmptyString($this->Password, $m));
    }
}
