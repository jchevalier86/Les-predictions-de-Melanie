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
