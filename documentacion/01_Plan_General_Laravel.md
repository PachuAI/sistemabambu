1. Justificación Estratégica
Laravel ofrece la mejor relación velocidad de desarrollo ↔ robustez para tu contexto:

Curva de aprendizaje suave: PHP + Blade + Livewire permiten interactividad sin escribir JS complejo.

Ecosistema enfocado a CRUD/ERP: migraciones, factories, colas, pruebas y paquetes (Scout, Excel, Spatie Permission) resuelven la mayoría de necesidades de un sistema de gestión.

Plantillas reutilizables: los módulos se empaquetan como Laravel Packages o Filament Plugins y se reutilizan en nuevos proyectos, alineándose con tu modelo SaaS.

Comunidad & hosting económico: abundan recursos, talento y servidores LAMP/LEMP baratos, ideales para PyMEs.


2. Propuesta de Arquitectura Tecnológica (Stack Laravel)
| Capa           | Elección                            | Razón                                                                                       |
| -------------- | ----------------------------------- | ------------------------------------------------------------------------------------------- |
| Backend        | **Laravel 11 (PHP 8.3)**            | Framework full-stack maduro, soporte LTS, sintaxis expresiva.                               |
| Frontend       | **Blade + Livewire v3 + Alpine.js** | UX reactiva sin SPA; evita JS avanzado y mantiene la lógica en PHP.                         |
| Base de datos  | **PostgreSQL 15**                   | ACID, precisión decimal, índices compuestos y extensiones GIS para rutas futuras.           |
| Autenticación  | **Laravel Sanctum**                 | Sesiones y API tokens sin la complejidad de OAuth.                                          |
| Búsqueda       | **Laravel Scout + Meilisearch**     | Autocomplete rápido para clientes y productos.                                              |
| Colas/Eventos  | **Redis + Laravel Queue/Horizon**   | Procesamiento asíncrono y monitoring.                                                       |
| Export/Import  | **Laravel-Excel (Maatwebsite)**     | Migración de planillas legacy y generación de reportes.                                     |
| Roles/Permisos | **spatie/laravel-permission**       | Control granular de acceso a módulos.                                                       |
| Admin rápido   | **Filament v3**                     | CRUD instantáneo para tablas secundarias (niveles de descuento, ciudades, vehículos, etc.). |


3. Diseño del Modelo de Datos

| Tabla                           | Columnas principales                                                                                                                                                                         | Relaciones / Índices                                                                      |
| ------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------- |
| **clientes**                    | id, alias (string 100), direccion (string 150), telefono (string 30), ciudad\_id (FK), timestamps                                                                                            | fk ciudad\_id → ciudades.id · índices sobre alias y dirección                             |
| **ciudades**                    | id, nombre (string 80 UNIQUE), timestamps                                                                                                                                                    | —                                                                                         |
| **productos**                   | id, nombre (string 120), sku (string 40 UNIQUE), precio\_base\_l1 (decimal 12,2), stock\_actual (int), es\_combo (boolean, default false), timestamps                                        | índice sobre nombre                                                                       |
| **niveles\_descuento**          | id, nombre (string 5), monto\_min (decimal 12,2), porcentaje (decimal 5,2), timestamps                                                                                                       | —                                                                                         |
| **pedidos**                     | id, cliente\_id (FK), nivel\_descuento\_id (FK, nullable), monto\_bruto (decimal 12,2), monto\_final (decimal 12,2), estado (enum), fecha\_reparto (date, nullable), timestamps, softDeletes | fk cliente\_id → clientes.id · fk nivel\_descuento\_id → niveles\_descuento.id            |
| **pedido\_items**               | id, pedido\_id (FK), producto\_id (FK), cantidad (int), precio\_unit\_l1 (decimal 12,2), subtotal (decimal 12,2)                                                                             | fk pedido\_id → pedidos.id · fk producto\_id → productos.id                               |
| **movimientos\_stock**          | id, producto\_id (FK), pedido\_id (nullable FK), cantidad (int), motivo (string 40), created\_at (timestamp)                                                                                 | negativos = salidas · fk producto\_id → productos.id                                      |
| **vehiculos**                   | id, nombre (string 60), capacidad\_bultos (int), activo (boolean), timestamps                                                                                                                | —                                                                                         |
| **repartos**                    | id, pedido\_id (FK UNIQUE), vehiculo\_id (FK), ciudad\_id (FK), bultos (int), fecha (date), timestamps                                                                                       | fk pedido\_id → pedidos.id · fk vehiculo\_id → vehiculos.id · fk ciudad\_id → ciudades.id |
| **users**                       | Laravel Breeze/Filament estándar                                                                                                                                                             | —                                                                                         |
| **role\_has\_permissions** etc. | Tablas del paquete Spatie                                                                                                                                                                    | —                                                                                         |

