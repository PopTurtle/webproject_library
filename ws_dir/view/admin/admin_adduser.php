<?php

use App\Constants;
use App\Controller\AdminFormTreatmentController;
use App\Controller\SessionManager;
use App\Model\DBObjects\Book;
use App\Model\DBObjects\Consumer;
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
            <h1>Ajouter un utilisateur</h1>
            <form action="<?= Constants::PAGE_ADMIN_FORM_TREATMENT ?>" class="simple-form">
                <?php
                foreach (Consumer::generateAddForm("") as $f) {
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
                    </div>
                    <?php
                }
                ?>
                <input
                    type="hidden"
                    name="<?= AdminFormTreatmentController::FORM_NAME_GET ?>"
                    value="<?= AdminFormTreatmentController::FORM_ADD_USER ?>"
                    >
                <div>
                    <input type="submit" value="Ajouter un utilisateur">
                </div>
            </form>
        </section>
    </main>
</body>
</html>