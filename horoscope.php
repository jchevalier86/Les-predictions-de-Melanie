<?php
    if (isset($_POST['signe'])) {
        $signe = $_POST['signe'];
        $rss_urls = [
            'belier' => 'https://www.mon-horoscope-du-jour.com/rss/rss_belier.php',
            'taureau' => 'https://www.mon-horoscope-du-jour.com/rss/rss_taureau.php',
            'gemeaux' => 'https://www.mon-horoscope-du-jour.com/rss/rss_gemeaux.php',
            'cancer' => 'https://www.mon-horoscope-du-jour.com/rss/rss_cancer.php',
            'lion' => 'https://www.mon-horoscope-du-jour.com/rss/rss_lion.php',
            'vierge' => 'https://www.mon-horoscope-du-jour.com/rss/rss_vierge.php',
            'balance' => 'https://www.mon-horoscope-du-jour.com/rss/rss_balance.php',
            'scorpion' => 'https://www.mon-horoscope-du-jour.com/rss/rss_scorpion.php',
            'sagittaire' => 'https://www.mon-horoscope-du-jour.com/rss/rss_sagittaire.php',
            'capricorne' => 'https://www.mon-horoscope-du-jour.com/rss/rss_capricorne.php',
            'verseau' => 'https://www.mon-horoscope-du-jour.com/rss/rss_verseau.php',
            'poissons' => 'https://www.mon-horoscope-du-jour.com/rss/rss_poissons.php'
        ];
    
        if (array_key_exists($signe, $rss_urls)) {
            $url = $rss_urls[$signe];
            $xml = simplexml_load_file($url);
    
            if ($xml) {
                echo "<h1> Horoscope pour " . ucfirst($signe) . "</h1>";
                foreach ($xml->channel->item as $item) {
                    echo "<h2>" . $item->title . "</h2>";
                    echo "<p>" . $item->description . "</p>";
                }
            } else {
                echo "Erreur lors de la récupération du flux RSS.";
            }
        } else {
            echo "Signe astrologique non valide.";
        }
    } else {
        echo "Veuillez sélectionner un signe astrologique.";
    }
?>