<?php

namespace App\Model\DBObjects;

use App\Constants;
use App\Model\DBObject;

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

    protected const FormAddPrefix = "book_";
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
        } elseif (strcmp($type, Constants::SEARCH_TYPE_CATEGORY) == 0) {
            $field = self::$all_properties["Category"];
        }
        $request = "SELECT * FROM " . self::TableName . " "
                 . "WHERE $field LIKE \"%$content%\"" . " "
                 . "LIMIT $limit";
        return static::trySelectOBJFromDB($request);
    }

    /**  Renvoie le livre dont l'id est $id s'il existe, sinon null */
    public static function getBookById(int $id) {
        return static::getFirstOBJ([static::$all_properties["Id"] . " = $id"]);
    }

    protected function ensureCorrectData(&$propertyError = null): bool {
        if (!is_null($propertyError)) {
            $propertyError = "TEST";
        }
        return false;
    }
}
