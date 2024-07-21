
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
        <title> Réinitialiser le mot de passe </title>

        <!-- Meta description de la page (max 160 caractères) -->
        <meta name="description" content="" />
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
                <img class="back-home" src="./images/maison-accueil.png" alt="Retour à la page d'accueil" onclick="window.location.href='accueil.html'" />
                <span class="home"> Accueil </span>
            </div>

            <!-- Titre de la page -->
            <h1 class="title">Les prédictions de Mélanie</h1>
        </nav>
    </header>

<?php
    require 'index.php'; // Inclure le fichier de connexion

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['token'];
        $newPassword = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);

        $conn = openConnection(); // Ouvrir la connexion

        // Rechercher le jeton dans la base de données
        $stmt = $conn->prepare("SELECT utilisateur_id FROM password_resets WHERE token = ?");
        if ($stmt) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $resetRequest = $result->fetch_assoc();

            if ($resetRequest) {
                // Mettre à jour le mot de passe de l'utilisateur
                $stmt = $conn->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $newPassword, $resetRequest['utilisateur_id']);
                    $stmt->execute();

                    // Supprimer le jeton après utilisation
                    $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                    if ($stmt) {
                        $stmt->bind_param("s", $token);
                        $stmt->execute();
                        echo "<div style='color:blue;'>Votre mot de passe a été réinitialisé avec succès.</div>";
                        echo "<script>setTimeout(function() { window.location.href = './connexion.html'; }, 3000);</script>";
                        exit();
                    } else {
                        echo "Erreur de préparation de la requête : " . $conn->error;
                    }
                } else {
                    echo "Erreur de préparation de la requête : " . $conn->error;
                }
            } else {
                echo "<div style='color:red;'>Jeton de réinitialisation invalide.</div>";
            }
            $stmt->close();
        } else {
            echo "Erreur de préparation de la requête : " . $conn->error;
        }

        closeConnection($conn); // Fermer la connexion
    } elseif (isset($_GET['token'])) {
        $token = $_GET['token'];
        // Afficher le formulaire de réinitialisation
?>

    <!-- Section du formulaire réinitialisation du mot de passe -->
    <div class="container-2">
        <form action="reset_password.php" method="POST">
            <h2>Réinitialiser le mot de passe</h2>
            
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            
            <!-- Champ pour entrer le nouveau mot de passe -->
            <label for="password"> Nouveau mot de passe <span class="star">*</span> </label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Créer votre nouveau mot de passe" required>
            
            <!-- Champ de confirmation du mot de passe -->
            <label for="password"> Confirmation du mot de passe <span class="star">*</span> </label>
            <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" placeholder="Confirmer votre nouveau mot de passe" required />
            
            <!-- Input Réinitialisation du mot de passe -->
            <input type="submit" name="reinitialisation" value="Réinitialiser votre mot de passe" />

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
                <li><a href="inscription.html"> Inscription </a></li>
                <li><a href="connexion.html"> Connexion </a></li>
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

    <script src="./script/script.js"></script>
    <script src="./script/inscription.js"></script>
</body>

</html>

<?php
} else {
    echo "<div style='color:red;'>Aucun jeton fourni.</div>";
}
?>