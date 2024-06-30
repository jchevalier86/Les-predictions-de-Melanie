<?php
$horoscope = 'Veuillez choisir un signe astrologique.';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horoscope</title>
</head>

<body>
    <h1>Votre Horoscope</h1>
    <?php echo $horoscope; ?>

    <?php
    $horoscope = 'Veuillez choisir un signe astrologique.';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sign = $_POST['sign'];
        $date = date('Y-m-d');
        $apiKey = '8501e1a789msh9ec9ffb634be5adp130a3ejsnf4b68454245a';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://daily-horoscope3.p.rapidapi.com/api/1.0/get_daily_horoscope.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'sign' => $sign,
                'date' => $date,
                'api_key' => $apiKey,
                'timezone' => '5.5',
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded",
                "x-rapidapi-host: daily-horoscope3.p.rapidapi.com",
                "x-rapidapi-key: $apiKey"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    } else {
        echo '<form method="POST" action="">
            <label for="sign">Signe :</label>
            <select name="sign" id="sign">
                <option value="belier">Bélier</option>
                <option value="taureau">Taureau</option>
                <option value="gemeaux">Gémeaux</option>
                <option value="cancer">Cancer</option>
                <option value="lion">Lion</option>
                <option value="vierge">Vierge</option>
                <option value="balance">Balance</option>
                <option value="scorpion">Scorpion</option>
                <option value="sagittaire">Sagittaire</option>
                <option value="capricorne">Capricorne</option>
                <option value="verseau">Verseau</option>
                <option value="poissons">Poissons</option>
            </select>
            <button type="submit">Voir l\'horoscope</button>
        </form>';
    }
    ?>

    <br>
    <a href="horoscope.html">Retourner au menu</a>
</body>
</html>
