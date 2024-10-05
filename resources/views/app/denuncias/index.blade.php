{{-- resources/views/app/denuncias/index.blade.php --}}
<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-gavel"></i> {{ __('Denuncias') }}
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
                                    <td class="px-6 py-4">{{ Auth::user()->email }}</td>
                                    <td class="px-6 py-4 text-xs">
                                        @php
                                            $statusColor = match($denuncia->status) {
                                                'pendiente' => 'bg-red-500 text-white',
                                                'en proceso' => 'bg-yellow-500 text-black',
                                                'informacion solicitada' => 'bg-orange-500 text-white inline',
                                                'resuelta' => 'bg-green-500 text-white',
                                                default => 'bg-gray-500 text-white',
                                            };
                                        @endphp
                                        <span id="status-badge-{{ $denuncia->id }}" class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                            {{ ucfirst($denuncia->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <x-btn-link 
                                            class="bg-sky-500" 
                                            href="javascript:void(0);" 
                                            onclick="openModal({
                                                id: '{{ $denuncia->id }}',
                                                nombre_completo: '{{ $denuncia->nombre_completo }}',
                                                tipo_denuncia: {{ json_encode($denuncia->tipo_denuncia) }},
                                                personas_involucradas: '{{ $denuncia->personas_involucradas }}',
                                                created_at: '{{ $denuncia->created_at }}',
                                                responsable: '{{ Auth::user()->email }}',
                                                status: '{{ $denuncia->status }}',
                                                evidencia: '{{ $denuncia->evidencia }}'
                                            })"
                                        >
                                            Detalle
                                        </x-btn-link>
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
            <button onclick="updateStatus()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Guardar Estado</button>
            <button onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cerrar</button>
        </div>
    </div>
</x-tenant-app-layout>

<script>
    function openModal(denuncia) {
        let evidenciaContent = '';

        // Decodificar la evidencia si existe
        if (denuncia.evidencia && denuncia.evidencia.length > 0) {
            // Dado que en la BD está almacenado como un string JSON, necesitamos parsearlo
            let archivosAdjuntos = JSON.parse(denuncia.evidencia); // Decodifica el array de evidencia

            evidenciaContent = '<h5 class="text-1xl font-semibold">Archivos Adjuntos:</h5><ul class="list-disc pl-5">';
            archivosAdjuntos.forEach((file, index) => {

                // Generar la URL del archivo
                const fileUrl = `${file.replace(/\\/g, '')}`; // Quitar barras invertidas y crear la URL
                const routeUrl = `{{ route('pdf.view', ['filename' => 'FILENAME_PLACEHOLDER']) }}`.replace('FILENAME_PLACEHOLDER', fileUrl);
                const routeDownloadPdf =  `{{ route('pdf.download', ['filename' => 'FILENAME_PLACEHOLDER']) }}`.replace('FILENAME_PLACEHOLDER', fileUrl);

                evidenciaContent += `
                <li>
                    <a href="${routeUrl}" target="_blank" class="text-blue-500 underline font-bold no-underline">Archivo ${index + 1}</a>
                    <button onclick="window.location.href='${routeDownloadPdf}'" class="bg-green-500 text-white px-2 py-1 rounded ml-4">Descargar</button>
                </li>`;
            });
            evidenciaContent += '</ul>';
        } else {
            evidenciaContent = '<h5 class="text-1xl font-semibold">Archivos Adjuntos:</h5><p class="text-sm text-gray-600">No hay archivos adjuntos</p>';
        }

        const content = `
        <h5 class="text-1xl font-semibold">Denunciante:</h5>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.nombre_completo}</span>
        <h5 class="text-1xl font-semibold">Tipo de denuncia:</h5>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.tipo_denuncia.join(', ')}</span>
        <h5 class="text-1xl font-semibold">Denunciado:</h5>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.personas_involucradas}</span>
        <h5 class="text-1xl font-semibold">Fecha denuncia:</h5>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.created_at}</span>
        ${evidenciaContent}
        <h5 class="text-1xl font-semibold mt-3">Estado Actual:</h5>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.status}</span>
        <h5 class="text-1xl font-semibold mt-3">Cambiar Estado:</h5>
        <select id="denunciaStatus" data-denuncia-id="${denuncia.id}" class="w-full p-2 mt-2 border border-gray-300 rounded">
            <option value="pendiente" ${denuncia.status === 'pendiente' ? 'selected' : ''}>Pendiente</option>
            <option value="en proceso" ${denuncia.status === 'en proceso' ? 'selected' : ''}>En Proceso</option>
            <option value="informacion solicitada" ${denuncia.status === 'informacion solicitada' ? 'selected' : ''}>Información Solicitada</option>
            <option value="resuelta" ${denuncia.status === 'resuelta' ? 'selected' : ''}>Resuelta</option>
        </select>
        <h5 class="text-1xl font-semibold mt-3">Responsable:</h5>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.responsable || ''}</span>
    `;

        document.getElementById('modalContent').innerHTML = content;
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function downloadFile(fileUrl) {
        const link = document.createElement('a');
        link.href = fileUrl;
        link.setAttribute('download', ''); // Esto puede ser el nombre del archivo si deseas
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function updateStatus() {
        const status = document.getElementById('denunciaStatus').value;
        const denunciaId = document.getElementById('denunciaStatus').getAttribute('data-denuncia-id');

        if (!denunciaId) {
            console.error('El ID de la denuncia es nulo o indefinido.');
            alert('Error: El ID de la denuncia no está disponible.');
            return; // Salir de la función si no hay ID
        }

        fetch(`/denuncias/${denunciaId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status })
        }).then(response => {
            return response.json();
        }).then(data => {
            if (data.success) {
                // Actualizar el texto del badge
                const statusBadge = document.getElementById(`status-badge-${denunciaId}`);
                statusBadge.innerText = status.charAt(0).toUpperCase() + status.slice(1);

                // Eliminar las clases de color existentes
                statusBadge.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-orange-500', 'bg-green-500', 'bg-gray-500', 'text-white', 'text-black');

                // Asignar las nuevas clases de color
                const newClasses = getStatusClasses(status);
                statusBadge.classList.add(...newClasses); // Agregar las nuevas clases

                closeModal(); // Cerrar el modal si se desea
            } else {
                alert('Hubo un error al actualizar el estado');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al actualizar el estado');
        });
    }

    // Función para obtener las clases de estado (colores)
    function getStatusClasses(status) {
        switch (status) {
            case 'pendiente':
                return ['bg-red-500', 'text-white']; // Color para pendiente
            case 'en proceso':
                return ['bg-yellow-500', 'text-black']; // Color para en proceso
            case 'informacion solicitada':
                return ['bg-orange-500', 'text-white']; // Color para información solicitada
            case 'resuelta':
                return ['bg-green-500', 'text-white']; // Color para resuelta
            default:
                return ['bg-gray-500', 'text-white']; // Color por defecto
        }
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
