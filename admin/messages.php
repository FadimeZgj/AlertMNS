<?php
require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';


// récupérer les utilisateur connecté
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);

if (!empty($_GET)) {
    $id = $_GET['id'];
}


if (isset($_POST['submit'])) 
{
    if (!empty($_POST['text_message'])) 
    {
            $sql = "INSERT INTO message (text_message, date_message, id_utilisateur) VALUES (:text_message, NOW(), :id_utilisateur)";
            $query = $dbh->prepare($sql);
            
            $res = $query->execute([
                'text_message' => $_POST['text_message'],
                'id_utilisateur' => $_SESSION['user']['id']

            ]);
            
            $newMsg = $dbh->lastInsertId();

        if ($newMsg) 
        {
            $sql = "INSERT INTO recevoir (id_message , id_utilisateur) VALUES (:id_message, :id_utilisateur)";
            $query = $dbh->prepare($sql);
            $recipent = $query->execute([
                "id_message" => $newMsg,
                "id_utilisateur" => $id
            ]);
        }

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

    <div class="sidebar">
        <!-- <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a> -->
        <div class="top-icons">
            <a href="/admin"><i class="fa-solid fa-house fa-2x"></i></a>
            <a href="/admin/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>

            </a>
            <a href=""><i class="fa-solid fa-users fa-2x"></i>

            </a>
            <a href="/admin/chaines"><i class="fa-solid fa-tower-cell fa-2x"></i>

            </a>
            <a href=""><i class="fa-regular fa-calendar-days fa-2x"></i>

            </a>
        </div>
        <div class="bottom-icons">
            <a href="../../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>

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


    <script src="../assets/js/messages-admin.js" async></script>
    <script>
        <?php $user_id = $_SESSION['user']['id']; ?>
        // déclaration de la variable user_id avec la valeur correspondante
        let userId = <?php echo $user_id; ?>;
    </script>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>