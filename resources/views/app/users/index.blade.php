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
                                            <x-btn-link class="bg-sky-500 hover:bg-sky-900" href="{{route('users.edit', $user->id)}}">Editar</x-btn-link>
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
