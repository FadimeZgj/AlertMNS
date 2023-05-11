<?php

if (in_array("Administrateur", $_SESSION['user']['roles'])) : ?>

    <section>
        <div class="actions">
            <ul>
                <li><a href="/admin/users/add-user.php"><i class="fa-solid fa-plus fa-xl"></i>Créer un utilisateur</a></li>
                <li><a href=""><i class="fa-solid fa-plus fa-xl"></i>Créer une nouvelle chaine</a></li>
                <li><a href=""><i class="fa-solid fa-plus fa-xl"></i>Créer un nouveau groupe</a></li>
                <li><a href=""><i class="fa-solid fa-plus fa-xl"></i>Organiser une réunion</a></li>
                <li><a href="/search-user.php"><i class="fa-solid fa-magnifying-glass fa-xl"></i>Rechercher un utilisateur</a></li>
                <li><a href="/admin/chaines"><i class="fa-solid fa-tower-cell fa-xl"></i>Voir les chaînes</a></li>
                <li><a href=""><i class="fa-solid fa-users fa-xl"></i>Voir les groupes</a></li>
                <li><a href="/admin/messages.php"><i class="fa-solid fa-comment-dots fa-xl"></i>Voir les messages</a></li>
                <li><a href=""><i class="fa-regular fa-calendar-days fa-xl"></i>Voir les réunions prévues</a></li>
                <li><a href="/search-user.php"><i class="fa-solid fa-circle-exclamation fa-xl"></i>Signalements reçus</a></li>
                <li><a href=""><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer un utilisateur</span></a></li>
                <li><a href=""><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer un groupe</span></a></li>
                <li><a href=""><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer une chaine</span></a></li>
            </ul>
        </div>
    </section>
<?php else : ?>

    <section>
        <div class="actions">
            <ul>
                <li><a href=""><i class="fa-solid fa-plus fa-xl"></i>Créer un nouveau groupe</a></li>
                <li><a href=""><i class="fa-solid fa-plus fa-xl"></i>Organiser une réunion</a></li>
                <li><a href="/search-user.php"><i class="fa-solid fa-magnifying-glass fa-xl"></i>Rechercher un utilisateur</a></li>
                <li><a href=""><i class="fa-solid fa-tower-cell fa-xl"></i>Voir les chaînes</a></li>
                <li><a href=""><i class="fa-solid fa-users fa-xl"></i>Voir les groupes</a></li>
                <li><a href="/user/messages.php"><i class="fa-solid fa-comment-dots fa-xl"></i>Voir les messages</a></li>
                <li><a href=""><i class="fa-regular fa-calendar-days fa-xl"></i>Voir les réunions prévues</a></li>
                <li><a href=""><i class="fa-solid fa-circle-exclamation fa-xl"></i>Signalements</a></li>
                <li><a href=""><i class="fa-solid fa-trash-can fa-xl"></i><span>Supprimer un groupe</span></a></li>
            </ul>
        </div>
    </section>


<?php endif; ?>