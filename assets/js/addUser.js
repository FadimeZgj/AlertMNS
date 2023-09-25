
// Vérification du formulaire d'ajout d'un nouvel utilisateur

const regexEmail = /^\S+@\S+\.\S+$/;
const regexMotDePasse = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>\/?])(?=.*[a-z]).{8,}$/;

let form = document.querySelector("#addUserForm")
let errorEmail = document.querySelector('#errorEmail')
let errorPassword = document.querySelector('#errorPassword')

form.addEventListener("submit", (event) => {
    let email = document.querySelector("#email")
    let password = document.querySelector("#password")

    if (!regexEmail.test(email.value)) {
        event.preventDefault();
        errorEmail.innerHTML = "Entrez une adresse email valide."
        email.style.backgroundColor = "pink"

    }

    if (!regexMotDePasse.test(password.value)) {
        errorPassword.innerHTML = "Le mot de passe ne correspond pas aux critères requis.";
        event.preventDefault();
        password.style.backgroundColor = "pink"
    }

    if (document.querySelector('#lastname').value == '') {
        document.querySelector('#errorName').innerHTML = "Saisissez le nom"
        document.querySelector('#lastname').style.backgroundColor = "pink"
        event.preventDefault();
    }

    if (document.querySelector('#firstname').value == '') {
        document.querySelector('#errorFirstname')
        document.querySelector('#errorFirstname').innerHTML = "Saisissez le prénom"
        document.querySelector('#firstname').style.backgroundColor = "pink"
        event.preventDefault();
    }
});
