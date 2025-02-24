<?php

require_once __DIR__ . '/vendor/autoload.php'; 
require_once __DIR__ . '/common.php'; 



if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $contactId = $_GET['contact_id'];
    $imgId = $_GET['picture_id'];
    $db->getData("DELETE FROM contacts WHERE id = ?", [$contactId]);
    $db->getData("DELETE FROM pictures WHERE id = ?", [$imgId]);

    header("Location : homepagetest.php"); //Reload della pagina
}

