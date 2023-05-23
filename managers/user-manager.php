<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';

// Récupérer utilisateur connecté
function getLoggedUser()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur , role.libelle_role FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role
WHERE id_utilisateur = '" . $_SESSION['user']['id'] . "'";
    $query = $dbh->query($sql);
    return $query->fetch(PDO::FETCH_ASSOC);
}

// récupérer tous les roles
function getAllRoles()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM role";
    $query = $dbh->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById(int $id)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM utilisateur 
LEFT JOIN role ON utilisateur.id_role = role.id_role WHERE utilisateur.id_utilisateur = :id_utilisateur";
    $query = $dbh->prepare($sql);
    $res = $query->execute(['id_utilisateur' => $_GET['id']]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function userExist()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT * FROM utilisateur WHERE email_utilisateur = :email_utilisateur";
    $query = $dbh->prepare($sql);
    $res = $query->execute([
        'email_utilisateur' => $_POST['email_utilisateur']
    ]);

    if ($query->rowCount() > 0) {
        $_SESSION['errors']['email_utilisateur'] = "Un utilisateur existe déjà avec cette adresse email.";
        header("Location: /admin/users/add-user.php");
        die;
    }

    return $res;
}

function insertUser(array $data)
{
    $data['mdp_utilisateur'] = password_hash($_POST['mdp_utilisateur'], PASSWORD_DEFAULT);

    $dbh = $GLOBALS['dbh'];
    $sql = "INSERT INTO utilisateur (nom_utilisateur, prenom_utilisateur, email_utilisateur, mdp_utilisateur, id_role) 
     VALUES (:nom_utilisateur, :prenom_utilisateur, :email_utilisateur, :mdp_utilisateur, :id_role)";
    $query = $dbh->prepare($sql);
    $res = $query->execute($data);

    return $dbh->lastInsertId();
}

function updateUser(array $data)
{
    $dbh = $GLOBALS['dbh'];
    $sql = "UPDATE utilisateur 
     SET nom_utilisateur = :nom_utilisateur, 
     prenom_utilisateur = :prenom_utilisateur, 
     email_utilisateur = :email_utilisateur,
     id_role = :id_role
     WHERE id_utilisateur = :id_utilisateur";
    $query = $dbh->prepare($sql);
    $query->execute($data);

    return $query->rowCount() == 1;
}

function archiveUser(int $id)
{
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $dbh = $GLOBALS['dbh'];
    $sql = "UPDATE utilisateur SET is_active = :is_active WHERE id_utilisateur = :id_utilisateur";
    $query = $dbh->prepare($sql);
    $query->execute([
        'is_active' => $isActive,
        'id_utilisateur' => $id
    ]);

    return $query->rowCount() == 1;
}


function searchUser(string $data)
{
    $search = htmlspecialchars($data);
    $data = explode(" ", $search);

    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
            LEFT JOIN role ON utilisateur.id_role = role.id_role
            WHERE utilisateur.nom_utilisateur LIKE :search
            OR utilisateur.prenom_utilisateur LIKE :search
            OR role.libelle_role LIKE :search
            ORDER BY utilisateur.nom_utilisateur ASC";

    $query = $dbh->prepare($sql);
    $query->execute([
        'search' => '%' . $data[0] . '%'
    ]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function getAllUsers()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
        LEFT JOIN role ON utilisateur.id_role = role.id_role ORDER BY utilisateur.nom_utilisateur ASC";
    $query = $dbh->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function adminGetAllUser()
{
    $dbh = $GLOBALS['dbh'];
    $sql = "SELECT utilisateur.id_utilisateur, utilisateur.prenom_utilisateur , utilisateur.nom_utilisateur, utilisateur.is_active , role.libelle_role FROM utilisateur 
    LEFT JOIN role ON utilisateur.id_role = role.id_role 
    WHERE utilisateur.is_active = 1 
    ORDER BY utilisateur.nom_utilisateur ASC";
    $query = $dbh->query($sql);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
