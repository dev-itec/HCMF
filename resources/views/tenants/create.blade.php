<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Añadir Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tenants.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                          :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Domain -->
                        <div class="mt-4">
                            <x-input-label for="domain_name" :value="__('Subdominio')" />
                            <x-text-input id="domain_name" class="block mt-1 w-full" type="text" name="domain_name"
                                          :value="old('domain_name')" required autofocus autocomplete="domain_name" />
                            <x-input-error :messages="$errors->get('domain_name')" class="mt-2" />
                        </div>

                        <!-- API Key -->
                        <div class="mt-4">
                            <x-input-label for="api_key" :value="__('API Key')" />
                            <x-text-input id="api_key" class="block mt-1 w-full" type="text" name="api_key"
                                          :value="old('api_key')" required autocomplete="off" />
                            <x-input-error :messages="$errors->get('api_key')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Contraseña')" />

                            <div class="relative">
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.294 5 12 5c4.706 0 8.268 2.943 9.542 7-.274.76-.676 1.462-1.183 2.06m-2.466 1.416C16.145 16.87 14.17 18 12 18c-2.294 0-4.316-1.195-5.893-2.903M6.342 9.658a9.978 9.978 0 00-1.733 2.342"/>
                                    </svg>
                                </button>
                            </div>

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>


                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                          name="password_confirmation" required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Crear') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Alterna el icono entre ojo abierto y cerrado si lo deseas
        this.querySelector('svg').classList.toggle('hidden');
    });
</script>

