<?php

namespace Database;

require_once __DIR__ . '/../../vendor/autoload.php'; //caricare l'autoloader;
use Database\DatabaseContract;
use Database\DatabaseFactory;
use Database\MyPDO;
use Database\DBConfig;
use Exception;


class GetDbTest
{
    private static  $db ;

    public static function getDb()  
    {
        
            $db = DatabaseFactory::Create(DatabaseContract::TYPE_PDO);
            
    
        return $db;
    }

    public static function lastInsertId()
    {
        
        return self::$db->lastInsertId();
    }
}
