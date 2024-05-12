<?php

use App\Constants;
use App\Controller\AdminDeleteBookController;
use App\Controller\Misc\FormMaker;
use App\Controller\SessionManager;
use App\Partials\NavBar;

require_once "../../autoloader.php";

SessionManager::Instance()->adminPage();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_FORM ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="form-container">
                <h1>Modifier un livre</h1>
                <form method="get" action="<?= "" ?>" class="simple-form">
                    <?php
                    foreach (Book::generateAddForm("") as $f) {
                        ?>
                        <div>
                            <label for="<?= $f["label_for"] ?>"><?= $f["label_content"] ?></label>
                            <input
                                type="<?= $f["input_type"] ?? "text" ?>"
                                value="<?= $f["prev"] ?? "" ?>"
                                name="<?= $f["input_name"] ?>"
                                id="<?= $f["input_id"] ?>"
                                class="<?= $f["input_classes"] ?>"
                                >
                            <?php
                            if ($f["is_error"]) {
                                ?>
                                <p class="error-msg">Le champ ci-dessus n'est pas valide.</p>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <input
                        type="hidden"
                        name="<?= AdminFormTreatmentController::FORM_NAME_GET ?>"
                        value="<?= AdminFormTreatmentController::FORM_ADD_BOOK ?>"
                        >
                    <div>
                        <input type="submit" value="Ajouter un livre">
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