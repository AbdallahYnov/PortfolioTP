<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour vérifier si l'utilisateur existe
    public function verifyUser($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return false;
    }

    // Méthode pour enregistrer un nouvel utilisateur
    public function registerUser($nom, $prenom, $email, $mot_de_passe, $photo, $cv, $telephone, $adresse, $cp, $ville, $role) {
        // Assainir les données
        $nom = htmlspecialchars(trim($nom), ENT_QUOTES, 'UTF-8');
        $prenom = htmlspecialchars(trim($prenom), ENT_QUOTES, 'UTF-8');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $telephone = htmlspecialchars(trim($telephone), ENT_QUOTES, 'UTF-8');
        $adresse = htmlspecialchars(trim($adresse), ENT_QUOTES, 'UTF-8');
        $cp = htmlspecialchars(trim($cp), ENT_QUOTES, 'UTF-8');
        $ville = htmlspecialchars(trim($ville), ENT_QUOTES, 'UTF-8');
        
       // Validation de l'email avant l'insertion dans la base de données
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; // Retourner false si l'email est invalide
        }

        // Hachage du mot de passe
        // $mot_de_passe = password_hash($mot_de_passe, PASSWORD_BCRYPT); // This line is removed

        // Vérification si l'email existe déjà
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Si l'email existe déjà, renvoyer false
            return false;
        }

        // Insertion de l'utilisateur dans la base de données avec la photo et le CV en BLOB
        $stmt = $this->db->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, photo, cv, telephone, adresse, cp, ville, role) 
                                    VALUES (:nom, :prenom, :email, :mot_de_passe, :photo, :cv, :telephone, :adresse, :cp, :ville, :role)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);
        $stmt->bindParam(':photo', $photo, PDO::PARAM_LOB);  // Spécifier que c'est un BLOB
        $stmt->bindParam(':cv', $cv, PDO::PARAM_LOB);  // Spécifier que c'est un BLOB
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    // Récupérer uniquement les utilisateurs avec le rôle 'user'
    public function getUsers() {
        $query = "SELECT * FROM users WHERE role = 'user'";  // Filtrer par rôle 'user'
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par son ID
    public function getUserById($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            return null; // Retourner null si l'ID est invalide
        }

        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Rechercher des utilisateurs
    public function searchUsers($searchTerm) {
        $searchTerm = htmlspecialchars(trim($searchTerm), ENT_QUOTES, 'UTF-8');
        $stmt = $this->db->prepare("SELECT * FROM users WHERE nom LIKE :searchTerm OR prenom LIKE :searchTerm OR email LIKE :searchTerm");
        $stmt->bindValue(':searchTerm', '%'.$searchTerm.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le rôle d'un utilisateur
    public function updateRole($user_id, $role) {
        $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
        $role = htmlspecialchars(trim($role), ENT_QUOTES, 'UTF-8');

        if ($user_id === false || empty($role)) {
            return false; // Retourner false si l'ID ou le rôle est invalide
        }

        $stmt = $this->db->prepare("UPDATE users SET role = :role WHERE id = :user_id");
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    // Supprimer un utilisateur
    public function deleteUser($user_id) {
        $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
        if ($user_id === false) {
            return false; // Retourner false si l'ID de l'utilisateur est invalide
        }

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

}
?>
