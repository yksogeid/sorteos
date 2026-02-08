<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gana con Kelvin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <header class="bg-sorteo-dark py-4 text-center">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center">
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://img.icons8.com/color/48/clover.png" alt="clover" class="w-8 h-8">
                    <h1 class="text-white text-2xl font-bold italic">GANA <span class="bg-sorteo-green px-1">CON
                            KELVIN</span></h1>
                </div>
                <a href="{{ route('buscar') }}"
                    class="bg-sorteo-green text-white font-bold py-2 px-6 rounded-sm text-sm uppercase hover:bg-green-600 transition">
                    Busca aquí tus números
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-sorteo-dark text-white pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="https://img.icons8.com/color/48/clover.png" alt="clover" class="w-8 h-8">
                        <h2 class="text-white text-xl font-bold italic">GANA <span class="bg-sorteo-green px-1">CON
                                KELVIN</span></h2>
                    </div>
                </div>
                <div class="text-gray-400 text-sm flex flex-col items-center md:items-end text-center md:text-right">
                    <p class="flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg> CARRERA 20 #21 54</p>
                    <p class="flex items-center gap-2 mt-2"><svg class="w-4 h-4" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12.01 2.01c-5.52 0-9.99 4.47-9.99 9.99 0 2.01.5 3.92 1.39 5.61l-1.41 5.15 5.28-1.38c1.61.81 3.42 1.28 5.34 1.28 5.51 0 10.01-4.48 10.01-10s-4.5-10.01-10.02-10.01zm5.22 14.12c-.22.61-1.29 1.14-1.78 1.21-.49.07-.98.05-1.49-.07-.33-.08-.75-.25-1.57-.59-3.48-1.44-5.74-4.82-5.91-5.05s-1.42-1.92-1.42-3.67c0-1.75.91-2.61 1.25-2.95s.7-.44.93-.44h.63c.22 0 .52-.08.82.63.31.75 1.05 2.62 1.14 2.82.09.19.16.42.03.68-.13.26-.2.43-.39.66-.19.23-.42.5-.59.68-.2.19-.41.4-.17.8.23.4.99 1.63 2.11 2.63 1.45 1.29 2.67 1.69 3.05 1.88.38.19.61.16.84-.1.23-.26.98-1.14 1.25-1.53.26-.4.52-.33.88-.2.36.13 2.3 1.08 2.7 1.28.4.2 1 .3 1.13.53s.13 1.18-.09 1.79z" />
                        </svg> +573045864456</p>
                    <p class="flex items-center gap-2 mt-2"><svg class="w-4 h-4" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg> ventas@ganaconkelvin.com</p>
                    <p class="flex items-center gap-2 mt-2"><svg class="w-4 h-4" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                        </svg> Términos y condiciones</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center text-xs text-gray-500">
                Copyright 2026 Gana con kelvin. Todos los derechos reservados | <a href="{{ route('admin.index') }}"
                    class="hover:text-white">Panel Admin</a>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>