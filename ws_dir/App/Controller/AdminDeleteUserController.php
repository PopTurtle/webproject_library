<?php

namespace App\Controller;

use App\Model\Database;
use App\Model\DBObjects\Consumer;
use App\Utils\Utils;

class AdminDeleteUserController {
    
    private bool $hasFormResult;
    private ?Consumer $searchResult;

    public function __construct()
    {
        $valid = function (string $k) {
            return isset($_GET[$k]) && strcmp($_GET[$k], "") !== 0;
        };

        $this->searchResult = null;
        $this->hasFormResult = isset($_GET["consumer_id"]) || isset($_GET["consumer_mail"]);
        if ($valid("consumer_id") && Utils::isInt($_GET["consumer_id"])) {
            $this->fetchConsumerId($_GET["consumer_id"]);
        } else if ($valid("consumer_mail")) {
            $this->fetchConsumerMail($_GET["consumer_mail"]);
        }
    }
    
    /**  Renvoie si des données de recherche sont disponibles */
    public function hasFormResult() : bool {
        return $this->hasFormResult;
    }

    /**
     *  Renvoie l'utilisateur trouvé si des données de recherches sont
     *    disponibles
     */
    public function getSearchResult() : ?Consumer {
        return $this->searchResult;
    }

    /**  Tente de trouver un utilisateur via son identifiant */
    private function fetchConsumerId(int $consumer_id) {
        $r = Consumer::getConsumerByID($consumer_id);
        if ($r === false) {
            self::fetchError();
        }
        $this->searchResult = $r;
    }

    /**  Tente de trouver un utilisateur via son email */
    private function fetchConsumerMail(string $mail) {
        $r = Consumer::getConsumerByMail($mail);
        if ($r === false) {
            self::fetchError();
        }
        $this->searchResult = $r;
    }

    /**
     *  Renvoie la page d'erreur avec un message d'erreur lié à la recherche
     */
    private function fetchError() {
        Utils::showErrorCode(
            Database::ConnectionErrorCode,
            "Erreur lors de la recherche"
        );
    }
}