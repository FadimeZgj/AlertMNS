<?php

$dsn = 'mysql:dbname=alertmns;host=127.0.0.1:8889;charset=utf8mb4';
$user = 'root';
$password = 'root';

try { // le code que je souhaite exécuter
    // Instanciation de l'objet PDO (il s'agit de la connexion)
    $dbh = new PDO($dsn, $user, $password);

} catch (PDOException $e) {
    // Gestion de l'erreur PDO
    echo "Erreur de connexion : " . $e->getMessage();
} catch (Exception $e) { // $e est un argument
    // Gestion des autres exceptions
    echo "Une erreur s'est produite : " . $e->getMessage();
}

?>