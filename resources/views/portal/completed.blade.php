@extends('layouts.fmk')

@section('title', 'Evaluación Completada - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-2xl mx-auto my-8">
    <div class="bg-white border border-slate-200/90 rounded-2xl p-8 sm:p-10 shadow-xs text-center space-y-6 relative overflow-hidden">
        
        <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center mx-auto shadow-2xs">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <div class="space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wider">
                Examen Finalizado
            </span>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Evaluación Registrada con Éxito</h1>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-md mx-auto font-normal">
                Muchas gracias por completar la prueba <strong class="text-slate-900 font-semibold">{{ $session->evaluation->title }}</strong>. Tus respuestas se han enviado al equipo de Selección de la Fundación Munasim Kullakita.
            </p>
        </div>

        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 max-w-md mx-auto space-y-1 font-normal">
            <div>Fecha de envío: <strong class="text-slate-900">{{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s') }}</strong></div>
            <div>Estado del proceso: <span class="text-emerald-700 font-semibold">En revisión por reclutamiento FMK</span></div>
        </div>

        <div class="pt-2">
            <a href="{{ route('portal.index') }}" 
               class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs shadow-xs transition-all inline-flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Volver al Portal del Postulante</span>
            </a>
        </div>
    </div>
</div>
@endsection
