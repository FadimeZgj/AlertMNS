<?php

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/admin/chaines-manager.php';

// Récupérer tous les utilisateurs
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);

$chaines = getAllChaines();

// if (!empty($_POST['submit'])) {
//     if (empty($_POST['id'])) {

//         header("Location: /admin/chaines/delete");
//         die;
//     }

//     $sql = "DELETE FROM chaine WHERE id_chaine = :id_chaine";
//     $query = $dbh->prepare($sql);
//     $res = $query->execute([
//         'id_chaine' => $_POST['id']
//     ]);

//     header("Location: /admin/chaines/delete");

// }

// if(!empty($_POST['submit']))
// {
//     // On met à jour les chaînes
//     $sql = "UPDATE chaine 
//     SET nom_chaine = :nom_chaine, 
//     is_active = :is_active
//     WHERE id_utilisateur = :id_utilisateur";
//     $query = $dbh->prepare($sql);
//     $res = $query->execute([
//         'nom_chaine' => $_POST['nom_chaine'],
//         'is_active' => $_POST['is_active'],
//         'id_utilisateur' => $_GET['id'],
//     ]);

//         // On recupère tous les ids des rôles de l'utilisateur
//     // pour comparer avec les rôles envoyés dans le POST
//     $sql = "SELECT chaine.id_chaine FROM chaine
//     JOIN role ON role.id_role = utilisateur_role.id_role 
//     WHERE id_utilisateur = :id_utilisateur";
//     $query = $dbh->prepare($sql);
//     $res = $query->execute([
//         'id_utilisateur' => $_GET['id']
//     ]);

//     $isActive = $query->fetchAll(PDO::FETCH_COLUMN);

//     foreach($isActive as $active)
//     {
//         if(!in_array($active, $disabled))
//         {
//             $sql = "DELETE FROM chaine WHERE is_active = :is_active AND id_utilisateur = :id_utilisateur";
//             $query = $dbh->prepare($sql);
//             $res = $query->execute([
//                 'id_utilisateur' => $_GET['id'],
//                 'is_active' => $active
//             ]);
//         }
//     }
// }

$title = "AlertMNS - Modifier utilisateur";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

?>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/disable-channel.css">
</head>

<body>
    <header>
        <div class="name-dashboard">
            <h1>Dashboard Administrateur</h1>
        </div>
        <div class="name-user">
            <div>
                <h2>
                    <?= $utilisateur['prenom_utilisateur'] ?>
                    <?= $utilisateur['nom_utilisateur'] ?>
                </h2>
                <p>
                    <?= $utilisateur['libelle_role'] ?>
                </p>
            </div>
            <a href=""><img src='https://dummyimage.com/50x50.jpg' alt='' /></a>
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
                <li><a href="/admin/index.php"><i class="fa-solid fa-house fa-2x"></i>Accueil</a></li>
                <li><a href="/admin/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>Voir tous les messages</a></li>
                <li><a href=""><i class="fa-solid fa-users fa-2x"></i>Voir tous les groupes</a></li>
                <li><a href="./admin/chaines/index.php"><i class="fa-solid fa-tower-cell fa-2x"></i>Voir toutes les
                        chaînes</a></li>
                <li><a href="#"><i class="fa-regular fa-calendar-days fa-2x"></i>Voir les réunions</a></li>
                <li><a href="#"><i class="fa-solid fa-user fa-2x"></i>Gérer mon profil</a></li>
                <li><a href="#"><i class="fa-solid fa-gear fa-2x"></i>Réglages</a></li>
                <li><a href="../../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <nav class="sidebar">
            <div class="top-icons">
            <a href="/admin">
                <i class="fa-solid fa-house fa-2x"></i></a>
                <a href="/admin/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>
                    <p>Voir tous les messages</p>
                </a>
                <a href=""><i class="fa-solid fa-users fa-2x"></i>
                    <p> Voir tous les groupes</p>
                </a>
                <a href="/admin/chaines"><i class="fa-solid fa-tower-cell fa-2x"></i>
                    <p>Voir toutes les chaînes</p>
                </a>
                <a href=""><i class="fa-regular fa-calendar-days fa-2x"></i>
                    <p>Voir les réunions</p>
                </a>
            </div>

            <div class="bottom-icons">
                <a href="../../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
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

            <section>
                <div class="squares">
                    <h3 class="chaineTitle">Liste des chaînes</h3>
                    <div class="barreLaterale"></div>
                    <div class="listeChaine">
                        <form action="../../edit-chaine.php" method="POST">
                            <?php foreach ($chaines as $chaine): ?>
                                <div class="affichageChaine" id="nomChaine_<?php echo $chaine["id_chaine"] ?> ">
                                    <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes'
                                        alt="logo chaine">
                                    <h3 id="chaine">
                                        <a>
                                            <?= $chaine['nom_chaine'] ?>
                                        </a>
                                    </h3>
                                </div>
                                <!-- Bouton switch -->
                                <div class="switchButton">
                                    <label class="switch">
                                    <input type="checkbox" id="chaine_<?php echo $chaine['id_chaine'] ?>" name="is_active[]" <?php echo ($chaine['is_active']) ? 'checked' : '0'; ?> value="<?php echo $chaine['id_chaine']; ?>">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" name="submit">Enregistrer les modifications</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        <!-- tablette/mobile -->

        <section class="section-profile">
            <div class="profile-mob">
                <a href=""><img src='https://dummyimage.com/100x100.jpg' alt='' /></a>
                <div class="name-mob">
                    <h2>
                        <?= $utilisateur['prenom_utilisateur'] ?>
                        <?= $utilisateur['nom_utilisateur'] ?>
                    </h2>
                    <p>
                        <?= $utilisateur['libelle_role'] ?>
                    </p>
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