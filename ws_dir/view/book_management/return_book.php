<?php

use App\Constants;
use App\Controller\ReturnBookController;
use App\Model\Database;
use App\Partials\GridDisplayer;
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
    <title>Rendre un livre</title>
    <script src="<?= Constants::SCRIPT_BOOKLOAN_RETURN ?>" type="module"></script>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <link rel="stylesheet" href=<?= Constants::STYLE_DISPLAY_BOOK ?>>
    <?php NavBar::putHeader(); ?>
    <?php GridDisplayer::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="display-book">
            <h1>Rendu des livres</h1>
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
                    <p>Le prêt se termine le: <?= Utils::formatDate($loan->DateEnd) ?></p>
                    <div class="action-button-container">
                        <button data-book-id="<?= $book->Id ?>" class="return-book">
                            Rendre le livre
                        </button>
                    </div>
                </div>
                <?php
            }
            GridDisplayer::putEnd();
            ?>
        </section>

        
    </main>
</body>
</html>