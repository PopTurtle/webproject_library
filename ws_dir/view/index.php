<?php

use App\Constants;
use App\Controller\SessionManager;
use App\Partials\Navbar;
use App\Partials\SearchBar;

require_once "../autoloader.php";

SessionManager::EnsureConnectionAttempt();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_INDEX ?>>
    <?php Navbar::putStyle(); ?>
    <?php SearchBar::putStyle(); ?>
</head>
<body>
    <?php Navbar::put(["btn_mode" => Navbar::BTN_USER]); ?>

    <main>
        <section class="main-search">
            <h2 class="category-title">Bienvenue sur votre espace d'emprunt !</h2>
            <?php SearchBar::put(""); ?>
        </section>
        
        <section class="main-news">
            <h2 class="category-title">Les nouveautés</h2>
        </section>
    </main>

    <div style="height: 200vh">
        SCROLL
    </div>

</body>
</html>