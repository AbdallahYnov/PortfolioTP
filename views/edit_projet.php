<?php
session_start();
require_once '../config/database.php';
require_once '../controllers/ProjectController.php';

$projectController = new ProjectController($db);

// Vérifier et ajouter un projet
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur CSRF');
    }

    // Ajouter un projet
    if (isset($_POST['titre'], $_POST['description'], $_POST['lien'], $_FILES['image'])) {
        $id_user = $_SESSION['user_id']; // Assurez-vous que l'utilisateur est connecté
        $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $lien = filter_var($_POST['lien'], FILTER_SANITIZE_URL);

        // Gestion de l'upload de l'image (BLOB)
        $image = null;

        // Vérifier si un fichier image a été téléchargé
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Lire l'image en binaire
            $image_data = file_get_contents($_FILES['image']['tmp_name']);
            $image = $image_data; // Assigner l'image binaire
        }

        // Ajouter le projet à la base de données (en utilisant BLOB pour l'image)
        if ($projectController->addProject($id_user, $titre, $description, $image, $lien)) {
            echo "Projet ajouté avec succès!";
        } else {
            echo "Erreur lors de l'ajout du projet!";
        }
    }

    // Supprimer un projet
    if (isset($_POST['delete_project'], $_POST['project_id'])) {
        $projectController->deleteProject();
    }
}

$projects = $projectController->showProjects($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des projets</title>
    <link rel="stylesheet" href="../public/css/edit_projet.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="../views/dashboard_user.php" class="back-btn">Retour</a> 

    <div class="edit_projet-container">
        <!-- Formulaire d'ajout de projet -->
        <form method="POST" class="form1" enctype="multipart/form-data">
            <h2>Ajouter un Projet</h2>
            <div class="form-group">
                <label for="titre">Titre du projet</label>
                <input type="text" name="titre" id="titre" placeholder="Entrez le titre de votre projet" required>
                <small>Indiquez le nom ou le titre de votre projet.</small>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Décrivez brièvement votre projet" required></textarea>
                <small>Fournissez une brève description du projet que vous souhaitez ajouter.</small>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" required>
                <small>Choisissez une image représentative de votre projet (jpg, png, etc.).</small>
            </div>
            <div class="form-group">
                <label for="lien">Lien vers le projet</label>
                <input type="url" name="lien" id="lien" placeholder="Entrez l'URL de votre projet" required>
                <small>Fournissez l'URL du projet ou du portfolio en ligne.</small>
            </div>

            <!-- Ajout du token CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <button type="submit" class="MAJ">Ajouter le projet</button>
        </form>

        <div class="project-cards">
            <h2>Mes Projets</h2>
            <?php foreach ($projects as $project): ?>
                <div class="card">
                    <div class="card1">
                        <?php if ($project['image']): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($project['image']); ?>" alt="<?= htmlspecialchars($project['titre']); ?>" />
                        <?php else: ?>
                            <img src="default-image.jpg" alt="Image par défaut" />
                        <?php endif; ?>
                    </div>
                    <div class="card2">
                        <h3><?= htmlspecialchars($project['titre']); ?></h3>
                        <p><?= htmlspecialchars($project['description']); ?></p>
                        <a href="<?= htmlspecialchars($project['lien']); ?>" target="_blank">Voir le projet</a>
                    </div>    
                    <div class="card3">
                        <!-- Formulaire pour supprimer le projet -->
                        <form action="edit_projet.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
                            <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id']); ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <button type="submit" class="MAJ" name="delete_project">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
