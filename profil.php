<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

if (empty($_SESSION['user'])) {
    header("Location: /");
    die;
}

$title = "AlertMNS - Profil";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

?>

<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/profil.css">
<link rel="stylesheet" href="/assets/css/dashboard.css">


</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-top-bar.php" ?>
    <!-- Menu burger pour mobile -->

    <nav class="navbar">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" id="menu-button">
                <span class="menu-icon menu-icon--bar-top"></span>
                <span class="menu-icon menu-icon--bar-middle"></span>
                <span class="menu-icon menu-icon--bar-bottom"></span>
            </button>

        </div>
        <div class="navbar-menu" id="menu">
            <ul class="nav navbar-nav">
                <li><a href="/admin"><i class="fa-solid fa-house fa-2x"></i>Accueil</a></li>
                <li><a href="/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>Voir tous les messages</a></li>
                <li><a href="#"><i class="fa-solid fa-users fa-2x"></i>Voir tous les groupes</a></li>
                <li>
                    <a href=""><i class="fa-solid fa-tower-cell fa-2x"></i>Voir toutes les chaînes</a>
                </li>
                <li><a href="#"><i class="fa-regular fa-calendar-days fa-2x"></i>Voir les réunions</a></li>
                <li><a href="#"><i class="fa-solid fa-user fa-2x"></i>Gérer mon profil</a></li>
                <li><a href="#"><i class="fa-solid fa-gear fa-2x"></i>Réglages</a></li>
                <li><a href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

        <section class="profile-settings">
            <div class="profile-options">
                <ul class="profil-options-choices">
                    <a href="">
                        <li class="info"><i class="fa-regular fa-user fa-xl"></i>Informations</li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-key fa-xl"></i>Mot de passe et sécurité</li>
                    </a>
                </ul>
            </div>
            <div class="profile-elements">

            </div>
        </section>

        <!-- tablette/mobile -->

        <section class="section-profile">
            <div class="profile-mob">
                <a href=""><img src='https://dummyimage.com/100x100.jpg' alt='' /></a>
                <div class="name-mob">
                    <h2><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h2>
                    <p><?= $utilisateur['libelle_role'] ?></p>
                </div>

            </div>
        </section>

        <section class="section-actions">
            <div class="actions-mob">
                <ul>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Créer un utilisateur</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Créer une nouvelle chaine</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Créer un nouveau groupe</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Organiser une réunion</span></li>
                    </a>
                </ul>
            </div>
        </section>

    </main>

    <footer></footer>
    <script src="../assets/js/script.js"></script>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>