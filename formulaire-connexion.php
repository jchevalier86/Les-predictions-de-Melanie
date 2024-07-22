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
    <link rel="stylesheet" href="./style/inscription-connexion-contact.css" />

    <!-- Favicon pour le site -->
    <link rel="shortcut icon" href="./images/favicon-5.ico" type="image/x-icon" />

    <!-- Lien vers les icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Titre de la page (max 60 caractères) -->
    <title> Connexion </title>

    <!-- Meta description de la page (max 160 caractères) -->
    <meta name="description"
        content="Connectez-vous pour accéder aux prédictions personnalisées de Mélanie, voyante et cartomancienne. Entrez votre email et mot de passe pour découvrir vos prédictions." />
</head>

<body>
    <!-- En-tête de la page -->
    <header>
        <!-- Image de l'en-tête -->
        <img class="photo-header" src="./images/melanie-voyante-2.jpg" alt="Logo de Mélanie Voyante" />

        <!-- Navigation pour retourner à la page d'accueil -->
        <nav class="lien-page-inscription">

            <!-- Logo maison accueil -->
            <div class="lien-home">
                <img class="back-home" src="./images/maison-accueil.png" alt="Retour à la page d'accueil"
                    onclick="window.location.href='accueil.html'" />
                <span class="home"> Accueil </span>
            </div>

            <!-- Titre de la page -->
            <h1 class="title">Les prédictions de Mélanie</h1>
        </nav>
    </header>

    <!-- Section du formulaire d'avis -->
    <div class="container-2">
        <?php
        session_start();
        ?>

        <form action="./connexion.php" method="POST">
            <h2>Connexion</h2>

            <!-- Champ pour entrer l'email -->
            <label for="email"> Email <span class="star">*</span> </label>
            <input type="email" id="email" name="email" placeholder="Entrez votre adresse email" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" required />
            <?php if (isset($_SESSION['errorMessages']['email'])): ?>
            <span style="color: red; font-size: 14px;"> <?php echo $_SESSION['errorMessages']['email']; ?> </span>
            <?php endif; ?>
            <br /><br />

            <!-- Champ pour entrer le mot de passe -->
            <label for="password"> Mot de passe <span class="star">*</span> </label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez votre mot de passe" required />
            <?php if (isset($_SESSION['errorMessages']['mot_de_passe'])): ?>
            <span style="color: red; font-size: 14px;"> <?php echo $_SESSION['errorMessages']['mot_de_passe']; ?> </span>
            <?php endif; ?>
            <br /><br />
            <!-- Lien pour mot de passe oublié -->
            <a class="forgot-your-password" href="./mot-de-passe-perdu.php"> Mot de passe oublié </a>
            <br /><br />

            <!-- Input Se connecter -->
            <input type="submit" name="connexion" value="Se connecter" />
            <br /><br />

            <!-- Lien pour s'inscrire si c'est la première visite -->
            <p>Première visite ? <a href="formulaire-inscription.php"> Inscrivez-vous </a></p>
            <br />
        </form>
    </div>

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
                <li><a href="accueil.html"> Accueil </a></li>
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
                <li><a href="avis.html"> Avis clients </a></li>
                <li><a href="contact.html"> Contact </a></li>
                <li><a href="horoscope.html"> Horoscope </a></li>
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