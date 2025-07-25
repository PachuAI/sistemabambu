### **Documento de Requerimientos: Sistema de Gestión Integral - BAMBU**

**1. Resumen del Proyecto**

El objetivo es desarrollar una aplicación web centralizada para reemplazar el actual ecosistema de trabajo fragmentado de la empresa BAMBU, compuesto por el software Enexpro y múltiples planillas de cálculo (Excel/Google Sheets). El nuevo sistema debe unificar y automatizar los procesos de cotización, gestión de pedidos, control de stock y planificación logística de repartos, eliminando la carga manual de datos y los errores derivados de esta.

**2. Contexto Operativo Actual**

- **2.1. Herramientas Utilizadas:**
    - **Enexpro:** Software de escritorio usado históricamente para el control de stock de productos de reventa (marca Saphirus).
    - **Cotizador en Hojas de Cálculo:** La herramienta principal para el armado de presupuestos de los productos de fabricación propia. Funciona con múltiples pestañas para manejar cotizaciones simultáneas.
    - **Registro de Reparto en Hojas de Cálculo:** Una planilla separada, alimentada manualmente desde el Cotizador, para planificar la logística de entregas diarias.
- **2.2. Contexto Histórico de la Operativa:**
    - La empresa fabrica sus propios productos de limpieza (marca BAMBU) y también revende productos de un tercero (marca Saphirus).
    - Esta división de productos originó el uso de dos sistemas: Enexpro para el stock finito de Saphirus y el Cotizador de Excel para los productos propios, cuyo stock no se controlaba.
- **2.3. Nuevo Objetivo de Negocio (Requerimiento Clave):**
    - La empresa ha decidido unificar su operativa. El nuevo sistema debe abandonar la distinción entre tipos de producto.
    - Se requiere implementar un **control de stock para todos los productos del catálogo**, tanto los de reventa como los de fabricación propia. El cliente adoptará este nuevo proceso de control como parte de la implementación del sistema.

**3. Requerimientos Funcionales por Módulo**

**3.1. Módulo 1: Núcleo del Sistema (Clientes y Productos/Stock)**

- **3.1.1. Entidad: Clientes**
    - El sistema debe permitir la gestión (alta, baja, modificación) de clientes.
    - Campos requeridos por cliente:
        - `Dirección`: Utilizada como identificador principal.
        - `Teléfono`.
        - `Nombre / Referencia`: Un nuevo campo para un alias o nombre de contacto que facilite la identificación.
    - Debe existir una función de búsqueda predictiva de clientes en la interfaz del cotizador.
- **3.1.2. Entidad: Productos**
    - El sistema debe permitir la gestión (alta, baja, modificación) de productos.
    - Campos requeridos por producto:
        - `Nombre`.
        - `SKU` o código de identificación.
        - `Precio_Base_L1`: El precio de lista base sobre el cual se calcularán todos los descuentos.
        - `Stock_Actual`: Campo numérico para el control de inventario de **todos** los productos.

**3.2. Módulo 2: Cotizador y Gestor de Pedidos**

- **3.2.1. Flujo de Creación de Pedido**
    - El usuario debe poder seleccionar un cliente para iniciar una nueva cotización.
    - Debe poder añadir productos al pedido, especificando la cantidad para cada uno.
    - La interfaz debe mostrar en tiempo real la lista de productos, cantidades, precios y subtotales.
- **3.2.2. Reglas de Negocio (Automatización Mandatoria)**
    - **Regla de Precios Dinámica:**
        - El sistema debe calcular el monto total del pedido en tiempo real.
        - Basado en este monto, debe determinar y aplicar automáticamente un nivel de descuento (L2, L3, L4).
        - Este descuento es un porcentaje que se aplica **siempre sobre el `Precio_Base_L1`** de cada producto.
        - Los productos categorizados como "Combos" deben ser excluidos del cálculo del monto total para determinar el nivel de descuento a aplicar.
    - **Validación de Stock en Tiempo Real:** El sistema debe consultar el `Stock_Actual` (del Módulo 1) y no permitir la venta de productos sin existencias suficientes.
- **3.2.3. Salidas (Outputs) del Módulo**
    - **Generación de Resumen para Comunicación Externa:**
        - Debe haber una función para generar un bloque de texto formateado listo para copiar.
        - Contenido del bloque: `Dirección` del cliente, `Teléfono`, `Monto Total Final` y la `Lista de Artículos`.
        - La lista de artículos en este resumen debe ser **ordenada automáticamente** según una prioridad predefinida (ej. líquidos y bultos primero).
    - **Persistencia de Pedidos:**
        - Debe existir una función para "Confirmar Pedido" que lo guarde en la base de datos con un estado y descuente las unidades correspondientes del stock central.

**3.3. Módulo 3: Logística y Repartos**

- **3.3.1. Hoja de Ruta Diaria**
    - El sistema debe generar una vista de todos los pedidos confirmados, agrupados por día de reparto. Las pestañas del Excel actual (LUNES, MARTES, etc.) deben ser replicadas funcionalmente.
    - En esta vista, cada pedido debe mostrar la información relevante pegada desde el cotizador (cliente, detalle de productos) y permitir la asignación de `Ciudad` y `Reparto` (vehículo/repartidor).
    - Debe permitir la entrada manual del número de `bultos` por pedido.
- **3.3.2. Vista de Resumen Logístico (Requerimiento Clave)**
    - El sistema debe poder generar una vista de resumen consolidada para el día seleccionado.
    - Esta vista debe agrupar la información por `CIUDAD`.
    - Para cada ciudad, debe mostrar dos datos calculados:
        - La **suma total de BULTOS**.
        - El **conteo total de CLIENTES** a visitar.
    - El propósito de esta vista es permitir una planificación logística estratégica, balanceando capacidad de carga y tiempo de entrega.