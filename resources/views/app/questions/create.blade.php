<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-list-check"></i> {{ __('Formulario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('questions.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="mb-4">
                            <label for="label" class="block text-sm font-medium text-gray-700">Etiqueta de la Pregunta</label>
                            <input type="text" name="label" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Pregunta (slug)</label>
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Pregunta</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                                <option value="text">Texto</option>
                                <option value="date">Fecha</option>
                                <option value="select">Seleccionar</option>
                                <option value="checkbox">Checkbox</option>
                            </select>
                        </div>

                        <!-- Campo de texto dinámico -->
                        <div class="mb-4" id="text-input-container" style="display: none;">
                            <label for="text-response" class="block text-sm font-medium text-gray-700">Respuesta Texto</label>
                            <input type="text" id="text-response" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                        </div>

                        <!-- Datepicker dinámico -->
                        <div class="mb-4" id="date-input-container" style="display: none;">
                            <label for="date-response" class="block text-sm font-medium text-gray-700">Fecha</label>
                            <input type="date" id="date-response" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                        </div>

                        <!-- Opciones dinámicas -->
                        <div class="mb-4" id="options-container" style="display: none;">
                            <label for="options" class="block text-sm font-medium text-gray-700">Opciones (separadas por coma)</label>
                            <input type="text" id="options" name="options" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Orden</label>
                            <input type="number" name="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="required" value="1" class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                            <label for="required" class="ml-2 block text-sm text-gray-700">¿Es requerida?</label>
                        </div>

                        <div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                Crear Pregunta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Preguntas</h3>
        <ul id="question-list" class="space-y-2">
            {{ debugbar()->info($questions) }}
            @foreach ($questions as $question)
                <li class="flex items-center justify-between p-4 bg-white shadow rounded border border-gray-200">
                    <span class="text-gray-900">{{ $question->label }}</span>
                    <div class="space-x-2">
                        <a href="{{ route('questions.edit', $question->id) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                            <span class="sr-only">Editar</span>
                        </a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> <!-- Icono de fontawesome -->
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>


</x-tenant-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mostrar u ocultar el campo de opciones dependiendo del tipo de pregunta seleccionada
        document.querySelector('select[name="type"]').addEventListener('change', function () {
            var opcionesContainer = document.getElementById('opciones-container');
            if (this.value === 'select' || this.value === 'checkbox') {
                opcionesContainer.style.display = 'block';
            } else {
                opcionesContainer.style.display = 'none';
            }
        });

        // Habilitar drag and drop con Sortable.js
        var el = document.getElementById('question-list');
        if (el) {
            var sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function (evt) {
                    let order = [];
                    document.querySelectorAll('#question-list li').forEach((element, index) => {
                        order.push({ id: element.getAttribute('data-id'), position: index });
                    });

                    // Actualizar el orden en el backend
                    fetch('{{ route('questions.updateOrder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ questions: order })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            alert('Orden actualizado');
                        } else {
                            alert('Error al actualizar el orden');
                        }
                    });
                }
            });
        }
    });
</script>
<script>
    document.getElementById('type').addEventListener('change', function() {
        var type = this.value;
        var textInput = document.getElementById('text-input-container');
        var dateInput = document.getElementById('date-input-container');
        var optionsContainer = document.getElementById('options-container');

        // Ocultar todos los campos
        textInput.style.display = 'none';
        dateInput.style.display = 'none';
        optionsContainer.style.display = 'none';

        // Mostrar los campos según el tipo seleccionado
        if (type === 'text') {
            textInput.style.display = 'block';
        } else if (type === 'date') {
            dateInput.style.display = 'block';
        } else if (type === 'select' || type === 'checkbox') {
            optionsContainer.style.display = 'block';
        }
    });
</script>
