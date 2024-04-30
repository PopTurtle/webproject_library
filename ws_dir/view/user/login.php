<?php

require_once "../../autoloader.php";

use App\Constants;
use App\Controller\LoginController;
use App\Partials\NavBar;

$lc = new LoginController;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_LOGIN ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>

    <main>
        <h2 class="category-title">Se connecter</h2>

        <form method="post" action="<?= Constants::PAGE_PROFILE ?>" class="connect-main">
            <?php $i = $lc->generateInputInfo("mail"); ?>
            <label for="<?= $i["label_for"] ?>">Mail</label>
            <input
                type="text"
                value="<?= $i["prev"] ?? "" ?>"
                name="<?= $i["input_name"] ?>"
                id="<?= $i["input_id"] ?>"
                class="<?= $i["input_classes"] ?>"
                >
            
            <?php $i = $lc->generateInputInfo("password"); ?>
            <label for="<?= $i["label_for"] ?>">Mot de passe</label>
            <input
                type="text"
                name="<?= $i["input_name"] ?>"
                id="<?= $i["input_id"] ?>"
                class="<?= $i["input_classes"] ?>"
                >
            
            <input type="submit" value="Connexion">
        </form>
    </main>

</body>
</html>