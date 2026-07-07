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
                 (id_reservation, statut, date_reservation, mode_paiement, montant, id_client, heure_reservation, id_voyage) 
                 VALUES (?, ?, CURDATE(), ?, ?, ?, CURTIME(), ?)';
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
                 FROM reservation r, voyage v, agence a
                 WHERE r.id_voyage = v.id_voyage 
                 and v.id_agence = a.id_agence
                 AND r.id_client = ? ';
        $data = array($id_client);
        $result = $this->request($stmt, $data);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function findByAgenceWithDetails($id)
    {
        $stmt = "SELECT r.*, v.nom_voyage,(SELECT COUNT(*) FROM place_voyage pv2 WHERE pv2.id_reservation = r.id_reservation) AS nb_places,(SELECT nom_users FROM utilisateur u WHERE r.id_client = u.id_users) as nom_client  
                   FROM voyage v, reservation r
                   where r.id_voyage = v.id_voyage
                   and v.id_agence = ?
        ";
        $data = array($id);
        $reservations = $this->request($stmt, $data)->fetchAll(PDO::FETCH_OBJ);
        return $reservations;
    }


    public function getReservationsByVoyage($id_voyage)
    {
        $stmt = 'SELECT * FROM ' . $this->table . ' WHERE id_voyage = ?';
        $data = array($id_voyage);
        $result = $this->request($stmt, $data);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Compte les réservations du jour (toutes agences)
     */
    public function countToday()
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*) FROM reservation 
        WHERE DATE(date_reservation) = CURDATE() 
        AND delet = 1
    ");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Compte les réservations du jour pour une agence donnée
     */
    public function countTodayByAgence($idAgence)
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(DISTINCT r.id_reservation) FROM reservation r
        JOIN place_voyage pv ON r.id_reservation = pv.id_reservation
        JOIN voyage v ON v.id_voyage = pv.id_voyage
        WHERE DATE(r.date_reservation) = CURDATE()
        AND v.id_agence = ?
        AND r.delet = 1
    ");
        $stmt->execute([$idAgence]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Somme des CA du jour (toutes agences)
     */
    public function sumCAToday()
    {
        $stmt = $this->pdo->prepare("
        SELECT COALESCE(SUM(montant), 0) FROM reservation 
        WHERE DATE(date_reservation) = CURDATE() 
        AND statut = 'confirmee'
        AND delet = 1
    ");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Somme des CA du jour pour une agence donnée
     */
    public function sumCATodayByAgence($idAgence)
    {
        $stmt = $this->pdo->prepare(" 
        SELECT 
            COALESCE(SUM(r.montant), 0) 
            FROM reservation r
            JOIN voyage v ON v.id_voyage = r.id_voyage
            WHERE DATE(r.date_reservation) = CURDATE()
            AND r.statut = 'confirmee'
            AND v.id_agence = ?
            AND r.delet = 1
    ");
        $stmt->execute([$idAgence]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Récupère les stats d'une agence pour une date donnée (nb résas, CA)
     */
    public function getStatsByAgence($idAgence, $date)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            COUNT(DISTINCT r.id_reservation) AS nb_resas,
            COALESCE(SUM(DISTINCT r.montant), 0) AS ca
        FROM reservation r
        JOIN place_voyage pv ON r.id_reservation = pv.id_reservation
        JOIN voyage v ON v.id_voyage = pv.id_voyage
        WHERE DATE(r.date_reservation) = ?
        AND r.statut = 'confirmee'
        AND v.id_agence = ?
        AND r.delet = 1
    ");
        $stmt->execute([$date, $idAgence]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getStats($idAgence)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            COALESCE(SUM(DISTINCT r.montant), 0) as CA
        FROM reservation r
        JOIN place_voyage pv ON r.id_reservation = pv.id_reservation
        JOIN voyage v ON v.id_voyage = pv.id_voyage
        WHERE r.statut = 'confirmee'
        AND v.id_agence = ?
        AND r.delet = 1
    ");
        $stmt->execute([$idAgence]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
}
