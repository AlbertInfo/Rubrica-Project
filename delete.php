<?php

require_once __DIR__ . '/vendor/autoload.php'; 
require_once __DIR__ . '/common.php'; 



if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $contactId = $_GET['contact_id'];
    $imgId = $_GET['picture_id'];


    
    $db2->getData("DELETE FROM contacts WHERE id = ?", [$contactId]);
    $db2->getData("DELETE FROM pictures WHERE id = ?", [$imgId]);

    header("Location : homepage.php"); //Reload della pagina
}

