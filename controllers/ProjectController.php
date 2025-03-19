<?php
require_once '../models/Project.php';

class ProjectController {
    private $db;
    private $projetModel;

    public function __construct($db) {
        $this->db = $db;  
        $this->projetModel = new Projet($this->db);  
    }

    public function addProject() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Protection CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Erreur CSRF');
            }

            // Assainir les entrées utilisateurs pour éviter XSS
            $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8') : null;
            $description = isset($_POST['description']) ? htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8') : null;
            $lien = isset($_POST['lien']) ? htmlspecialchars($_POST['lien'], ENT_QUOTES, 'UTF-8') : null;

            // Si un fichier image est envoyé, on le traite
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Vérification de l'extension et du type MIME de l'image
                if ($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/png') {
                    $imageData = file_get_contents($_FILES['image']['tmp_name']);
                    $image = $imageData;
                } else {
                    echo "Format de fichier image invalide.";
                    exit;
                }
            }

            if ($titre && $description && $lien) {
                if ($this->projetModel->addProject($_SESSION['user_id'], $titre, $description, $image, $lien)) {
                    echo "Projet ajouté avec succès!";
                } else {
                    echo "Erreur lors de l'ajout du projet!";
                }
            } else {
                echo "Tous les champs doivent être remplis.";
            }
        }
    }
    
    // Méthode pour récupérer et afficher les projets
    public function showProjects($id_user) {
        // Vérification que l'objet $this->projetModel est bien initialisé
        if ($this->projetModel !== null) {
            $projects = $this->projetModel->getProjectsByUser($id_user);
            return $projects;
        } else {
            echo "Erreur : l'objet Projet n'est pas correctement initialisé.";
        }
    }      
    
    // Méthode dans le contrôleur pour récupérer les projets
    public function getProjectsSummary($id_user) {
        return $this->projetModel->getProjectsByUser($id_user);
    }
    
    // Méthode pour supprimer un projet
    public function deleteProject() {
        if (isset($_POST['delete_project']) && isset($_POST['project_id'])) {
            // Protection CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Erreur CSRF');
            }

            // Validation et assainissement de l'ID du projet
            $id_project = filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_NUMBER_INT);

            if ($this->projetModel->deleteProject($id_project)) {
                header("Location: ../views/edit_projet.php"); // Redirige vers la page des projets après suppression
                exit();
            } else {
                echo "Erreur lors de la suppression du projet.";
            }
        }
    }
}
?>
