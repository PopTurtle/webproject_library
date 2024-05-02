<?php

use App\Constants;
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
            <h1>Ajouter un livre</h1>
            <form action="" class="simple-form">
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
                    </div>
                    <?php
                }
                ?>
                <div>
                    <input type="submit" value="Ajouter un livre">
                </div>
            </form>
        </section>
    </main>
</body>
</html>