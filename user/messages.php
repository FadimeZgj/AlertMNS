<?php
require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

// récupérer les messages envoyés
// $sql = 'SELECT message.id_message as message_envoie, message.text_message, message.date_message, message.id_utilisateur as id_expediteur,
//         recevoir.id_message as message_recue, recevoir.id_utilisateur as id_destinataire, recevoir.date_lecture, utilisateur.nom_utilisateur,
//         utilisateur.prenom_utilisateur, role.libelle_role
//         FROM message JOIN recevoir ON message.id_message = recevoir.id_message
//         left join utilisateur on utilisateur.id_utilisateur = message.id_utilisateur
//         LEFT JOIN role ON utilisateur.id_role = role.id_role
//         WHERE recevoir.id_message = message.id_message
//         AND recevoir.id_utilisateur = ' . $_SESSION['user']['id'] . ' ORDER BY message.date_message DESC ' ;

$sql = 'SELECT message.id_message, message.text_message, message.date_message, message.id_utilisateur as id_expediteur,
       recevoir.id_message as message_recue, recevoir.id_utilisateur as id_destinataire, recevoir.date_lecture, utilisateur.nom_utilisateur,
       utilisateur.prenom_utilisateur, role.libelle_role
        FROM message
        JOIN (
            SELECT id_utilisateur, MAX(id_message) as id_message
            FROM message
            WHERE id_utilisateur 
            GROUP BY id_utilisateur
        ) as max_message ON message.id_utilisateur = max_message.id_utilisateur AND message.id_message = max_message.id_message
        JOIN recevoir ON message.id_message = recevoir.id_message
        LEFT JOIN utilisateur ON utilisateur.id_utilisateur = message.id_utilisateur
        LEFT JOIN role ON utilisateur.id_role = role.id_role
        WHERE recevoir.id_utilisateur = ' . $_SESSION['user']['id'] . ' ORDER BY message.date_message DESC ';
        
$query = $dbh -> query($sql);
$messages = $query -> fetchAll();


// récupérer les utilisateur connecté
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);

// récupérer les destinataires
// $sql = 'SELECT message.id_message as message_envoie, message.text_message, message.date_message, message.id_utilisateur as id_expediteur,
//         recevoir.id_message, recevoir.id_utilisateur as id_destinataire, recevoir.date_lecture, utilisateur.nom_utilisateur, utilisateur.prenom_utilisateur,
//         role.libelle_role
//         FROM message JOIN recevoir ON message.id_message = recevoir.id_message
//         LEFT JOIN utilisateur ON utilisateur.id_utilisateur = recevoir.id_utilisateur
//         LEFT JOIN role ON utilisateur.id_role = role.id_role 
        
//         ORDER BY message.date_message DESC';

//         $query = $dbh -> query($sql);
//         $messages = $query -> fetchAll();


// $sql = 'SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
//         LEFT JOIN role ON utilisateur.id_role = role.id_role
//         JOIN recevoir ON recevoir.id_utilisateur = utilisateur.id_utilisateur
//         WHERE recevoir.id_utilisateur != ' . $_SESSION['user']['id'];

// $query = $dbh->query($sql);
// $destinataires = $query->fetchAll(PDO::FETCH_ASSOC);


// Envoyer un message

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="/assets/css/messages.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/5b104128e4.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="topbar">
            <div class="logo">
                <img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Logo' alt='Logo'>
                <h3>ALERT MNS</h3>
            </div>
            <div class="user-info">
                <img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' alt='Photo'>
                <div class="user-role">
                    <h4><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h4>
                    <h5><?= $utilisateur['libelle_role'] ?></h5>
                </div>
            </div>
        </div>
    </header>

    <div class="sidebar">
        <!-- <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a> -->
        <div class="top-icons">
            <a href="/admin"><i class="fa-solid fa-house fa-2x"></i></a>
            <a href="../messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>

            </a>
            <a href=""><i class="fa-solid fa-users fa-2x"></i>

            </a>
            <a href=""><i class="fa-solid fa-tower-cell fa-2x"></i>

            </a>
            <a href=""><i class="fa-regular fa-calendar-days fa-2x"></i>

            </a>
        </div>
        <div class="bottom-icons">
            <a href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
            
            </a>
            <a href=""><i class="fa-solid fa-user fa-2x"></i>
            
            </a>
            <a href=""><i class="fa-solid fa-gear fa-2x"></i>

            </a>
        </div>
    </div>

    <div class="container">
        <div class="messages">
            <!--Entête message-->
            <div class="entete-message">
                <h1>Messages</h1>
                <i class="fa-solid fa-pen-to-square fa-2xl"></i>
            </div>

            <!--Barre de recherche-->
            <div class="search-message">
                <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher...">
            </div>

            <!--Liste des messages-->
            
            <div class="liste-messages"><?php foreach ($messages as $message): ?>
                <!-- Contenu d'un message-->
                <div class="message">
                    <!--photo de profil de l'utilisateur-->
                    <div class="image-user">
                        <img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' alt='Photo'>
                    </div>
                    
                    <div class="right-content">
                        <div class="info-user">
                            <div class="name">
                                <h3><?= $message['prenom_utilisateur'] ?> <?= $message['nom_utilisateur'] ?> </h3>
                                <h4><?= $message['libelle_role'] ?></h4>
                            </div>
            
                            <div class="hour">Il y a 1 h</div>
                        </div> <!-- Referme Info user-->
                        <div class="text-message">
                            <p><?= substr($message['text_message'],0,50) ?></p>
                        </div>
                    </div>
                </div> <!--referme la div message-->
                <?php endforeach; ?>
            </div> <!-- liste-messages-->

        </div> <!--ferme <div> Messages-->

        <!--Interface principale des messages-->
        <div class="messages-interface">
            <div class="top-header-messages">
                <h3>Fadime Ilhan</h3>
                <div class="search-message">
                    <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher...">
                </div>
                <i class="fa-solid fa-ellipsis fa-2xl"></i>
            </div>

            <div class="conversation-interface">

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
                </div>

                <!--Bulle de discussion de l'utilisateur-->
                <div class="message-user">
                    <div class="bulle-user">
                        <div class="info">
                            <p class="name">Nom</p>
                            <p class="date">14 mai 2022</p>
                        </div>
                        <div class="bubble-right">
                            <div class="contenu-my-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                            </div>
                            <div class="arrow-right">
                            </div>
                        </div>
                    </div>
                    <div class="my-info">
                        <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                    </div>
                </div>

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
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boîte de dialogue -->
                <div class="chatbox">
                    <input type="text" placeholder="Ecrivez votre message...">
                </div>


                <!-- Icônes de la boîte de dialogue-->
                <div class="icons-group">
                    <i class="fas fa-images fa-xl"></i>
                    <i class="fa-regular fa-face-smile fa-xl"></i>
                    <i class="fa-solid fa-ellipsis fa-2xl"></i>
                    <div class="send-button">
                        <input type="button" value="Envoyer">
                    </div>
                </div>
            </div>
        </div> <!-- ferme <div> container-->

    <script src="../assets/js/messages.js"></script>

</body>

</html>
