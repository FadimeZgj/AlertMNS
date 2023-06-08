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
    $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
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
    AND reunion.id_reunion = reunion.id_reunion
    AND reunion.is_active = 1";
    return $dbh->query($sql)->fetchAll();
}

// Pour voir uniquement les réunions auxquels l'utilisateur est inscrit
function getUsersReunion()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT *
    FROM reunion
    LEFT JOIN utilisateur ON utilisateur.id_utilisateur = reunion.id_utilisateur
    LEFT JOIN groupe ON groupe.id_groupe = reunion.id_groupe
    LEFT JOIN affecter ON groupe.id_groupe = affecter.id_groupe
    WHERE groupe.id_groupe = reunion.id_groupe
    AND reunion.id_reunion = reunion.id_reunion
    AND reunion.is_active = 1
    AND affecter.id_utilisateur = '" . $_SESSION['user']['id'] . "'";
    return $dbh->query($sql)->fetchAll();
}

function getAllGroupes()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT affecter.id_utilisateur as id_du_membre_du_groupe, affecter.id_groupe, groupe.id_groupe as num_groupe, groupe.nom_groupe, groupe.date_groupe, groupe.id_utilisateur as id_createur_groupe, utilisateur.nom_utilisateur as nom_createur_groupe, utilisateur.prenom_utilisateur as prenom_createur_groupe
    FROM affecter
    LEFT JOIN groupe ON groupe.id_groupe = affecter.id_groupe
    LEFT JOIN utilisateur ON utilisateur.id_utilisateur = groupe.id_utilisateur
    WHERE groupe.is_active = 1
    GROUP BY groupe.nom_groupe
    ORDER BY groupe.date_groupe DESC";
    return $dbh->query($sql)->fetchAll();
}

function getUsersInGroupe()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
        LEFT JOIN role ON utilisateur.id_role = role.id_role
        ORDER BY utilisateur.nom_utilisateur ASC";
    $query = $dbh->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getGroupById(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM groupe WHERE id_groupe = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
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
        'nom_reunion' => htmlspecialchars($_POST['nom_reunion']),
        'date_reunion' => $_POST['date_reunion'],
        'sujet_reunion' => htmlspecialchars($_POST['sujet_reunion']),
        'id_groupe' => $_POST['groupe'],
        'id_reunion' => $id
    ]);

    return $stmt;
}

function deleteReunion(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "UPDATE reunion SET is_active = 0
    WHERE id_reunion = :id_reunion";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id_reunion' => $id]);

    return $stmt->rowCount();
}

function deleteGroupe(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "UPDATE groupe SET is_active = 0
    WHERE id_groupe = :id_groupe";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['id_groupe' => $id]);

    return $stmt->rowCount();
}

// Pour créer un nouveau groupe
function insertUsersInGroup(array $data, array $users)
{
    $dbh = $GLOBALS['dbh'];
    $data['nom_groupe'] = htmlspecialchars($data['nom_groupe']);
    $data['id_utilisateur'] = $_SESSION['user']['id'];

    $sql = "INSERT INTO groupe (nom_groupe, date_groupe, id_utilisateur) VALUES (:nom_groupe, NOW(), :id_utilisateur)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $id_groupe = $dbh->lastInsertId();

    // Lorsqu'on coche les utilisateurs qui seront inscrit dans le groupe
    if (count($users) > 0) {
        foreach ($users as $id_utilisateur) {
            // On les affecte dans le groupe
            $sql = "INSERT INTO affecter (id_utilisateur, id_groupe) VALUES (:id_utilisateur, :id_groupe)";
            $insertUser = $dbh->prepare($sql);
            $insertUser->execute([
                'id_utilisateur' => $id_utilisateur,
                'id_groupe' => $id_groupe
            ]);
        }
    }
    return $id_groupe;
}

