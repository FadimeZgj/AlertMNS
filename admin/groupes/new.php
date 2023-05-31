<?php

require $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/inc-session-check.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/managers/user-manager.php';

$title = "AlertMNS - Créer une nouvelle réunion";

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
<link rel="stylesheet" href="/assets/css/reunions.css">
<link rel="stylesheet" href="/assets/css/chaines.css">
<link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-navbar-chaines.php" ?>

    <header>
        <div class="topbar">
            <div class="logo">
                <img src='/assets/images/logo1.png' alt='Logo'>
                <h3>Groupes</h3>
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

    <div class="container">
        <div class="containerLeftInfo">
            <a href="/admin/groupes/index.php"><button class="createReunionBtn"><i
                        class="fa-solid fa-arrow-left fa-lg"></i> Revenir à la liste des groupes</button></a>

                        <a href="/admin/reunions/new.php"><button class="createReunionBtn"><i
                        class="fa-solid fa-arrow-left fa-lg"></i> Créer une réunion</button></a>
        </div>
        <div class="container-reunions">
            <div class="participantsForm">
                <form action="/admin/groupes/new.php" method="post">
                    <h1 class="createReunionTitle">Créer un nouveau groupe</h1>

                            <h3>Sélectionnez les utilisateurs</h3>
                            <select name="select-roles" class="" id="selectRole">
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

                        <ul id="usersList" style="display: none;">
                            <?php foreach ($users as $user): ?>
                                <li><input type="hidden" name="utilisateurs[]" value="<?= $user['id_utilisateur'] ?>"></li>
                            <?php endforeach; ?>
                        </ul>

                        </div>
                        <!--Div pour le nom du groupe-->
                        <div class="form-group group-name">
                            <label for="nom">Nom du groupe</label>
                            <input type="text" name="groupe[nom_groupe]" />
                        </div>

                        <div class="form-group submitBtn">
                            <input type="submit" name="submit" value="Créer">
                        </div>

                </form>

            </div>

        </div>
    </div>

    <script>

        const getSelect = document.getElementById("selectRole");
        const ulUsersList = document.getElementById("usersList");

        getSelect.addEventListener("click", (e) => {
            let id = getSelect.options[getSelect.selectedIndex].value; // permet de récupérer l'ID
            let role = getSelect.options[getSelect.selectedIndex].text; // permet de récupérer la valeur de l'ID (admin, formateur, stagiaire...)
            console.log(id, role);
            ulUsersList.innerHTML = ""
            ulUsersList.style.display = "block"
            fetch('../../json/get_users_roles.php?id_role=' + id).then(function (response) {
                return response.json();
            }).then(function (displayUsersByRole) {
                console.log(displayUsersByRole)
                for (j = 0; j < displayUsersByRole.length; j++) {
                    // Si option value = 1 (Administrateur), j'affiche les membres qui ont pour rôle "Administrateur"
                    if (id == displayUsersByRole[j].id_role) {
                        const li = document.createElement("li");
                        const input = document.createElement("input");
                        input.type = "checkbox";
                        input.name = "utilisateurs[]";
                        input.value = displayUsersByRole[j].id_utilisateur;
                        li.appendChild(input);

                        usersList = document.createTextNode(" " + displayUsersByRole[j].nom_utilisateur + " " + displayUsersByRole[j].prenom_utilisateur);
                        li.appendChild(usersList);

                        ulUsersList.appendChild(li);
                        console.log(displayUsersByRole[j].libelle_role + " " + displayUsersByRole[j].nom_utilisateur + " " + displayUsersByRole[j].prenom_utilisateur)
                    }
                    // Correspond à l'option value 4 = "Tous les utilisateurs"
                    else if (id == 4) {
                        const li = document.createElement("li");
                        const input = document.createElement("input");
                        input.type = "checkbox";
                        input.name = "utilisateurs[]";
                        input.value = displayUsersByRole[j].id_utilisateur;
                        li.appendChild(input);

                        usersList = document.createTextNode(" " + displayUsersByRole[j].nom_utilisateur + " " + displayUsersByRole[j].prenom_utilisateur);
                        li.appendChild(usersList);

                        ulUsersList.appendChild(li);
                        console.log(displayUsersByRole[j].libelle_role + " " + displayUsersByRole[j].nom_utilisateur + " " + displayUsersByRole[j].prenom_utilisateur)
                    }
                }
            })
        })

    </script>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/inc-bottom.php" ?>