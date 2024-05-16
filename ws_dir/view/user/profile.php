<?php

require_once "../../autoloader.php";

use App\Constants;
use App\Controller\ProfileController;
use App\Partials\NavBar;
use App\Utils\Utils;

$pc = new ProfileController();
$cc = $pc->currentConsumer();
$cl = $pc->currentLoans();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_PROFILE ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(["btn_mode" => Navbar::BTN_PROFILE]); ?>
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
                    <div class="profile-loans">
                        <?php
                        if (count($cl) === 0) {
                            ?>
                            <p>Vous n'avez aucun emprunt en cours</p>
                            <?php
                        }
                        foreach ($cl as $fl) {
                            $b = $fl->book();
                            $l = $fl->loan();
                            ?>
                            <div class="loan-container">
                                <div class="cover">
                                    <img src="<?= $b->getCoverPath() ?>" alt="">
                                </div>
                                <p class="book-title"><?= $b->Title ?></p>
                                <p class="loan-end-date">Se termine le <?= Utils::formatDate($l->DateEnd) ?></p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>