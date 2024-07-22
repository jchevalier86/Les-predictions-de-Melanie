<?php
    // Démarrer la session au début du fichier
    session_start();
    
    // Inclure le fichier de connexion et les librairies PHPMailer
    require './index.php'; // Inclure le fichier de connexion
    require './libs/PHPMailer/src/PHPMailer.php';
    require './libs/PHPMailer/src/SMTP.php';
    require './libs/PHPMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Fonction pour valider l'email
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Fonction pour envoyer l'email de réinitialisation du mot de passe
    function sendPasswordResetEmail($email) {
        $conn = openConnection(); // Ouvrir la connexion

        if (!validateEmail($email)) {
            $_SESSION['errorMessages']['email'] = "* Adresse email invalide.";
            closeConnection($conn);
            header("Location: mot-de-passe-perdu.php");
            exit();
        }

        if (!$conn instanceof mysqli) {
            die("Erreur : L'objet mysqli est invalide.");
        }

        // Préparer la requête pour vérifier si l'email existe
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
                // Générer un token unique
                $token = bin2hex(random_bytes(32));

                // Préparer la requête pour insérer le token dans la base de données
                $stmt = $conn->prepare("INSERT INTO password_resets (utilisateur_id, token) VALUES (?, ?)");
                if ($stmt) {
                    $stmt->bind_param("is", $user['id'], $token);
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
                        $mail->Username = 'les-predictions-de-melanie@outlook.com'; // Votre adresse email SMTP
                        $mail->Password = 'monamour20082011'; // Votre mot de passe SMTP
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Désactiver la vérification du certificat SSL (pour le développement local)
                        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );

                        // Configuration de l'email
                        $mail->setFrom('les-predictions-de-melanie@outlook.com', 'Les Predictions de Melanie');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Reinitialisation de votre mot de passe';
                        $mail->Body = "Bonjour,<br><br>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :<br><br><a href='$resetLink'>$resetLink</a><br><br>Si vous n'avez pas demandé de réinitialisation, ignorez cet email.";
                        $mail->AltBody = "Bonjour,\n\nCliquez sur le lien suivant pour réinitialiser votre mot de passe :\n\n$resetLink\n\nSi vous n'avez pas demandé de réinitialisation, ignorez cet email.";

                        $mail->send();
                        echo '<script>
                        alert("Un email de réinitialisation a été envoyé ! Vous allez être redirigé vers la page d\'accueil.");
                        window.location.href = "accueil.html";
                        </script>';
                        exit();
                    } catch (Exception $e) {
                        echo '<script>
                        alert("Une erreur est survenue lors de l\'envoi de l\'email. Erreur: ' . $mail->ErrorInfo . '");</script>';
                    }
                } else {
                    echo "Erreur de préparation de la requête : " . $conn->error;
                }
            } else {
                $_SESSION['errorMessages']['email'] = "* Aucun utilisateur trouvé avec cet e-mail.";
                header("Location: mot-de-passe-perdu.php");
                exit();
            }
            $stmt->close();
        } else {
            echo "Erreur de préparation de la requête : " . $conn->error;
        }
        closeConnection($conn);
    }

    // Vérifier si la requête est de type POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        sendPasswordResetEmail($email);
    }
?>
