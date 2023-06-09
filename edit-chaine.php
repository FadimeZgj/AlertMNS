<?php

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost:8889;dbname=alertmns;charset=utf8mb4", "root", "root", [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Vérifier si le formulaire a été soumis
if(isset($_POST['submit'])) {

    // Parcourir chaque chaîne pour récupérer l'état "is_active"
    foreach($_POST['is_active'] as $id_chaine) {

        // Récupération de l'état actuel de la chaîne
        $sql = "SELECT is_active FROM chaine WHERE id_chaine = :id_chaine";
        $query = $pdo->prepare($sql);
        $query->execute(['id_chaine' => $id_chaine]);
        $isActive = $query->fetchColumn();

        // Inversion de l'état de la chaîne
        $newIsActive = $isActive ? 0 : 1;

        // if ($_POST['submit'] === $id_chaine['id_chaine'] ) {
        //     $newisActive = 0;
        // } else {
        //     $newisActive = 1;
        // }

        // Mise à jour de la chaîne dans la base de données
        $sql = "UPDATE chaine SET is_active = :is_active WHERE id_chaine = :id_chaine";
        $query = $pdo->prepare($sql);
        $query->execute([
            'is_active' => $newIsActive,
            'id_chaine' => $id_chaine
        ]);
    }

    // Rediriger vers la page d'origine
    header('Location: /admin/chaines/edit.php');
    exit();
}

?>
