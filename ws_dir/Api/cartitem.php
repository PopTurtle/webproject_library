<?php

use App\Controller\SessionManager;
use App\Model\DBObjects\CartItem;

require_once "../autoloader.php";

// Pour le moment : si action == "add" alors ajoute le livre book_id au panier
$res = ["status" => -1];

if (isset($_POST["action"]) && strcmp($_POST["action"], "add") == 0) {
    if (!isset($_POST["book_id"])) {
        $res["status"] = -2;
    } else {
        $f = CartItem::tryAddToShoppingCart(
            intval($_POST["book_id"]),
            SessionManager::Instance()->getUserConsumer()->Id
        );
        $res["status"] = $f === false ? -3 : 0;
    }
}

header("Content-Type: application/json");
echo json_encode($res);
