<?php


session_start();


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlertMNS - Connexion</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/5b104128e4.js" crossorigin="anonymous"></script>
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
                <i class="fa-solid fa-envelope fa-xl"></i><h3>Contactez l'administrateur</h3>
            </div>
            <div class="copyright">
                <h5> 	&#xA9; Copyright</h5>
                <h5>Politique de confidentialité</h5>
            </div>
        </div>
    </footer>


    <script src="/assets/js/script.js"></script>
</body>

</html>