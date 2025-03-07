<?php
class Projet {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProjectsByUser($id_user) {
        $query = "SELECT * FROM projets_user WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addProject($id_user, $titre, $description, $image, $lien) {
        // Vérifier que les champs requis ne sont pas vides
        if (empty($titre) || empty($description) || empty($lien)) {
            return false;
        }

        $query = "INSERT INTO projets_user (id_user, titre, description, image, lien) 
                VALUES (:id_user, :titre, :description, :image, :lien)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_LOB); // Type BLOB pour l'image
        $stmt->bindParam(':lien', $lien, PDO::PARAM_STR);
        
        return $stmt->execute();
    }


    // Supprimer un projet
    public function deleteProject($id_project) {             
        $query = "DELETE FROM projets_user WHERE id = :id_project";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_project', $id_project, PDO::PARAM_INT);
        return $stmt->execute();
    }

    
}
?>

