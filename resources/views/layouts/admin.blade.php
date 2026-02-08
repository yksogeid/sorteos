<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Gana con Kelvin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-sorteo-dark text-white">
            <div class="p-6">
                <div class="flex items-center gap-2 mb-8">
                    <img src="https://img.icons8.com/color/48/clover.png" alt="clover" class="w-8 h-8">
                    <h1 class="text-xl font-bold italic">Admin <span class="text-sorteo-green">Kelvin</span></h1>
                </div>
                <nav class="space-y-4">
                    <a href="{{ route('admin.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800 transition {{ request()->routeIs('admin.index') ? 'bg-sorteo-green' : '' }}">Dashboard</a>
                    <a href="{{ url('/') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition"
                        target="_blank">Ver Sitio</a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">Bienvenido, Admin</span>
                </div>
            </header>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>