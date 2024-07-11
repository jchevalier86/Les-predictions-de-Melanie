<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horoscope</title>
</head>

<?php
$horoscope = 'Veuillez choisir un signe astrologique.';
?>

<body>
    <h1>Votre Horoscope</h1>
    <?php echo $horoscope; ?>

<?php
    $horoscope = 'Veuillez choisir un signe astrologique.';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sign = $_POST['sign'];
        $apiKey = 'f9ed554894mshaa8eeefc1fb8d82p1f929ajsnb2ea98c6fe94';

        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://best-daily-astrology-and-horoscope-api.p.rapidapi.com/api/Detailed-Horoscope/?zodiacSign=" . urlencode($sign),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: best-daily-astrology-and-horoscope-api.p.rapidapi.com",
                "x-rapidapi-key: $apiKey"
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            $horoscope = "Erreur cURL : " . $err;
        } else {
            $horoscope = $response;
        }
    }

    echo '<form method="POST" action="">
        <label for="sign">Signe :</label>
        <select name="sign" id="sign">
            <option value="aries">Bélier</option>
            <option value="taurus">Taureau</option>
            <option value="gemini">Gémeaux</option>
            <option value="cancer">Cancer</option>
            <option value="leo">Lion</option>
            <option value="virgo">Vierge</option>
            <option value="libra">Balance</option>
            <option value="scorpio">Scorpion</option>
            <option value="sagittarius">Sagittaire</option>
            <option value="capricorn">Capricorne</option>
            <option value="aquarius">Verseau</option>
            <option value="pisces">Poissons</option>
        </select>
        <button type="submit">Voir l\'horoscope</button>
    </form>';

    echo '<p>' . htmlspecialchars($horoscope) . '</p>';
?>

    <br>
    <a href="horoscope.html">Retourner au menu</a>
</body>
</html>
