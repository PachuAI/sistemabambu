# Desarrollo Laravel - Lessons Learned y Soluciones

## Resumen del Proyecto
**Sistema BAMBU** - Sistema de gestión integral para empresa de productos químicos de limpieza
- **Stack:** Laravel 12 + Livewire 3 + Filament 3 + Scout + Spatie Permission
- **Entorno:** Windows con Laragon, Git Bash
- **Base de datos:** MySQL (inicialmente SQLite, luego migrado)

---

## 1. Configuración Inicial y Problemas de Path

### Problema: Comandos no encontrados en Windows/Laragon
**Error:** `composer: command not found`, `php: command not found`

**Causa:** Git Bash no encuentra las rutas de Laragon automáticamente

**Solución implementada:**
```bash
# Configurar PATH para cada comando
export PATH="/c/laragon/bin/php/php-8.3.16-Win32-vs16-x64:$PATH"
/c/laragon/bin/composer/composer [comando]
```

**Mejora sugerida para futuros proyectos:**
Crear un script de configuración inicial que configure el PATH permanentemente.

---

## 2. Instalación de Paquetes

### Paquetes Core Instalados
```bash
composer require laravel/scout
composer require spatie/laravel-permission  
composer require filament/filament:"^3.2" --ignore-platform-req=ext-zip
```

### Problema: Conflictos de versiones Filament
**Error:** Filament no compatible con Laravel 12, falta extensión ZIP

**Solución:**
- Usar versión específica `^3.2` 
- Flag `--ignore-platform-req=ext-zip` para desarrollo local

**Lección:** Siempre verificar compatibilidad de versiones antes de instalar paquetes principales.

---

## 3. Configuración de Base de Datos

### Migración SQLite → MySQL
**Decisión:** Cambiar de SQLite a MySQL para mayor robustez

**Configuración .env:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bambu_stock
DB_USERNAME=root
DB_PASSWORD=
```

**Comando de reseteo completo:**
```bash
php artisan migrate:fresh --seed
```

---

## 4. Arquitectura de Modelos y Relaciones

### Estructura implementada:
```
- Ciudad (1:N) Cliente
- Cliente (1:N) Pedidos (futuro)
- Producto (searchable con Scout)
- NivelDescuento (para sistema de descuentos automáticos)
```

### Patterns importantes:
- **SoftDeletes** en modelos principales
- **Searchable trait** para Scout
- **Fillable y casts** explícitos
- **Relaciones tipadas** con PHPDoc

---

## 5. Sistema de Búsqueda con Scout

### Configuración Scout
**Driver elegido:** `collection` (para desarrollo local, evita Algolia/Meilisearch)

**Configuración .env:**
```env
SCOUT_DRIVER=collection
```

### Implementación en modelos:
```php
use Laravel\Scout\Searchable;

