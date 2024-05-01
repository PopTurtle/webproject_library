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
                    <a href="<?= $pc->loanBookURL() ?>" class="button btn-color-3">Emprunter un livre</a>
                    <a href="<?= $pc->renewLoanURL() ?>" class="button btn-color-3">Renouveler un emprunt</a>
                    <a href="<?= $pc->returnBookURL() ?>" class="button btn-color-3">Rendre un livre</a>
                </div>
                <div class="profile-loans-container">
                    <h2>Mes emprunts</h2>
                    <?php var_dump($cl); ?>
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
        </section>
    </main>
</body>
</html>