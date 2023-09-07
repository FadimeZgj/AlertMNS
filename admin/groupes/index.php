<?php

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

$title = "AlertMNS - Groupes";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();
$reunions = getAllReunions();
$groupes = getAllGroupes();

?>

<link rel="stylesheet" href="/assets/css/messages.css">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/groupes.css">
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

    <header>
        <div class="topbar">
            <div class="logo">
                <img src='/assets/images/logo1.png' alt='Logo'>
                <h3>Groupes</h3>
            </div>
            <div class="user-info">
            <a href="/profil"><img src="<?= $utilisateur['image_profile']!=null ? 
                '../' . $utilisateur['image_profile'] : 
                'https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' ?>" alt="Image Profil" /></a>
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
        <div class="messages">
            <!--Entête message-->
            <div class="entete-message">
                <h1>Groupes</h1>
                <a href="/admin/groupes/new.php"><i class="fa-solid fa-pen-to-square fa-2xl"></i></a>
            </div>

            <!--Barre de recherche-->
            <div class="search-groupe">
                <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher...">
            </div>

            <!--Liste des messages-->

            <div class="liste-groupes" id="conv">

            <?php foreach ($groupes as $groupe): ?>
                <div class="groupes" id="nomGroupe_<?php echo $groupe["id_groupe"] ?>">
                    <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Groupe' alt="logo groupe">
                    <h3 id="groupe">
                        <a>
                            <?= $groupe['nom_groupe'] ?>
                        </a>

                        <form action="/admin/groupes/delete.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce groupe ?')">
                        <input type="hidden" name="id_groupe" value="<?= $groupe['id_groupe'] ?>">
                        <button type="submit"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </h3>
                </div>
            <?php endforeach; ?> <!-- liste-messages-->

        </div> <!--ferme <div> Messages-->

        <!--Interface principale des messages-->
        <div class="messages-interface" style="display: none;">
            <div class="top-header-messages">
                <h3 id="dest-name"></h3>
                <div class="search-message">
                    <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher...">
                </div>
                <i class="fa-solid fa-ellipsis fa-2xl"></i>
            </div>

            <div class="conversation-interface">

                <!--Bulle de discussion de l'autre personne-->
                <div id="conversation">
                    
                </div>
            </div>
            <div class="text-zone">
                <!-- Boîte de dialogue -->
                <div class="chatbox">
                    <form action="/admin/messages.php" method="post" id="message">
                        <label for="text_message"></label>
                        <input type="hidden" name="id_utilisateur">
                        <input type="text" name="text_message" placeholder="Ecrivez votre message..." id="message-input"> 
                </div>

                <!-- Icônes de la boîte de dialogue-->
                <div class="icons-group">
                    <i class="fas fa-images fa-xl"></i>
                    <i class="fa-regular fa-face-smile fa-xl"></i>
                    <i class="fa-solid fa-ellipsis fa-2xl"></i>
                    <div class="send-button">
                        <input type="submit" value="Envoyer" name="submit" id="send-message-btn">
                    </div>
                    </form>
                </div>
            </div>
        </div><!-- ferme <div> container-->

    </div>

    <script>

// var viewMembersModal = document.getElementById("viewMembersModal");

// // On récupère le bouton qui permet d'ouvrir la modale
// var viewMembersModalButton = document.getElementById("viewMembersModalButton")

// // On récupère la classe close du <span> qui permet de fermer la modale
// var closeModalViewMembers = document.getElementById("closeModalViewMembers");

// // Quand l'utilisateur clic sur le bouton, cela ouvre la modale
// viewMembersModalButton.onclick = function () {
//     viewMembersModal.style.display = "block";
// }

// // Quand l'utilisateur clique sur la croix <span> (x), cela ferme la modale
// closeModalViewMembers.onclick = function () {
//     viewMembersModal.style.display = "none";
// }

// // Quand l'utilisateur clique en dehors de la modale, cela la ferme
// window.onclick = function (event) {
//     if (event.target == viewMembersModal) {
//         viewMembersModal.style.display = "none";
//     }
// }

    </script>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>