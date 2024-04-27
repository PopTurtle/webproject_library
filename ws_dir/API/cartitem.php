<?php

use App\Controller\SessionManager;
use App\Model\DBObjects\CartItem;

require_once "../autoloader.php";

$data = $_POST;

function actionAdd($data) {
    if (!isset($data["book_id"])) {
        return "no content";
    }
    $c = SessionManager::Instance()->getUserConsumer();
    if ($c === null) {
        return "no user";
    }
    $f = CartItem::tryAddToShoppingCart(intval($data["book_id"]), $c->Id);
    return $f === false ? "no content" : "ok";
}

function actionRemove($data) {
    if (!isset($data["book_id"])) {
        return "no content";
    }
    $c = SessionManager::Instance()->getUserConsumer();
    if ($c === null) {
        return "no user";
    }
    $f = CartItem::removeFromShoppingCart(intval($data["book_id"]), $c->Id);
    return $f === false ? "no content" : "ok";
}

// 
$res = ["status" => "error"];

if (isset($data["action"])) {
    if (strcmp($data["action"], "add") == 0) {
        $res["status"] = actionAdd($data);
    } else if (strcmp($data["action"], "remove") == 0) {
        $res["status"] = actionRemove($data);
    }
}

header("Content-Type: application/json");
echo json_encode($res);
