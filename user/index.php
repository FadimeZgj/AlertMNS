<?php

require 'includes/inc-session-check.php';
require '../includes/inc-db-connect.php';

// Récupérer tous les utilisateurs
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b7ca8ab8e7.js" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>

<body>
    <header>
        <div class="name-dashboard">
            <a href=""><i class="fa-solid fa-house fa-4x"></i></a>
            <h1>Dashboard Utilisateur</h1>
        </div>
        <div class="name-user">
            <div>
                <h2><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h2>
                <p><?= $utilisateur['libelle_role'] ?></p>
            </div>
            <a href=""><img src='https://dummyimage.com/50x50.jpg' alt=''/></a>
        </div>
    </header>

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
                <li><a href="#"><i class="fa-solid fa-house fa-2x"></i>Accueil</a></li>
                <li><a href="#"><i class="fa-solid fa-comment-dots fa-2x"></i>Voir tous les messages</a></li>
                <li><a href="#"><i class="fa-solid fa-users fa-2x"></i>Voir tous les groupes</a></li>
                <li><a href="#"><i class="fa-solid fa-tower-cell fa-2x"></i>Voir toutes les chaînes</a></li>
                <li><a href="#"><i class="fa-regular fa-calendar-days fa-2x"></i>Voir les réunions</a></li>
                <li><a href="#"><i class="fa-solid fa-user fa-2x"></i>Gérer mon profil</a></li>
                <li><a href="#"><i class="fa-solid fa-gear fa-2x"></i>Réglages</a></li>
                <li><a href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <nav class="sidebar">
            <div class="top-icons">
                <a href="#"><i class="fa-solid fa-comment-dots fa-2x"></i>
                    <p>Voir tous les messages</p>
                </a>
                <a href=""><i class="fa-solid fa-users fa-2x"></i>
                    <p> Voir tous les groupes</p>
                </a>
                <a href=""><i class="fa-solid fa-tower-cell fa-2x"></i>
                    <p>Voir toutes les chaînes</p>
                </a>
                <a href=""><i class="fa-regular fa-calendar-days fa-2x"></i>
                    <p>Voir les réunions</p>
                </a>
            </div>

            <div class="bottom-icons">
                <a href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
                    <p>Déconnexion</p>
                </a>
                <a href=""><i class="fa-solid fa-user fa-2x"></i>
                    <p>Gérer mon profil</p>
                </a>
                <a href=""><i class="fa-solid fa-gear fa-2x"></i>
                    <p> Réglages</p>
                </a>
            </div>
        </nav>

        <div class="options">
            <section>
                <div class="actions">
                    <ul>
                        <li><a href=""><i class="fa-solid fa-plus fa-xl"></i>Créer un nouveau groupe</a></li>
                        <li><a href=""><i class="fa-solid fa-plus fa-xl"></i>Organiser une réunion</a></li>
                        <li><a href=""><i class="fa-solid fa-magnifying-glass fa-xl"></i>Rechercher un utilisateur</a></li>
                        <li><a href=""><i class="fa-solid fa-tower-cell fa-xl"></i>Voir les chaînes</a></li>
                        <li><a href=""><i class="fa-solid fa-users fa-xl"></i>Voir les groupes</a></li>
                        <li><a href=""><i class="fa-solid fa-comment-dots fa-xl"></i>Voir les messages</a></li>
                        <li><a href=""><i class="fa-regular fa-calendar-days fa-xl"></i>Voir les réunions prévues</a></li>
                        <li><a href=""><i class="fa-solid fa-circle-exclamation fa-xl"></i>Signalements</a></li>
                        <li><a href=""><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer un groupe</span></a></li>
                    </ul>
                </div>
            </section>

            <section>
                <div class="squares">
                    <ul>
                        <a href=""><li><i class="fa-solid fa-plus fa-2x"></i><span>Créer un groupe</span></li></a>
                        <a href=""><li><i class="a-solid fa-comment-dots fa-2x"></i><span>Voir tous les messages</span></li></a>
                        <a href=""><li><i class="fa-solid fa-plus fa-2x"></i><span>Organiser une réunion</span></li></a>
                    </ul>
                    <ul>
                        <a href=""><li><i class="fa-solid fa-plus fa-2x"></i><span>Voir les réunions prévues</span></li></a>
                        <a href=""><li><i class="fa-solid fa-tower-cell fa-2x"></i><span>Voir la liste des chaînes</span></li></a>
                        <a href=""><li><i class="fa-solid fa-magnifying-glass fa-2x"></i><span>Rechercher un utilisateur</span></li></a>
                    </ul>
                </div>
            </section>
        </div>

        <!-- tablette/mobile -->

        <section class="section-profile">
            <div class="profile-mob">
                <a href=""><img src='https://dummyimage.com/100x100.jpg' alt=''/></a>
                <div class="name-mob">
                    <h2><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h2>
                    <p><?= $utilisateur['libelle_role'] ?></p>
                </div>

            </div>
        </section>
        
        <section class="section-actions">
            <div class="actions-mob">
                <ul>
                    <a href=""><li><i class="fa-solid fa-plus"></i><span>Créer un nouveau groupe</span></li></a>
                    <a href=""><li><i class="fa-solid fa-plus"></i><span>Organiser une réunion</span></li></a>
                    <a href=""><li><i class="fa-solid fa-comment-dots"></i><span>Voir tous les messages</span></li></a>
                </ul>
            </div>
        </section>

        <section class="section-squares">
            <div class="squares-mob">
                <ul>
                    <a href=""><li><i class="fa-solid fa-magnifying-glass fa-xl"></i>Rechercher un utilisateur</li></a>
                    <a href=""><li><i class="fa-solid fa-tower-cell fa-xl"></i>Voir les chaînes</li></a>
                    <a href=""><li><i class="fa-solid fa-users fa-xl"></i>Voir les groupes</li></a>
                    <a href=""><li><i class="fa-regular fa-calendar-days fa-xl"></i>Voir les réunions prévues</li></a>
                    <a href=""><li><i class="fa-solid fa-circle-exclamation fa-xl"></i>Signalements</li></a>
                    <a href=""><li><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer un groupe</span></li></a>
                </ul>
            </div>
        </section>

    </main>

    <footer></footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>