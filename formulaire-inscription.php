<?php
  require 'config.php';
  require 'function.php';

  // Vérifier si l'utilisateur est connecté
  $isConnected = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- La balise meta charset spécifie le jeu de caractères utilisé. Utiliser UTF-8 est recommandé pour une compatibilité maximale -->
  <meta charset="UTF-8">

  <!-- La balise meta viewport contrôle la mise en page sur les appareils mobiles et est essentielle pour un design responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Liens vers les feuilles de style CSS pour réinitialiser les styles par défaut et appliquer les styles personnalisés -->
  <link rel="stylesheet" href="./style/reset.css">
  <link rel="stylesheet" href="./style/style.css">
  <link rel="stylesheet" href="./style/inscription-connexion-contact.css">

  <!-- Favicon pour le site, affiché dans l'onglet du navigateur -->
  <link rel="shortcut icon" href="./images/favicon-7.ico" type="image/x-icon">

  <!-- Lien vers les icônes Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Titre de la page (max 60 caractères) affiché dans l'onglet du navigateur -->
  <title> Inscription </title>

  <!-- Meta description de la page (max 160 caractères) pour les moteurs de recherche -->
  <meta name="description"
    content="Découvrez votre avenir avec le service de voyance et cartomancie. Inscrivez-vous dès maintenant pour une consultation personnalisée. Obtenez des réponses claires et précises à vos questions grâce à mon expertise en cartomancie">
</head>

