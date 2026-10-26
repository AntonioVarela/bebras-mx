# Guía de Verificación: Fix de Scroll en iPad para Preguntas 4 y 6

## 🎯 Objetivo
Verificar que las preguntas tipo "ordenar" (preguntas 4 y 6) ahora permiten hacer scroll vertical en dispositivos iPad/Safari con touch.

## 📋 Checklist de Verificación

### ✅ Prueba 1: iPad Real o Emulado
1. **Iniciar el servidor**:
   ```bash
   php artisan serve
   npm run dev  # En otra terminal
   ```

2. **Acceder desde iPad o emular iPad en Chrome DevTools**:
   - Abrir Chrome DevTools (F12)
   - Activar "Toggle device toolbar" (Ctrl+Shift+M)
   - Seleccionar "iPad Pro" o "iPad Air"
   - Importante: Activar el modo "Touch" (no mouse)

3. **Navegar a las preguntas problemáticas**:
   - Pregunta 4: "5 Dulces" - `/preguntas/4` (o el ID correspondiente)
   - Pregunta 6: "Palillos Chinos" - `/preguntas/6` (o el ID correspondiente)

4. **Verificar scroll**:
   - ✅ Se puede hacer scroll vertical en el área "Disponibles" (izquierda)
   - ✅ Se puede hacer scroll vertical en el área "Orden correcto" (derecha)
   - ✅ El scroll funciona con gestos táctiles (arrastrar hacia arriba/abajo)

5. **Verificar drag-and-drop**:
   - ✅ Al mantener presionado ~150ms, se inicia el drag
   - ✅ Se pueden arrastrar elementos de "Disponibles" a "Orden correcto"
   - ✅ Se pueden reordenar elementos dentro de "Orden correcto"
   - ✅ Feedback visual: elemento se vuelve semi-transparente al arrastrar

### ✅ Prueba 2: Escritorio (No Romper Funcionalidad Existente)
1. **En modo escritorio normal**:
   - ✅ El drag-and-drop funciona inmediatamente (sin delay)
   - ✅ Se pueden arrastrar elementos con el mouse
   - ✅ El scroll con rueda del mouse funciona en ambas áreas

### ✅ Prueba 3: Otras Preguntas
Verificar que otros tipos de preguntas no se rompieron:
- Pregunta 1: "Libros Populares" (selección simple)
- Pregunta 2: "Tutorial de Dibujo" (ordenar - debería tener el mismo fix)
- Pregunta 3: "Receta de Hamburguesas" (selección simple)
- Pregunta 5: "¿Dónde quedó la bolita?" (verificar tipo)

## 🔍 Comportamiento Esperado vs Anterior

### ❌ Antes (Comportamiento Incorrecto)
- En iPad: tocar y arrastrar hacia arriba/abajo NO hacía scroll
- El contenido quedaba bloqueado si había muchos elementos
- SortableJS capturaba todos los eventos touch

### ✅ Después (Comportamiento Correcto)
- En iPad: tocar y arrastrar hacia arriba/abajo hace scroll inmediatamente
- Mantener presionado ~150ms en un elemento inicia el drag
- El usuario puede hacer scroll normalmente Y arrastrar elementos

## 🛠️ Debugging en Caso de Problemas

### Si el scroll NO funciona:
```javascript
// En Chrome DevTools Console:
const fuente = document.getElementById('elementos-fuente');
const area = document.getElementById('area-ordenamiento');
console.log('Fuente touch-action:', window.getComputedStyle(fuente).touchAction);
console.log('Area touch-action:', window.getComputedStyle(area).touchAction);
// Debe mostrar "pan-y" para ambos
```

### Si el drag NO funciona:
```javascript
// En Chrome DevTools Console:
const sortables = Sortable.get(document.getElementById('elementos-fuente'));
console.log('Sortable config:', sortables.options);
// Debe mostrar delay: 150 (en touch)
```

## 📝 Notas Técnicas

### Cambios Implementados:
1. **CSS**: `touch-action: pan-y` en contenedores scrollables
2. **JS**: Delay de 150ms en dispositivos touch para distinguir scroll de drag
3. **JS**: `forceFallback: true` para consistencia cross-browser
4. **JS**: `scrollSensitivity` y `bubbleScroll` para mejor auto-scroll

### Archivos Modificados:
- `resources/views/preguntas/tipos/ordenar.blade.php`
- `resources/views/preguntas/scripts/ordenar.blade.php`

## ✅ Criterios de Aceptación
- [ ] Scroll funciona en iPad Safari (ambas áreas)
- [ ] Drag-and-drop funciona en iPad con mantener presionado
- [ ] Drag-and-drop funciona en escritorio sin delays
- [ ] No se rompió funcionalidad en otros tipos de pregunta
- [ ] Modo oscuro sigue funcionando correctamente
