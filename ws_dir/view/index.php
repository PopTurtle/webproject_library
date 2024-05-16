<?php

use App\Constants;
use App\Controller\HomeController;
use App\Model\DBObjects\Book;
use App\Partials\NavBar;
use App\Partials\SearchBar;

require_once "../autoloader.php";

$hc = new HomeController;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque municipale</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_INDEX ?>>
    <?php NavBar::putHeader(); ?>
    <?php SearchBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(["btn_mode" => Navbar::BTN_HOME]); ?>
    <main>
        <section class="main-search">
            <h1>Bienvenue sur votre espace d'emprunt !</h2>
            <div class="search-bar-container">
                <?php SearchBar::put(["action_ref" => $hc->searchBarAction()]); ?>
            </div>
            <a href="<?= $hc->everyBookLink() ?>" class="button btn-color-1">Voir tous les livres</a>
        </section>
        
        <section class="main-news">
            <h1 class="category-title">Les nouveautés</h2>
            <div class="new-books">
                <?php
                $books = Book::getNewestBooks(5);
                if ($books === false) {
                    ?>
                    <p>Impossible de récupérer les nouveautés</p>
                    <?php
                } else {
                    foreach ($books as $b) {
                        ?>
                        <div><?php var_dump($b); ?></div>
                        <?php
                    }
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>