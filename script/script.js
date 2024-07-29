/* --------------------------Effets Couleurs-------------------------------- */

// Ce script s'exécute une fois que le DOM est entièrement chargé et prêt
document.addEventListener("DOMContentLoaded", () => {
  // Sélectionne les éléments et la section
  const circleBlue = document.querySelector(".circle-2");
  const circlePink = document.querySelector(".circle-1");
  const colorSection = document.querySelector(".intro");

  // Fonction pour changer l'arrière-plan et stocker la couleur
  function setBackground(color) {
    colorSection.style.background = color;
    localStorage.setItem("backgroundColor", color);
  }

  // Lire la couleur stockée lors du chargement de la page
  const savedColor = localStorage.getItem("backgroundColor");
  if (savedColor) {
    colorSection.style.background = savedColor;
  }

  // Ajouter les écouteurs d'événements pour les cercles
  circleBlue.addEventListener("click", () => {
    setBackground("linear-gradient(90deg, #ffffff, #00b5fd)");
  });

  circlePink.addEventListener("click", () => {
    setBackground("linear-gradient(90deg, #ffffff, #f32bf3)");
  });
});

/* -------------------------Effets Textes et Photos----------------------------------- */

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
