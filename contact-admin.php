<?php 
$title = "Contact Administrateur";
include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';
?>

    <link rel="stylesheet" href="assets/css/contact-admin.css">
</head>
<body>
    <header></header>
    <main>

        <div class="contact">
            <h1>Contact</h1>
            <form action="#" method="">
                <div class="name">
                    <div class="form-name">
                        <label for="lastname">Nom</label>
                        <input type="text">
                    </div>

                    <div class="form-name">
                        <label for="firstname">Prénom</label>
                        <input type="text">
                    </div>
                </div>
                <div class="form-email-text">
                    <label for="email">Adresse email</label>
                    <input type="email" placeholder="adresse@email.com">
                    <label for="subject">Sujet</label>
                    <input type="text" placeholder="Demande d'informations...">
                    <label for="message">Message</label>
                    <textarea name="message" id="" cols="30" rows="12"></textarea>
                    <input type="submit" value="ENVOYER" class="submit">
                </div>
            </form>
        </div>

    </main>
    <footer>
        <small>&#169; Copyright</small>
        <small>Politique de confidentalité</small>
    </footer>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-bottom.php'; ?>