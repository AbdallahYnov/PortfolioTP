<?php
// Vérifier si la session est déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aide - FabLab</title>
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/help.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../includes/header.php'; ?>
<!-- Bannière de la page Aide -->
<section class="help-banner">
    <h1>Besoin d'Aide ?</h1>
    <p>Trouvez des réponses à vos questions et apprenez à utiliser votre portfolio efficacement.</p>
</section>

<!-- Contenu principal -->
<main class="help-container">
    <h2 class="help-title">Guide d'utilisation</h2>
    
    <div class="help-section">
        <h3>🚀 Comment ajouter un projet à mon portfolio ?</h3>
        <p>Accédez à la section <strong>"Mes Projets"</strong> dans votre tableau de bord, cliquez sur "Ajouter un projet", remplissez les informations nécessaires (titre, description, image et lien) et validez la création de votre projet.</p>
    </div>

    <div class="help-section">
        <h3>🖨️ Comment mettre à jour mes compétences ?</h3>
        <p>Dans la section <strong>"Mes Compétences"</strong>, vous pouvez ajouter de nouvelles compétences, les modifier ou les supprimer. Vous pouvez également définir un niveau de compétence pour chaque domaine (par exemple, débutant, intermédiaire, expert).</p>
    </div>

    <div class="help-section">
        <h3>📦 Comment organiser mes projets ?</h3>
        <p>Vous pouvez organiser vos projets par catégories ou par ordre de priorité. Chaque projet peut être édité pour refléter vos dernières mises à jour ou ajouts. Assurez-vous que chaque projet est bien détaillé pour mettre en avant vos réalisations.</p>
    </div>

    <div class="help-section">
        <h3>⚠️ Que faire si je rencontre un problème avec mon projet ?</h3>
        <p>Si vous rencontrez un problème technique avec votre projet ou des erreurs lors de l'ajout de contenu, n'hésitez pas à consulter la section "FAQ" ou à nous contacter pour une assistance personnalisée.</p>
    </div>

    <div class="help-section">
        <h3>📞 Besoin d'une assistance ?</h3>
        <p>Contactez-nous par email à <a href="mailto:support@monportfolio.com">support@monportfolio.com</a> ou par téléphone au +33 6 12 34 56 78.</p>
    </div>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
