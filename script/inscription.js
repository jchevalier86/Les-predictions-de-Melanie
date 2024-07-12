function validate() {
  var mot_de_passe = document.getElementById("mot_de_passe").value;
  var confirmation_mot_de_passe = document.getElementById(
    "confirmation_mot_de_passe"
  ).value;
  var date_naissance = document.getElementById("date_naissance").value;
  var email = document.getElementById("email").value;

  if (!validatePassword(mot_de_passe, confirmation_mot_de_passe)) {
    return false;
  }

  if (!validateAge(date_naissance)) {
    return false;
  }

  if (!validateEmail(email)) {
    return false;
  }

  return true;
}

function validatePassword(mot_de_passe, confirmation_mot_de_passe) {
  if (mot_de_passe === confirmation_mot_de_passe) {
    document.getElementById("errorPassword").innerHTML = ""; // Si mot de passe est égale à confirmation au mot de passe, efface le message d'erreur
    return true; // Autorise la soumission du formulaire
  } else {
    document.getElementById("errorPassword").innerHTML =
      "* Les mots de passe ne correspondent pas."; // Sinon message d'erreur "Les mots de passe ne correspondent pas."
    return false; // Empêche la soumission du formulaire
  }
}

function validateAge(date_naissance) {
  var today = new Date();
  var birthDate = new Date(date_naissance);
  var age = today.getFullYear() - birthDate.getFullYear();
  var monthDifference = today.getMonth() - birthDate.getMonth();

  if (
    monthDifference < 0 ||
    (monthDifference === 0 && today.getDate() < birthDate.getDate())
  ) {
    age--;
  }

  if (age >= 18) {
    document.getElementById("errorAge").innerHTML = ""; // Si l'âge est valide, efface le message d'erreur
    return true; // Autorise la soumission du formulaire
  } else {
    document.getElementById("errorAge").innerHTML =
      "* Vous devez avoir au moins 18 ans pour vous inscrire."; // Sinon message d'erreur "Vous devez avoir au moins 18 ans pour vous inscrire."
    return false; // Empêche la soumission du formulaire
  }
}

function validateEmail(email) {
  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex pour vérifier le format de l'email

  if (emailPattern.test(email)) {
    document.getElementById("errorEmail").innerHTML = ""; // Si l'email est valide, efface le message d'erreur
    return true; // Autorise la soumission du formulaire
  } else {
    document.getElementById("errorEmail").innerHTML =
      "* Veuillez entrer une adresse email valide."; // Sinon message d'erreur "Veuillez entrer une adresse email valide."
    return false; // Empêche la soumission du formulaire
  }
}
