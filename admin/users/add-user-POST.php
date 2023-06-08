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

    if (!filter_var($_POST['newUser']['email_utilisateur'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_utilisateur'] = "Saississez l'adresse email.";
    }

    $password = $_POST['newUser']['mdp_utilisateur']; // Supposons que le mot de passe provienne d'un formulaire

    $minimumLength = 8; // Longueur minimale requise du mot de passe
    $maximumLength = 20; // Longueur maximale autorisée du mot de passe

    $containsUppercase = preg_match('/[A-Z]/', $password); // Vérifie s'il y a une lettre majuscule
    $containsLowercase = preg_match('/[a-z]/', $password); // Vérifie s'il y a une lettre minuscule
    $containsNumber = preg_match('/\d/', $password); // Vérifie s'il y a un chiffre
    $containsSpecialChars = preg_match('/[^a-zA-Z0-9]/', $password); // Vérifie s'il y a des caractères spéciaux

    if (strlen($password) < $minimumLength || strlen($password) > $maximumLength) {
        $errors['mdp_utilisateur'] = "Le mot de passe doit avoir entre $minimumLength et $maximumLength caractères.";
    } elseif (!$containsUppercase || !$containsLowercase || !$containsNumber || !$containsSpecialChars) {
        $errors['mdp_utilisateur'] = "Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.";
    } else {
        $errors['mdp_utilisateur'] =  "Le mot de passe est valide.";
    }


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

    $userExist = userExist($_POST['newUser']);

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
