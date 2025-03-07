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


    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $adresse = $_POST['adresse'];
            $cp = $_POST['cp'];
            $ville = $_POST['ville'];

            // Récupérer la photo (en BLOB)
            $photo = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                if ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/png') {
                    $photo = file_get_contents($_FILES['photo']['tmp_name']);
                }
            }

            // Récupérer le CV (en BLOB)
            $cv = null;
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
                if ($_FILES['cv']['type'] == 'application/pdf') {
                    $cv = file_get_contents($_FILES['cv']['tmp_name']);
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
                header("Location: dashboard_user.php");
                exit();
            } else {
                echo "Erreur lors de la mise à jour du profil.";
            }
        }
    }
}

?>
