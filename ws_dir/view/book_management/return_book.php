<?php

use App\Constants;
use App\Controller\ReturnBookController;
use App\Model\Database;
use App\Partials\NavBar;
use App\Utils\Utils;

require_once "../../autoloader.php";

$rbc = new ReturnBookController;
$allLoans = $rbc->getAllLoans();
if ($allLoans === false) {
    Utils::showErrorCode(
        Database::ConnectionErrorCode,
        "Impossible de récupèrer les données"
    );
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>rendre liver</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <?php
        if (count($allLoans) === 0) {
            ?>
            <p>Vous n'avez aucun emprunt en cours</p>
            <?php
        }
        foreach ($allLoans as $bl) {
            ?>
            <div>
                <?php var_dump($bl); ?>
                <button>
                    Rendre le livre
                </button>
            </div>
            <?php
        }
        ?>
    </main>
</body>
</html>