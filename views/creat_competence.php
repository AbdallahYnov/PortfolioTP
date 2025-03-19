<?php
session_start();
include_once('../models/Competence.php');
include_once('../config/database.php');


// Initialisation du modèle de compétences
$competenceModel = new Competence($db);

// Vérification que l'utilisateur est connecté et qu'il a le rôle 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Si l'utilisateur n'est pas admin, rediriger vers la page de connexion ou dashboard utilisateur
    header('Location: login.php');
    exit();
}

// Vérification et ajout d'une compétence si le formulaire est soumis
if (isset($_POST['add_competence'])) {
    // Protection contre XSS : assainir l'entrée
    $competence_name = htmlspecialchars($_POST['competence_name'], ENT_QUOTES, 'UTF-8');

    // Ajouter la compétence à la base de données
    if (!empty($competence_name)) {
        $competenceModel->addCompetence($competence_name);
        header('Location: creat_competence.php'); // Redirige pour éviter une double soumission
        exit;
    }
}

// Supprimer une compétence si le bouton de suppression est cliqué
if (isset($_POST['delete_competence'])) {
    $competence_id = filter_var($_POST['competence_id'], FILTER_VALIDATE_INT);

    // Vérification de l'ID de compétence
    if ($competence_id !== false) {
        $competenceModel->deleteCompetence($competence_id);
        header('Location: creat_competence.php'); // Redirige après suppression
        exit;
    }
}

// Récupérer toutes les compétences
$competences = $competenceModel->getCompetences();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer et gérer les compétences</title>
    <link rel="stylesheet" href="../public/css/creat_competence.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="../views/dashboard_admin.php" class="back-btn">Retour</a> 

    <div class="gestion_competences-container">
        <h2>Gestion des compétences</h2>
        
        <!-- Formulaire pour ajouter une nouvelle compétence -->
        <form action="creat_competence.php" method="post">
            <!-- Ajout d'un token CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <label for="competence_name">Nom de la compétence :</label>
            <input type="text" id="competence_name" name="competence_name" required>
            <button type="submit" name="add_competence">Ajouter la compétence</button>
        </form>

        <!-- Tableau des compétences -->
        <table>
            <thead>
                <tr>
                    <th>Nom de la compétence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($competences as $competence): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($competence['nom'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <!-- Formulaire pour supprimer une compétence -->
                            <form action="creat_competence.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?');">
                                <input type="hidden" name="competence_id" value="<?php echo $competence['id']; ?>">
                                <button type="submit" name="delete_competence">Supprimer</button>
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
