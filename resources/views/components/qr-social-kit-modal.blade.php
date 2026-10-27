<!-- Modal Generador de QR y Kit de Redes Sociales FMK -->
<div id="qrKitModalWrapper" 
     x-data="qrSocialKitModal()" 
     x-init="init()"
     @open-qr-kit.window="openModal($event.detail)"
     x-show="isOpen" 
     x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">

    <!-- Backdrop -->
    <div x-show="isOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
         @click="closeModal()"></div>

    <!-- Modal Content -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6">
        <div x-show="isOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-slate-200">

            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-[#059669] via-[#00a8cc] to-[#2563eb] px-6 py-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-xs flex items-center justify-center border border-white/30 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-extrabold px-2.5 py-0.5 bg-white/20 rounded-full border border-white/30 uppercase tracking-wider">
                            Kit Reclutamiento & Difusión
                        </span>
                        <h3 class="text-lg font-extrabold tracking-tight mt-0.5" id="modal-title">
                            Generador de Código QR & Afiches de Redes Sociales
                        </h3>
                    </div>
                </div>

                <button @click="closeModal()" type="button" class="text-white/80 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-6">

                <!-- Vacancy Info Banner -->
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Convocatoria Seleccionada</div>
                        <h4 class="text-base font-extrabold text-slate-900" x-text="vacancy.title"></h4>
                        <div class="text-xs text-slate-500 font-medium flex items-center gap-2 mt-0.5">
                            <span x-text="vacancy.department"></span>
                            <span>•</span>
                            <span x-text="vacancy.location"></span>
                            <span x-show="vacancy.salary">• <strong class="text-[#059669]" x-text="vacancy.salary"></strong></span>
                        </div>
                    </div>

                    <!-- Color Selector -->
                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold">
                        <span class="text-slate-500 text-[11px] mr-1">Color QR:</span>
                        <button type="button" @click="setQrColor('#059669')" :class="qrColor === '#059669' ? 'ring-2 ring-offset-1 ring-[#059669]' : ''" class="w-5 h-5 rounded-full bg-[#059669] cursor-pointer" title="Verde FMK"></button>
                        <button type="button" @click="setQrColor('#00a8cc')" :class="qrColor === '#00a8cc' ? 'ring-2 ring-offset-1 ring-[#00a8cc]' : ''" class="w-5 h-5 rounded-full bg-[#00a8cc] cursor-pointer" title="Azul Turquesa"></button>
                        <button type="button" @click="setQrColor('#0f172a')" :class="qrColor === '#0f172a' ? 'ring-2 ring-offset-1 ring-[#0f172a]' : ''" class="w-5 h-5 rounded-full bg-[#0f172a] cursor-pointer" title="Negro Ébano"></button>
                    </div>
                </div>

                <!-- Tabs: Solo QR vs Afiche para Redes -->
                <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                    <button type="button" 
                            @click="switchTab('qr')" 
                            :class="activeTab === 'qr' ? 'bg-[#00a8cc] text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                            class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span>Código QR Directo</span>
                    </button>

                    <button type="button" 
                            @click="switchTab('flyer')" 
                            :class="activeTab === 'flyer' ? 'bg-[#059669] text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                            class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Afiche / Flyer Redes Sociales (1080x1080)</span>
                    </button>
                </div>

                <!-- Preview Area -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    
                    <!-- Left Column: Visual Canvas Preview -->
                    <div class="md:col-span-6 flex flex-col items-center justify-center p-4 bg-slate-100/70 rounded-2xl border border-slate-200 min-h-[320px]">
                        
                        <!-- QR Canvas View -->
                        <div x-show="activeTab === 'qr'" class="flex flex-col items-center">
                            <div class="p-4 bg-white rounded-2xl shadow-md border border-slate-200">
                                <canvas id="qrCanvas" width="240" height="240" class="max-w-full rounded-lg"></canvas>
                            </div>
                            <p class="text-[11px] font-semibold text-slate-500 mt-3 text-center">
                                Enlace directo para postulantes: Escanear con la cámara del celular.
                            </p>
                        </div>

                        <!-- Social Flyer Canvas View -->
                        <div x-show="activeTab === 'flyer'" class="flex flex-col items-center w-full">
                            <div class="p-2 bg-slate-900 rounded-2xl shadow-xl border border-slate-700 max-w-[320px] w-full">
                                <canvas id="flyerCanvas" width="1080" height="1080" class="w-full h-auto rounded-xl shadow-inner"></canvas>
                            </div>
                            <p class="text-[11px] font-semibold text-slate-500 mt-3 text-center">
                                Imagen optimizada para Instagram, LinkedIn, Facebook o impresión física.
                            </p>
                        </div>

                    </div>

                    <!-- Right Column: Actions & Social Sharing -->
                    <div class="md:col-span-6 space-y-5">
                        
                        <!-- Download Buttons -->
                        <div class="space-y-2.5">
                            <button type="button" 
                                    @click="downloadQR()" 
                                    class="w-full py-3 px-4 bg-[#00a8cc] hover:bg-[#007b99] text-white font-extrabold rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Descargar Código QR (PNG Alta Resolución)</span>
                            </button>

                            <button type="button" 
                                    @click="downloadFlyer()" 
                                    class="w-full py-3 px-4 bg-[#059669] hover:bg-[#047857] text-white font-extrabold rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Descargar Afiche / Flyer para Redes (PNG 1080x1080)</span>
                            </button>
                        </div>

                        <!-- Direct Copy Link -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Enlace Público de Postulación</label>
                            <div class="flex items-center gap-2">
                                <input type="text" 
                                       readonly 
                                       :value="vacancy.url" 
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-mono select-all">
                                
                                <button type="button" 
                                        @click="copyLink()" 
                                        class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <span x-text="copied ? '¡Copiado!' : 'Copiar'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- One-Click Social Media Shares -->
                        <div class="space-y-2 pt-2 border-t border-slate-100">
                            <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Publicación Rápida en Redes</span>
                            <div class="grid grid-cols-2 gap-2">
                                
                                <!-- WhatsApp -->
                                <button type="button" 
                                        @click="shareWhatsApp()" 
                                        class="py-2.5 px-3 bg-[#25D366] hover:bg-[#20ba59] text-white font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer shadow-xs">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm5.78 14.07c-.24.68-1.39 1.3-1.92 1.38-.49.07-1.12.1-3.23-.77-2.69-1.11-4.42-3.83-4.56-4.01-.13-.18-1.09-1.45-1.09-2.77 0-1.31.69-1.96.93-2.22.25-.26.54-.33.72-.33.18 0 .36 0 .52.01.17.01.39-.06.61.46.23.54.77 1.88.84 2.02.07.14.12.31.02.5-.09.19-.14.31-.28.47-.14.16-.3.35-.43.47-.14.14-.29.3-.13.57.17.27.74 1.22 1.59 1.98 1.09.97 2.01 1.27 2.3 1.41.28.14.45.12.62-.07.17-.19.72-.84.91-1.13.19-.29.39-.24.65-.14.26.1 1.66.78 1.94.92.29.14.48.21.55.33.07.12.07.7-.17 1.38z"/>
                                    </svg>
                                    <span>WhatsApp</span>
                                </button>

                                <!-- LinkedIn -->
                                <button type="button" 
                                        @click="shareLinkedIn()" 
                                        class="py-2.5 px-3 bg-[#0A66C2] hover:bg-[#084e96] text-white font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer shadow-xs">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                    <span>LinkedIn</span>
                                </button>

                                <!-- Facebook -->
                                <button type="button" 
                                        @click="shareFacebook()" 
                                        class="py-2.5 px-3 bg-[#1877F2] hover:bg-[#1464cc] text-white font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer shadow-xs">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <span>Facebook</span>
                                </button>

                                <!-- X / Twitter -->
                                <button type="button" 
                                        @click="shareTwitter()" 
                                        class="py-2.5 px-3 bg-slate-900 hover:bg-black text-white font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer shadow-xs">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                    <span>X (Twitter)</span>
                                </button>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end">
                <button type="button" @click="closeModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition-all cursor-pointer">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<script>
// Universal Polyfill for Canvas rounded rectangles
function drawUniversalRoundedRect(ctx, x, y, width, height, radius) {
    if (typeof ctx.roundRect === 'function') {
        ctx.beginPath();
        ctx.roundRect(x, y, width, height, radius);
        ctx.fill();
        return;
    }
    ctx.beginPath();
    ctx.moveTo(x + radius, y);
    ctx.lineTo(x + width - radius, y);
    ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
    ctx.lineTo(x + width, y + height - radius);
    ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
    ctx.lineTo(x + radius, y + height);
    ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
    ctx.lineTo(x, y + radius);
    ctx.quadraticCurveTo(x, y, x + radius, y);
    ctx.closePath();
    ctx.fill();
}

function qrSocialKitModal() {
    return {
        isOpen: false,
        activeTab: 'qr',
        qrColor: '#059669',
        copied: false,
        vacancy: {
            id: '',
            title: '',
            department: '',
            location: '',
            salary: '',
            contractType: '',
            url: window.location.origin + '/convocatorias'
        },

        init() {
            window.qrKitModalInstance = this;
        },

        openModal(detail) {
            this.isOpen = true;
            this.copied = false;
            if (detail) {
                this.vacancy = {
                    id: detail.id || '',
                    title: detail.title || 'Convocatoria Laboral FMK',
                    department: detail.department || 'Fundación Munasim Kullakita',
                    location: detail.location || 'La Paz / El Alto',
                    salary: detail.salary || '',
                    contractType: detail.contractType || 'Tiempo Completo',
                    url: detail.url || (window.location.origin + '/convocatorias' + (detail.id ? '/' + detail.id : ''))
                };
            }
            this.$nextTick(() => {
                this.renderAll();
            });
        },

        closeModal() {
            this.isOpen = false;
        },

        switchTab(tab) {
            this.activeTab = tab;
            this.$nextTick(() => {
                if (tab === 'flyer') {
                    this.renderFlyer();
                } else {
                    this.renderQR();
                }
            });
        },

        setQrColor(color) {
            this.qrColor = color;
            this.renderAll();
        },

        renderAll() {
            this.renderQR(() => {
                this.renderFlyer();
            });
        },

        renderQR(callback) {
            const qrCanvas = document.getElementById('qrCanvas');
            if (!qrCanvas) {
                setTimeout(() => this.renderQR(callback), 100);
                return;
            }

            const qrLib = window.QRCode || (window.QRCode && window.QRCode.default);
            if (!qrLib || typeof qrLib.toCanvas !== 'function') {
                console.warn('QRCode library not loaded yet, retrying...');
                setTimeout(() => this.renderQR(callback), 200);
                return;
            }

            try {
                qrLib.toCanvas(qrCanvas, this.vacancy.url, {
                    width: 240,
                    margin: 2,
                    color: {
                        dark: this.qrColor,
                        light: '#ffffff'
                    }
                }, (error) => {
                    if (error) {
                        console.error('Error generating QR on canvas:', error);
                    } else if (typeof callback === 'function') {
                        callback();
                    }
                });
            } catch(e) {
                console.error('QR toCanvas exception:', e);
            }
        },

        renderFlyer() {
            const flyerCanvas = document.getElementById('flyerCanvas');
            if (!flyerCanvas) return;

            const ctx = flyerCanvas.getContext('2d');
            const size = 1080;
            flyerCanvas.width = size;
            flyerCanvas.height = size;

            try {
                // Background Gradient (Deep Emerald to Midnight Blue)
                const bgGrad = ctx.createLinearGradient(0, 0, 0, size);
                bgGrad.addColorStop(0, '#064e3b');
                bgGrad.addColorStop(0.5, '#0f172a');
                bgGrad.addColorStop(1, '#022c22');
                ctx.fillStyle = bgGrad;
                ctx.fillRect(0, 0, size, size);

                // Subtle Gold Border Accent
                ctx.strokeStyle = '#f59e0b';
                ctx.lineWidth = 14;
                ctx.strokeRect(20, 20, size - 40, size - 40);

                // Inner Thin White Frame
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.15)';
                ctx.lineWidth = 2;
                ctx.strokeRect(36, 36, size - 72, size - 72);

                // Top Header: Organization Name
                ctx.textAlign = 'center';
                ctx.fillStyle = '#ffffff';
                ctx.font = '800 32px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('FUNDACIÓN MUNASIM KULLAKITA', size / 2, 95);

                // Sub-pill: CONVOCATORIA LABORAL ABIERTA
                ctx.fillStyle = '#fbbf24';
                ctx.font = '800 24px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('• CONVOCATORIA LABORAL ABIERTA •', size / 2, 140);

                // Divider Line
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
                ctx.beginPath();
                ctx.moveTo(120, 165);
                ctx.lineTo(size - 120, 165);
                ctx.stroke();

                // Vacancy Title (Wrapped if long)
                ctx.fillStyle = '#ffffff';
                ctx.font = '800 46px "Plus Jakarta Sans", sans-serif';
                const title = (this.vacancy.title || 'CONVOCATORIA LABORAL').toUpperCase();
                
                const words = title.split(' ');
                let line = '';
                let y = 235;
                for (let n = 0; n < words.length; n++) {
                    const testLine = line + words[n] + ' ';
                    const metrics = ctx.measureText(testLine);
                    if (metrics.width > 860 && n > 0) {
                        ctx.fillText(line.trim(), size / 2, y);
                        line = words[n] + ' ';
                        y += 54;
                    } else {
                        line = testLine;
                    }
                }
                ctx.fillText(line.trim(), size / 2, y);

                // Department & Location Pill
                const subY = y + 55;
                ctx.fillStyle = 'rgba(16, 185, 129, 0.25)';
                const subText = `${this.vacancy.department || 'FMK'}  |  ${this.vacancy.location || 'Bolivia'}`;
                ctx.font = '700 24px "Plus Jakarta Sans", sans-serif';
                const subMetrics = ctx.measureText(subText);
                const pillW = subMetrics.width + 60;
                
                drawUniversalRoundedRect(ctx, (size - pillW) / 2, subY - 30, pillW, 44, 22);

                ctx.fillStyle = '#a7f3d0';
                ctx.fillText(subText, size / 2, subY);

                // Center QR White Card Box
                const qrBoxSize = 360;
                const qrBoxY = subY + 50;
                const qrBoxX = (size - qrBoxSize) / 2;

                ctx.fillStyle = '#ffffff';
                drawUniversalRoundedRect(ctx, qrBoxX, qrBoxY, qrBoxSize, qrBoxSize, 28);

                // Draw QR Code from qrCanvas
                const qrSrcCanvas = document.getElementById('qrCanvas');
                if (qrSrcCanvas) {
                    const qrPad = 25;
                    ctx.drawImage(qrSrcCanvas, qrBoxX + qrPad, qrBoxY + qrPad, qrBoxSize - (qrPad * 2), qrBoxSize - (qrPad * 2));
                }

                // Call to action below QR
                const ctaY = qrBoxY + qrBoxSize + 60;
                ctx.fillStyle = '#ffffff';
                ctx.font = '800 28px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('¡ESCANEA CON TU CELULAR PARA POSTULARTE!', size / 2, ctaY);

                // Sub callout
                ctx.fillStyle = '#94a3b8';
                ctx.font = '600 20px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('Ingresa de inmediato y rinde tus evaluaciones en línea', size / 2, ctaY + 34);

                // Footer URL
                ctx.fillStyle = '#38bdf8';
                ctx.font = '700 20px "Plus Jakarta Sans", sans-serif';
                ctx.fillText('www.kullakita.org  •  Proceso de Selección Transparente', size / 2, size - 48);

            } catch(e) {
                console.error('Error drawing flyer canvas:', e);
            }
        },

        downloadQR() {
            const canvas = document.getElementById('qrCanvas');
            if (!canvas) return;
            const a = document.createElement('a');
            a.download = `qr-convocatoria-${this.vacancy.id || 'fmk'}.png`;
            a.href = canvas.toDataURL('image/png');
            a.click();
        },

        downloadFlyer() {
            const canvas = document.getElementById('flyerCanvas');
            if (!canvas) return;
            const a = document.createElement('a');
            a.download = `afiche-reclutamiento-${this.vacancy.id || 'fmk'}.png`;
            a.href = canvas.toDataURL('image/png');
            a.click();
        },

        copyLink() {
            navigator.clipboard.writeText(this.vacancy.url).then(() => {
                this.copied = true;
                setTimeout(() => { this.copied = false; }, 2500);
            });
        },

        shareWhatsApp() {
            const msg = `*Convocatoria Laboral en Fundación Munasim Kullakita*\n\n` +
                        `Puesto: *${this.vacancy.title}*\n` +
                        `Área: ${this.vacancy.department} (${this.vacancy.location})\n` +
                        (this.vacancy.salary ? `Salario: ${this.vacancy.salary}\n` : '') +
                        `\nPostúlate directamente escaneando o ingresando a:\n${this.vacancy.url}`;
            window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(msg)}`, '_blank');
        },

        shareLinkedIn() {
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(this.vacancy.url)}`, '_blank');
        },

        shareFacebook() {
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.vacancy.url)}`, '_blank');
        },

        shareTwitter() {
            const text = `Convocatoria Abierta: ${this.vacancy.title} en Fundación Munasim Kullakita. ¡Postúlate aquí!`;
            window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(this.vacancy.url)}`, '_blank');
        }
    };
}

// Global bulletproof launcher callable from any button onclick
window.openQrModal = function(detail) {
    if (typeof detail === 'string') {
        try { detail = JSON.parse(detail); } catch(e) {}
    }
    if (window.qrKitModalInstance) {
        window.qrKitModalInstance.openModal(detail);
        return;
    }
    window.dispatchEvent(new CustomEvent('open-qr-kit', { detail: detail }));
};
</script>
