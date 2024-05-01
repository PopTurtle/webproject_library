<?php

namespace App\Controller;

use App\Constants;
use App\Controller\SessionManager;
use App\Model\DBObjects\Consumer;
use App\Model\FullBookloan;
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

    /**
     *  Peut renvoyer false === erreur lors de la requete
     */
    public function currentLoans() {
        if (is_null($this->currentLoans)) {
            $this->currentLoans = FullBookloan::getFullBookLoansFromConsumer($this->consumer->Id);
        }
        return $this->currentLoans;
    }

    public function currentConsumer() {
        return $this->consumer;
    }

    public function loanBookURL() : string {
        return Constants::PAGE_BOOKSEARCH;
    }
    
    public function renewLoanURL() : string {
        return "";
    }

    public function returnBookURL() : string {
        return Constants::PAGE_RETURNBOOK;
    }

    private function tryConnectUser(string $mail, string $password) {
        $res = $this->sm->tryConnectUser($mail, $password);
        if ($res != 0) {
            $redirectUrl = Constants::PAGE_LOGIN;
            $args = [];
            switch ($res) {
                case SessionManager::USERCONNECT_FAILED_MAIL:
                    $args["error"] = "mail";
                    break;
                case SessionManager::USERCONNECT_FAILED_PASS:
                    $args["error"] = "password";
                    $args["mail"] = $mail;
                    break;
                default:
                    break;
            }
            Utils::redirectTo($redirectUrl, $args);
        }
    }
}
