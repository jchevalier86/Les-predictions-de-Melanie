document.addEventListener("DOMContentLoaded", (event) => {
  event.preventDefault;
  const circleBlue = document.querySelector(".circle-2");
  const circlePink = document.querySelector(".circle-1");
  const colorSection = document.querySelector(".intro");

  circleBlue.addEventListener("click", () => {
    colorSection.style.background = "linear-gradient(90deg, #ffffff, #00b5fd)";
  });

  circlePink.addEventListener("click", () => {
    colorSection.style.background = "linear-gradient(90deg, #ffffff, #f32bf3)";
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.getElementById("bropbtn");

  menuItems.forEach(function (menuItem) {
    menuItem.addEventListener("click", function () {
      const dropbtn = this.getElementById("dropbtn");
      if (dropbtn.style.display === "block") {
        dropbtn.style.display = "none";
      } else {
        dropbtn.style.display = "block";
      }
    });
  });
});

// Fonction pour vérifier l'état de connexion
function checkLoginStatus() {
  const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";

  // Sélection des éléments de connexion et de déconnexion
  const lienConnect = document.querySelector(".lien-connect");
  const lienDeconnect = document.querySelector(".lien-deconnect");

  if (isLoggedIn) {
    // Si l'utilisateur est connecté
    lienConnect.style.display = "none";
    lienDeconnect.style.display = "block";
  } else {
    // Si l'utilisateur n'est pas connecté
    lienConnect.style.display = "block";
    lienDeconnect.style.display = "none";
  }
}

// Fonction pour se connecter
function login() {
  localStorage.setItem("isLoggedIn", "true");
  checkLoginStatus();
}

// Fonction pour se déconnecter
function logout() {
  localStorage.setItem("isLoggedIn", "false");
  alert("Vous avez bien été déconnecté.");
  window.location.href = "accueil.html"; // Redirigez vers la page d'accueil ou une autre page
}

// Ajouter des événements aux boutons de connexion et de déconnexion
document.addEventListener("DOMContentLoaded", function () {
  checkLoginStatus();

  document.querySelector(".lien-connect").addEventListener("click", login);
  document.querySelector(".lien-deconnect").addEventListener("click", logout);
});
