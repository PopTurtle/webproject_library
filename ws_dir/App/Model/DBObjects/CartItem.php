<?php

namespace App\Model\DBObjects;

use App\Model\Database;
use App\Model\DBObject;
use App\Utils\Utils;

class CartItem extends DBObject
{
    public const TableName = "cartitem";

    protected static $all_properties = [
        "BookId" => "book_id",
        "ConsumerId" => "consumer_id"
    ];

    public static function isInConsumerShoppingCart(int $bookId, int $consumerId): bool
    {
        $bid_field = self::$all_properties['BookId'];
        $cid_field = self::$all_properties['ConsumerId'];
        $sc = static::getFirstOBJ([
            "$bid_field = $bookId",
            "$cid_field = $consumerId"
        ]);
        return !is_null($sc);
    }

    public static function canAddToShoppingCart(int $bookId, int $consumerId): bool
    {
        return !static::isInConsumerShoppingCart($bookId, $consumerId);
    }

    public static function getShoppingCartOfCustomer(int $customer_id)
    {
        $request = "SELECT * FROM " . self::TableName . " " .
            "WHERE " . self::$all_properties['ConsumerId'] . " " .
            "= $customer_id";
        return self::trySelectOBJFromDB($request);
    }

    public static function getBooksFromShoppingCartOfCustomer(int $consumerId) {
        $ctn = self::TableName;
        $btn = Book::TableName;
        $ccid_field = self::getPropertyDBName("ConsumerId");
        $cbid_field = self::getPropertyDBName("BookId");
        $bbid_field = Book::getPropertyDBName("Id");
        $request = "SELECT * FROM $btn as b, $ctn as c
                    WHERE c.$ccid_field = $consumerId AND
                          b.$bbid_field = c.$cbid_field";
        return Book::trySelectOBJFromDB($request);
    }

    public static function tryAddToShoppingCart(int $bookId, int $consumerId)
    {
        if (!static::canAddToShoppingCart($bookId, $consumerId)) {
            return false;
        }
        $sc = new static();
        $sc->BookId = $bookId;
        $sc->ConsumerId = $consumerId;
        return $sc->tryAddToDB();
    }

    public static function removeFromShoppingCart(int $bookId, int $consumerId)
    {
        $sc = new static();
        $sc->BookId = $bookId;
        $sc->ConsumerId = $consumerId;
        return $sc->removeFromDB();
    }

    /**
     *  Renvoie si le panier de consumerId est vide
     *  @return bool|null
     */
    public static function isEmptyShoppingCart(int $consumerId): bool
    {
        $request = "SELECT * FROM " . self::TableName . " WHERE consumer_id = $consumerId";
        return Database::Instance()->isEmptyQuery($request);
    }

    /**
     *  Renvoie si tous les livres d'un panier sont en stock
     *  @return bool|null
     */
    public static function everyBookFromShoppingCartInStock(int $consumerId)
    {
        $bid_field = Book::getPropertyDBName("Id");
        $request = "SELECT b.$bid_field FROM " . BOOK::TableName . " as b, " . self::TableName . " as ci
                    WHERE ci." . self::getPropertyDBName("ConsumerId") . " = $consumerId
                        AND b.$bid_field = ci." . CartItem::getPropertyDBName("BookId") . "
                        AND b." . Book::getPropertyDBName("Stock") . " <= 0";
        return Database::Instance()->isEmptyQuery($request);
    }

    /**
     *  Renvoie true si tout les livres du panier ne sont pas déjà empruntés
     *    par le même utilisateur. Renvoie false sinon. Renvoie null en cas
     *    d'erreur.
     */
    public static function noBookFromShoppingCartIsLoan(int $consumerId) {
        $bl_tn = Bookloan::TableName;
        $ci_tn = CartItem::TableName;
        $blbid_field = Bookloan::getPropertyDBName("BookId");
        $cibid_field = CartItem::getPropertyDBName("BookId");
        $blcid_field = Bookloan::getPropertyDBName("ConsumerId");
        $cicid_field = CartItem::getPropertyDBName("ConsumerId");
        $request = "SELECT bl.$blbid_field 
                    FROM $bl_tn as bl, $ci_tn as ci 
                    WHERE ci.$cicid_field = $consumerId AND 
                          bl.$blcid_field = $consumerId AND 
                          bl.$blbid_field = ci.$cibid_field";
        return Database::Instance()->isEmptyQuery($request);
    }

    protected function ensureCorrectData(&$propertyError = null): bool
    {
        $test = function ($property, $result) use (&$propertyError) {
            if (!$result && !is_null($propertyError)) {
                $propertyError = static::getPropertyDBName($property);
            }
            return $result;
        };

        return $test("BookId", Utils::isInt($this->BookId, 0))
            && $test("ConsumerId", Utils::isInt($this->ConsumerId, 0));
    }

    protected function ensureCorrectUpdateData(&$propertyError = null): bool
    {
        return false;
    }
}
