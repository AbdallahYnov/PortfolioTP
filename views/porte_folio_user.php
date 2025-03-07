<?php
session_start();
require_once '../config/database.php';
require_once '../controllers/ProfilController.php';
require_once '../controllers/ProjectController.php';
require_once '../controllers/CompetenceUserController.php';

$profilController = new ProfilController($db);
$projectController = new ProjectController($db);
$competenceUserController = new CompetenceUserController($db);

// Vérifier si l'ID de l'utilisateur est passé dans l'URL
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$userInfo = $profilController->getUserInfo($user_id);

// Récupérer les projets de l'utilisateur
$projects = $projectController->getProjectsSummary($user_id);

// Récupérer les compétences de l'utilisateur
$competences = $competenceUserController->showCompetences($user_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porte-Folio de l'utilisateur</title>
    <link rel="stylesheet" href="../public/css/porte_folio_user.css">
</head>
<body>
    <a href="dashboard_user.php" class="back-btn">Retour au tableau de bord</a>

    <div class="porte-folio-container">

        <div class="user-info">
            <!-- Affichage de la photo de l'utilisateur -->
            <div class="user-photo">
                <?php if ($userInfo['photo']): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($userInfo['photo']); ?>" alt="Photo de <?= htmlspecialchars($userInfo['prenom']); ?>">
                <?php else: ?>
                    <img src="default-image.jpg" alt="Photo par défaut">
                <?php endif; ?>
            </div>
            
            <!-- Affichage du prénom et nom -->
            <div class="user-name">
                <p><?= htmlspecialchars($userInfo['prenom']); ?></p>
                <p><?= htmlspecialchars($userInfo['nom']); ?></p>
            </div>
        </div>

        <h1>Mes Contacts</h1>
        <div class="user-contact">

            <!-- Div pour le numéro de téléphone -->
            <div class="contact-item">
                <?= htmlspecialchars($userInfo['telephone']); ?>
            </div>

            <!-- Div pour l'email -->
            <div class="contact-item">
                <?= htmlspecialchars($userInfo['email']); ?>
            </div>

            <!-- Div pour l'adresse postale -->
            <div class="contact-item">
                <?= htmlspecialchars($userInfo['adresse']); ?>, <?= htmlspecialchars($userInfo['cp']); ?>, <?= htmlspecialchars($userInfo['ville']); ?>
            </div>
        </div>

        <h1>Mes Compétences</h1>
        <div class="user-competences">
            <?php if (count($competences) > 0): ?>
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
            <?php else: ?>
                <p>Aucune compétence renseignée.</p>
            <?php endif; ?>
        </div>

        <h1>Mes Projets</h1>
        <div class="user-projects">
            <?php if (count($projects) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Lien</th>
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
                                <td><a href="<?= $project['lien']; ?>" class="MAJ" target="_blank">Voir le projet</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun projet renseigné.</p>
            <?php endif; ?>
        </div>

        <div class="user-cv">
        <h1>Mon CV</h1>
        <?php if ($userInfo['CV']): ?>
            <a href="data:application/pdf;base64,<?= base64_encode($userInfo['CV']); ?>" download="Mon_CV.pdf" class="download-btn">
                Télécharger mon CV
            </a>
        <?php else: ?>
            <p>Aucun CV téléchargé.</p>
        <?php endif; ?>
    </div>

    </div>















</body>
</html>
