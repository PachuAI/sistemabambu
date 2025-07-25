# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Sistema BAMBU** is a Laravel-based stock management system for a cleaning chemical products company. It replaces fragmented legacy tools (Enexpro software + Excel spreadsheets) with a unified web application for inventory management, quotations, and delivery logistics.

## Technology Stack

- **Laravel 12** with **PHP 8.2+**
- **Livewire 3** for reactive components
- **Filament v3** for admin panel
- **Laravel Scout** with collection driver for search
- **Spatie Laravel Permission** for roles
- **Bootstrap 5** for styling (CDN-based)
- **MySQL/SQLite** database

## Development Environment Setup

### Windows/Laragon Specific Commands

This project runs in a Windows/Laragon environment. Use these PATH-adjusted commands:

```bash
# Set PATH for PHP
export PATH="/c/laragon/bin/php/php-8.3.16-Win32-vs16-x64:$PATH"

# Use full path for Composer
/c/laragon/bin/composer/composer [command]
```

### Essential Development Commands

```bash
# Database operations
php artisan migrate:fresh --seed    # Complete database reset with test data
php artisan scout:import "App\Models\Cliente"     # Re-index search
php artisan scout:import "App\Models\Producto"    # Re-index search

# Clear caches (frequently needed)
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan optimize:clear          # Clear all optimization caches

# Development server
php artisan serve --host=127.0.0.1 --port=8000
composer dev                        # Runs server + queue + logs + vite concurrently

# Testing
composer test                       # Runs config:clear + phpunit
php artisan test                    # Direct test execution

# Code quality
vendor/bin/pint                     # Laravel Pint code formatting
```

## Application Architecture

### Core Business Entities and Relationships

```
Ciudad → Cliente (1:N)
Cliente → Pedido (1:N)
Pedido → PedidoItem (1:N)
Producto → PedidoItem (1:N)
NivelDescuento → Pedido (1:N)
Producto/Pedido → MovimientoStock (1:N)
Vehiculo → Reparto (1:N)
Pedido → Reparto (1:N)
```

### Key Models Features

All models use:
- **SoftDeletes** for data preservation
- **Scout Searchable trait** for real-time search
- Proper **fillable/casts** declarations
- **Eloquent relationships** with type hints

### Development Approach

**Hybrid Architecture:**
- **Traditional Laravel controllers + Blade** for CRUD operations
- **Livewire components** for interactive features (quotation system)
- **Filament admin panel** for administrative tasks

## Database Schema

### Main Tables
- `ciudades` - Cities with provinces
- `clientes` - Clients linked to cities
- `productos` - Products with SKU, prices, and stock
- `niveles_descuento` - 4-tier discount configuration
- `pedidos` - Confirmed orders with status tracking
- `pedido_items` - Order line items
- `movimiento_stocks` - Stock movement audit trail
- `vehiculos` - Fleet management with capacity control
- `repartos` - Daily delivery assignments and tracking

## Search System Implementation

**Laravel Scout with Hybrid Fallback:**
```php
// Primary: Scout search
$productos = Producto::search($term)->get();

// Fallback: Traditional LIKE query if Scout fails
if ($productos->isEmpty()) {
    $productos = Producto::where('nombre', 'LIKE', "%{$term}%")
        ->orWhere('sku', 'LIKE', "%{$term}%")
        ->get();
}
```

## Key Application Features

### Phase 1: CRUD & Search (✅ Complete)
- Client/Product/City management with full CRUD
- Scout-powered autocomplete search with fallback
- Filament admin panel integration

### Phase 2: Quotation System (✅ Complete)
- **Livewire Cotizador** component at `/cotizador`
- Real-time client and product search
- Automated discount calculation based on order volume
- Stock validation during product selection
- Formatted quotation summary generation

### Phase 3A: Order Persistence (✅ Complete)
- Order confirmation with automatic stock deduction
- Stock movement tracking for audit trail
- Order listing with status management at `/pedidos`
- Database transactions for data integrity

### Phase 3B: Logistics and Delivery Management (✅ Complete)
- **Vehicle Fleet Management** - Full CRUD for vehicles with capacity control
- **Daily Route Planning** - Visual dashboard for assigning orders to vehicles
- **Delivery Assignment System** - Drag-and-drop interface for route optimization
- **Real-time Delivery Tracking** - Live status updates with Livewire components
- **City-based Logistics Summary** - Consolidated reports for strategic planning

### Discount System Logic

4-tier automatic discount system based on order volume:
- **L1:** 0% (base price)
- **L2:** 5% (>$X threshold)
- **L3:** 10% (>$Y threshold)
- **L4:** 15% (>$Z threshold)

**Important:** Combo products (`es_combo = true`) are excluded from discount calculations but included in final total.

