<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Postulante - Kullakita HR</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Compiled Vite Assets (Tailwind CSS v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col justify-center items-center bg-slate-950 antialiased px-4 py-8 selection:bg-indigo-600 selection:text-white">

    <!-- Main Clean Container Card -->
    <div class="w-full max-w-lg bg-white border border-slate-200/90 rounded-2xl p-8 shadow-2xl space-y-6 relative overflow-hidden">
        
        <!-- Header -->
        <div class="text-center pt-2">
            <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-slate-900 text-white mb-3 shadow-xs">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Registro de Postulante</h1>
            <p class="text-xs text-slate-500 mt-1">Crea tu perfil para acceder a tus pruebas de selección y convocatorias</p>
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
                <label for="full_name" class="block text-xs font-semibold text-slate-700 mb-1">Nombre Completo *</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                       placeholder="Ej. Juan Pérez López"
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-normal">
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Correo Electrónico *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       placeholder="postulante@ejemplo.com"
                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-normal">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Contraseña *</label>
                    <input type="password" id="password" name="password" required
                           placeholder="Mínimo 8 caracteres"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Confirmar Contraseña *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           placeholder="Repite la contraseña"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1">Teléfono / Celular</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           placeholder="+591 70000000"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
                <div>
                    <label for="applied_position" class="block text-xs font-semibold text-slate-700 mb-1">Puesto al que Postulas *</label>
                    <input type="text" id="applied_position" name="applied_position" value="{{ old('applied_position') }}" required
                           placeholder="Ej. Desarrollador Laravel"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
            </div>

            <button type="submit" class="w-full py-2.5 mt-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                Crear Perfil y Comenzar
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 underline ml-1">Inicia sesión</a>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="mt-6 text-center text-xs text-slate-500 font-normal">
        Fundación Munasim Kullakita &bull; Gestión de Selección &copy; {{ date('Y') }}
    </div>

</body>
</html>
