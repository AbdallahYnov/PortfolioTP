<?php
// Vérifier si la session est active avant de la démarrer
// session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - FabLab</title>
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/contact.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<!-- Bannière -->
<section class="contact-banner">
    <h1>Contactez-moi</h1>
    <p>Si vous avez des questions ou souhaitez discuter de mes projets, n'hésitez pas à me contacter.</p>
</section>

<!-- Contenu Principal -->
<main class="contact-container">
    <section class="contact-info">
        <h2>Informations de Contact</h2>
        <p><i class="fas fa-envelope"></i> Email : <a href="mailto:contact@monportfolio.com">contact@monportfolio.com</a></p>
        <p><i class="fas fa-phone"></i> Téléphone : +33 6 12 34 56 78</p>
        <p><i class="fas fa-map-marker-alt"></i> Adresse : 123 Rue de l'Informatique, Marseille, France</p>
    </section>

    <section class="contact-form">
        <h2>Envoyez-moi un message</h2>
        <form action="/backend/controllers/send_message.php" method="POST">
            <div class="form-group">
                <label for="name">Nom complet :</label>
                <input type="text" id="name" name="name" required placeholder="Votre nom">
            </div>
            
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required placeholder="Votre email">
            </div>
            
            <div class="form-group">
                <label for="message">Message :</label>
                <textarea id="message" name="message" rows="5" required placeholder="Votre message..."></textarea>
            </div>
            
            <button type="submit" class="btn-submit">Envoyer</button>
        </form>
    </section>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
