<?php
include_once('../models/User.php');  
include_once('../config/database.php');

// Vérification de l'action de la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Protection contre CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erreur CSRF');
    }

    // Instancier le modèle User
    $userModel = new User($db);

    // Connexion
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);  // Assainir l'email
        $password = $_POST['password']; // Pas besoin de filtrer ici, le hash se fait en base

        // Vérification de l'utilisateur
        $user = $userModel->verifyUser($email, $password);
        if ($user) {
            // Enregistrer l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Récupérer et stocker le rôle de l'utilisateur

            // Rediriger l'utilisateur selon son rôle
            if ($user['role'] === 'admin') {
                header('Location: ../views/dashboard_admin.php');
                exit;
            } else {
                header('Location: ../views/dashboard_user.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Identifiants incorrects';
            header('Location: ../views/login.php');
            exit;
        }
    }



    // Inscription de l'utilisateur
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mot_de_passe'], $_POST['confirm_password'])) {
        if ($_POST['mot_de_passe'] === $_POST['confirm_password']) {
            // Assainissement des entrées
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $mot_de_passe = password_hash(trim($_POST['mot_de_passe']), PASSWORD_DEFAULT);
            $role = 'user'; // Par défaut, le rôle est "user"

            // Gestion de la photo
            $photo = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $photo = file_get_contents($_FILES['photo']['tmp_name']); // Lire l'image en tant que BLOB
            }

            // Gestion du CV
            $cv = null;
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
                $cv = file_get_contents($_FILES['cv']['tmp_name']); // Lire le CV en tant que BLOB
            }

            // Autres informations
            $telephone = $_POST['telephone'] ?? null;
            $adresse = $_POST['adresse'] ?? null;
            $cp = $_POST['cp'] ?? null;
            $ville = $_POST['ville'] ?? null;

            // Enregistrement de l'utilisateur
            $result = $userModel->registerUser($nom, $prenom, $email, $mot_de_passe, $photo, $cv, $telephone, $adresse, $cp, $ville, $role);

            if ($result) {
                $_SESSION['success'] = 'Inscription réussie, vous pouvez vous connecter';
                header('Location: ../views/login.php');
                exit;
            } else {
                $_SESSION['error'] = 'Erreur : L\'email existe déjà';
                header('Location: ../views/login.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
            header('Location: ../views/login.php');
            exit;
        }
    }
}
?>
