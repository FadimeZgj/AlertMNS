<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';


$chaines_id = $_REQUEST['id_chaine']; // Permet de recupérer les id des chaines

$chaines_id = explode("_", $chaines_id); // _1 ; _2 ; _3 ; etc
$chaine_id = $chaines_id[1]; // Correspond à chaine_id 

$salons = $_REQUEST['id_chaine']; // Permet de recupérer les id des chaines

$sql = "SELECT salon.nom_salon, salon.id_salon, salon.id_chaine as idChaineDeSalon, chaine.nom_chaine, chaine.id_chaine 
FROM salon
LEFT JOIN chaine ON chaine.id_chaine = salon.id_chaine
WHERE salon.id_chaine = chaine.id_chaine
AND salon.id_salon = salon.id_salon
AND chaine.id_chaine = " . $chaine_id; // ou salon.id_chaine

$query = $dbh->query($sql);
$salons = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');

echo json_encode($salons);