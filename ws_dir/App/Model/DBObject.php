<?php

namespace App\Model;

use InvalidArgumentException;
use PDOStatement;


/**
 *  Classe représentant un objet dans la base de donnée pour une certaine
 *    table. Il pourra être ajouté (si possible) à la BDD, ou être récupéré
 *    depuis celle-ci.
 *  Il est supposé à chaque appel de méthode que la connection à la BDD a été
 *    effectuée sans erreur, sinon le comportement est indéterminé.
 *  
 *  Fonctionnement
 *  - Le tableau $all_properties stock des clé (key) valeurs (val) tels que
 *    key est le nom d'accès à l'attribut dans le code, et val son nom associé
 *    dans la BDD.
 *  - Le tableau obj_arr stock les valeurs associées à ces attributs
 *    Exemple : un attribut Attr dont le nom en BDD serait attr
 *      $all_properties["Attr"] == "attr"
 *      $obj_arr["Attr"] == (Valeur de attr en BDD, peut être null)
 *      Un objet obj de type DBOject: obj.Attr == $obj_arr["Attr"]
 */
abstract class DBObject {
    /**  Nom de la table en BDD, doit être redéfini par la classe dérivée */
    protected const TableName = self::TableName;
    protected static $all_properties;
    
    private $obj_arr;

    /** Initialise un objet dont les attributs n'ont pas de valeur */
    function __construct() {
        $this->obj_arr = [];
    }

    /**  Renvoie la valeur associée a un attribut si elle existe */
    function __get($name)
    {
        return $this->obj_arr[$name] ?? null;
    }

    /**
     *  Met à jour la valeur associée à $name si possible, sinon lève une
     *  exception de type InvalidArgumentException
     */
    function __set($name, $value)
    {
        if (!array_key_exists($name, static::$all_properties)) {
            throw new InvalidArgumentException("Attribut inexistant: " . $name);
        }
        $this->obj_arr[$name] = $value;
    }

    /**  Tente d'ajouter l'objet courant à la BDD en utilisant ses valeurs. */
    public function tryAddToDB() {
        if (!$this->ensureCorrectData()) {
            return false;
        }

        // -----------------------------------------------------------
        $kv = $this->getPropertyValues();
        $request = "INSERT INTO " . static::TableName
                 . " (" . implode(", ", array_keys($kv)) . ") "
                 . "VALUES (" . implode(", ", array_values($kv)) . ")";
        return Database::getConnection()->query($request);
    }

    /**
     *  S'assure que les valeurs associées aux attributs sont conformes au
     *    modèle.
     */
    protected abstract function ensureCorrectData() : bool;

    /**
     *  Renvoie le résultat de la requête associée à :
     *  SELECT * FROM (table du DBJObject) $after_str
     *  
     *  @return \PDOStatement|false
     */
    protected static function trySelectFromDB(string $after_str) {
        $request = "SELECT * FROM " . static::TableName . " " . $after_str;
        return Database::getConnection()->query($request);
    }

    /**
     *  Renvoie le premier objet qui respecte toutes les conditions SQL de
     *    $cond_arr, exemple de $cond_arr: ["title LIKE %fromage%"]
     * 
     *  @return ?static|false
     */
    protected static function getFirstOBJ($cond_arr) {
        $res = static::trySelectFromDB("WHERE " . implode(" AND ", $cond_arr) . " LIMIT 1");
        if ($res === false) {
            return false;
        }
        $vinfo = $res->fetch();
        if (!$vinfo) {
            return null;
        }
        $v = static::createFromDBArr($vinfo);
        return $v;
    }

    /**
     *  Renvoie un nouvel objet dont les valeur seront celles associées
     *    au tableau $values. $values contient des clés qui sont les noms
     *    des attributs trouvés en BDD, et leur valeur.
     */
    protected static function createFromDBArr($values) {
        $v = new static();
        $v->setValFromDBArr($values);
        return $v;
    }

    /**
     *  Mets à jours les valeurs de l'objet grâce à celles trouvées dans
     *    $values.
     */
    protected function setValFromDBArr($values) {
        foreach (static::$all_properties as $k => $v) {
            if (array_key_exists($v, $values)) {
                $this->obj_arr[$k] = $values[$v];
            }
        }
    }

    /**
     *  Renvoie un tableau associatif dont les clés sont les noms des attributs
     *    en BDD et les valeurs sont celles de l'objet courant.
     */
    protected function getPropertyValues() {
        $vs = [];
        foreach (static::$all_properties as $k => $v) {
            $t = $this->__get($k);
            if ($t != null) {
                $t = "\"" . $t . "\"";
            }
            $vs[$v] = $t ?? "NULL";
        }
        return $vs;
    }
}
