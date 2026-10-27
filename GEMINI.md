# Kullakita - Sistema de Contrataciones y Evaluaciones de RRHH

Documento de contexto arquitectónico y funcional para el agente de IA (**Gemini / Antigravity**).

---

## 1. Visión General del Proyecto
**Kullakita** es una plataforma web para la gestión integral de procesos de selección y reclutamiento de talento humano. Su objetivo principal es evaluar competencias laborales y psicométricas de los candidatos a través de pruebas estandarizadas (como evaluaciones cognitivas y perfiles de personalidad conductual tipo DISC), generando paneles de analíticas y radares comparativos visuales para el equipo de Recursos Humanos.

---

## 2. Stack Tecnológico

| Capa | Tecnologías | Notas |
| :--- | :--- | :--- |
| **Backend** | PHP 8.2 (FPM Alpine) / Laravel 12.x | ORM Eloquent, autenticación basada en sesión y roles |
| **Base de Datos** | MariaDB 10.11 | Contenedor `rrhh_mariadb`, puerto host `3306` |
| **Servidor Web** | Nginx Alpine | Contenedor `rrhh_laravel_nginx`, puerto host `8000` |
| **Frontend** | Tailwind CSS v4, Alpine.js, Vite 7 | Diseños inspirados en interfaces HR modernas (Kenjo), sin CDN |
| **Visualización** | Chart.js | Radares de competencias y gráficos analíticos interactivos |
| **Infraestructura** | Docker Compose | Orquestación en 3 servicios (`app`, `nginx`, `db`) |

---

## 3. Modelo de Dominio y Base de Datos

### Entidades Clave (`app/Models`):
- [User](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/User.php): Usuarios del sistema con roles:
  - `HR`: Administrador / Reclutador con acceso al panel de control, comparador y analíticas.
  - `CANDIDATE`: Postulante con acceso al portal de evaluaciones asignadas.
- [Candidate](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/Candidate.php): Información profesional del postulante (`full_name`, `email`, `phone`, `applied_position`).
- [Evaluation](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/Evaluation.php): Tipos de pruebas psicométricas y técnicas (`type`, `duration_minutes`, `instructions`).
  - Pruebas base: **Cognitiva** y **DISC**.
- [Question](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/Question.php): Preguntas asociadas a una evaluación, con opciones JSON y ponderación.
- [CandidateSession](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/CandidateSession.php): Instancia de un examen rendido por un candidato:
  - Estados: `PENDING`, `IN_PROGRESS`, `COMPLETED`.
  - Métricas: `raw_score`, `fit_percentage` (% de ajuste al perfil), `metrics_summary` (JSON).
- [SessionAnswer](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Models/SessionAnswer.php): Respuestas puntuales registradas durante una sesión de examen.

---

## 4. Módulos y Flujos Principales

### A. Autenticación y Redirección ([AuthController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/AuthController.php))
- Rutas públicas: `/login`, `/register`.
- Al iniciar sesión:
  - Rol `HR` ➡️ redirige a `/dashboard`.
  - Rol `CANDIDATE` ➡️ redirige a `/portal`.

### B. Módulo de Reclutador RRHH (`role:HR`)
- **Dashboard de Selección** ([RecruitmentDashboardController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/RecruitmentDashboardController.php)): KPIs de postulaciones, filtros por cargo y ajuste, lista de candidatos y detalle de sesiones.
- **Comparador y Radar de Competencias** ([ComparisonController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/ComparisonController.php)): Comparación simultánea de perfiles y exportación.
- **Gestión de Evaluaciones** ([EvaluationManagementController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/EvaluationManagementController.php)): Creación y administración de pruebas y reactivos.
- **Estadísticas y Analíticas FMK** ([AnalyticsController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/AnalyticsController.php), [CandidateController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/CandidateController.php)): Reportes institucionales.

### C. Módulo del Postulante (`role:CANDIDATE`)
- **Portal del Candidato** ([CandidatePortalController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/CandidatePortalController.php)): Visualización de pruebas pendientes y completadas.
- **Toma de Exámenes** ([ExamTakingController](file:///c:/Users/jhoam/OneDrive/Escritorio/Sistema%20de%20contrataciones/SistemaDeContrataciones/app/Http/Controllers/ExamTakingController.php)): Interfaz guiada para resolver preguntas, envío de respuestas y cálculo automático de puntuación.

---

## 5. Credenciales Semilla (Seeders)

| Rol | Correo Electrónico | Contraseña | Destino inicial |
| :--- | :--- | :--- | :--- |
| **Reclutador (RRHH)** | `rrhh@kullakita.org` | `password123` | `/dashboard` |
| **Postulante** | `postulante@kullakita.org` | `password123` | `/portal` |

---

## 6. Comandos Operativos Frecuentes

```bash
# Levantar el entorno Docker en segundo plano
docker compose up -d

# Detener los contenedores
docker compose down

# Ejecutar comandos de Artisan dentro del contenedor
docker compose exec -T app php artisan [comando]

# Compilar frontend con Vite (Tailwind v4)
npm run build

# Regenerar base de datos y datos de prueba
docker compose exec -T app php artisan migrate:fresh --seed --force

# Limpiar y regenerar cachés de Laravel
docker compose exec -T app php artisan optimize
```

---

## 7. Consideraciones Técnicas Críticas (Gotchas de Rendimiento)

1. **Ubicación en Windows / OneDrive:**
   - La carpeta física del proyecto reside en `C:\Users\jhoam\OneDrive\Escritorio\...`.
   - Debido a la latencia de I/O en Docker WSL2 sobre sistemas de archivos de Windows y la sincronización de OneDrive, **se ha configurado `opcache.ini` en RAM** (`opcache.validate_timestamps=0`) montado en `/usr/local/etc/php/conf.d/custom-opcache.ini`.
   - *Nota:* Si se editan archivos PHP o Blade y no se reflejan inmediatamente, reiniciar el contenedor `app` (`docker compose restart app`) o ejecutar `php artisan optimize:clear`.
2. **Conectividad de Red:**
   - Acceder preferentemente mediante `http://127.0.0.1:8000` o `http://localhost:8000` (Nginx ya soporta IPv4 e IPv6).
3. **Frontend:**
   - No utilizar `https://cdn.tailwindcss.com`. Todo el CSS se compila localmente mediante Vite (`npm run build`).
