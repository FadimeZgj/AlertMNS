<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

/**
 * Permet de vérifier les champs d'un formulaire en précisant les champs obligatoires
 *
 * @param  array $data
 * @param  array $requireds
 * @return array
 */

function checkFormData(array $data, array $requireds = []): array
{
    $errors = [];

    foreach($data as $key => $value)
    {
        if($requireds == [] || in_array($key, $requireds))
        {
            if(empty($value))
            {
                $errors[$key] = "Ce champs ne doit pas être vide";
            }
        }
    }

    return $errors;
}

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
    $sql = "SELECT * FROM chaine
    WHERE chaine.id_chaine = chaine.id_chaine";
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

/**
 * Permet de vérifier les champs d'un formulaire en précisant les champs obligatoires
 *
 * @param  array $data
 * @param  int $id
 * @return array|bool
 */
function getSalonById(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM salon WHERE id_salon = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function insertChaine()
{

}

function insertSalon(array $data)
{
    $dbh = $GLOBALS['dbh'];

    if (!isset($data['id_chaine'])) {
        // Si la valeur de l'id_chaine est null, retournez une erreur.
        throw new Exception("La valeur de l'id_chaine ne peut pas être nulle.");
    }

    $sql = "INSERT INTO salon (nom_salon, id_chaine) VALUES (:nom_salon, :id_chaine)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':nom_salon', $data['nom_salon']);
    $stmt->bindParam(':id_chaine', $data['id_chaine']);
    $stmt->execute();
    // On recupère l'id du salon
    $id_salon = $dbh->lastInsertId();

    return $id_salon;
}


function deleteSalon(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "DELETE FROM salon WHERE id_salon = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id' => $id]);

    return $stmt->rowCount();
}