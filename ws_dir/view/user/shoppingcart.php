<?php

use App\Constants;
use App\Controller\ShoppingCartController;
use App\Partials\NavBar;
use App\Utils\Utils;

require_once "../../autoloader.php";

$scc = new ShoppingCartController();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_SHOPPINGCART ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="sc-section">
            <h1>Mon panier</h1>
            <div class="sc-container">
                <?php
                foreach ($scc->getAllShoppingCartBooks() as $book) {
                    ?>
                    <div>
                        <?php var_dump($book); ?>
                    </div>
                    <?php
                    break;
                }
                ?>
            </div>
            <p>Date de rendu prévue: dd/mm/yyyy</p>
            <a href="" class="button">Valider l'emprunt</a>
        </section>
    </main>
</body>
</html>