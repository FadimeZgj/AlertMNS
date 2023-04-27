
// Pour le login form et l'oublie de mot de passe, permet d'afficher l'erreur des emails

const getEmailInput = document.querySelector("#email");

getEmailInput.addEventListener("focusin", displayEmailError);

function displayEmailError() {
    // Vérifier le champ email

    getEmailInput.addEventListener("focusout", function (e) {

        const emailMissing = document.querySelector("#emailMissing")
        // La couleur du fond se change en rose si le champ ne correspond pas
        if (this.value.length <= 0) {
            emailMissing.innerHTML = "Veuillez saisir votre adresse email"
            this.style.backgroundColor = "pink"
        }
        else if (!this.value.includes('@')) {
            this.style.backgroundColor = "pink"
            emailMissing.innerHTML = "Veuillez saisir une adresse email correcte"
        }
        else if (this.value.length >= 7) {
            this.style.backgroundColor = "#a9d993"
            emailMissing.innerHTML = ""
        }
    })
}
