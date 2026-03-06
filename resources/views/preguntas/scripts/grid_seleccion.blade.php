<script>
    function toggleCelda(btn) {
        if (window._bebrasResp) return;

        const activa = btn.dataset.activa === '1';
        btn.dataset.activa = activa ? '0' : '1';

        if (activa) {
            btn.classList.remove('bg-red-500', 'border-red-600');
            btn.classList.add('bg-gray-100', 'border-gray-300');
            const x = btn.querySelector('.celda-x');
            if (x) x.remove();
        } else {
            btn.classList.remove('bg-gray-100', 'border-gray-300');
            btn.classList.add('bg-red-500', 'border-red-600');
            const span = document.createElement('span');
            span.className = 'text-3xl font-bold text-white celda-x';
            span.textContent = '×';
            btn.appendChild(span);
        }
    }

    function obtenerRespuesta() {
        const celdas = document.querySelectorAll('.celda');
        const respuesta = [];

        celdas.forEach(celda => {
            if (celda.dataset.activa === '1') {
                respuesta.push({
                    fila: parseInt(celda.dataset.fila),
                    columna: parseInt(celda.dataset.columna)
                });
            }
        });

        return respuesta.length > 0 ? respuesta : null;
    }

    function deshabilitarInteraccion() {
        document.querySelectorAll('.celda').forEach(btn => {
            btn.classList.add('cursor-not-allowed', 'opacity-75');
            btn.onclick = null;
        });
    }
</script>