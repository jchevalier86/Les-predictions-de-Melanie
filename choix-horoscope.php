<?php
    if (isset($_POST['type'])) {
        $type = $_POST['type'];

        if ($type === 'jour') {
            header("Location: horoscope-jour.php");
        } elseif ($type === 'hebdomadaire') {
            header("Location: horoscope-hebdomadaire.php");
        } else {
            echo "Type d'horoscope non valide.";
        }
    } else {
        echo "Veuillez sélectionner un type d'horoscope.";
    }
    exit();
?>