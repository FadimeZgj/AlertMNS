<?php 

$title = "AlertMNS - Chaînes";
include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

?>
    <link rel="stylesheet" href="/assets/css/chaines.css">
</head>

<body>
    <nav class="sidebar">
        <ul class="nav-left">
            <li><a href="#"><i class="fas fa-house-chimney-window fa-xl"></i></a></li>
            <li><a href="#"><i class="fa-solid fa-comment-dots fa-xl"></i></a></li>
            <li><a href="#"><i class="fa-solid fa-users-rectangle fa-xl"></i></a></li>
            <li><a href=""><i class="fa-solid fa-diagram-project fa-xl"></i></a></li>
            <li><a href=""><i class="fa-regular fa-calendar fa-xl"></i></a></li>
        </ul>
    </nav>
    <nav class="responsive-menu">
        <div class="burger-icon">
            <button id="burgerMenu">
                <i class="fa-solid fa-bars fa-2xl"></i>
            </button>
            <button id="closeMenu" class="closeMenu">
                <i class="close fa-solid fa-xmark fa-2xl"></i>
            </button>
        </div>
        <ul id="responsiveMenu" class="ul">
            <li><a href="/admin/index.html"><i class="fa-solid fa-house"></i> Accueil</a></li>
            <li><a href="/messages.html"><i class="fa-solid fa-comment-dots"></i> Voir tous les messages</a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Voir tous les groupes</a></li>
            <li><a href="/chaines.html"><i class="fa-solid fa-tower-cell"></i> Voir toutes les chaînes</a></li>
            <li><a href="#"><i class="fa-regular fa-calendar"></i> Voir les réunions prévues</a></li>
            <li><a href="#"><i class="fa-solid fa-user"></i> Gérer mon profil</a></li>
            <li><a href="#"><i class="fa-solid fa-gear"></i> Réglages</a></li>
            <li><a href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i> Se déconnecter</a></li>
        </ul>
    </nav>



    <div class="container">
        <div class="chaines" id="chaines">
            <h2>Chaînes</h2>
            <div class="channel-group channel-devweb1" id="devweb1">
                <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                <h3>Dev Web 1</h3>
            </div>
            <div class="channel-group">
                <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                <h3>Dev Web 2</h3>
            </div>
            <div class="channel-group">
                <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                <h3>CDA C#</h3>
            </div>
            <div class="channel-group">
                <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                <h3>CDA DOTNET</h3>
            </div>
            <div class="channel-group">
                <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                <h3>MNS INFOS</h3>
            </div>
            <div class="channel-group">
                <img src='https://dummyimage.com/70x70/1D2D44/FFFFFF.png?text=Cha%C3%AEnes' alt="logo chaine">
                <h3>Co-voiturage</h3>
            </div>
        </div>
        <div class="salons" id="salons">
            <div class="top-header-nom-salon">
                <i class="fa-solid fa-chevron-left fa-2xl"></i>
                <h2>Dev Web 1</h2>
                <i class="fa-solid fa-chevron-right fa-2xl"></i>
            </div>
            <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher un salon...">
            <div class="create-salon">
                <div class="add">
                    <h3>Salons</h3><i class="fas fa-plus fa-2xl"></i>
                </div>
                <div class="salons-liste">
                    <div class="salon">Général</div>
                    <div class="salon">HTML/CSS</div>
                    <div class="salon">JavaScript</div>
                    <div class="salon salon-PHP">PHP / BDD</div>
                    <div class="salon">TRE</div>
                    <div class="salon">React</div>
                    <div class="salon">Méthodologie projet</div>
                </div>
            </div>
        </div>

        <!-- Concerne l'entête de la discussion -->
        <div class="discussion" id="discussion">
            <div class="topbar">
                <h2>PHP/BDD</h2>
                <i class="fa-solid fa-magnifying-glass icon"></i><input type="search" placeholder="Rechercher...">
                <i class="fa-solid fa-user-group fa-xl"></i>
                <i class="fa-solid fa-ellipsis fa-2xl"></i>
            </div>

            <!-- Pour les bulles de discussions-->

            <!--Bulle de discussion de l'autre personne-->
            <div class="conversation">
                <div class="message-me">
                    <div class="user-info">
                        <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                    </div>
                    <div class="bulle">
                        <div class="info">
                            <p class="name">Nom</p>
                            <p class="date">14 mai 2022</p>
                        </div>
                        <div class="arrow-left">
                        </div>
                        <div class="contenu-message">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet
                                consectetur adipisicing elit. Expedita adipisci magni magnam nostrum, at beatae
                                reprehenderit exercitationem asperiores ex ipsam quam veniam sequi quisquam sapiente
                                animi accusantium dolor sunt quia?</p>
                        </div>
                    </div>
                </div>

                <!--Bulle de discussion de l'utilisateur-->
                <div class="message-user">
                    <div class="bulle-user">
                        <div class="info">
                            <p class="name">Nom</p>
                            <p class="date">14 mai 2022</p>
                        </div>
                        <div class="bubble-right">
                            <div class="contenu-my-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                            </div>
                            <div class="arrow-right">
                            </div>
                        </div>
                    </div>
                    <div class="my-info">
                        <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                    </div>
                </div>

                <!-- Deuxième bulle de l'autre personne-->

                <div class="conversation">
                    <div class="message-me">
                        <div class="user-info">
                            <img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt="photo_de_profil">
                        </div>
                        <div class="bulle">
                            <div class="info">
                                <p class="name">Nom</p>
                                <p class="date">14 mai 2022</p>
                            </div>
                            <div class="arrow-left">
                            </div>
                            <div class="contenu-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet
                                    consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boîte de dialogue -->
                    <div class="chatbox">
                        <input type="text" placeholder="Ecrivez votre message...">
                    </div>


                    <!-- Icônes de la boîte de dialogue-->
                    <div class="icons-group">
                        <i class="fas fa-images fa-xl"></i>
                        <i class="fa-regular fa-face-smile fa-xl"></i>
                        <i class="fa-solid fa-ellipsis fa-2xl"></i>
                        <div class="send-button">
                            <input type="button" value="Envoyer">
                        </div>
                    </div>

                </div><!--conversation-->
            </div> <!--discussion -->
        </div> <!--container -->
    </div>
    <script>
        // Permet d'afficher le menu et de cacher les chaînes

        // On récupère l'ul qui a l'id "responsiveMenu"
        var showMenu = document.getElementById("responsiveMenu");

        // On récupère les chaînes avec l'id "chaines"
        let chaines = document.getElementById("chaines");

        // On récupère les salons avec l'id "salons"
        var salons = document.getElementById("salons");

        // On récupère l'interface de la message avec l'id "messagerie"
        var discussion = document.getElementById("discussion");

        // On récupère le bouton auquel on va ajouter l'évènement
        const burgerMenuBtn = document.getElementById("burgerMenu");

        burgerMenuBtn.addEventListener("click", buttonHideAndShowNav);

        function buttonHideAndShowNav() {
            if (showMenu.style.display === "block") {
                showMenu.style.display = "none";
                chaines.style.display = "block";
            } else {
                showMenu.style.display = "block";
                chaines.style.display = "none";
            }
        }

        // // Permet de cacher le burger si on est sur la liste des salons (fonctionne pas)
        // if ((salons.style.display === "block") && (chaines.style.display === "none")) {
        //     burgerMenuBtn.style.display = "none";
        // }
        // else if ((salons.style.display === "none") && (chaines.style.display === "block")){
        //     burgerMenuBtn.style.display = "block";
        // }

        const devWeb1 = document.getElementById("devweb1");

        devweb1.addEventListener("click", function () {
            if (devWeb1.style.display === "block") {
                devWeb1.style.display = "none";
                salons.style.display = "block";
                chaines.style.display = "none";
            } else {
                devWeb1.style.display = "block";
                salons.style.display = "none";
            }
        });

    </script>
    <script src="/assets/js/script.js"></script>
    
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>