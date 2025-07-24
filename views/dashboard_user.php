<?php
require_once '../config/database.php';
require_once '../controllers/ProjectController.php';
require_once '../controllers/CompetenceUserController.php'; 
require_once '../controllers/ProfilController.php'; 

// Vérification que l'utilisateur est connecté et qu'il n'est pas un admin
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] === 'admin') {
    header('Location: dashboard_admin.php');
    exit();
}


// Initialisation des contrôleurs
$projectController = new ProjectController($db);
$competenceUserController = new CompetenceUserController($db);
$profilController = new ProfilController($db);

// Récupérer les projets et compétences
$projects = $projectController->getProjectsSummary($_SESSION['user_id']);
$competences = $competenceUserController->showCompetences($_SESSION['user_id']);
$userInfo = $profilController->getUserInfo($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Utilisateur</title>
    <link rel="stylesheet" href="../public/css/dashboard_user.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="dashboard_user">
        <h2>Tableau de bord utilisateur</h2>

        <div id="dashboard_user">
            <div class="edit_link">
                <div class="edit-competence-link">
                    <a href="edit_competence.php" class="back-btn">Modifier mes compétences</a>
                    <div class="competence-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Compétence</th>
                                    <th>Niveau</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($competences as $competence): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($competence['nom']); ?></td>
                                        <td><?= htmlspecialchars($competence['niveau']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>   

                <div class="edit-projet-link">
                    <a href="edit_projet.php" class="back-btn">Modifier mes projets</a>
                    <div class="project-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td>
                                            <?php if ($project['image']): ?>
                                                <img src="data:image/jpeg;base64,<?= base64_encode($project['image']); ?>" alt="<?= htmlspecialchars($project['titre']); ?>" style="width: 100px; height: auto;" />
                                            <?php else: ?>
                                                <img src="default-image.jpg" alt="Image par défaut" style="width: 100px; height: auto;" />
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($project['titre']); ?></td>
                                        <td><?= htmlspecialchars($project['description']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>   

            <!-- Nouveau tableau pour afficher les informations de l'utilisateur -->
            <div class="user-info-link">
                <a href="../views/gestion_profil.php" class="back-btn">Mon profil</a> 
                <div class="user-info-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Champ</th>
                                <th>Valeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nom</td>
                                <td><?= htmlspecialchars($userInfo['nom']); ?></td>
                            </tr>
                            <tr>
                                <td>Prénom</td>
                                <td><?= htmlspecialchars($userInfo['prenom']); ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= htmlspecialchars($userInfo['email']); ?></td>
                            </tr>
                            <tr>
                                <td>Téléphone</td>
                                <td><?= htmlspecialchars($userInfo['telephone']); ?></td>
                            </tr>
                            <tr>
                                <td>Adresse</td>
                                <td><?= htmlspecialchars($userInfo['adresse']); ?></td>
                            </tr>
                            <tr>
                                <td>Code Postal</td>
                                <td><?= htmlspecialchars($userInfo['cp']); ?></td>
                            </tr>
                            <tr>
                                <td>Ville</td>
                                <td><?= htmlspecialchars($userInfo['ville']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="../views/porte_folio_user.php?user_id=<?= $_SESSION['user_id']; ?>" class="back-btn">Mon Porte - Folio</a>
            <a href="../views/presentation_profils_user.php" class="back-btn">Présentation des profils</a> 
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
