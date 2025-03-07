<?php
class Competence {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les compétences
    public function getCompetences() {
        $stmt = $this->db->prepare("SELECT * FROM competences");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une nouvelle compétence
    public function addCompetence($competence_name) {
        $stmt = $this->db->prepare("INSERT INTO competences (nom) VALUES (:competence_name)");
        $stmt->bindParam(':competence_name', $competence_name);
        return $stmt->execute();
    }

    // Supprimer une compétence
    public function deleteCompetence($competence_id) {
        $stmt = $this->db->prepare("DELETE FROM competences WHERE id = :competence_id");
        $stmt->bindParam(':competence_id', $competence_id);
        return $stmt->execute();
    }
}
?>
