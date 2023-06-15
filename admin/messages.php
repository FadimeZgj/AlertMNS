<?php 


require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';


// récupérer les utilisateur connecté
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , utilisateur.image_profile, role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);


// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
// }

// if (isset($_POST['submit'])) {
//     if (!empty($_POST['text_message'])) {
//         $sql = "INSERT INTO message (text_message, date_message, id_utilisateur) VALUES (:text_message, NOW(), :id_utilisateur)";
//         $query = $dbh->prepare($sql);

//         $res = $query->execute([
//             'text_message' => $_POST['text_message'],
//             'id_utilisateur' => $_SESSION['user']['id']

//         ]);

//         $newMsg = $dbh->lastInsertId();

//         if ($newMsg) {
//             $sql = "INSERT INTO recevoir (id_message, id_utilisateur) VALUES (:id_message, :id_destinataire)";
//             $query = $dbh->prepare($sql);
//             $recipent = $query->execute([
//                 "id_message" => $newMsg,
//                 "id_destinataire" => $id
//             ]);
//         }
//     }
// }


$title = "AlertMNS - Messages";
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

?>
<link rel="stylesheet" href="/assets/css/messages.css">
</head>

<body>
    <header>
        <div class="topbar">
            <div class="logo">
                <img src='/assets/images/logo1.png' alt='Logo'>
                <h3>ALERT MNS</h3>
            </div>
            <div class="user-info">
                <img src="<?= $utilisateur['image_profile']!=null ? 
                $utilisateur['image_profile'] : 
                'https://dummyimage.com/50x50.jpg' ?>" alt="Image Profil">
                <div class="user-role">
                    <h4 id="userName"><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h4>
                    <h5><?= $utilisateur['libelle_role'] ?></h5>
                </div>
            </div>
        </div>
    </header>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

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

            <div class="liste-messages" id="conv">


            </div> <!-- liste-messages-->

        </div> <!--ferme <div> Messages-->

        <!--Interface principale des messages-->
        <div class="messages-interface">
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
                        <input type="hidden" name="id_destinataire">
                        <input type="text" name="text_message" placeholder="Ecrivez votre message..." id="message-input">
                </div>

                <!-- Icônes de la boîte de dialogue-->
                <div class="icons-group">
                    <div class="send-button">
                        <input type="submit" value="Envoyer" name="submit" id="send-message-btn">
                    </div>
                    </form>
                </div>
            </div>
        </div><!-- ferme <div> container-->

    </div>


    <script src="../assets/js/messages-admin.js" async></script>
    <script>
        <?php $user_id = $_SESSION['user']['id']; ?>
        // déclaration de la variable user_id avec la valeur correspondante
        let userId = <?php echo $user_id; ?>;
    </script>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>