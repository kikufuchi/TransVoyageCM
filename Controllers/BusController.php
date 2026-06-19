<?php
require_once __DIR__ . '/../Models/Managers/BusManager.php';
require_once __DIR__ . '/../Models/Managers/PlaceManager.php';
require_once 'AuthController.php';

class BusController
{
    private $busManager;
    private $placeManager;
    private $table = 'bus';

    public function __construct()
    {
        $this->busManager = new BusManager();
        $this->placeManager = new PlaceManager();
    }

    public function liste_bus()
    {
        AuthController::checkRole('admin_principal');
        
        $allBus = $this->busManager->findAll($this->table);
        $totalPlace = []; 
        $busWithoutPlace = $this->busManager->findWithoutPlace();

        foreach ($allBus as $bus) {
            $totalPlace[] = $this->placeManager->findNumberPlace($bus->id_bus);
            $bus->nbrPlace = $this->placeManager->findNumberPlace($bus->id_bus);
        }
        
        ob_start(); //Demarre l'enregistrement et capture le bout de code en dessous

        require_once  __DIR__ . "/../Views/gerer_bus.php"; // ce code est capturer ne sera pas affiché

        $content = ob_get_clean(); //Arrete l'enregistrement et met tout le code html dans $content

        require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
    }

    public function insert_bus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->busManager->nom_bus = $_POST['nom'];
            $this->busManager->capacite = $_POST['capacite'];
            $this->busManager->categorie = $_POST['categorie'];
            $this->busManager->etat = $_POST['etat'];

            if ($this->busManager->insert()) {
                header('Location:index.php?action=listeBus');
            } else {
                header('Location:index.php?action=listeBus');
            }
        }
    }

    public function edit_bus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->busManager->update($_POST['id'], $_POST['nom'], $_POST['capacite'], $_POST['categorie'], $_POST['etat'])) {
                header('Location:index.php?action=listeBus');
                //  echo "<script>alert('Modification reussi')</script>";
            } else {
                header('Location:index.php?action=listeBus');
                //  echo "<script>alert('Modification echoué')</script>";
            }
        }
    }

    public function delete_bus()
    {
        AuthController::checkRole('admin_principal');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->busManager->delete($_GET['id'])) {
                header('Location:index.php?action=listeBus');
                echo "<script>alert('Supression reussi')</script>";
            } else {
                header('Location:index.php?action=listeBus');
                echo "<script>alert('Supression echoué')</script>";
            }
        }
    }
}
