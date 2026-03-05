<script>
    let colocaciones = {}; // { "fila-columna": {id, color, rotacion, imagen?} }
    const config = @json($config ?? []);
    const piezasDisponibles = config.piezas_disponibles || [];
    const estructura = config.estructura || [];
    const colores = config.colores || ['red', 'blue', 'green'];

    // Inicializar drag and drop
    document.addEventListener('DOMContentLoaded', function() {
        inicializarDragAndDrop();
        actualizarResumen();
    });

    function inicializarDragAndDrop() {
        const piezasDisponiblesEl = document.getElementById('piezas-disponibles');
        const celdasRompecabezas = document.querySelectorAll('.celda-hexagono[data-fija="false"]');

        // Configurar elementos arrastrables (piezas)
        piezasDisponiblesEl.querySelectorAll('.pieza-item').forEach(pieza => {
            pieza.addEventListener('dragstart', function(e) {
                e.dataTransfer.setData('text/plain', JSON.stringify({
                    id: this.dataset.piezaId,
                    color: this.dataset.color,
                    imagen: this.dataset.imagen || ''
                }));
                this.classList.add('dragging');
            });

            pieza.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
                document.querySelectorAll('.celda-hexagono').forEach(celda => {
                    celda.classList.remove('drag-over');
                });
            });
        });

        // Configurar zonas de destino (celdas del rompecabezas)
        celdasRompecabezas.forEach(celda => {
            celda.addEventListener('dragover', function(e) {
                e.preventDefault();
                if (!this.classList.contains('ocupada') && this.dataset.fija !== 'true') {
                    this.classList.add('drag-over');
                }
            });

            celda.addEventListener('dragleave', function(e) {
                this.classList.remove('drag-over');
            });

            celda.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');

                const piezaData = JSON.parse(e.dataTransfer.getData('text/plain'));
                
                if (!piezaData || !piezaData.id) return;

                // Verificar si la celda ya está ocupada
                if (this.classList.contains('ocupada')) {
                    mostrarMensaje('Esta celda ya está ocupada. Remueve la pieza primero.', 'warning');
                    return;
                }

                // Validar regla del triángulo antes de colocar
                const fila = parseInt(this.dataset.fila);
                const columna = parseInt(this.dataset.columna);
                
                if (!validarTriangulo(fila, columna, piezaData.color)) {
                    mostrarMensaje('Esta colocación no cumple la regla del triángulo. Todas las piezas deben ser del mismo color O todas de colores diferentes.', 'warning');
                    return;
                }

                // Verificar si la pieza ya está colocada en otra celda
                const celdaAnterior = encontrarCeldaConPieza(piezaData.id);
                if (celdaAnterior) {
                    removerPiezaDeCelda(celdaAnterior);
                }

                // Colocar pieza en la nueva celda
                colocarPiezaEnCelda(this, piezaData);
            });

            // Permitir doble clic para remover pieza
            celda.addEventListener('dblclick', function(e) {
                if (this.classList.contains('ocupada')) {
                    removerPiezaDeCelda(this);
                }
            });

            // Click simple para rotar pieza ya colocada
            celda.addEventListener('click', function(e) {
                if (!this.classList.contains('ocupada')) {
                    return;
                }
                if (this.dataset.fija === 'true') {
                    return;
                }
                rotarPiezaEnCelda(this);
            });
        });
    }

    function rotarPiezaEnCelda(celda) {
        const fila = parseInt(celda.dataset.fila);
        const columna = parseInt(celda.dataset.columna);
        const clave = `${fila}-${columna}`;

        if (!colocaciones[clave]) {
            return;
        }

        const rotacionActual = parseInt(celda.dataset.rotacion || '0');
        const nuevaRotacion = (rotacionActual + 60) % 360; // rotar de 60 en 60 grados
        celda.dataset.rotacion = nuevaRotacion;

        const contenedorPieza = celda.querySelector('.pieza-en-celda');
        if (contenedorPieza) {
            contenedorPieza.style.transform = `rotate(${nuevaRotacion}deg)`;
        }

        colocaciones[clave].rotacion = nuevaRotacion;
    }

    function validarTriangulo(fila, columna, colorNuevo) {
        // La regla: el triángulo formado (pieza nueva + 2 de abajo) debe tener:
        // - Todas del mismo color O
        // - Todas de colores diferentes
        
        // Obtener las 2 piezas de abajo (fila + 1, columna y columna + 1)
        const piezaAbajo1 = obtenerPiezaEnPosicion(fila + 1, columna);
        const piezaAbajo2 = obtenerPiezaEnPosicion(fila + 1, columna + 1);
        
        // Si no hay 2 piezas de abajo, no se puede validar (pero se permite colocar)
        if (!piezaAbajo1 || !piezaAbajo2) {
            return true; // Se permite si no hay piezas de abajo aún
        }
        
        const colores = [colorNuevo, piezaAbajo1.color, piezaAbajo2.color];
        
        // Verificar si todas son del mismo color
        const todosIguales = colores.every(c => c === colores[0]);
        
        // Verificar si todas son de colores diferentes
        const todosDiferentes = new Set(colores).size === 3;
        
        return todosIguales || todosDiferentes;
    }

    function obtenerPiezaEnPosicion(fila, columna) {
        const clave = `${fila}-${columna}`;
        if (colocaciones[clave]) {
            return colocaciones[clave];
        }
        
        // También verificar si hay una pieza fija en esa posición
        const celda = document.querySelector(`.celda-hexagono[data-fila="${fila}"][data-columna="${columna}"][data-fija="true"]`);
        if (celda) {
            return {
                id: celda.dataset.id || 'fija',
                color: celda.dataset.color
            };
        }
        
        return null;
    }

    function colocarPiezaEnCelda(celda, piezaData) {
        const fila = parseInt(celda.dataset.fila);
        const columna = parseInt(celda.dataset.columna);
        const clave = `${fila}-${columna}`;
        const rotacion = piezaData.rotacion !== undefined ? piezaData.rotacion : 0;

        // Marcar celda como ocupada
        celda.classList.add('ocupada');
        celda.dataset.ocupada = 'true';
        celda.dataset.piezaId = piezaData.id;
        celda.dataset.color = piezaData.color;
        celda.dataset.rotacion = rotacion;

        // Ocultar número de celda
        const numeroCelda = celda.querySelector('span');
        if (numeroCelda) {
            numeroCelda.style.display = 'none';
        }

        // Mostrar pieza en la celda
        const contenedorPieza = celda.querySelector('.pieza-en-celda');
        if (contenedorPieza) {
            const span = contenedorPieza.querySelector('span');
            const img = contenedorPieza.querySelector('.pieza-en-celda-imagen');

            if (piezaData.imagen) {
                // Mostrar imagen de la pieza
                contenedorPieza.style.backgroundColor = '';
                contenedorPieza.style.borderColor = '';
                if (img) {
                    img.src = `/storage/${piezaData.imagen}`;
                    img.alt = `Pieza ${piezaData.id}`;
                    img.classList.remove('hidden');
                }
                if (span) {
                    span.textContent = '';
                }
            } else {
                // Mostrar pieza como hexágono de color con letra
                contenedorPieza.style.backgroundColor = piezaData.color;
                contenedorPieza.style.borderColor = piezaData.color;
                if (img) {
                    img.classList.add('hidden');
                    img.removeAttribute('src');
                }
                if (span) {
                    span.textContent = piezaData.id;
                }
            }

            contenedorPieza.style.transform = `rotate(${rotacion}deg)`;
            contenedorPieza.classList.remove('hidden');
        }

        // Guardar colocación
        colocaciones[clave] = {
            id: piezaData.id,
            color: piezaData.color,
            rotacion: rotacion,
            imagen: piezaData.imagen || null
        };

        // Remover pieza de la lista de disponibles
        removerPiezaDeLista(piezaData.id);

        actualizarResumen();
        actualizarContadores();
        mostrarMensaje(`Pieza ${piezaData.id} colocada correctamente`, 'success');
    }

    function removerPiezaDeCelda(celda) {
        const fila = parseInt(celda.dataset.fila);
        const columna = parseInt(celda.dataset.columna);
        const clave = `${fila}-${columna}`;
        const piezaId = celda.dataset.piezaId;

        if (!piezaId) return;

        // Remover marca de ocupada
        celda.classList.remove('ocupada');
        celda.dataset.ocupada = 'false';
        delete celda.dataset.piezaId;
        delete celda.dataset.color;

        // Mostrar número de celda
        const numeroCelda = celda.querySelector('span');
        if (numeroCelda) {
            numeroCelda.style.display = 'block';
        }

        // Ocultar pieza
        const contenedorPieza = celda.querySelector('.pieza-en-celda');
        if (contenedorPieza) {
            contenedorPieza.classList.add('hidden');
        }

        // Remover de colocaciones
        delete colocaciones[clave];

        // Regresar pieza a la lista de disponibles
        regresarPiezaALista(piezaId);

        actualizarResumen();
        actualizarContadores();
        mostrarMensaje(`Pieza ${piezaId} removida`, 'info');
    }

    function removerPiezaDeLista(piezaId) {
        const piezaItem = document.querySelector(`[data-pieza-id="${piezaId}"]`);
        if (piezaItem) {
            piezaItem.style.display = 'none';
        }
    }

    function regresarPiezaALista(piezaId) {
        const piezaItem = document.querySelector(`[data-pieza-id="${piezaId}"]`);
        if (piezaItem) {
            piezaItem.style.display = 'block';
        }
    }

    function encontrarCeldaConPieza(piezaId) {
        return document.querySelector(`.celda-hexagono[data-pieza-id="${piezaId}"]`);
    }

    function actualizarResumen() {
        const resumen = document.getElementById('resumen-colocacion');
        const colocadas = Object.keys(colocaciones).length;

        if (colocadas === 0) {
            resumen.innerHTML = '<p>Ninguna pieza colocada aún.</p>';
        } else {
            let html = '<div class="grid grid-cols-2 md:grid-cols-4 gap-2">';
            Object.entries(colocaciones).forEach(([posicion, pieza]) => {
                html += `<div class="bg-white border border-gray-300 rounded p-1 text-xs">
                    <span class="font-semibold">Pieza ${pieza.id}</span> → ${posicion}
                </div>`;
            });
            html += '</div>';
            resumen.innerHTML = html;
        }
    }

    function actualizarContadores() {
        const piezasColocadas = Object.keys(colocaciones).length;
        const piezasDisponibles = piezasDisponibles.length - piezasColocadas;
        const totalCeldas = document.querySelectorAll('.celda-hexagono[data-fija="false"]').length;

        const contadorPiezas = document.getElementById('contador-piezas');
        if (contadorPiezas) {
            contadorPiezas.textContent = `(${piezasDisponibles})`;
        }

        const contadorColocadas = document.getElementById('contador-colocadas');
        if (contadorColocadas) {
            contadorColocadas.textContent = `(${piezasColocadas}/${totalCeldas} colocadas)`;
        }
    }

    function mostrarMensaje(texto, tipo) {
        let mensajeDiv = document.getElementById('mensaje-temporal');
        if (!mensajeDiv) {
            mensajeDiv = document.createElement('div');
            mensajeDiv.id = 'mensaje-temporal';
            mensajeDiv.className = 'fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm';
            document.body.appendChild(mensajeDiv);
        }

        const colores = {
            'info': 'bg-blue-100 text-blue-800 border-blue-300',
            'success': 'bg-green-100 text-green-800 border-green-300',
            'warning': 'bg-yellow-100 text-yellow-800 border-yellow-300'
        };

        mensajeDiv.className = `fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm border-2 ${colores[tipo] || colores.info}`;
        mensajeDiv.textContent = texto;

        setTimeout(() => {
            if (mensajeDiv) {
                mensajeDiv.style.opacity = '0';
                mensajeDiv.style.transition = 'opacity 0.5s';
                setTimeout(() => {
                    if (mensajeDiv && mensajeDiv.parentNode) {
                        mensajeDiv.parentNode.removeChild(mensajeDiv);
                    }
                }, 500);
            }
        }, 3000);
    }

    function obtenerRespuesta() {
        // Convertir colocaciones a formato esperado: [{fila: 0, columna: 0, pieza: 'A', color: 'red'}, ...]
        const respuesta = Object.entries(colocaciones).map(([posicion, pieza]) => {
            const [fila, columna] = posicion.split('-').map(Number);
            return {
                fila: fila,
                columna: columna,
                pieza: pieza.id,
                color: pieza.color,
                rotacion: pieza.rotacion !== undefined ? pieza.rotacion : 0
            };
        });

        return respuesta.length > 0 ? respuesta : null;
    }

    function deshabilitarInteraccion() {
        document.querySelectorAll('.pieza-item').forEach(pieza => {
            pieza.draggable = false;
            pieza.classList.add('opacity-50', 'cursor-not-allowed');
        });

        document.querySelectorAll('.celda-hexagono').forEach(celda => {
            celda.classList.add('cursor-not-allowed');
            celda.style.pointerEvents = 'none';
        });
    }

    // Cargar respuesta previa si existe
    @if(isset($progresoUsuario) && $progresoUsuario && $progresoUsuario->respuesta_usuario)
        const respuestaPrevia = @json($progresoUsuario->respuesta_usuario);
        if (respuestaPrevia && Array.isArray(respuestaPrevia)) {
            respuestaPrevia.forEach(item => {
                if (item.fila !== undefined && item.columna !== undefined && item.pieza) {
                    const celda = document.querySelector(`.celda-hexagono[data-fila="${item.fila}"][data-columna="${item.columna}"]`);
                    if (celda && celda.dataset.fija !== 'true') {
                        const piezaData = {
                            id: item.pieza,
                            color: item.color || piezasDisponibles.find(p => p.id === item.pieza)?.color || 'gray',
                            imagen: item.imagen || piezasDisponibles.find(p => p.id === item.pieza)?.imagen || '',
                            rotacion: item.rotacion !== undefined ? item.rotacion : 0
                        };
                        colocarPiezaEnCelda(celda, piezaData);
                    }
                }
            });
        }
    @endif
</script>

