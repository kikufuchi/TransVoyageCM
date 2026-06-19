<?php
 
 class Database {

    public $dbname;
    public $dbhost;
    public $dbuser;
    public $dbpassword;
    public $PDO;

    public function __construct($dbname = "transvoyagescm", $dbhost = 'localhost', $dbuser='root', $dbpassword =''){
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
        $this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
    }
   
    public function getPDO() : PDO{
        if($this->PDO == null){
          try {
            $pdo = new PDO("mysql:dbname=$this->dbname;host=$this->dbhost",$this->dbuser,$this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->PDO = $pdo;  
          } catch (PDOException $e) {
            die("Erreur de connexion". $e->getMessage());
          }
          
        }
        return $this->PDO;
    }

    

 }

?>