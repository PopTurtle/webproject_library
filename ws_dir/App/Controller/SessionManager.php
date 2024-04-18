<?php

namespace App\Controller;

use App\Model\Database;
use App\Model\DBObjects\Consumer;
use App\Utils\Singleton;
use App\Utils\Utils;

class SessionManager extends Singleton {
    public const USERCONNECT_FAILED_DB = -1;
    public const USERCONNECT_FAILED_MAIL = -2;
    public const USERCONNECT_FAILED_PASS = -3;

    // Utilisateur courant
    private bool $isUserConnected;
    private Consumer $currentUser;

    public const SESS_USER_ID = "user_id";

    protected function __construct()
    {
        $this->isUserConnected = false;
        if (isset($_SESSION[self::SESS_USER_ID])) {
            $this->tryConnectUserNoPass($_SESSION[self::SESS_USER_ID]);
        }
    }

    // Called for header
    public static function EnsureConnectionAttempt() {
        self::Instance();
    }

    public function isUserConnected(): bool {
        return $this->isUserConnected;
    }

    public function getUserConsumer(): Consumer {
        return new Consumer;
    }

    // Renvoie 0 en cas de succès
    public function tryConnectUser(string $mail, string $password, bool $redirectError = true) : int {
        $db = Database::getDatabase($redirectError);
        if ($db->hadConnectionError()) {
            return self::USERCONNECT_FAILED_DB;
        }
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

    private function tryConnectUserNoPass(int $id, $redirectError = true) : int {
        $db = Database::getDatabase($redirectError);
        if ($db->hadConnectionError()) {
            return self::USERCONNECT_FAILED_DB;
        }
        $c = Consumer::getConsumerByID($id);
        if ($c === false || $c == null) {
            return self::USERCONNECT_FAILED_DB;
        }
        $this->currentUser = $c;
        $this->isUserConnected = true;
        return 0;
    }
}
