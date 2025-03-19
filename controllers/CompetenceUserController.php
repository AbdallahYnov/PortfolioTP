<?php
require_once '../models/CompetenceUser.php';

class CompetenceUserController {
    private $db;
    private $competenceUserModel;

    public function __construct($db) {
        $this->db = $db;
        $this->competenceUserModel = new CompetenceUser($this->db);
    }

    // Méthode publique pour accéder au modèle CompetenceUser
    public function getCompetenceUserModel() {
        return $this->competenceUserModel;
    }

    // Ajouter une compétence à l'utilisateur
    public function addCompetence() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Protection CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Erreur CSRF');
            }

            // Validation et assainissement des entrées utilisateur
            $id_competence = filter_input(INPUT_POST, 'id_competence', FILTER_SANITIZE_NUMBER_INT); // Assainir l'ID de compétence
            $niveau = filter_input(INPUT_POST, 'niveau', FILTER_SANITIZE_STRING); // Assainir le niveau

            // Vérification des champs
            if ($id_competence && $niveau) {
                if ($this->competenceUserModel->addCompetence($_SESSION['user_id'], $id_competence, $niveau)) {
                    echo "Compétence ajoutée avec succès!";
                } else {
                    echo "Erreur lors de l'ajout de la compétence!";
                }
            } else {
                echo "Tous les champs doivent être remplis.";
            }
        }
    }

    // Récupérer toutes les compétences disponibles, excluant celles déjà ajoutées par l'utilisateur
    public function getAllCompetences($id_user) {
        return $this->competenceUserModel->getAllCompetences($id_user);
    }

    // Récupérer les compétences d'un utilisateur
    public function showCompetences($id_user) {
        return $this->competenceUserModel->getCompetencesByUser($id_user);
    }

    // Supprimer une compétence de l'utilisateur
    public function deleteCompetence() {
        if (isset($_POST['delete_competence']) && isset($_POST['competence_id'])) {
            // Protection CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Erreur CSRF');
            }

            // Validation et assainissement de l'ID de la compétence
            $id_competence = filter_input(INPUT_POST, 'competence_id', FILTER_SANITIZE_NUMBER_INT);

            if ($this->competenceUserModel->deleteCompetence($_SESSION['user_id'], $id_competence)) {
                header("Location: /views/edit_competence.php"); // Redirige vers la page des compétences après suppression
                exit();
            } else {
                echo "Erreur lors de la suppression de la compétence.";
            }
        }
    }
}

?>
