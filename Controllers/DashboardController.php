<?php
require_once __DIR__ . '/../Models/Managers/AgenceManager.php';
require_once __DIR__ . '/../Models/Managers/ReservationManager.php';
require_once __DIR__ . '/../Models/Managers/TrajetManager.php';
require_once __DIR__ . '/../Models/Managers/BusManager.php';
require_once __DIR__ . '/../Models/Managers/PassagerManager.php';
require_once __DIR__ . '/../Models/Managers/VoyageManager.php';
require_once 'AuthController.php';

class DashboardController
{
    private $agenceManager;
    private $trajetManager;
    private $busManager;
    private $reservationManager;
    private $passagerManager;

    public function __construct()
    {
        $this->agenceManager = new AgenceManager();
        $this->trajetManager = new TrajetManager();
        $this->busManager = new BusManager();
        $this->reservationManager = new ReservationManager();
        $this->passagerManager = new PassagerManager();
    }

    public function showDashboard()
    {
        AuthController::checkRole('admin_principal');

        // --- Cartes récapitulatives ---
        $totalTrajets = $this->trajetManager->countAll();

        $totalBus = $this->busManager->countAll();
        $totalResas = $this->reservationManager->countToday();
        $totalCA = $this->reservationManager->sumCAToday();
        $nbAgences = $this->agenceManager->countAll();
        $nbPassagers = $this->passagerManager->countToday();

        // --- Agences avec leurs stats du jour ---
        $agences = $this->agenceManager->findAll('agence');
        foreach ($agences as $agence) {
            $stats = $this->reservationManager->getStatsByAgence($agence->id_agence, date('Y-m-d'));
            $agence->nb_resas = $stats->nb_resas ?? 0;
            $agence->ca = $stats->ca ?? 0;
            $agence->CA = $this->reservationManager->getStats($agence->id_agence)->CA;
        }

// var_dump($agences);
// die('stop');
        // // --- Graphique (admin principal) ---
        $isAdminPrincipal = true;
        $labels = array_map(function ($a) {
            return $a->quartier;
        }, $agences);

        $values = array_map(function ($a) {
            return $a->CA ?? 0;
        }, $agences);

        // =============================================
        // 2. Affichage
        // =============================================
        ob_start();
        require_once __DIR__ . "/../Views/gerer_dashboard.php";
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
    }

    

    public function showDashboardAdmin()
    {
        AuthController::checkRole('admin');

        // =============================================
        // 1. Récupération des données pour l'admin simple
        // =============================================

        $idAgence = $_SESSION['user']['idAgence'] ?? null;

        // --- Cartes récapitulatives (pour son agence) ---
        $totalTrajets = $this->trajetManager->countAll(); // ou par agence si besoin
        $totalBus = $this->busManager->countAll();        // ou par age   nce si besoin
        $totalResas = $this->reservationManager->countTodayByAgence($idAgence);
        $totalCA = $this->reservationManager->sumCATodayByAgence($idAgence);
        $nbAgences = $this->agenceManager->countAll(); // il ne gère qu'une agence
        $nbPassagers = $this->passagerManager->countTodayByAgence($idAgence);

        // --- Agence unique avec ses stats ---
        $agence = $this->agenceManager->findById($idAgence, 'agence', 'id_agence');

        if ($agence) {
            $stats = $this->reservationManager->getStatsByAgence($idAgence, date('Y-m-d'));
            $agence->nb_resas = $stats->nb_resas ?? 0;
            $agence->ca = $stats->ca ?? 0;
            $agences = [$agence];
        } else {
            $agences = [];
        }

        // --- Graphique (pas affiché pour admin simple) ---
        $isAdminPrincipal = false;
        $labels = [];
        $values = [];

        // =============================================
        // 2. Affichage
        // =============================================
        ob_start();
        require_once __DIR__ . "/../Views/gerer_dashboard.php";
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/layouts/sideBarAdmin.php';
    }
}
