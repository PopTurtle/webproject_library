<?php

use API\APIPage;
use App\Model\DBObjects\Book;

require "../autoloader.php";

class APIBook extends APIPage {
    protected static function executeActions(&$data)
    {
        $data[static::resultKey] = static::tryActions(
            $data,
            [
                "delete" => [
                    "require" => ["book_id"],
                    "callback" => function (&$d) { return self::deleteBook(intval($d["book_id"])); }
                ]
            ]
        );
    }

    private static function deleteBook(int $bookId) : string {
        return Book::deleteBookById($bookId) ? "ok" : "no content";
    }
}

$data = $_POST;
APIBook::workData($data);
APIBook::echoData($data);
