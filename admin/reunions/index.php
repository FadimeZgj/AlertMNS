<?php

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

$title = "AlertMNS - Réunions";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();
$reunions = getAllReunions();
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
                <img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' alt='Photo'>
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
        <div class="containerLeftInfoIndex">
            <a href="/admin/reunions/new.php"><button class="createReunionBtn"><i class="fa-solid fa-plus fa-lg"></i> Organiser une nouvelle
                réunion</button></a>
            <a href="/admin/groupes/list.php"><button class="createReunionBtn">Voir mes réunions</button></a>
        </div>
        <div class="container-reunions">
            <h1>Liste des réunions</h1>
            <table>
                    <thead>
                        <tr>  
                            <th>Nom de la réunion</th>
                            <th>Sujet</th>
                            <th>Organisateur</th>
                            <th>Participants</th>
                            <th>Date prévue de la réunion</th>
                            <th colspan="3"></th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reunions as $reunion): ?>
                        <tr style="text-align: center;">
                            <td>
                                <?= $reunion['nom_reunion'] ?>
                            </td>
                            <td>
                                <?= $reunion['sujet_reunion'] ?>
                            </td>
                            <td>
                                <?= $reunion['prenom_utilisateur'] ?>
                                <?= $reunion['nom_utilisateur'] ?>
                            </td>
                            <td>
                                <?= $reunion['nom_groupe'] ?>
                            </td>
                            <td>
                                <?= $reunion['date_reunion'] ?>
                            </td>
                            <td>
                                <a href="/admin/groupes/list.php"><button>Plus d'infos</button></a>
                            </td>
                            <td>
                                <a href="/admin/groupes/list.php"><button>Participer</button></a>
                            </td>
                            <td>
                                <a href="/admin/reunions/edit.php?id=<?= $reunion['id_reunion'] ?>"><button>Modifier</button></a>
                            </td>
                            <td>
                            <form action="/admin/reunions/delete.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réunion ?')">
                                <input type="hidden" name="id" value="<?= $reunion['id_reunion'] ?>">
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