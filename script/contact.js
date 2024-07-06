document.addEventListener("DOMContentLoaded", function () {
  // Supposons que l'inscription soit stockée dans le localStorage
  const isRegistered = localStorage.getItem("isRegistered");

  // Référence aux éléments HTML
  const contactForm = document.getElementById("contactForm");
  const notRegisteredMessage = document.getElementById("notRegisteredMessage");

  // Vérification de l'inscription
  if (isRegistered === "true") {
    contactForm.style.display = "block";
    notRegisteredMessage.style.display = "none";
  } else {
    contactForm.style.display = "none";
    notRegisteredMessage.style.display = "block";
  }
});

// Exemple de fonction pour simuler l'inscription (vous pouvez l'appeler via un autre bouton ou action)
function registerUser() {
  localStorage.setItem("isRegistered", "true");
  alert("Vous êtes maintenant inscrit !");
  // Recharge la page pour appliquer les changements
  window.location.reload();
}
