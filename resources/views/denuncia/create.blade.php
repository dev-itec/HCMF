<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Denuncia</title>
    <link rel="shortcut icon" href="https://home.hcmfront.com/hubfs/favicon@3x.png">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            display: none; /* Ocultamos inicialmente */
        }
        .hidden {
            display: none;
        }
    </style>
    {!! NoCaptcha::renderJs() !!}
</head>
<body class="bg-white text-gray-900 antialiased">
@php
    // Configura la URL de la API y los encabezados
    $apiKey = tenant()->api_key;
    $url = "https://api.hcmfront.com/v1/company/";
    $headers = [
        "Authorization: Token $apiKey",
        "Content-Type: application/json"
    ];

    // Realiza la solicitud a la API
    $response = file_get_contents($url, false, stream_context_create([
        'http' => [
            'header'  => implode("\r\n", $headers),
            'method'  => 'GET',
        ]
    ]));

    // Decodifica la respuesta JSON
    $data = json_decode($response, true);

    // Obtén la URL de la imagen
    $imagenUrl = $data[0]['imagen'] ?? '';
@endphp
<nav class="sticky top-0 z-50 bg-white shadow-md p-6 flex justify-between items-center">
    @if (!empty($imagenUrl))
        <div>
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><img src="{{ $imagenUrl }}" alt="Logo" class="h-12"></a>
        </div>
    @else
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><img src="https://home.hcmfront.com/hs-fs/hubfs/logo_hcm.png?width=320&height=80&name=logo_hcm.png" alt="Imagen de la empresa" class="max-w-full h-auto mx-auto block"></a>
        </div>
    @endif
    <div>
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-blue-600 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-semibold"><i class="fa-solid fa-right-to-bracket"></i>Log in</a>
                @endauth
            </div>
        @endif
    </div>
</nav>

