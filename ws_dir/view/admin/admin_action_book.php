<?php

use App\Constants;
use App\Controller\AdminActionBookController;
use App\Controller\Misc\FormMaker;
use App\Controller\SessionManager;
use App\Partials\NavBar;

require_once "../../autoloader.php";

SessionManager::Instance()->adminPage();
$fm = FormMaker::Instance();
$aabc = new AdminActionBookController;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actions sur les livres</title>
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
                <h1>Actions sur les livres</h1>
                <p>Les champs sont optionnels, n'en saisir qu'un seul suffit.</p>
                <form method="get" action="<?= Constants::PAGE_ADMIN_ACTION_BOOK ?>" class="simple-form">
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
            if ($aabc->hasFormResult()) {
                $b = $aabc->getSearchResult();
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
                            <div id="del-btn-secondary-content">
                                <form method="get" action="<?= Constants::PAGE_ADMIN_UPDATE_BOOK?>">
                                    <?php
                                    foreach ($b->generatePrefilledInputs() as $k => $v) {
                                        ?>
                                        <input type="hidden" name="<?= $k ?>" value="<?= $v ?>">
                                        <?php
                                    }
                                    ?>
                                    <input type="submit" value="Modifier le livre">
                                </form>
                            </div>
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