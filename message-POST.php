<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

session_start();

// Envoyer un message

if (isset($_POST['submit'])) 
{

        $sql = "INSERT INTO message (text_message, date_message, id_utilisateur) VALUES (:text_message, NOW(), :id_utilisateur)";
        $query = $dbh->prepare($sql);
        
        $res = $query->execute([
            'text_message' => $_POST['text_message'],
            'id_utilisateur' => $_SESSION['user']['id']

        ]);
        
        $newMsg = $dbh->lastInsertId();

        var_dump($newMsg);


    var_dump($newMsg);

    if ($newMsg) 
    {
        $sql = "INSERT INTO recevoir (id_message , id_utilisateur) VALUES (:id_message, :id_utilisateur)";
        $query = $dbh->prepare($sql);
        $query->execute([
            "id_message" => $newMsg,
            "id_utilisateur" => $_GET['id']
        ]);
    }
}

$sql = "SELECT * FROM recevoir WHERE id_utilisateur = :id_utilisateur";
$query = $dbh->prepare($sql);
$res = $query->execute(['utilisateur' => $_GET['id']]);
$article = $query->fetch(PDO::FETCH_ASSOC);