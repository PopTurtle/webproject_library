<?php

namespace App\Model;

use App\Controller\Misc\FormMaker;
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
    public const TableName = self::TableName;

    protected static $all_properties;
    
    public const FormPrefix = "";

    //  Le premier élément de FormElts doit être la clé primaire si elle existe
    protected const FormElts = [];
    protected const FormAddElts = [];

    private $obj_arr;

    /** Initialise un objet dont les attributs n'ont pas de valeur */
    public function __construct() {
        $this->obj_arr = [];
    }

    /**  Renvoie la valeur associée a un attribut si elle existe */
    public function __get($name)
    {
        return $this->obj_arr[$name] ?? null;
    }

    /**
     *  Met à jour la valeur associée à $name si possible, sinon lève une
     *  exception de type InvalidArgumentException
     */
    public function __set($name, $value)
    {
        if (!array_key_exists($name, static::$all_properties)) {
            throw new InvalidArgumentException("Attribut inexistant: " . $name);
        }
        $this->obj_arr[$name] = $value;
    }

    public static function getPropertyDBName($name) {
        return static::$all_properties[$name] ?? null;
    }

    /**
     *  Ajoute tous les objets $objects à la BDD, en supposant qu'ils sont de
     *    type la classe courante.
     */
    public static function tryAddArrayToDB($objects) : bool {
        $properties = "(" . implode(", ", static::getAllPropertyDBName()) . ")";
        $request = "INSERT INTO " . static::TableName . $properties . " VALUES ";
        $values = [];
        foreach ($objects as $obj) {
            $values[] = "(" . implode(", ", static::getPropertyValues($obj)) . ")";
        }
        $request .= implode(", ", $values);
        return Database::getConnection()->exec($request);
    }

    /**  Tente d'ajouter l'objet courant à la BDD en utilisant ses valeurs. */
    public function tryAddToDB(&$propertyError = null) : bool {
        if (!$this->ensureCorrectAddData($propertyError)) {
            return false;
        }
        $kv = static::getPropertyValues($this);
        $request = "INSERT INTO " . static::TableName
                 . " (" . implode(", ", array_keys($kv)) . ") "
                 . "VALUES (" . implode(", ", array_values($kv)) . ")";
        return Database::getConnection()->exec($request) !== false;
    }

    public function tryUpdateDB(&$propertyError = null) : bool {
        if (!$this->ensureCorrectUpdateData($propertyError)) {
            return false;
        }
        $es = [];
        foreach (static::getPropertyValues($this) as $k => $v) {
            $es[] = $k . " = " . $v;
        }
        $request = "UPDATE " . static::TableName . " "
                 . "SET " . implode(", ", $es) . " "
                 . "WHERE " . $this->updateDBCond();
        return Database::getConnection()->exec($request) !== false;
    }

    /**
     *  Retire tous les objets de la BDD dont les valeurs correspondent
     *    avec celles de l'objet courant. Attention : des valeurs non définie
     *    correspondent à toutes les valeurs possibles.
     */
    public function removeFromDB($limit = 0) {
        $kv = $this->getDefinedPropertyValues($this);
        $opt = [];
        foreach ($kv as $k => $v) {
            $opt[] = "$k = $v";
        }
        $request = "DELETE FROM " . static::TableName . " " .
                   "WHERE " . implode(" AND ", $opt);
        if ($limit !== 0) {
            $request .= " LIMIT $limit";
        }
        return Database::getConnection()->exec($request);
    }

    /**
     *  Renvoie un nouvel objet dont les valeur seront celles associées
     *    au tableau $values. $values contient des clés qui sont les noms
     *    des attributs trouvés en BDD, et leur valeur.
     */
    public static function createFromDBArr($values) {
        $v = new static();
        $v->setValFromDBArr($values);
        return $v;
    }

    public static function generateAddForm(string $inputClasses = "") {
        if (count(static::FormAddElts) === 0) {
            return false;
        }
        $fae = static::getFormAddElts();
        return static::generateFormExclusive($inputClasses, $fae);
    }

    public static function generateAllFormArgs() {
        foreach (array_keys(static::FormElts) as $k) {
            yield static::FormPrefix . static::getPropertyDBName($k);
        }
    }

    public static function generateAllAddFormArgs() {
        foreach (array_keys(static::getFormAddElts()) as $k) {
            yield static::FormPrefix . static::getPropertyDBName($k);
        }
    }

    public static function treatAddForm($data, &$propertyError = null) : int {
        $object = static::ObjFromFormData($data);
        return $object->tryAddToDB($propertyError) ? 0 : -1;
    }

    public static function generateUpdateForm(string $inputClasses = "") {
        return static::generateFormExclusive($inputClasses, static::FormElts);
    }

    public static function treatUpdateForm($data, &$propertyError = null) : int {
        $object = static::ObjFromFormData($data);
        return $object->tryUpdateDB($propertyError) ? 0 : -1;
    }

    /**
     *  S'assure que les valeurs associées aux attributs serait conformes au
     *    modèle si on ajoutait l'objet.
     */
    protected abstract function ensureCorrectData(&$propertyError = null) : bool;
    
    protected function ensureCorrectAddData(&$propertyError = null) : bool {
        return $this->ensureCorrectData($propertyError);
    }

    protected function ensureCorrectUpdateData(&$propertyError = null) : bool {
        return $this->ensureCorrectData($propertyError);
    }

    protected function updateDBCond() : string {
        return "0";
    }

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
     *  Renvoie un tableau comportant tous les objets renvoyés par la requête
     *    request. Il est supposé que cette requete renvoie bien des données
     *    valides pour l'objet donné. Renvoie false en cas d'erreur.
     */
    protected static function trySelectOBJFromDB(string $request) {
        $res = Database::getConnection()->query($request);
        if (!$res) {
            return false;
        }
        $rs = [];
        while ($val = $res->fetch()) {
            array_push($rs, static::createFromDBArr($val));
        }
        return $rs;
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
     *  Renvoie un tableau associatif dont les clés sont les noms des attributs
     *    en BDD et les valeurs sont celles de l'objet $object.
     */
    protected static function getPropertyValues($object) {
        $vs = [];
        foreach (static::$all_properties as $k => $v) {
            $t = $object->__get($k);
            if ($t !== null) {
                $t = "\"" . $t . "\"";
            }
            $vs[$v] = $t ?? "NULL";
        }
        return $vs;
    }

    /**
     *  Renvoie un tableau contenant les valeurs associées aux propriétés de
     *    l'object $object, dans l'ordre.
     */
    protected static function getValues($object) {
        $values = [];
        foreach (static::$all_properties as $k => $v) {
            $t = $object->__get($k);
            if ($t !== null) {
                $t = "\"" . $t . "\"";
            }
            array_push($values, $t ?? "NULL");
        }
        return $values;
    }

    /**
     *  Similaire à getPropertyValues mais ignore les attributs qui n'ont pas
     *    de valeur définie.
     */
    protected static function getDefinedPropertyValues($object) {
        $vs = [];
        foreach (static::$all_properties as $k => $v) {
            $t = $object->__get($k);
            if ($t !== null) {
                $vs[$v] = "\"" . $t . "\"";
            }
        }
        return $vs;
    }

    protected static function getAllPropertyDBName() {
        return array_values(static::$all_properties);
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

    protected static function getFormAddElts() {
        $fae = [];
        foreach (static::FormAddElts as $elt) {
            if (array_key_exists($elt, static::FormElts)) {
                $fae[$elt] = static::FormElts[$elt];
            }
        }
        return $fae;
    }

    protected static function generateFormExclusive(string $inputClasses, $elts) {
        $fm = FormMaker::Instance();
        foreach (static::$all_properties as $k => $v) {
            if (!array_key_exists($k, $elts)) {
                continue;
            }
            $f = $fm->generateInputInfo(static::FormPrefix . $v, $inputClasses);
            $f["label_content"] = $elts[$k]["fn"];
            $f["input_type"] = $elts[$k]["type"];
            yield $f;
        }
    }

    protected static function ObjFromFormData($data) {
        $object = new static();
        foreach (static::$all_properties as $k => $v) {
            $arg = static::FormPrefix . $v;
            if (array_key_exists($arg, $data)) {
                $object->{$k} = $data[$arg];
            }
        }
        return $object;
    }

    /**
     *  Produit un tableau contenant les informations nécessaire pour passer
     *    un DBObject dans un formulaire
     */
    public function generatePrefilledInputs() {
        $rs = [];
        foreach (static::$all_properties as $k => $v) {
            $rs[static::FormPrefix . $v] = $this->{$k} ?? "";
        }
        return $rs;
    }
}
