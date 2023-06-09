<?php
require $_SERVER['DOCUMENT_ROOT'] . '/profil/profil-function.php';
session_start();
unset($_SESSION['error']);

if (empty($_SESSION['user'])) {
    header("Location: /");
    die;
}

if(!empty($_POST['deleteImage'])){
    $dbh = $GLOBALS['dbh'];
    $sql = "UPDATE utilisateur 
     SET image_profile = :image_profile
     WHERE id_utilisateur = " . $_SESSION['user']['id'];
    $query = $dbh->prepare($sql);
    $res = $query->execute(['image_profile' => Null]);
    $query->rowCount() == 1;
}

if (!empty($_POST['submit'])) {

    $errors = [];

    if (empty($_POST['user']['nom_utilisateur']))
        $errors['nom_utilisateur'] = "Saisissez le nom.";

    if (empty($_POST['user']['prenom_utilisateur']))
        $errors['prenom_utilisateur'] = "Saisissez le prenom.";

    if (empty($_POST['user']['email_utilisateur']))
        $errors['email_utilisateur'] = "Saisissez l'adresse email.";

    if (!filter_var($_POST['user']['email_utilisateur'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_utilisateur'] = "Saississez l'adresse email.";
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['values'] = $_POST;
        header("Location: /profil/index.php");
        die;
    }

    $_POST['user']['nom_utilisateur'] = htmlspecialchars($_POST['user']['nom_utilisateur']);
    $_POST['user']['prenom_utilisateur'] = htmlspecialchars($_POST['user']['prenom_utilisateur']);
    $_POST['user']['email_utilisateur'] = htmlspecialchars($_POST['user']['email_utilisateur']);

    $updateProfil = updateProfil($_POST['user']); 
    

    if ($updateProfil) {
        header("Location: /profil");
        exit;
    } else {
        $_SESSION['error'] = "Une erreur est survenue.";
        header("Location: /profil");
        die;
    }
}

// if(isset($_FILES['image'])) {
    
//     $imageFile = $_FILES['image']['tmp_name'];
    
//     // Paramètres de redimensionnement
//     $newWidth = 100;
//     $newHeight = 100;
    
//     // Chargement de l'image
//     $sourceImage = imagecreatefromjpeg($imageFile);
    
//     // Création d'une nouvelle image avec les dimensions souhaitées
//     $newImage = imagecreatetruecolor($newWidth, $newHeight);
    
//     // Redimensionnement de l'image
//     imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($sourceImage), imagesy($sourceImage));
    
//     // Enregistrement de l'image redimensionnée
//     $fileName = str_replace(' ','-', basename($_FILES[$inputFileName]['name']));
//     $outputFile = '../assets/uploads/profile-pictures/' . $fileName;
//     imagejpeg($newImage, $outputFile);
    
//     // Libération de la mémoire
//     imagedestroy($sourceImage);
//     imagedestroy($newImage);
// }



$title = "AlertMNS - Profil utilisateur";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

?>

<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/profil.css">
<link rel="stylesheet" href="/assets/css/dashboard.css">


</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-top-bar.php"?>
    <!-- Menu burger pour mobile -->

    <nav class="navbar">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" id="menu-button">
                <span class="menu-icon menu-icon--bar-top"></span>
                <span class="menu-icon menu-icon--bar-middle"></span>
                <span class="menu-icon menu-icon--bar-bottom"></span>
            </button>

        </div>
        <div class="navbar-menu" id="menu">
            <ul class="nav navbar-nav">
                <li><a href="/admin"><i class="fa-solid fa-house fa-2x"></i>Accueil</a></li>
                <li><a href="/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>Voir tous les messages</a></li>
                <li><a href="#"><i class="fa-solid fa-users fa-2x"></i>Voir tous les groupes</a></li>
                <li>
                    <a href=""><i class="fa-solid fa-tower-cell fa-2x"></i>Voir toutes les chaînes</a>
                </li>
                <li><a href="#"><i class="fa-regular fa-calendar-days fa-2x"></i>Voir les réunions</a></li>
                <li><a href="#"><i class="fa-solid fa-user fa-2x"></i>Gérer mon profil</a></li>
                <li><a href="#"><i class="fa-solid fa-gear fa-2x"></i>Réglages</a></li>
                <li><a href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

        <section class="profile-settings">
            <div class="profile-options">
                <ul class="profil-options-choices">
                    <a href="">
                        <li class="info"><i class="fa-regular fa-user fa-xl"></i>Informations</li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-key fa-xl"></i>Mot de passe et sécurité</li>
                    </a>
                </ul>
            </div>
            <div class="profile-elements">

                <div class="user-info">
                <div class="img-profil">
                <img src="<?= isset($utilisateur['image_profile']) ? 
                $utilisateur['image_profile'] : 
                'https://dummyimage.com/100x100.jpg' ?>" alt="Image Profil" id="preview" /></div>
                    <div class="user-name">
                        <h3><?= $utilisateur['prenom_utilisateur'] . " " . $utilisateur['nom_utilisateur'] ?></h3>
                        <h4><?= $utilisateur['libelle_role'] ?></h4>
                    </div>
                </div>
                
                <form action="/profil" method="post" name="user" enctype="multipart/form-data">
                <div class="upload-img">
                        <div><label for="image">Ajouter ou modifier votre image de profil</label></div>
                        <div><input type="file" name="image" id="imageFile" class="form-control" value="<?= isset($urlImageProfil) ? $urlImageProfil : NULL ?>"></div>
                        <button type="submit" name="deleteImage" value="deleteImage">Supprimer l'image</button>
                </div>

                <div class="user-input">

                    <div class="firstname-lastname">
                        <div class="name-email">
                            <label for="user[nom_utilisateur]">Nom</label>
                            <input type="text" name="user[nom_utilisateur]" value="<?= $utilisateur['nom_utilisateur'] ?>">
                            <small class="error" id="errorName"></small>
                            <?php if (isset($_SESSION['errors']['nom_utilisateur'])) : ?>
                                <small class="error"><?= $_SESSION['errors']['nom_utilisateur'] ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="name-email">
                            <label for="user[prenom_utilisateur]">Prénom</label>
                            <input type="text" name="user[prenom_utilisateur]" value="<?= $utilisateur['prenom_utilisateur'] ?>">
                            <small class="error" id="errorFirstname"></small>
                            <?php if (isset($_SESSION['errors']['prenom_utilisateur'])) : ?>
                                <small class="error"><?= $_SESSION['errors']['prenom_utilisateur'] ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="name-email">
                        <label for="user[email_utilisateur]">Adresse email</label>
                        <input type="email" name="user[email_utilisateur]" value="<?= $utilisateur['email_utilisateur'] ?>">
                        <small class="error" id="errorEmail"></small>
                        <?php if (isset($_SESSION['errors']['email_utilisateur'])) : ?>
                            <small class="error"><?= $_SESSION['errors']['email_utilisateur'] ?></small>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="submit" value="submit">Enregistrer les modifications</button>
                    </form>
                    <?php if (isset($_SESSION['error'])) : ?>
                        <p class="invalid"><?= $_SESSION['error'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php unset($_SESSION['errors']); ?>

        <!-- tablette/mobile -->

        <section class="section-profile">
            <div class="profile-mob">
                <a href=""><img src='https://dummyimage.com/100x100.jpg' alt='' /></a>
                <div class="name-mob">
                    <h2><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h2>
                    <p><?= $utilisateur['libelle_role'] ?></p>
                </div>

            </div>
        </section>

        <section class="section-actions">
            <div class="actions-mob">
                <ul>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Créer un utilisateur</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Créer une nouvelle chaine</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Créer un nouveau groupe</span></li>
                    </a>
                    <a href="">
                        <li><i class="fa-solid fa-plus"></i><span>Organiser une réunion</span></li>
                    </a>
                </ul>
            </div>
        </section>

    </main>

    <footer></footer>
    <script src="../assets/js/script.js"></script>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>