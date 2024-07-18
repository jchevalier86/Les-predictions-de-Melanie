// Fonction principale de validation du formulaire
function validate() {
  // Récupération des valeurs des champs du formulaire
  var mot_de_passe = document.getElementById("mot_de_passe").value;
  var confirmation_mot_de_passe = document.getElementById(
    "confirmation_mot_de_passe"
  ).value;
  var date_naissance = document.getElementById("date_naissance").value;
  var email = document.getElementById("email").value;
  var phone = document.getElementById("phone").value;

  // Validation du mot de passe
  if (!validatePassword(mot_de_passe, confirmation_mot_de_passe)) {
    return false; // Si la validation du mot de passe échoue, la fonction retourne false et empêche la soumission du formulaire
  }

  // Validation de l'âge
  if (!validateAge(date_naissance)) {
    return false; // Si la validation de l'âge échoue, la fonction retourne false et empêche la soumission du formulaire
  }

  // Validation de l'email
  if (!validateEmail(email)) {
    return false; // Si la validation de l'email échoue, la fonction retourne false et empêche la soumission du formulaire
  }

  // Validation du téléphone
  if (!validatePhone(phone)) {
    return false; // Si la validation du numéro de téléphone échoue, la fonction retourne false et empêche la soumission du formulaire
  }

  return true; // Si toutes les validations réussissent, la fonction retourne true et permet la soumission du formulaire
}

// Fonction de validation du mot de passe
function validatePassword(mot_de_passe, confirmation_mot_de_passe) {
  // Vérifie si le mot de passe et sa confirmation sont identiques
  if (mot_de_passe === confirmation_mot_de_passe) {
    // Si oui, efface le message d'erreur lié au mot de passe
    document.getElementById("errorPassword").innerHTML = "";
    return true; // Retourne true pour indiquer que la validation est réussie
  } else {
    // Si non, affiche un message d'erreur
    document.getElementById("errorPassword").innerHTML =
      "* Les mots de passe ne correspondent pas.";
    return false; // Retourne false pour indiquer que la validation a échoué
  }
}

// Fonction de validation de l'âge
function validateAge(date_naissance) {
  // Crée une instance de la date actuelle
  var today = new Date();
  // Crée une instance de la date de naissance à partir de la chaîne en format yyyy-mm-dd
  var birthDate = new Date(date_naissance);

  // Vérifie si la date de naissance est valide
  if (isNaN(birthDate.getTime())) {
    document.getElementById("errorAge").innerHTML =
      "* Date de naissance invalide.";
    return false;
  }

  // Calcule l'âge en années
  var age = today.getFullYear() - birthDate.getFullYear();
  var monthDifference = today.getMonth() - birthDate.getMonth();

  // Ajuste l'âge si la date de naissance n'est pas encore passée cette année
  if (
    monthDifference < 0 ||
    (monthDifference === 0 && today.getDate() < birthDate.getDate())
  ) {
    age--;
  }

  if (age >= 18) {
    document.getElementById("errorAge").innerHTML = "";
    return true;
  } else {
    document.getElementById("errorAge").innerHTML =
      "* Vous devez avoir au moins 18 ans pour vous inscrire.";
    return false;
  }
}

// Fonction de validation de l'email
function validateEmail(email) {
  // Regex pour vérifier le format de l'email
  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Vérifie si l'email correspond au format attendu
  if (emailPattern.test(email)) {
    // Si oui, efface le message d'erreur lié à l'email
    document.getElementById("errorEmail").innerHTML = "";
    return true; // Retourne true pour indiquer que la validation est réussie
  } else {
    // Si non, affiche un message d'erreur
    document.getElementById("errorEmail").innerHTML =
      "* Veuillez entrer une adresse email valide.";
    return false; // Retourne false pour indiquer que la validation a échoué
  }
}

// Fonction de validation du téléphone
function validatePhone(phone) {
  var phonePattern = /^[0-9]{10}$/; // Vérifie un numéro de téléphone de 10 chiffres
  if (phonePattern.test(phone) || phone === "") {
    document.getElementById("errorPhone").innerHTML = ""; // Efface l'erreur si le téléphone est valide
    return true;
  } else {
    document.getElementById("errorPhone").innerHTML =
      "* Le numéro de téléphone n'est pas valide.";
    return false;
  }
}
