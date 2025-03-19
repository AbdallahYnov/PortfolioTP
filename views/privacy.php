<?php
// Vérifier si la session est déjà active avant de l'initialiser
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de Confidentialité - FabLab</title>
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/privacy.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../includes/header.php'; ?>
<!-- Bannière -->
<section class="privacy-banner">
    <h1>Politique de Confidentialité</h1>
    <p>Découvrez comment je collecte, utilise et protège vos données personnelles sur mon portfolio en ligne.</p>
</section>

<!-- Contenu Principal -->
<main class="privacy-container">
    <section class="privacy-section">
        <h2>1. Introduction</h2>
        <p>Je m'engage à protéger la confidentialité de vos informations personnelles et à les traiter avec transparence, dans le respect de la législation en vigueur.</p>
    </section>

    <section class="privacy-section">
        <h2>2. Informations Collectées</h2>
        <p>Je collecte différentes catégories de données, notamment :</p>
        <ul>
            <li>Nom et prénom</li>
            <li>Adresse e-mail</li>
            <li>Données de navigation</li>
            <li>Historique des interactions et projets soumis</li>
        </ul>
    </section>

    <section class="privacy-section">
        <h2>3. Utilisation des Données</h2>
        <p>Les informations collectées sont utilisées pour :</p>
        <ul>
            <li>Fournir et améliorer l'accès à mon portfolio et mes projets</li>
            <li>Personnaliser votre expérience utilisateur</li>
            <li>Gérer vos informations de profil et vos projets</li>
            <li>Assurer la sécurité et la confidentialité de votre compte</li>
        </ul>
    </section>

    <section class="privacy-section">
        <h2>4. Partage des Données</h2>
        <p>Je ne partage pas vos données personnelles avec des tiers, sauf dans les cas suivants :</p>
        <ul>
            <li>Conformité aux obligations légales</li>
            <li>Services tiers nécessaires à l'exploitation du site (par exemple, hébergement, sécurité)</li>
        </ul>
    </section>

    <section class="privacy-section">
        <h2>5. Sécurité des Données</h2>
        <p>Je mets en place des mesures de sécurité pour protéger vos informations contre tout accès non autorisé ou abusif.</p>
    </section>

    <section class="privacy-section">
        <h2>6. Vos Droits</h2>
        <p>Vous avez le droit de :</p>
        <ul>
            <li>Accéder à vos données personnelles</li>
            <li>Les rectifier ou les supprimer</li>
            <li>Limiter leur traitement</li>
            <li>Vous opposer à leur utilisation dans certaines situations</li>
        </ul>
    </section>

    <section class="privacy-section">
        <h2>7. Contact</h2>
        <p>Pour toute question relative à ma politique de confidentialité, vous pouvez me contacter à : 
            <a href="mailto:contact@monportfolio.com">contact@monportfolio.com</a>
        </p>
    </section>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
