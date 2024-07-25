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

// Fonction pour la déconnexion de l'utilisateur
function logout() {
  // Définit l'état de connexion dans le localStorage
  localStorage.setItem("isLoggedIn", "false");
  // // Affiche une alerte pour confirmer la déconnexion
  // alert("Vous avez bien été déconnecté.");
  // // Redirige l'utilisateur vers la page d'accueil
  // window.location.href = "accueil.html";
}

// Ce script s'exécute une fois que le DOM est entièrement chargé et prêt
document.addEventListener("DOMContentLoaded", function () {
  // Vérifie l'état de connexion et met à jour l'affichage en conséquence
  checkLoginStatus();

  // Ajoute des écouteurs d'événement pour les liens de connexion et de déconnexion
  document.querySelector(".lien-connect").addEventListener("click", login);
  document.querySelector(".lien-deconnect").addEventListener("click", logout);
});
