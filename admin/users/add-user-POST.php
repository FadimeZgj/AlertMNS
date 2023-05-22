<?php

session_start();
unset($_SESSION['error']);
require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

if (!empty($_POST['submit'])) {

    $errors = [];

    if (empty($_POST['newUser']['nom_utilisateur']))
        $errors['nom_utilisateur'] = "Saississez le nom.";

    if (empty($_POST['newUser']['prenom_utilisateur']))
        $errors['prenom_utilisateur'] = "Saississez le prenom.";

    if (empty($_POST['newUser']['email_utilisateur']))
        $errors['email_utilisateur'] = "Saississez l'adresse email.";

    if (empty($_POST['newUser']['mdp_utilisateur']))
        $errors['mdp_utilisateur'] = "Saississez le mot de passe.";


    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['values'] = $_POST;
        header("Location: /admin/users/add-user.php");
        die;
    }

    $_POST['nom_utilisateur'] = htmlspecialchars($_POST['nom_utilisateur']);
    $_POST['prenom_utilisateur'] = htmlspecialchars($_POST['prenom_utilisateur']);
    $_POST['email_utilisateur'] = htmlspecialchars($_POST['email_utilisateur']);
    $_POST['mdp_utilisateur'] = htmlspecialchars($_POST['email_utilisateur']);

    // On vérifie que l'utilisateur n'existe pas
    // $sql = "SELECT * FROM utilisateur WHERE email_utilisateur = :email_utilisateur";
    // $query = $dbh->prepare($sql);
    // $res = $query->execute([
    //     'email_utilisateur' => $_POST['email_utilisateur']
    // ]);

    // if ($query->rowCount() > 0) {
    //     $_SESSION['errors']['email_utilisateur'] = "Un utilisateur existe déjà avec cette adresse email.";
    //     header("Location: /admin/users/add-user.php");
    //     die;
    // }

    $userExist = userExist();

    // On insère l'utilisateur en BDD
    // $sql = "INSERT INTO utilisateur (nom_utilisateur, prenom_utilisateur, email_utilisateur, mdp_utilisateur, id_role) 
    //  VALUES (:nom_utilisateur, :prenom_utilisateur, :email_utilisateur, :mdp_utilisateur, :id_role)";
    // $query = $dbh->prepare($sql);
    // $res = $query->execute([
    //     'nom_utilisateur' => $_POST['nom_utilisateur'],
    //     'prenom_utilisateur' => $_POST['prenom_utilisateur'],
    //     'email_utilisateur' => $_POST['email_utilisateur'],
    //     'mdp_utilisateur' => password_hash($_POST['mdp_utilisateur'], PASSWORD_DEFAULT),
    //     'id_role' => $_POST['id_role']
    // ]);

    $addUser = insertUser($_POST['newUser']);

    if ($addUser) {
        header("Location: /admin/users/add-user.php");
        exit;
    } else {
        $_SESSION['error'] = "Un erreur est survenue.";
        header("Location: /admin/users/add-user.php");
        die;
    }
}
