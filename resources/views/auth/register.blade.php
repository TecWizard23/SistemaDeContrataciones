<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Postulante - Kullakita HR</title>

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
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col justify-center items-center bg-slate-50 antialiased px-4 py-8 selection:bg-kenjo-500 selection:text-white">

    <!-- Main Clean Container Card -->
    <div class="w-full max-w-lg bg-white border border-slate-200 rounded-3xl p-8 shadow-xl shadow-slate-200/50 space-y-6 relative overflow-hidden">
        
        <!-- Top Mint Accent Strip -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-kenjo-400 via-kenjo-500 to-emerald-600"></div>

        <!-- Header -->
        <div class="text-center pt-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-kenjo-50 border border-kenjo-200 text-kenjo-600 mb-3 shadow-xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Registro de Postulante</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Crea tu perfil para acceder a tus pruebas de selección</p>
        </div>

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium space-y-1">
                <div class="font-bold">Por favor corrige los siguientes errores:</div>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="full_name" class="block text-xs font-bold text-slate-700 mb-1">Nombre Completo *</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                       placeholder="Ej. Juan Pérez López"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       placeholder="postulante@ejemplo.com"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Contraseña *</label>
                    <input type="password" id="password" name="password" required
                           placeholder="Mínimo 8 caracteres"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1">Confirmar Contraseña *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           placeholder="Repite la contraseña"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">Teléfono / Celular</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           placeholder="+591 70000000"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
                </div>
                <div>
                    <label for="applied_position" class="block text-xs font-bold text-slate-700 mb-1">Puesto al que Postulas *</label>
                    <input type="text" id="applied_position" name="applied_position" value="{{ old('applied_position') }}" required
                           placeholder="Ej. Desarrollador Laravel"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-kenjo-500 focus:border-kenjo-500 focus:bg-white transition-all">
                </div>
            </div>

            <button type="submit" class="w-full py-3 mt-2 bg-kenjo-600 hover:bg-kenjo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-kenjo-500/20 transition-all cursor-pointer">
                Crear Perfil y Comenzar
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}" class="font-bold text-kenjo-600 hover:text-kenjo-700 underline ml-1">Inicia sesión</a>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="mt-6 text-center text-xs text-slate-400 font-medium">
        Kullakita HR Analytics &bull; Estilo Kenjo HR &copy; {{ date('Y') }}
    </div>

</body>
</html>
