<?php

use App\Constants;
use App\Controller\AdminFormTreatmentController;
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
    <title>Ajouter un livre</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_FORM ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="form-container">
            <h1>Ajouter un livre</h1>
            <form enctype="multipart/form-data" method="post" action="<?= Constants::PAGE_ADMIN_FORM_TREATMENT ?>" class="simple-form">
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
                <div>
                    <label for="cover">Couverture du livre (.jpg)</label>
                    <input
                        type="file"
                        name="<?= Book::FormCoverArg ?>"
                        id="cover"
                        >
                </div>
                <input
                    type="hidden"
                    name="<?= AdminFormTreatmentController::FORM_NAME_KEY ?>"
                    value="<?= AdminFormTreatmentController::FORM_ADD_BOOK ?>"
                    >
                <div>
                    <input type="submit" value="Ajouter un livre">
                </div>
            </form>
        </section>
    </main>
</body>
</html>