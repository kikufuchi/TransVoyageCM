<?php
require_once __DIR__ . '/../Models/Managers/PlaceManager.php';
require_once __DIR__ . '/../Models/Managers/VoyageManager.php';
require_once __DIR__ . '/../Models/Managers/ReservationManager.php';

class PlaceController
{
  public $placeManager;
  public $voyageManager;
  public $reservationManager;

  public function __construct()
  {
    $this->placeManager = new PlaceManager();
    $this->voyageManager = new VoyageManager();
    $this->reservationManager = new ReservationManager();
  }


  public function insert_places()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $idBus = $_POST['bus'];
      $placeActives = (!empty($_POST['placeActives'])) ? explode('-', $_POST['placeActives']) : [];
      $placeInactives = (!empty($_POST['placeInacitves'])) ? explode('-', $_POST['placeInacitves']) : [];

      $this->placeManager->delete($idBus);

      foreach ($placeActives as $numero) {
        $this->placeManager->numero = $numero;
        $this->placeManager->disponibilite = 1;
        $this->placeManager->idBus = $idBus;
        $this->placeManager->insert();
      }

      foreach ($placeInactives as $numero) {
        $this->placeManager->numero = $numero;
        $this->placeManager->disponibilite = 0;
        $this->placeManager->idBus = $idBus;
        $this->placeManager->insert();
      }
    }
    header('Location:index.php?action=listeBus');
  }




  public function display_places()
  {
    header('Cache-Control: no-cache, no-store, must-revalidate'); //  dit au navigateur :  ne garde rien. À chaque fois, demande au serveur.
    header('Pragma: no-cache'); // Meme fonction que Cache-Control pour les vieux navigateur.
    header('Expires: 0'); //  dit au navigateur : cette page a expirée depuis le premiers janvier 1970.

    $idVoyage = $_GET['id_voyage'];
    $voyage = $this->voyageManager->findByID($idVoyage, 'voyage', 'id_voyage');

    if (isset($_SESSION['user'])) {
      $this->reservationManager->cleanOnReturn($_SESSION['user']['id_users'], $idVoyage);
    }

    $travelPlaces = $this->placeManager->getPlacesAvecStatut($voyage->id_bus, $idVoyage);
    // var_dump($travelPlaces);
    // die('stip');
    $totalPlaces = count($travelPlaces);
    $nbColonnes = $totalPlaces >= 70 ? 5 : 4;
    $totalLignes = $totalPlaces / $nbColonnes;
    $compteurAffichage = 1;
    $indexPlace = 0;


    require_once __DIR__ . '/../Views/AfficherPlaceBus.php';
  }
}
