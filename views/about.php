<?php

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Porte-Folio</title>
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/about.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../includes/header.php'; ?>
<!-- Bannière -->
<section class="about-banner">
    <h1>Bienvenue sur Mon Portfolio</h1>
    <p>Découvrez mes compétences, mes projets et mon parcours professionnel.</p>
</section>

<!-- Contenu principal -->
<main class="about-container">
    <section class="about-intro">
        <h2>Qui suis-je ?</h2>
        <p>Je suis un développeur passionné, spécialisé en développement web et en gestion de projets. Mon objectif est de partager mes réalisations et de mettre en avant mes compétences techniques et créatives.</p>
    </section>

    <!-- Valeurs -->
    <section class="values">
        <h2>Mes Valeurs</h2>
        <div class="value-cards">
            <div class="value-card">
                <span>🚀</span>
                <h3>Innovation</h3>
                <p>J'aime explorer de nouvelles technologies et trouver des solutions créatives aux défis techniques.</p>
            </div>
            <div class="value-card">
                <span>🤝</span>
                <h3>Collaboration</h3>
                <p>Je crois fermement en l'importance du travail d'équipe et de l'échange de connaissances pour grandir ensemble.</p>
            </div>
            <div class="value-card">
                <span>🌍</span>
                <h3>Accessibilité</h3>
                <p>Je souhaite rendre la technologie accessible à tous, en créant des applications simples et efficaces.</p>
            </div>
        </div>
    </section>


    <!-- Contact -->
    <section class="contact">
        <h2>Contactez-moi</h2>
        <p>📧 Email : <a href="mailto:contact@monportfolio.com">contact@monportfolio.com</a></p>
        <p>📞 Téléphone : +33 6 12 34 56 78</p>
    </section>
</main>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
