<?php
require_once __DIR__ . "/../Core/Model.php";

class PlaceVoyageManager extends Model
{

    public $id_place_voyage;
    public $id_place;
    public $id_voyage;
    public $id_reservation;
    public $statut;
    public $heure_debut_reservation;
    public $table;

    public function __construct()
    {
        $this->table = 'place_voyage';
        return parent::__construct();
    }



    // Insère les places pour un voyage (depuis la table place)
    public function insererPlacesPourVoyage($id_voyage, $id_bus)
    {
        $stmt = "
            INSERT INTO place_voyage ( statut,id_place, id_voyage)
            SELECT 'libre', id_place, ?
            FROM place
            WHERE id_bus = ? AND disponibilite = 1 
            ORDER BY numero DESC
        ";
        $data = array($id_voyage, $id_bus);
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function remplacerPlacesVoyage($id_voyage, $id_bus)
    {
        // 1. Supprime les anciennes places du voyage
        $stmt = "DELETE FROM place_voyage WHERE id_voyage = ?";
        $this->request($stmt, [$id_voyage]);

        // 2. Insère les nouvelles places du nouveau bus
        $stmt = "
        INSERT INTO place_voyage (id_place, id_voyage, statut)
        SELECT id_place, ?, 'libre'
        FROM place
        WHERE id_bus = ? AND disponibilite = 1
        ORDER BY numero DESC
    ";
        $this->request($stmt, [$id_voyage, $id_bus]);
    }



    public function reserverPlaces($id_reservation, $places_ids, $id_voyage)
    {
        $placeholders = implode(',', array_fill(0, count($places_ids), '?'));

        $stmt = "
        UPDATE place_voyage
        SET statut = 'en_attente',
            id_reservation = ?
        WHERE id_place IN ($placeholders)
        AND id_voyage = ?
        AND statut = 'libre' ";

        // Fusionne tous les paramètres : id_reservation + places_ids + id_voyage
        $data = array_merge([$id_reservation], $places_ids, [$id_voyage]);
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }



    // ============================================================
    // Confirme le paiement (statut = payee)
    // ============================================================
    public function confirmerPaiement($id_reservation)
    {
        $stmt = "
            UPDATE place_voyage
            SET statut = 'occupee'
            WHERE id_reservation = ?
        ";
        $data = array($id_reservation);
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function insertPassagerForAnyPlace($idPassager,$idPlace) {
         $stmt = "
            UPDATE place_voyage
            SET id_passager = ?
            WHERE id_place = ?
        ";
        $data = array($idPassager,$idPlace);
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }
}
