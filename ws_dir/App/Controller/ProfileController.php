<?php

namespace App\Controller;

use App\Constants;
use App\Controller\SessionManager;
use App\Model\DBObjects\Bookloan;
use App\Model\DBObjects\CartItem;
use App\Model\DBObjects\Consumer;
use App\Utils\Utils;

class ProfileController {
    private SessionManager $sm;
    private Consumer $consumer;

    private $currentLoans;

    public function __construct() {
        $this->sm = SessionManager::Instance();
        if (isset($_POST["mail"]) && isset($_POST["password"])) {
            $this->tryConnectUser($_POST["mail"], $_POST["password"]);
        }
        if (!$this->sm->isUserConnected()) {
            Utils::redirectTo(Constants::PAGE_LOGIN);
        }
        $this->consumer = $this->sm->getUserConsumer();
    }

    public function currentLoans() {
        if (is_null($this->currentLoans)) {
            $this->currentLoans = Bookloan::getAllCurrentLoans($this->consumer->Id);
        }
        return $this->currentLoans;
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
                default:
                    break;
            }
        }
    }
}
