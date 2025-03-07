<?php
session_start();
include_once('../models/User.php');
include_once('../config/database.php');

$userModel = new User($db);

// Mettre à jour le rôle
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    $userModel->updateRole($user_id, $role);
    header('Location: ../views/gestion_users.php');
    exit;
}

// Supprimer un utilisateur
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $userModel->deleteUser($user_id);
    header('Location: ../views/gestion_users.php');
    exit;
}
?>
