# 🔧 Fix: Scroll en Preguntas Tipo Ordenar en iPad/Safari

## 📋 Resumen

Este PR soluciona el problema reportado donde las **preguntas 4 y 6** no permitían hacer scroll en dispositivos iPad (Safari/iPadOS con touch). El contenido de las áreas de drag-and-drop quedaba bloqueado e inaccesible.

## 🎯 Preguntas Afectadas

- **Pregunta 4**: "5 Dulces" (`tipo_interaccion: 'ordenar'`)
- **Pregunta 6**: "Palillos Chinos" (`tipo_interaccion: 'ordenar'`)

## 🔍 Causa del Problema

La biblioteca **SortableJS** estaba capturando todos los eventos touch para implementar drag-and-drop, bloqueando el scroll nativo del navegador en contenedores con `overflow-y-auto`.

**Causas técnicas**:
1. ❌ Falta de `touch-action` CSS en contenedores scrollables
2. ❌ Sin delay en eventos touch para distinguir scroll de drag
3. ❌ Configuración de SortableJS no optimizada para touch

## ✅ Solución

### 1. CSS: Permitir Scroll Vertical
```css
/* Contenedores: permitir scroll */
#elementos-fuente,
#area-ordenamiento {
    touch-action: pan-y !important;  /* ← Gestos verticales = scroll */
    -webkit-overflow-scrolling: touch;
}

/* Elementos: permitir drag */
.elemento-draggable {
    touch-action: none;  /* ← Solo elementos capturan touch */
}
```

### 2. JavaScript: Configuración Touch-Friendly
```javascript
const sortableConfig = {
    forceFallback: true,           // Mejor control en touch
    fallbackTolerance: 5,          // 5px antes de iniciar drag
    delay: isTouchDevice ? 150 : 0,  // 150ms delay en touch
    delayOnTouchOnly: true,
    scrollSensitivity: 60,
    scrollSpeed: 15,
    bubbleScroll: true
};
```

**Lógica**: 
- En **touch**: Si el usuario toca y mueve inmediatamente → scroll. Si mantiene presionado 150ms → drag.
- En **desktop**: Drag inmediato (sin cambios).

## 📁 Archivos Modificados

```
resources/views/preguntas/tipos/ordenar.blade.php
resources/views/preguntas/scripts/ordenar.blade.php
```

## 🧪 Testing

Ver guía completa en **`TESTING_SCROLL_FIX.md`**

### Checklist Rápido
- [ ] Scroll funciona en iPad Safari (preguntas 4 y 6)
- [ ] Drag-and-drop funciona en iPad (mantener presionado ~150ms)
- [ ] Drag-and-drop funciona en desktop (sin delay)
- [ ] No se rompió funcionalidad en otros tipos de pregunta

### Emular iPad en Chrome DevTools
1. Abrir DevTools (F12)
2. Toggle device toolbar (Ctrl+Shift+M)
3. Seleccionar "iPad Pro" o "iPad Air"
4. **Importante**: Activar modo "Touch" (no mouse)
5. Navegar a pregunta 4 o 6
6. Verificar que se puede hacer scroll Y drag

## 📚 Documentación Adicional

- **`TESTING_SCROLL_FIX.md`**: Guía detallada de testing
- **`TECHNICAL_ANALYSIS.md`**: Análisis técnico profundo de la solución

## ⚠️ Otros Tipos de Pregunta con Drag-and-Drop

Los siguientes tipos de pregunta también usan SortableJS pero **NO fueron reportados** como problemáticos:

- `completar` (algunas variantes usan drag-and-drop)
- `colocar_piezas` (ya tiene `touch-action: manipulation`)
- `rompecabezas_hexagonos` (ya tiene `touch-action: manipulation`)
- `tejer_alfombra` (posiblemente)

**Recomendación**: Si se reportan problemas de scroll en estos tipos de pregunta en iPad, aplicar el mismo fix:
1. Agregar `touch-action: pan-y` a contenedores scrollables
2. Agregar configuración de SortableJS con delay y forceFallback

## 🚀 Deploy

Una vez aprobado el PR:
1. Merge a `main`
2. Deploy a producción
3. Verificar en dispositivo iPad real (si es posible)

## 🔗 Referencias

- [MDN: touch-action](https://developer.mozilla.org/en-US/docs/Web/CSS/touch-action)
- [SortableJS Mobile Support](https://github.com/SortableJS/Sortable#mobile-support)
- [Safari Touch Events](https://developer.apple.com/documentation/webkit/safari_web_extensions/handling_touch_events)

---

**PR**: [#1](https://github.com/AntonioVarela/bebras-mx/pull/1)  
**Branch**: `cursor/fix-scroll-ordenar-ipad-1a17`  
**Autor**: Cloud Agent (Cursor)  
**Fecha**: 2026-10-26
