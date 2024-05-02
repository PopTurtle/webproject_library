<?php

use App\Constants;
use App\Controller\AdminMainController;
use App\Partials\NavBar;
use App\Utils\Utils;

require_once "../../autoloader.php";

$amc = new AdminMainController;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <p>Page admin</p>
    </main>
</body>
</html>