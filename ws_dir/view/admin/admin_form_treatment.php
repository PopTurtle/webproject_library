<?php

use App\Constants;
use App\Controller\AdminFormTreatmentController;
use App\Controller\Misc\FormMaker;
use App\Controller\SessionManager;
use App\Model\Database;
use App\Model\DBObjects\Book;
use App\Partials\NavBar;
use App\Utils\Utils;

require_once "../../autoloader.php";

SessionManager::Instance()->adminPage();
$aftc = new AdminFormTreatmentController;

if (!$aftc->wasFormTreated()) {
    Utils::redirectTo(Constants::PAGE_ADMIN_MAIN);
}

switch ($aftc->getFormTreatmentResult()) {
    case AdminFormTreatmentController::TREAT_COMPLETE:
        break;
    case AdminFormTreatmentController::TREAT_INCORRECT_DATA:
        $args = [FormMaker::FIELD_ERROR_GET => $aftc->getFieldError()];
        $data = $aftc->getDataSet();
        foreach ($aftc->previousFormArgGenerator()() as $arg) {
            $args[$arg] = $data[$arg];
        }
        Utils::redirectTo($aftc->previousFormURL(), $args);
        break;
    case AdminFormTreatmentController::TREAT_DB_ERROR:
        Utils::showErrorCode(
            Database::ConnectionErrorCode,
            "Une erreur est survenue lors de l'appel à la base de donnée"
        );
    default:
        Utils::redirectTo(Constants::PAGE_ADMIN_MAIN);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Traitement de formulaires admins</title>
    <link rel="stylesheet" href=<?= Constants::STYLE_GLOBAL ?>>
    <?php NavBar::putHeader(); ?>
</head>
<body>
    <?php NavBar::put(); ?>
    <main>
        <section class="basic">
            <h1>Le formulaire a été traité correctement</h1>
            <a class="button" href="<?= Constants::PAGE_ADMIN_MAIN ?>">
                Retourner au menu
            </a>
        </section>
    </main>
</body>
</html>