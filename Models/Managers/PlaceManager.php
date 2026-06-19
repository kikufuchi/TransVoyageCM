<?php
require_once __DIR__ . "/../Core/Model.php";

class PlaceManager extends Model
{

    public $numero;
    public $disponibilite;
    public $idBus;
    public $table;


    #[Override]
    public function __construct()
    {
        $this->table = 'place';
        return parent::__construct();
    }

    public function insert()
    {
        $stmt = 'INSERT INTO ' . $this->table . ' (numero,disponibilite,id_bus) VALUE (?, ?, ?);';
        $data = array(
            $this->numero,
            $this->disponibilite,
            $this->idBus
        );
        $this->request($stmt, $data);
    }

    public function delete($id)
    {
        $stmt = 'DELETE FROM ' . $this->table . ' WHERE id_bus = ?';
        $data = array($id);
        $result = $this->request($stmt, $data);
    }

    public function findNumberPlace($id)
    {
        $stmt = 'SELECT COUNT(*) as total_place FROM ' . $this->table . ' WHERE id_bus = ? and disponibilite = 1';
        $data = array($id);
        $result = $this->request($stmt, $data);
        return $result->fetch(PDO::FETCH_OBJ)->total_place;
    }

    public function findInOrder($id)
    {
        $stmt = 'SELECT id_place, numero, disponibilite FROM ' . $this->table . ' WHERE id_bus = ? ORDER BY numero ASC';
        $data = array($id);
        $result = $this->request($stmt, $data);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPlacesAvecStatut($id_bus, $id_voyage)
    {
        // 1. Récupère TOUTES les places du bus
        $stmt = "
        SELECT id_place, numero, disponibilite
        FROM place
        WHERE id_bus = ?
        ORDER BY numero ASC
    ";
        $data = array($id_bus);
        $result = $this->request($stmt, $data);
        $places = $result->fetchAll(PDO::FETCH_OBJ);

        // 2. Récupère les statuts depuis place_voyage
        $stmt = "
        SELECT p.id_place, pv.statut
        FROM place p, place_voyage pv
        WHERE p.id_place = pv.id_place 
        AND pv.id_voyage = ? 
        AND p.id_bus = ?
        AND p.disponibilite = 1
    ";
        $data = array($id_voyage, $id_bus);
        $result = $this->request($stmt, $data);
        $statuts = $result->fetchAll(PDO::FETCH_OBJ);

        // 3. Transforme les statuts en tableau associatif [id_place => statut]
        $statutsMap = [];
        foreach ($statuts as $s) {
            $statutsMap[$s->id_place] = $s->statut;
        }

        // 4. Ajoute l'attribut statut aux places concernées
        foreach ($places as $place) {
            if ($place->disponibilite == 1) {
                $place->statut = $statutsMap[$place->id_place] ?? 'libre';
            }
            // Si disponibilité = 0 → pas d'attribut statut
        }

        return $places;
    }
}
