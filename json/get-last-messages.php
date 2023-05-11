<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';



$sql = 'SELECT 
                message.id_message, 
                message.text_message, 
                message.date_message, 
                message.id_utilisateur as id_expediteur, 
                utilisateur.nom_utilisateur as nom_exp, 
                utilisateur.prenom_utilisateur as prenom_exp,
                role.libelle_role

        FROM (SELECT * FROM message ORDER BY date_message DESC) AS message 
        JOIN utilisateur ON utilisateur.id_utilisateur = message.id_utilisateur 
        JOIN role ON utilisateur.id_role = role.id_role
        WHERE message.id_message IN 
        (SELECT MAX(message.id_message) 
        FROM message 
        JOIN recevoir ON message.id_message = recevoir.id_message 
        WHERE recevoir.id_utilisateur = ' . $_SESSION['user']['id'] . '
        GROUP BY message.id_utilisateur)';
        

$query = $dbh -> query($sql);
$messages = $query -> fetchAll();

header('Content-Type: application/json');


echo json_encode($messages);
