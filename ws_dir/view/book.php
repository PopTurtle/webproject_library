<?php

use App\Constants;
use App\Controller\BookController;
use App\Partials\NavBar;

require_once "../autoloader.php";

$bc = new BookController;
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
</head>
<body>
    <?php NavBar::put(); ?>

    <main>
        <h1><?= $bc->getCurrentBook()->Title ?></h1>

        <a href="">Emprunter</a>
    </main>

</body>
</html>