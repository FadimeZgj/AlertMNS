<?php

require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

// maj de is_active

if (!empty($_POST['isActive'])) {
    // $isActive = isset($_POST['is_active']) ? 1 : 0;

    // $sql = "UPDATE utilisateur SET is_active = :is_active WHERE id_utilisateur = :id_utilisateur";
    // $query = $dbh->prepare($sql);
    // $active = $query->execute([
    //     'is_active' => $isActive,
    //     'id_utilisateur' => $_POST['id_utilisateur']
    // ]);

    $active = archiveUser($_POST['id_utilisateur']);


    header("Location: /search-user.php");
}
