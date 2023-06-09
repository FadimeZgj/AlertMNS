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

    foreach ($data as $key => $value) {
        if ($requireds == [] || in_array($key, $requireds)) {
            if (empty($value)) {
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

// function getAllEmails()
// {
//     $dbh = $GLOBALS['dbh'];
//     $sql = "SELECT * FROM utilisateur
//     WHERE utilisateur.email_utilisateur = utilisateur.email_utilisateur";
//     return $dbh->query($sql)->fetchAll();
// }

function getAllChaines()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM chaine
    WHERE chaine.id_chaine = chaine.id_chaine AND chaine.is_active = 1
    ORDER BY chaine.nom_chaine DESC";
    return $dbh->query($sql)->fetchAll();
}


function getAllSalons()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT salon.nom_salon, salon.id_salon, salon.id_chaine as idChaineDeSalon, chaine.nom_chaine, chaine.id_chaine 
    FROM salon
    LEFT JOIN chaine ON chaine.id_chaine = salon.id_chaine
    WHERE salon.id_chaine = chaine.id_chaine
    AND salon.id_salon = salon.id_salon";
    return $dbh->query($sql)->fetchAll();
}

function getChainesUserMessages()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT message.text_message, message.date_message, salon.nom_salon, chaine.nom_chaine, utilisateur.nom_utilisateur, utilisateur.prenom_utilisateur
    FROM message
    LEFT JOIN salon on message.id_salon = salon.id_salon
    LEFT JOIN chaine on chaine.id_chaine = salon.id_salon
    LEFT JOIN utilisateur on message.id_utilisateur = utilisateur.id_utilisateur
    AND message.id_utilisateur = " . $_SESSION['user']['id'];
    return $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
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

/**
 * @var int l'ID de la database
 */
function insertChaine(array $data)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "INSERT INTO chaine (nom_chaine, id_utilisateur) VALUES (:nom_genre, :id_utilisateur)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':nom_chaine', $data['nom_chaine']);
    $stmt->bindValue(':id_utilisateur', $_SESSION['user']['id']);
    return $dbh->lastInsertId();
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