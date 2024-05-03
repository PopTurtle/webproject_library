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
    <title>bilbiloték</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <p>Page admin</p>
        <p>Retourner à l'accueil pour vous déconnecter de l'interface administrateur</p>
        <p>Ajouter livre</p>
        <a href="<?= Constants::PAGE_ADMIN_ADDBOOK ?>">Ajouter un livre</a>
        <p>Supprimer livre</p>
        <p>Mettre à jour livre</p>
        <p>Ajouter utilisateur</p>
        <a href="<?= Constants::PAGE_ADMIN_ADDUSER ?>">Ajouter un utilisateur</a>
        <p>Supprimer utilisateur</p>
    </main>
</body>
</html>