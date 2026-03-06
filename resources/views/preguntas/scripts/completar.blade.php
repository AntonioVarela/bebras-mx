<script>
    var completarOrdenActual = [];

    function obtenerRespuesta() {
        // P48: dias - objeto {domingo1: ['A'], domingo2: ['B','C'], ...}
        const todosDias = document.querySelectorAll('.completar-dia');
        if (todosDias.length > 0) {
            const diasUnicos = [...new Set([...todosDias].map(c => c.dataset.dia))];
            const obj = {};
            diasUnicos.forEach(d => { obj[d] = []; });
            document.querySelectorAll('.completar-dia:checked').forEach(cb => {
                obj[cb.dataset.dia].push(cb.value);
            });
            const completo = diasUnicos.every(d => obj[d].length > 0);
            return completo ? obj : null;
        }

        // P36: zancos - objeto {castor_id: zanco_num}
        const zancos = document.querySelectorAll('.completar-zanco');
        if (zancos.length > 0) {
            const obj = {};
            let completo = true;
            zancos.forEach(sel => {
                if (sel.value) obj[sel.dataset.castor] = parseInt(sel.value, 10);
                else completo = false;
            });
            return completo ? obj : null;
        }

        // P28: slots - objeto {martes: 'manzana', miercoles: 'pera'}
        const slots = document.querySelectorAll('.completar-slot');
        if (slots.length > 0) {
            const obj = {};
            let completo = true;
            slots.forEach(sel => {
                if (sel.value) obj[sel.dataset.slot] = sel.value;
                else completo = false;
            });
            return completo ? obj : null;
        }

        // P49: blanks - array ['padre','madre','madre']
        const blanks = document.querySelectorAll('.completar-blank');
        if (blanks.length > 0) {
            const arr = [];
            let completo = true;
            blanks.forEach(sel => {
                if (sel.value) arr[parseInt(sel.dataset.index, 10)] = sel.value;
                else completo = false;
            });
            return completo ? arr : null;
        }

        // P55: string
        const strInput = document.getElementById('completar-string');
        if (strInput && strInput.value.trim()) {
            return [strInput.value.trim()];
        }

        // P29: ordenar - array ordenado
        const destino = document.getElementById('completar-destino');
        if (destino) {
            const els = destino.querySelectorAll('.completar-draggable');
            const arr = [...els].map(el => el.dataset.id);
            return arr.length > 0 ? arr : null;
        }

        // P50, P57: checkboxes - array
        const checkboxes = document.querySelectorAll('.completar-checkbox:checked');
        if (checkboxes.length > 0) {
            return [...checkboxes].map(cb => cb.value);
        }

        return null;
    }

    function deshabilitarInteraccion() {
        document.querySelectorAll('.completar-dia, .completar-zanco, .completar-slot, .completar-blank, .completar-checkbox').forEach(el => {
            el.disabled = true;
            (el.closest('label') || el.closest('div') || el).classList.add('opacity-60', 'cursor-not-allowed');
        });
        const strInput = document.getElementById('completar-string');
        if (strInput) { strInput.disabled = true; strInput.classList.add('opacity-60'); }
        document.querySelectorAll('.completar-char-btn').forEach(btn => { btn.disabled = true; btn.classList.add('opacity-60'); });
        if (typeof Sortable !== 'undefined') {
            const fuente = document.getElementById('completar-fuente');
            const destino = document.getElementById('completar-destino');
            if (fuente && Sortable.get(fuente)) Sortable.get(fuente).option('disabled', true);
            if (destino && Sortable.get(destino)) Sortable.get(destino).option('disabled', true);
        }
        document.querySelectorAll('.completar-draggable').forEach(el => el.classList.add('cursor-not-allowed', 'opacity-75'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const strInput = document.getElementById('completar-string');
        if (strInput) {
            document.querySelectorAll('.completar-char-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    strInput.value += btn.dataset.char;
                    strInput.focus();
                });
            });
        }

        const destino = document.getElementById('completar-destino');
        if (destino && typeof Sortable !== 'undefined') {
            function initCompletarSortable() {
                if (typeof Sortable === 'undefined') { setTimeout(initCompletarSortable, 50); return; }
                const fuente = document.getElementById('completar-fuente');
                if (!fuente || !destino) return;
                Sortable.create(fuente, { group: { name: 'completar', pull: true, put: true }, animation: 150, sort: false });
                Sortable.create(destino, {
                    group: 'completar',
                    animation: 150,
                    onAdd: () => { document.getElementById('completar-placeholder')?.style.setProperty('display', 'none'); },
                    onRemove: function() {
                        if (destino.querySelectorAll('.completar-draggable').length === 0)
                            document.getElementById('completar-placeholder')?.style.setProperty('display', 'block');
                    }
                });
            }
            initCompletarSortable();
        }
    });
</script>
