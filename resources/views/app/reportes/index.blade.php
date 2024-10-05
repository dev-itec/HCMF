{{-- reportes.blade.php --}}
<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-chart-simple"></i> {{ __('Reporte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Identificador</th>
                                <th scope="col" class="px-6 py-3">Denunciante</th>
                                <th scope="col" class="px-6 py-3">Personas Involucradas</th>
                                <th scope="col" class="px-6 py-3">Responsable</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($answers as $denuncia)
                                <tr id="denuncia-{{ $denuncia->id }}" class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $denuncia->identificador }}
                                    </th>
                                    <td class="px-6 py-4">{{ $denuncia->nombre_completo }}</td>
                                    <td class="px-6 py-4">{{ $denuncia->personas_involucradas }}</td>
                                    <td class="px-6 py-4">{{ $denuncia->responsable }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColor = match($denuncia->status) {
                                                'pendiente' => 'bg-red-500 text-white',
                                                'en_proceso' => 'bg-yellow-500 text-black',
                                                'informacion solicitada' => 'bg-orange-500 text-white',
                                                'resuelta' => 'bg-green-500 text-white',
                                                default => 'bg-gray-500 text-white',
                                            };
                                        @endphp
                                        <span id="status-badge-{{ $denuncia->id }}" class="px-2 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                                            {{ ucfirst($denuncia->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $resolucion = \App\Models\Resolucion::where('denuncia_id', $denuncia->id)->first();
                                        @endphp
                                        @if ($resolucion)
                                            <button onclick="downloadExpediente('{{ $resolucion->pdf }}')" class="bg-sky-900 hover:bg-sky-900 active:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                                Ver Expediente
                                            </button>
                                        @else
                                            <x-btn-link 
                                                class="bg-sky-500" 
                                                href="javascript:void(0);" 
                                                onclick="openModal({
                                                    id: '{{ $denuncia->id }}',
                                                    nombre_completo: '{{ $denuncia->nombre_completo }}',
                                                    personas_involucradas: '{{ $denuncia->personas_involucradas }}',
                                                    created_at: '{{ $denuncia->created_at }}',
                                                    responsable: '{{ $denuncia->responsable }}',
                                                    status: '{{ $denuncia->status }}'
                                                })"
                                            >
                                                Cerrar Caso
                                            </x-btn-link>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-11/12 max-w-lg">
            <h3 class="text-xl font-semibold mb-4">Detalles de la Denuncia</h3>
            <div id="modalContent" class="text-center sm:text-left mb-14">
                <!-- Aquí se llenará la información -->
            </div>
        </div>
    </div>

    {{-- <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-11/12 max-w-lg relative">
            <!-- Botón de cierre "X" -->
            <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                &times; <!-- Símbolo de la X -->
            </button>

            <h3 class="text-xl font-semibold mb-4">Cerrar Caso {{ $denuncia->identificador }}</h3>
            <div id="modalContent" class="text-center sm:text-left mb-14">
                <!-- Aquí se llenará la información -->
            </div>
            <form id="closeCaseForm" enctype="multipart/form-data">
                <h5 class="text-1xl font-semibold">Texto de Resolución:</h5>
                <textarea id="textoResolucion" class="w-full p-2 mt-2 border border-gray-300 rounded" rows="3" required></textarea>

                <h5 class="text-1xl font-semibold mt-3">Adjuntar PDF:</h5>
                <input type="file" id="archivoPdf" class="mt-2" accept="application/pdf">

                <button onclick="confirmCloseCase('{{ $denuncia->id }}')" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Cerrar Caso</button>
            </form>
        </div>
    </div> --}}
    <!-- Modal para ver el PDF -->
    {{-- <div id="fileModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-11/12 max-w-lg">
            <h3 class="text-xl font-semibold mb-4">Ver Expediente</h3>
            <iframe id="pdfViewer" src="" width="100%" height="500px"></iframe>
        </div>
    </div> --}}


    <!-- Incluir SweetAlert2 desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>        
        function openModal(denuncia) {
            const content = `
            <h5 class="text-1xl font-semibold">Denunciante:</h5>
            <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.nombre_completo}</span>
            <h5 class="text-1xl font-semibold">Denunciado:</h5>
            <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.personas_involucradas}</span>
            <h5 class="text-1xl font-semibold">Fecha denuncia:</h5>
            <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.created_at}</span>
            <form id="closeCaseForm" enctype="multipart/form-data">
                <h5 class="text-1xl font-semibold">Texto de Resolución:</h5>
                <textarea id="textoResolucion" class="w-full p-2 mt-2 border border-gray-300 rounded" rows="3" required></textarea>

                <h5 class="text-1xl font-semibold mt-3">Adjuntar PDF:</h5>
                <input type="file" id="archivoPdf" class="mt-2" accept="application/pdf">

                <div class="flex items-center justify-items-left">
                    <button id="closeCaseButton" class="mt-4 bg-green-500 text-white px-4 py-2 rounded mr-2">Cerrar Caso</button>
                    <button onclick="closeFileModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
            `;
            document.getElementById('modalContent').innerHTML = content;
            document.querySelector('#detailModal h3').textContent = `Cerrar Caso ${denuncia.id}`;
            document.getElementById('detailModal').classList.remove('hidden');

            document.getElementById('closeCaseButton').addEventListener('click', async (event) => {
                event.preventDefault();
                await handleCaseClosure(denuncia.id);
            });

            async function handleCaseClosure(denunciaId) {
                await confirmCloseCase(denunciaId);
            }
        }

        // Función para ver el expediente
        function openFileModal(pdfPath) {
            // const pdfViewer = document.getElementById('pdfViewer');
            // pdfViewer.src = `/storage/${pdfPath}`; // Asegúrate de que el archivo PDF esté accesible desde la carpeta 'public/storage'
            // document.getElementById('fileModal').classList.remove('hidden');

            // console.log('Ese es el nombre del archivo'  + pdfPath);
            if(pdfPath){
                const url = `{{ route('file.reportes.view', ['filename' => 'FILENAME_PLACEHOLDER']) }}`.replace('FILENAME_PLACEHOLDER', pdfPath);
                window.location.href = url;
            } else {
                console.error('Problemas con el archivo adjunto')
            }
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Función para descargar el expediente
        function downloadExpediente(pdfPath) {
            console.log('PdfPath: ' + pdfPath);
            // const link = document.createElement('a');

            // // Ajustar la ruta para que apunte a 'public/storage/resoluciones'
            // // const publicPath = pdfPath.replace('storage/', 'storage/'); // Ajusta según el almacenamiento en Laravel
            // link.href = `/storage/${publicPath}`;  // Asegurarse que la ruta es accesible públicamente
            // link.download = publicPath.split('/').pop(); // Nombre del archivo
            // document.body.appendChild(link);
            // link.click();
            // document.body.removeChild(link);

            if(pdfPath){
                const url = `{{ route('file.reportes.download', ['filename' => 'FILENAME_PLACEHOLDER']) }}`.replace('FILENAME_PLACEHOLDER', pdfPath);
                window.location.href = url;
            } else {
                console.error('Problemas con el archivo adjunto')
            }
        }

        // Cerrar el modal con la tecla "Esc"
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        function closeFileModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Envia info del caso al server
        async function confirmCloseCase(denunciaId) {
            const result = await Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción cerrará el caso.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar caso!'
            });

            if (result.isConfirmed) {
                const textoResolucion = document.getElementById('textoResolucion').value;
                const archivoPdf = document.getElementById('archivoPdf').files[0];

                if (!textoResolucion) {
                    Swal.fire('Error!', 'Debe proporcionar un texto de resolución.', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('texto_resolucion', textoResolucion);
                if (archivoPdf) {
                    formData.append('pdf', archivoPdf);
                }

                const data = await sendCaseToServer(denunciaId, formData);

                if (data) {
                    Swal.fire({
                        title: 'Cerrado!',
                        text: 'El caso ha sido cerrado.',
                        icon: 'success'
                    }).then(() => {
                        closeModal();
                        console.log('this is the data: ' + JSON.stringify(data));

                        // Cambiar el botón "Cerrar Caso" a "Ver Expediente"
                        let rowElement = document.getElementById(`denuncia-${denunciaId}`);
                        let closeButton = rowElement.querySelector('td:last-child a');

                        if (closeButton) {
                            closeButton.textContent = 'Ver Expediente';
                            closeButton.onclick = () => openFileModal(data.pdfPath);
                            closeButton.onclick = () => openFileModal(data.pdfPath);
                        } else {
                            console.error('Botón no encontrado');
                        }

                        // Actualizar el badge del estado
                        const statusBadge = rowElement.querySelector(`#status-badge-${denunciaId}`);
                        if (statusBadge) {
                            statusBadge.textContent = 'Resuelta';
                            statusBadge.className = 'px-2 py-1 rounded-full text-sm font-semibold bg-green-500 text-white';
                        } else {
                            console.error('Badge no encontrado');
                        }
                    });
                } else {
                    Swal.fire('Error!', 'Hubo un problema al cerrar el caso.', 'error');
                }
            }
        }
    
        // Envia data a servidor
        async function sendCaseToServer(denunciaId, formData) {
            try {
                const response = await fetch(`/denuncias/${denunciaId}/cerrar`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    return data;
                } else {
                    return false;
                }
            } catch (error) {
                console.error('Error:', error);
                return false;
            }
        }
    

        function closeCase() {
            const resolutionText = document.getElementById('resolutionText').value;
            const resolutionFile = document.getElementById('resolutionFile').files[0];
            const denunciaId = document.querySelector('[data-denuncia-id]').getAttribute('data-denuncia-id');

            const formData = new FormData();
            formData.append('resolutionText', resolutionText);
            formData.append('resolutionFile', resolutionFile);
            formData.append('denunciaId', denunciaId);

            fetch(`/denuncias/${denunciaId}/cerrar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Cerrado!', 'El caso ha sido cerrado exitosamente.', 'success');
                        closeModal();
                    } else {
                        alert('Error al cerrar el caso.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al cerrar el caso.');
                });
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</x-tenant-app-layout>
