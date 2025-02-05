<?php

require_once __DIR__ . '/vendor/autoload.php'; //caricare l'autoloader;
require_once __DIR__ . '/common.php'; // per utilizzare le create e l'autoload dentro common.php

//Se voglio modificare il composer.json devo fare il comando composer update
//Come aggiunta di dipendenze o cambio autoload





//Creo una istanza di DBConfig e passo i parametri di connessione del db
//cosa da non fare quando si va in produzione.

// $statement->debubDumpParamas() : mi permette di vedere lo stato
//e le informazione dello statement

//Creo la connessione a db passando la dbConfig che mi ritorna la stringa 
//proprio come vuole il PDO.

// Qui posso passare due tipi di connessione al db o TYPE_PDO O TYPE_MYSQLi che attualmente non è
//implementato e tira un'eccezione.



if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $contactId = $_GET['contact_id'];
    // var_dump($_GET['picture_id']);
    $imgId = $_GET['picture_id'];


    
    $db2->getData("DELETE FROM contacts WHERE id = ?", [$contactId]);
    $db2->getData("DELETE FROM pictures WHERE id = ?", [$imgId]);

    header("Location : homepage.php"); //Reload della pagina
}

