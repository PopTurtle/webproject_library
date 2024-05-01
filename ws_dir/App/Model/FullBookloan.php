<?php

namespace App\Model;

use App\Model\DBObjects\Book;
use App\Model\DBObjects\Bookloan;

class FullBookloan {
    private Book $book;
    private Bookloan $loan;

    private function __construct(Book $b, Bookloan $bl)
    {
        $this->book = $b;
        $this->loan = $bl;
    }

    /**
     *  Renvoie un tableau de FullBookloan contenant les 'book' et 'bookloan'
     *    associés aux emprunts courant d'un utilisateur. Renvoie false en cas
     *    d'erreur.
     */
    public static function getFullBookLoansFromConsumer(int $consumerId) {
        $btable = Book::TableName;
        $bltable = Bookloan::TableName;

        $bl_bid = Bookloan::getPropertyDBName("BookId");
        $bl_cid = Bookloan::getPropertyDBName("ConsumerId");
        $bl_ds = Bookloan::getPropertyDBName("DateStart");
        $bl_de = Bookloan::getPropertyDBName("DateEnd");
        $b_bid = Book::getPropertyDBName("Id");
        
        $request = "
            SELECT b.*, $bl_ds, $bl_de 
            FROM $btable as b, $bltable as bl 
            WHERE bl.$bl_cid = $consumerId
                AND b.$b_bid = bl.$bl_bid";
                
        $res = Database::getConnection()->query($request);
        if (!$res) {
            return false;
        }
        $rs = [];
        while ($arr = $res->fetch()) {
            $arr[$bl_bid] = $arr[$b_bid];
            $arr[$bl_cid] = strval($consumerId);
            $b = Book::createFromDBArr($arr);
            $bl = Bookloan::createFromDBArr($arr);
            array_push($rs, new static($b, $bl));
        }
        return $rs;
    }

    public function book() : Book {
        return $this->book;
    }

    public function loan() : Bookloan {
        return $this->loan;
    }
}
