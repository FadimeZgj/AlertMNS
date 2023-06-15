<?php

unset($_SESSION['error']);

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

$title = "AlertMNS - Modifier une réunion";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();

// Vérification du paramètre, si il n'y a pas d'id on redirige vers la page des réunions
if (empty($_GET['id'])) {
    header("Location: /admin/reunions");
    die;
}


// // Récupération des informations de la réunion à modifier grâce à son ID
$reunion = getReunionById($_GET['id']);

// On vérifie si la réunion est bien présente en BDD
if (!$reunion) {
    header("Location: /admin/reunions");
    die;
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
                <img src="<?= $utilisateur['image_profile']!=null ? 
                '../' . $utilisateur['image_profile'] : 
                'https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' ?>" alt="Image Profil" />
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
        <div class="containerLeftInfoEdit">
            <a href="/admin/reunions/index.php"><button class="goBackReunionBtn"><i
                        class="fa-solid fa-arrow-left fa-lg"></i> <span class="hide">Revenir à la liste des réunions</span></button></a>
        </div>
        <div class="container-edit-reunions">
            <div class="editReunionForm">
                <form action="/admin/reunions/edit-POST.php?id=<?= $reunion['id_reunion'] ?>" method="post">
                    <h1 class="editReunionTitle">Modifier la réunion</h1>

                    <div class="form-group-edit">
                        <label for="nom">Nom de la réunion</label>
                        <input type="text" id="reunionName" name="nom_reunion" value="<?= $reunion['nom_reunion'] ?>">

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

                    <div class="form-group-edit">
                        <label for="date">Date de la réunion</label>
                        <input type="datetime-local" id="dateReunion" name="date_reunion"
                            value="<?= $reunion['date_reunion'] ?>">

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

                    <div class="form-group-edit">
                        <label for="sujet">Sujet de la réunion</label>
                        <input type="text" name="sujet_reunion" id="reunionSubject"
                            value="<?= $reunion['sujet_reunion'] ?>">

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
                    <div class="form-group-edit selectEditGroup">
                        <label for="groupe" class="selectEditLabel">Veuillez choisir le groupe qui participera à la
                            réunion</label>
                        <select name="groupe" class="editReunionSelectGroup">
                            <?php foreach ($groupes as $groupe): ?>
                                <option value="<?= $groupe['id_groupe'] ?>">
                                    <?= $groupe['nom_groupe'] ?>
                                </option>
                            <?php endforeach; ?>

                    </div>

                    <div class="form-group">
                        <input type="submit" id="submitEditReunionForm" name="submit"
                            value="Enregistrer" class="saveEditModificationSubmitBtn">
                    </div>
                </form>

                <?php if (isset($_SESSION['error'])): ?>
                    <p class="invalid">
                        <?= $_SESSION['error'] ?>
                    </p>
                <?php endif; ?>
                <!-- Permet d'enlever les erreurs quand on revient sur la page -->
                <?php unset($_SESSION['errors']); ?>
                <!-- Permet d'enlever les erreurs quand on revient sur la page -->
                <?php unset($_SESSION['values']); ?>

                <form action="/admin/reunions/delete.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réunion ?')">
                                <input type="hidden" name="id_reunion" value="<?= $reunion['id_reunion'] ?>">
                                <button type="submit" class="delete-reunion-btn">Supprimer
                                </button>
                            </form>
            </div>
        </div>

        <script>

            /* Verification du formulaire FocusIn et FocusOut*/

            /* Pour le nom de la réunion */
            const getReunionNameInput = document.querySelector("#reunionName");

            getReunionNameInput.addEventListener("focusin", displayReunionNameError);

            function displayReunionNameError() {
                // Vérifier le champ nom de la réunion
                getReunionNameInput.addEventListener("focusout", function (e) {
                    const errorReunionName = document.querySelector("#errorReunionName");
                    // La couleur du fond se change en rose si le champ ne correspond pas
                    if (this.value.length <= 0) {
                        errorReunionName.innerHTML = "Veuillez saisir le nom de la réunion";
                        this.style.backgroundColor = "#fcb8b3";
                    } else if (this.value.length >= 7) {
                        this.style.backgroundColor = "#b4d6a5";
                        errorReunionName.innerHTML = "";
                    }
                });
            }

            /* On contrôle la date de la réunion */
            const getReunionDateInput = document.querySelector("#dateReunion");

            getReunionDateInput.addEventListener("focusin", displayReunionDateError);

            function displayReunionDateError() {
                // Vérifier le champ date de la réunion

                getReunionDateInput.addEventListener("focusout", function (e) {
                    // Correspond à l'id small en dessous de l'input reunion
                    const errorReunionDate = document.querySelector("#errorDateReunion");
                    // La couleur du fond se change en rouge si le champ ne correspond pas
                    if (this.value.length <= 0) {
                        errorReunionDate.innerHTML =
                            "Veuillez saisir la date et l'heure de la réunion (cliquez sur le calendrier)";
                        this.style.backgroundColor = "#fcb8b3";
                    } else if (this.value.length >= 12) {
                        this.style.backgroundColor = "#b4d6a5";
                        errorReunionDate.innerHTML = "";
                    }
                });
            }

            /* On contrôle le sujet de la réunion */
            const getReunionSubjectInput = document.querySelector("#reunionSubject");

            getReunionSubjectInput.addEventListener("focusin", displayReunionSubjectError);

            function displayReunionSubjectError() {
                // Vérifier le champ sujet de la réunion

                getReunionSubjectInput.addEventListener("focusout", function (e) {
                    // Correspond à l'id small en dessous de l'input reunion
                    const errorReunionSubject = document.querySelector("#errorReunionSubject");
                    // La couleur du fond se change en rouge si le champ ne correspond pas
                    if (this.value.length <= 0) {
                        errorReunionSubject.innerHTML = "Veuillez saisir le sujet de la réunion";
                        this.style.backgroundColor = "#fcb8b3";
                    } else if (this.value.length >= 7) {
                        this.style.backgroundColor = "#b4d6a5";
                        errorReunionSubject.innerHTML = "";
                    }
                });
            }

        </script>

        <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>