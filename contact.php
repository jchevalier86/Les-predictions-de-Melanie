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
        $_SESSION['errorMessages']['contact'] = "Vous devez être connecté pour envoyer un message.";
        header("Location: formulaire-contact.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Vérification que tous les champs de formulaire nécessaires sont définis
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['sujet'], $_POST['domaine'], $_POST['paiement'], $_POST['message_envoi'])) {

        // Assainir les entrées utilisateur
        $contact_nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8');
        $contact_prenom = htmlspecialchars($_POST['prenom'], ENT_QUOTES, 'UTF-8');
        $contact_email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $contact_sujet = htmlspecialchars($_POST['sujet']);
        $contact_domaine = htmlspecialchars($_POST['domaine']);
        $contact_paiement = htmlspecialchars($_POST['paiement']);
        $contact_message_envoi = htmlspecialchars($_POST['message_envoi'], ENT_QUOTES, 'UTF-8');

        // Vérifiez que l'utilisateur existe
        $check_user_query = "SELECT user_id FROM utilisateurs WHERE user_id = ?";
        $stmt = $conn->prepare($check_user_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            echo '<script>
            alert("Utilisateur non trouvé.");
            </script>';
            $stmt->close();
            $conn->close();
            exit();
        }
        $stmt->close();

        // Vérifier si les valeurs des ENUM sont valides
        $valid_sujets = ["Question", "Tirage", "Ressenti", "Personnalite", "Information"];
        $valid_domaines = ["Avenir", "Tirage_general", "Grossesse", "Demenagement", "Amour", "Travail", "Permis", "Argent", "General", "Autres"];
        $valid_paiements = ["Paypal", "Virement"];

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
        $sql = "INSERT INTO contact (user_id, nom, prenom, email, sujet, domaine, paiement, message_envoi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("isssssss", $user_id, $contact_nom, $contact_prenom, $contact_email, $contact_sujet, $contact_domaine, $contact_paiement, $contact_message_envoi);
            if ($stmt->execute()) {
                // Préparer l'email après avoir inséré les données
                try {
                    // Paramètres du serveur SMTP
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.office365.com'; // Serveur SMTP
                    $mail->SMTPAuth = true;
                    $mail->Username = $_ENV['SMTP_USER'];
                    $mail->Password = $_ENV['SMTP_PASS']; // Utiliser une variable d'environnement
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Désactiver la vérification du certificat SSL pour le développement local
                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ];

                    // Définir l'encodage en UTF-8
                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64'; // Encodage du message

                    // Destinataires
                    $mail->setFrom('les-predictions-de-melanie@outlook.com', 'Les Prédictions de Mélanie');
                    $mail->addAddress('les-predictions-de-melanie@outlook.com', 'Propriétaire du Site');

                    // Contenu de l'email au propriétaire du site
                    $mail->isHTML(true);
                    $mail->Subject = "Nouveau message de " . htmlspecialchars($contact_prenom);
                    $mail->Body    = "Vous avez reçu un nouveau message de contact.<br><br>
                                    <strong>Nom :</strong> " . htmlspecialchars($contact_nom) . "<br>
                                    <strong>Prenom :</strong> " . htmlspecialchars($contact_prenom) . "<br>
                                    <strong>Email :</strong> " . htmlspecialchars($contact_email) . "<br>
                                    <strong>Sujet :</strong> " . htmlspecialchars($contact_sujet) . "<br>
                                    <strong>Domaine :</strong> " . htmlspecialchars($contact_domaine) . "<br>
                                    <strong>Type de paiement :</strong> " . htmlspecialchars($contact_paiement) . "<br>
                                    <strong>Message :</strong><br>" . nl2br($contact_message_envoi);
                    $mail->AltBody = "Vous avez reçu un nouveau message de contact.\n\n
                                    Nom : " . htmlspecialchars($contact_nom) . "\n
                                    Prenom : " . htmlspecialchars($contact_prenom) . "\n
                                    Email : " . htmlspecialchars($contact_email) . "\n
                                    Sujet : " . htmlspecialchars($contact_sujet) . "\n
                                    Domaine : " . htmlspecialchars($contact_domaine) . "\n
                                    Type de paiement : " . htmlspecialchars($contact_paiement) . "\n
                                    Message :\n" . htmlspecialchars($contact_message_envoi);
                    $mail->send();

                    // Réinitialiser les destinataires et contenu pour l'email à l'utilisateur
                    $mail->clearAddresses();
                    $mail->clearAttachments();

                    // Préparer l'email de récapitulatif pour l'utilisateur
                    $mail->addAddress($contact_email);
                    // Contenu de l'email
                    $mail->Subject = "Votre message à bien été envoyé sur le site Les Prédictions de Mélanie";
                    $mail->Body     = "Récapitulatif de votre message.<br><br>
                                    <strong>Nom :</strong> " . htmlspecialchars($contact_nom) . "<br>
                                    <strong>Prenom :</strong> " . htmlspecialchars($contact_prenom) . "<br>
                                    <strong>Email :</strong> " . htmlspecialchars($contact_email) . "<br>
                                    <strong>Sujet :</strong> " . htmlspecialchars($contact_sujet) . "<br>
                                    <strong>Domaine :</strong> " . htmlspecialchars($contact_domaine) . "<br>
                                    <strong>Type de paiement :</strong> " . htmlspecialchars($contact_paiement) . "<br>
                                    <strong>Message :</strong><br>" . nl2br($contact_message_envoi);
                    $mail->AltBody = "Récapitulatif de votre message.\n\n
                                    Nom : " . htmlspecialchars($contact_nom) . "\n
                                    Prenom : " . htmlspecialchars($contact_prenom) . "\n
                                    Email : " . htmlspecialchars($contact_email) . "\n
                                    Sujet : " . htmlspecialchars($contact_sujet) . "\n
                                    Domaine : " . htmlspecialchars($contact_domaine) . "\n
                                    Type de paiement : " . htmlspecialchars($contact_paiement) . "\n
                                    Message :\n" . htmlspecialchars($contact_message_envoi);

                    $mail->send();
                    $_SESSION['successMessages']['contact'] = "Votre message a été envoyé avec succès !";
                    header ('Location: formulaire-contact.php');
                    exit();
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
        // Affichage d'un message d'erreur si des champs sont manquants
        echo '<script>
            alert("Tous les champs ne sont pas remplis.");
            window.location.href = "formulaire-contact.php";
            </script>';
        exit();
    }

    $conn->close();
?>
