<?php
// Démarrage de la session
session_start();

// Vérification que l'utilisateur est connecté et qu'il a le rôle 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Si l'utilisateur n'est pas admin, rediriger vers la page de connexion ou dashboard utilisateur
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <link rel="stylesheet" href="../public/css/dashboard_admin.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php';?>
    <div class="dashboard_admin">
        <h2>Tableau de bord administrateur</h2>
        <div id="dashboard_admin">
            <!-- Liens vers les différentes sections de gestion -->
            <a href="../views/gestion_users.php" class="back-btn">Gestion des utilisateurs</a> 
            <a href="../views/creat_competence.php" class="back-btn">Gestion des compétences</a>
            <a href="../views/presentation_profils_admin.php" class="back-btn">Présentation des profils</a> 
        </div>
    </div>
    <?php include '../includes/footer.php';?>
</body>
</html>
