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
        $date = date('Y-m-d'); // Utilisation de la date actuelle au format 'YYYY-MM-DD'
        $apiKey = '8501e1a789msh9ec9ffb634be5adp130a3ejsnf4b68454245a';
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://daily-horoscope3.p.rapidapi.com/api/1.0/get_daily_horoscope.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"sign\"\r\n\r\n$sign\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"date\"\r\n\r\n$date\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"api_key\"\r\n\r\n$apiKey\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"timezone\"\r\n\r\n5.5\r\n-----011000010111000001101001--\r\n\r\n",
            CURLOPT_HTTPHEADER => [
                "Content-Type: multipart/form-data; boundary=---011000010111000001101001",
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
    }
?>
    

    <br>
    <a href="horoscope.html">Retourner au menu</a>
</body>
</html>
