<?php
session_start();
include_once('../models/Competence.php');
include_once('../config/database.php');

$competenceModel = new Competence($db);

// Vérification du rôle de l'utilisateur connecté (admin seulement)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../views/index.php');  // Redirection si non admin
    exit;
}

// Protection contre CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur CSRF');
}

// Ajouter une compétence
if (isset($_POST['add_competence'])) {
    // Validation et assainissement de l'entrée
    $competence_name = filter_input(INPUT_POST, 'competence_name', FILTER_SANITIZE_STRING); // Assainir le nom de la compétence

    // Ajouter la compétence de manière sécurisée
    $competenceModel->addCompetence($competence_name);

    header('Location: ../views/creat_competence.php'); // Rediriger après ajout
    exit;
}
?>
