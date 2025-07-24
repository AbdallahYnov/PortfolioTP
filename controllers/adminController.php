<?php
include_once('../models/User.php');
include_once('../config/database.php');

// Vérification de la validité du token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur CSRF');
}

$userModel = new User($db);

// Mettre à jour le rôle
if (isset($_POST['update_role'])) {
    // Validation et assainissement des entrées
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT); // Sécurisation de l'ID utilisateur
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING); // Sécurisation du rôle

    // Mise à jour sécurisée via le modèle User (assurez-vous que le modèle utilise des requêtes préparées)
    $userModel->updateRole($user_id, $role);

    header('Location: ../views/gestion_users.php');
    exit;
}

// Supprimer un utilisateur
if (isset($_POST['delete_user'])) {
    // Validation et assainissement des entrées
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT); // Sécurisation de l'ID utilisateur

    // Suppression sécurisée via le modèle User (assurez-vous que le modèle utilise des requêtes préparées)
    $userModel->deleteUser($user_id);

    header('Location: ../views/gestion_users.php');
    exit;
}
?>
