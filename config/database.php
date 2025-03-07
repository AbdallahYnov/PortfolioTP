<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'projetb2');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', 3306);

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
