<?php 

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

// $id_destinataire = $_POST['id_destinataire'];
$id = $_GET['id'];

$sql = "SELECT utilisateur.id_utilisateur, utilisateur.nom_utilisateur , utilisateur.prenom_utilisateur
FROM utilisateur 
JOIN message ON message.id_utilisateur = utilisateur.id_utilisateur
WHERE utilisateur.id_utilisateur = :id_destinataire
GROUP BY utilisateur.id_utilisateur";

$query = $dbh -> prepare($sql);
$query -> bindValue(':id_destinataire', $id, PDO::PARAM_INT);
$query -> execute();
$destinataires = $query -> fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($destinataires);



