@extends('layouts.fmk')

@section('title', 'Mi Perfil Profesional - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-12">

    <!-- Executive Hero Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-2xl p-6 sm:p-8 text-white border border-slate-800 shadow-sm relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white font-extrabold text-2xl border border-white/20 shadow-xs">
                    {{ strtoupper(substr($candidate->full_name, 0, 1)) }}
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">{{ $candidate->full_name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 uppercase tracking-wider">
                            Postulante
                        </span>
                    </div>
                    <p class="text-xs text-slate-300">
                        Postulación actual: <strong class="text-white">{{ $candidate->applied_position }}</strong>
                    </p>
                    <p class="text-[11px] text-slate-400">
                        {{ $candidate->email }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('portal.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-xl border border-white/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Mis Pruebas</span>
                </a>
                <a href="{{ route('portal.my-results') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl shadow-xs transition-all">
                    <span>Ver Mis Resultados</span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium space-y-1">
            <div class="font-bold">Revisa los siguientes campos:</div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Form Card -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                <span>Datos Personales y Profesionales</span>
            </h2>
            <span class="text-xs text-slate-400 font-medium">Información para el equipo de selección</span>
        </div>

        <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre Completo *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $candidate->full_name) }}" required 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Correo Electrónico (No editable)</label>
                    <input type="email" value="{{ $candidate->email }}" disabled 
                           class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-500 font-medium cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Teléfono o Celular de Contacto</label>
                    <input type="text" name="phone" value="{{ old('phone', $candidate->phone) }}" placeholder="+591 70001122" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Ciudad de Residencia</label>
                    <input type="text" name="city" value="{{ old('city', $candidate->city) }}" placeholder="Ej. La Paz / El Alto / Cochabamba" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nivel Máximo de Formación</label>
                    <select name="education_level" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-medium">
                        <option value="">Selecciona nivel...</option>
                        <option value="Técnico Medio / Superior" {{ old('education_level', $candidate->education_level) == 'Técnico Medio / Superior' ? 'selected' : '' }}>Técnico Medio / Superior</option>
                        <option value="Licenciatura / Grado" {{ old('education_level', $candidate->education_level) == 'Licenciatura / Grado' ? 'selected' : '' }}>Licenciatura / Grado</option>
                        <option value="Diplomado / Especialidad" {{ old('education_level', $candidate->education_level) == 'Diplomado / Especialidad' ? 'selected' : '' }}>Diplomado / Especialidad</option>
                        <option value="Maestría / Postgrado" {{ old('education_level', $candidate->education_level) == 'Maestría / Postgrado' ? 'selected' : '' }}>Maestría / Postgrado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Años de Experiencia Relevante</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $candidate->experience_years) }}" min="0" max="50" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-semibold">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Enlace a Perfil Profesional (LinkedIn / Portafolio)</label>
                    <div class="relative">
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $candidate->linkedin_url) }}" placeholder="https://linkedin.com/in/tu-perfil" 
                               class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Extracto / Resumen de Experiencia Profesional</label>
                    <textarea name="summary" rows="4" placeholder="Describe brevemente tus fortalezas, experiencia en proyectos sociales o técnicos y motivación..." 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-normal leading-relaxed">{{ old('summary', $candidate->summary) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('portal.index') }}" 
                   class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs shadow-xs transition-all cursor-pointer">
                    Actualizar Perfil
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
