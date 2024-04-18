<?php

namespace App\Model\DBObjects;

use App\Model\DBObject;


/**
 * Représente un emprunt, de la table 'bookloan'
 */
class Bookloan extends DBObject {
    protected const TableName = "bookloan";

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

    protected function ensureCorrectData() : bool {
        return false;
    }
}
