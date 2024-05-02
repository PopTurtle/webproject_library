<?php

use App\Constants;
use App\Controller\AdminFormTreatmentController;
use App\Controller\SessionManager;
use App\Partials\NavBar;

require_once "../../autoloader.php";

SessionManager::Instance()->adminPage();

$aftc = new AdminFormTreatmentController;
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
        <p>Résultat: <?= $aftc->getFormTreatmentResult() ?></p>
    </main>
</body>
</html>