<?php

namespace App\Model;

use App\Constants;
use App\Utils\Utils;
use PDOException;

class Database { // SINGLETON?
    private const DB_HOST = "localhost";
    private const DB_NAME = "webproject_library";
    private const DB_USER = "root";
    private const DB_PASS = "";

    public const ConnectionErrorCode = 500;
    private const ConnectionErrorMsg = "Une erreur de connexion est survenue";

    private static $instance;
    private $connection;
    private $connectionError;

    private function __construct($redirectError) {
        $this->connectionError = false;
        try {
            $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME;
            $this->connection = new \PDO($dsn, self::DB_USER, self::DB_PASS);
        } catch (PDOException $e) {
            if ($redirectError) {
                Utils::showErrorCode(Database::ConnectionErrorCode, Database::ConnectionErrorMsg);
            }
            $this->connectionError = true;
        }
    }

    // Si redirect error à false, alors il faut check connectionError
    public static function getDatabase($redirectError = true) : Database {
        if (Database::$instance == null || true) {
            Database::$instance = new Database($redirectError);
        }
        return Database::$instance;
    }

    public static function getConnection($redirectError = true): \PDO {
        return Database::getDatabase($redirectError)->connection;
    }

    public function connection(): \PDO {
        return $this->connection;
    }

    public function hadConnectionError() {
        return $this->connectionError;
    }
}
