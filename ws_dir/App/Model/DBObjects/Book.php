<?php

namespace App\Model\DBObjects;

use App\Constants;
use App\Model\Database;
use App\Model\DBObject;
use App\Utils\Utils;

/**
 *  Représente un livre, de la table 'book'
 */
class Book extends DBObject {
    public const TableName = "book";

    protected static $all_properties = [
        "Id" => "book_id",
        "Title" => "title",
        "Author" => "author",
        "Editor" => "editor",
        "PublicationYear" => "publication_year",
        "Category" => "category",
        "Stock" => "stock"
    ];

    public const FormAddPrefix = "book_";
    protected const FormAddElts = [
        "Title" => ["type" => "text", "fn" => "Titre"],
        "Author" => ["type" => "text", "fn" => "Auteur"],
        "Editor" => ["type" => "text", "fn" => "Editeur"],
        "PublicationYear" => ["type" => "number", "fn" => "Année de publication"],
        "Category" => ["type" => "text", "fn" => "Catégorie"],
        "Stock" => ["type" => "number", "fn" => "Stock"]
    ];

    /**
     *  Renvoie tous les livres dont le champs $type (title, author...) contient
     *    dans sa valeur $content
     */
    public static function getBooks(string $content, string $type, int $limit = 50) {
        $field = self::$all_properties["Title"];
        if (strcmp($type, Constants::SEARCH_TYPE_AUTHOR) == 0) {
            $field = self::$all_properties["Author"];
        } else if (strcmp($type, Constants::SEARCH_TYPE_CATEGORY) == 0) {
            $field = self::$all_properties["Category"];
        }
        $request = "SELECT * FROM " . self::TableName . " "
                 . "WHERE $field LIKE \"%$content%\"" . " "
                 . "LIMIT $limit";
        return static::trySelectOBJFromDB($request);
    }

    /**
     *  Renvoie le livre dont l'id est $id s'il existe, sinon null.
     *  Renvoie false en cas d'erreur.
     */
    public static function getBookById(int $id) {
        return static::getFirstOBJ([static::$all_properties["Id"] . " = $id"]);
    }

    public static function deleteBookById(int $id) : bool {
        $b = new static();
        $b->Id = $id;
        return $b->removeFromDB() !== false;
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
            && $test("Title", Utils::isNonEmptyString($this->Title, $m))
            && $test("Author", Utils::isNonEmptyString($this->Author, $m))
            && $test("Editor", Utils::isNonEmptyString($this->Editor, $m))
            && $test("PublicationYear", Utils::isInt($this->PublicationYear))
            && $test("Category", Utils::isNonEmptyString($this->Category, $m))
            && $test("Stock", Utils::isNonEmptyString($this->Stock, $m));
    }
}
