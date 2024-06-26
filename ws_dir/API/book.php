<?php

use API\APIPage;
use App\Controller\SessionManager;
use App\Model\DBObjects\Book;

require_once "../autoloader.php";

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
        if (!SessionManager::Instance()->isUserAdmin()) {
            return "no permission";
        }
        return Book::deleteBookById($bookId) ? "ok" : "no content";
    }
}

$data = $_POST;
APIBook::workData($data);
APIBook::echoData($data);
