<?php

session_start();

$title = "AlertMNS - Connexion";
include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';
?>

<link rel="stylesheet" href="/assets/css/login.css">
</head>

<body>
    <header>
        <div class="main-logo">
            <div class="logo"><img src='/assets/images/logo1.png' alt="Logo de Alert MNS" /></div>
        </div>
    </header>

    <main class="main-content">
        <div class="main-form">
            <form action="/login-POST.php" method="POST" name="formConnexion">
                <input type="email" id="email" name="email" placeholder="adresse@email.fr">
                <small id="emailMissing" class="checkFormEmail"></small>
                <?php if (isset($_SESSION['errors']['email'])): ?>
                    <noscript>
                        <small class="error-email" id="errorEmail">
                            <?= $_SESSION['errors']['email'] ?>
                        </small>
                    </noscript>
                <?php endif; ?>

                <input type="password" id="password" name="password" placeholder="********">
                <small id="passwordMissing" class="checkFormPassword"></small>
                <?php if (isset($_SESSION['errors']['password'])): ?>
                    <noscript>
                        <small class="error-password">
                            <?= $_SESSION['errors']['password'] ?>
                        </small>
                    </noscript>
                <?php endif; ?>

                <small class="forgetPassword" id="recupPassword"><a href="/reset-password.php">Mot de passe oublié
                        ?</a></small>

                <input type="submit" name="submit" value="Connexion" id="submit">
            </form>

            <?php if (isset($_SESSION['error'])): ?>
                <p class="invalid">
                    <?= $_SESSION['error'] ?>
                </p>
            <?php endif;

            session_destroy(); ?>

        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="contact">
                <a href="/contact-admin.php"><i class="fa-solid fa-envelope fa-xl"></i>
                    <h3>Contacter l'administrateur</h3>
                </a>
            </div>
            <div class="copyright">
                <h5> &#xA9; Copyright</h5>
                <h5>Politique de confidentialité</h5>
            </div>
        </div>
    </footer>


    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/verification-connexion.js"></script>
    <script src="/assets/js/functions.js"></script>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>