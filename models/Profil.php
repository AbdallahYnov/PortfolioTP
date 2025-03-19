<?php
class Profil {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function showProfil($id_user) {
        return $this->getUserData($id_user);
    }

    // Ajouter la méthode pour récupérer les données de l'utilisateur
    public function getUserData($id_user) {
        // Validation de l'ID utilisateur pour s'assurer qu'il est valide
        $id_user = filter_var($id_user, FILTER_VALIDATE_INT);
        if ($id_user === false) {
            return null; // Retourner null si l'ID est invalide
        }

        $query = "SELECT * FROM users WHERE id = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Autres méthodes pour la mise à jour du profil
    public function updateUserInfo($id_user, $nom, $prenom, $email, $photo, $cv, $telephone, $adresse, $cp, $ville) {
        // Validation et assainissement des données
        $nom = htmlspecialchars(trim($nom), ENT_QUOTES, 'UTF-8');
        $prenom = htmlspecialchars(trim($prenom), ENT_QUOTES, 'UTF-8');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $telephone = htmlspecialchars(trim($telephone), ENT_QUOTES, 'UTF-8');
        $adresse = htmlspecialchars(trim($adresse), ENT_QUOTES, 'UTF-8');
        $cp = htmlspecialchars(trim($cp), ENT_QUOTES, 'UTF-8');
        $ville = htmlspecialchars(trim($ville), ENT_QUOTES, 'UTF-8');

        // Vérification de la validité de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; // Retourne false si l'email n'est pas valide
        }

        // Vérification des fichiers (photo et CV)
        if ($photo !== null && !is_string($photo)) {
            $photo = null; // Si la photo n'est pas valide, on la met à null
        }
        if ($cv !== null && !is_string($cv)) {
            $cv = null; // Si le CV n'est pas valide, on le met à null
        }

        // Construction de la requête SQL pour mettre à jour les informations de l'utilisateur
        $query = "UPDATE users SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    photo = :photo,
                    CV = :cv,
                    telephone = :telephone,
                    adresse = :adresse,
                    cp = :cp,
                    ville = :ville
                  WHERE id = :id_user";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $photo, PDO::PARAM_LOB);
            $stmt->bindParam(':cv', $cv, PDO::PARAM_LOB);
            $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':cp', $cp, PDO::PARAM_STR);
            $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);

            return $stmt->execute(); // Exécution de la requête
        } catch (PDOException $e) {
            // Gestion des erreurs et exception
            die("Erreur lors de la mise à jour du profil : " . $e->getMessage());
        }
    }
}
?>
