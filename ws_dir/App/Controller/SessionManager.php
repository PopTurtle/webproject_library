<?php

namespace App\Controller;

use App\Model\DBObjects\Consumer;
use App\Utils\Singleton;
use App\Utils\Utils;


/**
 *  Gère la session courante.
 *  - Un utilisateur peut se connecter, et rester connecter via la session.
 */
class SessionManager extends Singleton {
    public const USERCONNECT_FAILED_DB = -1;
    public const USERCONNECT_FAILED_MAIL = -2;
    public const USERCONNECT_FAILED_PASS = -3;

    /**  Utilisateur courant */
    private bool $isUserConnected;
    private ?Consumer $currentUser;

    public const SESS_USER_ID = "user_id";

    protected function __construct()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->isUserConnected = false;
        $this->currentUser = null;
        if (isset($_SESSION[self::SESS_USER_ID])) {
            $this->tryConnectUserNoPass($_SESSION[self::SESS_USER_ID]);
        }
    }

    public static function ensureConnectionAttempt() {
        self::Instance();
    }

    public function isUserConnected(): bool {
        return $this->isUserConnected;
    }

    public function getUserConsumer(): ?Consumer {
        return $this->currentUser;
    }

    /**
     *  Essaie de connecter un utilisateur, via son mail et son mot de passe.
     *  Renvoie 0 en cas de succès, sinon une valeur parmis USERCONNECT_FAILED_*
     */
    public function tryConnectUser(string $mail, string $password) : int {
        $c = Consumer::getConsumerByMail($mail);
        if ($c == null) {
            return self::USERCONNECT_FAILED_MAIL;
        }
        $ph = Utils::generatePasswordHash($password);
        if (Utils::testPassword($c->Password, $ph) != 0) {
            return self::USERCONNECT_FAILED_PASS;
        }
        $this->currentUser = $c;
        $this->isUserConnected = true;
        $_SESSION[self::SESS_USER_ID] = intval($c->Id);
        return 0;
    }

    /**
     *  Essaie de connecter un utilisateur si il s'est déjà connecter
     *    auparavant, en utilisant l'ID stocké dans la session.
     *  @pre isset($_SESSION[self::SESS_USER_ID])
     */
    private function tryConnectUserNoPass(int $id) : int {
        $c = Consumer::getConsumerByID($id);
        if ($c === false || $c == null) {
            return self::USERCONNECT_FAILED_DB;
        }
        $this->currentUser = $c;
        $this->isUserConnected = true;
        return 0;
    }
}
