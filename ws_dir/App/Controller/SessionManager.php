<?php

namespace App\Controller;

use App\Constants;
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
    public const ADMINCONNECT_FAILED_PASS = -1;

    private const NOT_CONNECTED_USER_ID = -1;
    private const ADMIN_ID = 1;

    private const ADMIN_PASS = "\$2y\$10\$yJa8vfPL43s7Qsqa6Gi5SuRyVwMXGlrd6Xnvo84u7WnXwg.CSGupm";

    /**  Utilisateur courant */
    private bool $isUserConnected;
    private ?Consumer $currentUser;

    public const SESS_USER_ID = "user_id";
    public const SESS_ADMIN_ID = "admin_id";

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

    /**  S'assure qu'une tentative de connexion est effectuée */
    public static function ensureUserConnectionAttempt() {
        self::Instance();
    }

    /**  Renvoie si l'utilisateur est connecté */
    public function isUserConnected() : bool {
        return $this->isUserConnected;
    }

    /**  Renvoie si l'utilisateur est admin */
    public function isUserAdmin() : bool {
        return isset($_SESSION[self::SESS_ADMIN_ID])
            && $_SESSION[self::SESS_ADMIN_ID] === self::ADMIN_ID;
    }

    /**
     *  Renvoie l'objet associé à l'utilisateur courant s'il existe
     *    (c'est-à-dire s'il est connecté)
     */
    public function getUserConsumer(): ?Consumer {
        return $this->currentUser;
    }

    /**
     *  Essaie de connecter un utilisateur, via son mail et son mot de passe.
     *  Renvoie 0 en cas de succès, sinon une valeur parmis USERCONNECT_FAILED_*
     */
    public function tryConnectUser(string $mail, string $password) : int {
        $c = Consumer::getConsumerByMail($mail);
        if (is_null($c)) {
            return self::USERCONNECT_FAILED_MAIL;
        }
        if (!Utils::testPassword($password, $c->Password)) {
            return self::USERCONNECT_FAILED_PASS;
        }
        $this->currentUser = $c;
        $this->isUserConnected = true;
        $_SESSION[self::SESS_USER_ID] = intval($c->Id);
        return 0;
    }

    /**  Tente de connecter l'utilisateur en tant qu'administrateur */
    public function tryConnectAdmin(string $password) : int {
        if (!Utils::testPassword($password, self::ADMIN_PASS)) {
            return self::ADMINCONNECT_FAILED_PASS;
        }
        $_SESSION[self::SESS_ADMIN_ID] = self::ADMIN_ID;
        return 0;
    }

    /**
     *  Essaie de connecter un utilisateur si il s'est déjà connecter
     *    auparavant, en utilisant l'ID stocké dans la session.
     *  @pre isset($_SESSION[self::SESS_USER_ID])
     */
    private function tryConnectUserNoPass(int $id) : int {
        if ($id === self::NOT_CONNECTED_USER_ID) {
            return self::USERCONNECT_FAILED_PASS;
        }
        $c = Consumer::getConsumerByID($id);
        if ($c === false || $c == null) {
            return self::USERCONNECT_FAILED_DB;
        }
        $this->currentUser = $c;
        $this->isUserConnected = true;
        return 0;
    }

    /**  Redirige vers l'accueil du site si l'utilisateur n'est pas admin */
    public function adminPage() {
        if (!$this->isUserAdmin()) {
            Utils::redirectTo(Constants::PAGE_HOME);
        }
    }

    /**  Déconnecte l'utilisateur courant */
    public function logOutUser() {
        $_SESSION[self::SESS_USER_ID] = self::NOT_CONNECTED_USER_ID;
    }

    /**  Déconnecte l'utilisateur courant, s'il est admin */
    public function logOutAdmin() {
        unset($_SESSION[self::SESS_ADMIN_ID]);
    }
}