4. Rutas Web / API y Controladores
| Método                   | URI                             | Controlador / Componente Livewire  | Función principal                                                 |
| ------------------------ | ------------------------------- | ---------------------------------- | ----------------------------------------------------------------- |
| GET                      | /dashboard                      | `DashboardController@index`        | KPIs generales                                                    |
| **Clientes**             |                                 |                                    |                                                                   |
| GET                      | /clientes                       | `ClienteController@index`          | Listar / buscar                                                   |
| POST                     | /clientes                       | `ClienteController@store`          | Crear                                                             |
| PUT                      | /clientes/{cliente}             | `ClienteController@update`         | Actualizar                                                        |
| DELETE                   | /clientes/{cliente}             | `ClienteController@destroy`        | Baja lógica                                                       |
| **Productos**            |                                 |                                    |                                                                   |
| Resource                 | /productos                      | `ProductoController`               | CRUD + importación desde Excel                                    |
| **Cotizador (Livewire)** |                                 |                                    |                                                                   |
| GET                      | /cotizador                      | `CotizadorLivewire`                | UI reactiva (añadir items, totales, descuentos)                   |
| POST                     | /cotizador/{draft}/confirmar    | `PedidoController@confirm`         | Valida stock, aplica descuento, crea pedido, descuenta inventario |
| GET                      | /pedidos/{pedido}/resumen-texto | `PedidoController@resumen`         | Genera bloque de texto formateado                                 |
| **Logística**            |                                 |                                    |                                                                   |
| GET                      | /repartos/agenda                | `RutaDiariaLivewire`               | Hoja de ruta diaria (tabs lunes-domingo)                          |
| POST                     | /repartos/{pedido}/asignar      | `RepartoController@store`          | Asignar ciudad, vehículo y bultos                                 |
| GET                      | /resumen-logistico              | `ResumenLogisticoController@index` | Totales de bultos y clientes por ciudad                           |
| **API Autocomplete**     |                                 |                                    |                                                                   |
| GET                      | /api/search/clientes            | `SearchController@clientes`        | JSON para Livewire Select2                                        |
| GET                      | /api/search/productos           | `SearchController@productos`       | idem                                                              |

5. Plan de Desarrollo por Fases
| Fase                               | Entregables clave                                                                                                                                | Herramientas / Notas                     |
| ---------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------- |
| **0 – Bootstrap**                  | \* Repo Git + Docker (nginx, php-fpm, pgsql)<br>\* Laravel 11 con Breeze + Sanctum<br>\* Filament instalado                                      | PHPUnit, Pint, PHPStan                   |
| **1 – Núcleo CRUD & Autocomplete** | \* Migraciones/seeders de clientes, productos, ciudades<br>\* Scout + Meilisearch para búsqueda<br>\* Spatie Permission (roles: admin, operador) | Factories, Filament scaffold             |
| **2 – Cotizador Draft**            | \* `CotizadorLivewire` (add/edit items)<br>\* Cálculo dinámico de monto y nivel de descuento<br>\* Validación de stock en vivo                   | Alpine.js debounce, pruebas de políticas |
| **3 – Confirmación y Stock**       | \* Endpoint confirmar (transacción atómica)<br>\* Registro en `movimientos_stock`<br>\* Generador de resumen-texto listo para copiar             | Eventos / Listeners para auditoría       |
| **4 – Logística Básica**           | \* `RutaDiariaLivewire` (tabs días)<br>\* CRUD vehículos<br>\* Asignación de pedidos a vehículos/ciudad + bultos                                 | Filament forms y relaciones pivot        |
| **5 – Resumen Logístico**          | \* Consulta agregada por ciudad (SUM bultos, COUNT clientes)<br>\* `ResumenLogisticoController` + vista Blade                                    | Eloquent aggregates                      |
| **6 – Hardening & Reuso**          | \* Tests E2E Laravel Dusk<br>\* Exportación Excel de hojas de ruta<br>\* Empaquetar módulos como Package                                         | Composer workspaces                      |
| **7 – Nice-to-Have**               | \* WebSockets Livewire para multi-usuario<br>\* API Mobile / WhatsApp<br>\* Optimización de rutas (VRP)                                          | Laravel Echo, Pusher, Jobs               |

Cada fase cierra con un tag Git y despliegue automático a staging para entregar valor temprano y facilitar la reutilización en futuros proyectos de tu agencia.


