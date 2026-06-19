<?php
require_once __DIR__ . '/../Models/Managers/ReservationManager.php';
require_once __DIR__ . '/../Models/Managers/PlaceVoyageManager.php';
require_once __DIR__ . '/../Models/Managers/VoyageManager.php';
require_once __DIR__ . '/../Models/Managers/BusManager.php';


class ReservationController
{
    private $reservationManager;
    private $placeVoyageManager;
    private $voyageManager;
    private $busManager;

    public function __construct()
    {
        $this->reservationManager = new ReservationManager();
        $this->placeVoyageManager = new PlaceVoyageManager();
        $this->voyageManager = new VoyageManager();
        $this->busManager = new BusManager();
    }

    public function liste_reservation() {}

    public function insert_reservation()
    {
        // Vérifie que le client est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=formConnect');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id_voyage = $_GET['id_voyage'] ?? null;
            $places_ids = isset($_GET['places']) ? explode(',', $_GET['places']) : [];


            if (empty($id_voyage) || empty($places_ids)) {
                die('Paramètres manquants.');
            }

            $voyage = $this->voyageManager->findByID($id_voyage, 'voyage', 'id_voyage');
            $montant = $voyage->prix * count($places_ids);

            // Crée la réservation
            $this->reservationManager->statut = 'en_attente';
            $this->reservationManager->mode_paiement = ''; // Sera défini au paiement
            $this->reservationManager->montant = $montant;
            $this->reservationManager->id_client = $_SESSION['user']['id_users'];
            $this->reservationManager->id_voyage = $id_voyage;
            $id_reservation = $this->reservationManager->insert();

            $this->placeVoyageManager->reserverPlaces($id_reservation, $places_ids, $id_voyage);

            header('Location: index.php?action=pagePassager&id_reservation=' . $id_reservation . '&id_voyage=' . $id_voyage . '&numeros=' . $_GET['numeros'] . '&idPlaces=' . $_GET['places']);
            exit;
        }
    }


    public function simulationPaiement()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id_voyage = $_GET['id_voyage'] ?? null;
            $id_reservation = $_GET['id_reservation'];

            if (!$id_reservation) {
                die('Réservation non spécifiée.');
            }

            // $reservation = $this->reservationManager->findByID($id_reservation);
            $voyage = $this->voyageManager->findByID($id_voyage, 'voyage', 'id_voyage');
            $montant = $_GET['n'] * $voyage->prix;
            require_once __DIR__ . '/../Views/simulerPaiement.php';
        }
    }


    public function confirmerPaiement()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id_reservation = $_GET['id_reservation'] ?? null;
            $mode_paiement = $_GET['modePaiement'];
            $id_voyage = $_GET['id_voyage'];

            if (!$id_reservation) {
                die('Réservation non spécifiée.');
            }

            $voyage = $this->voyageManager->findByID($id_voyage, 'voyage', 'id_voyage');
            // Met à jour la réservation
            $this->reservationManager->updateStatut($id_reservation, 'confirmee', $mode_paiement);

            // Met à jour place_voyage
            $this->placeVoyageManager->confirmerPaiement($id_reservation);

            // Redirige vers une page de succès
            header('Location: index.php?action=downloadTicket&id_reservation=' . $id_reservation . '&id_voyage=' . $id_voyage);
            exit;
        }
    }

    function downloadTicket()
    {
        
        $id_reservation = $_GET['id_reservation'] ?? null;
        $id_voyage = $_GET['id_voyage'] ?? null;

        $voyage = $this->voyageManager->findByID($id_voyage, 'voyage', 'id_voyage');
        $reservation = $this->voyageManager->findByID($id_reservation, 'reservation', 'id_reservation');

        require_once "Views/confirmPaiement.php";
    }


    function downloadPdFinalize(){
        $id_reservation = $_GET['id_reservation'] ?? null;
        $id_voyage = $_GET['id_voyage'] ?? null;
        $voyage = $this->voyageManager->findByID($id_voyage, 'voyage', 'id_voyage');
        $bus = $this->busManager->findByID($voyage->id_bus,"bus","id_bus");
        $passagers = $this->reservationManager->getBypassagers($id_reservation);

       require_once "Views/finaliserTelechargement.php";
    }
}
