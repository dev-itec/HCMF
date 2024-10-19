<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-users-between-lines"></i> {{ __('Comité') }}
            <x-btn-link class="ml-4 float-right bg-sky-500 hover:bg-sky-900" href="{{ route('users.create') }}">Añadir</x-btn-link>
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
                                    <th scope="col" class="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Correo Electrónico
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Rol
                                    </th>
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap
                                        Apple MacBook Pro 17">{{$user->name}}
                                            </th>
                                        <td class="px-6 py-4">
                                            {{$user->email}}
                                        </td>
                                        <td class="px-6 py-4">
                                            @foreach ($user->roles as $role)
                                                {{$role->name}}{{$loop->last ? "" : ","}}
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">
                                            <!-- Botón Editar -->
                                            <x-btn-link class="bg-sky-500 hover:bg-sky-900" href="{{route('users.edit', $user->id)}}">
                                                <i class="fa-solid fa-edit"></i>
                                            </x-btn-link>

                                            <!-- Botón Eliminar -->
                                            <button class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded ml-2 delete-user" data-id="{{$user->id}}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <!-- Botón Recuperar contraseña -->
                                            <button class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded reset-password" data-id="{{ $user->id }}">
                                                <i class="fa-solid fa-envelope"></i>
                                            </button>

                                            <form id="delete-form-{{$user->id}}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
</x-tenant-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Agregar evento click a todos los botones de eliminar
        document.querySelectorAll('.delete-user').forEach(function (button) {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                const deleteForm = document.getElementById(`delete-form-${userId}`);

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        // Escuchar el evento click en los botones de "Enviar enlace de restablecimiento"
        document.querySelectorAll('.reset-password').forEach(function(button) {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');

                // Confirmar con SweetAlert2 antes de enviar el enlace
                Swal.fire({
                    title: '¿Enviar enlace de restablecimiento?',
                    text: "Se enviará un enlace de recuperación de contraseña al correo del usuario.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/users/${userId}/password/reset`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Enlace Enviado!',
                                        'Se ha enviado un enlace de restablecimiento de contraseña al correo del usuario.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'No se pudo enviar el enlace. Por favor, inténtalo de nuevo más tarde.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Hubo un problema al enviar el enlace.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    });
</script>

