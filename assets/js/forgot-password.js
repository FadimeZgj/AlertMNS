const submitButton = document.querySelector("#submitButton");
const showPassword = document.querySelector('#confirmPassword')
// Quand on appuie sur Submit, affiche le mot de passe

submitButton.addEventListener("click", function (e) {
    showPassword.innerHTML = '<?php echo "Voici votre nouveau mot de passe :" . $password ?>'
});
