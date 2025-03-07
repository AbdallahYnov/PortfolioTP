<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour vérifier si l'utilisateur existe
    public function verifyUser($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return null;
    }

    // Méthode pour enregistrer un nouvel utilisateur
    public function registerUser($nom, $prenom, $email, $mot_de_passe, $photo, $telephone, $adresse, $cp, $ville, $role) {
        // Vérification si l'email existe déjà
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Si l'email existe déjà, renvoyer false
            return false;
        }
    
        // Insertion dans la base de données
        $stmt = $this->db->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, photo, telephone, adresse, cp, ville, role) 
                                    VALUES (:nom, :prenom, :email, :mot_de_passe, :photo, :telephone, :adresse, :cp, :ville, :role)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':role', $role);
    
        return $stmt->execute();
    }

     // Récupérer tous les utilisateurs
     public function getUsers() {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Rechercher des utilisateurs
    public function searchUsers($searchTerm) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE nom LIKE :searchTerm OR prenom LIKE :searchTerm OR email LIKE :searchTerm");
        $stmt->bindValue(':searchTerm', '%'.$searchTerm.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le rôle d'un utilisateur
    public function updateRole($user_id, $role) {
        $stmt = $this->db->prepare("UPDATE users SET role = :role WHERE id = :user_id");
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    // Supprimer un utilisateur
    public function deleteUser($user_id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }


    
    
}
?>
