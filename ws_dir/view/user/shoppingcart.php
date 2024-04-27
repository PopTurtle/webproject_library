<?php

use App\Constants;
use App\Controller\ShoppingCartController;
use App\Partials\NavBar;

require_once "../../autoloader.php";

$scc = new ShoppingCartController;
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
            foreach ($scc->getAllShoppingCartBooks() as $book) {
                echo "BOOK" . PHP_EOL;
                var_dump($book);
                ?>
                <?php
            }
            ?>
        </ul>
        <p>Date de rendu prévue: jamais</p>
        <button>
            Valider l'emprunt (Panier vide ?)
        </button>
    </main>
</body>
</html>