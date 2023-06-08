<?php

unset($_SESSION['error']);

require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';


$title = "AlertMNS - Créer une nouvelle réunion";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();
$groupes = getAllGroupes();
$reunions = getAllReunions();


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
                        class="fa-solid fa-arrow-left fa-lg"></i> <span class="hide">Aller à la liste des réunions</span></button></a>
        </div>
        <!--Information de la colonne de droite-->
        <div class="container-create-reunions">
            <div class="createReunionForm">
                <form action="/admin/reunions/new-POST.php" method="post" name="addReunionForm">
                    <h1 class="createReunionTitle">Créer une nouvelle réunion</h1>

                    <div class="form-group-add-reunion">
                        <label for="nom">Nom de la réunion</label>
                        <input type="text" id="reunionName" name="nom_reunion" class="createReunionInput"
                            placeholder="Saisissez le nom de la réunion"
                            value="<?php echo isset($_SESSION['values']['nom_reunion']) ? $_SESSION['values']['nom_reunion'] : ''; ?>" />

                        <small class="errorCreateReunion" id="errorReunionName"></small>
                        <?php if (isset($_SESSION['errors']['nom_reunion'])): ?>
                            <!-- Si JavaScript est désactivé, on affiche un message d'erreur-->
                            <noscript>
                                <small class="errorCreateReunion">
                                    <?= $_SESSION['errors']['nom_reunion'] ?>
                                </small>
                            </noscript>
                        <?php endif; ?>
                    </div>

                    <div class="form-group-add-reunion">
                        <label for="date">Date de la réunion</label>
                        <input type="datetime-local" id="dateReunion" name="date_reunion" class="createReunionInput"
                            value="<?php echo isset($_SESSION['values']['date_reunion']) ? $_SESSION['values']['date_reunion'] : ''; ?>">

                        <small class="errorCreateReunion" id="errorDateReunion"></small>
                        <?php if (isset($_SESSION['errors']['date_reunion'])): ?>
                            <!-- Si JavaScript est désactivé, on affiche un message d'erreur-->
                            <noscript>
                                <small class="errorCreateReunion">
                                    <?= $_SESSION['errors']['date_reunion'] ?>
                                </small>
                            </noscript>
                        <?php endif; ?>
                    </div>

                    <div class="form-group-add-reunion">
                        <label for="sujet">Sujet de la réunion</label>
                        <input type="text" id="reunionSubject" name="sujet_reunion" class="createReunionInput"
                            placeholder="Ex : Réunion avec l'équipe pédagogique"
                            value="<?php echo isset($_SESSION['values']['sujet_reunion']) ? $_SESSION['values']['sujet_reunion'] : ''; ?>">

                        <small class="errorCreateReunion" id="errorReunionSubject"></small>
                        <?php if (isset($_SESSION['errors']['sujet_reunion'])): ?>
                            <!-- Si JavaScript est désactivé, on affiche un message d'erreur-->
                            <noscript>
                                <small class="errorCreateReunion" id="reunionSubjectMissing">
                                    <?= $_SESSION['errors']['sujet_reunion'] ?>
                                </small>
                            </noscript>
                        <?php endif; ?>
                    </div>


                    <div class="form-group-add-reunion">
                        <label for="groupe">Veuillez choisir le groupe qui participera à la réunion</label>
                        <select name="groupe" class="createReunionSelectGroup">
                            <!-- <option value="">Veuillez choisir un groupe</option> -->
                            <?php foreach ($groupes as $groupe): ?>
                                <option value="<?= $groupe['id_groupe'] ?>">
                                    <?= $groupe['nom_groupe'] ?>
                                </option>
                            <?php endforeach; ?>

                    <p>Pas de groupe ?</p>
                    <a href="/admin/groupes/new.php"><button class="noGroupBtn"><i class="fa-solid fa-plus fa-lg"></i>
                            Créer un nouveau groupe</button></a>

                    </div>
                    <div class="form-group-add-reunion">
                        <input type="submit" name="submit" value="Créer" class="submitCreateReunionBtn"
                            id="submitAddReunionForm">
                    </div>
                </form>

                <?php if (isset($_SESSION['error'])): ?>
                    <p class="invalid">
                        <?= $_SESSION['error'] ?>
                    </p>
                <?php endif; ?>

                <!-- Permet d'enlever les erreurs quand on revient sur la page -->
                <?php unset($_SESSION['errors']); ?>
                <!-- Permet d'enlever les valeurs des input quand on revient/quitte la page -->
                <?php unset($_SESSION['values']); ?>

                <div class="form-group-noGroup">
                    <p>Pas de groupe ?</p>
                    <a href="/admin/groupes/new.php"><button class="noGroupBtn"><i class="fa-solid fa-plus fa-lg"></i>
                            Créer un nouveau groupe</button></a>
                </div>

            </div>

        </div>
    </div>
    <script>

    </script>

    <script src="/assets/js/reunions.js"></script>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>