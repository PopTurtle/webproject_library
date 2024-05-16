<?php

namespace App\Controller;

use App\Constants;
use App\Model\Database;
use App\Model\DBObjects\Book;
use App\Model\DBObjects\Bookloan;
use App\Model\DBObjects\CartItem;
use App\Model\DBObjects\Consumer;
use App\Utils\Utils;

class BookSearchController {
    private string $searchStr;
    private string $searchType;

    private ?Consumer $consumer;
    private $loans;
    private $books;

    public function __construct() {
        $this->searchStr = $_GET["search-data"] ?? "";
        $this->searchType = $_GET["search-type"] ?? "";
        $this->makeValidSearchValues();
        $this->consumer = SessionManager::Instance()->getUserConsumer();
        if (!is_null($this->consumer)) {
            $this->books = CartItem::getShoppingCartOfCustomer($this->consumer->Id);
            if ($this->books === false) {
                Utils::showErrorCode(Database::RequestErrorCode, "Erreur lors d'une requête");
            }        
            $this->loans = Bookloan::getAllCurrentLoans($this->consumer->Id);
            if ($this->loans === false) {
                Utils::showErrorCode(Database::RequestErrorCode, "Erreur lors d'une requête");
            }
        }
    }

    /**  S'assure que les données de recherches sont valides */
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

    /**  Tente de récupérer les livres associés à la recherche en cours */
    public function fetchSearchResult() {
        $r = Book::getBooks($this->searchStr, $this->searchType);
        if ($r === false) {
            Utils::showErrorCode(Database::RequestErrorCode, "Impossible de récupérer les livres");
        }
        return $r;
    }

    /**  Renvoie les identifiants des livres déjà empruntés */
    public function getBookIdsInLoan() {
        $rs = [];
        if (is_null($this->consumer)) {
            return $rs;
        }
        foreach ($this->loans as $bl) {
            $rs[] = intval($bl->BookId);
        }
        return $rs;
    }

    /**  Renvoie les identifiants des livres dans le panier */
    public function getBookIdsInCart() {
        $rs = [];
        if (is_null($this->consumer)) {
            return $rs;
        }
        foreach ($this->books as $ci) {
            $rs[] = intval($ci->BookId);
        }
        return $rs;
    }

    /**  Renvoie les données de la recherche actuelle */
    public function getSearchStr() : string {
        return $this->searchStr;
    }

    /**  Lien vers la recherche de "Tous les livres" (= pas de recherche) */
    public function everyBookLink() {
        return Constants::PAGE_BOOKSEARCH;
    }
}
