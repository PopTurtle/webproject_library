<?php

namespace App\Controller;

use App\Model\Database;
use App\Model\DBObjects\Book;
use App\Utils\Utils;

class AdminActionBookController {

    private bool $hasFormResult;
    private ?Book $searchResult;

    public function __construct()
    {
        $valid = function (string $k) {
            return isset($_GET[$k]) && strcmp($_GET[$k], "") !== 0;
        };

        $this->searchResult = null;
        $this->hasFormResult = isset($_GET["book_id"]) || isset($_GET["book_title"]);
        if ($valid("book_id") && Utils::isInt($_GET["book_id"])) {
            $this->fetchBookId($_GET["book_id"]);
        } else if ($valid("book_title")) {
            $this->fetchBookTitle($_GET["book_title"]);
        }
    }

    public function hasFormResult() : bool {
        return $this->hasFormResult;
    }

    public function getSearchResult() : ?Book {
        return $this->searchResult;
    }

    private function fetchBookId(int $book_id) {
        $r = Book::getBookById($book_id);
        if ($r === false) {
            self::fetchError();
        }
        $this->searchResult = $r;
    }

    private function fetchBookTitle(string $str) {
        $r = Book::getBooks($str, "title", 1);
        if ($r === false) {
            self::fetchError();
        }
        $this->searchResult = isset($r[0]) ? $r[0] : null;
    }

    private function fetchError() {
        Utils::showErrorCode(
            Database::ConnectionErrorCode,
            "Erreur lors de la recherche"
        );
    }
}
