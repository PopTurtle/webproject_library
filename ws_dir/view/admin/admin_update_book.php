<?php

use App\Constants;
use App\Controller\AdminDeleteBookController;
use App\Controller\Misc\FormMaker;
use App\Controller\SessionManager;
use App\Partials\NavBar;

require_once "../../autoloader.php";

SessionManager::Instance()->adminPage();
$fm = FormMaker::Instance();
$adbc = new AdminDeleteBookController;
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
                <h1>Supprimer un livre</h1>
                <p>Les champs sont optionnels, n'en saisir qu'un seul suffit.</p>
                <form method="get" action="<?= Constants::PAGE_ADMIN_DELETE_BOOK ?>" class="simple-form">
                    <div>
                        <?php $i = $fm->generateInputInfo("book_id"); ?>
                        <label for="<?= $i["label_for"] ?>">Identifiant du livre</label>
                        <input
                            type="number"
                            value="<?= $i["prev"] ?? "" ?>"
                            name="<?= $i["input_name"] ?>"
                            id="<?= $i["input_id"] ?>"
                            class="<?= $i["input_classes"] ?>"
                            >
                    </div>
                    <div>
                        <?php $i = $fm->generateInputInfo("book_title"); ?>
                        <label for="<?= $i["label_for"] ?>">Titre</label>
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
            if ($adbc->hasFormResult()) {
                $b = $adbc->getSearchResult();
                ?>

                <section class="search-result-section">
                <?php
                if ($b === null) {
                    ?>
                    <p>Aucun résultat pour cette recherche</p>
                    <?php
                } else {
                    ?>
                    <div class="result-container">
                        <h1><?= $b->Title ?></h1>
                        <p><?= $b->Author ?> - <?= $b->PublicationYear ?></p>
                        <p>Identifiant: <?= $b->Id ?></p>
                        <div class="del-btn-container">
                            <button id="del-btn" data-book-id=<?= $b->Id ?>>Supprimer le livre</button>
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