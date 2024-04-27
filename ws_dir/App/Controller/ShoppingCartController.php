<?php

namespace App\Controller;

use App\Constants;
use App\Model\DBObjects\Bookloan;
use App\Model\DBObjects\CartItem;
use App\Model\DBObjects\Consumer;
use App\Utils\Utils;

class ShoppingCartController {

    private Consumer $consumer;

    public function __construct()
    {
        $sm = SessionManager::Instance();
        if (!$sm->isUserConnected()) {
            Utils::redirectTo(Constants::PAGE_LOGIN);
        }
        $this->consumer = $sm->getUserConsumer();
    }

    public function getAllShoppingCartBooks() {
        return CartItem::getShoppingCartOfCustomer($this->consumer->Id);
    }

    // From today
    public function getLoanEndDate() {
        return Utils::getDateIn(Bookloan::LOAN_DURATION);
    }
}
