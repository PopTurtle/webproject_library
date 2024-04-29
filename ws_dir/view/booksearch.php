<?php

use App\Constants;
use App\Controller\BookSearchController;
use App\Partials\NavBar;
use App\Partials\SearchBar;
use App\Utils\Utils;

require_once "../autoloader.php";

$bc = new BookSearchController();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_BOOKSEARCH ?>>
    <?php NavBar::putHeader(); ?>
    <?php SearchBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>

    <main>
        <section class="search-container">
            <div class="search-bar-container">
                <?php SearchBar::put() ?>
            </div>
            <a href="<?= $bc->everyBookLink() ?>" class="button btn-color-1">Voir tous les livres</a>
        </section>
        <section class="search-result">
            <?php
            $res = $bc->getSearchResult();
            $bcount = count($res);
            ?>
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
                                    <img src="https://placehold.co/400x600" alt="Text">
                                </div>
                                <p class="book-title">
                                    <?= $book->Title ?>
                                </p>
                                <p class="book-stock">
                                    <?=  Utils::plural($book->Stock . " exemplaires restant", $book->Stock); ?>
                                </p>
                            </div>
                        </a>
                        <button class="book-result-button">
                            Indisponible
                        </button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>
    </main>

</body>
</html>