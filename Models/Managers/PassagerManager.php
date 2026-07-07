<?php
require_once __DIR__ . "/../Core/Model.php";

class PassagerManager extends Model
{

    public $nom_passager;
    public $numero_CNI;
    public $id_reservation;
    public $id_passager;
    public $numeroChoisi;
    public $table;

    #[Override]
    public function __construct()
    {
        $this->table = 'passager';
        return parent::__construct();
    }


    public function insert()
    {
        $this->id_passager = $this->genererUUID();
        $stmt = 'INSERT INTO ' . $this->table . ' (id_passager,nom_passager,numero_CNI,numeroChoisi) VALUE (?, ?, ?, ?);';
        $data = array(
            $this->id_passager,
            $this->nom_passager,
            $this->numero_CNI,
            $this->numeroChoisi
        );
        $result = $this->request($stmt, $data);
        return $this->id_passager;
    }

    public function delete($id)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET delet = 0 WHERE id_passager = ?';
        $data = array($id);
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }

    public function update($id, $nom, $cni)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET nom_passager = ?, numero_cni = ? WHERE id_passager = ?';
        $data = array(
            $nom,
            $cni,
            $id
        );
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function findByAgenceWithDetails($id)
    {
        $stmt = "SELECT p.*, r.date_reservation, r.id_voyage,r.id_reservation
                   FROM passager p, place_voyage pv, voyage v, reservation r
                   where p.id_passager = pv.id_passager
                   and r.id_reservation = pv.id_reservation
                   and pv.id_voyage = v.id_voyage
                   and v.id_agence = ?
        ";
        $data = array($id);
        $passagers = $this->request($stmt, $data)->fetchAll(PDO::FETCH_OBJ);
        return $passagers;
    }


    /**
     * Compte le nombre de passagers ayant reservé aujourd'hui
     */
    public function countToday()
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(DISTINCT p.id_passager) 
        FROM passager p
        JOIN place_voyage pv ON p.id_passager = pv.id_passager
        JOIN reservation r ON r.id_reservation = pv.id_reservation
        WHERE DATE(r.date_reservation) = CURDATE()
        AND r.statut = 'confirmee'
        AND p.delet = 1
    ");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Compte les passagers pour une agence donnée aujourd'hui
     */
    public function countTodayByAgence($idAgence)
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(DISTINCT p.id_passager) 
        FROM passager p
        JOIN place_voyage pv ON p.id_passager = pv.id_passager
        JOIN reservation r ON r.id_reservation = pv.id_reservation
        JOIN voyage v ON v.id_voyage = pv.id_voyage
        WHERE DATE(r.date_reservation) = CURDATE()
        AND r.statut = 'confirmee'
        AND v.id_agence = ?
        AND p.delet = 1
    ");
        $stmt->execute([$idAgence]);
        return (int) $stmt->fetchColumn();
    }
}
