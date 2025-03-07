<?php
session_start();
include_once('../models/User.php');
include_once('../config/database.php');

$userModel = new User($db);

// Vérification de l'action de la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Connexion
        $user = $userModel->verifyUser($_POST['email'], $_POST['password']);
        if ($user) {
            // Enregistrer l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
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
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mot_de_passe']) && isset($_POST['confirm_password'])) {
    
    if ($_POST['mot_de_passe'] === $_POST['confirm_password']) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        $role = 'user';
        
        // Gestion de la photo
        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photo = 'uploads/' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        }

        // Autres informations
        $telephone = $_POST['telephone'] ?? null;
        $adresse = $_POST['adresse'] ?? null;
        $cp = $_POST['cp'] ?? null;
        $ville = $_POST['ville'] ?? null;

        // Enregistrement de l'utilisateur
        $result = $userModel->registerUser($nom, $prenom, $email, $mot_de_passe, $photo, $telephone, $adresse, $cp, $ville, $role);

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
