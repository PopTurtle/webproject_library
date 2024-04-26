<?php

require_once "../../autoloader.php";

use App\Constants;
use App\Controller\ProfileController;
use App\Partials\NavBar;

$pc = new ProfileController;
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
        <h1>Panier</h1>
        <ul>
            <?php
            foreach ($pc->getAllShoppingCartBooks() as $book) {
                ?>
                echo "BOOK";
                <?php
            }
            ?>
        </ul>
    </main>
</body>
</html>