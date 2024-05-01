<?php

use App\Controller\SessionManager;
use App\Model\DBObjects\Bookloan;

require_once "../autoloader.php";

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

// 
$res = ["status" => "error"];

if (isset($data["action"])) {
    if (strcmp($data["action"], "return") == 0) {
        $res["status"] = bookLoanReturn($data);
    }
}

header("Content-Type: application/json");
echo json_encode($res);
