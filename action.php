<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Resultados de la busqueda</title>
</head>

<body class="bg-gray-300">
    <?php
    function getSpotifyAccesToken()
    {
        $clientId = "2470acd4daaa4cff89d17f105ee754c3";
        $clientSecret =  "2de90a0993694c69aeb5931be2ac4d7c";
        $tokenUrl = "https://accounts.spotify.com/api/token";

        // Configurar la solicitud para obtener el token
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode("$clientId:$clientSecret"),
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutar la solicitud
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            throw new Exception("Error al obtener el token de acceso");
        }
        $data = json_decode($response, true);

        if (!isset($data['access_token'])) {
            throw new Exception("No se pudo obtener el token de acceso");
        }

        return $data['access_token'];
    }

    function getSpotifyData($query, $type = 'track')
    {
        $accessToken = getSpotifyAccesToken();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=" . urlencode($query) . "&type=$type");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    //capturamos el valor del input
    if (isset($_GET['query'])) {
        // Lógica Principal
        $query = $_GET['query'];
        echo "<h1 class='text-3xl font-bold text-center p-4'>Resultados de la búsqueda: $query</h1>";
        echo "<div class='grid grid-cols-4 gap-4 mt-4 p-4'>";
        try {
            $data = getSpotifyData($query);
            foreach ($data['tracks']['items'] as $track) {
                echo "<div class='bg-gray-100 p-4 rounded-lg shadow-md'>";
                echo "<img src='{$track['album']['images'][0]['url']}' class='w-full h-50 object-cover rounded-t-lg'>";
                echo "<h2 class='text-lg font-bold mt-2 truncate text-center'>{$track['name']}</h2>";
                echo "<p class='text-sm text-gray-700 text-center'>Artista: {$track['artists'][0]['name']}</p>";
                echo "<p class='text-sm text-gray-500 text-center'>Álbum: {$track['album']['name']}</p>";
                echo "</div>";
            }
            echo "</div>";
        } catch (Exception $e) {
            echo "<p class='text-red-500'>{$e->getMessage()}</p>";
        }
    } else {
        echo "<p class='text-red-500'>No se ha enviado un valor de búsqueda</p>";
    }

    ?>

</body>

</html>