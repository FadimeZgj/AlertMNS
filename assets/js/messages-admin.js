
// let user = userId

let listMsg = document.querySelector('#conv')


// récupérer le dernier message envoyé par l'interlocuteur
function getLastMsg() {
  return fetch("../../json/get-last-messages.php")
    .then(function (response) {
      return response.json();
    })
    .then(function (lastMessages) {
      console.log(lastMessages)
     
      // Boucle qui parcourt l'objet  
      for (i = 0; i < lastMessages.length; i++) {

        // div qui affiche le resultat
        let html = '<div class="message" data-id = ' + lastMessages[i].id_expediteur + ' ><div class="image-user">' +
          "<img src='https://dummyimage.com/70x70/1D2D44/ffffff.png?text=Photo' alt='Photo'>" +
          '</div>' +
          '<div class ="right-content"><div class ="info-user"><div class ="name">' +
          '<h3 id="destName">' + lastMessages[i].prenom_exp + ' ' + lastMessages[i].nom_exp + '</h3>' +
          '<h4>' + lastMessages[i].libelle_role + '</h4></div>' +
          '<div class="hour">Il y a 1 h</div>' +
          '</div>' +
          '<div class="text-message">' +
          '<p>' + lastMessages[i].text_message.slice(0, 50) + '...' + '</p>' +
          '</div></div></div>'
        listMsg.insertAdjacentHTML('beforeend', html);
      }
      // Ajouter la dernière conversation à sessionStorage
      if (lastMessages.length > 0) {
        const lastMessageId = lastMessages[lastMessages.length - 1].id_expediteur;
        sessionStorage.setItem('lastMessageId', lastMessageId);
      }
    })
}
let dataId

// fonction asynchrone pour récupérer l'id après l'affichage des derniers messages
async function getId() {
  //attendre la fonction qui récupère le dernier message
  await getLastMsg()
  // récupérer l'id du destinataire
  let recipient = document.querySelectorAll('.message');
  recipient.forEach(recipientId => {
    recipientId.addEventListener('click', function () {
      dataId = recipientId.getAttribute('data-id');
      // Mettre à jour l'URL avec l'ID
      updateURL(dataId);
      // Appeler une fonction pour traiter l'ID
      handleId(dataId);
    });
  });
}

// fonction qui permet de mettre à jour l'url avec l'id du destinataire
function updateURL(dataId) {
  const url = new URL(window.location.href);
  url.searchParams.set("id", dataId);
  const newURL = url.toString();
  history.pushState(null, "", newURL);
}
// fonction qui récupère l'id dans l'url
function getURLParameter(name) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(name);
}

// Affiche les messages dans l'interface avec les bulles etc...
function displayMessages(messages) {
  dataId = getURLParameter('id');
  console.log(dataId)
  let interface = document.querySelector(".conversation-interface")

  // Vérifier si la div des messages est déjà vide ou non
  let isInterfaceEmpty = interface.innerHTML.trim() === '';
  if (dataId) {

  }
  messages.forEach(function (message) {
    // construire le HTML pour le message
    if (message.id_exp != dataId) {
      interface.innerHTML += '<div class="message-user"><div class="bulle-user"><div class="info">' +
        '<p class="name">' + message.prenom_exp + ' ' + message.nom_exp + '</p><p class="date">' + message.date_message + '</p></div>' +
        '<div class="bubble-right"><div class="contenu-my-message">' +
        '<p>' + message.text_message + '</p></div>' +
        '<div class="arrow-right"></div>' +
        "<img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt='photo_de_profil'></div></div>"

    }
    else {
      interface.innerHTML += '<div class="conversation"><div class ="message-me"><div class = "user-info">' +
        "<img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt='photo_de_profil'></div>" +
        '<div class="bulle"><div class="info">' +
        '<p class="name">' + message.prenom_exp + ' ' + message.nom_exp + '</p><p class="date">' + message.date_message + '</p></div>' +
        '<div class="arrow-left"></div>' +
        '<div class="contenu-message"><p>' + message.text_message + '</p></div></div></div></div>';
    }
    // commencer au bas de la div
    element = document.querySelector('.conversation-interface')
    element.scrollTop = element.scrollHeight;
  })

  // Si la div des messages était vide, ajustez le scroll pour afficher les nouveaux messages ajoutés
  if (isInterfaceEmpty) {
    element.scrollTop = element.scrollHeight;
  }
}


