
var viewMembersModal = document.getElementById("viewMembersModal");

// On récupère le bouton qui permet d'ouvrir la modale
var viewMembersModalButton = document.getElementById("viewMembersModalButton")

// On récupère la classe close du <span> qui permet de fermer la modale
var closeModalViewMembers = document.getElementById("closeModalViewMembers");

// Quand l'utilisateur clic sur le bouton, cela ouvre la modale
viewMembersModalButton.onclick = function () {
    viewMembersModal.style.display = "block";
}

// Quand l'utilisateur clique sur la croix <span> (x), cela ferme la modale
closeModalViewMembers.onclick = function () {
    viewMembersModal.style.display = "none";
}

// Quand l'utilisateur clique en dehors de la modale, cela la ferme
window.onclick = function (event) {
    if (event.target == viewMembersModal) {
        viewMembersModal.style.display = "none";
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

///////// JSON qui permet de recharger la liste des salons \\\\\\\\\\\

// Affichage de la liste des salons

// On récupère toutes les chaînes générées par le PHP qui ont la classe "channel-group"
const channelGroups = document.querySelectorAll(".channel-group");
const listeSalon = document.getElementById("listeSalon");

channelGroups.forEach(function (channelGroup) {
    channelGroup.addEventListener("click", function () {
        checkClass("salon", 100);
        // this.style.backgroundColor = '#2f3f54';

        // On vide la liste des salons
        listeSalon.innerHTML = "";

        // Permet de récupérer l'id des chaînes
        const id = channelGroup.id;
        fetch("../../get_salon.php?id_chaine=" + id)
            .then(function (response) {
                return response.json();
            })
            .then(function (displaySalons) {
                for (let j = 0; j < displaySalons.length; j++) {
                    console.log(displaySalons[j].nom_salon)
                    // On crée une div
                    const div = document.createElement("div");
                    // On ajoute la classe "salon" à cette div
                    div.classList.add("salon");
                    // On ajoute un ID à la div "salon_"
                    div.setAttribute("id", "salon_" + (j + 1));
                    // On crée le texte de la div à partir du nom de salon
                    const salon = document.createTextNode(displaySalons[j].nom_salon);
                    div.appendChild(salon);
                    listeSalon.appendChild(div);
                }
            });
    });
});


// Fonction qui permet de vérifier si la classe "salon" est présente lorsque les salons sont générés grâce aux JSON.

function checkClass(salon, intervalTime) {
    // permet de définir un interval de temps (une boucle) qui exécutera une fonction à intervalles de temps réguliers.
    const intervalId = setInterval(() => {
        const salons = document.getElementsByClassName(salon);
        if (salons.length > 0) {
            clearInterval(intervalId);
            console.log(`La classe salon a été récupérée.`);

            for (let i of salons) {
                i.addEventListener("click", () => {
                    nomSalon.innerHTML = ""
                    // Permet de modifier le titre h2 de la conversation des chaînes en récupérant l'id du salon
                    fetch('../../get_salon.php?id_chaine=' + i.id)
                        .then(function (response) {
                            return response.json();
                        })
                        .then(function () {
                            // Permet de récupérer le contenu de l'id salon sélectionné
                            const salonContent = i.textContent;
                            // On crée un h2
                            const h2 = document.createElement("h2");
                            nomSalon.innerText = salonContent;
                            nomSalon.appendChild(h2);
                        });
                });
            }

        }
    }, intervalTime);
}


////// JSON qui permet d'afficher le nom de chaîne correct au-dessus de la liste des salons \\\\\\\\

// On récupère les chaînes contenant la classe "channel-group"
let chaineListe = document.querySelectorAll(".channel-group");

let chaineTitle = document.getElementById("chaineTitle")
// console.log(chaineTitle);

for (let i of chaineListe) {
    i.addEventListener("click", (e) => {
        chaineTitle.innerHTML = ""
        fetch('../../get_chaines.php?id_chaine=' + i.id).then(function (response) {
            return response.json();
        }).then(function (showChanelTitle) {
            console.log(showChanelTitle)
            for (j = 0; j < showChanelTitle.length; j++) {
                chaineTitle.innerHTML = showChanelTitle[j].nom_chaine;
            }
        })
    })
}

// Si is_active = true : on voit le salon, sinon on le cache

// // On récupère les chaînes contenant la classe "isActive"
let chanelIsActiveOrNot = document.querySelectorAll(".isActive");

chanelIsActiveOrNot.forEach(element => console.log(element))

// if (chanelIsActiveOrNot.value == "isActive_0") {
//     chanelIsActiveOrNot.style.display = "none";
// }
