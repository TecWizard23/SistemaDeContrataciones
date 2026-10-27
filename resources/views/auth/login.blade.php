<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Fundación Munasim Kullakita</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Compiled Vite Assets (Tailwind CSS v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full min-h-screen bg-slate-950 flex items-center justify-center p-0 sm:p-4 selection:bg-indigo-600 selection:text-white"
      x-data="{ 
          email: '{{ old('email') }}', 
          password: '', 
          showPassword: false,
          fillDemo(userEmail, userPass) {
              this.email = userEmail;
              this.password = userPass;
          }
      }">

    <!-- Split Screen Main Wrapper -->
    <div class="w-full max-w-5xl min-h-screen sm:min-h-[620px] bg-white sm:rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 border border-slate-800">

        <!-- Left Visual Brand Column (5 Cols) -->
        <div class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-10 text-white flex-col justify-between relative overflow-hidden border-r border-slate-800">
            <!-- Decorative Backing Shapes -->
            <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-slate-800/40 blur-3xl pointer-events-none"></div>

            <div class="space-y-6 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20 shadow-xs">
                        <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold uppercase tracking-widest text-indigo-300 block">Plataforma RRHH</span>
                        <h2 class="text-base font-bold tracking-tight text-white leading-tight">Fundación Munasim Kullakita</h2>
                    </div>
                </div>

                <div class="pt-6 space-y-3">
                    <span class="px-2.5 py-1 bg-indigo-500/20 rounded-full text-[10px] font-semibold uppercase tracking-wider border border-indigo-400/30 text-indigo-200">
                        Gestión del Talento Humano
                    </span>
                    <h3 class="text-2xl font-bold tracking-tight leading-snug text-white">
                        Evaluaciones Psicométricas & Selección por Competencias
                    </h3>
                    <p class="text-xs text-slate-300 font-normal leading-relaxed">
                        Sistema integral para la evaluación de aptitudes cognitivas, perfiles conductuales DISC y análisis comparativo para convocatorias laborales.
                    </p>
                </div>

                <!-- Feature Badges -->
                <div class="space-y-2.5 pt-2">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 backdrop-blur-xs border border-white/10">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-xs">
                            <span class="font-semibold text-white block">Evaluaciones Estandarizadas</span>
                            <span class="text-[11px] text-slate-400">Pruebas psicométricas con cálculo automático de % de ajuste</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 backdrop-blur-xs border border-white/10">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                            </svg>
                        </div>
                        <div class="text-xs">
                            <span class="font-semibold text-white block">Radares de Competencias</span>
                            <span class="text-[11px] text-slate-400">Comparación simultánea multi-candidato para selección</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Institutional Security Seal -->
            <div class="pt-6 border-t border-white/10 flex items-center justify-between text-[11px] text-slate-400 font-medium relative z-10">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Seguridad y Encriptación</span>
                </span>
                <span>La Paz &bull; Bolivia</span>
            </div>
        </div>

        <!-- Right Login Form Column (7 Cols) -->
        <div class="lg:col-span-7 p-6 sm:p-12 flex flex-col justify-between bg-white">
            
            <div class="max-w-md mx-auto w-full space-y-6">

                <!-- Header Mobile Logo & Titles -->
                <div class="space-y-1">
                    <div class="flex items-center gap-2 lg:hidden mb-4">
                        <div class="w-8 h-8 rounded-xl bg-slate-900 flex items-center justify-center text-white">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <span class="font-bold text-sm text-slate-900">Fundación Munasim Kullakita</span>
                    </div>

                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Acceso a la Plataforma</h2>
                    <p class="text-xs text-slate-500 font-normal">Ingresa tus credenciales para acceder a tu panel de gestión o portal.</p>
                </div>

                <!-- 1-Click Fast Fill Demo Buttons -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/90 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-600 flex items-center gap-1.5 uppercase tracking-wider">
                            <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>Acceso Rápido Demo</span>
                        </span>
                        <span class="text-[10px] text-slate-400 font-medium">1 clic</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" @click="fillDemo('rrhh@kullakita.org', 'password123')"
                                class="px-3 py-1.5 bg-white hover:bg-slate-100 border border-slate-200 text-slate-800 rounded-lg text-xs font-semibold transition-all shadow-2xs flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <span>Reclutador RRHH</span>
                        </button>

                        <button type="button" @click="fillDemo('postulante@kullakita.org', 'password123')"
                                class="px-3 py-1.5 bg-white hover:bg-slate-100 border border-slate-200 text-slate-800 rounded-lg text-xs font-semibold transition-all shadow-2xs flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Postulante</span>
                        </button>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2 animate-block-enter">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium space-y-1 animate-block-enter">
                        <div class="font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Error de acceso:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 text-red-700 pl-4">
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
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" x-model="email" required autofocus
                                   placeholder="tu-correo@kullakita.org"
                                   class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-normal">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Contraseña</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" x-model="password" required
                                   placeholder="Ingresa tu contraseña"
                                   class="w-full pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-normal">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>

                            <!-- Password Visibility Toggle (Eye SVG) -->
                            <button type="button" @click="showPassword = !showPassword" 
                                     class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors p-1"
                                     title="Mostrar u ocultar contraseña">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-600 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="font-normal">Recordar mi sesión</span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-xs transition-all cursor-pointer flex items-center justify-center gap-2">
                        <span>Iniciar Sesión</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                    <span>¿Eres un nuevo postulante?</span>
                    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 underline">
                        Regístrate para convocatorias
                    </a>
                </div>

            </div>

            <!-- Bottom Security Notice -->
            <div class="pt-6 text-center text-[11px] text-slate-400 font-medium">
                Acceso protegido por rate-limiting y sentencias preparadas PDO &bull; FMK &copy; {{ date('Y') }}
            </div>

        </div>

    </div>

</body>
</html>
