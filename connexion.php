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
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Vérification que les champs de formulaire sont définis
    if (isset($_POST['email'], $_POST['mot_de_passe'])) {
        // Récupération et stockage des valeurs du formulaire dans des variables
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Préparation de la requête SQL de sélection
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Liaison des paramètres de la requête préparée aux variables
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows >= 1) {
                // Récupération des données utilisateur
                $user = $result->fetch_assoc();
                // Vérification du mot de passe
                if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
                    echo "Connexion réussie. Bienvenue " . $user['prenom'] . " " . $user['nom'] . "!";
                } else {
                    echo "Mot de passe incorrect.";
                }
            } else {
                echo "Aucun utilisateur trouvé avec cet e-mail.";
            }
            $stmt->close();
        } else {
            echo "Erreur de préparation de la requête : " . $conn->error;
        }
    } else {
        echo "Veuillez remplir tous les champs.";
        // Debugging
        var_dump($_POST);
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

    <!-- Liens vers les feuilles de style CSS -->
    <link rel="stylesheet" href="../style/reset.css" />
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/inscription-connexion-contact.css" />

    <!-- Favicon pour le site -->
    <link
      rel="shortcut icon"
      href="/images/favicon-5.ico"
      type="image/x-icon"
    />

    <!-- Lien vers les icônes Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />

    <!-- Titre de la page (max 60 caractères) -->
    <title>Connexion</title>

    <!-- Meta description de la page (max 160 caractères) -->
    <meta
      name="description"
      content="Connectez-vous pour accéder aux prédictions personnalisées de Mélanie, voyante et cartomancienne. Entrez votre email et mot de passe pour découvrir vos prédictions."
    />
  </head>

  <body>
    <!-- En-tête de la page -->
    <header>
      <!-- Image de l'en-tête -->
      <img
        class="photo-header"
        src="images/melanie-voyante-2.jpg"
        alt="Logo de Mélanie Voyante"
      />

      <!-- Navigation pour retourner à la page d'accueil -->
      <nav class="lien-page-inscription">
        <!-- Image de la flèche de retour -->
        <img
          class="back-arrow"
          src="images/flèche-gauche.png"
          alt="Retour à la page d'accueil"
          onclick="window.location.href='accueil.html'"
        />

        <!-- Titre de la page -->
        <h1 class="title">Les prédictions de Mélanie</h1>
      </nav>
    </header>

    <!-- Section du formulaire d'avis -->
    <div class="container">
      <form action="connexion.php" method="post">
        <h2>Connexion</h2>

        <!-- Champ pour entrer l'email -->
        <label for="email"> Email <span class="star">*</span> </label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="Entrez votre adresse email"
          required
        />
        <br /><br />

        <!-- Champ pour entrer le mot de passe -->
        <label for="password"> Mot de passe <span class="star">*</span> </label>
        <input
          type="password"
          id="mot_de_passe"
          name="mot_de_passe"
          placeholder="Entrez votre mot de passe"
          required
        />

        <!-- Lien pour mot de passe oublié -->
        <a class="forgot-your-password" href=""> Mot de passe oublié </a>
        <br /><br />

        <!-- Bouton Se connecter -->
        <button>Se connecter</button>
        <br /><br />

        <!-- Lien pour s'inscrire si c'est la première visite -->
        <p>Première visite ? <a href="inscription.html"> Inscrivez-vous </a></p>
        <br />
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

    <script src="./script/connexion.js"></script>
  </body>
</html>

<?php
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['prenom'] . " " . $user['nom'];
    // Redirection vers une page protégée
    header("Location: accueil.html");
    exit();
?>
