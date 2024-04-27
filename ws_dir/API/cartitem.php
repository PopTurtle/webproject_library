<?php

use App\Controller\SessionManager;
use App\Model\DBObjects\CartItem;

require_once "../autoloader.php";

$options = $_POST;

function actionAdd($options) {
    if (!isset($options["book_id"])) {
        return "no content";
    }
    $c = SessionManager::Instance()->getUserConsumer();
    if ($c === null) {
        return "no user";
    }
    $f = CartItem::tryAddToShoppingCart(intval($options["book_id"]), $c->Id);
    return $f === false ? "no content" : "ok";
}

function actionRemove($options) {
    if (!isset($options["book_id"])) {
        return "no content";
    }
    $c = SessionManager::Instance()->getUserConsumer();
    if ($c === null) {
        return "no user";
    }
    $f = CartItem::removeFromShoppingCart(intval($options["book_id"]), $c->Id);
    return $f === false ? "no content" : "ok";
}

// 
$res = ["status" => "error"];

if (isset($options["action"])) {
    if (strcmp($options["action"], "add") == 0) {
        $res["status"] = actionAdd($options);
    } else if (strcmp($options["action"], "remove") == 0) {
        $res["status"] = actionRemove($options);
    }
}

header("Content-Type: application/json");
echo json_encode($res);
