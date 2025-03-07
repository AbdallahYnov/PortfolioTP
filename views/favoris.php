<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes favoris</title>
    <link rel="stylesheet" href="../public/css/favoris.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <a href="<?php echo $_SESSION['role'] === 'admin' ? '../views/dashboard_admin.php' : '../views/dashboard_user.php'; ?>" class="back-btn">Retour</a>


    <div class="favoris-container">

        <div id="favoris">
            <h2>Affiche la liste des porte folio en favoris avec lien redirecteur vers le porte folio</h2>
        
        </div>

    </div>

    
    <?php include '../includes/footer.php'; ?>
</body>
</html>
