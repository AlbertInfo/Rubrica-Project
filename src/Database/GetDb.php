<?php

namespace Database;

require_once __DIR__ . '/../../vendor/autoload.php'; //caricare l'autoloader;
use Database\DatabaseContract;
use Database\DatabaseFactory;
use Exception;


class GetDb
{
    private static $db = null;

    public static function getDb()
    {
        if (self::$db === null) {
            self::$db = DatabaseFactory::Create(DatabaseContract::TYPE_PDO);
            if (!self::$db) {
                die("Errore: impossibile connettersi al database.");
            }
        }
        return   self::$db;
    }

    public static function lastInsertId()
    {
        if (self::$db === null) { 
            throw new Exception("Database non inizializzato!");
        }
        return self::$db->lastInsertId();
    }
}
