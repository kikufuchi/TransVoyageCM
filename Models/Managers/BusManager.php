<?php
require_once __DIR__ . "/../Core/Model.php";

class BusManager extends Model
{

  public $id_bus;
  public $nom_bus;
  public $categorie;
  public $capacite;
  public $etat;
  public $delet;
  public $table;


  #[Override]
  public function __construct()
  {
    $this->table = 'bus';
    return parent::__construct();
  }

  public function insert()
  {
    $stmt = 'INSERT INTO ' . $this->table . ' (nom_bus,capacite,categorie,etat) VALUE (?, ?, ?, ?);';
    $data = array(
      $this->nom_bus,
      $this->capacite,
      $this->categorie,
      $this->etat
    );
    $result = $this->request($stmt, $data);
    return $result->rowCount();
  }

  public function delete($id)
  {
    $stmt = 'UPDATE ' . $this->table . ' SET delet = 0 WHERE id_bus = ?';
    $data = array($id);
    $result = $this->request($stmt, $data);

    $stmt = 'UPDATE voyage SET delet = 0  WHERE id_bus = ?';
    $this->request($stmt, $data);

    return $result->rowCount();
  }

  public function update($id, $nom, $capacite, $categorie, $etat)
  {
    $stmt = 'UPDATE ' . $this->table . ' SET nom_bus = ?, capacite = ?, categorie = ?, etat = ? WHERE id_bus = ?';
    $data = array(
      $nom,
      $capacite,
      $categorie,
      $etat,
      $id
    );
    $result = $this->request($stmt, $data);
    return $result->rowCount();
  }


  // Récupère les bus configurés (avec au moins 1 place dispo=1)
  public function findWithPlace()
  {
    $stmt = "
            SELECT DISTINCT b.id_bus, b.nom_bus, b.capacite, b.categorie, b.etat
            FROM bus b, place p
            WHERE b.id_bus = p.id_bus
            AND p.disponibilite = 1
            AND b.delet = 1
        ";
    $result = $this->request($stmt);
    return $result->fetchAll(PDO::FETCH_OBJ);
  }

  public function findWithoutPlace()
  {
    $stmt = "
            select * from bus where nom_bus not in(
            SELECT DISTINCT b.nom_bus
            FROM bus b, place p
            WHERE b.id_bus = p.id_bus
            AND b.delet = 1) and delet = 1
        ";
    $result = $this->request($stmt);
    return $result->fetchAll(PDO::FETCH_OBJ);
  }

  public function findByName($nom)
  {
    $stmt = 'SELECT id_bus FROM ' . $this->table . ' WHERE nom_bus = ? and delet = 1';
    $data = array($nom);
    $result = $this->request($stmt, $data);
    return $result->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Compte le nombre total de bus (non supprimés)
   */
  public function countAll()
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) as total_bus FROM bus WHERE delet = 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
}
