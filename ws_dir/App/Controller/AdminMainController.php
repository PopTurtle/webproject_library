<?php

namespace App\Controller;

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
        
        echo $r;
    }
}
