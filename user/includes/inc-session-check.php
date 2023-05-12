<?php
session_start();

// On vérifie que l'utilisateur est bien connecté
if(empty($_SESSION['user']))
{
    header("Location: /"); die;
}

// Si c'est un admin, on le rédirige à l'accueil
if(in_array("Administrateur", $_SESSION['user']['roles']))
{
    header("Location: /"); die;
}