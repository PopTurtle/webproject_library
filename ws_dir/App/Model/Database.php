<?php

namespace App\Model;

use PDOException;

const DB_HOST = "localhost";
const DB_NAME = "webproject_library";
const DB_USER = "root";
const DB_PASS = "";

class Database {

    const ConnectionErrorCode = 500;
    const ConnectionErrorMsg = "Une erreur de connexion est survenue";

    private static $instance;
    private $connection;
    private $connectionError;

    private function __construct($redirectError) {
        $this->connectionError = false;
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $this->connection = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            if ($redirectError) {
                header(
                    "Location: /view/error.php?" .
                    "code=" . Database::ConnectionErrorCode . "&" .
                    "msg=" . Database::ConnectionErrorMsg
                );
            }
            $this->connectionError = true;
        }
    }

    // Si redirect error à false, alors il faut check connectionError
    public static function getDatabase($redirectError = true) : Database {
        if (Database::$instance == null) {
            Database::$instance = new Database($redirectError);
        }
        return Database::$instance;
    }

    public static function getConnection(): \PDO {
        return Database::getDatabase()->connection;
    }

    public function connection(): \PDO {
        return $this->connection;
    }

    public function hadConnectionError() {
        return $this->connectionError;
    }
}
