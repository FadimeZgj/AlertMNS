<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

function getUserSession()
{
    // Récupérer l'utilisateur de la session
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
    LEFT JOIN role ON utilisateur.id_role = role.id_role
    WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
    return $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
}

function getAllChaines()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM chaine";
    return $dbh->query($sql)->fetchAll();
}

// Récupérer tous les utilisateurs
function getAllUsers()
{
    $dbh = $GLOBALS['dbh'];
    $sql = $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
    LEFT JOIN role ON utilisateur.id_role = role.id_role
    ORDER BY id_utilisateur ASC";

    return $dbh->query($sql)->fetchAll();
}

function getAllSalons()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT salon.nom_salon, salon.id_chaine as c, chaine.nom_chaine, chaine.id_chaine 
    FROM salon
    LEFT JOIN chaine ON chaine.id_chaine = salon.id_chaine
    WHERE salon.id_chaine = chaine.id_chaine";
    return $dbh->query($sql)->fetchAll();
}

function getAllMessages()
{
    // Jointure de la table message avec la table utilisateur et la table recevoir
    $dbh = $GLOBALS['dbh'];
    $sql = 'SELECT message.id_message, message.text_message, message.date_message, 
    message.id_utilisateur as id_expediteur, 
    recevoir.id_message as message_reception, 
    recevoir.id_utilisateur as id_destinataire, 
    recevoir.date_lecture 
    FROM message 
    JOIN recevoir ON message.id_message = recevoir.id_message 
    WHERE message.id_utilisateur = ' . $_SESSION['user']['id'] . ' OR recevoir.id_utilisateur = ' . $_SESSION['user']['id'] .
    ' ORDER BY message.date_message DESC ';

    return $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
}

function getChaineById(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM chaine WHERE id_chaine = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}
function getSalonById(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM salon WHERE id_salon = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function insertSalonBis(array $data)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "INSERT INTO salon (nom_salon) VALUES (:nom_salon)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    return $dbh->lastInsertId();

}

function insertSalon(array $data, array $chaines = [])
{
    $dbh = $GLOBALS['dbh'];

    // Traiter les données
    $data['nom_salon'] = htmlspecialchars($data['nom_salon']);

    $sql = "INSERT INTO salon (nom_salon) VALUES (:nom_salon)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $id_salon = $dbh->lastInsertId();

    // On traite les genres
    if(count($chaines) > 0)
    {
        foreach($chaines as $id_chaine)
        {
            $sql = "INSERT INTO chaine (id_chaine, id_salon) VALUES (:id_chaine, :id_salon)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                'id_chaine' => $id_chaine,
                'id_salon' => $id_salon
            ]);
        }
    }

    return $id_chaine;
}