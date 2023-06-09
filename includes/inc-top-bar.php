<?php
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
// Récupérer l'utilisateur connecté
$utilisateur = getAllActiveUsers();

if(in_array("Administrateur", $_SESSION['user']['roles'])):?>

<header>
        <div class="name-dashboard">
            
            <h1>Dashboard Administrateur</h1>
        </div>
        <div class="name-user">
            <div>
                <h2><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h2>
                <p><?= $utilisateur['libelle_role'] ?></p>
            </div>
            <a href=""><img src="<?= $utilisateur['image_profile'] != null ? 
                $utilisateur['image_profile'] : 
                'https://dummyimage.com/50x50.jpg' ?>" alt="Image Profil" /></a>
        </div>
    </header>

<?php else: ?>

    <header>
        <div class="name-dashboard">
            <h1>Dashboard Utilisateur</h1>
        </div>
        <div class="name-user">
            <div>
                <h2><?= $utilisateur['prenom_utilisateur'] ?> <?= $utilisateur['nom_utilisateur'] ?></h2>
                <p><?= $utilisateur['libelle_role'] ?></p>
            </div>
            <a href=""><img src="<?= $utilisateur['image_profile'] != null ? 
                $utilisateur['image_profile'] : 
                'https://dummyimage.com/50x50.jpg' ?>" alt="Image Profil" /></a>
        </div>
    </header>

<?php endif; ?>
    
