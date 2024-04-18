<?php

require_once "../autoloader.php";

use App\Constants;
use App\Partials\NavBar;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putNavbarStyle(); ?>
</head>
<body>
    <?php NavBar::putNavBar(NavBar::BTN_HOME); ?>

    <main>
        <h2 class="category-title">Se connecter</h2>

        <form method="post" action="<?= Constants::PAGE_PROFILE ?>" class="connect-main">
            <label for="mail">Mail</label>
            <input type="text" name="mail" id="mail">
            <label for="password">Mot de passe</label>
            <input type="text" name="password" id="password">
            <input type="submit" value="Connexion">
        </form>
    </main>

</body>
</html>