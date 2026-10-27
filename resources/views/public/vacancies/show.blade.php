@extends('layouts.fmk')

@section('title', $vacancy->title . ' - Convocatoria Fundación Munasim Kullakita')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto py-4">

    <!-- Top Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('public.vacancies.index') }}" 
           class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#00a8cc] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Volver a todas las convocatorias</span>
        </a>

        <span class="text-xs font-extrabold px-3 py-1 rounded-full border {{ $vacancy->status === 'OPEN' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
            {{ $vacancy->status === 'OPEN' ? 'Convocatoria Abierta' : 'Convocatoria Finalizada' }}
        </span>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Vacancy Hero Header -->
    <div class="bg-gradient-to-r from-[#00a8cc] via-[#059669] to-[#10b981] rounded-3xl p-8 sm:p-10 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="space-y-3 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[11px] font-extrabold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                        {{ $vacancy->department }}
                    </span>
                    <span class="text-[11px] font-bold px-3 py-1 bg-black/20 rounded-full border border-white/20">
                        {{ $vacancy->location }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                    {{ $vacancy->title }}
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 font-medium leading-relaxed">
                    Fundación Munasim Kullakita busca profesionales comprometidos con el bienestar, la protección integral y el desarrollo social.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 text-center flex-shrink-0 min-w-[160px]">
                <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-100">Vacantes Disponibles</div>
                <div class="text-3xl font-extrabold mt-0.5 text-white">{{ $vacancy->openings_count }}</div>
                <div class="text-[11px] text-emerald-200 mt-1 font-semibold">{{ $vacancy->contract_type }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content & Application Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Job Details & Requirements (7 cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Highlights Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Remuneración</span>
                    <span class="text-xs font-extrabold text-[#059669] mt-0.5 block">{{ $vacancy->salary_range ?? 'A convenir' }}</span>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Modalidad</span>
                    <span class="text-xs font-extrabold text-slate-800 mt-0.5 block">{{ $vacancy->contract_type }}</span>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs col-span-2 sm:col-span-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Fecha Límite</span>
                    <span class="text-xs font-extrabold text-slate-800 mt-0.5 block">
                        {{ $vacancy->closing_date ? $vacancy->closing_date->format('d/m/Y') : 'Hasta cubrir plazas' }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4">
                <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-4 h-4 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Descripción del Puesto & Responsabilidades</span>
                </h2>
                <div class="text-xs text-slate-600 leading-relaxed space-y-2 whitespace-pre-line font-medium">
                    {{ $vacancy->description ?: "El profesional seleccionado formará parte del equipo técnico de la Fundación Munasim Kullakita, ejecutando actividades orientadas a la atención, evaluación, acompañamiento y empoderamiento de niñas, niños, adolescentes y familias beneficiarias." }}
                </div>
            </div>

            <!-- Requirements -->
            @if($vacancy->requirements)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4">
                    <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                        <svg class="w-4 h-4 text-[#00a8cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span>Requisitos del Perfil & Competencias</span>
                    </h2>
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line font-medium">
                        {{ $vacancy->requirements }}
                    </div>
                </div>
            @endif

            <!-- Share Job & QR Card -->
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1">
                    <h3 class="text-xs font-bold text-slate-800">¿Conoces a alguien ideal para este puesto?</h3>
                    <p class="text-[11px] text-slate-500">Comparte esta convocatoria laboral directamente por WhatsApp o redes sociales.</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Convocatoria laboral en Fundación Munasim Kullakita: ' . $vacancy->title . '. Postúlate aquí: ' . request()->url()) }}" 
                       target="_blank" 
                       class="px-3.5 py-2 bg-[#25D366] hover:bg-[#20ba59] text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-2xs">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm5.78 14.07c-.24.68-1.39 1.3-1.92 1.38-.49.07-1.12.1-3.23-.77-2.69-1.11-4.42-3.83-4.56-4.01-.13-.18-1.09-1.45-1.09-2.77 0-1.31.69-1.96.93-2.22.25-.26.54-.33.72-.33.18 0 .36 0 .52.01.17.01.39-.06.61.46.23.54.77 1.88.84 2.02.07.14.12.31.02.5-.09.19-.14.31-.28.47-.14.16-.3.35-.43.47-.14.14-.29.3-.13.57.17.27.74 1.22 1.59 1.98 1.09.97 2.01 1.27 2.3 1.41.28.14.45.12.62-.07.17-.19.72-.84.91-1.13.19-.29.39-.24.65-.14.26.1 1.66.78 1.94.92.29.14.48.21.55.33.07.12.07.7-.17 1.38z"/>
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                    <button type="button" 
                            onclick="navigator.clipboard.writeText('{{ request()->url() }}'); alert('Enlace de postulación copiado.');"
                            class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span>Copiar Link</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Right Column: Interactive Postulation Form (5 cols) -->
        <div class="lg:col-span-5 sticky top-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border-2 border-[#059669]/30 shadow-xl space-y-6">
                
                <div class="space-y-1">
                    <span class="text-[10px] font-extrabold px-3 py-1 bg-emerald-100 text-[#059669] rounded-full border border-emerald-200 uppercase tracking-wider">
                        Postulación Inmediata
                    </span>
                    <h3 class="text-xl font-extrabold text-slate-900 tracking-tight pt-1">
                        Formulario de Postulación
                    </h3>
                    <p class="text-xs text-slate-500">
                        Completa tus datos para postular y ser derivado a las evaluaciones psicotécnicas del cargo.
                    </p>
                </div>

                @if($vacancy->status !== 'OPEN')
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold text-center">
                        Esta convocatoria se encuentra cerrada o en fase de deliberación.
                    </div>
                @elseif(Auth::check() && Auth::user()->isCandidate())
                    <!-- Logged in candidate postulation -->
                    <div class="space-y-4 bg-emerald-50/50 p-5 rounded-2xl border border-emerald-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#059669] text-white flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">{{ Auth::user()->name }}</div>
                                <div class="text-[11px] text-slate-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600">
                            Has iniciado sesión como postulante. Al hacer clic en el botón confirmarás tu interés en la vacante <strong>{{ $vacancy->title }}</strong>.
                        </p>

                        <form method="POST" action="{{ route('public.vacancies.apply', $vacancy) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full py-3 bg-[#059669] hover:bg-[#047857] text-white font-extrabold rounded-xl text-xs shadow-md hover:shadow-lg transition-all cursor-pointer active:scale-98 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Confirmar Postulación a este Cargo</span>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Public guest postulation form -->
                    <form method="POST" action="{{ route('public.vacancies.apply', $vacancy) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nombre Completo *</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="Ej. Lic. Andrea Condori Flores" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-medium">
                            @error('full_name') <span class="text-[10px] text-red-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="andrea@gmail.com" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-medium">
                                @error('email') <span class="text-[10px] text-red-500 font-semibold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Teléfono / WhatsApp *</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+591 71234567" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-medium">
                                @error('phone') <span class="text-[10px] text-red-500 font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Ciudad de Residencia</label>
                                <input type="text" name="city" value="{{ old('city', $vacancy->location) }}" placeholder="La Paz / El Alto" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-medium">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Años de Experiencia</label>
                                <input type="number" name="experience_years" min="0" max="40" value="{{ old('experience_years', 2) }}" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nivel Educativo</label>
                            <select name="education_level" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-semibold">
                                <option value="Licenciatura">Licenciatura / Titulado</option>
                                <option value="Egresado">Egresado</option>
                                <option value="Diplomado / Maestría">Diplomado / Maestría</option>
                                <option value="Técnico Superior">Técnico Superior</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Enlace a LinkedIn o CV Digital (opcional)</label>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/tu-perfil" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all font-medium">
                        </div>

                        <div class="pt-2 border-t border-slate-100">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Crear Contraseña de Acceso al Portal de Pruebas</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">Contraseña *</label>
                                    <input type="password" name="password" required placeholder="Mínimo 6 caracteres" 
                                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all">
                                    @error('password') <span class="text-[10px] text-red-500 font-semibold">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">Confirmar Contraseña *</label>
                                    <input type="password" name="password_confirmation" required placeholder="Repetir contraseña" 
                                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#059669] focus:bg-white transition-all">
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full py-3.5 bg-[#059669] hover:bg-[#047857] text-white font-extrabold rounded-2xl text-xs shadow-md hover:shadow-lg transition-all cursor-pointer active:scale-98 flex items-center justify-center gap-2 mt-2">
                            <span>Postularme Ahora & Rendir Evaluaciones</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                @endif

            </div>
        </div>

    </div>

</div>
@endsection
