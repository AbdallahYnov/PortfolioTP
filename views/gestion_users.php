<?php

include_once('../models/User.php');
include_once('../config/database.php');  // Assurez-vous que la connexion à la base de données est incluse

// Créer une instance du modèle User
$userModel = new User($db);

// Récupérer tous les utilisateurs
$users = $userModel->getUsers();

// Recherche des utilisateurs si une recherche a été faite
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
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
            <input type="text" name="search" placeholder="Rechercher un utilisateur..." />
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
                        <td><?php echo $user['nom'] . ' ' . $user['prenom']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <form action="../controllers/adminController.php" method="post">
                                <select name="role">
                                    <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>Utilisateur</option>
                                    <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                                </select>
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="update_role">Modifier rôle</button>
                            </form>
                        </td>
                        <td>
                            <form action="../controllers/adminController.php" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete_user" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</button>
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
