<?php

namespace App\Controller;

use App\Constants;
use App\Controller\Misc\FormMaker;
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

    /**  Renvoie l'utilisateur actuellement connecté */
    public function currentConsumer() {
        return $this->consumer;
    }

    /**  URL vers les livres (pour emprunt) */
    public function loanBookURL() : string {
        return Constants::PAGE_BOOKSEARCH;
    }
    
    /**  URL vers le renouvellement d'emprunts */
    public function renewLoanURL() : string {
        return Constants::PAGE_RENEWBOOK;
    }

    /**  URL vers l'annulation d'emprunt (rendu des livres) */
    public function returnBookURL() : string {
        return Constants::PAGE_RETURNBOOK;
    }

    /**  Tente de connecter l'utilisateur avec les données fournies */
    private function tryConnectUser(string $mail, string $password) {
        $res = $this->sm->tryConnectUser($mail, $password);
        if ($res != 0) {
            $redirectUrl = Constants::PAGE_LOGIN;
            $args = [];
            switch ($res) {
                case SessionManager::USERCONNECT_FAILED_MAIL:
                    $args[FormMaker::FIELD_ERROR_GET] = "mail";
                    break;
                case SessionManager::USERCONNECT_FAILED_PASS:
                    $args[FormMaker::FIELD_ERROR_GET] = "password";
                    $args["mail"] = $mail;
                    break;
                default:
                    break;
            }
            Utils::redirectTo($redirectUrl, $args);
        }
    }
}
