
<script>
    var opcionSeleccionada = null;

    function seleccionarOpcion(btn) {
        if (window._bebrasResp) return;

        // Remover selección anterior
        document.querySelectorAll('.opcion-btn').forEach(b => {
            b.classList.remove('opcion-seleccionada');
        });

        // Marcar nueva selección con color muy visible
        btn.classList.add('opcion-seleccionada');
        opcionSeleccionada = btn.dataset.opcion;
    }

    function obtenerRespuesta() {
        return opcionSeleccionada ? [opcionSeleccionada] : null;
    }

    function deshabilitarInteraccion() {
        document.querySelectorAll('.opcion-btn').forEach(btn => {
            btn.classList.add('cursor-not-allowed', 'opacity-75');
            btn.onclick = null;
        });
    }
</script>