<?php
class Projet {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer les projets d'un utilisateur
    public function getProjectsByUser($id_user) {
        // Validation de l'ID utilisateur
        $id_user = filter_var($id_user, FILTER_VALIDATE_INT);
        if ($id_user === false) {
            return []; // Retourner un tableau vide si l'ID est invalide
        }

        $query = "SELECT * FROM projets_user WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un projet
    public function addProject($id_user, $titre, $description, $image, $lien) {
        // Validation et assainissement des données d'entrée
        $titre = htmlspecialchars(trim($titre), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars(trim($description), ENT_QUOTES, 'UTF-8');
        $lien = filter_var($lien, FILTER_SANITIZE_URL); // Assainir l'URL pour éviter les XSS

        // Vérifier que les champs requis ne sont pas vides
        if (empty($titre) || empty($description) || empty($lien)) {
            return false; // Retourner false si les champs sont vides
        }

        // Validation de l'ID utilisateur
        $id_user = filter_var($id_user, FILTER_VALIDATE_INT);
        if ($id_user === false) {
            return false; // Retourner false si l'ID utilisateur est invalide
        }

        // Si une image est fournie, la traiter
        if ($image !== null && !is_string($image)) {
            return false; // Si l'image n'est pas valide, retourner false
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
        // Validation de l'ID du projet
        $id_project = filter_var($id_project, FILTER_VALIDATE_INT);
        if ($id_project === false) {
            return false; // Retourner false si l'ID du projet est invalide
        }

        $query = "DELETE FROM projets_user WHERE id = :id_project";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_project', $id_project, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
