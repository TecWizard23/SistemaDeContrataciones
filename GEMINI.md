# Kullakita - Sistema de Contrataciones y Evaluaciones de RRHH

Documento de contexto arquitectónico, técnico y funcional para el agente de IA (**Gemini / Antigravity**).

---

## 1. Visión General del Proyecto
**Kullakita** es una plataforma web enterprise orientada a la gestión integral de procesos de selección, reclutamiento y contratación de talento humano para la **Fundación Munasim Kullakita**. Su objetivo principal es centralizar las convocatorias laborales, la difusión multicanal mediante códigos QR y afiches para redes sociales, la postulación pública directa, la evaluación psicométrica estandarizada (pruebas cognitivas y perfiles conductuales DISC), el seguimiento del embudo de contratación y la formalización final de contratos.

---

## 2. Stack Tecnológico

| Capa | Tecnologías | Notas |
| :--- | :--- | :--- |
| **Backend** | PHP 8.2 (FPM Alpine) / Laravel 12.x | ORM Eloquent, arquitectura MVC, autenticación de sesión y roles |
| **Base de Datos** | MariaDB 10.11 | Contenedor `rrhh_mariadb`, puerto host `3306` |
| **Servidor Web** | Nginx Alpine | Contenedor `rrhh_laravel_nginx`, puerto host `8000` |
| **Frontend** | Tailwind CSS v4, Alpine.js, Vite 7 | Diseño corporativo sobrio (Linear / Stripe / Kenjo), sin CDN externa |
| **Visualización** | Chart.js | Radares de competencias (8 ejes) y curvas de tendencia |
| **Generación QR / Flyer**| QRCode.js & Canvas HTML5 | Afiches automatizados 1080x1080 y QR vectoriales de alta resolución |
| **Exportación PDF** | DomPDF | Reportes ejecutivos oficiales de resultados psicométricos |
| **Infraestructura** | Docker Compose | Orquestación en 3 servicios desacoplados (`app`, `nginx`, `db`) |

---

## 3. Modelo de Dominio y Base de Datos

### Entidades Clave (`app/Models`):
- [User](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/User.php): Usuarios del sistema con roles:
  - `HR`: Administrador / Reclutador con acceso al panel de control, convocatorias, pipeline, evaluaciones y analíticas.
  - `CANDIDATE`: Postulante con acceso al portal de pruebas asignadas, perfil y resultados.
- [Vacancy](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/Vacancy.php): Convocatorias laborales (`title`, `department`, `location`, `salary`, `contract_type`, `description`, `requirements`, `status`: `OPEN`, `PAUSED`, `CLOSED`).
- [Candidate](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/Candidate.php): Información profesional y trazabilidad del postulante:
  - Campos: `full_name`, `email`, `phone`, `applied_position`, `vacancy_id`.
  - Estados del embudo (`hiring_stage`): `POSTULADO`, `EVALUADO`, `ENTREVISTA`, `OFERTA`, `CONTRATADO`, `DESCARTADO`.
  - Formalización: `hired_at`, `hire_notes`.
- [Evaluation](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/Evaluation.php): Tipos de pruebas psicométricas y técnicas (`type`: `COGNITIVE`, `DISC`, `SITUATIONAL`, `duration_minutes`, `instructions`).
- [Question](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/Question.php): Preguntas asociadas a una evaluación, con opciones estructuradas JSON (`options`), ponderación (`points`) y respuesta correcta (`correct_option`).
- [CandidateSession](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/CandidateSession.php): Instancia de examen rendido por un candidato:
  - Estados: `PENDING`, `IN_PROGRESS`, `COMPLETED`.
  - Métricas: `raw_score`, `fit_percentage` (% de ajuste al perfil), `metrics_summary` (JSON).
- [SessionAnswer](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/SessionAnswer.php): Respuestas puntuales registradas durante una sesión de examen.

---

## 4. Módulos y Flujos Principales

