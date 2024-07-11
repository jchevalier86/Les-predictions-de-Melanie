<?php
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
        echo ("La connexion a échoué : " . $conn->connect_error);
    }

    // Vérification que tous les champs de formulaire nécessaires sont définis
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['email'], $_POST['phone'], $_POST['mot_de_passe'])) {
        // Récupération et stockage des valeurs du formulaire dans des variables
        $utilisateurs_nom = $_POST['nom'];
        $utilisateurs_prenom = $_POST['prenom'];
        $utilisateurs_date_naissance = $_POST['date_naissance'];
        $utilisateurs_email = $_POST['email'];
        $utilisateurs_phone = $_POST['phone'];
        // Hachage du mot de passe et de la confirmation du mot de passe pour des raisons de sécurité
        $utilisateurs_mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        // echo $utilisateurs_mot_de_passe;
        // Préparation de la requête SQL d'insertion
        $sql = "INSERT INTO utilisateurs (nom, prenom, date_naissance, email, phone, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)";

        // Préparation de la requête préparée
        $stmt = $conn->prepare($sql);

        // Vérification que la préparation de la requête a réussi
        if ($stmt) {
            // Liaison des paramètres de la requête préparée aux variables
            $stmt->bind_param("ssisis", $utilisateurs_nom, $utilisateurs_prenom, $utilisateurs_date_naissance, $utilisateurs_email, $utilisateurs_phone, $utilisateurs_mot_de_passe);
            // Exécution de la requête préparée
            if ($stmt->execute()) {
                // Affichage d'un message de succès si les données ont été insérées avec succès
                echo '<script>alert("Votre inscription à bien été prise en compte");</script>';
            } else {
                // Affichage d'un message d'erreur si l'insertion des données a échoué
                echo "Erreur lors de l'insertion des données : " . $stmt->error;
            }
            // Fermeture de la requête préparée
            $stmt->close();
        }
        else {
            // Affichage d'un message d'erreur si la préparation de la requête a échoué
            echo "Erreur de préparation de la requête : " . $conn->error;
        }
    } else {
        // Affichage d'un message d'erreur si tous les champs du formulaire ne sont pas remplis
        echo "Tous les champs ne sont pas remplis.";
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
?>
