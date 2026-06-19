<?php
require_once __DIR__ . "/../Core/Model.php";

class VoyageManager extends Model
{
    public $id_voyage;
    public $nom_voyage;
    public $date_depart;
    public $heure_depart;
    public $statut;
    public $categorie;
    public $prix;
    public $nom_trajet;
    public $nom_bus;
    public $nom_chauffeur;
    public $nom_agence;
    public $table;

    // Pour les recherches d'ID
    public $tableTrajet = 'trajet';
    public $id_trajet = 'id_trajet';
    public $tableBus = 'bus';
    public $id_bus = 'id_bus';
    public $tableChauffeur = 'chauffeur';
    public $id_chauffeur = 'id_chauffeur';
    public $tableAgence = 'agence';
    public $id_agence = 'id_agence';

    #[Override]
    public function __construct()
    {
        $this->table = 'voyage';
        return parent::__construct();
    }

    /**
     * Récupère tous les voyages d'une agence avec détails (via sous-requêtes)
     */
    public function findByAgenceWithDetails($id_agence)
    {
        $stmt = "select * from voyage where id_agence = ? and delet = 1";
        $data = array($id_agence);
        $voyages = $this->request($stmt, $data)->fetchAll(PDO::FETCH_OBJ);

        if ($voyages) {

            foreach ($voyages as $voyage) {

                $stmt1 = 'select nom_bus from bus where id_bus = ?';
                $data1 = array($voyage->id_bus);
                $voyage->nom_bus = $this->request($stmt1, $data1)->fetch(PDO::FETCH_OBJ)->nom_bus;

                $stmt2 = 'select nom_chauffeur from chauffeur where id_chauffeur = ?';
                $data2 = array($voyage->id_chauffeur);
                $voyage->nom_chauffeur = $this->request($stmt2, $data2)->fetch(PDO::FETCH_OBJ)->nom_chauffeur;
            }
        }

        return $voyages;
    }



    public function insert()
    {
        // Récupération ID trajet
        $stmt = 'SELECT ' . $this->id_trajet . ' FROM ' . $this->tableTrajet . ' WHERE CONCAT(ville_depart, " - ", ville_arrivee) = ? and delet = 1';
        $data = [$this->nom_trajet];
        $result = $this->request($stmt, $data);
        $id_trajet = $result->fetch(PDO::FETCH_OBJ)->id_trajet;

        // Récupération ID bus
        $stmt = 'SELECT ' . $this->id_bus . ' FROM ' . $this->tableBus . ' WHERE nom_bus = ? and delet = 1';
        $data = [$this->nom_bus];
        $result = $this->request($stmt, $data);
        $id_bus = $result->fetch(PDO::FETCH_OBJ)->id_bus;

        // Récupération ID chauffeur
        $stmt = 'SELECT ' . $this->id_chauffeur . ' FROM ' . $this->tableChauffeur . ' WHERE nom_chauffeur = ? and delet = 1';
        $data = [$this->nom_chauffeur];
        $result = $this->request($stmt, $data);
        $id_chauffeur = $result->fetch(PDO::FETCH_OBJ)->id_chauffeur;

        // Récupération ID agence
        $stmt = 'SELECT ' . $this->id_agence . ' FROM ' . $this->tableAgence . ' WHERE quartier = ? and delet = 1';
        $data = [$this->nom_agence];
        $result = $this->request($stmt, $data);
        $id_agence = $result->fetch(PDO::FETCH_OBJ)->id_agence;

        // Insertion du voyage
        $this->id_voyage = $this->genererUUID();
        $stmt = 'INSERT INTO ' . $this->table . ' (id_voyage, nom_voyage, heure_depart, statut, categorie, prix, id_Trajet, id_bus, id_chauffeur, id_agence, date_voyage) 
                 VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $data = [
            $this->id_voyage,
            $this->nom_voyage,
            $this->heure_depart,
            $this->statut,
            $this->categorie,
            $this->prix,
            $id_trajet,
            $id_bus,
            $id_chauffeur,
            $id_agence,
            $this->date_depart
        ];

        $result = $this->request($stmt, $data);
        return $this->id_voyage;
    }



    public function update($id)
    {
        // Récupération ID trajet
        $stmt = 'SELECT ' . $this->id_trajet . ' FROM ' . $this->tableTrajet . ' WHERE CONCAT(ville_depart, " - ", ville_arrivee) = ? and delet = 1';
        $data = [$this->nom_trajet];
        $result = $this->request($stmt, $data);
        $id_trajet = $result->fetch(PDO::FETCH_OBJ)->id_trajet;

        // Récupération ID bus
        $stmt = 'SELECT ' . $this->id_bus . ' FROM ' . $this->tableBus . ' WHERE nom_bus = ? and delet = 1';
        $data = [$this->nom_bus];
        $result = $this->request($stmt, $data);
        $id_bus = $result->fetch(PDO::FETCH_OBJ)->id_bus;

        // Récupération ID chauffeur
        $stmt = 'SELECT ' . $this->id_chauffeur . ' FROM ' . $this->tableChauffeur . ' WHERE nom_chauffeur = ? and delet = 1';
        $data = [$this->nom_chauffeur];
        $result = $this->request($stmt, $data);
        $id_chauffeur = $result->fetch(PDO::FETCH_OBJ)->id_chauffeur;

        // Récupération ID agence
        $stmt = 'SELECT ' . $this->id_agence . ' FROM ' . $this->tableAgence . ' WHERE quartier = ? and delet = 1';
        $data = [$this->nom_agence];
        $result = $this->request($stmt, $data);
        $id_agence = $result->fetch(PDO::FETCH_OBJ)->id_agence;

        // Mise à jour
        $stmt = 'UPDATE ' . $this->table . ' 
                 SET nom_voyage = ?, heure_depart = ?, statut = ?, categorie = ?, prix = ?, id_Trajet = ?, id_bus = ?, id_chauffeur = ?, id_agence = ?, date_voyage = ?
                 WHERE id_voyage = ?';

        $data = [
            $this->nom_voyage,
            $this->heure_depart,
            $this->statut,
            $this->categorie,
            $this->prix,
            $id_trajet,
            $id_bus,
            $id_chauffeur,
            $id_agence,
            $this->date_depart,
            $id
        ];

        $result = $this->request($stmt, $data);
        return $result->rowCount();
    }


    public function delete($id)
    {
        $stmt = 'UPDATE ' . $this->table . ' SET delet = 0 WHERE id_voyage = ?';
        $result = $this->request($stmt, [$id]);
        return $result->rowCount();
    }

    public function findAllForClient()
    {

        $stmt = 'select * from voyage where delet = 1;';
        $voyages = $this->request($stmt)->fetchAll(PDO::FETCH_OBJ);

        foreach ($voyages as $voyage) {

            $stmt = 'select ville_arrivee from trajet where id_trajet = ?';
            $data = array($voyage->id_Trajet);
            $voyage->ville_arrivee = $this->request($stmt, $data)->fetch(PDO::FETCH_OBJ)->ville_arrivee;

            $stmt = 'select quartier from agence where id_agence = ?';
            $data = array($voyage->id_agence);
            $voyage->nom_agence = 'Agence de ' . $this->request($stmt, $data)->fetch(PDO::FETCH_OBJ)->quartier;
        }

        return $voyages;
    }

   
}
