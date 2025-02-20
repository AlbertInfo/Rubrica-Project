<?php

require_once __DIR__ . '/vendor/autoload.php'; //caricare l'autoloader;
use Database\DatabaseContract;
use Database\DatabaseFactory;



//Creazione della connessione a DB che verrà utilizzata da tutti i file.
// $db = DatabaseFactory::Create( DatabaseContract::TYPE_MySQLi);
$db = DatabaseFactory::Create( DatabaseContract::TYPE_PDO);