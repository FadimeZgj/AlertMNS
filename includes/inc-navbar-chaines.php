<?php

if (in_array("Administrateur", $_SESSION['user']['roles'])): ?>

    <div class="sidebar">

        <div class="top-icons">
            <a href="/admin"><i class="fa-solid fa-house fa-2x"></i></a>
            <a href="/admin/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>

            </a>
            <a href="/admin/groupes"><i class="fa-solid fa-users fa-2x"></i>

            </a>
            <a href="/admin/chaines"><i class="fa-solid fa-tower-cell fa-2x"></i>

            </a>
            <a href="/admin/reunions"><i class="fa-regular fa-calendar-days fa-2x"></i>

            </a>
        </div>
        <div class="bottom-icons">
            <a><i class="fa-solid fa-arrow-right-from-bracket fa-2x hover" id="openLogoutModal"></i>
                <div class="modal-logout" id="logoutModal">
                    <div class="modal-content-logout">
                        <i class="fa-solid fa-power-off fa-5x"></i>
                        <h3>Souhaitez-vous vraiment vous déconnecter de <span>ALERT MNS<span> ?</h3>
                        <button class="cancel-btn" id="cancel-btn">Annuler</button>
                        <a href="../../logout.php"><button class="logout-btn">Oui, je souhaite me
                                déconnecter</button></a>
                    </div>
                </div>
            </a>
            <a href=""><i class="fa-solid fa-user fa-2x"></i>

            </a>
            <a href=""><i class="fa-solid fa-gear fa-2x"></i>

            </a>
        </div>
    </div>
<?php else: ?>
    <div class="sidebar">

        <div class="top-icons">
            <a href="/../user"><i class="fa-solid fa-house fa-2x"></i></a>
            <a href="/../user/messages.php"><i class="fa-solid fa-comment-dots fa-2x"></i>

            </a>
            <a href="/../user/groupes"><i class="fa-solid fa-users fa-2x"></i>

            </a>
            <a href="/../user/chaines"><i class="fa-solid fa-tower-cell fa-2x"></i>

            </a>
            <a href="/../user/reunions"><i class="fa-regular fa-calendar-days fa-2x"></i>

            </a>
        </div>
        <div class="bottom-icons">
            <a><i class="fa-solid fa-arrow-right-from-bracket fa-2x hover" id="openLogoutModal"></i>
                <div class="modal-logout" id="logoutModal">
                    <div class="modal-content-logout">
                        <i class="fa-solid fa-power-off fa-5x"></i>
                        <h3>Souhaitez-vous vraiment vous déconnecter de <span>ALERT MNS<span> ?</h3>
                        <button class="cancel-btn" id="cancel-btn">Annuler</button>
                        <a href="../../logout.php"><button class="logout-btn">Oui, je souhaite me
                                déconnecter</button></a>
                    </div>
                </div>
            </a>
            <a href=""><i class="fa-solid fa-user fa-2x"></i>

            </a>
            <a href=""><i class="fa-solid fa-gear fa-2x"></i>

            </a>
        </div>
    </div>


<?php endif; ?>