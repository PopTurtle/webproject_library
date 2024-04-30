<?php

require_once "../../autoloader.php";

use App\Constants;
use App\Controller\ProfileController;
use App\Partials\NavBar;

$pc = new ProfileController();
$cc = $pc->currentConsumer();
$cl = $pc->currentLoans();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_PROFILE ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="profile-section">
            <h1>Bienvenue sur votre profil, <?= $cc->Firstname ?> !</h1>
            <div class="profile-container">
                <div class="profile-actions">
                    <p><?= $cc->Firstname ?> <?= $cc->Lastname ?></p>
                    <a href="">Emprunter un livre</a>
                    <a href="">Renouveler un emprunt</a>
                    <a href="">Rendre un livre</a>
                </div>
                <div class="profile-loans-container">
                    <h2>Mes emprunts</h2>
                    <div class="profile-loans">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>

            <?php var_dump($pc->currentLoans()); ?>
        </section>
    </main>
</body>
</html>