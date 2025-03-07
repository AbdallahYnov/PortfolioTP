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

// Ajouter une compétence
if (isset($_POST['add_competence'])) {
    $competence_name = $_POST['competence_name'];
    $competenceModel->addCompetence($competence_name);
    header('Location: ../views/creat_competence.php'); // Rediriger après ajout
    exit;
}
?>
