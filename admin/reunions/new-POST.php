<?php

session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
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
        header("Location: /admin/reunions/new.php");
        die;
    } 
    
    if (count($errors) == 0) {
        
        $sql = "INSERT INTO reunion (nom_reunion, date_reunion, sujet_reunion, id_utilisateur, id_groupe) 
        VALUES (:nom_reunion,:date_reunion, :sujet_reunion, :id_utilisateur, :id_groupe)";
        $query = $dbh->prepare($sql);
        $res = $query->execute([
            'nom_reunion' => htmlspecialchars($_POST['nom_reunion']),
            'date_reunion' => $_POST['date_reunion'],
            'sujet_reunion' => htmlspecialchars($_POST['sujet_reunion']),
            'id_utilisateur' => $_SESSION['user']['id'],
            'id_groupe' => $_POST['groupe']
        ]);

        if ($res) {
            header("Location: /admin/reunions/");
            exit;
        } else {
            $_SESSION['error'] = "Une erreur est survenue.";
            header("Location: /admin/reunions/new.php");
            die;
        }
    }

}
