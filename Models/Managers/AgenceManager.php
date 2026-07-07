<?php
require_once __DIR__ . "/../Core/Model.php";

class AgenceManager extends Model
{

    public $ville;
    public $quartier;
    public $table;
    public $nom_admin;

    public $table2;
    public  $id_table;

    #[Override]
    public function __construct()
    {
        $this->table = 'agence';
        $this->table2 = 'utilisateur';
        $this->id_table = 'id_users';
        return parent::__construct();
    }

    public function insert()
    {
        $stmt = 'select ' . $this->id_table . ' from ' . $this->table2 . ' where nom_users = ? and delet = 1';
        $data = array($this->nom_admin);
        $result = $this->request($stmt, $data);
        $id_admin = $result->fetch(PDO::FETCH_OBJ)->id_users;

        $stmt = 'INSERT INTO ' . $this->table . ' (ville,quartier,id_admin) VALUE (?, ?, ?);';
        $data = array(
            $this->ville,
            $this->quartier,
            $id_admin
        );
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function delete($id)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET delet = 0 WHERE id_agence = ?';
        $data = array($id);
        $result = $this->request($stmt, $data);

        $stmt = 'UPDATE voyage SET delet = 0  WHERE id_agence = ?';
        $this->request($stmt, $data);

        return $result->rowCount();
    }


    public function update($id, $ville, $quartier, $nom_admin)
    {
        $stmt = 'select ' . $this->id_table . ' from ' . $this->table2 . ' where nom_users = ? and delet = 1';
        $data = array($nom_admin);
        $result = $this->request($stmt, $data);
        $idAdmin = $result->fetch(PDO::FETCH_OBJ)->id_users;

        $stmt = 'UPDATE ' . $this->table . ' SET ville = ?, quartier = ?, id_admin = ? where id_agence = ?';
        $data = array(
            $ville,
            $quartier,
            $idAdmin,
            $id
        );
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }

    /**
     * Compte le nombre total d'agences (non supprimées)
     */
    public function countAll()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total_agence FROM agence WHERE delet = 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
