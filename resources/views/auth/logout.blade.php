<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrando sesión</title>
    <meta http-equiv="refresh" content="3.5;url={{ route('logout.perform') }}">

    <style>
        :root {
            --primary: #f1f5f9;
            --accent: #38bdf8;
            --accent-glow: rgba(56, 189, 248, 0.35);
            --bg: #0b1120;
            --text-muted: #94a3b8;
            --track-bg: #1e293b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 32px 24px;
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: radial-gradient(circle at 50% 25%, #172544 0%, var(--bg) 72%);
            color: var(--primary);
            overflow-x: hidden;
            animation: fadeOut 0.5s ease-in-out forwards;
            animation-delay: 3s;
        }

        .fullscreen-stage {
            width: 100%;
            max-width: 960px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            animation: stageEntrance 0.65s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* Escena amplia a gran escala */
        .scene {
            width: 100%;
            max-width: 760px;
            height: auto;
            max-height: 360px;
            margin-bottom: 24px;
            overflow: visible;
        }

        .person-main {
            animation: walkOut 3.2s ease-in-out forwards;
        }

        .person-companion {
            animation: walkOutCompanion 3.2s ease-in-out forwards;
        }

        .bob {
            animation: stepBob 0.45s ease-in-out infinite alternate;
        }

        .bob-delay {
            animation: stepBob 0.45s ease-in-out 0.2s infinite alternate;
        }

        .door-light {
            animation: doorGlow 3.2s ease-in-out forwards;
        }

        h1 {
            font-weight: 700;
            font-size: clamp(2rem, 4.5vw, 3.25rem);
            margin: 0;
            letter-spacing: -0.8px;
            color: var(--primary);
        }

        p {
            color: var(--text-muted);
            font-size: clamp(1rem, 1.8vw, 1.25rem);
            margin: 12px 0 32px;
            max-width: 580px;
            line-height: 1.5;
        }

        /* Barra de progreso amplia */
        .progress-wrapper {
            width: 100%;
            max-width: 520px;
        }

        .progress-track {
            width: 100%;
            height: 6px;
            background-color: var(--track-bg);
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #38bdf8, #818cf8);
            border-radius: 99px;
            box-shadow: 0 0 14px var(--accent-glow);
            animation: fillProgress 3s linear forwards;
        }

        .skip-link {
            display: inline-block;
            margin-top: 22px;
            font-size: 0.95rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .skip-link:hover {
            color: var(--accent);
        }

        /* Keyframes */
        @keyframes walkOut {
            0% { transform: translateX(-80px); opacity: 0; }
            15% { opacity: 1; }
            75% { transform: translateX(135px); opacity: 1; }
            100% { transform: translateX(185px); opacity: 0; }
        }

        @keyframes walkOutCompanion {
            0% { transform: translateX(-125px); opacity: 0; }
            20% { opacity: 0.85; }
            80% { transform: translateX(100px); opacity: 0.85; }
            100% { transform: translateX(155px); opacity: 0; }
        }

        @keyframes stepBob {
            from { transform: translateY(0px); }
            to { transform: translateY(-6px); }
        }

        @keyframes doorGlow {
            0%, 40% { opacity: 0.18; }
            75% { opacity: 0.72; }
            100% { opacity: 0.15; }
        }

        @keyframes fillProgress {
            from { width: 0%; }
            to { width: 100%; }
        }

        @keyframes stageEntrance {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            to { opacity: 0; }
        }
    </style>
</head>
<body>

    <main class="fullscreen-stage">
        <!-- Ilustración vectorial amplia en modo oscuro -->
        <svg class="scene" viewBox="0 0 600 240" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Suelo de toda la escena -->
            <line x1="40" y1="204" x2="560" y2="204" stroke="#334155" stroke-width="3" stroke-linecap="round"/>

            <!-- Marco de puerta de salida grande (derecha) -->
            <rect x="415" y="42" width="82" height="162" rx="6" fill="#1e293b" stroke="#94a3b8" stroke-width="3.5"/>
            <!-- Luz exterior de la puerta -->
            <rect class="door-light" x="421" y="48" width="70" height="151" fill="#38bdf8"/>
            <!-- Indicador superior de salida -->
            <rect x="434" y="18" width="44" height="14" rx="3" fill="#34d399"/>
            <!-- Puerta entreabierta en perspectiva -->
            <polygon points="497,42 468,54 468,192 497,204" fill="#0f172a"/>
            <circle cx="474" cy="126" r="3" fill="#e2e8f0"/>

            <!-- Persona 2 (Compañero/a de trabajo detrás) -->
            <g class="person-companion">
                <g class="bob-delay">
                    <circle cx="195" cy="92" r="14" fill="#64748b"/>
                    <path d="M176 116C176 111 180 108 185 108H205C210 108 214 111 214 116V158H176V116Z" fill="#64748b"/>
                    <line x1="186" y1="158" x2="179" y2="202" stroke="#64748b" stroke-width="7" stroke-linecap="round"/>
                    <line x1="204" y1="158" x2="212" y2="202" stroke="#64748b" stroke-width="7" stroke-linecap="round"/>
                </g>
            </g>

            <!-- Persona 1 (Principal con maletín saliendo del trabajo) -->
            <g class="person-main">
                <g class="bob">
                    <circle cx="255" cy="82" r="16" fill="#e2e8f0"/>
                    <path d="M235 108C235 103 239 100 244 100H266C271 100 275 103 275 108V158H235V108Z" fill="#cbd5e1"/>
                    <polygon points="255,102 251,124 255,130 259,124" fill="#38bdf8"/>
                    <line x1="246" y1="158" x2="236" y2="202" stroke="#cbd5e1" stroke-width="8" stroke-linecap="round"/>
                    <line x1="264" y1="158" x2="276" y2="202" stroke="#cbd5e1" stroke-width="8" stroke-linecap="round"/>
                    <line x1="268" y1="112" x2="282" y2="144" stroke="#cbd5e1" stroke-width="7" stroke-linecap="round"/>
                    <rect x="272" y="142" width="28" height="20" rx="4" fill="#38bdf8"/>
                    <path d="M280 142V138C280 136.3 281.3 135 283 135H289C290.7 135 292 136.3 292 138V142" stroke="#e2e8f0" stroke-width="2.5"/>
                </g>
            </g>
        </svg>

        <h1 id="logout-title">Cerrando sesión...</h1>
        <p id="logout-subtitle">¡Buen trabajo hoy! Estamos cerrando tu jornada de forma segura.</p>

        <div class="progress-wrapper">
            <div class="progress-track">
                <div class="progress-fill"></div>
            </div>
        </div>

        <a href="{{ route('logout.perform') }}" id="logout-now" class="skip-link">Salir ahora</a>
    </main>

    <script>
        const mensajes = [
            {
                titulo: "Cerrando sesión...",
                subtitulo: "¡Buen trabajo hoy! Estamos cerrando tu jornada de forma segura."
            },
            {
                titulo: "¡Hasta pronto!",
                subtitulo: "Guardando tus últimos cambios antes de salir."
            },
            {
                titulo: "Jornada finalizada",
                subtitulo: "Tu sesión se está cerrando correctamente. ¡Que descanses!"
            }
        ];

        const elegido = mensajes[Math.floor(Math.random() * mensajes.length)];
        document.getElementById('logout-title').textContent = elegido.titulo;
        document.getElementById('logout-subtitle').textContent = elegido.subtitulo;

        const logoutUrl = @json(route('logout.perform'));
        let redirigiendo = false;

        function irALogout() {
            if (redirigiendo) return;
            redirigiendo = true;
            window.location.href = logoutUrl;
        }

        setTimeout(irALogout, 3000);

        document.getElementById('logout-now').addEventListener('click', function (e) {
            e.preventDefault();
            irALogout();
        });
    </script>

</body>
</html>