<?php

use App\Constants;
use App\Controller\BookSearchController;
use App\Partials\Navbar;
use App\Partials\SearchBar;

require_once "../autoloader.php";

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
    <?php Navbar::putHeader(); ?>
    <?php SearchBar::putHeader(); ?>
</head>
<body>
    <?php Navbar::put(); ?>

    <main>

        <section class="search-result">
            <?php $res = $bc->getSearchResult(); ?>    
            <p class="result-count"><?= count($res) ?> résultats</p>
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
                            <?= $book->Stock ?> exemplaires restants 
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