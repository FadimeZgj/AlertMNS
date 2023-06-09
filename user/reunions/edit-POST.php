<?php

session_start();
unset($_SESSION['error']);

require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';


// Traiter le formulaire si envoyé
// Permet de créer une nouvelle réunion
if (!empty($_POST['submit'])) {

    $errors = [];

    if (empty($_POST['nom_reunion']))
        $errors['nom_reunion'] = "Veuillez entrer un nom.";

    if (empty($_POST['date_reunion']))
        $errors['date_reunion'] = "Veuillez saisir une date";

    if (empty($_POST['sujet_reunion']))
        $errors['sujet_reunion'] = "Veuillez entrer un sujet";

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['values'] = $_POST;
        header("Location: /user/reunions/edit.php");
        die;
    } 
    
    // Si il n'y a pas d'erreurs, on modifie la réunion
    if (count($errors) == 0) {
        
        // On traite le formulaire si on récupère l'id de la réunion
        if(updateReunion($_GET['id']))
        {
            header("Location: /user/reunions/");
        }
        else
        {
            $_SESSION['error'] = "Une erreur est survenue.";
        header("Location: /user/reunions/edit.php");
        die;
        }
    
    }
}

