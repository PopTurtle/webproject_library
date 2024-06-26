<?php

use App\Constants;
use App\Controller\ShoppingCartController;
use App\Model\DBObjects\Bookloan;
use App\Partials\NavBar;
use App\Utils\Utils;

require_once "../../autoloader.php";

$scc = new ShoppingCartController();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <script src="<?= Constants::SCRIPT_SHOPPINGCART ?>" type="module"></script>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_SHOPPINGCART ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(["btn_mode" => Navbar::BTN_SHOPPINGCART]); ?>
    <main>
        <section class="sc-section">
            <h1>Mon panier</h1>
            <?php
            $books = $scc->getAllShoppingCartBooks();
            if (count($books) === 0) {
                ?>
                <p>Vous n'avez aucun livre dans votre panier</p>
                <?php
            }
            ?>
            <div class="sc-container">
                <?php
                foreach ($books as $book) {
                    ?>
                    <div class="book-container">
                        <div class="cover">
                            <img src="<?= $book->getCoverPath() ?>" alt="Couverture">
                        </div>
                        <p class="book-title"><?= $book->Title ?></p>
                    </div>
                    <?php
                }
                ?>
            </div>
            
            <?php
            if (count($books) !== 0) {
                ?>
                <p class="end-date">Date de rendu prévue: <?= Utils::formatDate($scc->getLoanEndDate()) ?></p>
                <div class="validate-btn-container">
                    <button id="validate-shopping-cart">
                        Débuter l'emprunt
                    </button>
                </div>
                <?php
            }
            ?>
        </section>
    </main>
</body>
</html>