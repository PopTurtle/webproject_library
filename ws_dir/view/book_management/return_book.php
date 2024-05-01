<?php

use App\Constants;
use App\Controller\ReturnBookController;
use App\Partials\NavBar;

require_once "../../autoloader.php";

$rbc = new ReturnBookController;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>rendre liver</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <?php
        foreach ($rbc->getAllLoans() as $bl) {
            ?>
            <div>
                <?php var_dump($bl); ?>
            </div>
            <?php
        }
        ?>
    </main>
</body>
</html>