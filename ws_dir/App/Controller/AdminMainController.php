<?php

namespace App\Controller;

use App\Constants;
use App\Controller\Misc\FormMaker;
use App\Utils\Utils;

class AdminMainController {
    public function __construct()
    {
        if (isset($_POST["password"])) {
            $this->tryConnect($_POST["password"]);
        }
        SessionManager::Instance()->adminPage();
    }

    private function tryConnect(string $password) {
        $r = SessionManager::Instance()->tryConnectAdmin($password);
        if ($r != 0) {
            $args = [FormMaker::FIELD_ERROR_GET => "password"];
            Utils::redirectTo(Constants::PAGE_ADMIN_LOGIN, $args);
        }
    }
}
