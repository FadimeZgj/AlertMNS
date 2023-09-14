
// Pour le login form et l'oublie de mot de passe, permet d'afficher l'erreur des emails

const getEmailInput = document.querySelector("#email");

getEmailInput.addEventListener("focusin", displayEmailError);

function displayEmailError() {
  getEmailInput.addEventListener("focusout", function (e) {
    const emailMissing = document.querySelector("#emailMissing");
    // La couleur du fond se change en rose si le champ ne correspond pas
    if (this.value.length <= 0) {
      emailMissing.innerHTML = "Veuillez saisir votre adresse email";
      this.style.backgroundColor = "pink";
    } else {
      // Utilisation d'une regex pour valider l'adresse e-mail
      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      if (!this.value.match(emailRegex)) {
        this.style.backgroundColor = "pink";
        emailMissing.innerHTML = "Veuillez saisir une adresse email correcte";
      } else {
        this.style.backgroundColor = "#a9d993";
        emailMissing.innerHTML = "";
      }
    }
  });
}

