<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Configuración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('app.opciones.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" required />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="value" :value="__('Valor')" />
                            <x-text-input id="value" class="block mt-1 w-full" type="text" name="value" />
                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Crear') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
