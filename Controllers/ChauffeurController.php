<?php
require_once __DIR__ . '/../Models/Managers/ChauffeurManager.php';
require_once 'AuthController.php';

class ChauffeurController
{
    private $ChauffeurManager;

    private $table = 'chauffeur';

    public function __construct()
    {
        $this->ChauffeurManager = new ChauffeurManager();
    }

    public function liste_chauffeur()
    {
        AuthController::checkRole('admin_principal');

        $chauffeurs = $this->ChauffeurManager->findAll($this->table);

        ob_start(); //Demarre l'enregistrement et capture le bout de code en dessous

        require_once  __DIR__ . "/../Views/gerer_chauffeur.php"; // ce code est capturer ne sera pas affiché

        $content = ob_get_clean(); //Arrete l'enregistrement et met tout le code html dans $content

        require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
    }

    public function insert_chauffeur()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->ChauffeurManager->nom_chauffeur = $_POST['nom'];
            $this->ChauffeurManager->telephone = $_POST['phone'];

            if ($this->ChauffeurManager->insert()) {
                header('Location:index.php?action=listeChauffeur');
            } else {
                header('Location:index.php?action=listeChauffeur');
            }
        }
    }

    public function edit_chauffeur()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->ChauffeurManager->update($_POST['id'], $_POST['nom'], $_POST['phone'])) {
                header('Location:index.php?action=listeChauffeur');
                //  echo "<script>alert('Modification reussi')</script>";
            } else {
                header('Location:index.php?action=listeChauffeur');
                //  echo "<script>alert('Modification echoué')</script>";
            }
        }
    }

    public function delete_chauffeur()
    {
        AuthController::checkRole('admin_principal');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->ChauffeurManager->delete($_GET['id'])) {
                header('Location:index.php?action=listeChauffeur');
                echo "<script>alert('Supression reussi')</script>";
            } else {
                header('Location:index.php?action=listeChauffeur');
                echo "<script>alert('Supression echoué')</script>";
            }
        }
    }

}
