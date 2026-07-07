<?php
require_once __DIR__ . "/../Core/Model.php";

class UsersManagers extends Model
{

  public $id_users;
  public $nom_users;
  public $email_users;
  public $mot_de_passe;
  public $telephone;
  public $role_users;
  public $delet;
  public $table;

  #[Override]
  public function __construct()
  {
    $this->table = 'utilisateur';
    return parent::__construct();
  }

  public function insert()
  {
    if ($this->findByEmail($this->email_users)) {
      return false;
    }


    if ($this->findByphone($this->telephone)) {
      return false;
    }
    $pass = password_hash($this->mot_de_passe, PASSWORD_DEFAULT);
    $stmt = 'INSERT INTO ' . $this->table . ' (nom_users,email_users,mot_de_passe,telephone,role_users) VALUE (?, ?, ?, ?, ?)';
    $data = array(
      $this->nom_users,
      $this->email_users,
      $pass,
      $this->telephone,
      $this->role_users
    );
    $result = $this->request($stmt, $data);
    return $result->rowCount();
  }

  public function delete($id)
  {
    $stmt = 'UPDATE ' . $this->table . ' SET delet = 0  WHERE id_users = ?';
    $data = array($id);
    $result = $this->request($stmt, $data);

    $stmt = 'UPDATE agence SET delet = 0  WHERE id_admin = ?';
    $this->request($stmt, $data);

    $stmt = 'UPDATE reservation SET delet = 0  WHERE id_reservation = ?';
    $this->request($stmt, $data);

    return $result->rowCount();
  }

  public function update($id, $nom, $email, $password, $telephone)
  {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = 'UPDATE ' . $this->table . ' SET nom_users = ?, email_users = ?, mot_de_passe = ?, telephone = ? WHERE id_users = ?';
    $data = array(
      $nom,
      $email,
      $password,
      $telephone,
      $id
    );
    $result = $this->request($stmt, $data);
    return $result->rowCount();
  }

  public function findByEmail($email)
  {
    $stmt = "SELECT * FROM utilisateur WHERE email_users = ?";
    $data = [$email];
    $result = $this->request($stmt, $data);
    return $result->fetch(PDO::FETCH_OBJ);
  }

  public function findByphone($phone)
  {
    $stmt = "SELECT * FROM utilisateur WHERE telephone = ?";
    $data = [$phone];
    $result = $this->request($stmt, $data);
    return $result->fetch(PDO::FETCH_OBJ);
  }

  public function findAdmin()
  {
    $stmt = "SELECT * FROM utilisateur WHERE (role_users = 'admin' or role_users = 'admin_principal')  and delet = 1;";
    $result = $this->request($stmt);
    return $result->fetchAll(PDO::FETCH_OBJ);
  }

  public function findAvailableAdmin()
  {
    $stmt = "SELECT * FROM " . $this->table . " WHERE ((role_users = 'admin' and id_users not in (select id_admin from agence where delet = 1)) or role_users = 'admin_principal') and delet = 1";
    $result = $this->request($stmt);
    return $result->fetchAll(PDO::FETCH_OBJ);
  }

  public function findAdminP()
  {
    $stmt = "SELECT * FROM utilisateur WHERE role_users = 'admin_principal'";
    $result = $this->request($stmt);
    return $result->fetch(PDO::FETCH_OBJ);
  }

  public function findAgencyById($id_users)
  {
    $stmt = "select id_agence, quartier from agence where id_admin = ? and delet = 1";
    $data = [$id_users];
    $result = $this->request($stmt, $data);
    return $result->fetch(PDO::FETCH_OBJ);
  }
}
