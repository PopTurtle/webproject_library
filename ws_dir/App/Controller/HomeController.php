<?php

namespace App\Controller;

use App\Constants;
use App\Utils\Utils;

class HomeController {
    public function __construct() {
        $sm = SessionManager::Instance();
        $sm->logOutAdmin();
        if (isset($_GET["logout"])) {
            $sm->logOutUser();
            Utils::redirectTo(Constants::PAGE_HOME);
        }
    }

    /**  Lien vers lequel redirige la bar de recherche */
    public function searchBarAction() {
        return Constants::PAGE_BOOKSEARCH;
    }

    /**  Lien vers tous les livres */
    public function everyBookLink() {
        return Constants::PAGE_BOOKSEARCH;
    }
}