<body>
  <header>
    <!-- Image de l'en-tête avec un logo ou une photo, représentative du site -->
    <img class="photo-header" src="./images/melanie-voyante-2.jpg" alt="Logo de Mélanie Voyante">

    <!-- Navigation pour la page d'inscription avec un lien de retour à l'accueil -->

    <nav class="lien-page-inscription">

      <!-- Logo maison accueil -->
      <div class="lien-home">
        <img class="back-home" src="./images/maison-accueil.png" alt="Retour à la page d'accueil"
          onclick="window.location.href='accueil.php'">
        <span class="home"> Accueil </span>
      </div>

      <h1 class="title"> Les prédictions de Mélanie </h1>
    </nav>
  </header>

  <!-- Conteneur principal pour le formulaire d'inscription -->
  <div class="container">
    
    <!-- Formulaire d'inscription, les données sont envoyées à "inscription.php" en utilisant la méthode POST -->
    <form action="./inscription.php" method="POST">
      <?php if (isset($_SESSION['errorMessages']['isLoggedIn'])): ?>
      <span style="display: block; margin: 20px auto; padding: 10px; width: fit-content; border: 2px solid #C62828; background: #FFEBEE; color: #C62828; border-radius: 5px; text-align: center; font-size: 16px;"> <?php echo $_SESSION['errorMessages']['isLoggedIn']; ?> </span>
      <?php endif; ?>

      <h2> Inscription </h2>

      <!-- Champ de saisie pour le nom -->
      <label for="nom"> Nom <span class="star">*</span> </label>
      <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?php echo isset($_SESSION['form_data']['nom']) ? htmlspecialchars($_SESSION['form_data']['nom']) : ''; ?>" required>
      <br><br>

      <!-- Champ de saisie pour le prénom -->
      <label for="prenom"> Prénom <span class="star">*</span> </label>
      <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" value="<?php echo isset($_SESSION['form_data']['prenom']) ? htmlspecialchars($_SESSION['form_data']['prenom']) : ''; ?>" required>
      <br><br>

      <!-- Champ de saisie pour la date de naissance -->
      <label for="date_naissance"> Date de naissance <span class="star">*</span> </label>
      <input type="date" id="date_naissance" name="date_naissance" value="<?php echo isset($_SESSION['form_data']['date_naissance']) ? htmlspecialchars($_SESSION['form_data']['date_naissance']) : ''; ?>" required>
      <?php if (isset($_SESSION['errorMessages']['age'])): ?>
      <span style="color: red; font-size: 14px;"> <?php echo $_SESSION['errorMessages']['age']; ?> </span>
      <?php endif; ?>
      <br><br>

      <!-- Champ de saisie pour l'email -->
      <label for="email"> E-mail <span class="star">*</span> </label>
      <input type="email" id="email" name="email" placeholder="votre.email@exemple.com" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" required>
      <?php if (isset($_SESSION['errorMessages']['email'])): ?>
      <span style="color: red; font-size: 14px;"> <?php echo $_SESSION['errorMessages']['email']; ?> </span>
      <?php endif; ?>
      <br><br>

      <!-- Champ de saisie pour le numéro de téléphone -->
      <label for="phone"> Tel </label>
      <input type="tel" id="phone" name="phone" placeholder="+33" value="<?php echo isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : ''; ?>">
      <?php if (isset($_SESSION['errorMessages']['phone'])): ?>
      <span style="color: red; font-size: 14px;"> <?php echo $_SESSION['errorMessages']['phone']; ?> </span>
      <?php endif; ?>
      <br><br>

      <!-- Champ de saisie pour le mot de passe -->
      <label for="mot_de_passe"> Votre mot de passe <span class="star">*</span> </label>
      <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Créer votre mot de passe" required>
      <?php if (isset($_SESSION['errorMessages']['mot_de_passe'])): ?>
      <span style="color: red; font-size: 14px;"> <?php echo $_SESSION['errorMessages']['mot_de_passe']; ?> </span>
      <?php endif; ?>
      <br><br>

      <!-- Champ de confirmation du mot de passe -->
      <label for="confirmation_mot_de_passe"> Confirmation du mot de passe <span class="star">*</span> </label>
      <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe"
        placeholder="Veuillez entrer à nouveau votre mot de passe" required>
      <br><br>

      <!-- Bouton de soumission du formulaire -->
      <input type="submit" name="inscription" value="Créer un compte">
      <br><br>

      <!-- Lien pour se connecter si l'utilisateur a déjà un compte -->
      Vous avez déjà un compte ?
      <a href="formulaire-connexion.php" class="connectez-vous"> Se connecter </a>
    </form>
  </div>

  <!-- Pied de page avec des liens vers les différentes pages du site -->
  <footer class="lien-page-footer">
    <div class="nav-links-1">
      <div class="social-link">
        <!-- Liens vers les réseaux sociaux et PayPal -->
        <a class="logo-footer" href="https://www.instagram.com/melanievoyante/" target="_blank">
          <img src="./images/instagram.png" alt="Logo Instagram">
          <!-- <i class="fab fa-instagram fa-2x instagram-logo"> </i> -->
          <span class="insta-paypal-mail"> Suivez-moi sur Instagram </span>
        </a>
      </div>
      <div class="social-link">
        <a class="logo-footer" href="https://www.paypal.me/maupin20" target="_blank">
          <img src="./images/paypal.png" alt="Logo Paypal">
          <!-- <i class="fa-brands fa-paypal fa-2xl paypal-logo"> </i> -->
          <span class="insta-paypal-mail"> PayPal </span>
        </a>
      </div>

      <!-- Lien mailto pour contacter par email -->
      <div class="social-link">
        <a class="logo-footer " href="mailto:les-predictions-de-melanie@outlook.com" target="_blank">
          <img src="./images/gmail.png" alt="Logo Gmail">
          <!-- <i class="fa-regular fa-envelope fa-2xl gmail-logo"></i> -->
          <span class="insta-paypal-mail"> Contactez-moi par mail </span>
        </a>
      </div>
    </div>

    <div class="nav-links-2">
      <ul>
        <li><a href="accueil.php"> Accueil </a></li>
        <li><a href="formulaire-inscription.php"> Inscription </a></li>
        <li><a href="formulaire-connexion.php"> Connexion </a></li>
      </ul>

      <ul>
        <li><a href="definition-voyance.html"> Définition voyance </a></li>
        <li><a href="definition-cartomancie.html"> Définition cartomancie </a></li>
        <li><a href="definition-ressenti-photo.html"> Définition ressenti photo </a></li>
      </ul>

      <ul>
        <li><a href="pratique-voyance.html"> Pratique voyance </a></li>
        <li><a href="pratique-cartomancie.html"> Pratique cartomancie </a></li>
        <li><a href="pratique-ressenti-photo.html"> Pratique ressenti photo </a></li>
      </ul>

      <ul>
        <li><a href="formulaire-avis.php"> Avis clients </a></li>
        <li><a href="formulaire-contact.php"> Contact </a></li>
        <li><a href="formulaire-horoscope.php"> Horoscope </a></li>
      </ul>
    </div>

    <div class="copyright-info">
      <p> © 2024 Les Prédictions de Mélanie. Tous droits réservés </p>
      <a href="mentions-legales.html"> Mentions Légales </a>
    </div>
  </footer>

  <?php
    if (isset($_SESSION['errorMessages'])) {
        unset($_SESSION['errorMessages']);
    }
    if (isset($_SESSION['form_data'])) {
      unset($_SESSION['form_data']);
    }
  ?>
</body>

</html>