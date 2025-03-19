<?php
// Durée d'inactivité avant déconnexion (en secondes)
$timeout_duration = 30 * 60; // 30 minutes

// Vérification de l'existence de la session et de l'inactivité de l'utilisateur
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Regénérer l'ID de session pour éviter la fixation de session
    session_regenerate_id(true);

    // Destruction de la session pour forcer la déconnexion
    session_unset();
    session_destroy();
    
    // Redirection vers la page de connexion
    header("Location: ../views/login.php");
    exit();
}

// Met à jour l'heure de la dernière activité
$_SESSION['last_activity'] = time();
?>
