<?php

require_once __DIR__ . '/common.php'; // per utilizzare le create dentro common.php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // header("Location : homepage.php"); //Reload della pagina
    $picture = $_FILES['picture'];
    $pictureTmpName = $_FILES['picture']['tmp_name'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $role = $_POST['role'];
    $phone_number = $_POST['phone_number'];
    $birthdate = $_POST['birthdate'];

    // var_dump($_FILES['picture']);
    //Verifica se l'email è gia presente.
    $checkEmail = $db2->prepare("SELECT id FROM contacts WHERE email = :email");
    $checkEmail->execute([":email" => $email]);
    if ($checkEmail->fetch()) {
        die("Errore: L'email esiste già!");
    }

    if ($_FILES["picture"]["error"] !== UPLOAD_ERR_OK) {
        die("Errore nel caricamento dell'immagine.");
    }
    //Leggere il contenuto dell'immagine.

    $imageData = file_get_contents($_FILES["picture"]["tmp_name"]);

    $imageType = $_FILES["picture"]["type"];

    $db2->setData("INSERT INTO pictures (content, type) VALUES (?,?)", [
        [$imageData, $imageType]

    ]);

    $pictureId = $db2->lastInsertId();

    $db2->setData("INSERT INTO contacts (name, surname, phone_number, company, role, picture, email, birthdate,picture_id) VALUES (?,?,?,?,?,?,?,?,?)", [
        [$name, $surname, $phone_number, $company, $role, $pictureTmpName, $email, $birthdate, $pictureId]

    ]);
}


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $name = $_GET['name'] ?? '';
    $surname = $_GET['surname'] ?? '';
    $phone_number = $_GET['phone_number'] ?? '';
    $company = $_GET['company'] ?? '';
    $role = $_GET['role'] ?? '';
    $email = $_GET['email'] ?? '';
    $birthdate = $_GET['birthdate'] ?? '';
   
    
}


?>
<!DOCTYPE html>
<html lang="it">

<head>
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
    <div class="container-custom">
        <div class="form-container">
            <h3 class="text-center text-primary">Nuovo Contatto</h3>
            <form method="POST" id="contact-form" enctype="multipart/form-data">
                <div class="text-center">
                    <label class="image-upload" id="upload-image">
                        <img src="/mock/person-placeholder.jpg" id="previewImage" alt="Aggiungi Foto">
                        <input type="hidden" name="MAX_FILE_SIZE" id="">
                        <input type="file" id="photo" onchange="changePlaceholder(event)" name="picture">
                    </label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" placeholder="Inserisci il nome" required name="name" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Cognome</label>
                    <input type="text" class="form-control" placeholder="Inserisci il cognome" required name="surname" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Inserisci l'email" required name="email" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Organizzazione</label>
                    <input type="text" class="form-control" placeholder="Inserisci l'organizzazione" name="company" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruolo</label>
                    <input type="text" class="form-control" placeholder="Inserisci il ruolo" name="role" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di cellulare</label>
                    <input type="tel" class="form-control" placeholder="Inserisci il numero" required name="phone_number" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Compleanno</label>
                    <input type="date" class="form-control" required name="birthdate" >
                </div>

                <button type="submit" class="btn btn-primary w-100">Salva Contatto</button>
            </form>
        </div>
        <div class="contacts-container">
            <h4 class="text-primary">Contatti Salvati</h4>
            <ul class="list-group">
                <?php $result =  $db2->getData("SELECT * FROM contacts "); ?>
                <?php while ($contact = $result->fetch()) :
                ?>


                    <li class="list-group-item d-flex justify-content-between">
                        <?php
                        $pictureId = $contact['picture_id'];

                        ?>
                        <img src="<?= $contact['picture_id'] ? "viewImage.php?id=" . $contact['picture_id'] : "./mock/person-placeholder.jpg"; ?>" class="contact-image" alt="Foto Contatto">
                        <div>
                            <strong><?= $contact['name'] . PHP_EOL . $contact['surname'] ?></strong><br>
                            <small><?= $contact['phone_number']  ?></small>
                        </div>
                        <div class="contact-buttons">
                            <a href="./updateContact.php?id=<?= $contact['id'] ?>" class="btn btn-sm btn-warning">Modifica</a>
                            <a href="./delete.php?contact_id=<?= $contact['id'] ?>&picture_id=<?= $pictureId ?>" class="btn btn-sm btn-danger">Elimina</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>


</body>

</html>