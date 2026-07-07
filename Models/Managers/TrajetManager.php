<?php
require_once __DIR__ . "/../Core/Model.php";

class TrajetManager extends Model
{

    public $ville_depart;
    public $ville_arrivee;
    private $table;

    #[Override]
    public function __construct()
    {
        $this->table = 'trajet';
        return parent::__construct();
    }

    public function insert()
    {
        $stmt = 'INSERT INTO ' . $this->table . ' (ville_depart,ville_arrivee) VALUE (?, ?);';
        $data = array(
            $this->ville_depart,
            $this->ville_arrivee,
        );
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function delete($id)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET delet = 0 WHERE id_trajet = ?';
        $data = array($id);
        $result = $this->request($stmt, $data);

        $stmt = 'UPDATE voyage SET delet = 0  WHERE id_Trajet = ?';
        $this->request($stmt, $data);

        return $result->rowCount();
    }

    public function update($id, $depart, $arivee)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET ville_depart = ?, ville_arrivee = ? WHERE id_trajet = ?';
        $data = array(
            $depart,
            $arivee,
            $id
        );
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function findCytyEndByCityStart($ville_depart)
    {
        $stmt = 'select ville_arrivee from ' . $this->table . ' where ville_depart = ? ';
        $data = array($ville_depart);
        return $this->request($stmt, $data)->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Compte le nombre total de trajets (non supprimés)
     */
    public function countAll()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total_trajet FROM trajet WHERE delet = 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
