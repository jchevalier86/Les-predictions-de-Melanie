/* -----------------------Effets Etoiles------------------------- */

document.addEventListener("DOMContentLoaded", function () {
  const ratingLabels = document.querySelectorAll(".rating label");

  ratingLabels.forEach((label) => {
    label.addEventListener("mouseover", function () {
      const value = this.getAttribute("for").replace("star", "");
      highlightStars(value);
    });

    label.addEventListener("mouseout", function () {
      removeHighlight();
    });
  });

  function highlightStars(value) {
    ratingLabels.forEach((label) => {
      const starValue = label.getAttribute("for").replace("star", "");
      if (starValue <= value) {
        label.style.color = "#ffd700";
      } else {
        label.style.color = "#ccc";
      }
    });
  }

  function removeHighlight() {
    const checkedValue = document.querySelector('input[name="rating"]:checked');
    if (checkedValue) {
      const value = checkedValue.value;
      highlightStars(value);
    } else {
      ratingLabels.forEach((label) => {
        label.style.color = "#ccc";
      });
    }
  }
});

/* -----------------Affichage Avis par 5 avec bouton voir plus------------------- */

document.addEventListener("DOMContentLoaded", function () {
  var voirPlusButton = document.getElementById("voir-plus");
  var hiddenAvis = document.querySelectorAll(".avis-item.hidden");
  var avisIndex = 0;

  voirPlusButton.addEventListener("click", function () {
    // Afficher les 5 prochains avis cachés
    for (var i = 0; i < 5 && avisIndex < hiddenAvis.length; i++, avisIndex++) {
      hiddenAvis[avisIndex].classList.remove("hidden");
    }

    // Si tous les avis sont affichés, masquer le bouton "voir plus"
    if (avisIndex >= hiddenAvis.length) {
      voirPlusButton.style.display = "none";
    }
  });
});
