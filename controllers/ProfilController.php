<?php
require_once '../models/Profil.php';

class ProfilController {
    private $db;
    private $profilModel;

    public function __construct($db) {
        $this->db = $db;
        $this->profilModel = new Profil($this->db);
    }

    // Méthode pour récupérer les informations de l'utilisateur
    public function getUserInfo($id_user) {
        $query = "SELECT * FROM users WHERE id = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour afficher les informations du profil
    public function showProfil() {
        $userData = $this->profilModel->showProfil($_SESSION['user_id']);
        return $userData;
    }

    // Mise à jour du profil utilisateur
    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Protection CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Erreur CSRF');
            }

            // Assainissement des entrées utilisateur pour éviter XSS
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
            $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_STRING);
            $cp = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_STRING);
            $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_STRING);

            // Validation de l'email (s'assurer qu'il est valide)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "L'email n'est pas valide.";
                exit;
            }

            // Gestion de la photo (en BLOB)
            $photo = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                if ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/png') {
                    $photo = file_get_contents($_FILES['photo']['tmp_name']);
                } else {
                    echo "Format de photo invalide.";
                    exit;
                }
            }

            // Gestion du CV (en BLOB)
            $cv = null;
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
                if ($_FILES['cv']['type'] == 'application/pdf') {
                    $cv = file_get_contents($_FILES['cv']['tmp_name']);
                } else {
                    echo "Format de CV invalide.";
                    exit;
                }
            }

            // Si pas de fichier photo, garder l'ancienne photo
            if ($photo === null) {
                $currentUserData = $this->profilModel->getUserData($_SESSION['user_id']);
                $photo = $currentUserData['photo'];  // Garder la photo existante
            }

            // Si pas de fichier CV, garder l'ancien CV
            if ($cv === null) {
                $currentUserData = $this->profilModel->getUserData($_SESSION['user_id']);
                $cv = $currentUserData['CV'];  // Garder le CV existant
            }

            // Appeler la méthode de mise à jour du modèle
            if ($this->profilModel->updateUserInfo($_SESSION['user_id'], $nom, $prenom, $email, $photo, $cv, $telephone, $adresse, $cp, $ville)) {
                // Rediriger vers le tableau de bord de l'utilisateur
                header("Location: /views/dashboard_user.php");
                exit();
            } else {
                echo "Erreur lors de la mise à jour du profil.";
            }
        }
    }
}
?>
