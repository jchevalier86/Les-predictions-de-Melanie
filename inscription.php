<?php
    // Démarrage de la session
    session_start();

    // Définition des informations de connexion au serveur MySQL
    $servername = "localhost"; // Nom du serveur
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "lespredictionsdemelanie"; // Nom de la base de données

    // Création d'une nouvelle connexion à la base de données MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion à la base de données
    if ($conn->connect_error) {
        // Affichage d'un message d'erreur en cas d'échec de connexion
        echo "La connexion a échoué : " . $conn->connect_error;
        exit();
    }

    function validateAge($date_naissance) {
        $today = new DateTime();
        $birthDate = new DateTime($date_naissance);
        if ($birthDate > $today) {
            return false;
        }
        $age = $today->diff($birthDate)->y;
        return $age >= 18;
    }
    
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    function validatePhone($phone) {
        return preg_match('/^[0-9]{10}$/', $phone) || $phone === '';
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
            $errorMessages['email'] = "* Veuillez entrer une adresse email valide.";
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

        // Vérification si l'email existe déjà dans la base de données
        $sql_check = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        if ($stmt_check) {
            $stmt_check->bind_param("s", $utilisateurs_email);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            if ($result_check->num_rows > 0) {
                // Affichage d'un message d'erreur si l'utilisateur est déjà inscrit
                $_SESSION['errorMessages'] = ["Cet utilisateur est déjà inscrit avec cet email."];
                header("Location: formulaire-inscription.php");
                exit();
            } else {
                // Préparation de la requête SQL d'insertion
                $sql = "INSERT INTO utilisateurs (nom, prenom, date_naissance, email, phone, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)";
                // Préparation de la requête préparée
                $stmt = $conn->prepare($sql);
                // Vérification que la préparation de la requête a réussi
                if ($stmt) {
                    // Liaison des paramètres de la requête préparée aux variables
                    $stmt->bind_param("ssssss", $utilisateurs_nom, $utilisateurs_prenom, $utilisateurs_date_naissance, $utilisateurs_email, $utilisateurs_phone, $utilisateurs_mot_de_passe);
                    // Exécution de la requête préparée
                    if ($stmt->execute()) {
                        // $_SESSION['successMessage'] = "Votre inscription a bien été prise en compte.";
                        echo '<script>
                        alert("Inscription réussie ! Vous allez être redirigé vers la page de connexion.");
                        window.location.href = "formulaire-connexion.php";
                        </script>';
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
        
        $conn->close();
?>
