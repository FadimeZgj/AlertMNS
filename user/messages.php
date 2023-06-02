<?php
require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';


// récupérer les utilisateur connecté
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);

// if (!empty($_GET)) {
//     $id = $_GET['id'];
// }


// if (isset($_POST['submit'])) 
// {
//     if (!empty($_POST['text_message'])) 
//     {
//             $sql = "INSERT INTO message (text_message, date_message, id_utilisateur) VALUES (:text_message, NOW(), :id_utilisateur)";
//             $query = $dbh->prepare($sql);
            
//             $res = $query->execute([
//                 'text_message' => $_POST['text_message'],
//                 'id_utilisateur' => $_SESSION['user']['id']

//             ]);
            
//             $newMsg = $dbh->lastInsertId();

//         if ($newMsg) 
//         {
//             $sql = "INSERT INTO recevoir (id_message , id_utilisateur) VALUES (:id_message, :id_utilisateur)";
//             $query = $dbh->prepare($sql);
//             $recipent = $query->execute([
//                 "id_message" => $newMsg,
//                 "id_utilisateur" => $id
//             ]);
//         }
    
//     }

// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du message envoyé
    $postData = json_decode(file_get_contents('php://input'), true);
    $textMessage = htmlspecialchars($postData['text_message']);
    $idDestinataire = $_GET['id'];
    var_dump($postData);die;

    // Effectuer les validations nécessaires sur les données
    if (!empty($textMessage) && !empty($idDestinataire)) {
        // Insérer le message dans la base de données
        $sql = "INSERT INTO message (text_message, date_message, id_utilisateur) VALUES (:text_message, NOW(), :id_utilisateur)";
        $query = $dbh->prepare($sql);

        $res = $query->execute([
            'text_message' => $textMessage,
            'id_utilisateur' => $_SESSION['user']['id']
        ]);

        


        // Vérifier si l'insertion du message a réussi
        if ($res) {
            // Récupérer l'ID du nouveau message inséré
            $newMsgId = $dbh->lastInsertId();

            // Insérer une entrée dans la table "recevoir" pour associer le message au destinataire
            $sql = "INSERT INTO recevoir (id_message, id_utilisateur) VALUES (:id_message, :id_destinataire)";
            $query = $dbh->prepare($sql);
            $recipent = $query->execute([
                "id_message" => $newMsgId,
                "id_destinataire" => $idDestinataire
            ]);


            // Vérifier si l'insertion dans la table "recevoir" a réussi
            if ($recipent) {
                // Le message a été envoyé avec succès
                // Effectuez d'autres actions si nécessaire
                echo 'Message envoyé avec succès';
            } else {
                // Erreur lors de l'insertion de l'entrée dans la table "recevoir"
                echo 'Erreur lors de l\'envoi du message';
            }
        } else {
            // Erreur lors de l'insertion du message dans la table "message"
            echo 'Erreur lors de l\'envoi du message';
        }
    } else {
        // Les données du message sont vides ou incomplètes
        echo 'Veuillez fournir les informations nécessaires pour envoyer le message';
    }
}

$title = "AlertMNS - Messages";
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

?>

    <link rel="stylesheet" href="/assets/css/messages.css">
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
                    <form action="/user/messages.php" method="post" id="message">
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
    <script src="../assets/js/messages-user.js" async></script>
    <script>
        <?php $user_id = $_SESSION['user']['id']; ?>
        // déclaration de la variable user_id avec la valeur correspondante
        let userId = <?php echo $user_id; ?>;
    </script>
    

<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>