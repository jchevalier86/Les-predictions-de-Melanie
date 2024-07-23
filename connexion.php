<?php
    // Inclure le fichier de configuration pour la connexion à la base de données
    require 'config.php';

    // Vérifier si l'utilisateur est déjà connecté
    $isConnected = isset($_SESSION['utilisateur_id']);

    // Ouvrir une connexion à la base de données
    $conn = openConnection();

    // Vérification que les champs de formulaire sont définis
    if (isset($_POST['email'], $_POST['mot_de_passe'])) {
        // Récupération et stockage des valeurs du formulaire dans des variables
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Stocker les données du formulaire dans la session pour réutilisation en cas d'erreur
        $_SESSION['form_data'] = [
            'email' => $email
        ];

        // Si aucune erreur n'a été trouvée
        if (empty($errorMessages)) {
            // Préparation de la requête SQL de sélection
            $sql = "SELECT * FROM utilisateurs WHERE email = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Liaison des paramètres de la requête préparée aux variables
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    // Récupération des données utilisateur
                    $utilisateur = $result->fetch_assoc();

                    // Vérification du mot de passe
                    if (password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
                        // Stockage des informations utilisateur dans la session
                        $_SESSION['utilisateur_id'] = $utilisateur['id'];
                        $_SESSION['utilisateurs_name'] = $utilisateur['nom'] . " " . $utilisateur['prenom'];

                        // Redirection avec un message de succès
                        echo '<script>
                        alert("Connexion réussie ! Vous allez être redirigé vers la page accueil.");
                        window.location.href = "accueil.html";
                        </script>';
                        exit();
                    } else {
                        $_SESSION['errorMessages']['mot_de_passe'] = "* Mot de passe incorrect.";
                        header("Location: formulaire-connexion.php");
                        exit();
                    }
                } else {
                    $_SESSION['errorMessages']['email'] = "* Aucun utilisateur trouvé avec cet e-mail.";
                    header("Location: formulaire-connexion.php");
                    exit();
                }
                $stmt->close();
            } else {
                $_SESSION['errorMessages']['database'] = "Erreur de préparation de la requête : " . $conn->error;
                header("Location: formulaire-connexion.php");
                exit();
            }
        } else {
            // Envoi des messages d'erreur à la session
            $_SESSION['errorMessages'] = $errorMessages;
            header("Location: formulaire-connexion.php");
            exit();
        }
    } else {
        $_SESSION['errorMessages']['form'] = "Veuillez remplir tous les champs.";
        header("Location: formulaire-connexion.php");
        exit();
    }

    // Fermeture de la connexion à la base de données
    closeConnection($conn);
?>
