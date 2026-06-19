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

   
}
