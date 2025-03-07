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
        $query = "SELECT * FROM users WHERE id = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Autres méthodes pour la mise à jour du profil
    public function updateUserInfo($id_user, $nom, $prenom, $email, $photo, $cv, $telephone, $adresse, $cp, $ville) {
        // Logique de mise à jour du profil
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
        
        return $stmt->execute();
    }
}

?>
