<?php
include_once('../models/User.php');
include_once('../config/database.php');

// Créer une instance du modèle User
$userModel = new User($db);

// Récupérer tous les utilisateurs
$users = $userModel->getUsers();

// S'assurer que l'ID utilisateur est valide (si passé dans l'URL)
if (isset($_GET['user_id'])) {
    $user_id = filter_var($_GET['user_id'], FILTER_VALIDATE_INT);
    if ($user_id === false) {
        header("Location: error.php"); // Rediriger vers une page d'erreur si l'ID est invalide
        exit();
    }
}
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
                    <!-- Affichage de la photo de l'utilisateur -->
                    <?php if (!empty($user['photo'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($user['photo']); ?>" alt="Photo de <?= htmlspecialchars($user['nom']); ?>" class="profile-photo">
                    <?php else: ?>
                        <img src="../public/images/default-avatar.png" alt="Photo par défaut" class="profile-photo">
                    <?php endif; ?>
                    
                    <h3><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?></h3>
                    <p>Email: <?= htmlspecialchars($user['email']); ?></p>
                    <!-- Lien vers le portfolio de l'utilisateur -->
                    <a href="porte_folio_user.php?user_id=<?= urlencode($user['id']); ?>" class="view-portfolio-btn">Voir le portfolio</a>
                    </div>
            <?php endforeach; ?>
        </div>
        
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
