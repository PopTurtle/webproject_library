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
    private const DB_DEFAULT_HOST = "localhost";
    private const DB_DEFAULT_NAME = "webproject_library";
    private const DB_DEFAULT_USER = "root";
    private const DB_DEFAULT_PASS = "";

    /**  Variables d'environnements associées */
    private const DB_ENV_HOST = "DB_HOST";
    private const DB_ENV_NAME = "DB_NAME";
    private const DB_ENV_USER = "DB_USER";
    private const DB_ENV_PASS = "DB_PASS";

    /**  Constantes d'erreur */
    public const ConnectionErrorCode = 500;
    public const RequestErrorCode = 501;
    private const ConnectionErrorMsg = "Une erreur de connexion s'est produite";

    /**  Connection courante à la BDD */
    private \PDO $connection;

    /**  Permet d'assurer la connection (Instanciation) */
    public static function ensureConnection() {
        static::Instance();
    }

    /**  Se connecte à la BDD ou redirige sur une page d'erreur */
    protected function __construct() {
        $host = getenv(self::DB_ENV_HOST) ?: self::DB_DEFAULT_HOST;
        $name = getenv(self::DB_ENV_NAME) ?: self::DB_DEFAULT_NAME;
        $user = getenv(self::DB_ENV_USER) ?: self::DB_DEFAULT_USER;
        $pass = getenv(self::DB_ENV_PASS) ?: self::DB_DEFAULT_PASS;
        try {
            $dsn = "mysql:host=" . $host . ";dbname=" . $name;
            $this->connection = new \PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            Utils::showErrorCode(Database::ConnectionErrorCode, Database::ConnectionErrorMsg);
        }
    }

    public static function getConnection() {
        return static::Instance()->connection;
    }

    public function connection(): \PDO {
        return $this->connection;
    }
}
