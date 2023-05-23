<?php

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

$title = "AlertMNS - Créer une nouvelle réunion";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();
$groupes = getAllGroupes();
$reunions = getAllReunions();
$users = getAllUsers();
$roles = getAllRoles();

// Traiter le formulaire si envoyé
// Permet de créer une nouvelle réunion
if (!empty($_POST['submit'])) {

    $id = insertUsersInGroups($_POST['groupe'], $_POST['utilisateurs']);

    if ($id) {
        header("Location: /admin/reunions/");
        exit;
    } else {
        echo "Une erreur est survenue...";
    }

}

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
        <div class="containerLeftInfo">
            <a href="/admin/reunions/index.php">
                <button class="goBackReunionBtn">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                    Revenir à la liste des réunions</button>
            </a>
        </div>
        <!--Information de la colonne de droite-->
        <div class="container-create-reunions">
            <div class="createReunionForm">
            <h1 class="createReunionTitle">Créer une nouvelle réunion</h1>
                <form action="/admin/reunions/new.php" method="post">
                    <div class="create-form-group">
                        <div class="form-group">
                            <h3>Créer un groupe (Sélectionnez les participants)</h3>
                            
                            <select name="groupe" class="">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id_role'] ?>">
                                    <?= $role['libelle_role'] ?>
                                </option>
                            <?php endforeach; ?>

                            <label for="groupe">Liste des utilisateurs:</label>
                            <?php foreach ($users as $user): ?>

                                <input type="checkbox" name="utilisateurs[]" value="<?= $user['id_utilisateur'] ?>" ">
                                <?= $user['prenom_utilisateur'] ?>
                                <?= $user['nom_utilisateur'] ?>
                            <?php endforeach; ?>
                        </div>
                        <!--Div pour le nom du groupe-->
                        <div class=" form-group">
                            <label for="nom">Nom du groupe</label>
                            <input type="text" name="groupe[nom_groupe]" />
                        </div>

                        <div class="form-group">
                            <label for="nom">Nom de la réunion</label>
                            <input type="text" name="nom" />
                        </div>

                        <div class="form-group">
                            <label for="sujet">Sujet de la réunion</label>
                            <input type="text" name="sujet">
                        </div>

                        <div class="form-group">
                            <label for="date">Date de la réunion</label>
                            <input type="date" name="date">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" value="Créer">
                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>