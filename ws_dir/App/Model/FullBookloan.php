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
        $request = "SELECT b.*, date_start, date_end FROM book as b, bookloan as bl WHERE bl.consumer_id = 1 AND b.book_id = bl.book_id";
        $res = Database::getConnection()->query($request);
        if (!$res) {
            return false;
        }
        $rs = [];
        while ($arr = $res->fetch()) {
            $arr[Bookloan::getPropertyDBName("BookId")] = $arr[Book::getPropertyDBName("Id")];
            $arr[Bookloan::getPropertyDBName("ConsumerId")] = strval($consumerId);
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
