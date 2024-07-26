<?php
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