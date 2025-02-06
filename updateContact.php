<?php

use Alberto\DatabaseAbstraction\Helper;

require_once __DIR__ . '/common.php'; // per utilizzare le create e l'autoload dentro common.php


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    // var_dump($_GET);

}



$id = $_GET['id'];
// var_dump($id);
//Vado a prendere dal db l'attore che ha l'id che arriva da GET
$result =  $db2->getData("SELECT * FROM contacts WHERE id = ?", [$id]);


$selectedContact = $result->fetch();
$name = $selectedContact['name'] ?? '';
$surname = $selectedContact['surname'] ?? '';
$phone_number = $selectedContact['phone_number'] ?? '';
$company = $selectedContact['company'] ?? '';
$role = $selectedContact['role'] ?? '';
$email = $selectedContact['email'] ?? '';
$birthdate = $selectedContact['birthdate'] ?? '';
$img = $selectedContact['picture_id'] ? "viewImage.php?id=" . $selectedContact['picture_id'] : "./mock/person-placeholder.jpg"; 



if ($_SERVER['REQUEST_METHOD'] == "POST") {

// var_dump($_POST);

    //Query POST PER AGGIORNARE IL NOME DELL'ATTORE.
    // $db2->setData("UPDATE contact SET name = ?, surname = ?, phone_number = ?, company = ?, role = ?, picture =?, email =?, birthdate =?,picture_id =?, WHERE actor_id = ?", [
    //     [$firstName, $lastName, $id]

    // ]);

    //Reload della pagina
    // header("Location : index.php"); //Reload della pagina



    //Inserimento di due elementi alla volta in transazione.
    // $db->doWithTransaction([
    //     "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')",
    //     "INSERT INTO actor (first_name, last_name) VALUES('$firstName', '$lastName')"
    // ]);


}
?>

<!DOCTYPE html>
<html lang="en">
</head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Creazione Contatto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/domManipolation.js"></script>
<style>
    body {
        background: linear-gradient(135deg, #667eea, #764ba2);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .container-custom {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 90%;
        max-width: 600px;
    }

    .contacts-container,
    .form-container {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .contact-item {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .contact-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .contact-buttons button {
        margin-left: 5px;
    }

    .image-upload {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        cursor: pointer;
        display: inline-block;
    }

    .image-upload img {
        width: 100%;
        height: 100%;
        object-fit: cover;

    }

    .image-upload::before {
        content: "Aggiungi Foto";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border-radius: 5px;
        opacity: 0.7;
    }

    .image-upload input {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;

    }

    @media (min-width: 768px) {
        .container-custom {
            flex-direction: row;
            max-width: 1000px;
        }

        .contacts-container {
            width: 50%;
            max-height: 500px;
            overflow-y: auto;
        }

        .form-container {
            width: 50%;
        }
    }
</style>

</head>

<body>
    <div class="form-container">
        <h3 class="text-center text-primary">Aggiorna informazioni contatto</h3>
        <form method="POST" id="contact-form" enctype="multipart/form-data">
            <div class="text-center">
                <label class="image-upload" id="upload-image">
                    <img src="<?= $img ?>" id="previewImage" alt="Aggiungi Foto">
                    <input type="hidden" name="MAX_FILE_SIZE" id="">
                    <input type="file" id="photo" onchange="changePlaceholder(event)" name="picture">
                </label>
            </div>
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control" placeholder="Inserisci il nome" required name="name" value="<?= $name ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Cognome</label>
                <input type="text" class="form-control" placeholder="Inserisci il cognome" required name="surname" value="<?= $surname ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Inserisci l'email" required name="email" value="<?= $email ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Organizzazione</label>
                <input type="text" class="form-control" placeholder="Inserisci l'organizzazione" name="company" value="<?= $company ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Ruolo</label>
                <input type="text" class="form-control" placeholder="Inserisci il ruolo" name="role" value="<?= $role ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Numero di cellulare</label>
                <input type="tel" class="form-control" placeholder="Inserisci il numero" required name="phone_number" value="<?= $phone_number ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Compleanno</label>
                <input type="date" class="form-control" required name="birthdate" value="<?= $birthdate ?>">
            </div>

            <button type="submit" class="btn btn-primary w-100">Salva modifiche</button>
        </form>
    </div>
</body>

</html>