<?php

use App\Constants;
use App\Controller\BookController;
use App\Controller\SessionManager;
use App\Model\DBObjects\CartItem;
use App\Partials\NavBar;

require_once "../autoloader.php";

$bc = new BookController;
$cb = $bc->getCurrentBook();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $cb->Title ?></title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_BOOK ?>>
    <script src="<?= Constants::SCRIPT_BOOK_CARTITEM ?>" type="module"></script>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="book-presentation">
            <a href="<?= Constants::PAGE_BOOKSEARCH ?>">Retour</a>
            <h1><?= $cb->Title ?></h1>
        </section>
        <section class="book-infos">
            <div class="book-cover">
                <div class="cover-container">
                    <img src="<?= $cb->getCoverPath() ?>" alt="Couverture du livre">
                </div>
            </div>
            <div class="infos">
                <p>Ecris par: <?= $cb->Author ?></p>
                <p>En: <?= $cb->PublicationYear ?></p>
                <p>Editeur: <?= $cb->Editor ?></p>
                <p>Catégorie: <?= $cb->Category ?></p>
                <p>Stock: <?= $cb->Stock ?></p>
                <div class="btn-container">
                    <?php
                    if (!SessionManager::Instance()->isUserConnected()) {
                        ?>
                        <a href="<?= Constants::PAGE_LOGIN ?>">
                            <button id="btn-connect">
                                Se connecter pour emprunter
                            </button>
                        </a>
                        <?php
                    } else {
                        $cid = SessionManager::Instance()->getUserConsumer()->Id;
                        $isLoan = CartItem::isInConsumerShoppingCart($cb->Id, $cid) ? "0" : "1";
                        ?>
                        <div id="loan-container" data-is-loan="<?= $isLoan ?>" data-book-id="<?= $cb->Id ?>">
                            <p id="btn-state"></p>
                            <button id="btn-loan">
                                Ajouter au panier
                            </button>
                            <button id="btn-unloan">
                                Retirer du panier
                            </button>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>