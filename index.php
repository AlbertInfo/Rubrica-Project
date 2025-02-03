<?php

require_once __DIR__ . '/common.php'; // per utilizzare le create dentro common.php
//Se voglio modificare il composer.json devo fare il comando composer update
//Come aggiunta di dipendenze o cambio autoload


//Questa era la precente creazione della connessione a  db che è stata spostata su common.php
// $db = DatabaseFactory::Create( DatabaseContract::TYPE_MySQLi);
// $db2 = DatabaseFactory::Create( DatabaseContract::TYPE_PDO);



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];

    //Inserimento a DB senza transazione : togliere commento se si vuole testare.
    //Passo la query e un array di array cosi come richiesto dall'execute di PDO per l'insert.
    $db->setData("INSERT INTO actor (first_name, last_name) VALUES (?,?)", [
        [$firstName, $lastName]

    ]);

    //Inserimento di due elementi alla volta in transazione.
    $db->doWithTransaction([
        "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')",
        "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')"
    ]);

    //Reload della pagina
    header("Location : index.php"); //Reload della pagina

}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sakila test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<!-- Restituzione da db con ciclo foreach -->

<body>
    <div class="container w-50">

        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    Crea un nuovo attore nel db:
                </div>
                <form action="" method="POST">
                    <input type="text" name="first_name" placeholder="nome">
                    <input type="text" name="last_name" placeholder="cognome">
                    <input type="submit" value="Invia">


                </form>
            </div>

        </div>
    </div>

    <hr>
    <div class="container w-25">
        <!-- Qui in questo codice sono implemenate il fetch e il fetchAll, ma il secondo svuota comunque l'array e non è compatibile con il fetch sulle stesse informazioni -->
        <div class="card d-flex">
            <div class="card-body">
                <div class="card-title">
                    Actors SQL query #1
                </div>

                <!-- query eseguita passando il parametro e specificando un array associativo ["param1" => "%pen%"]-->
                <ul class="list-group">
                    <?php $result =  $db2->getData("SELECT * FROM actor WHERE first_name LIKE :param1", ["param1" => "%pen%"]); ?>
                    <?php while ($actor = $result->fetch()) : ?>
                        <li class="list-group-item d-flex justify-content-between"><a class="link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="update.php?actor_id=<?= $actor['actor_id'] ?>"><?= $actor["first_name"] ?>, <?= $actor["last_name"] ?></a><a href="delete.php?actor_id=<?= $actor['actor_id'] ?>"><i class="fa-solid fa-trash-can"></i></a></li>
                    <?php endwhile;  ?>

                    <!-- FETCH ALL SENZA PARAM   -->
                    <?php /* foreach ($result->fetchAll() as $actor) : ?>
                        <li class="list-group-item"><?= $actor["first_name"] ?>, <?= $actor["last_name"] ?></li>
                    <?php endforeach; */  ?>
                </ul>
            </div>

        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    Actors SQL query #2
                </div>
                <!--query eseguita in cui il parametro passato con il ? i parametri passati vengono specificati
                    secondo l'ordine con cui vengono passati ogni ? corrisponde ad un argomento si possono
                    inserire anche piu di uno  sempre insieme dentro le quadre -->

                <ul class="list-group">
                    <?php $result =  $db->getData("SELECT * FROM actor WHERE first_name LIKE ?", ["%alb%"]); ?>
                    <?php while ($actor = $result->fetch()) : ?>
                        <li class="list-group-item d-flex justify-content-between"><a class="link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="update.php?actor_id=<?= $actor['actor_id'] ?>"><?= $actor["first_name"] ?>, <?= $actor["last_name"] ?></a><span><a href="delete.php?actor_id=<?= $actor['actor_id'] ?>"><i class="fa-solid fa-trash-can"></i></a></span></li>
                    <?php endwhile; ?>


                    <?php /*foreach ($result->fetchAll() as $actor) : ?>
                        <li class="list-group-item"><?= $actor["first_name"] ?>, <?= $actor["last_name"] ?></li>
                    <?php endforeach; */ ?>
                </ul>
            </div>

        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    Actors SQL query #3 with
                </div>
                <!--query eseguita in cui il parametro passato con il ? i parametri passati vengono specificati
                    secondo l'ordine con cui vengono passati ogni ? corrisponde ad un argomento si possono
                    inserire anche piu di uno  sempre insieme dentro le quadre -->

                <ul class="list-group">
                    <?php $result =  $db->getData("SELECT * FROM actor ORDER BY actor_id DESC LIMIT 5", []); ?>
                    <?php while ($actor = $result->fetch()) : ?>
                        <li class="list-group-item d-flex justify-content-between"><a class="link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="update.php?actor_id=<?= $actor['actor_id'] ?>"><?= $actor["first_name"] ?>, <?= $actor["last_name"] ?></a><a href="delete.php?actor_id=<?= $actor['actor_id'] ?>"><i class="fa-solid fa-trash-can"></i></a></li>
                    <?php endwhile; ?>


                    <?php /*foreach ($result->fetchAll() as $actor) : ?>
                        <li class="list-group-item"><?= $actor["first_name"] ?>, <?= $actor["last_name"] ?></li>
                    <?php endforeach; */ ?>
                </ul>
            </div>

        </div>




    </div>

    <script src="https://kit.fontawesome.com/a64b9c8090.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>