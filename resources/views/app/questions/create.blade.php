<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-list-check"></i> {{ __('Formulario Dinámico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Agregar Campos al Formulario</h3>
                        <button class="bg-sky-500 text-white px-4 py-2 rounded" id="addFieldBtn">Agregar Campo</button>
                    </div>

                    <!-- Form for submitting the dynamic fields -->
                    <form action="{{ route('questions.store') }}" method="POST" id="dynamicForm">
                        @csrf
                        <ul id="formFieldsList" class="space-y-4">
                            <!-- Campos de formulario existentes -->
                            @foreach($questions as $question)
                                <li class="bg-gray-50 p-4 rounded border" data-id="{{ $question->id }}">
                                    <div class="flex justify-between items-center">
                                        <input type="text" name="labels[]" value="{{ $question->label }}" class="field-label block w-full p-2 border-gray-300 rounded" placeholder="Etiqueta de Campo" required>
                                        <select name="types[]" class="field-type ml-2 block w-1/3 p-2 border-gray-300 rounded" required>
                                            <option value="text" {{ $question->type === 'text' ? 'selected' : '' }}>Texto</option>
                                            <option value="checkbox" {{ $question->type === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                            <option value="select" {{ $question->type === 'select' ? 'selected' : '' }}>Select</option>
                                        </select>
                                        <input type="text" name="placeholders[]" value="{{ $question->placeholder }}" class="field-placeholder ml-2 block w-full p-2 border-gray-300 rounded" placeholder="Placeholder (Opcional)">
                                        <input type="text" name="options[]" value="{{ is_array($question->options) ? implode(',', $question->options) : '' }}" class="field-options ml-2 block w-full p-2 border-gray-300 rounded" placeholder="Opciones (separadas por coma)" {{ $question->type === 'text' ? 'style=display:none;' : '' }}>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-500 hover:bg-sky-600">
                            Guardar Formulario
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Template for adding new fields -->
    <template id="fieldTemplate">
        <li class="bg-gray-50 p-4 rounded border">
            <div class="flex justify-between items-center">
                <!-- Input for label -->
                <input type="text" name="labels[]" class="field-label block w-full p-2 border-gray-300 rounded" placeholder="Etiqueta de Campo" required>

                <!-- Input for type -->
                <select name="types[]" class="field-type ml-2 block w-1/3 p-2 border-gray-300 rounded" required>
                    <option value="text">Texto</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="select">Select</option>
                </select>

                <!-- Input for placeholder -->
                <input type="text" name="placeholders[]" class="field-placeholder ml-2 block w-full p-2 border-gray-300 rounded" placeholder="Placeholder (Opcional)">

                <!-- Input for options (only for select/checkbox) -->
                <input type="text" name="options[]" class="field-options ml-2 block w-full p-2 border-gray-300 rounded" placeholder="Opciones (separadas por coma)" style="display: none;">

                <!-- Remove field button -->
                <button type="button" class="ml-2 text-red-500 remove-field"><i class="fa-solid fa-trash"></i></button>
            </div>
        </li>
    </template>

    <!-- Import Sortable.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formFieldsList = document.getElementById('formFieldsList');
            const fieldTemplate = document.getElementById('fieldTemplate').content;
            const addFieldBtn = document.getElementById('addFieldBtn');
            const deletedQuestionsInput = document.getElementById('deletedQuestions');
            let deletedQuestions = [];

            // Add new field on button click
            addFieldBtn.addEventListener('click', function () {
                const newField = fieldTemplate.cloneNode(true);
                formFieldsList.appendChild(newField);
            });

            // Enable drag-and-drop sorting using Sortable.js
            Sortable.create(formFieldsList, {
                animation: 150
            });

            // Show/hide options input based on field type
            formFieldsList.addEventListener('change', function (e) {
                if (e.target.classList.contains('field-type')) {
                    const optionsInput = e.target.closest('li').querySelector('.field-options');
                    if (e.target.value === 'select' || e.target.value === 'checkbox') {
                        optionsInput.style.display = 'block';
                    } else {
                        optionsInput.style.display = 'none';
                    }
                }
            });

            // Remove field functionality
            formFieldsList.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-field')) {
                    const questionId = e.target.getAttribute('data-id');

                    // If question has an ID (i.e., it exists in the database), mark it for deletion
                    if (questionId) {
                        deletedQuestions.push(questionId);
                        deletedQuestionsInput.value = deletedQuestions.join(',');
                    }

                    // Remove field from UI
                    e.target.closest('li').remove();
                }
            });
        });
    </script>
</x-tenant-app-layout>
