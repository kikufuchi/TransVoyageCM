<?php
session_start();

require_once 'Router.php';
$router = new Router();

$router->addRouter('listeBus', 'BusController', 'liste_bus');
$router->addRouter('deleteBus', 'BusController', 'delete_bus');
$router->addRouter('editBus', 'BusController', 'edit_bus');
$router->addRouter('insertBus', 'BusController', 'insert_bus');

$router->addRouter('listeUsers', 'UsersController', 'liste_users');
$router->addRouter('insertAC', 'UsersController', 'insert_AC');
$router->addRouter('deleteAC', 'UsersController', 'delete_AC');
$router->addRouter('editAC', 'UsersController', 'edit_AC');

$router->addRouter('inscription', 'AuthController', 'inscription');
$router->addRouter('login', 'AuthController', 'login');
$router->addRouter('deconnect', 'AuthController', 'logout');
$router->addRouter('dashboard', 'DashboardController', 'showDashboard');
$router->addRouter('dashboardAdmin', 'DashboardController', 'showDashboardAdmin');

$router->addRouter('listeTrajet', 'TrajetController', 'liste_trajet');
$router->addRouter('deleteTrajet', 'TrajetController', 'delete_trajet');
$router->addRouter('editTrajet', 'TrajetController', 'edit_trajet');
$router->addRouter('insertTrajet', 'TrajetController', 'insert_trajet');

$router->addRouter('listeChauffeur', 'ChauffeurController', 'liste_chauffeur');
$router->addRouter('deleteChauffeur', 'ChauffeurController', 'delete_chauffeur');
$router->addRouter('editChauffeur', 'ChauffeurController', 'edit_chauffeur');
$router->addRouter('insertChauffeur', 'ChauffeurController', 'insert_chauffeur');

$router->addRouter('listeAgence', 'AgenceController', 'liste_agence');
$router->addRouter('deleteAgence', 'AgenceController', 'delete_agence');
$router->addRouter('editAgence', 'AgenceController', 'edit_agence');
$router->addRouter('insertAgence', 'AgenceController', 'insert_agence');

$router->addRouter('listeVoyage', 'VoyageController', 'liste_voyage');
$router->addRouter('deleteVoyage', 'VoyageController', 'delete_voyage');
$router->addRouter('editVoyage', 'VoyageController', 'edit_voyage');
$router->addRouter('insertVoyage', 'VoyageController', 'insert_voyage');

$router->addRouter('voyage','ShowVoyageController','display_voyage');
$router->addRouter('getCityEnd','ShowVoyageController','SearchCityEnd');
$router->addRouter('searchTravel','ShowVoyageController','DisplayCityAfterSearch');

$router->addRouter('insertPlaces','PlaceController','insert_places');
$router->addRouter('placeBus','PlaceController','display_places');

$router->addRouter('creerReservation','ReservationController','insert_reservation');
$router->addRouter('pagePaiement','ReservationController','simulationPaiement');
$router->addRouter('confirmPaiement','ReservationController','confirmerPaiement');
$router->addRouter('downloadTicket','ReservationController','downloadTicket');
$router->addRouter('telechargerTickets','ReservationController','downloadPdFinalize');
$router->addRouter('listeReservations','ReservationController','liste_reservation');

$router->addRouter('pagePassager','passagerController','displayForm_passager');
$router->addRouter('enregistrerPassagers','passagerController','save_passager');
$router->addRouter('listePassager','passagerController','liste_passager');

$router->addRouter('profil','ProfilController','displayProfil');
$router->addRouter('reservationClient','ProfilController','ReservationCustumer');

$action = $_GET['action'] ?? 'home';

if (!in_array($action, ['formConnect', 'deconnect', 'formInscript', 'inscription', 'login'])) {
    $_SESSION['before_page'] = $action;
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
}

if ($action == 'home') {
    require_once "Views/acceuil.php";
} elseif ($action == 'formInscript') {
    require_once "Views/form/inscription.php";
} elseif ($action == 'formConnect') {
    require_once "Views/form/connection.php";
}elseif($action=='paie'){
    require_once 'Views/simulerPaiement.php';
}else {
    $router->execRoute($action);
}
