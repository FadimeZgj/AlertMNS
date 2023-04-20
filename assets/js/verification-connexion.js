function validateForm() {
  let email = document.forms["formConnexion"]["email"].value;
  if (email == "") {
    alert("Tous les champs doivent être complétés !");
    return false;
  }
  let password = document.forms["formConnexion"]["password"].value;
  if (password == "") {
    alert("Tous les champs doivent être complétés !");
    return false;
  }
}

const formSubmit = document.querySelector("#submit")
formSubmit.addEventListener("click", validateForm);

// // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // // //

const getEmailInput = document.querySelector("#email");

// function removeReadOnly() {
//   getEmailInput.removeAttribute('readonly')
// }
// getEmailInput.addEventListener("mouseenter", removeReadOnly);


// Vérifier le champ email
getEmailInput.addEventListener("focusin", function (e) {
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
    else if (this.value.length >= 6) {
      this.style.backgroundColor = "#a9d993"
      emailMissing.innerHTML = ""
    }
  })
})


// Vérifier si le mot de passe est entré 
document.querySelector("#password").addEventListener("focusin", function (e) {
  document.querySelector("#password").addEventListener("focusout", function (e) {
    const passwordMissing = document.querySelector("#passwordMissing")
    // Changer le fond en rose si le champ ne correspond pas
    if (this.value.length <= 0) {
      passwordMissing.innerHTML = "Veuillez saisir votre mot de passe"
      this.style.backgroundColor = "pink"
    }
    else if ((this.value.length > 1 && this.value.length < 6)) {
      this.style.backgroundColor = "pink"
      passwordMissing.innerHTML = "Mot de passe incorrect"
    }
    else if (this.value.length >= 7) {
      this.style.backgroundColor = "#a9d993"
      passwordMissing.innerHTML = ""
    }
  })
})