<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cerrando sesión</title>
    <meta http-equiv="refresh" content="5;url={{ route('logout.perform') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #2c3e50;
            /* Aplicamos la animación de salida */
            animation: fadeOut 0.5s ease-in-out forwards;
            animation-delay: 4.5s;
        }

        .container {
            text-align: center;
            animation: subtleFade 0.8s ease-out;
        }

        /* Spinner elegante */
        .loader {
            width: 40px;
            height: 40px;
            margin: 0 auto 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #2c3e50;
            border-radius: 50%;
            animation: spin 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }

        h2 {
            font-weight: 500;
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: -0.5px;
        }

        p {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-top: 8px;
        }

        /* Definición de Keyframes */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes subtleFade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            to { opacity: 0; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="loader"></div>
        <h2>Cerrando sesión</h2>
        <p>Estamos procesando su salida de forma segura.</p>
    </div>

</body>
</html>