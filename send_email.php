<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'path/to/PHPMailer/src/Exception.php';
    require 'path/to/PHPMailer/src/PHPMailer.php';
    require 'path/to/PHPMailer/src/SMTP.php';

    function sendPasswordResetEmail($email, $resetLink) {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.outlook.com'; // Serveur SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'les-predictions-de-melanie@outlook.com'; // Adresse email de l'expéditeur
            $mail->Password = 'monamour20082011'; // Mot de passe email
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Expéditeur et destinataire
            $mail->setFrom('les-predictions-de-melanie@outlook.com', 'localhost/les_predictions_de_melanie/accueil.html');
            $mail->addAddress($email);

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Réinitialisation de votre mot de passe';
            $mail->Body    = "Bonjour,<br><br>Cliquez sur le lien suivant pour réinitialiser votre mot de passe :<br><br><a href='$resetLink'>$resetLink</a><br><br>Si vous n'avez pas demandé de réinitialisation, ignorez cet email.";
            $mail->AltBody = "Bonjour,\n\nCliquez sur le lien suivant pour réinitialiser votre mot de passe :\n\n$resetLink\n\nSi vous n'avez pas demandé de réinitialisation, ignorez cet email.";

            $mail->send();
            echo 'Un email de réinitialisation a été envoyé.';
        } catch (Exception $e) {
            echo "Une erreur est survenue lors de l'envoi de l'email. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>
