<?php
use Alberto\DatabaseAbstraction\Helper;

require_once __DIR__ . '/common.php'; // per utilizzare le create e l'autoload dentro common.php
//Se voglio modificare il composer.json devo fare il comando composer update
//Come aggiunta di dipendenze o cambio autoload



//Questa era la precente creazione della connessione a  db che è stata spostata su common.php
// $db = DatabaseFactory::Create( DatabaseContract::TYPE_PDO);
// $db2 = DatabaseFactory::Create( DatabaseContract::TYPE_MySQLi);

$selectedActor = array(); // questo viene settato cosi perchè nella condizione dentro $POST NON ESISTE

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $name = $_GET['name'];
    $surname = $_GET['surname'];

    var_dump($name,$surname);
}

// if ($_SERVER['REQUEST_METHOD'] == "POST") {

//     $firstName = $_POST['first_name'];
//     $lastName = $_POST['last_name'];
//     $id = $_POST['actor_id'];

//     //Query POST PER AGGIORNARE IL NOME DELL'ATTORE.
//     $db2->setData("UPDATE actor SET first_name = ?, last_name = ? WHERE actor_id = ?", [
//         [$firstName, $lastName, $id]

//     ]);

//     //Reload della pagina
//     header("Location : index.php"); //Reload della pagina
   
    
    
//     //Inserimento di due elementi alla volta in transazione.
//     // $db->doWithTransaction([
//     //     "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')",
//     //     "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')"
//     // ]);


// }
?>
