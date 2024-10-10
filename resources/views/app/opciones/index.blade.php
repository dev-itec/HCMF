<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-cog"></i> {{ __('Opciones') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <section class="container mx-auto px-8 my-16 sm:px-12">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                <div
                    class="flex cursor-pointer flex-col items-center justify-start rounded-lg bg-slate-50 py-5 px-6 text-center text-slate-800 shadow-slate-200 transition hover:bg-white hover:shadow-lg hover:shadow-slate-200 open-modal"
                >
                    <i class="fa-solid fa-satellite-dish fa-2xl mt-3 mb-3 text-sky-500"></i>
                    <div class="mt-3 text-sm font-semibold text-sky-500">Conexion API</div>
                </div>
                <div
                    class="flex cursor-pointer flex-col items-center justify-start rounded-lg bg-slate-50 py-5 px-6 text-center text-slate-800 shadow-slate-200 transition hover:bg-white hover:shadow-lg hover:shadow-slate-200 open-modal"
                >
                    <i class="fa-solid fa-file-arrow-up fa-2xl mt-3 mb-3 text-sky-500"></i>
                    <div class="mt-3 text-sm font-semibold text-sky-500">Subida masiva</div>
                </div>
                <div
                    class="flex cursor-pointer flex-col items-center justify-start rounded-lg bg-slate-50 py-5 px-6 text-center text-slate-800 shadow-slate-200 transition hover:bg-white hover:shadow-lg hover:shadow-slate-200 open-modal"
                >
                    <i class="fa-solid fa-bell-concierge fa-2xl mt-3 mb-3 text-sky-500"></i>
                    <div class="mt-3 text-sm font-semibold text-sky-500">Notificaciones</div>
                </div>
            </div>
        </section>
        <section class="container mx-auto px-8 my-16 sm:px-12">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                <div
                    class="flex cursor-pointer flex-col items-center justify-start rounded-lg bg-slate-50 py-5 px-6 text-center text-slate-800 shadow-slate-200 transition hover:bg-white hover:shadow-lg hover:shadow-slate-200 open-modal"
                >
                    <i class="fa-solid fa-highlighter fa-2xl mt-3 mb-3 text-sky-500"></i>
                    <div class="mt-3 text-sm font-semibold text-sky-500">Apariencia</div>
                </div>
                <div
                    class="flex cursor-pointer flex-col items-center justify-start rounded-lg bg-slate-50 py-5 px-6 text-center text-slate-800 shadow-slate-200 transition hover:bg-white hover:shadow-lg hover:shadow-slate-200 open-modal"
                >
                    <i class="fa-solid fa-list-check fa-2xl mt-3 mb-3 text-sky-500"></i>
                    <div class="mt-3 text-sm font-semibold text-sky-500">Formulario</div>
                </div>
                <a
                    href="{{ url('/opciones/vars') }}"
                    class="flex cursor-pointer flex-col items-center justify-start rounded-lg bg-slate-50 py-5 px-6 text-center text-slate-800 shadow-slate-200 transition hover:bg-white hover:shadow-lg hover:shadow-slate-200"
                >
                    <i class="fa-solid fa-sliders fa-2xl mt-3 mb-3 text-sky-500"></i>
                    <div class="mt-3 text-sm font-semibold text-sky-500">Variables</div>
                </a>
            </div>
        </section>
        <section class="container mx-auto px-8 my-16 sm:px-12">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                <a
                    href="{{ url('/opciones/dynamic-text') }}"
                    class="flex cursor-pointer flex-col items-center justify-start rounded-lg bg-slate-50 py-5 px-6 text-center text-slate-800 shadow-slate-200 transition hover:bg-white hover:shadow-lg hover:shadow-slate-200"
                >
                    <i class="fa-solid fa-font fa-2xl mt-3 mb-3"></i>
                    <div class="mt-3 text-sm font-semibold">Textos</div>
                </a>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div id="modalOpciones" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-500 bg-opacity-75">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h3 class="text-lg font-semibold">Opciones</h3>
            <p class="mt-2 text-sm text-gray-600">Contenido del modal aquí.</p>
            <button id="closeModal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Cerrar</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openModalButtons = document.querySelectorAll('.open-modal');
            const modal = document.getElementById('myModal');
            const closeModalButton = document.getElementById('closeModal');

            openModalButtons.forEach(button => {
                button.addEventListener('click', function () {
                    modal.classList.remove('hidden');
                });
            });

            closeModalButton.addEventListener('click', function () {
                modal.classList.add('hidden');
            });

            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</x-tenant-app-layout>
