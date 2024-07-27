<?php
    // require 'connexion.php';
    // Démarrer la session si elle n'est pas déjà démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    session_unset(); // Supprimer toutes les variables de session
    // Détruire la session pour déconnecter l'utilisateur
    session_destroy();
    header('Location: accueil.php');
    exit();
?>
