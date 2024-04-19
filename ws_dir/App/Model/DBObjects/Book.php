<?php

namespace App\Model\DBObjects;

use App\Constants;
use App\Model\DBObject;

/**
 *  Représente un livre, de la table 'book'
 */
class Book extends DBObject {
    protected const TableName = "book";

    protected static $all_properties = [
        "Id" => "book_id",
        "Title" => "title",
        "Author" => "author",
        "Editor" => "editor",
        "PublicationYear" => "publication_year",
        "Category" => "category",
        "Stock" => "stock"
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

    protected function ensureCorrectData(): bool {
        return false;
    }
}
