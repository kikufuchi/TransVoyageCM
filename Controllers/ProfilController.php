<?php
require_once __DIR__ . "/../Models/Managers/UsersManagers.php";
require_once __DIR__ . "/../Models/Managers/ReservationManager.php";

class ProfilController
{
  private $userManager;
  private $reservationManager;

  public function __construct()
  {
    $this->userManager = new UsersManagers();
    $this->reservationManager = new ReservationManager();
  }

  public function displayProfil()
  {

    if ($_SESSION['user']) {
      $profil = 'profil';
      $users = $this->userManager->findByID($_SESSION['user']['id_users'], 'utilisateur', 'id_users');
      require_once __DIR__ . '/../Views/profil.php';
    }
  }

  public function ReservationCustumer()
  {
    if ($_SESSION['user']) {
      $reservations = $this->reservationManager->getReservationsByClient($_SESSION['user']['id_users']);
      require_once __DIR__ . '/../Views/myReservations.php';
    }
  }
}
