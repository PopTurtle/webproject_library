<?php

require_once "../../autoloader.php";

use App\Constants;
use App\Controller\Misc\FormMaker;
use App\Partials\NavBar;

$fm = FormMaker::Instance();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion administrateur</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_FORM ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>

    <main>
        <section class="form-container">
            <h1>Devenir administrateur</h1>
            <form method="post" action="<?= Constants::PAGE_ADMIN_MAIN ?>" class="simple-form">
                <div class="login-text-input">
                    <?php $i = $fm->generateInputInfo("password"); ?>
                    <label for="<?= $i["label_for"] ?>">Mot de passe</label>
                    <input
                        type="password"
                        value="<?= $i["prev"] ?? "" ?>"
                        name="<?= $i["input_name"] ?>"
                        id="<?= $i["input_id"] ?>"
                        class="<?= $i["input_classes"] ?>"
                        >
                        <?php
                        if ($i["is_error"]) {
                            ?>
                            <p class="error-msg">Le mot de passe n'est pas valide.</p>
                            <?php
                        }
                        ?>
                </div>
                <div>
                    <input type="submit" value="Connexion">
                </div>
            </form>
        </section>
    </main>

</body>
</html>