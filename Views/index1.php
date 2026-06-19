<?php
require_once 'class/Entites/Bus.php';
$data = [
    'id_bus' => 1,
    'nom_bus' => 'bus 1',
    'capacite' => 30,
    'categorie' => 'VIP',
    'etat' =>  'plein'

];
$bus1 = new Bus($data);
var_dump($bus1);

?>