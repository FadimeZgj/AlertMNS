<?php

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';


// $id_destinataire = $_POST['id_destinataire'];

// $sql = "SELECT u1.id_utilisateur as id_exp, u1.nom_utilisateur as nom_exp, u1.prenom_utilisateur as prenom_exp, role.libelle_role,
//         message.id_message, message.text_message, message.date_message , 
//         u2.id_utilisateur as id_dest , u2.nom_utilisateur as nom_dest, u2.prenom_utilisateur as prenom_dest
//         FROM message 
//         JOIN utilisateur u1 ON u1.id_utilisateur = message.id_utilisateur
//         JOIN role ON role.id_role = u1.id_role
//         LEFT JOIN recevoir ON recevoir.id_message = message.id_message
//         LEFT JOIN utilisateur u2 ON recevoir.id_utilisateur = u2.id_utilisateur
//         WHERE (u1.id_utilisateur = 1 
//         AND u2.id_utilisateur = $id_destinataire) OR (u1.id_utilisateur = $id_destinataire AND u2.id_utilisateur = 1)
//         ORDER BY message.id_message DESC";

// $query = $dbh -> prepare($sql);
// $query -> bindValue(':id_destinataire', $id_destinataire, PDO::PARAM_INT);
// $query -> execute();
// $conversations = $query -> fetchAll(PDO::FETCH_ASSOC);

// header('Content-Type: application/json');


// echo json_encode($conversations);

//$id_destinataire = $_POST['id_destinataire'];

$id = $_GET['id'];

$sql = "SELECT u1.id_utilisateur as id_exp, u1.nom_utilisateur as nom_exp, u1.prenom_utilisateur as prenom_exp, role.libelle_role,
        u1.image_profile as image_exp,
        message.id_message, message.text_message, message.date_message , 
        u2.id_utilisateur as id_dest , u2.nom_utilisateur as nom_dest, u2.prenom_utilisateur as prenom_dest, u2.image_profile as image_dest
        FROM message 
        JOIN utilisateur u1 ON u1.id_utilisateur = message.id_utilisateur
        JOIN role ON role.id_role = u1.id_role
        LEFT JOIN recevoir ON recevoir.id_message = message.id_message
        LEFT JOIN utilisateur u2 ON recevoir.id_utilisateur = u2.id_utilisateur
        WHERE (u1.id_utilisateur = " . $_SESSION['user']['id']
        . " 
        AND u2.id_utilisateur = :id_destinataire) OR (u1.id_utilisateur = :id_destinataire AND u2.id_utilisateur = " . $_SESSION['user']['id'] . ")
        ORDER BY message.date_message ASC";

$query = $dbh->prepare($sql);
$query->bindValue(':id_destinataire', $id, PDO::PARAM_INT);
$query->execute();
$conversations = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($conversations);
