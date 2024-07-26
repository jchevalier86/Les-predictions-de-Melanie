<?php
  require 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- La balise meta charset spécifie le jeu de caractères utilisé. Utiliser UTF-8 est recommandé pour une compatibilité maximale -->
  <meta charset="UTF-8" />

  <!-- La balise meta viewport contrôle la mise en page sur les appareils mobiles et est essentielle pour un design responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Liens vers les feuilles de style CSS -->
  <link rel="stylesheet" href="./style/reset.css" />
  <link rel="stylesheet" href="./style/style.css" />
  <link rel="stylesheet" href="./style/definitions-pratiques.css" />

  <!-- Favicon pour le site -->
  <link rel="shortcut icon" href="./images/favicon-3.ico" type="image/x-icon" />

  <!-- Lien vers les icônes Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- Titre de la page (max 60 caractères) -->
  <title>Définition de la Cartomancie</title>

  <!-- Meta description de la page (max 160 caractères) -->
  <meta name="description"
    content="Découvrez la définition de la cartomancie, une pratique divinatoire utilisant les cartes pour révéler des informations cachées et prédire des événements futurs. Apprenez comment les cartomanciens interprètent les cartes pour offrir des guidances précises et profondes." />
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
          onclick="window.location.href='accueil.php'" />
        <span class="home"> Accueil </span>
      </div>

      <div class="navbar">
        <!-- Menu déroulant pour Accueil -->
        <div class="dropdown">
          <div class="accueil">
            <button class="dropbtn"> Accueil
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
          <button class="dropbtn"> Voyance
            <i class="fa fa-caret-down"> </i>
          </button>
          <div class="dropdown-content">
            <a href="definition-voyance.php"> Définition </a>
            <a href="pratique-voyance.php"> Pratique </a>
          </div>
        </div>

        <!-- Menu déroulant pour Cartomancie -->
        <div class="dropdown">
          <button class="dropbtn"> Cartomancie
            <i class="fa fa-caret-down"> </i>
          </button>
          <div class="dropdown-content">
            <a href="definition-cartomancie.php"> Définition </a>
            <a href="pratique-cartomancie.php"> Pratique </a>
          </div>
        </div>

        <!-- Menu déroulant pour Ressenti photo -->
        <div class="dropdown">
          <button class="dropbtn"> Ressenti photo
            <i class="fa fa-caret-down"> </i>
          </button>
          <div class="dropdown-content">
            <a href="definition-ressenti-photo.php"> Définition </a>
            <a href="pratique-ressenti-photo.php"> Pratique </a>
          </div>
        </div>
      </div>

      <!-- Liens directs pour Contact, Avis clients et Horoscope -->
      <div class="tarif-contact-avis-blog">
        <a href="tarif.php"> Tarif </a>
        <a href="formulaire-contact.php"> Contact </a>
        <a href="formulaire-avis.php"> Avis clients </a>
        <a href="horoscope.php"> Horoscope </a>
      </div>

      <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Icône de déconnexion avec un lien vers la page de déconnexion -->
      <div class="lien-deconnect">
        <img class="icone-connect" src="./images/deconnexion.png" alt="Aller à la page accueil"
          onclick="window.location.href='deconnexion.php'" />
        <span class="deconnect"> Déconnexion </span>
      </div>
      <?php else: ?>
      <!-- Icône de connexion avec un lien vers la page de connexion -->
      <div class="lien-connect">
        <img class="icone-connect" src="./images/connexion.png" alt="Aller à la page de connexion"
          onclick="window.location.href='formulaire-connexion.php'" />
        <span class="connect"> Connexion </span>
      <?php endif; ?>
      </div>

      <div class="circle-1-2">
        <div class="circle-1-pink">
          <div class="circle-1"></div>
          <span class="circle-pink"> Rose </span>
        </div>
        <div class="circle-2-blue">
          <div class="circle-2"></div>
          <span class="circle-blue"> Bleu </span>
        </div>
      </div>
    </nav>
  </header>

  <!-- Section d'introduction -->
  <section class="intro">
    <h1>La Cartomancie</h1>
    <hr class="separator">
    <h2>Définition</h2>

    <!-- Section de définition -->
    <section class="section-presentation">
      <div class="section1-col1">
        <!-- Texte de définition de la Voyance -->
        <div class="presentation">
          <div class="presentation-text-content">
            <p>
              <span class="costum-word">La cartomancie</span> est une pratique divinatoire qui consiste à
              utiliser des cartes pour prédire l’avenir ou obtenir des conseils sur des questions
              personnelles. Elle peut impliquer divers types de cartes, notamment les cartes à jouer
              classiques, les tarots ou d’autres jeux de cartes spécialement conçus pour la divination.
              <span class="costum-word">La cartomancie</span> repose sur l’interprétation des cartes
              tirées selon des méthodes spécifiques, souvent influencées par la positions des cartes, leur
              signification individuelles et leurs relations les unes avec les autres. <span class="costum-word">Les
                cartomanciens</span>, ou <span class="costum-word">praticiens de la cartomancie</span>, utilisent leurs
              connaissances des significations traditionnelles
              des cartes ainsi que leur intuition pour fournir des lectures et des interprétations aux personnes qui les
              consultent.
            </p>
          </div>
        </div>


        <!-- Photo dans la section de définition cartomancie -->
        <div class="photo">
          <img class="photo-body-2" src="./images/cartomancienne.jpg" alt="Image de cartes Oracle Gé">
        </div>
      </div>
    </section>

    <!-- Pied de page avec des liens vers les différentes pages du site -->
    <footer class="lien-page-footer">
      <div class="nav-links-1">
        <div class="social-link">
          <!-- Liens vers les réseaux sociaux et PayPal -->
          <a class="logo-footer" href="https://www.instagram.com/melanievoyante/" target="_blank">
            <img src="./images/instagram.png">
            <!-- <i class="fab fa-instagram fa-2x instagram-logo"> </i> -->
            <span class="insta-paypal-mail"> Suivez-moi sur Instagram </span>
          </a>
        </div>
        <div class="social-link">
          <a class="logo-footer" href="https://www.paypal.me/maupin20" target="_blank">
            <img src="./images/paypal.png">
            <!-- <i class="fa-brands fa-paypal fa-2xl paypal-logo"> </i> -->
            <span class="insta-paypal-mail"> PayPal </span>
          </a>
        </div>

        <!-- Lien mailto pour contacter par email -->
        <div class="social-link">
          <a class="logo-footer " href="mailto:les-predictions-de-melanie@outlook.com" target="_blank">
            <img src="./images/gmail.png">
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
          <li><a href="definition-voyance.php"> Définition voyance </a></li>
          <li>
            <a href="definition-cartomancie.php"> Définition cartomancie </a>
          </li>
          <li>
            <a href="definition-ressenti-photo.php">
              Définition ressenti photo
            </a>
          </li>
        </ul>

        <ul>
          <li><a href="pratique-voyance.php"> Pratique voyance </a></li>
          <li>
            <a href="pratique-cartomancie.php"> Pratique cartomancie </a>
          </li>
          <li>
            <a href="pratique-ressenti-photo.php"> Pratique ressenti photo </a>
          </li>
        </ul>

        <ul>
          <li><a href="formulaire-avis.php"> Avis clients </a></li>
          <li><a href="formulaire-contact.php"> Contact </a></li>
          <li><a href="horoscope.php"> Horoscope </a></li>
        </ul>
      </div>

      <div class="copyright-info">
        <p> © 2024 Les Prédictions de Mélanie. Tous droits réservés </p>
        <a href="mentions-legales.php"> Mentions Légales </a>
      </div>
    </footer>

    <script src="./script/script.js"></script>
    <script src="./script/script2.js"></script>
</body>

</html>