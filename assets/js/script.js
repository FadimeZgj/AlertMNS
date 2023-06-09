// menu burger responsive

// const navbarMenu = document.querySelector(".navbar-menu");
// const navbarToggle = document.querySelector(".navbar-toggle");

// navbarToggle.addEventListener("click", function (e) {
//   navbarMenu.classList.toggle("active");
// });


// let searchInput = document.querySelector("#searchInput");
// let searchBtn = document.querySelector("#searchBtn");
// searchBtn.disabled = true;
// searchInput.addEventListener("input", stateHandle);
// function stateHandle() {
//   if (searchInput.value === "" || searchInput.value === " ") {
//     searchBtn.disabled = true;
//   } else {
//     searchBtn.disabled = false;
//   }
// }


// Code qui permet d'ouvrir la modale de la navbar quand on se déconnecte

// On récupère l'id de la modale
let logoutModal = document.getElementById("logoutModal");

// On récupère le bouton qui permet d'ouvrir la modale
let openLogoutModal = document.getElementById("openLogoutModal");

// On récupère la classe close du <span> qui permet de fermer la modale
let closeModal = document.getElementById("closeModal");

// Quand l'utilisateur clic sur le bouton, cela ouvre la modale
openLogoutModal.onclick = function () {
  logoutModal.style.display = "block";
}

// On ferme la modale quand on appuie sur le bouton cancel
let cancelBtn = document.getElementById("cancel-btn");
cancelBtn.addEventListener("click", (e) => {
  logoutModal.style.display = "none";
})
// Quand l'utilisateur clique en dehors de la modale, cela la ferme
window.onclick = function (e) {
  if (e.target == logoutModal) {
    logoutModal.style.display = "none";
  }
}

function deleteImage() {
  var image = document.getElementById('preview');
  image.src = '';
  var input = document.getElementById('imageFile');
  input.value = '';
}