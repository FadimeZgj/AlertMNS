<?php

require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

$title = "AlertMNS - Réunions";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();
$userReunions = getUsersReunion();
$groupes = getAllGroupes();

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
            <a href="/user/reunions/"><button class="showReunionBtn"><i
                        class="fa-solid fa-arrow-left fa-lg"></i> Voir toutes les réunions</button></a>
            <a href="/user/reunions/new.php"><button class="createReunionBtn"><i class="fa-solid fa-plus fa-lg"></i> Organiser une nouvelle
                réunion</button></a>
        </div>
        <div class="container-reunions">
            <h1 class="mainTitleReunion">Mes réunions prévues</h1>
            <table>
                    <thead>
                        <tr>  
                        <th>Nom réunion</th>
                            <th>Sujet</th>
                            <th>Organisateur</th>
                            <th>Participants</th>
                            <th>Date réunion</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($userReunions as $userReunion): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $userReunion['nom_reunion'] ?>
                            </td>
                            <td>
                                <?= $userReunion['sujet_reunion'] ?>
                            </td>
                            <td>
                                <?= $userReunion['prenom_utilisateur'] ?>
                                <?= $userReunion['nom_utilisateur'] ?>
                            </td>
                            <td>
                                <?= $userReunion['nom_groupe'] ?>
                            </td>
                            <td>
                                <?= $userReunion['date_reunion'] ?>
                            </td>
                            <!-- <td>
                                <a href="/user/groupes/list.php"><button>Plus d'infos</button></a>
                            </td> -->
                            <td>
                                <a href="/user/groupes/list.php"><button>Participer</button></a>
                            </td>
                            <td>
                                <a href="/user/reunions/editQuiFonctionnePas.php?id=<?= $reunion['id_reunion'] ?>"><button>Modifier</button></a>
                            </td>
                            <td>
                            <form action="/user/reunions/delete.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réunion ?')">
                                <input type="hidden" name="id_reunion" value="<?= $reunion['id_reunion'] ?>">
                                <button type="submit">Supprimer
                                </button>
                            </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>
        </div>
    </div>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>