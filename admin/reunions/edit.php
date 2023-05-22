<?php

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

$title = "AlertMNS - Créer une nouvelle réunion";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();

// Vérification du paramètre
if(empty($_GET['id']))
{
    header("Location: /admin/reunions"); die;
}

// Traiter le formulaire si envoyé
if(!empty($_POST['submit']))
{

    if(updateReunion($_GET['id']))
    {
        header("Location: /admin/reunions/");
    }
    else
    {
        echo "Une erreur est survenue...";
    }

}

// // Récupération des informations de la réunion à modifier
$reunion = getReunionById($_GET['id']);

// On vérifie si l'la réunion est bien présente en BDD
if(!$reunion)
{
    header("Location: /admin/reunions"); die;
}

// On récupère les groupes
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
        <div class="containerLeftInfo">
            <a href="/admin/reunions/index.php"><button class="createReunionBtn"><i class="fa-solid fa-arrow-left fa-lg"></i> Revenir à la liste des réunions</button></a>
        </div>
        <div class="container-reunions">
            <h1>Modifier la réunion</h1>
            <div class="createReunionForm">
                <form action="/admin/reunions/edit.php?id=<?= $reunion['id_reunion'] ?>" method="post">
                    <h1 class="createReunionTitle">Créer une nouvelle réunion</h1>

                    <div class="form-group">
                    <label for="nom">Nom de la réunion</label>
                    <input type="text" name="nom" value="<?= $reunion['nom_reunion'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="date">Date de la réunion</label>
                        <input type="date" name="date" value="<?= $reunion['date_reunion'] ?>">
                    </div>
                    
                    <div class="form-group">
                    <label for="sujet">Sujet de la réunion</label>
                        <input type="text" name="sujet" value="<?= $reunion['sujet_reunion'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="groupe">Selectionnez les participants</label>
                        <select name="groupe" class="">
                            <?php foreach ($groupes as $groupe): ?>
                                <option value="<?= $groupe['id_groupe'] ?>">
                                    <?= $groupe['nom_groupe'] ?>
                                </option>
                            <?php endforeach; ?>

                    </div>
                    <div class="form-group">
                    <input type="submit" name="submit" value="Enregistrer les modifications">
                    </div>
                </form>

                <div class="form-group">
                    <label for="no-group">Pas de groupe ?</label>
                    <a href="/admin/groupes/new.php"><button name="no-group">CREER UN NOUVEAU GROUPE</button></a>
                </div>
        </div>
    </div>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>