<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="hidden md:flex md:w-64 md:flex-col">
        <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white">
            <div class="flex items-center flex-shrink-0 px-4">
                <a href="dashboard">
                    <img class="w-auto h-8" src="https://home.hcmfront.com/hs-fs/hubfs/logo_hcm.png?width=320&height=80&name=logo_hcm.png" alt=""/>
                </a>
            </div>

            <div class="px-4 mt-6">
                <hr class="border-gray-200" />
            </div>

            <div class="flex flex-col flex-1 px-3 mt-6">
                <div class="space-y-4">
                    <nav class="flex-1 space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group
                               {{ request()->routeIs('dashboard') ? 'bg-sky-500 text-white' : 'text-gray-900 hover:text-white hover:bg-sky-500' }}">
                            <i class="fa-solid fa-display mr-3"></i> Panel
                        </a>
                    </nav>
                    <nav class="flex-1 space-y-2">
                        <a href="{{ route('denuncias.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group
                           {{ request()->routeIs('denuncias.index') ? 'bg-sky-500 text-white' : 'text-gray-900 hover:text-white hover:bg-sky-500' }}">
                            <i class="fa-solid fa-triangle-exclamation mr-3"></i> Denuncias
                        </a>

                        <a href="{{ route('reportes.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group
                           {{ request()->routeIs('reportes.index') ? 'bg-sky-500 text-white' : 'text-gray-900 hover:text-white hover:bg-sky-500' }}">
                            <i class="fa-regular fa-chart-bar mr-3"></i> Informes y Reportes
                        </a>
                    </nav>

                    <hr class="border-gray-200" />

                    <nav class="flex-1 space-y-2">
                        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group
                           {{ request()->routeIs('users.index') ? 'bg-sky-500 text-white' : 'text-gray-900 hover:text-white hover:bg-sky-500' }}">
                            <i class="fa-solid fa-display mr-3"></i> Comité
                        </a>

                        {{--<a href="{{ route('questions.create') }}" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group--}}
                        <a href="#" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group
                           {{ request()->routeIs('questions.create') ? 'bg-sky-500 text-white' : 'text-gray-900 hover:text-white hover:bg-sky-500' }}">
                            <i class="fa-solid fa-list-check mr-3"></i> Formulario
                        </a>
                    </nav>

                    <hr class="border-gray-200" />

                    <nav class="flex-1 space-y-2">
                        <a href="{{ route('opciones.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group
                           {{ request()->routeIs('opciones.index') ? 'bg-sky-500 text-white' : 'text-gray-900 hover:text-white hover:bg-sky-500' }}">
                            <i class="fa-solid fa-gear mr-3"></i> Opciones
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</nav>
