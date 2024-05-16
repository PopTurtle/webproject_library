<?php

use App\Constants;
use App\Controller\AdminMainController;
use App\Partials\NavBar;

require_once "../../autoloader.php";

$amc = new AdminMainController;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administrateur</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_ADMIN_MAIN ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(["btn_mode" => Navbar::BTN_HOME_ADMIN]); ?>
    <main>
        <section class="admin">
            <span class="title">
                <a href="<?= Constants::PAGE_HOME ?>">
                    <img src="/App/Assets/Images/deconnect.png" alt="Icone déconnexion">
                </a>
                <h1>Menu administrateur</h1>
            </span>

            <div class="content">
                <div class="book">
                    <h2>Livre</h2>
                    <div class="link">
                        <img src="/App/Assets/Images/add.png" alt="Icone ajouter">
                        <a href="<?= Constants::PAGE_ADMIN_ADDBOOK ?>">Ajouter</a>
                    </div>
                    <div class="link">
                        <img src="/App/Assets/Images/edit.png" alt="Icone modifier">
                        <a href="<?= Constants::PAGE_ADMIN_ACTION_BOOK ?>">Modifier</a>
                    </div>
                </div>
                <div class="user">
                    <h2>Utilisateur</h2>
                    <div class="link">
                        <img src="/App/Assets/Images/add.png" alt="Icone ajouter">
                        <a href="<?= Constants::PAGE_ADMIN_ADDUSER ?>">Ajouter</a>
                    </div>
                    <div class="link">
                        <img src="/App/Assets/Images/remove.png" alt="Icone supprimer">
                        <a href="<?= Constants::PAGE_ADMIN_DELETE_USER ?>">Supprimer</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>