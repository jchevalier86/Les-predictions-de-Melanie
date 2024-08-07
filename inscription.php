<?php
    // Inclusion des configurations et fonctions communes
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
        header("Location: formulaire-inscription.php");
        exit();
    }

    // Vérification que tous les champs de formulaire nécessaires sont définis
    if (!isset($_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['email'], $_POST['phone'], $_POST['mot_de_passe'], $_POST['confirmation_mot_de_passe'])) {
        $_SESSION['errorMessages'] = ["Tous les champs ne sont pas remplis."];
        header("Location: formulaire-inscription.php");
        exit();
    }

    // Récupération et stockage des valeurs du formulaire dans des variables
    $utilisateurs_nom = $_POST['nom'];
    $utilisateurs_prenom = $_POST['prenom'];
    $utilisateurs_date_naissance = $_POST['date_naissance'];
    $utilisateurs_email = $_POST['email'];
    $utilisateurs_phone = $_POST['phone'];
    $utilisateurs_mot_de_passe = $_POST['mot_de_passe'];
    $confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'];

    $_SESSION['form_data'] = [
        'nom' => $utilisateurs_nom,
        'prenom' => $utilisateurs_prenom,
        'date_naissance' => $utilisateurs_date_naissance,
        'email' => $utilisateurs_email,
        'phone' => $utilisateurs_phone,
    ];

    $errorMessages = [];
    if (!validateAge($utilisateurs_date_naissance)) {
        $errorMessages['age'] = "* Vous devez avoir au moins 18 ans pour vous inscrire.";
    }
    if (!validateEmail($utilisateurs_email)) {
        $errorMessages['email'] = "* Cet utilisateur est déjà inscrit avec cet email.";
    }
    if (!validatePhone($utilisateurs_phone)) {
        $errorMessages['phone'] = "* Le numéro de téléphone n'est pas valide.";
    }
    if ($utilisateurs_mot_de_passe !== $confirmation_mot_de_passe) {
        $errorMessages['mot_de_passe'] = "* Les mots de passe ne correspondent pas.";
    }

    if (!empty($errorMessages)) {
        $_SESSION['errorMessages'] = $errorMessages;
        header("Location: formulaire-inscription.php");
        exit();
    }

    // Hachage du mot de passe pour des raisons de sécurité
    $utilisateurs_mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    // Connexion à la base de données
    $conn = openConnection();

    // Vérification si l'email existe déjà dans la base de données
    $sql_check = "SELECT email FROM utilisateurs WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    if ($stmt_check) {
        $stmt_check->bind_param("s", $utilisateurs_email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $_SESSION['errorMessages']['email'] = "* Cet utilisateur est déjà inscrit avec cet email.";
            header("Location: formulaire-inscription.php");
            exit();
        } else {
            // Préparation de la requête SQL d'insertion
            $sql = "INSERT INTO utilisateurs (nom, prenom, date_naissance, email, phone, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssssss", $utilisateurs_nom, $utilisateurs_prenom, $utilisateurs_date_naissance, $utilisateurs_email, $utilisateurs_phone, $utilisateurs_mot_de_passe);
                if ($stmt->execute()) {
                    // Stocker le nom et le prénom dans la session
                    $_SESSION['user_name'] = $utilisateurs_nom;
                    $_SESSION['user_prenom'] = $utilisateurs_prenom;
                    // Redirection avec un message de succès
                    $_SESSION['successMessages']['inscription'] = "Inscription réussie ! Bienvenue " . htmlspecialchars($utilisateurs_prenom) . " " . htmlspecialchars($utilisateurs_nom) . ".";
                    header("Location: formulaire-connexion.php");
                    exit();
                } else {
                    $_SESSION['errorMessages'] = ["Erreur lors de l'insertion des données : " . $stmt->error];
                    header("Location: formulaire-inscription.php");
                    exit();
                }
                $stmt->close();
            } else {
                $_SESSION['errorMessages'] = ["Erreur de préparation de la requête : " . $conn->error];
                header("Location: formulaire-inscription.php");
                exit();
            }
        }
        $stmt_check->close();
    } else {
        $_SESSION['errorMessages'] = ["Erreur de préparation de la requête de vérification : " . $conn->error];
        header("Location: formulaire-inscription.php");
        exit();
    }

    closeConnection($conn);
?>
