<?php

use App\Constants;
use App\Controller\BookController;
use App\Partials\NavBar;

require_once "../autoloader.php";

$bc = new BookController;
$cb = $bc->getCurrentBook();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_BOOKSEARCH ?>>
    <?php $bc->putHeader(); ?>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>

    <main>
        <section class="book-infos">
            <h1><?= $cb->Title ?></h1>
            <p><?= $cb->Author ?></p>
            <p><?= $cb->Editor ?></p>
        </section>    
        

        <button id="loan-btn">
            Emprunter
        </button>
    </main>

</body>
</html>