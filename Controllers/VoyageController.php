<?php
require_once __DIR__ . '/../Models/Managers/VoyageManager.php';
require_once __DIR__ . '/../Models/Managers/AgenceManager.php';
require_once __DIR__ . '/../Models/Managers/TrajetManager.php';
require_once __DIR__ . '/../Models/Managers/BusManager.php';
require_once __DIR__ . '/../Models/Managers/ChauffeurManager.php';
require_once __DIR__ . '/../Models/Managers/PlaceVoyageManager.php';
require_once 'AuthController.php';

class VoyageController
{
    private $voyageManager;
    private $agenceManager;
    private $trajetManager;
    private $busManager;
    private $chauffeurManager;
    private $placeVoyageManager;

    public function __construct()
    {
        $this->voyageManager = new VoyageManager();
        $this->agenceManager = new AgenceManager();
        $this->trajetManager = new TrajetManager();
        $this->busManager = new BusManager();
        $this->chauffeurManager = new ChauffeurManager();
        $this->placeVoyageManager = new PlaceVoyageManager();
    }

    public function liste_voyage()
    {
        if ($_SESSION['user']['role'] == 'admin_principal') {
            AuthController::checkRole('admin_principal');

            // Récupérer toutes les agences
            $agences = $this->agenceManager->findAll('agence');

            // Pour chaque agence, récupérer ses voyages avec détails
            foreach ($agences as $agence) {
                $agence->voyages = $this->voyageManager->findByAgenceWithDetails($agence->id_agence);
            }

            // Données pour les select (modale ajout)
            $trajets = $this->trajetManager->findAll('trajet');
            $bus = $this->busManager->findWithPlace();
            $chauffeurs = $this->chauffeurManager->findAll('chauffeur');

            ob_start();
            require_once __DIR__ . "/../Views/gerer_voyages.php";
            $content = ob_get_clean();
            require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
        }else{
            AuthController::checkRole('admin');
            $agences = [];
            $agences[] = $this->agenceManager->findByID($_SESSION['user']['idAgence'], 'agence', 'id_agence');

            foreach ($agences as $agence) {
                $agence->voyages = $this->voyageManager->findByAgenceWithDetails($agence->id_agence);
            }
             // Données pour les select (modale ajout)
            $trajets = $this->trajetManager->findAll('trajet');
            $bus = $this->busManager->findWithPlace();
            $chauffeurs = $this->chauffeurManager->findAll('chauffeur');
            ob_start();
            require_once __DIR__ . "/../Views/gerer_voyages.php";
            $content = ob_get_clean();
            require_once __DIR__ . '/../Views/layouts/sideBarAdmin.php';
        }
    }

    public function insert_voyage()
    {
        AuthController::checkRole('admin_principal');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->voyageManager->nom_voyage = $_POST['trajet'];
            $this->voyageManager->date_depart = $_POST['date'];
            $this->voyageManager->heure_depart = $_POST['departure'];
            $this->voyageManager->statut = $_POST['statut'];
            $this->voyageManager->categorie = $_POST['categorie'];
            $this->voyageManager->prix = $_POST['prix'];
            $this->voyageManager->nom_trajet = $_POST['trajet'];
            $this->voyageManager->nom_bus = $_POST['bus'];
            $this->voyageManager->nom_chauffeur = $_POST['chauffeur'];
            $this->voyageManager->nom_agence = $_POST['agence'];

            $id_voyage = $this->voyageManager->insert();
            $id_bus = $this->busManager->findByName($_POST['bus'])->id_bus;
            $this->placeVoyageManager->insererPlacesPourVoyage($id_voyage, $id_bus);

            header('Location: index.php?action=listeVoyage');
        }
    }

    public function edit_voyage()
    {
        AuthController::checkRole('admin_principal');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->voyageManager->nom_voyage = $_POST['trajet'];
            $this->voyageManager->date_depart = $_POST['date'];
            $this->voyageManager->heure_depart = $_POST['departure'];
            $this->voyageManager->statut = $_POST['statut'];
            $this->voyageManager->categorie = $_POST['categorie'];
            $this->voyageManager->prix = $_POST['prix'];
            $this->voyageManager->nom_trajet = $_POST['trajet'];
            $this->voyageManager->nom_bus = $_POST['bus'];
            $this->voyageManager->nom_chauffeur = $_POST['chauffeur'];
            $this->voyageManager->nom_agence = $_POST['agence'];

            $id_bus = $this->busManager->findByName($_POST['bus'])->id_bus;
            $this->placeVoyageManager->remplacerPlacesVoyage($_POST['id'], $id_bus);

            if ($this->voyageManager->update($_POST['id'])) {
                header('Location: index.php?action=listeVoyage');
            } else {
                header('Location: index.php?action=listeVoyage');
            }
        }
    }

    public function delete_voyage()
    {
        AuthController::checkRole('admin_principal');

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->voyageManager->delete($_GET['id'])) {
                header('Location: index.php?action=listeVoyage');
            } else {
                header('Location: index.php?action=listeVoyage');
            }
        }
    }
}
