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
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Vérification que les champs de formulaire sont définis
    if (isset($_POST['email'], $_POST['mot_de_passe'])) {
        // Récupération et stockage des valeurs du formulaire dans des variables
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Debugging
        // var_dump($email, $mot_de_passe);

        // Préparation de la requête SQL de sélection
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Liaison des paramètres de la requête préparée aux variables
            $stmt->bind_param("s", $_POST['email']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // Récupération des données utilisateur
                $utilisateurs = $result->fetch_assoc();

                // Debugging
                // var_dump($utilisateurs);

                // Vérification du mot de passe
                if (password_verify($mot_de_passe, $utilisateurs["mot_de_passe"])) {
                    // Stockage des informations utilisateur dans la session
                    $_SESSION['utilisateurs_id'] = $utilisateurs['id'];
                    $_SESSION['utilisateurs_name'] = $utilisateurs['prenom'] . " " . $utilisateurs['nom'];

                    echo "<div style='color:blue;'>Connexion réussie ! Bienvenue " . $utilisateurs['prenom'] . " " . $utilisateurs['nom'] . " !</div>";
                    echo "<script>setTimeout(function() { window.location.href = './accueil.html'; }, 3000);</script>";
                    exit();

                } else {
                    // Redirection vers la page connexion après une vérification du mot de passe incorrect avec un délai de 3 secondes
                    echo "<div style='color:red;'>Mot de passe incorrect.</div>";
                    echo "<script>setTimeout(function() { window.location.href = './connexion.html'; }, 3000);</script>";
                }
            } else {
                // Redirection vers la page connexion après une vérification de l'adresse mail incorrect avec un délai de 3 secondes
                echo "<div style='color:red;'>Aucun utilisateur trouvé avec cet e-mail.</div>";
                echo "<script>setTimeout(function() { window.location.href = './connexion.html'; }, 3000);</script>";
            }
            $stmt->close();
        } else {
            echo "Erreur de préparation de la requête : " . $conn->error;
        }
    } else {
        echo "Veuillez remplir tous les champs.";
        
        // Debugging
        // var_dump($_POST);
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
?>
