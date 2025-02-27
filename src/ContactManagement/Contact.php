<?php

namespace ContactManagement;

require_once __DIR__ . '/../../vendor/autoload.php'; //caricare l'autoloader;
require_once __DIR__ . '/../../common.php';

use App\Helper;
use Database\GetDb;


class Contact
{

    private static $db = null;

    private static function initDb()
    {
        if (self::$db === null) {
            self::$db = GetDb::getDb();
        }
    }

    public  static function setImage(array $file)
    {
        self::initDb();
        if ($file["picture"]["error"] !== UPLOAD_ERR_OK) {
            $imageType = 'jpg';
            $placeholder = 'mock\person-placeholder.jpg';
            $imageData = file_get_contents($placeholder);
            self::$db->setData("INSERT INTO pictures (content, type) VALUES (?,?)", [
                [$imageData, $imageType]

            ]);
        }
        if ($file["picture"]["error"] == UPLOAD_ERR_OK) {

            $imageData = file_get_contents($file["picture"]["tmp_name"]);
            $imageType = $file["picture"]["type"];
            self::$db->setData("INSERT INTO pictures (content, type) VALUES (?,?)", [
                [$imageData, $imageType]

            ]);
        }
    }



    public static function addContact(array $info, array $file)
    {
        self::initDb();
        $pictureId = GetDb::lastInsertId();

        $checkEmail = self::$db->prepare("SELECT id FROM contacts WHERE email = :email");
        $checkEmail->execute([":email" => $info['email']]);
        if ($checkEmail->fetch()) {
            die("Errore: L'email esiste già!");
        }
    

        self::$db->setData("INSERT INTO contacts (name, surname, phone_number, company, role, picture, email, birthdate,picture_id) VALUES (?,?,?,?,?,?,?,?,?)", [
            [$info['name'], $info['surname'], $info['phone_number'], $info['company'], $info['role'], $file['picture']['tmp_name'], $info['email'], $info['birthdate'], $pictureId]

        ]);
    }

    public static function contactsList()
    {
        self::initDb();
        $data = self::$db->getData("SELECT * FROM contacts ");
        $contacts = $data->fetchAll();

        return $contacts;
    }
}
