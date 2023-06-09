<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-db-connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

$title = "Réinitialiser le mot de passe";
// $emails = getAllEmails();

include $_SERVER['DOCUMENT_ROOT'] . '/includes/inc-top.php';

$newPassword = "";

if (isset($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
    if (isset($email)) {
        $password = uniqid(); // Génère un mot de passe aléatoire
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // permet de le hasher

        $to = $email;
        $subject = 'Mot de passe oublié';
        $message = "Bonjour, voici votre nouveau mot de passe : $password";
        $headers = "Content-Type: text/plain; charset=UTF-8\r\n"; // permet de gérer les caractères avec accents

        if (mail($to, $subject, $message, $headers)) {
            $sql = "UPDATE utilisateur SET mdp_utilisateur = ? WHERE email_utilisateur = ?"; // Vide car c'est l'utilisateur qui rentre ce champ
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$hashedPassword, $email]);
            $newPassword = "Voici votre nouveau mot de passe : <strong>" . $password . "</strong>" ;
            // header("Location: /"); die;
        } else {
            echo "Une erreur est survenue...";
        }
    }
}

?>

<link rel="stylesheet" href="/assets/css/reset-password.css">

<body>
    <a class="bounce" href="/index.php"><i class="fa-solid fa-arrow-left fa-3x"></i>Revenir à la page précédente</a>
    <div class="container">
        <h1>Réinitialiser le mot de passe</h1>

        <form action="reset-password.php" method="post">
            <label for="email">Votre adresse email</label>
            <input type="email" name="email" id="email" required>
            <small id="emailMissing" class="emailErrorMessage"></small>
            <small id="confirmPassword" class="confirmPassword"><?= $newPassword ?></small>

            <input type="submit" value="Réinitialiser" id="submitButton">

        </form>
    </div>
</body>

<script src="/assets/js/functions.js"></script>

</html>