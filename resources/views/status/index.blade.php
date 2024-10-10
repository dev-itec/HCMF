{{debugbar()->info(get_defined_vars());}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Denuncia</title>
    <link rel="shortcut icon" href="https://home.hcmfront.com/hubfs/favicon@3x.png">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">
<nav class="bg-white shadow-md p-6 flex justify-between items-center">
    <div>
        <img src="https://home.hcmfront.com/hs-fs/hubfs/logo_hcm.png?width=320&height=80&name=logo_hcm.png" alt="Logo" class="h-12">
    </div>
</nav>
<div class="text-4xl">
    <p class="text-gray-700 mt-8 text-center font-bold">Canal de Denuncias</p>
</div>

<section class="dark:text-gray-800">
    <div class="container max-w-5xl px-4 py-12 mx-auto">
        <div class="grid gap-4 mx-4 sm:grid-cols-12">
            <div class="col-span-12 sm:col-span-3">
                <div class="text-center sm:text-left mb-14 before:block before:w-24 before:h-3 before:mb-5 before:rounded-md before:mx-auto sm:before:mx-0 before:dark:bg-sky-600">
                    <h5 class="text-1xl font-semibold">Denunciante:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">{{ $denuncia->nombre_completo }}</span>
                    <h5 class="text-1xl font-semibold">Tipo de denuncia:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">{{ implode(', ', $denuncia->tipo_denuncia) }}</span>
                    <h5 class="text-1xl font-semibold">Denunciado:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">{{ $denuncia->personas_involucradas }}</span>
                    <h5 class="text-1xl font-semibold">Fecha denuncia:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">{{ $denuncia->created_at }}</span>

                    <h5 class="text-1xl font-semibold mt-3">Estado Actual:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">{{ ucfirst($denuncia->status) }}</span>
                    <h5 class="text-1xl font-semibold">Responsable:</h5>
                    <span class="text-sm font-bold tracking-wider uppercase dark:text-gray-600">{{ $denuncia->responsable }}</span>
                </div>
            </div>

            <div class="relative col-span-12 px-4 space-y-6 sm:col-span-9">
                <!-- Aquí mostramos el historial de cambios de estado -->
                <!-- Primer estado: Recibido -->
                <div class="col-span-12 space-y-12 relative px-4 sm:col-span-8 sm:space-y-8 sm:before:absolute sm:before:top-2 sm:before:bottom-0 sm:before:w-0.5 sm:before:-left-3 before:dark:bg-gray-300">
                    <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-sky-500">
                        <h3 class="text-xl font-semibold tracking-wide">Recibido</h3>
                        <time class="text-xs tracking-wide uppercase dark:text-gray-600">{{ $denuncia->created_at }}</time>
                        <p class="text-sm">Denuncia recibida</p>
                    </div>
                    @foreach($statusHistory as $status)
                        <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-sky-500">
                            <h3 class="text-xl font-semibold tracking-wide">{{ ucfirst($status->new_status) }}</h3>
                            <time class="text-xs tracking-wide uppercase dark:text-gray-600">{{ $status->created_at }}</time>
                            <p class="text-sm">Cambiado por: {{ $status->changed_by ? App\Models\User::find($status->changed_by)->name : 'Sistema' }}</p>
                        </div>
                    @endforeach
                        @if($denuncia->status === 'informacion solicitada')
                            <form action="{{ route('denuncia.evidencia', $denuncia->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="evidencia" class="block text-sm font-medium text-gray-700">Subir Evidencia</label>
                                    <input type="file" name="evidencia[]" id="evidencia" multiple class="mt-2 block w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                </div>
                                <button type="submit" class="bg-sky-500 text-white px-4 py-2 rounded">
                                    Subir Archivos
                                </button>
                            </form>
                        @endif
                </div>
                @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Carga exitosa',
                            text: '{{ session('success') }}',
                        });

                        // Inhabilitar el input de subida de archivos
                        document.getElementById('evidencia').disabled = true;
                    </script>
                @endif
            </div>
        </div>

        <div class="text-right mt-6">
            <a href="{{ url('/') }}" class="inline-block bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl text-white font-semibold py-3 px-6 rounded-lg">Volver al inicio</a>
        </div>
    </div>
</section>
</body>
</html>
