<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer consumo de API con PHP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-300">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center p-4">Primer consumo de API con PHP</h1>
        <div class="grid grid-cols-5 gap-4 mt-4">
            <form action="action.php" method="get" class="col-span-5 flex flex-col items-center space-y-4">
                <input type="text" name="query" class="w-50 p-2 border border-gray-300 rounded-lg" placeholder="Buscar en Spotify">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg block">Buscar</button>
            </form>
        </div>
    </div>
</body>

</html>