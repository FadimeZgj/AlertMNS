function validateForm() {
  let nomReunion = document.forms["addReunionForm"]["reunionName"].value;
  let dateReunion = document.forms["addReunionForm"]["dateReunion"].value;
  let sujetReunion = document.forms["addReunionForm"]["reunionSubject"].value;

  if (nomReunion === "" || dateReunion === "" || sujetReunion === "") {
    alert("Tous les champs doivent être complétés !");
    return false;
  }
}

const formSubmit = document.querySelector("#submitAddReunionForm");
formSubmit.addEventListener("click", validateForm);


const submitAddReunionForm = document.querySelector("#submitAddReunionForm");

// Fonction générique pour afficher les erreurs de champ
// paramètre errorElement = id (nom) du span
function displayError(inputElement, errorElement, errorMessage) {
  if (inputElement.value.length <= 0) {
    // Afficher le message d'erreur si le champ est vide
    errorElement.innerHTML = errorMessage;
    inputElement.style.backgroundColor = "#fcb8b3";
  } else if (inputElement.value.length >= 7) {
    // Réinitialiser la couleur de fond si le champ est valide
    inputElement.style.backgroundColor = "#b4d6a5";
    errorElement.innerHTML = "";
  }
}

// Fonction pour configurer la validation d'un champ de formulaire
function setupInputValidation(inputId, errorId, errorMessage) {
  const inputElement = document.querySelector(inputId);
  const errorElement = document.querySelector(errorId);

  inputElement.addEventListener("focusin", () => {
    // Lorsque le champ obtient le focus, ajouter un écouteur pour le focusout
    inputElement.addEventListener("focusout", () => {
      // Appeler la fonction displayError pour afficher les erreurs
      displayError(inputElement, errorElement, errorMessage);
    });
  });
}

// Configuration de la validation pour le champ "Nom de la réunion"
setupInputValidation("#reunionName", "#errorReunionName", "Veuillez saisir le nom de la réunion");

// Configuration de la validation pour le champ "Date de la réunion"
setupInputValidation(
  "#dateReunion",
  "#errorDateReunion",
  "Veuillez saisir la date et l'heure de la réunion (cliquez sur le calendrier)"
);

// Configuration de la validation pour le champ "Sujet de la réunion"
setupInputValidation("#reunionSubject", "#errorReunionSubject", "Veuillez saisir le sujet de la réunion");

