# Guía de Diseño UX/UI - Sistema BAMBU
## Design System Definitivo basado en Implementaciones Exitosas

*Basado en análisis de screenshots de módulos modernizados: Dashboard, Clientes (List/Detail/Edit/Create)*

---

## 1. FILOSOFÍA DE DISEÑO VALIDADA

### Principios Fundamentales Confirmados
- **Dark Theme Consistente**: Fondo oscuro profesional en toda la aplicación (#2B2D42 / #1A1B3A)
- **Purple Accent Coherente**: Color violeta (#8B5CF6) como color primario para botones y elementos interactivos  
- **Layout Centrado**: Contenido centrado con máximo ancho controlado
- **Cards Semi-transparentes**: Elementos principales en cards oscuras con bordes sutiles
- **Tipografía Clara**: Texto blanco/gris claro sobre fondos oscuros para máximo contraste

---

## 2. PALETA DE COLORES IMPLEMENTADA

### Colores Base Confirmados
```css
:root {
  /* Backgrounds - Jerarquía Oscura */
  --bg-primary: #1A1B3A;      /* Fondo principal de página */
  --bg-secondary: #2B2D42;    /* Cards principales */
  --bg-tertiary: #3A3B5C;     /* Cards secundarias, headers */
  --bg-quaternary: #4A4D6A;   /* Elements hover */
  
  /* Purple Accent - Color Principal */
  --purple-primary: #8B5CF6;   /* Botones principales */
  --purple-hover: #7C3AED;     /* Hover states */
  --purple-light: #A78BFA;     /* Borders y acentos */
  --purple-ultra-light: rgba(139, 92, 246, 0.1); /* Backgrounds transparentes */
  
  /* Textos - Jerarquía Clara */
  --text-primary: #FFFFFF;     /* Títulos principales */
  --text-secondary: #E2E8F0;   /* Texto normal */
  --text-muted: #94A3B8;       /* Labels, metadata */
  --text-accent: #CBD5E1;      /* Elementos de apoyo */
  
  /* Estados Funcionales */
  --success: #10B981;          /* Success states */
  --warning: #F59E0B;          /* Warning states */
  --error: #EF4444;            /* Error states */
  --info: #3B82F6;             /* Info states */
}
```

### Colores Específicos por Provincia/Categoría
```css
/* Badges de Ubicación */
--badge-neuquen: #10B981;     /* Verde para Neuquén */
--badge-rio-negro: #3B82F6;   /* Azul para Río Negro */ 
--badge-cipolletti: #8B5CF6;  /* Violeta para Cipolletti */

/* Estados de Cliente */
--client-nuevo: #3B82F6;      /* Azul - Cliente Nuevo */
--client-prospecto: #F59E0B;  /* Amarillo - Prospecto */
--client-vip: #10B981;        /* Verde - Cliente VIP */
```

---

## 3. LAYOUT SYSTEM DEFINIDO

### 3.1 Container Principal
```css
/* Container Estándar para todas las páginas */
.bambu-container {
  max-width: 1400px;
  width: 95%;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Mobile responsive */
@media (max-width: 768px) {
  .bambu-container {
    width: 98%;
    padding: 0 0.5rem;
  }
}
```

### 3.2 Page Structure Consistente
```html
<!-- Estructura de página estándar -->
<body class="bambu-bg-primary">
  <nav class="bambu-navbar"><!-- Navbar --></nav>
  <main class="bambu-container py-6">
    <!-- Page Header -->
    <div class="bambu-page-header">
      <h1 class="bambu-title">Título de Página</h1>
      <button class="bambu-btn-primary">Acción Principal</button>
    </div>
    
    <!-- Content Cards -->
    <div class="bambu-content-grid">
      <!-- Cards de contenido -->
    </div>
  </main>
</body>
```

---

## 4. COMPONENTES PRINCIPALES

### 4.1 Dashboard Cards (Implementación Real)
```css
/* Cards principales del dashboard */
.bambu-dashboard-card {
  background: var(--bg-secondary);
  border: 1px solid rgba(139, 92, 246, 0.2);
  border-radius: 0.75rem;
  padding: 2rem;
  min-height: 280px;
  display: flex;
  flex-direction: column;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.bambu-dashboard-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
  border-color: rgba(139, 92, 246, 0.4);
}

/* Iconos de cards */
.bambu-card-icon {
  font-size: 3rem;
  color: var(--purple-primary);
  margin-bottom: 1rem;
}

/* Títulos de cards */
.bambu-card-title {
  color: var(--text-primary);
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 0.75rem;
}

/* Descripción de cards */
.bambu-card-description {
  color: var(--text-muted);
  font-size: 0.95rem;
  line-height: 1.5;
  flex: 1;
  margin-bottom: 1.5rem;
}
```

### 4.2 Sistema de Botones (Validado)
```css
/* Botón Primario - Purple */
.bambu-btn-primary {
  background: linear-gradient(135deg, var(--purple-primary) 0%, var(--purple-hover) 100%);
  border: none;
  color: white;
  padding: 0.75rem 1.5rem;
  border-radius: 0.5rem;
  font-weight: 600;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
  cursor: pointer;
}

.bambu-btn-primary:hover {
  background: linear-gradient(135deg, var(--purple-hover) 0%, #6D28D9 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(139, 92, 246, 0.4);
  color: white;
}

/* Botón Secundario */
.bambu-btn-secondary {
  background: transparent;
  border: 2px solid var(--purple-light);
  color: var(--purple-light);
  padding: 0.625rem 1.25rem;
  border-radius: 0.5rem;
  font-weight: 500;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.bambu-btn-secondary:hover {
  background: var(--purple-ultra-light);
  border-color: var(--purple-primary);
  color: var(--text-primary);
  transform: translateY(-1px);
}
```

### 4.3 Tablas Modernas (Basado en Lista de Clientes)
```css
/* Container de tabla */
.bambu-table-container {
  background: var(--bg-secondary);
  border: 1px solid rgba(139, 92, 246, 0.2);
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Header de tabla */
.bambu-table-header {
  background: var(--bg-tertiary);
  padding: 1.5rem 2rem;
  border-bottom: 1px solid rgba(139, 92, 246, 0.2);
  display: flex;
  justify-content: between;
  align-items: center;
}

.bambu-table-title {
  color: var(--text-primary);
  font-size: 1.25rem;
  font-weight: 600;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Tabla principal */
.bambu-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: transparent;
}

.bambu-table thead th {
  background: var(--bg-tertiary);
  color: var(--text-secondary);
  font-weight: 600;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  padding: 1rem;
  border-bottom: 1px solid rgba(139, 92, 246, 0.2);
  text-align: left;
}

.bambu-table tbody tr {
  background: var(--bg-secondary);
  border-bottom: 1px solid rgba(139, 92, 246, 0.1);
  transition: all 0.2s ease;
}

.bambu-table tbody tr:hover {
  background: rgba(139, 92, 246, 0.05);
  transform: translateX(2px);
}

.bambu-table tbody td {
  padding: 1rem;
  color: var(--text-secondary);
  vertical-align: middle;
}
```

### 4.4 Avatares Circulares (Cliente)
```css
/* Avatar circular con iniciales */
.bambu-avatar {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, var(--purple-primary) 0%, var(--purple-hover) 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1rem;
  color: white;
  text-transform: uppercase;
  flex-shrink: 0;
}

/* Tamaños alternativos */
.bambu-avatar-sm { width: 32px; height: 32px; font-size: 0.75rem; }
.bambu-avatar-lg { width: 64px; height: 64px; font-size: 1.25rem; }
```

### 4.5 Badges y Estados
```css
/* Badge base */
.bambu-badge {
  padding: 0.375rem 0.75rem;
  border-radius: 1rem;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
}

/* Variantes de badges */
.bambu-badge-neuquen {
  background: rgba(16, 185, 129, 0.2);
  color: #34D399;
  border: 1px solid rgba(16, 185, 129, 0.3);
}

.bambu-badge-rio-negro {
  background: rgba(59, 130, 246, 0.2);
  color: #60A5FA;
  border: 1px solid rgba(59, 130, 246, 0.3);
}

.bambu-badge-client-nuevo {
  background: rgba(59, 130, 246, 0.2);
  color: #93C5FD;
  border: 1px solid rgba(59, 130, 246, 0.3);
}

.bambu-badge-prospecto {
  background: rgba(245, 158, 11, 0.2);
  color: #FBBF24;
  border: 1px solid rgba(245, 158, 11, 0.3);
}
```

---

## 5. FORMULARIOS MODERNOS

### 5.1 Layout de Formularios (Basado en Create/Edit Cliente)
```css
/* Container principal de formulario */
.bambu-form-container {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 2rem;
  align-items: start;
}

/* Card principal del formulario */
.bambu-form-main {
  background: var(--bg-secondary);
  border: 1px solid rgba(139, 92, 246, 0.2);
  border-radius: 0.75rem;
  padding: 2rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Sidebar de guía */
.bambu-form-sidebar {
  background: var(--bg-tertiary);
  border: 1px solid rgba(139, 92, 246, 0.2);
  border-radius: 0.75rem;
  padding: 1.5rem;
  position: sticky;
  top: 2rem;
}

/* Header del formulario */
.bambu-form-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(139, 92, 246, 0.2);
}

.bambu-form-icon {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, var(--purple-primary) 0%, var(--purple-hover) 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
}

/* Mobile responsive */
@media (max-width: 768px) {
  .bambu-form-container {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
}
```

### 5.2 Inputs y Form Controls
```css
/* Label estándar */
.bambu-label {
  color: var(--text-secondary);
  font-weight: 600;
  font-size: 0.875rem;
  margin-bottom: 0.5rem;
  display: block;
}

.bambu-label-required::after {
  content: ' *';
  color: var(--error);
}

/* Input estándar */
.bambu-input {
  background: rgba(139, 92, 246, 0.05);
  border: 2px solid rgba(139, 92, 246, 0.2);
  border-radius: 0.5rem;
  color: var(--text-primary);
  padding: 0.75rem 1rem;
  font-size: 0.95rem;
  width: 100%;
  transition: all 0.3s ease;
}

.bambu-input:focus {
  outline: none;
  border-color: var(--purple-primary);
  background: rgba(139, 92, 246, 0.1);
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.bambu-input::placeholder {
  color: var(--text-muted);
}

/* Select estándar */
.bambu-select {
  background: rgba(139, 92, 246, 0.05);
  border: 2px solid rgba(139, 92, 246, 0.2);
  border-radius: 0.5rem;
  color: var(--text-primary);
  padding: 0.75rem 1rem;
  font-size: 0.95rem;
  width: 100%;
  transition: all 0.3s ease;
  cursor: pointer;
}

.bambu-select:focus {
  outline: none;
  border-color: var(--purple-primary);
  background: rgba(139, 92, 246, 0.1);
}

/* Estados de error */
.bambu-input-error {
  border-color: var(--error);
  background: rgba(239, 68, 68, 0.05);
}

.bambu-error-message {
  color: #FCA5A5;
  font-size: 0.875rem;
  margin-top: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.25rem;
}
```

---

## 6. NAVEGACIÓN Y BREADCRUMBS

### 6.1 Navbar Principal
```css
/* Navbar principal dark */
.bambu-navbar {
  background: var(--bg-tertiary);
  border-bottom: 1px solid rgba(139, 92, 246, 0.2);
  padding: 1rem 0;
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(10px);
}

.bambu-navbar-content {
  max-width: 1400px;
  width: 95%;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Logo */
.bambu-logo {
  color: var(--text-primary);
  font-size: 1.5rem;
  font-weight: 700;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Nav links */
.bambu-nav-links {
  display: flex;
  gap: 2rem;
  list-style: none;
  margin: 0;
  padding: 0;
}

.bambu-nav-link {
  color: var(--text-secondary);
  text-decoration: none;
  font-weight: 500;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.bambu-nav-link:hover,
.bambu-nav-link.active {
  color: var(--text-primary);
  background: rgba(139, 92, 246, 0.1);
}
```

### 6.2 Breadcrumbs
```css
/* Breadcrumb navigation */
.bambu-breadcrumb {
  margin-bottom: 2rem;
  padding: 0.75rem 1rem;
  background: rgba(139, 92, 246, 0.05);
  border: 1px solid rgba(139, 92, 246, 0.2);
  border-radius: 0.5rem;
}

.bambu-breadcrumb-list {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  list-style: none;
  margin: 0;
  padding: 0;
  font-size: 0.875rem;
}

.bambu-breadcrumb-item {
  color: var(--text-muted);
}

.bambu-breadcrumb-link {
  color: var(--purple-light);
  text-decoration: none;
  transition: color 0.3s ease;
}

.bambu-breadcrumb-link:hover {
  color: var(--text-primary);
}

.bambu-breadcrumb-separator {
  color: var(--text-muted);
  margin: 0 0.25rem;
}

.bambu-breadcrumb-current {
  color: var(--text-primary);
  font-weight: 600;
}
```

---

## 7. RESPONSIVIDAD DEFINIDA

### 7.1 Breakpoints Estándar
```css
/* Breakpoints definidos */
:root {
  --breakpoint-sm: 640px;
  --breakpoint-md: 768px;
  --breakpoint-lg: 1024px;
  --breakpoint-xl: 1280px;
  --breakpoint-2xl: 1536px;
}

/* Mobile First Approach */
@media (max-width: 640px) {
  .bambu-container { width: 98%; padding: 0 0.5rem; }
  .bambu-dashboard-grid { grid-template-columns: 1fr; }
  .bambu-form-container { grid-template-columns: 1fr; }
  .bambu-table-container { margin: 0 -1rem; border-radius: 0; }
}

@media (min-width: 641px) and (max-width: 768px) {
  .bambu-dashboard-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (min-width: 769px) and (max-width: 1024px) {
  .bambu-dashboard-grid { grid-template-columns: repeat(2, 1fr); }
  .bambu-form-container { grid-template-columns: 2fr 1fr; }
}

@media (min-width: 1025px) {
  .bambu-dashboard-grid { grid-template-columns: repeat(3, 1fr); }
  .bambu-form-container { grid-template-columns: 2fr 1fr; }
}
```

---

## 8. PÁGINAS ESPECÍFICAS

### 8.1 Dashboard Principal
```css
/* Layout del dashboard */
.bambu-dashboard {
  padding: 2rem 0;
}

.bambu-dashboard-hero {
  text-align: center;
  margin-bottom: 3rem;
}

.bambu-dashboard-title {
  color: var(--text-primary);
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.bambu-dashboard-subtitle {
  color: var(--text-muted);
  font-size: 1.25rem;
  margin-bottom: 2rem;
}

.bambu-dashboard-badge {
  background: var(--purple-ultra-light);
  color: var(--purple-light);
  padding: 0.5rem 1rem;
  border-radius: 1rem;
  font-size: 0.875rem;
  font-weight: 600;
  border: 1px solid rgba(139, 92, 246, 0.3);
}

.bambu-dashboard-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  margin-bottom: 3rem;
}
```

### 8.2 Lista de Elementos
```css
/* Header de listado */
.bambu-list-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.bambu-list-title {
  color: var(--text-primary);
  font-size: 2rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin: 0;
}

.bambu-list-stats {
  color: var(--text-muted);
  font-size: 0.875rem;
  margin-top: 0.25rem;
}
```

---

## 9. MICRO-INTERACCIONES Y ANIMACIONES

### 9.1 Transiciones Estándar
```css
/* Transiciones base */
.bambu-transition {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.bambu-transition-fast {
  transition: all 0.15s ease;
}

.bambu-transition-slow {
  transition: all 0.5s ease;
}

/* Hover effects */
.bambu-hover-lift:hover {
  transform: translateY(-2px);
}

.bambu-hover-scale:hover {
  transform: scale(1.02);
}

/* Focus states */
.bambu-focus-ring:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}
```

### 9.2 Loading States
```css
/* Loading spinner */
.bambu-spinner {
  width: 24px;
  height: 24px;
  border: 2px solid transparent;
  border-top: 2px solid var(--purple-primary);
  border-radius: 50%;
  animation: bambu-spin 1s linear infinite;
}

@keyframes bambu-spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Loading button state */
.bambu-btn-loading {
  opacity: 0.7;
  cursor: not-allowed;
  pointer-events: none;
}
```

---

## 10. UTILIDADES Y HELPERS

### 10.1 Espaciado Consistente
```css
/* Sistema de espaciado */
.bambu-p-0 { padding: 0; }
.bambu-p-1 { padding: 0.25rem; }
.bambu-p-2 { padding: 0.5rem; }
.bambu-p-3 { padding: 0.75rem; }
.bambu-p-4 { padding: 1rem; }
.bambu-p-6 { padding: 1.5rem; }
.bambu-p-8 { padding: 2rem; }

.bambu-m-0 { margin: 0; }
.bambu-m-1 { margin: 0.25rem; }
.bambu-m-2 { margin: 0.5rem; }
.bambu-m-3 { margin: 0.75rem; }
.bambu-m-4 { margin: 1rem; }
.bambu-m-6 { margin: 1.5rem; }
.bambu-m-8 { margin: 2rem; }

/* Espaciado específico */
.bambu-gap-2 { gap: 0.5rem; }
.bambu-gap-4 { gap: 1rem; }
.bambu-gap-6 { gap: 1.5rem; }
```

### 10.2 Texto y Tipografía
```css
/* Jerarquía de texto */
.bambu-text-xs { font-size: 0.75rem; }
.bambu-text-sm { font-size: 0.875rem; }
.bambu-text-base { font-size: 1rem; }
.bambu-text-lg { font-size: 1.125rem; }
.bambu-text-xl { font-size: 1.25rem; }
.bambu-text-2xl { font-size: 1.5rem; }
.bambu-text-3xl { font-size: 1.875rem; }

/* Pesos de fuente */
.bambu-font-normal { font-weight: 400; }
.bambu-font-medium { font-weight: 500; }
.bambu-font-semibold { font-weight: 600; }
.bambu-font-bold { font-weight: 700; }

/* Colores de texto */
.bambu-text-primary { color: var(--text-primary); }
.bambu-text-secondary { color: var(--text-secondary); }
.bambu-text-muted { color: var(--text-muted); }
.bambu-text-accent { color: var(--text-accent); }
```

---

## 11. IMPLEMENTACIÓN PRÁCTICA

### 11.1 Checklist de Implementación para Nuevos Módulos

**1. Setup Base:**
- [ ] Aplicar `bambu-bg-primary` al body
- [ ] Usar `bambu-container` para el layout principal
- [ ] Implementar estructura de `bambu-page-header`

**2. Componentes:**
- [ ] Cards con clase `bambu-dashboard-card` o `bambu-form-main`
- [ ] Botones con `bambu-btn-primary` / `bambu-btn-secondary`
- [ ] Inputs con `bambu-input` / `bambu-select`
- [ ] Tablas con `bambu-table-container` + `bambu-table`

**3. Elementos Específicos:**
- [ ] Avatares con `bambu-avatar`
- [ ] Badges con `bambu-badge-*`
- [ ] Breadcrumbs con `bambu-breadcrumb`

**4. Responsive:**
- [ ] Verificar en mobile (< 640px)
- [ ] Verificar en tablet (640px - 1024px)
- [ ] Verificar en desktop (> 1024px)

### 11.2 Archivos CSS Requeridos
```html
<!-- En el <head> de cada página -->
<link href="/css/bambu-design-system.css" rel="stylesheet">
<style>
  body { background: #1A1B3A; color: #FFFFFF; }
</style>
```

---

## 12. MANTENIMIENTO Y EVOLUCIÓN

### 12.1 Principios de Mantenimiento
1. **Consistencia Primero**: Cualquier cambio debe aplicarse a todos los módulos
2. **Mobile First**: Siempre probar en móvil antes que desktop
3. **Accesibilidad**: Mantener contraste mínimo 4.5:1
4. **Performance**: CSS optimizado, sin redundancias

### 12.2 Proceso de Actualización
1. Actualizar este documento con nuevos patrones
2. Implementar en un módulo piloto
3. Validar en todos los breakpoints
4. Aplicar a todos los módulos existentes
5. Documentar lecciones aprendidas

---

## CONCLUSIÓN

Este design system está validado por implementaciones reales y exitosas en los módulos de Dashboard, Lista de Clientes, Detalle de Cliente, Edición de Cliente y Creación de Cliente. 

**Garantiza:**
- ✅ Consistencia visual completa
- ✅ Experiencia de usuario fluida
- ✅ Mantenibilidad a largo plazo
- ✅ Escalabilidad para nuevos módulos
- ✅ Responsive design robusto

**Para aplicar a Productos, Ciudades, Repartos, etc:**
Seguir exactamente estos patrones asegura que todas las secciones tengan el mismo nivel de calidad y profesionalismo que los módulos ya modernizados exitosamente.

---

*Documento basado en análisis visual de implementaciones reales - Sistema BAMBU 2025*