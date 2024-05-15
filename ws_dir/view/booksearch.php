<?php

use App\Constants;
use App\Controller\BookSearchController;
use App\Controller\SessionManager;
use App\Partials\NavBar;
use App\Partials\SearchBar;
use App\Utils\Utils;

require_once "../autoloader.php";

$bc = new BookSearchController();
$res = $bc->fetchSearchResult();
$loans = $bc->getBookIdsInLoan();
$cartitems = $bc->getBookIdsInCart();
$bcount = count($res);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_BOOKSEARCH ?>>
    <script src="<?= Constants::SCRIPT_BOOKSEARCH ?>" type="module"></script>
    <?php NavBar::putHeader(); ?>
    <?php SearchBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>

    <main>
        <section class="search-container">
            <div class="search-bar-container">
                <?php SearchBar::put(["search_data" => $bc->getSearchStr()]); ?>
            </div>
            <a href="<?= $bc->everyBookLink() ?>" class="button btn-color-1">Voir tous les livres</a>
        </section>
        <section class="search-result">
            <p class="result-count">
                <?= Utils::plural("$bcount résultat", $bcount); ?>
            </p>
            <div class="result-box">
                <?php
                foreach ($res as $book) {
                    ?>
                    <div class="result-book">
                        <a href="<?= Constants::PAGE_BOOK . '?book_id=' . $book->Id ?>">
                            <div class="book-info">
                                <div class="book-cover">
                                    <img src="<?= $book->getCoverPath() ?>" alt="Couverture">
                                </div>
                                <p class="book-title">
                                    <?= $book->Title ?>
                                </p>
                                <p class="book-stock">
                                    <?=  Utils::plural($book->Stock . " exemplaires restant", $book->Stock); ?>
                                </p>
                            </div>
                        </a>
                        <?php
                        $inCart = in_array($book->Id, $cartitems) ? 1 : 0;
                        ?>
                        <div class="btn-container" data-book-id=<?= $book->Id ?> data-is-in-cart=<?= $inCart ?>>
                            <?php
                            $inLoan = in_array($book->Id, $loans);
                            $inStock = $book->Stock > 0;
                            $disabled = $inLoan || !$inStock;

                            if ($disabled) {
                                ?>
                                <button class="book-result-button" disabled>
                                    <?= $inLoan ? "Déjà emprunter" : "Indisponible" ?>
                                </button>
                                <?php
                            } else if (!SessionManager::Instance()->isUserConnected()) {
                                ?>
                                <a href="<?= Constants::PAGE_LOGIN ?>" class="book-result-button">
                                    Emprunter    
                                </a>
                                <?php
                            } else {
                                ?>
                                <button class="btn-loan book-result-button">
                                    Ajouter au panier
                                </button>
                                <button class="btn-unloan book-result-button">
                                    Retirer du panier
                                </button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>
    </main>

</body>
</html>