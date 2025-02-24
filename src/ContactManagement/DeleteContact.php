<?php

namespace ContactManagement;

use Database\GetDb;

require_once __DIR__ . '/../../common.php'; // per utilizzare le create e l'autoload dentro common.php


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $contactId = $_GET['contact_id'];
    $imgId = $_GET['picture_id'];

    DeleteContact::deleteContact($contactId, $imgId);


  
}


class DeleteContact
{



    public static function deleteContact(int $contactId, int $imgId)
    {
        $db = GetDb::getDb();
        $db->getData("DELETE FROM contacts WHERE id = ?", [$contactId]);
        $db->getData("DELETE FROM pictures WHERE id = ?", [$imgId]);

        header("Location : ../../homepagetest.php");
    }
}