function handleId(dataId) {
  // Stocker l'ID dans le sessionStorage
  sessionStorage.setItem('lastClickedId', dataId);
  // Récupérer l'ID de la dernière conversation
  const lastMessageId = sessionStorage.getItem('lastMessageId');

  // Utiliser l'ID de la dernière conversation s'il n'y a pas d'ID de destinataire dans l'URL
  if (!dataId && lastMessageId) {
    dataId = lastMessageId;
  }
  // Faites quelque chose avec l'ID récupéré, par exemple une requête Fetch
  fetch("../../json/get-conversations.php?id=" + dataId)
    .then(function (response) {
      return response.json();
    })
    .then(function (conversation) {
      // Traitez les détails du message ici
      console.log(conversation);
      displayMessages(conversation)

    })
    .catch(function (error) {
      console.log(error);
    });
  console.log(dataId);
}

window.addEventListener('DOMContentLoaded', function () {
  let lastClickedId = sessionStorage.getItem('lastClickedId');
  if (lastClickedId) {
    // Utiliser le dernier ID...
    handleId(lastClickedId)
  } else {
    // Vérifier si un ID de destinataire est présent dans l'URL
    const url = new URL(window.location.href);
    const dataId = url.searchParams.get("id");
    if (dataId) {
      handleId(dataId);
    } else {
      // Sinon, récupérer l'ID de la dernière conversation
      const lastMessageId = sessionStorage.getItem('lastMessageId');
      if (lastMessageId) {
        handleId(lastMessageId);
      }
    }
  }
})



// Gérer l'événement popstate pour récupérer le nouvel ID lors de la navigation
window.addEventListener("popstate", function (event) {
  const url = new URL(window.location.href);
  const dataId = url.searchParams.get("id");
  if (dataId) {
    handleId(dataId);
  }
});
getId()

// Récupérer le bouton d'envoi du message
let sendButton = document.getElementById('send-message-btn');

// Ajouter un gestionnaire d'événement au bouton d'envoi
sendButton.addEventListener('click', function (event) {
  // Empêcher le comportement par défaut du bouton d'envoi
  event.preventDefault();

  // Obtenir le contenu du champ de saisie du message
  let messageInput = document.getElementById('message-input');
  let textMessage = messageInput.value;

  // Obtenir l'ID du destinataire à partir de l'URL
  let recipientId = getURLParameter('id');

  // Créer un objet de message avec les données nécessaires
  let message = {
    text_message: textMessage,
    id_destinataire: recipientId
  };

  // Envoyer le message au destinataire sélectionné
  sendMessageToRecipient(message);
  messageInput.value = '';
});

// Récupérer la référence à la div des messages
let conversationInterface = document.querySelector(".conversation-interface");

function sendMessageToRecipient(message) {
  fetch('/admin/messages.php?id=' + encodeURIComponent(message.id_destinataire), {
    method: 'POST',
    body: JSON.stringify(message),
    headers: {
      'Content-Type': 'application/json'
    }
  })
    .then(function (response) {
      console.log(response);
      if (response.ok) {
        // Le message a été envoyé avec succès
        console.log('Message envoyé avec succès');

        // Mettre à jour la div des messages en utilisant AJAX
        fetch("../../json/get-conversations.php?id=" + dataId)
          .then(function (response) {
            return response.json();
          })
          .then(function (conversation) {
            // Obtenir le dernier message de la conversation
            let lastMessage = conversation[conversation.length - 1];

            // Construire le HTML pour le nouveau message
            let messageHtml = '';
            if (lastMessage.id_exp != dataId) {
              messageHtml = '<div class="message-user"><div class="bulle-user"><div class="info">' +
                '<p class="name">' + message.prenom_exp + ' ' + message.nom_exp + '</p><p class="date">' + message.date_message + '</p></div>' +
                '<div class="bubble-right"><div class="contenu-my-message">' +
                '<p>' + message.text_message + '</p></div>' +
                '<div class="arrow-right"></div>' +
                "<img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt='photo_de_profil'></div></div>"
            } else {
              messageHtml = '<div class="conversation"><div class ="message-me"><div class = "user-info">' +
                "<img src='https://dummyimage.com/70x70/3e5c76.png?text=Photo' alt='photo_de_profil'></div>" +
                '<div class="bulle"><div class="info">' +
                '<p class="name">' + message.prenom_exp + ' ' + message.nom_exp + '</p><p class="date">' + message.date_message + '</p></div>' +
                '<div class="arrow-left"></div>' +
                '<div class="contenu-message"><p>' + message.text_message + '</p></div></div></div></div>';
            }

            // Ajouter le nouveau message à la div
            conversationInterface.insertAdjacentHTML('beforeend', messageHtml);

            // Faire défiler jusqu'au bas de la div des messages pour afficher le nouveau message
            conversationInterface.scrollTop = conversationInterface.scrollHeight;

          })

          .catch(function (error) {
            console.error('Erreur lors de la récupération des messages:', error);
          });

        // Effectuez d'autres actions si nécessaire
      } else {
        // Erreur lors de l'envoi du message
        console.error('Erreur lors de l\'envoi du message');
      }
    })
    .catch(function (error) {
      console.error('Erreur lors de l\'envoi du message:', error);
    });
}