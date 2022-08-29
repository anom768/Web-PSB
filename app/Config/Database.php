<?php

namespace Anyar\Web\PSB\Config;
use PDO;

class Database
{
    public static ?PDO $pdo = null;

    public static function getConnection(string $env = "test"):PDO
    {
        if (self::$pdo == null) {
            require_once __DIR__ . "/../../config/database.php";
            $config = getDatabaseConfig();
            self::$pdo = new PDO(
                $config["database"][$env]["url"],
                $config["database"][$env]["username"],
                $config["database"][$env]["password"]
            );
        }
        return self::$pdo;
    }

    public static function startTransaction()
    {
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction()
    {
        self::$pdo->commit();
    }

    public static function rollbackTransaction()
    {
        self::$pdo->rollBack();
    }
}