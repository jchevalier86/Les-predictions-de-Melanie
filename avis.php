<?php
    // Inclure les configurations et fonctions communes
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

    // Vérification que tous les champs de formulaire nécessaires sont définis
    if (isset($_POST['rating'], $_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['avis'])) {

        // Assainir les entrées utilisateur
        $avis_clients_rating = htmlspecialchars($_POST['rating'], ENT_QUOTES, 'UTF-8');
        $avis_clients_nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8');
        $avis_clients_prenom = htmlspecialchars($_POST['prenom'], ENT_QUOTES, 'UTF-8');
        $avis_clients_email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $avis_clients_avis = htmlspecialchars($_POST['avis'], ENT_QUOTES, 'UTF-8');

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
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        // Préparation de la requête SQL d'insertion
        $sql = "INSERT INTO avis_clients (user_id, rating, nom, prenom, email, avis) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("isssss", $user_id, $avis_clients_rating, $avis_clients_nom, $avis_clients_prenom, $avis_clients_email, $avis_clients_avis);
            if ($stmt->execute()) {
                // Préparer l'email après avoir inséré les données
                try {
                    // Configuration du serveur SMTP
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = $_ENV['SMTP_HOST'];
                    $mail->SMTPAuth = true;
                    $mail->Username = $_ENV['SMTP_USER'];
                    $mail->Password = $_ENV['SMTP_PASS'];
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
                    
                    // Destinataire
                    $mail->setFrom('les-predictions-de-melanie@outlook.com', 'Les Prédictions de Mélanie');
                    $mail->addAddress('les-predictions-de-melanie@outlook.com', 'Les Prédictions de Mélanie');

                     // Envoi et Contenu de l'email au propriétaire du site
                    $mail->isHTML(true);
                    $mail->Subject = "Nouveau avis de " . htmlspecialchars($avis_clients_prenom);
                    $mail->Body    = "Vous avez reçu un nouveau avis sur le site Les Prédictions de Mélanie.<br><br>
                                    <strong>Note :</strong> " . htmlspecialchars($avis_clients_rating) . " étoile(s) <br>
                                    <strong>Nom :</strong> " . htmlspecialchars($avis_clients_nom) . "<br>
                                    <strong>Prenom :</strong> " . htmlspecialchars($avis_clients_prenom) . "<br>
                                    <strong>Email :</strong> " . htmlspecialchars($avis_clients_email) . "<br>
                                    <strong>Avis :</strong> " . nl2br($avis_clients_avis);
                    $mail->AltBody = "Vous avez reçu un nouveau avis sur votre site.\n\n
                                    Note : " . htmlspecialchars($avis_clients_rating) . "\n
                                    Nom : " . htmlspecialchars($avis_clients_nom) . "\n
                                    Prenom : " . htmlspecialchars($avis_clients_prenom) . "\n
                                    Email : " . htmlspecialchars($avis_clients_email) . "\n
                                    Avis :\n" . htmlspecialchars($avis_clients_avis);
                    $mail->send();

                    // Réinitialiser les destinataires et contenu pour l'email à l'utilisateur
                    $mail->clearAddresses();
                    $mail->clearAttachments();

                    $mail->addAddress($avis_clients_email);

                    // Contenu de l'email
                    $mail->isHTML(true);
                    $mail->Subject = 'Récapitulatif de votre avis';
                    $mail->Body    = "Merci pour votre avis ! Voici un récapitulatif :<br><br>
                                      <strong>Note :</strong> " . $avis_clients_rating . " étoile(s)<br>
                                      <strong>Nom :</strong> " . htmlspecialchars($avis_clients_nom) . "<br>
                                      <strong>Prenom :</strong> " . htmlspecialchars($avis_clients_prenom) . "<br>
                                      <strong>Email :</strong> " . htmlspecialchars($avis_clients_email) . "<br>
                                      <strong>Avis :</strong> " . $avis_clients_avis . "<br><br>
                                      Cordialement,<br><br>Les Prédictions de Mélanie";
                    $mail->AltBody = "Récapitulatif de votre avis.\n\n
                    Note : " . htmlspecialchars($avis_clients_rating) . "\n
                    Nom : " . htmlspecialchars($avis_clients_nom) . "\n
                    Prenom : " . htmlspecialchars($avis_clients_prenom) . "\n
                    Email : " . htmlspecialchars($avis_clients_email) . "\n
                    Avis :\n" . htmlspecialchars($avis_clients_avis);

                    $mail->send();
                    // Redirection ou message de succès
                    $_SESSION['successMessages']['avis'] = "Votre avis a été soumis avec succès.";
                    header('Location: formulaire-avis.php');
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
            window.location.href = "formulaire-avis.php";
            </script>';
        exit();
    }

    $conn->close();
?>
