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

    public const FormPrefix = "book_";
    public const FormCoverArg = "book_cover";

    protected const FormElts = [
        "Id" => ["type" => "number", "fn" => "ID"],
        "Title" => ["type" => "text", "fn" => "Titre"],
        "Author" => ["type" => "text", "fn" => "Auteur"],
        "Editor" => ["type" => "text", "fn" => "Editeur"],
        "PublicationYear" => ["type" => "number", "fn" => "Année de publication"],
        "Category" => ["type" => "text", "fn" => "Catégorie"],
        "Stock" => ["type" => "number", "fn" => "Stock"]
    ];

    protected const FormAddElts = [
        "Title", "Author", "Editor", "PublicationYear", "Category", "Stock"
    ];

    public const CoverPlaceholderImage = "/App/Assets/Images/Logo.png";

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

    /**
     *  Gestion de la couverture d'un livre
     */
    public static function getBookCoverPath(int $bookId): string {
        $fn = "cov_" . strval($bookId) . ".jpg";
        $full_fn = Utils::getFullStorageFolder() . "/Cover/" . $fn;
        $cp = static::CoverPlaceholderImage;
        return !file_exists($full_fn) ? $cp : Utils::getRootStorageFolder() . "/Cover/" . $fn;
    }

    public static function setBookCover(int $bookId, string $filepath): bool {
        $rpath = Utils::getFullStorageFolder() . "/Cover/cov_" . strval($bookId) . ".jpg";
        if (!move_uploaded_file($filepath, $rpath)) {
            return false;
        }
        return true;
    }

    public static function deleteBookCover(int $bookId): bool {
        $fn = Utils::getRootStorageFolder() . "/Cover/cov_" . strval($bookId) . ".png";
        return unlink($fn);
    }

    public static function treatAddForm($data, &$propertyError = null): int
    {
        $r = parent::treatAddForm($data, $propertyError);
        if ($r !== 0) {
            return $r;
        }
        //  Ajoute la couverture si elle existe
        //  ! Ne renvoie pas d'erreur en cas d'échec
        $q = Database::getConnection()->query("SELECT LAST_INSERT_ID()");
        if ($q === false) {
            return 0;
        }
        $id = $q->fetch()[0];
        $path = $_FILES[static::FormCoverArg]["tmp_name"];
        self::setBookCover($id, $path);
        return $r;
    }

    public function getCoverPath(): string {
        return static::getBookCoverPath($this->Id);
    }

    protected function ensureCorrectData(&$propertyError = null): bool {
        $m = Database::MAX_STRLEN;
        $test = function ($property, $result) use (&$propertyError) {
            if (!$result && !is_null($propertyError)) {
                $propertyError = static::getPropertyDBName($property);
            }
            return $result;
        };

        return $test("Title", Utils::isNonEmptyString($this->Title, $m))
            && $test("Author", Utils::isNonEmptyString($this->Author, $m))
            && $test("Editor", Utils::isNonEmptyString($this->Editor, $m))
            && $test("PublicationYear", Utils::isInt($this->PublicationYear))
            && $test("Category", Utils::isNonEmptyString($this->Category, $m))
            && $test("Stock", Utils::isNonEmptyString($this->Stock, $m));
    }

    protected function ensureCorrectAddData(&$propertyError = null): bool
    {
        if (!parent::ensureCorrectAddData($propertyError)) {
            return false;
        }
        $r = is_null($this->Id);
        if (!$r && !is_null($propertyError)) {
            $propertyError = static::getPropertyDBName("Id");
        }
        return $r;
    }

    protected function ensureCorrectUpdateData(&$propertyError = null): bool
    {
        if (!parent::ensureCorrectUpdateData($propertyError)) {
            return false;
        }
        $r = Utils::isInt($this->Id);
        if (!$r && !is_null($propertyError)) {
            $propertyError = static::getPropertyDBName("Id");
        }
        return $r;
    }

    protected function updateDBCond(): string
    {
        return static::getPropertyDBName("Id") . " = " . $this->Id;
    }
}
