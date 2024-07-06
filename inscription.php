<?php
    // Définition des informations de connexion au serveur MySQL
    $servername = "localhost"; // Nom du serveur
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "lespredictionsdemelanie"; // Nom de la base de données

    // Création d'une nouvelle connexion à la base de données MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion à la base de données
    if ($conn->connect_error) {
        // Affichage d'un message d'erreur en cas d'échec de connexion
        echo ("La connexion a échoué : " . $conn->connect_error);
    }

    // Vérification que tous les champs de formulaire nécessaires sont définis
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['email'], $_POST['phone'], $_POST['mot_de_passe'])) {
        // Récupération et stockage des valeurs du formulaire dans des variables
        $utilisateurs_nom = $_POST['nom'];
        $utilisateurs_prenom = $_POST['prenom'];
        $utilisateurs_date_naissance = $_POST['date_naissance'];
        $utilisateurs_email = $_POST['email'];
        $utilisateurs_phone = $_POST['phone'];
        // Hachage du mot de passe et de la confirmation du mot de passe pour des raisons de sécurité
        $utilisateurs_mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

        // Préparation de la requête SQL d'insertion
        $sql = "INSERT INTO utilisateurs (nom, prenom, date_naissance, email, phone, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)";

        // Préparation de la requête préparée
        $stmt = $conn->prepare($sql);

        // Vérification que la préparation de la requête a réussi
        if ($stmt) {
            // Liaison des paramètres de la requête préparée aux variables
            $stmt->bind_param("ssisis", $utilisateurs_nom, $utilisateurs_prenom, $utilisateurs_date_naissance, $utilisateurs_email, $utilisateurs_phone, $utilisateurs_mot_de_passe);
            // Exécution de la requête préparée
            if ($stmt->execute()) {
                // Affichage d'un message de succès si les données ont été insérées avec succès
                echo "Votre inscription à bien été prise en compte";
            } else {
                // Affichage d'un message d'erreur si l'insertion des données a échoué
                echo "Erreur lors de l'insertion des données : " . $stmt->error;
            }
            // Fermeture de la requête préparée
            $stmt->close();
        }
        else {
            // Affichage d'un message d'erreur si la préparation de la requête a échoué
            echo "Erreur de préparation de la requête : " . $conn->error;
        }
    } else {
        // Affichage d'un message d'erreur si tous les champs du formulaire ne sont pas remplis
        echo "Tous les champs ne sont pas remplis.";
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- La balise meta charset spécifie le jeu de caractères utilisé. Utiliser UTF-8 est recommandé pour une compatibilité maximale -->
    <meta charset="UTF-8" />

    <!-- La balise meta viewport contrôle la mise en page sur les appareils mobiles et est essentielle pour un design responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Liens vers les feuilles de style CSS pour réinitialiser les styles par défaut et appliquer les styles personnalisés -->
    <link rel="stylesheet" href="./style/reset.css" />
    <link rel="stylesheet" href="./style/style.css" />
    <link rel="stylesheet" href="./style/inscription-connexion-contact.css" />

    <!-- Favicon pour le site, affiché dans l'onglet du navigateur -->
    <link
      rel="shortcut icon"
      href="/images/favicon-7.ico"
      type="image/x-icon"
    />

    <!-- Lien vers les icônes Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />

    <!-- Titre de la page (max 60 caractères) affiché dans l'onglet du navigateur -->
    <title>Inscription</title>

    <!-- Meta description de la page (max 160 caractères) pour les moteurs de recherche -->
    <meta
      name="description"
      content="Découvrez votre avenir avec le service de voyance et cartomancie. Inscrivez-vous dès maintenant pour une consultation personnalisée. Obtenez des réponses claires et précises à vos questions grâce à mon expertise en cartomancie"
    />
  </head>

  <body>
    <header>
      <!-- Image de l'en-tête avec un logo ou une photo, représentative du site -->
      <img
        class="photo-header"
        src="images/melanie-voyante-2.jpg"
        alt="Logo de Mélanie Voyante"
      />

      <!-- Navigation pour la page d'inscription avec un lien de retour à l'accueil -->
      <nav class="lien-page-inscription">
        <img
          class="back-arrow"
          src="images/flèche-gauche.png"
          alt="Retour à la page d'accueil"
          onclick="window.location.href='accueil.html'"
        />
        <h1 class="title">Les prédictions de Mélanie</h1>
      </nav>
    </header>

    <!-- Conteneur principal pour le formulaire d'inscription -->
    <div class="container">
      <!-- Formulaire d'inscription, les données sont envoyées à "inscription.php" en utilisant la méthode POST -->
      <form action="inscription.php" method="post">
        <h2>Inscription</h2>

        <!-- Champ de saisie pour le nom -->
        <label for="nom"> Nom <span class="star">*</span> </label>
        <input
          type="text"
          id="nom"
          name="nom"
          placeholder="Votre nom"
          required
        />
        <br /><br />

        <!-- Champ de saisie pour le prénom -->
        <label for="prenom"> Prénom <span class="star">*</span> </label>
        <input
          type="text"
          id="prenom"
          name="prenom"
          placeholder="Votre prénom"
          required
        />
        <br /><br />

        <!-- Champ de saisie pour la date de naissance -->
        <label for="date_naissance">
          Date de naissance <span class="star">*</span>
        </label>
        <input type="date" id="date_naissance" name="date_naissance" required />
        <br /><br />

        <!-- Champ de saisie pour l'email -->
        <label for="email"> E-mail <span class="star">*</span> </label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="votre.email@exemple.com"
          required
        />
        <br /><br />

        <!-- Champ de saisie pour le numéro de téléphone -->
        <label for="phone"> Tel </label>
        <input
          type="tel"
          id="phone"
          pattern="[0-9]{10}"
          name="phone"
          placeholder="+33"
        />
        <br /><br />

        <!-- Champ de saisie pour le mot de passe -->
        <label for="password">
          Votre mot de passe <span class="star">*</span>
        </label>
        <input
          type="password"
          id="mot_de_passe"
          name="mot_de_passe"
          placeholder="Créer votre mot de passe"
          required
        />
        <br /><br />

        <!-- Champ de confirmation du mot de passe -->
        <label for="password">
          Confirmation du mot de passe <span class="star">*</span>
        </label>
        <input
          type="password"
          id="confirmation_mot_de_passe"
          name="confirmation_mot_de_passe"
          placeholder="Veuillez entrer à nouveau votre mot de passe"
          required
        />
        <br /><br />

        <!-- Bouton de soumission du formulaire -->
        <button>Créer un compte</button>
        <br />

        <!-- Lien pour se connecter si l'utilisateur a déjà un compte -->
        Vous avez déjà un compte ?
        <a href="connexion.html" class="connectez-vous"> Se connecter </a>
      </form>
    </div>

    <!-- Pied de page avec des liens vers les différentes pages du site -->
    <footer class="lien-page-footer">
      <div class="nav-links-1">
        <div class="social-link">
          <!-- Liens vers les réseaux sociaux et PayPal -->
          <a
            class="logo-footer"
            href="https://www.instagram.com/melanievoyante/"
            target="_blank"
          >
            <i class="fab fa-instagram fa-2x instagram-logo"> </i>
            <span class="insta-paypal-mail">Suivez-moi sur Instagram</span>
          </a>
        </div>
        <div class="social-link">
          <a
            class="logo-footer"
            href="https://www.paypal.com/fr/home"
            target="_blank"
          >
            <i class="fa-brands fa-paypal fa-2xl paypal-logo"> </i>
            <span class="insta-paypal-mail">PayPal</span>
          </a>
        </div>

        <!-- Lien mailto pour contacter par email -->
        <div class="social-link">
          <a href="mailto:melanie20082011@outlook.fr" target="_blank">
            mail: melanie20082011@outlook.fr
            <span class="insta-paypal-mail">Contactez-moi par mail</span>
          </a>
        </div>
      </div>

      <div class="nav-links-2">
        <ul>
          <li><a href="accueil.html"> Accueil </a></li>
          <li><a href="inscription.html"> Inscription </a></li>
          <li><a href="connexion.html"> Connexion </a></li>
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
    </footer>

    <script src="./script/inscription.js"></script>
  </body>
</html>