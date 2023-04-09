<?php

session_start();


if (!empty($_POST['submit'])) 
{
    
    $errors = [];

    if(empty($_POST['nom_utilisateur']))
        $errors['nom_utilisateur'] = "Saississez le nom.";

    if(empty($_POST['prenom_utilisateur']))
        $errors['prenom_utilisateur'] = "Saississez le prenom.";

    if(empty($_POST['email_utilisateur']))
        $errors['email_utilisateur'] = "Saississez l'adresse email.";

    if(empty($_POST['mdp_utilisateur']))
        $errors['mdp_utilisateur'] = "Saississez le mot de passe.";

    
    if(count($errors) > 0)
    {
        $_SESSION['errors'] = $errors;
        $_SESSION['values'] = $_POST;
        header("Location: /admin/add-user.php"); die;
    }

    require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

     // On vérifie que l'utilisateur n'existe pas
     $sql = "SELECT * FROM utilisateur WHERE email_utilisateur = :email_utilisateur";
     $query = $dbh->prepare($sql);
     $res = $query->execute([
         'email_utilisateur' => $_POST['email_utilisateur']
     ]);

     if($query->rowCount() > 0)
    {
        $_SESSION['error'] = "Un utilisateur existe déjà avec cette adresse email.";
        header("Location: /admin/add-user.php"); die;
    }

     // On insère l'utilisateur en BDD
     $sql = "INSERT INTO utilisateur (nom_utilisateur, prenom_utilisateur, email_utilisateur, mdp_utilisateur) 
     VALUES (:nom_utilisateur, :prenom_utilisateur, :email_utilisateur, :mdp_utilisateur)";
     $query = $dbh->prepare($sql);
     $res = $query->execute([
         'nom_utilisateur' => $_POST['nom_utilisateur'],
         'prenom_utilisateur' => $_POST['prenom_utilisateur'],
         'email_utilisateur' => $_POST['email_utilisateur'],
         'mdp_utilisateur' => password_hash($_POST['mdp_utilisateur'], PASSWORD_DEFAULT)
     ]);
 
     if($res)
     {
         header("Location: /admin/add-user.php"); exit;
     }
     else
     {
         $_SESSION['error'] = "Un erreur est survenue.";
         header("Location: /admin/add-user.php"); die;
     }
}