<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

if(!empty($_POST['id_groupe']))
{
    $count = deleteGroupe($_POST['id_groupe']);

    if($count == 1)
    {
        header("Location: /admin/groupes"); exit;
    }
    else
    {
        echo "Une erreur s'est produite lors de la suppression...";
    }
}
else
{
    header("Location: /admin/groupes"); exit;
}