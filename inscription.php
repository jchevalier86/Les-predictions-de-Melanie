<?php
// Définition des informations de connexion au serveur MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lespredictionsdemelanie";

// Création d'une nouvelle connexion à la base de données MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion à la base de données
if ($conn->connect_error) {
    // Affichage d'un message d'erreur en cas d'échec de connexion
    echo "La connexion a échoué : " . $conn->connect_error;
    exit();
}

// Vérification que tous les champs de formulaire nécessaires sont définis
if (isset($_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['email'], $_POST['phone'], $_POST['mot_de_passe'])) {
    // Récupération et stockage des valeurs du formulaire dans des variables
    $utilisateurs_nom = $_POST['nom'];
    $utilisateurs_prenom = $_POST['prenom'];
    $utilisateurs_date_naissance = $_POST['date_naissance'];
    $utilisateurs_email = $_POST['email'];
    $utilisateurs_phone = $_POST['phone'];
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
            echo "<div style='color:red;'>Cet utilisateur est déjà inscrit avec cet email.</div>";
            // Redirection vers la page inscription après une vérification du compte de l'utilisateur déjà inscrit avec un délai de 3 secondes
            echo "<script>setTimeout(function() { window.location.href = './inscription.html'; }, 3000);</script>";
            exit(); // Arrêter l'exécution du script après la redirection
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
                    // Affichage d'un message de succès si les données ont été insérées avec succès
                    echo "<div style='color:blue;'>Votre inscription a bien été prise en compte.</div>";
                    // Redirection vers la page de connexion après une inscription réussie avec un délai de 3 secondes
                    echo "<script>setTimeout(function() { window.location.href = './connexion.html'; }, 3000);</script>";
                    exit(); // Arrêter l'exécution du script après la redirection
                } else {
                    // Affichage d'un message d'erreur si l'insertion des données a échoué
                    echo "Erreur lors de l'insertion des données : " . $stmt->error;
                }
                // Fermeture de la requête préparée
                $stmt->close();
            } else {
                // Affichage d'un message d'erreur si la préparation de la requête a échoué
                echo "Erreur de préparation de la requête : " . $conn->error;
            }
        }
        // Fermeture de la requête de vérification
        $stmt_check->close();
    } else {
        // Affichage d'un message d'erreur si la préparation de la requête de vérification a échoué
        echo "Erreur de préparation de la requête de vérification : " . $conn->error;
    }
} else {
    // Affichage d'un message d'erreur si tous les champs du formulaire ne sont pas remplis
    echo "Tous les champs ne sont pas remplis.";
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
