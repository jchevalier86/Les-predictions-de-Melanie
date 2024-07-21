<?php
require './index.php'; // Inclure le fichier de connexion
require './libs/PHPMailer/src/PHPMailer.php';
require './libs/PHPMailer/src/SMTP.php';
require './libs/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendPasswordResetEmail($email) {
    $conn = openConnection(); // Ouvrir la connexion

    if (!$conn instanceof mysqli) {
        die("Erreur : L'objet mysqli est invalide.");
    }

    $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $stmt = $conn->prepare("INSERT INTO password_resets (utilisateur_id, token) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("is", $user['id'], $token);
                $stmt->execute();

                $resetLink = "http://localhost/les_predictions_de_melanie/reset_password.php?token=$token";

                $mail = new PHPMailer(true);
                try {
                    // Configuration du serveur SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.office365.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'les-predictions-de-melanie@outlook.com';
                    $mail->Password = 'monamour20082011';
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
                    echo "<div style='color:blue;'>Un email de réinitialisation a été envoyé.</div>";
                    echo "<script>setTimeout(function() { window.location.href = './accueil.html'; }, 3000);</script>";
                    exit();
                } catch (Exception $e) {
                    echo "<div style='color:red;'>Une erreur est survenue lors de l'envoi de l'email. Erreur: {$mail->ErrorInfo}</div>";
                }
            } else {
                echo "Erreur de préparation de la requête : " . $conn->error;
            }
        } else {
            echo "<div style='color:red;'>Aucun utilisateur trouvé avec cet email.</div>";
        }
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $conn->error;
    }
    closeConnection($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    sendPasswordResetEmail($email);
}
?>
