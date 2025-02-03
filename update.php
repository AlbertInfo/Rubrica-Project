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
    $id = $_GET['actor_id'];
    //Vado a prendere dal db l'attore che ha l'id che arriva da GET
    $result =  $db->getData("SELECT * FROM actor WHERE actor_id = ?", [$id]);

    $selectedActor = $result->fetch();

    if (!$selectedActor) {
        die('Actor not found!');
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $id = $_POST['actor_id'];

    //Query POST PER AGGIORNARE IL NOME DELL'ATTORE.
    $db2->setData("UPDATE actor SET first_name = ?, last_name = ? WHERE actor_id = ?", [
        [$firstName, $lastName, $id]

    ]);

    //Reload della pagina
    header("Location : index.php"); //Reload della pagina
   
    
    
    //Inserimento di due elementi alla volta in transazione.
    // $db->doWithTransaction([
    //     "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')",
    //     "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')"
    // ]);


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update actor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    Aggiorna il nome attore
                </div>
                <form action="" method="POST">
                    <input type="hidden" name="actor_id" value="<?= $id ?>">
                    <input type="text" name="first_name" value="<?= Helper::AccesToValue($selectedActor, 'first_name', 'null') ?>">
                    <input type="text" name="last_name" value="<?= Helper::AccesToValue($selectedActor, 'last_name', 'null') ?>">
                    <input type="submit" value="Invia">


                </form>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>