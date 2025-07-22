<?php
session_start();
include_once('../models/User.php');
include_once('../config/database.php');

// Initialiser le modèle User
$userModel = new User($db);

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // Si déjà connecté, rediriger vers le tableau de bord correspondant
    if ($_SESSION['role'] === 'admin') {
        header('Location: ../views/dashboard_admin.php');
    } else {
        header('Location: ../views/dashboard_user.php');
    }
    exit();
}

// Si le token CSRF n'existe pas, en créer un nouveau
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Inscription</title>
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="../views/index.php" class="back-btn">Retour</a> 


    <div class="login-container">
        <div class="tabs">
            <button class="tab-link active" onclick="openTab(event, 'login')">Connexion</button>
            <button class="tab-link" onclick="openTab(event, 'register')">Inscription</button>
        </div>

        <!-- Formulaire de Connexion -->
        <div id="login" class="tab-content active">

            <h2>Connexion</h2>

            <form action="../controllers/authController.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Se connecter</button>
            </form>
        </div>

        <!-- Formulaire d'Inscription -->
        <div id="register" class="tab-content">

            <h2>Inscription</h2>

            <form action="../controllers/authController.php" method="POST" enctype="multipart/form-data">
            <!-- Token CSRF pour protéger contre CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <!-- Champ Nom -->
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required>
            <small>Entrez votre nom de famille.</small>

            <!-- Champ Prénom -->
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
            <small>Entrez votre prénom.</small>

            <!-- Champ Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <small>Entrez une adresse email valide.</small>

            <!-- Champ Mot de passe -->
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            <small>Choisissez un mot de passe sécurisé.</small>

            <!-- Champ Confirmation du mot de passe -->
            <label for="confirm_password">Confirmer le mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <small>Entrez à nouveau le même mot de passe pour confirmation.</small>

            <!-- Champ Photo -->
            <label for="photo">Photo (facultatif)</label>
            <input type="file" id="photo" name="photo" accept="image/*">
            <small>Si vous souhaitez télécharger une photo, choisissez un fichier image.</small>

            <!-- Champ CV -->
            <label for="cv">CV (facultatif, format PDF)</label>
            <input type="file" id="cv" name="cv" accept="application/pdf">
            <small>Veuillez télécharger votre CV au format PDF si disponible.</small>

            <!-- Champ Téléphone -->
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone">
            <small>Entrez votre numéro de téléphone (facultatif).</small>

            <!-- Champ Adresse -->
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse">
            <small>Entrez votre adresse complète (facultatif).</small>

            <!-- Champ Code postal -->
            <label for="cp">Code postal</label>
            <input type="text" id="cp" name="cp">
            <small>Entrez votre code postal (facultatif).</small>

            <!-- Champ Ville -->
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville">
            <small>Indiquez votre ville (facultatif).</small>

            <!-- Rôle par défaut -->
            <input type="hidden" name="role" value="user">

            <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
    
    <script src="/public/js/tabs.js"></script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
