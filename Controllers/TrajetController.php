<?php
require_once __DIR__ . '/../Models/Managers/TrajetManager.php';
require_once 'AuthController.php';

class TrajetController
{

    private $trajetManager;

    private $table = 'trajet';

    public function __construct()
    {
        $this->trajetManager = new TrajetManager();
    }

    public function liste_trajet()
    {
        AuthController::checkRole('admin_principal');

        $journays = $this->trajetManager->findAll($this->table);

        ob_start(); //Demarre l'enregistrement et capture le bout de code en dessous

        require_once  __DIR__ . "/../Views/gerer_trajets.php"; // ce code est capturer ne sera pas affiché

        $content = ob_get_clean(); //Arrete l'enregistrement et met tout le code html dans $content

        require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
    }

    public function insert_trajet()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->trajetManager->ville_depart = $_POST['depart'];
            $this->trajetManager->ville_arrivee = $_POST['arrivee'];

            if ($this->trajetManager->insert()) {
                header('Location:index.php?action=listeTrajet');
            } else {
                header('Location:index.php?action=listeTrajet');
            }
        }
    }

    public function edit_trajet()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->trajetManager->update($_POST['id'], $_POST['depart'], $_POST['arrivee'])) {
                header('Location:index.php?action=listeTrajet');
                //  echo "<script>alert('Modification reussi')</script>";
            } else {
                header('Location:index.php?action=listeTrajet');
                //  echo "<script>alert('Modification echoué')</script>";
            }
        }
    }

    public function delete_trajet()
    {
        AuthController::checkRole('admin_principal');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->trajetManager->delete($_GET['id'])) {
                header('Location:index.php?action=listeTrajet');
                echo "<script>alert('Supression reussi')</script>";
            } else {
                header('Location:index.php?action=listeTrajet');
                echo "<script>alert('Supression echoué')</script>";
            }
        }
    }
}
