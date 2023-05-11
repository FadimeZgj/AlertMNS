<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

$chaines_id = $_REQUEST['id_chaine']; // Permet de recupérer les id des chaines

$chaines_id = explode("_", $chaines_id); // _1 ; _2 ; _3 ; etc
$chaine_id = $chaines_id[1]; // Correspond à chaine_id 1

    $sql = "SELECT * 
    FROM chaine
    LEFT JOIN salon ON salon.id_chaine = chaine.id_chaine
    WHERE salon.id_chaine = chaine.id_chaine
    AND chaine.id_chaine = " . $chaine_id;

    $query = $dbh->query($sql);
    $chaines = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($chaines);

?>
