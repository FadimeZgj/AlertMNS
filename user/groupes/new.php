<?php

require $_SERVER['DOCUMENT_ROOT'] . '/user/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

$title = "AlertMNS - Créer un nouveau groupe";

require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

// récupérer les utilisateur connecté
$utilisateur = getAllActiveUsers();


$groupes = getAllGroupes();
$users = getAllUsers();
$roles = getAllRoles();

if (!empty($_POST['submit'])) {

    $id = insertUsersInGroup($_POST['groupe'], $_POST['utilisateurs']);

    if ($id) {
        header("Location: /admin/groupes/");
        exit;
    } else {
        echo "Une erreur est survenue...";
    }

}

?>

<link rel="stylesheet" href="/assets/css/groupes.css">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/messages.css">
</head>

<body>
    <header>
        <div class="topbar">
            <div class="logo">
                <img src='/assets/images/logo1.png' alt='Logo'>
                <h3>ALERT MNS</h3>
            </div>
            <div class="user-info">
                <img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' alt='Photo'>
                <div class="user-role">
                    <h4 id="userName">
                        <?= $utilisateur['prenom_utilisateur'] ?>
                        <?= $utilisateur['nom_utilisateur'] ?>
                    </h4>
                    <h5>
                        <?= $utilisateur['libelle_role'] ?>
                    </h5>
                </div>
            </div>
        </div>
    </header>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

    <div class="container">
        <div class="containerLeftInfoGroup">
            <a href="/admin/groupes/index.php"><button class="goBackToListGroupesBtn"><i
                        class="fa-solid fa-arrow-left fa-lg"></i> Aller à la liste des groupes</button></a>

            <a href="/admin/reunions/new.php"><button class="createNewReunionBtn"><i class="fa-solid fa-plus fa-lg"></i>
                    Créer une réunion</button></a>
        </div>
        <div class="container-groupes">
            <div class="newGroupForm">
                <form action="/admin/groupes/new.php" method="post" class="createGroupeForm">
                    <h1 class="createGroupTitle">Créer un nouveau groupe</h1>

                    <div class="form-group-new-group">
                        <div class="form-group-new-group-name">
                            <label for="nom">Nom du groupe</label>
                            <input type="text" name="groupe[nom_groupe]" placeholder="ex: Equipe dev" />
                        </div>
                        <h4>Sélectionnez les utilisateurs</h4>
                        <select name="select-roles" class="selectUsersNewGroup" id="selectRole">
                            <option value="">Veuillez sélectionner les participants</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id_role'] ?>">
                                    <?= $role['libelle_role'] ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="4">
                                Tous les utilisateurs
                            </option>
                        </select>
                        <div class="searchUserForm" id="searchUser">

                            <label for="search">Rechercher un utilisateur</label>
                            <input type="search">

                            </div>
                        <ul id="usersList" style="display: none;">
                            <?php foreach ($users as $user): ?>
                                <li><input type="hidden" name="utilisateurs[]" value="<?= $user['id_utilisateur'] ?>"></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="form-group-new-group submitBtn">
                        <input type="submit" name="submit" value="Créer" class="submitCreateGroupBtn">
                    </div>

            </div>
            <!--Div pour le nom du groupe-->
            </form>

        </div>

    </div>
    </div>

    <script>

const getSelect = document.getElementById("selectRole");
const ulUsersList = document.getElementById("usersList");
const getSearchUserDiv = document.getElementById("searchUser");

getSelect.addEventListener("click", (e) => {
  let id = getSelect.value; // permet de récupérer l'ID
  let role = getSelect.options[getSelect.selectedIndex].text; // permet de récupérer la valeur de l'ID (admin, formateur, stagiaire...)
  console.log(id, role);
  ulUsersList.innerHTML = "";
  ulUsersList.style.display = "block";

  fetch('../../json/get_users_roles.php?id_role=' + id)
    .then(function (response) {
      return response.json();
    })
    .then(function (displayUsersByRole) {
      console.log(displayUsersByRole);
      for (j = 0; j < displayUsersByRole.length; j++) {
        // Si option value = 1 (Administrateur), j'affiche les membres qui ont pour rôle "Administrateur"
        if (id == displayUsersByRole[j].id_role) {

          const li = document.createElement("li");
          const input = document.createElement("input");
          input.type = "checkbox";
          input.name = "utilisateurs[]";
          input.value = displayUsersByRole[j].id_utilisateur;
          li.appendChild(input);

          usersList = document.createTextNode(
            " " +
              displayUsersByRole[j].nom_utilisateur +
              " " +
              displayUsersByRole[j].prenom_utilisateur
          );
          li.appendChild(usersList);

          ulUsersList.appendChild(li);
          ulUsersList.style.maxHeight = "25%";
        }
        // Correspond à l'option value 4 = "Tous les utilisateurs"
        else if (id == 4) {
          const li = document.createElement("li");
          const input = document.createElement("input");
          input.type = "checkbox";
          input.name = "utilisateurs[]";
          input.value = displayUsersByRole[j].id_utilisateur;
          li.appendChild(input);

          usersList = document.createTextNode(
            " " +
              displayUsersByRole[j].nom_utilisateur +
              " " +
              displayUsersByRole[j].prenom_utilisateur
          );
          li.appendChild(usersList);

          ulUsersList.appendChild(li);
          ulUsersList.style.maxHeight = "12%";
        }
        // // On n'affiche pas la barre de recherche si on ne sélectionne pas d'options
        // else if (id == "") {
        //   getSearchUserDiv.style.display = "none";
        // }
      }
    });
});



    </script>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>