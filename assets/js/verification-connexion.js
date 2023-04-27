function validateForm() {
  let email = document.forms["formConnexion"]["email"].value;
  if (email == "") {
    alert("Tous les champs doivent être complétés !");
    return false;
  }
  let password = document.forms["formConnexion"]["password"].value;
  if (password == "") {
    alert("Tous les champs doivent être complétés !");
  }
}

const formSubmit = document.querySelector("#submit")
formSubmit.addEventListener("click", validateForm);


// Vérifier si le mot de passe est entré 
const getPassword = document.querySelector("#password")

getPassword.addEventListener("focusin", function (e) {
  getPassword.addEventListener("focusout", function (e) {
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
    else if (this.value.length >= 5) {
      this.style.backgroundColor = "#a9d993"
      passwordMissing.innerHTML = ""
    }
  })
})