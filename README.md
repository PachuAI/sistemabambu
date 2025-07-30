# Sistema BAMBU - Sistema de Gestión de Stock y Logística

Sistema web integral para la gestión de inventario, cotizaciones y logística de entregas para una empresa de productos químicos de limpieza.

## Descripción del Proyecto

**Sistema BAMBU** es una aplicación web basada en Laravel que reemplaza herramientas fragmentadas (software Enexpro + hojas de Excel) con una solución unificada para:

- 📦 **Gestión de Inventario** - Control de stock en tiempo real para productos propios (BAMBU) y de reventa (SAPHIRUS)
- 💰 **Sistema de Cotizaciones** - Cotizador interactivo con descuentos automáticos por volumen
- 🚚 **Logística de Entregas** - Planificación de rutas y seguimiento de entregas
- 👥 **Gestión de Clientes** - Base de datos completa con búsqueda inteligente
- 📊 **Reportes y Análisis** - Dashboards visuales para toma de decisiones

## Stack Tecnológico

- **Backend**: Laravel 12 + PHP 8.2+
- **Frontend**: Bootstrap 5 (CDN) + Livewire 3
- **Base de Datos**: MySQL/SQLite
- **Panel Admin**: Filament v3
- **Búsqueda**: Laravel Scout con driver collection
- **Autenticación**: Laravel Breeze + Spatie Laravel Permission

## Características Principales

### ✅ Fase 1: CRUD y Búsqueda (Completa)
- Gestión completa de clientes, productos y ciudades
- Búsqueda inteligente con Scout y fallback tradicional
- Panel administrativo con Filament

### ✅ Fase 2: Sistema de Cotizaciones (Completa)
- Componente Livewire para cotizaciones en tiempo real
- Cálculo automático de descuentos por volumen (4 niveles)
- Validación de stock durante la selección
- Generación de resúmenes formateados

### ✅ Fase 3A: Persistencia de Pedidos (Completa)
- Confirmación de pedidos con deducción automática de stock
- Trazabilidad completa de movimientos de inventario
- Transacciones de base de datos para integridad

### ✅ Fase 3B: Gestión Logística (Completa)
- **Gestión de Flota** - CRUD de vehículos con control de capacidad
- **Planificación de Rutas** - Dashboard visual con calendario semanal
- **Asignación Inteligente** - Sistema modal con validación de capacidad
- **Seguimiento en Tiempo Real** - Estados: planificado → en_ruta → entregado
- **Reportes por Ciudad** - Consolidación estratégica para planificación

### 🎨 Diseño UI/UX Moderno
- **Material Design 3** - Interfaz elegante con efectos glassmorphism
- **Componentes Responsivos** - Adaptado para todos los dispositivos
- **Transiciones Suaves** - Animaciones fluidas para mejor UX
- **Esquema de Colores Coherente** - Paleta esmeralda y grises modernos

## Instalación

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL o SQLite

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/PachuAI/sistemabambu.git
cd sistemabambu
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**
   - Editar `.env` con las credenciales de tu base de datos
   - Ejecutar las migraciones:
```bash
php artisan migrate:fresh --seed
```

5. **Indexar datos para búsqueda**
```bash
php artisan scout:import "App\Models\Cliente"
php artisan scout:import "App\Models\Producto"
```

6. **Instalar dependencias de frontend**
```bash
npm install
npm run build
```

7. **Iniciar el servidor de desarrollo**
```bash
php artisan serve
# O usar el comando personalizado que incluye queue y logs:
composer dev
```

## Acceso al Sistema

### Panel Principal
- URL: `http://localhost:8000`
- Usuario demo: `demo@bambu.com`
- Contraseña: `password`

### Panel Administrativo
- URL: `http://localhost:8000/admin`
- Usuario: `admin@bambu.com`
- Contraseña: `admin123`

## Estructura del Proyecto

```
sistemastockbambu/
├── app/
│   ├── Http/Controllers/     # Controladores tradicionales
│   ├── Livewire/             # Componentes Livewire
│   ├── Models/               # Modelos Eloquent
│   └── Filament/             # Recursos del panel admin
├── database/
│   ├── migrations/           # Esquema de base de datos
│   └── seeders/              # Datos de prueba
├── resources/
│   └── views/
│       ├── clientes/         # Vistas CRUD de clientes
│       ├── productos/        # Vistas CRUD de productos
│       ├── livewire/         # Componentes Livewire
│       └── repartos/         # Vistas de logística
└── documentacion/            # Documentación técnica del proyecto
```

## Comandos Útiles

```bash
# Limpiar cachés
php artisan optimize:clear

# Ejecutar pruebas
php artisan test

# Formatear código
vendor/bin/pint

# Ver logs en tiempo real
tail -f storage/logs/laravel.log
```

## Datos de Prueba

El sistema incluye datos realistas de demostración:
- 15 ciudades reales de Neuquén y Río Negro
- 15 clientes comerciales (Carrefour, La Anónima, etc.)
- 20 productos (10 BAMBU propios + 10 SAPHIRUS reventa)
- 4 vehículos de reparto con diferentes capacidades
- Pedidos de ejemplo para pruebas

## Arquitectura y Decisiones Técnicas

### Arquitectura Híbrida
- **Controladores + Blade**: Para operaciones CRUD estables
- **Livewire**: Para características interactivas (cotizador)
- **Filament**: Para tareas administrativas avanzadas

### Sistema de Búsqueda
Implementación híbrida con Scout y fallback SQL tradicional para máxima confiabilidad.

### Gestión de Stock
- Deducciones automáticas al confirmar pedidos
- Registro completo de movimientos con trazabilidad
- Transacciones para garantizar integridad de datos

## Próximas Fases de Desarrollo

- **Fase 4**: Dashboard de analytics y reportes avanzados
- **Fase 5**: App móvil para conductores con GPS
- **Fase 6**: Sistema de notificaciones (SMS/WhatsApp)
- **Fase 7**: Algoritmos de optimización de rutas

## Contribuir

Las contribuciones son bienvenidas. Por favor:
1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto es software propietario desarrollado para BAMBU S.A.

## Contacto

Para soporte o consultas sobre el sistema, contactar al equipo de desarrollo.

---

Desarrollado con ❤️ por el equipo de desarrollo de BAMBU