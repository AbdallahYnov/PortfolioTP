<?php
// Vérifie si la session n'est pas déjà démarrée pour éviter l'erreur
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarre la session si elle n'est pas déjà active
}

// Régénérer l'ID de session pour éviter les attaques de fixation de session
session_regenerate_id(true);

// Inclure la gestion du timeout de session pour les déconnexions automatiques
include('../controllers/session_timeout.php');
?>

<header>
    <div class="logo">
        <a href="../views/index.php">
            <img src="../public/image/logo.png" alt="Logo du Portfolio" />
        </a>
    </div>
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Si l'utilisateur est connecté, afficher le bouton Déconnexion -->
                <li><a href="../controllers/logout.php" class="login-bouton">Déconnexion</a></li>
            <?php else: ?>
                <!-- Si l'utilisateur n'est pas connecté, afficher le bouton Connexion -->
                <li><a href="login.php" class="login-bouton">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
