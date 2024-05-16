<?php

namespace App\Controller;

use App\Constants;
use App\Model\Database;
use App\Model\DBObjects\Bookloan;
use App\Model\DBObjects\CartItem;
use App\Model\DBObjects\Consumer;
use App\Utils\Utils;

class ShoppingCartController {

    private Consumer $consumer;
    private $books;

    public function __construct()
    {
        $sm = SessionManager::Instance();
        if (!$sm->isUserConnected()) {
            Utils::redirectTo(Constants::PAGE_LOGIN);
        }
        $this->consumer = $sm->getUserConsumer();
        $this->books = CartItem::getShoppingCartOfCustomer($this->consumer->Id);
        if ($this->books === false) {
            Utils::showErrorCode(Database::RequestErrorCode, "Impossible de récupérer les données");
        }
    }

    public function getAllShoppingCartBooks() {
        return $this->books;
    }

    // From today
    public function getLoanEndDate() {
        return Utils::getDateIn(Bookloan::LOAN_DURATION);
    }

    //
    public function validateShoppingCart() : bool {
        return Bookloan::makeLoanFromShoppingCart($this->consumer->Id);
    }
}
