<?php

namespace App\Controller;

use App\Constants;
use App\Model\DBObjects\Book;
use App\Model\DBObjects\Bookloan;
use App\Model\DBObjects\Consumer;

class BookSearchController {
    private string $searchStr;
    private string $searchType;

    private ?Consumer $consumer;

    public function __construct() {
        $this->searchStr = $_GET["search-data"] ?? "";
        $this->searchType = $_GET["search-type"] ?? "";
        $this->makeValidSearchValues();
        $this->consumer = SessionManager::Instance()->getUserConsumer();
    }

    private function makeValidSearchValues() {
        $validType = false;
        $types = [
            Constants::SEARCH_TYPE_TITLE,
            Constants::SEARCH_TYPE_AUTHOR,
            Constants::SEARCH_TYPE_CATEGORY
        ];
        foreach($types as $t) {
            if (strcmp($this->searchType, $t) == 0) {
                $validType = true;
                break;
            }
        }
        if (!$validType) {
            $this->searchType = $types[0];
        }
    }

    public function fetchSearchResult() {
        return Book::getBooks($this->searchStr, $this->searchType);
    }

    public function getBookIdsInLoan() {
        $rs = [];
        if (is_null($this->consumer)) {
            return $rs;
        }
        foreach (Bookloan::getAllCurrentLoans($this->consumer->Id) as $bl) {
            $rs[] = intval($bl->BookId);
        }
        return $rs;
    }

    public function getSearchStr() : string {
        return $this->searchStr;
    }

    public function everyBookLink() {
        return Constants::PAGE_BOOKSEARCH;
    }
}
