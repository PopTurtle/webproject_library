<?php

use App\Constants;
use App\Controller\AdminDeleteBookController;
use App\Controller\AdminFormTreatmentController;
use App\Controller\Misc\FormMaker;
use App\Controller\SessionManager;
use App\Model\DBObjects\Book;
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
                <form method="get" action="<?= Constants::PAGE_ADMIN_FORM_TREATMENT ?>" class="simple-form">
                    <?php
                    $c = 0;
                    foreach (Book::generateUpdateForm("") as $f) {
                        if ($c === 0) {
                            ?>
                            <input type="hidden" name="<?= $f["input_name"] ?>" value="<?= $f["prev"] ?>">
                            <?php
                        }
                        ?>
                        <div>
                            <label for="<?= $f["label_for"] ?>"><?= $f["label_content"] ?></label>
                            <input
                                type="<?= $f["input_type"] ?? "text" ?>"
                                value="<?= $f["prev"] ?? "" ?>"
                                name="<?= $f["input_name"] ?>"
                                id="<?= $f["input_id"] ?>"
                                class="<?= $f["input_classes"] ?>"
                                <?= $c++ === 0 ? "disabled" : "" ?>>
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
                        name="<?= AdminFormTreatmentController::FORM_NAME_KEY ?>"
                        value="<?= AdminFormTreatmentController::FORM_UPDATE_BOOK ?>"
                        >
                    <div>
                        <input type="submit" value="Modifier le livre">
                    </div>
                </form>
            </section>
    </main>
</body>
</html>