<?php

namespace ContactManagement;

use Database\DatabaseContract;
use Database\GetDbTest;
use Database\MyPDO;

class AddContact implements AddContactContract
{

    public  ?MyPDO  $db = null;

    public  function getDb()
    {

        return $this->db;
    }

    public function setDb()
    {

        $this->db = GetDbTest::getDb();
    }

    public function setImage(array $file) {
 
        if($this->db == null){

            $this->setDb();
        }

        if ($file["picture"]["error"] !== UPLOAD_ERR_OK) {
            $imageType = 'jpg';
            $placeholder = 'mock\person-placeholder.jpg';
            $imageData = file_get_contents($placeholder);
            $this->db->setData("INSERT INTO pictures (content, type) VALUES (?,?)", [
                [$imageData, $imageType]

            ]);
        }
        if ($file["picture"]["error"] == UPLOAD_ERR_OK) {

            $imageData = file_get_contents($file["picture"]["tmp_name"]);
            $imageType = $file["picture"]["type"];
            $this->db->setData("INSERT INTO pictures (content, type) VALUES (?,?)", [
                [$imageData, $imageType]

            ]);


        }
         
    }


    public function addContact(array $info, array $file) {

        if($this->db == null){

            $this->setDb();
        }
        $pictureId = $this->db->lastInsertId();

        $checkEmail = $this->db->prepare("SELECT id FROM contacts WHERE email = :email");
        $checkEmail->execute([":email" => $info['email']]);
        if ($checkEmail->fetch()) {
            die("Errore: L'email esiste già!");
        }


        $this->db->setData("INSERT INTO contacts (name, surname, phone_number, company, role, picture, email, birthdate,picture_id) VALUES (?,?,?,?,?,?,?,?,?)", [
            [$info['name'], $info['surname'], $info['phone_number'], $info['company'], $info['role'], $file['picture']['tmp_name'], $info['email'], $info['birthdate'], $pictureId]

        ]);
   
        header("Location : ../../homepage.php");
    }
}
