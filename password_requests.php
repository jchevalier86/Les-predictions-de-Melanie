<?php
    // Inclure le fichier de configuration pour la connexion à la base de données et les fonctions utilitaires
    require 'config.php';
    require 'function.php';

    // Inclure les librairies PHPMailer
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

    // Vérifier si l'utilisateur est déjà connecté
    if (isLoggedIn()) {
        $_SESSION['errorMessages']['isLoggedIn'] = "Vous êtes déjà connecté !";
        header("Location: mot-de-passe-perdu.php");
        exit();
    }

    // Fonction pour envoyer l'email de réinitialisation du mot de passe
    function sendPasswordResetEmail($email) {
        // Ouvrir la connexion à la base de données
        $conn = openConnection();
        
        if (!$conn instanceof mysqli) {
            die("Erreur : L'objet mysqli est invalide.");
        }

        // Assurer que l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>
            alert("L\'adresse email fournie est invalide.");
            window.location.href = "mot-de-passe-perdu.php";
            </script>';
            exit();
        }

        // Préparer la requête pour vérifier si l'email existe
        $stmt = $conn->prepare("SELECT user_id FROM utilisateurs WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
                // Générer un token unique pour la réinitialisation
                $token = bin2hex(random_bytes(32));

                // Préparer la requête pour insérer le token dans la base de données
                $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token) VALUES (?, ?)");
                if ($stmt) {
                    $stmt->bind_param("is", $user['user_id'], $token);
                    $stmt->execute();

                    // Générer le lien de réinitialisation du mot de passe
                    $resetLink = "http://localhost/les_predictions_de_melanie/reset_password.php?token=$token";

                    // Configurer et envoyer l'email
                    $mail = new PHPMailer(true);
                    try {
                        // Configuration du serveur SMTP
                        $mail->isSMTP();
                        $mail->Host = 'smtp.office365.com'; // Serveur SMTP
                        $mail->SMTPAuth = true;
                        $mail->Username = $_ENV['SMTP_USER'];
                        $mail->Password = $_ENV['SMTP_PASS']; // J'utilise des variables d'environnement dans le fichier .env qui se trouve à la racine de mon projet
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

                        // Configuration de l'email
                        $mail->setFrom('les-predictions-de-melanie@outlook.com', 'Les Prédictions de Mélanie');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->CharSet = 'UTF-8'; // Définir l'encodage en UTF-8
                        $mail->Encoding = 'base64'; // Encodage du message
                        $mail->Subject = 'Réinitialisation de votre mot de passe';
                        $mail->Body = "Bonjour,<br><br>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :<br><br><a href='$resetLink'>$resetLink</a><br><br>Si vous n'avez pas demandé de réinitialisation, ignorez cet email.";
                        $mail->AltBody = "Bonjour,\n\nCliquez sur le lien suivant pour réinitialiser votre mot de passe :\n\n$resetLink\n\nSi vous n'avez pas demandé de réinitialisation, ignorez cet email.";

                        // Envoyer l'email
                        $mail->send();
                        $_SESSION['successMessages']['password_perdu'] = "Un email de réinitialisation a été envoyé !";
                        header ('Location: mot-de-passe-perdu.php');
                        exit();
                    } catch (Exception $e) {
                        // Gestion des erreurs d'envoi d'email
                        echo '<script>
                        alert("Une erreur est survenue lors de l\'envoi de l\'email. Erreur : ' . htmlspecialchars($mail->ErrorInfo, ENT_QUOTES, 'UTF-8') . '");
                        window.location.href = "mot-de-passe-perdu.php";
                        </script>';
                        exit();
                    }
                } else {
                    // Erreur lors de la préparation de la requête d'insertion du token
                    echo "Erreur de préparation de la requête : " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
                }
            } else {
                // Aucun utilisateur trouvé avec cet e-mail
                $_SESSION['errorMessages']['email'] = "* Aucun utilisateur trouvé avec cet e-mail.";
                header("Location: mot-de-passe-perdu.php");
                exit();
            }
            $stmt->close();
        } else {
            // Erreur lors de la préparation de la requête de vérification de l'email
            echo "Erreur de préparation de la requête : " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
        }

        // Fermer la connexion à la base de données
        closeConnection($conn);
    }

    // Vérifier si la requête est de type POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        sendPasswordResetEmail($email);
    }
?>
