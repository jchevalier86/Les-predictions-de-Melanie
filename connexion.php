<?php
    // Inclure le fichier de configuration pour la connexion à la base de données
    require 'config.php';
    require 'function.php';

    // Démarrer la session si elle n'est pas déjà démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Ouvrir une connexion à la base de données
    $conn = openConnection();

    // Vérifier si l'utilisateur est déjà connecté
    if (isLoggedIn()) {
        $_SESSION['errorMessages']['isLoggedIn'] = "Vous êtes déjà connecté !";
        header("Location: formulaire-connexion.php");
        exit();
    }

    // Vérification que les champs de formulaire sont définis
    if (isset($_POST['email'], $_POST['mot_de_passe'])) {
        // Récupération et stockage des valeurs du formulaire dans des variables
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Stocker les données du formulaire dans la session pour réutilisation en cas d'erreur
        $_SESSION['form_data'] = [
            'email' => $email
        ];

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
                    $_SESSION['user_id'] = $utilisateur['user_id'];
                    // Stocker le nom et le prénom dans la session
                    $_SESSION['user_name'] = $utilisateur['nom'];
                    $_SESSION['user_prenom'] = $utilisateur['prenom'];
                    // Redirection avec un message de succès
                    $_SESSION['successMessages']['connexion'] = "Connexion réussie ! Bienvenue " . htmlspecialchars($utilisateur['prenom']) . " " . htmlspecialchars($utilisateur['nom']) . ".";
                    header("Location: accueil.php");
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
        $_SESSION['errorMessages']['form'] = "Veuillez remplir tous les champs.";
        header("Location: formulaire-connexion.php");
        exit();
    }

    // Fermeture de la connexion à la base de données
    closeConnection($conn);
?>
