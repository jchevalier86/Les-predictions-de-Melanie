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

    // Fonctions de validation
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

    function validatePassword($password) {
        return !empty($password); // Vérifie si le mot de passe n'est pas vide
    }
?>
