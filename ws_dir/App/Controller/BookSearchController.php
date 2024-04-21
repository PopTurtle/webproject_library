<?php

namespace App\Controller;

use App\Constants;
use App\Model\DBObjects\Book;

class BookSearchController {

    private bool $validSearchResult;
    private $result;

    private string $searchStr;
    private string $searchType;

    public function __construct()
    {
        $this->searchStr = $_GET["search-data"] ?? "";
        $this->searchType = $_GET["search-type"] ?? "";
        $this->makeValidSearchValues();
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

    public function getSearchStr() : string {
        return $this->searchStr;
    }

    public function getSearchResult() {
        return Book::getBooks($this->searchStr, $this->searchType);
    }
}