### A. Autenticación, Redirección y Seguridad ([AuthController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/AuthController.php))
- **Redirección Raíz Intuitiva (`/`)**:
  - Visitantes no autenticados ➡️ Redirigen a `/convocatorias` (portal público de empleo).
  - Usuarios autenticados con rol `HR` ➡️ Redirigen a `/dashboard`.
  - Usuarios autenticados con rol `CANDIDATE` ➡️ Redirigen a `/portal`.
- **Inmunidad a SQL Injection**: Consultas con Parameter Binding estricto (`where`, `whereIn`, Eloquent ORM) y validaciones `FormRequest` tipadas. Certificado por suite de pruebas automatizadas [SecuritySqlInjectionTest](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/tests/Feature/SecuritySqlInjectionTest.php).

### B. Portal Público de Convocatorias y Postulación ([PublicJobController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/PublicJobController.php))
- **Catálogo de Convocatorias (`/convocatorias`)**: Lista pública de vacantes abiertas con filtros dinámicos por cargo, área y ubicación.
- **Detalle y Postulación Abierta (`/convocatorias/{vacancy}`)**: Información exhaustiva del puesto y formulario de postulación directa que registra automáticamente la cuenta de usuario del candidato y le asigna sus credenciales de acceso inicial.
- **Kit de Difusión y Generador de QR ([qr-social-kit-modal](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/resources/views/components/qr-social-kit-modal.blade.php))**:
  - Generación en el cliente de códigos QR descargables en PNG de alta resolución.
  - Generación de afiches / flyers de redes sociales de 1080x1080 px con branding institucional.
  - Enlaces directos para compartir en WhatsApp, LinkedIn, Facebook y X.

### C. Módulo de Reclutador RRHH (`role:HR`)
- **Gestión Integral de Contrataciones y Embudo** ([CandidateController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/CandidateController.php)):
  - Vista pipeline con ribbon KPI de las 5 fases: Postulados, Evaluados, Entrevista, Oferta y Contratados.
  - Filtros combinados por estado, cargo y convocatoria.
  - Modal de formalización de contratación con registro de fecha y notas de ingreso.
  - Nómina imprimible para auditoría de selección.
- **Gestión de Convocatorias y Vacantes** ([VacancyController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/VacancyController.php)): CRUD completo de plazas laborales y control de cupos.
- **Constructor de Evaluaciones por Bloques Dinámicos** ([EvaluationManagementController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/EvaluationManagementController.php)):
  - Creador y editor modular con Alpine.js: cada pregunta es un bloque completamente independiente.
  - Funcionalidades: reordenamiento arriba/abajo, duplicación instantánea, colapso individual o masivo.
  - Plantillas preconfiguradas (Cognitiva y DISC).
  - Pestaña de simulación / vista previa en tiempo real idéntica a la vista del postulante.
- **Dashboard de Selección** ([RecruitmentDashboardController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/RecruitmentDashboardController.php)): Panel ejecutivo de KPIs, listado de postulantes y detalle individual de sesión.
- **Comparador y Radar Multiaxial** ([ComparisonController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/ComparisonController.php)): Comparación simultánea de hasta 3 candidatos en un radar de 8 dimensiones y exportación a CSV.
- **Reportes Oficiales en PDF** ([CandidateReportController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/CandidateReportController.php)): Exportación en formato A4 institucional de resultados cognitivos y conductuales DISC.

### D. Módulo del Postulante (`role:CANDIDATE`)
- **Portal del Candidato** ([CandidatePortalController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/CandidatePortalController.php)): Acceso directo a pruebas pendientes y completadas.
- **Resolución de Pruebas** ([ExamTakingController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/ExamTakingController.php)): Interfaz guiada libre de distracciones, temporizador flotante en vivo y retroalimentación de estado de respuesta.
- **Perfil Profesional** ([CandidateProfileController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/CandidateProfileController.php)): Actualización de datos de contacto y datos curriculares.
- **Mis Resultados** ([CandidateEvaluationController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/CandidateEvaluationController.php)): Visualización del desglose de desempeño en pruebas completadas.

