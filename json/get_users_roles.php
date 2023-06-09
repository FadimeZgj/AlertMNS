<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

$sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur, utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role, role.id_role 
FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE utilisateur.id_role = role.id_role
ORDER BY utilisateur.nom_utilisateur ASC";

$query = $dbh->query($sql);
$usersRoles = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');

echo json_encode($usersRoles);
