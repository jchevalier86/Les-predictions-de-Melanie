<?php
    // Définition des informations de connexion au serveur MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lespredictionsdemelanie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

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
    header('Location: avis.html');
    exit();
?>
