<?php
// Inclure les fichiers nécessaires
include_once('../models/User.php'); // Modèle pour gérer les utilisateurs
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
        
                <!-- Champ Nom -->
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
                
                <!-- Champ Prénom -->
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>

                <!-- Champ Email -->
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <!-- Champ Mot de passe -->
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                
                <!-- Champ Confirmation du mot de passe -->
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                
                <!-- Champ Photo -->
                <label for="photo">Photo (facultatif)</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                
                <!-- Champ Téléphone -->
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone">
                
                <!-- Champ Adresse -->
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse">
                
                <!-- Champ Code postal -->
                <label for="cp">Code postal</label>
                <input type="text" id="cp" name="cp">
                
                <!-- Champ Ville -->
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville">
                
                <!-- Rôle par défaut -->
                <input type="hidden" name="role" value="user">
                
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
    
    <script>
        // Fonction pour afficher le formulaire de connexion
        function showLogin() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('registerForm').style.display = 'none';
        }

        // Fonction pour afficher le formulaire d'inscription
        function showRegister() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        }
    </script>

    <script src="/public/js/tabs.js"></script>
    

    <?php include '../includes/footer.php'; ?>
</body>
</html>
