<?php
// Vérifier si la session est active avant de la détruire
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Démarrer la session si elle n'est pas déjà active
}

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil (index)
header('Location: ../views/index.php');
exit();
?>
