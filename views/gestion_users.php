<?php
session_start();
require_once('../models/User.php');
require_once('../config/database.php');  // Assurez-vous que la connexion à la base de données est incluse

// Créer une instance du modèle User
$userModel = new User($db);

// Vérification si l'utilisateur est connecté et a le bon rôle
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Si l'utilisateur n'est pas connecté ou n'a pas le rôle admin, rediriger
    header('Location: login.php');
    exit();
}

// Récupérer tous les utilisateurs
$users = $userModel->getUsers();

// Recherche des utilisateurs si une recherche a été faite
if (isset($_GET['search'])) {
    $searchTerm = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');
    $users = $userModel->searchUsers($searchTerm);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="../public/css/gestion_users.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="../views/dashboard_admin.php" class="back-btn">Retour</a> 

    <div class="gestion_users-container">
        <h2>Gestion des utilisateurs</h2>
        
        <!-- Formulaire de recherche -->
        <form action="gestion_users.php" method="get">
            <input type="text" name="search" placeholder="Rechercher un utilisateur..." value="<?= isset($searchTerm) ? htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') : ''; ?>" />
            <button type="submit">Rechercher</button>
        </form>

        <!-- Tableau des utilisateurs -->
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <form action="../controllers/adminController.php" method="post">
                                <select name="role">
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                                <button type="submit" name="update_role">Modifier rôle</button>
                            </form>
                        </td>
                        <td>
                            <!-- Formulaire de suppression d'utilisateur -->
                            <form action="../controllers/adminController.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                                <!-- Token CSRF pour sécuriser l'action -->
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                <button type="submit" name="delete_user">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
