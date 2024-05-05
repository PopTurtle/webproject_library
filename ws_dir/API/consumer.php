<?php

use API\APIPage;
use App\Controller\SessionManager;
use App\Model\DBObjects\Consumer;

require_once "../autoloader.php";

class APIConsumer extends APIPage {
    protected static function executeActions(&$data)
    {
        $data[static::resultKey] = static::tryActions(
            $data,
            [
                "delete" => [
                    "require" => ["consumer_id"],
                    "callback" => function (&$d) { return self::deleteConsumer(intval($d["consumer_id"])); }
                ]
            ]
        );
    }

    private static function deleteConsumer(int $id) {
        if (!SessionManager::Instance()->isUserAdmin()) {
            return "no permission";
        }
        return Consumer::deleteConsumerByID($id) ? "ok" : "no content";
    }
}

$data = $_POST;
APIConsumer::workData($data);
APIConsumer::echoData($data);