public function toSearchableArray(): array
{
    return [
        'id' => $this->id,
        'nombre' => $this->nombre,
        // campos específicos para búsqueda
    ];
}
```

### API endpoints:
- `/api/search/clientes?q=term`
- `/api/search/productos?q=term`

**Indexación:**
```bash
php artisan scout:import "App\Models\Cliente"
php artisan scout:import "App\Models\Producto"
```

---

## 6. Sistema de Autenticación y Roles

### Filament Admin Panel
**Configuración:**
```bash
php artisan filament:install --panels
```

**Usuario admin creado via seeder:**
- Email: `admin@bambu.com`
- Password: `admin123`

### Spatie Permission (preparado para futuro)
- Migraciones publicadas y ejecutadas
- Sistema listo para roles: admin, operador

---

## 7. Frontend y Vistas

### Problema: Error "Internal Server Error" en home
**Causa:** Vite no configurado correctamente, referencias a assets inexistentes

**Solución temporal:**
- Remover `@vite()` del layout
- Usar CDN de Bootstrap directamente
- Limpiar cachés: `php artisan view:clear && php artisan config:clear`

### Stack Frontend elegido:
- **Bootstrap 5** vía CDN
- **Bootstrap Icons** para iconografía
- **Blade tradicional** para CRUD
- **Livewire** reservado para cotizador

---

## 8. Estructura de Seeders y Datos de Prueba

### Seeders implementados:
```
DatabaseSeeder
├── CiudadSeeder (10 ciudades argentinas)
├── NivelDescuentoSeeder (L1-L4: 0%, 5%, 10%, 15%)
├── ProductoSeeder (productos BAMBU)
└── ClienteSeeder (5 clientes de prueba)
```

### Pattern de seeders:
```php
// Usar updateOrCreate para evitar duplicados
Cliente::updateOrCreate(
    ['direccion' => $cliente['direccion']], // Unique key
    $cliente
);
```

---

## 9. Estrategia de Desarrollo CRUD

### Enfoque híbrido implementado:
1. **CRUD tradicional** (Laravel controllers + Blade) para funcionalidad básica
2. **Filament** para panel de administración potente
3. **Livewire** preparado para componentes interactivos (cotizador)

### Ventajas de este enfoque:
- Fácil de entender y debuggear
- Filament potente para admin
- Livewire listo para interactividad
- Mantenible y escalable

---

## 10. Comandos Esenciales para Desarrollo

### Limpieza de cachés:
```bash
php artisan config:clear
php artisan cache:clear  
php artisan view:clear
```

### Base de datos:
```bash
php artisan migrate:fresh --seed  # Reset completo
php artisan db:seed --class=ClienteSeeder  # Seeder específico
```

### Verificación:
```bash
php artisan route:list  # Ver todas las rutas
php artisan migrate:status  # Estado de migraciones
```

### Servidor de desarrollo:
```bash
php artisan serve --host=127.0.0.1 --port=8000
```

---

## 11. Problemas Comunes y Soluciones

### 1. "Class not found" en Seeders
**Solución:** Verificar imports y namespaces correctos

### 2. Unique constraint violations
**Soluciones:** 
- Usar `updateOrCreate()` en seeders
- `migrate:fresh --seed` para reset completo

### 3. Scout no indexa
**Verificar:** Driver configurado, modelos con trait Searchable

### 4. Vistas no cargan
**Soluciones:**
- Limpiar cachés
- Verificar sintaxis Blade
- Remover referencias Vite si no está configurado

---

## 12. Estructura Final del Proyecto

### Directorios importantes:
```
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/SearchController.php
│   │   ├── ClienteController.php
│   │   └── ProductoController.php
│   ├── Models/ (con traits Scout y SoftDeletes)
│   └── Providers/Filament/AdminPanelProvider.php
├── database/
│   ├── migrations/ (8 migraciones total)
│   └── seeders/ (5 seeders)
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── clientes/ (CRUD completo)
│   ├── productos/ (CRUD completo)
│   └── welcome.blade.php (dashboard)
└── routes/web.php
```

### URLs funcionales:
- `/` - Dashboard principal
- `/clientes` - CRUD clientes
- `/productos` - CRUD productos
- `/cotizador` - Sistema de cotizaciones Livewire
- `/admin` - Panel Filament
- `/api/search/*` - API búsqueda

---

## 13. Fase 2 Completada: Cotizador Livewire

### Funcionalidades implementadas:
- ✅ Componente Livewire completamente funcional (`/cotizador`)
- ✅ Búsqueda en tiempo real de clientes con autocompletado
- ✅ Búsqueda en tiempo real de productos con validación de stock
- ✅ Sistema de cálculo automático de descuentos por volumen (L1-L4)
- ✅ Interfaz reactiva para añadir/quitar productos del pedido
- ✅ Generación de resumen formateado para comunicación externa
- ✅ Modal con opción de copia al portapapeles
- ✅ Estados de carga y validaciones en vivo

### Características técnicas implementadas:
```php
// Archivo: app/Livewire/Cotizador.php
- Búsqueda debounceada (300ms) para mejor UX
- Integración con Laravel Scout para búsqueda rápida
- Cálculo automático de descuentos basado en NivelDescuento
- Validación de stock en tiempo real
- Gestión de estado reactivo con Livewire
- Interfaz responsive con Bootstrap 5
```

### Vista implementada:
```php
// Archivo: resources/views/livewire/cotizador.blade.php
- Layout de dos columnas: búsqueda/productos | totales
- Dropdowns interactivos con resultados de búsqueda
- Tabla reactiva de productos seleccionados
- Panel de totales con información de descuentos
- Modal para mostrar resumen formateado
- Loading states para todas las operaciones
```

### Próximos pasos:
- Fase 3: Sistema de persistencia de pedidos con descuento de stock
- Fase 4: Módulo de logística y repartos

---

## 14. Lecciones para Futuros Proyectos

1. **Configurar PATH de Laragon** desde el inicio
2. **Verificar compatibilidad de paquetes** antes de instalar
3. **Usar migrate:fresh --seed** para resets limpios
4. **CDN para CSS/JS** si Vite no está configurado
5. **Seeders con updateOrCreate** para evitar duplicados
6. **Scout con driver collection** para desarrollo local
7. **Filament es excelente** para admin panels rápidos
8. **Enfoque híbrido** (tradicional + Livewire) funciona bien

---

*Documentación creada: $(date)*
*Proyecto: Sistema BAMBU v1.0*