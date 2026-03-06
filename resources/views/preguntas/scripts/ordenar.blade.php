<script>
    var ordenActual = [];

    // Funciones globales (llamadas desde show.blade.php)
    function obtenerRespuesta() {
        return ordenActual.length > 0 ? ordenActual : null;
    }

    function deshabilitarInteraccion() {
        if (typeof Sortable === 'undefined') return;
        const fuente = document.getElementById('elementos-fuente');
        const destino = document.getElementById('area-ordenamiento');
        if (fuente && Sortable.get(fuente)) {
            Sortable.get(fuente).option('disabled', true);
        }
        if (destino && Sortable.get(destino)) {
            Sortable.get(destino).option('disabled', true);
        }
        document.querySelectorAll('.elemento-draggable').forEach(el => {
            el.classList.remove('cursor-move');
            el.classList.add('cursor-not-allowed', 'opacity-75');
        });
    }

    function initOrdenar() {
        if (typeof Sortable === 'undefined') {
            setTimeout(initOrdenar, 50);
            return;
        }
        const fuente = document.getElementById('elementos-fuente');
        const destino = document.getElementById('area-ordenamiento');
        if (!fuente || !destino) return;

        function actualizarOrden() {
            ordenActual = [];
            const elementos = destino.querySelectorAll('.elemento-draggable');
            elementos.forEach(el => {
                ordenActual.push(el.dataset.id);
            });
            if (ordenActual.length === 0) {
                const placeholder = document.getElementById('placeholder-orden');
                if (placeholder) placeholder.style.display = 'block';
            }
        }

        function actualizarFuente() {
            const elementosEnFuente = fuente.querySelectorAll('.elemento-draggable');
            const contadorFuente = document.getElementById('contador-fuente');
            if (contadorFuente) contadorFuente.textContent = `(${elementosEnFuente.length})`;
            const elementosEnDestino = destino.querySelectorAll('.elemento-draggable');
            const contadorDestino = document.getElementById('contador-destino');
            if (contadorDestino) contadorDestino.textContent = `(${elementosEnDestino.length})`;
            if (elementosEnFuente.length === 0) {
                const mensaje = fuente.querySelector('.mensaje-vacio');
                if (!mensaje) {
                    const msg = document.createElement('p');
                    msg.className = 'mensaje-vacio text-gray-400 text-center py-4 italic';
                    msg.textContent = 'Todos los elementos han sido movidos';
                    fuente.appendChild(msg);
                }
            } else {
                const mensaje = fuente.querySelector('.mensaje-vacio');
                if (mensaje) mensaje.remove();
            }
        }

        Sortable.create(fuente, {
            group: { name: 'shared', pull: true, put: true },
            animation: 150,
            sort: false,
            onAdd: actualizarOrden,
            onRemove: actualizarOrden
        });

        Sortable.create(destino, {
            group: 'shared',
            animation: 150,
            onAdd: function(evt) {
                document.getElementById('placeholder-orden').style.display = 'none';
                actualizarOrden();
                actualizarFuente();
            },
            onUpdate: actualizarOrden,
            onRemove: function(evt) {
                actualizarOrden();
                actualizarFuente();
                if (destino.querySelectorAll('.elemento-draggable').length === 0) {
                    document.getElementById('placeholder-orden').style.display = 'block';
                }
            }
        });

        actualizarFuente();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initOrdenar);
    } else {
        initOrdenar();
    }
</script>