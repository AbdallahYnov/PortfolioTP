<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
            <!-- Si l'utilisateur est connecté, on affiche le bouton Déconnexion -->
            <li><a href="../controllers/logout.php" class="login-bouton">Déconnexion</a></li>
        <?php else: ?>
            <!-- Si l'utilisateur n'est pas connecté, on affiche le bouton Connexion -->
            <li><a href="login.php" class="login-bouton">Connexion</a></li>
        <?php endif; ?>
        </ul>
    </nav>
</header>
