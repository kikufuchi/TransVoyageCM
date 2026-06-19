<?php
require_once __DIR__ . '/../Models/Managers/VoyageManager.php';
require_once __DIR__ . '/../Models/Managers/AgenceManager.php';
require_once __DIR__ . '/../Models/Managers/TrajetManager.php';

class ShowVoyageController
{
   private $voyageManager;
   private $agenceManager;
   private $trajetManager;
   public function __construct()
   {
      $this->voyageManager = new VoyageManager();
      $this->agenceManager = new AgenceManager();
      $this->trajetManager = new TrajetManager();
   }

   public function display_voyage()
   {

      $voyages = $this->voyageManager->findAllForClient();
      $groupes = [];
      foreach ($voyages as $voyage) {
         $villeArrivee = $voyage->ville_arrivee;
         $agenceDepart = $voyage->nom_agence;
         $groupes[$villeArrivee][$agenceDepart][] = $voyage;
      }

      ob_start();

      require_once  __DIR__ . "/../Views/voyagesClient.php";

      $content = ob_get_clean();

      $agences = $this->agenceManager->findAll('agence');
      $trajets = $this->trajetManager->findAll('trajet');
      $villeDeparts = [];
      foreach ($trajets as $trajet) {
         $trajet->ville_depart = ucfirst($trajet->ville_depart);
         if (!in_array($trajet->ville_depart, $villeDeparts)) {
            $villeDeparts[] = $trajet->ville_depart;
         }
      }

      require_once __DIR__ . '/../Views/voyages.php';
   }

   public function SearchCityEnd()
   {

      $cityStart = $_POST['villeDepart'];
      $villeArrivees = $this->trajetManager->findCytyEndByCityStart($cityStart);
      $optionCitys = "<option value=''>Selectionner une ville d'arrivée</option>";
      foreach ($villeArrivees as $villeArrivee) {
         $optionCitys .= " <option value='$villeArrivee->ville_arrivee'>$villeArrivee->ville_arrivee</option> ";
      }

      echo ($optionCitys);
   }

   public function DisplayCityAfterSearch()
   {
      $voyages = $this->voyageManager->findAllForClient();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $cityEnd = $_POST['cityEnd'];
         $cityStart = $_POST['cityStart'];
         $agenceDepart = 'Agence de ' . $_POST['agenceStart'];
         $categorie = $_POST['categ'] ?? '';
         $travel = $cityStart . ' - ' . $cityEnd;
         $travels = [];

         foreach ($voyages as $voyage) {
            if (!empty($categorie)) {

               if ($voyage->nom_voyage == $travel && $voyage->nom_agence == $agenceDepart && $voyage->categorie == $categorie && $voyage->statut == 'ouvert') {
                  $travels[] = $voyage;
               }
            } else {
               if ($voyage->nom_voyage == $travel && $voyage->nom_agence == $agenceDepart && $voyage->statut == 'ouvert') {
                  $travels[] = $voyage;
               }
            }
         }


         $agences = $this->agenceManager->findAll('agence');
         $trajets = $this->trajetManager->findAll('trajet');
         $villeDeparts = [];
         foreach ($trajets as $trajet) {
            $trajet->ville_depart = ucfirst($trajet->ville_depart);
            if (!in_array($trajet->ville_depart, $villeDeparts)) {
               $villeDeparts[] = $trajet->ville_depart;
            }
         }
         ob_start();

         require_once  __DIR__ . "/../Views/searchVoyageClient.php";

         $content = ob_get_clean();
         require_once __DIR__ . '/../Views/voyages.php';
      }
   }
   
}
