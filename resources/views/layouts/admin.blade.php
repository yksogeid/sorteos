<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Gana con Kelvin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-[#f8fafc] font-sans antialiased text-slate-900" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen relative overflow-x-hidden">
        <!-- Overlay Móvil -->
        <div x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 left-0 w-72 bg-black text-white z-50 transition-transform duration-300 ease-in-out border-r border-slate-800">
            <div class="flex flex-col h-full">
                <!-- Logo Admin -->
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="https://img.icons8.com/color/48/clover.png" alt="clover" class="w-8 h-8">
                        <h1 class="text-xl font-black italic tracking-tighter uppercase leading-none">
                            Admin <span class="text-sorteo-green">Kelvin</span>
                        </h1>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Nav Links -->
                <nav class="flex-1 px-4 space-y-1 mt-4">
                    <a href="{{ route('admin.index') }}"
                        class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.index') ? 'bg-sorteo-green text-white shadow-lg shadow-green-900/20' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                        <span class="mr-3">📊</span> Dashboard
                    </a>
                    <a href="{{ route('admin.settings.index') }}"
                        class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.settings.index') ? 'bg-sorteo-green text-white shadow-lg shadow-green-900/20' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                        <span class="mr-3">⚙️</span> Configuración
                    </a>
                </nav>

                <!-- Footer Sidebar -->
                <div class="p-4 border-t border-slate-900">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-3 text-sm font-semibold text-red-400 hover:bg-red-500/10 rounded-xl transition-all">
                            <span class="mr-3">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Dynamic Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white border-b border-slate-200 h-20 flex items-center px-4 md:px-8 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden mr-4 text-slate-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-800">@yield('header')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex flex-col items-end">
                        <span
                            class="text-sm font-bold text-slate-900">{{ auth()->user()->name ?? 'Administrador' }}</span>
                        <span class="text-xs text-slate-500">Super Admin</span>
                    </div>
                    <div
                        class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-600 border border-slate-200">
                        A
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                        class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 shadow-sm rounded-r-xl">
                        <div class="flex">
                            <div class="flex-shrink-0">✅</div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>