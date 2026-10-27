@extends('layouts.fmk')

@section('title', 'Publicar Convocatoria Laboral - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Banner FMK -->
    <div class="bg-gradient-to-r from-[#00a8cc] to-[#059669] rounded-3xl p-6 sm:p-8 text-white shadow-lg flex items-center justify-between">
        <div>
            <span class="text-[11px] font-extrabold px-3 py-1 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                Nueva Convocatoria
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-2">Publicar Convocatoria Laboral</h1>
            <p class="text-xs sm:text-sm text-emerald-100 font-medium mt-1">
                Define los requisitos, ubicación y condiciones para abrir un nuevo proceso de selección en FMK.
            </p>
        </div>

        <a href="{{ route('vacancies.index') }}" 
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-[#00a8cc] hover:bg-sky-50 text-xs font-extrabold rounded-full shadow-xs transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Volver</span>
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium space-y-1">
            <div class="font-bold">Por favor corrige los siguientes errores:</div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <form action="{{ route('vacancies.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Título de la Convocatoria / Cargo *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ej. Psicólogo/a Especialista en Acompañamiento Social"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Área o Departamento *</label>
                    <input type="text" name="department" value="{{ old('department') }}" required placeholder="Ej. Protección y Bienestar Infantil"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ubicación de la Plaza *</label>
                    <input type="text" name="location" value="{{ old('location', 'La Paz') }}" required placeholder="Ej. La Paz / El Alto / Regional"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tipo de Contrato *</label>
                    <select name="contract_type" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-bold">
                        <option value="Tiempo Completo" {{ old('contract_type') == 'Tiempo Completo' ? 'selected' : '' }}>Tiempo Completo</option>
                        <option value="Medio Tiempo" {{ old('contract_type') == 'Medio Tiempo' ? 'selected' : '' }}>Medio Tiempo</option>
                        <option value="Consultoría por Producto" {{ old('contract_type') == 'Consultoría por Producto' ? 'selected' : '' }}>Consultoría por Producto</option>
                        <option value="Plazo Fijo" {{ old('contract_type') == 'Plazo Fijo' ? 'selected' : '' }}>Plazo Fijo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Número de Plazas Vacantes *</label>
                    <input type="number" name="openings_count" value="{{ old('openings_count', 1) }}" min="1" max="50" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Rango Salarial Referencial</label>
                    <input type="text" name="salary_range" value="{{ old('salary_range') }}" placeholder="Ej. 4.500 - 5.500 BOB"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Fecha Límite de Postulación</label>
                    <input type="date" name="closing_date" value="{{ old('closing_date') }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Estado Inicial *</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all font-bold">
                        <option value="OPEN" {{ old('status') == 'OPEN' ? 'selected' : '' }}>Abierta (Recibiendo Postulaciones)</option>
                        <option value="IN_REVIEW" {{ old('status') == 'IN_REVIEW' ? 'selected' : '' }}>En Selección / Revisión</option>
                        <option value="CLOSED" {{ old('status') == 'CLOSED' ? 'selected' : '' }}>Cerrada</option>
                    </select>
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Descripción de Funciones y Objetivo del Puesto *</label>
                    <textarea name="description" rows="4" required placeholder="Detalla los objetivos del cargo y responsabilidades clave..."
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Requisitos y Perfil del Postulante</label>
                    <textarea name="requirements" rows="4" placeholder="Grado de formación, años de experiencia laboral, competencias clave..."
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#00a8cc] focus:bg-white transition-all">{{ old('requirements') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('vacancies.index') }}" 
                   class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-7 py-2.5 bg-[#059669] hover:bg-[#047857] text-white font-extrabold rounded-xl text-xs shadow-md hover:shadow-lg transition-all cursor-pointer">
                    Publicar Convocatoria
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
