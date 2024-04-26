<?php

namespace App\Controller;

use App\Constants;
use App\Model\Database;
use App\Model\DBObjects\Book;
use App\Utils\Utils;

class BookController {
    private ?Book $curBook;

    public function __construct() {
        if (!isset($_GET["book_id"])) {
            Utils::redirectTo(Constants::PAGE_HOME);
        }
        $this->curBook = Book::getBookById($_GET["book_id"]);
        if ($this->curBook === false) {
            Utils::showErrorCode(Database::RequestErrorCode, "Impossible de récupérer le livre demandé");
        }
        if ($this->curBook === null) {
            Utils::redirectTo(Constants::PAGE_HOME);
        }
    }

    public function getCurrentBook() : Book {
        return $this->curBook;
    }
}