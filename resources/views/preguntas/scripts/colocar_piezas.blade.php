<script>
    let colocaciones = {}; // { celda: abejaId }
    const config = @json($config ?? []);
    const abejas = config.abejas || [];
    const celdasHexagonales = config.celdas_hexagonales || 19;

    // Inicializar drag and drop
    document.addEventListener('DOMContentLoaded', function() {
        inicializarDragAndDrop();
        actualizarResumen();
    });

    function inicializarDragAndDrop() {
        const abejasDisponibles = document.getElementById('abejas-disponibles');
        const celdasPanal = document.querySelectorAll('.celda-panal');
        const esTactil = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

        // Configurar elementos arrastrables (abejas) — solo en dispositivos con mouse
        if (!esTactil) {
            abejasDisponibles.querySelectorAll('.abeja-item').forEach(abeja => {
                abeja.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', this.dataset.abejaId);
                    this.classList.add('dragging');
                });

                abeja.addEventListener('dragend', function(e) {
                    this.classList.remove('dragging');
                    document.querySelectorAll('.celda-panal').forEach(celda => {
                        celda.classList.remove('drag-over');
                    });
                });
            });

            // Configurar zonas de destino (celdas del panal)
            celdasPanal.forEach(celda => {
                celda.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    if (!this.classList.contains('ocupada')) {
                        this.classList.add('drag-over');
                    }
                });

                celda.addEventListener('dragleave', function(e) {
                    this.classList.remove('drag-over');
                });

                celda.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('drag-over');
                    const abejaId = e.dataTransfer.getData('text/plain');
                    if (!abejaId) return;
                    if (this.classList.contains('ocupada')) {
                        mostrarMensaje('Esta celda ya está ocupada. Remueve la abeja primero.', 'warning');
                        return;
                    }
                    const celdaAnterior = encontrarCeldaConAbeja(abejaId);
                    if (celdaAnterior) removerAbejaDeCelda(celdaAnterior);
                    colocarAbejaEnCelda(this, abejaId);
                });

                // Doble clic para remover abeja (escritorio)
                celda.addEventListener('dblclick', function(e) {
                    if (this.classList.contains('ocupada')) {
                        removerAbejaDeCelda(this);
                    }
                });
            });
        }

        // Soporte táctil: toca una abeja para seleccionarla, toca la celda para colocarla
        // (iOS/iPadOS no soporta la API HTML5 de drag-and-drop)
        if (esTactil) {
            window._abejaSeleccionadaToque = null;

            // Mostrar instrucciones táctiles y ocultar las de arrastre
            const instrucciones = document.querySelector('.instrucciones-arrastre');
            const instruccionesToque = document.querySelector('.instrucciones-toque');
            if (instrucciones) instrucciones.style.display = 'none';
            if (instruccionesToque) instruccionesToque.style.display = 'block';

            abejasDisponibles.querySelectorAll('.abeja-item').forEach(abeja => {
                abeja.addEventListener('touchend', function(e) {
                    e.preventDefault();
                    if (this.style.display === 'none') return;
                    const id = this.dataset.abejaId;
                    if (window._abejaSeleccionadaToque === id) {
                        window._abejaSeleccionadaToque = null;
                        this.classList.remove('abeja-toque-activa');
                    } else {
                        document.querySelectorAll('.abeja-item.abeja-toque-activa').forEach(el => el.classList.remove('abeja-toque-activa'));
                        window._abejaSeleccionadaToque = id;
                        this.classList.add('abeja-toque-activa');
                        mostrarMensaje('Abeja ' + id + ' seleccionada. Toca una celda del panal para colocarla.', 'info');
                    }
                });
            });

            celdasPanal.forEach(celda => {
                celda.addEventListener('touchend', function(e) {
                    e.preventDefault();
                    if (window._abejaSeleccionadaToque) {
                        const id = window._abejaSeleccionadaToque;
                        if (this.classList.contains('ocupada')) {
                            mostrarMensaje('Esta celda ya está ocupada. Toca la celda sin abeja seleccionada para removerla.', 'warning');
                            return;
                        }
                        const anterior = encontrarCeldaConAbeja(id);
                        if (anterior) removerAbejaDeCelda(anterior);
                        colocarAbejaEnCelda(this, id);
                        document.querySelectorAll('.abeja-item.abeja-toque-activa').forEach(el => el.classList.remove('abeja-toque-activa'));
                        window._abejaSeleccionadaToque = null;
                    } else if (this.classList.contains('ocupada')) {
                        removerAbejaDeCelda(this);
                    }
                });
            });
        }
    }

    function colocarAbejaEnCelda(celda, abejaId) {
        const celdaNumero = parseInt(celda.dataset.celda);
        const abeja = abejas.find(a => a.id === abejaId);

        if (!abeja) return;

        // Marcar celda como ocupada
        celda.classList.add('ocupada');
        celda.dataset.ocupada = 'true';
        celda.dataset.abejaId = abejaId;

        // Ocultar número de celda
        const numeroCelda = celda.querySelector('span');
        if (numeroCelda) {
            numeroCelda.style.display = 'none';
        }

        // Mostrar imagen de la abeja
        const contenedorAbeja = celda.querySelector('.abeja-en-celda');
        if (contenedorAbeja) {
            const img = contenedorAbeja.querySelector('img');
            if (img) {
                img.src = `/storage/${abeja.imagen}`;
                img.alt = `Abeja ${abejaId}`;
            }
            contenedorAbeja.classList.remove('hidden');
        }

        // Guardar colocación
        colocaciones[celdaNumero] = abejaId;

        // Remover abeja de la lista de disponibles
        removerAbejaDeLista(abejaId);

        actualizarResumen();
        actualizarContadores();
        mostrarMensaje(`Abeja ${abejaId} colocada en celda ${celdaNumero}`, 'success');
    }

    function removerAbejaDeCelda(celda) {
        const celdaNumero = parseInt(celda.dataset.celda);
        const abejaId = celda.dataset.abejaId;

        if (!abejaId) return;

        // Remover marca de ocupada
        celda.classList.remove('ocupada');
        celda.dataset.ocupada = 'false';
        delete celda.dataset.abejaId;

        // Mostrar número de celda
        const numeroCelda = celda.querySelector('span');
        if (numeroCelda) {
            numeroCelda.style.display = 'block';
        }

        // Ocultar imagen de la abeja
        const contenedorAbeja = celda.querySelector('.abeja-en-celda');
        if (contenedorAbeja) {
            contenedorAbeja.classList.add('hidden');
        }

        // Remover de colocaciones
        delete colocaciones[celdaNumero];

        // Regresar abeja a la lista de disponibles
        regresarAbejaALista(abejaId);

        actualizarResumen();
        actualizarContadores();
        mostrarMensaje(`Abeja ${abejaId} removida de celda ${celdaNumero}`, 'info');
    }

    function removerAbejaDeLista(abejaId) {
        const abejaItem = document.querySelector(`[data-abeja-id="${abejaId}"]`);
        if (abejaItem) {
            abejaItem.style.display = 'none';
        }
    }

    function regresarAbejaALista(abejaId) {
        const abejaItem = document.querySelector(`[data-abeja-id="${abejaId}"]`);
        if (abejaItem) {
            abejaItem.style.display = 'block';
        }
    }

    function encontrarCeldaConAbeja(abejaId) {
        return document.querySelector(`.celda-panal[data-abeja-id="${abejaId}"]`);
    }

    function actualizarResumen() {
        const resumen = document.getElementById('resumen-colocacion');
        const colocadas = Object.keys(colocaciones).length;

        if (colocadas === 0) {
            resumen.innerHTML = '<p>Ninguna abeja colocada aún.</p>';
        } else {
            let html = '<div class="grid grid-cols-2 md:grid-cols-4 gap-2">';
            Object.entries(colocaciones).forEach(([celda, abejaId]) => {
                html += `<div class="bg-white border border-gray-300 rounded p-2 text-xs">
                    <span class="font-semibold">Abeja ${abejaId}</span> → Celda ${celda}
                </div>`;
            });
            html += '</div>';
            resumen.innerHTML = html;
        }
    }

    function actualizarContadores() {
        const abejasColocadas = Object.keys(colocaciones).length;
        const abejasDisponibles = abejas.length - abejasColocadas;

        const contadorAbejas = document.getElementById('contador-abejas');
        if (contadorAbejas) {
            contadorAbejas.textContent = `(${abejasDisponibles})`;
        }

        const contadorCeldas = document.getElementById('contador-celdas');
        if (contadorCeldas) {
            contadorCeldas.textContent = `(${abejasColocadas}/${celdasHexagonales} ocupadas)`;
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
        // Verificar que todas las abejas estén colocadas
        const abejasColocadas = Object.keys(colocaciones).length;
        if (abejasColocadas !== abejas.length) {
            alert(`Por favor coloca todas las abejas. Faltan ${abejas.length - abejasColocadas} abeja(s).`);
            return null;
        }

        // Convertir a formato esperado: [{abeja: '1', celda: 5}, ...]
        const respuesta = Object.entries(colocaciones).map(([celda, abejaId]) => ({
            abeja: abejaId,
            celda: parseInt(celda)
        }));

        return respuesta;
    }

    function deshabilitarInteraccion() {
        document.querySelectorAll('.abeja-item').forEach(abeja => {
            abeja.draggable = false;
            abeja.classList.add('opacity-50', 'cursor-not-allowed');
        });

        document.querySelectorAll('.celda-panal').forEach(celda => {
            celda.classList.add('cursor-not-allowed');
            celda.style.pointerEvents = 'none';
        });
    }

    function removerAbejaDeCeldaManual(celdaNumero) {
        const celda = document.querySelector(`.celda-panal[data-celda="${celdaNumero}"]`);
        if (celda && celda.classList.contains('ocupada')) {
            removerAbejaDeCelda(celda);
        }
    }

    // Cargar respuesta previa si existe
    @if(isset($progresoUsuario) && $progresoUsuario && $progresoUsuario->respuesta_usuario)
        const respuestaPrevia = @json($progresoUsuario->respuesta_usuario);
        if (respuestaPrevia && Array.isArray(respuestaPrevia)) {
            respuestaPrevia.forEach(item => {
                if (item.abeja && item.celda) {
                    const celda = document.querySelector(`.celda-panal[data-celda="${item.celda}"]`);
                    if (celda) {
                        colocarAbejaEnCelda(celda, item.abeja);
                    }
                }
            });
        }
    @endif
</script>

