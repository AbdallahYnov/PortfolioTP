<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
    <link rel="stylesheet" href="../public/css/new_password.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Gestion du nouveau mot de passe</h1>
  




    <!-- Afficher les informations de l'utilisateur -->
    <table>
        <tr><td>Nom</td><td><?= htmlspecialchars($userInfo['nom']); ?></td></tr>
        <tr><td>Prénom</td><td><?= htmlspecialchars($userInfo['prenom']); ?></td></tr>
        <tr><td>Email</td><td><?= htmlspecialchars($userInfo['email']); ?></td></tr>
        <tr><td>Téléphone</td><td><?= htmlspecialchars($userInfo['telephone']); ?></td></tr>
        <tr><td>Adresse</td><td><?= htmlspecialchars($userInfo['adresse']); ?></td></tr>
        <tr><td>Code Postal</td><td><?= htmlspecialchars($userInfo['cp']); ?></td></tr>
        <tr><td>Ville</td><td><?= htmlspecialchars($userInfo['ville']); ?></td></tr>
    </table>

    <!-- Afficher les projets -->
    <h3>Projets</h3>
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
                            <img src="data:image/jpeg;base64,<?= base64_encode($project['image']); ?>" alt="<?= $project['titre']; ?>" style="width: 100px; height: auto;" />
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

    <!-- Afficher les compétences -->
    <h3>Compétences</h3>
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

    
    <?php include '../includes/footer.php'; ?>
</body>
</html>
