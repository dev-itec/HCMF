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
                                <th scope="col" class="px-6 py-3">Estado</th>
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
                                                'en proceso' => 'bg-yellow-300 text-black',
                                                'informacion solicitada' => 'bg-sky-300 text-white inline',
                                                'resuelta' => 'bg-green-500 text-white',
                                                default => 'bg-gray-500 text-white',
                                            };
                                        @endphp
                                        <span id="status-badge-{{ $denuncia->id }}" class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }} whitespace-nowrap">
                                            {{ ucfirst($denuncia->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 bg-ye">
                                        <x-btn-link
                                            class="bg-sky-500"
                                            href="javascript:void(0);"
                                            onclick="openModal({
                                                id: '{{ $denuncia->id }}',
                                                nombre_completo: '{{ $denuncia->nombre_completo }}',
                                                rut: '{{ $denuncia->rut }}',
                                                genero: '{{ $denuncia->genero }}',
                                                tipo_denuncia: {{ json_encode($denuncia->tipo_denuncia) }},
                                                personas_involucradas: '{{ $denuncia->personas_involucradas }}',
                                                created_at: '{{ $denuncia->created_at }}',
                                                responsable: '{{ $denuncia->responsable }}',
                                                status: '{{ $denuncia->status }}',
                                                evidencia: '{{ $denuncia->evidencia }}',
                                                cargo: '{{ $denuncia->cargo }}',
                                                relacion: '{{ $denuncia->relacion }}',
                                                correo_electronico: '{{ $denuncia->correo_electronico }}',
                                                detalles_incidente: '{{ $denuncia->detalles_incidente }}',
                                                fecha_exacta: '{{ $denuncia->fecha_exacta }}',
                                                fecha_aproximada: '{{ $denuncia->fecha_aproximada }}',
                                                hora_incidente: '{{ $denuncia->hora_incidente }}',
                                                lugar_incidente: '{{ $denuncia->lugar_incidente }}',
                                                descripcion_caso: '{{ $denuncia->descripcion_caso }}',
                                                testigos: '{{ $denuncia->testigos }}',
                                                como_se_entero: '{{ $denuncia->como_se_entero }}',
                                                impacto_empresa: {{ json_encode($denuncia->impacto_empresa)}},
                                                impacto_personal: {{ json_encode($denuncia->impacto_personal)}},
                                                accion_esperada: {{ json_encode($denuncia->accion_esperada)}}
                                            })"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </x-btn-link>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $answers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="relative bg-white rounded-lg p-6 w-11/12 max-w-5xl h-[80vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-xl font-semibold">
                    Detalles de la Denuncia
                </h3>
                <button onclick="closeModal()" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="modalContent" class="grid grid-cols-2 gap-4 mb-6"> <!-- Estilo de 2 columnas -->
                <!-- Aquí se llenará la información con formato de formulario -->
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end items-center space-x-4">
                <button onclick="updateStatus()" class="bg-sky-500 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-save mr-2"></i> Guardar Estado
                </button>
                <!-- Botón de cerrar -->
                <button onclick="closeModal()" class="bg-sky-900 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-times mr-2"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

<script>
    function openModal(denuncia) {
        let evidenciaContent = '';

        // Decodificar la evidencia si existe
        if (denuncia.evidencia && denuncia.evidencia.length > 0) {
            let archivosAdjuntos = JSON.parse(denuncia.evidencia);

            evidenciaContent = '<h5 class="text-1xl font-semibold">Archivos Adjuntos:</h5><ul class="list-disc pl-5">';
            archivosAdjuntos.forEach((file, index) => {
                const fileUrl = `${file.replace(/\\/g, '')}`;

                // Generar las rutas únicas para cada archivo
                const routeUrl = `{{ route('file.view', ['filename' => ':filename']) }}`.replace(':filename', fileUrl);
                const routeDownloadPdf = `{{ route('file.download', ['filename' => ':filename']) }}`.replace(':filename', fileUrl);

                evidenciaContent += `
            <li class="flex items-center space-x-4">
                <a href="${routeUrl}" target="_blank" class="bg-sky-500 text-white px-3 py-2 rounded flex items-center">
                    <i class="fas fa-eye mr-2"></i> Ver Archivo ${index + 1}
                </a>

                <button onclick="downloadFile('${routeDownloadPdf}')" class="bg-sky-900 text-white px-3 py-2 rounded flex items-center">
                    <i class="fas fa-download mr-2"></i> Descargar
                </button>
            </li><br>`;
            });
            evidenciaContent += '</ul>';
        } else {
            evidenciaContent = '<h5 class="text-1xl font-semibold">Archivos Adjuntos:</h5><p class="text-sm text-gray-600">No hay archivos adjuntos</p>';
        }

        const content = `
    <div>
        <h6 class="text-sm font-semibold">Denunciante:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.nombre_completo}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">R.U.T:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.rut}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Género:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.genero}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">Cargo:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.cargo}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Correo electrónico:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.correo_electronico}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">Relación con la empresa:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.relacion}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Tipo de Denuncia:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.tipo_denuncia}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Fecha Aproximada:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.fecha_aproximada}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Hora del Incidente:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.hora_incidente}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">Lugar del Incidente:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.lugar_incidente}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Descripción del Caso o Denuncia:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.descripcion_caso}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">Persona(s) Involucrada(s):</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.personas_involucradas}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Testigos:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.testigos}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">¿Cómo se dio cuenta de esta situación?:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.como_se_entero}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Impacto en la Empresa:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.impacto_empresa}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">Impacto Personal:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.impacto_personal}</span>
    </div>

    <div>
        <h6 class="text-sm font-semibold">Acción Esperada:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.accion_esperada}</span>
    </div>
    <div>
        <h6 class="text-sm font-semibold">Fecha de Denuncia:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.created_at}</span>
    </div>
    <div class="col-span-2">
        ${evidenciaContent}
    </div>

    <div>
        <h6 class="text-sm font-semibold mt-3">Estado Actual:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.status}</span>
    </div>
    ${denuncia.status !== 'resuelta' ? `
    <div>
        <h6 class="text-sm font-semibold mt-3">Cambiar Estado:</h6>
        <select id="denunciaStatus" data-denuncia-id="${denuncia.id}" class="w-full p-2 mt-2 border border-gray-300 rounded">
            <option value="pendiente" ${denuncia.status === 'pendiente' ? 'selected' : ''}>Pendiente</option>
            <option value="en proceso" ${denuncia.status === 'en proceso' ? 'selected' : ''}>En Proceso</option>
            <option value="informacion solicitada" ${denuncia.status === 'informacion solicitada' ? 'selected' : ''}>Información Solicitada</option>
            <option value="resuelta" ${denuncia.status === 'resuelta' ? 'selected' : ''}>Resuelta</option>
        </select>
    </div>
    ` : ''}
    <div class="col-span-2">
        <h6 class="text-sm font-semibold mt-3">Responsable:</h6>
        <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">${denuncia.responsable || ''}</span>
    </div>
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
            return;
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
                const statusBadge = document.getElementById(`status-badge-${denunciaId}`);
                statusBadge.innerText = status.charAt(0).toUpperCase() + status.slice(1);
                statusBadge.classList.remove('bg-red-500', 'bg-yellow-300', 'bg-sky-300', 'bg-green-500', 'bg-gray-500', 'text-white', 'text-black');
                const newClasses = getStatusClasses(status);
                statusBadge.classList.add(...newClasses);
                closeModal();
            } else {
                alert('Hubo un error al actualizar el estado');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al actualizar el estado');
        });
    }

    function getStatusClasses(status) {
        switch (status) {
            case 'pendiente':
                return ['bg-red-500', 'text-white'];
            case 'en proceso':
                return ['bg-yellow-500', 'text-black'];
            case 'informacion solicitada':
                return ['bg-orange-500', 'text-white'];
            case 'resuelta':
                return ['bg-green-500', 'text-white'];
            default:
                return ['bg-gray-500', 'text-white'];
        }
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Cerrar con Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>
