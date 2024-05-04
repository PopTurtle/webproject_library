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
            ]
        );
    }
}

$data = $_POST;
APIBook::workData($data);
APIBook::echoData($data);
