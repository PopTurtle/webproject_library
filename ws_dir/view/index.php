<?php

require_once "../autoloader.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>bilbiloték</title>
</head>
<body>
    <nav>
        <!-- Php partial ? -->
    </nav>

    <main>
        <section class="main-search">
            <h2>Bienvenue sur votre espace d'emprunt !</h2>
            <div class="search-bar">
                <form method="get" action="">
                    <input type="text" name="search-data" placeholder="Rechercher un livre">
                    <!-- Liste : par titre ; par auteur ; par année... -->
                    <input type="submit" value="Rechercher">
                </form>
            </div>
        </section>
        <section class="main-news">
            <h2>Les nouveautés</h2>
        </section>
    </main>

</body>
</html>