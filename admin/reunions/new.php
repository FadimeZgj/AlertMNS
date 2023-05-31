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

// Traiter le formulaire si envoyé
// Permet de créer une nouvelle réunion
if (!empty($_POST['submit'])) {

    $sql = "INSERT INTO reunion (nom_reunion, date_reunion, sujet_reunion, id_utilisateur, id_groupe) VALUES (:nom_reunion,:date_reunion, :sujet_reunion, :id_utilisateur, :id_groupe)";
    $query = $dbh->prepare($sql);
    $res = $query->execute([
        'nom_reunion' => htmlspecialchars($_POST['nom_reunion']),
        'date_reunion' => $_POST['date_reunion'],
        'sujet_reunion' => htmlspecialchars($_POST['sujet_reunion']),
        'id_utilisateur' => $_SESSION['user']['id'],
        'id_groupe' => $_POST['groupe']
    ]);

    if ($res) {
        header("Location: /admin/reunions/");
        exit;
    } else {
        echo "Une erreur est survenue...";
    }

}

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
        <div class="containerLeftInfoCreate">
            <a href="/admin/reunions/index.php"><button class="goBackReunionBtn"><i
                        class="fa-solid fa-arrow-left fa-lg"></i> Revenir à la liste des réunions</button></a>
        </div>
        <!--Information de la colonne de droite-->
        <div class="container-create-reunions">
            <div class="createReunionForm">
                <form action="/admin/reunions/new.php" method="post">
                    <h1 class="createReunionTitle">Créer une nouvelle réunion</h1>

                    <div class="form-group">
                    <label for="nom">Nom de la réunion</label>
                    <input type="text" name="nom_reunion" placeholder="Saisissez le nom de la réunion"/>
                    </div>

                    <div class="form-group">
                        <label for="date">Date de la réunion</label>
                        <input type="datetime-local" name="date_reunion">
                    </div>

                    <div class="form-group">
                    <label for="sujet">Sujet de la réunion</label>
                        <input type="text" name="sujet_reunion" placeholder="Ex : Réunion avec l'équipe pédagogique">
                    </div>
                    <div class="form-group">
                        <label for="groupe">Veuillez choisir le groupe qui participera à la réunion</label>
                        <select name="groupe" class="createReunionSelectGroup">
                            <?php foreach ($groupes as $groupe): ?>
                                <option value="<?= $groupe['id_groupe'] ?>">
                                    <?= $groupe['nom_groupe'] ?>
                                </option>
                            <?php endforeach; ?>

                    </div>
                    <div class="form-group">
                    <input type="submit" name="submit" value="Créer" class="submitCreateReunionBtn">
                    </div>
                </form>

                <div class="form-group-noGroup">
                    <p>Pas de groupe ?</p>
                    <a href="/admin/groupes/new.php"><button class="noGroupBtn"><i class="fa-solid fa-plus fa-lg"></i> Créer un nouveau groupe</button></a>
                </div>

            </div>

        </div>
    </div>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>