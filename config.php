<?php
    // Démarrage de la session
    session_start();

    // Définition des informations de connexion au serveur MySQL
    $servername = "localhost"; // Nom du serveur
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "lespredictionsdemelanie"; // Nom de la base de données

    // Fonction pour ouvrir une connexion à la base de données
    function openConnection() {
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }
        return $conn;
    }

    // Fonction pour fermer une connexion à la base de données
    function closeConnection($conn) {
        $conn->close();
    }

    // Fonction pour vérifier si l'utilisateur est connecté
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Fonction pour connecter l'utilisateur
    function login($email, $mot_de_passe) {
        $conn = openConnection();
       
        $stmt = $conn->prepare("SELECT user_id, mot_de_passe FROM utilisateurs WHERE email = ?");
        $stmt->bind_param("ss", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $nom; // Optionnel : stocke le nom d'utilisateur dans la session
            $stmt->close();
            closeConnection($conn);
            return true;
        }
        
        $stmt->close();
        closeConnection($conn);
        return false;
    }
?>
