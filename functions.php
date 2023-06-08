<?php

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';
function getAllEmails()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM utilisateur
    WHERE utilisateur.email_utilisateur = utilisateur.email_utilisateur";
    return $dbh->query($sql)->fetchAll();
}

// Récupérer les utilisateurs connectés (utile pour la topbar)
function getAllActiveUsers()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , utilisateur.email_utilisateur, 
    utilisateur.image_profile, role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
    return $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
}

function getAllReunions()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT *
    FROM reunion
    LEFT JOIN utilisateur ON utilisateur.id_utilisateur = reunion.id_utilisateur
    LEFT JOIN groupe ON groupe.id_groupe = reunion.id_groupe
    WHERE groupe.id_groupe = reunion.id_groupe
    AND reunion.id_reunion = reunion.id_reunion";
    return $dbh->query($sql)->fetchAll();
}

function getAllGroupes()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT affecter.id_utilisateur as id_du_membre_du_groupe, affecter.id_groupe, groupe.id_groupe as num_groupe, groupe.nom_groupe, groupe.date_groupe, groupe.id_utilisateur as id_createur_groupe, utilisateur.nom_utilisateur as nom_createur_groupe, utilisateur.prenom_utilisateur as prenom_createur_groupe
    FROM affecter
    LEFT JOIN groupe ON groupe.id_groupe = affecter.id_groupe
    LEFT JOIN utilisateur ON utilisateur.id_utilisateur = groupe.id_utilisateur
    GROUP BY groupe.nom_groupe ASC";
    return $dbh->query($sql)->fetchAll();
}

function getReunionById(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM reunion WHERE id_reunion = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}


function updateReunion(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "UPDATE reunion SET nom_reunion = :nom_reunion, date_reunion = :date_reunion, sujet_reunion = :sujet_reunion, id_groupe = :id_groupe  WHERE id_reunion = :id_reunion";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        'nom_reunion' => htmlspecialchars($_POST['nom']),
        'date_reunion' => $_POST['date'],
        'sujet_reunion' => htmlspecialchars($_POST['sujet']),
        'id_groupe' => $_POST['groupe'],
        'id_reunion' => $id
    ]);

    return $stmt;
}

function insertUsersInGroups(array $users = [])
{
    $dbh = $GLOBALS['dbh'];

    $sql = "INSERT INTO groupe (nom_groupe, date_groupe, id_utilisateur) VALUES (:nom_groupe, NOW(), :id_utilisateur)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $id_groupe = $dbh->lastInsertId();

    // On traite les utilisateurs
    if(count($users) > 0)
    {
        foreach($users as $id_user)
        {
            $sql = "INSERT INTO affecter (id_utilisateur, id_groupe) VALUES (:id_utilisateur, :id_groupe)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                'id_utilisateur' => $id_user,
                'id_groupe' => $id_groupe
            ]);
        }
    }

    return $id_groupe;
}



