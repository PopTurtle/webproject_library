<?php

namespace App\Model\DBObjects;

use App\Model\DBObject;


class CartItem extends DBObject {
    protected const TableName = "CartItem";

    protected static $all_properties = [
        "BookId" => "book_id",
        "ConsumerId" => "consumer_id"
    ];

    public static function isInConsumerShoppingCart(int $bookId, int $consumerId) : bool {
        $bid_field = self::$all_properties['BookId'];
        $cid_field = self::$all_properties['ConsumerId'];
        $sc = static::getFirstOBJ([
            "$bid_field = $bookId",
            "$cid_field = $consumerId"
        ]);
        return $sc !== null;
    }

    public static function canAddToShoppingCart(int $bookId, int $consumerId) : bool {
        return !static::isInConsumerShoppingCart($bookId, $consumerId);
    }

    public static function getShoppingCartOfCustomer(int $customer_id) {
        $request = "SELECT * FROM " . self::TableName . " " .
                   "WHERE " . self::$all_properties['ConsumerId'] . " " .
                   "= $customer_id";
        return self::trySelectOBJFromDB($request);
    }

    public static function tryAddToShoppingCart(int $bookId, int $consumerId) {
        if (!static::canAddToShoppingCart($bookId, $consumerId)) {
            return false;
        }
        $sc = new static();
        $sc->BookId = $bookId;
        $sc->ConsumerId = $consumerId;
        return $sc->tryAddToDB();
    }

    public static function removeFromShoppingCart(int $bookId, int $consumerId) {
        $sc = new static();
        $sc->BookId = $bookId;
        $sc->ConsumerId = $consumerId;
        return $sc->removeFromDB();
    }

    protected function ensureCorrectData(): bool {
        return true;
    }
}
