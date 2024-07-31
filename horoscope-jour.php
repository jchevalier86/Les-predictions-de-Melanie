<?php
  require 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- La balise meta charset spécifie le jeu de caractères utilisé. Utiliser UTF-8 est recommandé pour une compatibilité maximale -->
  <meta charset="UTF-8">

  <!-- La balise meta viewport contrôle la mise en page sur les appareils mobiles et est essentielle pour un design responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Liens vers les feuilles de style CSS -->
  <link rel="stylesheet" href="./style/reset.css">
  <link rel="stylesheet" href="./style/style.css">
  <link rel="stylesheet" href="./style/horoscope-jour-hebdo.css">

  <!-- Favicon pour le site -->
  <link rel="shortcut icon" href="./images/favicon-6.ico" type="image/x-icon">

  <!-- Lien vers les icônes Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Titre de la page (max 60 caractères) -->
  <title> Horoscope du jour </title>

  <!-- Meta description de la page (max 160 caractères) -->
  <meta name="description"
    content="Découvrez votre horoscope du jour personnalisé et obtenez des prédictions précises pour chaque signe astrologique.">
</head>

<body>
  <header>
    <!-- Image de l'en-tête avec un logo ou une photo -->
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

  <div class="body-image">
    <?php
      // Récupération des données avec cURL
      $url = "https://kayoo123.github.io/astroo-api/jour.json";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);

      // Vérifiez si la réponse a été correctement récupérée
      if ($response === false) {
        echo "Erreur lors de la récupération des données de l'API.";
        exit();
      }

      // Décoder la réponse JSON en tableau associatif
      $horoscopes = json_decode($response, true);

      // Vérifiez si le JSON a été correctement décodé
      if ($horoscopes === null) {
        echo "Erreur lors du décodage des données JSON.";
        exit();
      }

      // Utilisation d'une date dans l'API
      $date = isset($horoscopes['date']) ? $horoscopes['date'] : null;

      if ($date) {
          $dateObj = new DateTime($date);
          $dateFormatee = $dateObj->format('d/m/Y');
      } else {
          $dateFormatee = "Date non disponible";
      }

      echo "<h1> Horoscope du $dateFormatee </h1>";

      // Afficher les horoscopes pour chaque signe
      foreach ($horoscopes as $signe => $description) {
         // Nettoyer le mot "Date" du signe
        $signe = preg_replace('/Date\s*/i', '', $signe);
        $signe = trim($signe); // Enlever les espaces éventuels au début ou à la fin

        // Nettoyer la date et le mot "Date" de la description
        $description = preg_replace('/\d{4}-\d{2}-\d{2}/', '', $description);
        $description = preg_replace('/Date\s*/i', '', $description);
        $description = trim($description);

        // Vérifiez si $description est une chaîne de caractères
        if (is_string($description)) {
          // Enlever la date de la description
          $description = preg_replace('/\d{4}-\d{2}-\d{2}/', '', $description);
          $description = trim($description);

          echo "<div class='horoscope'>";
          echo "<div class='signe'>";
          echo "<h2> $signe </h2>";
          echo "</div>";
          echo "<div class='description-jour'>";
          echo "<br>";
          echo "<p> $description </p>";
          echo "</div>";
          echo "</div>";
        } else {
            echo "<p>Aucune description disponible pour $signe.</p>";
        }
      }
    ?>
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

</body>

</html>