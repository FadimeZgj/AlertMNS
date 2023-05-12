<?php

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

$title = "AlertMNS - Réunions";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();

?>
<link rel="stylesheet" href="/assets/css/messages.css">
<link rel="stylesheet" href="/assets/css/chaines.css">
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

<header>
        <div class="topbar">
            <div class="logo">
                <img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Logo' alt='Logo'>
                <h3>ALERT MNS</h3>
            </div>
            <div class="user-info">
                <img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' alt='Photo'>
                <div class="user-role">
                    <h4 id="userName"><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h4>
                    <h5><?= $utilisateur['libelle_role'] ?></h5>
                </div>
            </div>
        </div>
    </header>

<div class="container-reunions">
<h1 style="margin-left: 100px;">Liste des réunions</h1>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>