## Stock Management System

### Stock Deduction Flow
1. User confirms order in cotizador
2. System validates available stock
3. Creates order record in transaction
4. Deducts from `productos.stock_actual`
5. Records movement in `movimiento_stocks` with negative quantity

### Stock Movement Tracking
```php
MovimientoStock::create([
    'producto_id' => $producto->id,
    'pedido_id' => $pedido->id,
    'cantidad' => -$cantidad, // Negative for sales
    'motivo' => 'venta',
    'observaciones' => "Pedido #{$pedido->id}"
]);
```

## Routes Structure

```
/ - Dashboard
/clientes - Client CRUD
/productos - Product CRUD
/ciudades - City CRUD
/cotizador - Livewire quotation system
/pedidos - Confirmed orders listing
/pedidos/{id} - Order detail view
/vehiculos - Vehicle fleet management
/repartos - Daily delivery planning dashboard
/seguimiento-entregas - Real-time delivery tracking
/admin - Filament admin panel
/api/search/clientes - Client autocomplete API
/api/search/productos - Product autocomplete API
```

## Admin Access

- **URL:** `/admin`
- **User:** admin@bambu.com
- **Password:** admin123

## Critical Development Lessons Learned

### Livewire Array References Bug
**Issue:** Using `&$item` references in foreach loops corrupts Livewire component state
**Symptoms:** Array elements get overwritten with first element's data after subsequent renders
**Solution:** Never use PHP references (`&`) in Livewire component properties
```php
// ❌ Wrong - causes array corruption
foreach ($this->items as &$item) { ... }

// ✅ Correct - use array key access
foreach ($this->items as $key => $item) {
    $this->items[$key]['field'] = $newValue;
}
```

### Livewire Array Keys
**Issue:** Wire:key conflicts with array reconciliation in Livewire
**Solution:** Use associative arrays with unique string keys instead of numeric indices
```php
// ❌ Wrong - numeric keys cause DOM reuse issues
$this->items[] = $newItem;

// ✅ Correct - associative keys with unique identifiers
$itemId = 'item_' . $productId . '_' . str_replace('.', '_', microtime(true));
$this->items[$itemId] = $newItem;
```

### Livewire Component Blank Page
**Solution:** Ensure `@livewireStyles` and `@livewireScripts` are in layout

### Search Not Working
**Solution:** Re-run scout import or check hybrid search fallback implementation

### Windows Path Issues
**Solution:** Use full Laragon paths or set PATH as shown above

## Business Requirements Context

The system replaces:
1. **Enexpro**: Desktop software for Saphirus products (resale)
2. **Excel Cotizador**: Quotation tool for BAMBU products (manufactured)
3. **Excel Logistics**: Manual delivery planning sheets

Key business decision: Unified stock control for ALL products (both manufactured and resold).

## Logistics System Implementation

### Vehicle Management Features
- Vehicle CRUD with capacity control (bultos)
- Active/inactive status management
- Capacity utilization tracking
- Real-time availability calculation

### Delivery Planning Features
- Weekly calendar view with day-by-day planning
- Visual capacity indicators for each vehicle
- Order assignment with capacity validation
- Drag-and-drop interface for easy planning
- City-based delivery consolidation reports

### Delivery Tracking Features
- Real-time status updates (planificado → en_ruta → entregado/no_entregado)
- Live statistics dashboard with delivery effectiveness
- Vehicle-specific filtering and tracking
- Livewire-powered instant updates without page refresh

## Next Development Phases

- **Phase 4:** Advanced reporting and analytics dashboard
- **Phase 5:** Mobile app for drivers with GPS tracking
- **Phase 6:** Customer notification system (SMS/WhatsApp)
- **Phase 7:** Route optimization algorithms

## Key Files for Understanding Codebase

### Core System
- `app/Livewire/Cotizador.php` - Main quotation system with order confirmation
- `app/Models/Pedido.php` - Order model with relationships
- `database/migrations/*pedidos*.php` - Order system schema
- `resources/views/livewire/cotizador.blade.php` - Quotation UI

### Logistics System
- `app/Http/Controllers/VehiculoController.php` - Vehicle fleet management
- `app/Http/Controllers/RepartoController.php` - Delivery planning and assignment
- `app/Livewire/SeguimientoEntregas.php` - Real-time delivery tracking
- `app/Models/Vehiculo.php` - Vehicle model with capacity calculations
- `app/Models/Reparto.php` - Delivery assignment model
- `resources/views/repartos/index.blade.php` - Daily planning dashboard
- `resources/views/livewire/seguimiento-entregas.blade.php` - Tracking interface

### Documentation
- `documentacion/00_Requerimientos.md` - Complete business requirements