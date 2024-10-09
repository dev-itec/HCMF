<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-font"></i> {{ __('Textos para secciones') }}
            {{-- <x-btn-link class="ml-4 float-right" href="{{ route('app.opciones.create') }}">Añadir</x-btn-link> --}}
        </h2>
    </x-slot>

    <div class="py-2">
        @if ($message)
            <div id="alert-message" class="max-w-7xl mx-auto px-8 transition-opacity duration-500 pointer-events-none">
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                    role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">{{ $message }}</p>
                            <p class="text-sm">Puede seguir editando lo que necesite</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($dynamicTexts as $dynamicText)
                <div class="my-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col justify-left align-center">
                            <form action="{{ route('app.opciones.save-text') }}" method="POST">
                                @csrf
                                <label for="texto" class="block mb-4 text-xm font-medium text-gray-900">
                                    @switch($dynamicText->seccion)
                                        @case('home-section')
                                            Texto en home
                                        @break

                                        @case('end-complaint-section')
                                            Al finalizar la denuncia
                                        @break

                                        @case('email-body')
                                            Texto en cuerpo de los correos
                                        @break

                                        @default
                                            Section name
                                    @endswitch
                                </label>
                                <textarea id="texto" rows="4" name="texto"
                                    class="h-[250px] resize-none overflow-auto block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ $dynamicText->texto }}</textarea>

                                <input type="hidden" name="seccion" value="home-section">

                                <div class="mt-2 w-full flex justify-end items-center">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                alertMessage.classList.add('opacity-0');
                alertMessage.classList.add('transition-opacity', 'duration-500'); 
                alertMessage.classList.add('pointer-events-none'); 
                alertMessage.classList.add('hidden');
            }
        }, 3000);
    </script>
</x-tenant-app-layout>
