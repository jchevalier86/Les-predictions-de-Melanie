// Ce script s'exécute également une fois que le DOM est entièrement chargé et prêt
document.addEventListener("DOMContentLoaded", function () {
  // Sélectionne tous les éléments avec la classe "bropbtn"
  const menuItems = document.querySelectorAll(".bropbtn");

  // Itère sur chaque élément du menu
  menuItems.forEach(function (menuItem) {
    // Ajoute un écouteur d'événement pour le clic sur chaque élément du menu
    menuItems.addEventListener("click", function () {
      // Sélectionne le bouton de menu à l'intérieur de l'élément cliqué
      const dropbtn = menuItem.querySelector(".dropbtn");
      // Vérifie si le bouton de menu est affiché ou non
      if (dropbtn.style.display === "block") {
        // Si le bouton est affiché, le cache
        dropbtn.style.display = "none";
      } else {
        // Sinon, l'affiche
        dropbtn.style.display = "block";
      }
    });
  });
});

// Fonction pour vérifier si l'utilisateur est connecté
function checkLoginStatus() {
  // Récupère l'état de connexion depuis le localStorage
  const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";

  // Sélectionne les éléments pour les liens de connexion et de déconnexion
  const lienConnect = document.querySelector(".lien-connect");
  const lienDeconnect = document.querySelector(".lien-deconnect");

  // Vérifie si l'utilisateur est connecté ou non
  if (isLoggedIn) {
    // Si connecté, cache le lien de connexion et affiche le lien de déconnexion
    lienConnect.style.display = "none";
    lienDeconnect.style.display = "block";
  } else {
    // Si non connecté, affiche le lien de connexion et cache le lien de déconnexion
    lienConnect.style.display = "block";
    lienDeconnect.style.display = "none";
  }
}

// Fonction pour simuler la connexion de l'utilisateur
function login() {
  // Définit l'état de connexion dans le localStorage
  localStorage.setItem("isLoggedIn", "true");
  // Met à jour l'affichage en fonction du nouvel état de connexion
  checkLoginStatus();
}

// Fonction pour simuler la déconnexion de l'utilisateur
function logout() {
  // Définit l'état de connexion dans le localStorage
  localStorage.setItem("isLoggedIn", "false");
  // Affiche une alerte pour confirmer la déconnexion
  alert("Vous avez bien été déconnecté.");
  // Redirige l'utilisateur vers la page d'accueil
  window.location.href = "accueil.html";
}

// Ce script s'exécute une fois que le DOM est entièrement chargé et prêt
document.addEventListener("DOMContentLoaded", function () {
  // Vérifie l'état de connexion et met à jour l'affichage en conséquence
  checkLoginStatus();

  // Ajoute des écouteurs d'événement pour les liens de connexion et de déconnexion
  document.querySelector(".lien-connect").addEventListener("click", login);
  document.querySelector(".lien-deconnect").addEventListener("click", logout);
});

// Ce script s'exécute également une fois que le DOM est entièrement chargé et prêt
document.addEventListener("DOMContentLoaded", () => {
  // Sélectionne les éléments avec des classes spécifiques pour les afficher
  const presentation = document.querySelector(".presentation");
  const photoBody = document.querySelector(".photo-body");
  const photoBody1 = document.querySelector(".photo-body-1");
  const photoBody2 = document.querySelector(".photo-body-2");
  const photoBody3 = document.querySelector(".photo-body-3");
  const photoBody4 = document.querySelector(".photo-body-4");

  // Vérifie et ajoute la classe "show" si les éléments existent
  if (presentation) {
    presentation.classList.add("show");
  }
  if (photoBody) {
    photoBody.classList.add("show");
  }
  if (photoBody1) {
    photoBody1.classList.add("show");
  }
  if (photoBody2) {
    photoBody2.classList.add("show");
  }
  if (photoBody3) {
    photoBody3.classList.add("show");
  }
  if (photoBody4) {
    photoBody4.classList.add("show");
  }
});
