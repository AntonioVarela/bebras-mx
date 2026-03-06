
<script>
    var opcionSeleccionada = null;

    function seleccionarOpcion(btn) {
        if (window._bebrasResp) return;

        // Remover selección anterior
        document.querySelectorAll('.opcion-btn').forEach(b => {
            b.classList.remove('border-blue-600', 'bg-blue-100', 'border-4');
            b.classList.add('border-gray-300', 'border-3');
        });

        // Marcar nueva selección
        btn.classList.remove('border-gray-300', 'border-3');
        btn.classList.add('border-blue-600', 'bg-blue-100', 'border-4');
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