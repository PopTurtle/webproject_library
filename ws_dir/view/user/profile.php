<?php

require_once "../../autoloader.php";

use App\Constants;
use App\Controller\ProfileController;
use App\Model\DBObjects\CartItem;
use App\Partials\NavBar;

$pc = new ProfileController();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
    </main>
</body>
</html>