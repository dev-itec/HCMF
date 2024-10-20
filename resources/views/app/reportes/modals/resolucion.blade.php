<x-btn-link
    class="bg-sky-500"
    href="javascript:void(0);"
    onclick="comment({{ json_encode($resolucion) }}, {{ json_encode($denuncia) }})"
>
    <i class="fas fa-eye"></i>
</x-btn-link>


<!-- Modal -->
<div id="comment" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
    <div class="relative bg-white rounded-lg p-6 w-11/12 max-w-3xl h-[60vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">
                Comentarios
            </h3>
            <button onclick="closeModalComment()" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div id="modalContent" class="grid grid-cols-2 gap-4 mb-6 p-6"> <!-- Estilo de 2 columnas -->
            <!-- Aquí se llenará la información con formato de formulario -->
        </div>
        <!-- Modal Footer -->
        <div class="flex justify-end items-center space-x-4">
            <!-- Botón de cerrar -->
            <button onclick="closeModalComment()" class="bg-sky-900 text-white px-4 py-2 rounded flex items-center">
                <i class="fas fa-times mr-2"></i> Cerrar
            </button>
        </div>
    </div>
</div>

<script>
    function comment(resolucion, denuncia) {
        console.log(denuncia)
        // Ejemplo de cómo acceder a una propiedad, como `resolucion.nombre`:
    document.getElementById('modalContent').innerHTML = `
        <div>
            <label for="nombre">Resolución</label>
        </div>
        <div>
            <label for="status">${resolucion.texto_resolucion}</label>
        </div>
        <div class="px-6 py-4">${denuncia.nombre_completo }</div>
        <div class="px-6 py-4">${denuncia.personas_involucradas }</div>
        <div class="px-6 py-4">${denuncia.responsable }</div>
    `;
        document.getElementById('comment').classList.remove('hidden');
    }

    function closeModalComment() {
        document.getElementById('comment').classList.add('hidden');
    }
</script>