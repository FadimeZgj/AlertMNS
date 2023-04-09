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
            <div class="logo"><img src='https://dummyimage.com/150x150/1D2D44/FFFFFF.png?text=LOGO' alt="Logo" /></div>
        </div>
    </header>

    <main class="main-content">
        <div class="main-form">
            <form action="/login-POST.php" method="POST">
                <label for="email"></label>
                <input type="email" id="email" name="email" placeholder="adresse@email.fr">
                <?php if(isset($_SESSION['errors']['email'])): ?>
                <small class="error-email"><?= $_SESSION['errors']['email'] ?></small>
                <?php endif; ?>

                <label for="password"></label>
                <input type="password" id="password" name="password" placeholder="********">
                <?php if(isset($_SESSION['errors']['password'])): ?>
                <small class="error-password"><?= $_SESSION['errors']['password'] ?></small>
                <?php endif; ?>

                <small class="forgetPassword"><a href="">Mot de passe oublié ?</a></small>

                <input type="submit" name="submit" value="Connexion">
            </form>
            
            <?php if(isset($_SESSION['error'])): ?>
                <p class="invalid"><?= $_SESSION['error'] ?></p>
            <?php endif; 

            session_destroy();?> 

        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="contact">
                <a href="/contact-admin.php"><i class="fa-solid fa-envelope fa-xl"></i><h3>Contactez l'administrateur</h3></a>
            </div>
            <div class="copyright">
                <h5> 	&#xA9; Copyright</h5>
                <h5>Politique de confidentialité</h5>
            </div>
        </div>
    </footer>


    <script src="/assets/js/script.js"></script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>