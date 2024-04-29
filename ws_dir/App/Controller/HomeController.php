<?php

namespace App\Controller;

use App\Constants;
use App\Utils\Utils;

class HomeController {
    public function __construct() {
        if (isset($_GET["logout"])) {
            SessionManager::Instance()->logOutUser();
            Utils::redirectTo(Constants::PAGE_HOME);
        }
    }

    public function searchBarAction() {
        return Constants::PAGE_BOOKSEARCH;
    }

    public function everyBookLink() {
        return Constants::PAGE_BOOKSEARCH;
    }
}
