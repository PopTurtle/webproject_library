<?php

use App\Constants;
use App\Controller\RenewBookController;
use App\Model\Database;
use App\Partials\NavBar;
use App\Utils\Utils;

require_once "../../autoloader.php";

$rbc = new RenewBookController;
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
    <script src="<?= Constants::SCRIPT_BOOKLOAN_RENEW ?>" type="module"></script>
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
            $book = $bl->book();
            $loan = $bl->loan();
            ?>
            <div>
                <p class="renew-date-end">Date fin: <?= $loan->DateEnd ?></p>
                <?php var_dump($bl); ?>
                <button data-book-id="<?= $book->Id ?>" class="renew-book">
                    Renouveler l'emprunt
                </button>
            </div>
            <?php
        }
        ?>
    </main>
</body>
</html>