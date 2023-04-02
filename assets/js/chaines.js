        // On récupère l'id de la modale pour voir les membres
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
  