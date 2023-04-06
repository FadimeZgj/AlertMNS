<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/admin/managers/chaines-manager.php';

$salons = getAllSalons();
$utilisateurs = getAllUsers();
$chaines = getAllChaines();
$user = getUserSession();
$messages = getAllMessages();


// Fonctions pour ajouter un salon à une chaîne

if (isset($_POST['submit'])) {
    $id = insertSalon($_POST['salon']);

    if ($id) {
        header("Location: /chaines");
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chaînes</title>
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <link rel="stylesheet" href="/assets/css/chaines.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/5b104128e4.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="sidebar">
        <ul class="nav-left">
            <li><a href="#"><i class="fas fa-house-chimney-window fa-xl"></i></a></li>
            <li><a href="#"><i class="fa-solid fa-comment-dots fa-xl"></i></a></li>
            <li><a href="#"><i class="fa-solid fa-users-rectangle fa-xl"></i></a></li>
            <li><a href="/admin/chaines/index.php"><i class="fa-solid fa-diagram-project fa-xl"></i></a></li>
            <li><a href=""><i class="fa-regular fa-calendar fa-xl"></i></a></li>
        </ul>
    </nav>
    <nav class="responsive-menu">
        <div class="burger-icon">
            <button id="burgerMenu">
                <i class="fa-solid fa-bars fa-2xl"></i>
            </button>
            <button id="closeMenu" class="closeMenu">
                <i class="close fa-solid fa-xmark fa-2xl"></i>
            </button>
        </div>
        <ul id="responsiveMenu" class="ul">
            <li><a href="/admin/index.php"><i class="fa-solid fa-house"></i> Accueil</a></li>
            <li><a href="/messages.html"><i class="fa-solid fa-comment-dots"></i> Voir tous les messages</a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Voir tous les groupes</a></li>
            <li><a href="/admin/chaines/index.php"><i class="fa-solid fa-tower-cell"></i> Voir toutes les chaînes</a>
            </li>
            <li><a href="#"><i class="fa-regular fa-calendar"></i> Voir les réunions prévues</a></li>
            <li><a href="#"><i class="fa-solid fa-user"></i> Gérer mon profil</a></li>
            <li><a href="#"><i class="fa-solid fa-gear"></i> Réglages</a></li>
            <li><a href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i> Se déconnecter</a></li>
        </ul>
    </nav>



    <div class="container">
        <div class="chaines" id="chaines">
            <h2>Chaînes</h2>
            <?php foreach ($chaines as $chaine): ?>
                <div class="channel-group" id="nomChaine_<?php echo $chaine["id_chaine"] ?> ">
                    <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                    <h3 id="chaine">
                        <?= $chaine['nom_chaine'] ?>
                    </h3>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="salons" id="salons">
            <div class="top-header-nom-salon">
                <i class="fa-solid fa-chevron-left fa-2xl" id="leftArrow"></i>
                <h2 id="chaineTitle">
                    <?= $chaine['nom_chaine'] ?>
                </h2>
                <i class="fa-solid fa-chevron-right fa-2xl"></i>
            </div>
            <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher un salon...">
            <div class="create-salon">
                <div class="add">
                    <h3>Salons</h3>
                    <i class="fas fa-plus fa-2xl" id="createSalonModalButton"></i>
                    <div class="modal" id="addSalonModal">
                        <div class="modal-content">
                            <span class="closeModal" id="closeModal">&times;</span>
                            <h3>Création d'un salon</h3>

                            <form action="/admin/chaines/index.php" method="POST">
                                <label for="newSalon"></label>
                                <input type="text" name="salon[nom_salon]">
                                <input type="submit" name="submit" value="Envoyer">
                            </form>

                        </div>
                    </div>
                </div>
                <div class="salons-liste" id="listeSalon">
                    <?php foreach ($salons as $salon): ?>
                        <div class="salon" style="display: none;">
                            <?= $salon['nom_salon'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Concerne l'entête de la discussion -->
        <div class="discussion" id="discussion">
            <div class="topbar">
                <h2 id="nomSalon">
                    <?= $salon['nom_salon'] ?>
                </h2>
                <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher...">

                <!-- Icône et modale des utilisateurs -->
                <i class="fa-solid fa-user-group fa-xl" id="viewMembersModalButton"></i>
                <div class="modal" id="viewMembersModal">
                    <div class="modal-content-view-members">
                        <span class="closeModal" id="closeModalViewMembers">&times;</span>
                        <h3>Membres</h3>
                        <?php foreach ($utilisateurs as $utilisateur): ?>
                            <div class="members-info">
                                <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                                <div class="nameAndRole">
                                    <h4>
                                        <?= $utilisateur["prenom_utilisateur"] ?>
                                        <?= $utilisateur["nom_utilisateur"] ?>
                                    </h4>
                                    <h5>
                                        <?= $utilisateur["libelle_role"] ?>
                                    </h5>
                                </div>
                                <div class="modal-icons">
                                    <i class="fa-regular fa-paper-plane fa-lg"></i>
                                    <i class="fa-regular fa-trash-can fa-lg"></i>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- icône et menu pour les 3 petits points-->
                <i class="fa-solid fa-ellipsis fa-2xl" id="clickEllipsis"></i>
                <div class="chat-menu" id="showChatMenu">
                    <ul class="chat-menu-options">
                        <li id="closeEllipsisMenu"><i class="fa-solid fa-xmark fa-2xl"></i></li>
                        <li><a href="#"><i class="fas fa-pen fa-xl"></i> Modifier le nom du salon</a></li>
                        <li><a href="#"><i class="fas fa-volume-xmark fa-xl"></i> Mettre en sourdine</a></li>
                        <li><a href="#"><i class="fas fa-bell fa-xl"></i> Paramètre de notifications</a></li>
                        <li><a href="#"><i class="fas fa-folder fa-xl"></i> Voir les fichiers partagés</a></li>
                        <li><a href="#"><i class="fas fa-trash fa-xl"></i> Supprimer le salon</a></li>
                    </ul>
                </div>

            </div>

            <!-- Pour les bulles de discussions-->

            <!--Bulle de discussion de l'autre personne-->
            <div class="conversation">
                <div class="message-me">
                    <div class="user-info">
                        <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                    </div>
                    <div class="bulle">
                        <div class="info">
                            <p class="name">Nom</p>
                            <p class="date">14 mai 2022</p>
                        </div>
                        <div class="arrow-left">
                        </div>
                        <div class="contenu-message">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet
                                consectetur adipisicing elit. Expedita adipisci magni magnam nostrum, at beatae
                                reprehenderit exercitationem asperiores ex ipsam quam veniam sequi quisquam sapiente
                                animi accusantium dolor sunt quia?</p>
                        </div>
                    </div>
                </div>

                <!--Bulle de discussion de l'utilisateur-->
                <div class="message-user">
                    <div class="bulle-user">
                        <div class="info">
                            <p class="name">
                                <?= $user['prenom_utilisateur'] ?>
                            </p>
                            <p class="date">
                                <?= $messages['date_message'] ?>
                            </p>
                        </div>
                        <div class="bubble-right">
                            <div class="contenu-my-message">
                                <p>
                                    <?= $messages['text_message'] ?>
                                </p>
                            </div>
                            <div class="arrow-right">
                            </div>
                        </div>
                    </div>
                    <div class="my-info">
                        <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                    </div>
                </div>

                <!-- Deuxième bulle de l'autre personne-->

                <div class="conversation">
                    <div class="message-me">
                        <div class="user-info">
                            <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                        </div>
                        <div class="bulle">
                            <div class="info">
                                <p class="name">Nom</p>
                                <p class="date">14 mai 2022</p>
                            </div>
                            <div class="arrow-left">
                            </div>
                            <div class="contenu-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet
                                    consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boîte de dialogue -->
                    <form action="/admin/chaines/index.php" method="post">
                        <div class="chatbox">
                            <input type="text" placeholder="Ecrivez votre message..." name="text_message">
                        </div>


                        <!-- Icônes de la boîte de dialogue-->
                        <div class="icons-group">
                            <i class="fas fa-images fa-xl"></i>
                            <i class="fa-regular fa-face-smile fa-xl"></i>
                            <i class="fa-solid fa-ellipsis fa-2xl"></i>
                            <div class="send-button">
                                <input type="submit" value="Envoyer" name="submit">
                                <!-- <?php
                                //if (!empty($_POST['submit'])) {
                                //    $sql = "INSERT INTO message (text_message, date_message) VALUES (:text_message, NOW())";
                                //    $query = $dbh->prepare($sql);
                                //    $res = $query->execute([
                                //       'text_message' => $_POST['text_message'],
                                //   ]);
                                //} ?> -->
                            </div>
                        </div>
                    </form>
                </div><!--conversation-->
            </div> <!--discussion -->
        </div> <!--container -->
    </div>
    <script>


        ///////// JSON qui permet de recharger la liste des salons \\\\\\\\\\\

        // Affichage de la liste des salons

        // On récupère toutes les chaînes générés par le PHP qui ont la classe "channel-group"
        const channelGroup = document.querySelectorAll(".channel-group");

        for (let i of channelGroup) {
            i.addEventListener("click", (e) => {
                listeSalon.innerHTML = ""
                fetch('../../get_salon.php?id_chaine=' + i.id).then(function (response) {
                    return response.json();
                }).then(function (monjson) {
                    console.log(monjson)
                    for (j = 0; j < monjson.length; j++) {
                        // On créer une div
                        var div = document.createElement('div');
                        // A cette div on rajoute la classe "salon"
                        div.classList.add('salon');
                        // On créer le texte "salon" afin de rajouter la
                        var salon = document.createTextNode('salon')
                        div.appendChild(salon)
                        div.innerHTML = monjson[j].nom_salon;
                        // console.log(monjson[j].nom_salon) // Recupère bien tous les salons
                        document.getElementById('listeSalon').appendChild(div);
                    }


                })
            })
        }

        ///////// JSON qui permet d'afficher le nom de chaîne correct au-dessus de la liste des salons \\\\\\\\\\\
        
        // On récupère les chaînes contenant la classe "channel-group"
        let chaineListe = document.querySelectorAll(".channel-group");

        let chaineTitle = document.getElementById("chaineTitle")
        // console.log(chaineTitle);

        for (let i of chaineListe) {
            i.addEventListener("click", (e) => {
                chaineTitle.innerHTML = ""
                fetch('../../get_chaines.php?id_chaine=' + i.id).then(function (response) {
                    return response.json();
                }).then(function (monjson) {
                    console.log(monjson)

                    for (j = 0; j < monjson.length; j++) {
                        chaineTitle.innerHTML = monjson[j].nom_chaine;
                    }
                    document.getElementById('chaineTitle').appendChild(chaineTitle);
                })
            })
        }

        ///////// JSON qui permet d'afficher le salon correct au-dessus de la liste des salons \\\\\\\\\\\

        // On récupère tous les salons générés en JSON qui ont la classe "salon"
        const salonGroup = document.querySelectorAll(".salon");

        for (let i of salonGroup) {
            i.addEventListener("click", (e) => {
                listeSalon.innerHTML = ""
                fetch('../../get_salon.php?id_chaine=' + i.id).then(function (response) {
                    return response.json();
                }).then(function (monjson) {
                    console.log(monjson)
                    for (j = 0; j < monjson.length; j++) {
                        // On créer une div
                        var div = document.createElement('div');
                        // A cette div on rajoute la classe "salon"
                        div.classList.add('salon');
                        // On créer le texte "salon" afin de rajouter la
                        var salon = document.createTextNode('salon')
                        div.appendChild(salon)
                        div.innerHTML = monjson[j].nom_salon;
                        // console.log(monjson[j].nom_salon) // Recupère bien tous les salons
                        document.getElementById('listeSalon').appendChild(div);
                    }


                })
            })
        }

    </script>
    <script src="/assets/js/chaines.js"></script>
</body>

</html>