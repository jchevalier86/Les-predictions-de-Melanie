<?php
    // Démarrer la session au début du fichier
    session_start();

    // Inclure PHPMailer
    require './libs/PHPMailer/src/PHPMailer.php';
    require './libs/PHPMailer/src/SMTP.php';
    require './libs/PHPMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Générer un token CSRF s'il n'existe pas
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);

    // Définition des informations de connexion au serveur MySQL
    $servername = "localhost"; // Nom du serveur
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "lespredictionsdemelanie"; // Nom de la base de données

    // Création d'une nouvelle connexion à la base de données MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion à la base de données
    if ($conn->connect_error) {
        error_log("Erreur de connexion à la base de données : " . $conn->connect_error);
        echo "<div style='color:red;'>Une erreur est survenue. Veuillez réessayer plus tard.</div>";
        exit();
    }

    // Vérification que l'utilisateur est connecté
    // if (!isset($_SESSION['utilisateur_id'])) {
    //     echo '<script>
    //     alert("Vous devez être connecté pour envoyer un message.");
    //     window.location.href = "formulaire-connexion.php";
    //     </script>';
    //     exit();
    // }

    // Vérification que tous les champs de formulaire nécessaires sont définis
    if (isset($_POST['sujet'], $_POST['domaine'], $_POST['date_envoi'], $_POST['paiement'], $_POST['message_envoi'], $_POST['csrf_token'])) {
        // Vérification du token CSRF
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            echo "<div style='color:red;'>Token CSRF invalide.</div>";
            exit();
        }

        // Affichage des valeurs pour le débogage
        echo "Sujet: " . htmlspecialchars($_POST['sujet']) . "<br>";
        echo "Domaine: " . htmlspecialchars($_POST['domaine']) . "<br>";
        echo "Date d'envoi: " . htmlspecialchars($_POST['date_envoi']) . "<br>";
        echo "Paiement: " . htmlspecialchars($_POST['paiement']) . "<br>";
        echo "Message: " . htmlspecialchars($_POST['message_envoi']) . "<br>";
        echo "CSRF Token: " . htmlspecialchars($_POST['csrf_token']) . "<br>";

        // Assainir les entrées utilisateur
        $contact_sujet = htmlspecialchars($_POST['sujet']);
        $contact_domaine = htmlspecialchars($_POST['domaine']);
        $contact_date_envoi = htmlspecialchars($_POST['date_envoi']);
        $contact_paiement = htmlspecialchars($_POST['paiement']);
        $contact_message_envoi = htmlspecialchars($_POST['message_envoi']);

        // Vérifier si les valeurs des ENUM sont valides
        $valid_sujets = ["question", "tirage", "ressenti_photo", "personnalite", "information"];
        $valid_domaines = ["avenir", "tirage_general", "grossesse", "demenagement", "amour", "travail", "permis", "argent", "general", "autres"];
        $valid_paiements = ["paypal", "virement"];

        $errorMessages = [];
        if (!in_array($contact_sujet, $valid_sujets)) {
            $errorMessages['sujet'] = "* Sujet non choisi.";
        }
        if (!in_array($contact_domaine, $valid_domaines)) {
            $errorMessages['domaine'] = "* Domaine non choisi.";
        }
        if (!in_array($contact_paiement, $valid_paiements)) {
            $errorMessages['paiement'] = "* Type de paiement non choisi.";
        }

        if (!empty($errorMessages)) {
            $_SESSION['errorMessages'] = $errorMessages;
            header("Location: formulaire-contact.php");
            exit();
        }

        // Préparation de la requête SQL d'insertion
        $sql = "INSERT INTO contact (utilisateur_id, sujet, domaine, date_envoi, paiement, message_envoi) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // L'utilisateur_id est stocké dans la session
            $utilisateur_id = $_SESSION['utilisateur_id'];

            $stmt->bind_param("isssss", $utilisateur_id, $contact_sujet, $contact_domaine, $contact_date_envoi, $contact_paiement, $contact_message_envoi);
            if ($stmt->execute()) {
                // Préparer l'email après avoir inséré les données
                try {
                    // Paramètres du serveur SMTP
                    $mail->isSMTP();
                    $mail->Host = getenv('SMTP_HOST'); // Utilisez les variables d'environnement
                    $mail->SMTPAuth = true;
                    $mail->Username = getenv('SMTP_USERNAME');
                    $mail->Password = getenv('SMTP_PASSWORD');
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Destinataires
                    $mail->setFrom('noreply@lespredictionsdemelanie.com', 'Les Prédictions de Mélanie');
                    $mail->addAddress('les-predictions-de-melanie@outlook.com', 'Propriétaire du Site');

                    // Contenu de l'email
                    $mail->isHTML(true);
                    $mail->Subject = "Nouveau message de " . htmlspecialchars($utilisateur_id);
                    $mail->Body    = "Vous avez reçu un nouveau message de contact.<br><br>
                                    <strong>Nom:</strong> " . htmlspecialchars($utilisateur_id) . "<br>
                                    <strong>Sujet:</strong> " . htmlspecialchars($contact_sujet) . "<br>
                                    <strong>Domaine:</strong> " . htmlspecialchars($contact_domaine) . "<br>
                                    <strong>Date d'envoi:</strong> " . htmlspecialchars($contact_date_envoi) . "<br>
                                    <strong>Type de paiement:</strong> " . htmlspecialchars($contact_paiement) . "<br>
                                    <strong>Message:</strong><br>" . nl2br(htmlspecialchars($contact_message_envoi));
                    $mail->AltBody = "Vous avez reçu un nouveau message de contact.\n\n
                                    Nom: " . htmlspecialchars($utilisateur_id) . "\n
                                    Sujet: " . htmlspecialchars($contact_sujet) . "\n
                                    Domaine: " . htmlspecialchars($contact_domaine) . "\n
                                    Date d'envoi: " . htmlspecialchars($contact_date_envoi) . "\n
                                    Type de paiement: " . htmlspecialchars($contact_paiement) . "\n
                                    Message:\n" . htmlspecialchars($contact_message_envoi);

                    $mail->send();
                    echo '<script>
                        alert("Votre message a été envoyé avec succès.");
                        window.location.href = "formulaire-contact.php";
                        </script>';
                } catch (Exception $e) {
                    echo 'Le message n\'a pas pu être envoyé. Erreur de messagerie: ' . htmlspecialchars($mail->ErrorInfo);
                }

                $stmt->close();
            } else {
                echo "<div style='color:red;'>Erreur lors de l'insertion des données : " . htmlspecialchars($stmt->error) . "</div>";
            }
        } else {
            echo "<div style='color:red;'>Erreur de préparation de la requête : " . htmlspecialchars($conn->error) . "</div>";
        }
    } else {
        echo '<script>
            alert("Tous les champs ne sont pas remplis.");
            window.location.href = "formulaire-contact.php";
            </script>';
    }

    $conn->close();
?>
