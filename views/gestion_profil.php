<?php
session_start();
require_once '../config/database.php'; 
require_once '../controllers/ProfilController.php';

// Créer une instance du contrôleur de profil
$profilController = new ProfilController($db);

// Vérifier et mettre à jour les informations de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur CSRF');
    }

    // Mise à jour du profil
    $profilController->updateUser();
}

// Récupérer les informations de l'utilisateur
$userData = $profilController->showProfil();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Profil</title>
    <link rel="stylesheet" href="../public/css/gestion_profil.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="../views/dashboard_user.php" class="back-btn">Retour</a> 

    <div class="gestion_profil-container">
        <h2>Modifier mon profil</h2>

        <!-- Formulaire de mise à jour du profil -->
        <form method="POST" enctype="multipart/form-data">

            <!-- Ajout du token CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="formulaire">
                <div class="form1">     
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" value="<?= isset($userData['nom']) ? htmlspecialchars($userData['nom']) : ''; ?>" required placeholder="Entrez votre nom">
                        <small>Indiquez votre nom de famille.</small>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom" value="<?= isset($userData['prenom']) ? htmlspecialchars($userData['prenom']) : ''; ?>" required placeholder="Entrez votre prénom">
                        <small>Indiquez votre prénom.</small>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= isset($userData['email']) ? htmlspecialchars($userData['email']) : ''; ?>" required placeholder="Entrez votre adresse email">
                        <small>Indiquez une adresse email valide.</small>
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo" accept="image/jpeg, image/png, image/gif">
                        <small>Si vous souhaitez changer votre photo, sélectionnez un fichier ici.</small>
                    </div>

                    <div class="form-group">
                        <label for="cv">CV (PDF)</label>
                        <input type="file" name="cv" id="cv" accept="application/pdf">
                        <small>Si vous souhaitez changer votre CV, sélectionnez un fichier PDF ici.</small>
                    </div>
                </div>

                <div class="form2">
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" value="<?= isset($userData['telephone']) ? htmlspecialchars($userData['telephone']) : ''; ?>" required placeholder="Entrez votre numéro de téléphone">
                        <small>Indiquez votre numéro de téléphone mobile ou fixe.</small>
                    </div>

                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" name="adresse" id="adresse" value="<?= isset($userData['adresse']) ? htmlspecialchars($userData['adresse']) : ''; ?>" required placeholder="Entrez votre adresse">
                        <small>Indiquez votre adresse complète (numéro, rue, etc.).</small>
                    </div>

                    <div class="form-group">
                        <label for="cp">Code Postal</label>
                        <input type="text" name="cp" id="cp" value="<?= isset($userData['cp']) ? htmlspecialchars($userData['cp']) : ''; ?>" required placeholder="Entrez votre code postal">
                        <small>Indiquez votre code postal.</small>
                    </div>

                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="ville" value="<?= isset($userData['ville']) ? htmlspecialchars($userData['ville']) : ''; ?>" required placeholder="Entrez votre ville">
                        <small>Indiquez la ville où vous résidez.</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="MAJ">Mettre à jour</button>

        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
