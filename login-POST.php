<?php

// début de la session
session_start();
unset($_SESSION['error']);
// Connexion à la BDD
require 'includes/inc-db-connect.php';

if (!empty($_POST['submit'])) {

    $errors = [];

    if (empty($_POST['email']))
        $errors['email'] = "Saisissez votre email.";

    if (empty($_POST['password']))
        $errors['password'] = "Saisissez votre mot de passe.";


    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['values'] = $_POST;
        header("Location: /");
        die;
    }

    // 1. On cherche en base de donnée l'utilisateur avec son email
    $sql = "SELECT * FROM utilisateur WHERE email_utilisateur = :email";

    $result = $dbh->prepare($sql);
    $result->execute([
        "email" => $_POST['email']
    ]);
    $user = $result->fetch(PDO::FETCH_ASSOC);

    // 2. On test si l'utilisateur existe
    if ($user) {
        // 4. S'il existe alors on compare les mots de passes et on vérifie s'il est actif
        if (password_verify($_POST['password'], $user['mdp_utilisateur'])) {
            $sql = "SELECT role.libelle_role FROM role
            LEFT JOIN utilisateur ON role.id_role = utilisateur.id_role
            WHERE id_utilisateur = :id_utilisateur 
            AND utilisateur.is_active = 1";
            $query = $dbh->prepare($sql);
            $res = $query->execute([
                "id_utilisateur" => $user['id_utilisateur']
            ]);
            $roles = $query->fetchAll(PDO::FETCH_COLUMN);



            // 5. Si mdp OK alors on identifie l'utilisateur en SESSION et on redirige vers la page admin
            session_start();

            // On stock les informations de l'utilisateur
            $_SESSION['user'] = [
                'id' => $user['id_utilisateur'],
                'firstname' => $user['prenom_utilisateur'],
                'lastname' => $user['nom_utilisateur'],
                'roles' => $roles
            ];

            // on dirige l'utilisateur en fonction de son statut
            if (in_array("Administrateur", $roles)) {
                header("Location: /admin");
                die;
            } else {
                header("Location: /user");
                die;
            }
        } else {
            // 6. Si le mdp KO alors on redirige vers la page login
            $_SESSION['error'] = "Identifiants invalides. ";
            header("Location: /");
            die;
        }
    } else {
        // si l'utilisateur n'existe pas, on redirige vers le login
        $_SESSION['error'] = "Identifiants invalides. ";
        header("Location: /");
        die;
    }
} else {
    header("Location: /");
    die;
}
