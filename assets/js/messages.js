
let user = userId

// récupérer le dernier message envoyé par l'interlocuteur
$.ajax({
  type: "GET",
  url: "../../get-last-messages.php", // Le fichier PHP qui retourne les donnée
  dataType: "json",
  success: function (response) {
    // La fonction à exécuter en cas de succès
    // Afficher les données dans la console pour débogage
    //   // Boucle pour afficher les conversations dans la page HTML
    for (i = 0; i < response.length; i++) {

      let html = '<div class="message" data-id = ' + response[i].id_expediteur + ' ><div class="image-user">' +
        "<img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' alt='Photo'>" +
        '</div>' +
        '<div class ="right-content"><div class ="info-user"><div class ="name">' +
        '<h3 id="destName">' + response[i].prenom_exp + ' ' + response[i].nom_exp + '</h3>' +
        '<h4>' + response[i].libelle_role + '</h4></div>' +
        '<div class="hour">Il y a 1 h</div>' +
        '</div>' +
        '<div class="text-message">' +
        '<p>' + response[i].text_message.slice(0, 50) + '...' + '</p>' +
        '</div></div></div>'
      $("#conv").append(html); // Ajouter la conversation au conteneur HTML

    }
  },
  error: function (jqXHR, textStatus, errorThrown) {
    // La fonction à exécuter en cas d'erreur
    console.log("Erreur : " + errorThrown);
  }
});

$(document).ready(function () {

  let $listeMsg = $(".liste-messages");

  // écouter les clics sur les divs de classe "message"
  $listeMsg.on('click', '.message', function () {
    // récupérer l'ID du destinataire associé à la div cliquée
    let id_destinataire = $(this).data('id');

    $.ajax({

    })

    
    // envoyer la requête AJAX
    $.ajax({
      url: '../../get-conversations.php',
      type: 'POST',
      data: { id_destinataire: id_destinataire },
      dataType: 'json',
      success: function (response) {

        // afficher la conversation dans la liste des messages
        $('.conversation-interface').empty();
        // parcourir tous les messages de la conversation
        response.forEach(function (message) {
          // construire le HTML pour le message
          let messageHTML = ""
          if (message.id_exp == userId) {
            messageHTML = '<div class="message-user"><div class="bulle-user"><div class="info">' +
              '<p class="name">' + message.prenom_exp + ' ' + message.nom_exp + '</p><p class="date">' + message.date_message + '</p></div>' +
              '<div class="bubble-right"><div class="contenu-my-message">' +
              '<p>' + message.text_message + '</p></div>' +
              '<div class="arrow-right"></div></div></div>' +
              '<div class="my-info">' +
              "<img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt='photo_de_profil'></div></div>";
          }
          else {
            messageHTML = '<div class="conversation"><div class ="message-me"><div class = "user-info">' +
              "<img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt='photo_de_profil'></div>" +
              '<div class="bulle"><div class="info">' +
              '<p class="name">' + message.prenom_exp + ' ' + message.nom_exp + '</p><p class="date">' + message.date_message + '</p></div>' +
              '<div class="arrow-left"></div>' +
              '<div class="contenu-message"><p>' + message.text_message + '</p></div></div></div></div>';
          }
          // ajouter le message HTML à la div "conversation"
          $('.conversation-interface').append(messageHTML);
          
        });
      },
      error: function (xhr, status, error) {
        console.error(error);
      }
    });

    $.ajax({
      url: '../../get-users.php',
      type: 'POST',
      data: { id_destinataire: id_destinataire },
      dataType: 'json',
      success: function (response) {
        console.log(response)
        // extraire le nom du destinataire de la réponse
        for (i = 0; i < response.length; i++) {
          let destinataireNom = response[i].prenom_utilisateur + ' ' + response[i].nom_utilisateur;
                  // afficher le nom du destinataire ailleurs dans la page
        $('#dest-name').text(destinataireNom);
        }
            

      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
    
    
  });

});









