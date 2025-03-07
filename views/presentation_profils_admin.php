<?php
include_once('../models/User.php');
include_once('../config/database.php');


$userModel = new User($db);

// Récupérer tous les utilisateurs
$users = $userModel->getUsers();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profils d'utilisateurs</title>
    <link rel="stylesheet" href="../public/css/presentation_profils.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="../views/dashboard_admin.php" class="back-btn">Retour</a> 


    <div class="profil-cards-container">
        <h2>Profils des utilisateurs</h2>

        <div class="card-container">
            <?php foreach ($users as $user): ?>
                <div class="profile-card">
                    <h3><?php echo $user['nom'] . ' ' . $user['prenom']; ?></h3>
                    <p>Email: <?php echo $user['email']; ?></p>
                    <a href="portfolio.php?user_id=<?php echo $user['id']; ?>" class="view-portfolio-btn">Voir le portfolio</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    
    <?php include '../includes/footer.php'; ?>
</body>
</html>