// Pour créer un nouveau groupe et une nouvelle réunion (new V2 et edit V2)
function insertUsersInGroups(array $data, array $users)
{
    $dbh = $GLOBALS['dbh'];
    $data['nom_groupe'] = htmlspecialchars($data['nom_groupe']);
    $data['id_utilisateur'] = $_SESSION['user']['id'];

    $sql = "INSERT INTO groupe (nom_groupe, date_groupe, id_utilisateur) VALUES (:nom_groupe, NOW(), :id_utilisateur)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $id_groupe = $dbh->lastInsertId();

    // Lorsqu'on coche les utilisateurs qui seront inscrit dans le groupe
    if (count($users) > 0) {
        foreach ($users as $id_utilisateur) {
            // On les affecte dans le groupe
            $sql = "INSERT INTO affecter (id_utilisateur, id_groupe) VALUES (:id_utilisateur, :id_groupe)";
            $insertUser = $dbh->prepare($sql);
            $insertUser->execute([
                'id_utilisateur' => $id_utilisateur,
                'id_groupe' => $id_groupe
            ]);
        }
        // On créer la réunion
        $sql = "INSERT INTO reunion (nom_reunion, date_reunion, sujet_reunion, id_utilisateur, id_groupe) VALUES (:nom_reunion,:date_reunion, :sujet_reunion, :id_utilisateur, :id_groupe)";
        $query = $dbh->prepare($sql);
        $res = $query->execute([
            'nom_reunion' => htmlspecialchars($_POST['nom_reunion']),
            'date_reunion' => $_POST['date_reunion'],
            'sujet_reunion' => htmlspecialchars($_POST['sujet_reunion']),
            'id_utilisateur' => $_SESSION['user']['id'],
            'id_groupe' => $id_groupe
        ]);
    }

    return $id_groupe;
}

// Pour modifier une réunion (V2 qui ne fonctionne pas)
function getReunionsGroupesIds(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT r.*
    FROM reunion r
    JOIN affecter a ON a.id_groupe = r.id_groupe
    WHERE a.id_groupe = :id_groupe";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        'id_groupe' => $id
    ]);

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Pour modifier une réunion (V2 qui ne fonctionne pas)
function updateReunionBis(array $data, array $users)
{
    $dbh = $GLOBALS['dbh'];
    $data['nom_groupe'] = htmlspecialchars($data['nom_groupe']);
    $data['id_utilisateur'] = $_SESSION['user']['id'];

    $sql = "UPDATE groupe 
    SET nom_groupe = :nom_groupe, date_groupe = NOW(), id_utilisateur = :id_utilisateur 
    WHERE id_groupe = :id_groupe";
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $rowCount = $stmt->rowCount();

    $id_groupe = $data['id_groupe'];
    $usersInGroup = getReunionsGroupesIds($id_groupe);

    // Lorsqu'on coche les utilisateurs qui sont inscrit dans le groupe
    if (count($users) > 0) {
        foreach ($users as $id_utilisateur) {
            // On vérifie si le genre n'est pas déjà relié au livre, si non on le relie
            if (!in_array($id_utilisateur, $usersInGroup)) {
                // On vérifie si les utilisateurs ne sont pas déjà reliés aux groupes si non on le relie
                $sql = "INSERT INTO affecter (id_utilisateur, id_groupe) VALUES (:id_utilisateur, :id_groupe)";
                $insertUser = $dbh->prepare($sql);
                $insertUser->execute([
                    'id_utilisateur' => $id_utilisateur,
                    'id_groupe' => $id_groupe
                ]);
            }
        }
        foreach ($usersInGroup as $userInGroup) {
            if (!in_array($usersInGroup, $users)) {
                $sql = "DELETE FROM affecter WHERE id_utilisateur = :id_utilisateur AND id_groupe = :id_groupe";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([
                    'id_groupe' => $id_groupe,
                    'id_utilisateur' => $userInGroup
                ]);
            }
        }

        // On modifie la réunion
        $sql = "UPDATE reunion 
        SET nom_reunion = :nom_reunion, date_reunion = :date_reunion, sujet_reunion = :sujet_reunion, id_utilisateur = :id_utilisateur, id_groupe = :id_groupe) 
        WHERE id_reunion = :id_reunion";
        $query = $dbh->prepare($sql);
        $res = $query->execute([
            'nom_reunion' => htmlspecialchars($_POST['nom_reunion']),
            'date_reunion' => $_POST['date_reunion'],
            'sujet_reunion' => htmlspecialchars($_POST['sujet_reunion']),
            'id_utilisateur' => $_SESSION['user']['id'],
            'id_groupe' => $id_groupe
        ]);
    }

    return $rowCount;
}