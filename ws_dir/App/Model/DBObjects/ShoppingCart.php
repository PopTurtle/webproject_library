<?php

namespace App\Model\DBObjects;

use App\Model\DBObject;


class ShoppingCart extends DBObject {
    protected const TableName = "ShoppingCart";

    protected static $all_properties = [
        "BookId" => "book_id",
        "ConsumerId" => "consumer_id"
    ];

    public static function canAddToShoppingCart(int $bookId, int $consumerId) : bool {
        $bid_field = self::$all_properties['BookId'];
        $cid_field = self::$all_properties['ConsumerId'];
        $sc = static::getFirstOBJ([
            "$bid_field = $bookId",
            "$cid_field = $consumerId"
        ]);
        if ($sc === null) {
            return true;
        } else {
            return false;
        }
    }

    public static function tryAddToShoppingCart(int $bookId, int $consumerId) {
        if (!static::canAddToShoppingCart($bookId, $consumerId)) {
            return false;
        }
        $sc = new ShoppingCart();
        $sc->bookId = $bookId;
        $sc->consumerId = $consumerId;
        return $sc->tryAddToDB();
    }

    protected function ensureCorrectData(): bool {
        return false;
    }
}
