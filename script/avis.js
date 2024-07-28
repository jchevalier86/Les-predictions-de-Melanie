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
