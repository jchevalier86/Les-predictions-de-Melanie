<?php

    // Démarrage de la session
    session_start();

    // Définition des informations de connexion au serveur MySQL
    $servername = "localhost"; // Nom du serveur
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "lespredictionsdemelanie"; // Nom de la base de données

    function openConnection() {
        global $servername, $username, $password, $dbname;
        
        // Créer une connexion
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }
        return $conn;
    }

    function closeConnection($conn) {
        $conn->close();
    }
?>
