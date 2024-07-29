<?php
  require 'config.php';

  // Créer une connexion à la base de données
  $conn = openConnection();

  // Récupérer les avis depuis la base de données
  $avis_query = "SELECT rating, nom, prenom, avis FROM avis_clients ORDER BY date_envoi DESC";
  $result = $conn->query($avis_query);

  // Fermer la connexion
  $conn->close();
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
  <link rel="stylesheet" href="./style/avis.css">

  <!-- Favicon pour le site, affiché dans l'onglet du navigateur -->
  <link rel="shortcut icon" href="./images/favicon-1.ico" type="image/x-icon">

  <!-- Lien vers les icônes Font Awesome pour utiliser des icônes vectorielles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Titre de la page (max 60 caractères) affiché dans l'onglet du navigateur -->
  <title> Avis Clients </title>

  <!-- Meta description de la page (max 160 caractères) pour les moteurs de recherche -->
  <meta name="description"
    content="Découvrez les avis et témoignages de nos clients après leurs consultations de voyance et cartomancie. Lisez les retours d'expérience et partagez votre propre avis pour aider les autres à trouver la guidance dont ils ont besoin.">
</head>

<body>
  <header>
    <!-- Image de l'en-tête avec un logo ou une photo, représentative du site -->
    <img class="photo-header" src="./images/melanie-voyante-2.jpg" alt="Logo de Mélanie Voyante">

    <!-- Navigation principale -->
    <nav class="lien-page-header">

      <!-- Logo maison accueil -->
      <div class="lien-home">
        <img class="back-home" src="./images/maison-accueil.png" alt="Retour à la page d'accueil"
          onclick="window.location.href='accueil.php'">
        <span class="home"> Accueil </span>
      </div>

      <div class="navbar">
        <!-- Menu déroulant pour Accueil -->
        <div class="dropdown">
          <div class="accueil">
            <button class="dropbtn">
              Accueil
              <i class="fa fa-caret-down"> </i>
            </button>
          </div>
          <div class="dropdown-content">
            <a href="formulaire-inscription.php"> Inscription </a>
            <a href="formulaire-connexion.php"> Connexion </a>
          </div>
        </div>

        <!-- Menu déroulant pour Voyance -->
        <div class="dropdown">
          <button class="dropbtn">
            Voyance
            <i class="fa fa-caret-down"> </i>
          </button>
          <div class="dropdown-content">
            <a href="definition-voyance.html"> Définition </a>
            <a href="pratique-voyance.html"> Pratique </a>
          </div>
        </div>

        <!-- Menu déroulant pour Cartomancie -->
        <div class="dropdown">
          <button class="dropbtn">
            Cartomancie
            <i class="fa fa-caret-down"> </i>
          </button>
          <div class="dropdown-content">
            <a href="definition-cartomancie.html"> Définition </a>
            <a href="pratique-cartomancie.html"> Pratique </a>
          </div>
        </div>

        <!-- Menu déroulant pour Ressenti photo -->
        <div class="dropdown">
          <button class="dropbtn">
            Ressenti photo
            <i class="fa fa-caret-down"> </i>
          </button>
          <div class="dropdown-content">
            <a href="definition-ressenti-photo.html"> Définition </a>
            <a href="pratique-ressenti-photo.html"> Pratique </a>
          </div>
        </div>
      </div>

      <!-- Liens directs pour Contact, Avis clients et Horoscope -->
      <div class="tarif-contact-avis-blog">
        <a href="tarif.html"> Tarif </a>
        <a href="formulaire-contact.php"> Contact </a>
        <a href="formulaire-avis.php"> Avis clients </a>
        <a href="formulaire-horoscope.php"> Horoscope </a>
      </div>

      <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Icône de déconnexion avec un lien vers la page de déconnexion -->
      <div class="lien-deconnect">
        <img class="icone-connect" src="./images/deconnexion.png" alt="Aller à la page accueil"
          onclick="window.location.href='deconnexion.php'">
        <span class="deconnect"> Déconnexion </span>
      </div>
      <?php else: ?>
      <!-- Icône de connexion avec un lien vers la page de connexion -->
      <div class="lien-connect">
        <img class="icone-connect" src="./images/connexion.png" alt="Aller à la page de connexion"
          onclick="window.location.href='formulaire-connexion.php'">
        <span class="connect"> Connexion </span>
      <?php endif; ?>
      </div>

    </nav>
  </header>

  <!-- Contenu principal de la page -->
  <div class="container">
    <!-- Formulaire pour laisser un avis -->
    <form id="avis-form" action="./avis.php" method="POST">
      <?php if (isset($_SESSION['successMessages']['avis'])): ?>
      <span style="display: block; margin: 20px auto; padding: 10px; width: fit-content; border: 2px solid #4CAF50; background: #D4EDDA; color: #155724; border-radius: 5px; text-align: center; font-size: 16px;"> <?php echo $_SESSION['successMessages']['avis']; ?> </span>
      <?php endif; ?>

      <?php if (isset($_SESSION['errorMessages']['avis'])): ?>
      <span style="display: block; margin: 20px auto; padding: 10px; width: fit-content; border: 2px solid #C62828; background: #FFEBEE; color: #C62828; border-radius: 5px; text-align: center; font-size: 16px;"> <?php echo $_SESSION['errorMessages']['avis']; ?> </span>
      <?php endif; ?>

      <h1> Donnez votre avis </h1>

      <!-- Système de notation avec des étoiles -->
      <div class="rating">
        <div class="rating-star-1">
          <input type="radio" id="star1" name="rating" value="1" required>
          <label for="star1"> ☆ </label>
          <span class="rating-star"> 1 étoile </span>
        </div>

        <div class="rating-star-2">
          <input type="radio" id="star2" name="rating" value="2">
          <label for="star2"> ☆ </label>
          <span class="rating-star"> 2 étoiles </span>
        </div>

        <div class="rating-star-3">
          <input type="radio" id="star3" name="rating" value="3">
          <label for="star3"> ☆ </label>
          <span class="rating-star"> 3 étoiles </span>
        </div>

        <div class="rating-star-4">
          <input type="radio" id="star4" name="rating" value="4">
          <label for="star4"> ☆ </label>
          <span class="rating-star"> 4 étoiles </span>
        </div>

        <div class="rating-star-5">
          <input type="radio" id="star5" name="rating" value="5">
          <label for="star5"> ☆ </label>
          <span class="rating-star"> 5 étoiles </span>
        </div>
      </div>

      <!-- Champ pour entrer le nom -->
      <label for="nom"> Nom <span class="star">*</span> </label>
      <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?php echo isset($_SESSION['form_data']['nom']) ? htmlspecialchars($_SESSION['form_data']['nom']) : ''; ?>" required>

      <!-- Champ pour entrer le prénom -->
      <label for="prenom"> Prénom <span class="star">*</span> </label>
      <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" value="<?php echo isset($_SESSION['form_data']['prenom']) ? htmlspecialchars($_SESSION['form_data']['prenom']) : ''; ?>" required>

      <!-- Champ de saisie pour l'email -->
      <label for="email"> E-mail <span class="star">*</span> </label>
      <input type="email" id="email" name="email" placeholder="votre.email@exemple.com" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" required>
      <?php if (isset($_SESSION['errorMessages']['email'])): ?>
      <span style="color: red; font-size: 14px;"> <?php echo $_SESSION['errorMessages']['email']; ?> </span>
      <?php endif; ?>

      <!-- Zone de texte pour écrire l'avis -->
      <label for="avis"> Votre avis <span class="star">*</span> </label>
      <textarea id="avis" name="avis" rows="4" placeholder="Écrivez votre avis ici..." required></textarea>

      <!-- Bouton pour soumettre le formulaire -->
      <button type="submit" class="submit"> Envoyer </button>
    </form>
  </div>

  <!-- Affichage des avis -->
  <div class="avis-container">
    <h2> Avis des clients </h2>
    <?php if ($result->num_rows > 0): ?>
      <?php $avis_count = 0; ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <?php $avis_count++; ?>
          <div class="avis-item <?php echo $avis_count > 5 ? 'hidden' : ''; ?>">
          <div class="rating-stars">
            <?php for ($i = 0; $i < $row['rating']; $i++): ?>
              <i class="fas fa-star"></i>
            <?php endfor; ?>
            <?php for ($i = $row['rating']; $i < 5; $i++): ?>
              <i class="far fa-star"></i>
            <?php endfor; ?>
          </div>
          <div class="avis-name">
            <br>
            <p><?php echo htmlspecialchars($row['prenom']); ?> <?php echo htmlspecialchars($row['nom']); ?></p>
          </div>
          <br>
          <p><?php echo htmlspecialchars($row['avis']); ?></p>
        </div>
      <?php endwhile; ?>
      <div class="voir-plus-container">
        <button id="voir-plus">Voir plus</button>
      </div>
    <?php else: ?>
      <h6> Il n'y a pas encore d'avis </h6>
    <?php endif; ?>
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
        <li>
          <a href="definition-cartomancie.html"> Définition cartomancie </a>
        </li>
        <li>
          <a href="definition-ressenti-photo.html">
            Définition ressenti photo
          </a>
        </li>
      </ul>

      <ul>
        <li><a href="pratique-voyance.html"> Pratique voyance </a></li>
        <li>
          <a href="pratique-cartomancie.html"> Pratique cartomancie </a>
        </li>
        <li>
          <a href="pratique-ressenti-photo.html"> Pratique ressenti photo </a>
        </li>
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

  <script src="./script/avis.js"></script>

  <?php
    if (isset($_SESSION['errorMessages'])) {
        unset($_SESSION['errorMessages']);
    }
    if (isset($_SESSION['successMessages'])) {
      unset($_SESSION['successMessages']);
    }
    if (isset($_SESSION['form_data'])) {
      unset($_SESSION['form_data']);
    }
  ?>
</body>

</html>