<div class="container mx-auto p-6 mt-8">
    <h1 class="text-3xl font-bold text-center mb-8">Formulario de Denuncia</h1>

    <form id="denunciaForm" action="{{ route('denuncia.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @php
            $randomHex = bin2hex(random_bytes(3)); // Genera un código hexadecimal de 6 dígitos para la clave
            $randomCode = strtoupper(bin2hex(random_bytes(8))); // Genera un código hexadecimal de 12 dígitos para el identificador
            $formattedHex = implode('-', str_split($randomCode, 4)); // Divide en grupos de 4
        @endphp

            <!-- Campos ocultos para identificador y clave -->
        <input type="hidden" name="identificador" value="{{ $formattedHex }}">
        <input type="hidden" name="clave" value="{{ $randomHex }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Nombre completo -->
            <div>
                <label class="block text-gray-700 font-semibold">Nombre completo</label>
                <input type="text" maxlength="100" name="nombre_completo" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <!-- RUT -->
            <div>
                <label class="block text-gray-700 font-semibold">R.U.T</label>
                <input type="text" maxlength="15" name="rut" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <!-- Genero -->
            <div>
                <label class="block text-gray-700 font-semibold">¿Cuál es su genero?</label>
                <select name="genero" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Cargo -->
            <div>
                <label class="block text-gray-700 font-semibold">Cargo</label>
                <input type="text" name="cargo" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Correo electrónico -->
            <div>
                <label class="block text-gray-700 font-semibold">Correo electrónico</label>
                <input type="email" maxlength="50" name="correo_electronico" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <!-- Relación con la empresa -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Cuál es su relación con {{ $data[0]['name'] }}?</label>
            <select name="relacion" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                <option value="Trabajador">Trabajador(a)</option>
                <option value="Contratista">Trabajador(a) de empresa contratista</option>
                <option value="Proveedor">Proveedor</option>
                <option value="Cliente">Cliente</option>
                <option value="Accionista">Accionista</option>
                <option value="Comunidad">Comunidad</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <!-- Tipo de Denuncia -->
        <div>
            <label class="block text-gray-700 font-semibold">Tipo de Denuncia (Marque todas las que apliquen)</label>
            <div class="mt-2 space-y-2">
                <label class="block">
                    <input type="checkbox" name="tipo_denuncia[]" value="Acoso laboral" class="form-checkbox">
                    <span class="ml-2">Acoso laboral</span>
                </label>
                <label class="block">
                    <input type="checkbox" name="tipo_denuncia[]" value="Acoso sexual" class="form-checkbox">
                    <span class="ml-2">Acoso sexual </span>
                </label>
                <label class="block">
                    <input type="checkbox" name="tipo_denuncia[]" value="Violencia en el trabajo" class="form-checkbox">
                    <span class="ml-2">Violencia en el trabajo</span>
                </label>
            </div>
        </div>

        {{--<!-- Detalles del incidente -->
        <div>
            <label class="block text-gray-700 font-semibold">Detalles del incidente</label>
            <textarea name="detalles_incidente" id="detalles_incidente" maxlength="500" oninput="updateCharacterCount()" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
            <small id="charCount">0/500</small>
        </div>--}}

        <!-- Fecha exacta -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Fecha exacta -->
            <div>
                <label class="block text-gray-700 font-semibold">Fecha exacta</label>
                <input type="date" name="fecha_exacta" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Fecha aproximada -->
            <div>
                <label class="block text-gray-700 font-semibold">Fecha aproximada</label>
                <input type="date" name="fecha_aproximada" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Hora del incidente -->
            <div>
                <label class="block text-gray-700 font-semibold">Hora del incidente (si aplica)</label>
                <input type="time" name="hora_incidente" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <!-- Lugar del incidente -->
        <div>
            <label class="block text-gray-700 font-semibold">Lugar del incidente</label>
            <textarea name="lugar_incidente" maxlength="150" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <!-- Descripción del caso -->
        <div>
            <label class="block text-gray-700 font-semibold">Relate de la forma más detallada posible cómo, dónde, cúando sucedieron los hechos</label>
            <textarea name="descripcion_caso" id="descripcion_caso" maxlength="3000" oninput="updateCharacterCountDetalle()" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
            <small id="charCountDetalle">0/3000</small>
        </div>

        <!-- Personas involucradas -->
        <div class="relative">
            <label class="block text-gray-700 font-semibold">Mencione a la(s) persona(s) involucrada(s)</label>
            <input id="persona-involucrada" type="text" name="personas_involucradas" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" autocomplete="off">
            <div id="autocomplete-list" class="autocomplete-items"></div>
        </div>
        <!-- Testigos -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Hay testigos? Indique</label>
            <textarea name="testigos" maxlength="250" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <!-- ¿Cómo se dio cuenta de la situación? -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Cómo se dió cuenta de esta situación?</label>
            <select id="como_se_entero" name="como_se_entero" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" onchange="checkOtroOption()">
                <option value="Lo viví">Lo viví</option>
                <option value="Lo ví/escuche">Lo ví/escuché</option>
                <option value="Me contó un trabajador de la empresa">Me contó un trabajador de la empresa</option>
                <option value="Me contó un externo">Me contó un externo</option>
                <option value="Otro">Otro</option>
            </select>
            <input type="text" id="como_se_entero_otro" maxlength="100" name="como_se_entero_otro" placeholder="Especifique si eligió 'Otro'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 hidden">
        </div>

        <!-- Impacto en la empresa -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Qué impacto tiene en la empresa y en usted esta denuncia?</label>
            <div class="mt-2 space-y-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_empresa[]" value="Financiero" class="form-checkbox">
                    <span class="ml-2">Financiero</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_empresa[]" value="Reputacional" class="form-checkbox">
                    <span class="ml-2">Reputacional</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_empresa[]" value="Seguridad" class="form-checkbox">
                    <span class="ml-2">Seguridad</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_empresa[]" value="Otro" class="form-checkbox" id="impacto_empresa_otro_checkbox">
                    <span class="ml-2">Otro</span>
                </label>
            </div>
            <input type="text" maxlength="100" name="impacto_empresa_otro" id="impacto_empresa_otro" placeholder="Especifique si eligió 'Otro'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 hidden">
        </div>

        <!-- Impacto personal -->
        <div>
            <label class="block text-gray-700 font-semibold">Impacto Personal</label>
            <div class="mt-2 space-y-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_personal[]" value="Emocional" class="form-checkbox">
                    <span class="ml-2">Emocional</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_personal[]" value="Fisico" class="form-checkbox">
                    <span class="ml-2">Físico</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_personal[]" value="Profesional" class="form-checkbox">
                    <span class="ml-2">Profesional</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="impacto_personal[]" value="Otro" class="form-checkbox" id="impacto_personal_otro_checkbox">
                    <span class="ml-2">Otro</span>
                </label>
            </div>
            <input type="text" maxlength="100" name="impacto_personal_otro" id="impacto_personal_otro" placeholder="Especifique si eligió 'Otro'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 hidden">
        </div>

        <!-- Acción esperada -->
        <div>
            <label class="block text-gray-700 font-semibold">¿Qué acción espera que tome la empresa?</label>
            <div class="mt-2 space-y-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="accion_esperada[]" value="Investigación Interna" class="form-checkbox">
                    <span class="ml-2">Investigación Interna</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="accion_esperada[]" value="Mediación" class="form-checkbox">
                    <span class="ml-2">Mediación</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="accion_esperada[]" value="Otra" class="form-checkbox" id="accion_esperada_otro_checkbox">
                    <span class="ml-2">Otra</span>
                </label>
            </div>
            <input type="text" maxlength="100" name="accion_esperada_otra" id="accion_esperada_otra" placeholder="Especifique si eligió 'Otra'" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 hidden">
        </div>

        <!-- Adjuntar evidencia -->
        <div>
            <label class="block text-gray-700 font-semibold">Adjuntar evidencia (Solo PDF, JPG, JPEG, PNG, MP3, MP4, ZIP de hasta 10 MB)</label>
            <input type="file" name="evidencia[]" id="evidencia" multiple class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" accept=".pdf,.jpg,.jpeg,.png,.mp3,.mp4,.zip" onchange="validateFiles()">
            <span id="fileError" class="error-message hidden">El archivo debe ser un PDF, JPG, JPEG, PNG, MP3, MP4 o ZIP y no debe exceder 10 MB.</span>
        </div>
        {{--<div>
            <label class="block text-gray-700 font-semibold">Adjuntar evidencia (Solo PDF, JPG, JPEG, PNG, MP3, MP4, ZIP de hasta 10 MB)</label>
            <input type="file" name="evidencia[]" id="filepond" multiple />
            <span id="fileError" class="error-message hidden">El archivo debe ser un PDF, JPG, JPEG, PNG, MP3, MP4 o ZIP y no debe exceder 10 MB.</span>
        </div>--}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Botón de envío -->
        <div class="text-center">
            <div class="flex justify-center mt-1 mb-1">{!! NoCaptcha::display() !!}</div>
            <button id="submitForm" type="submit" class="bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl text-white font-semibold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800">
                Enviar Denuncia
            </button>
        </div>
        <div class="bottom-5 mt-8w-full text-center text-gray-400">
            Powered by <a class="text-blue-500" target="_blank" href="https://hcmfront.com/">HCMFront</a>
        </div>
    </form>
    @if ($errors->has('g-recaptcha-response'))
        <span class="help-block text-danger" role="alert">
        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
    </span>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputElement = document.querySelector('#filepond');
        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['application/pdf', 'image/jpeg', 'image/png', 'audio/mp3', 'video/mp4', 'application/zip'],
            maxFileSize: '10MB',
            maxTotalFileSize: '100MB',
            allowMultiple: true,
            name: 'evidencia[]', // Este nombre debe coincidir con el nombre del campo en el formulario
            server: {
                process: {
                    url: '/upload-evidencia',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    ondata: (formData) => {
                        formData.append('_token', '{{ csrf_token() }}');
                        return formData;
                    }
                },
                revert: {
                    url: '/delete-evidencia',
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            }
        });
    });

    document.getElementById('evidencia').addEventListener('change', function() {
        let totalSize = 0;
        let files = this.files;

        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }

        if (totalSize > 100 * 1024 * 1024) { // 100 MB en bytes
            Swal.fire('Error', 'El total de los archivos no debe superar los 100 MB.', 'error');
            this.value = ''; // Reiniciar el input si hay un error
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('persona-involucrada');
        const autocompleteList = document.getElementById('autocomplete-list');
        const apiUrl = '/api/employees';
        const apiKey = '{{ tenant()->api_key }}';
        let debounceTimeout;

        function fetchSuggestions(query) {
            fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Authorization': `Token ${apiKey}`,
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const results = data.results || [];
                    autocompleteList.innerHTML = '';

                    results.forEach(person => {
                        const fullName = `${person.name} ${person.last_name}`;
                        const position = person.position_data ? person.position_data.name : '';

                        // Only show the result if position_data is not null and position is not empty
                        if (position && fullName.toLowerCase().includes(query.toLowerCase())) {
                            const item = document.createElement('div');
                            item.classList.add('autocomplete-item');
                            item.innerHTML = `<strong>${fullName}</strong><br><span class="text-gray-600">${position}</span>`;
                            item.addEventListener('click', () => {
                                const currentValue = input.value;
                                const newValue = currentValue
                                    ? `${currentValue}, ${fullName}`
                                    : fullName;
                                input.value = newValue; // Set the new value including the selected item
                                autocompleteList.innerHTML = ''; // Clear the list after selection
                            });
                            autocompleteList.appendChild(item);
                        }
                    });

                    if (autocompleteList.children.length === 0) {
                        const noResultItem = document.createElement('div');
                        noResultItem.classList.add('autocomplete-item');
                        noResultItem.textContent = 'No se encontraron coincidencias';
                        autocompleteList.appendChild(noResultItem);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    autocompleteList.innerHTML = '<div class="autocomplete-item">Error al cargar datos</div>';
                });
        }

        input.addEventListener('input', function() {
            const query = input.value;

            if (query.length < 2) {
                autocompleteList.innerHTML = '';
                return;
            }

            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => fetchSuggestions(query), 300);
        });

        document.addEventListener('click', function(e) {
            if (!autocompleteList.contains(e.target) && e.target !== input) {
                autocompleteList.innerHTML = '';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function toggleVisibility(checkboxId, inputId) {
            const checkbox = document.getElementById(checkboxId);
            const input = document.getElementById(inputId);

            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    input.classList.remove('hidden');
                } else {
                    input.classList.add('hidden');
                }
            });
        }

        toggleVisibility('impacto_empresa_otro_checkbox', 'impacto_empresa_otro');
        toggleVisibility('impacto_personal_otro_checkbox', 'impacto_personal_otro');
        toggleVisibility('accion_esperada_otro_checkbox', 'accion_esperada_otra');
    });
    function updateCharacterCount() {
        const textarea = document.getElementById('detalles_incidente');
        const charCount = document.getElementById('charCount');
        charCount.textContent = `${textarea.value.length}/500`;
    }
    function updateCharacterCountDetalle() {
        const textarea = document.getElementById('descripcion_caso');
        const charCount = document.getElementById('charCountDetalle');
        charCount.textContent = `${textarea.value.length}/3000`;
    }
    function checkOtroOption() {
        const select = document.getElementById('como_se_entero');
        const otroInput = document.getElementById('como_se_entero_otro');
        if (select.value === 'Otro') {
            otroInput.classList.remove('hidden');
        } else {
            otroInput.classList.add('hidden');
        }
    }
    function validateFiles() {
        const input = document.getElementById('evidencia');
        const fileError = document.getElementById('fileError');
        fileError.classList.add('hidden');

        const files = input.files;
        const validExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'mp3', 'mp4', 'zip'];
        let totalSize = 0; // Para calcular el tamaño total
        let valid = true;

        for (let file of files) {
            const fileSizeMB = file.size / 1024 / 1024; // Tamaño en MB
            const fileExtension = file.name.split('.').pop().toLowerCase();

            console.log('File:', file.name, 'Size:', fileSizeMB, 'Extension:', fileExtension); // Log para ver el archivo

            if (!validExtensions.includes(fileExtension)) {
                valid = false;
                console.log('Invalid extension:', fileExtension); // Log si hay extensión inválida
                break;
            }
            if (fileSizeMB > 10) {
                valid = false;
                console.log('File size exceeds 10MB:', fileSizeMB); // Log si el tamaño es mayor a 10MB
                break;
            }
            totalSize += fileSizeMB;
        }

        if (totalSize > 100) {
            valid = false;
            console.log('Total size exceeds 100MB:', totalSize); // Log si el tamaño total excede 100MB
            Swal.fire('Error', 'El total de los archivos no debe superar los 100 MB.', 'error');
        }

        if (!valid) {
            fileError.classList.remove('hidden');
            input.value = ''; // Reiniciar input si hay error
        }
        if (errors.length > 0) {
            Swal.fire({
                title: 'Error',
                text: errors.join('\n'), // Mostrar los errores en una lista
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        } else {
            // Si no hay errores, continuar
        }

        return valid; // Retorna true si es válido, false si hay un error
    }
    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.getElementById('submitForm');

        submitButton.addEventListener('click', function() {
            // Aquí recoges los valores de los inputs del formulario
            const detallesIncidente = document.getElementById('detalles_incidente').value;
            const descripcionCaso = document.getElementById('descripcion_caso').value;
            const evidencia = document.getElementById('evidencia').files;

            // Crear un mensaje con las respuestas
            let respuestaMensaje = `Detalles del Incidente: ${detallesIncidente}\nDescripción del Caso: ${descripcionCaso}\nArchivos:\n`;

            for (let i = 0; i < evidencia.length; i++) {
                respuestaMensaje += `- ${evidencia[i].name}\n`;
            }

            // Mostrar SweetAlert de confirmación
            Swal.fire({
                title: '¿Está seguro de enviar el formulario?',
                text: respuestaMensaje,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, puedes proceder a enviar el formulario
                    // Por ejemplo, usando el método de formulario de envío:
                    document.getElementById('denunciaForm').submit(); // Asegúrate de tener el ID correcto
                }
            });
        });
    });


</script>
</body>
</html>
