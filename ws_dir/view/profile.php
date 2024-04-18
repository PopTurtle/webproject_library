<?php

require_once "../autoloader.php";

use App\Constants;
use App\Controller\SessionManager;
use App\Model\DBObjects\Book;
use App\Partials\NavBar;
use App\Utils\Utils;

$sm = SessionManager::Instance();
if (isset($_POST["mail"]) && isset($_POST["password"])) {
    $res = $sm->tryConnectUser($_POST["mail"], $_POST["password"], true);
    if ($res != 0) {
        switch ($res) {
            case SessionManager::USERCONNECT_FAILED_MAIL:
                echo "MAIL INVALIDE" . PHP_EOL;
                break;
            case SessionManager::USERCONNECT_FAILED_PASS:
                echo "PASS INVALIDE" . PHP_EOL;
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putStyle(); ?>
</head>
<body>
    <?php //NavBar::put(); ?>
    <main>
    </main>
</body>
</html>