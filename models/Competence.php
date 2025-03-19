<?php
class Competence {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les compétences
    public function getCompetences() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM competences");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs en retournant un message d'erreur générique
            die("Erreur lors de la récupération des compétences: " . $e->getMessage());
        }
    }

    // Ajouter une nouvelle compétence
    public function addCompetence($competence_name) {
        // Assainir l'entrée pour éviter l'injection SQL et les attaques XSS
        $competence_name = htmlspecialchars(trim($competence_name), ENT_QUOTES, 'UTF-8');

        try {
            $stmt = $this->db->prepare("INSERT INTO competences (nom) VALUES (:competence_name)");
            $stmt->bindParam(':competence_name', $competence_name, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Gérer les erreurs en retournant un message d'erreur générique
            die("Erreur lors de l'ajout de la compétence: " . $e->getMessage());
        }
    }

    // Supprimer une compétence
    public function deleteCompetence($competence_id) {
        // Assurer que l'ID est un entier valide pour éviter l'injection SQL
        $competence_id = filter_var($competence_id, FILTER_VALIDATE_INT);

        if ($competence_id === false) {
            die("ID de compétence invalide.");
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM competences WHERE id = :competence_id");
            $stmt->bindParam(':competence_id', $competence_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Gérer les erreurs en retournant un message d'erreur générique
            die("Erreur lors de la suppression de la compétence: " . $e->getMessage());
        }
    }
}
?>
