<?php
require_once __DIR__ . '/common.php'; // per utilizzare le create dentro common.php

$pictureId = $_GET['id'];

// Query per recuperare l'immagine
$stmt = $db->getData("SELECT content, type FROM pictures WHERE id = ?", [$pictureId]);
$image = $stmt->fetch();

if ($image) {
    // Imposta il tipo di contenuto corretto
    header("Content-Type: " . $image["type"]);
    echo $image["content"]; // Stampa i dati binari dell'immagine
} else {
    // Se l'immagine non esiste, restituisci un placeholder
    header("Content-Type: image/png");
    readfile("./mock/person-placeholder.jpg");
}
?>