<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gana con Kelvin</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-sorteo-dark min-h-screen flex items-center justify-center font-sans">
    <div class="max-w-md w-full p-8 bg-white rounded-xl shadow-2xl">
        <div class="flex flex-col items-center mb-8">
            <img src="https://img.icons8.com/color/96/clover.png" alt="clover" class="w-16 h-16 mb-4">
            <h1 class="text-2xl font-bold italic text-gray-800 uppercase tracking-wider">Acceso <span
                    class="text-sorteo-green">Admin</span></h1>
            <p class="text-gray-500 text-sm mt-2">Ingresa tus credenciales para gestionar el sistema</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Correo Electrónico</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-sorteo-green focus:ring-2 focus:ring-sorteo-green focus:ring-opacity-50 transition"
                    placeholder="admin@ejemplo.com">
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Contraseña</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-sorteo-green focus:ring-2 focus:ring-sorteo-green focus:ring-opacity-50 transition"
                    placeholder="••••••••">
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-sorteo-dark text-white font-bold py-4 rounded-lg uppercase tracking-widest hover:bg-sorteo-green transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ url('/') }}"
                class="text-sm text-gray-400 hover:text-gray-600 transition flex items-center justify-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al sitio público
            </a>
        </div>
    </div>
</body>

</html>