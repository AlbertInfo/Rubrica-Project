<?php
namespace ContactManagement;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../../common.php'; // per utilizzare le create e l'autoload dentro common.php


use Database\MyPDO;
use Database\GetDbTest;

class UpdateContactTest implements UpdateContactContract
{



    public  string $name = '';
    public  string $surname = '';
    public  string $email = '';
    public  string $phoneNumber = '';
    public  string $company = '';
    public  string $role = '';
    public  string $birthdate = '';
    public  ?int $pictureId = null;
    public  string $imageType = '';
    public  string $imageTmpName = '';
    public  ?int $contactId = null;




    public  ?MyPDO  $db = null;

    public  function getDb()
    {

        return $this->db;
    }

    public function setDb()
    {

        $this->db = GetDbTest::getDb();
    }


    public   function selectContact(int $id)
    {
        $this->contactId = $id;
        if($this->db == null){

            $this->setDb();
        }
        $result = $this->db->getData("SELECT * FROM contacts WHERE id = ?", [$id]);
        $selectedContact = $result->fetch();
        $stmt = $this->db->getData("SELECT content, type FROM pictures WHERE id = ?", [$selectedContact['picture_id']]);
        $image = $stmt->fetch();
        $this->setImage($selectedContact['picture_id'], $selectedContact['picture']);
        $this->showContactInfo($selectedContact);
    }

    public  function setImage(int $imageId, string $picture)
    {

        $this->pictureId = $imageId;
        $this->imageTmpName = $picture;
    }



    public  function showContactInfo(array $selectedContact)
    {


        $this->name = $selectedContact['name'] ?? '';
        $this->surname = $selectedContact['surname'] ?? '';
        $this->phoneNumber = $selectedContact['phone_number'] ?? '';
        $this->company = $selectedContact['company'] ?? '';
        $this->role = $selectedContact['role'] ?? '';
        $this->email = $selectedContact['email'] ?? '';
        $this->birthdate = $selectedContact['birthdate'] ?? '';
    }

    public  function updateContactInfo(array $data, int $pictureId, string $pictureTmpName, int $contactId)
    {
        if($this->db == null){

            $this->setDb();
        }
        
        $id = $contactId;



        $this->db->setData("UPDATE contacts SET name = ?, surname = ?, phone_number = ?, company = ?, role = ?, picture =?, email =?, birthdate =?,picture_id =?  WHERE id = ?", [
            [$data['name'], $data['surname'], $data['phone_number'], $data['company'], $data['role'], $pictureTmpName, $data['email'], $data['birthdate'], $pictureId, $id]

        ]);


        header("Location : ../../homepage.php");
    }

    public function updateContactImage(array $file, array $newContactInfo, $contactId)
    {

        if($this->db == null){

            $this->setDb();
        }



        $results = $this->db->getData("SELECT picture_id , picture from contacts where id = ?", [$contactId]);
        $data = $results->fetch();
        $imageId = $data['picture_id'];

        $stmt = $this->db->getData("SELECT content, type FROM pictures WHERE id = ?", [$imageId]);
        $image = $stmt->fetch();
        $pictureTmpName = $data['picture'];
        $imageType = $image['type'];



        $pictureTmpName = $file["picture"]["tmp_name"];
        $imageType = $file["picture"]["type"];


        if (file_exists($pictureTmpName)) {
            $content = file_get_contents($pictureTmpName);
            $pictureTmpName = $file["picture"]["tmp_name"];
        } else {

            $content = $image['content'];
            $imageType = $image['type'];
            $pictureTmpName = $data['picture'];
        }




        $this->db->setData("UPDATE  pictures SET content = ? , type = ?  WHERE  id = ? ", [
            [$content, $imageType, $imageId]

        ]);

        $this->updateContactInfo($newContactInfo, $imageId, $pictureTmpName, $contactId);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    
    $data = new UpdateContactTest();
    $data->selectContact($_GET['contact_id']);
    

}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = new UpdateContactTest();
    $newUpdateContact = $data->updateContactImage($_FILES, $_POST, $_GET['contact_id']);
    
}
?>

<!DOCTYPE html>
<html lang="en">

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
    <div class="form-container">
        <h3 class="text-center text-primary">Aggiorna informazioni contatto</h3>
        <form method="POST" id="contact-form" enctype="multipart/form-data">
            <div class="text-center">
                <label class="image-upload" id="upload-image">
                    <img src="<?= $data->pictureId ? "/../viewImage.php?id=" . $data->pictureId  : "./mock/person-placeholder.jpg"; ?>" class="contact-image" alt="Foto Contatto" id="previewImage" alt="Aggiungi Foto">
                    <input type="hidden" name="MAX_FILE_SIZE" id="">
                    <input type="file" id="photo" onchange="changePlaceholder(event)" name="picture">
                </label>
            </div>
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control" placeholder="Inserisci il nome" required name="name" value="<?= $data->name ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Cognome</label>
                <input type="text" class="form-control" placeholder="Inserisci il cognome" required name="surname" value="<?= $data->surname ?> ">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Inserisci l'email" required name="email" value="<?= $data->email ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Organizzazione</label>
                <input type="text" class="form-control" placeholder="Inserisci l'organizzazione" name="company" value="<?= $data->company ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Ruolo</label>
                <input type="text" class="form-control" placeholder="Inserisci il ruolo" name="role" value="<?= $data->role ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Numero di cellulare</label>
                <input type="tel" class="form-control" placeholder="Inserisci il numero" required name="phone_number" value="<?= $data->phoneNumber ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Compleanno</label>
                <input type="date" class="form-control" required name="birthdate" value="<?= $data->birthdate ?>">
            </div>

            <button type="submit" class="btn btn-primary w-100">Salva modifiche</button>
        </form>
    </div>
</body>

</html>

