<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

if(empty($_SESSION['user']))
{
    header("Location: /"); die;
}

if (in_array("Administrateur", $_SESSION['user']['roles'])){
    if (!empty($_GET['submit'])) {
        if (!empty($_GET['search'])) {
            $search = htmlspecialchars($_GET['search']);
            $data = explode(" ", $search);

            $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
            LEFT JOIN role ON utilisateur.id_role = role.id_role 
            WHERE utilisateur.nom_utilisateur = :search
            OR utilisateur.prenom_utilisateur = :search
            OR role.libelle_role = :search
            ORDER BY utilisateur.nom_utilisateur ASC";

            $query = $dbh->prepare($sql);
            $query->execute([
                'search' => $data[0]
            ]);
            $allUsers = $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            header("Location: /search-user.php");
        }
    } else {
        // récupérer tous les utilisateurs
        $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
        LEFT JOIN role ON utilisateur.id_role = role.id_role ORDER BY utilisateur.nom_utilisateur ASC";
        $query = $dbh->query($sql);
        $allUsers = $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
else
{
    if (!empty($_GET['submit'])) {
        if (!empty($_GET['search'])) {
            $search = htmlspecialchars($_GET['search']);
            $data = explode(" ", $search);

            $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
            LEFT JOIN role ON utilisateur.id_role = role.id_role
            WHERE utilisateur.is_active = 1 
            AND utilisateur.nom_utilisateur = :search
            OR utilisateur.prenom_utilisateur = :search
            OR role.libelle_role = :search
            ORDER BY utilisateur.nom_utilisateur ASC";

            $query = $dbh->prepare($sql);
            $query->execute([
                'search' => $data[0]
            ]);
            $allUsers = $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            header("Location: /search-user.php");
        }
    } else {
        // récupérer tous les utilisateurs
        $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
        LEFT JOIN role ON utilisateur.id_role = role.id_role 
        WHERE utilisateur.is_active = 1 
        ORDER BY utilisateur.nom_utilisateur ASC";
        $query = $dbh->query($sql);
        $allUsers = $query->fetchAll(PDO::FETCH_ASSOC);
    }
}    

// maj de is_active

if (!empty($_POST['isActive'])) {
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        $sql = "UPDATE utilisateur SET is_active = :is_active WHERE id_utilisateur = :id_utilisateur";
        $query = $dbh->prepare($sql);
        $active = $query->execute([
            'is_active' => $isActive,
            'id_utilisateur' => $_POST['id_utilisateur']
        ]);
        header("Location: /search-user.php");
}


$title = "AlertMNS - Recherche utilisateur";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

?>
<link rel="stylesheet" href="/assets/css/search-user.css">
<link rel="stylesheet" href="/assets/css/style.css">
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
        <nav class="sidebar">
            <div class="top-icons">
                <a href="<?php if(in_array("Administrateur", $_SESSION['user']['roles'])): ?> /admin <?php else: ?> /user <?php endif; ?>"><i class="fa-solid fa-house fa-2x"></i></a>
                <a href="<?php if(in_array("Administrateur", $_SESSION['user']['roles'])): ?> /admin/messages.php <?php else: ?> /user/messages.php  <?php endif; ?>"><i class="fa-solid fa-comment-dots fa-2x"></i>
                    <p>Voir tous les messages</p>
                </a>
                <a href=""><i class="fa-solid fa-users fa-2x"></i>
                    <p> Voir tous les groupes</p>
                </a>
                <a href="<?php if(in_array("Administrateur", $_SESSION['user']['roles'])): ?> /admin/chaines <?php else: ?> /user/chaines  <?php endif; ?>"><i class="fa-solid fa-tower-cell fa-2x"></i>
                    <p>Voir toutes les chaînes</p>
                </a>
                <a href=""><i class="fa-regular fa-calendar-days fa-2x"></i>
                    <p>Voir les réunions</p>
                </a>
            </div>

            <div class="bottom-icons">
                <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
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
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-sidebar.php" ?>

            <!-- recherche utilisateur -->
            <section>
                <div class="search">
                    <h1>Rechercher un utilisateur</h1>
                    <form action="/search-user.php" method="GET">
                        <input type="search" name="search" class="search-bar" id="searchInput">
                        <input type="submit" name="submit" value="Rechercher" class="submit" id="searchBtn">
                    </form>

                    <h2>Utilisateurs :</h2>
                    <hr>

                    <?php foreach ($allUsers as $user) : ?>
                        <div class="user-info">
                            <div class="user">
                                <img src="https://dummyimage.com/60x60/1D2D44/ffffff.png?text=Logo" alt="">
                                <div>
                                    <p><?= $user['prenom_utilisateur'] . " " . $user['nom_utilisateur'] ?> </p>
                                    <small><?= $user['libelle_role'] ?></small>
                                </div>
                            </div>
                            <div>
                                <a href=""><i class="fa-solid fa-paper-plane fa-xl"></i></a>
                                <?php if (in_array("Administrateur", $_SESSION['user']['roles'])) : ?>
                                    <a href="/admin/users/edit-user.php?id=<?= $user['id_utilisateur'] ?>"><i class="fa-solid fa-pen-to-square fa-xl"></i></a>
                                    <form action="/search-user.php" method="post">
                                    <input type="hidden" name="id_utilisateur" value="<?= $user['id_utilisateur'] ?>">
                                        <label class="switch">
                                            <input type="checkbox" name="is_active" <?= $user['is_active'] == 1 ? 'checked' : '' ?>>
                                            <span></span>
                                        </label>
                                        <input type="submit" name="isActive" class="is-active" value="Envoyer">
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

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

        <section class="section-squares">
            <div class="squares-mob">
                <ul>
                    <a href="">
                        <li><i class="fa-solid fa-magnifying-glass fa-xl"></i>Rechercher un utilisateur</li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-tower-cell fa-xl"></i>Voir les chaînes</li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-users fa-xl"></i>Voir les groupes</li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-comment-dots fa-xl"></i>Voir les messages</li>
                    </a>
                    <a href="">
                        <li><i class="fa-regular fa-calendar-days fa-xl"></i>Voir les réunions prévues</li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-circle-exclamation fa-xl"></i>Signalements reçus</li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer un utilisateur</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer un groupe</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer une chaine</span></li>
                    </a>
                </ul>
            </div>
        </section>

    </main>

    <footer></footer>
    <script src="../assets/js/script.js"></script>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>