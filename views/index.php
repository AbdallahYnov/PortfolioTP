<?php
include_once('../models/User.php');
include_once('../config/database.php');

// Initialiser le modèle User
$userModel = new User($db);

// Vérifier si une session est active et si un utilisateur est connecté
$profiles = [];
if (!isset($_SESSION['user_id'])) {
    // Si la session n'est pas active, récupérer quelques profils pour le carrousel
    $profiles = $userModel->getUsers(); // On récupère des utilisateurs
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="../public/css/index.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="index-container">

        <section id="description">
            <h2>À propos de ce projet</h2>
            <p>Ce portfolio en ligne vous permet de gérer vos compétences, ajouter des projets et bien plus. Vous pouvez vous inscrire, vous connecter, et commencer à structurer votre portfolio selon vos besoins.</p>
        </section>

        <section id="fonctionnalités">
            <h2>Fonctionnalités principales</h2>
            <ul>
                <li>Inscription et gestion du compte</li>
                <li>Ajout et gestion des compétences</li>
                <li>Création et gestion des projets</li>
                <li>Affichage structuré des projets avec images et liens externes</li>
                <li>Interface sécurisée avec gestion des sessions</li>
            </ul>
        </section>

        <section id="demarrer">
            <h2>Commencer</h2>
            <p>Pour commencer, <a href="../views/login.php">inscrivez-vous</a> ou <a href="../views/login.php">connectez-vous</a> si vous avez déjà un compte.</p>
        </section>

        <section id="documentation">
            <h2>Documentation</h2>
            <p>Pour plus d'informations sur le projet, consultez le <a href="README.html">README</a> ou téléchargez la documentation complète.</p>
        </section>

    </div>    

    <?php include '../includes/footer.php'; ?>

</body>
</html>
