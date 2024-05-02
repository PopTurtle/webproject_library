<?php

require_once "../../autoloader.php";

use App\Constants;
use App\Controller\LoginController;
use App\Controller\Misc\FormMaker;
use App\Partials\NavBar;

$fm = FormMaker::Instance();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_LOGIN ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_FORM ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>

    <main>
        <section class="login-form">
            <h1>Se connecter</h1>
            <form method="post" action="<?= Constants::PAGE_PROFILE ?>" class="simple-form">
                <div>
                    <?php $i = $fm->generateInputInfo("mail"); ?>
                    <label for="<?= $i["label_for"] ?>">Mail</label>
                    <input
                        type="text"
                        value="<?= $i["prev"] ?? "" ?>"
                        name="<?= $i["input_name"] ?>"
                        id="<?= $i["input_id"] ?>"
                        class="<?= $i["input_classes"] ?>"
                        >
                </div>
                <div>
                    <?php $i = $fm->generateInputInfo("password"); ?>
                    <label for="<?= $i["label_for"] ?>">Mot de passe</label>
                    <input
                        type="password"
                        name="<?= $i["input_name"] ?>"
                        id="<?= $i["input_id"] ?>"
                        class="<?= $i["input_classes"] ?>"
                        >
                </div>
                <div>
                    <input type="submit" value="Connexion">
                </div>
            </form>


        </section>
    </main>

</body>
</html>