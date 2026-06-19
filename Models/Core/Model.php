<?php
require_once __DIR__ . '/../database.php';

abstract class Model
{

  protected $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getPDO();
  }

  public function request($stmt, $data = [])
  {
    $sql = $this->pdo->prepare($stmt);
    $result = $sql->execute($data);
    if ($result) {
      return $sql;
    }
  }

  public function findAll($table)
  {
    $stmt = "SELECT * FROM " . $table . " WHERE delet = 1 ";
    $sql = $this->pdo->prepare($stmt);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_OBJ);
  }

  public function findByID($id, $table, $idTable)
  {
    $query = $this->pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $idTable . '  = ? and delet = 1');
    $query->execute([$id]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

  public function genererUUID(){
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff)
    );
  }
}
