<?php

use App\Constants;
use App\Controller\SessionManager;
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
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php //NavBar::put(); ?>
    <main>
    
        <input type="text" placeholder="Id" id="book-id">
        <input type="text" placeholder="Titre" id="book-title">

        <button>Rerchecher</button>

        
    </main>
</body>
</html>