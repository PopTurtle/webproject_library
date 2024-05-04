<?php

use API\APIPage;
use App\Controller\SessionManager;
use App\Model\DBObjects\Bookloan;

require_once "../autoloader.php";

class APIBookloan extends APIPage {
    protected static function executeActions(&$data)
    {
        return static::tryActions($data, [
                "return" => [
                    "require" => ["book_id"],
                    "callback" => function (&$d) { return static::returnLoan(intval($d["book_id"])); }
                ],
                "renew" => [
                    "require" => ["book_id"],
                    "callback" => function (&$d) { return static::renewLoan(intval($d["book_id"])); }
                ],
                "validate" => [
                    "callback" => function (&$d) { return static::validateShoppingCart(); }
                ]
            ]
        );
    }

    private static function returnLoan(int $bookId) {
        $c = SessionManager::Instance()->getUserConsumer();
        if (is_null($c)) {
            return "no user";
        }
        return Bookloan::returnLoan($c->Id, $bookId) ? "ok" : "no content";
    }

    private static function renewLoan(int $bookId) {
        $c = SessionManager::Instance()->getUserConsumer();
        if (is_null($c)) {
            return "no user";
        }
        return Bookloan::renewLoan($c->Id, $bookId) ? "ok" : "no content";
    }

    private static function validateShoppingCart() {
        $c = SessionManager::Instance()->getUserConsumer();
        if (is_null($c)) {
            return "no user";
        }
        return Bookloan::makeLoanFromShoppingCart($c->Id) ? "ok" : "no content";
    }
}

$data = $_POST;
APIBookloan::workData($data);
APIBookloan::echoData($data);

exit();

$data = $_POST;

function bookLoanReturn($data) {
    if (!isset($data['book_id'])) {
        return "no content";
    }
    $bookId = $data['book_id'];
    $c = SessionManager::Instance()->getUserConsumer();
    if (is_null($c)) {
        return "no user";
    }
    return Bookloan::returnLoan($c->Id, $bookId) ? "ok" : "no content";
}

function bookLoanRenew($data) {
    if (!isset($data['book_id'])) {
        return "no content";
    }
    $bookId = $data['book_id'];
    $c = SessionManager::Instance()->getUserConsumer();
    if (is_null($c)) {
        return "no user";
    }
    return Bookloan::renewLoan($c->Id, $bookId) ? "ok" : "no content";
}

function validateShoppingCart() {
    $c = SessionManager::Instance()->getUserConsumer();
    if (is_null($c)) {
        return "no user";
    }
    return Bookloan::makeLoanFromShoppingCart($c->Id) ? "ok" : "no content";
}

// 
$res = ["status" => "error"];

if (isset($data["action"])) {
    if (strcmp($data["action"], "return") == 0) {
        $res["status"] = bookLoanReturn($data);
    } else if (strcmp($data["action"], "renew") == 0) {
        $res["status"] = bookLoanRenew($data);
    } else if (strcmp($data["action"], "validate") == 0) {
        $res["status"] = validateShoppingCart();
    }
}

header("Content-Type: application/json");
echo json_encode($res);
