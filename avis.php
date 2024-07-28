<?php
    // Inclusion des configurations et fonctions communes
    require 'config.php';

    // Inclure PHPMailer
    require './libs/PHPMailer/src/PHPMailer.php';
    require './libs/PHPMailer/src/SMTP.php';
    require './libs/PHPMailer/src/Exception.php';

    // Inclure la librairie phpdotenv
    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use Dotenv\Dotenv;

    // Charger les variables d'environnement depuis le fichier .env
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Créer une connexion à la base de données
    $conn = openConnection();

    // Vérification de la connexion à la base de données
    if ($conn->connect_error) {
        error_log("Erreur de connexion à la base de données : " . $conn->connect_error);
        echo "<div style='color:red;'>Une erreur est survenue. Veuillez réessayer plus tard.</div>";
        exit();
    }

    // Vérification que l'utilisateur est connecté
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $_SESSION['errorMessages']['avis'] = "Vous devez être connecté pour envoyer un avis.";
        header("Location: formulaire-avis.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Récupération des données du formulaire
    $rating = $_POST['rating'];
    $review = $_POST['avis'];
    $status = $_POST['status'];

    // Préparation et exécution de la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO avis (rating, review, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $rating, $review, $status);
    $stmt->execute();

    // Envoi d'un email à la propriétaire du site
    $to = 'les-predictions-de-melanie@outlook.com';
    $subject = 'Nouveau avis en attente de validation';
    $message = "Un nouvel avis a été soumis et attend votre validation :\n\n" .
            "Note : $rating étoiles\n" .
            "Avis : $review\n\n" .
            "Connectez-vous à l'administration pour le valider.";
    $headers = 'From: noreply@example.com' . "\r\n" .
            'Reply-To: noreply@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();

    // Redirection ou message de succès
    header('Location: formulaire-avis.php');
    exit();
?>
