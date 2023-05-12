<?php

$title = "Déconnexion";

include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

session_start();
unset($_SESSION['user']);
session_destroy();

// header("Location: /"); exit;
?>

<link rel="stylesheet" href="/assets/css/logout.css">

<body>
    <a class="bounce" href="/index.php"><i class="fa-solid fa-arrow-left fa-3x"></i>Retourner à la page d'accueil</a>
    <div class="container">
        <h1>Vous êtes bien déconnecté(e)</h1>
        <h4>Merci d'avoir utiliser Alert MNS</h4>
    </div>
</body>