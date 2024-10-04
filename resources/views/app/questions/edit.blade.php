<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-list-check"></i> {{ __('Formulario') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-semibold mb-6">Editar Pregunta</h1>

        <form action="{{ route('questions.update', $question->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Campo de texto de la pregunta -->
            <div class="mb-4">
                <label for="label" class="block text-sm font-semibold text-gray-700 mb-2">Texto de la Pregunta</label>
                <input type="text" name="label" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" value="{{ old('label', $question->label) }}" required>
            </div>

            <!-- Selección de tipo de pregunta -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Pregunta</label>
                <select name="type" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" required>
                    <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Texto</option>
                    <option value="date" {{ $question->type == 'date' ? 'selected' : '' }}>Fecha</option>
                    <option value="select" {{ $question->type == 'select' ? 'selected' : '' }}>Seleccionar</option>
                    <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                </select>
            </div>

            <!-- Opciones solo si el tipo es 'select' o 'checkbox' -->
            <div class="mb-4" id="opciones-container" style="{{ $question->type == 'select' || $question->type == 'checkbox' ? '' : 'display: none;' }}">
                <label for="options" class="block text-sm font-semibold text-gray-700 mb-2">Opciones (separadas por coma)</label>
                <input type="text" name="options" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" value="{{ is_array($question->options) ? implode(',', $question->options) : ( $question->options ? implode(',', json_decode($question->options)) : '' ) }}">
            </div>

            <!-- Campo para el orden -->
            <div class="mb-4">
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">Orden</label>
                <input type="number" name="order" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-sky-500 focus:border-sky-500" value="{{ old('order', $question->order) }}">
            </div>

            <!-- Checkbox para si es requerido -->
            <div class="flex items-center mb-4">
                <input type="checkbox" name="required" id="required" value="1" class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded" {{ old('required', $question->required) ? 'checked' : '' }}>
                <label for="required" class="ml-2 block text-sm font-semibold text-gray-700">¿Es requerida?</label>
            </div>

            <!-- Botón para actualizar -->
            <div>
                <button type="submit" class="bg-sky-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-sky-700 focus:ring-4 focus:ring-sky-300">Actualizar Pregunta</button>
            </div>
        </form>

    </div>

    @section('scripts')
        <script>
            document.querySelector('select[name="type"]').addEventListener('change', function() {
                var opcionesContainer = document.getElementById('opciones-container');
                if (this.value === 'select' || this.value === 'checkbox') {
                    opcionesContainer.style.display = 'block';
                } else {
                    opcionesContainer.style.display = 'none';
                }
            });
        </script>
    @endsection
</x-tenant-app-layout>
