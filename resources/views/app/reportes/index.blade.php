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
                                            <x-btn-link class="bg-sky-500" href="javascript:void(0);" onclick="openModal({
                                            id: '{{ $denuncia->id }}',
                                            nombre_completo: '{{ $denuncia->nombre_completo }}',
                                            personas_involucradas: '{{ $denuncia->personas_involucradas }}',
                                            created_at: '{{ $denuncia->created_at }}',
                                            responsable: '{{ $denuncia->responsable }}',
                                            status: '{{ $denuncia->status }}'
                                        })">Cerrar Caso</x-btn-link>
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
    {{-- <div id="detailModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
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
    </div>
    <!-- Modal para ver el PDF -->
    <div id="fileModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-11/12 max-w-lg">
            <h3 class="text-xl font-semibold mb-4">Ver Expediente</h3>
            <iframe id="pdfViewer" src="" width="100%" height="500px"></iframe>
            <button onclick="closeFileModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cerrar</button>
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
            `;
            document.getElementById('modalContent').innerHTML = content;
            document.querySelector('#detailModal h3').textContent = `Cerrar Caso ${denuncia.id}`;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function openFileModal(pdfPath) {
            const pdfViewer = document.getElementById('pdfViewer');
            pdfViewer.src = `/storage/${pdfPath}`; // Asegúrate de que el archivo PDF esté accesible desde la carpeta 'public/storage'
            document.getElementById('fileModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
        // Función para descargar el expediente
        function downloadExpediente(pdfPath) {
            const link = document.createElement('a');

            // Ajustar la ruta para que apunte a 'public/storage/resoluciones'
            const publicPath = pdfPath.replace('storage/', 'storage/'); // Ajusta según el almacenamiento en Laravel
            link.href = `/storage/${publicPath}`;  // Asegurarse que la ruta es accesible públicamente
            link.download = publicPath.split('/').pop(); // Nombre del archivo
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Cerrar el modal con la tecla "Esc"
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        function closeFileModal() {
            document.getElementById('fileModal').classList.add('hidden');
        }

        function confirmCloseCase(denunciaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción cerrará el caso.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar caso!'
            }).then((result) => {
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

                    fetch(`/denuncias/${denunciaId}/cerrar`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Cerrado!', 'El caso ha sido cerrado.', 'success');
                                closeModal();

                                // Cambiar el botón "Cerrar Caso" a "Ver Expediente"
                                const closeButton = document.querySelector(`#denuncia-${denunciaId} td:last-child button`);
                                closeButton.textContent = 'Ver Expediente';
                                closeButton.onclick = () => openFileModal(data.pdfPath);

                                // Actualizar el badge del estado
                                const statusBadge = document.getElementById(`status-badge-${denunciaId}`);
                                statusBadge.textContent = 'Resuelta';
                                statusBadge.className = 'px-2 py-1 rounded-full text-sm font-semibold bg-green-500 text-white';
                            } else {
                                Swal.fire('Error!', 'Hubo un problema al cerrar el caso.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error!', 'Hubo un problema al cerrar el caso.', 'error');
                        });
                }
            });
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
