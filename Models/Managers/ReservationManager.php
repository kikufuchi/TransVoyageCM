<?php
require_once __DIR__ . "/../Core/Model.php";

class ReservationManager extends Model
{
    public $id_reservation;
    public $statut;
    public $date_reservation;
    public $heure_reservation;
    public $mode_paiement;
    public $montant;
    public $date_paiement;
    public $id_client;
    public $id_voyage;
    public $table;

    public function __construct()
    {
        $this->table = 'reservation';
        return parent::__construct();
    }

    public function insert()
    {
        // Génère l'UUID en PHP
        $this->id_reservation = $this->genererUUID();

        $stmt = 'INSERT INTO ' . $this->table . ' 
                 (id_reservation, statut, date_reservation, mode_paiement, montant, id_client, id_voyage, heure_reservation) 
                 VALUES (?, ?, CURDATE(), ?, ?, ?, ?, CURTIME())';
        $data = array(
            $this->id_reservation,
            $this->statut,
            $this->mode_paiement,
            $this->montant,
            $this->id_client,
            $this->id_voyage
        );
        $this->request($stmt, $data);

        return $this->id_reservation;
    }

    public function updateStatut($id_reservation, $statut, $mode)
    {
        $stmt = 'UPDATE ' . $this->table . ' 
                 SET statut = ?, mode_paiement = ?, date_paiement = NOW()
                 WHERE id_reservation = ?';
        $data = array($statut, $mode, $id_reservation);
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function cleanOnReturn($id_client, $idVoyage)
    {
        // Passe les réservations en échouées
        $stmt = "
       UPDATE reservation r
        SET r.statut = 'echouee'
        WHERE r.id_client = ?
        AND r.id_reservation IN (
            SELECT DISTINCT pv.id_reservation 
            FROM place_voyage pv 
            WHERE pv.id_voyage = ? and pv.id_reservation IS NOT NULL
        )
        AND r.statut = 'en_attente'
    ";
        $this->request($stmt, [$id_client, $idVoyage]);

        // Libère les anciennes réservations en_attente de ce client pour ce voyage
        $stmt = "
        UPDATE place_voyage pv, reservation r
        SET pv.statut = 'libre', 
            pv.id_reservation = NULL,
            pv.id_passager = NULL
        WHERE pv.id_reservation = r.id_reservation
        AND r.id_client = ?
        AND pv.id_voyage = ?
        AND r.statut = 'echouee' 
    ";
        $this->request($stmt, [$id_client, $idVoyage]);
    }


    public function getBypassagers($id_reservation)
    {
        $stmt = "
        SELECT p.*
        FROM passager p, place_voyage pv 
        WHERE p.id_passager = pv.id_passager
        AND pv.id_reservation = ?
        AND p.delet = 1
    ";
        $data = array($id_reservation);
        $result = $this->request($stmt, $data);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getReservationsByClient($id_client)
    {
        $stmt = 'SELECT DISTINCT r.id_reservation,r.statut,r.date_reservation,r.heure_reservation,r.mode_paiement,r.montant, v.nom_voyage,v.id_voyage, a.quartier,
                  (SELECT COUNT(*) FROM place_voyage pv2 WHERE pv2.id_reservation = r.id_reservation) AS nb_places
                 FROM reservation r, voyage v, place_voyage pv,  agence a
                 WHERE pv.id_reservation = r.id_reservation
                 and pv.id_voyage = v.id_voyage 
                 and v.id_agence = a.id_agence
                 AND r.id_client = ? ';
        $data = array($id_client);
        $result = $this->request($stmt, $data);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }




    public function getReservationsByVoyage($id_voyage)
    {
        $stmt = 'SELECT * FROM ' . $this->table . ' WHERE id_voyage = ?';
        $data = array($id_voyage);
        $result = $this->request($stmt, $data);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

}
