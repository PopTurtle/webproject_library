<?php

namespace App\Controller;

use App\Constants;
use App\Controller\SessionManager;
use App\Model\DBObjects\CartItem;
use App\Model\DBObjects\Consumer;
use App\Utils\Utils;

class ProfileController {
    private SessionManager $sm;
    private Consumer $consumer;

    public function __construct() {
        if (isset($_POST["mail"]) && isset($_POST["password"])) {
            $this->tryConnectUser($_POST["mail"], $_POST["password"]);
        }
        $this->sm = SessionManager::Instance();
        if (!$this->sm->isUserConnected()) {
            Utils::redirectTo(Constants::PAGE_LOGIN);
        }
        $this->consumer = $this->sm->getUserConsumer();
    }

    private function tryConnectUser(string $mail, string $password) {
        $res = $this->sm->tryConnectUser($mail, $password);
        if ($res != 0) {
            switch ($res) {
                case SessionManager::USERCONNECT_FAILED_MAIL:
                    echo "MAIL INVALIDE" . PHP_EOL;
                    break;
                case SessionManager::USERCONNECT_FAILED_PASS:
                    echo "PASS INVALIDE" . PHP_EOL;
                    break;
            }
        }
    }
}
