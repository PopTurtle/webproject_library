<?php

namespace App\Model;

use App\Utils\Singleton;
use App\Utils\Utils;
use PDOException;


/**
 *  Gère la connection à la base de données, si elle est utilisée, sa méthode
 *    statique ensureInstance doit être appelée avant tout code HTML, afin de
 *    pouvoir rediriger sur une page d'erreur en cas de problème de connection.
 */
class Database extends Singleton {
    /**  Constantes de connection */
    private const DB_HOST = "localhost";
    private const DB_NAME = "webproject_library";
    private const DB_USER = "root";
    private const DB_PASS = "";

    /**  Constantes d'erreur */
    public const ConnectionErrorCode = 500;
    private const ConnectionErrorMsg = "Une erreur de connexion s'est produite";

    /**  Connection courante à la BDD */
    private \PDO $connection;

    /**  Permet d'assurer la connection (Instanciation) */
    public function ensureConnection() {
        static::Instance();
    }

    /**  Se connecte à la BDD ou redirige sur une page d'erreur */
    protected function __construct() {
        try {
            $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME;
            $this->connection = new \PDO($dsn, self::DB_USER, self::DB_PASS);
        } catch (PDOException $e) {
            Utils::showErrorCode(Database::ConnectionErrorCode, Database::ConnectionErrorMsg);
        }
    }

    public static function getConnection(): \PDO {
        return static::Instance()->connection;
    }

    public function connection(): \PDO {
        return $this->connection;
    }
}
