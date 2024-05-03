<?php

use App\Constants;
use App\Controller\RenewBookController;
use App\Model\Database;
use App\Partials\GridDisplayer;
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
    <link rel="stylesheet" href=<?= Constants::STYLE_RENEW_BOOK ?>>
    <?php NavBar::putHeader(); ?>
    <?php GridDisplayer::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="books-section">
            <?php
            if (count($allLoans) === 0) {
                ?>
                <p>Vous n'avez aucun emprunt en cours</p>
                <?php
            }
            GridDisplayer::putStart();
            foreach ($allLoans as $bl) {
                $book = $bl->book();
                $loan = $bl->loan();
                ?>
                <div class="book-container">
                    <h2><?= $book->Title ?></h2>
                    <p class="author"><?= $book->Author ?></p>
                    <p>Depuis le <span><?= Utils::formatDate($loan->DateStart) ?></span></p>
                    <p>
                        Termine le
                        <span class="loan-end-date">
                            <?= Utils::formatDate($loan->DateEnd) ?>
                        </span>
                    </p>
                    <button data-book-id="<?= $book->Id ?>" class="renew-book">
                        Renouveler l'emprunt
                    </button>
                </div>
                <?php
            }
            GridDisplayer::putEnd();
            ?>
        </section>
    </main>
</body>
</html>