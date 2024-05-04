<?php

use API\APIPage;
use App\Controller\SessionManager;
use App\Model\DBObjects\CartItem;

require_once "../autoloader.php";

class APICartItem extends APIPage {
    protected static function executeActions(&$data) {
        $data[static::resultKey] = static::tryActions(
            $data,
            [
                "add" => [
                    "require" => ["book_id"],
                    "callback" => function (&$d) { return static::addCartItem(intval($d["book_id"])); }
                ],
                "remove" => [
                    "require" => ["book_id"],
                    "callback" => function (&$d) { return static::removeCartItem(intval($d["book_id"])); }
                ]
            ]
        );
    }

    private static function addCartItem(int $book_id) : string {
        //return "no content";
        $c = SessionManager::Instance()->getUserConsumer();
        if ($c === null) {
            return "no user";
        }
        $f = CartItem::tryAddToShoppingCart($book_id, $c->Id);
        return $f === false ? "no content" : "ok";
    }

    private static function removeCartItem(int $bookId) {
        $c = SessionManager::Instance()->getUserConsumer();
        if ($c === null) {
            return "no user";
        }
        $f = CartItem::removeFromShoppingCart($bookId, $c->Id);
        return $f === false ? "no content" : "ok";
    }
}

$data = $_POST;
APICartItem::workData($data);
APICartItem::echoData($data);
