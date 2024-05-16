<?php

namespace App\Controller;

use App\Model\DBObjects\Consumer;
use App\Model\FullBookloan;

class RenewBookController {
    private Consumer $consumer;

    public function __construct()
    {
        $this->consumer = SessionManager::Instance()->getUserConsumer();
    }

    /**  Renvoie tous les emprunts de l'utilisateur courant */
    public function getAllLoans() {
        $id = $this->consumer->Id;
        return FullBookloan::getFullBookLoansFromConsumer($id);
    }
}
