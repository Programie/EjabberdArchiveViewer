<?php
namespace com\selfcoders\ejabberdarchiveviewer;

use PDO;

class Database
{
    /**
     * @var PDO
     */
    private static $pdo;

    /**
     * @return PDO
     */
    public static function getPdo()
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(Config::getValue("database", "dsn"), Config::getValue("database", "username"), Config::getValue("database", "password"));

            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$pdo->exec("SET NAMES utf8mb4");
        }

        return self::$pdo;
    }
}