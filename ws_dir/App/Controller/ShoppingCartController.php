<?php

namespace App\Controller;

use App\Constants;
use App\Model\DBObjects\CartItem;
use App\Model\DBObjects\Consumer;
use App\Utils\Utils;

class ShoppingCartController {

    private Consumer $consumer;

    public function __construct()
    {
        $this->consumer = SessionManager::Instance()->getUserConsumer();
        if ($this->consumer === null) {
            Utils::redirectTo(Constants::PAGE_LOGIN);
        }
    }

    public function getAllShoppingCartBooks() {
        return CartItem::getShoppingCartOfCustomer($this->consumer->Id);
    }
}
