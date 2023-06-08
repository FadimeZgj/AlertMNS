<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

if(!empty($_POST['id_reunion']))
{
    $count = deleteReunion($_POST['id_reunion']);

    if($count == 1)
    {
        header("Location: /admin/reunions"); exit;
    }
    else
    {
        echo "Une erreur s'est produite lors de la suppression...";
    }
}
else
{
    header("Location: /admin/reunions"); exit;
}