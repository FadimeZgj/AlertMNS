<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

// Récupérer utilisateur connecté
$sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
$query = $dbh->query($sql);
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);

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
            <a href=""><img src='https://dummyimage.com/50x50.jpg' alt='' /></a>
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
            <a href=""><img src='https://dummyimage.com/50x50.jpg' alt=''/></a>
        </div>
    </header>

<?php endif; ?>
    