---

## 5. Estándar de Diseño Visual (Enterprise Design Standard)

La aplicación sigue una guía de diseño estricta inspirada en interfaces SaaS de alto nivel (Linear, Stripe, Kenjo):
1. **Paleta de Colores Ejecutiva:**
   - Barra superior (Navbar): `bg-slate-950` con borde inferior sutil `border-slate-800/80`.
   - Hero Banners: `from-slate-900 via-slate-800 to-indigo-950` con bordes nítidos y píldoras con efecto glassmorphism.
   - Tarjetas y Contenedores: Fondo blanco puro (`bg-white`) con micro-bordes refinados (`border-slate-200/80`) y sombras suaves (`shadow-xs` / `shadow-sm`).
   - Botones de Acción Primarios: Píldoras oscuras de alto contraste `bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs`.
   - Indicadores de Estado: Tonos pastel suaves (`indigo-50`, `emerald-50`, `amber-50`, `sky-50`) con texto nítido y legible.
2. **Iconografía y Tipografía:**
   - **Regla Estricta:** CERO EMOJIS en interfaces y documentos. Se utilizan exclusivamente íconos vectoriales SVG limpios.
   - Tipografía sans-serif moderna escalada de forma consistente.

---

## 6. Credenciales Semilla (Seeders)

| Rol | Correo Electrónico | Contraseña | Destino inicial |
| :--- | :--- | :--- | :--- |
| **Reclutador (RRHH)** | `rrhh@kullakita.org` | `password123` | `/dashboard` |
| **Postulante** | `postulante@kullakita.org` | `password123` | `/portal` |

---

## 7. Comandos Operativos Frecuentes

```bash
# Levantar el entorno Docker en segundo plano
docker compose up -d

# Detener los contenedores
docker compose down

# Ejecutar comandos de Artisan dentro del contenedor
docker compose exec -T app php artisan [comando]

# Compilar frontend con Vite (Tailwind v4)
npm run build

# Regenerar base de datos y datos de prueba completos
docker compose exec -T app php artisan migrate:fresh --seed --force

# Ejecutar la suite completa de pruebas automatizadas (36 pruebas / 163 aserciones)
docker compose exec -T app php artisan test

# Limpiar y regenerar cachés de Laravel
docker compose exec -T app php artisan optimize:clear

# Reiniciar contenedor PHP tras cambios en Blade o config (liberar OPcache en RAM)
docker compose restart app
```

---

## 8. Consideraciones Técnicas Críticas (Gotchas de Rendimiento)

1. **Ubicación en Windows / OneDrive:**
   - La carpeta física del proyecto reside en `C:\Users\jhoam\OneDrive\Escritorio\...`.
   - Debido a la latencia de I/O en Docker WSL2 sobre sistemas de archivos de Windows y la sincronización de OneDrive, **se ha configurado `opcache.ini` en RAM** (`opcache.validate_timestamps=0`) montado en `/usr/local/etc/php/conf.d/custom-opcache.ini`.
   - *Nota:* Tras editar archivos PHP o vistas Blade, si los cambios no se reflejan de inmediato, ejecutar `php artisan optimize:clear` y `docker compose restart app`.
2. **Conectividad de Red:**
   - Acceder preferentemente mediante `http://127.0.0.1:8000` o `http://localhost:8000` (Nginx ya soporta IPv4 e IPv6).
3. **Compilación de Frontend:**
   - No utilizar `https://cdn.tailwindcss.com`. Todo el CSS se compila localmente mediante Vite (`npm run build`).
4. **Integridad de Pruebas Automatizadas:**
   - Antes de confirmar cambios en producción o subir a Git, verificar que la suite `php artisan test` mantenga el 100% de pruebas aprobadas (36 pruebas verdes).
