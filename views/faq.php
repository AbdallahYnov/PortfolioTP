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
    <title>FAQ - FabLab</title>
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/faq.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../includes/header.php'; ?>

<!-- Bannière améliorée -->
<section class="faq-banner">
    <h1>Foire Aux Questions (FAQ)</h1>
    <p>Retrouvez ici les réponses aux questions les plus courantes concernant la gestion de mon portfolio, mes projets et mes compétences.</p>
</section>

<!-- Contenu principal -->
<main class="faq-container">
    <h2 class="faq-title">Questions Fréquentes</h2>
    <div class="faq">

        <div class="faq-item">
            <button class="faq-question">Comment ajouter un projet à mon portfolio ?</button>
            <div class="faq-answer">
                <p>Pour ajouter un projet, connectez-vous à votre compte, accédez à la section "Mes Projets" et remplissez le formulaire avec le titre, la description, l'image et le lien externe. Vous pourrez ensuite publier et modifier votre projet à tout moment.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">Comment mettre à jour mes compétences ?</button>
            <div class="faq-answer">
                <p>Dans la section "Mes Compétences", vous pouvez ajouter, modifier ou supprimer des compétences. Vous pouvez également définir un niveau de compétence (débutant, intermédiaire, expert) pour chaque compétence afin de mettre en valeur vos points forts.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">Comment sécuriser mon compte sur le portfolio ?</button>
            <div class="faq-answer">
                <p>Nous utilisons un système d'authentification sécurisé avec mot de passe haché. Pensez à choisir un mot de passe fort et à activer l'option "Se souvenir de moi" pour simplifier vos connexions futures.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">Puis-je partager mon portfolio avec d'autres personnes ?</button>
            <div class="faq-answer">
                <p>Oui, une fois votre portfolio en ligne, vous pouvez partager le lien de votre page avec des employeurs, collègues ou toute autre personne. Vous pouvez également intégrer vos projets dans d'autres sites si vous le souhaitez.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">Comment ajouter une image à un projet ?</button>
            <div class="faq-answer">
                <p>Pour ajouter une image à votre projet, cliquez sur l'option "Ajouter une image" lors de la création ou de la modification de votre projet. Vous pourrez télécharger des fichiers au format JPEG, PNG ou GIF. Assurez-vous que l'image respecte la taille et les formats autorisés.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">Comment puis-je modifier mes informations personnelles ?</button>
            <div class="faq-answer">
                <p>Dans la section "Mon Profil", vous pouvez facilement mettre à jour vos informations personnelles comme votre nom, email et autres détails. N'oubliez pas de sauvegarder vos modifications après chaque mise à jour.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">Quels sont les formats de fichiers acceptés pour les projets ?</button>
            <div class="faq-answer">
                <p>Pour les projets de développement, vous pouvez télécharger des fichiers au format ZIP, ainsi que des liens vers des GitHub ou autres référentiels externes. Assurez-vous que votre projet est bien organisé et compréhensible pour les visiteurs.</p>
            </div>
        </div>

    </div>
</main>

<!-- Script pour afficher les réponses aux questions -->
<script>
document.querySelectorAll(".faq-question").forEach(button => {
    button.addEventListener("click", () => {
        button.classList.toggle("active");
        let answer = button.nextElementSibling;
        if (answer.style.maxHeight) {
            answer.style.maxHeight = null;
        } else {
            answer.style.maxHeight = answer.scrollHeight + "px";
        }
    });
});
</script>


<?php include_once __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
