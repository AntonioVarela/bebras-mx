
<div class="w-full max-w-md mx-auto">
    @if(isset($pregunta->configuracion['tipo_respuesta']) && $pregunta->configuracion['tipo_respuesta'] === 'numero')
        <label class="block mb-1 text-sm font-medium text-gray-700">Ingresa tu respuesta (número):</label>
        <input 
            type="number" 
            id="respuesta-numero"
            min="{{ $pregunta->configuracion['min'] ?? 0 }}"
            max="{{ $pregunta->configuracion['max'] ?? 999 }}"
            class="w-full px-4 py-3 min-h-[48px] text-xl text-center border-2 border-gray-300 dark:border-neutral-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:bg-neutral-800 dark:text-white"
            placeholder="0">
    @else
        <label class="block mb-1 text-sm font-medium text-gray-700">Ingresa tu respuesta:</label>
        <textarea 
            id="respuesta-texto"
            rows="3"
            class="w-full px-4 py-3 min-h-[80px] border-2 border-gray-300 dark:border-neutral-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:bg-neutral-800 dark:text-white text-sm"
            placeholder="Escribe tu respuesta aquí..."></textarea>
    @endif
</div>