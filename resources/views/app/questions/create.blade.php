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

                    <form action="{{ route('questions.store') }}" method="POST" id="dynamicForm">
    @csrf
    <ul id="formFieldsList" class="space-y-4">
        @foreach($formFields as $formField)
            <li class="bg-gray-50 p-4 rounded border" data-id="{{ $formField->id }}">
                <div class="flex justify-between items-center">
                    <input type="hidden" name="ids[]" value="{{ $formField->id }}"> <!-- Campo oculto para el ID -->
                    <input type="text" name="labels[]" value="{{ $formField->label }}" class="field-label block w-full p-2 border-gray-300 rounded" placeholder="Etiqueta de Campo" required>
                    
                    <select name="types[]" class="field-type ml-2 block w-1/3 p-2 border-gray-300 rounded" required>
                        <option value="text" {{ $formField->type === 'text' ? 'selected' : '' }}>Texto</option>
                        <option value="checkbox" {{ $formField->type === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                        <option value="dropdown" {{ $formField->type === 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                        <option value="date" {{ $formField->type === 'date' ? 'selected' : '' }}>Date</option>
                    </select>

                    <select name="categories[]" class="field-category ml-2 block w-1/3 p-2 border-gray-300 rounded" required>
                        <option value="Datos denunciante" {{ $formField->category === 'Datos denunciante' ? 'selected' : '' }}>Datos denunciante</option>
                        <option value="Tipo denuncia" {{ $formField->category === 'Tipo denuncia' ? 'selected' : '' }}>Tipo denuncia</option>
                        <option value="Impacto" {{ $formField->category === 'Impacto' ? 'selected' : '' }}>Impacto</option>
                    </select>

                    <input type="checkbox" name="active[]" value="1" class="field-active ml-2" {{ $formField->active ? 'checked' : '' }}>
                    <label class="ml-1">Activo</label>

                    <input type="text" name="additional_infos[]" value="{{ $formField->additional_info }}" class="field-additional-info ml-2 block w-full p-2 border-gray-300 rounded" placeholder="Información Adicional (Opcional)">
                    
                    <button type="button" class="ml-2 text-red-500 remove-field" data-id="{{ $formField->id }}">
                        borrar
                    </button>
                </div>
            </li>
        @endforeach
    </ul>

    <input type="hidden" id="deletedQuestions" name="deletedQuestions" value="">

    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-sky-500 hover:bg-sky-600">
        Guardar Formulario
    </button>
</form>

                </div>
            </div>
        </div>
    </div>

    <template id="fieldTemplate">
        <li class="bg-gray-50 p-4 rounded border">
            <div class="flex justify-between items-center">
                <input type="text" name="labels[]" class="field-label block w-full p-2 border-gray-300 rounded" placeholder="Etiqueta de Campo" required>
                
                <select name="types[]" class="field-type ml-2 block w-1/3 p-2 border-gray-300 rounded" required>
                    <option value="text">Text</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="date">Date</option>
                </select>

                <select name="categories[]" class="field-category ml-2 block w-1/3 p-2 border-gray-300 rounded" required>
                    <option value="Datos denunciante">Datos denunciante</option>
                    <option value="Tipo denuncia">Tipo denuncia</option>
                    <option value="Impacto">Impacto</option>
                </select>

                <input type="checkbox" name="active[]" value="1" class="field-active ml-2">
                <label class="ml-1">Activo</label>

                <input type="text" name="additional_infos[]" class="field-additional-info ml-2 block w-full p-2 border-gray-300 rounded" placeholder="Información Adicional (Opcional)">
                
                <button type="button" class="ml-2 text-red-500 remove-field" data-id="">
                    borrar
                </button>
            </div>
        </li>
    </template>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formFieldsList = document.getElementById('formFieldsList');
            const fieldTemplate = document.getElementById('fieldTemplate').content;
            const addFieldBtn = document.getElementById('addFieldBtn');
            const deletedQuestionsInput = document.getElementById('deletedQuestions');
            let deletedQuestions = [];

            // Agregar nuevo campo al hacer clic en el botón
            addFieldBtn.addEventListener('click', function () {
                const newField = fieldTemplate.cloneNode(true);
                formFieldsList.appendChild(newField);
            });

            // Funcionalidad para eliminar campos
            formFieldsList.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-field')) {
                    const listItem = e.target.closest('li');
                    const questionId = e.target.dataset.id;

                    if (questionId) {
                        deletedQuestions.push(questionId);
                        deletedQuestionsInput.value = deletedQuestions.join(',');
                    }

                    listItem.remove();
                }
            });

            // Sortable para arrastrar y soltar
            Sortable.create(formFieldsList, {
                animation: 150,
                handle: '.field-label',
                onEnd: function (evt) {
                    // Aquí puedes manejar el cambio de orden si es necesario
                }
            });
        });
    </script>
</x-tenant-app-layout>
