<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';
function getAllEmails()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM utilisateur
    WHERE utilisateur.email_utilisateur = utilisateur.email_utilisateur";
    return $dbh->query($sql)->fetchAll();
}