<?php
    // Démarrer la session si elle n'est pas déjà démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    session_unset(); // Supprimer toutes les variables de session
    // Détruire la session pour déconnecter l'utilisateur
    session_destroy();
    
    // Redirection avec un message de succès
    echo '<script>
        alert("Vous avez bien été déconnecté ! Vous allez être redirigé vers la page d\'accueil.");
        window.location.href = "accueil.html";
    </script>';
    exit();
?>
