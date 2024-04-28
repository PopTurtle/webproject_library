<?php

namespace App\Model\DBObjects;

use App\Model\Database;
use App\Model\DBObject;
use App\Utils\Utils;

/**
 * Représente un emprunt, de la table 'bookloan'
 */
class Bookloan extends DBObject {
    public const TableName = "bookloan";

    /**  Durée d'un prêt en jours */
    public const LOAN_DURATION = 15;

    protected static $BookId = "book_id";
    protected static $ConsumerId = "consumer_id";
    protected static $DateStart = "date_start";
    protected static $DateEnd = "date_end";

    protected static $all_properties = [
        "BookId" => "book_id",
        "ConsumerId" => "consumer_id",
        "DateStart" => "date_start",
        "DateEnd" => "date_end",
    ];

    /**
     *  Transfert les livres du panier vers un prêt qui se terminera dans
     *    LOAN_DURATION jours.
     */
    public static function makeLoanFromShoppingCart(int $consumerId) : bool {
        //  Test que le panier n'est pas vide
        if (self::isEmptyShoppingCart($consumerId)) {
            return false;
        }
        //  Test que tous les livres du panier sont en stock
        if (self::everyBookFromShoppingCartInStock($consumerId) !== true) {
            return false;
        }
        //  Transfère les livres du panier en un emprunt
        $date_start = Utils::getTodayDate();
        $date_end = Utils::getDateIn(self::LOAN_DURATION);
        return self::transferShoppingCartIntoLoan($consumerId, $date_start, $date_end);
    }

    /**
     *  Renvoie si le panier de consumerId est vide
     *  @return bool|null
     */
    public static function isEmptyShoppingCart(int $consumerId) : bool {
        $request = "SELECT * FROM " . CartItem::TableName . " WHERE consumer_id = $consumerId";
        return Database::Instance()->isEmptyQuery($request);
    }

    /**
     *  Renvoie si tous les livres d'un panier sont en stock
     *  @return bool|null
     */
    public static function everyBookFromShoppingCartInStock(int $consumerId) {
        $bid_field = Book::getPropertyDBName("Id");
        $request = "SELECT b.$bid_field FROM " . BOOK::TableName . " as b, " . CartItem::TableName ." as ci
                    WHERE ci." . CartItem::getPropertyDBName("ConsumerId") . " = $consumerId
                        AND b.$bid_field = ci." . CartItem::getPropertyDBName("BookId") . "
                        AND b." . Book::getPropertyDBName("Stock") . " <= 0";
        return Database::Instance()->isEmptyQuery($request);
    }

    /**
     *  Convertie le panier de $consumerId en un emprunt (bookloan) qui commence
     *    à $date_start et fini à $date_end.
     */
    private static function transferShoppingCartIntoLoan(int $consumerId, string $date_start, string $date_end) : bool {
        $c = Database::getConnection();
        //  Récupère tous les livres
        $request = "SELECT * FROM " . CartItem::TableName . "
                    WHERE consumer_id = $consumerId";
        $items = CartItem::trySelectOBJFromDB($request);
        if (count($items) === 0) {
            return false;
        }
        $loans = [];
        foreach ($items as $i) {
            $l = new static();
            $l->BookId = $i->BookId;
            $l->ConsumerId = $i->ConsumerId;
            $l->DateStart = $date_start;
            $l->DateEnd = $date_end;
            array_push($loans, $l);
        }
        //  Démarre une transaction
        if (!$c->beginTransaction()) {
            return false;
        }
        //  Ajoute tous les emprunts
        if (!BookLoan::tryAddArrayToDB($loans) && false) {
            $c->rollBack();
            return false;
        }
        //  Retire 1 aux stocks des livres empruntés
        $s_field = Book::getPropertyDBName("Stock");
        $cbid_field = CartItem::getPropertyDBName("BookId");
        $ccid_field = CartItem::getPropertyDBName("ConsumerId");
        $bbid_field = Book::getPropertyDBName("Id");
        $request = "UPDATE " . Book::TableName ." as b, " . CartItem::TableName . " as ci
                    SET $s_field = $s_field - 1
                    WHERE ci.$ccid_field = $consumerId AND b.$bbid_field = ci.$cbid_field";
        if ($c->exec($request) === false) {
            $c->rollBack();
            return false;
        }
        //  Supprime le panier
        $request = "DELETE FROM " . CartItem::TableName . "
                    WHERE $ccid_field = $consumerId";
        if ($c->exec($request) === false) {
            $c->rollback();
            return false;
        }
        return $c->commit();
    }

    protected function ensureCorrectData() : bool {
        return false;
    }
}
