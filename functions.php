<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';
function getAllEmails()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM utilisateur
    WHERE utilisateur.email_utilisateur = utilisateur.email_utilisateur";
    return $dbh->query($sql)->fetchAll();
}

// Récupérer les utilisateurs connectés (utile pour la topbar)
function getAllActiveUsers()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
    return $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
}
