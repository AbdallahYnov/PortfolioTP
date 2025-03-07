<?php
class CompetenceUser {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer les compétences d'un utilisateur
    public function getCompetencesByUser($id_user) {
        $query = "SELECT c.nom, cu.niveau, cu.id_competence 
                  FROM competences_user cu
                  JOIN competences c ON cu.id_competence = c.id 
                  WHERE cu.id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une compétence à l'utilisateur
    public function addCompetence($id_user, $id_competence, $niveau) {
        // Vérifier que les champs requis ne sont pas vides
        if (empty($id_competence) || empty($niveau)) {
            return false;
        }

        $query = "INSERT INTO competences_user (id_user, id_competence, niveau) 
                  VALUES (:id_user, :id_competence, :niveau)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_competence', $id_competence, PDO::PARAM_INT);
        $stmt->bindParam(':niveau', $niveau, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Supprimer une compétence de l'utilisateur
    public function deleteCompetence($id_user, $id_competence) {             
        $query = "DELETE FROM competences_user WHERE id_user = :id_user AND id_competence = :id_competence";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_competence', $id_competence, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupérer toutes les compétences disponibles
    public function getAllCompetences() {
        $query = "SELECT * FROM competences";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
