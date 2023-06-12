<?php

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

$title = "AlertMNS - Créer une nouvelle réunion";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();

// $categories = getCategories();

?>
<link rel="stylesheet" href="/assets/css/reunions.css">
<link rel="stylesheet" href="/assets/css/chaines.css">
<link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

    <header>
        <div class="topbar">
            <div class="logo">
                <img src='/assets/images/logo1.png' alt='Logo'>
                <h3>Réunions</h3>
            </div>
            <div class="user-info">
            <img src="<?= $utilisateur['image_profile']!=null ? 
                '../' . $utilisateur['image_profile'] : 
                'https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' ?>" alt="Image Profil" />
                <div class="user-role">
                    <h4 id="userName">
                        <?= $utilisateur['prenom_utilisateur'] ?>
                        <?= $utilisateur['nom_utilisateur'] ?>
                    </h4>
                    <h5>
                        <?= $utilisateur['libelle_role'] ?>
                    </h5>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="containerLeftInfo">
            <a href="/admin/reunions/index.php"><button class="createReunionBtn"><i
                        class="fa-solid fa-arrow-left fa-lg"></i> Revenir à la liste des groupes</button></a>
        </div>
        <div class="container-reunions">
            <div class="participantsForm">

                    <h1 class="createReunionTitle">Liste des groupes</h1>

            </div>

        </div>
    </div>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>