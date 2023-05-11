<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';


$salons_id = $_REQUEST['id_salon']; // Permet de recupérer les id des chaines

$salons_id = explode("_", $salons_id); // _1 ; _2 ; _3 ; etc
$salon_id = $salons_id[1]; // Correspond à salons_id 1


$sql = "SELECT message.text_message, message.date_message, salon.nom_salon, chaine.nom_chaine, utilisateur.nom_utilisateur, utilisateur.prenom_utilisateur
FROM message
LEFT JOIN salon on message.id_salon = salon.id_salon
LEFT JOIN chaine on chaine.id_chaine = salon.id_salon
LEFT JOIN utilisateur on message.id_utilisateur = utilisateur.id_utilisateur
WHERE salon.id_salon = $salon_id
AND message.id_utilisateur = " . $_SESSION['user']['id'];

$query = $dbh->query($sql);
$messages = $query->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');

echo json_encode($messages);
