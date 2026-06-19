<?php
require_once __DIR__ . '/../Models/Managers/VoyageManager.php';
require_once __DIR__ . '/../Models/Managers/PassagerManager.php';
require_once __DIR__ . '/../Models/Managers/PlaceVoyageManager.php';

class PassagerController
{

    public $voyageManager;
    public $passagerManager;
    public $placeVoyageManager;

    public function __construct()
    {
        $this->passagerManager = new PassagerManager();
        $this->voyageManager = new VoyageManager();
        $this->placeVoyageManager = new PlaceVoyageManager();
    }

    public function displayForm_passager()
    {

        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $idPlaces = $_GET['idPlaces'];
            $id_voyage = $_GET['id_voyage'] ?? null;
            $id_reservation = $_GET['id_reservation'];
            $numeros = isset($_GET['numeros']) ? explode(',', $_GET['numeros']) : [];
            
            
            $voyage = $this->voyageManager->findByID($id_voyage, 'voyage', 'id_voyage');
            $montant = $voyage->prix * count($numeros);
            
            require_once __DIR__ . '/../Views/savePassager.php';
        }
    }

    public function save_passager(){
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $idPlaces = isset($_POST['id_places']) ? explode(',', $_POST['id_places']) : [];
            $id_voyage = $_POST['id_voyage'] ?? null;
            $id_reservation = $_POST['id_reservation'];
            $numeros = isset($_POST['numeros']) ? explode(',', $_POST['numeros']) : [];
            $passagers = $_POST['passagers'];

            $groupes = [];
            $i=0;
              
            while($i<count($passagers)){
               $passager = new stdClass();
               $passager->nom = $passagers[$i];
               $i++;
               $passager->cni = $passagers[$i];
               $groupes[] = $passager;
               $i++;
            }
            
            $nbrePassagers = count($groupes);

            $i = 0;
            foreach($groupes as $passager){
                $this->passagerManager->nom_passager = $passager->nom;
                $this->passagerManager->numero_CNI = $passager->cni;
                $this->passagerManager->numeroChoisi = $numeros[$i];
                
                $idPassager = $this->passagerManager->insert();
                // var_dump($idPassager,$idPlaces);
                // die('stop');
                $this->placeVoyageManager->insertPassagerForAnyPlace($idPassager,$idPlaces[$i]) ;

                $i++;
            }
             
            header('Location:index.php?action=pagePaiement&id_reservation='.$id_reservation.'&id_voyage='.$id_voyage.'&n='.$nbrePassagers);
        }
    }


}
