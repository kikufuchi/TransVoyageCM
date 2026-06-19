<?php
require_once __DIR__ . '/../Models/Managers/UsersManagers.php';
require_once __DIR__ . '/../Models/Managers/AgenceManager.php';
require_once 'AuthController.php';

class AgenceController
{

    private $agenceManager;
    private $usersAdmin;
    private $table = 'agence';

    public function __construct()
    {
        $this->agenceManager = new AgenceManager();
        $this->usersAdmin = new UsersManagers();
    }

    public function liste_agence()
    {
        AuthController::checkRole('admin_principal');

        $allAgence = $this->agenceManager->findAll($this->table);
        $id_admins = array_map(function ($agence) {
            return $agence->id_admin;
        }, $allAgence);
        $nom_admins = array_map(function ($id_admin) {
            return $this->agenceManager->findByID($id_admin, 'utilisateur', 'id_users')->nom_users;
        }, $id_admins);

        $nom_adminP = $this->usersAdmin->findAdminP()->nom_users;
        // var_dump($nom_admin);
        // die('stop');
        ob_start(); //Demarre l'enregistrement et capture le bout de code en dessous

        $admins = $this->usersAdmin->findAvailableAdmin();
        require_once  __DIR__ . "/../Views/gerer_agences.php"; // ce code est capturer ne sera pas affiché

        $content = ob_get_clean(); //Arrete l'enregistrement et met tout le code html dans $content

        require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
    }

    public function insert_agence()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->agenceManager->ville = $_POST['ville'];
            $this->agenceManager->quartier = $_POST['brotherhood'];
            $this->agenceManager->nom_admin = $_POST['nomAdmin'];

            if ($this->agenceManager->insert()) {
                header('Location:index.php?action=listeAgence');
            } else {
                header('Location:index.php?action=listeAgence');
            }
        }
    }

    public function edit_agence()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->agenceManager->update($_POST['id'], $_POST['ville'], $_POST['brotherhood'], $_POST['nomAdmin'])) {
                header('Location:index.php?action=listeAgence');
                //  echo "<script>alert('Modification reussi')</script>";
            } else {
                header('Location:index.php?action=listeAgence');
                //  echo "<script>alert('Modification echoué')</script>";
            }
        }
    }

    public function delete_agence()
    {
        AuthController::checkRole('admin_principal');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->agenceManager->delete($_GET['id'])) {
                header('Location:index.php?action=listeAgence');
                echo "<script>alert('Supression reussi')</script>";
            } else {
                header('Location:index.php?action=listeAgence');
                echo "<script>alert('Supression echoué')</script>";
            }
        }
    }
}
