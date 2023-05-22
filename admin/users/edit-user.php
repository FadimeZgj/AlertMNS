<?php
require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';
unset($_SESSION['error']);

$user = getLoggedUser();
$roles = getAllRoles();


// Récupérer tous les utilisateurs
// $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
// LEFT JOIN role ON utilisateur.id_role = role.id_role
// WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
// $query = $dbh->query($sql);
// $utilisateur = $query->fetch(PDO::FETCH_ASSOC);

// $sql = "SELECT * FROM role";
// $query = $dbh->query($sql);
// $roles = $query->fetchAll(PDO::FETCH_ASSOC);

// if(empty($_GET['id']))
// {
//     header("Location: /search-user.php"); die;
// }

if (!empty($_POST['submit'])) {

    $errors = [];

    if (empty($_POST['user']['nom_utilisateur']))
        $errors['nom_utilisateur'] = "Saisissez le nom.";

    if (empty($_POST['user']['prenom_utilisateur']))
        $errors['prenom_utilisateur'] = "Saisissez le prenom.";

    if (empty($_POST['user']['email_utilisateur']))
        $errors['email_utilisateur'] = "Saisissez l'adresse email.";

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['values'] = $_POST;
        header("Location: /admin/users/edit-user.php?id=" . $_GET['id']);
        die;
    }

    $_POST['user']['nom_utilisateur'] = htmlspecialchars($_POST['user']['nom_utilisateur']);
    $_POST['user']['prenom_utilisateur'] = htmlspecialchars($_POST['user']['prenom_utilisateur']);
    $_POST['user']['email_utilisateur'] = htmlspecialchars($_POST['user']['email_utilisateur']);

    // On insère l'utilisateur en BDD
    // $sql = "UPDATE utilisateur 
    //  SET nom_utilisateur = :nom_utilisateur, 
    //  prenom_utilisateur = :prenom_utilisateur, 
    //  email_utilisateur = :email_utilisateur,
    //  id_role = :id_role
    //  WHERE id_utilisateur = :id_utilisateur";
    // $query = $dbh->prepare($sql);
    // $res = $query->execute([
    //     'nom_utilisateur' => $_POST['nom_utilisateur'],
    //     'prenom_utilisateur' => $_POST['prenom_utilisateur'],
    //     'email_utilisateur' => $_POST['email_utilisateur'],
    //     'id_role' => $_POST['id_role'],
    //     'id_utilisateur' => $_GET['id']
    // ]);

    $updateUser = updateUser($_POST['user']);


    if ($updateUser) {
        header("Location: /search-user.php");
        exit;
    } else {
        $_SESSION['error'] = "Une erreur est survenue.";
        header("Location: /admin/users/edit-user.php?id=" . $_GET['id']);
        die;
    }
}

// Récupération des informations de la utilisateur à modifier
// $sql = "SELECT * FROM utilisateur 
// LEFT JOIN role ON utilisateur.id_role = role.id_role WHERE utilisateur.id_utilisateur = :id_utilisateur";
// $query = $dbh->prepare($sql);
// $res = $query->execute(['id_utilisateur' => $_GET['id']]);
// $userEdit = $query->fetch(PDO::FETCH_ASSOC);

$userEdit = getUserById($_GET['id']);

$title = "AlertMNS - Modifier utilisateur";
include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php'
?>

<link rel="stylesheet" href="../../assets/css/add-user.css">
<link rel="stylesheet" href="../../assets/css/style.css">
<link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>

<body>
    <header>
        <div class="name-dashboard">

            <h1>Dashboard Administrateur</h1>
        </div>
        <div class="name-user">
            <div>
                <h2><?= $user['prenom_utilisateur'] ?> <?= $user['nom_utilisateur'] ?></h2>
                <p><?= $user['libelle_role'] ?></p>
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
                <li><a href="/admin"><i class="fa-solid fa-house fa-2x"></i>Accueil</a></li>
                <li><a href="/admin/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>Voir tous les messages</a></li>
                <li><a href="#"><i class="fa-solid fa-users fa-2x"></i>Voir tous les groupes</a></li>
                <li><a href="/admin/chaines"><i class="fa-solid fa-tower-cell fa-2x"></i>Voir toutes les chaînes</a></li>
                <li><a href="#"><i class="fa-regular fa-calendar-days fa-2x"></i>Voir les réunions</a></li>
                <li><a href="#"><i class="fa-solid fa-user fa-2x"></i>Gérer mon profil</a></li>
                <li><a href="#"><i class="fa-solid fa-gear fa-2x"></i>Réglages</a></li>
                <li><a href="../../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <nav class="sidebar">
            <div class="top-icons">
                <a href="/admin"><i class="fa-solid fa-house fa-2x"></i></a>
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
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-sidebar.php'; ?>

            <!-- Cadre ajout utilisateur -->
            <section>
                <div class="add">
                    <h1>Modifier l'utilisateur</h1>

                    <form action="/admin/users/edit-user.php?id=<?= $userEdit['id_utilisateur'] ?>" method="post" id="addUserForm" name="user">
                        <div class="form-name">
                            <div class="form-name-lastname">
                                <input type="hidden" name="user[id_utilisateur]" value="<?= $userEdit['id_utilisateur'] ?>">
                                <label for="user[nom_utilisateur]">Nom</label>
                                <input type="text" name="user[nom_utilisateur]" value="<?= $userEdit['nom_utilisateur'] ?>" id="lastname">
                                <small class="error" id="errorName"></small>
                                <?php if (isset($_SESSION['errors']['nom_utilisateur'])) : ?>
                                    <small class="error"><?= $_SESSION['errors']['nom_utilisateur'] ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="form-name-firstname">
                                <label for="user[prenom_utilisateur]">Prénom</label>
                                <input type="text" name="user[prenom_utilisateur]" value="<?= $userEdit['prenom_utilisateur'] ?>" id="firstname">
                                <small class="error" id="errorFirstname"></small>
                                <?php if (isset($_SESSION['errors']['prenom_utilisateur'])) : ?>
                                    <small class="error"><?= $_SESSION['errors']['prenom_utilisateur'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label for="user[email_utilisateur]">Adresse email</label>
                        <input type="email" placeholder="Adresse@email.com" name="user[email_utilisateur]" value="<?= $userEdit['email_utilisateur'] ?>" id="email">
                        <small class="error" id="errorEmail"></small>
                        <?php if (isset($_SESSION['errors']['email_utilisateur'])) : ?>
                            <small class="error"><?= $_SESSION['errors']['email_utilisateur'] ?></small>
                        <?php endif; ?>

                        <div class="role">
                            <label for="user[id_role]">Rôle</label>
                            <select name="user[id_role]" id="">
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?= $role['id_role'] ?>" <?php if ($role['id_role'] == $userEdit['id_role']) echo "selected"; ?>>
                                        <?= $role['libelle_role'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>


                        <input type="submit" class="submit" value="Modifier" name="submit">
                    </form>
                    <?php if (isset($_SESSION['error'])) : ?>
                        <p class="invalid"><?= $_SESSION['error'] ?></p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php unset($_SESSION['errors']); ?>

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
    <script src="../../assets/js/script.js"></script>
    <script src="../../assets/js/addUser.js"></script>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php' ?>