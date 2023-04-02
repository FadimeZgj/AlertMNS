<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

function getAllChaines() {
    $pdo = $GLOBALS['pdo'];	
    $sql = "SELECT * FROM chaine
    ORDER BY id_chaine DESC";
    "SELECT chaine*, GROUP_CONCAT(g.nom_genre SEPARATOR ',') as genres FROM `chaine` LEFT JOIN livre_genre lg ON lg.id_livre = l.id_livre LEFT JOIN genre g ON g.id_genre = lg.id_genre GROUP BY l.id_livre";
    return $pdo->query($sql)->fetchAll();
}

