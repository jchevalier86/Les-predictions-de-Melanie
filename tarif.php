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
    <link rel="stylesheet" href="./style/tarif.css" />

    <!-- Favicon pour le site -->
    <link rel="shortcut icon" href="./images/favicon-9.ico" type="image/x-icon" />

    <!-- Lien vers les icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Titre de la page (max 60 caractères) -->
    <title> Tarif </title>

    <!-- Meta description de la page (max 160 caractères) -->
    <meta name="description"
        content="Découvrez les consultations en don libre des Prédictions de Mélanie, voyante et cartomancienne. Pas de rendez-vous, priorité aux premiers donateurs. Obtenez guidance et clairvoyance selon vos moyens." />
</head>

<body>
    <header>
        <!-- Image de l'en-tête avec un logo ou une photo -->
        <img class="photo-header" src="./images/melanie-voyante-2.jpg" alt="Logo de Mélanie Voyante" />

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
                    <button class="dropbtn" id="dropbtn" onclick="dropbtn()">
                        Voyance
                        <i class="fa fa-caret-down"> </i>
                    </button>
                    <div class="dropdown-content">
                        <a href="definition-voyance.php"> Définition </a>
                        <a href="pratique-voyance.php"> Pratique </a>
                    </div>
                </div>

                <!-- Menu déroulant pour Cartomancie -->
                <div class="dropdown">
                    <button class="dropbtn" id="dropbtn" onclick="dropbtn()">
                        Cartomancie
                        <i class="fa fa-caret-down"> </i>
                    </button>
                    <div class="dropdown-content">
                        <a href="definition-cartomancie.php"> Définition </a>
                        <a href="pratique-cartomancie.php"> Pratique </a>
                    </div>
                </div>

                <!-- Menu déroulant pour Ressenti photo -->
                <div class="dropdown">
                    <button class="dropbtn" id="dropbtn" onclick="dropbtn()">
                        Ressenti photo
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
        </nav>
    </header>

    <!-- Section Tarif -->
    <section class="intro">
        <h1>Tarif et Fonctionnement des Consultations</h1>

        <!-- Section de présentation -->
        <section class="section-presentation">
            <div class="section1-col1">
                <!-- Texte tarif -->
                <div class="presentation">
                    <p>
                        En tant que voyante et cartomancienne dévouée, je tiens à offrir mes services à tous ceux qui en
                        ont besoin, quel que soit leur budget. C'est pourquoi mes consultations sont proposées en don
                        libre.
                    </p>
                    <br />
                    <p>
                        <span class="costum-word"> Comment cela fonctionne : </span>
                    </p>

                    <ul>
                        <br />
                        <li>
                            <span class="costum-word"> Don Libre : </span> Vous êtes libre de donner ce que vous pouvez
                            et ce que vous estimez juste, pour la consultation. Chaque don, petit ou grand, est apprécié
                            et permet de continuer à offrir des services spirituels.
                        </li>
                        <br />
                        <li>
                            <span class="costum-word"> Consultations Sans Rendez-Vous : </span> Afin de rester flexible
                            et disponible pour le plus grand nombre, je ne prends pas de rendez-vous à l'avance. Les
                            consultations sont effectuées selon mes disponibilités.
                        </li>
                        <br />
                        <li>
                            <span class="costum-word"> Priorité aux Premiers Donateurs : </span> Pour garantir l'équité
                            et gérer la demande, les consultations sont accordées en priorité aux premiers qui
                            effectuent un don soit sur Paypal ou soit par Virement Bancaire. Ainsi, une fois votre don
                            effectué, vous serez placé en tête de liste
                            pour la prochaine consultation disponible.
                        </li>
                        <br />
                    </ul>

                    <h2>
                        Processus de Consultations :
                    </h2>

                    <ul>
                        <br />
                        <li>
                            <span class="costum-word"> Effectuez votre Don : </span> Utilisez le lien Paypal
                            ci-dessous pour contribuer.
                            Assurez-vous de bien indiquer vos coordonnées de contact.
                        </li>
                        <br />
                        <li>
                            <span class="costum-word"> Confirmation et Attente </span>: Vous recevrez une confirmation
                            de
                            votre don. Ensuite, en fonction
                            de la file d'attente et de mes disponibilités, je vous contacterai pour convenir du moment
                            de la consultation.
                        </li>
                        <br />
                        <li>
                            <span class="costum-word"> Consultation : </span> Une fois le moment fixé, nous procéderons
                            à
                            la consultation. Que ce soit sur mon
                            <a class="contact-paypal" href="https://www.instagram.com/melanievoyante/"
                                target="_blank">Instagram</a>, ou par
                            LiveChat que vous trouverez en bas de la page <a class="contact-paypal" href="contact.html">
                                Contact</a>, je
                            serai à votre écoute pour vous apporter
                            guidance et clairvoyance.
                        </li>
                        <br />
                    </ul>

                    <h2>
                        Pourquoi un Don Libre ?
                    </h2>

                    <br />
                    <p>
                        Je crois que l'aide spirituelle doit être accessible à tous. En permettant à chacun de donner
                        selon ses moyens, je souhaite créer un espace où l'énergie échangée est basée sur la gratitude
                        et le respect mutuel.
                    </p>
                    <br />
                    <p>
                        Merci pour votre confiance et votre générosité. Je suis impatiente de vous aider à trouver la
                        clarté et la guidance que vous recherchez.
                    </p>
                </div>
            </div>
        </section>
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
</body>

</html>