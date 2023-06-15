<?php

//  session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les données du message envoyé
    $postData = json_decode(file_get_contents('php://input'), true);
    $textMessage = htmlspecialchars($postData['text_message']);
    $idDestinataire = $_GET['id'];

    // Effectuer les validations nécessaires sur les données
    if (!empty($textMessage) && !empty($idDestinataire)) {
        // Insérer le message dans la base de données
        $sql = "INSERT INTO message (text_message, date_message, id_utilisateur) VALUES (:text_message, NOW(), :id_utilisateur)";
        $query = $dbh->prepare($sql);

        $res = $query->execute([
            'text_message' => $textMessage,
            'id_utilisateur' => $_SESSION['user']['id']
        ]);

        // Vérifier si l'insertion du message a réussi
        if ($res) {
            // Récupérer l'ID du nouveau message inséré
            $newMsgId = $dbh->lastInsertId();

            // Insérer une entrée dans la table "recevoir" pour associer le message au destinataire
            $sql = "INSERT INTO recevoir (id_message, id_utilisateur) VALUES (:id_message, :id_destinataire)";
            $query = $dbh->prepare($sql);
            $recipent = $query->execute([
                "id_message" => $newMsgId,
                "id_destinataire" => $idDestinataire
            ]);

            // Vérifier si l'insertion dans la table "recevoir" a réussi
            if ($recipent) {
                // Le message a été envoyé avec succès
                // Effectuez d'autres actions si nécessaire
                echo 'Message envoyé avec succès';
            } else {
                // Erreur lors de l'insertion de l'entrée dans la table "recevoir"
                echo 'Erreur lors de l\'envoi du message';
            }
        } else {
            // Erreur lors de l'insertion du message dans la table "message"
            echo 'Erreur lors de l\'envoi du message';
        }
    } else {
        // Les données du message sont vides ou incomplètes
        echo 'Veuillez fournir les informations nécessaires pour envoyer le message';
    }
}
