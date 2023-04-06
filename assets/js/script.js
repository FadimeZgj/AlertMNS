// menu burger responsive

const navbarMenu = document.querySelector(".navbar-menu");
const navbarToggle = document.querySelector(".navbar-toggle");

navbarToggle.addEventListener("click", function (e) {
    navbarMenu.classList.toggle("active");
});

// On récupère l'id de la modale
var addSalonModal = document.getElementById("addSalonModal");

// On récupère le bouton qui permet d'ouvrir la modale
var createSalonModalButton = document.getElementById("createSalonModalButton");

// On récupère la classe close du <span> qui permet de fermer la modale
var closeModal = document.getElementById("closeModal");

// Quand l'utilisateur clic sur le bouton, cela ouvre la modale
createSalonModalButton.onclick = function () {
    addSalonModal.style.display = "block";
}

// Quand l'utilisateur clique sur la croix <span> (x), cela ferme la modale
closeModal.onclick = function () {
    addSalonModal.style.display = "none";
}

// Quand l'utilisateur clique en dehors de la modale, cela la ferme
window.onclick = function (e) {
    if (e.target == addSalonModal) {
        addSalonModal.style.display = "none";
    }
}


// JS pour afficher le nav menu

// On récupère le bouton auquel on va ajouter l'évènement
const burgerMenuBtn = document.getElementById("burgerMenu");

burgerMenuBtn.addEventListener("click", responsiveMenu);

var responsiveMenu = document.getElementById("responsiveMenu");
// Afficher le menu quand on clic sur le burger
function responsiveMenu() {
    if (responsiveMenu.style.display === "block") {
        responsiveMenu.style.display = "none";
        chaines.style.display = "block";
    } else {
        responsiveMenu.style.display = "block";
        chaines.style.display = "block";
    }
}


// JS pour afficher les options

// On récupère le bouton auquel on va ajouter l'évènement
const clickEllipsis = document.getElementById("clickEllipsis");

clickEllipsis.addEventListener("click", showChatMenu);

var showChatMenu = document.getElementById("showChatMenu");
// Afficher le menu quand on clic sur le burger
function showChatMenu() {
    if (showChatMenu.style.display === "block") {
        showChatMenu.style.display = "none";
    } else {
        showChatMenu.style.display = "block";
    }
}

const closeEllipsisMenu = document.getElementById("closeEllipsisMenu");

closeEllipsisMenu.addEventListener("click", closeMenu);

function closeMenu() {
    if (showChatMenu.style.display === "block") {
        showChatMenu.style.display = "none";
    } else {
        showChatMenu.style.display = "block";
    }
}
