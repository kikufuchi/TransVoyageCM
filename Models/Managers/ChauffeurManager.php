<?php
require_once __DIR__ . "/../Core/Model.php";

class ChauffeurManager extends Model
{

    public $nom_chauffeur;
    public $telephone;
    private $table;

    #[Override]
    public function __construct()
    {
        $this->table = 'chauffeur';
        return parent::__construct();
    }

    public function insert()
    {
        $stmt = 'INSERT INTO ' . $this->table . ' (nom_chauffeur,telephone) VALUE (?, ?);';
        $data = array(
            $this->nom_chauffeur,
            $this->telephone,
        );
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function delete($id)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET delet = 0 WHERE id_chauffeur = ?';
        $data = array($id);
        $result = $this->request($stmt, $data);

        $stmt = 'UPDATE voyage SET delet = 0  WHERE id_chauffeur = ?';
        $this->request($stmt, $data);

        return $result->rowCount();
    }

    public function update($id, $nom, $telephone)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET nom_chauffeur = ?,  telephone = ? WHERE id_chauffeur = ?';
        $data = array(
            $nom,
            $telephone,
            $id
        );
        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }
}
