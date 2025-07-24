<?php
require_once '../config/database.php'; // Inclure la configuration de la base de données
require_once '../controllers/CompetenceUserController.php';

// Créer une instance du contrôleur
$competenceUserController = new CompetenceUserController($db);

// Ajouter une compétence
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur CSRF');
    }

    // Ajouter ou supprimer la compétence
    if (isset($_POST['id_competence']) && isset($_POST['niveau'])) {
        $competenceUserController->addCompetence();
    }
    if (isset($_POST['delete_competence']) && isset($_POST['competence_id'])) {
        $competenceUserController->deleteCompetence();
    }
}

// Récupérer les compétences de l'utilisateur
$competences = $competenceUserController->showCompetences($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Compétences</title>
    <link rel="stylesheet" href="../public/css/edit_competence.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="../views/dashboard_user.php" class="back-btn">Retour</a> 
    
    <div class="edit_competence-container">
        <form method="POST" class="form1">
            <h2>Ajouter une compétence</h2>
            
            <!-- Ajout du token CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <label for="id_competence">Compétence</label>
            <select name="id_competence" required>
                <?php
                // Utilisation de la méthode publique pour accéder à getAllCompetences et exclure les compétences déjà sélectionnées
                $competencesList = $competenceUserController->getCompetenceUserModel()->getAllCompetences($_SESSION['user_id']);
                foreach ($competencesList as $competence) {
                    echo "<option value='" . $competence['id'] . "'>" . htmlspecialchars($competence['nom']) . "</option>";
                }
                ?>
            </select>

            <label for="niveau">Niveau</label>
            <select name="niveau" required>
                <option value="débutant">Débutant</option>
                <option value="intermédiaire">Intermédiaire</option>
                <option value="expert">Expert</option>
            </select>

            <button type="submit" class="MAJ">Ajouter la compétence</button>
        </form>

        <div class="competences-tab">
            <h2>Mes compétences</h2>
            <table>
                <thead>
                    <tr>
                        <th>Compétence</th>
                        <th>Niveau</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($competences as $competence): ?>
                        <tr>
                            <td><?= htmlspecialchars($competence['nom']); ?></td>
                            <td><?= htmlspecialchars($competence['niveau']); ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?');">
                                    <input type="hidden" name="competence_id" value="<?= $competence['id_competence']; ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <button type="submit" class="MAJ" name="delete_competence">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
