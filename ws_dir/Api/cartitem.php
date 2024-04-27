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



// Pour le moment : si action == "add" alors ajoute le livre book_id au panier
$res = ["status" => "error"];

if (isset($options["action"]) && strcmp($options["action"], "add") == 0) {
    $res["status"] = actionAdd($options);
}

header("Content-Type: application/json");
echo json_encode($res);
