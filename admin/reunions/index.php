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
    <nav class="responsive-menu">
        <div class="burger-icon">
            <button id="burgerMenu">
                <i class="fa-solid fa-bars fa-3x"></i>
            </button>
            <button id="closeMenu" class="closeMenu">
                <i class="close fa-solid fa-xmark fa-2xl"></i>
            </button>
        </div>
        <ul id="responsiveMenu" class="ul">
            <li><a href="/admin/index.php"><i class="fa-solid fa-house"></i> Accueil</a></li>
            <li><a href="/admin/messages.php"><i class="fa-solid fa-comment-dots"></i> Voir tous les messages</a></li>
            <li><a href="/admin/groupes"><i class="fa-solid fa-users"></i> Voir tous les groupes</a></li>
            <li><a href="/admin/chaines"><i class="fa-solid fa-tower-cell"></i> Voir toutes les chaînes</a>
            </li>
            <li><a href="/admin/reunions"><i class="fa-regular fa-calendar"></i> Voir les réunions prévues</a></li>
            <li><a href="/profil"><i class="fa-solid fa-user"></i> Gérer mon profil</a></li>
            <li><a href="/"><i class="fa-solid fa-gear"></i> Réglages</a></li>
            <li><a href="/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Se déconnecter</a></li>
        </ul>
    </nav>
    <header>
        <div class="topbar">
            <div class="logo">
                <img src='/assets/images/logo1.png' alt='Logo'>
                <h3>Réunions</h3>
            </div>
            <div class="user-info">
            <a href="/profil"><img src="<?= $utilisateur['image_profile']!=null ? 
                '../' . $utilisateur['image_profile'] : 
                'https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' ?>" alt="Image Profil" /></a>
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

    <div class="container" id="containerBurger">
        <div class="containerLeftInfo">
            <a href="/admin/reunions/new.php"><button class="createReunionBtn" id="createReunionBtnBtn"><span class="hide"><i class="fa-solid fa-plus fa-lg"></i></span> Organiser une nouvelle
                réunion</button></a>
            <a href="/admin/reunions/list.php"><button class="showReunionBtn" id="showReunionBtnBtn"><span class="hide"><i class="fa-regular fa-calendar-check fa-lg"></i></span> Voir mes réunions</button></a>
        </div>
        <div class="container-reunions">
            <h1 class="hide">Liste de toutes les réunions</h1>
            <table>
                <caption class="show">Liste de toutes les réunions</caption>
                    <thead>
                        <tr>  
                            <th class="hide"><span class="hide">Nom réunion</span></th>
                            <th class="hide"><span class="hide">Sujet</span></th>
                            <th class="hide"><span class="hide">Organisateur</span></th>
                            <th class="hide"><span class="hide">Participants</span></th>
                            <th class="hide"><span class="hide">Date réunion</span></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reunions as $reunion): ?>

                        <tr style="text-align: center;">
                            <td>  
                            <a href="/admin/groupes/index.php">                      
                                <?= $reunion['nom_reunion'] ?>
                                </a>
                            </td>
                            <td class="hide">
                            <span class="hide"><?= $reunion['sujet_reunion'] ?></span>
                            </td>
                            <td class="hide">
                            <span class="hide"><?= $reunion['prenom_utilisateur'] ?></span>
                            <span class="hide"><?= $reunion['nom_utilisateur'] ?></span>
                            </td>
                            <td class="hide">
                            <span class="hide"><?= $reunion['nom_groupe'] ?></span>
                            </td>
                            <td class="small">
                            <a href="/admin/groupes/index.php"> 
                                <?= $reunion['date_reunion'] ?>
                            </a>
                            </td>
                            <!-- <td>
                                <a href="/admin/groupes/list.php"><button>Plus d'infos</button></a>
                            </td> -->
                            <td class="hide">
                            <span class="hide"><a href="/admin/groupes/index.php"><button>Participer</button></span></a>
                            </td>
                            <td>
                            <a href="/admin/reunions/edit.php?id=<?= $reunion['id_reunion'] ?>"><button>Modifier</button></a>
                            </td>
                            <td>
                            <span class="hide">
                            <form action="/admin/reunions/delete.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réunion ?')">
                                <input type="hidden" name="id_reunion" value="<?= $reunion['id_reunion'] ?>">
                                <button type="submit">Supprimer
                                </button>
                            </form>
                            </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>
        </div>
    </div>

<script>
    // JS pour afficher le nav menu

// On récupère le bouton auquel on va ajouter l'évènement
const burgerMenuBtn = document.getElementById("burgerMenu");

burgerMenuBtn.addEventListener("click", responsiveMenu);

var responsiveMenu = document.getElementById("responsiveMenu");
// Afficher le menu quand on clic sur le burger
function responsiveMenu() {
    if (responsiveMenu.style.display === "block") {
        responsiveMenu.style.display = "none";
        createReunionBtnBtn.style.zIndex = "1";
        showReunionBtnBtn.style.zIndex = "1";
        body.style.opacity = "O.4";
    } else {
        responsiveMenu.style.display = "block";
        createReunionBtnBtn.style.zIndex = "-1";
        showReunionBtnBtn.style.zIndex = "-1";
    }
}
</script>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>