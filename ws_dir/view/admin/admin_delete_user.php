<?php

use App\Constants;
use App\Controller\AdminDeleteUserController;
use App\Controller\Misc\FormMaker;
use App\Controller\SessionManager;
use App\Partials\NavBar;

require_once "../../autoloader.php";

SessionManager::Instance()->adminPage();
$fm = FormMaker::Instance();
$aduc = new AdminDeleteUserController;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_FORM ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_ADMIN_DELETE ?>>
    <script src="<?= Constants::SCRIPT_ADMIN_DELETE ?>" type="module"></script>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="form-container">
                <h1>Supprimer un utilisateur</h1>
                <p>Les champs sont optionnels, n'en saisir qu'un seul suffit.</p>
                <form method="get" action="<?= Constants::PAGE_ADMIN_DELETE_USER ?>" class="simple-form">
                    <div>
                        <?php $i = $fm->generateInputInfo("consumer_id"); ?>
                        <label for="<?= $i["label_for"] ?>">Identifiant de l'utilisateur</label>
                        <input
                            type="number"
                            value="<?= $i["prev"] ?? "" ?>"
                            name="<?= $i["input_name"] ?>"
                            id="<?= $i["input_id"] ?>"
                            class="<?= $i["input_classes"] ?>"
                            >
                    </div>
                    <div>
                        <?php $i = $fm->generateInputInfo("consumer_mail"); ?>
                        <label for="<?= $i["label_for"] ?>">Mail de l'utilisateur</label>
                        <input
                            type="text"
                            value="<?= $i["prev"] ?? "" ?>"
                            name="<?= $i["input_name"] ?>"
                            id="<?= $i["input_id"] ?>"
                            class="<?= $i["input_classes"] ?>"
                            >
                    </div>
                    <div>
                        <input type="submit" value="Chercher">
                    </div>
                </form>
            </section>

            <?php
            if ($aduc->hasFormResult()) {
                $c = $aduc->getSearchResult();
                ?>

                <section class="search-result-section">
                <?php
                if ($c === null) {
                    ?>
                    <p>Aucun résultat pour cette recherche</p>
                    <?php
                } else {
                    ?>
                    <div class="result-container">
                        <h1><?= $c->Lastname ?> <?= $c->Firstname ?></h1>
                        <p><?= $c->Mail ?></p>
                        <p>Identifiant: <?= $c->Id ?></p>
                        <div class="del-btn-container">
                            <button id="del-btn" data-consumer-id=<?= $c->Id ?>>Supprimer l'utilisateur</button>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </section>

                <?php
            }
            ?>
    </main>
</body>
</html>