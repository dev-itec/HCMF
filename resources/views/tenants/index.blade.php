<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-users-between-lines"></i>{{ __('Clientes') }}
            <x-btn-link class="ml-4 float-right" href="{{ route('tenants.create') }}">Añadir</x-btn-link>
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
                                    Cliente
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Subdominio
                                </th>
                                {{--<th scope="col" class="px-6 py-3">
                                    Contraseña
                                </th>--}}
                                <th scope="col" class="px-6 py-3">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tenants as $tenant)
                                <tr>
                                    <td>{{ $tenant->name }}</td>
                                    <td>{{ $tenant->email }}</td>
                                    <td>{{ $tenant->domains->first()->domain ?? '' }}</td>
                                    {{--<td>{{ $tenant->password ?? 'No disponible' }}</td> <!-- Campo para la contraseña -->--}}
                                    <td>
                                        <!-- Botón de Editar -->
                                        <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Botón de Eliminar -->
                                        <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
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
</x-app-layout>
