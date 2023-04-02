<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

// // Peut-être un potentiel ? //

// $sql = "SELECT *, GROUP_CONCAT(utilisateur.id_utilisateur SEPARATOR ',')
// FROM `chaine` 
// LEFT JOIN utilisateur ON utilisateur.id_utilisateur = chaine.id_utilisateur 
// LEFT JOIN salon ON salon.id_chaine = chaine.id_chaine 
// GROUP BY chaine.id_chaine";


/* On récupère les chaînes */
$sql = "SELECT * from chaine
ORDER BY id_chaine DESC";

$result = $dbh->query($sql);
$chaines = $result->fetchAll(PDO::FETCH_ASSOC);
json_encode($chaines);

/* On récupère les salons de la chaîne Dev Web 1 */

$sql = "SELECT * 
FROM salon 
LEFT JOIN chaine ON salon.id_chaine = chaine.id_chaine
WHERE chaine.nom_chaine = 'Dev Web 1'
ORDER BY nom_chaine ASC;";
$result = $dbh->query($sql);
$salons = $result->fetchAll(PDO::FETCH_ASSOC);


// Récupérer l'utilisateur de la session
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Récupérer tous les utilisateurs
function getAllUsers()
{
    $dbh = $GLOBALS['dbh'];
    $sql = $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
    LEFT JOIN role ON utilisateur.id_role = role.id_role
    ORDER BY id_utilisateur ASC";

    return $dbh->query($sql)->fetchAll();
}

$utilisateurs = getAllUsers();

// $utilisateurs = $query->fetch(PDO::FETCH_ASSOC);
//var_dump($utilisateurs);


// Jointure de la table message avec la table utilisateur et la table recevoir

$sql = 'SELECT message.id_message, message.text_message, message.date_message, 
message.id_utilisateur as id_expediteur, 
recevoir.id_message as message_reception, 
recevoir.id_utilisateur as id_destinataire, 
recevoir.date_lecture 
FROM message 
JOIN recevoir ON message.id_message = recevoir.id_message 
        WHERE message.id_utilisateur = ' . $_SESSION['user']['id'] . ' OR recevoir.id_utilisateur = ' . $_SESSION['user']['id'] .
    ' ORDER BY message.date_message DESC ';
$query = $dbh->query($sql);
$messages = $query->fetch(PDO::FETCH_ASSOC);

// Fonctions pour ajouter un salon à une chaîne

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chaînes</title>
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
            <li><a href=""><i class="fa-solid fa-diagram-project fa-xl"></i></a></li>
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
                <div class="channel-group" id="nomChaine"><a>
                        <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                        <h3>
                            <?= $chaine['nom_chaine'] ?>
                        </h3>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="salons" id="salons">
            <div class="top-header-nom-salon">
                <i class="fa-solid fa-chevron-left fa-2xl" id="leftArrow"></i>
                <h2 name="nomChaine">
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
                            <h3>Création d'une chaîne</h3>
                            <form action="">
                                <label for="newChaine"></label>
                                <input type="text" name="newChaine">
                                <input type="submit" name="submit" value="Envoyer">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="salons-liste" id="liste-salon">
                    <?php foreach ($salons as $salon): ?>
                        <div class="salon"><a>
                                <?= $salon['nom_salon'] ?>
                            </a></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Concerne l'entête de la discussion -->
        <div class="discussion" id="discussion">
            <div class="topbar">
                <h2>#
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
                <i class="fa-solid fa-ellipsis fa-2xl"></i>
                <div class="chat-menu">
                    <ul id="chatMenu" class="chat-menu-options">
                    <!-- <i class="close fa-solid fa-xmark fa-2xl"></i> -->
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
                                <?= $user['nom_utilisateur'] ?>
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
        // On récupère l'id de la modale
        var addSalonModal = document.getElementById("addSalonModal");

        // On récupère le bouton qui permet d'ouvrir la modale
        var createSalonModalButton = document.getElementById("createSalonModalButton");

        // On récupère la classe close du <span> qui permet de fermer la modale
        var closeModal = document.getElementById("closeModal");

        // Quand l'utilisateur clic sur le bouton, cela ouvre la modale
        createSalonModalButton.onclick = function () {
            addSalonModal.style.display = "block";
        }

        // Quand l'utilisateur clique sur la croix <span> (x), cela ferme la modale
        closeModal.onclick = function () {
            addSalonModal.style.display = "none";
        }

        // Quand l'utilisateur clique en dehors de la modale, cela la ferme
        window.onclick = function (e) {
            if (e.target == addSalonModal) {
                addSalonModal.style.display = "none";
            }
        }


        // JS pour afficher le nav menu

        // On récupère le bouton auquel on va ajouter l'évènement
        const burgerMenuBtn = document.getElementById("burgerMenu");

        burgerMenuBtn.addEventListener("click", responsiveMenu);

        var responsiveMenu = document.getElementById("responsiveMenu");
        // Afficher le menu quand on clic sur le burger
        function responsiveMenu() {
            if (responsiveMenu.style.display === "block") {
                responsiveMenu.style.display = "none";
                chaines.style.display = "block";
            } else {
                responsiveMenu.style.display = "block";
                chaines.style.display = "block";
            }
        }

        // 

    // Test fetch Json

    // document.querySelector("#nomChaine").addEventListener("click", function (e) {
    //         salons.innerHTML = ""
    //         fetch('/index.php').then(function (response) {
    //         return response.json();
    //     }).then(function (monjson) {
    //         console.log(monjson)

    //         var ul = document.createElement('ul');
    //         for (i = 0; i < monjson.length; i++) {
    //             var li = document.createElement('li');
    //             li.innerHTML = monjson[i].nom_chaine;
    //             ul.appendChild(li);
    //         }
    //         document.getElementById('salons').appendChild(ul);
    //     })
    //     })

    </script>
    <script src="/assets/js/chaines.js"></script>
</body>

</html>