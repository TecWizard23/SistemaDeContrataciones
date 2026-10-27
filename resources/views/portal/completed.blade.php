@extends('layouts.fmk')

@section('title', 'Evaluación Completada - Fundación Munasim Kullakita')

@section('content')
<div class="max-w-2xl mx-auto my-8">
    <div class="bg-white border border-slate-200 rounded-3xl p-8 sm:p-10 shadow-xl text-center space-y-6 relative overflow-hidden">
        
        <!-- Top Mint Accent Strip -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-400 via-emerald-500 to-teal-600"></div>

        <div class="w-20 h-20 rounded-3xl bg-emerald-50 text-[#059669] border border-emerald-200 flex items-center justify-center mx-auto shadow-md shadow-emerald-500/10">
            <svg class="w-10 h-10 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <div class="space-y-2">
            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-50 text-[#059669] border border-emerald-200 uppercase tracking-wider">
                Examen Finalizado
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">¡Evaluación Registrada con Éxito!</h1>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-md mx-auto font-medium">
                Muchas gracias por completar la prueba <strong class="text-slate-900">{{ $session->evaluation->title }}</strong>. Tus respuestas se han enviado al equipo de Selección de la Fundación Munasim Kullakita.
            </p>
        </div>

        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-600 max-w-md mx-auto space-y-1 font-medium">
            <div>Fecha de envío: <strong class="text-slate-900">{{ $session->completed_at ? $session->completed_at->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s') }}</strong></div>
            <div>Estado del proceso: <span class="text-[#059669] font-bold">En revisión por reclutamiento FMK</span></div>
        </div>

        <div class="pt-2">
            <a href="{{ route('portal.index') }}" 
               class="px-8 py-3 bg-[#00a8cc] hover:bg-[#007b99] text-white font-extrabold rounded-xl text-xs shadow-md transition-all inline-flex items-center gap-2 cursor-pointer">
                <span>&larr; Volver al Portal del Postulante</span>
            </a>
        </div>
    </div>
</div>
@endsection
