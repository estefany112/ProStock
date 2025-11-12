<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Proserve</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 flex items-center justify-center h-screen text-white">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Sistema de Control de Inventario</h1>
        <h2 class="text-xl text-gray-300 mb-8">Proserve</h2>
        <a href="{{ route('login') }}" class="bg-blue-600 px-6 py-2 rounded-lg text-white hover:bg-blue-700">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="bg-green-600 px-6 py-2 rounded-lg text-white hover:bg-green-700 ml-4">Registrarse</a>
    </div>
</body>
</html>
