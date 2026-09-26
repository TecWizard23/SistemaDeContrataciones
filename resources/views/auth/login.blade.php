<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Kullakita HR Analytics</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        kenjo: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            400: '#4ade80',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col justify-center items-center bg-slate-50 antialiased px-4 py-8 selection:bg-kenjo-500 selection:text-white"
      x-data="{ email: '{{ old('email') }}', password: '' }">

    <!-- Main Clean Container Card -->
    <div class="w-full max-w-md bg-white border border-slate-200 rounded-3xl p-8 shadow-xl shadow-slate-200/50 space-y-6 relative overflow-hidden">
        
        <!-- Top Mint Accent Strip -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-kenjo-400 via-kenjo-500 to-emerald-600"></div>

        <!-- Header & Brand Logo (Kenjo Style) -->
        <div class="text-center pt-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-kenjo-50 border border-kenjo-200 text-kenjo-600 mb-3 shadow-xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kullakita</h1>
            <p class="text-xs font-semibold text-kenjo-700 bg-kenjo-50 px-3 py-1 rounded-full border border-kenjo-200 inline-block mt-1">
                HR Selection & Competency Radar
            </p>
        </div>

        <!-- Session Alert Messages -->
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium space-y-1">
                <div class="font-bold">Error de autenticación:</div>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico</label>
                <div class="relative">
                    <input type="email" id="email" name="email" x-model="email" required autofocus
                           placeholder="rrhh@kullakita.org"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Contraseña</label>
                <div class="relative">
                    <input type="password" id="password" name="password" x-model="password" required
                           placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-600 pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-kenjo-600 border-slate-300 rounded focus:ring-kenjo-500">
                    <span>Recordarme</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-kenjo-600 hover:bg-kenjo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-kenjo-500/20 transition-all cursor-pointer">
                Iniciar Sesión
            </button>
        </form>

        <!-- Quick 1-Click Demo Credential Fill Buttons -->
        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
            <div class="text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-kenjo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Acceso Rápido de Demo (1-clic):
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" @click="email = 'rrhh@kullakita.org'; password = 'password123'"
                        class="px-2.5 py-1.5 bg-white hover:bg-kenjo-50 border border-slate-200 text-[11px] font-semibold text-slate-700 rounded-lg shadow-2xs hover:border-kenjo-300 hover:text-kenjo-700 transition-all text-left">
                    🔑 Rol RRHH
                </button>
                <button type="button" @click="email = 'postulante@kullakita.org'; password = 'password123'"
                        class="px-2.5 py-1.5 bg-white hover:bg-indigo-50 border border-slate-200 text-[11px] font-semibold text-slate-700 rounded-lg shadow-2xs hover:border-indigo-300 hover:text-indigo-700 transition-all text-left">
                    👤 Postulante
                </button>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            ¿Eres un nuevo postulante?
            <a href="{{ route('register') }}" class="font-bold text-kenjo-600 hover:text-kenjo-700 underline ml-1">Regístrate aquí</a>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="mt-6 text-center text-xs text-slate-400 font-medium">
        Kullakita HR Analytics &bull; Estilo Kenjo HR &copy; {{ date('Y') }}
    </div>

</body>
</html>
