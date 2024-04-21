<?php

use App\Constants;
use App\Controller\BookSearchController;
use App\Model\Database;
use App\Partials\NavBar;
use App\Partials\SearchBar;

require_once "../autoloader.php";

//Database::ensureConnection();

$bc = new BookSearchController();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_INDEX ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_BOOKSEARCH ?>>
    <?php NavBar::putHeader(); ?>
    <?php SearchBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>

    <main>

        <section class="search-result">
            <?php $res = $bc->getSearchResult(); ?>
            <?php $c = count($res); ?>
            <p class="result-count"><?= $c ?> résultat<?= $c > 1 ? "s" : "" ?></p>
            <div class="result-box">
                <?php foreach ($res as $book) {
                    ?>
                    <div class="result-book">
                        <div class="result-cover">
                            <img alt="Text">
                        </div>
                        <p class="result-title">
                            <?= $book->Title ?>
                        </p>
                        <p class="result-stock">
                            <?= $book->Stock ?> exemplaires restant<?= $book->Stock > 1 ? "s" : "" ?>
                        </p>
                        <div class="result-loan-btn">
                            <p>Emprunter</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

</body>
</html>